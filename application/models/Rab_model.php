<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rab_model extends CI_Model
{

    // AWAL PRODUCT
    public function getRAB($id = NULL, $status = NULL, $lembaga = NULL, $limit = NULL)
    {
        $this->db->select('
            rab_master.*, 
            db_user.nama as nama_user, 
            db_group.group_name as nama_group, 
            db_group.id as id_group, 
            store_profile.nama_lembaga as nama_lembaga,
            store_profile.id as id_lembaga,
        ');

        $this->db->from('rab_master');
        $this->db->join('db_user', 'rab_master.user_id = db_user.id');
        $this->db->join('db_group', 'db_user.group_id = db_group.id');
        $this->db->join('store_profile', 'db_user.store_id = store_profile.id');

        if ($id != NULL) {
            $this->db->where('rab_master.id', $id);
        }
        if ($lembaga != NULL) {
            $this->db->where('store_profile.id', $lembaga);
        }
        if ($status != NULL) {
            $this->db->where('rab_master.status', $status);
        }
        $this->db->where('rab_master.action', 0);

        if ($limit != NULL) {
            $this->db->order_by('rab_master.waktu', 'asc');
            $this->db->limit(10);
        }

        $query = $this->db->get();
        return $query;
    }

    public function addRAB($data)
    {
        $this->db->insert('rab_master', $data);
    }

    public function addInsertRAB($data)
    {
        $this->db->insert('rab_master', $data);
        return $this->db->insert_id();
    }

    public function editRAB($id = NULL, $data = NULL)
    {
        $this->db->where('id', $id);
        $this->db->update('rab_master', $data);
    }

    public function delRAB($id = NULL)
    {
        $params['status'] = 3;
        $params['action'] = 1;
        $this->db->where('id', $id);
        $this->db->update('rab_master', $params);
    }

    public function cancelRAB($id = NULL)
    {
        $params['status'] = 2;
        $params['action'] = 0;
        $this->db->where('id', $id);
        $this->db->update('rab_master', $params);
    }

    // AKHIR PRODUCT 

    // untuk kategeri produk
    public function getDetailRAB($id = NULL, $status = NULL, $user = NULL, $lembaga = NULL, $paren = NULL, $rab = NULL)
    {
        $this->db->select('
            rab_detail.*, 
            db_user.nama as nama_user, 
            db_group.group_name as nama_group, 
            db_group.id as id_group, 
            store_profile.nama_lembaga as nama_lembaga,
            store_profile.id as id_lembaga,
        ');

        $this->db->from('rab_detail');
        $this->db->join('db_user', 'rab_detail.user_id = db_user.id');
        $this->db->join('db_group', 'db_user.group_id = db_group.id');
        $this->db->join('store_profile', 'db_user.store_id = store_profile.id');

        if ($id != NULL) {
            $this->db->where('rab_detail.id', $id);
        }
        if ($rab != NULL) {
            $this->db->where('rab_detail.rab_id', $rab);
        }
        if ($status != NULL) {
            $this->db->where('rab_detail.status', $status);
        }
        if ($lembaga != NULL) {
            $this->db->where('store_profile.id', $lembaga);
        }
        if ($user != NULL) {
            $this->db->where('rab_detail.user_id', $user);
        }
        if ($paren != NULL) {
            $this->db->where('rab_detail.parent', $paren);
        }
        $this->db->where('rab_detail.action', 0);

        $query = $this->db->get();
        return $query;
    }

    public function addDetail($params)
    {
        $this->db->insert('rab_detail', $params);
    }

    public function editDetail($id = NULL, $data = NULL)
    {
        $this->db->where('id', $id);
        $this->db->update('rab_detail', $data);
    }

    public function editDetailAll($status = NULL, $user = NULL, $data = NULL)
    {
        $this->db->where('status', $status);
        $this->db->where('user_id', $user);
        $this->db->update('rab_detail', $data);
    }

    public function delDetail($id = NULL)
    {
        $params['status'] = 3;
        $params['action'] = 1;
        $this->db->where('id', $id);
        $this->db->update('rab_detail', $params);
    }

    public function resetDetail($status = NULL, $user = NULL)
    {
        if ($status != NULL) {
            $this->db->where('status', $status);
        }
        if ($user != NULL) {
            $this->db->where('user_id', $user);
        }
        $this->db->delete('rab_detail');
    }
}