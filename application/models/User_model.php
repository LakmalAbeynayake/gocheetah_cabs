<?php
class User_Model extends CI_Model
{
	private $tableName = 'user';


	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library(array('email'));
	}

	/*
	Attempts to login employee and set session. Returns boolean based on outcome.
	*/
	function login($user_username, $user_password)
	{
		$pwHashed = hash('sha512', $user_password);
		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->join("user_group", "user_group.user_group_id = user.group_id", "left");
		$this->db->where("user_username", $user_username);
		$this->db->where("user_password", $pwHashed);
		$this->db->where("user.user_status", 1);
		$this->db->where("user_group.user_group_status", 1);
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			$row = $query->row();
			return $row->user_id;
		}
		return false;
	}
	function create_user_sessions($sesdata)
	{
		$this->session->sess_expiration = 32140800; //~   one year
		$this->session->sess_expire_on_close = 'false';
		$this->session->set_userdata($sesdata);
	}

	function delete_user_sessions($sesdata)
	{
		$this->session->unset_userdata($sesdata);
	}

	function get_users($branch_id = "", $group_id = "")
	{
		$this->db->select('u.* , ug.user_group_name');
		$this->db->from('user u');
		$this->db->join('user_group ug', 'u.group_id = ug.user_group_id', 'left');
		if ($branch_id)
			$this->db->where('u.branch_id', $branch_id);

		if ($group_id)
			$this->db->where('u.branch_id', $group_id);

		$this->db->order_by("u.user_id", "desc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	function save_user(&$user_data, $user_id = false)
	{
		if (!$user_id) {
			$val = $this->db->insert($this->tableName, $user_data);
			if ($val) return TRUE;
			else return FALSE;
		} else {
			$this->db->where('user_id', $user_id);
			return $this->db->update($this->tableName, $user_data);
		}
	}
	function update_user(&$user_data, $user_id)
	{
		if ($user_id) {
			$this->db->where('user_id', $user_id);
			if ($this->db->update('user', $user_data)) {
				return $this->db->affected_rows();
			} else return 0;
		} else return 0;
	}

	public function get_user_info($id)
	{
		$this->db->select('u.* , g.user_group_name')
			->from('user u')
			->join('user_group g', 'u.group_id = g.user_group_id', 'left')
			->where('u.user_id', $id)
			->order_by("u.user_id", "desc");
		$query = $this->db->get();
		return $query->row_array();
	}

	public function delete_user($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete('user');
	}

	public function disable_user($user_id)
	{
		$data = array(
			'user_status' => 0
		);
		$this->db->where('user_id', $user_id);
		$this->db->update('user', $data);
	}

	public function enable_user($user_id)
	{
		$data = array(
			'user_status' => 1
		);
		$this->db->where('user_id', $user_id);
		$this->db->update('user', $data);
	}

	function get_name_by_id($sales_rep_id)
	{
		$this->db->select('user_first_name')
			->select('user_last_name')
			->from($this->tableName)
			->where("user_id", $sales_rep_id);
		$query = $this->db->get();
		return $query->row_array();
	}
	/* user groups */
	function get_all_user_group_list()
	{
		$this->db->select('*');
		$this->db->order_by("user_group_id", "desc");
		//$this->db->where("user_group_status", 1);
		$query = $this->db->get('user_group');
		return $query->result();
	}
	public function get_user_group_info_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('user_group');
		$this->db->where("user_group_id", $id);
		$this->db->order_by("user_group_id", "desc");
		$query = $this->db->get();
		return $query->row_array();
	}
	function get_dealers($srh=""){
		$this->db->select('*');
		$this->db->from('user');
		$this->db->like("group_id = 7 AND user.user_first_name", $srh);
		$this->db->or_like("group_id = 7 AND user.user_last_name", $srh);
		//$this->db->where("group_id", 7);
		$this->db->order_by("user.user_first_name", "desc");
		$query = $this->db->get();
		return $query->result();
	}
}
