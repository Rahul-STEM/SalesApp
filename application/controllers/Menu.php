<?php
date_default_timezone_set("Asia/Calcutta");
defined('BASEPATH') OR exit('No direct script access allowed');
class Menu extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // Load models, libraries, helpers, etc.
        $this->load->model('Menu_model');
         $this->load->helper('common_helper');
          $this->load->helper('samestatustilldate_helper');
    }
    public function main(){
        $msg = '';
        $this->load->model('Menu_model');
        $this->load->view('index');
        //  $this->load->helper('SameStatusTillDate_helper');
    }
    public function logout(){
        $this->session->unset_userdata('user');
        redirect('Menu/main');
    }
    public function getpcode(){
        $cname= $this->input->post('cname');
        $this->load->model('Menu_model');
        $result=$this->Menu_model->get_pcode($cname);
        foreach($result as $d){
           echo  $data = '<option>'.$d->projectcode.'</option>';
        }
        return $data;
    }
    public function getclientdetail(){
        $cname= $this->input->post('cname');
        $this->load->model('Menu_model');
        $result=$this->Menu_model->get_clientbyname($cname);
           echo  $data = '<b>Address:</b> '.$result[0]->address.'<br>'.$result[0]->city.', '.$result[0]->state.', '.$result[0]->country.'<br><b>Budget:</b>'.$result[0]->budget;
        return $data;
    }
    public function getcinfo(){
        $pcode= $this->input->post('pcode');
        $this->load->model('Menu_model');
        $cin=$this->Menu_model->get_cinfo($pcode);
        echo $data = '<b>Total No of School : '.$cin[0]->noofschool.'</b><br>
                      <b>Year : '.$cin[0]->project_year.'</b><br>
                      <b>Location : '.$cin[0]->location.'</b><br>
                      <b>State : '.$cin[0]->state.'</b><br>
                      <b>Status : '.$cin[0]->status.'</b>
                      ';
        return $data;
    }
    public function assignpsttask(){
        $compid= $this->input->post('compid');
        $apst= $this->input->post('apst');
        $this->load->model('Menu_model');
        $this->Menu_model->assign_psttask($compid,$apst);
        redirect('Menu/assignpst');
    }
    public function startdayreview($uid,$ttype){
        $this->load->model('Menu_model');
        $this->Menu_model->start_dayreview($uid,$ttype);
        redirect('Menu/DayStartCheck');
    }
    public function closedayreview($rid){
        $this->load->model('Menu_model');
        $this->Menu_model->close_dayreview($rid);
        redirect('Menu/DayStartCheck');
    }
    public function bdHandover(){
        $bdid= $this->input->post('bdid');
        $client_name= $this->input->post('client_name');
        $mediator= $this->input->post('mediator');
        $noofschool= $this->input->post('noofschool');
        $location= $this->input->post('location');
        $city= $this->input->post('city');
        $state= $this->input->post('state');
        $spd_identify_by= $this->input->post('spd_identify_by');
        $infrastructure= $this->input->post('infrastructure');
        $contact_person= $this->input->post('contact_person');
        $cp_mno= $this->input->post('cp_mno');
        $acontact_person= $this->input->post('acontact_person');
        $acp_mno= $this->input->post('acp_mno');
        $language= $this->input->post('language');
        $expected_installation_date= $this->input->post('expected_installation_date');
        $project_tenure= $this->input->post('project_tenure');
        $project_type= $this->input->post('project_type');
        $comments= $this->input->post('comments');
        $remark= $this->input->post('remark');
        $fttptype= $this->input->post('fttptype');
        $sid= $this->input->post('sid');
        $this->load->model('Menu_model');
        if(isset($_FILES['filname']['name'])) {
           $filname = $_FILES['filname']['name'];
           $count = sizeof($filname);
        }else{$count=0;$filname=0;}
        if($spd_identify_by=='Client'){
            $sname = $this->input->post('sname');
            $saddress = $this->input->post('saddress');
            $scity = $this->input->post('scity');
            $sstate = $this->input->post('sstate');
            $scontact = $this->input->post('scontact');
            $sdegignation = $this->input->post('sdegignation');
            $snumber = $this->input->post('snumber');
        }else{$sname=0;$saddress=0;$scity=0;$sstate=0;$scontact=0;$sdegignation=0;$snumber=0;}
        $id=$this->Menu_model->add_bdHandover($sname,$saddress,$scity,$sstate,$scontact,$sdegignation,$snumber,$bdid, $client_name, $mediator, $noofschool, $location, $city, $state, $spd_identify_by, $infrastructure, $filname,$count, $contact_person, $cp_mno, $acontact_person, $acp_mno, $language, $expected_installation_date, $project_tenure,$project_type, $comments,$sid,$remark,$fttptype);
        if($id){
            redirect('Menu/handoverToaccount/'.$id);
        }else{
            print('Insert error ');
        }
    }
    public function handoverToaccount($id){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $dt=$this->Menu_model->bd_toaccount($id);
        if(!empty($user)){
            $this->load->view($dep_name.'/bdtoacc',['uid'=>$uid,'data'=>$dt, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RIDDetail(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/RIDDetail',['uid'=>$uid,'data'=>$dt, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function NewFunnel(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/NewFunnel',['sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed,'uid'=>$uid,'data'=>$dt, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RIDSummary(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/RIDSummary',['uid'=>$uid,'data'=>$dt, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RIDDetailbyProgram(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/RIDDetailbyProgram',['uid'=>$uid,'data'=>$dt, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DGraph1(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/DGraph1',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DGraph2(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/DGraph2',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DGraph37(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/DGraph37',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DGraph38(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/DGraph38',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DGraph39(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/DGraph39',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DGraph40(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/DGraph40',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DGraph41(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/DGraph41',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DGraph42(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/DGraph42',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DGraph43(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/DGraph43',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DGraph44(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/DGraph44',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DGraph45(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/DGraph45',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DGraph46(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/DGraph46',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DGraph47(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/DGraph47',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DGraph48(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/DGraph48',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DGraph49(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/DGraph49',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RGraph1(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/RGraph1',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
     public function RGraph2(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/RGraph2',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RGraph3(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/RGraph3',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RGraph4(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/RGraph4',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RGraph5(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/RGraph5',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RGraph6(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/RGraph6',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RGraph7(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/RGraph7',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RGraph8(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/RGraph8',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RGraph9(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/RGraph9',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RGraph10(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/RGraph10',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ROGraph1(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/ROGraph1',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ROGraph2(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/ROGraph2',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ROGraph3(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/ROGraph3',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ROGraph4(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/ROGraph4',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ROGraph5(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/ROGraph5',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ROGraph6(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/ROGraph6',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ROGraph7(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/ROGraph7',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ROGraph8(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/ROGraph8',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ROGraph9(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/ROGraph9',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function GraphLink(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/GraphLink',['uid'=>$uid,'data'=>$dt, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PFGraph1(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PFGraph1',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph1($stid,$code){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph1',['stid'=>$stid,'code'=>$code,'uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph2($cityid){
        $code=2;
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph2',['cityid'=>$cityid,'code'=>$code,'uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph3($pid){
        $code=3;
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph3',['pid' =>$pid,'code'=>$code,'uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph4(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph4',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph5($sttid){
        $code=5;
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph5',['code'=>$code,'sttid'=>$sttid,'uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph6(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph6',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph7(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph7',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph8(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph8',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph9(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph9',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph10(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph10',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph11(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph11',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph12(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph12',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph13(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph13',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph14(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph14',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph15(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph15',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph16(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph16',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph17(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph17',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph18(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph18',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph19(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph19',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph20(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph20',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph21(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph21',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph22(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph22',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph23(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph23',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph24(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph24',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FGraph25(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FGraph25',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TGraph1(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TGraph1',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TGraph2(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TGraph2',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TGraph3(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TGraph3',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TGraph4(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TGraph4',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TGraph5(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TGraph5',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TGraph6(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TGraph6',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TGraph7(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TGraph7',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TGraph8(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TGraph8',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TGraph9(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TGraph9',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TGraph10(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TGraph10',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TGraph11(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TGraph11',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TGraph12(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TGraph12',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TGraph13(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TGraph13',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TGraph14(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TGraph14',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TGraph15(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TGraph15',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TGraph16(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TGraph16',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TGraph17(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TGraph17',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TGraph18(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TGraph18',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TGraph19(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TGraph19',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TGraph20(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TGraph20',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FunnelGraph1($muid){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FunnelGraph1',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed,'muid'=>$muid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FunnelBox(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FunnelBox',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FunnelBox1(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FunnelBox1',['uid'=>$uid,'data'=>$dt, 'user'=>$user, 'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function NewPage(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/NewPage',['uid'=>$uid,'data'=>$dt, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function NewPage1(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/NewPage1',['uid'=>$uid,'data'=>$dt, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TaskGraph(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TaskGraph',['uid'=>$uid,'data'=>$dt, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TaskGraph1(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TaskGraph1',['uid'=>$uid,'data'=>$dt, 'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TaskGraph2(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TaskGraph2',['uid'=>$uid,'data'=>$dt, 'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TaskGraph3(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TaskGraph3',['uid'=>$uid,'data'=>$dt, 'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TaskGraph4(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TaskGraph4',['uid'=>$uid,'data'=>$dt, 'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TaskGraph5(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TaskGraph5',['uid'=>$uid,'data'=>$dt, 'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TaskGraph6(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TaskGraph6',['uid'=>$uid,'data'=>$dt, 'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TaskGraph7(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = "2023-04-01";
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TaskGraph7',['uid'=>$uid,'data'=>$dt, 'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function CompanyTaskBox($cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FunnelBox',['uid'=>$uid,'cid'=>$cid, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ModelDetail($chid,$sid,$tid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/ModelDetail',['sid'=>$sid,'tid'=>$tid,'chid'=>$chid,'uid'=>$uid,'data'=>$dt, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function AllUtilisation(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_taskbyaction('Utilisation');
        if(!empty($user)){
            $this->load->view($dep_name.'/AllUtilisation',['uid'=>$uid,'mdata'=>$mdata, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function Utilisation($pid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $plan=$this->Menu_model->get_plantaskbyid($pid);
        $sid = $plan[0]->spd_id;
        $tid = $plan[0]->taskid;
        $spd=$this->Menu_model->get_school_detailbyid($sid);
        $task=$this->Menu_model->get_taskassign_byid($tid);
        $urtid=$task[0]->tid;
        $wgd=$this->Menu_model->get_wgdatabytid($tid);
        if(!empty($user)){
            $this->load->view($dep_name.'/Utilisation',['uid'=>$uid, 'user'=>$user,'spd'=>$spd, 'plan'=>$plan, 'task'=>$task,'tid'=>$tid,'wgd'=>$wgd]);
        }else{
            redirect('Menu/main');
        }
    }
    public function LiveCurrentTask(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/LiveCurrentTask',['uid'=>$uid, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function LiveCurrentDayUTask(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/LiveCurrentDayUTask',['uid'=>$uid, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function  LiveTaskTracking(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/LiveTaskTracking',['uid'=>$uid, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function  LiveTaskTrackingBD(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/LiveTaskTrackingBD',['uid'=>$uid, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function  LiveTaskTrackingPST(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/LiveTaskTrackingPST',['uid'=>$uid, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function  ReportTaskTracking(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/ReportTaskTracking',['uid'=>$uid, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function LiveNextDayTask(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/LiveNextDayTask',['uid'=>$uid, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function LiveStatusTask(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/LiveStatusTask',['uid'=>$uid, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function LiveStatusUTask(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/LiveStatusUTask',['uid'=>$uid, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function CategoryStatusPage(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        if($uid=='100103'){$uid=45;}
        if($uid=='100149'){$uid=45;}
        if($uid=='100142'){$uid=2;}
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        if($uyid == 15){
            $mdata = $this->Menu_model->get_userbyaSCid($uid);
        }elseif($uyid == 13){
            $mdata = $this->Menu_model->get_userbyAadminid($uid);;
        }else{
            $mdata = $this->Menu_model->get_userbyaid($uid);
        }
       
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/CategoryStatusPage',['mdata'=>$mdata,'uid'=>$uid, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function AddWorkingDay(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $maxdate = $this->Menu_model->get_CalendarMaxDate();
        $maxdate = $maxdate[0]->mdate;
        $maxdate = date('Y-m-d', strtotime($maxdate. ' + 1 days'));
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/AddWorkingDay',['maxdate'=>$maxdate,'uid'=>$uid, 'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function CalendarPlanner(){
        $uid= $this->input->post('uid');
        $fdate= $this->input->post('fdate');
        $tdate= $this->input->post('tdate');
        $wnw= $this->input->post('wnw');
        $remark= $this->input->post('remark');
        $this->load->model('Menu_model');
        $this->Menu_model->Calendar_Planner($uid,$fdate,$tdate,$wnw,$remark);
        redirect('Menu/AddWorkingDay/');
    }
    public function wstart(){
        $uid= $this->input->post('uid');
        $wname= $this->input->post('wname');
        $this->load->model('Menu_model');
        $this->Menu_model->w_start($uid,$wname);
    }
    public function wclose(){
        $uid= $this->input->post('uid');
        $wname= $this->input->post('wname');
        $this->load->model('Menu_model');
        $this->Menu_model->w_close($uid,$wname);
    }
    public function bdaccount(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $handover_id= $this->input->post('id');
        $wono= $this->input->post('wono');
        $porno= $this->input->post('porno');
        $gstno= $this->input->post('gstno');
        $panno= $this->input->post('panno');
        $tbudget= $this->input->post('tbudget');
        $payterm= $this->input->post('payterm');
        $pwosdate= $this->input->post('pwosdate');
        $moudate= $this->input->post('moudate');
        $srfinovice= $this->input->post('srfinovice');
        $bname= $this->input->post('bname');
        $basic= $this->input->post('basic');
        $gst= $this->input->post('gst');
        $total= $this->input->post('total');
        $oney= $this->input->post('oney');
        $twoy= $this->input->post('twoy');
        $threey= $this->input->post('threey');
        $proformadate= $this->input->post('proformadate');
        $taxinvoicedate= $this->input->post('taxinvoicedate');
        $this->load->model('Menu_model');
        if(isset($_FILES['filname']['name'])) {
           $filname = $_FILES['filname']['name'];
           $count = sizeof($filname);
        }else{$count=0;$filname=0;}
        $id=$this->Menu_model->add_bdaccount($uid,$handover_id, $wono, $porno, $gstno, $panno,$tbudget, $payterm, $pwosdate, $moudate, $srfinovice, $filname,$count,$bname, $basic, $gst, $total, $oney, $twoy, $threey,$proformadate,$taxinvoicedate);
        if($id){
            redirect('Menu/Dashboard');
        }else{
            print('Insert error ');
        }
    }
    public function ardata(){
        $uid= $this->input->post('uid');
        $uname= $this->input->post('uname');
        $data= $this->input->post('data');
        $svsname= $this->input->post('svsname');
        $svlocation= $this->input->post('svlocation');
        $csvcname= $this->input->post('csvcname');
        $csvsname= $this->input->post('csvsname');
        $csvlocation= $this->input->post('csvlocation');
        $cdcdata= $this->input->post('cdcdata');
        $cdsdata= $this->input->post('cdsdata');
        $cdrdata= $this->input->post('cdrdata');
        $kccompany= $this->input->post('kccompany');
        $kcsno= $this->input->post('kcsno');
        $kcrevenue= $this->input->post('kcrevenue');
        $kcqcompany= $this->input->post('kcqcompany');
        $kcqsno= $this->input->post('kcqsno');
        $kcqrevenue= $this->input->post('kcqrevenue');
        $achievement = $this->input->post('achievement');
        $svsnamem='';
        $l = sizeof($svsname);
        for($i=0;$i<$l;$i++){
            if($i==0){$svsnamem = $svsname[$i];}
            else{$svsnamem = $svsnamem.','.$svsname[$i];}
        }
        $svlocationm='';
        $l = sizeof($svlocation);
        for($i=0;$i<$l;$i++){
            if($i==0){$svlocationm = $svlocation[$i];}
            else{$svlocationm = $svlocationm.','.$svlocation[$i];}
        }
        $csvcnamem='';
        $l = sizeof($csvcname);
        for($i=0;$i<$l;$i++){
            if($i==0){$csvcnamem = $csvcname[$i];}
            else{$csvcnamem = $csvcnamem.','.$csvcname[$i];}
        }
        $csvlocationm='';
        $l = sizeof($csvlocation);
        for($i=0;$i<$l;$i++){
            if($i==0){$csvlocationm = $csvlocation[$i];}
            else{$csvlocationm = $csvlocationm.','.$csvlocation[$i];}
        }
        $cdcdatam='';
        $l = sizeof($cdcdata);
        for($i=0;$i<$l;$i++){
            if($i==0){$cdcdatam = $cdcdata[$i];}
            else{$cdcdatam = $cdcdatam.','.$cdcdata[$i];}
        }
        $cdrdatam='';
        $l = sizeof($cdrdata);
        for($i=0;$i<$l;$i++){
            if($i==0){$cdrdatam = $cdrdata[$i];}
            else{$cdrdatam = $cdrdatam.','.$cdrdata[$i];}
        }
        $kccompanym='';
        $l = sizeof($kccompany);
        for($i=0;$i<$l;$i++){
            if($i==0){$kccompanym = $kccompany[$i];}
            else{$kccompanym = $kccompanym.','.$kccompany[$i];}
        }
        $kcsnom='';
        $l = sizeof($kcsno);
        for($i=0;$i<$l;$i++){
            if($i==0){$kcsnom = $kcsno[$i];}
            else{$kcsnom = $kcsnom.','.$kcsno[$i];}
        }
        $kcrevenuem='';
        $l = sizeof($kcrevenue);
        for($i=0;$i<$l;$i++){
            if($i==0){$kcrevenuem = $kcrevenue[$i];}
            else{$kcrevenuem = $kcrevenuem.','.$kcrevenue[$i];}
        }
        $kcqcompanym='';
        $l = sizeof($kcqcompany);
        for($i=0;$i<$l;$i++){
            if($i==0){$kcqcompanym = $kcqcompany[$i];}
            else{$kcqcompanym = $kcqcompanym.','.$kcqcompany[$i];}
        }
        $kcqsnom='';
        $l = sizeof($kcqsno);
        for($i=0;$i<$l;$i++){
            if($i==0){$kcqsnom = $kcqsno[$i];}
            else{$kcqsnom = $kcqsnom.','.$kcqsno[$i];}
        }
        $kcqrevenuem='';
        $l = sizeof($kcqrevenue);
        for($i=0;$i<$l;$i++){
            if($i==0){$kcqrevenuem = $kcqrevenue[$i];}
            else{$kcqrevenuem = $kcqrevenuem.','.$kcqrevenue[$i];}
        }
        $csvsnamem='';
        $l = sizeof($csvsname);
        for($i=0;$i<$l;$i++){
            if($i==0){$csvsnamem = $csvsname[$i];}
            else{$csvsnamem = $csvsnamem.','.$csvsname[$i];}
        }
        $cdsdatam='';
        $l = sizeof($cdsdata);
        for($i=0;$i<$l;$i++){
            if($i==0){$cdsdatam = $cdsdata[$i];}
            else{$cdsdatam = $cdsdatam.','.$cdsdata[$i];}
        }
        $this->load->model('Menu_model');
        $filea = $_FILES['filea']['name'];
        $uploadPath = 'uploads/annual/';
        $flink1 = $this->Menu_model->mfilea($filea, $uploadPath);
        $fileb = $_FILES['fileb']['name'];
        $uploadPath = 'uploads/annual/';
        $flink2 = $this->Menu_model->mfileb($fileb, $uploadPath);
        $filec = $_FILES['filec']['name'];
        $uploadPath = 'uploads/annual/';
        $flink3 = $this->Menu_model->mfilec($filec, $uploadPath);
        $filed = $_FILES['filed']['name'];
        $uploadPath = 'uploads/annual/';
        $flink4 = $this->Menu_model->mfiled($filed, $uploadPath);
        $this->Menu_model->add_ardata($uid,$uname,$data,$svsnamem,$svlocationm,$csvcnamem,$csvsnamem,$csvlocationm,$cdcdatam,$cdsdatam,$cdrdatam,$kccompanym,$kcsnom,$kcrevenuem,$kcqcompanym,$kcqsnom,$kcqrevenuem,$achievement,$flink1,$flink2,$flink3,$flink4);
        redirect('Menu/Dashboard');
    }
    public function handoverchange(){
        $clientid= $this->input->post('clientid');
        $mediator= $this->input->post('mediator');
        $location= $this->input->post('location');
        $city= $this->input->post('city');
        $state= $this->input->post('state');
        $spd_identify_by= $this->input->post('spd_identify_by');
        $infrastructure= $this->input->post('infrastructure');
        $contact_person= $this->input->post('contact_person');
        $cp_mno= $this->input->post('cp_mno');
        $acontact_person= $this->input->post('acontact_person');
        $acp_mno= $this->input->post('acp_mno');
        $language= $this->input->post('language');
        $expected_installation_date= $this->input->post('expected_installation_date');
        $project_tenure= $this->input->post('project_tenure');
        $project_type= $this->input->post('project_type');
        $comments= $this->input->post('comments');
        $remark= $this->input->post('remark');
        $fttptype= $this->input->post('fttptype');
        $wono= $this->input->post('wono');
        $porno= $this->input->post('porno');
        $gstno= $this->input->post('gstno');
        $panno= $this->input->post('panno');
        $tbudget= $this->input->post('tbudget');
        $payterm= $this->input->post('payterm');
        $pwosdate= $this->input->post('pwosdate');
        $moudate= $this->input->post('moudate');
        $srfinovice= $this->input->post('srfinovice');
        $proformadate= $this->input->post('proformadate');
        $taxinvoicedate= $this->input->post('taxinvoicedate');
        $this->load->model('Menu_model');
        $this->Menu_model->add_handchange($clientid, $mediator, $location, $city, $state, $spd_identify_by, $infrastructure, $contact_person, $cp_mno, $acontact_person, $acp_mno, $language, $expected_installation_date, $project_tenure,$project_type,$comments,$remark,$fttptype,$wono,$porno,$gstno,$panno,$tbudget,$payterm,$pwosdate,$moudate,$srfinovice,$proformadate,$taxinvoicedate);
        redirect('Menu/Dashboard');
    }
    public function TaskReminder($tid,$uid){
        $this->load->model('Menu_model');
        $this->Menu_model->Task_Reminder($tid,$uid);
        redirect('Menu/LiveTaskTrackingBD');
    }
    public function TaskReminderPST($tid,$uid){
        $this->load->model('Menu_model');
        $this->Menu_model->Task_Reminder($tid,$uid);
        redirect('Menu/LiveTaskTrackingPST');
    }
    public function getctot(){
        $ctype= $this->input->post('ctype');
        $this->load->model('Menu_model');
        if($ctype=='On Board Client'){
           echo  $data = '<option>Select Request Type</option>
            <option value="Report">Client Report</option>
            <option value="School Identification">School Identification</option>
            <option value="On Board Client School Visit">On Board Client School Visit</option>
            <option value="Inauguration">Inauguration</option>
            <option value="Employee Engagement">Employee Engagement</option>
            <option value="School Maintenance">School Maintenance</option>
            <option value="RTTP">RTTP</option>
            <option value="DIY">DIY</option>
            <option value="MnE">MnE</option>';
        }else{
            echo  $data = '<option>Select Request Type</option>
            <option value="School Identification">School Identification</option>
            <option value="New client school visit">New client school visit</option>
            <option value="Demo">Online Demo</option>
            <option value="Demo">Offline Demo</option>
            <option value="New Client Report">New Client Report</option>';
        }
        return $data;
    }
    public function login(){
        $user=$this->input->post('user');
        $password=$this->input->post('password');
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->user_login($user,$password);
        if(!empty($dt))
        {
            $sessArray["id"] = $dt[0]->id;
            $sessArray["name"] = $dt[0]->name;
            $sessArray["zone_id"] = $dt[0]->zone_id;
            $sessArray["email"] = $dt[0]->email;
            $sessArray["photo"] = $dt[0]->photo;
            $sessArray["type_id"] = $dt[0]->type_id;
            $sessArray["user_id"] = $dt[0]->user_id;
            $sessArray["admin_id"] = $dt[0]->admin_id;
            $this->session->set_userdata('user',$sessArray);
            set_cookie('user[0]',$sessArray["id"],'60*60*24*30');
            set_cookie('user[1]',$sessArray["name"],'60*60*24*30');
            set_cookie('user[2]',$sessArray["zone_id"],'60*60*24*30');
            set_cookie('user[3]',$sessArray["photo"],'60*60*24*30');
            set_cookie('user[4]',$sessArray["type_id"],'60*60*24*30');
            set_cookie('user[5]',$sessArray["user_id"],'60*60*24*30');
        }else{redirect('Menu/main');}
        if(!empty($dt))
        {
        redirect('Menu/Dashboard');}
        else{redirect('Menu/main');}
    }
    public function Mytarget(){
        date_default_timezone_set("Asia/Calcutta");
        $tdate=date('Y-m-d H:i:s');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        // $mdata = $this->Menu_model->get_daytc($uid);
        $mytarget=$this->Menu_model->get_mytarget($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/Mytarget',['uid'=>$uid,'user'=>$user,'mdata'=>'','mytarget'=>$mytarget]);
        }else{
            redirect('Menu/main');
        }
    }
     public function MytargetStart($uid,$mid){
        $this->load->model('Menu_model');
        $this->Menu_model->Mytarget_Start($uid,$mid);
        redirect('Menu/Mytarget');
    }
    public function MytargetClose(){
        $mid = $this->input->post('taskid');
        $attch = $_FILES['attch']['name'];
        $count = sizeof($attch);
        $mcremark = $this->input->post('mcremark');
        $this->load->model('Menu_model');
        $this->Menu_model->Mytarget_Close($mid,$mcremark,$attch,$count);
        redirect('Menu/Mytarget');
    }
    public function Mytargetchange(){
        $mid = $this->input->post('ttaskid');
        $ttchange = $this->input->post('ttchange');
        $mcremark = $this->input->post('cremark');
        $this->load->model('Menu_model');
        $this->Menu_model->Mytarget_chnage($mid,$mcremark,$ttchange);
        redirect('Menu/Mytarget');
    }
    public function stpst(){
        $user=$this->input->post('user');
        $password=$this->input->post('password');
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->user_login($user,$password);
        if(!empty($dt))
        {
            $sessArray["id"] = $dt[0]->id;
            $sessArray["name"] = $dt[0]->name;
            $sessArray["zone_id"] = $dt[0]->zone_id;
            $sessArray["email"] = $dt[0]->email;
            $sessArray["photo"] = $dt[0]->photo;
            $sessArray["type_id"] = $dt[0]->type_id;
            $sessArray["user_id"] = $dt[0]->user_id;
            $sessArray["admin_id"] = $dt[0]->admin_id;
            $this->session->set_userdata('user',$sessArray);
            set_cookie('user[0]',$sessArray["id"],'60*60*24*30');
            set_cookie('user[1]',$sessArray["name"],'60*60*24*30');
            set_cookie('user[2]',$sessArray["zone_id"],'60*60*24*30');
            set_cookie('user[3]',$sessArray["photo"],'60*60*24*30');
            set_cookie('user[4]',$sessArray["type_id"],'60*60*24*30');
            set_cookie('user[5]',$sessArray["user_id"],'60*60*24*30');
        }else{redirect('Menu/main');}
        if(!empty($dt))
        {
        redirect('Menu/Dashboard');}
        else{redirect('Menu/main');}
    }
    public function mainremark(){
        $status_id= $this->input->post('status_id');
        $this->load->model('Menu_model');
        $result=$this->Menu_model->get_tremark($status_id);
        echo  $data = '<option>Select Remark</option>';
        foreach($result as $d){
           echo  $data = '<option>'.$d->name.'</option>';
        }
        echo  $data = '<option>Other</option>';
        return $data;
    }
    public function getstatus(){
        $cstatus= $this->input->post('cstatus');
        $this->load->model('Menu_model');
        $result=$this->Menu_model->get_status();
        if($cstatus==1){
        foreach($result as $d){if($d->id==8){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==8){
        foreach($result as $d){if($d->id==2){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==2){
        foreach($result as $d){if($d->id==8 || $d->id==4 || $d->id==5){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==3){
        foreach($result as $d){if($d->id==7 || $d->id==4 || $d->id==5 || $d->id==10 || $d->id==11 || $d->id==12){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==4){
        foreach($result as $d){if($d->id==1 || $d->id==8 || $d->id==2){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==5){
        foreach($result as $d){if($d->id==1 || $d->id==8 || $d->id==2){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==6){
        foreach($result as $d){if($d->id==12){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==7){
        foreach($result as $d){if($d->id==7){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==9){
        foreach($result as $d){if($d->id==9){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==10){
        foreach($result as $d){if($d->id==3){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==11){
        foreach($result as $d){if($d->id==3){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==12){
        foreach($result as $d){if($d->id==6){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==13){
        foreach($result as $d){if($d->id==13){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==14){
        foreach($result as $d){if($d->id==14){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        return $data;
    }
    public function getstatusadmin(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $cstatus= $this->input->post('cstatus');
        $this->load->model('Menu_model');
        $result=$this->Menu_model->get_status();
        if($cstatus==1){
        foreach($result as $d){if($d->id==8){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==8){
        foreach($result as $d){if($d->id==1 || $d->id==2){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==2){
        foreach($result as $d){if($d->id==2 || $d->id==4 || $d->id==5){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==3){
        foreach($result as $d){if($d->id==6 || $d->id==7 || $d->id==4 || $d->id==5 || $d->id==10 || $d->id==11 || $d->id==12){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==4){
        foreach($result as $d){if($d->id==1 || $d->id==8 || $d->id==2){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==5){
        foreach($result as $d){if($d->id==1 || $d->id==8 || $d->id==2){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==11){
            foreach($result as $d){if($d->id==11 || $d->id==3){
               echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
            }}}
        if($uyid == 13){
        if($cstatus==6){
        foreach($result as $d){if($d->id==6){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        }
        if($uyid == 4){
            if($cstatus==6){
            foreach($result as $d){if($d->id==6 || $d->id==12 || $d->id==13){
               echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
            }}}
            }
        if($cstatus==7){
        foreach($result as $d){if($d->id==7 || $d->id==4  || $d->id==5 || $d->id==9 || $d->id==10 || $d->id==11 || $d->id==13){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==9){
        foreach($result as $d){if($d->id==9){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==10){
        foreach($result as $d){if($d->id==10 || $d->id==3){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==11){
        foreach($result as $d){if($d->id==11){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==12){
        foreach($result as $d){if($d->id==6 || $d->id==13){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($uyid == 13){
            if($cstatus==13){
                foreach($result as $d){if($d->id==13){
                   echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
                }}}
        }
        if($uyid == 4){
            if($cstatus==13){
                foreach($result as $d){if($d->id==13 || $d->id==6){
                   echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
             }}}
        }
        if($cstatus==14){
        foreach($result as $d){if($d->id==14){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        return $data;
    }
    public function getstatuspst(){
        $cstatus= $this->input->post('cstatus');
        $this->load->model('Menu_model');
        $result=$this->Menu_model->get_status();
        echo  $data = '<option>Select Status</option>';
        foreach($result as $d){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }
        return $data;
    }
    public function getstatusbd(){
        $cstatus= $this->input->post('cstatus');
        $this->load->model('Menu_model');
        $result=$this->Menu_model->get_status();
        if($cstatus==1){
        foreach($result as $d){if($d->id==8){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==8){
        foreach($result as $d){if($d->id==2){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==2){
        foreach($result as $d){if($d->id==2 || $d->id==4 || $d->id==5){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==3){
        foreach($result as $d){if($d->id==3){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==4){
        foreach($result as $d){if($d->id==1 || $d->id==8 || $d->id==2){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==5){
        foreach($result as $d){if($d->id==1 || $d->id==8 || $d->id==2){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==6){
        foreach($result as $d){if($d->id==6){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==7){
        foreach($result as $d){if($d->id==7){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==9){
        foreach($result as $d){if($d->id==9){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==10){
        foreach($result as $d){if($d->id==3){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==11){
        foreach($result as $d){if($d->id==3){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==12){
        foreach($result as $d){if($d->id==12){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==13){
        foreach($result as $d){if($d->id==13){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==14){
        foreach($result as $d){if($d->id==14){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        return $data;
    }
    public function setdateremark(){
        $i = 0;
        date_default_timezone_set("Asia/Calcutta");
        $tdate =  date('Y-m-d');
        $uid = $this->input->post('uid');
        $date = $this->input->post('date');
        $date = strtotime($date);
        $date = date('H:i:s', $date);
        $this->load->model('Menu_model');
        $limit = $this->Menu_model->get_talimit($uid,$tdate);
        foreach($limit as $li){
            $t1 = $aid = $li->time.' ';
            $t2 =  date('H:i:s',strtotime('+10 minutes',strtotime($t1)));
            if($t1<=$date && $t2>=$date){$i++;}
        }
        if($i>0){echo 1;}else{echo 0;}
    }
    public function submittask(){
        // echo "<pre>";
        // print_r($_POST);
        // die;
        $status=1;$filname="";$tid="";$uid="";$action_id="";$ystatus="";$remark="";$remark_msg="";$noremark="";$purpose="";$nremark_msg="";$rpmmom='null';$mom='null';$flink='null';$flink1='null';$flink2='null';
        $tid = $_POST['tid'];
        $uid = $_POST['uid'];
        $cmpid = $_POST['cmpid'];
        $cstatus = $_POST['ccstatus'];
        $actontaken = $_POST['actontaken'];
        if (isset($_POST['LinkedIn'])) {
        $LinkedIn = $_POST['LinkedIn'];
        }else{
            $LinkedIn = "";
        }
        if(isset($_POST['Facebook'])){
            $Facebook = $_POST['Facebook'];
        }else{$Facebook="";}
        if(isset($_POST['YouTube'])){
            $YouTube = $_POST['YouTube'];
        }else{
            $YouTube = "";
        }
        if(isset($_POST['Instagram'])){
            $Instagram = $_POST['Instagram'];
        }else{$Instagram = "";}
        if(isset($_POST['OtherSocial'])){
            $OtherSocial = $_POST['OtherSocial'];
        }else{$OtherSocial ="";}
        if(isset($_POST['action_id'])){$action_id=$_POST['action_id'];}
        if(isset($_POST['yaction_id'])){$action_id = $_POST['yaction_id'];}
        if(isset($_POST['purpose'])){$purpose = $_POST['purpose'];}
        if(isset($_POST['ystatus'])){$ystatus = $_POST['ystatus'];}
        if(isset($_POST['noremark'])){$noremark = $_POST['noremark'];}
        if(isset($_POST['yremark_msg'])){$yremark = $_POST['yremark_msg'];}
        if(isset($_POST['nremark_msg'])){$nremark = $_POST['nremark_msg'];}
        if(isset($_POST['rpmmom'])){$rpmmom = $_POST['rpmmom'];}
        if(isset($_POST['nadate'])){$nadate = $_POST['nadate'];}else{$nadate='0';}
        if(isset($_FILES['filname']['name'])){$filname = $_FILES['filname']['name'];
            $uploadPath = 'uploads/proposal/';
            $this->load->model('Menu_model');
            $flink = $this->Menu_model->uploadfile($filname, $uploadPath);
        }else{$this->load->model('Menu_model');$flink=0;}
        if(isset($_FILES['filname2']['name'])){$filname2 = $_FILES['filname2']['name'];
            $uploadPath = 'uploads/proposal/';
            $this->load->model('Menu_model');
            $flink2 = $this->Menu_model->uploadfile($filname2, $uploadPath);
        }else{$this->load->model('Menu_model');$flink2=0;}
        if(isset($_FILES['filname1']['name'])){$filname1 = $_FILES['filname1']['name'];
            $uploadPath = 'uploads/proposal/';
            $this->load->model('Menu_model');
            $flink1 = $this->Menu_model->uploadfile($filname1, $uploadPath);
        }else{$this->load->model('Menu_model');$flink1=0;}
        if($noremark!=''){$remark=$noremark;}
        if($yremark!=''){$remark=$yremark;}
        if($nremark!=''){$remark=$nremark;}
        if($ystatus!==''){$status=$ystatus;}else{$status=$cstatus;}
        if($purpose==''){$purpose='yes';}
        if($action_id=='7'){
            $partner = $_POST['partner'];
            $noofsc = $_POST['noofsc'];
            $pbudgetme = $_POST['pbudgetme'];
        }else{$partner = "";$noofsc = "";$pbudgetme = "";}
        $id = $this->Menu_model->submit_task($tid,$uid,$cmpid,$actontaken,$action_id,$status,$remark,$rpmmom,$purpose,$flink,$flink1,$flink2,$partner,$noofsc,$pbudgetme,$LinkedIn,$Facebook,$YouTube,$Instagram,$OtherSocial,$nadate);
        redirect('Menu/Dashboard');
    }
    public function submittask1(){
        $this->load->library('session');
        $status=1;$filname="";$tid="";$uid="";$action_id="";$ystatus="";$remark="";$remark_msg="";$noremark="";$purpose="";$nremark_msg="";$rpmmom='null';$mom='null';$flink='null';$flink1='null';$flink2='null';
        $tid = $_POST['tid'];
        $uid = $_POST['uid'];
        $cmpid = $_POST['cmpid'];
        $cstatus = $_POST['ccstatus'];
        $actontaken = $_POST['actontaken'];
        if (isset($_POST['LinkedIn'])) {
        $LinkedIn = $_POST['LinkedIn'];
        }else{
            $LinkedIn = "";
        }
        if(isset($_POST['Facebook'])){
            $Facebook = $_POST['Facebook'];
        }else{$Facebook="";}
        if(isset($_POST['YouTube'])){
            $YouTube = $_POST['YouTube'];
        }else{
            $YouTube = "";
        }
        if(isset($_POST['Instagram'])){
            $Instagram = $_POST['Instagram'];
        }else{$Instagram = "";}
        if(isset($_POST['OtherSocial'])){
            $OtherSocial = $_POST['OtherSocial'];
        }else{$OtherSocial ="";}
        if(isset($_POST['action_id'])){$action_id=$_POST['action_id'];}
        if(isset($_POST['yaction_id'])){$action_id = $_POST['yaction_id'];}
        if(isset($_POST['purpose'])){$purpose = $_POST['purpose'];}
        if(isset($_POST['ystatus'])){$ystatus = $_POST['ystatus'];}
        if(isset($_POST['noremark'])){$noremark = $_POST['noremark'];}
        if(isset($_POST['yremark_msg'])){$yremark = $_POST['yremark_msg'];}
        if(isset($_POST['nremark_msg'])){$nremark = $_POST['nremark_msg'];}
        if(isset($_POST['rpmmom'])){$rpmmom = $_POST['rpmmom'];}
        // if(isset($_POST['nadate'])){$nadate = $_POST['nadate'];}else{$nadate='0';}
        if(isset($_FILES['filname']['name'])){$filname = $_FILES['filname']['name'];
            $uploadPath = 'uploads/proposal/';
            $this->load->model('Menu_model');
            $flink = $this->Menu_model->uploadfile($filname, $uploadPath);
        }else{$this->load->model('Menu_model');$flink=0;}
        if(isset($_FILES['filname2']['name'])){$filname2 = $_FILES['filname2']['name'];
            $uploadPath = 'uploads/proposal/';
            $this->load->model('Menu_model');
            $flink2 = $this->Menu_model->uploadfile($filname2, $uploadPath);
        }else{$this->load->model('Menu_model');$flink2=0;}
        if(isset($_FILES['filname1']['name'])){$filname1 = $_FILES['filname1']['name'];
            $uploadPath = 'uploads/proposal/';
            $this->load->model('Menu_model');
            $flink1 = $this->Menu_model->uploadfile($filname1, $uploadPath);
        }else{$this->load->model('Menu_model');$flink1=0;}
        if($noremark!=''){$remark=$noremark;}
        if($yremark!=''){$remark=$yremark;}
        if($nremark!=''){$remark=$nremark;}
        if($ystatus!==''){$status=$ystatus;}else{$status=$cstatus;}
        if($purpose==''){$purpose='yes';}
        if($action_id=='7'){
            $partner = $_POST['partner'];
            $noofsc = $_POST['noofsc'];
            $pbudgetme = $_POST['pbudgetme'];
        }else{$partner = "";$noofsc = "";$pbudgetme = "";}
       
         // Start mom acten taken yes
         $momdata = $_POST['momdata'];
         $action_id = $_POST['action_id'];
         if($actontaken == 'yes' && $action_id == 6 && $momdata =='momdata'){
           
             $meetingdonewinitiator = $_POST['meetingdonewinitiator'];
            //  presentation Start
             $presentation = $_POST['presentation'];
             $presentationdata = '';
 
             foreach($presentation as $prs){
                 $presentationdata .=$prs.',';
             }
             $presentationdata = rtrim($presentationdata, ',');
             //  presentation End
 
            //  identify_school_state Start
             $ischool_state = $_POST['identify_school_state'];
             $ischoolstate = '';
             foreach($ischool_state as $state){
                $ischoolstate .=$state.',';
             }
             $ischoolstate = rtrim($ischoolstate, ',');
            //  identify_school_state End
            //  identify_school_district Start
             $ischool_district = $_POST['identify_school_district'];
             $ischooldistrict = '';
             foreach($ischool_district as $district){
                $ischooldistrict .=$district.',';
             }
             $ischooldistrict = rtrim($ischooldistrict, ',');
            //  identify_school_district End
             //  no_of_school Start
             $ino_of_school = $_POST['no_of_school'];
             $ischoolcnt = '';
             foreach($ino_of_school as $school){
                $ischoolcnt .=$school.',';
             }
             $ischoolcnt = rtrim($ischoolcnt, ',');
            //  no_of_school End
            $client_int_type_project = $this->input->post('client_int_type_project');
            if($client_int_type_project == ''){$client_int_type_project = '';}
             $data = array(
                 'ccstatus' => $cstatus,
                 'action_id' => $this->input->post('action_id'),
                 'user_id' => $uid,
                 'init_cmpid' => $this->input->post('cmpid'),
                 'tid' => $this->input->post('tid'),
                 'actontaken' => $actontaken,
                 'meetingdonewinitiator' => $this->input->post('meetingdonewinitiator'),
                 'presentation' => $presentationdata,
                 'project_intervention_select' => $this->input->post('project_intervention_select'),
                 'project_intervention' => $this->input->post('project_intervention'),
                 'client_has_adopted_select' => $this->input->post('client_has_adopted_select'),
                 'client_has_adopted' => $this->input->post('client_has_adopted'),
                 'approving_autorities' => $this->input->post('approving_autorities'),
                 'budget_for_cfyear' => $this->input->post('budget_for_cfyear'),
                 'fund_sanstion_limit' => $this->input->post('fund_sanstion_limit'),
                 'other_specific_remarks' => $this->input->post('other_specific_remarks'),
                 'submit_proposal' => $this->input->post('submit_proposal'),
                 'proposal_no_of_school' => $this->input->post('proposal_no_of_school'),
                 'proposal_of_budget' => $this->input->post('proposal_of_budget'),
                 'proposal_of_location' => $this->input->post('proposal_of_location'),
                 'identify_school' => $this->input->post('identify_school'),
                 'identify_school_state' => $ischoolstate,
                 'identify_school_district' =>$ischooldistrict,
                 'no_of_school' => $ischoolcnt,
                 'permission_letter' => $this->input->post('permission_letter'),
                 'permission_letter_rech' => $this->input->post('permission_letter_rech'),
                 'Letter_organization_name' => $this->input->post('Letter_organization_name'),
                 'Letter_organization_designation' => $this->input->post('Letter_organization_designation'),
                 'Letter_organization_location' => $this->input->post('Letter_organization_location'),
                 'client_int_school_visit' => $this->input->post('client_int_school_visit'),
                 'client_int_type_project' => $client_int_type_project,
                 'client_int_school_date' => $this->input->post('client_int_school_date'),
                 'client_int_school_state' => $this->input->post('client_int_school_state'),
                 'client_int_school_district' => $this->input->post('client_int_school_district'),
                 'client_int_no_of_school' => $this->input->post('client_int_no_of_school'),
                 'intervention_cm_pst_sh' => $this->input->post('intervention_cm_pst_sh'),
                 'rpmmom' => $this->input->post('rpmmom'),
                 'partner' => $this->input->post('partner'),
             );
             // Call the model function to insert the data
             $id = $this->Menu_model->add_momData($data);
             $this->session->set_flashdata('success_message','Mom Data Submitted SuccessFully !');
         }
 
          // End mom acten taken yes
          if($action_id == 10){
            $init_id = $_POST['cmpid'];
            $getcmpinfo1 =  $this->Menu_model->get_cmpbyinid($init_id);
            $org_compname =  $getcmpinfo1[0]->compname;
            if($org_compname =='Unknown'){
                $status =1;
            }
        }
        $id = $this->Menu_model->submit_task1($tid,$uid,$cmpid,$actontaken,$action_id,$status,$remark,$rpmmom,$purpose,$flink,$flink1,$flink2,$partner,$noofsc,$pbudgetme,$LinkedIn,$Facebook,$YouTube,$Instagram,$OtherSocial);
      
        
        if($action_id == 10){
            $getcmpinfo1 =  $this->Menu_model->get_cmpbyinid($init_id);
            $org_compname =  $getcmpinfo1[0]->compname;
            
            if($org_compname =='Unknown'){
                redirect("Menu/AddNewLead/$init_id"); 
                $this->session->set_flashdata('success_message',' Please Add Your Lead ');
            }
        }
        redirect('Menu/Dashboard');
    }
    public function submitRPP(){
        $priority = $_POST['priority'];
        $tid = $_POST['tmid'];
        $this->load->model('Menu_model');
        $id = $this->Menu_model->submit_RPP($tid,$priority);
        redirect('Menu/RPPriority');
    }
    public function daysc(){
      
        $wffo=0;
        $do = $_POST['do'];
        if(isset($_POST['wffo'])){$wffo = $_POST['wffo'];}
        $user_id = $_POST['user_id'];
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
      
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
      
        $filname = $_FILES['filname']['name'];
        $uploadPath = 'uploads/day/';
        $this->load->model('Menu_model');
     
        if($do == 1){
            if($uyid == 3 || $uyid == 4 || $uyid == 13){
            $pendingtaskcmp = $this->Menu_model->get_PendingTaskForToday($user_id);
            $pendingautotaskcmpcnt = sizeof($pendingtaskcmp);  
           if($pendingautotaskcmpcnt > 0){
               $this->session->set_flashdata('error_message','Total '. $pendingautotaskcmpcnt . ' Pending Auto Task, First Complete Your Pending Autotask Before Going Task Planner Page');
               redirect('Menu/Dashboard');
           }else{
            $flink = $this->Menu_model->uploadfile($filname, $uploadPath);
            $this->Menu_model->submit_day($wffo,$flink,$user_id,$lat,$lng,$do);
           } 
        }else{
            $flink = $this->Menu_model->uploadfile($filname, $uploadPath);
            $this->Menu_model->submit_day($wffo,$flink,$user_id,$lat,$lng,$do);
        }
        }
      
        if($do == 0){
          
            $pendingtaskcmp = $this->Menu_model->get_PendingTaskForToday($user_id);
           $pendingautotaskcmpcnt = sizeof($pendingtaskcmp);  
           if($pendingautotaskcmpcnt > 0){
                $flink = $this->Menu_model->uploadfile($filname, $uploadPath);
                $this->Menu_model->submit_day($wffo,$flink,$user_id,$lat,$lng,$do);
               $this->session->set_flashdata('error_message','Total '. $pendingautotaskcmpcnt . ' Pending Auto Task, First Complete Your Pending Autotask Before Going Task Planner Page');
               redirect('Menu/Dashboard');
           }else{
            if($uyid == 3 || $uyid == 4 || $uyid == 13){
                $flink = $this->Menu_model->uploadfile($filname, $uploadPath);
                $this->Menu_model->submit_day($wffo,$flink,$user_id,$lat,$lng,$do);
                $this->session->set_flashdata('error_message','Please Set Todays Planner First');
                redirect('Menu/Dashboard');
            }else{
                $flink = $this->Menu_model->uploadfile($filname, $uploadPath);
                $this->Menu_model->submit_day($wffo,$flink,$user_id,$lat,$lng,$do);
            }
           }
        }
       
        redirect('Menu/Dashboard');
    }
    public function checkdays(){
        $rat1 = $_POST['rat1'];
        $rat2 = $_POST['rat2'];
        $rat3 = $_POST['rat3'];
        $rat4 = $_POST['rat4'];
        $udid = $_POST['udid'];
        $que = $_POST['que'];
        $sremark = $_POST['sremark'];
        $this->load->model('Menu_model');
        $this->Menu_model->check_days($rat1,$rat2,$rat3,$rat4,$sremark,$udid,$que);
        redirect('Menu/DayStartCheck');
    }
    public function checkmeeting(){
        $rat1 = $_POST['rat1'];
        $rat2 = $_POST['rat2'];
        $rat3 = $_POST['rat3'];
        $rat4 = $_POST['rat4'];
        $udid = $_POST['udid'];
        $que = $_POST['que'];
        $mremark = $_POST['mremark'];
        $this->load->model('Menu_model');
        $this->Menu_model->check_meeting($rat1,$rat2,$rat3,$rat4,$mremark,$udid,$que);
        redirect('Menu/MeetingCheck');
    }
    public function checkdayc(){
        $rat1 = $_POST['rat1'];
        $rat2 = $_POST['rat2'];
        $rat3 = $_POST['rat3'];
        $rat4 = $_POST['rat4'];
        $udid = $_POST['udid'];
        $que = $_POST['que'];
        $sremark = $_POST['sremark'];
        $this->load->model('Menu_model');
        $this->Menu_model->check_dayc($rat1,$rat2,$rat3,$rat4,$sremark,$udid,$que);
        redirect('Menu/DayCloseCheck');
    }
    public function checkdaytask(){
        $rat = $_POST['rat'];
        $rremark = $_POST['rremark'];
        $taskid = $_POST['taskid'];
        $uuid = $_POST['uuid'];
        $this->load->model('Menu_model');
        $this->Menu_model->check_daytask($rat,$rremark,$taskid,$uuid);
        redirect('Menu/TaskCheck');
    }
    public function dailytc(){
        $start = $_POST['start'];
        $piid = $_POST['piid'];
        $bdid = $_POST['bdid'];
        $pc = $_POST['pc'];
        $dsr = $_POST['dsr'];
        $apps = $_POST['apps'];
        $other = $_POST['other'];
        $this->load->model('Menu_model');
        $this->Menu_model->submit_tcs($start,$piid,$bdid,$pc,$dsr,$apps,$other);
        redirect('Menu/Dashboard');
    }
    public function rosterstart(){
        $pstid = $_POST['pstid'];
        $bdid = $_POST['bdid'];
        $this->load->model('Menu_model');
        $this->Menu_model->roster_start($pstid,$bdid);
        redirect('Menu/RosterCalling');
    }
    public function planreview(){
        $plandate = $_POST['plandate'];
        $uid = $_POST['uid'];
        $bdid = $_POST['bdid'];
        $fixdate = $_POST['fixdate'];
        $reviewtype = $_POST['reviewtype'];
        $meetlink = $_POST['meetlink'];
        $this->load->model('Menu_model');
        $this->Menu_model->plan_review($plandate,$uid,$bdid,$reviewtype,$meetlink,$fixdate);
        redirect('Menu/AllReviewPlaing');
    }
    public function pstplanreview(){
        $plandate = $_POST['plandate'];
        $uid = $_POST['uid'];
        $bdid = $_POST['bdid'];
        $fixdate = $_POST['fixdate'];
        $reviewtype = $_POST['reviewtype'];
        $meetlink = $_POST['meetlink'];
        $this->load->model('Menu_model');
        $this->Menu_model->plan_review($plandate,$uid,$bdid,$reviewtype,$meetlink,$fixdate);
        redirect('Menu/AllPSTReviewPlaing');
    }
    public function startreview(){
        $startt = $_POST['startt'];
        $reviewid = $_POST['reviewid'];
        $this->load->model('Menu_model');
        $this->Menu_model->start_review($startt,$reviewid);
        redirect('Menu/AllReviewPlaing');
    }
    public function pststartreview(){
        $startt = $_POST['startt'];
        $reviewid = $_POST['reviewid'];
        $this->load->model('Menu_model');
        $this->Menu_model->start_review($startt,$reviewid);
        redirect('Menu/AllPSTReviewPlaing');
    }
    public function closereview(){
        $closeremark = $_POST['closeremark'];
        $closetdate = $_POST['closetdate'];
        $rrid = $_POST['rrid'];
        $this->load->model('Menu_model');
        $result = $this->Menu_model->close_review($closetdate,$closeremark,$rrid);
        $data['uid'] =  $result[0]->uid;
        $data['reviewType'] =  $result[0]->reviewType;
        redirect('Menu/targetQandA',$data);
        // redirect('Menu/AllReviewPlaing');
    }
    public function pstclosereview(){
        $closeremark = $_POST['closeremark'];
        $closetdate = $_POST['closetdate'];
        $rrid = $_POST['rrid'];
        $this->load->model('Menu_model');
        $result = $this->Menu_model->close_review($closetdate,$closeremark,$rrid);
        $data['uid']        =  $result[0]->uid;
        $data['reviewType'] =  $result[0]->reviewType;
        redirect('Menu/targetQandA',$data);
        // redirect('Menu/AllPSTReviewPlaing');
    }
    public function rosterclose(){
        $pstid = $_POST['pid'];
        $bdid = $_POST['bid'];
        $closeremark = $_POST['closeremark'];
        $this->load->model('Menu_model');
        $this->Menu_model->roster_close($pstid,$bdid,$closeremark);
        redirect('Menu/RosterCalling');
    }
    public function rcremark(){
        echo $pstid = $_POST['pst'];
        echo $bdid = $_POST['bd'];
        echo $cid = $_POST['cid'];
        echo $inid = $_POST['inid'];
        $lremark = $_POST['lremark'];
        $cremark = $_POST['cremark'];
        $this->load->model('Menu_model');
        $this->Menu_model->rc_remark($pstid,$bdid,$cid,$inid,$lremark,$cremark);
        redirect('Menu/RosterCalling');
    }
    public function rosterca(){
        $piid = $_POST['piid'];
        $bdid = $_POST['bdid'];
        $ps = $_POST['ps'];
        $sscc = $_POST['sscc'];
        $rpcs = $_POST['rpcs'];
        $pcu = $_POST['pcu'];
        $ecftw = $_POST['ecftw'];
        $this->load->model('Menu_model');
        $this->Menu_model->submit_rosterca($piid,$bdid,$ps,$sscc,$rpcs,$pcu,$ecftw);
        redirect('Menu/Dashboard');
    }
    public function dailytcc(){
        $close = $_POST['close'];
        $piid = $_POST['piida'];
        $cremark = $_POST['cremark'];
        $this->load->model('Menu_model');
        $this->Menu_model->submit_tcsc($close,$piid,$cremark);
        redirect('Menu/Dashboard');
    }
    public function dateplan1($tdate,$uid){
        $taskid = $_POST['taskid'];
        $tasktimeplan = $_POST['tasktimeplan'];
        $date = $tdate.'T'.$tasktimeplan;
        $this->load->model('Menu_model');
        $this->Menu_model->plantask($taskid,$date,$uid);
        redirect('Menu/TaskPlanner2/'.$tdate);
    }
    public function dateplan(){
        $taskid = $_POST['taskid'];
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $this->load->model('Menu_model');
        $this->Menu_model->plantask($taskid,$date,$uid);
        redirect('Menu/Dashboard');
    }
    public function HandBINDReminder(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uname = $user['name'];
        $rid = $_POST['rid'];
        $creminder = $_POST['creminder'];
        $this->load->model('Menu_model');
        list($val1, $val2) = explode(",", $rid);
        $stid=$val1;
        $cid = $val2;
        $this->Menu_model->HandBIND_Reminder($cid,$stid,$creminder,$uname);
        redirect('Menu/HandBINDDetail/'.$cid);
    }
    public function HandBINDWarn(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uname = $user['name'];
        $wid = $_POST['wid'];
        $cwarning = $_POST['cwarning'];
        $this->load->model('Menu_model');
        list($val1, $val2) = explode(",", $wid);
        $stid=$val1;
        $cid = $val2;
        $this->Menu_model->HandBIND_Warn($cid,$stid,$cwarning,$uname);
        redirect('Menu/HandBINDDetail/'.$cid);
    }
    public function bdrcomment(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uname = $user['name'];
        $rid = $_POST['rid'];
        $rcomment = $_POST['rcomment'];
        $this->load->model('Menu_model');
        if(isset($_FILES['filname']['name'])) {
           $filname = $_FILES['filname']['name'];
        }else{$filname=0;}
        $this->Menu_model->bdr_comment($rid,$rcomment,$filname,$uname);
        redirect('Menu/TotalBDRequest/1');
    }
    public function bdrclose(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uname = $user['name'];
        $rid = $_POST['rrid'];
        $ccomment = $_POST['ccomment'];
        $this->load->model('Menu_model');
        $this->Menu_model->bdr_close($rid,$ccomment,$uname);
        redirect('Menu/TotalBDRequest/1');
    }
    public function bdropen(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uname = $user['name'];
        $rid = $_POST['rrrid'];
        $ccomment = $_POST['rccomment'];
        $this->load->model('Menu_model');
        $this->Menu_model->bdr_open($rid,$ccomment,$uname);
        redirect('Menu/TotalBDRequest/1');
    }
    public function AdminDailyReport(){
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
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/admindailyreport',['uid'=>$uid,'user'=>$user,'tdate'=>$tdate]);
        }else{
            redirect('Menu/main');
        }
    }
    public function NextDayPlanner(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/NextDayPlanner',['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ClientProject(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/ClientProject',['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TaskPlanner1($adate){
        if(isset($_POST['adate'])){
            $adate = $_POST['adate'];
        }else{
            $adate = $adate;
        }
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $tptime=$this->Menu_model->get_tptime($uid);
        $tptime = $tptime[0]->tptime;
        $dep_name = $dt[0]->name;
        $getreqData  =  $this->db->query("SELECT * FROM `task_plan_for_today` WHERE user_id =$uid and date='$adate'");
        $getreqData =  $getreqData->result();
        if(!empty($user)){
            $this->load->view($dep_name.'/TaskPlanner1',['uid'=>$uid,'user'=>$user,'adate'=>$adate,'tptime'=>$tptime,'getreqData'=>$getreqData]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TaskPlanner($adate){
        if(isset($_POST['adate'])){
            $adate = $_POST['adate'];
        }else{
            $adate = $adate;
        }
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $tptime=$this->Menu_model->get_tptime($uid);
        $tptime = $tptime[0]->tptime;
        $dep_name = $dt[0]->name;
        $planbutnotinited = $this->Menu_model->get_allcmp_planbutnotinited($uid);
        $planbutnotinitedcnt = sizeof($planbutnotinited);
        $getreqData  =  $this->db->query("SELECT * FROM `task_plan_for_today` WHERE user_id =$uid and date='$adate'");
        $getreqData =  $getreqData->result();
        $getAutoTaskTime  =  $this->db->query("SELECT * FROM `autotask_time` WHERE user_id =$uid and date='$adate'");
        $getAutoTaskTime =  $getAutoTaskTime->result();
        $curdate = date("Y-m-d");
        $getPendingAutoTask  =  $this->db->query("SELECT * FROM `tblcallevents` WHERE user_id = $uid AND nextCFID = 0 AND autotask = 1 AND auto_plan = 1 AND cast(appointmentdatetime AS DATE) != '$curdate'");
        $getPendingTask =  $getPendingAutoTask->result();
        $pcount = sizeof($getPendingTask);
    $getPendingTimeTask  =  $this->db->query("SELECT *
    FROM `tblcallevents`
    WHERE user_id = $uid
      AND (nextCFID = 0
           AND lastCFID = 0
           AND plan = 1
           AND autotask = 1
           AND auto_plan = 0)");
    $getPendingTimeTask =  $getPendingTimeTask->result();
    $timecount = 0;
    foreach ($getPendingTimeTask as $taskmin){
        $taskactiontime = $this->Menu_model->getTaskAction($taskmin->actiontype_id);
        $timecount += $taskactiontime[0]->yest;
    }
        $hours = floor($timecount / 60);
        $minutes = $timecount % 60;
        $mesaage = $hours ." Hours ".$minutes." Minutes Pending For Task Work";
        // $planbutnotinitedcnt =1;
        // echo "<pre>";
        // print_r($planbutnotinited);
        // die;
    if($planbutnotinitedcnt > 0){
        $this->load->library('session');
        $this->session->set_flashdata('success_message', $planbutnotinitedcnt . ' pending tasks - First, Plan You Old Pending Task with Plan But Not Initiated');
    }
    $getplandateindata  =  $this->db->query("SELECT * FROM `autotask_time` where user_id='$uid' AND date ='$adate'");
    $getplandateindata =  $getplandateindata->result();
        if(!empty($user)){
            $this->load->view($dep_name.'/TaskPlanner',['uid'=>$uid,'user'=>$user,'planbutnotinitedcnt'=>$planbutnotinitedcnt,'getplandt'=>$getplandateindata,'pendingtask'=>$pcount, 'mesaage'=>$mesaage,'adate'=>$adate,'tptime'=>$tptime,'getAutoTaskTime'=>$getAutoTaskTime,'getreqData'=>$getreqData]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TaskPlanner2($adate){
        
        date_default_timezone_set("Asia/Calcutta");
        
        if(isset($_POST['adate'])){
            $adate = $_POST['adate'];
        }else{
            $adate = $adate;
        }

        $tommrowdate =  date('Y-m-d', strtotime('tomorrow'));

        $datetime1      = new DateTime($tommrowdate);
        $datetime1_cur  = new DateTime(date("Y-m-d"));
        $datetime2      = new DateTime($adate);
        if ($datetime1 < $datetime2) {
            $this->session->set_flashdata('error_message','* You Can Not Planned Task For This Date : '.$adate);
            $adate = $tommrowdate;
            redirect("Menu/TaskPlanner2/".$adate); 
        }elseif ($datetime1_cur > $datetime2) {
            $this->session->set_flashdata('error_message','* You Can Not Planned Task For This Date : '.$adate);
            $adate = date("Y-m-d");
            redirect("Menu/TaskPlanner2/".$adate);
        }

        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $this->load->library('session');
        $dt=$this->Menu_model->get_utype($uyid);
        $tptime=$this->Menu_model->get_tptime($uid);
        $tptime = $tptime[0]->tptime;
        $dep_name = $dt[0]->name;

        if($adate == date("Y-m-d")){
            $aptime         = $this->Menu_model->GetTodaysAutoTaskANDPlanningTime($uid,date("Y-m-d"));
            $aptimecnt      = sizeof($aptime);
            if($aptimecnt > 0){
                $givenTime   = $aptime[0]->start_tttpft;
                $currentTime = date("H:i:s");
                $timestamp1  = strtotime($givenTime);
                $timestamp2  = strtotime($currentTime);
                if ($timestamp2 >= $timestamp1) {
                    $this->session->set_flashdata('error_message',"* Today's time is up! Now plan your task for tomorrow.");
                    redirect("Menu/TaskPlanner2/".$tommrowdate); 
                }
            }
        }

        $planbutnotinited = $this->Menu_model->get_allcmp_planbutnotinited($uid);
        
        $user_day = $this->Menu_model->get_daydetail($uid,date("Y-m-d"));
        if(sizeof($user_day) == 0){
            $this->session->set_flashdata('error_message','* Please Start Your Day');
            redirect('Menu/DayManagement');
        }   
        $pendingautotaskcmp = $this->Menu_model->get_PendingAutoTask($uid);
       
        $pendingautotaskcmpcnt = sizeof($pendingautotaskcmp);
       
        if($pendingautotaskcmpcnt > 0){
            $this->session->set_flashdata('error_message','Total '. $pendingautotaskcmpcnt . ' Pending Auto Task, First Complete Your Pending Autotask Before Going Task Planner Page');
            redirect('Menu/Dashboard2');
        }
        

        $oldplanbutnotinited = $this->Menu_model->get_all_old_cmp_planbutnotinited($uid);
        $oldplanbutnotinitedcnt = sizeof($oldplanbutnotinited);
        if($oldplanbutnotinitedcnt > 0){
            $this->session->set_flashdata('error_message','Total '. $oldplanbutnotinitedcnt . ' Yesterday Pending Task.');
            // redirect("Menu/TaskPlanner2/".$adate);
        }   
       
        $this->CheckPlannerTimeisReadyorNot($uid,$adate);
     
        $planbutnotinitedcnt = sizeof($planbutnotinited);
        $getreqData  =  $this->db->query("SELECT * FROM `task_plan_for_today` WHERE user_id =$uid and date='$adate'");
        $getreqData =  $getreqData->result();
        $getAutoTaskTime  =  $this->db->query("SELECT * FROM `autotask_time` WHERE user_id =$uid and date='$adate'");
        $getAutoTaskTime =  $getAutoTaskTime->result();
        $curdate = date("Y-m-d");
        $getPendingAutoTask  =  $this->db->query("SELECT * FROM `tblcallevents` WHERE user_id = $uid AND nextCFID = 0 AND autotask = 1 AND auto_plan = 1 AND cast(appointmentdatetime AS DATE) != '$curdate'");
        $getPendingTask =  $getPendingAutoTask->result();
        $pcount = sizeof($getPendingTask);
    $getPendingTimeTask  =  $this->db->query("SELECT * FROM `tblcallevents` WHERE user_id = $uid  AND (nextCFID = 0 AND lastCFID = 0 AND plan = 1 AND autotask = 1 AND auto_plan = 0)");
    $getPendingTimeTask =  $getPendingTimeTask->result();
    $timecount = 0;
    foreach ($getPendingTimeTask as $taskmin){
        $taskactiontime = $this->Menu_model->getTaskAction($taskmin->actiontype_id);
        $timecount += $taskactiontime[0]->yest;
    }
        $hours = floor($timecount / 60);
        $minutes = $timecount % 60;
        $mesaage = $hours ." Hours ".$minutes." Minutes Pending For Task Work";
   
   
    $getplandateindata  =  $this->db->query("SELECT * FROM `autotask_time` where user_id='$uid' AND date ='$adate'");
    $getplandateindata =  $getplandateindata->result();
        if(!empty($user)){
            $this->load->view($dep_name.'/TaskPlanner2',['uid'=>$uid,'user'=>$user,'planbutnotinitedcnt'=>$planbutnotinitedcnt,'getplandt'=>$getplandateindata,'pendingtask'=>$pcount, 'mesaage'=>$mesaage,'adate'=>$adate,'tptime'=>$tptime,'getAutoTaskTime'=>$getAutoTaskTime,'getreqData'=>$getreqData,'oldPendTask'=>$oldplanbutnotinited,'type_id'=>$uyid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function CheckPlannerTimeisReadyorNot($uid,$adate){
        
        $this->load->model('Menu_model');
        $this->load->library('session');
        if($adate !== date("Y-m-d")){
            $aptime = $this->Menu_model->GetTodaysAutoTaskANDPlanningTime($uid,date("Y-m-d"));
            $aptimecnt = sizeof($aptime);
            if($aptime > 0){
                $start_tttpft = $aptime[0]->start_tttpft;
                $end_tttpft = $aptime[0]->end_tttpft;
                $current_time = date("H:i:s");
                $current_date = date("Y-m-d");
    
                $start_time = new DateTime($start_tttpft);
                $current_time_obj = new DateTime($current_time);
                $interval = $current_time_obj->diff($start_time);
                if ($current_time >= $start_tttpft) {
                    // echo "The time has already passed.";
                } else {
                    $this->session->set_flashdata('error_message_plan',"Time remaining to plan your next day:" . $interval->format('%H hours, %I minutes, and %S seconds'));
                    redirect("Menu/TaskPlanner2/".$current_date); 
                }  
            }
        }
    }
    public function RequestForTodaysTaskPlan(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $userData  =  $this->db->query("SELECT * FROM `user_details` WHERE user_id = $uid");
        $userData =  $userData->result();
        $type_id =  $userData[0]->type_id;
        $inside =  $userData[0]->inside;
        if($type_id == 4 || $type_id == 5 || $type_id == 3){
             //$inside == 1 ||  removed this condition from below
            if($type_id == 4){
                $auid = $userData[0]->admin_id;
            }else{
                $auid = $userData[0]->aadmin;
            }
        }else{
            $auid = $userData[0]->aadmin;
        }
        if($uid == 100183 || $uid ==100166 || $uid == 100136 || $uid == 100193 || $uid == 100163 || $uid == 100184 || $uid == 100162 || $uid == 100176) {
            $auid = 100024;
        }
        if($type_id == 13){
            $auid = $userData[0]->pst_co;
        }
 
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $tptime=$this->Menu_model->get_tptime($uid);
        $tptime = $tptime[0]->tptime;
        $dep_name = $dt[0]->name;
        $setdatebyuser              = $_POST['setdatebyuser'];
        $requestForTodaysTaskPlan   = $_POST['requestForTodaysTaskPlan'];
        
        $taskcnt   = $_POST['taskcnt'];
        $would_you_want   = $_POST['would_you_want'];
        $this->db->query("INSERT INTO `task_plan_for_today`(`user_id`,`admin_id`, `date`, `request_remarks`,`taskcnt`,`would_you_want`) VALUES ('$uid','$auid','$setdatebyuser','$requestForTodaysTaskPlan','$taskcnt','$would_you_want')");
        $this->load->library('session');
        $this->session->set_flashdata('success_message', 'Your request has been successfully sent to the administrator. Please wait for approval.');
         redirect("Menu/TaskPlanner2/".date('Y-m-d'));
    }
    public function RequestForYestTaskPlan(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $setdatebyuser    = $_POST['setdatebyuser'];
        $requestremarks   = $_POST['todaysPendingTaskPlanrem'];
        $oldPendTaskcnt   = $_POST['oldPendTaskcnt'];
        $setdatebyuser = $setdatebyuser.' '.date('H:i:s');
       
        $this->db->query("INSERT INTO `request_old_pend_task`(`user_id`, `req_date`,`taskcnt`, `request_remarks`) VALUES ('$uid','$setdatebyuser','$oldPendTaskcnt','$requestremarks')");
        $this->load->library('session');
        $this->session->set_flashdata('success_message', 'Your request has been successfully sent to the administrator. Please wait for approval.');
         redirect("Menu/TaskPlanner2/".date('Y-m-d'));
    }
    public function TodaysTaskApprovelRequest(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $tptime=$this->Menu_model->get_tptime($uid);
        $tptime = $tptime[0]->tptime;
        $dep_name = $dt[0]->name;
        if(isset($_POST['targetdate'])){
            $adate = $_POST['targetdate'];
        }else{
            $adate = date("Y-m-d");
        }
         $getreqData  =  $this->db->query("SELECT * FROM `task_plan_for_today` WHERE admin_id = $uid and date='$adate'");
         $getreqData =  $getreqData->result();
         if(!empty($user)){
            $this->load->view($dep_name.'/TodaysTaskApprovelRequest',['uid'=>$uid,'user'=>$user,'adate'=>$adate,'getreqData'=>$getreqData]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PendingTaskApprovelRequest(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $tptime=$this->Menu_model->get_tptime($uid);
        $tptime = $tptime[0]->tptime;
        $dep_name = $dt[0]->name;
        if(isset($_POST['targetdate'])){
            $adate = $_POST['targetdate'];
        }else{
            $adate = date("Y-m-d");
        }
         $getreqData  =  $this->db->query("SELECT `request_old_pend_task`.`id` AS tid, `request_old_pend_task`.*, `user_details`.* FROM `request_old_pend_task` LEFT JOIN `user_details` ON `request_old_pend_task`.`user_id` = `user_details`.`user_id` WHERE `user_details`.`aadmin` = '$uid' AND CAST(`request_old_pend_task`.`req_date` AS DATE) = '$adate'");
         $getreqData =  $getreqData->result();
        
         if(!empty($user)){
            $this->load->view($dep_name.'/PendingTaskApprovelRequest',['uid'=>$uid,'user'=>$user,'adate'=>$adate,'getreqData'=>$getreqData]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TodaysTaskapprove($id,$type){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        if($type == 'Approve'){
            $status = "Approved";
            $reamrks = "Approved By ".$user['name'];
            $query =  $this->db->query("UPDATE `task_plan_for_today` SET `approvel_status`='$status',`remarks`='$reamrks' WHERE id = $id");
            redirect("Menu/TodaysTaskApprovelRequest");
        }else{
            redirect('Menu/main');
        }
    }
    public function TodaysPendingTaskapprove($id,$type){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
       
        if($type == 'Approve'){
            $status = 1;
            $reamrks = "Approved By ".$user['name'];
            $query =  $this->db->query("UPDATE `request_old_pend_task` SET `approvel_status`='$status',`approvel_by`='$uid',`approvel_reamrks`='$reamrks' WHERE id = $id");
            redirect("Menu/PendingTaskApprovelRequest");
        }else{
            redirect('Menu/main');
        }
    }
    public function TodaysTaskReject(){
        $rejectid = $_POST['reject'];
        $rejectreamrk = $_POST['rejectreamrk'];
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $status = "Reject";
        $query =  $this->db->query("UPDATE `task_plan_for_today` SET `approvel_status`='$status',`remarks`='$rejectreamrk' WHERE id = $rejectid");
        redirect("Menu/TodaysTaskApprovelRequest");
    }
    public function TodaysPendingsTaskRequestReject(){
        $rejectid = $_POST['reject'];
        $rejectreamrk = $_POST['rejectreamrk'];
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $status = 0;
        $query =  $this->db->query("UPDATE `request_old_pend_task` SET `approvel_status`='$status',`approvel_reamrks`='$rejectreamrk',`approvel_by`='$uid' WHERE id = $rejectid");
        redirect("Menu/PendingTaskApprovelRequest");
    }
    public function ndplan(){
        $uid = $_POST['bdid'];
        $wffo = $_POST['wffo'];
        $nextdate = $_POST['nextdate'];
        $reminder = $_POST['reminder'];
        $this->load->model('Menu_model');
        $this->Menu_model->submit_ndplan($wffo,$nextdate,$reminder,$uid);
        redirect('Menu/NextDayPlanner');
    }
    public function MyDailyReport($tdate){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
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
        $totalt=$this->Menu_model->get_totalt($uid,$tdate);
        $ttdone=$this->Menu_model->get_ttdone($uid,$tdate);
        $ttd=$this->Menu_model->get_totaltd($uid,$tdate);
        $upt=$this->Menu_model->get_unplant($uid,$tdate);
        $tsww=$this->Menu_model->get_tswwork($uid,$tdate);
        $tptask=$this->Menu_model->get_tptask($uid);
        $sc=$this->Menu_model->get_scon($uid,$tdate);
        $barg=$this->Menu_model->get_bargdetail($uid,$tdate);
        $positive=$this->Menu_model->get_positive();
        $vpositive=$this->Menu_model->get_vpositive();
        $bdrequest=$this->Menu_model->bdrequest($uid);
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
            $this->load->view($dep_name.'/MyDailyReport',['ttdone'=>$ttdone,'upt'=>$upt,'bdrequest'=>$bdrequest,'user'=>$user,'fr'=>$fr,'callr'=>$callr,'emailr'=>$emailr,'meetingr'=>$meetingr,'pendingt'=>$pendingt,'totalt'=>$totalt,'patc'=>$patc,'tatc'=>$tatc,'pate'=>$pate,'tate'=>$tate,'patm'=>$patm,'tatm'=>$tatm,'sc'=>$sc,'tptask'=>$tptask,'ttd'=>$ttd,'barg'=>$barg,'uid'=>$uid,'pstc'=>$pstc,'poc'=>$poc,'vpoc'=>$vpoc,'tnos'=>$tnos,'revenue'=>$revenue,'tsww'=>$tsww,'bdc'=>$bdc,'tdate'=>$tdate,'mbdc'=>$mbdc]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TeamDailyReport($tdate){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if($uid=='100103'){$uid=45;}
        if($uid=='100149'){$uid=45;}
        if($uid=='100142'){$uid=2;}
        if(isset($_POST["sdate"])){$tdate=$_POST["sdate"];}else{$tdate=$tdate;}
        if(isset($_POST["bdid"])){$userid=$bdid=$_POST["bdid"];}else{$userid=$uid;}
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $fr=$this->Menu_model->get_freport($userid);
        $bdc=$this->Menu_model->get_bdtcom($userid);
        $mbdc=$this->Menu_model->get_mbdc($userid);
        $atid=1;
        $callr=$this->Menu_model->get_callingr($atid,$userid,$tdate);
        $patc=$this->Menu_model->get_pat($atid,$userid,$tdate);
        $tatc=$this->Menu_model->get_tat($atid,$userid,$tdate);
        $atid=2;
        $emailr=$this->Menu_model->get_callingr($atid,$userid,$tdate);
        $pate=$this->Menu_model->get_pat($atid,$userid,$tdate);
        $tate=$this->Menu_model->get_tat($atid,$userid,$tdate);
        $atid=3;
        $meetingr=$this->Menu_model->get_callingr($atid,$userid,$tdate);
        $patm=$this->Menu_model->get_pat($atid,$userid,$tdate);
        $tatm=$this->Menu_model->get_tat($atid,$userid,$tdate);
        $pendingt=$this->Menu_model->get_pendingt($userid,$tdate);
        $totalt=$this->Menu_model->get_totalt($userid,$tdate);
        $ttdone=$this->Menu_model->get_ttdone($userid,$tdate);
        $ttd=$this->Menu_model->get_totaltd($userid,$tdate);
        $upt=$this->Menu_model->get_unplant($userid,$tdate);
        $tsww=$this->Menu_model->get_tswwork($userid,$tdate);
        $tptask=$this->Menu_model->get_tptask($userid);
        $sc=$this->Menu_model->get_scon($userid,$tdate);
        $barg=$this->Menu_model->get_bargdetail($userid,$tdate);
        $positive=$this->Menu_model->get_positive();
        $vpositive=$this->Menu_model->get_vpositive();
        $bdrequest=$this->Menu_model->bdrequest($userid);
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
            $this->load->view($dep_name.'/TeamDailyReport',['ttdone'=>$ttdone,'upt'=>$upt,'bdrequest'=>$bdrequest,'user'=>$user,'fr'=>$fr,'callr'=>$callr,'emailr'=>$emailr,'meetingr'=>$meetingr,'pendingt'=>$pendingt,'totalt'=>$totalt,'patc'=>$patc,'tatc'=>$tatc,'pate'=>$pate,'tate'=>$tate,'patm'=>$patm,'tatm'=>$tatm,'sc'=>$sc,'tptask'=>$tptask,'ttd'=>$ttd,'barg'=>$barg,'uid'=>$uid,'pstc'=>$pstc,'poc'=>$poc,'vpoc'=>$vpoc,'tnos'=>$tnos,'revenue'=>$revenue,'tsww'=>$tsww,'bdc'=>$bdc,'tdate'=>$tdate,'mbdc'=>$mbdc]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DailyReport(){
        date_default_timezone_set("Asia/Calcutta");
        if(isset($_POST['tdate'])){
        $tdate = $_POST['tdate'];
        }
        else{
            $tdate = date('Y-m-d');
        }
        $tdate="2023-03-23";
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
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
        $totalt=$this->Menu_model->get_totalt($uid,$tdate);
        $ttdone=$this->Menu_model->get_ttdone($uid,$tdate);
        $ttd=$this->Menu_model->get_totaltd($uid,$tdate);
        $upt=$this->Menu_model->get_unplant($uid,$tdate);
        $tsww=$this->Menu_model->get_tswwork($uid,$tdate);
        $tptask=$this->Menu_model->get_tptask($uid);
        $sc=$this->Menu_model->get_scon($uid,$tdate);
        $barg=$this->Menu_model->get_bargdetail($uid,$tdate);
        $positive=$this->Menu_model->get_positive();
        $vpositive=$this->Menu_model->get_vpositive();
        $bdrequest=$this->Menu_model->bdrequest($uid);
        $daym = $this->Menu_model->get_BDdaydbyad($uid,$tdate,1);
        $tnos=0;
        $revenue=0;
        $poc=0;
        $vpoc=0;
        foreach($positive as $po){
            $poc++;
            $iniid = $po->cid_id;
            $tos=$this->Menu_model->get_initbyid($iniid);
            $tpnos +=  (int)$tos[0]->noofschools;
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
            $this->load->view($dep_name.'/DailyReport',['daym'=>$daym,'ttdone'=>$ttdone,'upt'=>$upt,'bdrequest'=>$bdrequest,'user'=>$user,'fr'=>$fr,'callr'=>$callr,'emailr'=>$emailr,'meetingr'=>$meetingr,'pendingt'=>$pendingt,'totalt'=>$totalt,'patc'=>$patc,'tatc'=>$tatc,'pate'=>$pate,'tate'=>$tate,'patm'=>$patm,'tatm'=>$tatm,'sc'=>$sc,'tptask'=>$tptask,'ttd'=>$ttd,'barg'=>$barg,'uid'=>$uid,'pstc'=>$pstc,'poc'=>$poc,'vpoc'=>$vpoc,'tnos'=>$tnos,'revenue'=>$revenue,'tsww'=>$tsww,'bdc'=>$bdc,'tdate'=>$tdate,'mbdc'=>$mbdc]);
        }else{
            redirect('Menu/main');
        }
    }
/*
    public function Dashboard(){
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
         $positveNAP = $this->Menu_model->get_positiveNAP();
        $vpositveNAP = $this->Menu_model->get_vpositiveNAP();
        $cmtd=$this->Menu_model->get_clusterTaskDetails($uid,$tdate);
        $clusterFunnel = $this->Menu_model->get_clusterFunnel($uid);
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
            
            // $this->load->view($dep_name.'/index',['myid'=>$myid,'ttdone'=>$ttdone,'upt'=>$upt,'user'=>$user,'fr'=>$fr,'callr'=>$callr,'emailr'=>$emailr,'meetingr'=>$meetingr,'pendingt'=>$pendingt,'totalt'=>$totalt,'patc'=>$patc,'tatc'=>$tatc,'pate'=>$pate,'tate'=>$tate,'patm'=>$patm,'tatm'=>$tatm,'sc'=>$sc,'tptask'=>$tptask,'ttd'=>$ttd,'barg'=>$barg,'uid'=>$uid,'pstc'=>$pstc,'poc'=>$poc,'vpoc'=>$vpoc,'tnos'=>$tnos,'revenue'=>$revenue,'tsww'=>$tsww,'bdc'=>$bdc,'tdate'=>$tdate,'autotasktimenew'=>$autotasktimenew,'mbdc'=>$mbdc]);
        }else{
            redirect('Menu/main');
        }
    }
*/
public function Dashboard(){
        date_default_timezone_set("Asia/Calcutta");
        if(isset($_POST['tdate'])){
        $tdate = $_POST['tdate'];
        }
        else{
            $tdate = date('Y-m-d');
        }
     
        $this->load->library('session');;

    	$this->load->model('Menu_model');
        
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $myid = $uid;
        if($uyid == 3 || $uyid == 4 || $uyid == 5 || $uyid == 7 || $uyid == 8 || $uyid == 9 || $uyid == 11 || $uyid == 12 || $uyid == 13 || $uyid == 15){
            $user_day = $this->Menu_model->get_daydetail($uid,date("Y-m-d"));
            if(sizeof($user_day) == 0){
                $this->session->set_flashdata('error_message','* Please Start Your Day');
                redirect('Menu/DayManagement');
            } 
        }
        if($uid=='100103'){$uid=45;}
        if($uid=='100149'){$uid=45;}
        if($uid=='100142'){$uid=2;}
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
        
        $positveNAP = $this->Menu_model->get_positiveNAP();
        $vpositveNAP = $this->Menu_model->get_vpositiveNAP();
        $cmtd=$this->Menu_model->get_clusterTaskDetails($uid,$tdate);
        $clusterFunnel = $this->Menu_model->get_clusterFunnel($uid);
        
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
   
        $pendingautotaskcmp = $this->Menu_model->get_PendingAutoTask($uid);
       
       $pendingautotaskcmpcnt = sizeof($pendingautotaskcmp);
    //   echo "12121";exit;
       if($pendingautotaskcmpcnt > 0){
           $this->session->set_flashdata('error_message','Total '. $pendingautotaskcmpcnt . ' Pending Auto Task, First Complete Your Pending Autotask Before Going Task Planner Page');
           redirect('Menu/Dashboard2');
       } 
        if(!empty($user)){
            $this->load->view($dep_name.'/index',['myid'=>$myid,'cmtd'=>$cmtd,'clusterFunnel'=> $clusterFunnel ,'ttdone'=>$ttdone,'upt'=>$upt,'user'=>$user,'fr'=>$fr,'callr'=>$callr,'emailr'=>$emailr,'meetingr'=>$meetingr,'pendingt'=>$pendingt,'totalt'=>$totalt,'patc'=>$patc,'tatc'=>$tatc,'pate'=>$pate,'tate'=>$tate,'patm'=>$patm,'tatm'=>$tatm,'sc'=>$sc,'tptask'=>$tptask,'ttd'=>$ttd,'barg'=>$barg,'uid'=>$uid,'pstc'=>$pstc,'poc'=>$poc,'vpoc'=>$vpoc,'tnos'=>$tnos,'revenue'=>$revenue,'tsww'=>$tsww,'bdc'=>$bdc,'tdate'=>$tdate,'autotasktimenew'=>$autotasktimenew,'mbdc'=>$mbdc]);
        }else{
            redirect('Menu/main');
        }
    }

    public function Dashboard2(){
        date_default_timezone_set("Asia/Calcutta");
        if(isset($_POST['tdate'])){
        $tdate = $_POST['tdate'];
        }
        else{
            $tdate = date('Y-m-d');
        }
        $this->load->model('Menu_model');
        $this->load->library('session');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $myid = $uid;
        if($uyid == 3 || $uyid == 4 || $uyid == 5 || $uyid == 7 || $uyid == 8 || $uyid == 9 || $uyid == 11 || $uyid == 12 || $uyid == 13 || $uyid == 15){
            $user_day = $this->Menu_model->get_daydetail($uid,date("Y-m-d"));
            if(sizeof($user_day) == 0){
                $this->session->set_flashdata('error_message','* Please Start Your Day');
                redirect('Menu/DayManagement');
            } 
        }
       
        if($uid=='100103'){$uid=45;}
        if($uid=='100149'){$uid=45;}
        if($uid=='100142'){$uid=2;}
       
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
        $pendingautotaskcmp = $this->Menu_model->get_totaltPendingAutoTaskdetails($uid);
        $pendingautotaskcmpcnt = sizeof($pendingautotaskcmp);
        if($pendingautotaskcmpcnt > 0){
            $this->session->set_flashdata('error_message','Total '. $pendingautotaskcmpcnt . ' Pending Auto Task, First Complete Your Pending Autotask');
        }   
        if(!empty($user)){
            $this->load->view($dep_name.'/index2',['myid'=>$myid,'ttdone'=>$ttdone,'upt'=>$upt,'user'=>$user,'fr'=>$fr,'callr'=>$callr,'emailr'=>$emailr,'meetingr'=>$meetingr,'pendingt'=>$pendingt,'totalt'=>$totalt,'patc'=>$patc,'tatc'=>$tatc,'pate'=>$pate,'tate'=>$tate,'patm'=>$patm,'tatm'=>$tatm,'sc'=>$sc,'tptask'=>$tptask,'ttd'=>$ttd,'barg'=>$barg,'uid'=>$uid,'pstc'=>$pstc,'poc'=>$poc,'vpoc'=>$vpoc,'tnos'=>$tnos,'revenue'=>$revenue,'tsww'=>$tsww,'bdc'=>$bdc,'tdate'=>$tdate,'autotasktimenew'=>$autotasktimenew,'mbdc'=>$mbdc,'pautotask'=>$pendingautotaskcmp]);
        }else{
            redirect('Menu/main');
        }
    }
    public function Dashboard1(){
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
        $positive=$this->Menu_model->get_positive();
        $vpositive=$this->Menu_model->get_vpositive();
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
            $this->load->view($dep_name.'/index1',['myid'=>$myid,'ttdone'=>$ttdone,'upt'=>$upt,'user'=>$user,'fr'=>$fr,'callr'=>$callr,'emailr'=>$emailr,'meetingr'=>$meetingr,'pendingt'=>$pendingt,'totalt'=>$totalt,'patc'=>$patc,'tatc'=>$tatc,'pate'=>$pate,'tate'=>$tate,'patm'=>$patm,'tatm'=>$tatm,'sc'=>$sc,'tptask'=>$tptask,'ttd'=>$ttd,'barg'=>$barg,'uid'=>$uid,'pstc'=>$pstc,'poc'=>$poc,'vpoc'=>$vpoc,'tnos'=>$tnos,'revenue'=>$revenue,'tsww'=>$tsww,'bdc'=>$bdc,'tdate'=>$tdate,'mbdc'=>$mbdc]);
        }else{
            redirect('Menu/main');
        }
    }
    public function AnnualReviewDetail(){
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
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/AnnualReviewDetail',['user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function AnnualReview(){
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
        $totalt=$this->Menu_model->get_totalt($uid,$tdate);
        $ttdone=$this->Menu_model->get_ttdone($uid,$tdate);
        $ttd=$this->Menu_model->get_totaltd($uid,$tdate);
        $upt=$this->Menu_model->get_unplant($uid,$tdate);
        $tsww=$this->Menu_model->get_tswwork($uid,$tdate);
        $tptask=$this->Menu_model->get_tptask($uid);
        $sc=$this->Menu_model->get_scon($uid,$tdate);
        $barg=$this->Menu_model->get_bargdetail($uid,$tdate);
        $positive=$this->Menu_model->get_positive();
        $vpositive=$this->Menu_model->get_vpositive();
        $bdrequest=$this->Menu_model->bdrequest($uid);
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
            $this->load->view($dep_name.'/AnnualReview',['ttdone'=>$ttdone,'upt'=>$upt,'bdrequest'=>$bdrequest,'user'=>$user,'fr'=>$fr,'callr'=>$callr,'emailr'=>$emailr,'meetingr'=>$meetingr,'pendingt'=>$pendingt,'totalt'=>$totalt,'patc'=>$patc,'tatc'=>$tatc,'pate'=>$pate,'tate'=>$tate,'patm'=>$patm,'tatm'=>$tatm,'sc'=>$sc,'tptask'=>$tptask,'ttd'=>$ttd,'barg'=>$barg,'uid'=>$uid,'pstc'=>$pstc,'poc'=>$poc,'vpoc'=>$vpoc,'tnos'=>$tnos,'revenue'=>$revenue,'tsww'=>$tsww,'bdc'=>$bdc,'tdate'=>$tdate,'mbdc'=>$mbdc]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DownloadAnnualReport($bdid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $annualr1=$this->Menu_model->get_annualr1($bdid);
        $annualr2=$this->Menu_model->get_annualr2($bdid);
        $annualr3=$this->Menu_model->get_annualr3($bdid);
        if(!empty($user)){
            $this->load->view($dep_name.'/DownloadAnnualReport',['uid'=>$uid,'user'=>$user,'annualr1'=>$annualr1,'annualr2'=>$annualr2,'annualr3'=>$annualr3]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDDayDetail($tdate,$code){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_BDdaydbyad($uid,$tdate,$code);
        $this->load->view($dep_name.'/BDDayDetail',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid,'tdate'=>$tdate,'code'=>$code]);
    }
    public function ThemeColor(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $this->load->view($dep_name.'/ThemeColor',['user'=>$user,'uid'=>$uid]);
    }
    public function OntimeLate($uid,$sd,$ed,$code){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $this->load->view($dep_name.'/OntimeLate',['user'=>$user,'uid'=>$uid,'sd'=>$sd,'ed'=>$ed,'code'=>$code]);
    }
    public function DayManagment($tdate){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $this->load->view($dep_name.'/DayManagment',['user'=>$user,'uid'=>$uid,'tdate'=>$tdate]);
    }
    public function PlannedTask($uid,$sd,$ed,$code){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $this->load->view($dep_name.'/PlannedTask',['user'=>$user,'uid'=>$uid,'sd'=>$sd,'ed'=>$ed,'code'=>$code]);
    }
    public function InitiatedTask($uid,$sd,$ed,$code){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $this->load->view($dep_name.'/InitiatedTask',['user'=>$user,'uid'=>$uid,'sd'=>$sd,'ed'=>$ed,'code'=>$code]);
    }
    public function UpdatedTask($uid,$sd,$ed,$code){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $this->load->view($dep_name.'/UpdatedTask',['user'=>$user,'uid'=>$uid,'sd'=>$sd,'ed'=>$ed,'code'=>$code]);
    }
    public function BDDetail($aid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if($uyid ==15){
            $mdata = $this->Menu_model->get_userbySaleCoord($aid);
        }else{
            $mdata = $this->Menu_model->get_userbyaids($aid);
        }
     
        $this->load->view($dep_name.'/BDDetail',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
    }
    public function BDDetail1($aid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_userbyaaid($aid);
        $this->load->view($dep_name.'/BDDetail1',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
    }
    public function TWSWCombination(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TWSWCombination',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function MeetingDetail($code,$uid){
        if($uid =='100147')
        {$uid ='45';}
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        
        if(!empty($user)){
            
            $this->load->view($dep_name.'/MeetingDetail',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function MeetingDetailtest($code,$uid){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/MeetingDetailtest',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDFunnal($aid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        // echo $uyid."==".$uid;
        // die;
        if($uyid ==15){
        $mdata = $this->Menu_model->get_userbyaSCid($aid);
    }else if($uyid ==4){
        $mdata = $this->Menu_model->get_userbyaaid($aid);
    }else{
        $mdata = $this->Menu_model->get_userbyaid($aid);
    }
        
        $this->load->view($dep_name.'/BDFunnal',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
    }
    public function PSTFunnal($aid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_userbypst($aid);
        $this->load->view($dep_name.'/PSTFunnal',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
    }
    public function Notification(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->notify($uid);
        $this->load->view($dep_name.'/Notification',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
    }
    public function ProposalApr(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->proposal_apr($uid);
        $this->load->view($dep_name.'/ProposalApr',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
    }
    public function PSTProposalApr(){
        $user = $this->session->userdata('user');
// print_r($user);exit;
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
       //echo $dep_name;exit;
        $this->load->view($dep_name.'/PSTProposalApr',['user'=>$user,'uid'=>$uid]);
    }
    public function DeleteCMP(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->delete_r($uid);
        $this->load->view($dep_name.'/DeleteCMP',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
    }
    public function RemovePKClient(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->pkclient_r($uid);
        $this->load->view($dep_name.'/RemovePKClient',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
    }
    public function RemoveKClient(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->kclient_r($uid);
        $this->load->view($dep_name.'/RemoveKClient',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
    }
    public function ProposalDetail($tid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_ProposalDetail($tid);
        $this->load->view($dep_name.'/ProposalDetail',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
    }
    public function ToDoList(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $this->load->view($dep_name.'/ToDoList',['user'=>$user,'uid'=>$uid]);
    }
    public function AllProposalDetail(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_AllProposalDetail($uid);
        $this->load->view($dep_name.'/AllProposalDetail',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
    }
    public function AllProposalDetail_PSTTeam(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $this->load->view($dep_name.'/AllProposalDetail_PSTTeam',['user'=>$user,'uid'=>$uid]);
    }
    public function ProposalDetailbydate(){
        if(isset($_POST['sdate'])){
            $sdate = $_POST['sdate'];
            $edate = $_POST['edate'];
            $aprtype = $_POST['aprtype'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
            $aprtype = 1;
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_ProposalDetailbydate($uid,$sd,$ed,$aprtype);
        $this->load->view($dep_name.'/ProposalDetailbydate',['sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed,'user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
    }
    public function ProposalDetailbydate_PSTTeam(){
        if(isset($_POST['sdate'])){
            $sdate = $_POST['sdate'];
            $edate = $_POST['edate'];
            $aprtype = $_POST['aprtype'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
            $aprtype = 1;
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
       
        $this->load->view($dep_name.'/ProposalDetailbydate_PSTTeam',['sdate'=>$sdate,'aprtype'=>$aprtype, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed,'user'=>$user,'uid'=>$uid]);
    }
    public function TotalRequest(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->request_apr();
        $this->load->view($dep_name.'/TotalRequest',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
    }
    public function DCMP(){
        $cid = $_POST['cid'];
        $this->load->model('Menu_model');
        $mdata = $this->Menu_model->delete_cmp($cid);
    }
    public function RCMP(){
        $cid = $_POST['cid'];
        $this->load->model('Menu_model');
        $mdata = $this->Menu_model->rejectd_cmp($cid);
    }
    public function RPKCMP(){
        $cid = $_POST['cid'];
        $this->load->model('Menu_model');
        $mdata = $this->Menu_model->remove_pkcmp($cid);
    }
    public function RKCMP(){
        $cid = $_POST['cid'];
        $this->load->model('Menu_model');
        $mdata = $this->Menu_model->remove_kcmp($cid);
    }
    public function ProApr(){
        $remark=null;
        $aprid = $_POST['aprid'];
        $adid = $_POST['adid'];
        $apr = $_POST['apr'];
        if(isset($_POST['remark'])){$remark = $_POST['remark'];}
        $this->load->model('Menu_model');
        $mdata = $this->Menu_model->Pro_Apr($aprid,$adid,$apr,$remark);
    }
    public function handApr($aprid){
        $admid = $this->input->post('admid');
        $this->load->model('Menu_model');
        $mdata = $this->Menu_model->hand_Apr($aprid,$admid);
        redirect('Menu/handoverapr');
    }
    public function handDelete($aprid){
        $this->load->model('Menu_model');
        $mdata = $this->Menu_model->hand_Delete($aprid);
    }
    public function REQAPR(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uname = $user['name'];
        $id = $_POST['id'];
        $this->load->model('Menu_model');
        $mdata = $this->Menu_model->REQ_APR($id,$uname);
    }
    public function EditWR(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uname = $user['name'];
        $edid = $_POST['edid'];
        $editrem = $_POST['editrem'];
        $this->load->model('Menu_model');
        $mdata = $this->Menu_model->Edit_WR($edid,$uname,$editrem);
    }
    public function readnotify(){
        $id = $_POST['id'];
        $this->load->model('Menu_model');
        $mdata = $this->Menu_model->read_notify($id);
    }
    public function TravelPlan(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TravelPlan',['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TravelExpenses(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TravelExpenses',['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TBMDetail(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TBMDetail',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TBMDetailBD($date){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TBMDetailBD',['uid'=>$uid,'user'=>$user,'date'=>$date]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TMDetail(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TMDetail',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TeamDetail(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TeamDetail',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTStatusTaskD(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTStatusTaskD',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function StatusTaskD(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/StatusTaskD',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function StatusTaskDGroup(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/StatusTaskDGroup',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function StatusTaskPSTSelf(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/StatusTaskPSTSelf',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TeamWork(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
     
        if(!empty($user)){
            $this->load->view($dep_name.'/TeamWork',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TeamWorkpst(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TeamWorkpst',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function MyWork(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/MyWork',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTWork(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTWork',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTFTwork(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTFTwork',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDTeamWork($sd,$ed){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDTeamWork',['uid'=>$uid,'user'=>$user,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTTeamWork($sd,$ed){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTTeamWork',['uid'=>$uid,'user'=>$user,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDTaskDetail($sd,$ed,$bdid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $sdate = new DateTime($sd);
        $edate = new DateTime($ed);
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDTaskDetail',['uid'=>$uid,'user'=>$user,'sd'=>$sd,'ed'=>$ed,'sdate'=>$sdate,'edate'=>$edate,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTSRWork($date){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTSRWork',['uid'=>$uid,'user'=>$user,'date'=>$date]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTCTeamWork($date){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTCTeamWork',['uid'=>$uid,'user'=>$user,'date'=>$date]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDStatusTask($datet){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDStatusTask',['uid'=>$uid,'user'=>$user,'datet'=>$datet]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDStatusTaskGroup($sd,$ed){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDStatusTaskGroup',['uid'=>$uid,'user'=>$user,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDStatusTaskGroupSelf($sd,$ed){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDStatusTaskGroupSelf',['uid'=>$uid,'user'=>$user,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTStatusTask($datet){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTStatusTask',['uid'=>$uid,'user'=>$user,'datet'=>$datet]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDSConversion($datet){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDSConversion',['uid'=>$uid,'user'=>$user,'datet'=>$datet]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FinalBDSC($sd,$ed){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FinalBDSC',['uid'=>$uid,'user'=>$user,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FinalPSTSC($sd,$ed){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FinalPSTSC',['uid'=>$uid,'user'=>$user,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function momdetail(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/momdetail',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTData(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTData',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function AdminData(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/AdminData',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTSRData(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTSRData',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTDataC(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTDataC',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTDataCData(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTDataCData',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function SConversion(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/SConversion',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTSConversion(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTSConversion',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function MySConversion(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/MySConversion',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function AdminWork(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/AdminWork',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function UpsellClient(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/UpsellClient',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function CompanyAllDetail(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/CompanyAllDetail',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function totalcdetail($code){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_vpd($code,$uid);
        $this->load->view($dep_name.'/totalcdetail',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid,'code'=>$code]);
    }
    public function addcont(){
        $cid = $_POST['cid'];
        $cdate = $_POST['cdate'];
        $contactperson = $_POST['contactperson'];
        $designation = $_POST['designation'];
        $phoneno = $_POST['phoneno'];
        $emailid = $_POST['emailid'];
        $primary = $_POST['primary'];
        $this->load->model('Menu_model');
        $cbmid = $this->Menu_model->add_cont($cid, $cdate, $contactperson, $designation, $phoneno, $emailid, $primary);
        redirect('Menu/Dashboard');
    }
    public function setpcontact(){
        $setid = $_POST['setid'];
        $cid = $_POST['cid'];
        $this->load->model('Menu_model');
        $cbmid = $this->Menu_model->get_setccid($setid,$cid);
        redirect('Menu/CompanyDetails/'.$cid);
    }
    public function editpcontact(){
        $id = $_POST['id'];
        $cid = $_POST['cid'];
        $designation = $_POST['designation'];
        $emailid = $_POST['emailid'];
        $this->load->model('Menu_model');
        $cbmid = $this->Menu_model->get_editccid($id,$designation,$emailid);
        redirect('Menu/CompanyDetails/'.$cid);
    }
    public function updatecompany(){
        $state = $_POST['state'];
        $city = $_POST['city'];
        $cid = $_POST['cid'];
        $address = $_POST['address'];
        $website = $_POST['website'];
        $budget = $_POST['budget'];
        $partnertype = $_POST['partnertype'];
        $this->load->model('Menu_model');
        $cbmid = $this->Menu_model->get_ucompany($state,$city,$cid,$address,$website,$partnertype,$budget);
        redirect('Menu/CompanyDetails/'.$cid);
    }
    public function cbmeeting(){
        $bcytpe='';$bcid=0;$mlocation='';$piorl='';$bstate='';$bcity='';
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $bcytpe = $_POST['bcytpe'];
        if($bcytpe=='From Funnel'){
           $bcid = $_POST['bcid'];
        }
        else{
            $bstate = $_POST['bstate'];
            $bcity = $_POST['bcity'];
        }
        $piorl =  $_POST['piorl'];
        if($piorl=='Later'){
            $bmdate =  $_POST['bmdate'];
        }
        else{
            date_default_timezone_set("Asia/Kolkata");
            $bmdate=date('Y-m-d H:i:s');
        }
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $cbmid = $this->Menu_model->create_bmeeting($uid,$bcytpe,$bcid,$bmdate,$bstate,$bcity);
        redirect('Menu/Dashboard');
    }
    public function rpmstart(){
        $uid = $_POST['uid'];
        $smid = $_POST['smid'];
        $startm = $_POST['startm'];
        $company_name = $_POST['company_name'];
        $cphoto = $_FILES['cphoto']['name'];
        $uploadPath = 'uploads/day/';
        $this->load->model('Menu_model');
        $this->load->library('session');
        $flink = $this->Menu_model->cphotofile($cphoto, $uploadPath);
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        $bscid = $_POST['bscid'];
        $cphoto = $flink;
        $cbmid = $this->Menu_model->start_rpm($uid,$startm,$company_name,$cphoto,$lat,$lng,$smid,$bscid);
        $this->session->set_flashdata('success_message','Meeting Started SuccessFully !');
        redirect('Menu/Dashboard');
    }
    public function rpmclose(){
        $this->load->model('Menu_model');
        $this->load->library('session');
        $priority="";$closem="";$caddress="";$cpname="";$cpdes="";$cpno="";$cpemail="";
        $uid    = $_POST['uid'];
        $cmid   = $_POST['cmid'];
        $bmcid  = $_POST['bmcid'];
        $bmccid = $_POST['bmccid'];
        $bminid = $_POST['bminid'];
        $bmtid  = $_POST['bmtid'];
        if(isset($_POST['priority'])){$priority = $_POST['priority'];}
        $closem = $_POST['closem'];
        $type   = $_POST['type'];
        $caddress = $_POST['caddress'];
        $cpname = $_POST['cpname'];
        $cpdes  = $_POST['cpdes'];
        $cpno   = $_POST['cpno'];
        $cpemail = $_POST['cpemail'];
        $lat    = $_POST['lat'];
        $lng    = $_POST['lng'];
        $letmeetingsremarks = $_POST['letmeetingsremarks'];
        $updateStatus = $_POST['updateCompanyStatus'];
        if(isset($_POST['company_as'])){
            $company_as = $_POST['company_as'];
        }else{
            $company_as = '';
        }
        if(isset($_POST['company_descri'])){
            $company_descri = $_POST['company_descri'];
        }else{
            $company_descri = '';
        }
        if(isset($_POST['potentional_client'])){
            $potentional_client = $_POST['potentional_client'];
        }else{
            $potentional_client = '';
        }
        
       
        $cbmid = $this->Menu_model->close_rpm($uid,$closem,$caddress,$cpname,$cpdes,$cpno,$cpemail,$lat,$lng,$type,$priority,$cmid,$bmcid,$bmccid,$bminid,$bmtid,$letmeetingsremarks,$updateStatus,$company_as,$company_descri,$potentional_client);
        $this->session->set_flashdata('success_message','Meeting Close SuccessFully ! Please Update Your Lead');
        redirect('Menu/Dashboard');
    }
    public function TDetail(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TDetail',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TaskAStatus(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TaskAStatus',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PlanTaskAStatus(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PlanTaskAStatus',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function LiveVisit(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/LiveVisit',['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TBMD($code,$bdid,$sdate,$edate){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_tbmd($code,$bdid,$uid,$sd,$ed);
    
        // echo $str = $this->db->last_query(); 
        if(!empty($user)){
            $this->load->view($dep_name.'/TBMD',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TBMD_PST($code,$bdid,$sdate,$edate){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_tbmdPST($code,$bdid,$uid,$sd,$ed);
        if(!empty($user)){
            $this->load->view($dep_name.'/TBMD_PST',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TBMD_PST_Data($code,$bdid,$sdate,$edate){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_tbmdPST($code,$bdid,$uid,$sd,$ed);
        if(!empty($user)){
            $this->load->view($dep_name.'/TBMD_PST',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TBMDFRP($code,$sd,$ed,$bdname){
        $sdate = $sd;
        $edate = $ed;
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_tbmd(5,$bdname,$bdname,$sd,$ed);
        if(!empty($user)){
                $this->load->view($dep_name.'/TBMDF',['code'=>$code,'uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TBMDFRP_PST($code,$sd,$ed,$bdname){
        if(isset($_POST['sdate']) && isset($_POST['edate'])){
            $sdate = $_POST['sdate'];
            $edate = $_POST['edate'];
            $bdname = $_POST['bdname'];
        }else{
            $sdate = $sd;
            $edate = $ed;
        }
      
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_tbmdPST($code,$bdname,$bdname,$sd,$ed);
      
        if(!empty($user)){
            $this->load->view($dep_name.'/TBMDFRP_PST',['code'=>$code,'uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TBMDF(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        $bdname = $_POST['bdname'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
            $bdname = $uid;
        }
        $code = 5;
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_tbmd($code,$bdname,$uid,$sd,$ed);
        if(!empty($user)){
            $this->load->view($dep_name.'/TBMDF',['code'=>$code,'uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDNotWorkDD(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        if(isset($_POST['bdid'])){
        $bdid = $_POST['bdid'];}
        else{$bdid = $uid;}
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata=$this->Menu_model->get_bdtcom($bdid);
        if(!empty($user)){
            $this->load->view($dep_name.'/BDNotWorkDD',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RPTHISYEAR(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/RPTHISYEAR',['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDWORKBWDBYTC(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDWORKBWDBYTC',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTWorkOnRPCompanies(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTWorkOnRPCompanies',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTWorkOnRPALLCompanies(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTWorkOnRPALLCompanies',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTWorkOnRPPACompanies(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTWorkOnRPPACompanies',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ExpectedPSTSchool($pstid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/ExpectedPSTSchool',['uid'=>$uid,'user'=>$user,'pstid'=>$pstid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ExpectedSchool(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{$sdate = date('Y-m-d');
            $edate = date('Y-m-d');}
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/ExpectedSchool',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function REVIEWBWDATE(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/REVIEWBWDATE',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function NOREVIEWCOMP(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/NOREVIEWCOMP',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function CONVERSIONBWDATE(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/CONVERSIONBWDATE',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDNOWORKBWDBYTC(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDNOWORKBWDBYTC',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDWorkBWD(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        if(isset($_POST['bdid'])){
        $bdid = $_POST['bdid'];}
        else{$bdid = $uid;}
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata=$this->Menu_model->get_bdtcom($bdid);
        if(!empty($user)){
            $this->load->view($dep_name.'/BDWorkBWD',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTCConversion(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        $pstid = $_POST['pstname'];
        $stat = $_POST['stat'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
            $pstid = $uid;
            $stat = 0;
            $pstid = 0;
        }
        if($pstid==0){$ab=0;}else{$ab=1;}
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_pstccon($stat,$uid,$pstid,$sd,$ed,$ab);
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTCConversion',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function GPReviewReport($sdate,$edate,$pstid,$bdid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_reviewr($pstid,$bdid,$sd,$ed);
        if(!empty($user)){
            $this->load->view($dep_name.'/ReviewReport',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDReviewReport($sd,$ed,$bdid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $sdate = $sd;
        $edate = $ed;
        $pstid = $bdid;
        $bdid = $bdid;
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_reviewr($pstid,$bdid,$sd,$ed);
        if(!empty($user)){
            $this->load->view($dep_name.'/BDReviewReport',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ReviewReport(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
            $sdate = $_POST['sdate'];
            $edate = $_POST['edate'];
            $pstid = $_POST['pstname'];
            $bdid = $_POST['bdid'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
            $pstid=0;
            $bdid=0;
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if($uyid ==15){
            $mdata = $this->Menu_model->get_reviewrSCoo($pstid,$bdid,$sd,$ed);
        }else{
            $mdata = $this->Menu_model->get_reviewr($pstid,$bdid,$sd,$ed);
        }
        
        if(!empty($user)){
            $this->load->view($dep_name.'/ReviewReport',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDReviewReportSummary(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
            $sdate = $_POST['sdate'];
            $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_bdsummryreviewr($uid,$sd,$ed);
        if(!empty($user)){
            $this->load->view($dep_name.'/BDReviewReportSummary',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDReviewReportSummarys(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
            $sdate = $_POST['sdate'];
            $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        if($uid==0){$ab=0;}else{$ab=1;}
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_bdsummryreviewrs($uid,$sd,$ed,$ab);
        if(!empty($user)){
            $this->load->view($dep_name.'/BDReviewReportSummary',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTReviewReport($sd,$ed,$bdid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $sdate = $sd;
        $edate = $ed;
        $pstid = $bdid;
        $bdid = $bdid;
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_reviewr($pstid,$bdid,$sd,$ed);
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTReviewReport',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTReviewReportSummary(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
            $sdate = $_POST['sdate'];
            $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_pstsummryreviewr($uid,$sd,$ed);
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTReviewReportSummary',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ReviewDetail($rid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_reviewdetail($rid);
        if(!empty($user)){
            $this->load->view($dep_name.'/ReviewDetail',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function LatestReviewDetail($bdid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/LatestReviewDetail',['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function AfterReviewDetail($rid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_reviewdetail($rid);
        if(!empty($user)){
            $this->load->view($dep_name.'/AfterReviewDetail',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function AdminCConversion(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        $pstid = $_POST['pstname'];
        $stat = $_POST['stat'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
            $pstid = $uid;
            $stat = 0;
            $pstid = 0;
        }
        if($pstid==0){$ab=0;}else{$ab=1;}
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_pstccon($stat,$uid,$pstid,$sd,$ed,$ab);
        if(!empty($user)){
            $this->load->view($dep_name.'/AdminCConversion',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTAllReview(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        $pstid = $_POST['pstname'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
            $pstid = $uid;
            $pstid = 0;
        }
        if($pstid==0){$ab=0;}else{$ab=1;}
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_pstallreview($uid,$pstid,$sd,$ed,$ab);
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTAllReview',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTAllReviewData(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        $pstid = $_POST['pstname'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
            $pstid = $uid;
            $pstid = 0;
        }
        if($pstid==0){$ab=0;}else{$ab=1;}
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_pstallreviewData($pstid,$sd,$ed,$ab);
   
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTAllReviewData',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RPMeetDetail($atid,$uid,$tdate){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_TMbyaid($atid,$uid,$tdate);
        if(!empty($user)){
            $this->load->view($dep_name.'/RPMeetDetail',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'tdate'=>$tdate]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTFTTaskDetail($code,$bdid,$atid,$tdate,$ab){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTFTTaskDetail',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'tdate'=>$tdate,'code'=>$code,'ab'=>$ab,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function NotworkCompanyBDPST(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/NotworkCompanyBDPST',['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function workdoneCompanyBDPST(){
        if(isset($_POST['sdate'])){
            $sdate = $_POST['sdate'];
            $edate = $_POST['edate'];
            }
            else{
                $sdate = date('Y-m-d');
                $edate = date('Y-m-d');
            }
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/workdoneCompanyBDPST',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate]);
        }else{
            redirect('Menu/main');
        }
    }
    public function workbutactionnobd(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/workbutactionnobd',['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function workbutactionnopst(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/workbutactionnopst',['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function workOnClusterOnBDFunnels(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/workOnClusterOnBDFunnels',['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ATaskDetail($code,$bdid,$atid,$sd,$ed,$ab){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/ATaskDetail',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'sd'=>$sd,'ed'=>$ed,'code'=>$code,'ab'=>$ab,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ATaskDetailTeam($code,$bdid,$atid,$sd,$ed,$ab){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/ATaskDetailTeam',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'sd'=>$sd,'ed'=>$ed,'code'=>$code,'ab'=>$ab,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function APSTTaskDetail($code,$bdid,$atid,$sd,$ed,$ab){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/APSTTaskDetail',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'sd'=>$sd,'ed'=>$ed,'code'=>$code,'ab'=>$ab,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function AMyTaskDetail($code,$bdid,$atid,$sd,$ed,$ab){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/AMyTaskDetail',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'sd'=>$sd,'ed'=>$ed,'code'=>$code,'ab'=>$ab,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDAlertDetail($code){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $mdata=$this->Menu_model->get_bdalertpoint($uid,$code);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDAlertDetail',['uid'=>$uid,'user'=>$user,'code'=>$code,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function AlertDetail($code,$date){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $mdata=$this->Menu_model->get_alertpoint($uid,$code,$date);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/AlertDetail',['uid'=>$uid,'user'=>$user,'date'=>$date,'code'=>$code,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PlannerReport(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        $bdid = $_POST['bdid'];
        $stid = $_POST['stid'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
            $bdid=0;
            $stid=0;
        }
        $sd=$sdate;
        $ed=$edate;
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/plannerreport',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed,'bdid'=>$bdid,'stid'=>$stid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PlannerAReport(){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        $bdid = $_POST['bdid'];
        $acid = $_POST['acid'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
            $bdid=0;
            $acid=0;
        }
        $sd=$sdate;
        $ed=$edate;
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/plannerareport',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed,'bdid'=>$bdid,'acid'=>$acid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTDataDetail($code,$bdid,$atid,$tdate,$ab){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTDataDetail',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'tdate'=>$tdate,'tardate'=>$tdate,'code'=>$code,'ab'=>$ab,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTDataCDetail($bdid,$tdate,$ab){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTDataCDetail',['uid'=>$uid,'user'=>$user,'tdate'=>$tdate,'tardate'=>$tdate,'ab'=>$ab,'bdid'=>$bdid,'statuscode'=>$ab]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTDataCDetailData($bdid,$tdate,$ab){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTDataCDetailData',['uid'=>$uid,'user'=>$user,'tdate'=>$tdate,'tardate'=>$tdate,'ab'=>$ab,'bdid'=>$bdid,'statuscode'=>$ab]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTDataCDetail1($bdid,$tdate,$code1,$code2){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTDataCDetail1',['uid'=>$uid,'user'=>$user,'tdate'=>$tdate,'tardate'=>$tdate,'ab'=>$ab,'bdid'=>$bdid,'statuscode1'=>$code1,'statuscode2'=>$code2]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTDataCDetailChange($bdid,$tdate,$ab){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTDataCDetailChange',['uid'=>$uid,'user'=>$user,'tdate'=>$tdate,'ab'=>$ab,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function AdminDataCDetail($bdid,$tdate,$ab){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/AdminDataCDetail',['uid'=>$uid,'user'=>$user,'tdate'=>$tdate,'ab'=>$ab,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TaskDetail($code,$bdid,$atid,$tdate){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TaskDetail',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'code'=>$code,'tdate'=>$tdate]);
        }else{
            redirect('Menu/main');
        }
    }
    public function StatusTask($bdid,$tdate,$atid,$ab){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/statustask',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'tdate'=>$tdate,'ab'=>$ab,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function StatusTaskSelf($bdid,$tdate,$atid,$ab){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/StatusTaskSelf',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'tdate'=>$tdate,'ab'=>$ab,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function StatusTaskGroup($bdid,$sd,$ed,$atid,$ab){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/statustaskGroup',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'sd'=>$sd,'ed'=>$ed,'ab'=>$ab,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function StatusTaskGroupByTeam($bdid,$sd,$ed,$atid,$ab){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/StatusTaskGroupByTeam',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'sd'=>$sd,'ed'=>$ed,'ab'=>$ab,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function StatusTaskGroupSelfPST($bdid,$sd,$ed,$atid,$ab){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/StatusTaskGroupSelfPST',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'sd'=>$sd,'ed'=>$ed,'ab'=>$ab,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function StatusTaskPST($bdid,$tdate,$atid,$ab){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/StatusTaskPST',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'tdate'=>$tdate,'ab'=>$ab,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PlanStatusTask($bdid,$tdate,$atid,$ab){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PlanStatusTask',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'tdate'=>$tdate,'ab'=>$ab,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TotalRPMeeting(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_totalrpmeet($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/TotalRPMeeting',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RPPriority(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_totalrpmeet($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/RPPriority',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RPCPriority(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_totalrpmeet($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/RPCPriority',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DayManagement(){
        date_default_timezone_set("Asia/Calcutta");
        $tdate=date('Y-m-d');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_daydetail($uid,$tdate);
        $yesterday = date('Y-m-d', strtotime('-1 day', strtotime($tdate)));
        $yestdata = $this->Menu_model->get_Yestdaydetail($uid,$yesterday);
        if($mdata)
        {$st = $mdata[0]->ustart;
         $ct = $mdata[0]->uclose;
            if($st!=''){$do=1;}
            if($ct!=''){$do=2;}
        }else{$do=0;}
        // $yesterday_date = date("Y-m-d", strtotime("-1 day"));
        $currentDate = date("Y-m-d");
        $tomorrowDate = date("Y-m-d", strtotime($currentDate . ' +1 day'));
        $query  =  $this->db->query("SELECT * FROM `autotask_time` WHERE user_id =$uid and date='$tomorrowDate'");
        $gettoAutoTaskTime = $query->result();
        $query1  =  $this->db->query("SELECT * FROM `autotask_time` WHERE user_id =$uid and date='$currentDate'");
        $gecurAutoTaskTime = $query1->result();
           
        if(!empty($user)){
            // $pendingtaskcmp = $this->Menu_model->get_PendingTaskForToday($uid);
            
            //     //  $pendingautotaskcmpcnt = $pendingtaskcmp[0]->totalrecords;  
            //  //   echo "12121";exit;
            //     if($pendingautotaskcmpcnt > 0){
            //         $this->session->set_flashdata('error_message','Total '. $pendingautotaskcmpcnt . ' Pending Auto Task, First Complete Your Pending Autotask Before Going Task Planner Page');
            //         redirect('Menu/Dashboard');
            //     } 
            $this->load->view($dep_name.'/DayManagement',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'tdate'=>$tdate,'uid'=>$uid,'do'=>$do,'yestdata'=>$yestdata,'gettoAutoTaskTime'=>$gettoAutoTaskTime,'uyid'=>$uyid,'gecurAutoTaskTime'=>$gecurAutoTaskTime,'daycheck'=>'start']);
        }else{
            redirect('Menu/main');
        }
    }
    public function DayStartCheck(){
        date_default_timezone_set("Asia/Calcutta");
        $tdate=date('Y-m-d');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $udetail = $this->Menu_model->get_userbyid($uid);
        if($uyid ==15){
            $admid = $udetail[0]->user_id;
        }else{
            $admid = $udetail[0]->admin_id;
        }
       
        $mdata = $this->Menu_model->get_BDdaystart($admid,$tdate);
        if(!empty($user)){
            $this->load->view($dep_name.'/DayStartCheck',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function MeetingCheck(){
        date_default_timezone_set("Asia/Calcutta");
        $tdate=date('Y-m-d',strtotime("-1 days"));
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_MeetingCheck($uid,$tdate);
        if(!empty($user)){
            $this->load->view($dep_name.'/MeetingCheck',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TravalCheck(){
        date_default_timezone_set("Asia/Calcutta");
        $tdate="2023-05-19";
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_MeetingCheck($uid,$tdate);
        if(!empty($user)){
            $this->load->view($dep_name.'/TravalCheck',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TaskCheck(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TaskCheck',['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DayCloseCheck(){
        date_default_timezone_set("Asia/Calcutta");
        $tdate=date('Y-m-d',strtotime("-1 days"));
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_BDdayclose($uid,$tdate);
        if(!empty($user)){
            $this->load->view($dep_name.'/DayCloseCheck',['uid'=>$uid,'user'=>$user,'tdate'=>$tdate,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DailyTeamCoordination(){
        date_default_timezone_set("Asia/Calcutta");
        $tdate=date('Y-m-d H:i:s');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_daytc($uid);
        $l = sizeof($mdata);
        if($l==0){$do=1;}else{$do=2;}
        if(!empty($user)){
            $this->load->view($dep_name.'/DailyTeamCoordination',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'do'=>$do]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RosterCalling(){
        date_default_timezone_set("Asia/Calcutta");
        $tdate=date('Y-m-d H:i:s');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_daytc($uid);
        $l = sizeof($mdata);
        if($l==0){$do=1;}else{$do=2;}
        if(!empty($user)){
            $this->load->view($dep_name.'/RosterCalling',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'do'=>$do]);
        }else{
            redirect('Menu/main');
        }
    }
    public function EditReview(){
        date_default_timezone_set("Asia/Calcutta");
        $tdate=date('Y-m-d H:i:s');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_reviewdetailbyuid($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/EditReview.php',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TargerSetting(){
        date_default_timezone_set("Asia/Calcutta");
        $tdate=date('Y-m-d H:i:s');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TargerSetting.php',['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function CmpTarget(){
        date_default_timezone_set("Asia/Calcutta");
        $tdate=date('Y-m-d H:i:s');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/CmpTarget.php',['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function AllReviewPlaing(){
        date_default_timezone_set("Asia/Calcutta");
        $tdate=date('Y-m-d H:i:s');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/AllReviewPlaing.php',['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function GoalSetting(){
        date_default_timezone_set("Asia/Calcutta");
        $tdate=date('Y-m-d H:i:s');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_daytc($uid);
        $l = sizeof($mdata);
        if($l==0){$do=1;}else{$do=2;}
        if(!empty($user)){
            $this->load->view($dep_name.'/GoalSetting.php',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'do'=>$do]);
        }else{
            redirect('Menu/main');
        }
    }
    public function AllPSTReviewPlaing(){
        date_default_timezone_set("Asia/Calcutta");
        $tdate=date('Y-m-d H:i:s');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        // $mdata = $this->Menu_model->get_daytc($uid);
        // $l = sizeof($mdata);
        // if($l==0){$do=1;}else{$do=2;}
        if(!empty($user)){
            $this->load->view($dep_name.'/AllPSTReviewPlaing',['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function AllPSTReviewac(){
        date_default_timezone_set("Asia/Calcutta");
        $tdate=date('Y-m-d H:i:s');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_daytc($uid);
        $l = sizeof($mdata);
        if($l==0){$do=1;}else{$do=2;}
        if(!empty($user)){
            $this->load->view($dep_name.'/AllReviewac.php',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'do'=>$do]);
        }else{
            redirect('Menu/main');
        }
    }
    public function AllReviewac(){
        date_default_timezone_set("Asia/Calcutta");
        $tdate=date('Y-m-d H:i:s');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_daytc($uid);
        $l = sizeof($mdata);
        if($l==0){$do=1;}else{$do=2;}
        if(!empty($user)){
            $this->load->view($dep_name.'/AllReviewac.php',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'do'=>$do]);
        }else{
            redirect('Menu/main');
        }
    }
    public function test1(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_testc();
        $this->load->view($dep_name.'/test1',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
    }
    public function test2(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $this->Menu_model->get_testrp();
        $this->load->view($dep_name.'/test2',['uid'=>$uid,'user'=>$user]);
    }
    public function test3(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $this->Menu_model->get_testtc();
        $this->load->view($dep_name.'/test3',['uid'=>$uid,'user'=>$user]);
    }
    public function test4(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $this->Menu_model->get_testtfu();
        $this->load->view($dep_name.'/test4',['uid'=>$uid,'user'=>$user]);
    }
    public function test5(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $this->Menu_model->get_testaltf();
        $this->load->view($dep_name.'/test5',['uid'=>$uid,'user'=>$user]);
    }
    public function test6(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $this->Menu_model->get_testexbdmom();
    }
    public function test7(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_test7();
    }
    // public function test8(){
    //     $user = $this->session->userdata('user');
    //     $data['user'] = $user;
    //     $uid = $user['user_id'];
    //     $uyid =  $user['type_id'];
    //     $this->load->model('Menu_model');
    //     $dt=$this->Menu_model->get_utype($uyid);
    //     $dep_name = $dt[0]->name;
    //     $mdata = $this->Menu_model->get_test8();
    // }
    public function rpmmom(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_bmmombyu($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/rpmmom',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function uprpmmom(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $tblid = $_POST['tblid'];
        $mom = $_POST['mom'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $id = $this->Menu_model->set_uprpmmom($uid,$tblid,$mom);
        redirect('Menu/rpmmom');
    }
    public function assignpst(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_uapstc($uid);
        $alluser = $this->Menu_model->get_user();
        if(!empty($user)){
            $this->load->view($dep_name.'/assignpst',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'alluser'=>$alluser]);
        }else{
            redirect('Menu/main');
        }
    }
    public function rpcheckbybdpst(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_rppstassign($uid);
        $alluser = $this->Menu_model->get_user();
        if(!empty($user)){
            $this->load->view($dep_name.'/rpcheckbybdpst',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'alluser'=>$alluser]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TaskReport($atid){
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TaskReport',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'atid'=>$atid,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    public function StatusConversion($uid,$tdate){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $this->load->model('Menu_model');
        $uyid =  $user['type_id'];
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_scon($uid,$tdate);
        $this->load->view($dep_name.'/Conversion',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'tdate'=>$tdate]);
    }
    public function Meeting(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata=$this->Menu_model->get_meeting();
        if(!empty($user)){
            $this->load->view($dep_name.'/Meeting',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HandoverDetail(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata=$this->Menu_model->get_handover($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/handoverdetail',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ProgramLogs($cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata=$this->Menu_model->get_handoverlog($cid);
        if(!empty($user)){
            $this->load->view($dep_name.'/programlogs',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ChangePST(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata=$this->Menu_model->get_pstbyaid($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/changepst',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PMTFTOBD(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if($uyid == 15){
            $mdata=$this->Menu_model->get_userbySaleCoord($uid);
        }else if($uyid == 13){
            $mdata=$this->Menu_model->get_userbyAadminid($uid);
        }else{
            $mdata=$this->Menu_model->get_userbyaids($uid);
        }
      
        if(!empty($user)){
            $this->load->view($dep_name.'/PMTFTOBD',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDTOBDCTF(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata=$this->Menu_model->get_userbyaid($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/BDTOBDCTF',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function spddetail($cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $spd=$this->Menu_model->get_spdbypc($cid);
        $this->load->view($dep_name.'/spddetail', ['uid'=>$uid,'user'=>$user,'spd'=>$spd]);
    }
    public function ZipDownload($cid){
        $this->load->model('Menu_model');
        $cpc=$this->Menu_model->get_clientbyid($cid);
        $projcode = $cpc[0]->projectcode;
        $wgdata=$this->Menu_model->get_wgbytid($projcode);
        $this->load->library('zip');
          foreach($wgdata as $w)
          {
              $fpath=$w->filepath;
              $url = "https://stemoppapp.in/".$fpath;
              echo $filePath = $this->Menu_model->fetchDataFromOtherServer($url);
              $this->zip->read_file($url);
          }
          $this->zip->download(time().'.zip');
    }
    public function ReportDownload($cid){
        $this->load->model('Menu_model');
        $cpc=$this->Menu_model->get_clientbyid($cid);
        $projcode = $cpc[0]->projectcode;
        $report=$this->Menu_model->get_report($projcode);
        $this->load->library('zip');
          foreach($report as $r)
          {
              $fpath=$r->filepath;
              $this->zip->read_file($fpath);
          }
        $this->zip->download(time().'.zip');
    }
    public function BDRBox(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDRBox',['user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function Handovertoinsr($pid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/Handovertoinsr',['pid'=>$pid,'user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DesignProcess($pid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/DesignProcess',['pid'=>$pid,'user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BackdropPrinting($pid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BackdropPrinting',['pid'=>$pid,'user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function UManualPrinting($pid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/UManualPrinting',['pid'=>$pid,'user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PurchaseDetail($pid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PurchaseDetail',['pid'=>$pid,'user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function Preparing($pid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/Preparing',['pid'=>$pid,'user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function Packing($pid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/Packing',['pid'=>$pid,'user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TManualPrinting($pid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TManualPrinting',['pid'=>$pid,'user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HandoverForm($cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata=$this->Menu_model->get_clientbyid($cid);
        $mdc=$this->Menu_model->get_clientacbyid($cid);
        $spdc=$this->Menu_model->get_schoolbycid($cid);
        $budget=$this->Menu_model->get_budget($cid);
        $md = $mdata[0];
        $mdc = $mdc[0];
        if(!empty($user)){
            $this->load->view($dep_name.'/HandoverForm',['budget'=>$budget,'spdc'=>$spdc,'cid'=>$cid,'md'=>$md,'mdc'=>$mdc,'user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDRequestCBox(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDRequestCBox',['user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function OfflineDemoBox(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/OfflineDemoBox',['user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function SchoolIdentification($tid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/SchoolIdentification',['tid'=>$tid,'user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDRVisitSchool($tid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDRVisitSchool',['tid'=>$tid,'user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDRVisitdetail($tid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDRVisitdetail',['tid'=>$tid,'user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDRCalldetail($sid,$tid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDRCalldetail',['sid'=>$sid,'tid'=>$tid,'user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDRResearchDetail($sid,$tid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDRResearchDetail',['sid'=>$sid,'tid'=>$tid,'user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDRCallSchool($tid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDRCallSchool',['tid'=>$tid,'user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDRResearchSchool($tid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDRResearchSchool',['tid'=>$tid,'user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDCreatedRequest($tid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDCreatedRequest',['tid'=>$tid,'user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDRAssignPIA($tid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDRAssignPIA',['tid'=>$tid,'user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function OnlineDemoBox(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/OnlineDemoBox',['user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDRequestBox(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDRequestBox',['user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDRBox2($rtype){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDRBox2',['rtype'=>$rtype,'user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ProgramBOX($cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_Programbycid($uid,$cid);
        if(!empty($user)){
            $this->load->view($dep_name.'/ProgramBOX',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid,'cid'=>$cid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PendingTaskBox(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_Program($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/PendingTaskBox',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ANPNTaskBox(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_Program($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/ANPNTaskBox',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function AYPNTaskBox(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_Program($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/AYPNTaskBox',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function AYPYTaskBox(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_Program($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/AYPYTaskBox',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ActionTaskBox($ac){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_Program($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/ActionTaskBox',['ac'=>$ac,'user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function StatusTaskBox($st){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_Program($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/StatusTaskBox',['st'=>$st,'user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PartnerTaskBox($pt){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_Program($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/PartnerTaskBox',['pt'=>$pt,'user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TimeSlotTaskBox($ts){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_Program($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/TimeSlotTaskBox',['ts'=>$ts,'user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ActionConversionBox($st1,$st2){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_Program($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/ActionConversionBox',['st1'=>$st1,'st2'=>$st2,'user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function MyTeamBox(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/MyTeamBox',['user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function NewHandover(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_NewHandover($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/NewHandover',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RBDOP(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/RBDOP',['user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RBDOPDetail($rid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/RBDOPDetail',['user'=>$user,'uid'=>$uid,'rid'=>$rid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RDOPEN(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/RDOPEN',['user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RDMDetail($chid,$sid,$tid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/RDMDetail',['user'=>$user,'uid'=>$uid,'sid'=>$sid,'tid'=>$tid,'chid'=>$chid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HandBIND(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HandBIND',['user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HandBINDDetail($cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HandBINDDetail',['user'=>$user,'uid'=>$uid,'cid'=>$cid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HJoinCall($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HJoinCall',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HDesignProcesss($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HDesignProcesss',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HBackdropPrinting($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HBackdropPrinting',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HUserManual($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HUserManual',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HTrainingManual($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HTrainingManual',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HPurchase($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HPurchase',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HPackingA($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HPackingA',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HPackingB($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HPackingB',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HPackingC($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HPackingC',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HPackingMS($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HPackingMS',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HDelivery($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HDelivery',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HReceiveI($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HReceiveI',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HDeliver($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HDeliver',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HeWay($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HeWay',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HLogistic($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HLogistic',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HDispatchA($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HDispatchA',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HDispatchB($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HDispatchB',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HDispatchC($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HDispatchC',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HDispatchMS($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HDispatchMS',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HSRCall($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HSRCall',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HSISCall($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HSISCall',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HSIVisit($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HSIVisit',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HSIReport($code,$cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HSIReport',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HSDVDetail($code,$cid,$tid,$sid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HSDVDetail',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code,'tid'=>$tid,'sid'=>$sid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HSIVDetail($code,$cid,$tid,$sid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/HSIVDetail',['user'=>$user,'uid'=>$uid,'cid'=>$cid,'code'=>$code,'tid'=>$tid,'sid'=>$sid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function SchoolBOX($cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_Schoolbycid($cid);
        if(!empty($user)){
            $this->load->view($dep_name.'/SchoolBOX',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function SPDTASKBOX($sid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_SPDTask($sid);
        if(!empty($user)){
            $this->load->view($dep_name.'/SPDTASKBOX',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function schooldetail($sid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $slog=$this->Menu_model->get_schoollogs($sid);
        $spd=$this->Menu_model->get_school_detail($sid);
        $dtc=$this->Menu_model->get_school_contact($sid);
        $wgd=$this->Menu_model->get_wgdata($sid);
        $ostatus=$this->Menu_model->get_ostatus();
        if(!empty($user)){
            $this->load->view($dep_name.'/schooldetail',['user'=>$user,'uid'=>$uid,'spd'=>$spd,'dataa'=>$dtc, 'dataa'=>$dtc, 'wgd'=>$wgd,'slog'=>$slog, 'status'=>$ostatus]);
        }else{
            redirect('Menu/main');
        }
    }
    public function SPDVISITTASKBOX($sid,$tid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_SPDTask($sid);
        $task = $this->Menu_model->get_taskbyid($tid);
        if(!empty($user)){
            $this->load->view($dep_name.'/SPDVISITTASKBOX',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid,'task'=>$task,'sid'=>$sid,'tid'=>$tid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function SPDPANTASK($sid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_SPDTask($sid);
        if(!empty($user)){
            $this->load->view($dep_name.'/SPDPANTASK',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ProgramDetail(){
        $code=7;
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_handover_detail($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/ProgramDetail',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ProgramDetailinPST(){
        $code=7;
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        
        if(!empty($user)){
            $this->load->view($dep_name.'/ProgramDetailinPST',['user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function HandoverCompany(){
        $code=7;
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if($code==0){
            $mdata=$this->Menu_model->get_bdtcom($uid);
        }else{
            $mdata=$this->Menu_model->get_bdcombystatus($uid,$code);
        }
        // echo $str = $this->db->last_query();
        if(!empty($user)){
            $this->load->view($dep_name.'/HandoverCompany',['user'=>$user,'mdata'=>$mdata,'code'=>$code,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function artworkaprdone(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $client=$this->Menu_model->get_handover($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/artworkaprdone',['user'=>$user,'client'=>$client,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function artworkaprdoneinPST(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/artworkaprdoneinPST',['user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function artworkapr(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $client=$this->Menu_model->get_handover($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/artworkapr',['user'=>$user,'client'=>$client,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function artworkaprinPST(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        
        if(!empty($user)){
            $this->load->view($dep_name.'/artworkaprinPST',['user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function backdroparbd(){
        $by='BD';
        $apr= $this->input->post('apr');
        $rej= $this->input->post('rej');
        $this->load->model('Menu_model');
        if(isset($_FILES['filname']['name'])) {
           $filname = $_FILES['filname']['name'];
           $count = sizeof($filname);
        }else{$count=0;$filname=0;}
        $remark= $this->input->post('remark');
        $rem='';
        if(empty($apr)){
            $rem=$remark[0];
            $id=$rej;
            $val='Reject';
        }else{
            $id=$apr;
            $val=3;
        }
   
        $client=$this->Menu_model->get_clientbyid($id);
        $cid=$id;
        $this->Menu_model->backdrop_ar($id, $val, $rem,$by,$cid,$filname,$count);
        redirect('Menu/artworkapr');
    }
    public function companies($code){
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
        if($uyid == 2){
              $mdata=$this->Menu_model->getBdWiseCompList($uid,$code);
        }else{
            if($uyid == 9){
                  $mdata=$this->Menu_model->get_bdtcom($uid);
            }
            else{
              $mdata=$this->Menu_model->get_bdcombystatus($uid,$code);   
            } 
        }
        
        if(!empty($user)){
            $this->load->view($dep_name.'/CreatedCompanies',['user'=>$user,'mdata'=>$mdata,'code'=>$code,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function pstnotassignc(){
        $code=30;
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
        if(!empty($user)){
            $this->load->view($dep_name.'/pstnotassignc',['user'=>$user,'mdata'=>$mdata,'code'=>$code,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TotalCompanies(){
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
        $mdata=$this->Menu_model->get_allbdtcom($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/TotalCompanies',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function CallDetail($sid,$tid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $spd= $this->Menu_model->get_spdbyid($sid);
        $pcode = $spd[0]->project_code;
        $programd1=$this->Menu_model->get_spddetail1($sid);
        $programd2=$this->Menu_model->get_spddetail2($sid);
        $programd3=$this->Menu_model->get_spddetail3($sid);
        $programd4=$this->Menu_model->get_spddetail4($sid);
        $sdetail=$this->Menu_model->get_sdetail($sid);
        if(!empty($user)){
            $this->load->view($dep_name.'/CallDetail',['user'=>$user,'uid'=>$uid,'tid'=>$tid,'sid'=>$sid,'sdetail'=>$sdetail,'programd4'=>$programd4,'programd3'=>$programd3,'programd2'=>$programd2,'programd1'=>$programd1,'spd'=>$spd]);
        }else{
            redirect('Menu/main');
        }
    }
    public function UtilisationDetail($sid,$tid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $spd= $this->Menu_model->get_spdbyid($sid);
        $pcode = $spd[0]->project_code;
        $programd1=$this->Menu_model->get_spddetail1($sid);
        $programd2=$this->Menu_model->get_spddetail2($sid);
        $programd3=$this->Menu_model->get_spddetail3($sid);
        $programd4=$this->Menu_model->get_spddetail4($sid);
        $sdetail=$this->Menu_model->get_sdetail($sid);
        $wgd=$this->Menu_model->get_wgdatabytid($tid);
        if(!empty($user)){
            $this->load->view($dep_name.'/UtilisationDetail',['wgd'=>$wgd,'user'=>$user,'uid'=>$uid,'tid'=>$tid,'sid'=>$sid,'sdetail'=>$sdetail,'programd4'=>$programd4,'programd3'=>$programd3,'programd2'=>$programd2,'programd1'=>$programd1,'spd'=>$spd]);
        }else{
            redirect('Menu/main');
        }
    }
    public function addurwag(){
        $que=$this->input->post('que');
        $rat1=$this->input->post('rat1');
        $urtid=$this->input->post('urtid');
        $tid = $this->input->post('tid');
        $remark=$this->input->post('remark');
        $this->load->model('Menu_model');
        $id=$this->Menu_model->add_wgurdata($urtid,$tid,$remark,$que,$rat1);
        redirect('Menu/Dashboard');
    }
    public function PotentialPartner($cid,$code){
        $this->load->model('Menu_model');
        $this->Menu_model->Potential_Partner($cid);
        redirect('Menu/pstnotassignc/'.$code);
    }
    public function NonPotentialPartner($cid,$code){
        $this->load->model('Menu_model');
        $this->Menu_model->Non_Potential_Partner($cid);
        redirect('Menu/pstnotassignc/'.$code);
    }
    public function PotentialPartnerpst($cid,$code){
        $this->load->model('Menu_model');
        $this->Menu_model->Potential_Partnerpst($cid);
        redirect('Menu/pcompanies/'.$code);
    }
    public function nonPotentialPartnerpst($cid,$code){
        $this->load->model('Menu_model');
        $this->Menu_model->nonPotential_Partnerpst($cid);
        redirect('Menu/pcompanies/'.$code);
    }
    public function FYff($cid,$code){
        $this->load->model('Menu_model');
        $this->Menu_model->FY_ff($cid);
        redirect('Menu/pcompanies/'.$code);
    }
    public function QTRff($cid,$code){
        $this->load->model('Menu_model');
        $this->Menu_model->QTR_ff($cid);
        redirect('Menu/pcompanies/'.$code);
    }
    public function OppTaskDetail($type){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata=$this->Menu_model->get_opptask($uid,$type);
        if(!empty($user)){
            $this->load->view($dep_name.'/OppTaskDetail',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ZipDownloadbytid($tid){
        $this->load->model('Menu_model');
        $wgdata=$this->Menu_model->get_wgbyttid($tid);
        $this->load->library('zip');
          foreach($wgdata as $w)
          {
              $sp = "https://stemoppapp.in/";
              $fpath=$sp.$w->filepath;
              $this->zip->read_file($fpath);
          }
        $this->zip->download(time().'.zip');
    }
    public function pstcompanies($code){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if($uid=='100149'){$uid=45;}
        if($uid=='100103'){$uid=45;}
        if($uid=='100142'){$uid=2;}
        if($code==0){
            $mdata=$this->Menu_model->get_bdtcom($uid);
        }else{
            $mdata=$this->Menu_model->get_pstcombystatus($uid,$code);
        }
        if(!empty($user)){
            $this->load->view($dep_name.'/pstcompanies',['user'=>$user,'mdata'=>$mdata,'code'=>$code,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function AfterPSTTaskOnC(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $apst = $_POST['pst'];
        }
        else{
            $sdate = date('Y-m-d');
            $apst=$uid;
        }
        $sd=$sdate;
        $sdate = new DateTime($sdate);
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/afterpsttaskonc',['apst'=>$apst,'user'=>$user,'uid'=>$uid,'sdate'=>$sdate,'sd'=>$sd]);
        }else{
            redirect('Menu/main');
        }
    }
    public function creatert(){
        $rtdatet=$_POST['rtdatet'];
        $tasktype=$_POST['tasktype'];
        $bdid=$_POST['bdid'];
        $mlink=$_POST['meetinglink'];
        $pstid=$_POST['pstid'];
        $this->load->model('Menu_model');
        $this->Menu_model->pstreview($rtdatet,$tasktype,$bdid,$mlink,$pstid);
        redirect('Menu/Dashboard');
    }
    public function dremark(){
        $codeid=$_POST['codeid'];
        $bdid=$_POST['bdid'];
        $pstuid=$_POST['pstuid'];
        $cid=$_POST['cid'];
        $dremark=$_POST['dremark'];
        $this->load->model('Menu_model');
        $this->Menu_model->add_dremark($cid,$pstuid,$dremark);
        redirect('Menu/bdcompanies/'.$codeid.'/'.$bdid);
    }
    public function set_kc(){
        $cid=$_POST['skcid'];
        $kcdate=$_POST['kcdate'];
        $kcremark=$_POST['kcremark'];
        $this->load->model('Menu_model');
        $this->Menu_model->set_kcomp($cid,$kcdate,$kcremark);
        redirect('Menu/pcompanies/0');
    }
    public function rset_kc(){
        $cid=$_POST['rskcid'];
        $rsrremark=$_POST['rsrremark'];
        $this->load->model('Menu_model');
        $this->Menu_model->rset_kc($cid,$rsrremark);
        redirect('Menu/pcompanies/0');
    }
    public function set_kcc(){
        $cid=$_POST['spkcid'];
        $kcdate=$_POST['kccdate'];
        $kcremark=$_POST['kccremark'];
        $this->load->model('Menu_model');
        $this->Menu_model->set_kcc($cid,$kcdate,$kcremark);
        redirect('Menu/pcompanies/0');
    }
    public function rset_kcc(){
        $cid=$_POST['rspkcid'];
        $rsprremark=$_POST['rsprremark'];
        $this->load->model('Menu_model');
        $this->Menu_model->rset_kcc($cid,$rsprremark);
        redirect('Menu/pcompanies/0');
    }
    public function csbchange(){
        $cid=$_POST['cid'];
        $sno=$_POST['sno'];
        $code=$_POST['code'];
        $budget=$_POST['budget'];
        $this->load->model('Menu_model');
        $this->Menu_model->add_csbchange($cid,$sno,$budget);
        redirect('Menu/totalcdetail/'.$code);
    }
    public function rremarkpnp(){
        $bdid=$_POST['bdid'];
        $codeid=$_POST['codeid'];
        $cid=$_POST['cid'];
        $remark=$_POST['remark'];
        $this->load->model('Menu_model');
        $this->Menu_model->add_rremarkpnp($cid,$remark);
        redirect('Menu/bdcompanies/'.$codeid.'/'.$bdid);
    }
    public function rremark(){
        $pstuid=$_POST['pstuid'];
        $ntaction=$_POST['ntaction'];
        $ntppose=$_POST['ntppose'];
        $ntdate=$_POST['ntdate'];
        $bdid=$_POST['bdid'];
        $codeid=$_POST['codeid'];
        $cid=$_POST['cid'];
        $pstuid=$_POST['pstuid'];
        $remark=$_POST['remark'];
        $this->load->model('Menu_model');
        $this->Menu_model->add_rremark($cid,$bdid,$remark,$ntdate,$ntaction,$ntppose,$pstuid);
        redirect('Menu/bdcompanies/'.$codeid.'/'.$bdid);
    }
    public function uprremark(){
        $rid=$_POST['rid'];
        $potential=$_POST['potential'];
        $otherremark=$_POST['otherremark'];
        $ans1=$_POST['ans1'];
        $ans2=$_POST['ans2'];
        $ans3=$_POST['ans3'];
        $csrbudget=$_POST['csrbudget'];
        $bdscholl=$_POST['bdscholl'];
        $this->load->model('Menu_model');
        $this->Menu_model->up_rremark($rid,$potential,$otherremark,$ans1,$ans2,$ans3,$csrbudget,$bdscholl);
        redirect('Menu/EditReview/');
    }
    public function DailyTarget(){
        $date=$_POST['date1'];
        $dep=$_POST['dep1'];
        $user=$_POST['user1'];
        $task=$_POST['task1'];
        $remark=$_POST['remark1'];
        $this->load->model('Menu_model');
        $this->Menu_model->Daily_Target($date,$dep,$user,$task,$remark);
        redirect('Menu/ToDoList/');
    }
    public function WeeklyObjectives(){
        $date=$_POST['date2'];
        $dep=$_POST['dep2'];
        echo $user=$_POST['user2'];
        $task=$_POST['task2'];
        $remark=$_POST['remark2'];
        $this->load->model('Menu_model');
        $this->Menu_model->Weekly_Objectives($date,$dep,$user,$task,$remark);
        redirect('Menu/ToDoList/');
    }
    public function rtaskc(){
        $rid=$_POST['rid'];
        $pstuid=$_POST['pstuid'];
        $ntaction=$_POST['ntaction'];
        $ntdate=$_POST['ntdate'];
        $bdid=$_POST['bduid'];
        $inid=$_POST['cid'];
        $remark=$_POST['remark'];
        $exsid=$_POST['exsid'];
        $exdate=$_POST['exdate'];
        $rtype = $_POST['rtype'];
        $taskupdate = $_POST['taskupdate'];
        $this->load->model('Menu_model');
        $this->Menu_model->all_rremark($rid,$inid,$bdid,$remark,$ntdate,$ntaction,$pstuid,$exsid,$exdate,$rtype,$taskupdate);
        redirect('Menu/AllReviewPlaing/');
    }
    public function bdrtaskc(){
        $rid=$_POST['rid'];
        $pstuid=$_POST['pstuid'];
        $ntaction=$_POST['ntaction'];
        $ntdate=$_POST['ntdate'];
        $bdid=$_POST['bduid'];
        $inid=$_POST['cid'];
        $remark=$_POST['remark'];
        $exsid=$_POST['exsid'];
        $exdate=$_POST['exdate'];
        $rtype = $_POST['rtype'];
        $potential = $_POST['potential'];
        $ans1 = $_POST['ans1'];
        $ans2 = $_POST['ans2'];
        $ans3 = $_POST['ans3'];
        $ans4 = $_POST['ans4'];
        $csrbudget = $_POST['csrbudget'];
        $bdscholl = $_POST['bdscholl'];
        $requeststatus = $_POST['requeststatus'];
        $taskupdate = "NO";
        $deletef = $_POST['deletef'];
        $patnertype = $_POST['patnertype'];
        $topspender = $_POST['topspender'];
        $keyclient = $_POST['keyclient'];
        $pkeyclient = $_POST['pkeyclient'];
        $priorityclient = $_POST['priorityclient'];
        $upsellclient = $_POST['upsellclient'];
        $focusyclient = $_POST['focusyclient'];
        $travelcluster = $_POST['travelcluster'];
        $cluster_id = $_POST['cluster_id'];
        $review_time = $_POST['review_time'];
        $this->load->model('Menu_model');
        $this->load->library('session');

        dd($_POST);
       
        if($rtype == 'Roaster'){
            $this->Menu_model->all_bdrremark($deletef,$patnertype,$topspender,$keyclient,$pkeyclient,$priorityclient,$upsellclient,$focusyclient,$rid,$inid,$bdid,$remark,$ntdate,$ntaction,$pstuid,$exsid,$exdate,$rtype,$taskupdate,$potential,$ans1,$ans2,$ans3,$ans4,$requeststatus,$csrbudget,$bdscholl,$travelcluster,$cluster_id);
            $this->session->set_flashdata('success_message','Review Done SuccessFully !');
            redirect('Menu/AllReviewPlaing/');
        }
        if($review_time == 'First Time'){
            $this->Menu_model->all_bdrremark($deletef,$patnertype,$topspender,$keyclient,$pkeyclient,$priorityclient,$upsellclient,$focusyclient,$rid,$inid,$bdid,$remark,$ntdate,$ntaction,$pstuid,$exsid,$exdate,$rtype,$taskupdate,$potential,$ans1,$ans2,$ans3,$ans4,$requeststatus,$csrbudget,$bdscholl,$travelcluster,$cluster_id);
            $this->session->set_flashdata('success_message','Review Done SuccessFully !');
            redirect('Menu/AllReviewPlaing/');
        }
        if($review_time == 'Many Time'){
            $ex_status_id   = $_POST['exsid'];
            $exdate         = $_POST['exdate'];
            $ntaction       = $_POST['ntaction'];
            $ntppose        = $_POST['ntppose'];
            $ntdate         = $_POST['ntdate'];
            $sdate = date("Y-m-d H:i:s");
            $data = array(
                'sdatet'                  => $sdate,
                'user_id'                 => $pstuid,
                'bdid'                    => $bdid,
                'remark'                  => $remark,
                'inid'                    => $inid,
                'how_many_task'           => $this->input->post('how_many_task'),
                'frequency_of_the_task'   => $this->input->post('frequency_of_the_task'),
                'type_of_task'            => $this->input->post('type_of_task'),
                'rp_meeting_done'         => $this->input->post('rp_meeting_done'),
                'mom_done'                => $this->input->post('mom_done'),
                'social_networking_done'  => $this->input->post('social_networking_done'),
                'category_right'          => $this->input->post('category_right'),
                'slct_category'           => $this->input->post('slct_category'),
                'current_status_right'    => $this->input->post('current_status_right'),
                'many_times_barge_meeting'=> $this->input->post('many_times_barge_meeting'),
                'research_prospecting'    => $this->input->post('research_prospecting'),
                'base_or_travel_location' => $this->input->post('base_or_travel_location'),
                'partner_type_right'            => $this->input->post('partner_type_right'),
                'partner_type'            => $this->input->post('slct_partner_type'),
                'suppert'                 => $this->input->post('intervention_or_suppert'),
                'rtype'                   => $this->input->post('rtype'),
                'ex_status_id'            => $this->input->post('exsid'),
                'exdate'                  => $this->input->post('exdate')
            );
            
           
            $this->Menu_model->InsterManyTimeReview($rid,$inid,$pstuid,$bdid,$remark,$ntdate,$ntaction,$rtype,$taskupdate,$data);
            $this->session->set_flashdata('success_message','Review Done SuccessFully !');
            redirect('Menu/AllReviewPlaing/');
        }
       
    }
    public function tsetting(){
        $bdid=$_POST['bdid'];
        $inid=$_POST['inid'];
        $exstatus=$_POST['exsid'];
        $exdate=$_POST['exdate'];
        $this->load->model('Menu_model');
        $this->Menu_model->tset_ting($bdid,$inid,$exstatus,$exdate);
        redirect('Menu/TargerSetting/');
    }
    public function pstrtaskc(){
        $rid=$_POST['rid'];
        $pstuid=$_POST['pstuid'];
        $ntaction=$_POST['ntaction'];
        $ntdate=$_POST['ntdate'];
        $bdid=$_POST['bduid'];
        $inid=$_POST['cid'];
        $taskfor=$_POST['taskfor'];
        $remark=$_POST['remark'];
        $exsid=$_POST['exsid'];
        $exdate=$_POST['exdate'];
        $rtype = $_POST['rtype'];
        $potential = $_POST['potential'];
        $ans1 = $_POST['ans1'];
        $ans2 = $_POST['ans2'];
        $ans3 = $_POST['ans3'];
        $ans4 = $_POST['ans4'];
        $requeststatus = $_POST['requeststatus'];
        $taskupdate = $_POST['taskupdate'];
        $nschool = $_POST['nschool'];
        $nrvenue = $_POST['nrvenue'];
        $deletef = $_POST['deletef'];
        $patnertype = $_POST['patnertype'];
        $topspender = $_POST['topspender'];
        $keyclient = $_POST['keyclient'];
        $pkeyclient = $_POST['pkeyclient'];
        $priorityclient = $_POST['priorityclient'];
        $upsellclient = $_POST['upsellclient'];
        $focusyclient = $_POST['focusyclient'];
        $this->load->model('Menu_model');
        $this->Menu_model->all_pstrremark($deletef,$patnertype,$topspender,$keyclient,$pkeyclient,$priorityclient,$upsellclient,$focusyclient,$rid,$inid,$bdid,$remark,$ntdate,$ntaction,$pstuid,$exsid,$exdate,$rtype,$taskupdate,$ans1,$ans2,$ans3,$ans4,$requeststatus,$nschool,$nrvenue,$potential,$taskfor);
        redirect('Menu/AllReviewPlaing/');
    }
    public function rpsttaskc(){
        $rid=$_POST['rid'];
        $pstuid=$_POST['pstuid'];
        $ntaction=$_POST['ntaction'];
        $ntdate=$_POST['ntdate'];
        $bdid=$_POST['bduid'];
        $inid=$_POST['cid'];
        $remark=$_POST['remark'];
        $exsid=$_POST['exsid'];
        $exdate=$_POST['exdate'];
        $rtype = $_POST['rtype'];
        $taskupdate = $_POST['taskupdate'];
        $this->load->model('Menu_model');
        $this->Menu_model->all_rremark($rid,$inid,$bdid,$remark,$ntdate,$ntaction,$pstuid,$exsid,$exdate,$rtype,$taskupdate);
        redirect('Menu/AllPSTReviewPlaing/');
    }
    public function alreply($tid,$msg,$code,$uid){
        $this->load->model('Menu_model');
        $this->Menu_model->set_alreply($tid,$msg,$code,$uid);
        redirect('Menu/AlertReply/'.$code);
    }
    public function SetGoalSetting(){
        $rrrid=$_POST['rrrid'];
        $gsuid=$_POST['gsuid'];
        $gsbdid=$_POST['gsbdid'];
        $targetdt=$_POST['targetdt'];
        $tcall=$_POST['tcall'];
        $email=$_POST['email'];
        $praposal=$_POST['praposal'];
        $outmeeting=$_POST['outmeeting'];
        $meeting=$_POST['meeting'];
        $rpmeeting=$_POST['rpmeeting'];
        $research=$_POST['research'];
        $positivec=$_POST['positivec'];
        $vpositivec=$_POST['vpositivec'];
        $clouserc=$_POST['clouserc'];
        $noofschool=$_POST['noofschool'];
        $gsremark=$_POST['gsremark'];
        $this->load->model('Menu_model');
        $this->Menu_model->Goal_Setting($rrrid, $gsuid, $gsbdid, $targetdt, $tcall, $email, $praposal, $outmeeting, $meeting, $rpmeeting, $research, $positivec, $vpositivec, $clouserc, $noofschool, $gsremark);
        redirect('Menu/AllReviewPlaing/');
    }
    public function editcmpbybd(){
        $city='';$state='';$address='';$website='';$partnerType_id='';$budget='';$top_spender='';$upsell_client='';$focus_funnel='';
        $cid=$_POST['cid'];
        $state=$_POST['state'];
        $city=$_POST['city'];
        $address=$_POST['address'];
        $website=$_POST['website'];
        $partnerType_id=$_POST['partnerType_id'];
        $budget=$_POST['budget'];
        $top_spender=$_POST['top_spender'];
        $this->load->model('Menu_model');
        $this->Menu_model->edit_cmpbybd($cid,$state,$city,$address,$website,$partnerType_id,$budget,$top_spender);
        redirect('Menu/CompanyDetails/'.$cid);
    }
    public function editcmp(){
        $city='';$state='';$address='';$website='';$top_spender='';$upsell_client='';$focus_funnel='';
        $cid=$_POST['cid'];
        $state=$_POST['state'];
        $city=$_POST['city'];
        $address=$_POST['address'];
        $website=$_POST['website'];
        $codeid=$_POST['ecodeid'];
        $bdid=$_POST['ebdid'];
        $top_spender=$_POST['top_spender'];
        $upsell_client=$_POST['upsell_client'];
        $focus_funnel=$_POST['focus_funnel'];
        $this->load->model('Menu_model');
        $this->Menu_model->edit_cmp($cid,$state,$city,$address,$website,$top_spender,$upsell_client,$focus_funnel);
        redirect('Menu/bdcompanies/'.$codeid.'/'.$bdid);
    }
    public function handoverapr(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $client=$this->Menu_model->get_handoverforapr();
        $bdid=$this->Menu_model->get_userbyaid($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/handoverapr',['user'=>$user,'client'=>$client,'uid'=>$uid,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function bdcompanies($code,$bdid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if($code==0){
            $mdata=$this->Menu_model->get_bdtcom($bdid);
        }else{
            $mdata=$this->Menu_model->get_bdcombystatus($bdid,$code);
        }
        if(!empty($user)){
            $this->load->view($dep_name.'/CreatedBDCompanies',['user'=>$user,'mdata'=>$mdata,'code'=>$code,'uid'=>$uid,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function CommonCompaniesStatus($code,$bdid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
      
        $mdata=$this->Menu_model->get_CommonCompanies($bdid,$code);
      
        if(!empty($user)){
            $this->load->view($dep_name.'/CommonCompanies',['user'=>$user,'mdata'=>$mdata,'code'=>$code,'uid'=>$uid,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PSTbdcompanies($code,$bdid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTbdcompanies',['user'=>$user,'mdata'=>$mdata,'code'=>$code,'uid'=>$uid,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function CreatedPSTCompanies($code,$bdid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if($code==0){
            $mdata=$this->Menu_model->get_psttcom($bdid);
        }else{
            $mdata=$this->Menu_model->get_pstcombyst($bdid,$code);
        }
        if(!empty($user)){
            $this->load->view($dep_name.'/CreatedPSTCompanies',['user'=>$user,'mdata'=>$mdata,'code'=>$code,'uid'=>$uid,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function CategoryBDC($code,$bdid,$categories){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
   
        $mdata=$this->Menu_model->get_bdcombystatuscat($bdid,$code,$categories);
        if(!empty($user)){
            $this->load->view($dep_name.'/CategoryBDC',['user'=>$user,'mdata'=>$mdata,'code'=>$code,'uid'=>$uid,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ActionReviewDetail($aid,$sid,$bdid,$fdate,$rid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata=$this->Menu_model->get_actionlogs($sid,$aid,$fdate,$bdid);
        if(!empty($user)){
            $this->load->view($dep_name.'/ActionReviewDetail',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid,'bdid'=>$bdid,'rid'=>$rid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function pstassignc($uid,$tdate){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata=$this->Menu_model->get_pstwomf($uid,$tdate);
        if(!empty($user)){
            $this->load->view($dep_name.'/pstassignc',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function AlertReply($code){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/AlertReply',['user'=>$user,'code'=>$code,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDRequestSummary($code){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata=$this->Menu_model->get_bdrsummry($uid,$code);
        if(!empty($user)){
            $this->load->view($dep_name.'/BDRequestSummary',['code'=>$code,'user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function bdrequestlogs($rid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $bdrlogs=$this->Menu_model->get_bdrlogdetail($rid);
        if(!empty($user)){
            $this->load->view($dep_name.'/bdrequestlogs',['user'=>$user,'bdrlogs'=>$bdrlogs,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TBDRequest($code){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata=$this->Menu_model->get_bdrequest($uid,$code);
        if(!empty($user)){
            $this->load->view($dep_name.'/TBDRequest',['code'=>$code,'user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TotalBDRequest($code){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata=$this->Menu_model->get_bdrequest($uid,$code);
        if(!empty($user)){
            $this->load->view($dep_name.'/TotalBDRequest',['code'=>$code,'user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TotalBDRequestinPST($code){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata=$this->Menu_model->get_bdrequest_PSTTEAM($uid,$code);
        if(!empty($user)){
            $this->load->view($dep_name.'/TotalBDRequest',['code'=>$code,'user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function pcompanies($code){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        
        if(isset($_POST['submit'])){
            $commoncompanies = $_POST['commoncompanies'];   // meetings or topspender
            $commonwith = $_POST['commonwith'];             // bd, pst, both
            $topspender = $_POST['topspender'];             // yes, no
            
            if($commoncompanies =='meetings'){
                $mdata=$this->Menu_model->get_ComCompanies($uid,$commonwith,$commoncompanies);
            }
            if($commoncompanies =='topspender'){
                $mdata=$this->Menu_model->get_ComCompanies($uid,$topspender,$commoncompanies);
            }
        }else{
            if($code==0){
                $mdata=$this->Menu_model->get_pbdtcom($uid);
            }else{
                $mdata=$this->Menu_model->get_pbdcombystatus($uid,$code);
            }
            $commoncompanies = '';   // meetings or topspender
            $commonwith = '';             // bd, pst, both
            $topspender = '';
        }
        if(!empty($user)){
            $this->load->view($dep_name.'/CreatedCompanies',['user'=>$user,'mdata'=>$mdata,'code'=>$code,'uid'=>$uid,'commoncompanies'=>$commoncompanies,'commonwith'=>$commonwith,'topspender'=>$topspender]);
        }else{
            redirect('Menu/main');
        }
    }
    public function bdeff($tdate,$s){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata=$this->Menu_model->get_bdeffida($uid,$tdate,$s);
        if(!empty($user)){
            $this->load->view($dep_name.'/bdeff',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function psteff($tdate,$s){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata=$this->Menu_model->get_bdeffida($uid,$tdate,$s);
        if(!empty($user)){
            $this->load->view($dep_name.'/psteff',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function cpst(){
        $topst = $_POST['topst'];
        $cid = $_POST['cid'];
        $fopst = $_POST['fopst'];
        $this->load->model('Menu_model');
        $this->Menu_model->get_cpst($fopst,$topst,$cid);
        redirect('Menu/changepst');
    }
    public function cbdtf(){
        $topst = $_POST['topst'];
        $cid = $_POST['cid'];
        $fopst = $_POST['fopst'];
        $this->load->model('Menu_model');
        $this->Menu_model->get_cbdtf($fopst,$topst,$cid);
        redirect('Menu/PMTFTOBD');
    }
    public function rpmeetreport(){
        if(isset($_POST['sdate']) && isset($_POST['edate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/rpmeetreport',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RoasterCallingReport(){
        if(isset($_POST['sdate']) && isset($_POST['edate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $alluser=$this->Menu_model->get_user();
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/roastercallingreport',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'alluser'=>$alluser]);
        }else{
            redirect('Menu/main');
        }
    }
    public function getremark(){
        $sid= $this->input->post('sid');
        $this->load->model('Menu_model');
        $da = '';
        $remark=$this->Menu_model->get_remarkbys($sid);
        echo  $data = '<option value="">Select Remark</option>';
        foreach($remark as $rm){
             echo  $data = '<option value='.$rm->id.'>'.$rm->name.'</option>';
        }
    }
    public function getcmpbycmp(){
        $bycmp= $this->input->post('bycmp');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_cdbyinid($bycmp);
        echo '<option value="">Select Comapny</option>';
        foreach($cmp as $cmp){
             echo  $data = '<option value='.$cmp->inid.'>'.$cmp->compname.'</option>';
        }
    }
    public function getinidtostatus(){
        $inid= $this->input->post('inid');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_inidtostatus($inid);?>
        <input type="hidden" name="ntstatus" value="<?=$cmp[0]->cstatus?>">
        <?php
    }
    public function getcmpbycategory(){
        $category= $this->input->post('category');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_cmpbycategory($category,$uid);
        foreach($cmp as $cmp){
             echo  $data = '<option value='.$cmp->inid.'>'.$cmp->compname.'</option>';
        }
    }
    public function getcmpbycategory12(){
        $statusfiltercardCat = $this->input->post('statusfiltercardCat');
        $category= $this->input->post('category');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_cmpbycategory12($category,$statusfiltercardCat,$uid);
        foreach($cmp as $cmp){
             echo  $data = '<option value='.$cmp->inid.'>'.$cmp->compname.'</option>';
        }
    }
    public function getcmpbycategory13(){
        $taskActionbyusercatcat = $this->input->post('taskActionbyusercatcat');
        $statusfiltercardCat = $this->input->post('statusfiltercardCat');
        $category= $this->input->post('category');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_cmpbycategory13($category,$statusfiltercardCat,$taskActionbyusercatcat,$uid);
        foreach($cmp as $cmp){
             echo  $data = '<option value='.$cmp->inid.'>'.$cmp->compname.'</option>';
        }
    }
    public function getcmpbycategory14(){
        $taskPurposebyusercat = $this->input->post('taskPurposebyusercat');
        $taskActionbyusercatcat = $this->input->post('taskActionbyusercatcat');
        $statusfiltercardCat = $this->input->post('statusfiltercardCat');
        $category= $this->input->post('category');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_cmpbycategory14($category,$statusfiltercardCat,$taskActionbyusercatcat,$taskPurposebyusercat,$uid);
        foreach($cmp as $cmp){
             echo  $data = '<option value='.$cmp->inid.'>'.$cmp->compname.'</option>';
        }
    }
    public function getcmpbynwbwd(){
        $uid= $this->input->post('uid');
        $sid= $this->input->post('sid');
        // $plandate = $this->input->post('plandate');
        $radioval = $this->input->post('radioval');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_cmpbynwbwd($uid,$sid,$radioval);
        echo '<option value="">Select Comapny</option>';
        foreach($cmp as $cmp){
             echo  $data = '<option value='.$cmp->inid.'>'.$cmp->compname.'</option>';
        }
    }
    public function getcmpbypreplandate(){
        $uid= $this->input->post('uid');
        $plandate = $this->input->post('plandate');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_cmpbypreplandate($uid,$plandate);
        echo '<option value="">Select Comapny</option>';
        foreach($cmp as $cmp){
             echo  $data = '<option value='.$cmp->inid.'>'.$cmp->compname.'</option>';
        }
    }
    //get company by review
    public function getcmpbyreview(){
        $uid = $this->input->post('uid');
        $plandate= $this->input->post('plandate');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_cmpbyreview($uid,$plandate);
        echo '<option value="">Select Comapny</option>';
        foreach($cmp as $cmp){
             echo  $data = '<option value='.$cmp->inid.'>'.$cmp->compname.'</option>';
        }
    }
    public function getinitlogs(){
        $inid = $this->input->post('inid');
        $this->load->model('Menu_model');?>
        <div class="col-12">
    <div class="card">
              <div class="card-header">
                <h3 class="card-title">Completed Task Logs</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <button id="grid-view-btn" class="btn border">Grid View</button>
                  <button id="list-view-btn" class="btn border">Xls View</button>
                    <div class="container-fluid card p-5" id="data-container">
                        <div class="row text-center" id="grid-view">
                            <?php
                            $oldd = "";$newd="";
                            $gdata = $this->Menu_model->get_utaskbycmp($inid);
                            foreach ($gdata as $gd) { if($oldd==''){$oldd = $gd->updateddate;} $newd = $gd->updateddate;?>
                                        <div class="col-sm-12 col-md-4 col-lg-4 mb-4">
                                        <div class="card p-3 border rounded border-success hover-div d-flex flex-column align-items-stretch h-100">
                                            <div class="custom-border-card">
                                            <span class="custom-border-text"><h5>Time Diff Between to Task : <?=$this->Menu_model->timediff($oldd, $newd);?></h5></span>
                                            <div class="card-body">
                                            Action<br><b style="color:<?=$gd->aclr?>"><?=$gd->acname?></b><hr>
                                            Befour Status<br><b style="color:<?=$gd->bsclr?>"><?=$gd->bstatus?></b><hr>
                                            After Status<br><b style="color:<?=$gd->asclr?>"><?=$gd->astatus?></b><hr>
                                            Company Name<br><a href="<?=base_url();?>Menu/CompanyDetails/<?=$gd->cid?>"><b style="color:<?=$gd->pclr?>"><?=$gd->compname?><a></a><br>(<?=$gd->pname?>)</b><hr>
                                            Task By<br><b><?=$gd->uname?></b><hr>
                                            Task Plan<br><b><?=$this->Menu_model->get_dformat($gd->appointmentdatetime)?></b><hr>
                                            Task Inistaed<br><b><?=$this->Menu_model->get_dformat($gd->initiateddt)?></b><br>
                                            Time Diff : <?=$this->Menu_model->timediff($gd->appointmentdatetime,$gd->initiateddt);?><hr>
                                            Task Updated<br><b><?=$this->Menu_model->get_dformat($gd->updateddate)?></b><br>
                                            Time Diff : <?=$this->Menu_model->timediff($gd->initiateddt,$gd->updateddate);?><hr>
                                            Remark/MOM <br><b><?=$gd->remarks?><?=$gd->mom?></b><hr>
                                            <div class="rounded-circle bg-danger" style="position: absolute;
                                                bottom: -10px; left: 40%; transform: translateX(-50%); width: 20px; height: 20px;"></div>
                                            <div class="rounded-circle bg-danger" style="position: absolute;
                                                bottom: -10px; left: 60%; transform: translateX(-50%); width: 20px; height: 20px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $oldd = $gd->updateddate;} ?>
                        </div>
                        <div id="list-view" style="display: none;">
                            <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Action</th>
                                            <th>Before Status</th>
                                            <th>After Status</th>
                                            <th>Company Name</th>
                                            <th>Partner Type</th>
                                            <th>Task By</th>
                                            <th>Task Plan</th>
                                            <th>Task Initiated</th>
                                            <th>Time Diff</th>
                                            <th>Task Updated</th>
                                            <th>Time Diff</th>
                                            <th>Remark</th>
                                            <th>MOM</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=1;
                            foreach ($gdata as $gd) {
                                ?>
                                        <tr>
                                         <td><?=$i?></td>
                                         <td><b style="color:<?=$gd->aclr?>"><?=$gd->acname?></b></td>
                                         <td><b style="color:<?=$gd->bsclr?>"><?=$gd->bstatus?></b></td>
                                         <td><b style="color:<?=$gd->asclr?>"><?=$gd->astatus?></b></td>
                                         <td><a href="<?=base_url();?>Menu/CompanyDetails/<?=$gd->cid?>"><b style="color:<?=$gd->pclr?>"><?=$gd->compname?></b></a></td>
                                         <td><b style="color:<?=$gd->pclr?>"><?=$gd->pname?></b></td>
                                         <td><?=$gd->uname?></td>
                                         <td><?=$this->Menu_model->get_dformat($gd->appointmentdatetime)?></td>
                                         <td><?=$this->Menu_model->get_dformat($gd->initiateddt)?></td>
                                         <td><?=$this->Menu_model->timediff($gd->appointmentdatetime,$gd->initiateddt)?></td>
                                         <td><?=$this->Menu_model->get_dformat($gd->updateddate)?></td>
                                         <td><?=$this->Menu_model->timediff($gd->initiateddt,$gd->updateddate)?></td>
                                         <td><?=$gd->remarks?></td>
                                         <td><?=$gd->mom?></td>
                                     </tr>
                                     <?php $i++;} ?>
                                  </tbody>
                                </table>
                        </div>
                    </div>
                        <script>
                            document.getElementById("grid-view-btn").addEventListener("click", function () {
                                document.getElementById("grid-view").style.display = "block";
                                document.getElementById("list-view").style.display = "none";
                                document.getElementById("list-view-btn").classList.remove('btn-info');
                                document.getElementById("grid-view-btn").classList.add('btn-info');
                            });
                            document.getElementById("list-view-btn").addEventListener("click", function () {
                                document.getElementById("grid-view").style.display = "none";
                                document.getElementById("list-view").style.display = "block";
                                document.getElementById("grid-view-btn").classList.remove('btn-info');
                                document.getElementById("list-view-btn").classList.add('btn-info');
                            });
                        </script>
              </div>
    <?php }
    public function getcmpbynwpsta(){
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_cmpbynwpsta($uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){
             echo  $data = '<option value='.$cmp->inid.'>'.$cmp->compname.'</option>';
        }
    }
    public function getcmpbypstassign(){
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_cmpbypstassign($uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){
             echo  $data = '<option value='.$cmp->inid.'>'.$cmp->compname.'</option>';
        }
    }
    public function getcmpbytbs(){
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_cmpbytbs($uid);
        foreach($cmp as $cmp){
             echo  $data = '<option value='.$cmp->inid.'>'.$cmp->compname.'</option>';
        }
    }
    public function getstatuscmp(){
        $sid= $this->input->post('sid');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_statuscmp($sid,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getUserCompBy_cmp_id(){
        $company_val= $this->input->post('company_val');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_user_cmp_cid($company_val,$uid);
        // echo $this->db->last_query();
        foreach($cmp as $cmp){ ?>
        <option selected style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getstatuscmp_reviewTarget(){
        $sid= $this->input->post('sid');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_statuscmp_reviewTarget($sid,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getcmp_getreviewtype(){
        $getreviewtype= $this->input->post('getreviewtype');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_statuscmp_reviewTargetType($getreviewtype,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getcmp_getreviewtype_self(){
        $getreviewtype= $this->input->post('getreviewtype');
        $getreviewtypeself= $this->input->post('getreviewtypeself');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_statuscmp_reviewTargetType_self($getreviewtype,$getreviewtypeself,$uid);
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getcmp_reviewTarget_typeoftaskData(){
        $sid= $this->input->post('sid');
        $typeoftask= $this->input->post('typeoftask');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->getcmp_reviewTarget_typeoftask($sid,$uid,$typeoftask);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getcmp_reviewTarget_actionData(){
        $sid= $this->input->post('sid');
        $typeoftask= $this->input->post('typeoftask');
        $actionData= $this->input->post('actionData');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->getcmp_reviewTarget_actionData($sid,$uid,$typeoftask,$actionData);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getcmp_reviewTarget_purposeData(){
        $sid= $this->input->post('sid');
        $typeoftask  = $this->input->post('typeoftask');
        $actionData  = $this->input->post('actionData');
        $purposeData = $this->input->post('purposeData');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->getcmp_reviewTarget_purposeData($sid,$uid,$typeoftask,$actionData,$purposeData);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getpstassigncmp(){
        $pstassign = $this->input->post('pstassign');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->getpstassigncmpdata($pstassign,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getstatuscmpnotplaned(){
        $sid= $this->input->post('sid');
        $uid= $this->input->post('uid');
        $task_action= $this->input->post('tasktaction');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_statuscmpnotplan($sid,$uid);
        // $cmp = $this->Menu_model->taskactionnotplan_filter1($sid,$task_action,$uid);
        $uniqueCompanies = [];
        foreach ($cmp as $company) {
            $uniqueCompanies[$company->compname] = $company;
        }
        
        $uniqueCompanies = array_values($uniqueCompanies); // Optional: reindex the array
      
        echo '<option value="">Select Company</option>';
        foreach($uniqueCompanies as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getcmp_partnertype(){
        $partnertype= $this->input->post('partnertype');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_cmp_partnertype($partnertype,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getquarter1company(){
        $partnertype= $this->input->post('quarter');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_cmp_quarter1($partnertype,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getallcmp_planbutnotinited(){
        $taskaction= $this->input->post('taskaction');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_allcmp_planbutnotinited($uid);
        echo sizeof($cmp);
    }
    public function getallcmp_planbutnotinitedold(){
        $taskaction= $this->input->post('taskaction');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_all_old_cmp_planbutnotinited($uid);
        echo sizeof($cmp);
    }
    public function getallcmp_PendingAutotask(){
        $taskaction= $this->input->post('taskaction');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_PendingAutoTask($uid);
        // echo "<pre>";
        // print_r($cmp);
        echo sizeof($cmp);
    }
    public function getcmp_planbutnotinited(){
        $taskaction= $this->input->post('taskaction');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_cmp_planbutnotinited($taskaction,$uid);
       
        $data = '';
        $callsids = '';
        foreach ($cmp as $c) {
            $getcomp = $this->Menu_model->get_cmp_PlanPendingwork($c->cid_id);
            foreach ($getcomp as $cmpData) {
                $data .= '<option value="' . $c->id . '">' . $cmpData->compname.' ('.$cmpData->pname . ')</option>';
            }
        }
       echo $data;
    }
    public function getcmp_planbutnotinitedOld(){
        $taskaction= $this->input->post('taskaction');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_old_cmp_planbutnotinited_with_spcl_req($taskaction,$uid);
       
        $data = '';
        $callsids = '';
        foreach ($cmp as $c) {
            $getcomp = $this->Menu_model->get_cmp_PlanPendingwork($c->cid_id);
            foreach ($getcomp as $cmpData) {
                $data .= '<option value="' . $c->id . '">' . $cmpData->compname.' ('.$cmpData->pname . ')</option>';
            }
        }
       echo $data;
    }
    public function getcmp_PendingAutotaskonPlanner(){
        $taskaction= $this->input->post('taskaction');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_PendingAutoTaskByActionID($uid,$taskaction);
        
        $data = '';
        $callsids = '';
        foreach ($cmp as $c) {
            $getcomp = $this->Menu_model->get_cmp_PlanPendingwork($c->cid_id);
            foreach ($getcomp as $cmpData) {
                $data .= '<option value="' . $c->id . '">' . $cmpData->compname.' ('.$cmpData->pname . ')</option>';
            }
        }
       echo $data;
    }
    public function getcmp_partnertypeCstatus(){
        $partnertype= $this->input->post('partnertype');
        $partnertype_cstatus= $this->input->post('partnertype_cstatus');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_cmp_partnertypeCstatus($partnertype,$partnertype_cstatus,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getcmp_partnertypeCstatusTask(){
        $partnertype= $this->input->post('partnertype');
        $partnertype_cstatus= $this->input->post('partnertype_cstatus');
        $partnertype_task= $this->input->post('partnertype_task');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_cmp_partnertypeCstatusTask($partnertype,$partnertype_cstatus,$partnertype_task,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getcmp_partnertypeCstatusTaskAction(){
        $partnertype= $this->input->post('partnertype');
        $partnertype_cstatus= $this->input->post('partnertype_cstatus');
        $partnertype_task= $this->input->post('partnertype_task');
        $taskAction= $this->input->post('partnertype_taskAction');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_cmp_partnertypeCstatusTaskAction($partnertype,$partnertype_cstatus,$partnertype_task,$taskAction,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getcmp_partnertypeCstatusTaskPurpose(){
        $partnertype= $this->input->post('partnertype');
        $partnertype_cstatus= $this->input->post('partnertype_cstatus');
        $partnertype_task= $this->input->post('partnertype_task');
        $taskAction= $this->input->post('partnertype_taskAction');
        $taskPurpose= $this->input->post('partnertype_taskPurpose');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_cmp_partnertypeCstatusTaskPurpose($partnertype,$partnertype_cstatus,$partnertype_task,$taskAction,$taskPurpose,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getcmp_samestatuslastdays(){
        $samestatus= $this->input->post('samestatus');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_cmp_samestatuslastdays($samestatus,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getcmp_samestatuslastdaysPartner(){
        $samestatus= $this->input->post('samestatus');
        $partnertype= $this->input->post('partnertype');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_cmp_samestatuslastdaysPartner($samestatus,$partnertype,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getcmp_samestatuslastdaysPartnerDays(){
        $samestatus= $this->input->post('samestatus');
        $partnertype= $this->input->post('partnertype');
        $daysfilter= $this->input->post('daysfilter');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_cmp_samestatuslastdaysPartnerdays($samestatus,$partnertype,$daysfilter,$uid);
        echo '<option value="">Select Company</option>';
        $uniqueObjects = [];
        foreach ($cmp as $object) {
            if (!isset($uniqueObjects[$object->inid])) {
                $uniqueObjects[$object->inid] = $object;
            }
        }
        $uniqueObjects = array_values($uniqueObjects);

        foreach($uniqueObjects as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getcmp_samestatuslastdaysPartnerDaysAction(){
        $samestatus= $this->input->post('samestatus');
        $partnertype= $this->input->post('partnertype');
        $daysfilter= $this->input->post('daysfilter');
        $taskActioncard= $this->input->post('taskActioncard');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_cmp_samestatuslastdaysPartnerdaysAction($samestatus,$partnertype,$daysfilter,$taskActioncard,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getcmp_samestatuslastdaysPartnerDaysPurpose(){
        $samestatus= $this->input->post('samestatus');
        $partnertype= $this->input->post('partnertype');
        $daysfilter= $this->input->post('daysfilter');
        $taskActioncard= $this->input->post('taskActioncard');
        $taskPurposecard= $this->input->post('taskPurposecard');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_cmp_samestatuslastdaysPartnerdaysPurpose($samestatus,$partnertype,$daysfilter,$taskActioncard,$taskPurposecard,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function taskactionnotplan(){
        $task_action= $this->input->post('task_action');
        $sid= $this->input->post('sid');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_statuscmpnotplan11($sid,$task_action,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function taskactionnotplan_filter(){
        $task_action= $this->input->post('tasktaction');
      
        $uid= $this->input->post('uid');;
        $this->load->model('Menu_model');
        // $cmp = $this->Menu_model->taskactionnotplan_filter1($sid,$task_action,$uid);
        $cmp = $this->Menu_model->taskactionnotplan_filter5($task_action,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function taskactionnotplan_filter_action(){
        $task_action= $this->input->post('tasktaction');
        $taskActionbyuserCardData= $this->input->post('tasktactionData');
        $sid= $this->input->post('sid');
        $uid= $this->input->post('uid');;
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->taskactionnotplan_filter2($sid,$task_action,$taskActionbyuserCardData,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function taskactionnotplan_filter_purpose(){
        $task_action= $this->input->post('tasktaction');
        $taskActionbyuserCardData= $this->input->post('tasktactionData');
        $taskPurposeData= $this->input->post('taskPurposeData');
        $sid= $this->input->post('sid');
        $uid= $this->input->post('uid');;
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->taskactionnotplan_filter3($sid,$task_action,$taskActionbyuserCardData,$taskPurposeData,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function taskactionnotplanwithdays(){
        $task_action= $this->input->post('task_action');
        $daysfiltercard_anp_date= $this->input->post('daysfiltercard_anp_date');
        $sid= $this->input->post('sid');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_statuscmpnotplan12($sid,$task_action,$daysfiltercard_anp_date,$uid);
      
        $uniqueObjects = [];
            foreach ($cmp as $object) {
                if (!isset($uniqueObjects[$object->inid])) {
                    $uniqueObjects[$object->inid] = $object;
                }
            }
            $uniqueObjects = array_values($uniqueObjects);
        echo '<option value="">Select Company</option>';
        foreach($uniqueObjects as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getstatuscmpwithtasktaction(){
        $sid= $this->input->post('sid');
        $uid= $this->input->post('uid');
        $tasktaction= $this->input->post('tasktaction');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_statuscmpwithtasktaction($sid,$uid,$tasktaction);
    
        echo '<option value="">Select Company</option>';
      
        $uniqueObjects = [];
        foreach ($cmp as $object) {
            if (!isset($uniqueObjects[$object->inid])) {
                $uniqueObjects[$object->inid] = $object;
            }
        }
        $uniqueObjects = array_values($uniqueObjects);

        foreach($uniqueObjects as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
            <?=$cmp->compname?> (<?=$cmp->pname?>)
        </option>
        <?php
        }
    }
    public function getTaskActionYesorNobyuser(){
        $sid= $this->input->post('sid');
        $uid= $this->input->post('uid');
        $taskActionbyuser= $this->input->post('taskActionbyuser');
        $tasktaction= $this->input->post('tasktaction');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->task_Action_YesorNobyUser($sid,$uid,$tasktaction,$taskActionbyuser);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
            <?=$cmp->compname?> (<?=$cmp->pname?>)
        </option>
        <?php
        }
    }
    public function getTaskPurposeYesorNobyuser(){
        $sid= $this->input->post('sid');
        $uid= $this->input->post('uid');
        $taskActionbyuser= $this->input->post('taskActionbyuser');
        $tasktaction= $this->input->post('tasktaction');
        $taskPurposebyuser= $this->input->post('taskPurposebyuser');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->task_Purpose_YesorNobyUser($sid,$uid,$tasktaction,$taskPurposebyuser,$taskActionbyuser);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
            <?=$cmp->compname?> (<?=$cmp->pname?>)
        </option>
        <?php
        }
    }
   
    public function getstatuscmp4(){
        $sid= $this->input->post('sid');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_statuscmp4($sid,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getstatuscmp6(){
        $sid= $this->input->post('sid');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_statuscmp6($sid,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){ ?>
        <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
    <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
        <?php
        }
    }
    public function getcmpbyloc(){
        $bylocation= $this->input->post('bylocation');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_cmpbyloc($bylocation,$uid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){
             echo  $data = '<option value='.$cmp->inid.'>'.$cmp->compname.'</option>';
        }
    }
    public function getcmpbylocaction(){
        $bylocation= $this->input->post('bylocation');
        $selectactionplane= $this->input->post('selectactionplane');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp = $this->Menu_model->get_cmpbylocByAction($bylocation,$uid,$selectactionplane);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $cmp){
             echo  $data = '<option value='.$cmp->inid.'>'.$cmp->compname.'</option>';
        }
    }
    public function getcmpbybylocation(){
        $bylocation= $this->input->post('bylocation');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $query2 = $this->db->query("SELECT DISTINCT company_master.city AS city FROM init_call LEFT JOIN company_master ON company_master.id = init_call.cmpid_id LEFT JOIN partner_master ON partner_master.id = company_master.partnerType_id WHERE init_call.mainbd = '$uid' AND company_master.city != ''");
        $data3  = $query2->result();
        echo '<option value="">Select Company Location</option>';
        foreach($data3 as $cmp){
             echo  $data = '<option value='.$cmp->city.'>'.$cmp->city.'</option>';
        }
    }
    public function getcmpbyClusterLocation(){
        $bylocation= $this->input->post('bylocation');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $query2 = $this->db->query("SELECT DISTINCT init_call.id,company_master.compname AS cname, init_call.cluster_id FROM init_call LEFT JOIN company_master ON company_master.id = init_call.cmpid_id LEFT JOIN partner_master ON partner_master.id = company_master.partnerType_id WHERE init_call.mainbd = '$uid' and init_call.cluster_id !=''");
        $data3  = $query2->result();
        $clids = '';
        foreach($data3 as $d){
            $clids .= $d->cluster_id.',';
        }
        $clids = rtrim($clids , ',');
      
        $query3 = $this->db->query("SELECT * FROM `cluster` WHERE user_id = $uid AND id in($clids)");
        $data4  = $query3->result();
        echo '<option value="">Select Cluster Name</option>';
        foreach($data4 as $cmp){
             echo  $data = '<option value='.$cmp->id.'>'.$cmp->clustername.'</option>';
        }
    }
    public function getcmpbyClusterLocationid(){
        
        $clusterid= $this->input->post('clusterid');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $query2 = $this->db->query("SELECT DISTINCT init_call.id,company_master.compname AS cname, init_call.cluster_id FROM init_call LEFT JOIN company_master ON company_master.id = init_call.cmpid_id LEFT JOIN partner_master ON partner_master.id = company_master.partnerType_id WHERE init_call.mainbd = '$uid' and init_call.cluster_id =$clusterid");
        $data3  = $query2->result();
        echo '<option value="">Select Company</option>';
        foreach($data3 as $cmp){
            echo  $data = '<option value='.$cmp->id.'>'.$cmp->cname.'</option>';
       }
    }
    
    public function getcmpbyClusteridWithStatus(){
        
        $clusterid= $this->input->post('clusterid');
        $statusfilterCluster= $this->input->post('statusfilterCluster');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        if($statusfilterCluster == 'all'){
            $query2 = $this->db->query("SELECT DISTINCT init_call.id,company_master.compname AS cname, init_call.cluster_id FROM init_call LEFT JOIN company_master ON company_master.id = init_call.cmpid_id LEFT JOIN partner_master ON partner_master.id = company_master.partnerType_id WHERE init_call.mainbd = '$uid' and (init_call.cluster_id =$clusterid and init_call.cstatus !='')");
        }else{
            $query2 = $this->db->query("SELECT DISTINCT init_call.id,company_master.compname AS cname, init_call.cluster_id FROM init_call LEFT JOIN company_master ON company_master.id = init_call.cmpid_id LEFT JOIN partner_master ON partner_master.id = company_master.partnerType_id WHERE init_call.mainbd = '$uid' and (init_call.cluster_id =$clusterid and init_call.cstatus =$statusfilterCluster)");
        }
   
        $data3  = $query2->result();
        echo '<option value="">Select Company</option>';
        foreach($data3 as $cmp){
            echo  $data = '<option value='.$cmp->id.'>'.$cmp->cname.'</option>';
       }
    }
    public function getcmpbyClusteridWithStatusWithAction(){
        
        $clusterid= $this->input->post('clusterid');
        $statusfilterCluster= $this->input->post('statusfilterCluster');
        $taskActionbyCluster= $this->input->post('taskActionbyCluster');
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        if($statusfilterCluster == 'all'){
            $query2 = $this->db->query("SELECT DISTINCT init_call.id,company_master.compname AS cname, init_call.cluster_id FROM init_call LEFT JOIN company_master ON company_master.id = init_call.cmpid_id LEFT JOIN partner_master ON partner_master.id = company_master.partnerType_id LEFT JOIN tblcallevents on tblcallevents.cid_id = init_call.id WHERE init_call.mainbd = '100171' and (init_call.cluster_id =108 and init_call.cstatus !='' and tblcallevents.actontaken ='$taskActionbyCluster')");
        }else{
            $query2 = $this->db->query("SELECT DISTINCT init_call.id,company_master.compname AS cname, init_call.cluster_id FROM init_call LEFT JOIN company_master ON company_master.id = init_call.cmpid_id LEFT JOIN partner_master ON partner_master.id = company_master.partnerType_id LEFT JOIN tblcallevents on tblcallevents.cid_id = init_call.id WHERE init_call.mainbd = '100171' and (init_call.cluster_id =108 and init_call.cstatus =$statusfilterCluster and tblcallevents.actontaken ='$taskActionbyCluster')");
        }
        
        $data3  = $query2->result();
        echo '<option value="">Select Company</option>';
        foreach($data3 as $cmp){
            echo  $data = '<option value='.$cmp->id.'>'.$cmp->cname.'</option>';
       }
    }
    public function getcmpbyClusteridWithStatusWithActionPurpose(){
        
        $clusterid              = $this->input->post('clusterid');
        $statusfilterCluster    = $this->input->post('statusfilterCluster');
        $taskActionbyCluster    = $this->input->post('taskActionbyCluster');
        $taskPurposebyCluster   = $this->input->post('taskPurposebyCluster');
        $uid                    = $this->input->post('uid');
        $this->load->model('Menu_model');
        if($statusfilterCluster == 'all'){
            $query2 = $this->db->query("SELECT DISTINCT init_call.id,company_master.compname AS cname, init_call.cluster_id FROM init_call LEFT JOIN company_master ON company_master.id = init_call.cmpid_id LEFT JOIN partner_master ON partner_master.id = company_master.partnerType_id LEFT JOIN tblcallevents on tblcallevents.cid_id = init_call.id WHERE init_call.mainbd = '100171' and (init_call.cluster_id =108 and init_call.cstatus !='' and tblcallevents.actontaken ='$taskActionbyCluster' and tblcallevents.purpose_achieved ='$taskPurposebyCluster')");
        }else{
            $query2 = $this->db->query("SELECT DISTINCT init_call.id,company_master.compname AS cname, init_call.cluster_id FROM init_call LEFT JOIN company_master ON company_master.id = init_call.cmpid_id LEFT JOIN partner_master ON partner_master.id = company_master.partnerType_id LEFT JOIN tblcallevents on tblcallevents.cid_id = init_call.id WHERE init_call.mainbd = '100171' and (init_call.cluster_id =108 and init_call.cstatus =$statusfilterCluster and tblcallevents.actontaken ='$taskActionbyCluster' and tblcallevents.purpose_achieved ='$taskPurposebyCluster')");
        }
        
        $data3  = $query2->result();
        echo '<option value="">Select Company</option>';
        foreach($data3 as $cmp){
            echo  $data = '<option value='.$cmp->id.'>'.$cmp->cname.'</option>';
       }
    }
    public function tbdata(){
        $sstid= $this->input->post('stid');
        $uuid= $this->input->post('uuid');
        $code= $this->input->post('code');
        $this->load->model('Menu_model');?>
        <script>
    $("#example1").DataTable({
      "responsive": false, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>
        <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>S NO</th>
						<th>Current Status</th>
						<th>Company Name</th>
						<th>Address</th>
						<th>City</th>
						<th>State</th>
						<th>Partner Type</th>
						<th>Category</th>
						<th>Current Remark</th>
						<th>Total Logs on Same Status</th>
						<th>Current Status of from whitch date</th>
						<th>Same Status from Current Time</th>
                    </tr>
				</thead>
				<tbody>
        <?php
        $i=1;
        $mdata = $this->Menu_model->get_fannalbycode($uuid,$sstid,$code);
             foreach($mdata as $dt){
             $cid = $dt->cmpid_id;
             $init=$this->Menu_model->get_initcallbyid($cid);
             $ciid = $init[0]->id;
             $ldscd=$this->Menu_model->get_laststatuschangedate($ciid);
             $updatedt = $ldscd[0]->updatedt;
             $stlogs = $ldscd[0]->cont;
             $cdate=date('Y-m-d H:i:s');
             $timediff = $this->Menu_model->timediff($updatedt,$cdate);
             $pid = $init[0]->apst;
             $patid = $dt->partnerType_id;
             if($patid){$patrid = $this->Menu_model->get_partnerbyid($patid);$patid = $patrid[0]->name;$pclr=$patrid[0]->clr;} else{$patid='';$pclr='';}
             if($patid){$sid = $dt->cstatus;$stid=$this->Menu_model->get_statusbyid($sid);$sid=$stid[0]->name;$sclr=$stid[0]->clr;}
             else{$sid='';$sclr='';}
             $tblc=$this->Menu_model->get_tblbyidwithremark($ciid);
             $logs = sizeof($tblc);
             if($logs>0){$appoint = $tblc[0]->appointmentdatetime;
             $nextaction = $tblc[0]->nextaction;
             $remarks = $tblc[0]->remarks;}else{$appoint='';$nextaction='';$remarks='';}
        ?>
        <tr>
             <td><?=$i++?></td>
             <td style="color:<?=$sclr?>"><?=$sid?></td>
             <td style="color:<?=$pclr?>"><?=$dt->compname?></td>
             <td><?=$dt->address?></td>
             <td><?=$dt->city?></td>
             <td><?=$dt->state?></td>
             <td style="color:<?=$pclr?>"><?=$patid?></td>
             <td><?php if($dt->focus_funnel=='yes'){echo 'Focus Funnel, ';} if($dt->upsell_client=='yes'){echo 'Upsell Client, ';} if($dt->keycompany=='yes'){echo 'Key Company';}?></td>
             <td><?=$remarks?></td>
             <td><?=$stlogs?></td>
             <td><?=$ldscd[0]->updatedt?></td>
             <td><?=$timediff?></td>
        </tr>
       <?php }?>
		</tbody>
	</table>
	<?php
    }
    public function gdata(){
        $sstid= $this->input->post('stid');
        $uuid= $this->input->post('uuid');
        $code= $this->input->post('code');
        $this->load->model('Menu_model');
        ?>
        <div class="row">
          <?php
            $mdata = $this->Menu_model->get_fannalbycode($uuid,$sstid,$code);
             foreach($mdata as $dt){
             $cid = $dt->cmpid_id;
             $init=$this->Menu_model->get_initcallbyid($cid);
             $ciid = $init[0]->id;
             $ldscd=$this->Menu_model->get_laststatuschangedate($ciid);
             $updatedt = $ldscd[0]->updatedt;
             $stlogs = $ldscd[0]->cont;
             $cdate=date('Y-m-d H:i:s');
             $timediff = $this->Menu_model->timediff($updatedt,$cdate);
             $pid = $init[0]->apst;
             $patid = $dt->partnerType_id;
             if($patid){$patrid = $this->Menu_model->get_partnerbyid($patid);$patid = $patrid[0]->name;$pclr=$patrid[0]->clr;} else{$patid='';$pclr='';}
             if($patid){$sid = $dt->cstatus;$stid=$this->Menu_model->get_statusbyid($sid);$sid=$stid[0]->name;$sclr=$stid[0]->clr;}
             else{$sid='';$sclr='';}
             $tblc=$this->Menu_model->get_tblbyidwithremark($ciid);
             $logs = sizeof($tblc);
             if($logs>0){$appoint = $tblc[0]->appointmentdatetime;
             $nextaction = $tblc[0]->nextaction;
             $remarks = $tblc[0]->remarks;}else{$appoint='';$nextaction='';$remarks='';}
        ?>
        <div class="col-sm-12 col-md-4 col-lg-4 mb-4 filter-item">
          <div class="card p-3 border rounded border-success hover-div d-flex flex-column align-items-stretch h-100 text-dark">
                 Current Status<br><b style="color:<?=$sclr?>"><?=$sid?></b><hr>
                 Company Name<br><b style="color:<?=$pclr?>"><?=$dt->compname?></b><hr>
                 Address<br><b><?=$dt->address?></b><hr>
                 City<br><b><?=$dt->city?></b><hr>
                 State<br><b><?=$dt->state?></b><hr>
                 Partner Type<br><b style="color:<?=$pclr?>"><?=$patid?></b><hr>
                 Category<br><b><?php if($dt->focus_funnel=='yes'){echo 'Focus Funnel, ';} if($dt->upsell_client=='yes'){echo 'Upsell Client, ';} if($dt->keycompany=='yes'){echo 'Key Company';}?></b> <hr>
                 Current Remark<br><b><?=$remarks?></b></a><hr>
                 Total Logs on Same Status<br><b><?=$stlogs?></b></a><hr>
                 Current Status of from whitch date<br><b><?=$ldscd[0]->updatedt?></b></a><hr>
                 Same Status from Current Time<br><b><?=$timediff?></b>
                <div class="rounded-circle bg-danger" style="position: absolute;bottom: -10px; left: 40%; transform: translateX(-50%); width: 20px; height: 20px;"></div>
                <div class="rounded-circle bg-danger" style="position: absolute;bottom: -10px; left: 60%; transform: translateX(-50%); width: 20px; height: 20px;"></div>
          </div>
        </div>
       <?php } ?>
       </div>
    <?php
    }
    public function actionremark(){
        $purpose_id= $this->input->post('purpose_id');
        $this->load->model('Menu_model');
        $da = '';
        $remark=$this->Menu_model->get_purposebyid($purpose_id);
        echo  $data = '<option value="">Select Remark</option>';
        foreach($remark as $d){
             echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }
    }
    public function purpose(){
        $action_id= $this->input->post('action_id');
        $this->load->model('Menu_model');
        $da = '';
        $remark=$this->Menu_model->get_purposebyid($action_id);
        echo  $data = '<option value="">Select Purpose</option>';
        foreach($remark as $d){
             echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }
    }
    public function getpurpose(){
        $aid= $this->input->post('aid');
        $sid= $this->input->post('sid');
        $this->load->model('Menu_model');
        $da = '';
        $remark=$this->Menu_model->get_purposebya($aid,$sid);
        echo  $data = '<option value="">Select Purpose</option>';
        foreach($remark as $d){
             echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }
    }
    public function getpurposebyinid(){
        $inid= $this->input->post('inid');
        $aid= $this->input->post('aid');
        $this->load->model('Menu_model');
        $da = '';
        $remark=$this->Menu_model->get_purposebyinid($aid,$inid);
        echo  $data = '<option value="">Select Purpose</option>';
        foreach($remark as $d){
             echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }
    }
    public function getpurposebyinidnew(){
        $inid= $this->input->post('inid');
        $aid= $this->input->post('aid');
        $this->load->model('Menu_model');
        $da = '';
        $inid = rtrim($inid , ',');
       
        $remark=$this->Menu_model->get_purposebyinidnew($aid,$inid);
       
        echo  $data = '<option value="">Select Purpose</option>';
        foreach($remark as $d){
             echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }
        if(sizeof($remark) == 0){
            echo '<option value="34">Fresh Meeting</option>';
        }
    }
    public function changenorp(){
        $tid= $this->input->post('tid');
        $this->load->model('Menu_model');
        $remark=$this->Menu_model->change_norp($tid);
    }
    public function setkeycompny(){
        $cmpid = $this->input->post('cmpid');
        $this->load->model('Menu_model');
        $this->Menu_model->set_keycompny($cmpid);
    }
    public function getnextaction(){
        $pid= $this->input->post('pid');
        $this->load->model('Menu_model');
        $remark=$this->Menu_model->get_nextactionbyp($pid);
        echo  $data = '<option value="">Select Purpose</option>';
        foreach($remark as $d){
             echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }
    }
    public function getcity(){
        $stid= $this->input->post('stid');
        $this->load->model('Menu_model');
        $da = '';
        $city=$this->Menu_model->get_citybyst($stid);
        echo  $data = '<option value="">Select City</option>';
        foreach($city as $d){
             echo  $data = '<option value='.$d->id.'>'.$d->city.'</option>';
        }
    }
    public function getcitybystate(){
        $stid= $this->input->post('stid');
        $this->load->model('Menu_model');
        $da = '';
        $city=$this->Menu_model->get_citybystname($stid);
        echo  $data = '<option value="">Select City</option>';
        foreach($city as $d){
             echo  $data = '<option>'.$d->city.'</option>';
        }
    }
    public function getcmpdbybdnst(){
        $pstid = $this->input->post('pstid');
        $stid = $this->input->post('stid');
        $bdid = $this->input->post('bdid');
        $fdate = $this->input->post('fdate');
        $categories = $this->input->post('categories');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_cmpdbybdnst($stid,$bdid,$fdate,$pstid,$categories);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $dt){
             echo  $data = '<option value='.$dt->inid.'>'.$dt->compname.'</option>';
        }
    }
    public function getcmpdbypstnst(){
        $pstid = $this->input->post('pstid');
        $stid = $this->input->post('stid');
        $bdid = $this->input->post('bdid');
        $fdate = $this->input->post('fdate');
        $categories = $this->input->post('categories');
        $reviewtype = $this->input->post('revtype');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_cmpdbypstnst($stid,$bdid,$fdate,$pstid,$categories,$reviewtype);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $dt){
             echo  $data = '<option value='.$dt->inid.'>'.$dt->compname.'</option>';
        }
    }
  public function getcmpdbypstnst12(){
        $pstid = $this->input->post('pstid');
        $prtsl = $this->input->post('prtsl');
        $bdid = $this->input->post('bdid');
        $fdate = $this->input->post('fdate');
        $categories = $this->input->post('categories');
        $reviewtype = $this->input->post('revtype');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_cmpdbypstnst12($prtsl,$bdid,$fdate,$pstid,$categories,$reviewtype);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $dt){
             echo  $data = '<option value='.$dt->inid.'>'.$dt->compname.'</option>';
        }
    }
    public function getcsrcmp(){
        $rid = $this->input->post('rid');
        $this->load->model('Menu_model');
        echo $cmp=$this->Menu_model->get_csrcmp($rid);
    }
    public function getotherremark(){
        $stid = $this->input->post('stid');
        $this->load->model('Menu_model');
        if($stid==1){
            echo '<option>Select Option</option><option>No Calling Done</option><option>Other</option>';
        }
        elseif($stid==8){
          echo '<option>Select Option</option>
                <option>RP Changed</option>
                <option>Never connected on a call</option>
                <option>Transfer to Mam (Connect at HO)</option>
                <option>ReMeeting required</option>
                <option>Budget Exhausted/Allocated</option>
                <option>Different CSR theme</option>
                <option>Other</option>';
        }
        else{
          echo '<option>Select Option</option>
                <option>No Meeting Done</option>
                <option>Other</option>';
        }
    }
    public function getcallremark(){
        $stid = $this->input->post('stid');
        $this->load->model('Menu_model');
        if($stid==1){
            echo '<option>Select Option</option>
                  <option>Tried Calling Once but was not reached</option>
                  <option>Tried Calling Twice but was not reached</option>
                  <option>Tried Calling Thrice but was not reached</option>
                  <option>Tried Calling a More then three time but was not reached</option>
                  <option>Other</option>';
        }
        elseif($stid==8){
          echo '<option>Select Option</option>
                <option>Tried Calling Once but was not reached</option>
                <option>Tried Calling Twice but was not reached</option>
                <option>Tried Calling Thrice but was not reached</option>
                <option>Tried Calling a More then three time but was not reached</option>
                <option>Other</option>';
        }
        else{
          echo '<option>Select Option</option>
                <option>Not Connected on Call</option>
                <option>Followup Call Done Once but Meeting not Scheduled</option>
                <option>Followup Call Done Twice but Meeting not Scheduled</option>
                <option>Followup Call Done More Than Three Times but Meeting not Scheduled</option>
                <option>Other</option>';
        }
    }
    public function getemailremark(){
        $stid = $this->input->post('stid');
        $this->load->model('Menu_model');
        if($stid==1){
            echo '<option>Select Option</option>
                  <option>No Email Done</option>
                  <option>Other</option>';
        }
        elseif($stid==8){
          echo '<option>Select Option</option>
                <option>No Mail done</option>
                <option>Mailed Once</option>
                <option>Mailed Twice</option>
                <option>Mailed more than Twice</option>
                <option>Other</option>';
        }
        else{
          echo '<option>Select Option</option>
                <option>No Mail done</option>
                <option>Mailed Once</option>
                <option>Mailed Twice</option>
                <option>Mailed more than Twice</option>
                <option>Other</option>';
        }
    }
    public function getmeetremark(){
        $stid = $this->input->post('stid');
        $this->load->model('Menu_model');
        if($stid==1){
            echo '<option>Select Option</option>
                  <option>No Barge in Done</option>
                  <option>Barge in done Once but No Purpose Achieved</option>
                  <option>Barge in done Twice but No Purpose Achieved</option>
                  <option>Barge in done more than twice but No Purpose Achieved</option>
                  <option>Other</option>';
        }
        elseif($stid==8){
          echo '<option>Select Option</option>
                <option>No Meeting Done</option>
                <option>Other</option>';
        }
        else{
          echo '<option>Select Option</option>
                <option>No Barge in Done</option>
                <option>Barge in done Once but No Purpose Achieved</option>
                <option>Barge in done Twice but No Purpose Achieved</option>
                <option>Barge in done more than twice but No Purpose Achieved</option>
                <option>Other</option>';
        }
    }
    public function getcmpdbybd(){

        $stid       = $this->input->post('stid');
        $bdid       = $this->input->post('bdid');
        $fdate      = $this->input->post('fdate');

        $pstid      = $this->input->post('pstid');
        $review_id  = $this->input->post('review_id');
        $this->load->model('Menu_model');
       
        $revdata    =   $this->Menu_model->getReviewByRID($review_id);
        $rev_startt =   $revdata[0]->startt;
        $reviewtype =   $revdata[0]->reviewtype;
        $cdatetime  =   date("Y-m-d H:i:s");

        $revcmp     =   $this->Menu_model->getReviewedCMP($rev_startt,$cdatetime,$bdid,$reviewtype);

        $cmp=$this->Menu_model->get_cmpdbybd($stid,$bdid,$fdate);
            function filterArray($array1, $array2) {
                $inidValues = array_column($array1, 'inid');
                return array_filter($array2, function($item) use ($inidValues) {
                    return !in_array($item->inid, $inidValues);
                });
            }
        $result = filterArray($revcmp, $cmp);
        echo '<option value="">Select Company</option>';
        foreach($result as $dt){
             echo  $data = '<option value='.$dt->inid.'>'.$dt->compname.'</option>';
        }
    }
    public function getbdcmpts(){
        $stid = $this->input->post('stid');
        $bdid = $this->input->post('bdid');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_bdcmpts($stid,$bdid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $dt){
            $inid = $dt->inid;
            $ridinid = $this->Menu_model->ger_targetsetting($inid,$bdid);
            if(!$ridinid){
             echo  $data = '<option value='.$dt->inid.'>'.$dt->compname.'</option>';
            }
        }
    }
    public function getcmptscat(){
        $categories = $this->input->post('categories');
        $bdid = $this->input->post('bdid');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_bdcmptscat($categories,$bdid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $dt){
            $inid = $dt->inid;
            $ridinid = $this->Menu_model->ger_targetsetting($inid,$bdid);
            if(!$ridinid){
             echo  $data = '<option value='.$dt->inid.'>'.$dt->compname.'</option>';
            }
        }
    }
    public function getbdcmpdbynst(){
        $rid = $this->input->post('rid');
        $pstid = $this->input->post('pstid');
        $stid = $this->input->post('stid');
        $bdid = $this->input->post('bdid');
        $fdate = $this->input->post('fdate');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_bdcmpdbynst($stid,$bdid,$fdate,$pstid,$rid);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $dt){
             echo  $data = '<option value='.$dt->inid.'>'.$dt->compname.'</option>';
        }
    }
    public function getpstcmpdbynst(){
        $pstid = $this->input->post('pstid');
        $stid = $this->input->post('stid');
        $bdid = $this->input->post('bdid');
        $fdate = $this->input->post('fdate');
        $categories = $this->input->post('categories');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_pstcmpdbynst($stid,$bdid,$fdate,$categories);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $dt){
             echo  $data = '<option value='.$dt->inid.'>'.$dt->compname.'</option>';
        }
    }
    public function getcmpdbyadmins(){
        $rid = $this->input->post('rid');
        $pstid = $this->input->post('pstid');
        $stid = $this->input->post('stid');
        $bdid = $this->input->post('bdid');
        $fdate = $this->input->post('fdate');
        $categories = $this->input->post('categories');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_cmpdbyadmins($stid,$bdid,$fdate,$categories);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $dt){
            $inid = $dt->inid;
            $ridinid = $this->Menu_model->ger_ridinid($inid,$rid);
            if(!$ridinid){
             echo  $data = '<option value='.$dt->inid.'>'.$dt->compname.'</option>';
            }
        }
    }
    public function getgraphlog(){
        $uid = $this->input->post('uid');
        $inid = $this->input->post('inid');
        $sd = $this->input->post('fdate');
        $ed = "2024-03-31";
        $this->load->model('Menu_model');?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1/dist/chart.umd.min.js"></script>
    <div style="width: 80%; margin: auto;">
        <b><hr><center>Month Wise No of Task Action Planning</center><hr></b>
        <canvas id="stackedChartID21"></canvas>
    </div>
    <script>
        var myContext = document.getElementById("stackedChartID21").getContext('2d');
        var myChart21 = new Chart(myContext, {
            type: 'bar',
            data: {
                labels: [
                    <?php   $currentDate = new DateTime();
                            $financialYear = ($currentDate->format('m') >= 4) ? $currentDate->format('Y') : ($currentDate->format('Y') - 1);
                            for ($month = 4; $month <= 15; $month++) {
                                $adjustedMonth = ($month <= 12) ? $month : ($month - 12);
                                $year = ($month <= 12) ? $financialYear : ($financialYear + 1);
                                $monthName = DateTime::createFromFormat('!m', $adjustedMonth)->format('F');?>
                    "<?=$monthName?> (<?=$year?>)", <?php } ?>],
                datasets: [
                    <?php
                    $colors = array('red','blue','green','yellow','purple','orange','pink','brown','cyan','magenta','teal','lime','violet','indigo','gray');
                    $action = $this->Menu_model->get_action(); $i=0; foreach($action as $ac){
                        $acid = $ac->id; ?>
                    {
                        label: '<?=$ac->name?>',
                        backgroundColor: "<?=$colors[$i]?>",
                        data: [
                        <?php $currentDate = new DateTime();
                        $financialYear = ($currentDate->format('m') >= 4) ? $currentDate->format('Y') : ($currentDate->format('Y') - 1);
                        for ($month = 4; $month <= 15; $month++) {
                            $adjustedMonth = ($month <= 12) ? $month : ($month - 12);
                            $year = ($month <= 12) ? $financialYear : ($financialYear + 1);
                            $accont = $this->Menu_model->get_mywisetaskallbyf($uid,$month,$year,$acid,$inid);?>
                            <?=$accont[0]->cont?>,<?php } ?>],
                        stack: 'Stack 0',
                    },
                    <?php $i++;} ?>
                ],
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Month Wise No of Task Planning'
                    },
            },
            onClick: function (evt, activeElements) {
                if (activeElements && activeElements.length) {
                    const clickedDatasetIndex = activeElements[0].datasetIndex;
                    let allOthersHidden = true;
                    for (let i = 0; i < myChart21.data.datasets.length; i++) {
                        if (i !== clickedDatasetIndex && !myChart21.getDatasetMeta(i).hidden) {
                            allOthersHidden = false;
                            break;
                        }
                    }
                    if (allOthersHidden) {
                        for (let i = 0; i < myChart21.data.datasets.length; i++) {
                            myChart21.getDatasetMeta(i).hidden = false;
                        }
                    } else {
                        for (let i = 0; i < myChart21.data.datasets.length; i++) {
                            myChart21.getDatasetMeta(i).hidden = (i !== clickedDatasetIndex);
                        }
                    }
                    myChart21.update();
                }
            }
        }
    });
    </script>
    <div style="width: 80%; margin: auto;">
        <b><hr><center>Month Wise No of Task Action No Purpose No</center><hr></b>
        <canvas id="stackedChartID22"></canvas>
    </div>
    <script>
        var myContext = document.getElementById("stackedChartID22").getContext('2d');
        var myChart22 = new Chart(myContext, {
            type: 'bar',
            data: {
                labels: [
                    <?php   $currentDate = new DateTime();
                            $financialYear = ($currentDate->format('m') >= 4) ? $currentDate->format('Y') : ($currentDate->format('Y') - 1);
                            for ($month = 4; $month <= 15; $month++) {
                                $adjustedMonth = ($month <= 12) ? $month : ($month - 12);
                                $year = ($month <= 12) ? $financialYear : ($financialYear + 1);
                                $monthName = DateTime::createFromFormat('!m', $adjustedMonth)->format('F');?>
                    "<?=$monthName?> (<?=$year?>)", <?php } ?>],
                datasets: [
                    <?php
                    $colors = array('red','blue','green','yellow','purple','orange','pink','brown','cyan','magenta','teal','lime','violet','indigo','gray');
                    $action = $this->Menu_model->get_action(); $i=0; foreach($action as $ac){
                        $acid = $ac->id; ?>
                    {
                        label: '<?=$ac->name?>',
                        backgroundColor: "<?=$colors[$i]?>",
                        data: [
                        <?php $currentDate = new DateTime();
                        $financialYear = ($currentDate->format('m') >= 4) ? $currentDate->format('Y') : ($currentDate->format('Y') - 1);
                        for ($month = 4; $month <= 15; $month++) {
                            $adjustedMonth = ($month <= 12) ? $month : ($month - 12);
                            $year = ($month <= 12) ? $financialYear : ($financialYear + 1);
                            $accont = $this->Menu_model->get_mywisetaskallbyfanpn($uid,$month,$year,$acid,$inid);?>
                            <?=$accont[0]->cont?>,<?php } ?>],
                        stack: 'Stack 0',
                    },
                    <?php $i++;} ?>
                ],
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Month Wise No of Task Action No Purpose No'
                    },
            },
            onClick: function (evt, activeElements) {
                if (activeElements && activeElements.length) {
                    const clickedDatasetIndex = activeElements[0].datasetIndex;
                    let allOthersHidden = true;
                    for (let i = 0; i < myChart22.data.datasets.length; i++) {
                        if (i !== clickedDatasetIndex && !myChart22.getDatasetMeta(i).hidden) {
                            allOthersHidden = false;
                            break;
                        }
                    }
                    if (allOthersHidden) {
                        for (let i = 0; i < myChart22.data.datasets.length; i++) {
                            myChart22.getDatasetMeta(i).hidden = false;
                        }
                    } else {
                        for (let i = 0; i < myChart22.data.datasets.length; i++) {
                            myChart22.getDatasetMeta(i).hidden = (i !== clickedDatasetIndex);
                        }
                    }
                    myChart22.update();
                }
            }
        }
    });
    </script>
    <div style="width: 80%; margin: auto;">
        <b><hr><center>Month Wise No of Task Action Yes Purpose No</center><hr></b>
        <canvas id="stackedChartID23"></canvas>
    </div>
    <script>
        var myContext = document.getElementById("stackedChartID23").getContext('2d');
        var myChart23 = new Chart(myContext, {
            type: 'bar',
            data: {
                labels: [
                    <?php   $currentDate = new DateTime();
                            $financialYear = ($currentDate->format('m') >= 4) ? $currentDate->format('Y') : ($currentDate->format('Y') - 1);
                            for ($month = 4; $month <= 15; $month++) {
                                $adjustedMonth = ($month <= 12) ? $month : ($month - 12);
                                $year = ($month <= 12) ? $financialYear : ($financialYear + 1);
                                $monthName = DateTime::createFromFormat('!m', $adjustedMonth)->format('F');?>
                    "<?=$monthName?> (<?=$year?>)", <?php } ?>],
                datasets: [
                    <?php
                    $colors = array('red','blue','green','yellow','purple','orange','pink','brown','cyan','magenta','teal','lime','violet','indigo','gray');
                    $action = $this->Menu_model->get_action(); $i=0; foreach($action as $ac){
                        $acid = $ac->id; ?>
                    {
                        label: '<?=$ac->name?>',
                        backgroundColor: "<?=$colors[$i]?>",
                        data: [
                        <?php $currentDate = new DateTime();
                        $financialYear = ($currentDate->format('m') >= 4) ? $currentDate->format('Y') : ($currentDate->format('Y') - 1);
                        for ($month = 4; $month <= 15; $month++) {
                            $adjustedMonth = ($month <= 12) ? $month : ($month - 12);
                            $year = ($month <= 12) ? $financialYear : ($financialYear + 1);
                            $accont = $this->Menu_model->get_mywisetaskallbyfaypn($uid,$month,$year,$acid,$inid);?>
                            <?=$accont[0]->cont?>,<?php } ?>],
                        stack: 'Stack 0',
                    },
                    <?php $i++;} ?>
                ],
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Month Wise No of Task Action Yes Purpose No'
                    },
            },
            onClick: function (evt, activeElements) {
                if (activeElements && activeElements.length) {
                    const clickedDatasetIndex = activeElements[0].datasetIndex;
                    let allOthersHidden = true;
                    for (let i = 0; i < myChart23.data.datasets.length; i++) {
                        if (i !== clickedDatasetIndex && !myChart23.getDatasetMeta(i).hidden) {
                            allOthersHidden = false;
                            break;
                        }
                    }
                    if (allOthersHidden) {
                        for (let i = 0; i < myChart23.data.datasets.length; i++) {
                            myChart23.getDatasetMeta(i).hidden = false;
                        }
                    } else {
                        for (let i = 0; i < myChart23.data.datasets.length; i++) {
                            myChart23.getDatasetMeta(i).hidden = (i !== clickedDatasetIndex);
                        }
                    }
                    myChart23.update();
                }
            }
        }
    });
    </script>
    <div style="width: 80%; margin: auto;">
        <b><hr><center>Month Wise No of Task Action Yes Purpose Yes</center><hr></b>
        <canvas id="stackedChartID24"></canvas>
    </div>
    <script>
        var myContext = document.getElementById("stackedChartID24").getContext('2d');
        var myChart24 = new Chart(myContext, {
            type: 'bar',
            data: {
                labels: [
                    <?php   $currentDate = new DateTime();
                            $financialYear = ($currentDate->format('m') >= 4) ? $currentDate->format('Y') : ($currentDate->format('Y') - 1);
                            for ($month = 4; $month <= 15; $month++) {
                                $adjustedMonth = ($month <= 12) ? $month : ($month - 12);
                                $year = ($month <= 12) ? $financialYear : ($financialYear + 1);
                                $monthName = DateTime::createFromFormat('!m', $adjustedMonth)->format('F');?>
                    "<?=$monthName?> (<?=$year?>)", <?php } ?>],
                datasets: [
                    <?php
                    $colors = array('red','blue','green','yellow','purple','orange','pink','brown','cyan','magenta','teal','lime','violet','indigo','gray');
                    $action = $this->Menu_model->get_action(); $i=0; foreach($action as $ac){
                        $acid = $ac->id; ?>
                    {
                        label: '<?=$ac->name?>',
                        backgroundColor: "<?=$colors[$i]?>",
                        data: [
                        <?php $currentDate = new DateTime();
                        $financialYear = ($currentDate->format('m') >= 4) ? $currentDate->format('Y') : ($currentDate->format('Y') - 1);
                        for ($month = 4; $month <= 15; $month++) {
                            $adjustedMonth = ($month <= 12) ? $month : ($month - 12);
                            $year = ($month <= 12) ? $financialYear : ($financialYear + 1);
                            $accont = $this->Menu_model->get_mywisetaskallbyfaypn($uid,$month,$year,$acid,$inid);?>
                            <?=$accont[0]->cont?>,<?php } ?>],
                        stack: 'Stack 0',
                    },
                    <?php $i++;} ?>
                ],
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Month Wise No of Task Action Yes Purpose Yes'
                    },
            },
            onClick: function (evt, activeElements) {
                if (activeElements && activeElements.length) {
                    const clickedDatasetIndex = activeElements[0].datasetIndex;
                    let allOthersHidden = true;
                    for (let i = 0; i < myChart24.data.datasets.length; i++) {
                        if (i !== clickedDatasetIndex && !myChart24.getDatasetMeta(i).hidden) {
                            allOthersHidden = false;
                            break;
                        }
                    }
                    if (allOthersHidden) {
                        for (let i = 0; i < myChart24.data.datasets.length; i++) {
                            myChart24.getDatasetMeta(i).hidden = false;
                        }
                    } else {
                        for (let i = 0; i < myChart24.data.datasets.length; i++) {
                            myChart24.getDatasetMeta(i).hidden = (i !== clickedDatasetIndex);
                        }
                    }
                    myChart24.update();
                }
            }
        }
    });
    </script>
    <?php
    }
    public function getcmpnlog(){
        $inid = $this->input->post('inid');
        $fdate = $this->input->post('fdate');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_cmpnlog($inid);
        $cmptd=$this->Menu_model->get_cmptd($inid,$fdate);
        $cmpptd=$this->Menu_model->get_cmpptd($inid);
        echo '<h5><b><a target="_blank" href="'.base_url().'Menu/CompanyDetails/'.$cmp[0]->cid.'">'.$cmp[0]->compname.'</a></b></h5>';
        echo '<lable><b>Current Status: '.$cmp[0]->csstatus.'</b></lable><br>';
        echo '<lable><b>Partner Type: '.$cmp[0]->pname.'</b></lable><br>';
        echo '<lable><b>Categories : '.$cmp[0]->cat1.' ' .$cmp[0]->cat2.' ' .$cmp[0]->cat3.' '.$cmp[0]->cat4.' '.$cmp[0]->cat5.'</b></lable><hr>';
        echo '<input type="hidden" id="ntstatus" name="ntstatus" value='.$cmp[0]->sid.'>';
        echo '<input type="hidden" name="cid" value='.$cmp[0]->inid.'>';
        if($cmpptd[0]->abc>0){echo '<lable><b>Total Pending Task: '.$cmpptd[0]->abc.'</b></lable></br>';}
        if($cmptd[0]->ab>0){echo '<lable><b>Total Task: '.$cmptd[0]->ab.'</b></lable></br>';}
        if($cmptd[0]->j>0){echo '<lable><b>Research: '.$cmptd[0]->j.'</b></lable></br>';}
        if($cmptd[0]->a>0){echo '<lable><b>Call: '.$cmptd[0]->a.'</b></lable></br>';}
        if($cmptd[0]->b>0){echo '<lable><b>Email: '.$cmptd[0]->b.'</b></lable></br>';}
        if($cmptd[0]->c>0){echo '<lable><b>Scheduled Meeting: '.$cmptd[0]->c.'</b></lable></br>';}
        if($cmptd[0]->d>0){echo '<lable><b>Barg in Meeting: '.$cmptd[0]->d.'</b></lable></br>';}
        if($cmptd[0]->e>0){echo '<lable><b>Whatsapp Activity: '.$cmptd[0]->e.'</b></lable></br>';}
        if($cmptd[0]->f>0){echo '<lable><b>Write MOM: '.$cmptd[0]->f.'</b></lable></br>';}
        if($cmptd[0]->g>0){echo '<lable><b>Write Proposal: '.$cmptd[0]->g.'</b></lable></br>';}
        if($cmptd[0]->h>0){echo '<lable><b>Review: '.$cmptd[0]->h.'</b></lable></br>';}
        if($cmptd[0]->r>0){echo '<lable><b>Action No: '.$cmptd[0]->r.'</b></lable></br>';}
        if($cmptd[0]->s>0){echo '<lable><b>Action Yes with Purpose No: '.$cmptd[0]->s.'</b></lable></br>';}
        if($cmptd[0]->t>0){echo '<lable><b>Action Yes with Purpose Yes: '.$cmptd[0]->t.'</b></lable></br>';}
    }
    public function getcmplogs(){
        $inid = $this->input->post('inid');
        $fdate = $this->input->post('fdate');
        $this->load->model('Menu_model');
        $logdetail=$this->Menu_model->get_logdetail($inid,$fdate);
        $i=1;
        foreach($logdetail as $logs){
            $bdid = $logs->user_id;
            $aid = $logs->actiontype_id;
            $ui=$this->Menu_model->get_userbyid($bdid);
            $ai=$this->Menu_model->get_actionbyid($aid);
            echo '<tr>';
            echo '<td>'.$i++.'</td>';
            echo '<td>'.$ui[0]->name.'</td>';
            echo '<td>'.$logs->appointmentdatetime.'</td>';
            echo '<td>'.$logs->updateddate.'</td>';
            echo '<td>'.$ai[0]->name.'</td>';
            echo '<td>'.$logs->actontaken.'</td>';
            echo '<td>'.$logs->purpose_achieved.'</td>';
            echo '<td>'.$logs->remarks.'</td>';
            echo '<td>'.$logs->mom.'</td>';
            echo '<td>'.$logs->lstid.'</td>';
            echo '<td>'.$logs->tasksid.'</td>';
            echo '<td>'.$logs->nstid.'</td>';
            echo '<tr>';
        }
    }
    public function getactionlogs(){
        $actionid = $this->input->post('actionid');
        $fdate = $this->input->post('fdate');
        $bdid = $this->input->post('bdid');
        $statusid = $this->input->post('statusid');
        $this->load->model('Menu_model');
        $logdetail=$this->Menu_model->get_actionlogs($statusid,$actionid,$fdate,$bdid);
        $i=1;
        foreach($logdetail as $logs){
            $bdid = $logs->user_id;
            $aid = $logs->actiontype_id;
            $ui=$this->Menu_model->get_userbyid($bdid);
            $ai=$this->Menu_model->get_actionbyid($aid);
            echo '<tr>';
            echo '<td>'.$i++.'</td>';
            echo '<td>'.$logs->compname.'</td>';
            echo '<td>'.$ui[0]->name.'</td>';
            echo '<td>'.$logs->appointmentdatetime.'</td>';
            echo '<td>'.$logs->updateddate.'</td>';
            echo '<td>'.$ai[0]->name.'</td>';
            echo '<td>'.$logs->actontaken.'</td>';
            echo '<td>'.$logs->purpose_achieved.'</td>';
            echo '<td>'.$logs->remarks.'</td>';
            echo '<td>'.$logs->mom.'</td>';
            echo '<td>'.$logs->lstid.'</td>';
            echo '<td>'.$logs->tasksid.'</td>';
            echo '<td>'.$logs->nstid.'</td>';
            echo '<tr>';
        }
    }
    public function getactioninfo(){
        $actionid = $this->input->post('actionid');
        $fdate = $this->input->post('fdate');
        $bdid = $this->input->post('bdid');
        $statusid = $this->input->post('statusid');
        $this->load->model('Menu_model');
        $cmptd=$this->Menu_model->get_actioninfo($actionid,$fdate,$bdid);
        if($cmptd[0]->ab>0){echo '<lable><b>Total Company: '.$cmptd[0]->abc.'</b></lable></br>';}
        if($cmptd[0]->ab>0){echo '<lable><b>Total Task: '.$cmptd[0]->ab.'</b></lable></br>';}
        if($cmptd[0]->r>0){echo '<lable><b>Action No: '.$cmptd[0]->r.'</b></lable></br>';}
        if($cmptd[0]->s>0){echo '<lable><b>Action Yes with Purpose No: '.$cmptd[0]->s.'</b></lable></br>';}
        if($cmptd[0]->t>0){echo '<lable><b>Action Yes with Purpose Yes: '.$cmptd[0]->t.'</b></lable></br>';}
    }
    public function SalesKit(){
        $user = $this->session->userdata('user');
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/SalesKit',['user'=>$user,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function NewLead(){
        $user = $this->session->userdata('user');
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $alluser=$this->Menu_model->get_user();
        $status=$this->Menu_model->get_status();
        $action=$this->Menu_model->get_action();
        $states=$this->Menu_model->get_states();
        $partner=$this->Menu_model->get_partner();
        if(!empty($user)){
            $this->load->view($dep_name.'/NewLead.php',['user'=>$user,'alluser'=>$alluser,'status'=>$status,'action'=>$action,'states'=>$states,'partner'=>$partner,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BMNewLead($bmid){
        $user = $this->session->userdata('user');
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $alluser=$this->Menu_model->get_user();
        $status=$this->Menu_model->get_status();
        $action=$this->Menu_model->get_action();
        $states=$this->Menu_model->get_states();
        $partner=$this->Menu_model->get_partner();
        $bmdata=$this->Menu_model->get_bmalldata($bmid);
        if(!empty($user)){
            $this->load->view($dep_name.'/BMNewLead.php',['bmid'=>$bmid,'bmdata'=>$bmdata,'user'=>$user,'alluser'=>$alluser,'status'=>$status,'action'=>$action,'states'=>$states,'partner'=>$partner,'uid'=>$uid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function addplantask(){
        $tptime = $this->input->post('tptime');
        $ttype = $this->input->post('ttype');
        $pdate = $this->input->post('pdate');
        $uid= $this->input->post('ntuid');
        $ptime= $this->input->post('ptime');
        $inid= $this->input->post('inid');
        $ntaction= $this->input->post('ntaction');
        $ntstatus= $this->input->post('ntstatus');
        $ntppose= $this->input->post('ntppose');
        $this->load->model('Menu_model');
        $id=$this->Menu_model->add_plan($pdate,$uid,$ptime,$inid,$ntaction,$ntstatus,$ntppose,$ttype,$tptime);
        redirect('Menu/TaskPlanner2/'.$pdate);
    }
    
    public function addplantask1(){
        // echo "<pre>";
        // print_r($_POST);
        // die;
        $this->load->library('session');
        $selectby = $this->input->post('selectby');
        $tptime = $this->input->post('tptime');
        $ttype = $this->input->post('ttype');
        $pdate = $this->input->post('pdate');
        $uid= $this->input->post('ntuid');
        $ptime= $this->input->post('ptime');
        $inid= $this->input->post('inid');
        $ntaction= $this->input->post('ntaction');
        $ntstatus= $this->input->post('ntstatus');
        $ntppose= $this->input->post('ntppose');
        $this->load->model('Menu_model');
        $id=$this->Menu_model->add_plan1($pdate,$uid,$ptime,$inid,$ntaction,$ntstatus,$ntppose,$ttype,$tptime,$selectby);
        $this->session->set_flashdata('success_message','Task Plan Successfully');
        redirect('Menu/TaskPlanner2/'.$pdate);
    }
    public function addtask(){
        $date= $this->input->post('ntdate');
        $uid= $this->input->post('ntuid');
        $ntinid= $this->input->post('ntinid');
        $ntaction= $this->input->post('ntaction');
        $ntstatus= $this->input->post('ntstatus');
        $ntppose= $this->input->post('ntppose');
        $ntnextaction= $this->input->post('ntnextaction');
        $this->load->model('Menu_model');
        $id=$this->Menu_model->add_task($uid,$ntinid,$ntaction,$ntstatus,$ntppose,$ntnextaction,$date);
        redirect('Menu/Dashboard');
    }
    public function addcompany(){
        $uid= $this->input->post('uid');
        $compname= $this->input->post('compname');
        $website= $this->input->post('website');
        $country= $this->input->post('country');
        $city= $this->input->post('city');
        $state= $this->input->post('state');
        $draft= $this->input->post('draft');
        $address= $this->input->post('address');
        $ctype= $this->input->post('ctype');
        $budget= $this->input->post('budget');
        $compconname= $this->input->post('compconname');
        $emailid= $this->input->post('emailid');
        $phoneno= $this->input->post('phoneno');
        $draftop= $this->input->post('draftop');
        $designation= $this->input->post('designation');
        $top_spender= $this->input->post('top_spender');
        $upsell_client= $this->input->post('upsell_client');
        $focus_funnel= $this->input->post('focus_funnel');
        $key_company=$this->input->post('key_company');
        $potential_company=$this->input->post('potential_company');
        // $linkedin=$this->input->post('linkedin');
        // $facebook=$this->input->post('facebook');
        // $youtube=$this->input->post('youtube');
        // $instagram=$this->input->post('instagram');
        $clusterid        =   $this->input->post('cluster');
        $cstatusid      =   $this->input->post('cstatusid');
        $openrpem       =   $this->input->post('openrpem');
        $reachout       =   $this->input->post('reachout');
        $tentative      =   $this->input->post('tentative');
        $positivenap    =   $this->input->post('positivenap');
        $verypositive   =   $this->input->post('verypositive');
        $closure        =   $this->input->post('closure');
        // $openrpem,$reachout,$verypositive,$positivenap,$tentative,$closure,$clusterid,$cstatusid
        // `open`, `reachout`, `positive`, `positivenap`, `tentative`, `closure`, `cluster_id`
        $this->load->model('Menu_model');
        $id=$this->Menu_model->submit_company($uid,$compname, $website, $country, $city, $state, $draft, $address, $ctype, $budget, $compconname, $emailid, $phoneno, $draftop, $designation, $top_spender,$upsell_client,$focus_funnel,$key_company,$potential_company,$openrpem,$reachout,$verypositive,$positivenap,$tentative,$closure,$clusterid,$cstatusid);
        redirect('Menu/Dashboard');
    }
    public function addbmcompany(){
        $this->load->library('session');
        $uid= $this->input->post('uid');
        $bmid= $this->input->post('bmid');
        $cid= $this->input->post('cid');
        $ccid= $this->input->post('ccid');
        $inid= $this->input->post('inid');
        $tid= $this->input->post('tid');
        $compname= $this->input->post('compname');
        $website= $this->input->post('website');
        $country= $this->input->post('country');
        $city= $this->input->post('city');
        $state= $this->input->post('state');
        $draft= $this->input->post('draft');
        $address= $this->input->post('address');
        $ctype= $this->input->post('ctype');
        $budget= $this->input->post('budget');
        $compconname= $this->input->post('compconname');
        $emailid= $this->input->post('emailid');
        $phoneno= $this->input->post('phoneno');
        $draftop= $this->input->post('draftop');
        $designation= $this->input->post('designation');
        $top_spender= $this->input->post('top_spender');
        $upsell_client= $this->input->post('upsell_client');
        $focus_funnel= $this->input->post('focus_funnel');
        $key_client= $this->input->post('key_client');
        $potential_company = $this->input->post('potential_company');
        $cluster_id= $this->input->post('cluster');
        $contact_type = $this->input->post('contact_type');
        $this->load->model('Menu_model');
        // dd($_POST);
        // $id=$this->Menu_model->submit_bmcompany($uid,$compname, $website, $country, $city, $state, $draft, $address, $ctype, $budget, $compconname, $emailid, $phoneno, $draftop, $designation, $top_spender,$upsell_client,$focus_funnel,$cid,$ccid,$inid,$tid,$bmid);
        $id=$this->Menu_model->submit_bmcompany($uid,$compname, $website, $country, $city, $state, $draft, $address, $ctype, $budget, $compconname, $emailid, $phoneno, $draftop, $designation, $top_spender,$upsell_client,$focus_funnel,$cid,$ccid,$inid,$tid,$bmid,$key_client,$potential_company,$cluster_id,$contact_type);
        $this->session->set_flashdata('success_message','Lead Updated SuccessFully !');
        redirect('Menu/Dashboard');
    }
    public function manageuser(){
        $uid= $this->input->post('uid');
        $user_id= $this->input->post('usid');
        $name= $this->input->post('name');
        $username= $this->input->post('username');
        $password= $this->input->post('password');
        $email= $this->input->post('email');
        $phoneno= $this->input->post('phoneno');
        $active= $this->input->post('active');
        $this->load->model('Menu_model');
        $id=$this->Menu_model->manage_user($user_id,$name,$username,$password,$email,$phoneno,$active);
        redirect('Menu/BDDetail/'.$uid);
    }
    public function PrimaryContact($cid){
        $user = $this->session->userdata('user');
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $cc=$this->Menu_model->get_ccdbypid($cid);
        if(!empty($user)){
            $this->load->view($dep_name.'/primarycontact', ['uid'=>$uid,'cc'=>$cc,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function AlertsPage(){
        $user = $this->session->userdata('user');
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/AlertsPage', ['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function DayAlerts(){
        $user = $this->session->userdata('user');
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/DayAlerts', ['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FunnalAlerts(){
        $user = $this->session->userdata('user');
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/FunnalAlerts', ['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function TaskAlerts(){
        $user = $this->session->userdata('user');
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/TaskAlerts', ['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function OperationAlerts(){
        $user = $this->session->userdata('user');
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/OperationAlerts', ['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function ResponsibilityAlerts(){
        $user = $this->session->userdata('user');
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/ResponsibilityAlerts', ['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RegionalOwnershipAlerts(){
        $user = $this->session->userdata('user');
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/RegionalOwnershipAlerts', ['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function NotificationPage(){
        $user = $this->session->userdata('user');
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/NotificationPage', ['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function EditContact($id,$cid){
        $user = $this->session->userdata('user');
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $cc=$this->Menu_model->get_contactbyid($id);
        if(!empty($user)){
            $this->load->view($dep_name.'/editcontact', ['id'=>$id,'cid'=>$cid,'uid'=>$uid,'cc'=>$cc,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function EditCompany($cid){
        $user = $this->session->userdata('user');
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $cc=$this->Menu_model->get_cdbyid($cid);
        $states=$this->Menu_model->get_states();
        if(!empty($user)){
            $this->load->view($dep_name.'/EditCompany', ['cid'=>$cid,'states'=>$states,'uid'=>$uid,'cc'=>$cc,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function Muser(){
        $user_id= $this->input->post('user_id');
        $this->load->model('Menu_model');
        $result=$this->Menu_model->get_userbyid($user_id);
        echo json_encode($result);
    }
    public function binactivepstc(){
        $user_id= $this->input->post('user_id');
        $this->load->model('Menu_model');
        $result=$this->Menu_model->get_userbyid($user_id);
        echo json_encode($result);
    }
    public function adminpopup(){
        $ur_id= $this->input->post('ur_id');
        $this->load->model('Menu_model');
        echo $result=$this->Menu_model->get_adminpopup($ur_id);
    }
    public function pstpopup(){
        $ur_id= $this->input->post('ur_id');
        $this->load->model('Menu_model');
        echo $result=$this->Menu_model->get_pstpopup($ur_id);
    }
    public function bdpopup(){
        $ur_id= $this->input->post('ur_id');
        $this->load->model('Menu_model');
        echo $result=$this->Menu_model->get_bdpopup($ur_id);
    }
    public function opalsms(){
        $ur_id= $this->input->post('ur_id');
        $this->load->model('Menu_model');
        echo $result=$this->Menu_model->get_opalsms($ur_id);
    }
    public function nitisms(){
        $ur_id= $this->input->post('ur_id');
        $this->load->model('Menu_model');
        echo $result=$this->Menu_model->get_nitisms($ur_id);
    }
    public function cctd(){
        $tid= $this->input->post('tid');
        $this->load->model('Menu_model');
        $result=$this->Menu_model->get_cctd($tid);
        echo json_encode($result);
    }
    public function cctd_prupose(){
        $purposeId= $this->input->post('purposeId');
//echo $purposeId;
        $this->load->model('Menu_model');
        $result=$this->Menu_model->get_purposeNameById($purposeId);
        echo $result;
    }
    public function inidbycid(){
        $cmpid= $this->input->post('cmpid');
        $this->load->model('Menu_model');
        $result=$this->Menu_model->get_inidbycid($cmpid);
        echo json_encode($result);
    }
    public function rpstc(){
        $pstid = $this->input->post('pstid');
        $bdid = $this->input->post('bdid');
        $this->load->model('Menu_model');
        $result=$this->Menu_model->get_rpstc($pstid,$bdid);
        echo json_encode($result);
    }
    public function alpopup(){
        $user = $this->session->userdata('user');
        $uid = $user['user_id'];
        $this->load->model('Menu_model');
        $result=$this->Menu_model->get_alpopup($uid);
        echo $result;
    }
    public function ccctd(){
        $tid= $this->input->post('tid');
        $this->load->model('Menu_model');
        $result=$this->Menu_model->get_ccctd($tid);
        echo json_encode($result);
    }
    public function indtime(){
        $tid= $this->input->post('tid');
        $this->load->model('Menu_model');
        $result=$this->Menu_model->in_dtime($tid);
        echo json_encode($result);
    }
    public function bmtd(){
        $id= $this->input->post('id');
        $this->load->model('Menu_model');
        $result=$this->Menu_model->get_bmalldata($id);
        echo json_encode($result);
    }
    public function ccitblall(){
        $tid= $this->input->post('tid');
        $this->load->model('Menu_model');
        $result=$this->Menu_model->get_ccitblall($tid);
        echo json_encode($result);
    }
    public function CompanyDetails($cid){
        if(isset($_GET['tid'])){$tid = $_GET['tid'];}
        else{$tid=0;}
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $status=$this->Menu_model->get_status();
        $cd=$this->Menu_model->get_cdbyid($cid);
        $ccd=$this->Menu_model->get_ccdbyid($cid);
        $pccd=$this->Menu_model->get_ccdbypid($cid);
        $init=$this->Menu_model->get_initcallbyid($cid);
        
        $ciid = $init[0]->id;
        $sid = $init[0]->cstatus;
        $mainbd = $init[0]->mainbd;
        
        $userdetails = $this->Menu_model->get_userbyid($mainbd);
        $apst = $init[0]->apst;
        if(empty($apst)){
            $apst =$userdetails[0]->pst_co;
        }
        $tblc = $this->Menu_model->get_tblcalleventsbyid($ciid);
        $statusCount = $this->Menu_model->getStatusCount($ciid);
        $merged = array_merge($status, $statusCount);
        $countObject = array_pop($merged);
        foreach ($merged as $item) {
            if (isset($countObject->{$item->name})) {
                $item->count = $countObject->{$item->name};
            }
        }
      
        $tbllast=$this->Menu_model->get_tblcalleventsbyid($ciid);
        $aid = $tbllast[0]->actiontype_id;
        $cstatus=$this->Menu_model->get_statusbyid($sid);
        $action=$this->Menu_model->get_actionbyid($aid);
        if(!empty($user)){
            $this->load->view($dep_name.'/CompanyDetails.php',['pccd'=>$pccd,'ciid'=>$ciid,'tid'=>$tid,'uid'=>$uid,'user'=>$user,'cd'=>$cd,'ccd'=>$ccd,'init'=>$init,'tblc'=>$tblc,'status'=>$status,'tbllast'=>$tbllast,'status'=>$status,'action'=>$action,'tbllast'=>$tbllast,'cstatus'=>$cstatus,'sid'=>$sid,'mainbd'=>$mainbd,'apst'=>$apst,'merged'=>$merged]);
        }else{
            redirect('Menu/main');
        }
    }
     public function CompanyDetails1($cid){
        if(isset($_GET['tid'])){$tid = $_GET['tid'];}
        else{$tid=0;}
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $status=$this->Menu_model->get_status();
        $cd=$this->Menu_model->get_cdbyid($cid);
        $ccd=$this->Menu_model->get_ccdbyid($cid);
        $pccd=$this->Menu_model->get_ccdbypid($cid);
        $init=$this->Menu_model->get_initcallbyid($cid);
        $ciid = $init[0]->id;
        $sid = $init[0]->cstatus;
        $mainbd = $init[0]->mainbd;
        $apst = $init[0]->apst;
        $tblc = $this->Menu_model->get_tblcalleventsbyid($ciid);
        $tblc_new = $this->Menu_model->get_tblcalleventsbyidNew($ciid);
        // echo "<pre>";
        // print_r($tblc_new);
        // echo "SELECT * FROM tblcallevents WHERE cid_id='$ciid' AND is_new=1 and cast(updateddate as DATE)>'2023-04-01' ORDER BY tblcallevents.updateddate DESC";
        // die;
        $tbllast=$this->Menu_model->get_tblcalleventsbyid($ciid);
        $aid = $tbllast[0]->actiontype_id;
        $cstatus=$this->Menu_model->get_statusbyid($sid);
        $action=$this->Menu_model->get_actionbyid($aid);
        if(!empty($user)){
            $this->load->view($dep_name.'/CompanyDetails1',['tblc_new'=>$tblc_new,'pccd'=>$pccd,'ciid'=>$ciid,'tid'=>$tid,'uid'=>$uid,'user'=>$user,'cd'=>$cd,'ccd'=>$ccd,'init'=>$init,'tblc'=>$tblc,'status'=>$status,'tbllast'=>$tbllast,'status'=>$status,'action'=>$action,'tbllast'=>$tbllast,'cstatus'=>$cstatus,'sid'=>$sid,'mainbd'=>$mainbd,'apst'=>$apst]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDUFunnel($bdid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDUFunnel',['uid'=>$uid,'user'=>$user,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    public function BDFunnel(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDFunnel',['uid'=>$uid,'user'=>$user]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FunnelReport(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata=$this->Menu_model->get_funnelreport();
        if(!empty($user)){
            $this->load->view($dep_name.'/FunnelReport',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function Proposal(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata=$this->Menu_model->get_proposal();
        if(!empty($user)){
            $this->load->view($dep_name.'/Proposal',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function Synopsis(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata=$this->Menu_model->get_synopsis();
        if(!empty($user)){
            $this->load->view($dep_name.'/Synopsis',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FinalSConversion($bdid,$sd,$ed,$fsid,$ssid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $scdata = $this->Menu_model->final_scon3($bdid,$sd,$ed,$fsid,$ssid);
        if(!empty($user)){
            $this->load->view($dep_name.'/FinalSConversion',['uid'=>$uid,'user'=>$user,'scdata'=>$scdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FinalSConversionByTeam($bdid,$sd,$ed,$fsid,$ssid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $scdata = $this->Menu_model->final_scon3_inPST($bdid,$sd,$ed,$fsid,$ssid);
        if(!empty($user)){
            $this->load->view($dep_name.'/FinalSConversionByTeam',['uid'=>$uid,'user'=>$user,'scdata'=>$scdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FinalSConversionByClusterTeam($bdid,$sd,$ed,$fsid,$ssid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $scdata = $this->Menu_model->final_scon3_inCluster($bdid,$sd,$ed,$fsid,$ssid);
        if(!empty($user)){
            $this->load->view($dep_name.'/FinalSConversionByClusterTeam',['uid'=>$uid,'user'=>$user,'scdata'=>$scdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FinalPSTSConversion($bdid,$sd,$ed,$fsid,$ssid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $scdata = $this->Menu_model->final_pstscon3($bdid,$sd,$ed,$fsid,$ssid);
        if(!empty($user)){
            $this->load->view($dep_name.'/FinalPSTSConversion',['uid'=>$uid,'user'=>$user,'scdata'=>$scdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function FinalMySConversion($bdid,$sd,$ed,$fsid,$ssid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $scdata = $this->Menu_model->final_myscon3($bdid,$sd,$ed,$fsid,$ssid);
        if(!empty($user)){
            $this->load->view($dep_name.'/FinalMySConversion',['uid'=>$uid,'user'=>$user,'scdata'=>$scdata]);
        }else{
            redirect('Menu/main');
        }
    }
    public function Conversion($bdid,$tdate,$code1,$code2,$ab){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/Conversion',['uid'=>$uid,'user'=>$user,'code1'=>$code1,'code2'=>$code2,'tdate'=>$tdate,'ab'=>$ab,'bdid'=>$bdid]);
        }else{
            redirect('Menu/main');
        }
    }
    // public function Conversion($bdid,$tdate,$code1,$code2){
    //     $user = $this->session->userdata('user');
    //     $data['user'] = $user;
    //     $uid = $user['user_id'];
    //     $uyid =  $user['type_id'];
    //     $this->load->model('Menu_model');
    //     $dt=$this->Menu_model->get_utype($uyid);
    //     $dep_name = $dt[0]->name;
    //     if(!empty($user)){
    //         $this->load->view($dep_name.'/Conversion',['uid'=>$uid,'user'=>$user,'code1'=>$code1,'code2'=>$code2,'tdate'=>$tdate,'bdid'=>$bdid]);
    //     }else{
    //         redirect('Menu/main');
    //     }
    // }
    public function Handover($cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $mdata=$this->Menu_model->get_cdbyidwin($cid);
        $cname = $mdata[0]->compname;
        $spd=$this->Menu_model->get_spdforhandover($cname);
        if(!$spd){$spd=0;}
        $md = $mdata[0];
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/handover',['spd'=>$spd,'cid'=>$cid,'uid'=>$uid,'user'=>$user,'md'=>$md]);
        }else{
            redirect('Menu/main');
        }
    }
    public function handEdit($cid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $mdata=$this->Menu_model->get_clientbyid($cid);
        $mdc=$this->Menu_model->get_clientacbyid($cid);
        $spdc=$this->Menu_model->get_schoolbycid($cid);
        $md = $mdata[0];
        $mdc = $mdc[0];
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/handEdit',['spdc'=>$spdc,'cid'=>$cid,'uid'=>$uid,'user'=>$user,'md'=>$md,'mdc'=>$mdc]);
        }else{
            redirect('Menu/main');
        }
    }
    public function getcpmdetail(){
        $cid= $this->input->post('cid');
        $this->load->model('Menu_model');
        $result=$this->Menu_model->get_cdbyid($cid);
        $inida = $this->Menu_model->get_initcallbyid($cid);
        $inid = $inida[0]->id;
        $mainbd = $inida[0]->mainbd;
        $apst = $inida[0]->apst;
        if($mainbd){$mbd = $this->Menu_model->get_userbyid($mainbd);$bdname=$mbd[0]->name;}else{$bdname='NO';}
        if($apst){$pst = $this->Menu_model->get_userbyid($apst);$pstname=$pst[0]->name;}else{$pstname='NO';}
        $mom = $this->Menu_model->get_tblbycidmom($inid);
        $priority = $this->Menu_model->get_tblbypriority($inid);
        if($priority){$priority=$priority[0]->priority;}else{$priority='';}
        foreach($result as $d){
          $pid = $d->partnerType_id;
          if($pid){$p = $this->Menu_model->get_partnerbyid($pid);$partner=$p[0]->name;}else{$partner='NO';}
           $mdate = $mom[0]->updateddate;
           $datet = date('Y-m-d H:i:s');
           $atimed = $this->Menu_model->timediff($mdate, $datet);
           echo  $data = '<p> Company ID : '.$cid.'</p>
                         <p> Priority : '.$priority.'</p>
                         <p> BD Name : '.$bdname.'</p>
                         <p> MOM DATE : '.$mom[0]->updateddate.'</p>
                         <p> PST Assign Pending From : '.$atimed.'</p>
                         <p> PST Name : '.$pstname.'</p>
                         <p> Created Date : '.$d->createddate.'</p>
                         <p> Partner Type : '.$partner.'</p>
                         <p> Draft : '.$d->draft.'</p>
                         <p> Budget : '.$d->budget.'</p>
                         <p> Address : '.$d->address.'</p>
                         <p> City : '.$d->city.'</p>
                         <p> State : '.$d->state.'</p>
                         <p> Country : '.$d->country.'</p>
                         <p> Website : '.$d->website.'</p>
                         <p> MOM : '.$mom[0]->mom.'</p>';
        }
        return $data;
    }
    public function CreateRequest(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $client=$this->Menu_model->get_client();
        $fannal=$this->Menu_model->get_fannal($uid);
        if(!empty($user)){
        $this->load->view($dep_name.'/createrequest', ['uid'=>$uid,'dep'=>$dt, 'user'=>$user,'client'=>$client,'fannal'=>$fannal]);
        } else {
            redirect('Menu/main');
        }
    }
    public function store_location() {
        $uid = $_POST['ur_id'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $this->load->model('Menu_model');
        $this->Menu_model->s_location($uid,$latitude,$longitude);
    }
    public function bdrequest(){
        $uid = $_POST['uid'];
        $ctype = $_POST['ctype'];
        $targetd = $_POST['targetd'];
        $request_type = $_POST['request_type'];
        $remark = $_POST['remark'];
        $tyschool = $_POST['tyschool'];
        $noschool = $_POST['noschool'];
        $location = $_POST['location'];
        $idetype = $_POST['idetype'];
        $sletter = $_POST['sletter'];
        $dmletter = $_POST['dmletter'];
        $svalidation = $_POST['svalidation'];
        $cname = $_POST['cname'];
        if($ctype=='On Board Client'){$ctype=1;}
        else{$ctype=2;}
        $filname = $_FILES['filname']['name'];
        $uploadPath = 'uploads/day/';
        $this->load->model('Menu_model');
        $ngoletter = $this->Menu_model->uploadfile($filname, $uploadPath);
        $this->load->model('Menu_model');
        $id = $this->Menu_model->submit_bdrequest($ctype,$uid,$targetd,$request_type,$remark,$cname,$tyschool,$noschool,$location,$idetype,$ngoletter,$sletter,$dmletter,$svalidation);
        redirect('Menu/Dashboard');
    }
     //Assign Task to user by higher authorities
/*
     public function AssignTask(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $role = $this->db->select('*')->from('user_type')->get()->result();
        $this->load->view($dep_name.'/AssignTask',['user'=>$user,'uid'=>$uid,'role' => $role]);
    }
*/
    //Select user according to role
    public function getRoleUser(){
        $selectedOption= $this->input->post('selectedOption');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        // var_dump($user['type_id']); exit;
        if($user['type_id'] == 2){
            $user = $this->db->select('*')->from('user_details')->where(['type_id'=> $selectedOption, 'status'=>'active','admin_id'=>$uid])->or_where('aadmin', $uid)->or_where('badmin', $uid)->get()->result();
        }
        if($user['type_id'] == 4){
            if($selectedOption == 3){
                $user = $this->db->select('*')->from('user_details')->where(['type_id'=> $selectedOption, 'status'=>'active','badmin'=>$uid])->get()->result();
            }else{
                $user = $this->db->select('*')->from('user_details')->where(['type_id'=> $selectedOption, 'status'=>'active','aadmin'=>$uid])->get()->result();
            }
        }
        // echo $this->db->last_query(); exit;
        echo  $data = '<option value="">Select User</option>';
        foreach($user as $d){
            echo  $data = '<option value='.$d->user_id.'>'.$d->name.'</option>';
        }
    }
    //Select city according to user for assigning task
    public function getUserCity(){
        $user= $this->input->post('user');
        $city = $this->db->select('Distinct(company_master.city)')->from('tblcallevents')
                    ->join('init_call','init_call.id=tblcallevents.cid_id')
                    ->join('company_master','company_master.id=init_call.cmpid_id')
                    ->where(['user_id'=> $user])
                    ->where_not_in('company_master.city',['', 'NA', 'blank', '<blank>'])->get()->result();
                    $cityCount = count($city);
                    $data = [
                        'city' => $city,
                        'cityCount' => $cityCount
                    ];
        echo json_encode($data);
    }
    public function getUserPartner(){
        $user= $this->input->post('user');
        $cities = $this->input->post('cities');
        $partner = $this->db->select('Distinct(company_master.partnerType_id),partner_master.name')->from('tblcallevents')
                    ->join('init_call','init_call.id=tblcallevents.cid_id')
                    ->join('company_master','company_master.id=init_call.cmpid_id')
                    ->join('partner_master','partner_master.id = company_master.partnerType_id')
                    ->where(['user_id'=> $user]);
        if($cities != null){
            $partner->where_in('company_master.city', $cities);
        }
        //  echo $this->db->last_query(); exit;
        $partner =$this->db->get()->result();
        $partnerCount = count($partner);
                    $data = [
                        'partner' => $partner,
                        'partnerCount' => $partnerCount
                    ];
        echo json_encode($data);
    }
    public function getcmpbylstatus2(){
        $user= $this->input->post('user');
        $cities = $this->input->post('cities');
        $partner = $this->input->post('partner');
        $option1 = $this->input->post('option1');
        $option2 = $this->input->post('option2');
        $days = $this->input->post('days');
        $previous_status = $this->input->post('previous_status');
        $current_status = $this->input->post('current_status');
        $category = $this->input->post('category');
        $purpose = $this->input->post('purpose');
        $action = $this->input->post('action');
        $task_action = $this->input->post('task_action');
        $daysbyplandate = $this->input->post('daysbyplandate');
        $workbyothers = $this->input->post('workbyothers');
        $daysbyplandatewithtask = $this->input->post('daysbyplandatewithtask');
        // echo $admid; exit;
        $company = $this->db->select('Distinct(company_master.compname),company_master.id as cid, cast(updateddate as DATE) as updateddate,tblcallevents.actontaken,tblcallevents.purpose_achieved,tblcallevents.actiontype_id,company_master.partnerType_id,user_id,tblcallevents.plandt,init_call.mainbd,init_call.id inid')
                            ->from('tblcallevents')
                            ->join('init_call','init_call.id=tblcallevents.cid_id')
                            ->join('company_master','company_master.id=init_call.cmpid_id')
                            ->where(['user_id'=> $user])
                            ->where_in('company_master.city', $cities)
                            ->where_in('company_master.partnerType_id', $partner);
            if($days == "8"){
                $company->where("DATEDIFF(CURDATE(), updateddate) < 8");
            }if($days == "15"){
                $company->where("DATEDIFF(CURDATE(), updateddate) > 8");
                $company->where("DATEDIFF(CURDATE(), updateddate) < 15");
            }if($days == "more"){
                $company->where("DATEDIFF(CURDATE(), updateddate) > 15");
            }
            if($previous_status != ""){
                $company->where('init_call.lstatus',$previous_status);
            }
            if($current_status !=""){
                $company->where('init_call.cstatus',$current_status);
            }if ($category != "") {
                $company->where('init_call.' . $category, 'yes');
            }if($option1 == "actionPlanned" && $purpose != ""){
                $company->where('tblcallevents.purpose_achieved',        $purpose);
            }if($option1 == "actionPlanned" && $action != ""){
                $company->where('tblcallevents.actontaken',$action);
            }if($task_action != ""){
                $company->where('tblcallevents.actiontype_id',$task_action);
            }if($cities == null){
                $company->where_not_in('company_master.city',['', 'NA', 'blank', '<blank>']);
            }if($partner == null){
                $company->group_by('company_master.partnerType_id');
            }
            if($daysbyplandate == "8" || $daysbyplandatewithtask == "8"){
                $company->where("DATEDIFF(CURDATE(), tblcallevents.plandt) < 8");
            }if($daysbyplandate == "15" || $daysbyplandatewithtask == "8"){
                $company->where("DATEDIFF(CURDATE(), tblcallevents.plandt) > 8");
                $company->where("DATEDIFF(CURDATE(), tblcallevents.plandt) < 15");
            }if($daysbyplandate == "more" || $daysbyplandatewithtask == "8"){
                $company->where("DATEDIFF(CURDATE(), tblcallevents.plandt) > 15");
            }if($workbyothers !="" && $workbyothers=="bd"){
                $company->where(["init_call.mainbd" => $user, 'nextCFID!=' => 0]);
                $company->where('init_call.apst IS NOT null');
            }if($workbyothers !="" && $workbyothers=="pst"){
                $company->where('init_call.apst',$user);
            }
            if($workbyothers !="" && $workbyothers=="admin"){
                $company->or_where_in('user_id',['45']);
            }
            $company->group_by('company_master.compname');
            $company->group_by('company_master.city');
        $company = $this->db->get()->result();
                    // echo $this->db->last_query(); exit;
        // echo  $data = '<option value="">Select company</option>';
        // foreach($company as $d){
        //     echo  $data = '<option value='.$d->cid.'>'.$d->compname.'</option>';
        // }
        $companyCount = count($company);
        $data = [
            'company' => $company,
            'companyCount' => $companyCount
        ];
        echo json_encode($data);
    }
    //Assign Daily Task
/*
    public function dailyTaskAssign(){
        $user = $this->session->userdata('user');
        $company = $this->input->post('company');
        $user = $this->input->post('user');
        $rmplandt = $this->input->post('plandate');
        $tasktimeplan = $this->input->post('tasktimeplan');
        $task = $this->input->post('atask');
        $status = $this->input->post('current_status');
        $targetstatus = $this->input->post('targetstatus');
        $targetdate = $this->input->post('targetDate');
        $purpose = $this->input->post('ntppose');
        $i = 0;
        $action = $this->db->select('*')->from('action')->where('id',$task)->get()->row();
        // var_dump($i  + $action->yest); exit;
        foreach($company as $c){
            $newTime = date('H:i:s', strtotime($tasktimeplan . '+'.$i.'minutes'));
            $date = $rmplandt.'T'.$newTime;
            $data =[
                'rmplandt'              => $rmplandt,
                'cid_id'                => $c,
                'user_id'               => $user,
                'purpose_achieved'      => "no",
                'actontaken'            => "",
                'pstassign'             => "",
                'assignedto_id'         => $user,
                'actiontype_id'         => $task,
                'updateddate'          =>  $date,
                'date'                  => $date,
                'fwd_date'              => $date,
                'appointmentdatetime'   => $date,
                'plandt'                => $date,
                'plan'                  => '1',
                'status_id'             =>  $status,
                'lastCFID'              => 0,
                'nextCFID'              => 0,
                'targetstatus'          => $targetstatus,
                'targetdate'            => $targetdate,
                'purpose_id'            => $purpose,
                'remarks'               => ""
            ];
            $i = $i + $action->yest;
            $this->db->insert('tblcallevents',$data);
            // echo $this->db->last_query();
        }
        //  exit;
        redirect('Menu/Dashboard');
    }
*/
/*****task assign function modification -ABHishek***/
 public function dailyTaskAssign(){
        $this->load->model('Menu_model');
        $user = $this->session->userdata('user');
        $company = $this->input->post('company');
        $user = $this->input->post('user');
        $rmplandt = $this->input->post('plandate');
        $tasktimeplan = $this->input->post('tasktimeplan');
        $task = $this->input->post('atask');
        $status = $this->input->post('current_status');
        $targetstatus = $this->input->post('targetstatus');
        $targetdate = $this->input->post('targetDate');
        $purpose = $this->input->post('ntppose');
        //echo"<pre>company ";print_r($company);exit;
        
        $i = 0;
        $action = $this->db->select('*')->from('action')->where('id',$task)->get()->row();
        // var_dump($i  + $action->yest); exit;
        foreach($company as $c){
            $initDetails=$this->Menu_model->get_initbyid($c);
            $cid = $initDetails[0]->cmpid_id;
            $compDetails=$this->Menu_model->get_cdbyid($cid);
            $compName = $compDetails[0]->compname;
            $contactDetails=$this->Menu_model->get_ccdbyid($cid);
            $ccid = $contactDetails[0]->id;
            //echo"<pre>contactDetails ";print_r($contactDetails);exit;
            $newTime = date('H:i:s', strtotime($tasktimeplan . '+'.$i.'minutes'));
            $date = $rmplandt.'T'.$newTime;
            $data =[
                'rmplandt'              => $rmplandt,
                'cid_id'                => $c,
                'user_id'               => $user,
                'purpose_achieved'      => "no",
                'actontaken'            => "",
                'pstassign'             => "",
                'assignedto_id'         => $user,
                'actiontype_id'         => $task,
                'updateddate'          =>  $date,
                'date'                  => $date,
                'fwd_date'              => $date,
                'appointmentdatetime'   => $date,
                'plandt'                => $date,
                'plan'                  => '1',
                'status_id'             =>  $status,
                'lastCFID'              => 0,
                'nextCFID'              => 0,
                'targetstatus'          => $targetstatus,
                'targetdate'            => $targetdate,
                'purpose_id'            => $purpose,
                'remarks'               => ""
            ];
            $this->db->insert('tblcallevents',$data);
            $tid = $this->db->insert_id();
            //echo $tid;exit;
            if($task==3 || $task==4){
                $data2 = [
                    'storedt' => $date,
                    'user_id' => $user,
                    'cid'     => $cid,
                    'ccid'    => $ccid,
                    'inid'    => $c,
                    'tid'     => $tid,  
                    'company_name' => $compName
                ];
                $this->db->insert('barginmeeting',$data2);
            }
            $i = $i + $action->yest;
           
        }
        //echo"<pre>data ";print_r($data);exit;
        //  exit;
        redirect('Menu/Dashboard');
    }
    
    
     //Assign Task to user by higher authorities
     public function AssignTask(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $role = $this->db->select('*')->from('user_type')->get()->result();
        //echo"<pre>role ";print_r($role);exit;
        $this->load->view($dep_name.'/AssignTask',['user'=>$user,'uid'=>$uid,'role' => $role]);
    }
/*******Assign task ****/
    public function AnnualReviewComp(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $role = $this->db->select('*')->from('user_type')->get()->result();
        $this->load->view($dep_name.'/AnnualReviewComp',['user'=>$user,'uid'=>$uid,'role' => $role]);
    }
    public function getAnuualRevirewCmp(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $stid = $this->input->post('stid');
        // var_dump($stid); exit;
        $uyid =  $user['type_id'];
        // if($stid == 'reject'){
        //     $rej_cmp = $this->db->select('*')->from('annualreviewtarget')->where(['is_approved' => 'Reject','user_id'=>$uid])->get()->row();
        // }
        if($uyid == 9){
            if($stid == '0'){
                $query=$this->db->query("SELECT *,init_call.id inid from init_call Left JOIN company_master ON company_master.id=init_call.cmpid_id where mainbd='$uid'");
            }else{
                $query=$this->db->query("SELECT *,init_call.id inid from init_call Left JOIN company_master ON company_master.id=init_call.cmpid_id where cstatus='$stid' and mainbd='$uid'");
            }
        }
        if($uyid == 4){
            if($stid == '0'){
                $query=$this->db->query("SELECT *,init_call.id inid from init_call Left JOIN company_master ON company_master.id=init_call.cmpid_id where apst='$uid'");
            }else{
                $query=$this->db->query("SELECT *,init_call.id inid from init_call Left JOIN company_master ON company_master.id=init_call.cmpid_id where cstatus='$stid' and apst='$uid'");
            }
        }
        if($uyid == 3){
            if($stid == '0'){
                if($uid == 100194){
                    $query = $this->db->query("SELECT *,init_call.id inid from init_call Left JOIN company_master ON company_master.id=init_call.cmpid_id where mainbd = '100194' or apst=100194 AND insidebd=100194");
                }else{
                    $query=$this->db->query("SELECT *,init_call.id inid from init_call Left JOIN company_master ON company_master.id=init_call.cmpid_id where mainbd='$uid' or apst='$uid' or insidebd='$uid'");
                }
            }else{
                $query=$this->db->query("SELECT *,init_call.id inid from init_call Left JOIN company_master ON company_master.id=init_call.cmpid_id where cstatus='$stid' and mainbd='$uid' or apst='$uid' or insidebd='$uid'");
            }
        }
        if($uyid == 13){
            if($stid == '0'){
                $query=$this->db->query("SELECT *,init_call.id inid from init_call Left JOIN company_master ON company_master.id=init_call.cmpid_id where mainbd='$uid' or apst='$uid' or insidebd='$uid'");
            }else{
                $query=$this->db->query("SELECT *,init_call.id inid from init_call Left JOIN company_master ON company_master.id=init_call.cmpid_id where cstatus='$stid' and mainbd='$uid' or apst='$uid' or insidebd='$uid'");
            }
        }
        if($stid == "reject"){
            $query=$this->db->select('annualreviewtarget.*,company_master.compname,company_master.id as cmpid_id')->from('annualreviewtarget')
                            ->join('company_master','company_master.id = annualreviewtarget.company_id')
                            ->where(['user_id'=>$uid])
                            // ->or_where('is_approved','Reject')
                            // ->or_where('is_admin_approved','Reject')
                            ->group_start()
                                ->or_where('is_approved', 'Reject')
                                ->or_where('is_admin_approved', 'Reject')
                            ->group_end()
                            ->get();
        }
        $cmp = $query->result();
        // echo $this->db->last_query();
        // $annualcmp = $this->db->select('*')->from('annualreviewtarget')->where('user_id',$uid)->get()->result();
        echo '<option value=""class="">Select Company</option>';
        foreach($cmp as $dt){
             $query=$this->db->query("SELECT * FROM `annualreviewtarget` WHERE `user_id` = '$uid'");
            //  $query=$this->db->query("SELECT * FROM `annualreviewtarget` WHERE 'reject_remark'='' or `pst_reject` = '1' OR `cluster_reject` = '1' AND `user_id` = '$uid' ");
             $annualcmp = $query->result();
            // echo $this->db->last_query();
            // $annualcmp = $this->db->select('*')->from('annualreviewtarget')
            //     ->where(['user_id' => $uid])
            //     ->or_where('pst_reject','1')
            //     ->or_where('cluster_reject','1')
                // ->or_where('reject_remark', 'Not under CSR Mandate')
                // ->or_where('reject_remark', 'Not under CSR Mandate.')
                // ->or_where('reject_remark', 'Not in my region')
                // ->or_where('reject_remark', 'Not in my region.')
                // ->get()->result();
            $companyExists = false;
            foreach ($annualcmp as $annual) {
                if ($annual->company_id == $dt->cmpid_id) {
                    // if($annual->pst_reject == 0 || $annual->cluster_reject == 0){
                    if($annual->pst_reject == 0 && $annual->cluster_reject == 0){
                         $companyExists = true;
                            break;
                    }
                    // else if($annual->cluster_reject == 0){
                    //       $companyExists = true;
                    //         break;
                    // }
                }
            }
            if (!$companyExists) {
                // echo '<option value="' . $dt->cmpid_id . '">' . $dt->compname . '</option>';
               echo $annual->company_id."<br/><br/>";
                echo '<option value="' . $dt->cmpid_id . '">'. $dt->cmpid_id .'&nbsp;/&nbsp;' . $dt->compname . '</option>';
            }
        }
    }
    public function annualAnalysisCompanyData(){
        $cmpid = $this->input->post('inid');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $company = $this->db->select('*')->from('company_master')->where('id',$cmpid)->get()->row();
        //  echo "<pre>";
        // print_r($company);
        // exit;
        // if($uyid == 9){
            $init_data = $this->db->select('*')->from('init_call')->where(['cmpid_id'=>$company->id])->get()->row();
        // }
        if($uyid == 4){
            $init_data = $this->db->select('*')->from('init_call')->where(['cmpid_id'=>$company->id, 'apst'=>$uid])->get()->row();
        }
        // var_dump($init_data->id); exit;
        $ccd=$this->Menu_model->get_ccdbyid($company->id);
        $alternate=$this->Menu_model->get_ccdbyidalternate($company->id);
        $dep_name = $dt[0]->name;
        $tblc=$this->Menu_model->get_tblcalleventsbyid($init_data->id);
        // $query=$this->db->query("SELECT * FROM tblcallevents WHERE cid_id='$init_data->id' and user_id='$uid' and cast(updateddate as DATE)>'2023-03-31' ORDER BY tblcallevents.updateddate DESC");
        // $tblc = $query->result();
        // echo $this->db->last_query(); exit;
        // echo "<pre>";
        // print_r($init_data);
        // exit;
    $userdata = $this->db->select('*')->from('user_details')->where('user_id',$uid)->get()->row();
        $cluData = $this->Menu_model->getAllActiveClusterByUid($uid);
        $admin = $this->db->select('u2.name,u2.user_id')->from('user_details u1')
                            ->join('user_details u2','u2.user_id = u1.admin_id')
                            ->where(['u1.user_id'=> $uid])->get()->result();
                            // var_dump($user); exit;
        if($userdata->aadmin != ""){
            $clusteradmin = $this->db->select('u2.name,u2.user_id')->from('user_details u1')
                            ->join('user_details u2','u2.user_id = u1.aadmin')
                            ->where(['u1.user_id'=> $uid])->get()->result();
        }
        if($userdata->badmin != ""){
            $badmin =  $this->db->select('u2.name,u2.user_id')->from('user_details u1')
                            ->join('user_details u2','u2.user_id = u1.badmin')
                            ->where(['u1.user_id'=> $uid])->get()->result();
        }
        //   echo $this->db->last_query(); exit;
        $status=$this->Menu_model->get_status();
        $this->load->view($dep_name.'/AnnualAnalysisData',['user'=>$user,'company'=>$company,'init_data'=>$init_data,'ccd'=>$ccd,'tblc'=>$tblc,'status'=>$status,'alternate'=>$alternate,'cluData'=>$cluData,'admin'=>$admin,'clusteradmin'=>$clusteradmin,'badmin'=>$badmin]);
    }
    public function annualAnalysisDetails(){
        // echo "<pre>";
        // print_r($_POST);
        // exit;
         $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $que        = $this->input->post('que');
        $ans        = $this->input->post('remark');
        $cmp        = $this->input->post('company');
        $user       = $this->input->post('user');
        $noschool   = $this->input->post('noschool');
        $revenue    = $this->input->post('revenue');
        $reachout       = $this->input->post('reachout');
        $tentative      = $this->input->post('tentative');
        $positive       = $this->input->post('positive');
        $positivenap    = $this->input->post('positivenap');
        $verypositive   = $this->input->post('verypositive');
        $closure        = $this->input->post('closure');
        $focusfunnel = $this->input->post('focusfunnel');
        $topspender = $this->input->post('topspender');
        $partnership = $this->input->post('partnership');
        $fyear = $this->input->post('fyear');
        $timer = $this->input->post('timer');
        $cstatusid = $this->input->post('cstatusid');
        $focusquarter = $this->input->post('focusqu');
        $keepremark = $this->input->post('keepremark');
        $change_location = $this->input->post('change_location');
        $vmeeting = $this->input->post('vmeeting');
        $kcompany  = $this->input->post('kcompany');
        $district           = $this->input->post('district_location');
        $state_location     = $this->input->post('state_location');
        $focuspositive      = $this->input->post('focuspositive');
        $intervention       = $this->input->post('intervention');
        $support            = $this->input->post('support');
        $upsell             = $this->input->post('upsell');
        if($uyid == 4){
             $selectClusterid  = '0';
        }else{
             $selectClusterid  = $this->input->post('selectCluster');
        }
        $i=0;
        foreach($que as $q){
            $data = [
                'company_id'=>$cmp,
                'question'=>$q,
                'answer'=>$ans[$i],
                'user_id'=>$user,
                'createdat' => date('Y-m-d H:i:s'),
                'updatedat' => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('annualreviewdetails',$data);
        }
        $data1 = [
            'fyear'=>$fyear,
            'company_id'=>$cmp,
            'user_id'=>$user,
            'noofschool'=>$noschool,
            'revenue'=>$revenue,
            'open'=>'',
            'reachout'=>$reachout,
            'tentative'=>$tentative,
            'positive'=>$positive,
            'very_positive'=>$verypositive,
            'positivenap' => $positivenap,
            'closure'=>$closure,
            'focusfunnel'=>$focusfunnel,
            'topspender'=>$topspender,
            'partnertype'=>$partnership,
            'starttime'=>$timer,
            'status'=>$cstatusid,
            'keep_company'=>$kcompany,
            'cluster_id'=>$selectClusterid,
            'vmeeting'=>$vmeeting,
            'focusquarter' => $focusquarter,
            'location'=>$change_location,
            'keepremark' => $keepremark,
            'district' => $district,
            'state' => $state_location,
            'focuspositive' => $focuspositive,
            'intervention' => $intervention,
            'support' => $support,
            'upsell'  => $upsell,
            'createdat' => date('Y-m-d H:i:s'),
            'updatedat' => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('annualreviewtarget',$data1);
        // echo $this->db->last_query(); exit;
        redirect('Menu/AnnualReviewDet');
    }
    public function AnnualReviewDet(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if($uyid == 9){
            $query=$this->db->query("SELECT init_call.cstatus,COUNT(init_call.cmpid_id) as totalCmp from init_call where mainbd='$uid' GROUP BY init_call.cstatus ORDER BY cstatus ASC");
        }
        if($uyid == 4){
            $query=$this->db->query("SELECT init_call.cstatus,COUNT(init_call.cmpid_id) as totalCmp from init_call where apst='$uid' GROUP BY init_call.cstatus ORDER BY cstatus ASC");
        }
        if($uyid == 3){
            $query=$this->db->query("SELECT init_call.cstatus,COUNT(init_call.cmpid_id) as totalCmp from init_call where mainbd='$uid' or apst='$uid' or insidebd='$uid' GROUP BY init_call.cstatus ORDER BY cstatus ASC");
        }
        if($uyid == 13){
            $query=$this->db->query("SELECT init_call.cstatus,COUNT(init_call.cmpid_id) as totalCmp from init_call where mainbd='$uid' GROUP BY init_call.cstatus ORDER BY cstatus ASC");
        }
        $companydata = $query->result();
        $reviwcmp = $this->db->select('*')->from('annualreviewtarget')->where(['user_id'=>$uid])->get()->result();
        $startreview = $this->db->select('*')->from('startannualreview')->where(['user_id'=>$uid])->get()->row();
        $this->load->view($dep_name.'/AnnualReview',['user'=>$user,'companydata'=>$companydata,'reviwcmp'=>$reviwcmp,'startreview'=>$startreview]);
    }
    public function ReviewDetails(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if($uyid == 9){
            // $query=$this->db->query("SELECT init_call.cstatus,COUNT(init_call.cmpid_id) as totalCmp from init_call where mainbd='$uid' GROUP BY init_call.cstatus ORDER BY cstatus ASC");
        $query=$this->db->query("SELECT init_call.cmpid_id, init_call.cstatus from init_call where mainbd='$uid' ORDER BY cstatus ASC");
        }
        if($uyid == 4){
            // $query=$this->db->query("SELECT init_call.cstatus,COUNT(init_call.cmpid_id) as totalCmp from init_call where apst='$uid' GROUP BY init_call.cstatus ORDER BY cstatus ASC");
            $query=$this->db->query("SELECT init_call.cmpid_id, init_call.cstatus from init_call where apst='$uid' ORDER BY cstatus ASC");
        }
        if($uyid == 3){
            // $query=$this->db->query("SELECT init_call.cstatus,COUNT(init_call.cmpid_id) as totalCmp from init_call where mainbd='$uid' or apst='$uid' or insidebd='$uid' GROUP BY init_call.cstatus ORDER BY cstatus ASC");
            $query=$this->db->query("SELECT init_call.cmpid_id, init_call.cstatus from init_call where mainbd='$uid' ORDER BY cstatus ASC");
        }
        if($uyid == 13){
            // $query=$this->db->query("SELECT init_call.cstatus,COUNT(init_call.cmpid_id) as totalCmp from init_call where mainbd='$uid' GROUP BY init_call.cstatus ORDER BY cstatus ASC");
            $query=$this->db->query("SELECT init_call.cmpid_id, init_call.cstatus from init_call where mainbd='$uid' ORDER BY cstatus ASC");
        }
        $companydata = $query->result();
        $totalcmp = [];
        $pending  = [];
        foreach($companydata as $cd){
            $s = $cd->cstatus;
            if (isset($totalcmp[$s])) {
                $totalcmp[$s]++;
            } else {
                $totalcmp[$s] = 1;
            }
            $rcmp = $this->db->select('*')->from('annualreviewtarget')->where(['user_id'=>$uid])->group_by('company_id')->get()->result();//,'company_id' => $cd->cmpid_id
            $companyExists = false;
            foreach ($rcmp as $rc) {
                if ($rc->company_id == $cd->cmpid_id) {
                    $companyExists = true;
                    if (isset($pending[$s])) {
                        $pending[$s]++;
                    } else {
                        $pending[$s] = 1;
                    }
                }
            }
        }
        // var_dump($pending); exit;
        // echo $this->db->last_query(); exit;
        $reviwcmp = $this->db->select('*')->from('annualreviewtarget')->where(['user_id'=>$uid])->get()->result();
        // echo $this->db->last_query(); exit;
        $startreview = $this->db->select('*')->from('startannualreview')->where(['user_id'=>$uid])->get()->row();
        $this->load->view($dep_name.'/ReviewDetails',['user'=>$user,'companydata'=>$companydata,'reviwcmp'=>$reviwcmp,'startreview'=>$startreview,'pending'=>$pending,'totalcmp' => $totalcmp]);
    }
    public function startAnnualReview(){
        $data = [
            'start' => date('Y-m-d'),
            'user_id' => $this->input->post('user_id'),
            'createdat' => date('Y-m-d H:i:s'),
            'updatedat' => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('startannualreview',$data);
        redirect('Menu/AnnualReviewDet');
    }
    public function annualReviewReport(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $bd = $this->Menu_model->get_userbyaid('45');
        $userid = $this->input->post('bd');
        $company = $this->input->post('company');
        $userdata = $this->db->select()->from('user_details')->where('user_id',$userid)->get()->row();
        // die("Under Maintenance ");
        if($uyid == 4){
            // if($userdata->type_id == 3){
            // }
            $udetails = $this->db->select('*')->from('user_details')->where("(aadmin = $uid OR badmin = $uid)")->get()->result();
            $u = [];
            foreach($udetails as $b){
                $u[] = $b->user_id;
            }
        }
        if($uyid == 11){
            $udetails = $this->db->select('*')->from('user_details')->where("(aadmin = $uid)")->get()->result();
            $u = [];
            foreach($udetails as $b){
                $u[] = $b->user_id;
            }
        }
        if($uyid == 13){
            $udetails = $this->db->select('*')->from('user_details')->where("(aadmin = $uid)")->get()->result();
            $u = [];
            foreach($udetails as $b){
                $u[] = $b->user_id;
            }
        }
        if($uyid == 2){
            $udetails = $this->db->select('*')->from('user_details')->where("(admin_id = $uid)")->get()->result();
            $u = [];
            foreach($udetails as $b){
                $u[] = $b->user_id;
            }
        }
        // var_dump($u);exit;
        // $annualdata = $this->db->select('*')->from('annualreviewdetails')
        //                         ->where_in('user_id', $u)
        //                         ->get()->result();
        // $annualTarget = $this->db->select('*')->from('annualreviewtarget')
        //                         ->where('is_approved','')
        //                         ->where_in('user_id', $u)
        //                         ->get()->result();
        // if($uyid == 2){
        $annualTarget = $this->db->select('*')->from('annualreviewtarget')->where(['user_id'=>$userid,'company_id'=>$company])->get()->result();
                                // echo $this->db->last_query(); exit;
                                //,['annualdata'=>$annualdata,'annualTarget'=>$annualTarget]
        $revDatatar = $this->db->select('*')->from('annualreviewtarget')->where(['user_id'=>$uid])->get()->result();
        $this->load->view($dep_name.'/AnnualReviewReport',['udetails'=>$udetails,'annualTarget'=>$annualTarget,'user'=>$user,'revDatatar'=>$revDatatar,'uid'=> $uid]);
        // }
        }
     public function AnnualReviewReportData(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $revDatatar = $this->db->select('*')->from('annualreviewtarget')->where(['user_id'=>$uid])->get()->result();
        // echo $this->db->last_query(); exit;
        $this->load->view($dep_name.'/AnnualReviewReportData',['uid'=>$uid,'udetails'=>$udetails,'revDatatar'=>$revDatatar,'user'=>$user]);
    }
      public function AnnualReviewReportDatabkp(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $revDatatar = $this->db->select('*')->from('annualreviewtarget')->where(['user_id'=>$uid])->get()->result();
        $this->load->view($dep_name.'/AnnualReviewReportDatabkp',['uid'=>$uid,'udetails'=>$udetails,'revDatatar'=>$revDatatar,'user'=>$user]);
    }
    public function AnnualReviewReportDataInAdmin(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $userdata = $this->db->select('user_id')->from('user_details')->where(['admin_id'=>$uid,'status'=>'active'])->get()->result();
        $userIds = array_map(function($user) {
            return $user->user_id;
        }, $userdata);
            // $rcmp = $this->db->select('*')->from('annualreviewtarget')->where(['user_id'=>58])->group_by('company_id')->get()->result();
            // echo  $str = $this->db->last_query();
            // exit;
        //   die("Under Mentainence");
        $revDatatar = $this->db->select('*')->from('annualreviewtarget')->where(['is_approved'=>'Approve'])->where_in('user_id', $userIds)->get()->result();
        $this->load->view($dep_name.'/AnnualReviewReportDataInAdmin',['uid'=>$uid,'revDatatar'=>$revDatatar,'user'=>$user]);
    }
    public function getUpdatedReviewDetailsByUser(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $userdata = $this->db->select('user_id')->from('user_details')->where(['admin_id'=>$uid,'status'=>'active'])->get()->result();
        $userIds = array_map(function($user) {
            return $user->user_id;
        }, $userdata);
            // $rcmp = $this->db->select('*')->from('annualreviewtarget')->where(['user_id'=>58])->group_by('company_id')->get()->result();
            // echo  $str = $this->db->last_query();
            // exit;
        //   die("Under Mentainence");
        $revDatatar = $this->db->select('*')->from('annualreviewtarget')->where(['is_approved'=>'Approve'])->where_in('user_id', $userIds)->get()->result();
        $this->load->view($dep_name.'/getUpdatedReviewDetailsByUser',['uid'=>$uid,'revDatatar'=>$revDatatar,'user'=>$user]);
    }
      public function AnnualCompanyReport(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $userdata = $this->db->select('user_id')->from('user_details')->where(['admin_id'=>$uid,'status'=>'active'])->get()->result();
        $userIds = array_map(function($user) {
            return $user->user_id;
        }, $userdata);
        $revDatatar = $this->db->select('*')->from('annualreviewtarget')->where(['is_approved'=>'Approve'])->where_in('user_id', $userIds)->get()->result();
        $this->load->view($dep_name.'/AnnualCompanyReport',['uid'=>$uid,'revDatatar'=>$revDatatar,'user'=>$user]);
    }
       public function AnnualReviewReportDataInAdmin1(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $this->load->view($dep_name.'/AnnualReviewReportDataInAdmin1',['uid'=>$uid,'user'=>$user]);
    }
       public function ReviewPage(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $this->load->view($dep_name.'/ReviewPage',['uid'=>$uid,'user'=>$user]);
    }
    public function ShowCompanyReviewData($userid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $this->load->view($dep_name.'/ShowCompanyReviewData',['uid'=>$uid,'userid'=>$userid,'user'=>$user]);
    }
    public function DuplicateCompanyReview($userid){
         ini_set('max_execution_time', 2000); // 300 seconds
        //  ini_set('max_execution_time', 0);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $query = $this->db->query("SELECT user_id FROM user_details where (aadmin='$userid' or badmin='$userid')  and status='active'");
         $userdata =  $query->result();
        $teamid = '';
        foreach($userdata as $d){
           $teamid .= $d->user_id.',';
        }
        $teamid .= $userid;
        $this->load->view($dep_name.'/DuplicateCompanyReview',['uid'=>$uid,'userid'=>$userid,'user'=>$user,'teamid'=>$teamid]);
    }
      public function DuplicateCompanyReviewTable($userid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $query = $this->db->query("SELECT user_id FROM user_details where (aadmin='$userid' or badmin='$userid')  and status='active'");
         $userdata =  $query->result();
        $teamid = '';
        foreach($userdata as $d){
           $teamid .= $d->user_id.',';
        }
        $teamid .= $userid;
        $this->load->view($dep_name.'/DuplicateCompanyReviewTable',['uid'=>$uid,'userid'=>$userid,'user'=>$user,'teamid'=>$teamid]);
    }
      public function CompanyGroupWiseReviewDone($userid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $query = $this->db->query("SELECT user_id FROM user_details where (aadmin='$userid' or badmin='$userid')  and status='active'");
         $userdata =  $query->result();
        $teamid = '';
        foreach($userdata as $d){
           $teamid .= $d->user_id.',';
        }
        $teamid .= $userid;
        $this->load->view($dep_name.'/CompanyGroupWiseReviewDone',['uid'=>$uid,'userid'=>$userid,'user'=>$user,'teamid'=>$teamid]);
    }
       public function CompanyNotWithMe(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $query = $this->db->query("SELECT DISTINCT(user_id) FROM `annualreviewtarget` WHERE keep_company ='no'");
        $userdata =  $query->result();
        $this->load->view($dep_name.'/CompanyNotWithMe',['uid'=>$uid,'user'=>$user,'userdata'=>$userdata]);
    }
      public function CompanyDetailsNotwithMe($userid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $queryData = $this->Menu_model->getAllCompanyNotWithMe($userid);
        // echo "<pre>";
        // print_r($userdatacomp);
        // die;
        $this->load->view($dep_name.'/CompanyDetailsNotwithMe',['uid'=>$uid,'user'=>$user,'userid'=>$userid,'userdatacomp'=>$queryData]);
    }
     public function firstApproveAnnualReview($id,$a){
        // var_dump($_POST); exit;
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $annual = $this->db->select('*')->from('annualreviewtarget')
                            ->where('id',$id)->get()->row();
        $userdetails = $this->db->select('*')->from('user_details')->where('user_id',$annual->user_id)->get()->row();
        // echo "<pre>";
        // print_r($user['name']);
        // print_r($userdetails);
        // die;
        $cmpid = $annual->company_id;
        $topspender = $annual->topspender;
        $status = $annual->status;
        $focusfunnel = $annual->focusfunnel;
        $partnerType_id = $annual->partnertype;
        $isapprove = false;
        $compname = $this->Menu_model->get_cdbyid($cmpid)[0]->compname;
        $atarget = $this->db->select('*')->from('annualreviewtarget')->where('id',$id)->get()->row();
        $utype = $this->db->select('*')->from('user_details')->where('user_id',$atarget->user_id)->get()->row();
        if($a == 'Approve'){
            if($uyid == 13){
                $this->db->where('id',$id)->update('annualreviewtarget',['cluster_approve'=>$a]);
                $this->db->where('id',$id)->update('annualreviewtarget',['cluster_name'=>$user['name']]);
            }
            if($uyid == 4){
                $this->db->where('id',$id)->update('annualreviewtarget',['pst_approve'=>$a]);
                $this->db->where('id',$id)->update('annualreviewtarget',['pst_name'=>$user['name']]);
            }
            if($uyid == 8){
                $this->db->where('id',$id)->update('annualreviewtarget',['is_approved'=>$a]);
                $this->db->where('id',$id)->update('annualreviewtarget',['is_fapproved_name'=>$user['name']]);
            }
            if($utype == 3 && $atarget->cluster_approve != "" && $atarget->pst_approve != ""){
                $this->db->where('id',$id)->update('annualreviewtarget',['is_approved'=>$a]);
                $this->db->where('id',$id)->update('annualreviewtarget',['is_fapproved_name'=>$user['name']]);
            }else{
                $this->db->where('id',$id)->update('annualreviewtarget',['is_approved'=>$a]);
                $this->db->where('id',$id)->update('annualreviewtarget',['is_fapproved_name'=>$user['name']]);
            }
            $this->load->library('session');
            $this->session->set_flashdata('action_message',$compname.' - '. $cmpid.' - '. $a.' SuccessFully');
          }
         if($a == 'Reject'){
            $this->db->where('id',$id)->update('annualreviewtarget',['cluster_approve'=>$a]);
            $this->db->where('id',$id)->update('annualreviewtarget',['is_approved'=>$a]);
            $this->db->where('id',$id)->update('annualreviewtarget',['is_fapproved_name'=>$user['name']]);
            $this->load->library('session');
            $this->session->set_flashdata('action_message', $compname.' - '. $cmpid.' - '. $a.' SuccessFully');
          }
          if($uyid == 9){
                redirect('Menu/AnnualReviewReportDatabkp');
            }else{
               redirect('Menu/AnnualReviewReport');
            }
    }
    public function firstApproveAnnualReviewNew($id,$a,$userid){
      
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $annual = $this->db->select('*')->from('annualreviewtarget')
                            ->where('id',$id)->get()->row();
        $userdetails = $this->db->select('*')->from('user_details')->where('user_id',$annual->user_id)->get()->row();
        // echo "<pre>";
        // print_r($user['name']);
        // print_r($userdetails);
        // die;
        $cmpid = $annual->company_id;
        $topspender = $annual->topspender;
        $status = $annual->status;
        $focusfunnel = $annual->focusfunnel;
        $partnerType_id = $annual->partnertype;
        $isapprove = false;
        $compname = $this->Menu_model->get_cdbyid($cmpid)[0]->compname;
        $atarget = $this->db->select('*')->from('annualreviewtarget')->where('id',$id)->get()->row();
        $utype = $this->db->select('*')->from('user_details')->where('user_id',$atarget->user_id)->get()->row();
        if($a == 'Approve'){
            if($uyid == 13){
                $this->db->where('id',$id)->update('annualreviewtarget',['cluster_approve'=>$a]);
                $this->db->where('id',$id)->update('annualreviewtarget',['cluster_name'=>$user['name']]);
            }
            if($uyid == 4){
                $this->db->where('id',$id)->update('annualreviewtarget',['pst_approve'=>$a]);
                $this->db->where('id',$id)->update('annualreviewtarget',['pst_name'=>$user['name']]);
            }
            if($uyid == 8){
                $this->db->where('id',$id)->update('annualreviewtarget',['is_approved'=>$a]);
                $this->db->where('id',$id)->update('annualreviewtarget',['is_fapproved_name'=>$user['name']]);
            }
            if($utype == 3 && $atarget->cluster_approve != "" && $atarget->pst_approve != ""){
                $this->db->where('id',$id)->update('annualreviewtarget',['is_approved'=>$a]);
                $this->db->where('id',$id)->update('annualreviewtarget',['is_fapproved_name'=>$user['name']]);
            }else{
                $this->db->where('id',$id)->update('annualreviewtarget',['is_approved'=>$a]);
                $this->db->where('id',$id)->update('annualreviewtarget',['is_fapproved_name'=>$user['name']]);
            }
            $this->load->library('session');
            $this->session->set_flashdata('action_message',$compname.' - '. $cmpid.' - '. $a.' SuccessFully');
          }
         if($a == 'Reject'){
            $this->db->where('id',$id)->update('annualreviewtarget',['cluster_approve'=>$a]);
            $this->db->where('id',$id)->update('annualreviewtarget',['is_approved'=>$a]);
            $this->db->where('id',$id)->update('annualreviewtarget',['is_fapproved_name'=>$user['name']]);
            $this->load->library('session');
            $this->session->set_flashdata('action_message', $compname.' - '. $cmpid.' - '. $a.' SuccessFully');
          }
          if($uyid == 9){
                redirect('Menu/ShowCompanyReviewData/'.$userid);
            }else{
               redirect('Menu/AnnualReviewReport');
            }
    }
    public function rejectAnnualReview(){
        // var_dump($_POST); exit;
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $id = $this->input->post('reject');
        $remark = $this->input->post('rejectreamrk');
        $atarget = $this->db->select('*')->from('annualreviewtarget')->where('id',$id)->get()->row();
        $utype = $this->db->select('*')->from('user_details')->where('user_id',$atarget->user_id)->get()->row();
        if($uyid == 13){
            $this->db->where('id',$id)->update('annualreviewtarget',['cluster_approve'=>'Reject','reject_remark' => $remark,'cluster_remark'=>$remark]);
            $this->db->where('id',$id)->update('annualreviewtarget',['cluster_name'=>$user['name']]);
             $this->db->where('id',$id)->update('annualreviewtarget',['cluster_reject'=>1]);
        }
        if($uyid == 4){
            $this->db->where('id',$id)->update('annualreviewtarget',['pst_approve'=>'Reject','reject_remark' => $remark, 'pst_remark'=>$remark]);
            $this->db->where('id',$id)->update('annualreviewtarget',['pst_name'=>$user['name']]);
            $this->db->where('id',$id)->update('annualreviewtarget',['pst_reject'=>1]);
        }
        if($uyid == 8){
            $this->db->where('id',$id)->update('annualreviewtarget',['is_approved'=>'Reject','reject_remark' => $remark]);
            $this->db->where('id',$id)->update('annualreviewtarget',['is_fapproved_name'=>$user['name']]);
        }
        if($utype == 3 && $atarget->cluster_approve != "" && $atarget->pst_approve != ""){
            $this->db->where('id',$id)->update('annualreviewtarget',['is_approved'=>$a]);
            $this->db->where('id',$id)->update('annualreviewtarget',['is_fapproved_name'=>$user['name']]);
        }else{
            $this->db->where('id',$id)->update('annualreviewtarget',['is_approved'=>'Reject','reject_remark' => $remark]);
            $this->db->where('id',$id)->update('annualreviewtarget',['is_fapproved_name'=>$user['name']]);
        }
            //   echo $this->db->last_query(); exit;
            $this->load->library('session');
            $this->session->set_flashdata('action_message', 'Company Rejected SuccessFully');
            if($uyid == 9){
                redirect('Menu/AnnualReviewReportDatabkp');
            }else{
               redirect('Menu/AnnualReviewReport');
            }
    }
    public function approveAnnualReview($id,$a){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $annual = $this->db->select('*')->from('annualreviewtarget')
                            ->where('id',$id)->get()->row();
        $userdetails = $this->db->select('*')->from('user_details')->where('user_id',$annual->user_id)->get()->row();
        echo "<pre>";
        print_r($annual);
        echo "under mentainence";
        die;
        $cmpid = $annual->company_id;
        $topspender = $annual->topspender;
        $status = $annual->status;
        $focusfunnel = $annual->focusfunnel;
        $noofschool = $annual->noofschool;
        $partnerType_id = $annual->partnertype;
        $keycompany = $annual->keycompany;
        $exrevenue = $annual->revenue;
        $compname = $this->Menu_model->get_cdbyid($cmpid)[0]->compname;
           if($uyid == 2){
                $isapprove = true;
            }else{
                $this->load->library('session');
                $this->session->set_flashdata('action_message', 'You are not Authrized to Access this action.');
                redirect('Menu/AnnualReviewReportDataInAdmin');
            }
        if($a == "Approve" && $isapprove){
            $init = $this->db->select('*')->from('init_call')
                        ->where(['cmpid_id'=>$cmpid])->get()->row();
            // die("Approved are Under Maintenance");
            $this->db->where('id',$id)->update('annualreviewtarget',['is_admin_approved'=>$a]);
            // $this->db->where('id',$init->id)->update('init_call',['is_deleted'=>1]);
            $this->db->where('id',$init->id)->update('init_call',
            ['topspender'=>$topspender,
                'cstatus'=>$status,
                'focus_funnel'=>$focusfunnel,
                'keycompany'=>$keycompany,
                'exrevenue'=>$exrevenue,
                'noofschools'=>$noofschool,
                'fyear'=>$annual->fyear,
                'open'=>$annual->open,
                'reachout'=>$annual->reachout,
                'positive'=>$annual->positive,
                'positivenap'=>$annual->positivenap,
                'tentative'=>$annual->tentative,
                'closure'=>$annual->closure,
                'verypositive'=>$annual->very_positive,
                'vmeeting'=>$annual->vmeeting,
                'cluster_id'=>$annual->cluster_id,
                'focuspositive'=>$annual->focuspositive,
                'interventions'=>$annual->intervention,
                'keep_company'=>$annual->keep_company,
                'review_date'=>$annual->createdat,
                'support'=>$annual->support]);
            // $this->db->where('id',$init->id)->update('init_call',['is_deleted'=>1]);
            $this->db->where('id',$cmpid)->update('company_master',['partnerType_id'=>$partnerType_id]);
            if($annual->location !==''){
               $this->db->where('id',$cmpid)->update('company_master',['locations'=>$annual->location]);
            }
            // echo $init->id;
            // die;
            $fwd_date = date('Y-m-d H:i:s');
            $data = [
                'lastCFID' => 0,
                'nextCFID' => 0,
                'fwd_date' => $fwd_date,
                'actiontype_id' => 15,
                'assignedto_id' => $annual->user_id,
                'purpose_id' => 127,
                'targetstatus' => 0,
                'actontaken' => 'no',
                'purpose_achieved' => 'no',
                'cid_id'=>$init->id,
                'remarks'=>'After Focus funnel and Top Spender And Partner Type details are updated',
                'status_id'=>$status,
                'user_id' => $annual->user_id,
                'date' => date('Y-m-d H:i:s'),
                'updateddate' => date('Y-m-d H:i:s'),
                'is_new' => 1
            ];
            $this->db->insert('tblcallevents',$data);
            // echo $str = $this->db->last_query();
            // die;
            //   $data = [
            //     'lastCFID' => 0,
            //     'nextCFID' => 0,
            //     'fwd_date' => $fwd_date,
            //     'actiontype_id' => 1,
            //     'assignedto_id' => $annual->user_id,
            //     'purpose_id' => 127,
            //     'targetstatus' => 0,
            //     'actontaken' => 'no',
            //     'purpose_achieved' => 'no',
            //     'cid_id'=>$init->id,
            //     'remarks'=>'Top Spender details are updated',
            //     'status_id'=>$status,
            //     'user_id' => $annual->user_id,
            //     'date' => date('Y-m-d H:i:s'),
            //     'updateddate' => date('Y-m-d H:i:s'),
            //     'is_new' => 1
            // ];
            // $this->db->insert('tblcallevents',$data);
            //   $data = [
            //     'lastCFID' => 0,
            //     'nextCFID' => 0,
            //     'fwd_date' => $fwd_date,
            //     'actiontype_id' => 1,
            //     'assignedto_id' => $annual->user_id,
            //     'purpose_id' => 127,
            //     'targetstatus' => 0,
            //     'actontaken' => 'no',
            //     'purpose_achieved' => 'no',
            //     'cid_id'=>$init->id,
            //     'remarks'=>'Partner Type details are updated',
            //     'status_id'=>$status,
            //     'user_id' => $annual->user_id,
            //     'date' => date('Y-m-d H:i:s'),
            //     'updateddate' => date('Y-m-d H:i:s'),
            //     'is_new' => 1
            // ];
            // $this->db->insert('tblcallevents',$data);
        }
        $this->session->set_flashdata('action_message', $compname.' - '. $cmpid.' - '. $a.' Successfully');
        redirect('Menu/AnnualReviewReportDataInAdmin1');
    }
    public function CompanyReviewRejectByAdmin(){
            // echo "<pre>";
            // print_r($_POST);
            // die("Reject Action is Under Maintenance");
            $user = $this->session->userdata('user');
            $data['user'] = $user;
            $uid = $user['user_id'];
            $uyid =  $user['type_id'];
            $this->load->model('Menu_model');
            $id = $this->input->post('rejectid');
            $remark = $this->input->post('rejectreamrk');
                $this->db->where('id',$id)->update('annualreviewtarget',['is_admin_approved'=>'Reject','reject_remark' => $remark]);
            //   echo $this->db->last_query(); exit;
                $this->load->library('session');
                $this->session->set_flashdata('action_message', 'Company Rejected SuccessFully');
            redirect('Menu/AnnualReviewReportDataInAdmin1');
    }
    public function cluster(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
         $state = $this->db->select('*')->from('in_state')
                            ->where('status','Active')->get()->result();
        $clusterData = $this->db->select('*')->from('cluster')->where('user_id',$uid)->get()->result();
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $this->load->view($dep_name.'/cluster',['state'=>$state,'cluster'=>$clusterData,'uid' => $uid,'user'=>$user]);
    }
        public function cluster_test(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
         $state = $this->db->select('*')->from('in_state')
                            ->where('status','Active')->get()->result();
        $clusterData = $this->db->select('*')->from('cluster')->where('user_id',$uid)->get()->result();
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $this->load->view($dep_name.'/cluster_test',['state'=>$state,'cluster'=>$clusterData,'uid' => $uid,'user'=>$user]);
    }
    public function getAllclusterDistrict(){
       $clusterStateid = $_POST['clusterState'];
        $this->load->model('Menu_model');
         $district = $this->db->select('*')->from('in_district')
                            ->where('state_id',$clusterStateid)->get()->result();
            // echo $this->db->last_query(); exit;
            $data = '';
             foreach($district as $dt){
                    $data .= '<option value='.$dt->districtid.'>'.$dt->district_title.'</option>';
                }
                echo $data;
    }
    public function getAllclusterDistrictCity(){
       $clusterDistrict = $_POST['clusterDistrict'];
        $this->load->model('Menu_model');
        $cityids = implode(", ", $clusterDistrict);
        $query = $this->db->query("SELECT * FROM in_city WHERE districtid IN ($cityids)");
        $districtcity = $query->result();
            $data = '';
            $data .= '<option disabled >Select User </option>';
            foreach($districtcity as $dtc){
                $data .= '<option value='.$dtc->id.'>'.$dtc->name.'</option>';
            }
        echo $data;
    }
    public function AddNewCluster(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $cluster = $_POST['cluster'];
        $clusterState = $_POST['clusterState'];
        $clusterDistrict = $_POST['clusterDistrict'];
        $clusterDistrict = implode(",", $clusterDistrict);
        $clusterCity = $_POST['clusterCity'];
        $clusterCity = implode(",", $clusterCity);
        $this->db->query("INSERT INTO `cluster`(`clustername`,`user_id`,`in_state`, `in_district`, `in_city`) VALUES ('$cluster','$uid','$clusterState','$clusterDistrict','$clusterCity')");
        $this->load->library('session');
        $this->session->set_flashdata('success_message', 'Cluster Add successfully');
     redirect('Menu/cluster');
    }
    public function AddFAQ(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $faq = $this->db->select('*')->from('faqquestion')->where('user_id',$uid)->get()->result();
        $this->load->view($dep_name.'/AddFAQ',['uid'=>$uid,'faq'=>$faq]);
    }
    public function createFaq(){
        $question = $this->input->post('faq');
        $user = $this->input->post('uid');
        $data = [
            'question'      => $question,
            'user_id'       => $user,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
            ];
        $this->db->insert('faqquestion',$data);
        redirect('Menu/AddFAQ');
    }
    public function FAQReport(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if($uyid == 4){
            $udetails = $this->db->select('*')->from('user_details')->where("(aadmin = $uid OR badmin = $uid)")->get()->result();
            $u = [];
            foreach($udetails as $b){
                $u[] = $b->user_id;
            }
        }
        if($uyid == 11){
            $udetails = $this->db->select('*')->from('user_details')->where("(aadmin = $uid)")->get()->result();
            $u = [];
            foreach($udetails as $b){
                $u[] = $b->user_id;
            }
        }
        if($uyid == 13){
            $udetails = $this->db->select('*')->from('user_details')->where("(aadmin = $uid)")->get()->result();
            $u = [];
            foreach($udetails as $b){
                $u[] = $b->user_id;
            }
        }
        if($uyid == 2){
            $udetails = $this->db->select('*')->from('user_details')->where("(admin_id = $uid)")->get()->result();
            $u = [];
            foreach($udetails as $b){
                $u[] = $b->user_id;
            }
        }
        $faq = $this->db->select('DISTINCT(user_id)')->from('faqquestion')
                        // ->where('user_id',$uid)
                        ->where_in('user_id', $u)
                        ->group_by('user_id')
                        ->get()->result();
        // echo $this->db->last_query(); exit;
        $this->load->view($dep_name.'/FAQReport',['uid'=>$uid,'faq'=>$faq]);
    }
    public function getcmpbyannualreview(){
        $uid        = $this->input->post('uid');
        $plandate   = $this->input->post('plandate');
        // $status     = $this->input->post('status');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_cmpbyannualreview($uid,$plandate);
        echo '<option value="">Select Comapny</option>';
        foreach($cmp as $cmp){
             echo  $data = '<option value='.$cmp->id.'>'.$cmp->compname.'</option>';
        }
    }
    public function getcmpbyTopSpender(){
        $uid        = $this->input->post('uid');
        $plandate   = $this->input->post('plandate');
        $selectval   = $this->input->post('selectval');
        // $status     = $this->input->post('status');
        $this->load->model('Menu_model');
        if($selectval=='Top Spender'){
        $cmp=$this->Menu_model->get_cmpbytopSpender($uid,$plandate);
        }
        if($selectval=='Upsell Client'){
            $cmp=$this->Menu_model->get_cmpbyUpsellClient($uid,$plandate);
        }
        if($selectval=='Cluster Wise'){
            $selectedValue  = $this->input->post('selectedValue');
            echo $selectedValue;
        }
        if($selectval=='Focus And Positive Key Client'){
            echo 'Focus And Positive Key Client';
        }
        if($selectval=='Focus Lead For this Quarter 1'){
            echo 'Focus Lead For this Quarter 1';
        }
        echo '<option value="">Select Comapny</option>';
        foreach($cmp as $cmp){
             echo  $data = '<option value='.$cmp->id.'>'.$cmp->compname.'</option>';
        }
    }
    public function HumHongeTaiyar(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $faq = $this->db->select('*')->from('faqquestion')->where('user_id',$uid)->get()->result();
        $allResource = $this->db->select('*')->from('allresourcedata')->where('user_id',$uid)->get()->result();
        $this->load->view($dep_name.'/HumHongeTaiyar',['uid'=>$uid, 'faq' => $faq,'allResource'=>$allResource,'user' => $user]);
    }
    // public function getcmpbyRMTaskAssign(){
    // }
    public function addAllResource(){
        // var_dump(implode(', ', $this->input->post('reference'))); exit;
        $pointscover = $this->input->post('pointscover');
        // $pptref = $this->input->post('reference');
        $fileda = $this->input->post('attactppt');
        if(isset($_FILES['filname']['name'])){$filname = $_FILES['filname']['name'];
            $uploadPath = 'uploads/allResource/';
            $this->load->model('Menu_model');
            // $flink = $this->Menu_model->uploadFile11($filname, $uploadPath);
            $flink = $this->Menu_model->muploadfile($filname, $uploadPath);
        }else{$this->load->model('Menu_model');$flink=0;}
        // var_dump($flink); exit;
        $user = $this->input->post('uid');
        $type= $this->input->post('type');
        $message = $this->input->post('message');
        $partnership = $this->input->post('partnership');
        $proposalname = $this->input->post('proposal');
        $presentationtype = $this->input->post('presentationtype');
        $faq = $this->input->post('faq');
        $depttype = $this->input->post('depttype');
        $deptdetail = $this->input->post('deptdetail');
        $slideno = $this->input->post('slideno');
        $data = [
            'user_id'       => $user,
            'type'          => $type,
            'pointscover'   => $pointscover,
            'filesupload'   => implode(', ', $flink),
            'reference'     => implode(', ', $this->input->post('reference')),
            'message'       => $message,
            'partnertype'   => $partnership,
            'proposalname'  => $proposalname,
            'presentationtype' => $presentationtype,
            'question'      => $faq,
            'deptdetails'    => $deptdetail,
            'depttype'      => $depttype,
            'slideno'       => $slideno
            ];
        $this->db->insert('allresourcedata',$data);
        redirect('Menu/HumHongeTaiyar');
        // echo $this->db->last_query(); exit;
    }
    public function getstatusbycompany(){
        $inid = $this->input->post('inid');
        $last = $this->db->select('*')->from('init_call')->where('id',$inid)->get()->row();
        $status = $this->db->select('*')->from('status')->where('id',$last->lstatus)->get()->row();
        // var_dump($status); exit;
        echo $status->name;
    }
    public function AddSchoolDetails(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $sdetails = $this->db->select('*')->from('schoolDetails')->where('user_id',$uid)->get()->result();
        $this->load->view($dep_name.'/AddSchoolDetails',['uid' => $uid,'user'=>$user, 'sdetails' => $sdetails]);
    }
    public function insertSchoolDetails(){
        $user = $this->input->post('uid');
        $clientname = $this->input->post('clientname');
        $district = $this->input->post('district');
        $slocation = $this->input->post('slocation');
        $noofschool = $this->input->post('noofschool');
        $data = [
            'user_id'   => $user,
            'client_name'   => $clientname,
            'district'=> $district,
            'location'=> $slocation,
            'noofschools'=> $noofschool,
            'createdat'=> date('Y-m-d H:i:s'),
            'updatedat'=> date('Y-m-d H:i:s'),
            ];
        $this->db->insert('schoolDetails',$data);
        redirect('Menu/HumHongeTaiyar');
    }
    public function getannualreviewcmpbybd(){
        $user = $_POST['user'];
        $userdata = $this->db->select('*')->from('user_details')->where('user_id',$user)->get()->row();
        $query = $this->db->select('*,company_master.compname')
                              ->from('annualreviewtarget')
                              ->join('company_master', 'company_master.id = annualreviewtarget.company_id')
                              ->where([
                                  'annualreviewtarget.user_id' => $user
                                //   'annualreviewtarget.is_approved' => ''
                              ]);
        if($userdata->type_id == 3){
            $query->where('annualreviewtarget.cluster_approve !=', '');
        }else{
            $query->where('annualreviewtarget.is_approved', '');
        }
        $company = $query->get()->result();
        // echo $this->db->last_query(); exit;
        $data = '<option selected disabled>Select Company</option>';
        foreach($company as $c){
            // var_dump($task); exit;
            $data .= '<option value='.$c->id.'>'.$c->compname.'</option>';
        }
        echo $data;
    }
    // public function getAnnualReviewCompany(){
    //     $userid = $this->input->post('bd');
    //     $company = $this->input->post('company');
    //     $annualTarget = $this->db->select('*')->from('annualreviewtarget')->where(['user_id'=>$userid,'company_id'=>$company])->get()->result();
    //     // echo $this->db->last_query(); exit;
    //     // redirect('Menu/AnnualReviewReport',['annualTarget'=>$annualTarget]);
    //     $this->load->view($dep_name.'/AnnualReviewReport',['annualTarget'=>$annualTarget]);
    // }
    public function AnnualReviewDetails($company){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $annualTarget = $this->db->select('*')->from('annualreviewtarget')->where(['company_id'=>$company])->get()->result();
        $annualdata   = $this->db->select('*')->from('annualreviewdetails')->where(['company_id'=>$company])->get()->result();
        $this->load->view($dep_name.'/AnnualReviewDetails',['user'=>$user,'annualTarget'=>$annualTarget,'annualdata'=>$annualdata]);
    }
    
    
    public function AnnualReviewDetailsData($company,$tuid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $annualTarget = $this->db->select('*')->from('annualreviewtarget')->where(['company_id'=>$company,'user_id'=>$tuid])->get()->result();
        $annualdata   = $this->db->select('*')->from('annualreviewdetails')->where(['company_id'=>$company,'user_id'=>$tuid])->get()->result();
            // $str = $this->db->last_query();
            // echo $str;
        $this->load->view($dep_name.'/AnnualReviewDetails',['user'=>$user,'annualTarget'=>$annualTarget,'annualdata'=>$annualdata]);
    }
      public function AnnualReviewDetails1($company,$user_id){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $annualTarget = $this->db->select('*')->from('annualreviewtarget')->where(['company_id'=>$company,'user_id'=>$user_id])->get()->result();
        $annualdata   = $this->db->select('*')->from('annualreviewdetails')->where(['company_id'=>$company,'user_id'=>$user_id])->get()->result();
        //  echo "<pre>";
        //  print_r($annualTarget);
        //  print_r($annualdata);
        //  die;
        $this->load->view($dep_name.'/AnnualReviewDetails',['user'=>$user,'annualTarget'=>$annualTarget,'annualdata'=>$annualdata,'company_id'=>$company,'user_id'=>$user_id]);
    }
    public function newFinancialYearData($userid,$type){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if($type == 'transfer'){
            $cmp = $this->db->select('*')->from('annualreviewtarget')->where(['keep_company' => 'no','user_id'=>$userid])->get()->result();
        }else if($type == 'quarter1'){
            $cmp = $this->db->select('*')->from('annualreviewtarget')->where(['focusfunnel' => 'yes', 'keep_company' => 'yes','user_id'=>$userid])->get()->result();
        }else if($type == 'quarter2'){
            $cmp = $this->db->select('*')->from('annualreviewtarget')->where(['focusfunnel' => 'no', 'keep_company' => 'yes','user_id'=>$userid,'focusquarter'=>'Focus for Quarter 2'])->get()->result();
        }else if($type == 'quarter3'){
            $cmp = $this->db->select('*')->from('annualreviewtarget')->where(['focusfunnel' => 'no', 'keep_company' => 'yes','user_id'=>$userid,'focusquarter'=>'Focus for Quarter 3'])->get()->result();
        }else if($type == 'quarter4'){
            $cmp = $this->db->select('*')->from('annualreviewtarget')->where(['focusfunnel' => 'no', 'keep_company' => 'yes','user_id'=>$userid,'focusquarter'=>'Focus for Quarter 4'])->get()->result();
        }else if($type == 'open'){
            $cmp = $this->db->select('*')->from('annualreviewtarget')->where(['status' => '1', 'keep_company' => 'yes','user_id'=>$userid])->get()->result();
        }else if($type == 'openrpm'){
            $cmp = $this->db->select('*')->from('annualreviewtarget')->where(['status' => '8', 'keep_company' => 'yes','user_id'=>$userid])->get()->result();
        }else if($type == 'focusPositiveKeyClient'){
            $cmp = $this->db->select('*')->from('annualreviewtarget')->where(['focuspositive' => 'yes','keep_company' => 'yes','user_id'=>$userid])
            ->where('pst_approve !=', 'Reject')
            ->where('cluster_approve !=', 'Reject')
            ->where('is_approved !=', 'Reject')
            ->get()->result();
        }else{
            $cmp = $this->db->select('*')->from('annualreviewtarget')->where([$type => 'yes', 'keep_company' => 'yes','user_id'=>$userid])->get()->result();
        }
        // echo $this->db->last_query(); exit;
        $this->load->view($dep_name.'/newFinancialYearData',['user'=>$user,'uid'=>$uid,'cmp'=>$cmp,'type'=>$type]);
    }
    public function newFinancialYearDataUpdated($userid,$type){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if($type == 'transfer'){
            $cmp = $this->db->select('*')->from('init_call')->where(['keycompany' => 'no','mainbd'=>$userid])->get()->result();
        }else if($type == 'quarter1'){
            $cmp = $this->db->select('*')->from('annualreviewtarget')->where(['focusfunnel' => 'yes', 'keep_company' => 'yes','user_id'=>$userid,'is_admin_approved'=>'Approve'])->get()->result();
        }else if($type == 'quarter2'){
            $cmp = $this->db->select('*')->from('annualreviewtarget')->where(['focusfunnel' => 'no', 'keep_company' => 'yes','user_id'=>$userid,'focusquarter'=>'Focus for Quarter 2','is_admin_approved'=>'Approve'])->get()->result();
        }else if($type == 'quarter3'){
            $cmp = $this->db->select('*')->from('annualreviewtarget')->where(['focusfunnel' => 'no', 'keep_company' => 'yes','user_id'=>$userid,'focusquarter'=>'Focus for Quarter 3','is_admin_approved'=>'Approve'])->get()->result();
        }else if($type == 'quarter4'){
            $cmp = $this->db->select('*')->from('annualreviewtarget')->where(['focusfunnel' => 'no', 'keep_company' => 'yes','user_id'=>$userid,'focusquarter'=>'Focus for Quarter 4','is_admin_approved'=>'Approve'])->get()->result();
        }else if($type == 'open'){
            $cmp = $this->db->select('*')->from('annualreviewtarget')->where(['status' => '1', 'keep_company' => 'yes','user_id'=>$userid])->get()->result();
        }else if($type == 'openrpm'){
            $cmp = $this->db->select('*')->from('annualreviewtarget')->where(['status' => '8', 'keep_company' => 'yes','user_id'=>$userid])->get()->result();
        }else if($type == 'focusPositiveKeyClient'){
            $cmp = $this->db->select('*')->from('init_call')->where(['focuspositive' => 'yes','mainbd'=>$userid])->get()->result();
        }else{
            $cmp = $this->db->select('*')->from('init_call')->where([$type => 'yes','mainbd'=>$userid])->get()->result();
        }
// dd($cmp);
        // echo $this->db->last_query(); exit;
        $this->load->view($dep_name.'/newFinancialYearDataUpdated',['user'=>$user,'uid'=>$uid,'cmp'=>$cmp,'type'=>$type]);
    }
    public function HumHongeTaiyarReport(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $revDatatar = $this->db->select('*')->from('allresourcedata')->where(['user_id'=>$uid])->get()->result();
        $school = $this->db->select('*')->from('schoolDetails')->where(['user_id'=>$uid])->get()->result();
        $this->load->view($dep_name.'/HumHongeTaiyarReport',['user'=>$user,'uid'=>$uid,'revDatatar'=>$revDatatar,'school'=>$school]);
    }
    public function rejectResource(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $id = $this->input->post('reject');
        $rejectreamrk = $this->input->post('rejectreamrk');
        if($uyid == 4){
            $this->db->where('id',$id)->update('allresourcedata',['pst_approve'=>'Reject','pst_remark' => $rejectreamrk]);
            $this->db->where('id',$id)->update('allresourcedata',['pst_name'=>$user['name']]);
        }
        if($uyid == 13){
            $this->db->where('id',$id)->update('allresourcedata',['cluster_approve'=>'Reject','cluster_remark' => $rejectreamrk]);
            $this->db->where('id',$id)->update('allresourcedata',['cluster_name'=>$user['name']]);
        }
        if($uyid == 8){
            $this->db->where('id',$id)->update('allresourcedata',['is_approved'=>$a]);
            $this->db->where('id',$id)->update('allresourcedata',['is_approve_remark'=>$rejectreamrk]);
        }
        if($uyid == 9){
            $this->db->where('id',$id)->update('allresourcedata',['is_approved'=>$a]);
            $this->db->where('id',$id)->update('allresourcedata',['is_approve_remark'=>$rejectreamrk]);
        }
        $this->load->library('session');
        $this->session->set_flashdata('action_message','SuccessFully Rejected');
        redirect('Menu/HumHongeTaiyarReport');
    }
    public function rejectResourceSchool(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $id = $this->input->post('reject');
        $rejectreamrk = $this->input->post('rejectreamrk');
        if($uyid == 4){
            $this->db->where('id',$id)->update('schoolDetails',['pst_approve'=>'Reject','pst_remark' => $rejectreamrk]);
            $this->db->where('id',$id)->update('schoolDetails',['pst_name'=>$user['name']]);
        }
        if($uyid == 13){
            $this->db->where('id',$id)->update('schoolDetails',['cluster_approve'=>'Reject','cluster_remark' => $rejectreamrk]);
            $this->db->where('id',$id)->update('schoolDetails',['cluster_name'=>$user['name']]);
        }
        if($uyid == 8){
            $this->db->where('id',$id)->update('schoolDetails',['is_approved'=>$a]);
            $this->db->where('id',$id)->update('schoolDetails',['is_approve_remark'=>$rejectreamrk]);
        }
        if($uyid == 9){
            $this->db->where('id',$id)->update('schoolDetails',['is_approved'=>$a]);
            $this->db->where('id',$id)->update('schoolDetails',['is_approve_remark'=>$rejectreamrk]);
        }
        $this->load->library('session');
        $this->session->set_flashdata('action_message','SuccessFully Rejected');
        redirect('Menu/HumHongeTaiyarReport');
    }
    public function approveAllResource($id,$type){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $atarget = $this->db->select('*')->from('allresourcedata')->where('id',$id)->get()->row();
        $utype = $this->db->select('*')->from('user_details')->where('user_id',$atarget->user_id)->get()->row();
        if($uyid == 4){
            $this->db->where('id',$id)->update('allresourcedata',['pst_approve'=>$type]);
            $this->db->where('id',$id)->update('allresourcedata',['pst_name'=>$user['name']]);
            if($utype->type_id == 13){
                $this->db->where('id',$id)->update('allresourcedata',['is_approve'=>'Approve']);
                $this->db->where('id',$id)->update('allresourcedata',['is_approve_remark'=>$rejectreamrk]);
            }
        }
        if($uyid == 13){
            $this->db->where('id',$id)->update('allresourcedata',['cluster_approve'=>$type]);
            $this->db->where('id',$id)->update('allresourcedata',['cluster_name'=>$user['name']]);
        }
        if($uyid == 2){
            if($type == 'Approve'){
                $type = 'Approved';
                $this->db->where('id',$id)->update('allresourcedata',['is_admin_approved'=>$type]);
                $this->db->where('id',$id)->update('allresourcedata',['admin_remark'=>'Approved By Admin']);
            }else{
            $this->db->where('id',$id)->update('allresourcedata',['is_admin_approved'=>$type]);
            $this->db->where('id',$id)->update('allresourcedata',['admin_remark'=>'Reject By Admin']);
            }
        }
        if($uyid == 8){
            $this->db->where('id',$id)->update('allresourcedata',['is_approve'=>'Approve']);
            $this->db->where('id',$id)->update('allresourcedata',['is_approve_remark'=>$rejectreamrk]);
        }
        if($uyid != 9){
            if($utype->type_id == 3 && ($atarget->cluster_approve != "" || $atarget->pst_approve != "")){
                $this->db->where('id',$id)->update('allresourcedata',['is_approve'=>'Approve']);
                $this->db->where('id',$id)->update('allresourcedata',['is_approve_remark'=>$rejectreamrk]);
            }
        }else{
            $this->db->where('id',$id)->update('allresourcedata',['is_approve'=>'Approve']);
            $this->db->where('id',$id)->update('allresourcedata',['is_approve_remark'=>$rejectreamrk]);
        }
        // echo $this->db->last_query(); exit;
        $this->load->library('session');
        $this->session->set_flashdata('action_message','SuccessFully Updated');
        redirect('Menu/HumHongeTaiyarReportAdmin');
    }
    public function approveAllResourceSchool($id,$type){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $atarget = $this->db->select('*')->from('schoolDetails')->where('id',$id)->get()->row();
        $utype = $this->db->select('*')->from('user_details')->where('user_id',$atarget->user_id)->get()->row();
        if($uyid == 4){
            $this->db->where('id',$id)->update('schoolDetails',['pst_approve'=>$type]);
            $this->db->where('id',$id)->update('schoolDetails',['pst_name'=>$user['name']]);
            if($utype->type_id == 13){
                $this->db->where('id',$id)->update('schoolDetails',['is_approve'=>'Approve']);
                $this->db->where('id',$id)->update('schoolDetails',['is_approve_remark'=>$rejectreamrk]);
            }
        }
     if($uyid == 2){
            if($type == 'Approve'){
                $type = 'Approved';
                $this->db->where('id',$id)->update('schoolDetails',['is_admin_approved'=>$type]);
            }else{
            $this->db->where('id',$id)->update('allresourcedata',['is_admin_approved'=>$type]);
            }
            redirect('Menu/HumHongeTaiyarReportAdmin');
        }
        if($uyid == 13){
            $this->db->where('id',$id)->update('schoolDetails',['cluster_approve'=>$type]);
            $this->db->where('id',$id)->update('schoolDetails',['cluster_name'=>$user['name']]);
        }
        if($uyid == 8){
            $this->db->where('id',$id)->update('schoolDetails',['is_approve'=>'Approve']);
            $this->db->where('id',$id)->update('schoolDetails',['is_approve_remark'=>$rejectreamrk]);
        }
        if($uyid != 9){
            if($utype->type_id == 3 && ($atarget->cluster_approve != "" || $atarget->pst_approve != "")){
                $this->db->where('id',$id)->update('schoolDetails',['is_approve'=>'Approve']);
                $this->db->where('id',$id)->update('schoolDetails',['is_approve_remark'=>$rejectreamrk]);
            }
        }else{
            $this->db->where('id',$id)->update('schoolDetails',['is_approve'=>'Approve']);
            $this->db->where('id',$id)->update('schoolDetails',['is_approve_remark'=>$rejectreamrk]);
        }
        // echo $this->db->last_query(); exit;
        $this->load->library('session');
        $this->session->set_flashdata('action_message','SuccessFully Update');
        redirect('Menu/HumHongeTaiyarReport');
    }
     public function ApproveResourceFaqAdmin(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        // print_r($_POST);
        $id = $this->input->post('approveid');
        $approvedmsg = $this->input->post('approvedmsg');
          if($uyid == 2){
            $this->db->query("UPDATE `allresourcedata` SET `is_admin_approved`='Approved', `admin_remark`='$approvedmsg' WHERE id='$id'");
            $this->load->library('session');
            $this->session->set_flashdata('action_message','SuccessFully Approved');
            redirect('Menu/HumHongeTaiyarReportAdmin');
          }
     }
     public function RejectResourceFaqAdmin(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        // print_r($_POST);
        // die;
        $id = $this->input->post('rejectid');
        $approvedmsg = $this->input->post('rejectreamrk');
          if($uyid == 2){
            $this->db->query("UPDATE `allresourcedata` SET `is_admin_approved`='Reject', `admin_remark`='$approvedmsg' WHERE id='$id'");
            $this->load->library('session');
            $this->session->set_flashdata('action_message','SuccessFully Reject');
            redirect('Menu/HumHongeTaiyarReportAdmin');
          }
     }
    public function ApproveResourceFaq(){
       $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $id = $this->input->post('approvedid');
        $rejectreamrk = $this->input->post('approvedmsg');
        $atarget = $this->db->select('*')->from('allresourcedata')->where('id',$id)->get()->row();
        $utype = $this->db->select('*')->from('user_details')->where('user_id',$atarget->user_id)->get()->row();
        if($uyid == 4){
            $this->db->where('id',$id)->update('allresourcedata',['pst_approve'=>'Approve','pst_remark' => $rejectreamrk]);
            $this->db->where('id',$id)->update('allresourcedata',['pst_name'=>$user['name']]);
            if($utype->type_id == 13){
                $this->db->where('id',$id)->update('allresourcedata',['is_approve'=>'Approve']);
                $this->db->where('id',$id)->update('allresourcedata',['is_approve_remark'=>$rejectreamrk]);
            }
        }
        if($uyid == 13){
            $this->db->where('id',$id)->update('allresourcedata',['cluster_approve'=>'Approve','cluster_remark' => $rejectreamrk]);
            $this->db->where('id',$id)->update('allresourcedata',['cluster_name'=>$user['name']]);
        }
        if($uyid == 8){
            $this->db->where('id',$id)->update('allresourcedata',['is_approve'=>'Approve']);
            $this->db->where('id',$id)->update('allresourcedata',['is_approve_remark'=>$rejectreamrk]);
        }
        if($uyid != 9){
            if($utype->type_id == 3 && $atarget->cluster_approve != "" && $atarget->pst_approve != ""){
                $this->db->where('id',$id)->update('allresourcedata',['is_approve'=>'Approve']);
                $this->db->where('id',$id)->update('allresourcedata',['is_approve_remark'=>$rejectreamrk]);
            }
        }else{
                $this->db->where('id',$id)->update('allresourcedata',['is_approve'=>'Approve']);
                $this->db->where('id',$id)->update('allresourcedata',['is_approve_remark'=>$rejectreamrk]);
            }
        // echo $this->db->last_query(); exit;
        $this->load->library('session');
        $this->session->set_flashdata('action_message','SuccessFully Approved');
        redirect('Menu/HumHongeTaiyarReport');
    }
    public function HumHongeTaiyarReportAdmin(){
       $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $userdata = $this->db->select('user_id')->from('user_details')->where(['admin_id'=>$uid,'status'=>'active'])->get()->result();
        $userIds = array_map(function($user) {
            return $user->user_id;
        }, $userdata);
        $school = $this->db->select('*')->from('schoolDetails')->where_in('user_id', $userIds)->get()->result();
        $revDatatar = $this->db->select('*')->from('allresourcedata')->where(['is_approve'=>'Approve','is_admin_approved'=>''])->where_in('user_id', $userIds)->get()->result();
        // $str = $this->db->last_query();
        // echo $str;
        // die;
        $this->load->view($dep_name.'/HumHongeTaiyarReport',['uid'=>$uid,'revDatatar'=>$revDatatar,'user'=>$user,'school'=>$school]);
    }
    public function HumHongeTaiyarReportApprove(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $userdata = $this->db->select('user_id')->from('user_details')->where(['admin_id'=>$uid,'status'=>'active'])->get()->result();
        $userIds = array_map(function($user) {
            return $user->user_id;
        }, $userdata);
        $school = $this->db->select('*')->from('schoolDetails')->where_in('user_id', $userIds)->get()->result();
        // $revDatatar = $this->db->select('*')->from('allresourcedata')->where(['is_approve'=>'Approve'])->where_in('user_id', $userIds)->get()->result();
         $revDatatar = $this->db->select('*')->from('allresourcedata')->where(['is_approve'=>'Approve','is_admin_approved'=>'Approved'])->where_in('user_id', $userIds)->get()->result();
        $this->load->view($dep_name.'/HumHongeTaiyarReportApprove',['uid'=>$uid,'revDatatar'=>$revDatatar,'user'=>$user,'school'=>$school]);
    }
    public function approveResourceReview($id,$type){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
          if($uyid == 2){
            if($type == 'Approve'){
                $type = 'Approved';
                $this->db->where('id',$id)->update('allresourcedata',['is_admin_approved'=>$type]);
            }else{
                $this->db->where('id',$id)->update('allresourcedata',['is_admin_approved'=>$type]);
            }
        }
        $this->load->library('session');
        $this->session->set_flashdata('action_message','SuccessFully Approved');
        redirect('Menu/HumHongeTaiyarReportAdmin');
    }
    public function approveResourceReviewSchool($id,$type){
        $this->db->where('id',$id)->update('allresourcedata',['is_admin_approved'=>$type]);
        $this->load->library('session');
        $this->session->set_flashdata('action_message','SuccessFully Approved');
        redirect('Menu/HumHongeTaiyarReportAdmin');
    }
    public function ResourceReviewSchoolRejectByAdmin(){
        $id = $this->input->post('reject');
        $rejectreamrk = $this->input->post('rejectreamrk');
        $this->db->where('id',$id)->update('schoolDetails',['is_admin_approved'=>$type]);
        $this->session->set_flashdata('action_message','SuccessFully Rejected');
        redirect('Menu/HumHongeTaiyarReportAdmin');
    }
    public function AllResourceDetails($userid,$type){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if($type == "school"){
            $revDatatar = $this->db->select('*')->from('schoolDetails')->where(['user_id' => $userid])->get()->result();
        }else{
            $revDatatar = $this->db->select('*')->from('allresourcedata')->where(['user_id' => $userid, 'type'=>$type])->get()->result();
        }
        $this->load->view($dep_name.'/AllResourceDetails',['uid'=>$uid,'revDatatar'=>$revDatatar,'user'=>$user,'type'=>$type]);
    }
    public function AllResourceDetailsData($userid,$type,$column,$approve){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if($approve == "approve"){
            $app = "Approve";
        } if($approve == "reject"){
            $app = "Reject";
        }
        if($approve == "pending"){
            $app = "";
        }
        if($type == "school"){
            $revDatatar = $this->db->select('*')->from('schoolDetails')->where(['user_id' => $userid, $column => $app])->get()->result();
        }else{
            $revDatatar = $this->db->select('*')->from('allresourcedata')->where(['user_id' => $userid, 'type'=>$type,$column => $app])->get()->result();
        }
        // echo $this->db->last_query(); exit;
        $this->load->view($dep_name.'/AllResourceDetails',['uid'=>$uid,'revDatatar'=>$revDatatar,'user'=>$user,'type'=>$type]);
    }
// public function DeleteDuplicateRecord(){
//     $user = $this->session->userdata('user');
//     $data['user'] = $user;
//     $uid = $user['user_id'];
//     $uyid =  $user['type_id'];
//     $this->load->model('Menu_model');
//     $dt=$this->Menu_model->get_utype($uyid);
//     $dep_name = $dt[0]->name;
//     $query = $this->db->query("SELECT user_id FROM `user_details` WHERE type_id in(3,4,5,9,13,11,12)");
//     $data1  = $query->result();
//    foreach($data1 as $d){
//     $query1 = $this->db->query("SELECT company_id, COUNT(company_id) AS cnt FROM annualreviewtarget WHERE user_id = '$d->user_id' GROUP BY company_id HAVING COUNT(company_id) > 1");
//     $data2  = $query1->result();
//     if(sizeof($data2) > 1){
//         foreach($data2 as $d2){
//             $company_id = $d2->company_id;
//             $query2 = $this->db->query("SELECT * FROM `annualreviewtarget` WHERE user_id = '$d->user_id' AND company_id = $company_id");
//             $data3  = $query2->result();
//             unset($data3[0]);
//             foreach($data3 as $d3){
//                 $tid = $d3->id;
//                 $query2 = $this->db->query("DELETE FROM `annualreviewtarget` WHERE id=$tid");
//             }
//             // die("stem");
//         }
//     }
// echo "success <br/>";
//    }
// }
// public function DeleteRecord(){
//     $user = $this->session->userdata('user');
//     $data['user'] = $user;
//     $uid = $user['user_id'];
//     $uyid =  $user['type_id'];
//     $this->load->model('Menu_model');
//     $dt=$this->Menu_model->get_utype($uyid);
//     $dep_name = $dt[0]->name;
//     $query = $this->db->query("SELECT * FROM `annualreviewtarget` WHERE user_id=100150 AND keep_company = 'no'");
//     $data1  = $query->result();
//   foreach($data1 as $d){
//     $tid = $d->id;
//     $company_id = $d->company_id;
//     $user_id = $d->user_id;
//     $query2 = $this->db->query("DELETE FROM `annualreviewdetails` WHERE company_id = $company_id AND user_id = $user_id");
//     $query3 = $this->db->query("DELETE FROM `annualreviewtarget` WHERE id=$tid");
//   }
//     echo "Success";
// }
        public function CompanyUpdateUsingCsv(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $this->load->view($dep_name.'/CompanyUpdateUsingCsv',['uid'=>$uid,'user'=>$user]);
    }
   public function UploadCompanyCSV(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if($uyid == 2){
            $isapprove = true;
        }else{
            $this->load->library('session');
            $this->session->set_flashdata('action_message', 'You are not Authrized to Access this action.');
            redirect('Menu/Dashboard');
        }
    if($isapprove){
        $file_path  = "https://stemapp.in/uploads/CompanyCSV/ATeam.csv";
          if (($handle = fopen($file_path, "r")) !== FALSE) {
                $csv_data = array();
                while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $csv_data[] = $row;
                }
                fclose($handle);
                unset($csv_data[0]);
                echo "<pre>";
                print_r($csv_data);
                die;
                $k=1;
                foreach($csv_data as $cdata){
                        $tid                = $cdata[0];        // ttable row id
                        $company_id         = $cdata[1];        // Company Id
                        $revuser_id         = $cdata[2];        // Review User ID
                        $current_status     = $cdata[3];        // Current Status
                        $current_ysid       = $cdata[4];        // Current year Status ID
                        $is_this_location   = $cdata[5];        // Is this Location is Right?
                        $keeping_comapny    = $cdata[6];        // Will be keeping this company with you?
                        $face_to_face       = $cdata[7];        // Did you have any face to face or virtual meeting with client?
                        $cluster_id         = $cdata[8];        // Cluster ID
                        $key_Client         = $cdata[9];        // Focus And Positive Key Client For FY 2024-25
                        $focus_lead         = $cdata[10];       // Focus Lead For this Quarter 1?
                        $top_spender        = $cdata[11];       // Top Spender For this Year?
                        $upsell_Client      = $cdata[12];       // Is This Upsell Client?
                        $intervention_id    = $cdata[13];       // Intervention ID
                        $support            = $cdata[14];       // What Support You Required In Detail?
                        $no_of_school       = $cdata[15];       // No of school
                        $expected_revenue   = $cdata[16];       // Expected Revenue
                        $open               = $cdata[17];       // Open
                        $reachout           = $cdata[18];       // Reachout
                        $tentative          = $cdata[19];       // Tentative
                        $positive           = $cdata[20];       // Positive
                        $very_positive      = $cdata[21];       // Very Positive
                        $positive_nap       = $cdata[22];       // Positive nap
                        $closer             = $cdata[23];       // Closure
                        $approved = 'Approve';
                        $remarks = 'Admin Approved';
                        $annual = $this->db->select('*')->from('annualreviewtarget')
                                       ->where('id',$tid)->get()->row();
                        $init = $this->db->select('*')->from('init_call')
                            ->where(['cmpid_id'=>$company_id])->get()->row();
                        // echo "<pre>";
                        // print_r($cdata);
                        // die;
                        if($annual->is_admin_approved == ''){
                        $this->db->where('id',$tid)->update('annualreviewtarget',['is_admin_approved'=>$approved,'is_admin_remarks'=>$remarks]);
                        $this->db->where('id',$init->id)->update('init_call',
                            ['topspender'=>$top_spender,
                            'cstatus'=>$current_ysid,
                            'focus_funnel'=>$focus_lead,
                            'keycompany'=>$keeping_comapny,
                            'exrevenue'=>$expected_revenue,
                            'noofschools'=>$no_of_school,
                            'fyear'=>$annual->fyear,
                            'open'=>$annual->open,
                            'reachout'=>$reachout,
                            'positive'=>$positive,
                            'positivenap'=>$positive_nap,
                            'tentative'=>$tentative,
                            'closure'=>$closer,
                            'verypositive'=>$very_positive,
                            'vmeeting'=>$face_to_face,
                            'cluster_id'=>$cluster_id,
                            'focuspositive'=>$key_Client,
                            'interventions'=>$intervention_id,
                            'keep_company'=>$keeping_comapny,
                            'review_date'=>$annual->createdat,
                            'support'=>$support]);
                        $this->db->where('id',$company_id)->update('company_master',
                        ['partnerType_id'=>$annual->partnertype]);
                        if($keeping_comapny == 'no'){
                            // $this->db->where('id',$init->id)->update('init_call',
                            // ['is_deleted'=>1,
                            // 'deleted_by'=>$revuser_id
                            // ]);
                        $company_delete = [
                                'cid' => $company_id,
                                'user_id' => $revuser_id,
                                'deleted_remarks' => $annual->keepremark
                           ];
                        $this->db->insert('deleted_company',$company_delete);
                          }else{
                        //       $fwd_date = date('Y-m-d H:i:s');
                        //       $data = [
                        //         'lastCFID' => 0,
                        //         'nextCFID' => 0,
                        //         'fwd_date' => $fwd_date,
                        //         'actiontype_id' => 15,
                        //         'assignedto_id' => $annual->user_id,
                        //         'purpose_id' => 127,
                        //         'targetstatus' => 0,
                        //         'actontaken' => 'no',
                        //         'purpose_achieved' => 'no',
                        //         'cid_id'=>$init->id,
                        //         'remarks'=>'After Focus funnel and Top Spender And Partner Type details are updated',
                        //         'status_id'=>$current_ysid,
                        //         'user_id' => $annual->user_id,
                        //         'date' => date('Y-m-d H:i:s'),
                        //         'updateddate' => date('Y-m-d H:i:s'),
                        //         'is_new' => 1
                        //     ];
                        //     $this->db->insert('tblcallevents',$data);
                          }
                        if($annual->location !==''){
                          $this->db->where('id',$company_id)->update('company_master',['locations'=>$annual->location]);
                        }
                        $compname = $this->Menu_model->get_cdbyid($company_id)[0]->compname;
                        echo "[".$k."] = ".$company_id ." - $compname ----------- Company Updated Succesffully<br>";
                    }else{
                        echo "[".$k."] = ".$company_id ." - $compname ----------- Company Allready Updated <br/>";
                    }
                $k++;
                }
                }else{
                    echo "Files are not exists";
                }
        }
        die("stem pvt ltd");
        $this->load->view($dep_name.'/CompanyUpdateUsingCsv',['uid'=>$uid,'user'=>$user]);
    }
    public function deleteCompanyFunnel(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $getcmp  =  $this->db->query("SELECT * FROM `deleted_company` WHERE is_delete = 0");
        $getcmpany =  $getcmp->result();
        die("Stem PVT LTD");
        $k=1;
        foreach($getcmpany as $cmp){
            $getcmpd  =  $this->db->query("SELECT * FROM `init_call` WHERE cmpid_id = '$cmp->cid'");
            $getcmpanyd =  $getcmpd->result();
            $getid = $getcmpanyd[0]->id;
            // echo "<pre>";
            // print_r($getid);
      
            
            $getcmpd  =  $this->db->query("UPDATE `init_call` SET `mainbd`='0',`insidebd`='0',`bdid`='0',`abd`='0',`apst`='0',`bpst`='0',`cpst`='0' WHERE id ='$getid'");
            $did = $cmp->id;
            $getcmpd  =  $this->db->query("UPDATE `deleted_company` SET `is_delete`= '1' WHERE id = $did");
            $compname = $this->Menu_model->get_cdbyid($cmp->cid)[0]->compname;
            echo "[".$k."] = ".$cmp->cid ." - $compname ----------- Company Deleted Successfully<br>";
            $k++;
        }
    }
    public function updateAtotaskTime(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $bdid = $_POST['bdid'];
        $plandate = $_POST['pdate'];
        $plandatet = $_POST['pdate'];
        if(isset($_POST['userworkfrom'])){
            $userworkfrom = $_POST['userworkfrom'];
        }else{
            $userworkfrom = '';
        }
        $this->load->library('session');
        $date = date('Y-m-d H:i:s');
        $startautotasktime = $_POST['startautotasktime'].":00";
        $endautotasktime = $_POST['endautotasktime'].":00";
        $initiateddt = date("Y-m-d H:i:s");
        $plandate = $plandate ." ". $startautotasktime;
        $getplandateindata  =  $this->db->query("SELECT * FROM `autotask_time` where user_id='$uid' AND date ='$plandatet'");
        $getplandateindata =  $getplandateindata->result();
        $getplanrecord = sizeof($getplandateindata);
        $datetime1 = new DateTime($startautotasktime);
        $datetime2 = new DateTime($endautotasktime);
        // Calculate the difference between the two DateTime objects
        $interval = $datetime1->diff($datetime2);
        // Convert the difference to minutes
        $minutes = ($interval->h * 60) + $interval->i;
        if ($interval->invert) {
            $minutes = -$minutes;
            }
        $datetime = new DateTime($plandate);
        $start_tttpft = $_POST['start_tttpft'];
        $end_tttpft = $_POST['end_tttpft'];
        if($getplanrecord == 0){
            $datetime1 = new DateTime($startautotasktime);
            $datetime2 = new DateTime($endautotasktime);
            $interval = $datetime1->diff($datetime2);
            $minutes = $interval->h * 60 + $interval->i;
            if($minutes > 90){
                $this->session->set_flashdata('success_message',' AutoTask Time is Less Than 90 Minute only !!');
                redirect('Menu/TaskPlanner2/'.date("Y-m-d"));
            }else{
                $this->db->query("INSERT INTO `autotask_time`(`user_id`, `date`, `stime`, `etime`, `start_tttpft`, `end_tttpft`,`userworkfrom`) VALUES ('$uid','$plandatet','$startautotasktime','$endautotasktime','$start_tttpft','$end_tttpft','$userworkfrom')");
                $inid = $this->db->insert_id();
            }
            $this->session->set_flashdata('success_message',' Nice job! You Have Planned For Time For Doing AutoTask');
            
            if($plandatet == date("Y-m-d")){
                redirect('Menu/TaskPlanner2/'.date("Y-m-d"));
            }else{
                redirect('Menu/TaskPlanner2/'.$plandatet);
            }
        }else{
            $this->session->set_flashdata('success_message',' You are Allready Planned');
            redirect('Menu/TaskPlanner2/'.date("Y-m-d"));
        }
    //     $today = date('Y-m-d');
    //     $autoPlanNWork  =  $this->db->query("SELECT * FROM `tblcallevents` WHERE user_id = $uid AND (nextCFID = 0 AND lastCFID = 0 AND plan = 1 AND autotask = 1 AND auto_plan = 1 AND cast(appointmentdatetime AS DATE)  != '$today')");
    //     $autoPlanNWork =  $autoPlanNWork->result();
    //     $autoPlanNWorkcnt = sizeof($autoPlanNWork);
    //     foreach($autoPlanNWork as $pendTask){
    //         $tid = $pendTask->id;
    //         $actiontype_id = $pendTask->actiontype_id;
    //         if($actiontype_id ==5 || $actiontype_id ==8 || $actiontype_id ==9 || $actiontype_id ==10 || $actiontype_id == 15){
    //             $datetime->modify('+5 minutes');
    //             $updatedDatetimeString = $datetime->format('Y-m-d H:i:s');
    //             $minutes = $minutes - 5;
    //             }else if($actiontype_id ==2 || $actiontype_id ==6){
    //             $datetime->modify('+10 minutes');
    //             $updatedDatetimeString = $datetime->format('Y-m-d H:i:s');
    //             $minutes = $minutes - 10;
    //             }else if($actiontype_id ==3 || $actiontype_id ==4 || $actiontype_id ==12){
    //             $datetime->modify('+30 minutes');
    //             $updatedDatetimeString = $datetime->format('Y-m-d H:i:s');
    //             $minutes = $minutes - 30;
    //             }else if($actiontype_id ==7){
    //             $datetime->modify('+15 minutes');
    //             $updatedDatetimeString = $datetime->format('Y-m-d H:i:s');
    //             $minutes = $minutes - 15;
    //             }else if($actiontype_id ==11 || $actiontype_id ==13 || $actiontype_id ==14){
    //             $datetime->modify('+2 minutes');
    //             $updatedDatetimeString = $datetime->format('Y-m-d H:i:s');
    //             $minutes = $minutes - 2;
    //             }else{
    //             $updatedDatetimeString = $plandate;
    //             }
    //             $plancount++;
    //             $query=$this->db->query("UPDATE tblcallevents SET appointmentdatetime='$updatedDatetimeString', initiateddt='$updatedDatetimeString', plandt='$updatedDatetimeString', auto_plan=1 WHERE id='$tid'");
    //     }
    // $getPendingAutoTask  =  $this->db->query("SELECT * FROM `tblcallevents` WHERE user_id = $uid AND (nextCFID = 0 AND lastCFID = 0 AND plan = 1 AND autotask = 1 AND auto_plan = 0)");
    // $getPendingTask =  $getPendingAutoTask->result();
    // $pcount = sizeof($getPendingTask);
    // if($pcount > 0){
    //     $plancount =0;
    //     foreach($getPendingTask as $ptask){
    //         if($minutes > 1){
    //         $tid = $ptask->id;
    //         $actiontype_id = $ptask->actiontype_id;
    //         if($actiontype_id ==5 || $actiontype_id ==8 || $actiontype_id ==9 || $actiontype_id ==10 || $actiontype_id ==15){
    //         $datetime->modify('+5 minutes');
    //         $updatedDatetimeString = $datetime->format('Y-m-d H:i:s');
    //         $minutes = $minutes - 5;
    //         }else if($actiontype_id ==2 || $actiontype_id ==6){
    //         $datetime->modify('+10 minutes');
    //         $updatedDatetimeString = $datetime->format('Y-m-d H:i:s');
    //         $minutes = $minutes - 10;
    //         }else if($actiontype_id ==3 || $actiontype_id ==4 || $actiontype_id ==12){
    //         $datetime->modify('+30 minutes');
    //         $updatedDatetimeString = $datetime->format('Y-m-d H:i:s');
    //         $minutes = $minutes - 30;
    //         }else if($actiontype_id ==7){
    //         $datetime->modify('+15 minutes');
    //         $updatedDatetimeString = $datetime->format('Y-m-d H:i:s');
    //         $minutes = $minutes - 15;
    //         }else if($actiontype_id ==11 || $actiontype_id ==13 || $actiontype_id ==14){
    //         $datetime->modify('+2 minutes');
    //         $updatedDatetimeString = $datetime->format('Y-m-d H:i:s');
    //         $minutes = $minutes - 2;
    //         }else{
    //         $updatedDatetimeString = $plandate;
    //         }
    //         $plancount++;
    //         $query=$this->db->query("UPDATE tblcallevents SET appointmentdatetime='$updatedDatetimeString', initiateddt='$updatedDatetimeString', plandt='$updatedDatetimeString', auto_plan=1 WHERE id='$tid'");
    //         }else{
    //             $this->session->set_flashdata('success_message',' Total '.$plancount.' - Task Plan Successfully');
    //             redirect('Menu/TaskPlanner1/'.date("Y-m-d"));
    //         }
    //     }
    //     $this->session->set_flashdata('success_message',' Total '.$plancount.' - Task Plan Successfully');
    //     redirect('Menu/TaskPlanner1/'.date("Y-m-d"));
    // }else{
    //     $this->session->set_flashdata('success_message',' No Pending Task');
    //     redirect('Menu/TaskPlanner1/'.date("Y-m-d"));
    // }
    }
    public function momapproved($tid,$status){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $this->load->library('session');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $status = "Approved";
        $curdate = date("Y-m-d H:i:s");
        $currentDateTime = new DateTime();
        $currentDateTime->modify('+1 day');
        $tomorrowDateTime = $currentDateTime->format('Y-m-d H:i:s');
        $randomDateTime = $this->getRandomDateTime($tomorrowDateTime);
        $queryData = $this->db->query("SELECT * FROM tblcallevents WHERE id='$tid'");
        $queryData = $queryData->result();
        $assignedto_id = $queryData[0]->assignedto_id;
        $cid_id = $queryData[0]->cid_id;
        $draft  = 'Task Assign After Approved';
        $data = [
            'lastCFID' => $tid,
            'nextCFID' => '0',
            'draft' => $draft,
            'event' => '',
            'fwd_date' => $curdate,
            'actontaken' => 'no',
            'nextaction' => 'Write Thanks Mail',
            'meeting_type' => 'NA',
            'live_loaction' => 'NA',
            'mom_received' => 'no',
            // 'appointmentdatetime' => $randomDateTime,
            'appointmentdatetime' => $curdate,
            'actiontype_id' => '2',
            'assignedto_id' => $assignedto_id,
            'cid_id' => $cid_id,
            'purpose_id' => '1',
            'remarks' => 'RP Meeting Done',
            'status_id' => '4',
            'user_id' => $assignedto_id,
            'date' => $curdate,
            'updateddate' => $curdate,
            'updation_data_type' => 'Pending',
            'plan' => '1',
            'targetstatus' => '0',
            'autotask' => '1',
            'auto_plan' => '1'
        ];
        
        $this->db->insert('tblcallevents',$data);
        $ntid = $this->db->insert_id();
      
        $query=$this->db->query("UPDATE `tblcallevents` SET `mom_approved`='$status', `mom_remarks`='Approved Success', `mom_approved_name`='$uid' WHERE id='$tid'");
        $this->session->set_flashdata('success_message',' MOM Approved And New Auto Task (Write Thanks Mail) Assign Successfully');
        redirect('Menu/momdetail');
    }
    public function momReject(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $this->load->library('session');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $status = "Reject";
        $tid = $_POST['reject'];
        $rejectreamrk = $_POST['rejectreamrk'];
        $curdate = date("Y-m-d H:i:s");
        $currentDateTime = new DateTime();
        $currentDateTime->modify('+1 day');
        $tomorrowDateTime = $currentDateTime->format('Y-m-d H:i:s');
        $randomDateTime = $this->getRandomDateTime($tomorrowDateTime);
        $queryData = $this->db->query("SELECT * FROM tblcallevents WHERE id='$tid'");
        $queryData = $queryData->result();
        $assignedto_id = $queryData[0]->assignedto_id;
        $cid_id = $queryData[0]->cid_id;
        $draft  = 'Task Assign After Reject';
        $data = [
            'lastCFID' => $tid,
            'nextCFID' => '0',
            'draft' => $draft,
            'event' => '',
            'fwd_date' => $curdate,
            'actontaken' => 'no',
            'nextaction' => 'Write MOM',
            'meeting_type' => 'NA',
            'live_loaction' => 'NA',
            'mom_received' => 'no',
            // 'appointmentdatetime' => $randomDateTime,
            'appointmentdatetime' => $curdate,
            'actiontype_id' => '6',
            'assignedto_id' => $assignedto_id,
            'cid_id' => $cid_id,
            'purpose_id' => '1',
            'remarks' => 'RP Meeting Done',
            'status_id' => '4',
            'user_id' => $assignedto_id,
            'date' => $curdate,
            'updateddate' => $curdate,
            'updation_data_type' => 'Pending',
            'plan' => '1',
            'targetstatus' => '0',
            'autotask' => '1',
            'auto_plan' => '1'
        ];
        
        $this->db->insert('tblcallevents',$data);
        $ntid = $this->db->insert_id();
        $query=$this->db->query("UPDATE `tblcallevents` SET `mom_approved`='$status', `mom_remarks`='$rejectreamrk', `mom_approved_name`='$uid' WHERE id='$tid'");
        $this->session->set_flashdata('success_message','MOM Rejeect & New MOM Auto Task Assign Successfully');
        redirect('Menu/momdetail');
    }
    public function getRandomDateTime($endDateTime) {
        // Get the current timestamp
        $currentTimestamp = time();
        // Convert the end date and time to a timestamp
        $endTimestamp = strtotime($endDateTime);
        // Generate a random timestamp between the current and end timestamps
        $randomTimestamp = mt_rand($currentTimestamp, $endTimestamp);
        // Extract the date part from the random timestamp
        $randomDate = date('Y-m-d', $randomTimestamp);
        // Generate a random time between 10:00 AM and 7:00 PM
        $randomHour = mt_rand(10, 18);  // Hours from 10 to 18 (10:00 AM to 6:00 PM)
        $randomMinute = mt_rand(0, 59);  // Minutes from 0 to 59
        $randomSecond = mt_rand(0, 59);  // Seconds from 0 to 59
        // Format the random time part
        $randomTime = sprintf('%02d:%02d:%02d', $randomHour, $randomMinute, $randomSecond);
        // Combine the random date and time
        $randomDateTime = $randomDate . ' ' . $randomTime;
        // Convert the random datetime to a timestamp
        $randomDateTimeTimestamp = strtotime($randomDateTime);
        // Ensure the random datetime is between 10:00 AM and 7:00 PM
        if ($randomDateTimeTimestamp < strtotime($randomDate . ' 10:00:00')) {
            $randomDateTime = $randomDate . ' 10:00:00';
        } elseif ($randomDateTimeTimestamp > strtotime($randomDate . ' 19:00:00')) {
            $randomDateTime = $randomDate . ' 19:00:00';
        }
        return $randomDateTime;
    }
    public function PlannerTaskApprovelPage(){
        if(isset($_POST['sdate'])){
            $sdate = $_POST['sdate'];
        }
        else{
            $sdate = date('Y-m-d');
            $currentDateTime = new DateTime();
            $currentDateTime->modify('-1 day');
            $yesterdayDate = $currentDateTime->format('Y-m-d');
        }
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PlannerTaskApprovelPage',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'ydate'=>$yesterdayDate]);
        }else{
            redirect('Menu/main');
        }
    }
    public function PlannerTaskApprovelPageTest(){
        if(isset($_POST['sdate'])){
            $sdate = $_POST['sdate'];
        }
        else{
            $sdate = date('Y-m-d');
            $currentDateTime = new DateTime();
            $currentDateTime->modify('-1 day');
            $yesterdayDate = $currentDateTime->format('Y-m-d');
        }
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PlannerTaskApprovelPageTest',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'ydate'=>$yesterdayDate]);
        }else{
            redirect('Menu/main');
        }
    }
    public function CheckTaskDetailsByUser($userid,$taskdateselect){
       
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $this->load->library('session');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $selected_date = $this->input->post('adate');
        if(isset($_POST['adate'])){
            $taskdateselect = $_POST['adate'];
        }else{
            $taskdateselect = date("Y-m-d");
        }
    
        if(!empty($user)){
            $this->load->view($dep_name.'/CheckTaskDetailsByUser',['uid'=>$uid,'user'=>$user,'tuser_uid'=>$userid,'taskdate'=>$taskdateselect, 'selected_date' => $selected_date]);
        }else{
            redirect('Menu/main');
        }
    }
    public function updatecompanyOpenOrOpenRPM(){
       
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $this->load->library('session');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $aid = 45;
        $mdata = $this->Menu_model->get_userbyaid($aid);
         foreach($mdata as $dt){
            $bdid = $dt->user_id;
           
            if($bdid == 100138){
                continue;
                }
            $name  = $dt->name;
            $queryData = $this->db->query("SELECT * FROM init_call WHERE cstatus !=1 AND cstatus !=8 AND mainbd='$bdid'");
            $queryData = $queryData->result();
             echo "<pre>";
             print_r($queryData);
            $queryDatacnt = sizeof($queryData);
            if($queryDatacnt > 0){
                foreach($queryData as $data){
                    // echo "<pre>";
                    // print_r($data->id);
                    // print_r($data->keycompany);
    
                    // $this->db->where('id',$data->id)->update('init_call',
                    //     ['cstatus'=>1]);
                }
            }else{
                echo "All Comapny is Open or Openrpm";
            }
         
        }
        // echo "<pre>";
        // print_r($mdata);
        die;
       
      
    }
public function addplantask11(){
    $this->load->model('Menu_model');
    $this->load->model('Management_model');
    $this->load->library('session');
  
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $pendingTask = $this->Menu_model->get_allcmp_planbutnotinited($uid);
    $pendingTaskcnt = sizeof($pendingTask);
     $bdid = $this->input->post('bdid');
     $tptime = $this->input->post('tptime');
     $ptime = $this->input->post('ptime');
     $ntaction = $this->input->post('ntaction');
     $ntppose = $this->input->post('ntppose');
     $selectby = $this->input->post('selectby');
     $pdate = $this->input->post('pdate');
     $selectcompanybyuser = $this->input->post('selectcompanybyuser');
     if(sizeof($selectcompanybyuser) > 3){
        $this->session->set_flashdata('success_message',' You can only have three company plans at a time !!');
        redirect('Menu/TaskPlanner2/'.$pdate);
     }
	if(!isset($_POST['selectcompanybyuser']) && $ntaction == 10){
        $bmdate = $pdate.' '.$ptime.':00';
        $partner = $this->Menu_model->CreateNewResearchTask($bdid,$bmdate,$ntaction,$ntppose);
        $this->session->set_flashdata('success_message',' Task Planned Successfully !!');
        redirect('Menu/TaskPlanner2/'.$pdate);
     }
     $totalttaskdata =$this->Menu_model->get_totaltdetailsDatewise($bdid,$pdate);
     
     $cosumeTime = '';
 
     $getplandateindata  =  $this->db->query("SELECT * FROM `autotask_time` where user_id='$uid' AND date ='$pdate'");
     $getplandateindata =  $getplandateindata->result();
 
     if(sizeof($totalttaskdata) > 0){
        foreach($totalttaskdata as $task){
            $action = $this->Menu_model->get_actionbyid($task->actiontype_id);
            $cosumeTime +=$action[0]->yest;
        }
       
        $stime = $getplandateindata[0]->stime;
        $etime = $getplandateindata[0]->etime;
    
        $datetime1 = new DateTime($stime);
        $datetime2 = new DateTime($etime);
        $interval = $datetime1->diff($datetime2);
        $autominutes = $interval->h * 60 + $interval->i;
    
        $totalAssignTime = 540;
        $remaingtime = $totalAssignTime - $autominutes;
    
        if($cosumeTime > $remaingtime){
            $this->session->set_flashdata('success_message_plan','* Nice Job !! You have Successfully Achive Your Target Time.');
            redirect('Menu/TaskPlanner2/'.$pdate);
        }else{
            $rrtime = $remaingtime - $cosumeTime;
        }
     }
    $taskAssigntime = $pdate.' '.$ptime;
   
    foreach($selectcompanybyuser as $tid){
       
        $cmp_Data = $this->Menu_model->getCompanyStatus($tid);
        $ntstatus = $cmp_Data[0]->cstatus;
            $actiontype_id = $ntaction;
            $inid = $tid;
            if($actiontype_id ==1 || $actiontype_id ==5 || $actiontype_id ==8 || $actiontype_id ==9 || $actiontype_id ==10 || $actiontype_id ==15){
                $taskplanmincount = $taskplanmincount+5;
                $modifystr = "+$taskplanmincount minutes";
            }else if($actiontype_id ==2 || $actiontype_id ==6){
                $taskplanmincount = $taskplanmincount+10;
                $modifystr = "+$taskplanmincount minutes";
            }else if($actiontype_id ==3 || $actiontype_id ==4 || $actiontype_id ==12){
                $taskplanmincount = $taskplanmincount+30;
                $modifystr = "+$taskplanmincount minutes";
            }else if($actiontype_id ==7){
                $taskplanmincount = $taskplanmincount+15;
                $modifystr = "+$taskplanmincount minutes";
            }else if($actiontype_id ==11 || $actiontype_id ==13 || $actiontype_id ==14){
                $taskplanmincount = $taskplanmincount+2;
                $modifystr = "+$taskplanmincount minutes";
            }else{
                $new_datetime = date("y-m-d H:i:s");
            }
        $newdate = new DateTime($taskAssigntime);
        $modifystr = "+$taskplanmincount minutes";
        $newdate->modify($modifystr);
        $new_datetime = $newdate->format('Y-m-d H:i:s');
        if($selectby == 'Plan But Not Initiated'){
            
            $query =  $this->db->query("UPDATE `tblcallevents` SET `appointmentdatetime`='$new_datetime', `selectby`='$selectby' WHERE  id = $tid");
            $tbl_id = $this->Menu_model->getTBLTaskByID($tid); 
            $tbl_getaction = $tbl_id[0]->actiontype_id;
            // echo $tbl_getaction;exit;
            if($tbl_getaction == 3 || $tbl_getaction ==4){
                $query =  $this->db->query("UPDATE `barginmeeting` SET `storedt`='$new_datetime' WHERE tid =$tbl_id ");
            } 
            
        
        }else if($selectby == 'Review Target Date'){
        if($pendingTaskcnt > 0){
            $this->session->set_flashdata('success_message_plan',' First Plan Your Old Pending Task Using Filter - Plan But Not Initiated');
            redirect('Menu/TaskPlanner2/'.$pdate);
        }
           $query =  $this->db->query("UPDATE `tblcallevents` SET `appointmentdatetime`='$new_datetime', `selectby`='$selectby' WHERE  id = $tid");
        }else{
        if($pendingTaskcnt > 0){
            $this->session->set_flashdata('success_message',' First Plan Your Old Pending Task Using Filter - Plan But Not Initiated');
            redirect('Menu/TaskPlanner2/'.$pdate);
        }
            $ttype = $ntaction;
            $id = $this->Menu_model->add_plan2($pdate,$uid,$ptime,$inid,$ntaction,$ntstatus,$ntppose,$ttype,$tptime,$new_datetime,$selectby);
        }
    }
    $this->session->set_flashdata('success_message_plan',' Task Planned Successfully !! and Total Remaining Time For Task Plan '.$rrtime. ' Minutes');
    redirect('Menu/TaskPlanner2/'.$pdate);
}
public function addplantask12(){
    $this->load->model('Menu_model');
    $this->load->model('Management_model');
    $this->load->library('session');
  
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $todayspendingTask = $this->Menu_model->get_allcmp_planbutnotinited($uid);
    $pendingOldTask = $this->Menu_model->get_all_old_cmp_planbutnotinited($uid);
    $pendingTodaysTaskcnt = sizeof($todayspendingTask);
    $pendingOldTask = sizeof($pendingOldTask);
    
     $bdid = $this->input->post('bdid');
     $tptime = $this->input->post('tptime');
     $ptime = $this->input->post('ptime');
     $ntaction = $this->input->post('ntaction');
     $ntppose = $this->input->post('ntppose');
     $selectby = $this->input->post('selectby');
     $pdate = $this->input->post('pdate');
     $select_cluster = $this->input->post('select_cluster');
     $selectcompanybyuser = $this->input->post('selectcompanybyuser');
    
     if(!isset($_POST['selectcompanybyuser']) && $ntaction == 4){
        
        $bmdate = $pdate.' '.$ptime.':00';
        $partner = $this->Menu_model->createBargMeetingWithClusterId($bdid,$bmdate,$select_cluster);
        $this->session->set_flashdata('success_message',' Task Planned Successfully !!');
        redirect('Menu/TaskPlanner2/'.$pdate);
     } if(isset($_POST['selectcompanybyuser']) && $ntaction == 4){
        $ntaction = 4;
     }
     
     if($ntaction == 17){
       
        $bmdate = $pdate.' '.$ptime.':00';
        $partner = $this->Menu_model->CreateJoinMeetingTaskWithClusterId($bdid,$selectcompanybyuser,$bmdate,$ntaction,$ntppose,$select_cluster);
        $this->session->set_flashdata('success_message',' Task Planned Successfully !!');
        redirect('Menu/TaskPlanner2/'.$pdate);
        
     }
    
     if(!isset($_POST['selectcompanybyuser']) && $ntaction == 10){
        $bmdate = $pdate.' '.$ptime.':00';
        $partner = $this->Menu_model->CreateNewResearchTask($bdid,$bmdate,$ntaction,$ntppose);
        $this->session->set_flashdata('success_message',' Task Planned Successfully !!');
        redirect('Menu/TaskPlanner2/'.$pdate);
     }
    $CheckingData = $this->input->post('check_data');  // Checking_Data
     if($CheckingData == 'Mom Check'){
        $bmdate = $pdate.' '.$ptime.':00';
        $addMOMCheckTask = $this->Menu_model->CreateTaskForMOMCheck($bdid,$bmdate);
        $this->session->set_flashdata('success_message',' Task Planned Successfully !!');
        redirect('Menu/TaskPlanner2/'.$pdate);
     }
   
    
// Abhishek Data Start
     $data = array(
        'selectstatusbyuser' => $this->input->post('selectstatusbyuser'),
        'tasktaction' => $this->input->post('tasktaction'),
        'taskActionbyuser' => $this->input->post('taskActionbyuser'),
        'taskPurposebyuser' => $this->input->post('taskPurposebyuser'),
        'selectstatusbyusernotplaned' => $this->input->post('selectstatusbyusernotplaned'),
        'task_action' => $this->input->post('task_action'),
        'daysfiltercard_anp_date' => $this->input->post('daysfiltercard_anp_date'),
        'selectdcategory' => $this->input->post('selectdcategory'),
        'statusfiltercardCat' => $this->input->post('statusfiltercardCat'),
        'taskActionbyusercat' => $this->input->post('taskActionbyusercat'),
        'taskPurposebyusercatdata' => $this->input->post('taskPurposebyusercatdata'),
        'clusterNameLocaction' => $this->input->post('clusterNameLocaction'),
        'statusfilterCluster' => $this->input->post('statusfilterCluster'),
        'taskActionbyCluster' => $this->input->post('taskActionbyCluster'),
        'taskPurposebyCluster' => $this->input->post('taskPurposebyCluster'),
        'companyLocation' => $this->input->post('companyLocation'),
        'selectactionplane' => $this->input->post('selectactionplane'),
        'daysfilter' => $this->input->post('daysfilter'),
        'pstAssignCardData' => $this->input->post('pstAssignCardData'),
        'status_taskaction' => $this->input->post('status_taskaction'),
        'task_action_filter' => $this->input->post('task_action_filter'),
        'taskActionbyuserCardData' => $this->input->post('taskActionbyuserCardData'),
        'taskPurposebyuserCardData' => $this->input->post('taskPurposebyuserCardData'),
        'partnertype_select' => $this->input->post('partnertype_select'),
        'partnertype_cstatusData' => $this->input->post('partnertype_cstatusData'),
        'partnertype_taskData' => $this->input->post('partnertype_taskData'),
        'partnertype_taskActionData' => $this->input->post('partnertype_taskActionData'),
        'partnertype_taskPurposeData' => $this->input->post('partnertype_taskPurposeData'),
        'samestatuslast15daysData' => $this->input->post('samestatuslast15daysData'),
        'partnertype_planbutData' => $this->input->post('partnertype_planbutData'),
        'daysfilter2_samedays' => $this->input->post('daysfilter2_samedays'),
        'planbut_taskActionData' => $this->input->post('planbut_taskActionData'),
        'planbut_taskPurposeData' => $this->input->post('planbut_taskPurposeData'),
        'planbutnoinit_TaskData' => $this->input->post('planbutnoinit_TaskData'),
        'firstQuarter1cstatysData' => $this->input->post('firstQuarter1cstatysData'),
        'firstQuarter1cstatysDataTask' => $this->input->post('firstQuarter1cstatysDataTask'),
        'firstQuarter1taskActionbyuser' => $this->input->post('firstQuarter1taskActionbyuser'),
        'firstQuarter1taskPurposebyuser' => $this->input->post('firstQuarter1taskPurposebyuser'),
        'reviewTargetreviewtypeData' => $this->input->post('reviewTargetreviewtypeData'),
        'reviewTargetReviewSelfData' => $this->input->post('reviewTargetReviewSelfData')
        // 'curuserid' => $this->input->post('curuserid'),
        // 'pdate' => $this->input->post('pdate'),
        // 'tptime' => $this->input->post('tptime'),
        // 'meeting_time' => $this->input->post('meeting_time'),
        // 'selectcompanybyuser' => $this->input->post('selectcompanybyuser'),
        // 'ntactionnew' => $this->input->post('ntactionnew'),
        // 'ntppose' => $this->input->post('ntppose')
    );
    $selectedFields = [];
    $other = [];
    $statusId = null;
    $actionId = null;
    $statusIndex = null;
    $actionIndex = null;
 
     //echo"<pre>data ";print_r($data);
 
 
     foreach($data as $key => $value){
         if(isset($value) && !empty($value)){
             $selectedFields[$key] = $value;
            //echo"<pre>selectedFields inside loop ";print_r($selectedFields);
            //echo 'here'.$value;
 
            if ($value == 'A-yes' || $value == 'A-no') {
                 $selectedFields['Action'] = $value;
             }
             if ($value == 'P-yes' || $value == 'P-no') {
                 $selectedFields['Purpose'] = $value;
             }
 
             if(($key != 'partnertype_select') && ($key != 'partnertype_planbutData')){
                 if (is_numeric($value)) {
                     //echo $value;
                     if ($statusId == null)  {
                         $statusId = $value;
                         $statusArr = $this->Menu_model->get_statusbyid($statusId);
                         $statusName = $statusArr[0]->name ? $statusId:'NULL';
                         $selectedFields['comp_status'] = $statusName;
 
                     } elseif ($actionId == null) {
                         $actionId = $value;
                         $actionArr = $this->Menu_model->get_actionbyid($actionId);
                         $actionName = $actionArr[0]->name ? $actionId:'NULL';
                         $selectedFields['task'] = $actionName;
         
                     }
                 }
             }
             if($key == 'partnertype_select' || $key == 'partnertype_planbutData'){
                 $partner = $this->Menu_model->get_partnerbyid($value);
                 $partnername = $partner[0]->name;
                 $selectedFields['Partner'] = $partnername;
                 //echo $partnername;
             }
            
         }
     }
 
     $finalArr = [];
     $anotherArr = [];
     $keyArr = ['comp_status', 'task', 'Action', 'Purpose'];
 
     foreach($selectedFields as $key => $value){
         if(in_array($key, $keyArr)){
             $finalArr[$key] = $value;
         }elseif(!in_array($key, $keyArr) && !is_numeric($value)){
             $anotherArr[$key] = $value;
         }
     }
     
     $array = array_unique (array_merge ($finalArr, $anotherArr));
    // END Abhishek Data Star
    $jsonData = json_encode($array);
     if(sizeof($selectcompanybyuser) > 3){
        $this->session->set_flashdata('success_message',' You can only have three company plans at a time !!');
        redirect('Menu/TaskPlanner2/'.$pdate);
     }
  
     $totalttaskdata =$this->Menu_model->get_totaltdetailsDatewise($bdid,$pdate);
     $cosumeTime = '';
 
     $getplandateindata  =  $this->db->query("SELECT * FROM `autotask_time` where user_id='$uid' AND date ='$pdate'");
     $getplandateindata =  $getplandateindata->result();
 
     if(sizeof($totalttaskdata) > 0){
        foreach($totalttaskdata as $task){
            $action = $this->Menu_model->get_actionbyid($task->actiontype_id);
            $cosumeTime +=$action[0]->yest;
        }
       
        $stime = $getplandateindata[0]->stime;
        $etime = $getplandateindata[0]->etime;
    
        $datetime1 = new DateTime($stime);
        $datetime2 = new DateTime($etime);
        $interval = $datetime1->diff($datetime2);
        $autominutes = $interval->h * 60 + $interval->i;
    
        $totalAssignTime = 540;
        $remaingtime = $totalAssignTime - $autominutes;
    
        // if($cosumeTime > $remaingtime){
        //     $this->session->set_flashdata('success_message_plan','* Nice Job !! You have Successfully Achive Your Target Time.');
        //     redirect('Menu/TaskPlanner2/'.$pdate);
        // }else{
        //     $rrtime = $remaingtime - $cosumeTime;
        // }
     }
    $taskAssigntime = $pdate.' '.$ptime;
   
    $k=1;
    foreach($selectcompanybyuser as $tid){
       
        $cmp_Data = $this->Menu_model->getCompanyStatus($tid);
        $ntstatus = $cmp_Data[0]->cstatus;
        if($ntaction != 0){
            $actiontype_id = $ntaction;
        }else{
            $call_Data = $this->Menu_model->get_tbldata($tid);
            $actiontype_id = $call_Data[0]->actiontype_id;
        }
        
            $inid = $tid;
            if($actiontype_id ==1 || $actiontype_id ==5 || $actiontype_id ==8 || $actiontype_id ==9 || $actiontype_id ==10 || $actiontype_id ==15){
                $taskplanmincount = $taskplanmincount+5;
                $modifystr = "+$taskplanmincount minutes";
            }else if($actiontype_id ==2 || $actiontype_id ==6){
                $taskplanmincount = $taskplanmincount+10;
                $modifystr = "+$taskplanmincount minutes";
            }else if($actiontype_id ==3 || $actiontype_id ==4 || $actiontype_id ==12){
                $taskplanmincount = $taskplanmincount+30;
                $modifystr = "+$taskplanmincount minutes";
            }else if($actiontype_id ==7){
                $taskplanmincount = $taskplanmincount+15;
                $modifystr = "+$taskplanmincount minutes";
            }else if($actiontype_id ==11 || $actiontype_id ==13 || $actiontype_id ==14){
                $taskplanmincount = $taskplanmincount+2;
                $modifystr = "+$taskplanmincount minutes";
            }else{
                $new_datetime = date("y-m-d H:i:s");
            }
        if($k==1){$taskplanmincount = 0;}
        $newdate = new DateTime($taskAssigntime);
        $modifystr = "+$taskplanmincount minutes";
        $newdate->modify($modifystr);
        $new_datetime = $newdate->format('Y-m-d H:i:s');
        if($selectby == 'Plan But Not Initiated'){
           $sact_type = $this->Menu_model->SelectTaskBYTid($tid);
           
           if($sact_type ==4 || $sact_type == 17 || $sact_type == 3){ 
            $this->Menu_model->updateBarginmeeting($tid,$new_datetime);
           }
     
            $query =  $this->db->query("UPDATE `tblcallevents` SET `appointmentdatetime`='$new_datetime', `plan_change`='0', `selectby`='$selectby'  WHERE  id = $tid");
          
        }else if($selectby == 'Plan When MOM Approved'){
            $sact_type = $this->Menu_model->SelectTaskBYTid($tid);
          
             $query =  $this->db->query("UPDATE `tblcallevents` SET `appointmentdatetime`='$new_datetime', `selectby`='$selectby' WHERE  id = $tid");
             $currentdatetime = date("Y-m-d H:i:s");
             $query =  $this->db->query("UPDATE `auto_assign_task` SET `status`='1',`updated_at`='$currentdatetime' WHERE call_tid = $tid");
         }else if($selectby == 'Because of Plan Change'){
                $sact_type = $this->Menu_model->SelectTaskBYTid($tid);
                if($sact_type ==4 || $sact_type == 17 || $sact_type == 3){ 
                    $this->Menu_model->updateBarginmeetingAfterPlanChnage($tid,$new_datetime);
                   }
             $query =  $this->db->query("UPDATE `tblcallevents` SET `appointmentdatetime`='$new_datetime',`plan_change`='0', `selectby`='$selectby' WHERE  id = $tid");
        
         } else if($selectby == 'Review Target Date'){
       if(date("Y-m-d") !== $pdate){
            if($pendingTodaysTaskcnt > 0){
                $this->session->set_flashdata('success_message_plan',' First Plan Your Todays Pending Task]');
                redirect('Menu/TaskPlanner2/'.$pdate);
            }
       }elseif(date("Y-m-d") == $pdate){
        if($pendingOldTaskcnt > 0){
            $this->session->set_flashdata('success_message_plan',' First Plan Your Yesterday Pending Task]');
            redirect('Menu/TaskPlanner2/'.$pdate);
        }
    }    
        
        $query =  $this->db->query("UPDATE `tblcallevents` SET `appointmentdatetime`='$new_datetime', `selectby`='$selectby' WHERE  id = $tid");
        }else{
    if(date("Y-m-d") !== $pdate){     
        if($pendingTodaysTaskcnt > 0){
            $this->session->set_flashdata('success_message',' First Plan Your Yesterday Pending Task.');
            redirect('Menu/TaskPlanner2/'.$pdate);
        }
    }elseif(date("Y-m-d") == $pdate){
        if($pendingOldTaskcnt > 0){
            $this->session->set_flashdata('success_message_plan',' First Plan Your Todays Pending Task]');
            redirect('Menu/TaskPlanner2/'.$pdate);
        }
    }
            $ttype = $ntaction;
            if($select_cluster !== ''){
                $this->Menu_model->updateClusterIdByinitID($uid,$tid,$select_cluster);
            }
           
        // Start Check Active Task Planner Restrication Set BY Admin 
        $rstData = $this->Management_model->SpecialRestricationonTaskPlanner($uyid,$bdid,$tptime,$ptime,$ntaction,$ntppose,$selectby,$pdate,$selectcompanybyuser);     
        // End Check Active Task Planner Restrication Set BY Admin 
   
            $id = $this->Menu_model->add_plan2($pdate,$uid,$ptime,$inid,$ntaction,$ntstatus,$ntppose,$ttype,$tptime,$new_datetime,$selectby,$jsonData);
      
        }
        $k++;
     }
     
    $this->session->set_flashdata('success_message_plan',' Task Planned Successfully !!');
    redirect('Menu/TaskPlanner2/'.$pdate);
}
public function approveDailyTask(){
    $this->load->model('Menu_model');
    $this->load->library('session');
  
    $user   = $this->session->userdata('user');
    $data['user'] = $user;
    $uid    = $user['user_id'];
    $uyid   =  $user['type_id'];
    $status = $this->input->post('status');
    $tid    = $this->input->post('tid');
    $suser  = $this->input->post('suser');
    $cdate  = date("Y-m-d");
    $taskcount = sizeof($tid);
    if($status){
        if($taskcount > 0){
        foreach($tid as $id){
            $taskData = $this->Menu_model->getTBLTaskByID($id);
            $task_action_id = $taskData[0]->actiontype_id;
            if($status == 'Approve')
            {
                $query =  $this->db->query("UPDATE `tblcallevents` SET `approved_status` = 1, `approved_by`='$uid' WHERE  id = $id");
                if($task_action_id == 3 || $task_action_id == 4 || $task_action_id == 17){
                    $query =  $this->db->query("UPDATE `barginmeeting` SET `approved_status` = 1, `approved_by`='$uid' WHERE  tid = $id");
                }
            }
            if($status == 'Reject')
            {
                $query =  $this->db->query("UPDATE `tblcallevents` SET `approved_status` = 0, `approved_by`='$uid' WHERE  id = $id");
                if($task_action_id == 3 || $task_action_id == 4 || $task_action_id == 17){
                    $query =  $this->db->query("UPDATE `barginmeeting` SET `approved_status` = 0, `approved_by`='$uid' WHERE  tid = $id");
                }
            }
        }
        $this->session->set_flashdata('success_message','Total '.$taskcount.' Task '.$status.' Successfully');
        redirect('Menu/CheckTaskDetailsByUser/'.$suser.'/'.$cdate);
        }else{
            $this->session->set_flashdata('error_message','* Select At List one Task For '.$status);
            redirect('Menu/CheckTaskDetailsByUser/'.$suser.'/'.$cdate);
        }
    }else{
        $this->session->set_flashdata('error_message','* Please Select Valid Approve / Reject Status');
        redirect('Menu/CheckTaskDetailsByUser/'.$suser.'/'.$cdate);
    }
}
public function selfAssign($tableId, $selfAssign, $taskdate){
        $data = array(
            'self_assign' => $selfAssign,
        );
        $this->db->where('id', $tableId);
        $this->db->update('tblcallevents', $data);
       $query = $this->db->query("SELECT * FROM `tblcallevents` WHERE `id` = $tableId");
       $result = $query->result_array();
        $this->session->set_flashdata('success_message','Request for self assign was sent successfully to the user');
        redirect('Menu/CheckTaskDetailsByUser/'.$result[0]['user_id'].'/'.$taskdate);
    }
    public function AssignTaskById($tableId, $taskdate)
    {
        $this->load->model('Menu_model');
        $this->load->library('session');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $taskDetails = $this->Menu_model->get_tbldata($tableId);
        $userdtl = $this->Menu_model->get_userbyid($taskDetails[0]->user_id);
        $this->load->view($dep_name.'/AssignTaskById',['user'=>$user,'uid'=>$uid,'tableId'=>$tableId, 'taskDetails' => $taskDetails, 'userdtl' => $userdtl]);
    }
    public function getPurposeByAction(){
        $inid= $this->input->post('initId');
        $aid= $this->input->post('aId');
        $this->load->model('Menu_model');
        $da = '';
        $inid = rtrim($inid , ',');
        $remark=$this->Menu_model->get_purposebyinidnew($aid,$inid);
        echo json_encode($remark);
    }
     public function dailyTaskAssignById(){
        $this->load->model('Menu_model');
        $cuser = $this->session->userdata('user');
        $taskDetailsJson= $this->input->post('taskDetails');
        $taskDetails    = json_decode($taskDetailsJson, true);
        $eventId        = $taskDetails[0]['id'];
        $filterBy       = json_decode($taskDetails[0]['filter_by'], true);
        $selectby       = "Task Assign By User Manager";
        $task_date      = $this->input->post('date_display');
        $time_display   = $this->input->post('time_display');
        $current_status = $this->input->post('current_status');
        $inid           = $this->input->post('company');
        $ntaction       = $this->input->post('task_action');
        $ntppose        = $this->input->post('ntppose');
        $ntdate         = $task_date.' '.$time_display;
        $bdid           = json_decode($taskDetails[0]['user_id'], true);
        $approved_user  = $cuser['user_id'];
        $query          =   $this->db->query("SELECT * FROM init_call where id='$inid'");
        $data           =   $query->result();
        $stid           =   $data[0]->cstatus;
        $cmpid_id       =   $data[0]->cmpid_id;
        $cmpDataq       =  $this->db->query("SELECT * FROM `company_contact_master` WHERE company_id = '$cmpid_id'");
        $cmpData        = $cmpDataq->result();
        $ccid           = $cmpData[0]->id;
 
        $cmp_data = $this->Menu_model->get_cmpbyinid($inid);
        $cmp_name = $cmp_data[0]->compname;
        
        if($ntaction == 3 || $ntaction == 4){
            $tasktdata = array(
                'lastCFID'              => '0',
                'nextCFID'              => '0',
                'purpose_achieved'      => 'no',
                'fwd_date'              => $ntdate,
                'actontaken'            => 'no',
                'nextaction'            => 'Will Collect Data by RP Meeting',
                'mom_received'          => 'no',
                'appointmentdatetime'   => $ntdate,
                'actiontype_id'         => $ntaction,
                'assignedto_id'         => $bdid,
                'cid_id'                => $inid,
                'purpose_id'            => $ntppose,
                'remarks'               => 'Will Collect Data by RP Meeting',
                'status_id'             => $stid,
                'user_id'               => $bdid,
                'date'                  => $ntdate,
                'updateddate'           => $ntdate,
                'updation_data_type'    => 'updated',
                'plan'                  => '1',
                'selectby'              => $selectby,
                'approved_status'       => 1,
                'approved_by'           => $approved_user,
                'self_assign'           => 2,
            );
            
            // Insert data into tblcallevents
            $this->db->insert('tblcallevents',$tasktdata);
            $cntid = $this->db->insert_id();
        
            $meeting_data = array(
                'storedt' => $ntdate,
                'user_id' => $bdid,
                'cid'     => $cmpid_id,
                'ccid'    => $ccid,
                'inid'    => $inid,
                'tid'     => $cntid,
                'company_name' => $cmp_name,
                'approved_status' => 1,
                'approved_by' => $approved_user
            );
            
            $this->db->insert('barginmeeting', $meeting_data);
            $bmid = $this->db->insert_id();
        }else{
            $createtask_data = array(
                'lastCFID' => '0',
                'nextCFID' => '0',
                'remarks' => '',
                'plan' => '1',
                'fwd_date' => $ntdate,
                'appointmentdatetime' => $ntdate,
                'actiontype_id' => $ntaction,
                'purpose_id' => $ntppose,
                'assignedto_id' => $bdid,
                'cid_id' => $inid,
                'status_id' => $stid,
                'user_id' => $bdid,
                'date' => $ntdate,
                'updateddate' => $ntdate,
                'selectby'      => $selectby,
                'approved_status' => 1,
                'approved_by'   => $approved_user,
                'self_assign' => 2
            );
            // Insert data into tblcallevents
            $this->db->insert('tblcallevents', $createtask_data);
            $ntid = $this->db->insert_id();
        }
 
    $data = array(
        'self_assign' => 2,
        'nextCFID' => $eventId,
    );
        // Updating the database
        $this->db->where('id', $eventId);
        $this->db->update('tblcallevents', $data);
        $this->session->set_flashdata('success_message','Task assigned Successfuly');
        redirect('Menu/CheckTaskDetailsByUser/'.$taskDetails[0]['user_id'].'/'.$task_date);
    }
public function getcmpbyStatus(){
        $uid= $this->input->post('uid');
        $status= $this->input->post('status');
        $this->load->model('Menu_model');
        $this->load->library('session');
        $cmp = $this->Menu_model->get_statuscmp($status,$uid);
        echo json_encode($cmp);
    }
    public function UserTaskViewPage(){
        $this->load->model('Menu_model');
        $this->load->library('session');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $selected_date = $this->input->post('adate');
    
        if(isset($_POST['adate'])){
            $date = $_POST['adate'];
        }else{
            $date = date("Y-m-d");
        }
    
        $taskPlanInfo = $this->Menu_model->get_tblDataByUserId($uid, $date);
        if(!empty($user)){
            $this->load->view($dep_name.'/UserTaskViewPage',['uid'=>$uid,'user'=>$user, 'taskPlanInfo'=> $taskPlanInfo, 'date'=>$date, 'selected_date' => $selected_date]);
        }else{
            redirect('Menu/main');
        }
    }
     public function selfTaskAssignPage($tableId){
        $this->load->model('Menu_model');
        $this->load->library('session');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $date =  date('Y-m-d');
        $taskDetails = $this->Menu_model->get_tbldata($tableId);
        $userdtl = $this->Menu_model->get_userbyid($taskDetails[0]->user_id);
        if(!empty($user)){
            $this->load->view($dep_name.'/selfTaskAssignPage',['uid'=>$uid,'user'=>$user, 'taskDetails'=> $taskDetails, 'date'=>$date, 'userdtl' => $userdtl]);
        }else{
            redirect('Menu/main');
        }
    }
    public function selfTaskAssign(){
    $this->load->model('Menu_model');
    $cuser = $this->session->userdata('user');
    $taskDetailsJson= $this->input->post('taskDetails');
    $taskDetails    = json_decode($taskDetailsJson, true);
    $eventId        = $taskDetails[0]['id'];
    $filterBy       = json_decode($taskDetails[0]['filter_by'], true);
    $selectby       = "User Assigned Task via Admin Request";
    $task_date      = $this->input->post('date_display');
    $time_display   = $this->input->post('time_display');
    $current_status = $this->input->post('current_status');
    $inid           = $this->input->post('company');
    $ntaction       = $this->input->post('task_action');
    $ntppose        = $this->input->post('ntppose');
    $ntdate         = $task_date.' '.$time_display;
    $bdid           = json_decode($taskDetails[0]['user_id'], true);
    $approved_user  = $cuser['user_id'];
    $query          =   $this->db->query("SELECT * FROM init_call where id='$inid'");
    $data           =   $query->result();
    $stid           =   $data[0]->cstatus;
    $cmpid_id       =   $data[0]->cmpid_id;
    $cmpDataq       =  $this->db->query("SELECT * FROM `company_contact_master` WHERE company_id = '$cmpid_id'");
    $cmpData        = $cmpDataq->result();
    $ccid           = $cmpData[0]->id;
    $cmp_data = $this->Menu_model->get_cmpbyinid($inid);
    $cmp_name = $cmp_data[0]->compname;
    
    if($ntaction == 3 || $ntaction == 4){
        $tasktdata = array(
            'lastCFID'              => '0',
            'nextCFID'              => '0',
            'purpose_achieved'      => 'no',
            'fwd_date'              => $ntdate,
            'actontaken'            => 'no',
            'nextaction'            => 'Will Collect Data by RP Meeting',
            'mom_received'          => 'no',
            'appointmentdatetime'   => $ntdate,
            'actiontype_id'         => $ntaction,
            'assignedto_id'         => $bdid,
            'cid_id'                => $inid,
            'purpose_id'            => $ntppose,
            'remarks'               => 'Will Collect Data by RP Meeting',
            'status_id'             => $stid,
            'user_id'               => $bdid,
            'date'                  => $ntdate,
            'updateddate'           => $ntdate,
            'updation_data_type'    => 'updated',
            'plan'                  => '1',
            'selectby'              => $selectby
        );
        
        // Insert data into tblcallevents
        $this->db->insert('tblcallevents',$tasktdata);
        $cntid = $this->db->insert_id();
    
        $meeting_data = array(
            'storedt' => $ntdate,
            'user_id' => $bdid,
            'cid'     => $cmpid_id,
            'ccid'    => $ccid,
            'inid'    => $inid,
            'tid'     => $cntid,
            'company_name' => $cmp_name
        );
        
        $this->db->insert('barginmeeting', $meeting_data);
        $bmid = $this->db->insert_id();
    }else{
        $createtask_data = array(
            'lastCFID' => '0',
            'nextCFID' => '0',
            'remarks' => '',
            'plan' => '1',
            'fwd_date' => $ntdate,
            'appointmentdatetime' => $ntdate,
            'actiontype_id' => $ntaction,
            'purpose_id' => $ntppose,
            'assignedto_id' => $bdid,
            'cid_id' => $inid,
            'status_id' => $stid,
            'user_id' => $bdid,
            'date' => $ntdate,
            'updateddate' => $ntdate,
            'selectby'    => $selectby
        );
        // Insert data into tblcallevents
        $this->db->insert('tblcallevents', $createtask_data);
        $ntid = $this->db->insert_id();
    }
    $data = array(
        'self_assign' => 3,
        'nextCFID' => $eventId,
    );
    // Updating the database
    $this->db->where('id', $eventId);
    $this->db->update('tblcallevents', $data);
    $this->session->set_flashdata('success_message','User Assigned Task via Admin Request Successfuly !');
    redirect('Menu/UserTaskViewPage');
    }
// public function getTotalTaskData(){
//     $this->load->model('Menu_model');
//     $this->load->library('session');
//     $user = $this->session->userdata('user');
//     $data['user'] = $user;
//     $uid = $user['user_id'];
//     $uyid =  $user['type_id'];
//     $taskdate  = date("Y-m-d");
//     $uid = 100095;
//     $totalttaskdata =$this->Menu_model->get_totaltdetailsDatewise(100095,$taskdate);
    
//     $cosumeTime = '';
//     $getplandateindata  =  $this->db->query("SELECT * FROM `autotask_time` where user_id='$uid' AND date ='$taskdate'");
//     $getplandateindata =  $getplandateindata->result();
//     foreach($totalttaskdata as $task){
//         $action = $this->Menu_model->get_actionbyid($task->actiontype_id);
//         $cosumeTime +=$action[0]->yest;
//     }
   
//     $stime = $getplandateindata[0]->stime;
//     $etime = $getplandateindata[0]->etime;
//     $datetime1 = new DateTime($stime);
//     $datetime2 = new DateTime($etime);
//     $interval = $datetime1->diff($datetime2);
//     $autominutes = $interval->h * 60 + $interval->i;
//     $totalAssignTime = 540;
//     $remaingtime = $totalAssignTime - $autominutes;
//     if($cosumeTime > $remaingtime){
//         $this->session->set_flashdata('success_message','* Nice Job !! You have Successfully Achive Your Target Time.');
//     }else{
//         $rrtime = $remaingtime - $cosumeTime;
//     }
  
// }
public function ClusterWorkWithBDFunnel(){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt =$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $udetail = $this->Menu_model->get_userbyid($uid);
    $clu_id = $udetail[0]->aadmin;
    $totalttaskdata =$this->Menu_model->ClusterWorkMyFunnel($uid,$clu_id);
 
    if(!empty($user)){
        $this->load->view($dep_name.'/ClusterWorkWithBDFunnel',['uid'=>$uid,'user'=>$user,'clm_data'=>$totalttaskdata]);
    }else{
        redirect('Menu/main');
    }
}
public function PSTWorkWithBDFunnel(){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt =$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $udetail = $this->Menu_model->get_userbyid($uid);
    $pst_id = $udetail[0]->pst_co;
    $totalttaskdata =$this->Menu_model->PSTWorkMyFunnel($uid,$pst_id);
 
    if(!empty($user)){
        $this->load->view($dep_name.'/PSTWorkWithBDFunnel',['uid'=>$uid,'user'=>$user,'pst_data'=>$totalttaskdata]);
    }else{
        redirect('Menu/main');
    }
}
public function Total_Team_Meetings($auser_id,$sdate,$edate){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt =$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $udetail = $this->Menu_model->get_userbyid($uid);
    $pst_id = $udetail[0]->pst_co;
    $mdata = $this->Menu_model->get_all_bd_meetings($auser_id,$sdate,$edate);
    if(!empty($user)){
        $this->load->view($dep_name.'/Total_Team_Meetings',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'mdata'=>$mdata]);
    }else{
        redirect('Menu/main');
    }
}
public function Total_Team_RP_Meeting($auser_id,$sdate,$edate){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt =$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $udetail = $this->Menu_model->get_userbyid($uid);
    $pst_id = $udetail[0]->pst_co;
    $mdata = $this->Menu_model->get_all_bd_RP_meetings($auser_id,$sdate,$edate);
    if(!empty($user)){
        $this->load->view($dep_name.'/Total_Team_RP_Meeting',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'mdata'=>$mdata]);
    }else{
        redirect('Menu/main');
    }
}
public function Total_Team_No_RP_Meeting($auser_id,$sdate,$edate){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt =$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $udetail = $this->Menu_model->get_userbyid($uid);
    $pst_id = $udetail[0]->pst_co;
    $mdata = $this->Menu_model->get_all_bd_No_RP_meetings($auser_id,$sdate,$edate);
   
    if(!empty($user)){
        $this->load->view($dep_name.'/Total_Team_NO_RP_Meeting',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'mdata'=>$mdata]);
    }else{
        redirect('Menu/main');
    }
}
public function Total_Team_Fresh_Meeting($auser_id,$sdate,$edate){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt =$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $udetail = $this->Menu_model->get_userbyid($uid);
    $pst_id = $udetail[0]->pst_co;
    $mdata = $this->Menu_model->get_all_bd_Fresh_RP_meetings($auser_id,$sdate,$edate);
    $mdata1 = [];
    $toData = 0;
    $tids = '';
    foreach($mdata as $dt){
        $cmpid = $dt->cmpid;
        $cid = $dt->cid;
        $tid = $dt->tid;
        $cmprp = $this->Menu_model->get_meetfr12($tid,$cid);
        $cmrp = sizeof($cmprp);
        if($cmrp==0){
            $toData++;
            $tids .=$tid.',';
        }
    
}   
$tids = rtrim($tids, ',');
$mdata2 = $this->Menu_model->get_all_bd_Fresh_RP_meetings_New($tids);
    if(!empty($user)){
        $this->load->view($dep_name.'/Total_Team_Fresh_Meeting',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'mdata'=>$mdata2]);
    }else{
        redirect('Menu/main');
    }
}
public function Total_Team_Re_Meeting($auser_id,$sdate,$edate){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt =$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $udetail = $this->Menu_model->get_userbyid($uid);
    $pst_id = $udetail[0]->pst_co;
    $mdata = $this->Menu_model->get_all_bd_Fresh_RP_meetings($auser_id,$sdate,$edate);
    $mdata1 = [];
    $tids = '';
    $rmeet = 0;
    foreach($mdata as $dt){
        $cmpid = $dt->cmpid;
        $cid = $dt->cid;
        $tid = $dt->tid;
        $cmprp = $this->Menu_model->get_meetfr12($tid,$cid);
        $cmrp = sizeof($cmprp);
        if($cmrp>0){
            $rmeet++;
            $tids .=$tid.',';
        }
}   
$tids = rtrim($tids, ',');
$mdata2 = $this->Menu_model->get_all_bd_Fresh_RP_meetings_New($tids);
    if(!empty($user)){
        $this->load->view($dep_name.'/Total_Team_Re_Meeting',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'mdata'=>$mdata2]);
    }else{
        redirect('Menu/main');
    }
}
public function Total_Team_Potential_Meeting($uid,$sdate,$edate){ 
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $mdata = $this->Menu_model->get_all_bd_Potential_meetings($uid,$sdate,$edate);

    if(!empty($user)){
        $this->load->view($dep_name.'/Total_Team_potential_Meeting',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'mdata'=>$mdata2]);
    }else{
        redirect('Menu/main');
    }
}
public function SpecialRequestForLeave(){
    $pdate      = $_POST['pdate'];
    $stime      = $_POST['start_meeting_time'];
    $etime      = $_POST['end_meeting_time'];
    $purpose    = $_POST['purpose'];
 
    $user       = $this->session->userdata('user');
    $data['user'] = $user;
    $uid        = $user['user_id'];
    $uyid       = $user['type_id'];
    $this->load->model('Menu_model');
    $this->load->library('session');
    $dt         = $this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $this->Menu_model->add_SpecialRequestForLeave($uid,$pdate,$stime,$etime,$purpose);
    
    $this->session->set_flashdata('success_message','Request For Plan Change Sended Successfully !');
    redirect('Menu/dashboard');
}
public function SpecialRequestForLeaveSomeTime(){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $this->load->view($dep_name.'/SpecialRequestForLeaveSomeTime',['user'=>$user,'uid'=>$uid]);
}

public function GetCheckExistsTaskTime(){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $timeValue = $_POST['timeValue'];
    $pdate = $_POST['pdate'];
    $cdata = $this->Menu_model->CheckExistsTaskTime($uid,$pdate,$timeValue);
    $cdatacnt = sizeof($cdata);
    echo $cdatacnt;
}
public function session_plan_time_start(){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $psdatetime = date("Y-m-d H:i:s");
    $pstime = date("H:i:s");
    $dt=$this->Menu_model->StorePlannerSessionStart($uid,$psdatetime,$pstime);
}
public function session_plan_time_close(){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $pcdatetime = date("Y-m-d H:i:s");
    $pctime = date("H:i:s");
    $totaltime = $_POST['close'];
    
    $dt=$this->Menu_model->StorePlannerSessionClose($uid,$pcdatetime,$pctime,$totaltime);
}
public function CheckPlanTaskBetweenTimes($stime,$etime){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $date = date("Y-m-d");
    $total_task = $this->Menu_model->TotalTaskBetweenTime($uid,$date,$stime,$etime);
    $this->load->view($dep_name.'/CheckPlanTaskBetweenTimes',['user'=>$user,'uid'=>$uid,'tdata'=>$total_task,'cdate'=>$date,'stime'=>$stime,'etime'=>$etime]);
}
public function get_BargeMeetCompany(){
    $uid= $this->input->post('uid');
    $this->load->model('Menu_model');
    $cmp = $this->Menu_model->get_BargeMeetMeetCmp($uid);
    echo '<option value="">Select Company</option>';
    foreach($cmp as $cmp){ ?>
    <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
        <?=$cmp->compname?> (<?=$cmp->pname?>)
    </option>
    <?php
    }
}
public function get_JoinMeetingsCompany(){
    $uid= $this->input->post('uid');
    $this->load->model('Menu_model');
    $cmp = $this->Menu_model->get_JoinMeetingsCmp($uid);
    echo '<option value="">Select Company</option>';
    foreach($cmp as $cmp){ ?>
    <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
        <?=$cmp->compname?> (<?=$cmp->pname?>)
    </option>
    <?php
    }
}
// New TaskCheck <=========================================== START ==================================>
    public function TaskCheck_New(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $userList = $this->Menu_model->get_userForTask($uid,$uyid);
        $dep_name = $dt[0]->name;
        // $tdate=date('Y-m-d');
        $date = new DateTime();
        $date->modify('-1 day');
        $tdate =  $date->format('Y-m-d');
        $taskList = array();
        
        if(isset($_POST['userId'])){
            $userId = $_POST['userId'];
            $taskList = $this->Menu_model->getTasks($userId,$tdate);
            
        }
        else{
            $userId = '';
        }
        // echo "<pre>";print_r($taskList);exit;
        // var_dump($taskList);die;
        if(!empty($user)){
            $this->load->view($dep_name.'/TaskCheck_New',['uid'=>$uid,'user'=>$user,'userList'=>$userList,'taskList'=>$taskList,'cdate'=>$tdate,'selectedUser'=>$userId]);
        }else{
            redirect('Menu/main');
        }
    }
    public function getTaskByUser(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $userId = '100192';
        $tdate = '2024-07-20';
        // var_dump($_POST);die;
        $getTasks = $this->Menu_model->getTasks($userId,$tdate);
        print_r($getTasks);die;
        if(!empty($user)){
            $this->load->view($dep_name.'/TaskCheck_New',['uid'=>$uid,'user'=>$user,'tasks'=>$getTasks]);
        }else{
            redirect('Menu/main');
        }
    }
    public function RateTask(){
        $rat = $_POST['rat'];
        $rremark = $_POST['rremark'];
        $taskid = $_POST['taskid'];
        $uuid = $_POST['uuid'];
        $this->Menu_model->RateTask($rat,$rremark,$taskid,$uuid);
        $this->session->set_flashdata('success_message', 'Star Rating Added Successfully');
        redirect('Menu/TaskCheck_New');
    }
    public function TaskCheckStarNew(){
        // var_dump($_POST);die;
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $rating = $this->input->post('rating');
        $question = $this->input->post('question');
        $userId = $this->input->post('userId');
        $taskid = $this->input->post('taskId');
        // $cdate = $this->input->post('cdate');
        $cdate = date('Y-m-d h:m:s');
        $this->load->model('Menu_model');
        $result = $this->Menu_model->InsertTaskRating($rating,$question,$userId,$taskid,$cdate,$uid);
        echo json_encode($result);
        // print_r($rating);die;
    }
     public function updateTaskCheckRemark() {
        // var_dump($_POST);die;
        $this->load->model('Menu_model');
        $remark = $this->input->post('remark');
        $starID = $this->input->post('starID');
        
        $result = $this->Menu_model->updateTaskCheckRemark($remark,$starID);
    }
    
    public function meetingDetail_new(){
                if($uid =='100147')
        {$uid ='45';}
        if(isset($_POST['sdate'])){
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        }
        else{
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        
        if(!empty($user)){
            
            $this->load->view($dep_name.'/MeetingDetail',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
        }else{
            redirect('Menu/main');
        }
    }
    // New TaskCheck <=========================================== END ==================================>
    
    /******* To Create Target Vs Achievement Report Function - Manasvi 31-09-2024*******/
    
     public function targetQandA(){
        // $reviewId = '100059';$reviewType="Roster";$reviewTypeId="2";
        // echo "<pre>";print_r($_POST);exit;
        if($_POST){
            $uid = $this->input->post('uid');
            $reviewType  = $this->input->post('reviewType ');
        }
        $uid                = $_SESSION['user']['user_id'];
        $utype              = $_SESSION['user']['type_id'];
        $bd_user_id         = $reviewId;
        $dt                 = $this->Menu_model->get_utype($utype);
        $utype              = $dt[0]->name;
        $data['reviewType'] = $reviewType;
        $bd_user_details    = $this->Menu_model->get_userbyid($reviewId);
       
        $data['username']       = $bd_user_details[0]->name;
       
        $data['partnerType']    = $this->Menu_model->get_partnertype();
            if($_POST){
               $data['bd']            = $reviewId;
               $data['prospecting']   = $this->input->post('prospecting');
               $data['revenue']       = $this->input->post('revenue');
               $data['proposal']      = $this->input->post('proposal');
               $data['closure']       = $this->input->post('closure');
               $data['partner_type']  = $this->input->post('partner_type');
               $data['updatedBy']     = $uid;
               $targetQandAdata['reviewType']      = $reviewTypeId;
               $targetQandAdata['targetStartDate'] = $this->input->post('sdate');
               $targetQandAdata['targetEndDate']   = $this->input->post('edate');
               $targetQandAdata['updatedAt']       =  date("Y-m-d h:i:s");
               $this->Menu_model->insertTargetQandA($data);
            }
        
        $data['utype'] = $utype;
        $this->load->view('header.php');
        $this->load->view('targetQandA.php',$data);
        $this->load->view('footer.php');
    }
    
    public function targetVsAchievedData(){
        $uid     = $_SESSION['user']['user_id'];
        $utypeid = $_SESSION['user']['type_id'];
       
        if($_POST){
            $sdate                  = $this->input->post('sdate');  
            $edate                  = $this->input->post('edate'); 
            // $mainbd                 = $this->input->post('mainbd');
        }
        else{
            $sdate          = date("Y-m-d");
            $edate          = date("Y-m-d");
            $sdate          = '2024-02-25';
            $edate          = '2024-08-25';

           
        }
      
        $getMyTeamListIds_str   = $mainbd;
        $dt                             = $this->Menu_model->get_utype($utypeid);
        $utype                          = $dt[0]->name;
          
        $getMyTeamListIds               = $this->Menu_model->getMyTeamList($uid,$utypeid,$column='user_id');
        $getMyTeamListIds_str           = implode(',',$getMyTeamListIds);

        $data['sdate']  =  $sdate;
        $data['edate']  =  $edate;
        // $mainbd         = '100059';

      
        
        $data['targetVsAchieved']       = $this->Menu_model->getAchievedData($getMyTeamListIds_str,$sdate,$edate);
        $data['heading']                = 'Target Vs Achieved';

        $this->load->view('TargetVsAchieved',$data);
    }
   
    public function getAchievedDataList($uid,$category,$sdate,$edate){
        $data             = $this->Menu_model->getAchievedDataList($uid,$category,$sdate,$edate);
        
        // for prospective page : prospective_achieved_View 
        //for proposal          : proposal_achieved_View 
        //for revenue           : revenue_achieved_View 
        //for closure           : closure_achieved_View  
        $data['sdate'] =$sdate;
        $data['edate'] =$edate;
        $data['username'] = $this->Menu_model->getUserNameById($uid);
        $this->load->view($category.'_View.php',$data);
    }
    

    /********End Target Vs Achievement Report Function********/
    
    /*******User Management** ABHISHEK**/
   public function UserRegistration(){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $userArr = array();
    if ($this->input->post()) {
        $initUserId=$this->input->post('user_id');
        $userId = $this->Menu_model->generateUserId();
        $maxUserId = (int)($userId[0]->user_id);
        $finalUserId = $maxUserId + 1;
        $userArr = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'Username' => $this->input->post('Username'),
            'joiningDate' => date("Y-m-d"),
            'phone' => $this->input->post('phone'),
            'zone' => $this->input->post('zone'),
            'type' => $this->input->post('type'),
            'cluster' => $this->input->post('cluster') ?? 0,
            'bdpstF' => $this->input->post('bdpstF'),
            'sales' =>$this->input->post('sales') ?? 0,
            'pst' => $this->input->post('pst') ?? 0,
            'password' => $this->input->post('password'),
            'inside' => null,
            'aadmin' => $this->input->post('admin'),
            'admin_id' => 45,
            'status' => 'active',
            'userId'=>$finalUserId,
        );

        $username = $userArr['Username'];
        $user     = $this->Menu_model->checkUsername($username);
      
        if($initUserId){
            $isSucess = $this->Menu_model->editUserData($userArr, $initUserId);
            if($isSucess){
            $this->session->set_flashdata('success_message',"User updated successfully !");
            redirect('Menu/UserRegistration');
            }
        }elseif($user){
            //echo"here inside if";exit;
            $this->session->set_flashdata('error_message',"Username already Exists !");
            redirect('Menu/UserRegistration');
        }else{
           
            $isSucess = $this->Menu_model->insertUserData($userArr);
            if($isSucess){
                //echo"here inside issucess";exit;
                $this->session->set_flashdata('success_message',"User added successfully with User ID - $finalUserId ");
                redirect('Menu/UserRegistration');
            }
        }
        
    }
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $zone=$this->Menu_model->getZone();
    $type=$this->Menu_model->get_user_type();
    $pst=$this->Menu_model->get_pstNames();
    $salesCoordinator = $this->Menu_model->get_salesCoordinatorNames();
    $clusterManager = $this->Menu_model->get_clusterManagerNames();
    $bdpst = $this->Menu_model->get_bdpstNames();
    $admin = $this->Menu_model->get_adminNames();
    $this->load->view($dep_name.'/UserRegistration',['user'=>$user,'zone'=>$zone, "type"=>$type, "pst"=>$pst, "salesCoordinator"=>$salesCoordinator, "clusterManager"=>$clusterManager, "bdpst"=>$bdpst, "admin"=>$admin]);
}
     public function UserDisplayPage(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $userDetails = $this->Menu_model->get_userDetails();
        if(!empty($user)){
            $this->load->view($dep_name.'/ActiveUserDisplayPage',['user'=>$user,'uid'=>$uid, 'userDetails'=>$userDetails]);
        }else{
            redirect('Menu/main');
        }
    }
    public function UserEditAction($userId){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $userDetails = $this->Menu_model->get_userbyid($userId);
    $zone=$this->Menu_model->getZone();
    $type=$this->Menu_model->get_user_type();
    $pst=$this->Menu_model->get_pstNames();
    $salesCoordinator = $this->Menu_model->get_salesCoordinatorNames();
    $clusterManager = $this->Menu_model->get_clusterManagerNames();
    $bdpst = $this->Menu_model->get_bdpstNames();
    $admin = $this->Menu_model->get_adminNames();
    if(!empty($user)){
        $this->load->view($dep_name."/UserEditPage",['user'=>$user,'uid'=>$uid, 'userDetails'=>$userDetails,'zone'=>$zone, 'type'=>$type, 'pst'=>$pst, 'salesCoordinator'=>$salesCoordinator, 'clusterManager'=>$clusterManager, 'bdpst'=>$bdpst, 'admin'=>$admin, 'userId'=>$userId]);
    }else{
        redirect('Menu/main');
    }
}
public function UserDeleteAction($userId){
    $this->load->model('Menu_model');
    $removed = $this->Menu_model->changeActiveStatus($userId);
    if($removed==1){
        $this->session->set_flashdata('success_message',"User Deleted successfully !");
        redirect('Menu/UserDisplayPage');
    }
}
 public function fetchClusterManagers() {
        $zone_id = $this->input->post('zone_id');
        //echo 'zone id',$zone_id;exit;
        $this->load->model('Menu_model');
        $data = $this->Menu_model->getClusterManagersByZone($zone_id);
        //echo"<pre>data ";print_r($data);exit;
        echo json_encode($data);
    }
    public function fetchSalesCoordinators() {
        $zone_id = $this->input->post('zone_id');
        $this->load->model('Menu_model');
        $data = $this->Menu_model->getSalesCoordinatorsByZone($zone_id);
        echo json_encode($data);
    }
    public function fetchBdpst() {
        $zone_id = $this->input->post('zone_id');
        $this->load->model('Menu_model');
        $data = $this->Menu_model->getBdpstByZone($zone_id);
        echo json_encode($data);
    }
    public function fetchPst() {
        $zone_id = $this->input->post('zone_id');
        $this->load->model('Menu_model');
        $data = $this->Menu_model->getPstByZone($zone_id);
        echo json_encode($data);
    }
    /*******END User Management*********/
// -----------------------------28-08-2024 by Abhishek cluster cards----------------------------
public function clusterManagerTaskDetail($code,$bdid,$atid,$sd,$ed,$ab){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $mtdata=$this->Menu_model->get_clustertaskdbyad($code,$atid,$uid,$sd,$ed,$ab);
    //echo"<pre>mtdata ";print_r($mtdata);exit;
    if(!empty($user)){
        $this->load->view($dep_name.'/ClusterTaskDetail',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'sd'=>$sd,'ed'=>$ed,'code'=>$code,'ab'=>$ab,'bdid'=>$bdid, 'mtdata'=>$mtdata]);
    }else{
        redirect('Menu/main');
    }
}
public function clusterWork(){
    if(isset($_POST['sdate'])){
    $sdate = $_POST['sdate'];
    $edate = $_POST['edate'];
    }
    else{
        $sdate = date('Y-m-d');
        $edate = date('Y-m-d');
    }
    $sd=$sdate;
    $ed=$edate;
    $sdate = new DateTime($sdate);
    $edate = new DateTime($edate);
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    if(!empty($user)){
        $this->load->view($dep_name.'/clusterWork',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
    }else{
        redirect('Menu/main');
    }
}
public function ClusterTeamWork($sd,$ed){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    if(!empty($user)){
        $this->load->view($dep_name.'/ClusterTeamWork',['uid'=>$uid,'user'=>$user,'sd'=>$sd,'ed'=>$ed]);
    }else{
        redirect('Menu/main');
    }
}
public function StatusTaskCLuster($bdid,$tdate,$atid,$ab){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $mdata = $this->Menu_model->new_clusterttswdetail($atid,$bdid,$tdate,$ab);
    //echo"<pre>mtdata ";print_r($mdata);exit;
    if(!empty($user)){
        $this->load->view($dep_name.'/StatusTaskCluster',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'tdate'=>$tdate,'ab'=>$ab,'bdid'=>$bdid, 'mdata'=>$mdata]);
    }else{
        redirect('Menu/main');
    }
}
public function ClusterStatusTask(){
    if(isset($_POST['sdate'])){
    $sdate = $_POST['sdate'];
    $edate = $_POST['edate'];
    }
    else{
        $sdate = date('Y-m-d');
        $edate = date('Y-m-d');
    }
    $sd=$sdate;
    $ed=$edate;
    $sdate = new DateTime($sdate);
    $edate = new DateTime($edate);
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    if(!empty($user)){
        $this->load->view($dep_name.'/ClusterStatusTask',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
    }else{
        redirect('Menu/main');
    }
}
 public function ClusterStatusTaskDateWise($datet){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    if(!empty($user)){
        $this->load->view($dep_name.'/ClusterStatusTaskDateWise',['uid'=>$uid,'user'=>$user,'datet'=>$datet]);
    }else{
        redirect('Menu/main');
    }
}
public function FinalClusterConversion($bdid,$sd,$ed,$fsid,$ssid){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $scdata = $this->Menu_model->final_clusterscon3($bdid,$sd,$ed,$fsid,$ssid);
    //echo"<pre>";print_r($scdata);exit;
    if(!empty($user)){
        $this->load->view($dep_name.'/FinalClusterStatusConversion',['uid'=>$uid,'user'=>$user,'scdata'=>$scdata]);
    }else{
        redirect('Menu/main');
    }
}
public function ClusterStatusConversion(){
    if(isset($_POST['sdate'])){
    $sdate = $_POST['sdate'];
    $edate = $_POST['edate'];
    }
    else{
        $sdate = date('Y-m-d');
        $edate = date('Y-m-d');
    }
    $sd=$sdate;
    $ed=$edate;
    $sdate = new DateTime($sdate);
    $edate = new DateTime($edate);
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    if(!empty($user)){
        $this->load->view($dep_name.'/ClusterStatusConversion',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate, 'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
    }else{
        redirect('Menu/main');
    }
}
public function AfterClusterTaskOnC(){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    if(isset($_POST['sdate']) && isset($_POST['cluster'])){
    $sdate = $_POST['sdate'];
    $cluster = $_POST['cluster'];
    //echo'cluster from menu', $cluster;exit;
    }
    else{
        $sdate = date('Y-m-d');
        $cluster=$uid;
    }
    $sd=$sdate;
    $sdate = new DateTime($sdate);
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $mdata=$this->Menu_model->get_clusterassignc($cluster);
    // echo"<pre> mdata";print_r($mdata);exit;
    if(!empty($user)){
        $this->load->view($dep_name.'/AfterClusterTaskOnC',['cluster'=>$cluster,'user'=>$user,'uid'=>$uid,'sdate'=>$sdate,'sd'=>$sd, 'mdata'=>$mdata]);
    }else{
        redirect('Menu/main');
    }
}
public function ChangeCLuster(){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $mdata=$this->Menu_model->get_clusterbyaid($uid);
    if(!empty($user)){
        $this->load->view($dep_name.'/ChangeCLuster',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
    }else{
        redirect('Menu/main');
    }
}
public function assignCLuster(){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $mdata = $this->Menu_model->get_uapstc($uid);
    $alluser = $this->Menu_model->get_user();
    if(!empty($user)){
        $this->load->view($dep_name.'/AssignCLuster',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'alluser'=>$alluser]);
    }else{
        redirect('Menu/main');
    }
}
public function ClusterFunnel($aid){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $mdata = $this->Menu_model->get_userbypst($aid);
    $this->load->view($dep_name.'/ClusterFunnel',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
}
public function ClusterCompanies($code){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    if($uid=='100149'){$uid=45;}
    if($uid=='100103'){$uid=45;}
    if($uid=='100142'){$uid=2;}
    if($code==0){
        $mdata=$this->Menu_model->get_bdtcom($uid);
    }else{
        $mdata=$this->Menu_model->get_clustercombystatus($uid,$code);
        //echo"<pre>here ";print_r($mdata);exit;
    }
    if(!empty($user)){
        $this->load->view($dep_name.'/ClusterCompanies',['user'=>$user,'mdata'=>$mdata,'code'=>$code,'uid'=>$uid]);
    }else{
        redirect('Menu/main');
    }
}
public function CreatedClusterCompanies($code,$bdid){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    if(isset($_POST['submit'])){
        $commoncompanies = $_POST['commoncompanies'];   // meetings or topspender
        $commonwith = $_POST['commonwith'];             // bd, pst, both
        $topspender = $_POST['topspender'];            // yes, no
        // echo "inside if", $commoncompanies;
        // echo $commonwith;
        // echo $topspender;exit;
        
        if($commoncompanies =='meetings'){
            $mdata=$this->Menu_model->get_ComCompaniesSelectionWise($uid,$bdid,$commonwith,$commoncompanies);
        }
        if($commoncompanies =='topspender'){
            $mdata=$this->Menu_model->get_ComCompaniesSelectionWise($uid,$bdid,$topspender,$commoncompanies);
        }
    }else{
        if($code==0){
            $mdata=$this->Menu_model->get_clusterCom($bdid);
        }else{
            $mdata=$this->Menu_model->get_clusterCombyst($bdid,$code);
        }
        $commoncompanies = '';   // meetings or topspender
        $commonwith = '';             // bd, pst, both
        $topspender = '';
    }
    //echo"<pre>";print_r($mdata);exit;
    if(!empty($user)){
        $this->load->view($dep_name.'/CreatedCLusterCompanies',['user'=>$user,'mdata'=>$mdata,'code'=>$code,'uid'=>$uid,'bdid'=>$bdid, 'commoncompanies'=>$commoncompanies,'commonwith'=>$commonwith,'topspender'=>$topspender]);
    }else{
        redirect('Menu/main');
    }
}
public function ClmBDTaskDetail($code,$bdid,$atid,$sd,$ed,$ab){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    if(!empty($user)){
        $this->load->view($dep_name.'/ClmBDTaskDetail',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'sd'=>$sd,'ed'=>$ed,'code'=>$code,'ab'=>$ab,'bdid'=>$bdid]);
    }else{
        redirect('Menu/main');
    }
}
public function CMFunnelTransfer(){
    $tocm = $_POST['toCluster'];
    $cid = $_POST['cid'];
    $focm = $_POST['foCluster'];
    $this->load->model('Menu_model');
    $this->Menu_model->transferFunnel($focm,$tocm,$cid);
    redirect('Menu/changeCluster');
}
public function ClmWorkOnBDFunnel($code,$bdid,$atid,$sd,$ed,$ab){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    if(!empty($user)){
        $this->load->view($dep_name.'/ClmWorkOnBDFunnel',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'sd'=>$sd,'ed'=>$ed,'code'=>$code,'ab'=>$ab,'bdid'=>$bdid]);
    }else{
        redirect('Menu/main');
    }
}
public function FinalBDConversion($bdid,$sd,$ed,$fsid,$ssid){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $scdata = $this->Menu_model->bdFunnelConversion3($bdid,$sd,$ed,$fsid,$ssid);
    //echo"<pre>";print_r($scdata);exit;
    if(!empty($user)){
        $this->load->view($dep_name.'/FinalBDConversion',['uid'=>$uid,'user'=>$user,'scdata'=>$scdata]);
    }else{
        redirect('Menu/main');
    }
}
/*****-----------------------------------Cluster Cards End----------------------------****/
/***************Task check managment Rahul*********************/
    public function getMoMData(){
        $taskID = $this->input->post('taskID');
        $this->load->model('Menu_model');   
        // var_dump($taskID);die;
        $result = $this->Menu_model->getMoMData($taskID);
        echo json_encode($result);
    }
public function TaskCheck_NewReport()
    {
        if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
            $sdate = $_POST['startDate'];
            $edate = $_POST['endDate'];
        } else {
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d');
        }
        if (isset($_POST['user'])) {
            $selected_user = array_filter($_POST['user'], function ($value) {
                return $value !== 'select_all';
            });
        } else {
            $selected_user = [];
        }
//  var_dump($sdate);die;
        // $selected_user = [];
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $userTypeid = $user['type_id'];
        $this->load->model('Management_model');
        $this->load->model('Menu_model');   
        $dt = $this->Menu_model->get_utype($userTypeid);
        $dep_name = $dt[0]->name;
//echo "=="; print_r($dep_name);exit;
        $getUsers = $this->Management_model->getUsers($uid,$userTypeid);
        // $sdate
       // var_dump($sdate);die;
        $getReportbyUser = $this->Menu_model->getReportbyUser($selected_user,$sdate,$edate);
        // $getReportbyUser = '';
        if (!empty($user)) {
            // $this->load->view('include/header');
            $this->load->view($dep_name.'/TaskCheck_NewReport',['uid'=>$uid,'user'=>$user,'sdate'=>$sdate,'edate'=>$edate,'users'=>$getUsers,'selected_user'=>$selected_user,'getReportbyUser'=>$getReportbyUser]);
                                       
        } else {
            redirect('Menu/main');
        }
    }
    public function submitMoMRating(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $jsonData = file_get_contents('php://input');
        // Decode the JSON data
        $data = json_decode($jsonData, true);
        $this->load->model('Menu_model');
        // var_dump($data);die;
        foreach ($data as $review) {
            // var_dump($review);die;
            $review['date'] = date('Y-m-d');
            $review['feedback_by'] = $uid;
            $this->Menu_model->InsertMoMTaskRating($review);
        }
    }

/*******task Planner***Deepak***6_09_2024******/
// Start Day Close Request
public function dayscRequest(){
    $user         = $this->session->userdata('user');
    $data['user'] = $user;
    $uid          = $user['user_id'];
    $uyid         =  $user['type_id'];
    $this->load->model('Menu_model');
    $this->load->library('session');
    $req_id           = $_POST['req_id'];
    $req_answer       = $_POST['would_you_want'];
    $message          = $_POST['requestForTodaysTaskPlan'];
    $startautotasktime  = $_POST['startautotasktime'];
    $endautotasktime    = $_POST['endautotasktime'];
    $start_tttpft       = $_POST['start_tttpft'];
    $end_tttpft         = $_POST['end_tttpft'];
    $autotasktimeisset  = $_POST['autotasktimeisset'];
    if($uyid ==15){
        $autotasktimeisset = 1;
    }
    if($autotasktimeisset != 0){
        $planbutnotinited = $this->Menu_model->CreateCloseDayRequest($uid,$req_id,$req_answer,$message,$autotasktimeisset);
    }else{
        $planbutnotinited = $this->Menu_model->CreateCloseDayRequestWithAutoTaskTime($uid,$req_id,$req_answer,$message,$startautotasktime,$endautotasktime,$start_tttpft,$end_tttpft,$autotasktimeisset);
    }
   
    $this->session->set_flashdata('success_message','* Day Close Request Send SuccessFully !');
    redirect('Menu/DayManagement');
    
}

public function YesterdayDayClose(){
    $user_id    = $_POST['user_id'];
    $lat        = $_POST['lat'];
    $lng        = $_POST['lng'];
    $req_id     = $_POST['req_id'];
  
    $filname    = $_FILES['filname']['name'];
    $uploadPath = 'uploads/day/';
    $this->load->library('session');
    $this->load->model('Menu_model');
    $flink      = $this->Menu_model->uploadfile($filname, $uploadPath);
    $this->Menu_model->UpdateCloseYesterDay($flink,$user_id,$lat,$lng,$req_id);
    $this->session->set_flashdata('success_message','* Yesterday Day Close SuccessFully ! Now Start Your Days');
    redirect('Menu/DayManagement');
}
public function YesterDayDaysCloseRequest(){
    $user           =   $this->session->userdata('user');
    $data['user']   =   $user;
    $uid            =   $user['user_id'];
    $uyid           =   $user['type_id'];
    $this->load->library('session');
    $this->load->model('Menu_model');
    $dt             =   $this->Menu_model->get_utype($uyid);
    $tptime         =   $this->Menu_model->get_tptime($uid);
    $tptime         =   $tptime[0]->tptime;
    $dep_name       =   $dt[0]->name;
    if(isset($_POST['targetdate'])){
        $adate = $_POST['targetdate'];
    }else{
        $adate = date("Y-m-d");
    }
    $getreqData  =   $this->Menu_model->GetDayCloseRequestData($uid,$adate,$uyid);
     if(!empty($user)){
        $this->load->view($dep_name.'/YesterDayDaysCloseRequest',['uid'=>$uid,'user'=>$user,'adate'=>$adate,'getreqData'=>$getreqData]);
    }else{
        redirect('Menu/main');
    }
}
public function YesterdayCloseRequestApprove($id,$type){
    $user           = $this->session->userdata('user');
    $data['user']   = $user;
    $uid            = $user['user_id'];
    $this->load->library('session');
    $this->load->model('Menu_model');
    if($type == 'Approved'){
        $status     = "Approved";
        $reamrks    = "Approved By ".$user['name'];
        $apdate     =  date("Y-m-d H:i:s");
        
        $queryslct =  $this->db->query("SELECT * FROM `close_your_day_request` WHERE id = '$id'");
        $data = $queryslct->result();
        $autotasktimeisset  = $data[0]->autotasktimeisset;
        if($autotasktimeisset == 0 ){
            $startautotasktime  = $data[0]->startautotasktime;
            $endautotasktime    = $data[0]->endautotasktime;
            $start_tttpft       = $data[0]->start_tttpft;
            $end_tttpft         = $data[0]->end_tttpft;
            $suser_id           = $data[0]->user_id;
            $req_date           = $data[0]->req_date;
            $date_only          = date("Y-m-d", strtotime($req_date));
            $dataslct = array(
                'user_id'      => $suser_id,
                'date'         => $date_only,
                'stime'        => $startautotasktime,
                'etime'        => $endautotasktime,
                'start_tttpft' => $start_tttpft,
                'end_tttpft'   => $end_tttpft
            );
            $this->db->insert('autotask_time', $dataslct);
        }
        $query =  $this->db->query("UPDATE `close_your_day_request` SET `approved_status`='$status',`approved_remarks`='$reamrks',`approved_date`='$apdate', `approved_by`='$uid' WHERE id = $id");
        $this->session->set_flashdata('success_message','* Request Approved Successfully !');
        redirect("Menu/YesterDayDaysCloseRequest");
    }else{
        redirect('Menu/main');
    }
}
public function YesterdayCloseRequestReject(){
    
    $rejectid       = $_POST['reject'];
    $rejectreamrk   = $_POST['rejectreamrk'];
    $user           = $this->session->userdata('user');
    $data['user']   = $user;
    $uid            = $user['user_id'];
    $status         = "Reject";
    $apdate         =  date("Y-m-d H:i:s");
    $this->load->library('session');
    $this->load->model('Menu_model');
    
    $query =  $this->db->query("UPDATE `close_your_day_request` SET `approved_status`='$status',`approved_remarks`='$rejectreamrk',`approved_date`='$apdate', `approved_by`='$uid' WHERE id = '$rejectid'");
    $this->session->set_flashdata('error_message','* Request Reject Successfully !');
    redirect("Menu/YesterDayDaysCloseRequest");
}
// End Day Close Request
public function get_SheduledMeetCompany(){
    $uid= $this->input->post('uid');
    $this->load->model('Menu_model');
    $cmp = $this->Menu_model->get_SheduledMeetCmp($uid);
    echo '<option value="">Select Company</option>';
    foreach($cmp as $cmp){ ?>
    <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
        <?=$cmp->compname?> (<?=$cmp->pname?>)
    </option>
    <?php
    }
}
public function getJoinMeetpurposebyinid(){
    $inid= $this->input->post('inid');
    $aid= $this->input->post('aid');
    $this->load->model('Menu_model');
    $da = '';
    $inid = rtrim($inid , ',');
   
    $remark=$this->Menu_model->get_purposebyinidnew($aid,$inid);
    
    echo  $data = '<option value="">Select Purpose</option>';
    foreach($remark as $d){
         echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
    }
  
}
public function GetStatusWhenMeetClose(){
    $this->load->model('Menu_model');
    $meetingslct = $_POST['meetingslct'];
    
    if($meetingslct == 'NO RP'){
        $cstatus = $_POST['cstatus'];
        $status_name = $this->Menu_model->get_statusbyid($cstatus);
        // echo  $data = '<option disabled value="">Select Status</option>';
        foreach($status_name as $d){
            echo  $data = '<option selected value='.$d->id.'>'.$d->name.'</option>';
        }
    }
    
    if($meetingslct == 'RP'){
        $cstatus = $_POST['cstatus'];
        // if($cstatus=='1' || $cstatus=='8' || $cstatus=='10' || $cstatus=='11'){
        //     $status=2;
        // }
        $status_name = $this->Menu_model->get_statusbyid(3);
        // echo  $data = '<option disabled value="">Select Status</option>';
        foreach($status_name as $d){
            echo  $data = '<option selected value='.$d->id.'>'.$d->name.'</option>';
        }
    }
    if($meetingslct == 'Only Got Detail'){
        $cstatus = $_POST['cstatus'];
        $status_name = $this->Menu_model->get_statusbyid(8);
        // echo  $data = '<option disabled value="">Select Status</option>';
        foreach($status_name as $d){
            echo  $data = '<option selected value='.$d->id.'>'.$d->name.'</option>';
        }
    }
}
public function MeetingFeedBack(){
    $this->load->model('Menu_model');
    $uid            = $_POST['uid'];
    $cmp_id         = $_POST['cmp_id'];
    $meeting_id     = $_POST['meeting_id'];
    $meetwith__person = $_POST['meet_user_feed'];
    $this->Menu_model->UserUpdatefeedinMeeting($meeting_id,$meetwith__person);
    redirect('Menu/Dashboard');
}
public function AddNewLead($init_id){
    $user = $this->session->userdata('user');
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $alluser=$this->Menu_model->get_user();
    $status=$this->Menu_model->get_status();
    $action=$this->Menu_model->get_action();
    $states=$this->Menu_model->get_states();
    $partner=$this->Menu_model->get_partner();
    if(!empty($user)){
        $this->load->view($dep_name.'/AddNewLead',['user'=>$user,'alluser'=>$alluser,'status'=>$status,'action'=>$action,'states'=>$states,'partner'=>$partner,'uid'=>$uid,'init_id'=>$init_id]);
    }else{
        redirect('Menu/main');
    }
}
public function addcompany_new(){
    $uid= $this->input->post('uid');
    $compname= $this->input->post('compname');
    $website= $this->input->post('website');
    $country= $this->input->post('country');
    $city= $this->input->post('city');
    $state= $this->input->post('state');
    $draft= $this->input->post('draft');
    $address= $this->input->post('address');
    $ctype= $this->input->post('ctype');
    $budget= $this->input->post('budget');
    $compconname= $this->input->post('compconname');
    $emailid= $this->input->post('emailid');
    $phoneno= $this->input->post('phoneno');
    $draftop= $this->input->post('draftop');
    $designation= $this->input->post('designation');
    $top_spender= $this->input->post('top_spender');
    $upsell_client= $this->input->post('upsell_client');
    $focus_funnel= $this->input->post('focus_funnel');
    $key_company=$this->input->post('key_company');
    $potential_company=$this->input->post('potential_company');
    $clusterid      =   $this->input->post('cluster');
    $cstatusid      =   $this->input->post('cstatusid');
    $openrpem       =   $this->input->post('openrpem');
    $reachout       =   $this->input->post('reachout');
    $tentative      =   $this->input->post('tentative');
    $positivenap    =   $this->input->post('positivenap');
    $verypositive   =   $this->input->post('verypositive');
    $closure        =   $this->input->post('closure');
    $init_id        =   $this->input->post('init_id');
    $this->load->model('Menu_model');
    $id=$this->Menu_model->submit_company_new($uid,$compname, $website, $country, $city, $state, $draft, $address, $ctype, $budget, $compconname, $emailid, $phoneno, $draftop, $designation, $top_spender,$upsell_client,$focus_funnel,$key_company,$potential_company,$openrpem,$reachout,$verypositive,$positivenap,$tentative,$closure,$clusterid,$cstatusid,$init_id);
    redirect('Menu/Dashboard');
}
// Get Slef Assign Task
public function getAutoAssignTask(){
    $this->load->model('Menu_model');
    $uid            = $this->input->post('uid');
    $selectedValue  = $this->input->post('selectedValue');
  
    $cmps = $this->Menu_model->getTaskAssignBySelf($uid);
    $groupedByActionTypes = [];
    foreach ($cmps as $objects) {
        $action_id = $objects->action_id;
        if (!isset($groupedByActionTypes[$action_id])) {
            $groupedByActionTypes[$action_id] = [];
        }
        $groupedByActionTypes[$action_id][] = $objects;
    }
    // echo "<pre>";
    // print_r($groupedByActionTypes);
    echo '<option value="">Select Task</option>';
    
    foreach($groupedByActionTypes as $key => $petotaskData){
        $getaction_name = $this->Menu_model->get_actionbyid($key)[0]->name;
        $getaction_namecnts = sizeof($petotaskData);
        echo "<option value='$key'>$getaction_name($getaction_namecnts)</options>";
      }
}
public function getAutoAssignTaskWithType(){
    $this->load->model('Menu_model');
    $uid            = $this->input->post('uid');
    $selectedValue  = $this->input->post('selectedValue');
    $tasktype       = $this->input->post('tasktype');
  
    $cmps = $this->Menu_model->getTaskAssignBySelfWithTaskType($uid,$tasktype);
    $callTids = array_map(function($item) {
        return $item->call_tid;
    }, $cmps);
    
    $callTidsString = implode(', ', $callTids);
    $tasks = $this->Menu_model->getTBLTaskByID($callTidsString);
    $data = '';
    foreach ($tasks as $c) {
        $getcomp = $this->Menu_model->get_cmp_PlanPendingwork($c->cid_id);
        foreach ($getcomp as $cmpData) {
            $data .= '<option value="' . $c->id . '">' . $cmpData->compname.' ('.$cmpData->pname . ')</option>';
        }
    }
    echo $data;
}
public function getPendingTeamMoM(){
    $user           =   $this->session->userdata('user');
    $data['user']   =   $user;
    $uid            =   $user['user_id'];
    $uyid           =   $user['type_id'];
    $this->load->model('Menu_model');
    $uid            = $this->input->post('uid');
    if($uyid == 13 ){
        $users      = $this->Menu_model->get_userbyaaid($uid);
    }elseif($uyid == 4){
        $users      = $this->Menu_model->Get_PSTCLM($uid);
    }else{
        $users      = $this->Menu_model->get_userbyaaid($uid);
    }
    $user_id    = array_map(function($item) {
        return $item->user_id;
    }, $users);
    
    $user_id = implode(', ', $user_id);
    // $query=$this->db->query("SELECT * FROM `mom_data` WHERE user_id IN ($user_id) AND approved_status IS NULL");
    $query=$this->db->query("SELECT * FROM `mom_data` WHERE mom_data.`user_id` IN ($user_id) AND `approved_status` IS NULL AND NOT EXISTS (SELECT 1 FROM `tblcallevents` WHERE `mom_data`.`id` = `tblcallevents`.`reviewtype`)");
    $data =  $query->result();
    $pending_momdata =  sizeof($data);
    echo $pending_momdata;
}
// 10-08-2024
public function getstatuscmpnotplanedCompany(){
    $user           =   $this->session->userdata('user');
    $data['user']   =   $user;
    // $uid            =   $user['user_id'];
    $uyid           =   $user['type_id'];
    
    $sid= $this->input->post('sid');
    $uid= $this->input->post('uid');
    $this->load->model('Menu_model');
    if($sid == 4 || $sid == 5){
        if($uyid == 3){
            $days = 15;
        }elseif($uyid == 13 || $uyid == 4){
            $days = 30;
        }else{
            $days = 8;
        }
    }else{
        $days = 8;
    }
    $cmps = $this->Menu_model->CompanyThatBDHasNoWorkedInDays($uid,$days,$sid);
  
    echo '<option value="">Select Company</option>';
    foreach($cmps as $cmp){ ?>
    <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
<?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
    <?php
    }
}
public function nostatuschange_indate(){
    $user           =   $this->session->userdata('user');
    $data['user']   =   $user;
    // $uid            =   $user['user_id'];
    $uyid           =   $user['type_id'];
    
    $sid= $this->input->post('sid');
    $uid= $this->input->post('uid');
    $this->load->model('Menu_model');
    if($sid == 4 || $sid == 5){
        if($uyid == 3){
            $days = 15;
        }elseif($uyid == 13 || $uyid == 4){
            $days = 30;
        }else{
            $days = 8;
        }
    }else{
        $days = 8;
    }
    $cmps = $this->Menu_model->getCompanyWhichNoStatusChange($uid,$days,$sid);
    $cdate = date("Y-m-d");
    echo '<option value="">Select Company</option>';
    foreach($cmps as $cmp){ ?>
    <option style="color: #d90d2b;" title="<?=$cmp->days?> Days - <?=$cmp->compname?> (<?=$cmp->pname?>)" value="<?=$cmp->inid?>">
    <?=$cmp->days?> Days - <?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
    <?php
    }
}
// Review Start 
public function PlanningForReview(){
    $pdate              = $_POST['plandate'];
    $review_plantime    = $_POST['review_plantime'];
    $uid                = $_POST['uid'];
    $bdid               = $_POST['bdid'];
    $fixdate            = $_POST['fixdate'];
    $reviewtype         = $_POST['reviewtype'];
    $meetlink           = $_POST['meetlink'];
    $this->load->library('session');
    $this->load->model('Menu_model');
    $plandate = $pdate.' '.$review_plantime;
    $this->Menu_model->plan_review($plandate,$uid,$bdid,$reviewtype,$meetlink,$fixdate);
    $this->session->set_flashdata('success_message', 'Review Plan Created Successfully !');
    redirect('Menu/TaskPlanner2/'.$pdate);
}
public function CheckFirstTimeReviewInYear(){
    $user   = $this->session->userdata('user');
    $uid    = $user['user_id'];
    $uyid   =  $user['type_id'];
    $cyear  = date("Y");
    $inid   = $_POST['inid'];
    $this->load->model('Menu_model');
    $getFirstTimeReview = $this->Menu_model->GetFirstTimeReviewInYear($uid,$inid,$cyear);
    $getFirstTimeReviewcnt = sizeof($getFirstTimeReview);
    echo $getFirstTimeReviewcnt;
}
public function GetCompnayDetailsUsiingInit(){
    $user   = $this->session->userdata('user');
    $uid    = $user['user_id'];
    $uyid   =  $user['type_id'];
    $cyear  = date("Y");
    $inid   = $_POST['inid'];
    $this->load->model('Menu_model');
    $inidData = $this->Menu_model->get_cmpbyinid($inid);
    echo json_encode($inidData);
}
public function GetTaskOfReciewCompany(){
    $user   = $this->session->userdata('user');
    $uid    = $user['user_id'];
    $uyid   =  $user['type_id'];
    $cyear  = date("Y");
    $inid   = $_POST['inid'];
    $bdid   = $_POST['bdid'];
    $this->load->model('Menu_model');
    $data   = [];
    $query  = $this->db->query("SELECT * FROM `allreviewdata` WHERE inid = '$inid' and bdid = '$bdid' ORDER BY `id` DESC LIMIT 1");
    $data1  =  $query->result();
    $sdatet     = $data1[0]->sdatet;
    $exsid      = $data1[0]->exsid;
    $exdate     = $data1[0]->exdate;
    $reviewtype = $data1[0]->reviewtype;
    $statusname = $this->Menu_model->get_statusbyid($exsid)[0]->name;
    $inidData   = $this->Menu_model->get_cmpbyinid($inid);
    $cstatus    = $inidData[0]->cstatus;
    $cur_statusname = $this->Menu_model->get_statusbyid($cstatus)[0]->name;
    $data ['review_date']= $sdatet;
    $data ['expet_status_name']= $statusname;
    $data ['expet_status_date']= $exdate;
    $data ['current_status_name']= $cur_statusname;
    $data ['review_type']= $reviewtype;
    echo json_encode($data);
}
public function getPartnerBYID(){
    $user   = $this->session->userdata('user');
    $uid    = $user['user_id'];
    $uyid   =  $user['type_id'];
    $cyear  = date("Y");
    $name   = $_POST['name'];
    $pid   = $_POST['pid'];
    $this->load->model('Menu_model');
    if($name = 'Partner'){
        $partner = $this->Menu_model->get_partnerbyid($pid);
        $partnername = $partner[0]->name;
        echo $partnername;
    }
    
}
public function NeedYourAttentionInCompany(){
    $user = $this->session->userdata('user');
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $sid= $this->input->post('sid');
    $uid= $this->input->post('uid');
    $days = 8;
    $nya_data  = $this->Menu_model->NeedYourAttentions($days,$sid);
    echo '<option value="">Select Company</option>';
    foreach($nya_data as $cmp){
        if($cmp->days <= 20){
            $color = '#D70040';
        }else if($cmp->days >= 20 && $cmp->days <= 40){
            $color = '#D2042D';
        }elseif($cmp->days >= 40){
            $color = '#FF0000';
        }
        ?>
        <option style="color:<?=$color;?>" title="<?= $cmp->days ?> Days - <?=$cmp->compname?> (<?= $cmp->bdname ?>)" value="<?=$cmp->inid?>">
        <?= $cmp->days ?> Days - <?=$cmp->compname?> (<?= $cmp->bdname ?> )
        </option>
        <?php
            }
}
public function SpecialRequestForLeaveSomeTimeData(){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $requests = $this->Menu_model->getSpecialRequestForLeaveData($uid,$uyid);
    $this->load->view($dep_name.'/SpecialRequestForLeaveSomeTimeData',['user'=>$user,'uid'=>$uid,'requests'=>$requests]);
}
public function AdminAcceptSpecialRequest(){
    $user           = $this->session->userdata('user');
    $data['user']   = $user;
    $uid            = $user['user_id'];
    $uyid           =  $user['type_id'];
    $this->load->model('Menu_model');
    $this->load->library('session');
    $req_id     = $_POST['id'];
    $status     = $_POST['status'];
    $remarks    = $_POST['remarks'];
    
    $current_datetime   = date("Y-m-d H:i:s");
    if($status == 'Approved'){
        
        $message_variable   = 'success_message';
        $reqData            =   $this->Menu_model->getSpecialRequestForLeaveByID($req_id);
        $req_user_id        =   $reqData[0]->user_id;
        $req_date           =   $reqData[0]->date;
        $req_stime          =   $reqData[0]->stime;
        $req_etime          =   $reqData[0]->etime;
        $start_tommorow     =   $reqData[0]->start_tommorow;
        $current_date       = date("Y-m-d");
     
        $tomorrow_date = date('Y-m-d', strtotime($current_date . ' +1 day'));
       
        // $tostime = $start_tommorow;
        $tostime = '10:00:00';
        $tasks = $this->Menu_model->getTaskBetweenTime($req_user_id,$current_date,$req_stime,$req_etime);
      
        $taskssize = sizeof($tasks);
 
        if($taskssize > 0){
            $i=1;
            foreach($tasks as $task){
                $task_id        =  $task->id;
                $task_date      =  $task->appointmentdatetime;
                $actiontype_id  =  $task->actiontype_id;
                $act = $this->Menu_model->get_actionbyid($actiontype_id);
                $yesttime = $act[0]->yest;
                if($i == 1){
                    $newDateTime = $tomorrow_date . ' ' . $tostime;
                    $query  = $this->db->query("UPDATE `tblcallevents` SET `appointmentdatetime`='$newDateTime',`plan_change`='1' WHERE id='$task_id'");
                    if($actiontype_id == 3 || $actiontype_id == 4 || $actiontype_id == 17){
                        $mtdata = $this->Menu_model->getMeetinfoBytid($task_id);
                        $mtdatacnt =sizeof($mtdata);
                        if($mtdatacnt == 1){
                            $query  = $this->db->query("UPDATE `barginmeeting` SET `storedt`='$newDateTime',`plan_change`='1' WHERE tid ='$task_id'");
                        }
                    }
                    $start = new DateTime($newDateTime);
                    $start->modify("+$yesttime minutes");
                    $newDateTime = $start->format('Y-m-d H:i:s');
                }else{
                    $start = new DateTime($newDateTime);
                    $start->modify("+$yesttime minutes");
                    $newDateTime = $start->format('Y-m-d H:i:s');
                    $query  = $this->db->query("UPDATE `tblcallevents` SET `appointmentdatetime`='$newDateTime',`plan_change`='1' WHERE id='$task_id'");
                    if($actiontype_id == 3 || $actiontype_id == 4 || $actiontype_id == 17){
                        $mtdata = $this->Menu_model->getMeetinfoBytid($task_id);
                        $mtdatacnt =sizeof($mtdata);
                        if($mtdatacnt == 1){
                            $query  = $this->db->query("UPDATE `barginmeeting` SET `storedt`='$newDateTime',`plan_change`='1' WHERE tid ='$task_id'");
                        }
                    }
                }
                $i++;
            }
        }
        $query  = $this->db->query("UPDATE `special_request_for_leave` SET `approve_by`='$uid',`approve_status`='$status',`approve_date`='$current_datetime',`approve_remarks`='$remarks' WHERE id = '$req_id'");
    }
    if($status == 'Reject'){
        $message_variable = 'reject_message';
        $query  = $this->db->query("UPDATE `special_request_for_leave` SET `approve_by`='$uid',`approve_status`='$status',`approve_date`='$current_datetime',`approve_remarks`='$remarks' WHERE id = '$req_id'");
    }
    $this->session->set_flashdata($message_variable, 'Request '.$status.' Successfully !');
    redirect('Menu/SpecialRequestForLeaveSomeTimeData');
}
public function GetTaskBeetweenUserTime(){
    $user   = $this->session->userdata('user');
    $uid    = $user['user_id'];
    $uyid   =  $user['type_id'];
    $this->load->model('Menu_model');
    $mtime1 = $this->input->post('mtime1');
    $mtime2 = $this->input->post('mtime2');
    $cdate = date("Y-m-d");
    $tasks = $this->Menu_model->getTaskBetweenTimeWithAction($uid,$cdate,$mtime1,$mtime2);
    
    $html = '';
        $html .= "<table class='table'>
        <thead class='thead-dark'>
            <tr>
                <th>Task Name</th>
                <th>Count</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>";
        $totoaltime = '';
        foreach ($tasks as $item) {
            $act = $this->Menu_model->get_actionbyid($item->aid);
            $yesttime = $act[0]->yest;
            $tasktime = $item->cont * $yesttime;
            $totoaltime +=$tasktime;
            $html .= "<tr>
                <td>{$item->acname}</td>
                <td>{$item->cont}</td>
                <td>{$tasktime} Minutes</td>
            </tr>";
        }
        $hours = floor($totoaltime / 60);  // Get the number of full hours
        $remainingMinutes = $totoaltime % 60; // Get the remaining minutes
        $html .= "<tr>
        <td colspan='3'>Total Time : {$hours} hours and {$remainingMinutes} minutes</td>
    </tr>";
        $html .= "</tbody>
        </table>";
        echo $html;
  
}
public function getUserDayStartStatus(){
    
    $user   = $this->session->userdata('user');
    $uid    = $user['user_id'];
    $uyid   =  $user['type_id'];
    $this->load->model('Menu_model');
    $user_day = $this->Menu_model->getUserDayStartDetails($uid,date("Y-m-d"));
    $user_day_wffo = $user_day[0]->wffo;
    
    echo $user_day_wffo;
}
public function AddSpecialCommentOnTask(){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $tasks = $this->Menu_model->GetTommarowPlanTask($uid);
    $this->load->view($dep_name.'/AddSpecialCommentOnTask',['user'=>$user,'uid'=>$uid,'tasks'=>$tasks]);
}
public function AddThanksCommentOnTask(){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $tasks = $this->Menu_model->GetYesterDaysPlanTask($uid);
    if(!empty($user)){
        $this->load->view($dep_name.'/AddThanksCommentOnTask',['user'=>$user,'uid'=>$uid,'tasks'=>$tasks]);
    }else{
        redirect('Menu/main');
    }
}
public function AddTaskComments(){
    $user           = $this->session->userdata('user');
    $data['user']   = $user;
    $uid            = $user['user_id'];
    $uyid           =  $user['type_id'];
    $this->load->model('Menu_model');
    $this->load->library('session');
    $commentsid         = $this->input->post('commentsid');
    $comments           = $this->input->post('comments');
    $comments           = strip_tags($comments);
    $encode_comments    = base64_encode($comments);
    $query  = $this->db->query("UPDATE `tblcallevents` SET`comment_by`='$uid',`comments`='$encode_comments' WHERE id ='$commentsid'");
    $this->session->set_flashdata('success_message','Task Comments Added Successfully !');
    redirect('Menu/AddSpecialCommentOnTask');
}
public function AddTaskthanksCommentsbyUser(){
    $user           = $this->session->userdata('user');
    $data['user']   = $user;
    $uid            = $user['user_id'];
    $uyid           =  $user['type_id'];
    $this->load->model('Menu_model');
    $this->load->library('session');
    $commentsid         = $this->input->post('commentsid');
    $comments           = $this->input->post('comments');
    $comments           = strip_tags($comments);
    $encode_comments    = base64_encode($comments);
    $query  = $this->db->query("UPDATE `tblcallevents` SET`comment_by`='$uid',`thnkscomments`='$encode_comments' WHERE id ='$commentsid'");
    $this->session->set_flashdata('success_message','Thanks Comments Added Successfully !');
    redirect('Menu/AddThanksCommentOnTask');
}
public function GetTaskComments(){
  
    $this->load->model('Menu_model');
    $taskid             = $this->input->post('taskid');
    $tasksData          = $this->Menu_model->get_lasttask($taskid);
    $comment_by         = $tasksData[0]->comment_by;
    $comments           = $tasksData[0]->comments;
    if($comment_by !== '' && $comment_by !== NULL){
        $decode_comments    = base64_decode($comments);
        $udetail            = $this->Menu_model->get_userbyid($comment_by);
        $uname              = $udetail[0]->name;
        $message = $decode_comments.' - <b>'.$uname.'</b>';
        echo $message;
    }else{
        echo $message = '';
    }
}
public function NeedYourAttentionsInAdmin(){
   
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $needdata = $this->Menu_model->NeedYourAttentions(15,'1,2,8,3,6,9,12,13');
    if(!empty($user)){
        $this->load->view($dep_name.'/NeedYourAttentionsInAdmin',['uid'=>$uid,'user'=>$user,'needdata'=>$needdata]);
    }else{
        redirect('Menu/main');
    }
}
public function GetMeetCompanyInfo(){
    
    $user   = $this->session->userdata('user');
    $uid    = $user['user_id'];
    $uyid   =  $user['type_id'];
    $this->load->model('Menu_model');
    $mid    = $this->input->post('mid');
    
    $mitinfo = $this->Menu_model->getMeetinfoByid($mid);
    $mitinfocnt = sizeof($mitinfo);
    if($mitinfocnt > 0){
        $mitinfojson = json_encode($mitinfo);
        echo $mitinfojson;
    }
}
public function GetCompanyLastStatus(){
    
    $user   = $this->session->userdata('user');
    $uid    = $user['user_id'];
    $uyid   =  $user['type_id'];
    $this->load->model('Menu_model');
    $mom_id = $this->input->post('mom_id');
    $momdata = $this->Menu_model->getRequestMOMBYID($mom_id);
    $init_cmpid = $momdata[0]->init_cmpid;
    $initdata = $this->Menu_model->get_cmpbyinid($init_cmpid);
    // $lstatus = $initdata[0]->lstatus;
    $lstatus = 2;
    
    $lstatusdata = $this->Menu_model->get_statusbyid($lstatus);
    echo "<option value='".$lstatus."'>".$lstatusdata[0]->name."</option>";
   
}
public function ConfirmReminder($id){
    
    $user   = $this->session->userdata('user');
    $uid    = $user['user_id'];
    $uyid   =  $user['type_id'];
    $this->load->model('Menu_model');
    $message    = 'Reminder was successfully accepted.';
    $remdata    = $this->Menu_model->getReminderData($id);
    $rem_type   = $remdata[0]->type;
    $this->Menu_model->ConfirmRemindertoUser($id,$uid,$message);
    $this->load->library('session');
    $this->session->set_flashdata('success_message',$message);
    if($rem_type == 1){
        redirect('Menu/YesterDayDaysCloseRequest');
    }elseif($rem_type == 2){
        redirect('Menu/TodaysTaskApprovelRequest');
    }elseif($rem_type == 3){
        redirect('Menu/SpecialRequestForLeaveSomeTimeData');
    }elseif($rem_type == 4){
        redirect('Menu/PlannerTaskApprovelPage');
    }elseif($rem_type == 5){
        redirect('Menu/GetTodaysTeamDayChnageRequestData');
    }else{
        redirect('Menu/dashboard');
    }
}
public function CheckuserDayAccardingPlanner(){
    
    $user   = $this->session->userdata('user');
    $uid    = $user['user_id'];
    $uyid   =  $user['type_id'];
    $this->load->model('Menu_model');
    
    $wffo = $this->input->post('wffo');
    $usdata1 = $this->Menu_model->userworkfrombyid($wffo);
    $wffomsg = $usdata1[0]->TYPE;
    $cdate = date("Y-m-d");
    $uime =$this->db->select('*') ->from('autotask_time') ->where('date', $cdate) ->where('user_id', $uid) ->order_by('id', 'DESC') ->get() ->result();
    $uimecnt = sizeof($uime);
    if($uimecnt > 0){
        $userworkfrom = $uime[0]->userworkfrom;
        if($wffo !== $userworkfrom){
    
            $usdata = $this->Menu_model->userworkfrombyid($userworkfrom);
            $usdatamsg = $usdata[0]->TYPE;
            echo $usdatamsg;
        }
    }
}
public function SendRequestForDayStartChnage(){
    
    $user   = $this->session->userdata('user');
    $uid    = $user['user_id'];
    $uyid   =  $user['type_id'];
    $this->load->model('Menu_model');
    $message            = $this->input->post('message');
    $user_want_start    = $this->input->post('user_want_start');
    $data = array(
        'user_id'     => $uid,
        'date'        => date("Y-m-d H:i:s"),
        'message'     => $message,
        'user_want_start' => $user_want_start
    );
    
    $this->db->insert('change_user_day_request', $data);
    $this->load->library('session');
    $this->session->set_flashdata('success_message','Request to change the start your Days Sended Successfully !');
    redirect('Menu/DayManagement');
}
public function GetTodaysTeamDayChnageRequestData(){
   
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
    $daychangedata = $this->Menu_model->GetTodaysTeamDayChnageRequest($uid);
    if(!empty($user)){
        $this->load->view($dep_name.'/GetTodaysTeamDayChnageRequestData',['uid'=>$uid,'user'=>$user,'daychangedata'=>$daychangedata]);
    }else{
        redirect('Menu/main');
    }
}
public function TodayDayStartapprove($id,$type){
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    if($type == 'Approve'){
        $status = 1;
        $reamrks = "Approved By ".$user['name'];
        $query =  $this->db->query("UPDATE `change_user_day_request` SET `apr_status`='$status',`apr_by`='$uid',`amessage`='$reamrks' WHERE id = $id");
        $this->load->library('session');
        $this->session->set_flashdata('success_message','Request to change the start your Days Approved  Successfully !');
        redirect("Menu/GetTodaysTeamDayChnageRequestData");
    }else{
        redirect('Menu/main');
    }
}
public function TodaysDayChageReject(){
    $rejectid = $_POST['reject'];
    $rejectreamrk = $_POST['rejectreamrk'];
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $status = 2;
    $query =  $this->db->query("UPDATE `change_user_day_request` SET `apr_by`='$uid',`apr_status`='$status',`amessage`='$rejectreamrk' WHERE id = $rejectid");
    redirect("Menu/GetTodaysTeamDayChnageRequestData");
}
public function getcmp_becauseofplanchange(){
    $taskaction= $this->input->post('taskaction');
    $uid= $this->input->post('uid');
    $this->load->model('Menu_model');
    $cmp = $this->Menu_model->GetTaskBecauseOfPlanChangeWithAction($taskaction,$uid);
   
    $data = '';
    $callsids = '';
    foreach ($cmp as $c) {
        $getcomp = $this->Menu_model->get_cmp_PlanPendingwork($c->cid_id);
        foreach ($getcomp as $cmpData) {
            $data .= '<option value="' . $c->id . '">' . $cmpData->compname.' ('.$cmpData->pname . ')</option>';
        }
    }
   echo $data;
}
public function getownfunnel(){
    $sid = $this->input->post('sid');
    $uid= $this->input->post('uid');
    $this->load->model('Menu_model');
    $cmp = $this->Menu_model->get_statuscmp($sid,$uid);
    echo '<option value="">Select Company</option>';
    foreach($cmp as $cmp){ ?>
    <option style="color: #d90d2b;" value="<?=$cmp->inid?>">
<?=$cmp->compname?> (<?=$cmp->pname?>)
</option>
    <?php
    }
}
public function getstatuscmp_becauseoftpm(){
    $becauseofTPM = $this->input->post('becauseofTPM');
    $uid= $this->input->post('uid');
    $this->load->model('Menu_model');
    $cmp = $this->Menu_model->GetCompanyClusterWorkBecauseOf($uid,$becauseofTPM);
    echo '<option value="">Select Company</option>';
    foreach($cmp as $cmp){
        $name = $cmp->name;
        if($becauseofTPM == 'both'){  $apst = $cmp->apst; ?>
        <option style="color: #d90d2b;" title="<?=$name;?> ( <?= $apst; ?>)" value="<?=$cmp->inid?>">
            <?=$cmp->compname?> (<?=$cmp->pname?>)
        </option>
       <?php }else{ ?>
        <option style="color: #d90d2b;" title="<?=$name;?>" value="<?=$cmp->inid?>">
            <?=$cmp->compname?> (<?=$cmp->pname?>)
        </option>
       <?php } ?>
        <?php
        }
}
public function get_becauseoftpm(){
    $usertypes = $this->input->post('usertypes');
    $becauseofTPM = $this->input->post('becauseofTPM');
    $uid= $this->input->post('uid');
    $this->load->model('Menu_model');
    $cmp = $this->Menu_model->GetCompanyClusterWorkBecauseOfUser($uid,$usertypes,$becauseofTPM);
    echo '<option value="">Select Company</option>';
    foreach($cmp as $cmp){
        $name = $cmp->name;
        if($becauseofTPM == 'both'){  $apst = $cmp->apst; ?>
        <option style="color: #d90d2b;" title="<?=$name;?> ( <?= $apst; ?>)" value="<?=$cmp->inid?>">
            <?=$cmp->compname?> (<?=$cmp->pname?>)
        </option>
       <?php }else{ ?>
        <option style="color: #d90d2b;" title="<?=$name;?>" value="<?=$cmp->inid?>">
            <?=$cmp->compname?> (<?=$cmp->pname?>)
        </option>
       <?php } ?>
        <?php
        }
  
}
/********End *****************/


/******** Start To Get Task Available Slot TIme *****************/

public function getTaskAvailableTime(){

    $user           = $this->session->userdata('user');
    $uid            = $user['user_id'];
    $data['user']   = $user;
    $user_id        = $user['user_id'];
    $this->load->model('Menu_model');
    $sdate    = $this->input->post('sdate');
    $avltimeslct    = $this->input->post('avltimeslct');

    if($avltimeslct == 1){
        $time1 = '10:00:00';
        $time2 = '11:00:00';
    }elseif($avltimeslct == 2){
        $time1 = '11:00:00';
        $time2 = '12:00:00';
    }elseif($avltimeslct == 3){
        $time1 = '12:00:00';
        $time2 = '13:00:00';
    }elseif($avltimeslct == 4){
        $time1 = '13:00:00';
        $time2 = '14:00:00';
    }elseif($avltimeslct == 5){
        $time1 = '14:00:00';
        $time2 = '15:00:00';
    }elseif($avltimeslct == 6){
        $time1 = '15:00:00';
        $time2 = '16:00:00';
    }elseif($avltimeslct == 7){
        $time1 = '16:00:00';
        $time2 = '17:00:00';
    }

$slotdata =   $this->Menu_model->CheckTodaysTaskAvilableTime($user_id,$time1,$time2,$sdate);
// echo $this->db->last_query();

$appointmentDates = array_column($slotdata, 'appointmentdatetime');
$filteredTimes = array_filter($slotdata, function($item) use ($appointmentDates) {
    return !in_array($item->next_available_time, $appointmentDates);
});
$result = array_map(function($item) {
    return $item->next_available_time;
}, $filteredTimes);

$slotrees = sizeof($result);

$html = '';
if($slotrees == 0){
    $span = '<span class="findslot">All Slot is Free</span>';
    $html .= $span;
}else{
    $filteredArray = array_filter($result);
    foreach($filteredArray as $res){
        if($res !== ''){

            $dateTime = new DateTime($res);
            $time = $dateTime->format('H:i:s');
            $span = '<span class="findslot">'.$time.'</span>';
            $html .= $span;
        }
    }
    
}

echo $html;

}
public function getTaskPlannedTime(){

    $user           = $this->session->userdata('user');
    $uid            = $user['user_id'];
    $data['user']   = $user;
    $user_id        = $user['user_id'];
    $this->load->model('Menu_model');
    $sdate    = $this->input->post('sdate');
    $avltimeslct    = $this->input->post('avltimeslct');

    if($avltimeslct == 1){
        $time1 = '10:00:00';
        $time2 = '11:00:00';
    }elseif($avltimeslct == 2){
        $time1 = '11:00:00';
        $time2 = '12:00:00';
    }elseif($avltimeslct == 3){
        $time1 = '12:00:00';
        $time2 = '13:00:00';
    }elseif($avltimeslct == 4){
        $time1 = '13:00:00';
        $time2 = '14:00:00';
    }elseif($avltimeslct == 5){
        $time1 = '14:00:00';
        $time2 = '15:00:00';
    }elseif($avltimeslct == 6){
        $time1 = '15:00:00';
        $time2 = '16:00:00';
    }elseif($avltimeslct == 7){
        $time1 = '16:00:00';
        $time2 = '17:00:00';
    }

$slotdata =   $this->Menu_model->GetBookedSlot($user_id,$time1,$time2,$sdate);

// echo $this->db->last_query();
$slotrees = sizeof($slotdata);

$html = '';

if($slotrees > 0){
    foreach($slotdata as $res){

        $dateTime = new DateTime($res->bookedtime);
        $time = $dateTime->format('H:i:s');
        $span = '<span class="findbookedslottime">'.$time.'</span>';
        $html .= $span;
    }
}

echo $html;

}

/******** Start To Get Task Available Slot TIme *****************/

public function UserVisitPage(){
    $user           = $this->session->userdata('user');
    $user_id        = $user['user_id'];
    $page           = "Planner Page";
    $action         = "Planning";
    $this->load->model('Menu_model');

    if(isset($_POST['action'])){
        $action = $_POST['action'];
    }else{
        $action = '';
    }
        if ($action && $page) {
            if ($action === 'visit') {
                $this->Menu_model->insert_visit($user_id, $page, $action);
            } elseif ($action === 'leave') {
                $this->Menu_model->insert_visit($user_id, $page, $action);
                echo  $this->db->last_query();
            }
    }   
}


public function CheckTaskPlanningTime(){
    
    date_default_timezone_set("Asia/Calcutta");
    $user           = $this->session->userdata('user');
    $uid            = $user['user_id'];
    $aptime         = $this->Menu_model->GetTodaysAutoTaskANDPlanningTime($uid,date("Y-m-d"));
    $aptimecnt      = sizeof($aptime);
    $initedtime     = Date("Y-m-d H:i:s");
    $tdate          = date("Y-m-d");
    $user_day       = $this->Menu_model->get_daystarted($uid,date("Y-m-d"));

      if(sizeof($user_day) > 0){
        $pinitiate_time = $user_day[0]->planner_initiate_time;
        if($pinitiate_time == ''){
            $query =  $this->db->query("UPDATE `user_day` SET `planner_initiate_time`='$initedtime' WHERE user_id='$uid' and cast(ustart as DATE)='$tdate'");
        }
      }  

    if($aptimecnt > 0){

       $givenTime   = $aptime[0]->start_tttpft;
       $currentTime = date("H:i:s");
       $timestamp1  = strtotime($givenTime);
       $timestamp2  = strtotime($currentTime);
    
       if ($givenTime >= $currentTime) {
        echo "false";
        $this->load->library('session');
        $this->session->set_flashdata('success_message', 'You Can Plan Task For Todays!');
       } else {
        echo "true";
        $this->load->library('session');
        $this->session->set_flashdata('success_message', 'Now You Can Start Planning For Tomorrow ');
       }
    }else{
        echo "false";
        $this->load->library('session');
        $this->session->set_flashdata('success_message', 'You Can Plan Task For Todays!');
    }
}



public function TestPage(){
    date_default_timezone_set("Asia/Calcutta");
    $tdate=date('Y-m-d H:i:s');
    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];
    $this->load->model('Menu_model');
    $dt=$this->Menu_model->get_utype($uyid);
    $dep_name = $dt[0]->name;
  
    if(!empty($user)){
        $this->load->view($dep_name.'/TestPage',['uid'=>$uid,'user'=>$user,'mdata'=>'']);
    }else{
        redirect('Menu/main');
    }
}

// Start Review Changes
public function GetCompanyPrimaryContact(){

    $user = $this->session->userdata('user');
    $data['user'] = $user;
    $uid = $user['user_id'];
    $uyid =  $user['type_id'];

    $this->load->model('Menu_model');

    $cmpid = $_POST['cmpid_id'];
    $ctype = $_POST['ctype'];

    $data = $this->Menu_model->getCompanyContact($cmpid,$ctype);
    $datacnt = sizeof($data);
    $html = "";
    if ($datacnt > 0) {
        foreach ($data as $dt) {
            $html .= "Contact Person : <span class='pccolor'>" . (($dt->contactperson) ? $dt->contactperson : 'NA') . "</span><br/>";
            $html .= "Email ID : <span class='pccolor'>" . (($dt->emailid) ? $dt->emailid : 'NA') . "</span><br/>";
            $html .= "Phone Number : <span class='pccolor'>" . (($dt->phoneno) ? $dt->phoneno : 'NA') . "</span><br/>";
            $html .= "Designation : <span class='pccolor'>" . (($dt->designation) ? $dt->designation : 'NA') . "</span><br/>";
            $html .= "Contact Type : <span class='pccolor'>" . (($dt->type) ? $dt->type : 'NA') . "</span><br/>";
            $html .= "<br/>";
        }
    } else {
        $html .= "NA";
    }
    
    echo $html;
}

public function GetStatusName(){
    $this->load->model('Menu_model');
    $cstatus    = $_POST['cstatus'];
    $statusName = $this->Menu_model->get_statusbyid($cstatus)[0]->name;
    echo $statusName;
}
public function GetPartnerTypeName(){
    $this->load->model('Menu_model');
    $ptid    = $_POST['partnerType_id'];
    $partnerName = $this->Menu_model->get_partnerbyid($ptid)[0]->name;
    echo $partnerName;
}
public function GetClusterName(){
    $this->load->model('Menu_model');
    $cluster_id    = $_POST['cluster_id'];
    $clusterName = $this->Menu_model->getClusterByid($cluster_id)[0]->clustername;
    echo $clusterName;
}


}