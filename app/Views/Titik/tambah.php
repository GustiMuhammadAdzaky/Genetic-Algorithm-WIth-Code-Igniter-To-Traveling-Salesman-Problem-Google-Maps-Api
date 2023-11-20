<?= $this->extend('Layouts/index') ?>

<?= $this->section('content') ?>


<section class="section">
    <div class="row" id="basic-table">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center"><?= $title; ?></h4>
                    <form action="save" method="POST">
                        <div class="col">
                            <div class="form-group">
                                <select name="kode_kelompok" class="form-select <?= ($validation->hasError('kode_kelompok')) ? 'is-invalid' : ''; ?>" aria-label="Default select example">
                                    <option value="">Pilih Kelompok</option>
                                    <?php if ($kelompok_model != null) { ?>
                                        <?php foreach ($kelompok_model as $km) : ?>
                                            <option value="<?= $km['kode_kelompok']; ?>"><?= $km["nama_kelompok"]; ?></option>
                                        <?php endforeach; ?>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('kode_kelompok'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="kode_titik">Kode</label>
                                <input name="kode_titik" type="text" id="kode_titik" class="form-control <?= ($validation->hasError('kode_titik')) ? 'is-invalid' : ''; ?> round" value="<?= $kode; ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('kode_titik') . "(Saran, Gunakan Code Yang tersedia Otomatis)"; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="nama_titik">Nama Titik</label>
                                <input name="nama_titik" type="text" id="nama" class="form-control <?= ($validation->hasError('nama_titik')) ? 'is-invalid' : ''; ?> square" placeholder="Isikan">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('nama_titik'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input name="latitude" type="text" id="lat" class="form-control <?= ($validation->hasError('latitude')) ? 'is-invalid' : ''; ?> square" placeholder="Drag Marker Merah Pada Maps untuk mengisikan Data!">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('latitude'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input name="longitude" type="text" id="lng" class="form-control <?= ($validation->hasError('longitude')) ? 'is-invalid' : ''; ?> square" placeholder="Drag Marker Merah Pada Maps untuk mengisikan Data!">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('longitude'); ?>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Tambah</button>
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
    const defaultCenter = {
        lat: -0.077457,
        lng: 109.348590
    };


    function initMap() {
        const map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
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