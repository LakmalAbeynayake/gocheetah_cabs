<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Journeys extends CI_Controller
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
    var $main_menu_name = "Journeys";
    var $sub_menu_name = "";
    var $title = "Journeys";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('common_model');
        $this->load->model('journeys_model');
        $this->load->model('category_model');
        $this->load->model('warehouse_model');
    }
    public function index()
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'Journeys';
        $data['title']          = $this->title;
        $data['main_category']  = $this->category_model->get_categories();
        $data['warehouse']      = $this->warehouse_model->get_warehouses();
        $this->load->view('journeys/journeys-list', $data);
    }
    public function add()
    {
        $data['main_menu_name'] = 'new_journey';//$this->main_menu_name;
        $data['sub_menu_name']  = 'new_journey';
        $data['title']          = $this->title;
        $data['main_category']  = $this->category_model->get_categories();
        $this->load->view('journeys/journeys-add', $data);
    }
    
    public function get_sub_category_by_id()
    {
        $parent_category = $this->input->post('category_id');
        if ($parent_category) {
            $val = $this->category_model->get_sub_category($parent_category);
            if (!empty($val)) {
                echo '<select onchange="products_load()" name="subcategory" id="subcategory" class="form-control search-select">';
                echo "<option value=''></option>";
                foreach ($val as $key => $lst) {
                    echo "<option value='$lst->sub_cat_id'>$lst->sub_cat_name</option>";
                }
                echo '</select>';
            }
        } else {
            echo NULL;
        }
    }
    public function save()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('lat', 'Mark pickup location', 'required');
        $this->form_validation->set_rules('lng', 'Mark pickup location', 'required');
        
        $this->form_validation->set_rules('lat_drop_off', 'Mark drop-off location', 'required');
        $this->form_validation->set_rules('lng_drop_off', 'Mark drop-off location', 'required');
        
        $this->form_validation->set_rules('distance', 'Mark drop-off location', 'required');
        $this->form_validation->set_rules('category', 'Select vehicle category', 'required');

        
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'status' => false,
                'validation' => validation_errors()
            );
            echo json_encode($st);
        } else {
            $product_info        = array(
                'cus_id' => $this->session->userdata('ss_user_id'),
                'drv_id' => "",
                'veh_cat_id' => $this->input->post('category'),
                'city' => $this->session->userdata('ss_city_id'),
                
                'start_lat' => $this->input->post('lat'),
                'start_lng' => $this->input->post('lng'),
                
                'end_lat' => $this->input->post('lat_drop_off'),
                'end_lng' => $this->input->post('lng_drop_off'),

                'start_time' => "",
                'end_time' => "",
                'price' => $this->input->post('total_val'),
                'drv_rate' => "",
                'trip_status' => ""
            );
            $last_id             = $this->common_model->save($product_info, 'journeys');
            if ($last_id) {
                $st = array(
                    'success' => true,
                    'validation' => 'Done!',
                    'values' => array(
                        'last_id' => $last_id
                    )
                );
                echo json_encode($st);
            } else {
                $st = array(
                    'status' => false,
                    'validation' => 'Error occurred. please contact your system administrator.'
                );
                echo json_encode($st);
            }
        }
    }
    public function update_product()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('product_id', 'Product ID', 'required');
        $this->form_validation->set_rules('product_name', 'Product Name', 'required');
        $this->form_validation->set_rules('product_cost', 'product Cost', 'required');
        $this->form_validation->set_rules('product_price', 'product Price', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'status' => false,
                'validation' => validation_errors()
            );
            echo json_encode($st);
        } else {
            $product_id          = $this->input->post('product_id');
            $product_name        = $this->input->post('product_name');
            $category            = $this->input->post('category');
            $subcategory         = $this->input->post('subcategory');
            $unit                = $this->input->post('unit');
            $si_prefix                = $this->input->post('si_prefix');
            $product_cost        = $this->input->post('product_cost');
            $product_price       = $this->input->post('product_price');
            $alert_qty           = $this->input->post('alert_qty');
            $product_image       = $this->input->post('product_image');
            $product_description = $this->input->post('product_description');
            $store_position      = $this->input->post('store_position');
            $product_max_qty     = $this->input->post('product_max_qty');
            $product_info        = array(
                'cat_id' => $category,
                'sub_cat_id' => $subcategory,
                'product_name' => $product_name,
                'product_image' => $product_image,
                'product_alert_qty' => $alert_qty,
                'product_max_qty' => $product_max_qty,
                'product_unit' => $unit,
                'product_prefix' => $si_prefix,
                'product_cost' => $product_cost,
                'product_price' => $product_price,
                'product_description' => $product_description,
                'store_position' => $store_position,
                'product_type' => 1
            );
            $last_id             = $this->journeys_model->update_product($product_info, $product_id);
            if ($last_id) {
                $st = array(
                    'success' => true,
                    'validation' => 'Done!',
                    'values' => array(
                        'last_id' => $last_id
                    )
                );
                echo json_encode($st);
            } else {
                $st = array(
                    'status' => false,
                    'validation' => 'Error occurred. please contact your system administrator.'
                );
                echo json_encode($st);
            }
        }
    }
    function price_filter($amount = '')
    {
        $s = array();
        $s = explode("Rs.", $amount);
        return str_replace(',', '', $s[1]);
    }
    function get_list()
    {
        $this->load->model('stock_model');
        $start         = $this->input->post('start');
        $length        = $this->input->post('length');
        $search_key    = $this->input->post('search');
        $filter['search_key_val']        = $search_key['value'];
        $filter['cat_id']       = $this->input->post('cat_id');
        $filter['date']   = $this->input->post('date');
        $filter['branch_id']     = $this->input->post('branch_id');

        $values        = $this->journeys_model->get_journeys($start, $length, $filter);
        $value_count   = $this->journeys_model->get_journeys('', '', '');
        $totalData     = $value_count;
        $totalFiltered = $totalData;
        $data          = array();
        if (!empty($values)) {
            foreach ($values as $products) {
                $row     = array();
                $row[]   = $products->added_date_time;
                $row[]   = $products->start_time;
                $row[]   = $products->end_time;
                $row[]   = $products->trip_status;
                $row[]   = $products->cat_name;
                $row[]   = $products->cus_id;
                $row[]   = $products->drv_id;
                $row[]   = $products->price;
                
                $row[]  = '
                <div class="dropdown show">
                    <a class="btn btn-default dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        ACTIONS <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="' . base_url() . 'journeys/view?product_id=' . $products->journey_id . '"><i class="fa fa-file"></i> Details</a></a>
                        </li>
                    </ul>
                </div>';
                $data[] = $row;
            }
        }
        $output = array(
            'data' => $data,
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered)
        );
        echo json_encode($output);
    }
    function suggestions()
    {
        $term = $this->input->get('term');
        $data['sales'] = $this->journeys_model->get_products_suggestions($term);
        $json = array();
        foreach ($data['sales'] as $row) {
            $extraName = ", Cost Price: " . number_format($row['product_cost'], 2, '.', ',');
            $json_itm = array(
                'value' => $row,
                'label' => $row['product_name'] . " (" . $row['product_code'] . ")$extraName"
            );
            array_push($json, $json_itm);
        }
        echo json_encode($json);
    }
    function suggestions_batch()
    {
        $this->load->model('purchases_model');
        $term = $this->input->get('term');
        $data['sales'] = $this->journeys_model->get_products_suggestions($term);
        $json = array();
        foreach ($data['sales'] as $row) {
            $batches = $this->purchases_model->get_batches(array('product_id' => $row['product_id'], 'pb_in_use' => 1, 'branch_id' => $this->session->userdata('ss_branch_id')));
            if (empty($batches)) continue;
            foreach ($batches as $btch) {
                $row['batches'][] = array(
                    'pd_id' => floatval($btch->pb_id),
                    'pb_code' => $btch->pb_code,
                    'pd_cost' => floatval($btch->pb_cost)
                );
            }
            $extraName = ", Cost Price: " . number_format($row['product_cost'], 2, '.', ',');
            $json_itm = array(
                'value' => $row,
                'label' => $row['product_name'] . " (" . $row['product_code'] . ")$extraName"
            );
            array_push($json, $json_itm);
        }
        echo json_encode($json);
    }
    function suggestions_batch_issue()
    {
        $this->load->model('production_model');
        $this->load->model('purchases_model');
        $term = $this->input->get('term');
        $branch_id = $this->session->userdata('ss_branch_id');
        $data['sales'] = $this->journeys_model->get_products_suggestions($term);
        $json = array();
        foreach ($data['sales'] as $row) {
            $add = false;
            /* purchased batches */
            $batches = $this->purchases_model->get_batches(array('product_id' => $row['product_id'], 'pb_in_use' => 1, 'branch_id' => $branch_id));
            if (!empty($batches)) {
                foreach ($batches as $btch) {
                    $row['batches'][] = array(
                        'pd_id' => floatval($btch->pb_id),
                        'pb_code' => $btch->pb_code,
                        'pd_cost' => floatval($btch->pb_cost),
                        'b_type'  =>'purchase'
                    );
                }
                /* $extraName = ", Cost Price: " . number_format($row['product_cost'], 2, '.', ',');
                $json_itm = array(
                    'value' => $row,
                    'label' => $row['product_name'] . " (" . $row['product_code'] . ")$extraName"
                );
                array_push($json, $json_itm); */
                $add = true;
            }
            /* end */
            /* production batches */
            /* $sel_open   =   '<select class="form-control batch_sel" name="row['.$row['product_id'].'][batch_id]" id="batch_'.$row['product_id'].'" data-raw_mat_id="'.$row['product_id'].'">';
            $sel_close  =   '</select>';
            $options    =   ''; */

            $pro_batches = $this->production_model->get_batches(array('product_id' => $row['product_id'], 'prdb_in_use' => 1, 'branch_id' => $branch_id));
            if (!empty($pro_batches)) {
                foreach ($pro_batches as $btch) {
                    $row['batches'][] = array(
                        'pd_id' => floatval($btch->prdb_id),
                        'pb_code' => $btch->prdb_code,
                        'pd_cost' => floatval($btch->prdb_cost),
                        'b_type'  =>'production'
                    );
                }
                $add = true;
            }
            if ($add) {
                $extraName = "";
                $json_itm = array(
                    'value' => $row,
                    'label' => $row['product_name'] . " (" . $row['product_code'] . ")$extraName"
                );
                array_push($json, $json_itm);
            }
            /* end */
        }
        echo json_encode($json);
    }
    /* 
        $this->load->model('purchases_model');
        $this->load->model('production_model');
        $this->load->model('stock_model');

        $product_id = $this->input->post('product_id');
        $production_qty = $this->input->post('production_qty');
        $branch_id = $this->input->post('branch_id') ? $this->input->post('branch_id'): $this->session->userdata('ss_branch_id');
        $recipe  = $this->journeys_model->get_recipes($product_id);
        $data = array();
        foreach ($recipe as $rc) {
            $row = array();
            //print_r($rc);
            $sel_open   =   '<select class="form-control batch_sel" name="row['.$rc->raw_mat_id.'][batch_id]" id="batch_'.$rc->raw_mat_id.'" data-raw_mat_id="'.$rc->raw_mat_id.'">';
            $sel_close  =   '</select>';
            $options    =   '';
            
            $pur_batches = $this->purchases_model->get_batches(array('product_id' => $rc->raw_mat_id, 'pb_in_use' => 1, 'branch_id' => $branch_id ));
            if (!empty($pur_batches))
            foreach ($pur_batches as $btch) {
                $bal = $this->stock_model->get_qty($btch->pb_id);
                $options .= '<option value="'.$btch->pb_id.'" data-batch_type="purchase" data-balance="'.floatval($bal).'" data-cost="'.$btch->pb_cost.'">'.$btch->pb_code.'-'.$btch->pb_cost.'</option>';
            }
            $pro_batches = $this->production_model->get_batches(array('product_id' => $rc->raw_mat_id, 'prdb_in_use' => 1, 'branch_id' => $branch_id ));
            if (!empty($pro_batches))
            foreach ($pro_batches as $btch) {
                $bal = $this->stock_model->get_qty_by_product_id_n_warehouse_id($rc->raw_mat_id,$branch_id,$btch->prdb_id,"production");
                //$options .= '<option value="'.$btch->batch_no.'" data-batch_type="purchase" data-balance="'.floatval($bal).'" data-cost="'.$btch->product_cost.'">'.$btch->batch_no.'-'.$btch->product_cost.'</option>';
                $options .= '<option value="'.$btch->prdb_id.'" data-batch_type="production" data-balance="'.floatval($bal).'" data-cost="'.$btch->prdb_cost.'">'.$btch->prdb_code.'-'.$btch->prdb_cost.'</option>';
            }
            $row[] = $rc->product_name.'<input type="hidden" name="row['.$rc->raw_mat_id.'][raw_mat_id]" id="raw_mat_id_'.$rc->raw_mat_id.'" value="'.$rc->raw_mat_id.'">';
            $row[] = $sel_open.$options.$sel_close;
            $row[] = '<span id="available_sp_'.$rc->raw_mat_id.'"></span><input type="hidden" name="row['.$rc->raw_mat_id.'][available_qty]" id="available_'.$rc->raw_mat_id.'">';
            $row[] = '<span id="required_sp_'.$rc->raw_mat_id.'">'.number_format(($production_qty*$rc->raw_mat_qty),2,".",",").'</span><input type="hidden" name="row['.$rc->raw_mat_id.'][required_qty]" id="required_'.$rc->raw_mat_id.'" value="'.($production_qty*$rc->raw_mat_qty).'">';
            $row[] = '<span id="balance_sp_'.$rc->raw_mat_id.'" style="vertical-align: -webkit-baseline-middle;"></span><input type="hidden" name="row['.$rc->raw_mat_id.'][balance_qty]" id="balance_qty'.$rc->raw_mat_id.'" value="">';
            $row[] = '<span id="status_sp_'.$rc->raw_mat_id.'"></span><input type="hidden" name="row['.$rc->raw_mat_id.'][batch_cost]" id="batch_cost_'.$rc->raw_mat_id.'"><input type="hidden" name="row['.$rc->raw_mat_id.'][batch_type]" id="batch_type_'.$rc->raw_mat_id.'">';
            $data[] = $row;
        }
        */
    function get_product()
    {
        $srh_product_id = $this->input->get('srh_product_id');
        $response = $this->journeys_model->get_product($srh_product_id);
        echo json_encode($response);
    }
    function view()
    {
        $product_id = $this->input->get('product_id');
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'list_products';
        $data['title']          = "View product";
        $data['product']  = $this->journeys_model->get_product_by_id($product_id);
        $data['recipe']  = $this->journeys_model->get_recipes($product_id);
        $this->load->view('product/product-info', $data);
    }
    function edit()
    {
        $product_id = $this->input->get('product_id');
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'list_products';
        $data['title']          = "Edit product";
        $data['product']  = $this->journeys_model->get_product_by_id($product_id);
        $data['main_category']  = $this->category_model->get_categories();
        $data['unit_type']      = $this->journeys_model->get_units();
        $data['prefix_list']    = $this->journeys_model->get_prefix();
        $this->load->view('product/product-edit', $data);
    }
    /* assign raw materials */
    function set_raw_materials()
    {
        $success = false;
        $current_quantity = 0;
        $product_id = 0;

        /* item fields */
        $product_id  = $this->input->post('product_id');
        $raw_mat_id  = $this->input->post('raw_mat_id');
        $raw_mat_qty = $this->input->post('raw_mat_qty');

        $num_romw = $this->journeys_model->update_raw_mat_qty($product_id, $raw_mat_id, $raw_mat_qty);
        if (!$num_romw) {
            $last_id = $this->common_model->save(array('product_id' => $product_id, 'raw_mat_id' => $raw_mat_id, 'raw_mat_qty' => $raw_mat_qty,), 'recipes');
            if ($last_id)
                $success = true;
        } else
            $success = true;
        echo json_encode(array(
            'success' => $success
        ));
    }
    function delete_raw_mat()
    {
        $product_id = $this->input->post('product_id');
        $raw_mat_id = $this->input->post('raw_mat_id');

        $success = $this->journeys_model->delete_recipe_item($product_id, $raw_mat_id);
        echo json_encode(array(
            'success' => $success
        ));
    }
    function get_products_ajax()
    {
        $str    = $this->input->get('search_string');
        $result = $this->journeys_model->get_products_ajax($str);
        echo json_encode($result);
    }
    function get_products_ajax_all()
    {
        $str    = $this->input->get('search_string');
        $result = $this->journeys_model->get_products_ajax_all($str);
        echo json_encode($result);
    }
}
