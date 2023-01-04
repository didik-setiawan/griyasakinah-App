<?php
defined('BASEPATH')or exit('No direct script access allowed');

class Pesan extends CI_Controller { 

   public function __construct()
   {
       parent::__construct();
      //  $this->load->model(masterModel());
       checkLoginGagal();
   }

   public function kirim_massal(){
      $data['calon_konsumen'] = $this->db->order_by('nama_konsumen','ASC')->get_where('tbl_marketing')->result();
      // var_dump($data);
      // exit;
      $this->template->load('template', 'pesan/kirim_massal', $data);
   }

   public function tagihan(){
      $data = $this->data_tagihan();
      $data['pengaturan'] =  $this->db->get_where('pengaturan_pesan')->row();
      $this->template->load('template', 'pesan/tagihan', $data);
   }

   public function data_tagihan(){
    $data = array();
    $data['tanda_jadi_lokasi'] = $this->data_tanda_jadi_lokasi();
    $data['uang_muka'] = $this->data_uang_muka();
    $data['kelebihan_tanah'] = $this->data_kelebihan_tanah();
    $data['piutang_bank'] = $this->data_piutang_bank();
    $data['pak'] = $this->data_pak();
    $data['lain_lain'] = $this->data_lain_lain();
    
    $data['tanda_jadi_lokasi_inhouse'] = $this->data_tanda_jadi_lokasi_inhouse();
    $data['uang_muka_inhouse'] = $this->data_uang_muka_inhouse();
    $data['harga_kesepakatan_inhouse'] = $this->data_harga_kesepakatan_inhouse();
    $data['kelebihan_tanah_inhouse'] = $this->data_kelebihan_tanah_inhouse();
    return $data;
   }

   public function data_tanda_jadi_lokasi(){
        $tjl_parent = "SELECT * FROM  tanda_jadi_lokasi WHERE status = 0 OR status = 1 ";
        $output = $this->db->query($tjl_parent)->result();
        foreach($output as $item){
            $konsumen = "SELECT nama_konsumen, no_hp FROM  tbl_marketing WHERE id_marketing = $item->id_konsumen ";
            $konsumen = $this->db->query($konsumen)->row();
            $tjl_cicil = "SELECT * FROM bank_cicil_tjl WHERE id_pembayaran = $item->id_tjl";
            $tjl_cicil = $this->db->query($tjl_cicil)->result();
            $bank_cicil_tjl = array();
            $jumlah_terbayar = 0;
            if($tjl_cicil !== null){
                foreach($tjl_cicil as $items){
                    $bank_cicil_tjl[] = $items;
                    $jumlah_terbayar += $items->jumlah;
                }
            }
            $data[] = [
                'id_tjl' => $item->id_tjl,
                'jml_tjl' => $item->jml_tjl,
                'konsumen' => $konsumen->nama_konsumen,
                'no_hp' => $konsumen->no_hp,
                'angsuran' => $item->angsuran,
                'cicilan_angsuran' => $item->cicilan_angsuran,
                'tgl_bayar' => $item->tgl_bayar,
                'status' => $item->status,
                'jatuh_tempo' => $item->jatuh_tempo,
                'tgl_pembayaran' => $item->tgl_pembayaran,
                'denda' => $item->denda,
                'id_perumahan' => $item->id_perumahan,
                'title_kode' => $item->title_kode,
                'jumlah_terbayar' => $jumlah_terbayar,
                'tagihan' => ($item->cicilan_angsuran - $jumlah_terbayar + ($item->denda == "" ? 0 : $item->denda)),
                'total_angsuran' => ($item->cicilan_angsuran  + ($item->denda == "" ? 0 : $item->denda)),
                'cicilan_detail' => $bank_cicil_tjl,
            ];
        }
        return $data;
   }
   
   public function data_tanda_jadi_lokasi_inhouse(){
        $tjl_parent = "SELECT * FROM  tanda_jadi_lokasi_inhouse WHERE status = 0 OR status = 1 ";
        $output = $this->db->query($tjl_parent)->result();
        foreach($output as $item){
            $konsumen = "SELECT nama_konsumen, no_hp FROM  tbl_marketing WHERE id_marketing = $item->id_konsumen ";
            $konsumen = $this->db->query($konsumen)->row();
            $tjl_cicil = "SELECT * FROM inhouse_cicil_tjl WHERE id_pembayaran = $item->id_tjl";
            $tjl_cicil = $this->db->query($tjl_cicil)->result();
            $bank_cicil_tjl = array();
            $jumlah_terbayar = 0;
            if($tjl_cicil !== null){
                foreach($tjl_cicil as $items){
                    $bank_cicil_tjl[] = $items;
                    $jumlah_terbayar += $items->jumlah;
                }
            }
            $data[] = [
                'id_tjl' => $item->id_tjl,
                'jml_tjl' => $item->jml_tjl,
                'konsumen' => $konsumen->nama_konsumen,
                'no_hp' => $konsumen->no_hp,
                'angsuran' => $item->angsuran,
                'cicilan_angsuran' => $item->cicilan_angsuran,
                'tgl_bayar' => $item->tgl_bayar,
                'status' => $item->status,
                'jatuh_tempo' => $item->jatuh_tempo,
                'tgl_pembayaran' => $item->tgl_pembayaran,
                'denda' => $item->denda,
                'id_perumahan' => $item->id_perumahan,
                'title_kode' => $item->title_kode,
                'jumlah_terbayar' => $jumlah_terbayar,
                'tagihan' => ($item->cicilan_angsuran - $jumlah_terbayar + ($item->denda == "" ? 0 : $item->denda)),
                'total_angsuran' => ($item->cicilan_angsuran  + ($item->denda == "" ? 0 : $item->denda)),
                'cicilan_detail' => $bank_cicil_tjl,
            ];
        }
        return $data;
   }

