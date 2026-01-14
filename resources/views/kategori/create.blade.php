@extends('layouts.template')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start mb-3 mb-md-4 gap-2">
        <div>
            <h2 class="mb-1 fs-4 fs-md-3">
                <i class="fas fa-plus-circle text-primary"></i> Tambah Kategori
            </h2>
            <p class="text-muted mb-0 small">Tambahkan kategori barang baru</p>
        </div>
        <a href="{{ route('kategori.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row g-3">
        <!-- Form Card -->
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary bg-gradient text-white">
                    <h5 class="mb-0 fs-6">
                        <i class="fas fa-tags"></i> Formulir Kategori
                    </h5>
                </div>
                <div class="card-body p-3 p-md-4">
                    <form action="{{ route('kategori.store') }}" method="POST" id="formKategori">
                        @csrf
                        
                        <!-- Nama Kategori -->
                        <div class="mb-4">
                            <label for="nama_kategori" class="form-label fw-semibold">
                                Nama Kategori <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-tag text-primary"></i>
                                </span>
                                <input type="text" 
                                       id="nama_kategori"
                                       name="nama_kategori" 
                                       class="form-control @error('nama_kategori') is-invalid @enderror" 
                                       value="{{ old('nama_kategori') }}"
                                       placeholder="Contoh: Elektronik, Furniture, Alat Tulis"
                                       required
                                       autofocus>
                                @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Nama kategori harus jelas dan mudah dipahami
                            </small>
                        </div>
                        
                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-semibold">
                                Deskripsi <span class="text-muted small">(Opsional)</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light align-items-start pt-2">
                                    <i class="fas fa-align-left text-primary"></i>
                                </span>
                                <textarea id="deskripsi"
                                          name="deskripsi" 
                                          class="form-control @error('deskripsi') is-invalid @enderror" 
                                          rows="4"
                                          placeholder="Jelaskan jenis barang yang termasuk dalam kategori ini...">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <small class="form-text text-muted">
                                    <i class="fas fa-lightbulb"></i> Deskripsi membantu identifikasi kategori
                                </small>
                                <small class="text-muted char-count">
                                    <span id="charCount">0</span>/500 karakter
                                </small>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-end mt-4">
                            <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary order-2 order-sm-1">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary order-1 order-sm-2">
                                <i class="fas fa-save"></i> Simpan Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Sidebar -->
        <div class="col-12 col-lg-4">
            <!-- Tips Card -->
            <div class="card border-info shadow-sm mb-3">
                <div class="card-header bg-info bg-opacity-10 border-bottom border-info">
                    <h6 class="mb-0 text-info">
                        <i class="fas fa-lightbulb"></i> Tips Pengisian
                    </h6>
                </div>
                <div class="card-body p-3">
                    <ul class="small mb-0 ps-3">
                        <li class="mb-2">Gunakan nama yang spesifik dan mudah dikenali</li>
                        <li class="mb-2">Hindari penggunaan singkatan yang ambigu</li>
                        <li class="mb-2">Kelompokkan barang dengan karakteristik serupa</li>
                        <li class="mb-0">Tambahkan deskripsi untuk memudahkan klasifikasi</li>
                    </ul>
                </div>
            </div>

            <!-- Examples Card -->
            <div class="card border-success shadow-sm">
                <div class="card-header bg-success bg-opacity-10 border-bottom border-success">
                    <h6 class="mb-0 text-success">
                        <i class="fas fa-check-circle"></i> Contoh Kategori
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-primary bg-opacity-75">Elektronik</span>
                        <span class="badge bg-primary bg-opacity-75">Furniture</span>
                        <span class="badge bg-primary bg-opacity-75">Alat Tulis</span>
                        <span class="badge bg-primary bg-opacity-75">Peralatan Olahraga</span>
                        <span class="badge bg-primary bg-opacity-75">Alat Kebersihan</span>
                        <span class="badge bg-primary bg-opacity-75">Kendaraan</span>
                        <span class="badge bg-primary bg-opacity-75">Peralatan Medis</span>
                        <span class="badge bg-primary bg-opacity-75">Buku & Perpustakaan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Card Enhancements */
.card {
    border-radius: 0.75rem;
    overflow: hidden;
    transition: all 0.3s ease;
}

.card-header {
    border-bottom: 2px solid rgba(255,255,255,0.2);
}

/* Form Styling */
.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
}

.input-group-text {
    border: 1px solid #dee2e6;
    transition: all 0.3s;
}

.form-control:focus ~ .input-group-text,
.input-group:focus-within .input-group-text {
    border-color: #0d6efd;
    background-color: #e7f1ff !important;
}

textarea.form-control {
    resize: vertical;
    min-height: 100px;
}

/* Button Styling */
.btn {
    font-weight: 500;
    padding: 0.5rem 1.25rem;
    transition: all 0.3s;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.btn-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #0a58ca 0%, #084298 100%);
}

