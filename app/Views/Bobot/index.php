<?= $this->extend('Layouts/index') ?>
<?= $this->section('content') ?>



<section class="section">
    <div class="card">
        <div class="card-body">
            <h1>Selamat Datang Pada Menu <?= $title; ?></h1>

        </div>
    </div>
</section>
<!--  -->
<select id="mySelect" class="form-select" aria-label="form-select" onchange="myFunction()">
    <option>Pilih Kelompok</option>
    <?php foreach ($kelompok as $k) : ?>
        <option value="<?= $k->kode_kelompok; ?>&nama_kelompok=<?= $k->nama_kelompok; ?>"><?= $k->nama_kelompok; ?>
        </option>
    <?php endforeach; ?>
</select>
<!--  -->
<section class="section mt-3">
    <div class="card">
        <?php if ($getData != null) { ?>

            <form action="/bobot/save">
                <!-- button awal sampai Akhur -->
                <div class="card-header">
                    <h5 class="mb-4">Kelompok <?= $getData['nama_kelompok']; ?></h5>
                    <button type="submit" class="btn btn-primary">
                        <svg class="bi" width="1em" height="1em" fill="currentColor">
                            <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#cloud-download-fill" />
                        </svg>Simpan Jarak</button>
                    <button type="submit" class="btn btn-light">
                        <svg class="bi" width="1em" height="1em" fill="currentColor">
                            <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#align-center" />
                        </svg>Tambah</button>
                    <select id="start" name="titik1" class="btn btn-light" aria-label="Default select example">
                        <?php foreach ($titikOption as $to) : ?>
                            <option value='{
                            "kode":"<?= $to->kode_titik; ?>",
                            "data_lat":"<?= $to->lat; ?>",
                            "data_lng":"<?= $to->lng; ?>"}'>
                                <?= $to->nama_titik; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select id="end" name="titik2" class=" btn btn-light" aria-label="Default select example">
                        <?php foreach ($titikOption as $to) : ?>
                            <option value='{
                            "kode":"<?= $to->kode_titik; ?>",
                            "data_lat":"<?= $to->lat; ?>",
                            "data_lng":"<?= $to->lng; ?>"}'>
                                <?= $to->nama_titik; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- button awal sampai Akhur -->
                <!-- Maps -->
                <div class="card-body">
                    <div class="panel-body">
                        <div id="map" style="height: 300px;"></div>
                        <?php

                        $data = array();

                        // dd($rows);
                        foreach ($rows as $row) {
                            // d($row);
                            $data[$row->ID1][$row->ID2]  = $row->bobot;
                            $ID[$row->ID1][$row->ID2] = $row->ID;
                        }
                        d($model->get_graph($data));
                        // d($data);


                        ?>
                    </div>
                </div>
                <!-- Maps -->
                <!-- Table -->

                <div class="card-body">
                    <div class="panel-body">
                        <section class="section">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Kode</th>
                                                <?php foreach ($data as $key => $val) : ?>
                                                    <th><?= $key ?></th>
                                                <?php endforeach ?>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // d($data);
                                            $a = 1;
                                            foreach ($data as $key => $val) : ?>
                                                <tr>
                                                    <td><?= $key ?></td>

                                                    <?php

                                                    $b = 1;
                                                    foreach ($val as $k => $v) : ?>

                                                        <td>

                                                            <input type="text" id="vh[<?= $key ?>][<?= $k ?>]" name="bobot[<?= $key ?>][<?= $k ?>]" class="form-control input-sm bobot_<?= $key ?>_<?= $k ?>" value="<?= $v ?>" />

                                                        </td>
                                                    <?php $b++;
                                                    endforeach; ?>
                                                </tr>
                                            <?php $a++;
                                            endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <!-- table -->
            </form>
        <?php } ?>
    </div>

</section>

</section>

<script>
    // function ambil() {
    //     // const select = document.getElementById("start").value;
    //     const start = document.querySelector("#start").value;
    //     const end = document.querySelector("#end").value;
    //     // console.log(JSON.parse(end).kode);
    //     const titikA = JSON.parse(start);
    //     const titikB = JSON.parse(end);

    // }

    // let elements = document.getElementsByName(bobot[]);

    function myFunction() {
        var select = document.getElementById("mySelect").value;
        const href = "<?= base_url(); ?>/Bobot?kode_kelompok=" + select;
        window.location.href = href;
    }

    const defaultCenter = {
        lat: -0.114272,
        lng: 109.291787
    };


    function initMap() {
        const directionsService = new google.maps.DirectionsService;
        const directionsDisplay = new google.maps.DirectionsRenderer;

        const map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: defaultCenter
        });

        directionsDisplay.setMap(map);
        var onChangeHandler = function() {
            calculateAndDisplayRoute(directionsService, directionsDisplay);
        };




        document.getElementById('start').addEventListener('change', onChangeHandler);
        document.getElementById('end').addEventListener('change', onChangeHandler);

    }

    function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        const titikA = document.getElementById('start').value;
        const titikB = document.getElementById('end').value;
        const start = JSON.parse(titikA);
        const end = JSON.parse(titikB);
        directionsService.route({
            origin: {
                lat: parseFloat(start.data_lat),
                lng: parseFloat(start.data_lng),
            },
            destination: {
                lat: parseFloat(end.data_lat),
                lng: parseFloat(end.data_lng),
            },
            travelMode: 'DRIVING'
        }, function(response, status) {
            if (status === 'OK') {
                // vh = vertical horizontal
                const bobot = `vh[${start.kode}][${end.kode}]`;
                // alert(bobot);
                let elements = document.getElementById(bobot).value = response.routes[0].legs[0].distance
                    .value / 1000;
                console.log(response);
                // console.log(start.kode);
                directionsDisplay.setDirections(response);
            } else {
                window.alert('Directions request failed due to ' + satus);
            }
        });
    }






    window.initMap = initMap;
</script>
<?= $this->endSection() ?>