   public function data_uang_muka_inhouse(){
        $um_parent = "SELECT * FROM  uang_muka_inhouse WHERE status = 0 OR status = 1 ";
        $output = $this->db->query($um_parent)->result();
        foreach($output as $item){
            $konsumen = "SELECT nama_konsumen, no_hp FROM  tbl_marketing WHERE id_marketing = $item->id_konsumen ";
            $konsumen = $this->db->query($konsumen)->row();
            $um_cicil = "SELECT * FROM inhouse_cicil_um WHERE id_pembayaran = $item->id_um";
            $um_cicil = $this->db->query($um_cicil)->result();
            $bank_cicil_um = array();
            $jumlah_terbayar = 0;
            if($um_cicil !== null){
                foreach($um_cicil as $items){
                    $bank_cicil_um[] = $items;
                    $jumlah_terbayar += $items->jumlah;
                }
            }
            $data[] = [
                'id_um' => $item->id_um,
                'jml_um' => $item->jml_um,
                'konsumen' => $konsumen->nama_konsumen,
                'no_hp' => $konsumen->no_hp,
                'angsuran' => $item->angsuran,
                'cicilan_angsuran' => $item->cicilan_angsuran,
                'tgl_bayar' => $item->tgl_bayar,
                'status' => $item->status,
                'jatuh_tempo' => $item->jatuh_tempo,
                'tgl_pembayaran' => $item->tgl_pembayaran,
                'denda' => $item->denda,
                'id_perumahan' => $item->id_perumahan,
                'title_kode' => $item->title_kode,
                'jumlah_terbayar' => $jumlah_terbayar,
                'tagihan' => ($item->cicilan_angsuran - $jumlah_terbayar + ($item->denda == "" ? 0 : $item->denda)),
                'total_angsuran' => ($item->cicilan_angsuran  + ($item->denda == "" ? 0 : $item->denda)),
                'cicilan_detail' => $bank_cicil_um,
            ];
        }
        return $data;
    }

    public function data_uang_muka(){
        $um_parent = "SELECT * FROM  uang_muka WHERE status = 0 OR status = 1 ";
        $output = $this->db->query($um_parent)->result();
        foreach($output as $item){
            $konsumen = "SELECT nama_konsumen, no_hp FROM  tbl_marketing WHERE id_marketing = $item->id_konsumen ";
            $konsumen = $this->db->query($konsumen)->row();
            $um_cicil = "SELECT * FROM bank_cicil_um WHERE id_pembayaran = $item->id_um";
            $um_cicil = $this->db->query($um_cicil)->result();
            $bank_cicil_um = array();
            $jumlah_terbayar = 0;
            if($um_cicil !== null){
                foreach($um_cicil as $items){
                    $bank_cicil_um[] = $items;
                    $jumlah_terbayar += $items->jumlah;
                }
            }
            $data[] = [
                'id_um' => $item->id_um,
                'jml_um' => $item->jml_um,
                'konsumen' => $konsumen->nama_konsumen,
                'no_hp' => $konsumen->no_hp,
                'angsuran' => $item->angsuran,
                'cicilan_angsuran' => $item->cicilan_angsuran,
                'tgl_bayar' => $item->tgl_bayar,
                'status' => $item->status,
                'jatuh_tempo' => $item->jatuh_tempo,
                'tgl_pembayaran' => $item->tgl_pembayaran,
                'denda' => $item->denda,
                'id_perumahan' => $item->id_perumahan,
                'title_kode' => $item->title_kode,
                'jumlah_terbayar' => $jumlah_terbayar,
                'tagihan' => ($item->cicilan_angsuran - $jumlah_terbayar + ($item->denda == "" ? 0 : $item->denda)),
                'total_angsuran' => ($item->cicilan_angsuran  + ($item->denda == "" ? 0 : $item->denda)),
                'cicilan_detail' => $bank_cicil_um,
            ];
        }
        return $data;
    }

