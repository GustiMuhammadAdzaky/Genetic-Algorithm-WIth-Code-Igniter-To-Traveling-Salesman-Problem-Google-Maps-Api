<?= $this->extend('Layouts/index') ?>

<?= $this->section('content') ?>
<?php if(!$berhasil == null) : ?>
<script>
swal("<?= $berhasil; ?>", "", "success");
</script>
<?php endif; ?>
<?php if($validation->getErrors() != null) : ?>
<script>
swal("Sepertinya Ada yang salah", "Coba cek lagi form Edit anda!", "error");
</script>
<?php endif; ?>
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
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="/Titik/tambah" class="btn btn-primary mb-3">Tambah Data</a>
                </div>
            </div>


            <div class="card-body">
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th>Kelompok</th>
                            <th>Kode</th>
                            <th>Nama Titik</th>
                            <th>Lat</th>
                            <th>Lng</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($titik as $t) : ?>
                        <tr>
                            <td><?= $t["kode_kelompok"]; ?></td>
                            <td><?= $t["kode_titik"]; ?></td>
                            <td><?= $t["nama_titik"]; ?></td>
                            <td><?= $t["lat"]; ?></td>
                            <td><?= $t["lng"]; ?></td>
                            <td>
                                <a
                                    href="/Titik/edit?id=<?= $t["id"]; ?>&kode_titik=<?= $t["kode_titik"]; ?>&nama_titik=<?= $t["nama_titik"]; ?>&kode_kelompok=<?= $t["kode_kelompok"]; ?>&lat=<?= $t["lat"]; ?>&lng=<?= $t["lng"]; ?>"><span
                                        class="badge bg-warning">Edit</span></a>
                                <a href="/Titik/delete?id=<?= $t["kode_titik"]; ?>"><span
                                        class="badge bg-danger">Delete</span></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>

</section>
<?= $this->endSection() ?>