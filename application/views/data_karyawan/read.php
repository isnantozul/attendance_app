<!-- Content -->
<main>
    <div class="container">
        <div class="text-center">
            <h2>Data Karyawan</h2>
            <p>Data karyawan pada cv destinasi computindo</p>
        </div>

        <div class="row mt-5">
            <?php
            // pesan error/sukses
            if ($this->session->flashdata('pesan-sukses')) { ?>
                <div class="alert alert-success" role="alert">
                    <?= $this->session->flashdata('pesan-sukses'); ?>
                </div>
            <?php } ?>
            <div class="col-sm-12">
                <div class="table-responsive mt-3">
                    <table id="tblDataAll" class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                            <tr>
                                <th>No</th>
                                <th>Nama User</th>
                                <th>Tanggal Lahir</th>
                                <th>Tempat Lahir</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($data_karyawan as  $d) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $d["NAMA_USER"]; ?></td>
                                    <td><?= $d["TANGGAL_LAHIR"]; ?></td>
                                    <td><?= $d["TEMPAT_LAHIR"]; ?></td>
                                    <td><?= $d["ALAMAT"]; ?></td>
                                    <td>
                                        <a href="<?= base_url("data_karyawan/delete/" . $d["ID_USER"]) ?>" class="badge badge-danger">Hapus</a>
                                        <a href="<?= base_url("data_karyawan/edit/" . $d["ID_USER"]) ?>" class="badge badge-warning">Edit</a>
                                        <a href="<?= base_url("data_karyawan/detail/" . $d["ID_USER"]) ?>" class="badge badge-info">Detail</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>