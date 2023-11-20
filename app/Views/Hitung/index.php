<?= $this->extend('Layouts/index') ?>

<?= $this->section('content') ?>


<?php if ($validation->getErrors() != null) : ?>
    <script>
        swal("Sepertinya Ada yang salah", "Coba cek lagi", "error");
    </script>
<?php endif; ?>




<section class="section">

    <div class="card">
        <div class="card-body">
            <h1>Selamat Datang Pada Menu <?= $title; ?></h1>


        </div>
    </div>
    <select id="mySelect" class="form-select" aria-label="form-select" onchange="myFunction()">
        <option>Pilih Kelompok</option>
        <?php foreach ($kelompok as $k) : ?>
            <option value="<?= $k->kode_kelompok; ?>&nama_kelompok=<?= $k->nama_kelompok; ?>"><?= $k->nama_kelompok; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <section class="section mt-3">
        <?php if ($getData != null) { ?>
            <div class="row match-height">
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Horizontal Form</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-horizontal" method="GET" action="/Hitung/generate" onsubmit="return validateForm();">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Titik Awal</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <select name="titikAwal" class="form-select" aria-label="Default select example">
                                                    <?php foreach ($titikOption as $to) : ?>
                                                        <option value='<?= $to->kode_titik; ?>'>
                                                            <?= $to->nama_titik; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Titik tujuan</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <select id="pemilihanTitik" class="form-select" aria-label="Default select example" onchange="tambahTujuan()">
                                                    <option value="">Pilih Titik Tujuan</option>
                                                    <?php foreach ($titikOption as $to) : ?>
                                                        <option value='{
                                                        "kode":"<?= $to->kode_titik; ?>",
                                                        "data_lat":"<?= $to->lat; ?>",
                                                        "data_lng":"<?= $to->lng; ?>"}'>
                                                            <?= $to->nama_titik; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div id="myDIV">
                                                    <input type="hidden" id="select2" name="titikTujuan" value="">
                                                    <span id="box" class="badge rounded-pill bg-success mt-3"></span>
                                                </div>
                                                <div id="hiddenCode">
                                                    <input type="hidden" name="kode_kelompok" value="<?= $getData["kode_kelompok"]; ?>">
                                                    <span id="box" class="badge rounded-pill bg-success mt-3"></span>
                                                </div>

                                                <input type="hidden" name="nama_kelompok" value="<?= $getData["nama_kelompok"]; ?>">

                                            </div>
                                            <!-- Atur Terlebih dahulu -->
                                            <div class="col-md-4">
                                                <label>Kromosom</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" id="" class="form-control" name="num_kromosom" placeholder="Berikan kisaran kromosom minimal 10, dan maksimal 50">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Max gen</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="max_generation" id="max_generation" class="form-control" name="max_generation" placeholder="Berikan kisaran generasi minimal 1, dan maksimal 100">
                                            </div>
                                            <div class="col-md-4">
                                                <label> <input type="checkbox" name="debug">Tampilkan Proses </label>
                                            </div>
                                            <div class="col-sm-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary me-1 mb-1">Hitung</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>
    </section>
</section>

<br>
<br>

<br>
<br>


<br>
<br>

<br>
<br>

<br>
<br>


<br>


<script>
    function validateForm() {
        // Validasi input Titik Awal
        var titikAwal = document.getElementsByName("titikAwal")[0].value;
        if (titikAwal === "") {
            alert("Titik Awal harus diisi");
            return false;
        }

        // Validasi input Titik Tujuan
        var titikTujuan = document.getElementsByName("titikTujuan")[0].value;
        if (titikTujuan === "") {
            alert("Titik Tujuan harus diisi");
            return false;
        }

        // Validasi input Kromosom
        var numKromosom = parseInt(document.getElementsByName("num_kromosom")[0].value);
        if (isNaN(numKromosom) || numKromosom < 10 || numKromosom > 50) {
            alert("Kromosom harus diisi dengan angka antara 10 dan 50");
            return false;
        }

        // Validasi input Max Generasi
        var maxGeneration = parseInt(document.getElementsByName("max_generation")[0].value);
        if (isNaN(maxGeneration) || maxGeneration < 1 || maxGeneration > 100) {
            alert("Max Generasi harus diisi dengan angka antara 1 dan 100");
            return false;
        }

        return true;
    }


    function myFunction() {
        const select = document.getElementById("mySelect").value;
        // alert(select);
        const href = "<?= base_url(); ?>/Hitung?kode_kelompok=" + select;
        window.location.href = href;
    }
    // if (document.getElementById("box")) {

    // }


    const array = [];


    function tambahTujuan() {
        const pemilihanTitik = JSON.parse(document.getElementById("pemilihanTitik").value);
        let columnElement = document.createElement("span");
        columnElement.setAttribute("class", "badge rounded-pill bg-success mt-3");
        columnElement.innerHTML = pemilihanTitik.kode;
        document.getElementById("myDIV").appendChild(columnElement);
        array[array.length] = pemilihanTitik.kode;
        document.getElementById("select2").value = array;
    }
</script>
<?= $this->endSection() ?>