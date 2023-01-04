<?php
defined('BASEPATH')or exit('No direct script access allowed');
class Accounting extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        checkLoginGagal();
        $this->load->model('Proyek_model','proyek');
    }

    public function get_sub_kode(){
        $id_kode = $_POST['id_kode'];
        $sub_kode = $this->db->order_by('sub_kode','ASC')->get_where('sub_kode',['id_kode' => $id_kode])->result();
        echo json_encode($sub_kode);
    }

    public function get_title_kode(){
        $id_sub = $_POST['id'];
        $title_kode = $this->db->order_by('kode_title', 'ASC')->get_where('title_kode',['id_sub' => $id_sub])->result();
        echo json_encode($title_kode);
    }

    public function bank(){
        $id_perumahan = $this->session->userdata('id_perumahan');
        
        

        if(isset($_GET['cluster'])){
            $cluster = $_GET['cluster'];

            if($cluster == null){
                $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling WHERE tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tbl_marketing.status != 0 AND tbl_marketing.status != 3 AND tbl_kavling.id_perum = $id_perumahan";
            } else {
                $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling WHERE tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tbl_marketing.status != 0 AND tbl_marketing.status != 3 AND tbl_kavling.id_perum = $id_perumahan AND tbl_kavling.id_cluster = $cluster";
            }

        } else {
            $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling WHERE tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tbl_marketing.status != 0 AND tbl_marketing.status != 3 AND tbl_kavling.id_perum = $id_perumahan";
        }

        

        $data['bank'] = $this->db->query($q)->result();
        $data['kode'] = $this->db->order_by('kode','ASC')->get('kode')->result();
        $this->template->load('template', 'accounting/bank', $data);
    }

    public function get_tjl(){
        $id = $_POST['id'];
        $data['data'] = $this->db->get_where('tanda_jadi_lokasi',['id_konsumen' => $id])->result();
        $this->load->view('accounting/bank_tjl', $data);
    }

    public function get_um(){
        $id = $_POST['id'];
        $data['data'] = $this->db->get_where('uang_muka',['id_konsumen' => $id])->result();
        $this->load->view('accounting/bank_um', $data);
    }

    public function get_kt(){
        $id = $_POST['id'];
        $data['data'] = $this->db->get_where('kelebihan_tanah',['id_konsumen' => $id])->result();
        $this->load->view('accounting/bank_kt', $data);
    }

    public function get_pak(){
        $id = $_POST['id'];
        $data['data'] = $this->db->get_where('pak',['id_konsumen' => $id])->result();
        $this->load->view('accounting/bank_pak', $data);
    }

    public function get_lain(){
        $id = $_POST['id'];
        $data['data'] = $this->db->get_where('lain_lain',['id_konsumen' => $id])->result();
        $this->load->view('accounting/bank_lain', $data);
    }

    public function gen_tjl($id){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= Tanda jadi lokasi bank.xls");
        $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling, tanda_jadi_lokasi, bank_cicil_tjl WHERE tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tanda_jadi_lokasi.id_konsumen = tbl_marketing.id_marketing AND tanda_jadi_lokasi.id_tjl = bank_cicil_tjl.id_pembayaran AND bank_cicil_tjl.id_cicil = $id";
        // $data['tjl'] = $this->db->get_where('tanda_jadi_lokasi',['id_konsumen' => $id])->result();
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Tanda Jadi Lokasi';
        // $this->load->view('accounting/bank_gen_tjl', $data);
        $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        return $this->print_kwitansi($html);
    }

    public function gen_um($id){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= Uang Muka.xls");
        $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling, uang_muka, bank_cicil_um WHERE tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND uang_muka.id_konsumen = tbl_marketing.id_marketing AND uang_muka.id_um = bank_cicil_um.id_pembayaran AND bank_cicil_um.id_cicil = $id";
        // $data['tjl'] = $this->db->query($q)->row();
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Uang Muka';
        // $this->load->view('accounting/bank_gen_um', $data);
        $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        return $this->print_kwitansi($html);

    }

    public function gen_kt($id){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= Kelebihan Tanah.xls");
        $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling, kelebihan_tanah, bank_cicil_kt WHERE tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND kelebihan_tanah.id_konsumen = tbl_marketing.id_marketing AND kelebihan_tanah.id_kt = bank_cicil_kt.id_pembayaran AND bank_cicil_kt.id_cicil = $id";
        // $data['tjl'] = $this->db->query($q)->row();
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Kelebihan Tanah';

        // $this->load->view('accounting/bank_gen_kt', $data);
        $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        return $this->print_kwitansi($html);

    }

    public function gen_pak($id){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= pak.xls");
        $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling, pak, bank_cicil_pak WHERE tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND pak.id_konsumen = tbl_marketing.id_marketing AND pak.id_pak = bank_cicil_pak.id_pembayaran AND bank_cicil_pak.id_cicil = $id";
        // $data['tjl'] = $this->db->query($q)->row();
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'PAK';
        $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        return $this->print_kwitansi($html);
        // $this->load->view('accounting/bank_gen_pak', $data);
    }

    public function gen_lain($id){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= lain-lain.xls");
        $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling, lain_lain, bank_cicil_lain WHERE tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND lain_lain.id_konsumen = tbl_marketing.id_marketing AND lain_lain.id_lain = bank_cicil_lain.id_pembayaran AND bank_cicil_lain.id_cicil = $id";
        // $data['tjl'] = $this->db->query($q)->row();
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Lain-lain';
        $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        return $this->print_kwitansi($html);
        // $this->load->view('accounting/bank_gen_lain', $data);
    }

    public function gen_angsuran($id){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= lain-lain.xls");
        $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling, angsuran_bank, bank_cicil_rb WHERE tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND angsuran_bank.id_konsumen = tbl_marketing.id_marketing AND angsuran_bank.id_angsur = bank_cicil_rb.id_pembayaran AND bank_cicil_rb.id_cicil = $id";
        // $data['tjl'] = $this->db->query($q)->row();
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Realisasi Bank';
        $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        return $this->print_kwitansi($html);
        // $this->load->view('accounting/bank_gen_lain', $data);
    }

    public function gen_piutang($id){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= lain-lain.xls");
        $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling, piutang_bank, bank_cicil_pb WHERE tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND piutang_bank.id_konsumen = tbl_marketing.id_marketing AND piutang_bank.id_piutang = bank_cicil_pb.id_pembayaran AND bank_cicil_pb.id_cicil = $id";
        // $data['tjl'] = $this->db->query($q)->row();
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Piutang Bank';
        $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        return $this->print_kwitansi($html);
        // $this->load->view('accounting/bank_gen_lain', $data);
    }





    public function inhouse(){
        $id_perumahan = $this->session->userdata('id_perumahan');

        if(isset($_GET['cluster'])){
            $cluster = $_GET['cluster'];

            if($cluster == null){
                $q = "SELECT * FROM tbl_transaksi_inhouse, tbl_marketing, tbl_kavling WHERE tbl_transaksi_inhouse.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND tbl_marketing.status != 0 AND tbl_marketing.status != 2 AND tbl_kavling.id_perum = $id_perumahan";
            } else {
                $q = "SELECT * FROM tbl_transaksi_inhouse, tbl_marketing, tbl_kavling WHERE tbl_transaksi_inhouse.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND tbl_marketing.status != 0 AND tbl_marketing.status != 2 AND tbl_kavling.id_perum = $id_perumahan AND tbl_kavling.id_cluster = $cluster";
            }

        } else {
            $q = "SELECT * FROM tbl_transaksi_inhouse, tbl_marketing, tbl_kavling WHERE tbl_transaksi_inhouse.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND tbl_marketing.status != 0 AND tbl_marketing.status != 2 AND tbl_kavling.id_perum = $id_perumahan";
        }


        


        $data['bank'] = $this->db->query($q)->result();
        $data['kode'] = $this->db->order_by('kode','ASC')->get('kode')->result();
        $this->template->load('template', 'accounting/inhouse', $data);
    }

    public function get_hk_inhouse(){
        $id = $_POST['id'];
        $data['data'] = $this->db->get_where('harga_kesepakatan_inhouse',['id_konsumen' => $id])->result();
        $this->load->view('accounting/inhouse_hk', $data);
    }

    public function get_tjl_inhouse(){
        $id = $_POST['id'];
        $data['data'] = $this->db->get_where('tanda_jadi_lokasi_inhouse',['id_konsumen' => $id])->result();
        $this->load->view('accounting/inhouse_tjl', $data);
    }

    public function get_um_inhouse(){
        $id = $_POST['id'];
        $data['data'] = $this->db->get_where('uang_muka_inhouse',['id_konsumen' => $id])->result();
        $this->load->view('accounting/inhouse_um', $data);
    }

    public function get_kt_inhouse(){
        $id = $_POST['id'];
        $data['data'] = $this->db->get_where('kelebihan_tanah_inhouse',['id_konsumen' => $id])->result();
        $this->load->view('accounting/inhouse_kt', $data);
    }

    public function gen_hk($id){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= Harga Kesepakatan.xls");
        $q = "SELECT * FROM tbl_transaksi_inhouse, tbl_marketing, tbl_kavling, harga_kesepakatan_inhouse, inhouse_cicil_hk WHERE tbl_transaksi_inhouse.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND harga_kesepakatan_inhouse.id_konsumen = tbl_marketing.id_marketing AND harga_kesepakatan_inhouse.id_kesepakatan = inhouse_cicil_hk.id_pembayaran AND inhouse_cicil_hk.id_cicil = $id";
        // $data['tjl'] = $this->db->query($q)->row();
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Harga Kesepakatan';
        $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        return $this->print_kwitansi($html);
        // $this->load->view('accounting/inhouse_gen_hk', $data);
    }

    public function gen_inhouse_tjl($id){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= Tanda Jadi Lokasi Inhouse.xls");
        $q = "SELECT * FROM tbl_transaksi_inhouse, tbl_marketing, tbl_kavling, tanda_jadi_lokasi_inhouse, inhouse_cicil_tjl WHERE tbl_transaksi_inhouse.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND tanda_jadi_lokasi_inhouse.id_konsumen = tbl_marketing.id_marketing AND tanda_jadi_lokasi_inhouse.id_tjl = inhouse_cicil_tjl.id_pembayaran AND inhouse_cicil_tjl.id_cicil = $id";
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Tanda Jadi Lokasi';
        $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        return $this->print_kwitansi($html);
        // $data['tjl'] = $this->db->query($q)->row();
        // $this->load->view('accounting/inhouse_gen_tjl', $data);
    }


    public function gen_inhouse_um($id){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= Uang Muka.xls");
        $q = "SELECT * FROM tbl_transaksi_inhouse, tbl_marketing, tbl_kavling, uang_muka_inhouse, inhouse_cicil_um WHERE tbl_transaksi_inhouse.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND uang_muka_inhouse.id_konsumen = tbl_marketing.id_marketing AND uang_muka_inhouse.id_um = inhouse_cicil_um.id_pembayaran AND inhouse_cicil_um.id_cicil = $id";
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Uang Muka';
        $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        return $this->print_kwitansi($html);
        // $data['tjl'] = $this->db->query($q)->row();
        // $this->load->view('accounting/inhouse_gen_um', $data);
    }

    public function gen_inhouse_kt($id){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= Kelebihan Tanah.xls");
        $q = "SELECT * FROM tbl_transaksi_inhouse, tbl_marketing, tbl_kavling, kelebihan_tanah_inhouse, inhouse_cicil_kt WHERE tbl_transaksi_inhouse.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND kelebihan_tanah_inhouse.id_konsumen = tbl_marketing.id_marketing AND kelebihan_tanah_inhouse.id_kt = inhouse_cicil_kt.id_pembayaran AND inhouse_cicil_kt.id_cicil = $id";
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Kelebihan Tanah';
        $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        return $this->print_kwitansi($html);
        // $data['tjl'] = $this->db->query($q)->row();
        // $this->load->view('accounting/inhouse_gen_kt', $data);
    }


    public function print_kwitansi($html){
        // $html = 'hello';
        require FCPATH . 'assets/mpdf/vendor/autoload.php';
        $pdf = new \Mpdf\Mpdf([
            'format' => 'A4-P',
        ]);
        $pdf->AddPageByArray([
            'margin-left' => 5,
            'margin-right' => 5,
            'margin-top' => 5,
            'margin-bottom' => 0,
        ]);
        $pdf->WriteHTML($html);
        $pdf->Output();
    }


    public function input_bukti_pembayaran(){
        $img = $_FILES['bukti'];
        $title_kode = $this->input->post('title_kode');


        if($img){
            $config['upload_path']          = './assets/bukti_pembayaran/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);

            if($this->upload->do_upload('bukti')){
                $bukti = $this->upload->data('file_name');
            } else {
                $msg = 'Bukti pembayaran gagal di upload';
                echo json_encode($msg);
            }
        }


        $data = [
            'id_pembayaran' => $this->input->post('id'),
            'db' => $this->input->post('db'),
            'bukti_pembayaran' => $bukti
        ];

        if($this->db->insert('bukti_pembayaran', $data)){
            
            $type = $this->input->post('type');

            if($type == 'b_tjl'){
                $this->confirm_bank_tjl($title_kode);
            } 
            else if($type == 'b_um'){
                $this->confirm_bank_um($title_kode);
            }
            else if($type == 'b_kt'){
                $this->confirm_bank_kt($title_kode);
            }
            else if($type == 'b_pak'){
                $this->confirm_bank_pak($title_kode);
            }
            else if($type == 'b_lain'){
                $this->confirm_bank_lain($title_kode);
            }
            else if($type == 'b_angsur'){
                $this->confirm_bank_angsuran($title_kode);
            }
            else if($type == 'b_piutang'){
                $this->confirm_bank_piutang($title_kode);
            }
            else if($type == 'i_hk'){
                $this->confirm_inhouse_hk($title_kode);
            }
            else if($type == 'i_tjl'){
                $this->confirm_inhouse_tjl($title_kode);
            }
            else if($type == 'i_um'){
                $this->confirm_inhouse_um($title_kode);
            }
            else if($type == 'i_kt'){
                $this->confirm_inhouse_kt($title_kode);
            }
            else if($type == 'b_tj'){
                $this->confirm_tj_bank($title_kode);
            }
            else if($type == 'i_tj'){
                $this->confirm_tj_inhouse($title_kode);
            }

        } else {
            $msg = 'Bukti pembayaran gagal di upload';
            echo json_encode($msg);
        }

        


    }




    //Konfirmasi Pembayaran
    public function count_denda($id, $db, $db_where, $title_kode){
        $today = date('Y-m-d');
        $data = $this->db->get_where($db, [$db_where => $id])->row();
            
        if($data->jatuh_tempo < $today){
                    // jika telat
                    $now = date_create(date('Y-m-d'));
                    $tenggat = date_create($data->jatuh_tempo);
                    $telat = date_diff($tenggat, $now);
                    $hari = $telat->format("%a");
                    $denda = 0.5 / 100 * $data->cicilan_angsuran * $hari;
        } else {
                    // tidak telat
                    $denda = 0;
        }

        $data = [
            'status' => 2,
            'tgl_pembayaran' => date('Y-m-d'),
            'denda' => $denda,
            'title_kode' => $title_kode
        ];

        if($this->db->where($db_where, $id)->update($db, $data)){
            $params = 'Pembayaran Berhasil';
        } else {
            $params = 'Pembayaran Gagal';
        }

        echo json_encode($params);
    }



    public function approve($id, $db, $db_where){

        $ThisTable = $this->db->get_where($db,[$db_where => $id])->row();
        $title_kode = $ThisTable->title_kode;
        $jml = $ThisTable->cicilan_angsuran + $ThisTable->denda;
        $id_perum = $ThisTable->id_perumahan;

        $data = [
            'status' => 1,
            'tgl_pembayaran' => date('Y-m-d')
        ];
        if($this->db->where($db_where, $id)->update($db, $data)){
            $this->toHistoryApprove($title_kode, $jml, $id_perum);
            $params = ['msg' => 'Pembayaran Di Terima'];
        } else {
            $params = ['msg' => 'Pembayaran Gagal Di Terima'];
        }
        echo json_encode($params);
    }

    public function reject($id, $db, $db_where){
        if($this->db->set('status', 3)->where($db_where, $id)->update($db)){
            $params = ['msg' => 'Pembayaran Di Tolak'];
        } else {
            $params = ['msg' => 'Pembayaran Gagal Di Tolak'];
        }
        echo json_encode($params);
    }

    public function delete($id, $db, $db_where){
        if($this->db->delete($db,[$db_where => $id])){
            $params = ['msg' => 'Pembayaran Berhasil di hapus'];
        } else {
            $params = ['msg' => 'Pembayaran Gagal di hapus'];
        }
        echo json_encode($params);
    }


    //konfirmasi pembayaran bank Tanda jadi lokasi
    public function confirm_bank_tjl($title_kode){
        $id = $_POST['id'];
        $db = 'tanda_jadi_lokasi';
        $db_where = 'id_tjl';
        $this->count_denda($id, $db, $db_where, $title_kode);
    }
    public function approve_bank_tjl(){
        $id = $_POST['id'];
        $db = 'tanda_jadi_lokasi';
        $db_where = 'id_tjl';
        $this->approve($id, $db, $db_where);
    }
    public function reject_bank_tjl(){
        $id = $_POST['id'];
        $db = 'tanda_jadi_lokasi';
        $db_where = 'id_tjl';
        $this->reject($id, $db, $db_where);
    }
    public function delete_bank_tjl(){
        $id = $_POST['id'];
        $db = 'tanda_jadi_lokasi';
        $db_where = 'id_tjl';
        $this->delete($id, $db, $db_where);
    }

    //Pembayaran transaksi bank uang muka
    public function confirm_bank_um($title_kode){
        $id = $_POST['id'];
        $db = 'uang_muka';
        $db_where = 'id_um';
        $this->count_denda($id, $db, $db_where, $title_kode);
    }
    public function approve_bank_um(){
        $id = $_POST['id'];
        $db = 'uang_muka';
        $db_where = 'id_um';
        $this->approve($id, $db, $db_where);
    }
    public function reject_bank_um(){
        $id = $_POST['id'];
        $db = 'uang_muka';
        $db_where = 'id_um';
        $this->reject($id, $db, $db_where);
    }
    public function delete_bank_um(){
        $id = $_POST['id'];
        $db = 'uang_muka';
        $db_where = 'id_um';
        $this->delete($id, $db, $db_where);
    }

    //Pembayaran transaksi bank Kelebihan Tanah
    public function confirm_bank_kt($title_kode){
        $id = $_POST['id'];
        $db = 'kelebihan_tanah';
        $db_where = 'id_kt';
        $this->count_denda($id, $db, $db_where, $title_kode);
    }
    public function approve_bank_kt(){
        $id = $_POST['id'];
        $db = 'kelebihan_tanah';
        $db_where = 'id_kt';
        $this->approve($id, $db, $db_where);
    }
    public function reject_bank_kt(){
        $id = $_POST['id'];
        $db = 'kelebihan_tanah';
        $db_where = 'id_kt';
        $this->reject($id, $db, $db_where);
    }
    public function delete_bank_kt(){
        $id = $_POST['id'];
        $db = 'kelebihan_tanah';
        $db_where = 'id_kt';
        $this->delete($id, $db, $db_where);
    }


    //Pembayaran transaksi bank PAK
    public function confirm_bank_pak($title_kode){
        $id = $_POST['id'];
        $db = 'pak';
        $db_where = 'id_pak';
        $this->count_denda($id, $db, $db_where, $title_kode);
    }
    public function approve_bank_pak(){
        $id = $_POST['id'];
        $db = 'pak';
        $db_where = 'id_pak';
        $this->approve($id, $db, $db_where);
    }
    public function reject_bank_pak(){
        $id = $_POST['id'];
        $db = 'pak';
        $db_where = 'id_pak';
        $this->reject($id, $db, $db_where);
    }
    public function delete_bank_pak(){
        $id = $_POST['id'];
        $db = 'pak';
        $db_where = 'id_pak';
        $this->delete($id, $db, $db_where);
    }
    
    
    //Pembayaran transaksi bank Lain-lain
    public function confirm_bank_lain($title_kode){
        $id = $_POST['id'];
        $db = 'lain_lain';
        $db_where = 'id_lain';
        $this->count_denda($id, $db, $db_where, $title_kode);
    }
    public function approve_bank_lain(){
        $id = $_POST['id'];
        $db = 'lain_lain';
        $db_where = 'id_lain';
        $this->approve($id, $db, $db_where);
    }
    public function reject_bank_lain(){
        $id = $_POST['id'];
        $db = 'lain_lain';
        $db_where = 'id_lain';
        $this->reject($id, $db, $db_where);
    }
    public function delete_bank_lain(){
        $id = $_POST['id'];
        $db = 'lain_lain';
        $db_where = 'id_lain';
        $this->delete($id, $db, $db_where);
    }


    //Pembayaran transaksi bank Angsuran Bank
    public function confirm_bank_angsuran($title_kode){
        $id = $_POST['id'];
        $db = 'angsuran_bank';
        $db_where = 'id_angsur';
        $this->count_denda($id, $db, $db_where, $title_kode);
    }
    public function approve_bank_angsuran(){
        $id = $_POST['id'];
        $db = 'angsuran_bank';
        $db_where = 'id_angsur';
        $this->approve($id, $db, $db_where);
    }
    public function reject_bank_angsuran(){
        $id = $_POST['id'];
        $db = 'angsuran_bank';
        $db_where = 'id_angsur';
        $this->reject($id, $db, $db_where);
    }
    public function delete_bank_angsuran(){
        $id = $_POST['id'];
        $db = 'angsuran_bank';
        $db_where = 'id_angsur';
        $this->delete($id, $db, $db_where);
    }


    //Pembayaran transaksi bank piutang 
    public function confirm_bank_piutang($title_kode){
        $id = $_POST['id'];
        $db = 'piutang_bank';
        $db_where = 'id_piutang';
        $this->count_denda($id, $db, $db_where, $title_kode);
    }
    public function approve_bank_piutang(){
        $id = $_POST['id'];
        $db = 'piutang_bank';
        $db_where = 'id_piutang';
        $this->approve($id, $db, $db_where);
    }
    public function reject_bank_piutang(){
        $id = $_POST['id'];
        $db = 'piutang_bank';
        $db_where = 'id_piutang';
        $this->reject($id, $db, $db_where);
    }
    public function delete_bank_piutang(){
        $id = $_POST['id'];
        $db = 'piutang_bank';
        $db_where = 'id_piutang';
        $this->delete($id, $db, $db_where);
    }



    //konfirmasi pembayaran inhouse harga kesepakan
    public function confirm_inhouse_hk($title_kode){
        $id = $_POST['id'];
        $db = 'harga_kesepakatan_inhouse';
        $db_where = 'id_kesepakatan';
        $this->count_denda($id, $db, $db_where, $title_kode);
    }
    public function approve_inhouse_hk(){
        $id = $_POST['id'];
        $db = 'harga_kesepakatan_inhouse';
        $db_where = 'id_kesepakatan';
        $this->approve($id, $db, $db_where);
    }
    public function reject_inhouse_hk(){
        $id = $_POST['id'];
        $db = 'harga_kesepakatan_inhouse';
        $db_where = 'id_kesepakatan';
        $this->reject($id, $db, $db_where);
    }
    public function delete_inhouse_hk(){
        $id = $_POST['id'];
        $db = 'harga_kesepakatan_inhouse';
        $db_where = 'id_kesepakatan';
        $this->delete($id, $db, $db_where);
    }


    //pembayaran inhouse tanda jadi lokasi
    public function confirm_inhouse_tjl($title_kode){
        $id = $_POST['id'];
        $db = 'tanda_jadi_lokasi_inhouse';
        $db_where = 'id_tjl';
        $this->count_denda($id, $db, $db_where, $title_kode);
    }
    public function approve_inhouse_tjl(){
        $id = $_POST['id'];
        $db = 'tanda_jadi_lokasi_inhouse';
        $db_where = 'id_tjl';
        $this->approve($id, $db, $db_where);
    }
    public function reject_inhouse_tjl(){
        $id = $_POST['id'];
        $db = 'tanda_jadi_lokasi_inhouse';
        $db_where = 'id_tjl';
        $this->reject($id, $db, $db_where);
    }
    public function delete_inhouse_tjl(){
        $id = $_POST['id'];
        $db = 'tanda_jadi_lokasi_inhouse';
        $db_where = 'id_tjl';
        $this->delete($id, $db, $db_where);
    }

    

    //pembayarn inhouse uang muka
    public function confirm_inhouse_um($title_kode){
        $id = $_POST['id'];
        $db = 'uang_muka_inhouse';
        $db_where = 'id_um';
        $this->count_denda($id, $db, $db_where, $title_kode);
    }
    public function approve_inhouse_um(){
        $id = $_POST['id'];
        $db = 'uang_muka_inhouse';
        $db_where = 'id_um';
        $this->approve($id, $db, $db_where);
    }
    public function reject_inhouse_um(){
        $id = $_POST['id'];
        $db = 'uang_muka_inhouse';
        $db_where = 'id_um';
        $this->reject($id, $db, $db_where);
    }
    public function delete_inhouse_um(){
        $id = $_POST['id'];
        $db = 'uang_muka_inhouse';
        $db_where = 'id_um';
        $this->delete($id, $db, $db_where);
    }



    //pembayaran inhouse kelebihan tanah
    public function confirm_inhouse_kt($title_kode){
        $id = $_POST['id'];
        $db = 'kelebihan_tanah_inhouse';
        $db_where = 'id_kt';
        $this->count_denda($id, $db, $db_where, $title_kode);
    }
    public function approve_inhouse_kt(){
        $id = $_POST['id'];
        $db = 'kelebihan_tanah_inhouse';
        $db_where = 'id_kt';
        $this->approve($id, $db, $db_where);
    }
    public function reject_inhouse_kt(){
        $id = $_POST['id'];
        $db = 'kelebihan_tanah_inhouse';
        $db_where = 'id_kt';
        $this->reject($id, $db, $db_where);
    }
    public function delete_inhouse_kt(){
        $id = $_POST['id'];
        $db = 'kelebihan_tanah_inhouse';
        $db_where = 'id_kt';
        $this->delete($id, $db, $db_where);
    }





    public function fee_marketing(){
        $id_perum = $this->session->userdata('id_perumahan');

        $query_b = "SELECT * FROM tbl_marketing, tbl_transaksi_bank, tbl_kavling WHERE tbl_marketing.id_marketing = tbl_transaksi_bank.id_konsumen AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tbl_kavling.id_perum = $id_perum AND tbl_marketing.status != 0";

        $query_i = "SELECT * FROM tbl_marketing, tbl_transaksi_inhouse, tbl_kavling WHERE tbl_marketing.id_marketing = tbl_transaksi_inhouse.id_konsumen AND tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND tbl_kavling.id_perum = $id_perum AND tbl_marketing.status != 0";

       

        $data['konsumen_b'] = $this->db->query($query_b)->result();
        $data['konsumen_i'] = $this->db->query($query_i)->result();
        $data['kode'] = $this->db->order_by('kode','ASC')->get('kode')->result();
        $this->template->load('template', 'accounting/fee_marketing', $data);
    }


    public function get_fee_marketing(){
        $id = $_POST['id'];
        $data['konsumen'] = $this->db->get_where('tbl_marketing',['id_marketing' => $id])->row();
        // var_dump($data['konsumen']);die;
        $this->load->view('kpr/view_fee_marketing', $data);
    }

    public function confirm_fee_marketing($id){
        $data = [
            'title_kode' => $this->input->post('title_kode'),
            'status_fee_marketing' => 2,
            'tgl_fee_marketing' => date('Y-m-d')
        ];
        if($this->db->where('id_marketing', $id)->update('tbl_marketing', $data)){
            $this->session->set_flashdata('scs', 'Konfirmasi fee marketing berhasil');
            redirect('accounting/fee_marketing');
        } else {
            $this->session->set_flashdata('err', 'Konfirmasi fee marketing gagal');
            redirect('accounting/fee_marketing');
        }
    }

    public function repeat_fee_marketing($id){
        $data = [
            'title_kode' => $this->input->post('title_kode'),
            'status_fee_marketing' => 2,
            'tgl_fee_marketing' => date('Y-m-d')
        ];
        if($this->db->where('id_marketing', $id)->update('tbl_marketing', $data)){
            $this->session->set_flashdata('scs', 'Konfirmasi fee marketing berhasil');
            redirect('accounting/fee_marketing');
        } else {
            $this->session->set_flashdata('err', 'Konfirmasi fee marketing gagal');
            redirect('accounting/fee_marketing');
        }
    }

    public function pembangunan(){

        if(isset($_GET['filter'])){
            $data = $this->logistik->getUpahPekerja($_GET['filter'])->result();
        } else {
            $data = $this->logistik->getUpahPekerja(null)->result();
        }

        $data = [
            'pembangunan' => $data,
            'kode' => $this->db->order_by('kode','ASC')->get('kode')->result(),
            'filter' => $this->master->getFilterUpahKerja()->result()
        ];
        $this->template->load('template', 'accounting/pembangunan', $data);
    }

    public function detail_pembangunan(){
        $id = $_POST['id'];
        $q = "SELECT
            master_proyek.*,
            tbl_proyek_upah.*,
            progres_pembangunan.*, progres_pembangunan.status as status_pembangunan,
            tbl_kavling.*,
            tbl_tipe.*,
            tbl_cluster.* 
            FROM
            master_proyek,
            tbl_proyek_upah,
            progres_pembangunan,
            tbl_kavling,
            tbl_tipe,
            tbl_cluster
            WHERE
            master_proyek.id = tbl_proyek_upah.proyek_id AND
            tbl_proyek_upah.id = progres_pembangunan.upah_id AND
            progres_pembangunan.kavling_id = tbl_kavling.id_kavling AND
            tbl_kavling.id_tipe = tbl_tipe.id_tipe AND
            tbl_kavling.id_cluster = tbl_cluster.id_cluster AND
            progres_pembangunan.id_progres = $id 
        ";
        $data['detail'] = $this->db->query($q)->row();
        $this->load->view('accounting/detail_pembangunan', $data);
    }

    public function approve_pembangunan(){
        $id = $this->input->post('id');
        $id_upah = $this->input->post('id_up');

        $q = "SELECT SUM(total) as totalAll FROM progres_pembangunan WHERE upah_id = $id_upah AND status = 4";
        $jmlBayar = $this->db->query($q)->row()->totalAll;
        $thisApprove = $this->db->get_where('progres_pembangunan',['id_progres' => $id])->row();
        $hargaKontrak = $this->db->get_where('tbl_proyek_upah',['id' => $id_upah])->row()->harga_kontrak;
        $totAll = $jmlBayar + $thisApprove->total;

        $data_update = [
            'title_kode' => $this->input->post('title_kode'),
            'tgl_approve' => date('Y-m-d'),
            'status' => 3
        ];

        if($totAll > $hargaKontrak){
            $msg = [
                'success' => false,
                'msg' => 'Jumlah pengajuan melebihi harga kontrak'
            ];
        } else {
            if($this->db->where('id_progres', $id)->update('progres_pembangunan', $data_update)){
                $msg = [
                    'success' => true,
                    'msg' => 'Pembangunan berhasil di setujui'
                ];
            } else {
                $msg = [
                    'success' => false,
                    'msg' => 'Pembangunan gagal di setujui'
                ];
            } 
        }

        echo json_encode($msg);
    }

    public function tolak_pembangunan(){
        $id = $_POST['id'];
        if($this->db->set('status', 1)->where('id_progres', $id)->update('progres_pembangunan')){
            $msg = [
                'success' => true,
                'msg' => 'Pembangunan berhasil di tolak'
            ];
        } else {
            $msg = [
                'success' => false,
                'msg' => 'Pembangunan gagal di tolak'
            ];
        } 
        
        echo json_encode($msg);
    }

    public function approve_pembangunan_admin(){   
        $id = $_POST['id'];
        
        $pro = $this->master->get_confirm_pembangunan_admin($id)->row();


        // $pro = $this->proyek->getProgresIDforApprove($id);
        $title_kode = $pro->title_kode;
        $jml = $pro->jumlah;
        $id_perum = $pro->id_perum;

            if($this->db->set('status', 2)->where('id_cicil', $id)->update('cicil_progres')){

                $this->toHistoryApprove($title_kode, $jml, $id_perum);

                $params = ['msg' => 'Pembayaran Berhasil Di Terima'];
            } else {
                $params = ['msg' => 'Pembayaran Gagal Di Terima'];
            }
        
        
        echo json_encode($params);
    }

    public function reject_pembangunan_admin(){
        $id = $_POST['id'];
        if($this->db->set('status',0)->where('id_cicil', $id)->update('cicil_progres')){
            $params = ['msg' => 'Pembayaran Berhasil Di Tolak'];
        } else {
            $params = ['msg' => 'Pembayaran Gagal Di Tolak'];
        }
        echo json_encode($params);
    }





    //18/8/2022
    public function kode(){
        $data = [
            'kode' => $this->db->get('kode')->result()
        ];
        $this->template->load('template', 'accounting/kode', $data);
    }

    public function get_kode_id(){
        $kode = $this->db->get_where('kode',['id_kode' => $_POST['id']])->row();
        echo json_encode($kode);
    }

    private function validation_kode(){
        $this->form_validation->set_rules('kode','Kode','required|trim|is_unique[kode.kode]');
        $this->form_validation->set_rules('desc','Deskripsi Kode','required|trim');
        if($this->form_validation->run() == false){
            $params = [
                'type' => 'err_validation',
                'err_kode' => form_error('kode'),
                'err_desc' => form_error('desc')
            ];
            echo json_encode($params); 
            die;
        } else {
            return true;
        }
    }

    public function add_kode(){
        $this->validation_kode();
        $data = [
            'kode' => $this->input->post('kode'),
            'deskripsi_kode' => $this->input->post('desc')
        ];

        if($this->db->insert('kode', $data)){
            $params = [
                'type' => 'result',
                'success' => true,
                'msg' => 'Data berhasil di tambahkan'
            ];
        } else {
            $params = [
                'type' => 'result',
                'success' => false,
                'msg' => 'Data gagal di tambahkan'
            ];
        }
        echo json_encode($params);
    }

    public function edit_kode(){
        $this->validation_kode();
        $id = $this->input->post('id');
        $data = [
            'kode' => $this->input->post('kode'),
            'deskripsi_kode' => $this->input->post('desc')
        ];
        if($this->db->where('id_kode', $id)->update('kode',$data)){
            $params = [
                'type' => 'result',
                'success' => true,
                'msg' => 'Data berhasil di edit'
            ];
        } else {
            $params = [
                'type' => 'result',
                'success' => false,
                'msg' => 'Data gagal di edit'
            ];
        }
        echo json_encode($params);
    }

    public function del_kode(){
        $id = $_POST['id'];
        if($this->db->delete('kode',['id_kode' => $id])){
            $params = [
                'success' => true,
                'msg' => 'Kode berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Kode gagal di hapus'
            ];
        }
        echo json_encode($params);
    }


    public function sub_kode($id = null){
        $data = [
            'kode' => $this->db->get_where('kode',['id_kode' => $id])->row(),
            'sub_kode' => $this->db->get_where('sub_kode',['id_kode' => $id])->result()
        ];
        $this->template->load('template', 'accounting/sub_kode', $data);
    }

    public function get_sub_kode_id(){
        $sub = $this->db->get_where('sub_kode',['id_sub' => $_POST['id']])->row();
        echo json_encode($sub);
    }

    public function validation_sub_kode(){
        $id_kode = $this->input->post('id_kode');
        $sub_kode = $this->input->post('sub');
        $sub_reg = $this->db->get_where('sub_kode',['id_kode' => $id_kode, 'sub_kode' => $sub_kode])->row();
        $this->form_validation->set_rules('sub','Sub Kode','required|trim');
        $this->form_validation->set_rules('desc','Deskripsi','required|trim');
        if($this->form_validation->run() == false){
            $params = [
                'type' => 'err_validation',
                'err_sub' => form_error('sub'),
                'err_desc' => form_error('desc')
            ];
            echo json_encode($params);
            die;
        } else if($sub_reg) {

            $params = [
                'type' => 'err_validation',
                'err_sub' => 'Sub code already registered',
                'err_desc' => ''
            ];
            echo json_encode($params);
            die;
        
        } else  {
            return true;
        }
    }

    public function add_sub_kode(){
        $this->validation_sub_kode();
        $data = [
            'id_kode' => $this->input->post('id_kode'),
            'sub_kode' => $this->input->post('sub'),
            'deskripsi_sub_kode' => $this->input->post('desc')
        ];
        if($this->db->insert('sub_kode', $data)){
            $params = [
                'type' => 'result',
                'success' => true,
                'msg' => 'Sub kode berhasil di tambahkan'
            ];
        } else {
            $params = [
                'type' => 'result',
                'success' => false,
                'msg' => 'Sub kode gagal di tambahkan'
            ];
        }
        echo json_encode($params);
    }

    public function edit_sub_kode(){
        $id = $this->input->post('id_sub');
        $this->validation_sub_kode();
        $data = [
            'sub_kode' => $this->input->post('sub'),
            'deskripsi_sub_kode' => $this->input->post('desc')
        ];
        if($this->db->where('id_sub',$id)->update('sub_kode', $data)){
            $params = [
                'type' => 'result',
                'success' => true,
                'msg' => 'Sub kode berhasil di edit'
            ];
        } else {
            $params = [
                'type' => 'result',
                'success' => false,
                'msg' => 'Sub kode gagal di edit'
            ];
        }
        echo json_encode($params);
    }

    public function del_sub_kode(){
        $id = $_POST['id'];
        if($this->db->where('id_sub', $id)->delete('sub_kode')){
            $params = [
                'success' => true,
                'msg' => 'Sub kode berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => true,
                'msg' => 'Sub kode gagal di hapus'
            ];
        }
        echo json_encode($params);
    }



    //21-8-2022

    public function approve_fee_marketing(){
        $id = $_POST['id'];

        $userBank = $this->proyek->getUserBank($id);
        $userInhouse = $this->proyek->getUserInhouse($id);
        

        // $data = [
        //     'tgl_fee_marketing' => date('Y-m-d'),
        //     'status_fee_marketing' => 3
        // ];


        if($this->db->set('status',2)->where('id_cicil', $id)->update('cicil_fee_marketing')){

            if($userBank){
                $title_kode = $userBank->fee_kode;
                $jml = $userBank->jml_cicil;
                $id_perum = $userBank->id_perum;
                $this->toHistoryApprove($title_kode, $jml, $id_perum);
            } else if($userInhouse){
                $title_kode = $userInhouse->fee_kode;
                $jml = $userInhouse->jml_cicil;
                $id_perum = $userInhouse->id_perum;
                $this->toHistoryApprove($title_kode, $jml, $id_perum);
            }


            $msg = ['msg' => 'Berhasil di approve'];
        } else {
            $msg = ['msg' => 'Gagal di approve'];
        }
        echo json_encode($msg);
    }

    public function reject_fee_marketing(){
        $id = $_POST['id'];
        if($this->db->set('status', 0)->where('id_cicil', $id)->update('cicil_fee_marketing')){
            $msg = ['msg' => 'Berhasil di reject'];
        } else {
            $msg = ['msg' => 'Gagal di reject'];
        }
        echo json_encode($msg);
    }


    


    //23-8-2022

    public function laporan(){
        $this->template->load('template', 'accounting/laporan_bulanan');
    }


    public function getDataByFilterDate(){
        $perum = $this->session->userdata('id_perumahan');
        $date_A = $this->input->post('date_A');
        $date_B = $this->input->post('date_B');


        


        $data = [
            'kode' => $this->db->order_by('kode','ASC')->get('kode')->result(),
            'date_A' => $date_A,
            'date_B' => $date_B,
            'perum' => $perum
        ];

        $this->load->view('accounting/laporan_bulanan_view',$data);
    }





    //31-8-2022
    public function validation_title(){
        $id_sub = $this->input->post('sub_kode');
        $kode_title = $this->input->post('title');
        $reg_title = $this->db->get_where('title_kode',['id_sub' => $id_sub, 'kode_title' => $kode_title])->result();

        $this->form_validation->set_rules('title','Title','required|trim');
        $this->form_validation->set_rules('desc','Deskripsi','required|trim');
        if($this->form_validation->run() == false){
            $params = [
                'type' => 'validation',
                'err_title' => form_error('title'),
                'err_desc' => form_error('desc')
            ];
            echo json_encode($params); die;
        } else if($reg_title) {
            $params = [
                'type' => 'validation',
                'err_title' => 'Kode title has registered',
                'err_desc' => ''
            ];
            echo json_encode($params); die;
        } else {
            return true;
        }
    }

    public function add_title(){
        $this->validation_title();
        $data = [
            'id_sub' => $this->input->post('sub_kode'),
            'kode_title' => $this->input->post('title'),
            'deskripsi' => $this->input->post('desc')
        ];

        if($this->db->insert('title_kode', $data)){
            $params = [
                'type' => 'result',
                'success' => true,
                'msg' => 'Title kode berhasil di tambahkan'
            ];
        } else {
            $params = [
                'type' => 'result',
                'success' => false,
                'msg' => 'Title kode gagal di tambahkan'
            ];
        }

        echo json_encode($params);

    }

    public function get_ajax_title(){
        $id = $_POST['id'];
        $title = $this->db->get_where('title_kode',['id_title' => $id])->row();
        echo json_encode($title);
    }

    public function edit_title(){
        $this->validation_title();
        $id = $this->input->post('id_title');

        $data = [
            'id_sub' => $this->input->post('sub_kode'),
            'kode_title' => $this->input->post('title'),
            'deskripsi' => $this->input->post('desc')
        ];

        if($this->db->where('id_title', $id)->update('title_kode', $data)){
            $params = [
                'type' => 'result',
                'success' => true,
                'msg' => 'Title kode berhasil di edit'
            ];
        } else {
            $params = [
                'type' => 'result',
                'success' => true,
                'msg' => 'Title kode gagal di edit'
            ];
        }

        echo json_encode($params);
    }

    public function del_title_kode(){
        $id = $_POST['id'];
        if($this->db->delete('title_kode',['id_title' => $id])){
            $params = [
                'success' => true,
                'msg' => 'Title kode berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => true,
                'msg' => 'Title kode gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function getBuktiPembayaranKonsumen(){
        $id = $_POST['id'];
        $db = $_POST['db'];
        $where = $_POST['where'];

        $data = $this->db->get_where('bukti_pembayaran',['id_pembayaran' => $id, 'db' => $db])->row();
        echo json_encode($data);
    }

    
    public function repeat_bukti_pembayaran(){
        $img = $_FILES['bukti'];
        $title_kode = $this->input->post('title_kode');
        $id_bukti = $this->input->post('id_bukti');
        $bukti_pemb = $this->db->get_where('bukti_pembayaran',['id_bukti' => $id_bukti])->row();


        if($img){
            $config['upload_path']          = './assets/bukti_pembayaran/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);

            if($this->upload->do_upload('bukti')){
                $bukti = $this->upload->data('file_name');
            } else {
                $bukti = $bukti_pemb->bukti_pembayaran;
            }
        }

        $data = [
            'bukti_pembayaran' => $bukti
        ];

        if($this->db->where('id_bukti', $id_bukti)->update('bukti_pembayaran', $data)){

            $type = $this->input->post('type');
            $db = $this->input->post('db');
            $id = $this->input->post('id');

            if($type == 'b_tjl'){
                $where = 'id_tjl';
                $tgl = 'tgl_pembayaran';
                $status = 2;
            } 
            else if($type == 'b_um'){
                $where = 'id_um';
                $tgl = 'tgl_pembayaran';
                $status = 2;
            }
            else if($type == 'b_kt'){
                $where = 'id_kt';
                $tgl = 'tgl_pembayaran';
                $status = 2;
            }
            else if($type == 'b_pak'){
                $where = 'id_pak';
                $tgl = 'tgl_pembayaran';
                $status = 2;
            }
            else if($type == 'b_lain'){
                $where = 'id_lain';
                $tgl = 'tgl_pembayaran';
                $status = 2;
            }
            else if($type == 'b_angsur'){
                $where = 'id_angsur';
                $tgl = 'tgl_pembayaran';
                $status = 2;
            }
            else if($type == 'b_piutang'){
                $where = 'id_piutang';
                $tgl = 'tgl_pembayaran';
                $status = 2;
            }
            else if($type == 'i_hk'){
                $where = 'id_kesepakatan';
                $tgl = 'tgl_pembayaran';
                $status = 2;
            }
            else if($type == 'i_tjl'){
                $where = 'id_tjl';
                $tgl = 'tgl_pembayaran';
                $status = 2;
            }
            else if($type == 'i_um'){
                $where = 'id_um';
                $tgl = 'tgl_pembayaran';
                $status = 2;
            }
            else if($type == 'i_kt'){
                $where = 'id_kt';
                $tgl = 'tgl_pembayaran';
                $status = 2;
            }
            else if($type == 'b_tj'){
                $where = 'id_transaksi_bank';
                $tgl = 'tgl_tanda_jadi';
                $status = 1;
            }
            else if($type == 'i_tj'){
                $where = 'id_inhouse';
                $tgl = 'tgl_tanda_jadi';
                $status = 1;
            }

            $params = [
                'status' => $status,
                $tgl => date('Y-m-d'),
                'title_kode' => $title_kode
            ];

            if($this->db->where($where, $id)->update($db, $params)){
                $msg = 'Pembayaran Berhasil';
            } else {
                $msg = 'Pembayaran Gagal';
            }

            echo json_encode($msg);
            die;

        } else {
            $msg = 'Bukti pembayaran gagal di upload';
            echo json_encode($msg);
        }

    }




    //3-9-2022

    public function pembebasan_lahan(){
        $id_perum = $this->session->userdata('id_perumahan');
        $data = [
            'list_data' => $this->master->getPembebasanLahan()->result(),
            'kode' => $this->db->order_by('kode','ASC')->get('kode')->result()
        ];
        $this->template->load('template', 'accounting/pembebasan_lahan', $data);
    }

    public function check_pembebasan_lahan(){
        $id = $this->input->post('id_cicil');
        $data = [
            'status' => 2,
            'title_kode' => $this->input->post('title_kode')
        ];

        if($this->db->where('id_pembebasan', $id)->update('pembebasan_lahan', $data)){
            $params = [
                'success' => true,
                'msg' => 'Pembayaran berhasil'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Pembayaran gagal'
            ];
        }

        echo json_encode($params);

    }

    public function get_detail_pembebasan_lahan(){
        $id = $_POST['id'];

        $q = "SELECT * FROM pembebasan_lahan JOIN tbl_perumahan ON pembebasan_lahan.id_perumahan = tbl_perumahan.id_perumahan WHERE pembebasan_lahan.id_pembebasan = $id";

        $data = [
            'data' => $this->db->query($q)->row()
        ];
        $this->load->view('accounting/detail_pembebasan_lahan', $data);

    }

    public function ApprovePembebasanLahan(){
        $id = $_POST['id'];

        $pemb = $this->master->get_pembebasan_lahan($id)->row();
        $title_kode = $pemb->title_kode;
        $jml = $pemb->jumlah;
        $id_perum = $pemb->id_perumahan;

        if($this->db->set('status', 2)->where('id_cicil', $id)->update('cicil_pembebasan_lahan')){

            $this->toHistoryApprove($title_kode, $jml, $id_perum);

            $params = ['msg' => 'Berhasil di Approve'];
        } else {
            $params = ['msg' => 'Gagal di Approve'];
        }

        echo json_encode($params);

    }

    public function RejectPembebasanLahan(){
        $id = $_POST['id'];

        if($this->db->set('status', 0)->where('id_cicil', $id)->update('cicil_pembebasan_lahan')){
            $params = ['msg' => 'Berhasil di Tolak'];
        } else {
            $params = ['msg' => 'Gagal di Tolak'];
        }

        echo json_encode($params);
    }



    //4-9-2022

    public function pengeluaran_lain(){
        $id_perum = $this->session->userdata('id_perumahan');
        
        $data = [
            'list' => $this->db->get_where('pengeluaran_lain',['id_perumahan' => $id_perum])->result(),
            'kode' => $this->db->order_by('kode','ASC')->get('kode')->result()
        ];
        $this->template->load('template', 'accounting/pengeluaran_lain', $data);
    }

    public function add_kode_pengeluaran_lain(){
        $id = $this->input->post('id_pengeluaran');

        $data = [
            'status' => 2,
            'title_kode' => $this->input->post('title_kode'),
            'tgl_approve' => date('Y-m-d')
        ];

        if($this->db->where('id_pengeluaran', $id)->update('pengeluaran_lain', $data)){
            $params = [
                'success' => true,
                'msg' => 'Pembayaran berhasil'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Pembayaran gagal'
            ];
        }

        echo json_encode($params);

    }

    public function approvePengeluaranLain(){
        $id = $_POST['id'];

        $lain = $this->master->get_confirm_pengeluaran_lain($id)->row();
        $title_kode = $lain->title_kode;
        $jml = $lain->jumlah;
        $id_perum = $lain->id_perumahan;

        if($this->db->set('status', 2)->where('id_cicil', $id)->update('cicil_pengeluaran_lain')){
            $this->toHistoryApprove($title_kode, $jml, $id_perum);
            $params = ['msg' => 'Berhasil di Approve'];
        } else {
            $params = ['msg' => 'Gagal di Approve'];
        }

        echo json_encode($params);

    }

    public function rejectPengeluaranLain(){
        $id = $_POST['id'];

        if($this->db->set('status', 0)->where('id_cicil', $id)->update('cicil_pengeluaran_lain')){
            $params = ['msg' => 'Berhasil di Reject'];
        } else {
            $params = ['msg' => 'Gagal di Reject'];
        }

        echo json_encode($params);

    }




    //5-9-2022

    public function rab(){
        $id_perum = $this->session->userdata('id_perumahan');
        $data = [
            'kode' => $this->db->order_by('kode','ASC')->get('kode')->result(),
            'material' => $this->proyek->getRABMaterialByPerum($id_perum),
            'upah' => $this->proyek->getRABUpahByPerum($id_perum),
            'lain' => $this->proyek->getRABLainByPerum($id_perum)
        ];
        $this->template->load('template', 'accounting/rab', $data);
    }

    public function detail_rab(){
        $id = $_POST['id'];
        $type = $_POST['type'];

        $data = [
            'type' => $type,
            'material' => $this->proyek->detailRABMaterialID($id),
            'upah' => $this->proyek->detailRABUpahID($id),
            'lain' => $this->proyek->detailRABLain($id)
        ];

        $this->load->view('accounting/detailRab', $data);
    }

    public function check_kode_RAB(){
        $id = $this->input->post('id');
        $type = $this->input->post('type');

        if($type == 'material'){
            $data = [
                'status' => 2,
                'title_kode' => $this->input->post('title_kode'),
                'tgl_approve' => date('Y-m-d')
            ];
            $this->db->where('id', $id)->update('tbl_proyek_material', $data);
        } else if($type == 'upah'){
            $data1 = [
                'status' => 2,
                'title_kode' => $this->input->post('title_kode'),
                'tgl_approve' => date('Y-m-d')
            ];
            $this->db->where('id', $id)->update('tbl_proyek_upah', $data1);
        } else if($type == 'lain'){
            $data2 = [
                'status' => 2,
                'title_kode' => $this->input->post('title_kode'),
                'tgl_approve' => date('Y-m-d')
            ];
            $this->db->where('id', $id)->update('tbl_proyek_lainnya', $data2);
        }



        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'msg' => 'Berhasil di approve'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Gagal di approve'
            ];
        }

        echo json_encode($params);
    }



    //6-9-2022
    public function approveRABMaterial(){
        $id = $_POST['id'];
        $data = [
            'status' => 3,
            'tgl_approve' => date('Y-m-d')
        ];

        $material = $this->proyek->detailRABMaterialID($id);
        $title_kode = $material->title_kode;
        $jml = $material->total;
        $id_perum = $material->id_perumahan;


        if($this->db->where('id', $id)->update('tbl_proyek_material', $data)){
            $this->toHistoryApprove($title_kode, $jml, $id_perum);
            $params = ['msg' => 'Approve berhasil'];
        } else {
            $params = ['msg' => 'Approve gagal'];
        }
        
        echo json_encode($params);
    }

    public function rejectRABMaterial(){
        $id = $_POST['id'];
        $data = [
            'status' => 0,
            'tgl_approve' => date('Y-m-d')
        ];

        if($this->db->where('id', $id)->update('tbl_proyek_material', $data)){
            $params = ['msg' => 'Reject berhasil'];
        } else {
            $params = ['msg' => 'Reject gagal'];
        }
        
        echo json_encode($params);
    }

    public function approveRABUpah(){
        $id = $_POST['id'];
        $data = [
            'status' => 3,
            'tgl_approve' => date('Y-m-d')
        ];

        $upah = $this->proyek->detailRABUpahID($id);
        $jml_kav = $this->proyek->countJmlKavProyek($upah->proyek_id, $upah->tipe_id);
        $title_kode = $upah->title_kode;
        $jml = $upah->harga_kontrak * $jml_kav;
        $id_perum = $upah->id_perum;

        if($this->db->where('id', $id)->update('tbl_proyek_upah', $data)){
            $this->toHistoryApprove($title_kode, $jml, $id_perum);
            $params = ['msg' => 'Approve berhasil'];
        } else {
            $params = ['msg' => 'Approve gagal'];
        }

        echo json_encode($params);
    }

    public function rejectRABUpah(){
        $id = $_POST['id'];
        $data = [
            'status' => 0,
            'tgl_approve' => date('Y-m-d')
        ];

        if($this->db->where('id', $id)->update('tbl_proyek_upah', $data)){
            $params = ['msg' => 'Reject berhasil'];
        } else {
            $params = ['msg' => 'Reject gagal'];
        }

        echo json_encode($params);
    }

    public function approveRABLain(){
        $id = $_POST['id'];
        $data = [
            'status' => 3,
            'tgl_approve' => date('Y-m-d')
        ];

        $lain = $this->proyek->detailRABLain($id);
        $jml_kav = $this->proyek->countJmlKavProyek($lain->proyek_id, $lain->tipe_id);
        $title_kode = $lain->title_kode;
        $jml = $lain->harga_lainnya * $jml_kav;
        $id_perum = $lain->id_perumahan;

        if($this->db->where('id', $id)->update('tbl_proyek_lainnya', $data)){
            $this->toHistoryApprove($title_kode, $jml, $id_perum);
            $params = ['msg' => 'Approve berhasil'];
        } else {
            $params = ['msg' => 'Approve gagal'];
        }

        echo json_encode($params);
    }

    public function rejectRABLain(){
        $id = $_POST['id'];
        $data = [
            'status' => 0,
            'tgl_approve' => date('Y-m-d')
        ];

        if($this->db->where('id', $id)->update('tbl_proyek_lainnya', $data)){
            $params = ['msg' => 'Reject berhasil'];
        } else {
            $params = ['msg' => 'Reject gagal'];
        }

        echo json_encode($params);
    }

    public function insidentil(){
        $data = [
            'insidentil' => $this->proyek->Insidentil()->result(),
            'kode' => $this->db->order_by('kode','ASC')->get('kode')->result()
        ];
        $this->template->load('template', 'accounting/insidentil', $data);
    }

    public function kodeInsidentil(){
        $id = $this->input->post('id');
        $data = [
            'status' => 3,
            'title_kode' => $this->input->post('title_kode'),
            'tgl_approve' => date('Y-m-d')
        ];

        if($this->db->where('id', $id)->update('tbl_proyek_insidentil', $data)){
            $params = [
                'success' => true,
                'msg' => 'Berhasil di Approve'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Gagal di Approve'
            ];
        }

        echo json_encode($params);

    }

    public function approveInsidentil(){
        $id = $_POST['id'];
        $data_cicil = $this->db->get_where('cicil_insidentil',['id_cicil' => $id])->row();
        $data_insidentil = $this->db->get_where('tbl_proyek_insidentil',['id' => $data_cicil->id_insidentil])->row();

        $title_kode = $data_insidentil->title_kode;
        $jml = $data_cicil->jml_pengajuan;
        $id_perum = $data_insidentil->id_perumahan;

        $this->db->set('status', 2)->where('id_cicil', $id)->update('cicil_insidentil');
        if($this->db->affected_rows() > 0){
            $this->toHistoryApprove($title_kode, $jml, $id_perum);
            $params = ['msg' => 'Approve berhasil'];
        } else {
            $params = ['msg' => 'Approve gagal'];
        }

        echo json_encode($params);
    }

    public function rejectInsidentil(){
        $id = $_POST['id'];
        $data = [
            'status' => 0,
        ];
        if($this->db->where('id_cicil', $id)->update('cicil_insidentil', $data)){
            $params = ['msg' => 'Reject berhasil'];
        } else {
            $params = ['msg' => 'Reject gagal'];
        }
        echo json_encode($params);
    }

    //7-9-2022
    public function pengajuan_material(){
        $id_perum = $this->session->userdata('id_perumahan');

        if(isset($_GET['filter'])){
            $data = $this->logistik->getDataPengajuanMaterial($_GET['filter'])->result();
        } else {
            $data = $this->logistik->getDataPengajuanMaterial(null)->result();
        }

        $data = [
            'list' => $this->proyek->getPengajuanMaterial($id_perum),
            'kode' => $this->db->order_by('kode','ASC')->get('kode')->result(),
            'data' => $data,
            'filter' => $this->master->getFilterPengajuanMaterial()->result()
        ];
        $this->template->load('template', 'accounting/pengajuan_material', $data);
    }

    public function getDetailPengajuanMaterial(){
        $id = $_POST['id'];
        $data = [
            'list' => $this->logistik->getDataPengajuanMaterialDetail($id)->result(),
            'nota' => $this->db->get_where('nota_material',['id_pengajuan' => $id])->result()   
        ];
        $this->load->view('accounting/detail_pengajuan_material', $data);
    }

    public function toKodePengajuanMaterial(){
        $id = $this->input->post('id');
                $data = [
                    'status_pengajuan' => 4,
                    'title_kode' => $this->input->post('title_kode'),
                ];
        
                if($this->db->where('id_pengajuan', $id)->update('pengajuan_material', $data)){
                    $params = [
                        'success' => true,
                        'msg' => 'Berhasil Approve'
                    ];
                } else {
                    $params = [
                        'success' => false,
                        'msg' => 'Gagal Approve'
                    ];
                }
                echo json_encode($params);
        
    }

    public function approveMaterial(){
        $id = $_POST['id'];

        $this->db->select('cicil_material.jml_pengajuan, pengajuan_material.title_kode, pengajuan_material.id_perumahan')->from('cicil_material')->join('pengajuan_material', 'cicil_material.id_pengajuan = pengajuan_material.id_pengajuan')->where('id_cicil', $id);
        $data = $this->db->get()->row();

        $title_kode = $data->title_kode;
        $jml = $data->jml_pengajuan;
        $id_perum = $data->id_perumahan;


        $this->db->set('status', 2)->where('id_cicil', $id)->update('cicil_material');
        if($this->db->affected_rows() > 0){
            $this->toHistoryApprove($title_kode, $jml, $id_perum);
            $params = ['msg' => 'Approve berhasil'];
        } else {
            $params = ['msg' => 'Approve Gagal'];
        }

        echo json_encode($params);
    }

    public function rejectMaterial(){
        $id = $_POST['id'];
        $data = [
            'status' => 0,
        ];

        if($this->db->where('id_cicil', $id)->update('cicil_material', $data)){
            $params = ['msg' => 'Reject berhasil'];
        } else {
            $params = ['msg' => 'Reject Gagal'];
        }

        echo json_encode($params);
    }



    //8-9-2022

    private function toHistoryApprove($title_kode, $jml, $id_perum){
        $data = [
            'id_perumahan' => $id_perum,
            'id_title_kode' => $title_kode,
            'jumlah' => $jml,
            'tanggal' => date('Y-m-d')
        ];
        $this->db->insert('approved_history', $data);
    }



    //9-9-2022
    public function printLaporanBulanan(){
        $perum = $_GET['perum'];
        $date_A = $_GET['date_A'];
        $date_B = $_GET['date_B'];

        $data = [
            'perum' => $perum,
            'date_A' => $date_A,
            'date_B' => $date_B,
            'kode' => $this->db->order_by('kode','ASC')->get('kode')->result(),
            'perumahan' => $this->db->get_where('tbl_perumahan',['id_perumahan' => $perum])->row(),
            'user' => $this->db->get_where('db_user',['id' => $this->session->userdata('user_id')])->row()
        ];

        $html = $this->load->view('accounting/print_Laporan_Bulanan', $data, true);

        $this->toPrintLaporan($html);

    }


    public function laporan_kas(){
        $this->template->load('template', 'accounting/laporan_kas');
    }

    public function showLaporanKas(){
        $date_A = $this->input->post('date_A');
        $date_B = $this->input->post('date_B');
        $id_perum = $this->session->userdata('id_perumahan');

        $q = "SELECT
            approved_history.*,
            title_kode.kode_title,
            title_kode.deskripsi,
            sub_kode.sub_kode,
            sub_kode.deskripsi_sub_kode,
            kode.kode,
            kode.deskripsi_kode

            FROM
            approved_history,
            title_kode,
            sub_kode,
            kode

            WHERE
            approved_history.id_perumahan = $id_perum AND
            approved_history.id_title_kode = title_kode.id_title AND
            title_kode.id_sub = sub_kode.id_sub AND
            sub_kode.id_kode = kode.id_kode AND
            approved_history.tanggal BETWEEN '".$date_A."' AND '".$date_B."'
            ORDER BY approved_history.tanggal ASC
        ";

        $list = $this->db->query($q)->result();

        $data = [
            'date_A' => $date_A,
            'date_B' => $date_B,
            'list' => $list,
            'id_perum' => $id_perum
        ];

        $this->load->view('accounting/show_laporan_kas', $data);

    }

    public function printArusKas(){
        $date_A = $_GET['date_A'];
        $date_B = $_GET['date_B'];
        $id_perum = $this->session->userdata('id_perumahan');
    
        $q = "SELECT
        approved_history.*,
        title_kode.kode_title,
        title_kode.deskripsi,
        sub_kode.sub_kode,
        sub_kode.deskripsi_sub_kode,
        kode.kode,
        kode.deskripsi_kode

        FROM
        approved_history,
        title_kode,
        sub_kode,
        kode

        WHERE
        approved_history.id_perumahan = $id_perum AND
        approved_history.id_title_kode = title_kode.id_title AND
        title_kode.id_sub = sub_kode.id_sub AND
        sub_kode.id_kode = kode.id_kode AND
        approved_history.tanggal BETWEEN '".$date_A."' AND '".$date_B."'
        ORDER BY approved_history.tanggal ASC
    ";


        $list = $this->db->query($q)->result();

        $data = [
            'perumahan' => $this->db->get_where('tbl_perumahan',['id_perumahan' => $id_perum])->row(),
            'date_A' => $date_A,
            'date_B' => $date_B,
            'list' => $list,
            'user' => $this->db->get_where('db_user',['id' => $this->session->userdata('user_id')])->row()
        ];

       $html = $this->load->view('accounting/printArusKas', $data ,true);

       require FCPATH . 'assets/mpdf/vendor/autoload.php';
       $pdf = new \Mpdf\Mpdf();
       $pdf->WriteHTML($html);
       $pdf->Output();

    }

    public function toPrintLaporan($html){
        require FCPATH . 'assets/mpdf/vendor/autoload.php';
        $pdf = new \Mpdf\Mpdf();
        $pdf->WriteHTML($html);
        $pdf->Output();
    }




    //21-9-2022

    public function get_angsuran(){
        $id = $_POST['id'];
        $data['data'] = $this->db->get_where('angsuran_bank',['id_konsumen' => $id])->result();
        $this->load->view('accounting/bank_angsuran', $data);
    }

    public function get_piutang(){
        $id = $_POST['id'];
        $data['data'] = $this->db->get_where('piutang_bank',['id_konsumen' => $id])->result();
        $this->load->view('accounting/bank_piutang', $data);
    }


    //20-10-2022
    public function pembatalan_transaksi(){
        $id_perum = $this->session->userdata('id_perumahan');
        // var_dump($id_perum); die;
        $b = "SELECT 
            tbl_marketing.*,
            tbl_marketing.status as status_konsumen,
            pembatalan_transaksi.*,
            tbl_transaksi_bank.id_transaksi_bank,
            tbl_kavling.id_perum

            FROM 
            tbl_marketing,
            pembatalan_transaksi,
            tbl_transaksi_bank,
            tbl_kavling

            WHERE
            tbl_marketing.status = 0 AND
            tbl_marketing.id_marketing = pembatalan_transaksi.id_user AND
            pembatalan_transaksi.id_user = tbl_transaksi_bank.id_konsumen AND
            tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND
            tbl_kavling.id_perum = $id_perum
        ";

        $i = "SELECT 
            tbl_marketing.*,
            tbl_marketing.status as status_konsumen,
            pembatalan_transaksi.*,
            tbl_transaksi_inhouse.id_inhouse,
            tbl_kavling.id_perum

            FROM 
            tbl_marketing,
            pembatalan_transaksi,
            tbl_transaksi_inhouse,
            tbl_kavling

            WHERE
            tbl_marketing.status = 0 AND
            tbl_marketing.id_marketing = pembatalan_transaksi.id_user AND
            pembatalan_transaksi.id_user = tbl_transaksi_inhouse.id_konsumen AND
            tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND
            tbl_kavling.id_perum = $id_perum
        ";

        $data = [
            'bank' => $this->db->query($b)->result(),
            'inhouse' => $this->db->query($i)->result(),
            'kode' => $this->db->order_by('kode','ASC')->get('kode')->result()
        ];
        $this->template->load('template', 'accounting/pembatalan_transaksi', $data);
    }

    public function toCodePembatalan(){
        $id = $this->input->post('id');
        $data = [
            'status' => 2,
            'title_kode' => $this->input->post('title_kode')
        ];
        if($this->db->where('id_pembatalan', $id)->update('pembatalan_transaksi', $data)){
            $params = [
                'success' => true,
                'msg' => 'Berhasil Approve'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Gagal Approve'
            ];
        }
        echo json_encode($params);
    }

    public function tolak_pembatalan(){
        $id = $_POST['id'];
        if($this->db->set('status', 2)->where('id_pembatalan', $id)->update('pembatalan_transaksi')){
            $params = [
                'success' => true,
                'msg' => 'Berhasil Reject'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Gagal Reject'
            ];
        }
        echo json_encode($params);
    }



    public function rejectBatal(){
        $id = $_POST['id'];
        if($this->db->set('status', 0)->where('id_cicil', $id)->update('cicil_pembatalan')){
            $params = ['msg' => 'Reject berhasil'];
        } else {
            $params = ['msg' => 'Reject gagal'];
        }

        echo json_encode($params);
    }

    public function approveBatal(){
        $id = $_POST['id'];
        $b = "SELECT
            pembatalan_transaksi.title_kode,
            pembatalan_transaksi.total_pengembalian,
            tbl_transaksi_bank.id_transaksi_bank,
            tbl_kavling.id_perum,
            cicil_pembatalan.*,
            cicil_pembatalan.jumlah as jml_cicil
            FROM
            pembatalan_transaksi,
            tbl_transaksi_bank,
            tbl_kavling,
            cicil_pembatalan
            
            WHERE
            pembatalan_transaksi.id_pembatalan = cicil_pembatalan.id_pembatalan AND
            pembatalan_transaksi.id_user = tbl_transaksi_bank.id_konsumen AND
            tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND
            cicil_pembatalan.id_cicil = $id
        ";

        $i = "SELECT
        pembatalan_transaksi.title_kode,
        pembatalan_transaksi.total_pengembalian,
        tbl_transaksi_inhouse.id_inhouse,
        tbl_kavling.id_perum,
        cicil_pembatalan.*,
        cicil_pembatalan.jumlah as jml_cicil

        FROM
        pembatalan_transaksi,
        tbl_transaksi_inhouse,
        tbl_kavling,
        cicil_pembatalan

        WHERE
        pembatalan_transaksi.id_pembatalan = cicil_pembatalan.id_pembatalan AND
        pembatalan_transaksi.id_user = tbl_transaksi_inhouse.id_konsumen AND
        tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND
        cicil_pembatalan.id_cicil = $id
        ";

        $bank = $this->db->query($b)->row();
        $inhouse = $this->db->query($i)->row();
        if($this->db->set('status', 2)->where('id_cicil', $id)->update('cicil_pembatalan')){
            if($bank){
                $title_kode = $bank->title_kode;
                $jml = $bank->jml_cicil;
                $id_perum = $bank->id_perum;
            } else if($inhouse){
                $title_kode = $inhouse->title_kode;
                $jml = $inhouse->jml_cicil;
                $id_perum = $inhouse->id_perum;
            }
            $this->toHistoryApprove($title_kode, $jml, $id_perum);
            $params = ['msg' => 'Approve Berhasil'];
        } else {
            $params = ['msg' => 'Approve Gagal'];
        }
        echo json_encode($params);
    }



    public function get_tj(){
        $id = $_POST['id'];
        $data['data'] = $this->db->get_where('tbl_transaksi_bank',['id_konsumen' => $id])->row();
        $this->load->view('accounting/bank_tj', $data);
    }

    public function confirm_tj_bank($title_kode){
        $id = $_POST['id'];
        if($this->db->set('status', 1)->set('tgl_tanda_jadi', date('Y-m-d'))->set('title_kode', $title_kode)->where('id_transaksi_bank', $id)->update('tbl_transaksi_bank')){
            $params = "Approve berhasil";
        } else {
            $params = "Approve gagal";
        }
        echo json_encode($params);
    }

    public function gen_b_tj($id){
        $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling, bank_cicil_tj WHERE tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tbl_transaksi_bank.id_transaksi_bank = bank_cicil_tj.id_pembayaran AND bank_cicil_tj.id_cicil = $id";
        // $data['tjl'] = $this->db->query($q)->row();
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Tanda Jadi';
        // $this->load->view('accounting/bank_gen_um', $data);
        $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        return $this->print_kwitansi($html);
    }

    public function get_tj_inhouse(){
        $id = $_POST['id'];
        $data['data'] = $this->db->get_where('tbl_transaksi_inhouse',['id_konsumen' => $id])->row();
        $this->load->view('accounting/inhouse_tj', $data);
    }

    public function confirm_tj_inhouse($title_kode){
        $id = $_POST['id'];
        $data = [
            'status' => 1,
            'tgl_tanda_jadi' => date('Y-m-d'),
            'title_kode' => $title_kode
        ];
        if($this->db->where('id_inhouse', $id)->update('tbl_transaksi_inhouse', $data)){
            $params = "Approve berhasil";
        } else {
            $params = "Approve gagal";
        }
        echo json_encode($params);
    }

    public function gen_i_tj($id){
        $q = "SELECT * FROM tbl_transaksi_inhouse, tbl_marketing, tbl_kavling, inhouse_cicil_tj WHERE tbl_transaksi_inhouse.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND tbl_transaksi_inhouse.id_inhouse = inhouse_cicil_tj.id_pembayaran AND inhouse_cicil_tj.id_cicil = $id";
        // $data['tjl'] = $this->db->query($q)->row();
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Tanda Jadi';
        // $this->load->view('accounting/bank_gen_um', $data);
        $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        return $this->print_kwitansi($html);
    }

    public function rejectBankTJ(){
        $id = $_POST['id'];
        if($this->db->set('status', 3)->where('id_transaksi_bank', $id)->update('tbl_transaksi_bank')){
            $params = ['msg' => 'Reject berhasil'];
        } else {
            $params = ['msg' => 'Reject gagal'];
        }
        echo json_encode($params);
    }

    public function approveBankTj(){
        $id = $_POST['id'];
        $q = "SELECT * FROM tbl_transaksi_bank JOIN tbl_kavling ON tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling WHERE tbl_transaksi_bank.id_transaksi_bank = $id";
        $tj = $this->db->query($q)->row();

        if($this->db->set('status', 2)->where('id_transaksi_bank', $id)->update('tbl_transaksi_bank')){
            $title_kode = $tj->title_kode;
            $jml = $tj->tanda_jadi;
            $id_perum = $tj->id_perum;
            $this->toHistoryApprove($title_kode, $jml, $id_perum);
            $params = ['msg' => 'Approve berhasil'];
        } else {
            $params = ['msg' => 'Approve gagal'];
        }
        echo json_encode($params);
    }

    public function rejectInhouseTJ(){
        $id = $_POST['id'];
        if($this->db->set('status', 3)->where('id_inhouse', $id)->update('tbl_transaksi_inhouse')){
            $params = ['msg' => 'Reject berhasil'];
        } else {
            $params = ['msg' => 'Reject gagal'];
        }
        echo json_encode($params);
    }

    public function approveInhouseTj(){
        $id = $_POST['id'];
        $q = "SELECT * FROM tbl_transaksi_inhouse JOIN tbl_kavling ON tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling WHERE tbl_transaksi_inhouse.id_inhouse = $id";
        $tj = $this->db->query($q)->row();

        if($this->db->set('status', 2)->where('id_inhouse', $id)->update('tbl_transaksi_inhouse')){
            $title_kode = $tj->title_kode;
            $jml = $tj->tanda_jadi;
            $id_perum = $tj->id_perum;
            $this->toHistoryApprove($title_kode, $jml, $id_perum);
            $params = ['msg' => 'Approve berhasil'];
        } else {
            $params = ['msg' => 'Approve gagal'];
        }
        echo json_encode($params);
    }

    public function addMCM(){
        $jml = $_POST['jml_pengajuan'];
        $jml_max = $_POST['jml_max'];
        if($jml > $jml_max){
            $params = [
                'success' => false,
                'msg' => 'Jumlah melebihi maksimal'
            ];
            echo json_encode($params);
            die;
        }

                $id_logistik = $this->input->post('id_logistik');
                $data = [
                    'id_pengajuan' => $id_logistik,
                    'tgl_pengajuan' => $this->input->post('tgl'),
                    'jml_pengajuan' => $this->input->post('jml_pengajuan'),
                    'bukti_pembayaran' => '',
                    'status' => 1
                ];
                if($this->db->insert('cicil_material', $data)){
                    $params = [
                        'success' => true,
                        'msg' => 'Pembayaran berhasil di tambahkan'
                    ];
                } else {
                    $params = [
                        'success' => false,
                        'msg' => 'Pembayaran gagal di tambahkan'
                    ];
                }
                echo json_encode($params);
        
    }

    public function showSupp(){
        $id = $_POST['id'];
        $total_material = $this->logistik->getDataPengajuanMaterialDetail($id)->result();
        $total_real = 0;
        foreach($total_material as $t){
            $harga_real = $this->db->get_where('master_logistik_detail',['logistik_id' => $t->id_logistik])->row();
            $total_real += $t->jml_pengajuan * $harga_real->harga_real;
        }

        $data = [
            'data' => $this->proyek->getSupplierJoinPengajuan($id),
            'nota' => $this->db->get_where('nota_material',['id_pengajuan' => $id])->result(),
            'total_real' => $total_real
        ];
        return $this->load->view('accounting/showSupp',  $data);
    }

    public function showSisaPembayaran(){
        $id = $_POST['id'];
        $total_material = $this->logistik->getDataPengajuanMaterialDetail($id)->result();
        $total_cicil = $this->logistik->countTotalTerbayar($id);
        $lunas = $this->db->get_where('cicil_material',['id_pengajuan' => $id, 'status' => 2])->result();


        $total_real = 0;
        $total_lunas = 0;
        foreach($total_material as $t){
            $harga_real = $this->db->get_where('master_logistik_detail',['logistik_id' => $t->id_logistik])->row();
            $total_real += $t->jml_pengajuan * $harga_real->harga_real;
        }
        $sisa_pembayaran = $total_real - $total_cicil->total;

        foreach($lunas as $l){
            $total_lunas += $l->jml_pengajuan;
        }

        if($sisa_pembayaran == 0){
            $params = [
                'lunas' => true,
                'sisa' => $sisa_pembayaran,
                'sisa1' => number_format($total_lunas),
                'sisa3' => number_format($sisa_pembayaran)
            ];
        } else {
            $params = [
                'lunas' => false,
                'sisa' => $sisa_pembayaran,
                'sisa1' => number_format($total_lunas),
                'sisa3' => number_format($sisa_pembayaran)
            ];
        }

        echo json_encode($params);
    }

    public function showHistoryPembayaran(){
        $role = $this->session->userdata('group_id');
        if($role == 3){
            $access = '';
            $approve = 'disabled';
        } else {
            $access = 'disabled';
            $approve = '';
        }
        $id = $_POST['id'];
        $history = $this->db->get_where('cicil_material',['id_pengajuan' => $id])->result();
        $html = '';
        $i = 1;
        foreach($history as $h){
            $date = date_create($h->tgl_pengajuan);

            if($h->status == 1){
                $status = 'Menunggu Super Admin';
                $color = 'warning';

                $btn = '
                    <button data-id="'.$h->id_cicil.'" '.$approve.' class="btn btn-xs btn-success apprv"><i class="fa fa-check"></i></button>
                    <button data-id="'.$h->id_cicil.'" '.$approve.' class="btn btn-xs btn-danger rejc"><i class="fa fa-times"></i></button>
                ';
            } else if($h->status == 2){
                $status = 'Approved';
                $color = 'success';

                if($h->bukti_pembayaran == null){
                    $btn = '<button '.$access.' class="btn btn-xs btn-success addBuktiPembayaran" type="button" data-id="'.$h->id_cicil.'"><i class="fa fa-plus"></i></button>';
                } else {
                    $btn = '';
                }

            } else if($h->status == 0){
                $status = 'Di Tolak';
                $color = 'danger';

                $btn = '<button '.$access.' class="btn btn-xs btn-warning repeatPengajuan" type="button" data-id="'.$h->id_cicil.'" data-tgl="'.$h->tgl_pengajuan.'" data-jml="'.$h->jml_pengajuan.'"><i class="fa fa-edit"></i></button>
                        <button  '.$access.' class="btn btn-xs btn-danger deletePengajuan" type="button" data-id="'.$h->id_cicil.'"><i class="fa fa-trash"></i></button>';
            }


            if($h->bukti_pembayaran == null){
                $bukti_img = '-';
            } else {
                $bukti_img = '<img src="'.base_url('/assets/bukti_pembayaran/'). $h->bukti_pembayaran.'" width="20%">';
            }


            $html .= '<tr>
                        <td>'.$i++.'</td>
                        <td>'.date_format($date, 'd F Y').'</td>
                        <td>Rp. '.number_format($h->jml_pengajuan).'</td>
                        <td>'.$bukti_img.'</td>
                        <td><span class="badge badge-'.$color.'">'.$status.'</span></h6></td>
                        <td>'.$btn.'</td>
                    </tr>';
        }
        echo $html;
    }

    public function addBuktiTransaksiMaterial(){
        $id = $_POST['id_cicil'];
        $img = $_FILES['bukti'];

        if($img){
            $config['upload_path']          = './assets/bukti_pembayaran/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';

            $this->load->library('upload', $config);

            if($this->upload->do_upload('bukti')){
                $bukti = $this->upload->data('file_name');

                if($this->db->set('bukti_pembayaran', $bukti)->where('id_cicil', $id)->update('cicil_material')){
                    $params = [
                        'success' => true,
                        'msg' => 'Bukti Transaksi Berhasil di Tambahkan'
                    ];
                } else {
                    $params = [
                        'success' => false,
                        'msg' => 'Bukti Transaksi Gagal di Tambahkan'
                    ];
                }

            } else {
                $params = [
                    'success' => false,
                    'msg' => 'Error Upload file'
                ];
            }

        } else {
            $params = [
                'success' => false,
                'msg' => 'No file selected'
            ];
        }
        echo json_encode($params);
    }
    
    public function repeatPengajuan(){

        $jml = $_POST['jml_repeat'];
        $max = $_POST['repeat_max'];
        if($jml > $max){
            $params = [
                'success' => false,
                'msg' => 'Jumlah melebihi maksimal'
            ];
            echo json_encode($params);
            die;
        }

        $id = $_POST['id_repeat'];
        $data = [
            'tgl_pengajuan' => $_POST['tgl_repeat'],
            'jml_pengajuan' => $_POST['jml_repeat'],
            'status' => 1
        ];
        if($this->db->where('id_cicil', $id)->update('cicil_material', $data)){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan berhasil di kirim ulang'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Pengajuan gagal di kirim ulang'
            ];
        }
        echo json_encode($params);
    }

    public function deleteHistoryCicil(){
        $id = $_POST['id'];
        $this->db->where('id_cicil', $id)->delete('cicil_material');
        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Pengajuan gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    //insidentil

    public function showSisaInsidentil(){
        $id = $_POST['id'];
        $jml_awal = $this->db->get_where('tbl_proyek_insidentil',['id' => $id])->row()->nilai;
        $terbayar = 0;
        $data_terbayar = $this->db->get_where('cicil_insidentil',['id_insidentil' => $id, 'status' => 2])->result();
        foreach($data_terbayar as $t){
            $terbayar += $t->jml_pengajuan;
        }
        $sisa_pembayaran = $jml_awal - $terbayar;
        if($sisa_pembayaran == 0){
            $data = [
                'lunas' => true,
                'sisa' => $sisa_pembayaran,
                'terbayar' => number_format($terbayar),
                'sisa1' => number_format($sisa_pembayaran)
            ];
        } else {
            $data = [
                'lunas' => false,
                'sisa' => $sisa_pembayaran,
                'terbayar' => number_format($terbayar),
                'sisa1' => number_format($sisa_pembayaran)
            ];
        }
        echo json_encode($data);

    }

    public function addCicilInsidentil(){
        $pengajuan = $_POST['pengajuan'];
        $max = $_POST['max_pengajuan'];
        if($pengajuan > $max){
            $params = [
                'success' => false,
                'msg' => 'Jumlah pengajuan melebihi maksimal'
            ];
            echo json_encode($params);
            die;
        }
            $data = [
                'id_insidentil' => $_POST['id'],
                'tgl_input' => $_POST['date'],
                'jml_pengajuan' => $pengajuan,
                'bukti_transfer' => '',
                'status' => 1
            ];
            if($this->db->insert('cicil_insidentil', $data)){
                $params = [
                    'success' => true,
                    'msg' => 'Pengajuan berhasil di tambahkan'
                ];
            } else {
                $params = [
                    'success' => false,
                    'msg' => 'Pengajuan gagal di tambahkan'
                ];
            }
            echo json_encode($params);
        
    }

    public function showHistoryInsidentil(){
        $id = $_POST['id'];
        $data = $this->db->get_where('cicil_insidentil',['id_insidentil' => $id])->result();
        $html = '';
        
        foreach($data as $d){
            $group = $this->session->userdata('group_id');
            $date = date_create($d->tgl_input);

            if($d->bukti_transfer == ''){
                $bukti = '-';
            } else {
                $bukti = '<img src="'.base_url('/assets/bukti_pembayaran/'). $d->bukti_transfer.'" width="20%">';
            }

            if($d->status == 1){
                $color = 'warning';
                $text = 'Menunggu Super Admin';
            } else if($d->status == 2){
                $color = 'success';
                $text = 'Approved Super Admin';
            } else if($d->status == 0){
                $color = 'danger';
                $text = 'Di tolak Super Admin';
            }

            if($group == 3){
                if($d->status == 0){
                    $btn = '<button class="btn btn-xs btn-warning editPengajuan" type="button" data-id="'.$d->id_cicil.'" data-date="'.$d->tgl_input.'" data-jml="'.$d->jml_pengajuan.'"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-xs btn-danger deletePengajuan" type="button" data-id="'.$d->id_cicil.'"><i class="fa fa-trash"></i></button>';  
                } else if($d->status == 1) {
                    $btn = '';
                } else if($d->status == 2) {
                    if($d->bukti_transfer == ''){
                        $btn = '<button class="btn btn-xs btn-success addBukti" type="button" data-id="'.$d->id_cicil.'"><i class="fa fa-plus"></i></button>';
                    } else {
                        $btn = '';
                    }
                }
            } else if($group == 1){
                if($d->status == 1){
                    $btn = '
                    <button data-id="'.$d->id_cicil.'" class="btn btn-xs btn-success apprv"><i class="fa fa-check"></i></button>
                    <button data-id="'.$d->id_cicil.'" class="btn btn-xs btn-danger rejc"><i class="fa fa-times"></i></button>
                    ';
                } else {
                    $btn = '';
                }
            }



            $html .= '<tr>
                        <td>'.date_format($date, 'd F Y').'</td>
                        <td>'.number_format($d->jml_pengajuan).'</td>
                        <td>'.$bukti.'</td>
                        <td><span class="badge badge-'.$color.'">'.$text.'</span></td>
                        <td>
                            '.$btn.'
                        </td>
                    </tr>';
        }
        echo $html;
    }


    public function editCicilInsidentil(){
        $jml = $_POST['jml_edit'];
        $max = $_POST['max_edit'];
        $id = $_POST['id_edit'];

        if($jml > $max){
            $this->session->set_flashdata('error','Jumlah pengajuan melebihi maksimal');
            redirect('accounting/insidentil');
        }

        $data = [
            'jml_pengajuan' => $jml,
            'tgl_input' => $_POST['tgl_edit'],
            'status' => 1
        ];
        if($this->db->where('id_cicil', $id)->update('cicil_insidentil', $data)){
            $this->session->set_flashdata('success','Pengajuan berhasil di edit');
        } else {
            $this->session->set_flashdata('error','Pengajuan gagal di edit');
        }
        redirect('accounting/insidentil');

    }

    public function deleteCicilInsidentil(){
        $id = $_POST['id'];
        if($this->db->where('id_cicil', $id)->delete('cicil_insidentil')){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Pengajuan gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function addBuktiCicilInsidentil(){
        $id = $_POST['id_cicil'];
        $img = $_FILES['bukti'];
        if($img){
            $config['upload_path']          = './assets/bukti_pembayaran/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';

            $this->load->library('upload', $config);

            if($this->upload->do_upload('bukti')){
                $bukti = $this->upload->data('file_name');
                $this->db->set('bukti_transfer', $bukti)->where('id_cicil', $id)->update('cicil_insidentil');
                if($this->db->affected_rows() > 0){
                    $params = [
                        'success' => true,
                        'msg' => 'File berhasil di upload'
                    ];
                } else {
                    $params = [
                        'success' => false,
                        'msg' => 'File gagal di upload'
                    ];
                }

            } else {
                $params = [
                    'success' => false,
                    'msg' => 'Error upload file'
                ];
            }

            echo json_encode($params);

        }  
    }

    public function kas_operasional(){
        $id_perum =  $this->session->userdata('id_perumahan');
        $data = [
            'data' => $this->db->get_where('kas_operasional',['id_perumahan' => $id_perum])->result(),
            'kode' => $this->db->get('kode')->result()
        ];
        $this->template->load('template', 'accounting/kas', $data);
    }

    public function add_kas(){
        $data = [
            'tgl_input' => $_POST['tgl'],
            'keterangan' => $_POST['ket'],
            'jumlah' => $_POST['jml'],
            'id_perumahan' => $this->session->userdata('id_perumahan'),
            'title_kode' => $_POST['title_kode'],
            'status' => 1
        ];
        if($this->db->insert('kas_operasional', $data)){
            $params = [
                'success' => true,
                'msg' => 'Kas operasional berhasil di tambahkan'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Kas operasional gagal di tambahkan'
            ];
        }
        echo json_encode($params);
    }

    public function edit_kas(){
        $id = $_POST['id_kas'];
        $data = [
            'tgl_input' => $_POST['tgl'],
            'keterangan' => $_POST['ket'],
            'jumlah' => $_POST['jml'],
            'title_kode' => $_POST['title_kode'],
            'status' => 1
        ];
        if($this->db->where('id_kas', $id)->update('kas_operasional', $data)){
            $params = [
                'success' => true,
                'msg' => 'Kas operasional berhasil di Edit'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Kas operasional gagal di Edit'
            ];
        }
        echo json_encode($params);
    }

    public function set_status_kas(){
        $id = $_POST['id'];
        $type = $_POST['type'];
        if($type == 'approve'){
            $status = 2;
        } else if($type == 'reject'){
            $status = 0;
        }
        if($this->db->set('status', $status)->where('id_kas', $id)->update('kas_operasional')){
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

    public function delete_kas(){
        $id = $_POST['id'];
        if($this->db->delete('kas_operasional',['id_kas' => $id])){
            $params = [
                'success' => true,
                'msg' => 'Kas operasional berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Kas operasional gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function getSisaCicilKas(){
        $id_kas = $_POST['id'];
        $data_kas = $this->db->get_where('kas_operasional',['id_kas' => $id_kas])->row();
        $data_cicil = $this->db->get_where('cicil_kas',['id_kas' => $id_kas])->result();

        $total_terbayar = 0;
        foreach($data_cicil as $dc){
            if($dc->status == 2){
                $total_terbayar += $dc->jumlah;
            }
        }

        $sisa_pembayaran = $data_kas->jumlah - $total_terbayar;

        if($sisa_pembayaran == 0){
            //lunas
            $lunas = true;
        } else if($sisa_pembayaran > 0){
            //belum lunas
            $lunas = false;
        } else if($sisa_pembayaran < 0){
            //error input
            $lunas = false;
        }

        $data = [
            'jumlah_pembayaran' => $data_kas->jumlah,
            'sisa_pembayaran' => $sisa_pembayaran,
            'sisa' => number_format($sisa_pembayaran),
            'total_terbayar' => number_format($total_terbayar),
            'lunas' => $lunas
        ];
        echo json_encode($data);

    }

    public function showHistoryKas(){
        $id_kas = $_POST['id'];
        $data_cicil = $this->db->get_where('cicil_kas',['id_kas' => $id_kas])->result();
        $html = '';

        $group = $this->session->userdata('group_id');
        if($group == 3){
            $access = '';
            $approve = 'disabled';
        } else {
            $access = 'disabled';
            $approve = '';
        }
 
        foreach($data_cicil as $dc){
            $date = date_create($dc->tanggal);
            if($dc->bukti == ''){
                $bukti = '-';
            } else {
                $bukti = '<img src="'.base_url('/assets/bukti_pembayaran/'). $dc->bukti.'" width="20%">';
            }

            if($dc->status == 0){
                $color = 'danger';
                $text = 'Di Tolak Super Admin';

                $btn = '<button class="btn btn-xs btn-warning edit-cicil" '.$access.' type="button" data-id="'.$dc->id_cicil.'" data-jml="'.$dc->jumlah.'" data-tgl="'.$dc->tanggal.'"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-xs btn-danger delete-cicil" '.$access.' type="button" data-id="'.$dc->id_cicil.'"><i class="fa fa-trash"></i></button>';

            } else if($dc->status == 1){
                $color = 'warning';
                $text = 'Menunggu Super Admin';
                $btn = '
                <button data-id="'.$dc->id_cicil.'" '.$approve.' class="btn btn-xs btn-success apprv"><i class="fa fa-check"></i></button>
                <button data-id="'.$dc->id_cicil.'" '.$approve.' class="btn btn-xs btn-danger rejc"><i class="fa fa-times"></i></button>
                ';
            } else if($dc->status == 2){
                $color = 'success';
                $text = 'Approved Super Admin';
                if($dc->bukti == ''){
                    $btn = '<button class="btn btn-xs btn-primary bukti" '.$access.' type="button" data-id="'.$dc->id_cicil.'"><i class="fa fa-plus"></i></button>';
                } else {
                    $btn = '';
                }
            }

            $html .= '<tr>
                        <td>'.date_format($date, 'd F Y').'</td>
                        <td>Rp. '.number_format($dc->jumlah).'</td>
                        <td>'.$bukti.'</td>
                        <td><span class="badge badge-'.$color.'">'.$text.'</span></td>
                        <td>'.$btn.'</td>
                    </tr>';
        }
        echo $html;
    }

    public function adddCicilKas(){
        $id_kas = $_POST['id_dana_kas'];
        $dana = $_POST['dana'];
        $max_dana = $_POST['max_dana'];
        if($dana > $max_dana){
            $params = [
                'success' => false,
                'msg' => 'Jumlah pengajuan melebihi maksimal'
            ];
            echo json_encode($params);
            die;
        }

        $data = [
            'id_kas' => $id_kas,
            'tanggal' => $_POST['date'],
            'jumlah' => $dana,
            'bukti' => '',
            'status' => 1
        ];
        $this->db->insert('cicil_kas', $data);
        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan dana berhasil di tambahkan'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Pengajuan dana gagal di tambahkan'
            ];
        }
        echo json_encode($params);
    }

    public function addBuktiKas(){
        $id = $_POST['id_cicil'];
        $img = $_FILES['bukti'];

        if($img){
            $config['upload_path']          = './assets/bukti_pembayaran/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            if($this->upload->do_upload('bukti')){
                $bukti = $this->upload->data('file_name');
                $this->db->set('bukti', $bukti)->where('id_cicil', $id)->update('cicil_kas');
                if($this->db->affected_rows() > 0){
                    $params = [
                        'success' => true,
                        'msg' => 'File berhasil di upload'
                    ];  
                } else {
                    $params = [
                        'success' => false,
                        'msg' => 'File gagal di upload'
                    ];  
                }
            } else {
                $params = [
                    'success' => false,
                    'msg' => 'Error upload file'
                ];
            }
        }
        echo json_encode($params);
    }

    public function editCicilKas(){
        $id = $_POST['id_cicil_edit'];
        $jml = $_POST['jml_edit'];
        $max = $_POST['max_edit'];
        if($jml > $max){
            $params = [
                'success' => false,
                'msg' => 'Jumlah pengajuan melebihi maksimal'
            ];
            echo json_encode($params);
            die;
        }

        $data = [
            'tanggal' => $_POST['date_edit'],
            'jumlah' => $jml,
            'status' =>1
        ];

        $this->db->where('id_cicil', $id)->update('cicil_kas', $data);
        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan dana berhasil di update'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Pengajuan dana gagal di update'
            ];
        }
        echo json_encode($params);

    }

    public function deleteCicilKas(){
        $id = $_POST['id'];
        if($this->db->delete('cicil_kas', ['id_cicil' => $id])){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Pengajuan gagal di hapus'
            ];
        }
        echo json_encode($params);
    }


    public function approveKas(){
        $id_cicil = $_POST['id'];
        $cicil = $this->db->get_where('cicil_kas',['id_cicil' => $id_cicil])->row();
        $kas = $this->db->get_where('kas_operasional',['id_kas' => $cicil->id_kas])->row();

        $title_kode = $kas->title_kode;
        $jml = $cicil->jumlah;
        $id_perum = $kas->id_perumahan;

        if($this->db->set('status', 2)->where('id_cicil', $id_cicil)->update('cicil_kas')){
            $this->toHistoryApprove($title_kode, $jml, $id_perum);
            $params = ['msg' => 'Approve berhasil'];
        } else {
            $params = ['msg' => 'Approve gagal'];
        }
        echo json_encode($params);
    }

    public function rejectKas(){
        $id_cicil = $_POST['id'];
        if($this->db->set('status', 0)->where('id_cicil', $id_cicil)->update('cicil_kas')){
            $params = ['msg' => 'Reject berhasil'];
        } else {
            $params = ['msg' => 'Reject gagal'];
        }
        echo json_encode($params);
    }

    //fee marketing

    public function showSisaFeeMarketing(){
        $id = $_POST['id'];
        $data_cicil = $this->db->get_where('cicil_fee_marketing',['id_marketing' => $id])->result();
        $data_fee = $this->db->get_where('tbl_marketing',['id_marketing' => $id])->row();

        $juml = $data_fee->nominal_fee_marketing;
        $terbayar = 0;
        foreach($data_cicil as $c){
            if($c->status == 2){
                $terbayar += $c->jumlah;
            }
        }
        
        $sisa = $juml - $terbayar;

        if($sisa == 0){
            $lunas = true;
        } else {
            $lunas = false;
        }

        $data = [
            'terbayar' => number_format($terbayar),
            'sisa' => $sisa,
            'sisa1' => number_format($sisa),
            'lunas' => $lunas
        ];
        echo json_encode($data);
    }

    public function showHistoryCicilFee(){
        $role = $this->session->userdata('group_id');
        if($role == 3){
            $access = '';
            $approve = 'disabled';
        } else {
            $access = 'disabled';
            $approve = '';
        }
        $id = $_POST['id'];
        $data_cicil = $this->db->get_where('cicil_fee_marketing',['id_marketing' => $id])->result();
        $html = '';
        foreach($data_cicil as $d){
            $date = date_create($d->tanggal);
            if($d->bukti == ''){
                $bukti = '-';
            } else {
                $bukti = '<img src="'.base_url('/assets/bukti_pembayaran/'). $d->bukti.'" width="20%">';
            }

            if($d->status == 0){
                $color = 'danger';
                $txt = 'di Tolak';

                $btn = '<button '.$access.' class="btn btn-xs btn-warning edit-pengajuan" type="button" data-id="'.$d->id_cicil.'" data-date="'.$d->tanggal.'" data-jml="'.$d->jumlah.'"><i class="fa fa-edit"></i></button>
                <button '.$access.' class="btn btn-xs btn-danger delete-pengajuan" type="button" data-id="'.$d->id_cicil.'"><i class="fa fa-trash"></i></button>';

            } else if($d->status == 1){
                $color = 'warning';
                $txt = 'Menunggu Super Admin';
                $btn = '
                <button '.$approve.' data-id="'.$d->id_cicil.'" class="btn btn-xs btn-success apprv"><i class="fa fa-check"></i></button>
                <button '.$approve.' data-id="'.$d->id_cicil.'" class="btn btn-xs btn-danger rejc"><i class="fa fa-times"></i></button>
                ';
            } else if($d->status == 2){
                $color = 'success';
                $txt = 'Approved';
                
                if($d->bukti == ''){
                    $btn = '<button '.$access.' class="btn btn-xs btn-primary add-bukti" type="button" data-id="'.$d->id_cicil.'"><i class="fa fa-plus"></i></button>';
                } else {
                    $btn = '';
                }
            }

            $html .= '<tr>
                        <td>'.date_format($date, 'd F Y').'</td>
                        <td>Rp. '.number_format($d->jumlah).'</td>
                        <td>'.$bukti.'</td>
                        <td><span class="badge badge-'.$color.'">'.$txt.'</span></td>
                        <td>'.$btn.'</td>
                    </tr>';
        }
        echo $html;
    }

    public function addCicilFee(){
        $id = $_POST['id_marketing'];
        $jml = $_POST['jml'];
        $max = $_POST['max_jml'];
        
        if($jml > $max){
            $params = [
                'success' => false,
                'msg' => 'Jumlah melebihi maksimal'
            ];
            echo json_encode($params);
            die;
        }

        $data = [
            'id_marketing' => $id,
            'tanggal' => $_POST['tanggal'],
            'jumlah' => $jml,
            'bukti' =>'',
            'status' => 1,
        ];

        if($this->db->insert('cicil_fee_marketing', $data)){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan berhasil di tambahkan'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Pengajuan gagal di tambahkan'
            ];
        }

        echo json_encode($params);

    }

    public function editCicilFee(){
        $id = $_POST['id_edit'];
        $jml = $_POST['jml_edit'];
        $max = $_POST['max_edit'];

        if($jml > $max){
            $params = [
                'success' => false,
                'msg' => 'Jumlah pengajuan melebihi maksimal'
            ];   
            echo json_encode($params);
            die;
        }
        $data = [
            'tanggal' => $_POST['date'],
            'jumlah' => $jml,
            'status' => 1
        ];
        if($this->db->where('id_cicil', $id)->update('cicil_fee_marketing', $data)){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan berhasil di edit'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Pengajuan gagal di edit'
            ];
        }
        echo json_encode($params);

    }

    public function deleteCicilFee(){
        $id = $_POST['id'];
        if($this->db->delete('cicil_fee_marketing',['id_cicil' => $id])){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => true,
                'msg' => 'Pengajuan gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function addBuktiCicilFee(){
        $id = $_POST['id_bukti'];
        $img = $_FILES['bukti'];
        if($img){
            $config['upload_path']          = './assets/bukti_pembayaran/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            if($this->upload->do_upload('bukti')){
                $bukti = $this->upload->data('file_name');
                $this->db->set('bukti', $bukti)->where('id_cicil', $id)->update('cicil_fee_marketing');
                if($this->db->affected_rows() > 0){
                    $params = [
                        'success' => true,
                        'msg' => 'File berhasil di upload'
                    ];  
                } else {
                    $params = [
                        'success' => false,
                        'msg' => 'File gagal di upload'
                    ];  
                }
            } else {
                $params = [
                    'success' => false,
                    'msg' => 'Error upload file'
                ];
            }
        }
        echo json_encode($params);
    }


    //pembatalan transaksi

    public function showSisaPembatalan(){
        
        $id = $_POST['id'];

        $pembatalan = $this->db->get_where('pembatalan_transaksi',['id_pembatalan' => $id])->row();
        $cicil = $this->db->get_where('cicil_pembatalan',['id_pembatalan' => $id])->result();

        $terbayar = 0;
        foreach($cicil as $c){
            if($c->status == 2){
                $terbayar += $c->jumlah;
            }
        }
        $sisa = $pembatalan->total_pengembalian - $terbayar;
        if($sisa == 0){
            $lunas = true;
        } else {
            $lunas = false;
        }

        

        $data = [
            'terbayar' => number_format($terbayar),
            'sisa' => $sisa,
            'sisa1' => number_format($sisa),
            'lunas' => $lunas
        ];
        echo json_encode($data);

    }

    public function showHistoryPembatalan(){
        $role = $this->session->userdata('group_id');
        if($role == 3){
            $access = '';
            $approve = 'disabled';
        } else {
            $access = 'disabled';
            $approve = '';
        }
        $id = $_POST['id'];
        $data_cicil = $this->db->get_where('cicil_pembatalan',['id_pembatalan' => $id])->result();
        $html = '';
        foreach($data_cicil as $d){
            $date = date_create($d->tanggal);
            if($d->bukti == ''){
                $bukti = '-';
            } else {
                $bukti = '<img src="'.base_url('/assets/bukti_pembayaran/'). $d->bukti.'" width="20%">';
            }

            if($d->status == 0){
                $color = 'danger';
                $txt = 'di Tolak';

                $btn = '<button '.$access.' class="btn btn-xs btn-warning edit-pengajuan" type="button" data-id="'.$d->id_cicil.'" data-date="'.$d->tanggal.'" data-jml="'.$d->jumlah.'"><i class="fa fa-edit"></i></button>
                <button '.$access.' class="btn btn-xs btn-danger delete-pengajuan" type="button" data-id="'.$d->id_cicil.'"><i class="fa fa-trash"></i></button>';

            } else if($d->status == 1){
                $color = 'warning';
                $txt = 'Menunggu Super Admin';
                $btn = '
                <button '.$approve.' data-id="'.$d->id_cicil.'" class="btn btn-xs btn-success apprv"><i class="fa fa-check"></i></button>
                <button '.$approve.' data-id="'.$d->id_cicil.'" class="btn btn-xs btn-danger rejc"><i class="fa fa-times"></i></button>
                ';
            } else if($d->status == 2){
                $color = 'success';
                $txt = 'Approved';
                
                if($d->bukti == ''){
                    $btn = '<button '.$access.' class="btn btn-xs btn-primary add-bukti" type="button" data-id="'.$d->id_cicil.'"><i class="fa fa-plus"></i></button>';
                } else {
                    $btn = '';
                }
            }

            $html .= '<tr>
                        <td>'.date_format($date, 'd F Y').'</td>
                        <td>Rp. '.number_format($d->jumlah).'</td>
                        <td>'.$bukti.'</td>
                        <td><span class="badge badge-'.$color.'">'.$txt.'</span></td>
                        <td>'.$btn.'</td>
                    </tr>';
        }
        echo $html;
    }

    public function addCicilPembatalan(){
        $jml = $_POST['jml'];
        $max = $_POST['jml_max'];
        if($jml > $max){
            $params = [
                'success' => false,
                'msg' => 'Jumlah pengajuan melebihi maksimal'
            ];
            echo json_encode($params);
            die;
        }

        $data = [
            'id_pembatalan' => $_POST['id_pembatalan'],
            'tanggal' => $_POST['tgl'],
            'jumlah' => $jml,
            'bukti' => '',
            'status' => 1
        ];
        if($this->db->insert('cicil_pembatalan', $data)){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan berhasil di tambahkan'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Pengajuan gagal di tambahkan'
            ];
        }
        echo json_encode($params);
    }

    public function editCicilPembatalan(){
        $id = $_POST['id_edit'];
        $jml = $_POST['jml_edit'];
        $max = $_POST['max_edit'];

        if($jml > $max){
            $params = [
                'success' => false,
                'msg' => 'Jumlah pengajuan melebihi maksimal'
            ];   
            echo json_encode($params);
            die;
        }
        $data = [
            'tanggal' => $_POST['date'],
            'jumlah' => $jml,
            'status' => 1
        ];
        if($this->db->where('id_cicil', $id)->update('cicil_pembatalan', $data)){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan berhasil di edit'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Pengajuan gagal di edit'
            ];
        }
        echo json_encode($params);
    }

    public function deleteCicilPembatalan(){
        $id = $_POST['id'];
        if($this->db->delete('cicil_pembatalan',['id_cicil' => $id])){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => true,
                'msg' => 'Pengajuan gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function addBuktiCicilPembatalan(){
        $id = $_POST['id_bukti'];
        $img = $_FILES['bukti'];
        if($img){
            $config['upload_path']          = './assets/bukti_pembayaran/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            if($this->upload->do_upload('bukti')){
                $bukti = $this->upload->data('file_name');
                $this->db->set('bukti', $bukti)->where('id_cicil', $id)->update('cicil_pembatalan');
                if($this->db->affected_rows() > 0){
                    $params = [
                        'success' => true,
                        'msg' => 'File berhasil di upload'
                    ];  
                } else {
                    $params = [
                        'success' => false,
                        'msg' => 'File gagal di upload'
                    ];  
                }
            } else {
                $params = [
                    'success' => false,
                    'msg' => 'Error upload file'
                ];
            }
        }
        echo json_encode($params);
    }

    //progres pembangunan

    public function showSisaProgres(){
        $id = $_POST['id'];
        $data_cicil = $this->db->get_where('cicil_progres',['id_progres' => $id])->result();
        $data = $this->db->get_where('progres_pembangunan',['id_progres' => $id])->row();

        $juml = $data->total;
        $terbayar = 0;
        foreach($data_cicil as $c){
            if($c->status == 2){
                $terbayar += $c->jumlah;
            }
        }
        
        $sisa = $juml - $terbayar;

        if($sisa == 0){
            $lunas = true;
        } else {
            $lunas = false;
        }

        $data = [
            'terbayar' => number_format($terbayar),
            'sisa' => $sisa,
            'sisa1' => number_format($sisa),
            'lunas' => $lunas
        ];
        echo json_encode($data);
    }

    public function showHistoryCicilProgres(){
        $role = $this->session->userdata('group_id');
        if($role == 3){
            $access = '';
            $approve = 'disabled';
        } else {
            $access = 'disabled';
            $approve = '';
        }
        $id = $_POST['id'];
        $data_cicil = $this->db->get_where('cicil_progres',['id_progres' => $id])->result();
        $html = '';
        foreach($data_cicil as $d){
            $date = date_create($d->tanggal);
            if($d->bukti == ''){
                $bukti = '-';
            } else {
                $bukti = '<img src="'.base_url('/assets/bukti_pembayaran/'). $d->bukti.'" width="20%">';
            }

            if($d->status == 0){
                $color = 'danger';
                $txt = 'di Tolak';

                $btn = '<button '.$access.' class="btn btn-xs btn-warning edit-pengajuan" type="button" data-id="'.$d->id_cicil.'" data-date="'.$d->tanggal.'" data-jml="'.$d->jumlah.'"><i class="fa fa-edit"></i></button>
                <button '.$access.' class="btn btn-xs btn-danger delete-pengajuan" type="button" data-id="'.$d->id_cicil.'"><i class="fa fa-trash"></i></button>';

            } else if($d->status == 1){
                $color = 'warning';
                $txt = 'Menunggu Super Admin';
                $btn = '
                <button data-id="'.$d->id_cicil.'" '.$approve.' class="btn btn-xs btn-success apprv"><i class="fa fa-check"></i></button>
                <button data-id="'.$d->id_cicil.'" '.$approve.' class="btn btn-xs btn-danger rejc"><i class="fa fa-times"></i></button>
                ';
            } else if($d->status == 2){
                $color = 'success';
                $txt = 'Approved';
                
                if($d->bukti == ''){
                    $btn = '<button '.$access.' class="btn btn-xs btn-primary add-bukti" type="button" data-id="'.$d->id_cicil.'"><i class="fa fa-plus"></i></button>';
                } else {
                    $btn = '';
                }
            }

            $html .= '<tr>
                        <td>'.date_format($date, 'd F Y').'</td>
                        <td>Rp. '.number_format($d->jumlah).'</td>
                        <td>'.$bukti.'</td>
                        <td><span class="badge badge-'.$color.'">'.$txt.'</span></td>
                        <td>'.$btn.'</td>
                    </tr>';
        }
        echo $html;
    }

    public function addCicilProgres(){
        $id = $_POST['id_progres'];
        $jml = $_POST['jml'];
        $max = $_POST['max_jml'];
        
        if($jml > $max){
            $params = [
                'success' => false,
                'msg' => 'Jumlah melebihi maksimal'
            ];
            echo json_encode($params);
            die;
        }

        $data = [
            'id_progres' => $id,
            'tanggal' => $_POST['tanggal'],
            'jumlah' => $jml,
            'bukti' =>'',
            'status' => 1,
        ];

        if($this->db->insert('cicil_progres', $data)){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan berhasil di tambahkan'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Pengajuan gagal di tambahkan'
            ];
        }

        echo json_encode($params);

    }

    public function editCicilProgres(){
        $id = $_POST['id_edit'];
        $jml = $_POST['jml_edit'];
        $max = $_POST['max_edit'];

        if($jml > $max){
            $params = [
                'success' => false,
                'msg' => 'Jumlah pengajuan melebihi maksimal'
            ];   
            echo json_encode($params);
            die;
        }
        $data = [
            'tanggal' => $_POST['date'],
            'jumlah' => $jml,
            'status' => 1
        ];
        if($this->db->where('id_cicil', $id)->update('cicil_progres', $data)){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan berhasil di edit'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Pengajuan gagal di edit'
            ];
        }
        echo json_encode($params);

    }

    public function deleteCicilProgres(){
        $id = $_POST['id'];
        if($this->db->delete('cicil_progres',['id_cicil' => $id])){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => true,
                'msg' => 'Pengajuan gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function addBuktiCicilProgres(){
        $id = $_POST['id_bukti'];
        $img = $_FILES['bukti'];
        if($img){
            $config['upload_path']          = './assets/bukti_pembayaran/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            if($this->upload->do_upload('bukti')){
                $bukti = $this->upload->data('file_name');
                $this->db->set('bukti', $bukti)->where('id_cicil', $id)->update('cicil_progres');
                if($this->db->affected_rows() > 0){
                    $params = [
                        'success' => true,
                        'msg' => 'File berhasil di upload'
                    ];  
                } else {
                    $params = [
                        'success' => false,
                        'msg' => 'File gagal di upload'
                    ];  
                }
            } else {
                $params = [
                    'success' => false,
                    'msg' => 'Error upload file'
                ];
            }
        }
        echo json_encode($params);
    }

    //pengeluaran lain

    public function showSisaPengeluaran(){
        $id = $_POST['id'];
        $data_cicil = $this->db->get_where('cicil_pengeluaran_lain',['id_pengeluaran' => $id])->result();
        $data = $this->db->get_where('pengeluaran_lain',['id_pengeluaran' => $id])->row();

        $juml = $data->jml_pengeluaran;
        $terbayar = 0;
        foreach($data_cicil as $c){
            if($c->status == 2){
                $terbayar += $c->jumlah;
            }
        }
        
        $sisa = $juml - $terbayar;

        if($sisa == 0){
            $lunas = true;
        } else {
            $lunas = false;
        }

        $data = [
            'terbayar' => number_format($terbayar),
            'sisa' => $sisa,
            'sisa1' => number_format($sisa),
            'lunas' => $lunas
        ];
        echo json_encode($data);
    }

    public function showHistoryCicilPengeluaran(){
        $role = $this->session->userdata('group_id');
        if($role == 3){
            $access = '';
            $approve = 'disabled';
        } else {
            $access = 'disabled';
            $approve = '';
        }
        $id = $_POST['id'];
        $data_cicil = $this->db->get_where('cicil_pengeluaran_lain',['id_pengeluaran' => $id])->result();
        $html = '';
        foreach($data_cicil as $d){
            $date = date_create($d->tanggal);
            if($d->bukti == ''){
                $bukti = '-';
            } else {
                $bukti = '<img src="'.base_url('/assets/bukti_pembayaran/'). $d->bukti.'" width="20%">';
            }

            if($d->status == 0){
                $color = 'danger';
                $txt = 'di Tolak';

                $btn = '<button '.$access.' class="btn btn-xs btn-warning edit-pengajuan" type="button" data-id="'.$d->id_cicil.'" data-date="'.$d->tanggal.'" data-jml="'.$d->jumlah.'"><i class="fa fa-edit"></i></button>
                <button '.$access.' class="btn btn-xs btn-danger delete-pengajuan" type="button" data-id="'.$d->id_cicil.'"><i class="fa fa-trash"></i></button>';

            } else if($d->status == 1){
                $color = 'warning';
                $txt = 'Menunggu Super Admin';
                $btn = '
                    <button data-id="'.$d->id_cicil.'" '.$approve.' class="btn btn-xs btn-success apprv"><i class="fa fa-check"></i></button>
                    <button data-id="'.$d->id_cicil.'" '.$approve.' class="btn btn-xs btn-danger rejc"><i class="fa fa-times"></i></button>
                ';
            } else if($d->status == 2){
                $color = 'success';
                $txt = 'Approved';
                
                if($d->bukti == ''){
                    $btn = '<button '.$access.' class="btn btn-xs btn-primary add-bukti" type="button" data-id="'.$d->id_cicil.'"><i class="fa fa-plus"></i></button>';
                } else {
                    $btn = '';
                }
            }

            $html .= '<tr>
                        <td>'.date_format($date, 'd F Y').'</td>
                        <td>Rp. '.number_format($d->jumlah).'</td>
                        <td>'.$bukti.'</td>
                        <td><span class="badge badge-'.$color.'">'.$txt.'</span></td>
                        <td>'.$btn.'</td>
                    </tr>';
        }
        echo $html;
    }

    public function addCicilPengeluaran(){
        $id = $_POST['id_add'];
        $jml = $_POST['jml'];
        $max = $_POST['max_jml'];
        
        if($jml > $max){
            $params = [
                'success' => false,
                'msg' => 'Jumlah melebihi maksimal'
            ];
            echo json_encode($params);
            die;
        }

        $data = [
            'id_pengeluaran' => $id,
            'tanggal' => $_POST['tanggal'],
            'jumlah' => $jml,
            'bukti' =>'',
            'status' => 1,
        ];

        if($this->db->insert('cicil_pengeluaran_lain', $data)){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan berhasil di tambahkan'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Pengajuan gagal di tambahkan'
            ];
        }

        echo json_encode($params);

    }

    public function editCicilPengeluaran(){
        $id = $_POST['id_edit'];
        $jml = $_POST['jml_edit'];
        $max = $_POST['max_edit'];

        if($jml > $max){
            $params = [
                'success' => false,
                'msg' => 'Jumlah pengajuan melebihi maksimal'
            ];   
            echo json_encode($params);
            die;
        }
        $data = [
            'tanggal' => $_POST['date'],
            'jumlah' => $jml,
            'status' => 1
        ];
        if($this->db->where('id_cicil', $id)->update('cicil_pengeluaran_lain', $data)){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan berhasil di edit'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Pengajuan gagal di edit'
            ];
        }
        echo json_encode($params);

    }

    public function deleteCicilpengeluaran(){
        $id = $_POST['id'];
        if($this->db->delete('cicil_pengeluaran_lain',['id_cicil' => $id])){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => true,
                'msg' => 'Pengajuan gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function addBuktiCicilPengeluaran(){
        $id = $_POST['id_bukti'];
        $img = $_FILES['bukti'];
        if($img){
            $config['upload_path']          = './assets/bukti_pembayaran/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            if($this->upload->do_upload('bukti')){
                $bukti = $this->upload->data('file_name');
                $this->db->set('bukti', $bukti)->where('id_cicil', $id)->update('cicil_pengeluaran_lain');
                if($this->db->affected_rows() > 0){
                    $params = [
                        'success' => true,
                        'msg' => 'File berhasil di upload'
                    ];  
                } else {
                    $params = [
                        'success' => false,
                        'msg' => 'File gagal di upload'
                    ];  
                }
            } else {
                $params = [
                    'success' => false,
                    'msg' => 'Error upload file'
                ];
            }
        }
        echo json_encode($params);
    }


    //pembebasan lahan
    public function tolakPembebasanLahan(){
        $id = $_POST['id'];
        if($this->db->set('status', 0)->where('id_pembebasan', $id)->update('pembebasan_lahan')){
            $params = ['msg' => 'Pembebasan lahan berhasil di tolak'];
        } else {
            $params = ['msg' => 'Pembebasan lahan gagal di tolak'];
        }
        echo json_encode($params);
    }

    public function showSisaPembebasan(){
        $id = $_POST['id'];
        $data_cicil = $this->db->get_where('cicil_pembebasan_lahan',['id_pembebasan' => $id])->result();
        $data = $this->db->get_where('pembebasan_lahan',['id_pembebasan' => $id])->row();

        $juml = $data->total_pembelian;
        $terbayar = 0;
        foreach($data_cicil as $c){
            if($c->status == 2){
                $terbayar += $c->jumlah;
            }
        }
        
        $sisa = $juml - $terbayar;

        if($sisa == 0){
            $lunas = true;
        } else {
            $lunas = false;
        }

        $data = [
            'terbayar' => number_format($terbayar),
            'sisa' => $sisa,
            'sisa1' => number_format($sisa),
            'lunas' => $lunas
        ];
        echo json_encode($data);
    }

    public function showHistoryCicilPembebasan(){
        $role = $this->session->userdata('group_id');
        if($role == 3){
            $access = '';
            $approve = 'disabled';
        } else {
            $access = 'disabled';
            $approve = '';
        }
        $id = $_POST['id'];
        $data_cicil = $this->db->get_where('cicil_pembebasan_lahan',['id_pembebasan' => $id])->result();
        $html = '';
        foreach($data_cicil as $d){
            $date = date_create($d->tanggal);
            if($d->bukti == ''){
                $bukti = '-';
            } else {
                $bukti = '<img src="'.base_url('/assets/bukti_pembayaran/'). $d->bukti.'" width="20%">';
            }

            if($d->status == 0){
                $color = 'danger';
                $txt = 'di Tolak';

                $btn = '<button '.$access.' class="btn btn-xs btn-warning edit-pengajuan" type="button" data-id="'.$d->id_cicil.'" data-date="'.$d->tanggal.'" data-jml="'.$d->jumlah.'"><i class="fa fa-edit"></i></button>
                <button '.$access.' class="btn btn-xs btn-danger delete-pengajuan" type="button" data-id="'.$d->id_cicil.'"><i class="fa fa-trash"></i></button>';

            } else if($d->status == 1){
                $color = 'warning';
                $txt = 'Menunggu Super Admin';
                $btn = '
                    <button data-id="'.$d->id_cicil.'" '.$approve.' class="btn btn-xs btn-success apprv"><i class="fa fa-check"></i></button>
                    <button data-id="'.$d->id_cicil.'" '.$approve.' class="btn btn-xs btn-danger rejc"><i class="fa fa-times"></i></button>
                ';
            } else if($d->status == 2){
                $color = 'success';
                $txt = 'Approved';
                
                if($d->bukti == ''){
                    $btn = '<button '.$access.' class="btn btn-xs btn-primary add-bukti" type="button" data-id="'.$d->id_cicil.'"><i class="fa fa-plus"></i></button>';
                } else {
                    $btn = '';
                }
            }

            $html .= '<tr>
                        <td>'.date_format($date, 'd F Y').'</td>
                        <td>Rp. '.number_format($d->jumlah).'</td>
                        <td>'.$bukti.'</td>
                        <td><span class="badge badge-'.$color.'">'.$txt.'</span></td>
                        <td>'.$btn.'</td>
                    </tr>';
        }
        echo $html;
    }

    public function addCicilPembebasan(){
        $id = $_POST['id_data'];
        $jml = $_POST['jml'];
        $max = $_POST['max_jml'];
        
        if($jml > $max){
            $params = [
                'success' => false,
                'msg' => 'Jumlah melebihi maksimal'
            ];
            echo json_encode($params);
            die;
        }

        $data = [
            'id_pembebasan' => $id,
            'tanggal' => $_POST['tanggal'],
            'jumlah' => $jml,
            'bukti' =>'',
            'status' => 1,
        ];

        if($this->db->insert('cicil_pembebasan_lahan', $data)){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan berhasil di tambahkan'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Pengajuan gagal di tambahkan'
            ];
        }

        echo json_encode($params);

    }

    public function editCicilPembebasan(){
        $id = $_POST['id_edit'];
        $jml = $_POST['jml_edit'];
        $max = $_POST['max_edit'];

        if($jml > $max){
            $params = [
                'success' => false,
                'msg' => 'Jumlah pengajuan melebihi maksimal'
            ];   
            echo json_encode($params);
            die;
        }
        $data = [
            'tanggal' => $_POST['date'],
            'jumlah' => $jml,
            'status' => 1
        ];
        if($this->db->where('id_cicil', $id)->update('cicil_pembebasan_lahan', $data)){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan berhasil di edit'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Pengajuan gagal di edit'
            ];
        }
        echo json_encode($params);

    }

    public function deleteCicilPembebasan(){
        $id = $_POST['id'];
        if($this->db->delete('cicil_pembebasan_lahan',['id_cicil' => $id])){
            $params = [
                'success' => true,
                'msg' => 'Pengajuan berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => true,
                'msg' => 'Pengajuan gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function addBuktiCicilPembebasan(){
        $id = $_POST['id_bukti'];
        $img = $_FILES['bukti'];
        if($img){
            $config['upload_path']          = './assets/bukti_pembayaran/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            if($this->upload->do_upload('bukti')){
                $bukti = $this->upload->data('file_name');
                $this->db->set('bukti', $bukti)->where('id_cicil', $id)->update('cicil_pembebasan_lahan');
                if($this->db->affected_rows() > 0){
                    $params = [
                        'success' => true,
                        'msg' => 'File berhasil di upload'
                    ];  
                } else {
                    $params = [
                        'success' => false,
                        'msg' => 'File gagal di upload'
                    ];  
                }
            } else {
                $params = [
                    'success' => false,
                    'msg' => 'Error upload file'
                ];
            }
        }
        echo json_encode($params);
    }


    //pemasukan lain
    public function pemasukan_lain(){
        $data = [
            'data' => $this->db->get('pemasukan_lain')->result()
        ];
        $this->template->load('template', 'accounting/pemasukan_lain', $data);
    }

    public function add_pemasukan_lain(){
        $bukti = $_FILES['bukti'];
        if($bukti){
            $config['upload_path']          = './assets/bukti_pembayaran/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            if($this->upload->do_upload('bukti')){

                $img = $this->upload->data('file_name');
                $data = [
                    'keterangan' => $_POST['ket'],
                    'jumlah' => $_POST['jumlah'],
                    'tanggal' => date('Y-m-d'),
                    'bukti' => $img,
                    'status' => 1,
                    'title_kode' => $_POST['title_kode'],
                    'id_perumahan' => $this->session->userdata('id_perumahan')
                ];
                $this->db->insert('pemasukan_lain', $data);
                if($this->db->affected_rows() > 0){
                    $params = [
                        'success' => true,
                        'msg' => 'Pemasukan berhasil di tambahkan'
                    ];
                } else {
                    $params = [
                        'success' => false,
                        'msg' => 'Pemasukan gagal di tambahkan'
                    ];
                }

            } else {
                $params = [
                    'success' => false,
                    'msg' => $this->upload->display_errors() 
                ];
            }
        }
        echo json_encode($params);
    }

    public function detail_pemasukan_lain(){
        $id = $_POST['id'];

        $this->db->select('pemasukan_lain.*,
            title_kode.*,
            sub_kode.*,
            kode.*
        ')->from('pemasukan_lain')
        ->join('title_kode','pemasukan_lain.title_kode = title_kode.id_title')
        ->join('sub_kode','title_kode.id_sub = sub_kode.id_sub')
        ->join('kode','sub_kode.id_kode = kode.id_kode')
        ->where('pemasukan_lain.id_pemasukan', $id);

        $data = $this->db->get()->row();
        $html = '<table class="table table-bordered">
                    <tr>
                        <td>Bukti</td>
                        <td><img src="'.base_url('assets/bukti_pembayaran/').$data->bukti.'" width="100%"></td>
                    </tr>
                    <tr>
                        <td>Kode</td>
                        <td>('.$data->kode.') '.$data->deskripsi_kode.'</td>
                    </tr>
                    <tr>
                        <td>Sub Kode</td>
                        <td>('.$data->sub_kode.') '.$data->deskripsi_sub_kode.'</td>
                    </tr>
                    <tr>
                        <td>Title Kode</td>
                        <td>('.$data->kode_title.') '.$data->deskripsi.'</td>
                    </tr>
                <table>';
        echo $html;
    }

    public function approve_pemasukan_lain(){
        $id = $_POST['id'];
        $data = $this->db->get_where('pemasukan_lain',['id_pemasukan' => $id])->row();
        $title_kode = $data->title_kode;
        $jml = $data->jumlah;
        $id_perum = $data->id_perumahan;
        $this->db->set('status',2)->where('id_pemasukan', $id)->update('pemasukan_lain');
        if($this->db->affected_rows() > 0){
            $this->toHistoryApprove($title_kode, $jml, $id_perum);
            $params = ['msg' => 'Berhasil di Approve'];
        } else {
           $params = ['msg' => 'Gagal Approve'];
        }
        echo json_encode($params);
    }

    public function reject_pemasukan_lain(){
        $id = $_POST['id'];
        $this->db->set('status',0)->where('id_pemasukan', $id)->update('pemasukan_lain');
        if($this->db->affected_rows() > 0){
            $params = ['msg' => 'Berhasil di tolak'];
        } else {
            $params = ['msg' => 'Gagal di tolak'];
        }
        echo json_encode($params);
    }

    public function delete_pemasukan_lain(){
        $id = $_POST['id'];
        if($this->db->delete('pemasukan_lain',['id_pemasukan' => $id])){
            $params = [
                'success' => true,
                'msg' => 'Pemasukan lain berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Pemasukan lain gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function edit_pemasukan_lain(){
        $id = $_POST['id_pemasukan'];
        $pemasukan = $this->db->get_where('pemasukan_lain',['id_pemasukan' => $id])->row();

        $bukti = $_FILES['bukti'];
        if($bukti){
            $config['upload_path']          = './assets/bukti_pembayaran/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            if($this->upload->do_upload('bukti')){
                $img = $this->upload->data('file_name');
            } else {
                $img = $pemasukan->bukti;
            }

            $data = [
                'keterangan' => $_POST['ket'],
                'jumlah' => $_POST['jumlah'],
                'tanggal' => date('Y-m-d'),
                'bukti' => $img,
                'status' => 1,
                'title_kode' => $_POST['title_kode'],
                'id_perumahan' => $this->session->userdata('id_perumahan')
            ];
            $this->db->where('id_pemasukan', $id)->update('pemasukan_lain', $data);
            if($this->db->affected_rows() > 0){
                $params = [
                    'success' => true,
                    'msg' => 'Pemasukan berhasil di Edit'
                ];
            } else {
                $params = [
                    'success' => false,
                    'msg' => 'Pemasukan gagal di Edit'
                ];
            }
        }
        echo json_encode($params);
    }

    public function get_pemasukan_id(){
        $id = $_POST['id'];
        $data = $this->db->get_where('pemasukan_lain',['id_pemasukan' => $id])->row();
        echo json_encode($data);
    }


}