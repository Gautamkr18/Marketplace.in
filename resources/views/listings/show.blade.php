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
                    <img src="{{ $listing->image_url }}" alt="{{ $listing->name }}" class="img-fluid w-100" style="max-height: 480px; object-fit: contain;" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'p-5 text-white-50\'><i class=\'fa-solid fa-image fs-1 mb-2\'></i><div>No Image Available</div></div>';">
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

    <!-- Seller Information & Connect Sidebar -->
    <div class="col-lg-4">
        <!-- Seller Card -->
        <div class="card border-0 shadow-sm rounded-3 p-4 mb-4" style="background:#fff;">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold fs-4" style="width: 56px; height: 56px; background: linear-gradient(135deg, var(--mp-navy) 0%, var(--mp-teal) 100%);">
                    {{ strtoupper(substr($listing->user->name ?? 'S', 0, 1)) }}
                </div>
                <div>
                    <h5 class="fw-bold text-dark mb-0">{{ $listing->user->name ?? 'Verified Seller' }}</h5>
                    <div class="d-flex align-items-center gap-1 text-muted small">
                        <i class="fa-solid fa-circle-check text-success"></i> Verified Member
                    </div>
                    <small class="text-muted">Member since {{ $listing->user->created_at ? $listing->user->created_at->format('M Y') : 'Recent' }}</small>
                </div>
            </div>

            <!-- Connect Action Buttons -->
            <div class="d-grid gap-2 mb-3">
                <!-- WhatsApp Connect -->
                @php
                    $sellerPhoneRaw = $listing->user->phone ?? '';
                    $cleanPhone = preg_replace('/[^0-9]/', '', $sellerPhoneRaw);
                    $cleanPhone = ltrim($cleanPhone, '0');
                    if (strlen($cleanPhone) === 10) {
                        $cleanPhone = '91' . $cleanPhone;
                    }
                    $waText = urlencode("Hi ".($listing->user->name ?? 'Seller').", I am interested in your listing: '{$listing->name}' ({$listing->formatted_price}) on Marketplace.in. Is it still available?");
                    $waUrl = !empty($cleanPhone)
                        ? "https://api.whatsapp.com/send?phone={$cleanPhone}&text={$waText}"
                        : "https://api.whatsapp.com/send?text={$waText}";
                @endphp
                <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-success fw-bold py-2 shadow-sm d-flex align-items-center justify-content-center gap-2">
                    <i class="fa-brands fa-whatsapp fs-5"></i> Chat on WhatsApp
                </a>

                <!-- Make an Offer Modal Trigger -->
                <button type="button" class="btn btn-outline-dark fw-bold py-2 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#makeOfferModal">
                    <i class="fa-solid fa-tag text-warning"></i> Make an Offer
                </button>

                <!-- Show Seller Contact Phone -->
                <button type="button" class="btn btn-light border fw-bold py-2 text-dark d-flex align-items-center justify-content-center gap-2" id="btnRevealPhone" onclick="revealSellerContact()">
                    <i class="fa-solid fa-phone text-primary"></i> <span id="phoneText">Show Seller Contact</span>
                </button>
            </div>

            <div class="p-3 bg-light rounded-3 text-center">
                <small class="text-muted d-block mb-1">Seller Location</small>
                <span class="fw-bold text-dark"><i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $listing->city }}, {{ $listing->state }}</span>
            </div>
        </div>

        <!-- Live In-Page Chat Box with Seller -->
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4" style="background:#fff;">
            <div class="card-header bg-navy text-white p-3 d-flex justify-content-between align-items-center" style="background: var(--mp-navy);">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-comments text-warning"></i>
                    <span class="fw-bold">Chat with Seller</span>
                </div>
                <span class="badge bg-success text-white small"><i class="fa-solid fa-circle me-1" style="font-size: 0.5rem;"></i> Online</span>
            </div>

            <!-- Quick question pills -->
            <div class="p-2 bg-light border-bottom d-flex gap-1 overflow-x-auto text-nowrap scrollbar-none">
                <button type="button" class="btn btn-white btn-sm border rounded-pill small py-1 px-2 text-muted fw-bold" onclick="sendQuickChat('Is this still available?')">
                    "Still available?"
                </button>
                <button type="button" class="btn btn-white btn-sm border rounded-pill small py-1 px-2 text-muted fw-bold" onclick="sendQuickChat('What is your best final price?')">
                    "Best price?"
                </button>
                <button type="button" class="btn btn-white btn-sm border rounded-pill small py-1 px-2 text-muted fw-bold" onclick="sendQuickChat('Can we meet today?')">
                    "Meet today?"
                </button>
            </div>

            <!-- Chat message body -->
            <div id="chatBoxBody" class="p-3 bg-light overflow-y-auto" style="height: 220px; font-size: 0.88rem;">
                <div class="d-flex mb-3">
                    <div class="bg-white p-3 rounded-3 shadow-sm text-dark border" style="max-width: 85%;">
                        Hello! 👋 I am {{ $listing->user->name ?? 'the seller' }}. Let me know if you have any questions about this ad!
                    </div>
                </div>
            </div>

            <!-- Chat input -->
            <div class="p-2 bg-white border-top">
                <div class="input-group">
                    <input type="text" id="chatInputMsg" class="form-control form-control-sm border-0 bg-light" placeholder="Type a message..." onkeydown="if(event.key==='Enter') sendChatMessage()">
                    <button class="btn btn-dark btn-sm px-3" type="button" onclick="sendChatMessage()">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Safety Tips -->
        <div class="card border-0 shadow-sm rounded-3 p-3 text-muted small" style="background: #fdfdfd; border-left: 4px solid var(--mp-teal) !important;">
            <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-shield-halved text-teal me-1" style="color: var(--mp-teal);"></i> Safety Tips for Buyers</h6>
            <ul class="mb-0 ps-3 lh-base">
                <li>Meet the seller at a safe public location.</li>
                <li>Check the item thoroughly before making payment.</li>
                <li>Avoid advance payments or suspicious transfers.</li>
            </ul>
        </div>
    </div>
