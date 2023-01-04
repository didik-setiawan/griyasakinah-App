<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventaris_model extends CI_Model{
    
    // AWAL PRODUCT
    public function listProduk($id = NULL, $lembaga = NULL) {
        $this->db->select('
            master_produk.*, 
            master_produk_kategori.kategori_produk as nama_kategori, 
            master_produk_unit.nama_satuan as nama_unit, 
            db_user.nama as nama_user, 
            db_group.group_name as nama_group, 
            db_group.id as id_group, 
            store_profile.nama_lembaga as nama_lembaga,
            store_profile.id as id_lembaga,
        ');
        
        $this->db->from('master_produk');
        $this->db->join('master_produk_kategori', 'master_produk.kategori_id = master_produk_kategori.id');
        $this->db->join('master_produk_unit', 'master_produk.unit_id = master_produk_unit.id');
        $this->db->join('db_user', 'master_produk.user_id = db_user.id');
        $this->db->join('db_group', 'db_user.group_id = db_group.id');
        $this->db->join('store_profile', 'db_user.store_id = store_profile.id');

        if($id != NULL) {
            $this->db->where('master_produk.id', $id);
        }
        if($lembaga != NULL) {
            $this->db->where('store_profile.id', $lembaga);
        }
        $this->db->where('master_produk.action', 0);

        $query = $this->db->get();
        return $query;
    }

    public function addProduk($data) {
        $this->db->insert('master_produk', $data);
    }

    public function editProduk($id = NULL, $data = NULL) {
        $this->db->where('id', $id);
        $this->db->update('master_produk', $data);
    }
    
    public function delProduk($id = NULL) {
        $params['action'] = 1;
        $this->db->where('id', $id);
        $this->db->update('master_produk', $params);
    }

    // AKHIR PRODUCT 

    // untuk kategeri produk
    public function listKategori($id = NULL, $lembaga = NULL) {
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
        if($lembaga != NULL) {
            $this->db->where('store_profile.id', $lembaga);
        }
        $this->db->where('master_produk_kategori.action', 0);
        $this->db->order_by('master_produk_kategori.kategori_produk', 'asc');

        $query = $this->db->get();
        return $query;
    }

    public function addKategori($params) {
        $this->db->insert('master_produk_kategori', $params);
    }

    public function editKategori($id = NULL, $data = NULL) {
        $this->db->where('id', $id);
        $this->db->update('master_produk_kategori', $data);
    }
    
    public function delKategori($id = NULL) {
        $params['action'] = 1;
        $this->db->where('id', $id);
        $this->db->update('master_produk_kategori', $params);
    }
    // akhir kategori produk

    // untuk unit produk
    public function listUnit($id = NULL, $lembaga = NULL) {
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
        if($lembaga != NULL) {
            $this->db->where('store_profile.id', $lembaga);
        }
        $this->db->where('master_produk_unit.action', 0);
        $this->db->order_by('master_produk_unit.nama_satuan', 'asc');

        $query = $this->db->get();
        return $query;
    }

    public function addUnit($params) {
        $this->db->insert('master_produk_unit', $params);
    }

    public function editUnit($id = NULL, $data = NULL) {
        $this->db->where('id', $id);
        $this->db->update('master_produk_unit', $data);
    }
    
    public function delUnit($id = NULL) {
        $params['action'] = 1;
        $this->db->where('id', $id);
        $this->db->update('master_produk_unit', $params);
    }
    // akhir unit produk
   

    
	public function getProduk($id = NULL, $kategori = NULL, $unit = NULL){
        if($id != NULL){
            $this->db->where('id', $id);
        }
        if($kategori != NULL){
            $this->db->where('kategori_id', $kategori);
        }
        if($unit != NULL){
            $this->db->where('unit_id', $unit);
        }
        $this->db->from('master_produk');
        $this->db->where('action', 0);
		$query = $this->db->get();
		return $query;
	}
    
	public function getUnit($id = NULL, $nama = NULL){
        if($id != NULL){
            $this->db->where('id', $id);
        }
        if($nama != NULL){
            $this->db->where('nama_satuan', $nama);
        }
        $this->db->from('master_produk_unit');
		$this->db->order_by('nama_satuan', 'asc');
        $this->db->where('action', 0);
		$query = $this->db->get();
		return $query;
	}
    
	public function getKategori($id = NULL, $nama = NULL) {
        if($id != NULL){
            $this->db->where('id', $id);
        }
        if($nama != NULL){
            $this->db->where('kategori_produk', $nama);
        }
        $this->db->from('master_produk_kategori');
		$this->db->order_by('kategori_produk', 'asc');
        $this->db->where('action', 0);
		$query = $this->db->get();
		return $query;
	}

    public function totalStok($produk = NULL, $tipe = NULL, $tgl1 = NULL, $tgl2 = NULL) {
        $this->db->select('SUM(quantity) AS total_stok');
        $this->db->from('stok_in_out');
        if($produk != NULL){
            $this->db->where('id_produk', $produk);
        }
        if($tipe != NULL){
            $this->db->where('stok_tipe', $tipe);
        }
        if($tgl1 != NULL && $tgl2 != NULL){
            $this->db->where('tanggal >=', $tgl1);
            $this->db->where('tanggal <=', $tgl2);
        }
        $this->db->where('status', 1);
        $this->db->where('action', 0);
        $query = $this->db->get();
        return $query;
    }


    // untuk Stok In Out
    public function getStok($id = NULL, $lembaga = NULL) {
        $this->db->select('
            stok_in_out.*, 
            stok_in_out.keterangan as keterangan_stok, 
            master_produk.nama_produk as nama_produk, 
            master_produk.barcode as kode_produk, 
            master_produk_kategori.kategori_produk as nama_kategori, 
            master_produk_unit.nama_satuan as nama_satuan, 
            stok_tipe.nama as nama_tipe, 
            db_user.nama as nama_user,
            db_group.group_name as nama_group, 
            db_group.id as id_group, 
            store_profile.nama_lembaga as nama_lembaga,
            store_profile.id as id_lembaga,

        ');
        $this->db->from('stok_in_out');
        $this->db->join('master_produk', 'stok_in_out.id_produk = master_produk.id');
        $this->db->join('master_produk_kategori', 'master_produk.kategori_id = master_produk_kategori.id');
        $this->db->join('master_produk_unit', 'master_produk.unit_id = master_produk_unit.id');
        $this->db->join('stok_tipe', 'stok_in_out.stok_tipe = stok_tipe.id');
        $this->db->join('db_user', 'stok_in_out.user_id = db_user.id');
        $this->db->join('db_group', 'db_user.group_id = db_group.id');
        $this->db->join('store_profile', 'db_user.store_id = store_profile.id');

        if($id != NULL) {
            $this->db->where('stok_in_out.id', $id);
        }
        if($lembaga != NULL) {
            $this->db->where('store_profile.id', $lembaga);
        }
        $this->db->where('stok_in_out.status', 1);
        $this->db->where('stok_in_out.action', 0);
        $this->db->order_by('stok_in_out.tanggal, stok_in_out.jam', 'desc');

        $query = $this->db->get();
        return $query;
    }

    public function addStok($params) {
        $this->db->insert('stok_in_out', $params);
    }

    public function editStok($id = NULL, $data = NULL) {
        $this->db->where('id', $id);
        $this->db->update('stok_in_out', $data);
    }
    
    public function delStok($id = NULL) {
        $params['action'] = 1;
        $this->db->where('id', $id);
        $this->db->update('stok_in_out', $params);
    }
    // akhir Stok In Out
  
    function topStok($lembaga = NULL){
        $this->db->select('
            SUM(IF(stok_in_out.stok_tipe = 1, stok_in_out.quantity, 0)) AS pemasukan,
            SUM(IF(stok_in_out.stok_tipe = 2, stok_in_out.quantity, 0)) AS pengeluaran,
            (SUM(IF( stok_in_out.stok_tipe = 1, stok_in_out.quantity, 0)) - SUM(IF( stok_in_out.stok_tipe = 2, stok_in_out.quantity, 0))) AS total_stok,
            stok_in_out.id_produk as id_produk, 
            master_produk.nama_produk as nama_produk, 
            master_produk.harga as harga, 
            master_produk.barcode as kode_produk, 
            master_produk_kategori.kategori_produk as nama_kategori, 
            master_produk_unit.nama_satuan as nama_satuan, 

        ');
        $this->db->from('stok_in_out');
        $this->db->join('master_produk', 'stok_in_out.id_produk = master_produk.id');
        $this->db->join('master_produk_kategori', 'master_produk.kategori_id = master_produk_kategori.id');
        $this->db->join('master_produk_unit', 'master_produk.unit_id = master_produk_unit.id');
        $this->db->join('stok_tipe', 'stok_in_out.stok_tipe = stok_tipe.id');
        $this->db->join('db_user', 'stok_in_out.user_id = db_user.id');
        $this->db->join('db_group', 'db_user.group_id = db_group.id');
        $this->db->join('store_profile', 'db_user.store_id = store_profile.id');

		if($lembaga != NULL) {
			$this->db->where('store_profile.id', $lembaga);
        }
        
        $this->db->where('stok_in_out.status', 1);
        $this->db->where('stok_in_out.action', 0);
        $this->db->group_by('stok_in_out.id_produk');
        $this->db->order_by('total_stok', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get();
        return $query;

    }


}

?>