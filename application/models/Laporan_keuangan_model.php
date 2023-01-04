<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_keuangan_model extends CI_Model {

    public function tipeTransaksi($id = NULL) {
        $this->db->from('laporan_keuangan_tipe');
        if($id != null) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function kategoriInduk($id = NULL, $nama = NULL, $lembaga = NULL) {
        $this->db->select('
            laporan_keuangan_kategori_induk.*, 
            db_user.nama as nama_user, 
            db_group.group_name as nama_group, 
            db_group.id as id_group, 
            store_profile.nama_lembaga as nama_lembaga,
            store_profile.id as id_lembaga,
        ');

        $this->db->from('laporan_keuangan_kategori_induk');
        $this->db->join('db_user', 'laporan_keuangan_kategori_induk.user_id = db_user.id');
        $this->db->join('db_group', 'db_user.group_id = db_group.id');
        $this->db->join('store_profile', 'db_user.store_id = store_profile.id');

        if($id != null) {
            $this->db->where('laporan_keuangan_kategori_induk.id', $id);
        }
        if($nama != null) {
            $this->db->like('laporan_keuangan_kategori_induk.nama_kategori', $nama);
        }
        if($lembaga != null) {
            $this->db->where('store_profile.id', $lembaga);
        }
        $this->db->where('laporan_keuangan_kategori_induk.action', 0);
        $this->db->order_by('laporan_keuangan_kategori_induk.nama_kategori', 'ASC');


        $query = $this->db->get();
        return $query;
    }

    public function kategoriTransaksi($id = NULL, $tipe = NULL, $induk = NULL, $nama = NULL, $limit = NULL, $lembaga = NULL) { //5 push data
        $this->db->select('
            laporan_keuangan_kategori_transaksi.*, 
            db_user.nama as nama_user, 
            db_group.group_name as nama_group, 
            db_group.id as id_group, 
            store_profile.nama_lembaga as nama_lembaga,
            store_profile.id as id_lembaga,
        ');

        $this->db->from('laporan_keuangan_kategori_transaksi');
        $this->db->join('db_user', 'laporan_keuangan_kategori_transaksi.user_id = db_user.id');
        $this->db->join('db_group', 'db_user.group_id = db_group.id');
        $this->db->join('store_profile', 'db_user.store_id = store_profile.id');

        if($nama != null) {
            $this->db->where('laporan_keuangan_kategori_transaksi.nama_kategori', $nama);
        }
        if($id != null) {
            $this->db->where('laporan_keuangan_kategori_transaksi.id', $id);
        }
        if($tipe != null) {
            $this->db->where('laporan_keuangan_kategori_transaksi.tipe', $tipe);
        }
        if($induk != null) {
            $this->db->where('laporan_keuangan_kategori_transaksi.induk', $induk);
        }
        if($limit != null) {
            $this->db->order_by('laporan_keuangan_kategori_transaksi.id', 'ASC');
        }
        if($lembaga != null) {
            $this->db->where('store_profile.id', $lembaga);
        }
        $this->db->where('laporan_keuangan_kategori_transaksi.action', 0);

        $query = $this->db->get();
        return $query;
    }

    
    // untuk proses input laporan 
    public function getLaporan($id = NULL, $lembaga = NULL, $kategori = NULL) {
        $this->db->select('
            laporan_keuangan.*, 
            laporan_keuangan_kategori_transaksi.nama_kategori as nama_kategori, 
            db_user.nama as nama_user, 
            db_group.group_name as nama_group, 
            db_group.id as id_group, 
            store_profile.nama_lembaga as nama_lembaga,
            store_profile.id as id_lembaga,
        ');

        $this->db->from('laporan_keuangan');
        $this->db->join('laporan_keuangan_kategori_transaksi', 'laporan_keuangan.kategori_id = laporan_keuangan_kategori_transaksi.id');
        $this->db->join('db_user', 'laporan_keuangan.user_id = db_user.id');
        $this->db->join('db_group', 'db_user.group_id = db_group.id');
        $this->db->join('store_profile', 'db_user.store_id = store_profile.id');

        if($id != NULL) {
            $this->db->where('laporan_keuangan.id', $id);
        }
        if($lembaga != NULL) {
            $this->db->where('store_profile.id', $lembaga);
        }
        if($kategori != NULL) {
            $this->db->where('laporan_keuangan.kategori_id', $kategori);
        }
        $this->db->where('laporan_keuangan.action', 0);
        $query = $this->db->get();
        return $query;
    }
    
    public function getTotalLaporan($kategori = NULL, $tipe = NULL, $tahun = NULL, $induk = NULL, $neraca = NULL) {
        $this->db->select('
            SUM(laporan_keuangan.nominal) as sub_total,
            SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) AS pemasukan,
            SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0)) AS pengeluaran,
            (SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) - SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0))) AS saldo_akhir,
            laporan_keuangan.tipe_id as tipe, 
            laporan_keuangan.kategori_id as kategori, 
        ');

        $this->db->from('laporan_keuangan');
        $this->db->join('laporan_keuangan_kategori_transaksi', 'laporan_keuangan.kategori_id = laporan_keuangan_kategori_transaksi.id');
        $this->db->join('laporan_keuangan_kategori_induk', 'laporan_keuangan_kategori_transaksi.induk = laporan_keuangan_kategori_induk.id');
        $this->db->join('db_user', 'laporan_keuangan.user_id = db_user.id');
		$this->db->join('db_group', 'db_user.group_id = db_group.id');
		$this->db->join('store_profile', 'db_user.store_id = store_profile.id');


        if($kategori != NULL) {
            $this->db->where('laporan_keuangan.kategori_id', $kategori);
        }
        if($tipe != NULL) {
            $this->db->where('laporan_keuangan.tipe_id', $tipe);
        }
        if($tahun != NULL) {
            $this->db->where('MID(laporan_keuangan.tanggal,1,4)', $tahun);
        }
        if($neraca != NULL) {
            $this->db->where('MID(laporan_keuangan.tanggal,1,7)', $neraca);
        }
        if($induk != NULL) {
            $this->db->where('laporan_keuangan_kategori_induk.id', $induk);
        }
        $this->db->where('laporan_keuangan.action', 0);
        // $this->db->group_by("kategori_id");
        $query = $this->db->get();
        return $query;
    }
    
    public function addLaporan($params) {
        $this->db->insert('laporan_keuangan', $params);
    }

    public function editLaporan($id = NULL, $params = NULL) {
        $this->db->where('id', $id);
        $this->db->update('laporan_keuangan', $params);
    }
    
    public function deleteLaporan($id) {
        $params['action'] = 1; // delete = 1, aktif = 0
        $this->db->where('id', $id);
        $this->db->update('laporan_keuangan', $params);
    }
    // akhir untuk laporan 
        
    // untuk proses input kategori 
    public function getKategori($id = NULL) {
        $this->db->select('
            laporan_keuangan_kategori_transaksi.*, 
            laporan_keuangan_kategori_transaksi.nama_kategori as kategori_nama, 
            laporan_keuangan_kategori_induk.nama_kategori as nama_induk, 
            laporan_keuangan_tipe.nama as nama_tipe, 
        ');

        $this->db->from('laporan_keuangan_kategori_transaksi');
        $this->db->join('laporan_keuangan_kategori_induk', 'laporan_keuangan_kategori_transaksi.induk = laporan_keuangan_kategori_induk.id');
        $this->db->join('laporan_keuangan_tipe', 'laporan_keuangan_kategori_transaksi.tipe = laporan_keuangan_tipe.id');

        if($id != NULL) {
            $this->db->where('laporan_keuangan_kategori_transaksi.id', $id);
        }
        $this->db->where('laporan_keuangan_kategori_transaksi.action', 0);
        $query = $this->db->get();
        return $query;
    }
    
    public function getKategori2($id = NULL) {
        $this->db->from('laporan_keuangan_kategori_transaksi');
        if($id != NULL) {
            $this->db->where('tipe', $id);
        }
        $this->db->where('action', 0);
        $query = $this->db->get();
        return $query;
    }
    
    public function addKategori($params) {
        $this->db->insert('laporan_keuangan_kategori_transaksi', $params);
    }

    public function editKategori($id = NULL, $params = NULL) {
        $this->db->where('id', $id);
        $this->db->update('laporan_keuangan_kategori_transaksi', $params);
    }
    
    public function deleteKategori($id) {
        $params['action'] = 1; // delete = 1, aktif = 0
        $this->db->where('id', $id);
        $this->db->update('laporan_keuangan_kategori_transaksi', $params);
    }
    // akhir untuk kategori 
        
    // untuk proses input induk 
    public function getInduk($id = NULL) {
        $this->db->from('laporan_keuangan_kategori_induk');
        if($id != NULL) {
            $this->db->where('id', $id);
        }
        $this->db->where('action', 0);
        $query = $this->db->get();
        return $query;
    }
    
    public function addInduk($params) {
        $this->db->insert('laporan_keuangan_kategori_induk', $params);
    }

    public function editInduk($id = NULL, $params = NULL) {
        $this->db->where('id', $id);
        $this->db->update('laporan_keuangan_kategori_induk', $params);
    }
    
    public function deleteInduk($id) {
        $params['action'] = 1; // delete = 1, aktif = 0
        $this->db->where('id', $id);
        $this->db->update('laporan_keuangan_kategori_induk', $params);
    }
    // akhir untuk induk 

    function cekSaldo($data1 = NULL, $data2 = NULL, $id_lembaga = NULL) { 
        $bulan = date('Y-m');
        if($data1 != NULL){
            $this->db->select("
                (SELECT (SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) - SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0))) FROM laporan_keuangan WHERE laporan_keuangan.action = 0 AND  laporan_keuangan.tanggal < '$data1') AS saldo_awal,
                SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) AS pemasukan,
                SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0)) AS pengeluaran,
                (SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) - SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0))) AS saldo_akhir
            ");
            $this->db->where('laporan_keuangan.tanggal >=', $data1);
            $this->db->where('laporan_keuangan.tanggal <=', $data2);
        }else{
            $this->db->select("
                (SELECT (SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) - SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0))) FROM laporan_keuangan WHERE laporan_keuangan.action = 0 AND  MID(laporan_keuangan.tanggal,1,7) < '$bulan') AS saldo_awal,
                    SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) AS pemasukan,
                    SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0)) AS pengeluaran,
                    (SUM(IF( laporan_keuangan.tipe_id = 1, laporan_keuangan.nominal, 0)) - SUM(IF( laporan_keuangan.tipe_id = 2, laporan_keuangan.nominal, 0))) AS saldo_akhir
            ");
            $this->db->where('MID(laporan_keuangan.tanggal,1,7)', $bulan);
        }
        if($id_lembaga != NULL){
            $this->db->where('store_profile.id', $id_lembaga);
        }

        $this->db->from('laporan_keuangan');
        $this->db->join('db_user', 'laporan_keuangan.user_id = db_user.id');
		$this->db->join('db_group', 'db_user.group_id = db_group.id');
        $this->db->join('store_profile', 'db_user.store_id = store_profile.id');
        $this->db->where('laporan_keuangan.action', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function cetakLaporanBulanan($periode = NULL, $id_lembaga = NULL) { 

        if($periode != NULL) {
            $tgl = explode(" - ", $periode);
			$today = date('Y-m-d');
			if($tgl[0] == $today AND $tgl[1] == $today){
				$bulan = date('Y-m');
				$this->db->where("DATE_FORMAT(laporan_keuangan.tanggal,'%Y-%m')", $bulan);
			}else{
				$this->db->where('laporan_keuangan.tanggal >=', $tgl[0]);
				$this->db->where('laporan_keuangan.tanggal <=', $tgl[1]);
			}
        }else{
			$bulan = date('Y-m');
            $this->db->where("DATE_FORMAT(laporan_keuangan.tanggal,'%Y-%m')", $bulan);
		}

		if($id_lembaga != NULL) {
			$this->db->where('store_profile.id', $id_lembaga);
		}

		$this->db->where('laporan_keuangan.action', 0);
		$this->db->order_by('laporan_keuangan.tanggal ASC, laporan_keuangan.id ASC');

		$this->db->select('
			laporan_keuangan.*, 
			laporan_keuangan_kategori_transaksi.nama_kategori as kategori, 
			laporan_keuangan_tipe.nama as nama_tipe, 
			laporan_keuangan_tipe.warna as warna_tipe,
			db_user.nama as nama_user, 
			db_group.group_name as nama_group, 
            db_group.id as id_group, 
            store_profile.nama_lembaga as nama_lembaga,
            store_profile.id as id_lembaga,
		');
        $this->db->from('laporan_keuangan');
        $this->db->join('laporan_keuangan_kategori_transaksi', 'laporan_keuangan_kategori_transaksi.id = laporan_keuangan.kategori_id');
        $this->db->join('laporan_keuangan_tipe', 'laporan_keuangan_tipe.id = laporan_keuangan.tipe_id');
		$this->db->join('db_user', 'laporan_keuangan.user_id = db_user.id');
		$this->db->join('db_group', 'db_user.group_id = db_group.id');
		$this->db->join('store_profile', 'db_user.store_id = store_profile.id');
        
        $query = $this->db->get();
        return $query;
    }

	function get_limit_id($periode = NULL, $id_lembaga = NULL)	{

        if($periode != NULL) {
            $tgl = explode(" - ", $periode);
			$today = date('Y-m-d');
			if($tgl[0] == $today AND $tgl[1] == $today){
				$bulan = date('Y-m');
				$this->db->where("DATE_FORMAT(laporan_keuangan.tanggal,'%Y-%m')", $bulan);
			}else{
				$this->db->where('laporan_keuangan.tanggal >=', $tgl[0]);
				$this->db->where('laporan_keuangan.tanggal <=', $tgl[1]);
			}
        }else{
			$bulan = date('Y-m');
            $this->db->where("DATE_FORMAT(laporan_keuangan.tanggal,'%Y-%m')", $bulan);
		}

		if($id_lembaga != NULL) {
			$this->db->where('store_profile.id', $id_lembaga);
		}

		$this->db->where('laporan_keuangan.action', 0);
		$this->db->order_by('laporan_keuangan.tanggal ASC, laporan_keuangan.id ASC');

		$this->db->select('
			laporan_keuangan.*, 
			laporan_keuangan_kategori_transaksi.nama_kategori as kategori, 
			laporan_keuangan_tipe.nama as nama_tipe, 
			laporan_keuangan_tipe.warna as warna_tipe,
			db_user.nama as nama_user, 
			db_group.group_name as nama_group, 
            db_group.id as id_group, 
            store_profile.nama_lembaga as nama_lembaga,
            store_profile.id as id_lembaga,
		');
        $this->db->from('laporan_keuangan');
        $this->db->join('laporan_keuangan_kategori_transaksi', 'laporan_keuangan_kategori_transaksi.id = laporan_keuangan.kategori_id');
        $this->db->join('laporan_keuangan_tipe', 'laporan_keuangan_tipe.id = laporan_keuangan.tipe_id');
		$this->db->join('db_user', 'laporan_keuangan.user_id = db_user.id');
		$this->db->join('db_group', 'db_user.group_id = db_group.id');
		$this->db->join('store_profile', 'db_user.store_id = store_profile.id');

		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}



}
