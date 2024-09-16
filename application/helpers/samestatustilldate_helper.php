<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
if (!function_exists('getFunnelTaskforCLM')) {
	    function getFunnelTaskforCLM($id){
	        $CI =& get_instance();
	        // Load the model if not already loaded
	        $CI->load->model('Management_model');
	        $DataSet = $CI->Management_model->getFunnelTaskforCLM($id);
            
	        return $DataSet;
	    }
	}
	
	if (!function_exists('getLastActionDetails')) {
	    function getLastActionDetails($cmp_ID,$userID,$cdate){
	        $CI =& get_instance();
	        // Load the model if not already loaded
	        $CI->load->model('Menu_model');
	        $DataSet = $CI->Menu_model->getLastActionDetails($cmp_ID,$userID,$cdate);
            
	        return $DataSet;
	    }
	}

	if (!function_exists('get_CompanyStatus')) {
	    function get_CompanyStatus($company_id,$cmp_ID){
	        $CI =& get_instance();
	        // Load the model if not already loaded
	        $CI->load->model('Menu_model');
	        $DataSet = $CI->Menu_model->get_CompanyStatus($company_id,$cmp_ID);
            
	        return $DataSet;
	    }
	}

	if (!function_exists('getSameStatusSince')) {
	    function getSameStatusSince($id,$date){
	        $CI =& get_instance();
	        // Load the model if not already loaded
	        $CI->load->model('Menu_model');
	        $DataSet = $CI->Menu_model->getSameStatusSince($id,$date);
            
	        return $DataSet;
	    }
	}
?>