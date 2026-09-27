<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    public function create()
    {
        $categories = Category::with('subcategories')->orderBy('name')->get();

        return view('listings.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:product,service'],
            'name' => ['required', 'string', 'max:255'],
            'detail' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_id' => ['nullable', 'exists:subcategories,id'],
            'country' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'area' => ['nullable', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        $validated['user_id'] = $request->user()->id;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('listings', 'public');
        }

        $listing = Listing::create($validated);

        return redirect()->route('listings.show', $listing)->with('status', 'Your listing has been posted.');
    }

    public function show(Listing $listing)
    {
        $listing->load('user', 'category', 'subcategory');

        return view('listings.show', compact('listing'));
    }

    public function my(Request $request)
    {
        $listings = $request->user()->listings()->latest()->paginate(10);

        return view('listings.my', compact('listings'));
    }

    public function edit(Listing $listing)
    {
        $this->authorizeOwner($listing);

        $categories = Category::with('subcategories')->orderBy('name')->get();

        return view('listings.edit', compact('listing', 'categories'));
    }

    public function update(Request $request, Listing $listing)
    {
        $this->authorizeOwner($listing);

        $validated = $request->validate([
            'type' => ['required', 'in:product,service'],
            'name' => ['required', 'string', 'max:255'],
            'detail' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_id' => ['nullable', 'exists:subcategories,id'],
            'country' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'area' => ['nullable', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            if ($listing->image) {
                Storage::disk('public')->delete($listing->image);
            }
            $validated['image'] = $request->file('image')->store('listings', 'public');
        }

        $listing->update($validated);

        return redirect()->route('listings.show', $listing)->with('status', 'Listing updated.');
    }

    public function destroy(Listing $listing)
    {
        $this->authorizeOwner($listing);

        if ($listing->image) {
            Storage::disk('public')->delete($listing->image);
        }
        $listing->delete();

        return redirect()->route('listings.my')->with('status', 'Listing deleted.');
    }

    private function authorizeOwner(Listing $listing): void
    {
        abort_unless($listing->user_id === auth()->id(), 403);
    }
}
