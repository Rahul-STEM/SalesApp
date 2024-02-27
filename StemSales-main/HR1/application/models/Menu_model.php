<?php
date_default_timezone_set("Asia/Calcutta");
class Menu_model extends CI_Model{
    
    public function user_login($user,$pwd){
        $query=$this->db->query("SELECT * FROM user_detail WHERE user_name='$user' AND password='$pwd'");
        return $query->result();
    }
    
    
    public function get_action(){
        $query=$this->db->query("SELECT * FROM action");
        return $query->result();
    }
    
    public function get_position(){
        $query=$this->db->query("SELECT * FROM position");
        return $query->result();
    }
    
    
    public function New_Candidate($storeby,$cname,$cemail,$cmo,$cwno,$cresume,$cqual,$cifield,$address,$city,$state,$position_id){
        $udate = date('Y-m-d H:i:s');
        $query=$this->db->query("insert into cpd (storeby, cname, cemail, cmo, cwno, cresume, cqual, cifield, address, city, state,lupdate,cstatus,lstatus,position_id) value('$storeby','$cname','$cemail',$cmo,'$cwno','$cresume','$cqual','$cifield','$address','$city','$state','$udate','1','1','$position_id') ");
        return $this->db->insert_id();
    }
    
    
    public function get_userbyid($uid){
        $query=$this->db->query("SELECT * FROM user_detail WHERE id='$uid'");
        return $query->result();
    }
    
     
    public function statuswiseCdetail($uid){
        $udeatil = $this->Menu_model->get_userbyid($uid);
        $utype = $udeatil[0]->type;
        if($utype=='Admin'){$text = "user_detail.id='$uid'";}
        if($utype=='SupperAdmin'){$text = "user_detail.adminid='$uid'";}
        
        $query=$this->db->query("SELECT COUNT(*) ab,COUNT(CASE WHEN cstatus=1 THEN cstatus END) a,COUNT(CASE WHEN cstatus=2 THEN cstatus END) b,COUNT(CASE WHEN cstatus=3 THEN cstatus END) c,COUNT(CASE WHEN cstatus=4 THEN cstatus END) d,COUNT(CASE WHEN cstatus=5 THEN cstatus END) e,COUNT(CASE WHEN cstatus=6 THEN cstatus END) f,COUNT(CASE WHEN cstatus=7 THEN cstatus END) g,COUNT(CASE WHEN cstatus=8 THEN cstatus END) h, COUNT(CASE WHEN cstatus=9 THEN cstatus END) i, COUNT(CASE WHEN cstatus=10 THEN cstatus END) j, COUNT(CASE WHEN cstatus=11 THEN cstatus END) k, COUNT(CASE WHEN cstatus=12 THEN cstatus END) l, COUNT(CASE WHEN cstatus=13 THEN cstatus END) m FROM cpd left join user_detail on user_detail.id=cpd.storeby where $text");
        return $query->result();
    }
    
    public function positionwiseCdetail($uid){
         $udeatil = $this->Menu_model->get_userbyid($uid);
        $utype = $udeatil[0]->type;
        if($utype=='Admin'){$text = "user_detail.id='$uid'";}
        if($utype=='SupperAdmin'){$text = "user_detail.adminid='$uid'";}
        
        $query=$this->db->query("SELECT COUNT(*) cont,position.spname FROM cpd left join user_detail on user_detail.id=cpd.storeby LEFT JOIN position ON position.id=cpd.position WHERE $text GROUP BY cpd.position");
        return $query->result();
    }
    
    
    
    public function get_Candidate($s,$uid){
        if($s==0){
            $query=$this->db->query("SELECT cpd.*,s1.name csname,s2.name lsname,user_detail.fullname FROM cpd LEFT JOIN status s1 ON s1.id=cpd.cstatus LEFT JOIN status s2 ON s2.id=cpd.lstatus LEFT JOIN user_detail ON user_detail.id=cpd.storeby where user_detail.id='$uid'");
        }else{
            $query=$this->db->query("SELECT cpd.*,s1.name csname,s2.name lsname,user_detail.fullname FROM cpd LEFT JOIN status s1 ON s1.id=cpd.cstatus LEFT JOIN status s2 ON s2.id=cpd.lstatus LEFT JOIN user_detail ON user_detail.id=cpd.storeby where cpd.cstatus='$s' and  user_detail.id='$uid'");
        }
        return $query->result();
    }
    
    
    public function get_Candidatebypid($uid){
        
        $query=$this->db->query("SELECT cpd.*,s1.name csname,s2.name lsname,user_detail.fullname FROM cpd LEFT JOIN status s1 ON s1.id=cpd.cstatus LEFT JOIN status s2 ON s2.id=cpd.lstatus LEFT JOIN user_detail ON user_detail.id=cpd.storeby where cpd.storeby='$uid'");
        
        return $query->result();
    }
    
    public function task_create($uid,$cpdid,$action_id){
        
        print_r($cpdid);
        $l = sizeof($cpdid);
        
        for($i=0;$i<$l;$i++){
            $query=$this->db->query("SELECT * from cpd where id='$cpdid[$i]'");
            $data = $query->result();
            $lstatus = $data[0]->lstatus;
            $query=$this->db->query("INSERT INTO taskdetail(uid, cpd_id, action_id, lstatus) VALUES ('$uid','$cpdid[$i]','$action_id','$lstatus')");

        }
        
    }
    
    
    public function update_tpbncdbyuid($uid,$tdate){
        
        $query=$this->db->query("UPDATE taskdetail SET plan=null,initiated=null WHERE uid='$uid' and plan is not null and completed is null and cast(plan as DATE)<'$tdate'");
       
    }
    
    public function pending_task_up($uid,$tdate){
        $query=$this->db->query("SELECT count(*) ab,COUNT(CASE WHEN action_id=1 THEN action_id END) a FROM taskdetail WHERE uid='$uid' and plan is null");
        return $query->result();
    }
    
    public function pending_taskd_up($uid,$tdate){
        $query=$this->db->query("SELECT *,taskdetail.id tid FROM taskdetail LEFT JOIN cpd ON cpd.id=taskdetail.cpd_id LEFT JOIN action ON action.id=taskdetail.action_id WHERE uid='$uid' and plan is null");
        return $query->result();
    }
    
    
    public function plantask($taskid,$date,$uid){
        $query=$this->db->query("UPDATE taskdetail SET plan='$date' WHERE id='$taskid'");
    }
    
    
    
    public function pending_task($uid,$tdate){
        $query=$this->db->query("SELECT count(*) ab,COUNT(CASE WHEN action_id=1 THEN action_id END) a FROM taskdetail WHERE uid='$uid' and plan is not null and completed is null");
        return $query->result();
    }
    
    public function pending_taskd($uid,$tdate){
        $query=$this->db->query("SELECT *,taskdetail.id tid FROM taskdetail LEFT JOIN cpd ON cpd.id=taskdetail.cpd_id LEFT JOIN action ON action.id=taskdetail.action_id WHERE uid='$uid' and plan is not null and completed is null");
        return $query->result();
    }
    
    
    
