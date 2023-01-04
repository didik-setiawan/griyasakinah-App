<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proyek_model extends CI_Model{
    
    var $column_order = array('id','nama_proyek','tipe','blok',null); //set column field database for datatable orderable
    var $column_search = array('nama_proyek','tipe','blok'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('tgl_pengajuan ' => 'desc'); // default order 

    private function _get_datatables_query()
    {
		if($this->input->post('periode')) {
			$tgl = explode(" - ", $this->input->post('periode'));
			$today = date('Y-m-d');
			if($tgl[0] != $today && $tgl[1] != $today){
				$this->db->where('master_proyek.tgl_pengajuan >=', $tgl[0]);
				$this->db->where('master_proyek.tgl_pengajuan <=', $tgl[1]);
			}
		}
        
        $this->db->select('
            tbl_tipe.*,
            tbl_kavling.id_tipe as tipe_id,
            tbl_kavling.*,
            master_proyek.*,
            master_proyek_kavling.id as id_proyek_kavling,
            master_proyek_kavling.proyek_id,
        ');

        $this->db->from('tbl_tipe');
        $this->db->join('tbl_kavling', 'tbl_kavling.id_tipe = tbl_tipe.id_tipe');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');

        $this->db->join('master_proyek_kavling', 'master_proyek_kavling.kavling_id = tbl_kavling.id_kavling');
        $this->db->join('master_proyek', 'master_proyek.id = master_proyek_kavling.proyek_id');
        

        $this->db->join('db_user', 'master_proyek.user_id = db_user.id');
        $this->db->join('db_group', 'db_user.group_id = db_group.id');
        $this->db->join('store_profile', 'db_user.store_id = store_profile.id');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));
        $this->db->order_by('master_proyek.tgl_pengajuan', 'desc');
        

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

    function ajukan_proyek()
    {
        $this->_get_datatables_query();
        $this->db->group_by('master_proyek.id');
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
    }

    function buat_rab()
    {
        $this->_get_datatables_query();
        $this->db->where('master_proyek.approve',1);
        $this->db->group_by('master_proyek.id');
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
    }

    public function getLogistikKeluar(){
        $this->_get_datatables_query();
        $this->db->where('master_proyek.approve',1);
        $this->db->where('master_proyek.rab',1);
        $this->db->group_by('master_proyek.id');
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
    }

    public function listKategori($id = NULL) 
    {
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

    public function listUnit($id = NULL) 
    {
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

    public function listKavlingProyek($id  = NULL) 
    {
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
       
        if($id  != NULL) {
            $this->db->where('master_proyek_kavling.proyek_id', $id );
        }
        $query = $this->db->get();
        return $query;
        
    }

    //DropDown Rab

    public function DropdownKavlingRab($id  = NULL, $id_pro = null) 
    {

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
        // // $this->db->group_by('tbl_tipe.id_tipe');

        // if($id  != NULL) {
        //     $this->db->where('tbl_kavling.id_tipe', $id );
        // }
        // $query = $this->db->get();
        // return $query;
        
    }

    public function DropdownTipeRab($id  = NULL) 
    {
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
        // $this->db->where('tbl_kavling.id_kavling','master_proyek_kavling.kavling_id');
        $this->db->group_by('tbl_tipe.id_tipe');

        if($id  != NULL) {
            $this->db->where('tbl_kavling.id_cluster', $id );
        }
        $query = $this->db->get();
        return $query;
        
    }

    public function DropdownClusterRab($id  = NULL) 
    {
        $this->db->select('
        master_proyek_kavling.*,
        tbl_kavling.id_cluster as cluster_id, 
        tbl_perumahan.*,
        tbl_cluster.id_cluster,
        tbl_cluster.nama_cluster
        ');
        
        $this->db->from('master_proyek_kavling');
        $this->db->join('tbl_kavling', 'tbl_kavling.id_kavling = master_proyek_kavling.kavling_id');
        $this->db->join('tbl_cluster', 'tbl_cluster.id_cluster = tbl_kavling.id_cluster');

        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));
        $this->db->group_by('tbl_cluster.id_cluster');
       
        if($id  != NULL) {
            $this->db->where('master_proyek_kavling.proyek_id', $id );
        }
        $query = $this->db->get();
        return $query;
        
    }

    
    public function listKavling($id  = NULL) 
    {
        $this->db->select('
        master_proyek_kavling.*,
        tbl_kavling.*, 
        tbl_perumahan.*,
        ');
        
        $this->db->from('master_proyek_kavling');
        $this->db->join('tbl_kavling', 'tbl_kavling.id_kavling = master_proyek_kavling.kavling_id');
        $this->db->join('tbl_tipe', 'tbl_tipe.id_tipe = tbl_kavling.id_tipe');
        
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));
       
        if($id  != NULL) {
            $this->db->where('tbl_kavling.id_tipe', $id );
        }
        $query = $this->db->get();
        return $query;
    }

    public function RabKavling($id  = NULL) 
    {
        $this->db->select('
        master_proyek_kavling.kavling_id as kav_id,
        tbl_kavling.*, 
        tbl_tipe.*, 
        tbl_kavling.id_tipe as tipe_id, 
        tbl_cluster.nama_cluster,
        count(master_proyek_kavling.kavling_id) AS kav
        ');
        
        $this->db->from('master_proyek_kavling');
        $this->db->join('tbl_kavling', 'master_proyek_kavling.kavling_id = tbl_kavling.id_kavling');
        $this->db->join('tbl_tipe', 'tbl_kavling.id_tipe = tbl_tipe.id_tipe');
        $this->db->join('tbl_cluster', 'tbl_cluster.id_cluster = tbl_kavling.id_cluster');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        $this->db->group_by('tbl_tipe.id_tipe');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));
       
        if($id  != NULL) {
            $this->db->where('master_proyek_kavling.proyek_id', $id );
            // $this->db->where('tbl_kavling.id_kavling', $id );
        }
        $query = $this->db->get();
        return $query;
    }

    public function listMaterial($id  = NULL) 
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
        $this->db->order_by('master_material.created_at', 'desc');
       
        if($id  != NULL) {
            $this->db->where('master_material.id', $id );
        }
        $query = $this->db->get();
        return $query;
    }

    public function listMaterialKategori($id  = NULL) 
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
        // $this->db->order_by('master_material.created_at', 'desc');
       
        if($id  != NULL) {
            $this->db->where('master_produk_kategori.id', $id );
        }
        $query = $this->db->get();
        return $query;
    }

    public function listPengajuan($id  = NULL) 
    {
        $this->db->select('
        master_proyek.*,
        master_proyek_kavling.id as id_proyek_kavling,
        master_proyek_kavling.proyek_id,
        master_proyek_kavling.kavling_id,
        tbl_kavling.*,
        tbl_tipe.*,
        tbl_perumahan.*, 
        db_group.group_name as nama_group, 
        db_group.id as id_group, 
        store_profile.nama_lembaga as nama_lembaga,
        store_profile.id as id_lembaga,
        ');
        $this->db->from('master_proyek');
        $this->db->join('master_proyek_kavling', 'master_proyek_kavling.proyek_id = master_proyek.id');
        $this->db->join('tbl_kavling', 'tbl_kavling.id_kavling = master_proyek_kavling.kavling_id');
        $this->db->join('tbl_tipe', 'tbl_tipe.id_tipe = tbl_kavling.id_tipe');

        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');

        $this->db->join('db_user', 'master_proyek.user_id = db_user.id');
        $this->db->join('db_group', 'db_user.group_id = db_group.id');
        $this->db->join('store_profile', 'db_user.store_id = store_profile.id');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));
        $this->db->order_by('master_proyek.tgl_pengajuan', 'desc');
        // $this->db->where('master_proyek_kavling.proyek_id',$this->session->userdata('id_perumahan'));

        if ($id != NULL) {
            $this->db->where('master_proyek.id', $id);
        }
   
        $query = $this->db->get();
        return $query;
    }

    public function DropdownTipe($id  = NULL)
    {
        $this->db->select('
        tbl_tipe.*,
        tbl_perumahan.*,

        ');

        $this->db->from('tbl_tipe');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan  = tbl_tipe.id_perum');

        $this->db->where('tbl_tipe.id_perum',$this->session->userdata('id_perumahan'));

        if ($id != NULL) {
            $this->db->where('tbl_tipe.id_cluster', $id);
        }

        $query = $this->db->get();
        return $query;
    }

    public function DropdownKavling($id  = NULL)
    {
        $this->db->select('
        tbl_tipe.*,
        tbl_kavling.*,
        tbl_perumahan.*,
        ');

        $this->db->from('tbl_tipe');
        $this->db->join('tbl_kavling', 'tbl_kavling.id_tipe  = tbl_tipe.id_tipe');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan  = tbl_kavling.id_perum');

        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));
        $this->db->where('tbl_kavling.proyek', 0);

        if ($id != NULL) {
            $this->db->where('tbl_tipe.id_tipe', $id);
        }

        $query = $this->db->get();
        return $query;
    }


    public function getDetailRAB($id = NULL)
    {
        $this->db->select('
        tbl_proyek_material.*,
        tbl_proyek_material.harga as harga_satuan,

        master_proyek.nama_proyek,
        master_proyek.rab,

        tbl_proyek_material.proyek_id as id_proyek,
        tbl_proyek_material.quantity,
        tbl_proyek_material.harga as harga_mat,
        tbl_proyek_material.total as total_mat,

        master_produk_kategori.kategori_produk,
        master_material.nama_material,
        master_produk_unit.nama_satuan,

  
        tbl_tipe.*,
        tbl_cluster.id_cluster,
        tbl_cluster.nama_cluster
        ');

        $this->db->from('tbl_proyek_material');
        $this->db->join('master_proyek', 'master_proyek.id = tbl_proyek_material.proyek_id');


        $this->db->join('tbl_kavling', 'tbl_kavling.id_tipe = tbl_proyek_material.tipe_id');
        $this->db->join('tbl_cluster', 'tbl_cluster.id_cluster = tbl_kavling.id_cluster');
        $this->db->join('tbl_tipe', 'tbl_kavling.id_tipe = tbl_tipe.id_tipe');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));
        $this->db->where('tbl_kavling.proyek', 1);

        $this->db->join('master_material', 'master_material.id = tbl_proyek_material.material_id', 'left');
        $this->db->join('master_produk_unit', 'master_produk_unit.id = master_material.unit_id', 'left');

        $this->db->join('master_produk_kategori', 'master_produk_kategori.id = tbl_proyek_material.kategori_id');


        if ($id != NULL) {
            $this->db->where('tbl_proyek_material.proyek_id', $id);
        }

        $query = $this->db->get();
        return $query;
    }

    public function getDetailUpah($id = NULL)
    {
        // $this->db->select('
        //     tbl_proyek_upah.*,
        //     tbl_kavling.*,
        //     tbl_tipe.*,
        //     master_proyek.id as id_proyek,
        //     master_proyek.nama_proyek,
        //     master_proyek.approve,
        //     master_proyek.rab,
        //     tbl_cluster.id_cluster,
        //     tbl_cluster.nama_cluster
        // ');

        // $this->db->from('tbl_proyek_upah');
        // $this->db->join('master_proyek', 'master_proyek.id = tbl_proyek_upah.proyek_id');
        // // $this->db->join('tbl_kavling', 'tbl_kavling.id_kavling = tbl_proyek_upah.kavling_id');
        // $this->db->join('tbl_cluster', 'tbl_cluster.id_cluster = tbl_kavling.id_cluster');
        // $this->db->join('tbl_tipe', 'tbl_tipe.id_tipe = tbl_proyek_upah.tipe_id');
        // $this->db->join('tbl_tipe', 'tbl_kavling.id_tipe = tbl_tipe.id_tipe');
        // $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        // $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));

        // if ($id != NULL) {
        //     $this->db->where('tbl_proyek_upah.proyek_id', $id);
        // }

        // $this->db->where('tbl_proyek_upah.action', 0);

        // $query = $this->db->get();

            $id_perum = $this->session->userdata('id_perumahan');

        $q = "SELECT
                tbl_proyek_upah.*, tbl_proyek_upah.id as id_upah,
                master_proyek.*, master_proyek.id as id_proyek,
                tbl_tipe.*

                FROM 
                tbl_proyek_upah,
                master_proyek,
                tbl_tipe

                WHERE 
                master_proyek.id = tbl_proyek_upah.proyek_id AND 
                tbl_tipe.id_tipe = tbl_proyek_upah.tipe_id AND
                tbl_proyek_upah.proyek_id = $id
            ";

            $query = $this->db->query($q);

        return $query;
    }

    public function getDetailLainnya($id = NULL)
    {
        // $this->db->select('
        //     tbl_proyek_lainnya.*,
        //     tbl_kavling.*,
        //     tbl_tipe.*,
        //     master_proyek.id as id_proyek,
        //     master_proyek.nama_proyek,
        //     master_proyek.approve,
        //     master_proyek.rab,
        //     tbl_cluster.id_cluster,
        //     tbl_cluster.nama_cluster
        // ');

        // $this->db->from('tbl_proyek_lainnya');
        // $this->db->join('master_proyek', 'master_proyek.id = tbl_proyek_lainnya.proyek_id');
        // $this->db->join('tbl_kavling', 'tbl_kavling.id_kavling = tbl_proyek_lainnya.kavling_id');
        // $this->db->join('tbl_cluster', 'tbl_cluster.id_cluster = tbl_kavling.id_cluster');
        // $this->db->join('tbl_tipe', 'tbl_kavling.id_tipe = tbl_tipe.id_tipe');
        // $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        // $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));

        // if ($id != NULL) {
        //     $this->db->where('tbl_proyek_lainnya.proyek_id', $id);
        // }

        // $query = $this->db->get();
        // return $query;

        $q = "SELECT
            tbl_proyek_lainnya.* , tbl_proyek_lainnya.id as id_lainnya,
            master_proyek.*, master_proyek.id  as id_proyek,
            tbl_tipe.*
            FROM 
            tbl_proyek_lainnya,
            master_proyek,
            tbl_tipe
            WHERE
            tbl_proyek_lainnya.proyek_id = master_proyek.id AND
            tbl_proyek_lainnya.tipe_id = tbl_tipe.id_tipe AND
            tbl_proyek_lainnya.proyek_id = $id
        ";

        return $this->db->query($q);

    }

    public function getRAB($id = NULL)
    {
        $this->db->select('
        tbl_proyek_material.*,
        tbl_proyek_material.harga as harga_satuan,

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
        tbl_cluster.id_cluster,
        tbl_cluster.nama_cluster
        ');

        $this->db->from('tbl_proyek_material');
        $this->db->join('master_proyek', 'master_proyek.id = tbl_proyek_material.proyek_id');


        $this->db->join('tbl_kavling', 'tbl_kavling.id_kavling = tbl_proyek_material.kavling_id');
        $this->db->join('tbl_cluster', 'tbl_cluster.id_cluster = tbl_kavling.id_cluster');

        $this->db->join('tbl_tipe', 'tbl_kavling.id_tipe = tbl_tipe.id_tipe');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));

        $this->db->join('master_material', 'master_material.id = tbl_proyek_material.material_id', 'left');
        $this->db->join('master_produk_unit', 'master_produk_unit.id = master_material.unit_id', 'left');

        $this->db->join('master_produk_kategori', 'master_produk_kategori.id = tbl_proyek_material.kategori_id');

        if ($id != NULL) {
            $this->db->where('tbl_proyek_material.id', $id);
        }

        $query = $this->db->get();
        return $query;
    }

    public function getRABUpah($id = NULL)
    {
        // $this->db->select('
        // tbl_proyek_upah.*,
       
        // tbl_tipe.*,
        // master_proyek.id as id_proyek,
        // master_proyek.nama_proyek,
        // master_proyek.approve,
        // master_proyek.rab,
        // tbl_cluster.id_cluster,
        // tbl_cluster.nama_cluster
        // ');

        // $this->db->from('tbl_proyek_upah');
        // $this->db->join('master_proyek', 'master_proyek.id = tbl_proyek_upah.proyek_id');
        // // $this->db->join('tbl_kavling', 'tbl_kavling.id_kavling = tbl_proyek_upah.kavling_id');
        // // $this->db->join('tbl_cluster', 'tbl_cluster.id_cluster = tbl_kavling.id_cluster');
        // $this->db->join('tbl_tipe', 'tbl_proyek_upah.tipe_id = tbl_tipe.id_tipe');
        // // $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        // // $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));

        // if ($id != NULL) {
        //     $this->db->where('tbl_proyek_upah.id', $id);
        // }

        // $this->db->where('tbl_proyek_upah.action', 0);

        // $query = $this->db->get();
        // return $query;


        $q = "SELECT 
            master_proyek.*, master_proyek.id as proyek_id,
            tbl_proyek_upah.*,
            tbl_tipe.*,
            tbl_cluster.*
            FROM 
            master_proyek,
            tbl_proyek_upah,
            tbl_tipe,
            tbl_cluster
            WHERE
            master_proyek.id = tbl_proyek_upah.proyek_id AND
            tbl_proyek_upah.tipe_id = tbl_tipe.id_tipe AND
            tbl_tipe.id_cluster = tbl_cluster.id_cluster AND
            tbl_proyek_upah.id = $id
        ";

        return $this->db->query($q);

    }

    
    public function getRABLainnya($id = NULL)
    {

        $q = "SELECT 
            master_proyek.*, master_proyek.id as proyek_id,
            tbl_proyek_lainnya.*,
            tbl_tipe.*,
            tbl_cluster.*
            FROM 
            master_proyek,
            tbl_proyek_lainnya,
            tbl_tipe,
            tbl_cluster
            WHERE
            master_proyek.id = tbl_proyek_lainnya.proyek_id AND
            tbl_proyek_lainnya.tipe_id = tbl_tipe.id_tipe AND
            tbl_tipe.id_cluster = tbl_cluster.id_cluster AND
            tbl_proyek_lainnya.id = $id
        ";

        return $this->db->query($q);

        // $this->db->select('
        //     tbl_proyek_lainnya.*,
        //     tbl_kavling.*,
        //     tbl_tipe.*,
        //     master_proyek.id as id_proyek,
        //     master_proyek.nama_proyek,
        //     master_proyek.approve,
        //     master_proyek.rab,
        //     tbl_cluster.id_cluster,
        //     tbl_cluster.nama_cluster
        // ');

        // $this->db->from('tbl_proyek_lainnya');
        // $this->db->join('master_proyek', 'master_proyek.id = tbl_proyek_lainnya.proyek_id');
        // $this->db->join('tbl_kavling', 'tbl_kavling.id_kavling = tbl_proyek_lainnya.kavling_id');
        // $this->db->join('tbl_cluster', 'tbl_cluster.id_cluster = tbl_kavling.id_cluster');
        // $this->db->join('tbl_tipe', 'tbl_kavling.id_tipe = tbl_tipe.id_tipe');
        // $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        // $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));

        // if ($id != NULL) {
        //     $this->db->where('tbl_proyek_lainnya.id', $id);
        // }

        // $query = $this->db->get();
        // return $query;
    }


    public function addPengajuan($params) 
    {
        $this->db->insert('master_proyek', $params);
    }

    public function addPengajuanKavling($params) 
    {
        $this->db->insert('master_proyek_kavling', $params);
    }

    public function addMaterial($params) 
    {
        $this->db->insert('master_material', $params);
    }

    public function addRABMaterial($params) {
        $this->db->insert('tbl_proyek_material', $params);
    }

    public function editRABMaterial($id = NULL, $data = NULL) {
        $this->db->where('id', $id);
        $this->db->update('tbl_proyek_material', $data);
    }

    public function delRABMaterial($id = NULL) {
        $this->db->where('id', $id);
        $this->db->delete('tbl_proyek_material');
    }

    public function delRABUpah($id = NULL) {
        $this->db->where('id', $id);
        $this->db->delete('tbl_proyek_upah');
    }

    public function delRABLainnya($id = NULL) {
        $this->db->where('id', $id);
        $this->db->delete('tbl_proyek_lainnya');
    }

    public function ApprovePengajuan($id = NULL, $data = NULL) {
        $this->db->where('id', $id);
        $this->db->update('master_proyek', $data);
    }

    public function delPengajuan($id = NULL) {
        $this->db->where('id', $id);
        $this->db->delete('master_proyek');
    }

    public function delPengajuanKavling($id = NULL) {
        $this->db->where('proyek_id', $id);
        $this->db->delete('master_proyek_kavling');
    }

    public function addUpah($params) {
        $this->db->insert('tbl_proyek_upah', $params);
    }

    public function editRABUpah($id = NULL, $data = NULL) {
        $this->db->where('id', $id);
        $this->db->update('tbl_proyek_upah', $data);
    }

    public function edit_kavling($id = NULL, $data = NULL) {
        $this->db->where('id_kavling', $id);
        $this->db->update('tbl_kavling', $data);
    }

    public function addLainnya($params) {
        $this->db->insert('tbl_proyek_lainnya', $params);
    }

    public function editRABLainnya($id = NULL, $data = NULL) {
        $this->db->where('id', $id);
        $this->db->update('tbl_proyek_lainnya', $data);
    }

    public function KavlingCount($id  = NULL) {
        $this->db->select('
        master_proyek_kavling.*, 
        tbl_kavling.id_tipe as tipe_id, 
        tbl_kavling.*, 
        tbl_tipe.*, 
        tbl_perumahan.*,
        count(master_proyek_kavling.kavling_id) AS kav
        ');
        
        $this->db->from('master_proyek_kavling');
        $this->db->join('tbl_kavling', 'master_proyek_kavling.kavling_id = tbl_kavling.id_kavling');
        $this->db->join('tbl_tipe', 'tbl_kavling.id_tipe = tbl_tipe.id_tipe');

        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));
        // $this->db->group_by('tbl_kavling.tipe');
        if($id  != NULL) {
            $this->db->where('master_proyek_kavling.proyek_id', $id );
        }
        $query = $this->db->get();
        return $query;
    }

    public function MaterialCount($id = NULL)
    {
        $this->db->select('
            tbl_proyek_material.*,
            count(tbl_proyek_material.material_id) AS material
        ');

        $this->db->from('tbl_proyek_material');
    
        if ($id != NULL) {
            $this->db->where('tbl_proyek_material.proyek_id', $id);
        }

        $query = $this->db->get();
        return $query;
    }

    public function UpahCount($id = NULL)
    {
        $this->db->select('
            tbl_proyek_upah.*,
            count(tbl_proyek_upah.proyek_id) AS upah
        ');

        $this->db->from('tbl_proyek_upah');
    
        if ($id != NULL) {
            $this->db->where('tbl_proyek_upah.proyek_id', $id);
        }

        $this->db->where('tbl_proyek_upah.action', 0);

        $query = $this->db->get();
        return $query;
    }

    public function LainnyaCount($id = NULL)
    {
        $this->db->select('
            tbl_proyek_lainnya.*,
            count(tbl_proyek_lainnya.proyek_id) AS lainnya
        ');

        $this->db->from('tbl_proyek_lainnya');
    
        if ($id != NULL) {
            $this->db->where('tbl_proyek_lainnya.proyek_id', $id);
        }

        $query = $this->db->get();
        return $query;
    }

    public function CetakDetailRAB($id = NULL)
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
            $this->db->where('tbl_proyek_material.proyek_id', $id);
            $this->db->where('tbl_proyek_material.keluar', 1);
        }

        $query = $this->db->get();
        return $query;
    }

    public function CetakDetailBelanja($id = NULL)
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
            $this->db->where('tbl_proyek_material.proyek_id', $id);
            $this->db->where('tbl_proyek_material.belanja', 1);
        }

        $query = $this->db->get();
        return $query;
    }
    public function del_list_material($id = NULL) {
        $this->db->where('id', $id);
        $this->db->delete('master_material');
    }

    public function AllRABMat($id = NULL)
    {
        // $this->db->select('
        //     tbl_proyek_material.*
        // ');

        // $this->db->from('tbl_proyek_material');

        // $this->db->join('tbl_kavling', 'tbl_kavling.id_tipe = tbl_proyek_material.tipe_id');
        // $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        // $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));

        // if ($id != NULL) {
        //     $this->db->where('tbl_proyek_material.proyek_id', $id);
        // }

        // $query = $this->db->get();
        $query = $this->db->get_where('tbl_proyek_material',['proyek_id' => $id]);
        return $query;
    }

    public function UpahTotal($id = NULL)
    {
        $this->db->select('
            tbl_proyek_upah.*
        ');

        $this->db->from('tbl_proyek_upah');

        $this->db->join('tbl_kavling', 'tbl_kavling.id_tipe = tbl_proyek_upah.tipe_id');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));

        if ($id != NULL) {
            $this->db->where('tbl_proyek_upah.proyek_id', $id);
        }

        $query = $this->db->get();
        return $query;
    }

    public function LainnyaTotal($id = NULL)
    {
        // $this->db->select('
        //     tbl_proyek_lainnya.*
        // ');

        // $this->db->from('tbl_proyek_lainnya');

        // $this->db->join('tbl_kavling', 'tbl_kavling.id_tipe = tbl_proyek_lainnya.tipe_id');
        // $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        // $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));

        // if ($id != NULL) {
        //     $this->db->where('tbl_proyek_lainnya.proyek_id', $id);
        // }

        // $query = $this->db->get();
        $query = $this->db->get_where('tbl_proyek_lainnya',['proyek_id' => $id]);
        return $query;
    }

    public function TotalKav($id  = NULL) {
        $this->db->select('
        master_proyek_kavling.*,
        count(master_proyek_kavling.kavling_id) AS total_kav
        ');
        
        $this->db->from('master_proyek_kavling');
        $this->db->join('tbl_kavling', 'master_proyek_kavling.kavling_id = tbl_kavling.id_kavling');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan = tbl_kavling.id_perum');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));
       
        if($id  != NULL) {
            $this->db->where('master_proyek_kavling.proyek_id', $id );
        }
        $query = $this->db->get();
        return $query;
    }

    public function DropdownCluster($id  = NULL)
    {
        $this->db->select('
        tbl_cluster.*,
        tbl_kavling.*,
        tbl_perumahan.*,

        ');

        $this->db->from('tbl_cluster');
        $this->db->join('tbl_kavling', 'tbl_kavling.id_cluster  = tbl_cluster.id_cluster');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan  = tbl_kavling.id_perum');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));
        $this->db->group_by('tbl_cluster.id_cluster');

        if ($id != NULL) {
            $this->db->where('tbl_kavling.id_cluster', $id);
        }

        $query = $this->db->get();
        return $query;
    }

    public function PengajuanMaterial($id  = NULL)
    {
        $this->db->select('
        master_logistik.*,
        master_logistik.tgl_pengajuan,
        master_logistik_detail.*,
        master_supplier.*,

        master_logistik.status as status_material,

        master_material.id as id_material,
        master_material.unit_id,
        master_material.kategori_id,
        master_material.nama_material,

        master_proyek_kavling.proyek_id as idProyekKav,
        master_proyek_kavling.kavling_id,
        tbl_kavling.*,
        tbl_perumahan.*,
        master_produk_kategori.id as id_kategori, 
        master_produk_kategori.kategori_produk, 
        master_produk_unit.id as id_unit, 
        master_produk_unit.nama_satuan,
        ');

        $this->db->from('master_logistik');
        $this->db->join('master_logistik_detail', 'master_logistik_detail.logistik_id = master_logistik.id');
        $this->db->join('master_supplier', 'master_supplier.id_supplier = master_logistik_detail.supplier_id');

        $this->db->join('tbl_proyek_material', 'tbl_proyek_material.id = master_logistik.proyek_material_id');
        $this->db->join('master_proyek', 'master_proyek.id = tbl_proyek_material.proyek_id');
        
        $this->db->join('master_proyek_kavling', 'master_proyek_kavling.proyek_id = master_proyek.id');
    
        $this->db->join('tbl_kavling', 'tbl_kavling.id_kavling  = master_proyek_kavling.kavling_id');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan  = tbl_kavling.id_perum');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));
        $this->db->group_by('master_logistik.id');
    
        $this->db->join('master_material', 'master_logistik.material_id = master_material.id');
        $this->db->join('master_produk_kategori', 'master_produk_kategori.id = master_material.kategori_id');
        $this->db->join('master_produk_unit', 'master_produk_unit.id = master_material.unit_id');

        if ($id != NULL) {
            $this->db->where(' master_logistik_detail.logistik_id', $id);
        }

        $query = $this->db->get();
        return $query;

    }

    public function addPengajuan_Material($params) {
        $this->db->insert('master_logistik_detail', $params);
    }

    public function delPengajuanMaterial($id = NULL) {
        $this->db->where('id_logistik_detail', $id);
        $this->db->delete('master_logistik_detail');
    }

    public function Insidentil($id  = NULL)
    {
        $this->db->select('
        tbl_proyek_insidentil.*,
        master_proyek.nama_proyek,
        ');

        $this->db->from('tbl_proyek_insidentil');
        $this->db->join('master_proyek', 'master_proyek.id = tbl_proyek_insidentil.proyek_id');
        
        $this->db->join('master_proyek_kavling', 'master_proyek_kavling.proyek_id = master_proyek.id');
    
        $this->db->join('tbl_kavling', 'tbl_kavling.id_kavling  = master_proyek_kavling.kavling_id');
        $this->db->join('tbl_perumahan', 'tbl_perumahan.id_perumahan  = tbl_kavling.id_perum');
        $this->db->where('tbl_kavling.id_perum',$this->session->userdata('id_perumahan'));
        $this->db->group_by('tbl_proyek_insidentil.id');
    
        if ($id != NULL) {
            $this->db->where('tbl_proyek_insidentil.id', $id);
        }

        $query = $this->db->get();
        return $query;

    }

    public function addInsidentil($params) {
        $this->db->insert('tbl_proyek_insidentil', $params);
    }

    public function editInsidentil($id = NULL, $data = NULL) {
        $this->db->where('id', $id);
        $this->db->update('tbl_proyek_insidentil', $data);
    }

    public function delInsidentil($id = NULL) {
        $this->db->where('id', $id);
        $this->db->delete('tbl_proyek_insidentil');
    }






    public function getProgres($filter = null){

        if($filter == null){
            $q = "SELECT 
                master_proyek.*, master_proyek.id as id_proyek,
                tbl_proyek_upah.*, tbl_proyek_upah.id as id_upah,
                tbl_tipe.*
                FROM
                master_proyek,
                tbl_proyek_upah,
                tbl_tipe
                WHERE
                master_proyek.id = tbl_proyek_upah.proyek_id AND
                tbl_tipe.id_tipe = tbl_proyek_upah.tipe_id AND
                master_proyek.rab = 1 
            ";
        } else {
            $q = "SELECT 
                master_proyek.*, master_proyek.id as id_proyek,
                tbl_proyek_upah.*, tbl_proyek_upah.id as id_upah,
                tbl_tipe.*
                FROM
                master_proyek,
                tbl_proyek_upah,
                tbl_tipe
                WHERE
                master_proyek.id = tbl_proyek_upah.proyek_id AND
                tbl_tipe.id_tipe = tbl_proyek_upah.tipe_id AND
                master_proyek.rab = 1 AND
                master_proyek.id = $filter AND
                master_proyek.end = 1
            ";
        }

        
        return $this->db->query($q)->result();
    }

    public function getKavlingByProyek(){
        $id_perum = $this->session->userdata('id_perumahan');
        $q = "SELECT
            master_proyek.*, master_proyek.id as id_proyek,
            tbl_proyek_upah.*, tbl_proyek_upah.id as id_upah,
            tbl_tipe.*,
            tbl_kavling.*,
            master_proyek_kavling.*
            FROM
            master_proyek,
            tbl_proyek_upah,
            tbl_tipe,
            tbl_kavling,
            master_proyek_kavling
            WHERE
            master_proyek.id = tbl_proyek_upah.proyek_id AND
            tbl_tipe.id_tipe = tbl_proyek_upah.tipe_id AND
            master_proyek.rab = 1 AND 
            tbl_kavling.id_tipe = tbl_tipe.id_tipe AND
            tbl_kavling.id_kavling = master_proyek_kavling.kavling_id AND
            tbl_kavling.id_perum = $id_perum
        ";
        return $this->db->query($q)->result();
    }

    public function getDetailProgres($upah, $blok){
        $q = "SELECT * FROM tbl_proyek_upah JOIN progres_pembangunan ON tbl_proyek_upah.id = progres_pembangunan.upah_id WHERE tbl_proyek_upah.id = $upah AND progres_pembangunan.kavling_id = $blok";
        return $this->db->query($q)->result();
    }

    public function countTotal($upah, $blok){
        $q = "SELECT SUM(total) as total_akhir FROM progres_pembangunan WHERE upah_id = $upah AND kavling_id = $blok AND status = 3";
        return $this->db->query($q)->row()->total_akhir;
    }

    public function add_progres($data){
        return $this->db->insert('progres_pembangunan', $data);
    }

    public function delete_progres($id){
        $progres = $this->db->get_where('progres_pembangunan',['id_progres' => $id])->row();

        unlink(FCPATH.'assets/upload/progres/'. $progres->foto);

        return $this->db->delete('progres_pembangunan',['id_progres' => $id]);

    }

    public function edit_progres($data, $id){
        return $this->db->where('id_progres', $id)->update('progres_pembangunan', $data);
    }

    public function get_progres_id($id){
        return $this->db->get_where('progres_pembangunan',['id_progres' => $id])->row();
    }

    public function getKavlingRAB($id){
        $id_perum = $this->session->userdata('id_perumahan');

        $q = "SELECT
            master_proyek.*, master_proyek.id as id_proyek,
            master_proyek_kavling.*,
            tbl_kavling.*
            FROM 
            master_proyek,
            master_proyek_kavling,
            tbl_kavling
            WHERE 
            master_proyek.id = master_proyek_kavling.proyek_id AND
            master_proyek_kavling.kavling_id = tbl_kavling.id_kavling AND
            tbl_kavling.id_perum = $id_perum AND
            master_proyek.id = $id
        ";

        return $this->db->query($q)->result();

    }

    public function ended_proyek($data, $id){
        $this->db->where('id', $id)->update('master_proyek', $data);
    }

    public function get_material_by_proyek($id){
        $q = "SELECT 
            tbl_proyek_material.*,
            master_material.nama_material,
            master_produk_unit.nama_satuan
            FROM
            tbl_proyek_material,
            master_material,
            master_produk_unit
            WHERE
            tbl_proyek_material.material_id = master_material.id AND
            master_material.unit_id = master_produk_unit.id AND
            tbl_proyek_material.proyek_id = $id
        ";
        return $this->db->query($q)->result();
    }

    public function get_total_material($id){
        $q = "SELECT SUM(total) as total FROM tbl_proyek_material WHERE proyek_id = $id";
        return $this->db->query($q)->row()->total;
    }

    public function get_upah_by_proyek($id){
        $q = "SELECT * FROM tbl_proyek_upah JOIN tbl_tipe ON tbl_proyek_upah.tipe_id = tbl_tipe.id_tipe WHERE tbl_proyek_upah.proyek_id = $id";
        return $this->db->query($q)->result();
    }

    public function get_detail_upah_proyek($id){
        $q ="SELECT 
            tbl_proyek_upah.*, tbl_proyek_upah.id as id_upah,
            master_proyek_kavling.*,
            tbl_kavling.*
            FROM
            tbl_proyek_upah,
            master_proyek_kavling,
            tbl_kavling
            WHERE
            tbl_proyek_upah.proyek_id = master_proyek_kavling.proyek_id AND
            master_proyek_kavling.kavling_id = tbl_kavling.id_kavling AND
            tbl_proyek_upah.proyek_id = $id AND
            tbl_kavling.id_tipe = tbl_proyek_upah.tipe_id
        ";
        return $this->db->query($q)->result();
    }

    public function get_total_detail_upah($id){
        $q = "SELECT SUM(total) as total FROM progres_pembangunan JOIN tbl_proyek_upah ON progres_pembangunan.upah_id = tbl_proyek_upah.id WHERE tbl_proyek_upah.proyek_id = $id";
        return $this->db->query($q)->row()->total;
    }

    public function get_Lain_proyek($id){
        $q = "SELECT * FROM tbl_proyek_lainnya JOIN tbl_tipe ON tbl_proyek_lainnya.tipe_id = tbl_tipe.id_tipe WHERE proyek_id = $id GROUP BY tbl_tipe.tipe";
        return $this->db->query($q)->result();
    }






    // 9 Agust 2022
    public function getProyekForFIlter(){
        $id_perum = $this->session->userdata('id_perumahan');
        $q = "SELECT
            master_proyek.*, master_proyek.id as id_proyek,
            tbl_proyek_upah.*, tbl_proyek_upah.id as id_upah,
            tbl_tipe.*,
            tbl_kavling.*,
            master_proyek_kavling.*
            FROM
            master_proyek,
            tbl_proyek_upah,
            tbl_tipe,
            tbl_kavling,
            master_proyek_kavling
            WHERE
            master_proyek.id = tbl_proyek_upah.proyek_id AND
            tbl_tipe.id_tipe = tbl_proyek_upah.tipe_id AND
            master_proyek.rab = 1 AND 
            tbl_kavling.id_tipe = tbl_tipe.id_tipe AND
            tbl_kavling.id_kavling = master_proyek_kavling.kavling_id AND
            tbl_kavling.id_perum = $id_perum
            GROUP BY master_proyek.nama_proyek
        ";
        return $this->db->query($q)->result();
    }

    public function getHargaKontrakForFilter($id_upah, $id_blok){
        $q = "SELECT * FROM
            tbl_proyek_upah,
            master_proyek_kavling,
            tbl_kavling
            WHERE
            tbl_proyek_upah.id = $id_upah AND
            tbl_proyek_upah.proyek_id = master_proyek_kavling.proyek_id AND
            master_proyek_kavling.kavling_id = tbl_kavling.id_kavling AND
            tbl_kavling.id_tipe = tbl_proyek_upah.tipe_id AND
            tbl_kavling.id_kavling = $id_blok
        ";
        return $this->db->query($q)->row()->harga_kontrak;
    }
  




    //5-9-2022

    public function getRABMaterialByPerum($id_perum){

        $q = "SELECT 
            tbl_proyek_material.*,
            tbl_proyek_material.created_at AS tgl_rab_material,
            master_material.nama_material,
            master_produk_kategori.kategori_produk,
            master_produk_unit.nama_satuan,
            master_proyek.nama_proyek,
            tbl_tipe.tipe

            FROM 
            tbl_proyek_material,
            master_material,
            master_produk_kategori,
            master_produk_unit,
            master_proyek,
            tbl_tipe

            WHERE
            tbl_proyek_material.material_id = master_material.id AND
            master_material.kategori_id = master_produk_kategori.id AND
            master_material.unit_id = master_produk_unit.id AND
            tbl_proyek_material.proyek_id = master_proyek.id AND 
            master_proyek.rab = 1 AND
            tbl_proyek_material.tipe_id = tbl_tipe.id_tipe AND
            tbl_tipe.id_perum = $id_perum
        ";

        return $this->db->query($q)->result();

    }

    public function detailRABMaterialID($id){
        $q = "SELECT 
            tbl_proyek_material.*,
            tbl_proyek_material.proyek_id as id_proyek,
            master_proyek.nama_proyek,
            tbl_tipe.*,
            tbl_cluster.nama_cluster,
            tbl_perumahan.*

            FROM
            tbl_proyek_material,
            master_proyek,
            tbl_tipe,
            tbl_cluster,
            tbl_perumahan

            WHERE
            tbl_proyek_material.id = $id AND
            tbl_proyek_material.proyek_id = master_proyek.id AND
            tbl_proyek_material.tipe_id = tbl_tipe.id_tipe AND
            tbl_tipe.id_cluster = tbl_cluster.id_cluster AND
            tbl_tipe.id_perum = tbl_perumahan.id_perumahan
        ";

        return $this->db->query($q)->row();

    }

    public function getRABUpahByPerum($id_perum){
        $q = "SELECT 
            tbl_proyek_upah.*,
            tbl_proyek_upah.created_at as tgl_upah,
            tbl_proyek_upah.status as status_upah,
            tbl_proyek_upah.id as id_upah,
            tbl_tipe.*,
            master_proyek.*
            
            FROM 
            tbl_proyek_upah,
            tbl_tipe,
            master_proyek

            WHERE 
            tbl_proyek_upah.proyek_id = master_proyek.id AND
            tbl_proyek_upah.tipe_id = tbl_tipe.id_tipe AND
            master_proyek.rab = 1 AND
            tbl_tipe.id_perum = $id_perum
        ";

        return $this->db->query($q)->result();
    }

    public function detailRABUpahID($id){
        $q = "SELECT 
            tbl_proyek_upah.*,
            tbl_proyek_upah.proyek_id as id_proyek,
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

    public function getRABLainByPerum($id_perum){
        $q = "SELECT 
            tbl_proyek_lainnya.*,
            tbl_proyek_lainnya.status as status_lain,
            tbl_proyek_lainnya.id as id_lain,
            tbl_tipe.*,
            master_proyek.*

            FROM 
            tbl_proyek_lainnya,
            tbl_tipe,
            master_proyek

            WHERE
            tbl_proyek_lainnya.proyek_id = master_proyek.id AND
            tbl_proyek_lainnya.tipe_id = tbl_tipe.id_tipe AND
            tbl_tipe.id_perum = $id_perum AND
            master_proyek.rab = 1
        ";

        return $this->db->query($q)->result();
    }


    public function detailRABLain($id){
        $q = "SELECT 
            tbl_proyek_lainnya.*,
            tbl_proyek_lainnya.proyek_id as id_proyek,
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



    //7-9-2022

    public function getPengajuanMaterial($id_perum){
        $q = "SELECT
            master_logistik.*,
            master_logistik.id as id_logistik,
            master_logistik_detail.*,
            master_logistik_detail.status as status_real,
            tbl_proyek_material.*,
            master_material.nama_material,
            master_produk_kategori.kategori_produk,
            master_produk_unit.nama_satuan,
            tbl_tipe.*

            FROM
            master_logistik,
            master_logistik_detail,
            tbl_proyek_material,
            master_material,
            master_produk_kategori,
            master_produk_unit,
            tbl_tipe

            WHERE
            master_logistik.id = master_logistik_detail.logistik_id AND
            master_logistik.proyek_material_id = tbl_proyek_material.id AND
            tbl_proyek_material.material_id = master_material.id AND
            master_material.kategori_id = master_produk_kategori.id AND
            master_material.unit_id = master_produk_unit.id AND
            tbl_proyek_material.tipe_id = tbl_tipe.id_tipe AND
            tbl_tipe.id_perum = $id_perum
        ";

        return $this->db->query($q)->result();
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



    //8-9-2022

    public function getPembebasanLahan($id_perum){
        $q = "SELECT * FROM cicil_pembebasan_lahan JOIN pembebasan_lahan ON cicil_pembebasan_lahan.id_pembebasan = pembebasan_lahan.id_pembebasan WHERE pembebasan_lahan.id_perumahan = $id_perum ORDER BY cicil_pembebasan_lahan.tgl_bayar DESC";
        return $this->db->query($q)->result();
    }

    public function getUserBank($id){
        $q = "SELECT 
            tbl_transaksi_bank.*,
            tbl_marketing.*,
            tbl_marketing.title_kode as fee_kode,
            tbl_kavling.*,
            cicil_fee_marketing.jumlah as jml_cicil

            FROM
            tbl_transaksi_bank,
            tbl_marketing,
            tbl_kavling,
            cicil_fee_marketing

            WHERE 
            tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND
            tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND
            tbl_marketing.id_marketing = cicil_fee_marketing.id_marketing AND 
            cicil_fee_marketing.id_cicil = $id
        ";

        return $this->db->query($q)->row();
    }


    public function getUserInhouse($id){
        $q = "SELECT 
            tbl_transaksi_inhouse.*,
            tbl_marketing.*,
            tbl_kavling.*,
            cicil_fee_marketing.jumlah as jml_cicil

            FROM
            tbl_transaksi_inhouse,
            tbl_marketing,
            tbl_kavling,
            cicil_fee_marketing

            WHERE 
            tbl_transaksi_inhouse.id_konsumen = tbl_marketing.id_marketing AND
            tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND
            cicil_fee_marketing.id_cicil = $id AND
            tbl_marketing.id_marketing = cicil_fee_marketing.id_marketing
        ";

        return $this->db->query($q)->row();
    }

    public function getProgresIDforApprove($id){
        $q = "SELECT * FROM progres_pembangunan JOIN tbl_kavling ON progres_pembangunan.kavling_id = tbl_kavling.id_kavling WHERE progres_pembangunan.id_progres = $id";
        return $this->db->query($q)->row();
    }

    public function getPembebasanLahanforApprove($id){
        $q = "SELECT * FROM cicil_pembebasan_lahan JOIN pembebasan_lahan ON cicil_pembebasan_lahan.id_pembebasan = pembebasan_lahan.id_pembebasan WHERE cicil_pembebasan_lahan.id_cicil = $id";
        return $this->db->query($q)->row();
    }

    public function countJmlKavProyek($id_pro, $id_tipe){
        $q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $id_pro AND tbl_kavling.id_tipe = $id_tipe";
        return $this->db->query($q)->num_rows();
    }


    public function getpengajuanMaterialforApprove($id){
       $q = "SELECT 
        master_logistik_detail.harga_real,
        master_logistik_detail.title_kode,
        master_logistik.jml_pengajuan,
        tbl_tipe.id_perum,
        tbl_proyek_material.proyek_id

        FROM
        master_logistik_detail,
        master_logistik,
        tbl_tipe,
        tbl_proyek_material

        WHERE
        master_logistik.id = $id AND
        master_logistik_detail.logistik_id = master_logistik.id AND
        master_logistik.proyek_material_id = tbl_proyek_material.id AND
        tbl_proyek_material.tipe_id = tbl_tipe.id_tipe
       ";
        return $this->db->query($q)->row();
    }

    public function get_tipe_detail_rab_ajax($id_proyek){
        $q = "SELECT 
            master_proyek_kavling.proyek_id,
            tbl_kavling.id_tipe,
            tbl_tipe.tipe

            FROM master_proyek_kavling, tbl_kavling, tbl_tipe
            WHERE
            master_proyek_kavling.proyek_id = $id_proyek AND
            master_proyek_kavling.kavling_id = tbl_kavling.id_kavling AND
            tbl_kavling.id_tipe = tbl_tipe.id_tipe
            GROUP BY tbl_kavling.id_tipe
        ";   
        return $this->db->query($q)->result();
    }

    public function get_jenis_material_ajax_detail($id_tipe, $id_proyek){
        $q = "SELECT 
            tbl_proyek_material.kategori_id,
            master_produk_kategori.kategori_produk,
            master_proyek_kavling.kavling_id,
            tbl_kavling.*
            FROM tbl_proyek_material, master_produk_kategori, master_proyek_kavling, tbl_kavling
            WHERE tbl_proyek_material.tipe_id = $id_tipe AND
            tbl_proyek_material.proyek_id = $id_proyek AND
            tbl_proyek_material.kategori_id = master_produk_kategori.id AND
            tbl_proyek_material.proyek_id = master_proyek_kavling.proyek_id AND 
            master_proyek_kavling.kavling_id = tbl_kavling.id_kavling
            GROUP BY master_produk_kategori.id
        ";
        return $this->db->query($q);
    }

    public function get_jml_material_ajax_detail($id_tipe, $id_proyek){
        return $this->db->get_where('tbl_proyek_material',['proyek_id' => $id_proyek, 'tipe_id' => $id_tipe])->num_rows();
    }

    public function get_jml_material_ajax_detail_material($id_tipe, $id_proyek, $id_kategori){
        $q = "SELECT
            tbl_proyek_material.*,
            master_material.*,
            master_produk_unit.*
            FROM
            tbl_proyek_material,
            master_material,
            master_produk_unit
            WHERE
            tbl_proyek_material.proyek_id = $id_proyek AND
            tbl_proyek_material.tipe_id = $id_tipe AND
            tbl_proyek_material.kategori_id = $id_kategori AND
            tbl_proyek_material.material_id = master_material.id AND
            master_material.unit_id = master_produk_unit.id
        ";
        return $this->db->query($q);
    }

    public function get_total_per_jenis_ajax_detail_material($id_tipe, $id_proyek, $id_kategori){
        $q = "SELECT SUM(total) AS total_all FROM tbl_proyek_material WHERE proyek_id = $id_proyek AND tipe_id = $id_tipe AND kategori_id = $id_kategori";

        return $this->db->query($q)->row()->total_all;
    }

    public function get_blok_ajax_detail($id_tipe, $id_proyek){
        $q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $id_proyek AND tbl_kavling.id_tipe = $id_tipe";
        return $this->db->query($q);
    }

    public function get_upah_ajax_detail($id_tipe, $id_proyek){
        return $this->db->get_where('tbl_proyek_upah',['proyek_id' => $id_proyek, 'tipe_id' => $id_tipe])->result();
    }


    public function get_lainnya_ajax_detail($id_tipe, $id_proyek){
        return $this->db->get_where('tbl_proyek_lainnya',['proyek_id' => $id_proyek, 'tipe_id' => $id_tipe])->result();
    }

    public function get_total_material_ajax_detail($id_proyek){
        $q = "SELECT SUM(total) AS jml_material FROM tbl_proyek_material WHERE proyek_id = $id_proyek";
        return $this->db->query($q)->row()->jml_material;
    }

  public function get_pengajuan_material_all($id_proyek){
    if(isset($id_proyek)){
        $q = "SELECT
            master_logistik.*,
            master_logistik.id as logistik_id,
            tbl_proyek_material.proyek_id,
            tbl_proyek_material.harga,
            master_produk_kategori.kategori_produk,
            master_material.nama_material,
            master_produk_unit.nama_satuan,
            master_proyek.nama_proyek
            FROM
            master_logistik,
            tbl_proyek_material,
            master_produk_kategori,
            master_material,
            master_produk_unit,
            master_proyek
            WHERE
            master_logistik.proyek_material_id = tbl_proyek_material.id AND 
            master_logistik.kategori_id = master_produk_kategori.id AND
            master_logistik.material_id = master_material.id AND
            master_material.unit_id = master_produk_unit.id AND 
            tbl_proyek_material.proyek_id = master_proyek.id AND
            tbl_proyek_material.proyek_id = $id_proyek
        ";
    } else {
        $q = "SELECT
            master_logistik.*,
            master_logistik.id as logistik_id,
            tbl_proyek_material.proyek_id,
            tbl_proyek_material.harga,
            master_produk_kategori.kategori_produk,
            master_material.nama_material,
            master_produk_unit.nama_satuan,
            master_proyek.nama_proyek
            FROM
            master_logistik,
            tbl_proyek_material,
            master_produk_kategori,
            master_material,
            master_produk_unit,
            master_proyek
            WHERE
            master_logistik.proyek_material_id = tbl_proyek_material.id AND 
            master_logistik.kategori_id = master_produk_kategori.id AND
            master_logistik.material_id = master_material.id AND
            master_material.unit_id = master_produk_unit.id AND 
            tbl_proyek_material.proyek_id = master_proyek.id
        ";
    }
    return $this->db->query($q)->result();
  }

  public function getLogistikSelectID($id_logistik){
        $q = "SELECT
            master_logistik.*,
            master_logistik.id as logistik_id,
            tbl_proyek_material.proyek_id,
            master_produk_kategori.kategori_produk,
            master_material.nama_material,
            master_produk_unit.nama_satuan,
            master_proyek.nama_proyek,
            master_logistik_detail.harga_real
            FROM
            master_logistik,
            tbl_proyek_material,
            master_produk_kategori,
            master_material,
            master_produk_unit,
            master_proyek,
            master_logistik_detail
            WHERE
            master_logistik.proyek_material_id = tbl_proyek_material.id AND 
            master_logistik.kategori_id = master_produk_kategori.id AND
            master_logistik.material_id = master_material.id AND
            master_material.unit_id = master_produk_unit.id AND 
            tbl_proyek_material.proyek_id = master_proyek.id AND
            master_logistik.id = $id_logistik AND
            master_logistik_detail.logistik_id = master_logistik.id
        ";
    return $this->db->query($q)->row();
  }

  public function getRealMaterialril($id_logistik){
        $q = "SELECT
            master_logistik.*,
            master_logistik.id as logistik_id,
            tbl_proyek_material.proyek_id,
            tbl_proyek_material.harga,
            master_produk_kategori.kategori_produk,
            master_material.nama_material,
            master_produk_unit.nama_satuan,
            master_proyek.nama_proyek
            FROM
            master_logistik,
            tbl_proyek_material,
            master_produk_kategori,
            master_material,
            master_produk_unit,
            master_proyek
            WHERE
            master_logistik.proyek_material_id = tbl_proyek_material.id AND 
            master_logistik.kategori_id = master_produk_kategori.id AND
            master_logistik.material_id = master_material.id AND
            master_material.unit_id = master_produk_unit.id AND 
            tbl_proyek_material.proyek_id = master_proyek.id AND
            master_logistik.id != $id_logistik
        ";
        return $this->db->query($q)->result();
  }

    public function loadMaterialReady($id_proyek = null){
        $status1 = array(1,2);
        $status2 = array(3);
        $this->db->select('master_logistik.*,
            master_logistik.id as logistik_id,
            master_logistik_detail.harga_real,
            tbl_proyek_material.proyek_id,
            master_produk_kategori.kategori_produk,
            master_material.nama_material,
            master_produk_unit.nama_satuan,
            master_proyek.nama_proyek
        ')
        ->from('master_logistik')
        ->join('master_logistik_detail','master_logistik.id = master_logistik_detail.logistik_id')
        ->join('tbl_proyek_material','master_logistik.proyek_material_id = tbl_proyek_material.id')
        ->join('master_produk_kategori','tbl_proyek_material.kategori_id = master_produk_kategori.id')
        ->join('master_material','tbl_proyek_material.material_id = master_material.id')
        ->join('master_produk_unit','master_material.unit_id = master_produk_unit.id')
        ->join('master_proyek','tbl_proyek_material.proyek_id = master_proyek.id')
        ->where_in('master_logistik.status', $status1)
        ->where_in('master_logistik_detail.status', $status2);
        if(isset($id_proyek)){
            $this->db->where('tbl_proyek_material.proyek_id', $id_proyek);
        }
        $query = $this->db->get()->result();
        return $query;
    }

    public function getDataMandor($proyek, $blok){
        $q = "SELECT * FROM mandor_proyek JOIN master_mandor ON mandor_proyek.id_mandor = master_mandor.id_mandor Where mandor_proyek.id_proyek_upah = $proyek AND mandor_proyek.id_blok = $blok";
        return $this->db->query($q)->row();
    }

    public function getSupplierJoinPengajuan($id){
        $this->db->select('pengajuan_material.supplier, master_supplier.*')
        ->from('pengajuan_material')
        ->join('master_supplier', 'pengajuan_material.supplier = master_supplier.id_supplier')
        ->where('pengajuan_material.id_pengajuan', $id);
        return $this->db->get()->row();
    }

}

?>