@extends('layouts.app')

@section('content')
<h3>Scan QR Code untuk Absensi</h3>

<!-- Container Kamera -->
<div style="width: 100%;">
    <div id="reader" style="width: 500px;"></div>
</div>

<!-- Menampilkan hasil scan -->
<p id="result"></p>

<!-- Form untuk mengirim data ke server -->
<form id="absenForm" action="{{ route('admin.siswa.absen') }}" method="POST">
    @csrf
    <input type="hidden" name="siswa_nis" id="siswa_nis">
</form>

<!-- Load Library -->
<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
 document.addEventListener("DOMContentLoaded", function () {
    console.log("Memulai pemindaian QR Code...");
    let formSubmit = false;
    
    async function onScanSuccess(decodedText, decodedResult) {
        console.log("QR Code Terbaca: " + decodedText);
        document.getElementById("result").innerText = "QR Code Terbaca: " + decodedText;

        // Masukkan ID siswa ke input form
        document.getElementById("siswa_nis").value = decodedText;

        // Submit form otomatis setelah scan, pastikan hanya sekali
        if (!formSubmit) {
            formSubmit = true;
            await document.getElementById("absenForm").submit(); // Tambahkan await untuk memastikan hanya sekali submit
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
                { fps: 10, qrbox: 250 },
                onScanSuccess,
                onScanFailure
            );
        } else {
            console.error("Tidak ada kamera terdeteksi.");
        }
    }).catch(err => {
        console.error("Gagal mengakses kamera: ", err);
    });
});

</script>

@endsection