    public function get_cctd($tid){
    $query=$this->db->query("SELECT cpd.*,taskdetail.id tid,cpd.id cid,s1.name,s2.name FROM taskdetail LEFT JOIN cpd ON cpd.id=taskdetail.cpd_id LEFT JOIN action ON action.id=taskdetail.action_id LEFT JOIN status s1 ON s1.id=cpd.lstatus LEFT JOIN status s2 ON s2.id=cpd.cstatus WHERE taskdetail.id='$tid'");
        return $query->result();
    }
     
     
     public function get_adminpopup($ur_id){
        $tdate= date('Y-m-d');
        $data = "";
        
        $query=$this->db->query("SELECT (SELECT count(*) FROM user_details where admin_id='$ur_id' and status='active' and type_id=3) a, COUNT(*) b, COUNT(case when wffo=1 then wffo end) c, COUNT(case when wffo=2 then wffo end) d, COUNT(case when wffo=3 then wffo end) e FROM user_day LEFT JOIN user_details ON user_details.user_id=user_day.user_id WHERE cast(ustart as DATE)='$tdate' and user_details.admin_id='$ur_id'");
        $da = $query->result();
        $da = $da[0]->a - $da[0]->b;
        if($da>0){
        $data = $data."<a href='TeamDetail'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da." BD Not Started Their  Day</b></div><a/>";}
        
        $query=$this->db->query("SELECT count(CASE WHEN nextCFID=0 THEN nextCFID end) b FROM tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and plan=1");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='TeamWork'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Task Pending for Completion</b></div><a/>";}
        
        return $data; 
     }
     
     public function get_bdpopup($ur_id){
        $tdate= date('Y-m-d');
        $data = "";
        
        $query=$this->db->query("SELECT COUNT(*) b WHERE cast(ustart as DATE)='$tdate'");
        $da = $query->result();
        $da = $da[0]->b;
        if($da>0){
        $data = $data."<a href='TeamDetail'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da." BD Not Started Their  Day</b></div><a/>";}
        
        $query=$this->db->query("SELECT count(CASE WHEN nextCFID=0 THEN nextCFID end) b FROM tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and plan=1");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='TeamWork'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Task Pending for Completion</b></div><a/>";}
        
        return $data; 
     }
     
     
     public function add_bdHandover($bdid, $client_name, $mediator, $noofschool, $location, $city, $state, $spd_identify_by, $infrastructure, $filname,$count, $contact_person, $cp_mno, $acontact_person, $acp_mno, $language, $expected_installation_date, $project_tenure,$project_type, $comments,$sname, $saddress, $scity, $sstate, $contact_name, $contact_no,$slanguage,$remark,$fttptype){
        
                if($count>0){
                    $flink="";
                for($i = 0; $i < $count; $i++){
                    $fn = $_FILES['file']['name']     = $_FILES['filname']['name'][$i]; 
                    $_FILES['file']['type']     = $_FILES['filname']['type'][$i]; 
                    $_FILES['file']['tmp_name'] = $_FILES['filname']['tmp_name'][$i]; 
                    $_FILES['file']['error']     = $_FILES['filname']['error'][$i]; 
                    $_FILES['file']['size'] = $_FILES['filname']['size'][$i]; 
                     
                    $uploadPath = 'uploads/logo/'; 
                    $config['upload_path'] = $uploadPath; 
                    $config['allowed_types'] = '*';
                    $config['file_name'] = $fn;
                     
                    $this->load->library('upload', $config); 
                    $this->upload->initialize($config); 
                     
                    if($this->upload->do_upload('file')){
                        $uploadData = $this->upload->data();
                        $filename = $uploadData['file_name'];
                        
                        if($i==0){$flink = $uploadPath.$filename;}
                        else{$flink = $flink.','.$uploadPath.$filename;}
                    }}}
        
        
        
        $db3 = $this->load->database('db3', TRUE);
        $db3->query("INSERT INTO `client_handover` (bd_id,client_name, mediator, noofschool, location, city, state, spd_identify_by, infrastructure, logo, contact_person, cp_mno, acontact_person, acp_mno, language, expected_installation_date, project_tenure,project_type,comments,remark,fttptype) VALUES ('$bdid','$client_name', '$mediator', '$noofschool', '$location', '$city', '$state', '$spd_identify_by', '$infrastructure', '$flink', '$contact_person', '$cp_mno', '$acontact_person', '$acp_mno', '$language', '$expected_installation_date', '$project_tenure', '$project_type', '$comments','$remark','$fttptype')");
        $cid= $db3->insert_id();
        
        $l=sizeof($sname);
        for($i=0;$i<$l;$i++){
            $db3->query("INSERT INTO spd (cid, sname, saddress, sstate, scity,clientname,slanguage) VALUES ('$cid','$sname[$i]','$saddress[$i]','$sstate[$i]','$scity[$i]','$client_name','$slanguage[$i]')");
            $sid =  $db3->insert_id();
            $db3->query("INSERT INTO spd_contact (sid, contact_name, contact_no,main) VALUES ('$sid','$contact_name[$i]','$contact_no[$i]','1')");
        }
        
        $db3->query("INSERT INTO handoverlog (cid, taskby, remark) VALUES ('$cid','1','Handover From BD to Program Manager')");
        return $cid;
    }
    
    
    public function backdrop_ar($id, $val, $rem,$by,$cid,$filname,$count){
        $flink="";
        if($count>0){
        for($i = 0; $i < $count; $i++){
            $fn = $_FILES['file']['name']     = $_FILES['filname']['name'][$i]; 
            $_FILES['file']['type']     = $_FILES['filname']['type'][$i]; 
            $_FILES['file']['tmp_name'] = $_FILES['filname']['tmp_name'][$i]; 
            $_FILES['file']['error']     = $_FILES['filname']['error'][$i]; 
            $_FILES['file']['size'] = $_FILES['filname']['size'][$i]; 
             
            $uploadPath = 'uploads/logo/'; 
            $config['upload_path'] = $uploadPath; 
            $config['allowed_types'] = '*';
            $config['file_name'] = $fn;
             
            $this->load->library('upload', $config); 
            $this->upload->initialize($config); 
             
            if($this->upload->do_upload('file')){
                $uploadData = $this->upload->data();
                $filename = $uploadData['file_name'];
                
                if($i==0){$flink = $uploadPath.$filename;}
                else{$flink = $flink.','.$uploadPath.$filename;}
            }}}
        
        
        
       $db3 = $this->load->database('db3', TRUE);
       if($val=='Reject'){
           $query=$db3->query("update client_handover set apr='$val',remark='$rem',eatch='$flink' WHERE id='$id'");
           $remark='Backdrop Rejected by '.$by;
           $db3->query("INSERT INTO handoverlog(cid, taskby, remark) VALUES ('$cid','$by','$remark')");
       }else{
        $query=$db3->query("update client_handover set apr='$val' WHERE id='$id'");
        $remark='Backdrop Approved by '.$by;
        $db3->query("INSERT INTO handoverlog(cid, taskby, remark) VALUES ('$cid','$by','$remark')");
       }
    }
    
    public function get_handoverforapr(){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("select *,client_handover.id as cid from client_handover LEFT join handover_account on handover_account.handover_id=client_handover.id LEFT join fm_timeline on fm_timeline.handover_id=client_handover.id where client_handover.status is null");
        return $query->result();
    }
    
    
    public function bd_toaccount($btn){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("select * from client_handover where id='$btn'");
        return $query->result();
    }
    
    
    public function add_bdaccount($uid,$handover_id, $wono, $porno, $gstno, $panno,$tbudget, $payterm, $pwosdate, $moudate, $srfinovice, $filname,$count,$bname, $basic, $gst, $total, $oney, $twoy, $threey,$proformadate,$taxinvoicedate){
        
                if($count>0){
                    $flink="";
                for($i = 0; $i < $count; $i++){
                    $fn = $_FILES['file']['name']     = $_FILES['filname']['name'][$i]; 
                    $_FILES['file']['type']     = $_FILES['filname']['type'][$i]; 
                    $_FILES['file']['tmp_name'] = $_FILES['filname']['tmp_name'][$i]; 
                    $_FILES['file']['error']     = $_FILES['filname']['error'][$i]; 
                    $_FILES['file']['size'] = $_FILES['filname']['size'][$i]; 
                     
                    $uploadPath = 'uploads/logo/'; 
                    $config['upload_path'] = $uploadPath; 
                    $config['allowed_types'] = '*';
                    $config['file_name'] = $fn;
                     
                    $this->load->library('upload', $config); 
                    $this->upload->initialize($config); 
                     
                    if($this->upload->do_upload('file')){
                        $uploadData = $this->upload->data();
                        $filename = $uploadData['file_name'];
                        
                        if($i==0){$flink = $uploadPath.$filename;}
                        else{$flink = $flink.','.$uploadPath.$filename;}
                    }}}
        
        
        $db3 = $this->load->database('db3', TRUE);
        $db3->query("INSERT INTO `handover_account` (handover_id, wono, porno, gstno, panno, tbudget, payterm, pwosdate, moudate, srfinovice, mou,proformadate,taxinvoicedate) VALUES ('$handover_id', '$wono', '$porno', '$tbudget', '$gstno', '$panno', '$payterm', '$pwosdate', '$moudate', '$srfinovice', '$flink','$proformadate','$taxinvoicedate')");
        $id = $db3->insert_id();
        $l = sizeof($basic);
        for($i=0;$i<$l;$i++)
        {
            $db3->query("INSERT INTO `budget` (cid, bname, basic, gst, total, oney, twoy, threey) VALUES ('$handover_id','$bname[$i]','$basic[$i]','$gst[$i]','$total[$i]','$oney[$i]','$twoy[$i]','$threey[$i]')");
        }
        $db3->query("INSERT INTO handoverlog (cid, taskby, remark) VALUES ('$handover_id','1','Handover From BD to Account')");
        
        return $id;
    }
    
     
    public function get_tremark($status_id){
        $query=$this->db->query("SELECT * FROM todays_remark WHERE status_id='$status_id'");
        return $query->result();
    }
    
    public function get_talimit($uid,$tdate){
        $query=$this->db->query("SELECT actiontype_id, cast(appointmentdatetime as TIME) time FROM `tblcallevents` WHERE user_id='$uid' and cast(appointmentdatetime as DATE)='$tdate' and nextCFID=0 and plan=1");
        return $query->result();
    }
    
    
    public function get_pcode($cname){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM `client_handover` WHERE client_name='$cname'");
        return $query->result();
    }
    
    public function get_cinfo($pcode){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM `client_handover` WHERE projectcode='$pcode'");
        return $query->result();
    }
    
     
     public function get_utype($uyid){
        $query=$this->db->query("SELECT * FROM user_type WHERE id='$uyid'");
        return $query->result();
     }
     
     public function get_client(){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("select distinct client_name from client_handover");
        return $query->result();
     }
     
     
     public function get_uapstc($uid){
        $query=$this->db->query("SELECT company_master.*,init_call.creator_id FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id left JOIN company_master ON company_master.id=init_call.cmpid_id WHERE tblcallevents.mom!='' and user_details.admin_id='$uid'and init_call.apst is null");
        return $query->result();
     }
     
     public function get_rpbutnotmom(){
        $query=$this->db->query("SELECT company_master.*,init_call.creator_id FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id left JOIN company_master ON company_master.id=init_call.cmpid_id WHERE tblcallevents.mtype='RP' and init_call.apst is null");
        return $query->result();
     }
     
     public function get_cpmadbyu($uyid){
        $query=$this->db->query("SELECT company_master.* FROM company_master JOIN init_call ON init_call.cmpid_id=company_master.id WHERE init_call.creator_id='$uyid' ORDER BY `company_master`.`id`  DESC");
        return $query->result();
     }
     
     public function get_cmpbyinid($inid){
        $query=$this->db->query("SELECT * FROM init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE init_call.id='$inid'");
        return $query->result();
     }
     
     
     public function get_bdpsc($uid){
        $query=$this->db->query("SELECT sum(noofschools) nos,SUM(fbudget) tbud FROM init_call WHERE mainbd='$uid' and cstatus=6");
        return $query->result();
     }
     public function get_bdvpsc($uid){
        $query=$this->db->query("SELECT sum(noofschools) nos,SUM(fbudget) tbud FROM init_call WHERE mainbd='$uid' and cstatus=9");
        return $query->result();
     }
     
     public function get_bdrpd($uid){
        $query=$this->db->query("SELECT COUNT(*) as a, COUNT(case WHEN cstatus=4 THEN cstatus END) as b, COUNT(case WHEN cstatus=5 THEN cstatus END) as c, COUNT(case WHEN cstatus=6 THEN cstatus END) as d, COUNT(case WHEN cstatus=7 THEN cstatus END) as e,COUNT(case WHEN cstatus=9 THEN cstatus END) as f,COUNT(case WHEN cstatus=10 THEN cstatus END) as g,COUNT(case WHEN cstatus=11 THEN cstatus END) as h,COUNT(case WHEN cstatus=12 THEN cstatus END) as i,COUNT(case WHEN cstatus=2 THEN cstatus END) as j,COUNT(case WHEN cstatus=3 THEN cstatus END) as k FROM init_call WHERE apst is not null and mainbd='$uid'");
        return $query->result();
     }
     
     
     public function assign_psttask($compid,$apst){
         $cstatus = 3;
        $query=$this->db->query("UPDATE init_call set apst='$apst',cstatus='$cstatus' WHERE cmpid_id='$compid'");
        $query=$this->db->query("SELECT * FROM init_call WHERE cmpid_id='$compid'");
        $data = $query->result();
        
        $inid = $data[0]->id;
        $date=date('Y-m-d H:i:s');
        
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE cid_id='$inid' ORDER BY id DESC limit 1");
        $data1 = $query->result();
        $tid = $data1[0]->id;
        
        $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, purpose_achieved, fwd_date, actontaken, nextaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type) 
        VALUES ('$tid', '0','no', '$date', 'no', 'Call for Clarity', 'no','$date','1','$apst','$inid','52','','$cstatus','$apst','$date','$date','updated')");
        $this->db->insert_id();
     }
     
     
     public function get_rcreport($sdate,$edate,$user){
        $query=$this->db->query("SELECT COUNT(*) as a, COUNT(case when actiontype_id=1 then actiontype_id end) as b,COUNT(case when actiontype_id=2 then actiontype_id end) as c,COUNT(case when actiontype_id=3 then actiontype_id end) as d,COUNT(case when actiontype_id=4 then actiontype_id end) as e,COUNT(case when actiontype_id=5 then actiontype_id end) as f,COUNT(case when topspender='yes' then topspender end) as g,COUNT(case when topspender='no' then topspender end) as h,COUNT(case when partnerType_id=1 then partnerType_id end) as i,COUNT(case when partnerType_id=2 then partnerType_id end) as j,COUNT(case when partnerType_id=3 then partnerType_id end) as k,COUNT(case when partnerType_id=4 then partnerType_id end) as l,COUNT(case when partnerType_id=5 then partnerType_id end) as m,COUNT(case when partnerType_id=6 then partnerType_id end) as n,COUNT(case when partnerType_id=7 then partnerType_id end) as o,COUNT(case when partnerType_id=8 then partnerType_id end) as p,COUNT(case when partnerType_id=9 then partnerType_id end) as q,COUNT(case when partnerType_id=10 then partnerType_id end) as r,COUNT(case when partnerType_id=11 then partnerType_id end) as s,COUNT(case when partnerType_id=12 then partnerType_id end) as t,COUNT(case when partnerType_id=13 then partnerType_id end) as u,COUNT(case when partnerType_id=14 then partnerType_id end) as v,COUNT(case when partnerType_id=15 then partnerType_id end) as w FROM tblcallevents JOIN init_call ON init_call.id=tblcallevents.cid_id JOIN company_master ON company_master.id=init_call.cmpid_id WHERE user_id='$user' and cast(appointmentdatetime as DATE) BETWEEN '$sdate' AND '$edate' and actontaken='yes'");
        return $query->result();
     }
     
     
     public function get_rpmreport($date){
        $query=$this->db->query("SELECT COUNT(*) as a,count(CASE WHEN zone_id=1 THEN zone_id end) as b,count(CASE WHEN zone_id=2 THEN zone_id end) as c,count(CASE WHEN zone_id=3 THEN zone_id end) as d,count(CASE WHEN zone_id=4 THEN zone_id end) as e,count(CASE WHEN zone_id=5 THEN zone_id end) as f,count(CASE WHEN zone_id=6 THEN zone_id end) as g,count(CASE WHEN zone_id=7 THEN zone_id end) as h,count(CASE WHEN zone_id=8 THEN zone_id end) as i FROM tblcallevents JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE tblcallevents.actiontype_id='3' and tblcallevents.status_id=3 and cast(tblcallevents.appointmentdatetime as DATE)='$date'");
        return $query->result();
     }
     
    public function get_meeting(){
        
        $query=$this->db->query("SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,partner_master.name as partner_type,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id left join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join partner_master on partner_master.id=company_master.partnerType_id join user_details on cr_event.user_id=user_details.user_id where cr_event.meeting_type!='NA' or ( cr_event.status_id=3 and cr_event.nextCFID!='' ) order by cr_event.id desc limit 20");
           return $query->result();
    }
    public function get_proposal(){
        $query=$this->db->query("SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,partner_master.name as partner_type,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id left join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join partner_master on partner_master.id=company_master.partnerType_id join user_details on cr_event.user_id=user_details.user_id limit 50");
        return $query->result();
    }
    
    public function get_scon($uid,$tdate){
        $query=$this->db->query("SELECT tblcallevents.* FROM `tblcallevents` WHERE cast(updateddate as DATE)='$tdate' and nextCFID!=0 and updation_data_type='updated' and lastCFID!=0 and user_id='$uid'");
        return $query->result();
    }
    
    
     public function get_scongg($uid,$tdate,$ab){
        if($uid=='100103'){$uid=45;}
    if($ab==0){$text = "user_details.admin_id='$uid'";}
    if($ab==1){$text = "user_details.user_id='$uid'";}
    $query=$this->db->query("SELECT tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE cast(updateddate as DATE)='$tdate' and nextCFID!=0 and updation_data_type='updated' and lastCFID!=0 and $text");
        return $query->result();
    }
    
    
    
    
    public function get_scong($uid,$tdate,$ab){
        if($uid=='100103'){$uid=45;}
    if($ab==0){$text = "user_details.admin_id='$uid'";}
    if($ab==1){$text = "user_details.user_id='$uid'";}
    $query=$this->db->query("SELECT tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE cast(updateddate as DATE)='$tdate' and nextCFID!=0 and updation_data_type='updated' and lastCFID!=0 and $text");
        return $query->result();
    }
    
    public function get_sconbyadmin($uid,$tdate){
        $query=$this->db->query("SELECT tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE cast(updateddate as DATE)='$tdate' and nextCFID!=0 and updation_data_type='updated' and user_details.admin_id='$uid' and tblcallevents.status_id!=''");
        return $query->result();
    }
    
    
    
    public function get_sconversion($uid,$tdate){
        
        $query=$this->db->query("SELECT DISTINCT cid_id FROM `tblcallevents` WHERE cast(appointmentdatetime as DATE)='$tdate' and user_id='$uid'");
        $data = $query->result();
        $otoor=0;
        $ortor=0;
        $rtot=0;
        $ttop=0;
        $ptovp=0;
        $ptoc=0;
        $vptoc=0;
        $other=0;
        foreach($data as $d){
            $cid = $d->cid_id;
            $query1=$this->db->query("SELECT id,lastCFID, status_id FROM `tblcallevents` WHERE cid_id='$cid' and cast(appointmentdatetime as DATE)='$tdate'");
            $data1 = $query1->result();
            foreach($data1 as $d1){
                $id = $d1->id;
                $query2=$this->db->query("SELECT status_id FROM `tblcallevents` WHERE id='$id'");
                $data2 = $query2->result();
                $query3=$this->db->query("SELECT status_id FROM `tblcallevents` WHERE lastCFID='$id'");
                $data3 = $query3->result();
                if($data2 && $data3){
                $f1 = $data2[0]->status_id;
                $f2 = $data3[0]->status_id;
                if($f1!=$f2){
                    if($f1==1 && $f2==8){$otoor++;}
                    elseif($f1==8 && $f2==2){$ortor++;}
                    elseif($f1==2 && $f2==3){$rtot++;}
                    elseif($f1==3 && $f2==6){$ttop++;}
                    elseif($f1==6 && $f2==9){$ptovp++;}
                    elseif($f1==6 && $f2==7){$ptoc++;}
                    elseif($f1==9 && $f2==7){$vptoc++;}
                    else{$other++;}
                }}
                
            }
        }
        $scdata = array($otoor,$ortor,$rtot,$ttop,$ptovp,$ptoc,$vptoc,$other);
        return $scdata;
    }
    
    
    
    public function get_funnelreport(){
        $query=$this->db->query("SELECT  a.*, (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents t1 JOIN init_call on init_call.id=t1.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE  t1.assignedto_id = a.user_id  and t1.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=t1.cid_id)) as totaltaks      , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I1 JOIN init_call on init_call.id=I1.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I1.assignedto_id = a.user_id and I1.status_id=1 and I1.status_id=1 and I1.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I1.cid_id) ) as open      ,(SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I1 JOIN init_call on init_call.id=I1.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I1.assignedto_id = a.user_id and I1.status_id=8 and I1.status_id=8 and I1.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I1.cid_id)) as open_rpem      , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I2 JOIN init_call on init_call.id=I2.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I2.assignedto_id = a.user_id and I2.status_id=2 and I2.status_id=2 and I2.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I2.cid_id) ) as reachout      , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I3 JOIN init_call on init_call.id=I3.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I3.assignedto_id = a.user_id and I3.status_id=3  and I3.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I3.cid_id) ) as tantative      , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I4 JOIN init_call on init_call.id=I4.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I4.assignedto_id = a.user_id and I4.status_id=4  and I4.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I4.cid_id)  ) as will_do_later, (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I5 JOIN init_call on init_call.id=I5.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I5.assignedto_id = a.user_id and I5.status_id=5 and I5.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I5.cid_id)  ) as not_interested      , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I6 JOIN init_call on init_call.id=I6.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I6.assignedto_id = a.user_id and I6.status_id=6 and I6.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I6.cid_id) ) as positive , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I6 JOIN init_call on init_call.id=I6.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I6.assignedto_id = a.user_id and I6.status_id=9 and I6.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I6.cid_id) ) as very_positive      , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I7 JOIN init_call on init_call.id=I7.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I7.assignedto_id = a.user_id and I7.status_id=6 and I7.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I7.cid_id)  ) as closure FROM user_details a where a.status='active'");
        return $query->result();
    }
    
    public function get_status(){
        $query=$this->db->query("SELECT * FROM status");
        return $query->result();
    }
    
    public function get_bmmombyu($uid){
        $query=$this->db->query("SELECT company_master.compname,init_call.cmpid_id,tblcallevents.id FROM tblcallevents JOIN init_call ON init_call.id=tblcallevents.cid_id JOIN company_master ON init_call.cmpid_id=company_master.id WHERE actiontype_id='4' and user_id='$uid' GROUP BY company_master.compname,init_call.cmpid_id,tblcallevents.id");
        return $query->result();
    }
    
    
    public function get_partner(){
        $query=$this->db->query("SELECT * FROM partner_master");
        return $query->result();
    }
    
    
    public function get_partnerbyid($pid){
        $query=$this->db->query("SELECT * FROM partner_master where id='$pid'");
        return $query->result();
    }
    
    
    
    
    public function get_states(){
        $query=$this->db->query("SELECT * FROM states");
        return $query->result();
    }
    
    public function get_citybyst($stid){
        $query=$this->db->query("SELECT * FROM city where state_id='$stid'");
        return $query->result();
    }
    
    public function get_citybystname($stid){
        $query=$this->db->query("SELECT * FROM city LEFT JOIN states on states.id=city.state_id WHERE states.state='$stid'");
        return $query->result();
    }
    
    
    public function get_citybyid($city){
        $query=$this->db->query("SELECT * FROM city where id='$city'");
        $data = $query->result();
        return $data[0]->city;
    }
    
    public function get_statebyid($state){
        $query=$this->db->query("SELECT * FROM states where id='$state'");
        $data = $query->result();
        return $data[0]->state;
    }
    
    public function get_countrybyid($country){
        $query=$this->db->query("SELECT * FROM country_db where id='$country'");
        $data = $query->result();
        return $data[0]->name;
    }
    
    
    public function get_remarkbys($sid){
        $query=$this->db->query("SELECT * FROM todays_remark where status_id='$sid'");
        return $query->result();
    }
    
    public function get_purposebya($aid,$sid){
        $query=$this->db->query("SELECT * FROM purpose where action_id='$aid' and status_id='$sid'");
        return $query->result();
    }
    
    
    public function change_norp($tid){
        $query=$this->db->query("update tblcallevents set mtype='NO RP' where id='$tid'");
        $data = $this->Menu_model->get_tbldata($tid);
        $cid = $data[0]->cid_id;
        $query=$this->db->query("update init_call set apst=null,bpst=null where id='$cid'");
        return $query->result();
    }
    
    public function set_keycompny($cmpid){
        $query=$this->db->query("Update init_call set keycompany='yes' where cmpid_id='$cmpid'");
        return $query->result();
    }
    
    public function get_purposebyid($id){
        $query=$this->db->query("SELECT * FROM purpose where id='$id'");
        return $query->result();
    }
    
    public function get_nextactionbyp($pid){
        $query=$this->db->query("SELECT * FROM next_action where purpose_id='$pid'");
        return $query->result();
    }
    
    public function get_company(){
        $query=$this->db->query("SELECT * FROM company_master limit 250");
        return $query->result();
    }
    
    
    public function get_cdbyid($cid){
        $query=$this->db->query("SELECT * FROM company_master WHERE id='$cid'");
        return $query->result();
    }
    
    public function get_cdbypst($pst){
        $query=$this->db->query("SELECT company_master.*,init_call.cstatus,init_call.mainbd FROM init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE init_call.apst='$pst'");
        return $query->result();
    }
    
    
    public function get_cdbyinBD($pst){
        $query=$this->db->query("SELECT company_master.*,init_call.cstatus,init_call.mainbd FROM init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN tblcallevents ON tblcallevents.cid_id=init_call.id WHERE init_call.mainbd='$pst' and tblcallevents.user_id='$pst' and tblcallevents.actiontype_id='4' and tblcallevents.nextCFID=0");
        return $query->result();
    }
    
    
    public function get_cdbyBD($pst){
        $query=$this->db->query("SELECT company_master.*,init_call.cstatus,init_call.mainbd FROM init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE init_call.mainbd='$pst'");
        return $query->result();
    }
    
    
    public function get_cpst($fopst,$topst,$cid){
        $l = sizeof($cid);
        for($i=0;$i<$l;$i++){
            $cmpid = $cid[$i];
            $query=$this->db->query("SELECT * FROM init_call WHERE cmpid_id='$cmpid'");
            $data =  $query->result();
            $inid = $data[0]->id;
            $query=$this->db->query("update tblcallevents set assignedto_id='$topst',user_id='$topst' WHERE cid_id='$inid' and assignedto_id='$fopst' and nextCFID='0' and plan=0");
            $query=$this->db->query("update init_call set apst='$topst' WHERE cmpid_id='$cmpid'");     
            
        }
    }
    
    
    
    public function get_cbdtf($fopst,$topst,$cid){
        $l = sizeof($cid);
        for($i=0;$i<$l;$i++){
            $cmpid = $cid[$i];
            $query=$this->db->query("SELECT * FROM init_call WHERE cmpid_id='$cmpid'");
            $data =  $query->result();
            $inid = $data[0]->id;
            $query=$this->db->query("update tblcallevents set assignedto_id='$topst',user_id='$topst' WHERE cid_id='$inid' and assignedto_id='$fopst' and nextCFID='0'");
            $query=$this->db->query("update init_call set mainbd='$topst' WHERE cmpid_id='$cmpid'");  
            $query=$this->db->query("update barginmeeting set user_id='$topst' WHERE inid='$inid'");
            
        }
    }
    
    
    public function get_cdbyidwin($cid){
        $query=$this->db->query("SELECT * FROM company_master LEFT JOIN init_call ON init_call.cmpid_id=company_master.id LEFT JOIN company_contact_master ON company_contact_master.company_id=company_master.id WHERE company_master.id='$cid' and company_contact_master.type='primary'");
        return $query->result();
    }
    
    public function get_ccdbyid($cid){
        $query=$this->db->query("SELECT * FROM company_contact_master WHERE company_id='$cid' and type='primary'");
        return $query->result();
    }
    
    public function get_ccdbypid($cid){
        $query=$this->db->query("SELECT * FROM company_contact_master WHERE company_id='$cid'");
        return $query->result();
    }
    
    public function get_contactbyid($id){
        $query=$this->db->query("SELECT * FROM company_contact_master WHERE id='$id'");
        return $query->result();
    }
    
    public function get_setccid($setid,$cid){
        $query=$this->db->query("update company_contact_master set type='alternate' WHERE company_id='$cid'");
        $query=$this->db->query("update company_contact_master set type='primary' WHERE id='$setid'");
    }
    
    public function get_editccid($id,$designation,$emailid){
        $query=$this->db->query("update company_contact_master set designation='$designation',emailid='$emailid' WHERE id='$id'");
    }
    
    public function get_ucompany($state,$city,$cid,$address,$website,$partnertype,$budget){
        $query=$this->db->query("update company_master set budget='$budget',city='$city', state='$state',website='$website',address='$address',partnerType_id='$partnertype' WHERE id='$cid'");
    }
    
    public function get_initcallbyid($cid){
        $query=$this->db->query("SELECT * FROM init_call WHERE cmpid_id='$cid'");
        return $query->result();
    }
    
    
    public function get_initbyid($initid){
        $query=$this->db->query("SELECT * FROM init_call WHERE id='$initid'");
        return $query->result();
    }
    
    
    public function get_pstc($uid){
        $query=$this->db->query("SELECT COUNT(*) a,COUNT(CASE WHEN cstatus=1 THEN cstatus END) b,COUNT(CASE WHEN cstatus=2 THEN cstatus END) c,COUNT(CASE WHEN cstatus=3 THEN cstatus END) d,COUNT(CASE WHEN cstatus=4 THEN cstatus END) e,COUNT(CASE WHEN cstatus=5 THEN cstatus END) f,COUNT(CASE WHEN cstatus=6 THEN cstatus END) g,COUNT(CASE WHEN cstatus=7 THEN cstatus END) h,COUNT(CASE WHEN cstatus=8 THEN cstatus END) i,COUNT(CASE WHEN cstatus=9 THEN cstatus END) j,COUNT(CASE WHEN cstatus=10 THEN cstatus END) k,COUNT(CASE WHEN cstatus=11 THEN cstatus END) l,COUNT(CASE WHEN focus_funnel='yes' THEN focus_funnel END) m,COUNT(CASE WHEN upsell_client='yes' THEN upsell_client END) n,COUNT(CASE WHEN cstatus=12 THEN cstatus END) o,COUNT(CASE WHEN cstatus=13 THEN cstatus END) p, COUNT(CASE WHEN keycompany='yes' THEN keycompany END) q FROM init_call WHERE apst='$uid'");
        return $query->result();
    }
    
    
    
    public function get_apstc($uid){
        $query=$this->db->query("SELECT COUNT(*) a,COUNT(CASE WHEN cstatus=1 THEN cstatus END) b,COUNT(CASE WHEN cstatus=2 THEN cstatus END) c,COUNT(CASE WHEN cstatus=3 THEN cstatus END) d,COUNT(CASE WHEN cstatus=4 THEN cstatus END) e,COUNT(CASE WHEN cstatus=5 THEN cstatus END) f,COUNT(CASE WHEN cstatus=6 THEN cstatus END) g,COUNT(CASE WHEN cstatus=7 THEN cstatus END) h,COUNT(CASE WHEN cstatus=8 THEN cstatus END) i,COUNT(CASE WHEN cstatus=9 THEN cstatus END) j,COUNT(CASE WHEN cstatus=10 THEN cstatus END) k,COUNT(CASE WHEN cstatus=11 THEN cstatus END) l,COUNT(CASE WHEN focus_funnel='yes' THEN focus_funnel END) m,COUNT(CASE WHEN upsell_client='yes' THEN upsell_client END) n,COUNT(CASE WHEN cstatus=12 THEN cstatus END) o,COUNT(CASE WHEN cstatus=13 THEN cstatus END) p, COUNT(CASE WHEN keycompany='yes' THEN keycompany END) q FROM init_call LEFT JOIN user_details ON user_details.user_id=init_call.apst WHERE user_details.admin_id='$uid'");
        return $query->result();
    }
    
    public function get_fannal($uid){
        $query=$this->db->query("SELECT * FROM init_call JOIN company_master on company_master.id=init_call.cmpid_id WHERE creator_id='$uid'");
        return $query->result();
    }
    
    public function get_cdbyinid($inid){
        $query=$this->db->query("SELECT * FROM init_call JOIN company_master on company_master.id=init_call.cmpid_id WHERE init_call.id='$inid'");
        return $query->result();
    }
    
    
    public function get_initcom($cid){
        $query=$this->db->query("SELECT * FROM init_call JOIN company_master on company_master.id=init_call.cmpid_id WHERE init_call.cmpid_id='$cid'");
        return $query->result();
    }
    
    public function get_handover($uid){
        $db3 = $this->load->database('db3', TRUE);
        $query = $db3->query("SELECT * FROM `client_handover` WHERE bd_id='$uid'");
        return $query->result();
    }
    
    public function get_handoverbyadmin(){
        $db3 = $this->load->database('db3', TRUE);
        $query = $db3->query("SELECT * FROM `client_handover`");
        return $query->result();
    }
    
    public function get_utibypc($pcode){
        $db3 = $this->load->database('db3', TRUE);
        $query = $db3->query("SELECT date FROM `wgdata` WHERE project_code='$pcode' GROUP by date");
        return $query->result();
    }
    
    public function get_spd($pcode){
        $db3 = $this->load->database('db3', TRUE);
        $query = $db3->query("SELECT * FROM `spd` WHERE project_code='$pcode'");
        return $query->result();
    }
    
    public function get_spdbypc($cid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("select * from spd where cid='$cid'");
        return $query->result();
    }
    
    public function get_clientbyid($id){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("select * from client_handover where id='$id'");
        return $query->result();
    }
    
    public function get_clientacbyid($id){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("select * from handover_account where cid='$id'");
        return $query->result();
    }
    
    public function get_user_byid($id){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("select * from user_detail where id='$id'");
        return $query->result();
    }
    
    public function get_schoollogs($sid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM schoollogs WHERE sid='$sid' ORDER BY id DESC");
        return $query->result();
    }
    
    public function get_sstatusbyid($id){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT name FROM `status` where id='$id'");
        return $query->result();
    }
    
    public function get_wgbytid($pcode){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM wgdata WHERE project_code='$pcode'");
        return $query->result();
    }
    
    public function get_report($pcode){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM report WHERE project_code='$pcode'");
        return $query->result();
    }
    
    public function get_handoverlog($cid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT *,(SELECT max(sdatet) FROM handoverlog where cid='$cid') ltdate FROM handoverlog where cid='$cid'");
        return $query->result();
     }
     
     public function get_lasthlog($cid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM handoverlog where id=(SELECT max(id) FROM handoverlog where cid='$cid')");
        return $query->result();
     }
    
    public function timediff($time1,$time2){
        
        $t1=date_create($time1);
        $t2=date_create($time2);
        
        $diff=date_diff($t1,$t2);
        $d= $diff->format("%d day");
        $m= $diff->format("%m month");
        $y= $diff->format("%y year");
        $h= $diff->format("%h hours");
        $i= $diff->format("%i min");
        $s= $diff->format("%s sec");
        
        $dtc='';
        $flag = false;
        if($diff->format('%y') != 0) {
            $dtc= $diff->format('%y years');
            $flag= true;
        }
        if($diff->format('%m') != 0) {
            $dtc=$dtc.' '.$diff->format('%m months');
            $flag= true;
        }
        if($diff->format('%d') != 0) {
            $dtc=$dtc.' '.$diff->format('%d day');
            $flag= true;
        }
        if($diff->format('%h') != 0) {
            $dtc=$dtc.' '.$diff->format('%h hours');
            $flag= true;
        }
        if($diff->format('%i') != 0) {
            $dtc=$dtc.' '.$diff->format('%i min');
            $flag= true;
        }
        if($diff->format('%s') != 0) {
            $dtc=$dtc.' '.$diff->format('%s sec');
            $flag= true;
        }
        if($dtc==''){$dtc=0;}
        
        return $dtc;
  
    }
    
    
    public function get_initcallbyiid($cid){
        $query=$this->db->query("SELECT * FROM init_call WHERE id='$cid'");
        return $query->result();
    }
    
    
    public function get_cdetail($iniid){
        $query=$this->db->query("SELECT * FROM init_call JOIN company_master ON company_master.id=init_call.cmpid_id WHERE init_call.id='$iniid'");
        return $query->result();
    }
    
    
    public function get_tblcalleventsbyid($ciid){
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE cid_id='$ciid' and cast(updateddate as DATE)>'2022-03-31' ORDER BY tblcallevents.id DESC");
        return $query->result();
    }
    
    public function get_tblcbyidwr($ciid){
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE cid_id='$ciid' and cast(updateddate as DATE)>'2022-03-31' and remarks!='' ORDER BY tblcallevents.id DESC");
        return $query->result();
    }
    
    public function get_tblbyid($ciid){
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE cid_id='$ciid' and nextCFID!=0 and cast(updateddate as DATE)>'2022-03-31' ORDER BY tblcallevents.id DESC");
        return $query->result();
    }
    
    
    public function get_tblbyidwithremark($ciid){
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE cid_id='$ciid' and remarks!='' ORDER BY tblcallevents.updateddate DESC");
        return $query->result();
    }
    
    
    public function get_tblbyidafterpst($ciid,$tminid){
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE cid_id='$ciid' and nextCFID!=0 and id>'$tminid' ORDER BY tblcallevents.id DESC");
        return $query->result();
    }
    
    public function get_user(){
        $query=$this->db->query("SELECT * FROM user_details");
        return $query->result();
    }
    
    
    
    public function get_userbyaid($uid){
        $query=$this->db->query("SELECT * FROM user_details WHERE admin_id='$uid' and status='active' and type_id=3");
        return $query->result();
    }
    
    
    public function get_pstbyaid($uid){
        $query=$this->db->query("SELECT * FROM user_details WHERE admin_id='$uid' and status='active' and type_id=4");
        return $query->result();
    }
    
    
    
    public function get_statusbyid($sid){
        $query=$this->db->query("SELECT * FROM status WHERE id='$sid'");
        return $query->result();
    }
    
    
    
    public function add_dremark($cid,$pstuid,$dremark){
        
        $query=$this->db->query("update company_master set drequest=1,dremark='$dremark',rby='$pstuid' WHERE id='$cid'");
        
    }
    
    
    public function set_kcomp($cid,$kcdate,$kcremark){
        
        $query=$this->db->query("Update init_call set keycompany='yes',kcremark='$kcremark',kcdate='$kcdate' where cmpid_id='$cid'");
        
    }
    
    public function add_csbchange($cid,$sno,$budget){
        
        $query=$this->db->query("update init_call set noofschools='$sno',fbudget='$budget' WHERE cmpid_id='$cid'");
        
    }
    
    
    public function add_rremark($cid,$bdid,$remark,$ntdate,$ntaction,$ntppose,$pstuid){
        
        date_default_timezone_set("Asia/Kolkata");
        $date = date('Y-m-d H:i:s');
        
        $data = $this->Menu_model->get_initcallbyid($cid);
        $inid = $data[0]->id;
        $cs = $data[0]->cstatus;
        
        $query=$this->db->query("select MAX(id) mid from tblcallevents where cid_id='$inid'");
        $data1= $query->result();
        $lid = $data1[0]->mid;
        
        $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, purpose_achieved, fwd_date, actontaken, nextaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type,plan) 
                            VALUES ('$lid', '0','yes', '$date', 'yes', '', 'no','$date','8','$pstuid','$inid','66','$remark','$cs','$pstuid','$date','$date','updated', 1)");
        $psttid = $this->db->insert_id();
        
        $query=$this->db->query("update tblcallevents set nextCFID='$psttid' WHERE id='$lid'");
        
        $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, purpose_achieved, fwd_date, actontaken, nextaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, status_id, user_id, date, updateddate, updation_data_type,plan) 
                            VALUES ('$psttid', '0','no', '$ntdate', 'no', '', 'no','$ntdate','$ntaction','$bdid','$inid','$ntppose','$cs','$bdid','$ntdate','$ntdate','updated', 1)");
        $ntid = $this->db->insert_id();
        
