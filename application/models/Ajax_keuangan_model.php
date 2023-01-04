<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_keuangan_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query(){
		// UNTUK DATATABLE SERVER SIDE
		$column_order = array(
			'datetimes', 
			'nama_transaksi', 
			'nominal', 
			NULL,
			NULL,
		); //set column field database for datatable orderable
		
		$column_search = array(
			'datetimes', 
			'nama_transaksi', 
			'nominal', 
			'laporan_keuangan_kategori_transaksi.nama_kategori',
			'laporan_keuangan_tipe.nama',
		); //set column field database for datatable searchable 
		
		$order = array('
			laporan_keuangan.tanggal ASC, 
			laporan_keuangan.id ASC
		'); // default order 

		if($this->input->post('periode')) {
            $tgl = explode(" - ", $this->input->post('periode'));
			$today = date('Y-m-d');
			if($tgl[0] == $today AND $tgl[1] == $today){
				$bulan = date('Y-m');
				$this->db->where("DATE_FORMAT(laporan_keuangan.tanggal,'%Y-%m')", $bulan);
			}else{
				$this->db->where('laporan_keuangan.tanggal >=', $tgl[0]);
				$this->db->where('laporan_keuangan.tanggal <=', $tgl[1]);
			}
        }else{
			$bulan = date('Y-m');
            $this->db->where("DATE_FORMAT(laporan_keuangan.tanggal,'%Y-%m')", $bulan);
		}

		if($this->input->post('kategori_transaksi')) {
			$this->db->where('laporan_keuangan.kategori_id', $this->input->post('kategori_transaksi'));
		}

		if($this->input->post('tipe')) {
			$this->db->where('laporan_keuangan.tipe_id', $this->input->post('tipe'));
		}

		if($this->input->post('id_lembaga')) {
			$this->db->where('store_profile.id', $this->input->post('id_lembaga'));
		}

		$this->db->where('laporan_keuangan.action', 0);

		$this->db->select('
			laporan_keuangan.*, 
			laporan_keuangan_kategori_transaksi.nama_kategori as kategori, 
			laporan_keuangan_tipe.nama as nama_tipe, 
			laporan_keuangan_tipe.warna as warna_tipe,
			db_user.nama as nama_user, 
			db_group.group_name as nama_group, 
            db_group.id as id_group, 
            store_profile.nama_lembaga as nama_lembaga,
            store_profile.id as id_lembaga,

		');
        $this->db->from('laporan_keuangan');
        $this->db->join('laporan_keuangan_kategori_transaksi', 'laporan_keuangan_kategori_transaksi.id = laporan_keuangan.kategori_id');
        $this->db->join('laporan_keuangan_tipe', 'laporan_keuangan_tipe.id = laporan_keuangan.tipe_id');
		$this->db->join('db_user', 'laporan_keuangan.user_id = db_user.id');
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
			$this->db->order_by($order[0]);
			// $this->db->order_by(key($order), $order[key($order)]);
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

	public function get_limit_id()
	{
		$this->_get_datatables_query();
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
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
