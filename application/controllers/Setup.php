<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setup extends CI_Controller
{
    function __construct(){
        parent::__construct();
        $this->load->model(masterModel());
        $this->load->library('fungsi');
        $this->load->library('form_validation');
        checkLoginGagal();
    }

    public function index(){
        checkUserLogin();
        $data = array(
        );
        $this->template->load('template', 'setup/setup', $data);
    }

    function proses(){
        $post = $this->input->post(null, TRUE);

        if (isset($_POST['updateProfile'])) {
            // print_r($post);

            $user_avatar = $this->master_model->getProfile(1)->row()->logo;
            if (@$_FILES['gambar']['name'] != NULL) {
                $config['upload_path']          = './uploads/img/';
                $config['allowed_types']        = 'jpg';
                $config['max_size']             = 1024;
                $config['file_name']            = 'profile-' . substr(md5(rand()), 0, 10);
                $this->load->library('upload', $config);
            }

            // print_r($post);
            if (@$_FILES['gambar']['name'] != NULL) {
                if ($this->upload->do_upload('gambar')) {
                    if ($user_avatar) {
                        $target_file = './uploads/img/' . $user_avatar;
                        unlink($target_file);
                    }
                    $post['gambar'] = $this->upload->data('file_name');
                    $data = [
                        'judul_web'         => $post['judul_web'],
                        'nama_lembaga'      => $post['nama_lembaga'],
                        'alamat'            => $post['alamat'],
                        'telp'              => $post['telp'],
                        'hp'                => $post['hp'],
                        'contact_person'    => $post['contact_person'],
                        'bidang'            => $post['bidang'],
                        'logo'              => $post['gambar'],
                        'user_id'           => userId(),

                    ];
                    $this->master_model->editProfile($post['idProfile'], $data);

                    if ($this->db->affected_rows() > 0) {
                        $params = [
                            'success'   => true,
                            'status'    => 1,
                            'msg'       => 'Sukses',
                        ];
                    } else {
                        $params = [
                            'success'   => false,
                            'status'    => 3,
                            'msg'       => 'Not Proses',
                        ];
                    }
                } else {
                    $error = $this->upload->display_errors();
                    $params = [
                        'success'   => false,
                        'status'    => 2,
                        'msg'       => $error,
                    ];
                }
            } else {
                $post['gambar'] = NULL;
                $data = [
                    'judul_web'         => $post['judul_web'],
                    'nama_lembaga'      => $post['nama_lembaga'],
                    'alamat'            => $post['alamat'],
                    'telp'              => $post['telp'],
                    'hp'                => $post['hp'],
                    'contact_person'    => $post['contact_person'],
                    'bidang'            => $post['bidang'],
                    'user_id'           => userId(),
                ];
                $this->master_model->editProfile($post['idProfile'], $data);

                $params = [
                    'success'   => false,
                    'status'    => 1,
                    'msg'       => 'File Empty',
                ];
            }
            echo json_encode($params);

        } else {
            redirect('setup/');
        }
    }

}
