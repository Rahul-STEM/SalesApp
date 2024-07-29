
<?php
date_default_timezone_set("Asia/Calcutta");
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Menu_model.php');
class Management_model  extends Menu_model {

    public function __construct() {
        parent::__construct();
        // Load database or other necessary operations
        $db2 = $this->load->database('db2', TRUE);
        $db3 = $this->load->database('db3', TRUE);
    }


    public function CheckingDayManage($uid,$cdate){

        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype ==15){
            $query=$this->db->query("SELECT user_details.user_id, user_details.name,user_day.* FROM `user_day` LEFT JOIN user_details on user_details.user_id = user_day.user_id WHERE user_details.sales_co = $uid and cast(sdatet as DATE)='$cdate'");
        }
        if($utype ==13){
            $query=$this->db->query("SELECT user_details.user_id, user_details.name,user_day.* FROM `user_day` LEFT JOIN user_details on user_details.user_id = user_day.user_id WHERE user_details.aadmin = $uid and cast(sdatet as DATE)='$cdate'");
        }
        if($utype ==2){
            $query=$this->db->query("SELECT user_details.user_id, user_details.name,user_day.* FROM `user_day` LEFT JOIN user_details on user_details.user_id = user_day.user_id WHERE user_details.admin_id = $uid and cast(sdatet as DATE)='$cdate'");
        }
        if($utype ==4){
            $query=$this->db->query("SELECT user_details.user_id, user_details.name,user_day.* FROM `user_day` LEFT JOIN user_details on user_details.user_id = user_day.user_id WHERE user_details.pst_co = $uid and cast(sdatet as DATE)='$cdate'");
        }

