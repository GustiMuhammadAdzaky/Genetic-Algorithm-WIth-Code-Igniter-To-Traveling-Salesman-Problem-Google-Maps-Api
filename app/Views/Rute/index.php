<?= $this->extend('Layouts/index') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="card">
        <div class="card-body">
            <h1>Selamat Datang di Menu <?= $title; ?></h1>
        </div>
    </div>




    <section class="section">
        <div class="card">
            <div class="card-header">
                Tabel <?= $title; ?>
            </div>


            <div class="card-body">
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th>Nama Kelompok</th>
                            <th>Maps</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $mdl) : ?>
                            <tr>
                                <td><?= $mdl["nama_kelompok"]; ?></td>
                                <td><a href="/rute/detail?data=<?= urlencode($mdl["json_data"]); ?>&id=<?= $mdl["id"]; ?>"><i class="bi bi-geo-alt-fill"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>

</section>
<?= $this->endSection() ?>