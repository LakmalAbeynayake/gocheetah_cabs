<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class category_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    function get_category_by_name($cat_name = '')
    {
        $this->db->select('*');
        $this->db->from('vehicle_category');
        $this->db->where('cat_name', $cat_name);
        $cat = $this->db->get();
        $ret = ($cat->num_rows > 0) ? $cat->result() : false;
        return $ret;
    }
    function get_sub_category_by_name($value = '')
    {
        $this->db->select('*');
        $this->db->from('vehicle_sub_category');
        $this->db->where('sub_cat_name', $value);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_categories()
    {
        $this->db->select('*');
        $this->db->from('vehicle_category');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function getSubCategoryPrint()
    {
        $this->db->select('s.*,c.cat_name');
        $this->db->from('vehicle_sub_category s');
        $this->db->join('vehicle_category c', 'c.cat_id = s.cat_id', 'left');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function getSubCategory($value = '')
    {
        $this->db->select('*');
        $this->db->from('vehicle_sub_category');
        $this->db->where('cat_id', $value);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function getCategory_by_id($category_id = '')
    {
        $this->db->select('*');
        $this->db->from('vehicle_category');
        $this->db->where('cat_id', $category_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    function category_update($data,$cat_id)
    {
        $this->db->where('cat_id', $cat_id);
        if ($this->db->update('vehicle_category', $data)) {
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }
    function category_change_status($category_tbl_id = '', $status = '')
    {
        $cat_id = ($status == 0) ? 1 : 0;
        $data   = array(
            'cat_status' => $cat_id
        );
        $this->db->where('cat_id', $category_tbl_id);
        if ($this->db->update('vehicle_category', $data)) {
            return true;
        } else {
            return false;
        }
    }
    function category_show_web($category_tbl_id = '', $show_web = '')
    {
        $cat_id = ($show_web == 0) ? 1 : 0;
        $data   = array(
            'show_web' => $cat_id
        );
        $this->db->where('cat_id', $category_tbl_id);
        if ($this->db->update('vehicle_category', $data)) {
            return true;
        } else {
            return false;
        }
    }
    function category_permanent_delete($category_id = '')
    {
        if ($this->get_sub_category($category_id) == true) {
            echo false;
        } else {
            $this->db->where('cat_id', $category_id);
            if ($this->db->delete('vehicle_category')) {
                return true;
            } else {
                return false;
            }
        }
    }
    //sub category module begin
    function category_sub_save($data)
    {
        if ($this->db->insert('vehicle_sub_category', $data)) {
            return true;
        } else {
            return false;
        }
    }
    function get_sub_category($parent_cat_id = '')
    {
        $this->db->select('p.cat_name , s.*');
        $this->db->from('vehicle_category p, vehicle_sub_category s');
        $this->db->where('s.cat_id', $parent_cat_id);
        $this->db->where('p.cat_id = s.cat_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_sub_Category_by_id($sub_cat_id = '')
    {
        $this->db->select('*');
        $this->db->from('vehicle_sub_category');
        $this->db->where('sub_cat_id', $sub_cat_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    function sub_category_permanent_delete($sub_category_id = '')
    {
        $this->db->where('sub_cat_id', $sub_category_id);
        if ($this->db->delete('vehicle_sub_category')) {
            return true;
        } else {
            return false;
        }
    }
    function sub_category_update($sub_cat_id,$data)
    {
        $this->db->where('sub_cat_id', $sub_cat_id);
        if ($this->db->update('vehicle_sub_category', $data)) {
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }
    // sub category module end
}
