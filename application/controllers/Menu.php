<?php 
date_default_timezone_set("Asia/Calcutta");
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Menu extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->access_control->block_urls();
    }
    public function blocked_page(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $this->load->view($dep_name.'/blocked_page');
    }
    
    public function main(){
        $msg = '';
        $this->load->model('Menu_model');
        $this->load->view('index');
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
        $mdata = $this->Menu_model->get_userbyaid($uid);
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
        $mdata = $this->Menu_model->get_daytc($uid);
        $mytarget=$this->Menu_model->get_mytarget($uid);
        if(!empty($user)){
            $this->load->view($dep_name.'/Mytarget',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'mytarget'=>$mytarget]);
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
        
        if($cstatus==6){
        foreach($result as $d){if($d->id==6){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        
        if($cstatus==7){
        foreach($result as $d){if($d->id==7 || $d->id==4  || $d->id==5 || $d->id==9 || $d->id==10 || $d->id==11 || $d->id==13){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        
        if($cstatus==9){
        foreach($result as $d){if($d->id==9){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        
        if($cstatus==10){
        foreach($result as $d){if($d->id==10){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        if($cstatus==11){
        foreach($result as $d){if($d->id==11){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        
        if($cstatus==12){
        foreach($result as $d){if($d->id==9 || $d->id==13){
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
        
        $status=1;$filname="";$tid="";$uid="";$action_id="";$ystatus="";$remark="";$remark_msg="";$noremark="";$purpose="";$nremark_msg="";$rpmmom='null';$mom='null';$flink='null';$flink1='null';$flink2='null';
        $tid = $_POST['tid'];
        $uid = $_POST['uid'];
        $cmpid = $_POST['cmpid'];
        $cstatus = $_POST['ccstatus']; 
        $actontaken = $_POST['actontaken'];
        
        $LinkedIn = $_POST['LinkedIn'];
        $Facebook = $_POST['Facebook'];
        $YouTube = $_POST['YouTube'];
        $Instagram = $_POST['Instagram'];
        $OtherSocial = $_POST['OtherSocial'];
        
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
    
    public function submitRPP(){
        $priority = $_POST['priority'];
        $tid = $_POST['tmid'];
        $this->load->model('Menu_model'); 
        $id = $this->Menu_model->submit_RPP($tid,$priority);
        redirect('Menu/RPPriority');
    }
    
    public function daysc(){
        $autotask=0;
        $wffo=0;
        $do = $_POST['do'];
        if(isset($_POST['wffo'])){$wffo = $_POST['wffo'];}
        $user_id = $_POST['user_id'];
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        $autotask = $_POST['autotask'];
        $filname = $_FILES['filname']['name'];
        $uploadPath = 'uploads/day/';
        $this->load->model('Menu_model');
        $flink = $this->Menu_model->uploadfile($filname, $uploadPath);
        
        $this->Menu_model->submit_day($wffo,$flink,$user_id,$lat,$lng,$do,$autotask);
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
        $this->Menu_model->close_review($closetdate,$closeremark,$rrid);
        redirect('Menu/AllReviewPlaing');
    }
    
    
    public function pstclosereview(){
        $closeremark = $_POST['closeremark'];
        $closetdate = $_POST['closetdate'];
        $rrid = $_POST['rrid'];
        $this->load->model('Menu_model');
        $this->Menu_model->close_review($closetdate,$closeremark,$rrid);
        redirect('Menu/AllPSTReviewPlaing');
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
        redirect('Menu/TaskPlanner/'.$tdate);
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
        if(!empty($user)){
            $this->load->view($dep_name.'/TaskPlanner',['uid'=>$uid,'user'=>$user,'adate'=>$adate,'tptime'=>$tptime]);
        }else{
            redirect('Menu/main');
        }  
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
        // var_dump($dep_name);die;
        if(!empty($user)){
            $this->load->view($dep_name.'/index',['myid'=>$myid,'ttdone'=>$ttdone,'upt'=>$upt,'user'=>$user,'fr'=>$fr,'callr'=>$callr,'emailr'=>$emailr,'meetingr'=>$meetingr,'pendingt'=>$pendingt,'totalt'=>$totalt,'patc'=>$patc,'tatc'=>$tatc,'pate'=>$pate,'tate'=>$tate,'patm'=>$patm,'tatm'=>$tatm,'sc'=>$sc,'tptask'=>$tptask,'ttd'=>$ttd,'barg'=>$barg,'uid'=>$uid,'pstc'=>$pstc,'poc'=>$poc,'vpoc'=>$vpoc,'tnos'=>$tnos,'revenue'=>$revenue,'tsww'=>$tsww,'bdc'=>$bdc,'tdate'=>$tdate,'mbdc'=>$mbdc]);
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
        $mdata = $this->Menu_model->get_userbyaids($aid);
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
        $mdata = $this->Menu_model->get_userbyaid($aid);
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
    
    public function editremark(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uname = $user['name'];
        $edid = $_POST['editid'];
        $editrem = $_POST['editrem'];
        $this->load->model('Menu_model');
        $data1 = [
            'remark' =>$editrem,
        ];
        $db3 = $this->load->database('db3', TRUE);
        $db3->where('id',$edid);
        $db3->update('bdrequest',$data1);
        redirect('Menu/Dashboard');
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
        $flink = $this->Menu_model->cphotofile($cphoto, $uploadPath);
        
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        $bscid = $_POST['bscid'];
        $this->load->model('Menu_model');
        $cphoto = $flink;
        $cbmid = $this->Menu_model->start_rpm($uid,$startm,$company_name,$cphoto,$lat,$lng,$smid,$bscid);
        redirect('Menu/Dashboard');
    }
    
    public function rpmclose(){
        $priority="";$closem="";$caddress="";$cpname="";$cpdes="";$cpno="";$cpemail="";
        $uid = $_POST['uid'];
        $cmid = $_POST['cmid'];
        $bmcid = $_POST['bmcid'];
        $bmccid = $_POST['bmccid'];
        $bminid = $_POST['bminid'];
        $bmtid = $_POST['bmtid'];
        if(isset($_POST['priority'])){$priority = $_POST['priority'];}
        $closem = $_POST['closem'];
        $type = $_POST['type'];
            $caddress = $_POST['caddress'];
            $cpname = $_POST['cpname'];
            $cpdes = $_POST['cpdes'];
            $cpno = $_POST['cpno'];
            $cpemail = $_POST['cpemail'];
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        $this->load->model('Menu_model');
        $cbmid = $this->Menu_model->close_rpm($uid,$closem,$caddress,$cpname,$cpdes,$cpno,$cpemail,$lat,$lng,$type,$priority,$cmid,$bmcid,$bmccid,$bminid,$bmtid);
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
        if(!empty($user)){
            $this->load->view($dep_name.'/TBMD',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
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
        
        $mdata = $this->Menu_model->get_reviewr($pstid,$bdid,$sd,$ed);
        
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
        $user = $this->session->userdata('user');
        // print_r($user);die;
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        // print_r($dep_name);die;
        if(!empty($user)){
            $this->load->view($dep_name.'/workdoneCompanyBDPST',['uid'=>$uid,'user'=>$user]);
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
            $this->load->view($dep_name.'/PSTDataDetail',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'tdate'=>$tdate,'code'=>$code,'ab'=>$ab,'bdid'=>$bdid]);
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
            $this->load->view($dep_name.'/PSTDataCDetail',['uid'=>$uid,'user'=>$user,'tdate'=>$tdate,'ab'=>$ab,'bdid'=>$bdid]);
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
        if($mdata)
        {$st = $mdata[0]->ustart;
         $ct = $mdata[0]->uclose;
            if($st!=''){$do=1;}
            if($ct!=''){$do=2;}
        }else{$do=0;}
        
        
        if(!empty($user)){
            $this->load->view($dep_name.'/DayManagement',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'uid'=>$uid,'do'=>$do]);
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
        $admid = $udetail[0]->admin_id;
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
            $this->load->view($dep_name.'/DayCloseCheck',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
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
        $mdata = $this->Menu_model->get_daytc($uid);
        $l = sizeof($mdata);
        if($l==0){$do=1;}else{$do=2;}
        if(!empty($user)){
            $this->load->view($dep_name.'/AllPSTReviewPlaing.php',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'do'=>$do]);
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
    
    public function test8(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_test8();
    }
    
    
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
        $mdata=$this->Menu_model->get_userbyaids($uid);
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
        if($code==0){
            $mdata=$this->Menu_model->get_bdtcom($uid);
        }else{
            $mdata=$this->Menu_model->get_bdcombystatus($uid,$code);
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
        // var_dump($dep_name);die;
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
        
        
        
        
        $this->load->model('Menu_model');
        $this->Menu_model->all_bdrremark($deletef,$patnertype,$topspender,$keyclient,$pkeyclient,$priorityclient,$upsellclient,$focusyclient,$rid,$inid,$bdid,$remark,$ntdate,$ntaction,$pstuid,$exsid,$exdate,$rtype,$taskupdate,$potential,$ans1,$ans2,$ans3,$ans4,$requeststatus,$csrbudget,$bdscholl);
        redirect('Menu/AllReviewPlaing/'); 
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
        if($code==0){
            $mdata=$this->Menu_model->get_bdtcomcat($bdid,$categories);
        }else{
            $mdata=$this->Menu_model->get_bdcombystatuscat($bdid,$code,$categories);
        }
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
            $this->load->view($dep_name.'/pstassignc',['user'=>$user,'mdata'=>$mdata,'code'=>$code,'uid'=>$uid]);
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
    
    
    
     public function pcompanies($code){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if($code==0){
            $mdata=$this->Menu_model->get_pbdtcom($uid);
        }else{
            $mdata=$this->Menu_model->get_pbdcombystatus($uid,$code);
        }
        if(!empty($user)){
            $this->load->view($dep_name.'/CreatedCompanies',['user'=>$user,'mdata'=>$mdata,'code'=>$code,'uid'=>$uid]);
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
        echo '<option value="">Select Comapny</option>';
        foreach($cmp as $cmp){
             echo  $data = '<option value='.$cmp->inid.'>'.$cmp->compname.'</option>';
        }
    }

    public function getcmpbypstassign(){
        $uid= $this->input->post('uid');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_cmpbypstassign($uid);
        echo '<option value="">Select Comapny</option>';
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
        echo '<option value="">Select Comapny</option>';
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
        echo '<option value="">Select Comapny</option>';
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
        echo '<option value="">Select Comapny</option>';
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
        echo '<option value="">Select Comapny</option>';
        foreach($cmp as $cmp){
             echo  $data = '<option value='.$cmp->inid.'>'.$cmp->compname.'</option>';
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
        $stid = $this->input->post('stid');
        $bdid = $this->input->post('bdid');
        $fdate = $this->input->post('fdate');
        $this->load->model('Menu_model');
        $cmp=$this->Menu_model->get_cmpdbybd($stid,$bdid,$fdate);
        echo '<option value="">Select Company</option>';
        foreach($cmp as $dt){
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
        redirect('Menu/TaskPlanner/'.$pdate);
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
        $this->load->model('Menu_model');
        $id=$this->Menu_model->submit_company($uid,$compname, $website, $country, $city, $state, $draft, $address, $ctype, $budget, $compconname, $emailid, $phoneno, $draftop, $designation, $top_spender,$upsell_client,$focus_funnel,$key_company,$potential_company);
        redirect('Menu/Dashboard');
    }
    
    public function addbmcompany(){
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
        $this->load->model('Menu_model');
        $id=$this->Menu_model->submit_bmcompany($uid,$compname, $website, $country, $city, $state, $draft, $address, $ctype, $budget, $compconname, $emailid, $phoneno, $draftop, $designation, $top_spender,$upsell_client,$focus_funnel,$cid,$ccid,$inid,$tid,$bmid);
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
        $apst = $init[0]->apst;
        $tblc=$this->Menu_model->get_tblcalleventsbyid($ciid);
        $tbllast=$this->Menu_model->get_tblcalleventsbyid($ciid);
        $aid = $tbllast[0]->actiontype_id;
        $cstatus=$this->Menu_model->get_statusbyid($sid);
        $action=$this->Menu_model->get_actionbyid($aid);
        
        if(!empty($user)){
            $this->load->view($dep_name.'/CompanyDetails.php',['pccd'=>$pccd,'ciid'=>$ciid,'tid'=>$tid,'uid'=>$uid,'user'=>$user,'cd'=>$cd,'ccd'=>$ccd,'init'=>$init,'tblc'=>$tblc,'status'=>$status,'tbllast'=>$tbllast,'status'=>$status,'action'=>$action,'tbllast'=>$tbllast,'cstatus'=>$cstatus,'sid'=>$sid,'mainbd'=>$mainbd,'apst'=>$apst]);
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
            $this->load->view($dep_name.'/BDFunnel',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata]);
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
        $location = $_POST['location_n']; 
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

    // Edit Bd request
    public function updatebdrequest(){
        $data = [
            'remark' => $_POST['remark'],
            'idetype' => $_POST['idetype'],
            'schooltype' => $_POST['tyschool'],
            'sletter' => $_POST['sletter'],
            'dmletter' => $_POST['dmletter'],
            'svalidation' => $_POST['svalidation'],
            'is_rejected'   => 0,
            'reject_remark' => ""
        ];
        $db3 = $this->load->database('db3', TRUE);
        $db3->where('id',$_POST['bdid']);
        $db3->update('bdrequest',$data);
        // echo $db3->last_query(); exit;
        $tid = $_POST['bdid'];
        
        $msg = $request_type." Task Updated";
        $remark =$_POST['remark'];
        $query=$db3->query("INSERT INTO bdrequestlog(tid,tby,remark,detail) VALUES ('$tid','','$remark','$msg')");
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
        $this->load->view($dep_name.'/AssignTask',['user'=>$user,'uid'=>$uid,'role' => $role]);
    }


    //Select user according to role
    public function getRoleUser(){
        $selectedOption= $this->input->post('selectedOption');
        $adminid = $this->input->post('adminid');
        
        $user = $this->db->select('*')->from('user_details')
                        ->where(['type_id'=> $selectedOption, 'status'=>'active','admin_id' => $adminid])
                        ->get()->result();
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
        //             echo $this->db->last_query(); exit;

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
                'updateddate'           =>  $date,
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


    public function bd_rreject(){
        $db3 = $this->load->database('db3', TRUE);
        $id = 0;
        if($_POST['isdeleted'] == 1){
            $id = $_POST['rrid'];
            $data = [
                'is_deleted'   => 1,
                'delete_remark' => $_POST['ccomment']
            ];
        }
        if($_POST['isrejected']){
            $id = $_POST['rejectid'];
            $data = [
                'is_rejected'   => 1,
                'reject_remark' => $_POST['ccomment']
            ];
        }
        $db3->where(['id' => $id]);
		$db3->update('bdrequest', $data);
        redirect('Menu/Dashboard');
    }

    public function editBdrequest($id){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $client=$this->Menu_model->get_client();
        $fannal=$this->Menu_model->get_fannal($uid);
        $db3 = $this->load->database('db3', TRUE);
        $bddetails = $db3->select("*")->from("bdrequest")
                            ->where('id',$id)->get()->row();
        $company = $this->db->select('*')->from('company_master')->where('id',$bddetails->cid)->get()->row();
        // echo $this->db->last_query(); exit;
        // echo $db3->last_query(); exit;
        if(!empty($user)){
            $this->load->view($dep_name.'/updaterequest',['user'=>$user,'uid'=>$uid,'bddetails'=>$bddetails,'client'=>$client,'fannal'=>$fannal,'company'=>$company]);
        }else{
            redirect('Menu/main');
        }
    }
    
}