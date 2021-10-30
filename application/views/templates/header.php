<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

  <!-- my style -->
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

  <!-- my font -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Viga&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

  <!-- Datatables -->
  <link rel="stylesheet" href="<?= base_url("assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") ?>">
  <link rel="stylesheet" href="<?= base_url("assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css") ?>">

  <?php if (isset($face_register) && $face_register) : ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
  <?php endif; ?>

  <?php if (isset($face_detect) && $face_detect) : ?>
    <script defer src="<?= base_url("assets/js/face-api.min.js") ?>"></script>
    <script defer src="<?= base_url("assets/js/script.js") ?>"></script>
  <?php endif; ?>

  <title>Resident List</title>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url(); ?>">
        <img src="<?= base_url('assets/img/logo.png') ?>" width="30" height="30" class="d-inline-block align-top" alt="">
        Destinasi Computindo
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <?php $current_link = $this->uri->segment(1); ?>
        <ul class="navbar-nav ml-auto mr-3">
          <li class="nav-item mx-2">
            <a class="nav-link <?= $current_link == "home" || $current_link == "" ? 'active' : '' ?>" href="<?= base_url("home") ?>">Home <span class="sr-only">(current)</span></a>
          </li>
          <?php if ($this->session->userdata('admin_logged_in')) : ?>
            <li class="nav-item mx-2">
              <a class="nav-link <?= $current_link == "data_karyawan" ? 'active' : '' ?>" href="<?= base_url("data_karyawan") ?>">Data Karyawan</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link <?= $current_link == "data_absensi" ? 'active' : '' ?>" href="<?= base_url("data_absensi") ?>">Data Absensi</a>
            </li>
          <?php else : ?>
            <li class="nav-item mx-2">
              <a class="nav-link <?= $current_link == "user" ? 'active' : '' ?>" href="<?= base_url("user/register") ?>">Registrasi</a>
            </li>
          <?php endif; ?>
        </ul>

        <?php if ($this->session->userdata('admin_logged_in')) : ?>
          <a href="<?= base_url("admin/logout") ?>" onclick="return confirm('Yakin logout?');" class="btn btn-blue-navy">Logout</a>
        <?php else : ?>
          <a href="<?= base_url("admin/login") ?>" class="btn btn-blue-navy">Masuk</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>
  <!-- Akhir Navbar -->