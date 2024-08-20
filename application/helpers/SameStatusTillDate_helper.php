<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	
	if (!function_exists('SameStatusTillDate')) {
	    function SameStatusTillDate($uid,$userTypeid,$sdate,$edate,$status){
	        $CI =& get_instance();
	        // Load the model if not already loaded
	        $CI->load->model('Graph_model');
	        $DataSet = $CI->Graph_model->SameStatusTillDateByStatus($uid,$userTypeid,$sdate,$edate,$status);
            // var_dump($graphtitle);die;
	        return $DataSet;
	    }
	}

// if (!function_exists('format_date')) {
//     function format_date($date) {
//         return date('F j, Y, g:i a', strtotime($date));
//     }
// }

?>