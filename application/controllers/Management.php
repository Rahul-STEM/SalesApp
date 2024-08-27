<?php
date_default_timezone_set("Asia/Calcutta");
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Menu.php');
class Management extends Menu {

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

        $this->user = $this->session->userdata('user');
        $this->uid = $this->user['user_id'];
        $this->uyid =  $this->user['type_id'];

        $this->dt = $this->Menu_model->get_utype($this->uyid);

        $this->dep_name = $this->dt[0]->name;
   
        if (in_array(!$this->uyid, [15, 13, 2, 4])) {
            echo "Stem Learning Pvt Ltd..!!!";
            echo "<br/>";
            exit;
        }
        
    }

    public function Manage() {

        if(!empty($this->user)){
            $this->load->view($this->dep_name.'/Manage',['uid'=>$this->uid,'user'=>$this->user]);
        }else{
            redirect('Menu/main');
        }
    }

    public function CheckingDayManagement(){

        $cdate = date("Y-m-d");
        $sdate = new DateTime($cdate);
        $sdate->modify('-1 day');
        $previousDate = $sdate->format('Y-m-d');

        $dayData = $this->Management_model->CheckingDayManage($this->uid,$cdate);
        
        if(!empty($this->user)){
            $this->load->view($this->dep_name.'/CheckingDayManagement',['uid'=>$this->uid,'user'=>$this->user,'dayData'=>$dayData,'cdate'=>$cdate,'previousDate'=>$previousDate]);
        }else{
            redirect('Menu/main');
        }
    }
  
    public function CheckingDayManagementNew(){

        $cdate = date("Y-m-d");
        $sdate = new DateTime($cdate);
        $sdate->modify('-1 day');
        $previousDate = $sdate->format('Y-m-d');

        $dayData = $this->Management_model->CheckingDayManage($this->uid,$cdate);
        
        if(!empty($this->user)){
            $this->load->view($this->dep_name.'/CheckingDayManagementNew',['uid'=>$this->uid,'user'=>$this->user,'dayData'=>$dayData,'cdate'=>$cdate,'previousDate'=>$previousDate]);
        }else{
            redirect('Menu/main');
        }
    }



    public function CheckingYesterDayTask($type,$userid,$sdate){
        
        $sdate = new DateTime($sdate);
        $sdate->modify('-1 day');
        $previousDate = $sdate->format('Y-m-d');

        $dayData = $this->Management_model->CheckingTotalYestTask($userid,$previousDate,$type);
        
       $cdate = date("Y-m-d");
        if(!empty($this->user)){
            $this->load->view($this->dep_name.'/CheckingYesterTask',['uid'=>$this->uid,'user'=>$this->user,'dayData'=>$dayData,'cdate'=>$cdate,'previousDate'=>$previousDate]);
        }else{
            redirect('Menu/main');
        }
    }


    public function checkdayswithStar(){
        $periods = $_POST['periods'];
        $suser_id = $_POST['udid'];
        $cdate = $_POST['cdate'];
        $previousDate = $_POST['previousDate'];

        $rat1 = $_POST['rat1'];
        $rat2 = $_POST['rat2'];
        $rat3 = $_POST['rat3'];
        $rat4 = $_POST['rat4'];
       
        $que = $_POST['que'];
        $remarks = $_POST['sremark'];
        
        if($periods == 'Mornings'){
            $rat5 = $_POST['rat5'];
            $rat6 = $_POST['rat6'];
            $star = [$rat1,$rat2,$rat3,$rat4,$rat5,$rat6];
            $i=0;
            foreach($que as $q){
                $this->Management_model->AddStarRating($cdate,$suser_id,$periods,$q,$star[$i],$remarks,$this->uid);
                $i++;
            }
        }

        if($periods == 'Yesterday Evening' || $periods == 'Yesterday Task'){
            $star = [$rat1,$rat2,$rat3,$rat4];
            $i=0;
            foreach($que as $q){
                $this->Management_model->AddStarRating($previousDate,$suser_id,$periods,$q,$star[$i],$remarks,$this->uid);
                $i++;
            }
        }

        $this->session->set_flashdata('success_message', 'Star Rating Added Successfully');
        redirect('Management/CheckingDayManagement');
    }


    // New Daymanagement changes <======== START =======>
    public function CheckingDayManagement_New(){

        $cdate = date("Y-m-d");
        $sdate = new DateTime($cdate);
        $sdate->modify('-1 day');
        $previousDate = $sdate->format('Y-m-d');
        $cdate = '2024-07-20';
        $dayData = $this->Management_model->CheckingDayManage($this->uid,$cdate);
        // var_dump($dayData);die;
        if(!empty($this->user)){
            $this->load->view($this->dep_name.'/CheckingDayManagement_New',['uid'=>$this->uid,'user'=>$this->user,'dayData'=>$dayData,'cdate'=>$cdate,'previousDate'=>$previousDate]);
        }else{
            redirect('Menu/main');
        }
    }

    public function checkdayswithStarNew(){
        
        // var_dump($_POST);die;
        $cdate = $_POST['cdate'];
        $sdate = new DateTime($cdate);
        $sdate->modify('-1 day');
        $previousDate = $sdate->format('Y-m-d');

        $periods = $_POST['period'];
        $userId = $_POST['userId'];
        $rating = $_POST['rating'];
        $question = $_POST['question'];

        if($periods == 'Yesterday Evening' || $periods == 'Yesterday Task'){

            $date = $previousDate;

        }else{
            $date = $cdate;
        }
        $data = [
            'date' => $date,
            'user_id' => $userId,
            'periods' => $periods,
            'question' => $question,
            'star'=>$rating,
            // 'previousDate'=>$previousDate,
            'feedback_by'=>$this->uid,
        ];

        $result = $this->Management_model->AddStarRatingNew($data);
        // var_dump($result);die;
        echo json_encode($result);

        // $this->session->set_flashdata('success_message', 'Star Rating Added Successfully');
        // redirect('Management/CheckingDayManagement');
    }

    public function updateStarRemark() {
        // var_dump($_POST);die;
        $remark = $_POST['remark'];
        $starID = $_POST['starID'];

        $result = $this->Management_model->updateStarRemark($remark,$starID);
    }
    

    // New Daymanagement changes <======== END =======>


    // MOM Start Here

    public function MoMApprovedStatus(){

        if(isset($_POST['sdate'])){
            $cdate = $_POST['sdate'];
           
        }else{
            $cdate = date("Y-m-d");
        }
        if(isset($_POST['edate'])){
            $edate = $_POST['edate'];
        }else{
            $edate = date("Y-m-d");
        }

        $sdate = new DateTime($cdate);
        $sdate->modify('-1 day');

        $previousDate = $sdate->format('Y-m-d');
    
        if(!empty($this->user)){
                $this->load->view($this->dep_name.'/MoMApprovedStatus',['uid'=>$this->uid,'user'=>$this->user,'cdate'=>$cdate,'edate'=>$edate,'previousDate'=>$previousDate]);
            }else{
                redirect('Menu/main');
            }
    }

    public function MomData($suid,$tdate){

        $cdate = date("Y-m-d");
        $sdate = new DateTime($cdate);
        $sdate->modify('-1 day');
        $previousDate = $sdate->format('Y-m-d');
        $momdata = $this->Management_model->getBDMoMData($suid,$tdate);

        if(!empty($this->user)){
                $this->load->view($this->dep_name.'/MomData',['uid'=>$this->uid,'user'=>$this->user,'cdate'=>$cdate,'previousDate'=>$previousDate,'suid'=>$suid,'momdata'=>$momdata,'tardate'=>$tdate]);
            }else{
                redirect('Menu/main');
            }
    }
    public function TotalMomData($suid,$tdate){

        $cdate = date("Y-m-d");
        $sdate = new DateTime($cdate);
        $sdate->modify('-1 day');
        $previousDate = $sdate->format('Y-m-d');
        $momdata = $this->Management_model->getBDMoMData($suid,$tdate);

        if(!empty($this->user)){
                $this->load->view($this->dep_name.'/TotalMomData',['uid'=>$this->uid,'user'=>$this->user,'cdate'=>$cdate,'previousDate'=>$previousDate,'suid'=>$suid,'momdata'=>$momdata,'tardate'=>$tdate]);
            }else{
                redirect('Menu/main');
            }
    }
    public function TotalApproveMomData($suid,$tdate){

        $cdate = date("Y-m-d");
        $sdate = new DateTime($cdate);
        $sdate->modify('-1 day');
        $previousDate = $sdate->format('Y-m-d');
        $momdata = $this->Management_model->getBDMoMData($suid,$tdate);

        if(!empty($this->user)){
                $this->load->view($this->dep_name.'/TotalApproveMomData',['uid'=>$this->uid,'user'=>$this->user,'cdate'=>$cdate,'previousDate'=>$previousDate,'suid'=>$suid,'momdata'=>$momdata,'tardate'=>$tdate]);
            }else{
                redirect('Menu/main');
            }
    }


    public function MomDataReject($suid,$tdate){

        $cdate = date("Y-m-d");
        $sdate = new DateTime($cdate);
        $sdate->modify('-1 day');
        $previousDate = $sdate->format('Y-m-d');
        $momdata = $this->Management_model->getBDMoMData($suid,$tdate);

        if(!empty($this->user)){
                $this->load->view($this->dep_name.'/MomDataReject',['uid'=>$this->uid,'user'=>$this->user,'cdate'=>$cdate,'previousDate'=>$previousDate,'suid'=>$suid,'momdata'=>$momdata,'tardate'=>$tdate]);
            }else{
                redirect('Menu/main');
            }
    }

    public function MomDataDisplay($suid,$tdate,$t_id){

        $cdate = date("Y-m-d");
        $sdate = new DateTime($cdate);
        $sdate->modify('-1 day');
        $previousDate = $sdate->format('Y-m-d');
        $momdata = $this->Management_model->getBDMoMDataWthTid($suid,$t_id);
        // echo $str = $this->db->last_query(); 

        if(!empty($this->user)){
                $this->load->view($this->dep_name.'/MomDataDisplay',['uid'=>$this->uid,'user'=>$this->user,'cdate'=>$cdate,'previousDate'=>$previousDate,'momdata'=>$momdata,'t_id'=>$t_id,'tdate'=>$tdate]);
            }else{
                redirect('Menu/main');
            }
    }

    public function MomRejectByUserAdmin(){

        $rejectId = $_POST['reject'];
        $rejectreamrk = $_POST['rejectreamrk'];
       
        $rejectDate = date("y-m-d H:i:s");
        $approved_status = 'Reject';

        $suid = $_POST['suid'];
        $tardate = $_POST['tardate'];

        $momdata = $this->Management_model->MomRejectByUserAdminInsert($approved_status,$rejectId,$rejectreamrk,$rejectDate,$this->uid);
      
        redirect('Management/MomData/'.$suid.'/'.$tardate);
      
    }

    // public function MomApprovedByUserAdmin($id,$status,$suid,$tardate){
    public function MomApprovedByUserAdmin(){

        $id = $_POST['mom_id'];
        $suid = $_POST['suid'];
        $tardate = $_POST['tardate'];
        $right_remarks = $_POST['right_remarks'];
        $mom_yes_no = $_POST['mom_yes_no'];

        $finalRemarks = $right_remarks.' - '.$mom_yes_no;
       
        $approvedtDate = date("y-m-d H:i:s");
        $approved_status = 'Approved';
        $approvedreamrk = $finalRemarks;

        $momdata = $this->Management_model->getMomByID($id);
        $init_cmpid = $momdata[0]->init_cmpid;
        $tid_calleve = $momdata[0]->tid;
        $ccstatus = $momdata[0]->ccstatus;
        $mom_user_id = $momdata[0]->user_id;

        $fwd_date = '';
        // $fwd_date = date("Y-m-d h:i:s");
        $actiontype_id = 1;
        $init_id = $init_cmpid;
        $nextaction = 1;
        $ass_user_id = $this->uid;
        $purpose_id = 1;
        $autotask = 1;
        $auto_plan = 1;

        // dd($_POST);
        // die;

        $this->Management_model->MomApprovedByUserAdminInsert($approved_status,$id,$approvedreamrk,$approvedtDate,$this->uid,$finalRemarks);

        $task_remarks = "Task Create After MOM Approved";

        $insert_id = $this->Management_model->CreateTask($fwd_date,$actiontype_id,$init_id,$nextaction,$ass_user_id,$purpose_id,$autotask,$auto_plan,$ccstatus,$task_remarks);
       
        $this->Management_model->CreateTaskForAutoAssign($ass_user_id,$ass_user_id,$ccstatus,$init_id,$insert_id,$actiontype_id,$id,$task_remarks);
      
        $cudetail = $this->Menu_model->get_userbyid($mom_user_id);
        $get_pst_co = $cudetail[0]->pst_co;
        $clm_aadmin = $cudetail[0]->aadmin;
        
        $this->Management_model->AssignPSTAfterMomApproved($init_cmpid,$get_pst_co);
        $this->Management_model->AssignCLMAfterMomApproved($init_cmpid,$clm_aadmin);

        $insert_id = $this->Management_model->CreateTask($fwd_date,$actiontype_id,$init_id,$nextaction,$get_pst_co,$purpose_id,$autotask,$auto_plan,$ccstatus,$task_remarks);
        $this->Management_model->CreateTaskForAutoAssign($ass_user_id,$get_pst_co,$ccstatus,$init_id,$insert_id,$actiontype_id,$id,$task_remarks);

        redirect('Management/MomData/'.$suid.'/'.$tardate);

    }



    public function MomApprovedAndPSTAssign(){
        
        // PST Assign After 48 Hours 
        $approvedtDate = date("y-m-d H:i:s");
        $cur_user = $this->uid;

        // $momdata = $this->Management_model->AssignPSTAfterMomApproved();
        $momdata = $this->Management_model->getApprovedMom_notAssignPST();
        foreach($momdata as $mdata){

            $mom_user_id = $mdata->user_id;
            $init_cmpid = $mdata->init_cmpid;
            $tid_calleve = $mdata->tid;

            $cudetail = $this->Menu_model->get_userbyid($mom_user_id);
            $get_pst_co = $cudetail[0]->pst_co;

            // $get_cmp = $this->Menu_model->get_cmpbyinid($init_cmpid);
            // $this->Management_model->AssignPSTAfterMomApprTwoHours($get_pst_co,$init_cmpid);

        }

        die;
       

    }


    public function MomEditByUser($stid,$page_status,$suid,$tardate){

        $momdata = $this->Management_model->getBDMoMDataWthTid($suid,$stid);
     
        if(!empty($this->user)){
                $this->load->view($this->dep_name.'/MomEditByUser',['uid'=>$this->uid,'user'=>$this->user,'stid'=>$stid,'page_status'=>$page_status,'momdata'=>$momdata,'tardate'=>$tardate,'suid'=>$suid]);
            }else{
                redirect('Menu/main');
            }

    }
    public function UpdateEditMomData(){

    $tbl_id = $this->input->post('id');
    $tardate = $this->input->post('tardate');
    $user_id = $this->input->post('user_id');
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
         'ccstatus' => $this->input->post('ccstatus'),
         'action_id' => $this->input->post('action_id'),
         'user_id' => $this->input->post('user_id'),
         'init_cmpid' => $this->input->post('init_cmpid'),
         'tid' => $this->input->post('tid'),
         'actontaken' => $this->input->post('actontaken'),
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

    // Pass data to model to insert into the database
    $this->db->insert('mom_data', $data);
    $insert_id = $this->db->insert_id();
    // echo $this->db->last_query();;
    $query =  $this->db->query("UPDATE `mom_data` SET `edit_cnt`='$insert_id' WHERE id = $tbl_id");

    redirect('Management/MomData/'.$user_id.'/'.$tardate);

    }


