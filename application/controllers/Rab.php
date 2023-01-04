<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rab extends CI_Controller {
   
    function __construct() {
        parent::__construct();
        $this->load->model(masterModel());
        $this->load->library('fungsi');
        $this->load->library('form_validation');
        checkLoginGagal();
    }

    function index(){
        redirect('rab/new/');
    }


    function new(){
        checkUserLogin();
        $data = [
            // $id = NULL, $status = NULL, $user = NULL, $lembaga = NULL, $paren = NULL
            'detail'    => $this->rab_model->getDetailRAB(NULL, 4, userId(), idLembaga(), NULL),
            'unit'      => $this->inventaris_model->listUnit(NULL, idLembaga())->result(),
        ];
        
        $this->template->load('template', 'rab/new', $data);
    }
    
    function list(){
        checkUserLogin();
        $data = [
            // 'suplayer'      => $this->database_model->supplier_list()->result(),
            // 'gudang'        => $this->database_model->listGudang()->result(),
            // 'status'        => $this->pembelian_model->listStatus(NULL, 2)->result(),
            // 'judul'         => 'Laporan Pembelian', // today
            // 'pages'         => 2, // laporan
        ];
        
        $this->template->load('template', 'rab/list', $data);
    }
    
    function detail($id = NULL){
        if($id != NULL){
            // $id = NULL, $status = NULL, $lembaga = NULL
            $rab = $this->rab_model->getRAB($id, NULL, idLembaga());
            if($rab->num_rows() > 0){
                $data = [
                    'rab'   => $rab->row(),
                    // $id = NULL, $status = NULL, $user = NULL, $lembaga = NULL, $paren = NULL, $rab = NULL
                    'detail'    => $this->rab_model->getDetailRAB(NULL, NULL, NULL, idLembaga(), NULL, $rab->row()->id),
                    'unit'      => $this->inventaris_model->listUnit(NULL, idLembaga())->result(),
                ];
                $this->template->load('template', 'rab/detail', $data);
            }else{
                redirect('rab/list/');
            }
        }else{
            redirect('rab/list/');
        }
    }

    function proses(){
        $post = $this->input->post(null, TRUE);

        if(isset($_POST['add_kategori'])){
            // print_r($post);
            
            if(empty($post['nama_kategori'])){
                $params = array("success" => false, "status" => 1);
            }else{
                $data = [
                    'level'         => 1,
                    'parent'        => 999,
                    'deskripsi'     => $post['nama_kategori'],
                    'user_id'       => userId(),
                    'status'        => 4,
                ];
                if(!empty($post['id_rab'])){
                    $data['rab_id'] = $post['id_rab'];
                }
                $this->rab_model->addDetail($data);

                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }

            }
            echo json_encode($params);

        }elseif(isset($_POST['edit_kategori'])){
            // print_r($post);

            if(empty($post['nama_kategori'])){
                $params = array("success" => false, "status" => 1);
            }else{
                $data = [
                    'deskripsi'     => $post['nama_kategori'],
                ];
                $this->rab_model->editDetail($post['id_kategori'], $data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }

            }
            echo json_encode($params);

        }elseif(isset($_POST['del_kategori'])){
            // print_r($post);

            // $id = NULL, $status = NULL, $user = NULL, $lembaga = NULL, $paren = NULL
            $parent = $this->rab_model-> getDetailRAB(NULL, NULL, NULL, idLembaga(), $post['id_kategori']);
            if($parent->num_rows() > 0){
                $params = array("success" => false, "status" => 1);
            }else{
                $this->rab_model->delDetail($post['id_kategori']);
        
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['add_item'])){
            // print_r($post);

            if($post['induk_kategori'] == 0){
                $params = array("success" => false, "status" => 1);

            }elseif(empty($post['deskripsi'])){
                $params = array("success" => false, "status" => 2);

            }elseif(empty($post['quantity']) || $post['quantity'] == 0){
                $params = array("success" => false, "status" => 3);

            }elseif($post['satuan'] == 0){
                $params = array("success" => false, "status" => 4);
                
            }elseif(empty($post['nominal']) || $post['nominal'] == 0){
                $params = array("success" => false, "status" => 5);

            }else{
                $satuan = $this->inventaris_model->listUnit($post['satuan'], idLembaga())->row();
                $data = [
                    'level'         => 0,
                    'parent'        => $post['induk_kategori'],
                    'deskripsi'     => $post['deskripsi'],
                    'quantity'      => $post['quantity'],
                    'satuan'        => $satuan->nama_satuan,
                    'id_satuan'     => $post['satuan'],
                    'nominal'       => $post['nominal'],
                    'total'         => $post['total'],
                    'user_id'       => userId(),
                    // 'status'        => 4,
                ];
                if(!empty($post['id_rab'])){
                    $data['rab_id'] = $post['id_rab'];
                    $data['status'] = 1;
                }else{
                    $data['status'] = 4;
                }
                $this->rab_model->addDetail($data);
    
                if(!empty($post['id_rab'])){
                    $totalRAB = 0;
                    $Update = $this->rab_model->getDetailRAB(NULL, NULL, NULL, idLembaga(), NULL, $post['id_rab'])->result();
                    foreach ($Update as $key => $row) {
                        $totalRAB += $row->total;
                    }
                    // udpate RAB Master 
                    $data2 = [
                        'total_anggaran'    => $totalRAB,
                    ];
                    // $status = NULL, $user = NULL, $data = NULL
                    $this->rab_model->editRAB($post['id_rab'], $data2);
                }

                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['edit_item'])){
            // print_r($post);

            if($post['induk_kategori'] == 0){
                $params = array("success" => false, "status" => 1);

            }elseif(empty($post['deskripsi'])){
                $params = array("success" => false, "status" => 2);

            }elseif(empty($post['quantity']) || $post['quantity'] == 0){
                $params = array("success" => false, "status" => 3);

            }elseif($post['satuan'] == 0){
                $params = array("success" => false, "status" => 4);
                
            }elseif(empty($post['nominal']) || $post['nominal'] == 0){
                $params = array("success" => false, "status" => 5);

            }else{
                $satuan = $this->inventaris_model->listUnit($post['satuan'], idLembaga())->row();
                $data = [
                    'parent'        => $post['induk_kategori'],
                    'deskripsi'     => $post['deskripsi'],
                    'quantity'      => $post['quantity'],
                    'satuan'        => $satuan->nama_satuan,
                    'id_satuan'     => $post['satuan'],
                    'nominal'       => $post['nominal'],
                    'total'         => $post['total'],
                ];
                $this->rab_model->editDetail($post['id_detail'], $data);
                
                if(!empty($post['id_rab'])){
                    $totalRAB = 0;
                    $Update = $this->rab_model->getDetailRAB(NULL, NULL, NULL, idLembaga(), NULL, $post['id_rab'])->result();
                    foreach ($Update as $key => $row) {
                        $totalRAB += $row->total;
                    }
                    // udpate RAB Master 
                    $data2 = [
                        'total_anggaran'    => $totalRAB,
                    ];
                    // $status = NULL, $user = NULL, $data = NULL
                    $this->rab_model->editRAB($post['id_rab'], $data2);
                }


                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);
            
            
        }elseif(isset($_POST['del_item'])){
            // print_r($post);

            $this->rab_model->delDetail($post['id_detail']);

            if(!empty($post['id_rab'])){
                $totalRAB = 0;
                $Update = $this->rab_model->getDetailRAB(NULL, NULL, NULL, idLembaga(), NULL, $post['id_rab'])->result();
                foreach ($Update as $key => $row) {
                    $totalRAB += $row->total;
                }
                // udpate RAB Master 
                $data2 = [
                    'total_anggaran'    => $totalRAB,
                ];
                // $status = NULL, $user = NULL, $data = NULL
                $this->rab_model->editRAB($post['id_rab'], $data2);
            }

            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
            echo json_encode($params);

        }elseif(isset($_POST['get_item'])){
            // print_r($post);

            $rab = $this->rab_model->getDetailRAB($post['item_id']);
            if($rab->num_rows() > 0){
                $detail = $rab->row();
                $induk = $this->rab_model->getDetailRAB($detail->parent)->row();
                $data = [
                    'parrent'       => $detail->parent,
                    'induk'         => $induk->deskripsi,
                    'deskripsi'     => $detail->deskripsi,
                    'quantity'      => $detail->quantity,
                    'quantity2'     => rupiah2($detail->quantity),
                    'satuan'        => $detail->satuan,
                    'id_satuan'     => $detail->id_satuan,
                    'nominal'       => $detail->nominal,
                    'nominal2'      => rupiah($detail->nominal),
                    'total'         => $detail->total,
                    'total2'        => rupiah($detail->total),
                    'data'          => $detail,
                ];
                echo json_encode($data);

            }else{
                redirect('rab/new/');
            }

        }elseif(isset($_POST['get_rab'])){
            // print_r($post);

            $rab = $this->rab_model->getRAB($post['id_detail'], NULL, idLembaga());
            if($rab->num_rows() > 0){
                $detail = $rab->row();
                $realisasi = 0;
                $real = $this->rab_model->getDetailRAB(NULL, 5, NULL, idLembaga(), NULL, $detail->id)->result();
                foreach ($real as $key => $value) {
                    $realisasi += $value->total;
                }
                $target = $detail->total_anggaran;
                if($target > 0){
                    $persentasi = round($realisasi/$target * 100, 2);
                }else{
                    $persentasi = 0;
                }

                $data = [
                    'rab'           => $detail,
                    'anggaran'      => rupiah($detail->total_anggaran),
                    'realisasi'     => rupiah($realisasi),
                    'sisa'          => rupiah($detail->total_anggaran - $realisasi),
                    'persentasi'    => $persentasi,
                ];
                echo json_encode($data);

            }else{
                redirect('rab/list/');
            }

        }elseif(isset($_POST['del_rab'])){
            // print_r($post);

            // 1 = progres, 2, = cancel, 3 = delete, 4 = template, 99 = selesai
            $data = [
                'status'    => 3,
            ];
            $this->rab_model->editRAB($post['rab_id'], $data);
            
            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
            echo json_encode($params);

        }elseif(isset($_POST['cancel_rab'])){
            // print_r($post);

            $data = [
                'status'    => 2,
            ];
            $this->rab_model->editRAB($post['rab_id'], $data);
            
            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
            echo json_encode($params);

        }elseif(isset($_POST['finish_rab'])){
            // print_r($post);

            $data = [
                'status'    => 99,
            ];
            $this->rab_model->editRAB($post['rab_id'], $data);
            
            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
            echo json_encode($params);

        }elseif(isset($_POST['save_rab'])){
            // print_r($post);

            // cek status template RAB Detail 
            // $id = NULL, $status = NULL, $user = NULL, $lembaga = NULL, $paren = NULL
            $rab = $this->rab_model->getDetailRAB(NULL, 4, userId(), NULL, NULL);
            $totalAnggaran = 0;
            if($rab->num_rows() > 0){
                $statusRAB = 1;
                foreach ($rab->result() as $key => $row) {
                    $totalAnggaran += $row->total;
                }
            }else{
                $statusRAB = 0;
                $totalAnggaran = 0;
            }

            if(empty($post['nama_kegiatan'])){
                $params = array("success" => false, "status" => 1);
            }elseif(empty($post['tempat_lokasi'])){
                $params = array("success" => false, "status" => 2);
            }elseif(empty($post['deskripsi_kegiatan'])){
                $params = array("success" => false, "status" => 3);
            }elseif($statusRAB == 0){
                $params = array("success" => false, "status" => 4);
            }else{

                // insert data Master RAB 
                $data = [
                    'judul_rab'         => $post['nama_kegiatan'],
                    'lokasi'            => $post['tempat_lokasi'],
                    'keterangan'        => $post['deskripsi_kegiatan'],
                    'waktu'             => $post['tanggal'],
                    'total_anggaran'    => $totalAnggaran,
                    'tanggal'           => date('Y-m-d'),
                    'user_id'           => userId(),
                ];
                $master_id = $this->rab_model->addInsertRAB($data);
                
                // // update data detail RAB 
                $data2 = [
                    'rab_id'    => $master_id,
                    'status'    => 1,
                ];
                // $status = NULL, $user = NULL, $data = NULL
                $this->rab_model->editDetailAll(0, userId(), $data2);
                
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);
            
            
        }elseif(isset($_POST['update_rab'])){
            // print_r($post);

            if(empty($post['nama_kegiatan'])){
                $params = array("success" => false, "status" => 1);
            }elseif(empty($post['tempat_lokasi'])){
                $params = array("success" => false, "status" => 2);
            }elseif(empty($post['deskripsi_kegiatan'])){
                $params = array("success" => false, "status" => 3);
            }else{

                // insert data Master RAB 
                $data = [
                    'judul_rab'         => $post['nama_kegiatan'],
                    'lokasi'            => $post['tempat_lokasi'],
                    'keterangan'        => $post['deskripsi_kegiatan'],
                    'waktu'             => $post['tanggal'],
                ];
                $master_id = $this->rab_model->editRAB($post['id_rab'], $data);
                
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);
            
        }elseif(isset($_POST['finish_detail'])){
            // print_r($post);

            $data = [
                'status'    => 5,
            ];
            $this->rab_model->editDetail($post['id_detail'], $data);
            
            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
            echo json_encode($params);

        }elseif(isset($_POST['reset_rab'])){
            // print_r($post);

            $this->rab_model->resetDetail(4, userId());
            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
            echo json_encode($params);

        }else{
            redirect('rab/new/');
        }
    }

    public function ajax_list(){
        $list = $this->ajax_rab_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rab) {
            $tanggal = $rab->waktu;
            $date = date_create($tanggal);
            $tanggal_dibuat = date_format($date,"j F Y");

            $realisasi = 0;
            $real = $this->rab_model->getDetailRAB(NULL, 5, NULL, idLembaga(), NULL, $rab->id);
            foreach ($real->result() as $key => $value) {
                $realisasi += $value->total;
            }
            $target = $rab->total_anggaran;
            if($target > 0){
                $persentasi = round($realisasi/$target * 100, 2);
            }else{
                $persentasi = 0;
            }

            if($rab->status == 1){
                $progress = '<span class="badge badge-primary text-uppercase">on Progress</span>';
            }elseif($rab->status == 2){
                $progress = '<span class="badge badge-secondary text-uppercase">Cancel</span>';
            }elseif($rab->status == 3){
                $progress = '<span class="badge badge-danger text-uppercase">Delete</span>';
            }elseif($rab->status == 99){
                $progress = '<span class="badge badge-primary text-uppercase">Finish</span>';
            }else{
                $progress = '<span class="badge badge-success text-uppercase">Tempplates</span>';
            }
        
            if(HakAkses(12)->update == 1){
                if($rab->status == 1){
                    $statusU = NULL;
                    $finishRAB = '
                        <div class="btn-group">
                            <button class="btn btn-primary btn-xs" data-toggle="modal" id="finish_rab" data-target="#finish-rab" data-id_detail="'.$rab->id.'">
                                <i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Finish"></i>
                            </button>
                        </div>
                    ';
                }elseif($rab->status == 99){
                    $statusU = 'disabled';
                    $finishRAB = '
                        <div class="btn-group">
                            <button class="btn btn-primary btn-xs">
                                <i class="fa fa-check-double" data-toggle="tooltip" data-placement="top" title="Finish"></i>
                            </button>
                        </div>
                    ';
                }else{
                    $statusU = 'disabled';
                    $finishRAB = '
                        <div class="btn-group">
                            <button class="btn btn-primary btn-xs">
                                <i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Finish"></i>
                            </button>
                        </div>
                    ';
                }
            }else{
                $statusU = 'disabled';
                $finishRAB = '
                    <div class="btn-group">
                        <button class="btn btn-primary btn-xs">
                            <i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Finish"></i>
                        </button>
                    </div>
                ';
            }

            if(HakAkses(12)->delete == 1){
                if($rab->status == 1){
                    $statusD = NULL;
                }else{
                    $statusD = 'disabled';
                }
            }else{
                $statusD = 'disabled';
            }
        
            $no++;
            $row = array();
            $row[] = $rab->waktu.'<br>
                <div class="btn-group">
                    <button class="btn btn-secondary btn-xs" id="cetak_laporan" data-toggle="tooltip" data-placement="top" title="Cetak" data-id_cetak="'.$rab->id.'"><i class="fa fa-print"></i></button>
                </div>
                <div class="btn-group">
                    <button class="btn btn-danger btn-xs" id="download_laporan" data-toggle="tooltip" data-placement="top" title="Download" data-id_download="'.$rab->id.'"><i class="fa fa-file-pdf"></i></button>
                </div>
            ';
            $row[] = '
            <b>'.$rab->judul_rab.'</b> <br>
            <span class="small text-primary">Lokasi : '.$rab->lokasi.'</span> <br>
            <span class="small text-success">Waktu : '.$tanggal_dibuat.'</span> <br>
            ';
            $row[] = rupiah($rab->total_anggaran);
            $row[] = '
                <div class="progress-group">
                    <span class="small text-bold">Progress : '.$persentasi.'%</span>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-success" style="width: '.$persentasi.'%"></div>
                    </div>
                </div>
            ';
            $row[] = $progress;
            $row[] = '
                <div class="btn-group">
                    <button class="btn btn-info btn-xs" id="open_detail" data-id_detail="'.$rab->id.'">
                        <i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="Open"></i>
                    </button>
                </div>
                <div class="btn-group">
                    <button class="btn btn-secondary btn-xs" data-toggle="modal" id="cancel_rab" data-target="#cancel-rab" data-id_detail="'.$rab->id.'" '.$statusU.'>
                        <i class="fa fa-ban" data-toggle="tooltip" data-placement="top" title="Cancel"></i>
                    </button>
                </div>
                <div class="btn-group">
                    <button class="btn btn-danger btn-xs" data-toggle="modal" id="delete_rab" data-target="#delete-rab" data-id_detail="'.$rab->id.'" '.$statusD.'>
                        <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                    </button>
                </div>
                '.$finishRAB.'
            ';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ajax_rab_model->count_all(),
            "recordsFiltered" => $this->ajax_rab_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    
    }


    

}

?>

