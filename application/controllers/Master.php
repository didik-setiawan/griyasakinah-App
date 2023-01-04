<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model(masterModel());
        $this->load->library('fungsi');
        $this->load->library('form_validation');
        checkLoginGagal();
    }

    public function index() {
        checkUserLogin();
        redirect('dashboard/');
    }
    
    public function users_proses() {
        $post = $this->input->post(null, TRUE);

        if(isset($_POST['update_status'])){
            $users =  $this->master_model->selectUsers($post['user_id']);
            if($users->num_rows() > 0){
                $row = $users->row();
                if($row->group_id == 5){
                    if($row->status == 1){
                        $status = 2;
                    }else{
                        $status = 1;
                    }
                    $this->master_model->updateUser($row->id, NULL, $status);

                    $sales =  $this->database_model->sales_list($row->sales_id)->row();
                    if($sales->status == 1){
                        $status = 0;
                    }else{
                        $status = 1;
                    }
                    $this->database_model->sales_onof($sales->id, $status);
                    
                }else{
                    if($row->status == 1){
                        $status = 2;
                    }else{
                        $status = 1;
                    }
                    $this->master_model->updateUser($row->id, NULL, $status);
                }

                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }else{
                $params = array("success" => false, "status" => 1);
            }
            echo json_encode($params);

        }elseif(isset($_POST['add_users'])){
            // print_r($post);

            $users =  $this->master_model->selectUsers(NULL, NULL, $post['add_email']);
            if($users->num_rows() > 0){
                $params = array("success" => false, "status" => 1);
            }else{
                $data = [
                    'group_id'  => $post['add_group'],
                    'password'  => MD5($post['add_password']),
                    'nama'      => $post['add_nama'],
                    'email'     => $post['add_email'],
                    'store_id'  => 1,
                    'status'    => 1,
                ];
                $this->master_model->add_users($data);

                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['edit_user'])){
            $users =  $this->master_model->selectUsers($post['user_id'], NULL, NULL);

            if($users->num_rows() > 0){
                $data = [
                    'password'  => MD5($post['password']),
                    'nama'      => $post['username'],
                ];
                $this->master_model->edit_users($post['user_id'], $data);

                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }else{
                $params = array("success" => false, "status" => 1);
            }
            echo json_encode($params);

        }elseif(isset($_POST['change_group'])){
            $users =  $this->master_model->selectUsers($post['user_id'])->row();
            if($post['group_id'] == 0){
                $params = array("success" => false, "status" => 1);
            }elseif($users->group_id == $post['group_id']){
                $params = array("success" => false, "status" => 2);
            }else{
                $this->master_model->updateUser($post['user_id'], $post['group_id'], NULL);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['delete_user'])){
            // $id = NULL, $group = NULL, $status = NULL, $del = NULL
            $this->master_model->updateUser($post['user_id'], NULL, NULL, 1);

            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
            echo json_encode($params);

        }else{
            redirect('users_groups/users');
        }

    }

    public function perumahan() {
        checkUserLogin();
        // $id = null, $group = NULL, $email = NULL, $active = NULL
		// $this->load->model('perumahan_model');
        // $perumahan =  $this->perumahan_model->selectPerumahan(NULL, NULL, NULL, 1)->result();
        
        // $data = [
        //     'list'          => $perumahan
        // ];
        // $this->template->load('template', 'master/perumahan', $data);

        $data['perum'] = $this->db->get('tbl_perumahan')->result();
        $this->template->load('template', 'master/perum', $data);
    }

    public function del_perum(){
        $id = $_POST['id'];
        $perum = $this->db->get_where('tbl_perumahan',['id_perumahan' => $id])->row();
        unlink(FCPATH . 'assets/img/' . $perum->logo);
        if($this->db->delete('tbl_perumahan',['id_perumahan' => $id])){
            $params = [
                'success' => true,
                'msg' => 'Perumahan berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Perumahan gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function get_perum_ajax(){
        $id = $_POST['id'];
        $perum = $this->db->get_where('tbl_perumahan',['id_perumahan' => $id])->row();
        echo json_encode($perum);
    }

    public function validation_perum(){
        $this->form_validation->set_rules('nama','Nama Perumahan','required|trim');
        $this->form_validation->set_rules('kota','Kota','required|trim');
        $this->form_validation->set_rules('alamat','Alamat Perumahan','required|trim');

        if($this->form_validation->run() == false){
            $params = [
                'type' => 'validation',
                'err_nama' => form_error('nama'),
                'err_kota' => form_error('kota'),
                'err_alamat' => form_error('alamat')
            ];
            echo json_encode($params);
            die;
        } else {
            return true;
        }

    }

    public function add_perum(){
        $this->validation_perum();
        $perum = $this->input->post('nama');
        $kota = $this->input->post('kota');
        $alamat = $this->input->post('alamat');
        $cluster = $this->input->post('cluster');


        $perum_ada = $this->db->get_where('tbl_perumahan',['nama_perumahan' => $perum, 'kabupaten' => $kota])->result();

        // if($perum_ada){
        //     $params = [
        //         'success' => false,
        //         'msg' => 'Perumahan di lokasi tersebut sudah tersedia',
        //         'type' => 'result'
        //     ];
        //     echo json_encode($params);
        //     die;
        // } else {

            $img = $_FILES['logo'];

            if($img){
                $config['upload_path']          = './assets/img/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $this->load->library('upload', $config);
                if($this->upload->do_upload('logo')){
                    $logo = $this->upload->data('file_name');
                } else {
                    $params = [
                        'success' => false,
                        'msg' => 'Error upload file',
                        'type' => 'result'
                    ];
                    echo json_encode($params);
                    die;
                }

            }

            $data = [
                'nama_perumahan' => $perum,
                'kabupaten' => $kota,
                'cluster' => $cluster,
                'logo' => $logo,
                'alamat_perumahan' => $alamat
            ];  

            if($this->db->insert('tbl_perumahan', $data)){
                $params = [
                    'success' => true,
                    'msg' => 'Perumahan baru berhasil di tambahkan',
                    'type' => 'result'
                ];
            } else {
                $params = [
                    'success' => false,
                    'msg' => 'Perumahan baru gagal di tambahkan',
                    'type' => 'result'
                ];
            }
            echo json_encode($params);
        // }
    }

    public function edit_perum(){
        $this->validation_perum();
        $id = $this->input->post('id_perum');

        $perum_ada = $this->db->get_where('tbl_perumahan',['nama_perumahan' => $this->input->post('nama'), 'kabupaten' => $this->input->post('kota')])->result();

        // if($perum_ada){
        //     $params = [
        //         'success' => false,
        //         'msg' => 'Nama perumahan di lokasi tersebut sudah tersedia',
        //         'type' => 'result'
        //     ];
        //     echo json_encode($params);
        //     die;
        // } else {
            
            $this_perum = $this->db->get_where('tbl_perumahan',['id_perumahan' => $id])->row();
            $img = $_FILES['logo'];

            if($img){
                $config['upload_path']          = './assets/img/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';

                $this->load->library('upload', $config);

                if($this->upload->do_upload('logo')){
                    unlink(FCPATH . 'assets/img/' . $this_perum->logo);
                    $newlogo = $this->upload->data('file_name');
                } else {
                    $newlogo = $this_perum->logo;
                }
            } 

            $data = [
                'nama_perumahan' => $this->input->post('nama'),
                'kabupaten' => $this->input->post('kota'),
                'cluster' => $this->input->post('cluster'),
                'logo' => $newlogo,
                'alamat_perumahan' => $this->input->post('alamat')
            ];  

            // var_dump($data);die;

            if($this->db->where('id_perumahan', $id)->update('tbl_perumahan', $data)){
                $params = [
                    'success' => true,
                    'msg' => 'Perumahan berhasil di edit',
                    'type' => 'result'
                ];
            } else {
                $params = [
                    'success' => false,
                    'msg' => 'Perumahan gagal di edit',
                    'type' => 'result'
                ];
            }

            echo json_encode($params);
        // }

    }

    public function groups() {
        checkUserLogin();
        $group =  $this->master_model->select_group()->result();
        $data = [
            'list'   => $group
        ];
        $this->template->load('template', 'user_group/groups', $data);
    }

    public function group_list() {
        $group =  $this->master_model->select_group()->result();
        $data = [
            'list'   => $group
        ];
        $this->load->view('user_group/group_list', $data);
    }

    public function group_proses() {
        $post = $this->input->post(null, TRUE);
        // print_r($post);
        if(isset($_POST['add_save'])){
            $group =  $this->master_model->select_group(NULL, NULL, $post['nama_group']);
            if($group->num_rows() > 0){
                $params = array("success" => false, "status" => 1);
            }else{
                $data = [
                    'group_name'    => $post['nama_group'],
                    'home'          => 1,
                    'user_id'       => userId(),
                ];
                $this->master_model->add_groups($data);
        
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['edit_group'])){
            $group =  $this->master_model->select_group(NULL, NULL, $post['edit_nama_group']);
            if($group->num_rows() > 0){
                if($group->row()->id == $post['edit_id']){
                    $this->master_model->edit_groups($post['edit_id'], $post, NULL);
        
                    if($this->db->affected_rows() > 0) {
                        $params = array("success" => true);
                    } else {
                        $params = array("success" => false);
                    }
                }else{
                    $params = array("success" => false, "status" => 1);
                }
            }else{
                $this->master_model->edit_groups($post['edit_id'], $post, NULL);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['update_status'])){
            $group =  $this->master_model->select_group($post['id'], NULL, NULL);
            if($group->num_rows() > 0){
                $row = $group->row();
                if($row->status == 1){
                    $status = 2;
                }else{
                    $status = 1;
                }
                // echo $status;
                $this->master_model->edit_groups($row->id, NULL, $status);
                
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }else{
                $params = array("success" => false);
            }
            echo json_encode($params);

        }elseif(isset($_POST['delete_group'])){
            $this->master_model->del_groups($post['id']);
            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
            echo json_encode($params);
        }else{
            redirect('users_groups/groups');
        }
    }


    public function role_group($id = NULL) {
        if($id != NULL) {
            $query = $this->master_model->select_group($id);
            if($query->num_rows() > 0){
                $data['detail'] = $query->row();
                $this->template->load('template', 'user_group/role_group', $data);
            } else {
                redirect('users_groups/groups');
            }
        } else {
            redirect('users_groups/groups');
        }
    }

    public function modules() {
        checkUserLogin();
        $this->template->load('template', 'user_group/module');
    }
    
    public function modules_save() {
        $post = $this->input->post(null, TRUE);
        if(isset($_POST['proses'])){
            $menu = $this->master_model->menu_modul()->result(); 
            $data = [];
            foreach ($menu as $key => $row) {
                if(!empty($post['modul'.$row->id])){
                    $aktif = 1;
                }else{
                    $aktif = 0;
                }
                array_push($data, array(
                    'id'        => $row->id,
                    'aktif'     => $aktif,
                    )
                );
            }
            $this->master_model->edit_modules($data);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('modul_update', 'Modul berhasil di update');
                redirect('users_groups/modules');
            }else{
                $this->session->set_flashdata('modul_gagal', 'Modul gagal di update');
                redirect('users_groups/modules');
            }
        }elseif(isset($_POST['role_group'])){
            // print_r($post);
            $this->master_model->del_role($post['group_id']);
            $menu = $this->master_model->menu_modul()->result(); 
            $data = [];
            foreach ($menu as $key => $row) {
                if(!empty($post['modul'.$row->id])){
                    if(!empty($post['input'.$row->id])){
                        $input = 1;
                    }else{
                        $input = 2;
                    }
                    if(!empty($post['edit'.$row->id])){
                        $edit = 1;
                    }else{
                        $edit = 2;
                    }
                    if(!empty($post['delete'.$row->id])){
                        $del = 1;
                    }else{
                        $del = 2;
                    }
                    array_push($data, array(
                        'group_id'      => $post['group_id'],
                        'modul_id'      => $row->id,
                        'crud_create'   => $input,
                        'crud_update'   => $edit,
                        'crud_delete'   => $del,
                        )
                    );
                }
            }
            $this->master_model->edit_role($data);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('modul_update', 'Modul berhasil di update');
                redirect('users_groups/role_group/'.$post['group_id']);
            }else{
                $this->session->set_flashdata('modul_gagal', 'Modul gagal di update');
                redirect('users_groups/role_group/'.$post['group_id']);
            }

        }else{
            redirect('users_groups/modules');
        }
    }


    //management Kavling

    public function kavling(){
        $data['perum'] = $this->master_model->getPerumahan();
        $data['kavling'] = $this->master_model->get_kavling_join_perum();
        $data['kavling2'] = $this->master_model->get_kavling_join_perum2();


        // var_dump($data['kavling']);die;


        if(isset($_GET['perum'])){
            $data['kavling'] = $this->master_model->get_kavling_join_perum_filter_perum($_GET['perum']);
            $data['kavling2'] = $this->master_model->get_kavling_join_perum2_filter_perum($_GET['perum']);

            if(isset($_GET['cluster'])){
                $data['kavling'] = $this->master_model->get_kavling_join_perum_filter_perum_cluster($_GET['perum'],$_GET['cluster']);
            }

        }

        $this->template->load('template', 'master/kavling', $data);
    }

    public function get_perum_id_ajax(){
        $id = $_POST['id'];
        $perum = $this->db->get_where('tbl_perumahan',['id_perumahan' => $id])->row();
        echo json_encode($perum);
    }

    public function add_kavling(){
        $post = $this->input->post(null, TRUE);

        $ada_blok = $this->db->get_where('tbl_kavling',['id_cluster' => $post['cluster'], 'blok' => $post['blok'], 'no_rumah' => $post['no_rumah']])->result();

        if(empty($post['lokasi'])){
            $params = array("success" => false, "status" => 1);
        } elseif(empty($post['tipe'])){
            $params = array("success" => false, "status" => 2);
        } elseif(empty($post['blok'])) {
            $params = array("success" => false, "status" => 3);
        } elseif(empty($post['harga'])) {
            $params = array("success" => false, "status" => 6);
        }
        elseif(empty($post['cluster']) & $post['status_perum'] == 1) {
            $params = array("success" => false, "status" => 4);
        }
        elseif(empty($post['lt'])) {
            $params = array("success" => false, "status" => 5);
        }
        elseif(empty($post['lb'])) {
            $params = array("success" => false, "status" => 7);
        }
        elseif(empty($post['no_rumah'])) {
            $params = array("success" => false, "status" => 8);
        }
        elseif($ada_blok) {
            $params = array("success" => false, "status" => 10);
        }
         else {
            //add_data
            $data = [
                'id_perum' => $_POST['lokasi'],
                'id_tipe' => $_POST['tipe'],
                'blok' => $_POST['blok'],
                'id_cluster' => $_POST['cluster'],
                'harga' => $_POST['harga'],
                'status_kavling' => 0,
                'lt' => $_POST['lt'],
                'lb' => $_POST['lb'],
                'no_rumah' => $_POST['no_rumah'],
                'sitemap_id' => $_POST['sitemap_id']
            ];
            $this->master_model->add_kavling($data);

            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
        }
        echo json_encode($params);
    }


    public function edit_kavling(){
        $post = $this->input->post(null, TRUE);
        $err = $this->db->get_where('tbl_kavling',['id_cluster' => $post['cluster'], 'blok' => $post['blok'], 'no_rumah' => $post['no_rumah'], 'id_kavling !=' => $post['id']])->row();


        if(empty($post['lokasi'])){
            $params = array("success" => false, "status" => 1);
        } elseif(empty($post['tipe'])){
            $params = array("success" => false, "status" => 2);
        } elseif(empty($post['blok'])) {
            $params = array("success" => false, "status" => 3);
        } elseif(empty($post['harga'])) {
            $params = array("success" => false, "status" => 6);
        }
        elseif(empty($post['cluster']) & $post['status_perum'] == 1) {
            $params = array("success" => false, "status" => 4);
        }
        elseif(empty($post['lt'])) {
            $params = array("success" => false, "status" => 5);
        }
        elseif(empty($post['lb'])) {
            $params = array("success" => false, "status" => 7);
        }
        elseif(empty($post['no_rumah'])) {
            $params = array("success" => false, "status" => 8);
        }
        elseif($err) {
            $params = array("success" => false, "status" => 10);
        }
         else {
            //edit_data
            $data = [
                'id_perum' => $_POST['lokasi'],
                'id_tipe' => $_POST['tipe'],
                'blok' => $_POST['blok'],
                'lt' => $_POST['lt'],
                'lb' => $_POST['lb'],
                'id_cluster' => $_POST['cluster'],
                'harga' => $_POST['harga'],
                'no_rumah' => $_POST['no_rumah']
            ];
            $id = $_POST['id'];
            $this->db->where('id_kavling', $id)->update('tbl_kavling', $data);

            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
        }
        echo json_encode($params);
    }

    public function delete_kavling(){
        $id = $_POST['id'];
        $this->master_model->delete_kavling($id);
        if($this->db->affected_rows() > 0) {
            $params = array("success" => true);
        } else {
            $params = array("success" => false);
        }
        echo json_encode($params);
    }

    public function get_kavling_id(){
        $id = $_POST['id'];
        $q = $this->master_model->get_kavling_id($id);
        echo json_encode($q);
    }

    public function cluster(){
        $data['perum'] = $this->db->get_where('tbl_perumahan',['cluster' => 1])->result();
        $q = "SELECT * FROM tbl_perumahan JOIN tbl_cluster ON tbl_perumahan.id_perumahan = tbl_cluster.id_perum";
        $data['cluster'] = $this->db->query($q)->result();
        $this->template->load('template', 'marketing/cluster', $data);
    }

    public function add_cluster(){
        $perum = $this->input->post('perum');
        $cluster = $this->input->post('cluster');
        $cluster_terdaftar = $this->db->get_where('tbl_cluster',['id_perum' => $perum, 'nama_cluster' => $cluster])->row();

        if($cluster_terdaftar){
            $this->session->set_flashdata('err','Cluster di perumahan ini sudah terdaftar');
            redirect('master/cluster');  
        } else {

            $data = [
                'id_perum' => $perum,
                'nama_cluster' => $cluster
            ];

            if($this->db->insert('tbl_cluster', $data)){
                $this->session->set_flashdata('scs','Cluster berhasil di tambahkan');
            redirect('master/cluster'); 
            } else {
                $this->session->set_flashdata('err','Cluster gagal di tambahkan');
            redirect('master/cluster'); 
            }

        }

    }

    public function get_cluster_ajax(){
        $id = $_POST['id'];
        $cl = $this->db->get_where('tbl_cluster',['id_cluster' => $id])->row();
        echo json_encode($cl);
    }

    public function edit_cluster($id){

         $perum = $this->input->post('perum');
        $cluster = $this->input->post('cluster');
        $cluster_terdaftar = $this->db->get_where('tbl_cluster',['id_perum' => $perum, 'nama_cluster' => $cluster])->row();

        if($cluster_terdaftar){
            $this->session->set_flashdata('err','Cluster di perumahan ini sudah terdaftar');
            redirect('master/cluster');  
        } else {

            $data = [
                'id_perum' => $perum,
                'nama_cluster' => $cluster
            ];

            if($this->db->where('id_cluster', $id)->update('tbl_cluster', $data)){
                $this->session->set_flashdata('scs','Cluster berhasil di edit');
            redirect('master/cluster'); 
            } else {
                $this->session->set_flashdata('err','Cluster gagal di edit');
            redirect('master/cluster'); 
            }
        }

    }

    public function del_cluster($id){
        if($this->db->delete('tbl_cluster',['id_cluster' => $id])){
            $this->db->delete('tbl_kavling',['id_cluster' => $id]);
            $this->session->set_flashdata('scs','Cluster berhasil di hapus');
            redirect('master/cluster'); 
        } else {
            $this->session->set_flashdata('err','Cluster gagal di hapus');
            redirect('master/cluster'); 
        }
    }

    public function get_cluster_by_perum(){
        $perum = $_POST['lokasi'];
        $cluster = $this->db->get_where('tbl_cluster',['id_perum' => $perum])->result();
        echo json_encode($cluster);
    }


    public function material(){
        $data['unit'] = $this->master_model->listUnit()->result();
        $data['kategori'] = $this->master_model->listKategori()->result();
        $data['material'] = $this->master_model->listMaterial()->result();
        $this->template->load('template', 'master/material', $data);
    }

    public function add_material(){
        $post = $this->input->post(null, TRUE);

        if(empty($post['kategori_id'])){
            $params = array("success" => false, "status" => 1);
        } elseif(empty($post['nama_material'])){
            $params = array("success" => false, "status" => 2);
        } elseif(empty($post['unit_id'])) {
            $params = array("success" => false, "status" => 3);
        } else {
            //add_data
            $data = [
                'kategori_id' => $_POST['kategori_id'],
                'nama_material' => $_POST['nama_material'],
                'unit_id' => $_POST['unit_id'],
                'user_id' => userId()
            ];
            $this->master_model->add_material($data);

            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
        }
        echo json_encode($params);
    }

    public function delete_material(){
        $id = $_POST['id'];
        $this->master_model->delete_material($id);
        if($this->db->affected_rows() > 0) {
            $params = array("success" => true);
        } else {
            $params = array("success" => false);
        }
        echo json_encode($params);
    }

    public function edit_material(){
        $post = $this->input->post(null, TRUE);

        if(empty($post['kategori_id'])){
            $params = array("success" => false, "status" => 1);
        } elseif(empty($post['nama_material'])){
            $params = array("success" => false, "status" => 2);
        } elseif(empty($post['unit_id'])) {
            $params = array("success" => false, "status" => 3);
        } else {
            //edit_data
            $data = [
                'kategori_id' => $_POST['kategori_id'],
                'nama_material' => $_POST['nama_material'],
                'unit_id' => $_POST['unit_id'],
            ];
            $id = $_POST['id'];
            $this->db->where('id', $id)->update('master_material', $data);

            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
        }
        echo json_encode($params);
    }

    public function get_material_id(){
        $id = $_POST['id'];
        $q = $this->master_model->get_material_id($id);
        echo json_encode($q);
    }

    public function jenis_material(){
        $data['kategori'] = $this->master_model->listKategori()->result();
        $this->template->load('template', 'master/jenis_material', $data);
    }

    public function add_jenis_material(){
        $post = $this->input->post(null, TRUE);

        if(empty($post['kategori_produk'])){
            $params = array("success" => false, "status" => 1);
        } else {
            //add_data
            $data = [
                'kategori_produk' => $_POST['kategori_produk'],
                'user_id' => userId()
            ];
            $this->master_model->addKategori($data);

            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
        }
        echo json_encode($params);
    }

    public function delete_jenis_material(){
        $id = $_POST['id'];
        $this->master_model->delKategori($id);
        if($this->db->affected_rows() > 0) {
            $params = array("success" => true);
        } else {
            $params = array("success" => false);
        }
        echo json_encode($params);
    }

    public function edit_jenis_material(){
        $post = $this->input->post(null, TRUE);

        if(empty($post['kategori_produk'])){
            $params = array("success" => false, "status" => 1);
        } else {
            //edit_data
            $data = [
                'kategori_produk' => $_POST['kategori_produk'],
            ];
            $id = $_POST['id'];
            $this->db->where('id', $id)->update('master_produk_kategori', $data);

            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
        }
        echo json_encode($params);
    }

    public function get_jenis_material_id(){
        $id = $_POST['id'];
        $q = $this->master_model->get_jenis_material_id($id);
        echo json_encode($q);
    }

    public function unit(){
        $data['unit'] = $this->master_model->listUnit()->result();
        $this->template->load('template', 'master/unit', $data);
    }

    public function add_unit(){
        $post = $this->input->post(null, TRUE);

        if(empty($post['nama_satuan'])){
            $params = array("success" => false, "status" => 1);
        } else {
            //add_data
            $data = [
                'nama_satuan' => $_POST['nama_satuan'],
                'user_id' => userId()
            ];
            $this->master_model->addUnit($data);

            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
        }
        echo json_encode($params);
    }

    public function delete_unit(){
        $id = $_POST['id'];
        $this->master_model->delUnit($id);
        if($this->db->affected_rows() > 0) {
            $params = array("success" => true);
        } else {
            $params = array("success" => false);
        }
        echo json_encode($params);
    }

    public function edit_unit(){
        $post = $this->input->post(null, TRUE);

        if(empty($post['nama_satuan'])){
            $params = array("success" => false, "status" => 1);
        } else {
            //edit_data
            $data = [
                'nama_satuan' => $_POST['nama_satuan'],
            ];
            $id = $_POST['id'];
            $this->db->where('id', $id)->update('master_produk_unit', $data);

            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
        }
        echo json_encode($params);
    }

    public function get_unit_id(){
        $id = $_POST['id'];
        $q = $this->master_model->get_unit_id($id);
        echo json_encode($q);
    }

    public function tipe(){
        $data['perum'] = $this->master_model->getPerumahan(); //dropdown
        $data['tipe'] = $this->master_model->listTipe()->result();
        $data['material'] = $this->master_model->getKategori()->result(); //dropdown
        $data['unit'] = $this->master_model->listUnit()->result();//dropdown
        $this->template->load('template', 'master/tipe', $data);
    }

    public function add_tipe(){
        $post = $this->input->post(null, TRUE);

        if(empty($post['lokasi'])){
            $params = array("success" => false, "status" => 1);
        } elseif(empty($post['tipe'])){
            $params = array("success" => false, "status" => 2);
        }
         else {
            //add_data
            $data = [
                'id_perum' => $_POST['lokasi'],
                'tipe' => $_POST['tipe'],
                'id_cluster' => $_POST['cluster'],
            ];
            $this->master_model->addTipe($data);

            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
        }
        echo json_encode($params);
    }


    public function edit_tipe(){
        $post = $this->input->post(null, TRUE);
        if(empty($post['lokasi'])){
            $params = array("success" => false, "status" => 1);
        } elseif(empty($post['tipe'])){
            $params = array("success" => false, "status" => 2);
        }
        elseif(empty($post['cluster'])) {
            $params = array("success" => false, "status" => 3);
        }elseif(empty($post['id_kategori'])) {
            $params = array("success" => false, "status" => 4);
        }
        else {
            //data tipe
            $data = [
                'id_perum' => $_POST['lokasi'],
                'tipe' => $_POST['tipe'],
                'id_cluster' => $_POST['cluster'],
            ];
            $id = $_POST['id'];
            $this->db->where('id_tipe', $id)->update('tbl_tipe', $data);

            //add data max
            if($post['id_kategori'] != null)
            {
                $data = [
                    'material_id' => $_POST['id_material'],
                    'kategori_id' => $_POST['id_kategori'],
                    'max' => $_POST['max'],
                    'id_tipe' => $_POST['id'],
                ];
            }
            $this->master_model->addMax($data);

            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
        }
        echo json_encode($params);
    }

    public function delete_tipe(){
        $id = $_POST['id'];
        $this->master_model->delete_tipe($id);
        $this->master_model->delmaterialMax($id);
        if($this->db->affected_rows() > 0) {
            $params = array("success" => true);
        } else {
            $params = array("success" => false);
        }
        echo json_encode($params);
    }

    public function get_tipe_id(){
        $id = $_POST['id'];
        $q = $this->master_model->get_tipe_id($id);
        echo json_encode($q);
    }

    public function get_mat(){
        $id = $this->input->post('id', TRUE);
        $data = $this->master_model->getMat($id)->result();
        echo json_encode($data);
    }
    
    public function get_sat(){
        $id = $this->input->post('id', TRUE);
        $data = $this->master_model->getSat($id)->row();
        echo json_encode($data);
    }

    public function view_max($id = NULL){
        if($id != NULL){
                $data = [
                    'material' => $this->master_model->getKategori()->result(), //dropdown
                    'unit' => $this->master_model->listUnit()->result(), //dropdown
                    'materialMax'   => $this->master_model->TipeMaxMaterial($id)->result(),
                ];
                $this->template->load('template', 'master/material_max', $data);
        }
    }

    public function get_materialMax_id(){
        $id = $_POST['id_max'];
        $data = $this->master_model->get_materialMax_id($id);
        echo json_encode($data);
    }

    public function edit_materialMax(){
        $post = $this->input->post(null, TRUE);

        if(empty($post['id_kategori'])){
            $params = array("success" => false, "status" => 1);
        }elseif(empty($post['max'])){
            $params = array("success" => false, "status" => 2);
        }  else {
            //add_data
            $data = [
                'material_id' => $_POST['id_material'],
                'kategori_id' => $_POST['id_kategori'],
                'max' => $_POST['max'],
                'id_tipe' => $_POST['id_tipe'],
            ];

            $id = $_POST['id_max'];
            $this->db->where('id_max', $id)->update('tbl_max_material', $data);

            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
        }
        echo json_encode($params);
    }

    public function delete_materialMax($id = NULL){
        $id = $_POST['id_max'];
        $this->master_model->delMax($id);
        if($this->db->affected_rows() > 0) {
            $params = array("success" => true);
        } else {
            $params = array("success" => false);
        }
        echo json_encode($params);
    }


    public function supplier(){
        $q = "SELECT * FROM master_supplier";
        $data['supplier'] = $this->db->query($q)->result();

        $this->template->load('template', 'master/supplier', $data);
    }

    public function add_supplier(){
        $post = $this->input->post(null, TRUE);

        if(empty($post['nama'])){
            $params = array("success" => false, "status" => 1);
        } if(empty($post['alamat'])){
            $params = array("success" => false, "status" => 2);
        } if(empty($post['nama_toko'])){
            $params = array("success" => false, "status" => 3);
        } if(empty($post['no_tlp'])){
            $params = array("success" => false, "status" => 4);
        } if(empty($post['no_rek'])){
            $params = array("success" => false, "status" => 5);
        } if(empty($post['atas_nama'])){
            $params = array("success" => false, "status" => 6);
        } if(empty($post['nama_bank'])){
            $params = array("success" => false, "status" => 7);
        }else{
            $data = [
              
                'nama'                => $post['nama'],
                'alamat'              => $post['alamat'],
                'nama_toko'             => $post['nama_toko'],
                'no_tlp'                => $post['no_tlp'],
                'nama_bank' => $post['nama_bank'],
                'atas_nama' => $post['atas_nama'],
                'no_rek' => $post['no_rek']

            ];

            $this->master_model->addSupplier($data);

            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
        }
        echo json_encode($params);
    }

    public function delete_supplier(){
        $id = $_POST['id'];
        $this->master_model->delSupplier($id);
        if($this->db->affected_rows() > 0) {
            $params = array("success" => true);
        } else {
            $params = array("success" => false);
        }
        echo json_encode($params);
    }

    public function edit_supplier(){
        $post = $this->input->post(null, TRUE);

        if(empty($post['nama'])){
            $params = array("success" => false, "status" => 1);
        } if(empty($post['alamat'])){
            $params = array("success" => false, "status" => 2);
        } if(empty($post['nama_toko'])){
            $params = array("success" => false, "status" => 3);
        } if(empty($post['no_tlp'])){
            $params = array("success" => false, "status" => 4);
        } if(empty($post['no_rek'])){
            $params = array("success" => false, "status" => 5);
        } if(empty($post['atas_nama'])){
            $params = array("success" => false, "status" => 6);
        } if(empty($post['nama_bank'])){
            $params = array("success" => false, "status" => 7);
        }else{
            $data = [
                'nama'                => $post['nama'],
                'alamat'              => $post['alamat'],
                'nama_toko'             => $post['nama_toko'],
                'no_tlp'                => $post['no_tlp'],
                'nama_bank' => $post['nama_bank'],
                'atas_nama' => $post['atas_nama'],
                'no_rek' => $post['no_rek']
            ];

            $id = $_POST['id'];
            $this->db->where('id_supplier', $id)->update('master_supplier', $data);

            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
        }
        echo json_encode($params);
    }

    public function get_supplier_id(){

        $id = $_POST['id'];
        $data = $this->master_model->get_supplier_id($id);
        echo json_encode($data);
    }
    public function get_tipe_ajax(){
        $perum = $_POST['id_perum'];
        $cluster = $_POST['id_cluster'];
        $tipe = $this->db->get_where('tbl_tipe',['id_perum' => $perum, 'id_cluster' => $cluster])->result();
        echo json_encode($tipe);
    }

    public function mandor(){
        $data = [
            'mandor' => $this->db->get('master_mandor')->result()
        ];
        $this->template->load('template', 'master/mandor', $data);
    }

    private function validation_mandor(){
        $this->form_validation->set_rules('mandor','Nama Mandor','required|trim');
        $this->form_validation->set_rules('telp','No Telp','required|trim|numeric');
        $this->form_validation->set_rules('rekening','No Rekening','required|trim|numeric');
        $this->form_validation->set_rules('bank','Nama Bank','required|trim');
        $this->form_validation->set_rules('atas_nama','Atas Nama','required|trim');

        if($this->form_validation->run() == false){
            $data = [
                'type' => 'validation',
                'err_mandor' => form_error('mandor'),
                'err_telp' => form_error('telp'),
                'err_rekening' => form_error('rekening'),
                'err_bank' => form_error('bank'),
                'err_name' => form_error('atas_nama')
            ];
            echo json_encode($data);
            die;
        } else {
            return true;
        }

    }

    public function add_mandor(){
        $this->validation_mandor();

        $data = [
            'nama_mandor' => $this->input->post('mandor'),
            'no_telp' => $this->input->post('telp'),
            'no_rekening' => $this->input->post('rekening'),
            'atas_nama' => $this->input->post('atas_nama'),
            'nama_bank' => $this->input->post('bank')
        ];
        if($this->db->insert('master_mandor', $data)){
            $params = [
                'type' => 'result',
                'success' => true,
                'msg' => 'Data mandor berhasil di tambahkan'
            ];
        } else {
            $params = [
                'type' => 'result',
                'success' => false,
                'msg' => 'Data mandor gagal di tambahkan'
            ];
        }
        echo json_encode($params);

    }

    public function edit_mandor(){
        $id = $this->input->post('id_mandor');
        $this->validation_mandor();
        $data = [
            'nama_mandor' => $this->input->post('mandor'),
            'no_telp' => $this->input->post('telp'),
            'no_rekening' => $this->input->post('rekening'),
            'atas_nama' => $this->input->post('atas_nama'),
            'nama_bank' => $this->input->post('bank')
        ];
        if($this->db->where('id_mandor', $id)->update('master_mandor', $data)){
            $params = [
                'type' => 'result',
                'success' => true,
                'msg' => 'Data mandor berhasil di update'
            ];
        } else {
            $params = [
                'type' => 'result',
                'success' => false,
                'msg' => 'Data mandor gagal di update'
            ];
        }
        echo json_encode($params);
    }

    public function delete_mandor(){
        $id = $_POST['id'];
        if($this->db->delete('master_mandor',['id_mandor' => $id])){
            $params = [
                'success' => true,
                'msg' => 'Data mandor berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Data mandor gagal di hapus'
            ];
        }
        echo json_encode($params);
    }



}