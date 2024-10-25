<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	if (!function_exists('getUserDayStartStatus')) {
	    function getUserDayStartStatus($uid){
	        $CI =& get_instance();
	        // Load the model if not already loaded
	        $CI->load->model('Menu_model');
	        $DataSet = $CI->Menu_model->getUserDayStartDetails($uid,date("Y-m-d"));
            
	        return $DataSet;
	    }
	}

	if (!function_exists('getDaystartRequestCount')) {
	    function getDaystartRequestCount($uid){
	        $CI =& get_instance();
	        // Load the model if not already loaded
	        $CI->load->model('Menu_model');
	        $DataSet = $CI->Menu_model->getDaystartRequestCount($uid,date("Y-m-d"));
            
	        return $DataSet;
	    }
	}

	if (!function_exists('getDaystartRequestApprovedCount')) {
	    function getDaystartRequestApprovedCount($uid){
	        $CI =& get_instance();
	        // Load the model if not already loaded
	        $CI->load->model('Menu_model');
	        $DataSet = $CI->Menu_model->getDaystartRequestApprovedCount($uid,date("Y-m-d"));
            
	        return $DataSet;
	    }
	}

	if (!function_exists('getCheckinTime')) {
	    function getCheckinTime($uid){
	        $CI =& get_instance();
	        // Load the model if not already loaded
	        $CI->load->model('Menu_model');
	        $DataSet = $CI->Menu_model->getCheckinTime($uid,date("Y-m-d"));
            
	        return $DataSet;
	    }
	}


?>