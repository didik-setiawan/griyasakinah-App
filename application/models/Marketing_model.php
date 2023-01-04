<?php
defined('BASEPATH')or exit('No direct script access allowed');
class Marketing_model extends CI_Controller{
    public function get_calon_konsumen_all(){
        return $this->db->order_by('nama','ASC')->get('tbl_marketing')->result();
    }

    public function add_calon_konsumen($data){
        return $this->db->insert('tbl_marketing', $data);
    }

}