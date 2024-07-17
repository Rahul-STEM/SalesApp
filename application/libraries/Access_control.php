<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access_control {

    protected $CI;

    // List of allowed URLs
    protected $allowedUrls = array(
        'Menu/TotalRequest',
        'Menu/blocked_page',
        'Menu/EditWR',
        'Menu/bdrdelete',
        'Menu/bdrreject',
        'Menu/REQAPR',
        // Add more URLs as needed
    );

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('Menu_model');
    }

    

    public function block_urls() {
        // Check if the user should be blocked from accessing the current URL
        $blocked_user = $this->is_blocked_user();

        if ($blocked_user) {
            // Redirect or show an error page
            redirect('Menu/blocked_page');
        }
    }

    protected function is_blocked_user() {
        // Implement your logic to check if the current user should be blocked
        // For example, check the user's role or any other condition

        // Sample logic, modify as needed
        $user = $this->CI->session->userdata('user');
        // print_r($user);
        if(ISSET($user['user_id'])){
        $user_id = $user['user_id'];
        // $user_id = $this->CI->session->userdata('user_id');
        
        $nottakenaction=false;
        $bd = $this->CI->Menu_model->get_userbyaid($user_id); 
        foreach($bd as $bd){ 
            $urid = $bd->user_id;
        $mdata = $this->CI->Menu_model->request_admin_apr($urid);
        foreach($mdata as $dt){
$yourDatetime = $dt->sdatet;
$currentDatetime = new DateTime();
$specificDatetime = new DateTime($yourDatetime);
$timeDifference = $currentDatetime->diff($specificDatetime);
$days = $timeDifference->days;
$totalHoursDifference = $timeDifference->days * 24 + $timeDifference->h;
$minutes = $timeDifference->i;
$seconds = $timeDifference->s;
if($totalHoursDifference>48 && $dt->sdatet == $dt->lupdate){
$nottakenaction=true;
}
        }
    }   
        if (($user_id && $user_id == 45) && $nottakenaction) {
            if($this->is_allowed_url()){
                return false;
            } else {
            return true; // Block user with ID 1
            }
        }

    }

        return false;
    }

    protected function is_allowed_url() {
        // Implement logic to check if the current URL is allowed
        // For example, compare with a specific URL

        $current_url = $this->CI->uri->uri_string();
        // $allowed_url = 'Menu/TotalRequest';
        // $blocked_url = 'Menu/blocked_page';

        return in_array($current_url, $this->allowedUrls);
        // return ($current_url == $allowed_url || $current_url == $blocked_url);
    }
}
