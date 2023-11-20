<?= $this->extend('Layouts/index') ?>

<?= $this->section('content') ?>
<style>
    #right-panel {
        font-family: 'Roboto', 'sans-serif';
        line-height: 30px;
        padding-left: 10px;
        float: right;
        width: 34%;
        height: 500px;
        overflow: auto;
    }

    #right-panel select,
    #right-panel input {
        font-size: 15px;
    }

    #right-panel select {
        width: 100%;
    }

    #right-panel i {
        font-size: 12px;
    }




    #map {
        height: 500px;
        float: left;
        width: 63%;
    }

    #right-panel2 {
        font-family: 'Roboto', 'sans-serif';
        line-height: 30px;
        padding-left: 10px;
        float: right;
        width: 34%;
        height: 500px;
        overflow: auto;
    }

    #right-panel2 select,
    #right-panel2 input {
        font-size: 15px;
    }

    #right-panel2 select {
        width: 100%;
    }

    #right-panel2 i {
        font-size: 12px;
    }

    #map2 {
        height: 500px;
        float: left;
        width: 63%;
    }

    /* #right-panel {} */
</style>
<?php

// Pelajari tentang arr



$ag->num_crommosom = $getVar["num_kromosom"];
$ag->max_generation = $getVar["max_generation"];
// $ag->debug = $getVar["debug"];
$ag->crossover_rate = 75;
$arr = $ag->generate();



$origin = array(
    'lat' => $POINTS[$arr[0]]->lat * 1,
    'lng' => $POINTS[$arr[0]]->lng * 1,
);

$org = json_encode($origin);


$detination = array(
    'lat' => $POINTS[$arr[count($arr) - 1]]->lat * 1,
    'lng' => $POINTS[$arr[count($arr) - 1]]->lng * 1,
);


$waypoint = array();
for ($a = 1; $a < count($arr) - 1; $a++) {
    $waypoint[] = array(
        'location' => array(
            'lat' => $POINTS[$arr[$a]]->lat * 1,
            'lng' => $POINTS[$arr[$a]]->lng * 1,
        ),
        'stopover' => TRUE,
    );
}

$arr_poly = array();
foreach ($arr as $key) {

    $arr_poly[] = array(
        'lat' => $POINTS[$key]->lat * 1,
        'lng' => $POINTS[$key]->lng * 1,
    );
}


$ket_str = "Keterangan: <br />";
$ascii = 65;
$arr_rute = array();
foreach ($arr as $key) {
    $chr = chr($ascii++);
    $arr_rute[] = $chr;
    $ket_str .= "$chr = $TITIK[$key] <br />";
}

// map2
$arr2 = $ag->titikUmum();
$origin2 = array(
    'lat' => $POINTS[$arr[0]]->lat * 1,
    'lng' => $POINTS[$arr[0]]->lng * 1,
);
$org = json_encode($origin);


$detination2 = array(
    'lat' => $POINTS[$arr2[count($arr2) - 1]]->lat * 1,
    'lng' => $POINTS[$arr2[count($arr2) - 1]]->lng * 1,
);


$waypoint2 = array();
for ($a = 1; $a < count($arr2) - 1; $a++) {
    $waypoint2[] = array(
        'location' => array(
            'lat' => $POINTS[$arr2[$a]]->lat * 1,
            'lng' => $POINTS[$arr2[$a]]->lng * 1,
        ),
        'stopover' => TRUE,
    );
}
$arr_poly2 = array();
foreach ($arr2 as $key) {

    $arr_poly2[] = array(
        'lat' => $POINTS[$key]->lat * 1,
        'lng' => $POINTS[$key]->lng * 1,
    );
}


$ket_str = "Keterangan: <br />";
$ascii = 65;
$arr_rute = array();
foreach ($arr as $key) {
    $chr = chr($ascii++);
    $arr_rute[] = $chr;
    $ket_str .= "$chr = $TITIK[$key] <br />";
}
?>

<section class="section">
    <div class="card">
        <div class="card-body">
            <h1>Selamat Datang Pada Menu <?= $title; ?></h1>
        </div>
    </div>
</section>
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Rute teroptimasi Menggunakan Algoritma genetika</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-10">
                            <p class="rute"></p>
                            <div>
                                <div id="map" class="thumbnail"></div>
                                <div id="right-panel" class="small">
                                    <p style="font-weight: bold;" class="text-danger">
                                        Total Jarak: <span id="total"></span> km<br />
                                        Total Biaya: Rp <span id="biaya"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <form action="save" method="POST" id="myForm">
                    <input type="hidden" name="origin" value="<?= htmlentities(serialize($origin)); ?>">
                    <input type="hidden" name="detination" value="<?= htmlentities(serialize($detination)); ?>">
                    <input type="hidden" name="waypoint" value="<?= htmlentities(serialize($waypoint)); ?>">
                    <input type="hidden" name="arr_poly" value="<?= htmlentities(serialize($arr_poly)); ?>">
                    <input type="hidden" name="arr_rute" value="<?= htmlentities(serialize($arr_rute)); ?>">
                    <input type="hidden" name="nama_kelompok" value="<?= $getVar["nama_kelompok"]; ?>">


                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-3">Simpan Rute ini</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</section>

