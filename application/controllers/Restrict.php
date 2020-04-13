<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Restrict extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
    }

    public function index()
    {
        if ($this->session->userdata("user_id")) //VERIFICA SE TEM SESSÃO ATIVA.
        {
            $data = array(
                "styles" => array(
                    "dataTables.bootstrap.min.css",
                    "datatables.min.css",
                ),
                "scripts" => array(
                    "sweetalert2@9.js",
                    "datatables.min.js",
                    "dataTables.bootstrap.min.js",
                    "util.js",
                    "restrict.js",
                ),
                "user_id" => $this->session->userdata("user_id"),
            );

            return $this->template->show("restrict", $data);
        } else {

            $data = array(
                "scripts" => array(
                    "util.js",
                    "login.js",
                ),
            );

            return $this->template->show("login", $data);
        }
    }

    public function logoff()
    {
        $this->session->sess_destroy();
        header("Location:" . base_url() . "restrict");
    }

    public function ajaxLogin()
    {

        if (!$this->input->is_ajax_request()) //FUNÇÃO DO C.I QUE VERIFICA SE É UMA REQUISIÇÃO AJAX.
        {
            die("Nenhum acesso de script direto permitido.");
        }

        $json = [];
        $json["status"] = 1;
        $json["error_list"] = [];

        $username = $this->input->post("username");
        $password = $this->input->post("password");

        if (empty($username)) {
            $json["status"] = 0;
            $json["error_list"]["#username"] = "Usuário não pode ser vazio.";
        } else {
            $this->load->model("UsersModel");
            $result = $this->UsersModel->getUser($username);
            if ($result) {
                $user_id = $result->user_id;
                $password_hash = $result->password_hash;
                if (password_verify($password, $password_hash)) {
                    $this->session->set_userdata("user_id", $user_id); //CRIA SESSÃO, MAS PRECISA ESTÁ HABILITADO.
                } else {
                    $json["status"] = 0;
                }
            } else {
                $json["status"] = 0;
            }

            if ($json["status"] == 0) {
                $json["error_list"]["#btn_login"] = "Usuário e/ou senha incorretos.";
            }
        }

        echo json_encode($json);
    }

    public function ajaxImportImage()
    {

        if (!$this->input->is_ajax_request()) //FUNÇÃO DO C.I QUE VERIFICA SE É UMA REQUISIÇÃO AJAX.
        {
            die("Nenhum acesso de script direto permitido.");
        }

        $config["upload_path"] = "./tmp/";
        $config["allowed_types"] = "gif|png|jpg";
        $config["overwrite"] = true;

        $this->load->library("upload", $config);

        $json = array();
        $json["status"] = 1;

        if (!$this->upload->do_upload("image_file")) { //FAZ UPLOAD DO ARQUIVO
            $json["status"] = 0;
            $json["error"] = $this->upload->display_errors("", "");
        } else {
            if ($this->upload->data()["file_size"] <= 1024) { //VERIFICA O TAMANHO DO ARQUIVO
                $file_name = $this->upload->data()["file_name"];
                $json["img_path"] = base_url() . "tmp/" . $file_name;
            } else {
                $json["status"] = 0;
                $json["error"] = "Arquivo não deve ser maior que 1 MB.";
            }
        }

        echo json_encode($json);
    }

    public function ajaxSaveCourse()
    {

        if (!$this->input->is_ajax_request()) //FUNÇÃO DO C.I QUE VERIFICA SE É UMA REQUISIÇÃO AJAX.
        {
            die("Nenhum acesso de script direto permitido.");
        }

        $json = array();
        $json["status"] = 1;
        $json["error_list"] = [];

        $this->load->model("CoursesModel");

        $data = $this->input->post();

        if (empty($data["course_name"])) {
            $json["error_list"]["#course_name"] = "Nome do curso é obrigatorio.";

        } else {
            if ($this->CoursesModel->isDuplicated("course_name", $data["course_name"], $data["course_id"])) {
                $json["error_list"]["#course_name"] = "Nome de curso já existente.";
            }
        }

        $data["course_duration"] = floatval($data["course_duration"]);

        if (empty($data["course_duration"])) {
            $json["error_list"]["#course_duration"] = "Duração do curso é obrigatorio.";

        } else {
            if (!($data["course_duration"] > 0 && $data["course_duration"] < 100)) {
                $json["error_list"]["#course_duration"] = "Duração do curso deverá ser maior que 0 (h) e menor que 100 (h).";
            }
        }

        if (!empty($json["error_list"])) {
            $json["status"] = 0;
        } else {

            if (!empty($data["course_img"])) {

                $file_name = basename($data["course_img"]);
                $old_path = getcwd() . "/tmp/" . $file_name;
                $new_path = getcwd() . "/public/images/courses/" . $file_name;
                rename($old_path, $new_path);

                $data["course_img"] = "/public/images/courses/" . $file_name;

            }

            if (empty($data["course_id"])) {
                $this->CoursesModel->insert($data);
            } else {
                $course_id = $data["course_id"];
                unset($data["course_id"]);
                $this->CoursesModel->update($course_id, $data);
            }
        }

        echo json_encode($json);
    }

    public function ajaxSaveMember()
    {

        if (!$this->input->is_ajax_request()) //FUNÇÃO DO C.I QUE VERIFICA SE É UMA REQUISIÇÃO AJAX.
        {
            die("Nenhum acesso de script direto permitido.");
        }

        $json = array();
        $json["status"] = 1;
        $json["error_list"] = [];

        $this->load->model("TeamModel");

        $data = $this->input->post();

        if (empty($data["member_name"])) {
            $json["error_list"]["#member_name"] = "Nome do membro é obrigatorio.";

        }

        if (!empty($json["error_list"])) {
            $json["status"] = 0;
        } else {

            if (!empty($data["member_photo"])) {

                $file_name = basename($data["member_photo"]);
                $old_path = getcwd() . "/tmp/" . $file_name;
                $new_path = getcwd() . "/public/images/team/" . $file_name;
                rename($old_path, $new_path);

                $data["member_photo"] = "/public/images/team/" . $file_name;

            }

            if (empty($data["member_id"])) {
                $this->TeamModel->insert($data);
            } else {
                $member_id = $data["member_id"];
                unset($data["member_id"]);
                $this->TeamModel->update($member_id, $data);
            }
        }

        echo json_encode($json);
    }

    public function ajaxSaveUser()
    {

        if (!$this->input->is_ajax_request()) //FUNÇÃO DO C.I QUE VERIFICA SE É UMA REQUISIÇÃO AJAX.
        {
            die("Nenhum acesso de script direto permitido.");
        }

        $json = array();
        $json["status"] = 1;
        $json["error_list"] = [];

        $this->load->model("UsersModel");

        $data = $this->input->post();

        //VERIFICANDO LOGIN
        if (empty($data["user_login"])) {
            $json["error_list"]["#user_login"] = "Login é obrigatorio.";

        } else {
            if ($this->UsersModel->isDuplicated("user_login", $data["user_login"], $data["user_id"])) {
                $json["error_list"]["#user_login"] = "Login já existente.";
            }
        }
        //VERIFICANDO NOME COMPLETO
        if (empty($data["user_full_name"])) {
            $json["error_list"]["#user_full_name"] = "Nome completo é obrigatorio.";
        }

        //VERIFICANDO E-MAIL
        if (empty($data["user_email"])) {
            $json["error_list"]["#user_email"] = "E-mail é obrigatorio.";

        } else {
            if ($this->UsersModel->isDuplicated("user_email", $data["user_email"], $data["user_id"])) {
                $json["error_list"]["#user_email"] = "E-mail já existente.";
            } else {
                if ($data["user_email"] != $data["user_email_confirm"]) {
                    $json["error_list"]["#user_email"] = "";
                    $json["error_list"]["#user_email_confirm"] = "E-mails não conferem.";
                }
            }
        }
        //VERIFICANDO SENHA
        if (empty($data["user_password"])) {
            $json["error_list"]["#user_password"] = "Senha é obrigatorio.";

        } else {
            if ($data["user_password"] != $data["user_password_confirm"]) {
                $json["error_list"]["#user_password"] = "";
                $json["error_list"]["#user_password_confirm"] = "Senhas não conferem.";
            }
        }

        //SEGUE...

        if (!empty($json["error_list"])) {
            $json["status"] = 0;
        } else {

            $data["password_hash"] = password_hash($data["user_password"], PASSWORD_DEFAULT);

            //ELIMINAR ALGUNS CAMPOS...
            unset($data["user_password"]);
            unset($data["user_password_confirm"]);
            unset($data["user_email_confirm"]);

            if (empty($data["user_id"])) {
                $this->UsersModel->insert($data);
            } else {
                $user_id = $data["user_id"];
                unset($data["user_id"]);
                $this->UsersModel->update($user_id, $data);
            }
        }

        echo json_encode($json);
    }

    //FUNÇÃO PARA PEGAR DADOS DO USUÁRIO LOGADO
    public function ajaxGetUserData()
    {

        if (!$this->input->is_ajax_request()) //FUNÇÃO DO C.I QUE VERIFICA SE É UMA REQUISIÇÃO AJAX.
        {
            die("Nenhum acesso de script direto permitido.");
        }

        $json = array();
        $json["status"] = 1;
        $json["input"] = [];

        $this->load->model("UsersModel");

        $user_id = $this->input->post("user_id");
        $data = $this->UsersModel->getData($user_id)->result_array()[0]; //FUNÇÃO C.I result_array()

        $json["input"]["user_id"] = $data["user_id"];
        $json["input"]["user_login"] = $data["user_login"];
        $json["input"]["user_full_name"] = $data["user_full_name"];
        $json["input"]["user_email"] = $data["user_email"];
        $json["input"]["user_email_confirm"] = $data["user_email"];
        $json["input"]["user_password"] = $data["password_hash"];
        $json["input"]["user_password_confirm"] = $data["password_hash"];

        echo json_encode($json);
    }

    //AJAX PARA LISTAR OS CURSOS COM DATATABLES

    public function ajaxListCourse(){

        if (!$this->input->is_ajax_request()) //FUNÇÃO DO C.I QUE VERIFICA SE É UMA REQUISIÇÃO AJAX.
        {
            die("Nenhum acesso de script direto permitido.");
        }
        
        $this->load->model("CoursesModel");

        $courses = $this->CoursesModel->getDataTable();

        $data = array();

        foreach ($courses as $course) {

            $row = array();

            $row[] = $course->course_name;

            if ($course->course_img) {
                $row[] = '<img src="' . base_url() . $course->course_img . '" style="max-height:100px;max-width:100px;" >';
            } else {
                $row[] = "";
            }
            $row[] = $course->course_duration;
            $row[] = '<div class="description">' . $course->course_description . '</div>';
            $row[] = '<div style="display:inline-block;">
                <button class="btn btn-primary btn-edit-course"
                course_id="' . $course->course_id . '">
                <i class="fa fa-edit"></i>
                </button>
                <button class="btn btn-danger btn-del-course"
                course_id="' . $course->course_id . '">
                <i class="fa fa-times"></i>
                </button></div>';

            $data[] = $row;
        }
        $json = array(
            "draw" => $this->input->post("draw"),
            "recordsTotal" => $this->CoursesModel->recordsTotal(),
            "recordsFiltered" => $this->CoursesModel->recordsFiltered(),
            "data" => $data,
        );

        echo json_encode($json);

    }

    //AJAX PARA LISTAR OS MEMBROS COM DATATABLES
    public function ajaxListMember(){

        if (!$this->input->is_ajax_request()) //FUNÇÃO DO C.I QUE VERIFICA SE É UMA REQUISIÇÃO AJAX.
        {
            die("Nenhum acesso de script direto permitido.");
        }
        
        $this->load->model("TeamModel");

        $team = $this->TeamModel->getDataTable();

        $data = array();

        foreach ($team as $member) {

            $row = array();

            $row[] = $member->member_name;

            if ($member->member_photo) {
                $row[] = '<img src="' . base_url() . $member->member_photo . '" style="max-height:100px;max-width:100px;" >';
            } else {
                $row[] = "";
            }
            $row[] = '<div class="description">' . $member->member_description . '</div>';
            $row[] = '<div style="display:inline-block;">
                <button class="btn btn-primary btn-edit-course"
                member_id="' . $member->member_id . '">
                <i class="fa fa-edit"></i>
                </button>
                <button class="btn btn-danger btn-del-course"
                member_id="' . $member->member_id . '">
                <i class="fa fa-times"></i>
                </button></div>';

            $data[] = $row;
        }
        $json = array(
            "draw" => $this->input->post("draw"),
            "recordsTotal" => $this->TeamModel->recordsTotal(),
            "recordsFiltered" => $this->TeamModel->recordsFiltered(),
            "data" => $data,
        );

        echo json_encode($json);

    }

    //AJAX PARA LISTAR OS USUARIOS COM DATATABLES
    public function ajaxListUser(){

        if (!$this->input->is_ajax_request()) //FUNÇÃO DO C.I QUE VERIFICA SE É UMA REQUISIÇÃO AJAX.
        {
            die("Nenhum acesso de script direto permitido.");
        }
        
        $this->load->model("UsersModel");

        $users = $this->UsersModel->getDataTable();

        $data = array();

        foreach ($users as $user) {

            $row = array();

            $row[] = $user->user_login;       
            $row[] =  $user->user_full_name;
            $row[] =  $user->user_email;

            $row[] = '<div style="display:inline-block;">

                <button class="btn btn-primary btn-edit-course"
                user_id="' . $user->user_id . '">
                <i class="fa fa-edit"></i>
                </button>
                <button class="btn btn-danger btn-del-course"
                user_id="' . $user->user_id . '">
                <i class="fa fa-times"></i>
                </button></div>';

            $data[] = $row;
        }
        $json = array(
            "draw" => $this->input->post("draw"),
            "recordsTotal" => $this->UsersModel->recordsTotal(),
            "recordsFiltered" => $this->UsersModel->recordsFiltered(),
            "data" => $data,
        );

        echo json_encode($json);

    }


}
