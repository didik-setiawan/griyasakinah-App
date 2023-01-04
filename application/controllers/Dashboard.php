<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
   
    function __construct() {
        parent::__construct();
        $this->load->model(masterModel());
        $this->load->library('fungsi');
        $this->load->library('form_validation');
        checkLoginGagal();
    }

    function index(){
        // checkUserLogin();
        $id_perum = $this->session->userdata('id_perumahan');
        if(!$id_perum){
            redirect('dashboard/cek_access_perum');
        }
        $data['perumahan'] = $this->master_model->masukPerumahan($id_perum);
        $this->template->load('template', 'dashboard', $data);
    }
    
    private function json(){
        // cara membuat data mysql jadi json
        $module_array = groups();
        $json = json_encode($module_array);
        printf($json);
	}
    
    function profile(){
        $id = userId();
        $G_id = groupId();
        $nama_group = $this->master_model->cekGroups($G_id)->row();
        $last_login = $this->master_model->cekHistory()->row();
        $data = array(
            'nama_group'    => $nama_group,
            'last_login'    => $last_login
        );
        $this->template->load('template', 'profile', $data);
	}
    
    function change_password(){
        $post = $this->input->post(null, TRUE);
        // print_r($post);
        if($post['ganti_password'] == $post['ganti_password2']) {
            // echo 'password sama';
            $this->master_model->ganti_password($post);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('ganti_password', 'Password berhasil diubah');
                redirect('dashboard/profile/');
            }else{
                $this->session->set_flashdata('ganti_password2', 'Password gagal diubah');
                redirect('dashboard/profile/');
            }
        }else{
            $this->session->set_flashdata('ganti_password2', 'Password harus sama');
            redirect('dashboard/profile/');
        }

    }
    
    function test(){
        $this->template->load('template', 'page');
        // $this->template->load('template', 'message/login_success.php');
    }

    function cek_access_perum(){
        $id_user = $this->session->userdata('user_id');
        $id_group = $this->session->userdata('group_id');
        $access = $this->db->get_where('access_perumahan',['id_user' => $id_user])->num_rows();


        if($id_group == 1){
            redirect('home');
        } else {

            if($access == 0){
                $this->load->view('no_access');
            } else if($access == 1){
                //langsung masuk dashboard
                $get_access = $this->db->get_where('access_perumahan',['id_user' => $id_user])->row();
                $data_perum = $this->db->get_where('tbl_perumahan',['id_perumahan' => $get_access->id_perum])->row();
                $data = [
                    'id_perumahan' => $data_perum->id_perumahan,
                    'nama_perumahan' => $data_perum->nama_perumahan,
                    'kabupaten' => $data_perum->kabupaten,
                    'logo_perumahan' => $data_perum->logo
                ];
                $this->session->set_userdata($data);
                redirect('dashboard');

            } else if($access > 1){
                //pilih perum
                $this->pilih_perumahan();
            }

        }

    }
    
    function pilih_perumahan()
    {
        $id_user = $this->session->userdata('user_id');
        $q = "SELECT * FROM tbl_perumahan JOIN access_perumahan WHERE tbl_perumahan.id_perumahan = access_perumahan.id_perum AND access_perumahan.id_user = $id_user";
        // $data['perumahan'] = $this->master_model->getPerumahan();
        $data['perumahan'] = $this->db->query($q)->result_array();
        $this->load->view('pilih_perumahan', $data);
    }
    
    function masuk_perumahan()
    {
        $id_perumahan = $this->input->post('id_perumahan', true);
        $query = $this->master_model->cekPerumahan($id_perumahan);
        if($query > 0)
        {
            $perumahan = array(
                'id_perumahan'       => $query['id_perumahan'],
                'nama_perumahan'      => $query['nama_perumahan'],
                'kabupaten'          => $query['kabupaten'],
                'logo_perumahan'    => $query['logo']
            );
            $this->session->set_userdata($perumahan);
        }
        redirect('dashboard');
        // $data['perumahan'] = $this->master_model->masukPerumahan($this->session->userdata('id_perumahan'));
        // $this->template->load('template', 'dashboard', $data);
    }

    public function get_confirm_superadmin(){
        //transaksi bank
        $tjl_b = $this->master_model->getConfirmPembayaranKonsumen('bank_tjl')->num_rows();
        $um_b = $this->master_model->getConfirmPembayaranKonsumen('bank_um')->num_rows();
        $kt_b = $this->master_model->getConfirmPembayaranKonsumen('bank_kt')->num_rows();
        $pak_b = $this->master_model->getConfirmPembayaranKonsumen('bank_pak')->num_rows();
        $lain_b = $this->master_model->getConfirmPembayaranKonsumen('bank_lain')->num_rows();
        
        //transaksi inhouse
        $hk_i = $this->master_model->getConfirmPembayaranKonsumen('inhouse_hk')->num_rows();
        $tjl_i = $this->master_model->getConfirmPembayaranKonsumen('inhouse_tjl')->num_rows();
        $um_i = $this->master_model->getConfirmPembayaranKonsumen('inhouse_um')->num_rows();
        $kt_i = $this->master_model->getConfirmPembayaranKonsumen('inhouse_kt')->num_rows();

        //Konfirmasi Upah Pembangunan
        $pembangunan = $this->master_model->get_confirm_pembangunan_admin()->num_rows();

        //konfirmasi fee marketing
        $fee = $this->master_model->get_confirm_fee_marketing()->num_rows();

        //Konfirmasi Pembebasan Lahan
        $pembebasan = $this->master_model->get_pembebasan_lahan()->num_rows();

        //konfirmasi pengeluaran lain
        $pengeluaran = $this->master_model->get_confirm_pengeluaran_lain()->num_rows();

        //RAB
        $rab_material = $this->master_model->get_confirm_rab_material();
        $rab_upah = $this->master_model->get_confirm_rab_upah();
        $rab_lain = $this->master_model->get_confirm_rab_lain();

        //pekerjaan insidentil
        $insidentil = $this->master_model->get_confirm_insidentil()->num_rows();

        //pengajuan material
        $material = $this->master_model->get_confirm_material();

        //angsuran bank
        $angsuran = $this->master_model->getConfirmPembayaranKonsumen('bank_rb')->num_rows();

        //piutang bank
        $piutang = $this->master_model->getConfirmPembayaranKonsumen('bank_pb')->num_rows();

        //transaksi batal
        $batal = $this->master_model->get_confirm_transaksi_batal()->num_rows();

        //tanda jadi
        $b_tj = $this->master_model->getConfirmPembayaranKonsumen('bank_tj')->num_rows();
        $i_tj = $this->master_model->getConfirmPembayaranKonsumen('inhouse_tj')->num_rows();

        //kas operasional
        $kas = $this->master_model->get_kas()->num_rows();

        //pemasukan lain
        $pemasukan = $this->db->get_where('pemasukan_lain',['status' => 1, 'id_perumahan' => $this->session->userdata('id_perumahan')])->num_rows();
        

        $count = $tjl_b + $um_b + $kt_b + $pak_b + $lain_b + $hk_i + $tjl_i + $um_i + $kt_i + $pembangunan + $fee + $pembebasan + $pengeluaran + $rab_material + $rab_upah + $rab_lain + $insidentil + $material + $angsuran + $piutang + $batal + $b_tj + $i_tj + $kas + $pemasukan;
      
        echo json_encode($count);
    }

    public function show_confirm_superadmin(){
        $data = [
            //transaksi bank
            'tjl_b' => $this->master_model->getConfirmPembayaranKonsumen('bank_tjl')->result(),
            'um_b' => $this->master_model->getConfirmPembayaranKonsumen('bank_um')->result(),
            'kt_b' => $this->master_model->getConfirmPembayaranKonsumen('bank_kt')->result(),
            'pak_b' => $this->master_model->getConfirmPembayaranKonsumen('bank_pak')->result(),
            'lain_b' => $this->master_model->getConfirmPembayaranKonsumen('bank_lain')->result(),
            'angsur_b' => $this->master_model->getConfirmPembayaranKonsumen('bank_rb')->result(),
            'piutang_b' => $this->master_model->getConfirmPembayaranKonsumen('bank_pb')->result(),
            
            //transaksi inhouse
            'hk_i' => $this->master_model->getConfirmPembayaranKonsumen('inhouse_hk')->result(),
            'tjl_i' => $this->master_model->getConfirmPembayaranKonsumen('inhouse_tjl')->result(),
            'um_i' => $this->master_model->getConfirmPembayaranKonsumen('inhouse_um')->result(),
            'kt_i' => $this->master_model->getConfirmPembayaranKonsumen('inhouse_kt')->result(),
            
            'pembangunan' => $this->master_model->get_confirm_pembangunan_admin()->result(),
            'fee_marketing' => $this->master_model->get_confirm_fee_marketing()->result(),
            'pembebasan' => $this->master_model->get_pembebasan_lahan()->result(),
            'pengeluaran' => $this->master_model->get_confirm_pengeluaran_lain()->result(),
            'rab_material' => $this->master_model->get_rab_material(),
            'rab_upah' => $this->master_model->get_rab_upah(),
            'rab_lain' => $this->master_model->get_rab_lain(),
            'insidentil' => $this->master_model->get_confirm_insidentil()->result(),
            'material' => $this->master_model->get_Pengajuan_Material(),
            'batal' => $this->master_model->get_confirm_transaksi_batal()->result(),

            'b_tj' => $this->master_model->getConfirmPembayaranKonsumen('bank_tj')->result(),
            'i_tj' => $this->master_model->getConfirmPembayaranKonsumen('inhouse_tj')->result(),
            'kas' => $this->master_model->get_kas()->result(),
            'pemasukan' => $this->db->get_where('pemasukan_lain',['status' => 1, 'id_perumahan' => $this->session->userdata('id_perumahan')])->result()
        ];
        $view = $this->load->view('show_confirm', $data);
    }


    public function show_details(){
        $id = $_POST['id'];
        $type = $_POST['type'];

        //tandaa jadi lokasi bank
        if($type == 'tjl_b'){
           
            $data = [
                'data' => $this->db->get_where('bank_cicil_tjl',['id_cicil' => $id])->row(),
                'type' => 'Tanda Jadi Lokasi Transaksi Bank',
                'db' => 'tanda_jadi_lokasi',
                'where' => 'id_tjl'
            ];
            $this->load->view('show_details', $data);
        }
        // uang muka bank
        else if($type == 'um_b'){
            $data = [
                'data' => $this->db->get_where('bank_cicil_um',['id_cicil' => $id])->row(),
                'type' => 'Uang Muka Transaksi Bank',
                'db' => 'uang_muka',
                'where' => 'id_um'
            ];
            $this->load->view('show_details', $data);
        }
        //kelebihan tanah bank
        else if($type == 'kt_b'){
            $data = [
                'data' => $this->db->get_where('bank_cicil_kt',['id_cicil' => $id])->row(),
                'type' => 'kelebihan Tanah Transaksi Bank',
                'db' => 'kelebihan_tanah',
                'where' => 'id_kt'
            ];

            $this->load->view('show_details', $data);
        }
        //PAK bank
        else if($type == 'pak_b'){
       
            $data = [
                'data' => $this->db->get_where('bank_cicil_pak',['id_cicil' => $id])->row(),
                'type' => 'PAK Transaksi Bank',
                'db' => 'pak',
                'where' => 'id_pak'
            ];
            $this->load->view('show_details', $data);
        }
        // lain lain bank.
        else if($type == 'lain_b'){
        
            $data = [
                'data' => $this->db->get_where('bank_cicil_lain',['id_cicil' => $id])->row(),
                'type' => 'Lain-lain Transaksi Bank',
                'db' => 'lain_lain',
                'where' => 'id_lain'
            ];
            $this->load->view('show_details', $data);
        }
        //angsuran bank
        else if($type == 'angsuran_b'){
          
            $data = [
                'data' => $this->db->get_where('bank_cicil_rb',['id_cicil' => $id])->row(),
                'type' => 'Realisasi Bank',
                'db' => 'angsuran_bank',
                'where' => 'id_angsur'
            ];
            $this->load->view('show_details', $data);
        }
        //piutang bank
        else if($type == 'piutang_b'){
           
            $data = [
                'data' => $this->db->get_where('bank_cicil_pb',['id_cicil' => $id])->row(),
                'type' => 'Piutang Bank',
                'db' => 'piutang_bank',
                'where' => 'id_piutang'
            ];
            $this->load->view('show_details', $data);
        }
        //harga kesepakatan inhouse
        else if($type == 'hk_i'){

            $data = [
                'data' => $this->db->get_where('inhouse_cicil_hk',['id_cicil' => $id])->row(),
                'type' => 'Harga kesepakatan Transaksi Inhouse',
                'db' => 'harga_kesepakatan_inhouse',
                'where' => 'id_kesepakatan'
            ];
            $this->load->view('show_details', $data);
        }
        // tanda jadi lokasi inhouse
        else if($type == 'tjl_i'){
           
            $data = [
                'data' => $this->db->get_where('inhouse_cicil_tjl',['id_cicil' => $id])->row(),
                'type' => 'Tanda Jadi Lokasi Transaksi Inhouse',
                'db' => 'tanda_jadi_lokasi_inhouse',
                'where' => 'id_tjl'
            ];
            $this->load->view('show_details', $data);
        }
        // uang muka inhouse
        else if($type == 'um_i'){
          
            $data = [
                'data' => $this->db->get_where('inhouse_cicil_um',['id_cicil' => $id])->row(),
                'type' => 'Uang Muka Transaksi Inhouse',
                'db' => 'uang_muka_inhouse',
                'where' => 'id_um'
            ];

            $this->load->view('show_details', $data);
        }
        // Kelebihan tanah inhouse
        else if($type == 'kt_i'){
          
            $data = [
                'data' => $this->db->get_where('inhouse_cicil_kt',['id_cicil' => $id])->row(),
                'type' => 'Kelebihan Tanah Transaksi Inhouse',
                'db' => 'kelebihan_tanah_inhouse',
                'where' => 'id_kt'
            ];

            $this->load->view('show_details', $data);
        }
        //Upah Pembangunan
        else if($type == 'pembangunan'){
            $data = [
                // 'detail' => $this->master_model->get_upah_confirm_id($id),
                // 'kode' => $this->master_model->get_kode_upah($id),
                'data' => $this->master->get_confirm_pembangunan_admin($id)->row()
            ];
            $this->load->view('show_details_upah', $data);
        }
        //fee marketing
        else if($type == 'fee_marketing'){
            $data['fee']  = $this->master_model->get_confirm_fee_marketing($id)->row();
            $data['kode'] = $this->master_model->get_kode_fee_marketing($id);

            $this->load->view('show_details_fee_marketing', $data);
        }

        //pembebasan Lahan
        else if($type == 'pembebasan'){
            $data = [
                'pembebasan' => $this->master_model->get_pembebasan_lahan($id)->row(),
                // 'kode' => $this->master_model->get_kode_pembebasan($id)
            ];

            $this->load->view('pembebasan_lahan', $data);
        }

        //pengeluaran lain
        else if($type == 'pengeluaran'){
            $data = [
                // 'pengeluaran' => $this->master_model->get_pengeluaran_id($id),
                // 'kode' => $this->master_model->get_kode_pengeluaran($id),
                'data' => $this->master->get_confirm_pengeluaran_lain($id)->row()
            ];

            $this->load->view('pengeluaran_lain', $data);
        }

        //RAB Material
        else if($type == 'rabMaterial'){
            $data = [
                'material' => $this->master_model->get_RABmaterial_id($id),
                'kode' => $this->master_model->getKodeRABMaterial($id)
            ];
           $this->load->view('RABmaterial', $data); 
        }

        //RAB Upah
        else if($type == 'rabUpah'){
            $data = [
                'upah' => $this->master_model->get_RABUpah_id($id),
                'kode' => $this->master_model->getKodeRABUpah($id)
            ];
           $this->load->view('RABupah', $data); 
        }

        //RAB Lain
        else if($type == 'rabLain'){
            $data = [
                'lain' => $this->master_model->get_RABLain_id($id),
                'kode' => $this->master_model->getKodeRABLain($id)
            ];
           $this->load->view('RABlain', $data); 
        }

        //insidentil
        else if($type == 'insidentil'){
            $data = [
                'insidentil' => $this->master_model->getInsidentilID($id),
                'kode' => $this->master_model->getKodeInsidentil($id)
            ];
           $this->load->view('insidentil', $data); 
        }

        //pengajuan material
        else if($type == 'material'){
            $data = [
                'list' => $this->master_model->get_Pengajuan_material_detail($id),
                'kode' => $this->master_model->getKodePengajuanMaterial($id)
            ];
           $this->load->view('pengajuan_material', $data); 
        }
        else if($type == 'batal'){
            $data = [
                'batal' => $this->master_model->get_confirm_transaksi_batal($id)->row(),
                // 'kode' => $this->master_model->getKodePembatalan($id)
            ];
           $this->load->view('pembatalan_transaksi', $data); 
        }
        else if($type == 'b_tj'){
            $cicil = $this->db->get_where('bank_cicil_tj',['id_cicil' => $id])->row();
            $data = [
                'data' => $this->master_model->getBankTJDataID($cicil->id_pembayaran),
                'kode' => $this->master_model->getKodeBankTJ($cicil->id_pembayaran),
                'cicil' => $cicil
            ];
           $this->load->view('b_tj', $data); 
        }
        else if($type == 'i_tj'){
            $cicil = $this->db->get_where('inhouse_cicil_tj',['id_cicil' => $id])->row();
            $data = [
                'data' => $this->master_model->getIhhouseTJDataID($cicil->id_pembayaran),
                'kode' => $this->master_model->getKodeInhouseTJ($cicil->id_pembayaran),
                'cicil' => $cicil
            ];
           $this->load->view('b_tj', $data); 
        }
        else if($type == 'kas'){
            $data = [
                'data' => $this->master_model->get_kas($id)->row()
            ];
            $this->load->view('kas_operasional', $data);
        }
        else if($type == 'pemasukan'){
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
                        <td><img src="'.base_url('assets/bukti_pembayaran/').$data->bukti.'" width="30%"></td>
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

    }


}



?>
