<?php

class CoursesModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getData($id, $select = null)
    {
        if (!empty($select)) {
            $this->db->select($select);
        }
        $this->db->from("courses");
        $this->db->where("user", $id);
        return $this->db->get();
    }
    public function insert($data)
    {
        $this->db->insert("courses", $data);
    }

    public function update($id, $data)
    {
        $this->db->where("course_id", $id);
        $this->db->update("courses", $data);
    }
    public function delete($id)
    {
        $this->db->where("course_id", $id);
        $this->db->delete("courses");
    }

    public function isDuplicated($field, $value, $id = null)
    {
        if (!empty($id)) {
            $this->db->where("course_id <>", $id);
        }

        $this->db->from("courses");
        $this->db->where($field, $value);
        return $this->db->get()->num_rows() > 0;
    }

    /*
    $_POST['search']['value'] = Campo para busca
    $_POST['order'] = [[0,'asc']]
    $_POST['order'][0]['column'] = index da coluna
    $_POST['order'][0]['dir'] = tipo de ordenação (asc,desc)
    $_POST['length'] = Quantos campos mostrar
    $_POST['start'] = Qual posição começar
     */

    private $column_search = array("course_name", "course_description");

    private $column_order = array("course_name", "", "course_duration");

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

        $this->db->from("courses");


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

        $this->_getDataTable();//CHAMA O OUTRO METODO...

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
        $this->db->from("courses");
        return $this->db->count_all_results();
    }


}
