<html>

<head>
    <title>Export Data Absensi Destinasi Computindo</title>
</head>

<body>
    <style type="text/css">
        body {
            font-family: sans-serif;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #3c3c3c;
            padding: 3px 8px;

        }

        a {
            background: blue;
            color: #fff;
            padding: 8px 10px;
            text-decoration: none;
            border-radius: 2px;
        }

        .tepat-waktu {
            color: lightgreen;
        }

        .terlambat {
            color: yellow;
        }

        .bolos {
            color: red;
        }
    </style>

    <?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Data Absensi.xls");
    ?>

    <center>
        <h1>Export Data Absensi <br /> Destinasi Computindo</h1>
    </center>

    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama User</th>
            <th>Tanggal Absen</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
            <th>Status</th>
        </tr>
        <?php $i = 1;
        foreach ($data_absensi as  $d) : ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $d["NAMA_USER"]; ?></td>
                <td><?= $d["TGL_ABSEN"]; ?></td>
                <td><?= $d["JAM_MASUK"]; ?></td>
                <td><?= $d["JAM_PULANG"]; ?></td>
                <?php if ($d["STATUS_USER"] == 1) : ?>
                    <td class="tepat-waktu">Datang tepat waktu</td>
                <?php elseif ($d["STATUS_USER"] == 2) : ?>
                    <td class="terlambat">Terlambat</td>
                <?php else : ?>
                    <td class="bolos">Bolos</td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>