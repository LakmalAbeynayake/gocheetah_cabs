<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    
    var $main_menu_name = "dashboard";
	var $sub_menu_name = "dashboard";
    var $title = "Dashboard";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('common_model');
    }
    public function index()
    {
        $data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = $this->sub_menu_name;
		$data['title'] = $this->title;
        $this->load->view('dashboard',$data);
    }
}
