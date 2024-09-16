<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('getGraphName')) {
    function getGraphName($graphname){
        $CI =& get_instance();
        // Load the model if not already loaded
        $CI->load->model('Graph_model');
        $graphtitle = $CI->Graph_model->graphlist($graphname);
        return $graphtitle['detail'];
    }
}

if (!function_exists('getUserNameById')) {
    function getUserNameById($usedId){
    
        $CI =& get_instance();
        // Load the model if not already loaded
        $CI->load->model('Menu_model');
        $userName = $CI->Menu_model->getUserNameById($userId);
        return $userName;
    }
}


// if (!function_exists('format_date')) {
//     function format_date($date) {
//         return date('F j, Y, g:i a', strtotime($date));
//     }
// }

?>