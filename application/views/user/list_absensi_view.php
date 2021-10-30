<!-- Content -->
<main>
    <div class="container">
        <div class="text-center">
            <h2>Data Riwayat Absen</h2>
            <p>Data berikut berdasarkan user absen</p>
        </div>

        <div class="row mt-5">
            <div class="col-sm-12">
                <div class="table-responsive mt-3">
                    <table id="tblDataAll" class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                            <tr>
                                <th>No</th>
                                <th>Nama User</th>
                                <th>Tanggal Absen</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Status</th>
                            </tr>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($data_absensi as  $d) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $d["NAMA_USER"]; ?></td>
                                    <td><?= $d["TGL_ABSEN"]; ?></td>
                                    <td><?= $d["JAM_MASUK"]; ?></td>
                                    <td><?= $d["JAM_PULANG"]; ?></td>
                                    <td><?php if ($d["STATUS_USER"] == 1) : ?>
                                            <span class="badge badge-success">Datang tepat waktu</span>
                                        <?php elseif ($d["STATUS_USER"] == 2) : ?>
                                            <span class="badge badge-warning">Terlambat</span>
                                        <?php else : ?>
                                            <span class="badge badge-danger">Bolos</span>
                                        <?php endif; ?>
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