        return $query->result();
       
    }

    public function CheckingYesterDayTaskStatus($uid){
        $date = new DateTime();
        $date->modify('-1 day');
        $pdate =  $date->format('Y-m-d');
        $query=$this->db->query("SELECT COUNT(*) AS plan, COUNT(CASE WHEN autotask = 1 THEN autotask END) AS autotask, COUNT(CASE WHEN nextCFID != 0 THEN 1 END) AS done, COUNT(CASE WHEN nextCFID = 0 AND lastCFID = 0 THEN 1 END) AS pending FROM tblcallevents WHERE assignedto_id = $uid AND CAST(appointmentdatetime AS DATE) = '$pdate'");

        return $query->result();
       
    }

    public function CheckingTotalYestTask($uid,$sdate,$type){
        if($type == 'total'){
            $query=$this->db->query("SELECT * FROM `tblcallevents` WHERE assignedto_id = $uid and cast(appointmentdatetime as DATE)='$sdate'");
        }
        if($type == 'Pending'){
            $query=$this->db->query("SELECT * FROM `tblcallevents` WHERE nextCFID =0 AND assignedto_id = $uid and cast(appointmentdatetime as DATE)='$sdate'");
        }
        if($type == 'autotask'){
            $query=$this->db->query("SELECT * FROM `tblcallevents` WHERE autotask =1 AND assignedto_id = $uid and cast(appointmentdatetime as DATE)='$sdate'");
        }
        if($type == 'done'){
            $query=$this->db->query("SELECT * FROM `tblcallevents` WHERE nextCFID != 0 AND assignedto_id = $uid and cast(appointmentdatetime as DATE)='$sdate'");
        }
        // echo $str = $this->db->last_query(); 
        return $query->result();
    }


    public function CheckAutoTaskTime($uid,$date) {
        $query=$this->db->query("SELECT * FROM `autotask_time` WHERE user_id = $uid AND date = '$date'");
        return $query->result();
    }

    public function CheckTaskPlanRequest($uid,$date) {
        $query=$this->db->query("SELECT * FROM `task_plan_for_today` WHERE user_id =$uid AND date ='$date'");
        return $query->result();
    }

    public function CheckingYesterDayConsumeTime($uid,$date) {
        $query=$this->db->query("SELECT * FROM `user_day` WHERE user_id = $uid and cast(sdatet as DATE)='$date'");
        return $query->result();
    }

    public function CheckStarRatingsExistorNot($uid,$date) {
        $query=$this->db->query("SELECT * FROM `star_rating` WHERE user_id = $uid AND date ='$date'");
        return $query->result();
    }


    public function CheckEveningStarRatingsExistorNot($uid,$date) {
        $query=$this->db->query("SELECT * FROM `star_rating` WHERE user_id = $uid AND (date ='$date' AND periods='Yesterday Evening')");
        return $query->result();
    }

    public function CheckYestTaskStarRatingsExistorNot($uid,$date) {
        $query=$this->db->query("SELECT * FROM `star_rating` WHERE user_id = $uid AND (date ='$date' AND periods='Yesterday Task')");
        return $query->result();
        // echo $str = $this->db->last_query(); 
    }


    public function getStarRatingRemarks($uid,$date) {
        $query=$this->db->query("SELECT * FROM `star_rating` WHERE user_id = $uid AND date ='$date'");
        return $query->result();
    }

    public function AddStarRating($sdate,$suser_id,$periods,$question,$star,$remarks,$feedback_by){
        $data = [
            'date' => $sdate,
            'user_id' => $suser_id,
            'periods' => $periods,
            'question' => $question,
            'star'=>$star,
            'remarks'=>$remarks,
            'feedback_by'=>$feedback_by,
        ];
        $this->db->insert('star_rating',$data);
    }



    // mom Start here
    // SELECT * FROM `mom_data` WHERE approved_status 
    public function SubmitBDMoMDataCount($uid,$date) {
        $query=$this->db->query("SELECT user_details.name,mom_data.* FROM `mom_data`LEFT JOIN `user_details` ON user_details.user_id = mom_data.user_id WHERE user_details.aadmin = $uid AND user_details.type_id = 3 and cast(cdate AS DATE)='$date' order by id DESC");
        
        return $query->result();
    }

    

    public function getBDMoMData($suid,$tdate) {
        $query=$this->db->query("SELECT * FROM `mom_data` WHERE user_id  = $suid and cast(cdate AS DATE)='$tdate' order by id DESC");
        return $query->result();
    }



    public function getAllPendngBDMoMData($suid,$tdate) {
        $query=$this->db->query("SELECT * FROM `mom_data` WHERE user_id  = $suid and approved_status IS NULL");
        return $query->result();
    }
    public function getAllRejectBDMoMData($suid,$tdate) {
        $query=$this->db->query("SELECT * FROM `mom_data` WHERE user_id  = $suid and approved_status='Reject'");
        return $query->result();
    }

    public function getBDMoMDataWthTid($suid,$tid) {
        $query=$this->db->query("SELECT * FROM `mom_data` WHERE user_id  = $suid and id=$tid");
        return $query->result();
    }

    public function get_BDMoM_TBL_Call_Data($id) {
        $query=$this->db->query("SELECT * FROM `tblcallevents` WHERE id = $id");
        return $query->result();
    }

    public function SubmitBDMoMData($uid,$date) {
        $query=$this->db->query("SELECT * FROM `mom_data` WHERE user_id = $uid AND cast(cdate AS DATE)='$date' order by id DESC");
        // echo $str = $this->db->last_query(); 
        return $query->result();
    }

    public function SubmitPendingBDMoMData($uid) {
        $query=$this->db->query("SELECT * FROM `mom_data` WHERE user_id = $uid AND approved_status IS NULL");
        // echo $str = $this->db->last_query(); 
        return $query->result();
    }


    public function GetSubmitBDMoMData($uid,$date) {
        $query=$this->db->query("SELECT * FROM `mom_data` WHERE user_id = $uid and approved_status is NULL");
        // echo $str = $this->db->last_query(); 
        return $query->result();
    }

    public function GetTotalSubmitBDMoMData($uid,$date) {
        $query=$this->db->query("SELECT * FROM `mom_data` WHERE user_id = $uid");
        // echo $str = $this->db->last_query(); 
        return $query->result();
    }
    public function GetSubmitRejectBDMoMData($uid,$date) {
        $query=$this->db->query("SELECT * FROM `mom_data` WHERE user_id = $uid and approved_status='Reject'");
        // echo $str = $this->db->last_query(); 
        return $query->result();
    }
    public function GetApprovedSubmitBDMoMData($uid,$date) {
        $query=$this->db->query("SELECT * FROM `mom_data` WHERE user_id = $uid and approved_status='Approved'");
        // echo $str = $this->db->last_query(); 
        return $query->result();
    }


    public function getMomByID($id) {
        $query=$this->db->query("SELECT * FROM `mom_data` WHERE id = $id");
        return $query->result();
    }

    public function MomRejectByUserAdminInsert($approved_status,$rejectId,$rejectreamrk,$rejectDate,$uaid) {
        $query =  $this->db->query("UPDATE `mom_data` SET `approved_status`='$approved_status',`approved_by`='$uaid',`approved_date`='$rejectDate',`reject_remarks`='$rejectreamrk' WHERE id = $rejectId");
    }
    public function MomApprovedByUserAdminInsert($approved_status,$id,$approvedreamrk,$approvedtDate,$uaid) {
        $query =  $this->db->query("UPDATE `mom_data` SET `approved_status` = '$approved_status', `approved_by` = '$uaid', `cm_call_task` = 1, `pst_assign` = 1, `approved_date` = '$approvedtDate', `reject_remarks` = '$approvedreamrk' WHERE `id` = $id;");
    }
    

    public function AssignPSTAfterMomApproved($init_id,$pst_id) {
        $query =  $this->db->query("UPDATE `init_call` SET `apst`='$pst_id' WHERE id= $init_id");
    }
    public function AssignCLMAfterMomApproved($init_id,$clm_aadmin) {
        $query =  $this->db->query("UPDATE `init_call` SET `clm_id`='$clm_aadmin' WHERE id= $init_id");
    }

    public function getApprovedMom_notAssignPST() {
        $query=$this->db->query("SELECT * FROM `mom_data` WHERE approved_status = 'Approved' and (pst_assign = 0 or pst_assign ='')");
        return $query->result();
    }


    public function CreateTask($fwd_date,$actiontype_id,$init_id,$nextaction,$ass_user_id,$purpose_id,$autotask,$auto_plan,$ccstatus) {
            $data = array(
                'lastCFID' => 0,
                'nextCFID' => 0,
                'purpose_achieved' => 'no',
                'fwd_date' => $fwd_date,
                'actontaken' => 'no',
                'nextaction' => $nextaction,
                'mom_received' => 'no',
                'appointmentdatetime' => $fwd_date,
                'actiontype_id' => $actiontype_id,
                'assignedto_id' => $ass_user_id,
                'cid_id' => $init_id,
                'purpose_id' => $purpose_id,
                'remarks' => '',
                'status_id' => $ccstatus,
                'user_id' => $ass_user_id,
                'date' => $fwd_date,
                'updateddate' => $fwd_date,
                'updation_data_type' => 'updated',
                'plan' => 1,
                'autotask' => $autotask,
                'auto_plan' => $auto_plan
            );

            // Insert the data into the database
            $this->db->insert('tblcallevents', $data);
            $insert_id = $this->db->insert_id();
            return  $insert_id;
    }


    public function CreateTaskForAutoAssign($user_id,$to_user_id,$ccstatus,$init_cmpid,$call_tid,$action_id) {

        $data = array(
            'user_id' => $user_id,
            'to_user_id' => $to_user_id,
            'ccstatus' => $ccstatus,
            'init_cmpid' => $init_cmpid,
            'call_tid' => $call_tid,
            'action_id' => $action_id,
            'status' => '0'
        );

        // Insert the data into the database
        $this->db->insert('auto_assign_task', $data);
}


