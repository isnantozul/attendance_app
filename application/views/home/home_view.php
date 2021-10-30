<!-- Content -->
<main>
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <img class="tabler-face" src="<?=base_url("assets/img/tabler_face-id.png")?>" alt="tabler_face">
            </div>
            <div class="col-lg-1">
                <div class="vl"></div>
            </div>
            <?php if($this->session->userdata('admin_logged_in')):?>
            <div class="col-lg-6">
                <p class="title-page">Home Admin</p>
                <p class="text-title">Face Recognition</p>
                <p class="text-desc">Aplikasi absensi berbasis web menggunakan teknologi deteksi wajah untuk karyawan CV Destinasi Computindo</p>
            </div>
            <?php else:?>
                <div class="col-lg-6">
                <p class="title-page">Absensi Karyawan</p>
                <p class="text-title">Face Recognition</p>
                <p class="text-desc">Aplikasi absensi berbasis web menggunakan teknologi deteksi wajah untuk karyawan CV Destinasi Computindo</p>
                <a href="<?=site_url("user")?>" class="btn btn-orange">Absen Sekarang</a>
            </div>
            <?php endif;?>
        </div>
    </div>
    </main>
<!-- End of Content -->