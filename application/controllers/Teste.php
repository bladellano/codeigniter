<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Teste extends CI_Controller
{
    public function index()
    {

        echo "<h3>Hello World!</h3>";

        $this->load->database(); //CHAMANDO BANCO

        $query = $this->db->query('SELECT * FROM courses');

        echo '<pre>';

        echo 'QUANTIDADE DE LINHAS: ';
        print_r($query->num_rows()); //QUANTIDADE DE LINHAS

        echo "<hr>";

        foreach ($query->result() as $row) { // LISTANDO RESULTADO
            echo $row->course_name . " |";
            echo $row->course_duration . " |";
            echo trim($row->course_description) . " |";
            echo "<br>";
        }

        //SELECT DE UM RESULTADO SOMENTE.
        echo "<hr>";
        $query = $this->db->query('SELECT course_name FROM courses LIMIT 1');
        $row = $query->row();
        echo 'SELECT DE UM RESULTADO SOMENTE: ', $row->course_name;

        // INSERÇÃO
        echo '<hr>';
        $nome = "Node Completo";
        $duracao = 21.5;
        $descricao = "Lorem ispum is simply";

        $sql = "INSERT INTO courses (course_name, course_duration,course_description) VALUES
        (" . $this->db->escape($nome) . "," . $duracao . ", " . $this->db->escape($descricao) . ")";
        # $this->db->query($sql);
        echo 'LINHAS AFETADAS: ', $this->db->affected_rows();

        // O Query Builder Pattern oferece um meio simplificado de recuperar dados:
        echo '<hr>';
        $query = $this->db->get('courses');

        foreach ($query->result() as $row) {
            echo $row->course_name, '<br>';
        }

        // Inserção do Query Builder
        echo '<hr>';

        $data = array(
            'course_name' => "Curso Completo de CSS",
            'course_duration' => 15.5,
            'course_description' => "Curso voltado para iniciantes e profissionais da área.",
        );

        #$this->db->insert('courses', $data);
        echo 'LINHAS AFETADAS: ', $this->db->affected_rows();

        echo '<hr>';

        echo $this->db->select('title, content, date')->get_compiled_select();

        echo '<hr>';

        $this->db->select('course_name, course_description');
        $this->db->from('courses');
        $query = $this->db->get();
        #print_r($query->result_array());

        //JOIN
        echo '<hr>';
        $this->db->select('*');
        $this->db->from('blogs');
        echo $this->db->join('comments', 'comments.id = blogs.id')->get_compiled_select();

        //BUSCA USANDO CLAUSULA WHERE
        echo '<hr>';

        $this->db->select('course_name, course_description');
        $this->db->from('courses');
        $array = array('course_name' => "Curso de PHP");
        $this->db->where($array);
        $result = $this->db->get();
        print_r($result->result_array()[0]);

        echo '<hr>';
        //PERMITE DETERMINAR O NÚMERO DE LINHAS EM UMA TABELA ESPECÍFICA.
        echo $this->db->count_all('courses');

        //ENCANDEANDO E GROUP_START
        echo '<hr>';

        echo $this->db->select('*')->from('courses')
            ->group_start()
                ->where('a', 'a')
                ->or_group_start()
                    ->where('b', 'b')
                    ->where('c', 'c')
                ->group_end()
            ->group_end()
            ->where('d', 'd')->get_compiled_select();
            # ->get();
        
        //UPDATE
        echo '<hr>';
        $this->db->set('course_name', 'Curso Node + Angular');
        $this->db->where('course_id', 8);
        $this->db->update('courses');

        //INICIANDO TRANSAÇÃO
        echo '<hr>';
/*         $this->db->trans_start();
        $this->db->query('AN SQL QUERY...');
        $this->db->query('ANOTHER QUERY...');
        $this->db->query('AND YET ANOTHER QUERY...');
        $this->db->trans_complete(); */
        
        echo '<hr>';
        // TABLE METADATA
        
        $tabelas = $this->db->list_tables();
        print_r($tabelas);

    }
}
