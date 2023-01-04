<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model(masterModel());
        $this->load->library('fungsi');
        $this->load->library('form_validation');
        checkLoginGagal();

    }

    public function index() {
        $this->template->load('template', 'profile/profile');
    }
    
    public function proses() {
        $post = $this->input->post(null, TRUE);
        // print_r($post);
        // echo '<br>';
        // print_r($_FILES);

        // $users =  $this->master_model->selectUsers(userId(), NULL, NULL);

        if(@$_FILES['gambar']['name'] != NULL){
            $config['upload_path']          = './uploads/img/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 2048;
            $config['file_name']            = 'profile-'.substr(md5(rand()),0,10);
            $this->load->library('upload', $config);
        }

        if(!empty($post['password1']) && !empty($post['password2'])){
            $cekPassword = 1;
        }else{
            $cekPassword = 0;
        }

        if($cekPassword == 1 && $post['password1'] != $post['password2']){
            $params = array("success" => false, "status" => 1);
        }else{
            if(@$_FILES['gambar']['name'] != NULL) {
                if($this->upload->do_upload('gambar')){
                    $post['gambar'] = $this->upload->data('file_name');
    
                    $data = [
                        'nama'      => $post['nama_user'],
                        'password'  => MD5($post['password1']),
                        'avatar'    => empty($post['gambar']) ? null : $post['gambar'],
                    ];
                    $this->master_model->edit_users(userId(), $data);
                    
                    if($this->db->affected_rows() > 0) {
                        $params = array("success" => true);
                    } else {
                        $params = array("success" => false, "status" => "ada gambar");
                    }
                } else {
                    $error = $this->upload->display_errors();
                    $params = array("success" => false, "status" => 3, "pesan" => $error);
                }
            } else {
                $data = [
                    'nama'      => $post['nama_user'],
                    'password'  => MD5($post['password1']),
                ];
                $this->master_model->edit_users(userId(), $data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false, "status" => "tanpa gambar");
                }
            }
        }
        echo json_encode($params);

    }


    public function to_edit(){
        $id = $this->input->post('id_user');
        $type = $this->input->post('type');

        if($type == 'edit-nama'){
            $this->form_validation->set_rules('nama','Nama','required|trim');
            if($this->form_validation->run() == false){
                $params = [
                    'type' => 'validation',
                    'err_nama' => form_error('nama')
                ];
                echo json_encode($params);
                die;
            } else {
                $this->db->set('nama', $this->input->post('nama', true));
                $this->db->where('id', $id);
                if($this->db->update('db_user')){
                    $params = [
                        'type' => 'result',
                        'success' => true,
                        'msg' => 'Nama berhasil di edit'
                    ];
                } else {
                    $params = [
                        'type' => 'result',
                        'success' => false,
                        'msg' => 'Nama gagal di edit'
                    ];
                }
                echo json_encode($params);
            }
        } else if($type == 'edit-password'){
            $this->form_validation->set_rules('new_pass','Password Baru', 'required|trim|min_length[5]|matches[re_pass]');
            $this->form_validation->set_rules('re_pass','Re-type Password', 'required|trim|matches[new_pass]');

            if($this->form_validation->run() == false){
                $params = [
                    'type' => 'validation',
                    'err_new' => form_error('new_pass'),
                    'err_re' => form_error('re_pass')
                ];
                echo json_encode($params);
                die;
            } else {
                $new_pass = md5($this->input->post('new_pass'));
                $this->db->set('password', $new_pass);
                $this->db->where('id', $id);
                if($this->db->update('db_user')){
                    $params = [
                        'type' => 'result',
                        'success' => true,
                        'msg' => 'Password berhasil di edit'
                    ];
                } else {
                    $params = [
                        'type' => 'result',
                        'success' => false,
                        'msg' => 'Password gagal di edit'
                    ];
                }
                echo json_encode($params);
            }
        } else if($type == 'edit-photo'){

            $foto = $_FILES['img'];
            $user = $this->db->get_where('db_user',['id' => $id])->row();

            if($foto){
                $config['upload_path']          = './uploads/img/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';

                $this->load->library('upload', $config);

                if($this->upload->do_upload('img')){
                    $profile = $this->upload->data('file_name');
                   
                    if($user->avatar != null){
                        unlink(FCPATH .'uploads/img/'. $user->avatar);
                    } 

                    $this->db->set('avatar', $profile);
                    $this->db->where('id', $id);
                    if($this->db->update('db_user')){
                        $params = [
                            'type' => 'result',
                            'success' => true,
                            'msg' => 'Foto berhasil di edit'
                        ];
                    } else {
                        $params = [
                            'type' => 'result',
                            'success' => false,
                            'msg' => 'Foto gagal di edit'
                        ];
                    }

                } else {
                    $params = [
                        'type' => 'result',
                        'success' => false,
                        'msg' => 'Gagal upload photo'
                    ];
                }
                echo json_encode($params);
            } 

        }

    }

    
}

?>

