<?= $this->extend('Layouts/index') ?>

<?= $this->section('content') ?>
<section id="input-style">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Kelompok</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="update" method="POST">
                            <input type="hidden" name="id" id="id" value="<?= $getData['id']; ?>">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="kode_kelompok">Kode</label>
                                    <input name="kode_kelompok" type="text" id="kode_kelompok"
                                        class="form-control round" value="<?= $getData['kode_kelompok']; ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nama_kelompok">Nama Kelompok</label>
                                    <input name="nama_kelompok" type="text" id="nama_kelompok"
                                        class="form-control square" placeholder=""
                                        value="<?= $getData['nama_kelompok']; ?>">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Edit Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>