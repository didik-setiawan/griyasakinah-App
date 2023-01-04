<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_Logistik_model extends CI_Model{
    
    var $column_order = array('id_material','nama_material','kategori_produk','harga_mat',null); //set column field database for datatable orderable
    var $column_search = array('nama_material','kategori_produk'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('tgl_pengajuan ' => 'desc'); // default order 

    private function _get_datatables_query()
    {
		if($this->input->post('periode')) {
			$tgl = explode(" - ", $this->input->post('periode'));
			$today = date('Y-m-d');
			if($tgl[0] != $today && $tgl[1] != $today){
				$this->db->where('master_logistik.tgl_pengajuan >=', $tgl[0]);
				$this->db->where('master_logistik.tgl_pengajuan <=', $tgl[1]);
			}
		}
        
        $this->db->select('
        master_logistik.*,
     
        master_logistik_masuk.logistik_id,
        master_logistik_masuk.created_at as tgl_masuk,
        master_logistik_masuk.dokumentasi,
        ');

        $this->db->from('master_logistik');
        $this->db->join('master_logistik_masuk', 'master_logistik_masuk.logistik_id = master_logistik.id');
        // $this->db->group_by('master_logistik_masuk.created_at');

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

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
    }
    //PENGAJUAN DATA MATERIAL

    function get_datatables()
    {
        $this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
    }

    public function countKeluar($tgl = NULL){
        $this->db->select('tbl_proyek_material.*','COUNT(tbl_proyek_material.keluar) as total_keluar');
        $this->db->from('master_logistik');
        $this->db->join('tbl_proyek_material', 'tbl_proyek_material.id = master_logistik.proyek_material_id');
        $this->db->where('tbl_proyek_material.keluar', 1);

        if ($tgl != NULL) {
            $this->db->where('tbl_proyek_material.tgl_keluar', $tgl);
        }

        $query = $this->db->get();
        return $query;
    }
}

?>