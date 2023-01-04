<?php

    function titleWebsite(){
        $CI = get_instance();
        $profile = $CI->master_model->getProfile(1)->row();
        $judul = $profile->judul_web;
        return $judul;
    }

    // Start untuk menu Users & Group
    function groupId(){
        $CI = get_instance();
        return $CI->session->userdata('group_id');
    }
    function groupId2(){
        $CI = get_instance();
        return $CI->fungsi->user_login()->group_id;
    }

    function userId(){
        $CI = get_instance();
        return $CI->session->userdata('user_id');
    }
    function userId2(){
        $CI = get_instance();
        return $CI->fungsi->user_login()->id;
    }

    function idLembaga(){
        $CI = get_instance();
        return $CI->fungsi->user_login()->store_id;
    }

    function usersAll(){
        $CI = get_instance();
        $CI->load->model('master_model');
        return $CI->master_model->select_users_all()->result_array();
    }

    function menus(){
        $CI = get_instance();
        $CI->load->model('master_model');
        return $CI->master_model->menu_modul()->result_array();
    }

    function menusAktif(){
        $CI = get_instance();
        $CI->load->model('master_model');
        return $CI->master_model->ModulAktif()->result_array();
    }

    function groups(){
        $CI = get_instance();
        $CI->load->model('master_model');
        return  $CI->master_model->select_group()->result_array();
    }

    function groupsModul(){
        $CI = get_instance();
        $CI->load->model('master_model');
        return  $CI->master_model->select_group_modul()->result_array();
    }

    function cek_url(){
        $CI = get_instance();
        $urlnya1 = $CI->uri->segment(1);
        $urlnya2 = $CI->uri->segment(2);
        $urlnya3 = $CI->uri->segment(3);
        $urlnya4 = $CI->uri->segment(4);
        if(!empty($urlnya1)) {
            if(!empty($urlnya2)) {
                $result = $urlnya1.'/'.$urlnya2.'/';
            }else{
                $result = $urlnya1.'/';
            }
        } else {
            $result = site_url();
        }
        return $result;
    }

    function checkLogin(){
        $CI = get_instance();
        $userId = userId();
        if($userId){
            redirect('dashboard');
        }
    }
    
    function checkLoginGagal(){
        $CI = get_instance();
        $userId = userId();
        if(!$userId){
            redirect('login');
        }
    }
    
    // masih belum bisa dipakai.... dilanjutkan nanti jika sudah mendekati 80%
    function checkUserLogin(){
        $CI = get_instance();

        $urlnya1 = $CI->uri->segment(1);
        $urlnya2 = $CI->uri->segment(2);
        $urlnya3 = $CI->uri->segment(3);
        $urlnya4 = $CI->uri->segment(4);
        if(!empty($urlnya1)) {
            if(!empty($urlnya2)) {
                $result = $urlnya1.'/'.$urlnya2.'/';
            }else{
                $result = $urlnya1.'/';
            }
        } else {
            $result = 'dashboard/';
        }

        $userId = userId();
        $groupId = groupId();
        $url_cek = cek_url();
        
        $menu = $CI->master_model->menuModulUrl(NULL, $result)->row();
        $modul = $CI->master_model->groupModul($groupId, $menu->id);
        if($modul->num_rows() > 0) {
            $waktu = date("H:i:s");
            // cek durasi akses 
            // jika durasi empty maka biarkan dapat akses 
            if(!empty($group->durasi_awal)){
                if($waktu >= $group->durasi_awal && $waktu <= $group->durasi_akhir){
                    // jika waktu ada dan sesuai dengan waktu sekarang maka boleh akses 
                    // echo 'Boleh Login';
                }else{
                    $CI->session->sess_destroy();
                    $url = base_url('login/non_aktif/');
                    redirect($url);
                }
            }
        }else{
            // jika modul tidak ada maka lempar ke dashboard
            redirect('dashboard/');
        }
      
    }
    // End untuk Menu Users & Groups

    function batasWaktu($nilai){
        // $tgl_a = $cicil->tanggal;
        // $tgl_b = date_create($nilai);
        // $tgl_c = date_format($tgl_b,"Y-m");

        $hari_ini = date("Y-m-d");
        $timeStart = strtotime("$nilai");
        $timeEnd = strtotime("$hari_ini");
        // Menambah bulan ini + semua bulan pada tahun sebelumnya
        $numBulan = 1 + (date("Y",$timeEnd)-date("Y",$timeStart))*12;
        // menghitung selisih bulan
        $numBulan += date("m",$timeEnd)-date("m",$timeStart);

        return $numBulan;
    }
    
    // Start untuk Master Database 
    function productCategory(){
        $CI = get_instance();
        $CI->load->model('database_model');
        return $CI->database_model->product_category()->result_array();
    }
    
    
    function productUnit(){
        $CI = get_instance();
        $CI->load->model('database_model');
        return $CI->database_model->product_unit()->result_array();
    }
    
    function customerAll(){
        $CI = get_instance();
        $CI->load->model('database_model');
        return $CI->database_model->customer_list()->result_array();
    }
    
    function supplierAll(){
        $CI = get_instance();
        $CI->load->model('database_model');
        return $CI->database_model->supplier_list()->result_array();
    }
    
    function salesAll(){
        $CI = get_instance();
        $CI->load->model('database_model');
        return $CI->database_model->sales_list()->result_array();
    }
    
    function employerAll(){
        $CI = get_instance();
        $CI->load->model('database_model');
        return $CI->database_model->employer_list()->result_array();
    }
    
    function storeAll(){
        $CI = get_instance();
        $CI->load->model('database_model');
        return $CI->database_model->store_list()->result_array();
    }
    
    function storeAll2(){
        $CI = get_instance();
        $CI->load->model('database_model');
        return $CI->database_model->store_list();
    }
    
    function paymentAll(){
        $CI = get_instance();
        $CI->load->model('database_model');
        return $CI->database_model->payment_method()->result_array();
    }

    function productAll(){
        $CI = get_instance();
        $CI->load->model('database_model');
        return $CI->database_model->product_all()->result_array();
    }
    
    function apiKEYUrl() {
        $api = 'https://dataglobalmandiri.com/laporan_keuangan/api/key/';
        return $api;
    }
    
    function apiKEY() {
        $CI = get_instance();
        $data = $CI->master_model->getProfile(1)->row()->api_key;
        return $data;
    }

    function apiKEYProfile() {
        $CI = get_instance();
        $data = $CI->master_model->getProfile(1)->row()->nama_lembaga;
        return $data;
    }

    function apiValidDate(){
        $CI = get_instance();
        $data = $CI->master_model->cekValidDate()->row()->last_login;
        return $data;
    }

    function kodeAcak($panjang) {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // Output: 54esmdr0qf
        return substr(str_shuffle($permitted_chars), 0, $panjang);
    }
  
    function rupiah($uang) {
        $rupiah = "Rp. " . number_format($uang, 2, ',', '.');
        return $rupiah;
    }

    function rupiah2($uang) {
        $rupiah = number_format($uang, 0, ',', '.');
        return $rupiah;
    }

    function rupiah3($uang) {
        $rupiah = number_format($uang, 2, ',', '.');
        return $rupiah;
    }

    function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai)). " rupiah";
		} else {
			$hasil = trim(penyebut($nilai)). " rupiah";
		}     		
		return $hasil;
	}
 
    function HakAkses($data) {
        $CI = get_instance();
        $groupId = groupId();
        
        $modul = $CI->master_model->groupModul($groupId, $data);
        if($modul->num_rows() > 0){
            $result = [
                'modul'     => $modul->row()->modul_id,
                'create'    => $modul->row()->crud_create,
                'update'    => $modul->row()->crud_update,
                'delete'    => $modul->row()->crud_delete
            ];
        }else{
            $result = [
                'modul'     => NULL,
                'create'    => NULL,
                'update'    => NULL,
                'delete'    => NULL
            ];
        }
        return (object) $result;
    }

    function lastStok($produk = NULL) {
        $CI = get_instance();

        // $id = null, $penjualan = NULL, $produk = NULL, $user = NULL, $status = NULL
        $CartTemp = $CI->transaksi_model->penjualanCart(NULL, NULL, $produk, NULL, 0)->result();
        $TotalQuantity = 0;
        foreach ($CartTemp as $key => $cardT) {
            $TotalQuantity += $cardT->quantity;
        }

        // awal gudang toko 
            $stok1 = $CI->stok_model->totalStok($produk, 1, 1, 1)->row();
            if(!empty($stok1->total_stok)){
                $stok_masuk = $stok1->total_stok;
            }else{
                $stok_masuk = 0;
            }
            $stok2 = $CI->stok_model->totalStok($produk, 1, 2, 1)->row();
            if(!empty($stok2->total_stok)){
                $stok_keluar = $stok2->total_stok;
            }else{
                $stok_keluar = 0;
            }
            $stok_akhir = ($stok_masuk - $stok_keluar) - $TotalQuantity;
        // akhir gudang toko 
        return $stok_akhir;
        
    }

    function masterModel() {
        $data = [
            'ajax_keuangan_model', 
            'ajax_saldo_model', 
            'ajax_saldo2_model',
            'ajax_produk_model',
            'ajax_history_stok_model',
            'ajax_laporan_stok_model',
            'ajax_keuangan_tahunan_model',
            'ajax_rab_model',
            'cetak_model', 
            'inventaris_model', 
            'laporan_keuangan_model', 
            'login_model', 
            'master_model', 
            'rab_model', 
        ];
        return $data;
	}
 
    function hariHari(){
        //Tanggal Kemarin
        $kemarin = date('Y-m-d', strtotime("-1 day", strtotime(date("Y-m-d"))));
        //Tanggal Besok
        $besok = date('Y-m-d', strtotime("+10 day", strtotime(date("Y-m-d"))));
        
        //Tanggal n Hari Kebelakang dari Tanggal Tertentu
        $tanggal = "2015-05-19";
        $hari = 3;
        $minggu_lalu = date('Y-m-d', strtotime('-$hari day', strtotime($tanggal)));
        //Tanggal Minggu Lalu dari Tanggal Tertentu
        $tanggal = "2015-05-19";
        $minggu_lalu = date('Y-m-d', strtotime('-1 week', strtotime($tanggal)));
        //Tanggal Minggu Depan dari Tanggal Tertentu
        $tanggal = "2015-05-19";
        $minggu_lalu = date('Y-m-d', strtotime('+1 week', strtotime($tanggal)));   
    }

    function hitungHari($id = NULL, $tgl = NULL){
        if($tgl != NULL){
            $kemarin = date('Y-m-d', strtotime("$id day", strtotime(date($tgl))));
        }else{
            $kemarin = date('Y-m-d', strtotime("$id day", strtotime(date("Y-m-d"))));
        }
        return $kemarin;
    }

    function access(){
        $ci = get_instance();
        $admin_group = $ci->session->userdata('group_id');
        if($admin_group == 2){
            echo "d-none";
        } else {
           echo ""; 
        }
    }

    function only_accounting(){
        $ci = get_instance();
        $admin_group = $ci->session->userdata('group_id');
        if($admin_group != 3){
            echo "d-none";
        } else {
           echo ""; 
        }
    }

?>




