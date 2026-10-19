<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $query = Lead::with(['propertyOffer', 'assignee']);

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $leads = $query->latest()->paginate(15)->withQueryString();
        $agents = User::where('is_active', true)->get();

        $counts = [
            'total' => Lead::count(),
            'new' => Lead::where('status', 'new')->count(),
            'buyers' => Lead::where('type', 'buyer')->count(),
            'owners' => Lead::where('type', 'owner')->count(),
        ];

        return view('admin.leads.index', compact('leads', 'agents', 'counts'));
    }

    public function updateStatus(Request $request, Lead $lead): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['new', 'contacted', 'in_progress', 'closed', 'cancelled'])],
            'notes' => ['nullable', 'string', 'max:2000'],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ]);

        $lead->update([
            'status' => $validated['status'],
            'notes' => $validated['notes'],
            'assigned_to' => $validated['assigned_to'] ?? $lead->assigned_to,
        ]);

        return back()->with('success', "Lead #{$lead->id} status updated to " . ucfirst(str_replace('_', ' ', $lead->status)));
    }

    public function destroy(Lead $lead): RedirectResponse
    {
        $lead->delete();

        return redirect()->route('admin.leads.index')
            ->with('success', 'Lead record removed.');
    }
}
