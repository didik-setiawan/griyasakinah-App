<?php
$profile = $this->master_model->getProfile(1)->row();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $profile->nama_lembaga ?> - PT. TUNGGAL GRIYA SAKINAH</title>
    <?php
        $profile = $this->master_model->getProfile(1)->row();
    ?>
    <link rel="shortcut icon" type="image/jpg" href="<?= site_url('/uploads/img/' . $profile->logo) ?>" />
    <!-- Tell the browser to be responsive to screen width -->

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= base_url('assets/css/ionicons.min.css') ?>">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/dist/css/adminlte.min.css') ?>">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition">

<div class="container">
    <div class="row justify-content-center mt-5">
        <h4>Silahkan Pililh Perumahaan</h4>
    </div>
    <div class="row mt-5 justify-content-center">
        <?php foreach($perumahan as $p){ ?>
        <div class="col-md-3 m-3">
        <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="card-title m-0">Perumahan <?= $p['nama_perumahan'] ?></h5>
              </div>
              <div class="card-body">

                <p class="card-text">Lokasi : <?= $p['kabupaten'] ?></p>
                <form action="<?= base_url('index.php/dashboard/masuk_perumahan') ?>" method="POST">
                            <input type="hidden" name="id_perumahan" value="<?= $p['id_perumahan'] ?>">
                            <button type="submit" class="btn btn-primary">
                            Masuk
                            </button>
                        </form>
              </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

    <!-- jQuery -->
    <script src="<?= base_url('assets/adminlte3/plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/adminlte3/dist/js/adminlte.min.js') ?>"></script>

</body>

</html>