   public function data_kelebihan_tanah(){
        $kt_parent = "SELECT * FROM  kelebihan_tanah WHERE status = 0 OR status = 1 ";
        $output = $this->db->query($kt_parent)->result();
        foreach($output as $item){
            $konsumen = "SELECT nama_konsumen, no_hp FROM  tbl_marketing WHERE id_marketing = $item->id_konsumen ";
            $konsumen = $this->db->query($konsumen)->row();
            $kt_cicil = "SELECT * FROM bank_cicil_kt WHERE id_pembayaran = $item->id_kt";
            $kt_cicil = $this->db->query($kt_cicil)->result();
            $bank_cicil_kt = array();
            $jumlah_terbayar = 0;
            if($kt_cicil !== null){
                foreach($kt_cicil as $items){
                    $bank_cicil_kt[] = $items;
                    $jumlah_terbayar += $items->jumlah;
                }
            }
            $data[] = [
                'id_kt' => $item->id_kt,
                'jml_kt' => $item->jml_kt,
                'konsumen' => $konsumen->nama_konsumen,
                'no_hp' => $konsumen->no_hp,
                'angsuran' => $item->angsuran,
                'cicilan_angsuran' => $item->cicilan_angsuran,
                'tgl_bayar' => $item->tgl_bayar,
                'status' => $item->status,
                'jatuh_tempo' => $item->jatuh_tempo,
                'tgl_pembayaran' => $item->tgl_pembayaran,
                'denda' => $item->denda,
                'id_perumahan' => $item->id_perumahan,
                'title_kode' => $item->title_kode,
                'jumlah_terbayar' => $jumlah_terbayar,
                'tagihan' => ($item->cicilan_angsuran - $jumlah_terbayar + ($item->denda == "" ? 0 : $item->denda)),
                'total_angsuran' => ($item->cicilan_angsuran  + ($item->denda == "" ? 0 : $item->denda)),
                'cicilan_detail' => $bank_cicil_kt,
            ];
        }
        return $data;
    }

   public function data_kelebihan_tanah_inhouse(){
        $kt_parent = "SELECT * FROM  kelebihan_tanah_inhouse WHERE status = 0 OR status = 1 ";
        $output = $this->db->query($kt_parent)->result();
        foreach($output as $item){
            $konsumen = "SELECT nama_konsumen, no_hp FROM  tbl_marketing WHERE id_marketing = $item->id_konsumen ";
            $konsumen = $this->db->query($konsumen)->row();
            $kt_cicil = "SELECT * FROM inhouse_cicil_kt WHERE id_pembayaran = $item->id_kt";
            $kt_cicil = $this->db->query($kt_cicil)->result();
            $bank_cicil_kt = array();
            $jumlah_terbayar = 0;
            if($kt_cicil !== null){
                foreach($kt_cicil as $items){
                    $bank_cicil_kt[] = $items;
                    $jumlah_terbayar += $items->jumlah;
                }
            }
            $data[] = [
                'id_kt' => $item->id_kt,
                'jml_kt' => $item->jml_kt,
                'konsumen' => $konsumen->nama_konsumen,
                'no_hp' => $konsumen->no_hp,
                'angsuran' => $item->angsuran,
                'cicilan_angsuran' => $item->cicilan_angsuran,
                'tgl_bayar' => $item->tgl_bayar,
                'status' => $item->status,
                'jatuh_tempo' => $item->jatuh_tempo,
                'tgl_pembayaran' => $item->tgl_pembayaran,
                'denda' => $item->denda,
                'id_perumahan' => $item->id_perumahan,
                'title_kode' => $item->title_kode,
                'jumlah_terbayar' => $jumlah_terbayar,
                'tagihan' => ($item->cicilan_angsuran - $jumlah_terbayar + ($item->denda == "" ? 0 : $item->denda)),
                'total_angsuran' => ($item->cicilan_angsuran  + ($item->denda == "" ? 0 : $item->denda)),
                'cicilan_detail' => $bank_cicil_kt,
            ];
        }
        return $data;
    }

   public function data_piutang_bank(){
        $pb_parent = "SELECT * FROM  piutang_bank WHERE status = 0 OR status = 1 ";
        $output = $this->db->query($pb_parent)->result();
        foreach($output as $item){
            $konsumen = "SELECT nama_konsumen, no_hp FROM  tbl_marketing WHERE id_marketing = $item->id_konsumen ";
            $konsumen = $this->db->query($konsumen)->row();
            $pb_cicil = "SELECT * FROM bank_cicil_pb WHERE id_pembayaran = $item->id_piutang";
            $pb_cicil = $this->db->query($pb_cicil)->result();
            $bank_cicil_pb = array();
            $jumlah_terbayar = 0;
            if($pb_cicil !== null){
                foreach($pb_cicil as $items){
                    $bank_cicil_pb[] = $items;
                    $jumlah_terbayar += $items->jumlah;
                }
            }
            $data[] = [
                'id_pb' => $item->id_piutang,
                'jml_pb' => $item->jml_piutang,
                'konsumen' => $konsumen->nama_konsumen,
                'no_hp' => $konsumen->no_hp,
                'angsuran' => $item->angsuran,
                'cicilan_angsuran' => $item->cicilan_angsuran,
                'tgl_bayar' => $item->tgl_bayar,
                'status' => $item->status,
                'jatuh_tempo' => $item->jatuh_tempo,
                'tgl_pembayaran' => $item->tgl_pembayaran,
                'denda' => $item->denda,
                'id_perumahan' => $item->id_perumahan,
                'title_kode' => $item->title_kode,
                'jumlah_terbayar' => $jumlah_terbayar,
                'tagihan' => ($item->cicilan_angsuran - $jumlah_terbayar + ($item->denda == "" ? 0 : $item->denda)),
                'total_angsuran' => ($item->cicilan_angsuran  + ($item->denda == "" ? 0 : $item->denda)),
                'cicilan_detail' => $bank_cicil_pb,
            ];
        }
        return $data;
    }

