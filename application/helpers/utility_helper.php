<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('display_date_time_format'))
{
   function display_date_time_format($datetime)
   {
	   return date('Y-m-d  H:i A', strtotime($datetime)); //$dateTime->format("d/m/y  H:i A"); 
	   
   }  
}

if ( ! function_exists('assets_url'))
{
   function assets_url($type=0)
   {
	   return base_url().'assets';
	   
   }  
}


 	function image_url($type=0)
   {
	   return base_url().'thems/images';
	   
   }
   
   function premition($sub_menu_name)
   {
	   $CI = & get_instance();  //get instance, access the CI superobject
	   
	  if($CI->session->userdata('ss_user_group_name') and $CI->session->userdata('ss_user_group_name')=='Sale mStaff')
	 return true;
   }
   
   
   
   function is_logged_in() {
		// Get current CodeIgniter instance
		$CI =& get_instance();
		// We need to use $CI->session instead of $this->session
		$ss_user_id = $CI->session->userdata('ss_user_id');
		//echo "uid:".$user_id;
		if ($ss_user_id) { 
			return true;
			//redirect(base_url(),'refresh');
		} else { return false; }
	}

// function in_multiarray($field,$elem, $array,$field_2,$elem_2)
// {
//     $top = sizeof($array) - 1;
//     $bottom = 0;
//     while($bottom <= $top)
//     {
//         if($array[$bottom][$field] == $elem && $array[$bottom][$field_2]==$elem_2){
//             return true;
// 		}
//         else 
//             if(is_array($array[$bottom][$field]))
//                 if(in_multiarray($elem, ($array[$bottom][$field])))
//                     return true;

//         $bottom++;
//     }        
//     return false;
// }      
?>