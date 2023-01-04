<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_keuangan extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model(masterModel());
        $this->load->library('fungsi');
        $this->load->library('form_validation');
        checkLoginGagal();

    }

    public function index() {
        checkUserLogin();
        redirect('laporan_keuangan/bulanan/');
    }

    // AWAL PRODUK
    public function bulanan() {
        checkUserLogin();
        $data = [
            // $id = NULL, $tipe = NULL, $induk = NULL, $nama = NULL, $limit = NULL
            'kategori'      => $this->laporan_keuangan_model->kategoriTransaksi(NULL, NULL, NULL, NULL, 1, idLembaga())->result(),
            'cash_in'       => $this->laporan_keuangan_model->kategoriTransaksi(NULL, 1, NULL, NULL, 1, idLembaga())->result(),
            'cash_out'      => $this->laporan_keuangan_model->kategoriTransaksi(NULL, 2, NULL, NULL, 1, idLembaga())->result(),
        ];
        $this->template->load('template', 'laporan_keuangan/bulanan', $data);
	}
    
    public function tahunan($id = NULL){
        checkUserLogin();
        $kat = $this->laporan_keuangan_model->kategoriTransaksi(NULL, NULL, NULL, NULL, NULL, idLembaga());
        $induk = $this->laporan_keuangan_model->kategoriInduk(NULL, NULL, idLembaga());
        $tipe = $this->laporan_keuangan_model->tipeTransaksi();
        if($id != NULL){
            $id = $id;
        }else{
            $id = date('Y');
        }
        $data = array(
            'tahun'     => $id,
            'kat'       => $kat,
            'induk'     => $induk,
            'tipe'      => $tipe,
        );
        $this->template->load('template', 'laporan_keuangan/tahunan', $data);
    }

    public function laporan_tahunan($id = NULL) {
        $kat = $this->laporan_keuangan_model->kategoriTransaksi(NULL, NULL, NULL, NULL, NULL, idLembaga());
        $induk = $this->laporan_keuangan_model->kategoriInduk(NULL, NULL, idLembaga());
        $tipe = $this->laporan_keuangan_model->tipeTransaksi();

        if($id != NULL){
            $id = $id;
        }else{
            $id = date('Y');
        }
        $data = array(
            'tahun'     => $id,
            'kat'       => $kat,
            'induk'     => $induk,
            'tipe'      => $tipe,
        );
        $this->load->view('laporan_keuangan/tahunan_data', $data);
    }


    
    public function setup(){
        checkUserLogin();
        $kat = $this->laporan_keuangan_model->kategoriTransaksi(NULL, NULL, NULL, NULL, NULL, idLembaga());
        $induk = $this->laporan_keuangan_model->kategoriInduk(NULL, NULL, idLembaga());
        $tipe = $this->laporan_keuangan_model->tipeTransaksi()->result();

        $data = array(
            'kat'       => $kat,
            'induk'     => $induk,
            'tipe2'      => $tipe,
        );
        $this->template->load('template', 'laporan_keuangan/setup', $data);
    }

    public function laba_rugi($id = NULL){
        checkUserLogin();
        // $id = NULL, $tipe = NULL, $induk = NULL, $nama = NULL, $limit = NULL, $lembaga = NULL
        $pemasukkan = $this->laporan_keuangan_model->kategoriTransaksi(NULL, 1, NULL, NULL, NULL, idLembaga());
        $pengeluaran = $this->laporan_keuangan_model->kategoriTransaksi(NULL, 2, NULL, NULL, NULL, idLembaga());

        if($id != NULL){
            $id = $id;
        }else{
            $id = date('Y');
        }

        $data = array(
            'sa'            => $this->ajax_saldo2_model->getSaldoAwal2($id, idLembaga()),
            'profile'       => $this->master_model->getProfile(idLembaga())->row(),
            'pemasukkan'    => $pemasukkan,
            'pengeluaran'   => $pengeluaran,
            'tahun'         => $id,
        );
        $this->template->load('template', 'laporan_keuangan/laba_rugi', $data);
    }

    public function data_labarugi($id = NULL){
        // $id = NULL, $tipe = NULL, $induk = NULL, $nama = NULL, $limit = NULL, $lembaga = NULL
        $pemasukkan = $this->laporan_keuangan_model->kategoriTransaksi(NULL, 1, NULL, NULL, NULL, idLembaga());
        $pengeluaran = $this->laporan_keuangan_model->kategoriTransaksi(NULL, 2, NULL, NULL, NULL, idLembaga());

        if($id != NULL){
            $id = $id;
        }else{
            $id = date('Y');
        }

        $data = array(
            'sa'            => $this->ajax_saldo2_model->getSaldoAwal2($id, idLembaga()),
            'pemasukkan'    => $pemasukkan,
            'pengeluaran'   => $pengeluaran,
            'tahun'         => $id,
        );
        $this->load->view('laporan_keuangan/data_labarugi', $data);        
    }

    public function neraca(){
        checkUserLogin();
        $kat = $this->laporan_keuangan_model->kategoriTransaksi(NULL, NULL, NULL, NULL, NULL, idLembaga());
        $induk = $this->laporan_keuangan_model->kategoriInduk(NULL, NULL, idLembaga());
        $tipe = $this->laporan_keuangan_model->tipeTransaksi()->result();

        $data = array(
            'kat'       => $kat,
            'induk'     => $induk,
            'tipe2'      => $tipe,
        );
        $this->template->load('template', 'laporan_keuangan/neraca', $data);
    }

    public function proses(){
        $post = $this->input->post(null, TRUE);

        if(isset($_POST['add_pemasukan'])){
            // print_r($post);
            if($post['kategori_pemasukan'] == 0){
                $params = array("success" => false, "status" => 1);
            }elseif(empty($post['jumlah_pemasukkan']) || $post['jumlah_pemasukkan'] == 0){
                $params = array("success" => false, "status" => 2);
            }elseif(empty($post['judul_pemasukkan'])){
                $params = array("success" => false, "status" => 3);
            }else{
                $data = [
                    'tipe_id'           => $post['tipe_kas'],
                    'kategori_id'       => $post['kategori_pemasukan'],
                    'nominal'           => $post['jumlah_pemasukkan'],
                    'nama_transaksi'    => $post['judul_pemasukkan'],
                    'tanggal'           => $post['tanggal'],
                    'jenis_kas'         => 1,
                    'user_id'           => userId(),
                ];
                $this->laporan_keuangan_model->addLaporan($data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['edit_pemasukan'])){
            // print_r($post);

            if($post['kategori_pemasukan'] == 0){
                $params = array("success" => false, "status" => 1);
            }elseif(empty($post['jumlah_pemasukkan']) || $post['jumlah_pemasukkan'] == 0){
                $params = array("success" => false, "status" => 2);
            }elseif(empty($post['judul_pemasukkan'])){
                $params = array("success" => false, "status" => 3);
            }else{
                $data = [
                    'kategori_id'       => $post['kategori_pemasukan'],
                    'nominal'           => $post['jumlah_pemasukkan'],
                    'nama_transaksi'    => $post['judul_pemasukkan'],
                    'tanggal'           => $post['tanggal'],
                    'user_update'       => userId(),
                ];
                $this->laporan_keuangan_model->editLaporan($post['pemasukkan_id'], $data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['add_pengeluaran'])){
            // print_r($post);
            
            if($post['kategori_pengeluaran'] == 0){
                $params = array("success" => false, "status" => 1);
            }elseif(empty($post['jumlah_pengeluaran']) || $post['jumlah_pengeluaran'] == 0){
                $params = array("success" => false, "status" => 2);
            }elseif(empty($post['judul_pengeluaran'])){
                $params = array("success" => false, "status" => 3);
            }else{
                $data = [
                    'tipe_id'           => $post['tipe_kas'],
                    'kategori_id'       => $post['kategori_pengeluaran'],
                    'nominal'           => $post['jumlah_pengeluaran'],
                    'nama_transaksi'    => $post['judul_pengeluaran'],
                    'tanggal'           => $post['tanggal'],
                    'jenis_kas'         => 1, // kas besar = 1, kas kecil = 2
                    'user_id'           => userId(),
                ];
                $this->laporan_keuangan_model->addLaporan($data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['edit_pengeluaran'])){
            // print_r($post);

            if($post['kategori_pengeluaran'] == 0){
                $params = array("success" => false, "status" => 1);
            }elseif(empty($post['jumlah_pengeluaran']) || $post['jumlah_pengeluaran'] == 0){
                $params = array("success" => false, "status" => 2);
            }elseif(empty($post['judul_pengeluaran'])){
                $params = array("success" => false, "status" => 3);
            }else{
                $data = [
                    'kategori_id'       => $post['kategori_pengeluaran'],
                    'nominal'           => $post['jumlah_pengeluaran'],
                    'nama_transaksi'    => $post['judul_pengeluaran'],
                    'tanggal'           => $post['tanggal'],
                    'user_update'       => userId(),
                ];
                $this->laporan_keuangan_model->editLaporan($post['pengeluaran_id'], $data);
    
                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);
            
            
        }elseif(isset($_POST['delete_laporan'])){
            // print_r($post);

            $this->laporan_keuangan_model->deleteLaporan($post['id_laporan']);

            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
            echo json_encode($params);

        }elseif(isset($_POST['add_induk'])){
            // print_r($post);

            if(empty($post['nama_induk'])){
                $params = array("success" => false, "status" => 1);
            }else{
                $data = [
                    'nama_kategori' => $post['nama_induk'],
                    'user_id'       => userId(),
                ];
                $this->laporan_keuangan_model->addInduk($data);

                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['edit_induk'])){
            // print_r($post);

            if(empty($post['nama_induk'])){
                $params = array("success" => false, "status" => 1);
            }else{
                $data = [
                    'nama_kategori' => $post['nama_induk'],
                ];
                $this->laporan_keuangan_model->editInduk($post['induk_id'], $data);

                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);


        }elseif(isset($_POST['del_induk'])){
            // print_r($post);

            $kategori = $this->laporan_keuangan_model->kategoriTransaksi(NULL, NULL, $post['induk_id'], NULL, NULL);
            if($kategori->num_rows() > 0){
                $params = array("success" => false, "status" => 1);
            }else{
                $this->laporan_keuangan_model->deleteInduk($post['induk_id']);

                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['add_kategori'])){
            // print_r($post);

            if(empty($post['nama_kategori'])){
                $params = array("success" => false, "status" => 1);
            }elseif($post['induk_kategori'] == 0){
                $params = array("success" => false, "status" => 2);
            }elseif($post['tipe_transaksi'] == 0){
                $params = array("success" => false, "status" => 3);
            }else{
                $data = [
                    'nama_kategori' => $post['nama_kategori'],
                    'induk'         => $post['induk_kategori'],
                    'tipe'          => $post['tipe_transaksi'],
                    'user_id'       => userId(),
                ];
                $this->laporan_keuangan_model->addKategori($data);

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
            }elseif($post['induk_kategori'] == 0){
                $params = array("success" => false, "status" => 2);
            }elseif($post['tipe_transaksi'] == 0){
                $params = array("success" => false, "status" => 3);
            }else{
                $data = [
                    'nama_kategori' => $post['nama_kategori'],
                    'induk'         => $post['induk_kategori'],
                    'tipe'          => $post['tipe_transaksi'],
                ];
                $this->laporan_keuangan_model->editKategori($post['kategori_id'], $data);

                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);


        }elseif(isset($_POST['del_kategori'])){
            // print_r($post);

            $laporan = $this->laporan_keuangan_model->getLaporan(NULL, NULL, $post['kategori_id']);
            if($laporan->num_rows() > 0){
                $params = array("success" => false, "status" => 1);
            }else{
                $this->laporan_keuangan_model->deleteKategori($post['kategori_id']);

                if($this->db->affected_rows() > 0) {
                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            }
            echo json_encode($params);

        }elseif(isset($_POST['get_data'])){
            // print_r($post);
            // $lembaga = $this->fungsi->user_login()->id_lembaga;
            $data = $this->laporan_keuangan_model->getLaporan($post['laporan_id'], idLembaga())->row();
            if($data->tipe_id == 1){
                $tipe = 'Pemasukkan';
            }else{
                $tipe = 'Pengeluaran';
            }
            $params = [
                'tanggal'           => $data->tanggal,
                'kategori'          => $data->kategori_id,
                'nama_kategori'     => $data->nama_kategori,
                'nominal'           => $data->nominal,
                'nominal_rp'        => rupiah($data->nominal),
                'keterangan'        => $data->nama_transaksi,
                'id_laporan'        => $data->id,
                'tipe'              => $tipe,
                'tipe_id'           => $data->tipe_id,
            ];
            echo json_encode($params);

        }elseif(isset($_POST['get_kategori'])){
            // print_r($post);
            $data = $this->laporan_keuangan_model->getKategori($post['id_kategori'])->row();
            $params = [
                'nama_katagori'     => $data->kategori_nama,
                'nama_induk'        => $data->nama_induk,
                'nama_tipe'         => $data->nama_tipe,
            ];
            echo json_encode($params);

        }elseif(isset($_POST['changeTipe'])){
            // print_r($post);
            // kategoriTransaksi($id = NULL, $tipe = NULL, $induk = NULL, $nama = NULL, $limit = NULL, $lembaga = NULL)
            if($post['tipe']){
                $data = $this->laporan_keuangan_model->getKategori2($post['tipe'])->result();
            }else{
                $data = NULL;
            }
            echo json_encode($data);
        }
    }

    public function bulanan_ajax(){
        $list = $this->ajax_keuangan_model->get_datatables();
        $idRow = $this->ajax_keuangan_model->get_limit_id();
        $data = array();
        $no = $_POST['start'];
        $saldo = 0;
        foreach ($list as $laporan) {
            
            if(HakAkses(3)->update == 1){
                $statusU = NULL;
            }else{
                $statusU = 'disabled';
            }
            if(HakAkses(3)->delete == 1){
                $statusD = NULL;
            }else{
                $statusD = 'disabled';
            }
        
            if($this->input->post('periode')) {
                $tgl = explode(" - ", $this->input->post('periode'));
                $today = date('Y-m-d');
                if($tgl[0] == $today AND $tgl[1] == $today){
                    $cekSaldo = $this->laporan_keuangan_model->cekSaldo(NULL, NULL, idLembaga());
                }else{
                    $cekSaldo = $this->laporan_keuangan_model->cekSaldo($tgl[0], $tgl[1], idLembaga());
                }
            }else{
                $cekSaldo = $this->laporan_keuangan_model->cekSaldo(NULL, NULL, idLembaga());
            }
    
            $tanggal = explode(" ", $laporan->datetimes);
            if($laporan->id == $idRow->id){
                $saldo_awal = $cekSaldo->saldo_awal;
            }else{
                $saldo_awal = 0;
            }
            if($laporan->tipe_id == 1){
                $kredit = $laporan->nominal;
                $saldo = ($saldo + $kredit) + $saldo_awal;
                $btn_Edit = '
                    <div class="btn-group">
                        <button class="btn btn-success btn-xs" data-toggle="modal" id="set_edit_pemasukan" data-target="#edit-pemasukan" data-laporan_id="'.$laporan->id.'" '.$statusU.'>
                            <i class="fa fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                        </button>
                    </div>
                ';
            }else{
                $debit = $laporan->nominal;
                $saldo = ($saldo - $debit) + $saldo_awal;
                $btn_Edit = '
                    <div class="btn-group">
                        <button class="btn btn-success btn-xs" data-toggle="modal" id="set_edit_pengeluaran" data-target="#edit-pengeluaran" data-laporan_id="'.$laporan->id.'" '.$statusU.'>
                            <i class="fa fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                        </button>
                    </div>
                ';
            }

            $no++;
            $row = array();
            $row[] = $laporan->tanggal;
            $row[] = $laporan->nama_transaksi.'<br /><span class="small text-success">Kategori : '.$laporan->kategori.'</span>';
            $row[] = '<span class="badge badge-'.$laporan->warna_tipe.' text-uppercase">'.$laporan->nama_tipe.'</span>';
            $row[] = rupiah($laporan->nominal);
            $row[] = rupiah($saldo);
            $row[] = $btn_Edit.'
                <div class="btn-group">
                    <button class="btn btn-danger btn-xs" data-toggle="modal" id="set_delete" data-target="#delete-item" data-laporan_id="'.$laporan->id.'" '.$statusD.'>
                        <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                    </button>
                </div>
            ';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ajax_keuangan_model->count_all(),
            "recordsFiltered" => $this->ajax_keuangan_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    
    }

    public function tahunan_ajax(){
        $list = $this->ajax_keuangan_tahunan_model->get_datatables();
        $data = array();
        $no = $_POST['start'];

        $saldo = 0;
        $cashIn1 = 0;
        $cashOut1 = 0;

        foreach ($list as $tahunan) {
            $kategori = $this->laporan_keuangan_model->kategoriTransaksi(NULL, NULL, $row->id, NULL, NULL)->result();

            $no++;
            $row = array();
            $row[] = '<span class="text-uppercase text-bold">'.$tahunan->nama_kategori.'</span>';
            $row[] = '';
            $row[] = '';
            $row[] = '';

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ajax_keuangan_tahunan_model->count_all(),
            "recordsFiltered" => $this->ajax_keuangan_tahunan_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    
    }

    public function saldo_ajax(){
        $list = $this->ajax_saldo_model->get_datatables();
        $sa = $this->ajax_saldo_model->getSaldoAwal();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $saldo) {
            $no++;
            $row = array();
            $row[] = rupiah($sa->saldo_awal);
            $row[] = rupiah($saldo->pemasukan);
            $row[] = rupiah($saldo->pengeluaran);
            $row[] = rupiah($sa->saldo_awal + ($saldo->pemasukan - $saldo->pengeluaran));
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ajax_saldo_model->count_all(),
            "recordsFiltered" => $this->ajax_saldo_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    
    }

    public function saldo2_ajax(){
        $list = $this->ajax_saldo2_model->get_datatables();
        $sa = $this->ajax_saldo2_model->getSaldoAwal();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $saldo) {
            $no++;
            $row = array();
            $row[] = rupiah($sa->saldo_awal);
            $row[] = rupiah($saldo->pemasukan);
            $row[] = rupiah($saldo->pengeluaran);
            $row[] = rupiah($sa->saldo_awal + $saldo->saldo_akhir);
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ajax_saldo2_model->count_all(),
            "recordsFiltered" => $this->ajax_saldo2_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    
    }





}