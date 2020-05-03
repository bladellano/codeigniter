<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function index()
    {
        $this->load->model("CoursesModel");
        $courses = $this->CoursesModel->showCourse();

        $this->load->model("TeamModel");
        $members = $this->TeamModel->showTeam();

        $data = array(
            "scripts" => array(
                "owl.carousel.min.js",
                "theme-scripts.js"
            ),
            "courses"=> $courses,
            "members"=> $members,
        );

        $this->template->show("home",$data);
    }
}
