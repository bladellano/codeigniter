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

    public function getData($id, $select= null)
    {
        if (!empty($select)) {
            $this->db->select($select);
        }
        $this->db->from("users");
        $this->db->where("user", $id);
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
}
