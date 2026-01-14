@extends('layouts.template')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start mb-3 mb-md-4 gap-2">
        <div>
            <h2 class="mb-1 fs-4 fs-md-3">
                <i class="fas fa-edit text-warning"></i> Edit Kategori
            </h2>
            <p class="text-muted mb-0 small">Update data kategori barang</p>
        </div>
        <a href="{{ route('kategori.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row g-3">
        <!-- Form Card -->
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning bg-gradient text-dark">
                    <h5 class="mb-0 fs-6 fw-bold">
                        <i class="fas fa-tags"></i> Formulir Edit Kategori
                    </h5>
                </div>
                <div class="card-body p-3 p-md-4">
                    <!-- Current Info Display -->
                    <div class="alert alert-info border-0 mb-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-info-circle me-2 mt-1"></i>
                            <div>
                                <strong>Data Saat Ini:</strong>
                                <div class="mt-2">
                                    <div class="mb-1">
                                        <small class="text-muted">Nama:</small>
                                        <span class="badge bg-primary ms-1">{{ $kategori->nama_kategori }}</span>
                                    </div>
                                    @if($kategori->deskripsi)
                                    <div>
                                        <small class="text-muted">Deskripsi:</small>
                                        <div class="small mt-1 fst-italic">"{{ Str::limit($kategori->deskripsi, 100) }}"</div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST" id="formKategori">
                        @csrf
                        @method('PUT')
                        
                        <!-- Nama Kategori -->
                        <div class="mb-4">
                            <label for="nama_kategori" class="form-label fw-semibold">
                                Nama Kategori <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-tag text-warning"></i>
                                </span>
                                <input type="text" 
                                       id="nama_kategori"
                                       name="nama_kategori" 
                                       class="form-control @error('nama_kategori') is-invalid @enderror" 
                                       value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
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
                                    <i class="fas fa-align-left text-warning"></i>
                                </span>
                                <textarea id="deskripsi"
                                          name="deskripsi" 
                                          class="form-control @error('deskripsi') is-invalid @enderror" 
                                          rows="4"
                                          placeholder="Jelaskan jenis barang yang termasuk dalam kategori ini...">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                                @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <small class="form-text text-muted">
                                    <i class="fas fa-lightbulb"></i> Deskripsi membantu identifikasi kategori
                                </small>
                                <small class="text-muted char-count">
                                    <span id="charCount">{{ strlen(old('deskripsi', $kategori->deskripsi ?? '')) }}</span>/500 karakter
                                </small>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-end mt-4">
                            <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary order-2 order-sm-1">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning text-dark order-1 order-sm-2">
                                <i class="fas fa-save"></i> Update Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Sidebar -->
        <div class="col-12 col-lg-4">
            <!-- Warning Card -->
            <div class="card border-warning shadow-sm mb-3">
                <div class="card-header bg-warning bg-opacity-10 border-bottom border-warning">
                    <h6 class="mb-0 text-warning fw-bold">
                        <i class="fas fa-exclamation-triangle"></i> Perhatian
                    </h6>
                </div>
                <div class="card-body p-3">
                    <ul class="small mb-0 ps-3">
                        <li class="mb-2">Perubahan akan mempengaruhi semua barang terkait</li>
                        <li class="mb-2">Pastikan nama kategori tetap konsisten</li>
                        <li class="mb-0">Deskripsi membantu dalam klasifikasi barang</li>
                    </ul>
                </div>
                
                <!-- Items Count -->
                @if(isset($kategori->items) && $kategori->items->count() > 0)
                <div class="card-footer bg-light border-top">
                    <small class="text-muted">
                        <i class="fas fa-box"></i> 
                        <strong>{{ $kategori->items->count() }}</strong> barang menggunakan kategori ini
                    </small>
                </div>
                @endif
            </div>

            <!-- History Card -->
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body p-3">
                    <h6 class="mb-3 fw-bold">
                        <i class="fas fa-clock"></i> Riwayat
                    </h6>
                    <div class="row g-2 small text-muted">
                        <div class="col-12">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-calendar-plus me-2 mt-1"></i>
                                <div>
                                    <div class="fw-semibold">Dibuat</div>
                                    <div>{{ $kategori->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-calendar-check me-2 mt-1"></i>
                                <div>
                                    <div class="fw-semibold">Terakhir Diubah</div>
                                    <div>{{ $kategori->updated_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        </div>
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
    border-bottom: 2px solid rgba(0,0,0,0.1);
}

/* Form Styling */
.form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.15);
}

.input-group-text {
    border: 1px solid #dee2e6;
    transition: all 0.3s;
}

.form-control:focus ~ .input-group-text,
.input-group:focus-within .input-group-text {
    border-color: #ffc107;
    background-color: #fff3cd !important;
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

.btn-warning {
    background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
    border: none;
    font-weight: 600;
}

.btn-warning:hover {
    background: linear-gradient(135deg, #ffb300 0%, #ffa000 100%);
}

/* Alert Styling */
.alert {
    border-radius: 0.5rem;
    border: none;
}

.alert-info {
    background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
    color: #0c5460;
}

.alert .badge {
    font-size: 0.9rem;
    padding: 0.4rem 0.6rem;
}

/* Border Colors */
.border-warning {
    border-left-width: 4px !important;
}

/* Character Counter */
.char-count {
    font-size: 0.8rem;
    font-weight: 500;
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
        font-size: 0.8rem !important;
    }

    textarea.form-control {
        min-height: 80px;
    }

    .alert {
        font-size: 0.9rem;
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

.card:nth-child(3) .card {
    animation-delay: 0.2s;
}

/* Focus Visible for Accessibility */
button:focus-visible,
a:focus-visible,
input:focus-visible,
textarea:focus-visible {
    outline: 2px solid #ffc107;
    outline-offset: 2px;
}

/* Gradient backgrounds */
.bg-gradient {
    background-image: linear-gradient(180deg, rgba(255,255,255,.15), rgba(255,255,255,0));
}

/* Card Footer */
.card-footer {
    background-color: #f8f9fa;
    padding: 0.75rem 1rem;
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
    
    // Store original values
    const originalNama = namaInput.value;
    const originalDeskripsi = deskripsiTextarea.value;
    
    // Auto-capitalize first letter
    namaInput.addEventListener('input', function(e) {
        let value = e.target.value;
        e.target.value = value.replace(/\b\w/g, l => l.toUpperCase());
    });
    
    // Character counter for description
    function updateCharCount() {
        const length = deskripsiTextarea.value.length;
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
            deskripsiTextarea.value = deskripsiTextarea.value.substring(0, maxLength);
            charCount.textContent = maxLength;
        }
    }
    
    deskripsiTextarea.addEventListener('input', updateCharCount);
    
    // Detect changes
    function hasChanges() {
        return namaInput.value !== originalNama || 
               deskripsiTextarea.value !== originalDeskripsi;
    }
    
    // Highlight changed fields
    namaInput.addEventListener('input', function() {
        if (this.value !== originalNama) {
            this.classList.add('border-warning', 'border-2');
        } else {
            this.classList.remove('border-warning', 'border-2');
        }
    });
    
    deskripsiTextarea.addEventListener('input', function() {
        if (this.value !== originalDeskripsi) {
            this.classList.add('border-warning', 'border-2');
        } else {
            this.classList.remove('border-warning', 'border-2');
        }
    });
    
    // Form submit handling
    form.addEventListener('submit', function(e) {
        // Check if any changes were made
        if (!hasChanges()) {
            e.preventDefault();
            Swal.fire({
                icon: 'info',
                title: 'Tidak Ada Perubahan',
                text: 'Anda belum melakukan perubahan pada data kategori.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#0d6efd'
            });
            return false;
        }
        
        // Confirm update
        e.preventDefault();
        
        Swal.fire({
            title: 'Update Kategori?',
            html: `Apakah Anda yakin ingin menyimpan perubahan?<br><small class="text-muted">Perubahan akan mempengaruhi semua data terkait.</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-save"></i> Ya, Update',
            cancelButtonText: '<i class="fas fa-times"></i> Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Disable button
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
                
                // Submit form
                form.submit();
            }
        });
    });
    
    // Keyboard shortcut: Ctrl+S to save
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            form.requestSubmit();
        }
    });
    
    // Warn before leaving if there are unsaved changes
    window.addEventListener('beforeunload', function(e) {
        if (hasChanges()) {
            e.preventDefault();
            e.returnValue = '';
            return '';
        }
    });
    
    // Remove warning when form is submitted
    form.addEventListener('submit', function() {
        window.removeEventListener('beforeunload', arguments.callee);
    });
});
</script>
@endsection