@extends('layouts.app')

@section('title', 'Booking Kamar')

@push('styles')
<style>
    .payment-info {
        border-left: 4px solid #0d6efd;
        background-color: #f8f9fa;
        border-radius: 10px;
    }
    
    .bank-detail {
        background: white;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .step-icon {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #0d6efd;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 10px;
    }
    
    /* Sidebar sticky */
    .sidebar-wrapper {
        position: sticky;
        top: 20px;
        height: fit-content;
    }
    
    /* Atur jarak antar card */
    .sidebar-card {
        margin-bottom: 15px;
    }
    
    .sidebar-card:last-child {
        margin-bottom: 0;
    }
    
    /* Untuk mobile, nonaktifkan sticky */
    @media (max-width: 992px) {
        .sidebar-wrapper {
            position: relative;
            top: 0;
        }
    }
    
    /* Styling form yang lebih clean */
    .form-control {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 10px 15px;
    }
    
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .form-label {
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
    }
    
    .required-asterisk {
        color: #dc3545;
    }
    
    .form-text {
        font-size: 0.85rem;
        color: #6c757d;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto calculate payment amount berdasarkan harga kamar
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const paymentAmountInput = document.getElementById('payment_amount');
        const pricePerMonth = {{ $room->price }};

        function calculatePayment() {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            if (startDate && endDate && endDate > startDate) {
                // Hitung jumlah bulan
                const months = (endDate.getFullYear() - startDate.getFullYear()) * 12 + 
                               (endDate.getMonth() - startDate.getMonth());
                
                // Total pembayaran (minimal 1 bulan)
                const totalMonths = Math.max(months, 1);
                const totalPayment = pricePerMonth * totalMonths;
                
                paymentAmountInput.value = totalPayment;
                
                // Update display
                document.getElementById('displayPayment').textContent = 
                    'Rp ' + totalPayment.toLocaleString('id-ID');
                document.getElementById('displayMonths').textContent = totalMonths + ' bulan';
                
                // Update untuk instruksi pembayaran
                document.getElementById('paymentAmountDisplay').textContent = 
                    'Rp ' + totalPayment.toLocaleString('id-ID');
            }
        }

        startDateInput.addEventListener('change', calculatePayment);
        endDateInput.addEventListener('change', calculatePayment);
        
        // Hitung otomatis saat halaman dimuat jika ada nilai default
        if (startDateInput.value && endDateInput.value) {
            calculatePayment();
        }
    });
