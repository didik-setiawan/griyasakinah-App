<?php
$urlnya = cek_url();
$alt_urlnya = $this->uri->segment(1) . '/';
$alt_urlnya2 = $alt_urlnya . $this->uri->segment(2) . '/';

$user_avatar    = $this->fungsi->user_login()->avatar;
$username       = $this->fungsi->user_login()->nama;
$idLembaga      = $this->fungsi->user_login()->id_lembaga;

$user = $this->session->userdata('group_id');

if (!empty($user_avatar)) {
    $user_avatar = base_url('uploads/img/') . $user_avatar;
} else {
    $user_avatar = base_url('assets/img/avatar.png');
}
$profile = $this->master_model->getProfile(1)->row();


?>
<!DOCTYPE html>
<html>

<head>
    <script>
        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('txt').innerHTML =
                h + ":" + m + ":" + s;
            var t = setTimeout(startTime, 500);
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i
            }; // add zero in front of numbers < 10
            return i;
        }
    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $profile->nama_lembaga ?> - <?= titleWebsite() ?></title>
    <!-- ini diubah dengan images profile  -->
    <link rel="shortcut icon" type="image/jpg" href="<?= site_url('/uploads/img/' . $profile->logo) ?>" />

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/dist/css/ionicons.min.css') ?>">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/plugins/select2/css/select2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/plugins/jqvmap/jqvmap.min.css') ?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/dist/css/adminlte.min.css') ?>">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/plugins/daterangepicker/daterangepicker.css') ?>">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/plugins/summernote/summernote-bs4.css') ?>">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>

        .showImage:hover {
            cursor: pointer;
        }

    </style>

</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed" onload="startTime()">

    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="<?= site_url() ?>" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" role="button">
                        <span class="h4" id="txt"></span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link btn" data-toggle="dropdown" href="<?= site_url() ?>" role="button">
                        <i class="fas fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header"><?= $username ?></span>
                        <div class="dropdown-divider"></div>
                        <a href="<?= site_url('profile/') ?>" class="dropdown-item">
                            <i class="fas fa-user-circle mr-2"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?= site_url('profile/') ?>" class="dropdown-item">
                            <i class="fas fa-key mr-2"></i> Change Password
                        </a>
                        <?php if($user == 1){ ?>
                        <div class="dropdown-divider"></div>
                        <a href="<?= site_url('home/') ?>" class="dropdown-item">
                            <i class="fa fa-arrow-right mr-2"></i> Back to Home
                        </a>
                        <?php } ?>
                        <div class="dropdown-divider"></div>
                        <a href="<?= site_url('login/logout/') ?>" class="dropdown-item dropdown-footer">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= site_url() ?>" class="brand-link elevation-4">
                <img src="<?= base_url('uploads/img/' . $profile->logo) ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><?= $profile->judul_web ?></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= $user_avatar ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="<?= site_url('profile/') ?>" class="d-block <?= $urlnya == 'profile/' ? 'text-warning text-bold' : NULL ?>"><?= $username ?></a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

<?php
    $type0 = $this->perum->getAccessMenu1('0', $user);
    $type1 = $this->perum->getAccessMenu1('1', $user);
    // $type0 = $this->db->get_where('menu',['type' => 0])->result();
    // $type1 = $this->db->get_where('menu',['type' => 1])->result();
?>

<?php foreach($type0 as $t0){ ?>
    <li class="nav-item">
        <a href="<?= site_url('/') . $t0->url ?>" class="nav-link">
        <i class="<?= $t0->icon ?>"></i>
        <p><?= $t0->nama_menu; ?></p>
        </a>
    </li>
<?php } ?>

