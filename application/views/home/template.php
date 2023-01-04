<?php $admin = $this->db->get_where('db_user',['id' => $this->session->userdata('user_id'), 'group_id' => 1])->row(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/dist/css/adminlte.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url() ?>assets/adminlte3/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/adminlte3/plugins/sweetalert2/sweetalert2.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/adminlte3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/adminlte3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">

    <script src="<?= base_url('assets/adminlte3/plugins/jquery/jquery.min.js') ?>"></script>
    

    <script src="<?= base_url(); ?>/assets/adminlte3/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>/assets/adminlte3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>/assets/adminlte3/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>/assets/adminlte3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>


    <title>Home Super Admin</title>
</head>
<body style="background: #f0f0f0">

<!-- Image and text -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="<?= base_url('assets/img/avatar.png'); ?>" width="30" height="30" class="d-inline-block align-top rounded-circle" alt="">
            <?= $admin->nama ?>
        </a>
            <a class="nav-link text-light" style="text-decoration: none" href="<?= site_url('home/logout') ?>"><i class="fas fa-sign-out-alt"></i>Logout</a>
  </div>
</nav>



<?php $this->load->view($view); ?>



<script src="<?= base_url() ?>assets/adminlte3/plugins/sweetalert2/sweetalert2.min.js"></script>    
<script src="<?= base_url() ?>assets/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>