/* Badge Styling */
.badge {
    padding: 0.5rem 0.75rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.badge:hover {
    transform: scale(1.05);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Character Counter */
.char-count {
    font-size: 0.8rem;
    font-weight: 500;
}

/* Info Cards */
.border-info,
.border-success {
    border-left-width: 4px !important;
}

/* Mobile Optimizations */
@media (max-width: 576px) {
    .fs-4 {
        font-size: 1.15rem !important;
    }
    
    .fs-6 {
        font-size: 0.95rem !important;
    }
    
    h6 {
        font-size: 0.9rem;
    }
    
    .card-body {
        padding: 1rem !important;
    }
    
    .btn {
        width: 100%;
        padding: 0.6rem 1rem;
    }
    
    .input-group-text {
        padding: 0.5rem;
    }
    
    .form-control {
        font-size: 0.95rem;
    }
    
    small, .small {
        font-size: 0.8rem;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.6rem;
    }

    textarea.form-control {
        min-height: 80px;
    }
}

/* Tablet Optimizations */
@media (min-width: 577px) and (max-width: 768px) {
    .card-body {
        padding: 1.5rem !important;
    }
}

/* Touch-friendly */
@media (max-width: 768px) {
    .form-control,
    .btn {
        min-height: 44px;
    }
    
    .input-group-text {
        min-width: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    textarea.form-control {
        min-height: 100px;
    }
}

/* Loading State */
.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
}

/* Form Validation */
.is-invalid {
    border-color: #dc3545 !important;
}

.invalid-feedback {
    display: block;
    font-size: 0.875rem;
}

/* Hover Effects */
@media (hover: hover) {
    .card:hover {
        box-shadow: 0 8px 16px rgba(0,0,0,0.1) !important;
    }
}

/* Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: fadeIn 0.5s ease;
}

.card:nth-child(2) .card {
    animation-delay: 0.1s;
}

/* Focus Visible for Accessibility */
button:focus-visible,
a:focus-visible,
input:focus-visible,
textarea:focus-visible {
    outline: 2px solid #0d6efd;
    outline-offset: 2px;
}

/* Gradient backgrounds */
.bg-gradient {
    background-image: linear-gradient(180deg, rgba(255,255,255,.15), rgba(255,255,255,0));
}
</style>

<script>
// Form Enhancement
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formKategori');
    const submitBtn = form.querySelector('button[type="submit"]');
    const namaInput = document.getElementById('nama_kategori');
    const deskripsiTextarea = document.getElementById('deskripsi');
    const charCount = document.getElementById('charCount');
    
    // Auto-capitalize first letter
    namaInput.addEventListener('input', function(e) {
        let value = e.target.value;
        e.target.value = value.replace(/\b\w/g, l => l.toUpperCase());
    });
    
    // Character counter for description
    deskripsiTextarea.addEventListener('input', function() {
        const length = this.value.length;
        const maxLength = 500;
        
        charCount.textContent = length;
        
        // Change color based on length
        if (length > maxLength * 0.9) {
            charCount.classList.add('text-danger');
            charCount.classList.remove('text-warning', 'text-muted');
        } else if (length > maxLength * 0.7) {
            charCount.classList.add('text-warning');
            charCount.classList.remove('text-danger', 'text-muted');
        } else {
            charCount.classList.add('text-muted');
            charCount.classList.remove('text-danger', 'text-warning');
        }
        
        // Limit characters
        if (length > maxLength) {
            this.value = this.value.substring(0, maxLength);
            charCount.textContent = maxLength;
        }
    });
    
    // Form submit handling
    form.addEventListener('submit', function(e) {
        // Disable button to prevent double submit
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        
        // If validation fails, re-enable button
        if (!form.checkValidity()) {
            e.preventDefault();
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save"></i> Simpan Kategori';
        }
    });
    
    // Example badges click to fill
    const exampleBadges = document.querySelectorAll('.badge');
    exampleBadges.forEach(badge => {
        badge.addEventListener('click', function() {
            if (confirm(`Gunakan "${this.textContent}" sebagai nama kategori?`)) {
                namaInput.value = this.textContent;
                namaInput.focus();
                
                // Add animation
                namaInput.classList.add('border-success');
                setTimeout(() => {
                    namaInput.classList.remove('border-success');
                }, 1000);
            }
        });
    });
    
    // Add tooltip to badges
    exampleBadges.forEach(badge => {
        badge.setAttribute('title', 'Klik untuk menggunakan sebagai nama kategori');
    });
    
    // Keyboard shortcut: Ctrl+S to save
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            form.requestSubmit();
        }
    });
    
    // Auto-save to localStorage (optional)
    const autoSaveKey = 'kategori_form_draft';
    
    // Load draft
    const savedDraft = localStorage.getItem(autoSaveKey);
    if (savedDraft) {
        const draft = JSON.parse(savedDraft);
        if (draft.nama && !namaInput.value) {
            if (confirm('Ditemukan draft tersimpan. Muat data draft?')) {
                namaInput.value = draft.nama;
                deskripsiTextarea.value = draft.deskripsi || '';
                charCount.textContent = (draft.deskripsi || '').length;
            } else {
                localStorage.removeItem(autoSaveKey);
            }
        }
    }
    
    // Save draft on input
    let saveTimeout;
    function saveDraft() {
        clearTimeout(saveTimeout);
        saveTimeout = setTimeout(() => {
            const draft = {
                nama: namaInput.value,
                deskripsi: deskripsiTextarea.value
            };
            localStorage.setItem(autoSaveKey, JSON.stringify(draft));
        }, 1000);
    }
    
    namaInput.addEventListener('input', saveDraft);
    deskripsiTextarea.addEventListener('input', saveDraft);
    
    // Clear draft on successful submit
    form.addEventListener('submit', function() {
        localStorage.removeItem(autoSaveKey);
    });
});
</script>
@endsection