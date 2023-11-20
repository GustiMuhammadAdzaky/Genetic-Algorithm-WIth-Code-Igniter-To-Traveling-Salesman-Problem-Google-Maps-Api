<?= $this->extend('Layouts/index') ?>
<?= $this->section('content') ?>


<style>
    #right-panel {
        font-family: 'Roboto', 'sans-serif';
        line-height: 30px;
        padding-left: 10px;
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

    #right-panel {
        float: right;
        width: 34%;
        height: 500px;
        overflow: auto;
    }
</style>







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
                    <h3 class="panel-title">Hasil TSP</h3>
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

                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3" onclick="window.location.href='<?= base_url('/rute'); ?>'">Balik Kemenu Sebelumnya</button>
                    <form action="delete" method="POST" id="myForm">
                        <input type="hidden" value="<?= $id ?>" name="id">
                        <button type="submit" class="btn btn-danger mb-3">Hapus Data</button>
                    </form>
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

    const titik = <?= json_encode(array_values($jsonData->arr_rute)) ?>;
    let cost_per_kilo = <?= $cost_per_kilo; ?>;


    // Teaster 

    // teaster



    function initMap() {
        const directionsService = new google.maps.DirectionsService;
        const directionsDisplay = new google.maps.DirectionsRenderer;
        const map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: defaultCenter
        });
        directionsDisplay.setMap(map);
        directionsDisplay.setPanel(document.getElementById('right-panel'));
        calculateAndDisplayRoute(directionsService, directionsDisplay, map);
    }

    function calculateAndDisplayRoute(directionsService, directionsDisplay, map) {
        directionsService.route({
            origin: <?= json_encode($jsonData->tempatAwal) ?>,
            destination: <?= json_encode($jsonData->destination) ?>,
            waypoints: <?= json_encode($jsonData->waypoint) ?>,
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
                var flightPlanCoordinates = <?= json_encode($jsonData->arr_poly) ?>;
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

    window.initMap = initMap;
</script>


<?= $this->endSection() ?>