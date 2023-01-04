<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(masterModel());
        $this->load->model('Proyek_model');
        $this->load->library('fungsi');
        $this->load->library('form_validation');
        checkLoginGagal();
        // checkLogin();

    }

    private function index() {
        redirect('dashboard');
    }
    
    // print laporan keuangan bulanan
    function plkb() {
        $pdf            = $this->input->get('pdf');
        $periode        = $this->input->get('periode');
        $tgl            = explode(" - ", $periode);
        $today          = date('Y-m-d');
        $awal           = date_create($tgl[0]);
        $akhir          = date_create($tgl[1]);
        $hariIni        = date_create($today);
        $tanggalAwal    = date_format($awal,"j");
        $tanggalAkhir   = date_format($akhir,"j F Y");
        if($tgl[0] == $today AND $tgl[1] == $today){
            $bulan = date_format($hariIni,"F Y");
            $periodeTanggal = $bulan;
        }else{
            $periodeTanggal = $tanggalAwal.' - '.$tanggalAkhir;
        }

        // if($id != NULL){
        if(strtotime($tgl[0]) !== false && strtotime($tgl[1]) !== false){
            $data = [
                'saldo2'             => $this->ajax_saldo_model->getInfoSaldo($periode, idLembaga()),
                'sa'                => $this->ajax_saldo_model->getSaldoAwal2($periode, idLembaga()),
                'laporan'           => $this->laporan_keuangan_model->cetakLaporanBulanan($periode, idLembaga())->result(),
                'profile'           => $this->master_model->getProfile(idLembaga())->row(),
                'periodeTanggal'    => $periodeTanggal,
                'idRow'             => $this->laporan_keuangan_model->get_limit_id($periode, idLembaga()),
                'pdf'               => $pdf,
            ];
            if($pdf == 1){
                $html = $this->load->view('print/laporan_keuangan_bulanan', $data, TRUE);
                $this->fungsi->pdfGenerator($html, 'laporan_keuangan_bulanan-'.date('Y-m-d-Hms'), 'A4', 'portrait');
            }elseif($pdf == 0){
                $this->load->view('print/laporan_keuangan_bulanan', $data);
            }else{
                redirect('dashboard');
            }
        }else{
            redirect('dashboard');
        }

    }

    //print laporan keuangan tahunan
    function plkt($id = NULL) {
        $pdf            = $this->input->get('pdf');
        $kat            = $this->laporan_keuangan_model->kategoriTransaksi(NULL, NULL, NULL, NULL, NULL, idLembaga());
        $induk          = $this->laporan_keuangan_model->kategoriInduk(NULL, NULL, idLembaga());
        $tipe           = $this->laporan_keuangan_model->tipeTransaksi();

        if($id != NULL){
            $id = $id;
        }else{
            $id = date('Y');
        }
        $data = array(
            'profile'   => $this->master_model->getProfile(idLembaga())->row(),
            'saldo2'    => $this->ajax_saldo2_model->getInfoSaldo($id, idLembaga()),
            'sa'        => $this->ajax_saldo2_model->getSaldoAwal2($id, idLembaga()),
            'tahun'     => $id,
            'kat'       => $kat,
            'induk'     => $induk,
            'tipe'      => $tipe,
            'pdf'       => $pdf,
        );
        if($pdf == 1){
            $html = $this->load->view('print/laporan_keuangan_tahunan', $data, TRUE);
            $this->fungsi->pdfGenerator($html, 'laporan_keuangan_tahunan-'.date('Y-m-d-Hms'), 'A4', 'portrait');
        }elseif($pdf == 0){
            $this->load->view('print/laporan_keuangan_tahunan', $data);
        }else{
            redirect('dashboard');
        }

    }

    //print laporan keuangan tahunan
    function laba_rugi($id = NULL) {
        $pdf            = $this->input->get('pdf');
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
            'pdf'       => $pdf,
        );

        if($pdf == 1){
            $html = $this->load->view('print/laba_rugi', $data, TRUE);
            $this->fungsi->pdfGenerator($html, 'laba_rugi-'.date('Y-m-d-Hms'), 'A4', 'portrait');
        }elseif($pdf == 0){
            $this->load->view('print/laba_rugi', $data);
        }else{
            redirect('dashboard');
        }

    }

    //print Daftar Barang Inventaris
    function daftarbarang($id = NULL) {
        $pdf            = $this->input->get('pdf');

        $data = [
            'list'          => $this->ajax_produk_model->getBarang($id, idLembaga())->result(),
            'profile'       => $this->master_model->getProfile(idLembaga())->row(),
            'kategori'      => $id,
            'pdf'           => $pdf,
        ];
        if($pdf == 1){
            $html = $this->load->view('print/daftar_barang', $data, TRUE);
            $this->fungsi->pdfGenerator($html, 'daftar_barang-'.date('Y-m-d-Hms'), 'A4', 'portrait');
        }elseif($pdf == 0){
            $this->load->view('print/daftar_barang', $data);
        }else{
            redirect('dashboard');
        }
    }

    //print Keluar Masuk Barang 
    function in_out() {
        $periode    = $this->input->get('periode');
        $tipe       = $this->input->get('tipe');
        $pdf        = $this->input->get('pdf');

        $data = [
            'list'          => $this->ajax_history_stok_model->getStok($periode, $tipe, idLembaga()),
            'profile'       => $this->master_model->getProfile(idLembaga())->row(),
            'pdf'           => $pdf,
        ];
        if($pdf == 1){
            $html = $this->load->view('print/keluar_masuk_barang', $data, TRUE);
            $this->fungsi->pdfGenerator($html, 'keluar_masuk_barang-'.date('Y-m-d-Hms'), 'A4', 'portrait');
        }elseif($pdf == 0){
            $this->load->view('print/keluar_masuk_barang', $data);
        }else{
            redirect('dashboard');
        }
    }

    //print Keluar Masuk Barang 
    function laporan_barang() {
        $periode    = $this->input->get('periode');
        $tipe       = $this->input->get('tipe');
        $pdf        = $this->input->get('pdf');

        $data = [
            'list'          => $this->ajax_laporan_stok_model->getLaporan($periode, $tipe, idLembaga()),
            'profile'       => $this->master_model->getProfile(idLembaga())->row(),
            'pdf'           => $pdf,
        ];
        if($pdf == 1){
            $html = $this->load->view('print/laporan_barang', $data, TRUE);
            $this->fungsi->pdfGenerator($html, 'laporan_barang-'.date('Y-m-d-Hms'), 'A4', 'portrait');
        }elseif($pdf == 0){
            $this->load->view('print/laporan_barang', $data);
        }else{
            redirect('dashboard');
        }
    }

    //print Detail RAB 
    function rab_detail($id = NULL) {
        $pdf        = $this->input->get('pdf');

        if($id != NULL){
            $rab = $this->rab_model->getRAB($id, NULL, idLembaga());
            if($rab->num_rows() > 0){
                $data = [
                    'rab'       => $rab->row(),
                    'detail'    => $this->rab_model->getDetailRAB(NULL, NULL, NULL, idLembaga(), NULL, $rab->row()->id),
                    'unit'      => $this->inventaris_model->listUnit(NULL, idLembaga())->result(),
                    'profile'   => $this->master_model->getProfile(idLembaga())->row(),
                    'pdf'       => $pdf,
                ];
                if($pdf == 1){
                    $html = $this->load->view('print/rab_detail', $data, TRUE);
                    $this->fungsi->pdfGenerator($html, 'rab_detail-'.date('Y-m-d-Hms'), 'A4', 'portrait');
                }elseif($pdf == 0){
                    $this->load->view('print/rab_detail', $data);
                }else{
                    redirect('dashboard');
                }
                    }else{
                redirect('dashboard');
            }
        }else{
            redirect('dashboard');
        }
    }

    //print Detail RAB 
    function material_keluar($id = NULL) {
        $pdf        = $this->input->get('pdf');

        if($id != NULL){
            $rab = $this->Proyek_model->listPengajuan($id);
            if($rab->num_rows() > 0){
                $data = [
                    'rab'       => $rab->row(),
                    'tipe'      => $this->Proyek_model->listKavlingProyek($id)->result(),
                    'blok'      => $this->Proyek_model->KavlingCount($id)->result(),
                    'kavling'  => $this->Proyek_model->RabKavling($id)->result(),
                    'detail'    => $this->Proyek_model->CetakDetailRAB($id)->result(),
                    'belanja'    => $this->Proyek_model->CetakDetailBelanja($id)->result(),
                    'material'    => $this->Proyek_model->getDetailRAB($id)->result(),
                    'profile'   => $this->master_model->getProfile(idLembaga())->row(),
                    'pdf'       => $pdf,
                ];
                if($pdf == 1){
                    $html = $this->load->view('print/material_keluar', $data, TRUE);
                    $this->fungsi->pdfGenerator($html, 'material_keluar-'.date('Y-m-d-Hms'), 'A4', 'portrait');
                }elseif($pdf == 0){
                    $this->load->view('print/material_keluar', $data);
                }else{
                    redirect('dashboard');
                }
                    }else{
                redirect('dashboard');
            }
        }else{
            redirect('dashboard');
        }
    }


     //print Detail RAB 
     function rab($id = NULL) {

        $pdf        = $this->input->get('pdf');

        if($id != NULL){
            $rab = $this->Proyek_model->listPengajuan($id);
            
            if($rab->num_rows() > 0){

                $material = "SELECT tbl_proyek_material.total,tbl_tipe.tipe,
                SUM(tbl_proyek_material.total) as total_harga FROM `tbl_proyek_material`
                
                JOIN tbl_tipe ON tbl_tipe.id_tipe = tbl_proyek_material.tipe_id
                where tbl_proyek_material.proyek_id = $id
                GROUP BY tbl_tipe.tipe";

                $upah ="SELECT tbl_proyek_upah.harga_kontrak,tbl_tipe.tipe,
                SUM(tbl_proyek_upah.harga_kontrak) as total_harga_kontrak FROM `tbl_proyek_upah`
                
                JOIN tbl_tipe ON tbl_tipe.id_tipe = tbl_proyek_upah.tipe_id
                where tbl_proyek_upah.proyek_id = $id
                GROUP BY tbl_tipe.tipe";

                $lainnya ="SELECT tbl_proyek_lainnya.harga_lainnya,tbl_tipe.tipe,
                SUM(tbl_proyek_lainnya.harga_lainnya) as total_lainnya FROM `tbl_proyek_lainnya`
                
                JOIN tbl_tipe ON tbl_tipe.id_tipe = tbl_proyek_lainnya.tipe_id
                where tbl_proyek_lainnya.proyek_id = $id
                GROUP BY tbl_tipe.tipe";


                $data = [
                    'id_pro'    => $id,
                    'rab'       => $rab->row(),
                    'tipe'      => $this->Proyek_model->listKavlingProyek($id)->result(),
                    'kavling'   => $this->Proyek_model->RabKavling($id)->result(),
                    'detail'    => $this->Proyek_model->AllRABMat($id)->result(),
                    'material'  => $this->db->query($material)->result(),
                    'upah'      => $this->db->query($upah)->result(),
                    'lainnya'   => $this->db->query($lainnya)->result(),
                    'UpahTOtal' => $this->Proyek_model->UpahTotal($id)->result(),
                    'LainnyaTotal' => $this->Proyek_model->LainnyaTotal($id)->result(),
                    'totalKavling'      => $this->Proyek_model->TotalKav($id)->result(),
                    'profile'   => $this->master_model->getProfile(idLembaga())->row(),
                    'pdf'       => $pdf,
                ];
                if($pdf == 1){
                    $html = $this->load->view('print/rab', $data, TRUE);
                    $this->fungsi->pdfGenerator($html, 'rab-'.date('Y-m-d-Hms'), 'A4', 'portrait');
                }elseif($pdf == 0){
                    $this->load->view('print/rab', $data);
                }else{
                    redirect('dashboard');
                }
                    }else{
                redirect('dashboard');
            }
        }else{
            redirect('dashboard');
        }
    }
}

?>

