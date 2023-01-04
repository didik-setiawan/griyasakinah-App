<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_laporan_stok_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	// UNTUK DATATABLE SERVER SIDE

	private function _get_datatables_query(){
		
		// var $table = 'master_produk';
		$column_order = array(
			'stok_in_out.tanggal', 
			'master_produk.nama_produk', 
			'stok_in_out.quantity', 
			'stok_in_out.stok_tipe', 
			NULL
		); //set column field database for datatable orderable

		$column_search = array(
			'stok_in_out.tanggal', 
			'stok_in_out.jam', 
			'stok_in_out.quantity', 
			'stok_in_out.keterangan', 
			'master_produk.nama_produk',
			'master_produk.barcode',
			'master_produk_kategori.kategori_produk',
			'master_produk_unit.nama_satuan'
		); //set column field database for datatable searchable 
		
		$order = array(
			'stok_in_out.tanggal' => 'desc',
		); // default order 


		if($this->input->post('periode')) {
			$tgl = explode(" - ", $this->input->post('periode'));
			$today = date('Y-m-d');
			if($tgl[0] != $today && $tgl[1] != $today){
				$this->db->where('stok_in_out.tanggal >=', $tgl[0]);
				$this->db->where('stok_in_out.tanggal <=', $tgl[1]);
			}
		}

		if($this->input->post('kategori_produk')) {
			$this->db->where('master_produk_kategori.id', $this->input->post('kategori_produk'));
		}

		if($this->input->post('id_lembaga')) {
			$this->db->where('store_profile.id', $this->input->post('id_lembaga'));
		}

		$this->db->where('stok_in_out.status', 1);
		$this->db->where('stok_in_out.action', 0);
		$this->db->group_by("stok_in_out.id_produk");

		$this->db->select('
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

	public function getLaporan($periode = NULL, $tipe = NULL, $lembaga = NULL){
		if($periode) {
			$tgl = explode(" - ", $periode);
			$today = date('Y-m-d');
			if($tgl[0] != $today && $tgl[1] != $today){
				$this->db->where('stok_in_out.tanggal >=', $tgl[0]);
				$this->db->where('stok_in_out.tanggal <=', $tgl[1]);
			}
		}

		if($tipe) {
			$this->db->where('master_produk_kategori.id', $tipe);
		}

		if($lembaga) {
			$this->db->where('store_profile.id', $lembaga);
		}

		$this->db->where('stok_in_out.status', 1);
		$this->db->where('stok_in_out.action', 0);
		$this->db->group_by("stok_in_out.id_produk");
		$this->db->order_by('stok_in_out.tanggal', 'desc');

		$this->db->select('
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

		$query = $this->db->get();
		return $query->result();
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
