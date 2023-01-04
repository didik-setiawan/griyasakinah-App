<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventaris extends CI_Controller {
   
    function __construct() {
        parent::__construct();
        $this->load->model(masterModel());
        $this->load->library('fungsi');
        $this->load->library('form_validation');
        checkLoginGagal();
    }

    public function index(){
        redirect('inventaris/daftar_barang/');
    }

    public function daftar_barang(){
        checkUserLogin();
        $data = [
            'unit'      => $this->inventaris_model->listUnit(NULL, idLembaga())->result(),
            'kategori'  => $this->inventaris_model->listKategori(NULL, idLembaga())->result(),
        ];
        $this->template->load('template', 'inventaris/daftar_barang', $data);
    }

    function laporan(){
        checkUserLogin();
        $data = [
            'unit'      => $this->inventaris_model->listUnit(NULL, idLembaga())->result(),
            'kategori'  => $this->inventaris_model->listKategori(NULL, idLembaga())->result(),
        ];
        $this->template->load('template', 'inventaris/laporan', $data);
    }

    function stok(){
        checkUserLogin();
        $data = [
            'unit'      => $this->inventaris_model->listUnit(NULL, idLembaga())->result(),
            'kategori'  => $this->inventaris_model->listKategori(NULL, idLembaga())->result(),
            'barang'    => $this->inventaris_model->listProduk(NULL, idLembaga())->result(),
        ];
        $this->template->load('template', 'inventaris/stok', $data);
    }

    public function kategori_list(){
        $data = [
            'unit'      => $this->inventaris_model->listUnit(NULL, idLembaga())->result(),
            'kategori'  => $this->inventaris_model->listKategori(NULL, idLembaga())->result(),
        ];
        $this->template->load('template', 'inventaris/produk_kategori', $data);

    }

    public function unit_list(){
        $data = [
            'unit'      => $this->inventaris_model->listUnit(NULL, idLembaga())->result(),
            'kategori'  => $this->inventaris_model->listKategori(NULL, idLembaga())->result(),
        ];
        $this->template->load('template', 'inventaris/produk_unit', $data);
    }

    public function proses(){

        $post = $this->input->post(null, TRUE);

        if(isset($_POST['add_produk'])){
            // print_r($post);

            if(empty($post['nama_produk'])){
                $params = array("success" => false, "status" => 1);
            }elseif(empty($post['kode_barang'])){
                $params = array("success" => false, "status" => 2);
            }elseif($post['kategori_produk'] == 0){
                $params = array("success" => false, "status" => 3);
            }elseif($post['unit_produk'] == 0){
                $params = array("success" => false, "status" => 4);
            }else{
                $data = [
                    'barcode'       => $post['kode_barang'],
                    'nama_produk'   => $post['nama_produk'],
                    'kategori_id'   => $post['kategori_produk'],
                    'unit_id'       => $post['unit_produk'],
                    'harga'         => $post['estimasi_harga'],
                    'tanggal'       => date('Y-m-d'),
                    'user_id'       => userId(),
                ];
                $this->inventaris_model->addProduk($data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['edit_produk'])){
            // print_r($post);

            if(empty($post['nama_produk'])){
                $params = array("success" => false, "status" => 1);
            }elseif(empty($post['kode_barang'])){
                $params = array("success" => false, "status" => 2);
            }elseif($post['kategori_produk'] == 0){
                $params = array("success" => false, "status" => 3);
            }elseif($post['unit_produk'] == 0){
                $params = array("success" => false, "status" => 4);
            }else{
                $data = [
                    'barcode'       => $post['kode_barang'],
                    'nama_produk'   => $post['nama_produk'],
                    'kategori_id'   => $post['kategori_produk'],
                    'unit_id'       => $post['unit_produk'],
                    'harga'         => $post['estimasi_harga'],
                ];
                $this->inventaris_model->editProduk($post['id_produk'], $data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['del_produk'])){
            // print_r($post);

            if($post['stok'] > 0){
                $params = array("success" => false, "status" => 1);
            }else{

                $this->inventaris_model->delProduk($post['id_produk']);

                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['get_produk'])){
            // print_r($post);

            $row = $this->inventaris_model->listProduk($post['id_produk'], idLembaga())->row();
            $stokA = $this->inventaris_model->totalStok($row->id, 1)->row();
            if(!empty($stokA->total_stok)){
                $stok_masukA = $stokA->total_stok;
            }else{
                $stok_masukA = 0;
            }
            $stokB = $this->inventaris_model->totalStok($row->id, 2)->row();
            if(!empty($stokB->total_stok)){
                $stok_keluarA = $stokB->total_stok;
            }else{
                $stok_keluarA = 0;
            }
            $stok_akhir = $stok_masukA - $stok_keluarA;

            $params = [
                'id_produk'         => $row->id,
                'nama_produk'       => $row->nama_produk,
                'kode_produk'       => $row->barcode,
                'kategori'          => $row->kategori_id,
                'nama_kategori'     => $row->nama_kategori,
                'unit'              => $row->unit_id,
                'nama_unit'         => $row->nama_unit,
                'harga'             => $row->harga,
                'harga_rp'          => rupiah($row->harga),
                'stok'              => $stok_akhir,
                'stok_akhir'        => rupiah2($stok_akhir),
            ];
            echo json_encode($params);

        }elseif(isset($_POST['add_kategori'])){
            // print_r($post);

            if(empty($post['nama_kategori'])){
                $params = array("success" => false, "status" => 1);
            }else{
                $data = [
                    'kategori_produk'   => $post['nama_kategori'],
                    'tanggal_dibuat'    => date('Y-m-d'),
                    'user_id'           => userId(),
                ];
                $this->inventaris_model->addKategori($data);
    
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
                    'kategori_produk'   => $post['nama_kategori'],
                ];
                $this->inventaris_model->editKategori($post['id_kategori'], $data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['del_kategori'])){
            // print_r($post);

            // $id = NULL, $kategori = NULL, $unit = NULL
            $row = $this->inventaris_model->getProduk(NULL, $post['id_kategori'], NULL);
            if($row->num_rows() > 0){
                $params = array("success" => false, "status" => 1);
            }else{
                $this->inventaris_model->delKategori($post['id_kategori']);
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['add_unit'])){
            // print_r($post);

            if(empty($post['nama_unit'])){
                $params = array("success" => false, "status" => 1);
            }else{
                $data = [
                    'nama_satuan'       => $post['nama_unit'],
                    'tanggal_dibuat'    => date('Y-m-d'),
                    'user_id'           => userId(),
                ];
                $this->inventaris_model->addUnit($data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['edit_unit'])){
            // print_r($post);

            if(empty($post['nama_unit'])){
                $params = array("success" => false, "status" => 1);
            }else{
                $data = [
                    'nama_satuan'       => $post['nama_unit'],
                ];
                $this->inventaris_model->editUnit($post['id_unit'], $data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['del_unit'])){
            // print_r($post);

            $row = $this->inventaris_model->getProduk(NULL, NULL, $post['id_unit']);
            if($row->num_rows() > 0){
                $params = array("success" => false, "status" => 1);
            }else{
                $this->inventaris_model->delUnit($post['id_unit']);
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['add_stok'])){
            // print_r($post);

            if(empty($post['nama_barang'])){
                $params = array("success" => false, "status" => 1);
            }elseif(empty($post['quantity']) || $post['quantity'] == 0){
                $params = array("success" => false, "status" => 2);
            }elseif(empty($post['keterangan'])){
                $params = array("success" => false, "status" => 3);
            }else{
                if($post['tipe'] == 1){
                    $data = [
                        'id_produk'     => $post['nama_barang'],
                        'stok_tipe'     => $post['tipe'],
                        'quantity'      => $post['quantity'],
                        'keterangan'    => $post['keterangan'],
                        'tanggal'       => $post['tanggal'],
                        'user_id'       => userId(),
                    ];
                    $this->inventaris_model->addStok($data);
        
                    if($this->db->affected_rows() > 0) {
                        $params = array("success" => true);
                    } else {
                        $params = array("success" => false);
                    }
                }else{
                    $stokA = $this->inventaris_model->totalStok($post['nama_barang'], 1)->row();
                    if(!empty($stokA->total_stok)){
                        $stok_masukA = $stokA->total_stok;
                    }else{
                        $stok_masukA = 0;
                    }
                    $stokB = $this->inventaris_model->totalStok($post['nama_barang'], 2)->row();
                    if(!empty($stokB->total_stok)){
                        $stok_keluarA = $stokB->total_stok;
                    }else{
                        $stok_keluarA = 0;
                    }
                    $stok_akhir = $stok_masukA - $stok_keluarA;

                    if($stok_akhir == 0){
                        $params = array("success" => false, "status" => 4);
                    }elseif($post['quantity'] > $stok_akhir){
                        $params = array("success" => false, "status" => 5);
                    }else{
                        $data = [
                            'id_produk'     => $post['nama_barang'],
                            'stok_tipe'     => $post['tipe'],
                            'quantity'      => $post['quantity'],
                            'keterangan'    => $post['keterangan'],
                            'tanggal'       => $post['tanggal'],
                            'user_id'       => userId(),
                        ];
                        $this->inventaris_model->addStok($data);
            
                        if($this->db->affected_rows() > 0) {
                            $params = array("success" => true);
                        } else {
                            $params = array("success" => false);
                        }    
                    }
        
                }
            }
            echo json_encode($params);
            
        }elseif(isset($_POST['edit_stok'])){
            // print_r($post);
            // Array ( [edit_stok] => true [tanggal] => 2021-01-13 [nama_barang] => 1 [quantity] => 2 [keterangan] => Buat makan siang dan sore [tipe] => 2 [id_stok] => 5 ) 

            if(empty($post['nama_barang'])){
                $params = array("success" => false, "status" => 1);
            }elseif(empty($post['quantity']) || $post['quantity'] == 0){
                $params = array("success" => false, "status" => 2);
            }elseif(empty($post['keterangan'])){
                $params = array("success" => false, "status" => 3);
            }else{
                if($post['tipe'] == 1){
                    $data = [
                        'id_produk'     => $post['nama_barang'],
                        'quantity'      => $post['quantity'],
                        'keterangan'    => $post['keterangan'],
                        'tanggal'       => $post['tanggal'],
                    ];
                    $this->inventaris_model->editStok($post['id_stok'], $data);
        
                    if($this->db->affected_rows() > 0) {
                        $params = array("success" => true);
                    } else {
                        $params = array("success" => false);
                    }
                }else{
                    $stokA = $this->inventaris_model->totalStok($post['nama_barang'], 1)->row();
                    if(!empty($stokA->total_stok)){
                        $stok_masukA = $stokA->total_stok;
                    }else{
                        $stok_masukA = 0;
                    }
                    $stokB = $this->inventaris_model->totalStok($post['nama_barang'], 2)->row();
                    if(!empty($stokB->total_stok)){
                        $stok_keluarA = $stokB->total_stok;
                    }else{
                        $stok_keluarA = 0;
                    }
                    $stok_akhir = $stok_masukA - $stok_keluarA;

                    $newStok = $stok_akhir + $post['quantity_old'];

                    if($post['quantity'] > $newStok){
                        $params = array("success" => false, "status" => 5);
                    }else{
                        $data = [
                            'id_produk'     => $post['nama_barang'],
                            'quantity'      => $post['quantity'],
                            'keterangan'    => $post['keterangan'],
                            'tanggal'       => $post['tanggal'],
                        ];
                        $this->inventaris_model->editStok($post['id_stok'], $data);
            
                        if($this->db->affected_rows() > 0) {
                            $params = array("success" => true);
                        } else {
                            $params = array("success" => false);
                        }    
                    }
        
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['del_stok'])){
            // print_r($post);

            $this->inventaris_model->delStok($post['del_id']);
            
            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }    
            echo json_encode($params);

        }elseif(isset($_POST['get_stok'])){
            // print_r($post);

            $row = $this->inventaris_model->getStok($post['id_stok'], idLembaga())->row();
            $stokA = $this->inventaris_model->totalStok($row->id_produk, 1)->row();
            if(!empty($stokA->total_stok)){
                $stok_masukA = $stokA->total_stok;
            }else{
                $stok_masukA = 0;
            }
            $stokB = $this->inventaris_model->totalStok($row->id_produk, 2)->row();
            if(!empty($stokB->total_stok)){
                $stok_keluarA = $stokB->total_stok;
            }else{
                $stok_keluarA = 0;
            }
            $stok_akhir = $stok_masukA - $stok_keluarA;

            $params = [
                'id_stok'           => $row->id,
                'produk'            => $row->id_produk,
                'stok_tipe'         => $row->stok_tipe,
                'quantity'          => $row->quantity,
                'tanggal'           => $row->tanggal,
                'nama_produk'       => $row->nama_produk,
                'kode_produk'       => $row->kode_produk,
                'nama_kategori'     => $row->nama_kategori,
                'nama_unit'         => $row->nama_satuan,
                'keterangan'        => $row->keterangan_stok,
                'stok'              => $stok_akhir,
                'stok_akhir'        => rupiah2($stok_akhir),
            ];
            echo json_encode($params);

        }else{
            redirect('inventaris/daftar_barang/');
        }
    
    }

    public function ajax_produk(){
        $list = $this->ajax_produk_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $saldo = 0;
        $stok_akhir = 0;
        $nilaiStok = 0;

        foreach ($list as $produk) {
            if($this->input->post('periode')) {
                $tgl = explode(" - ", $this->input->post('periode'));
                $today = date('Y-m-d');
                if($tgl[0] == $today && $tgl[1] == $today){
                    $stokA = $this->inventaris_model->totalStok($produk->id, 1, NULL, NULL)->row();
                    $stokB = $this->inventaris_model->totalStok($produk->id, 2, NULL, NULL)->row();
                }else{
                    $stokA = $this->inventaris_model->totalStok($produk->id, 1, $tgl[0], $tgl[1])->row();
                    $stokB = $this->inventaris_model->totalStok($produk->id, 2, $tgl[0], $tgl[1])->row();
                }
            }else{
                $stokA = $this->inventaris_model->totalStok($produk->id, 1, NULL, NULL)->row();
                $stokB = $this->inventaris_model->totalStok($produk->id, 2, NULL, NULL)->row();                
            }

            if(!empty($stokA->total_stok)){
                $stok_masukA = $stokA->total_stok;
                $textA = NULL;
            }else{
                $stok_masukA = 0;
                $textA = 'text-danger';
            }

            if(!empty($stokB->total_stok)){
                $stok_keluarA = $stokB->total_stok;
                $textB = NULL;
            }else{
                $stok_keluarA = 0;
                $textB = 'text-danger';
            }
            $stok_akhir = $stok_masukA - $stok_keluarA;
            $nilaiStok = $produk->harga * $stok_akhir;

            if(HakAkses(7)->update == 1){
                $statusU = NULL;
            }else{
                $statusU = 'disabled';
            }
            if(HakAkses(7)->delete == 1){
                $statusD = NULL;
            }else{
                $statusD = 'disabled';
            }
            
            $no++;
            $row = array();
            $row[] = '<span class="text-uppercase">'.$produk->barcode.'</span>';
            $row[] = '
                <span class="text-uppercase text-bold">'.$produk->nama_produk.'</span> <br>
                <span class="small text-info">Estimasi harga <b>'.rupiah($produk->harga).'</b></span> <br>
                <span class="small text-success">Nilai Stok = '.rupiah($produk->harga).' x '.rupiah2($stok_akhir).' '.$produk->nama_satuan.' = <b>'.rupiah($nilaiStok).'</b></span>
            ';
            $row[] = '<span class="text-capitalize">'.$produk->nama_kategori.'</span>';
            $row[] = rupiah2($stok_akhir).' '.$produk->nama_satuan;
            $row[] = rupiah($nilaiStok);
            $row[] = '
                <div class="btn-group">
                    <button class="btn btn-secondary btn-xs" data-toggle="modal" id="set_edit" data-target="#edit-item" data-id_produk="'.$produk->id.'" '.$statusU.'>
                        <i class="fa fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                    </button>
                </div>
                <div class="btn-group">
                    <button class="btn btn-danger btn-xs" data-toggle="modal" id="set_delete" data-target="#delete-item" data-id_produk="'.$produk->id.'" data-stok_akhir="'.$stok_akhir.'" '.$statusD.'>
                        <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                    </button>
                </div>
            ';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ajax_produk_model->count_all(),
            "recordsFiltered" => $this->ajax_produk_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    
    }

    public function ajax_laporan(){
        $list = $this->ajax_laporan_stok_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $saldo = 0;
        $stok_akhir = 0;
        $nilaiStok = 0;

        foreach ($list as $produk) {
            if($this->input->post('periode')) {
                $tgl = explode(" - ", $this->input->post('periode'));
                $today = date('Y-m-d');
                if($tgl[0] == $today && $tgl[1] == $today){
                    $stokA = $this->inventaris_model->totalStok($produk->id_produk, 1, NULL, NULL)->row();
                    $stokB = $this->inventaris_model->totalStok($produk->id_produk, 2, NULL, NULL)->row();
                }else{
                    $stokA = $this->inventaris_model->totalStok($produk->id_produk, 1, $tgl[0], $tgl[1])->row();
                    $stokB = $this->inventaris_model->totalStok($produk->id_produk, 2, $tgl[0], $tgl[1])->row();
                }
            }else{
                $stokA = $this->inventaris_model->totalStok($produk->id_produk, 1, NULL, NULL)->row();
                $stokB = $this->inventaris_model->totalStok($produk->id_produk, 2, NULL, NULL)->row();                
            }

            if(!empty($stokA->total_stok)){
                $stok_masukA = $stokA->total_stok;
                $textA = NULL;
            }else{
                $stok_masukA = 0;
                $textA = 'text-danger';
            }

            if(!empty($stokB->total_stok)){
                $stok_keluarA = $stokB->total_stok;
                $textB = NULL;
            }else{
                $stok_keluarA = 0;
                $textB = 'text-danger';
            }
            $stok_akhir = $stok_masukA - $stok_keluarA;
            $nilaiStok = $produk->harga * $stok_akhir;

            $no++;
            $row = array();
            $row[] = '<span class="text-uppercase">'.$produk->kode_produk.'</span>';
            $row[] = '
                <span class="text-uppercase text-bold">'.$produk->nama_produk.'</span> <br>
                <span class="small text-info">Estimasi harga <b>'.rupiah($produk->harga).'</b></span> <br>
                <span class="small text-success">Nilai Stok = '.rupiah($produk->harga).' x '.rupiah2($stok_akhir).' '.$produk->nama_satuan.' = <b>'.rupiah($nilaiStok).'</b></span>
            ';
            $row[] = '<span class="text-capitalize">'.$produk->nama_kategori.'</span>';
            $row[] = rupiah2($stok_masukA).' '.$produk->nama_satuan;
            $row[] = rupiah2($stok_keluarA).' '.$produk->nama_satuan;
            $row[] = rupiah2($stok_akhir).' '.$produk->nama_satuan;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ajax_laporan_stok_model->count_all(),
            "recordsFiltered" => $this->ajax_laporan_stok_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    
    }

    public function ajax_stok(){
        $list = $this->ajax_history_stok_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $stok) {
            if($stok->stok_tipe == 1){
                $warna = 'primary';
            }else{
                $warna = 'danger';
            }

            if(HakAkses(8)->update == 1){
                $statusU = NULL;
            }else{
                $statusU = 'disabled';
            }
            if(HakAkses(8)->delete == 1){
                $statusD = NULL;
            }else{
                $statusD = 'disabled';
            }
        
            $no++;
            $row = array();
            $row[] = $stok->tanggal.'<br>'.$stok->jam;
            $row[] = '
                <span class="text-uppercase text-bold">'.$stok->nama_produk.' ['.$stok->kode_produk.']</span><br>
                <span class="small text-success">Kategori : '.$stok->nama_kategori.'</span> <br>
                <span class="small text-info">Keterangan : '.$stok->keterangan.'</span> <br>
            ';
            $row[] = rupiah2($stok->quantity).' '.$stok->nama_satuan;
            $row[] = '
                <span class="badge badge-'.$warna.' text-uppercase">'.$stok->nama_tipe.'</span>
            ';
            $row[] = '
                <div class="btn-group">
                    <button class="btn btn-secondary btn-xs" data-toggle="modal" id="set_edit" data-target="#edit-item" data-id_stok="'.$stok->id.'" '.$statusU.'>
                        <i class="fa fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                    </button>
                </div>
                <div class="btn-group">
                    <button class="btn btn-danger btn-xs" data-toggle="modal" id="set_delete" data-target="#delete-item" data-id_stok="'.$stok->id.'" '.$statusD.'>
                        <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                    </button>
                </div>
            ';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ajax_history_stok_model->count_all(),
            "recordsFiltered" => $this->ajax_history_stok_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
        
    }



    
    
}