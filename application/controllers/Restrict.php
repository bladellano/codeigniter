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
                "scripts" => array(
                    "util.js",
                    "login.js",
                    "restrict.js",
                ),
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

            $data["password_hash"] = password_hash($data["user_password"],PASSWORD_DEFAULT);
            
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

}
