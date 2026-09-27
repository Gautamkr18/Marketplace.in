@extends('layouts.app')
@section('title', $heading ?? 'Buy & Sell Electronics, Cars, Properties & Services')

@section('content')

<!-- Hero Banner (Only on main home or city filter) -->
@if(!request()->filled('q') && !isset($category))
<div class="mp-hero-banner shadow-sm">
    <div class="container py-3">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-warning text-dark font-monospace mb-2 px-3 py-1 text-uppercase fw-bold">🔥 Live Marketplace</span>
                <h1 class="display-6 fw-extrabold mb-2" style="font-weight: 800;">Find Anything in {{ $currentCity ?? 'India' }}</h1>
                <p class="lead text-white-50 mb-4" style="font-size: 1.05rem;">
                    Buy & sell verified Cars, Mobiles, Apartments, Laptops, Furniture and local Services near you.
                </p>

            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <i class="fa-solid fa-store fs-1 text-success opacity-75" style="font-size: 8rem !important;"></i>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Quick Category Icons Grid (Show on home page) -->
@if(!request()->filled('q') && !isset($category) && isset($categories))
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-grid-2 me-2 text-success"></i> Browse Categories</h5>
        <a href="{{ route('categories.index') }}" class="text-decoration-none fw-bold small text-teal" style="color: var(--mp-teal);">View All <i class="fa-solid fa-chevron-right ms-1"></i></a>
    </div>
    <div class="row g-3">
        @foreach($categories->take(8) as $cat)
            @php
                $iconMap = [
                    'Cars' => 'fa-car text-primary',
                    'Mobiles' => 'fa-mobile-screen-button text-success',
                    'Electronics & Appliances' => 'fa-laptop text-info',
                    'Furniture' => 'fa-couch text-warning',
                    'Properties' => 'fa-building text-danger',
                    'Jobs' => 'fa-briefcase text-secondary',
                    'Services' => 'fa-screwdriver-wrench text-dark',
                    'Fashion' => 'fa-shirt text-pink',
                    'Pets' => 'fa-dog text-orange',
                    'Books, Sports & Hobbies' => 'fa-guitar text-purple',
                ];
                $icon = $iconMap[$cat->name] ?? 'fa-tag text-teal';
            @endphp
            <div class="col-6 col-md-3 col-lg-2">
                <a href="{{ route('category.show', $cat->slug) }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center p-3 h-100 rounded-3 hover-elevate transition-all" style="background:#fff;">
                        <div class="fs-2 mb-2">
                            <i class="fa-solid {{ $icon }}"></i>
                        </div>
                        <div class="fw-bold text-dark small text-truncate">{{ $cat->name }}</div>
                        <small class="text-muted" style="font-size:0.75rem;">{{ $cat->listings_count ?? 0 }} Ads</small>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endif

<!-- Subcategories Filter Strip if Category is selected -->
@if(isset($category) && $category->subcategories->count() > 0)
<div class="card border-0 shadow-sm mb-4 p-3 rounded-3" style="background: #fff;">
    <div class="d-flex align-items-center gap-2 overflow-x-auto">
        <span class="fw-bold text-dark me-2 small text-uppercase">Subcategories:</span>
        <a href="{{ route('category.show', $category->slug) }}" class="badge rounded-pill {{ !request()->filled('subcategory') ? 'bg-dark' : 'bg-light text-dark border' }} text-decoration-none px-3 py-2">
            All {{ $category->name }}
        </a>
        @foreach($category->subcategories as $sub)
            <a href="{{ route('category.show', $category->slug) }}?subcategory={{ $sub->slug }}{{ request('city') ? '&city='.request('city') : '' }}" 
               class="badge rounded-pill {{ request('subcategory') == $sub->slug ? 'bg-success' : 'bg-light text-dark border' }} text-decoration-none px-3 py-2">
                {{ $sub->name }}
            </a>
        @endforeach
    </div>
</div>
@endif

