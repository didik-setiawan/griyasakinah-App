<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perumahan_model extends CI_Model{

    public function selectPerumahan($id = null, $group = NULL, $email = NULL, $active = NULL) {
        $this->db->select('*');
        $this->db->from('tbl_perumahan');

        if($id != null) {
            $this->db->where('tbl_perumahan.id_perumahan', $id);
        }
       
        $this->db->order_by('tbl_perumahan.id_perumahan', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function getAccessMenu1($type, $group_id){
        $q = "SELECT * FROM menu JOIN menu_access ON menu.id_menu = menu_access.id_menu WHERE menu.type = $type AND menu_access.id_group = $group_id";
        return $this->db->query($q)->result();
    }

    public function getAccessMenu2($type, $parent, $group_id){
        $q = "SELECT * FROM menu JOIN menu_access ON menu.id_menu = menu_access.id_menu WHERE menu.type = $type AND menu_access.id_group = $group_id AND menu.parent = $parent";
        return $this->db->query($q)->result();
    }
	

  

}

?>