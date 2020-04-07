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
                    "restrict.js"
                )
            );

            return $this->template->show("restrict", $data);
        } else {

            $data = array(
                "scripts" => array(
                    "util.js",
                    "login.js"
                )
            );

            return $this->template->show('login', $data);
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
            die("Nenhum acesso de script direto permitido.");

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
            die("Nenhum acesso de script direto permitido.");

        $config["upload_path"] = "./tmp/";
        $config["allowed_type"] = "gif|png|jpg";
        $config["overwrite"] = TRUE;

        $this->load->library("upload", $config);

        $json = array();
        $json["status"] = 1;

        if (!$this->upload->do_upload("image_file")) {//FAZ UPLOAD DO ARQUIVO
            $json["status"] = 0;
            $json["error"] = $this->upload->display_errors("", "");
        } else {
            if ($this->upload->data()["file_size"] <= 1024) {//VERIFICA O TAMANHO DO ARQUIVO
                $file_name = $this->upload->data()["file_name"];
                $json["img_path"] = base_url() . "tmp/" . $file_name;
            } else {
                $json["status"] = 0;
                $json["error"] = "Arquivo não deve ser maior que 1 MB.";
            }
        }

        echo json_encode($json);
    }
}
