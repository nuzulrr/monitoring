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
    <link rel="stylesheet" href="../assets/css/app.css" />
    <!--js-->
    <!-- LEAFLET -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://teastman.github.io/Leaflet.pattern/leaflet.pattern.js"></script>
    <!-- SEARCH -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <div class="dropdown">
                    <a href="#" class="me-4 rounded-circle bg-dark d-flex align-items-center justify-content-center"
                        id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false"
                        style="width: 32px; height: 32px; border: 1px solid #333; overflow: hidden; cursor: pointer;">

                        <img src="{{ asset('assets/images/application/user.png') }}" alt="User"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow" aria-labelledby="dropdownUser"
                        style="border: 1px solid #333;">
                        <li>
                            <h6 class="dropdown-header">{{ Auth::user()->name }}</h6>
                        </li>
                        <li>
                            <hr class="dropdown-divider" style="border-color: #444;">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a>
                        </li>
                    </ul>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>

        </div>
    </header>
    <div class="pc-container">

        <div class="pc-content">
            <div class="card-header border-0 pb-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-2">
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <button type="button" class="top-nav-btn active" data-kategori="all">All</button>
                        <button type="button" class="top-nav-btn" data-kategori="1">Coklat</button>
                        <button type="button" class="top-nav-btn" data-kategori="2">Hijau</button>
                        <button type="button" class="top-nav-btn" data-kategori="3">Loreng</button>
                    </div>
                    <div class="ms-2 ps-3 d-flex">
                        <button type="button" class="btn btn-success btn-add-action me-2" data-bs-toggle="modal"
                            data-bs-target="#modalLokasi">
                            Tambah Site
                        </button>

                        <!-- MODAL TAMBAH SITE -->
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
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Kategori Projek Utama</label>
                                                    <select name="id_projek" id="select-id-projek" class="form-select"
                                                        required>
                                                        <option value="">-- Pilih Projek --</option>
                                                        @foreach($projek as $p)
                                                        <option value="{{ $p->id_projek }}">{{ $p->nama_projek }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Kategori Instansi</label>
                                                    <select name="kategori" class="form-select" required>
                                                        <option value="">-- Pilih Kategori --</option>
                                                        <option value="1">Coklat</option>
                                                        <option value="2">Hijau </option>
                                                        <option value="3">Oren </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Nama Site / Detail Projek</label>
                                                <input type="text" name="projek" id="input-projek-manual"
                                                    class="form-control" placeholder="" required>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">IP Address</label>
                                                    <input type="text" name="ip_address" class="form-control"
                                                        placeholder="" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Tanggal Instalasi</label>
                                                    <input type="date" name="tgl_instalasi" class="form-control"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Catatan</label>
                                                <textarea name="note" class="form-control" rows="3"
                                                    placeholder="Tambahkan catatan tambahan di sini..."></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Alamat Lengkap</label>
                                                <input type="text" name="alamat" id="input-alamat" class="form-control"
                                                    placeholder="Pilih lokasi di peta..." required>
                                            </div>

                                            <div class="mb-2">
                                                <div id="map"
                                                    style="height:350px; width: 100%; border-radius: 8px; border: 1px solid #ddd;">
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Lat</span>
                                                        <input type="text" name="latitude" id="lat" class="form-control"
                                                            readonly required>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Lng</span>
                                                        <input type="text" name="longitude" id="lng"
                                                            class="form-control" readonly required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="btnSimpan" onclick="confirmSimpanLokasi()"
                                                class="btn btn-primary">
                                                <span id="textSimpan">Simpan Site</span>
                                                <span id="loadingSimpan" class="spinner-border spinner-border-sm d-none"
                                                    role="status" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                    </form>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            // --- 1. INISIALISASI PETA ---
                                            const map = L.map('map').setView([-6.200000, 106.816666], 13);
                                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png')
                                                .addTo(map);
                                            let marker = L.marker([-6.200000, 106.816666], {
                                                draggable: true
                                            }).addTo(map);

                                            const inputAlamat = document.getElementById('input-alamat');
                                            const inputLat = document.getElementById('lat');
                                            const inputLng = document.getElementById('lng');

                                            function updateLocation(lat, lng, address = null) {
                                                inputLat.value = lat.toFixed(8);
                                                inputLng.value = lng.toFixed(8);
                                                if (address) inputAlamat.value = address;
                                            }

                                            // Ambil alamat saat peta diklik
                                            map.on('click', (e) => {
                                                marker.setLatLng(e.latlng);
                                                fetch(
                                                        `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${e.latlng.lat}&lon=${e.latlng.lng}`
                                                    )
                                                    .then(res => res.json())
                                                    .then(data => updateLocation(e.latlng.lat, e.latlng
                                                        .lng, data.display_name));
                                            });

                                            // --- FIX MODAL: Peta Abu-abu & Input Null ---
                                            const myModal = document.getElementById('modalLokasi');
                                            if (myModal) {
                                                myModal.addEventListener('shown.bs.modal', function () {
                                                    map.invalidateSize(); // Perbaiki tampilan peta
                                                    // Paksa input manual kosong agar teks "null" hilang total
                                                    document.getElementById('input-projek-manual')
                                                        .value = '';
                                                });
                                            }
                                        });

                                        // --- 3. FUNGSI SIMPAN DENGAN LOADING & SWAL ---
                                        function confirmSimpanLokasi() {
                                            const form = document.getElementById('formLokasi');
                                            const btn = document.getElementById('btnSimpan');
                                            const text = document.getElementById('textSimpan');
                                            const loading = document.getElementById('loadingSimpan');

                                            if (!form.checkValidity()) {
                                                form.reportValidity();
                                                return;
                                            }

                                            Swal.fire({
                                                title: 'Simpan Data Site?',
                                                icon: 'question',
                                                showCancelButton: true,
                                                confirmButtonText: 'Ya, Simpan',
                                                cancelButtonText: 'Batal'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    // Jalankan Efek Loading
                                                    btn.disabled = true;
                                                    text.innerText = 'Menyimpan...';
                                                    loading.classList.remove('d-none');

                                                    // Kirim Data
                                                    form.submit();
                                                }
                                            });
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


                    if (nama === '') {
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

                <div class="col-12 mb-3">
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
                            <div class="map-container position-relative"
                                style="width: 100%; height: 600px; border-radius: 8px; overflow: hidden; border: 1px solid #333;">

                                <!-- MAP -->
                                <div id="map-home" style="width: 100%; height: 100%;"></div>

                                <!-- OVERLAY CLICK -->
                                <div id="map-overlay" style="position:absolute;top:0;left:0;width:100%;height:100%;
                    display:flex;align-items:center;justify-content:center;
                    color:white;font-size:14px;cursor:pointer;z-index:999;">

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">

                    <!-- 🔥 LIVE IP MONITORING (BESAR) -->
                    <div class="col-xl-9 col-lg-8">
                        <div class="card card-dark-custom mb-4 h-100">
                            <div class="card-header border-0 pb-1 d-flex justify-content-between align-items-center">
                                <h5 class="text-white mb-0 d-flex align-items-center">
                                    <i class="ph ph-arrows-left-right text-muted me-2 f-20"></i> Live IP Monitoring
                                </h5>

                                <div class="ms-auto" style="min-width: 250px;">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-dark border-secondary text-muted">
                                            <i class="ph ph-magnifying-glass"></i>
                                        </span>
                                        <input type="text" id="tableSearch"
                                            class="form-control bg-dark border-secondary text-white"
                                            placeholder="Cari Nama Site atau IP...">
                                    </div>
                                </div>
                            </div>
                            <!-- search -->
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const searchInput = document.getElementById('tableSearch');

                                    // Pastikan menunjuk ke tbody yang menampung data sites
                                    const tableBody = document.querySelector('table tbody');

                                    searchInput.addEventListener('keyup', function () {
                                        const searchTerm = this.value.toLowerCase();
                                        const rows = tableBody.getElementsByTagName('tr');

                                        for (let i = 0; i < rows.length; i++) {

                                            const siteCol = rows[i].getElementsByTagName('td')[0];
                                            const ipCol = rows[i].getElementsByTagName('td')[1];

                                            if (siteCol && ipCol) {
                                                const siteText = siteCol.textContent || siteCol
                                                    .innerText;
                                                const ipText = ipCol.textContent || ipCol.innerText;

                                                // Cek apakah searchTerm ada di Nama Site ATAU IP Address
                                                if (siteText.toLowerCase().indexOf(searchTerm) > -1 ||
                                                    ipText.toLowerCase().indexOf(searchTerm) > -1) {
                                                    rows[i].style.display = "";
                                                } else {
                                                    rows[i].style.display = "none";
                                                }
                                            }
                                        }
                                    });
                                });

                            </script>

                            <div class="card-body p-0">
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table table-ip mb-0">
                                        <thead>
                                            <tr>
                                                <th class="ps-4">Project</th>
                                                <th>IP Address</th>
                                                <th class="text-center">Instansi</th>
                                                <th class="text-center">Time</th>
                                                <th class="text-center">Status</th>
                                                <th>Alamat</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($sites as $s)
                                            @php $ipId = str_replace('.', '-', $s->ip_address); @endphp
                                            <tr id="site-row-{{ $s->id_site }}" data-kategori="{{ $s->kategori }}">

                                                <td class="ps-4 text-white fw-bold">
                                                    {{ $s->projek_ref->nama_projek ?? '' }} - {{ $s->projek ?? '-' }}
                                                </td>

                                                <td class="text-white font-monospace">
                                                    {{ $s->ip_address }}
                                                </td>
                                                <td class="text-white text-center">
                                                    {{ $s->kategori == '1' ? 'Coklat' : ($s->kategori == '2' ? 'Hijau' : ($s->kategori == '3' ? 'Loreng' : '-')) }}
                                                </td>

                                                <td class="text-center">
                                                    <strong id="ping-value-{{ $ipId }}" class="text-info">--</strong>
                                                    <small class="text-muted">ms</small>
                                                </td>

                                                <td class="text-center">
                                                    <div id="dot-{{ $ipId }}" class="status-pill warning"></div>
                                                </td>

                                                <td class="text-white">
                                                    {{ $s->alamat ?? '-' }}
                                                </td>

                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm">
                                                        <button type="button"
                                                            class="btn btn-outline-primary border-0 btn-edit"
                                                            data-id="{{ $s->id_site }}"
                                                            data-projek_id="{{ $s->id_projek }}"
                                                            data-projek_val="{{ $s->projek }}"
                                                            data-ip="{{ $s->ip_address }}"
                                                            data-alamat="{{ $s->alamat }}" data-lat="{{ $s->latitude }}"
                                                            data-lng="{{ $s->longitude }}"
                                                            data-tgl="{{ $s->tgl_instalasi }}"
                                                            data-note="{{ $s->note }}" data-bs-toggle="modal"
                                                            data-bs-target="#modalEdit">
                                                            <i class="ph ph-pencil"></i>
                                                        </button>
                                                        <script>
                                                            document.querySelectorAll('.btn-edit').forEach(button => {
                                                                button.addEventListener('click', function () {

                                                                    // 1. Ambil data dari atribut tombol yang diklik
                                                                    const id = this.getAttribute(
                                                                        'data-id');
                                                                    const idProjek = this.getAttribute(
                                                                        'data-projek_id');
                                                                    const projekVal = this.getAttribute(
                                                                        'data-projek_val');
                                                                    const ip = this.getAttribute(
                                                                        'data-ip');
                                                                    const alamat = this.getAttribute(
                                                                        'data-alamat');
                                                                    const tgl = this.getAttribute(
                                                                        'data-tgl');
                                                                    const note = this.getAttribute(
                                                                        'data-note');
                                                                    const lat = this.getAttribute(
                                                                        'data-lat');
                                                                    const lng = this.getAttribute(
                                                                        'data-lng');

                                                                    // 2. Ambil elemen form di dalam modal
                                                                    const modal = document
                                                                        .getElementById('modalEdit');
                                                                    const form = document
                                                                        .getElementById('formEdit');


                                                                    // 3. Set Action URL Form (sesuaikan dengan route update Anda)
                                                                    form.action = `/site/${id}`;

                                                                    // 4. Isi field input (Gunakan pengecekan agar tidak muncul teks "null")
                                                                    form.querySelector(
                                                                            'select[name="id_projek"]')
                                                                        .value = idProjek;
                                                                    form.querySelector(
                                                                            'input[name="projek"]')
                                                                        .value = (projekVal ===
                                                                            'null' || !projekVal) ? '' :
                                                                        projekVal;
                                                                    form.querySelector(
                                                                            'input[name="ip_address"]')
                                                                        .value = (ip === 'null' || !
                                                                            ip) ? '' : ip;
                                                                    form.querySelector(
                                                                            'input[name="alamat"]')
                                                                        .value = (alamat === 'null' || !
                                                                            alamat) ? '' : alamat;
                                                                    form.querySelector(
                                                                        'input[name="tgl_instalasi"]'
                                                                    ).value = tgl;
                                                                    form.querySelector(
                                                                            'textarea[name="note"]')
                                                                        .value = (note === 'null' || !
                                                                            note) ? '' : note;
                                                                    form.querySelector(
                                                                            'input[name="latitude"]')
                                                                        .value = lat;
                                                                    form.querySelector(
                                                                            'input[name="longitude"]')
                                                                        .value = lng;

                                                                    // 5. Update Peta di Modal Edit (Jika menggunakan Leaflet)
                                                                    // Pastikan variabel mapEdit dan markerEdit sudah Anda inisialisasi sebelumnya
                                                                    setTimeout(() => {
                                                                        if (typeof mapEdit !==
                                                                            'undefined') {
                                                                            mapEdit
                                                                                .invalidateSize();
                                                                            const
                                                                                targetLatLng = [
                                                                                    lat, lng
                                                                                ];
                                                                            mapEdit.setView(
                                                                                targetLatLng,
                                                                                15);
                                                                            markerEdit
                                                                                .setLatLng(
                                                                                    targetLatLng
                                                                                );
                                                                        }
                                                                    }, 300);
                                                                });
                                                            });

                                                        </script>

                                                        <button type="button"
                                                            class="btn btn-outline-danger border-0 btn-delete-trigger"
                                                            data-id="{{ $s->id_site }}">
                                                            <i class="ph ph-trash f-18"></i>
                                                        </button>
                                                    </div>
                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 🔥 SYSTEM STATUS (KECIL DI SAMPING) -->
                    <div class="col-xl-3 col-lg-4">
                        <div class="card border-0 h-100 d-flex justify-content-center"
                            style="background-color: #f8f9fa; border-radius: 12px;">

                            <div class="card-body text-center">
                                <h6 class="text-dark fw-bold mb-4 d-flex align-items-center justify-content-center">
                                    <span class="bg-danger me-2"
                                        style="width: 4px; height: 14px; border-radius: 2px;"></span>
                                    System Status
                                </h6>

                                <div class="d-flex justify-content-around">

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
                <div class="modal fade" id="modalEdit" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Edit Lokasi Site</h5>
                                <button type="button" class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <form id="formEdit" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label>Projek</label>
                                            <select name="id_projek" id="edit-id-projek" class="form-control">
                                                @foreach($projek as $p)
                                                <option value="{{ $p->id_projek }}">{{ $p->nama_projek }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Nama Site</label>
                                            <input type="text" name="projek" id="edit-projek-manual"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label>Kategori</label>
                                            <select name="kategori" id="edit-kategori" class="form-control">
                                                <option value="1">Coklat</option>
                                                <option value="2">Hijau</option>
                                                <option value="3">Oren</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>IP Address</label>
                                            <input type="text" name="ip_address" id="edit-ip-address"
                                                class="form-control">
                                            <div id="ip-feedback" class="small mt-1"></div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label>Alamat</label>
                                        <textarea name="alamat" id="edit-alamat" class="form-control"
                                            rows="2"></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label>Tanggal Instalasi</label>
                                            <input type="date" name="tgl_instalasi" id="edit-tgl" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Note</label>
                                            <input type="text" name="note" id="edit-note" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col"><input type="text" name="latitude" id="edit-lat"
                                                class="form-control bg-light" readonly></div>
                                        <div class="col"><input type="text" name="longitude" id="edit-lng"
                                                class="form-control bg-light" readonly></div>
                                    </div>

                                    <div id="map-edit"
                                        style="height:300px; border-radius: 8px; border: 1px solid #ddd;"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" id="btn-save-edit" class="btn btn-primary">Simpan
                                        Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <script>
    let editMap, editMarker;
    const modalEditEl = document.getElementById('modalEdit');
    const inputIp = document.getElementById('edit-ip-address');
    const ipFeedback = document.getElementById('ip-feedback');
    const inputAlamat = document.getElementById('edit-alamat'); // Input alamat
    const btnSave = document.getElementById('btn-save-edit');

    // 1. Fungsi Ambil Alamat Otomatis (Reverse Geocoding)
    function fetchAddress(lat, lng) {
        inputAlamat.value = "Mencari alamat..."; // Loading state
        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
            .then(res => res.json())
            .then(data => {
                // Mengisi kolom alamat dengan hasil pencarian lokasi
                inputAlamat.value = data.display_name || "Alamat tidak ditemukan";
            })
            .catch(() => { 
                inputAlamat.value = "Gagal mengambil alamat otomatis"; 
            });
    }

    // 2. Event saat tombol Edit diklik (Inisialisasi Modal)
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function () {
            const d = this.dataset;
            document.getElementById('formEdit').action = `/sites/${d.id}`;
            modalEditEl.dataset.id = d.id;
            modalEditEl.dataset.lat = d.lat;
            modalEditEl.dataset.lng = d.lng;

            document.getElementById('edit-id-projek').value = d.projek_id;
            document.getElementById('edit-projek-manual').value = (d.projek_val === 'null') ? '' : d.projek_val;
            document.getElementById('edit-kategori').value = d.kategori || '';
            inputIp.value = (d.ip === 'null') ? '' : d.ip;
            inputAlamat.value = (d.alamat === 'null') ? '' : d.alamat;
            document.getElementById('edit-tgl').value = d.tgl;
            document.getElementById('edit-note').value = (d.note === 'null' || !d.note) ? '' : d.note;
            document.getElementById('edit-lat').value = d.lat;
            document.getElementById('edit-lng').value = d.lng;

            inputIp.classList.remove('is-invalid', 'is-valid');
            ipFeedback.innerText = "";
            btnSave.disabled = false;
        });
    });

    // 3. Logika Map, Marker, dan Search Box
    modalEditEl.addEventListener('shown.bs.modal', function () {
        const lat = parseFloat(this.dataset.lat) || -6.200;
        const lng = parseFloat(this.dataset.lng) || 106.816;

        if (!editMap) {
            editMap = L.map('map-edit').setView([lat, lng], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(editMap);
            editMarker = L.marker([lat, lng], { draggable: true }).addTo(editMap);

            // Fungsi Sinkronisasi Koordinat & Alamat
            const syncLocation = (nLat, nLng) => {
                document.getElementById('edit-lat').value = nLat.toFixed(8);
                document.getElementById('edit-lng').value = nLng.toFixed(8);
                fetchAddress(nLat, nLng); // Panggil fungsi auto-fill alamat
            };

            // Klik pada peta untuk pindah marker
            editMap.on('click', (e) => {
                editMarker.setLatLng(e.latlng);
                syncLocation(e.latlng.lat, e.latlng.lng);
            });

            // Geser marker manual
            editMarker.on('dragend', () => {
                const p = editMarker.getLatLng();
                syncLocation(p.lat, p.lng);
            });

            // --- FITUR SEARCH (Pencarian Lokasi) ---
            const geocoder = L.Control.geocoder({
                defaultMarkGeocode: false,
                placeholder: "Cari lokasi atau alamat...",
                errorMessage: "Lokasi tidak ditemukan."
            })
            .on('markgeocode', function(e) {
                const center = e.geocode.center;
                editMarker.setLatLng(center); // Pindah marker ke hasil pencarian
                editMap.setView(center, 15); // Zoom ke lokasi
                syncLocation(center.lat, center.lng); // Update input & alamat
            })
            .addTo(editMap);

        } else {
            // Jika map sudah ada, tinggal update posisi sesuai data site yang diklik
            editMap.setView([lat, lng], 15);
            editMarker.setLatLng([lat, lng]);
        }
        
        // Memperbaiki rendering peta yang kadang abu-abu saat modal muncul
        setTimeout(() => { editMap.invalidateSize(); }, 200);
    });
</script>

            </div>
        </div>
    </div>
    </div>
    <script>
        // Modal Lokasi: Inisialisasi Leaflet dan Interaksi  
        let map;
        let marker;

        document.getElementById('modalLokasi').addEventListener('shown.bs.modal',
            function () {

                // 🔥 kalau map sudah ada, jangan init ulang
                if (!map) {

                    map = L.map('map').setView([-6.2, 106.8], 10);

                    L.tileLayer(
                        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; OpenStreetMap'
                        }).addTo(map);

                    // 🔍 SEARCH
                    let geocoder = L.Control.geocoder({
                            defaultMarkGeocode: false
                        })
                        .on('markgeocode', function (e) {

                            let latlng = e.geocode.center;

                            map.setView(latlng, 15);

                            if (marker) map.removeLayer(marker);

                            marker = L.marker(latlng).addTo(map);

                            document.getElementById('lat').value = latlng.lat;
                            document.getElementById('lng').value = latlng.lng;

                            // isi alamat otomatis
                            document.querySelector('[name="alamat"]').value = e
                                .geocode.name;
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

        function confirmSimpanLokasi() {

            let projek = document.querySelector('[name="id_projek"]').value;
            let alamat = document.querySelector('[name="alamat"]').value;
            let ip = document.querySelector('[name="ip_address"]').value;
            let tgl = document.querySelector('[name="tgl_instalasi"]').value;
            let lat = document.getElementById('lat').value;
            let lng = document.getElementById('lng').value;

            // VALIDASI
            if (projek === '') {
                Swal.fire('Oops!', 'Projek wajib dipilih!', 'error');
                return;
            }
            if (alamat === '') {
                Swal.fire('Oops!', 'Alamat wajib diisi!', 'error');
                return;
            }
            if (ip === '') {
                Swal.fire('Oops!', 'IP wajib diisi!', 'error');
                return;
            }
            if (tgl === '') {
                Swal.fire('Oops!', 'Tanggal wajib diisi!', 'error');
                return;
            }
            if (lat === '' || lng === '') {
                Swal.fire('Oops!', 'Klik map dulu!', 'error');
                return;
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


        let mapHome;
        let markerInstances = {}; // 🔥 GLOBAL (WAJIB)
        let activeIntervals = {};

        document.addEventListener('DOMContentLoaded', function () {

            // =========================
            // 🔥 INIT MAP
            // =========================
            mapHome = L.map('map-home', {
                scrollWheelZoom: false,
                dragging: false,
                touchZoom: false,
                doubleClickZoom: false,
                boxZoom: false,
                keyboard: false
            }).setView([-2.5489, 118.0149], 5);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(mapHome);

            const sites = @json($sites);
            const markersCoordinates = [];

            // =========================
            // 🔥 CREATE MARKERS
            // =========================
            sites.forEach(function (item) {

                if (!item.latitude || !item.longitude) return;

                const lat = parseFloat(item.latitude);
                const lng = parseFloat(item.longitude);

                if (isNaN(lat) || isNaN(lng)) return;

                const customIcon = L.divIcon({
                    className: 'status-icon status-checking',
                    html: ''
                });

                const marker = L.marker([lat, lng], {
                    icon: customIcon
                }).addTo(mapHome);

                // 🔥 SIMPAN GLOBAL
                markerInstances[item.id_site] = marker;

                const namaProjek = (item.projek_ref && item.projek_ref.nama_projek) ?
                    item.projek_ref.nama_projek :
                    (item.projek || 'Tanpa Nama Projek');

                const popupContent = `
            <div style="font-family: sans-serif; min-width: 180px;">
                <h6 style="margin:0 0 5px 0;color:#007bff;">
                    ${namaProjek} - ${item.projek ?? '-'}
                </h6>
                <hr style="margin:5px 0;">
                <table style="width:100%;font-size:12px;">
                    <tr><td><b>Status:</b></td><td><b id="status-text-${item.id_site}" style="color:gray">Checking...</b></td></tr>
                    <tr><td><b>IP:</b></td><td>${item.ip_address ?? '-'}</td></tr>
                    <tr><td><b>Alamat:</b></td><td>${item.alamat ?? '-'}</td></tr>
                </table>
            </div>
        `;

                marker.bindPopup(popupContent);
                markersCoordinates.push([lat, lng]);
            });

            // =========================
            // 🔥 AUTO FIT BOUNDS
            // =========================
            if (markersCoordinates.length > 0) {
                mapHome.fitBounds(L.latLngBounds(markersCoordinates), {
                    padding: [50, 50]
                });
            }

            // =========================
            // 🔥 FILTER LOGIC (INI INTI)
            // =========================
            const filterButtons = document.querySelectorAll('.top-nav-btn');
            const rows = document.querySelectorAll('tbody tr');

            filterButtons.forEach(btn => {
                btn.addEventListener('click', function () {

                    // ACTIVE BUTTON
                    filterButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    const selectedKategori = this.getAttribute('data-kategori');

                    // =========================
                    // 🔥 FILTER TABLE
                    // =========================
                    rows.forEach(row => {
                        const kategori = row.getAttribute('data-kategori');

                        if (selectedKategori === 'all' || kategori ===
                            selectedKategori) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // =========================
                    // 🔥 FILTER MARKER
                    // =========================
                    sites.forEach(site => {

                        const marker = markerInstances[site.id_site];
                        if (!marker) return;

                        if (selectedKategori === 'all' || site.kategori ===
                            selectedKategori) {

                            if (!mapHome.hasLayer(marker)) {
                                mapHome.addLayer(marker);
                            }

                        } else {

                            if (mapHome.hasLayer(marker)) {
                                mapHome.removeLayer(marker);
                            }
                        }
                    });

                });
            });

            // =========================
            // 🔥 MAP INTERACTION CONTROL (BIAR GA KEGESER)
            // =========================
            const mapContainer = document.getElementById('map-home');
            const overlay = document.getElementById('map-overlay');

            function enableMap() {
                mapHome.scrollWheelZoom.enable();
                mapHome.dragging.enable();
                mapHome.touchZoom.enable();
                mapHome.doubleClickZoom.enable();
                mapHome.boxZoom.enable();
                mapHome.keyboard.enable();
            }

            function disableMap() {
                mapHome.scrollWheelZoom.disable();
                mapHome.dragging.disable();
                mapHome.touchZoom.disable();
                mapHome.doubleClickZoom.disable();
                mapHome.boxZoom.disable();
                mapHome.keyboard.disable();
            }

            overlay.addEventListener('click', () => {
                overlay.style.display = 'none';
                enableMap();
            });

            mapContainer.addEventListener('mouseleave', () => {
                disableMap();
                overlay.style.display = 'flex';
            });

            // FIX RENDER
            setTimeout(() => {
                mapHome.invalidateSize();
            }, 300);

        });
        // Delete Site dengan SweetAlert2 dan Fetch API
        document.addEventListener('DOMContentLoaded', function () {
            // Gunakan event delegation supaya lebih aman jika ada penambahan baris dinamis
            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.btn-delete-trigger');
                if (!btn) return;

                const idSite = btn.dataset.id;
                const ipAddr = btn.dataset.ip || 'Site';
                const targetRow = document.getElementById(`site-row-${idSite}`);

                Swal.fire({
                    title: 'Hapus Monitoring?',
                    text: `IP ${ipAddr} akan dihapus dari peta & tabel secara permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return fetch(`${window.location.origin}/site/${idSite}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    // Jika 404, berarti ID salah atau Route belum di-clear
                                    throw new Error(
                                        'Server merespon error (Cek Route/Controller)'
                                    );
                                }
                                return response.json();
                            })
                            .catch(error => {
                                Swal.showValidationMessage(`Gagal: ${error.message}`);
                            });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {

                    if (result.isConfirmed) {

                        // 🔥 INI YANG BIKIN REALTIME HILANG DARI PETA
                        if (markerInstances[idSite]) {
                            console.log("Marker ditemukan, menghapus dari peta...");

                            // Hapus dari tampilan peta
                            mapHome.removeLayer(markerInstances[idSite]);

                            // Hapus dari daftar memori
                            delete markerInstances[idSite];
                        }

                        // Hentikan monitoring IP agar tidak error di console
                        if (activeIntervals[idSite]) {
                            clearInterval(activeIntervals[idSite]);
                            delete activeIntervals[idSite];
                        }

                        // Hapus baris tabel secara realtime
                        if (targetRow) {
                            targetRow.style.transition = "all 0.5s ease";
                            targetRow.style.opacity = "0";
                            targetRow.style.transform = "translateX(50px)";
                            setTimeout(() => targetRow.remove(), 500);
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            timer: 1000,
                            showConfirmButton: false
                        });
                    }
                });
            });
        }); // Realtime Status Check JS
        const sites = @json($sites);

        async function updateRealtimeStatus() {

            for (const site of sites) {

                const ip = site.ip_address;
                const ipId = ip ? ip.replace(/\./g, '-') : null;

                const dot = document.getElementById(`dot-${ipId}`);
                const pingDisplay = document.getElementById(`ping-value-${ipId}`);
                const marker = markerInstances[site.id_site];

                // =========================
                // 🔥 HANDLE NO IP
                // =========================
                if (!ip || ip.trim() === '') {

                    if (dot && pingDisplay) {
                        pingDisplay.innerText = 'No IP';
                        pingDisplay.className = 'text-secondary';
                        dot.className = 'status-pill secondary';
                    }

                    if (marker && marker.getElement()) {
                        const el = marker.getElement();
                        el.className = 'status-icon status-unreachable';
                    }

                    continue;
                }

                try {

                    const response = await fetch(`/api/check-status?ip=${ip}`);

                    if (!response.ok) throw new Error('Server error');

                    const data = await response.json();

                    // =========================
                    // 🔥 UPDATE TABLE
                    // =========================
                    if (data.status === 'online') {

                        if (pingDisplay) {
                            pingDisplay.innerText = data.response_time + ' ms';
                            pingDisplay.className = 'text-success';
                        }

                        if (dot) {
                            dot.className = 'status-pill success';
                        }

                    } else if (data.status === 'offline') {

                        if (pingDisplay) {
                            pingDisplay.innerText = 'Timeout';
                            pingDisplay.className = 'text-warning';
                        }

                        if (dot) {
                            dot.className = 'status-pill warning';
                        }

                    } else {

                        if (pingDisplay) {
                            pingDisplay.innerText = 'Unreachable';
                            pingDisplay.className = 'text-danger';
                        }

                        if (dot) {
                            dot.className = 'status-pill danger';
                        }
                    }

                    // =========================
                    // 🔥 UPDATE MARKER (INI FIX NYA)
                    // =========================
                    if (marker && marker.getElement()) {

                        const el = marker.getElement();

                        // RESET CLASS
                        el.className = 'status-icon';

                        if (data.status === 'online') {

                            el.classList.add('status-online');

                        } else if (data.status === 'offline') {

                            el.classList.add('status-offline');

                        } else {

                            el.classList.add('status-unreachable');
                        }
                    }

                } catch (error) {

                    console.error('Error checking IP:', ip);

                    if (pingDisplay) {
                        pingDisplay.innerText = 'Unreachable';
                        pingDisplay.className = 'text-danger';
                    }

                    if (dot) {
                        dot.className = 'status-pill danger';
                    }

                    // 🔥 UPDATE MARKER ERROR
                    if (marker && marker.getElement()) {
                        const el = marker.getElement();
                        el.className = 'status-icon status-unreachable';
                    }
                }
            }
        } // 🚀 RUN
        updateRealtimeStatus();
        setInterval(updateRealtimeStatus, 10000);

        // realtime clock js
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
        document.addEventListener("DOMContentLoaded", function () {

            const buttons = document.querySelectorAll(".top-nav-btn");
            const cards = document.querySelectorAll(".site-card");

            buttons.forEach(btn => {
                btn.addEventListener("click", function () {

                    // 🔥 remove active semua
                    buttons.forEach(b => b.classList.remove("active"));
                    this.classList.add("active");

                    const kategori = this.getAttribute("data-kategori");
                    const isAll = this.getAttribute("data-id") === "all";

                    cards.forEach(card => {
                        if (isAll) {
                            card.style.display = "block";
                        } else {
                            if (card.getAttribute("data-kategori") === kategori) {
                                card.style.display = "block";
                            } else {
                                card.style.display = "none";
                            }
                        }
                    });

                });
            });

        });

    </script>
    <script src="../assets/js/plugins/popper.min.js"></script>
    <script src="../assets/js/plugins/simplebar.min.js"></script>
    <script src="../assets/js/plugins/bootstrap.min.js"></script>
    <script src="../assets/js/fonts/custom-font.js"></script>
    <script src="../assets/js/pcoded.js"></script>
    <script src="../assets/js/plugins/feather.min.js"></script>
</body>

</html>
