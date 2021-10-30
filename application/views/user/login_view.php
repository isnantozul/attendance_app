 <!-- Content -->
 <main>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="detected-face text-center" id="detected-face">  
                    <!-- <img class="tabler-face" src="assets/img/rectangle .png" width="400" height="400" alt="rectangle_face"> -->
                    <video id="video" class="tabler-face" width="400" height="400" autoplay muted></video>
                    <img class="frame-face" src="<?=base_url('assets/img/frame.png')?>" width="270" height="270" alt="rectangle_face">
                    <p id="clocknow" class="timer-text"></p>
                </div>
            </div>
            <div class="col-lg-6">
                <div id="square-info" class="square-info">
                    <div class="header-square">
                        Informasi Absensi
                    </div>
                    <div class="content-square">
                        <p class="employee-info-title">Panduan Penggunaan</p>
                        <div class="row employee-info-text">
                            <div class="col-sm-1">1</div>
                            <div class="col-sm-8">Tunggu hingga kamera terbuka</div>
                        </div>
                        <div class="row employee-info-text">
                            <div class="col-sm-1">2</div>
                            <div class="col-sm-8">Pastikan wajah masuk ke seluruh frame</div>
                        </div>
                        <div class="row employee-info-text">
                            <div class="col-sm-1">3</div>
                            <div class="col-sm-8">Tunggu proses absensi selesai</div>
                        </div>
                        <div class="row employee-info-text">
                            <div class="col-sm-1">4</div>
                            <div class="col-sm-8">Informasi karyawan akan terdeteksi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
<!-- End of Content -->
    