<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_keuangan_tahunan_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	
	// UNTUK DATATABLE SERVER SIDE
	var $column_order = array(
		NULL,
		NULL,
		NULL,
		NULL,
	); //set column field database for datatable orderable
	
	var $column_search = array(
		NULL,
		NULL,
		NULL,
		NULL,
	); //set column field database for datatable searchable 
	
	var $order = array(
		'laporan_keuangan_kategori_induk.nama_kategori'	=> 'asc',
	); // default order 


	private function _get_datatables_query(){

		if($this->input->post('id_lembaga')) {
			$this->db->where('store_profile.id', $this->input->post('id_lembaga'));
		}

		$this->db->where('laporan_keuangan_kategori_induk.action', 0);

		$this->db->select('
			laporan_keuangan_kategori_induk.*, 
			db_user.nama as nama_user, 
			db_group.group_name as nama_group, 
            db_group.id as id_group, 
            store_profile.nama_lembaga as nama_lembaga,
            store_profile.id as id_lembaga,
		');

        $this->db->from('laporan_keuangan_kategori_induk');
		$this->db->join('db_user', 'laporan_keuangan_kategori_induk.user_id = db_user.id');
		$this->db->join('db_group', 'db_user.group_id = db_group.id');
		$this->db->join('store_profile', 'db_user.store_id = store_profile.id');

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
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

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
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
