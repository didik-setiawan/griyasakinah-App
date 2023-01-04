<?php
defined('BASEPATH')or exit('No direct script access allowed');
class Other extends CI_Controller {
    public function __construct(){
        parent::__construct();
        checkLoginGagal();
    }
    public function pembebasan_lahan(){
        $q = "SELECT * FROM pembebasan_lahan JOIN tbl_perumahan ON pembebasan_lahan.id_perumahan = tbl_perumahan.id_perumahan";
        $data['pembebasan'] = $this->db->query($q)->result();
        $data['perum'] = $this->db->get('tbl_perumahan')->result();
        $this->template->load('template', 'other/pembebasan_lahan', $data);
    }

    public function add_pembebasan(){
        $data = [
            'nama_penjual' => $this->input->post('nama'),
            'no_surat' => $this->input->post('no_surat'),
            'jenis_surat' => $this->input->post('surat'),
            'tgl_pengalihan' => $this->input->post('tgl'),
            'total_pembelian' => $this->input->post('total'),
            'id_perumahan' => $this->input->post('perum'),
            'title_kode' => 0,
            'status' =>1
        ];
        if($this->db->insert('pembebasan_lahan', $data)){
            $this->session->set_flashdata('scs','Data berhasil ditambahkan');
            redirect('other/pembebasan_lahan/');
        } else {
            $this->session->set_flashdata('err','Data gagal ditambahkan');
            redirect('other/pembebasan_lahan/');
        }
    }

    public function get_pembebasan_ajax(){
        $id = $_POST['id'];
        $p = $this->db->get_where('pembebasan_lahan',['id_pembebasan' => $id])->row();
        echo json_encode($p);
    }

    public function edit_pembebasan(){
        $id = $this->input->post('id');
        $data = [
            'nama_penjual' => $this->input->post('nama'),
            'no_surat' => $this->input->post('no_surat'),
            'jenis_surat' => $this->input->post('surat'),
            'tgl_pengalihan' => $this->input->post('tgl'),
            'total_pembelian' => $this->input->post('total'),
            'id_perumahan' => $this->input->post('perum')
        ];

        if($this->db->where('id_pembebasan', $id)->update('pembebasan_lahan', $data)){
            $this->session->set_flashdata('scs','Data berhasil diedit');
            redirect('other/pembebasan_lahan/');
        } else {
            $this->session->set_flashdata('err','Data gagal diedit');
            redirect('other/pembebasan_lahan/');
        }
    }

    public function del_pembebasan($id){
        if($this->db->delete('pembebasan_lahan',['id_pembebasan' => $id])){
            $this->session->set_flashdata('scs','Data berhasil dihapus');
            redirect('other/pembebasan_lahan/');
        } else {
            $this->session->set_flashdata('err','Data gagal dihapus');
            redirect('other/pembebasan_lahan/');
        }
    }

    public function get_kurang_cicil(){
        $id = $_POST['id'];
        $total_pembelian = $this->db->get_where('pembebasan_lahan',['id_pembebasan' => $id])->row()->total_pembelian;
        $q = "SELECT SUM(jumlah) AS total FROM cicil_pembebasan_lahan WHERE id_pembebasan = $id";
        $jml = $this->db->query($q)->row()->total;

        $j = $total_pembelian - $jml;
        $output = number_format($j);
        echo json_encode($output);
    }

    public function add_cicil(){
        $data = [
            'id_pembebasan' => $this->input->post('id'),
            'jumlah' => $this->input->post('cicil'),
            'tgl_bayar' => date('Y-m-d'),
            'status' => 1
        ];

        if($this->db->insert('cicil_pembebasan_lahan', $data)){
            $this->session->set_flashdata('scs','Data berhasil ditambahkan');
            redirect('other/pembebasan_lahan/');
        } else {
            $this->session->set_flashdata('err','Data gagal ditambahkan');
            redirect('other/pembebasan_lahan/');
        }
    }

    public function view_history(){
        $id = $_POST['id'];
        $data['history'] = $this->db->get_where('cicil_pembebasan_lahan',['id_pembebasan' => $id])->result();
        $q = "SELECT SUM(jumlah) AS total FROM cicil_pembebasan_lahan WHERE id_pembebasan = $id";
        $data['total'] = $this->db->query($q)->row()->total;
        $this->load->view('other/history_cicil', $data);
    }



    public function pengeluaran_lain(){
        $id_perum = $this->session->userdata('id_perumahan');
        $data['pengeluaran'] = $this->db->order_by('tgl_pengeluaran','DESC')->get_where('pengeluaran_lain',['id_perumahan' => $id_perum])->result();
        $this->template->load('template', 'other/pengeluaran_lain', $data);
    }
    
    public function add_pengeluaran(){
        $data = [
            'tgl_pengeluaran' => $this->input->post('tgl'),
            'jml_pengeluaran' => $this->input->post('jml'),
            'keterangan' => $this->input->post('ket'),
            'status' => 1,
            'id_perumahan' => $this->session->userdata('id_perumahan')
        ];

        if($this->db->insert('pengeluaran_lain', $data)){
            $this->session->set_flashdata('scs','Data berhasil tambahkan');
            redirect('other/pengeluaran_lain/');
        } else {
            $this->session->set_flashdata('err','Data gagal tambahkan');
            redirect('other/pengeluaran_lain/');
        }

    }

    public function get_pengeluaran_ajax(){
        $id = $_POST['id'];
        $p = $this->db->get_where('pengeluaran_lain',['id_pengeluaran' => $id])->row();
        echo json_encode($p);
    }

    public function edit_pengeluaran(){
        $id = $this->input->post('id');
        
        $data = [
            'tgl_pengeluaran' => $this->input->post('tgl'),
            'jml_pengeluaran' => $this->input->post('jml'),
            'keterangan' => $this->input->post('ket'),
        ];

        if($this->db->where('id_pengeluaran', $id)->update('pengeluaran_lain', $data)){
            $this->session->set_flashdata('scs','Data berhasil edit');
            redirect('other/pengeluaran_lain/');
        } else {
            $this->session->set_flashdata('err','Data gagal edit');
            redirect('other/pengeluaran_lain/');
        }
    }

    public function del_pengeluaran($id){
        if($this->db->delete('pengeluaran_lain',['id_pengeluaran' => $id])){
            $this->session->set_flashdata('scs','Data berhasil hapus');
            redirect('other/pengeluaran_lain/');
        } else {
            $this->session->set_flashdata('err','Data gagal hapus');
            redirect('other/pengeluaran_lain/');
        }
    }

    public function gen_pengeluaran_excel(){
        header("Content-type: application/vdn-ms-excel");
        header("Content-Disposition: attachment; filename= Pengeluaran lain-lain.xls");

        $from = $this->input->post('tgl_f');
        $to = $this->input->post('tgl_t');
        $q = "SELECT * FROM pengeluaran_lain WHERE tgl_pengeluaran BETWEEN '$from' AND '$to' ORDER BY tgl_pengeluaran ASC";
        $data['data'] = $this->db->query($q)->result();
        $j = "SELECT SUM(jml_pengeluaran) AS total FROM pengeluaran_lain WHERE tgl_pengeluaran BETWEEN '$from' AND '$to'";
        $data['total'] = $this->db->query($j)->row()->total;
        $data['from'] = $from;
        $data['to'] = $to;
        
        $this->load->view('other/excel_pengeluaran', $data);

    }


}