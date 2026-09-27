@extends('layouts.app')
@section('title', $listing->name)

@section('content')

<!-- Breadcrumb Navigation -->
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb small">
        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('category.show', $listing->category->slug) }}" class="text-decoration-none text-muted">{{ $listing->category->name }}</a></li>
        @if($listing->subcategory)
            <li class="breadcrumb-item"><a href="{{ route('category.show', $listing->category->slug) }}?subcategory={{ $listing->subcategory->slug }}" class="text-decoration-none text-muted">{{ $listing->subcategory->name }}</a></li>
        @endif
        <li class="breadcrumb-item active text-dark fw-bold text-truncate" style="max-width: 250px;">{{ $listing->name }}</li>
    </ol>
</nav>

<div class="row g-4">
    <!-- Main Product Details -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4" style="background:#fff;">
            <div class="position-relative bg-dark text-center" style="min-height: 360px; max-height: 480px; display: flex; align-items: center; justify-content: center;">
                @if($listing->image_url)
                    <img src="{{ $listing->image_url }}" alt="{{ $listing->name }}" class="img-fluid w-100" style="max-height: 480px; object-fit: contain;">
                @else
                    <div class="p-5 text-white-50">
                        <i class="fa-solid fa-image fs-1 mb-2"></i>
                        <div>No Image Available</div>
                    </div>
                @endif
                <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-3 px-3 py-2 fw-bold uppercase">
                    {{ ucfirst($listing->type) }}
                </span>
            </div>

            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                    <div>
                        <h2 class="fw-extrabold text-dark mb-1" style="font-weight: 800;">{{ $listing->formatted_price }}</h2>
                        <h4 class="fw-bold text-secondary mb-2">{{ $listing->name }}</h4>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-light border btn-sm px-3" onclick="copyShareLink()">
                            <i class="fa-solid fa-share-nodes me-1 text-primary"></i> Share
                        </button>
                        @auth
                            @if(auth()->id() === $listing->user_id)
                                <a href="{{ route('listings.edit', $listing) }}" class="btn btn-warning btn-sm px-3 fw-bold">Edit Ad</a>
                            @endif
                        @endauth
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3 text-muted small pb-3 mb-4 border-bottom">
                    <div><i class="fa-solid fa-location-dot me-1 text-danger"></i> {{ $listing->area ? $listing->area.', ' : '' }}{{ $listing->city }}, {{ $listing->state }}</div>
                    <div>•</div>
                    <div><i class="fa-regular fa-clock me-1"></i> Posted {{ $listing->created_at->format('d M Y') }}</div>
                </div>

                <!-- Product Specifications -->
                <h6 class="fw-bold text-uppercase text-dark mb-3">Overview</h6>
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-4">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block">Category</small>
                            <span class="fw-bold text-dark">{{ $listing->category->name }}</span>
                        </div>
                    </div>
                    @if($listing->subcategory)
                        <div class="col-6 col-md-4">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted d-block">Subcategory</small>
                                <span class="fw-bold text-dark">{{ $listing->subcategory->name }}</span>
                            </div>
                        </div>
                    @endif
                    <div class="col-6 col-md-4">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block">Ad ID</small>
                            <span class="fw-bold text-dark">#MP-{{ $listing->id * 8421 }}</span>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <h6 class="fw-bold text-uppercase text-dark mb-3">Description</h6>
                <div class="text-dark lh-lg mb-4" style="white-space: pre-line; font-size: 1rem;">
                    {{ $listing->detail }}
                </div>

            </div>
        </div>
    </div>


</div>



@endsection

@section('scripts')
<script>
    function copyShareLink() {
        navigator.clipboard.writeText(window.location.href);
        showToast('<i class="fa-solid fa-link text-info"></i> Listing link copied to clipboard!');
    }

    function sendQuickChat(msg) {
        document.getElementById('chatInputMsg').value = msg;
        sendChatMessage();
    }

    function sendChatMessage() {
        const input = document.getElementById('chatInputMsg');
        const text = input.value.trim();
        if (!text) return;

        const body = document.getElementById('chatBoxBody');
        const userMsg = document.createElement('div');
        userMsg.className = 'd-flex justify-content-end mb-3';
        userMsg.innerHTML = `<div class="bg-navy text-white p-3 rounded-3 shadow-sm" style="max-width: 80%; background: var(--mp-navy);">${text}</div>`;
        body.appendChild(userMsg);
        input.value = '';
        body.scrollTop = body.scrollHeight;

        setTimeout(() => {
            const replyMsg = document.createElement('div');
            replyMsg.className = 'd-flex mb-3';
            replyMsg.innerHTML = `<div class="bg-white p-3 rounded-3 shadow-sm text-dark border" style="max-width: 80%;">Thanks for your inquiry! Yes, it is in excellent condition and available in {{ $listing->city }}. Let me know if you would like to meet up.</div>`;
            body.appendChild(replyMsg);
            body.scrollTop = body.scrollHeight;
        }, 1200);
    }

    function setOfferPct(factor) {
        const basePrice = {{ $listing->price }};
        document.getElementById('offerAmountInput').value = Math.round(basePrice * factor);
    }

    function submitOffer() {
        const offer = document.getElementById('offerAmountInput').value;
        const modalEl = document.getElementById('makeOfferModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        showToast('<i class="fa-solid fa-paper-plane text-success"></i> Your offer of ₹' + Number(offer).toLocaleString() + ' has been sent to the seller!');
    }
</script>
@endsection
