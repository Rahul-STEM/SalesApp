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

    function checkLeaveForDay($uid,$date){
        $CI =& get_instance();
        // Load the model if not already loaded
        $CI->load->model('Menu_model');
        $DataSet = $CI->Menu_model->checkLeaveForDay($uid,$date);
        
        return $DataSet;
    }


    function checkforHoliday($date){
        $CI =& get_instance();
        // Load the model if not already loaded
        $CI->load->model('Menu_model');
        $DataSet = $CI->Menu_model->checkforHoliday($date);
        
        return $DataSet;
    }


    function checkHalfDayLeave($uid,$date){
        $CI =& get_instance();
        // Load the model if not already loaded
        $CI->load->model('Menu_model');
        $DataSet = $CI->Menu_model->checkHalfDayLeave($uid,$date);
        
        return $DataSet;
    }


    function getNextDate($date){

        $CI =& get_instance();

        $dateObj = new DateTime($date);

        $dateObj->modify('+1 day');

        $adate = $dateObj->format('Y-m-d');
        return $adate;
    }

}



?>