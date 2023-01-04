<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('master_model');
    }
 
    function index(){
        // checkLogin();
        $this->load->view('login');
    }
    
    function proses(){
        $this->load->view('proses');
    }
 
    function auth(){
        echo '<link href="'.base_url().'/assets/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <link href="'.base_url().'assets/sweetalert2/animate.css" rel="stylesheet" type="text/css" />
        <script src="'.base_url().'assets/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="'.base_url().'assets/sweetalert2/sweetalert2.min.js" type="text/javascript"></script>';


        $post = $this->input->post(null, TRUE);
        if (isset($post['login'])) {
            // $this->session->set_userdata('masuk',TRUE);
            $query = $this->master_model->select_users($post);
            if($query->num_rows() > 0) {
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
                if(!empty($group->durasi_awal)){
                    $waktu = date("H:i:s");
                    if($waktu >= $group->durasi_awal && $waktu <= $group->durasi_akhir){
                        if($ses_status == 1){
                            $data = $row->id;
                            $this->master_model->historyUser($data);
                            // Jika status aktif maka jalankan perintah dibawah
                            // window location masih harus di edit, disesuaikan dengan HOME Group
                             echo "<script>
                            // alert('Selamat, Login Berhasil');
                             window.location='".site_url('dashboard')."';
                             </script>";
        
                           /* echo "<script>
                            setTimeout(function() {
                                swal({
                                    title: 'Success!',
                                    text: 'Selamat, login berhasil 1:)',
                                    type: 'success',
                                    allowOutsideClick: false
                                }).then(
                                    function() {
                                        window.location='".site_url('dashboard')."';
                                    }
                                )
                            }, 50);
                            </script>";*/
                        } else {
                            // Jika status disable maka diarahkan ke halaman disable
                            $this->session->sess_destroy();
                            $url = base_url('login/akun_disable/');
                            redirect($url);
                        }
                    }else{
                        $this->session->sess_destroy();
                        $url = base_url('login/non_aktif/');
                        redirect($url);
                    }
                }else{
                    if($ses_status == 1){
                        $data = $row->id;
                        $this->master_model->historyUser($data);
                         echo "<script>
                            // alert('Selamat, Login Berhasil');
                             window.location='".site_url('dashboard')."';
                             </script>";
                        /*
                        echo "<script>
                        setTimeout(function() {
                            swal({
                                title: 'Success!',
                                text: 'Selamat, login berhasil 11:)',
                                type: 'success',
                                allowOutsideClick: false
                            }).then(
                                function() {
                                    window.location='".site_url('dashboard')."';
                                }
                            )
                        }, 50);
                        </script>"; */
                    } else {
                        // Jika status disable maka diarahkan ke halaman disable
                        $this->session->sess_destroy();
                        $url = base_url('login/akun_disable/');
                        redirect($url);
                    }
                }
            } else {
                echo "<script>
            	setTimeout(function() {
	            	swal({
						title: 'Error!',
						text: 'Login Gagal...!!! Username atau password salah',
						type: 'error',
						allowOutsideClick: false
					}).then(
						function() {
							window.location='".site_url('login')."';
						}
					)
				}, 50);
				</script>";

            }
        } else {
            $url=base_url();
            echo $this->session->set_flashdata('msg','Username Atau Password Salah');
           redirect($url);
        }
    }
 
    function logout(){
        $this->session->sess_destroy();
        $url = site_url('login');
        redirect($url);
    }
 
    function akun_disable(){
        $this->load->view('akun_disable.php');
    }
 
    function non_aktif(){
        $this->load->view('akun_nonaktif.php');
    }

    function login(){
        $this->load->view('login2');
    }
 
}