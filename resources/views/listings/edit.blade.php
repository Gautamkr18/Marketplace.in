@extends('layouts.app')
@section('title', 'Edit Ad: '.$listing->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="text-center mb-4">
            <h2 class="fw-extrabold text-dark" style="font-weight: 800;">EDIT AD</h2>
            <p class="text-muted">Update listing information or photos for {{ $listing->name }}</p>
        </div>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background:#fff;">
            <div class="card-header bg-navy text-white p-4" style="background: var(--mp-navy);">
                <div class="d-flex align-items-center gap-3">
                    <i class="fa-solid fa-pen-to-square fs-2 text-warning"></i>
                    <div>
                        <h5 class="fw-bold mb-0 text-white">Modify Details</h5>
                        <small class="text-white-50">Ad ID: #MP-{{ $listing->id * 8421 }}</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <form method="POST" action="{{ route('listings.update', $listing) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Type -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-muted">Item Type</label>
                        <select name="type" class="form-select form-select-lg rounded-3" required>
                            <option value="product" {{ $listing->type=='product'?'selected':'' }}>Product</option>
                            <option value="service" {{ $listing->type=='service'?'selected':'' }}>Service</option>
                        </select>
                    </div>

                    <!-- Category & Subcategory -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-uppercase small text-muted">Category *</label>
                            <select name="category_id" id="category_id" class="form-select form-select-lg rounded-3" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $listing->category_id==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-uppercase small text-muted">Subcategory</label>
                            <select name="subcategory_id" id="subcategory_id" class="form-select form-select-lg rounded-3">
                                @foreach($categories->firstWhere('id', $listing->category_id)?->subcategories ?? [] as $sub)
                                    <option value="{{ $sub->id }}" {{ $listing->subcategory_id==$sub->id?'selected':'' }}>{{ $sub->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-muted">Ad Title *</label>
                        <input type="text" name="name" class="form-control form-control-lg rounded-3" value="{{ old('name', $listing->name) }}" required>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-muted">Description *</label>
                        <textarea name="detail" rows="5" class="form-control rounded-3" required>{{ old('detail', $listing->detail) }}</textarea>
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-muted">Price (₹) *</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light fw-bold">₹</span>
                            <input type="number" step="1" min="0" name="price" class="form-control rounded-end-3 fw-bold text-success" value="{{ old('price', $listing->price) }}" required>
                        </div>
                    </div>

                    <!-- Image Upload Zone -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-muted d-flex justify-content-between align-items-center">
                            <span>Listing Photo</span>
                            <span class="badge bg-light text-muted border">Change Photo</span>
                        </label>

                        @if($listing->image_url)
                            <div class="mb-3 p-3 bg-light rounded-3 border text-center" id="currentImageWrapper">
                                <div class="small fw-bold text-muted mb-2"><i class="fa-solid fa-image me-1"></i> Current Photo:</div>
                                <img src="{{ $listing->image_url }}" class="img-thumbnail rounded-3 shadow-sm mx-auto d-block" style="max-height: 180px; object-fit: contain;">
                            </div>
                        @endif

                        <!-- Nav tabs for upload method -->
                        <ul class="nav nav-pills nav-fill mb-3 bg-light p-1 rounded-3" id="imageTabsEdit" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active py-2 fw-bold small" id="upload-tab-edit" data-bs-toggle="pill" data-bs-target="#tab-upload-edit" type="button" role="tab"><i class="fa-solid fa-cloud-arrow-up me-1"></i> Upload New File</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link py-2 fw-bold small" id="url-tab-edit" data-bs-toggle="pill" data-bs-target="#tab-url-edit" type="button" role="tab"><i class="fa-solid fa-link me-1"></i> Image URL / Link</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="imageTabContentEdit">
                            <!-- Tab: File Upload -->
                            <div class="tab-pane fade show active" id="tab-upload-edit" role="tabpanel">
                                <div class="p-4 border-2 border-dashed rounded-3 text-center bg-light position-relative" id="dropZoneEdit" style="border-style: dashed !important; border-color: #cbd5e1; cursor: pointer;">
                                    <i class="fa-solid fa-images fs-1 text-teal mb-2" style="color: var(--mp-teal);"></i>
                                    <div class="fw-bold text-dark">Click to browse or drag & drop new photo</div>
                                    <small class="text-muted d-block mb-2">PNG, JPG, WEBP, GIF up to 8MB</small>
                                    <input type="file" name="image" id="imageInputEdit" class="d-none" accept="image/*" onchange="previewImageEdit(this)">
                                    <button type="button" class="btn btn-outline-dark btn-sm px-3 mt-1" onclick="document.getElementById('imageInputEdit').click()"><i class="fa-solid fa-folder-open me-1"></i> Choose New File</button>
                                </div>
                            </div>

                            <!-- Tab: Image URL -->
                            <div class="tab-pane fade" id="tab-url-edit" role="tabpanel">
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fa-solid fa-image text-muted"></i></span>
                                    <input type="url" name="image_url_input" id="imageUrlInputEdit" class="form-control" placeholder="https://images.unsplash.com/photo-... or any image URL" oninput="previewUrlImageEdit(this.value)">
                                </div>
                                <small class="text-muted mt-1 d-block">Paste a direct image link from Unsplash, Google, or any web host.</small>
                            </div>
                        </div>

                        <!-- Unified Preview Container -->
                        <div id="imagePreviewContainerEdit" class="mt-3 p-3 bg-light rounded-3 border text-center d-none position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small fw-bold text-success"><i class="fa-solid fa-eye me-1"></i> New Photo Preview</span>
                                <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="clearSelectedImageEdit()"><i class="fa-solid fa-xmark"></i> Cancel</button>
                            </div>
                            <img id="imagePreviewEdit" src="" class="img-thumbnail rounded-3 shadow-sm mx-auto d-block" style="max-height: 200px; object-fit: contain;">
                        </div>
                    </div>

                    <!-- Location details -->
                    <h6 class="fw-bold text-uppercase text-dark mt-4 mb-3 border-top pt-3">Location Details</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">Country *</label>
                            <input type="text" name="country" class="form-control" value="{{ old('country', $listing->country) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">State *</label>
                            <input type="text" name="state" class="form-control" value="{{ old('state', $listing->state) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">City *</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city', $listing->city) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">Area</label>
                            <input type="text" name="area" class="form-control" value="{{ old('area', $listing->area) }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold py-3 text-dark shadow-sm rounded-3">
                        <i class="fa-solid fa-save me-2"></i> UPDATE AD
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('category_id').addEventListener('change', function () {
        const categoryId = this.value;
        const subSelect = document.getElementById('subcategory_id');
        subSelect.innerHTML = '<option value="">Loading...</option>';
        if (!categoryId) { subSelect.innerHTML = '<option value="">Select Subcategory</option>'; return; }

        fetch(`/ajax/categories/${categoryId}/subcategories`)
            .then(res => res.json())
            .then(data => {
                subSelect.innerHTML = '<option value="">Select Subcategory</option>';
                data.forEach(sub => {
                    const opt = document.createElement('option');
                    opt.value = sub.id;
                    opt.textContent = sub.name;
                    subSelect.appendChild(opt);
                });
            });
    });

    const dropZoneEdit = document.getElementById('dropZoneEdit');
    const imageInputEdit = document.getElementById('imageInputEdit');

    if (dropZoneEdit && imageInputEdit) {
        dropZoneEdit.addEventListener('click', (e) => {
            if (e.target !== imageInputEdit && !e.target.closest('button')) {
                imageInputEdit.click();
            }
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZoneEdit.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropZoneEdit.classList.add('bg-white', 'border-primary');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZoneEdit.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropZoneEdit.classList.remove('bg-white', 'border-primary');
            }, false);
        });

        dropZoneEdit.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files && files.length > 0) {
                imageInputEdit.files = files;
                previewImageEdit(imageInputEdit);
            }
        });
    }

    function previewImageEdit(input) {
        const preview = document.getElementById('imagePreviewEdit');
        const container = document.getElementById('imagePreviewContainerEdit');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewUrlImageEdit(url) {
        const preview = document.getElementById('imagePreviewEdit');
        const container = document.getElementById('imagePreviewContainerEdit');
        if (url && url.trim().startsWith('http')) {
            preview.src = url.trim();
            container.classList.remove('d-none');
        } else if (!document.getElementById('imageInputEdit').files.length) {
            container.classList.add('d-none');
        }
    }

    function clearSelectedImageEdit() {
        const imageInput = document.getElementById('imageInputEdit');
        const imageUrlInput = document.getElementById('imageUrlInputEdit');
        const container = document.getElementById('imagePreviewContainerEdit');
        const preview = document.getElementById('imagePreviewEdit');

        if (imageInput) imageInput.value = '';
        if (imageUrlInput) imageUrlInput.value = '';
        if (preview) preview.src = '';
        if (container) container.classList.add('d-none');
    }
</script>
@endsection
