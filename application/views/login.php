<?php
$profile = $this->master_model->getProfile(1)->row();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $profile->nama_lembaga ?> - <?= titleWebsite() ?></title>
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

<body class="hold-transition login-page">

    <div class="login-box">
        <div class="login-logo">
            <img src="<?= base_url('uploads/img/' . $profile->logo) ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-5" width="160px" style="opacity: .8">
            
        </div>
        <div class="card card-success shadow">
            <div class="card-header text-center">
                <?= $profile->nama_lembaga ?>
            </div>
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form action="<?= site_url('login/proses/') ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="number" name="email" class="form-control" placeholder="Phone number" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                        </div>
                        <div class="col-4">
                            <button type="submit" name="login" class="btn btn-success btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
            </div>
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