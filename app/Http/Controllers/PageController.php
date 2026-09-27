<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;

class PageController extends Controller
{
    private function getCommonData()
    {
        $categories = Category::withCount('listings')->orderBy('name')->get();
        $cities = Listing::select('city')->distinct()->whereNotNull('city')->pluck('city')->sort()->values();

        return [$categories, $cities];
    }

    /** Homepage */
    public function home(Request $request)
    {
        [$categories, $cities] = $this->getCommonData();

        $listings = Listing::with('category', 'subcategory', 'user')
            ->filter($request)
            ->paginate(12)
            ->withQueryString();

        return view('listings.index', [
            'listings' => $listings,
            'categories' => $categories,
            'cities' => $cities,
            'heading' => $request->filled('q') ? 'Search results for "'.$request->q.'"' : 'Fresh Recommendations',
            'currentCity' => $request->city ?? null,
        ]);
    }

    /** All categories page */
    public function categories()
    {
        [$categories, $cities] = $this->getCommonData();
        return view('categories.index', compact('categories', 'cities'));
    }

    /** Category-wise page */
    public function byCategory(Request $request, Category $category)
    {
        [$categories, $cities] = $this->getCommonData();

        $listings = $category->listings()
            ->with('category', 'subcategory', 'user')
            ->filter($request)
            ->paginate(12)
            ->withQueryString();

        return view('listings.index', [
            'listings' => $listings,
            'categories' => $categories,
            'cities' => $cities,
            'heading' => $category->name.' Listings',
            'category' => $category,
            'currentCity' => $request->city ?? null,
        ]);
    }

    /** City-wise page */
    public function byCity(Request $request, string $city)
    {
        $request->merge(['city' => $city]);
        return $this->home($request);
    }

    /** City + Category page */
    public function byCityAndCategory(Request $request, string $city, Category $category)
    {
        $request->merge(['city' => $city]);
        return $this->byCategory($request, $category);
    }

    /** AJAX subcategories endpoint */
    public function subcategoriesOf(Category $category)
    {
        return response()->json(
            $category->subcategories()->orderBy('name')->get(['id', 'name'])
        );
    }

    /** AJAX search suggestions */
    public function searchSuggestions(Request $request)
    {
        $q = $request->get('q');
        if (!$q || strlen($q) < 2) {
            return response()->json([]);
        }

        $suggestions = Listing::active()
            ->where('name', 'like', '%'.$q.'%')
            ->select('id', 'name', 'price', 'city', 'image')
            ->take(5)
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->formatted_price,
                'city' => $item->city,
                'url' => route('listings.show', $item->id),
                'image' => $item->image_url,
            ]);

        return response()->json($suggestions);
    }
}
