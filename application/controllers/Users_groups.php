<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_groups extends CI_Controller {
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

    public function users() {
        checkUserLogin();
        // $id = null, $group = NULL, $email = NULL, $active = NULL
        $users =  $this->master_model->selectUsers(NULL, NULL, NULL, 1)->result();
        $group =  $this->master_model->select_group()->result();
        $perum =  $this->db->get('tbl_perumahan')->result();
        $data = [
            'list'          => $users,
            'group_list'    => $group,
            'perum'         => $perum
        ];
        $this->template->load('template', 'user_group/users', $data);
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




    public function access_perum(){
        $id_user = $this->input->post('id_user');
        $id_perum = $_POST['access_perum'];

        if(empty($id_perum)){
            $this->db->delete('access_perumahan',['id_user' => $id_user]);
            $params = [
                'success' => true,
                'msg' => 'Akses perumahan berhasil di perbarui'
            ];
            echo json_encode($params);
            die;
        }

        $p = count($id_perum);

        $data = array();
        for($a=0; $a<$p; $a++){
            array_push($data, array(
                'id_user' => $id_user,
                'id_perum' => $id_perum[$a]
            ));
        }
        $this->db->delete('access_perumahan',['id_user' => $id_user]);
        if($this->db->insert_batch('access_perumahan', $data)){
            $params = [
                'success' => true,
                'msg' => 'Akses perumahan berhasil di perbarui'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Akses perumahan gagal di perbarui'
            ];
        }

        echo json_encode($params);
        die;
    }

    public function get_access(){
        $id = $_POST['id'];
        $q = "SELECT * FROM tbl_perumahan JOIN access_perumahan ON tbl_perumahan.id_perumahan = access_perumahan.id_perum AND access_perumahan.id_user = $id";
        $access = $this->db->query($q)->result();

        if($access){
            $output = "";
            foreach($access as $c){
                $output .= "
                  
                        <li>$c->nama_perumahan</li>
                  
                ";
            }
        } else {
            $output = "<p class='text-center'>No data result</p>";
        }

        // echo json_encode($output);
        echo $output;
    }



    public function coba(){

        // $q = "SELECT * FROM db_module JOIN db_group_module WHERE db_module.aktif = 1 AND db_group_module.modul_id = db_module.id AND db_module.aktif = 1 AND db_module.parent = 999";
        // $data = $this->db->query($q)->result();

        $menu = $this->db->get_where('db_module',['parent' => 999 , 'aktif' => 1])->result();
        // $menu = $this->db->query($q)->result();

        // var_dump($menu);die;
        $data['menu'] = $menu;

        $this->load->view('coba', $data);

    }

















    //1-9-2022

    public function get_group_ajax(){
        $id = $_POST['id'];
        $group = $this->db->get_where('db_group',['id' => $id])->row();
        echo json_encode($group);
    }

    public function val_group(){
        $this->form_validation->set_rules('group_name','Nama group', 'required|trim|is_unique[db_group.group_name]');
        if($this->form_validation->run() == false){
            $params = [
                'type' => 'validation',
                'err_group' => form_error('group_name')
            ];
            echo json_encode($params);
            die;
        } else {
            return true;
        }
    }

    public function add_group(){
        $this->val_group();
        $data = [
            'group_name'    => $this->input->post('group_name'),
            'home'          => 1,
            'user_id'       => userId(),
        ];
        $this->master_model->add_groups($data);
        if($this->db->affected_rows() > 0){
            $params = [
                'type' => 'result',
                'success' => true,
                'msg' => 'Group baru berhasil di tambahkan'
            ];
        } else {
            $params = [
                'type' => 'result',
                'success' => true,
                'msg' => 'Group baru gagal di tambahkan'
            ];
        }
        echo json_encode($params);
    }

    public function edit_group(){
        $this->val_group();
        $id = $this->input->post('id_group');
        $this->db->set('group_name', $this->input->post('group_name'))->where('id', $id)->update('db_group');
        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'msg' => 'Group berhasil di update' ,
                'type' => 'result'
            ];
        } else {
            $params = [
                'success' => true,
                'msg' => 'Group gagal di update',
                'type' => 'result'
            ];
        }

        echo json_encode($params);

    }

    public function set_status_group(){
        $id = $_POST['id'];
        $val = $_POST['val'];

        if($val == 1){
            $data = [
                'status' => 1,
            ];
        } else if($val == 2){
            $data = [
                'status' => 2,
            ];
        }

        $this->db->where('id', $id)->update('db_group', $data);

        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'msg' => 'Status group berhasil di update'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Status group gagal di update'
            ];
        }

        echo json_encode($params);

    }


    public function delete_group(){
        $id = $_POST['id'];
        $this->master_model->del_groups($id);
        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'msg' => 'Group berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => true,
                'msg' => 'Group gagal di hapus'
            ];
        }

        echo json_encode($params);
    }





    public function val_user(){
        $this->form_validation->set_rules('user','Nama user','required|trim');
        $this->form_validation->set_rules('telp','No telp','required|trim|numeric|is_unique[db_user.email]');
        $this->form_validation->set_rules('pass1','Password','required|trim|matches[pass2]');
        $this->form_validation->set_rules('pass2','Re-type password','required|trim|matches[pass1]');

        if($this->form_validation->run() == false){
            $params = [
                'type' => 'validation',
                'err_user' => form_error('user'),
                'err_telp' => form_error('telp'),
                'err_pass1' => form_error('pass1'),
                'err_pass2' => form_error('pass2')
            ];
            echo json_encode($params);
            die;
        } else {
            return true;
        }

    }

    public function add_user(){
        $this->val_user();
        $data = [
            'group_id'  => $this->input->post('group'),
            'password'  => MD5($this->input->post('pass1')),
            'nama'      => $this->input->post('user'),
            'email'     => $this->input->post('telp'),
            'store_id'  => 1,
            'status'    => 1,
        ];
        $this->master_model->add_users($data);

        if($this->db->affected_rows() > 0){
            $params = [
                'type' => 'result',
                'success' => true,
                'msg' => 'User baru berhasil di tambahkan'
            ];
        } else {
            $params = [
                'type' => 'result',
                'success' => false,
                'msg' => 'User baru gagal di tambahkan'
            ];
        }

        echo json_encode($params);

    }

    public function change_group(){
        $id = $this->input->post('id_user');

        if($this->db->set('group_id', $this->input->post('group'))->where('id', $id)->update('db_user')){
            $params = [
                'success' => true,
                'msg' => 'Group user berhasil di update'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Group user gagal di update'
            ];
        }

        echo json_encode($params);

    }

    public function set_status_user(){

        $id = $_POST['id'];
        $val = $_POST['val'];

        if($val == 1){
            $data = [
                'status' => 1
            ];
        } else if($val == 2) {
            $data = [
                'status' => 2
            ];
        }

        if($this->db->where('id', $id)->update('db_user', $data)){
            $params = [
                'success' => true,
                'msg' => 'Status user berhasil di edit'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Status user berhasil di edit'
            ];
        }

        echo json_encode($params); 

    }

    public function get_ajax_user(){
        $id = $_POST['id'];
        $user = $this->db->get_where('db_user',['id' => $id])->row();
        echo json_encode($user);
    }


    public function edit_user(){
        $id_user = $this->input->post('id_user');

        $this->form_validation->set_rules('user','Nama user','required|trim');
        $this->form_validation->set_rules('telp','No telp','required|trim|numeric|is_unique[db_user.email]');
        $this->form_validation->set_rules('pass1','Password','trim|matches[pass2]');
        $this->form_validation->set_rules('pass2','Re-type password','trim|matches[pass1]');

        if($this->form_validation->run() == false){
            $params = [
                'type' => 'validation',
                'err_user' => form_error('user'),
                'err_telp' => form_error('telp'),
                'err_pass1' => form_error('pass1'),
                'err_pass2' => form_error('pass2')
            ];
            echo json_encode($params);
            die;
        } else {
            
            $pass = $this->input->post('pass1');

            if($pass){
                $data = [
                    'nama'      => $this->input->post('user'),
                    'email'     => $this->input->post('telp'),
                    'password' => md5($pass)
                ];
            } else {
                $data = [
                    'nama'      => $this->input->post('user'),
                    'email'     => $this->input->post('telp')
                ];
            }

            $this->db->where('id', $id_user)->update('db_user', $data);

            if($this->db->affected_rows() > 0){
                $params = [
                    'type' => 'result',
                    'success' => true,
                    'msg' => 'User berhasil di edit'
                ];
            } else {
                $params = [
                    'type' => 'result',
                    'success' => false,
                    'msg' => 'User gaga di edit'
                ];
            }

            echo json_encode($params);

        }

    }

    public function delete_user(){
        $id = $_POST['id'];
        $this->master_model->del_users($id);
        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'msg' => 'User berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'User gagal di hapus'
            ];
        }

        echo json_encode($params);
    }

}