</script>
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="bi bi-calendar-check me-2"></i>Form Booking Kamar Kos</h2>
        <p class="text-muted">Lengkapi form booking dan selesaikan pembayaran</p>
    </div>

    <div class="row g-4">
        <!-- Kolom Kiri: Form -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('penyewa.bookings.store', $room) }}" method="POST" id="bookingForm">
                        @csrf

                        <!-- Room Info -->
                        <div class="mb-4">
                            <div class="d-flex align-items-start">
                                @if($room->image)
                                    <img src="{{ asset('storage/' . $room->image) }}" 
                                         style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;" 
                                         class="me-3">
                                @endif
                                <div>
                                    <h4 class="mb-1">{{ $room->room_name }}</h4>
                                    <p class="mb-1 text-muted">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $room->property->name }}
                                    </p>
                                    <h5 class="text-success mb-0">Rp {{ number_format($room->price, 0, ',', '.') }}/bulan</h5>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Informasi Pembayaran -->
                        <div class="mb-4">
                            <h5 class="mb-3">
                                <i class="bi bi-credit-card me-2"></i>Informasi Pembayaran
                            </h5>
                            
                            <div class="payment-info p-4">
                                <!-- Transfer ke Admin -->
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="step-icon">1</div>
                                        <h6 class="mb-0">Transfer ke Admin</h6>
                                    </div>
                                    <div class="bank-detail">
                                        <table class="table table-borderless table-sm mb-0">
                                            <tr>
                                                <td width="40%"><strong>Bank:</strong></td>
                                                <td><span class="text-primary fw-bold">BRI</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>No. Rekening:</strong></td>
                                                <td class="fw-bold">1234-5678-9012-3456</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Atas Nama:</strong></td>
                                                <td>Admin KostKon</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- Jumlah Transfer -->
                                <div>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="step-icon">2</div>
                                        <h6 class="mb-0">Jumlah Transfer</h6>
                                    </div>
                                    <div class="bank-detail text-center">
                                        <h3 class="text-success mb-2" id="paymentAmountDisplay">Rp 0</h3>
                                        <p class="text-muted mb-0">Jumlah akan terhitung otomatis</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-warning mt-3 mb-0">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Penting!</strong> Simpan bukti transfer untuk diupload setelah booking berhasil.
                            </div>
                        </div>

                        <!-- Form Input -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    Tanggal Mulai Sewa <span class="required-asterisk">*</span>
                                </label>
                                <input type="date" 
                                       id="start_date"
                                       name="start_date" 
                                       class="form-control @error('start_date') is-invalid @enderror" 
                                       value="{{ old('start_date') }}" 
                                       min="{{ date('Y-m-d') }}" 
                                       required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Pilih tanggal mulai tinggal di kos</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Tanggal Akhir Sewa <span class="required-asterisk">*</span>
                                </label>
                                <input type="date" 
                                       id="end_date"
                                       name="end_date" 
                                       class="form-control @error('end_date') is-invalid @enderror" 
                                       value="{{ old('end_date') }}" 
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                                       required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Pilih tanggal selesai sewa kos</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Jumlah Pembayaran (Rp) <span class="required-asterisk">*</span>
                            </label>
                            <input type="number" 
                                   id="payment_amount"
                                   name="payment_amount" 
                                   class="form-control @error('payment_amount') is-invalid @enderror" 
                                   value="{{ old('payment_amount') }}" 
                                   min="0" 
                                   readonly
                                   required>
                            @error('payment_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Dihitung otomatis berdasarkan durasi sewa (per bulan)</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan Tambahan (Opsional)</label>
                            <textarea name="notes" 
                                      class="form-control @error('notes') is-invalid @enderror" 
                                      rows="3" 
                                      placeholder="Contoh: Permintaan khusus, kebutuhan tambahan, dll...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Syarat dan Ketentuan -->
                        <div class="form-check mb-4">
                            <input class="form-check-input @error('terms') is-invalid @enderror" 
                                   type="checkbox" 
                                   name="terms" 
                                   id="terms" 
                                   required>
                            <label class="form-check-label" for="terms">
                                Saya setuju dengan <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">syarat dan ketentuan</a> pembayaran
                            </label>
                            @error('terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- FAQ Section -->
                        <div class="mb-4">
                            <h6 class="mb-3">
                                <i class="bi bi-question-circle me-2"></i>Pertanyaan Umum
                            </h6>
                            <div class="accordion" id="faqAccordion">
                                <div class="accordion-item border">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                            Bagaimana cara upload bukti transfer?
                                        </button>
                                    </h2>
                                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Setelah booking, Anda akan diarahkan ke halaman dashboard. Klik menu "Booking Saya" dan pilih booking yang baru dibuat. Klik tombol "Upload Bukti Transfer" dan pilih file gambar.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item border">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                            Kapan bisa menempati kamar?
                                        </button>
                                    </h2>
                                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Anda bisa menempati kamar sesuai tanggal mulai sewa yang dipilih. Silakan datang ke lokasi kos dengan membawa KTP dan bukti pembayaran yang sudah diverifikasi.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item border">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                            Apakah perlu deposit keamanan?
                                        </button>
                                    </h2>
                                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Ya, biasanya diperlukan deposit keamanan sebesar Rp 500.000 - Rp 1.000.000 yang akan dikembalikan saat Anda pindah dengan kondisi kamar yang baik.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-flex gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-primary btn-lg px-4" id="submitBtn">
                                <i class="bi bi-check-circle me-2"></i>Konfirmasi Booking
                            </button>
                            <a href="{{ route('penyewa.rooms.show', $room) }}" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Sidebar -->
        <div class="col-lg-4">
            <div class="sidebar-wrapper">
                <!-- Summary Card -->
                <div class="card shadow-sm border-0 sidebar-card">
                    <div class="card-header bg-success text-white border-0">
                        <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Ringkasan Booking</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td width="40%"><strong>Kamar:</strong></td>
                                <td>{{ $room->room_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Lokasi:</strong></td>
                                <td>{{ $room->property->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Ukuran:</strong></td>
                                <td>{{ $room->size }} m²</td>
                            </tr>
                        </table>
                        <hr>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td width="60%"><strong>Harga per Bulan:</strong></td>
                                <td class="text-end text-success">Rp {{ number_format($room->price, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Durasi Sewa:</strong></td>
                                <td class="text-end text-primary" id="displayMonths">-</td>
                            </tr>
                            <tr>
                                <td><strong>Total Pembayaran:</strong></td>
                                <td class="text-end">
                                    <h5 class="text-success mb-0" id="displayPayment">Rp 0</h5>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Informasi Penting -->
                <div class="card shadow-sm border-0 sidebar-card">
                    <div class="card-header bg-warning text-dark border-0">
                        <h6 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Informasi Penting</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="alert alert-light border mb-2 p-2">
                            <small>
                                <i class="bi bi-calendar-check text-primary me-1"></i>
                                <strong>Tanggal Masuk:</strong> Sesuai yang dipilih
                            </small>
                        </div>
                        <div class="alert alert-light border mb-2 p-2">
                            <small>
                                <i class="bi bi-cash-coin text-success me-1"></i>
                                <strong>Deposit:</strong> Rp 500.000 (refundable)
                            </small>
                        </div>
                        <div class="alert alert-light border p-2">
                            <small>
                                <i class="bi bi-clock-history text-info me-1"></i>
                                <strong>Verifikasi:</strong> 1x24 jam kerja
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Contact Card -->
                <div class="card shadow-sm border-0 sidebar-card">
                    <div class="card-header bg-info text-white border-0">
                        <h6 class="mb-0"><i class="bi bi-headset me-2"></i>Butuh Bantuan?</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-whatsapp text-success me-2 fs-5"></i>
                            <div>
                                <small class="d-block">WhatsApp Admin</small>
                                <strong>+62 895-1067-5368</strong>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-envelope text-primary me-2 fs-5"></i>
                            <div>
                                <small class="d-block">Email</small>
                                <strong>admin@kostkon.com</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="card shadow-sm border-0 sidebar-card">
                    <div class="card-header bg-light border-0">
                        <h6 class="mb-0"><i class="bi bi-lightbulb text-warning me-2"></i>Tips Booking Kos</h6>
                    </div>
                    <div class="card-body p-3">
                        <small class="d-block mb-1">✓ Pastikan tanggal sesuai kebutuhan</small>
                        <small class="d-block mb-1">✓ Transfer ke rekening resmi</small>
                        <small class="d-block">✓ Simpan bukti transfer dengan baik</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-file-text me-2"></i>Syarat dan Ketentuan Sewa Kos
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>Ketentuan Pembayaran:</h6>
                <ol>
                    <li>Pembayaran dilakukan melalui transfer bank ke rekening admin KostKon</li>
                    <li>Booking hanya akan diproses setelah pembayaran diverifikasi</li>
                    <li>Waktu verifikasi maksimal 1x24 jam pada hari kerja</li>
                    <li>Pembayaran pertama minimal 1 bulan sewa + deposit keamanan</li>
                    <li>Deposit akan dikembalikan saat check-out jika tidak ada kerusakan</li>
                </ol>
                
                <h6 class="mt-4">Ketentuan Sewa:</h6>
                <ol>
                    <li>Durasi sewa minimal 1 bulan</li>
                    <li>Pembayaran bulanan di awal setiap bulan</li>
                    <li>Tidak boleh sub-let/menyewakan kembali kepada pihak lain</li>
                    <li>Dilarang membawa tamu menginap tanpa izin</li>
                    <li>Wajib menjaga kebersihan dan ketertiban kos</li>
                </ol>
                
                <h6 class="mt-4">Rekening Resmi KostKon:</h6>
                <div class="alert alert-info">
                    <p class="mb-1"><strong>Bank:</strong> BRI (Bank Rakyat Indonesia)</p>
                    <p class="mb-1"><strong>Nomor Rekening:</strong> 1234-5678-9012-3456</p>
                    <p class="mb-0"><strong>Atas Nama:</strong> ADMIN KOSTKON</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Saya Mengerti</button>
            </div>
        </div>
    </div>
</div>
@endsection