   public function data_pak(){
        $pak_parent = "SELECT * FROM  pak WHERE status = 0 OR status = 1 ";
        $output = $this->db->query($pak_parent)->result();
        foreach($output as $item){
            $konsumen = "SELECT nama_konsumen, no_hp FROM  tbl_marketing WHERE id_marketing = $item->id_konsumen ";
            $konsumen = $this->db->query($konsumen)->row();
            $pak_cicil = "SELECT * FROM bank_cicil_pak WHERE id_pembayaran = $item->id_pak";
            $pak_cicil = $this->db->query($pak_cicil)->result();
            $bank_cicil_pak = array();
            $jumlah_terbayar = 0;
            if($pak_cicil !== null){
                foreach($pak_cicil as $items){
                    $bank_cicil_pak[] = $items;
                    $jumlah_terbayar += $items->jumlah;
                }
            }
            $data[] = [
                'id_pak' => $item->id_pak,
                'jml_pak' => $item->jml_pak,
                'konsumen' => $konsumen->nama_konsumen,
                'no_hp' => $konsumen->no_hp,
                'angsuran' => $item->angsuran,
                'cicilan_angsuran' => $item->cicilan_angsuran,
                'tgl_bayar' => $item->tgl_bayar,
                'status' => $item->status,
                'jatuh_tempo' => $item->jatuh_tempo,
                'tgl_pembayaran' => $item->tgl_pembayaran,
                'denda' => $item->denda,
                'id_perumahan' => $item->id_perumahan,
                'title_kode' => $item->title_kode,
                'jumlah_terbayar' => $jumlah_terbayar,
                'tagihan' => ($item->cicilan_angsuran - $jumlah_terbayar + ($item->denda == "" ? 0 : $item->denda)),
                'total_angsuran' => ($item->cicilan_angsuran  + ($item->denda == "" ? 0 : $item->denda)),
                'cicilan_detail' => $bank_cicil_pak,
            ];
        }
        return $data;
    }


    public function data_lain_lain(){
        $lain_parent = "SELECT * FROM lain_lain WHERE status = 0 OR status = 1 ";
        $output = $this->db->query($lain_parent)->result();
        foreach($output as $item){
            $konsumen = "SELECT nama_konsumen, no_hp FROM  tbl_marketing WHERE id_marketing = $item->id_konsumen ";
            $konsumen = $this->db->query($konsumen)->row();
            $lain_cicil = "SELECT * FROM bank_cicil_lain WHERE id_pembayaran = $item->id_lain";
            $lain_cicil = $this->db->query($lain_cicil)->result();
            $bank_cicil_lain = array();
            $jumlah_terbayar = 0;
            if($lain_cicil !== null){
                foreach($lain_cicil as $items){
                    $bank_cicil_lain[] = $items;
                    $jumlah_terbayar += $items->jumlah;
                }
            }
            $data[] = [
                'id_lain' => $item->id_lain,
                'jml_lain' => $item->jml_lain,
                'konsumen' => $konsumen->nama_konsumen,
                'no_hp' => $konsumen->no_hp,
                'angsuran' => $item->angsuran,
                'cicilan_angsuran' => $item->cicilan_angsuran,
                'tgl_bayar' => $item->tgl_bayar,
                'status' => $item->status,
                'jatuh_tempo' => $item->jatuh_tempo,
                'tgl_pembayaran' => $item->tgl_pembayaran,
                'denda' => $item->denda,
                'id_perumahan' => $item->id_perumahan,
                'title_kode' => $item->title_kode,
                'jumlah_terbayar' => $jumlah_terbayar,
                'tagihan' => ($item->cicilan_angsuran - $jumlah_terbayar + ($item->denda == "" ? 0 : $item->denda)),
                'total_angsuran' => ($item->cicilan_angsuran  + ($item->denda == "" ? 0 : $item->denda)),
                'cicilan_detail' => $bank_cicil_lain,
            ];
        }
        return $data;
    }

    public function data_harga_kesepakatan_inhouse(){
        $hk_parent = "SELECT * FROM harga_kesepakatan_inhouse WHERE status = 0 OR status = 1 ";
        $output = $this->db->query($hk_parent)->result();
        foreach($output as $item){
            $konsumen = "SELECT nama_konsumen, no_hp FROM  tbl_marketing WHERE id_marketing = $item->id_konsumen ";
            $konsumen = $this->db->query($konsumen)->row();
            $hk_cicil = "SELECT * FROM inhouse_cicil_hk WHERE id_pembayaran = $item->id_kesepakatan";
            $hk_cicil = $this->db->query($hk_cicil)->result();
            $inhouse_cicil_hk = array();
            $jumlah_terbayar = 0;
            if($hk_cicil !== null){
                foreach($hk_cicil as $items){
                    $inhouse_cicil_hk[] = $items;
                    $jumlah_terbayar += $items->jumlah;
                }
            }
            $data[] = [
                'id_kesepakatan' => $item->id_kesepakatan,
                'jml_kesepakatan' => $item->jml_kesepakatan,
                'konsumen' => $konsumen->nama_konsumen,
                'no_hp' => $konsumen->no_hp,
                'angsuran' => $item->angsuran,
                'cicilan_angsuran' => $item->cicilan_angsuran,
                'tgl_bayar' => $item->tgl_bayar,
                'status' => $item->status,
                'jatuh_tempo' => $item->jatuh_tempo,
                'tgl_pembayaran' => $item->tgl_pembayaran,
                'denda' => $item->denda,
                'id_perumahan' => $item->id_perumahan,
                'title_kode' => $item->title_kode,
                'jumlah_terbayar' => $jumlah_terbayar,
                'tagihan' => ($item->cicilan_angsuran - $jumlah_terbayar + ($item->denda == "" ? 0 : $item->denda)),
                'total_angsuran' => ($item->cicilan_angsuran  + ($item->denda == "" ? 0 : $item->denda)),
                'cicilan_detail' => $inhouse_cicil_hk,
            ];
        }
        return $data;
    }

   
   