// MOM END


// Start Insert Other Assign Task
public function OtherAssignTask($task_id,$user_id,$fwd_date,$init_cid,$fwd_user_id,$purpose_id) {
    $data = array(
        'task_id' => $task_id,
        'purpose_id' => $purpose_id,
        'user_id' => $user_id,
        'fwd_date' => $fwd_date,
        'init_cid' => $init_cid,
        'fwd_user_id' => $fwd_user_id,
        'action_date' => ''
    );
    $this->db->insert('other_assign_task', $data);
}
// End Insert Other Assign Task

public function AddTaskPlannerRestricationInTable($action_id,$user_types,$sdate,$edate,$status,$company_statuss,$partner_types,$categorys,$user_id){
 
    $data = array(
        'action_id' => $action_id,
        'user_types' => $user_types,
        'user_ids' => $user_id,
        'company_status' => $company_statuss,
        'partner_types' => $partner_types,
        'categorys' => $categorys,
        'sdate' => $sdate,
        'edate' => $edate,
        'status' => $status
    );
    // Insert the data into the database
    $this->db->insert(' spcl_rest_task_planner', $data);
}


public function GetTaskPlannerRestricationInTable() {
    $query=$this->db->query("SELECT * FROM `spcl_rest_task_planner` order by id DESC");
    return $query->result();
}
public function ChangeTaskPlannerRestricationStatus($res_id,$active_diactive,$start_date,$end_date) {
   $this->db->query("UPDATE `spcl_rest_task_planner` SET `status`='$active_diactive',`sdate`='$start_date',`edate`='$end_date' WHERE id ='$res_id'");
}

public function GetActiveTaskPlannerRestrication12(){
    $query=$this->db->query("SELECT * FROM `spcl_rest_task_planner` where status = 1");
    return $query->result();
}
public function get_partnerById($id){
    $query=$this->db->query("SELECT * FROM `partner_master` WHERE id = $id");
    return $query->result();
}



// Special Restrication on Task Planner
// ---------- Start ------------------

