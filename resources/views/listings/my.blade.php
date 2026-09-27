@extends('layouts.app')
@section('title', 'My Ads | Marketplace Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-extrabold text-dark mb-1" style="font-weight: 800;">MY ADS DASHBOARD</h3>
        <p class="text-muted small mb-0">Manage, edit, or remove your published listings</p>
    </div>
    <a href="{{ route('listings.create') }}" class="btn-mp-sell text-decoration-none">
        <i class="fa-solid fa-plus"></i> POST NEW AD
    </a>
</div>

<div class="row g-3">
    @forelse($listings as $listing)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="mp-card">
                <div class="mp-card-img-wrap">
                    @if($listing->image)
                        <img src="{{ str_starts_with($listing->image, 'http') ? $listing->image : asset('storage/'.$listing->image) }}" alt="{{ $listing->name }}">
                    @else
                        <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-light text-muted">
                            <i class="fa-solid fa-image fs-1 opacity-50 mb-1"></i>
                            <small>No Photo</small>
                        </div>
                    @endif
                    <span class="badge bg-success position-absolute top-0 start-0 m-2"><i class="fa-solid fa-circle-check me-1"></i> Active</span>
                </div>

                <div class="mp-card-body">
                    <div class="mp-card-price">₹{{ number_format($listing->price) }}</div>
                    <h6 class="mp-card-title">{{ $listing->name }}</h6>
                    <div class="small text-muted mb-3"><i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $listing->city }} • {{ $listing->created_at->format('d M Y') }}</div>

                    <div class="d-flex gap-2 mt-auto">
                        <a href="{{ route('listings.show', $listing) }}" class="btn btn-outline-dark btn-sm flex-grow-1 fw-bold">View</a>
                        <a href="{{ route('listings.edit', $listing) }}" class="btn btn-outline-warning btn-sm flex-grow-1 fw-bold text-dark">Edit</a>
                        <form method="POST" action="{{ route('listings.destroy', $listing) }}" onsubmit="return confirm('Delete this ad permanently?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm px-3" title="Delete"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 py-5 text-center bg-white rounded-3 shadow-sm">
            <i class="fa-solid fa-boxes-packing fs-1 text-muted opacity-50 mb-3"></i>
            <h5 class="fw-bold text-dark">You haven't posted any ads yet</h5>
            <p class="text-muted small mb-3">Got something to sell? Post your ad now and reach buyers in your city!</p>
            <a href="{{ route('listings.create') }}" class="btn btn-warning fw-bold px-4 py-2 text-dark">
                <i class="fa-solid fa-plus me-1"></i> Post Your First Ad
            </a>
        </div>
    @endforelse
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $listings->links() }}
</div>
@endsection