// MOM END HERE


// Special Restrication on Task Planner in Admin
public function SpecialRestrictionOnTaskPlanner(){

    if(!empty($this->user)){
            $this->load->view($this->dep_name.'/SpecialRestrictionOnTaskPlanner',['uid'=>$this->uid,'user'=>$this->user]);
        }else{
            redirect('Menu/main');
        }

}
public function AddTaskPlannerRestrication(){

    $action_id  = $_POST['action']; 
    $user_type  = $_POST['user_type']; 
    $user_ids     = $_POST['user_id'];

    $company_status  = $_POST['company_status']; 
    $partner_type  = $_POST['partner_type']; 
    $category  = $_POST['category']; 
   

    $sdate      = $_POST['sdate'];
    $edate      = $_POST['edate'];
    $status     = $_POST['status'];


    // Start combine action_id 
    if($action_id[0] !=='all'){
        $action_ids = '';
        foreach($action_id as $adata){
            $action_ids .=$adata.',';
        }
        $action_ids = rtrim($action_ids, ',');
    }else{
        $action_ids =  $action_id[0];
    }
     // End combine action_id 

    // Start combine user_type 
    if($user_type[0] !=='all'){
        $user_types = '';
        foreach($user_type as $auser_type){
            $user_types .=$auser_type.',';
        }
        $user_types = rtrim($user_types, ',');
    }else{
        $user_types =  $user_type[0];
    }
    // End combine user_type 

    // Start combine company_status 
    if($company_status[0] !=='all'){
        $company_statuss = '';
        foreach($company_status as $acompany_status){
            $company_statuss .=$acompany_status.',';
        }
        $company_statuss = rtrim($company_statuss, ',');
    }else{
        $company_statuss =  $company_status[0];
    }
    // End combine company_status 

    // Start combine partner_types 
    if($partner_type[0] !=='all'){
        $partner_types = '';
        foreach($partner_type as $apartner_type){
            $partner_types .=$apartner_type.',';
        }
        $partner_types = rtrim($partner_types, ',');
    }else{
        $partner_types =  $partner_type[0];
    }
    // End combine partner_types 

     // Start combine categorys 
     if($category[0] !=='all'){
        $categorys = '';
        foreach($category as $acategory){
            $categorys .=$acategory.',';
        }
        $categorys = rtrim($categorys, ',');
    }else{
        $categorys =  $category[0];
    }
    // End combine categorys 

    // Start combine user_id 
        $user_id = '';
        foreach($user_ids as $u_id){
            $user_id .=$u_id.',';
        }
        $user_id = rtrim($user_id, ',');
    // end combine user_id 


    if(!isset($user_ids)){
        $user_id = '';
    }
    if(!isset($company_status)){
        $company_statuss = '';
    }
    if(!isset($partner_type)){
        $partner_types = '';
    }
    if(!isset($category)){
        $categorys = '';
    }
   

    $this->Management_model->AddTaskPlannerRestricationInTable($action_ids,$user_types,$sdate,$edate,$status,$company_statuss,$partner_types,$categorys,$user_id);
    $this->session->set_flashdata('success_message', 'Restrication Add Successfully !');

    redirect('Management/SpecialRestrictionOnTaskPlanner');
}
public function ChangeStatusofRestrication(){
    
    $res_id             = $_POST['res_id'];
    $active_diactive    = $_POST['active_diactive'];
    $start_date         = $_POST['start_date'];
    $end_date           = $_POST['end_date'];

    $this->Management_model->ChangeTaskPlannerRestricationStatus($res_id,$active_diactive,$start_date,$end_date);
    $this->session->set_flashdata('success_message', 'Restrication Update Successfully !');

    redirect('Management/SpecialRestrictionOnTaskPlanner');
}



public function SpecialRestricationonDelete($id){
   
    $this->Management_model->DeleteSpecialRestrication($id);
    $this->session->set_flashdata('success_message', 'Restrication Delete Successfully !');

    redirect('Management/SpecialRestrictionOnTaskPlanner');
}



public function getAllActiveUserInDepartment(){

    $user_type_id = $_POST['user_type_id'];

    $user_type_ids = implode(", ", $user_type_id);

       $query = $this->db->query("SELECT * FROM `user_details` WHERE status = 'Active' AND type_id IN ($user_type_ids) order by user_id");
        
       $selectusers = $query->result();
         $data = '';
          foreach($selectusers as $user){
            $data .= '<option value='.$user->user_id.'>'.$user->name.'</option>';
            }
             echo $data;
 }

 public function Change_RP_To_No_RP(){

    $mom_id= $this->input->post('mom_id');
    $tid= $this->input->post('tid');
    
    $this->Menu_model->change_norp($tid);

    $return = $this->Management_model->UpdateMOM_DataTo_NORP($mom_id,$this->uid,$tid);
    echo $return;

}



}
