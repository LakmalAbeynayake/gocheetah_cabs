<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Customers extends CI_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/welcome
     *    - or -
     *         http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    var $main_menu_name = "associates";
    var $sub_menu_name = "customers";
    var $title = "Customers";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->model('warehouse_model');
        $this->load->model('customers_model');
        $this->load->model('user_model');
    }
    public function index(){
        $this->load->view('customers/page-login');
    }
    public function reg(){
        $this->load->view('customers/page-reg');
    }
    function dashboard(){
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = "cus_dashboard";
        $data['title'] = "Dashboard";
        $data['warehouse_list'] = $this->warehouse_model->get_warehouses();
        $this->load->view('customers/dashboard', $data);
    }
    public function view()
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = "list_customers";
        $data['title'] = "List Customers";
        $data['warehouse_list'] = $this->warehouse_model->get_warehouses();
        $this->load->view('customers/customer-list', $data);
    }
    function get_list()
    {
        $start         = $this->input->post('start');
        $length        = $this->input->post('length');
        $search_key    = $this->input->post('search');
        
        $values        = $this->customers_model->get_customers($start, $length, $search_key['value']);
        $value_count   = $this->customers_model->get_customers('', '', '');
        $totalData     = $value_count;
        $totalFiltered = $totalData;
        $data          = array();
        foreach ($values as $row) {
            $nestedData = array();
            $nestedData[] = $row->cus_code;
            $nestedData[] = $row->cus_name;
            $nestedData[] = $row->cus_email;
            $nestedData[] = $row->cus_phone;
            $nestedData[] = $row->cus_address;
            $actionTxtDisble = '';
            $actionTxtEnable = '';
            $actionTxtUpdate = '';
            $actionTxtDelete = '';
            $actionTxtUpdate = '<a onClick="click_customer_update_btn(' . $row->cus_id . ')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit customers"><i class="glyphicon fa fa-edit"></i></a> &nbsp;';
            if ($row->cus_status == 1) {
                $actionTxtDisble = '<a class="btn btn-xs btn-green tooltips" data-placement="top" data-original-title="Disable customer" onClick="disableCustomerData(' . $row->cus_id . ')"><i class="glyphicon fa fa-check"></i></a> &nbsp;';
            }
            if ($row->cus_status == 0) {
                $actionTxtEnable = '<a class="btn btn-xs btn-warning tooltips" data-placement="top" data-original-title="Disable customer" onClick="enableCustomerData(' . $row->cus_id . ')"><i class="glyphicon fa fa-minus-circle"></i></a> &nbsp;';
            }
            $actionTxtDelete = '<a class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Delete customer" onClick="deleteCustomerData(' . $row->cus_id . ')">
															<i class="glyphicon fa fa-trash-o"></i></a>';

            $nestedData[] = $actionTxtUpdate . $actionTxtDisble . $actionTxtEnable;
            $data[] = $nestedData;
        }

        $json_data = array(
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
    function save_customer(){
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('cus_first_name', 'Customer Name', 'required');
        $this->form_validation->set_rules('cus_last_name', 'Customer Name', 'required');
        $this->form_validation->set_rules('cus_phone', 'Customer Phone', 'required|is_unique[customer.cus_phone]');
        $this->form_validation->set_rules('cus_password', 'Password', 'required');
        $this->form_validation->set_rules('cus_city', 'Customer City', 'required');

        if ($this->form_validation->run() == FALSE) {
            $st = array('status' => 0, 'validation' => validation_errors());
            echo json_encode($st);
        } else {
            //$user_id = $this->input->post('user_id');
            $cus_first_name = $this->input->post('cus_first_name');
            $cus_last_name  = $this->input->post('cus_last_name');
            $cus_pass       = $this->input->post('cus_password');
            $cus_phone      = $this->input->post('cus_phone');
            $cus_city       = $this->input->post('cus_city');
            $cus_gender     = $this->input->post('cus_gender');

            $pwHashed = hash('sha512', $cus_pass);
            $user_data = array(
                'cus_first_name' => $cus_first_name,
                'cus_last_name' => $cus_last_name,
                'cus_password' => $pwHashed,
                'cus_phone' => $cus_phone,
                'city_id' => $cus_city,
                'cus_gender' => "",
                'branch_id' => $this->session->userdata('ss_branch_id'),
            );
            $last_id = $this->common_model->save($user_data,'customer');
            if ($last_id) {
                $st = array(
                    'success' => true,
                    'validation' => 'Done!',
                    'values' => array(
                        'last_id'=>$last_id
                        )
                );
                echo json_encode($st);
            } else {
                $st = array('status' => false, 'validation' => 'error occurred please contact your system administrator');
                echo json_encode($st);
            }
        }
    }
    /*  */
    public function login()
    {
        $st = array();
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('cus_phone', 'Mobile No', 'required');
        $this->form_validation->set_rules('cus_password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'success' => false,
                'validation' => validation_errors()
            );
        } else {
            $user_username = $this->input->post('cus_phone');
            $user_password      = $this->input->post('cus_password');
            //get user details by id
            $user_id       = $this->customers_model->login($user_username, $user_password);
            //echo "<br/>test:$user_id";
            if ($user_id) {
                $data['user_details'] = $this->customers_model->get_customer_info($user_id);
                //create sessions
                $ss_user_username     = $data['user_details']['cus_phone'];
                $ss_user_id           = $data['user_details']['cus_id'];
                $ss_group_id          = $data['user_details']['group_id'];
                $ss_branch_id      = $data['user_details']['branch_id'];
                $ss_user_first_name   = $data['user_details']['cus_first_name'];
                $ss_user_last_name    = $data['user_details']['cus_last_name'];
                $ss_user_group_name   = "customer";
                $ss_user_image        = "no";
                $sesdata              = array(
                    'ss_user_username' => $ss_user_username,
                    'ss_user_id' => $ss_user_id,
                    'ss_group_id' => $ss_group_id,
                    'ss_branch_id' => $ss_branch_id,
                    'ss_city_id' => $data['user_details']['city_id'],
                    'ss_user_first_name' => $ss_user_first_name,
                    'ss_user_last_name' => $ss_user_last_name,
                    'ss_user_group_name' => $ss_user_group_name,
                    'ss_user_image' => $ss_user_image
                );
                $this->user_model->create_user_sessions($sesdata);
                $st = array(
                    'success' => true,
                    'validation' => 'Done!'
                );
                $this->common_model->add_user_activitie("Customer Login");
            } else {
                $st = array(
                    'success' => false,
                    'validation' => validation_errors()
                );
            }
        }
        echo json_encode($st);
    }
    public function logout()
    {
        $sesdata = array(
            'ss_user_username' => '',
            'ss_user_id' => '',
            'ss_group_id' => '',
            'ss_branch_id' => '',
            'ss_user_first_name' => '',
            'ss_user_last_name' => '',
            'ss_user_group_name' => '',
            'ss_user_image' => ''
        );
        $this->common_model->add_user_activitie("Logout User");
        $this->user_model->delete_user_sessions($sesdata);
        redirect(base_url(), 'refresh');
    }
}
