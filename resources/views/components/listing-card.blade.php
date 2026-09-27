@props(['listing', 'isFeatured' => false])

<div class="mp-card">
    <div class="mp-card-img-wrap">
        @if($listing->image_url)
            <img src="{{ $listing->image_url }}" alt="{{ $listing->name }}" loading="lazy" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-light text-muted\'><i class=\'fa-solid fa-image fs-1 mb-1 opacity-50\'></i><small>No Image</small></div>';">
        @else
            <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-light text-muted">
                <i class="fa-solid fa-image fs-1 mb-1 opacity-50"></i>
                <small>No Image</small>
            </div>
        @endif

        @if($isFeatured)
            <span class="badge-featured"><i class="fa-solid fa-bolt me-1"></i> Featured</span>
        @endif

        <span class="badge-type">{{ ucfirst($listing->type) }}</span>
    </div>

    <div class="mp-card-body">
        <div class="mp-card-price">{{ $listing->formatted_price }}</div>
        <h6 class="mp-card-title">
            <a href="{{ route('listings.show', $listing) }}" class="text-decoration-none text-dark hover-teal">
                {{ $listing->name }}
            </a>
        </h6>

        <div class="mp-card-footer">
            <div>
                <i class="fa-solid fa-location-dot me-1 text-danger"></i> 
                {{ $listing->area ? $listing->area.', ' : '' }}{{ $listing->city }}
            </div>
            <div>
                {{ $listing->created_at->diffForHumans(null, true, true) }}
            </div>
        </div>
    </div>
</div>
