<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_database extends CI_Controller {
    function __construct() {
        parent::__construct();
        // checkLogin();
        checkLoginGagal();
        $this->load->model(masterModel());
        $this->load->library('fungsi');
        $this->load->library('form_validation');

    }

    public function index() {
        checkUserLogin();
        $this->template->load('template', 'master/product');
    }

    // awal ketegori 
    public function product_category() {
        checkUserLogin();
        $this->template->load('template', 'master/produk_kategori');
    }

    public function product_category_add() {
        $post = $this->input->post(null, TRUE);
        $this->database_model->product_category_add($post);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata('kategori_add', 'Data Berhasil ditambahkan');
            redirect('master_database/product_category');
        }
    }
    
    public function product_category_del() {
        $post = $this->input->post(null, TRUE);
        $this->database_model->product_category_del($post);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata('kategori_del', 'Data Berhasil dihapus');
            redirect('master_database/product_category');
        }
    }

    public function product_category_edit() {
        $post = $this->input->post(null, TRUE);
        $this->database_model->product_category_edit($post);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata('kategori_edit', 'Data berhasil di update');
            redirect('master_database/product_category');
        }
    }
    // akhir kategori

    // awal unit 
    public function product_unit_add() {
        $post = $this->input->post(null, TRUE);
        $this->database_model->product_unit_add($post);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata('unit_add', 'Data Berhasil ditambahkan');
            redirect('master_database/product_category');
        }
    }

    public function product_unit_edit() {
        $post = $this->input->post(null, TRUE);
        $this->database_model->product_unit_edit($post);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata('unit_edit', 'Data berhasil di update');
            redirect('master_database/product_category');
        }
    }

    public function product_unit_del() {
        $post = $this->input->post(null, TRUE);
        $this->database_model->product_unit_del($post);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata('unit_del', 'Data Berhasil dihapus');
            redirect('master_database/product_category');
        }
    }
    // akhir unit 

    // awal customer 
    public function customer() {
        checkUserLogin();
        $this->template->load('template', 'master/customer');
    }
    
    public function customer_add() {
        $customer = new stdClass();
        $customer->id = NULL;
        $customer->nama_customer = NULL;
        $customer->nama_perusahaan = NULL;
        $customer->telp = NULL;
        $customer->email_customer = NULL;
        $customer->alamat = NULL;
        $customer->keterangan = NULL;
        // contoh load data agar tidak perlu load di view
        // $kategori = $this->database_model->product_category();
        $data = array(
            // '$kategori' => $kategori,
            // nanti panggilnya nya : $kategori->nama_fieldnya
            'page'  => 'add',
            'tombol'  => 'Create',
            'judul'  => 'Create New Customer!',
            'row'   => $customer
        );
        $this->template->load('template', 'master/customer_form', $data);
    }

    public function customer_edit($id = NULL) {
        if($id != NULL) {
            $query = $this->database_model->customer_list($id);
            if($query->num_rows() > 0) {
                $customer = $query->row();
                $data = array(
                    'page'  => 'edit',
                    'tombol'  => 'Update',
                    'judul'  => 'Update data Customer',
                    'row'   => $customer
                );
                $this->template->load('template', 'master/customer_form', $data);
            }else{
                echo "<script>alert('Data tidak ditemukan');</script>";
                echo "<script>window.location='".site_url('master_database/customer/')."';</script>";
            }
        } else {
            redirect('master_database/customer');
        }
        
    }

    public function customer_del($id = NULL) {
        if($id != NULL) {
            $this->database_model->customer_del($id);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('customer_del', 'Data Berhasil dihapus');
            }
            redirect('master_database/customer');
        }else{
            redirect('master_database/customer');
        }
    }

    public function customer_proses() {
        $post = $this->input->post(null, TRUE);
        if(isset($_POST['add'])){
            $this->database_model->customer_add($post);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('customer_add', 'Data Berhasil ditambah');
                redirect('master_database/customer');
            }
        } elseif(isset($_POST['edit'])){
            $this->database_model->customer_edit($post);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('customer_edit', 'Data Berhasil diupdate');
                redirect('master_database/customer');
            }
        }
    }
    // akhir customer 

    // awal supplier 
    public function supplier() {
        checkUserLogin();
        $this->template->load('template', 'master/supplier');
    }

    public function supplier_add() {
        $supplier = new stdClass();
        $supplier->id = NULL;
        $supplier->kontak_person = NULL;
        $supplier->nama_perusahaan = NULL;
        $supplier->telp = NULL;
        $supplier->email_supplier = NULL;
        $supplier->alamat = NULL;
        $supplier->keterangan = NULL;
        $data = array(
            'page'  => 'add',
            'tombol'  => 'Create',
            'judul'  => 'Create New Supplier!',
            'row'   => $supplier
        );
        $this->template->load('template', 'master/supplier_form', $data);
    }

    public function supplier_edit($id = NULL) {
        if($id != NULL) {
            $query = $this->database_model->supplier_list($id);
            if($query->num_rows() > 0) {
                $supplier = $query->row();
                $data = array(
                    'page'  => 'edit',
                    'tombol'  => 'Update',
                    'judul'  => 'Update data Supplier',
                    'row'   => $supplier
                );
                $this->template->load('template', 'master/supplier_form', $data);
            }else{
                echo "<script>alert('Data tidak ditemukan');</script>";
                echo "<script>window.location='".site_url('master_database/supplier/')."';</script>";
            }
        } else {
            redirect('master_database/supplier');
        }
        
    }

    public function supplier_del($id = NULL) {
        if($id != NULL) {
            $this->database_model->supplier_del($id);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('supplier_del', 'Data Berhasil dihapus');
            }
            redirect('master_database/supplier');
        }else{
            redirect('master_database/supplier');
        }
    }

    public function supplier_proses() {
        $post = $this->input->post(null, TRUE);
        if(isset($_POST['add'])){

            $this->database_model->supplier_add($post);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('supplier_add', 'Data Berhasil ditambah');
                redirect('master_database/supplier');
            }
        } elseif(isset($_POST['edit'])){
            $this->database_model->supplier_edit($post);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('supplier_edit', 'Data Berhasil diupdate');
                redirect('master_database/supplier');
            }
        }
    }
    // akhir supplier 

    // awal sales 
    public function sales() {
        checkUserLogin();
        $this->template->load('template', 'master/sales');
    }

    public function sales_add() {
        $sales = new stdClass();
        $sales->id = NULL;
        $sales->nama_sales = NULL;
        $sales->email_sales = NULL;
        $sales->nomor_hp = NULL;
        $sales->tempat_lahir = NULL;
        $sales->tanggal_lahir = NULL;
        $sales->usia = NULL;
        $sales->photo = NULL;
        $sales->diskon_store = NULL;
        $sales->diskon_select = NULL;
        $sales->pajak = NULL;
        $sales->alamat = NULL;
        $sales->keterangan = NULL;
        $data = array(
            'page'  => 'add',
            'tombol'  => 'Create',
            'judul'  => 'Create New Sales!',
            'row'   => $sales
        );
        $this->template->load('template', 'master/sales_form', $data);
    }

    public function sales_edit($id = NULL) {
        if($id != NULL) {
            $query = $this->database_model->sales_list($id);
            if($query->num_rows() > 0) {
                $sales = $query->row();
                $data = array(
                    'page'  => 'edit',
                    'tombol'  => 'Update',
                    'judul'  => 'Update data Sales',
                    'row'   => $sales
                );
                $this->template->load('template', 'master/sales_form', $data);
            }else{
                echo "<script>alert('Data tidak ditemukan');</script>";
                echo "<script>window.location='".site_url('master_database/sales/')."';</script>";
            }
        } else {
            redirect('master_database/sales');
        }
    }

    public function sales_del($id = NULL) {
        if($id != NULL) {
            $item = $this->database_model->sales_list($id)->row();
            if($item->photo != NULL) {
                $target_file = './uploads/sales/'.$item->photo;
                unlink($target_file);
            }
            $this->database_model->sales_del($id);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('sales_del', 'Data Berhasil dihapus');
            }
            redirect('master_database/sales');
        }else{
            redirect('master_database/sales');
        }
    }

    public function sales_onof($id = NULL) {
        $post = $this->input->post(null, TRUE);
        // print_r($post);
        if($id != NULL) {
            $this->database_model->sales_onof($post);
            redirect('master_database/sales');
        }else{
            redirect('master_database/sales');
        }
    }

    public function sales_proses() {

        $post = $this->input->post(null, TRUE);

        if(@$_FILES['photo']['name'] != NULL) {
            $config['upload_path']          = './uploads/sales/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 2048;
            $config['file_name']            = 'sales-'.date(ymd).'-'.substr(md5(rand()),0,10);
            $this->load->library('upload', $config);
        }

        // print_r($post);
        if(isset($_POST['add'])){
            if(@$_FILES['photo']['name'] != NULL) {
                if($this->upload->do_upload('photo')){
                    $post['photo'] = $this->upload->data('file_name');
                    $this->database_model->sales_add($post);
                    if($this->db->affected_rows() > 0){
                        $this->session->set_flashdata('sales_add', 'Data Berhasil ditambah');
                        redirect('master_database/sales');
                    }
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('sales_error', $error);
                    redirect('master_database/sales_add');
                }
            } else {
                $post['photo'] = NULL;
                $this->database_model->sales_add($post);
                if($this->db->affected_rows() > 0){
                    $this->session->set_flashdata('sales_add', 'Data Berhasil ditambah');
                    redirect('master_database/sales');
                }
            }
        } elseif(isset($_POST['edit'])){
            if(@$_FILES['photo']['name'] != NULL) {
                if($this->upload->do_upload('photo')){
                    $item = $this->database_model->sales_list($post['id'])->row();
                    if($item->photo != NULL) {
                        $target_file = './uploads/sales/'.$item->photo;
                        unlink($target_file);
                    }

                    $post['photo'] = $this->upload->data('file_name');
                    $this->database_model->sales_edit($post);
                    if($this->db->affected_rows() > 0){
                        $this->session->set_flashdata('sales_edit', 'Data Berhasil diupdate');
                        redirect('master_database/sales');
                    }
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('sales_error', $error);
                    redirect('master_database/sales_edit/'.$post['id']);
                }
            } else {
                $post['photo'] = NULL;
                $this->database_model->sales_edit($post);
                if($this->db->affected_rows() > 0){
                    $this->session->set_flashdata('sales_edit', 'Data Berhasil diupdate');
                }
                redirect('master_database/sales');
            }
        }
    }

    public function sales_add_user() {
        $post = $this->input->post(null, TRUE);
        // print_r($post);
        $this->database_model->sales_add_user($post);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata('sales_add_user', 'Berhasil dijadikan User login');
        }
        redirect('master_database/sales');
    }
    

    // akhir sales 

    // awal employer

    public function employer() {
        checkUserLogin();
        $this->template->load('template', 'master/employer');
    }

    public function employer_add() {
        $employer = new stdClass();
        $employer->id = NULL;
        $employer->nama_karyawan = NULL;
        $employer->email_karyawan = NULL;
        $employer->jabatan = NULL;
        $employer->nomor_hp = NULL;
        $employer->tempat_lahir = NULL;
        $employer->tanggal_lahir = NULL;
        $employer->usia = NULL;
        $employer->photo = NULL;
        $employer->alamat = NULL;
        $employer->keterangan = NULL;
        $data = array(
            'page'  => 'add',
            'tombol'  => 'Create',
            'judul'  => 'Create New Employer!',
            'row'   => $employer
        );
        $this->template->load('template', 'master/employer_form', $data);
    }

    public function employer_edit($id = NULL) {
        if($id != NULL) {
            $query = $this->database_model->employer_list($id);
            if($query->num_rows() > 0) {
                $employer = $query->row();
                $data = array(
                    'page'  => 'edit',
                    'tombol'  => 'Update',
                    'judul'  => 'Update data Employer',
                    'row'   => $employer
                );
                $this->template->load('template', 'master/employer_form', $data);
            }else{
                echo "<script>alert('Data tidak ditemukan');</script>";
                echo "<script>window.location='".site_url('master_database/employer/')."';</script>";
            }
        } else {
            redirect('master_database/employer');
        }
    }

    public function employer_del($id = NULL) {
        if($id != NULL) {
            $item = $this->database_model->employer_list($id)->row();
            if($item->photo != NULL) {
                $target_file = './uploads/employer/'.$item->photo;
                unlink($target_file);
            }
            $this->database_model->employer_del($id);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('employer_del', 'Data Berhasil dihapus');
            }
            redirect('master_database/employer');
        }else{
            redirect('master_database/employer');
        }
    }

    public function employer_onof($id = NULL) {
        $post = $this->input->post(null, TRUE);
        // print_r($post);
        if($id != NULL) {
            $this->database_model->employer_onof($post);
            redirect('master_database/employer');
        }else{
            redirect('master_database/employer');
        }
    }

    public function employer_proses() {
        $post = $this->input->post(null, TRUE);

        if(@$_FILES['photo']['name'] != NULL){
            $config['upload_path']          = './uploads/employer/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 2048;
            $config['file_name']            = 'employer-'.date(ymd).'-'.substr(md5(rand()),0,10);
            $this->load->library('upload', $config);
        }

        // print_r($post);
        if(isset($_POST['add'])){
            if(@$_FILES['photo']['name'] != NULL) {
                if($this->upload->do_upload('photo')){
                    $post['photo'] = $this->upload->data('file_name');
                    $this->database_model->employer_add($post);
                    if($this->db->affected_rows() > 0){
                        $this->session->set_flashdata('employer_add', 'Data Berhasil ditambah');
                        redirect('master_database/employer');
                    }
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('employer_error', $error);
                    redirect('master_database/employer_add');
                }
            } else {
                
                $post['photo'] = NULL;
                $this->database_model->employer_add($post);
                if($this->db->affected_rows() > 0){
                    $this->session->set_flashdata('employer_add', 'Data Berhasil ditambah');
                    redirect('master_database/employer');
                }
            }
        } elseif(isset($_POST['edit'])){
            if(@$_FILES['photo']['name'] != NULL) {
                if($this->upload->do_upload('photo')){
                    $item = $this->database_model->employer_list($post['id'])->row();
                    if($item->photo != NULL) {
                        $target_file = './uploads/employer/'.$item->photo;
                        unlink($target_file);
                    }
                    
                    $post['photo'] = $this->upload->data('file_name');
                    $this->database_model->employer_edit($post);
                    if($this->db->affected_rows() > 0){
                        $this->session->set_flashdata('employer_edit', 'Data Berhasil diupdate');
                        redirect('master_database/employer');
                    }
                } else {
                    // print_r($post);
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('employer_error', $error);
                    redirect('master_database/employer_edit/'.$post['id']);
                }
            } else {
                $post['photo'] = NULL;
                $this->database_model->employer_edit($post);
                if($this->db->affected_rows() > 0){
                    $this->session->set_flashdata('employer_edit', 'Data Berhasil diupdate');
                }
                redirect('master_database/employer');
            }
        }
    }

    public function employer_add_user() {
        $post = $this->input->post(null, TRUE);
        // print_r($post);
        $this->database_model->employer_add_user($post);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata('employer_add_user', 'Berhasil dijadikan User login');
        }
        redirect('master_database/employer');
    }
    
    // akhir employer 

    // awal STORE

    public function store() {
        checkUserLogin();
        $this->template->load('template', 'master/store');
    }

    public function store_add() {
        $store = new stdClass();
        $store->id = NULL;
        $store->store_name = NULL;
        $store->telp = NULL;
        $store->email_store = NULL;
        $store->alamat = NULL;
        $store->pajak = NULL;
        $store->diskon_store = NULL;
        $store->diskon_select = NULL;
        $store->logo_store = NULL;
        $store->keterangan = NULL;
        $store->pesan = NULL;
        $data = array(
            'page'  => 'add',
            'tombol'  => 'Create',
            'judul'  => 'Create New Store!',
            'row'   => $store
        );
        $this->template->load('template', 'master/store_form', $data);
    }

    public function store_edit($id = NULL) {
        if($id != NULL) {
            $query = $this->database_model->store_list($id);
            if($query->num_rows() > 0) {
                $store = $query->row();
                $data = array(
                    'page'  => 'edit',
                    'tombol'  => 'Update',
                    'judul'  => 'Update data store',
                    'row'   => $store
                );
                $this->template->load('template', 'master/store_form', $data);
            }else{
                echo "<script>alert('Data tidak ditemukan');</script>";
                echo "<script>window.location='".site_url('master_database/store/')."';</script>";
            }
        } else {
            redirect('master_database/store');
        }
    }

    public function store_del($id = NULL) {
        if($id != NULL) {
            $item = $this->database_model->store_list($id)->row();
            if($item->logo_store != NULL) {
                $target_file = './uploads/store/'.$item->logo_store;
                unlink($target_file);
            }
            $this->database_model->store_del($id);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('store_del', 'Data Berhasil dihapus');
            }
            redirect('master_database/store');
        }else{
            redirect('master_database/store');
        }
    }

    public function store_proses() {
        $post = $this->input->post(null, TRUE);

        if(@$_FILES['logo_store']['name'] != NULL){
            $config['upload_path']          = './uploads/store/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 2048;
            $config['file_name']            = 'store-'.date(ymd).'-'.substr(md5(rand()),0,10);
            $this->load->library('upload', $config);
        }

        // print_r($post);
        if(isset($_POST['add'])){
            if(@$_FILES['logo_store']['name'] != NULL) {
                if($this->upload->do_upload('logo_store')){
                    $post['logo_store'] = $this->upload->data('file_name');
                    $this->database_model->store_add($post);
                    if($this->db->affected_rows() > 0){
                        $this->session->set_flashdata('store_add', 'Data Berhasil ditambah');
                        redirect('master_database/store');
                    }
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('store_error', $error);
                    redirect('master_database/store_add');
                }
            } else {
                
                $post['logo_store'] = NULL;
                $this->database_model->store_add($post);
                if($this->db->affected_rows() > 0){
                    $this->session->set_flashdata('store_add', 'Data Berhasil ditambah');
                    redirect('master_database/store');
                }
            }
        } elseif(isset($_POST['edit'])){
            if(@$_FILES['logo_store']['name'] != NULL) {
                if($this->upload->do_upload('logo_store')){
                    $item = $this->database_model->store_list($post['id'])->row();
                    if($item->logo_store != NULL) {
                        $target_file = './uploads/store/'.$item->logo_store;
                        unlink($target_file);
                    }
                    
                    $post['logo_store'] = $this->upload->data('file_name');
                    $this->database_model->store_edit($post);
                    if($this->db->affected_rows() > 0){
                        $this->session->set_flashdata('store_edit', 'Data Berhasil diupdate');
                        redirect('master_database/store');
                    }
                } else {
                    // print_r($post);
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('store_error', $error);
                    redirect('master_database/store_edit/'.$post['id']);
                }
            } else {
                $post['logo_store'] = NULL;
                $this->database_model->store_edit($post);
                if($this->db->affected_rows() > 0){
                    $this->session->set_flashdata('store_edit', 'Data Berhasil diupdate');
                }
                redirect('master_database/store');
            }
        }
    }

    public function store_onof($id = NULL) {
        $post = $this->input->post(null, TRUE);
        // print_r($post);
        if($id != NULL) {
            $this->database_model->store_onof($post);
            redirect('master_database/store');
        }else{
            redirect('master_database/store');
        }
    }

    // akhir STORE 
    
    
    // awal Setting & Payment Methods
    public function setting() {
        checkUserLogin();
        $id = 1;
        $query = $this->database_model->setting_list($id);
        $store = $query->row();
        $data = array(
            'row'   => $store
        );
        $this->template->load('template', 'master/setting', $data);
    }

    public function setting_edit() {
        $post = $this->input->post(null, TRUE);
        // print_r($post);
        // echo "<hr>";
        // print_r($_FILES);
        

        if(@$_FILES['site_logo']['name'] != NULL){
            $config['upload_path']          = './uploads/img/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 2048;
            $config['file_name']            = 'setting-'.date(ymd).'-'.substr(md5(rand()),0,10);
            $this->load->library('upload', $config);
        }

        if(@$_FILES['site_logo']['name'] != NULL) {
            if($this->upload->do_upload('site_logo')){
                $item = $this->database_model->setting_list($post['site_id'])->row();
                if($item->site_logo != NULL) {
                    $target_file = './uploads/img/'.$item->site_logo;
                    unlink($target_file);
                }
                
                $post['site_logo'] = $this->upload->data('file_name');
                $this->database_model->setting_edit($post);
                if($this->db->affected_rows() > 0){
                    $this->session->set_flashdata('setting_edit', 'Data Berhasil diupdate');
                    redirect('master_database/setting');
                }
            } else {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('setting_error', $error);
                redirect('master_database/setting/');
            }
        } else {
            $post['site_logo'] = NULL;
            $this->database_model->setting_edit($post);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('setting_edit', 'Data Berhasil diupdate');
            }
            redirect('master_database/setting');
        }
    }

    public function methods_add() {
        $post = $this->input->post(null, TRUE);
        // print_r($post);
        $this->database_model->methods_add($post);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata('methods_add', 'Data Berhasil ditambahkan');
        }
        redirect('master_database/setting');
    }
    
    public function methods_del() {
        $post = $this->input->post(null, TRUE);
        $this->database_model->methods_del($post);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata('methods_del', 'Data Berhasil dihapus');
            redirect('master_database/setting');
        }
    }

    public function methods_edit() {
        $post = $this->input->post(null, TRUE);
        $this->database_model->methods_edit($post);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata('methods_edit', 'Data berhasil di update');
            redirect('master_database/setting');
        }
    }

    // Akhir Setting & Payment Methods

    // AWAL PRODUCT

    public function product() {
        checkUserLogin();
        $this->template->load('template', 'master/produk');
    }


    public function product_add() {
        $product = new stdClass();
        $product->id = NULL;
        $product->barcode = NULL;
        $product->nama_produk = NULL;
        $product->kategori_produk = NULL;
        $product->unit_produk = NULL;
        $product->gambar = NULL;
        $product->status_produk = NULL;
        $data = array(
            'page'  => 'add',
            'tombol'  => 'Create',
            'judul'  => 'Create New product!',
            'row'   => $product
        );
        $this->template->load('template', 'master/produk_form', $data);
    }

    public function product_edit($id = NULL) {
        if($id != NULL) {
            $query = $this->database_model->product_all($id);
            if($query->num_rows() > 0) {
                $product = $query->row();
                $data = array(
                    'page'  => 'edit',
                    'tombol'  => 'Update',
                    'judul'  => 'Update data product',
                    'row'   => $product
                );
                $this->template->load('template', 'master/produk_form', $data);
            }else{
                echo "<script>alert('Data tidak ditemukan');</script>";
                echo "<script>window.location='".site_url('master_database/product/')."';</script>";
            }
        } else {
            redirect('master_database/product');
        }
    }

    public function product_del($id = NULL) {
        if($id != NULL) {
            $item = $this->database_model->product_all($id)->row();
            if($item->gambar != NULL) {
                $target_file = './uploads/produk/'.$item->gambar;
                unlink($target_file);
            }
            $this->database_model->product_del($id);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('product_del', 'Data Berhasil dihapus');
            }
            redirect('master_database/product');
        }else{
            redirect('master_database/product');
        }
    }
    
    public function product_onof($id = NULL) {
        $post = $this->input->post(null, TRUE);
        // print_r($post);
        if($id != NULL) {
            $this->database_model->product_onof($post);
            redirect('master_database/product');
        }else{
            redirect('master_database/product');
        }
    }
    
    public function barcode_qrcode($id) {
        $data['row'] = $this->database_model->product_all($id)->row();
        $this->template->load('template', 'master/barcode_qrcode', $data);
    }

    public function barcode_qrcode_print($id) {
        $data['row'] = $this->database_model->product_all($id)->row();
        $html = $this->load->view('master/barcode_qrcode_print', $data, TRUE);
        $this->fungsi->pdfGenerator($html, 'print-'.$data['row']->barcode, 'A5', 'portrait');
    }

    public function product_proses() {
        $post = $this->input->post(null, TRUE);

        if(@$_FILES['gambar']['name'] != NULL){
            $config['upload_path']          = './uploads/produk/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 2048;
            $config['file_name']            = 'product-'.date(ymd).'-'.substr(md5(rand()),0,10);
            $this->load->library('upload', $config);
        }

        // print_r($post);
        if(isset($_POST['add'])){
            if($this->database_model->check_barcode($post['barcode'])->num_rows() > 0){
                $this->session->set_flashdata('barcode_error', "Barcode $post[barcode] sudah dipakai product lain");
                redirect('master_database/product_add');
            } else {
                if(@$_FILES['gambar']['name'] != NULL) {
                    if($this->upload->do_upload('gambar')){
                        $post['gambar'] = $this->upload->data('file_name');
                        $this->database_model->product_add($post);
                        if($this->db->affected_rows() > 0){
                            $this->session->set_flashdata('product_add', 'Data Berhasil ditambah');
                            redirect('master_database/product');
                        }
                    } else {
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('product_error', $error);
                        redirect('master_database/product_add');
                    }
                } else {
                    
                    $post['gambar'] = NULL;
                    $this->database_model->product_add($post);
                    if($this->db->affected_rows() > 0){
                        $this->session->set_flashdata('product_add', 'Data Berhasil ditambah');
                        redirect('master_database/product');
                    }
                }
            }
        } elseif(isset($_POST['edit'])){
            if($this->database_model->check_barcode($post['barcode'], $post['id'])->num_rows() > 0){
                $this->session->set_flashdata('barcode_error', "Barcode $post[barcode] sudah dipakai product lain");
                redirect('master_database/product_edit/'.$post['id']);
            } else {
                if(@$_FILES['gambar']['name'] != NULL) {
                    if($this->upload->do_upload('gambar')){
                        $item = $this->database_model->product_all($post['id'])->row();
                        if($item->gambar != NULL) {
                            $target_file = './uploads/produk/'.$item->gambar;
                            unlink($target_file);
                        }
                        
                        $post['gambar'] = $this->upload->data('file_name');
                        $this->database_model->product_edit($post);
                        if($this->db->affected_rows() > 0){
                            $this->session->set_flashdata('product_edit', 'Data Berhasil diupdate');
                            redirect('master_database/product');
                        }
                    } else {
                        // print_r($post);
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('product_error', $error);
                        redirect('master_database/product_edit/'.$post['id']);
                    }
                } else {
                    $post['gambar'] = NULL;
                    $this->database_model->product_edit($post);
                    if($this->db->affected_rows() > 0){
                        $this->session->set_flashdata('product_edit', 'Data Berhasil diupdate');
                    }
                    redirect('master_database/product');
                }
            }
        }
    }

    // AKHIR PRODUCT

	function get_ajax() {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();

        $list = $this->database_model->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->id;
            $row[] = '<img style="width: 150px;" src="data:image/png;base64,' . base64_encode($generator->getBarcode($item->barcode, $generator::TYPE_CODE_128)) . '"><br>'.$item->barcode;
            $row[] = $item->nama_produk;
            $row[] = $item->kategori_produk2;
            $row[] = $item->nama_satuan;
            $row[] = $item->status_produk;
            $row[] = $item->gambar != null ? '<img src="'.base_url('uploads/produk/'.$item->gambar).'" class="img" style="width:100px">' : null;
            $row[] = rupiah($item->harga_beli);
            $row[] = $item->diskon_per_item;
            // add html for action
            $row[] = '<a href="'.site_url('master_database/product_edit/'.$item->id).'" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>&nbsp;
                    <a href="'.site_url('master_database/product_del/'.$item->id).'" onclick="return confirm(\'Apakah Anda yakin?\')" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a>';
            $data[] = $row;

        }
        $output = array(
                    "draw" => @$_POST['draw'],
                    "recordsTotal" => $this->database_model->count_all(),
                    "recordsFiltered" => $this->database_model->count_filtered(),
                    "data" => $data,
                );
        // output to json format
        echo json_encode($output);
    }



}