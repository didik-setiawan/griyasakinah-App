<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_model extends CI_Model{

    public function selectPerumahan($id = null, $group = NULL, $email = NULL, $active = NULL) {
        $this->db->select('
            db_user.*, 
            db_group.group_name AS nama_group,
            store_profile.nama_lembaga as nama_lembaga,
            store_profile.id as id_lembaga,
        ');
        $this->db->from('db_user');
        $this->db->join('db_group', 'db_user.group_id = db_group.id');
        $this->db->join('store_profile', 'db_user.store_id = store_profile.id');

        if($id != null) {
            $this->db->where('db_user.id', $id);
        }
        if($group != null) {
            $this->db->where('db_user.group_id', $group);
        }
        if($email != null) {
            $this->db->like('db_user.email', $email);
        }
        if($active != null) {
            $this->db->where('db_user.active', 0);
        }
        $this->db->order_by('db_user.id', 'desc');
        $query = $this->db->get();
        return $query;
    }
	public function select_users($post) {
        $this->db->from('db_user');
        $this->db->where('email', $post['email']);
        $this->db->where('password', MD5($post['password']));
        $this->db->where('active', 0);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query;
    }

    public function select_group($id = null, $status = NULL, $nama = NULL) {
        $this->db->from('db_group');
        if($id != null) {
            $this->db->where('id', $id);
        }
        if($status != null) {
            $this->db->where('status', $status);
        }
        if($nama != null) {
            $this->db->where('group_name', $nama);
        }
        $this->db->where('active', 0);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function add_groups($params) {
        $this->db->insert('db_group', $params);
    }

    public function edit_groups($id = NULL, $post = NULL, $status = NULL) {
        if($status != NULL){
            $params = [
                'status' => $status
            ];
        }
        if($post != NULL){
            $params = [
                'group_name'        => $post['edit_nama_group'],
                // 'durasi_awal'       => $post['durasi_awal1'],
                // 'durasi_akhir'      => $post['durasi_akhir1']
            ];
        }
        $this->db->where('id', $id);
        $this->db->update('db_group', $params);
    }
    
    public function del_groups($id) {
        // konsep nya update 'active' jadi = 1
        $params = [
            'status'    => 2,
            'active'    => 1
        ];

        $this->db->where('id', $id);
        $this->db->update('db_group', $params);
        // $this->db->delete('db_group');
    }

    public function selectUsers($id = null, $group = NULL, $email = NULL, $active = NULL) {
        $this->db->select('
            db_user.*, 
            db_group.group_name AS nama_group,
            store_profile.nama_lembaga as nama_lembaga,
            store_profile.id as id_lembaga,
        ');
        $this->db->from('db_user');
        $this->db->join('db_group', 'db_user.group_id = db_group.id');
        $this->db->join('store_profile', 'db_user.store_id = store_profile.id');

        if($id != null) {
            $this->db->where('db_user.id', $id);
        }
        if($group != null) {
            $this->db->where('db_user.group_id', $group);
        }
        if($email != null) {
            $this->db->like('db_user.email', $email);
        }
        if($active != null) {
            $this->db->where('db_user.active', 0);
        }
        $this->db->order_by('db_user.id', 'desc');
        $query = $this->db->get();
        return $query;
    }
	
	

    public function select_users_all($id = null, $group = NULL, $email = NULL, $sales = NULL) {
        $this->db->from('db_user');
        if($id != null) {
            $this->db->where('id', $id);
        }
        if($group != null) {
            $this->db->where('group_id', $group);
        }
        if($email != null) {
            $this->db->like('email', $email);
        }
        if($sales != null) {
            $this->db->like('sales_id', $sales);
        }
        // $this->db->where('active', 0);
        $query = $this->db->get();
        return $query;
    }

    public function add_users($data) {
        $this->db->insert('db_user', $data);
    }

    public function updateUserSales($group = NULL, $sales = NULL) {
        $this->db->where('group_id', $group);
        $this->db->where('sales_id', $sales);
        $this->db->delete('db_user');
    }

    public function updateUser($id = NULL, $group = NULL, $status = NULL, $del = NULL) {
        if($group != NULL){
            $params['group_id'] = $group;
        }
        if($status != NULL){
            $params['status'] = $status;
        }
        if($del != NULL){
            $params['active'] = 1;
        }
        $this->db->where('id', $id);
        $this->db->update('db_user', $params);
    }

    public function edit_users($id = NULL, $data = NULL) {
        $this->db->where('id', $id);
        $this->db->update('db_user', $data);
    }

    public function del_users($id) {
        $this->db->where('id', $id);
        $this->db->delete('db_user');
    }

    public function select_group_modul($id = null) {
        $this->db->from('db_group_module');
        if($id != null) {
            $this->db->where('modul_id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function groupModul($id = null, $modul = null) {
        $this->db->from('db_group_module');
        if($id != null) {
            $this->db->where('group_id', $id);
        }
        if($modul != null) {
            $this->db->where('modul_id', $modul);
        }
        $query = $this->db->get();
        return $query;
    }

    public function menu_modul($id = null, $level = NULL, $tipe = NULL, $parent = NULL, $aktif = NULL, $url = NULL, $order = NULL) {
        $this->db->from('db_module');
        if($id != null) {
            $this->db->where('id', $id);
        }
        if($level != null) {
            $this->db->where('level', $level);
        }
        if($tipe != null) {
            $this->db->where('tipe', $tipe);
        }
        if($parent != null) {
            $this->db->where('parent', $parent);
        }
        if($aktif != null) {
            $this->db->where('aktif', $aktif);
        }
        if($url != null) {
            $this->db->where('url', $url);
        }
        // if($order != null) {
            $this->db->order_by('tipe', 'ASC');
        // }
        $query = $this->db->get();
        return $query;
    }

    public function menuModulUrl($id = null, $url = NULL) {
        $this->db->from('db_module');
        if($id != null) {
            $this->db->where('id', $id);
        }
        if($url != null) {
            $this->db->where('url', $url);
        }
        $query = $this->db->get();
        return $query;
    }

    public function ModulAktif($id = null) {
        $this->db->from('db_module');
        if($id != null) {
            $this->db->where('id', $id);
        }
        $this->db->where('aktif', 1);
        $query = $this->db->get();
        return $query;
    }

    public function edit_modules($data) {
        $this->db->update_batch('db_module', $data, 'id'); 
    }

    public function menu_modul_edit() {
        $filter = $this->input->get('cari');
        $this->db->like('id', $filter);
        $this->db->order_by('id', 'DESC');
        return $this->db->get("db_module");
    }

    public function del_role($id) {
        $this->db->where('group_id', $id);
        $this->db->delete('db_group_module');

    }

    public function edit_role($data) {
        $this->db->insert_batch('db_group_module', $data);
    }

    public function ganti_password($post) {
        $params['password'] = MD5($post['ganti_password']);
        $this->db->where('id', $post['user_id']);
        $this->db->update('db_user', $params);
    }

    public function historyUser($post) {
        $params['user_id'] = $post;
        $this->db->insert('db_user_history_login', $params);
    }
    
    public function cekValidDate() {
        $this->db->from('db_user_history_login');
        $this->db->order_by('db_user_history_login.last_login', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query;
    }
    
    public function cekHistory($id = NULL, $lembaga = NULL) {
        
        $this->db->select('
            db_user_history_login.*, 
            db_user.nama AS nama_user,
            db_group.group_name AS nama_group,
            store_profile.nama_lembaga as nama_lembaga,
            store_profile.id as id_lembaga,
        ');

        $this->db->from('db_user_history_login');
        $this->db->join('db_user', 'db_user_history_login.user_id = db_user.id');
        $this->db->join('db_group', 'db_user.group_id = db_group.id');
        $this->db->join('store_profile', 'db_user.store_id = store_profile.id');

        if($id != NULL){
            $this->db->where('db_user_history_login.user_id', $id);
        }

        if($lembaga != NULL){
            $this->db->where('store_profile.id', $lembaga);
        }
        $this->db->order_by('db_user_history_login.last_login', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query;
        // $query = "SELECT * FROM db_user_history_login WHERE user_id = ".userId()." ORDER BY last_login DESC LIMIT 1";
        // $query = $this->db->query($query);
        // return $query;
    }
    
    public function cekTotalUser($id = NULL, $lembaga = NULL) {
        
        $this->db->select('COUNT(db_user.id) as total_user');
        $this->db->from('db_user');
        $this->db->join('db_group', 'db_user.group_id = db_group.id');
        $this->db->join('store_profile', 'db_user.store_id = store_profile.id');
        if($id != NULL){
            $this->db->where('db_user.id', $id);
        }
        if($lembaga != NULL){
            $this->db->where('store_profile.id', $lembaga);
        }
        $query = $this->db->get();
        return $query;
    }
    
    public function cekTotalGroup($id = NULL, $lembaga = NULL) {
        
        $this->db->select('COUNT(db_group.id) as total_group');
        $this->db->from('db_group');
        $this->db->join('db_user', 'db_group.user_id = db_user.id');
        $this->db->join('store_profile', 'db_user.store_id = store_profile.id');
        if($id != NULL){
            $this->db->where('db_group.id', $id);
        }
        if($lembaga != NULL){
            $this->db->where('store_profile.id', $lembaga);
        }
        $query = $this->db->get();
        return $query;
    }
    
    public function cekGroups($id) {
        $this->db->where('id', $id);
        $this->db->from('db_group');
        $query = $this->db->get();
        return $query;
    }
    
    public function getProfile($id = NULL) {
        $this->db->from('store_profile');
        if($id != NULL) {
            $this->db->where('store_profile.id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function editProfile($id = NULL, $data = NULL) {
        $this->db->where('id', $id);
        $this->db->update('store_profile', $data);
    }

    public function getPerumahan()
    {
        $this->db->select('*');
        $this->db->from('tbl_perumahan');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function cekPerumahan($id)
    {
        return $this->db->get_where('tbl_perumahan', ['id_perumahan' => $id])->row_array();
    }

    public function masukPerumahan($id)
    {
        $this->db->from('tbl_perumahan');
        $this->db->where('id_perumahan', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function add_kavling($data){
        return $this->db->insert('tbl_kavling', $data);
    }

    public function get_kavling_join_perum(){
        $q = "SELECT * FROM tbl_perumahan, tbl_kavling, tbl_cluster, tbl_tipe WHERE tbl_kavling.id_perum = tbl_perumahan.id_perumahan AND tbl_kavling.id_cluster = tbl_cluster.id_cluster AND tbl_kavling.id_tipe = tbl_tipe.id_tipe";
        return $this->db->query($q)->result();
    }

    public function get_kavling_join_perum2(){
        $q = "SELECT * FROM tbl_perumahan, tbl_tipe, tbl_kavling WHERE tbl_kavling.id_perum = tbl_perumahan.id_perumahan AND tbl_perumahan.cluster = 0 AND tbl_kavling.id_tipe = tbl_tipe.id_tipe";
        return $this->db->query($q)->result();
    }

    public function delete_kavling($id){
        return $this->db->delete('tbl_kavling',['id_kavling' => $id]);
    }

    public function get_kavling_id($id){
        // return $this->db->get_where('tbl_kavling',['id_kavling' => $id])->row();
        $q = "SELECT * FROM tbl_kavling JOIN tbl_perumahan WHERE tbl_kavling.id_kavling = $id AND tbl_kavling.id_perum = tbl_perumahan.id_perumahan";
        return $this->db->query($q)->row();

    }

    public function listUnit($id = NULL) {
        $this->db->select('
            master_produk_unit.*, 
            db_user.nama as nama_user, 
            db_group.group_name as nama_group, 
            db_group.id as id_group, 
            store_profile.nama_lembaga as nama_lembaga,
            store_profile.id as id_lembaga,
        ');

        $this->db->from('master_produk_unit');
        $this->db->join('db_user', 'master_produk_unit.user_id = db_user.id');
        $this->db->join('db_group', 'db_user.group_id = db_group.id');
        $this->db->join('store_profile', 'db_user.store_id = store_profile.id');

        if($id != NULL) {
            $this->db->where('master_produk_unit.id', $id);
        }
    
        $this->db->where('master_produk_unit.action', 0);
        $this->db->order_by('master_produk_unit.nama_satuan', 'asc');

        $query = $this->db->get();
        return $query;
    }


    public function listKategori($id = NULL) {
        $this->db->select('
            master_produk_kategori.*, 
            db_user.nama as nama_user, 
            db_group.group_name as nama_group, 
            db_group.id as id_group, 
            store_profile.nama_lembaga as nama_lembaga,
            store_profile.id as id_lembaga,
        ');
        
        $this->db->from('master_produk_kategori');
        $this->db->join('db_user', 'master_produk_kategori.user_id = db_user.id');
        $this->db->join('db_group', 'db_user.group_id = db_group.id');
        $this->db->join('store_profile', 'db_user.store_id = store_profile.id');

        if($id != NULL) {
            $this->db->where('master_produk_kategori.id', $id);
        }
        $this->db->where('master_produk_kategori.action', 0);
        $this->db->order_by('master_produk_kategori.kategori_produk', 'asc');

        $query = $this->db->get();
        return $query;
    }

    public function listMaterial($id  = NULL) {
        $this->db->select('
        master_material.*,
        master_produk_kategori.id as id_kategori, 
        master_produk_kategori.kategori_produk, 
        master_produk_unit.id as id_unit,  
        master_produk_unit.nama_satuan,
        ');
        
        $this->db->from('master_material');
        $this->db->join('master_produk_kategori', 'master_produk_kategori.id = master_material.kategori_id');
        $this->db->join('master_produk_unit', 'master_produk_unit.id = master_material.unit_id');
        $this->db->order_by('master_material.created_at', 'desc');
       
        if($id  != NULL) {
            $this->db->where('master_material.id', $id );
        }
        $query = $this->db->get();
        return $query;
    }

    public function add_material($data){
        return $this->db->insert('master_material', $data);
    }
    public function delete_material($id){
        return $this->db->delete('master_material',['id' => $id]);
    }
    public function get_material_id($id){
        return $this->db->get_where('master_material',['id' => $id])->row();
    }








    public function get_kavling_join_perum_filter_perum($req){
        $q = "SELECT * FROM tbl_perumahan, tbl_kavling, tbl_cluster, tbl_tipe WHERE tbl_kavling.id_perum = tbl_perumahan.id_perumahan AND tbl_kavling.id_cluster = tbl_cluster.id_cluster AND tbl_kavling.id_tipe = tbl_tipe.id_tipe AND tbl_perumahan.id_perumahan = $req";
        return $this->db->query($q)->result();
    }

    public function get_kavling_join_perum2_filter_perum($req){
        $q = "SELECT * FROM tbl_perumahan, tbl_tipe, tbl_kavling WHERE tbl_kavling.id_perum = tbl_perumahan.id_perumahan AND tbl_perumahan.cluster = 0 AND tbl_kavling.id_tipe = tbl_tipe.id_tipe AND tbl_perumahan.id_perumahan = $req";
        return $this->db->query($q)->result();
    }

    public function get_kavling_join_perum_filter_perum_cluster($perum, $cluster){
        $q = "SELECT * FROM tbl_perumahan, tbl_kavling, tbl_cluster, tbl_tipe WHERE tbl_kavling.id_perum = tbl_perumahan.id_perumahan AND tbl_kavling.id_cluster = tbl_cluster.id_cluster AND tbl_kavling.id_tipe = tbl_tipe.id_tipe AND tbl_perumahan.id_perumahan = $perum AND tbl_cluster.id_cluster = $cluster";
        return $this->db->query($q)->result();
    }
    




    public function get_count($db, $where){
        return $this->db->get_where($db, [$where => 2])->num_rows();
    }

    public function get_data_confirm($db, $where){
        return $this->db->get_where($db, [$where => 2])->result();
    }

    public function get_show_details($db, $id, $where){
        $q = "SELECT * FROM tbl_marketing JOIN $db ON tbl_marketing.id_marketing = $db.id_konsumen WHERE $db.$where = $id";
        return $this->db->query($q)->row();
    }




    // 18-6-22


    public function addKategori($params) {
        $this->db->insert('master_produk_kategori', $params);
    }

    public function delKategori($id = NULL) {
        $params['action'] = 1;
        $this->db->where('id', $id);
        $this->db->update('master_produk_kategori', $params);
    }

    public function get_jenis_material_id($id){
        return $this->db->get_where('master_produk_kategori',['id' => $id])->row();
    }
    // akhirjenis_material

    public function addUnit($params) {
        $this->db->insert('master_produk_unit', $params);
    }

    public function delUnit($id = NULL) {
        $params['action'] = 1;
        $this->db->where('id', $id);
        $this->db->update('master_produk_unit', $params);
    }

    public function get_unit_id($id){
        return $this->db->get_where('master_produk_unit',['id' => $id])->row();
    }
    //end Unit

    public function listmaterialMax($id  = NULL) {
        $this->db->select('
        tbl_max_material.*,
        tbl_tipe.*,
        ');
        
        $this->db->from('tbl_max_material');
        $this->db->join('tbl_tipe', 'tbl_max_material.id_tipe = tbl_tipe.id_tipe');
        $this->db->join('tbl_cluster', 'tbl_cluster.id_cluster = tbl_tipe.id_cluster');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_tipe.id_perum');
        $this->db->where('tbl_tipe.id_perum',$this->session->userdata('id_perumahan'));
       
        if($id  != NULL) {
            $this->db->where('tbl_max_material.id_max', $id );
        }
        $query = $this->db->get();
        return $query;
    }

    public function listTipe($id  = NULL) {
        $this->db->select('
        tbl_tipe.*,
        tbl_cluster.*,
        tbl_perumahan.*,
        ');
        
        $this->db->from('tbl_tipe');
        $this->db->join('tbl_cluster', 'tbl_cluster.id_cluster = tbl_tipe.id_cluster','left');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_tipe.id_perum');
        $this->db->where('tbl_tipe.id_perum',$this->session->userdata('id_perumahan'));
        $this->db->order_by('tbl_tipe.id_tipe','desc');
       
        if($id  != NULL) {
            $this->db->where('tbl_tipe.id_tipe', $id );
        }
        $query = $this->db->get();
        return $query;
    }

    public function addmaterialMax($params) {
        $this->db->insert('tbl_max_material', $params);
    }

    public function get_materialMax_id($id){
        return $this->db->get_where('tbl_max_material',['id_max' => $id])->row();
    }

    public function delMax($id = NULL) {
        return $this->db->delete('tbl_max_material',['id_max' => $id]);
    }
    //end material Max

    //TIPE
    public function addTipe($params) {
        $this->db->insert('tbl_tipe', $params);
    }

    public function addMax($params) {
        $this->db->insert('tbl_max_material', $params);
    }

    public function GetMaterial($id = NULL)
    {
        $this->db->select('
            master_material.*,
            master_produk_kategori.id as id_kategori, 
            master_produk_kategori.kategori_produk, 
            master_produk_unit.id as id_unit,  
            master_produk_unit.nama_satuan,
        ');

        $this->db->from('master_material');
        $this->db->join('master_produk_kategori', 'master_produk_kategori.id = master_material.kategori_id');
        $this->db->join('master_produk_unit', 'master_produk_unit.id = master_material.unit_id');
        $this->db->group_by('master_produk_kategori.id');

        if ($id != NULL) {
            $this->db->where('master_material.id', $id);
        }

        $query = $this->db->get();
        return $query;
    }

    public function get_tipe_id($id){
        $q = "SELECT * FROM tbl_tipe JOIN tbl_perumahan WHERE tbl_tipe.id_tipe = $id AND tbl_tipe.id_perum = tbl_perumahan.id_perumahan";
        return $this->db->query($q)->row();
    }

    public function getKategori()
    {
        $this->db->select('*');
        $this->db->where('action', 0);
        $this->db->from('master_produk_kategori');
        $query = $this->db->get();
        return $query;
    }

    public function getMat($id = NULL)
    {
        $this->db->select('
            master_material.*,
            master_produk_kategori.id as id_kategori, 
            master_produk_kategori.kategori_produk, 
            master_produk_unit.id as id_unit,  
            master_produk_unit.nama_satuan,
        ');

        $this->db->from('master_material');
        $this->db->join('master_produk_kategori', 'master_produk_kategori.id = master_material.kategori_id');
        $this->db->join('master_produk_unit', 'master_produk_unit.id = master_material.unit_id');

        if ($id != NULL) {
            $this->db->where('master_produk_kategori.id', $id);
        }

        $query = $this->db->get();
        return $query;
    }

    public function getSat($id = NULL)
    {
        $this->db->select('
            master_material.*,
            master_produk_unit.id as id_unit,  
            master_produk_unit.nama_satuan,
        ');

        $this->db->from('master_material');
        $this->db->join('master_produk_unit', 'master_produk_unit.id = master_material.unit_id');

        if ($id != NULL) {
            $this->db->where('master_material.id', $id);
        }

        $query = $this->db->get();
        return $query;
    }

    public function delMaterialMax($id = NULL) {
        return $this->db->delete('tbl_max_material',['id_tipe' => $id]);
    }

    public function delete_tipe($id = NULL) {
        return $this->db->delete('tbl_tipe',['id_tipe' => $id]);
    }

    public function TipeMaxMaterial($id_tipe  = NULL, $id_max  = NULL) {
        $this->db->select('
        tbl_max_material.*,
        tbl_max_material.id_tipe as tipe_id,
        tbl_tipe.*,

        master_material.*,
        master_produk_kategori.id as id_kategori, 
        master_produk_kategori.kategori_produk, 
        master_produk_unit.id as id_unit,  
        master_produk_unit.nama_satuan,

        ');
        
        $this->db->from('tbl_max_material');
        $this->db->join('master_material', 'tbl_max_material.material_id = master_material.id');
        $this->db->join('master_produk_kategori', 'master_produk_kategori.id = master_material.kategori_id');
        $this->db->join('master_produk_unit', 'master_produk_unit.id = master_material.unit_id');

        $this->db->join('tbl_tipe', 'tbl_max_material.id_tipe = tbl_tipe.id_tipe');
        $this->db->join('tbl_cluster', 'tbl_cluster.id_cluster = tbl_tipe.id_cluster');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_tipe.id_perum');
        $this->db->where('tbl_tipe.id_perum',$this->session->userdata('id_perumahan'));
       
        if($id_tipe  != NULL) {
            $this->db->where('tbl_max_material.id_tipe', $id_tipe );
        }

        if($id_max  != NULL) {
            $this->db->where('tbl_max_material.id_max', $id_max );
        }


        $query = $this->db->get();
        return $query;
    }

    public function addSupplier($params)
    {
        $this->db->insert('master_supplier', $params);
    }

    public function delSupplier($id = NULL) {
        return $this->db->delete('master_supplier',['id_supplier' => $id]);
    }

    public function get_supplier_id($id){
        return $this->db->get_where('master_supplier',['id_supplier' => $id])->row();
    }





    // 1-8-2022

    public function get_confirm_pembangunan_admin($id = null){
        // return $this->db->get_where('progres_pembangunan',['status' => 3])->num_rows();
        $id_perum = $this->session->userdata('id_perumahan');
        $this->db->select('cicil_progres.*,
            cicil_progres.tanggal as tgl,
            progres_pembangunan.*,
            tbl_kavling.id_perum
        ')
        ->from('cicil_progres')
        ->join('progres_pembangunan','cicil_progres.id_progres = progres_pembangunan.id_progres')
        ->join('tbl_kavling','progres_pembangunan.kavling_id = tbl_kavling.id_kavling')
        ->where('tbl_kavling.id_perum', $id_perum)
        ->where('cicil_progres.status', 1);
        if($id){
            $this->db->where('cicil_progres.id_cicil', $id);
        }
        return $this->db->get();
    }

    public function get_pembangunan_admin(){
        return $this->db->order_by('id_progres','DESC')->get_where('progres_pembangunan',['status' => 3])->result();
    }

    public function get_upah_confirm_id($id){
        $q = "SELECT
            master_proyek.*,
            tbl_proyek_upah.*,
            progres_pembangunan.*, progres_pembangunan.status as status_pembangunan,
            tbl_kavling.*,
            tbl_tipe.*,
            tbl_cluster.* 
            FROM
            master_proyek,
            tbl_proyek_upah,
            progres_pembangunan,
            tbl_kavling,
            tbl_tipe,
            tbl_cluster
            WHERE
            master_proyek.id = tbl_proyek_upah.proyek_id AND
            tbl_proyek_upah.id = progres_pembangunan.upah_id AND
            progres_pembangunan.kavling_id = tbl_kavling.id_kavling AND
            tbl_kavling.id_tipe = tbl_tipe.id_tipe AND
            tbl_kavling.id_cluster = tbl_cluster.id_cluster AND
            progres_pembangunan.id_progres = $id 
        ";

        return $this->db->query($q)->row();

    }



    //21-8-2022
    public function get_fee_marketing_admin(){
        $data = $this->db->get_where('tbl_marketing',['status_fee_marketing' => 2])->result();
        return $data;
    }

    public function get_confirm_fee_marketing($id = null){
       
        $this->db->select('cicil_fee_marketing.*,
            cicil_fee_marketing.status as status_cicil,
            cicil_fee_marketing.tanggal as tgl_cicil,
            tbl_marketing.*,
        ')
        ->from('cicil_fee_marketing')
        ->join('tbl_marketing','cicil_fee_marketing.id_marketing = tbl_marketing.id_marketing')
        ->where('cicil_fee_marketing.status', 1);

        if($id){
            $this->db->where('cicil_fee_marketing.id_cicil', $id);
        }

        return $this->db->get();
    }

    public function get_fee_marketing_id($id){
        return $this->db->get_where('tbl_marketing',['id_marketing' => $id])->row();
    }




    //2-9-2022

    public function get_kode_fee_marketing($id){
        $q = "SELECT * FROM
            tbl_marketing JOIN
            title_kode ON tbl_marketing.title_kode = title_kode.id_title
            JOIN sub_kode ON title_kode.id_sub = sub_kode.id_sub 
            JOIN kode ON sub_kode.id_kode = kode.id_kode
            WHERE tbl_marketing.id_marketing = $id
        ";
        $data = $this->db->query($q)->row();
        return $data;
    }


    public function get_kode_upah($id){
        $q = "SELECT * FROM
            progres_pembangunan JOIN
            title_kode ON progres_pembangunan.title_kode = title_kode.id_title
            JOIN sub_kode ON title_kode.id_sub = sub_kode.id_sub 
            JOIN kode ON sub_kode.id_kode = kode.id_kode
            WHERE progres_pembangunan.id_progres = $id
        ";
        $data = $this->db->query($q)->row();
        return $data;
    }

    public function get_kode_transaksi_konsumen($db, $where, $id){
        $q = "SELECT * FROM
            $db JOIN
            title_kode ON $db.title_kode = title_kode.id_title
            JOIN sub_kode ON title_kode.id_sub = sub_kode.id_sub 
            JOIN kode ON sub_kode.id_kode = kode.id_kode
            WHERE $db.$where = $id
        ";
        $data = $this->db->query($q)->row();
        return $data;
    }


    public function get_confirm_pembebasan_lahan(){
        return $this->db->get_where('cicil_pembebasan_lahan',['status' => 2])->num_rows();
    }

    public function get_pembebasan_lahan($id = null){
        // return $this->db->order_by('id_cicil','DESC')->get_where('cicil_pembebasan_lahan',['status' => 2])->result();
        $id_perum = $this->session->userdata('id_perumahan');
        $this->db->select('pembebasan_lahan.*, cicil_pembebasan_lahan.*, tbl_perumahan.nama_perumahan')
        ->from('pembebasan_lahan')
        ->join('cicil_pembebasan_lahan','pembebasan_lahan.id_pembebasan = cicil_pembebasan_lahan.id_pembebasan')
        ->join('tbl_perumahan','tbl_perumahan.id_perumahan = pembebasan_lahan.id_perumahan')
        ->where('tbl_perumahan.id_perumahan', $id_perum)
        ->where('cicil_pembebasan_lahan.status', 1);
        if($id){
            $this->db->where('cicil_pembebasan_lahan.id_cicil', $id);
        }
        return $this->db->get();
    }

    public function get_pembebasan_id($id){
        $q = "SELECT * FROM cicil_pembebasan_lahan JOIN pembebasan_lahan ON cicil_pembebasan_lahan.id_pembebasan = pembebasan_lahan.id_pembebasan JOIN tbl_perumahan ON pembebasan_lahan.id_perumahan = tbl_perumahan.id_perumahan WHERE cicil_pembebasan_lahan.id_cicil = $id
        ";
        return $this->db->query($q)->row();

        // return $this->db->get_where('cicil_pembebasan_lahan',['id_cicil' => $id])->row();
    }


    public function get_kode_pembebasan($id){
        $q = "SELECT * FROM
            pembebasan_lahan JOIN
            title_kode ON pembebasan_lahan.title_kode = title_kode.id_title
            JOIN sub_kode ON title_kode.id_sub = sub_kode.id_sub 
            JOIN kode ON sub_kode.id_kode = kode.id_kode
            WHERE pembebasan_lahan.id_pembebasan = $id
        ";
        $data = $this->db->query($q)->row();
        return $data;
    }


    public function get_confirm_pengeluaran_lain($id = null){
        // return $this->db->get_where('pengeluaran_lain',['status' => 2])->num_rows();
        $id_perum = $this->session->userdata('id_perumahan');
        $this->db->select('*')
        ->from('pengeluaran_lain')
        ->join('cicil_pengeluaran_lain','pengeluaran_lain.id_pengeluaran = cicil_pengeluaran_lain.id_pengeluaran')
        ->where('pengeluaran_lain.id_perumahan', $id_perum)
        ->where('cicil_pengeluaran_lain.status', 1);
        if($id){
            $this->db->where('cicil_pengeluaran_lain.id_cicil', $id);
        }
        return $this->db->get();
    }

    public function get_pengeluaran_lain(){
        return $this->db->get_where('pengeluaran_lain',['status' => 2])->result();
    }

    public function get_pengeluaran_id($id){
        return $this->db->get_where('pengeluaran_lain',['id_pengeluaran' => $id])->row();
    }

    public function get_kode_pengeluaran($id){
        $q = "SELECT * FROM
            pengeluaran_lain JOIN
            title_kode ON pengeluaran_lain.title_kode = title_kode.id_title
            JOIN sub_kode ON title_kode.id_sub = sub_kode.id_sub 
            JOIN kode ON sub_kode.id_kode = kode.id_kode
            WHERE pengeluaran_lain.id_pengeluaran = $id
        ";
        $data = $this->db->query($q)->row();
        return $data;
    }



    //5-9-2022

    public function get_confirm_rab_material(){
        $q = "SELECT * FROM tbl_proyek_material JOIN master_proyek ON tbl_proyek_material.proyek_id = master_proyek.id WHERE tbl_proyek_material.status = 2 AND master_proyek.rab = 1";
        return $this->db->query($q)->num_rows();
    }

    public function get_confirm_rab_upah(){
        $q = "SELECT * FROM tbl_proyek_upah JOIN master_proyek ON tbl_proyek_upah.proyek_id = master_proyek.id WHERE tbl_proyek_upah.status = 2 AND master_proyek.rab = 1";
        return $this->db->query($q)->num_rows();
    }

    public function get_confirm_rab_lain(){
        $q = "SELECT * FROM tbl_proyek_lainnya JOIN master_proyek ON tbl_proyek_lainnya.proyek_id = master_proyek.id WHERE tbl_proyek_lainnya.status = 2 AND master_proyek.rab = 1";
        return $this->db->query($q)->num_rows();
    }


    public function get_rab_material(){
        $q = "SELECT tbl_proyek_material.*, tbl_proyek_material.id as id_material FROM tbl_proyek_material JOIN master_proyek ON tbl_proyek_material.proyek_id = master_proyek.id WHERE tbl_proyek_material.status = 2 AND master_proyek.rab = 1";
        return $this->db->query($q)->result();
    }

    public function get_rab_upah(){
        $q = "SELECT tbl_proyek_upah.*, tbl_proyek_upah.id as id_upah FROM tbl_proyek_upah JOIN master_proyek ON tbl_proyek_upah.proyek_id = master_proyek.id WHERE tbl_proyek_upah.status = 2 AND master_proyek.rab = 1";
        return $this->db->query($q)->result();
    }

    public function get_rab_lain(){
        $q = "SELECT tbl_proyek_lainnya.*, tbl_proyek_lainnya.id as id_lain FROM tbl_proyek_lainnya JOIN master_proyek ON tbl_proyek_lainnya.proyek_id = master_proyek.id WHERE tbl_proyek_lainnya.status = 2 AND master_proyek.rab = 1";
        return $this->db->query($q)->result();
    }

    public function get_RABmaterial_id($id){
        $q = "SELECT 
            tbl_proyek_material.*,
            master_material.nama_material,
            master_produk_kategori.kategori_produk,
            master_produk_unit.nama_satuan,

            master_proyek.nama_proyek,
            tbl_tipe.*,
            tbl_cluster.nama_cluster,
            tbl_perumahan.*

            FROM 
            tbl_proyek_material,
            master_material,
            master_produk_kategori,
            master_produk_unit,
            master_proyek,
            tbl_tipe,
            tbl_cluster,
            tbl_perumahan

            WHERE
            tbl_proyek_material.material_id = master_material.id AND
            master_material.kategori_id = master_produk_kategori.id AND
            master_material.unit_id = master_produk_unit.id AND

            tbl_proyek_material.proyek_id = master_proyek.id AND
            tbl_proyek_material.tipe_id = tbl_tipe.id_tipe AND
            tbl_tipe.id_cluster = tbl_cluster.id_cluster AND
            tbl_tipe.id_perum = tbl_perumahan.id_perumahan AND
            
            tbl_proyek_material.id = $id
        ";
        return $this->db->query($q)->row();
    }

    public function getKodeRABMaterial($id){
        $q = "SELECT * FROM
            tbl_proyek_material JOIN
            title_kode ON tbl_proyek_material.title_kode = title_kode.id_title
            JOIN sub_kode ON title_kode.id_sub = sub_kode.id_sub 
            JOIN kode ON sub_kode.id_kode = kode.id_kode
            WHERE tbl_proyek_material.id = $id
        ";
        $data = $this->db->query($q)->row();
        return $data;
    }

    public function get_RABUpah_id($id){
        $q = "SELECT
            tbl_proyek_upah.*,
            master_proyek.nama_proyek,
            tbl_tipe.*,
            tbl_cluster.nama_cluster,
            tbl_perumahan.*

            FROM
            tbl_proyek_upah,
            master_proyek,
            tbl_tipe,
            tbl_cluster,
            tbl_perumahan

            WHERE
            tbl_proyek_upah.id = $id AND
            tbl_proyek_upah.proyek_id = master_proyek.id AND
            tbl_proyek_upah.tipe_id = tbl_tipe.id_tipe AND
            tbl_tipe.id_cluster = tbl_cluster.id_cluster AND
            tbl_tipe.id_perum = tbl_perumahan.id_perumahan 
        ";

        return $this->db->query($q)->row();
    }

    public function getKodeRABUpah($id){
        $q = "SELECT * FROM
            tbl_proyek_upah JOIN
            title_kode ON tbl_proyek_upah.title_kode = title_kode.id_title
            JOIN sub_kode ON title_kode.id_sub = sub_kode.id_sub 
            JOIN kode ON sub_kode.id_kode = kode.id_kode
            WHERE tbl_proyek_upah.id = $id
        ";
        $data = $this->db->query($q)->row();
        return $data;
    }

    public function get_RABLain_id($id){
        $q = "SELECT
            tbl_proyek_lainnya.*,
            master_proyek.nama_proyek,
            tbl_tipe.*,
            tbl_cluster.nama_cluster,
            tbl_perumahan.*

            FROM
            tbl_proyek_lainnya,
            master_proyek,
            tbl_tipe,
            tbl_cluster,
            tbl_perumahan

            WHERE
            tbl_proyek_lainnya.id = $id AND
            tbl_proyek_lainnya.proyek_id = master_proyek.id AND
            tbl_proyek_lainnya.tipe_id = tbl_tipe.id_tipe AND
            tbl_tipe.id_cluster = tbl_cluster.id_cluster AND
            tbl_tipe.id_perum = tbl_perumahan.id_perumahan 
        ";

        return $this->db->query($q)->row();
    }

    public function getKodeRABLain($id){
        $q = "SELECT * FROM
            tbl_proyek_lainnya JOIN
            title_kode ON tbl_proyek_lainnya.title_kode = title_kode.id_title
            JOIN sub_kode ON title_kode.id_sub = sub_kode.id_sub 
            JOIN kode ON sub_kode.id_kode = kode.id_kode
            WHERE tbl_proyek_lainnya.id = $id
        ";
        $data = $this->db->query($q)->row();
        return $data;
    }

    public function get_confirm_insidentil(){
        $id_perum = $this->session->userdata('id_perumahan');
        $this->db->select('tbl_proyek_insidentil.*, master_proyek.nama_proyek, cicil_insidentil.*, cicil_insidentil.jml_pengajuan as jml_cicil')
        ->from('tbl_proyek_insidentil')
        ->join('master_proyek', 'tbl_proyek_insidentil.proyek_id = master_proyek.id')
        ->join('cicil_insidentil', 'tbl_proyek_insidentil.id = cicil_insidentil.id_insidentil')
        ->where('tbl_proyek_insidentil.id_perumahan', $id_perum)
        ->where('cicil_insidentil.status', 1);
        return $this->db->get();
    }

    public function get_insidentil(){    
        return $this->db->get_where('tbl_proyek_insidentil',['status' => 2])->result();
    }

    public function getInsidentilID($id){
        $q = "SELECT 
            tbl_proyek_insidentil.*,
            tbl_proyek_insidentil.id as insidentil_id,
            master_proyek.nama_proyek,
            master_proyek_kavling.*,
            tbl_kavling.*,
            tbl_perumahan.*

            FROM 
            tbl_proyek_insidentil,
            master_proyek,
            master_proyek_kavling,
            tbl_kavling,
            tbl_perumahan

            WHERE
            tbl_proyek_insidentil.id = $id AND
            tbl_proyek_insidentil.proyek_id = master_proyek.id AND
            tbl_proyek_insidentil.proyek_id = master_proyek_kavling.proyek_id AND
            master_proyek_kavling.kavling_id = tbl_kavling.id_kavling AND
            tbl_kavling.id_perum = tbl_perumahan.id_perumahan
        ";

        return $this->db->query($q)->row();
    }

    public function getKodeInsidentil($id){
        $q = "SELECT * FROM
            tbl_proyek_insidentil JOIN
            title_kode ON tbl_proyek_insidentil.title_kode = title_kode.id_title
            JOIN sub_kode ON title_kode.id_sub = sub_kode.id_sub 
            JOIN kode ON sub_kode.id_kode = kode.id_kode
            WHERE tbl_proyek_insidentil.id = $id
        ";
        $data = $this->db->query($q)->row();
        return $data;
    }


    public function get_confirm_material(){
        $id_perumahan = $this->session->userdata('id_perumahan');
        $this->db->select('
            pengajuan_material.id_perumahan,
            master_logistik.time,
            cicil_material.*
        ')
        ->from('pengajuan_material')
        ->join('master_logistik','pengajuan_material.time = master_logistik.time')
        ->join('cicil_material','pengajuan_material.id_pengajuan = cicil_material.id_pengajuan')
        ->where('cicil_material.status', 1)
        ->where('pengajuan_material.id_perumahan', $id_perumahan);
        
        return $this->db->get()->num_rows();
    }

    public function get_Pengajuan_Material(){
        $id_perumahan = $this->session->userdata('id_perumahan');
        $this->db->select('
            pengajuan_material.id_perumahan,
            cicil_material.*
        ')
        ->from('pengajuan_material')
        ->join('cicil_material','pengajuan_material.id_pengajuan = cicil_material.id_pengajuan')
        ->where('cicil_material.status', 1)
        ->where('pengajuan_material.id_perumahan', $id_perumahan);
        
        return $this->db->get()->result();
    }

    public function getPengajuanMaterialID($id){
        $q = "SELECT
            master_logistik.*,
            master_logistik.id as id_logistik,
            master_logistik_detail.*,
            master_logistik_detail.status as status_real,
            tbl_proyek_material.*,
            master_material.nama_material,
            master_produk_kategori.kategori_produk,
            master_produk_unit.nama_satuan,
            tbl_tipe.*,
            tbl_cluster.nama_cluster,
            tbl_perumahan.*,
            master_proyek.nama_proyek,
            master_supplier.*,
            master_supplier.alamat as alamat_supplier

            FROM
            master_logistik,
            master_logistik_detail,
            tbl_proyek_material,
            master_material,
            master_produk_kategori,
            master_produk_unit,
            tbl_tipe,
            tbl_cluster,
            tbl_perumahan,
            master_proyek,
            master_supplier

            WHERE
            master_logistik.id = master_logistik_detail.logistik_id AND
            master_logistik.proyek_material_id = tbl_proyek_material.id AND
            tbl_proyek_material.material_id = master_material.id AND
            master_material.kategori_id = master_produk_kategori.id AND
            master_material.unit_id = master_produk_unit.id AND
            tbl_proyek_material.tipe_id = tbl_tipe.id_tipe AND
            tbl_tipe.id_cluster = tbl_cluster.id_cluster AND
            tbl_tipe.id_perum = tbl_perumahan.id_perumahan AND
            master_logistik.id = $id AND
            tbl_proyek_material.proyek_id = master_proyek.id AND
            master_supplier.id_supplier = master_logistik_detail.supplier_id
        ";

        return $this->db->query($q)->row();
    }

    public function getKodePengajuanMaterial($id){
        $q = "SELECT * FROM
            master_logistik_detail JOIN
            title_kode ON master_logistik_detail.title_kode = title_kode.id_title
            JOIN sub_kode ON title_kode.id_sub = sub_kode.id_sub 
            JOIN kode ON sub_kode.id_kode = kode.id_kode
            WHERE master_logistik_detail.logistik_id = $id
        ";
        $data = $this->db->query($q)->row();
        return $data;
    }



    //21-9-2022
    public function get_confirm_angsuran_bank(){
        return $this->db->get_where('angsuran_bank',['status' => 2])->num_rows();
    }
    public function get_confirm_piutang_bank(){
        return $this->db->get_where('piutang_bank',['status' => 2])->num_rows();
    }


    //22-9-2022
    public function get_proyek_dashboard(){
        $id_perumahan = $this->session->userdata('id_perumahan');
        $q = "SELECT 
            master_proyek.id AS id_proyek,
            master_proyek.nama_proyek,
            master_proyek.tgl_pengajuan
            FROM master_proyek JOIN
            master_proyek_kavling ON master_proyek.id = master_proyek_kavling.proyek_id JOIN
            tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE
            tbl_kavling.id_perum = $id_perumahan AND
            master_proyek.end = 0
            GROUP BY master_proyek.id
        ";
        return $this->db->query($q)->result();
    }

    public function get_kavling_progres_proyek_dashboard($id_proyek){
        $q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $id_proyek";
        return $this->db->query($q)->result();
    }

    public function get_progres_kavling($id_kavling){
        // $q = $this->db->order_by('id_progres','DESC')->get_where('progres_pembangunan',['kavling_id' => $id_kavling])->row()->progres;
        $q = "SELECT * FROM progres_pembangunan WHERE progres_pembangunan.kavling_id = $id_kavling AND progres_pembangunan.status = 4 ORDER BY progres_pembangunan.id_progres DESC";
        return $this->db->query($q)->row();
    }

    public function get_confirm_transaksi_batal($id = null){
        $this->db->select('pembatalan_transaksi.*,
            cicil_pembatalan.*,
            cicil_pembatalan.status as status_cicil,
            tbl_marketing.*,
        ')
        ->from('pembatalan_transaksi')
        ->join('cicil_pembatalan','pembatalan_transaksi.id_pembatalan = cicil_pembatalan.id_pembatalan')
        ->join('tbl_marketing','pembatalan_transaksi.id_user = tbl_marketing.id_marketing')
        ->where('cicil_pembatalan.status', 1);
        if($id){
            $this->db->where('cicil_pembatalan.id_cicil', $id);
        }
        return $this->db->get();
    }
    public function get_transaksi_batal(){
        return $this->db->get_where('pembatalan_transaksi',['status' => 3])->result();
    }
    public function getPebatalanTransaksi($id){
        $q = "SELECT 
        tbl_marketing.*,
        tbl_marketing.status as status_konsumen,

        pembatalan_transaksi.*

        FROM 
        tbl_marketing,
        pembatalan_transaksi

        WHERE
        pembatalan_transaksi.id_pembatalan = $id
        ";
        return $this->db->query($q)->row();
    }
    public function getKodePembatalan($id){
        $q = "SELECT * FROM
        pembatalan_transaksi JOIN
        title_kode ON pembatalan_transaksi.title_kode = title_kode.id_title
        JOIN sub_kode ON title_kode.id_sub = sub_kode.id_sub 
        JOIN kode ON sub_kode.id_kode = kode.id_kode
        WHERE pembatalan_transaksi.id_pembatalan = $id";
        return $this->db->query($q)->row();
    }

    public function get_tj($db){
       return $this->db->get_where($db,['status' => 1])->num_rows();
    }

    public function get_data_tj($db){
        return $this->db->get_where($db,['status' => 1])->result();
    }


    public function getBankTJDataID($id){
        $q = "SELECT * FROM tbl_transaksi_bank JOIN tbl_marketing ON tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing WHERE tbl_transaksi_bank.id_transaksi_bank = $id
        ";
        return $this->db->query($q)->row();
    }

    public function getKodeBankTJ($id){
        $q = "SELECT * FROM
        tbl_transaksi_bank JOIN
        title_kode ON tbl_transaksi_bank.title_kode = title_kode.id_title
        JOIN sub_kode ON title_kode.id_sub = sub_kode.id_sub 
        JOIN kode ON sub_kode.id_kode = kode.id_kode
        WHERE tbl_transaksi_bank.id_transaksi_bank = $id";
        return $this->db->query($q)->row();
    }

    public function getIhhouseTJDataID($id){
        $q = "SELECT * FROM tbl_transaksi_inhouse JOIN tbl_marketing ON tbl_transaksi_inhouse.id_konsumen = tbl_marketing.id_marketing WHERE tbl_transaksi_inhouse.id_inhouse = $id
        ";
        return $this->db->query($q)->row();
    }

    public function getKodeInhouseTJ($id){
        $q = "SELECT * FROM
        tbl_transaksi_inhouse JOIN
        title_kode ON tbl_transaksi_inhouse.title_kode = title_kode.id_title
        JOIN sub_kode ON title_kode.id_sub = sub_kode.id_sub 
        JOIN kode ON sub_kode.id_kode = kode.id_kode
        WHERE tbl_transaksi_inhouse.id_inhouse = $id";
        return $this->db->query($q)->row();
    }


    public function get_Pengajuan_material_detail($id){
        $this->db->select('
            cicil_material.*,
            cicil_material.jml_pengajuan as pengajuan_jml,
            pengajuan_material.*,
            master_proyek.nama_proyek,
            master_supplier.*,
            tbl_perumahan.nama_perumahan,
            tbl_tipe.tipe as nama_tipe,
            tbl_cluster.nama_cluster
        ')
        ->from('cicil_material')
        ->join('pengajuan_material','cicil_material.id_pengajuan = pengajuan_material.id_pengajuan')
        ->join('master_proyek','pengajuan_material.id_proyek = master_proyek.id')
        ->join('master_supplier','pengajuan_material.supplier = master_supplier.id_supplier')
        ->join('tbl_perumahan','pengajuan_material.id_perumahan = tbl_perumahan.id_perumahan')
        ->join('tbl_tipe','pengajuan_material.id_tipe = tbl_tipe.id_tipe')
        ->join('tbl_cluster','tbl_tipe.id_cluster = tbl_cluster.id_cluster')
        ->where('cicil_material.id_cicil', $id);
        return $this->db->get()->row();
    }

    public function get_kas($id = null){
        $id_perum = $this->session->userdata('id_perumahan');
        $this->db->select('cicil_kas.*, cicil_kas.jumlah as jml_cicil, cicil_kas.status as status_cicil, kas_operasional.*')
        ->from('cicil_kas')
        ->join('kas_operasional','cicil_kas.id_kas = kas_operasional.id_kas')
        ->where('cicil_kas.status', 1)
        ->where('kas_operasional.id_perumahan', $id_perum);
        if($id){
            $this->db->where('cicil_kas.id_cicil', $id);
        }

        return $this->db->get();
    }

    public function getPembebasanLahan($id = null){
        $id_perum = $this->session->userdata('id_perumahan');
        $this->db->select('pembebasan_lahan.*, tbl_perumahan.nama_perumahan')
        ->from('pembebasan_lahan')
        ->join('tbl_perumahan','pembebasan_lahan.id_perumahan = tbl_perumahan.id_perumahan')
        ->where('tbl_perumahan.id_perumahan', $id_perum);
        if($id){
            $this->db->where('pembebasan_lahan.id_pembebasan', $id);
        }
        return $this->db->get();
    }













    public function count_denda_pembayaran_konsumen($type , $id){
        if($type == 'bank_tjl'){
            $data = $this->db->get_where('tanda_jadi_lokasi',['id_tjl' => $id])->row();
            $today = date('Y-m-d');
            if($data->jatuh_tempo < $today){
               
                $q = "SELECT SUM(jumlah) as terbayar FROM bank_cicil_tjl WHERE id_pembayaran = $id";
                    $jumlah_lunas = $this->db->query($q)->row()->terbayar;

                    $sisa = $data->cicilan_angsuran - $jumlah_lunas;


                $now = date_create(date('Y-m-d'));
                $tenggat = date_create($data->jatuh_tempo);
                $telat = date_diff($tenggat, $now);
                $hari = $telat->format("%a");
                $denda = 0.5 / 100 * $sisa * $hari;
            } else {
                // tidak telat
                $denda = 0;
            }
            $this->db->set('denda', $denda)->where('id_tjl', $id)->update('tanda_jadi_lokasi');
        } else if($type == 'bank_um'){
            $data = $this->db->get_where('uang_muka',['id_um' => $id])->row();
            $today = date('Y-m-d');
            if($data->jatuh_tempo < $today){
                // jika telat
                
                $q = "SELECT SUM(jumlah) as terbayar FROM bank_cicil_um WHERE id_pembayaran = $id";
                    $jumlah_lunas = $this->db->query($q)->row()->terbayar;

                    $sisa = $data->cicilan_angsuran - $jumlah_lunas;

                $now = date_create(date('Y-m-d'));
                $tenggat = date_create($data->jatuh_tempo);
                $telat = date_diff($tenggat, $now);
                $hari = $telat->format("%a");
                $denda = 0.5 / 100 * $sisa * $hari;
            } else {
                // tidak telat
                $denda = 0;
            }
            $this->db->set('denda', $denda)->where('id_um', $id)->update('uang_muka');
        } 
        else if($type == 'bank_kt'){
            $data = $this->db->get_where('kelebihan_tanah',['id_kt' => $id])->row();
            $today = date('Y-m-d');
            if($data->jatuh_tempo < $today){
                // jika telat
                
                $q = "SELECT SUM(jumlah) as terbayar FROM bank_cicil_kt WHERE id_pembayaran = $id";
                    $jumlah_lunas = $this->db->query($q)->row()->terbayar;

                    $sisa = $data->cicilan_angsuran - $jumlah_lunas;

                $now = date_create(date('Y-m-d'));
                $tenggat = date_create($data->jatuh_tempo);
                $telat = date_diff($tenggat, $now);
                $hari = $telat->format("%a");
                $denda = 0.5 / 100 * $sisa * $hari;
            } else {
                // tidak telat
                $denda = 0;
            }
            $this->db->set('denda', $denda)->where('id_kt', $id)->update('kelebihan_tanah');
        }
        else if($type == 'bank_pak'){
            $data = $this->db->get_where('pak',['id_pak' => $id])->row();
            $today = date('Y-m-d');
            if($data->jatuh_tempo < $today){
                // jika telat
                
                $q = "SELECT SUM(jumlah) as terbayar FROM bank_cicil_pak WHERE id_pembayaran = $id";
                    $jumlah_lunas = $this->db->query($q)->row()->terbayar;

                    $sisa = $data->cicilan_angsuran - $jumlah_lunas;

                $now = date_create(date('Y-m-d'));
                $tenggat = date_create($data->jatuh_tempo);
                $telat = date_diff($tenggat, $now);
                $hari = $telat->format("%a");
                $denda = 0.5 / 100 * $sisa * $hari;
            } else {
                // tidak telat
                $denda = 0;
            }
            $this->db->set('denda', $denda)->where('id_pak', $id)->update('pak');
        }
        else if($type == 'bank_lain'){
            $data = $this->db->get_where('lain_lain',['id_lain' => $id])->row();
            $today = date('Y-m-d');
            if($data->jatuh_tempo < $today){
                // jika telat
                
                $q = "SELECT SUM(jumlah) as terbayar FROM bank_cicil_lain WHERE id_pembayaran = $id";
                    $jumlah_lunas = $this->db->query($q)->row()->terbayar;

                    $sisa = $data->cicilan_angsuran - $jumlah_lunas;

                $now = date_create(date('Y-m-d'));
                $tenggat = date_create($data->jatuh_tempo);
                $telat = date_diff($tenggat, $now);
                $hari = $telat->format("%a");
                $denda = 0.5 / 100 * $sisa * $hari;
            } else {
                // tidak telat
                $denda = 0;
            }
            $this->db->set('denda', $denda)->where('id_lain', $id)->update('lain_lain');
        }
        else if($type == 'bank_realisasi'){
            $data = $this->db->get_where('angsuran_bank',['id_angsur' => $id])->row();
            $today = date('Y-m-d');
            if($data->jatuh_tempo < $today){
                // jika telat
                
                $q = "SELECT SUM(jumlah) as terbayar FROM bank_cicil_rb WHERE id_pembayaran = $id";
                    $jumlah_lunas = $this->db->query($q)->row()->terbayar;

                    $sisa = $data->cicilan_angsuran - $jumlah_lunas;

                $now = date_create(date('Y-m-d'));
                $tenggat = date_create($data->jatuh_tempo);
                $telat = date_diff($tenggat, $now);
                $hari = $telat->format("%a");
                $denda = 0.5 / 100 * $sisa * $hari;
            } else {
                // tidak telat
                $denda = 0;
            }
            $this->db->set('denda', $denda)->where('id_angsur', $id)->update('angsuran_bank');
        }
        else if($type == 'bank_piutang'){
            $data = $this->db->get_where('piutang_bank',['id_piutang' => $id])->row();
            $today = date('Y-m-d');
            if($data->jatuh_tempo < $today){
                // jika telat
                
                $q = "SELECT SUM(jumlah) as terbayar FROM bank_cicil_pb WHERE id_pembayaran = $id";
                    $jumlah_lunas = $this->db->query($q)->row()->terbayar;

                    $sisa = $data->cicilan_angsuran - $jumlah_lunas;

                $now = date_create(date('Y-m-d'));
                $tenggat = date_create($data->jatuh_tempo);
                $telat = date_diff($tenggat, $now);
                $hari = $telat->format("%a");
                $denda = 0.5 / 100 * $sisa * $hari;
            } else {
                // tidak telat
                $denda = 0;
            }
            $this->db->set('denda', $denda)->where('id_piutang', $id)->update('piutang_bank');
        }
        else if($type == 'inhouse_hk'){
            $data = $this->db->get_where('harga_kesepakatan_inhouse',['id_kesepakatan' => $id])->row();
            $today = date('Y-m-d');
            if($data->jatuh_tempo < $today){
                // jika telat
                
                $q = "SELECT SUM(jumlah) as terbayar FROM inhouse_cicil_hk WHERE id_pembayaran = $id";
                    $jumlah_lunas = $this->db->query($q)->row()->terbayar;

                    $sisa = $data->cicilan_angsuran - $jumlah_lunas;

                $now = date_create(date('Y-m-d'));
                $tenggat = date_create($data->jatuh_tempo);
                $telat = date_diff($tenggat, $now);
                $hari = $telat->format("%a");
                $denda = 0.5 / 100 * $sisa * $hari;
            } else {
                // tidak telat
                $denda = 0;
            }
            $this->db->set('denda', $denda)->where('id_kesepakatan', $id)->update('harga_kesepakatan_inhouse');
        }
        else if($type == 'inhouse_tjl'){
            $data = $this->db->get_where('tanda_jadi_lokasi_inhouse',['id_tjl' => $id])->row();
            $today = date('Y-m-d');
            if($data->jatuh_tempo < $today){
                // jika telat
                
                $q = "SELECT SUM(jumlah) as terbayar FROM inhouse_cicil_tjl WHERE id_pembayaran = $id";
                    $jumlah_lunas = $this->db->query($q)->row()->terbayar;

                    $sisa = $data->cicilan_angsuran - $jumlah_lunas;

                $now = date_create(date('Y-m-d'));
                $tenggat = date_create($data->jatuh_tempo);
                $telat = date_diff($tenggat, $now);
                $hari = $telat->format("%a");
                $denda = 0.5 / 100 * $sisa * $hari;
            } else {
                // tidak telat
                $denda = 0;
            }
            $this->db->set('denda', $denda)->where('id_tjl', $id)->update('tanda_jadi_lokasi_inhouse');
        }
        else if($type == 'inhouse_um'){
            $data = $this->db->get_where('uang_muka_inhouse',['id_um' => $id])->row();
            $today = date('Y-m-d');
            if($data->jatuh_tempo < $today){
                // jika telat
                
                $q = "SELECT SUM(jumlah) as terbayar FROM inhouse_cicil_um WHERE id_pembayaran = $id";
                    $jumlah_lunas = $this->db->query($q)->row()->terbayar;

                    $sisa = $data->cicilan_angsuran - $jumlah_lunas;

                $now = date_create(date('Y-m-d'));
                $tenggat = date_create($data->jatuh_tempo);
                $telat = date_diff($tenggat, $now);
                $hari = $telat->format("%a");
                $denda = 0.5 / 100 * $sisa * $hari;
            } else {
                // tidak telat
                $denda = 0;
            }
            $this->db->set('denda', $denda)->where('id_um', $id)->update('uang_muka_inhouse');
        }
        else if($type == 'inhouse_kt'){
            $data = $this->db->get_where('kelebihan_tanah_inhouse',['id_kt' => $id])->row();
            $today = date('Y-m-d');
            if($data->jatuh_tempo < $today){
                // jika telat
                
                $q = "SELECT SUM(jumlah) as terbayar FROM inhouse_cicil_kt WHERE id_pembayaran = $id";
                    $jumlah_lunas = $this->db->query($q)->row()->terbayar;

                    $sisa = $data->cicilan_angsuran - $jumlah_lunas;

                $now = date_create(date('Y-m-d'));
                $tenggat = date_create($data->jatuh_tempo);
                $telat = date_diff($tenggat, $now);
                $hari = $telat->format("%a");
                $denda = 0.5 / 100 * $sisa * $hari;
            } else {
                // tidak telat
                $denda = 0;
            }
            $this->db->set('denda', $denda)->where('id_kt', $id)->update('kelebihan_tanah_inhouse');
        }
       

    }

    public function count_terbayar($type, $id){
        if($type == 'bank_tjl'){
            $q = "SELECT SUM(jumlah) as terbayar FROM bank_cicil_tjl WHERE id_pembayaran = $id";
        } 
        else if($type == 'bank_um'){
            $q = "SELECT SUM(jumlah) as terbayar FROM bank_cicil_um WHERE id_pembayaran = $id";
        } 
        else if($type == 'bank_kt'){
            $q = "SELECT SUM(jumlah) as terbayar FROM bank_cicil_kt WHERE id_pembayaran = $id";
        }
        else if($type == 'bank_pak'){
            $q = "SELECT SUM(jumlah) as terbayar FROM bank_cicil_pak WHERE id_pembayaran = $id";
        }
        else if($type == 'bank_lain'){
            $q = "SELECT SUM(jumlah) as terbayar FROM bank_cicil_lain WHERE id_pembayaran = $id";
        }
        else if($type == 'bank_realisasi'){
            $q = "SELECT SUM(jumlah) as terbayar FROM bank_cicil_rb WHERE id_pembayaran = $id";
        }
        else if($type == 'bank_piutang'){
            $q = "SELECT SUM(jumlah) as terbayar FROM bank_cicil_pb WHERE id_pembayaran = $id";
        }
        else if($type == 'inhouse_hk'){
            $q = "SELECT SUM(jumlah) as terbayar FROM inhouse_cicil_hk WHERE id_pembayaran = $id";
        }
        else if($type == 'inhouse_tjl'){
            $q = "SELECT SUM(jumlah) as terbayar FROM inhouse_cicil_tjl WHERE id_pembayaran = $id";
        }
        else if($type == 'inhouse_um'){
            $q = "SELECT SUM(jumlah) as terbayar FROM inhouse_cicil_um WHERE id_pembayaran = $id";
        }
        else if($type == 'inhouse_kt'){
            $q = "SELECT SUM(jumlah) as terbayar FROM inhouse_cicil_kt WHERE id_pembayaran = $id";
        }
        else if($type == 'bank_tj'){
            $q = "SELECT SUM(jumlah) as terbayar FROM bank_cicil_tj WHERE id_pembayaran = $id";
        }
        else if($type == 'inhouse_tj'){
            $q = "SELECT SUM(jumlah) as terbayar FROM inhouse_cicil_tj WHERE id_pembayaran = $id";
        }

        return $this->db->query($q)->row()->terbayar;
    }

    public function cek_pembayaran_konsumen($type, $id){
        if($type == 'bank_tjl'){
            $q = "SELECT SUM(jumlah) as total_cicil FROM bank_cicil_tjl WHERE id_pembayaran = $id";
            $cicil = $this->db->query($q)->row()->total_cicil;
            $data = $this->db->get_where('tanda_jadi_lokasi',['id_tjl' => $id])->row();

            if($cicil >= $data->cicilan_angsuran){
                $this->db->set('status', 2)->where('id_tjl', $id)->update('tanda_jadi_lokasi');
            }
        }
        else if($type == 'bank_um'){
            $q = "SELECT SUM(jumlah) as total_cicil FROM bank_cicil_um WHERE id_pembayaran = $id";
            $cicil = $this->db->query($q)->row()->total_cicil;
            $data = $this->db->get_where('uang_muka',['id_um' => $id])->row();

            if($cicil >= $data->cicilan_angsuran){
                $this->db->set('status', 2)->where('id_um', $id)->update('uang_muka');
            }
        }
        else if($type == 'bank_kt'){
            $q = "SELECT SUM(jumlah) as total_cicil FROM bank_cicil_kt WHERE id_pembayaran = $id";
            $cicil = $this->db->query($q)->row()->total_cicil;
            $data = $this->db->get_where('kelebihan_tanah',['id_kt' => $id])->row();

            if($cicil >= $data->cicilan_angsuran){
                $this->db->set('status', 2)->where('id_kt', $id)->update('kelebihan_tanah');
            }
        }
        else if($type == 'bank_pak'){
            $q = "SELECT SUM(jumlah) as total_cicil FROM bank_cicil_pak WHERE id_pembayaran = $id";
            $cicil = $this->db->query($q)->row()->total_cicil;
            $data = $this->db->get_where('pak',['id_pak' => $id])->row();

            if($cicil >= $data->cicilan_angsuran){
                $this->db->set('status', 2)->where('id_pak', $id)->update('pak');
            }
        }
        else if($type == 'bank_lain'){
            $q = "SELECT SUM(jumlah) as total_cicil FROM bank_cicil_lain WHERE id_pembayaran = $id";
            $cicil = $this->db->query($q)->row()->total_cicil;
            $data = $this->db->get_where('lain_lain',['id_lain' => $id])->row();

            if($cicil >= $data->cicilan_angsuran){
                $this->db->set('status', 2)->where('id_lain', $id)->update('lain_lain');
            }
        }
        else if($type == 'bank_realisasi'){
            $q = "SELECT SUM(jumlah) as total_cicil FROM bank_cicil_rb WHERE id_pembayaran = $id";
            $cicil = $this->db->query($q)->row()->total_cicil;
            $data = $this->db->get_where('angsuran_bank',['id_angsur' => $id])->row();

            if($cicil >= $data->cicilan_angsuran){
                $this->db->set('status', 2)->where('id_angsur', $id)->update('angsuran_bank');
            }
        }
        else if($type == 'bank_piutang'){
            $q = "SELECT SUM(jumlah) as total_cicil FROM bank_cicil_pb WHERE id_pembayaran = $id";
            $cicil = $this->db->query($q)->row()->total_cicil;
            $data = $this->db->get_where('piutang_bank',['id_piutang' => $id])->row();

            if($cicil >= $data->cicilan_angsuran){
                $this->db->set('status', 2)->where('id_piutang', $id)->update('piutang_bank');
            }
        }
        else if($type == 'inhouse_hk'){
            $q = "SELECT SUM(jumlah) as total_cicil FROM inhouse_cicil_hk WHERE id_pembayaran = $id";
            $cicil = $this->db->query($q)->row()->total_cicil;
            $data = $this->db->get_where('harga_kesepakatan_inhouse',['id_kesepakatan' => $id])->row();

            if($cicil >= $data->cicilan_angsuran){
                $this->db->set('status', 2)->where('id_kesepakatan', $id)->update('harga_kesepakatan_inhouse');
            }
        }
        else if($type == 'inhouse_tjl'){
            $q = "SELECT SUM(jumlah) as total_cicil FROM inhouse_cicil_tjl WHERE id_pembayaran = $id";
            $cicil = $this->db->query($q)->row()->total_cicil;
            $data = $this->db->get_where('tanda_jadi_lokasi_inhouse',['id_tjl' => $id])->row();
            if($cicil >= $data->cicilan_angsuran){
                $this->db->set('status', 2)->where('id_tjl', $id)->update('tanda_jadi_lokasi_inhouse');
            }
        }
        else if($type == 'inhouse_um'){
            $q = "SELECT SUM(jumlah) as total_cicil FROM inhouse_cicil_um WHERE id_pembayaran = $id";
            $cicil = $this->db->query($q)->row()->total_cicil;
            $data = $this->db->get_where('uang_muka_inhouse',['id_um' => $id])->row();
            if($cicil >= $data->cicilan_angsuran){
                $this->db->set('status', 2)->where('id_um', $id)->update('uang_muka_inhouse');
            }
        }
        else if($type == 'inhouse_kt'){
            $q = "SELECT SUM(jumlah) as total_cicil FROM inhouse_cicil_kt WHERE id_pembayaran = $id";
            $cicil = $this->db->query($q)->row()->total_cicil;
            $data = $this->db->get_where('kelebihan_tanah_inhouse',['id_kt' => $id])->row();
            if($cicil >= $data->cicilan_angsuran){
                $this->db->set('status', 2)->where('id_kt', $id)->update('kelebihan_tanah_inhouse');
            }
        }
    }



    public function getClusterByPerum(){
        $id_perum = $this->session->userdata('id_perumahan');
        return $this->db->get_where('tbl_cluster',['id_perum' => $id_perum])->result();
    }

    public function getConfirmPembayaranKonsumen($tipe){
        if($tipe == 'bank_tjl'){
            $this->db->select('bank_cicil_tjl.*')
            ->from('bank_cicil_tjl')
            ->join('tanda_jadi_lokasi','bank_cicil_tjl.id_pembayaran = tanda_jadi_lokasi.id_tjl')
            ->where('bank_cicil_tjl.status', 2);
        }
        else if($tipe == 'bank_um'){
            $this->db->select('bank_cicil_um.*')
            ->from('bank_cicil_um')
            ->join('uang_muka','bank_cicil_um.id_pembayaran = uang_muka.id_um')
            ->where('bank_cicil_um.status', 2);
        }
        else if($tipe == 'bank_kt'){
            $this->db->select('bank_cicil_kt.*')
            ->from('bank_cicil_kt')
            ->join('kelebihan_tanah','bank_cicil_kt.id_pembayaran = kelebihan_tanah.id_kt')
            ->where('bank_cicil_kt.status', 2);
        }
        else if($tipe == 'bank_pak'){
            $this->db->select('bank_cicil_pak.*')
            ->from('bank_cicil_pak')
            ->join('pak','bank_cicil_pak.id_pembayaran = pak.id_pak')
            ->where('bank_cicil_pak.status', 2);
        }
        else if($tipe == 'bank_lain'){
            $this->db->select('bank_cicil_lain.*')
            ->from('bank_cicil_lain')
            ->join('lain_lain','bank_cicil_lain.id_pembayaran = lain_lain.id_lain')
            ->where('bank_cicil_lain.status', 2);
        }
        else if($tipe == 'bank_rb'){
            $this->db->select('bank_cicil_rb.*')
            ->from('bank_cicil_rb')
            ->join('angsuran_bank','bank_cicil_rb.id_pembayaran = angsuran_bank.id_angsur')
            ->where('bank_cicil_rb.status', 2);
        }
        else if($tipe == 'bank_pb'){
            $this->db->select('bank_cicil_pb.*')
            ->from('bank_cicil_pb')
            ->join('piutang_bank','bank_cicil_pb.id_pembayaran = piutang_bank.id_piutang')
            ->where('bank_cicil_pb.status', 2);
        }
        else if($tipe == 'bank_tj'){
            $this->db->select('bank_cicil_tj.*')
            ->from('bank_cicil_tj')
            ->join('tbl_transaksi_bank','bank_cicil_tj.id_pembayaran = tbl_transaksi_bank.id_transaksi_bank')
            ->where('bank_cicil_tj.status', 2);
        }
        else if($tipe == 'inhouse_hk'){
            $this->db->select('inhouse_cicil_hk.*')
            ->from('inhouse_cicil_hk')
            ->join('harga_kesepakatan_inhouse','inhouse_cicil_hk.id_pembayaran = harga_kesepakatan_inhouse.id_kesepakatan')
            ->where('inhouse_cicil_hk.status', 2);
        }
        else if($tipe == 'inhouse_tjl'){
            $this->db->select('inhouse_cicil_tjl.*')
            ->from('inhouse_cicil_tjl')
            ->join('tanda_jadi_lokasi_inhouse','inhouse_cicil_tjl.id_pembayaran = tanda_jadi_lokasi_inhouse.id_tjl')
            ->where('inhouse_cicil_tjl.status', 2);
        }
        else if($tipe == 'inhouse_um'){
            $this->db->select('inhouse_cicil_um.*')
            ->from('inhouse_cicil_um')
            ->join('uang_muka_inhouse','inhouse_cicil_um.id_pembayaran = uang_muka_inhouse.id_um')
            ->where('inhouse_cicil_um.status', 2);
        }
        else if($tipe == 'inhouse_kt'){
            $this->db->select('inhouse_cicil_kt.*')
            ->from('inhouse_cicil_kt')
            ->join('kelebihan_tanah_inhouse','inhouse_cicil_kt.id_pembayaran = kelebihan_tanah_inhouse.id_kt')
            ->where('inhouse_cicil_kt.status', 2);
        }
        else if($tipe == 'inhouse_tj'){
            $this->db->select('inhouse_cicil_tj.*')
            ->from('inhouse_cicil_tj')
            ->join('tbl_transaksi_inhouse','inhouse_cicil_tj.id_pembayaran = tbl_transaksi_inhouse.id_inhouse')
            ->where('inhouse_cicil_tj.status', 2);
        }

        return $this->db->get();
    }


    public function getFilterPengajuanMaterial(){
        $id_perum = $this->session->userdata('id_perumahan');
        $this->db->select('master_proyek.nama_proyek, master_proyek.id')
        ->from('master_proyek')
        ->join('pengajuan_material','master_proyek.id = pengajuan_material.id_proyek')
        ->where('master_proyek.rab', 1)
        ->where('master_proyek.end', 0)
        ->where('pengajuan_material.id_perumahan', $id_perum)
        ->group_by('master_proyek.id');

        return $this->db->get();
    }

    public function getFilterUpahKerja(){
        $id_perum = $this->session->userdata('id_perumahan');
        $this->db->select('
            progres_pembangunan.*,
            tbl_kavling.*,
            master_proyek.id as id_proyek,
            master_proyek.nama_proyek
        ')->from('progres_pembangunan')
        ->join('tbl_kavling','progres_pembangunan.kavling_id = tbl_kavling.id_kavling')
        ->join('tbl_proyek_upah','progres_pembangunan.upah_id = tbl_proyek_upah.id')
        ->join('master_proyek','tbl_proyek_upah.proyek_id = master_proyek.id')
        ->where('master_proyek.end', 0)
        ->where('tbl_kavling.id_perum', $id_perum)
        ->group_by('master_proyek.id');
        return $this->db->get();
    }

    public function getFilterMaterialProyek(){
        $id_perum = $this->session->userdata('id_perumahan');
        $this->db->select('
            pengajuan_material.*,
            master_proyek.nama_proyek,
            master_proyek.id as id_pro
        ')
        ->from('pengajuan_material')
        ->join('master_proyek','pengajuan_material.id_proyek = master_proyek.id')
        ->where('pengajuan_material.id_perumahan', $id_perum)
        ->where('master_proyek.end', 0)
        ->group_by('master_proyek.id');
        return $this->db->get();
    }

}

?>