<?php foreach($type1 as $t1){ 
    $type2 = $this->perum->getAccessMenu2('2', $t1->id_menu, $user);
    $type3 = $this->perum->getAccessMenu2('3', $t1->id_menu, $user);
    // $type2 = $this->db->get_where('menu',['type' => 2, 'parent' => $t1->id_menu])->result();
    // $type3 = $this->db->get_where('menu',['type' => 3, 'parent' => $t1->id_menu])->result();
?>
    <li class="nav-item">
        <a href="<?= site_url('/') . $t1->url; ?>" class="nav-link">
            <i class="<?= $t1->icon ?>"></i>
            <p>
                <?= $t1->nama_menu ?>
            <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <?php foreach($type3 as $t3){ ?>
                <li class="nav-item">
                    <a href="<?= site_url('/') . $t3->url; ?>" class="nav-link">
                    <i class="<?= $t3->icon ?>"></i>
                    <p><?= $t3->nama_menu ?></p>
                    </a>
                </li>
            <?php } ?>
        </ul>

        <?php foreach($type2 as $t2){ 
            
            $type32 = $this->perum->getAccessMenu2('3', $t2->id_menu, $user);
            $type42 = $this->perum->getAccessMenu2('4', $t2->id_menu, $user);
        ?>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="<?= $t2->url; ?>" class="nav-link">
                    <i class="<?= $t2->icon ?>"></i>
                    <p>
                    <?= $t2->nama_menu ?>
                    <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <?php foreach($type32 as $t32){ 
                    ?>
                    <li class="nav-item">
                        <a href="<?= site_url('/') . $t32->url ?>" class="nav-link">
                            <i class="<?= $t32->icon ?>"></i>
                            <p><?= $t32->nama_menu ?></p>
                        </a>
                    </li>
                    <?php } ?>

                  
                       <?php foreach($type42 as $t42){ 
                            $type43 = $this->perum->getAccessMenu2('3', $t42->id_menu, $user);
                        ?>
                            <li class="nav-item">
                                <a href="<?= site_url('/') . $t42->url; ?>" class="nav-link">
                                <i class="<?= $t42->icon ?>"></i>
                                    <p>
                                    <?= $t42->nama_menu ?>
                                    <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <?php foreach($type43 as $t43){ ?>
                                    <li class="nav-item">
                                        <a href="<?= site_url('/') . $t43->url ?>" class="nav-link">
                                        <i class="<?= $t43->icon ?>"></i>
                                        <p><?= $t43->nama_menu; ?></p>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                    


                </ul>
            </li>
        </ul>
        <?php } ?>
        

    </li>
<?php } ?>







</ul>
</nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" width="100%">
            <?php
            echo $contents;
            ?>
        </div>
        <!-- /.content-wrapper -->

        <!-- <a id="back-to-top" href="<?= site_url() ?>" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a> -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                            </div>
            <strong>Copyright &copy; 2022  All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="<?= base_url('assets/adminlte3/plugins/jquery/jquery.min.js') ?>"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?= base_url('assets/adminlte3/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script> -->

<script src="<?= base_url('assets/js/jquerymask/dist/jquery.mask.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquerymask/dist/jquery.mask.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url('assets/adminlte3/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
    <!-- ChartJS -->
    <script src="<?= base_url('assets/adminlte3/plugins/chart.js/Chart.min.js') ?>"></script>
    <!-- daterangepicker -->
    <script src="<?= base_url('assets/adminlte3/plugins/moment/moment.min.js') ?>"></script>
    <script src="<?= base_url('assets/adminlte3/plugins/daterangepicker/daterangepicker.js') ?>"></script>

    <!-- Select2 -->
    <script src="<?= base_url('assets/adminlte3/plugins/select2/js/select2.full.min.js') ?>"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?= base_url('assets/adminlte3/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
    <!-- Summernote -->
    <script src="<?= base_url('assets/adminlte3/plugins/summernote/summernote-bs4.min.js') ?>"></script>
    <!-- overlayScrollbars -->
    <script src="<?= base_url('assets/adminlte3/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
    <!-- DataTables -->
    <script src="<?= base_url('assets/adminlte3/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('assets/adminlte3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('assets/adminlte3/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
    <script src="<?= base_url('assets/adminlte3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>

    <script src="<?= base_url('assets/js/inputmask.bundle.js') ?>"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

    <!-- Bootstrap Switch -->
    <script src="<?= base_url('assets/adminlte3/plugins/bootstrap-switch/js/bootstrap-switch.min.js') ?>"></script>
    <?php
    if (
        $urlnya == 'laporan_keuangan/bulanan/' ||
        $urlnya == 'laporan_keuangan/setup/' ||
        $urlnya == 'inventaris/daftar_barang/' ||
        $urlnya == 'inventaris/stok/' ||
        $urlnya == 'rab/new/' ||
        $urlnya == 'rab/detail/' ||
        $urlnya == 'rab/list/' ||
        $urlnya == 'profile/' ||
        $urlnya == 'users_groups/users/' ||
        $urlnya == 'users_groups/groups/'
    ) {
    ?>
        <!-- jquery-validation -->
        <script src="<?= base_url('assets/adminlte3/plugins/jquery-validation/jquery.validate.min.js') ?>"></script>
        <script src="<?= base_url('assets/adminlte3/plugins/jquery-validation/additional-methods.min.js') ?>"></script>

    <?php
    }
    ?>

    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/adminlte3/dist/js/adminlte.js') ?>"></script>

    <script>
        $(document).on('shown.bs.modal', '.modal', function() {
            $(this).find('[autofocus]').focus();
        });

        $('body').tooltip({
            selector: '[data-toggle="tooltip"]'
        });

        $(document).ready(function() {
            $('[rel="tooltip"]').tooltip({
                trigger: "hover"
            });
        });
    </script>


    <?php
    // if($url_cek == 'laporan_keuangan/laba_rugi/'){
    //   $this->load->view('js_chart.php');
    // }
    $this->load->view('js_master.php');
    $this->load->view('js_datatable.php');
    $this->load->view('js_alert.php');
    $this->load->view('js_bootstrapswitch.php');
    $this->load->view('js_chart.php');
    $this->load->view('js_datepicker.php');
    $this->load->view('js_select2.php');

    ?>


</body>

</html>