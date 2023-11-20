<?= $this->extend('Layouts/index') ?>

<?= $this->section('content') ?>


<div id="error-message" class="alert alert-danger" style="display: none;">Mohon lengkapi semua field sebelum mengirimkan formulir.</div>



<section class="section">
    <div class="row" id="basic-table">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center"><?= $title; ?></h4>
                    <form action="/titik/update" method="POST">
                        <input type="hidden" name="id" value="<?= $getData["id"]; ?>">
                        <input type="hidden" name="kode_kelompok" value="<?= $getData["kode_kelompok"]; ?>">
                        <div class="col">
                            <div class="form-group">
                                <select disabled="disabled" name="kode_kelompok" class="form-select" aria-label="Default select example">
                                    <option value=""><?= $getData["kode_kelompok"]; ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="kode_titik">Kode Titik</label>
                                <input name="kode_titik" type="text" id="kode_titik" class="form-control square" value="<?= $getData["kode_titik"]; ?>">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="nama_titik">Nama Titik</label>
                                <input name="nama_titik" type="text" id="nama_titik" class="form-control square" value="<?= $getData["nama_titik"]; ?>">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input name="latitude" type="text" id="lat" class="form-control square" value="<?= $getData["lat"]; ?>">

                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input name="longitude" type="text" id="lng" class="form-control square" value="<?= $getData["lng"]; ?>">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Edit Data</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">MAPS</h4>
                    <div class="form-group mt-4">
                        <input class="form-control" type="text" id="pac-input" placeholder="Cari lokasi" />
                    </div>
                </div>
                <div class="card-content">
                    <div id="map" style="width:100%;height:380px;padding:35px;"></div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    // validation
    function validateForm() {
        var kodeTitik = document.getElementById("kode_titik").value;
        var namaTitik = document.getElementById("nama_titik").value;
        var latitude = document.getElementById("lat").value;
        var longitude = document.getElementById("lng").value;

        if (kodeTitik === "" || namaTitik === "" || latitude === "" || longitude === "") {
            // Menampilkan pesan error
            var errorElement = document.getElementById("error-message");
            errorElement.style.display = "block";

            // Menandai input yang tidak valid dengan class is-invalid
            if (kodeTitik === "") {
                document.getElementById("kode_titik").classList.add("is-invalid");
            }
            if (namaTitik === "") {
                document.getElementById("nama_titik").classList.add("is-invalid");
            }
            if (latitude === "") {
                document.getElementById("lat").classList.add("is-invalid");
            }
            if (longitude === "") {
                document.getElementById("lng").classList.add("is-invalid");
            }

            return false;
        }
    }


    const defaultCenter = {
        lat: <?= $getData["lat"]; ?>,
        lng: <?= $getData["lng"]; ?>
    };


    function initMap() {


        const map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: defaultCenter
        });

        const marker = new google.maps.Marker({
            position: defaultCenter,
            map: map,
            title: 'Click to zoom',
            draggable: true
        });

        var input = document.getElementById('pac-input');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        marker.addListener('drag', handleEvent);
        marker.addListener('dragend', handleEvent);


        var infowindow = new google.maps.InfoWindow({
            content: "<h6>Drag untuk pindah lokasi</h6>",
        });

        infowindow.open(map, marker);
        var infowindowContent = document.getElementById("infowindow-content");

        autocomplete.addListener('place_changed', function() {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17); // Why 17? Because it looks good.
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            document.getElementById('nama').value = place.name;
            document.getElementById('lat').value = place.geometry.location.lat();
            document.getElementById('lng').value = place.geometry.location.lng();

            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }

            infowindow.setContent(place.name + '');
            infowindow.open(map, marker);
        });
    }

    function handleEvent(event) {
        document.getElementById('lat').value = event.latLng.lat();
        document.getElementById('lng').value = event.latLng.lng();
    }

    window.initMap = initMap;
</script>
<?= $this->endSection() ?>