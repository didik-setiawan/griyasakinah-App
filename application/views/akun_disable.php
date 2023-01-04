<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Account Disable - <?= titleWebsite() ?></title>
    <?php
        $profile = $this->master_model->getProfile(1)->row();
    ?>
    <link rel="shortcut icon" type="image/jpg" href="<?= site_url('/uploads/img/' . $profile->logo) ?>" />

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url(); ?>assets/css/sb-admin-2.css" rel="stylesheet">

    <style>
        .bg-login-disabled {
            background: url("<?= base_url('assets/img/locked.jpg') ?>");
            background-position: center;
            background-size: cover;
        }
    </style>

</head>

<body class="bg-gradient-info">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-1 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-4 d-none d-lg-block bg-login-disabled"></div>
                            <div class="col-lg-8">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-danger mb-4"><i class="fas fa-user-slash"></i> Account Disable</h1>
                                    </div>
                                    <div class="text-center">
                                        <div class="container">
                                            <h1 class="h6">
                                                Maaf <b>Akun</b> atau <b>Group</b> anda sedang ditangguhkan, silahkan hubungi <b>Admin</b> untuk mengaktifkan nya
                                                <br><br><br>
                                                <a href="<?php echo base_url('login') ?>" class="btn btn-primary btn-flat shadow"><i class="fas fa-arrow-circle-left"></i> back login</a>
                                            </h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url(); ?>assets/js/sb-admin-2.min.js"></script>

</body>

</html>