<?= $this->extend('Layouts/index') ?>

<?= $this->section('content') ?>
<section id="input-style">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Kelompok</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="save" method="POST">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="kode_kelompok">Kode</label>
                                    <input name="kode_kelompok" type="text" id="kode_kelompok"
                                        class="form-control round <?= ($validation->hasError('kode_kelompok')) ? 'is-invalid' : ''; ?>"
                                        value="<?= $kodeOtomatis; ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('kode_kelompok'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nama_kelompok">Nama Kelompok</label>
                                    <input name="nama_kelompok" type="text" id="nama_kelompok"
                                        class="form-control square <?= ($validation->hasError('nama_kelompok')) ? 'is-invalid' : ''; ?>"
                                        placeholder="Silahkan isi Nama Kelompok">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama_kelompok'); ?>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>