    public function invoice(){
        $data = $this->data_tagihan();
      $this->template->load('template', 'pesan/invoice', $data);
   }

   public function pengaturan(){
        $data['pengaturan'] = $this->db->get_where('pengaturan_pesan')->result();
        $curl = curl_init();
        $token = $data['pengaturan'][0]->token;
        curl_setopt($curl, CURLOPT_URL,  "https://jogja.wablas.com/api/device/info?token=$token");
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, true);
        if($result['data']){
            $data['device_info'] = $result['data'];
        }else{
            $data['device_info'] = false;
        }
      $this->template->load('template', 'pesan/pengaturan', $data);
   }

   public function edit_pengaturan(){
      $post = $this->input->post(null, TRUE);
        
      if(empty($post['template_pesan'])){
          $params = array("success" => false, "status" => 1);
      } elseif(empty($post['interval_1'])){
          $params = array("success" => false, "status" => 2);
      } elseif(empty($post['jam'])){
          $params = array("success" => false, "status" => 3);
      } else {
          $data = [
              'template_pesan' => $_POST['template_pesan'],
              'interval_1' => $_POST['interval_1'],
              'interval_2' => $_POST['interval_2'],
              'interval_3' => $_POST['interval_3'],
              'jam' => $_POST['jam'],
          ];
          $this->db->where('id', 1)->update('pengaturan_pesan', $data);
          if($this->db->affected_rows() > 0) {
              $params = array("success" => true);
          } else {
              $params = array("success" => false);
          }
      }
      echo json_encode($params);
   }

   public function edit_token(){
      $post = $this->input->post(null, TRUE);
        
      if(empty($post['token'])){
          $params = array("success" => false, "status" => 1);
      } else {
          $data = [
              'token' => $_POST['token'],
          ];
          $this->db->where('id', 1)->update('pengaturan_pesan', $data);
          if($this->db->affected_rows() > 0) {
              $params = array("success" => true);
          } else {
              $params = array("success" => false);
          }
      }
      echo json_encode($params);
   }

   function send_message(){
       $post = $this->input->post(null, TRUE);
    //    echo $post['jam'];exit;
        $curl = curl_init();
        $pengaturan =  $this->db->get_where('pengaturan_pesan')->row();


        $img = $_FILES['foto'];
        if($img['name'] !== ""){
            $config['upload_path']          = './uploads/img/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            if($this->upload->do_upload('foto')){
                $foto = $this->upload->data('file_name');

                if(count($post['no_hp']) <= 1){
                    $data = [
                        'phone' => $post['no_hp'][0],
                        'message' => $post['pesan'],
                        'image' => base_url().'uploads/img/'.$foto,
                        'caption' => $post['pesan'],
                        'date' => $post['tanggal'],
                        'time' => $post['jam'],
                        'timezone' => 'Asia/Jakarta',
                        'isGroup' => 'false',
                        'random' => 'false',
                    ];
                }else{
                    $data = [];
                    for ($i=0; $i < count($post['no_hp']); $i++) { 
                        $data[] = [
                            'phone' => $post['no_hp'][$i],
                            'message' => $post['pesan'],
                            'image' => base_url().'uploads/img/'.$foto,
                            'caption' => $post['pesan'],
                            'date' => $post['tanggal'],
                            'time' => $post['jam'],
                            'timezone' => 'Asia/Jakarta',
                            'isGroup' => 'false',
                            'random' => 'false',
                        ];
                    }
                }
        
                $token =  $pengaturan->token;
                
        
                curl_setopt($curl, CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: ".$token,
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($curl, CURLOPT_URL, "https://jogja.wablas.com/api/send-image");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                $result = curl_exec($curl);
                curl_close($curl);
        
                $params = array("success" => true);
            } else {
                echo $this->upload->display_errors();
            }
            
        } else {
            if(count($post['no_hp']) <= 1){
                $data = [
                    'phone' => $post['no_hp'][0],
                    'message' => $post['pesan'],
                    'date' => $post['tanggal'],
                    'time' => $post['jam'],
                    'timezone' => 'Asia/Jakarta',
                    'isGroup' => 'false',
                    'random' => 'false',
                ];
            }else{
                $data = [];
                for ($i=0; $i < count($post['no_hp']); $i++) { 
                    $data[] = [
                        'phone' => $post['no_hp'][$i],
                        'message' => $post['pesan'],
                        'date' => $post['tanggal'],
                        'time' => $post['jam'],
                        'timezone' => 'Asia/Jakarta',
                        'isGroup' => 'false',
                        'random' => 'false',
                    ];
                }
            }
    
            $token =  $pengaturan->token;
            
    
            curl_setopt($curl, CURLOPT_HTTPHEADER,
                array(
                    "Authorization: ".$token,
                )
            );
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_URL, "https://jogja.wablas.com/api/schedule");
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($curl);
            curl_close($curl);
    
            $params = array("success" => true);
        }

        echo json_encode($params);

    }

    public function kirim_tagihan()
    {
        $this->config_tagihan($this->data_kelebihan_tanah(), 'Kelebihan Tanah');
        $this->config_tagihan($this->data_uang_muka(), 'Uang Muka');
        $this->config_tagihan($this->data_piutang_bank(), 'Piutang Bank');
        $this->config_tagihan($this->data_pak(), 'PAK');
        $this->config_tagihan($this->data_lain_lain(),'Lain - lain');
        $this->config_tagihan($this->data_tanda_jadi_lokasi_inhouse(), 'Tanda Jadi Lokasi');
        $this->config_tagihan($this->data_uang_muka_inhouse() , 'Uang Muka');
        $this->config_tagihan($this->data_harga_kesepakatan_inhouse(), 'Harga Kesepakatan');
        $this->config_tagihan($this->data_kelebihan_tanah_inhouse(), 'Kelebihan Tanah');
    }

    public function config_tagihan($data, $jenis)
    {
        $pengaturan =  $this->db->get_where('pengaturan_pesan')->row();
        
        foreach($data as $item){
            $date_1 = date('Y-m-d', strtotime("-$pengaturan->interval_1 day", strtotime($item['jatuh_tempo']))); 
            $date_2 = date('Y-m-d', strtotime("-$pengaturan->interval_2 day", strtotime($item['jatuh_tempo']))); 
            $date_3 = date('Y-m-d', strtotime("-$pengaturan->interval_3 day", strtotime($item['jatuh_tempo'])));

            $pesan = $pengaturan->template_pesan;
            $pesan = str_replace("{nama}",$item['konsumen'],$pesan);
            $pesan = str_replace("{jenis_tagihan}",$jenis,$pesan);
            $pesan = str_replace("{total_angsuran}",$item['total_angsuran'] ,$pesan);
            $pesan = str_replace("{total_sudah_terbayar}",$item['jumlah_terbayar'] ,$pesan);
            $pesan = str_replace("{total_belum_terbayar}",$item['tagihan'] ,$pesan);
            $pesan = str_replace("{jatuh_tempo}",$item['jatuh_tempo'] ,$pesan);

            if( $item['jatuh_tempo'] == date('Y-m-d') ){
                $this->config_send_message($item['no_hp'], $pesan);
            }
            if( $date_1 == date('Y-m-d') ){
                $this->config_send_message($item['no_hp'], $pesan);
            }
            if( $date_2 == date('Y-m-d') ){
                $this->config_send_message($item['no_hp'], $pesan);
            }
            if( $date_3 == date('Y-m-d') ){
                $this->config_send_message($item['no_hp'], $pesan);
            }
        }

    }

    public function config_send_message($penerima, $pesan)
    {
        $pengaturan =  $this->db->get_where('pengaturan_pesan')->row();
        $curl = curl_init();

        $data = [
            'phone' => $penerima,
            'message' => $pesan,
            'date' => date("Y-m-d"),
            'time' => $pengaturan->jam,
            'timezone' => 'Asia/Jakarta',
            'isGroup' => 'false',
            'random' => 'false',
        ];

        $token =  $pengaturan->token;


        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array(
                "Authorization: ".$token,
            )
        );

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, "https://jogja.wablas.com/api/schedule");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
    }

    public function change_number()
    {
        $curl = curl_init();
        $pengaturan =  $this->db->get_where('pengaturan_pesan')->row();
        $token =  $pengaturan->token;
        $data = [
            'phone' => '081249033317',
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL,  "https://jogja.wablas.com/api/device/change-number");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($curl);
        curl_close($curl);
        echo "<pre>";
        print_r($result);
    }


    
    public function send_message_test()
    {
        $curl = curl_init();
        $pengaturan =  $this->db->get_where('pengaturan_pesan')->row();
        $token =  $pengaturan->token;
        $data = [
        'phone' => '085707060522',
        'message' => 'hello there',
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL,  "https://jogja.wablas.com/api/send-message");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
        echo "<pre>";
        print_r($result);
    }


    public function device_info()
    {
        $curl = curl_init();
        $pengaturan =  $this->db->get_where('pengaturan_pesan')->row();
        $token =  $pengaturan->token;
        curl_setopt($curl, CURLOPT_URL,  "https://jogja.wablas.com/api/device/info?token=$token");
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($curl);
        curl_close($curl);
        echo "<pre>";
        print_r($result);
    }



    public function gen_tjl($id, $no_hp){
        $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling, tanda_jadi_lokasi, bank_cicil_tjl WHERE tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tanda_jadi_lokasi.id_konsumen = tbl_marketing.id_marketing AND tanda_jadi_lokasi.id_tjl = bank_cicil_tjl.id_pembayaran AND bank_cicil_tjl.id_cicil = $id";
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Tanda Jadi Lokasi';
        $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        $this->print_kwitansi($html, $data, $no_hp, $id);
        // unlink('uploads/1'.$id.'.pdf'); 
    }

    public function gen_um($id, $no_hp){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= Uang Muka.xls");
        $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling, uang_muka, bank_cicil_um WHERE tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND uang_muka.id_konsumen = tbl_marketing.id_marketing AND uang_muka.id_um = bank_cicil_um.id_pembayaran AND bank_cicil_um.id_cicil = $id";
        // $data['tjl'] = $this->db->query($q)->row();
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Uang Muka';
        // $this->load->view('accounting/bank_gen_um', $data);
                $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        $this->print_kwitansi($html, $data, $no_hp, $id);

    }

    public function gen_kt($id, $no_hp){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= Kelebihan Tanah.xls");
        $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling, kelebihan_tanah, bank_cicil_kt WHERE tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND kelebihan_tanah.id_konsumen = tbl_marketing.id_marketing AND kelebihan_tanah.id_kt = bank_cicil_kt.id_pembayaran AND bank_cicil_kt.id_cicil = $id";
        // $data['tjl'] = $this->db->query($q)->row();
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Kelebihan Tanah';

        // $this->load->view('accounting/bank_gen_kt', $data);
                $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        $this->print_kwitansi($html, $data, $no_hp, $id);

    }

    public function gen_pak($id, $no_hp){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= pak.xls");
        $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling, pak, bank_cicil_pak WHERE tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND pak.id_konsumen = tbl_marketing.id_marketing AND pak.id_pak = bank_cicil_pak.id_pembayaran AND bank_cicil_pak.id_cicil = $id";
        // $data['tjl'] = $this->db->query($q)->row();
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'PAK';
                $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        $this->print_kwitansi($html, $data, $no_hp, $id);
        // $this->load->view('accounting/bank_gen_pak', $data);
    }

    public function gen_lain($id, $no_hp){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= lain-lain.xls");
        $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling, lain_lain, bank_cicil_lain WHERE tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND lain_lain.id_konsumen = tbl_marketing.id_marketing AND lain_lain.id_lain = bank_cicil_lain.id_pembayaran AND bank_cicil_lain.id_cicil = $id";
        // $data['tjl'] = $this->db->query($q)->row();
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Lain-lain';
                $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        $this->print_kwitansi($html, $data, $no_hp, $id);
        // $this->load->view('accounting/bank_gen_lain', $data);
    }

    public function gen_angsuran($id, $no_hp){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= lain-lain.xls");
        $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling, angsuran_bank, bank_cicil_rb WHERE tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND angsuran_bank.id_konsumen = tbl_marketing.id_marketing AND angsuran_bank.id_angsur = bank_cicil_rb.id_pembayaran AND bank_cicil_rb.id_cicil = $id";
        // $data['tjl'] = $this->db->query($q)->row();
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Realisasi Bank';
                $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        $this->print_kwitansi($html, $data, $no_hp, $id);
        // $this->load->view('accounting/bank_gen_lain', $data);
    }

    public function gen_piutang($id, $no_hp){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= lain-lain.xls");
        $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling, piutang_bank, bank_cicil_pb WHERE tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND piutang_bank.id_konsumen = tbl_marketing.id_marketing AND piutang_bank.id_piutang = bank_cicil_pb.id_pembayaran AND bank_cicil_pb.id_cicil = $id";
        // $data['tjl'] = $this->db->query($q)->row();
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Piutang Bank';
                $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        $this->print_kwitansi($html, $data, $no_hp, $id);
        // $this->load->view('accounting/bank_gen_lain', $data);
    }

    public function gen_hk($id, $no_hp){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= Harga Kesepakatan.xls");
        $q = "SELECT * FROM tbl_transaksi_inhouse, tbl_marketing, tbl_kavling, harga_kesepakatan_inhouse, inhouse_cicil_hk WHERE tbl_transaksi_inhouse.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND harga_kesepakatan_inhouse.id_konsumen = tbl_marketing.id_marketing AND harga_kesepakatan_inhouse.id_kesepakatan = inhouse_cicil_hk.id_pembayaran AND inhouse_cicil_hk.id_cicil = $id";
        // $data['tjl'] = $this->db->query($q)->row();
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Harga Kesepakatan';
                $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        $this->print_kwitansi($html, $data, $no_hp, $id);
        // $this->load->view('accounting/inhouse_gen_hk', $data);
    }

    public function gen_inhouse_tjl($id, $no_hp){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= Tanda Jadi Lokasi Inhouse.xls");
        $q = "SELECT * FROM tbl_transaksi_inhouse, tbl_marketing, tbl_kavling, tanda_jadi_lokasi_inhouse, inhouse_cicil_tjl WHERE tbl_transaksi_inhouse.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND tanda_jadi_lokasi_inhouse.id_konsumen = tbl_marketing.id_marketing AND tanda_jadi_lokasi_inhouse.id_tjl = inhouse_cicil_tjl.id_pembayaran AND inhouse_cicil_tjl.id_cicil = $id";
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Tanda Jadi Lokasi';
                $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        $this->print_kwitansi($html, $data, $no_hp, $id);
        // $data['tjl'] = $this->db->query($q)->row();
        // $this->load->view('accounting/inhouse_gen_tjl', $data);
    }


    public function gen_inhouse_um($id, $no_hp){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= Uang Muka.xls");
        $q = "SELECT * FROM tbl_transaksi_inhouse, tbl_marketing, tbl_kavling, uang_muka_inhouse, inhouse_cicil_um WHERE tbl_transaksi_inhouse.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND uang_muka_inhouse.id_konsumen = tbl_marketing.id_marketing AND uang_muka_inhouse.id_um = inhouse_cicil_um.id_pembayaran AND inhouse_cicil_um.id_cicil = $id";
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Uang Muka';
                $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        $this->print_kwitansi($html, $data, $no_hp, $id);
        // $data['tjl'] = $this->db->query($q)->row();
        // $this->load->view('accounting/inhouse_gen_um', $data);
    }

    public function gen_inhouse_kt($id, $no_hp){
        // header("Content-type: application/vdn-ms-excel");
        // header("Content-Disposition: attachment; filename= Kelebihan Tanah.xls");
        $q = "SELECT * FROM tbl_transaksi_inhouse, tbl_marketing, tbl_kavling, kelebihan_tanah_inhouse, inhouse_cicil_kt WHERE tbl_transaksi_inhouse.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND kelebihan_tanah_inhouse.id_konsumen = tbl_marketing.id_marketing AND kelebihan_tanah_inhouse.id_kt = inhouse_cicil_kt.id_pembayaran AND inhouse_cicil_kt.id_cicil = $id";
        $data['data'] = $this->db->query($q)->row();
        $data['tipe'] = 'Kelebihan Tanah';
                $html = $this->load->view('accounting/gen_kwitansi', $data, true);
        $this->print_kwitansi($html, $data, $no_hp, $id);
    }

    public function print_kwitansi($html, $data, $no_hp, $id){
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
        $pdf->Output('uploads/'.$data['data']->nama_konsumen.'-'.$id.'.pdf', 'F');
        $this->send_document($no_hp,'uploads/'.$data['data']->nama_konsumen.'-'.$id.'.pdf');
    }


    public function send_document($no_hp, $path)
    {
        try {
            $curl = curl_init();
            $pengaturan =  $this->db->get_where('pengaturan_pesan')->row();
            $token =  $pengaturan->token;

            

            $data = [
                'phone' => $no_hp,
                'message' => base_url().$path,
            ];
            // $data = [
            //     'phone' => $no_hp,
            //     'message' => $link,
            // ];
            curl_setopt($curl, CURLOPT_HTTPHEADER,
                array(
                    "Authorization: $token",
                )
            );
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_URL,  "https://jogja.wablas.com/api/send-message");
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

            $result = curl_exec($curl);
            curl_close($curl);
            
            $this->invoice();
        } catch (\Throwable $th) {
            $this->invoice();
        }
        
    }

    public function get_message(){
        $curl = curl_init();
        $pengaturan =  $this->db->get_where('pengaturan_pesan')->row();
        $token =  $pengaturan->token;
        
        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, 'https://jogja.wablas.com/message/schedule/data?draw=1&columns[0][data]=no&columns[0][name]=&columns[0][searchable]=false&columns[0][orderable]=false&columns[0][search][value]=&columns[0][search][regex]=false&columns[1][data]=device_serial&columns[1][name]=device_serial&columns[1][searchable]=true&columns[1][orderable]=true&columns[1][search][value]=&columns[1][search][regex]=false&columns[2][data]=created_at&columns[2][name]=created_at&columns[2][searchable]=true&columns[2][orderable]=true&columns[2][search][value]=&columns[2][search][regex]=false&columns[3][data]=category&columns[3][name]=category&columns[3][searchable]=true&columns[3][orderable]=true&columns[3][search][value]=&columns[3][search][regex]=false&columns[4][data]=phone&columns[4][name]=phone&columns[4][searchable]=true&columns[4][orderable]=true&columns[4][search][value]=&columns[4][search][regex]=false&columns[5][data]=scheduled_at&columns[5][name]=scheduled_at&columns[5][searchable]=true&columns[5][orderable]=true&columns[5][search][value]=&columns[5][search][regex]=false&columns[6][data]=status&columns[6][name]=status&columns[6][searchable]=true&columns[6][orderable]=true&columns[6][search][value]=&columns[6][search][regex]=false&columns[7][data]=action&columns[7][name]=action&columns[7][searchable]=false&columns[7][orderable]=false&columns[7][search][value]=&columns[7][search][regex]=false&order[0][column]=0&order[0][dir]=asc&start=0&length=10&search[value]=&search[regex]=false&_=1672503953219');
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

        $jsonData = json_decode(curl_exec($curlSession));
        curl_close($curlSession);
                echo "<pre>";
        print_r($jsonData);

        // $result = curl_exec($curl);
        // curl_close($curl);
        // echo "<pre>";
        // print_r($result);
    }
}