<!-- Main Listings Section with Sidebar Filter -->
<div id="listingSection" class="row g-4">
    <!-- Sidebar Filters -->
    <div class="col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 p-3 mb-4" style="background:#fff;">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <h6 class="fw-bold text-uppercase mb-0" style="color: var(--mp-navy);"><i class="fa-solid fa-sliders me-2"></i> Filters</h6>
                @if(request()->anyFilled(['q', 'type', 'min_price', 'max_price', 'subcategory', 'sort']))
                    <a href="{{ isset($category) ? route('category.show', $category->slug) : (isset($city) ? route('city.show', $city) : route('home')) }}" class="small text-danger fw-bold text-decoration-none">Clear All</a>
                @endif
            </div>

            <form method="GET" action="{{ url()->current() }}">
                @if(request('city'))
                    <input type="hidden" name="city" value="{{ request('city') }}">
                @endif
                @if(request('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                @endif

                <!-- Category List -->
                <div class="mb-4">
                    <label class="form-label fw-bold small text-uppercase text-muted">Categories</label>
                    <ul class="list-unstyled mb-0 lh-lg" style="max-height: 220px; overflow-y: auto;">
                        <li class="mb-1">
                            <a href="{{ route('home') }}" class="text-decoration-none {{ !isset($category) ? 'fw-bold text-success' : 'text-dark' }} small">
                                <i class="fa-solid fa-angle-right me-1"></i> All Categories
                            </a>
                        </li>
                        @foreach($categories as $cat)
                            <li class="mb-1">
                                <a href="{{ route('category.show', $cat->slug) }}{{ request('city') ? '?city='.request('city') : '' }}" 
                                   class="text-decoration-none d-flex justify-content-between align-items-center {{ isset($category) && $category->id === $cat->id ? 'fw-bold text-success' : 'text-dark' }} small">
                                    <span>{{ $cat->name }}</span>
                                    <span class="badge bg-light text-muted rounded-pill">{{ $cat->listings_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Price Filter -->
                <div class="mb-4">
                    <label class="form-label fw-bold small text-uppercase text-muted">Price Range (₹)</label>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <input type="number" name="min_price" class="form-control form-control-sm" placeholder="Min" value="{{ request('min_price') }}">
                        </div>
                        <div class="col-6">
                            <input type="number" name="max_price" class="form-control form-control-sm" placeholder="Max" value="{{ request('max_price') }}">
                        </div>
                    </div>
                </div>

                <!-- Listing Type -->
                <div class="mb-4">
                    <label class="form-label fw-bold small text-uppercase text-muted">Item Type</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="typeAll" value="" {{ !request('type') ? 'checked' : '' }}>
                        <label class="form-check-label small" for="typeAll">All Types</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="typeProduct" value="product" {{ request('type') == 'product' ? 'checked' : '' }}>
                        <label class="form-check-label small" for="typeProduct">Products</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="typeService" value="service" {{ request('type') == 'service' ? 'checked' : '' }}>
                        <label class="form-check-label small" for="typeService">Services</label>
                    </div>
                </div>

                <!-- Sort By -->
                <div class="mb-4">
                    <label class="form-label fw-bold small text-uppercase text-muted">Sort By</label>
                    <select name="sort" class="form-select form-select-sm">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest First</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-dark w-100 fw-bold btn-sm py-2">
                    <i class="fa-solid fa-filter me-1"></i> Apply Filters
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="col-lg-9">
        <!-- Heading & Count Bar -->
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div>
                <h4 class="fw-extrabold text-dark mb-0" style="font-weight: 800;">{{ $heading }}</h4>
                <small class="text-muted">Showing {{ $listings->total() }} ads found</small>
            </div>
            
            @if(request('city') || request('q'))
                <div class="d-flex gap-2 align-items-center">
                    @if(request('city'))
                        <span class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-sm">
                            📍 {{ request('city') }} 
                            <a href="{{ route('home') }}" class="text-danger ms-2"><i class="fa-solid fa-xmark"></i></a>
                        </span>
                    @endif
                    @if(request('q'))
                        <span class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-sm">
                            🔍 "{{ request('q') }}" 
                            <a href="{{ route('home') }}" class="text-danger ms-2"><i class="fa-solid fa-xmark"></i></a>
                        </span>
                    @endif
                </div>
            @endif
        </div>

        <!-- Listing Cards Grid -->
        <div class="row g-3">
            @forelse($listings as $listing)
                <div class="col-12 col-md-6 col-lg-4">
                    <x-listing-card :listing="$listing" :isFeatured="$loop->index < 3" />
                </div>
            @empty
                <div class="col-12 py-5 text-center bg-white rounded-4 shadow-sm my-3 border p-5">
                    <div class="fs-1 text-teal mb-3" style="color: var(--mp-teal);">
                        <i class="fa-solid fa-store-slash" style="font-size: 3.5rem;"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">No Ads Posted Yet</h4>
                    <p class="text-muted mb-4" style="max-width: 480px; margin: 0 auto;">
                        Be the first seller to post a real listing! Start selling your cars, phones, laptops, apartments, or services to local buyers.
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('listings.create') }}" class="btn btn-warning btn-lg fw-bold px-4 py-2 text-dark shadow-sm">
                            <i class="fa-solid fa-plus-circle me-2"></i> Post First Real Ad
                        </a>
                        @if(request()->anyFilled(['q', 'type', 'min_price', 'max_price', 'subcategory', 'city', 'sort']))
                            <a href="{{ route('home') }}" class="btn btn-outline-dark btn-lg fw-bold px-4 py-2">
                                Clear Filters
                            </a>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $listings->links() }}
        </div>
    </div>
</div>

@endsection
