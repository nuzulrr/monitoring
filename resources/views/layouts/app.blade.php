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
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/fonts/phosphor/regular/style.css" />
  <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" />
  <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" />
  <link rel="stylesheet" href="../assets/css/style-preset.css" />
  <link rel="stylesheet" href="../assets/css/app.css" />
  <!--js-->
  <!-- LEAFLET -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

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
          <img src="{{ asset('assets/images/application/logop.png') }}" alt="Logo" style="height: 40px; width: auto;">
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
          <div class="d-flex flex-wrap gap-2">
            <button type="button" class="top-nav-btn active" data-id="all">
              All Project
            </button>

            @foreach ($projek as $item)
              <button type="button" class="top-nav-btn" data-id="{{ $item->id_projek }}">
                {{ $item->nama_projek }}
              </button>
            @endforeach
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
                        <select name="id_projek" id="select-id-projek" class="form-control">
                          <option value="">Pilih Projek</option>
                          @foreach($projek as $p)
                            <option value="{{ $p->id_projek }}" data-nama="{{ $p->nama_projek }}" {{ old('id_projek') == $p->id_projek ? 'selected' : '' }}>
                              {{ $p->nama_projek }}
                            </option>
                          @endforeach
                        </select>
                        @error('id_projek')
                          <small class="text-danger">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="mb-3">
                        <label>Nama Projek</label>
                        <input type="text" name="projek" class="form-control" value="{{ old('projek') }}">
                        @error('projek')
                          <small class="text-danger">{{ $message }}</small>
                        @enderror
                      </div>
                      <script>
                        document.addEventListener('DOMContentLoaded', function () {
                          const selectProjek = document.getElementById(
                            'select-id-projek');
                          const inputProjek = document.getElementById(
                            'input-projek-manual');

                          // Variabel untuk menyimpan nama asli dari dropdown
                          let baseProjectName = "";

                          // Saat Dropdown dipilih
                          selectProjek.addEventListener('change', function () {
                            const selectedOption = this.options[this
                              .selectedIndex];

                            if (this.value !== "") {
                              // Ambil nama dari atribut data-nama yang kita buat di Blade
                              baseProjectName = selectedOption
                                .getAttribute('data-nama');

                              // Langsung update input dengan Nama Projek awal
                              inputProjek.value = baseProjectName + " ";
                              inputProjek
                                .focus(); // Arahkan kursor ke input agar bisa langsung ngetik
                            } else {
                              baseProjectName = "";
                              inputProjek.value = "";
                            }
                          });

                          // Saat user mengetik di input (Opsional: Jika ingin memastikan awalan tidak dihapus)
                          inputProjek.addEventListener('input', function () {
                            if (baseProjectName !== "" && !this.value
                              .startsWith(baseProjectName)) {
                              // Mencegah user menghapus nama dasar dari dropdown
                              this.value = baseProjectName + " " + this
                                .value.trimStart();
                            }
                          });
                        });

                      </script>

                      <!-- Alamat -->
                      <div class="mb-3">
                        <label>Alamat</label>
                        <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}">
                        @error('alamat')
                          <small class="text-danger">{{ $message }}</small>
                        @enderror
                      </div>

                      <!-- IP -->
                      <div class="mb-3">
                        <label>IP Public</label>
                        <input type="text" name="ip_address" class="form-control" value="{{ old('ip_address') }}">
                        @error('ip_address')
                          <small class="text-danger">{{ $message }}</small>
                        @enderror
                      </div>

                      <!-- Tanggal -->
                      <div class="mb-3">
                        <label>Tanggal Instalasi</label>
                        <input type="date" name="tgl_instalasi" class="form-control" value="{{ old('tgl_instalasi') }}">
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
                          <input type="text" name="latitude" id="lat" class="form-control" placeholder="Latitude"
                            value="{{ old('latitude') }}" readonly>
                          @error('latitude')
                            <small class="text-danger">{{ $message }}</small>
                          @enderror
                        </div>
                        <div class="col">
                          <input type="text" name="longitude" id="lng" class="form-control" placeholder="Longitude"
                            value="{{ old('longitude') }}" readonly>
                          @error('longitude')
                            <small class="text-danger">{{ $message }}</small>
                          @enderror
                        </div>
                      </div>

                      <!-- MAP -->
                      <div id="map" style="height:300px; margin-top:15px;"></div>

                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                      <button type="button" onclick="confirmSimpanLokasi()" class="btn btn-primary">
                        Simpan
                      </button>
                    </div>
                  </form>

                </div>
              </div>
            </div>
            <button type="button" class="btn-add-action" data-bs-toggle="modal" data-bs-target="#modalProjek">
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
              <div class="d-flex bg-dark" style="border: 1px solid #333; border-radius: 6px; padding: 2px;">
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
              <div class="card-header border-0 pb-1">
                <h5 class="text-white mb-0 d-flex align-items-center">
                  <i class="ph ph-arrows-left-right text-muted me-2 f-20"></i> Live IP Monitoring
                </h5>
              </div>

              <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                  <table class="table table-ip mb-0">
                    <thead>
                      <tr>
                        <th class="ps-4">Project</th>
                        <th>IP Public</th>
                        <th class="text-center">Time</th>
                        <th class="text-center">Status</th>
                        <th>Alamat</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>

                    <tbody>
                      @foreach($sites as $s)
                        @php $ipId = str_replace('.', '-', $s->ip_address); @endphp
                        <tr id="site-row-{{ $s->id_site }}">

                          <td class="ps-4 text-white fw-bold">
                            {{ $s->projek_ref->nama_projek ?? '' }} - {{ $s->projek ?? '-' }}
                          </td>

                          <td class="text-white font-monospace">
                            {{ $s->ip_address }}
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
                              <button type="button" class="btn btn-outline-primary border-0 btn-edit"
                                data-id="{{ $s->id_site }}" data-projek_id="{{ $s->id_projek }}"
                                data-projek_val="{{ $s->projek }}" data-ip="{{ $s->ip_address }}"
                                data-alamat="{{ $s->alamat }}" data-lat="{{ $s->latitude }}"
                                data-lng="{{ $s->longitude }}" data-tgl="{{ $s->tgl_instalasi }}"
                                data-note="{{ $s->note }}" data-bs-toggle="modal" data-bs-target="#modalEdit">
                                <i class="ph ph-pencil"></i>
                              </button>
                              <script>
                                document.addEventListener('click', function (e) {
                                  const btn = e.target.closest('.btn-edit');
                                  if (!btn) return;

                                  const modal = document.getElementById('modalEdit');

                                  // SET ACTION FORM
                                  document.getElementById('formEdit').action = `/sites/${btn.dataset.id}`;

                                  // ISI FORM
                                  document.getElementById('edit-id-projek').value = btn.dataset.projek_id;
                                  document.getElementById('edit-projek-manual').value = btn.dataset.projek_val;
                                  document.getElementById('edit-ip').value = btn.dataset.ip;
                                  document.getElementById('edit-alamat').value = btn.dataset.alamat;
                                  document.getElementById('edit-tgl').value = btn.dataset.tgl;
                                  document.getElementById('edit-note').value = btn.dataset.note;
                                  document.getElementById('edit-lat').value = btn.dataset.lat;
                                  document.getElementById('edit-lng').value = btn.dataset.lng;

                                  // 🔥 SIMPAN KOORDINAT UNTUK MAP
                                  modal.dataset.lat = btn.dataset.lat;
                                  modal.dataset.lng = btn.dataset.lng;
                                });
                              </script>

                              <button type="button" class="btn btn-outline-danger border-0 btn-delete-trigger"
                                data-id="{{ $s->id_site }}" data-ip="{{ $s->ip_address }}">
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
                  <span class="bg-danger me-2" style="width: 4px; height: 14px; border-radius: 2px;"></span>
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
                <h5 class="modal-title">Edit Lokasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
              </div>

              <form id="formEdit" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">
                  <div class="mb-3">
                    <label class="fw-bold">Kategori Projek</label>
                    <select name="id_projek" id="edit-id-projek" class="form-control">
                      <option value="">Pilih Projek</option>
                      @foreach($projek as $p)
                        <option value="{{ $p->id_projek }}" data-nama="{{ $p->nama_projek }}" {{ old('id_projek') == $p->id_projek ? 'selected' : '' }}>
                          {{ $p->nama_projek }}
                        </option>
                      @endforeach
                    </select>
                    @error('id_projek') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="mb-3">
                    <label class="fw-bold">Nama Projek</label>
                    <input type="text" name="projek" id="edit-projek-manual" class="form-control"
                      value="{{ old('projek') }}">
                    @error('projek') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="mb-3">
                    <label class="fw-bold">Alamat</label>
                    <input type="text" name="alamat" id="edit-alamat" class="form-control" value="{{ old('alamat') }}">
                    @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="fw-bold">IP Public</label>
                      <input type="text" name="ip_address" id="edit-ip" class="form-control"
                        value="{{ old('ip_address') }}">
                      @error('ip_address') <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                      <label class="fw-bold">Tanggal Instalasi</label>
                      <input type="date" name="tgl_instalasi" id="edit-tgl" class="form-control"
                        value="{{ old('tgl_instalasi') }}">
                      @error('tgl_instalasi') <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="fw-bold">Note</label>
                    <textarea name="note" id="edit-note" class="form-control">{{ old('note') }}</textarea>
                  </div>

                  <div class="row">
                    <div class="col">
                      <label class="small fw-bold">Latitude</label>
                      <input type="text" name="latitude" id="edit-lat" class="form-control"
                        value="{{ old('latitude') }}" readonly>
                    </div>
                    <div class="col">
                      <label class="small fw-bold">Longitude</label>
                      <input type="text" name="longitude" id="edit-lng" class="form-control"
                        value="{{ old('longitude') }}" readonly>
                    </div>
                  </div>

                  <div id="map-edit" style="height:300px; margin-top:15px; border-radius: 8px;"></div>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <script>
          let editMap;
          let editMarker;

          const modalEditEl = document.getElementById('modalEdit');

          modalEditEl.addEventListener('shown.bs.modal', function () {
            const lat = parseFloat(this.dataset.lat) || -6.200000;
            const lng = parseFloat(this.dataset.lng) || 106.816666;

            if (!editMap) {
              // 1. Inisialisasi Map
              editMap = L.map('map-edit').setView([lat, lng], 15);

              L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
              }).addTo(editMap);

              // 2. Tambahkan Marker
              editMarker = L.marker([lat, lng], {
                draggable: true
              }).addTo(editMap);

              // 3. TAMBAHKAN FITUR SEARCH (GEOCODER)
              const geocoder = L.Control.geocoder({
                defaultMarkGeocode: false
              })
                .on('markgeocode', function (e) {
                  const bbox = e.geocode.bbox;
                  const center = e.geocode.center;

                  // Pindahkan Marker dan Map ke hasil pencarian
                  editMarker.setLatLng(center);
                  editMap.fitBounds(bbox);

                  // Update Input Latitude & Longitude
                  updateCoords(center.lat, center.lng);
                })
                .addTo(editMap);

              // 4. FITUR KLIK PETA
              editMap.on('click', function (e) {
                const {
                  lat,
                  lng
                } = e.latlng;
                editMarker.setLatLng([lat, lng]);
                updateCoords(lat, lng);
              });

              // 5. FITUR DRAG MARKER
              editMarker.on('dragend', function () {
                const pos = editMarker.getLatLng();
                updateCoords(pos.lat, pos.lng);
              });

            } else {
              // Jika sudah ada, cukup update posisi
              editMap.setView([lat, lng], 15);
              editMarker.setLatLng([lat, lng]);
            }

            // Refresh ukuran peta agar tidak bug/abu-abu
            setTimeout(() => {
              editMap.invalidateSize();
            }, 200);
          });

          // Fungsi Helper Update Input
          function updateCoords(lat, lng) {
            document.getElementById('edit-lat').value = lat.toFixed(8);
            document.getElementById('edit-lng').value = lng.toFixed(8);
          }

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



    // Peta Home: Menampilkan semua site dengan status real-time
    document.addEventListener('DOMContentLoaded', function () {

      // 🔥 INIT MAP (SEMUA INTERAKSI DIMATIKAN)
      const mapHome = L.map('map-home', {
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
      const markerInstances = {};

      // 🔥 MARKER LOOP
      sites.forEach(function (item) {
        if (item.latitude && item.longitude) {

          const lat = parseFloat(item.latitude);
          const lng = parseFloat(item.longitude);

          if (!isNaN(lat) && !isNaN(lng)) {

            const customIcon = L.divIcon({
              className: 'status-icon status-checking',
              html: ''
            });

            const marker = L.marker([lat, lng], {
              icon: customIcon
            }).addTo(mapHome);

            markerInstances[item.id_site] = marker;

            const namaProjek = (item.projek_ref && item.projek_ref.nama_projek) ? item.projek_ref.nama_projek : (item.projek || 'Tanpa Nama Projek');

            const popupContent = `
                    <div style="font-family: sans-serif; min-width: 180px;">
                        <h6 style="margin: 0 0 5px 0; color: #007bff;">${namaProjek} - ${item.projek ?? '-'}</h6>
                        <hr style="margin: 5px 0;">
                        <table style="width: 100%; font-size: 12px;">
                            <tr><td><b>Status:</b></td><td><b id="status-text-${item.id_site}" style="color:gray">Checking...</b></td></tr>
                            <tr><td><b>IP:</b></td><td><code>${item.ip_address ?? '-'}</code></td></tr>
                            <tr><td><b>Alamat:</b></td><td>${item.alamat ?? '-'}</td></tr>
                        </table>
                    </div>
                `;

            marker.bindPopup(popupContent);
            markersCoordinates.push([lat, lng]);

            monitorIP(item.ip_address, item.id_site);
          }
        }
      });

      // 🔥 AUTO ZOOM
      if (markersCoordinates.length > 0) {
        const bounds = L.latLngBounds(markersCoordinates);
        mapHome.fitBounds(bounds, { padding: [50, 50] });
      }

      // 🔥 REALTIME MONITOR
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

              // RESET CLASS
              iconElement.classList.remove(
                'status-online',
                'status-offline',
                'status-unreachable',
                'status-checking'
              );

              // 🔥 STATUS
              if (data.status === 'online') {
                iconElement.classList.add('status-online');
                textStatus.innerText = 'ONLINE';
                textStatus.style.color = 'lime';

              } else if (data.status === 'offline') {
                iconElement.classList.add('status-offline');
                textStatus.innerText = 'RTO (Offline)';
                textStatus.style.color = 'yellow';

              } else {
                iconElement.classList.add('status-unreachable');
                textStatus.innerText = 'UNREACHABLE';
                textStatus.style.color = 'red';
              }
            })
            .catch(err => console.error("Monitor Error:", err));
        }

        updateStatus();
        setInterval(updateStatus, 15000);
      }

      // 🔥 FIX MAP RENDER
      setTimeout(() => {
        mapHome.invalidateSize();
      }, 300);


      // =========================================
      // 🔥 CONTROL MAP INTERACTION (INI YANG LO MAU)
      // =========================================

      const mapContainer = document.getElementById('map-home');
      const overlay = document.getElementById('map-overlay');

      // 👉 AKTIFKAN MAP SAAT KLIK
      function enableMap() {
        mapHome.scrollWheelZoom.enable();
        mapHome.dragging.enable();
        mapHome.touchZoom.enable();
        mapHome.doubleClickZoom.enable();
        mapHome.boxZoom.enable();
        mapHome.keyboard.enable();
      }

      // 👉 MATIKAN MAP
      function disableMap() {
        mapHome.scrollWheelZoom.disable();
        mapHome.dragging.disable();
        mapHome.touchZoom.disable();
        mapHome.doubleClickZoom.disable();
        mapHome.boxZoom.disable();
        mapHome.keyboard.disable();
      }

      // Klik overlay → aktif
      overlay.addEventListener('click', function () {
        overlay.style.display = 'none';
        enableMap();
      });

      // Klik map → aktif juga
      mapContainer.addEventListener('click', function () {
        overlay.style.display = 'none';
        enableMap();
      });

      // Mouse keluar → disable lagi + munculin overlay
      mapContainer.addEventListener('mouseleave', function () {
        disableMap();
        overlay.style.display = 'flex';
      });

    });

    // Edit Site: Mapping data ke modal edit
    document.addEventListener('DOMContentLoaded', function () {
      const editButtons = document.querySelectorAll(
        '.btn-edit');
      const formEdit = document.getElementById(
        'formEdit');

      editButtons.forEach(btn => {
        btn.addEventListener('click',
          function () {
            // Mapping data dari atribut button ke input modal
            formEdit.action =
              `/sites/${this.dataset.id}`;
            document.getElementById(
              'edit-projek')
              .value = this.dataset
                .projek;
            document.getElementById(
              'edit-ip').value =
              this.dataset.ip;
            document.getElementById(
              'edit-alamat')
              .value = this.dataset
                .alamat;
            document.getElementById(
              'edit-lat').value =
              this.dataset.lat;
            document.getElementById(
              'edit-lng').value =
              this.dataset.lng;
            document.getElementById(
              'edit-tgl').value =
              this.dataset.tgl;
            document.getElementById(
              'edit-note').value =
              this.dataset.note;
          });
      });
    });

    // Delete Site dengan SweetAlert2 dan Fetch API
    document.addEventListener('DOMContentLoaded', function () {
      const deleteButtons = document.querySelectorAll('.btn-delete-trigger');

      deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
          const idSite = this.dataset.id;
          const ipAddr = this.dataset.ip;
          const targetRow = document.getElementById(`site-row-${idSite}`);

          Swal.fire({
            title: 'Hapus Monitoring?',
            text: `IP ${ipAddr} akan dihapus tanpa refresh halaman!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            showLoaderOnConfirm: true, // Menampilkan loading di dalam tombol Ya
            preConfirm: () => {
              // Mengirim request ke backend menggunakan Fetch API
              return fetch(`/sites/${idSite}`, {
                method: 'DELETE',
                headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}',
                  'Content-Type': 'application/json',
                  'Accept': 'application/json'
                }
              })
                .then(response => {
                  if (!response.ok) throw new Error(
                    'Gagal menghapus data di server'
                  );
                  return response.json();
                })
                .catch(error => {
                  Swal.showValidationMessage(
                    `Error: ${error}`);
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
          }).then((result) => {
            if (result.isConfirmed) {
              // Animasi menghilang sebelum baris dihapus
              targetRow.style.transition = "all 0.6s ease";
              targetRow.style.opacity = "0";
              targetRow.style.transform = "translateX(50px)";

              setTimeout(() => {
                targetRow.remove(); // Hapus dari HTML

                Swal.fire({
                  icon: 'success',
                  title: 'Terhapus!',
                  text: 'Baris telah dihapus secara realtime.',
                  timer: 1500,
                  showConfirmButton: false
                });
              }, 600);
            }
          });
        });
      });
    });
    // Realtime Status Check JS
    const sites = @json($sites);

    async function updateRealtimeStatus() {
      for (const site of sites) {

        const ip = site.ip_address;
        const ipId = ip ? ip.replace(/\./g, '-') : null;

        // 🔥 HANDLE JIKA IP TIDAK ADA
        if (!ip || ip.trim() === '') {
          if (ipId) {
            const dot = document.getElementById(`dot-${ipId}`);
            const pingDisplay = document.getElementById(`ping-value-${ipId}`);

            if (dot && pingDisplay) {
              pingDisplay.innerText = 'No IP';
              pingDisplay.className = 'text-secondary';
              dot.className = 'status-pill secondary';
            }
          }
          continue;
        }

        const dot = document.getElementById(`dot-${ipId}`);
        const pingDisplay = document.getElementById(`ping-value-${ipId}`);

        try {
          const response = await fetch(`/api/check-status?ip=${ip}`);

          // 🔥 JIKA API ERROR (SERVER DOWN / IP INVALID)
          if (!response.ok) {
            throw new Error('Server error');
          }

          const data = await response.json();

          // ✅ 1. ONLINE
          if (data.status === 'online') {
            pingDisplay.innerText = data.response_time + ' ms';
            pingDisplay.className = 'text-success';
            dot.className = 'status-pill success';
          }

          // 🔴 2. OFFLINE (TIMEOUT)
          else if (data.status === 'offline') {
            pingDisplay.innerText = 'Timeout';
            pingDisplay.className = 'text-warning';
            dot.className = 'status-pill warning';
          }

          // ⚫ 3. UNREACHABLE (STATUS TIDAK DIKENAL)
          else {
            pingDisplay.innerText = 'Unreachable';
            pingDisplay.className = 'text-danger';
            dot.className = 'status-pill danger';
          }

        } catch (error) {
          console.error('Error checking IP:', ip);

          // ⚫ UNREACHABLE (FETCH ERROR / NETWORK ERROR)
          if (dot && pingDisplay) {
            pingDisplay.innerText = 'Unreachable';
            pingDisplay.className = 'text-danger';
            dot.className = 'status-pill danger';
          }
        }
      }
    }

    // 🚀 RUN
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

  </script>
  <script src="../assets/js/plugins/popper.min.js"></script>
  <script src="../assets/js/plugins/simplebar.min.js"></script>
  <script src="../assets/js/plugins/bootstrap.min.js"></script>
  <script src="../assets/js/fonts/custom-font.js"></script>
  <script src="../assets/js/pcoded.js"></script>
  <script src="../assets/js/plugins/feather.min.js"></script>
</body>

</html>