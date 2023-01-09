<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logistik extends CI_Controller {
   
    function __construct() {
        parent::__construct();
        $this->load->model(masterModel());
        $this->load->model('Logistik_model');
        $this->load->model('Proyek_model');
        $this->load->model('Rekap_Logistik_model');
        $this->load->library('fungsi');
        $this->load->library('form_validation');
        checkLoginGagal();
    }

    public function index(){
        redirect('logistik/ajukan_material/');
    }

        //menu Ajukan Material
     public function ajukan_material(){
        checkUserLogin();
        $data = [
            'rab'      => $this->Logistik_model->listRab(NULL)->result(),
            'data' => $this->Logistik_model->getDataPengajuanMaterial()->result(),
            'proyek' => $this->Logistik_model->getProyekByPerum()->result()
        ];
        $this->template->load('template', 'logistik/ajukan_material',$data);
    }

    public function get_Tipe_id(){
        $id = $this->input->post('id', TRUE);
        $data = $this->Logistik_model->DropdownTipeRab($id)->result();
        echo json_encode($data);
    }

    public function get_Kavling_id(){
        $id = $this->input->post('id', TRUE);
        $id_pro = $_POST['id_pro'];
        $data = $this->Logistik_model->DropdownKavlingRab($id, $id_pro)->result();
        echo json_encode($data);
    }

    public function get_Jenismaterial_id(){
        $id = $this->input->post('id', TRUE);
        $id_pro = $this->input->post('id_pro', TRUE);
        $data = $this->Logistik_model->DropdownJenisMaterial($id,$id_pro)->result();
        echo json_encode($data);
    }

    public function get_material_id(){
        $id = $this->input->post('id', TRUE);
        $id_pro = $this->input->post('id_pro', TRUE);
        $id_tipe = $this->input->post('id_tipe', TRUE);
        $data = $this->Logistik_model->DropdownMaterial($id,$id_pro,$id_tipe)->result();
        echo json_encode($data);
    }

    public function get_quantity_id(){
        $id = $this->input->post('id', TRUE);
        $id_pro = $this->input->post('id_pro', TRUE);
        $data = $this->Logistik_model->DropdownQuantity($id,$id_pro)->row();
        echo json_encode($data);
    }

    public function get_total_pengajuan(){
        $id_material = $_POST['id_material'];
        $id_proyek = $_POST['id_proyek'];

       $data = $this->Logistik_model->getTotalPengajuan($id_material, $id_proyek);
       
       if($data == null){
        $jml = 0;
       } else {
        $jml = $data;
       }

        $json = [
            'total_pengajuan' => $jml
        ];
        echo json_encode($json);
    }


        //menu Ajukan Material
    public function material_masuk(){
        checkUserLogin();
        $data = [
            'data' => $this->logistik->getLogistikMasuk()->result()
        ];
        $this->template->load('template', 'logistik/material_masuk', $data);
    }

    public function material_keluar(){
        checkUserLogin();

        $data = [
            'rab'      => $this->Logistik_model->listRab(NULL)->result(),
          
        ];
        $this->template->load('template', 'logistik/material_keluar',$data);
    }

    public function rekap_stok_material(){
        checkUserLogin();

        $data = [
            'kategori'  => $this->Proyek_model->listKategori(NULL)->result(),
            'mat'  => $this->Proyek_model->listMaterial(NULL)->result(),
            'detail'    => $this->Logistik_model->get_rekap_material(NULL, null)->result(),
        ];

        if(isset($_GET['jenis'])){
            $data['detail'] = $this->Logistik_model->get_rekap_material($_GET['jenis'], null)->result();
        }

        if(isset($_GET['material'])){
            $data['detail'] = $this->Logistik_model->get_rekap_material(null, $_GET['material'])->result();
        }

        $this->template->load('template', 'logistik/rekap_stok_material',$data);
    }

    public function add_material_masuk(){
        $img = $_FILES['foto'];
         if($img){
             $config['upload_path']          = './assets/upload/logistik/';
             $config['allowed_types']        = 'gif|jpg|png|jpeg';
             $this->load->library('upload', $config);
             if($this->upload->do_upload('foto')){
                 $dokumentasi = $this->upload->data('file_name');
             } else {
                 echo $this->upload->display_errors();
             }
             
         }else {
             echo $this->upload->display_errors();
         }
 
         $mat = $this->db->get_where('master_logistik',['id' => $this->input->post('id')])->row();

         if($mat->tipe == 2){
            $stok_id = $mat->stok_id;
            $type = 1;
         } else {
            $stok_id = 0;
            $type = 0;
         }


         $datas = [
            'logistik_id' => $this->input->post('id'),
            'proyek_material_id' => $this->input->post('proyek_material_id'),
            'material_masuk' => $this->input->post('quantity'),
            'tgl_masuk' => $this->input->post('tgl_masuk'),
            'dokumentasi' => $dokumentasi,
        ];
        $this->db->insert('master_logistik_masuk', $datas);

        $datax  = [
            'logistik_id'           => $this->input->post('id'),
            'stok'                  => $this->input->post('quantity'),
            'proyek_material_id'    => $this->input->post('proyek_material_id'),
            'type' => $type,
            'stok_id' => $stok_id
        ];

        $this->Logistik_model->addStok($datax);

        //  $data = [
        //      'status' => 2,
        //  ];
 
        //  $id = $this->input->post('id');

         if($this->db->affected_rows() > 0){
             $this->session->set_flashdata('true', 'Data Material Masuk Berhasil',300);
             redirect('logistik/material_masuk');
         } else {
             $this->session->set_flashdata('false', 'Data Material Masuk Gagal',300);
             redirect('logistik/material_masuk');
         }
    }

    public function proses(){
        $post = $this->input->post(null, TRUE);
        
        if(isset($_POST['add_pengajuan'])){
            $contents = $this->cart->contents();

               if(empty($contents)){
                    $params = ['success' => false, 'msg' => 'Harap pilih material proyek'];
                } else {
                     foreach($contents as $c){
                        if($c['options']['type'] == 2){
                            $id_stok = $c['options']['stok_id'];
                            $stok = $this->db->get_where('logistik_stok',['id_stok' => $id_stok])->row();
                            $new_stok = $stok->stok - $c['qty'];
                            $this->db->set('stok', $new_stok)->where('id_stok', $id_stok)->update('logistik_stok');
                            $stok_id = $id_stok;
                        } else {
                            $stok_id = 0;
                        }

                        $data = [
                            'proyek_material_id'    => $c['options']['proyek_id'],
                            'kategori_id'           => $c['options']['jenis_material'],
                            'material_id'           => $c['id'],
                            'tgl_pengajuan'         => $post['tgl_pengajuan'],
                            'user_id'               => userId(),
                            'jml_pengajuan'         => $c['qty'],
                            'time' => time(),
                            'tipe' => $c['options']['type'],
                            'id_proyek' => $post['proyek'],
                            'stok_id' => $stok_id
                        ];

                        $this->db->insert('master_logistik', $data);
                     }

                     $data1 = [
                        'id_proyek'=> $post['proyek'] ,
                        'id_tipe'=> $post['tipe'],
                        'tgl_pengajuan'=> $post['tgl_pengajuan'],
                        'status_pengajuan' => 1,
                        'time' => time(),
                        'id_perumahan' => $this->session->userdata('id_perumahan')
                     ];
                     $this->db->insert('pengajuan_material', $data1);
                     $this->cart->destroy();
                     if($this->db->affected_rows() > 0){
                        
                        $params = ['success' => true, 'msg' => 'Pengajuan berhasil di tambahkan'];
                     } else {
                        $params = ['success' => false, 'msg' => 'Pengajuan gagal di tambahkan'];
                     }

                }
                echo json_encode($params);

        }elseif(isset($_POST['get_approve'])){

            $row = $this->Logistik_model->listProyekMaterial($post['id'])->row();
            
            $params = [
                'id'            => $row->id,
            ];
            echo json_encode($params);

        }elseif(isset($_POST['approve_pengajuan'])){
            // print_r($post);

                $id = $_POST['id'];
                $logistik = $this->db->get_where('master_logistik',['id' => $id])->row();
                $mat_pro = $this->db->get_where('tbl_proyek_material',['id' => $logistik->proyek_material_id])->row();

                $jml_pengajuan = $logistik->jml_pengajuan;
                $sisa_stok = $mat_pro->quantity - $mat_pro->jml_out;

                if($jml_pengajuan > $sisa_stok){
                    $params = ['err' => true];
                } else {
                    $data = [
                        'status'         => 1,
                    ];
                    $this->Logistik_model->ApprovePengajuan($post['id'], $data);
                    $this->Logistik_model->Change_jml_out( $logistik->proyek_material_id, $logistik->jml_pengajuan, $mat_pro->jml_out);
        
                    if($this->db->affected_rows() > 0) {
                        $params = array("success" => true);
                    } else {
                        $params = array("success" => false);
                    }
                }

            echo json_encode($params);

        }elseif(isset($_POST['tolak_pengajuan'])){
            // print_r($post);
                $data = [
                    'status'         => 3,
                ];
                $this->Logistik_model->ApprovePengajuan($post['id'], $data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            echo json_encode($params);

        }elseif(isset($_POST['del_pengajuan'])){
            
            $this->Logistik_model->delPengajuan($post['id']);

            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
            
            echo json_encode($params);

        }elseif(isset($_POST['add_material'])){
            // print_r($post);

            if(empty($post['nama_material2'])){
                $params = array("success" => false, "status" => 1);
            }else{
                $data = [
                    'nama_material'   => $post['nama_material2'],
                    'created_by'           => userId(),
                ];
                $this->Logistik_model->addKategori($data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['get_pengajuan'])){

            $row = $this->Logistik_model->listProyekMaterial($post['id'])->row();

            $params = [
                'id'                  => $row->id,
            ];
            echo json_encode($params);

        }elseif(isset($_POST['edit_pengajuan'])){

            if($post['proyek_material_id'] == 0){
                $params = array("success" => false, "status" => 1);
            }else{
                $data = [
                    'proyek_material_id'   => $post['proyek_material_id'],
                    'tgl_pengajuan'      => $post['tgl_pengajuan'],
                ];
                $this->Logistik_model->editPengajuan($post['id'], $data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['get_id_logistik'])){

            $row = $this->Logistik_model->listProyekMaterial($post['id'])->row();
            
            $params = [
                'id'                  => $row->id,
                'proyek_material_id'  => $row->proyek_material_id,
                'quantity'            => $row->jml_pengajuan,
            ];
            echo json_encode($params);

        }elseif(isset($_POST['get_keluar'])){

            $row = $this->Logistik_model->DropdownJenisMaterial($post['id'])->row();
            
            $params = [
                'id'       => $row->id,
            ];
            echo json_encode($params);

        }elseif(isset($_POST['add_keluar'])){
            
            if(empty($_POST['kavling'])){
                $params = array("success" => false, "status" => 2); 
                echo json_encode($params);
                die;
            } else if(empty($_POST['quantity'])){
                $params = array("success" => false, "status" => 3); 
                echo json_encode($params);
                die;
            } else if(empty($_POST['id_max'])){
                $params = array("success" => false, "status" => 4); 
                echo json_encode($params);
                die;
            } 
            
            $id_max = $post['id_max'];
            $id = $post['id_proyek'];
            $logistik = $post['id_logistik'];
            $kavling = $post['kavling'];

            $quantity = $post['quantity'];
            $max = $post['max'];
        
            $mat ="SELECT tbl_max_material.*
            FROM `tbl_max_material`
            WHERE tbl_max_material.id_max = $id_max";
        
            $material = $this->db->query($mat)->row();

            $mat_kel ="SELECT master_logistik_keluar.*
            FROM `master_logistik_keluar`
            WHERE master_logistik_keluar.logistik_id = $logistik";
            $keluar = $this->db->query($mat_kel)->row();

            $stok ="SELECT logistik_stok.*
            FROM `logistik_stok`
            WHERE logistik_stok.logistik_id = $logistik";
            $stok_mat = $this->db->query($stok)->row();
           

            $q = "SELECT SUM(jml_keluar) as keluar FROM material_keluar WHERE id_logistik = $logistik AND kavling_id = $kavling";
            $m_out = $this->db->query($q)->row()->keluar;

        
            $hasil = 0;
            $tot_keluar = 0;
                
            //Cek Create & Edit
            if($post['id_keluar'] == null){

                // //Cek Perbandingan Max/Quantity RAB
                // if($stok_mat->stok > $material->max)
                // {
                //         //CEK QUANTITY
                //     $max_out = $material->max - $m_out;
                //     if($post['quantity'] > $max_out){  //
                //         $params = array("success" => false, "status" => 1); 
                //     }else{
                //         $hasil = $stok_mat->stok - $post['quantity'];
                //         $data = [
                //             'proyek_material_id'    => $id,
                //             'logistik_id'           => $logistik,
                //             'material_keluar'       => $post['quantity'],
                //             'tgl_keluar'            => $post['tgl_pengajuan'],
                //             'user_id'               => userId(),
                //             'kavling'               => $_POST['kavling']
                //         ];
                        
                        
                //         $datas  = [
                //             'stok'                  => $hasil
                //          ];
                
                //         $this->Logistik_model->addMaterialKeluar($data);
                //         $this->Logistik_model->edit_Stok($post['id_stok'], $datas);

                //         $out = [
                //             'id_logistik' => $logistik,
                //             'jml_keluar' => $post['quantity'],
                //             'kavling_id' => $kavling
                //         ];
        
                //         $this->db->insert('material_keluar', $out);

                //         if($this->db->affected_rows() > 0) {
                //             $params = array("success" => true);
                //         } else {
                //             $params = array("success" => false);
                //         }
                //     }
                // }else{ //ELSE Cek Perbandingan Max/Quantity RAB

                //     //CEK QUANTITY
                //     $max_out = $stok_mat->stok - $m_out;
                //     if($post['quantity'] > $max_out){
                //         $params = array("success" => false, "status" => 1); 
                //     }else{

                //         $hasil = $stok_mat->stok - $post['quantity'];
                //         $data = [
                //             'proyek_material_id'    => $id,
                //             'logistik_id'           => $logistik,
                //             'material_keluar'       => $post['quantity'],
                //             'tgl_keluar'            => $post['tgl_pengajuan'],
                //             'user_id'               => userId(),
                //             'kavling'               => $_POST['kavling'],
                //         ];
                        
                        
                //         $datas  = [
                //             'stok'                  => $hasil,
                //         ];
                
                //         $this->Logistik_model->addMaterialKeluar($data);
                
                //         $this->Logistik_model->edit_Stok($post['id_stok'], $datas);

                //         $out = [
                //             'id_logistik' => $logistik,
                //             'jml_keluar' => $post['quantity'],
                //             'kavling_id' => $kavling
                //         ];
        
                //         $this->db->insert('material_keluar', $out);

                //         if($this->db->affected_rows() > 0) {
                //             $params = array("success" => true);
                //         } else {
                //             $params = array("success" => false);
                //         }
                //     }
                // }


                //cek perbandingan jumlah & max_out
                if($quantity > $max){
                    $params = array("success" => false, "status" => 1); 
                } else {
                    $hasil = $stok_mat->stok - $post['quantity'];
                        $data = [
                            'proyek_material_id'    => $id,
                            'logistik_id'           => $logistik,
                            'material_keluar'       => $post['quantity'],
                            'tgl_keluar'            => $post['tgl_pengajuan'],
                            'user_id'               => userId(),
                            'kavling'               => $_POST['kavling']
                        ];
                        
                        $datas  = [
                            'stok'                  => $hasil
                        ];

                        $out = [
                            'id_logistik' => $logistik,
                            'jml_keluar' => $post['quantity'],
                            'kavling_id' => $kavling
                        ];
                
                        $this->Logistik_model->addMaterialKeluar($data);
                        $this->Logistik_model->edit_Stok($post['id_stok'], $datas);
                        $this->db->insert('material_keluar', $out);

                        if($this->db->affected_rows() > 0) {
                            $params = array("success" => true);
                        } else {
                            $params = array("success" => false);
                        }
                }


                

                echo json_encode($params);

                //ELSE Cek CREATE & EDIT
            }else{

                // //Cek Perbandingan Max/Quantity RAB
                // if($stok_mat->stok > $material->max)
                // {
                //     //CEK QUANTITY
                //     $max_out = $material->max - $m_out;
                //     if($post['quantity'] > $max_out){
                //         $params = array("success" => false, "status" => 1); 
                //     }else{
                //         $hasil = $stok_mat->stok - $post['quantity'];
                //         $tot_keluar = $keluar->material_keluar + $post['quantity'];

                //         $data = [
                //             'proyek_material_id'    => $id,
                //             'material_keluar'       => $tot_keluar,
                //             'kavling' => $_POST['kavling']
                //         ];
                        
                //         $datas  = [
                //             'stok'                  => $hasil,
                //             'proyek_material_id'    => $id,
                //         ];
                
                //         $this->Logistik_model->edit_Matkeluar($post['id_keluar'], $data);

                //         $this->Logistik_model->edit_Stok($post['id_stok'], $datas);

                //         $out = [
                //             'id_logistik' => $logistik,
                //             'jml_keluar' => $post['quantity'],
                //             'kavling_id' => $kavling
                //         ];
        
                //         $this->db->insert('material_keluar', $out);

                //         if($this->db->affected_rows() > 0) {
                //             $params = array("success" => true);
                //         } else {
                //             $params = array("success" => false);
                //         }
                //     }

                // }else{ //ELSE Cek Perbandingan Max/Quantity RAB
                    
                //     //CEK QUANTITY
                //     $max_out = $stok_mat->stok - $m_out;
                //     if($post['quantity'] > $max_out){
                //         $params = array("success" => false, "status" => 1); 
                //     }else{
                //         $hasil = $stok_mat->stok - $post['quantity'];
                //         $tot_keluar = $keluar->material_keluar + $post['quantity'];

                //         $data = [
                //             'proyek_material_id'    => $id,
                //             'material_keluar'       => $tot_keluar,
                //             'kavling' => $_POST['kavling']
                //         ];
                        
                //         $datas  = [
                //             'stok'                  => $hasil,
                //             'proyek_material_id'    => $id,
                //         ];
                
                //         $this->Logistik_model->edit_Matkeluar($post['id_keluar'], $data);

                //         $this->Logistik_model->edit_Stok($post['id_stok'], $datas);

                //         $out = [
                //             'id_logistik' => $logistik,
                //             'jml_keluar' => $post['quantity'],
                //             'kavling_id' => $kavling
                //         ];
        
                //         $this->db->insert('material_keluar', $out);

                //         if($this->db->affected_rows() > 0) {
                //             $params = array("success" => true);
                //         } else {
                //             $params = array("success" => false);
                //         }
                //     }
                // }



                //cek perbandingan quantity & max keluar
                if($quantity > $max){
                    $params = array("success" => false, "status" => 1); 
                } else {
                    $hasil = $stok_mat->stok - $post['quantity'];
                    $tot_keluar = $keluar->material_keluar + $post['quantity'];

                        $data = [
                            'proyek_material_id'    => $id,
                            'material_keluar'       => $tot_keluar,
                            'kavling' => $_POST['kavling']
                        ];
                        
                        $datas  = [
                            'stok'                  => $hasil,
                            'proyek_material_id'    => $id,
                        ];
                
                        $out = [
                            'id_logistik' => $logistik,
                            'jml_keluar' => $post['quantity'],
                            'kavling_id' => $kavling
                        ];

                        $this->Logistik_model->edit_Matkeluar($post['id_keluar'], $data);

                        $this->Logistik_model->edit_Stok($post['id_stok'], $datas);
        
                        $this->db->insert('material_keluar', $out);

                        if($this->db->affected_rows() > 0) {
                            $params = array("success" => true);
                        } else {
                            $params = array("success" => false);
                        }
                }

                echo json_encode($params);
            }
        

        }elseif(isset($_POST['get_Mat_keluar'])){

            $id = $post['id'];

            $row = $this->Logistik_model->DetailMaterialKeluar($id)->row();

            $params = [
                'id'            => $row->id,
                'id_proyek'     => $row->id_proyek,
                'id_tipe'       => $row->id_tipe,
                'id_keluar'     => $row->id_keluar,
                'id_stok'       => $row->id_stok,
                'id_max'        => $row->id_max,
                'nama_material' => $row->nama_material,
                'quantity'      => $row->quantity,
                'blok'          => $row->blok,
                'tipe'          => $row->tipe,
                'max'           => $row->max,
                'id_pro'        => $row->id_pro
            ];
            echo json_encode($params);

        } else if(isset($_POST['getMaxOut'])){

            if(empty($_POST['max'])){
                $params = [
                    'success' => false,
                    'msg' => 'Maximal material tidak di temukan',
                    'max_out' => 0
                ];
                echo json_encode($params);
                die;
            } else if(empty($_POST['kavling'])){
                $params = [
                    'success' => false,
                    'msg' => 'Harap pilih kavling',
                    'max_out' => 0
                ];
                echo json_encode($params);
                die;
            }

            //ambil yang di perlukan 
            $id = $post['id'];
            $kavling = $post['kavling'];
            $max = $post['max'];

            $max_material = $this->db->get_where('tbl_max_material',['id_max' => $max])->row()->max;
            $stok_material = $this->db->get_where('logistik_stok',['logistik_id' => $id])->row()->stok;
            $material_out = $this->db->select('SUM(jml_keluar) AS keluar')->from('material_keluar')->where(['id_logistik' => $id, 'kavling_id' => $kavling])->get()->row()->keluar;

            //buat perbandingan antara max material & material keluar
            if($material_out == $max_material){
                $max_out = 0;
            } else if($material_out > $max_material){
                $max_out = 0;
            } else if($material_out < $max_material){
                $sisa_jatah = $max_material - $material_out;
                
                //buat perbandingan antara sisa jatah & stok material
                if($sisa_jatah < $stok_material){
                    $max_out = $sisa_jatah;
                } else if ($sisa_jatah > $stok_material){
                    $max_out = $stok_material;
                } else if($sisa_jatah = $stok_material){
                    $max_out = $stok_material;
                }

            }

            $output = [
                'max_out' => $max_out,
                'success' => true
            ];
            echo json_encode($output);
        }
    }

    public function ajax_ajukan(){
        $list = $this->Logistik_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $group = $this->session->userdata('group_id');
        if($group == 1){
            $act = '';
            $apr = '';
        } else if($group == 2){
            $apr = 'disabled';
            $act = 'disabled';
        } else if($group == 5){
            $apr = 'disabled';
            $act = '';
        } else {
            $apr = 'disabled';
            $act = 'disabled';
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
            
                if($ajukan->status == 1){
                    $warna = 'primary';
                    $a = 'Approved';
                    $statusU = 'disabled';
                    $approve = '
                    <div class="btn-group">
                        <button class="btn btn-primary btn-xs"'.$apr.'>
                            <i class="fa fa-check-double" data-toggle="tooltip" data-placement="top" title="Sudah di Approve"></i>
                        </button>
                    </div>
                    ';
                }elseif($ajukan->status == 3){
                    $warna = 'danger';
                    $a = 'Di Tolak';
                    $statusU = 'disabled';
                    $approve = '
                    <div class="btn-group">
                        <button class="btn btn-danger btn-xs" data-toggle="modal" '.$apr.'>
                            <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Sudah di Tolak"></i>
                        </button>
                    </div>
                    ';
                }else{
                    $warna = 'warning';
                    $a = 'Di Ajukan';
                    $statusU = NULL;
                    $approve = '
                    <div class="btn-group">
                        <button class="btn btn-primary btn-xs" data-toggle="modal" id="approve" data-target="#approve-item" data-id="'.$ajukan->id.'" '.$apr.'>
                            <i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Approve"></i>
                        </button>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-warning btn-xs" data-toggle="modal" id="approve" data-target="#tolak-item" data-id="'.$ajukan->id.'" '.$apr.'>
                            <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Tolak"></i>
                        </button>
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
            <span class="small text-danger">Rp '.rupiah2($ajukan->harga_mat * $ajukan->jml_pengajuan).'</span><br>';

            $row[] = '
            <span class="badge badge-'.$warna.' text-uppercase">'.$a.'</span>
            ';

            $row[] = '
            '.$approve.'
                <div class="btn-group">
                    <button class="btn btn-secondary btn-xs" data-toggle="modal" id="set_edit" hidden data-target="#edit-item" data-id="'.$ajukan->id.'" '.$act.'>
                        <i class="fa fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                    </button>
                </div>
                <div class="btn-group">
                    <button class="btn btn-danger btn-xs" data-target="#delete-item" data-toggle="modal" id="set_delete" data-id="'.$ajukan->id.'" '.$act.'>
                    <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Hapus"></i>
                    </button>
                </div>
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

    public function ajax_masuk(){
        $list = $this->Logistik_model->getLogistikMasuk()->result();
        $data = array();
        $no = $_POST['start'];
        $group = $this->session->userdata('group_id');
        if($group == 1){
            $add = '';
        } else if($group == 2){
            $add = 'disabled';
        } else if($group == 5){
            $add = '';
        } else {
            $add = 'disabled';
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

            
                if($ajukan->status == 1){
                    $warna = 'primary';
                    $a = 'Approved';
                    $statusU = NULL;

                    $button = '
                    <div class="btn-group">
                        <button class="btn btn-primary btn-xs" data-toggle="modal" id="material_masuk" data-target="#approve-item" data-id="'.$ajukan->id.'"'.$statusU.''.$add.'>
                        <i class="fa fa-plus" data-toggle="tooltip" data-placement="top" title="Tambah"></i>
                         Upload
                    </button>
                    </div>
                    ';

                }elseif($ajukan->status == 2){
                    $warna = 'primary';
                    $a = 'Berkas Sudah di Upload';
                    $statusU = NULL;

                    $button = '
                    <div class="btn-group">
                        <button class="btn btn-secondary btn-xs" data-toggle="modal" id="detail_masuk" data-target="#detail_material" data-id="'.$ajukan->id.'">
                        <i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="Detail"></i>
                         Detail
                    </button>
                    </div>
                    ';
                }else{
                    $warna = 'danger';
                    $a = 'Belum Di Approve';
                }


                if($ajukan->status_keuangan == 0){
                    $color = 'danger';
                    $show = 'Di tolak super admin';
                } else if($ajukan->status_keuangan == 1){
                    $color = 'warning';
                    $show = 'Menunggu Accounting';
                } else if($ajukan->status_keuangan == 2){
                    $color = 'success';
                    $show = 'Menunggu Super Admin';
                } else if($ajukan->status_keuangan == 3){
                    $color = 'primary';
                    $show = 'Approved';
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

            $row[] ='<span class="text-uppercase">Rp '.rupiah2($ajukan->harga_real).'</span><br>
            <span class="small text-danger">Rp '.rupiah2($ajukan->harga_real * $ajukan->jml_pengajuan).'</span><br>';

            $row[] = '
                <span class="badge badge-'.$warna.' text-uppercase">'.$a.'</span>
            ';

            $row[] = '
                <span class="badge badge-'.$color.' text-uppercase">'.$show.'</span>
            ';

            $row[] = '
           '.$button.'
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
    
    public function get_detail_masuk(){
        $id = $_POST['id'];
        $data = [
            'masuk'     => $this->Logistik_model->gambar_masuk($id)->row(),
        ];
        $this->load->view('logistik/view_detail_masuk', $data);
    }

    function detail_keluar($id = NULL){
        if($id != NULL){    

            $max ="SELECT tbl_max_material.*,master_material.nama_material
            FROM `tbl_max_material`
            JOIN master_material ON master_material.id = tbl_max_material.material_id
            ";

            $rab = $this->Proyek_model->listPengajuan($id);
                $data = [
                    'rab'       => $rab->row(),
                    'detail'    => $this->Logistik_model->getMaterialKeluarProyek($id)->result(),
                    'material_max'      => $this->db->query($max)->row(),
                ];
                $this->template->load('template', 'logistik/detail_keluar', $data);
        }
    }

    public function get_mat(){
        $id = $this->input->post('id', TRUE);
        $data = $this->Logistik_model->getDropDetailRAB($id)->result();
        echo json_encode($data);
    }

    public function detail_material(){
        $id = $_POST['id'];
        if($id != NULL){
                $data = [
                    'material'      => $this->Proyek_model->listMaterial($id)->result(),
                ];
                $this->load->view('logistik/material', $data);
        }
    }

    public function getJenisMaterialTipe(){
        $id_tipe = $_POST['id_tipe'];
        $id_pro = $_POST['id_pro'];

        $q = "SELECT 
            tbl_proyek_material.*, tbl_proyek_material.id as proyek_material_id,
            master_produk_kategori.*, master_produk_kategori.id as kategori_id
            FROM
            tbl_proyek_material, master_produk_kategori
            WHERE 
            tbl_proyek_material.proyek_id = $id_pro AND
            tbl_proyek_material.tipe_id = $id_tipe AND 
            tbl_proyek_material.kategori_id = master_produk_kategori.id
            GROUP BY master_produk_kategori.id
        ";
        $result = $this->db->query($q)->result();
        echo json_encode($result);

    }

    public function get_kavling_id_kel(){
        $id_tipe = $_POST['id'];
        $id_pro = $_POST['id_pro'];

        $q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON
            master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE
            master_proyek_kavling.proyek_id = $id_pro AND
            tbl_kavling.id_tipe = $id_tipe
        ";

        $kav = $this->db->query($q)->result();
        echo json_encode($kav);
    }


    public function add_list_pengajuan_material(){
        $jml_pengajuan = $_POST['pengajuan'];
        $max_out = $_POST['max_out'];

        if($jml_pengajuan > $max_out){
            $para = [
                'success' => false,
                'msg' => 'Jumlah pengajuan melebihi maksimal'
            ];
            echo json_encode($para);
            die;
        }

        $data = [
            'id'=> $_POST['material'],
            'qty' => $_POST['pengajuan'],
            'price' => 1,
            'name' => $_POST['satuan'],
            'options' => [
                'proyek_id' => $_POST['proyek_id'],
                'jenis_material' => $_POST['jenis_material'],
                'type' => 1,
                'stok_id' => 0,
            ]
        ];
        if($this->cart->insert($data)){
            $para = [
                'success' => true
            ];
        } else {
            $para = [
                'success' => false,
                'msg' => 'Erorr insert list data'
            ];
        }   
        echo json_encode($para);
    }


    public function load_list_item(){
        $this->load->view('logistik/list_pengajuan');
    }


    public function del_items(){
        $id = $_POST['id'];
        $this->cart->remove($id);
    }


    public function detailPengajuanMaterial(){
        $id_pengajuan = $_POST['id'];
        $data  = [
            'data' => $this->Logistik_model->getDataPengajuanMaterialDetail($id_pengajuan)->result()
        ];
        $this->load->view('logistik/detail_pengajuan_material', $data);
    }


    public function setStatusPengajuan(){
        $id = $_POST['id'];
        $status = $_POST['status'];
        $this->db->set('status_pengajuan', $status)->where('id_pengajuan', $id)->update('pengajuan_material');
        if($this->db->affected_rows() > 0){
            $params = array("success" => true, 'msg' => 'Status pengajuan berhasil di ubah');
        } else {
            $params = array("success" => false, 'msg' => 'Status pengajuan gagal di ubah');
        }
        echo json_encode($params); die;
    }

    public function getMaterialGudangbyFilter(){
        $id_perum = $_POST['perum'];
        $data = $this->logistik->getMaterialGudangbyFilter($id_perum)->result();
        $html = '';
        foreach($data as $d){
            $logistik_stok = $this->db->get_where('logistik_stok',['logistik_id' => $d->id_logistik])->row();

            if(isset($logistik_stok)){
                $stok = $logistik_stok->stok;
                $color = 'success';
            } else {
                $stok = 'kosong';
                $color = 'danger';
            }

            $html .= '<tr>
                        <td>'.$d->nama_proyek.'</td>
                        <td>'.$d->nama_material.'</td>
                        <td class="text-center"><span class="badge badge-'.$color.'">'.$stok.' '.$d->nama_satuan.'</span>
                        </td>
                        <td><button class="btn btn-sm btn-primary addFromGudang" 
                            data-id="'.$logistik_stok->id_stok.'"
                            data-material="'.$d->material_id.'"
                            data-kategori="'.$d->kategori_id.'"
                            data-qty="'.$stok.'"
                            data-proyek="'.$d->id_proyek_material.'"
                            data-satuan="'.$d->nama_satuan.'"
                        ><i class="fa fa-check"></i></button></td>
                    </tr>';
        }
        echo $html;
    }

    public function addFromGudang(){
        $pengajuan = $_POST['qty'];
        $max_out = $_POST['max_material'];
        if($pengajuan > $max_out){
            $params = [
                'success' => false,
                'msg' => 'Jumlah Pengajuan melebihi maksimal'
            ];
            echo json_encode($params);
            die;
        }
        $data = [
            'id'=> $_POST['material_show'],
            'qty' => $_POST['qty'],
            'price' => 1,
            'name' => $_POST['satuan_show'],
            'options' => [
                'proyek_id' => $_POST['proyek_id'],
                'jenis_material' => $_POST['kategori_show'],
                'type' => 2,
                'stok_id' => $_POST['stok_id']
            ]
        ];
        if($this->cart->insert($data)){
            $params = [
                'success' => true
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Erorr insert list data'
            ];
        } 
        echo json_encode($params);
    }

    public function loadLaporan(){
        $id_proyek = $_POST['id'];
        $data = [
            'kavling' => $this->Logistik_model->getKavlingByProyek($id_proyek)->result(),
            'id_pro' => $id_proyek
        ];
        $this->load->view('logistik/loadLaporan', $data);
    }

    public function printMaterialOut($pro, $kav){
        $perum  = $this->db->select('tbl_kavling.*, tbl_perumahan.*')->from('tbl_kavling')->join('tbl_perumahan','tbl_kavling.id_perum = tbl_perumahan.id_perumahan')->where('tbl_kavling.id_kavling', $kav)->get()->row();

        $data = [
            'perum' => $perum,
            'id_pro' => $pro,
            'id_kavling' => $kav,
            'jenis_material' => $this->logistik->getJenisMaterialKeluar($kav, $pro)->result()
        ];

        $this->load->view('logistik/print_material_out', $data);
    }


}