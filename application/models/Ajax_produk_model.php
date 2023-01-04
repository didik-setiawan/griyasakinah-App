<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_produk_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	// UNTUK DATATABLE SERVER SIDE
	// var $table = 'master_produk';

	private function _get_datatables_query(){
		$column_order = array(
			'master_produk.barcode', 
			'master_produk.nama_produk',
			'master_produk_kategori.kategori_produk', 
			NULL, 
			NULL, 
			NULL
		); //set column field database for datatable orderable
	
		$column_search = array(
			'master_produk.barcode',
			'master_produk.nama_produk',
			'master_produk.harga', 
			'master_produk_kategori.kategori_produk',
			'master_produk_unit.nama_satuan',
			'master_produk.stok',
		); //set column field database for datatable searchable 
		
		$order = array(
			'master_produk.nama_produk' => 'asc'
		); // default order 
	
	
		//add custom filter here
		if($this->input->post('kategori_produk')) {
			$this->db->where('master_produk.kategori_id', $this->input->post('kategori_produk'));
		}

		if($this->input->post('id_lembaga')) {
			$this->db->where('store_profile.id', $this->input->post('id_lembaga'));
		}

		$this->db->where('master_produk.action', 0);

		$this->db->select('
			master_produk.*, 
			master_produk_kategori.kategori_produk as nama_kategori, 
			master_produk_unit.nama_satuan as nama_satuan, 
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

		$i = 0;
	
		foreach ($column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($order))
		{
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getBarang($kategori = NULL, $lembaga = NULL){
		//add custom filter here
		if($kategori) {
			$this->db->where('master_produk.kategori_id', $kategori);
		}

		if($lembaga) {
			$this->db->where('store_profile.id', $lembaga);
		}

		$this->db->where('master_produk.action', 0);
        $this->db->order_by('master_produk.nama_produk', 'asc');

		$this->db->select('
			master_produk.*, 
			master_produk_kategori.kategori_produk as nama_kategori, 
			master_produk_unit.nama_satuan as nama_satuan, 
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
		
		$query = $this->db->get();
		return $query;
	}

	public function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->_get_datatables_query();
		return $this->db->count_all_results();
	}

	// UNTUK DATATABLE SERVER SIDE


}
