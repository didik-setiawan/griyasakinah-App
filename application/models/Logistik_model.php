<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logistik_model extends CI_Model{
    
    var $column_order = array('material_id','nama_material','kategori_produk',null); //set column field database for datatable orderable
    var $column_search = array('nama_material','kategori_produk','nama_proyek'); //set column field database for datatable searchable just firstname , lastname , address are searchable
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
        master_logistik.status as status_material,
        master_proyek.nama_proyek,

        tbl_proyek_material.id as id_proyek,
        tbl_proyek_material.quantity,
        tbl_proyek_material.harga as harga_mat,
        tbl_proyek_material.total as total_mat,

        master_produk_kategori.kategori_produk,
        master_material.nama_material,
        master_produk_unit.nama_satuan

        ');

        $this->db->from('master_logistik');
        $this->db->join('tbl_proyek_material', 'tbl_proyek_material.id = master_logistik.proyek_material_id');
        $this->db->join('master_proyek', 'master_proyek.id = tbl_proyek_material.proyek_id');

        $this->db->join('tbl_kavling', 'tbl_kavling.id_tipe  = tbl_proyek_material.tipe_id');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan  = tbl_kavling.id_perum');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));

        $this->db->join('master_material', 'master_material.id = master_logistik.material_id', 'left');
        $this->db->join('master_produk_unit', 'master_produk_unit.id = master_material.unit_id', 'left');

        $this->db->join('master_produk_kategori', 'master_produk_kategori.id = master_logistik.kategori_id');
        $this->db->group_by('master_logistik.id');
        $this->db->order_by('master_logistik.id','DESC');
      
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

    public function listKavling($id  = NULL) {
        $this->db->select('
        tbl_kavling.*, 
        ');
        
        $this->db->from('tbl_kavling');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));
       
        if($id  != NULL) {
            $this->db->where('tbl_kavling.id_kavling', $id );
        }
        $query = $this->db->get();
        return $query;
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_by_id($id_material)
    {
        $this->db->from('tbl_material');
        $this->db->join('master_kategori_material', 'master_kategori_material.id_kategori_material  = tbl_material.id_kategori_material ');
        $this->db->where('id_material',$id_material);
        $query = $this->db->get();
 
        return $query->row();
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
        $status = array(0,3);
        // $this->db->where('master_logistik.status', 0);
        $this->db->where_in('master_logistik.status', $status);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
    }

    function get_datatables_proyek()
    {
        $this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
    }

    function get_datatables_masuk()
    {
        $this->_get_datatables_query();
        $this->db->select('master_logistik_detail.harga_real, master_logistik_detail.status as status_keuangan');
        $this->db->join('master_logistik_detail','master_logistik_detail.logistik_id = master_logistik.id');
        $status = array(1,2);
        $stats = array(2,3);
        $this->db->where_in('master_logistik.status', $status);
        // $this->db->where($stat);
        $this->db->where_in('master_logistik_detail.status', $stats);
      
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
    }

    function get_datatables_rekap()
    {
        $this->_get_datatables_query();
        $this->db->group_by('tgl');
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
    }


    public function ApprovePengajuan($id = NULL, $data = NULL) {
        $this->db->where('id', $id);
        $this->db->update('master_logistik', $data);
    }

    public function addPengajuan($params) {
        $this->db->insert('master_logistik', $params);
    }

    public function editPengajuan($id = NULL, $data = NULL) {
        $this->db->where('id', $id);
        $this->db->update('master_logistik', $data);
    }
    public function edit_proyek_material($id = NULL, $data = NULL) {
        $this->db->where('id', $id);
        $this->db->update('tbl_proyek_material', $data);
    }

    public function addLainnya($params) {
        $this->db->insert('tbl_proyek_lainnya', $params);
    }

    public function delPengajuan($id = NULL) {
        $this->db->where('id', $id);
        $this->db->delete('master_logistik');
    }

    public function listRab($id  = NULL) {

        $this->db->select('
        master_proyek.*,

        master_proyek_kavling.proyek_id as idProyekKav,
        master_proyek_kavling.kavling_id,
        tbl_kavling.*,
        tbl_perumahan.*,

        master_proyek.rab,
        master_proyek.id as id_proyek,
        master_proyek.nama_proyek,

        ');

    $this->db->from('master_proyek');
    $this->db->join('master_proyek_kavling', 'master_proyek_kavling.proyek_id = master_proyek.id');

    $this->db->join('tbl_kavling', 'tbl_kavling.id_kavling  = master_proyek_kavling.kavling_id');
    $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan  = tbl_kavling.id_perum');

    $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));
    $this->db->group_by('master_proyek.id');
    $this->db->where('master_proyek.rab',1);

    if ($id != NULL) {
        $this->db->where('master_proyek.id', $id);
    }

    $query = $this->db->get();
    return $query;
    }

    public function listProyekMaterial($id  = NULL) {

        $this->db->select('
        master_logistik.*,

        tbl_proyek_material.quantity,
        ');

        $this->db->from('master_logistik');
        $this->db->join('tbl_proyek_material', 'tbl_proyek_material.id = master_logistik.proyek_material_id');

    if ($id != NULL) {
        $this->db->where('master_logistik.id', $id);
    }

    $query = $this->db->get();

    return $query;
    }

    
    public function gambar_masuk($id  = NULL) {

        $this->db->select('
        master_logistik.*,
        master_logistik_masuk.*,
        master_logistik_masuk.created_at as tgl_masuk,
        ');
        
        $this->db->from('master_logistik');
        $this->db->join('master_logistik_masuk', 'master_logistik_masuk.logistik_id = master_logistik.id');

    if ($id != NULL) {
        $this->db->where('master_logistik.id', $id);
    }

    $query = $this->db->get();

    return $query;
    }

    public function listMaterial($id  = NULL) {

        $this->db->select('
        tbl_proyek_material.*,
        tbl_proyek_material.harga as harga_mat,
        tbl_proyek_material.total as total_mat,

        master_material.id as id_material,
        master_material.unit_id,
        master_material.kategori_id,
        master_material.nama_material,

        master_proyek_kavling.proyek_id as idProyekKav,
        master_proyek_kavling.kavling_id,
        tbl_kavling.*,
        tbl_perumahan.*,

        master_proyek.rab,
        master_proyek.id as id_proyek,
        master_proyek.nama_proyek,

        master_produk_kategori.id as id_kategori, 
        master_produk_kategori.kategori_produk, 
        master_produk_unit.id as id_unit,  
        master_produk_unit.nama_satuan,
        ');

        $this->db->from('tbl_proyek_material');
        $this->db->join('master_proyek', 'master_proyek.id = tbl_proyek_material.proyek_id');


        $this->db->join('master_proyek_kavling', 'master_proyek_kavling.proyek_id = tbl_proyek_material.proyek_id');
        $this->db->join('tbl_kavling', 'tbl_kavling.id_kavling  = master_proyek_kavling.kavling_id');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan  = tbl_kavling.id_perum');

        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));
        $this->db->group_by('tbl_proyek_material.id');
        $this->db->where('master_proyek.rab',1);


        $this->db->join('master_material', 'tbl_proyek_material.material_id = master_material.id');
        $this->db->join('master_produk_kategori', 'master_produk_kategori.id = master_material.kategori_id');
        $this->db->join('master_produk_unit', 'master_produk_unit.id = master_material.unit_id');

        if ($id != NULL) {
            $this->db->where('tbl_proyek_material.proyek_id', $id);
        }

        $query = $this->db->get();
        return $query;
    }

    public function DropdownTipeRab($id  = NULL) {
        $this->db->select('
        master_proyek_kavling.*,
        tbl_kavling.*, 
        tbl_tipe.*,
        tbl_perumahan.*,
        ');
        
        $this->db->from('master_proyek_kavling');
        $this->db->join('tbl_kavling', 'tbl_kavling.id_kavling = master_proyek_kavling.kavling_id');
        $this->db->join('tbl_tipe', 'tbl_tipe.id_tipe = tbl_kavling.id_tipe');

        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));
        $this->db->group_by('tbl_tipe.id_tipe');

        if($id  != NULL) {
            $this->db->where('master_proyek_kavling.proyek_id', $id);
        }

        $query = $this->db->get();
        return $query;
    }

    public function DropdownKavlingRab($id  = NULL, $id_pro = null) {
        $q = "SELECT * FROM tbl_kavling JOIN master_proyek_kavling ON tbl_kavling.id_kavling = master_proyek_kavling.kavling_id WHERE tbl_kavling.id_tipe = $id AND master_proyek_kavling.proyek_id = $id_pro";
        return $this->db->query($q);
        // $this->db->select('
        // master_proyek_kavling.*,
        // tbl_kavling.*, 
        // tbl_tipe.*,
        // tbl_perumahan.*,
        // ');
        
        // $this->db->from('master_proyek_kavling');
        // $this->db->join('tbl_kavling', 'tbl_kavling.id_kavling = master_proyek_kavling.kavling_id');
        // $this->db->join('tbl_tipe', 'tbl_tipe.id_tipe = tbl_kavling.id_tipe');

        // $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        // $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));
        // $this->db->group_by('tbl_kavling.id_kavling');

        // if($id  != NULL) {
        //     $this->db->where('tbl_tipe.id_tipe', $id);
        // }
        
        // $query = $this->db->get();
        // return $query;
        
    }

    public function DropdownJenisMaterial($id  = NULL,$id_pro = NULL) {
        $this->db->select('
            tbl_proyek_material.*,
            master_produk_kategori.kategori_produk,
            master_produk_kategori.id as id_kategori,
        ');

        $this->db->from('tbl_proyek_material');

        $this->db->join('master_material', 'tbl_proyek_material.material_id = master_material.id');
        $this->db->join('master_produk_kategori', 'master_produk_kategori.id = master_material.kategori_id');
        $this->db->join('master_produk_unit', 'master_produk_unit.id = master_material.unit_id');

        if ($id != NULL) {
            $this->db->where('tbl_proyek_material.kavling_id', $id);
        }

        if ($id_pro != NULL) {
            $this->db->where('tbl_proyek_material.proyek_id', $id_pro);
        }

        $query = $this->db->get();
        return $query;
    }

    public function DropdownMaterial($id  = NULL,$id_pro  = NULL,$id_tipe = NULL) {
        // $this->db->select('
        // tbl_proyek_material.*,

        // master_material.nama_material,
        // master_material.id as id_material,
        // ');

        // $this->db->from('tbl_proyek_material');
        // $this->db->join('master_material', 'tbl_proyek_material.material_id = master_material.id');

        // if ($id != NULL) {
        // $this->db->where('tbl_proyek_material.kategori_id', $id);
        // }
        // if ($id_pro != NULL) {
        //     $this->db->where('tbl_proyek_material.proyek_id', $id_pro);
        // }

        // if ($id_kav != NULL) {
        //     $this->db->where('tbl_proyek_material.kavling_id', $id_kav);
        // }

        // $query = $this->db->get();

            $q = "SELECT 
                master_material.*, master_material.id as id_material,
                tbl_proyek_material.* 
                FROM 
                master_material,
                tbl_proyek_material
                WHERE
                tbl_proyek_material.proyek_id = $id_pro AND
                tbl_proyek_material.kategori_id = $id AND
                tbl_proyek_material.tipe_id = $id_tipe AND 
                tbl_proyek_material.material_id = master_material.id
            ";
            $query = $this->db->query($q);

        return $query;
    }

    public function DropdownQuantity($id  = NULL,$id_pro  = NULL) {
        $this->db->select('
        tbl_proyek_material.*,
        tbl_proyek_material.id as id_pro_mat,

        master_material.nama_material,
        master_material.id as id_material,

        master_produk_unit.*,
        master_produk_unit.id as id_unit
        ');

        $this->db->from('tbl_proyek_material');
        $this->db->join('master_material', 'tbl_proyek_material.material_id = master_material.id');
        $this->db->join('master_produk_unit', 'master_material.unit_id = master_produk_unit.id');

        if ($id != NULL) {
        $this->db->where('tbl_proyek_material.material_id', $id);
        }
        if ($id_pro != NULL) {
            $this->db->where('tbl_proyek_material.proyek_id', $id_pro);
        }

        $query = $this->db->get();
        return $query;
    }

    public function getProyekMaterial($id  = NULL) {

        $this->db->select('
        tbl_proyek_material.*,
        ');

        $this->db->from('tbl_proyek_material');

    if ($id != NULL) {
        $this->db->where('tbl_proyek_material.id', $id);
    }

    $query = $this->db->get();

    return $query;
    }

    public function getDetailRAB($id = NULL)
    {
        $this->db->select('
            tbl_proyek_material.*,
            master_proyek.rab,
            master_material.id as id_material,
            master_material.unit_id,
            master_material.kategori_id,
            master_material.nama_material,

            master_produk_kategori.id as id_kategori, 
            master_produk_kategori.kategori_produk, 
            master_produk_unit.id as id_unit,  
            master_produk_unit.nama_satuan,
        ');

        $this->db->from('tbl_proyek_material');
        $this->db->join('master_proyek', 'tbl_proyek_material.proyek_id = master_proyek.id');
        $this->db->join('master_material', 'tbl_proyek_material.material_id = master_material.id');
        $this->db->join('master_produk_kategori', 'master_produk_kategori.id = master_material.kategori_id');
        $this->db->join('master_produk_unit', 'master_produk_unit.id = master_material.unit_id');

        if ($id != NULL) {
            $this->db->where('tbl_proyek_material.id', $id);
        }

        $query = $this->db->get();
        return $query;
    }

    public function getDropDetailRAB($id = NULL)
    {
        $this->db->select('
            tbl_proyek_material.*,
            master_proyek.rab,
            master_material.id as id_material,
            master_material.unit_id,
            master_material.kategori_id,
            master_material.nama_material,

            master_produk_kategori.id as id_kategori, 
            master_produk_kategori.kategori_produk, 
            master_produk_unit.id as id_unit,  
            master_produk_unit.nama_satuan,
        ');

        $this->db->from('tbl_proyek_material');
        $this->db->join('master_proyek', 'tbl_proyek_material.proyek_id = master_proyek.id');
        $this->db->join('master_material', 'tbl_proyek_material.material_id = master_material.id');
        $this->db->join('master_produk_kategori', 'master_produk_kategori.id = master_material.kategori_id');
        $this->db->join('master_produk_unit', 'master_produk_unit.id = master_material.unit_id');

        if ($id != NULL) {
            $this->db->where('tbl_proyek_material.id', $id);
        }

        $query = $this->db->get();
        return $query;
    }

    
    public function addMaterialKeluar($params) {
        $this->db->insert('master_logistik_keluar', $params);
    }

    public function MaterialKeluar($id = NULL)
    {
        $this->db->select('
        master_logistik.id as id_logistik,

        tbl_proyek_material.*,
        tbl_proyek_material.harga as harga_satuan,

        master_logistik_keluar.material_keluar,

        master_proyek.nama_proyek,
        master_proyek.rab,

        tbl_proyek_material.proyek_id as id_proyek,
        tbl_proyek_material.quantity,
        tbl_proyek_material.harga as harga_mat,
        tbl_proyek_material.total as total_mat,

        master_produk_kategori.kategori_produk,
        master_material.nama_material,
        master_produk_unit.nama_satuan,

        tbl_kavling.*,
        tbl_tipe.*,
        tbl_max_material.max,
        logistik_stok.stok,
        ');

        $this->db->from('master_logistik');

        $this->db->join('tbl_proyek_material', 'tbl_proyek_material.id = master_logistik.proyek_material_id');

        $this->db->join('master_logistik_keluar', 'master_logistik_keluar.logistik_id = master_logistik.id','left');
        $this->db->join('logistik_stok', 'logistik_stok.logistik_id = master_logistik.id','left');

        $this->db->join('master_proyek', 'master_proyek.id = tbl_proyek_material.proyek_id');

        $this->db->join('tbl_kavling', 'tbl_kavling.id_tipe = tbl_proyek_material.tipe_id');
        $this->db->join('tbl_tipe', 'tbl_kavling.id_tipe = tbl_tipe.id_tipe');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));

        $this->db->join('master_material', 'master_material.id = tbl_proyek_material.material_id', 'left');
        $this->db->join('tbl_max_material', 'tbl_max_material.material_id = master_material.id', 'left');

        $this->db->join('master_produk_unit', 'master_produk_unit.id = master_material.unit_id', 'left');

        $this->db->join('master_produk_kategori', 'master_produk_kategori.id = tbl_proyek_material.kategori_id');

        $this->db->group_by('master_logistik.id');

        if ($id != NULL) {
            $this->db->where('tbl_proyek_material.proyek_id', $id);
        }

        $query = $this->db->get();
        return $query;
    }


    public function getMaterialKeluarProyek($id = null){
        $this->db->select('
        master_logistik.id as id_logistik,

        tbl_proyek_material.*,
        tbl_proyek_material.harga as harga_satuan,

        master_logistik_keluar.material_keluar,

        master_proyek.nama_proyek,
        master_proyek.rab,

        tbl_proyek_material.proyek_id as id_proyek,
        tbl_proyek_material.quantity,
        tbl_proyek_material.harga as harga_mat,
        tbl_proyek_material.total as total_mat,

        master_produk_kategori.kategori_produk,
        master_material.nama_material,
        master_produk_unit.nama_satuan,

        tbl_kavling.*,
        tbl_tipe.*,
        tbl_max_material.max,
        logistik_stok.stok,
        ');

        $this->db->from('master_logistik');

        $this->db->join('tbl_proyek_material', 'tbl_proyek_material.id = master_logistik.proyek_material_id');

        $this->db->join('master_logistik_keluar', 'master_logistik_keluar.logistik_id = master_logistik.id','left');
        $this->db->join('logistik_stok', 'logistik_stok.logistik_id = master_logistik.id','left');

        $this->db->join('master_proyek', 'master_proyek.id = tbl_proyek_material.proyek_id');

        $this->db->join('tbl_kavling', 'tbl_kavling.id_tipe = tbl_proyek_material.tipe_id');
        $this->db->join('tbl_tipe', 'tbl_kavling.id_tipe = tbl_tipe.id_tipe');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));

        $this->db->join('master_material', 'master_material.id = tbl_proyek_material.material_id', 'left');
        $this->db->join('tbl_max_material', 'tbl_max_material.material_id = master_material.id', 'left');

        $this->db->join('master_produk_unit', 'master_produk_unit.id = master_material.unit_id', 'left');

        $this->db->join('master_produk_kategori', 'master_produk_kategori.id = tbl_proyek_material.kategori_id');

        $this->db->group_by('master_logistik.id');

        if ($id != NULL) {
            $this->db->where('master_logistik.id_proyek', $id);
        }

        $query = $this->db->get();
        return $query;
    }

    public function DetailMaterialKeluar($id = NULL)
    {
        $this->db->select('
        master_logistik.id,

        tbl_proyek_material.id as id_proyek,
        tbl_proyek_material.harga as harga_satuan,
        tbl_proyek_material.proyek_id as id_pro,

        master_proyek.nama_proyek,
        master_proyek.rab,

        tbl_proyek_material.id as id_proyek,
        tbl_proyek_material.quantity,
        tbl_proyek_material.harga as harga_mat,
        tbl_proyek_material.total as total_mat,

        master_produk_kategori.kategori_produk,
        master_material.nama_material,
        master_produk_unit.nama_satuan,

        tbl_kavling.*,
        tbl_tipe.*,
        tbl_max_material.id_max,
        tbl_max_material.max,
        master_logistik_masuk.material_masuk,

        master_logistik_keluar.id as id_keluar,
        master_logistik_keluar.material_keluar,
        logistik_stok.id_stok,
        logistik_stok.stok,
        ');

        $this->db->from('tbl_proyek_material');

        $this->db->join('master_logistik', 'master_logistik.proyek_material_id = tbl_proyek_material.id','left');

        $this->db->join('master_logistik_masuk', 'master_logistik_masuk.logistik_id = master_logistik.id','left');
        $this->db->join('master_logistik_keluar', 'master_logistik_keluar.logistik_id = master_logistik.id','left');
        $this->db->join('logistik_stok', 'logistik_stok.logistik_id = master_logistik.id','left');

        $this->db->join('master_proyek', 'master_proyek.id = tbl_proyek_material.proyek_id');

        $this->db->join('tbl_kavling', 'tbl_kavling.id_tipe = tbl_proyek_material.tipe_id');
        $this->db->join('tbl_tipe', 'tbl_kavling.id_tipe = tbl_tipe.id_tipe');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));

        $this->db->join('master_material', 'master_material.id = tbl_proyek_material.material_id', 'left');
        $this->db->join('tbl_max_material', 'tbl_max_material.material_id = master_material.id', 'left');

        $this->db->join('master_produk_unit', 'master_produk_unit.id = master_material.unit_id', 'left');

        $this->db->join('master_produk_kategori', 'master_produk_kategori.id = tbl_proyek_material.kategori_id');


        if ($id != NULL) {
            $this->db->where('master_logistik.id', $id);
        }

        $query = $this->db->get();

        return $query;
    }

    public function addStok($params) {
        $this->db->insert('logistik_stok', $params);
    }

    public function edit_Matkeluar($id = NULL, $data = NULL) {
        $this->db->where('id', $id);
        $this->db->update('master_logistik_keluar', $data);
    }

    public function edit_Stok($id = NULL, $data = NULL) {
        $this->db->where('id_stok', $id);
        $this->db->update('logistik_stok', $data);
    }

    public function RekapMaterial($id = NULL)
    {
        $this->db->select('
        master_logistik_masuk.material_masuk,
        master_logistik_keluar.material_keluar,
        logistik_stok.stok,
        logistik_stok.id_stok,
        master_logistik.id as id_logistik,

        pengajuan_material.id_perumahan,

        master_produk_kategori.kategori_produk,
        master_material.nama_material,
        master_produk_unit.nama_satuan,

        SUM(master_logistik_masuk.material_masuk) as total_masuk,
        SUM(master_logistik_keluar.material_keluar) as total_keluar,
        SUM(logistik_stok.stok) as total_stok,
        ');

        $this->db->from('master_logistik');
        $this->db->join('master_logistik_masuk', 'master_logistik_masuk.logistik_id = master_logistik.id','left');
        $this->db->join('master_logistik_keluar', 'master_logistik_keluar.logistik_id = master_logistik.id','left');
        $this->db->join('logistik_stok', 'logistik_stok.logistik_id = master_logistik.id','left');

        
        $this->db->join('pengajuan_material','pengajuan_material.time = master_logistik.time');

        $this->db->where('pengajuan_material.id_perumahan',$this->session->userdata('id_perumahan'));
        $this->db->where('logistik_stok.type', 0);

        $this->db->join('master_material', 'master_material.id = master_logistik.material_id', 'left');
        $this->db->join('master_produk_unit', 'master_produk_unit.id = master_material.unit_id', 'left');
        $this->db->join('master_produk_kategori', 'master_produk_kategori.id = master_logistik.kategori_id');

        $this->db->group_by('master_logistik.material_id');

        $query = $this->db->get();
        return $query;
    }

    public function RekapMaterialKategori($id = NULL)
    {
        $this->db->select('
        master_logistik.id as id_logistik,

        tbl_proyek_material.*,
        tbl_proyek_material.harga as harga_satuan,

        master_logistik_masuk.material_masuk,
        master_logistik_keluar.material_keluar,

        master_produk_kategori.id as id_kategori,
        master_produk_kategori.kategori_produk,
        master_material.nama_material,
        master_produk_unit.nama_satuan,

        tbl_kavling.*,
        tbl_tipe.*,
        tbl_max_material.max,
        logistik_stok.stok,

        SUM(master_logistik_masuk.material_masuk) as total_masuk,
        SUM(master_logistik_keluar.material_keluar) as total_keluar,
        SUM(logistik_stok.stok) as total_stok,
        ');

        $this->db->from('master_logistik');

        $this->db->join('tbl_proyek_material', 'tbl_proyek_material.id = master_logistik.proyek_material_id');

        $this->db->join('master_logistik_masuk', 'master_logistik_masuk.logistik_id = master_logistik.id','left');
        $this->db->join('master_logistik_keluar', 'master_logistik_keluar.logistik_id = master_logistik.id','left');
        $this->db->join('logistik_stok', 'logistik_stok.logistik_id = master_logistik.id','left');

        $this->db->join('master_proyek', 'master_proyek.id = tbl_proyek_material.proyek_id');


        $this->db->join('tbl_kavling', 'tbl_kavling.id_kavling = tbl_proyek_material.kavling_id');
        $this->db->join('tbl_tipe', 'tbl_kavling.id_tipe = tbl_tipe.id_tipe');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));

        $this->db->join('master_material', 'master_material.id = tbl_proyek_material.material_id', 'left');
        $this->db->join('tbl_max_material', 'tbl_max_material.material_id = master_material.id', 'left');

        $this->db->join('master_produk_unit', 'master_produk_unit.id = master_material.unit_id', 'left');

        $this->db->join('master_produk_kategori', 'master_produk_kategori.id = tbl_proyek_material.kategori_id');

        $this->db->group_by('master_material.nama_material');

        if ($id != NULL) {
            $this->db->where('master_produk_kategori.id', $id);
        }

        $query = $this->db->get();
        return $query;
    }

    public function RekapMaterialMaterial($id = NULL)
    {
        $this->db->select('
        master_logistik.id as id_logistik,

        tbl_proyek_material.*,
        tbl_proyek_material.harga as harga_satuan,

        master_logistik_masuk.material_masuk,
        master_logistik_keluar.material_keluar,

        master_proyek.nama_proyek,
        master_proyek.rab,

        tbl_proyek_material.proyek_id as id_proyek,
        tbl_proyek_material.quantity,
        tbl_proyek_material.harga as harga_mat,
        tbl_proyek_material.total as total_mat,

        master_produk_kategori.kategori_produk,
        master_material.id as id_material,
        master_material.nama_material,
        master_produk_unit.nama_satuan,

        tbl_kavling.*,
        tbl_tipe.*,
        tbl_max_material.max,
        logistik_stok.stok,

        SUM(master_logistik_masuk.material_masuk) as total_masuk,
        SUM(master_logistik_keluar.material_keluar) as total_keluar,
        SUM(logistik_stok.stok) as total_stok,
        ');

        $this->db->from('master_logistik');

        $this->db->join('tbl_proyek_material', 'tbl_proyek_material.id = master_logistik.proyek_material_id');

        $this->db->join('master_logistik_masuk', 'master_logistik_masuk.logistik_id = master_logistik.id','left');
        $this->db->join('master_logistik_keluar', 'master_logistik_keluar.logistik_id = master_logistik.id','left');
        $this->db->join('logistik_stok', 'logistik_stok.logistik_id = master_logistik.id','left');

        $this->db->join('master_proyek', 'master_proyek.id = tbl_proyek_material.proyek_id');


        $this->db->join('tbl_kavling', 'tbl_kavling.id_kavling = tbl_proyek_material.kavling_id');
        $this->db->join('tbl_tipe', 'tbl_kavling.id_tipe = tbl_tipe.id_tipe');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));

        $this->db->join('master_material', 'master_material.id = tbl_proyek_material.material_id', 'left');
        $this->db->join('tbl_max_material', 'tbl_max_material.material_id = master_material.id', 'left');

        $this->db->join('master_produk_unit', 'master_produk_unit.id = master_material.unit_id', 'left');

        $this->db->join('master_produk_kategori', 'master_produk_kategori.id = tbl_proyek_material.kategori_id');

        $this->db->group_by('master_material.nama_material');

        if ($id != NULL) {
            $this->db->where('master_material.id', $id);
        }

        $query = $this->db->get();
        return $query;
    }





    //15/8/2022

    public function Change_jml_out($id, $pengajuan, $jml_out_mat){
        $tot_out_mat = $pengajuan + $jml_out_mat;
         $this->db->set('jml_out', $tot_out_mat)->where('id', $id)->update('tbl_proyek_material');
    }

    public function getTotalPengajuan($id_material, $id_proyek){
        $q = "SELECT SUM(jml_pengajuan) as total_pengajuan FROM master_logistik WHERE proyek_material_id = $id_proyek AND material_id = $id_material AND status != 3 AND status != 1";
        return $this->db->query($q)->row()->total_pengajuan;
    }

    public function get_material_with_cart($id){
        $this->db->select('master_material.*,
            master_produk_kategori.*,
            master_produk_unit.*
        ')
        ->from('master_material')
        ->join('master_produk_kategori', 'master_material.kategori_id = master_produk_kategori.id')
        ->join('master_produk_unit','master_material.unit_id = master_produk_unit.id')
        ->where('master_material.id', $id);
        return $this->db->get()->row();
    }

    public function getDataPengajuanMaterialDetail($id){
        $id_perum = $this->session->userdata('id_perumahan');
        $this->db->select('
            pengajuan_material.*,
            master_logistik.jml_pengajuan,
            master_logistik.id as id_logistik,
            master_logistik.tipe as type,
            tbl_proyek_material.harga,
            tbl_proyek_material.proyek_id,
            master_proyek.nama_proyek,
            master_material.nama_material,
            master_produk_kategori.kategori_produk,
            master_produk_unit.nama_satuan,
            tbl_tipe.tipe
        ')
        ->from('pengajuan_material')
        ->join('master_logistik','pengajuan_material.time = master_logistik.time')
        ->join('tbl_proyek_material', 'master_logistik.proyek_material_id = tbl_proyek_material.id')
        ->join('master_proyek','pengajuan_material.id_proyek = master_proyek.id')
        ->join('master_material','tbl_proyek_material.material_id = master_material.id')
        ->join('master_produk_kategori','master_material.kategori_id = master_produk_kategori.id')
        ->join('master_produk_unit','master_material.unit_id = master_produk_unit.id')
        ->join('tbl_tipe','tbl_proyek_material.tipe_id = tbl_tipe.id_tipe')
        ->where('pengajuan_material.id_pengajuan', $id)
        ->where('master_proyek.end', 0)
        ->where('tbl_tipe.id_perum', $id_perum);
        return $this->db->get();
    }

    public function getDataPengajuanMaterial($filter = null){
        $id_perum = $this->session->userdata('id_perumahan');
        $this->db->select('
            pengajuan_material.*,
            master_proyek.nama_proyek
        ')
        ->from('pengajuan_material')
        ->join('master_proyek','pengajuan_material.id_proyek = master_proyek.id')
        ->where('pengajuan_material.id_perumahan', $id_perum)
        ->where('master_proyek.end', 0);

        if($filter){
            $this->db->where('master_proyek.id', $filter);
        }

        return $this->db->get();
    }

    public function countTotalTerbayar($id){
        $q = "SELECT SUM(jml_pengajuan) AS total FROM cicil_material WHERE id_pengajuan = $id AND status = 2";
        return $this->db->query($q)->row();
    }


    public function getLogistikMasuk($id = null){
        $id_perum = $this->session->userdata('id_perumahan');
        $stat = [4,5];
        $this->db->select('
            pengajuan_material.*,
            master_logistik.jml_pengajuan,
            master_logistik.id as id_logistik,
            master_logistik.tipe as type,
            tbl_proyek_material.harga,
            tbl_proyek_material.id as proyek_material_id,
            master_proyek.nama_proyek,
            master_material.nama_material,
            master_produk_kategori.kategori_produk,
            master_produk_unit.nama_satuan,
            tbl_tipe.tipe,
            master_logistik_detail.harga_real
        ')
        ->from('pengajuan_material')
        ->join('master_logistik','pengajuan_material.time = master_logistik.time')
        ->join('tbl_proyek_material', 'master_logistik.proyek_material_id = tbl_proyek_material.id')
        ->join('master_proyek','pengajuan_material.id_proyek = master_proyek.id')
        ->join('master_material','tbl_proyek_material.material_id = master_material.id')
        ->join('master_produk_kategori','master_material.kategori_id = master_produk_kategori.id')
        ->join('master_produk_unit','master_material.unit_id = master_produk_unit.id')
        ->join('tbl_tipe','tbl_proyek_material.tipe_id = tbl_tipe.id_tipe')
        ->join('master_logistik_detail','master_logistik_detail.logistik_id = master_logistik.id')
        ->where('tbl_tipe.id_perum', $id_perum)
        ->where_in('pengajuan_material.status_pengajuan', $stat);
        if($id){
            $this->db->where('pengajuan_material.id_pengajuan', $id);
        }
        return $this->db->get();
    }


    public function getProyekByPerum(){
        $id_perum = $this->session->userdata('id_perumahan');
        $this->db->select('
            master_proyek.*,
            master_proyek.id as proyek_id,
            tbl_proyek_material.*,
            tbl_tipe.*
        ')
        ->from('master_proyek')
        ->join('tbl_proyek_material','master_proyek.id = tbl_proyek_material.proyek_id')
        ->join('tbl_tipe','tbl_proyek_material.tipe_id = tbl_tipe.id_tipe')
        ->where('tbl_tipe.id_perum', $id_perum)
        ->where('master_proyek.end', 1)
        ->group_by('tbl_proyek_material.proyek_id');
        return $this->db->get();
    }


    public function getMaterialGudangbyFilter($id_perum = null){
        $this->db->select('
            tbl_proyek_material.proyek_id,
            tbl_proyek_material.id as id_proyek_material,
            master_logistik.id as id_logistik,
            master_material.*,
            master_material.id as material_id,
            master_produk_kategori.kategori_produk,
            master_produk_unit.nama_satuan,
            master_logistik_masuk.material_masuk,
            master_proyek.nama_proyek
        ')
        ->from('tbl_proyek_material')
        ->join('master_logistik','tbl_proyek_material.id = master_logistik.proyek_material_id')
        ->join('master_material', 'master_logistik.material_id = master_material.id')
        ->join('master_produk_kategori', 'master_material.kategori_id = master_produk_kategori.id')
        ->join('master_produk_unit','master_material.unit_id = master_produk_unit.id')
        ->join('master_proyek','tbl_proyek_material.proyek_id = master_proyek.id')
        ->join('master_logistik_masuk','master_logistik.id = master_logistik_masuk.logistik_id');
        if($id_perum){
            $this->db->where('tbl_proyek_material.proyek_id', $id_perum);
        }
        return $this->db->get();
    }

    public function CountSisaPembayaran($id){
        $this->db->select('pengajuan_material.id_perumahan,
            master_logistik.jml_pengajuan,
            master_logistik.tipe as type,
            master_logistik_detail.harga_real
        ')
        ->from('pengajuan_material')
        ->join('master_logistik','pengajuan_material.time = master_logistik.time')
        ->join('master_logistik_detail', 'master_logistik.id = master_logistik_detail.logistik_id')
        ->where('pengajuan_material.id_pengajuan', $id);
        return $this->db->get();
    }

    public function getLogistikMasukAll(){
        $id_perum = $this->session->userdata('id_perumahan');
        $stat = [4,5];

        $this->db->select('
            master_proyek.nama_proyek,
            pengajuan_material.*,
            master_logistik.jml_pengajuan,
            master_logistik.id as id_logistik,
            master_logistik.tipe as type,
            master_logistik_detail.harga_real,
            master_material.nama_material,
            master_produk_kategori.kategori_produk,
            master_produk_unit.nama_satuan,
        ')->from('master_proyek')
        ->join('pengajuan_material','master_proyek.id = pengajuan_material.id_proyek')
        ->join('master_logistik','pengajuan_material.time = master_logistik.time')
        ->join('master_logistik_detail','master_logistik.id = master_logistik_detail.logistik_id')
        ->join('master_material','master_logistik.material_id = master_material.id')
        ->join('master_produk_kategori','master_material.kategori_id = master_produk_kategori.id')
        ->join('master_produk_unit','master_material.unit_id = master_produk_unit.id')
        ->where_in('pengajuan_material.status_pengajuan', $stat)
        ->where('pengajuan_material.id_perumahan', $id_perum);

        return $this->db->get()->result();
    }

    public function get_rekap_material($jenis = null, $material = null){
        $this->db->select('
            pengajuan_material.id_perumahan,
            master_logistik.id,

            master_produk_kategori.kategori_produk,
            master_material.nama_material,
            master_produk_unit.nama_satuan,

            logistik_stok.stok,
            logistik_stok.id_stok,

            SUM(logistik_stok.stok) as stok_logistik

        ')->from('master_logistik')
        ->join('pengajuan_material','master_logistik.time = pengajuan_material.time')
        ->join('master_material', 'master_material.id = master_logistik.material_id', 'left')
        ->join('master_produk_unit', 'master_produk_unit.id = master_material.unit_id', 'left')
        ->join('master_produk_kategori', 'master_produk_kategori.id = master_logistik.kategori_id')
        ->join('logistik_stok', 'logistik_stok.logistik_id = master_logistik.id')
        ->where('pengajuan_material.id_perumahan', $this->session->userdata('id_perumahan'))
        ->where('logistik_stok.type', 0)
       ->group_by('master_logistik.material_id');

       if($jenis){
        $this->db->where('master_logistik.kategori_id', $jenis);
       }
       if($material){
        $this->db->where('master_logistik.material_id', $material);
       }

       return $this->db->get();
    }


    public function getUpahPekerja($filter = null){
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
        ->where('tbl_kavling.id_perum', $id_perum);

        if($filter){
            $this->db->where('master_proyek.id', $filter);
        }

        return $this->db->get();
    }


    public function getKavlingByProyek($id_pro){
        $this->db->select('
            master_proyek_kavling.proyek_id,
            tbl_kavling.blok,
            tbl_kavling.id_kavling,
            tbl_kavling.no_rumah,
            tbl_tipe.tipe
        ')->from('master_proyek_kavling')
        ->join('tbl_kavling', 'master_proyek_kavling.kavling_id = tbl_kavling.id_kavling')
        ->join('tbl_tipe', 'tbl_kavling.id_tipe = tbl_tipe.id_tipe')
        ->where('master_proyek_kavling.proyek_id', $id_pro);
        return $this->db->get();
    }

    public function getJenisMaterialKeluar($kavling, $proyek){
        $this->db->select('
            master_produk_kategori.*,
        ')
        ->from('master_produk_kategori')
        ->join('master_logistik','master_produk_kategori.id = master_logistik.kategori_id')
        ->join('material_keluar','master_logistik.id = material_keluar.id_logistik')
        ->where('master_logistik.id_proyek', $proyek)
        ->where('material_keluar.kavling_id', $kavling)
        ->group_by('master_produk_kategori.id');
        return $this->db->get();
    }

    public function getMaterialKeluar($id_pro, $kavling, $jenis){
        $this->db->select('
            master_material.nama_material,
            master_produk_unit.nama_satuan,
            SUM(jml_keluar) as keluar
        ')->from('master_material')
        ->join('master_produk_unit','master_material.unit_id = master_produk_unit.id')
        ->join('master_logistik','master_material.id = master_logistik.material_id')
        ->join('material_keluar','master_logistik.id = material_keluar.id_logistik')
        ->where('master_logistik.kategori_id', $jenis)
        ->where('material_keluar.kavling_id', $kavling)
        ->where('master_logistik.id_proyek', $id_pro)
        ->group_by('master_material.id');
        return $this->db->get();
    }


}

?>