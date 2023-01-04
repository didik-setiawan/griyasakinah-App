<?php
defined('BASEPATH')or exit('No direct script access allowed');
class Marketing extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(masterModel());
        checkLoginGagal();
    }

    public function data_konsumen(){
        $data['calon_konsumen'] = $this->db->order_by('nama_konsumen','ASC')->get_where('tbl_marketing',['status' => 1])->result();
        $data['perum'] = $this->db->get('tbl_perumahan')->result();
        $this->template->load('template', 'marketing/data_konsumen', $data);
    }

    public function add_calon_konsumen(){
        $post = $this->input->post(null, TRUE);
        $cek_nohp = $this->db->get_where('tbl_marketing' ,['no_hp' => $post['no_hp']])->num_rows();
        
        if(empty($post['nama'])){
            $params = array("success" => false, "status" => 1);
        } elseif(empty($post['no_hp'])){
            $params = array("success" => false, "status" => 2);
        } elseif(empty($post['pekerjaan'])) {
            $params = array("success" => false, "status" => 3);
        } elseif(empty($post['jk'])) {
            $params = array("success" => false, "status" => 4);
        } elseif(empty($post['info'])) {
            $params = array("success" => false, "status" => 5);
        }
        elseif($cek_nohp > 0) {
            $params = array("success" => false, "status" => 6);
        }
        else {
            $data = [
                'nama_konsumen' => $_POST['nama'],
                'no_hp' => $_POST['no_hp'],
                'jk' => $_POST['jk'],
                'pekerjaan' => $_POST['pekerjaan'],
                'dapat_info' => $_POST['info'],
                'status' => 1
            ];

            $this->db->insert('tbl_marketing', $data);

            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
        }
        echo json_encode($params);
    }

    public function edit_calon_konsumen(){
        $post = $this->input->post(null, TRUE);
        
        if(empty($post['nama'])){
            $params = array("success" => false, "status" => 1);
        } elseif(empty($post['no_hp'])){
            $params = array("success" => false, "status" => 2);
        } elseif(empty($post['pekerjaan'])) {
            $params = array("success" => false, "status" => 3);
        } elseif(empty($post['jk'])) {
            $params = array("success" => false, "status" => 4);
        } elseif(empty($post['info'])) {
            $params = array("success" => false, "status" => 5);
        } else {
            $data = [
                'nama_konsumen' => $_POST['nama'],
                'no_hp' => $_POST['no_hp'],
                'jk' => $_POST['jk'],
                'pekerjaan' => $_POST['pekerjaan'],
                'dapat_info' => $_POST['info'],
            ];

            $id = $_POST['id'];

            $this->db->where('id_marketing', $id)->update('tbl_marketing', $data);
            if($this->db->affected_rows() > 0) {
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }
        }
        echo json_encode($params);
    }

    public function del_calon_konsumen(){
        $id = $_POST['id'];
        $this->db->delete('tbl_marketing',['id_marketing' => $id]);
        if($this->db->affected_rows() > 0) {
            $params = array("success" => true);
        } else {
            $params = array("success" => false);
        }
        echo json_encode($params);
    }

    public function get_data_calon_id(){
        $id = $_POST['id'];
        $q = $this->db->get_where('tbl_marketing',['id_marketing' => $id])->row();
        echo json_encode($q);
    }

    public function get_kavling_select(){
        $id = $_POST['id'];
        $kavling = $this->db->order_by('blok','ASC')->get_where('tbl_kavling',['id_perum' => $id , 'status' => 0])->result();
        echo "<option value='' selected>--Pilih--</option>";
        foreach ($kavling as $k) {
        echo "<option value=".$k->id_kavling." data-harga=".$k->harga.">".$k->blok." (Tipe: ".$k->tipe.") (Luas :".$k->panjang." X ".$k->lebar." m) (Harga: Rp. ".number_format($k->harga).") </option>";
        }
    }

    public function get_harga_kavling(){
        $id = $_POST['id'];
        $harga = $this->db->get_where('tbl_kavling',['id_kavling' => $id])->row();
        echo json_encode($harga);
    }


    public function get_kavling_by_cluster(){
        $id_cluster = $_POST['cluster'];
        $kavling = $this->db->get_where('tbl_kavling',['id_cluster' => $id_cluster, 'status_kavling' => 0])->result();
        echo json_encode($kavling);
    }


    //transaksi bank
    public function transaksi_bank(){
        $id_perumahan = $this->session->userdata('id_perumahan');

        $data['rumah'] = $this->db->order_by('blok','ASC')->get_where('tbl_kavling',['id_perum' => $id_perumahan, 'status_kavling' => 0])->result();
        $data['cluster'] = $this->db->get_where('tbl_cluster',['id_perum' => $id_perumahan])->result();
        $data['calon_konsumen'] = $this->db->get_where('tbl_marketing',['status' => 1])->result();
        
        $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling WHERE tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_kavling.id_perum = $id_perumahan AND tbl_marketing.status != 0 AND tbl_marketing.status != 3 AND tbl_marketing.status != 1";
        $data['konsumen_tf_bank'] = $this->db->query($q)->result();
        $data['kavling'] = $this->master_model->get_kavling_join_perum();
        $this->template->load('template', 'marketing/transaksi_bank', $data);
    }

    public function get_blok_id(){
        $id = $_POST['id'];
        // $output = $this->db->get_where('tbl_kavling',['id_kavling' => $id])->row();
        $q = "SELECT * FROM tbl_kavling JOIN tbl_tipe ON tbl_kavling.id_tipe = tbl_tipe.id_tipe WHERE tbl_kavling.id_kavling = $id";
        $output = $this->db->query($q)->row();
        echo json_encode($output);
    }

    public function add_transaksi_bank(){
        $post = $this->input->post(null, TRUE);
        $id_perumahan = $this->session->userdata('id_perumahan');

        $cek_email = $this->db->get_where('tbl_marketing',['email' => $post['email']])->num_rows();
        $cek_email2 = $this->db->get_where('tbl_pasangan',['email' => $post['email']])->num_rows();

        $cek_nik = $this->db->get_where('tbl_marketing',['nik' => $post['nik']])->num_rows();
        $cek_nik2 = $this->db->get_where('tbl_pasangan',['nik' => $post['nik']])->num_rows();

        $cek_telp = $this->db->get_where('tbl_marketing',['no_hp' => $post['nohp_p']])->num_rows();
        $cek_telp2 = $this->db->get_where('tbl_pasangan',['no_hp' => $post['nohp_p']])->num_rows();
    
        $cek_email_p = $this->db->get_where('tbl_marketing',['email' => $post['email_p']])->num_rows();
        $cek_email2_p = $this->db->get_where('tbl_pasangan',['email' => $post['email_p']])->num_rows();
    
        $cek_nik_p = $this->db->get_where('tbl_marketing',['nik' => $post['nik_p']])->num_rows();
        $cek_nik2_p = $this->db->get_where('tbl_pasangan',['nik' => $post['nik_p']])->num_rows();

        if(empty($post['nik'])){
            $params = array("success" => false, "status" => 1);
        } 
        elseif($cek_nik > 0){
            $params = array("success" => false, "status" => 21);
        }
        elseif($cek_nik2 > 0){
            $params = array("success" => false, "status" => 21);
        }
        elseif(empty($post['tempat_kerja'])){
            $params = array("success" => false, "status" => 18);
        }
        elseif(empty($post['gaji'])){
            $params = array("success" => false, "status" => 19);
        }
        elseif(empty($post['email'])){
            $params = array("success" => false, "status" => 20);
        }
        elseif($cek_email > 0){
            $params = array("success" => false, "status" => 22);
        }
        elseif($cek_email2 > 0){
            $params = array("success" => false, "status" => 22);
        }
        elseif(empty($post['alamat'])){
            $params = array("success" => false, "status" => 2);
        } elseif(empty($post['status_menikah'])){
            $params = array("success" => false, "status" => 3);
        } elseif(empty($post['rumah'])){
            $params = array("success" => false, "status" => 4);
        } elseif(empty($post['harga_kesepakatan'])){
            $params = array("success" => false, "status" => 5);
        } elseif(empty($post['tanda_jadi'])){
            $params = array("success" => false, "status" => 6);
        } elseif(empty($post['tgl_tanda_jadi'])){
            $params = array("success" => false, "status" => 7);
        }
        elseif($post['cicil_angsur_tj'] == '' & $post['tempo_tj'] != ''){
            $params = array("success" => false, "status" => 8);
        }
        elseif($post['cicil_angsur_tj'] != '' & $post['tempo_tj'] == ''){
            $params = array("success" => false, "status" => 9);
        }
        elseif($post['cicil_angsur_um'] == '' & $post['tempo_um'] != ''){
            $params = array("success" => false, "status" => 10);
        }
        elseif($post['cicil_angsur_um'] != '' & $post['tempo_um'] == ''){
            $params = array("success" => false, "status" => 11);
        }
        elseif($post['cicil_angsur_kt'] == '' & $post['tempo_kt'] != ''){
            $params = array("success" => false, "status" => 12);
        }
        elseif($post['cicil_angsur_kt'] != '' & $post['tempo_kt'] == ''){
            $params = array("success" => false, "status" => 13);
        }
        elseif($post['cicil_angsur_pak'] == '' & $post['tempo_pak'] != ''){
            $params = array("success" => false, "status" => 14);
        }
        elseif($post['cicil_angsur_pak'] != '' & $post['tempo_pak'] == ''){
            $params = array("success" => false, "status" => 15);
        }
        elseif($post['cicil_angsur_lain'] == '' & $post['tempo_lain'] != ''){
            $params = array("success" => false, "status" => 16);
        }
        elseif($post['cicil_angsur_lain'] != '' & $post['tempo_lain'] == ''){
            $params = array("success" => false, "status" => 17);
        }

        elseif($post['cicil_piutang'] == '' & $post['tempo_piutang'] != ''){
            $params = array("success" => false, "status" => 91);
        }
        elseif($post['cicil_piutang'] != '' & $post['tempo_piutang'] == ''){
            $params = array("success" => false, "status" => 92);
        }

        elseif($post['cicil_angsuran'] == '' & $post['tempo_angsuran'] != ''){
            $params = array("success" => false, "status" => 93);
        }
        elseif($post['cicil_angsuran'] != '' & $post['tempo_angsuran'] == ''){
            $params = array("success" => false, "status" => 94);
        }

        //data pasangan
       
        elseif($post['status_menikah'] == 'Sudah' & $post['nik_p'] == ''){
            $params = array("success" => false, "status" => 30);
        }
        else if($post['status_menikah'] == 'Sudah' & $post['nama_p'] == ''){
            $params = array("success" => false, "status" => 31);
        }
        else if($post['status_menikah'] == 'Sudah' & $post['nohp_p'] == ''){
            $params = array("success" => false, "status" => 32);
        }
        else if($post['status_menikah'] == 'Sudah' & $post['email_p'] == ''){
            $params = array("success" => false, "status" => 33);
        }
        else if($post['status_menikah'] == 'Sudah' & $post['jk_p'] == ''){
            $params = array("success" => false, "status" => 34);
        }
        else if($post['status_menikah'] == 'Sudah' & $post['pekerjaan_p'] == ''){
            $params = array("success" => false, "status" => 35);
        }
        else if($post['status_menikah'] == 'Sudah' & $post['tk_p'] == ''){
            $params = array("success" => false, "status" => 36);
        }
        else if($post['status_menikah'] == 'Sudah' & $post['gaji_p'] == ''){
            $params = array("success" => false, "status" => 37);
        }
       
        else {

            if($post['status_menikah'] == 'Sudah'){

                if($cek_nik_p > 0){
                    $params = array("success" => false, "status" => 38);
                }
                elseif($cek_nik2_p > 0){
                    $params = array("success" => false, "status" => 38);
                }
                elseif($cek_email_p > 0){
                    $params = array("success" => false, "status" => 39);
                }
                elseif($cek_email2_p > 0){
                    $params = array("success" => false, "status" => 39);
                }
                elseif($cek_telp > 0){
                    $params = array("success" => false, "status" => 40);
                }
                elseif($cek_telp2 > 0){
                    $params = array("success" => false, "status" => 40);
                }
                     else {
                // input data pasangan
                $data_pasangan = [
                    'id_marketing' => $post['id_konsumen'],
                    'nik' => $post['nik_p'],
                    'nama' => $post['nama_p'],
                    'no_hp' => $post['nohp_p'],
                    'email' => $post['email_p'],
                    'jk' => $post['jk_p'],
                    'pekerjaan' => $post['pekerjaan_p'],
                    'tempat_kerja' => $post['tk_p'],
                    'gaji' => $post['gaji_p']
                ];
                $this->db->insert('tbl_pasangan', $data_pasangan);
                    }
            }
            
            

            $data = [
                'nik' => $post['nik'],
                'tempat_kerja' => $post['tempat_kerja'],
                'gaji' => $post['gaji'],
                'email' => $post['email'],
                'alamat' => $post['alamat'],
                'status_menikah' => $post['status_menikah'],
            ];
            $id_konsumen = $post['id_konsumen'];
            if($this->db->where('id_marketing', $id_konsumen)->update('tbl_marketing', $data)){
                $data = [
                    'id_konsumen' => $id_konsumen,
                    'id_rumah' => $post['rumah'],
                    'harga_kesepakatan' => $post['harga_kesepakatan'],
                    'tanda_jadi' => $post['tanda_jadi'],
                    'tgl_tanda_jadi' => $post['tgl_tanda_jadi']
                ];

                if($this->db->insert('tbl_transaksi_bank', $data)){

                    //input tanda jadi lokasi
                    if($post['tempo_tj'] >= date("d")){
                        $angsur_tjl = $post['angsur_tj'] - 1;
                        for($i =0; $i<=$angsur_tjl; $i++){
                            $date = mktime(0,0,0, date("m")+$i, date($post['tempo_tj']), date("Y"));
                            $date = date("Y-m-d", $date);
    
                            $data = [
                                'id_konsumen' => $id_konsumen,
                                'jml_tjl' => $post['tanda_jadi_lokasi'],
                                'angsuran' => $post['angsur_tj'],
                                'cicilan_angsuran' => $post['cicil_angsur_tj'],
                                'tgl_bayar' => $post['tempo_tj'],
                                'status' => 0,
                                'jatuh_tempo' => $date,
                                'id_perumahan' => $id_perumahan,
                                'denda' => 0
                            ];
                            $this->db->insert('tanda_jadi_lokasi', $data);
                        }
                    } else if($post['tempo_tj'] < date("d")) {
                        $angsur_tjl = $post['angsur_tj'];
                        for($i =1; $i<=$angsur_tjl; $i++){
                            $date = mktime(0,0,0, date("m")+$i, date($post['tempo_tj']), date("Y"));
                            $date = date("Y-m-d", $date);
    
                            $data = [
                                'id_konsumen' => $id_konsumen,
                                'jml_tjl' => $post['tanda_jadi_lokasi'],
                                'angsuran' => $post['angsur_tj'],
                                'cicilan_angsuran' => $post['cicil_angsur_tj'],
                                'tgl_bayar' => $post['tempo_tj'],
                                'status' => 0,
                                'jatuh_tempo' => $date,
                                'id_perumahan' => $id_perumahan,
                                'denda' => 0
                            ];
                            $this->db->insert('tanda_jadi_lokasi', $data);
                        }
                    }

                    //input uang muka
                    if($post['tempo_tj'] >= date("d")){
                        $angsur_um = $post['angsur_um'] - 1;
                        for($i =0; $i<=$angsur_um; $i++){
                            $date = mktime(0,0,0, date("m")+$i, date($post['tempo_um']), date("Y"));
                            $date = date("Y-m-d", $date);
    
                            $data = [
                                'id_konsumen' => $id_konsumen,
                                'jml_um' => $post['uang_muka'],
                                'angsuran' => $post['angsur_um'],
                                'cicilan_angsuran' => $post['cicil_angsur_um'],
                                'tgl_bayar' => $post['tempo_um'],
                                'status' => 0,
                                'jatuh_tempo' => $date,
                                'id_perumahan' => $id_perumahan,
                                'denda' => 0
                            ];
                            $this->db->insert('uang_muka', $data);
                        }
                    } else if($post['tempo_tj'] < date("d")){
                        $angsur_um = $post['angsur_um'];
                        for($i =1; $i<=$angsur_um; $i++){
                            $date = mktime(0,0,0, date("m")+$i, date($post['tempo_um']), date("Y"));
                            $date = date("Y-m-d", $date);
    
                            $data = [
                                'id_konsumen' => $id_konsumen,
                                'jml_um' => $post['uang_muka'],
                                'angsuran' => $post['angsur_um'],
                                'cicilan_angsuran' => $post['cicil_angsur_um'],
                                'tgl_bayar' => $post['tempo_um'],
                                'status' => 0,
                                'jatuh_tempo' => $date,
                                'id_perumahan' => $id_perumahan,
                                'denda' => 0
                            ];
                            $this->db->insert('uang_muka', $data);
                        }
                    }

                    //input kelebihan tanah

                    if($post['tempo_kt'] >= date("d")){
                        $angsur_kt = $post['angsur_kt'] - 1;
                        for($i =0; $i<=$angsur_kt; $i++){
                            $date = mktime(0,0,0, date("m")+$i, date($post['tempo_kt']), date("Y"));
                            $date = date("Y-m-d", $date);
    
                            $data = [
                                'id_konsumen' => $id_konsumen,
                                'jml_kt' => $post['kelebihan_tanah'],
                                'angsuran' => $post['angsur_kt'],
                                'cicilan_angsuran' => $post['cicil_angsur_kt'],
                                'tgl_bayar' => $post['tempo_kt'],
                                'status' => 0,
                                'jatuh_tempo' => $date,
                                'id_perumahan' => $id_perumahan,
                                'denda' => 0
                            ];
                            $this->db->insert('kelebihan_tanah', $data);
                        }
                    } else if($post['tempo_kt'] < date("d")) {
                        $angsur_kt = $post['angsur_kt'];
                        for($i =1; $i<=$angsur_kt; $i++){
                            $date = mktime(0,0,0, date("m")+$i, date($post['tempo_kt']), date("Y"));
                            $date = date("Y-m-d", $date);
    
                            $data = [
                                'id_konsumen' => $id_konsumen,
                                'jml_kt' => $post['kelebihan_tanah'],
                                'angsuran' => $post['angsur_kt'],
                                'cicilan_angsuran' => $post['cicil_angsur_kt'],
                                'tgl_bayar' => $post['tempo_kt'],
                                'status' => 0,
                                'jatuh_tempo' => $date,
                                'id_perumahan' => $id_perumahan,
                                'denda' => 0
                            ];
                            $this->db->insert('kelebihan_tanah', $data);
                        }
                    }

                    
                    //insert pak
                    if($post['tempo_pak'] >= date("d")){
                        $angsur_pak = $post['angsur_pak'] - 1;
                        for($i =0; $i<=$angsur_pak; $i++){
                            $date = mktime(0,0,0, date("m")+$i, date($post['tempo_pak']), date("Y"));
                            $date = date("Y-m-d", $date);
    
                            $data = [
                                'id_konsumen' => $id_konsumen,
                                'jml_pak' => $post['pak'],
                                'angsuran' => $post['angsur_pak'],
                                'cicilan_angsuran' => $post['cicil_angsur_pak'],
                                'tgl_bayar' => $post['tempo_pak'],
                                'status' => 0,
                                'jatuh_tempo' => $date,
                                'id_perumahan' => $id_perumahan,
                                'denda' => 0
                            ];
                            $this->db->insert('pak', $data);
                        }
                    } else if($post['tempo_pak'] < date("d")){
                        $angsur_pak = $post['angsur_pak'];
                        for($i =1; $i<=$angsur_pak; $i++){
                            $date = mktime(0,0,0, date("m")+$i, date($post['tempo_pak']), date("Y"));
                            $date = date("Y-m-d", $date);
    
                            $data = [
                                'id_konsumen' => $id_konsumen,
                                'jml_pak' => $post['pak'],
                                'angsuran' => $post['angsur_pak'],
                                'cicilan_angsuran' => $post['cicil_angsur_pak'],
                                'tgl_bayar' => $post['tempo_pak'],
                                'status' => 0,
                                'jatuh_tempo' => $date,
                                'id_perumahan' => $id_perumahan,
                                'denda' => 0
                            ];
                            $this->db->insert('pak', $data);
                        }
                    }

                    //insert lain-lain
                    if($post['tempo_lain'] >= date("d")){
                        $angsur_lain = $post['angsur_lain'] - 1;
                        for($i =0; $i<=$angsur_lain; $i++){
                            $date = mktime(0,0,0, date("m")+$i, date($post['tempo_lain']), date("Y"));
                            $date = date("Y-m-d", $date);
    
                            $data = [
                                'id_konsumen' => $id_konsumen,
                                'jml_lain' => $post['lain'],
                                'angsuran' => $post['angsur_lain'],
                                'cicilan_angsuran' => $post['cicil_angsur_lain'],
                                'tgl_bayar' => $post['tempo_lain'],
                                'status' => 0,
                                'jatuh_tempo' => $date,
                                'id_perumahan' => $id_perumahan,
                                'denda' => 0
                            ];
                            $this->db->insert('lain_lain', $data);
                        }
                    } else if($post['tempo_lain'] < date("d")){
                        $angsur_lain = $post['angsur_lain'];
                        for($i =1; $i<=$angsur_lain; $i++){
                            $date = mktime(0,0,0, date("m")+$i, date($post['tempo_lain']), date("Y"));
                            $date = date("Y-m-d", $date);
    
                            $data = [
                                'id_konsumen' => $id_konsumen,
                                'jml_lain' => $post['lain'],
                                'angsuran' => $post['angsur_lain'],
                                'cicilan_angsuran' => $post['cicil_angsur_lain'],
                                'tgl_bayar' => $post['tempo_lain'],
                                'status' => 0,
                                'jatuh_tempo' => $date,
                                'id_perumahan' => $id_perumahan,
                                'denda' => 0
                            ];
                            $this->db->insert('lain_lain', $data);
                        }
                    }


                    //insert piutang bank
                    if($post['tempo_piutang'] >= date("d")){
                        $angsur_piutang = $post['angsur_piutang'] - 1;
                        for($i =0; $i<=$angsur_piutang; $i++){
                            $date = mktime(0,0,0, date("m")+$i, date($post['angsur_piutang']), date("Y"));
                            $date = date("Y-m-d", $date);
    
                            $data = [
                                'id_konsumen' => $id_konsumen,
                                'jml_piutang' => $post['piutang_bank'],
                                'angsuran' => $post['angsur_piutang'],
                                'cicilan_angsuran' => $post['cicil_piutang'],
                                'tgl_bayar' => $post['tempo_piutang'],
                                'status' => 0,
                                'jatuh_tempo' => $date,
                                'id_perumahan' => $id_perumahan,
                                'denda' => 0
                            ];
                            $this->db->insert('piutang_bank', $data);
                        }
                    } else if($post['tempo_piutang'] < date("d")){
                        $angsur_piutang = $post['angsur_piutang'];
                        for($i =1; $i<=$angsur_piutang; $i++){
                            $date = mktime(0,0,0, date("m")+$i, date($post['angsur_piutang']), date("Y"));
                            $date = date("Y-m-d", $date);
    
                            $data = [
                                'id_konsumen' => $id_konsumen,
                                'jml_piutang' => $post['piutang_bank'],
                                'angsuran' => $post['angsur_piutang'],
                                'cicilan_angsuran' => $post['cicil_piutang'],
                                'tgl_bayar' => $post['tempo_piutang'],
                                'status' => 0,
                                'jatuh_tempo' => $date,
                                'id_perumahan' => $id_perumahan,
                                'denda' => 0
                            ];
                            $this->db->insert('piutang_bank', $data);
                        }
                    }


                    //insert angsuran bank
                    if($post['tempo_angsuran'] >= date("d")){
                        $angsur_bank = $post['agsur_angsuran'] - 1;
                        for($i =0; $i<=$angsur_bank; $i++){
                            $date = mktime(0,0,0, date("m")+$i, date($post['tempo_angsuran']), date("Y"));
                            $date = date("Y-m-d", $date);
    
                            $data = [
                                'id_konsumen' => $id_konsumen,
                                'jml_angsur' => $post['angsur_bank'],
                                'angsuran' => $post['agsur_angsuran'],
                                'cicilan_angsuran' => $post['cicil_angsuran'],
                                'tgl_bayar' => $post['tempo_angsuran'],
                                'status' => 0,
                                'jatuh_tempo' => $date,
                                'id_perumahan' => $id_perumahan,
                                'denda' => 0
                            ];
                            $this->db->insert('angsuran_bank', $data);
                        }
                    } else if($post['tempo_angsuran'] < date("d")){
                        $angsur_bank = $post['agsur_angsuran'];
                        for($i =1; $i<=$angsur_bank; $i++){
                            $date = mktime(0,0,0, date("m")+$i, date($post['tempo_angsuran']), date("Y"));
                            $date = date("Y-m-d", $date);
    
                            $data = [
                                'id_konsumen' => $id_konsumen,
                                'jml_angsur' => $post['angsur_bank'],
                                'angsuran' => $post['agsur_angsuran'],
                                'cicilan_angsuran' => $post['cicil_angsuran'],
                                'tgl_bayar' => $post['tempo_angsuran'],
                                'status' => 0,
                                'jatuh_tempo' => $date,
                                'id_perumahan' => $id_perumahan,
                                'denda' => 0
                            ];
                            $this->db->insert('angsuran_bank', $data);
                        }
                    }


                    //input data pasangan 

                    


                    $this->db->set('status', 2)->where('id_marketing', $id_konsumen)->update('tbl_marketing');
                    $this->db->set('status_kavling', 1)->where('id_kavling', $post['rumah'])->update('tbl_kavling');


                    $params = array("success" => true);
                } else {

                    $params = array("success" => false);
                }
            } else  {
            }

        }
            
        
            
        echo json_encode($params);
    }


    public function edit_transaksi_bank(){
        $post = $this->input->post(null, TRUE);
        $id_konsumen = $post['id_konsumen'];
        // $piutang = $this->db->get_where('piutang_bank',['id_konsumen' => $id_konsumen])->row();
        

        //validasi data konsumen
        if(empty($post['nik'])){
            $params = array("success" => false, "status" => 1);
        }
        else if(empty($post['nama'])){
            $params = array("success" => false, "status" => 2);
        }
        else if(empty($post['jk'])){
            $params = array("success" => false, "status" => 3);
        }
        else if(empty($post['no_hp'])){
            $params = array("success" => false, "status" => 4);
        }
        else if(empty($post['pekerjaan'])){
            $params = array("success" => false, "status" => 5);
        }
        else if(empty($post['alamat'])){
            $params = array("success" => false, "status" => 6);
        }
        else if(empty($post['email'])){
            $params = array("success" => false, "status" => 7);
        }
        else if(empty($post['status_menikah'])){
            $params = array("success" => false, "status" => 8);
        }
        else if(empty($post['tempat_kerja'])){
            $params = array("success" => false, "status" => 9);
        }
        else if(empty($post['gaji'])){
            $params = array("success" => false, "status" => 10);
        }
        else if(empty($post['info'])){
            $params = array("success" => false, "status" => 11);
        }

        //validasi data bank
        else if(empty($post['harga_kesepakatan'])){
            $params = array("success" => false, "status" => 12);
        }
        else if(empty($post['tanda_jadi'])){
            $params = array("success" => false, "status" => 13);
        }
        else if(empty($post['tgl_tanda_jadi'])){
            $params = array("success" => false, "status" => 14);
        }

        //tanda jadi lokasi
        elseif($post['tjl_angsuran'] == '' & $post['tjl_tgl_bayar'] != ''){
            $params = array("success" => false, "status" => 15);
        }
        elseif($post['tjl_angsuran'] != '' & $post['tjl_tgl_bayar'] == ''){
            $params = array("success" => false, "status" => 16);
        }
        
        //uang muka
        elseif($post['um_angsuran'] == '' & $post['um_tgl_bayar'] != ''){
            $params = array("success" => false, "status" => 17);
        }
        elseif($post['um_angsuran'] != '' & $post['um_tgl_bayar'] == ''){
            $params = array("success" => false, "status" => 18);
        }

        //kelebihan tanah
        elseif($post['kt_angsuran'] == '' & $post['kt_tgl_bayar'] != ''){
            $params = array("success" => false, "status" => 19);
        }
        elseif($post['kt_angsuran'] != '' & $post['kt_tgl_bayar'] == ''){
            $params = array("success" => false, "status" => 20);
        }

        //PAK
        elseif($post['pak_angsuran'] == '' & $post['pak_tgl_bayar'] != ''){
            $params = array("success" => false, "status" => 21);
        }
        elseif($post['pak_angsuran'] != '' & $post['pak_tgl_bayar'] == ''){
            $params = array("success" => false, "status" => 22);
        }

        //lain-lain
        elseif($post['lain_angsuran'] == '' & $post['lain_tgl_bayar'] != ''){
            $params = array("success" => false, "status" => 23);
        }
        elseif($post['lain_angsuran'] != '' & $post['lain_tgl_bayar'] == ''){
            $params = array("success" => false, "status" => 24);
        } 

        elseif($post['cicil_piutang'] == '' & $post['tempo_piutang'] != ''){
            $params = array("success" => false, "status" => 91);
        }
        elseif($post['cicil_piutang'] != '' & $post['tempo_piutang'] == ''){
            $params = array("success" => false, "status" => 92);
        }

        elseif($post['cicil_angsuran'] == '' & $post['tempo_angsuran'] != ''){
            $params = array("success" => false, "status" => 93);
        }
        elseif($post['cicil_angsuran'] != '' & $post['tempo_angsuran'] == ''){
            $params = array("success" => false, "status" => 94);
        }

        //data pasangan
        elseif($post['status_menikah'] == 'Sudah' & $post['nik_pe'] == ''){
            $params = array("success" => false, "status" => 30);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['nama_pe'] == ''){
            $params = array("success" => false, "status" => 31);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['nohp_pe'] == ''){
            $params = array("success" => false, "status" => 32);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['email_pe'] == ''){
            $params = array("success" => false, "status" => 33);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['jk_pe'] == ''){
            $params = array("success" => false, "status" => 34);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['pekerjaan_pe'] == ''){
            $params = array("success" => false, "status" => 35);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['tk_pe'] == ''){
            $params = array("success" => false, "status" => 36);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['gaji_pe'] == ''){
            $params = array("success" => false, "status" => 37);
        }
        else {
            $id_konsumen = $post['id_konsumen'];

                    if($post['status_menikah'] == 'Sudah'){
                        $cek_pasangan = $this->db->get_where('tbl_pasangan',['id_marketing' => $id_konsumen])->row();
                        if($cek_pasangan){
                            // edit data pasangan
                            $data_pasangan = [
                                'nik' => $post['nik_pe'],
                                'nama' => $post['nama_pe'],
                                'no_hp' => $post['nohp_pe'],
                                'email' => $post['email_pe'],
                                'jk' => $post['jk_pe'],
                                'pekerjaan' => $post['pekerjaan_pe'],
                                'tempat_kerja' => $post['tk_pe'],
                                'gaji' => $post['gaji_pe']
                            ];
                            $this->db->where('id_marketing', $id_konsumen)->update('tbl_pasangan', $data_pasangan);
                        } else {

                            // add data pasangan
                            $data_pasangan = [
                                'id_marketing' => $post['id_konsumen'],
                                'nik' => $post['nik_pe'],
                                'nama' => $post['nama_pe'],
                                'no_hp' => $post['nohp_pe'],
                                'email' => $post['email_pe'],
                                'jk' => $post['jk_pe'],
                                'pekerjaan' => $post['pekerjaan_pe'],
                                'tempat_kerja' => $post['tk_pe'],
                                'gaji' => $post['gaji_pe']
                            ];
                            $this->db->insert('tbl_pasangan', $data_pasangan);
                        }
                    } else {
                        $this->db->delete('tbl_pasangan',['id_marketing'=>$id_konsumen]);
                    }

            //update data konsumen
            $data_konsumen = [
                'nik' => $post['nik'],
                'nama_konsumen' => $post['nama'],
                'jk' => $post['jk'],
                'no_hp' => $post['no_hp'],
                'pekerjaan' => $post['pekerjaan'],
                'alamat' => $post['alamat'],
                'email' => $post['email'],
                'status_menikah' => $post['status_menikah'],
                'tempat_kerja' => $post['tempat_kerja'],
                'gaji' => $post['gaji'],
                'dapat_info' => $post['info']
            ];
            if($this->db->where('id_marketing', $id_konsumen)->update('tbl_marketing', $data_konsumen)){
                // $params = array("success" => true);

                //update data bank
                $data_bank = [
                    'harga_kesepakatan' => $post['harga_kesepakatan'],
                    'tanda_jadi' => $post['tanda_jadi'],
                    'tgl_tanda_jadi' => $post['tgl_tanda_jadi']
                ];
                if($this->db->where('id_konsumen', $id_konsumen)->update('tbl_transaksi_bank', $data_bank)){

                
                    //update angsuran bank
                    $pb = $this->db->get_where('angsuran_bank',['id_konsumen' => $id_konsumen])->row();
                    if($pb == null){
                        if($post['tempo_angsuran'] >= date("d")){
                                $pb_angsur = $post['agsur_angsuran'] - 1;
                                for($i =0; $i<=$pb_angsur; $i++){
                                    $date = mktime(0,0,0, date("m")+$i, date($post['tempo_angsuran']), date("Y"));
                                    $date = date("Y-m-d", $date);
            
                                    $data = [
                                        'id_konsumen' => $id_konsumen,
                                        'jml_angsur' => $post['angsur_bank'],
                                        'angsuran' => $post['agsur_angsuran'],
                                        'cicilan_angsuran' => $post['cicil_angsuran'],
                                        'tgl_bayar' => $post['tempo_angsuran'],
                                        'status' => 0,
                                        'jatuh_tempo' => $date
                                    ];
                                    $this->db->insert('angsuran_bank', $data);
                                }
                            } else if($post['tempo_angsuran'] < date("d")) {
                                $pb_angsur = $post['agsur_angsuran'];
                                for($i =1; $i<=$pb_angsur; $i++){
                                    $date = mktime(0,0,0, date("m")+$i, date($post['tempo_angsuran']), date("Y"));
                                    $date = date("Y-m-d", $date);
            
                                    $data = [
                                        'id_konsumen' => $id_konsumen,
                                        'jml_angsur' => $post['angsur_bank'],
                                        'angsuran' => $post['agsur_angsuran'],
                                        'cicilan_angsuran' => $post['cicil_angsuran'],
                                        'tgl_bayar' => $post['tempo_angsuran'],
                                        'status' => 0,
                                        'jatuh_tempo' => $date
                                    ];
                                    $this->db->insert('angsuran_bank', $data);
                                }
                            }
                    }
                    else if($post['angsur_bank'] == $pb->jml_angsur & $post['agsur_angsuran'] == $pb->angsuran & $post['tempo_angsuran'] == $pb->tgl_bayar){
                        //return true
                    } else {
                        $this->db->delete('angsuran_bank',['id_konsumen' => $id_konsumen]);
                            if($post['tempo_angsuran'] >= date("d")){
                                $pb_angsur = $post['agsur_angsuran'] - 1;
                                for($i =0; $i<=$pb_angsur; $i++){
                                    $date = mktime(0,0,0, date("m")+$i, date($post['tempo_angsuran']), date("Y"));
                                    $date = date("Y-m-d", $date);
            
                                    $data = [
                                        'id_konsumen' => $id_konsumen,
                                        'jml_angsur' => $post['angsur_bank'],
                                        'angsuran' => $post['agsur_angsuran'],
                                        'cicilan_angsuran' => $post['cicil_angsuran'],
                                        'tgl_bayar' => $post['tempo_angsuran'],
                                        'status' => 0,
                                        'jatuh_tempo' => $date
                                    ];
                                    $this->db->insert('angsuran_bank', $data);
                                }
                            } else if($post['tempo_angsuran'] < date("d")) {
                                $pb_angsur = $post['agsur_angsuran'];
                                for($i =1; $i<=$pb_angsur; $i++){
                                    $date = mktime(0,0,0, date("m")+$i, date($post['tempo_angsuran']), date("Y"));
                                    $date = date("Y-m-d", $date);
            
                                    $data = [
                                        'id_konsumen' => $id_konsumen,
                                        'jml_angsur' => $post['angsur_bank'],
                                        'angsuran' => $post['agsur_angsuran'],
                                        'cicilan_angsuran' => $post['cicil_angsuran'],
                                        'tgl_bayar' => $post['tempo_angsuran'],
                                        'status' => 0,
                                        'jatuh_tempo' => $date
                                    ];
                                    $this->db->insert('angsuran_bank', $data);
                                }
                            }
                    }


                    //update piutang bank
                    $piutang = $this->db->get_where('piutang_bank',['id_konsumen' => $id_konsumen])->row();
                    if($piutang == null){
                        if($post['tempo_piutang'] >= date("d")){
                                $piutang_angsur = $post['angsur_piutang'] - 1;
                                for($i =0; $i<=$piutang_angsur; $i++){
                                    $date = mktime(0,0,0, date("m")+$i, date($post['tempo_piutang']), date("Y"));
                                    $date = date("Y-m-d", $date);
            
                                    $data = [
                                        'id_konsumen' => $id_konsumen,
                                        'jml_piutang' => $post['piutang_bank'],
                                        'angsuran' => $post['angsur_piutang'],
                                        'cicilan_angsuran' => $post['cicil_piutang'],
                                        'tgl_bayar' => $post['tempo_piutang'],
                                        'status' => 0,
                                        'jatuh_tempo' => $date
                                    ];
                                    $this->db->insert('piutang_bank', $data);
                                }
                            } else if($post['tempo_piutang'] < date("d")) {
                                $piutang_angsur = $post['angsur_piutang'];
                                for($i =1; $i<=$piutang_angsur; $i++){
                                    $date = mktime(0,0,0, date("m")+$i, date($post['tempo_piutang']), date("Y"));
                                    $date = date("Y-m-d", $date);
            
                                    $data = [
                                        'id_konsumen' => $id_konsumen,
                                        'jml_piutang' => $post['piutang_bank'],
                                        'angsuran' => $post['angsur_piutang'],
                                        'cicilan_angsuran' => $post['cicil_piutang'],
                                        'tgl_bayar' => $post['tempo_piutang'],
                                        'status' => 0,
                                        'jatuh_tempo' => $date
                                    ];
                                    $this->db->insert('piutang_bank', $data);
                                }
                            }
                    }
                    else if($post['piutang_bank'] == $piutang->jml_piutang & $post['angsur_piutang'] == $piutang->angsuran & $post['tempo_piutang'] == $piutang->tgl_bayar){
                        //return true
                    } else {
                        $this->db->delete('piutang_bank',['id_konsumen' => $id_konsumen]);
                            if($post['tempo_piutang'] >= date("d")){
                                $piutang_angsur = $post['angsur_piutang'] - 1;
                                for($i =0; $i<=$piutang_angsur; $i++){
                                    $date = mktime(0,0,0, date("m")+$i, date($post['tempo_piutang']), date("Y"));
                                    $date = date("Y-m-d", $date);
            
                                    $data = [
                                        'id_konsumen' => $id_konsumen,
                                        'jml_piutang' => $post['piutang_bank'],
                                        'angsuran' => $post['angsur_piutang'],
                                        'cicilan_angsuran' => $post['cicil_piutang'],
                                        'tgl_bayar' => $post['tempo_piutang'],
                                        'status' => 0,
                                        'jatuh_tempo' => $date
                                    ];
                                    $this->db->insert('piutang_bank', $data);
                                }
                            } else if($post['tempo_piutang'] < date("d")) {
                                $piutang_angsur = $post['angsur_piutang'];
                                for($i =1; $i<=$piutang_angsur; $i++){
                                    $date = mktime(0,0,0, date("m")+$i, date($post['tempo_piutang']), date("Y"));
                                    $date = date("Y-m-d", $date);
            
                                    $data = [
                                        'id_konsumen' => $id_konsumen,
                                        'jml_piutang' => $post['piutang_bank'],
                                        'angsuran' => $post['angsur_piutang'],
                                        'cicilan_angsuran' => $post['cicil_piutang'],
                                        'tgl_bayar' => $post['tempo_piutang'],
                                        'status' => 0,
                                        'jatuh_tempo' => $date
                                    ];
                                    $this->db->insert('piutang_bank', $data);
                                }
                            }
                    }

                    //update tanda jadi lokasi
                    $tjl = $this->db->get_where('tanda_jadi_lokasi',['id_konsumen' => $id_konsumen])->row();
                    if($tjl == null){
                        if($post['tjl_tgl_bayar'] >= date("d")){
                            $tjl_angsur = $post['tjl_angsur'] - 1;
                            for($i =0; $i<=$tjl_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['tjl_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_tjl' => $post['tjl'],
                                    'angsuran' => $post['tjl_angsur'],
                                    'cicilan_angsuran' => $post['tjl_angsuran'],
                                    'tgl_bayar' => $post['tjl_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('tanda_jadi_lokasi', $data);
                            }
                        } else if($post['tjl_tgl_bayar'] < date("d")) {
                            $tjl_angsur = $post['tjl_angsur'];
                            for($i =1; $i<=$tjl_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['tjl_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_tjl' => $post['tjl'],
                                    'angsuran' => $post['tjl_angsur'],
                                    'cicilan_angsuran' => $post['tjl_angsuran'],
                                    'tgl_bayar' => $post['tjl_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('tanda_jadi_lokasi', $data);
                            }
                        }
                    }
                    else if($post['tjl'] == $tjl->jml_tjl & $post['tjl_angsur'] == $tjl->angsuran & $post['tjl_tgl_bayar'] == $tjl->tgl_bayar){
                        //return true
                    } else {
                    $this->db->delete('tanda_jadi_lokasi',['id_konsumen' => $id_konsumen]);
                        if($post['tjl_tgl_bayar'] >= date("d")){
                            $tjl_angsur = $post['tjl_angsur'] - 1;
                            for($i =0; $i<=$tjl_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['tjl_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_tjl' => $post['tjl'],
                                    'angsuran' => $post['tjl_angsur'],
                                    'cicilan_angsuran' => $post['tjl_angsuran'],
                                    'tgl_bayar' => $post['tjl_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('tanda_jadi_lokasi', $data);
                            }
                        } else if($post['tjl_tgl_bayar'] < date("d")) {
                            $tjl_angsur = $post['tjl_angsur'];
                            for($i =1; $i<=$tjl_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['tjl_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_tjl' => $post['tjl'],
                                    'angsuran' => $post['tjl_angsur'],
                                    'cicilan_angsuran' => $post['tjl_angsuran'],
                                    'tgl_bayar' => $post['tjl_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('tanda_jadi_lokasi', $data);
                            }
                        }
                    }



                    //update uang muka
                    $um = $this->db->get_where('uang_muka',['id_konsumen' => $id_konsumen])->row();
                    if($um == null){
                        if($post['um_tgl_bayar'] >= date("d")){
                            $um_angsur = $post['um_angsur'] - 1;
                            for($i =0; $i<=$um_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['um_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_um' => $post['um'],
                                    'angsuran' => $post['um_angsur'],
                                    'cicilan_angsuran' => $post['um_angsuran'],
                                    'tgl_bayar' => $post['um_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('uang_muka', $data);
                            }
                        } else if($post['um_tgl_bayar'] < date("d")) {
                            $um_angsur = $post['um_angsur'];
                            for($i =1; $i<=$um_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['um_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_um' => $post['um'],
                                    'angsuran' => $post['um_angsur'],
                                    'cicilan_angsuran' => $post['um_angsuran'],
                                    'tgl_bayar' => $post['um_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('uang_muka', $data);
                            }
                        }
                    }
                    else if($post['um'] == $um->jml_um & $post['um_angsur'] == $um->angsuran & $post['um_tgl_bayar'] == $um->tgl_bayar){
                        //return true
                    }
                    else {
                    $this->db->delete('uang_muka',['id_konsumen' => $id_konsumen]);
                        if($post['um_tgl_bayar'] >= date("d")){
                            $um_angsur = $post['um_angsur'] - 1;
                            for($i =0; $i<=$um_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['um_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_um' => $post['um'],
                                    'angsuran' => $post['um_angsur'],
                                    'cicilan_angsuran' => $post['um_angsuran'],
                                    'tgl_bayar' => $post['um_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('uang_muka', $data);
                            }
                        } else if($post['um_tgl_bayar'] < date("d")) {
                            $um_angsur = $post['um_angsur'];
                            for($i =1; $i<=$um_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['um_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_um' => $post['um'],
                                    'angsuran' => $post['um_angsur'],
                                    'cicilan_angsuran' => $post['um_angsuran'],
                                    'tgl_bayar' => $post['um_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('uang_muka', $data);
                            }
                        }
                    }



                    //update kelebihan tanah
                    $kt = $this->db->get_where('kelebihan_tanah',['id_konsumen' => $id_konsumen])->row();
                    if($kt == null){
                        if($post['kt_tgl_bayar'] >= date("d")){
                            $kt_angsur = $post['kt_angsur'] - 1;
                            for($i =0; $i<=$kt_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['kt_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_kt' => $post['kt'],
                                    'angsuran' => $post['kt_angsur'],
                                    'cicilan_angsuran' => $post['kt_angsuran'],
                                    'tgl_bayar' => $post['kt_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('kelebihan_tanah', $data);
                            }
                        } else if($post['kt_tgl_bayar'] < date("d")) {
                            $kt_angsur = $post['kt_angsur'];
                            for($i =1; $i<=$kt_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['kt_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_kt' => $post['kt'],
                                    'angsuran' => $post['kt_angsur'],
                                    'cicilan_angsuran' => $post['kt_angsuran'],
                                    'tgl_bayar' => $post['kt_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('kelebihan_tanah', $data);
                            }
                        }
                    }
                    else if($post['kt'] == $kt->jml_kt & $post['kt_angsur'] == $kt->angsuran & $post['kt_tgl_bayar'] == $kt->tgl_bayar){
                        //return true
                    } else {
                    $this->db->delete('kelebihan_tanah',['id_konsumen' => $id_konsumen]);
                        if($post['kt_tgl_bayar'] >= date("d")){
                            $kt_angsur = $post['kt_angsur'] - 1;
                            for($i =0; $i<=$kt_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['kt_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_kt' => $post['kt'],
                                    'angsuran' => $post['kt_angsur'],
                                    'cicilan_angsuran' => $post['kt_angsuran'],
                                    'tgl_bayar' => $post['kt_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('kelebihan_tanah', $data);
                            }
                        } else if($post['kt_tgl_bayar'] < date("d")) {
                            $kt_angsur = $post['kt_angsur'];
                            for($i =1; $i<=$kt_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['kt_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_kt' => $post['kt'],
                                    'angsuran' => $post['kt_angsur'],
                                    'cicilan_angsuran' => $post['kt_angsuran'],
                                    'tgl_bayar' => $post['kt_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('kelebihan_tanah', $data);
                            }
                        }
                    }
                        


                        //update PAK
                        $pak = $this->db->get_where('pak',['id_konsumen' => $id_konsumen])->row();
                        if($pak == null){
                            if($post['pak_tgl_bayar'] >= date("d")){
                                $pak_angsur = $post['pak_angsur'] - 1;
                                for($i =0; $i<=$pak_angsur; $i++){
                                    $date = mktime(0,0,0, date("m")+$i, date($post['pak_tgl_bayar']), date("Y"));
                                    $date = date("Y-m-d", $date);
            
                                    $data = [
                                        'id_konsumen' => $id_konsumen,
                                        'jml_pak' => $post['pak'],
                                        'angsuran' => $post['pak_angsur'],
                                        'cicilan_angsuran' => $post['pak_angsuran'],
                                        'tgl_bayar' => $post['pak_tgl_bayar'],
                                        'status' => 0,
                                        'jatuh_tempo' => $date
                                    ];
                                    $this->db->insert('pak', $data);
                                }
                            } else if($post['pak_tgl_bayar'] < date("d")) {
                                $pak_angsur = $post['pak_angsur'];
                                for($i =1; $i<=$pak_angsur; $i++){
                                    $date = mktime(0,0,0, date("m")+$i, date($post['pak_tgl_bayar']), date("Y"));
                                    $date = date("Y-m-d", $date);
            
                                    $data = [
                                        'id_konsumen' => $id_konsumen,
                                        'jml_pak' => $post['pak'],
                                        'angsuran' => $post['pak_angsur'],
                                        'cicilan_angsuran' => $post['pak_angsuran'],
                                        'tgl_bayar' => $post['pak_tgl_bayar'],
                                        'status' => 0,
                                        'jatuh_tempo' => $date
                                    ];
                                    $this->db->insert('pak', $data);
                                }
                            }
                        }
                        else if($post['pak'] == $pak->jml_pak & $post['pak_angsur'] == $pak->angsuran & $post['pak_tgl_bayar'] == $pak->tgl_bayar){
                            //return true
                        } else {
                        $this->db->delete('pak',['id_konsumen' => $id_konsumen]);
                            if($post['pak_tgl_bayar'] >= date("d")){
                                $pak_angsur = $post['pak_angsur'] - 1;
                                for($i =0; $i<=$pak_angsur; $i++){
                                    $date = mktime(0,0,0, date("m")+$i, date($post['pak_tgl_bayar']), date("Y"));
                                    $date = date("Y-m-d", $date);
            
                                    $data = [
                                        'id_konsumen' => $id_konsumen,
                                        'jml_pak' => $post['pak'],
                                        'angsuran' => $post['pak_angsur'],
                                        'cicilan_angsuran' => $post['pak_angsuran'],
                                        'tgl_bayar' => $post['pak_tgl_bayar'],
                                        'status' => 0,
                                        'jatuh_tempo' => $date
                                    ];
                                    $this->db->insert('pak', $data);
                                }
                            } else if($post['pak_tgl_bayar'] < date("d")) {
                                $pak_angsur = $post['pak_angsur'];
                                for($i =1; $i<=$pak_angsur; $i++){
                                    $date = mktime(0,0,0, date("m")+$i, date($post['pak_tgl_bayar']), date("Y"));
                                    $date = date("Y-m-d", $date);
            
                                    $data = [
                                        'id_konsumen' => $id_konsumen,
                                        'jml_pak' => $post['pak'],
                                        'angsuran' => $post['pak_angsur'],
                                        'cicilan_angsuran' => $post['pak_angsuran'],
                                        'tgl_bayar' => $post['pak_tgl_bayar'],
                                        'status' => 0,
                                        'jatuh_tempo' => $date
                                    ];
                                    $this->db->insert('pak', $data);
                                }
                            }
                        } 


                    //update lain-lain
                    $lain = $this->db->get_where('lain_lain',['id_konsumen' => $id_konsumen])->row();
                    if($lain == null){
                        if($post['lain_tgl_bayar'] >= date("d")){
                                $lain_angsur = $post['lain_angsur'] - 1;
                                for($i =0; $i<=$lain_angsur; $i++){
                                    $date = mktime(0,0,0, date("m")+$i, date($post['lain_tgl_bayar']), date("Y"));
                                    $date = date("Y-m-d", $date);
            
                                    $data = [
                                        'id_konsumen' => $id_konsumen,
                                        'jml_lain' => $post['lain'],
                                        'angsuran' => $post['lain_angsur'],
                                        'cicilan_angsuran' => $post['lain_angsuran'],
                                        'tgl_bayar' => $post['lain_tgl_bayar'],
                                        'status' => 0,
                                        'jatuh_tempo' => $date
                                    ];
                                    $this->db->insert('lain_lain', $data);
                                }
                            } else if($post['lain_tgl_bayar'] < date("d")) {
                                $lain_angsur = $post['lain_angsur'];
                                for($i =1; $i<=$lain_angsur; $i++){
                                    $date = mktime(0,0,0, date("m")+$i, date($post['lain_tgl_bayar']), date("Y"));
                                    $date = date("Y-m-d", $date);
            
                                    $data = [
                                        'id_konsumen' => $id_konsumen,
                                        'jml_lain' => $post['lain'],
                                        'angsuran' => $post['lain_angsur'],
                                        'cicilan_angsuran' => $post['lain_angsuran'],
                                        'tgl_bayar' => $post['lain_tgl_bayar'],
                                        'status' => 0,
                                        'jatuh_tempo' => $date
                                    ];
                                    $this->db->insert('lain_lain', $data);
                                }
                            }
                    }
                    else if($post['lain'] == $lain->jml_lain & $post['lain_angsur'] == $lain->angsuran & $post['lain_tgl_bayar'] == $lain->tgl_bayar){
                        //return true
                    } else {
                        $this->db->delete('lain_lain',['id_konsumen' => $id_konsumen]);
                            if($post['lain_tgl_bayar'] >= date("d")){
                                $lain_angsur = $post['lain_angsur'] - 1;
                                for($i =0; $i<=$lain_angsur; $i++){
                                    $date = mktime(0,0,0, date("m")+$i, date($post['lain_tgl_bayar']), date("Y"));
                                    $date = date("Y-m-d", $date);
            
                                    $data = [
                                        'id_konsumen' => $id_konsumen,
                                        'jml_lain' => $post['lain'],
                                        'angsuran' => $post['lain_angsur'],
                                        'cicilan_angsuran' => $post['lain_angsuran'],
                                        'tgl_bayar' => $post['lain_tgl_bayar'],
                                        'status' => 0,
                                        'jatuh_tempo' => $date
                                    ];
                                    $this->db->insert('lain_lain', $data);
                                }
                            } else if($post['lain_tgl_bayar'] < date("d")) {
                                $lain_angsur = $post['lain_angsur'];
                                for($i =1; $i<=$lain_angsur; $i++){
                                    $date = mktime(0,0,0, date("m")+$i, date($post['lain_tgl_bayar']), date("Y"));
                                    $date = date("Y-m-d", $date);
            
                                    $data = [
                                        'id_konsumen' => $id_konsumen,
                                        'jml_lain' => $post['lain'],
                                        'angsuran' => $post['lain_angsur'],
                                        'cicilan_angsuran' => $post['lain_angsuran'],
                                        'tgl_bayar' => $post['lain_tgl_bayar'],
                                        'status' => 0,
                                        'jatuh_tempo' => $date
                                    ];
                                    $this->db->insert('lain_lain', $data);
                                }
                            }
                    }



                $params = array("success" => true);




                } else {
                $params = array("success" => false);
                }

            } else {
                $params = array("success" => false, "status" => 25);
            }

                


        }


        echo json_encode($params);
    }


    public function view_detail_tf_bank(){
        $id = $_POST['id_konsumen'];
        $data['konsumen'] = $this->db->get_where('tbl_marketing',['id_marketing' => $id])->row();
        $status_perum = $this->db->get_where('tbl_perumahan',['id_perumahan' => $this->session->userdata('id_perumahan')])->row()->cluster;

        if($status_perum == 0){
            $q = "SELECT * FROM tbl_transaksi_bank, tbl_tipe, tbl_kavling WHERE tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tbl_transaksi_bank.id_konsumen = $id AND tbl_kavling.id_tipe = tbl_tipe.id_tipe";
        } else if($status_perum == 1){
            $q = "SELECT * FROM tbl_transaksi_bank, tbl_kavling, tbl_cluster, tbl_tipe WHERE tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tbl_transaksi_bank.id_konsumen = $id AND tbl_kavling.id_cluster = tbl_cluster.id_cluster AND tbl_kavling.id_tipe = tbl_tipe.id_tipe"; 
        } 
        
        
        $data['bank'] = $this->db->query($q)->row();
        $data['status_perum'] = $status_perum;
        $data['tjl'] = $this->db->get_where('tanda_jadi_lokasi',['id_konsumen' => $id])->row();
        $data['um'] = $this->db->get_where('uang_muka',['id_konsumen' => $id])->row();
        $data['kt'] = $this->db->get_where('kelebihan_tanah',['id_konsumen' => $id])->row();
        $data['pak'] = $this->db->get_where('pak',['id_konsumen' => $id])->row();
        $data['lain'] = $this->db->get_where('lain_lain',['id_konsumen' => $id])->row();

        $data['pasangan'] = $this->db->get_where('tbl_pasangan',['id_marketing' => $id])->row();

        $data['angsuran_bank'] = $this->db->get_where('angsuran_bank',['id_konsumen' => $id])->row();
        $data['piutang_bank'] = $this->db->get_where('piutang_bank',['id_konsumen' => $id])->row();

        $this->load->view('marketing/view_tf_bank', $data);
    }

    public function get_bank_join_all(){
        $id = $_POST['id'];

        $status_perum = $this->db->get_where('tbl_perumahan',['id_perumahan' => $this->session->userdata('id_perumahan')])->row()->cluster;

        // $q = "SELECT * FROM tbl_marketing, tbl_transaksi_bank, tanda_jadi_lokasi, uang_muka, kelebihan_tanah, pak, lain_lain, tbl_kavling WHERE tbl_marketing.id_marketing = $id AND tbl_transaksi_bank.id_konsumen = $id AND tanda_jadi_lokasi.id_konsumen = $id AND uang_muka.id_konsumen = $id AND kelebihan_tanah.id_konsumen = $id AND pak.id_konsumen = $id AND lain_lain.id_konsumen = $id AND tbl_kavling.id_kavling = tbl_transaksi_bank.id_rumah";

        if($status_perum == 0){
            $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling, tbl_tipe WHERE tbl_transaksi_bank.id_konsumen = $id AND tbl_marketing.id_marketing = $id AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tbl_kavling.id_tipe = tbl_tipe.id_tipe";
        } else if($status_perum == 1){
            $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling, tbl_cluster, tbl_tipe WHERE tbl_transaksi_bank.id_konsumen = $id AND tbl_marketing.id_marketing = $id AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tbl_kavling.id_cluster = tbl_cluster.id_cluster  AND tbl_kavling.id_tipe = tbl_tipe.id_tipe";
        }
        $all = $this->db->query($q)->row();
        
        echo json_encode($all);
    }


    public function get_tjl(){
        $id = $_POST['id'];
        $q = $this->db->get_where('tanda_jadi_lokasi',['id_konsumen' => $id, 'status !=' => 9])->row();
        echo json_encode($q);
    }

    public function get_um(){
        $id = $_POST['id'];
        $q = $this->db->get_where('uang_muka',['id_konsumen' => $id, 'status !=' => 9])->row();
        echo json_encode($q);
    }

    public function get_kt(){
        $id = $_POST['id'];
        $q = $this->db->get_where('kelebihan_tanah',['id_konsumen' => $id, 'status !=' => 9])->row();
        echo json_encode($q);
    }

    public function get_pak(){
        $id = $_POST['id'];
        $q = $this->db->get_where('pak',['id_konsumen' => $id, 'status !=' => 9])->row();
        echo json_encode($q);
    }

    public function get_lain(){
        $id = $_POST['id'];
        $q = $this->db->get_where('lain_lain',['id_konsumen' => $id, 'status !=' => 9])->row();
        echo json_encode($q);
    }

    public function get_angsuran(){
        $id = $_POST['id'];
        $q = $this->db->get_where('angsuran_bank',['id_konsumen' => $id, 'status !=' => 9])->row();
        echo json_encode($q);
    }

    public function get_piutang(){
        $id = $_POST['id'];
        $q = $this->db->get_where('piutang_bank',['id_konsumen' => $id, 'status !=' => 9])->row();
        echo json_encode($q);
    }
    

    //transaksi inhouse
    public function transaksi_inhouse(){
        $id_perumahan = $this->session->userdata('id_perumahan');
        $data['rumah'] = $this->db->order_by('blok','ASC')->get_where('tbl_kavling',['id_perum' => $id_perumahan, 'status_kavling' => 0])->result();
        $data['cluster'] = $this->db->get_where('tbl_cluster',['id_perum' => $id_perumahan])->result();
        $data['konsumen_tf_bank'] = $this->db->get_where('tbl_marketing',['status' => 1])->result();

        $q = "SELECT * FROM tbl_transaksi_inhouse, tbl_marketing, tbl_kavling WHERE tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND tbl_transaksi_inhouse.id_konsumen = tbl_marketing.id_marketing AND tbl_kavling.id_perum = $id_perumahan AND tbl_marketing.status != 0 AND tbl_marketing.status != 2 AND tbl_marketing.status != 1";
        $data['konsumen_inhouse'] = $this->db->query($q)->result();
        $data['kavling'] = $this->master_model->get_kavling_join_perum();
        
        $this->template->load('template', 'marketing/transaksi_inhouse', $data);
    }

    public function get_rumah(){
        $id_konsumen = $_POST['id_konsumen'];
        $q = "SELECT * FROM tbl_transaksi_bank JOIN tbl_kavling ON tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling WHERE tbl_transaksi_bank.id_konsumen = $id_konsumen";
        echo json_encode($this->db->query($q)->row());
    }

    public function add_transaksi_inhouse(){
        $post = $this->input->post(null, TRUE);
        $id_perumahan = $this->session->userdata('id_perumahan');

        $cek_email = $this->db->get_where('tbl_marketing',['email' => $post['email']])->num_rows();
        $cek_email2 = $this->db->get_where('tbl_pasangan',['email' => $post['email']])->num_rows();

        $cek_nik = $this->db->get_where('tbl_marketing',['nik' => $post['nik']])->num_rows();
        $cek_nik2 = $this->db->get_where('tbl_pasangan',['nik' => $post['nik']])->num_rows();

        $cek_telp = $this->db->get_where('tbl_marketing',['no_hp' => $post['nohp_p']])->num_rows();
        $cek_telp2 = $this->db->get_where('tbl_pasangan',['no_hp' => $post['nohp_p']])->num_rows();
    
        $cek_email_p = $this->db->get_where('tbl_marketing',['email' => $post['email_p']])->num_rows();
        $cek_email2_p = $this->db->get_where('tbl_pasangan',['email' => $post['email_p']])->num_rows();
    
        $cek_nik_p = $this->db->get_where('tbl_marketing',['nik' => $post['nik_p']])->num_rows();
        $cek_nik2_p = $this->db->get_where('tbl_pasangan',['nik' => $post['nik_p']])->num_rows();

        if(empty($post['tanda_jadi'])){
            $params = array("success" => false, "status" => 1);
        } 
        elseif(empty($post['tanggal_tanda_jadi'])){
            $params = array("success" => false, "status" => 2);
        }
        elseif($post['cicil_angsur_hk'] != '' & $post['tgl_bayar_hk'] == ''){
            $params = array("success" => false, "status" => 3);
        }
        elseif($post['cicil_angsur_hk'] == '' & $post['tgl_bayar_hk'] != ''){
            $params = array("success" => false, "status" => 4);
        }
        elseif($post['cicil_angsur_tjl'] != '' & $post['tgl_bayar_tjl'] == ''){
            $params = array("success" => false, "status" => 5);
        }
        elseif($post['cicil_angsur_tjl'] == '' & $post['tgl_bayar_tjl'] != ''){
            $params = array("success" => false, "status" => 6);
        }
        elseif($post['cicil_angsur_um'] != '' & $post['tgl_bayar_um'] == ''){
            $params = array("success" => false, "status" => 7);
        }
        elseif($post['cicil_angsur_um'] == '' & $post['tgl_bayar_um'] != ''){
            $params = array("success" => false, "status" => 8);
        }
        elseif($post['cicil_angsur_kt'] != '' & $post['tgl_bayar_kt'] == ''){
            $params = array("success" => false, "status" => 9);
        }
        elseif($post['cicil_angsur_kt'] == '' & $post['tgl_bayar_kt'] != ''){
            $params = array("success" => false, "status" => 10);
        }

        
        elseif($post['nik'] == ''){
            $params = array("success" => false, "status" => 100);
        }
        elseif($cek_nik > 0){
            $params = array("success" => false, "status" => 107);
        }
        elseif($cek_nik2 > 0){
            $params = array("success" => false, "status" => 107);
        }
        elseif($post['tempat_kerja'] == ''){
            $params = array("success" => false, "status" => 104);
        }
        elseif($post['gaji'] == ''){
            $params = array("success" => false, "status" => 105);
        }
        elseif($post['email'] == ''){
            $params = array("success" => false, "status" => 106);
        }
        elseif($cek_email > 0){
            $params = array("success" => false, "status" => 108);
        }
        elseif($cek_email2 > 0){
            $params = array("success" => false, "status" => 108);
        }
        elseif($post['alamat'] == ''){
            $params = array("success" => false, "status" => 101);
        }
        elseif($post['status_menikah'] == ''){
            $params = array("success" => false, "status" => 102);
        }
        elseif($post['id_rumah'] == ''){
            $params = array("success" => false, "status" => 103);
        }

        //data pasangan
        elseif($post['status_menikah'] == 'Sudah' & $post['nik_p'] == ''){
            $params = array("success" => false, "status" => 30);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['nama_p'] == ''){
            $params = array("success" => false, "status" => 31);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['nohp_p'] == ''){
            $params = array("success" => false, "status" => 32);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['email_p'] == ''){
            $params = array("success" => false, "status" => 33);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['jk_p'] == ''){
            $params = array("success" => false, "status" => 34);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['pekerjaan_p'] == ''){
            $params = array("success" => false, "status" => 35);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['tk_p'] == ''){
            $params = array("success" => false, "status" => 36);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['gaji_p'] == ''){
            $params = array("success" => false, "status" => 37);
        }
        
        else {

            if($post['status_menikah'] == 'Sudah'){

                if($cek_nik_p > 0){
                    $params = array("success" => false, "status" => 38);
                }
                elseif($cek_nik2_p > 0){
                    $params = array("success" => false, "status" => 38);
                }
                elseif($cek_email_p > 0){
                    $params = array("success" => false, "status" => 39);
                }
                elseif($cek_email2_p > 0){
                    $params = array("success" => false, "status" => 39);
                }
                elseif($cek_telp > 0){
                    $params = array("success" => false, "status" => 40);
                }
                elseif($cek_telp2 > 0){
                    $params = array("success" => false, "status" => 40);
                } else {

                $data_pasangan = [
                    'id_marketing' => $post['id_konsumen'],
                    'nik' => $post['nik_p'],
                    'nama' => $post['nama_p'],
                    'no_hp' => $post['nohp_p'],
                    'email' => $post['email_p'],
                    'jk' => $post['jk_p'],
                    'pekerjaan' => $post['pekerjaan_p'],
                    'tempat_kerja' => $post['tk_p'],
                    'gaji' => $post['gaji_p']
                ];
                $this->db->insert('tbl_pasangan', $data_pasangan);
                }
            }
        
            $data_konsume = [
                'nik' => $post['nik'],
                'tempat_kerja' => $post['tempat_kerja'],
                'gaji' => $post['gaji'],
                'email' => $post['email'],
                'alamat' => $post['alamat'],
                'status_menikah' => $post['status_menikah']
            ];
            $this->db->where('id_marketing', $post['id_konsumen'])->update('tbl_marketing', $data_konsume);

            $data = [
                'id_konsumen' => $post['id_konsumen'],
                'id_rumah' => $post['id_rumah'],
                'tanda_jadi' => $post['tanda_jadi'],
                'tgl_tanda_jadi' => $post['tanggal_tanda_jadi'] 
            ];

            // $this->db->insert('tbl_transaksi_inhouse', $data);

            if($this->db->insert('tbl_transaksi_inhouse', $data)){

            $id_konsumen = $post['id_konsumen'];

            //input harga kesepakatan
            if($post['tgl_bayar_hk'] >= date("d")){
                $angsur_hk = $post['angsur_hk'] - 1;
                for($i =0; $i<=$angsur_hk; $i++){
                    $date = mktime(0,0,0, date("m")+$i, date($post['tgl_bayar_hk']), date("Y"));
                    $date = date("Y-m-d", $date);
                    
                    $data = [
                        'id_konsumen' => $id_konsumen,
                        'jml_kesepakatan' => $post['harga_kesepakatan'],
                        'angsuran' => $post['angsur_hk'],
                        'cicilan_angsuran' => $post['cicil_angsur_hk'],
                        'tgl_bayar' => $post['tgl_bayar_hk'],
                        'status' => 0,
                        'jatuh_tempo' => $date,
                        'id_perumahan' => $id_perumahan,
                        'denda' => 0
                    ];
                    $this->db->insert('harga_kesepakatan_inhouse', $data);

                }
            } else if($post['tgl_bayar_hk'] < date("d")) {
                $angsur_hk = $post['angsur_hk'];
                for($i =1; $i<=$angsur_hk; $i++){
                    $date = mktime(0,0,0, date("m")+$i, date($post['tgl_bayar_hk']), date("Y"));
                    $date = date("Y-m-d", $date);
                    $data = [
                        'id_konsumen' => $id_konsumen,
                        'jml_kesepakatan' => $post['harga_kesepakatan'],
                        'angsuran' => $post['angsur_hk'],
                        'cicilan_angsuran' => $post['cicil_angsur_hk'],
                        'tgl_bayar' => $post['tgl_bayar_hk'],
                        'status' => 0,
                        'jatuh_tempo' => $date,
                        'id_perumahan' => $id_perumahan,
                        'denda' => 0
                    ];
                    $this->db->insert('harga_kesepakatan_inhouse', $data);
                }

            }

            //input tanda jadi lokasi
            if($post['tgl_bayar_tjl'] >= date("d")){
                $angsur_tjl = $post['angsur_tjl'] - 1;
                for($i =0; $i<=$angsur_tjl; $i++){
                    $date = mktime(0,0,0, date("m")+$i, date($post['tgl_bayar_tjl']), date("Y"));
                    $date = date("Y-m-d", $date);
                    
                    $data = [
                        'id_konsumen' => $id_konsumen,
                        'jml_tjl' => $post['tjl'],
                        'angsuran' => $post['angsur_tjl'],
                        'cicilan_angsuran' => $post['cicil_angsur_tjl'],
                        'tgl_bayar' => $post['tgl_bayar_tjl'],
                        'status' => 0,
                        'jatuh_tempo' => $date,
                        'id_perumahan' => $id_perumahan,
                        'denda' => 0
                    ];
                    $this->db->insert('tanda_jadi_lokasi_inhouse', $data);

                }
            } else if($post['tgl_bayar_tjl'] < date("d")) {
                $angsur_tjl = $post['angsur_tjl'];
                for($i =1; $i<=$angsur_tjl; $i++){
                    $date = mktime(0,0,0, date("m")+$i, date($post['tgl_bayar_tjl']), date("Y"));
                    $date = date("Y-m-d", $date);
                    $data = [
                        'id_konsumen' => $id_konsumen,
                        'jml_tjl' => $post['tjl'],
                        'angsuran' => $post['angsur_tjl'],
                        'cicilan_angsuran' => $post['cicil_angsur_tjl'],
                        'tgl_bayar' => $post['tgl_bayar_tjl'],
                        'status' => 0,
                        'jatuh_tempo' => $date,
                        'id_perumahan' => $id_perumahan,
                        'denda' => 0
                    ];
                    $this->db->insert('tanda_jadi_lokasi_inhouse', $data);
                }

            }

            //Input uang muka
            if($post['tgl_bayar_um'] >= date("d")){
                $angsur_um = $post['angsur_um'] - 1;
                for($i =0; $i<=$angsur_um; $i++){
                    $date = mktime(0,0,0, date("m")+$i, date($post['tgl_bayar_um']), date("Y"));
                    $date = date("Y-m-d", $date);
                    
                    $data = [
                        'id_konsumen' => $id_konsumen,
                        'jml_um' => $post['um'],
                        'angsuran' => $post['angsur_um'],
                        'cicilan_angsuran' => $post['cicil_angsur_um'],
                        'tgl_bayar' => $post['tgl_bayar_um'],
                        'status' => 0,
                        'jatuh_tempo' => $date,
                        'id_perumahan' => $id_perumahan,
                        'denda' => 0
                    ];
                    $this->db->insert('uang_muka_inhouse', $data);

                }
            } else if($post['tgl_bayar_um'] < date("d")) {
                $angsur_um = $post['angsur_um'];
                for($i =1; $i<=$angsur_um; $i++){
                    $date = mktime(0,0,0, date("m")+$i, date($post['tgl_bayar_um']), date("Y"));
                    $date = date("Y-m-d", $date);
                    $data = [
                        'id_konsumen' => $id_konsumen,
                        'jml_um' => $post['um'],
                        'angsuran' => $post['angsur_um'],
                        'cicilan_angsuran' => $post['cicil_angsur_um'],
                        'tgl_bayar' => $post['tgl_bayar_um'],
                        'status' => 0,
                        'jatuh_tempo' => $date,
                        'id_perumahan' => $id_perumahan,
                        'denda' => 0
                    ];
                    $this->db->insert('uang_muka_inhouse', $data);
                }

            }

            //input kelebihan tanah
            if($post['tgl_bayar_kt'] >= date("d")){
                $angsur_kt = $post['angsur_kt'] - 1;
                for($i =0; $i<=$angsur_kt; $i++){
                    $date = mktime(0,0,0, date("m")+$i, date($post['tgl_bayar_kt']), date("Y"));
                    $date = date("Y-m-d", $date);
                    
                    $data = [
                        'id_konsumen' => $id_konsumen,
                        'jml_kt' => $post['kt'],
                        'angsuran' => $post['angsur_kt'],
                        'cicilan_angsuran' => $post['cicil_angsur_kt'],
                        'tgl_bayar' => $post['tgl_bayar_kt'],
                        'status' => 0,
                        'jatuh_tempo' => $date,
                        'id_perumahan' => $id_perumahan,
                        'denda' => 0
                    ];
                    $this->db->insert('kelebihan_tanah_inhouse', $data);

                }
            } else if($post['tgl_bayar_kt'] < date("d")) {
                $angsur_kt = $post['angsur_kt'];
                for($i =1; $i<=$angsur_kt; $i++){
                    $date = mktime(0,0,0, date("m")+$i, date($post['tgl_bayar_kt']), date("Y"));
                    $date = date("Y-m-d", $date);
                    $data = [
                        'id_konsumen' => $id_konsumen,
                        'jml_kt' => $post['kt'],
                        'angsuran' => $post['angsur_kt'],
                        'cicilan_angsuran' => $post['cicil_angsur_kt'],
                        'tgl_bayar' => $post['tgl_bayar_kt'],
                        'status' => 0,
                        'jatuh_tempo' => $date,
                        'id_perumahan' => $id_perumahan,
                        'denda' => 0
                    ];
                    $this->db->insert('kelebihan_tanah_inhouse', $data);
                }

            }
            $this->db->set('status_kavling', 1)->where('id_kavling', $post['id_rumah'])->update('tbl_kavling');
            if($this->db->set('status', 3)->where('id_marketing', $id_konsumen)->update('tbl_marketing')){
                $params = array("success" => true);
            } else {
                $params = array("success" => false);
            }


            } else {
                $params = array("success" => false, "status" => 11);
            }


        }

        echo json_encode($params);
    }


    public function view_detail_inhouse(){
        $id_konsumen = $_POST['id_konsumen'];
        $data['konsumen'] = $this->db->get_where('tbl_marketing',['id_marketing' => $id_konsumen])->row();
        $status_perum = $this->db->get_where('tbl_perumahan',['id_perumahan' => $this->session->userdata('id_perumahan')])->row()->cluster;

        if($status_perum == 0){
            $q = "SELECT * FROM tbl_transaksi_inhouse, tbl_tipe, tbl_kavling WHERE tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND tbl_transaksi_inhouse.id_konsumen = $id_konsumen AND tbl_kavling.id_tipe = tbl_tipe.id_tipe";
        } else if($status_perum == 1){
            $q = "SELECT * FROM tbl_transaksi_inhouse, tbl_kavling, tbl_cluster, tbl_tipe WHERE tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND tbl_transaksi_inhouse.id_konsumen = $id_konsumen AND tbl_kavling.id_cluster = tbl_cluster.id_cluster AND tbl_kavling.id_tipe = tbl_tipe.id_tipe";
        }

        $data['pasangan'] = $this->db->get_where('tbl_pasangan',['id_marketing' => $id_konsumen])->row();
        $data['bank'] = $this->db->query($q)->row();
        $data['status_perum'] = $status_perum;
        $data['hk'] = $this->db->get_where('harga_kesepakatan_inhouse',['id_konsumen' => $id_konsumen])->row();
        $data['tjl'] = $this->db->get_where('tanda_jadi_lokasi_inhouse',['id_konsumen' => $id_konsumen])->row();
        $data['um'] = $this->db->get_where('uang_muka_inhouse',['id_konsumen' => $id_konsumen])->row();
        $data['kt'] = $this->db->get_where('kelebihan_tanah_inhouse',['id_konsumen' => $id_konsumen])->row();
        $this->load->view('marketing/view_tf_inhouse', $data);
    }

    
    //management konsumen

    public function konsumen(){
        $id_perumahan = $this->session->userdata('id_perumahan');
        $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling WHERE tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_kavling.id_perum = $id_perumahan AND tbl_marketing.status != 0 AND tbl_marketing.status != 1";
        $data['bank'] = $this->db->query($q)->result();

        $p = "SELECT * FROM tbl_transaksi_inhouse, tbl_marketing, tbl_kavling WHERE tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND tbl_transaksi_inhouse.id_konsumen = tbl_marketing.id_marketing AND tbl_kavling.id_perum = $id_perumahan AND tbl_marketing.status != 0 AND tbl_marketing.status != 1";
        $data['inhouse'] = $this->db->query($p)->result();
        // var_dump($data['inhouse']);die;
        $this->template->load('template', 'marketing/konsumen', $data);
    }

    public function batal_transaksi_bank(){
        $id = $_POST['id'];
        $konsumen = $this->db->get_where('tbl_marketing',['id_marketing' => $id])->row();
        $this->db->set('status',0)->where('id_marketing', $id)->update('tbl_marketing');
        $q = "SELECT * FROM tbl_transaksi_bank JOIN tbl_kavling ON tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling WHERE tbl_transaksi_bank.id_konsumen = $id";
        $id_rumah = $this->db->query($q)->row()->id_kavling;
        $this->db->set('status_kavling', 0)->where('id_kavling', $id_rumah)->update('tbl_kavling');
        $params = array("success" => true);
        echo json_encode($params);
    }


    public function batal_transaksi_inhouse(){
        $id = $_POST['id'];
        $konsumen = $this->db->get_where('tbl_marketing',['id_marketing' => $id])->row();
        $this->db->set('status',0)->where('id_marketing', $id)->update('tbl_marketing');
        $q = "SELECT * FROM tbl_transaksi_inhouse JOIN tbl_kavling ON tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling WHERE tbl_transaksi_inhouse.id_konsumen = $id";
        $id_rumah = $this->db->query($q)->row()->id_kavling;
        $this->db->set('status_kavling', 0)->where('id_kavling', $id_rumah)->update('tbl_kavling');
        $params = array("success" => true);
        echo json_encode($params);
    }

    public function get_inhouse_join_all(){
        $id = $_POST['id'];
        $status_perum = $this->db->get_where('tbl_perumahan',['id_perumahan' => $this->session->userdata('id_perumahan')])->row()->cluster;

        if($status_perum == 0){
            $q = "SELECT * FROM tbl_transaksi_inhouse, tbl_marketing, tbl_kavling, tbl_tipe WHERE tbl_transaksi_inhouse.id_konsumen = $id AND tbl_marketing.id_marketing = $id AND tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND tbl_kavling.id_tipe = tbl_tipe.id_tipe";
        } else if($status_perum == 1) {
            $q = "SELECT * FROM tbl_transaksi_inhouse, tbl_marketing, tbl_kavling, tbl_cluster, tbl_tipe WHERE tbl_transaksi_inhouse.id_konsumen = $id AND tbl_marketing.id_marketing = $id AND tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND tbl_kavling.id_cluster = tbl_cluster.id_cluster AND tbl_kavling.id_tipe = tbl_tipe.id_tipe";
        }
        $all = $this->db->query($q)->row();
        echo json_encode($all);
    }

    public function get_tjl_inhouse(){
        $id = $_POST['id'];
        $q = $this->db->get_where('tanda_jadi_lokasi_inhouse',['id_konsumen' => $id])->row();
        echo json_encode($q);
    }

    public function get_um_inhouse(){
        $id = $_POST['id'];
        $q = $this->db->get_where('uang_muka_inhouse',['id_konsumen' => $id])->row();
        echo json_encode($q);
    }

    public function get_kt_inhouse(){
        $id = $_POST['id'];
        $q = $this->db->get_where('kelebihan_tanah_inhouse',['id_konsumen' => $id])->row();
        echo json_encode($q);
    }
    
    public function get_hk_inhouse(){
        $id = $_POST['id'];
        $q = $this->db->get_where('harga_kesepakatan_inhouse',['id_konsumen' => $id])->row();
        echo json_encode($q);
    }

    public function edit_inhouse(){
        $post = $this->input->post(null, TRUE);

        //validasi data konsumen
        if(empty($post['nik'])){
            $params = array("success" => false, "status" => 1);
        }
        else if(empty($post['nama'])){
            $params = array("success" => false, "status" => 2);
        }
        else if(empty($post['jk'])){
            $params = array("success" => false, "status" => 3);
        }
        else if(empty($post['no_hp'])){
            $params = array("success" => false, "status" => 4);
        }
        else if(empty($post['pekerjaan'])){
            $params = array("success" => false, "status" => 5);
        }
        else if(empty($post['alamat'])){
            $params = array("success" => false, "status" => 6);
        }
        else if(empty($post['email'])){
            $params = array("success" => false, "status" => 7);
        }
        else if(empty($post['status_menikah'])){
            $params = array("success" => false, "status" => 8);
        }
        else if(empty($post['tempat_kerja'])){
            $params = array("success" => false, "status" => 9);
        }
        else if(empty($post['gaji'])){
            $params = array("success" => false, "status" => 10);
        }
        else if(empty($post['info'])){
            $params = array("success" => false, "status" => 11);
        }

        //validasi data bank
        else if(empty($post['tanda_jadi'])){
            $params = array("success" => false, "status" => 12);
        }
        else if(empty($post['tgl_tanda_jadi'])){
            $params = array("success" => false, "status" => 13);
        }

        //tanda jadi lokasi
        elseif($post['tjl_angsuran'] == '' & $post['tjl_tgl_bayar'] != ''){
            $params = array("success" => false, "status" => 15);
        }
        elseif($post['tjl_angsuran'] != '' & $post['tjl_tgl_bayar'] == ''){
            $params = array("success" => false, "status" => 16);
        }
        
        //uang muka
        elseif($post['um_angsuran'] == '' & $post['um_tgl_bayar'] != ''){
            $params = array("success" => false, "status" => 17);
        }
        elseif($post['um_angsuran'] != '' & $post['um_tgl_bayar'] == ''){
            $params = array("success" => false, "status" => 18);
        }

        //kelebihan tanah
        elseif($post['kt_angsuran'] == '' & $post['kt_tgl_bayar'] != ''){
            $params = array("success" => false, "status" => 19);
        }
        elseif($post['kt_angsuran'] != '' & $post['kt_tgl_bayar'] == ''){
            $params = array("success" => false, "status" => 20);
        }

        //harga kesepakatan
        elseif($post['hk_angsuran'] == '' & $post['hk_tgl_bayar'] != ''){
            $params = array("success" => false, "status" => 21);
        }
        elseif($post['hk_angsuran'] != '' & $post['hk_tgl_bayar'] == ''){
            $params = array("success" => false, "status" => 22);
        }

        //data pasangan
        elseif($post['status_menikah'] == 'Sudah' & $post['nik_p'] == ''){
            $params = array("success" => false, "status" => 30);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['nama_p'] == ''){
            $params = array("success" => false, "status" => 31);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['nohp_p'] == ''){
            $params = array("success" => false, "status" => 32);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['email_p'] == ''){
            $params = array("success" => false, "status" => 33);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['jk_p'] == ''){
            $params = array("success" => false, "status" => 34);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['pekerjaan_p'] == ''){
            $params = array("success" => false, "status" => 35);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['tk_p'] == ''){
            $params = array("success" => false, "status" => 36);
        }
        elseif($post['status_menikah'] == 'Sudah' & $post['gaji_p'] == ''){
            $params = array("success" => false, "status" => 37);
        }
        else {

            $id_konsumen = $post['id_konsumen'];

            if($post['status_menikah'] == 'Sudah'){
                $cek_pasangan = $this->db->get_where('tbl_pasangan',['id_marketing' => $id_konsumen])->row();
                if($cek_pasangan){
                    // edit data pasangan
                    $data_pasangan = [
                        'nik' => $post['nik_p'],
                        'nama' => $post['nama_p'],
                        'no_hp' => $post['nohp_p'],
                        'email' => $post['email_p'],
                        'jk' => $post['jk_p'],
                        'pekerjaan' => $post['pekerjaan_p'],
                        'tempat_kerja' => $post['tk_p'],
                        'gaji' => $post['gaji_p']
                    ];
                    $this->db->where('id_marketing', $id_konsumen)->update('tbl_pasangan', $data_pasangan);
                } else {

                    // add data pasangan
                    $data_pasangan = [
                        'id_marketing' => $post['id_konsumen'],
                        'nik' => $post['nik_p'],
                        'nama' => $post['nama_p'],
                        'no_hp' => $post['nohp_p'],
                        'email' => $post['email_p'],
                        'jk' => $post['jk_p'],
                        'pekerjaan' => $post['pekerjaan_p'],
                        'tempat_kerja' => $post['tk_p'],
                        'gaji' => $post['gaji_p']
                    ];
                    $this->db->insert('tbl_pasangan', $data_pasangan);
                }
            } else {
                $this->db->delete('tbl_pasangan',['id_marketing'=>$id_konsumen]);
            }

            //data konsumen
            $data_konsumen = [
                'nik' => $post['nik'],
                'nama_konsumen' => $post['nama'],
                'jk' => $post['jk'],
                'no_hp' => $post['no_hp'],
                'pekerjaan' => $post['pekerjaan'],
                'alamat' => $post['alamat'],
                'email' => $post['email'],
                'status_menikah' => $post['status_menikah'],
                'tempat_kerja' => $post['tempat_kerja'],
                'gaji' => $post['gaji'],
                'dapat_info' => $post['info']
            ];

            if($this->db->where('id_marketing' , $id_konsumen)->update('tbl_marketing', $data_konsumen)){
                $data_inhouse = [
                    'tanda_jadi' => $post['tanda_jadi'],
                    'tgl_tanda_jadi' => $post['tgl_tanda_jadi']
                ];
                if($this->db->where('id_konsumen' , $id_konsumen)->update('tbl_transaksi_inhouse', $data_inhouse)){


                    //update tanda jadi lokasi
                    $tjl = $this->db->get_where('tanda_jadi_lokasi_inhouse',['id_konsumen' => $id_konsumen])->row();
                    if($tjl == null){
                        if($post['tjl_tgl_bayar'] >= date("d")){
                            $tjl_angsur = $post['tjl_angsur'] - 1;
                            for($i =0; $i<=$tjl_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['tjl_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_tjl' => $post['tjl'],
                                    'angsuran' => $post['tjl_angsur'],
                                    'cicilan_angsuran' => $post['tjl_angsuran'],
                                    'tgl_bayar' => $post['tjl_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('tanda_jadi_lokasi_inhouse', $data);
                            }
                        } else if($post['tjl_tgl_bayar'] < date("d")) {
                            $tjl_angsur = $post['tjl_angsur'];
                            for($i =1; $i<=$tjl_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['tjl_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_tjl' => $post['tjl'],
                                    'angsuran' => $post['tjl_angsur'],
                                    'cicilan_angsuran' => $post['tjl_angsuran'],
                                    'tgl_bayar' => $post['tjl_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('tanda_jadi_lokasi_inhouse', $data);
                            }
                        }
                    }
                    else if($post['tjl'] == $tjl->jml_tjl & $post['tjl_angsur'] == $tjl->angsuran & $post['tjl_tgl_bayar'] == $tjl->tgl_bayar){
                        //return true
                    } else {
                    $this->db->delete('tanda_jadi_lokasi_inhouse',['id_konsumen' => $id_konsumen]);
                        if($post['tjl_tgl_bayar'] >= date("d")){
                            $tjl_angsur = $post['tjl_angsur'] - 1;
                            for($i =0; $i<=$tjl_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['tjl_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_tjl' => $post['tjl'],
                                    'angsuran' => $post['tjl_angsur'],
                                    'cicilan_angsuran' => $post['tjl_angsuran'],
                                    'tgl_bayar' => $post['tjl_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('tanda_jadi_lokasi_inhouse', $data);
                            }
                        } else if($post['tjl_tgl_bayar'] < date("d")) {
                            $tjl_angsur = $post['tjl_angsur'];
                            for($i =1; $i<=$tjl_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['tjl_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_tjl' => $post['tjl'],
                                    'angsuran' => $post['tjl_angsur'],
                                    'cicilan_angsuran' => $post['tjl_angsuran'],
                                    'tgl_bayar' => $post['tjl_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('tanda_jadi_lokasi_inhouse', $data);
                            }
                        }
                    }



                    //update uang muka
                    $um = $this->db->get_where('uang_muka_inhouse',['id_konsumen' => $id_konsumen])->row();
                    if($um == null){
                        if($post['um_tgl_bayar'] >= date("d")){
                            $um_angsur = $post['um_angsur'] - 1;
                            for($i =0; $i<=$um_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['um_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_um' => $post['um'],
                                    'angsuran' => $post['um_angsur'],
                                    'cicilan_angsuran' => $post['um_angsuran'],
                                    'tgl_bayar' => $post['um_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('uang_muka_inhouse', $data);
                            }
                        } else if($post['um_tgl_bayar'] < date("d")) {
                            $um_angsur = $post['um_angsur'];
                            for($i =1; $i<=$um_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['um_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_um' => $post['um'],
                                    'angsuran' => $post['um_angsur'],
                                    'cicilan_angsuran' => $post['um_angsuran'],
                                    'tgl_bayar' => $post['um_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('uang_muka_inhouse', $data);
                            }
                        }
                    }
                    else if($post['um'] == $um->jml_um & $post['um_angsur'] == $um->angsuran & $post['um_tgl_bayar'] == $um->tgl_bayar){
                        //return true
                    }
                    else {
                    $this->db->delete('uang_muka_inhouse',['id_konsumen' => $id_konsumen]);
                        if($post['um_tgl_bayar'] >= date("d")){
                            $um_angsur = $post['um_angsur'] - 1;
                            for($i =0; $i<=$um_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['um_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_um' => $post['um'],
                                    'angsuran' => $post['um_angsur'],
                                    'cicilan_angsuran' => $post['um_angsuran'],
                                    'tgl_bayar' => $post['um_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('uang_muka_inhouse', $data);
                            }
                        } else if($post['um_tgl_bayar'] < date("d")) {
                            $um_angsur = $post['um_angsur'];
                            for($i =1; $i<=$um_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['um_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_um' => $post['um'],
                                    'angsuran' => $post['um_angsur'],
                                    'cicilan_angsuran' => $post['um_angsuran'],
                                    'tgl_bayar' => $post['um_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('uang_muka_inhouse', $data);
                            }
                        }
                    }



                    //update kelebihan tanah
                    $kt = $this->db->get_where('kelebihan_tanah_inhouse',['id_konsumen' => $id_konsumen])->row();
                    if($kt == null){
                        if($post['kt_tgl_bayar'] >= date("d")){
                            $kt_angsur = $post['kt_angsur'] - 1;
                            for($i =0; $i<=$kt_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['kt_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_kt' => $post['kt'],
                                    'angsuran' => $post['kt_angsur'],
                                    'cicilan_angsuran' => $post['kt_angsuran'],
                                    'tgl_bayar' => $post['kt_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('kelebihan_tanah_inhouse', $data);
                            }
                        } else if($post['kt_tgl_bayar'] < date("d")) {
                            $kt_angsur = $post['kt_angsur'];
                            for($i =1; $i<=$kt_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['kt_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_kt' => $post['kt'],
                                    'angsuran' => $post['kt_angsur'],
                                    'cicilan_angsuran' => $post['kt_angsuran'],
                                    'tgl_bayar' => $post['kt_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('kelebihan_tanah_inhouse', $data);
                            }
                        }
                    }
                    else if($post['kt'] == $kt->jml_kt & $post['kt_angsur'] == $kt->angsuran & $post['kt_tgl_bayar'] == $kt->tgl_bayar){
                        //return true
                    } else {
                    $this->db->delete('kelebihan_tanah_inhouse',['id_konsumen' => $id_konsumen]);
                        if($post['kt_tgl_bayar'] >= date("d")){
                            $kt_angsur = $post['kt_angsur'] - 1;
                            for($i =0; $i<=$kt_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['kt_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_kt' => $post['kt'],
                                    'angsuran' => $post['kt_angsur'],
                                    'cicilan_angsuran' => $post['kt_angsuran'],
                                    'tgl_bayar' => $post['kt_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('kelebihan_tanah_inhouse', $data);
                            }
                        } else if($post['kt_tgl_bayar'] < date("d")) {
                            $kt_angsur = $post['kt_angsur'];
                            for($i =1; $i<=$kt_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['kt_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_kt' => $post['kt'],
                                    'angsuran' => $post['kt_angsur'],
                                    'cicilan_angsuran' => $post['kt_angsuran'],
                                    'tgl_bayar' => $post['kt_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('kelebihan_tanah_inhouse', $data);
                            }
                        }
                    }



                    //update Harga kesepakatan
                    $hk = $this->db->get_where('harga_kesepakatan_inhouse',['id_konsumen' => $id_konsumen])->row();
                    if($hk == null){
                        if($post['hk_tgl_bayar'] >= date("d")){
                            $hk_angsur = $post['hk_angsur'] - 1;
                            for($i =0; $i<=$hk_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['hk_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_kesepakatan' => $post['hk'],
                                    'angsuran' => $post['hk_angsur'],
                                    'cicilan_angsuran' => $post['hk_angsuran'],
                                    'tgl_bayar' => $post['hk_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('harga_kesepakatan_inhouse', $data);
                            }
                        } else if($post['hk_tgl_bayar'] < date("d")) {
                            $hk_angsur = $post['hk_angsur'];
                            for($i =1; $i<=$hk_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['hk_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_kesepakatan' => $post['hk'],
                                    'angsuran' => $post['hk_angsur'],
                                    'cicilan_angsuran' => $post['hk_angsuran'],
                                    'tgl_bayar' => $post['hk_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('harga_kesepakatan_inhouse', $data);
                            }
                        }
                    }
                    else if($post['hk'] == $hk->jml_kesepakatan & $post['hk_angsur'] == $hk->angsuran & $post['hk_tgl_bayar'] == $hk->tgl_bayar){
                        //return true
                    } else {
                    $this->db->delete('harga_kesepakatan_inhouse',['id_konsumen' => $id_konsumen]);
                        if($post['hk_tgl_bayar'] >= date("d")){
                            $hk_angsur = $post['hk_angsur'] - 1;
                            for($i =0; $i<=$hk_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['hk_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_kesepakatan' => $post['hk'],
                                    'angsuran' => $post['hk_angsur'],
                                    'cicilan_angsuran' => $post['hk_angsuran'],
                                    'tgl_bayar' => $post['hk_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('harga_kesepakatan_inhouse', $data);
                            }
                        } else if($post['hk_tgl_bayar'] < date("d")) {
                            $hk_angsur = $post['hk_angsur'];
                            for($i =1; $i<=$hk_angsur; $i++){
                                $date = mktime(0,0,0, date("m")+$i, date($post['hk_tgl_bayar']), date("Y"));
                                $date = date("Y-m-d", $date);
        
                                $data = [
                                    'id_konsumen' => $id_konsumen,
                                    'jml_kesepakatan' => $post['hk'],
                                    'angsuran' => $post['hk_angsur'],
                                    'cicilan_angsuran' => $post['hk_angsuran'],
                                    'tgl_bayar' => $post['hk_tgl_bayar'],
                                    'status' => 0,
                                    'jatuh_tempo' => $date
                                ];
                                $this->db->insert('harga_kesepakatan_inhouse', $data);
                            }
                        }
                    }




                    $params = array("success" => true);
                } else {
                    $params = array("success" => false);
                }
            } else {
                $params = array("success" => false);
            }


        }


        echo json_encode($params);

    }

    public function ajukan_fee_marketing(){
       $img = $_FILES['foto'];
        if($img){
            $config['upload_path']          = './assets/upload/fee-marketing/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            if($this->upload->do_upload('foto')){
                $bukti = $this->upload->data('file_name');
            } else {
                echo $this->upload->display_errors();
            }
            
        } else {
            echo $this->upload->display_errors();
        }

        $data = [
            'status_fee_marketing' => 1,
            'img_fee_marketing' => $bukti,
            'nominal_fee_marketing' => $this->input->post('nominal')
        ];

        $id_konsumen = $this->input->post('id_konsumen');
        if($this->db->where('id_marketing', $id_konsumen)->update('tbl_marketing', $data)){
            $this->session->set_flashdata('true', 'Pengajuan Fee Marketing Berhasil');
            redirect('marketing/konsumen');
        } else {
            $this->session->set_flashdata('false', 'Pengajuan Fee Marketing Gagal');
            redirect('marketing/konsumen');
        }


    }


    public function detail_fee_marketing(){
        $id = $_POST['id'];
        $data['marketing'] = $this->db->get_where('tbl_marketing',['id_marketing' => $id])->row();
        $this->load->view('marketing/detail_fee_marketing', $data);
    }


    public function acc_fee_marketing(){
        $id = $_POST['id'];
        if($this->db->set('status_fee_marketing', 2)->where('id_marketing', $id)->update('tbl_marketing')){
            $params = array("success" => true);
        } else {
            $params = array("success" => false);
        }
        echo json_encode($params);
    }


    public function transaksi_batal(){
        // $data['batal'] = $this->db->get_where('tbl_marketing',['status' => 9])->result();
        $id_perumahan = $this->session->userdata('id_perumahan');
        // $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling WHERE tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_kavling.id_perum = $id_perumahan AND tbl_marketing.status = 9";
        // $data['bank'] = $this->db->query($q)->result();
        // $data['bank'] = $this->db->get_where('tbl_marketing',['status' => 0])->result();

        $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling WHERE tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_kavling.id_perum = $id_perumahan AND tbl_marketing.status = 0";
        $data['bank'] = $this->db->query($q)->result();

        $p = "SELECT * FROM tbl_transaksi_inhouse, tbl_marketing, tbl_kavling WHERE tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND tbl_transaksi_inhouse.id_konsumen = tbl_marketing.id_marketing AND tbl_kavling.id_perum = $id_perumahan AND tbl_marketing.status = 0";
        $data['inhouse'] = $this->db->query($p)->result();

        $this->template->load('template', 'marketing/transaksi_batal', $data);
    }

    public function view_all_transaksi_konsumen(){
        $id = $_POST['id'];

        $q = "SELECT * FROM tbl_transaksi_bank JOIN tbl_kavling ON tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling JOIN tbl_tipe ON tbl_kavling.id_tipe = tbl_tipe.id_tipe WHERE tbl_transaksi_bank.id_konsumen = $id";
        $data['bank'] = $this->db->query($q)->row();

        $data['tanda_jadi_lokasi_bank'] = $this->db->get_where('tanda_jadi_lokasi',['id_konsumen' => $id])->row();
        $data['uang_muka_bank'] = $this->db->get_where('uang_muka',['id_konsumen' => $id])->row();
        $data['kelebihan_tanah_bank'] = $this->db->get_where('kelebihan_tanah',['id_konsumen' => $id])->row();
        $data['pak'] = $this->db->get_where('pak',['id_konsumen' => $id])->row();
        $data['lain_bank'] = $this->db->get_where('lain_lain',['id_konsumen' => $id])->row();

        $q = "SELECT * FROM tbl_transaksi_inhouse JOIN tbl_kavling ON tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling JOIN tbl_tipe ON tbl_kavling.id_tipe = tbl_tipe.id_tipe WHERE tbl_transaksi_inhouse.id_konsumen = $id";
        $data['inhouse'] = $this->db->query($q)->row();
        $data['kesepakatan'] = $this->db->get_where('harga_kesepakatan_inhouse',['id_konsumen' => $id])->row();
        $data['tanda_jadi_lokasi_inhouse'] = $this->db->get_where('tanda_jadi_lokasi_inhouse',['id_konsumen' => $id])->row();
        $data['uang_muka_inhouse'] = $this->db->get_where('uang_muka_inhouse',['id_konsumen' => $id])->row();
        $data['kelebihan_tanah_inhouse'] = $this->db->get_where('kelebihan_tanah_inhouse',['id_konsumen' => $id])->row();

        $data['konsumen'] = $this->db->get_where('tbl_marketing',['id_marketing' => $id])->row();
        $data['pasangan'] = $this->db->get_where('tbl_pasangan',['id_marketing' => $id])->row();

        $this->load->view('marketing/all_transaksi', $data);
    }



    //cetak surat
    
    public function cek_pembayaran_spkb(){

        $id = $_POST['id'];
        $bank = $this->db->get_where('tbl_transaksi_bank',['id_konsumen' => $id])->row();
        $inhouse = $this->db->get_where('tbl_transaksi_inhouse',['id_konsumen' => $id])->row();

        if($bank){
            $tjl_b = $this->db->get_where('tanda_jadi_lokasi',['id_konsumen' => $id, 'status' != 0])->num_rows();
            $um_b = $this->db->get_where('uang_muka',['id_konsumen' => $id, 'status' != 0])->num_rows();
            $kt_b = $this->db->get_where('kelebihan_tanah',['id_konsumen' => $id, 'status' != 0])->num_rows();
            $pak_b = $this->db->get_where('pak',['id_konsumen' => $id, 'status' != 0])->num_rows();
            $lain_b = $this->db->get_where('lain_lain',['id_konsumen' => $id, 'status' != 0])->num_rows();
            $angsur_b = $this->db->get_where('angsuran_bank',['id_konsumen' => $id, 'status' != 0])->num_rows();
            $piutang_b = $this->db->get_where('piutang_bank',['id_konsumen' => $id, 'status' != 0])->num_rows();
            $tj_b = $this->db->get_where('tbl_transaksi_bank',['id_konsumen' => $id, 'status' != 0])->num_rows();

            $param = [
                'type' => 'bank',
                'tjl' => $tjl_b,
                'um' => $um_b,
                'kt' => $kt_b,
                'pak' => $pak_b,
                'lain' => $lain_b,
                'angsur' => $angsur_b,
                'piutang' => $piutang_b,
                'tj' => $tj_b
            ];

        } else if($inhouse){
            $hk_i = $this->db->get_where('harga_kesepakatan_inhouse',['id_konsumen' => $id, 'status' != 0])->num_rows();
            $um_i = $this->db->get_where('uang_muka_inhouse',['id_konsumen' => $id, 'status' != 0])->num_rows();
            $kt_i = $this->db->get_where('kelebihan_tanah_inhouse',['id_konsumen' => $id, 'status' != 0])->num_rows();
            $tjl_i = $this->db->get_where('tanda_jadi_lokasi_inhouse',['id_konsumen' => $id, 'status' != 0])->num_rows();
            $tj_i = $this->db->get_where('tbl_transaksi_inhouse',['id_konsumen' => $id, 'status' != 0])->num_rows();
            
            $param = [
                'type' => 'inhouse',
                'hk' => $hk_i,
                'um' => $um_i,
                'kt' => $kt_i,
                'tjl' => $tjl_i,
                'tj' => $tj_i
            ];

        }
        echo json_encode($param);

    }

    public function gen_spkb(){ 
        $id = $this->input->post('id_konsumen');

        if(empty($id)){
            redirect('marketing/transaksi_batal');
        }

        //bank
        $tjl = $this->input->post('tjl');
        $um = $this->input->post('um');
        $kt = $this->input->post('kt');
        $pak = $this->input->post('pak');
        $lain = $this->input->post('lain');
        $angsuran = $this->input->post('angsur');
        $piutang = $this->input->post('piutang');
        $tj = $this->input->post('tj');

        //inhouse
        $hk_i = $this->input->post('hk_i');
        $um_i = $this->input->post('um_i');
        $kt_i = $this->input->post('kt_i');
        $tjl_i = $this->input->post('tjl_i');
        $tj_i = $this->input->post('tj_i');

        

        $data['konsumen'] = $this->db->get_where('tbl_marketing',['id_marketing' => $id])->row();
        $status_perum = $this->db->get_where('tbl_perumahan',['id_perumahan' => $this->session->userdata('id_perumahan')])->row()->cluster;
        $data['status_perum'] = $status_perum;
        $data['admin'] = $this->session->userdata('nama');
        //cek data konsumen
        $bank = $this->db->get_where('tbl_transaksi_bank',['id_konsumen' => $id])->row();
        if($bank){
            //ambil data dari transaksi bank

            if($status_perum == 1){
                $r = "SELECT * FROM tbl_transaksi_bank, tbl_kavling, tbl_perumahan, tbl_cluster, tbl_tipe WHERE tbl_transaksi_bank.id_konsumen = $id AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tbl_kavling.id_perum = tbl_perumahan.id_perumahan AND tbl_kavling.id_cluster = tbl_cluster.id_cluster AND tbl_tipe.id_tipe = tbl_kavling.id_tipe";
            } else if($status_perum == 0) {
                $r = "SELECT * FROM tbl_transaksi_bank, tbl_kavling, tbl_perumahan, tbl_tipe WHERE tbl_transaksi_bank.id_konsumen = $id AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tbl_kavling.id_perum = tbl_perumahan.id_perumahan AND tbl_tipe.id_tipe = tbl_kavling.id_tipe";
            }

            $data['transaksi'] = 1;
           
            if($tjl){
                $angs = $this->db->get_where('tanda_jadi_lokasi',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('bank_cicil_tjl',['id_pembayaran' => $a->id_tjl])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }

                $data['tjl'] = $jml;
                if(empty($data['tjl'])){
                    $data['tjl'] = 0;
                }
                $c_tjl = $data['tjl'];
            } else {
                $c_tjl = 0;
            }

            if($um){
                
                $angs = $this->db->get_where('uang_muka',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('bank_cicil_um',['id_pembayaran' => $a->id_um])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $data['um'] = $jml;
                if(empty($data['um'])){
                    $data['um'] = 0;
                }
                $c_um = $data['um'];
            } else {
                $c_um = 0;
            }

            if($kt){
                $angs = $this->db->get_where('kelebihan_tanah',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('bank_cicil_kt',['id_pembayaran' => $a->id_kt])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $data['kt'] = $jml;
                if(empty($data['kt'])){
                    $data['kt'] = 0;
                }
                $c_kt = $data['kt'];
            } else {
                $c_kt = 0;
            }

            if($pak){
                $angs = $this->db->get_where('pak',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('bank_cicil_pak',['id_pembayaran' => $a->id_pak])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $data['pak'] = $jml;
                if(empty($data['pak'])){
                    $data['pak'] = 0;
                }
                $c_pak = $data['pak'];
            } else {
                $c_pak = 0;
            }

            if($lain){
                $angs = $this->db->get_where('lain_lain',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('bank_cicil_lain',['id_pembayaran' => $a->id_lain])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $data['lain'] = $jml;
                if(empty($data['lain'])){
                    $data['lain'] = 0;
                }
                $c_lain = $data['lain'];
            } else {
                $c_lain = 0;
            }

            if($angsuran){
                $angs = $this->db->get_where('angsuran_bank',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('bank_cicil_rb',['id_pembayaran' => $a->id_angsur])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $data['angsuran'] = $jml;
                if(empty($data['angsuran'])){
                    $data['angsuran'] = 0;
                }
                $c_angsuran = $data['angsuran'];
            } else {
                $c_angsuran = 0;
            }

            if($piutang){
                $angs = $this->db->get_where('piutang_bank',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('bank_cicil_pb',['id_pembayaran' => $a->id_piutang])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $data['piutang'] = $jml;
                if(empty($data['piutang'])){
                    $data['piutang'] = 0;
                }
                $c_piutang = $data['piutang'];
            } else {
                $c_piutang = 0;
            }

            if($tj){
                $tj = $this->db->get_where('tbl_transaksi_bank',['id_konsumen' => $id])->row();
                $jml = 0;
                $cicil = $this->db->get_where('bank_cicil_tj',['id_pembayaran' => $tj->id_transaksi_bank])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                
                $data['tj'] = $jml;
                $c_tj = $jml;
            } else {
                $c_tj = 0;
            }

            $data['jumlah'] = $c_tjl + $c_um + $c_kt + $c_pak + $c_lain + $c_angsuran + $c_piutang + $c_tj;
            $data['rumah'] = $this->db->query($r)->row();

        } else {
            //ambil data dari transaksi inhouse

            if($status_perum == 1){
                $r = "SELECT * FROM tbl_transaksi_inhouse, tbl_kavling, tbl_perumahan, tbl_cluster, tbl_tipe WHERE tbl_transaksi_inhouse.id_konsumen = $id AND tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND tbl_kavling.id_perum = tbl_perumahan.id_perumahan AND tbl_kavling.id_cluster = tbl_cluster.id_cluster AND tbl_tipe.id_tipe = tbl_kavling.id_tipe";
            } else if($status_perum == 0){
                $r = "SELECT * FROM tbl_transaksi_inhouse, tbl_kavling, tbl_perumahan, tbl_tipe WHERE tbl_transaksi_inhouse.id_konsumen = $id AND tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND tbl_kavling.id_perum = tbl_perumahan.id_perumahan AND tbl_tipe.id_tipe = tbl_kavling.id_tipe";
            }

            if($hk_i){
                $angs = $this->db->get_where('harga_kesepakatan_inhouse',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('inhouse_cicil_hk',['id_pembayaran' => $a->id_kesepakatan])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $data['hk_i'] = $jml;
                if(empty($data['hk_i'])){
                    $data['hk_i'] = 0;
                }
                $c_hk_i = $data['hk_i'];
            } else {
                $c_hk_i = 0;
            }

            if($um_i){
                $angs = $this->db->get_where('uang_muka_inhouse',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('inhouse_cicil_um',['id_pembayaran' => $a->id_um])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $data['um_i'] = $jml;
                if(empty($data['um_i'])){
                    $data['um_i'] = 0;
                }
                $c_um_i = $data['um_i'];
            } else {
                $c_um_i = 0;
            }

            if($kt_i){
                $angs = $this->db->get_where('kelebihan_tanah_inhouse',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('inhouse_cicil_kt',['id_pembayaran' => $a->id_kt])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $data['kt_i'] = $jml;
                if(empty($data['kt_i'])){
                    $data['kt_i'] = 0;
                }
                $c_kt_i = $data['kt_i'];
            } else {
                $c_kt_i = 0;
            }

            if($tjl_i){
                $angs = $this->db->get_where('tanda_jadi_lokasi_inhouse',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('inhouse_cicil_tjl',['id_pembayaran' => $a->id_tjl])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $data['tjl_i'] = $jml;
                if(empty($data['tjl_i'])){
                    $data['tjl_i'] = 0;
                }
                $c_tjl_i = $data['tjl_i'];
            } else {
                $c_tjl_i = 0;
            }

            if($tj_i){
                // $tanda_jadi = $this->db->get_where('tbl_transaksi_inhouse',['id_konsumen' => $id])->row()->tanda_jadi;
                // $data['tj_i'] = $tanda_jadi;

                $tj = $this->db->get_where('tbl_transaksi_inhouse',['id_konsumen' => $id])->row();
                $jml = 0;
                $cicil = $this->db->get_where('inhouse_cicil_tj',['id_pembayaran' => $tj->id_inhouse])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                
                $data['tj_i'] = $jml;
                $c_tj = $jml;

            } else {
                $c_tj = 0;
            }

            $data['jumlah'] = $c_hk_i + $c_um_i + $c_kt_i + $c_tjl_i + $c_tj;
            $data['transaksi'] = 2;
            $data['rumah'] = $this->db->query($r)->row();
        }

      $html = $this->load->view('kpr/gen_spkb', $data, true);
        // $this->load->view('kpr/gen_spkb', $data);
       return $this->gen_pdf($html);
        
    }

    public function gen_spr($id){
        $data['konsumen'] = $this->db->get_where('tbl_marketing',['id_marketing' => $id])->row();
        $status_perum = $this->db->get_where('tbl_perumahan',['id_perumahan' => $this->session->userdata('id_perumahan')])->row()->cluster;
        $data['status_perum'] = $status_perum;
        //cek data konsumen
        $bank = $this->db->get_where('tbl_transaksi_bank',['id_konsumen' => $id])->row();
        $data['admin'] = $this->session->userdata('nama');
        if($bank){
            //ambil data dari transaksi bank

            if($status_perum == 0){
                $r = "SELECT * FROM tbl_transaksi_bank, tbl_kavling, tbl_perumahan, tbl_tipe WHERE tbl_transaksi_bank.id_konsumen = $id AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tbl_kavling.id_perum = tbl_perumahan.id_perumahan AND tbl_tipe.id_tipe = tbl_kavling.id_tipe";
            } else if($status_perum == 1){
                $r = "SELECT * FROM tbl_transaksi_bank, tbl_kavling, tbl_perumahan, tbl_cluster, tbl_tipe WHERE tbl_transaksi_bank.id_konsumen = $id AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tbl_kavling.id_perum = tbl_perumahan.id_perumahan AND tbl_kavling.id_cluster = tbl_cluster.id_cluster AND tbl_tipe.id_tipe = tbl_kavling.id_tipe";
            }

            $data['transaksi'] = 1;
            $data['kpr'] = $this->db->get_where('tbl_transaksi_bank',['id_konsumen' => $id])->row()->harga_kesepakatan;
            $data['rumah'] = $this->db->query($r)->row();
            $data['um'] = $this->db->get_where('uang_muka',['id_konsumen' => $id])->result();
            $data['tjl'] = $this->db->get_where('tanda_jadi_lokasi',['id_konsumen' => $id])->result();
            $data['kt'] = $this->db->get_where('kelebihan_tanah',['id_konsumen' => $id])->result();
            $data['uang_muka'] = $this->db->get_where('uang_muka',['id_konsumen' => $id])->row();
            $data['pak'] = $this->db->get_where('pak',['id_konsumen' => $id])->result();
            $data['lain'] = $this->db->get_where('lain_lain',['id_konsumen' => $id])->result();
            $data['angsuran'] = $this->db->get_where('angsuran_bank',['id_konsumen' => $id])->result();
            $data['piutang'] = $this->db->get_where('piutang_bank',['id_konsumen' => $id])->result();


        } else {
            //ambil data dari transaksi inhouse

            if($status_perum == 0){
                $r = "SELECT * FROM tbl_transaksi_inhouse, tbl_kavling, tbl_perumahan, tbl_cluster, tbl_tipe WHERE tbl_transaksi_inhouse.id_konsumen = $id AND tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND tbl_kavling.id_perum = tbl_perumahan.id_perumahan AND tbl_tipe.id_tipe = tbl_kavling.id_tipe";
            } else if($status_perum == 1){
                $r = "SELECT * FROM tbl_transaksi_inhouse, tbl_kavling, tbl_perumahan, tbl_cluster, tbl_tipe WHERE tbl_transaksi_inhouse.id_konsumen = $id AND tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND tbl_kavling.id_perum = tbl_perumahan.id_perumahan AND tbl_kavling.id_cluster = tbl_cluster.id_cluster AND tbl_tipe.id_tipe = tbl_kavling.id_tipe";
            }


            $data['transaksi'] = 2;
            $data['kpr'] = $this->db->get_where('harga_kesepakatan_inhouse',['id_konsumen' => $id])->row()->jml_kesepakatan;
            $data['rumah'] = $this->db->query($r)->row();
            $data['um'] = $this->db->get_where('uang_muka_inhouse',['id_konsumen' => $id])->result();
            $data['tjl'] = $this->db->get_where('tanda_jadi_lokasi_inhouse',['id_konsumen' => $id])->result();
            $data['kt'] = $this->db->get_where('kelebihan_tanah_inhouse',['id_konsumen' => $id])->result();
            $data['hk'] = $this->db->get_where('harga_kesepakatan_inhouse',['id_konsumen' => $id])->result();
            $data['uang_muka'] = $this->db->get_where('uang_muka_inhouse',['id_konsumen' => $id])->row();
        
        }


        //update status print spr
        // $this->db->set('spr', 1)->where('id_marketing', $id)->update('tbl_marketing');

        $html = $this->load->view('kpr/gen_spr', $data, true);
        return $this->gen_pdf($html);

        // $this->load->view('kpr/gen_spr', $data);
    }


    public function gen_pdf($html){
        require FCPATH . 'assets/mpdf/vendor/autoload.php';
        $pdf = new \Mpdf\Mpdf();
        // $html = str_replace('{PAGECNT}', $this->getPageCount(), $html);

        ob_start();
        echo $html;
        $html1 = ob_get_contents();
        ob_end_clean();

        $pdf->setFooter('{PAGENO} dari halaman 1');
        $pdf->WriteHTML($html1);
        $pdf->Output();
    }



    public function add_bukti_spr(){
        $img = $_FILES['userfile'];
        $type = 'gif|jpeg|png|jpg|pdf';
        if($img){
            $config['upload_path']          = './assets/surat/spr/';
            $config['allowed_types']        = $type;

            $this->load->library('upload', $config);
            if($this->upload->do_upload('userfile')){
                $bukti_spr = $this->upload->data();
                // print_r($this->upload->data());
                // die;
            } else {
                $this->session->set_flashdata('false', 'kesalahan saat upload file, harap coba kembali');
            redirect('marketing/konsumen');
            // $this->upload->display_errors();
            }
        } else {
            $this->session->set_flashdata('false', 'kesalahan saat upload foto, harap coba kembali');
            redirect('marketing/konsumen');
        }

        $data = [
            'id_konsumen' => $this->input->post('id_konsumen'),
            'bukti_spr' => $bukti_spr['file_name'],
            'file_type' => $bukti_spr['file_ext']
         ];
        // var_dump($data);die;
        if($this->db->insert('bukti_spr', $data)){

            //update status spr konsumen
            $this->db->set('spr', 1)->where('id_marketing', $this->input->post('id_konsumen'))->update('tbl_marketing');


            $this->session->set_flashdata('true', 'Bukti SPR berhasil di tamabahkan');
            redirect('marketing/konsumen');
        } else {
            $this->session->set_flashdata('false', 'Bukti SPR gagal di tamabahkan');
            redirect('marketing/konsumen');
        }

    }

    public function get_bukti_spr(){
        $id = $_POST['id'];
        $data['bukti_spr'] = $this->db->get_where('bukti_spr',['id_konsumen' => $id])->result();
        $this->load->view('marketing/bukti_spr', $data);
    }

    public function delete_bukti_spr($id){
        $img = $this->db->get_where('bukti_spr',['id_bukti_spr' => $id])->row()->bukti_spr;

        unlink(FCPATH .'assets/surat/spr/'. $img);
        if($this->db->delete('bukti_spr',['id_bukti_spr' => $id])){
            $this->session->set_flashdata('true', 'Bukti SPR berhasil di hapus');
            redirect('marketing/konsumen');
        } else {
            $this->session->set_flashdata('false', 'Bukti SPR gagal di hapus');
            redirect('marketing/konsumen');
        }

    }


    public function add_bukti_spkb(){
        $img = $_FILES['bukti_spkb'];
        if($img){
            $config['upload_path']          = './assets/surat/spkb/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';
            $this->load->library('upload', $config);

            if($this->upload->do_upload('bukti_spkb')){
                $bukti_spkb = $this->upload->data();
            } else {
                $this->session->set_flashdata('false', 'kesalahan saat upload foto');
            redirect('marketing/transaksi_batal');  
            }
        } else {
            $this->session->set_flashdata('false', 'kesalahan saat upload foto');
            redirect('marketing/transaksi_batal');  
        }

        $data = [
            'id_konsumen' => $this->input->post('id_konsumen'),
            'bukti_spkb' => $bukti_spkb['file_name'],
            'file_type' => $bukti_spkb['file_ext']
        ];

        if($this->db->insert('bukti_spkb', $data)){
            $this->session->set_flashdata('true', 'Bukti SPKB berhasil ditambahkan');
            redirect('marketing/transaksi_batal');  
        } else {
            $this->session->set_flashdata('false', 'Bukti SPKB gagal ditambahkan');
            redirect('marketing/transaksi_batal');  
        }

    }


    public function get_bukti_spkb(){
        $id = $_POST['id'];
        $data['bukti_spkb'] = $this->db->get_where('bukti_spkb',['id_konsumen' => $id])->result();
        $this->load->view('marketing/bukti_spkb', $data);
    }


    public function delete_bukti_spkb($id){
        $img = $this->db->get_where('bukti_spkb',['id_bukti_spkb' => $id])->row()->bukti_spkb;

        unlink(FCPATH .'assets/surat/spkb/'. $img);

        if($this->db->delete('bukti_spkb',['id_bukti_spkb' => $id])){
            $this->session->set_flashdata('true', 'Bukti SPKB berhasil di hapus');
            redirect('marketing/transaksi_batal');
        } else {
            $this->session->set_flashdata('false', 'Bukti SPKB gagal di hapus');
            redirect('marketing/transaksi_batal');
        }
    }

    public function get_status_menikah(){
        $id = $_POST['id'];
        $status_menikah = $this->db->get_where('tbl_pasangan',['id_marketing' => $id])->num_rows();
        echo json_encode($status_menikah);
    }

    public function get_pasangan(){
        $id = $_POST['id'];
        $pasangan = $this->db->get_where('tbl_pasangan',['id_marketing' => $id])->row();
        echo json_encode($pasangan);
    }

    public function pembatalan_to_accounting(){

        $id = $this->input->post('id_konsumen');

        //bank
        $tjl = $this->input->post('tjl');
        $um = $this->input->post('um');
        $kt = $this->input->post('kt');
        $pak = $this->input->post('pak');
        $lain = $this->input->post('lain');
        $angsuran = $this->input->post('angsur');
        $piutang = $this->input->post('piutang');
        $tj = $this->input->post('tj');

        //inhouse
        $hk_i = $this->input->post('hk_i');
        $um_i = $this->input->post('um_i');
        $kt_i = $this->input->post('kt_i');
        $tjl_i = $this->input->post('tjl_i');
        $tj_i = $this->input->post('tj_i');

        $bank = $this->db->get_where('tbl_transaksi_bank',['id_konsumen' => $id])->row();

        if($bank){
            //jika transaksi bank
            if($tjl){
                $angs = $this->db->get_where('tanda_jadi_lokasi',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('bank_cicil_tjl',['id_pembayaran' => $a->id_tjl])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $bank_tjl = $jml;


                if(empty($bank_tjl)){
                    $bank_tjl = 0;
                }
                $count_bank_tjl = $bank_tjl;
                $data_bank_tjl = ['nominal' => $bank_tjl, 'keterangan' => 'Tanda Jadi Lokasi'];
            } else {
                $count_bank_tjl = 0;
                $data_bank_tjl = '';
            }

            if($um){
                $angs = $this->db->get_where('uang_muka',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('bank_cicil_um',['id_pembayaran' => $a->id_um])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $bank_um = $jml;

                if(empty($bank_um)){
                    $bank_um = 0;
                }
                $count_bank_um = $bank_um;
                $data_bank_um = ['nominal' => $bank_um, 'keterangan' => 'Uang Muka'];
            } else {
                $count_bank_um = 0;
                $data_bank_um = '';
            }

            if($kt){
                $angs = $this->db->get_where('kelebihan_tanah',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('bank_cicil_kt',['id_pembayaran' => $a->id_kt])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $bank_kt = $jml;
                if(empty($bank_kt)){
                    $bank_kt = 0;
                }
                $count_bank_kt = $bank_kt;
                $data_bank_kt = ['nominal' => $bank_kt, 'keterangan' => 'Kelebihan Tanah'];
            } else {
                $count_bank_kt = '';
                $data_bank_kt = 0;
            }

            if($pak){
                $angs = $this->db->get_where('pak',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('bank_cicil_pak',['id_pembayaran' => $a->id_pak])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $bank_pak = $jml;
                if(empty($bank_pak)){
                    $bank_pak = 0;
                }
                $count_bank_pak = $bank_pak;
                $data_bank_pak = ['nominal' => $bank_pak, 'keterangan' => 'PAK'];
            } else {
                $count_bank_pak = 0;
                $data_bank_pak = '';
            }

            if($lain){
                $angs = $this->db->get_where('lain_lain',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('bank_cicil_lain',['id_pembayaran' => $a->id_lain])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $bank_lain = $jml;
                if(empty($bank_lain)){
                    $bank_lain = 0;
                }
                $count_bank_lain = $bank_lain;
                $data_bank_lain = ['nominal' => $bank_lain, 'keterangan' => 'Lain lain'];
            } else {
                $count_bank_lain = 0;
                $data_bank_lain = '';
            }

            if($angsuran){
                $angs = $this->db->get_where('angsuran_bank',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('bank_cicil_rb',['id_pembayaran' => $a->id_angsur])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $bank_angsuran = $jml;
                if(empty($bank_angsuran)){
                    $bank_angsuran = 0;
                }
                $count_bank_angsuran = $bank_angsuran;
                $data_bank_angsuran = ['nominal' => $bank_angsuran, 'keterangan' => 'Angsuran Bank'];
            } else {
                $count_bank_angsuran = 0;
                $data_bank_angsuran = '';
            }

            if($piutang){
                $angs = $this->db->get_where('piutang_bank',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('bank_cicil_pb',['id_pembayaran' => $a->id_piutang])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $bank_piutang = $jml;
                if(empty($bank_piutang)){
                    $bank_piutang = 0;
                }
                $count_bank_piutang = $bank_piutang;
                $data_bank_piutang = ['nominal' => $bank_piutang, 'keterangan' => 'Piutang Bank'];
            } else {
                $count_bank_piutang = 0;
                $data_bank_piutang = '';
            }

            if($tj){
                $tj = $this->db->get_where('tbl_transaksi_bank',['id_konsumen' => $id])->row();
                $jml = 0;
                $cicil = $this->db->get_where('bank_cicil_tj',['id_pembayaran' => $tj->id_transaksi_bank])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }

                $tanda_jadi = $jml;

                $count_bank_tanda_jadi = $tanda_jadi;
                $data_bank_tj = ['nominal' => $tanda_jadi, 'keterangan' => 'Tanda Jadi'];
            } else {
                $count_bank_tanda_jadi = 0;
                $data_bank_tj = '';
            }

            $jumlah = $count_bank_tjl + $count_bank_um + $count_bank_kt + $count_bank_pak + $count_bank_lain + $count_bank_angsuran + $count_bank_piutang + $count_bank_tanda_jadi;

            $data = [
                'id_user' => $id,
                'status' => 1,
                'tgl_pembatalan' => date('Y-m-d'),
                'total_pengembalian' => $jumlah
            ];

        } else {
            //jika transaksi inhouse
            if($hk_i){
                $angs = $this->db->get_where('harga_kesepakatan_inhouse',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('inhouse_cicil_hk',['id_pembayaran' => $a->id_kesepakatan])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $inhouse_hk = $jml;
                if(empty($inhouse_hk)){
                    $inhouse_hk = 0;
                }
                $count_inhouse_hk = $inhouse_hk;
            } else {
                $count_inhouse_hk = 0;
            }

            if($um_i){
                $angs = $this->db->get_where('uang_muka_inhouse',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('inhouse_cicil_um',['id_pembayaran' => $a->id_um])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $inhouse_um = $jml;
                if(empty($inhouse_um)){
                    $inhouse_um = 0;
                }
                $count_inhouse_um = $inhouse_um;
            } else {
                $count_inhouse_um = 0;
            }

            if($kt_i){
                $angs = $this->db->get_where('kelebihan_tanah_inhouse',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('inhouse_cicil_kt',['id_pembayaran' => $a->id_kt])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $inhouse_kt = $jml;
                if(empty($inhouse_kt)){
                    $inhouse_kt = 0;
                }
                $count_inhouse_kt = $inhouse_kt;
            } else {
                $count_inhouse_kt = 0;
            }

            if($tjl_i){
                $angs = $this->db->get_where('tanda_jadi_lokasi_inhouse',['id_konsumen' => $id, 'status' != 0])->result();
                $jml = 0;
                foreach($angs as $a){
                    $cicil = $this->db->get_where('inhouse_cicil_tjl',['id_pembayaran' => $a->id_tjl])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                }
                $inhouse_tjl = $jml;
                if(empty($inhouse_tjl)){
                    $inhouse_tjl = 0;
                }
                $count_inhouse_tjl = $inhouse_tjl;
            } else {
                $count_inhouse_tjl = 0;
            }

            if($tj_i){
                $tj = $this->db->get_where('tbl_transaksi_inhouse',['id_konsumen' => $id])->row();
                $jml = 0;
                $cicil = $this->db->get_where('inhouse_cicil_tj',['id_pembayaran' => $tj->id_inhouse])->result();
                    foreach($cicil as $c){
                        $jml += $c->jumlah;
                    }
                $tanda_jadi = $jml;

                $count_inhouse_tj = $tanda_jadi;
            } else {
                $count_inhouse_tj = 0;
            }

            $jumlah = $count_inhouse_hk + $count_inhouse_um + $count_inhouse_kt + $count_inhouse_tjl + $count_inhouse_tj;

            $data = [
                'id_user' => $id,
                'status' => 1,
                'tgl_pembatalan' => date('Y-m-d'),
                'total_pengembalian' => $jumlah
            ];
        }

        $this->db->delete('pembatalan_transaksi',['id_user' => $id]);
        if($this->db->insert('pembatalan_transaksi', $data)){
            $this->session->set_flashdata('true', 'Pengembalian uang berhasil');
            redirect('marketing/transaksi_batal');
        } else {
            $this->session->set_flashdata('false', 'Pengembalian uang gagal');
            redirect('marketing/transaksi_batal');
        }

    }

    public function add_sertifikat(){
        $img = $_FILES['file'];
        if($img){
            $config['upload_path']          = './assets/surat/sertifikat/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            if($this->upload->do_upload('file')){
                $sertifikat = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('false','Kesalahan saat upload file');
                redirect('marketing/konsumen');
            }
        } else {
            $this->session->set_flashdata('false','Tidak ada file yang di upload');
            redirect('marketing/konsumen');
        }

        $data = [
            'id_konsumen' => $this->input->post('id_konsumen'),
            'file' => $sertifikat,
            'tgl_upload' => date('Y-m-d')
        ];
        if($this->db->insert('sertifikat', $data)){
            $this->session->set_flashdata('true','Sertifikat berhasil di tambahkan');
            redirect('marketing/konsumen');
        } else {
            $this->session->set_flashdata('false','Sertifikat gagal di tambahkan');
            redirect('marketing/konsumen');
        }

    }

    public function show_sertifikat(){
        $id = $_POST['id'];
        $data['data'] = $this->db->get_where('sertifikat',['id_konsumen' => $id])->result();
        $this->load->view('marketing/show_sertifikat', $data);
    }

    public function delete_sertifikat($id){
        $file = $this->db->get_where('sertifikat',['id_sertifikat' => $id])->row()->file;
        unlink(FCPATH .'assets/surat/sertifikat/'. $file);
        if($this->db->delete('sertifikat',['id_sertifikat' => $id])){
            $this->session->set_flashdata('true','Sertifikat berhasil di hapus');
            redirect('marketing/konsumen');
        } else {
            $this->session->set_flashdata('false','Sertifikat gagal di hapus');
            redirect('marketing/konsumen');
        }
    }

}