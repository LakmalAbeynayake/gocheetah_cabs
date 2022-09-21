<?php

class Common_Model extends CI_Model
{


	function __construct()
	{
		/* Call the Model constructor */
		parent::__construct();
	}
	//User Activities
	public function add_user_activitie($details)
	{
		$data = array(
			'details'   => $details,
			'page'  => base_url(uri_string()),
			'user_id'  =>  $this->session->userdata('ss_user_id'),
			'branch_id'  => $this->session->userdata('ss_branch_id'),
			'datetime'     => date("Y-m-d H:i:s"),
			'ip'     => $this->input->ip_address()
		);

		if ($this->db->insert('logs', $data)) {
			return $this->db->insert_id();
		}
		//else
		{
			return false;
		}
	}

	/* Navigation Menu for user group */

	function get_all_navs()
	{
		$nav = array();

		$this->db->select('*');
		$this->db->order_by("menu_order", "asc");
		$this->db->where("menu_parent_id", "0");
		$this->db->where("is_nav", "1");
		$this->db->where("menu_status", "1");
		$nav_main_list = $this->db->get('user_nav_menu');
		$nav_main_list = $nav_main_list->result_array();

		foreach ($nav_main_list as $row) {
			$has_permission = $this->check_permission($row['menu_id'], $this->session->userdata('ss_group_id'), 1);
			if ($has_permission) {
			} else continue;
			$nav_main = array(
				"id" => $row['menu_id'],
				"main_menu_name" => $row['menu_name'],
				"display_name" => $row['menu_display_name'],
				"url" => $row['menu_url'],
				"subs" => ""
			);
			$nav_sub = array();
			$this->db->select('*');
			$this->db->where("menu_parent_id", $row['menu_id']);
			$this->db->where("menu_status", "1");
			$this->db->order_by("menu_order", "asc");
			$nav_sub = $this->db->get('user_nav_menu');
			$nav_sub = $nav_sub->result_array();

			$sub_list = array();
			foreach ($nav_sub as $row_sub) {
				if ($this->check_permission($row_sub['menu_id'], $this->session->userdata('ss_group_id'), 1)) {
				} else continue;
				$sub = array(
					"id" => $row_sub["menu_id"],
					"display_name" => $row_sub["menu_display_name"],
					"sub_menu_name" => $row_sub["menu_name"],
					"url" => $row_sub["menu_url"],
				);
				array_push($sub_list, $sub);
			}
			$nav_main["subs"] = $sub_list;

			array_push($nav, $nav_main);
		}
		return $nav;
	}
	function get_all_navs_no_filter()
	{
		$nav = array();

		$this->db->select('*');
		$this->db->order_by("menu_order", "asc");
		$this->db->where("menu_parent_id", "0");
		$this->db->where("is_nav", "1");
		$this->db->where("menu_status", "1");
		$nav_main_list = $this->db->get('user_nav_menu');
		$nav_main_list = $nav_main_list->result_array();

		foreach ($nav_main_list as $row) {
			$nav_main = array(
				"id" => $row['menu_id'],
				"main_menu_name" => $row['menu_name'],
				"display_name" => $row['menu_display_name'],
				"url" => $row['menu_url'],
				"subs" => ""
			);
			$nav_sub = array();
			$this->db->select('*');
			$this->db->where("menu_parent_id", $row['menu_id']);
			$this->db->where("menu_status", "1");
			$this->db->order_by("menu_order", "asc");
			$nav_sub = $this->db->get('user_nav_menu');
			$nav_sub = $nav_sub->result_array();

			$sub_list = array();
			foreach ($nav_sub as $row_sub) {
				$sub = array(
					"id" => $row_sub["menu_id"],
					"display_name" => $row_sub["menu_display_name"],
					"sub_menu_name" => $row_sub["menu_name"],
					"url" => $row_sub["menu_url"],
				);
				array_push($sub_list, $sub);
			}
			$nav_main["subs"] = $sub_list;

			array_push($nav, $nav_main);
		}
		return $nav;
	}

	function save_menu($nav_menu)
	{
		if ($nav_menu) {
			if ($this->db->insert("user_nav_menu", $nav_menu)) {
				return $this->db->insert_id();
			} else return 0;
		}
	}

	// nav configs

	function list_menu()
	{
		$this->db->select('*');
		$this->db->where("menu_status", "1");
		$nav_sub = $this->db->get('user_nav_menu');
		return $nav_sub->result_array();
	}
	function list_nav_menu()
	{
		$this->db->select('*');
		$this->db->where("menu_status", "1");
		$this->db->where("is_nav", "1");
		$nav_sub = $this->db->get('user_nav_menu');
		return $nav_sub->result_array();
	}
	function list_perms()
	{
		$this->db->select('*');
		$this->db->where("menu_status", "1");
		$this->db->where("is_nav", "0");
		$nav_sub = $this->db->get('user_nav_menu');
		return $nav_sub->result_array();
	}

	/* permission rules */

	function add_rule($rule_data)
	{
		if ($rule_data) {
			if ($this->db->insert("permission_allocation", $rule_data)) {
				return $this->db->insert_id();
			} else return 0;
		}
	}

	function update_rule($where, $per_data)
	{
		if ($where) {
			$this->db->where($where);
			if ($this->db->update('permission_allocation', $per_data)) {
				return $this->db->affected_rows();
			} else return 0;
		} else return 0;
	}

