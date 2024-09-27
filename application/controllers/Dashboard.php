<?php
date_default_timezone_set("Asia/Calcutta");
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Menu.php');
class Dashboard extends Menu {

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
        $this->load->model('Menu_model');
        $this->load->model('Management_model');

        $this->load->helper('funnel_helper');

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

    public function Dashboard_New(){
        date_default_timezone_set("Asia/Calcutta");
        if(isset($_POST['tdate'])){
        $tdate = $_POST['tdate'];
        }
        else{
            $tdate = date('Y-m-d');
        }
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $myid = $uid;


        if($uid=='100103'){$uid=45;}
        if($uid=='100149'){$uid=45;}
        if($uid=='100142'){$uid=2;}
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $fr=$this->Menu_model->get_freport($uid);
        $bdc=$this->Menu_model->get_bdtcom($uid);
        $mbdc=$this->Menu_model->get_mbdc($uid);
        $atid=1;
        $callr=$this->Menu_model->get_callingr($atid,$uid,$tdate);
        $patc=$this->Menu_model->get_pat($atid,$uid,$tdate);
        $tatc=$this->Menu_model->get_tat($atid,$uid,$tdate);
        $atid=2;
        $emailr=$this->Menu_model->get_callingr($atid,$uid,$tdate);
        $pate=$this->Menu_model->get_pat($atid,$uid,$tdate);
        $tate=$this->Menu_model->get_tat($atid,$uid,$tdate);
        $atid=3;
        $meetingr=$this->Menu_model->get_callingr($atid,$uid,$tdate);
        $patm=$this->Menu_model->get_pat($atid,$uid,$tdate);
        $tatm=$this->Menu_model->get_tat($atid,$uid,$tdate);
        $pendingt=$this->Menu_model->get_pendingt($uid,$tdate);
        $totalt=$this->Menu_model->get_totalt($myid,$tdate);
        $ttdone=$this->Menu_model->get_ttdone($uid,$tdate);
        $ttd=$this->Menu_model->get_totaltd($uid,$tdate);
        $upt=$this->Menu_model->get_unplant($uid,$tdate);
        $tsww=$this->Menu_model->get_tswwork($uid,$tdate);
        $tptask=$this->Menu_model->get_tptask($uid);
        $sc=$this->Menu_model->get_scon($uid,$tdate);
        $barg=$this->Menu_model->get_bargdetail($uid,$tdate);
        $autotasktimenew=$this->Menu_model->autotasktimenew($uid,$tdate);
        $positive=$this->Menu_model->get_positive();
        $vpositive=$this->Menu_model->get_vpositive();

        // New functions <==== START ====>

        $roles = $this->Menu_model->getRoles($id=null);
        $zones = $this->Menu_model->getZones();
        
        // var_dump($roles);die;

        // New functions <==== END ====>
        $tnos=0;
        $revenue=0;
        $poc=0;
        $vpoc=0;

        foreach($positive as $po){
            $poc++;
            $iniid = $po->cid_id;
            $tos=$this->Menu_model->get_initbyid($iniid);
            $tnos +=  (int)$tos[0]->noofschools;
            $revenue +=  (int)$tos[0]->fbudget;
        }

        foreach($vpositive as $vpo){
            $vpoc++;
            $iniid = $vpo->cid_id;
            $tost=$this->Menu_model->get_initbyid($iniid);
            $tnos +=  (int)$tost[0]->noofschools;
            $revenue +=  (int)$tost[0]->fbudget;
        }

        $pstc=$this->Menu_model->get_pstc($uid);
   
        if(!empty($user)){
            $this->load->view('Admin/index_New',['myid'=>$myid,'ttdone'=>$ttdone,'upt'=>$upt,'user'=>$user,'fr'=>$fr,'callr'=>$callr,'emailr'=>$emailr,'meetingr'=>$meetingr,'pendingt'=>$pendingt,'totalt'=>$totalt,'patc'=>$patc,'tatc'=>$tatc,'pate'=>$pate,'tate'=>$tate,'patm'=>$patm,'tatm'=>$tatm,'sc'=>$sc,'tptask'=>$tptask,'ttd'=>$ttd,'barg'=>$barg,'uid'=>$uid,'pstc'=>$pstc,'poc'=>$poc,'vpoc'=>$vpoc,'tnos'=>$tnos,'revenue'=>$revenue,'tsww'=>$tsww,'bdc'=>$bdc,'tdate'=>$tdate,'autotasktimenew'=>$autotasktimenew,'mbdc'=>$mbdc,'roles'=>$roles,'zones'=>$zones]);
        }else{
            redirect('Menu/main');
        }
    }

