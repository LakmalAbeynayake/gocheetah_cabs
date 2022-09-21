<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Vehicles extends CI_Controller
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
    var $main_menu_name = "vehicles";
    var $sub_menu_name = "vehicle_list";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('vehicles_model');
        $this->load->model('vehicles_model');
        $this->load->model('common_model');
    }
    public function index()
    {
        $data['title'] = "Categories";
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = $this->sub_menu_name;
        $this->load->model('category_model');
        $this->load->model('drivers_model');
        $data['main_category']  = $this->category_model->get_categories();
        $data['drivers']  = $this->drivers_model->get_drivers();
        $this->load->view('vehicles/vehicles', $data);
    }
    public function edit_vehicles($vehicles_id)
    {
        $vehicles_details = $this->vehicles_model->get_vehicle_by_id($vehicles_id);
        echo json_encode($vehicles_details);
    }
    public function update()
    {
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('veh_number', 'Vehicle Number', 'required');
        $this->form_validation->set_rules('driver_id', 'Driver Name', 'required');
        $this->form_validation->set_rules('veh_cat', 'Vehicle Category', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'status' => 0,
                'validation' => validation_errors()
            );
            echo json_encode($st);
        } else {
            $veh_id = $this->input->post('veh_id');
            $data = array(
                'veh_name' => $this->input->post('veh_name'),
                'veh_description' => $this->input->post('veh_desc'),
                'veh_price' => $this->input->post('veh_price'),
            );
            if ($this->vehicles_model->vehicles_update($data, $veh_id)) {
                $st = array(
                    'status' => 1,
                    'validation' => 'Done!'
                );
                echo json_encode($st);
            } else {
                $st = array(
                    'status' => 0,
                    'validation' => 'error occurred please contact your system administrator'
                );
                echo json_encode($st);
            }
        }
    }
    public function add_subcategory()
    {
        $data = array(
            'getCategory' => $this->vehicles_model->getCategory()
        );
        $this->load->view('models/create_sub_category', $data);
    }
    public function getProduct($value = '')
    {
        $arrayName = array(
            'id' => 123
        );
        echo json_encode($arrayName);
    }
    public function save()
    {
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('veh_number', 'Vehicle Number', 'required');
        $this->form_validation->set_rules('driver_id', 'Driver Name', 'required');
        $this->form_validation->set_rules('cat_id', 'Vehicle Category', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'status' => 0,
                'validation' => validation_errors()
            );
            echo json_encode($st);
        } else {
            $data1 = array(
                'veh_number' => $this->input->post('veh_number'),
                'driver_id' => $this->input->post('driver_id'),
                'branch_id' =>  $this->session->userdata('ss_branch_id'),
                'veh_cat' => $this->input->post('cat_id'),
                'veh_status' => 'available',
            );
            if ($this->common_model->save($data1, 'vehicle')) {
                $st = array(
                    'status' => 1,
                    'validation' => 'Done!'
                );
                echo json_encode($st);
            } else {
                $st = array(
                    'status' => 0,
                    'validation' => 'error occurred please contact your system administrator'
                );
                echo json_encode($st);
            }
        }
    }
    public function get_vehicle()
    {
        $values = $this->vehicles_model->get_vehicles();
        $data   = array();
        if (!empty($values)) {
            foreach ($values as $categoriy) {
                if ($categoriy->veh_status == 0) {
                    $k = "btn-warning";
                    $m = "fa-minus-circle";
                } else {
                    $k = "btn-success";
                    $m = "fa-check";
                }
                $row    = array();
                $row[]  = '<div style="margin-bottom: 0px; height: 30px; width: 30px;" class="fileupload-new thumbnail"><img alt="" src="' . assets_url() . "uploads/thumbs/" . $categoriy->veh_image . '">
                </div>';
                $row[]  = strtoupper($categoriy->veh_number);
                $row[]  = strtoupper($categoriy->cat_name);
                $row[]  = strtoupper($categoriy->driver_first_name);
                $row[]  = strtoupper($categoriy->veh_status);
                $row[]  = ' 
                            <a class="btn btn-xs btn-primary" href="#" data-toggle="modal" onclick="vehicles_edit(' . $categoriy->veh_id . ')"><i class="glyphicon fa fa-edit"></i></a>
                            <a class="btn btn-xs ' . $k . '" href="#" data-toggle="modal" onclick="change_status(' . $categoriy->veh_id . ',' . $categoriy->veh_status . ')"><i class="glyphicon fa ' . $m . '"></i></a>
                            <a class="btn btn-xs btn-danger" href="#" data-toggle="modal" onclick="perm_delete(' . $categoriy->veh_id . ')"><i class="glyphicon fa fa-trash-o"></i></a>';
                $data[] = $row;
            }
            $output = array(
                'data' => $data
            );
            echo json_encode($output);
        } else {
            $output = array(
                'data' => ''
            );
            echo json_encode($output);
        }
    }
    public function vehicles_change_status()
    {
        if ($this->vehicles_model->vehicles_change_status($this->input->post('veh_id'), $this->input->post('status'))) {
            $st = array(
                'status' => 1,
                'validation' => 'Done!'
            );
            echo json_encode($st);
        } else {
            $st = array(
                'status' => 0,
                'validation' => 'error occurred please contact your system administrator'
            );
            echo json_encode($st);
        }
    }
    public function vehicles_permanent_delete()
    {
        if ($this->vehicles_model->vehicles_permanent_delete($this->input->post('veh_id'))) {
            $st = array(
                'status' => 1,
                'validation' => 'Done!'
            );
            echo json_encode($st);
        } else {
            $st = array(
                'status' => 0,
                'validation' => 'cannot delete parent category with children categorys existing'
            );
            echo json_encode($st);
        }
    }
    function check(){
        $cat_id = $this->input->post('category_id');
        $count = $this->vehicles_model->check($cat_id);
        echo json_encode(array(
            'success' => $count > 0 ? true:false
        ));
    }
}
