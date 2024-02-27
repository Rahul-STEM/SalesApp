<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Excel_import_model extends CI_Model
{
    public function select()
    {
        $this->db->order_by("id", "DESC");
        // $this->db->limit(10);
        $query = $this->db->get("action");
        return $query;

    }

    public function insert($data)
    {
        $this->db->insert_batch('action', $data);
    }

}
