<?php

class UsersModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getUser($user_login)
    {
        $this->db
            ->select("user_id,password_hash,user_full_name,user_email")
            ->from("users")
            ->where("user_login", $user_login);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return $result->row();
        }
        return null;
    }

    public function getData($id, $select = null)
    {
        if (!empty($select)) {
            $this->db->select($select);
        }
        $this->db->from("users");
        $this->db->where("user_id", $id);
        return $this->db->get();
    }
    public function insert($data)
    {
        $this->db->insert("users", $data);
    }

    public function update($id, $data)
    {
        $this->db->where("user_id", $id);
        $this->db->update("users", $data);
    }
    public function delete($id)
    {
        $this->db->where("user_id", $id);
        $this->db->delete("users");
    }

    public function isDuplicated($field, $value, $id = null)
    {
        if (!empty($id)) {
            $this->db->where("user_id <>", $id);
        }

        $this->db->from("users");
        $this->db->where($field, $value);
        return $this->db->get()->num_rows() > 0;
    }

    //CONFIGURAÇÃO PARA DATATABLES USUARIOS
    private $column_search = array("user_login", "user_full_name","user_email");
    private $column_order = array("user_login","","user_full_name","user_email");

    private function _getDataTable()
    {
        $search = null;
        if ($this->input->post("search")) {
            $search = $this->input->post("search")["value"];
        }

        $order_column = null;
        $order_dir = null;
        $order = $this->input->post("order");

        if (isset($order)) {
            $order_column = $order[0]["column"];
            $order_dir = $order[0]["dir"];
        }

        $this->db->from("users");

        if (isset($search)) {
            $first = true;
            foreach ($this->column_search as $field) {
                if ($first) {
                    $this->db->group_start();
                    $this->db->like($field, $search);
                    $first = false;
                } else {
                    $this->db->or_like($field, $search);
                }
            }
            if (!$first) {
                $this->db->group_end();
            }
        }

        if (isset($order)) {
            $this->db->order_by($this->column_order[$order_column], $order_dir);
        }
    }

    public function getDataTable()
    {
        $length = $this->input->post("length");
        $start = $this->input->post("start");

        $this->_getDataTable(); //CHAMA O OUTRO METODO...

        if (isset($length) && $length != -1) {
            $this->db->limit($length, $start);
        }
        return $this->db->get()->result();
    }

    public function recordsFiltered()
    {
        $this->_getDataTable();
        return $this->db->get()->num_rows();
    }

    public function recordsTotal()
    {
        $this->db->from("users");
        return $this->db->count_all_results();
    }

}
