<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
if (!function_exists('getlastloginData')) {
    function getlastloginData($uid){
        $CI =& get_instance();
        // Load the model if not already loaded
        $CI->load->model('Menu_model');
        $DataSet = $CI->Menu_model->getlastloginData($uid);
        
        return $DataSet;
    }
}



?>