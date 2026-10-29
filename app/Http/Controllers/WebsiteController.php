<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\PropertyOffer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WebsiteController extends Controller
{
    public function home(): View
    {
        $featuredOffers = PropertyOffer::where('is_featured', true)
            ->where('status', 'available')
            ->latest()
            ->take(6)
            ->get();

        $stats = [
            'properties_listed' => PropertyOffer::count(),
            'happy_clients' => 850,
            'years_experience' => 16,
            'districts_covered' => 24,
        ];

        $districts = ['Al-Shati', 'Al-Rawdah', 'Al-Hamra', 'Obhur Al-Shamaliyah', 'Al-Salama'];

        return view('website.home', compact('featuredOffers', 'stats', 'districts'));
    }

    public function offers(Request $request): View
    {
        $query = PropertyOffer::where('status', 'available');

        if ($request->filled('type') && $request->input('type') !== 'all') {
            $query->where('property_type', $request->input('type'));
        }

        if ($request->filled('purpose') && $request->input('purpose') !== 'all') {
            $query->where('purpose', $request->input('purpose'));
        }

        if ($request->filled('district') && $request->input('district') !== 'all') {
            $query->where('district', $request->input('district'));
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->input('max_price'));
        }

        if ($request->filled('bedrooms') && $request->input('bedrooms') !== 'all') {
            $query->where('bedrooms', '>=', (int) $request->input('bedrooms'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('district', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $sort = $request->input('sort', 'latest');
        if ($sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $offers = $query->paginate(9)->withQueryString();

        $districts = PropertyOffer::select('district')->distinct()->pluck('district');
        $types = ['Villa', 'Apartment', 'Penthouse', 'Commercial', 'Land'];

        return view('website.offers', compact('offers', 'districts', 'types'));
    }

    public function offerShow(string $slug): View
    {
        $offer = PropertyOffer::with('creator')->where('slug', $slug)->firstOrFail();
        $relatedOffers = PropertyOffer::where('id', '!=', $offer->id)
            ->where(function ($q) use ($offer) {
                $q->where('district', $offer->district)
                  ->orWhere('property_type', $offer->property_type);
            })
            ->where('status', 'available')
            ->take(3)
            ->get();

        return view('website.offer-details', compact('offer', 'relatedOffers'));
    }

    public function contact(): View
    {
        $propertyOffers = PropertyOffer::where('status', 'available')->select('id', 'title', 'district', 'price')->get();
        return view('website.contact', compact('propertyOffers'));
    }

    public function storeInquiry(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'type' => ['required', Rule::in(['buyer', 'owner', 'inquiry'])],
            'property_offer_id' => ['nullable', 'exists:property_offers,id'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        Lead::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'type' => $validated['type'],
            'property_offer_id' => $validated['property_offer_id'],
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        return back()->with('inquiry_success', 'Thank you! Your inquiry has been submitted. Our Customer Service team in Jeddah will contact you shortly.');
    }
}
