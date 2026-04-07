<!doctype html>
<html lang="en">

<head>
    <title>MTT Live Monitor Project Map</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description"
        content="Datta able is trending dashboard template made using Bootstrap 5 design framework." />
    <meta name="keywords" content="Bootstrap admin template, Dashboard UI Kit" />
    <meta name="author" content="Codedthemes" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <link rel="icon" href="../assets/images/favicon.svg" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="../assets/fonts/phosphor/regular/style.css" />
    <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/style-preset.css" />
    <!--js-->
    <!-- LEAFLET -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- SEARCH -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Custom Styling to match the screenshot exactly */
        body {
            background-color: #1a1a1c !important;
        }

        .pc-header {
            background-color: #121213 !important;
            left: 0 !important;
            /* Remove sidebar offset */
            border-bottom: 1px solid #2a2a2a;
        }

        .pc-container {
            margin-left: 0 !important;
            /* Remove sidebar offset */
            padding-top: 30px;
        }

        .top-nav-btn {
            background-color: transparent;
            color: #a0a0a0;
            border: 1px solid #333;
            border-radius: 6px;
            padding: 5px 15px;
            font-size: 13px;
            margin-right: 8px;
        }

        .top-nav-btn.active {
            background-color: #a81c1c;
            color: #fff;
            border-color: #a81c1c;
        }

        .search-bar {
            background-color: transparent;
            border: 1px solid #333;
            border-radius: 6px;
            color: #fff;
            padding: 5px 15px 5px 35px;
            font-size: 13px;
        }

        .search-icon-wrapper {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .card-dark-custom {
            background-color: #212123;
            border: 1px solid #333;
            border-radius: 10px;
        }

        .status-pill {
            height: 18px;
            width: 65px;
            border-radius: 6px;
            display: inline-block;
        }

        .status-pill.danger {
            background-color: #b72b2b;
        }

        .status-pill.success {
            background-color: #23cc38;
        }

        .table-ip th {
            color: #6c757d;
            font-weight: 500;
            font-size: 13px;
            border-bottom: none;
        }

        .table-ip td {
            color: #d1d1d1;
            font-size: 13px;
            vertical-align: middle;
            border-top: 1px solid #2a2a2a;
        }

        .map-btn {
            background-color: transparent;
            color: #a0a0a0;
            border: none;
            font-size: 13px;
            padding: 5px 10px;
        }

        .map-btn.active {
            color: #fff;
        }

        .status-ring {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .status-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
        }

        .ring-success {
            background-color: #d2f4d6;
        }

        .dot-success {
            background-color: #1ab82c;
        }

        .ring-danger {
            background-color: #f4d2d2;
        }

        .dot-danger {
            background-color: #b81a1a;
        }

        /* TAMBAHAN KODE: Style untuk tombol Add Site & Add Project */
        .btn-add-action {
            background-color: #23cc38;
            /* Warna hijau default */
            color: #fff;
            border: 1px solid #23cc38;
            border-radius: 6px;
            padding: 5px 15px;
            font-size: 13px;
            margin-right: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-add-action:hover {
            background-color: #1ea32d;
            border-color: #1ea32d;
        }

        .btn-add-action.active {
            background-color: #000000;
            /* Warna hitam saat aktif */
            border-color: #000000;
            color: #fff;
        }

    </style>
    <style>
        .leaflet-control-geocoder {
            z-index: 9999 !important;
        }

    </style>
</head>

<body data-pc-theme="dark">
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <header class="pc-header">
        <div class="header-wrapper d-flex justify-content-between align-items-center px-4 w-100">

            <div class="d-flex align-items-center">
                <div class="logo me-4 d-flex align-items-center">
                    <img src="{{ asset('assets/images/application/logop.png') }}" alt="Logo"
                        style="height: 40px; width: auto;">
                </div>
            </div>

            <div class="d-flex align-items-center">
                <span id="live-clock" class=" fs-6 me-4 d-none d-xl-block" style="font-size: 13px !important;">
                </span>
                <div class="me-4 rounded-circle bg-dark d-flex align-items-center justify-content-center"
                    style="width: 32px; height: 32px; border: 1px solid #333; overflow: hidden;">

                    <img src="{{ asset('assets/images/application/user.png') }}" alt="User"
                        style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>

        </div>
    </header>
    <div class="pc-container">

        <div class="pc-content">
            <div class="card-header border-0 pb-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-2">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="top-nav-btn active">All Project</button>
                        <button type="button" class="top-nav-btn">Next G</button>
                        <button type="button" class="top-nav-btn">NARA</button>
                        <button type="button" class="top-nav-btn">NARO</button>
                        <button type="button" class="top-nav-btn">CITICON</button>
                    </div>
                    <div class="ms-2 ps-3 d-flex">
                        <button type="button" class="btn btn-success btn-add-action me-2" data-bs-toggle="modal"
                            data-bs-target="#modalLokasi">
                            Tambah Site
                        </button>
                        <div class="modal fade" id="modalLokasi" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Lokasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form id="formLokasi" action="{{ route('site.store') }}" method="POST">
                                        @csrf

                                        <div class="modal-body">

                                            <!-- Projek -->
                                            <div class="mb-3">
                                                <label>Projek</label>
                                                <select name="id_projek" class="form-control">
                                                    <option value="">Pilih Projek</option>
                                                    @foreach($projek as $p)
                                                    <option value="{{ $p->id_projek }}"
                                                        {{ old('id_projek') == $p->id_projek ? 'selected' : '' }}>
                                                        {{ $p->nama_projek }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('id_projek')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- Alamat -->
                                            <div class="mb-3">
                                                <label>Alamat</label>
                                                <input type="text" name="alamat" class="form-control"
                                                    value="{{ old('alamat') }}">
                                                @error('alamat')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- IP -->
                                            <div class="mb-3">
                                                <label>IP Address</label>
                                                <input type="text" name="ip_address" class="form-control"
                                                    value="{{ old('ip_address') }}">
                                                @error('ip_address')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- Tanggal -->
                                            <div class="mb-3">
                                                <label>Tanggal Instalasi</label>
                                                <input type="date" name="tgl_instalasi" class="form-control"
                                                    value="{{ old('tgl_instalasi') }}">
                                                @error('tgl_instalasi')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- Note -->
                                            <div class="mb-3">
                                                <label>Note</label>
                                                <textarea name="note" class="form-control">{{ old('note') }}</textarea>
                                            </div>

                                            <!-- Latitude & Longitude -->
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" name="latitude" id="lat" class="form-control"
                                                        placeholder="Latitude" value="{{ old('latitude') }}" readonly>
                                                    @error('latitude')
                                                    <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="longitude" id="lng" class="form-control"
                                                        placeholder="Longitude" value="{{ old('longitude') }}" readonly>
                                                    @error('longitude')
                                                    <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- MAP -->
                                            <div id="map" style="height:300px; margin-top:15px;"></div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="button" onclick="confirmSimpanLokasi()"
                                                class="btn btn-primary">
                                                Simpan
                                            </button>
                                        </div>
                                    </form>

<script>
let map;
let marker;

document.getElementById('modalLokasi').addEventListener('shown.bs.modal', function () {

    // 🔥 kalau map sudah ada, jangan init ulang
    if (!map) {

        map = L.map('map').setView([-6.2, 106.8], 10);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        // 🔍 SEARCH
        let geocoder = L.Control.geocoder({
            defaultMarkGeocode: false
        })
        .on('markgeocode', function(e) {

            let latlng = e.geocode.center;

            map.setView(latlng, 15);

            if (marker) map.removeLayer(marker);

            marker = L.marker(latlng).addTo(map);

            document.getElementById('lat').value = latlng.lat;
            document.getElementById('lng').value = latlng.lng;

            // isi alamat otomatis
            document.querySelector('[name="alamat"]').value = e.geocode.name;
        })
        .addTo(map);

        // 🖱️ KLIK MAP
        map.on('click', function (e) {

            let lat = e.latlng.lat;
            let lng = e.latlng.lng;

            if (marker) map.removeLayer(marker);

            marker = L.marker([lat, lng]).addTo(map);

            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
        });
    }

    // 🔥 WAJIB (BIAR MAP NORMAL)
    setTimeout(() => {
        map.invalidateSize();
    }, 300);

});
</script>
                                  

<script>
function confirmSimpanLokasi() {

    let projek = document.querySelector('[name="id_projek"]').value;
    let alamat = document.querySelector('[name="alamat"]').value;
    let ip = document.querySelector('[name="ip_address"]').value;
    let tgl = document.querySelector('[name="tgl_instalasi"]').value;
    let lat = document.getElementById('lat').value;
    let lng = document.getElementById('lng').value;

    // VALIDASI
    if (projek === '') {
        Swal.fire('Oops!', 'Projek wajib dipilih!', 'error'); return;
    }
    if (alamat === '') {
        Swal.fire('Oops!', 'Alamat wajib diisi!', 'error'); return;
    }
    if (ip === '') {
        Swal.fire('Oops!', 'IP wajib diisi!', 'error'); return;
    }
    if (tgl === '') {
        Swal.fire('Oops!', 'Tanggal wajib diisi!', 'error'); return;
    }
    if (lat === '' || lng === '') {
        Swal.fire('Oops!', 'Klik map dulu!', 'error'); return;
    }

    // 🔥 TUTUP MODAL
    let modalEl = document.getElementById('modalLokasi');
    let modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) {
        modal.hide();
    }

    // 🔥 LOADING
    Swal.fire({
        title: 'Menyimpan...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    // SUBMIT
    document.getElementById('formLokasi').submit();
}
</script>

                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-add-action" data-bs-toggle="modal"
                            data-bs-target="#modalProjek">
                            <i class="ph ph-plus me-1"></i> Add Project
                        </button>
                    </div>
                </div>

            </div>
            <div class="modal fade" id="modalProjek" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Projek</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- 🔥 TAMBAH ID -->
                        <form id="formProjek" action="{{ route('projek.store') }}" method="POST">
                            @csrf

                            <div class="modal-body">

                                <div class="mb-3">
                                    <label>Nama Projek</label>
                                    <input type="text" name="nama_projek" class="form-control" required>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="button" onclick="confirmSimpan()" class="btn btn-primary">
                                    Simpan
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
            <script>
                function confirmSimpan() {

                    let nama = document.querySelector('[name="nama_projek"]').value;
                    

                    if (nama === '' ) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Nama Projek & Vendor wajib diisi!'
                        });
                        return;
                    }

                    // langsung submit
                    document.getElementById('formProjek').submit();
                }

            </script>
            @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('
                    success ') }}',
                    timer: 2000,
                    showConfirmButton: false
                });
                var modal = bootstrap.Modal.getInstance(document.getElementById('modalProjek'));
                if (modal) {
                    modal.hide();
                }

            </script>
            @endif


            <div class="row">

                <div class="col-xl-9 col-lg-8">
                    <div class="card card-dark-custom h-100">
                        <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
                            <h5 class="text-white mb-0 d-flex align-items-center">
                                <span class="text-danger me-2" style="font-size: 18px; letter-spacing: -2px;">|||</span>
                                MTT Live Monitor Project Map
                            </h5>
                            <!-- PINDAH NAV PROJECT KE SINI -->
                            <div class="d-flex bg-dark"
                                style="border: 1px solid #333; border-radius: 6px; padding: 2px;">
                                <button class="map-btn active"><i class="ph ph-crosshair me-1"></i> Indonesia
                                    View</button>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="map-container"
                                style="width: 100%; height: 600px; border-radius: 8px; overflow: hidden; border: 1px solid #333;">
                                <div id="map-home" style="width: 100%; height: 100%;"></div>
                              <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Inisialisasi Peta
        const mapHome = L.map('map-home').setView([-2.5489, 118.0149], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(mapHome);

        const sites = @json($site);
        const markersCoordinates = [];
        const markerInstances = {}; // Menyimpan referensi marker agar bisa diupdate warnanya

        // 2. Tambahkan Marker ke Peta
        sites.forEach(function(item) {
            if (item.latitude && item.longitude) {
                const lat = parseFloat(item.latitude);
                const lng = parseFloat(item.longitude);
                
                if (!isNaN(lat) && !isNaN(lng)) {
                    // Buat Icon menggunakan divIcon (bukan marker gambar standar)
                    const customIcon = L.divIcon({
                        className: 'status-icon status-checking', // Default: Abu-abu
                        html: ''
                    });

                    const marker = L.marker([lat, lng], { icon: customIcon }).addTo(mapHome);
                    
                    // Simpan referensi marker ke object global berdasarkan ID site
                    markerInstances[item.id_site] = marker;

                    const namaProjek = item.projek ? item.projek.nama_projek : 'Tanpa Projek';

                    // Konten Popup dengan ID status teks agar bisa diupdate
                    const popupContent = `
                        <div style="font-family: sans-serif; min-width: 180px;">
                            <h6 style="margin: 0 0 5px 0; color: #007bff;">${namaProjek}</h6>
                            <hr style="margin: 5px 0;">
                            <table style="width: 100%; font-size: 12px; border-collapse: collapse;">
                                <tr><td><b>Status:</b></td><td><b id="status-text-${item.id_site}" style="color:gray">Checking...</b></td></tr>
                                <tr><td><b>IP:</b></td><td><code>${item.ip_address ?? '-'}</code></td></tr>
                                <tr><td><b>Alamat:</b></td><td>${item.alamat ?? '-'}</td></tr>
                            </table>
                        </div>
                    `;

                    marker.bindPopup(popupContent);
                    markersCoordinates.push([lat, lng]);

                    // Jalankan monitoring untuk site ini
                    monitorIP(item.ip_address, item.id_site);
                }
            }
        });

        // 3. Auto Zoom agar semua marker terlihat
        if (markersCoordinates.length > 0) {
            const bounds = L.latLngBounds(markersCoordinates);
            mapHome.fitBounds(bounds, { padding: [50, 50] });
        }

        // 4. Fungsi Monitoring Real-time
       function monitorIP(ip, siteId) {
    function updateStatus() {
        fetch(`/api/check-status?ip=${ip}`)
            .then(res => res.json())
            .then(data => {
                const marker = markerInstances[siteId];
                if (!marker) return;

                const iconElement = marker.getElement();
                const textStatus = document.getElementById(`status-text-${siteId}`);

                if (!iconElement) return;

                // BERSIHKAN STATUS SEBELUMNYA TANPA MENGHAPUS 'status-icon'
                iconElement.classList.remove('status-online', 'status-offline', 'status-checking');

                if (data.status === 'online') {
                    // Update jadi Hijau
                    iconElement.classList.add('status-online');
                    if(textStatus) {
                        textStatus.innerText = 'ONLINE';
                        textStatus.style.color = 'green';
                    }
                } else {
                    // Update jadi Merah (RTO)
                    iconElement.classList.add('status-offline');
                    if(textStatus) {
                        textStatus.innerText = 'RTO (Offline)';
                        textStatus.style.color = 'red';
                    }
                }
            })
            .catch(err => console.error("Monitor Error:", err));
    }

    updateStatus();
    setInterval(updateStatus, 15000);
}

        // 5. Fix Rendering untuk memastikan map tidak abu-abu
        setTimeout(() => {
            mapHome.invalidateSize();
        }, 300);
    });
