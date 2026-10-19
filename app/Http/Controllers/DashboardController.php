<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\PropertyOffer;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $stats = [
            'total_offers' => PropertyOffer::count(),
            'available_offers' => PropertyOffer::where('status', 'available')->count(),
            'total_portfolio_value' => PropertyOffer::where('status', 'available')->sum('price'),
            'total_leads' => Lead::count(),
            'new_leads' => Lead::where('status', 'new')->count(),
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
        ];

        $recentOffers = PropertyOffer::with('creator')->latest()->take(5)->get();
        $recentLeads = Lead::with('propertyOffer', 'assignee')->latest()->take(5)->get();

        $districtsBreakdown = PropertyOffer::selectRaw('district, count(*) as count')
            ->groupBy('district')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        $leadsByType = [
            'buyer' => Lead::where('type', 'buyer')->count(),
            'owner' => Lead::where('type', 'owner')->count(),
            'inquiry' => Lead::where('type', 'inquiry')->count(),
        ];

        return view('admin.dashboard', compact(
            'stats',
            'recentOffers',
            'recentLeads',
            'districtsBreakdown',
            'leadsByType'
        ));
    }
}
