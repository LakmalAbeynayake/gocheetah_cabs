<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class user_group_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_user_groups()
    {
        $this->db->select('user_group.*');
        $this->db->order_by("user_group_id", "desc");
        $this->db->where("user_group_status", 1);
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
    function save_user_group($data){
		if ($data)
		{
			if($this->db->insert("user_group",$data))
			{
				return $this->db->insert_id();
			}else return 0;
		}else return 0;
	}
    function disable_user_group($user_group_id)
	{
		$data = array(
			'user_group_status' => 0
		);
		$this->db->where('user_group_id', $user_group_id);
		$this->db->update('user_group', $data);
	}

	function enable_user_group($user_group_id)
	{
		$data = array(
			'user_group_status' => 1
		);
		$this->db->where('user_group_id', $user_group_id);
		$this->db->update('user_group', $data);
	}
	function clear_table()
	{
		$this->db->where('has_permission', 0);
		$this->db->delete('permission_allocation');
	}
}