	public function get_user_groups()
	{
		$this->db->select('*');
		$this->db->order_by("user_group_id", "asc");
		$query = $this->db->get("user_group");
		return $query->result_array();
	}
	/* END NAVIGATION */
	function check_permission($menu_id, $group_id, $gp_id)
	{
		$this->db->select('*');
		$this->db->from('permission_allocation');
		$array = array('menu_id' => $menu_id, 'group_id' => $group_id, 'gp_id' => $gp_id, 'has_permission' => 1);
		$this->db->where($array);
		$query = $this->db->get();
		if ($query->num_rows())
			return $query->row()->has_permission;
		else return 0;
	}

	function reset_group_permission($group_id)
	{
		$menu = $this->list_menu();
		foreach ($menu as $mnu) {
			$where = array(
				'menu_id' => $mnu['menu_id'],
				'group_id' => $group_id,
				'gp_id' => 1
			);
			$perm_data = array(
				"has_permission" => 0
			);
			$this->update_rule($where, $perm_data);
		}
	}
	//works above
	function get_all_country()
	{
		$this->db->select('country_id, country_short_name');
		$this->db->order_by("country_short_name", "asc");
		$this->db->where("country_status", "1");
		$query = $this->db->get('mstr_country');
		return $query->result_array();
	}

	function get_all_status()
	{
		$this->db->select('mstr_status.*');
		$this->db->order_by("status_order", "desc");
		$this->db->where("status_staus", "1");
		$query = $this->db->get('mstr_status');
		return $query->result_array();
	}

	function get_all_cr_limit()
	{
		$this->db->select('*');
		$this->db->order_by("cr_limit_status", "asc");
		$this->db->where("cr_limit_status", "1");
		$query = $this->db->get('mstr_cr_limit');
		return $query->result_array();
	}

	public function get_cr_limit_name_by_val($cr_limit_value)
	{
		$this->db->select('cr_limit_name');
		$this->db->order_by("cr_limit_name", "asc");
		$this->db->where("cr_limit_value", $cr_limit_value);
		$query = $this->db->get('mstr_cr_limit');
		return $query->result_array();
	}

	public function get_country_name_by_id($country_id)
	{
		$this->db->select('country_short_name');
		$this->db->order_by("country_short_name", "asc");
		$this->db->where("country_id", $country_id);
		$query = $this->db->get('mstr_country');
		return $query->result_array();
	}

	public function get_city_list_by_country_id($country_id)
	{
		$this->db->select('cname,cid');
		$this->db->order_by("cname", "asc");
		$this->db->where("country_id", $country_id);
		$query = $this->db->get('mstr_city');
		//echo $this->db->last_query();
		return $query->result();
	}
	
	public function gen_ref_number($column_name, $table_name, $pre_fix)
	{
		$this->db->select_max($column_name);
		$query = $this->db->get($table_name);
		if ($query->num_rows() > 0) {
			$g = $query->result();
			$u = $this->set_ref_no($g[0]->$column_name, $pre_fix);
			return $u;
		} else {
			return false;
		}
	}
	public function gen_ref_number_v1($column_name, $table_name, $pre_fix, $where = array())
	{
		$this->db->select('count('.$column_name.') as count');
		if(!empty($where))
		$this->db->where($where);
		//$this->db->where('date(date_time) >=', date('Y-m-01'));
		$query = $this->db->get($table_name);
		if ($query->num_rows() > 0) {
			$g = $query->row();
			$u = $this->set_ref_no($g->count, $pre_fix);
			return $u;
		} else {
			return false;
		}
	}

	function set_ref_no($count, $pre_fix)
	{
		$w = '';
		$d = date('Y/m/');
		if ($pre_fix) {
			$w = $pre_fix;
		}
		$w = $w . sprintf("%04d", $count + 1);
		return $w;
	}
	function get_max_value($column_name,$table_name){
		$this->db->select_max($column_name);
		$query = $this->db->get($table_name);
		return $query->result();
	}
	function get_next_value($column_name,$table_name,$branch_id){
		$this->db->select_max($column_name);
		$this->db->where('branch_id',$branch_id);
		$query = $this->db->get($table_name);
		return $query->row()->$column_name + 1;
	}

	public function add_fi_table($type, $ref_id, $product, $quantity, $unit_cost)
	{
		$data = array(
			'fi_type_id'  => $type,
			'fi_ref_id'   => $ref_id,
			'fi_item_id'  => $product,
			'fi_qty'      => $quantity,
			'fi_cost'     => $unit_cost
		);

		if ($this->db->insert('fi_table', $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	public function check_option_valable_by_setting_id($sett_id)
	{
		$this->db->select('s.sett_status');
		$this->db->from('setting s');
		$this->db->where("s.sett_id", $sett_id);
		//$this->db->where('sis.pis_number',$pis_number);
		//$query = $this->db->get('s.sett_status');
		$query = $this->db->get();
		$rtn_des = $query->result();
		return intval($rtn_des[0]->sett_status);
	}


	function change_user_group_permission_details_view_by_page($where, $page = false, $user_group_id)
	{
		$array = array('usrgp_permission_page' => $page, 'user_group_id' => $user_group_id);
		$this->db->where($array);
		//$this->db->where('usrgp_permission_page', $page);
		$per_data = "";
		$this->db->update('has_permission', $per_data);
		//echo $this->db->last_query();
	}
	function save($data,$table){
		if ($this->db->insert($table, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
	function save_batch($data,$table){
		if ($this->db->insert_batch($table, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
}