</div>

<!-- Make an Offer Modal -->
<div class="modal fade" id="makeOfferModal" tabindex="-1" aria-labelledby="makeOfferModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-navy text-white p-4" style="background: var(--mp-navy);">
                <h5 class="modal-title fw-bold" id="makeOfferModalLabel"><i class="fa-solid fa-tags text-warning me-2"></i> Make an Offer to Seller</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small mb-3">Listed Price: <strong class="text-dark fs-5">{{ $listing->formatted_price }}</strong></p>
                
                <label class="form-label fw-bold text-dark small text-uppercase">Select Quick Offer:</label>
                <div class="d-flex gap-2 mb-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm flex-grow-1 fw-bold" onclick="setOfferPct(0.95)">-5%</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm flex-grow-1 fw-bold" onclick="setOfferPct(0.90)">-10%</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm flex-grow-1 fw-bold" onclick="setOfferPct(0.85)">-15%</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm flex-grow-1 fw-bold" onclick="setOfferPct(0.80)">-20%</button>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small text-uppercase">Your Offer Amount (₹)</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light fw-bold">₹</span>
                        <input type="number" id="offerAmountInput" class="form-control fw-bold text-success" value="{{ round($listing->price * 0.9) }}">
                    </div>
                </div>

                <button type="button" class="btn btn-warning btn-lg w-100 fw-bold py-3 text-dark shadow-sm rounded-3" onclick="submitOffer()">
                    <i class="fa-solid fa-paper-plane me-2"></i> Send Offer to Seller
                </button>
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

    function revealSellerContact() {
        const phoneText = document.getElementById('phoneText');
        const phone = @json($listing->user->phone ?? '');
        const email = @json($listing->user->email ?? 'seller@marketplace.in');
        
        if (phone && phone.trim() !== '') {
            const rawPhone = phone.replace(/[^0-9+]/g, '');
            phoneText.innerHTML = `<a href="tel:${rawPhone}" class="text-dark text-decoration-none fw-bold"><i class="fa-solid fa-phone-volume text-success me-1"></i> ${phone}</a> &bull; <a href="mailto:${email}" class="text-muted text-decoration-none small">${email}</a>`;
        } else {
            phoneText.innerHTML = `<i class="fa-solid fa-envelope text-primary me-1"></i> <a href="mailto:${email}" class="text-dark text-decoration-none fw-bold">${email}</a>`;
        }
        showToast('<i class="fa-solid fa-phone text-success"></i> Seller contact information revealed!');
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
            replyMsg.innerHTML = `<div class="bg-white p-3 rounded-3 shadow-sm text-dark border" style="max-width: 80%;">Thanks for reaching out! Yes, it is in excellent condition and available in {{ $listing->city }}. Let me know when you would like to inspect it.</div>`;
            body.appendChild(replyMsg);
            body.scrollTop = body.scrollHeight;
        }, 1000);
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
        showToast('<i class="fa-solid fa-paper-plane text-success"></i> Your offer of ₹' + Number(offer).toLocaleString() + ' has been sent to {{ $listing->user->name ?? "the seller" }}!');
    }
</script>
@endsection
