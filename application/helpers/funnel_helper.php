<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	if ( ! function_exists('date_diff_format'))
	{
		/**
		 * Calculate the difference between two dates and return in "days hours min" format.
		 *
		 * @param string $date1 The first date (in 'Y-m-d H:i:s' format)
		 * @param string $date2 The second date (in 'Y-m-d H:i:s' format)
		 * @return string The difference in "days hours min" format
		 */
		function date_diff_format($date1, $date2)
		{
			// Create DateTime objects from the input strings
			$datetime1 = new DateTime($date1);
			$datetime2 = new DateTime($date2);

			// Calculate the difference
			$interval = $datetime1->diff($datetime2);

			// Build the formatted difference string
			$result = '';

			if ($interval->days > 0) {
				$result .= $interval->days . ' days ';
			}
			if ($interval->h > 0) {
				$result .= $interval->h . ' hours ';
			}
			if ($interval->i > 0) {
				$result .= $interval->i . ' mins';
			}

			return trim($result);
		}
	}


	if (!function_exists('getFunnelDetails')) {
		function getFunnelDetails($uid,$userTypeid,$sdate,$edate,$status,$SelectedCluster,$SelectedCategory,$SelectedUsers,$SelectedpartnerType,$statusArray){
			$CI =& get_instance();
			// Load the model if not already loaded
			$CI->load->model('Graph_model');
			$DataSet = $CI->Graph_model->getFunnelDetails($uid,$userTypeid,$sdate,$edate,$status,$SelectedCluster,$SelectedCategory,$SelectedUsers,$SelectedpartnerType,$statusArray);
			
			return $DataSet;
		}
	}


	if (!function_exists('getLastRemark')) {
	    function getLastRemark($id){
	        $CI =& get_instance();
	        // Load the model if not already loaded
	        $CI->load->model('Graph_model');
	        $DataSet = $CI->Graph_model->get_tblbyidwithremark($id);
            
	        return $DataSet;
	    }
	}


	if (!function_exists('getStatusWiseTask')) {
	    function getStatusWiseTask($uid,$sdate,$edate,$selected_category,$selected_partnerType,$selected_userType,$selected_cluster,$selected_users,$SelectedSingleStatus,$userTypeid){
	        $CI =& get_instance();
	        // Load the model if not already loaded
	        $CI->load->model('Graph_model');
	        $DataSet = $CI->Graph_model->getStatusWiseTask($uid,$sdate,$edate,$selected_category,$selected_partnerType,$selected_userType,$selected_cluster,$selected_users,$SelectedSingleStatus,$userTypeid);
            
	        return $DataSet;
	    }
	}

	if (!function_exists('SameStatusTillDate')) {
	    function SameStatusTillDate($uid,$userTypeid,$sdate,$edate,$status,$SelectedCluster,$SelectedCategory,$SelectedUsers,$SelectedpartnerType){
	        $CI =& get_instance();
	        // Load the model if not already loaded
	        $CI->load->model('Graph_model');
	        $DataSet = $CI->Graph_model->SameStatusTillDateByStatus($uid,$userTypeid,$sdate,$edate,$status,$SelectedCluster,$SelectedCategory,$SelectedUsers,$SelectedpartnerType);
            
	        return $DataSet;
	    }
	}

	if (!function_exists('getMonthWiseFunnel')) {
	    function getMonthWiseFunnel($uid,$userTypeid,$sdate,$edate,$status,$SelectedCluster,$SelectedCategory,$SelectedUsers,$SelectedpartnerType){
	        $CI =& get_instance();
	        // Load the model if not already loaded
	        $CI->load->model('Graph_model');
	        $DataSet = $CI->Graph_model->getMonthWiseFunnel($uid,$userTypeid,$sdate,$edate,$status,$SelectedCluster,$SelectedCategory,$SelectedUsers,$SelectedpartnerType);
            
	        return $DataSet;
	    }
	}

	if (!function_exists('getActionWiseFunnel')) {
	    function getActionWiseFunnel($uid,$sdate,$edate,$selected_category,$selected_partnerType,$Selected_userType,$selected_cluster,$selected_users,$stid,$userTypeid,$action){
	        $CI =& get_instance();
	        // Load the model if not already loaded
	        $CI->load->model('Graph_model');
	        $DataSet = $CI->Graph_model->getActionWiseFunnel($uid,$sdate,$edate,$selected_category,$selected_partnerType,$Selected_userType,$selected_cluster,$selected_users,$stid,$userTypeid,$action);
            
	        return $DataSet;
	    }
	}

	if (!function_exists('get_OtherUserOnMyFunnelGraph')) {
	    function get_OtherUserOnMyFunnelGraph($uid,$month,$financialYear,$sdate,$edate,$selected_category,$selected_partnerType,$Selected_userType,$selected_cluster,$selected_users,$userTypeid,$Selected_action,$Selected_purpose){
	        $CI =& get_instance();
	        // Load the model if not already loaded
	        $CI->load->model('Graph_model');
	        $DataSet = $CI->Graph_model->get_OtherUserOnMyFunnelGraph($uid,$month,$financialYear,$sdate,$edate,$selected_category,$selected_partnerType,$Selected_userType,$selected_cluster,$selected_users,$userTypeid,$Selected_action,$Selected_purpose);
            
	        return $DataSet;
	    }
	}
	


?>