</script>
                                
                                
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="nav-projects d-none d-md-flex ms-3 align-items-center">

                    </div>
                    <div class="card card-dark-custom mb-4">
                        <div class="card-header border-0 pb-1">
                            <h5 class="text-white mb-0 d-flex align-items-center">
                                <i class="ph ph-arrows-left-right text-muted me-2 f-20"></i> IP Status
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-ip mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-4">IP</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="ps-4">192.172.60.1</td>
                                            <td>2mins</td>
                                            <td>
                                                <div class="status-pill danger"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ps-4">192.172.60.4</td>
                                            <td>2mins</td>
                                            <td>
                                                <div class="status-pill danger"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ps-4">192.168.1.1</td>
                                            <td>5 mins</td>
                                            <td>
                                                <div class="status-pill success"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ps-4">192.168.1.2</td>
                                            <td>5 mins</td>
                                            <td>
                                                <div class="status-pill success"></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0" style="background-color: #f8f9fa; border-radius: 12px;">
                        <div class="card-body">
                            <h6 class="text-dark fw-bold mb-4 d-flex align-items-center">
                                <span class="bg-danger me-2"
                                    style="width: 4px; height: 14px; border-radius: 2px;"></span> System status
                            </h6>
                            <div class="d-flex justify-content-around text-center mb-2">

                                <div>
                                    <div class="status-ring ring-success mb-2">
                                        <div class="status-dot dot-success"></div>
                                    </div>
                                    <span class="text-success small fw-bold">Connect</span>
                                </div>

                                <div>
                                    <div class="status-ring ring-danger mb-2">
                                        <div class="status-dot dot-danger"></div>
                                    </div>
                                    <span class="text-danger small fw-bold">Error</span>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        function updateClock() {
            const now = new Date();

            const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            const dayName = days[now.getDay()];

            const day = String(now.getDate()).padStart(2, '0');
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const year = now.getFullYear();

            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            const formatted = `${dayName}, ${day}/${month}/${year} &nbsp; ${hours}:${minutes}:${seconds}`;

            document.getElementById("live-clock").innerHTML = formatted;
        }

        // jalanin pertama kali
        updateClock();

        // update tiap 1 detik
        setInterval(updateClock, 1000);

    </script>
    <script src="../assets/js/plugins/popper.min.js"></script>
    <script src="../assets/js/plugins/simplebar.min.js"></script>
    <script src="../assets/js/plugins/bootstrap.min.js"></script>
    <script src="../assets/js/fonts/custom-font.js"></script>
    <script src="../assets/js/pcoded.js"></script>
    <script src="../assets/js/plugins/feather.min.js"></script>
</body>

</html>
