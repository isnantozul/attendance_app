<!-- Content -->
<main>
    <div class="container">
        <?php
        // pesan error/sukses
        if ($this->session->flashdata('pesan')) { ?>
            <div class="alert alert-danger" role="alert">
                <?= $this->session->flashdata('pesan'); ?>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-lg-12">
                <p class="employee-new-title">Detail Karyawan</p>
                <?php echo form_open("data_karyawan/edit/" . $user["ID_USER"]) ?>
                <div class="row mt-2">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="nama_depan">Nama Depan</label>
                            <input disabled="disabled" type="text" class="form-control" id="nama_depan" name="nama_depan" value="<?= set_value('nama_depan') ? set_value('nama_depan') : $user["NAMA_DEPAN"]; ?>" readonly>
                            <?= form_error('nama_depan', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="nama_belakang">Nama Belakang</label>
                            <input disabled="disabled" type="text" class="form-control" id="nama_belakang" name="nama_belakang" value="<?= set_value('nama_belakang') ? set_value('nama_belakang') : $user["NAMA_BELAKANG"]; ?>" readonly>
                            <?= form_error('nama_belakang', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input disabled="disabled" type="date" class="form-control" id="tanggal_lahir" id="tanggal_lahir" name="tanggal_lahir" value="<?= set_value('tanggal_lahir') ? set_value('tanggal_lahir') : $user["TANGGAL_LAHIR"]; ?>">
                            <?= form_error('tanggal_lahir', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input disabled="disabled" type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?= set_value('tempat_lahir') ? set_value('tempat_lahir') : $user["TEMPAT_LAHIR"]; ?>">
                            <?= form_error('tgl_lahir', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div>
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input disabled="disabled" class="form-check-input" type="radio" name="jenis_kelamin" id="L" value="L" <?php if ($user["JENIS_KELAMIN"] == 'L') echo "checked";  ?>>
                            <label class="form-check-label" for="L">
                                Pria
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input disabled="disabled" class="form-check-input" type="radio" name="jenis_kelamin" id="P" value="P" <?php if ($user["JENIS_KELAMIN"] == 'P') echo "checked";  ?>>
                            <label class="form-check-label" for="P">
                                Wanita
                            </label>
                        </div>
                        <?= form_error('jenis_kelamin', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <div>
                            <label for="status_pernikahan">Status Pernikahan</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input disabled="disabled" class="form-check-input" type="radio" name="status_pernikahan" id="1" value="1" <?php if ($user["STATUS_PERNIKAHAN"] == '1') echo "checked";  ?>>
                            <label class="form-check-label" for="1">
                                Menikah
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input disabled="disabled" class="form-check-input" type="radio" name="status_pernikahan" id="2" value="2" <?php if ($user["STATUS_PERNIKAHAN"] == '2') echo "checked";  ?>>
                            <label class="form-check-label" for="2">
                                Cerai
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input disabled="disabled" class="form-check-input" type="radio" name="status_pernikahan" id="3" value="3" <?php if ($user["STATUS_PERNIKAHAN"] == '3') echo "checked";  ?>>
                            <label class="form-check-label" for="3">
                                Single
                            </label>
                        </div>
                        <?= form_error('status_pernikahan', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-1">
                        <p class="form-address-title">Address</p>
                    </div>
                    <div class="col-lg-11">
                        <hr>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input disabled="disabled" type="text" class="form-control" id="alamat" name="alamat" value="<?= set_value('alamat') ? set_value('alamat') : $user["ALAMAT"]; ?>">
                            <?= form_error('alamat', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="alamat2">Alamat 2 (optional)</label>
                            <input disabled="disabled" type="text" class="form-control" id="alamat2" name="alamat2" value="<?= set_value('alamat2') ? set_value('alamat2') : $user["ALAMAT2"]; ?>">
                            <?= form_error('alamat2', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <input type="hidden" id="selected_prov" value="<?= $user["PROVINSI"] ?>">
                            <label for="provinsi">Provinsi</label>
                            <select disabled="disabled" name="provinsi" id="provinsi-list" class="form-control">
                            </select>
                            <?= form_error('provinsi', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <input type="hidden" id="selected_kota" value="<?= $user["KOTA"] ?>">
                            <label for="kota">Kabupaten/Kota</label>
                            <select disabled="disabled" name="kota" id="kota-list" class="form-control">
                            </select>
                        </div>
                        <?= form_error('kota', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <input type="hidden" id="selected_kecamatan" value="<?= $user["KECAMATAN"] ?>">
                            <label for="kecamatan">Kecamatan</label>
                            <select disabled="disabled" name="kecamatan" id="kecamatan-list" class="form-control">
                            </select>
                        </div>
                        <?= form_error('kecamatan', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <input type="hidden" id="selected_kelurahan" value="<?= $user["KELURAHAN"] ?>">
                            <label for="kelurahan">Kelurahan</label>
                            <select disabled="disabled" name="kelurahan" id="kelurahan-list" class="form-control">
                            </select>
                        </div>
                        <?= form_error('kelurahan', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="kode_pos">Kode Pos</label>
                            <input disabled="disabled" type="text" class="form-control" id="kode_pos" name="kode_pos" value="<?= set_value('kode_pos') ? set_value('kode_pos') : $user["KODE_POS"] ?>">
                        </div>
                        <?= form_error('kode_pos', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-10"></div>
                    <div class="col-lg-2">
                        <a href="<?= base_url("data_karyawan") ?>" class="btn btn-orange">Kembali</a>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</main>
<!-- End of Content -->