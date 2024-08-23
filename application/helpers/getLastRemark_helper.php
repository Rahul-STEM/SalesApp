<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	if (!function_exists('getLastRemark')) {
	    function getLastRemark($id){
	        $CI =& get_instance();
	        // Load the model if not already loaded
	        $CI->load->model('Graph_model');
	        $DataSet = $CI->Graph_model->get_tblbyidwithremark($id);
            
	        return $DataSet;
	    }
	}


?>