        $query=$this->db->query("update tblcallevents set nextCFID='$ntid' WHERE id='$psttid'");
    }
    
    
    
    public function edit_cmp($cid,$state,$city,$address,$website){
        
        if($address!=''){
            if($website!=''){
                $query=$this->db->query("update company_master set state='$state',city='$city',address='$address',website='$website' WHERE id='$cid'");
                return $cid;
            }
            $query=$this->db->query("update company_master set state='$state',city='$city',address='$address' WHERE id='$cid'");
            return $cid;
        }
        elseif($website!=''){
            $query=$this->db->query("update company_master set state='$state',city='$city',website='$website' WHERE id='$cid'");
            return $cid;
        }else{
            $query=$this->db->query("update company_master set state='$state',city='$city' WHERE id='$cid'");
            return $cid;
        }
        
        
    }
    
    
        
    public function manage_user($user_id,$name,$username,$password,$email,$phoneno,$active){
        $query=$this->db->query("update user_details set name='$name',username='$username',password='$password',email='$email',phoneno='$phoneno',status='$active' WHERE user_id='$user_id'");
    }
    
    
    public function get_synopsis(){
        $query=$this->db->query("SELECT * FROM tblcallevents limit 50");
        return $query->result();
    }
    
    public function get_conversion(){
        $query=$this->db->query("SELECT * FROM tblcallevents limit 50");
        return $query->result();
    }
    
    public function get_cidbyuid($uid){
        $query=$this->db->query("SELECT DISTINCT cid_id FROM `tblcallevents` WHERE user_id='$uid'");
        return $query->result();
    }
    
    public function get_bdtcom($uid){
        $userd = $this->Menu_model->get_userbyid($uid);
        $utid = $userd[0]->type_id;
        
        if($utid==2){
            $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid'");
            return $query->result();
        }else{
            $query=$this->db->query("SELECT cmpid_id FROM init_call where mainbd='$uid'");
            return $query->result();
        }
        
    }
    
    
    public function get_pstassignc($apst){
            $query=$this->db->query("SELECT *,init_call.id as inid FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where init_call.apst='$apst'");
            return $query->result();
    }
    
    
    public function get_pstassigndate($ciid,$sd){
        
        $query=$this->db->query("SELECT * FROM tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.user_id where user_details.type_id=4 and cid_id='$ciid' and cast(appointmentdatetime as DATE)='$sd' ORDER BY `tblcallevents`.`appointmentdatetime` ASC limit 1");
        return $query->result();
        
    }
    
    
    
    public function get_noworkc($cid,$sd,$ed){
            $query=$this->db->query("SELECT * FROM tblcallevents WHERE cid_id='$cid' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed'");
            return $query->result(); 
    }
    
    
    public function get_noworkcbystatus($cid,$status,$sd,$ed){
            $query=$this->db->query("SELECT * FROM tblcallevents WHERE cid_id='$cid' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed'");
            return $query->result(); 
    }
    
    
    
    
    public function get_pbdtcom($uid){
        $query=$this->db->query("SELECT cmpid_id FROM init_call where apst='$uid' ");
        return $query->result();
    }
    
    
    public function get_cmpbybd($uid){
        $query=$this->db->query("SELECT company_master.* FROM init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE mainbd='$uid'");
        return $query->result();
    }
    
    
    public function get_mbdc($uid){
        $query=$this->db->query("SELECT COUNT(*) a,COUNT(CASE WHEN cstatus=1 THEN cstatus END) b,COUNT(CASE WHEN cstatus=2 THEN cstatus END) c,COUNT(CASE WHEN cstatus=3 THEN cstatus END) d,COUNT(CASE WHEN cstatus=4 THEN cstatus END) e,COUNT(CASE WHEN cstatus=5 THEN cstatus END) f,COUNT(CASE WHEN cstatus=6 THEN cstatus END) g,COUNT(CASE WHEN cstatus=7 THEN cstatus END) h,COUNT(CASE WHEN cstatus=8 THEN cstatus END) i,COUNT(CASE WHEN cstatus=9 THEN cstatus END) j,COUNT(CASE WHEN cstatus=10 THEN cstatus END) k,COUNT(CASE WHEN cstatus=11 THEN cstatus END) l,COUNT(CASE WHEN focus_funnel='yes' THEN focus_funnel END) m,COUNT(CASE WHEN upsell_client='yes' THEN upsell_client END) n,COUNT(CASE WHEN cstatus=12 THEN cstatus END) o,COUNT(CASE WHEN cstatus=13 THEN cstatus END) p, COUNT(CASE WHEN keycompany='yes' THEN keycompany END) q FROM init_call WHERE mainbd='$uid'");
        return $query->result();
    }
    
    
    public function get_mbpstc($uid){
        $query=$this->db->query("SELECT COUNT(*) a,COUNT(CASE WHEN cstatus=1 THEN cstatus END) b,COUNT(CASE WHEN cstatus=2 THEN cstatus END) c,COUNT(CASE WHEN cstatus=3 THEN cstatus END) d,COUNT(CASE WHEN cstatus=4 THEN cstatus END) e,COUNT(CASE WHEN cstatus=5 THEN cstatus END) f,COUNT(CASE WHEN cstatus=6 THEN cstatus END) g,COUNT(CASE WHEN cstatus=7 THEN cstatus END) h,COUNT(CASE WHEN cstatus=8 THEN cstatus END) i,COUNT(CASE WHEN cstatus=9 THEN cstatus END) j,COUNT(CASE WHEN cstatus=10 THEN cstatus END) k,COUNT(CASE WHEN cstatus=11 THEN cstatus END) l,COUNT(CASE WHEN focus_funnel='yes' THEN focus_funnel END) m, COUNT(CASE WHEN upsell_client='yes' THEN upsell_client END) n,COUNT(CASE WHEN exbd is not null THEN upsell_client END) o FROM init_call WHERE mainbd='$uid' and apst is not null");
        return $query->result();
    }
    
    
    public function get_mbdcbyaid($uid){
        $query=$this->db->query("SELECT COUNT(*) a,COUNT(CASE WHEN cstatus=1 THEN cstatus END) b,COUNT(CASE WHEN cstatus=2 THEN cstatus END) c,COUNT(CASE WHEN cstatus=3 THEN cstatus END) d,COUNT(CASE WHEN cstatus=4 THEN cstatus END) e,COUNT(CASE WHEN cstatus=5 THEN cstatus END) f,COUNT(CASE WHEN cstatus=6 THEN cstatus END) g,COUNT(CASE WHEN cstatus=7 THEN cstatus END) h,COUNT(CASE WHEN cstatus=8 THEN cstatus END) i,COUNT(CASE WHEN cstatus=9 THEN cstatus END) j,COUNT(CASE WHEN cstatus=10 THEN cstatus END) k,COUNT(CASE WHEN cstatus=11 THEN cstatus END) l,COUNT(CASE WHEN focus_funnel='yes' THEN focus_funnel END) m, COUNT(CASE WHEN upsell_client='yes' THEN upsell_client END) n,COUNT(CASE WHEN exbd is not null THEN upsell_client END) o FROM init_call LEFT JOIN user_details ON user_details.user_id=mainbd WHERE user_details.admin_id='$uid' and user_details.status='active' ");
        return $query->result();
    }
    
    public function get_bdeffi($uid,$tdate,$s){
         $tdate = strtotime($tdate);
         $ldate = strtotime("-15 day", $tdate);
         $ldate = date('Y-m-d', $ldate);
        $j=0;
        $query=$this->db->query("SELECT * FROM init_call WHERE mainbd='$uid'");
        $data = $query->result();
        foreach($data as $d){
            $cid = $d->cmpid_id;
            $inid = $d->id;
            $query=$this->db->query("SELECT * FROM tblcallevents WHERE status_id='$s' and cid_id='$inid' and cast(updateddate as DATE)>'$ldate' ORDER BY id DESC limit 1");
            $data2 = $query->result();
            if($data2){$j++;}
        }
        return $j;
    }
    
    
    public function get_psteffi($uid,$tdate,$s){
         $tdate = strtotime($tdate);
         $ldate = strtotime("-15 day", $tdate);
         $ldate = date('Y-m-d', $ldate);
        $j=0;
        $query=$this->db->query("SELECT * FROM init_call WHERE apst='$uid'");
        $data = $query->result();
        foreach($data as $d){
            $cid = $d->cmpid_id;
            $inid = $d->id;
            $query=$this->db->query("SELECT * FROM tblcallevents WHERE status_id='$s' and cid_id='$inid' and cast(updateddate as DATE)>'$ldate' ORDER BY id DESC limit 1");
            $data2 = $query->result();
            if($data2){$j++;}
        }
        return $j;
    }
    
    public function get_bdeffida($uid,$tdate,$s){
         $tdate = strtotime($tdate);
         $ldate = strtotime("-15 day", $tdate);
         $ldate = date('Y-m-d', $ldate);
        $da;
        $query=$this->db->query("SELECT * FROM init_call WHERE mainbd='$uid'");
        $data = $query->result();
        foreach($data as $d){
            $cid = $d->cmpid_id;
            $inid = $d->id;
            $query=$this->db->query("SELECT * FROM tblcallevents WHERE status_id='$s' and cid_id='$inid' and user_id='$uid' and cast(updateddate as DATE)>'$ldate' ORDER BY id DESC limit 1");
            $data2 = $query->result();
            if($data2){$da[]=$inid;}
        }
        return $da;
    }
    
    
    public function get_psteffida($uid,$tdate,$s){
        $tdate = strtotime($tdate);
        $ldate = strtotime("-15 day", $tdate);
        $ldate = date('Y-m-d', $ldate);
        $da;
        $query=$this->db->query("SELECT * FROM init_call WHERE apst='$uid'");
        $data = $query->result();
        foreach($data as $d){
            $cid = $d->cmpid_id;
            $inid = $d->id;
            $query=$this->db->query("SELECT * FROM tblcallevents WHERE status_id='$s' and cid_id='$inid' and user_id='$uid' and cast(updateddate as DATE)>'$ldate' ORDER BY id DESC limit 1");
            $data2 = $query->result();
            if($data2){$da[]=$inid;}
        }
        return $da;
    }
    
    
    public function get_bdcombystatus($uid,$sid){
        if($uid=='100103' || $uid=='100114' || $uid=='100115'){$uid=45;}
        $userd = $this->Menu_model->get_userbyid($uid);
        $utid = $userd[0]->type_id;
        
        if($utid==2){
            
            if($sid==14){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active' and focus_funnel='yes'");
            }elseif($sid==15){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active' and upsell_client='yes'");
            }elseif($sid==16){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active' and keycompany='yes'");
            }else{
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active' and init_call.cstatus='$sid'");
            }
            return $query->result();
            
        }else{
            if($sid==14){
            $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where mainbd= '$uid' and focus_funnel='yes'");
            }elseif($sid==15){
                $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where mainbd= '$uid' and upsell_client='yes'");
            }elseif($sid==16){
                $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where mainbd= '$uid' and keycompany='yes'");
            }else{
            $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where mainbd= '$uid' and cstatus='$sid'");
            }
            return $query->result();
        } 
    }
    
    public function get_pbdcombystatus($uid,$sid){
        
        if($sid==14){
            $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where apst= '$uid' and focus_funnel='yes'");
        }elseif($sid==15){
            $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where apst= '$uid' and upsell_client='yes'");
        }elseif($sid==16){
            $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where apst= '$uid' and keycompany='yes'");
        }else{
        $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where apst= '$uid' and cstatus='$sid'");
        }
        return $query->result();
    }
    
    public function get_freport($uid){
        $query=$this->db->query("SELECT  a.*, (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents t1 JOIN init_call on init_call.id=t1.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE  t1.assignedto_id = a.user_id  and t1.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=t1.cid_id)) as totaltaks, (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I1 JOIN init_call on init_call.id=I1.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I1.assignedto_id = a.user_id and I1.status_id=1 and I1.status_id=1 and I1.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I1.cid_id) ) as open      ,(SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I1 JOIN init_call on init_call.id=I1.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I1.assignedto_id = a.user_id and I1.status_id=8 and I1.status_id=8 and I1.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I1.cid_id)) as open_rpem, (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I2 JOIN init_call on init_call.id=I2.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I2.assignedto_id = a.user_id and I2.status_id=2 and I2.status_id=2 and I2.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I2.cid_id) ) as reachout, (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I3 JOIN init_call on init_call.id=I3.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I3.assignedto_id = a.user_id and I3.status_id=3  and I3.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I3.cid_id) ) as tantative, (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I4 JOIN init_call on init_call.id=I4.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I4.assignedto_id = a.user_id and I4.status_id=4  and I4.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I4.cid_id)  ) as will_do_later, (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I5 JOIN init_call on init_call.id=I5.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I5.assignedto_id = a.user_id and I5.status_id=5 and I5.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I5.cid_id)  ) as not_interested, (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I6 JOIN init_call on init_call.id=I6.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I6.assignedto_id = a.user_id and I6.status_id=6 and I6.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I6.cid_id) ) as positive , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I6 JOIN init_call on init_call.id=I6.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I6.assignedto_id = a.user_id and I6.status_id=9 and I6.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I6.cid_id) ) as very_positive, (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I7 JOIN init_call on init_call.id=I7.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I7.assignedto_id = a.user_id and I7.status_id=7 and I7.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I7.cid_id)) as closure FROM user_details a where a.status='active' and a.user_id='$uid'");
        return $query->result();
    }
    
    
    public function get_pstfreport($uid){
        $query=$this->db->query("SELECT  a.*, (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents t1 JOIN init_call on init_call.id=t1.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE  t1.assignedto_id = a.user_id  and t1.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=t1.cid_id)) as totaltaks, (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I1 JOIN init_call on init_call.id=I1.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I1.assignedto_id = a.user_id and I1.status_id=1 and I1.status_id=1 and I1.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I1.cid_id) ) as open      ,(SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I1 JOIN init_call on init_call.id=I1.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I1.assignedto_id = a.user_id and I1.status_id=8 and I1.status_id=8 and I1.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I1.cid_id)) as open_rpem, (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I2 JOIN init_call on init_call.id=I2.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I2.assignedto_id = a.user_id and I2.status_id=2 and I2.status_id=2 and I2.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I2.cid_id) ) as reachout, (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I3 JOIN init_call on init_call.id=I3.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I3.assignedto_id = a.user_id and I3.status_id=3  and I3.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I3.cid_id) ) as tantative, (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I4 JOIN init_call on init_call.id=I4.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I4.assignedto_id = a.user_id and I4.status_id=4  and I4.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I4.cid_id)  ) as will_do_later, (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I5 JOIN init_call on init_call.id=I5.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I5.assignedto_id = a.user_id and I5.status_id=5 and I5.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I5.cid_id)  ) as not_interested, (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I6 JOIN init_call on init_call.id=I6.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I6.assignedto_id = a.user_id and I6.status_id=6 and I6.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I6.cid_id) ) as positive , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I6 JOIN init_call on init_call.id=I6.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I6.assignedto_id = a.user_id and I6.status_id=9 and I6.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I6.cid_id) ) as very_positive, (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I7 JOIN init_call on init_call.id=I7.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I7.assignedto_id = a.user_id and I7.status_id=7 and I7.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I7.cid_id)) as closure FROM user_details a where a.status='active' and a.user_id='$uid'");
        return $query->result();
    }
    
    public function get_tptask($uid){
        $cdate = date('Y-m-d');
        $query=$this->db->query("SELECT COUNT(*) as a, count(CASE WHEN actiontype_id=1 THEN actiontype_id end) as b,count(CASE WHEN actiontype_id=2 THEN actiontype_id end) as c,count(CASE WHEN actiontype_id=3 THEN actiontype_id end) as d,count(CASE WHEN actiontype_id=4 THEN actiontype_id end) as e,count(CASE WHEN actiontype_id=5 THEN actiontype_id end) as f FROM `tblcallevents` join init_call on tblcallevents.cid_id=init_call.id join company_master on init_call.cmpid_id=company_master.id join company_contact_master on company_contact_master.company_id=company_master.id join partner_master on company_master.partnerType_id=partner_master.id join user_details on tblcallevents.assignedto_id=user_details.user_id WHERE date(appointmentdatetime) < '$cdate' and tblcallevents.id=(select MAX(id) from tblcallevents t1 WHERE t1.cid_id=tblcallevents.cid_id) and assignedto_id='$uid' and actiontype_id !=4");
        return $query->result();
    }
    
    
    public function create_bmeeting($uid,$bcytpe,$bcid,$bmdate,$bstate,$bcity){
        if($bcytpe=='From Funnel'){
            $data = $this->Menu_model->get_initcallbyid($bcid);
            $inid = $data[0]->id;
            $cstatus = $data[0]->cstatus;
            
            $data2 = $this->Menu_model->get_ccdbyid($bcid);
            $ccid = $data2[0]->id;
            
            $query=$this->db->query("SELECT MAX(id) mid FROM `tblcallevents` WHERE cid_id='$inid'");
            $data1 = $query->result();
            $ltid = $data1[0]->mid;
            
            $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, purpose_achieved, fwd_date, actontaken, nextaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type,plan) VALUES ('$ltid', '0','no', '$bmdate', 'no', 'Will Collect Data by RP Meeting', 'no','$bmdate','4','$uid','$inid','66','Will Collect Data by RP Meeting','$cstatus','$uid','$bmdate','$bmdate','updated',1)");
            $ntid = $this->db->insert_id();
            $query=$this->db->query("update tblcallevents set nextCFID='$ntid' WHERE id='$ltid'");
            
            $this->db->query("INSERT INTO barginmeeting(storedt,user_id,cid) VALUES ('$bmdate','$uid','$bcid')");
            $bmid = $this->db->insert_id();
            
            $query=$this->db->query("update barginmeeting set ccid='$ccid',inid='$inid',tid='$ntid' WHERE id='$bmid'");
            
            $this->db->query("INSERT INTO notify(uid,type,sms) VALUES ('$uid','1','Bargin Meeting Created form Funnel')");
        }else{
            
           $this->db->query("INSERT INTO company_master(compname, createddate, city, country, state,partnerType_id) VALUES ('Unknown', '$bmdate', '$bcity', '1', '$bstate','1')");
           $cid = $this->db->insert_id();
           
           $this->db->query("INSERT INTO company_contact_master(contactperson, emailid, phoneno, designation, type, createddate, company_id) VALUES ('', '', '', '', 'primary', '$bmdate', '$cid')");
           $ccid = $this->db->insert_id();
           
           $this->db->query("INSERT INTO init_call(createDate, cmpid_id, creator_id,mainbd,cstatus) VALUES ('$bmdate','$cid','$uid','$uid','1')");
           $inid = $this->db->insert_id();
           
           $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, purpose_achieved, fwd_date, actontaken, nextaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type,plan) VALUES ('0', '0','no', '$bmdate', 'no', 'Will Collect Data by RP Meeting', 'no','$bmdate','4','$uid','$inid','66','Will Collect Data by RP Meeting','1','$uid','$bmdate','$bmdate','updated',1)");
            $ntid = $this->db->insert_id();
            
            $this->db->query("INSERT INTO barginmeeting(storedt,user_id,cid) VALUES ('$bmdate','$uid','$bcid')");
            $bmid = $this->db->insert_id();
           
           $query=$this->db->query("update barginmeeting set cid='$cid',ccid='$ccid',inid='$inid',tid='$ntid' WHERE id='$bmid'");
        }
        
        
        
    }
    
    
    public function get_pendingt($uid,$tdate){
        $query=$this->db->query("SELECT * FROM `tblcallevents` WHERE user_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0");
        return $query->result();
    }
    
    public function get_totalt($uid,$tdate){
        $query=$this->db->query("SELECT tblcallevents.*,status.name,action.name aname,status.color,init_call.cstatus cstatus,(SELECT name from status WHERE id=cstatus) csname, (select init_call.cmpid_id from init_call WHERE id=tblcallevents.cid_id) as cmpid_id,(select company_master.compname from company_master WHERE id=cmpid_id) as compname, (select company_master.id from company_master WHERE id=cmpid_id) as cid FROM tblcallevents left JOIN status ON status.id=tblcallevents.status_id left JOIN action ON action.id=tblcallevents.actiontype_id left JOIN init_call ON init_call.id=tblcallevents.cid_id WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0");
        return $query->result();
    }
    
    public function get_ttdone($uid,$tdate){
        $query=$this->db->query("SELECT tblcallevents.*,status.name,action.name aname,status.color,(select init_call.cmpid_id from init_call WHERE id=tblcallevents.cid_id) as cmpid_id,(select company_master.compname from company_master WHERE id=cmpid_id) as compname, (select company_master.id from company_master WHERE id=cmpid_id) as cid FROM tblcallevents left JOIN status ON status.id=tblcallevents.status_id left JOIN action ON action.id=tblcallevents.actiontype_id WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID!=0");
        return $query->result();
    }
    
    public function get_tptd($uid,$tdate){
        $query=$this->db->query("SELECT count(*) ab,COUNT(CASE WHEN actiontype_id=1 THEN actiontype_id END) a,COUNT(CASE WHEN actiontype_id=2 THEN actiontype_id END) b,COUNT(CASE WHEN actiontype_id=3 THEN actiontype_id END) c,COUNT(CASE WHEN actiontype_id=4 THEN actiontype_id END) d,COUNT(CASE WHEN actiontype_id=5 THEN actiontype_id END) e,COUNT(CASE WHEN actiontype_id=6 THEN actiontype_id END) f,COUNT(CASE WHEN actiontype_id=7 THEN actiontype_id END) g FROM tblcallevents WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=0 and autotask=1");
        return $query->result();
    }
    
    public function get_tptsd($uid,$tdate){
        $query=$this->db->query("SELECT count(*) ab,COUNT(CASE WHEN status_id=1 THEN status_id END) a,COUNT(CASE WHEN status_id=8 THEN status_id END) b,COUNT(CASE WHEN status_id=2 THEN status_id END) c,COUNT(CASE WHEN status_id=3 THEN status_id END) d,COUNT(CASE WHEN status_id=4 THEN status_id END) e,COUNT(CASE WHEN status_id=5 THEN status_id END) f,COUNT(CASE WHEN status_id=10 THEN status_id END) g,COUNT(CASE WHEN status_id=11 THEN status_id END) h,COUNT(CASE WHEN status_id=6 THEN status_id END) i,COUNT(CASE WHEN status_id=9 THEN status_id END) j,COUNT(CASE WHEN status_id=7 THEN status_id END) k FROM tblcallevents WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=0 and autotask=1");
        return $query->result();
    }
    
    
    public function get_atptd($uid,$tdate){
        $query=$this->db->query("SELECT count(*) ab,COUNT(CASE WHEN actiontype_id=1 THEN actiontype_id END) a,COUNT(CASE WHEN actiontype_id=2 THEN actiontype_id END) b,COUNT(CASE WHEN actiontype_id=3 THEN actiontype_id END) c,COUNT(CASE WHEN actiontype_id=4 THEN actiontype_id END) d,COUNT(CASE WHEN actiontype_id=5 THEN actiontype_id END) e,COUNT(CASE WHEN actiontype_id=6 THEN actiontype_id END) f,COUNT(CASE WHEN actiontype_id=7 THEN actiontype_id END) g FROM tblcallevents WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=0 and autotask=0");
        return $query->result();
    }
    
    public function get_atptsd($uid,$tdate){
        $query=$this->db->query("SELECT count(*) ab,COUNT(CASE WHEN status_id=1 THEN status_id END) a,COUNT(CASE WHEN status_id=8 THEN status_id END) b,COUNT(CASE WHEN status_id=2 THEN status_id END) c,COUNT(CASE WHEN status_id=3 THEN status_id END) d,COUNT(CASE WHEN status_id=4 THEN status_id END) e,COUNT(CASE WHEN status_id=5 THEN status_id END) f,COUNT(CASE WHEN status_id=10 THEN status_id END) g,COUNT(CASE WHEN status_id=11 THEN status_id END) h,COUNT(CASE WHEN status_id=6 THEN status_id END) i,COUNT(CASE WHEN status_id=9 THEN status_id END) j,COUNT(CASE WHEN status_id=7 THEN status_id END) k FROM tblcallevents WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan='0' and autotask='0'");
        return $query->result();
    }
    
    public function get_ttbytime($uid,$tdate,$t1,$t2){
        $query=$this->db->query("SELECT tblcallevents.*,status.name,status.color,(select init_call.cmpid_id from init_call WHERE id=tblcallevents.cid_id) as cmpid_id,(select company_master.compname from company_master WHERE id=cmpid_id) as compname, (select company_master.id from company_master WHERE id=cmpid_id) as cid FROM tblcallevents JOIN status ON status.id=tblcallevents.status_id WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '$t1' and '$t2' ORDER BY tblcallevents.appointmentdatetime ASC");
        return $query->result();
    }
    
    
    public function get_ttbytimec($uid,$tdate,$t1,$t2){
        $query=$this->db->query("SELECT tblcallevents.*,status.name,status.color,(select init_call.cmpid_id from init_call WHERE id=tblcallevents.cid_id) as cmpid_id,(select company_master.compname from company_master WHERE id=cmpid_id) as compname, (select company_master.id from company_master WHERE id=cmpid_id) as cid FROM tblcallevents JOIN status ON status.id=tblcallevents.status_id WHERE assignedto_id='$uid' and cast(updateddate AS DATE)='$tdate' and nextCFID!=0 and plan=1 and cast(updateddate AS TIME) BETWEEN '$t1' and '$t2' ORDER BY tblcallevents.appointmentdatetime ASC");
        return $query->result();
    }
    
    
    public function get_pstcalld($uid,$tdate){
        $query=$this->db->query("SELECT count(*) ab, count(case when status_id=1 then status_id END) a, count(case when status_id=2 then status_id END) b, count(case when status_id=3 then status_id END) c, count(case when status_id=4 then status_id END) d, count(case when status_id=5 then status_id END) e, count(case when status_id=6 then status_id END) f, count(case when status_id=7 then status_id END) g, count(case when status_id=8 then status_id END) h, count(case when status_id=9 then status_id END) i, count(case when status_id=10 then status_id END) j, count(case when status_id=11 then status_id END) k  FROM tblcallevents WHERE user_id='$uid' and cast(appointmentdatetime as DATE)='$tdate' and plan=1 and nextCFID!=0");
        return $query->result();
    }
    
    
    public function get_pstcalldbyad($uid,$tdate,$ab){
        if($uid=='100103'){$uid=45;}
        if($ab==0){$text = "user_details.admin_id='$uid' and user_details.type_id=4";}
        if($ab==1){$text = "user_details.user_id='$uid'";}
        $query=$this->db->query("SELECT count(*) ab, count(case when plan=1 then plan END) abc, count(case when status_id=1 and plan=1 then status_id END) a, count(case when status_id=2 and plan=1 then status_id END) b, count(case when status_id=3 and plan=1 then status_id END) c, count(case when status_id=4 and plan=1 then status_id END) d, count(case when status_id=5 and plan=1 then status_id END) e, count(case when status_id=6 and plan=1 then status_id END) f, count(case when status_id=7 and plan=1 then status_id END) g, count(case when status_id=8 and plan=1 then status_id END) h, count(case when status_id=9 and plan=1 then status_id END) i, count(case when status_id=10 and plan=1 then status_id END) j, count(case when status_id=11 and plan=1 then status_id END) k,count(case when actontaken='no' and plan=1 then status_id END) l,count(case when actontaken='yes' and plan=1 then status_id END) m,count(case when purpose_achieved='no' and plan=1 then status_id END) n,count(case when purpose_achieved='yes' and plan=1 then status_id END) o  FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and cast(updateddate as DATE)='$tdate' and nextCFID!=0 and actiontype_id=1");
        return $query->result();
    }
    
    
    
    public function get_pstcc($uid,$tdate,$ab){
        if($uid=='100103'){$uid=45;}
        if($ab==0){$text = "user_details.admin_id='$uid' and user_details.type_id=4";}
        if($ab==1){$text = "user_details.user_id='$uid'";}
        $query=$this->db->query("SELECT tblcallevents.id as tid,tblcallevents.cid_id as cid, (SELECT min(id) FROM tblcallevents where id>tid and cid_id=cid) ntid, (SELECT status_id FROM tblcallevents where id=ntid) nsid, tblcallevents.status_id as sid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and cast(updateddate as DATE)='$tdate' and nextCFID!=0 and plan=1 and actiontype_id=1");
        return $query->result();
    }
    
    
    public function get_pstccon($stat,$uid,$pstid,$sd,$ed,$ab){
        if($uid=='100103'){$uid=45;}
        if($ab==0){$text = "user_details.admin_id='$uid' and user_details.type_id=4";}
        if($ab==1){$text = "user_details.user_id='$pstid'";}
        
        if($stat==0){
        $query=$this->db->query("SELECT appointmentdatetime,initiateddt,updateddate,tblcallevents.user_id as tuid, tblcallevents.id as tid,tblcallevents.cid_id as cid, (SELECT min(id) FROM tblcallevents where id>tid and cid_id=cid) ntid, (SELECT status_id FROM tblcallevents where id=ntid) nsid, tblcallevents.status_id as sid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and nextCFID!=0 and plan=1 and actiontype_id=1 and cast(updateddate as DATE) between '$sd' and '$ed'");
        }else{
            $query=$this->db->query("SELECT appointmentdatetime,initiateddt,updateddate,tblcallevents.user_id as tuid, tblcallevents.id as tid,tblcallevents.cid_id as cid, (SELECT min(id) FROM tblcallevents where id>tid and cid_id=cid) ntid, (SELECT status_id FROM tblcallevents where id=ntid) nsid, tblcallevents.status_id as sid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and nextCFID!=0 and plan=1 and actiontype_id=1 and cast(updateddate as DATE) between '$sd' and '$ed' and status_id='$stat'");
        }
        return $query->result();
    }
    
    
    
    public function get_pstallreview($uid,$pstid,$sd,$ed,$ab){
        if($uid=='100103'){$uid=45;}
        if($ab==0){$text = "user_details.admin_id='$uid' and user_details.type_id=4";}
        if($ab==1){$text = "user_details.user_id='$pstid'";}
        
        $query=$this->db->query("SELECT appointmentdatetime,initiateddt,updateddate,tblcallevents.user_id as tuid, tblcallevents.id as tid,tblcallevents.cid_id as cid, (SELECT min(id) FROM tblcallevents where id>tid and cid_id=cid) ntid, (SELECT status_id FROM tblcallevents where id=ntid) nsid, tblcallevents.status_id as sid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and nextCFID!=0 and plan=1 and actiontype_id=8 and cast(updateddate as DATE) between '$sd' and '$ed'");
        return $query->result();
    }
    
    
    public function get_pstccd($uid,$tdate,$ab){
        if($uid=='100103'){$uid=45;}
        if($ab==0){$text = "user_details.admin_id='$uid' and user_details.type_id=4";}
        if($ab==1){$text = "user_details.user_id='$uid'";}
        $query=$this->db->query("SELECT tblcallevents.*, (select name FROM user_details where user_id=assignedto_id) as name, (select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.id tid, tblcallevents.cid_id cid, tblcallevents.status_id sid, (SELECT min(id) FROM tblcallevents where id>tid and cid_id=cid) ntid, (SELECT status_id FROM tblcallevents where id=ntid) nsid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE nextCFID!=0 and $text and cast(updateddate as DATE)='$tdate'");
        return $query->result();
    }
    
    
    
    public function get_mombtdate($sdate,$edate,$uid,$ab){
        if($uid=='100103'){$uid=45;}
        if($ab==0){$text = "user_details.admin_id='$uid' and user_details.type_id=4";}
        if($ab==1){$text = "user_details.user_id='$uid'";}
        $query=$this->db->query("SELECT (SELECT company_master.compname FROM company_master WHERE company_master.id=init_call.cmpid_id) cname, user_details.name, tblcallevents.mom, tblcallevents.updateddate, (SELECT name FROM user_details WHERE user_details.user_id=init_call.apst) pst FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id WHERE mom!='' and actiontype_id=6 and cast(appointmentdatetime as DATE) between '$sdate' and '$edate' and $text");
        return $query->result();
    }
    
    
    
    public function get_plannersreport($uid,$sdate,$edate,$stid){
        $ab=1;
        if($uid=='100103'){$uid=45;}
        if($ab==0){$text = "user_details.admin_id='$uid' and user_details.type_id=4";}
        if($ab==1){$text = "user_details.user_id='$uid'";}
        $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE cast(updateddate as DATE) BETWEEN '$sdate' and '$edate' and status_id='$stid' and tblcallevents.user_id='$uid' and cid_id in (SELECT DISTINCT cid_id FROM tblcallevents where cast(updateddate as DATE) BETWEEN '$sdate' and '$edate' and status_id='$stid' and tblcallevents.user_id='$uid')");
        return $query->result();
    }
    
    
    
    public function get_plannersareport($uid,$sdate,$edate,$acid){
        $ab=1;
        if($uid=='100103'){$uid=45;}
        if($ab==0){$text = "user_details.admin_id='$uid' and user_details.type_id=4";}
        if($ab==1){$text = "user_details.user_id='$uid'";}
        $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE cast(updateddate as DATE) BETWEEN '$sdate' and '$edate' and actiontype_id='$acid' and tblcallevents.user_id='$uid' and cid_id in (SELECT DISTINCT cid_id FROM tblcallevents where cast(updateddate as DATE) BETWEEN '$sdate' and '$edate' and actiontype_id='$acid' and tblcallevents.user_id='$uid')");
        return $query->result();
    }
    
    
    
    
    public function get_pstcallcon($code,$atid,$uid,$tdate,$ab){
        if($uid=='100103'){$uid=45;}
        if($ab==0){$text = "user_details.admin_id='$uid' and user_details.type_id=4";}
        if($ab==1){$text = "user_details.user_id='$uid'";}
        if($atid==0){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE actiontype_id=1 and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and plan=1 and nextCFID!=0 and $text");
        }
        if($atid==1){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE actiontype_id=1 and status_id='$code' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and nextCFID!=0 and plan=1 and $text");
        }
        if($atid==2){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE actiontype_id=1 and actontaken='no' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and nextCFID!=0 and plan=1 and $text");
        }
        if($atid==3){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE actiontype_id=1 and actontaken='yes' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and nextCFID!=0 and plan=1 and $text");
        }
        if($atid==4){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE actiontype_id=1 and purpose_achieved='no' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and nextCFID!=0 and plan=1 and $text");
        }
        if($atid==5){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE actiontype_id=1 and purpose_achieved='yes' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and nextCFID!=0 and plan=1 and $text");
        }
        
        
        return $query->result();
    }
    
    
    
    public function get_psttaskdetail($sid,$uid,$tdate,$ab){
        if($uid=='100103'){$uid=45;}
        if($ab==0){$text = "user_details.admin_id='$uid' and user_details.type_id=4";}
        if($ab==1){$text = "user_details.user_id='$uid'";}
        $query=$this->db->query("SELECT * FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and cast(appointmentdatetime as DATE)='$tdate' and plan=1 and nextCFID!=0 and status_id=1");
        return $query->result();
    }
    
    
    public function get_pstcalldetail($code,$uid,$tdate,$ab){
        if($uid=='100103'){$uid=45;}
      if($ab==0){$text = "user_details.admin_id='$uid' and user_details.type_id=4";}
      if($ab==1){$text = "user_details.user_id='$uid'";}
      $query=$this->db->query("SELECT * FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and cast(appointmentdatetime as DATE)='$tdate' and plan=1 and nextCFID!=0");
      return $query->result();
    }
    
    
    public function get_ttbytimed($uid,$tdate,$t1,$t2){
        $query=$this->db->query("SELECT count(*) ab,COUNT(CASE WHEN actiontype_id=1 THEN actiontype_id END) a,COUNT(CASE WHEN actiontype_id=2 THEN actiontype_id END) b,COUNT(CASE WHEN actiontype_id=3 THEN actiontype_id END) c,COUNT(CASE WHEN actiontype_id=4 THEN actiontype_id END) d,COUNT(CASE WHEN actiontype_id=5 THEN actiontype_id END) e,COUNT(CASE WHEN actiontype_id=6 THEN actiontype_id END) f,COUNT(CASE WHEN actiontype_id=7 THEN actiontype_id END) g from tblcallevents WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '$t1' and '$t2'");
        return $query->result();
    }
    
    public function get_ttbytimedc($uid,$tdate,$t1,$t2){
        $query=$this->db->query("SELECT count(*) ab,COUNT(CASE WHEN actiontype_id=1 THEN actiontype_id END) a,COUNT(CASE WHEN actiontype_id=2 THEN actiontype_id END) b,COUNT(CASE WHEN actiontype_id=3 THEN actiontype_id END) c,COUNT(CASE WHEN actiontype_id=4 THEN actiontype_id END) d,COUNT(CASE WHEN actiontype_id=5 THEN actiontype_id END) e,COUNT(CASE WHEN actiontype_id=6 THEN actiontype_id END) f,COUNT(CASE WHEN actiontype_id=7 THEN actiontype_id END) g from tblcallevents WHERE assignedto_id='$uid' and cast(updateddate AS DATE)='$tdate' and nextCFID!=0 and plan=1 and cast(updateddate AS TIME) BETWEEN '$t1' and '$t2'");
        return $query->result();
    }
    
    public function get_ttbyd($uid,$tdate){
        $query=$this->db->query("SELECT count(*) ab,COUNT(CASE WHEN actiontype_id=1 THEN actiontype_id END) a,COUNT(CASE WHEN actiontype_id=2 THEN actiontype_id END) b,COUNT(CASE WHEN actiontype_id=3 THEN actiontype_id END) c,COUNT(CASE WHEN actiontype_id=4 THEN actiontype_id END) d,COUNT(CASE WHEN actiontype_id=5 THEN actiontype_id END) e,COUNT(CASE WHEN actiontype_id=6 THEN actiontype_id END) f,COUNT(CASE WHEN actiontype_id=7 THEN actiontype_id END) g from tblcallevents WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1");
        return $query->result();
    }
    
    public function get_ctpending($cid){
        $query=$this->db->query("SELECT count(*) a from tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id WHERE tblcallevents.nextCFID=0 and init_call.cmpid_id='$cid'");
        return $query->result();
    }
    
    public function get_ttbydc($uid,$tdate){
        $query=$this->db->query("SELECT count(*) ab,COUNT(CASE WHEN actiontype_id=1 THEN actiontype_id END) a,COUNT(CASE WHEN actiontype_id=2 THEN actiontype_id END) b,COUNT(CASE WHEN actiontype_id=3 THEN actiontype_id END) c,COUNT(CASE WHEN actiontype_id=4 THEN actiontype_id END) d,COUNT(CASE WHEN actiontype_id=5 THEN actiontype_id END) e,COUNT(CASE WHEN actiontype_id=6 THEN actiontype_id END) f,COUNT(CASE WHEN actiontype_id=7 THEN actiontype_id END) g from tblcallevents WHERE assignedto_id='$uid' and cast(updateddate AS DATE)='$tdate' and nextCFID!=0");
        return $query->result();
    }
    
    
    public function get_totaltd($uid,$tdate){
        $query=$this->db->query("SELECT COUNT(*) a,count(CASE WHEN nextCFID=0 THEN nextCFID end) b,count(CASE WHEN nextCFID!=0 THEN nextCFID end) c, count(CASE WHEN actiontype_id=1 THEN actiontype_id end) d,count(CASE WHEN actiontype_id=1 and nextCFID=0 THEN actiontype_id end) e,count(CASE WHEN actiontype_id=2 THEN actiontype_id end) f,count(CASE WHEN actiontype_id=2 and nextCFID=0 THEN actiontype_id end) g,count(CASE WHEN actiontype_id=3 THEN actiontype_id end) h,count(CASE WHEN actiontype_id=3 and nextCFID=0 THEN actiontype_id end) i,count(CASE WHEN actiontype_id=4 THEN actiontype_id end) j,count(CASE WHEN actiontype_id=4 and nextCFID=0 THEN actiontype_id end) k,count(CASE WHEN actiontype_id=5 THEN actiontype_id end) l,count(CASE WHEN actiontype_id=5 and nextCFID=0 THEN actiontype_id end) m,count(CASE WHEN actiontype_id=6 THEN actiontype_id end) n,count(CASE WHEN actiontype_id=6 and nextCFID=0 THEN actiontype_id end) o,count(CASE WHEN actiontype_id=7 THEN actiontype_id end) p,count(CASE WHEN actiontype_id=7 and nextCFID=0 THEN actiontype_id end) q,count(CASE WHEN actiontype_id=10 THEN actiontype_id end) na,count(CASE WHEN actiontype_id=10 and nextCFID=0 THEN actiontype_id end) nb,count(CASE WHEN actiontype_id=11 THEN actiontype_id end) nc,count(CASE WHEN actiontype_id=11 and nextCFID=0 THEN actiontype_id end) nd,count(CASE WHEN actiontype_id=12 THEN actiontype_id end) ne,count(CASE WHEN actiontype_id=12 and nextCFID=0 THEN actiontype_id end) nf,count(CASE WHEN actontaken='yes' and nextCFID!=0 THEN actiontype_id end) r,count(CASE WHEN actontaken='no' and nextCFID!=0 THEN actiontype_id end) s,count(CASE WHEN purpose_achieved='yes' and nextCFID!=0 THEN actiontype_id end) t,count(CASE WHEN purpose_achieved='no' and nextCFID!=0 THEN actiontype_id end) u FROM tblcallevents WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and plan=1");
        return $query->result();
    }
    
    public function get_tmeetdbyaid($uid,$tdate){
        $query=$this->db->query("SELECT count(*) ab, count(case when actiontype_id=3 then actiontype_id END) a, count(case when actiontype_id=4 then actiontype_id END) b, count(case when actiontype_id=4 and priority='yes' then actiontype_id END) c, count(case when actiontype_id=4 and priority='no' then actiontype_id END) d, count(case when actiontype_id=4 and mtype='rp' then actiontype_id END) e, count(case when actiontype_id=4 and priority='nrp' then actiontype_id END) f, count(case when actiontype_id=4 and pstassign='no' then actiontype_id END) g, count(case when actiontype_id=4 and pstassign='yes' then actiontype_id END) h FROM tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and nextCFID!=0");
        return $query->result();
    }
    
    
    public function get_tbmeetdbyaid($uid,$tdate){
        
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        
        
        $query=$this->db->query("SELECT COUNT(*) ab, count(case WHEN barginmeeting.status='Pending' THEN barginmeeting.status END) a,count(case WHEN barginmeeting.status='Start' THEN barginmeeting.status END) b,count(case WHEN barginmeeting.status='Close' THEN barginmeeting.status END) c, count(case WHEN tblcallevents.mtype='RP' THEN tblcallevents.mtype END) d, count(case WHEN tblcallevents.mtype='NO RP' THEN tblcallevents.mtype END) e, count(case WHEN tblcallevents.priority='yes' THEN tblcallevents.mtype END) f, count(case WHEN tblcallevents.priority='no' THEN tblcallevents.mtype END) g, count(case WHEN barginmeeting.status='RPClose' THEN barginmeeting.status END) h,count(case WHEN barginmeeting.status!='Pending' THEN barginmeeting.status END) i,count(case WHEN tblcallevents.mtype='Only Got Detail' THEN tblcallevents.mtype END) k FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(barginmeeting.storedt AS DATE)='$tdate'");
        return $query->result();
    }
    
    
    public function get_tallmeetd($uid,$tdate){
        $query=$this->db->query("SELECT COUNT(*) ab, count(case WHEN tblcallevents.nextCFID!=0 THEN tblcallevents.nextCFID END) as abc, count(case WHEN tblcallevents.actiontype_id=3 THEN tblcallevents.actiontype_id END) a, count(case WHEN tblcallevents.actiontype_id=3 and tblcallevents.nextCFID!=0 THEN tblcallevents.actiontype_id END) b,count(case WHEN tblcallevents.actiontype_id=4 THEN tblcallevents.actiontype_id END) c,count(case WHEN tblcallevents.actiontype_id=4 and tblcallevents.nextCFID!=0 THEN tblcallevents.actiontype_id END) d FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$uid' and cast(barginmeeting.storedt AS DATE)='$tdate'");
        return $query->result();
    }
    
    
    
    public function get_momyn($cid,$tid){
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE cid_id='$cid' and actiontype_id=6 and nextCFID!=0 and id>$tid");
        return $query->result();
    }
    
    public function get_temailyn($cid,$tid){
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE cid_id='$cid' and actiontype_id=2 and nextCFID!=0 and id>$tid");
        return $query->result();
    }
    
    public function get_psta($cid){
        $query=$this->db->query("SELECT * FROM init_call WHERE cmpid_id='$cid' and apst!=''");
        return $query->result();
    }
    
    
    public function get_tbmd($code,$uid,$sdate,$edate){
        if($uid=='100103' || $uid=='100114' || $uid=='100115'){$uid=45;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($code==1){
        $query=$this->db->query("SELECT tblcallevents.*,barginmeeting.*,user_details.*, tblcallevents.id tid, tblcallevents.cid_id cid, (SELECT count(id) from tblcallevents WHERE tblcallevents.cid_id=cid and id>tid and mom!='') momc FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(barginmeeting.storedt AS DATE) BETWEEN '$sdate' AND '$edate'");
        }elseif($code==2){
        $query=$this->db->query("SELECT tblcallevents.*,barginmeeting.*,user_details.*, tblcallevents.id tid, tblcallevents.cid_id cid, (SELECT count(id) from tblcallevents WHERE tblcallevents.cid_id=cid and id>tid and mom!='') momc FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(barginmeeting.storedt AS DATE) BETWEEN '$sdate' AND '$edate' and barginmeeting.status='Pending'");
        }elseif($code==3){
        $query=$this->db->query("SELECT tblcallevents.*,barginmeeting.*,user_details.*, tblcallevents.id tid, tblcallevents.cid_id cid, (SELECT count(id) from tblcallevents WHERE tblcallevents.cid_id=cid and id>tid and mom!='') momc FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(barginmeeting.storedt AS DATE) BETWEEN '$sdate' AND '$edate' and barginmeeting.status='Start'");
        }elseif($code==4){
        $query=$this->db->query("SELECT tblcallevents.*,barginmeeting.*,user_details.*, tblcallevents.id tid, tblcallevents.cid_id cid, (SELECT count(id) from tblcallevents WHERE tblcallevents.cid_id=cid and id>tid and mom!='') momc FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(barginmeeting.storedt AS DATE) BETWEEN '$sdate' AND '$edate' and barginmeeting.status='Close'");
        }elseif($code==5){
        $query=$this->db->query("SELECT tblcallevents.*,barginmeeting.*,user_details.*, tblcallevents.id tid, tblcallevents.cid_id cid, (SELECT count(id) from tblcallevents WHERE tblcallevents.cid_id=cid and id>tid and mom!='') momc FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE $text and tblcallevents.mtype='RP' and cast(barginmeeting.storedt AS DATE) between '$sdate' and '$edate'");
        }elseif($code==6){
        $query=$this->db->query("SELECT tblcallevents.*,barginmeeting.*,user_details.*, tblcallevents.id tid, tblcallevents.cid_id cid, (SELECT count(id) from tblcallevents WHERE tblcallevents.cid_id=cid and id>tid and mom!='') momc FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(barginmeeting.storedt AS DATE) BETWEEN '$sdate' AND '$edate' and tblcallevents.mtype='NO RP'");
        }elseif($code==7){
        $query=$this->db->query("SELECT tblcallevents.*,barginmeeting.*,user_details.*, tblcallevents.id tid, tblcallevents.cid_id cid, (SELECT count(id) from tblcallevents WHERE tblcallevents.cid_id=cid and id>tid and mom!='') momc FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(barginmeeting.storedt AS DATE) BETWEEN '$sdate' AND '$edate' and tblcallevents.priority='yes'");
        }elseif($code==8){
        $query=$this->db->query("SELECT tblcallevents.*,barginmeeting.*,user_details.*, tblcallevents.id tid, tblcallevents.cid_id cid, (SELECT count(id) from tblcallevents WHERE tblcallevents.cid_id=cid and id>tid and mom!='') momc FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(barginmeeting.storedt AS DATE) BETWEEN '$sdate' AND '$edate' and tblcallevents.priority='no' ");
        }
        else{
            $query=$this->db->query("SELECT tblcallevents.*,barginmeeting.*,user_details.*, tblcallevents.id tid, tblcallevents.cid_id cid, (SELECT count(id) from tblcallevents WHERE tblcallevents.cid_id=cid and id>tid and mom!='') momc FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(barginmeeting.storedt AS DATE) BETWEEN '$sdate' AND '$edate'");
        }
        return $query->result();
    }
    
    
    public function get_tmeetingd($code,$uid,$sdate,$edate){
        
        $query=$this->db->query("SELECT user_details.name, COUNT(*) tt, COUNT(CASE WHEN tblcallevents.mtype='RP' THEN tblcallevents.mtype END) rp FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.user_id='$uid' and cast(barginmeeting.storedt AS DATE) BETWEEN '$sdate' AND '$edate'  GROUP BY user_details.name");
        return $query->result();
    }
    
    
    public function get_TMbyaid($atid,$uid,$tdate){
        $query=$this->db->query("SELECT user_details.name bd,company_master.compname cname,tblcallevents.* FROM tblcallevents LEFT JOIN init_call init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE cast(updateddate as DATE)='$tdate' and user_details.admin_id='$uid' and plan=1 and nextCFID!=0 and actiontype_id=$atid");
        return $query->result();
    }
    
    
    
    
    public function get_bdtofpstf($uid,$tdate){
        $query=$this->db->query("SELECT COUNT(*) a,count(CASE WHEN nextCFID=0 THEN nextCFID end) b,count(CASE WHEN nextCFID!=0 THEN nextCFID end) c, count(CASE WHEN actiontype_id=1 THEN actiontype_id end) d,count(CASE WHEN actiontype_id=1 and nextCFID=0 THEN actiontype_id end) e,count(CASE WHEN actiontype_id=2 THEN actiontype_id end) f,count(CASE WHEN actiontype_id=2 and nextCFID=0 THEN actiontype_id end) g,count(CASE WHEN actiontype_id=3 THEN actiontype_id end) h,count(CASE WHEN actiontype_id=3 and nextCFID=0 THEN actiontype_id end) i,count(CASE WHEN actiontype_id=4 THEN actiontype_id end) j,count(CASE WHEN actiontype_id=4 and nextCFID=0 THEN actiontype_id end) k,count(CASE WHEN actiontype_id=5 THEN actiontype_id end) l,count(CASE WHEN actiontype_id=5 and nextCFID=0 THEN actiontype_id end) m,count(CASE WHEN actiontype_id=6 THEN actiontype_id end) n,count(CASE WHEN actiontype_id=6 and nextCFID=0 THEN actiontype_id end) o,count(CASE WHEN actiontype_id=7 THEN actiontype_id end) p,count(CASE WHEN actiontype_id=7 and nextCFID=0 THEN actiontype_id end) q,count(CASE WHEN actontaken='yes' THEN actiontype_id end) r,count(CASE WHEN actontaken='no' and nextCFID=0 THEN actiontype_id end) s,count(CASE WHEN purpose_achieved='yes' THEN actiontype_id end) t,count(CASE WHEN purpose_achieved='no' and nextCFID=0 THEN actiontype_id end) u FROM tblcallevents LEFT JOIN init_call on init_call.id=tblcallevents.cid_id WHERE init_call.apst='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and plan=1");
        return $query->result();
    }
    
    
    public function get_pstfbdwork($code,$atid,$uid,$tdate,$ab){
        if($ab==0){$text = "init_call.apst='$uid'";}
        if($ab==1){$text = "init_call.apst='$uid'";}
        if($code==1){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id WHERE actiontype_id='$atid' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and plan=1 and $text");
            
        }elseif($code==2){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id  LEFT JOIN init_call on init_call.id=tblcallevents.cid_id WHERE actiontype_id='$atid' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and plan=1 and $text and tblcallevents.nextCFID=0");
            
        }elseif($code==3){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id  LEFT JOIN init_call on init_call.id=tblcallevents.cid_id WHERE actiontype_id='$atid' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and plan=1 and $text and tblcallevents.nextCFID!=0");
            
        }elseif($code==4){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id  LEFT JOIN init_call on init_call.id=tblcallevents.cid_id WHERE $text and cast(appointmentdatetime AS DATE)='$tdate' and plan=1");
            
        }elseif($code==5){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id  LEFT JOIN init_call on init_call.id=tblcallevents.cid_id WHERE $text and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and nextCFID=0");
            
        }elseif($code==6){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id  LEFT JOIN init_call on init_call.id=tblcallevents.cid_id WHERE $text and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and nextCFID!=0");
            
        }elseif($code==7){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id  LEFT JOIN init_call on init_call.id=tblcallevents.cid_id WHERE $text and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and nextCFID!=0 and actontaken='yes'");
            
        }elseif($code==8){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id  LEFT JOIN init_call on init_call.id=tblcallevents.cid_id WHERE $text and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and nextCFID!=0 and actontaken='no'");
            
        }elseif($code==9){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id  LEFT JOIN init_call on init_call.id=tblcallevents.cid_id WHERE $text and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and nextCFID!=0 and purpose_achieved='yes'");
            
        }elseif($code==10){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id  LEFT JOIN init_call on init_call.id=tblcallevents.cid_id WHERE $text and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and nextCFID!=0 and purpose_achieved='no'");
            
        }else{
        $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id  LEFT JOIN init_call on init_call.id=tblcallevents.cid_id WHERE actiontype_id='$atid' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and plan=1 and $text");
        }
        return $query->result();  
    }

    
    
    public function get_tteamtd($uid,$tdate){
        $query=$this->db->query("SELECT COUNT(*) a,count(CASE WHEN nextCFID=0 THEN nextCFID end) b,count(CASE WHEN nextCFID!=0 THEN nextCFID end) c, count(CASE WHEN actiontype_id=1 THEN actiontype_id end) d,count(CASE WHEN actiontype_id=1 and nextCFID=0 THEN actiontype_id end) e,count(CASE WHEN actiontype_id=2 THEN actiontype_id end) f,count(CASE WHEN actiontype_id=2 and nextCFID=0 THEN actiontype_id end) g,count(CASE WHEN actiontype_id=3 THEN actiontype_id end) h,count(CASE WHEN actiontype_id=3 and nextCFID=0 THEN actiontype_id end) i,count(CASE WHEN actiontype_id=4 THEN actiontype_id end) j,count(CASE WHEN actiontype_id=4 and nextCFID=0 THEN actiontype_id end) k,count(CASE WHEN actiontype_id=5 THEN actiontype_id end) l,count(CASE WHEN actiontype_id=5 and nextCFID=0 THEN actiontype_id end) m,count(CASE WHEN actiontype_id=6 THEN actiontype_id end) n,count(CASE WHEN actiontype_id=6 and nextCFID=0 THEN actiontype_id end) o,count(CASE WHEN actiontype_id=7 THEN actiontype_id end) p,count(CASE WHEN actiontype_id=7 and nextCFID=0 THEN actiontype_id end) q,count(CASE WHEN actontaken='yes' and nextCFID!=0 THEN actiontype_id end) r,count(CASE WHEN actontaken='no' and nextCFID!=0 THEN actiontype_id end) s,count(CASE WHEN purpose_achieved='yes' and nextCFID!=0 THEN actiontype_id end) t,count(CASE WHEN purpose_achieved='no' and nextCFID!=0 THEN actiontype_id end) u FROM tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and user_details.type_id=3");
        return $query->result();
    }
    
    
    
    
    
    
    public function get_unplant($uid,$tdate){
        $query=$this->db->query("SELECT COUNT(*) a,count(CASE WHEN nextCFID=0 THEN nextCFID end) b,count(CASE WHEN nextCFID!=0 THEN nextCFID end) c, count(CASE WHEN actiontype_id=1 THEN actiontype_id end) d,count(CASE WHEN actiontype_id=1 and nextCFID=0 THEN actiontype_id end) e,count(CASE WHEN actiontype_id=2 THEN actiontype_id end) f,count(CASE WHEN actiontype_id=2 and nextCFID=0 THEN actiontype_id end) g,count(CASE WHEN actiontype_id=3 THEN actiontype_id end) h,count(CASE WHEN actiontype_id=3 and nextCFID=0 THEN actiontype_id end) i,count(CASE WHEN actiontype_id=4 THEN actiontype_id end) j,count(CASE WHEN actiontype_id=4 and nextCFID=0 THEN actiontype_id end) k,count(CASE WHEN actiontype_id=5 THEN actiontype_id end) l,count(CASE WHEN actiontype_id=5 and nextCFID=0 THEN actiontype_id end) m,count(CASE WHEN actiontype_id=6 THEN actiontype_id end) n,count(CASE WHEN actiontype_id=6 and nextCFID=0 THEN actiontype_id end) o,count(CASE WHEN actiontype_id=7 THEN actiontype_id end) p,count(CASE WHEN actiontype_id=7 and nextCFID=0 THEN actiontype_id end) q,count(CASE WHEN actontaken='yes' THEN actiontype_id end) r,count(CASE WHEN actontaken='no' and nextCFID=0 THEN actiontype_id end) s,count(CASE WHEN purpose_achieved='yes' THEN actiontype_id end) t,count(CASE WHEN purpose_achieved='no' and nextCFID=0 THEN actiontype_id end) u FROM tblcallevents WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and plan=0");
        return $query->result();
    }
    
    public function get_tswwork($uid,$tdate){
    $query=$this->db->query("SELECT * FROM tblcallevents WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and plan=1");
        return $query->result();
    }
    
    
    public function get_tbdtaskonpstf($uid,$tdate){
    $query=$this->db->query("SELECT * FROM tblcallevents LEFT JOIN init_call on init_call.id=tblcallevents.cid_id WHERE init_call.apst='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and plan=1");
        return $query->result();
    }
    
    
    public function get_ttswwork($uid,$tdate){
    $query=$this->db->query("SELECT * FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and plan=1");
        return $query->result();
    }
    
    
    public function get_ttsw($uid,$tdate,$ab){
        if($uid=='100103'){$uid=45;}
        if($ab==0){$text = "user_details.admin_id='$uid' and user_details.type_id=3";}
        if($ab==1){$text = "user_details.user_id='$uid'";}
        $query=$this->db->query("SELECT COUNT(case when lstatus=1 then lstatus END) a,COUNT(case when lstatus=8 then lstatus END) b,COUNT(case when lstatus=2 then lstatus END) c,COUNT(case when lstatus=3 then lstatus END) d,COUNT(case when lstatus=4 then lstatus END) e,COUNT(case when lstatus=5 then lstatus END) f,COUNT(case when lstatus=6 then lstatus END) g,COUNT(case when lstatus=7 then lstatus END) h,COUNT(case when lstatus=9 then lstatus END) i,COUNT(case when lstatus=10 then lstatus END) j,COUNT(case when lstatus=11 then lstatus END) k,COUNT(case when lstatus=12 then lstatus END) l,COUNT(case when lstatus=13 then lstatus END) m FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and nextCFID!=0");
            return $query->result();
    }
    
    
    public function get_tswworkdata($id){
    $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents WHERE id='$id'");
        return $query->result();
    }
    
    public function get_ttswdetail($sid,$uid,$tdate,$ab){
    if($ab==0){$text = "user_details.admin_id='$uid'";}
    if($ab==1){$text = "user_details.user_id='$uid'";}
    $query=$this->db->query("SELECT tblcallevents.* FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(updateddate AS DATE)='$tdate' and plan=1 and nextCFID!=0 and lstatus='$sid'");
        return $query->result();
    }
    
    
    public function in_dtime($tid){
        $date = date('Y-m-d H:i:s');
        $query=$this->db->query("update tblcallevents set initiateddt='$date' WHERE id='$tid'");
    }
    
    
    
    
    
    public function get_alpopup($uid){
    $date = date('Y-m-d');
    $query=$this->db->query("SELECT count(*) cont FROM user_day WHERE user_id='$uid' and cast(sdatet as DATE)='$date'");
    $data = $query->result();
    $cont = $data[0]->cont;
    
     if($cont>0){return 0;}else{return "<p><b>Plese Start Your Day First Then Do Any Other Task</b></p>";}
     
    }
    
    
    
    
    public function get_ccctd($tid){
    $query=$this->db->query("SELECT company_master.compname, status.name csname, tblcallevents.remarks cremarks, tblcallevents.* FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN action ON action.id=tblcallevents.actiontype_id LEFT JOIN status ON status.id=tblcallevents.status_id LEFT JOIN purpose ON purpose.id=tblcallevents.purpose_id  WHERE tblcallevents.id='$tid'");
        return $query->result();
    }
    
    
    public function get_cnlstatus($tid,$cid){
    $query=$this->db->query("SELECT status.name,(SELECT status.name FROM tblcallevents t1 LEFT JOIN status ON status.id=t1.status_id WHERE t1.id=(SELECT min(id) FROM tblcallevents WHERE id>'$tid' and cid_id='$cid')) as nstid, (SELECT status.name FROM tblcallevents t2 LEFT JOIN status ON status.id=t2.status_id WHERE t2.id=(SELECT max(id) FROM tblcallevents WHERE id<'$tid' and cid_id='$cid')) as lstid FROM tblcallevents LEFT JOIN status ON status.id=tblcallevents.status_id WHERE tblcallevents.id='$tid' and cid_id='$cid'");
        return $query->result();
    }
    
    
    
    public function get_ttominid($tid,$cid){
    $query=$this->db->query("SELECT min(id) ntid FROM `tblcallevents` WHERE cid_id='$cid' and id>'$tid'");
        return $query->result();
    }
    
    
    public function get_ccitblall($id){
        $query=$this->db->query("SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,partner_master.name as partner_type,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id left join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join partner_master on partner_master.id=company_master.partnerType_id join user_details on cr_event.user_id=user_details.user_id WHERE cr_event.id='$id'");
        return $query->result();
    }
    
    public function get_alltaskdbyad($code,$atid,$uid,$tdate,$ab){
        if($uid=='100103' || $uid=='100114' || $uid=='100115'){$uid=45;}
        if($ab==0){$text = "user_details.admin_id='$uid' and user_details.type_id=3";}
        if($ab==1){$text = "user_details.user_id='$uid'";}
        if($code==1){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE actiontype_id='$atid' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and plan=1 and $text");
            
        }elseif($code==2){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE actiontype_id='$atid' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and plan=1 and $text and tblcallevents.nextCFID=0");
            
        }elseif($code==3){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE actiontype_id='$atid' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and plan=1 and $text and tblcallevents.nextCFID!=0");
            
        }elseif($code==4){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(appointmentdatetime AS DATE)='$tdate' and plan=1");
            
        }elseif($code==5){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and nextCFID=0");
            
        }elseif($code==6){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and nextCFID!=0");
            
        }elseif($code==7){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and nextCFID!=0 and actontaken='yes'");
            
        }elseif($code==8){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and nextCFID!=0 and actontaken='no'");
            
        }elseif($code==9){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and nextCFID!=0 and purpose_achieved='yes'");
            
        }elseif($code==10){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and nextCFID!=0 and purpose_achieved='no'");
            
        }else{
        $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE actiontype_id='$atid' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and plan=1 and $text");
        }
        return $query->result();  
    }
    
    
    
    public function get_alltaskd($code,$atid,$uid,$tdate){
        if($code==1){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents WHERE actiontype_id='$atid' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and plan=1 and assignedto_id='$uid'");
            
        }elseif($code==2){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents WHERE actiontype_id='$atid' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and plan=1 and assignedto_id='$uid' and tblcallevents.nextCFID=0");
            
        }elseif($code==3){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents WHERE actiontype_id='$atid' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and plan=1 and assignedto_id='$uid' and tblcallevents.nextCFID!=0");
            
        }else{
        $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents WHERE actiontype_id='$atid' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and plan=1 and assignedto_id='$uid'");
        }
        return $query->result();  
    }
        
    public function get_callingr($atid,$uid,$tdate){
            $code=3;
        if($code==1){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents WHERE assignedto_id='$uid' and actiontype_id='$atid' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and plan=1");
            
        }elseif($code==2){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents WHERE assignedto_id='$uid' and actiontype_id='$atid' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and plan=1 and nextCFID==0");
            
        }elseif($code==3){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents WHERE assignedto_id='$uid' and actiontype_id='$atid' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and plan=1 and nextCFID!=0");
            
        }else{
        $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents WHERE assignedto_id='$uid' and actiontype_id='$atid' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated'");
        }
        
        
        return $query->result();  
    }
    
    
    public function get_totalrpmeet($uid){
        $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents WHERE user_id='$uid' and mtype='RP'");
        return $query->result();  
    }
    
    public function get_tbldata($id){
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE id='$id'");
        return $query->result();
    }
    
    
    public function get_pat($atid,$uid,$tdate){
        $query=$this->db->query("SELECT * FROM `tblcallevents` WHERE user_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and actiontype_id='$atid'");
        return $query->result();
    }
    
    public function get_tat($atid,$uid,$tdate){
        $query=$this->db->query("SELECT * FROM `tblcallevents` WHERE user_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and actiontype_id='$atid'");
        return $query->result();
    }
    
    
    
    public function get_tblbycid($cid){
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE id=(SELECT max(id) FROM tblcallevents where cid_id='$cid')");
        return $query->result();
    }
    
    public function get_tblbycidtan($cid){
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE cid_id='$cid' and status_id=3");
        return $query->result();
    }
    
    public function get_tblbycidmom($cid){
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE cid_id='$cid' and mom!=''");
        return $query->result();
    }
    
    
    public function get_tblbypriority($cid){
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE cid_id='$cid' and priority!=''");
        return $query->result();
    }
    
    
    public function get_daydetail($uid,$tdate){
        $query=$this->db->query("SELECT cast(ustart as TIME) as ustart,cast(uclose as TIME) as uclose FROM user_day WHERE user_id='$uid' and cast(sdatet as DATE)='$tdate'");
        return $query->result();
    }
    
    
    public function get_daydbyad($uid,$tdate){
        $query=$this->db->query("SELECT (SELECT count(*) FROM user_details where admin_id='45' and status='active' and type_id=3) a, COUNT(*) b, COUNT(case when wffo=1 then wffo end) c, COUNT(case when wffo=2 then wffo end) d, COUNT(case when wffo=3 then wffo end) e FROM user_day LEFT JOIN user_details ON user_details.user_id=user_day.user_id WHERE cast(ustart as DATE)='$tdate' and user_details.admin_id='$uid'");
        return $query->result();
    }
    
    public function get_BDdaydbyad($uid,$tdate,$code){
        if($uid=='100103' || $uid=='100114' || $uid=='100115'){$uid=45;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($code==1){
        $query=$this->db->query("SELECT user_details.name bdname, cast(ustart as TIME) as start,cast(uclose as TIME) as close, user_day.* FROM user_day LEFT JOIN user_details ON user_details.user_id=user_day.user_id WHERE cast(ustart as DATE)='$tdate' and $text");
        }elseif($code==2){
        $query=$this->db->query("SELECT user_details.name bdname, cast(ustart as TIME) as start,cast(uclose as TIME) as close, user_day.* FROM user_day LEFT JOIN user_details ON user_details.user_id=user_day.user_id WHERE cast(ustart as DATE)='$tdate' and $text and user_day.wffo=1");
        }elseif($code==3){
        $query=$this->db->query("SELECT user_details.name bdname, cast(ustart as TIME) as start,cast(uclose as TIME) as close, user_day.* FROM user_day LEFT JOIN user_details ON user_details.user_id=user_day.user_id WHERE cast(ustart as DATE)='$tdate' and $text and user_day.wffo=2");
        }elseif($code==4){
        $query=$this->db->query("SELECT user_details.name bdname, cast(ustart as TIME) as start,cast(uclose as TIME) as close, user_day.* FROM user_day LEFT JOIN user_details ON user_details.user_id=user_day.user_id WHERE cast(ustart as DATE)='$tdate' and $text and user_day.wffo=3");
        }else{
        $query=$this->db->query("SELECT user_details.name bdname, cast(ustart as TIME) as start,cast(uclose as TIME) as close, user_day.* FROM user_day LEFT JOIN user_details ON user_details.user_id=user_day.user_id WHERE cast(ustart as DATE)='$tdate' and $text");
        }
        return $query->result();
    }
    
    
    
    public function get_test7(){
        $query=$this->db->query("SELECT id FROM init_call WHERE mainbd!=''");
        $data =  $query->result();
        foreach($data as $d){
        $inid = $d->id;
        
          $query=$this->db->query("SELECT max(id) mid FROM tblcallevents WHERE cid_id='$inid'");
          $data1 =  $query->result();
          $mid = $data1[0]->mid;
          
          
          $query=$this->db->query("SELECT status_id FROM tblcallevents WHERE id='$mid'");
          $data2 =  $query->result();
          $sid = $data2[0]->status_id;
          
          $query=$this->db->query("SELECT user_id FROM tblcallevents WHERE id='$mid'");
          $data3 =  $query->result();
          $uuid = $data3[0]->user_id;
          
          $query=$this->db->query("update init_call set cstatus='$sid',mainbd='$uuid' where id='$inid'");
        } 
    }
    
    
    public function get_test8(){
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE mom!=''");
        $data =  $query->result();
        foreach($data as $d){
        $inid = $d->cid_id;
        $tid = $d->id;
        $udate = $d->updateddate;
        $uid = $d->user_id;
        
        $query=$this->db->query("SELECT max(id) mid FROM tblcallevents WHERE cid_id='$inid' and id<$tid");
          $data1 =  $query->result();
          $mid = $data1[0]->mid;
          
          $query=$this->db->query("update tblcallevents set status_id=3, actiontype_id=3, remarks='schedule meeting completed', assignedto_id='$uid', user_id='$uid',mtype='RP' WHERE id='$mid'");
        } 
    }
    
    
    
    
    
    public function get_testexbdmom(){
        $date = date('Y-m-d H:i:s');
        $query=$this->db->query("SELECT * FROM test3");
        $data = $query->result();
        foreach($data as $dt){
            $bdid = $dt->bdid;
            $cid = $dt->cid;
            $mom = $dt->mom;
            $cs = $dt->cs;
            $ls = $dt->ls;
            $nos = $dt->nos;
            $buz = $dt->buz;
            
            $query=$this->db->query("update init_call set mainbd='$bdid', cstatus='$cs', lstatus='$ls' WHERE cmpid_id='$cid'");
            
            $query=$this->db->query("SELECT max(id) mid FROM tblcallevents where cid_id='$cid'");
            $data1 = $query->result();
            $mid = $data1[0]->mid;
            
            
            $query=$this->db->query("SELECT id FROM init_call where cmpid_id='$cid'");
            $data2 = $query->result();
            $inid = $data2[0]->id;
            
            $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, purpose_achieved, fwd_date, actontaken, nextaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type,mom,plan) 
                                                  VALUES ('$mid', '$mid','yes', '$date', 'yes', 'Write MOM', 'yes','$date','6','$bdid','$inid','81','After RP Meeting MOM','$cs','$bdid','$date','$date','updated','$mom','1')");
                $ntid = $this->db->insert_id();
                $query=$this->db->query("update tblcallevents set nextCFID='$ntid' WHERE id='$mid'");
                
                
                $query=$this->db->query("SELECT max(id) mid FROM tblcallevents WHERE cid_id='$inid' and id<$ntid");
                  $data3 =  $query->result();
                  $mid = $data3[0]->mid;
          
                $query=$this->db->query("update tblcallevents set status_id=3, actiontype_id=3, remarks='schedule meeting completed', assignedto_id='$bdid', user_id='$bdid',mtype='RP' WHERE id='$mid'");
            
        }
    }
    
    public function get_testc(){
        $query=$this->db->query("SELECT company_master.*,init_call.mainbd,init_call.cstatus FROM company_master right join init_call on init_call.cmpid_id=company_master.id");
        return $query->result();
    }
    
    public function get_testrp(){
        $query=$this->db->query("SELECT * FROM test2");
        $data =  $query->result();
        foreach($data as $d){
        $cid = $d->cid;
        $mbd = $d->mbd;
        $pst = $d->pst;
        $cs = $d->cs;
        $query=$this->db->query("update init_call set mainbd='$mbd',apst='$pst',cstatus='$cs',bpst='100103' WHERE cmpid_id='$cid'");
        } 
    }
    
    public function get_testaltf(){
        $query=$this->db->query("SELECT * FROM altd");
        $dat = $query->result();
        foreach($dat as $da)
        {
            $bd = $da->cid;
            $xbd = $da->bd;
            $cid = $da->xbd;
            $query=$this->db->query("update init_call set exbd='$xbd', mainbd='$bd' where cmpid_id='$cid'");
        }   
    }
    
    public function get_testtfu(){
        $query=$this->db->query("SELECT * FROM alfu");
        $dat = $query->result();
        foreach($dat as $da)
        {
            $cid = $da->cid;
            $fo = $da->fo;
            $up = $da->up;
            $query=$this->db->query("update init_call set focus_funnel='$fo', upsell_client='$up' where id='$cid'");
        }   
    }
    
    public function pstreview($rtdatet,$tasktype,$bdid,$mlink,$pstid){
        $this->db->query("INSERT INTO pstreview(sdatet,tasktype,bdid,meetinglink,pstid) VALUES ('$rtdatet','$tasktype','$bdid','$mlink','$pstid')");
        return $this->db->insert_id();  
    }
    
    
    public function get_pstreview($uid){
        $query = $this->db->query("SELECT * FROM pstreview WHERE pstid='$uid'");
        return $query->result();
    }
    
    
    public function get_testtc(){
        $query=$this->db->query("SELECT * FROM user_details WHERE admin_id='45' and status='active' and type_id=3");
        $dat = $query->result();
        foreach($dat as $da)
        {
            $uid = $da->user_id;
            $query=$this->db->query("SELECT DISTINCT init_call.cmpid_id FROM tblcallevents t1 JOIN init_call on init_call.id=t1.cid_id  WHERE t1.assignedto_id = '$uid' and t1.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=t1.cid_id)");
            $data = $query->result();
            foreach($data as $d){
                $cid = $d->cmpid_id;
                $this->db->query("INSERT INTO test2(cid,mbd) VALUES ('$cid','$uid')");
                $cid = $this->db->insert_id();
        }
    }
    
    
        
        
        $query=$this->db->query("SELECT * FROM user_details WHERE admin_id='45' and status='active' and type_id=3");
        $dat = $query->result();
        foreach($dat as $da)
        {
            $uid = $da->user_id;
        
            for($i=1;$i<=11;$i++){
            $query=$this->db->query("SELECT DISTINCT init_call.cmpid_id FROM tblcallevents t1 JOIN init_call on init_call.id=t1.cid_id WHERE t1.assignedto_id = '$uid' and t1.status_id='$i' and t1.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=t1.cid_id)");
            $data1= $query->result();
                foreach($data1 as $d){
                    $cid = $d->cmpid_id;
                    $this->db->query("update test2 set cs='$i' where cid ='$cid' and mbd='$uid'");
                }
            
            }
        }
    }
    
    
    public function get_updatetest($cname,$uid){
        $query=$this->db->query("SELECT init_call.* FROM company_master join init_call ON init_call.cmpid_id=company_master.id where company_master.compname='$cname' and init_call.creator_id='$uid'");
        $data= $query->result();
        if(sizeof($data)>0){
        $inid  = $data[0]->id;
        $cid = $data[0]->cmpid_id;
        
        $query1=$this->db->query("SELECT * FROM `tblcallevents` WHERE cid_id='$inid' ORDER BY id DESC LIMIT 1");
        $data1 = $query1->result();
        $tid  = $data1[0]->id;
        $lid = $data1[0]->lastCFID;
        $nid = $data1[0]->nextCFID;
        $tdate = $data1[0]->updateddate;
        $bdid = $data1[0]->user_id;
        
        $query=$this->db->query("update test1 set cid='$cid',initid='$inid',tid='$tid',lid='$lid',nid='$nid' WHERE cname='$cname' and uid='$uid'");
        
        $query2=$this->db->query("SELECT * FROM `test1` WHERE cname='$cname' and uid='$uid'");
        $data2 = $query2->result();
        
        $mom = $data2[0]->mom;
        $pstid = $data2[0]->pstid;
        $calldate = $data2[0]->calldate;
        $remarka = $data2[0]->remarka;
        $remarkb = $data2[0]->remarkb;
        $remarkc = $data2[0]->remarkc;
        $cstatus = $data2[0]->cstatus;
        $noofschool = $data2[0]->noofschool;
        $budget = $data2[0]->budget;

        $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type,mom) 
        VALUES ('$tid', '0', '', '', '$tdate', 'yes', 'Call for Clarity', 'NA','NA','yes','$tdate','6','$uid','$inid','6','After Meeting Write MOM','3','$uid','$tdate','$tdate','updated','$mom')");
        $tcid =  $this->db->insert_id();
        $query=$this->db->query("update tblcallevents set nextCFID='$tcid' WHERE id='$tid'");
        
        if($remarka!=''){
            $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type) 
            VALUES ('$tcid', '0', '', '', '$calldate', 'yes', 'Call for Clarity', 'NA','NA','no','$calldate','1','$pstid','$inid','1','$remarka','$cstatus','$pstid','$calldate','$calldate','updated')");
            $ntcida =  $this->db->insert_id();
            $query=$this->db->query("update tblcallevents set nextCFID='$ntcida' WHERE id='$tcid'");
            
        }
        if($remarkb!=''){
            $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type) 
            VALUES ('$ntcida', '0', '', '', '$calldate', 'yes', 'Call for Clarity', 'NA','NA','no','$calldate','1','$pstid','$inid','1','$remarkb','$cstatus','$pstid','$calldate','$calldate','updated')");
            $ntcidb =  $this->db->insert_id();
            $query=$this->db->query("update tblcallevents set nextCFID='$ntcidb' WHERE id='$ntcida'");
        }
        if($remarkc!=''){
            $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type) 
            VALUES ('$ntcidb', '0', '', '', '$calldate', 'yes', 'Call for Clarity', 'NA','NA','no','$calldate','1','$pstid','$inid','1','$remarkc','$cstatus','$pstid','$calldate','$calldate','updated')");
            $ntcidc =  $this->db->insert_id();
            $query=$this->db->query("update tblcallevents set nextCFID='$ntcidc' WHERE id='$ntcidb'");
        }
        
        $query=$this->db->query("update init_call set apst='$pstid', noofschools='$noofschool', fbudget='$budget' WHERE id='$inid'");
        
        $query3=$this->db->query("SELECT MAX(id) mid FROM `tblcallevents` WHERE cid_id='$inid'");
        $data3 = $query3->result();
        $mid = $data3[0]->mid;
        
        
            $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type) 
            VALUES ('$mid', '0', '', '', '$calldate', 'yes', 'Proposal Upload', 'NA','NA','no','$calldate','7','100103','$inid','1','Proposal Uploaded','$cstatus','100103','$calldate','$calldate','updated')");
            $ntcidd =  $this->db->insert_id();
            $query=$this->db->query("update tblcallevents set nextCFID='$ntcidd' WHERE id='$mid'");
            
            
            if($cstatus==9){$this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type) 
            VALUES ('$ntcidd', '0', '', '', '$calldate', 'no', 'Call for Closure', 'NA','NA','no','$calldate','1','45','$inid','1','Call for Closure','$cstatus','45','$calldate','$calldate','updated')");
            $ntcide =  $this->db->insert_id();
            $query=$this->db->query("update tblcallevents set nextCFID='$ntcide' WHERE id='$ntcidd'");
            
            }elseif($cstatus==6){$this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type) 
                VALUES ('$ntcidd', '0', '', '', '$calldate', 'no', 'Call for Very Positive', 'NA','NA','no','$calldate','1','45','$inid','1','Call for Very Positive','$cstatus','45','$calldate','$calldate','updated')");
                $ntcide =  $this->db->insert_id();
                $query=$this->db->query("update tblcallevents set nextCFID='$ntcide' WHERE id='$ntcidd'");
            }else{
                $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type) 
                VALUES ('$ntcidd', '0', '', '', '$calldate', 'no', 'Call for Clarity', 'NA','NA','no','$calldate','1','$bdid','$inid','1','Call for Clarity','$cstatus','$bdid','$calldate','$calldate','updated')");
                $ntcide =  $this->db->insert_id();
                $query=$this->db->query("update tblcallevents set nextCFID='$ntcide' WHERE id='$ntcidd'");
            }
        }else{}
    }
    
    public function get_bargdetail($uid,$tdate){
        $query=$this->db->query("SELECT * FROM barginmeeting WHERE user_id='$uid' ORDER BY barginmeeting.id DESC");
        return $query->result();
    }
    
    
    public function get_bargdetailcid($cid){
        $query=$this->db->query("SELECT * FROM barginmeeting WHERE user_id='$uid' ORDER BY barginmeeting.id DESC");
        return $query->result();
    }
    
    
    
    public function get_bmdata($id){
        $query=$this->db->query("SELECT * FROM barginmeeting WHERE id='$id'");
        return $query->result();
    }
    
    public function get_bmalldata($id){
        $query=$this->db->query("SELECT * FROM barginmeeting LEFT JOIN company_master ON company_master.id=barginmeeting.cid LEFT JOIN company_contact_master ON company_contact_master.id=barginmeeting.ccid LEFT JOIN init_call ON init_call.id=barginmeeting.inid LEFT JOIN tblcallevents ON tblcallevents.id=barginmeeting.tid WHERE barginmeeting.id='$id'");
        return $query->result();
    }
    
    public function get_positive(){
        $query=$this->db->query("SELECT DISTINCT(cid_id) FROM tblcallevents LEFT JOIN init_call on init_call.id=tblcallevents.cid_id left JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE init_call.cstatus=6 and user_details.type_id=4");
        return $query->result();
    }
    
    
    
    public function get_pvpdetail($uid){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        $query=$this->db->query("SELECT COUNT(CASE WHEN cstatus=6 THEN cstatus END) tp,COUNT(CASE WHEN cstatus=9 THEN cstatus END) tvp,SUM(CASE WHEN cstatus=6 THEN noofschools END) pos,SUM(CASE WHEN cstatus=9 THEN noofschools END) vpos, SUM(CASE WHEN cstatus=6 THEN fbudget END) pfb,SUM(CASE WHEN cstatus=9 THEN fbudget END) vpfb, COUNT(CASE WHEN cstatus=12 THEN cstatus END) tpnap,COUNT(CASE WHEN cstatus=13 THEN cstatus END) tvpnap,SUM(CASE WHEN cstatus=12 THEN noofschools END) pnapos ,SUM(CASE WHEN cstatus=13 THEN noofschools END) vpnapos, SUM(CASE WHEN cstatus=12 THEN fbudget END) pnapfb, SUM(CASE WHEN cstatus=13 THEN fbudget END) vpnapfb FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd WHERE $text and init_call.apst is not null and init_call.mainbd is not null");
        return $query->result();
    }
    
    
    public function get_vpd($code,$uid){
        
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        
        if($code==1){$txt = "cstatus=6";}
        if($code==2){$txt = "cstatus=9";}
        if($code==3){$txt = "cstatus=6";}
        if($code==4){$txt = "cstatus=9";}
        if($code==5){$txt = "cstatus=6";}
        if($code==6){$txt = "cstatus=9";}
        if($code==7){$txt = "cstatus=12";}
        if($code==8){$txt = "cstatus=13";}
        if($code==9){$txt = "cstatus=12";}
        if($code==10){$txt = "cstatus=13";}
        if($code==11){$txt = "cstatus=12";}
        if($code==12){$txt = "cstatus=13";}
        if($code==13){
            $query=$this->db->query("SELECT init_call.id inid,init_call.apst pst, init_call.mainbd mbd FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd WHERE $text and init_call.apst is not null and init_call.mainbd is not null and init_call.cstatus=6 or init_call.cstatus=9 and apst is not null and mainbd is not null");
            return $query->result();
        }else{
            $query=$this->db->query("SELECT init_call.id inid,init_call.apst pst, init_call.mainbd mbd FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd WHERE $text and init_call.apst is not null and init_call.mainbd is not null and apst is not null and mainbd is not null and $txt");
            return $query->result();
        }
    }
    
    
    
    
    
    
    
    
    public function get_positivebypst($pst){
        $query=$this->db->query("SELECT DISTINCT(cid_id) FROM tblcallevents LEFT JOIN init_call on init_call.id=tblcallevents.cid_id left JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE init_call.cstatus=6 and user_details.type_id=4 and user_details.user_id='$pst'");
        return $query->result();
    }
    
    public function get_vpositive(){
        $query=$this->db->query("SELECT DISTINCT(cid_id) FROM tblcallevents LEFT JOIN init_call on init_call.id=tblcallevents.cid_id left JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE init_call.cstatus=9 and user_details.type_id=4");
        return $query->result();
    }
    
    public function get_vpositivebypst($pst){
        $query=$this->db->query("SELECT DISTINCT(cid_id) FROM tblcallevents LEFT JOIN init_call on init_call.id=tblcallevents.cid_id left JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE init_call.cstatus=9 and user_details.type_id=4 and user_details.user_id='$pst'");
        return $query->result();
    }
    
    public function start_rpm($uid,$startm,$company_name,$cphoto,$lat,$lng,$smid,$bscid){
        $query=$this->db->query("update barginmeeting set company_name='$company_name',cphoto='$cphoto',startm='$startm',slatitude='$lat',slongitude='$lng',status='Start' WHERE id='$smid'");
        
        $query=$this->db->query("update company_master set compname='$company_name' WHERE id='$bscid'");
        
        $this->db->query("INSERT INTO notify(uid,type,sms) VALUES ('$uid','1','Bargin Meeting Started $company_name')");
        return  $smid;
    }
    
    public function close_rpm($uid,$closem,$caddress,$cpname,$cpdes,$cpno,$cpemail,$lat,$lng,$type,$priority,$cmid,$bmcid,$bmccid,$bminid,$bmtid){
            
            if($type=='RP'){
            $query=$this->db->query("update barginmeeting set closem='$closem',clatitude='$lat',clongitude='$lng',status='RPClose' WHERE id='$cmid'");
            }
            else{
                $query=$this->db->query("update barginmeeting set closem='$closem',clatitude='$lat',clongitude='$lng',status='Close' WHERE id='$cmid'");
                $query=$this->db->query("update tblcallevents set remarks='Meeting Close With No RP',nextCFID='$bmtid' WHERE id='$bmtid'");
            }
            
            
            $query=$this->db->query("update company_master set address='$caddress' WHERE id='$bmcid'");
            
            $query=$this->db->query("update company_contact_master set contactperson='$cpname',emailid='$cpemail',phoneno='$cpno',designation='$cpdes' WHERE id='$bmccid'");
            
            $query=$this->db->query("update tblcallevents set priority='$priority',mtype='$type' WHERE id='$bmtid'");
            
            $this->db->query("INSERT INTO notify(uid,type,sms) VALUES ('$uid','1','Bargin Meeting Closed')");
            return  $cmid;
    }
    
    
    public function add_task($uid,$ntinid,$ntaction,$ntstatus,$ntppose,$ntnextaction,$date){
        if($ntaction==3){
            
            $data = $this->Menu_model->get_initbyid($ntinid);
            $bcid = $data[0]->cmpid_id;
            
            $data2 = $this->Menu_model->get_ccdbyid($bcid);
            $ccid = $data2[0]->id;
            
            $query=$this->db->query("SELECT MAX(id) mid FROM `tblcallevents` WHERE cid_id='$ntinid'");
            $data1 = $query->result();
            $ltid = $data1[0]->mid;
            
            $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, purpose_achieved, fwd_date, actontaken, nextaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type,plan) VALUES ('$ltid', '0','no', '$date', 'no', '$ntppose', 'no','$date','4','$uid','$ntinid','66','','1','$uid','$date','$date','updated',1)");
            $ntid = $this->db->insert_id();
            
            $query=$this->db->query("update tblcallevents set nextCFID='$ntid' WHERE id='$ltid'");
            
            $this->db->query("INSERT INTO barginmeeting(storedt,user_id,cid) VALUES ('$date','$uid','$bcid')");
            $bmid = $this->db->insert_id();
            
            $query=$this->db->query("update barginmeeting set ccid='$ccid',inid='$ntinid',tid='$ntid' WHERE id='$bmid'");
            
            $this->db->query("INSERT INTO notify(uid,type,sms) VALUES ('$uid','1','Bargin Meeting Created form Funnel')");
            
        }else{
       $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type,plan) 
       VALUES ('0', '0', '', '', '$date', 'no', '$ntnextaction', 'NA','NA','no','$date','$ntaction','$uid','$ntinid','$ntppose','','$ntstatus','$uid','$date','$date','updated','1')");
       $tblid = $this->db->insert_id();
       
       
        $query = $this->db->query("SELECT * FROM action WHERE id='$ntaction'");
        $data2 = $query->result();
        $acname = $data2[0]->name;
        $query = $this->db->query("SELECT * FROM init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE init_call.id='$ntinid'");
        $data3 = $query->result();
        $cname = $data3[0]->compname;
        $cstatus = $data3[0]->cstatus;
        
        $query = $this->db->query("SELECT * FROM status WHERE id='$cstatus'");
        $data5 = $query->result();
        $sname = $data5[0]->name;
        
        $msg = $acname." Task Create for ".$cname." And Current Status is ".$sname;
       
       
       $this->db->query("INSERT INTO notify(uid,type,sms) VALUES ('$uid','1','$msg')");
        }
    }
    
    public function add_cont($cid, $cdate, $contactperson, $designation, $phoneno, $emailid, $primary){
       
       $this->db->query("update company_contact_master set type='alternate'  where company_id='$cid'");
       
       $this->db->query("INSERT INTO company_contact_master(contactperson, emailid, phoneno, designation, type, createddate, company_id) VALUES ('$contactperson', '$emailid', '$phoneno', '$designation', '$primary', '$cdate', '$cid')");
       $ccid = $this->db->insert_id();
    }
    
    public function submit_company($uid, $compname, $website, $country, $city,$state, $draft, $address, $ctype, $budget, $compconname, $emailid, $phoneno, $draftop, $designation, $top_spender,$upsell_client,$focus_funnel){
        
        $assign_to = $uid;
        $status = 1;
        $remark_msg = 'Research done';
        $action = 1;
        $purpose = 1;
        $next_action_id = 1;
        $next_action = 'Will do research on client complete details';
        date_default_timezone_set("Asia/Kolkata");
        $date = date('Y-m-d H:i:s');
        
        $city = $this->Menu_model->get_citybyid($city);
        $state = $this->Menu_model->get_statebyid($state);
        $country = $this->Menu_model->get_countrybyid($country);
        $cdate=date('Y-m-d');

       $this->db->query("INSERT INTO company_master(compname, draft, budget, address, website, createddate, city, country, partnerType_id, state) VALUES ('$compname', '$draft', '$budget', '$address', '$website', '$cdate', '$city', '$country', '$ctype', '$state')");
       $cid = $this->db->insert_id();
       
       $this->db->query("INSERT INTO company_contact_master(contactperson, emailid, phoneno, designation, type, createddate, company_id) VALUES ('$compconname', '$emailid', '$phoneno', '$designation', 'primary', '$cdate', '$cid')");
       $ccid = $this->db->insert_id();
       
       $this->db->query("INSERT INTO init_call(draft, proposal, createDate, topspender, noofschools, proposaldate, proposal_type, proposal_amt, cmpid_id, creator_id,upsell_client,focus_funnel,mainbd,cstatus) VALUES ('$draft', '$emailid', '$cdate', '$top_spender', '0', 'NA', 'NA', 'NA','$cid','$uid','$upsell_client','$focus_funnel','$uid','$status')");
       $inid = $this->db->insert_id();
       
       
       $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type) VALUES ('0', '0', '$draft', '', '$date', '$action', 'Research & Data Collection', 'NA','NA','no','$date','$next_action_id','$assign_to','$inid','$purpose','$remark_msg','$status','$assign_to','$date','$date','updated')");
       $tblid = $this->db->insert_id();
       
       $this->db->query("INSERT INTO notify(uid,type,sms) VALUES ('$uid','1','New Lead Added Company Name is $compname')");
    }
    
    
    public function submit_bmcompany($uid, $compname, $website, $country, $city,$state, $draft, $address, $ctype, $budget, $compconname, $emailid, $phoneno, $draftop, $designation, $top_spender,$upsell_client,$focus_funnel,$cid,$ccid,$inid,$tid,$bmid){
        
        $query = $this->db->query("SELECT * FROM init_call WHERE cmpid_id='$cid'");
        $data = $query->result();
        $olsstatus = $data[0]->cstatus;
        if($olsstatus==1){$status = 3;}
        elseif($olsstatus==8){$status = 3;}
        elseif($olsstatus==2){$status = 3;}
        else{$status = $olsstatus;}
        
        $assign_to = $uid;
        
        $remark_msg = 'RP Meeting done';
        $action = 3;
        $purpose = 1;
        $next_action_id = 6;
        $next_action = 'Write MOM';
        date_default_timezone_set("Asia/Kolkata");
        $date = date('Y-m-d H:i:s');
        $cdate=date('Y-m-d');
        
        $city = $this->Menu_model->get_citybyid($city);
        $state = $this->Menu_model->get_statebyid($state);
        $country = $this->Menu_model->get_countrybyid($country);
        

       $this->db->query("update company_master set compname='$compname', draft='$draft', budget='$budget', address='$address', website='$website', createddate='$cdate', city='$city', country='$country', partnerType_id='$ctype', state='$state' where id='$cid'");
       $cid = $this->db->insert_id();
       
       $this->db->query("update company_contact_master set contactperson='$compconname', emailid='$emailid', phoneno='$phoneno', designation='$designation', createddate='$cdate' where id='$ccid'");
       $ccid = $this->db->insert_id();
       
       $this->db->query("update init_call set draft='$draft', createDate='$cdate', topspender='$top_spender', creator_id='$uid',upsell_client='$upsell_client',focus_funnel='$focus_funnel',mainbd='$uid',cstatus='$status' where id='$inid'");
       
       $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type) VALUES ('$tid', '0', '$draft', '', '$date', 'no', '$next_action', 'NA','NA','no','$date','$next_action_id','$assign_to','$inid','$purpose','$remark_msg','$status','$assign_to','$date','$date','updated')");
       $tblid = $this->db->insert_id();
       $query=$this->db->query("update tblcallevents set nextCFID='$tblid' WHERE id='$tid'");
       
        
        $remark_msg = 'RP Meeting done';
        $purpose = 1;
        $next_action_id = 2;
        $next_action = 'Write Thanks Mail';
       
       $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type) VALUES ('$tblid', '0', '$draft', '', '$date', 'no', '$next_action', 'NA','NA','no','$date','$next_action_id','$assign_to','$inid','$purpose','$remark_msg','$status','$assign_to','$date','$date','updated')");
       $tblid = $this->db->insert_id();
       
       $query=$this->db->query("update barginmeeting set status='Close' WHERE id='$bmid'");
       
       $this->db->query("INSERT INTO notify(uid,type,sms) VALUES ('$uid','1','RP Lead Added in Funnel Company Name is $compname')");
    }
    
    public function set_uprpmmom($uid,$tblid,$mom){
        
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE id='$tblid'");
        $data = $query->result();
        $inid = $data[0]->cid_id;
        $draft = $data[0]->draft;
        date_default_timezone_set("Asia/Kolkata");
        $date = date('Y-m-d H:i:s');
        $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type) VALUES ('$tblid', '0', '$draft', '', '$date', '1', '1', 'NA','NA','yes','$date','1','100101','$inid','1','test','3','100101','$date','$date','updated')");
       $nextid = $this->db->insert_id();
       
       $this->db->query("update tblcallevents set mom='$mom' where id='$tblid'");
       $tblid = $this->db->insert_id();
       
    }
    
    public function submit_task($tid,$uid,$actontaken,$purpose,$noremark,$pyremark_msg,$pnoremark_msg,$ystatus){
        
        $tdate = date('Y-m-d H:m:s');
        
       $this->db->query("update taskdetail set remark='$pyremark_msg',completed='$tdate',initiated='$tdate',cstatus='$ystatus' where id='$tid'");
        
    }
    
    public function uploadfile($filname, $uploadPath){
        $fn = $_FILES['file']['name'] = $_FILES['filname']['name'];
        $_FILES['file']['type']     = $_FILES['filname']['type']; 
        $_FILES['file']['tmp_name'] = $_FILES['filname']['tmp_name']; 
        $_FILES['file']['error']     = $_FILES['filname']['error']; 
        $_FILES['file']['size']     = $_FILES['filname']['size'];
        $config['upload_path'] = $uploadPath; 
        $config['allowed_types'] = '*'; 
        $config['file_name'] = $fn;
        $this->load->library('upload', $config);
        $this->upload->do_upload('file');
        $uploadData = $this->upload->data();
        $filename = $uploadData['file_name'];
        return $fpn = $uploadPath.$filename;
    }
    
    
    public function cphotofile($filname, $uploadPath){
        $fn = $_FILES['file']['name'] = $_FILES['cphoto']['name'];
        $_FILES['file']['type']     = $_FILES['cphoto']['type']; 
        $_FILES['file']['tmp_name'] = $_FILES['cphoto']['tmp_name']; 
        $_FILES['file']['error']     = $_FILES['cphoto']['error']; 
        $_FILES['file']['size']     = $_FILES['cphoto']['size'];
        $config['upload_path'] = $uploadPath; 
        $config['allowed_types'] = '*'; 
        $config['file_name'] = $fn;
        $this->load->library('upload', $config);
        $this->upload->do_upload('file');
        $uploadData = $this->upload->data();
        $filename = $uploadData['file_name'];
        return $fpn = $uploadPath.$filename;
    }
    
    
    
    
    
    public function submit_day($wffo,$flink,$user_id,$lat,$lng,$do){
        date_default_timezone_set("Asia/Kolkata");
        $date = date('Y-m-d H:i:s');
        $da = date('Y-m-d');
        if($do==0){
        $this->db->query("INSERT INTO user_day(user_id, ustart, usimg, slatitude, slongitude,wffo) VALUES ('$user_id','$date','$flink','$lat','$lng','$wffo')");
        $id =  $this->db->insert_id();
        
        $this->db->query("UPDATE tblcallevents SET appointmentdatetime='$date', plan=0 WHERE nextCFID=0 and cast(appointmentdatetime as DATE)<'$da' and remarks!='Company Created' and user_id='$user_id'");
        
        
        $this->db->query("INSERT INTO notify(uid,type,sms) VALUES ('$user_id','1','You Are Started Your Day at $date')");
        return $id;
        }
        if($do==1){
            $tdate=date('Y-m-d');
            $this->db->query("Update user_day set uclose='$date',ucimg='$flink',clatitude='$lat',clongitude='$lng' where cast(sdatet as DATE)='$tdate' and user_id='$user_id'");
            $this->db->query("INSERT INTO notify(uid,type,sms) VALUES ('$user_id','1','You Are Closed Your Day at $date')");
        }
    }
    
    
    public function delete_r(){
        $query=$this->db->query("SELECT *,company_master.id cid FROM company_master LEFT JOIN init_call ON init_call.cmpid_id=company_master.id where company_master.drequest=1");
        return $query->result();
    }
    
    
    public function proposal_apr($uid){
        $query=$this->db->query("SELECT *,proposal.id aprid FROM proposal LEFT JOIN tblcallevents ON tblcallevents.id=proposal.tid LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE proposal.apr=0 and user_details.admin_id='$uid'");
        return $query->result();
    }
    
    
    public function request_apr(){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM bdrequest where assignto=0");
        return $query->result();
    }
    
    public function request_admin_apr($urid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM bdrequest where assignto=0 and bd_id='$urid'");
        return $query->result();
    }
    
    
    public function REQ_APR($id){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("update bdrequest set assignto=1 where id='$id'");
    }
    
    
    
    
    
    
    public function notify($uid){
        $query=$this->db->query("SELECT * FROM notify where view=0 and uid='$uid'  ORDER BY notify.sdatet DESC");
        return $query->result();
    }
    
    public function Pro_Apr($aprid,$adid,$apr,$remark){
        $date=date('Y-m-d H:i:s');
        $query=$this->db->query("SELECT tid FROM proposal where id='$aprid'");
        $data = $query->result();
        $tid = $data[0]->tid;
        
        
        $query=$this->db->query("update proposal set apr='$apr',aprdatet='$date',remark='$remark' where id='$aprid'");
        if($apr=='2'){
            $this->db->query("INSERT INTO tblcallevents(draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, status_id, user_id, date, updateddate, updation_data_type) select draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, status_id, user_id, date, updateddate, updation_data_type from tblcallevents where id='$tid'");
            $nextid = $this->db->insert_id();
            $this->db->query("update tblcallevents set lastCFID='$tid',nextCFID=0,actontaken='no', purpose_achieved='no', plan=0, appointmentdatetime='$date',fwd_date='$date',date='$date', updateddate='$date' where id='$nextid'");
        }
        
        if($apr=='1'){
            $this->db->query("INSERT INTO tblcallevents(draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, status_id, user_id, date, updateddate, updation_data_type) select draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, status_id, user_id, date, updateddate, updation_data_type from tblcallevents where id='$tid'");
            $nextid = $this->db->insert_id();
            $this->db->query("update tblcallevents set lastCFID='$tid',nextCFID=0,actontaken='no', purpose_achieved='no',plan=0, appointmentdatetime='$date',fwd_date='$date',date='$date', updateddate='$date', actiontype_id=2,purpose_id=26 where id='$nextid'");
        }
        
        
    }
    
    
    public function hand_Apr($aprid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("update client_handover set status='1' where id='$aprid'");
    }
    
    
    public function hand_Delete($aprid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("Delete FROM client_handover where id='$aprid'");
        $query=$db3->query("Delete FROM handover_account where handover_id='$aprid'");
        $query=$db3->query("Delete FROM spd where cid='$aprid'");
    }
    
    
    public function delete_cmp($cid){
        $query=$this->db->query("update init_call set mainbd=null,apst='100116',bpst=null where cmpid_id='$cid'");
        $query=$this->db->query("update company_master set drequest=2 where id='$cid'");
    }
    
    
    public function read_notify($id){
        $query=$this->db->query("update notify set view=1 where id='$id'");
    }
    
    
    
    public function submit_bdrequest($uid,$targetd,$request_type,$remark,$cid,$tyschool,$noschool,$location,$compname){
        
        $data = $this->Menu_model->get_userbyid($uid);
        $bdname = $data[0]->name;
        $data1 = $this->Menu_model->get_cdbyid($cid);
        if($data1){$compname = $data1[0]->compname;}
        
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("INSERT INTO bdrequest(targetd,bd_id,request_type,remark,cid,schooltype,noofschool,vlocation,assignto,bd_name,cname) VALUES ('$targetd','$uid','$request_type','$remark','$cid','$tyschool','$noschool','$location','0','$bdname','$compname')");
        $tid = $db3->insert_id();
        
        $msg = $request_type." Task Created By ".$bdname;
        
        $query=$db3->query("INSERT INTO bdrequestlog(tid,tby,remark,detail) VALUES ('$tid','$bdname','$remark','$msg')");
            return $db3->insert_id();    
    }
    
    
    public function get_handover_detail($uid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("select *,client_handover.id as cid from client_handover LEFT join handover_account on handover_account.handover_id=client_handover.id LEFT join fm_timeline on fm_timeline.handover_id=client_handover.id where client_handover.bd_id='$uid'");
        return $query->result();
    }
    
    public function bdrequest($uid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT COUNT(*) cont,COUNT(CASE WHEN assignto=0 then assignto end) pass,COUNT(CASE WHEN assignto!=0 then assignto end) tass,COUNT(CASE WHEN assignto>1 then assignto end) ini,COUNT(CASE WHEN status=0 then status end) pend, COUNT(CASE WHEN status=1 then status end) as close FROM bdrequest WHERE bd_id='$uid'");
        return $query->result();
    }
    
    public function bdallrequest(){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT COUNT(*) cont,COUNT(CASE WHEN assignto=0 then assignto end) pass,COUNT(CASE WHEN assignto!=0 then assignto end) tass,COUNT(CASE WHEN assignto>1 then assignto end) ini,COUNT(CASE WHEN status=0 then status end) pend, COUNT(CASE WHEN status=1 then status end) as close FROM bdrequest");
        return $query->result();
    }
    
  public function getaddress($lat,$lng)
  {
     $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
     $json = @file_get_contents($url);
     $data=json_decode($json);
     $status = $data->status;
     if($status=="OK")
     {
       return $data->results[0]->formatted_address;
     }
     else
     {
       return false;
     }
  }
    
    

}