public function SpecialRestricationonTaskPlanner($uyid,$bdid,$tptime,$ptime,$ntaction,$ntppose,$selectby,$pdate,$selectcompanybyuser){
    
    $rstData = $this->Menu_model->GetActiveTaskPlannerRestrication($pdate);

    if(sizeof($rstData) > 0){
     
        foreach ($rstData as $rsData) {
            $conditions = [
                'action_id' => explode(',', $rsData->action_id),
                'user_types' => explode(',', $rsData->user_types),
                'company_status' => explode(',', $rsData->company_status),
                'partner_types' => explode(',', $rsData->partner_types),
                'categorys' => explode(',', $rsData->categorys),
            ];
            
            $rst_sdate = $rsData->sdate;
            $rst_edate = $rsData->edate;

            $allArrays = array_filter($conditions, function ($arr) { return $arr == ['all']; });
           
            if (count($allArrays) == count($conditions)) {
                $this->session->set_flashdata('success_message', 'Admin Add Special Restriction on Task Planner for ' . $rst_sdate . ' to ' . $rst_edate);
                redirect('Menu/TaskPlanner/' . $pdate);
            } else {

                if (array_key_exists('user_types', $allArrays) && array_key_exists('action_id', $allArrays)) {
                
                $this->session->set_flashdata('success_message', 'Admin Add Special Restriction on Task Planner for ' . $rst_sdate . ' to ' . $rst_edate);
                redirect('Menu/TaskPlanner/' . $pdate);

                }
           
            $difference = array_diff_assoc($conditions,$allArrays);
                       
            $difference = array_filter($difference, function($value) {
                return !empty($value[0]);
            });
            
            $rsuser_ids = $rsData->user_ids;
            $user_ids_arr = explode(',', $rsuser_ids);

            if (array_key_exists('user_types', $difference) && array_key_exists('action_id', $difference) && array_key_exists('company_status', $difference) && array_key_exists('partner_types', $difference) && array_key_exists('categorys', $difference) && sizeof($difference) == 5 ) {

                foreach ($difference as $key => $value) {
                    if ($key == 'company_status'){
                        foreach($selectcompanybyuser as $tid){
                            $cmp_Data = $this->getResCompanyStatus($tid);
                            $cmp_Data_cstatus = $cmp_Data[0]->cstatus;
                            $rst_cmpid_id = $cmp_Data[0]->cmpid_id;
                         
                            if (in_array($cmp_Data_cstatus, $value)){
                          
                                $cur_cmp_status = $this->Menu_model->get_statusbyid($cmp_Data_cstatus); 
                                $cur_cmp_status_name = $cur_cmp_status[0]->name;

                                foreach ($difference as $key => $value) {
                                    if ($key == 'partner_types') {

                                        foreach($value as $partnertype){
                                            $cmp_part = $this->Menu_model->get_cmp_partnertype($partnertype,$bdid);
                                            foreach ($cmp_part as $obj) {
                                                if ($obj->inid == $tid) {
                                                    $exists = true;
                                                    break;
                                                }
                                            }
                                            
                                            if ($exists) {
                                                $cmp_prtData = $this->Menu_model->get_partnerById($partnertype); 
                                                $cmp_prt_name = $cmp_prtData[0]->name;
                                                
                                                foreach ($difference as $key => $value) {

                                                    if ($key == 'categorys') {

                                                        foreach($value as $rst_cate){

                                                            if($rst_cate == 'topspender'){$catename = 'Top Spender';}
                                                            if($rst_cate == 'upsell_client'){$catename = 'Upsell Client';}
                                                            if($rst_cate == 'focus_funnel'){$catename = 'Focus Funnel';}
                                                            if($rst_cate == 'keycompany'){$catename = 'Key Company';}
                                                            if($rst_cate == 'pkclient'){$catename = 'Positive Key Client';}
                            
                                                            $get_db_cat = $this->Menu_model->get_comCategorys($rst_cate,$tid);
                                                            
                                                            if(sizeof($get_db_cat) !== 0){
                                                               
                                                                foreach ($difference as $key => $value) {
                                                                    if ($key == 'action_id' && !in_array($ntaction, $value)) {
                                    
                                                                        $ntactionname = $this->Menu_model->get_actionbyid($ntaction);
                                                                        $ntactionname = $ntactionname[0]->name;
                    
                                                                        $flash_message = $get_utypename.' | '.$cur_cmp_status_name.' | '.$cmp_prt_name.' | '.$catename.' | '.$ntactionname;
                                                                        
                                                                        if($rsuser_ids !== ''){
                                                                            if (in_array($bdid, $user_ids_arr)) {
                                                                               
                                                                                $this->session->set_flashdata('success_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                                redirect('Menu/TaskPlanner2/'.$pdate);
                                                                            }
                                                                        }else{
                                                                            $this->session->set_flashdata('success_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                                                            redirect('Menu/TaskPlanner2/'.$pdate);
                                                                        }
                                                                    }
                                                                 }
                                                            }else{

                                                                $flash_message = $get_utypename.' | '.$cur_cmp_status_name.' | '.$catename;
                                                                        
                                                                if($rsuser_ids !== ''){
                                                                    if (in_array($bdid, $user_ids_arr)) {
                                            
                                                                        $this->session->set_flashdata('success_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                        redirect('Menu/TaskPlanner2/'.$pdate);
                                                                    }
                                                                }else{
                                                                    $this->session->set_flashdata('success_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                                                    redirect('Menu/TaskPlanner2/'.$pdate);
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                            }else{
                                                $cmp_prtData = $this->Menu_model->get_partnerById($partnertype); 
                                                $cmp_prt_name = $cmp_prtData[0]->name;
                                                $flash_message = $get_utypename.' | '.$cur_cmp_status_name.' | '.$cmp_prt_name;

                                                if($rsuser_ids !== ''){
                                                    if (in_array($bdid, $user_ids_arr)) {
                                                        
                                                        $this->session->set_flashdata('success_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                        redirect('Menu/TaskPlanner2/'.$pdate);
                                                    }
                                                }else{
                                                    $this->session->set_flashdata('success_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                                    redirect('Menu/TaskPlanner2/'.$pdate);
                                                }

                                            }
                                        } 
                                    }
                                }  
                            }else{
                                $cur_cmp_status = $this->Menu_model->get_statusbyid($cmp_Data_cstatus); 
                                $cur_cmp_status_name = $cur_cmp_status[0]->name;
                                $flash_message = $get_utypename.' |  '.$cur_cmp_status_name;
                                if($rsuser_ids !== ''){
                                    if (in_array($bdid, $user_ids_arr)) {
                                        $flash_message = 'Company Status - '.$cur_cmp_status_name;
                                        $this->session->set_flashdata('success_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                        redirect('Menu/TaskPlanner2/'.$pdate);
                                    }
                                }else{
                                    $this->session->set_flashdata('success_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                    redirect('Menu/TaskPlanner2/'.$pdate);
                                }
                            }
                        }
                    }
                }


                }
              
// Start Check Restrction when admin add - user_types, action_id, company_status, partner_types, categorys

// Start Check Restrction when admin add - user_types, action_id, company_status, partner_types

                if (array_key_exists('user_types', $difference) && array_key_exists('action_id', $difference) && array_key_exists('company_status', $difference) && array_key_exists('partner_types', $difference) && sizeof($difference) == 4) {
                
                    foreach ($difference as $key => $value) {
                        if ($key == 'user_types' && in_array($uyid, $value)) {

                            $get_utypename = $this->Menu_model->get_utype($uyid);
                            $get_utypename = $get_utypename[0]->name;

                            foreach ($difference as $key => $value) {
                                if ($key == 'user_types' && in_array($uyid, $value)) {
        
                                    $get_utypename = $this->Menu_model->get_utype($uyid);
                                    $get_utypename = $get_utypename[0]->name;
                                    
                                    foreach ($difference as $key => $value) {
                                        if ($key == 'company_status'){
                                            foreach($selectcompanybyuser as $tid){
                                                $cmp_Data = $this->getResCompanyStatus($tid);
                                                $cmp_Data_cstatus = $cmp_Data[0]->cstatus;
                                                $rst_cmpid_id = $cmp_Data[0]->cmpid_id;
                                             
                                                if (in_array($cmp_Data_cstatus, $value)){
                                              
                                                    $cur_cmp_status = $this->Menu_model->get_statusbyid($cmp_Data_cstatus); 
                                                    $cur_cmp_status_name = $cur_cmp_status[0]->name;

                                                    foreach ($difference as $key => $value) {
                                                        if ($key == 'partner_types') {

                                                            foreach($value as $partnertype){
                                                                $cmp_part = $this->Menu_model->get_cmp_partnertype($partnertype,$bdid);
                                                                foreach ($cmp_part as $obj) {
                                                                    if ($obj->inid == $tid) {
                                                                        $exists = true;
                                                                        break;
                                                                    }
                                                                }
                                                                
                                                                if ($exists) {
                                                                    $cmp_prtData = $this->Menu_model->get_partnerById($partnertype); 
                                                                    $cmp_prt_name = $cmp_prtData[0]->name;
                                                                    
                                                                    foreach ($difference as $key => $value) {
                                                                        if ($key == 'action_id' && !in_array($ntaction, $value)) {
                                        
                                                                            $ntactionname = $this->Menu_model->get_actionbyid($ntaction);
                                                                            $ntactionname = $ntactionname[0]->name;
                        
                                                                            $flash_message = $get_utypename.' | '.$cur_cmp_status_name.' | '.$cmp_prt_name.' | '.$ntactionname;
                                                                            
                                                                            if($rsuser_ids !== ''){
                                                                                if (in_array($bdid, $user_ids_arr)) {
                                                                                    $flash_message = 'Company Status - '.$cur_cmp_status_name.' & Task Action - '.$ntactionname;
                                                                                    $this->session->set_flashdata('success_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                                    redirect('Menu/TaskPlanner2/'.$pdate);
                                                                                }
                                                                            }else{
                                                                                $this->session->set_flashdata('success_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                                                                redirect('Menu/TaskPlanner2/'.$pdate);
                                                                            }
                                                                        }
                                                                     }
                                                                }else{
                                                                    $cmp_prtData = $this->Menu_model->get_partnerById($partnertype); 
                                                                    $cmp_prt_name = $cmp_prtData[0]->name;
                                                                    $flash_message = $get_utypename.' | '.$cur_cmp_status_name.' | '.$cmp_prt_name;

                                                                    if($rsuser_ids !== ''){
                                                                        if (in_array($bdid, $user_ids_arr)) {
                                                                            
                                                                            $this->session->set_flashdata('success_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                            redirect('Menu/TaskPlanner2/'.$pdate);
                                                                        }
                                                                    }else{
                                                                        $this->session->set_flashdata('success_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                                                        redirect('Menu/TaskPlanner2/'.$pdate);
                                                                    }

                                                                }
                                                            } 
                                                        }
                                                    }  
                                                }else{
                                                    $cur_cmp_status = $this->Menu_model->get_statusbyid($cmp_Data_cstatus); 
                                                    $cur_cmp_status_name = $cur_cmp_status[0]->name;
                                                    $flash_message = $get_utypename.' |  '.$cur_cmp_status_name;
                                                    if($rsuser_ids !== ''){
                                                        if (in_array($bdid, $user_ids_arr)) {
                                                            $flash_message = 'Company Status - '.$cur_cmp_status_name;
                                                            $this->session->set_flashdata('success_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                            redirect('Menu/TaskPlanner2/'.$pdate);
                                                        }
                                                    }else{
                                                        $this->session->set_flashdata('success_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                                        redirect('Menu/TaskPlanner2/'.$pdate);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                
// End Check Restrction when admin add - user_types, action_id, company_status, partner_types


// Start Check Restrction when admin add - user_types, action_id, company_status, categorys

                if (array_key_exists('user_types', $difference) && array_key_exists('action_id', $difference) && array_key_exists('company_status', $difference) && array_key_exists('categorys', $difference) && sizeof($difference) == 4) {
                
                    foreach ($difference as $key => $value) {
                        if ($key == 'user_types' && in_array($uyid, $value)) {

                            $get_utypename = $this->Menu_model->get_utype($uyid);
                            $get_utypename = $get_utypename[0]->name;

                            foreach ($difference as $key => $value) {
                                if ($key == 'user_types' && in_array($uyid, $value)) {
        
                                    $get_utypename = $this->Menu_model->get_utype($uyid);
                                    $get_utypename = $get_utypename[0]->name;
                                    
                                    foreach ($difference as $key => $value) {
                                        if ($key == 'company_status'){
                                            foreach($selectcompanybyuser as $tid){
                                                $cmp_Data = $this->getResCompanyStatus($tid);
                                                $cmp_Data_cstatus = $cmp_Data[0]->cstatus;
                                                $rst_cmpid_id = $cmp_Data[0]->cmpid_id;
                                             
                                                if (in_array($cmp_Data_cstatus, $value)){
                                              
                                                    $cur_cmp_status = $this->Menu_model->get_statusbyid($cmp_Data_cstatus); 
                                                    $cur_cmp_status_name = $cur_cmp_status[0]->name;


                                                    foreach ($difference as $key => $value) {

                                                        if ($key == 'categorys') {

                                                            foreach($value as $rst_cate){

                                                                if($rst_cate == 'topspender'){$catename = 'Top Spender';}
                                                                if($rst_cate == 'upsell_client'){$catename = 'Upsell Client';}
                                                                if($rst_cate == 'focus_funnel'){$catename = 'Focus Funnel';}
                                                                if($rst_cate == 'keycompany'){$catename = 'Key Company';}
                                                                if($rst_cate == 'pkclient'){$catename = 'Positive Key Client';}
                                
                                                                $get_db_cat = $this->Menu_model->get_comCategorys($rst_cate,$tid);
                                                                
                                                                if(sizeof($get_db_cat) !== 0){
                                                                   
                                                                    foreach ($difference as $key => $value) {
                                                                        if ($key == 'action_id' && !in_array($ntaction, $value)) {
                                        
                                                                            $ntactionname = $this->Menu_model->get_actionbyid($ntaction);
                                                                            $ntactionname = $ntactionname[0]->name;
                        
                                                                            $flash_message = $get_utypename.' | '.$cur_cmp_status_name.' | '.$catename.' | '.$ntactionname;
                                                                            
                                                                            if($rsuser_ids !== ''){
                                                                                if (in_array($bdid, $user_ids_arr)) {
                                                                                   
                                                                                    $this->session->set_flashdata('success_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                                    redirect('Menu/TaskPlanner2/'.$pdate);
                                                                                }
                                                                            }else{
                                                                                $this->session->set_flashdata('success_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                                                                redirect('Menu/TaskPlanner2/'.$pdate);
                                                                            }
                                                                        }
                                                                     }
                                                                }else{

                                                                    $flash_message = $get_utypename.' | '.$cur_cmp_status_name.' | '.$catename;
                                                                            
                                                                    if($rsuser_ids !== ''){
                                                                        if (in_array($bdid, $user_ids_arr)) {
                                                
                                                                            $this->session->set_flashdata('success_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                            redirect('Menu/TaskPlanner2/'.$pdate);
                                                                        }
                                                                    }else{
                                                                        $this->session->set_flashdata('success_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                                                        redirect('Menu/TaskPlanner2/'.$pdate);
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }else{
                                                    $cur_cmp_status = $this->Menu_model->get_statusbyid($cmp_Data_cstatus); 
                                                    $cur_cmp_status_name = $cur_cmp_status[0]->name;
                                                    $flash_message = $get_utypename.' |  '.$cur_cmp_status_name;
                                                    if($rsuser_ids !== ''){
                                                        if (in_array($bdid, $user_ids_arr)) {
                                                            $flash_message = 'Company Status - '.$cur_cmp_status_name;
                                                            $this->session->set_flashdata('success_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                            redirect('Menu/TaskPlanner2/'.$pdate);
                                                        }
                                                    }else{
                                                        $this->session->set_flashdata('success_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                                        redirect('Menu/TaskPlanner2/'.$pdate);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                
 // End Check Restrction when admin add - user_types, action_id, company_status, categorys

// Start Check Restrction when admin add - user_types, action_id, partner_types,categorys

                if (array_key_exists('user_types', $difference) && array_key_exists('action_id', $difference) && array_key_exists('partner_types', $difference) && array_key_exists('categorys', $difference) && sizeof($difference) == 4) {
                
                    foreach ($difference as $key => $value) {
                        if ($key == 'user_types' && in_array($uyid, $value)) {

                            $get_utypename = $this->Menu_model->get_utype($uyid);
                            $get_utypename = $get_utypename[0]->name;

                            foreach ($difference as $key => $value) {
                                if ($key == 'user_types' && in_array($uyid, $value)) {
        
                                    $get_utypename = $this->Menu_model->get_utype($uyid);
                                    $get_utypename = $get_utypename[0]->name;
                                    
                                                    foreach ($difference as $key => $value) {
                                                        if ($key == 'partner_types') {

                                                            foreach($value as $partnertype){
                                                                $cmp_part = $this->Menu_model->get_cmp_partnertype($partnertype,$bdid);
                                                                foreach ($cmp_part as $obj) {
                                                                    if ($obj->inid == $tid) {
                                                                        $exists = true;
                                                                        break;
                                                                    }
                                                                }
                                                                
                                                                if ($exists) {
                                                                    $cmp_prtData = $this->Menu_model->get_partnerById($partnertype); 
                                                                    $cmp_prt_name = $cmp_prtData[0]->name;
                                                                
                                                                    foreach ($difference as $key => $value) {

                                                                        if ($key == 'categorys') {
                
                                                                            foreach($value as $rst_cate){
                
                                                                                if($rst_cate == 'topspender'){$catename = 'Top Spender';}
                                                                                if($rst_cate == 'upsell_client'){$catename = 'Upsell Client';}
                                                                                if($rst_cate == 'focus_funnel'){$catename = 'Focus Funnel';}
                                                                                if($rst_cate == 'keycompany'){$catename = 'Key Company';}
                                                                                if($rst_cate == 'pkclient'){$catename = 'Positive Key Client';}
                                                
                                                                                $get_db_cat = $this->Menu_model->get_comCategorys($rst_cate,$tid);
                                                                                
                                                                                if(sizeof($get_db_cat) !== 0){
                                                                                   
                                                                                    foreach ($difference as $key => $value) {
                                                                                        if ($key == 'action_id' && !in_array($ntaction, $value)) {
                                                        
                                                                                            $ntactionname = $this->Menu_model->get_actionbyid($ntaction);
                                                                                            $ntactionname = $ntactionname[0]->name;
                                        
                                                                                            $flash_message = $get_utypename.' | '.$cmp_prt_name.' | '.$catename.' | '.$ntactionname;
                                                                                            
                                                                                            if($rsuser_ids !== ''){
                                                                                                if (in_array($bdid, $user_ids_arr)) {
                                                                                                   
                                                                                                    $this->session->set_flashdata('success_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                                                    redirect('Menu/TaskPlanner2/'.$pdate);
                                                                                                }
                                                                                            }else{
                                                                                                $this->session->set_flashdata('success_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                                                                                redirect('Menu/TaskPlanner2/'.$pdate);
                                                                                            }
                                                                                        }
                                                                                     }
                                                                                }else{
                
                                                                                    $flash_message = $get_utypename.' | '.$cur_cmp_status_name.' | '.$catename;
                                                                                            
                                                                                    if($rsuser_ids !== ''){
                                                                                        if (in_array($bdid, $user_ids_arr)) {
                                                                
                                                                                            $this->session->set_flashdata('success_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                                            redirect('Menu/TaskPlanner2/'.$pdate);
                                                                                        }
                                                                                    }else{
                                                                                        $this->session->set_flashdata('success_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                                                                        redirect('Menu/TaskPlanner2/'.$pdate);
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }else{
                                                                    $cmp_prtData = $this->Menu_model->get_partnerById($partnertype); 
                                                                    $cmp_prt_name = $cmp_prtData[0]->name;
                                                                    $flash_message = $get_utypename.' | '.$cur_cmp_status_name.' | '.$cmp_prt_name;

                                                                    if($rsuser_ids !== ''){
                                                                        if (in_array($bdid, $user_ids_arr)) {
                                                                            
                                                                            $this->session->set_flashdata('success_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                            redirect('Menu/TaskPlanner2/'.$pdate);
                                                                        }
                                                                    }else{
                                                                        $this->session->set_flashdata('success_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                                                        redirect('Menu/TaskPlanner2/'.$pdate);
                                                                    }

                                                                }
                                                            } 
                                                        }
                                                    }  
                                                }
                                            }
                                        }
                                    }
                                }           
// End Check Restrction when admin add - user_types, action_id, partner_types,categorys

// Start Check Restrction when admin add - user_types, action_id, partner_types

if (array_key_exists('user_types', $difference) && array_key_exists('action_id', $difference) && array_key_exists('partner_types', $difference) && sizeof($difference) == 3) {
                
    foreach ($difference as $key => $value) {
        if ($key == 'user_types' && in_array($uyid, $value)) {

            $get_utypename = $this->Menu_model->get_utype($uyid);
            $get_utypename = $get_utypename[0]->name;

            foreach ($difference as $key => $value) {
                if ($key == 'user_types' && in_array($uyid, $value)) {

                    $get_utypename = $this->Menu_model->get_utype($uyid);
                    $get_utypename = $get_utypename[0]->name;
                    foreach ($difference as $key => $value) {
                        if ($key == 'partner_types') {

                                        foreach($value as $partnertype){
                                            $cmp_part = $this->Menu_model->get_cmp_partnertype($partnertype,$bdid);
                                            foreach ($cmp_part as $obj) {
                                                if ($obj->inid == $tid) {
                                                    $exists = true;
                                                    break;
                                                }
                                            }
                                            
                                            if ($exists) {
                                                $cmp_prtData = $this->Menu_model->get_partnerById($partnertype); 
                                                $cmp_prt_name = $cmp_prtData[0]->name;
                                                
                                                foreach ($difference as $key => $value) {
                                                    if ($key == 'action_id' && !in_array($ntaction, $value)) {
                    
                                                        $ntactionname = $this->Menu_model->get_actionbyid($ntaction);
                                                        $ntactionname = $ntactionname[0]->name;

                                                        $flash_message = $get_utypename.' | '.$cmp_prt_name.' | '.$ntactionname;
                                                        
                                                        if($rsuser_ids !== ''){
                                                            if (in_array($bdid, $user_ids_arr)) {
                                                                $flash_message = 'Company Status - '.$cur_cmp_status_name.' & Task Action - '.$ntactionname;
                                                                $this->session->set_flashdata('success_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                redirect('Menu/TaskPlanner2/'.$pdate);
                                                            }
                                                        }else{
                                                            $this->session->set_flashdata('success_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                                            redirect('Menu/TaskPlanner2/'.$pdate);
                                                        }
                                                    }
                                                }
                                            }else{
                                                $cmp_prtData = $this->Menu_model->get_partnerById($partnertype); 
                                                $cmp_prt_name = $cmp_prtData[0]->name;
                                                $flash_message = $get_utypename.' | '.$cmp_prt_name;

                                                if($rsuser_ids !== ''){
                                                    if (in_array($bdid, $user_ids_arr)) {
                                                        
                                                        $this->session->set_flashdata('success_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                        redirect('Menu/TaskPlanner2/'.$pdate);
                                                    }
                                                }else{
                                                    $this->session->set_flashdata('success_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                                    redirect('Menu/TaskPlanner2/'.$pdate);
                                                }
                                            }
                                        } 
                                    }
                                }        
                            }
                        }
                    }
                }
            }
                    
// End Check Restrction when admin add - user_types, action_id, partner_types

// Start Check Restrction when admin add - user_types, action_id, categorys

if (array_key_exists('user_types', $difference) && array_key_exists('action_id', $difference) && array_key_exists('categorys', $difference) && sizeof($difference) == 3) {
                
    foreach ($difference as $key => $value) {
        if ($key == 'user_types' && in_array($uyid, $value)) {

            $get_utypename = $this->Menu_model->get_utype($uyid);
            $get_utypename = $get_utypename[0]->name;

            foreach ($difference as $key => $value) {
                if ($key == 'user_types' && in_array($uyid, $value)) {

                    $get_utypename = $this->Menu_model->get_utype($uyid);
                    $get_utypename = $get_utypename[0]->name;
                    
                                foreach ($difference as $key => $value) {

                                    if ($key == 'categorys') {

                                        foreach($value as $rst_cate){

                                            if($rst_cate == 'topspender'){$catename = 'Top Spender';}
                                            if($rst_cate == 'upsell_client'){$catename = 'Upsell Client';}
                                            if($rst_cate == 'focus_funnel'){$catename = 'Focus Funnel';}
                                            if($rst_cate == 'keycompany'){$catename = 'Key Company';}
                                            if($rst_cate == 'pkclient'){$catename = 'Positive Key Client';}

                                            $get_db_cat = $this->Menu_model->get_comCategorys($rst_cate,$tid);
                                            
                                            if(sizeof($get_db_cat) !== 0){
                                            
                                                foreach ($difference as $key => $value) {
                                                    if ($key == 'action_id' && !in_array($ntaction, $value)) {
                    
                                                        $ntactionname = $this->Menu_model->get_actionbyid($ntaction);
                                                        $ntactionname = $ntactionname[0]->name;

                                                        $flash_message = $get_utypename.' | '.$catename.' | '.$ntactionname;
                                                        
                                                        if($rsuser_ids !== ''){
                                                            if (in_array($bdid, $user_ids_arr)) {
                                                            
                                                                $this->session->set_flashdata('success_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                redirect('Menu/TaskPlanner2/'.$pdate);
                                                            }
                                                        }else{
                                                            $this->session->set_flashdata('success_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                                            redirect('Menu/TaskPlanner2/'.$pdate);
                                                        }
                                                    }
                                                }
                                            }else{

                                                $flash_message = $get_utypename.' | '.$catename;
                                                        
                                                if($rsuser_ids !== ''){
                                                    if (in_array($bdid, $user_ids_arr)) {
                            
                                                        $this->session->set_flashdata('success_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                        redirect('Menu/TaskPlanner2/'.$pdate);
                                                    }
                                                }else{
                                                    $this->session->set_flashdata('success_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                                    redirect('Menu/TaskPlanner2/'.$pdate);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
                    
// End Check Restrction when admin add - user_types, action_id, categorys

// Start Check Restrction when admin add - user_types, action_id, company_status

if (array_key_exists('user_types', $difference) && array_key_exists('action_id', $difference) && array_key_exists('company_status', $difference) && sizeof($difference) == 3 ) {
                
    foreach ($difference as $key => $value) {
        if ($key == 'user_types' && in_array($uyid, $value)) {

            $get_utypename = $this->Menu_model->get_utype($uyid);
            $get_utypename = $get_utypename[0]->name;
            
            foreach ($difference as $key => $value) {
                if ($key == 'company_status'){
                    foreach($selectcompanybyuser as $tid){
                        $cmp_Data = $this->getResCompanyStatus($tid);
                        $cmp_Data_cstatus = $cmp_Data[0]->cstatus;
                        $rst_cmpid_id = $cmp_Data[0]->cmpid_id;
                     
                        if (in_array($cmp_Data_cstatus, $value)){
                      
                            $cur_cmp_status = $this->Menu_model->get_statusbyid($cmp_Data_cstatus); 
                            $cur_cmp_status_name = $cur_cmp_status[0]->name;
                            foreach ($difference as $key => $value) {
                                if ($key == 'action_id' && !in_array($ntaction, $value)) {

                                    $ntactionname = $this->Menu_model->get_actionbyid($ntaction);
                                    $ntactionname = $ntactionname[0]->name;

                                    $flash_message = $get_utypename.' | '.$cur_cmp_status_name.' | '.$ntactionname;
                                    
                                    if($rsuser_ids !== ''){
                                        if (in_array($bdid, $user_ids_arr)) {
                                            $flash_message = 'Company Status - '.$cur_cmp_status_name.' & Task Action - '.$ntactionname;
                                            $this->session->set_flashdata('success_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                            redirect('Menu/TaskPlanner2/'.$pdate);
                                        }
                                    }else{
                                        $this->session->set_flashdata('success_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                        redirect('Menu/TaskPlanner2/'.$pdate);
                                    }
                                }
                             }
                        }else{
                            $cur_cmp_status = $this->Menu_model->get_statusbyid($cmp_Data_cstatus); 
                            $cur_cmp_status_name = $cur_cmp_status[0]->name;
                            $flash_message = $get_utypename.' |  '.$cur_cmp_status_name;
                            if($rsuser_ids !== ''){
                                if (in_array($bdid, $user_ids_arr)) {
                                    $flash_message = 'Company Status - '.$cur_cmp_status_name;
                                    $this->session->set_flashdata('success_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                    redirect('Menu/TaskPlanner2/'.$pdate);
                                }
                            }else{
                                $this->session->set_flashdata('success_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                redirect('Menu/TaskPlanner2/'.$pdate);
                            }
                        }
                    }
                }
            }
        }
    }
}

// End Check Restrction when admin add - user_types, action_id, company_status

// Start Check Restrction when admin add - user_types, action_id

if (array_key_exists('user_types', $difference) && array_key_exists('action_id', $difference) && sizeof($difference) == 2) {
                
    foreach ($difference as $key => $value) {
        if ($key == 'user_types' && in_array($uyid, $value)) {

            $get_utypename = $this->Menu_model->get_utype($uyid);
            $get_utypename = $get_utypename[0]->name;

            foreach ($difference as $key => $value) {
                if ($key == 'user_types' && in_array($uyid, $value)) {

                    $get_utypename = $this->Menu_model->get_utype($uyid);
                    $get_utypename = $get_utypename[0]->name;
                    foreach ($difference as $key => $value) {
                        if ($key == 'action_id' && !in_array($ntaction, $value)) {

                            $ntactionname = $this->Menu_model->get_actionbyid($ntaction);
                            $ntactionname = $ntactionname[0]->name;

                            $flash_message = $get_utypename.' | '.$ntactionname;
                            
                            if($rsuser_ids !== ''){
                                if (in_array($bdid, $user_ids_arr)) {
                                    $flash_message = 'Company Status - '.$cur_cmp_status_name.' & Task Action - '.$ntactionname;
                                    $this->session->set_flashdata('success_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                    redirect('Menu/TaskPlanner2/'.$pdate);
                                }
                            }else{
                                $this->session->set_flashdata('success_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                redirect('Menu/TaskPlanner2/'.$pdate);
                            }
                        }
                     }           
                }
            }
        }
    }
}
                    
// End Check Restrction when admin add - user_types, action_id

// Handle other conditions as needed
            }
        }
    }
}
// Special Restrication on Task Planner 
// ---------- Close ------------------

public function DeleteSpecialRestrication($id){
    $query=$this->db->query("DELETE FROM `spcl_rest_task_planner` WHERE id=$id");
}

public function getResCompanyStatus($cmpid){
    $query=$this->db->query("SELECT * FROM `init_call` WHERE id ='$cmpid'");
    return $query->result();
}






}