    public function getRoleUser_New(){
        $RoleId= $this->input->post('RoleId');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        // var_dump($user); die;
        // if($user['type_id'] == 2){

        //     $user_new = $this->db->select('*')->from('user_details')->where_in('type_id', $RoleId)->where(['status'=>'active','admin_id'=>$uid])->or_where('aadmin', $uid)->or_where('badmin', $uid)->get()->result();
        // }
        // elseif ($user['type_id'] == 4) {

        //     $user_new = $this->db->select('*')->from('user_details')->where(['status'=>'active','pst_co'=>$uid])->get()->result();

        // }elseif ($user['type_id'] == 9) {

        //     $user_new = $this->db->select('*')->from('user_details')->where(['status'=>'active','aadmin'=>$uid])->get()->result();
            
        // }

        // $user_new = $this->db->select('*')->from('user_details')->where_in(['status'=>'active','type_id'=>$RoleId])->get()->result();


            $this->db->select('*');
            $this->db->from('user_details');
            $this->db->where('status', 'active');
            $this->db->where_in('type_id', $RoleId);
            $this->db->order_by('name','ASC');

            $query = $this->db->get(); 
            // echo $this->db->last_query();die;
            $user_new =  $query->result();
            // $user_new =   $this->db->result();
            // var_dump($user_new);die;

            echo $data = '<option value="select_all">Select All</option>';

            foreach($user_new as $d){
                
                echo  $data = '<option value='.$d->user_id.'>'.$d->name.'</option>';
            }
    }

    public function BDDayDetail_New($tdate,$code){
        // var_dump($_POST);die;
        $startDate = '';
        $endDate = '';
        if(isset($_POST['FromDate']) && isset($_POST['ToDate'])){

            $startDate = $_POST['FromDate'];
            $endDate = $_POST['ToDate'];

        }else{

            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d');

        }

        if(isset($_POST['userType'])){

            $postUserType = $_POST['userType'];

        }else{

            $postUserType = [];

        }

        if(isset($_POST['user'])){

            $postUsers = $_POST['user'];

        }else{

            $postUsers = [];

        }

        if(isset($_POST['FromDate']) && isset($_POST['ToDate'])){

            $startDate = $_POST['FromDate'];
            $endDate = $_POST['ToDate'];

        }else{

            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d');

        }

        $sDate =$startDate;
        $eDate= $endDate ;
        if(isset($_POST['clear'])){
            $_POST = array();
        }
        // $userArray = $_POST[]
        $user = $this->session->userdata('user');
        // var_dump($user);die;
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        
        $mdata = $this->Menu_model->get_BDdaydbyadNew($uid,$startDate,$endDate,$code,$tdate,$postUserType,$postUsers);

        $getWorkLocationCounts = $this->Menu_model->getWorkLocationCount($uid,$startDate,$endDate,$tdate,$postUserType,$postUsers);
        // var_dump($mdata);die;

        $roles = $this->Menu_model->getRoles($dt[0]->id);
        // var_dump($roles);die;
        $this->load->view('Admin/BDDayDetail_New',['user'=>$user,'mdata'=>$mdata,'count'=>$getWorkLocationCounts,'uid'=>$uid,'tdate'=>$tdate,'code'=>$code,'startDate'=>$sDate,'endDate'=>$eDate,'roles'=>$roles,'postUsers'=>$postUsers,'postUserType'=>$postUserType,'userType'=>$dt[0]->id]);
    }

