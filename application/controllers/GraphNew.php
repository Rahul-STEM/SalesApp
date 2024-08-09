<?php
date_default_timezone_set("Asia/Calcutta");
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once('Menu.php');
class GraphNew extends CI_Controller {

    private $user;
    private $uid;
    private $uyid;
    private $dep_name;
    private $dt;

    public function __construct() {
        parent::__construct();
        // Load common libraries, helpers, or models here
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->model('Graph_Model');
        $this->load->model('Menu_model');

        $this->user = $this->session->userdata('user');
        $this->uid = $this->user['user_id'];
        $this->uyid =  $this->user['type_id'];

        $this->dt = $this->Menu_model->get_utype($this->uyid);

        $this->dep_name = $this->dt[0]->name;
   
        if (in_array(!$this->uyid, [15, 13, 2, 4])) {
            echo "Stem Learning Pvt Ltd";
            echo "<br/>";
            exit;
        }
        
    }

    public function StatusWiseFunnelGraph($code) {

        // var_dump($_POST);die;
        if(isset($_POST['startDate']) && isset($_POST['endDate'])){

            $sdate = $_POST['startDate'];
            $edate = $_POST['endDate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }

        // var_dump($sdate,$edate);die;
            $user = $this->session->userdata('user');
            $data['user'] = $user;
            $uid = $user['user_id'];
            $userTypeid =  $user['type_id'];
            $dt=$this->Graph_Model->get_utype($userTypeid);
            $dep_name = $dt[0]->name;

            $chartData = $this->Graph_Model->get_fannalstwise($uid,$userTypeid,$sdate,$edate);

            $TableData = $this->Graph_Model->get_fannalbycode($uid,$userTypeid,$sdate,$edate);

            // var_dump($chartData);die;
            if(!empty($user)){
                $this->load->view('include/header');
                $this->load->view($dep_name.'/nav',['uid'=>$uid,'user'=>$user]);
                $this->load->view('Graphs/FGraph1_New',['code'=>$code,'uid'=>$uid,'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'chartData'=>$chartData,'TableData'=>$TableData]);
                $this->load->view('include/footer');
            }else{
                redirect('Menu/main');
            }



    }

    public function FunnelAnalysis() {

        // var_dump($_POST);die;

        if(isset($_POST['startDate']) && isset($_POST['endDate'])){

            $sdate = $_POST['startDate'];
            $edate = $_POST['endDate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }

        if(isset($_POST['userType'])){

            $userType = array_filter($_POST['userType'], function($value) {
                return $value !== 'select_all';
            });

            // $userType = implode(',', ($userType));

        }else{

            $userType = '';
        }
        
        if(isset($_POST['cluster'])){

            $cluster = array_filter($_POST['cluster'], function($value) {
                return $value !== 'select_all';
            });

            $cluster = implode(',', ($cluster));

        }else{

            $cluster = '';
        }

        if(isset($_POST['user'])){

            $users = array_filter($_POST['user'], function($value) {
                return $value !== 'select_all';
            });
            
            $users = implode(',', ($users));
        }else{

            $users = '';
        }
           

        if(isset($_POST['partnerType'])){
            
            $partnerType = array_filter($_POST['partnerType'], function($value) {
            return $value !== 'select_all';

        });
            $partnerType = implode(',', ($partnerType));

        }else{

            $partnerType = '';
        }

        if(isset($_POST['category'])){
            
            $category = array_filter($_POST['category'], function($value) {
            return $value !== 'select_all';
 
            });
            // $category = implode(',', ($category));

        }else{

            $category = '';
        }


        // $sdate = '2024-03-01';
        // var_dump($sdate,$edate);die;
            $user = $this->session->userdata('user');
            $data['user'] = $user;
            $uid = $user['user_id'];
            $userTypeid =  $user['type_id'];
            $dt=$this->Graph_Model->get_utype($userTypeid);
            $dep_name = $dt[0]->name;

            $roles = $this->Graph_Model->getRoles($dt[0]->id);

            $partner_type = $this->Graph_Model->getPartnerType();

            $get_cluster = $this->Graph_Model->get_clusters();

            $TableData = $this->Graph_Model->get_TableData($uid,$userTypeid,$sdate,$edate,$userType,$cluster,$partnerType,$category,$users);

            $FunnelData = $this->Graph_Model->getGraphDetails($uid,$userTypeid,$sdate,$edate,$userType,$cluster,$partnerType,$category,$users);
            // var_dump($FunnelData);die;

            
            // var_dump($data);die;
            if(!empty($user)){
                $this->load->view('include/header');
                $this->load->view($dep_name.'/nav',['uid'=>$uid,'user'=>$user]);
                $this->load->view('Graphs/FunnelAnalysis',['uid'=>$uid,'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'TableData'=>$TableData,'roles'=>$roles,'partner_type'=>$partner_type,'clusters'=>$get_cluster,'FunnelData'=>$FunnelData,'selected_partnerType'=> $partnerType,'selected_category'=> $category,'selected_cluster'=> $cluster,'selected_users'=> $users]);
                $this->load->view('include/footer');
            }else{
                redirect('Menu/main');
            }



    }


    public function getUserByCluster(){

        $clusterID = array_filter($_POST['clusterId'], function($value) {
            return $value !== 'select_all';

        });
        
        $clusterID = implode(',', ($clusterID));

        $getClusterManagerByCluster = $this->Graph_Model->getClusterManagerByCluster($clusterID);

        echo $data = '<option value="select_all">Select All</option>';
        foreach($getClusterManagerByCluster as $SignleUser){
            echo  $data = '<option value='.$SignleUser->user_id.'>'.$SignleUser->name.'</option>';
        }

    }

    public function StatusWiseFunnelData(){
        
        // var_dump($stID);die;
        $status_id = $this->input->post('stid');
        // var_dump($stid);die;
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        $selected_partnerType = str_replace('"', '', $_POST['selected_partnerType']);
        $arrayselected_cluster = str_replace('"', '', $_POST['arrayselected_cluster']);
        $arrayselected_user = str_replace('"', '', $_POST['arrayselected_user']);
        // $status_id =  $_POST['stid'];
// print_r($status_id);die;
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $userTypeid =  $user['type_id'];
        $dt=$this->Graph_Model->get_utype($userTypeid);
        $dep_name = $dt[0]->name;

        $StatusWiseFunnelData = $this->Graph_Model->getStatusWiseFunnelData($uid,$sdate,$edate,$selected_partnerType,$arrayselected_cluster,$arrayselected_user,$status_id);
        // echo "<pre>";
        // print_r($StatusWiseFunnelData);die;

        if(!empty($user)){
            $this->load->view('include/header');
            $this->load->view($dep_name.'/nav',['uid'=>$uid,'user'=>$user]);
            $this->load->view('Graphs/StatusWiseFunnelAnalysis',['uid'=>$uid,'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'StatusWiseFunnelData'=>$StatusWiseFunnelData]);
            $this->load->view('include/footer');
        }else{
            redirect('Menu/main');
        }
    }
}