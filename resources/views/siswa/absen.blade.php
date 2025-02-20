@extends('layouts.app')

@section('content')
<div class="d-flex flex-column align-items-center justify-content-center vh-100">
    <h3 class="mb-4 text-primary fw-bold">Scan QR Code untuk Absensi</h3>

    <!-- Alert Messages -->
    @if(session('error'))
        <div class="alert alert-danger" id="alertMessage">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success" id="alertMessage">{{ session('success') }}</div>
    @endif

    <!-- Container Kamera -->
    <div class="card shadow p-3" style="width: 100%; max-width: 400px; border-radius: 12px;">
        <div id="reader" style="width: 100%; height: 300px; border-radius: 10px; overflow: hidden;"></div>
    </div>

    <!-- Menampilkan hasil scan -->
    <div id="resultBox" class="mt-3 d-none">
        <p class="fw-bold text-success">QR Code Terbaca:</p>
        <p id="result" class="bg-light p-2 rounded text-center"></p>
    </div>

    <!-- Form untuk mengirim data ke server -->
    <form id="absenForm" action="{{ route('admin.siswa.absen') }}" method="POST">
        @csrf
        <input type="hidden" name="siswa_nis" id="siswa_nis">
    </form>
</div>

<!-- Load Library -->
<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    console.log("Memulai pemindaian QR Code...");
    let formSubmit = false;

    async function onScanSuccess(decodedText, decodedResult) {
        console.log("QR Code Terbaca: " + decodedText);
        document.getElementById("result").innerText = decodedText;
        
        // Tampilkan hasil scan
        let resultBox = document.getElementById("resultBox");
        resultBox.classList.remove("d-none");
        resultBox.classList.add("bg-white", "shadow-sm", "p-3", "rounded");

        // Masukkan ID siswa ke input form
        document.getElementById("siswa_nis").value = decodedText;

        // Submit form otomatis setelah scan, pastikan hanya sekali
        if (!formSubmit) {
            formSubmit = true;
            await document.getElementById("absenForm").submit();
        }
    }

    function onScanFailure(error) {
        console.warn(`QR scan error: ${error}`);
    }

    let html5QrCode = new Html5Qrcode("reader");

    // Cek apakah browser support kamera
    Html5Qrcode.getCameras().then(devices => {
        if (devices && devices.length) {
            let cameraId = devices[0].id;
            html5QrCode.start(
                cameraId,
                { fps: 10, qrbox: { width: 250, height: 250 } },
                onScanSuccess,
                onScanFailure
            );
        } else {
            console.error("Tidak ada kamera terdeteksi.");
        }
    }).catch(err => {
        console.error("Gagal mengakses kamera: ", err);
    });

    // Auto-hide alert setelah 3 detik
    setTimeout(() => {
        let alertMessage = document.getElementById("alertMessage");
        if (alertMessage) {
            alertMessage.style.display = "none";
        }
    }, 3000);
});
</script>
@endsection
