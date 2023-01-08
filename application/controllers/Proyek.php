<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proyek extends CI_Controller {
   
    function __construct() {
        parent::__construct();
        $this->load->model(masterModel());
        $this->load->model('Proyek_model');
        $this->load->model('Logistik_model');
        $this->load->library('fungsi');
        $this->load->library('form_validation');
        checkLoginGagal();
    }

    public function index(){
        redirect('proyek/ajukan_proyek/');
    }

        //menu Ajukan proyek
    public function ajukan_proyek(){
        checkUserLogin();
        $id_perumahan = $this->session->userdata('id_perumahan');
        $post = $this->input->post(null, TRUE);
        $data = [
            // 'DropKavEdit'  => $this->db->order_by('blok','ASC')->get_where('tbl_kavling',['id_perum' => $id_perumahan],['id_kavling' => $post['proyek_id']])->result(),
            'Tipe'  => $this->db->get_where('tbl_tipe',['id_perum' => $id_perumahan])->result(),
            'cluster'  => $this->Proyek_model->DropdownCluster(NULL)->result(),
            'kavling'  => $this->Proyek_model->listKavling(NULL)->result(),
            'list'  => $this->Proyek_model->listPengajuan(NULL)->result(),
        ];
        $data['perum'] = $this->master_model->getPerumahan();
        // var_dump($data['list']);die;
        $this->template->load('template', 'proyek/ajukan_proyek',$data);
        
    }

    public function get_kavling(){
        $id = $this->input->post('id', TRUE);
        $data = $this->Proyek_model->DropdownKavling($id)->result();
        echo json_encode($data);
    }

    public function get_tipe(){
        $id = $this->input->post('id', TRUE);
        $data = $this->Proyek_model->DropdownTipe($id)->result();
        echo json_encode($data);
    }

    public function get_cluster_ajax(){
        $id_perumahan = $this->session->userdata('id_perumahan');
        $data = $this->db->get_where('tbl_cluster',['id_perum' => $id_perumahan])->result();
        echo json_encode($data);
    }

    public function get_tipe_ajax(){
        $id_perumahan = $this->session->userdata('id_perumahan');
        $data = $this->db->get_where('tbl_tipe',['id_perum' => $id_perumahan])->result();
        echo json_encode($data);
    }

    public function rab(){
        checkUserLogin();
        $data = [
            'kavling'  => $this->Proyek_model->listKavling(NULL)->result(),
            'list'  => $this->Proyek_model->listPengajuan(NULL)->result(),
        ];
        $this->template->load('template', 'proyek/rab',$data);
    }

    public function material_list(){
        $data = [
            'material'  => $this->Proyek_model->listMaterial(NULL)->result(),
        ];
        $this->load->view('proyek/material_list', $data);
    }

    function detail_rab($id = NULL){
        if($id != NULL){    
            $kav ="SELECT tbl_tipe.tipe,tbl_kavling.blok
            JOIN tbl_kavling ON tbl_kavling.id_kavling = tbl_proyek_material.kavling_id
            JOIN tbl_tipe ON tbl_tipe.id_tipe = tbl_kavling.id_tipe
            where master_proyek_kavling.proyek_id = $id
            GROUP BY master_proyek_kavling.kavling_id";

            $rab = $this->Proyek_model->listPengajuan($id);
                $data = [
                    'id_pro' => $id,
                    'rab'       => $rab->row(),
                    // 'rab' => '',
                    'cluster'  => $this->Proyek_model->DropdownClusterRab(NULL)->result(),
                    'kategori'  => $this->Proyek_model->listKategori(NULL)->result(),
                    // 'kavling'  => $this->Proyek_model->TipeBlokDropdown($id)->result(),
                    'unit'      => $this->Proyek_model->listUnit(NULL)->result(),
                    'material'  => $this->Proyek_model->listMaterial(NULL,$id)->result(),
                    'detail'    => $this->Proyek_model->getDetailRAB($id,NULL)->result(),
                    'detail_rab' => $this->db->get_where('tbl_proyek_material',['proyek_id' => $id])->result(),
                    'upah'    => $this->Proyek_model->getDetailUpah($id,NULL)->result(),
                    'lainnya'    => $this->Proyek_model->getDetailLainnya($id,NULL)->result(),
                    'kavling' => $this->Proyek_model->getKavlingRAB($id),
                    'upah2' => $this->db->get_where('tbl_proyek_upah',['proyek_id' => $id])->result(),
                    'lain2' => $this->db->get_where('tbl_proyek_lainnya')
                ];
                

                // var_dump($data['lainnya']);die;
                $this->template->load('template', 'proyek/detail_rab', $data);
            }
    }

    public function get_tipe_id_rab(){
        $post = $this->input->post(null, TRUE);
        $data = $this->Proyek_model->DropdownTipeRab($post['id'])->result();
        echo json_encode($data);
    }

    public function get_kavling_id_rab(){
        $post = $this->input->post(null, TRUE);
        $data = $this->Proyek_model->DropdownKavlingRab($post['id'], $post['id_pro'])->result();
        echo json_encode($data);
    }

    public function get_material_id(){
        $post = $this->input->post(null, TRUE);
        $output = $this->Proyek_model->listMaterial($post['id'])->row();
        echo json_encode($output);
    }

    public function get_kavling_id(){
        $post = $this->input->post(null, TRUE);
        $data = $this->Proyek_model->listKavling($post['id'])->result();
        echo json_encode($data);
    }

    public function proses(){
        $post = $this->input->post(null, TRUE);

        if(isset($_POST['add_pengajuan'])){

            if(empty($post['kavling_id'])){
                $params = array("success" => false, "status" => 1);
            }else{
                $data = [
                    'nama_proyek'         => $post['nama_proyek'],
                    'tgl_pengajuan'      => $post['tgl_pengajuan'],
                    'user_id'            => userId(),
                ];
                $this->Proyek_model->addPengajuan($data);
                $proyek_id = $this->db->insert_id();

                $kav = count($this->input->post('kavling_id'));

                for ($i = 0; $i < $kav; $i++) {
                    $id_kav = $this->input->post('kavling_id[' . $i . ']');
                    $datas[$i] = array(
                      'proyek_id' => $proyek_id,
                      'kavling_id' => $id_kav,
                      'user_id'    => userId()
                    );
                    $this->db->insert('master_proyek_kavling', $datas[$i]);

                    $data[$i]  = [
                        'id_kavling'         => $id_kav,
                        'proyek'             => 1,
                    ];

                    $this->Proyek_model->edit_kavling($id_kav, $data[$i]);
                }

                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            
            }
            echo json_encode($params);

        }elseif(isset($_POST['approve_pengajuan'])){
            // print_r($post);
                // $data = [
                //     'approve'         => 1,
                // ];
                // $this->Proyek_model->ApprovePengajuan($post['id'], $data);

                $this->db->set('approve', 1)->where('id', $post['id'])->update('master_proyek');
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            echo json_encode($params);

        }elseif(isset($_POST['tolak_pengajuan'])){
            // print_r($post);
                $data = [
                    'approve'         => 2,
                ];
                $this->Proyek_model->ApprovePengajuan($post['id'], $data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            echo json_encode($params);

        }elseif(isset($_POST['edit_pengajuan'])){
            $post = $this->input->post(null, TRUE);
        
            if(empty($post['tgl_pengajuan'])){
                $params = array("success" => false, "status" => 1);
            } elseif(empty($post['nama_proyek'])){
                $params = array("success" => false, "status" => 2);
            } elseif(empty($post['kavling_id'])) {
                $params = array("success" => false, "status" => 3);
            } else {
                $data = [
                    'tgl_pengajuan' => $_POST['tgl_pengajuan'],
                    'nama_proyek' => $_POST['nama_proyek'],
                    'kavling_id' => $_POST['kavling_id'],
                ];

                $id = $_POST['id'];

                $this->Proyek_model->ApprovePengajuan($post['id'], $data);
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['get_approve'])){

            $row = $this->Proyek_model->listPengajuan($post['id'])->row();
            
            $params = [
                'id'       => $row->id,
            ];
            echo json_encode($params);

        }elseif(isset($_POST['del_pengajuan'])){
             // print_r($post);

            $result = $this->Proyek_model->listKavlingProyek($post['id']);
            foreach($result->result() as $row) {
                $data = [
                    'id_kavling'         => $row->id_kavling,
                    'proyek'             => 0,
                ];
                $this->Proyek_model->edit_kavling($row->id_kavling, $data);
            }

            $this->Proyek_model->delPengajuanKavling($post['id']);
            $this->Proyek_model->delPengajuan($post['id']);
            
             if($this->db->affected_rows() > 0) {
                 $params = array("success" => true);
             } else {
                 $params = array("success" => false);
             }
             echo json_encode($params);
        }elseif(isset($_POST['get_pengajuan'])){

            $row = $this->Proyek_model->listPengajuan($post['id'])->row();
            
            $params = [
                'id'                    => $row->id,
                'proyek_id'             => $row->proyek_id,
                'nama_proyek'           => $row->nama_proyek,
                'tipe'                  => $row->tipe,
                'blok'                  => $row->blok,
                'kavling_id'            => $row->kavling_id,
                'tgl_pengajuan'         => $row->tgl_pengajuan,
            ];
            echo json_encode($params);
        }elseif(isset($_POST['add_material'])){

            if($post['kategori_id'] == 0){
                $params = array("success" => false, "status" => 1);
            }elseif(empty($post['nama_material'])){
                $params = array("success" => false, "status" => 2);
            }elseif($post['unit_id'] == 0){
                $params = array("success" => false, "status" => 3);
            }else{
                $data = [
                    'kategori_id'        => $post['kategori_id'],
                    'nama_material'      => $post['nama_material'],
                    'unit_id'            => $post['unit_id'],
                    'user_id'            => userId(),
                ];
                $this->Proyek_model->addMaterial($data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);
        }elseif(isset($_POST['add_RABmaterial'])){

            if(empty($post['id_tipe'])){
                $params = array("success" => false, "status" => 1);
            }elseif(empty($post['id_kategori'])){
                $params = array("success" => false, "status" => 2);
            }elseif(empty($post['add_quantity'])){
                $params = array("success" => false, "status" => 3);
            }elseif($post['add_harga'] == 0){
                $params = array("success" => false, "status" => 4);
            }elseif($post['add_total'] == 0){
                $params = array("success" => false, "status" => 5);
            }elseif(empty($post['kavling'])){
                $params = array("success" => false, "status" => 6);
            }else{
                $data = [
                    'proyek_id'          => $post['id_proyek'],
                    'tipe_id'        => $post['id_tipe'],
                    'material_id'      => $post['id_material'],
                    'kategori_id'      => $post['id_kategori'],
                    'quantity'            => $post['add_quantity'],
                    'harga'            => $post['add_harga'],
                    'total'            => $post['add_total'],
                    'user_id'            => userId(),
                    'status'        => 1
                ];
                $this->Proyek_model->addRABMaterial($data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);
        }elseif(isset($_POST['get_RabMaterial'])){
            $row = $this->Proyek_model->getRAB($post['id'],NULL)->row();
            
            $params = [
                'id'                    => $row->id,
                'id_kavling'            => $row->id_kavling,
                'id_cluster'            => $row->id_cluster,
                'id_tipe'               => $row->id_tipe,
                'tipe'                  => $row->tipe,
                'blok'                  => $row->blok,
                'proyek_id'             => $row->proyek_id,
                'material_id'           => $row->material_id,
                'nama_material'         => $row->nama_material,
                'kategori_id'           => $row->kategori_id,
                'kategori_produk'       => $row->kategori_produk,
                'nama_satuan'           => $row->nama_satuan,
                'quantity'              => $row->quantity,
                'harga'                 => $row->harga_satuan,
                'total'                 => $row->total,
                'nama_cluster'          => $row->nama_cluster,
            ];
            echo json_encode($params);
        }elseif(isset($_POST['get_RabUpah'])){
            $row = $this->Proyek_model->getRABUpah($post['id'],NULL)->row();
            
            // $params = [
            //     'id'                    => $row->id,
            //     'proyek_id'             => $row->proyek_id,
            //     'id_tipe'               => $row->id_tipe,
            //     'id_cluster'            => $row->id_cluster,
            //     'kavling_id'            => $row->kavling_id,
            //     'harga_kontrak'         => $row->harga_kontrak,
            //     'nama_cluster'          => $row->nama_cluster,
            //     'tipe'                  => $row->tipe,
            //     'blok'                  => $row->blok,
            // ];
            echo json_encode($row);
        }elseif(isset($_POST['get_RabLainnya'])){
            $row = $this->Proyek_model->getRABLainnya($post['id'],NULL)->row();
            
            // $params = [
            //     'id'                    => $row->id,
            //     'id_cluster'            => $row->id_cluster,
            //     'proyek_id'             => $row->proyek_id,
            //     'kavling_id'            => $row->kavling_id,
            //     'id_tipe'               => $row->id_tipe,
            //     'harga_lainnya'         => $row->harga_lainnya,
            //     'keterangan'            => $row->keterangan,
            //     'tipe'                  => $row->tipe,
            //     'blok'                  => $row->blok,
            //     'nama_cluster'          => $row->nama_cluster,
            // ];
            echo json_encode($row);
        }elseif(isset($_POST['edit_RABmaterial'])){

            $post = $this->input->post(null, TRUE);
        
            // if(empty($post['id_kavling'])){
            //     $params = array("success" => false, "status" => 1);
            // }
            if(empty($post['id_kategori'])){
                $params = array("success" => false, "status" => 2);
            }elseif(empty($post['quantity'])){
                $params = array("success" => false, "status" => 3);
            }elseif($post['harga'] == 0){
                $params = array("success" => false, "status" => 4);
            }elseif($post['total'] == 0){
                $params = array("success" => false, "status" => 5);
            }else{
                $data = [
                    'proyek_id'          => $post['proyek_id'],
                    'tipe_id'            => $post['id_tipe'],
                    'material_id'        => $post['material_id'],
                    'kategori_id'        => $post['id_kategori'],
                    'quantity'           => $post['quantity'],
                    'harga'              => $post['harga'],
                    'total'              => $post['total'],
                    'user_id'            => userId(),
                ];

                // $this->Proyek_model->editRABMaterial($post['id'], $data);

                $this->db->where('id', $post['id']);
                $this->db->update('tbl_proyek_material', $data);

                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                    // $params = $data;
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['edit_RABupah'])){

            $post = $this->input->post(null, TRUE);
        
            if(empty($post['tipe'])){
                $params = array("success" => false, "status" => 1);
            }else{
                $data = [
                    'proyek_id'          => $post['proyek_id'],
                    'tipe_id'            => $post['tipe'],
                    'harga_kontrak'      => $post['harga_kontrak'],
                    'user_id'            => userId(),
                    'ket' => $post['keterangan']
                ];

                $this->Proyek_model->editRABUpah($post['id'], $data);

                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['edit_RABlainnya'])){

            $post = $this->input->post(null, TRUE);
        
            if(empty($post['tipe'])){
                $params = array("success" => false, "status" => 1);
            }else{
                $data = [
                    'proyek_id'          => $post['proyek_id'],
                    // 'kavling_id'        => $post['kavling_id'],
                    'tipe_id'       => $post['tipe'],
                    'harga_lainnya'           => $post['harga_lainnya'],
                    'keterangan'             => $post['keterangan'],
                    'user_id'            => userId(),
                ];

                $this->Proyek_model->editRABLainnya($post['id'], $data);

                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['del_RABmaterial'])){
            // print_r($post);
            $this->Proyek_model->delRABMaterial($post['id']);
            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
            echo json_encode($params);
        }elseif(isset($_POST['del_RABupah'])){
            // print_r($post);
            $this->Proyek_model->delRABUpah($post['id']);
            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
            echo json_encode($params);
        }elseif(isset($_POST['del_RABlainnya'])){
            // print_r($post);
            $this->Proyek_model->delRABLainnya($post['id']);
            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
            echo json_encode($params);
        }elseif(isset($_POST['add_upah'])){

            if(empty($post['tipe_id'])){
                $params = array("success" => false, "status" => 1);
            }elseif(empty($post['harga_kontrak'])){
                $params = array("success" => false, "status" => 2);
            }else{
                $data = [
                    'tipe_id'         => $post['tipe_id'],
                    'harga_kontrak'      => $post['harga_kontrak'],
                    'proyek_id'          => $post['proyek_id'],
                    'user_id'            => userId(),
                    'status'            => 1,
                    'ket' => $post['keterangan']
                ];
                $this->Proyek_model->addUpah($data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);
        }elseif(isset($_POST['add_lainnya'])){

            if(empty($post['tipe'])){
                $params = array("success" => false, "status" => 1);
            }elseif(empty($post['harga_lainnya'])){
                $params = array("success" => false, "status" => 2);
            }elseif(empty($post['keterangan'])){
                $params = array("success" => false, "status" => 3);
            }else{
                $data = [
                    // 'kavling_id'         => $post['id_kavling_lain'],
                    'tipe_id' => $post['tipe'],
                    'harga_lainnya'            => $post['harga_lainnya'],
                    'keterangan'             => $post['keterangan'],
                    'proyek_id'          => $post['proyek_id'],
                    'user_id'            => userId(),
                    'status'            => 1
                ];
                $this->Proyek_model->addLainnya($data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);
        }elseif(isset($_POST['approve_rab'])){
            // print_r($post);
                $data = [
                    'rab'         => 1,
                ];
                $this->Proyek_model->ApprovePengajuan($post['id'], $data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            echo json_encode($params);

        }elseif(isset($_POST['tolak_rab'])){
            // print_r($post);
                $data = [
                    'rab'         => 2,
                ];
                $this->Proyek_model->ApprovePengajuan($post['id'], $data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            echo json_encode($params);

        }elseif(isset($_POST['get_keluar'])){

            $row = $this->Proyek_model->getDetailRAB($post['id'])->row();
            
            $params = [
                'id'       => $row->id,
            ];
            echo json_encode($params);

        }elseif(isset($_POST['del_list_material'])){
            // print_r($post);
            $this->Proyek_model->del_list_material($post['id']);
            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
            echo json_encode($params);
        }elseif(isset($_POST['add_pengajuan_material'])){

            $post = $this->input->post(null, TRUE);
            $detail = $this->db->get_where('master_logistik_detail', ['logistik_id' => $post['id']])->row();


            if(empty($post['id_supplier'])){
                $params = array("success" => false, "status" => 1);
            }if(empty($post['harga_realA'])){
                $params = array("success" => false, "status" => 2);
            }
            if($detail){
                $params = array("success" => false);
            }
            else{
                
                $data = [
                    'logistik_id'           => $post['id'],
                    'supplier_id'           => $post['id_supplier'],
                    'harga_real'            => $post['harga_realA'],
                    'status'                => 1
                ];
                $this->Proyek_model->addPengajuan_Material($data);

                $d = [
                    'detail'                => 1,
                ];
                $this->Logistik_model->editPengajuan($post['id'], $d);

                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            
            }
            echo json_encode($params);

        }elseif(isset($_POST['add_insidentil'])){

            $post = $this->input->post(null, TRUE);

            if(empty($post['id_proyek'])){
                $params = array("success" => false, "status" => 1);
            }if(empty($post['keterangan'])){
                $params = array("success" => false, "status" => 2);
            }if(empty($post['nilaiA'])){
                $params = array("success" => false, "status" => 2);
            }else{
                
                $data = [
                    'tanggal_insidentil'   => $post['tanggal_insidentil'],
                    'proyek_id'            => $post['id_proyek'],
                    'keterangan'           => $post['keterangan'],
                    'nilai'                => $post['nilaiA'],
                    'user_id'              => userId(),
                    'status'               => 1,
                    'id_perumahan'         => $this->session->userdata('id_perumahan')
                ];
                $this->Proyek_model->addInsidentil($data);

                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            
            }
            echo json_encode($params);

        }elseif(isset($_POST['get_insidentil'])){

            $row = $this->Proyek_model->Insidentil($post['id'])->row();

            $params = [
                'id'                    => $row->id,
                'proyek_id'             => $row->proyek_id,
                'keterangan'            => $row->keterangan,
                'nilai'                 => $row->nilai,
                'tanggal_insidentil'    => $row->tanggal_insidentil,
            ];
            echo json_encode($params);

        }elseif(isset($_POST['edit_insidentil'])){
            $post = $this->input->post(null, TRUE);
        
            if(empty($post['id_proyek'])){
                $params = array("success" => false, "status" => 1);
            }if(empty($post['keterangan'])){
                $params = array("success" => false, "status" => 2);
            }if(empty($post['nilaiA'])){
                $params = array("success" => false, "status" => 2);
            }else{
                $data = [
                    'tanggal_insidentil'   => $post['tanggal_insidentil'],
                    'proyek_id'            => $post['id_proyek'],
                    'keterangan'           => $post['keterangan'],
                    'nilai'                => $post['nilaiA'],
                ];

                $id = $_POST['id'];

                $this->Proyek_model->editInsidentil($id, $data);

                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }
    }

    public function ajax_list(){
        $list = $this->Proyek_model->ajukan_proyek();
        $data = array();
        $no = $_POST['start'];

        
        
        foreach ($list as $c) {
            $group = $this->session->userdata('group_id');
            if($group == 1){
                $action = '';
                $ended = '';
            } else if($group == 2){
                $action = 'disabled';
                $ended = 'disabled';
            } else if($group == 6){
                $action = 'disabled';
                $ended = '';
            }





                if($c->approve == 1){
                    $warna = 'primary';
                    $a = 'Approved';
                    $statusU = 'disabled';
                    $approve = '
                    <div class="btn-group">
                        <button class="btn btn-info btn-xs" '.$action.'>
                            <i class="fa fa-check-double" data-toggle="tooltip" data-placement="top" title="Sudah di Approve"></i>
                        </button>
                    </div>
                    ';
                    $end = '<button class="btn btn-xs btn-dark btn-end" data-id="'.$c->id.'" '.$ended.'>Ended</button>';

                }elseif($c->approve == 2){
                    $warna = 'danger';
                    $a = 'Di Tolak';
                    $statusU = 'disabled';
                    $approve = '
                    <div class="btn-group">
                        <button class="btn btn-danger btn-xs" data-toggle="modal" '.$action.'>
                            <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Sudah di Tolak"></i>
                        </button>
                    </div>
                    ';
                    $end = '';
                }
                elseif($c->approve == 3){
                    $warna = 'dark';
                    $a = 'Ended';
                    $statusU = 'disabled';
                    $approve = '
                    <div class="btn-group">
                        <button class="btn btn-dark btn-xs" data-toggle="modal" '.$action.'>
                            <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Sudah Selesai"></i>
                        </button>
                    </div>
                    ';
                    $end = '<button class="btn btn-xs btn-info btn-print" data-id="'.$c->id.'"><i class="fas fa-print" '.$ended.'></i></button>';
                }
                
                else{
                    $warna = 'warning';
                    $a = 'Di Ajukan';
                    $statusU = NULL;
                    $approve = '
                    <div class="btn-group">
                        <button class="btn btn-primary btn-xs" data-toggle="modal" id="approve" data-target="#approve-item" data-id="'.$c->id.'" '.$action.'>
                            <i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Approve"></i>
                        </button>
                    </div>
                    <div class="btn-group">
                    <button class="btn btn-warning btn-xs" data-toggle="modal" id="approve" data-target="#tolak-item" data-id="'.$c->id.'" '.$action.'>
                        <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Tolak"></i>
                    </button>
                </div>
                ';
                $end = '';
                }
           
           if(HakAkses(7)->delete == 1){
                if($c->approve == 1){
                    $statusD = 'disabled';
                    
                }else{
                    $statusD = NULL;
                }
            }else{
                $statusD = 'disabled';
            }

            

        
            $no++;
            $row = array();
            $row[] = $no;
            $row[] =  '<span class="text-uppercase">'.date('d F Y', strtotime($c->tgl_pengajuan)).'</span><br>
                       <span class="small text-danger">'.date('h:i:s A', strtotime($c->created_at)).'</span><br>';
            $row[] = $c->nama_proyek;
            $row[] = '
            <center>
            <button type="button" class="btn btn-xs btn-secondary" id="set_kav" data-id="'.$c->id.'" data-toggle="modal" data-target="#detailKavling">
            Detail Kavling</button></center>
            ';
            $row[] = '
                        <span class="badge badge-'.$warna.' text-uppercase">'.$a.'</span>
            ';
            $row[] = '
                    '.$approve.'
                    <button hidden type="button" class="btn btn-xs btn-secondary" id="set_edit" data-id="'.$c->id.'" data-toggle="modal" data-target="#edit-pengajuan" '.$statusU.' '.$action.'>
                    <i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Edit"></i></button>

                    <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" id="set_delete" data-target="#del-pengajuan" data-id="'.$c->id.'" '.$statusD.' '.$action.'><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Hapus"></i></button>

                    '.$end.'
            ';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Proyek_model->count_all(),
            "recordsFiltered" => $this->Proyek_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_Rab(){
        $list = $this->Proyek_model->buat_rab();
        $data = array();
        $no = $_POST['start'];
        $group = $this->session->userdata('group_id');

        if($group == 1){
            $print = '';
        } else if($group == 2){
            $print = 'disabled';
        } else if($group == 6){
            $print = '';
        }

        if($group == 1){
            $appr_tolak = '';
        } else {
            $appr_tolak = 'disabled';
        }


        foreach ($list as $c) {
           
                if($c->rab == 1){
                    $warna = 'primary';
                    $a = 'Approved';
                    $approve = '
                        <button class="btn btn-dark btn-xs" id="cetak_rab" data-toggle="tooltip" data-placement="top" title="Cetak RAB" data-id="'.$c->id.'" '.$print.'>
                            <i class="fa fa-print" aria-hidden="true" data-toggle="tooltip" data-placement="top"></i>
                        </button>
                        <button class="btn btn-info btn-xs">
                            <i class="fa fa-check-double" data-toggle="tooltip" data-placement="top" title="Sudah di Approve"></i>
                        </button>
                    ';
                }elseif($c->rab == 2){
                    $warna = 'danger';
                    $a = 'Di Tolak';
                    $approve = '
                    <button class="btn btn-danger btn-xs" data-toggle="modal">
                        <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Sudah di Tolak"></i>
                    </button>
                    ';
                }else{
                    $warna = 'warning';
                    $a = 'Di Ajukan';
                    $approve = '
                    <div class="btn-group">
                        <button class="btn btn-primary btn-xs" data-toggle="modal" id="approveRab" data-target="#approve-item" data-id="'.$c->id.'"'.$appr_tolak.'>
                            <i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Approve"></i>
                        </button>
                    </div>

                    <div class="btn-group">
                    <button class="btn btn-warning btn-xs" data-toggle="modal" id="approveRab" data-target="#tolak-item" data-id="'.$c->id.'" '.$appr_tolak.'>
                        <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Tolak"></i>
                    </button>
                    </div>
                ';
                }
          
         
            $no++;
            $row = array();
            $row[] = $no;
            $row[] =  '<span class="text-uppercase">'.date('d F Y', strtotime($c->tgl_pengajuan)).'</span><br>
                       <span class="small text-danger">'.date('h:i:s A', strtotime($c->created_at)).'</span><br>';
            $row[] = $c->nama_proyek;
            $row[] = '
                    <center>
                    <button type="button" class="btn btn-xs btn-secondary" id="set_kav" data-id="'.$c->id.'" data-toggle="modal" data-target="#detailKavling">
                    Detail Kavling</button></center>
            ';
            $row[] = '
                        <span class="badge badge-'.$warna.' text-uppercase">'.$a.'</span>
            ';
            $row[] = '
            <button class="btn btn-success btn-xs" id="open_detail" data-id="'.$c->id.'"><i class="fa fa-plus" data-toggle="tooltip" data-placement="top" title="Buat RAB"></i></button>
            '.$approve.'
            <button class="btn btn-secondary btn-xs" data-toggle="modal" data-target="#staticBackdrop" id="detail-rab" data-id="'.$c->id.'"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="Detail RAB"></i></button>
            ';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Proyek_model->count_all(),
            "recordsFiltered" => $this->Proyek_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_Keluar(){
        $list = $this->Proyek_model->getLogistikKeluar();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $c) {
           

                if($c->approve == 1){
                    $warna = 'primary';
                    $a = 'Approved';
                }else{
                    $warna = 'danger';
                    $a = 'Belum Di Approve';
                }
           
         
            $no++;
            $row = array();
            $row[] = $no;
            $row[] =  '<span class="text-uppercase">'.date('d F Y', strtotime($c->tgl_pengajuan)).'</span><br>
                       <span class="small text-danger">'.date('h:i:s A', strtotime($c->created_at)).'</span><br>';
            $row[] = $c->nama_proyek;
            $row[] = '
            <center>
            <button type="button" class="btn btn-xs btn-secondary" id="set" data-id="'.$c->id.'" data-toggle="modal" data-target="#kavling">
            Detail Kavling</button></center>
            ';
            $row[] = '
            <span class="badge badge-'.$warna.' text-uppercase">'.$a.'</span>
            ';
          
            $row[] = '
            <button class="btn btn-secondary btn-xs" id="detail_keluar" data-id="'.$c->id.'"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="Detail"></i> Detail</button>
            <button class="btn btn-primary btn-xs laporan" data-id="'.$c->id.'"><i class="fa fa-book"></i> Laporan Material</button>
            ';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Proyek_model->count_all(),
            "recordsFiltered" => $this->Proyek_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function view_all_rab(){
        $id = $_POST['id'];

      

        if($id != NULL){
            $rab = $this->Proyek_model->listPengajuan($id);

            // $kav ="SELECT tbl_tipe.tipe,tbl_kavling.blok,tbl_kavling.id_kavling,tbl_cluster.nama_cluster
            // FROM master_proyek_kavling
            // JOIN tbl_kavling ON tbl_kavling.id_kavling = master_proyek_kavling.kavling_id
            // JOIN tbl_cluster ON tbl_cluster.id_cluster = tbl_kavling.id_cluster
            // JOIN tbl_tipe ON tbl_tipe.id_tipe = tbl_kavling.id_tipe
            // where master_proyek_kavling.proyek_id = $id
            // GROUP BY tbl_kavling.blok";

            // $kav = "SELECT DISTINCT tipe FROM tbl_tipe, master_proyek_kavling, tbl_kavling WHERE
            //     master_proyek_kavling.proyek_id = $id AND
            //     master_proyek_kavling.kavling_id = tbl_kavling.id_kavling AND
            //     tbl_kavling.id_tipe = tbl_tipe.id_tipe
            // ";

            $kav = "SELECT * FROM 
                master_proyek_kavling, 
                tbl_kavling,
                tbl_tipe
                WHERE 
                master_proyek_kavling.kavling_id = tbl_kavling.id_kavling AND
                tbl_kavling.id_tipe = tbl_tipe.id_tipe AND
                master_proyek_kavling.proyek_id = $id
                GROUP BY 
                tbl_tipe.id_tipe
            ";

                $data = [
                    'rab'       => $rab->row(),
                    'kav'       => $this->db->query($kav)->result(),
                    // 'kav'       => $kav,
                    'id_pro'    => $id,
                    'tipe'      => $this->Proyek_model->listKavlingProyek($id)->result(),
                    'blok'      => $this->Proyek_model->KavlingCount($id)->result(),
                    'kavling'  => $this->Proyek_model->RabKavling($id)->result(),
                    'detail'    => $this->Proyek_model->getDetailRAB($id),
                    'upah'      => $this->Proyek_model->getDetailUpah($id)->result(),
                    'lainnya'    => $this->Proyek_model->getDetailLainnya($id)->result(),
                    'proyek'    => $this->Proyek_model->listPengajuan($id),
                    'material'   => $this->Proyek_model->MaterialCount($id)->result(),
                    'UpahCount'      => $this->Proyek_model->UpahCount($id)->result(),
                    'LainnyaCount'   => $this->Proyek_model->LainnyaCount($id)->result(),
                    'upah2' => $this->db->get_where('tbl_proyek_upah',['proyek_id' => $id])->result()
                ];
                $this->load->view('proyek/all_rab', $data);
        }
    }

    public function view_rab_keluar(){
        $id = $_POST['id'];
        if($id != NULL){
            $rab = $this->Proyek_model->listPengajuan($id);
                $data = [
                    'rab'       => $rab->row(),
                    'tipe'      => $this->Proyek_model->listKavlingProyek($id)->result(),
                    'blok'      => $this->Proyek_model->KavlingCount($id)->result(),
                    'kavling'  => $this->Proyek_model->RabKavling($id)->result(),
                    'detail'    => $this->Proyek_model->getDetailRAB($id)->result(),
                ];
                $this->load->view('proyek/rab_keluar', $data);
        }
    }

    public function view_all_kavling(){
        $id = $_POST['id'];
        if($id != NULL){
            $rab = $this->Proyek_model->listPengajuan($id);
                $data = [
                    'rab'       => $rab->row(),
                    'tipe'      => $this->Proyek_model->listKavlingProyek($id)->result(),
                    'kavling'  => $this->Proyek_model->RabKavling($id)->result(),
                ];
                $this->load->view('proyek/kavling', $data);
        }
    }

    public function pengajuan_material(){
        checkUserLogin();
        $q = "SELECT * FROM master_supplier";

        if(isset($_GET['filter'])){
            $data = $this->Logistik_model->getDataPengajuanMaterial($_GET['filter'])->result();
        } else {
            $data = $this->Logistik_model->getDataPengajuanMaterial(null)->result();
        }

        $data = [
            'logistik'      => $this->Proyek_model->PengajuanMaterial()->result(),
            'supplier'      => $this->db->query($q)->result(),
            'proyek'        => $this->db->get('master_proyek')->result(),
            'data' => $data,
            'filter' => $this->master->getFilterMaterialProyek()->result()
        ];
        $this->template->load('template', 'proyek/pengajuan_material',$data);
    }

    public function ajax_pengajuan(){
        $list = $this->Logistik_model->get_datatables_proyek();
        $data = array();
        $no = $_POST['start'];

        $group = $this->session->userdata('group_id');
        if($group == 1){
            $add = '';
        } else if($group == 2){
            $add = 'd-none';
        } else if($group == 6){
            $add = '';
        } else {
            $add = 'd-none';
        }

        foreach ($list as $ajukan) {

            if($ajukan->nama_material == NULL && $ajukan->nama_satuan == NULL)
            {
                $material = '-';
                $satuan = '-';
            }else{
                $material = $ajukan->nama_material;
                $satuan = $ajukan->nama_satuan;
            }

                if($ajukan->status_material == 1 || $ajukan->status_material == 2){
                    $warna = 'primary';
                    $a = 'Approved';
                    $approve = '
                    <div class="btn-group">
                        <button class="btn btn-secondary btn-xs detail" data-toggle="modal" data-target="#detail" data-id="'.$ajukan->id.'">
                            <i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="Approve"></i> Detail
                        </button>
                    </div>
                    <div class="btn-group '.$add.'">
                        <button type="button" class="btn btn-success btn-xs set_edit" data-toggle="modal" data-target="#add-pengajuan" data-id="'.$ajukan->id.'"><i class="fa fa-plus"></i> Tambah Data Supplier</button>
                    </div>
                ';
                }else{
                    $warna = 'danger';
                    $a = 'Di Ajukan';
                    $approve = '
                    <div class="btn-group">
                        <button class="btn btn-secondary btn-xs detail" disabled>
                            <i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="Approve"></i> Detail
                        </button>
                    </div>
                    <div class="btn-group '.$add.'">
                        <button type="button" disabled class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Tambah Data Supplier</button>
                    </div>
                ';
                }
            $no++;
            $row = array();
            $row[]= $no;
            $row[] = '<span class="text-uppercase">'.date('d F Y', strtotime($ajukan->tgl_pengajuan)).'</span><br>
            <span class="small text-danger">'.date('h:i:s A', strtotime($ajukan->created_at)).'</span><br>
            ';
            $row[] = $ajukan->nama_proyek;

            $row[] = '<span class="text-uppercase">'.$material.'</span><br>
            <span class="small text-danger">'.$ajukan->kategori_produk.'</span><br>';

            $row[] ='<span class="text-uppercase">'.$ajukan->jml_pengajuan.'</span> <span class="text-bold">'.$satuan.'</span>';

            $row[] ='<span class="text-uppercase">Rp '.rupiah2($ajukan->harga_mat).'</span><br>
            <span class="small text-danger">Rp '.rupiah2($ajukan->jml_pengajuan * $ajukan->harga_mat).'</span><br>';

            $row[] = '
            <span class="badge badge-'.$warna.' text-uppercase">'.$a.'</span>
            ';

            $row[] = '
            '.$approve.' 
            
            ';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Logistik_model->count_all(),
                        "recordsFiltered" => $this->Logistik_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    
    }

    public function get_supplier(){
        $id = $this->input->post('id', TRUE);
        $data = $this->db->get_where('master_supplier' ,['id_supplier' => $id])->row();
        // $data = $this->Proyek_model->getSat($id)->row();
        echo json_encode($data);
    }

    public function detail_pengajuan(){
        $id = $_POST['id'];
        if($id != NULL){
                $data = [
                    'logistik'      => $this->Proyek_model->PengajuanMaterial($id)->result(),
                    // 'img_nota' => $this->db->get_where('master_logistik',['id' => $id])->row(),
                    // 'img_pembayaran' => $this->db->get_where('master_logistik_detail',['logistik_id', $id])->row()
                ];
                $this->load->view('proyek/supplier', $data);
        }
    }

    
    public function delete_pengajuan(){
        $id = $_POST['id'];
        $this->Proyek_model->delPengajuanMaterial($id);
        if($this->db->affected_rows() > 0) {
            $params = array("success" => true);
        } else {
            $params = array("success" => false);
        }
        echo json_encode($params);
    }

    public function pekerjaan_insidentil(){
        checkUserLogin();

        $q = "SELECT * FROM master_proyek";

        $data = [
            'insidental'      => $this->Proyek_model->Insidentil()->result(),
            'proyek'      => $this->db->query($q)->result(),
        ];
        $this->template->load('template', 'proyek/pekerjaan_insidentil',$data);
    }

    public function del_insidentil(){
        $id = $_POST['id'];
        $this->Proyek_model->delInsidentil($id);
        
        if($this->db->affected_rows() > 0) {
            $params = array("success" => true);
        } else {
            $params = array("success" => false);
        }
        echo json_encode($params);
    }





    public function get_rab_material(){

        $id_pro = $_POST['id'];

        $q = "SELECT 
            tbl_proyek_material.*, tbl_proyek_material.id as proyek_material_id,
            tbl_tipe.*,
            master_produk_kategori.*, master_produk_kategori.id as kategori_id,
            master_material.*, master_material.id as material_id,
            tbl_cluster.*,
            master_produk_unit.nama_satuan

            FROM 
            tbl_proyek_material,
            tbl_tipe,
            master_produk_kategori,
            master_material,
            tbl_cluster,
            master_produk_unit

            WHERE
            tbl_proyek_material.id = $id_pro AND 
            tbl_proyek_material.tipe_id = tbl_tipe.id_tipe AND 
            tbl_proyek_material.kategori_id = master_produk_kategori.id AND
            tbl_proyek_material.material_id = master_material.id AND 
            tbl_tipe.id_cluster = tbl_cluster.id_cluster AND 
            master_material.unit_id = master_produk_unit.id
        ";

        $rab = $this->db->query($q)->row();
        echo json_encode($rab);

    }


    public function progres(){
        if(isset($_GET['filter'])){
           $filterResult = $this->Proyek_model->getProgres($_GET['filter']);
        } else {
           $filterResult = $this->Proyek_model->getProgres();
        }


        $kavling = $this->Proyek_model->getKavlingByProyek();
        if($kavling){
            $progres =  $filterResult;
        } else {
            $progres = [];
        }

        $data = [
            'progres' => $progres,
            'proyek' => $this->Proyek_model->getProyekForFIlter()
        ];
        $this->template->load('template', 'proyek/progres', $data);
    }

    public function detail_progres($upah = null, $blok = null){
        $data = [
            'upah_id' => $upah,
            'blok_id' => $blok,
            'data_mandor' => $this->proyek->getDataMandor($upah, $blok),
            'detail' => $this->Proyek_model->getDetailProgres($upah, $blok),
            'total' => $this->Proyek_model->countTotal($upah, $blok),
            'mandor' => $this->db->get('master_mandor')->result()
        ];
        // var_dump($data['total']);die;
        $this->template->load('template', 'proyek/detail_progres', $data);
    }

    public function del_progres($id){
        $this->Proyek_model->delete_progres($id);

        if($this->db->affected_rows() > 0){
            $msg = ['success' => true, 'msg' => 'Progres berhasil di hapus'];
        } else {
            $msg = ['success' => false, 'msg' => 'Progres gagal di hapus'];
        }

        echo json_encode($msg);

    }

    private function validation_progres(){
        $this->form_validation->set_rules('persentase','Persentase','required|trim|numeric');
        $this->form_validation->set_rules('jumlah','Jumlah','required|trim|numeric');

            $persentase = $this->input->post('persentase');
            
            if($persentase > 100){
                $invalid = 'Persentase is invalid';
            } else {
                $invalid = '';
            }

        if($this->form_validation->run() == false){

            $msg = [
                'type' => 'form_validation',
                'persentase_err' => form_error('persentase'),
                'persentase_err2' => $invalid,
                'jumlah_err' => form_error('jumlah')
            ];
            
        } else {
            return true;
        }
        echo json_encode($msg); die;
        

    }

    public function add_progres(){
        $this->validation_progres();

        date_default_timezone_set('Asia/Jakarta');


        $img = $_FILES['foto'];

        if($img){
            $config['upload_path']          = './assets/upload/progres/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            if($this->upload->do_upload('foto')){
                $new_foto = $this->upload->data('file_name');
            } else {
                $msg = ['type' => 'foto_err', 'msg' => 'Error upload file'];
            }
        }

        $upahID = $this->input->post('id_upah');
        $blok = $this->input->post('id_blok');
        $HargaKontrak = $this->Proyek_model->getHargaKontrakForFilter($upahID, $blok);
        $totalBayar = $this->Proyek_model->countTotal($upahID, $blok);
        $bayar = $this->input->post('jumlah');
        // $totalALlBayar = $bayar + $totalBayar;
        $sisa = $HargaKontrak - $totalBayar;
     
        if($bayar <= $sisa){
            $data = [
                'upah_id' => $this->input->post('id_upah'),
                'kavling_id' => $this->input->post('id_blok'),
                'tanggal' => date('Y-m-d'),
                'progres' => $this->input->post('persentase'),
                'total' => $this->input->post('jumlah'),
                'foto' => $new_foto,
                'status' => 2
            ];
    
            $this->Proyek_model->add_progres($data);
    
            if($this->db->affected_rows() > 0){
                $msg = ['type' => 'result', 'msg' => 'Progres berhasil di tambahkan', 'success' => true];
            } else {
                $msg = ['type' => 'result', 'msg' => 'Progres gagal di tambahkan', 'success' => false];
            }

        } else {
           $msg = ['type' => 'err2' ,'msg' => 'Jumlah melebihi Sisa'];
        }

        echo json_encode($msg);

    }

    public function edit_progres(){
        $this->validation_progres();

        $id = $this->input->post('id_progres');
        $thisProgres = $this->Proyek_model->get_progres_id($id);

        $img = $_FILES['foto'];
        if($img){
            $config['upload_path']          = './assets/upload/progres/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            if($this->upload->do_upload('foto')){
                unlink(FCPATH.'assets/upload/progres/'.$thisProgres->foto);
                $new_foto = $this->upload->data('file_name');
            } else {
                $new_foto = $thisProgres->foto;
            }
        }

        $data = [
            'progres' => $this->input->post('persentase'),
            'total' => $this->input->post('jumlah'),
            'foto' => $new_foto
        ];

        $this->Proyek_model->edit_progres($data, $id);

        if($this->db->affected_rows() > 0){
            $msg = ['type' => 'result', 'msg' => 'Progres berhasil di edit', 'success' => true];
        } else {
            $msg = ['type' => 'result', 'msg' => 'Progres gagal di edit', 'success' => false];
        }

        echo json_encode($msg);
    }

    public function get_progres_id_ajax(){
        $id = $_POST['id'];
        $progres = $this->Proyek_model->get_progres_id($id);
        echo json_encode($progres);
    }

    public function ended_proyek(){
        $id = $_POST['id'];
        $data = [
            'end'   => 1,
            'approve' => 3
        ];
        $this->Proyek_model->ended_proyek($data,$id);

        if($this->db->affected_rows() > 0){
            $msg = ['success' => true, 'msg' => 'Proyek berhasil di akhiri'];
        } else {
            $msg = ['success' => false, 'msg' => 'Proyek gagal di akhiri'];
        }
        echo json_encode($msg);
    }


    public function print_proyek($id){
        $data = [
            'id_pro' => $id,
            'perum' => $this->db->get_where('tbl_perumahan',['id_perumahan' => $this->session->userdata('id_perumahan')])->row(),
            'proyek' => $this->db->get_where('master_proyek',['id' => $id])->row(),
            'material' => $this->Proyek_model->get_material_by_proyek($id),
            'total_material' => $this->Proyek_model->get_total_material($id),
            'upah' => $this->Proyek_model->get_upah_by_proyek($id),
            'detail_upah' => $this->Proyek_model->get_detail_upah_proyek($id),
            'total_detail_upah' => $this->Proyek_model->get_total_detail_upah($id),
            'lain' => $this->Proyek_model->get_Lain_proyek($id)
        ];
        $this->load->view('proyek/print_proyek', $data);
    }

    public function ajax_detail_rab(){
        $id_proyek = $_POST['id'];

        $data = [
            'id_proyek' => $id_proyek,
            'tipe' => $this->Proyek_model->get_tipe_detail_rab_ajax($id_proyek)
        ];
        $this->load->view('proyek/ajax_detail_rab', $data);
    }

    public function load_material_All(){
        if(isset($_POST['id_proyek'])){
            $id_proyek = $_POST['id_proyek'];
        } else {
            $id_proyek = null;
        }
        $data = [
            // 'proyek' => $this->Proyek_model->get_pengajuan_material_all($id_proyek)
            'proyek' => $this->Proyek_model->loadMaterialReady($id_proyek)
        ];
        $this->load->view('proyek/load_material_all', $data);
    }

    public function selectMaterialToNota(){
        $id_logistik = $_POST['id_logistik'];
        $logistik = $this->Proyek_model->getLogistikSelectID($id_logistik);
        $data = [
            'id' => $logistik->logistik_id,
            'name' => $logistik->nama_material,
            'qty' => $logistik->jml_pengajuan,
            'price' =>  $logistik->harga_real,
            'options' => array(
                'nama_proyek' => $logistik->nama_proyek,
                'kategori_material' => $logistik->kategori_produk,
                'satuan_material' => $logistik->nama_satuan,
                'tanggal' => $logistik->tgl_pengajuan
            )
        ];
        if($this->cart->insert($data)){
            $params = [
                'success' => true
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Error Insert'
            ];
        }
        echo json_encode($params);
    }

    public function load_cart_nota(){
        $data = [
            'item' => $this->cart->contents()
        ];
        $this->load->view('proyek/load_cart_nota', $data);
    }

    public function remove_cart(){
        $rowid = $_POST['id'];
        if($this->cart->remove($rowid)){
            $params = [
                'success' => true
            ];
        } else {
            $params = [
                'success' => true,
                'msg' => 'Error Removing'
            ];
        }
        echo json_encode($params);
    }


    public function add_nota(){
        if(empty($this->cart->contents())){
            $this->session->set_flashdata('error', 'Tidak ada item di pilih');
            redirect('proyek/pengajuan_material');
        }
        $file = $_FILES['nota'];

        if($file){
            $config['upload_path']          = './assets/berkas/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            if($this->upload->do_upload('nota')){
                $nota = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', 'Error Upload File');
                redirect('proyek/pengajuan_material');
            }

            foreach($this->cart->contents() as $c){
               $this->db->set('nota', $nota);
               $this->db->where('id', $c['id']);
               $this->db->update('master_logistik');
            }
            $this->cart->destroy();
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('success', 'Nota Berhasil di tambahkan');
            } else {
                $this->session->set_flashdata('error', 'Nota gagal di tambahkan');
            }
            redirect('proyek/pengajuan_material');
        }
    }

    public function getSupllierID(){
        $id = $_POST['id'];
        $data = $this->db->get_where('master_supplier',['id_supplier' => $id])->row();
        echo json_encode($data);
    }


    public function showAjukanSupllier(){
        $id = $_POST['id'];
        $data = [
            'supplier' => $this->db->get('master_supplier')->result(),
            'id_pengajuan' => $id,
            'data' => $this->logistik->getDataPengajuanMaterialDetail($id)->result()
        ];
        $this->load->view('proyek/showPengajuanSupplier', $data);
    }

    public function addSupplierData(){
        $id_pengajuan = $this->input->post('id_pengajuan');
        $id_material_pengajuan = $_POST['id_material_pengajuan'];
        $harga_rill = $_POST['harga_rill'];
        $index = count($id_material_pengajuan);
        $data_logistik_detail = array();

        for($i=0; $i<$index; $i++){
            array_push($data_logistik_detail, array(
                'logistik_id' => $id_material_pengajuan[$i],
                'supplier_id' => 0,
                'harga_real' => $harga_rill[$i],
            ));
        }
        $data = [
            'supplier' => $this->input->post('supplier'),
            'status_pengajuan' => 3
        ];

        $this->db->insert_batch('master_logistik_detail', $data_logistik_detail);
        $this->db->where('id_pengajuan', $id_pengajuan)->update('pengajuan_material', $data);

        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata('success','Data supplier berhasil di tambahkan');
        } else {
            $this->session->set_flashdata('error','Data supplier gagal di tambahkan');
        }
        redirect('proyek/pengajuan_material');
    }

    public function addNotaPengajuan(){
        $file = $_FILES['nota'];
        if($file){
            $config['upload_path']          = './assets/bukti_pembayaran/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            if($this->upload->do_upload('nota')){
                $nota = $this->upload->data('file_name');
                $data = [
                    'id_pengajuan' => $this->input->post('id_pengajuan'),
                    'nota' => $nota,
                    'tgl_upload'=> date('Y-m-d')
                ];
                $this->db->insert('nota_material', $data);
                if($this->db->affected_rows() > 0){
                    $this->session->set_flashdata('success','Nota berhasil di tambahkan');
                } else {
                    $this->session->set_flashdata('error','Nota gagal di tambahkan');
                }
            } else {
                $this->session->set_flashdata('error','Error upload file');
            }
        } else {
            $this->session->set_flashdata('error','No file selected');
        }
        redirect('proyek/pengajuan_material');
    }

    public function getDetailsPengajuan(){
        $id = $_POST['id'];
        $data = [
            'data' => $this->logistik->getDataPengajuanMaterialDetail($id)->result(),
            'nota' => $this->db->get_where('nota_material',['id_pengajuan' => $id])->result() ,
            'cicil' => $this->db->get_where('cicil_material',['id_pengajuan' => $id])->result()
        ];
        $this->load->view('proyek/detail_pengajuan_show', $data);
    }

    public function addMandor(){
       $data = [
        'id_mandor' => $this->input->post('mandor'),
        'id_proyek_upah' => $this->input->post('id_proyek'),
        'id_blok' => $this->input->post('id_kavling')
       ];
       if($this->db->insert('mandor_proyek', $data)){
        $params = [
            'success' => true,
            'msg' => 'Data mandor berhasil di tambahkan'
        ];
       } else {
        $params = [
            'success' => false,
            'msg' => 'Data mandor gagal di tambahkan'
        ];
       }
       echo json_encode($params);
    }

    public function showDataMandor(){
        $proyek = $_POST['upah'];
        $blok = $_POST['blok'];
        $data['mandor'] = $this->proyek->getDataMandor($proyek, $blok);
        $this->load->view('proyek/dataMandor', $data);
    }

    public function editDataMandor(){
        $id_mandor = $this->input->post('mandor');
        $id = $this->input->post('id_mandor');
        if($this->db->set('id_mandor', $id_mandor)->where('id_mandor_proyek', $id)->update('mandor_proyek')){
            $params = [
                'success' => true,
                'msg' => 'Data mandor berhasil di ubah'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Data mandor gagal di ubah'
            ];
        }
        echo json_encode($params);
    }

    public function deleteDataMandor(){
        $id = $_POST['id'];
        if($this->db->delete('mandor_proyek',['id_mandor_proyek' => $id])){
            $params = [
                'success' => true,
                'msg' => 'Data mandor berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Data mandor gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function setStatusInsidentil(){
        $id = $_POST['id'];
        $status = $_POST['status'];
        if($status == 'approve'){
            $set_status = 2;
        } else if($status == 'reject'){
            $set_status = 0;
        }

        $this->db->set('status', $set_status)->where('id', $id)->update('tbl_proyek_insidentil');
        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'msg' => 'Status berhasil di ubah'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Status gagal di ubah'
            ];
        }
        echo json_encode($params);
    }

}