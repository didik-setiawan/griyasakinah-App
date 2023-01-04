<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_saldo2_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	// UNTUK DATATABLE SERVER SIDE
	var $column_order = array(NULL, NULL, NULL, NULL); //set column field database for datatable orderable
	var $column_search = array(NULL, NULL, NULL, NULL); //set column field database for datatable searchable 
	var $order = array(NULL); // default order 


	private function _get_datatables_query(){

		if($this->input->post('periode')) {
			$periode = $this->input->post('periode');
			$this->db->select("
				(SELECT (SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) - SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0))) FROM laporan_keuangan WHERE laporan_keuangan.action = 0 AND laporan_keuangan.tanggal < '$periode') AS saldo_awal,
				SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) AS pemasukan,
				SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0)) AS pengeluaran,
				(SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) - SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0))) AS saldo_akhir
			");
			$this->db->where('MID(laporan_keuangan.tanggal,1,4)', $periode);
        }else{
			$bulan = date('Y');
            $this->db->select("
                (SELECT (SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) - SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0))) FROM laporan_keuangan WHERE laporan_keuangan.action = 0 AND MID(laporan_keuangan.tanggal,1,4) < '$bulan') AS saldo_awal,
				SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) AS pemasukan,
				SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0)) AS pengeluaran,
				(SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) - SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0))) AS saldo_akhir
            ");
            $this->db->where('MID(laporan_keuangan.tanggal,1,4)', $bulan);
		}

		if($this->input->post('id_lembaga')) {
			$this->db->where('store_profile.id', $this->input->post('id_lembaga'));
		}
		
        $this->db->from('laporan_keuangan');
        $this->db->join('db_user', 'laporan_keuangan.user_id = db_user.id');
		$this->db->join('db_group', 'db_user.group_id = db_group.id');
		$this->db->join('store_profile', 'db_user.store_id = store_profile.id');
		
		$this->db->where('laporan_keuangan.action', 0);
		
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

	public function getInfoSaldo($periode = NULL, $lembaga = NULL){
		if($periode) {
			$this->db->select("
				(SELECT (SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) - SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0))) FROM laporan_keuangan WHERE laporan_keuangan.action = 0 AND laporan_keuangan.tanggal < '$periode') AS saldo_awal,
				SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) AS pemasukan,
				SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0)) AS pengeluaran,
				(SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) - SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0))) AS saldo_akhir
			");
			$this->db->where('MID(laporan_keuangan.tanggal,1,4)', $periode);
        }else{
			$bulan = date('Y');
            $this->db->select("
                (SELECT (SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) - SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0))) FROM laporan_keuangan WHERE laporan_keuangan.action = 0 AND MID(laporan_keuangan.tanggal,1,4) < '$bulan') AS saldo_awal,
				SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) AS pemasukan,
				SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0)) AS pengeluaran,
				(SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) - SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0))) AS saldo_akhir
            ");
            $this->db->where('MID(laporan_keuangan.tanggal,1,4)', $bulan);
		}

		if($lembaga) {
			$this->db->where('store_profile.id', $lembaga);
		}
		
        $this->db->from('laporan_keuangan');
        $this->db->join('db_user', 'laporan_keuangan.user_id = db_user.id');
		$this->db->join('db_group', 'db_user.group_id = db_group.id');
		$this->db->join('store_profile', 'db_user.store_id = store_profile.id');
		$this->db->where('laporan_keuangan.action', 0);
		$query = $this->db->get();
		return $query->row();

	}

	public function getSaldoAwal2($periode = NULL, $lembaga = NULL){
		if($periode != NULL) {
			$periode = $periode;
			$this->db->select("
				(SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) - SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0))) AS saldo_awal
			");
			$this->db->where('MID(laporan_keuangan.tanggal,1,4) <', $periode);
        }else{
			$bulan = date('Y');
            $this->db->select("
				(SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) - SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0))) AS saldo_awal
            ");
            $this->db->where('MID(laporan_keuangan.tanggal,1,4) <', $bulan);
		}

		if($lembaga != NULL) {
			$this->db->where('store_profile.id', $lembaga);
		}
		
		$this->db->where('laporan_keuangan.action', 0);

        $this->db->from('laporan_keuangan');
        $this->db->join('db_user', 'laporan_keuangan.user_id = db_user.id');
		$this->db->join('db_group', 'db_user.group_id = db_group.id');
		$this->db->join('store_profile', 'db_user.store_id = store_profile.id');

		$query = $this->db->get();
		return $query->row();
	}

	public function getSaldoAwal(){
		if($this->input->post('periode')) {
			$periode = $this->input->post('periode');
			$this->db->select("
				(SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) - SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0))) AS saldo_awal
			");
			$this->db->where('MID(laporan_keuangan.tanggal,1,4) <', $periode);
        }else{
			$bulan = date('Y');
            $this->db->select("
				(SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) - SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0))) AS saldo_awal
            ");
            $this->db->where('MID(laporan_keuangan.tanggal,1,4) <', $bulan);
		}

		if($this->input->post('id_lembaga')) {
			$this->db->where('store_profile.id', $this->input->post('id_lembaga'));
		}
		
		$this->db->where('laporan_keuangan.action', 0);

        $this->db->from('laporan_keuangan');
        $this->db->join('db_user', 'laporan_keuangan.user_id = db_user.id');
		$this->db->join('db_group', 'db_user.group_id = db_group.id');
		$this->db->join('store_profile', 'db_user.store_id = store_profile.id');

		$query = $this->db->get();
		return $query->row();

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
