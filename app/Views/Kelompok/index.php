<?= $this->extend('Layouts/index') ?>
<?= $this->section('content') ?>
<?php if (!$berhasil == null) : ?>
    <script>
        swal("<?= $berhasil; ?>", "", "success");
    </script>
<?php endif; ?>

<?php if ($validation->hasError('kode_kelompok') || $validation->hasError('nama_kelompok')) : ?>
    <script>
        swal("Oopsss", "Sepertinya kamu menghapus Kode Kelompok atau Nama Kelompok", "error");
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
                    <a href="/Kelompok/tambah" class="btn btn-primary mb-3">Tambah Data</a>
                </div>
            </div>


            <div class="card-body">
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th>Kode Kelompok</th>
                            <th>Nama Kelompok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kelompok as $k) : ?>
                            <tr>
                                <td><?= $k["kode_kelompok"]; ?></td>
                                <td><?= $k["nama_kelompok"]; ?></td>
                                <td>
                                    <a href="/Kelompok/edit?id=<?= $k["id"]; ?>&kode_kelompok=<?= $k["kode_kelompok"]; ?>&nama_kelompok=<?= $k["nama_kelompok"]; ?>"><span class="badge bg-warning">Edit</span></a>
                                    <a href="/Kelompok/delete?id=<?= $k["kode_kelompok"]; ?>"><span class="badge bg-danger">Delete</span></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>

</section>

<script>
    <?= $this->endSection() ?>