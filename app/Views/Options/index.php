<?= $this->extend('Layouts/index') ?>

<?= $this->section('content') ?>


<style>
    .custom-button {
        width: 20%;
    }

    .custom-color {
        color: red;
    }
</style>


<section class="section">
    <div class="card">
        <div class="card-body">
            <h1>Selamat Datang di Menu <?= $title; ?></h1>
        </div>
    </div>
</section>

<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Inputkan estimasi biaya perkilometer !</h3>
                    <p class="text-center custom-color">Data Ini Akan Mempengaruhi Rute Tersimpan</p>
                </div>
                <form action="Options/update" method="POST">
                    <div class="panel-body">
                        <div class="text-center">
                            <div class="mx-auto" style="width: 50%;">
                                <input class="form-control custom-input text-center" type="text" name="biaya" value="<?= $biaya; ?>" placeholder="">

                            </div>
                            <button type="submit" class="btn custom-button btn-primary mt-2">Ganti</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        const form = document.querySelector('form');
        const inputElement = document.querySelector('input[name="biaya"]');
        const errorElement = document.createElement('div');
        errorElement.classList.add('invalid-feedback');
        errorElement.textContent = 'Tolong inputkan data terlebih dahulu!';

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah pengiriman form secara langsung

            if (inputElement.value === '') {
                inputElement.classList.add('is-invalid');
                inputElement.parentNode.appendChild(errorElement);
            } else {
                // Hapus pesan kesalahan jika ada
                if (inputElement.classList.contains('is-invalid')) {
                    inputElement.classList.remove('is-invalid');
                    inputElement.parentNode.removeChild(errorElement);
                }

                // Tambahkan SweetAlert untuk notifikasi sukses dengan logo ceklis
                swal(
                    'Terupdate',
                    'Kamu berhasil Mengupdate Data',
                    'success'
                ).then(function() {
                    form.submit(); // Kirim form setelah pengguna menekan tombol OK pada SweetAlert
                });
            }
        });
    </script>



</section>


<?= $this->endSection() ?>