<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Rute berdasarkan inputan kurir(belum teroptimasi)</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-10">
                            <p class="rute2"></p>
                            <div>
                                <div id="map2" class="thumbnail"></div>
                                <div id="right-panel2" class="small">
                                    <p style="font-weight: bold;" class="text-danger">
                                        Total Jarak: <span id="total2"></span> km<br />
                                        Total Biaya: Rp <span id="biaya2"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

</section>


<?php



// $ag->num_crommosom = $getVar["num_kromosom"];
// $ag->max_generation = $getVar["max_generation"];
// // $ag->debug = $getVar["debug"];
// $ag->crossover_rate = 75;

// $arr = $ag->generate();
// // d($arr);
// $origin = array(
//     'lat' => $POINTS[$arr[0]]->lat * 1,
//     'lng' => $POINTS[$arr[0]]->lng * 1,
// );
// // d($origin);
// $detination = array(
//     'lat' => $POINTS[$arr[count($arr) - 1]]->lat * 1,
//     'lng' => $POINTS[$arr[count($arr) - 1]]->lng * 1,
// );

// $waypoint = array();
// for ($a = 1; $a < count($arr) - 1; $a++) {
//     $waypoint[] = array(
//         'location' => array(
//             'lat' => $POINTS[$arr[$a]]->lat * 1,
//             'lng' => $POINTS[$arr[$a]]->lng * 1,
//         ),
//         'stopover' => TRUE,
//     );
// }
// $ket_str = "Keterangan: <br />";

// d(json_encode($waypoint));
// $ascii = 65;
// $arr_rute = array();
// foreach ($arr as $key) {
//     $chr = chr($ascii++);
//     $arr_rute[] = $chr;
//     $ket_str .= "$chr = $TITIK[$key] <br />";
// }
// d($arr_rute);
// d($arr_poly);


?>

<script>
    const defaultCenter = {
        lat: -0.077457,
        lng: 109.348590
    };

    const titik = <?= json_encode(array_values($arr_rute)) ?>;
    let cost_per_kilo = <?= $cost_per_kilo; ?>;


    // Teaster 

    // teaster



    function initMap() {
        const directionsService = new google.maps.DirectionsService;
        const directionsDisplay = new google.maps.DirectionsRenderer;
        const directionsService2 = new google.maps.DirectionsService;
        const directionsDisplay2 = new google.maps.DirectionsRenderer;
        const map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: defaultCenter
        });
        directionsDisplay.setMap(map);
        directionsDisplay.setPanel(document.getElementById('right-panel'));
        calculateAndDisplayRoute(directionsService, directionsDisplay, map);

        var map2 = new google.maps.Map(document.getElementById('map2'), {
            zoom: 16,
            center: defaultCenter
        });
        directionsDisplay2.setMap(map2);
        calculateAndDisplayRoute2(directionsService2, directionsDisplay2, map2);
        directionsDisplay2.setPanel(document.getElementById('right-panel2'));

    }





    function calculateAndDisplayRoute(directionsService, directionsDisplay, map) {
        directionsService.route({
            origin: <?= json_encode($origin) ?>,
            destination: <?= json_encode($detination) ?>,
            waypoints: <?= json_encode($waypoint) ?>,
            optimizeWaypoints: false,
            travelMode: 'DRIVING'
        }, function(response, status) {
            if (status === 'OK') {
                directionsDisplay.setDirections(response);
                // Mencari total jarak
                let total = 0;
                const result = directionsDisplay.getDirections();
                const myroute = result.routes[0];
                for (let i = 0; i < myroute.legs.length; i++) {
                    total += myroute.legs[i].distance.value;
                }
                total = total / 1000;
                document.getElementById('total').innerHTML = total;
                const cost = Math.round(total * cost_per_kilo);
                document.getElementById('biaya').innerHTML = cost.toLocaleString();

                var flightPlanCoordinates = <?= json_encode($arr_poly) ?>;
                var flightPath = new google.maps.Polyline({
                    path: flightPlanCoordinates,
                    geodesic: true,
                    strokeColor: '#FF0000',
                    strokeOpacity: 1.0,
                    strokeWeight: 2
                });
                flightPath.setMap(map);
            }
        });
    }

    function calculateAndDisplayRoute2(directionsService2, directionsDisplay2, map2) {
        directionsService2.route({
            origin: <?= json_encode($origin2) ?>,
            destination: <?= json_encode($detination2) ?>,
            waypoints: <?= json_encode($waypoint2) ?>,
            optimizeWaypoints: false,
            travelMode: 'DRIVING'
        }, function(response, status) {
            if (status === 'OK') {
                directionsDisplay2.setDirections(response);

                let total = 0;
                const result = directionsDisplay2.getDirections();
                const myroute = result.routes[0];
                for (let i = 0; i < myroute.legs.length; i++) {
                    total += myroute.legs[i].distance.value;
                }
                total = total / 1000;
                document.getElementById('total2').innerHTML = total;
                const cost = Math.round(total * cost_per_kilo);
                document.getElementById('biaya2').innerHTML = cost.toLocaleString();

                var flightPlanCoordinates = <?= json_encode($arr_poly2) ?>;
                var flightPath = new google.maps.Polyline({
                    path: flightPlanCoordinates,
                    geodesic: true,
                    strokeColor: '#FF0000',
                    strokeOpacity: 1.0,
                    strokeWeight: 2
                });
                flightPath.setMap(map2);
            }
        });
    }

    window.initMap = initMap;
</script>

<?= $this->endSection() ?>