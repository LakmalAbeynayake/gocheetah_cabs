<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Category extends CI_Controller
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
    var $sub_menu_name = "category";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('category_model');
        $this->load->model('common_model');
    }
    public function index()
    {
        $data['title'] = "Categories";
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = $this->sub_menu_name;
        $this->load->view('category/vehicle_category', $data);
    }
    public function add_category()
    {
        $data['id'] = 1;
        $this->load->view('models/create_category', $data);
    }
    public function edit_category($category_id)
    {
        $category_details = $this->category_model->getCategory_by_id($category_id);
        echo json_encode($category_details);
        /*$this->load->view('category/create_category', $data);*/
    }
    public function update()
    {
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('cat_id', 'Category ID', 'required');
        $this->form_validation->set_rules('cat_name', 'Category Name', 'required');
        $this->form_validation->set_rules('cat_price', 'Category Price', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'status' => 0,
                'validation' => validation_errors()
            );
            echo json_encode($st);
        } else {
            $cat_id = $this->input->post('cat_id');
            $data = array(
                'cat_name' => $this->input->post('cat_name'),
                'cat_description' => $this->input->post('cat_desc'),
                'cat_price' => $this->input->post('cat_price'),
            );
            if ($this->category_model->category_update($data, $cat_id)) {
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
            'getCategory' => $this->category_model->getCategory()
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
        $this->form_validation->set_rules('cat_name', 'Category Name', 'required|is_unique[vehicle_category.cat_name]');
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'status' => 0,
                'validation' => validation_errors()
            );
            echo json_encode($st);
        } else {
            $data1 = array(
                'cat_price' => $this->input->post('cat_price'),
                'cat_name' => $this->input->post('cat_name'),
                'cat_description' => $this->input->post('cat_desc'),
                'cat_image' => 'no-cat.jpg'
            );
            if ($this->common_model->save($data1, 'vehicle_category')) {
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
    public function get_category()
    {
        $values = $this->category_model->get_categories();
        $data   = array();
        if (!empty($values)) {
            foreach ($values as $categoriy) {
                if ($categoriy->cat_status == 0) {
                    $k = "btn-warning";
                    $m = "fa-minus-circle";
                } else {
                    $k = "btn-success";
                    $m = "fa-check";
                }
                $row    = array();
                $row[]  = '<div style="margin-bottom: 0px; height: 30px; width: 30px;" class="fileupload-new thumbnail"><img alt="" src="' . assets_url() . "uploads/thumbs/" . $categoriy->cat_image . '">
                </div>';
                $row[]  = strtoupper($categoriy->cat_name);
                $row[]  = strtoupper($categoriy->cat_description);
                $row[]  = strtoupper($categoriy->cat_price);
                $row[]  = ' 
                            <a class="btn btn-xs btn-primary" href="#" data-toggle="modal" onclick="category_edit(' . $categoriy->cat_id . ')"><i class="glyphicon fa fa-edit"></i></a>
                            <a class="btn btn-xs ' . $k . '" href="#" data-toggle="modal" onclick="change_status(' . $categoriy->cat_id . ',' . $categoriy->cat_status . ')"><i class="glyphicon fa ' . $m . '"></i></a>
                            <a class="btn btn-xs btn-danger" href="#" data-toggle="modal" onclick="perm_delete(' . $categoriy->cat_id . ')"><i class="glyphicon fa fa-trash-o"></i></a>';
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
    public function category_change_status()
    {
        if ($this->category_model->category_change_status($this->input->post('cat_id'), $this->input->post('status'))) {
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
    public function category_permanent_delete()
    {
        if ($this->category_model->category_permanent_delete($this->input->post('cat_id'))) {
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
}