    public function ATaskDetail_New($code,$bdid,$atid,$sd,$ed){
        
        // var_dump($ed);die;
        $startDate = '';
        $endDate = '';
        if(isset($_POST['FromDate']) && isset($_POST['EndDate'])){

            $startDate = $_POST['FromDate'];
            $endDate = $_POST['EndDate'];

        }else{
            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d');
        }

        $sd =$startDate;
        $ed= $endDate ;
        // echo $sd;
        // echo $ed;
        // die;

        if (isset($_POST['userType'])) {

            $userType = array_filter($_POST['userType'], function ($value) {
                return $value !== 'select_all';
            });

        } else {

            $userType = [];
        }

        if (isset($_POST['user'])) {

            $users = array_filter($_POST['user'], function ($value) {
                return $value !== 'select_all';
            });

        } else {

            $users = [];
        }

        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;

        $roles = $this->Menu_model->getRoles($dt[0]->id);


        $mtdata = $this->Menu_model->get_bwdalltaskdbyad_New($code,$atid,$bdid,$sd,$ed);
        // echo $this->db->last_query();die;

        $tdate = date('Y-m-d');
        $getCountData = $this->Menu_model->getTeamTasksDashboard($uid,$tdate,$sd,$ed,$users);

        $mappedData = new stdClass();
        $mappedData->id_1 = $getCountData[0]->TotalTasks;
        $mappedData->id_2 = $getCountData[0]->TotalPending;
        $mappedData->id_3 = $getCountData[0]->TotalCompleted;


        $formattedData = new stdClass();
        $formattedData->lable = 'TotalTasks'; // Sample name
        $formattedData->count =  $mappedData->id_1; // Sample color
        $formattedData->id = '1';        // Sample ID

        // Create an array to hold the final result
        $result = [];
        $result[] = $formattedData;

        $result[] = new stdClass();
        $result[1]->lable = 'TotalPending';
        $result[1]->count = $mappedData->id_2; // Another color example
        $result[1]->id = '2';

        $result[] = new stdClass();
        $result[2]->lable = 'TotalCompleted';
        $result[2]->count = $mappedData->id_3; // Another color example
        $result[2]->id = '3';
        
        // var_dump($result);die;
        if(!empty($user)){
            $this->load->view($dep_name.'/ATaskDetail_New',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'sd'=>$sd,'ed'=>$ed,'code'=>$code,'bdid'=>$bdid,'mtdata'=>$mtdata,'getCountData'=>$result,'roles'=>$roles,'Selected_userType' => $userType,'selected_users' => $users,]);
        }else{
            redirect('Menu/main');
        }
    }

    public function companies_New($code,$PSTid=null){

        // var_dump($_POST);die;
        $PSTid = null;
        // $endDate = '';
        if(isset($_POST['PST'])){

            $PSTid = $_POST['PST'];
            // $endDate = $_POST['EndDate'];
        }else{

            $PSTid = null;

        }
        // var_dump($PSTid);die;
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if($uid=='100103'){$uid=45;}
        if($uid=='100149'){$uid=45;}
        if($uid=='100142'){$uid=2;}

        if($code==0){

            $mdata=$this->Menu_model->get_bdtcom($uid);

        }else{

            $mdata=$this->Menu_model->get_bdcombystatus($uid,$code);

        }

        $getPST = $this->Menu_model->getPST($uid);
        $TeamFunnelDetails = $this->Menu_model->getFunnelDetails($uid);

        if(!empty($user)){
            $this->load->view($dep_name.'/CreatedCompanies_New',['user'=>$user,'mdata'=>$mdata,'code'=>$code,'uid'=>$uid,'getPST'=>$getPST,'TeamFunnelDetails'=>$TeamFunnelDetails]);
        }else{
            redirect('Menu/main');
        }
    }
}