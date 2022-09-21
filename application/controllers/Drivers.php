<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Drivers extends CI_Controller
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
     * @see https://codeigniter.com/driver_guide/general/urls.html
     */
    private $default_image = '';
    public function __construct()
    {
        parent::__construct();
        $this->load->model('drivers_model');
        $this->load->model('common_model');
        $this->load->model('user_group_model');
        $this->load->model('warehouse_model');
    }
    public function index()
    {
        $this->load->view('driver/page-login');
    }
    function edit()
    {
        $data['main_menu_name']  = 'associates';
        $data['sub_menu_name']   = 'list-user';
        $data['title']           = 'Drivers';
        $id = $this->uri->segment(3);
        $data['warehouse_list']  =  $this->warehouse_model->get_warehouses();
        $data['driver_group_list'] =  $this->user_group_model->get_user_groups();
        $data['user']            =  $this->drivers_model->get_driver_info($id);
        /* print_r($data['user']);exit; */
        $data['default_image'] = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAa4AAAF4CAYAAAAMkh2oAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAAEnQAABJ0Ad5mH3gAAAdjaVRYdFhNTDpjb20uYWRvYmUueG1wAAAAAAA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzE0OCA3OS4xNjQwMzYsIDIwMTkvMDgvMTMtMDE6MDY6NTcgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdEV2dD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlRXZlbnQjIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIiB4bWxuczpwaG90b3Nob3A9Imh0dHA6Ly9ucy5hZG9iZS5jb20vcGhvdG9zaG9wLzEuMC8iIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1wTU06RG9jdW1lbnRJRD0iYWRvYmU6ZG9jaWQ6cGhvdG9zaG9wOmI4ZjYzM2UxLTA2MzYtMjc0ZC1iYWFjLThmOTE5MThlMGJiOSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpiZmM4MTQyMy02YzZjLTE4NDItOTU0OS03NjBkZmVkNjBlZTkiIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0iQzU3MkI4QjQ2MTc1QzUyRDBDNkJDQzU4QzNGMzEwODMiIGRjOmZvcm1hdD0iaW1hZ2UvcG5nIiBwaG90b3Nob3A6Q29sb3JNb2RlPSIzIiBwaG90b3Nob3A6SUNDUHJvZmlsZT0iIiB4bXA6Q3JlYXRlRGF0ZT0iMjAyMC0wNy0wMVQxODoyNDoxNiswNTozMCIgeG1wOk1vZGlmeURhdGU9IjIwMjAtMDctMDFUMjM6MzU6NDErMDU6MzAiIHhtcDpNZXRhZGF0YURhdGU9IjIwMjAtMDctMDFUMjM6MzU6NDErMDU6MzAiPiA8eG1wTU06SGlzdG9yeT4gPHJkZjpTZXE+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDoyODc3MjkwMS04YTE3LWFjNDEtOTBiZC0zMzFmYWZkYjhjMmQiIHN0RXZ0OndoZW49IjIwMjAtMDctMDFUMjM6MzU6NDErMDU6MzAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCAyMS4wIChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY29udmVydGVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJmcm9tIGltYWdlL2pwZWcgdG8gaW1hZ2UvcG5nIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJkZXJpdmVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJjb252ZXJ0ZWQgZnJvbSBpbWFnZS9qcGVnIHRvIGltYWdlL3BuZyIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6YmZjODE0MjMtNmM2Yy0xODQyLTk1NDktNzYwZGZlZDYwZWU5IiBzdEV2dDp3aGVuPSIyMDIwLTA3LTAxVDIzOjM1OjQxKzA1OjMwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgMjEuMCAoV2luZG93cykiIHN0RXZ0OmNoYW5nZWQ9Ii8iLz4gPC9yZGY6U2VxPiA8L3htcE1NOkhpc3Rvcnk+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjI4NzcyOTAxLThhMTctYWM0MS05MGJkLTMzMWZhZmRi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";
        $this->load->view('driver/driver-edit', $data);
    }
    function change_pw()
    {

    }
    function profile(){
        $this->load->model('customers_model');
        $driver_id = $this->session->userdata['ss_driver_id'];
        $data['main_menu_name']  = 'associates';
        $data['sub_menu_name']   = 'list-user';
        $data['title']           = 'Profile';
        $data['user'] = $this->drivers_model->get_driver_info($driver_id);
        $data['cus_count'] = $this->customers_model->get_cus_count_by_user($driver_id);
        $data[''] = $this->customers_model->get_cus_count_by_user($driver_id);
        $this->load->view('driver/driver-profile', $data);
    }
    public function login()
    {
        $st = array();
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('driver_username', 'Username', 'required');
        $this->form_validation->set_rules('driver_password', 'Username', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'success' => false,
                'validation' => validation_errors()
            );
        } else {
            $driver_username = $this->input->post('driver_username');
            $driver_password      = $this->input->post('driver_password');
            //get user details by id
            $driver_id       = $this->drivers_model->login($driver_username, $driver_password);
            //echo "<br/>test:$driver_id";
            if ($driver_id) {
                $data['driver_details'] = $this->drivers_model->get_driver_info($driver_id);
                //create sessions
                $ss_driver_username     = $data['driver_details']['driver_username'];
                $ss_driver_id           = $data['driver_details']['driver_id'];
                $ss_group_id            = $data['driver_details']['group_id'];
                $ss_branch_id        = $data['driver_details']['branch_id'];
                $ss_driver_first_name   = $data['driver_details']['driver_first_name'];
                $ss_driver_last_name    = $data['driver_details']['driver_last_name'];
                $ss_driver_group_name   = $data['driver_details']['driver_group_name'];
                $ss_driver_image        = $data['driver_details']['driver_image'];
                $sesdata              = array(
                    'ss_driver_username' => $ss_driver_username,
                    'ss_driver_id' => $ss_driver_id,
                    'ss_group_id' => $ss_group_id,
                    'ss_branch_id' => $ss_branch_id,
                    'ss_driver_first_name' => $ss_driver_first_name,
                    'ss_driver_last_name' => $ss_driver_last_name,
                    'ss_driver_group_name' => $ss_driver_group_name,
                    'ss_driver_image' => $ss_driver_image,
                );
                $this->drivers_model->create_driver_sessions($sesdata);
                $st = array(
                    'success' => true,
                    'validation' => 'Done!'
                );
                $this->common_model->add_driver_activitie("User Login");
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
            'ss_driver_username'  => '',
            'ss_driver_id'     => '',
            'ss_group_id' => '',
            'ss_branch_id' => '',
            'ss_driver_first_name' => '',
            'ss_driver_last_name' => '',
            'ss_driver_group_name' => ''
        );
        $this->common_model->add_driver_activitie("Logout User");
        $this->drivers_model->delete_driver_sessions($sesdata);
        redirect(base_url(), 'refresh');
    }
    function view_list()
    {
        $data['main_menu_name']  = 'associates';
        $data['sub_menu_name']   = 'drivers';
        $data['title']           = 'Drivers';
        $data['warehouse_list']  =  $this->warehouse_model->get_warehouses();
        $data['driver_group_list'] =  $this->user_group_model->get_user_groups();
        $this->load->view('driver/driver-list', $data);
    }
    public function save_user()
    {
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('driver_first_name', 'First Name', 'required');
        $this->form_validation->set_rules('driver_username', 'User Name', 'required|is_unique[driver.driver_username]');
        $this->form_validation->set_rules('driver_password', 'User Password', 'required');
        $this->form_validation->set_rules('driver_phone', 'User Phone', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array('status' => 0, 'validation' => validation_errors());
            echo json_encode($st);
        } else {
            //$driver_id = $this->input->post('driver_id');
            $driver_first_name = $this->input->post('driver_first_name');
            $driver_last_name = $this->input->post('driver_last_name');
            $driver_email = $this->input->post('driver_email');
            $driver_phone = $this->input->post('driver_phone');
            $driver_username = $this->input->post('driver_username');
            $driver_password = $this->input->post('driver_password');
            $driver_gender = $this->input->post('driver_gender');
            $group_id = $this->input->post('group_id');
            $branch_id = $this->input->post('branch_id');
            $driver_password = $this->input->post('driver_password');
            $driver_password_send = hash('sha512', $driver_password);
            $driver_data = array(
                'driver_first_name' => $driver_first_name,
                'driver_last_name' => $driver_last_name,
                'driver_email' => $driver_email,
                'driver_phone' => $driver_phone,
                'driver_gender' => $driver_gender,
                'group_id' => $group_id,
                'branch_id' => $branch_id,
                'driver_username' => $driver_username,
                'driver_password' => $driver_password_send,
                'driver_gender' => $driver_gender,
            );
            $last_id = $this->common_model->save($driver_data, 'driver');
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
                $st = array('success' => false, 'validation' => 'error occurred please contact your system administrator');
                echo json_encode($st);
            }
        }
    }
    public function update_user()
    {
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('driver_id', 'User ID', 'required');
        $this->form_validation->set_rules('driver_first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('driver_email', 'User Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('driver_phone', 'User Phone', 'trim|required');
        $this->form_validation->set_rules('group_id', 'User Group', 'required');
        $this->form_validation->set_rules('branch_id', 'Warehouse Group', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array('status' => 0, 'validation' => validation_errors());
            echo json_encode($st);
        } else {
            //$driver_id = $this->input->post('driver_id');
            $driver_first_name = $this->input->post('driver_first_name');
            $driver_last_name = $this->input->post('driver_last_name');
            $driver_email = $this->input->post('driver_email');
            $driver_phone = $this->input->post('driver_phone');
            $driver_username = $this->input->post('driver_username');
            $driver_gender = $this->input->post('driver_gender');
            $group_id = $this->input->post('group_id');
            $driver_id = $this->input->post('driver_id');
            $branch_id = $this->input->post('branch_id');
            $driver_image = $this->input->post('driver_image');

            $driver_data = array(
                'driver_first_name' => $driver_first_name,
                'driver_last_name' => $driver_last_name,
                'driver_email' => $driver_email,
                'driver_phone' => $driver_phone,
                'group_id' => $group_id,
                'branch_id' => $branch_id,
                'driver_gender' => $driver_gender,
                'driver_image' => $driver_image
            );
            $this->db->trans_begin();
            $this->db->trans_strict();
            $num_rows = $this->drivers_model->update_user($driver_data, $driver_id);
            if ($num_rows) {
                $this->db->trans_commit();
                $st = array('success' => true, 'validation' => 'Done!');
                echo json_encode($st);
            } else {
                $this->db->trans_rollback();
                $st = array('status' => false, 'validation' => 'error occurred please contact your system administrator');
                echo json_encode($st);
            }
        }
    }
    function get_list()
    {
        $branch_id = $this->input->get('srh_warehouse_id');
        $group_id = $this->input->get('srh_user_group_id');
        $values = $this->drivers_model->get_Drivers($branch_id, $group_id);
        $data = array();
        if (!empty($values)) {
            foreach ($values as $Drivers) {
                $row = array();
                $driver_id = $Drivers->driver_id;
                $row[] = $Drivers->driver_first_name;
                $row[] = $Drivers->driver_last_name;
                $row[] = $Drivers->driver_phone;
                $row[] = $Drivers->driver_email;
                $row[] = $Drivers->driver_gender;
                $row_action = '<div class="btn-group text-left">
                                <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                                <ul role="menu" class="dropdown-menu pull-right">';
                if ($Drivers->driver_status == 1) {
                    $row_action .= ' <li><a style="cursor: pointer;" onClick="disableUserData(' . $Drivers->driver_id . ')"><i class="fa fa-minus-circle"></i> Disable Driver</a></li>';
                }
                if ($Drivers->driver_status == 0) {
                    $row_action .= ' <li><a style="cursor: pointer;" onClick="enableUserData(' . $Drivers->driver_id . ')"><i class="fa fa-check"></i> Enable Driver</a></li>';
                }
                $row_action .= '<li><a href="' . base_url() . 'Drivers/edit/' . $driver_id . '"><i class="fa fa-edit"></i> Edit Info</a></li>
								<li class="divider"></li>
                                <li><a href="' . base_url() . 'Drivers/change_pw/' . $driver_id . '"><i class="fa fa-pencil"></i> Change Password</a></li>
                            </ul>
                        </div>';
                $row[] = $row_action;
                $data[] = $row;
            }
            $output = array('data' => $data);
            echo json_encode($output);
        } else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    }
}
