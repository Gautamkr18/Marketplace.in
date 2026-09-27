<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Marketplace.in</title>

    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --mp-navy: #002f34;
            --mp-teal: #00a5a5;
            --mp-mint: #23e5bf;
            --mp-yellow: #ffce32;
            --mp-bg: #f2f4f5;
            --mp-card-bg: #ffffff;
            --mp-text: #002f34;
            --mp-muted: #406367;
            --mp-border: #e0e5e6;
            --mp-radius: 12px;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--mp-bg);
            color: var(--mp-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
        }

        /* Navbar */
        .mp-navbar {
            background-color: #f7f9fa;
            border-bottom: 2px solid #ebf1f2;
            position: sticky;
            top: 0;
            z-index: 1040;
            box-shadow: 0 2px 10px rgba(0, 47, 52, 0.05);
        }

        .mp-brand {
            font-weight: 900;
            font-size: 1.8rem;
            letter-spacing: -1px;
            color: var(--mp-navy) !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .mp-brand span {
            color: var(--mp-teal);
        }

        /* Main Live Search Input */
        .search-box-wrap {
            position: relative;
            flex-grow: 1;
        }

        .search-box-input {
            border: 2px solid var(--mp-navy);
            border-radius: 8px 0 0 8px;
            height: 48px;
            font-size: 0.95rem;
            font-weight: 500;
            padding-left: 16px;
        }

        .search-box-input:focus {
            box-shadow: none;
            border-color: var(--mp-teal);
        }

        .search-box-btn {
            background-color: var(--mp-navy);
            color: #fff;
            border: 2px solid var(--mp-navy);
            border-radius: 0 8px 8px 0;
            width: 54px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.2s ease;
        }

        .search-box-btn:hover {
            background-color: #00454d;
            color: var(--mp-mint);
        }

        /* Live Autocomplete Dropdown */
        .search-suggestions-dropdown {
            position: absolute;
            top: 52px;
            left: 0;
            right: 0;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 47, 52, 0.18);
            border: 1px solid var(--mp-border);
            z-index: 1050;
            display: none;
            overflow: hidden;
        }

        .suggestion-item {
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--mp-navy);
            border-bottom: 1px solid #f0f4f5;
            transition: background 0.15s ease;
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }

        .suggestion-item:hover {
            background-color: #e8f7f7;
        }

        .suggestion-img {
            width: 44px;
            height: 44px;
            object-fit: cover;
            border-radius: 6px;
            background: #eee;
        }

        /* SELL Button */
        .btn-mp-sell {
            position: relative;
            background: #fff;
            color: var(--mp-navy);
            font-weight: 800;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
            padding: 8px 22px;
            border-radius: 30px;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 5px solid transparent;
            border-image: linear-gradient(135deg, #23e5bf 0%, #ffce32 50%, #00a5a5 100%) 1;
            border-radius: 50px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-mp-sell:hover {
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 6px 20px rgba(0, 47, 52, 0.2);
            color: var(--mp-navy);
        }

        /* Top Category Strip */
        .category-strip {
            background: #fff;
            border-bottom: 1px solid var(--mp-border);
            padding: 12px 0;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        }

        .cat-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #f7f9fa;
            border: 1px solid var(--mp-border);
            border-radius: 20px;
            color: var(--mp-navy);
            font-weight: 600;
            font-size: 0.88rem;
            text-decoration: none;
            white-space: nowrap;
            transition: all 0.2s ease;
        }

        .cat-chip i {
            color: var(--mp-teal);
        }

        .cat-chip:hover,
        .cat-chip.active {
            background: var(--mp-navy);
            color: #fff;
            border-color: var(--mp-navy);
        }

        .cat-chip:hover i,
        .cat-chip.active i {
            color: var(--mp-yellow);
        }

        /* Listing Cards */
        .mp-card {
            background: var(--mp-card-bg);
            border-radius: var(--mp-radius);
            border: 1px solid var(--mp-border);
            overflow: hidden;
            transition: all 0.25s ease;
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .mp-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 47, 52, 0.12);
            border-color: #c4d4d6;
        }

        .mp-card-img-wrap {
            position: relative;
            width: 100%;
            height: 200px;
            background-color: #eaeff0;
            overflow: hidden;
        }

        .mp-card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .mp-card:hover .mp-card-img-wrap img {
            transform: scale(1.06);
        }

        .badge-featured {
            position: absolute;
            top: 10px;
            left: 10px;
            background: var(--mp-yellow);
            color: var(--mp-navy);
            font-weight: 800;
            font-size: 0.72rem;
            padding: 3px 10px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .badge-type {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(0, 47, 52, 0.85);
            color: #fff;
            font-weight: 600;
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 4px;
            backdrop-filter: blur(4px);
        }

        .mp-card-body {
            padding: 16px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .mp-card-price {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--mp-navy);
            margin-bottom: 4px;
        }

        .mp-card-title {
            font-size: 0.98rem;
            font-weight: 600;
            color: #002f34;
            margin-bottom: 8px;
            line-clamp: 2;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.3;
        }

        .mp-card-footer {
            margin-top: auto;
            padding-top: 10px;
            border-top: 1px solid #f0f4f5;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.78rem;
            color: var(--mp-muted);
            font-weight: 500;
        }

        /* Hero Banner */
        .mp-hero-banner {
            background: linear-gradient(135deg, #002f34 0%, #004d54 100%);
            color: #fff;
            padding: 32px 0;
            border-radius: 16px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }

        .mp-hero-banner::after {
            content: '';
            position: absolute;
            right: -40px;
            bottom: -40px;
            width: 260px;
            height: 260px;
            background: rgba(35, 229, 191, 0.1);
            border-radius: 50%;
            pointer-events: none;
        }

        /* Footer */
        footer {
            background-color: #ebeeef;
            color: var(--mp-navy);
            border-top: 1px solid var(--mp-border);
            margin-top: auto;
        }

        /* Toast */
        .toast-container {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 1100;
        }

        .mp-toast {
            background: var(--mp-navy);
            color: #fff;
            border-radius: 10px;
            padding: 12px 20px;
            box-shadow: 0 10px 25px rgba(0, 47, 52, 0.3);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            animation: slideUp 0.3s ease;
        }

        /* Pagination Styling */
        .pagination {
            gap: 6px;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pagination .page-item .page-link {
            border-radius: 8px !important;
            color: var(--mp-navy);
            border: 1px solid var(--mp-border);
            font-weight: 600;
            font-size: 0.88rem;
            padding: 8px 14px;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            background: #fff;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--mp-navy) !important;
            border-color: var(--mp-navy) !important;
            color: #fff !important;
            box-shadow: 0 4px 10px rgba(0, 47, 52, 0.2);
        }

        .pagination .page-item .page-link:hover:not(.active) {
            background-color: #e0f2f1;
            color: var(--mp-teal);
            border-color: var(--mp-teal);
        }

        .pagination .page-item.disabled .page-link {
            color: #94a3b8;
            background-color: #f8fafc;
            border-color: #e2e8f0;
        }

        .pagination svg {
            width: 1rem;
            height: 1rem;
        }
    </style>
    @yield('styles')
</head>

<body>

    <!-- Main Navbar -->
    <header class="mp-navbar">
        <div class="container py-2">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <!-- Brand Logo -->
                <a class="mp-brand me-2" href="{{ route('home') }}">
                    <i class="fa-solid fa-store text-success"></i> Marketplace<span>.in</span>
                </a>

                <!-- Global Live Search -->
                <div class="search-box-wrap">
                    <form method="GET" action="{{ route('home') }}" class="d-flex">
                        <input type="text" id="mainSearchInput" name="q" class="form-control search-box-input"
                            placeholder="Find Cars, Mobile Phones, Laptops, Apartments..." value="{{ request('q') }}"
                            autocomplete="off">
                        <button type="submit" class="search-box-btn">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                    <!-- Autocomplete Dropdown -->
                    <div id="searchSuggestions" class="search-suggestions-dropdown"></div>
                </div>

                <!-- Header Action Items -->
                <div class="d-flex align-items-center gap-3 ms-auto">
                    @auth
                        <!-- My Listings & User Menu -->
                        <div class="dropdown">
                            <button class="btn btn-light rounded-circle p-2 dropdown-toggle border-0" type="button"
                                data-bs-toggle="dropdown">
                                <i class="fa-solid fa-user-circle fs-4" style="color: var(--mp-navy);"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                <li class="px-3 py-2 border-bottom">
                                    <div class="fw-bold">{{ auth()->user()->name }}</div>
                                    <small class="text-muted">{{ auth()->user()->email }}</small>
                                </li>
                                <li><a class="dropdown-menu-item dropdown-item py-2" href="{{ route('listings.my') }}"><i
                                            class="fa-solid fa-boxes-packing me-2 text-primary"></i> My Ads</a></li>
                                <li><a class="dropdown-menu-item dropdown-item py-2"
                                        href="{{ route('listings.create') }}"><i
                                            class="fa-solid fa-plus-circle me-2 text-success"></i> Post New Ad</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item text-danger py-2"><i
                                                class="fa-solid fa-right-from-bracket me-2"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="fw-bold text-decoration-none"
                            style="color: var(--mp-navy);">Login</a>
                    @endauth

                    <!-- Sell Button -->
                    <a href="{{ route('listings.create') }}" class="btn-mp-sell">
                        <i class="fa-solid fa-plus"></i> SELL
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Category Horizontal Strip -->
    <nav class="category-strip">
        <div class="container d-flex align-items-center gap-2 overflow-x-auto py-1 scrollbar-none">
            <a href="{{ route('home') }}" class="cat-chip {{ !request()->routeIs('category.show') ? 'active' : '' }}">
                <i class="fa-solid fa-border-all"></i> All Categories
            </a>
            <a href="{{ route('category.show', 'cars') }}"
                class="cat-chip {{ request()->is('category/cars*') ? 'active' : '' }}">
                <i class="fa-solid fa-car"></i> Cars
            </a>
            <a href="{{ route('category.show', 'mobiles') }}"
                class="cat-chip {{ request()->is('category/mobiles*') ? 'active' : '' }}">
                <i class="fa-solid fa-mobile-screen-button"></i> Mobiles
            </a>
            <a href="{{ route('category.show', 'electronics-appliances') }}"
                class="cat-chip {{ request()->is('category/electronics*') ? 'active' : '' }}">
                <i class="fa-solid fa-laptop"></i> Electronics
            </a>
            <a href="{{ route('category.show', 'properties') }}"
                class="cat-chip {{ request()->is('category/properties*') ? 'active' : '' }}">
                <i class="fa-solid fa-house-chimney"></i> Properties
            </a>
            <a href="{{ route('category.show', 'furniture') }}"
                class="cat-chip {{ request()->is('category/furniture*') ? 'active' : '' }}">
                <i class="fa-solid fa-couch"></i> Furniture
            </a>
            <a href="{{ route('category.show', 'jobs') }}"
                class="cat-chip {{ request()->is('category/jobs*') ? 'active' : '' }}">
                <i class="fa-solid fa-briefcase"></i> Jobs
            </a>
            <a href="{{ route('category.show', 'services') }}"
                class="cat-chip {{ request()->is('category/services*') ? 'active' : '' }}">
                <i class="fa-solid fa-screwdriver-wrench"></i> Services
            </a>
            <a href="{{ route('category.show', 'fashion') }}"
                class="cat-chip {{ request()->is('category/fashion*') ? 'active' : '' }}">
                <i class="fa-solid fa-shirt"></i> Fashion
            </a>
            <a href="{{ route('category.show', 'pets') }}"
                class="cat-chip {{ request()->is('category/pets*') ? 'active' : '' }}">
                <i class="fa-solid fa-dog"></i> Pets
            </a>
            <a href="{{ route('category.show', 'books-sports-hobbies') }}"
                class="cat-chip {{ request()->is('category/books*') ? 'active' : '' }}">
                <i class="fa-solid fa-guitar"></i> Books & Hobbies
            </a>
        </div>
    </nav>

    <!-- Page Content Container -->
    <main class="container my-4 flex-grow-1">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4"
                role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="py-4 mt-5">
        <div class="container text-center text-muted small">
            &copy; {{ date('Y') }} <strong>Marketplace.in</strong>. All rights reserved.
        </div>
    </footer>

    <!-- Floating Toast Container -->
    <div id="toastContainer" class="toast-container"></div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Live Interactivity Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Live Search Autocomplete ---
            const searchInput = document.getElementById('mainSearchInput');
            const suggestionsBox = document.getElementById('searchSuggestions');

            if (searchInput && suggestionsBox) {
                let debounceTimer;
                searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    const query = this.value.trim();

                    if (query.length < 2) {
                        suggestionsBox.style.display = 'none';
                        return;
                    }

                    debounceTimer = setTimeout(() => {
                        fetch(`{{ route('ajax.suggestions') }}?q=${encodeURIComponent(query)}`)
                            .then(res => res.json())
                            .then(data => {
                                if (data.length === 0) {
                                    suggestionsBox.style.display = 'none';
                                    return;
                                }

                                let html = '';
                                data.forEach(item => {
                                    const imgTag = item.image ?
                                        `<img src="${item.image}" class="suggestion-img">` :
                                        `<div class="suggestion-img d-flex align-items-center justify-content-center text-muted"><i class="fa-solid fa-image"></i></div>`;
                                    html += `
                                    <a href="${item.url}" class="suggestion-item">
                                        ${imgTag}
                                        <div class="flex-grow-1">
                                            <div class="fw-bold text-dark text-truncate" style="max-width: 320px;">${item.name}</div>
                                            <small class="text-muted"><i class="fa-solid fa-location-dot me-1"></i>${item.city}</small>
                                        </div>
                                        <span class="badge bg-success font-monospace fs-6">${item.price}</span>
                                    </a>
                                `;
                                });
                                suggestionsBox.innerHTML = html;
                                suggestionsBox.style.display = 'block';
                            })
                            .catch(err => console.error(err));
                    }, 250);
                });

                // Close suggestion box on outside click
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                        suggestionsBox.style.display = 'none';
                    }
                });
            }
        });

        // Global Toast Notification Helper
        function showToast(message) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = 'mp-toast';
            toast.innerHTML = message;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.4s ease';
                setTimeout(() => toast.remove(), 400);
            }, 3000);
        }
    </script>

    @yield('scripts')
</body>

</html>
