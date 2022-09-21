<?php
defined('BASEPATH') or exit('No direct script access allowed');

class settings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('common_model');
    }
    function index(){
        $this->load->model('warehouse_model');
        $this->load->model('customers_model');
        $data['main_menu_name'] = 'sales';
        $data['sub_menu_name']  = 'list_sales';
        $data['title']  = 'Sales';
        $this->load->view('developer/rule-add', $data);
    }
}
