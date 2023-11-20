<?= $this->extend('Layouts/index') ?>

<?= $this->section('content') ?>
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
            <h3>Tujuan Proyek</h3>
            <p>
                Proyek ini bertujuan untuk mengurangi jarak tempuh, mengestimasi biaya, dan waktu perjalanan kurir ekspedisi pada J&T Paris 2 melalui penggunaan algoritma genetika untuk memecahkan Traveling Salesman Problem (TSP). Solusi ini diimplementasikan dalam suatu sistem berbasis Web GIS yang memungkinkan Anda mengakses dan mengoptimalkan rute kurir dengan lebih efisien.
            </p>
            <h3>Fitur Utama</h3>
            <p>
                1. Visualisasi Rute Kurir:
                Lihat visualisasi peta interaktif dengan rute perjalanan kurir yang dihasilkan oleh algoritma genetika. Setiap rute akan dianotasikan dengan informasi jarak tempuh dan estimasi waktu tempuh.
                <br>
                2. Pengaturan Alternatif Rute:
                Eksplorasi berbagai alternatif rute yang dihasilkan oleh algoritma genetika. Bandingkan jarak, waktu tempuh, dan kriteria lain untuk memilih rute yang paling sesuai.
                <br>
                3. Optimasi Dinamis:
                Dapatkan rute terbaru berdasarkan perubahan dinamis dalam jadwal pengiriman atau kondisi lalu lintas. Sistem akan memberikan solusi yang diperbarui untuk memastikan efisiensi dalam pengiriman.
                <br>
                4. Informasi Atribut Lokasi:
                Dapatkan informasi detail tentang setiap lokasi yang harus dikunjungi oleh kurir, termasuk alamat, jam operasional, dan informasi penting lainnya.
            </p>
        </div>
    </div>
</section>
<?= $this->endSection() ?>