<!-- Content -->
<?php 
$nama = $user["NAMA_USER"];
$upload_dir = "uploads/face-recognition/labeled-images/".$nama."/";?>
<main>
    <div class="container">
        <?php 
        // pesan error/sukses
            if($this->session->flashdata('pesan'))
            { ?>
                <div class="alert alert-danger" role="alert">
                    <?=$this->session->flashdata('pesan');?>
                </div>    
            <?php }?>
        <input id="user_id" type="hidden" value="<?=$user["ID_USER"];?>">
        <input id="user_name" type="hidden" value="<?=$nama;?>">
        <div class="text-center">
            <h2>Upload Foto Kamu, <?=$user["NAMA_DEPAN"]?></h2>
            <p>Pastikan seluruh wajah masuk ke dalam frame foto</p>
            <?php echo form_open("user/check_upload_foto/".$user["ID_USER"]);?>
                <input type="submit" class="btn btn-orange ml-3" value="Sudah Upload Foto">  
            <?php echo form_close();?>
        </div>

        <div class="row mt-5">
            <div class="col-sm-4">
            <div id="card-camera-1" class="card" style="width: 18rem;">
                <?php if(file_exists($upload_dir."1.jpg")):?>
                    <img id="image-up-1" src="<?=base_url("uploads/face-recognition/labeled-images/".$nama."/"."1.jpg")?>" class="card-img-top" alt="card-foto-1">
                <?php else:?>
                     <svg id="svg-1" class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#6c757d"></rect><text x="30%" y="50%" fill="#dee2e6" dy=".3em">Belum ada foto</text></svg>
                <?php endif;?>
                <div id="card-body-1" class="card-body text-center">
                    <p class="card-text">Foto Pertama</p>
                    <a href="#" onclick="run_camera('Pertama',1)" class="btn btn-blue-navy non-uppercase">Buka Kamera</a>
                </div>
            </div>
            </div>
            <div class="col-sm-4">
            <div id="card-camera-2" class="card" style="width: 18rem;">
                <?php if(file_exists($upload_dir."2.jpg")):?>
                    <img id="image-up-2" src="<?=base_url("uploads/face-recognition/labeled-images/".$nama."/"."2.jpg")?>" class="card-img-top" alt="card-foto-2">
                <?php else:?>
                     <svg id="svg-2" class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#6c757d"></rect><text x="30%" y="50%" fill="#dee2e6" dy=".3em">Belum ada foto</text></svg>
                <?php endif;?>
                <div id="card-body-2" class="card-body text-center">
                    <p class="card-text">Foto Kedua</p>
                    <a href="#" onclick="run_camera('Kedua',2)" class="btn btn-blue-navy non-uppercase">Buka Kamera</a>
                </div>
            </div>
            </div>
            <div class="col-sm-4">
            <div id="card-camera-3" class="card" style="width: 18rem;">
                <?php if(file_exists($upload_dir."3.jpg")):?>
                    <img id="image-up-3" src="<?=base_url("uploads/face-recognition/labeled-images/".$nama."/"."3.jpg")?>" class="card-img-top" alt="card-foto-3">
                <?php else:?>
                     <svg id="svg-3" class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#6c757d"></rect><text x="30%" y="50%" fill="#dee2e6" dy=".3em">Belum ada foto</text></svg>
                <?php endif;?>
                <div id="card-body-3" class="card-body text-center">
                    <p class="card-text">Foto Ketiga</p>
                    <a href="#" onclick="run_camera('Ketiga',3)" class="btn btn-blue-navy non-uppercase">Buka Kamera</a>
                </div>
            </div>
            </div>
        </div>
    </div>
</main>
