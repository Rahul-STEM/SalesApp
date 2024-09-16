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
        
        $query = $this->db->query("SELECT * FROM `mom_data` WHERE `user_id` = $suid AND (`approved_status` IS NULL)");
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
        $query =  $this->db->query("UPDATE `mom_data` SET `approved_status` = '$approved_status', `approved_by` = '$uaid', `cm_call_task` = 1, `pst_assign` = 1,`pst_call_task` = 1, `approved_date` = '$approvedtDate', `reject_remarks` = '$approvedreamrk' WHERE `id` = '$id'");
    }
    
    public function UpdateMOM_DataTo_NORP($mom_id,$uaid,$tid) {
        $approved_status = 'NO RP';
        $approvedtDate = date("Y-m-d H:i:s");
        $approvedreamrk = 'Meetings Converted To NO RP Successfully';
        
        $query =$this->db->query("SELECT cid_id FROM `tblcallevents` WHERE id = '$tid' ");
        $resData =  $query->result();
        $cid_id = $resData[0]->cid_id;
        $query=$this->db->query("UPDATE `init_call` SET `cstatus` = `lstatus` WHERE id='$cid_id'");
        $data = [
            'approved_status' => $approved_status,
            'approved_by' => $uaid,
            'cm_call_task' => 0,
            'pst_assign' => 1,
            'pst_call_task' => 0,
            'approved_date' => $approvedtDate,
            'reject_remarks' => $approvedreamrk
        ];
        
        $this->db->where('id', $mom_id);
        $this->db->update('mom_data', $data);
        
        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
        
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
    public function CreateTask($fwd_date,$actiontype_id,$init_id,$nextaction,$ass_user_id,$purpose_id,$autotask,$auto_plan,$ccstatus,$task_remarks) {
            $current_date = date("Y-m-d H:i:s");
            $data = array(
                'lastCFID' => 0,
                'nextCFID' => 0,
                'purpose_achieved' => 'no',
                'fwd_date' => $current_date,
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
                'auto_plan' => $auto_plan,
                'mom_remarks' => $task_remarks
            );
            // Insert the data into the database
            $this->db->insert('tblcallevents', $data);
            $insert_id = $this->db->insert_id();
            return  $insert_id;
    }
    public function CreateTaskForAutoAssign($user_id,$to_user_id,$ccstatus,$init_cmpid,$call_tid,$action_id,$mom_id,$remarks) {
        $data = array(
            'user_id' => $user_id,
            'to_user_id' => $to_user_id,
            'ccstatus' => $ccstatus,
            'init_cmpid' => $init_cmpid,
            'call_tid' => $call_tid,
            'action_id' => $action_id,
            'mom_id' => $mom_id,
            'remarks' => $remarks,
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
                $chk_user_types = explode(',', $rsData->user_types);
                $rsuser_ids = $rsData->user_ids;
                $user_ids_arr = explode(',', $rsuser_ids);
             
                if(in_array($uyid, $chk_user_types)) {
                    if (empty($user_ids_arr[0]) || in_array($bdid, $user_ids_arr)) {
            $conditions = [
                'action_id' => explode(',', $rsData->action_id),
                'user_types' => $chk_user_types,
                'company_status' => explode(',', $rsData->company_status),
                'partner_types' => explode(',', $rsData->partner_types),
                'categorys' => explode(',', $rsData->categorys),
            ];
            
            $rst_sdate = $rsData->sdate;
            $rst_edate = $rsData->edate;
            $allArrays = array_filter($conditions, function ($arr) { return $arr == ['all']; });
           
            if (count($allArrays) == count($conditions)) {
                $this->session->set_flashdata('error_message', 'Admin Add Special Restriction on Task Planner for ' . $rst_sdate . ' to ' . $rst_edate);
                redirect('Menu/TaskPlanner2' . $pdate);
            } else {
                if (array_key_exists('user_types', $allArrays) && array_key_exists('action_id', $allArrays)) {
                
                $this->session->set_flashdata('error_message', 'Admin Add Special Restriction on Task Planner for ' . $rst_sdate . ' to ' . $rst_edate);
                redirect('Menu/TaskPlanner2' . $pdate);
                }
           
            $difference = array_diff_assoc($conditions,$allArrays);
                       
            $difference = array_filter($difference, function($value) {
                return !empty($value[0]);
            });
            
            
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
                                                                               
                                                                                $this->session->set_flashdata('error_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                                redirect('Menu/TaskPlanner2/'.$pdate);
                                                                            }
                                                                        }else{
                                                                            $this->session->set_flashdata('error_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                                                            redirect('Menu/TaskPlanner2/'.$pdate);
                                                                        }
                                                                    }
                                                                 }
                                                            }else{
                                                                $flash_message = $get_utypename.' | '.$cur_cmp_status_name.' | '.$catename;
                                                                        
                                                                if($rsuser_ids !== ''){
                                                                    if (in_array($bdid, $user_ids_arr)) {
                                            
                                                                        $this->session->set_flashdata('error_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                        redirect('Menu/TaskPlanner2/'.$pdate);
                                                                    }
                                                                }else{
                                                                    $this->session->set_flashdata('error_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
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
                                                        
                                                        $this->session->set_flashdata('error_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                        redirect('Menu/TaskPlanner2/'.$pdate);
                                                    }
                                                }else{
                                                    $this->session->set_flashdata('error_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
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
                                        $this->session->set_flashdata('error_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                        redirect('Menu/TaskPlanner2/'.$pdate);
                                    }
                                }else{
                                    $this->session->set_flashdata('error_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
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
                                                                                    $this->session->set_flashdata('error_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                                    redirect('Menu/TaskPlanner2/'.$pdate);
                                                                                }
                                                                            }else{
                                                                                $this->session->set_flashdata('error_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
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
                                                                            
                                                                            $this->session->set_flashdata('error_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                            redirect('Menu/TaskPlanner2/'.$pdate);
                                                                        }
                                                                    }else{
                                                                        $this->session->set_flashdata('error_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
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
                                                            $this->session->set_flashdata('error_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                            redirect('Menu/TaskPlanner2/'.$pdate);
                                                        }
                                                    }else{
                                                        $this->session->set_flashdata('error_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
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
                                                                                   
                                                                                    $this->session->set_flashdata('error_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                                    redirect('Menu/TaskPlanner2/'.$pdate);
                                                                                }
                                                                            }else{
                                                                                $this->session->set_flashdata('error_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                                                                redirect('Menu/TaskPlanner2/'.$pdate);
                                                                            }
                                                                        }
                                                                     }
                                                                }else{
                                                                    $flash_message = $get_utypename.' | '.$cur_cmp_status_name.' | '.$catename;
                                                                            
                                                                    if($rsuser_ids !== ''){
                                                                        if (in_array($bdid, $user_ids_arr)) {
                                                
                                                                            $this->session->set_flashdata('error_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                            redirect('Menu/TaskPlanner2/'.$pdate);
                                                                        }
                                                                    }else{
                                                                        $this->session->set_flashdata('error_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
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
                                                            $this->session->set_flashdata('error_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                            redirect('Menu/TaskPlanner2/'.$pdate);
                                                        }
                                                    }else{
                                                        $this->session->set_flashdata('error_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
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
                                                                                                   
                                                                                                    $this->session->set_flashdata('error_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                                                    redirect('Menu/TaskPlanner2/'.$pdate);
                                                                                                }
                                                                                            }else{
                                                                                                $this->session->set_flashdata('error_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                                                                                redirect('Menu/TaskPlanner2/'.$pdate);
                                                                                            }
                                                                                        }
                                                                                     }
                                                                                }else{
                
                                                                                    $flash_message = $get_utypename.' | '.$cur_cmp_status_name.' | '.$catename;
                                                                                            
                                                                                    if($rsuser_ids !== ''){
                                                                                        if (in_array($bdid, $user_ids_arr)) {
                                                                
                                                                                            $this->session->set_flashdata('error_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                                            redirect('Menu/TaskPlanner2/'.$pdate);
                                                                                        }
                                                                                    }else{
                                                                                        $this->session->set_flashdata('error_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
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
                                                                            
                                                                            $this->session->set_flashdata('error_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                            redirect('Menu/TaskPlanner2/'.$pdate);
                                                                        }
                                                                    }else{
                                                                        $this->session->set_flashdata('error_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
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
                                                                $this->session->set_flashdata('error_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                redirect('Menu/TaskPlanner2/'.$pdate);
                                                            }
                                                        }else{
                                                            $this->session->set_flashdata('error_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
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
                                                        
                                                        $this->session->set_flashdata('error_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                        redirect('Menu/TaskPlanner2/'.$pdate);
                                                    }
                                                }else{
                                                    $this->session->set_flashdata('error_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
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
                                                            
                                                                $this->session->set_flashdata('error_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                                redirect('Menu/TaskPlanner2/'.$pdate);
                                                            }
                                                        }else{
                                                            $this->session->set_flashdata('error_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                                            redirect('Menu/TaskPlanner2/'.$pdate);
                                                        }
                                                    }
                                                }
                                            }else{
                                                $flash_message = $get_utypename.' | '.$catename;
                                                        
                                                if($rsuser_ids !== ''){
                                                    if (in_array($bdid, $user_ids_arr)) {
                            
                                                        $this->session->set_flashdata('error_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                                        redirect('Menu/TaskPlanner2/'.$pdate);
                                                    }
                                                }else{
                                                    $this->session->set_flashdata('error_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
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
                                            $this->session->set_flashdata('error_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                            redirect('Menu/TaskPlanner2/'.$pdate);
                                        }
                                    }else{
                                        $this->session->set_flashdata('error_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
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
                                    $this->session->set_flashdata('error_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                    redirect('Menu/TaskPlanner2/'.$pdate);
                                }
                            }else{
                                $this->session->set_flashdata('error_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
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
                        if ($key == 'action_id' && !in_array($ntaction, $value)) {
                            $ntactionname = $this->Menu_model->get_actionbyid($ntaction);
                            $ntactionname = $ntactionname[0]->name;
                            $flash_message = $get_utypename.' | '.$ntactionname;
                            
                            if($rsuser_ids !== ''){
                                if (in_array($bdid, $user_ids_arr)) {
                                    $flash_message = $ntactionname;
                                    $this->session->set_flashdata('error_message','Admin have Added Special Restriction for You Can not Plan '.$flash_message.' Task on Task Planner for you on date '.$rst_sdate .' to '.$rst_edate);
                                    redirect('Menu/TaskPlanner2/'.$pdate);
                                }
                            }else{
                                $this->session->set_flashdata('error_message','Admin have Added Special Restriction of '.$flash_message.' Task on Task Planner for '.$rst_sdate .' to '.$rst_edate);
                                redirect('Menu/TaskPlanner2/'.$pdate);
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
    }
}
// Special Restrication on Task Planner 
// ---------- Close ------------------
public function DeleteSpecialRestrication($id){
    $query=$this->db->query("DELETE FROM `spcl_rest_task_planner` WHERE id=$id");
}
 public function RequestForDayManagementApproval_Model($uid,$request){
        $data = [
            'USER_ID' => $uid,
            'REASON' => $request
        ];
    
        if ($this->db->insert('daymanagementapprovalrequest', $data)) {
            return true;
        } else {
            return false;
        }
    }
    
     public function RequestApprovals($uid,$cdate) {
        $cdate = date('Y-m-d');
        // echo $cdate;die;
        $this->db->select('REASON, CREATED_AT,APPROVED_AT');
        $this->db->select('ud1.name AS request_by');
        $this->db->select('ud2.name AS approved_by');
        $this->db->from('daymanagementapprovalrequest');
        $this->db->join('user_details ud1', 'ud1.user_id = daymanagementapprovalrequest.USER_ID', 'left');
        $this->db->join('user_details ud2', 'ud2.user_id = daymanagementapprovalrequest.APPROVED_BY', 'left');
        $this->db->where('daymanagementapprovalrequest.USER_ID', $uid);
        
        $this->db->where('DATE(daymanagementapprovalrequest.CREATED_AT) ', $cdate);
// Execute the query
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }
 public function ApprovedRequests($uid,$cdate) {
        $cdate = date('Y-m-d');
        $this->db->select('REASON, CREATED_AT,APPROVED_AT');
        $this->db->select('ud1.name AS request_by');
        $this->db->select('ud2.name AS approved_by');
        $this->db->from('daymanagementapprovalrequest');
        $this->db->join('user_details ud1', 'ud1.user_id = daymanagementapprovalrequest.USER_ID', 'left');
        $this->db->join('user_details ud2', 'ud2.user_id = daymanagementapprovalrequest.APPROVED_BY', 'left');
        $this->db->where('daymanagementapprovalrequest.USER_ID', $uid);
        $this->db->where('DATE(daymanagementapprovalrequest.CREATED_AT) ', $cdate);
        $this->db->where('daymanagementapprovalrequest.STATUS ', 'Approved');
// Execute the query
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }
 public function getRequests($uid) {
        $this->db->select('REASON, CREATED_AT,APPROVED_AT');
        $this->db->select('daymanagementapprovalrequest.ID,daymanagementapprovalrequest.STATUS');
        $this->db->select('ud1.name AS request_by');
        $this->db->select('ud2.name AS approved_by');
        $this->db->from('daymanagementapprovalrequest');
        $this->db->join('user_details ud1', 'ud1.user_id = daymanagementapprovalrequest.USER_ID', 'left');
        $this->db->join('user_details ud2', 'ud2.user_id = daymanagementapprovalrequest.APPROVED_BY', 'left');
        $this->db->where('ud1.admin_id', $uid);
// Execute the query
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }
  public function ApproveRequest($id,$action,$uid) {
        $current_timestamp = date('Y-m-d H:i:s');
        // echo $current_timestamp;die;
        // Update the request status
        $this->db->set('STATUS', $action);
        $this->db->set('APPROVED_BY', $uid);
        $this->db->set('APPROVED_AT', $current_timestamp);
        $this->db->where('ID', $id);
        $result = $this->db->update('daymanagementapprovalrequest');
        // echo $this->db->last_query();die;
        // $current_timestamp = date('Y-m-d H:i:s');
        // $query =  $this->db->query("UPDATE `daymanagementapprovalrequest` SET `STATUS` = '".$action."',`APPROVED_BY` = '".$uid."',`APPROVED_AT`= now() WHERE `ID` = $id;");
        return 'Success..!!';
    }
 public function getUsers($id,$typeID){
        $this->db->select("user_id,name,type_id");
        $this->db->from("user_details");
        if($typeID == 2){
            $this->db->where("admin_id",$id);
        }elseif ($typeID == 15) {
            
            $this->db->where("sales_co",$id);
        }elseif ($typeID == 4 || $typeID == 13 || $typeID == 9) {
            
            $this->db->where("aadmin_id",$id);
        }else {
            
            $this->db->where("user_id",$id);
        }
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }
    
    public function getReportbyUser($selected_user,$sdate,$edate){
        // var_dump($selected_user);die;
        $this->db->select('star_rating.*');
        $this->db->select('ud1.name as userName');
        $this->db->select('ud2.name as feedbackBy');
        $this->db->from('star_rating');
        $this->db->join('user_details ud1', 'ud1.user_id = star_rating.user_id', 'left');
        $this->db->join('user_details ud2', 'ud2.user_id = star_rating.feedback_by', 'left');
        if(!empty($selected_user)){
            $this->db->where_in('star_rating.user_id',$selected_user);
        }
        $this->db->where('CAST(date AS DATE) >=', "'$sdate'", FALSE);
        $this->db->where('CAST(date AS DATE) <=', "'$edate'", FALSE);
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }
     public function getFunnelTaskforCLM($id){
        // echo $id;
        $date = new DateTime();
        $date->modify('-1 day');
        $pdate =  $date->format('Y-m-d');
        $this->db->select("id");
        $this->db->from('init_call');
        $this->db->where('clm_id', $id);
        $this->db->where('mainbd !=', $id);
        // mainbd != '$uid'
        $subquery = $this->db->get_compiled_select();
        $this->db->select("COUNT(*) AS TotalTeamplan");
        $this->db->select("COUNT(CASE WHEN autotask = 1 AND nextCFID != 0 THEN autotask END) AS TotalTeamCompletedautotask");
        $this->db->select("COUNT(CASE WHEN autotask = 1 THEN autotask END) AS TotalTeamautotask");
        $this->db->select("COUNT(CASE WHEN nextCFID != 0 THEN 1 END) AS TotalTeamdone");
        $this->db->select("COUNT(CASE WHEN nextCFID = 0 AND lastCFID = 0 THEN 1 END) AS TotalTeampending");
        $this->db->select("COUNT(CASE WHEN reassign_type = 2 THEN 1 END) AS TotalTeamassignByOther");
        $this->db->select("COUNT(CASE WHEN reassign_type = 2 AND nextCFID != 0 THEN 1 END) AS TotalTeamCompletedassignByOther");
        $this->db->from('tblcallevents');
        $this->db->where_IN('cid_id', $subquery);
        $this->db->where('CAST(appointmentdatetime AS DATE) = ', $this->db->escape($pdate), FALSE);
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }
    public function CheckingDayManage_New($uid,$cdate){
        // $cdate = '2024-07-20';
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        $this->db->select('user_details.user_id, 
                user_details.name, 
                user_details.type_id, 
                user_day.ustart AS user_start_time, 
                user_day.usimg AS user_start_image,
                user_day.scomment AS user_start_comment, 
                user_day.slatitude AS user_start_lat, 
                user_day.slongitude AS user_start_long, 
                user_day.uclose AS user_close_time, 
                user_day.ucimg AS user_close_image, 
                user_day.ccomment AS user_end_comment, 
                user_day.clatitude AS user_end_lat, 
                user_day.clongitude AS user_end_long, 
                task_plan_for_today.date, 
                task_plan_for_today.request_remarks AS planner_request_remarks, 
                task_plan_for_today.created_at AS planner_created_at, 
                task_plan_for_today.updated_at AS planner_request_approval_date, 
                task_plan_for_today.approvel_status AS planner_approvel_status,
                task_plan_for_today.updated_at AS planner_approvel_time,
                spt.psdatetime AS user_planner_start_time,
                ud1.name AS approver_Name,
                cydr.why_did_you AS close_day_request_Remark,  
                cydr.req_remarks AS close_day_req_remarks,
                cydr.approved_status AS close_day_approved_status,
                cydr.approved_remarks AS close_day_approved_remarks,
                tce.appointmentdatetime AS task_start_time,
                SUM(spt.totaltime) AS total_timeTakeFor_planner,
                uwf.TYPE AS userWorkFrom,
                srfl.prupose AS reasonFor_Request,
                srfl.stime AS leave_StartTime,
                srfl.etime AS leave_EndTime
            '
            );
            
            $this->db->from('user_day');
            $this->db->join('user_details', 'user_details.user_id = user_day.user_id', 'left');
            $this->db->join('session_plan_time spt', 'spt.user_id = user_day.user_id', 'left');
            $this->db->join('autotask_time at1', 'at1.user_id = user_day.user_id', 'left');
            $this->db->join('userworkfrom uwf', 'uwf.ID = at1.userworkfrom', 'left');
            $this->db->join('tblcallevents tce', 'tce.user_id = user_day.user_id AND DATE(tce.appointmentdatetime) = "'.$cdate.'"', 'left');
            $this->db->join('close_your_day_request cydr', 'user_details.user_id = cydr.user_id', 'left');
            $this->db->join('special_request_for_leave srfl', 'user_details.user_id = srfl.user_id', 'left');
            $this->db->join('task_plan_for_today', 'task_plan_for_today.user_id = user_day.user_id AND DATE(task_plan_for_today.date) = DATE(sdatet)', 'left');
            $this->db->join('user_details ud1', 'ud1.user_id = task_plan_for_today.admin_id', 'left');
            if ($utype == 15){
                $this->db->where('user_details.sales_co', $uid);
            }elseif ($utype == 2) {
                
                $this->db->where('user_details.admin_id', $uid);
            }
            $this->db->where('DATE(sdatet)', $cdate);
            $this->db->group_by('user_details.user_id');
            $query = $this->db->get();
            //   echo $this->db->last_query();
               //die;
               
            //   echo "<pre>";
            //   print_r($query->result());exit;
            return $query->result();
       
    }
    
public function getResCompanyStatus($cmpid){
    $query=$this->db->query("SELECT * FROM `init_call` WHERE id ='$cmpid'");
    return $query->result();
}
public function UpdateMOMAterCheck_DataTo_NORP($mom_id,$uaid,$tid,$ntid) {
    $approved_status = 'NO RP';
    $approvedtDate = date("Y-m-d H:i:s");
    $approvedreamrk = 'Meetings Converted To NO RP Successfully';
    
    $query =$this->db->query("SELECT cid_id FROM `tblcallevents` WHERE id = '$tid' ");
    $resData =  $query->result();
    $cid_id = $resData[0]->cid_id;
    $query=$this->db->query("UPDATE `init_call` SET `cstatus` = `lstatus` WHERE id='$cid_id'");
    $remark = 'NO RP FOUND';
    $date = date("Y-m-d H:i:s");
    $dataup = array(
        'remarks' => $remark,
        'nextCFID' => $tid,
        'updateddate' => $date,
        'actontaken' => 'yes',
        'purpose_achieved' => 'no',
        'updation_data_type' => 'update'
    );
    
    $this->db->where('id', $ntid);
    $this->db->update('tblcallevents', $dataup);
    
    $data = [
        'approved_status' => $approved_status,
        'approved_by' => $uaid,
        'cm_call_task' => 0,
        'pst_assign' => 1,
        'pst_call_task' => 0,
        'approved_date' => $approvedtDate,
        'reject_remarks' => $approvedreamrk
    ];
    
    $this->db->where('id', $mom_id);
    $this->db->update('mom_data', $data);
    
    if ($this->db->affected_rows() > 0) {
        return 1;
    } else {
        return 0;
    }
    
}
public function StoreReminder($rtype,$rmessage,$user_id){
    $data = [
        'type' => $rtype,
        'message' => $rmessage,
        'user_id' => $user_id
    ];
    $this->db->insert('reminder', $data);
}
}
