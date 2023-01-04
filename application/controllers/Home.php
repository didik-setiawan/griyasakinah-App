<?php
defined('BASEPATH')or exit('No direct script access allowed');
class Home extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Master_model','master');
        checkLoginGagal();
    }

    public function index(){
        $data = [
            'view' => 'home/index',
            'perum' => $this->db->get('tbl_perumahan')->result()
        ];
        $this->load->view('home/template', $data);
    }


    //master perumahan
    public function perumahan(){
        $data = [
            'view' => 'home/perum',
            'perum' => $this->db->get('tbl_perumahan')->result()
        ];
        $this->load->view('home/template', $data);
    }


    //master kode
    public function kode(){
        $data = [
            'view' => 'home/kode',
            'kode' => $this->db->get('kode')->result()
        ];
        $this->load->view('home/template', $data);
    }

    public function detail_kode($id = null){
        $q = "SELECT * FROM title_kode JOIN sub_kode ON title_kode.id_sub = sub_kode.id_sub WHERE sub_kode.id_kode = $id";
        $data = [
            'view' => 'home/detail_kode',
            'kode' => $this->db->get_where('kode',['id_kode' => $id])->row(),
            'sub_kode' => $this->db->get_where('sub_kode',['id_kode' => $id])->result(),
            'title_kode' => $this->db->query($q)->result()
        ];
        $this->load->view('home/template', $data);
    }



    //master group
    public function group(){
        $data = [
            'view' => 'home/group',
            'group' => $this->db->get_where('db_group',['active' => 0])->result()
        ];
        $this->load->view('home/template', $data);
    }



    //master user

    public function user(){
        $data = [
            'view' => 'home/user',
            'user' => $this->master->selectUsers(NULL, NULL, NULL, 1)->result(),
            'group' => $this->master_model->select_group()->result(),
            'perum' => $this->db->get('tbl_perumahan')->result()
        ];
        $this->load->view('home/template', $data);
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect(site_url());
    }


}