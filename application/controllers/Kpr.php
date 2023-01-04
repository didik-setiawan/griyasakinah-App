<?php
defined('BASEPATH')or exit('No direct script access allowed');
class Kpr extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        checkLoginGagal();
    }

    public function konsumen(){
        $id_perum = $this->session->userdata('id_perumahan');
        // $q = "SELECT * FROM tbl_marketing WHERE status != 1 AND status != 0";
        // $data['konsumen'] = $this->db->query($q)->result();

        $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling WHERE tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_kavling.id_perum = $id_perum AND tbl_marketing.status != 0 AND tbl_marketing.status != 1";
        $data['bank'] = $this->db->query($q)->result();

        $p = "SELECT * FROM tbl_transaksi_inhouse, tbl_marketing, tbl_kavling WHERE tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND tbl_transaksi_inhouse.id_konsumen = tbl_marketing.id_marketing AND tbl_kavling.id_perum = $id_perum AND tbl_marketing.status != 0 AND tbl_marketing.status != 1";
        $data['inhouse'] = $this->db->query($p)->result();
        // var_dump($data['inhouse']);die;

        $this->template->load('template', 'kpr/konsumen', $data);
    }


    public function rejec_konsumen($id){
        if($this->db->set('status' , 0)->where('id_marketing' , $id)->update('tbl_marketing')){
            
            $k_bank = $this->db->get_where('tbl_transaksi_bank',['id_konsumen' => $id])->row();
            $k_inhouse = $this->db->get_where('tbl_transaksi_inhouse',['id_konsumen' => $id])->row();

            if($k_bank){
                $id_rumah = $k_bank->id_rumah;
                $this->db->set('status_kavling',0)->where('id_kavling', $id_rumah)->update('tbl_kavling');
            } else if($k_inhouse){
                $id_rumah = $k_inhouse->id_rumah;
                $this->db->set('status_kavling',0)->where('id_kavling', $id_rumah)->update('tbl_kavling');
            } else {
                //lanjutkan
            }

            $this->session->set_flashdata('scs', 'Konsumen berhasil di rejec');
            redirect('kpr/konsumen');
        } else {
            $this->session->set_flashdata('err', 'Konsumen gagal di rejec');
            redirect('kpr/konsumen');
        }
    }

    public function pemberkasan($id){
        if($this->db->set('status' , 4)->where('id_marketing' , $id)->update('tbl_marketing')){
            $this->session->set_flashdata('scs', 'Status konsumen berhasil di edit');
            redirect('kpr/konsumen');
        } else {
            $this->session->set_flashdata('err', 'Status konsumen gagal di edit');
            redirect('kpr/konsumen');
        }
    }

    public function wawancara($id){
        if($this->db->set('status' , 5)->where('id_marketing' , $id)->update('tbl_marketing')){
            $this->session->set_flashdata('scs', 'Status konsumen berhasil di edit');
            redirect('kpr/konsumen');
        } else {
            $this->session->set_flashdata('err', 'Status konsumen gagal di edit');
            redirect('kpr/konsumen');
        }
    }

    public function sp3k($id){
        if($this->db->set('status' , 6)->where('id_marketing' , $id)->update('tbl_marketing')){
            $this->session->set_flashdata('scs', 'Status konsumen berhasil di edit');
            redirect('kpr/konsumen');
        } else {
            $this->session->set_flashdata('err', 'Status konsumen gagal di edit');
            redirect('kpr/konsumen');
        }
    }

    public function pembangunan($id){
        if($this->db->set('status' , 7)->where('id_marketing' , $id)->update('tbl_marketing')){
            $this->session->set_flashdata('scs', 'Status konsumen berhasil di edit');
            redirect('kpr/konsumen');
        } else {
            $this->session->set_flashdata('err', 'Status konsumen gagal di edit');
            redirect('kpr/konsumen');
        }
    }

    public function realisasi($id){
        if($this->db->set('status' , 8)->where('id_marketing' , $id)->update('tbl_marketing')){
            $id_kavling_from_bank = $this->db->get_where('tbl_transaksi_bank',['id_konsumen' => $id])->row();
            $id_kavling_from_inhouse = $this->db->get_where('tbl_transaksi_inhouse',['id_konsumen' => $id])->row();

            if($id_kavling_from_bank){
                $this->db->set('status_kavling', 2)->where('id_kavling', $id_kavling_from_bank->id_rumah)->update('tbl_kavling');
            } else if($id_kavling_from_inhouse){
                $this->db->set('status_kavling', 2)->where('id_kavling', $id_kavling_from_inhouse->id_rumah)->update('tbl_kavling');
            }

            $this->session->set_flashdata('scs', 'Status konsumen berhasil di edit');
            redirect('kpr/konsumen');
        } else {
            $this->session->set_flashdata('err', 'Status konsumen gagal di edit');
            redirect('kpr/konsumen');
        }
    }

    public function get_fee_marketing(){
        $id = $_POST['id'];
        $data['konsumen'] = $this->db->get_where('tbl_marketing',['id_marketing' => $id])->row();
        $this->load->view('kpr/view_fee_marketing', $data);
        // $konsumen = $this->db->get_where('tbl_marketing',['id_marketing' => $id])->row();
        // echo json_encode($konsumen);
    }

    public function confirm_fee_marketing($id){
        if($this->db->set('status_fee_marketing', 2)->where('id_marketing', $id)->update('tbl_marketing')){
            $this->session->set_flashdata('scs', 'Konfirmasi fee marketing berhasil');
            redirect('kpr/konsumen');
        } else {
            $this->session->set_flashdata('err', 'Konfirmasi fee marketing gagal');
            redirect('kpr/konsumen');
        }

    }



    //Management Rek Bank

    public function rek_bank(){
        $data['rek'] = $this->db->get('rek_bank')->result();
        $this->template->load('template', 'kpr/rekening', $data);
    }

    public function add_rek_bank(){
        $data = [
            'nama_bank' => $this->input->post('bank'),
            'nama_pemilik' => $this->input->post('pemilik'),
            'no_rekening' => $this->input->post('no_rek')
        ];

        // var_dump($data);die;

        if($this->db->insert('rek_bank', $data)){
            $this->session->set_flashdata('true','Rekening baru berhasil di tambahkan');
            redirect('kpr/rek_bank');
        } else {
            $this->session->set_flashdata('false','Rekening baru gagal di tambahkan');
            redirect('kpr/rek_bank');
        }

    }


    public function get_rek_bank_ajax(){
        $id = $_POST['id'];
        $rek = $this->db->get_where('rek_bank', ['id_rekening' => $id])->row();
        echo json_encode($rek);
    }

    public function edit_rek_bank(){
        $id = $this->input->post('id_rek');
        $data = [
            'nama_bank' => $this->input->post('bank'),
            'nama_pemilik' => $this->input->post('pemilik'),
            'no_rekening' => $this->input->post('no_rek')
        ];

        if($this->db->where('id_rekening', $id)->update('rek_bank', $data)){
            $this->session->set_flashdata('true','Rekening berhasil di edit');
            redirect('kpr/rek_bank');
        } else {
            $this->session->set_flashdata('false','Rekening gagal di edit');
            redirect('kpr/rek_bank');
        }

    }

    public function del_rekening($id){
        if($this->db->delete('rek_bank',['id_rekening' => $id])){
            $this->session->set_flashdata('true','Rekening berhasil di hapus');
            redirect('kpr/rek_bank');
        } else {
            $this->session->set_flashdata('false','Rekening gagal di hapus');
            redirect('kpr/rek_bank');
        }
    }





    //Management Berkas Konsumen

    public function berkas_konsumen(){
        $id_perumahan = $this->session->userdata('id_perumahan');
        $q = "SELECT * FROM tbl_transaksi_bank, tbl_marketing, tbl_kavling WHERE tbl_transaksi_bank.id_konsumen = tbl_marketing.id_marketing AND tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND tbl_marketing.status != 0 AND tbl_kavling.id_perum = $id_perumahan";
        $data['konsumen'] = $this->db->query($q)->result();
        $this->template->load('template', 'kpr/berkas_konsumen', $data);
    }

    public function add_berkas(){
        $img = $_FILES['file'];
        if($img){
            $config['upload_path']          = './assets/berkas/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            if($this->upload->do_upload('file')){
                $berkas = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('false','Gagal upload berkas, harap coba kembali');
                redirect('kpr/berkas_konsumen');
            }
        } else {
            $this->session->set_flashdata('false','Gagal upload berkas, harap coba kembali');
            redirect('kpr/berkas_konsumen');
        }

        $data = [
            'id_konsumen' => $this->input->post('id_konsumen'),
            'file' => $berkas,
            'keterangan' => $this->input->post('kategori')
        ];
        // var_dump($data);die;
        if($this->db->insert('berkas_konsumen', $data)){
            $this->session->set_flashdata('true','Berkas berhasil di upload');
                redirect('kpr/berkas_konsumen');
        } else {
            $this->session->set_flashdata('false','Berkas gagal di upload');
                redirect('kpr/berkas_konsumen');
        }
    }

    public function view_berkas(){
        $id = $_POST['id'];
        $ket = $_POST['keterangan'];
        $data['berkas'] = $this->db->get_where('berkas_konsumen',['id_konsumen' => $id, 'keterangan' => $ket])->result();
        $this->load->view('kpr/view_berkas', $data);
    }


    public function del_berkas($id){
        $file = $this->db->get_where('berkas_konsumen',['id_berkas' => $id])->row()->file;
        unlink(FCPATH .'assets/berkas/'. $file);
        if($this->db->delete('berkas_konsumen',['id_berkas' => $id])){
            $this->session->set_flashdata('true','Berkas berhasil di hapus');
            redirect('kpr/berkas_konsumen');
        } else {
            $this->session->set_flashdata('false','Berkas gagal di hapus');
            redirect('kpr/berkas_konsumen');
        }  
    }

}