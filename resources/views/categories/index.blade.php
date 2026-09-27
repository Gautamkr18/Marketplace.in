@extends('layouts.app')
@section('title', 'All Categories | Marketplace')

@section('content')
<div class="text-center mb-5">
    <h2 class="fw-extrabold text-dark" style="font-weight: 800;">EXPLORE ALL CATEGORIES</h2>
    <p class="text-muted">Find exactly what you are looking for across all categories</p>
</div>

<div class="row g-4">
    @foreach($categories as $cat)
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
            $icon = $iconMap[$cat->name] ?? 'fa-tags text-teal';
        @endphp
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white hover-elevate transition-all">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="fs-1 p-3 bg-light rounded-3 d-flex align-items-center justify-content-center" style="width:64px; height:64px;">
                        <i class="fa-solid {{ $icon }}"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">
                            <a href="{{ route('category.show', $cat->slug) }}" class="text-decoration-none text-dark hover-teal">
                                {{ $cat->name }}
                            </a>
                        </h5>
                        <small class="text-muted fw-bold">{{ $cat->listings_count }} Live Ads</small>
                    </div>
                </div>

                @if($cat->subcategories->count() > 0)
                    <div class="d-flex flex-wrap gap-2 mt-auto pt-3 border-top">
                        @foreach($cat->subcategories as $sub)
                            <a href="{{ route('category.show', $cat->slug) }}?subcategory={{ $sub->slug }}" 
                               class="badge bg-light text-dark border text-decoration-none fw-normal px-2 py-1">
                                {{ $sub->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
