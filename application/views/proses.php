<?php
$profile = $this->master_model->getProfile(1)->row();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $profile->nama_lembaga ?> - <?= titleWebsite() ?></title>
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
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/dist/css/adminlte.min.css') ?>">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/plugins/daterangepicker/daterangepicker.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') ?>">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte3/plugins/summernote/summernote-bs4.css') ?>">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>

<body>

    <!-- jQuery -->
    <script src="<?= base_url('assets/adminlte3/plugins/jquery/jquery.min.js') ?>"></script>

    <!-- jQuery UI 1.11.4 -->
    <script src="<?= base_url('assets/adminlte3/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url('assets/adminlte3/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
    <!-- ChartJS -->
    <script src="<?= base_url('assets/adminlte3/plugins/chart.js/Chart.min.js') ?>"></script>

    <!-- daterangepicker -->
    <script src="<?= base_url('assets/adminlte3/plugins/moment/moment.min.js') ?>"></script>
    <script src="<?= base_url('assets/adminlte3/plugins/daterangepicker/daterangepicker.js') ?>"></script>
    <script src="<?= base_url('assets/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') ?>"></script>

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
    <!-- Bootstrap Switch -->
    <script src="<?= base_url('assets/adminlte3/plugins/bootstrap-switch/js/bootstrap-switch.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/adminlte3/dist/js/adminlte.js') ?>"></script>


    <?php
    $post = $this->input->post(null, TRUE);
    if (isset($post['login'])) {

        $query = $this->master_model->select_users($post);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $session_data = array(
                'user_id'       => $row->id,
                'group_id'      => $row->group_id,
                'nama'          => $row->nama,
                'employer_id'   => $row->employer_id,
                'sales_id'      => $row->sales_id,
                'status'        => $row->status,
                'avatar'        => $row->avatar,
                'description'   => $row->description
            );
            $this->session->set_userdata($session_data);
            $ses_status = $this->session->userdata('status');
            $group = $this->master_model->select_group($row->group_id)->row();
            if ($group->status == 1) {
                if (!empty($group->durasi_awal)) {
                    $waktu = date("H:i:s");
                    if ($waktu >= $group->durasi_awal && $waktu <= $group->durasi_akhir) {
                        if ($ses_status == 1) {
                            $data = $row->id;
                            $this->master_model->historyUser($data);
    ?>
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Selamat, login berhasil :)',
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(
                                    function() {
                                        window.location = '<?= site_url('dashboard/cek_access_perum') ?>';
                                    }
                                )
                            </script>
                        <?php
                        } else {
                            // Jika status disable maka diarahkan ke halaman disable
                            $this->session->sess_destroy();
                            $url = base_url('login/akun_disable/');
                            redirect($url);
                        }
                    } else {
                        $this->session->sess_destroy();
                        $url = base_url('login/non_aktif/');
                        redirect($url);
                    }
                } else {
                    if ($ses_status == 1) {
                        $data = $row->id;
                        $this->master_model->historyUser($data);
                        ?>
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Selamat, login berhasil :)',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(
                                function() {
                                    window.location = '<?= site_url('dashboard/cek_access_perum') ?>';
                                }
                            )
                        </script>
            <?php
                    } else {
                        // Jika status disable maka diarahkan ke halaman disable
                        $this->session->sess_destroy();
                        $url = base_url('login/akun_disable/');
                        redirect($url);
                    }
                }
            } else {
                // Jika status disable maka diarahkan ke halaman disable
                $this->session->sess_destroy();
                $url = base_url('login/akun_disable/');
                redirect($url);
            }
        } else {
            ?>
            <script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Login Gagal...!!! Username atau password salah',
                    showConfirmButton: false,
                    timer: 3000
                }).then(
                    function() {
                        window.location = '<?= site_url('login/') ?>';
                    }
                )
            </script>
    <?php
        }
    } else {
        // echo 'gagal login';
        $url = base_url();
        echo $this->session->set_flashdata('msg', 'Username Atau Password Salah');
        redirect($url);
    }

    ?>
</body>

</html>