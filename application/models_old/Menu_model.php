<?php
date_default_timezone_set("Asia/Calcutta");
class Menu_model extends CI_Model{
    
    public function user_login($user,$pwd){
        $query=$this->db->query("SELECT * FROM user_details WHERE username='$user' AND password='$pwd'");
        return $query->result();
    }
    
    public function get_pstpopup($ur_id){
        $tdatet= date('Y-m-d H:i:s');
        $tdate= date('Y-m-d');
        $data = "";
        $query=$this->db->query("SELECT COUNT(init_call.id) b FROM init_call WHERE apst is not null and apst='$ur_id' AND init_call.id NOT IN (SELECT cid_id FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE cid_id IN (SELECT DISTINCT id FROM init_call WHERE apst is not null and apst='$ur_id') and tblcallevents.nextCFID!='0' and user_details.type_id='4' and tblcallevents.actiontype_id='1' and actontaken='yes' and purpose_achieved='yes' GROUP BY cid_id)");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href=''><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Company PST Assign but Not Work on This</b></div><a/>";}
        $query=$this->db->query("SELECT COUNT(*) b, COUNT(CASE WHEN init_call.cstatus='1' THEN init_call.cstatus END) ope, COUNT(CASE WHEN init_call.cstatus='8' THEN init_call.cstatus END) rpe, COUNT(CASE WHEN init_call.cstatus='2' THEN init_call.cstatus END) rec, COUNT(CASE WHEN init_call.cstatus='3' THEN init_call.cstatus END) ten FROM init_call LEFT JOIN allreviewdata ON allreviewdata.inid=init_call.id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE init_call.apst='$ur_id' and allreviewdata.inid is null");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='AlertDetail/1'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Company Not Taken any Review by you</b></div><a/>";}
        return $data; 
    }
    
    public function get_BDRBoxONB2($uid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT request_type, COUNT(*) cont,rysn FROM bdrequest where bd_id='$uid' and onnew='1' and status='1' GROUP BY request_type,rysn ORDER BY `bdrequest`.`request_type` ASC;");
        return $query->result();
    }
    
    
    
    public function get_joincallpcode($pcode){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM joincall where projectcode='$pcode'");
        return $query->result();
    }
    
    
    public function get_yearbybd($bdid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT client_handover.project_year,count(*) cont  FROM spd LEFT JOIN client_handover on spd.project_code = client_handover.projectcode WHERE client_handover.bd_id='$bdid' and client_handover.project_year!=''  group by client_handover.project_year ORDER BY `client_handover`.`project_year` DESC");
        return $query->result();
    }
    
    public function get_Programbypcode($pcode){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT *, (SELECT COUNT(*) FROM spd WHERE spd.project_code = client_handover.projectcode) AS tspd, (SELECT GROUP_CONCAT(DISTINCT user_detail.fullname) FROM spd LEFT JOIN user_detail ON user_detail.id=spd.pi_id WHERE spd.project_code = client_handover.projectcode) AS pia, (SELECT GROUP_CONCAT(DISTINCT user_detail.fullname) FROM spd LEFT JOIN user_detail ON user_detail.id=spd.ins_id WHERE spd.project_code = client_handover.projectcode) AS imp FROM client_handover WHERE client_handover.projectcode = '$pcode'  ORDER BY `client_handover`.`project_year` DESC");
        return $query->result();
    }
    
    public function get_fmtaskAssing($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT * FROM sub_task WHERE project_code='$pcode'");
        return $query->result();
    }
    
    
    public function get_printprocess($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT * FROM `model_m` WHERE model_name='Backdrop Printing' ORDER BY `model_m`.`stage` ASC");
        return $query->result();
    }
    
    
    
    public function get_fbackdrop($pcode,$process,$part){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT dailywork.video,workclose.user_name,process_name,workclose.startt,workclose.closet,workclose.workdone_img,taskmstore.image timage FROM dailywork LEFT JOIN taskmstore ON taskmstore.wid=dailywork.id LEFT JOIN workclose ON workclose.wid=dailywork.id WHERE batchno='$pcode' and model_name='Backdrop Printing'");
        return $query->result();
    }
    
    
    public function get_fusermanual($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT dailywork.video,workclose.user_name,process_name,workclose.startt,workclose.closet FROM dailywork LEFT JOIN workclose ON workclose.wid=dailywork.id WHERE batchno='$pcode' and model_name='User Manual Printing'");
        return $query->result();
    }
    
    
    public function get_fpacking($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT * FROM `boxpreparing` WHERE project='$pcode'");
        return $query->result();
    }
    
    
    
    public function get_ftrainingmanual($pcode,$process,$part){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT dailywork.video,workclose.user_name,process_name,workclose.startt,workclose.closet,workclose.workdone_img,taskmstore.image timage FROM dailywork LEFT JOIN taskmstore ON taskmstore.wid=dailywork.id LEFT JOIN workclose ON workclose.wid=dailywork.id WHERE batchno='$pcode' and model_name='Training Manual Printing'");
        return $query->result();
    }
    
    
    public function get_flogistic($pcode){
        $db2 = $this->load->database('db3', TRUE);
        $query=$db2->query("SELECT spdlogic.*,spdlogic.spd sid,(SELECT spd.sname FROM spd WHERE spd.id=sid) sname,(SELECT spd.scity FROM spd WHERE spd.id=sid) scity,(SELECT spd.sstate FROM spd WHERE spd.id=sid) sstate,(SELECT spd.saddress FROM spd WHERE spd.id=sid) saddress FROM spdlogic  WHERE spdlogic.project_code='$pcode'");
        return $query->result();
    }
    
    
    public function get_fewaybill($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT * FROM dewaybill WHERE project_code='$pcode'");
        return $query->result();
    }
    
    
    
    public function get_fpur($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT purreq.sdate, plandt, targetdt, paymetdate, gpodate, purreq.unit,purreq.pono,purreq.material_name,purreq.material_qty,vander_detail.vander_name,purreq.matimg,purreq.matdimg FROM purreq LEFT JOIN vander_detail ON vander_detail.vander_id=purreq.vander_id WHERE batchno='$pcode'");
        return $query->result();
    }
    
    public function get_fboxap($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT dailywork.sdatet,dailywork.created_by,boxpreparing.sdatet bpdate,boxpreparing.boxpimg,dailywork.user_name,(SELECT unique_model.storeoutdt FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) storeoutdt,(SELECT unique_model.packdt FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) packdt,(SELECT unique_model.packlocation FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) packlocation FROM dailywork LEFT JOIN boxpreparing ON boxpreparing.wid=dailywork.id WHERE dailywork.batchno='$pcode' and model_name='MSC Set Box Packaging' and process_name='Box A Packaging' and wclose='3'");
        return $query->result();
    }
    
    public function get_fboxbp($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT dailywork.sdatet,dailywork.created_by,boxpreparing.sdatet bpdate,boxpreparing.boxpimg,dailywork.user_name,(SELECT unique_model.storeoutdt FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) storeoutdt,(SELECT unique_model.packdt FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) packdt,(SELECT unique_model.packlocation FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) packlocation FROM dailywork LEFT JOIN boxpreparing ON boxpreparing.wid=dailywork.id WHERE dailywork.batchno='$pcode' and model_name='MSC Set Box Packaging' and process_name='Box B Packaging' and wclose='3'");
        return $query->result();
    }
    
    public function get_fboxcp($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT dailywork.sdatet,dailywork.created_by,boxpreparing.sdatet bpdate,boxpreparing.boxpimg,dailywork.user_name,(SELECT unique_model.storeoutdt FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) storeoutdt,(SELECT unique_model.packdt FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) packdt,(SELECT unique_model.packlocation FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) packlocation FROM dailywork LEFT JOIN boxpreparing ON boxpreparing.wid=dailywork.id WHERE dailywork.batchno='$pcode' and model_name='MSC Set Box Packaging' and process_name='Box C Packaging' and wclose='3'");
        return $query->result();
    }
    
    public function get_fboxmsp($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT dailywork.sdatet,dailywork.created_by,boxpreparing.sdatet bpdate,boxpreparing.boxpimg,dailywork.user_name,(SELECT unique_model.storeoutdt FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) storeoutdt,(SELECT unique_model.packdt FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) packdt,(SELECT unique_model.packlocation FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) packlocation FROM dailywork LEFT JOIN boxpreparing ON boxpreparing.wid=dailywork.id WHERE dailywork.batchno='$pcode' and model_name='MSC Set Box Packaging' and process_name='Box MS Packaging' and wclose='3'");
        return $query->result();
    }
    
    
    
    public function get_fboxad($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT (SELECT unique_model.dispatchdt FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) dispatchdt,(SELECT unique_model.weighkg FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) weighkg,(SELECT unique_model.weighvideo FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) weighvideo FROM dailywork LEFT JOIN boxpreparing ON boxpreparing.wid=dailywork.id WHERE dailywork.batchno='$pcode' and model_name='MSC Set Box Packaging' and process_name='Box A Packaging' and wclose='3'");
        return $query->result();
    }
    
    public function get_fboxbd($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT dailywork.sdatet,dailywork.created_by,boxpreparing.sdatet bpdate,boxpreparing.boxpimg,dailywork.user_name,(SELECT unique_model.storeoutdt FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) storeoutdt,(SELECT unique_model.packdt FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) packdt,(SELECT unique_model.packlocation FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) packlocation FROM dailywork LEFT JOIN boxpreparing ON boxpreparing.wid=dailywork.id WHERE dailywork.batchno='$pcode' and model_name='MSC Set Box Packaging' and process_name='Box B Packaging' and wclose='3'");
        return $query->result();
    }
    
    public function get_fboxcd($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT dailywork.sdatet,dailywork.created_by,boxpreparing.sdatet bpdate,boxpreparing.boxpimg,dailywork.user_name,(SELECT unique_model.storeoutdt FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) storeoutdt,(SELECT unique_model.packdt FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) packdt,(SELECT unique_model.packlocation FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) packlocation FROM dailywork LEFT JOIN boxpreparing ON boxpreparing.wid=dailywork.id WHERE dailywork.batchno='$pcode' and model_name='MSC Set Box Packaging' and process_name='Box C Packaging' and wclose='3'");
        return $query->result();
    }
    
    public function get_fboxmsd($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT dailywork.sdatet,dailywork.created_by,boxpreparing.sdatet bpdate,boxpreparing.boxpimg,dailywork.user_name,(SELECT unique_model.storeoutdt FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) storeoutdt,(SELECT unique_model.packdt FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) packdt,(SELECT unique_model.packlocation FROM unique_model WHERE unique_model.workid=dailywork.id LIMIT 1) packlocation FROM dailywork LEFT JOIN boxpreparing ON boxpreparing.wid=dailywork.id WHERE dailywork.batchno='$pcode' and model_name='MSC Set Box Packaging' and process_name='Box MS Packaging' and wclose='3'");
        return $query->result();
    }
    
    
    
    public function get_designstart($pid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM `handoverlog` WHERE cid='$pid' and remark='Backdrop Approved by BD'");
        return $query->result();
    }
    
    public function get_BDRBoxNC2($uid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT request_type, COUNT(*) cont,rysn FROM bdrequest where bd_id='$uid' and onnew='2' and status='1' GROUP BY request_type,rysn ORDER BY `bdrequest`.`request_type` ASC;");
        return $query->result();
    }
    
    
    public function get_BDRBoxONB1($uid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT request_type, COUNT(*) cont,rysn FROM bdrequest where bd_id='$uid' and onnew='1' and status='0' GROUP BY request_type,rysn ORDER BY `bdrequest`.`request_type` ASC;");
        return $query->result();
    }
    
    
    public function get_BDRBoxNC1($uid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT request_type, COUNT(*) cont,rysn FROM bdrequest where bd_id='$uid' and onnew='2' and status='0' GROUP BY request_type,rysn ORDER BY `bdrequest`.`request_type` ASC;");
        return $query->result();
    }
    
    public function get_BDRPbyrysn($rysn,$uid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("select *,(SELECT GROUP_CONCAT(user_detail.fullname) from bdtask LEFT JOIN user_detail ON user_detail.id=bdtask.uid WHERE bdtask.tid=bdrequest.id) pia from bdrequest where rysn='$rysn' and  bd_id='$uid' ORDER BY bdrequest.sdatet DESC");
        return $query->result();
    }
    
    public function get_ridbytype(){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT type,COUNT(*) cont FROM replacereq GROUP BY type");
        return $query->result();  
    }
    
    public function get_ridbymodel(){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT model_name,COUNT(*) cont FROM replacereq GROUP BY model_name");
        return $query->result();  
    }
    
    public function get_faq(){
        $query=$this->db->query("SELECT * FROM faq");
        return $query->result();  
    }
    
    public function get_mtupbycntid($cid,$tid){
        $query=$this->db->query("SELECT * FROM mtaskupdate where hcid='$cid' and tid='$tid'");
        return $query->result();  
    }
    
    public function get_mtupbyrbdid($rid,$tid){
        $query=$this->db->query("SELECT * FROM mtaskupdate where rbdid='$rid' and tid='$tid'");
        return $query->result();  
    }
    
    public function get_mstubycntsid($cid,$tid,$stid){
        $db3 = $this->load->database('db3', TRUE);
        $db2 = $this->load->database('db2', TRUE);
        
        if($tid!='2'){
            $query=$db3->query("SELECT * FROM client_handover WHERE id='$cid'");
            $data = $query->result();
            $pcode = $data[0]->projectcode;
        }
        
        
        if($stid==1){
            $query=$db3->query("select client_handover.sdatet tdate, client_handover.bd_id tby from client_handover where id='$cid'");
            return $query->result();
        }
        
        if($stid==2){
            $query=$db3->query("select handover_account.sdatet tdate, client_handover.bd_id tby from client_handover LEFT join handover_account on handover_account.handover_id=client_handover.id LEFT join fm_timeline on fm_timeline.handover_id=client_handover.id where client_handover.id='$cid'");
            return $query->result();
        }
        
        if($stid==3){
            $query=$db3->query("select client_handover.haprdt tdate, client_handover.haby tby from client_handover LEFT join handover_account on handover_account.handover_id=client_handover.id LEFT join fm_timeline on fm_timeline.handover_id=client_handover.id where client_handover.id='$cid'");
            return $query->result();
        }
        if($stid==4){
            $query=$db3->query("select handoverlog.sdatet tdate, handoverlog.taskby tby from handoverlog where stid='4' and cid='$cid'");
            return $query->result();
        }
        if($stid==5){
            $query=$db3->query("select handoverlog.sdatet tdate, handoverlog.taskby tby from handoverlog where stid='5' and cid='$cid'");
            return $query->result();
        }
        if($stid==6){
            $query=$db3->query("select joincall.startt tdate, joincall.createdby tby from joincall LEFT JOIN client_handover ON client_handover.projectcode=joincall.projectcode WHERE client_handover.id='$cid'");
            return $query->result();
        }
        if($stid==7){
            $query=$db3->query("select handoverlog.sdatet tdate, handoverlog.taskby tby from handoverlog where stid='7' and cid='$cid'");
            return $query->result();
        } 
        
        if($stid==8){
            $query=$db3->query("SELECT sdatet tdate,bd_name tby FROM bdrequest WHERE id='$cid'");
            return $query->result();
        }
        
        if($stid==9){
            $query=$db3->query("SELECT sdatet tdate,tby FROM bdrequestlog WHERE tid='$cid' and status='3'");
            return $query->result();
        }
        
        if($stid==10){
            $query=$db3->query("SELECT sdatet tdate, tby FROM bdrequestlog WHERE tid='$cid' and status='4'");
            return $query->result();
        }
        
        if($stid==11){
            $query=$db3->query("SELECT GROUP_CONCAT(DISTINCT user_detail.fullname) tby,max(plantask.donet) tdate FROM task_assign LEFT JOIN plantask on plantask.taskid=task_assign.id LEFT JOIN user_detail on user_detail.id=plantask.user_id LEFT JOIN spd ON spd.id=task_assign.spd_id WHERE task_subtype='School Identification' and task_type='Call' and spd.spdident='$cid' and plantask.tdone='1'");
            return $query->result();
        }
        
        if($stid==12){
            $query=$db3->query("SELECT GROUP_CONCAT(DISTINCT user_detail.fullname) tby,max(plantask.donet) tdate FROM task_assign LEFT JOIN plantask on plantask.taskid=task_assign.id LEFT JOIN user_detail on user_detail.id=plantask.user_id LEFT JOIN spd ON spd.id=task_assign.spd_id WHERE task_subtype='School Identification' and task_type='Visit' and spd.spdident='$cid' and plantask.tdone='1'");
            return $query->result();
        }
        
        if($stid==13){
            $query=$db3->query("SELECT GROUP_CONCAT(DISTINCT user_detail.fullname) tby,max(plantask.donet) tdate FROM task_assign LEFT JOIN plantask on plantask.taskid=task_assign.id LEFT JOIN user_detail on user_detail.id=plantask.user_id LEFT JOIN spd ON spd.id=task_assign.spd_id WHERE checklist='page57' and spd.spdident='$cid' and plantask.tdone='1'");
            return $query->result();
        }
        
        if($stid==14){
            $query=$db3->query("SELECT GROUP_CONCAT(DISTINCT user_detail.fullname) tby,max(plantask.donet) tdate FROM task_assign LEFT JOIN plantask on plantask.taskid=task_assign.id LEFT JOIN user_detail on user_detail.id=plantask.user_id LEFT JOIN spd ON spd.id=task_assign.spd_id WHERE checklist='page57' and spd.spdident='$cid' and plantask.tdone='1'");
            return $query->result();
        }
        
        if($stid==15){
            $query=$db3->query("SELECT GROUP_CONCAT(DISTINCT user_detail.fullname) tby,max(plantask.donet) tdate FROM task_assign LEFT JOIN plantask on plantask.taskid=task_assign.id LEFT JOIN user_detail on user_detail.id=plantask.user_id LEFT JOIN spd ON spd.id=task_assign.spd_id WHERE task_subtype='School Identification' and task_type='Call' and spd.spdident='$cid' and plantask.tdone='1'");
            return $query->result();
        }
        
        
        if($stid==16){
            $query=$db3->query("select handoverlog.sdatet tdate, handoverlog.taskby tby from handoverlog where stid='17' and cid='$cid'");
            return $query->result();
        } 
        
        
        if($stid==17){
            $query=$db3->query("select handoverlog.sdatet tdate, handoverlog.taskby tby from handoverlog where stid='17' and cid='$cid'");
            return $query->result();
        } 
         
         
         if($stid==18){
            $query=$db3->query("select handoverlog.sdatet tdate, handoverlog.taskby tby from handoverlog where stid='18' and cid='$cid'");
            return $query->result();
        } 
         
         if($stid==19){
            $query=$db3->query("select handoverlog.sdatet tdate, handoverlog.taskby tby from handoverlog where stid='19' and cid='$cid'");
            return $query->result();
        } 
         
        
        if($stid==21){
            $query=$db3->query("select handoverlog.sdatet tdate, handoverlog.taskby tby from handoverlog where stid='21' and cid='$cid'");
            return $query->result();
        }
        
        
        if($stid==22){
            $query=$db2->query("SELECT MAX(workclose.closet) tdate, GROUP_CONCAT(DISTINCT dailywork.user_name) tby FROM dailywork LEFT JOIN workclose ON workclose.wid=dailywork.id WHERE batchno='$pcode' and wclose='3' and model_name='Backdrop Printing'");
            return $query->result();
        } 
        if($stid==23){
            $query=$db2->query("SELECT MAX(workclose.closet) tdate, GROUP_CONCAT(DISTINCT dailywork.user_name) tby FROM dailywork LEFT JOIN workclose ON workclose.wid=dailywork.id WHERE batchno='$pcode' and wclose='3' and model_name='User Manual Printing'");
            return $query->result();
        }
        
        if($stid==24){
            $query=$db2->query("SELECT MAX(workclose.closet) tdate, GROUP_CONCAT(DISTINCT dailywork.user_name) tby FROM dailywork LEFT JOIN workclose ON workclose.wid=dailywork.id WHERE batchno='$pcode' and wclose='3' and model_name='Training Manual Printing'");
            return $query->result();
        }
        
        if($stid==25){
            $query=$db2->query("SELECT MAX(sdate) tdate, 'Ajinkya' AS tby FROM purreq WHERE batchno='$pcode'");
            return $query->result();
        }
        
        if($stid==26){
            $query=$db2->query("SELECT assign_dt AS tdate, 'FM, Wahid' AS tby FROM sub_task WHERE project_code='$pcode' and tasktype='Packing';");
            return $query->result();
        }
        
        
        if($stid==27){
            $query=$db2->query("SELECT MAX(unique_model.packdt) tdate,GROUP_CONCAT(DISTINCT dailywork.user_name) AS tby FROM dailywork LEFT JOIN unique_model ON unique_model.workid=dailywork.id WHERE dailywork.batchno='$pcode' and model_name='MSC Set Box Packaging' and process_name='Box A Packaging' and wclose='3'");
            return $query->result();
        }
        if($stid==28){
            $query=$db2->query("SELECT MAX(unique_model.packdt) tdate,GROUP_CONCAT(DISTINCT dailywork.user_name) AS tby FROM dailywork LEFT JOIN unique_model ON unique_model.workid=dailywork.id WHERE dailywork.batchno='$pcode' and model_name='MSC Set Box Packaging' and process_name='Box B Packaging' and wclose='3'");
            return $query->result();
        }
        if($stid==29){
            $query=$db2->query("SELECT MAX(unique_model.packdt) tdate,GROUP_CONCAT(DISTINCT dailywork.user_name) AS tby FROM dailywork LEFT JOIN unique_model ON unique_model.workid=dailywork.id  WHERE dailywork.batchno='$pcode' and model_name='MSC Set Box Packaging' and process_name='Box C Packaging' and wclose='3'");
            return $query->result();
        }
        if($stid==30){
            $query=$db2->query("SELECT MAX(unique_model.packdt) tdate,GROUP_CONCAT(DISTINCT dailywork.user_name) AS tby FROM dailywork LEFT JOIN unique_model ON unique_model.workid=dailywork.id  WHERE dailywork.batchno='$pcode' and model_name='MSC Set Box Packaging' and process_name='Box MS Packaging' and wclose='3'");
            return $query->result();
        }
        
        
        if($stid==33){
            $query=$db2->query("SELECT assign_dt AS tdate, 'FM, Wahid' AS tby FROM sub_task WHERE project_code='$pcode' and tasktype='Dispatch';");
            return $query->result();
        }
        
        
        if($stid==34){
            $query=$db2->query("SELECT MAX(unique_model.dispatchdt) tdate,'QPD Admin, Sayali' AS tby FROM dailywork LEFT JOIN unique_model ON unique_model.workid=dailywork.id  WHERE dailywork.batchno='$pcode' and model_name='MSC Set Box Packaging' and process_name='Box A Packaging' and wclose='3'");
            return $query->result();
        }
        if($stid==35){
            $query=$db2->query("SELECT MAX(unique_model.dispatchdt) tdate,'QPD Admin, Sayali' AS tby FROM dailywork LEFT JOIN unique_model ON unique_model.workid=dailywork.id  WHERE dailywork.batchno='$pcode' and model_name='MSC Set Box Packaging' and process_name='Box B Packaging' and wclose='3'");
            return $query->result();
        }
        if($stid==36){
            $query=$db2->query("SELECT MAX(unique_model.dispatchdt) tdate,'QPD Admin, Sayali' AS tby FROM dailywork LEFT JOIN unique_model ON unique_model.workid=dailywork.id  WHERE dailywork.batchno='$pcode' and model_name='MSC Set Box Packaging' and process_name='Box C Packaging' and wclose='3'");
            return $query->result();
        }
        if($stid==37){
            $query=$db2->query("SELECT MAX(unique_model.dispatchdt) tdate,'QPD Admin, Sayali' AS tby FROM dailywork LEFT JOIN unique_model ON unique_model.workid=dailywork.id  WHERE dailywork.batchno='$pcode' and model_name='MSC Set Box Packaging' and process_name='Box MS Packaging' and wclose='3'");
            return $query->result();
        }
        
        if($stid==38){
            $query=$db3->query("SELECT MAX(sdatet) tdate,'Ajinkya' AS tby FROM spdlogic WHERE project_code='$pcode'");
            return $query->result();
        }
        if($stid==39){
            $query=$db2->query("SELECT MAX(sdatet) tdate,'Omkar' AS tby  FROM dewaybill WHERE project_code='$pcode'");
            return $query->result();
        }
        if($stid==40){
            $query=$db2->query("SELECT MAX(unique_model.deliverydt) tdate,'QPD Admin, Sayali' AS tby FROM dailywork LEFT JOIN unique_model ON unique_model.workid=dailywork.id  WHERE dailywork.batchno='$pcode' and model_name='MSC Set Box Packaging' and process_name='Box MS Packaging' and wclose='3'");
            return $query->result();
        }
        if($stid==41){
            $query=$db2->query("SELECT MAX(unique_model.deliverydt) tdate,'NO DATA' AS tby FROM dailywork LEFT JOIN unique_model ON unique_model.workid=dailywork.id  WHERE dailywork.batchno='$pcode' and model_name='MSC Set Box Packaging' and process_name='Box MS Packaging' and wclose='3'");
            return $query->result();
        }
        if($stid==42){
            $query=$db3->query("SELECT MAX(plandate) tdate,GROUP_CONCAT(user_detail.fullname) AS tby FROM plantask LEFT JOIN user_detail ON user_detail.id=plantask.user_id LEFT JOIN task_assign ON task_assign.id=plantask.taskid WHERE task_assign.project_code='$pcode' and task_assign.checklist='page59'");
            return $query->result();
        }
        
        
        
        
        
         
    }
    
    public function get_htprodetail($cid,$code,$tid,$sid){
        
        $db3 = $this->load->database('db3', TRUE);
        $db2 = $this->load->database('db2', TRUE);
        $query=$db3->query("SELECT * FROM client_handover WHERE id='$cid'");
        $data = $query->result();
        $pcode = $data[0]->projectcode;
        
        if($code==43){
            $query=$db3->query("SELECT * FROM visitstupdate WHERE tid='$tid'");
            return $query->result();
        }
        
        if($code==42){
            $query=$db3->query("SELECT * FROM visitstupdate WHERE tid='$tid'");
            return $query->result();
        }
        
        
    }
    
    
    public function get_htprocess($cid,$code){
        
        $db3 = $this->load->database('db3', TRUE);
        $db2 = $this->load->database('db2', TRUE);
        
        $query=$db3->query("SELECT * FROM client_handover WHERE id='$cid'");
        $data = $query->result();
        $pcode = $data[0]->projectcode;
        
        if($code==6){
            $query=$db3->query("select * from joincall where projectcode='$pcode'");
            return $query->result();
        }
        
        if($code==17){
            $query=$db3->query("select * from joincall where projectcode='$pcode'");
            return $query->result();
        }
        
        if($code==22){
            $query=$db2->query("SELECT * FROM model_m WHERE model_name='Backdrop Printing' ORDER BY model_m.stage ASC");
            return $query->result();
        }
        
        
        if($code==31){
            $query=$db3->query("SELECT spd.*, spd.id AS sid, u1.fullname piname, u2.fullname insname, 
       (
           SELECT task_assign.sdatet
           FROM task_assign
           LEFT JOIN plantask ON plantask.taskid = task_assign.id
           WHERE task_assign.spd_id = sid
           AND task_assign.checklist = 'page1'
           AND plantask.tdone = '1'
           LIMIT 1
       ) AS tassdt,
       (
           SELECT plantask.plandate FROM task_assign LEFT JOIN plantask ON plantask.taskid = task_assign.id WHERE task_assign.spd_id = sid AND task_assign.checklist = 'page1'  AND plantask.tdone = '1'  LIMIT 1
       ) AS tplandt,
       (
           SELECT plantask.donet FROM task_assign LEFT JOIN plantask ON plantask.taskid = task_assign.id WHERE task_assign.spd_id = sid AND task_assign.checklist = 'page1' AND plantask.tdone = '1' LIMIT 1
       ) AS tdonedt, (
           SELECT plantask.remark FROM task_assign LEFT JOIN plantask ON plantask.taskid = task_assign.id WHERE task_assign.spd_id = sid AND task_assign.checklist = 'page1' AND plantask.tdone = '1' LIMIT 1
       ) AS tremark FROM spd LEFT join user_detail u1 ON u1.id=spd.pi_id LEFT join user_detail u2 ON u2.id=spd.ins_id
WHERE cid = '$cid'");
            return $query->result();
        }
        
        
        if($code==32){
            $query=$db3->query("SELECT spd.*, spd.id AS sid, u1.fullname piname, u2.fullname insname, 
       (
           SELECT task_assign.sdatet
           FROM task_assign
           LEFT JOIN plantask ON plantask.taskid = task_assign.id
           WHERE task_assign.spd_id = sid
           AND task_assign.checklist = 'page2'
           AND plantask.tdone = '1'
           LIMIT 1
       ) AS tassdt,
       (
           SELECT plantask.plandate FROM task_assign LEFT JOIN plantask ON plantask.taskid = task_assign.id WHERE task_assign.spd_id = sid AND task_assign.checklist = 'page2'  AND plantask.tdone = '1'  LIMIT 1
       ) AS tplandt,
       (
           SELECT plantask.donet FROM task_assign LEFT JOIN plantask ON plantask.taskid = task_assign.id WHERE task_assign.spd_id = sid AND task_assign.checklist = 'page2' AND plantask.tdone = '1' LIMIT 1
       ) AS tdonedt, (
           SELECT plantask.remark FROM task_assign LEFT JOIN plantask ON plantask.taskid = task_assign.id WHERE task_assign.spd_id = sid AND task_assign.checklist = 'page2' AND plantask.tdone = '1' LIMIT 1
       ) AS tremark FROM spd LEFT join user_detail u1 ON u1.id=spd.pi_id LEFT join user_detail u2 ON u2.id=spd.ins_id
WHERE cid = '$cid'");
            return $query->result();
        }
        
        
        
        if($code==42){
            $query=$db3->query("SELECT spd.*, spd.id AS sid, u1.fullname piname, u2.fullname insname, 
       (
           SELECT task_assign.id
           FROM task_assign
           LEFT JOIN plantask ON plantask.taskid = task_assign.id
           WHERE task_assign.spd_id = sid
           AND task_assign.checklist = 'page59'
           AND plantask.tdone = '1'
           LIMIT 1
       ) AS tid,
       (
           SELECT task_assign.sdatet
           FROM task_assign
           LEFT JOIN plantask ON plantask.taskid = task_assign.id
           WHERE task_assign.spd_id = sid
           AND task_assign.checklist = 'page59'
           AND plantask.tdone = '1'
           LIMIT 1
       ) AS tassdt,
       (
           SELECT plantask.plandate FROM task_assign LEFT JOIN plantask ON plantask.taskid = task_assign.id WHERE task_assign.spd_id = sid AND task_assign.checklist = 'page59'  AND plantask.tdone = '1'  LIMIT 1
       ) AS tplandt,
       (
           SELECT plantask.donet FROM task_assign LEFT JOIN plantask ON plantask.taskid = task_assign.id WHERE task_assign.spd_id = sid AND task_assign.checklist = 'page59' AND plantask.tdone = '1' LIMIT 1
       ) AS tdonedt, (
           SELECT plantask.remark FROM task_assign LEFT JOIN plantask ON plantask.taskid = task_assign.id WHERE task_assign.spd_id = sid AND task_assign.checklist = 'page59' AND plantask.tdone = '1' LIMIT 1
       ) AS tremark FROM spd LEFT join user_detail u1 ON u1.id=spd.pi_id LEFT join user_detail u2 ON u2.id=spd.ins_id
WHERE cid = '$cid'");
            return $query->result();
        }
        
        
        
        if($code==43){
            $query=$db3->query("SELECT spd.*, spd.id AS sid, u1.fullname piname, u2.fullname insname, 
       (
           SELECT task_assign.id
           FROM task_assign
           LEFT JOIN plantask ON plantask.taskid = task_assign.id
           WHERE task_assign.spd_id = sid
           AND task_assign.checklist = 'page6'
           AND plantask.tdone = '1'
           LIMIT 1
       ) AS tid,
       (
           SELECT task_assign.sdatet
           FROM task_assign
           LEFT JOIN plantask ON plantask.taskid = task_assign.id
           WHERE task_assign.spd_id = sid
           AND task_assign.checklist = 'page6'
           AND plantask.tdone = '1'
           LIMIT 1
       ) AS tassdt,
       (
           SELECT plantask.plandate FROM task_assign LEFT JOIN plantask ON plantask.taskid = task_assign.id WHERE task_assign.spd_id = sid AND task_assign.checklist = 'page6'  AND plantask.tdone = '1'  LIMIT 1
       ) AS tplandt,
       (
           SELECT plantask.donet FROM task_assign LEFT JOIN plantask ON plantask.taskid = task_assign.id WHERE task_assign.spd_id = sid AND task_assign.checklist = 'page6' AND plantask.tdone = '1' LIMIT 1
       ) AS tdonedt, (
           SELECT plantask.remark FROM task_assign LEFT JOIN plantask ON plantask.taskid = task_assign.id WHERE task_assign.spd_id = sid AND task_assign.checklist = 'page6' AND plantask.tdone = '1' LIMIT 1
       ) AS tremark FROM spd LEFT join user_detail u1 ON u1.id=spd.pi_id LEFT join user_detail u2 ON u2.id=spd.ins_id
WHERE cid = '$cid'");
            return $query->result();
        }
        
        
        
        if($code==44){
            $query=$db3->query("SELECT spd.*, spd.id AS sid, u1.fullname piname, u2.fullname insname, 
       (
           SELECT task_assign.id
           FROM task_assign
           LEFT JOIN plantask ON plantask.taskid = task_assign.id
           WHERE task_assign.spd_id = sid
           AND task_assign.task_type = 'Report'
           AND task_assign.task_subtype = 'Upload Installation Report'
           AND plantask.tdone = '1'
           LIMIT 1
       ) AS tid,
       (
           SELECT task_assign.sdatet
           FROM task_assign
           LEFT JOIN plantask ON plantask.taskid = task_assign.id
           WHERE task_assign.spd_id = sid
           AND task_assign.task_type = 'Report'
           AND task_assign.task_subtype = 'Upload Installation Report'
           AND plantask.tdone = '1'
           LIMIT 1
       ) AS tassdt,
       (
           SELECT plantask.plandate FROM task_assign LEFT JOIN plantask ON plantask.taskid = task_assign.id WHERE task_assign.spd_id = sid AND task_assign.task_type = 'Report'
           AND task_assign.task_subtype = 'Upload Installation Report' AND plantask.tdone = '1'  LIMIT 1
       ) AS tplandt,
       (
           SELECT plantask.donet FROM task_assign LEFT JOIN plantask ON plantask.taskid = task_assign.id WHERE task_assign.spd_id = sid AND task_assign.task_type = 'Report'
           AND task_assign.task_subtype = 'Upload Installation Report' AND plantask.tdone = '1' LIMIT 1
       ) AS tdonedt, (
           SELECT plantask.remark FROM task_assign LEFT JOIN plantask ON plantask.taskid = task_assign.id WHERE task_assign.spd_id = sid AND task_assign.task_type = 'Report'
           AND task_assign.task_subtype = 'Upload Installation Report' AND plantask.tdone = '1' LIMIT 1
       ) AS tremark, (
           SELECT report.filepath FROM task_assign LEFT JOIN plantask ON plantask.taskid = task_assign.id LEFT JOIN report ON report.tid = task_assign.id WHERE task_assign.spd_id = sid AND task_assign.task_type = 'Report'
           AND task_assign.task_subtype = 'Upload Installation Report' AND plantask.tdone = '1' LIMIT 1
       ) AS tfilepath
       
       FROM spd LEFT join user_detail u1 ON u1.id=spd.pi_id LEFT join user_detail u2 ON u2.id=spd.ins_id
WHERE cid = '$cid'");





            return $query->result();
        } 
    }
    
    
    
    public function get_ridbyp($uid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT projectcode pcode,COUNT(DISTINCT spd.id) school, COUNT(*) model,COUNT(CASE WHEN replacereq.type='Repair' THEN replacereq.type='Repair' END) as Repair, COUNT(CASE WHEN replacereq.type='replace' THEN replacereq.type='replace' END) as rreplace FROM replacereq inner join spd on spd.id = replacereq.sid inner join client_handover ON client_handover.projectcode=spd.project_code where client_handover.bd_id='$uid' GROUP BY client_handover.projectcode");
        return $query->result();  
    }
    
    
    
    public function get_spdforhandover($cname){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT MAX(id) bdrmid FROM bdrequest WHERE cname='$cname'");
        $data = $query->result();
        $spdident = $data[0]->bdrmid;
        $query=$db3->query("SELECT * FROM spd WHERE spdident='$spdident' and spdident is not null and spdident!=''");
        return $query->result();
    }
    
    public function bdr_close($rid,$ccomment,$uname){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("Update bdrequest set status='1',assignto='1' WHERE id='$rid'");
        $query=$db3->query("INSERT INTO bdrequestlog(tid, tby, remark) VALUES ('$rid','$uname','$ccomment')");
    }
    
    
    public function bdr_open($rid,$ccomment,$uname){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("Update bdrequest set status='0',assignto='1' WHERE id='$rid'");
        $query=$db3->query("INSERT INTO bdrequestlog(tid, tby, remark) VALUES ('$rid','$uname','$ccomment')");
    }
    
    
    
    
    public function get_ridbypcode($uid,$pcode){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT rdate, MONTHNAME(STR_TO_DATE(rdate, '%Y-%m-%d')) AS month_name, project_code, project_year, chid, sid, sname, noofmodel, tid FROM ( SELECT CAST(replacereq.sdatet AS DATE) AS rdate, spd.project_code, client_handover.project_year, client_handover.id AS chid, spd.id AS sid, spd.sname, COUNT(*) AS noofmodel, replacereq.tid AS tid FROM replacereq INNER JOIN spd ON spd.id = replacereq.sid INNER JOIN client_handover ON client_handover.projectcode = spd.project_code WHERE client_handover.projectcode='$pcode' and client_handover.bd_id = '$uid' GROUP BY spd.project_code, spd.sname, spd.id, replacereq.tid, client_handover.project_year, client_handover.id, CAST(replacereq.sdatet AS DATE) ) AS subquery ORDER BY rdate DESC");
        return $query->result();  
    }
    
    public function get_ridpending($uid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT CAST(replacereq.sdatet AS DATE) AS rdate, spd.project_code, client_handover.project_year, client_handover.id AS chid, spd.id AS sid, spd.sname, COUNT(*) AS noofmodel, status.name AS stname, replacereq.tid, SUM(CASE WHEN replacereq.type='replace' THEN 1 ELSE 0 END) AS `replace`, SUM(CASE WHEN replacereq.type='Repair' THEN 1 ELSE 0 END) AS `Repair` FROM replacereq INNER JOIN spd ON spd.id = replacereq.sid LEFT JOIN status ON status.id = spd.status INNER JOIN client_handover ON client_handover.projectcode = spd.project_code WHERE client_handover.bd_id = '$uid' and replacereq.status='Open' GROUP BY CAST(replacereq.sdatet AS DATE), spd.project_code, client_handover.project_year, client_handover.id, spd.id, spd.sname, status.name, replacereq.tid ORDER BY rdate DESC");
        return $query->result();  
    }
    
    
    
    public function get_rid($uid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT rdate, MONTHNAME(STR_TO_DATE(rdate, '%Y-%m-%d')) AS month_name, project_code, project_year, chid, sid, sname, noofmodel, stname, tid FROM ( SELECT CAST(replacereq.sdatet AS DATE) AS rdate, spd.project_code, client_handover.project_year, client_handover.id AS chid, spd.id AS sid, spd.sname, COUNT(*) AS noofmodel, status.name AS stname, replacereq.tid AS tid FROM replacereq INNER JOIN spd ON spd.id = replacereq.sid LEFT JOIN status ON status.id = spd.status INNER JOIN client_handover ON client_handover.projectcode = spd.project_code WHERE client_handover.bd_id = '$uid' GROUP BY CAST(replacereq.sdatet AS DATE), spd.project_code, client_handover.project_year, client_handover.id,spd.id,spd.sname,status.name,replacereq.tid) AS subquery ORDER BY rdate DESC");
        return $query->result();  
    }
    
    
    public function get_sidrid($sid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM replacereq inner join spd on spd.id = replacereq.sid inner join client_handover ON client_handover.projectcode=spd.project_code where spd.id='$sid'");
        return $query->result();
    }
    
    public function get_tidrid($tid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT *,u1.fullname assignby FROM plantask LEFT JOIN task_assign ON task_assign.id=plantask.taskid LEFT JOIN taskdetail ON taskdetail.page=task_assign.checklist LEFT JOIN user_detail u1 ON u1.id=task_assign.from_user   LEFT JOIN user_detail ON user_detail.id=plantask.user_id WHERE plantask.taskid='$tid'");
        return $query->result();
    }
    
     public function plantask($taskid,$date){
        $query=$this->db->query("UPDATE tblcallevents SET appointmentdatetime='$date',plan=1 WHERE id='$taskid'");
    }
    
    public function get_midelrid($projectcode,$model_name){
        $db3 = $this->load->database('db2', TRUE);
        $query=$db3->query("SELECT unique_model.packdt,dailywork.user_name,unique_model.fgpackimg,dispatchdt,deliverydt FROM unique_model LEFT JOIN dailywork ON dailywork.id=unique_model.workid WHERE unique_model.id=(SELECT MAX(id) FROM unique_model WHERE workid=(SELECT MAX(id) FROM dailywork WHERE batchno='$projectcode') and packdt is not null and fg_name='$model_name')");
        return $query->result();
    }
    
    
     public function get_adminpopup($ur_id){
        $udetail = $this->Menu_model->get_userbyid($ur_id);
        $admid = $udetail[0]->admin_id;
        $ur_id=$admid;
        $tdatet= date('Y-m-d H:i:s');
        $tdate= date('Y-m-d');
        $ndate = date('Y-m-d', strtotime($tdate . ' +1 day'));
        $bdate = date('Y-m-d', strtotime($tdate . ' -1 day'));
        $data = "";
        
        $data = $data."<center><h5 class='text-white'>Day Managment<h5></center><hr>";
        $query=$this->db->query("SELECT (SELECT count(*) FROM user_details where admin_id='$ur_id' and status='active' and type_id=3)- COUNT(*) b FROM user_day LEFT JOIN user_details ON user_details.user_id=user_day.user_id WHERE cast(ustart as DATE)='$tdate' and user_details.admin_id='$ur_id'");
        $da = $query->result();
        if($da[0]->b>0){
        $data = $data."<a href='".base_url()."Menu/AlertReply/1'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da[0]->b." BD Not Started Their  Day</b></div><a/>";}
        
        $query=$this->db->query("SELECT COUNT(*) b FROM user_day LEFT JOIN user_details ON user_details.user_id=user_day.user_id WHERE cast(ustart as DATE)='$tdate' and scomment is null and cast(CURRENT_TIMESTAMP AS TIME)>'11:00:00' and user_details.admin_id='$ur_id'");
        $da = $query->result();
        if($da[0]->b>0){
        $data = $data."<a href='".base_url()."Menu/AlertReply/2'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da[0]->b." BDs Day Start Review Not Done</b></div><a/>";}
        
        $query=$this->db->query("SELECT COUNT(*) b FROM user_day LEFT JOIN user_details ON user_details.user_id=user_day.user_id WHERE cast(ustart as DATE)='$tdate' and uclose is null and cast(CURRENT_TIMESTAMP AS TIME)>'19:00:00' and user_details.admin_id='$ur_id'");
        $da = $query->result();
        if($da[0]->b>0){
        $data = $data."<a href='".base_url()."Menu/AlertReply/3'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da[0]->b." BD Not Closed Their  Day</b></div><a/>";}
        
        $query=$this->db->query("SELECT COUNT(*) b FROM user_day LEFT JOIN user_details ON user_details.user_id=user_day.user_id WHERE cast(uclose as DATE)='$bdate' and ccomment is null and cast(CURRENT_TIMESTAMP AS TIME)>'11:00:00' and user_details.admin_id='$ur_id'");
        $da = $query->result();
        if($da[0]->b>0){
        $data = $data."<a href='".base_url()."Menu/AlertReply/4'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da[0]->b." BDs Day Close Review a day befoue Not Done</b></div><a/>";}
        
        $data = $data."<hr>";
        $data = $data."<center><h5 class='text-white'>Task Managment<h5></center><hr>";
    
    
        $query=$this->db->query("SELECT count(*) b FROM tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and plan='1' and nextCFID='0'");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='".base_url()."Menu/AlertReply/5'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Task Pending for Completion</b></div><a/>";}
        
        $query=$this->db->query("SELECT count(CASE WHEN nextCFID=0 and actiontype_id=6 THEN nextCFID end) b FROM tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and plan=1");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='".base_url()."Menu/AlertReply/6'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Task MOM Pending for Completion</b></div><a/>";}
    
    
        $query=$this->db->query("SELECT count(*) b from tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '09:00:00' and '11:00:00' and cast(CURRENT_TIMESTAMP AS TIME)>'11:00:00'");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='".base_url()."Menu/AlertReply/7'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Task Pending for Completion (09am to 11am)</b></div><a/>";}
        
        $query=$this->db->query("SELECT count(*) b from tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '11:00:01' and '13:00:00' and cast(CURRENT_TIMESTAMP AS TIME)>'13:00:00'");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='".base_url()."Menu/AlertReply/8'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Task Pending for Completion (11am to 01pm)</b></div><a/>";}
        
        $query=$this->db->query("SELECT count(*) b from tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '13:00:01' and '15:00:00' and cast(CURRENT_TIMESTAMP AS TIME)>'15:00:00'");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='".base_url()."Menu/AlertReply/9'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Task Pending for Completion (01pm to 03pm)</b></div><a/>";}
        
        $query=$this->db->query("SELECT count(*) b from tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '15:00:01' and '17:00:00' and cast(CURRENT_TIMESTAMP AS TIME)>'17:00:00'");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='".base_url()."Menu/AlertReply/10'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Task Pending for Completion (03pm to 05pm)</b></div><a/>";}
        
        $query=$this->db->query("SELECT count(*) b from tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '17:00:01' and '19:00:00' and cast(CURRENT_TIMESTAMP AS TIME)>'19:00:00'");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='".base_url()."Menu/AlertReply/11'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Task Pending for Completion (05pm to 07pm)</b></div><a/>";}
        
        $query=$this->db->query("SELECT count(*) b from tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '19:00:01' and '21:00:00' and cast(CURRENT_TIMESTAMP AS TIME)>'21:00:00'");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='".base_url()."Menu/AlertReply/12'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Task Pending for Completion (07pm to 09pm)</b></div><a/>";}
    
        $data = $data."<hr>";
        $data = $data."<center><h5 class='text-white'>Approval<h5></center><hr>";
    
        $query=$this->db->query("SELECT count(*) b FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id left JOIN company_master ON company_master.id=init_call.cmpid_id WHERE tblcallevents.mom!='' and user_details.admin_id='$ur_id' and init_call.apst is null and init_call.mainbd is not null");
        $da = $query->result();
        if($da[0]->b>0){
        $data = $data."<a href='assignpst'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da[0]->b." Company Pending for PST Assign</b></div><a/>";}
        
        $mdata = $this->Menu_model->proposal_apr($ur_id);
        $k=sizeof($mdata);
        if($k > 0){
        $data = $data."<a href='ProposalApr'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$k." Proposal Pending for Approval</b></div><a/>";}
        
        $mdata = $this->Menu_model->delete_r($ur_id);
        $k=sizeof($mdata);
        if($k > 0){
        $data = $data."<a href='DeleteCMP'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$k." Request Pending for Delete Company</b></div><a/>";}
        
        $data = $data."<hr>";
        $data = $data."<center><h5 class='text-white'>Long Time<h5></center><hr>";
    
        $query=$this->db->query("SELECT COUNT(CASE WHEN init_call.cstatus='6' THEN init_call.cstatus END) + COUNT(CASE WHEN init_call.cstatus='7' THEN init_call.cstatus END) + COUNT(CASE WHEN init_call.cstatus='9' THEN init_call.cstatus END) + COUNT(CASE WHEN init_call.cstatus='12' THEN init_call.cstatus END) + COUNT(CASE WHEN init_call.cstatus='13' THEN init_call.cstatus END) b FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd LEFT JOIN allreviewdata ON allreviewdata.inid=init_call.id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE user_details.admin_id='$ur_id' and apst is not null and allreviewdata.inid is null");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='".base_url()."Menu/AlertReply/13'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Company Not Taken any Review by Admin</b></div><a/>";}
        
        $query=$this->db->query("SELECT COUNT(init_call.id) b FROM init_call LEFT JOIN user_details u1 ON u1.user_id=init_call.mainbd WHERE apst is not null and u1.admin_id='$ur_id' AND init_call.id NOT IN (SELECT cid_id FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE cid_id IN (SELECT DISTINCT init_call.id FROM init_call LEFT JOIN user_details u1 ON u1.user_id=init_call.mainbd WHERE apst is not null and u1.admin_id='$ur_id') and tblcallevents.nextCFID!='0' and user_details.type_id='4' and tblcallevents.actiontype_id='1' and actontaken='yes' and purpose_achieved='yes' GROUP BY cid_id)");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='".base_url()."Menu/AlertReply/14'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Company PST Assign but Not Work on This</b></div><a/>";}
        
        $query=$this->db->query("SELECT COUNT(*) b FROM allreviewdata LEFT JOIN tblcallevents ON tblcallevents.id=allreviewdata.ntid WHERE pst='$ur_id' and tblcallevents.nextCFID='0'");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='".base_url()."Menu/AlertReply/15".$tdate."'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Review Task Pending</b></div><a/>";}
        
        
        $query=$this->db->query("SELECT count(*) b FROM allreviewdata LEFT JOIN init_call ON init_call.id=allreviewdata.inid WHERE allreviewdata.exsid!=init_call.cstatus and pst='$ur_id'");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='".base_url()."Menu/AlertReply/16'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Companies Expected Status not Matched</b></div><a/>";}
        
        
        $query=$this->db->query("SELECT user_details.name, goalsetting.tcall, (SELECT COUNT(*) from tblcallevents LEFT JOIN user_details u1 ON u1.user_id=tblcallevents.user_id WHERE tblcallevents.updateddate>goalsetting.sdatet AND tblcallevents.actontaken='yes' and tblcallevents.purpose_achieved='yes' and tblcallevents.actiontype_id='1' and tblcallevents.user_id=goalsetting.bdid and u1.admin_id='$ur_id') abc FROM goalsetting JOIN user_details ON user_details.user_id=goalsetting.bdid and user_details.admin_id='$ur_id'");
        $da1 = $query->result();
        foreach($da1 as $dat){if($dat->abc<$dat->tcall){
        $data = $data."<a href='".base_url()."Menu/AlertReply/17'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total Goal for Call is ".$dat->tcall." but only ".$dat->abc." Call Completed by ".$dat->name."</b></div><a/>";}}
        
        $query=$this->db->query("SELECT user_details.name, goalsetting.email, (SELECT COUNT(*) from tblcallevents LEFT JOIN user_details u1 ON u1.user_id=tblcallevents.user_id WHERE tblcallevents.updateddate>goalsetting.sdatet AND tblcallevents.actontaken='yes' and tblcallevents.purpose_achieved='yes' and tblcallevents.actiontype_id='2' and tblcallevents.user_id=goalsetting.bdid and u1.admin_id='$ur_id') abc FROM goalsetting JOIN user_details ON user_details.user_id=goalsetting.bdid and user_details.admin_id='$ur_id'");
        $da1 = $query->result();
        foreach($da1 as $dat){if($dat->abc<$dat->email){
        $data = $data."<a href='".base_url()."Menu/AlertReply/18'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total Goal for Email is ".$dat->email." but only ".$dat->abc." Email Completed by ".$dat->name."</b></div><a/>";}}
        
        
        $query=$this->db->query("SELECT user_details.name, goalsetting.meeting, (SELECT COUNT(*) from tblcallevents LEFT JOIN user_details u1 ON u1.user_id=tblcallevents.user_id WHERE tblcallevents.updateddate>goalsetting.sdatet AND tblcallevents.actontaken='yes' and tblcallevents.purpose_achieved='yes' and tblcallevents.actiontype_id='4' and tblcallevents.user_id=goalsetting.bdid and u1.admin_id='$ur_id') abc FROM goalsetting JOIN user_details ON user_details.user_id=goalsetting.bdid and user_details.admin_id='$ur_id'");
        $da1 = $query->result();
        foreach($da1 as $dat){if($dat->abc<$dat->meeting){
        $data = $data."<a href='".base_url()."Menu/AlertReply/19'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total Goal for Barg in Meeting is ".$dat->meeting." but only ".$dat->abc." Barg in Meeting Completed by ".$dat->name."</b></div><a/>";}}
        
        
        $query=$this->db->query("SELECT user_details.name, goalsetting.praposal, (SELECT COUNT(*) from tblcallevents LEFT JOIN user_details u1 ON u1.user_id=tblcallevents.user_id WHERE tblcallevents.updateddate>goalsetting.sdatet AND tblcallevents.actontaken='yes' and tblcallevents.purpose_achieved='yes' and tblcallevents.actiontype_id='7' and tblcallevents.user_id=goalsetting.bdid and u1.admin_id='$ur_id') abc FROM goalsetting JOIN user_details ON user_details.user_id=goalsetting.bdid and user_details.admin_id='$ur_id'");
        $da1 = $query->result();
        foreach($da1 as $dat){if($dat->abc<$dat->praposal){
        $data = $data."<a href='".base_url()."Menu/AlertReply/20'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total Goal for Write Proposal is ".$dat->praposal." but only ".$dat->abc." Write Proposal Completed by ".$dat->name."</b></div><a/>";}}
    
        $data = $data."<hr>";
        $data = $data."<center><h5 class='text-white'>Others<h5></center><hr>";    
           
        $data = $data."<hr>";
        $data = $data."<center><h5 class='text-white'>Opration Update!<h5></center><hr>";     
        
        return $data; 
     }
     
     
     public function fetchDataFromOtherServer($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $tempFilePath = tempnam(sys_get_temp_dir(), 'zipdata');
        file_put_contents($tempFilePath, $response);
        return $tempFilePath;
    }
     
     
     public function get_alertreply($ur_id,$code){
        $utype = $this->Menu_model->get_userbyid($ur_id);
        $utype = $utype[0]->type_id;
        if($utype==6){$ur_id = $utype[0]->admin_id;}
        $tdatet= date('Y-m-d H:i:s');
        $tdate= date('Y-m-d');
        $ndate = date('Y-m-d', strtotime($tdate . ' +1 day'));
        $bdate = date('Y-m-d', strtotime($tdate . ' -1 day'));
        $data = "";
         
         if($code==1){
             $query=$this->db->query("SELECT *,user_details.user_id uuid FROM user_details where admin_id='$ur_id' and status='active' and type_id=3 and user_id not IN (SELECT user_day.user_id FROM user_day LEFT JOIN user_details u1 ON u1.user_id=user_day.user_id WHERE cast(ustart as DATE)='$tdate' and u1.admin_id='$ur_id')");
             return $query->result();
         }
         
         if($code==2){
             $query=$this->db->query("SELECT *,user_details.user_id uuid FROM user_day LEFT JOIN user_details ON user_details.user_id=user_day.user_id WHERE cast(ustart as DATE)='$tdate' and scomment is null and cast(CURRENT_TIMESTAMP AS TIME)>'11:00:00' and user_details.admin_id='$ur_id'");
            return $query->result();
         }
         
         if($code==3){
             $query=$this->db->query("SELECT *,user_details.user_id uuid FROM user_day LEFT JOIN user_details ON user_details.user_id=user_day.user_id WHERE cast(ustart as DATE)='$bdate' and uclose is null and cast(CURRENT_TIMESTAMP AS TIME)>'19:00:00' and user_details.admin_id='$ur_id'");
            return $query->result();
         }
         
         if($code==4){
             $query=$this->db->query("SELECT *,user_details.user_id uuid FROM user_day LEFT JOIN user_details ON user_details.user_id=user_day.user_id WHERE cast(uclose as DATE)='$bdate' and ccomment is null and cast(CURRENT_TIMESTAMP AS TIME)>'11:00:00' and user_details.admin_id='$ur_id'");
             return $query->result();
         }
         
         if($code==5){
             $query=$this->db->query("SELECT *,tblcallevents.id tid,action.name aname,user_details.name uname  FROM tblcallevents LEFT JOIN action on action.id=tblcallevents.actiontype_id LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$ur_id' and nextCFID='0' and cast(appointmentdatetime AS DATE)='$tdate' and plan='1'");
             return $query->result();
         }
         
         
         if($code==6){
             $query=$this->db->query("SELECT *,tblcallevents.id tid,action.name aname,user_details.name uname  FROM tblcallevents LEFT JOIN action on action.id=tblcallevents.actiontype_id LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$ur_id' and nextCFID='0' and cast(appointmentdatetime AS DATE)='$tdate' and plan='1' and actiontype_id=6");
             return $query->result();
         }
         
         
         if($code==7){
             $query=$this->db->query("SELECT *,tblcallevents.id tid,action.name aname,user_details.name uname  FROM tblcallevents LEFT JOIN action on action.id=tblcallevents.actiontype_id LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '09:00:00' and '11:00:00' and cast(CURRENT_TIMESTAMP AS TIME)>'11:00:00'");
             return $query->result();
         }
         
         
         if($code==8){
             $query=$this->db->query("SELECT *,tblcallevents.id tid,action.name aname,user_details.name uname  FROM tblcallevents LEFT JOIN action on action.id=tblcallevents.actiontype_id LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '11:00:01' and '13:00:00' and cast(CURRENT_TIMESTAMP AS TIME)>'13:00:00'");
             return $query->result();
         }
         
         
         if($code==9){
             $query=$this->db->query("SELECT *,tblcallevents.id tid,action.name aname,user_details.name uname  FROM tblcallevents LEFT JOIN action on action.id=tblcallevents.actiontype_id LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '13:00:01' and '15:00:00' and cast(CURRENT_TIMESTAMP AS TIME)>'15:00:00'");
             return $query->result();
         }
         
         
         if($code==10){
             $query=$this->db->query("SELECT *,tblcallevents.id tid,action.name aname,user_details.name uname  FROM tblcallevents LEFT JOIN action on action.id=tblcallevents.actiontype_id LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '15:00:01' and '17:00:00' and cast(CURRENT_TIMESTAMP AS TIME)>'17:00:00'");
             return $query->result();
         }
         
         if($code==11){
             $query=$this->db->query("SELECT *,tblcallevents.id tid,action.name aname,user_details.name uname  FROM tblcallevents LEFT JOIN action on action.id=tblcallevents.actiontype_id LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '17:00:01' and '19:00:00' and cast(CURRENT_TIMESTAMP AS TIME)>'19:00:00'");
             return $query->result();
         }
         
         
         if($code==12){
             $query=$this->db->query("SELECT *,tblcallevents.id tid,action.name aname,user_details.name uname  FROM tblcallevents LEFT JOIN action on action.id=tblcallevents.actiontype_id LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '19:00:01' and '21:00:00' and cast(CURRENT_TIMESTAMP AS TIME)>'21:00:00'");
             return $query->result();
         }
         
         if($code==13){
             $query=$this->db->query("SELECT *,company_master.id cid,u1.name bdname, u2.name pstname FROM init_call LEFT JOIN user_details u1 ON u1.user_id=init_call.mainbd LEFT JOIN user_details u2 ON u2.user_id=init_call.apst LEFT JOIN user_details on user_details.user_id=init_call.mainbd LEFT JOIN allreviewdata ON allreviewdata.inid=init_call.id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE user_details.admin_id='$ur_id' and apst is not null and allreviewdata.inid is null");
             return $query->result();
         }
         
         
         if($code==14){
             $query=$this->db->query("SELECT *,company_master.id cid,u1.name bdname, u2.name pstname  FROM init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN user_details u1 ON u1.user_id=init_call.mainbd LEFT JOIN user_details u2 ON u2.user_id=init_call.apst WHERE apst is not null and u1.admin_id='$uid' AND init_call.id NOT IN (SELECT cid_id FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE cid_id IN (SELECT DISTINCT init_call.id FROM init_call LEFT JOIN user_details u1 ON u1.user_id=init_call.mainbd WHERE apst is not null and u1.admin_id='$uid') and tblcallevents.nextCFID!='0' and user_details.type_id='4' and tblcallevents.actiontype_id='1' and actontaken='yes' and purpose_achieved='yes' GROUP BY cid_id)");
             return $query->result();
         }  
     }
     
     
     
     public function get_alertpoint($uid,$code,$date){
         
         if($code==1){
             $query=$this->db->query("SELECT allreviewdata.sdatet,company_master.compname,user_details.name,s1.name exstatus,s2.name cstatus,allreviewdata.exdate FROM allreviewdata LEFT JOIN init_call ON init_call.id=allreviewdata.inid LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN user_details ON user_details.user_id=allreviewdata.bdid LEFT JOIN status s1 ON s1.id=allreviewdata.exsid  LEFT JOIN status s2 ON s2.id=init_call.cstatus WHERE allreviewdata.exsid!=init_call.cstatus and pst='$uid'");
             return $query->result();
         }
         
         if($code==2){
             $query=$this->db->query("SELECT allreviewdata.sdatet,company_master.compname,user_details.name,action.name acname FROM allreviewdata LEFT JOIN init_call ON init_call.id=allreviewdata.inid LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN user_details ON user_details.user_id=allreviewdata.bdid left JOIN tblcallevents ON tblcallevents.id=allreviewdata.ntid LEFT JOIN action ON action.id=tblcallevents.actiontype_id WHERE pst='$uid' and tblcallevents.nextCFID='0'");
             return $query->result();
         }
         
     }
     
     public function get_bdpopup($ur_id){
        $tdatet= date('Y-m-d H:i:s');
        $tdate= date('Y-m-d');
        $data = "";
        
        
        $query=$this->db->query("SELECT count(*) b FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id left JOIN company_master ON company_master.id=init_call.cmpid_id WHERE tblcallevents.mom!='' and user_details.user_id='$ur_id' and init_call.apst is null and init_call.mainbd is not null");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='".base_url()."/Menu/BDAlertDetail/1'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Company Pending for PST Assign</b></div><a/>";}
        
        $query=$this->db->query("SELECT COUNT(*) b, COUNT(CASE WHEN init_call.cstatus='1' THEN init_call.cstatus END) ope, COUNT(CASE WHEN init_call.cstatus='8' THEN init_call.cstatus END) rpe, COUNT(CASE WHEN init_call.cstatus='2' THEN init_call.cstatus END) rec, COUNT(CASE WHEN init_call.cstatus='3' THEN init_call.cstatus END) ten FROM init_call LEFT JOIN allreviewdata ON allreviewdata.inid=init_call.id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE init_call.mainbd='$ur_id' and apst is null and allreviewdata.inid is null");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='".base_url()."/Menu/BDAlertDetail/2'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Company Not Taken any Self Review</b></div><a/>";}
        
        $query=$this->db->query("SELECT COUNT(*) b FROM init_call LEFT JOIN allreviewdata ON allreviewdata.inid=init_call.id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE init_call.mainbd='$ur_id' and apst is not null and allreviewdata.inid is null");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='".base_url()."/Menu/BDAlertDetail/3'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Company Not Taken any Review by PST</b></div><a/>";}
        
        
        date_default_timezone_set("Asia/Kolkata");
        $nextdate = date('Y-m-d', strtotime('+1 day')); 
        $nxtdtask=$this->Menu_model->get_nxtdtask($ur_id,$nextdate);
        $nxtdplan = $this->Menu_model->get_nxtdplan($ur_id,$nextdate);
        if($nxtdplan[0]->cont > 0){
        $data = $data."<a href='#'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>You Are Not Plan for Next Day Task</b></div><a/>";}
        
        $query=$this->db->query("SELECT COUNT(CASE WHEN init_call.cstatus='6' THEN init_call.cstatus END) + COUNT(CASE WHEN init_call.cstatus='7' THEN init_call.cstatus END) + COUNT(CASE WHEN init_call.cstatus='9' THEN init_call.cstatus END) + COUNT(CASE WHEN init_call.cstatus='12' THEN init_call.cstatus END) + COUNT(CASE WHEN init_call.cstatus='13' THEN init_call.cstatus END) b FROM init_call LEFT JOIN allreviewdata ON allreviewdata.inid=init_call.id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE init_call.mainbd='$ur_id' and apst is not null and allreviewdata.inid is null ORDER BY `init_call`.`cstatus` ASC");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='".base_url()."/Menu/BDAlertDetail/4'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Company Not Taken any Review by Admin</b></div><a/>";}
        
        $query=$this->db->query("SELECT COUNT(init_call.id) b FROM init_call WHERE apst is not null and mainbd='$ur_id' AND init_call.id NOT IN (SELECT cid_id FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE cid_id IN (SELECT DISTINCT id FROM init_call WHERE apst is not null and mainbd='$ur_id') and tblcallevents.nextCFID!='0' and user_details.type_id='4' and tblcallevents.actiontype_id='1' and actontaken='yes' and purpose_achieved='yes' GROUP BY cid_id)");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='".base_url()."/Menu/pstwork'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Company PST Assign but Not Work on This</b></div><a/>";}
        
        $query=$this->db->query("SELECT count(CASE WHEN nextCFID=0 THEN nextCFID end) b FROM tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.user_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and plan=0");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='#'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Task Pending for Plan</b></div><a/>";}
        
        $query=$this->db->query("SELECT (SELECT count(*) FROM user_details where admin_id='$ur_id' and status='active' and type_id=3) a, COUNT(*) b, COUNT(case when wffo=1 then wffo end) c, COUNT(case when wffo=2 then wffo end) d, COUNT(case when wffo=3 then wffo end) e FROM user_day LEFT JOIN user_details ON user_details.user_id=user_day.user_id WHERE cast(ustart as DATE)='$tdate' and user_details.user_id='$ur_id'");
        $da = $query->result();
        $da = $da[0]->a - $da[0]->b;
        if($da>0){
        $data = $data."<a href='#'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da." BD Not Started Their  Day</b></div><a/>";}
        
        $query=$this->db->query("SELECT count(CASE WHEN nextCFID=0 THEN nextCFID end) b FROM tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.user_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and plan=1");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='".base_url()."Menu/AlertReply/5'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Task Pending for Completion</b></div><a/>";}
        
        $query=$this->db->query("SELECT count(CASE WHEN nextCFID=0 and actiontype_id=6 THEN nextCFID end) b FROM tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.user_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and plan=1");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='#'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Task MOM Pending for Completion</b></div><a/>";}
        
        $query=$this->db->query("SELECT count(*) b from tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.user_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '09:00:00' and '11:00:00'");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='".base_url()."Menu/AlertReply/7'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Task Pending for Completion (09am to 11am)</b></div><a/>";}
        
        $query=$this->db->query("SELECT count(*) b from tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.user_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '11:00:01' and '13:00:00'");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='".base_url()."Menu/AlertReply/7'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Task Pending for Completion (11am to 01pm)</b></div><a/>";}
        
        $query=$this->db->query("SELECT count(*) b from tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.user_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '13:00:01' and '15:00:00'");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='#'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Task Pending for Completion (01pm to 03pm)</b></div><a/>";}
        
        $query=$this->db->query("SELECT count(*) b from tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.user_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '15:00:01' and '17:00:00'");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='#'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Task Pending for Completion (03pm to 05pm)</b></div><a/>";}
        
        $query=$this->db->query("SELECT count(*) b from tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.user_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '17:00:01' and '19:00:00'");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='#'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Task Pending for Completion (05pm to 07pm)</b></div><a/>";}
        
        $query=$this->db->query("SELECT count(*) b from tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.user_id='$ur_id' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '19:00:01' and '21:00:00'");
        $da1 = $query->result();
        if($da1[0]->b > 0){
        $data = $data."<a href='#'><div class='rounded border border-white text-center p-1 m-1 bg-danger text-white'><b>Total ".$da1[0]->b." Task Pending for Completion (07pm to 09pm)</b></div><a/>";}
        
        
        
        
        
        
        return $data; 
     }
     
     
     
     public function get_opalsms($ur_id){
        $tdatet= date('Y-m-d H:i:s');
        $tdate= date('Y-m-d');
        $data = "";
        
        
     }
     
     public function get_nitisms($ur_id){
        $tdatet= date('Y-m-d H:i:s');
        $tdate= date('Y-m-d');
        $data = "";
        
         
     }
     
     
     
     public function get_bdalertpoint($uid,$code){
         
         if($code==1){
             $query=$this->db->query("SELECT *,company_master.id cid FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id left JOIN company_master ON company_master.id=init_call.cmpid_id WHERE tblcallevents.mom!='' and user_details.user_id='$uid' and init_call.apst is null and init_call.mainbd is not null");
             return $query->result();
         }
         
         if($code==2){
             $query=$this->db->query("SELECT *,company_master.id cid FROM init_call LEFT JOIN allreviewdata ON allreviewdata.inid=init_call.id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE init_call.mainbd='$uid' and apst is null and allreviewdata.inid is null");
             return $query->result();
         }
         
     }
     
    
    public function get_wgdatabytid($tid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM wgdata WHERE tid='$tid'");
        return $query->result();
    }
    
    public function get_school_detailbyid($id){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM `spd` WHERE id='$id'");
        return $query->result();
    } 
     
    public function get_plantaskbyid($id){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("select * from plantask where id='$id'");
        return $query->result();
    } 
     
     public function get_taskbyaction($action){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT spd.project_code,spd.sname,user_detail.fullname,plantask.donet,plantask.id pid FROM task_assign LEFT JOIN user_detail on user_detail.id=task_assign.to_user LEFT JOIN plantask ON plantask.taskid=task_assign.id LEFT JOIN spd ON spd.id=task_assign.spd_id LEFT JOIN report ON report.tid=task_assign.id WHERE plantask.action='$action' and tdone='1' ORDER BY plantask.donet DESC");
        return $query->result();
    }
    
    
    public function get_programdetail1($pcode){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT action,COUNT(*) cont FROM plantask left join spd on spd.id=plantask.spd_id WHERE spd.project_code='$pcode' and cast(donet as DATE)>'2023-03-31' GROUP BY action");
        return $query->result();
    }
    
    public function get_programdetail2($pcode){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT task_assign.task_type tt,task_assign.task_subtype stt,COUNT(*) cont FROM plantask left join spd on spd.id=plantask.spd_id LEFT JOIN task_assign ON task_assign.id=plantask.taskid WHERE spd.project_code='$pcode' and task_assign.task_subtype!='' and task_assign.task_type!='' and cast(donet as DATE)>'2023-03-31' GROUP BY task_assign.task_type,task_assign.task_subtype");
        return $query->result();
    }
    
    
    public function get_programdetail3($pcode){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("Select * FROM task_assign LEFT JOIN plantask ON plantask.taskid=task_assign.id LEFT JOIN user_detail ON user_detail.id=task_assign.to_user LEFT JOIN spd ON spd.id=task_assign.spd_id LEFT JOIN status ON status.id=spd.status WHERE spd.project_code='$pcode' and task_assign.task_subtype!='' and task_assign.task_type!='' and cast(donet as DATE)>'2023-03-31'");
        return $query->result();
    }
    
    
    public function get_programdetail4($pcode){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("Select * FROM task_assign LEFT JOIN plantask ON plantask.taskid=task_assign.id LEFT JOIN user_detail ON user_detail.id=task_assign.to_user LEFT JOIN spd ON spd.id=task_assign.spd_id LEFT JOIN status ON status.id=spd.status WHERE spd.project_code='$pcode' and task_assign.task_subtype!='' and task_assign.task_type!='' and donet is null and cast(plandate as DATE)>'2023-03-31'");
        return $query->result();
    }
    
    public function get_pdetail($pcode){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT GROUP_CONCAT(DISTINCT sstate) state, GROUP_CONCAT(DISTINCT sdistrict) district, COUNT(*) spd,COUNT(case WHEN status='1' THEN status END) news,COUNT(case WHEN status='2' THEN status END) ttps,COUNT(case WHEN status='3' THEN status END) uis,COUNT(case WHEN status='4' THEN status END) avs,COUNT(case WHEN status='5' THEN status END) gos,COUNT(case WHEN status='6' THEN status END) mos,COUNT(case WHEN status='7' THEN status END) ins,COUNT(case WHEN status='8' THEN status END) crs from spd where spd.project_code='$pcode';");
        return $query->result();
    }
    
    public function get_spddetail1($sid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT action,COUNT(*) cont FROM plantask left join spd on spd.id=plantask.spd_id WHERE spd.id='$sid' and cast(donet as DATE)>'2023-03-31' GROUP BY action");
        return $query->result();
    }
    
     
     
     public function add_bdHandover($sname,$saddress,$scity,$sstate,$scontact,$sdegignation,$snumber,$bdid, $client_name, $mediator, $noofschool, $location, $city, $state, $spd_identify_by, $infrastructure, $filname,$count, $contact_person, $cp_mno, $acontact_person, $acp_mno, $language, $expected_installation_date, $project_tenure,$project_type, $comments,$sid,$remark,$fttptype){
        
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
                    
                    $currentMonth = date('n');
                    $currentYear = date('Y');
                    if ($currentMonth < 4) {
                        $financialYearStart = ($currentYear - 1);
                        $financialYearEnd = $currentYear;
                    } else {
                        $financialYearStart = $currentYear;
                        $financialYearEnd = ($currentYear + 1);
                    }
                    $financialYear = $financialYearStart . '-' . $financialYearEnd;       
        
        $db3 = $this->load->database('db3', TRUE);
        $db3->query("INSERT INTO `client_handover` (bd_id,client_name, mediator, noofschool, location, city, state, spd_identify_by, infrastructure, logo, contact_person, cp_mno, acontact_person, acp_mno, language, expected_installation_date, project_tenure,project_type,comments,remark,fttptype,project_year) VALUES ('$bdid','$client_name', '$mediator', '$noofschool', '$location', '$city', '$state', '$spd_identify_by', '$infrastructure', '$flink', '$contact_person', '$cp_mno', '$acontact_person', '$acp_mno', '$language', '$expected_installation_date', '$project_tenure', '$project_type', '$comments','$remark','$fttptype','$financialYear')");
        $cid= $db3->insert_id();
        
        $l=sizeof($sid);
        for($i=0;$i<$l;$i++){
            $db3->query("Update spd set idebypi=pi_id, cid='$cid', pi_id=null where id='$sid[$i]'");
        }
        
        if($sname!=0){
            $l=sizeof($sname);
            for($i=0;$i<$l;$i++){
                $db3->query("INSERT INTO spd (sname,saddress,scity,sstate,cid) VALUES ('$sname[$i]','$saddress[$i]','$scity[$i]','$sstate[$i]','$cid')");
                $ssid = $db3->insert_id();
                $db3->query("INSERT INTO spd_contact (contact_name,designation,contact_no,main,sid) VALUES ('$scontact[$i]','$sdegignation[$i]','$snumber[$i]','1','$ssid')");
            }
        }
        
        
        $db3->query("INSERT INTO handoverlog (cid, taskby, remark) VALUES ('$cid','1','Handover From BD to Program Manager')");
        return $cid;
    }
    
    
    public function Task_Reminder($tid,$uid){
        $date=date('Y-m-d H:i:s');
        $this->db->query("Update tblcallevents set  reminder=reminder+1,reminderby='$uid',reminderat='$date' where id='$tid'");
    }
    
    
    
    
    
    public function add_handchange($clientid, $mediator, $location, $city, $state, $spd_identify_by, $infrastructure, $contact_person, $cp_mno, $acontact_person, $acp_mno, $language, $expected_installation_date, $project_tenure,$project_type,$comments,$remark,$fttptype,$wono,$porno,$gstno,$panno,$tbudget,$payterm,$pwosdate,$moudate,$srfinovice,$proformadate,$taxinvoicedate){
        
        $db3 = $this->load->database('db3', TRUE);
        $db3->query("Update client_handover set  mediator='$mediator', location='$location', city='$city', state='$state', spd_identify_by='$spd_identify_by', infrastructure='$infrastructure', contact_person='$contact_person', cp_mno='$cp_mno', acontact_person='$acontact_person', acp_mno='$acp_mno', language='$language', expected_installation_date='$expected_installation_date', project_tenure='$project_tenure',project_type='$project_type',comments='$comments',remark='$remark',fttptype='$fttptype' where id='$clientid'");
        
        $db3->query("Update handover_account set wono='$wono',porno='$porno',gstno='$gstno',panno='$panno',tbudget='$tbudget',payterm='$payterm',pwosdate='$pwosdate',moudate='$moudate',srfinovice='$srfinovice',proformadate='$proformadate',taxinvoicedate='$taxinvoicedate' where handover_id='$clientid'");
        
        
        $db3->query("insert INTO handoverlog (cid, taskby, remark) VALUES ('$clientid','1','Handover Edit by Admin')");
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
           $db3->query("INSERT INTO handoverlog(cid, taskby, remark, stid) VALUES ('$cid','$by','$remark','8')");
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
    
    
    public function get_projectbyclient($bdid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT client_handover.id cid, client_name AS cname, COUNT(DISTINCT client_handover.projectcode) AS tproject, MAX(client_handover.sdatet) AS lhand, COUNT(spd.id) AS tspd, GROUP_CONCAT(DISTINCT project_year) AS pyear, MAX(plantask.donet) AS ltask, DATEDIFF(CURDATE(), MAX(plantask.donet)) AS tdiff FROM client_handover LEFT JOIN spd ON spd.project_code = client_handover.projectcode LEFT JOIN plantask ON plantask.spd_id = spd.id WHERE client_handover.bd_id = '$bdid' AND plantask.tdone = '1' GROUP BY client_name,client_handover.id");
        return $query->result();
    }
    
    
    
    public function bdr_comment($rid,$rcomment,$filname,$uname){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("INSERT INTO bdrequestlog(tid, tby, remark,attech) VALUES ('$rid','$uname','$rcomment','$filname')");
    }
    
    
    public function HandBIND_Reminder($cid,$stid,$creminder,$uname){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("INSERT INTO hnadtoinrw(user,cid,stid,type,remark) VALUES ('$uname','$cid','$stid','Reminder','$creminder')");
    }
    
    
    public function HandBIND_Warn($cid,$stid,$cwarning,$uname){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("INSERT INTO hnadtoinrw(user,cid,stid,type,remark) VALUES ('$uname','$cid','$stid','Warn','$cwarning')");
    }
    
    
    public function get_HandBIND($bdid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT client_handover.bd_id,client_handover.projectcode,client_handover.id cid, client_name AS cname, COUNT(DISTINCT client_handover.projectcode) AS tproject, MAX(client_handover.sdatet) AS lhand, COUNT(spd.id) AS tspd, GROUP_CONCAT(DISTINCT project_year) AS pyear, MAX(plantask.donet) AS ltask, DATEDIFF(CURDATE(), MAX(plantask.donet)) AS tdiff FROM client_handover LEFT JOIN spd ON spd.project_code = client_handover.projectcode LEFT JOIN plantask ON plantask.spd_id = spd.id WHERE client_handover.bd_id = '$bdid' AND allinsdone='0' GROUP BY client_name,client_handover.id,client_handover.projectcode,client_handover.bd_id");
        return $query->result();
    }
    
    public function get_HandBINDs($bdid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT client_handover.bd_id,client_handover.projectcode,client_handover.id cid, client_name AS cname, COUNT(DISTINCT client_handover.projectcode) AS tproject, MAX(client_handover.sdatet) AS lhand, COUNT(spd.id) AS tspd, GROUP_CONCAT(DISTINCT project_year) AS pyear, MAX(plantask.donet) AS ltask, DATEDIFF(CURDATE(), MAX(plantask.donet)) AS tdiff FROM client_handover LEFT JOIN spd ON spd.project_code = client_handover.projectcode LEFT JOIN plantask ON plantask.spd_id = spd.id WHERE client_handover.bd_id IN ('58','10','15','31','29','8','100024') AND allinsdone='0' GROUP BY client_name,client_handover.id,client_handover.projectcode,client_handover.bd_id");
        return $query->result();
    }
    
    public function get_HandBINDbycid($cid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT client_handover.bd_id,client_handover.projectcode,client_handover.id cid, client_name AS cname, COUNT(DISTINCT client_handover.projectcode) AS tproject, MAX(client_handover.sdatet) AS lhand, COUNT(spd.id) AS tspd, GROUP_CONCAT(DISTINCT project_year) AS pyear, MAX(plantask.donet) AS ltask, DATEDIFF(CURDATE(), MAX(plantask.donet)) AS tdiff FROM client_handover LEFT JOIN spd ON spd.project_code = client_handover.projectcode LEFT JOIN plantask ON plantask.spd_id = spd.id WHERE client_handover.id = '$cid' AND allinsdone='0' GROUP BY client_name,client_handover.id,client_handover.projectcode,client_handover.bd_id");
        return $query->result();
    }
    
    
    public function get_clientbyiid($cid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("select *,client_handover.id as cid,client_handover.sdatet htpm ,handover_account.sdatet htac from client_handover LEFT join handover_account on handover_account.handover_id=client_handover.id LEFT join fm_timeline on fm_timeline.handover_id=client_handover.id where client_handover.id='$cid'");
        return $query->result();
    }
    
    
    public function get_handoverlogfordesign($cid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM `handoverlog` WHERE cid='$cid' and (stid='8' OR stid='17' OR stid='18' OR stid='21')");
        return $query->result();
    }
    
    public function get_budget($cid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT bname FROM budget WHERE cid='$cid' and basic!='' and bname!='TOTAL'");
        return $query->result();
    }
    
    
    public function get_spdbycid($cid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("select * from spd where cid='$cid'");
        return $query->result();
    }
    
    
    
    
    
    public function get_projectbycid($bdid,$cid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT client_handover.id cid, client_name AS cname, COUNT(DISTINCT client_handover.projectcode) AS tproject, MAX(client_handover.sdatet) AS lhand, COUNT(spd.id) AS tspd, GROUP_CONCAT(DISTINCT project_year) AS pyear, MAX(plantask.donet) AS ltask, DATEDIFF(CURDATE(), MAX(plantask.donet)) AS tdiff FROM client_handover LEFT JOIN spd ON spd.project_code = client_handover.projectcode LEFT JOIN plantask ON plantask.spd_id = spd.id WHERE client_handover.id='$cid' and client_handover.bd_id = '$bdid' AND plantask.tdone = '1' GROUP BY client_name,client_handover.id");
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
    
    
    public function get_action(){
        $query=$this->db->query("SELECT * FROM action");
        return $query->result();
     }
     
     
     public function get_actionbyid($id){
        $query=$this->db->query("SELECT * FROM action where id='$id'");
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
        $query=$this->db->query("SELECT company_master.id id,init_call.mainbd, company_master.compname compname FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id left JOIN company_master ON company_master.id=init_call.cmpid_id WHERE tblcallevents.mom!='' and user_details.admin_id='$uid'and init_call.apst is null and cast(tblcallevents.updateddate as DATE)>'2023-03-31' and init_call.pstadt is null group by company_master.id,init_call.mainbd,company_master.compname");
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
         $date=date('Y-m-d H:i:s');
        $query=$this->db->query("UPDATE init_call set apst='$apst',pstadt='$date',cstatus='$cstatus' WHERE cmpid_id='$compid'");
        $query=$this->db->query("SELECT * FROM init_call WHERE cmpid_id='$compid'");
        $data = $query->result();
        
        $inid = $data[0]->id;
        
        
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
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
    $query=$this->db->query("SELECT tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE cast(updateddate as DATE)='$tdate' and nextCFID!=0 and updation_data_type='updated' and lastCFID!=0 and $text");
        return $query->result();
    }
    
    
    
    
    
    
    
    
    public function get_scong($uid,$tdate,$ab){
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
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
    
    public function get_statusbyname($sname){
        $query=$this->db->query("SELECT * FROM status where name='$sname'");
        return $query->result();
    }
    
    
    public function final_pstscon1($uid,$sd,$ed,$ab){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='4' and user_details.status='active'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        $query=$this->db->query("SELECT DISTINCT CONCAT(s1.name, ' -to- ', s2.name) scname FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id WHERE $text and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and s1.name!=s2.name and s1.name is not null and s2.name is not null");
        return $query->result();
    }
    
    public function final_myscon1($uid,$sd,$ed,$ab){
        $text = "user_details.user_id='$uid'";
        $query=$this->db->query("SELECT DISTINCT CONCAT(s1.name, ' -to- ', s2.name) scname FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id WHERE $text and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and s1.name!=s2.name and s1.name is not null and s2.name is not null");
        return $query->result();
    }
    
    
    
    public function final_myscon5($uid,$sd,$ed,$ab){
        $text = "user_details.user_id='$uid'";
        $query=$this->db->query("SELECT count(*) cont, count(case when actiontype_id=1 then 1 end) tcall FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id WHERE $text and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and s1.name!=s2.name and s1.name is not null and s2.name is not null");
        return $query->result();
    }
    
    
    public function final_pstscon5($uid,$sd,$ed,$ab){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='4' and user_details.status='active'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        $query=$this->db->query("SELECT count(*) cont, count(case when actiontype_id=1 then 1 end) tcall FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id WHERE $text and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and s1.name!=s2.name and s1.name is not null and s2.name is not null");
        return $query->result();
    }
    
    
    public function final_scon1($uid,$sd,$ed,$ab){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        $query=$this->db->query("SELECT DISTINCT CONCAT(s1.name, ' -to- ', s2.name) scname FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id WHERE $text and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and s1.name!=s2.name and s1.name is not null and s2.name is not null");
        return $query->result();
    }
    
    
    public function final_myscon4($uid,$sd,$ed,$ab){
        $text = "user_details.user_id='$uid'";
        $query=$this->db->query("SELECT DISTINCT tblcallevents.user_id bdid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id WHERE $text and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and s1.name!=s2.name and s1.name is not null and s2.name is not null");
        return $query->result();
    }
    
    public function final_pstscon4($uid,$sd,$ed,$ab){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='4' and user_details.status='active'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        $query=$this->db->query("SELECT DISTINCT tblcallevents.user_id bdid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id WHERE $text and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and s1.name!=s2.name and s1.name is not null and s2.name is not null");
        return $query->result();
    }
    
    public function final_scon4($uid,$sd,$ed,$ab){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        $query=$this->db->query("SELECT DISTINCT tblcallevents.user_id bdid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id WHERE $text and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and s1.name!=s2.name and s1.name is not null and s2.name is not null");
        return $query->result();
    }
    
    
    public function final_pstscon2($uid,$sd,$ed,$ab,$fsid,$ssid){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='4' and user_details.status='active'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id WHERE $text and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and status_id!=nstatus_id and status_id='$fsid' and nstatus_id='$ssid'");
        $data =  $query->result();
        return $data[0]->cont;
    }
    
    
    public function final_myscon2($uid,$sd,$ed,$ab,$fsid,$ssid){
        $text = "user_details.user_id='$uid'";
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id WHERE $text and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and status_id!=nstatus_id and status_id='$fsid' and nstatus_id='$ssid'");
        $data =  $query->result();
        return $data[0]->cont;
    }
    
    
    
    public function final_scon2($uid,$sd,$ed,$ab,$fsid,$ssid){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id WHERE $text and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and status_id!=nstatus_id and status_id='$fsid' and nstatus_id='$ssid'");
        $data =  $query->result();
        return $data[0]->cont;
    }
    
    public function final_pstscon3($uid,$sd,$ed,$fsid,$ssid){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='4' and user_details.status='active'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        $query=$this->db->query("SELECT *, tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id WHERE $text and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and status_id!=nstatus_id and status_id='$fsid' and nstatus_id='$ssid'");
        return  $query->result();
    }
    
    
    public function final_myscon3($uid,$sd,$ed,$fsid,$ssid){
        $text = "user_details.user_id='$uid'";
        $query=$this->db->query("SELECT *, tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id WHERE $text and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and status_id!=nstatus_id and status_id='$fsid' and nstatus_id='$ssid'");
        return  $query->result();
    }
    
    
    public function final_scon3($uid,$sd,$ed,$fsid,$ssid){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        $query=$this->db->query("SELECT *, tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id WHERE $text and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and status_id!=nstatus_id and status_id='$fsid' and nstatus_id='$ssid'");
        return  $query->result();
    }
    
    
    
    public function get_bwdtteamtdbymy($uid,$sd,$ed,$bdid){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.user_id='$uid'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.user_id='$uid'";}
        $query=$this->db->query("SELECT Count(DISTINCT tblcallevents.user_id)bdcount,COUNT(*) a,count(CASE WHEN nextCFID=0 THEN nextCFID end) b,count(CASE WHEN nextCFID!=0 THEN nextCFID end) c, count(CASE WHEN actiontype_id=1 THEN actiontype_id end) d,count(CASE WHEN actiontype_id=1 and nextCFID=0 THEN actiontype_id end) e,count(CASE WHEN actiontype_id=2 THEN actiontype_id end) f,count(CASE WHEN actiontype_id=2 and nextCFID=0 THEN actiontype_id end) g,count(CASE WHEN actiontype_id=3 THEN actiontype_id end) h,count(CASE WHEN actiontype_id=3 and nextCFID=0 THEN actiontype_id end) i,count(CASE WHEN actiontype_id=4 THEN actiontype_id end) j,count(CASE WHEN actiontype_id=4 and nextCFID=0 THEN actiontype_id end) k,count(CASE WHEN actiontype_id=5 THEN actiontype_id end) l,count(CASE WHEN actiontype_id=5 and nextCFID=0 THEN actiontype_id end) m,count(CASE WHEN actiontype_id=6 THEN actiontype_id end) n,count(CASE WHEN actiontype_id=6 and nextCFID=0 THEN actiontype_id end) o,count(CASE WHEN actiontype_id=7 THEN actiontype_id end) p,count(CASE WHEN actiontype_id=7 and nextCFID=0 THEN actiontype_id end) q,count(CASE WHEN actontaken='yes' and nextCFID!=0 THEN actiontype_id end) r,count(CASE WHEN actontaken='no' and nextCFID!=0 THEN actiontype_id end) s,count(CASE WHEN purpose_achieved='yes' and nextCFID!=0 THEN actiontype_id end) t,count(CASE WHEN purpose_achieved='no' and nextCFID!=0 THEN actiontype_id end) u FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed'");
        return $query->result();
    }
    
    
    public function get_bwdtteamtdbypst($uid,$sd,$ed,$bdid){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and (user_details.type_id='4' or user_details.type_id='9') and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='4' and user_details.status='active'";}
        $query=$this->db->query("SELECT Count(DISTINCT tblcallevents.user_id)bdcount,COUNT(*) a,count(CASE WHEN nextCFID=0 THEN nextCFID end) b,count(CASE WHEN nextCFID!=0 THEN nextCFID end) c, count(CASE WHEN actiontype_id=1 THEN actiontype_id end) d,count(CASE WHEN actiontype_id=1 and nextCFID=0 THEN actiontype_id end) e,count(CASE WHEN actiontype_id=2 THEN actiontype_id end) f,count(CASE WHEN actiontype_id=2 and nextCFID=0 THEN actiontype_id end) g,count(CASE WHEN actiontype_id=3 THEN actiontype_id end) h,count(CASE WHEN actiontype_id=3 and nextCFID=0 THEN actiontype_id end) i,count(CASE WHEN actiontype_id=4 THEN actiontype_id end) j,count(CASE WHEN actiontype_id=4 and nextCFID=0 THEN actiontype_id end) k,count(CASE WHEN actiontype_id=5 THEN actiontype_id end) l,count(CASE WHEN actiontype_id=5 and nextCFID=0 THEN actiontype_id end) m,count(CASE WHEN actiontype_id=6 THEN actiontype_id end) n,count(CASE WHEN actiontype_id=6 and nextCFID=0 THEN actiontype_id end) o,count(CASE WHEN actiontype_id=7 THEN actiontype_id end) p,count(CASE WHEN actiontype_id=7 and nextCFID=0 THEN actiontype_id end) q,count(CASE WHEN actontaken='yes' and nextCFID!=0 THEN actiontype_id end) r,count(CASE WHEN actontaken='no' and nextCFID!=0 THEN actiontype_id end) s,count(CASE WHEN purpose_achieved='yes' and nextCFID!=0 THEN actiontype_id end) t,count(CASE WHEN purpose_achieved='no' and nextCFID!=0 THEN actiontype_id end) u FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed'");
        return $query->result();
    }
    
    
    
    
    public function get_bwdtteamtdbybd($uid,$sd,$ed,$bdid){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        $query=$this->db->query("SELECT Count(DISTINCT tblcallevents.user_id)bdcount,COUNT(*) a,count(CASE WHEN nextCFID=0 THEN nextCFID end) b,count(CASE WHEN nextCFID!=0 THEN nextCFID end) c, count(CASE WHEN actiontype_id=1 THEN actiontype_id end) d,count(CASE WHEN actiontype_id=1 and nextCFID=0 THEN actiontype_id end) e,count(CASE WHEN actiontype_id=2 THEN actiontype_id end) f,count(CASE WHEN actiontype_id=2 and nextCFID=0 THEN actiontype_id end) g,count(CASE WHEN actiontype_id=3 THEN actiontype_id end) h,count(CASE WHEN actiontype_id=3 and nextCFID=0 THEN actiontype_id end) i,count(CASE WHEN actiontype_id=4 THEN actiontype_id end) j,count(CASE WHEN actiontype_id=4 and nextCFID=0 THEN actiontype_id end) k,count(CASE WHEN actiontype_id=5 THEN actiontype_id end) l,count(CASE WHEN actiontype_id=5 and nextCFID=0 THEN actiontype_id end) m,count(CASE WHEN actiontype_id=6 THEN actiontype_id end) n,count(CASE WHEN actiontype_id=6 and nextCFID=0 THEN actiontype_id end) o,count(CASE WHEN actiontype_id=7 THEN actiontype_id end) p,count(CASE WHEN actiontype_id=7 and nextCFID=0 THEN actiontype_id end) q,count(CASE WHEN actontaken='yes' and nextCFID!=0 THEN actiontype_id end) r,count(CASE WHEN actontaken='no' and nextCFID!=0 THEN actiontype_id end) s,count(CASE WHEN purpose_achieved='yes' and nextCFID!=0 THEN actiontype_id end) t,count(CASE WHEN purpose_achieved='no' and nextCFID!=0 THEN actiontype_id end) u FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and plan=1 and cast(appointmentdatetime as DATE) BETWEEN '$sd' and '$ed'");
        return $query->result();
    }
    
    
    public function get_bwdtotaltd($uid,$sd,$ed){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and (user_details.type_id='3' or user_details.type_id='9') and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.user_id='$uid'";}
        $query=$this->db->query("SELECT Count(DISTINCT tblcallevents.user_id)bdcount,COUNT(*) a,count(CASE WHEN nextCFID=0 THEN nextCFID end) b,count(CASE WHEN nextCFID!=0 THEN nextCFID end) c, count(CASE WHEN actiontype_id=1 THEN actiontype_id end) d,count(CASE WHEN actiontype_id=1 and nextCFID=0 THEN actiontype_id end) e,count(CASE WHEN actiontype_id=2 THEN actiontype_id end) f,count(CASE WHEN actiontype_id=2 and nextCFID=0 THEN actiontype_id end) g,count(CASE WHEN actiontype_id=3 THEN actiontype_id end) h,count(CASE WHEN actiontype_id=3 and nextCFID=0 THEN actiontype_id end) i,count(CASE WHEN actiontype_id=4 THEN actiontype_id end) j,count(CASE WHEN actiontype_id=4 and nextCFID=0 THEN actiontype_id end) k,count(CASE WHEN actiontype_id=5 THEN actiontype_id end) l,count(CASE WHEN actiontype_id=5 and nextCFID=0 THEN actiontype_id end) m,count(CASE WHEN actiontype_id=6 THEN actiontype_id end) n,count(CASE WHEN actiontype_id=6 and nextCFID=0 THEN actiontype_id end) o,count(CASE WHEN actiontype_id=7 THEN actiontype_id end) p,count(CASE WHEN actiontype_id=7 and nextCFID=0 THEN actiontype_id end) q,count(CASE WHEN actontaken='yes' and nextCFID!=0 THEN actiontype_id end) r,count(CASE WHEN actontaken='no' and nextCFID!=0 THEN actiontype_id end) s,count(CASE WHEN purpose_achieved='yes' and nextCFID!=0 THEN actiontype_id end) t,count(CASE WHEN purpose_achieved='no' and nextCFID!=0 THEN actiontype_id end) u FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and plan=1 and cast(appointmentdatetime as DATE) BETWEEN '$sd' and '$ed'");
        return $query->result();
    }
    
    
    public function get_bwdtotaltdpst($uid,$sd,$ed){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and (user_details.type_id='4'  or user_details.type_id='9') and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='4' and user_details.status='active'";}
        
        $query=$this->db->query("SELECT COUNT(*) a,count(CASE WHEN nextCFID=0 THEN nextCFID end) b,count(CASE WHEN nextCFID!=0 THEN nextCFID end) c, count(CASE WHEN actiontype_id=1 THEN actiontype_id end) d,count(CASE WHEN actiontype_id=1 and nextCFID=0 THEN actiontype_id end) e,count(CASE WHEN actiontype_id=2 THEN actiontype_id end) f,count(CASE WHEN actiontype_id=2 and nextCFID=0 THEN actiontype_id end) g,count(CASE WHEN actiontype_id=3 THEN actiontype_id end) h,count(CASE WHEN actiontype_id=3 and nextCFID=0 THEN actiontype_id end) i,count(CASE WHEN actiontype_id=4 THEN actiontype_id end) j,count(CASE WHEN actiontype_id=4 and nextCFID=0 THEN actiontype_id end) k,count(CASE WHEN actiontype_id=5 THEN actiontype_id end) l,count(CASE WHEN actiontype_id=5 and nextCFID=0 THEN actiontype_id end) m,count(CASE WHEN actiontype_id=6 THEN actiontype_id end) n,count(CASE WHEN actiontype_id=6 and nextCFID=0 THEN actiontype_id end) o,count(CASE WHEN actiontype_id=7 THEN actiontype_id end) p,count(CASE WHEN actiontype_id=7 and nextCFID=0 THEN actiontype_id end) q,count(CASE WHEN actontaken='yes' and nextCFID!=0 THEN actiontype_id end) r,count(CASE WHEN actontaken='no' and nextCFID!=0 THEN actiontype_id end) s,count(CASE WHEN purpose_achieved='yes' and nextCFID!=0 THEN actiontype_id end) t,count(CASE WHEN purpose_achieved='no' and nextCFID!=0 THEN actiontype_id end) u FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE user_details.user_id='$uid' and plan=1 and cast(appointmentdatetime as DATE) BETWEEN '$sd' and '$ed'");
        return $query->result();
    }
    
    
    
    public function get_mywdalltaskdbyad($code,$atid,$uid,$sd,$ed,$ab){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.user_id='$uid'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.user_id='$uid'";}
        
        if($code==4){
            $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1");
            
        }elseif($code==5){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID=0");
             
        }elseif($code==6){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0");
             
        }elseif($code==1){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1  and actiontype_id='$atid'");
             
        }elseif($code==2){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID=0 and actiontype_id='$atid'");
             
        }elseif($code==3){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0 and actiontype_id='$atid'");
             
        }elseif($code==7){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0 and actontaken='yes'");
             
        }elseif($code==8){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0 and actontaken='no'");
             
        }elseif($code==9){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0 and actontaken='yes' and purpose_achieved='no'");
             
        }elseif($code==10){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0 and actontaken='yes' and purpose_achieved='yes'");
             
        }else{
        $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0");
        }
        return $query->result();  
        
        
    }
    
    public function get_pstwdalltaskdbyad($code,$atid,$uid,$sd,$ed,$ab){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and (user_details.type_id='4' or user_details.type_id='9') and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.user_id='$uid'";}
        
        if($code==4){
            $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1");
            
        }elseif($code==5){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID=0");
             
        }elseif($code==6){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0");
             
        }elseif($code==1){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1  and actiontype_id='$atid'");
             
        }elseif($code==2){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID=0 and actiontype_id='$atid'");
             
        }elseif($code==3){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0 and actiontype_id='$atid'");
             
        }elseif($code==7){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0 and actontaken='yes'");
             
        }elseif($code==8){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0 and actontaken='no'");
             
        }elseif($code==9){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0 and  purpose_achieved='no'");
             
        }elseif($code==10){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0 and  purpose_achieved='yes'");
             
        }else{
        $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0");
        }
        return $query->result();  
        
        
    }
    
    
    
    public function get_pstwdalltaskdbyads($code,$atid,$uid,$sd,$ed,$ab){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='9' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='9' and user_details.status='active'";}
        
        if($code==4){
            $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1");
            
        }elseif($code==5){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID=0");
             
        }elseif($code==6){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0");
             
        }elseif($code==1){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1  and actiontype_id='$atid'");
             
        }elseif($code==2){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID=0 and actiontype_id='$atid'");
             
        }elseif($code==3){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0 and actiontype_id='$atid'");
             
        }elseif($code==7){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0 and actontaken='yes'");
             
        }elseif($code==8){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0 and actontaken='no'");
             
        }elseif($code==9){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0 and  purpose_achieved='no'");
             
        }elseif($code==10){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0 and  purpose_achieved='yes'");
             
        }else{
        $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0");
        }
        return $query->result();   
        
        
    }
    
    
    public function get_bwdalltaskdbyad($code,$atid,$uid,$sd,$ed,$ab){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        
        if($code==4){
            $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1");
            
        }elseif($code==5){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID=0");
             
        }elseif($code==6){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0");
             
        }elseif($code==1){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1  and actiontype_id='$atid'");
             
        }elseif($code==2){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID=0 and actiontype_id='$atid'");
             
        }elseif($code==3){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0 and actiontype_id='$atid'");
             
        }elseif($code==7){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0 and actontaken='yes'");
             
        }elseif($code==8){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0 and actontaken='no'");
             
        }elseif($code==9){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0 and purpose_achieved='no'");
             
        }elseif($code==10){
           $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0 and actontaken='yes' and purpose_achieved='yes'");
             
        }else{
        $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE $text and cast(appointmentdatetime  as DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0");
        }
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
    
    
    public function get_purposebyinid($aid,$inid){
        $query=$this->db->query("SELECT cstatus FROM init_call WHERE init_call.id='$inid'");
        $data =  $query->result();
        $sid = $data[0]->cstatus;
        
        
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
    
    public function get_compbyname($bdid,$cname){
        $query=$this->db->query("SELECT *,partner_master.name pname FROM init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN partner_master ON partner_master.id=company_master.partnerType_id LEFT JOIN company_contact_master on company_contact_master.company_id=company_master.id WHERE company_master.compname='$cname' and init_call.mainbd='$bdid' and company_contact_master.type='primary'");
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
    
    public function get_cctd($tid){
        $query=$this->db->query("SELECT *,company_contact_master.emailid emailid,company_contact_master.phoneno phoneno,company_contact_master.designation designation,user_details.name bdname,company_master.id comid,company_master.id cmid,tblcallevents.id id,action.name ctname,status.name clsname,company_master.compname cname,company_contact_master.contactperson cp from tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN company_contact_master on company_contact_master.company_id=company_master.id LEFT JOIN action on action.id=tblcallevents.actiontype_id LEFT JOIN status ON status.id=init_call.cstatus LEFT JOIN user_details ON user_details.user_id=init_call.mainbd WHERE tblcallevents.id='$tid' and company_contact_master.type='primary'");
        return $query->result();
    }
    
    
    
    
    
    public function get_next_action($purpose_id){
        $query=$this->db->query("SELECT * from next_action where purpose_id='$purpose_id'");
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
        $query=$this->db->query("SELECT COUNT(*) a,COUNT(CASE WHEN cstatus=1 THEN cstatus END) b,COUNT(CASE WHEN cstatus=2 THEN cstatus END) c,COUNT(CASE WHEN cstatus=3 THEN cstatus END) d,COUNT(CASE WHEN cstatus=4 THEN cstatus END) e,COUNT(CASE WHEN cstatus=5 THEN cstatus END) f,COUNT(CASE WHEN cstatus=6 THEN cstatus END) g,COUNT(CASE WHEN cstatus=7 THEN cstatus END) h,COUNT(CASE WHEN cstatus=8 THEN cstatus END) i,COUNT(CASE WHEN cstatus=9 THEN cstatus END) j,COUNT(CASE WHEN cstatus=10 THEN cstatus END) k,COUNT(CASE WHEN cstatus=11 THEN cstatus END) l,COUNT(CASE WHEN focus_funnel='yes' THEN focus_funnel END) m,COUNT(CASE WHEN upsell_client='yes' THEN upsell_client END) n,COUNT(CASE WHEN cstatus=12 THEN cstatus END) o,COUNT(CASE WHEN cstatus=13 THEN cstatus END) p, COUNT(CASE WHEN keycompany='yes' THEN keycompany END) q, COUNT(CASE WHEN priorityc='yes' THEN priorityc END) s, COUNT(CASE WHEN priorityc='yes' and cstatus='3' THEN priorityc END) t, COUNT(CASE WHEN pkclient='yes' THEN pkclient END) r FROM init_call WHERE mainbd='$uid'");
        return $query->result();
    }
    
    
    
    public function get_apstc($uid){
        $query=$this->db->query("SELECT COUNT(*) a,COUNT(CASE WHEN cstatus=1 THEN cstatus END) b,COUNT(CASE WHEN cstatus=2 THEN cstatus END) c,COUNT(CASE WHEN cstatus=3 THEN cstatus END) d,COUNT(CASE WHEN cstatus=4 THEN cstatus END) e,COUNT(CASE WHEN cstatus=5 THEN cstatus END) f,COUNT(CASE WHEN cstatus=6 THEN cstatus END) g,COUNT(CASE WHEN cstatus=7 THEN cstatus END) h,COUNT(CASE WHEN cstatus=8 THEN cstatus END) i,COUNT(CASE WHEN cstatus=9 THEN cstatus END) j,COUNT(CASE WHEN cstatus=10 THEN cstatus END) k,COUNT(CASE WHEN cstatus=11 THEN cstatus END) l,COUNT(CASE WHEN focus_funnel='yes' THEN focus_funnel END) m,COUNT(CASE WHEN upsell_client='yes' THEN upsell_client END) n,COUNT(CASE WHEN cstatus=12 THEN cstatus END) o,COUNT(CASE WHEN cstatus=13 THEN cstatus END) p, COUNT(CASE WHEN keycompany='yes' THEN keycompany END) q,COUNT(CASE WHEN  keycompany='yes' and apst is not null and pkclient='yes' THEN keycompany END) r,COUNT(CASE WHEN keycompany='yes' and apst is not null and priorityc='yes' THEN keycompany END) s,COUNT(CASE WHEN keycompany='yes' and apst is not null and priorityc='yes' and cstatus='3' THEN keycompany END) t,COUNT(CASE WHEN cstatus='12' THEN keycompany END) u,COUNT(CASE WHEN cstatus='13' THEN keycompany END) v FROM init_call LEFT JOIN user_details ON user_details.user_id=init_call.apst WHERE user_details.admin_id='$uid' and user_details.status='active' and mainbd!='' and mainbd is not null and  apst is not null and apst!=''");
        return $query->result();
    }
    
    public function get_fannal($uid){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){
            
            $query=$this->db->query("SELECT *,init_call.id inid FROM init_call LEFT JOIN user_details ON user_details.user_id=init_call.mainbd left JOIN company_master on company_master.id=init_call.cmpid_id WHERE user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'");
            
        }else{
        $query=$this->db->query("SELECT *,init_call.id inid FROM init_call left JOIN company_master on company_master.id=init_call.cmpid_id WHERE mainbd='$uid'");
        }
        return $query->result();
    }
    
    
    public function get_pstfannal($uid){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){
            
            $query=$this->db->query("SELECT *,init_call.id inid FROM init_call LEFT JOIN user_details ON user_details.user_id=init_call.apst left JOIN company_master on company_master.id=init_call.cmpid_id WHERE user_details.admin_id='$uid' and user_details.status='active'");
            
        }else{
        $query=$this->db->query("SELECT *,init_call.id inid FROM init_call left JOIN company_master on company_master.id=init_call.cmpid_id WHERE apst='$uid'");
        }
        return $query->result();
    }
    
    
    
    
    
    
    public function get_fannalbystid($uid,$stid){
        $query=$this->db->query("SELECT *,init_call.id inid FROM init_call left JOIN company_master on company_master.id=init_call.cmpid_id WHERE mainbd='$uid' and cstatus='$stid'");
        return $query->result();
    }
    
    
    public function get_fannalbycode($uid,$stid,$code){
        
        if($code==1){
            if($stid==0){$query=$this->db->query("SELECT *,init_call.id inid FROM init_call left JOIN company_master on company_master.id=init_call.cmpid_id WHERE mainbd='$uid'");}
            else{$query=$this->db->query("SELECT *,init_call.id inid FROM init_call left JOIN company_master on company_master.id=init_call.cmpid_id WHERE mainbd='$uid' and cstatus='$stid'");}
        }elseif($code==2){
            $query=$this->db->query("SELECT *,init_call.id inid FROM init_call left JOIN company_master on company_master.id=init_call.cmpid_id left join city on city.city=company_master.city WHERE mainbd='$uid' and city.id='$stid'");
        }elseif($code==3){
            $query=$this->db->query("SELECT *,init_call.id inid FROM init_call left JOIN company_master on company_master.id=init_call.cmpid_id WHERE mainbd='$uid' and company_master.partnerType_id='$stid'");
        }elseif($code==4){
            $query=$this->db->query("SELECT *,init_call.id inid FROM init_call left JOIN company_master on company_master.id=init_call.cmpid_id WHERE mainbd='$uid' and $stid='yes'");
        }elseif($code==5){
            $string = $stid;
            $parts = explode("A", $string);
            
            if (count($parts) == 2) {
                $stid = $parts[0];
                $cond = $parts[1];
            }
            if($cond==1){$txt = "(SELECT DATEDIFF(NOW(), MAX(ce.updateddate)) FROM tblcallevents AS ce WHERE ce.cid_id = init_call.id ) <= 10)";}
            if($cond==3){$txt = "(SELECT DATEDIFF(NOW(), MAX(ce.updateddate)) FROM tblcallevents AS ce WHERE ce.cid_id = init_call.id HAVING DATEDIFF(NOW(), MAX(ce.updateddate)) > 10 AND DATEDIFF(NOW(), MAX(ce.updateddate)) < 20))";}
            if($cond==5){$txt = "(SELECT DATEDIFF(NOW(), MAX(ce.updateddate)) FROM tblcallevents AS ce WHERE ce.cid_id = init_call.id HAVING DATEDIFF(NOW(), MAX(ce.updateddate)) > 20 AND DATEDIFF(NOW(), MAX(ce.updateddate)) < 30)";}
            if($cond==7){$txt = "(SELECT DATEDIFF(NOW(), MAX(ce.updateddate)) FROM tblcallevents AS ce WHERE ce.cid_id = init_call.id ) > 30)";}
            
            
            $query=$this->db->query("SELECT *,init_call.id inid FROM init_call left JOIN company_master on company_master.id=init_call.cmpid_id WHERE init_call.id IN (SELECT DISTINCT tblcallevents.cid_id FROM tblcallevents LEFT JOIN init_call ON init_call.id = tblcallevents.cid_id LEFT JOIN company_master ON company_master.id = init_call.cmpid_id WHERE init_call.cstatus = tblcallevents.nstatus_id AND CAST(tblcallevents.updateddate AS DATE) BETWEEN '2023-04-01' AND '2024-03-31' AND tblcallevents.cid_id IN ( SELECT id FROM init_call WHERE init_call.mainbd = '$uid' ) AND tblcallevents.nextCFID != '0' AND init_call.cstatus = '$stid' AND $txt");
        }
     elseif($code==7){
            $query=$this->db->query("SELECT COUNT(*) as cont, COUNT(case when actiontype_id=1 then 1 end) as a,COUNT(case when actiontype_id=2 then 1 end) as b,COUNT(case when actiontype_id=3 then 1 end) as c,COUNT(case when actiontype_id=4 then 1 end) as d,COUNT(case when actiontype_id=5 then 1 end) as e,COUNT(case when actiontype_id=6 then 1 end) as f,COUNT(case when actiontype_id=7 then 1 end) as g,COUNT(case when actiontype_id=8 then 1 end) as h,COUNT(case when actiontype_id=9 then 1 end) as i,COUNT(case when actiontype_id=10 then 1 end) as j,COUNT(case when actiontype_id=11 then 1 end) as k FROM tblcallevents WHERE tblcallevents.cid_id IN (Select id from init_call WHERE init_call.mainbd='$uid' and init_call.cstatus='$sid') and nextCFID!='0' and cast(updateddate as DATE) Between '$sd' and '$ed'");
    }
        else{
            $query=$this->db->query("SELECT *,init_call.id inid FROM init_call left JOIN company_master on company_master.id=init_call.cmpid_id WHERE mainbd='$uid' and cstatus='$stid'");
        }
        
        return $query->result();
    }
    
    
    
    
    
    
    
    
    
    public function get_bdlocation($uid){
        $query=$this->db->query("SELECT Distinct city FROM init_call left JOIN company_master on company_master.id=init_call.cmpid_id WHERE mainbd='$uid'");
        return $query->result();
    }
    
    public function get_bdpotentialp($uid){
        $query=$this->db->query("SELECT Distinct potentialp FROM init_call left JOIN company_master on company_master.id=init_call.cmpid_id WHERE mainbd='$uid'");
        return $query->result();
    }
    
    
    public function get_cdbyinid($inid){
        $query=$this->db->query("SELECT *,init_call.id inid FROM init_call JOIN company_master on company_master.id=init_call.cmpid_id WHERE init_call.id='$inid'");
        return $query->result();
    }
    
    
    public function get_inidtostatus($inid){
        $query=$this->db->query("SELECT cstatus FROM init_call WHERE init_call.id='$inid'");
        return $query->result();
    }
    
    
    public function get_initcom($cid){
        $query=$this->db->query("SELECT * FROM init_call JOIN company_master on company_master.id=init_call.cmpid_id WHERE init_call.cmpid_id='$cid'");
        return $query->result();
    }
    
    public function get_handover($uid){
        $db3 = $this->load->database('db3', TRUE);
        $query = $db3->query("SELECT * FROM client_handover WHERE bd_id='$uid'");
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
        $query=$db3->query("select * from handover_account where handover_id='$id'");
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
    
    public function get_school_detail($id){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT spd.*, spd_contact.email, spd_contact.contact_no FROM `spd` join spd_contact on spd_contact.sid=spd.id WHERE spd.id='$id' and spd_contact.main=1");
        return $query->result();
    }
    
    public function get_clientbypc($project_code){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("select * from client_handover where projectcode='$project_code'");
        return $query->result();
    }
    
    public function get_school_contact($id){
       $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM spd_contact WHERE sid='$id'");
        return $query->result();
    }
    
    public function get_scount($sid,$status){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT count(*) as scont FROM schoollogs WHERE sid='$sid' and status='$status'");
        $date =  $query->result();
        return $date[0]->scont;
    }
    
    public function get_plantaskbytid($tid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("select * from plantask where taskid='$tid'");
        return $query->result();
    }
    
    public function get_taskassign_byid($id){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("select * from task_assign where id='$id'");
        return $query->result();
    }
    
    public function get_snextststus($status){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT name FROM status WHERE ID IN(SELECT ID + 1 FROM status WHERE name='$status')");
        return $query->result();
    }
    
    public function get_ostatus(){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM `status`");
        return $query->result();
    }
    
    public function get_wgdata($id){
         $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM wgdata WHERE sid='$id' ORDER BY filepath DESC LIMIT 6");
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
    
    public function get_rpthisyear($bdid,$uid){
        $query=$this->db->query("SELECT company_master.*, init_call.*,barginmeeting.cid cmpid,tblcallevents.*,barginmeeting.*,user_details.*, tblcallevents.id tid, tblcallevents.cid_id ciid,tblcallevents.user_id userid,init_call.pstadt abc, (SELECT count(id) from tblcallevents WHERE tblcallevents.cid_id=cid and id>tid and mom!='') momc FROM tblcallevents left JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.user_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE tblcallevents.user_id='$bdid' and tblcallevents.mtype='RP' and cast(tblcallevents.updateddate AS DATE)>'2023-04-01' and nextCFID!='0'");
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
    
    
    public function timetomint($input_time){
    $time_parts = explode(":", $input_time);

        if (count($time_parts) === 2) {
            $hours = intval($time_parts[0]);
            $minutes = intval($time_parts[1]);
            $total_minutes = ($hours * 60) + $minutes;
            return$total_minutes;
        } 
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
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE cid_id='$ciid' and cast(updateddate as DATE)>'2023-03-31' ORDER BY tblcallevents.updateddate DESC");
        return $query->result();
    }
    
    public function get_tblcbyidwr($ciid){
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE cid_id='$ciid' and cast(updateddate as DATE)>'2023-03-31' and remarks!='' ORDER BY tblcallevents.id DESC");
        return $query->result();
    }
    
    public function get_tblbyid($ciid){
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE cid_id='$ciid' and nextCFID!=0 and cast(updateddate as DATE)>'2023-03-31' ORDER BY tblcallevents.id DESC");
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
    
    public function get_userbyid($uid){
        $query=$this->db->query("SELECT * FROM user_details where user_id='$uid'");
        return $query->result();
    }
    
    
    
    
    
    public function get_userbyaid($uid){
        $query=$this->db->query("SELECT * FROM user_details WHERE admin_id='$uid' and status='active' and (type_id=3 or type_id=9)");
        return $query->result();
    }
    
    public function get_userbyaids($uid){
        $query=$this->db->query("SELECT * FROM user_details WHERE (admin_id='$uid' or aadmin='$uid') and (type_id=3 or type_id=9)");
        return $query->result();
    }
    
    public function get_userbypst($uid){
        $query=$this->db->query("SELECT * FROM user_details WHERE admin_id='$uid' and (type_id=4 )");
        return $query->result();
    }
    
    
    public function get_userbyaaid($uid){
        $query=$this->db->query("SELECT * FROM user_details where (aadmin='$uid' or badmin='$uid')  and status='active' and (type_id=3 or type_id=9)");
        return $query->result();
    }
    
    public function get_alluserbyaid($uid){
        $query=$this->db->query("SELECT * FROM user_details WHERE admin_id='$uid'");
        return $query->result();
    }
    
    
    
    public function get_pstbyaid($uid){
        $query=$this->db->query("SELECT * FROM user_details WHERE admin_id='$uid' and status='active' and (type_id=4 or type_id=9)");
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
    
    
    public function add_rremarkpnp($cid,$remark){
        $query=$this->db->query("update init_call set pnpremark='$remark' WHERE cmpid_id='$cid'");
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
            $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active' and mainbd!='' and mainbd is not null");
            return $query->result();
        }elseif($utid==9){
            $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where (user_details.aadmin='$uid' or user_details.badmin='$uid') and user_details.status='active' and mainbd!='' and mainbd is not null");
            return $query->result();
        }else{
            $query=$this->db->query("SELECT cmpid_id FROM init_call where mainbd='$uid' or apst='$uid'");
            return $query->result();
        }
        
    }
    
    
    public function get_psttcom($uid){
        $userd = $this->Menu_model->get_userbyid($uid);
        $utid = $userd[0]->type_id;
        if($utid==2){
            $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.admin_id='$uid' and user_details.status='active' and mainbd!='' and mainbd is not null");
            return $query->result();
        }else{
            $query=$this->db->query("SELECT cmpid_id FROM init_call where apst='$uid'");
            return $query->result();
        }
        
    }
    
    
    
    
    
    public function get_newbdtcom($sdate,$edate,$uid){
        $userd = $this->Menu_model->get_userbyid($uid);
        $utid = $userd[0]->type_id;
        
        if($utid==2){
            $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active' and cast(createddate as DATE) between '$sdate' and '$edate' and mainbd is not null");
            return $query->result();
        }else{
            $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN company_master on company_master.id=init_call.cmpid_id where (mainbd='$uid' or apst='$uid') and createddate between '$sdate' and '$edate'");
            return $query->result();
        }
        
    }
    
    
    
    public function get_newbdtcoms($sdate,$edate,$uid){
        $userd = $this->Menu_model->get_userbyid($uid);
        $utid = $userd[0]->type_id;
        
        if($utid==2){
            $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active' and cast(createddate as DATE) between '$sdate' and '$edate' and mainbd is not null");
            return $query->result();
        }else{
            $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN company_master on company_master.id=init_call.cmpid_id where (mainbd='$uid' or apst='$uid') and createddate between '$sdate' and '$edate'");
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
    
    public function new_pstttsw($uid,$tdate,$ab){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='4' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='4' and user_details.status='active'";}
        
        
            $query=$this->db->query("SELECT COUNT(CASE WHEN status_id='1' THEN 1 END) a,
                COUNT(CASE WHEN status_id='8' THEN 1 END) b,
                COUNT(CASE WHEN status_id='2' THEN 1 END) c,COUNT(CASE WHEN status_id='3' THEN 1 END) d,
                COUNT(CASE WHEN status_id='4' THEN 1 END) e,COUNT(CASE WHEN status_id='5' THEN 1 END) f,
                COUNT(CASE WHEN status_id='10' THEN 1 END) j,COUNT(CASE WHEN status_id='11' THEN 1 END) k,
                COUNT(CASE WHEN status_id='6' THEN 1 END) g,COUNT(CASE WHEN status_id='12' THEN 1 END) l,
                COUNT(CASE WHEN status_id='9' THEN 1 END) i,COUNT(CASE WHEN status_id='13' THEN 1 END) m,
                COUNT(CASE WHEN status_id='7' THEN 1 END) h FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and cast(updateddate as DATE)='$tdate' and nextCFID!='0' ");
                            return $query->result(); 
    }
    
    
    public function new_ttsw($uid,$tdate,$ab){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        
        
            $query=$this->db->query("SELECT COUNT(CASE WHEN status_id='1' THEN 1 END) a,
                COUNT(CASE WHEN status_id='8' THEN 1 END) b,
                COUNT(CASE WHEN status_id='2' THEN 1 END) c,COUNT(CASE WHEN status_id='3' THEN 1 END) d,
                COUNT(CASE WHEN status_id='4' THEN 1 END) e,COUNT(CASE WHEN status_id='5' THEN 1 END) f,
                COUNT(CASE WHEN status_id='10' THEN 1 END) j,COUNT(CASE WHEN status_id='11' THEN 1 END) k,
                COUNT(CASE WHEN status_id='6' THEN 1 END) g,COUNT(CASE WHEN status_id='12' THEN 1 END) l,
                COUNT(CASE WHEN status_id='9' THEN 1 END) i,COUNT(CASE WHEN status_id='13' THEN 1 END) m,
                COUNT(CASE WHEN status_id='7' THEN 1 END) h FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and cast(updateddate as DATE)='$tdate' and nextCFID!='0'");
                            return $query->result(); 
    }

    public function new_ttswGroup($uid,$sd,$ed,$ab){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        
        
            $query=$this->db->query("SELECT COUNT(CASE WHEN status_id='1' THEN 1 END) a,
                COUNT(CASE WHEN status_id='8' THEN 1 END) b,
                COUNT(CASE WHEN status_id='2' THEN 1 END) c,COUNT(CASE WHEN status_id='3' THEN 1 END) d,
                COUNT(CASE WHEN status_id='4' THEN 1 END) e,COUNT(CASE WHEN status_id='5' THEN 1 END) f,
                COUNT(CASE WHEN status_id='10' THEN 1 END) j,COUNT(CASE WHEN status_id='11' THEN 1 END) k,
                COUNT(CASE WHEN status_id='6' THEN 1 END) g,COUNT(CASE WHEN status_id='12' THEN 1 END) l,
                COUNT(CASE WHEN status_id='9' THEN 1 END) i,COUNT(CASE WHEN status_id='13' THEN 1 END) m,
                COUNT(CASE WHEN status_id='7' THEN 1 END) h FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and nextCFID!='0'");
                            return $query->result(); 
    }
    
    
    public function new_ttswplan($uid,$tdate,$ab){
        
        
            $query=$this->db->query("SELECT COUNT(CASE WHEN status_id='1' THEN 1 END) a,
COUNT(CASE WHEN status_id='8' THEN 1 END) b,
COUNT(CASE WHEN status_id='2' THEN 1 END) c,COUNT(CASE WHEN status_id='3' THEN 1 END) d,
COUNT(CASE WHEN status_id='4' THEN 1 END) e,COUNT(CASE WHEN status_id='5' THEN 1 END) f,
COUNT(CASE WHEN status_id='10' THEN 1 END) j,COUNT(CASE WHEN status_id='11' THEN 1 END) k,
COUNT(CASE WHEN status_id='6' THEN 1 END) g,COUNT(CASE WHEN status_id='12' THEN 1 END) l,
COUNT(CASE WHEN status_id='9' THEN 1 END) i,COUNT(CASE WHEN status_id='13' THEN 1 END) m,
COUNT(CASE WHEN status_id='7' THEN 1 END) h FROM tblcallevents WHERE user_id='$uid' and cast(appointmentdatetime as DATE)='$tdate'");
            return $query->result(); 
    }
    
    
    public function new_pstttswplan($uid,$tdate,$ab){
            $query=$this->db->query("SELECT COUNT(CASE WHEN status_id='1' THEN 1 END) a,
COUNT(CASE WHEN status_id='8' THEN 1 END) b,
COUNT(CASE WHEN status_id='2' THEN 1 END) c,COUNT(CASE WHEN status_id='3' THEN 1 END) d,
COUNT(CASE WHEN status_id='4' THEN 1 END) e,COUNT(CASE WHEN status_id='5' THEN 1 END) f,
COUNT(CASE WHEN status_id='10' THEN 1 END) j,COUNT(CASE WHEN status_id='11' THEN 1 END) k,
COUNT(CASE WHEN status_id='6' THEN 1 END) g,COUNT(CASE WHEN status_id='12' THEN 1 END) l,
COUNT(CASE WHEN status_id='9' THEN 1 END) i,COUNT(CASE WHEN status_id='13' THEN 1 END) m,
COUNT(CASE WHEN status_id='7' THEN 1 END) h FROM tblcallevents WHERE user_id='$uid' and cast(appointmentdatetime as DATE)='$tdate'");
            return $query->result(); 
    }
    
    
    
    public function get_MeetingCheck($uid,$tdate){
        
        $query=$this->db->query("SELECT tblcallevents.id tid, barginmeeting.cid cmpid,tblcallevents.*,barginmeeting.*,user_details.*, tblcallevents.id tid, tblcallevents.cid_id cid, (SELECT count(id) from tblcallevents WHERE tblcallevents.cid_id=cid and id>tid and mom!='') momc FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE cast(tblcallevents.updateddate AS DATE)='$tdate' and user_details.admin_id='$uid' and nextCFID!='0'");
        return $query->result();
        
    }
    
    
    
    
    
    
    
    
    
    
    public function get_pbdtcom($uid){
        $query=$this->db->query("SELECT cmpid_id FROM init_call where apst='$uid' ");
        return $query->result();
    }
    
    
    public function get_htiprocess(){
        $query=$this->db->query("SELECT * FROM mtask");
        return $query->result();
    }
    
    public function get_htiprocessbytid($tid){
        $query=$this->db->query("SELECT * FROM mtask where tid='$tid'");
        return $query->result();
    }
    
    public function get_htimsprocess($tid){
        $query=$this->db->query("SELECT * FROM mstask where mtid='$tid'");
        return $query->result();
    }
    
    
    
    
    public function get_cmpbybd($uid){
        $query=$this->db->query("SELECT company_master.* FROM init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE mainbd='$uid'");
        return $query->result();
    }
    
    
    public function get_mbdc($uid){
        $query=$this->db->query("SELECT COUNT(*) a,COUNT(CASE WHEN cstatus=1 THEN cstatus END) b,COUNT(CASE WHEN cstatus=2 THEN cstatus END) c,COUNT(CASE WHEN cstatus=3 THEN cstatus END) d,COUNT(CASE WHEN cstatus=4 THEN cstatus END) e,COUNT(CASE WHEN cstatus=5 THEN cstatus END) f,COUNT(CASE WHEN cstatus=6 THEN cstatus END) g,COUNT(CASE WHEN cstatus=7 THEN cstatus END) h,COUNT(CASE WHEN cstatus=8 THEN cstatus END) i,COUNT(CASE WHEN cstatus=9 THEN cstatus END) j,COUNT(CASE WHEN cstatus=10 THEN cstatus END) k,COUNT(CASE WHEN cstatus=11 THEN cstatus END) l,COUNT(CASE WHEN focus_funnel='yes' THEN focus_funnel END) m,COUNT(CASE WHEN upsell_client='yes' THEN upsell_client END) n,COUNT(CASE WHEN cstatus=12 THEN cstatus END) o,COUNT(CASE WHEN cstatus=13 THEN cstatus END) p, COUNT(CASE WHEN keycompany='yes' THEN keycompany END) q, COUNT(CASE WHEN pkclient='yes' THEN pkclient END) r, COUNT(CASE WHEN priorityc='yes' THEN priorityc END) s,COUNT(CASE WHEN topspender='yes' THEN 1 END) t,COUNT(CASE WHEN upsell_client='yes' THEN 1 END) u,COUNT(CASE WHEN focus_funnel='yes' THEN 1 END) v,COUNT(CASE WHEN potentialp='yes' and apst is null THEN 1 END) w,COUNT(CASE WHEN potentialp='no' and apst is null THEN 1 END) x  , COUNT(CASE WHEN potentialp is Null and apst is null THEN 1 END) y , COUNT(CASE WHEN mainbd ='$uid' and apst is null THEN 1 END) z,  COUNT(CASE WHEN mainbd ='$uid' and potentialppst ='yes' THEN 1 END) za, COUNT(CASE WHEN mainbd ='$uid' and potentialppst ='no' THEN 1 END) zb,  COUNT(CASE WHEN mainbd ='$uid' and apst is not Null and potentialppst is null THEN 1 END) zc, COUNT(CASE WHEN mainbd ='$uid' and apst is not Null THEN 1 END) zd   FROM init_call WHERE mainbd='$uid'");
        return $query->result();
    }
    
    
    public function get_mbdcpst($uid){
        $query=$this->db->query("SELECT COUNT(*) a,COUNT(CASE WHEN cstatus=1 THEN cstatus END) b,COUNT(CASE WHEN cstatus=2 THEN cstatus END) c,COUNT(CASE WHEN cstatus=3 THEN cstatus END) d,COUNT(CASE WHEN cstatus=4 THEN cstatus END) e,COUNT(CASE WHEN cstatus=5 THEN cstatus END) f,COUNT(CASE WHEN cstatus=6 THEN cstatus END) g,COUNT(CASE WHEN cstatus=7 THEN cstatus END) h,COUNT(CASE WHEN cstatus=8 THEN cstatus END) i,COUNT(CASE WHEN cstatus=9 THEN cstatus END) j,COUNT(CASE WHEN cstatus=10 THEN cstatus END) k,COUNT(CASE WHEN cstatus=11 THEN cstatus END) l,COUNT(CASE WHEN focus_funnel='yes' THEN focus_funnel END) m,COUNT(CASE WHEN upsell_client='yes' THEN upsell_client END) n,COUNT(CASE WHEN cstatus=12 THEN cstatus END) o,COUNT(CASE WHEN cstatus=13 THEN cstatus END) p, COUNT(CASE WHEN keycompany='yes' THEN keycompany END) q, COUNT(CASE WHEN pkclient='yes' THEN pkclient END) r, COUNT(CASE WHEN priorityc='yes' THEN priorityc END) s,COUNT(CASE WHEN topspender='yes' THEN 1 END) t,COUNT(CASE WHEN upsell_client='yes' THEN 1 END) u,COUNT(CASE WHEN focus_funnel='yes' THEN 1 END) v,COUNT(CASE WHEN potentialp='yes' THEN 1 END) w,COUNT(CASE WHEN potentialp='no' THEN 1 END) x,COUNT(CASE WHEN potentialppst='yes' THEN 1 END) y,COUNT(CASE WHEN potentialppst='no' THEN 1 END) z,COUNT(CASE WHEN fffyqtr='FY' THEN 1 END) za,COUNT(CASE WHEN fffyqtr='QTR' THEN 1 END) zb , COUNT(CASE WHEN potentialppst is Null THEN 1 END) zc FROM init_call WHERE mainbd!='' and mainbd is not null and apst='$uid'");
        return $query->result();
    }
    
    
    public function get_bdpstteammbdc($uid){
        $query=$this->db->query("SELECT COUNT(*) a,COUNT(CASE WHEN cstatus=1 THEN cstatus END) b,COUNT(CASE WHEN cstatus=2 THEN cstatus END) c,COUNT(CASE WHEN cstatus=3 THEN cstatus END) d,COUNT(CASE WHEN cstatus=4 THEN cstatus END) e,COUNT(CASE WHEN cstatus=5 THEN cstatus END) f,COUNT(CASE WHEN cstatus=6 THEN cstatus END) g,COUNT(CASE WHEN cstatus=7 THEN cstatus END) h,COUNT(CASE WHEN cstatus=8 THEN cstatus END) i,COUNT(CASE WHEN cstatus=9 THEN cstatus END) j,COUNT(CASE WHEN cstatus=10 THEN cstatus END) k,COUNT(CASE WHEN cstatus=11 THEN cstatus END) l,COUNT(CASE WHEN focus_funnel='yes' THEN focus_funnel END) m,COUNT(CASE WHEN upsell_client='yes' THEN upsell_client END) n,COUNT(CASE WHEN cstatus=12 THEN cstatus END) o,COUNT(CASE WHEN cstatus=13 THEN cstatus END) p, COUNT(CASE WHEN keycompany='yes' THEN keycompany END) q, COUNT(CASE WHEN pkclient='yes' THEN pkclient END) r, COUNT(CASE WHEN priorityc='yes' THEN priorityc END) s,COUNT(CASE WHEN topspender='yes' THEN 1 END) t,COUNT(CASE WHEN upsell_client='yes' THEN 1 END) u,COUNT(CASE WHEN focus_funnel='yes' THEN 1 END) v FROM init_call WHERE apst='$uid'");
        return $query->result();
    }
    
    
    public function get_mbpstc($uid){
        $query=$this->db->query("SELECT COUNT(*) a,COUNT(CASE WHEN cstatus=1 THEN cstatus END) b,COUNT(CASE WHEN cstatus=2 THEN cstatus END) c,COUNT(CASE WHEN cstatus=3 THEN cstatus END) d,COUNT(CASE WHEN cstatus=4 THEN cstatus END) e,COUNT(CASE WHEN cstatus=5 THEN cstatus END) f,COUNT(CASE WHEN cstatus=6 THEN cstatus END) g,COUNT(CASE WHEN cstatus=7 THEN cstatus END) h,COUNT(CASE WHEN cstatus=8 THEN cstatus END) i,COUNT(CASE WHEN cstatus=9 THEN cstatus END) j,COUNT(CASE WHEN cstatus=10 THEN cstatus END) k,COUNT(CASE WHEN cstatus=11 THEN cstatus END) l,COUNT(CASE WHEN focus_funnel='yes' THEN focus_funnel END) m, COUNT(CASE WHEN upsell_client='yes' THEN upsell_client END) n,COUNT(CASE WHEN exbd is not null THEN upsell_client END) o FROM init_call WHERE mainbd='$uid' and apst is not null");
        return $query->result();
    }
    
    
    public function get_mbdcbyaid($uid){
        $query=$this->db->query("SELECT COUNT(*) a,COUNT(CASE WHEN cstatus=1 THEN cstatus END) b,COUNT(CASE WHEN cstatus=2 THEN cstatus END) c,COUNT(CASE WHEN cstatus=3 THEN cstatus END) d,COUNT(CASE WHEN cstatus=4 THEN cstatus END) e,COUNT(CASE WHEN cstatus=5 THEN cstatus END) f,COUNT(CASE WHEN cstatus=6 THEN cstatus END) g,COUNT(CASE WHEN cstatus=7 THEN cstatus END) h,COUNT(CASE WHEN cstatus=8 THEN cstatus END) i,COUNT(CASE WHEN cstatus=9 THEN cstatus END) j,COUNT(CASE WHEN cstatus=10 THEN cstatus END) k,COUNT(CASE WHEN cstatus=11 THEN cstatus END) l,COUNT(CASE WHEN focus_funnel='yes' THEN focus_funnel END) m, COUNT(CASE WHEN upsell_client='yes' THEN upsell_client END) n,COUNT(CASE WHEN exbd is not null THEN upsell_client END) o,COUNT(CASE WHEN company_master.partnerType_id='17' THEN company_master.partnerType_id END) p,COUNT(CASE WHEN potentialp='yes' THEN potentialp END) q,COUNT(CASE WHEN potentialppst='yes' THEN potentialppst END) r,COUNT(CASE WHEN fffyqtr='QTR' THEN fffyqtr END) s,COUNT(CASE WHEN fffyqtr='FY' THEN fffyqtr END) t,COUNT(CASE WHEN potentialp='no' THEN potentialp END) u,COUNT(CASE WHEN potentialp='' THEN potentialp END) v FROM init_call LEFT JOIN user_details ON user_details.user_id=mainbd LEFT JOIN company_master on company_master.id=init_call.cmpid_id WHERE user_details.admin_id='$uid' and user_details.status='active' ");
        return $query->result();
    }
    
    public function get_mbdcbyaaid($uid){
        $query=$this->db->query("SELECT COUNT(*) a,COUNT(CASE WHEN cstatus=1 THEN cstatus END) b,COUNT(CASE WHEN cstatus=2 THEN cstatus END) c,COUNT(CASE WHEN cstatus=3 THEN cstatus END) d,COUNT(CASE WHEN cstatus=4 THEN cstatus END) e,COUNT(CASE WHEN cstatus=5 THEN cstatus END) f,COUNT(CASE WHEN cstatus=6 THEN cstatus END) g,COUNT(CASE WHEN cstatus=7 THEN cstatus END) h,COUNT(CASE WHEN cstatus=8 THEN cstatus END) i,COUNT(CASE WHEN cstatus=9 THEN cstatus END) j,COUNT(CASE WHEN cstatus=10 THEN cstatus END) k,COUNT(CASE WHEN cstatus=11 THEN cstatus END) l,COUNT(CASE WHEN focus_funnel='yes' THEN focus_funnel END) m, COUNT(CASE WHEN upsell_client='yes' THEN upsell_client END) n,COUNT(CASE WHEN exbd is not null THEN upsell_client END) o FROM init_call LEFT JOIN user_details ON user_details.user_id=mainbd WHERE (user_details.aadmin='$uid' or user_details.badmin='$uid') and user_details.status='active' ");
        return $query->result();
    }
    
    
    public function get_mbdcbycat($uid){
        $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!=''  and mainbd is not null and focus_funnel='yes'");
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
        if($uid=='100103' || $uid=='100149' || $uid=='100114' || $uid=='100115'){$uid=$uid;}
        $userd = $this->Menu_model->get_userbyid($uid);
        $utid = $userd[0]->type_id;
        
        if($utid==2){
            
            if($sid==14){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!=''  and mainbd is not null and focus_funnel='yes'");
            }elseif($sid==15){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and upsell_client='yes'");
            }elseif($sid==16){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and keycompany='yes'");
            }elseif($sid==17){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and pkclient='yes'");
            }elseif($sid==18){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and priorityc='yes'");
            }elseif($sid==20){
                $query=$this->db->query("SELECT cmpid_id FROM `init_call` LEFT JOIN user_details on user_details.user_id=init_call.mainbd LEFT JOIN company_master on company_master.id=init_call.cmpid_id WHERE user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and company_master.partnerType_id='17'");
            }elseif($sid==21){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and potentialp='yes'");
            }elseif($sid==22){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and potentialppst='yes'");
            }elseif($sid==23){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and fffyqtr='QTR'");
            }elseif($sid==24){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and fffyqtr='FY'");
            }elseif($sid==25){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and potentialp='no'");
            }elseif($sid==26){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and potentialp=''");
            }else{
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and init_call.cstatus='$sid'");
            }
            return $query->result();
            
        }else{
            if($sid==14){
            $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where (mainbd= '$uid' or apst='$uid') and focus_funnel='yes'");
            }elseif($sid==15){
                $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where (mainbd= '$uid' or apst='$uid') and upsell_client='yes'");
            }elseif($sid==16){
                $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where (mainbd= '$uid' or apst='$uid') and keycompany='yes'");
            }elseif($sid==17){
                $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where (mainbd= '$uid' or apst='$uid') and pkclient='yes'");
            }elseif($sid==18){
                $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where (mainbd= '$uid' or apst='$uid') and priorityc='yes'");
            }elseif($sid==20){
                $query=$this->db->query("SELECT cmpid_id FROM `init_call` LEFT JOIN user_details on user_details.user_id=init_call.mainbd LEFT JOIN company_master on company_master.id=init_call.cmpid_id WHERE user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and company_master.partnerType_id='17'");
            }elseif($sid==21){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.user_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and potentialp='yes' and apst is Null");
            }elseif($sid==22){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.user_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and potentialppst='yes'");
            }elseif($sid==23){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.user_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and fffyqtr='QTR'");
            }elseif($sid==24){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.user_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and fffyqtr='FY'");
            }elseif($sid==25){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.user_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and potentialp='no'and apst is Null");
            }elseif($sid==26){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.user_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and potentialp=''");
            }elseif($sid==27){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.user_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and mainbd ='$uid' and apst is null");
            }elseif($sid==28){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.user_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and mainbd ='$uid' and potentialppst ='yes'");
            }elseif($sid==29){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.user_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and mainbd ='$uid' and potentialppst ='no'");
            }elseif($sid==32){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.user_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and mainbd ='$uid' and apst is not Null and potentialppst is null");
            }elseif($sid==31){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.user_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and potentialp is Null and apst is null ");
            }elseif($sid==30){
                $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where mainbd='$uid' and apst is null");
            }elseif($sid==33){
                $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where mainbd ='$uid' and apst is not Null");			
            }else{
            $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where (mainbd= '$uid' or apst='$uid') and cstatus='$sid'");
            }
            return $query->result();
        } 
    }
    
    
    public function get_pstcombyst($uid,$sid){
        if($uid=='100103' || $uid=='100149' || $uid=='100114' || $uid=='100115'){$uid=$uid;}
        $userd = $this->Menu_model->get_userbyid($uid);
        $utid = $userd[0]->type_id;
        
        if($utid==2){
            if($sid==14){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!=''  and mainbd is not null and focus_funnel='yes'");
            }elseif($sid==15){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and upsell_client='yes'");
            }elseif($sid==16){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and keycompany='yes'");
            }elseif($sid==17){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and pkclient='yes'");
            }elseif($sid==18){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and priorityc='yes'");
            }elseif($sid==20){
                $query=$this->db->query("SELECT cmpid_id FROM `init_call` LEFT JOIN user_details on user_details.user_id=init_call.apst LEFT JOIN company_master on company_master.id=init_call.cmpid_id WHERE user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and company_master.partnerType_id='17'");
            }elseif($sid==21){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and potentialp='yes'");
            }elseif($sid==22){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and potentialppst='yes'");
            }elseif($sid==23){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and fffyqtr='QTR'");
            }elseif($sid==24){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and fffyqtr='FY'");
            }elseif($sid==25){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and potentialp='no'");
            }elseif($sid==26){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and potentialp=''");
            }elseif($sid==27){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and potentialppst='no'");
            }else{
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and init_call.cstatus='$sid'");
            }
            return $query->result();
            
        }else{
            if($sid==14){
            $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where  apst='$uid' and focus_funnel='yes'");
            }elseif($sid==15){
                $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where apst='$uid' and upsell_client='yes'");
            }elseif($sid==16){
                $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where  apst='$uid' and keycompany='yes'");
            }elseif($sid==17){
                $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where  apst='$uid' and pkclient='yes'");
            }elseif($sid==18){
                $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where apst='$uid' and priorityc='yes'");
            }elseif($sid==20){
                $query=$this->db->query("SELECT cmpid_id FROM `init_call` LEFT JOIN user_details on user_details.user_id=init_call.apst LEFT JOIN company_master on company_master.id=init_call.cmpid_id WHERE user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and company_master.partnerType_id='17'");
            }elseif($sid==21){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.user_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and potentialp='yes'");
            }elseif($sid==22){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.user_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and potentialppst='yes'");
            }elseif($sid==23){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.user_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and fffyqtr='QTR'");
            }elseif($sid==24){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.user_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and fffyqtr='FY'");
            }elseif($sid==25){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.user_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and potentialp='no'");
            }elseif($sid==26){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.user_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and potentialp=''");
            }elseif($sid==27){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.user_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and potentialppst='no'");
            }elseif($sid==31){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.user_id='$uid' and user_details.status='active' and mainbd!=''  and mainbd is not null and potentialppst is Null");				
            }elseif($sid==30){
                $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where apst='$uid'");
            }else{
            $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where apst='$uid' and cstatus='$sid'");
            }
            return $query->result();
        } 
    }
    
    public function Potential_Partner($cid){
        $query=$this->db->query("update init_call set potentialp='yes' where cmpid_id='$cid'");
    }
    public function Non_Potential_Partner($cid){
        $query=$this->db->query("update init_call set potentialp='no' where cmpid_id='$cid'");
    }
    
    public function Potential_Partnerpst($cid){
        $query=$this->db->query("update init_call set potentialppst='yes' where cmpid_id='$cid'");
    }
    
    public function nonPotential_Partnerpst($cid){
        $query=$this->db->query("update init_call set potentialppst='no' where cmpid_id='$cid'");
    }
    
    public function FY_ff($cid){
        $query=$this->db->query("update init_call set fffyqtr='FY' where cmpid_id='$cid'");
    }
    
    public function QTR_ff($cid){
        $query=$this->db->query("update init_call set fffyqtr='QTR' where cmpid_id='$cid'");
    }
    
    
    
    
    
    
    public function get_pstcombystatus1($uid,$sid){
        if($uid=='100103' || $uid=='100149' || $uid=='100114' || $uid=='100115'){$uid=$uid;}
        $userd = $this->Menu_model->get_userbyid($uid);
        $utid = $userd[0]->type_id;
        
        if($utid==2){
            
            $query=$this->db->query("SELECT user_details.name pstname, count(*) cont FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.apst where user_details.admin_id='$uid' and user_details.type_id='4' and user_details.status='active' and mainbd!='' and mainbd is not null and  apst is not null and apst!='' and init_call.cstatus='$sid' GROUP BY user_details.user_id,user_details.name");
            return $query->result(); 
        }
    }
    
    
    
    
    
    
    
    
    
    
    public function get_pstcombystatus($uid,$sid){
        if($uid=='100103' || $uid=='100149' || $uid=='100114' || $uid=='100115'){$uid=$uid;}
        $userd = $this->Menu_model->get_userbyid($uid);
        $utid = $userd[0]->type_id;
        
        if($utid==2){
            
            if($sid==14){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!=''  and mainbd is not null and focus_funnel='yes' and apst is not null and apst!=''");
            }elseif($sid==15){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and upsell_client='yes' and apst is not null and apst!=''");
            }elseif($sid==16){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and keycompany='yes' and apst is not null and apst!=''");
            }elseif($sid==17){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and keycompany='yes' and apst is not null and pkclient='yes'");
            }elseif($sid==18){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and keycompany='yes' and apst is not null and priorityc='yes'");
            }elseif($sid==19){
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and keycompany='yes' and apst is not null and priorityc='yes' and cstatus='3'");
            }else{
                $query=$this->db->query("SELECT cmpid_id FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd where user_details.admin_id='$uid' and user_details.status='active'  and mainbd!='' and mainbd is not null and init_call.cstatus='$sid' and apst is not null and apst!=''");
            }
            return $query->result();
            
        }else{
            if($sid==14){
            $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where mainbd= '$uid' and focus_funnel='yes'  and apst is not null and apst!=''");
            }elseif($sid==15){
                $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where mainbd= '$uid' and upsell_client='yes'  and apst is not null and apst!=''");
            }elseif($sid==16){
                $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where mainbd= '$uid' and keycompany='yes' and apst is not null and apst!=''");
            }else{
            $query=$this->db->query("SELECT DISTINCT cmpid_id FROM init_call where mainbd= '$uid' and cstatus='$sid' and apst is not null and apst!=''");
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
            
            $data3 = $this->Menu_model->get_cdbyid($bcid);
            $compname = $data3[0]->compname;
            
            
            $query=$this->db->query("SELECT MAX(id) mid FROM `tblcallevents` WHERE cid_id='$inid'");
            $data1 = $query->result();
            $ltid = $data1[0]->mid;
            
            $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, purpose_achieved, fwd_date, actontaken, nextaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type,plan) VALUES ('$ltid', '0','no', '$bmdate', 'no', 'Will Collect Data by RP Meeting', 'no','$bmdate','4','$uid','$inid','66','Will Collect Data by RP Meeting','$cstatus','$uid','$bmdate','$bmdate','updated',1)");
            $ntid = $this->db->insert_id();
            $query=$this->db->query("update tblcallevents set nextCFID='$ntid' WHERE id='$ltid'");
            
            $this->db->query("INSERT INTO barginmeeting(storedt,user_id,cid,company_name) VALUES ('$bmdate','$uid','$bcid','$compname')");
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
            
            $this->db->query("INSERT INTO barginmeeting(storedt,user_id,cid,company_name) VALUES ('$bmdate','$uid','$bcid','Unknown')");
            $bmid = $this->db->insert_id();
           
           $query=$this->db->query("update barginmeeting set cid='$cid',ccid='$ccid',inid='$inid',tid='$ntid' WHERE id='$bmid'");
        }
        
        
        
    }
    
    
    public function get_pendingt($uid,$tdate){
        $query=$this->db->query("SELECT * FROM `tblcallevents` WHERE user_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0");
        return $query->result();
    }
    
    
    public function get_totalpt($uid,$tdate){
        $query=$this->db->query("SELECT tblcallevents.*,status.name,action.name aname,status.color,status.clr,init_call.cstatus cstatus,(SELECT name from status WHERE id=cstatus) csname, (select init_call.cmpid_id from init_call WHERE id=tblcallevents.cid_id) as cmpid_id,(select company_master.compname from company_master WHERE id=cmpid_id) as compname, (select company_master.id from company_master WHERE id=cmpid_id) as cid FROM tblcallevents left JOIN action ON action.id=tblcallevents.actiontype_id left JOIN init_call ON init_call.id=tblcallevents.cid_id left JOIN status ON status.id=init_call.cstatus WHERE user_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID='0' and plan!='1'");
        return $query->result();
    }
    
    public function get_totalt($uid,$tdate){
        $query=$this->db->query("SELECT tblcallevents.*,status.name,action.name aname,status.color,status.clr,init_call.cstatus cstatus,(SELECT name from status WHERE id=cstatus) csname, (select init_call.cmpid_id from init_call WHERE id=tblcallevents.cid_id) as cmpid_id,(select company_master.compname from company_master WHERE id=cmpid_id) as compname, (select company_master.id from company_master WHERE id=cmpid_id) as cid FROM tblcallevents left JOIN action ON action.id=tblcallevents.actiontype_id left JOIN init_call ON init_call.id=tblcallevents.cid_id left JOIN status ON status.id=init_call.cstatus WHERE user_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID='0'");
        return $query->result();
    }
    
    public function get_ttdone($uid,$tdate){
        $query=$this->db->query("SELECT tblcallevents.*,status.name,action.name aname,status.color,(select init_call.cmpid_id from init_call WHERE id=tblcallevents.cid_id) as cmpid_id,(select company_master.compname from company_master WHERE id=cmpid_id) as compname, (select company_master.id from company_master WHERE id=cmpid_id) as cid FROM tblcallevents left JOIN status ON status.id=tblcallevents.status_id left JOIN action ON action.id=tblcallevents.actiontype_id WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID!=0");
        return $query->result();
    }
    
    public function get_tptd($uid,$tdate){
        $query=$this->db->query("SELECT count(*) ab,COUNT(CASE WHEN actiontype_id=1 THEN actiontype_id END) a,COUNT(CASE WHEN actiontype_id=2 THEN actiontype_id END) b,COUNT(CASE WHEN actiontype_id=3 THEN actiontype_id END) c,COUNT(CASE WHEN actiontype_id=4 THEN actiontype_id END) d,COUNT(CASE WHEN actiontype_id=5 THEN actiontype_id END) e,COUNT(CASE WHEN actiontype_id=6 THEN actiontype_id END) f,COUNT(CASE WHEN actiontype_id=7 THEN actiontype_id END) g,COUNT(CASE WHEN actiontype_id=8 THEN actiontype_id END) h,COUNT(CASE WHEN actiontype_id=9 THEN actiontype_id END) i,COUNT(CASE WHEN actiontype_id=10 THEN actiontype_id END) j,COUNT(CASE WHEN actiontype_id=11 THEN actiontype_id END) k,COUNT(CASE WHEN actiontype_id=12 THEN actiontype_id END) l,COUNT(CASE WHEN actiontype_id=13 THEN actiontype_id END) m FROM tblcallevents WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=0 and autotask=1");
        return $query->result();
    }
    
    public function get_tptsd($uid,$tdate){
        $query=$this->db->query("SELECT count(*) ab,COUNT(CASE WHEN status_id=1 THEN status_id END) a,COUNT(CASE WHEN status_id=8 THEN status_id END) b,COUNT(CASE WHEN status_id=2 THEN status_id END) c,COUNT(CASE WHEN status_id=3 THEN status_id END) d,COUNT(CASE WHEN status_id=4 THEN status_id END) e,COUNT(CASE WHEN status_id=5 THEN status_id END) f,COUNT(CASE WHEN status_id=10 THEN status_id END) g,COUNT(CASE WHEN status_id=11 THEN status_id END) h,COUNT(CASE WHEN status_id=6 THEN status_id END) i,COUNT(CASE WHEN status_id=9 THEN status_id END) j,COUNT(CASE WHEN status_id=7 THEN status_id END) k FROM tblcallevents WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=0 and autotask=1");
        return $query->result();
    }
    
    
    public function get_atptd($uid,$tdate){
        $query=$this->db->query("SELECT count(*) ab,COUNT(CASE WHEN actiontype_id=1 THEN actiontype_id END) a,COUNT(CASE WHEN actiontype_id=2 THEN actiontype_id END) b,COUNT(CASE WHEN actiontype_id=3 THEN actiontype_id END) c,COUNT(CASE WHEN actiontype_id=4 THEN actiontype_id END) d,COUNT(CASE WHEN actiontype_id=5 THEN actiontype_id END) e,COUNT(CASE WHEN actiontype_id=6 THEN actiontype_id END) f,COUNT(CASE WHEN actiontype_id=7 THEN actiontype_id END) g,COUNT(CASE WHEN actiontype_id=8 THEN actiontype_id END) h,COUNT(CASE WHEN actiontype_id=9 THEN actiontype_id END) i,COUNT(CASE WHEN actiontype_id=10 THEN actiontype_id END) j,COUNT(CASE WHEN actiontype_id=11 THEN actiontype_id END) k,COUNT(CASE WHEN actiontype_id=12 THEN actiontype_id END) l,COUNT(CASE WHEN actiontype_id=13 THEN actiontype_id END) m FROM tblcallevents WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID='0' and plan='0' and autotask='0'");
        return $query->result();
    }
    
    public function get_atptsd($uid,$tdate){
        $query=$this->db->query("SELECT count(*) ab,COUNT(CASE WHEN status_id=1 THEN status_id END) a,COUNT(CASE WHEN status_id=8 THEN status_id END) b,COUNT(CASE WHEN status_id=2 THEN status_id END) c,COUNT(CASE WHEN status_id=3 THEN status_id END) d,COUNT(CASE WHEN status_id=4 THEN status_id END) e,COUNT(CASE WHEN status_id=5 THEN status_id END) f,COUNT(CASE WHEN status_id=10 THEN status_id END) g,COUNT(CASE WHEN status_id=11 THEN status_id END) h,COUNT(CASE WHEN status_id=6 THEN status_id END) i,COUNT(CASE WHEN status_id=9 THEN status_id END) j,COUNT(CASE WHEN status_id=7 THEN status_id END) k FROM tblcallevents WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID='0' and plan='0' and autotask='0'");
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
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        $query=$this->db->query("SELECT count(*) ab, count(case when plan=1 then plan END) abc, count(case when status_id=1 and plan=1 then status_id END) a, count(case when status_id=2 and plan=1 then status_id END) b, count(case when status_id=3 and plan=1 then status_id END) c, count(case when status_id=4 and plan=1 then status_id END) d, count(case when status_id=5 and plan=1 then status_id END) e, count(case when status_id=6 and plan=1 then status_id END) f, count(case when status_id=7 and plan=1 then status_id END) g, count(case when status_id=8 and plan=1 then status_id END) h, count(case when status_id=9 and plan=1 then status_id END) i, count(case when status_id=10 and plan=1 then status_id END) j, count(case when status_id=11 and plan=1 then status_id END) k,count(case when actontaken='no' and plan=1 then status_id END) l,count(case when actontaken='yes' and plan=1 then status_id END) m,count(case when purpose_achieved='no' and plan=1 then status_id END) n,count(case when purpose_achieved='yes' and plan=1 then status_id END) o  FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and cast(updateddate as DATE)='$tdate' and nextCFID!=0 and actiontype_id=1");
        return $query->result();
    }
    
    
    
    public function get_pstcc($uid,$tdate,$ab){
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        $query=$this->db->query("SELECT tblcallevents.id as tid,tblcallevents.cid_id as cid, (SELECT min(id) FROM tblcallevents where id>tid and cid_id=cid) ntid, (SELECT status_id FROM tblcallevents where id=ntid) nsid, tblcallevents.status_id as sid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and cast(updateddate as DATE)='$tdate' and nextCFID!=0 and plan=1 and actiontype_id=1");
        return $query->result();
    }
    
    
    public function get_pstccon($stat,$uid,$pstid,$sd,$ed,$ab){
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        
        if($stat==0){
        $query=$this->db->query("SELECT appointmentdatetime,initiateddt,updateddate,tblcallevents.user_id as tuid, tblcallevents.id as tid,tblcallevents.cid_id as cid, (SELECT min(id) FROM tblcallevents where id>tid and cid_id=cid) ntid, (SELECT status_id FROM tblcallevents where id=ntid) nsid, tblcallevents.status_id as sid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and nextCFID!=0 and plan=1 and actiontype_id=1 and cast(updateddate as DATE) between '$sd' and '$ed'");
        }else{
            $query=$this->db->query("SELECT appointmentdatetime,initiateddt,updateddate,tblcallevents.user_id as tuid, tblcallevents.id as tid,tblcallevents.cid_id as cid, (SELECT min(id) FROM tblcallevents where id>tid and cid_id=cid) ntid, (SELECT status_id FROM tblcallevents where id=ntid) nsid, tblcallevents.status_id as sid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and nextCFID!=0 and plan=1 and actiontype_id=1 and cast(updateddate as DATE) between '$sd' and '$ed' and status_id='$stat'");
        }
        return $query->result();
    }
    
    
    
    public function get_pstallreview($uid,$pstid,$sd,$ed,$ab){
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        
        $query=$this->db->query("SELECT appointmentdatetime,initiateddt,updateddate,tblcallevents.user_id as tuid, tblcallevents.id as tid,tblcallevents.cid_id as cid, (SELECT min(id) FROM tblcallevents where id>tid and cid_id=cid) ntid, (SELECT status_id FROM tblcallevents where id=ntid) nsid, tblcallevents.status_id as sid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and nextCFID!=0 and plan=1 and actiontype_id=8 and cast(updateddate as DATE) between '$sd' and '$ed'");
        return $query->result();
    }
    
    
    public function get_pstccd($uid,$tdate,$ab){
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        $query=$this->db->query("SELECT tblcallevents.*, (select name FROM user_details where user_id=assignedto_id) as name, (select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.id tid, tblcallevents.cid_id cid, tblcallevents.status_id sid, (SELECT min(id) FROM tblcallevents where id>tid and cid_id=cid) ntid, (SELECT status_id FROM tblcallevents where id=ntid) nsid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE nextCFID!=0 and $text and cast(updateddate as DATE)='$tdate'");
        return $query->result();
    }
    
    
    public function get_mom($ciid,$tid){
        
        $query=$this->db->query("SELECT mom from tblcallevents WHERE mom!='' and actiontype_id=6 and id>'$tid' and cid_id='$ciid'");
        return $query->result();
        
    } 

    public function get_momNewPst($ciid,$tid){
        
        $query=$this->db->query("SELECT count(*) as countmom from tblcallevents WHERE mom!='' and actiontype_id=6 and cid_id='$ciid'");
        return $query->result();
        
    }
    
    
    
    
    public function get_mombtdate($sdate,$edate,$uid,$ab){
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        $query=$this->db->query("SELECT (SELECT company_master.compname FROM company_master WHERE company_master.id=init_call.cmpid_id) cname, user_details.name, tblcallevents.mom, tblcallevents.updateddate, (SELECT name FROM user_details WHERE user_details.user_id=init_call.apst) pst FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id WHERE mom!='' and actiontype_id=6 and cast(appointmentdatetime as DATE) between '$sdate' and '$edate' and $text");
        return $query->result();
    }
    
    
    
    public function get_plannersreport($uid,$sdate,$edate,$stid){
        $ab=1;
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        
        $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE cast(updateddate as DATE) BETWEEN '$sdate' and '$edate' and status_id='$stid' and tblcallevents.user_id='$uid'");
        
        
        
        return $query->result();
    }
    
    
    
    public function get_plannersareport($uid,$sdate,$edate,$acid){
        $ab=1;
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        
        
        $query=$this->db->query("SELECT *,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE cast(updateddate as DATE) BETWEEN '$sdate' and '$edate' and actiontype_id='$acid' and tblcallevents.user_id='$uid'");
        
        
        return $query->result();
    }
    
    
    
    
    public function get_pstcallcon($code,$atid,$uid,$tdate,$ab){
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='4' and user_details.status='active'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
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
        if($atid==15){
            $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE actiontype_id=1 and purpose_achieved='yes' and cast(appointmentdatetime AS DATE)='$tdate' and updation_data_type='updated' and nextCFID!=0 and plan=1 and $text");
        }
        
        
        return $query->result();
    }
    
    
    
    public function get_psttaskdetail($sid,$uid,$tdate,$ab){
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        $query=$this->db->query("SELECT * FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and cast(appointmentdatetime as DATE)='$tdate' and plan=1 and nextCFID!=0 and status_id=1");
        return $query->result();
    }
    
    
    public function get_pstcalldetail($code,$uid,$tdate,$ab){
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
      $query=$this->db->query("SELECT * FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and cast(appointmentdatetime as DATE)='$tdate' and plan=1 and nextCFID!=0");
      return $query->result();
    }
    
    
    public function get_ttbytimed($uid,$tdate,$t1,$t2){
        $query=$this->db->query("SELECT count(*) ab,COUNT(CASE WHEN actiontype_id=1 THEN actiontype_id END) a,COUNT(CASE WHEN actiontype_id=2 THEN actiontype_id END) b,COUNT(CASE WHEN actiontype_id=3 THEN actiontype_id END) c,COUNT(CASE WHEN actiontype_id=4 THEN actiontype_id END) d,COUNT(CASE WHEN actiontype_id=5 THEN actiontype_id END) e,COUNT(CASE WHEN actiontype_id=6 THEN actiontype_id END) f,COUNT(CASE WHEN actiontype_id=7 THEN actiontype_id END) g,COUNT(CASE WHEN actiontype_id=8 THEN actiontype_id END) h,COUNT(CASE WHEN actiontype_id=9 THEN actiontype_id END) i,COUNT(CASE WHEN actiontype_id=10 THEN actiontype_id END) j,COUNT(CASE WHEN actiontype_id=11 THEN actiontype_id END) k,COUNT(CASE WHEN actiontype_id=12 THEN actiontype_id END) l,COUNT(CASE WHEN actiontype_id=13 THEN actiontype_id END) m from tblcallevents WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '$t1' and '$t2'");
        return $query->result();
    }
    
    
    
    public function get_tttbytimedaction($uid,$tdate){
        $query=$this->db->query("SELECT action.name acname,action.clr aclr,COUNT(*) cont from tblcallevents LEFT JOIN action ON action.id=tblcallevents.actiontype_id WHERE user_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 GROUP BY action.name,action.clr ORDER BY `acname` ASC");
        return $query->result();
    }
    
    
    public function get_tttbytimedstatus($uid,$tdate){
        $query=$this->db->query("SELECT status.name stname,status.clr sclr,COUNT(*) cont from tblcallevents LEFT JOIN status ON status.id=tblcallevents.status_id WHERE user_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and plan=1  GROUP BY status.name,status.clr ORDER BY `stname` ASC");
        return $query->result();
    }
    
    public function get_ttbytimedaction($uid,$tdate,$t1,$t2){
        $query=$this->db->query("SELECT action.name acname,action.clr aclr,COUNT(*) cont from tblcallevents LEFT JOIN action ON action.id=tblcallevents.actiontype_id WHERE user_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '$t1' and '$t2' GROUP BY action.name,action.clr ORDER BY `acname` ASC");
        return $query->result();
    }
    
    public function get_ttbytimedstatus($uid,$tdate,$t1,$t2){
        $query=$this->db->query("SELECT status.name stname,status.clr sclr,COUNT(*) cont from tblcallevents LEFT JOIN status ON status.id=tblcallevents.status_id WHERE user_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and cast(appointmentdatetime AS TIME) BETWEEN '$t1' and '$t2' GROUP BY status.name,status.clr ORDER BY `stname` ASC");
        return $query->result();
    }
    
    public function get_ttbytimedc($uid,$tdate,$t1,$t2){
        $query=$this->db->query("SELECT count(*) ab,COUNT(CASE WHEN actiontype_id=1 THEN actiontype_id END) a,COUNT(CASE WHEN actiontype_id=2 THEN actiontype_id END) b,COUNT(CASE WHEN actiontype_id=3 THEN actiontype_id END) c,COUNT(CASE WHEN actiontype_id=4 THEN actiontype_id END) d,COUNT(CASE WHEN actiontype_id=5 THEN actiontype_id END) e,COUNT(CASE WHEN actiontype_id=6 THEN actiontype_id END) f,COUNT(CASE WHEN actiontype_id=7 THEN actiontype_id END) g,COUNT(CASE WHEN actiontype_id=8 THEN actiontype_id END) h,COUNT(CASE WHEN actiontype_id=9 THEN actiontype_id END) i,COUNT(CASE WHEN actiontype_id=10 THEN actiontype_id END) j,COUNT(CASE WHEN actiontype_id=11 THEN actiontype_id END) k,COUNT(CASE WHEN actiontype_id=12 THEN actiontype_id END) l,COUNT(CASE WHEN actiontype_id=13 THEN actiontype_id END) m from tblcallevents WHERE assignedto_id='$uid' and cast(updateddate AS DATE)='$tdate' and nextCFID!=0 and plan=1 and cast(updateddate AS TIME) BETWEEN '$t1' and '$t2'");
        return $query->result();
    }
    
    public function get_ttbyd($uid,$tdate){
        $query=$this->db->query("SELECT count(*) ab,COUNT(CASE WHEN actiontype_id=1 THEN actiontype_id END) a,COUNT(CASE WHEN actiontype_id=2 THEN actiontype_id END) b,COUNT(CASE WHEN actiontype_id=3 THEN actiontype_id END) c,COUNT(CASE WHEN actiontype_id=4 THEN actiontype_id END) d,COUNT(CASE WHEN actiontype_id=5 THEN actiontype_id END) e,COUNT(CASE WHEN actiontype_id=6 THEN actiontype_id END) f,COUNT(CASE WHEN actiontype_id=7 THEN actiontype_id END) g,COUNT(CASE WHEN actiontype_id=8 THEN actiontype_id END) h,COUNT(CASE WHEN actiontype_id=9 THEN actiontype_id END) i,COUNT(CASE WHEN actiontype_id=10 THEN actiontype_id END) j,COUNT(CASE WHEN actiontype_id=11 THEN actiontype_id END) k,COUNT(CASE WHEN actiontype_id=12 THEN actiontype_id END) l,COUNT(CASE WHEN actiontype_id=13 THEN actiontype_id END) m from tblcallevents WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and nextCFID=0 and plan=1");
        
        return $query->result();
    }
    
    public function get_ctpending($cid){
        $query=$this->db->query("SELECT count(*) a from tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id WHERE tblcallevents.nextCFID=0 and init_call.cmpid_id='$cid'");
        return $query->result();
    }
    
    public function get_ttbydc($uid,$tdate){
        $query=$this->db->query("SELECT count(*) ab,COUNT(CASE WHEN actiontype_id=1 THEN actiontype_id END) a,COUNT(CASE WHEN actiontype_id=2 THEN actiontype_id END) b,COUNT(CASE WHEN actiontype_id=3 THEN actiontype_id END) c,COUNT(CASE WHEN actiontype_id=4 THEN actiontype_id END) d,COUNT(CASE WHEN actiontype_id=5 THEN actiontype_id END) e,COUNT(CASE WHEN actiontype_id=6 THEN actiontype_id END) f,COUNT(CASE WHEN actiontype_id=7 THEN actiontype_id END) g,COUNT(CASE WHEN actiontype_id=8 THEN actiontype_id END) h,COUNT(CASE WHEN actiontype_id=9 THEN actiontype_id END) i,COUNT(CASE WHEN actiontype_id=10 THEN actiontype_id END) j,COUNT(CASE WHEN actiontype_id=11 THEN actiontype_id END) k,COUNT(CASE WHEN actiontype_id=12 THEN actiontype_id END) l,COUNT(CASE WHEN actiontype_id=13 THEN actiontype_id END) m from tblcallevents WHERE assignedto_id='$uid' and cast(updateddate AS DATE)='$tdate' and nextCFID!=0");
        return $query->result();
    }
    
    
    public function get_totaltd($uid,$tdate){
        $query=$this->db->query("SELECT COUNT(*) a,count(CASE WHEN nextCFID=0 THEN nextCFID end) b,count(CASE WHEN nextCFID!=0 THEN nextCFID end) c, count(CASE WHEN actiontype_id=1 THEN actiontype_id end) d,count(CASE WHEN actiontype_id=1 and nextCFID=0 THEN actiontype_id end) e,count(CASE WHEN actiontype_id=2 THEN actiontype_id end) f,count(CASE WHEN actiontype_id=2 and nextCFID=0 THEN actiontype_id end) g,count(CASE WHEN actiontype_id=3 THEN actiontype_id end) h,count(CASE WHEN actiontype_id=3 and nextCFID=0 THEN actiontype_id end) i,count(CASE WHEN actiontype_id=4 THEN actiontype_id end) j,count(CASE WHEN actiontype_id=4 and nextCFID=0 THEN actiontype_id end) k,count(CASE WHEN actiontype_id=5 THEN actiontype_id end) l,count(CASE WHEN actiontype_id=5 and nextCFID=0 THEN actiontype_id end) m,count(CASE WHEN actiontype_id=6 THEN actiontype_id end) n,count(CASE WHEN actiontype_id=6 and nextCFID=0 THEN actiontype_id end) o,count(CASE WHEN actiontype_id=7 THEN actiontype_id end) p,count(CASE WHEN actiontype_id=7 and nextCFID=0 THEN actiontype_id end) q,count(CASE WHEN actiontype_id=10 THEN actiontype_id end) na,count(CASE WHEN actiontype_id=10 and nextCFID=0 THEN actiontype_id end) nb,count(CASE WHEN actiontype_id=11 THEN actiontype_id end) nc,count(CASE WHEN actiontype_id=11 and nextCFID=0 THEN actiontype_id end) nd,count(CASE WHEN actiontype_id=12 THEN actiontype_id end) ne,count(CASE WHEN actiontype_id=12 and nextCFID=0 THEN actiontype_id end) nf,count(CASE WHEN actontaken='yes' and nextCFID!=0 THEN actiontype_id end) r,count(CASE WHEN actontaken='no' and nextCFID!=0 THEN actiontype_id end) s,count(CASE WHEN purpose_achieved='yes' and nextCFID!=0 THEN actiontype_id end) t,count(CASE WHEN purpose_achieved='no' and nextCFID!=0 THEN actiontype_id end) u FROM tblcallevents WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and plan=1");
        return $query->result();
    }
    
    public function get_admintteamtd($uid,$tdate){
        $query=$this->db->query("SELECT COUNT(*) a,count(CASE WHEN nextCFID=0 THEN nextCFID end) b,count(CASE WHEN nextCFID!=0 THEN nextCFID end) c, count(CASE WHEN actiontype_id=1 THEN actiontype_id end) d,count(CASE WHEN actiontype_id=1 and nextCFID=0 THEN actiontype_id end) e,count(CASE WHEN actiontype_id=2 THEN actiontype_id end) f,count(CASE WHEN actiontype_id=2 and nextCFID=0 THEN actiontype_id end) g,count(CASE WHEN actiontype_id=3 THEN actiontype_id end) h,count(CASE WHEN actiontype_id=3 and nextCFID=0 THEN actiontype_id end) i,count(CASE WHEN actiontype_id=4 THEN actiontype_id end) j,count(CASE WHEN actiontype_id=4 and nextCFID=0 THEN actiontype_id end) k,count(CASE WHEN actiontype_id=5 THEN actiontype_id end) l,count(CASE WHEN actiontype_id=5 and nextCFID=0 THEN actiontype_id end) m,count(CASE WHEN actiontype_id=6 THEN actiontype_id end) n,count(CASE WHEN actiontype_id=6 and nextCFID=0 THEN actiontype_id end) o,count(CASE WHEN actiontype_id=7 THEN actiontype_id end) p,count(CASE WHEN actiontype_id=7 and nextCFID=0 THEN actiontype_id end) q,count(CASE WHEN actiontype_id=10 THEN actiontype_id end) na,count(CASE WHEN actiontype_id=10 and nextCFID=0 THEN actiontype_id end) nb,count(CASE WHEN actiontype_id=11 THEN actiontype_id end) nc,count(CASE WHEN actiontype_id=11 and nextCFID=0 THEN actiontype_id end) nd,count(CASE WHEN actiontype_id=12 THEN actiontype_id end) ne,count(CASE WHEN actiontype_id=12 and nextCFID=0 THEN actiontype_id end) nf,count(CASE WHEN actontaken='yes' and nextCFID!=0 THEN actiontype_id end) r,count(CASE WHEN actontaken='no' and nextCFID!=0 THEN actiontype_id end) s,count(CASE WHEN purpose_achieved='yes' and nextCFID!=0 THEN actiontype_id end) t,count(CASE WHEN purpose_achieved='no' and nextCFID!=0 THEN actiontype_id end) u FROM tblcallevents WHERE assignedto_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and plan=1");
        return $query->result();
    }
    
    
    public function get_psttteamtd($uid,$tdate){
        $query=$this->db->query("SELECT COUNT(*) a,count(CASE WHEN nextCFID=0 THEN nextCFID end) b,count(CASE WHEN nextCFID!=0 THEN nextCFID end) c, count(CASE WHEN actiontype_id=1 THEN actiontype_id end) d,count(CASE WHEN actiontype_id=1 and nextCFID=0 THEN actiontype_id end) e,count(CASE WHEN actiontype_id=2 THEN actiontype_id end) f,count(CASE WHEN actiontype_id=2 and nextCFID=0 THEN actiontype_id end) g,count(CASE WHEN actiontype_id=3 THEN actiontype_id end) h,count(CASE WHEN actiontype_id=3 and nextCFID=0 THEN actiontype_id end) i,count(CASE WHEN actiontype_id=4 THEN actiontype_id end) j,count(CASE WHEN actiontype_id=4 and nextCFID=0 THEN actiontype_id end) k,count(CASE WHEN actiontype_id=5 THEN actiontype_id end) l,count(CASE WHEN actiontype_id=5 and nextCFID=0 THEN actiontype_id end) m,count(CASE WHEN actiontype_id=6 THEN actiontype_id end) n,count(CASE WHEN actiontype_id=6 and nextCFID=0 THEN actiontype_id end) o,count(CASE WHEN actiontype_id=7 THEN actiontype_id end) p,count(CASE WHEN actiontype_id=7 and nextCFID=0 THEN actiontype_id end) q,count(CASE WHEN actiontype_id=10 THEN actiontype_id end) na,count(CASE WHEN actiontype_id=10 and nextCFID=0 THEN actiontype_id end) nb,count(CASE WHEN actiontype_id=11 THEN actiontype_id end) nc,count(CASE WHEN actiontype_id=11 and nextCFID=0 THEN actiontype_id end) nd,count(CASE WHEN actiontype_id=12 THEN actiontype_id end) ne,count(CASE WHEN actiontype_id=12 and nextCFID=0 THEN actiontype_id end) nf,count(CASE WHEN actontaken='yes' and nextCFID!=0 THEN actiontype_id end) r,count(CASE WHEN actontaken='no' and nextCFID!=0 THEN actiontype_id end) s,count(CASE WHEN purpose_achieved='yes' and nextCFID!=0 THEN actiontype_id end) t,count(CASE WHEN purpose_achieved='no' and nextCFID!=0 THEN actiontype_id end) u FROM tblcallevents tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and user_details.admin_id='$uid' and (user_details.type_id='4' or user_details.type_id='9')");
        return $query->result();
    }
    
    
    public function get_tmeetdbyaid($uid,$tdate){
        $query=$this->db->query("SELECT count(*) ab, count(case when actiontype_id=3 then actiontype_id END) a, count(case when actiontype_id=4 then actiontype_id END) b, count(case when actiontype_id=4 and priority='yes' then actiontype_id END) c, count(case when actiontype_id=4 and priority='no' then actiontype_id END) d, count(case when actiontype_id=4 and mtype='rp' then actiontype_id END) e, count(case when actiontype_id=4 and priority='nrp' then actiontype_id END) f, count(case when actiontype_id=4 and pstassign='no' then actiontype_id END) g, count(case when actiontype_id=4 and pstassign='yes' then actiontype_id END) h FROM tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.admin_id='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and nextCFID!=0");
        return $query->result();
    }
    
    
    public function get_tbmeetdbyaid($uid,$tdate){
        
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        
        
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
    
    
    public function get_tbmd($code,$uid,$bdid,$sdate,$edate){
        if($uid=='100103' || $uid=='100149' || $uid=='100114' || $uid=='100115'){$uid='45';}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and (user_details.type_id='3' or user_details.type_id='9') and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.user_id='$uid'";}
        if($code==1){
        $query=$this->db->query("SELECT barginmeeting.cid cmpid,tblcallevents.*,barginmeeting.*,user_details.*, tblcallevents.id tid, tblcallevents.cid_id cid, (SELECT count(id) from tblcallevents WHERE tblcallevents.cid_id=cid and id>tid and mom!='') momc FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.user_id WHERE $text and cast(barginmeeting.startm AS DATE) BETWEEN '$sdate' AND '$edate' and nextCFID!='0'");
        }elseif($code==2){
        $query=$this->db->query("SELECT barginmeeting.cid cmpid,tblcallevents.*,barginmeeting.*,user_details.*, tblcallevents.id tid, tblcallevents.cid_id cid, (SELECT count(id) from tblcallevents WHERE tblcallevents.cid_id=cid and id>tid and mom!='') momc FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.user_id WHERE $text and cast(barginmeeting.startm AS DATE) BETWEEN '$sdate' AND '$edate' and barginmeeting.status='Pending'");
        }elseif($code==3){
        $query=$this->db->query("SELECT barginmeeting.cid cmpid,tblcallevents.*,barginmeeting.*,user_details.*, tblcallevents.id tid, tblcallevents.cid_id cid, (SELECT count(id) from tblcallevents WHERE tblcallevents.cid_id=cid and id>tid and mom!='') momc FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.user_id WHERE $text and cast(barginmeeting.startm AS DATE) BETWEEN '$sdate' AND '$edate' and barginmeeting.status='Start'");
        }elseif($code==4){
        $query=$this->db->query("SELECT barginmeeting.cid cmpid,tblcallevents.*,barginmeeting.*,user_details.*, tblcallevents.id tid, tblcallevents.cid_id cid, (SELECT count(id) from tblcallevents WHERE tblcallevents.cid_id=cid and id>tid and mom!='') momc FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.user_id WHERE $text and cast(barginmeeting.startm AS DATE) BETWEEN '$sdate' AND '$edate'");
        }elseif($code==5){
        $query=$this->db->query("SELECT barginmeeting.cid cmpid,tblcallevents.*,barginmeeting.*,user_details.*, tblcallevents.id tid, tblcallevents.cid_id cid, (SELECT count(id) from tblcallevents WHERE tblcallevents.cid_id=cid and id>tid and mom!='') momc FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.user_id WHERE $text and tblcallevents.mtype='RP' and cast(barginmeeting.startm AS DATE) between '$sdate' and '$edate' and nextCFID!='0'");
        }elseif($code==6){
        $query=$this->db->query("SELECT barginmeeting.cid cmpid,tblcallevents.*,barginmeeting.*,user_details.*, tblcallevents.id tid, tblcallevents.cid_id cid, (SELECT count(id) from tblcallevents WHERE tblcallevents.cid_id=cid and id>tid and mom!='') momc FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.user_id WHERE $text and cast(barginmeeting.startm AS DATE) BETWEEN '$sdate' AND '$edate' and tblcallevents.mtype='NO RP' and nextCFID!='0'");
        }elseif($code==7){
        $query=$this->db->query("SELECT barginmeeting.cid cmpid,tblcallevents.*,barginmeeting.*,user_details.*, tblcallevents.id tid, tblcallevents.cid_id cid, (SELECT count(id) from tblcallevents WHERE tblcallevents.cid_id=cid and id>tid and mom!='') momc FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.user_id WHERE $text and cast(barginmeeting.startm AS DATE) BETWEEN '$sdate' AND '$edate' and tblcallevents.priority='yes' and nextCFID!='0'");
        }elseif($code==8){
        $query=$this->db->query("SELECT barginmeeting.cid cmpid,tblcallevents.*,barginmeeting.*,user_details.*, tblcallevents.id tid, tblcallevents.cid_id cid, (SELECT count(id) from tblcallevents WHERE tblcallevents.cid_id=cid and id>tid and mom!='') momc FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.user_id WHERE $text and cast(barginmeeting.startm AS DATE) BETWEEN '$sdate' AND '$edate' and tblcallevents.priority='no'  and nextCFID!='0'");
        }
        else{
            $query=$this->db->query("SELECT tblcallevents.*,barginmeeting.*,user_details.*, tblcallevents.id tid, tblcallevents.cid_id cid, (SELECT count(id) from tblcallevents WHERE tblcallevents.cid_id=cid and id>tid and mom!='') momc FROM tblcallevents LEFT JOIN barginmeeting on barginmeeting.tid=tblcallevents.id LEFT JOIN user_details on user_details.user_id=tblcallevents.user_id WHERE $text and cast(barginmeeting.startm AS DATE) BETWEEN '$sdate' AND '$edate' and nextCFID!='0'");
        }
        return $query->result();
    }
    
    public function get_checkrpbytid($tid){
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE id='$tid' and mtype='RP'");
        return $query->result();
    }
    
    public function get_meetfr($tid,$cid){
        $query=$this->db->query("SELECT count(*) cont FROM barginmeeting WHERE inid = '$cid' AND (SELECT MIN(tid) FROM barginmeeting LEFT JOIN tblcallevents ON tblcallevents.id=barginmeeting.tid where tblcallevents.mtype='RP' and cast(tblcallevents.updateddate as DATE)>'2023-03-31' and inid = '$cid')<'$tid'");
        return $query->result();
    }
    
    public function get_TaskCheckaypy($bduid,$tdate){
        $query=$this->db->query("SELECT *,tblcallevents.id tid,action.id aname,s1.name sname, s2.name nsname,company_master.id cmpid,company_master.compname, action.name aname1 FROM tblcallevents LEFT JOIN init_call init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id left join action on action.id=tblcallevents.actiontype_id 
        left join status s1 on s1.id=tblcallevents.status_id
        left join status s2 on s2.id=tblcallevents.nstatus_id
        WHERE user_id='$bduid' and cast(updateddate as DATE)='$tdate' and actontaken='yes' and purpose_achieved='yes' and rremark is null");
        return $query->result();
    }
    
    
    public function get_TaskCheckaypn($bduid,$tdate){
       $query=$this->db->query("SELECT *,tblcallevents.id tid,action.id aname,s1.name sname, s2.name nsname,company_master.id cmpid,company_master.compname, action.name aname1 FROM tblcallevents LEFT JOIN init_call init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id left join action on action.id=tblcallevents.actiontype_id 
        left join status s1 on s1.id=tblcallevents.status_id
        left join status s2 on s2.id=tblcallevents.nstatus_id
        WHERE user_id='$bduid' and cast(updateddate as DATE)='$tdate' and actontaken='yes' and purpose_achieved='no' and rremark is null");
        return $query->result();
    }
    
    
    public function get_TaskCheckanpn($bduid,$tdate){
        $query=$this->db->query("SELECT *,tblcallevents.id tid,action.id aname,s1.name sname, s2.name nsname,company_master.id cmpid,company_master.compname, action.name aname1 FROM tblcallevents LEFT JOIN init_call init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id left join action on action.id=tblcallevents.actiontype_id 
        left join status s1 on s1.id=tblcallevents.status_id
        left join status s2 on s2.id=tblcallevents.nstatus_id
        WHERE user_id='$bduid' and cast(updateddate as DATE)='$tdate' and actontaken='no' and rremark is null");
        return $query->result();
    }
    
    
    public function check_daytask($rat,$rremark,$taskid,$uuid){
        $date = date('Y-m-d H:i:s');
        $query=$this->db->query("update tblcallevents set rtime='$date', star='$rat',rremark='$rremark',rby='$uuid' WHERE id='$taskid'");
        
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
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
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
    
    
    public function get_tteaamtd($uid,$tdate){
        $query=$this->db->query("SELECT COUNT(*) a,count(CASE WHEN nextCFID=0 THEN nextCFID end) b,count(CASE WHEN nextCFID!=0 THEN nextCFID end) c, count(CASE WHEN actiontype_id=1 THEN actiontype_id end) d,count(CASE WHEN actiontype_id=1 and nextCFID=0 THEN actiontype_id end) e,count(CASE WHEN actiontype_id=2 THEN actiontype_id end) f,count(CASE WHEN actiontype_id=2 and nextCFID=0 THEN actiontype_id end) g,count(CASE WHEN actiontype_id=3 THEN actiontype_id end) h,count(CASE WHEN actiontype_id=3 and nextCFID=0 THEN actiontype_id end) i,count(CASE WHEN actiontype_id=4 THEN actiontype_id end) j,count(CASE WHEN actiontype_id=4 and nextCFID=0 THEN actiontype_id end) k,count(CASE WHEN actiontype_id=5 THEN actiontype_id end) l,count(CASE WHEN actiontype_id=5 and nextCFID=0 THEN actiontype_id end) m,count(CASE WHEN actiontype_id=6 THEN actiontype_id end) n,count(CASE WHEN actiontype_id=6 and nextCFID=0 THEN actiontype_id end) o,count(CASE WHEN actiontype_id=7 THEN actiontype_id end) p,count(CASE WHEN actiontype_id=7 and nextCFID=0 THEN actiontype_id end) q,count(CASE WHEN actontaken='yes' and nextCFID!=0 THEN actiontype_id end) r,count(CASE WHEN actontaken='no' and nextCFID!=0 THEN actiontype_id end) s,count(CASE WHEN purpose_achieved='yes' and nextCFID!=0 THEN actiontype_id end) t,count(CASE WHEN purpose_achieved='no' and nextCFID!=0 THEN actiontype_id end) u FROM tblcallevents LEFT JOIN user_details on user_details.user_id=tblcallevents.assignedto_id WHERE user_details.aadmin='$uid' and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and user_details.type_id=3");
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
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        
        
        $query=$this->db->query("SELECT COUNT(case when lstatus=1 then lstatus END) a,COUNT(case when lstatus=8 then lstatus END) b,COUNT(case when lstatus=2 then lstatus END) c,COUNT(case when lstatus=3 then lstatus END) d,COUNT(case when lstatus=4 then lstatus END) e,COUNT(case when lstatus=5 then lstatus END) f,COUNT(case when lstatus=6 then lstatus END) g,COUNT(case when lstatus=7 then lstatus END) h,COUNT(case when lstatus=9 then lstatus END) i,COUNT(case when lstatus=10 then lstatus END) j,COUNT(case when lstatus=11 then lstatus END) k,COUNT(case when lstatus=12 then lstatus END) l,COUNT(case when lstatus=13 then lstatus END) m FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(appointmentdatetime AS DATE)='$tdate' and plan=1 and nextCFID!=0");
            return $query->result();
    }

    public function get_ttswGroup($uid,$sd,$ed,$ab){
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        
        
        $query=$this->db->query("SELECT COUNT(case when lstatus=1 then lstatus END) a,COUNT(case when lstatus=8 then lstatus END) b,COUNT(case when lstatus=2 then lstatus END) c,COUNT(case when lstatus=3 then lstatus END) d,COUNT(case when lstatus=4 then lstatus END) e,COUNT(case when lstatus=5 then lstatus END) f,COUNT(case when lstatus=6 then lstatus END) g,COUNT(case when lstatus=7 then lstatus END) h,COUNT(case when lstatus=9 then lstatus END) i,COUNT(case when lstatus=10 then lstatus END) j,COUNT(case when lstatus=11 then lstatus END) k,COUNT(case when lstatus=12 then lstatus END) l,COUNT(case when lstatus=13 then lstatus END) m FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(appointmentdatetime AS DATE) BETWEEN '$sd' and '$ed' and plan=1 and nextCFID!=0");
            return $query->result();
    }
    
    public function get_pstttswd($uid,$tdate,$ab){
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='4' and user_details.status='active'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='4' and user_details.status='active'";}
        
        
        $query=$this->db->query("SELECT COUNT(case when status_id=1 then status_id END) a,COUNT(case when status_id=8 then status_id END) b,COUNT(case when status_id=2 then status_id END) c,COUNT(case when status_id=3 then status_id END) d,COUNT(case when status_id=4 then status_id END) e,COUNT(case when status_id=5 then status_id END) f,COUNT(case when status_id=6 then status_id END) g,COUNT(case when status_id=7 then status_id END) h,COUNT(case when status_id=9 then status_id END) i,COUNT(case when status_id=10 then status_id END) j,COUNT(case when status_id=11 then status_id END) k,COUNT(case when status_id=12 then status_id END) l,COUNT(case when status_id=13 then status_id END) m FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE $text and cast(updateddate AS DATE)='$tdate' and plan='1' and nextCFID!='0'");
            return $query->result();
    }
    
    
    public function get_tswworkdata($id){
    $query=$this->db->query("SELECT (select name FROM user_details where user_id=assignedto_id) as name,(select id FROM init_call where cmpid_id=cid_id) as inid,(select compname FROM company_master where id=inid) as compname, tblcallevents.* FROM tblcallevents WHERE id='$id'");
        return $query->result();
    }
    
    
    
    public function get_AllProposalDetailbyadmin($uid){
        $query=$this->db->query("SELECT *,  (SELECT COUNT(t2.id) FROM tblcallevents t2 WHERE t2.nextCFID!='0' and t2.cid_id=t1.cid_id and t2.updateddate>'2023-03-31') logs FROM proposal LEFT JOIN tblcallevents t1 ON t1.id=proposal.tid LEFT JOIN user_details ON user_details.user_id=proposal.user_id LEFT JOIN init_call ON init_call.id=t1.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE user_details.admin_id='$uid'");
        return $query->result();
    }
    
    public function get_ProposalDetailbydate($uid,$sd,$ed,$aprtype){
        $query=$this->db->query("SELECT *, company_master.id cid, u1.name bdname, u2.name pstname FROM proposal LEFT JOIN tblcallevents t1 ON t1.id=proposal.tid LEFT JOIN user_details u1 ON u1.user_id=proposal.user_id LEFT JOIN init_call ON init_call.id=t1.cid_id LEFT JOIN user_details u2 ON u2.user_id=init_call.apst LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE u1.admin_id='$uid' and cast(updateddate as DATE) between '$sd' and '$ed' and proposal.apr='$aprtype'");
        return $query->result();
    }
    
    
    public function get_AllProposalDetail($uid){
        $query=$this->db->query("SELECT * FROM proposal LEFT JOIN tblcallevents t1 ON t1.id=proposal.tid LEFT JOIN init_call ON init_call.id=t1.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE proposal.user_id='$uid'");
        return $query->result();
    }
    
    public function get_ProposalDetail($tid){
        $query=$this->db->query("SELECT * FROM proposal LEFT JOIN tblcallevents t1 ON t1.id=proposal.tid LEFT JOIN init_call ON init_call.id=t1.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE tid='$tid'");
        return $query->result();
    }
    
    
    
    
    public function get_ttswdetail($sid,$uid,$tdate,$ab){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
    
        $query=$this->db->query("SELECT tblcallevents.* FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(updateddate AS DATE)='$tdate' and plan=1 and nextCFID!=0 and lstatus='$sid'");
        return $query->result();
    }
    
    
   
    
    
    
    public function new_ttswdetail($sid,$uid,$tdate,$ab){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and (user_details.type_id='3' or user_details.type_id='9') and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.user_id='$uid'";}
    
        $query=$this->db->query("SELECT tblcallevents.*,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(updateddate AS DATE)='$tdate' and plan='1' and nextCFID!='0' and tblcallevents.status_id='$sid'");
        return $query->result();
    }

    public function new_ttswdetailGroup($sid,$uid,$sd,$ed,$ab){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and (user_details.type_id='3' or user_details.type_id='9') and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.user_id='$uid'";}
    
        $query=$this->db->query("SELECT tblcallevents.*,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(updateddate AS DATE) BETWEEN '$sd' and '$ed' and plan='1' and nextCFID!='0' and tblcallevents.status_id='$sid'");
        return $query->result();
    }
    
    
    
    
    
    
    
    
    
    public function new_pstttswdetail($sid,$uid,$tdate,$ab){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='4' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==4){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='4' and user_details.status='active'";}
    
        $query=$this->db->query("SELECT tblcallevents.*,tblcallevents.id id, tblcallevents.cid_id cid, (SELECT max(t1.id) FROM tblcallevents t1 WHERE t1.cid_id=cid and t1.nextCFID!='0') ltid FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.assignedto_id WHERE $text and cast(updateddate AS DATE)='$tdate' and plan=1 and nextCFID!=0 and lstatus='$sid'");
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
    
    public function get_tptime($uid){
    $date=date('Y-m-d');
    $query=$this->db->query("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(tptime))) AS tptime FROM tblcallevents WHERE user_id='$uid' and tptime is not null and cast(plandt as DATE)='$date'");
        return $query->result();
    }
    
    
    
    public function get_ccitblall($id){
        $query=$this->db->query("SELECT *,action.name current_action_type FROM tblcallevents left JOIN action ON action.id=tblcallevents.actiontype_id LEFT JOIN init_call on init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE tblcallevents.id='$id'");
        return $query->result();
    }
    
    public function get_alltaskdbyad($code,$atid,$uid,$tdate,$ab){
        if($uid=='100103' || $uid=='100149' || $uid=='100114' || $uid=='100115'){$uid=$uid;}
        
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        
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
    
    public function get_daystarted($uid,$tdate){
        $query=$this->db->query("SELECT * FROM user_day WHERE user_id='$uid' and cast(ustart as DATE)='$tdate' and uclose is null");
        return $query->result();
    }
    
    
    
    public function get_daydbyad($uid,$tdate){
        $query=$this->db->query("SELECT (SELECT count(*) FROM user_details where admin_id='$uid' and status='active' and type_id=3) a, COUNT(*) b, COUNT(case when wffo=1 then wffo end) c, COUNT(case when wffo=2 then wffo end) d, COUNT(case when wffo=3 then wffo end) e FROM user_day LEFT JOIN user_details ON user_details.user_id=user_day.user_id WHERE cast(ustart as DATE)='$tdate' and user_details.admin_id='$uid'");
        return $query->result();
    }
    
    public function get_daydbyaad($uid,$tdate){
        $query=$this->db->query("SELECT (SELECT count(*) FROM user_details where (admin_id='$uid' or aadmin='$uid') and status='active' and type_id=3) a, COUNT(*) b, COUNT(case when wffo=1 then wffo end) c, COUNT(case when wffo=2 then wffo end) d, COUNT(case when wffo=3 then wffo end) e FROM user_day LEFT JOIN user_details ON user_details.user_id=user_day.user_id WHERE cast(ustart as DATE)='$tdate' and user_details.aadmin='$uid'");
        return $query->result();
    }
    
    
    public function get_BDdaystart($admid,$tdate){
        $query=$this->db->query("SELECT *,user_day.user_id udid  FROM user_day LEFT JOIN user_details on user_details.user_id=user_day.user_id WHERE cast(ustart as DATE)='$tdate' and user_details.admin_id='$admid' and scomment is null limit 1");
        return $query->result();
    }
    
    public function check_days($rat1,$rat2,$rat3,$rat4,$sremark,$udid,$que){
        
        $q1 = $que[0].'('.$rat1.' Star)';
        $q2 = $que[1].'('.$rat2.' Star)';
        $q3 = $que[2].'('.$rat3.' Star)';
        $q4 = $que[3].'('.$rat4.' Star)';
        $queans=$q1.','.$q2.','.$q3.','.$q4;
        $this->db->query("update user_day set queans='$queans', scomment='$sremark' where user_id='$udid'");
    }
    
    
    
    public function check_dayc($rat1,$rat2,$rat3,$rat4,$sremark,$udid,$que){
        
        $q1 = $que[0].'('.$rat1.' Star)';
        $q2 = $que[1].'('.$rat2.' Star)';
        $q3 = $que[2].'('.$rat3.' Star)';
        $q4 = $que[3].'('.$rat4.' Star)';
        $queans=$q1.','.$q2.','.$q3.','.$q4;
        $this->db->query("update user_day set queansc='$queans', ccomment='$sremark' where user_id='$udid'");
        
    }
    
    
    
    
    
    public function get_BDdayclose($admid,$tdate){
        $query=$this->db->query("SELECT *,user_day.user_id udid FROM user_day LEFT JOIN user_details on user_details.id-user_day.user_id WHERE cast(uclose as DATE)='$tdate' and uclose is not null and user_details.admin_id='$admid' and scomment is null limit 1");
        return $query->result();
    }
    
    
    public function get_taskstart($uid,$tttype,$tdate){
        $query=$this->db->query("SELECT * FROM othertask WHERE cast(startdt as DATE)='$tdate' and uid='$uid' and tasktype='$tttype'");
        return $query->result();
    }
    
    public function start_dayreview($uid,$ttype){
        date_default_timezone_set("Asia/Kolkata");
        $date = date('Y-m-d H:i:s');
        $query=$this->db->query("insert into othertask (startdt,uid,tasktype) values('$date','$uid','$ttype')");
    }
    
    public function close_dayreview($uid,$ttype){
        date_default_timezone_set("Asia/Kolkata");
        $date = date('Y-m-d H:i:s');
        $query=$this->db->query("update othertask set closedt='$date' and tasktype='$ttype' and startdt is not null");
    }
    
    
    
    
    
    
    
    
    
    public function get_BDdaydbyad($uid,$tdate,$code){
        if($uid=='100103' || $uid=='100149' || $uid=='100114' || $uid=='100115'){$uid='45';}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid'";}
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
        $query=$this->db->query("SELECT * FROM user_details WHERE admin_id='$uid' and status='active' and type_id=3");
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
    
    
        
        
        $query=$this->db->query("SELECT * FROM user_details WHERE admin_id='$uid' and status='active' and type_id=3");
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
            VALUES ('$ntcidd', '0', '', '', '$calldate', 'no', 'Call for Closure', 'NA','NA','no','$calldate','1','$uid','$inid','1','Call for Closure','$cstatus','$uid','$calldate','$calldate','updated')");
            $ntcide =  $this->db->insert_id();
            $query=$this->db->query("update tblcallevents set nextCFID='$ntcide' WHERE id='$ntcidd'");
            
            }elseif($cstatus==6){$this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type) 
                VALUES ('$ntcidd', '0', '', '', '$calldate', 'no', 'Call for Very Positive', 'NA','NA','no','$calldate','1','$uid','$inid','1','Call for Very Positive','$cstatus','$uid','$calldate','$calldate','updated')");
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
        $query=$this->db->query("SELECT * FROM barginmeeting WHERE cid='$cid' ORDER BY barginmeeting.id DESC");
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
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        $query=$this->db->query("SELECT COUNT(CASE WHEN cstatus=7 THEN cstatus END) tcc,COUNT(CASE WHEN cstatus=6 THEN cstatus END) tp,COUNT(CASE WHEN cstatus=9 THEN cstatus END) tvp,SUM(CASE WHEN cstatus=6 THEN noofschools END) pos,SUM(CASE WHEN cstatus=7 THEN noofschools END) ccos,SUM(CASE WHEN cstatus=9 THEN noofschools END) vpos, SUM(CASE WHEN cstatus=6 THEN fbudget END) pfb,SUM(CASE WHEN cstatus=9 THEN fbudget END) vpfb, COUNT(CASE WHEN cstatus=12 THEN cstatus END) tpnap,COUNT(CASE WHEN cstatus=13 THEN cstatus END) tvpnap,SUM(CASE WHEN cstatus=12 THEN noofschools END) pnapos ,SUM(CASE WHEN cstatus=13 THEN noofschools END) vpnapos, SUM(CASE WHEN cstatus=12 THEN fbudget END) pnapfb, SUM(CASE WHEN cstatus=13 THEN fbudget END) vpnapfb, SUM(CASE WHEN cstatus=7 THEN fbudget END) ccfb FROM init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd WHERE $text and init_call.apst is not null and init_call.mainbd is not null");
        return $query->result();
    }
    
    
    public function get_vpd($code,$uid){
        
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "u1.admin_id='$uid' and u1.type_id='3' and u1.status='active'";}
        if($utype==3){$text = "u1.user_id='$uid'";}
        if($utype==9){$text = "u1.aadmin='$uid' and u1.type_id='3' and u1.status='active'";}
        
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
        if($code==14){$txt = "cstatus=7";}
        if($code==13){ 
            $query=$this->db->query("SELECT u1.name uname, u2.name pstname, init_call.id inid,company_master.id cid, init_call.apst pst, init_call.mainbd mbd FROM init_call  LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN user_details u1 on u1.user_id=init_call.mainbd LEFT JOIN user_details u2 on u2.user_id=init_call.apst  WHERE $text and init_call.apst is not null and init_call.mainbd is not null and (init_call.cstatus=6 or init_call.cstatus=9 or init_call.cstatus=7 or init_call.cstatus=12 or init_call.cstatus=13) and apst is not null and mainbd is not null");
            return $query->result();
        }else{
            $query=$this->db->query("SELECT u1.name uname, u2.name pstname, init_call.id inid,company_master.id cid, init_call.apst pst, init_call.mainbd mbd FROM init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN user_details u1 on u1.user_id=init_call.mainbd LEFT JOIN user_details u2 on u2.user_id=init_call.apst WHERE $text and init_call.apst is not null and init_call.mainbd is not null and apst is not null and mainbd is not null and $txt");
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
        
        $query=$this->db->query("SELECT cstatus,init_call.id inid FROM tblcallevents left join init_call on init_call.id=tblcallevents.cid_id WHERE tblcallevents.id='$bmtid'");
        $data = $query->result();
        $cs = $data[0]->cstatus;
        $inid = $data[0]->inid;
        
        date_default_timezone_set("Asia/Kolkata");
        $date = date('Y-m-d H:i:s');
            
            if($type=='RP'){
                if($cs=='1' || $cs=='2' || $cs=='8' || $cs=='10' || $cs=='11'){$status='2';}
                else{$status=$cs;}
                $query=$this->db->query("update barginmeeting set closem='$closem',clatitude='$lat',clongitude='$lng',status='RPClose' WHERE id='$cmid'");
                $query=$this->db->query("UPDATE tblcallevents SET remarks='Meeting Close With RP',nextCFID='$bmtid',updateddate='$date',status_id='$cs',nstatus_id='$status',actontaken='yes',purpose_achieved='yes',updation_data_type='update' WHERE id='$bmtid'");
                $query=$this->db->query("update tblcallevents set priority='$priority',mtype='$type' WHERE id='$bmtid'");
                $query=$this->db->query("update company_master set address='$caddress' WHERE id='$bmcid'");
                $query=$this->db->query("update company_contact_master set contactperson='$cpname',emailid='$cpemail',phoneno='$cpno',designation='$cpdes' WHERE id='$bmccid'");
                $query=$this->db->query("update init_call set lstatus=cstatus,cstatus='$status' WHERE id='$inid'");                                         
                
            }
            if($type=='NO RP'){
                $status=$cs;
                $query=$this->db->query("update barginmeeting set closem='$closem',clatitude='$lat',clongitude='$lng',status='Close' WHERE id='$cmid'");
                $query=$this->db->query("UPDATE tblcallevents SET mtype='$type',remarks='Meeting Close With No RP',nextCFID='$bmtid',updateddate='$date',status_id='$cs',nstatus_id='$status',actontaken='no',purpose_achieved='no',updation_data_type='update' WHERE id='$bmtid'");
            }
            if($type=='Only Got Detail'){
                if($cs=='1'){$status='8';}
                else{$status=$cs;}
                $query=$this->db->query("update barginmeeting set closem='$closem',clatitude='$lat',clongitude='$lng',status='Close' WHERE id='$cmid'");
                $query=$this->db->query("UPDATE tblcallevents SET mtype='$type', remarks='Meeting Close With Only Got Detail',nextCFID='$bmtid',updateddate='$date',status_id='$cs',nstatus_id='$status',actontaken='yes',purpose_achieved='no',updation_data_type='update' WHERE id='$bmtid'");
                $query=$this->db->query("update company_master set address='$caddress' WHERE id='$bmcid'");
                $query=$this->db->query("update company_contact_master set contactperson='$cpname',emailid='$cpemail',phoneno='$cpno',designation='$cpdes' WHERE id='$bmccid'");
                $query=$this->db->query("update init_call set lstatus=cstatus,cstatus='$status' WHERE id='$inid'");
            }
            
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
    
    
    
    
    public function add_plan($pdate,$uid,$ptime,$inid,$ntaction,$ntstatus,$ntppose,$ttype,$tptime){
       $date = $pdate.'T'.$ptime;
       
       
       if($ntaction==3){
            
            $data = $this->Menu_model->get_initbyid($inid);
            $bcid = $data[0]->cmpid_id;
            
            $data2 = $this->Menu_model->get_ccdbyid($bcid);
            $ccid = $data2[0]->id;
            
            $query=$this->db->query("SELECT MAX(id) mid FROM `tblcallevents` WHERE cid_id='$inid'");
            $data1 = $query->result();
            $ltid = $data1[0]->mid;
            
            $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, purpose_achieved, fwd_date, actontaken, nextaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type,plan) VALUES ('$ltid', '0','no', '$date', 'no', '$ntppose', 'no','$date','4','$uid','$inid','66','','1','$uid','$date','$date','updated',1)");
            $ntid = $this->db->insert_id();
            
            $query=$this->db->query("update tblcallevents set nextCFID='$ntid' WHERE id='$ltid'");
            
            $this->db->query("INSERT INTO barginmeeting(storedt,user_id,cid) VALUES ('$date','$uid','$bcid')");
            $bmid = $this->db->insert_id();
            
            $query=$this->db->query("update barginmeeting set ccid='$ccid',inid='$inid',tid='$ntid' WHERE id='$bmid'");
            
            $this->db->query("INSERT INTO notify(uid,type,sms) VALUES ('$uid','1','Bargin Meeting Created form Funnel')");
            
        }else{
           $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type,plan,tptype,tptime) 
           VALUES ('0', '0', '', '', '$date', 'no', '$ntaction', 'NA','NA','no','$date','$ntaction','$uid','$inid','$ntppose','','$ntstatus','$uid','$date','$date','updated','1','$ttype','$tptime')");
           $tblid = $this->db->insert_id();
           if($cs!='1' and $ntaction=='1'){ $this->db->query("INSERT INTO tblcallevents (fwd_date,appointmentdatetime,actiontype_id,assignedto_id,cid_id,purpose_id,status_id,user_id,plan,lastCFID,nextCFID) value('$date','$date',2,'$uid',$inid,22,$ntstatus,'$uid','1','0','0')");}
        }
       
        $query = $this->db->query("SELECT * FROM action WHERE id='$ntaction'");
        $data2 = $query->result();
        $acname = $data2[0]->name;
        $query = $this->db->query("SELECT * FROM init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE init_call.id='$inid'");
        $data3 = $query->result();
        $cname = $data3[0]->compname;
        $cstatus = $data3[0]->cstatus;
        $query = $this->db->query("SELECT * FROM status WHERE id='$cstatus'");
        $data5 = $query->result();
        $sname = $data5[0]->name;
        $msg = $acname." Task Create for ".$cname." And Current Status is ".$sname;
        $this->db->query("INSERT INTO notify(uid,type,sms) VALUES ('$uid','1','$msg')");
         
    }
    
    
    
    public function add_cont($cid, $cdate, $contactperson, $designation, $phoneno, $emailid, $primary){
       
       $this->db->query("update company_contact_master set type='alternate'  where company_id='$cid'");
       
       $this->db->query("INSERT INTO company_contact_master(contactperson, emailid, phoneno, designation, type, createddate, company_id) VALUES ('$contactperson', '$emailid', '$phoneno', '$designation', '$primary', '$cdate', '$cid')");
       $ccid = $this->db->insert_id();
    }
    
    public function submit_company($uid,$compname, $website, $country, $city, $state, $draft, $address, $ctype, $budget, $compconname, $emailid, $phoneno, $draftop, $designation, $top_spender,$upsell_client,$focus_funnel){
        
        
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
       
       $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type,plan,autotask) VALUES ('$tid', '0', '$draft', '', '$date', 'no', '$next_action', 'NA','NA','no','$date','$next_action_id','$assign_to','$inid','$purpose','$remark_msg','$status','$assign_to','$date','$date','updated','1','1')");
       $tblid = $this->db->insert_id();
       $query=$this->db->query("update tblcallevents set nextCFID='$tblid' WHERE id='$tid'");
       
        $remark_msg = 'RP Meeting done';
        $purpose = 1;
        $next_action_id = 2;
        $next_action = 'Write Thanks Mail';
       
       $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, draft, event, fwd_date, actontaken, nextaction, meeting_type, live_loaction, mom_received, appointmentdatetime, actiontype_id, assignedto_id, cid_id, purpose_id, remarks, status_id, user_id, date, updateddate, updation_data_type,plan,autotask) VALUES ('$tblid', '0', '$draft', '', '$date', 'no', '$next_action', 'NA','NA','no','$date','$next_action_id','$assign_to','$inid','$purpose','$remark_msg','$status','$assign_to','$date','$date','updated','1','1')");
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
    
    public function submit_task($tid,$uid,$cmpid,$actontaken,$action_id,$status,$remark,$rpmmom,$purpose,$flink,$flink1,$flink2,$partner,$noofsc,$pbudgetme,$LinkedIn,$Facebook,$YouTube,$Instagram,$OtherSocial,$nadate){
        
            date_default_timezone_set("Asia/Kolkata");
            $date = date('Y-m-d H:i:s');
            $query=$this->db->query("SELECT cstatus,init_call.id inid FROM tblcallevents left join init_call on init_call.id=tblcallevents.cid_id WHERE tblcallevents.id='$tid'");
            $data = $query->result();
            $cs = $data[0]->cstatus;
            $inid = $data[0]->inid;
            
            
            if($actontaken=='no'){
                $this->db->query("INSERT INTO tblcallevents (fwd_date,appointmentdatetime,actiontype_id,assignedto_id,cid_id,purpose_id,status_id,user_id,lastCFID,nextCFID) SELECT '$date','$date',actiontype_id,'$uid',cid_id,purpose_id,status_id,'$uid','0','0' FROM tblcallevents WHERE id='$tid'");
                $ntid =  $this->db->insert_id();
                $this->db->query("UPDATE tblcallevents SET remarks='$remark',nextCFID='$ntid',updateddate='$date',status_id='$cs',nstatus_id='$cs',actontaken='no',purpose_achieved='no',updation_data_type='update' WHERE id='$tid'");
                return $ntid;
            }
            
            else{
                
                   if($purpose=='no'){
                        $this->db->query("INSERT INTO tblcallevents (fwd_date,appointmentdatetime,actiontype_id,assignedto_id,cid_id,purpose_id,remarks,status_id,user_id,ntdate) SELECT '$date','$date',actiontype_id,'$uid',cid_id,purpose_id,'',status_id,'$uid','$nadate' FROM tblcallevents WHERE id='$tid'");
                        $ntid =  $this->db->insert_id();
                        $this->db->query("UPDATE tblcallevents SET remarks='$remark',nextCFID='$ntid',updateddate='$date',status_id='$cs',nstatus_id='$cs',actontaken='yes',purpose_achieved='no',updation_data_type='update' WHERE id='$tid'");
                        return $ntid;
                   }
                   else{
                       
                       if($action_id=='6'){$this->db->query("UPDATE tblcallevents SET mom='$rpmmom' WHERE id='$tid'");if($cs=='2'){$status='3';}}
                       if($action_id=='2'){$remark='eMail Sent Successfully';$status=$cs;}
                       if($action_id=='5'){$status=$cs;}
                       if($action_id=='7'){
                           $status=$cs;
                           $this->db->query("INSERT INTO proposal(user_id, proattach, tid, main, partner, noofsc, pbudgetme) 
                                                                VALUES ('$uid','$flink','$tid','1','$partner','$noofsc','$pbudgetme')");
                           $remark='Will be Upload Proposal for Approval';
                       }
                       if($action_id=='10'){$status=$cs;}
                       if($action_id=='13'){$status=$cs;}
                       if($action_id=='14'){$status=$cs;}
                       
                       $this->db->query("UPDATE tblcallevents SET remarks='$remark',nextCFID='$tid',updateddate='$date',status_id='$cs',nstatus_id='$status',actontaken='yes',purpose_achieved='yes',updation_data_type='update' WHERE id='$tid'");
                       $this->db->query("UPDATE init_call SET lstatus=cstatus,cstatus='$status'  WHERE id='$inid'");
                       return $tid;
                       
                   }
                
            }
        
        
        
        
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
    
    
    
    
    
    public function submit_day($wffo,$flink,$user_id,$lat,$lng,$do,$autotask){
        date_default_timezone_set("Asia/Kolkata");
        $date = date('Y-m-d H:i:s');
        $da = date('Y-m-d');
        
        if($do==0){
            $this->db->query("INSERT INTO user_day(user_id, ustart, usimg, slatitude, slongitude,wffo,autotask) VALUES ('$user_id','$date','$flink','$lat','$lng','$wffo','$autotask')");
            $id =  $this->db->insert_id();
            $this->db->query("UPDATE tblcallevents SET hmtplan=hmtplan + 1, appointmentdatetime='$date', plan=0,initiateddt=null WHERE nextCFID=0 and cast(appointmentdatetime as DATE)<'$da' and remarks!='Company Created' and user_id='$user_id'");
            $this->db->query("INSERT INTO notify(uid,type,sms) VALUES ('$user_id','1','You Are Started Your Day at $date')");
            
            $query=$this->db->query("SELECT * FROM barginmeeting where company_name='Unknown' and startm is null and user_id='$user_id' and cast(storedt as DATE)<'$da'");
            $data = $query->result();
            foreach($data as $da){
                $did = $da->id;
                $cid = $da->cid;
                $ccid = $da->ccid;
                $inid = $da->inid;
                $tid = $da->tid;
                $this->db->query("DELETE FROM tblcallevents WHERE id='$tid'");
                $this->db->query("DELETE FROM init_call WHERE id='$inid'");
                $this->db->query("DELETE FROM company_contact_master WHERE id='$ccid'");
                $this->db->query("DELETE FROM company_master WHERE id='$cid'");
                $this->db->query("DELETE FROM barginmeeting WHERE id='$did'");
            }
            
            
            return $id;
        }
        
        if($do==1){
            $tdate=date('Y-m-d');
            $this->db->query("Update user_day set uclose='$date',ucimg='$flink',clatitude='$lat',clongitude='$lng' where cast(sdatet as DATE)='$tdate' and user_id='$user_id'");
            $this->db->query("INSERT INTO notify(uid,type,sms) VALUES ('$user_id','1','You Are Closed Your Day at $date')");
        }
    }
    
    
    public function delete_r(){
        $query=$this->db->query("SELECT *, user_details.name bdname,(SELECT COUNT(*) from tblcallevents where tblcallevents.cid_id=init_call.id and nextCFID!='0') tlogs ,company_master.id cid FROM company_master LEFT JOIN init_call ON init_call.cmpid_id=company_master.id left join user_details on user_details.user_id=init_call.mainbd where company_master.drequest=1");
        return $query->result();
    }
    
    
    
    
    
    public function proposal_apr($uid){
        $query=$this->db->query("SELECT *,proposal.id aprid FROM proposal LEFT JOIN tblcallevents ON tblcallevents.id=proposal.tid LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE proposal.apr=0 and user_details.admin_id='$uid'");
        return $query->result();
    }
    
    
    
    public function get_BDRequestbybdid($bdid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM bdrequest where bd_id='$bdid'");
        return $query->result();
    }
    
    public function get_BDRequestbyrid($rid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM bdrequest where id='$rid'");
        return $query->result();
    }
    
    
    public function get_BDRPIAbyrid($rid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT GROUP_CONCAT(user_detail.fullname) pianame FROM bdtask LEFT join user_detail ON user_detail.id=bdtask.uid WHERE tid='$rid'");
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
    
    
    public function REQ_APR($id,$uname){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("update bdrequest set assignto=1 where id='$id'");
        $remark='Request Approved By '.$uname;
        $query=$db3->query("INSERT INTO bdrequestlog(tid, tby, remark, detail) VALUES ('$id','$uname','$remark','$remark')");
        
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
    
    
    public function hand_Apr($aprid,$admid){
        $tdatet= date('Y-m-d H:i:s');
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("update client_handover set status='1', haprdt='$tdatet', haby='$admid' where id='$aprid'");
    }
    
    
    public function hand_Delete($aprid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("Delete FROM client_handover where id='$aprid'");
        $query=$db3->query("Delete FROM handover_account where handover_id='$aprid'");
    }
    
    
    public function delete_cmp($cid){
        $query=$this->db->query("update init_call set mainbd=null,apst='100116',bpst=null where cmpid_id='$cid'");
        $query=$this->db->query("update company_master set drequest=2 where id='$cid'");
    }
    
    
    public function rejectd_cmp($cid){
        $query=$this->db->query("update company_master set drequest=null where id='$cid'");
    }
    
    
    public function read_notify($id){
        $query=$this->db->query("update notify set view=1 where id='$id'");
    }
    
    
    public function get_bdrequest($uid,$code){
        $db3 = $this->load->database('db3', TRUE);
        if($code=='1'){
            $query=$db3->query("select * from bdrequest where bd_id='$uid'");
        }
        if($code=='2'){
            $query=$db3->query("select * from bdrequest where bd_id='$uid' and assignto='0'");
        }
        if($code=='3'){
            $query=$db3->query("select * from bdrequest where bd_id='$uid' and assignto='1'");
        }
        if($code=='4'){
            $query=$db3->query("select * from bdrequest where bd_id='$uid' and assignstatus='0'");
        }
        if($code=='5'){
            $query=$db3->query("select * from bdrequest where bd_id='$uid' and status='0' and assignstatus='1'");
        }
        if($code=='6'){
            $query=$db3->query("select * from bdrequest where bd_id='$uid' and status='1'");
        }
        return $query->result();
    }
    
    public function get_bdrequestlog($tid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM bdrequestlog WHERE tid='$tid'");
        return $query->result();
    }
    
    
    public function get_bdrequestattech($tid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT GROUP_CONCAT(attech) att FROM bdrequestlog WHERE tid='$tid' and attech!=''");
        return $query->result();
    }
    
    
    
    public function submit_bdrequest($ctype,$uid,$targetd,$request_type,$remark,$cname,$tyschool,$noschool,$location,$idetype,$ngoletter,$sletter,$dmletter,$svalidation){
        
        
        if($request_type=='School Identification'){$rysn='SSCHOOLID';}
        if($request_type=='Report'){$rysn='Report';} 
        if($request_type=='New client school visit'){$rysn='NCSV';}
        if($request_type=='Inauguration'){$rysn='Inauguration';}
        if($request_type=='Demo'){$rysn='Demo';}
        if($request_type=='OnBoardVisit'){$rysn='OnBoardVisit';}
        if($request_type=='School Maintenance'){$rysn='SMaintenance';}
        if($request_type=='New Client Report'){$rysn='NCR';}
        if($request_type=='On Board Client School Visit'){$rysn='OnBoardClientVisit';}
        if($request_type=='DIY'){$rysn='DIY';}
        if($request_type=='Employee Engagement'){$rysn='EmployeeEngagement';}
        if($request_type=='RTTP'){$rysn='RTTP';}
        
        $data = $this->Menu_model->get_userbyid($uid);
        $bdname = $data[0]->name;
        
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("INSERT INTO bdrequest(targetd, bd_id, bd_name, request_type, remark, cname, vlocation, schooltype, noofschool, assignto, rysn, onnew, idetype, ngoletter, sletter, dmletter, svalidation) VALUES 
        ('$targetd','$uid','$bdname','$request_type','$remark','$cname','$location','$tyschool','$noschool','0','$rysn','$ctype','$idetype','$ngoletter','$sletter','$dmletter','$svalidation')");
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
  
  
  
  
  
  
  
    
   
   
    public function get_fmtaskdesign($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT * FROM sub_task WHERE project_code='$pcode' and ");
        return $query->result();
    }
   
    public function get_fmtaskprinting($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT * FROM sub_task WHERE project_code='$pcode' and tasktype='Printing'");
        return $query->result();
    }
   
    public function get_fmtaskpacking($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT * FROM sub_task WHERE project_code='$pcode' and tasktype='Packing'");
        return $query->result();
    }
   
    public function get_fmtaskdispatch($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT * FROM sub_task WHERE project_code='$pcode' and tasktype='Dispatch'");
        return $query->result();
    }
    
    
    
   
    public function get_printprocessUM($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT * FROM `model_m` WHERE model_name='User Manual Printing' ORDER BY `model_m`.`stage` ASC");
        return $query->result();
    }
   
    public function get_printprocessTM($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT * FROM `model_m` WHERE model_name='Training Manual Printing' ORDER BY `model_m`.`stage` ASC");
        return $query->result();
    }
   
    public function get_printingprocess($pcode,$process,$part){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT dailywork.video,workclose.user_name,process_name,workclose.startt,workclose.closet FROM dailywork LEFT JOIN workclose ON workclose.wid=dailywork.id WHERE batchno='$pcode' and model_name='Backdrop Printing'");
        return $query->result();
    }
    
    
   
    public function get_fprepairing($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT * FROM `boxpreparing` WHERE project='$pcode'");
        return $query->result();
    }
   
   
   
   
   
    

    public function get_bdnamebyid($bdid){
        $query=$this->db->query("SELECT * FROM user_details where user_id='$bdid'");
        return $query->result();
    }
    
    
    
    
    public function get_Schoolbycid($cid){
        $db3 = $this->load->database('db3', TRUE);
        
        $query=$db3->query("SELECT * FROM client_handover where id='$cid'");
        $data = $query->result();
        $pcode = $data[0]->projectcode;
        
        
        $query=$db3->query("SELECT spd.id sid,spd.updateddt spdudt,status.name stname,u1.fullname pia,u2.fullname imp,spd.*,client_handover.* FROM spd LEFT JOIN user_detail u1 ON u1.id=spd.pi_id LEFT JOIN user_detail u2 ON u2.id=spd.ins_id LEFT JOIN client_handover ON client_handover.projectcode=spd.project_code LEFT JOIN status ON status.id=spd.status WHERE client_handover.id and project_code='$pcode';");
        return $query->result();
    }
    
    
    
    public function get_SPDTask($sid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT *,spd.id sid,status.name stname,user_detail.fullname uname, plantask.donet taskudt,plantask.remark tremark FROM spd LEFT JOIN status on status.id=spd.status LEFT JOIN client_handover ON client_handover.projectcode=spd.project_code LEFT JOIN user_detail ON user_detail.id=spd.pi_id LEFT JOIN plantask ON spd.id=plantask.spd_id LEFT JOIN task_assign on task_assign.id=plantask.taskid WHERE spd.id='$sid'");
        return $query->result();
    }
    
    public function get_reportbystid($tid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM report WHERE tid='$tid'");
        return $query->result();
    }
    
    
    public function get_commbystid($tid,$sid){
       $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM wgdata WHERE tid='$tid' and sid='$sid'");
        return $query->result();
    }
    
    
    public function get_wgbytttid($tid){
       $db3 = $this->load->database('db3', TRUE);
        
        $query=$db3->query("SELECT * FROM wgdata WHERE tid='$tid'");
        return $query->result();
    }
    









    public function get_School($pcode){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT spd.id sid,spd.updateddt spdudt,status.name stname,u1.fullname pia,u2.fullname imp,spd.*,client_handover.* FROM spd LEFT JOIN user_detail u1 ON u1.id=spd.pi_id LEFT JOIN user_detail u2 ON u2.id=spd.ins_id LEFT JOIN client_handover ON client_handover.projectcode=spd.project_code LEFT JOIN status ON status.id=spd.status WHERE client_handover.id and project_code='$pcode';");
        return $query->result();
    }
   
    public function get_Dispatchdetail($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT * FROM unique_model where project='$pcode' and dispatchdt is not null ORDER BY `unique_model`.`dispatchdt` ASC");
        return $query->result();
    }
   
    public function get_Logesticinfo($pcode){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM `spdlogic` where project_code='$pcode'");
        return $query->result();
    }
   
    public function get_ewaybillinfo($pcode){
        $db2 = $this->load->database('db2', TRUE);
        $query=$db2->query("SELECT * FROM `dewaybill` where project_code='$pcode'");
        return $query->result();
    }
   
    public function get_deliveryprocess($pcode){
	$db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT * FROM `deliveryv` where projectcode='$pcode'");
        return $query->result();
    }
    
    public function get_fannals($uid,$sid){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){
            
        }
        if($utype==3){
            $query=$this->db->query("SELECT (COUNT(CASE WHEN cstatus='1' THEN cstatus='1' END))+(COUNT(CASE WHEN cstatus='8' THEN cstatus='8' END))+(COUNT(CASE WHEN cstatus='2' THEN cstatus='2' END))+(COUNT(CASE WHEN cstatus='10' THEN cstatus='10' END))+(COUNT(CASE WHEN cstatus='11' THEN cstatus='11' END)) stage1, (COUNT(CASE WHEN cstatus='3' THEN cstatus='3' END)) stage2,(COUNT(CASE WHEN cstatus='6' THEN cstatus='6' END))+(COUNT(CASE WHEN cstatus='9' THEN cstatus='9' END))+(COUNT(CASE WHEN cstatus='12' THEN cstatus='12' END))+(COUNT(CASE WHEN cstatus='13' THEN cstatus='13' END)) stage3,(COUNT(CASE WHEN cstatus='7' THEN cstatus='7' END)) stage4  FROM init_call left join user_details on user_details.user_id=init_call.mainbd  JOIN status on status.id=init_call.cstatus WHERE init_call.mainbd='$uid'");
        }
        if($utype==4){
            $query=$this->db->query("SELECT (COUNT(CASE WHEN cstatus='1' THEN cstatus='1' END))+(COUNT(CASE WHEN cstatus='8' THEN cstatus='8' END))+(COUNT(CASE WHEN cstatus='2' THEN cstatus='2' END))+(COUNT(CASE WHEN cstatus='10' THEN cstatus='10' END))+(COUNT(CASE WHEN cstatus='11' THEN cstatus='11' END)) stage1, (COUNT(CASE WHEN cstatus='3' THEN cstatus='3' END)) stage2,(COUNT(CASE WHEN cstatus='6' THEN cstatus='6' END))+(COUNT(CASE WHEN cstatus='9' THEN cstatus='9' END))+(COUNT(CASE WHEN cstatus='12' THEN cstatus='12' END))+(COUNT(CASE WHEN cstatus='13' THEN cstatus='13' END)) stage3,(COUNT(CASE WHEN cstatus='7' THEN cstatus='7' END)) stage4  FROM init_call left join user_details on user_details.user_id=init_call.apst  JOIN status on status.id=init_call.cstatus WHERE init_call.apst='$uid'");
        }
        if($utype==9){
            $query=$this->db->query("SELECT (COUNT(CASE WHEN cstatus='1' THEN cstatus='1' END))+(COUNT(CASE WHEN cstatus='8' THEN cstatus='8' END))+(COUNT(CASE WHEN cstatus='2' THEN cstatus='2' END))+(COUNT(CASE WHEN cstatus='10' THEN cstatus='10' END))+(COUNT(CASE WHEN cstatus='11' THEN cstatus='11' END)) stage1, (COUNT(CASE WHEN cstatus='3' THEN cstatus='3' END)) stage2,(COUNT(CASE WHEN cstatus='6' THEN cstatus='6' END))+(COUNT(CASE WHEN cstatus='9' THEN cstatus='9' END))+(COUNT(CASE WHEN cstatus='12' THEN cstatus='12' END))+(COUNT(CASE WHEN cstatus='13' THEN cstatus='13' END)) stage3,(COUNT(CASE WHEN cstatus='7' THEN cstatus='7' END)) stage4  FROM init_call left join user_details on user_details.user_id=init_call.mainbd  JOIN status on status.id=init_call.cstatus WHERE init_call.mainbd='$uid'");
        }
        
        return $query->result();
    }
    
    
    
    
    
    public function get_fannalstatus($uid,$sid){
        
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        
        if($utype==2){
            
        }
        if($utype==4){
            $query=$this->db->query("SELECT status.name,COUNT(*) cont FROM init_call JOIN status on status.id=init_call.cstatus WHERE apst='$uid' and cstatus='$sid'");
        }
        
        if($utype==3){
            $query=$this->db->query("SELECT status.name,COUNT(*) cont FROM init_call JOIN status on status.id=init_call.cstatus WHERE mainbd='$uid' and cstatus='$sid'");
        }
        
        if($utype==9){
            $query=$this->db->query("SELECT status.name,COUNT(*) cont FROM init_call JOIN status on status.id=init_call.cstatus WHERE mainbd='$uid' and cstatus='$sid'");
        }
        
        return $query->result();
    }
    
    
    public function get_dmstartg($uid,$tdate){
        $query=$this->db->query("SELECT TIME_FORMAT(ustart, '%H:%i') mystime, (SELECT TIME_FORMAT(SEC_TO_TIME(AVG(TIME_TO_SEC(ustart))),'%H:%i') average_time FROM ( SELECT ustart FROM user_day LEFT JOIN user_details ON user_details.user_id = user_day.user_id WHERE user_day.user_id!='$uid' and user_details.admin_id = '45' AND CAST(ustart AS DATE) = '$tdate' ) AS subquery) avgstime FROM user_day WHERE user_id='$uid' and cast(ustart as DATE)='$tdate'");
        return $query->result();
    }
    
    
    public function get_dmsreview($uid,$tdate){
        $query=$this->db->query("SELECT count(case when scomment is not null then 1 end) scomment FROM user_day WHERE user_id='$uid' and cast(ustart as DATE)='$tdate'");
        return $query->result();
    }
    
    public function get_dmcreview($uid,$tdate){
        $query=$this->db->query("SELECT count(case when ccomment is not null then 1 end) ccomment FROM user_day WHERE user_id='$uid' and cast(ustart as DATE)='$tdate'");
        return $query->result();
    }
    

    
    public function get_dmcloseg($uid,$tdate){
        $query=$this->db->query("SELECT TIME_FORMAT(uclose, '%H:%i') myctime, (SELECT TIME_FORMAT(SEC_TO_TIME(AVG(TIME_TO_SEC(uclose))),'%H:%i') average_time FROM ( SELECT uclose FROM user_day LEFT JOIN user_details ON user_details.user_id = user_day.user_id WHERE user_day.user_id!='$uid' and user_details.admin_id = '45' AND CAST(uclose AS DATE) = '$tdate' ) AS subquery) avgctime FROM user_day WHERE user_id='$uid' and cast(uclose as DATE)='$tdate'");
        return $query->result();
    }
    
    public function get_fannalpartner($uid){
        $query=$this->db->query("SELECT partner_master.id pid, partner_master.name pname,COUNT(*) cont FROM init_call JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN partner_master ON partner_master.id=company_master.partnerType_id WHERE mainbd='$uid' GROUP BY partner_master.name,partner_master.id");
        return $query->result();
    }
    
    public function get_fannalcat($uid){
        $query=$this->db->query("SELECT COUNT(CASE WHEN topspender!='yes' and focus_funnel!='yes' and upsell_client!='yes' and keycompany!='yes' and pkclient!='yes' and priorityc!='yes' THEN 1 END) nocat,COUNT(CASE WHEN topspender='yes' THEN topspender='yes' END) topspender,COUNT(CASE WHEN focus_funnel='yes' THEN focus_funnel='yes' END) focus_funnel,COUNT(CASE WHEN upsell_client='yes' THEN upsell_client='yes' END) upsell_client,COUNT(CASE WHEN keycompany='yes' THEN keycompany='yes' END) keycompany,COUNT(CASE WHEN pkclient='yes' THEN pkclient='yes' END) pkclient,COUNT(CASE WHEN priorityc='yes' THEN priorityc='yes' END) priorityc FROM init_call WHERE mainbd='$uid'");
        return $query->result();
    }
    
    
    public function get_pstfannalstwise($uid){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){
            $query=$this->db->query("SELECT status.id stid,status.name stname, COUNT(*) cont FROM init_call LEFT join status ON status.id=init_call.cstatus LEFT JOIN user_details on user_details.user_id=init_call.apst  WHERE user_details.admin_id='$uid' and user_details.status='active' GROUP BY status.name,status.id");
            
        }else{
            $query=$this->db->query("SELECT status.id stid,status.name stname, COUNT(*) cont FROM init_call LEFT JOIN status ON status.id=init_call.cstatus WHERE apst='$uid' GROUP BY status.name,status.id");
            
        }
        
        return $query->result();
    }
    
    public function get_fannalstwise($uid){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){
            $query=$this->db->query("SELECT status.id stid,status.name stname, COUNT(*) cont FROM init_call LEFT join status ON status.id=init_call.cstatus LEFT JOIN user_details on user_details.user_id=init_call.mainbd  WHERE user_details.admin_id='$uid' and user_details.status='active' GROUP BY status.name,status.id");
            
        }else{
            $query=$this->db->query("SELECT status.id stid,status.name stname, COUNT(*) cont FROM init_call LEFT JOIN status ON status.id=init_call.cstatus WHERE mainbd='$uid' GROUP BY status.name,status.id");
            
        }
        
        return $query->result();
    }
    
    public function get_fannalcitywise($uid){
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){
            $query=$this->db->query("Select city.id cityid, company_master.city,COUNT(*) cont from init_call LEFT JOIN user_details ON user_details.user_id=init_call.mainbd LEFT JOIN company_master ON company_master.id=init_call.cmpid_id left join city on city.city=company_master.city WHERE user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active' GROUP BY company_master.city,city.id");
        }
        else{
           $query=$this->db->query("Select city.id cityid, company_master.city,COUNT(*) cont from init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id left join city on city.city=company_master.city WHERE init_call.mainbd='$uid' GROUP BY company_master.city,city.id"); 
        }
        
        
        return $query->result();
    }
    
    public function get_pstworkonrpcnew($sdate,$edate,$uid){
        
        $query=$this->db->query("SELECT u1.name bdname, u2.name pstname, init_call.*,company_master.*,init_call.id inid, company_master.id cid, init_call.cstatus cst,(SELECT MAX(tid) FROM barginmeeting WHERE barginmeeting.inid=init_call.id) tid FROM init_call LEFT JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN user_details u1 ON u1.user_id=init_call.mainbd LEFT JOIN user_details u2 ON u2.user_id=init_call.apst WHERE init_call.apst is not null and u1.admin_id='$uid' and cast(init_call.pstadt as DATE) between '$sdate' and '$edate'");
        return $query->result();
        
    }
    
    public function get_workdoneCompanyBDPST($bdid){
        $query=$this->db->query("SELECT company_master.id cid, updateddate,actontaken,purpose_achieved, company_master.compname,u1.name bdname,u2.name pstname,u3.name taskby,s1.name cstatus,s2.name bstatus,s3.name astatus,remarks FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN status s1 ON s1.id=init_call.cstatus LEFT JOIN status s2 ON s2.id=tblcallevents.status_id LEFT JOIN status s3 ON s3.id=tblcallevents.nstatus_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN user_details u1 ON u1.user_id=init_call.mainbd LEFT JOIN user_details u2 ON u2.user_id=init_call.apst LEFT JOIN user_details u3 ON u3.user_id=tblcallevents.user_id WHERE cid_id IN (SELECT init_call.id FROM init_call LEFT JOIN user_details u4 ON u4.user_id=init_call.mainbd WHERE u4.user_id='$bdid' and apst is not null) and nextCFID!='0' and cast(updateddate as DATE)>'2023-09-18' ORDER BY `company_master`.`id` ASC");
        return $query->result();
    }
    
    
    public function get_NotworkCompanyBDPST($bdid){
        $query=$this->db->query("SELECT company_master.id cid,company_master.compname,u1.name bdname,u2.name pstname,s1.name cstatus FROM init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN status s1 ON s1.id=init_call.cstatus LEFT JOIN user_details u1 ON u1.user_id=init_call.mainbd LEFT JOIN user_details u2 ON u2.user_id=init_call.apst WHERE mainbd = '$bdid' AND apst IS NOT NULL AND init_call.id NOT IN (SELECT cid_id FROM tblcallevents WHERE cid_id IN (SELECT id FROM init_call WHERE mainbd='$bdid' AND apst IS NOT NULL) AND nextCFID != '0' AND CAST(updateddate AS DATE) > '2023-09-18')");
        return $query->result();
    }
    
    public function get_workbutactionnobd($bdid){
        $query=$this->db->query("SELECT company_master.id cid,company_master.compname,u1.name bdname,u2.name pstname,s1.name cstatus FROM init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN status s1 ON s1.id=init_call.cstatus LEFT JOIN user_details u1 ON u1.user_id=init_call.mainbd LEFT JOIN user_details u2 ON u2.user_id=init_call.apst WHERE mainbd = '$bdid' AND apst IS NOT NULL AND init_call.id NOT IN (SELECT cid_id FROM tblcallevents WHERE cid_id IN (SELECT id FROM init_call WHERE mainbd='$bdid' AND apst IS NOT NULL) AND nextCFID != '0' AND actontaken='no' AND user_id='$bdid' AND CAST(updateddate AS DATE) > '2023-09-18')");
        return $query->result();
    }
    
    public function get_workbutactionnopst($bdid){
        $query=$this->db->query("SELECT company_master.id cid,company_master.compname,u1.name bdname,u2.name pstname,s1.name cstatus FROM init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN status s1 ON s1.id=init_call.cstatus LEFT JOIN user_details u1 ON u1.user_id=init_call.mainbd LEFT JOIN user_details u2 ON u2.user_id=init_call.apst WHERE mainbd = '$bdid' AND apst IS NOT NULL AND init_call.id NOT IN (SELECT cid_id FROM tblcallevents WHERE cid_id IN (SELECT id FROM init_call WHERE mainbd='$bdid' AND apst IS NOT NULL) AND nextCFID != '0' AND actontaken='no' AND CAST(updateddate AS DATE) > '2023-09-18')");
        return $query->result();
    }
    
    
    
    public function get_pstworkonrpcall($sdate,$edate,$uid){
        
        
        
        $query=$this->db->query("SELECT u1.name bdname, u2.name pstname, init_call.*,company_master.*,init_call.id inid, company_master.id cid, status.name cst, (SELECT MAX(tid) FROM barginmeeting WHERE barginmeeting.inid = init_call.id) AS tid FROM init_call left join status on status.id=init_call.cstatus LEFT JOIN company_master ON company_master.id = init_call.cmpid_id LEFT JOIN user_details u1 ON u1.user_id = init_call.mainbd LEFT JOIN user_details u2 ON u2.user_id = init_call.apst WHERE init_call.apst IS NOT NULL AND u1.admin_id = '$uid' AND init_call.id IN ( SELECT tblcallevents.cid_id FROM tblcallevents LEFT JOIN user_details u5 ON u5.user_id = tblcallevents.user_id WHERE CAST(tblcallevents.updateddate AS DATE) BETWEEN '$sdate' AND '$edate' AND tblcallevents.actiontype_id = '6' AND u5.admin_id = '$uid' )");
        return $query->result();
        
    }
    
    
    public function get_graphlink($uid){
        
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){}
        if($utype==3){$query=$this->db->query("SELECT * FROM graphlink WHERE depid='3'");}
        
        
        return $query->result();
        
    }
    
    
    
    
    public function get_opensday($uid,$sid,$sdate,$edate){
        $query=$this->db->query("SELECT TIMESTAMPDIFF(DAY,MAX(updateddate),now()) opensday FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id WHERE init_call.cstatus=tblcallevents.nstatus_id and cast(tblcallevents.updateddate as DATE) Between '2023-04-01' and '2024-03-31' and tblcallevents.cid_id IN (Select id from init_call WHERE init_call.mainbd='$uid') and tblcallevents.nextCFID!='0' and init_call.cstatus='$sid' GROUP BY init_call.id");
        return $query->result();
    }
    
    
    public function get_statuswisetaskandaction($uid,$stid,$sd,$ed){
        $query=$this->db->query("SELECT COUNT(*) as cont, 
        COUNT(case when actiontype_id=1 then 1 end) as a,
        COUNT(case when actiontype_id=2 then 1 end) as b,
        COUNT(case when actiontype_id=3 then 1 end) as c,
        COUNT(case when actiontype_id=4 then 1 end) as d,
        COUNT(case when actiontype_id=5 then 1 end) as e,
        COUNT(case when actiontype_id=6 then 1 end) as f,
        COUNT(case when actiontype_id=7 then 1 end) as g,
        COUNT(case when actiontype_id=8 then 1 end) as h,
        COUNT(case when actiontype_id=9 then 1 end) as i,
        COUNT(case when actiontype_id=10 then 1 end) as j,
        COUNT(case when actiontype_id=11 then 1 end) as k
        FROM tblcallevents  WHERE tblcallevents.cid_id IN (Select id from init_call WHERE init_call.mainbd='$uid' and init_call.cstatus='$stid') and nextCFID!='0' and cast(updateddate as DATE) Between '$sd' and '$ed'");
        return $query->result();
    }
    
    
    public function get_monthwsaction($uid,$m,$y){
        $query=$this->db->query("SELECT COUNT(*) as cont, 
        COUNT(case when actiontype_id=1 then 1 end) as a,
        COUNT(case when actiontype_id=2 then 1 end) as b,
        COUNT(case when actiontype_id=3 then 1 end) as c,
        COUNT(case when actiontype_id=4 then 1 end) as d,
        COUNT(case when actiontype_id=5 then 1 end) as e,
        COUNT(case when actiontype_id=6 then 1 end) as f,
        COUNT(case when actiontype_id=7 then 1 end) as g,
        COUNT(case when actiontype_id=8 then 1 end) as h,
        COUNT(case when actiontype_id=9 then 1 end) as i,
        COUNT(case when actiontype_id=10 then 1 end) as j,
        COUNT(case when actiontype_id=11 then 1 end) as k
        FROM tblcallevents  WHERE tblcallevents.cid_id IN (Select id from init_call WHERE init_call.mainbd='$uid') and nextCFID!='0' and Month(updateddate)='$m' and Year(updateddate)='$y'");
        return $query->result();
    }
    
    
    
    public function get_monthwnewlead($uid,$m,$y){
        $query=$this->db->query("SELECT COUNT(*) as cont, 
        COUNT(*) as a,
        COUNT(*) as b
        FROM init_call  WHERE Month(createDate)='$m' and Year(createDate)='$y' and mainbd='$uid'");
        return $query->result();
    }
    
    
    
    public function get_monthwsactionbyotherAYPY($uid,$m,$y){
        $query=$this->db->query("SELECT COUNT(*) as cont, 
        COUNT(case when actiontype_id=1 then 1 end) as a,
        COUNT(case when actiontype_id=2 then 1 end) as b,
        COUNT(case when actiontype_id=3 then 1 end) as c,
        COUNT(case when actiontype_id=4 then 1 end) as d,
        COUNT(case when actiontype_id=5 then 1 end) as e,
        COUNT(case when actiontype_id=6 then 1 end) as f,
        COUNT(case when actiontype_id=7 then 1 end) as g,
        COUNT(case when actiontype_id=8 then 1 end) as h,
        COUNT(case when actiontype_id=9 then 1 end) as i,
        COUNT(case when actiontype_id=10 then 1 end) as j,
        COUNT(case when actiontype_id=11 then 1 end) as k
        FROM tblcallevents  WHERE tblcallevents.user_id!='$uid' and actontaken='yes' and purpose_achieved='yes' and tblcallevents.cid_id IN (Select id from init_call WHERE init_call.mainbd='$uid') and nextCFID!='0' and Month(updateddate)='$m' and Year(updateddate)='$y'");
        return $query->result();
    }
    
    
    public function get_monthwsactionbyotherAYPN($uid,$m,$y){
        $query=$this->db->query("SELECT COUNT(*) as cont, 
        COUNT(case when actiontype_id=1 then 1 end) as a,
        COUNT(case when actiontype_id=2 then 1 end) as b,
        COUNT(case when actiontype_id=3 then 1 end) as c,
        COUNT(case when actiontype_id=4 then 1 end) as d,
        COUNT(case when actiontype_id=5 then 1 end) as e,
        COUNT(case when actiontype_id=6 then 1 end) as f,
        COUNT(case when actiontype_id=7 then 1 end) as g,
        COUNT(case when actiontype_id=8 then 1 end) as h,
        COUNT(case when actiontype_id=9 then 1 end) as i,
        COUNT(case when actiontype_id=10 then 1 end) as j,
        COUNT(case when actiontype_id=11 then 1 end) as k
        FROM tblcallevents  WHERE tblcallevents.user_id!='$uid' and actontaken='yes' and purpose_achieved='no' and tblcallevents.cid_id IN (Select id from init_call WHERE init_call.mainbd='$uid') and nextCFID!='0' and Month(updateddate)='$m' and Year(updateddate)='$y'");
        return $query->result();
    }
    
    
    public function get_monthwsactionbyotherANPN($uid,$m,$y){
        $query=$this->db->query("SELECT COUNT(*) as cont, 
        COUNT(case when actiontype_id=1 then 1 end) as a,
        COUNT(case when actiontype_id=2 then 1 end) as b,
        COUNT(case when actiontype_id=3 then 1 end) as c,
        COUNT(case when actiontype_id=4 then 1 end) as d,
        COUNT(case when actiontype_id=5 then 1 end) as e,
        COUNT(case when actiontype_id=6 then 1 end) as f,
        COUNT(case when actiontype_id=7 then 1 end) as g,
        COUNT(case when actiontype_id=8 then 1 end) as h,
        COUNT(case when actiontype_id=9 then 1 end) as i,
        COUNT(case when actiontype_id=10 then 1 end) as j,
        COUNT(case when actiontype_id=11 then 1 end) as k
        FROM tblcallevents  WHERE tblcallevents.user_id!='$uid' and actontaken='no' and purpose_achieved='no' and tblcallevents.cid_id IN (Select id from init_call WHERE init_call.mainbd='$uid') and nextCFID!='0' and Month(updateddate)='$m' and Year(updateddate)='$y'");
        return $query->result();
    }
    
    
    
    public function get_taskolsna($uid,$st,$ac,$sd,$ed){
        $query=$this->db->query("SELECT COUNT(*) cont,action.name name, COUNT(CASE WHEN initiateddt>updateddate THEN 1 END) a, COUNT(CASE WHEN initiateddt<updateddate THEN 1 END) b FROM tblcallevents  LEFT JOIN action on action.id=tblcallevents.actiontype_id WHERE tblcallevents.cid_id IN (Select id from init_call WHERE init_call.mainbd='$uid' and init_call.cstatus='$st') and actiontype_id='$ac' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed'");
        return $query->result();
    }
    
    
    
    public function get_ounmfunnal($uid,$sd,$ed){
        $query=$this->db->query("SELECT user_details.name ouname,user_details.user_id ouid FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE tblcallevents.cid_id IN (Select id from init_call WHERE init_call.mainbd='$uid') and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' Group By user_details.name,user_details.user_id");
        return $query->result();
    }
    
    public function get_outaskonmyfunnalaypy($uid,$ouid,$sd,$ed){
        $query=$this->db->query("SELECT COUNT(*) as cont, 
        COUNT(case when tblcallevents.status_id=1 then 1 end) as a,
        COUNT(case when tblcallevents.status_id=2 then 1 end) as b,
        COUNT(case when tblcallevents.status_id=3 then 1 end) as c,
        COUNT(case when tblcallevents.status_id=4 then 1 end) as d,
        COUNT(case when tblcallevents.status_id=5 then 1 end) as e,
        COUNT(case when tblcallevents.status_id=6 then 1 end) as f,
        COUNT(case when tblcallevents.status_id=7 then 1 end) as g,
        COUNT(case when tblcallevents.status_id=8 then 1 end) as h,
        COUNT(case when tblcallevents.status_id=9 then 1 end) as i,
        COUNT(case when tblcallevents.status_id=10 then 1 end) as j,
        COUNT(case when tblcallevents.status_id=11 then 1 end) as k,
        COUNT(case when tblcallevents.status_id=12 then 1 end) as l,
        COUNT(case when tblcallevents.status_id=13 then 1 end) as m,
        COUNT(case when tblcallevents.status_id=14 then 1 end) as n
        FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE tblcallevents.user_id='$ouid' and tblcallevents.cid_id IN (Select id from init_call WHERE init_call.mainbd='$uid') and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed'");
        return $query->result();
    }
    
    
    
    
    public function get_cmpdbypstnst($stid,$bdid,$fdate,$pstid,$categories,$reviewtype){
        
        $utype = $this->Menu_model->get_userbyid($pstid);
        $utype = $utype[0]->type_id;
        if($utype=='4'){
            if($bdid==$pstid){
                $query=$this->db->query("SELECT *,init_call.id inid from init_call Left JOIN company_master ON company_master.id=init_call.cmpid_id where cstatus='$stid' and apst='$pstid'");
                
            }else{
                $query=$this->db->query("SELECT *,init_call.id inid from init_call Left JOIN company_master ON company_master.id=init_call.cmpid_id where mainbd='$bdid' and cstatus='$stid' and apst='$pstid'");
            }
            
            
            
            
            
            
        }elseif($utype=='9'){
            $query=$this->db->query("SELECT *,init_call.id inid from init_call Left JOIN company_master ON company_master.id=init_call.cmpid_id where cstatus='$stid' and mainbd='$bdid'");
        }elseif($utype=='10'){
            $query=$this->db->query("SELECT *,init_call.id inid from init_call Left JOIN company_master ON company_master.id=init_call.cmpid_id where cstatus='$stid' and mainbd='$bdid'");
        }
        
        else{
           $query=$this->db->query("SELECT *,init_call.id inid from init_call Left JOIN company_master ON company_master.id=init_call.cmpid_id where mainbd='$bdid' and cstatus='$stid' and apst='$pstid'");
         
        }
        
        return $query->result(); 
    }
    
    public function get_cmpdbybd($stid,$bdid,$fdate){
        $query=$this->db->query("SELECT *,init_call.id inid from init_call Left JOIN company_master ON company_master.id=init_call.cmpid_id where mainbd='$bdid' and cstatus='$stid'");
        return $query->result(); 
    }
    
    public function get_bdcmpdbynst($stid,$bdid,$fdate,$pstid,$rid){
        $query=$this->db->query("SELECT *,init_call.id inid from init_call Left JOIN company_master ON company_master.id=init_call.cmpid_id where mainbd='$bdid' and cstatus='$stid'");
        return $query->result(); 
    }
    
    
    
    public function get_tasklogs($inid,$date,$cdate,$ab){
        $query=$this->db->query("SELECT *,company_master.id cid,user_details.name umane,u1.name bdname,action.name aname,status.name sname FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN user_details u1 ON u1.user_id=init_call.mainbd LEFT JOIN user_details u2 ON u2.user_id=init_call.apst LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN status ON status.id=tblcallevents.status_id LEFT JOIN action ON action.id=tblcallevents.actiontype_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE cid_id='$inid' and cast(updateddate as DATE) Between '$date' and '$cdate'");
        return $query->result();
    }
    
    public function get_psttasklogs($inid,$date,$cdate,$ab){
        $query=$this->db->query("SELECT *,company_master.id cid,user_details.name umane,u1.name bdname,action.name aname,status.name sname FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN user_details u1 ON u1.user_id=init_call.mainbd LEFT JOIN user_details u2 ON u2.user_id=init_call.apst LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN status ON status.id=tblcallevents.status_id LEFT JOIN action ON action.id=tblcallevents.actiontype_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id WHERE user_details.type_id='4' and cid_id='$inid' and cast(updateddate as DATE) Between '$date' and '$cdate'");
        return $query->result();
    }
    
    
    public function get_lasttask($ntid){
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE id='$ntid'");
        return $query->result();
    }
    
    public function convert_seconds($seconds){
        $days = floor($seconds / 86400);
$seconds %= 86400;

$hours = floor($seconds / 3600);
$seconds %= 3600;

$minutes = floor($seconds / 60);
$seconds %= 60;

return "Days: $days, Hours: $hours, Minutes: $minutes, Seconds: $seconds";
    }
    
    
    public function get_pstsummryreviewr($uid,$sd,$ed){
        $query=$this->db->query("SELECT user_details.user_id uid,user_details.name, COUNT(*) noofreview, COUNT(allreviewdata.inid) noofcompny, SUM(TIMESTAMPDIFF(SECOND,startt,closet)) ttime FROM allreview LEFT JOIN allreviewdata ON allreviewdata.rid=allreview.id LEFT JOIN user_details ON user_details.user_id=allreview.uid WHERE cast(startt as DATE) between '$sd' and '$ed' and user_details.type_id='4' and user_details.admin_id='45' group by user_details.user_id,user_details.name");
        return $query->result();
    }
    
    public function get_bdsummryreviewr($uid,$sd,$ed){
        $query=$this->db->query("SELECT user_details.user_id uid,user_details.name, COUNT(*) noofreview, COUNT(allreviewdata.inid) noofcompny, COUNT(distinct allreviewdata.inid) noofucompny, SUM(TIMESTAMPDIFF(SECOND,startt,closet)) ttime FROM allreview LEFT JOIN allreviewdata ON allreviewdata.rid=allreview.id LEFT JOIN user_details ON user_details.user_id=allreview.uid WHERE  cast(startt as DATE) between '$sd' and '$ed' and user_details.type_id='3' and user_details.admin_id='45' group by user_details.user_id,user_details.name");
        return $query->result();
    }
    
    
    
    public function get_reviewdetail($rid){
        
        $query=$this->db->query("SELECT *,company_master.id cid,company_master.compname cmpname,action.name aname,s1.name exname,s2.name rtsname,s3.name csname,user_details.name bdname FROM allreviewdata LEFT JOIN user_details ON user_details.user_id=allreviewdata.bdid LEFT JOIN status s1 ON s1.id=allreviewdata.exsid LEFT JOIN status s2 ON s2.id=allreviewdata.csid LEFT JOIN init_call ON init_call.id=allreviewdata.inid  LEFT JOIN status s3 ON s3.id=init_call.cstatus  LEFT JOIN tblcallevents ON tblcallevents.id=allreviewdata.ntid LEFT JOIN action ON action.id=tblcallevents.actiontype_id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE rid='$rid'");
        return $query->result();
    }
    
    public function get_reviewr($pstid,$bdid,$sd,$ed){
        if($bdid==0){
           $query=$this->db->query("SELECT *,allreview.id rid,user_details.name bdname,(SELECT COUNT(*) FROM allreviewdata WHERE allreviewdata.rid=allreview.id) totalc FROM allreview LEFT JOIN user_details ON user_details.user_id=allreview.uid WHERE uid='$pstid' and cast(startt as DATE) between '$sd' and '$ed'");
        }else{
          $query=$this->db->query("SELECT *,allreview.id rid,user_details.name bdname,(SELECT COUNT(*) FROM allreviewdata WHERE allreviewdata.rid=allreview.id) totalc FROM allreview LEFT JOIN user_details ON user_details.user_id=allreview.bdid WHERE uid='$pstid' and cast(startt as DATE) between '$sd' and '$ed'");
        }
        return $query->result();
    }
    
    public function get_reviewstarted($uid){
        $query=$this->db->query("SELECT *,allreview.id rid FROM allreview left join user_details ON user_details.user_id=allreview.bdid WHERE startt is not null and closet is null and uid='$uid'");
        return $query->result();
    }
    
    public function get_reviewid($uid){
        $query=$this->db->query("SELECT allreview.id rid,user_details.name name,allreview.* FROM allreview LEFT JOIN user_details ON user_details.user_id=allreview.bdid WHERE startt is null and closet is null and uid='$uid'");
        return $query->result();
    }
    
    public function start_review($startt,$reviewid){
        $query=$this->db->query("update allreview set startt='$startt' WHERE id='$reviewid'");
    }
    
    
    
    public function close_review($closetdate,$closeremark,$rrid){
        $query=$this->db->query("update allreview set closet='$closetdate',cremark='$closeremark' WHERE id='$rrid'");
    }
    
    
    public function plan_review($plandate,$uid,$bdid,$reviewtype,$meetlink,$fixdate){
        $query=$this->db->query("INSERT INTO allreview(plant, uid, bdid, meetid, reviewtype, fixdate) 
                                    VALUES ('$plandate','$uid','$bdid','$meetlink','$reviewtype','$fixdate')");
    }
    
    
    
    
    
    public function all_bdrremark($deletef,$patnertype,$topspender,$keyclient,$pkeyclient,$priorityclient,$upsellclient,$focusyclient,$rid,$inid,$bdid,$remark,$ntdate,$ntaction,$pstuid,$exsid,$exdate,$rtype,$taskupdate,$potential,$ans1,$ans2,$ans3,$ans4,$requeststatus,$csrbudget,$bdscholl){
        $tdatet= date('Y-m-d H:i:s');
        
        $query=$this->db->query("SELECT * FROM init_call where id='$inid'");
        $data = $query->result();
        $stid = $data[0]->cstatus;
        
        $query=$this->db->query("SELECT max(id) mid FROM tblcallevents where cid_id='$inid'");
        $data1 = $query->result();
        $mid = $data1[0]->mid;
        
        
        $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, fwd_date, appointmentdatetime, actiontype_id,purpose_id,remarks, assignedto_id, cid_id, status_id, user_id, date, updateddate,actontaken,purpose_achieved) 
        VALUES ('$mid', '$mid', '$tdatet', '$tdatet','8','127','$remark','$pstuid','$inid','$stid','$pstuid','$tdatet','$tdatet','yes','yes')");
        $ntid = $this->db->insert_id();
        
        
        if($rtype=='Roaster'){
            $this->db->query("INSERT INTO allreviewdata(pst, bdid, remark, rid, csid, inid, taskupdate) 
                                VALUES ('$pstuid','$bdid','$remark','$rid','$stid','$inid','$taskupdate')");
            
        }else{
            
        $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID,remarks,plan, fwd_date, appointmentdatetime, actiontype_id,purpose_id, assignedto_id, cid_id, status_id, user_id, date, updateddate) 
        VALUES ('0', '0','','1', '$ntdate', '$ntdate','$ntaction','127','$bdid','$inid','$stid','$bdid','$ntdate','$ntdate')");
        $ntid = $this->db->insert_id();
        
        
        $this->db->query("INSERT INTO allreviewdata(deletef,patnertype,topspender,keyclient,pkeyclient,priorityclient,upsellclient,focusyclient,pst, bdid, remark, ntid, exsid, exdate, rid, csid, inid, ans1, ans2, ans3, ans4, requeststatus, nschool, nrvenue, potential) 
                                       VALUES ('$deletef','$patnertype','$topspender','$keyclient','$pkeyclient','$priorityclient','$upsellclient','$focusyclient','$pstuid','$bdid','$remark','$ntid','$exsid','$exdate','$rid','$stid','$inid','$ans1','$ans2','$ans3','$ans4','$requeststatus','$nschool','$nrvenue','$potential')");
        }
        
        
        
        
        
        
        
        
        
    }
    
    
    public function all_pstrremark($deletef,$patnertype,$topspender,$keyclient,$pkeyclient,$priorityclient,$upsellclient,$focusyclient,$rid,$inid,$bdid,$remark,$ntdate,$ntaction,$pstuid,$exsid,$exdate,$rtype,$taskupdate,$ans1,$ans2,$ans3,$ans4,$requeststatus,$nschool,$nrvenue,$potential,$taskfor){
        $tdatet= date('Y-m-d H:i:s');
        
        $query=$this->db->query("SELECT * FROM init_call where id='$inid'");
        $data = $query->result();
        $stid = $data[0]->cstatus;
        
        $query=$this->db->query("SELECT max(id) mid FROM tblcallevents where cid_id='$inid'");
        $data1 = $query->result();
        $mid = $data1[0]->mid;
        
        
        $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID, fwd_date, appointmentdatetime, actiontype_id,purpose_id,remarks, assignedto_id, cid_id, status_id, user_id, date, updateddate,actontaken,purpose_achieved) 
        VALUES ('$mid', '$mid', '$tdatet', '$tdatet','8','127','$remark','$pstuid','$inid','$stid','$pstuid','$tdatet','$tdatet','yes','yes')");
        $ntid = $this->db->insert_id();
        
        
        if($rtype=='Roaster'){
            $this->db->query("INSERT INTO allreviewdata(pst, bdid, remark, rid, csid, inid, taskupdate) 
                                VALUES ('$pstuid','$bdid','$remark','$rid','$stid','$inid','$taskupdate')");
            
        }else{
            
        $this->db->query("INSERT INTO tblcallevents(lastCFID, nextCFID,remarks,plan, fwd_date, appointmentdatetime, actiontype_id,purpose_id, assignedto_id, cid_id, status_id, user_id, date, updateddate) 
        VALUES ('0', '0','','1', '$ntdate', '$ntdate','$ntaction','127','$bdid','$inid','$stid','$bdid','$ntdate','$ntdate')");
        $ntid = $this->db->insert_id();
        
        
        $this->db->query("INSERT INTO allreviewdata(deletef,patnertype,topspender,keyclient,pkeyclient,priorityclient,upsellclient,focusyclient,pst, bdid, remark, ntid, exsid, exdate, rid, csid, inid, ans1, ans2, ans3, ans4, requeststatus, nschool, nrvenue, potential) 
                                       VALUES ('$deletef','$patnertype','$topspender','$keyclient','$pkeyclient','$priorityclient','$upsellclient','$focusyclient','$pstuid','$bdid','$remark','$ntid','$exsid','$exdate','$rid','$stid','$inid','$ans1','$ans2','$ans3','$ans4','$requeststatus','$nschool','$nrvenue','$potential')");
        }
        
        
        
        
        
        
        
        
        
    }
    
    
    public function get_logdetail($inid,$fdate){
        $query=$this->db->query("SELECT * FROM tblcallevents WHERE cid_id='$inid' and cast(updateddate as DATE)>'$fdate' ORDER BY tblcallevents.id DESC");
        return $query->result();
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function get_cmpptd($inid){
        $query=$this->db->query("SELECT count(*) abc FROM tblcallevents where cid_id='$inid' and nextCFID='0'");
        return $query->result();
    }
    
    
    public function get_cmptd($inid,$fdate){
        $query=$this->db->query("SELECT count(*) ab, COUNT(CASE WHEN actiontype_id=1 THEN 1 END) a, COUNT(CASE WHEN actiontype_id=2 THEN 1 END) b, 
        COUNT(CASE WHEN actiontype_id=3 THEN 1 END) c,
        COUNT(CASE WHEN actiontype_id=4 THEN 1 END) d,
        COUNT(CASE WHEN actiontype_id=5 THEN 1 END) e,
        COUNT(CASE WHEN actiontype_id=6 THEN 1 END) f,
        COUNT(CASE WHEN actiontype_id=7 THEN 1 END) g,
        COUNT(CASE WHEN actiontype_id=8 THEN 1 END) h,
        COUNT(CASE WHEN actiontype_id=9 THEN 1 END) i,
        COUNT(CASE WHEN actiontype_id=10 THEN 1 END) j,
        COUNT(CASE WHEN actiontype_id=11 THEN 1 END) k,
        COUNT(CASE WHEN actiontype_id=12 THEN 1 END) l,
        COUNT(CASE WHEN actiontype_id=13 THEN 1 END) m,
        COUNT(CASE WHEN actiontype_id=14 THEN 1 END) n,
        COUNT(CASE WHEN actontaken='no' THEN 1 END) r,
        COUNT(CASE WHEN actontaken='yes' and purpose_achieved='no'  THEN 1 END) s,
        COUNT(CASE WHEN actontaken='yes' and purpose_achieved='yes'  THEN 1 END) t
        FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id WHERE init_call.id='$inid' and cast(updateddate as DATE)>'$fdate'");
        return $query->result();
    }
    
    
    public function get_cmpnlog($inid){
        $query=$this->db->query("SELECT *, company_master.id AS cid, init_call.id AS inid, init_call.cstatus AS sid, CASE WHEN init_call.topspender='yes' THEN 'TOP Spender' END AS cat1, CASE WHEN keycompany='yes' THEN 'Key Company' END AS cat1, CASE WHEN pkclient='yes' THEN 'Positive Key Client' END AS cat2, CASE WHEN priorityc='yes' THEN 'Priority Client' END AS cat3, CASE WHEN upsell_client='yes' THEN 'Upsell Client' END AS cat4, CASE WHEN focus_funnel='yes' THEN 'Focus Funnel' END AS cat5, partner_master.name AS pname, status.name AS csstatus FROM init_call LEFT JOIN company_master ON company_master.id = init_call.cmpid_id LEFT JOIN status ON status.id = init_call.cstatus LEFT JOIN partner_master ON partner_master.id = company_master.partnerType_id WHERE init_call.id = '$inid'");
        return $query->result();
    }
    
    
    
    
    public function get_taskstatuswisebwdall($uid,$sd,$ed){
        $query=$this->db->query("SELECT status.name stname,count(*) cont FROM tblcallevents LEFT JOIN status ON status.id=tblcallevents.status_id WHERE tblcallevents.cid_id IN (Select id from init_call WHERE init_call.mainbd='$uid') and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' Group By status.name");
        return $query->result();
    }
    
    
    
    public function get_taskstatuswisebwdanpn($uid,$sd,$ed){
        $query=$this->db->query("SELECT status.name stname,count(*) cont FROM tblcallevents LEFT JOIN status ON status.id=tblcallevents.status_id WHERE tblcallevents.cid_id IN (Select id from init_call WHERE init_call.mainbd='$uid') and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and actontaken='no' and purpose_achieved='no' Group By status.name");
        return $query->result();
    }
    
    
    public function get_taskstatuswisebwdaypn($uid,$sd,$ed){
        $query=$this->db->query("SELECT status.name stname,count(*) cont FROM tblcallevents LEFT JOIN status ON status.id=tblcallevents.status_id WHERE tblcallevents.cid_id IN (Select id from init_call WHERE init_call.mainbd='$uid') and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and actontaken='yes' and purpose_achieved='no' Group By status.name");
        return $query->result();
    }
    
    
    public function get_taskstatuswisebwdaypy($uid,$sd,$ed){
        $query=$this->db->query("SELECT status.name stname,count(*) cont FROM tblcallevents LEFT JOIN status ON status.id=tblcallevents.status_id WHERE tblcallevents.cid_id IN (Select id from init_call WHERE init_call.mainbd='$uid') and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and actontaken='yes' and purpose_achieved='yes' Group By status.name");
        return $query->result();
    }
    
    public function get_meetingtypewise($uid,$sd,$ed){
        $query=$this->db->query("SELECT remarks,count(*) cont FROM tblcallevents LEFT JOIN status ON status.id=tblcallevents.status_id WHERE remarks!='' and tblcallevents.cid_id IN (Select id from init_call WHERE init_call.mainbd='$uid') and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and (actiontype_id='4' or actiontype_id='3') Group By remarks");
        return $query->result();
    }
    
    
    public function get_actiontypewbwdap($uid,$sd,$ed,$ac){
        $query=$this->db->query("SELECT count(*) cont, Count(Case When actontaken='no' and purpose_achieved='no' Then 1 End) anpn, Count(Case When actontaken='yes' and purpose_achieved='no' Then 1 End) aypn, Count(Case When actontaken='yes' and purpose_achieved='yes' Then 1 End) aypy FROM tblcallevents WHERE user_id='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and actiontype_id='$ac'");
        return $query->result();
    }
    
    public function get_mywisetaskall($uid,$m,$y,$ac){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and nextCFID!='0' and Month(updateddate)='$m' and Year(updateddate)='$y' and actiontype_id='$ac'");
        return $query->result();
    }
    
    
    public function get_mywisetaskallbyf($uid,$m,$y,$ac,$inid){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE  Month(updateddate)='$m' and Year(updateddate)='$y' and actiontype_id='$ac' and tblcallevents.cid_id='$inid'");
        return $query->result();
    }
    
    public function get_mywisetaskallbyfanpn($uid,$m,$y,$ac,$inid){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE  nextCFID!='0' and Month(updateddate)='$m' and Year(updateddate)='$y' and actiontype_id='$ac' and tblcallevents.cid_id='$inid' and actontaken='no' and purpose_achieved='no'");
        return $query->result();
    }
    
    
    public function get_mywisetaskallbyfaypn($uid,$m,$y,$ac,$inid){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE  nextCFID!='0' and Month(updateddate)='$m' and Year(updateddate)='$y' and actiontype_id='$ac' and tblcallevents.cid_id='$inid' and actontaken='yes' and purpose_achieved='no'");
        return $query->result();
    }
    
    public function get_mywisetaskallbyfaypy($uid,$m,$y,$ac,$inid){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE  nextCFID!='0' and Month(updateddate)='$m' and Year(updateddate)='$y' and actiontype_id='$ac' and tblcallevents.cid_id='$inid' and actontaken='yes' and purpose_achieved='yes'");
        return $query->result();
    }
    
    
    public function get_tasktypeupdateanpn($uid,$sd,$ed,$ac){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and actiontype_id='$ac' and actontaken='no' and purpose_achieved='no'");
        return $query->result();
    }
    
    public function get_tasktypeupdatebysp($uid,$sd,$ed,$st){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and  cast(appointmentdatetime as DATE) BETWEEN '$sd' and '$ed' and status_id='$st' and plan='1'");
        return $query->result();
    }
    
    public function get_tasktypeupdatebysi($uid,$sd,$ed,$st){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and cast(initiateddt as DATE) BETWEEN '$sd' and '$ed' and status_id='$st' and plan='1'");
        return $query->result();
    }
    
    public function get_tasktypeupdatebysu($uid,$sd,$ed,$st){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and status_id='$st'");
        return $query->result();
    }
    
    
    public function get_tasktypeupdatebyap($uid,$sd,$ed,$ac){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and  cast(appointmentdatetime as DATE) BETWEEN '$sd' and '$ed' and actiontype_id='$ac' and plan='1'");
        return $query->result();
    }
    
    public function get_tasktypeupdatebyai($uid,$sd,$ed,$ac){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and cast(initiateddt as DATE) BETWEEN '$sd' and '$ed' and actiontype_id='$ac' and plan='1'");
        return $query->result();
    }
    
    public function get_tasktypeupdatebyau($uid,$sd,$ed,$ac){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and actiontype_id='$ac'");
        return $query->result();
    }
    
    public function get_tasktypepending($uid,$sd,$ed,$ac){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and nextCFID='0' and cast(appointmentdatetime as DATE) BETWEEN '$sd' and '$ed' and actiontype_id='$ac' and plan='1'");
        return $query->result();
    }
    
    public function get_tasktypeupdatebyauaypy($uid,$sd,$ed,$ac){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and actiontype_id='$ac' and actontaken='yes' and purpose_achieved='yes'");
        return $query->result();
    }
    
    public function get_tasktypeupdatebyauaypn($uid,$sd,$ed,$ac){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and actiontype_id='$ac' and actontaken='Yes' and purpose_achieved='no'");
        return $query->result();
    }
    
    public function get_tasktypeupdatebyauanpn($uid,$sd,$ed,$ac){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and actiontype_id='$ac' and actontaken='no' and purpose_achieved='no'");
        return $query->result();
    }
    
    
    public function get_tasktypeconvstion($uid,$sd,$ed,$ac){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and actiontype_id='$ac' and status_id!=nstatus_id");
        return $query->result();
    }
    
    
    public function get_tasktypeconvstionbys($uid,$sd,$ed,$ac,$st){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and actiontype_id='$ac' and status_id!=nstatus_id and nstatus_id='$st'");
        return $query->result();
    }
    
    
    public function get_tasktypeconvstionsbyother($uid,$sd,$ed,$st){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents left join init_call on init_call.id=tblcallevents.cid_id WHERE init_call.mainbd='$uid' and user_id!='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and status_id='$st'");
        return $query->result();
    }
    
    
    public function get_tasktypeconvstionsbyothers($uid,$sd,$ed,$st,$stt){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents left join init_call on init_call.id=tblcallevents.cid_id WHERE init_call.mainbd='$uid' and user_id!='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and status_id='$st' and status_id!=nstatus_id and nstatus_id='$stt'");
        return $query->result();
    }
    
    
    public function get_tasktypeconvstions($uid,$sd,$ed,$st){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and status_id='$st'");
        return $query->result();
    }
    
    
    public function get_tasktypeconvstionsbys($uid,$sd,$ed,$st,$stt){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and status_id='$st' and status_id!=nstatus_id and nstatus_id='$stt'");
        return $query->result();
    }
    
    
    public function get_tasktypenextdplan($uid,$sd,$ed,$ac){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and cast(appointmentdatetime as DATE) BETWEEN '$sd' and '$ed' and actiontype_id='$ac' and plan='1'");
        return $query->result();
    }
    
    public function get_tasktypenextdplanbys($uid,$sd,$ed,$ac,$st){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and cast(appointmentdatetime as DATE) BETWEEN '$sd' and '$ed' and actiontype_id='$ac' and plan='1' and status_id='$st'");
        return $query->result();
    }
    
    public function get_tasktypenextdplanwt($uid,$sd,$ed,$ac){
        $query=$this->db->query("SELECT count(*)*(SELECT action.yest FROM action WHERE action.id='$ac') time FROM tblcallevents WHERE user_id='$uid' and cast(appointmentdatetime as DATE) BETWEEN '$sd' and '$ed' and actiontype_id='$ac' and plan='1'");
        return $query->result();
    }
    
    
    
    public function get_autotasktypeupdatebytp($uid,$sd,$ed,$t1,$t2){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and  cast(appointmentdatetime as DATE) BETWEEN '$sd' and '$ed' and cast(appointmentdatetime as TIME) BETWEEN '$t1' and '$t2' and plan='1' and autotask='1'");
        return $query->result();
    }
    
    public function get_autotasktypeupdatebyti($uid,$sd,$ed,$t1,$t2){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and cast(initiateddt as DATE) BETWEEN '$sd' and '$ed' and  cast(initiateddt as TIME) BETWEEN '$t1' and '$t2' and plan='1' and autotask='1'");
        return $query->result();
    }
    
    public function get_autotasktypeupdatebytu($uid,$sd,$ed,$t1,$t2){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and cast(updateddate as TIME) BETWEEN '$t1' and '$t2' and autotask='1'");
        return $query->result();
    }
    
    
    
    public function get_tasktypeupdatebytp($uid,$sd,$ed,$t1,$t2){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and  cast(appointmentdatetime as DATE) BETWEEN '$sd' and '$ed' and cast(appointmentdatetime as TIME) BETWEEN '$t1' and '$t2' and plan='1'");
        return $query->result();
    }
    
    public function get_tasktypeupdatebyti($uid,$sd,$ed,$t1,$t2){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and cast(initiateddt as DATE) BETWEEN '$sd' and '$ed' and  cast(initiateddt as TIME) BETWEEN '$t1' and '$t2' and plan='1'");
        return $query->result();
    }
    
    public function get_tasktypeupdatebytu($uid,$sd,$ed,$t1,$t2){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and cast(updateddate as TIME) BETWEEN '$t1' and '$t2' ");
        return $query->result();
    }
    
    
    public function get_tasktypeupdate($uid,$sd,$ed,$ac){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and actiontype_id='$ac'");
        return $query->result();
    }
    
    public function get_tasktypeupdatewstar($uid,$sd,$ed,$ac,$j){
        $query=$this->db->query("SELECT count(case when star='$j' then 1 end) cont FROM tblcallevents WHERE user_id='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and actiontype_id='$ac'");
        return $query->result();
    }
    
    
    public function get_tasktypeupdatereview($uid,$sd,$ed,$ac){
        $query=$this->db->query("SELECT count(case WHEN rremark is not null then 1 END) dreview, count(case WHEN rremark is null then 1 END) nreview FROM tblcallevents WHERE user_id='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and actiontype_id='$ac'");
        return $query->result();
    }
    
    
    public function get_tasktypeupdateaypn($uid,$sd,$ed,$ac){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and actiontype_id='$ac' and actontaken='yes' and purpose_achieved='no'");
        return $query->result();
    }
    
    public function get_tasktypeupdatestatusanpn($uid,$sd,$ed,$st,$ac){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and actiontype_id='$ac' and status_id='$st'  and actontaken='no' and purpose_achieved='no'");
        return $query->result();
    }
    
    public function get_tasktypeupdatestatusaypn($uid,$sd,$ed,$st,$ac){
        $query=$this->db->query("SELECT count(*) cont FROM tblcallevents WHERE user_id='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' and actiontype_id='$ac' and status_id='$st'  and actontaken='yes' and purpose_achieved='no'");
        return $query->result();
    }
    
    
    
    public function get_taskubyacaypy($uid,$m,$y,$ac){
        $query=$this->db->query("SELECT COUNT(*) cont,action.name acname FROM tblcallevents  LEFT JOIN action on action.id=tblcallevents.actiontype_id WHERE user_id='$uid' and nextCFID!='0' and Month(updateddate)='$m' and Year(updateddate)='$y' and actiontype_id='$ac' and actontaken='yes' and purpose_achieved='yes' group by action.name");
        return $query->result();
    }
    
    public function get_taskubystaypy($uid,$m,$y,$st,$ac){
        $query=$this->db->query("SELECT COUNT(*) cont,status.name stname FROM tblcallevents  LEFT JOIN status on status.id=tblcallevents.status_id WHERE user_id='$uid' and nextCFID!='0' and Month(updateddate)='$m' and Year(updateddate)='$y' and status_id='$st' and actiontype_id='$ac' and actontaken='yes' and purpose_achieved='yes' group by status.name");
        return $query->result();
    }
    
    
    
    public function get_taskubyacaypn($uid,$m,$y,$ac){
        $query=$this->db->query("SELECT COUNT(*) cont,action.name acname FROM tblcallevents  LEFT JOIN action on action.id=tblcallevents.actiontype_id WHERE user_id='$uid' and nextCFID!='0' and Month(updateddate)='$m' and Year(updateddate)='$y' and actiontype_id='$ac' and actontaken='yes' and purpose_achieved='no' group by action.name");
        return $query->result();
    }
    
    
    public function get_taskubystaypn($uid,$m,$y,$st,$ac){
        $query=$this->db->query("SELECT COUNT(*) cont,status.name stname FROM tblcallevents  LEFT JOIN status on status.id=tblcallevents.status_id WHERE user_id='$uid' and nextCFID!='0' and Month(updateddate)='$m' and Year(updateddate)='$y' and status_id='$st' and actiontype_id='$ac' and actontaken='yes' and purpose_achieved='no' group by status.name");
        return $query->result();
    }
    
    
    public function get_taskubyacanpn($uid,$m,$y,$ac){
        $query=$this->db->query("SELECT COUNT(*) cont,action.name acname FROM tblcallevents  LEFT JOIN action on action.id=tblcallevents.actiontype_id WHERE user_id='$uid' and nextCFID!='0' and Month(updateddate)='$m' and Year(updateddate)='$y' and actiontype_id='$ac' and actontaken='no' and purpose_achieved='no' group by action.name");
        return $query->result();
    }
    
    public function get_taskubystanpn($uid,$m,$y,$st,$ac){
        $query=$this->db->query("SELECT COUNT(*) cont,status.name stname FROM tblcallevents  LEFT JOIN status on status.id=tblcallevents.status_id WHERE user_id='$uid' and nextCFID!='0' and Month(updateddate)='$m' and Year(updateddate)='$y' and status_id='$st' and actiontype_id='$ac' and actontaken='no' and purpose_achieved='no' group by status.name");
        return $query->result();
    }
    
    
    
    public function get_taskPendingbya($uid,$m,$y,$ac){
        $query=$this->db->query("SELECT COUNT(*) cont,action.name acname FROM tblcallevents  LEFT JOIN action on action.id=tblcallevents.actiontype_id WHERE user_id='$uid' and plan='0' and Month(updateddate)='$m' and Year(updateddate)='$y' and actiontype_id='$ac' group by action.name");
        return $query->result();
    }
    
    public function get_taskPendingbys($uid,$m,$y,$st,$ac){
        $query=$this->db->query("SELECT COUNT(*) cont,status.name stname FROM tblcallevents  LEFT JOIN status on status.id=tblcallevents.status_id WHERE user_id='$uid' and plan='0' and Month(updateddate)='$m' and Year(updateddate)='$y' and status_id='$st' and actiontype_id='$ac' group by status.name");
        return $query->result();
    }
    
    
    
    
    public function get_taskremarkwise($uid,$sd,$ed){
        $query=$this->db->query("SELECT COUNT(*) cont,remarks FROM tblcallevents  LEFT JOIN action on action.id=tblcallevents.actiontype_id WHERE user_id='$uid' and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' group by remarks");
        return $query->result();
    }
    
    
    public function get_timeslot(){
        $query=$this->db->query("SELECT * FROM timeslot");
        return $query->result();
    }
    
    
    public function get_bdrtype(){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT DISTINCT `request_type` FROM bdrequest");
        return $query->result();
    }
    
    
    public function get_nhprocess(){
        $query=$this->db->query("SELECT DISTINCT mtask.tmane FROM mtask LEFT JOIN mstask ON mstask.mtid=mtask.tid WHERE mtask.tid BETWEEN 3 AND 11");
        return $query->result();
    }
    
    
    public function get_spdtargetvex($i){
        $db3 = $this->load->database('db3', TRUE);
        if($i=='0'){
        $query=$db3->query("SELECT COUNT(sid) traget, COUNT( (SELECT DISTINCT sid FROM plantask LEFT join task_assign ON task_assign.id=plantask.taskid WHERE plantask.spd_id = schooltimeline.sid AND task_assign.task_subtype='Upload M&E Report' AND CAST(donet AS DATE) < NOW())) done FROM schooltimeline WHERE elmne < NOW();");
            return $query->result();
        }
        
        if($i=='1'){
        $query=$db3->query("SELECT COUNT(sid) traget, COUNT( (SELECT DISTINCT sid FROM plantask LEFT join task_assign ON task_assign.id=plantask.taskid WHERE plantask.spd_id = schooltimeline.sid AND task_assign.task_subtype='Upload M&E Report' AND CAST(donet AS DATE) < NOW())) done FROM schooltimeline WHERE elmne < NOW();");
            return $query->result();
        }
        
        if($i=='2'){
        $query=$db3->query("SELECT COUNT(sid) traget, COUNT( (SELECT DISTINCT sid FROM plantask LEFT join task_assign ON task_assign.id=plantask.taskid WHERE plantask.spd_id = schooltimeline.sid AND task_assign.task_subtype='Upload FTTP Report' AND CAST(donet AS DATE) < NOW())) done FROM schooltimeline WHERE elmne < NOW();");
            return $query->result();
        }
        
        if($i=='3'){
        $query=$db3->query("SELECT COUNT(sid) traget, COUNT( (SELECT DISTINCT sid FROM plantask LEFT join task_assign ON task_assign.id=plantask.taskid WHERE plantask.spd_id = schooltimeline.sid AND task_assign.task_subtype='Upload RTTP Report' AND CAST(donet AS DATE) < NOW())) done FROM schooltimeline WHERE elmne < NOW();");
            return $query->result();
        }
        
        if($i=='4'){
        $query=$db3->query("SELECT COUNT(sid) traget, COUNT( (SELECT DISTINCT sid FROM plantask LEFT join task_assign ON task_assign.id=plantask.taskid WHERE plantask.spd_id = schooltimeline.sid AND task_assign.task_subtype='Upload M&E Report' AND CAST(donet AS DATE) < NOW())) done FROM schooltimeline WHERE elmne < NOW();");
            return $query->result();
        }
        
        if($i=='5'){
        $query=$db3->query("SELECT COUNT(sid) traget, COUNT( (SELECT DISTINCT sid FROM plantask LEFT join task_assign ON task_assign.id=plantask.taskid WHERE plantask.spd_id = schooltimeline.sid AND task_assign.task_subtype='Upload M&E Report' AND CAST(donet AS DATE) < NOW())) done FROM schooltimeline WHERE elmne < NOW();");
            return $query->result();
        }
        
        if($i=='6'){
        $query=$db3->query("SELECT COUNT(sid) traget, COUNT( (SELECT DISTINCT sid FROM plantask LEFT join task_assign ON task_assign.id=plantask.taskid WHERE plantask.spd_id = schooltimeline.sid AND task_assign.task_subtype='Upload M&E Report' AND CAST(donet AS DATE) < NOW())) done FROM schooltimeline WHERE elmne < NOW();");
            return $query->result();
        }
        
        if($i=='7'){
        $query=$db3->query("SELECT COUNT(sid) traget, COUNT( (SELECT DISTINCT sid FROM plantask LEFT join task_assign ON task_assign.id=plantask.taskid WHERE plantask.spd_id = schooltimeline.sid AND task_assign.task_subtype='Upload M&E Report' AND CAST(donet AS DATE) < NOW())) done FROM schooltimeline WHERE elmne < NOW();");
            return $query->result();
        }
        
        if($i=='8'){
        $query=$db3->query("SELECT COUNT(sid) traget, COUNT( (SELECT DISTINCT sid FROM plantask LEFT join task_assign ON task_assign.id=plantask.taskid WHERE plantask.spd_id = schooltimeline.sid AND task_assign.task_subtype='Upload DIY Report' AND CAST(donet AS DATE) < NOW())) done FROM schooltimeline WHERE diy < NOW();");
            return $query->result();
        }
        if($i=='9'){
        $query=$db3->query("SELECT COUNT(sid) traget, COUNT( (SELECT DISTINCT sid FROM plantask LEFT join task_assign ON task_assign.id=plantask.taskid WHERE plantask.spd_id = schooltimeline.sid AND task_assign.task_subtype='Upload M&E Report' AND CAST(blmne AS DATE) < NOW())) done FROM schooltimeline WHERE elmne < NOW();");
            return $query->result();
        }
        
        if($i=='10'){
        $query=$db3->query("SELECT COUNT(sid) traget, COUNT( (SELECT DISTINCT sid FROM plantask LEFT join task_assign ON task_assign.id=plantask.taskid WHERE plantask.spd_id = schooltimeline.sid AND task_assign.task_subtype='Upload M&E Report' AND CAST(elmne AS DATE) < NOW())) done FROM schooltimeline WHERE elmne < NOW();");
            return $query->result();
        }
        
        if($i=='11'){
        $query=$db3->query("SELECT COUNT(sid) traget, COUNT( (SELECT DISTINCT sid FROM plantask LEFT join task_assign ON task_assign.id=plantask.taskid WHERE plantask.spd_id = schooltimeline.sid AND action='utilisation' AND CAST(utilisation AS DATE) < NOW())) done FROM schooltimeline WHERE elmne < NOW();");
            return $query->result();
        }
    }
    
    
    
    
    public function get_bdrmodel($uid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT replacereq.model_name, COUNT(*) cont FROM replacereq LEFT join spd ON spd.id=replacereq.sid LEFT join client_handover ON client_handover.projectcode=spd.project_code WHERE replacereq.status='Open' and client_handover.bd_id='$uid' GROUP BY replacereq.model_name ORDER BY `cont` DESC");
        return $query->result();
    }
    
    
    public function get_bdrmodelatype($uid,$model,$rt){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT COUNT(*) cont FROM replacereq LEFT join spd ON spd.id=replacereq.sid LEFT join client_handover ON client_handover.projectcode=spd.project_code WHERE replacereq.status='Open' and client_handover.bd_id='$uid' and replacereq.model_name='$model' and replacereq.type='$rt'");
        return $query->result();
    }
    
    
    public function get_bdrbytype($uid,$rtype){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT count(*) cont FROM bdrequest where bd_id='$uid' and request_type='$rtype'");
        return $query->result();
    }
    
    
    
    
    public function get_bdrbybdid($uid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("select *,(SELECT GROUP_CONCAT(user_detail.fullname) from bdtask LEFT JOIN user_detail ON user_detail.id=bdtask.uid WHERE bdtask.tid=bdrequest.id) pia from bdrequest where request_type='School Identification' and bd_id='$uid' ORDER BY bdrequest.sdatet DESC");
        return $query->result();
    }
    
    public function get_riddaywise($uid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT CASE WHEN DATEDIFF(CURDATE(), replacereq.sdatet) < 5 THEN 'Less than 5 days' WHEN DATEDIFF(CURDATE(), replacereq.sdatet) = 5 THEN '5 days' WHEN DATEDIFF(CURDATE(), replacereq.sdatet) <= 10 THEN '10 days' WHEN DATEDIFF(CURDATE(), replacereq.sdatet) <= 20 THEN '20 days' WHEN DATEDIFF(CURDATE(), replacereq.sdatet) <= 30 THEN '30 days' WHEN DATEDIFF(CURDATE(), replacereq.sdatet) <= 60 THEN '60 days' WHEN DATEDIFF(CURDATE(), replacereq.sdatet) <= 120 THEN '120 days' WHEN DATEDIFF(CURDATE(), replacereq.sdatet) <= 180 THEN '180 days' ELSE 'More than 180 days' END AS day_category, COUNT(*) AS cont FROM replacereq LEFT JOIN spd ON spd.id = replacereq.sid LEFT JOIN client_handover ON client_handover.projectcode = spd.project_code WHERE client_handover.bd_id = '$uid' AND replacereq.status = 'Open' GROUP BY day_category");
        return $query->result();
    }
    
    
    public function get_ridcdaywise($uid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT CASE WHEN DATEDIFF(CURDATE(), replacereq.sdatet) < 5 THEN 'Less than 5 days' WHEN DATEDIFF(CURDATE(), replacereq.sdatet) = 5 THEN '5 days' WHEN DATEDIFF(CURDATE(), replacereq.sdatet) <= 10 THEN '10 days' WHEN DATEDIFF(CURDATE(), replacereq.sdatet) <= 20 THEN '20 days' WHEN DATEDIFF(CURDATE(), replacereq.sdatet) <= 30 THEN '30 days' WHEN DATEDIFF(CURDATE(), replacereq.sdatet) <= 60 THEN '60 days' WHEN DATEDIFF(CURDATE(), replacereq.sdatet) <= 120 THEN '120 days' WHEN DATEDIFF(CURDATE(), replacereq.sdatet) <= 180 THEN '180 days' ELSE 'More than 180 days' END AS day_category, COUNT(*) AS cont FROM replacereq LEFT JOIN spd ON spd.id = replacereq.sid LEFT JOIN client_handover ON client_handover.projectcode = spd.project_code WHERE client_handover.bd_id = '$uid' AND replacereq.status = 'Close' GROUP BY day_category");
        return $query->result();
    }
    
    
    public function get_ridfhndone($uid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT COUNT(*) as total_entries, SUM(CASE WHEN subquery.open_count > 0 AND subquery.close_count > 0 THEN 1 ELSE 0 END) as both_open_and_close, SUM(CASE WHEN subquery.open_count > 0 AND subquery.close_count = 0 THEN 1 ELSE 0 END) as open_count_not_closed, SUM(CASE WHEN subquery.open_count = 0 THEN 1 ELSE 0 END) as open_count_zero FROM ( SELECT COUNT(*) as total, COUNT(CASE WHEN replacereq.status='Open' THEN 1 END) as open_count, COUNT(CASE WHEN replacereq.status='Close' THEN 1 END) as close_count FROM replacereq LEFT join spd ON spd.id=replacereq.sid LEFT join client_handover ON client_handover.projectcode=spd.project_code WHERE type!='Repaired' and client_handover.bd_id='100087' GROUP BY tid ) as subquery");
        return $query->result();
    }
    
    public function get_BDridcdaywise($uid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT CASE WHEN DATEDIFF(CURDATE(), bdrequest.sdatet) < 5 THEN 'Less than 5 days' WHEN DATEDIFF(CURDATE(), bdrequest.sdatet) = 5 THEN '5 days' WHEN DATEDIFF(CURDATE(), bdrequest.sdatet) <= 10 THEN '10 days' WHEN DATEDIFF(CURDATE(), bdrequest.sdatet) <= 20 THEN '20 days' WHEN DATEDIFF(CURDATE(), bdrequest.sdatet) <= 30 THEN '30 days' WHEN DATEDIFF(CURDATE(), bdrequest.sdatet) <= 60 THEN '60 days' WHEN DATEDIFF(CURDATE(), bdrequest.sdatet) <= 120 THEN '120 days' WHEN DATEDIFF(CURDATE(), bdrequest.sdatet) <= 180 THEN '180 days' ELSE 'More than 180 days' END AS day_category, COUNT(*) AS cont FROM bdrequest WHERE bdrequest.status = '1' and bd_id='$uid' GROUP BY day_category");
        return $query->result();
    }
    
    
    public function get_mrspdbys($uid){
        $query=$this->db->query("SELECT * FROM user_details WHERE user_id='$uid'");
        $data = $query->result();
        $state = $data[0]->state;
        
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("Select status.name sname, count(*) cont from spd left join status on status.id=spd.status where sstate='$state' group by status.name");
        return $query->result();
    }
    
    public function get_mrprojectbys($uid){
        
        $query=$this->db->query("SELECT * FROM user_details WHERE user_id='$uid'");
        $data = $query->result();
        $state = $data[0]->state;
        
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT pstatus.name psname, COUNT(*) cont FROM client_handover LEFT join pstatus ON pstatus.id=client_handover.pstatus WHERE projectcode IN (Select DISTINCT project_code from spd left join status on status.id=spd.status where sstate='$state') GROUP BY pstatus.name");
        return $query->result();
    }
    
    public function get_mrppvsmp($uid){
        
        $query=$this->db->query("SELECT * FROM user_details WHERE user_id='$uid'");
        $data = $query->result();
        $state = $data[0]->state;
        
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT COUNT(case when client_handover.bd_id='$uid' then 1 end) mpcont, COUNT(case when client_handover.bd_id!='$uid' then 1 end) opcont FROM client_handover WHERE projectcode IN (Select DISTINCT project_code from spd left join status on status.id=spd.status where sstate='$state')");
        return $query->result();
    }
    
    
    public function get_mrospdvsmspd($uid){
        
        $query=$this->db->query("SELECT * FROM user_details WHERE user_id='$uid'");
        $data = $query->result();
        $state = $data[0]->state;
        
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("Select COUNT(case when client_handover.bd_id='$uid' then 1 end) mscont, COUNT(case when client_handover.bd_id!='$uid' then 1 end) oscont from spd left join client_handover on client_handover.projectcode=spd.project_code where sstate='$state'");
        return $query->result();
    }
    
    
    
    public function get_mrspdstatus($uid){
        
        $query=$this->db->query("SELECT * FROM user_details WHERE user_id='$uid'");
        $data = $query->result();
        $state = $data[0]->state;
        
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("Select status.name sname,status.id sid from spd left join status on status.id=spd.status where sstate='$state' group by status.name,status.id");
        return $query->result();
    }
    
    public function get_myspdbystid($uid,$stid){
        $query=$this->db->query("SELECT * FROM user_details WHERE user_id='$uid'");
        $data = $query->result();
        $state = $data[0]->state;
        
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("Select count(case when client_handover.bd_id!='$uid' then 1 end) oscont, count(case when client_handover.bd_id='$uid' then 1 end) mscont from spd left join client_handover on client_handover.projectcode=spd.project_code where sstate='$state' and spd.status='$stid'");
        return $query->result();
    }
    
    
    public function get_mrspdyear($uid){
        
        $query=$this->db->query("SELECT * FROM user_details WHERE user_id='$uid'");
        $data = $query->result();
        $state = $data[0]->state;
        
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("Select client_handover.project_year pyear from spd left join client_handover on client_handover.projectcode=spd.project_code where sstate='$state' group by client_handover.project_year");
        return $query->result();
    }
    
    
    
    public function get_myspdbyyear($uid,$pyear){
        $query=$this->db->query("SELECT * FROM user_details WHERE user_id='$uid'");
        $data = $query->result();
        $state = $data[0]->state;
        
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("Select count(case when client_handover.bd_id!='$uid' then 1 end) oscont, count(case when client_handover.bd_id='$uid' then 1 end) mscont from spd left join client_handover on client_handover.projectcode=spd.project_code where sstate='$state' and client_handover.project_year='$pyear'");
        return $query->result();
    }
    
    
    public function get_myprojectbyyear($uid,$pyear){
        $query=$this->db->query("SELECT * FROM user_details WHERE user_id='$uid'");
        $data = $query->result();
        $state = $data[0]->state;
        
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("Select count(case when client_handover.bd_id!='$uid' then 1 end) oscont, count(case when client_handover.bd_id='$uid' then 1 end) mscont from client_handover where client_handover.project_year='$pyear' and projectcode IN (Select DISTINCT project_code from spd where sstate='$state')");
        return $query->result();
    }
    
    
    
    
    
    public function get_mravguti($uid){
        $query=$this->db->query("SELECT * FROM user_details WHERE user_id='$uid'");
        $data = $query->result();
        $state = $data[0]->state;
        
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT ROUND(SUM(CASE WHEN client_handover.bd_id='$uid' THEN 1 ELSE 0 END) / COUNT(DISTINCT CASE WHEN client_handover.bd_id='$uid' THEN wgdata.sid END)) AS mavguti, ROUND(SUM(CASE WHEN client_handover.bd_id!='$uid' THEN 1 ELSE 0 END) / COUNT(DISTINCT CASE WHEN client_handover.bd_id!='$uid' THEN wgdata.sid END)) AS oavguti FROM wgdata LEFT JOIN client_handover ON client_handover.projectcode=wgdata.project_code WHERE type = 'Utilisation' AND CAST(wgdata.sdatet AS DATE) BETWEEN '2023-04-01' AND '2024-03-31' AND project_code IN (SELECT DISTINCT project_code FROM spd WHERE sstate='$state');");
        return $query->result();
    }
    
    
    public function get_mravgutimonthwise($uid,$m,$y){
        $query=$this->db->query("SELECT * FROM user_details WHERE user_id='$uid'");
        $data = $query->result();
        $state = $data[0]->state;
        
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT (SELECT COUNT(*) FROM wgdata LEFT JOIN client_handover ON client_handover.projectcode = wgdata.project_code WHERE type = 'Utilisation' AND MONTH(wgdata.sdatet) = '$m' AND YEAR(wgdata.sdatet) = '$y' AND CAST(wgdata.sdatet AS DATE) BETWEEN '2023-04-01' AND '2024-03-31' AND project_code IN (SELECT DISTINCT project_code FROM spd WHERE sstate = 'Chhattisgarh') AND client_handover.bd_id = '$uid') AS mavguti, (SELECT COUNT(*) FROM wgdata LEFT JOIN client_handover ON client_handover.projectcode = wgdata.project_code WHERE type = 'Utilisation' AND MONTH(wgdata.sdatet) = '$m' AND YEAR(wgdata.sdatet) = '$y' AND CAST(wgdata.sdatet AS DATE) BETWEEN '2023-04-01' AND '2024-03-31' AND project_code IN (SELECT DISTINCT project_code FROM spd WHERE sstate = 'Chhattisgarh') AND client_handover.bd_id != '$uid') AS oavguti");
        return $query->result();
    }
    
    
    
    
    
    
    
    public function get_bdrponnew($uid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT COUNT(CASE WHEN onnew='1' THEN 1 END) onborded, COUNT(CASE WHEN onnew='2' THEN 1 END) newclient FROM bdrequest where bd_id='$uid' GROUP BY bd_name");
        return $query->result();
    }
    
    
    
    
    public function get_bdrbytypeandstage($uid,$rtype,$j){
        $db3 = $this->load->database('db3', TRUE);
        
        if($j==0){
            $query=$db3->query("SELECT COUNT(*) cont FROM bdrequest WHERE bd_id = '$uid' AND request_type = '$rtype' AND id NOT IN (SELECT tid FROM bdtask)");
            return $query->result();
        }
        
        if($j==1){
            $query=$db3->query("SELECT COUNT(DISTINCT tid) cont FROM bdtask WHERE tid IN (SELECT bdrequest.id FROM bdrequest where bd_id='$uid' and request_type='$rtype') and startt is null");
            return $query->result();
        }
        if($j==2){
            $query=$db3->query("SELECT COUNT(DISTINCT tid) cont FROM bdtask WHERE tid IN (SELECT bdrequest.id FROM bdrequest where bd_id='$uid' and request_type='$rtype') and startt is not null and closet is null");
            return $query->result();
        }
        if($j==3){
            $query=$db3->query("SELECT COUNT(*) cont FROM `bdrequest` WHERE id IN (SELECT DISTINCT tid FROM bdtask WHERE tid IN ( SELECT bdrequest.id FROM bdrequest WHERE bd_id='$uid' AND request_type='$rtype' ) AND startt IS NOT NULL AND closet IS NOT NULL) and status='0'");
            return $query->result();
        }
        
        
        
    }
    
    
    
    
    
    
    public function get_timewtplanac($uid, $sd, $ed, $t1, $t2, $ac) {
    $query = $this->db->query("SELECT COUNT(*) cont, action.name acname FROM tblcallevents 
                               LEFT JOIN action ON action.id = tblcallevents.actiontype_id 
                               WHERE user_id = ? AND plan = '1' AND 
                                     (cast(appointmentdatetime as TIME) BETWEEN ? AND ?) AND 
                                     (cast(appointmentdatetime as DATE) BETWEEN ? AND ?) AND 
                                     actiontype_id = ? 
                               GROUP BY action.name", array($uid, $t1, $t2, $sd, $ed, $ac));
    return $query->result();
}

public function get_timewtplanacst($uid, $sd, $ed, $t1, $t2, $st, $ac) {
    $query = $this->db->query("SELECT COUNT(*) cont, status.name stname FROM tblcallevents 
                               LEFT JOIN status ON status.id = tblcallevents.status_id 
                               WHERE user_id = ? AND plan = '1' AND 
                                     (cast(appointmentdatetime as TIME) BETWEEN ? AND ?) AND 
                                     (cast(appointmentdatetime as DATE) BETWEEN ? AND ?) AND 
                                     status_id = ? AND actiontype_id = ? 
                               GROUP BY status.name", array($uid, $t1, $t2, $sd, $ed, $st, $ac));
    return $query->result();
}



public function get_timewtiniac($uid, $sd, $ed, $t1, $t2, $ac) {
    $query = $this->db->query("SELECT COUNT(*) cont, action.name acname FROM tblcallevents 
                               LEFT JOIN action ON action.id = tblcallevents.actiontype_id 
                               WHERE user_id = ? AND plan = '1' AND 
                                     (cast(initiateddt as TIME) BETWEEN ? AND ?) AND 
                                     (cast(initiateddt as DATE) BETWEEN ? AND ?) AND 
                                     actiontype_id = ? 
                               GROUP BY action.name", array($uid, $t1, $t2, $sd, $ed, $ac));
    return $query->result();
}

public function get_timewtiniacst($uid, $sd, $ed, $t1, $t2, $st, $ac) {
    $query = $this->db->query("SELECT COUNT(*) cont, status.name stname FROM tblcallevents 
                               LEFT JOIN status ON status.id = tblcallevents.status_id 
                               WHERE user_id = ? AND plan = '1' AND 
                                     (cast(initiateddt as TIME) BETWEEN ? AND ?) AND 
                                     (cast(initiateddt as DATE) BETWEEN ? AND ?) AND 
                                     status_id = ? AND actiontype_id = ? 
                               GROUP BY status.name", array($uid, $t1, $t2, $sd, $ed, $st, $ac));
    return $query->result();
}



public function get_timewtupac($uid, $sd, $ed, $t1, $t2, $ac) {
    $query = $this->db->query("SELECT COUNT(*) cont, action.name acname FROM tblcallevents 
                               LEFT JOIN action ON action.id = tblcallevents.actiontype_id 
                               WHERE user_id = ? AND plan = '1' AND 
                                     (cast(updateddate as TIME) BETWEEN ? AND ?) AND 
                                     (cast(updateddate as DATE) BETWEEN ? AND ?) AND 
                                     actiontype_id = ? 
                               GROUP BY action.name", array($uid, $t1, $t2, $sd, $ed, $ac));
    return $query->result();
}

public function get_timewtupacst($uid, $sd, $ed, $t1, $t2, $st, $ac) {
    $query = $this->db->query("SELECT COUNT(*) cont, status.name stname FROM tblcallevents 
                               LEFT JOIN status ON status.id = tblcallevents.status_id 
                               WHERE user_id = ? AND plan = '1' AND 
                                     (cast(updateddate as TIME) BETWEEN ? AND ?) AND 
                                     (cast(updateddate as DATE) BETWEEN ? AND ?) AND 
                                     status_id = ? AND actiontype_id = ? 
                               GROUP BY status.name", array($uid, $t1, $t2, $sd, $ed, $st, $ac));
    return $query->result();
}






public function get_timewtpbteac($uid, $sd, $ed, $t1, $t2, $ac) {
    $query = $this->db->query("SELECT COUNT(*) cont, action.name acname FROM tblcallevents 
                               LEFT JOIN action ON action.id = tblcallevents.actiontype_id 
                               WHERE user_id = ? AND plan = '1' AND nextCFID='0' AND 
                                     (cast(updateddate as TIME) BETWEEN ? AND ?) AND 
                                     (cast(updateddate as DATE) BETWEEN ? AND ?) AND 
                                     actiontype_id = ? 
                               GROUP BY action.name", array($uid, $t1, $t2, $sd, $ed, $ac));
    return $query->result();
}

public function get_timewtpbteacst($uid, $sd, $ed, $t1, $t2, $st, $ac) {
    $query = $this->db->query("SELECT COUNT(*) cont, status.name stname FROM tblcallevents 
                               LEFT JOIN status ON status.id = tblcallevents.status_id 
                               WHERE user_id = ? AND plan = '1' AND nextCFID='0' AND
                                     (cast(updateddate as TIME) BETWEEN ? AND ?) AND 
                                     (cast(updateddate as DATE) BETWEEN ? AND ?) AND 
                                     status_id = ? AND actiontype_id = ? 
                               GROUP BY status.name", array($uid, $t1, $t2, $sd, $ed, $st, $ac));
    return $query->result();
}


public function get_avgtaskparday($uid,$sd,$ed) {
    $query = $this->db->query("SELECT action_name, CAST(AVG(daily_tasks) AS SIGNED) AS avg_daily_tasks FROM ( SELECT action.name AS action_name, DATE(updateddate) AS event_date, COUNT(*) AS daily_tasks FROM tblcallevents LEFT JOIN action ON action.id = actiontype_id WHERE nextCFID != '0' AND CAST(updateddate AS DATE) BETWEEN '$sd' AND '$ed' AND user_id = '$uid' GROUP BY action.name, DATE(updateddate) ) AS daily_task_counts GROUP BY action_name");
    return $query->result();
}


public function get_avgtasksamest($uid,$sd,$ed,$st,$ac) {
    $query = $this->db->query("SELECT 
    FLOOR(SUM(event_count)/COUNT(*)) as cont
FROM (
    SELECT COUNT(*) AS event_count
    FROM tblcallevents
    LEFT JOIN init_call ON init_call.id = tblcallevents.cid_id
    WHERE 
        nextCFID != '0'
        AND CAST(updateddate AS DATE) BETWEEN '$sd' AND '$ed'
        AND user_id = '$uid'
        AND status_id = '$st'
        AND nstatus_id = '$st'
        AND actiontype_id = '$ac'
        AND init_call.cstatus = '$st'
    GROUP BY cid_id
) AS subquery");
    return $query->result();
}



public function get_totaltaktimep($uid,$tdate) {
    $query = $this->db->query("SELECT 
    (COUNT(CASE WHEN actiontype_id = 1 THEN 1 END) * 5 +
    COUNT(CASE WHEN actiontype_id = 2 THEN 1 END) * 5 +
    COUNT(CASE WHEN actiontype_id = 3 THEN 1 END) * 30 +
    COUNT(CASE WHEN actiontype_id = 4 THEN 1 END) * 30 +
    COUNT(CASE WHEN actiontype_id = 5 THEN 1 END) * 5 +
    COUNT(CASE WHEN actiontype_id = 6 THEN 1 END) +
    COUNT(CASE WHEN actiontype_id = 7 THEN 1 END) * 5 +
    COUNT(CASE WHEN actiontype_id = 8 THEN 1 END) * 5 +
    COUNT(CASE WHEN actiontype_id = 9 THEN 1 END) * 5 +
    COUNT(CASE WHEN actiontype_id = 10 THEN 1 END) * 5 +
    COUNT(CASE WHEN actiontype_id = 11 THEN 1 END) * 5) AS ttime
FROM tblcallevents
WHERE plan = '1' AND user_id = '$uid' AND CAST(appointmentdatetime AS DATE) = '$tdate'");
    return $query->result();
}


public function get_totaltaktimepbyh($uid,$tdate,$t1,$t2) {
    $query = $this->db->query("SELECT 
    (COUNT(CASE WHEN actiontype_id = 1 THEN 1 END) * 5 +
    COUNT(CASE WHEN actiontype_id = 2 THEN 1 END) * 10 +
    COUNT(CASE WHEN actiontype_id = 3 THEN 1 END) * 30 +
    COUNT(CASE WHEN actiontype_id = 4 THEN 1 END) * 30 +
    COUNT(CASE WHEN actiontype_id = 5 THEN 1 END) * 5 +
    COUNT(CASE WHEN actiontype_id = 6 THEN 1 END) +
    COUNT(CASE WHEN actiontype_id = 7 THEN 1 END) * 5 +
    COUNT(CASE WHEN actiontype_id = 8 THEN 1 END) * 5 +
    COUNT(CASE WHEN actiontype_id = 9 THEN 1 END) * 5 +
    COUNT(CASE WHEN actiontype_id = 10 THEN 1 END) * 5 +
    COUNT(CASE WHEN actiontype_id = 11 THEN 1 END) * 5) AS ttime
FROM tblcallevents
WHERE plan = '1' AND user_id = '$uid' AND CAST(appointmentdatetime AS DATE) = '$tdate' and CAST(appointmentdatetime AS TIME) between '$t1' and '$t2'");
    return $query->result();
}



public function get_livetask($uid,$sdate,$edate) {
    $query = $this->db->query("SELECT *,tblcallevents.id tid,compname,user_details.name uname,action.name acname,action.id aid,status.name stname,status.id stid
FROM tblcallevents left join action on action.id=tblcallevents.actiontype_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id left join status on status.id=tblcallevents.status_id LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id Left JOIN company_master ON company_master.id=init_call.cmpid_id
WHERE plan = '1' and nextCFID='0'
  AND user_details.admin_id = '$uid' and user_details.type_id='3'
  AND appointmentdatetime BETWEEN '$sdate' AND '$edate' ORDER BY appointmentdatetime DESC limit 1");
    return $query->result();
}

public function get_livetaskBD($uid,$sdate,$edate) {
    $query = $this->db->query("SELECT *,tblcallevents.id tid,compname,user_details.name uname,action.name acname,action.id aid,status.name stname,status.id stid
FROM tblcallevents left join action on action.id=tblcallevents.actiontype_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id left join status on status.id=tblcallevents.status_id LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id Left JOIN company_master ON company_master.id=init_call.cmpid_id
WHERE plan = '1' and nextCFID='0' and tblcallevents.reminder='0'
  AND user_details.admin_id = '$uid' and user_details.type_id='3'
  AND appointmentdatetime BETWEEN '$sdate' AND '$edate' ORDER BY appointmentdatetime DESC limit 1");
    return $query->result();
}

public function get_livetaskPST($uid,$sdate,$edate) {
    $query = $this->db->query("SELECT *,tblcallevents.id tid,compname,user_details.name uname,action.name acname,action.id aid,status.name stname,status.id stid
FROM tblcallevents left join action on action.id=tblcallevents.actiontype_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id left join status on status.id=tblcallevents.status_id LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id Left JOIN company_master ON company_master.id=init_call.cmpid_id
WHERE plan = '1' and nextCFID='0' and tblcallevents.reminder='0'
  AND user_details.admin_id = '$uid' and user_details.type_id='4'
  AND appointmentdatetime BETWEEN '$sdate' AND '$edate' ORDER BY appointmentdatetime DESC limit 1");
    return $query->result();
}


public function get_todaypaction($uid,$dt1,$dt2) {
    $query = $this->db->query("SELECT *,action.name acname,action.id aid
FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id left join action on action.id=tblcallevents.actiontype_id
WHERE plan = '1' and nextCFID='0'
  AND user_details.admin_id = '$uid'
  AND appointmentdatetime BETWEEN '$dt1' AND '$dt2'");
    return $query->result();
}


public function get_todaypstatus($uid,$dt1,$dt2,$aid) {
    $query = $this->db->query("SELECT *,status.name stname,status.id stid
FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id  left join status on status.id=tblcallevents.status_id 
WHERE plan = '1'  and nextCFID='0' and actiontype_id='$aid'
  AND user_details.admin_id = '$uid'
  AND appointmentdatetime BETWEEN '$dt1' AND '$dt2'");
    return $query->result();
}


public function get_todayptask($uid,$dt1,$dt2,$aid,$stid) {
    $query = $this->db->query("SELECT *,status.name stname,status.id stid,user_details.name uname
FROM tblcallevents LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id Left JOIN company_master ON company_master.id=init_call.cmpid_id left join status on status.id=tblcallevents.status_id
WHERE plan = '1'  and nextCFID='0' and actiontype_id='$aid' and status_id='$stid'
  AND user_details.admin_id = '$uid'
  AND appointmentdatetime BETWEEN '$dt1' AND '$dt2'");
    return $query->result();
}



    public function get_statuscmp($sid,$uid){
        $query=$this->db->query("SELECT init_call.id inid,company_master.compname compname,partner_master.name pname FROM init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT join partner_master ON partner_master.id=company_master.partnerType_id WHERE init_call.mainbd='$uid' and cstatus='$sid'");
        return $query->result();
    }
    
    public function get_cmpbyloc($bylocation,$uid){
        $query=$this->db->query("SELECT init_call.id inid,company_master.compname compname,partner_master.name pname FROM init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT join partner_master ON partner_master.id=company_master.partnerType_id WHERE init_call.mainbd='$uid' and company_master.city='$bylocation'");
        return $query->result();
    }
    
    public function get_statuscmp4($sid,$uid){
        $query=$this->db->query("SELECT init_call.id inid,company_master.compname compname,partner_master.name pname FROM init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT join partner_master ON partner_master.id=company_master.partnerType_id WHERE init_call.mainbd='$uid' and cstatus='$sid' and apst is not null");
        return $query->result();
    }
    
    public function get_statuscmp6($sid,$uid){
        $query=$this->db->query("SELECT init_call.id inid,company_master.compname compname,partner_master.name pname FROM init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT join partner_master ON partner_master.id=company_master.partnerType_id WHERE init_call.mainbd='$uid' and cstatus='$sid' and apst is null");
        return $query->result();
    }
    
    
    
    public function get_cmpbynwbwd5($sid,$uid){
        $query=$this->db->query("SELECT init_call.id inid,company_master.compname compname,partner_master.name pname FROM init_call LEFT JOIN tblcallevents ON tblcallevents.cid_id=init_call.id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT join partner_master ON partner_master.id=company_master.partnerType_id WHERE init_call.mainbd='$uid' and cstatus='$sid' and apst is not null and tblcallevents.updateddate>DATE_SUB(NOW(), INTERVAL 2 DAY) and tblcallevents.nextCFID!='0' GROUP BY init_call.id ,company_master.compname,partner_master.name");
        return $query->result();
    }
    
    
    public function get_cmpbynwbwd($sid,$uid){
        $query=$this->db->query("SELECT init_call.id inid,company_master.compname compname,partner_master.name pname FROM init_call LEFT JOIN tblcallevents ON tblcallevents.cid_id=init_call.id LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT join partner_master ON partner_master.id=company_master.partnerType_id WHERE init_call.mainbd='$uid' and cstatus='$sid' and tblcallevents.updateddate>DATE_SUB(NOW(), INTERVAL 15 DAY) and tblcallevents.nextCFID!='0' GROUP BY init_call.id ,company_master.compname,partner_master.name");
        return $query->result();
    }
    
    
    public function get_cmpbynwpsta($uid){
        $query=$this->db->query("SELECT init_call.id inid,company_master.compname compname,partner_master.name pname FROM init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id LEFT join partner_master ON partner_master.id=company_master.partnerType_id LEFT JOIN status s1 ON s1.id=init_call.cstatus LEFT JOIN user_details u1 ON u1.user_id=init_call.mainbd LEFT JOIN user_details u2 ON u2.user_id=init_call.apst WHERE mainbd = '$uid' AND apst IS NOT NULL AND init_call.id NOT IN (SELECT cid_id FROM tblcallevents WHERE cid_id IN (SELECT id FROM init_call WHERE mainbd='$uid' AND apst IS NOT NULL) AND nextCFID != '0' AND CAST(updateddate AS DATE) > '2023-09-18')");
        return $query->result();
    }
    
    
    
    
    public function get_cdbyname($bycmp){
        $query=$this->db->query("SELECT *,init_call.id inid,company_master.compname FROM init_call LEFT JOIN company_master ON company_master.id=init_call.cmpid_id WHERE company_master.compname='$bycmp'");
        return $query->result();
    }
    
    
    
    public function get_todayts($uid,$tdate){
        $query=$this->db->query("SELECT status.name stame,status.clr sclr,COUNT(*) cont FROM tblcallevents LEFT join init_call ON init_call.id=tblcallevents.cid_id JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN status ON status.id=init_call.cstatus WHERE tblcallevents.user_id='$uid' and plan='1' and cast(tblcallevents.appointmentdatetime as DATE)='$tdate' GROUP BY status.name,status.clr");
        return $query->result();
    }
    
    public function get_todaytcs($uid,$tdate){
        $query=$this->db->query("SELECT status.name stame,status.clr sclr,COUNT(*) cont FROM tblcallevents LEFT join init_call ON init_call.id=tblcallevents.cid_id JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN status ON status.id=init_call.cstatus WHERE tblcallevents.user_id='$uid' and plan='1' and nextCFID!='0' and cast(tblcallevents.updateddate as DATE)='$tdate' GROUP BY status.name,status.clr");
        return $query->result();
    }
    
    
    public function get_todaytis($uid,$tdate){
        $query=$this->db->query("SELECT status.name stame,status.clr sclr,COUNT(*) cont FROM tblcallevents LEFT join init_call ON init_call.id=tblcallevents.cid_id JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN status ON status.id=init_call.cstatus WHERE tblcallevents.user_id='$uid' and plan='1' and cast(tblcallevents.initiateddt as DATE)='$tdate' GROUP BY status.name,status.clr");
        return $query->result();
    }
    
    
    
    public function get_todayta($uid,$tdate){
        $query=$this->db->query("SELECT action.name acname,action.clr aclr,COUNT(*) cont FROM tblcallevents LEFT join init_call ON init_call.id=tblcallevents.cid_id JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN action ON action.id=tblcallevents.actiontype_id WHERE tblcallevents.user_id='$uid' and plan='1' and cast(tblcallevents.appointmentdatetime as DATE)='$tdate' GROUP BY action.name,action.clr");
        return $query->result();
    }
    
    public function get_todaytca($uid,$tdate){
        $query=$this->db->query("SELECT action.name acname,action.clr aclr,COUNT(*) cont FROM tblcallevents LEFT join init_call ON init_call.id=tblcallevents.cid_id JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN action ON action.id=tblcallevents.actiontype_id WHERE tblcallevents.user_id='$uid' and plan='1' and nextCFID!='0' and  cast(tblcallevents.updateddate as DATE)='$tdate' GROUP BY action.name,action.clr");
        return $query->result();
    }
    
    
    public function get_todaytia($uid,$tdate){
        $query=$this->db->query("SELECT action.name acname,action.clr aclr,COUNT(*) cont FROM tblcallevents LEFT join init_call ON init_call.id=tblcallevents.cid_id JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN action ON action.id=tblcallevents.actiontype_id WHERE tblcallevents.user_id='$uid' and plan='1' and  cast(tblcallevents.initiateddt as DATE)='$tdate' GROUP BY action.name,action.clr");
        return $query->result();
    }
    
    
    public function get_todaytp($uid,$tdate){
        $query=$this->db->query("SELECT partner_master.name pname,partner_master.clr pclr, COUNT(*) cont FROM tblcallevents LEFT join init_call ON init_call.id=tblcallevents.cid_id JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN partner_master ON partner_master.id=company_master.partnerType_id WHERE tblcallevents.user_id='$uid' and plan='1' and cast(tblcallevents.appointmentdatetime as DATE)='$tdate' GROUP BY partner_master.name,partner_master.clr");
        return $query->result();
    }
    
    
    public function get_todaytcp($uid,$tdate){
        $query=$this->db->query("SELECT partner_master.name pname,partner_master.clr pclr, COUNT(*) cont FROM tblcallevents LEFT join init_call ON init_call.id=tblcallevents.cid_id JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN partner_master ON partner_master.id=company_master.partnerType_id WHERE tblcallevents.user_id='$uid' and plan='1' and nextCFID!='0' and cast(tblcallevents.updateddate as DATE)='$tdate' GROUP BY partner_master.name,partner_master.clr");
        return $query->result();
    }
    
    
    public function get_todaytip($uid,$tdate){
        $query=$this->db->query("SELECT partner_master.name pname,partner_master.clr pclr, COUNT(*) cont FROM tblcallevents LEFT join init_call ON init_call.id=tblcallevents.cid_id JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN partner_master ON partner_master.id=company_master.partnerType_id WHERE tblcallevents.user_id='$uid' and plan='1' and cast(tblcallevents.initiateddt as DATE)='$tdate' GROUP BY partner_master.name,partner_master.clr");
        return $query->result();
    }
    
    
    public function get_todaytc($uid){
        $query=$this->db->query("SELECT partner_master.name ctname,COUNT(*) cont FROM init_call JOIN company_master on company_master.id=init_call.cmpid_id LEFT JOIN partner_master ON partner_master.id=company_master.partnerType_id WHERE mainbd='$uid' GROUP BY partner_master.name");
        return $query->result();
    }
    
    
    
    public function get_todaytiol($uid,$tdate){
        $query=$this->db->query("SELECT COUNT(CASE WHEN DATE_ADD(appointmentdatetime, INTERVAL 15 MINUTE)<initiateddt THEN 1 END) late, COUNT(CASE WHEN DATE_ADD(appointmentdatetime, INTERVAL 15 MINUTE)>initiateddt THEN 1 END) ontime FROM tblcallevents WHERE user_id='$uid' and plan='1' and cast(initiateddt as DATE)='$tdate'");
        return $query->result();
    }
    
    
    public function get_olbyu($uid,$sd,$ed,$code){
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text = "user_details.user_id='$uid'";}
        if($utype==9){$text = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        
        
        
        if($code==1){
        $query=$this->db->query("SELECT *,company_master.id cid, action.clr aclr,s1.clr bsclr,s2.clr asclr,partner_master.clr pclr,s1.name bstatus, s1.name astatus, action.name acname,user_details.name uname,partner_master.name pname FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id left JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id LEFT JOIN action on action.id=tblcallevents.actiontype_id left join partner_master on partner_master.id=company_master.partnerType_id WHERE $text and plan='1' and appointmentdatetime<initiateddt and cast(initiateddt as DATE) between '$sd' and '$ed'");
        }
        if($code==2){
        $query=$this->db->query("SELECT *,company_master.id cid, action.clr aclr,s1.clr bsclr,s2.clr asclr,partner_master.clr pclr,s1.name bstatus, s1.name astatus, action.name acname,user_details.name uname,partner_master.name pname FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id left JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id LEFT JOIN action on action.id=tblcallevents.actiontype_id left join partner_master on partner_master.id=company_master.partnerType_id WHERE $text and plan='1' and appointmentdatetime>initiateddt and cast(initiateddt as DATE) between '$sd' and '$ed'");
        }
        return $query->result();
    }
    
    public function get_odformat($dateTimeString){
        $dateTime = new DateTime($dateTimeString, new DateTimeZone('UTC'));
        $formattedDate = $dateTime->format('F j, Y');
        return $formattedDate;
    }
    
    public function get_dformat($dateTimeString){
        $dateTime = new DateTime($dateTimeString, new DateTimeZone('UTC'));
        $formattedDate = $dateTime->format('g:i A, F j, Y');
        return $formattedDate;
    }
    
    public function get_Program($bdid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT *, (SELECT COUNT(*) FROM spd WHERE spd.project_code = client_handover.projectcode) AS tspd, (SELECT GROUP_CONCAT(DISTINCT user_detail.fullname) FROM spd LEFT JOIN user_detail ON user_detail.id=spd.pi_id WHERE spd.project_code = client_handover.projectcode) AS pia, (SELECT GROUP_CONCAT(DISTINCT user_detail.fullname) FROM spd LEFT JOIN user_detail ON user_detail.id=spd.ins_id WHERE spd.project_code = client_handover.projectcode) AS imp FROM client_handover WHERE bd_id = '$bdid'  ORDER BY `client_handover`.`project_year` DESC");
        return $query->result();
    }
    
    
    public function get_Programbycid($bdid,$cid){
        $db3 = $this->load->database('db3', TRUE);
        $query=$db3->query("SELECT *, (SELECT COUNT(*) FROM spd WHERE spd.project_code = client_handover.projectcode) AS tspd, (SELECT GROUP_CONCAT(DISTINCT user_detail.fullname) FROM spd LEFT JOIN user_detail ON user_detail.id=spd.pi_id WHERE spd.project_code = client_handover.projectcode) AS pia, (SELECT GROUP_CONCAT(DISTINCT user_detail.fullname) FROM spd LEFT JOIN user_detail ON user_detail.id=spd.ins_id WHERE spd.project_code = client_handover.projectcode) AS imp FROM client_handover WHERE bd_id = '$bdid' and client_handover.id='$cid'  ORDER BY `client_handover`.`project_year` DESC");
        return $query->result();
    }
    
    
    public function get_plannedtask($uid,$sd,$ed,$code){
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text1 = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text1 = "user_details.user_id='$uid'";}
        if($utype==9){$text1 = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        
        if($code==1){
            $text2="plan='1' and appointmentdatetime<initiateddt and cast(initiateddt as DATE) between '$sd' and '$ed'";
        }
        if($code==2){
            $text2="plan='1' and appointmentdatetime>initiateddt and cast(initiateddt as DATE) between '$sd' and '$ed'";
        }
        
        $query=$this->db->query("SELECT *,company_master.id cid, action.clr aclr,s1.clr bsclr,s2.clr asclr,partner_master.clr pclr,s1.name bstatus, s1.name astatus, action.name acname,user_details.name uname,partner_master.name pname FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN status s3 ON s3.id=init_call.cstatus LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id left JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id LEFT JOIN action on action.id=tblcallevents.actiontype_id left join partner_master on partner_master.id=company_master.partnerType_id WHERE $text1 and $text2 ORDER BY tblcallevents.appointmentdatetime DESC");
        return $query->result();
    }
    
    
    public function get_laststatuschangedate($ciid){
        $query=$this->db->query("SELECT MAX(updateddate) updatedt, COUNT(*) cont FROM tblcallevents WHERE cid_id='$ciid' and nextCFID!='0'");
        return $query->result();
    }
    
    
    
    public function get_initiatedtask($uid,$sd,$ed,$code){
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text1 = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text1 = "user_details.user_id='$uid'";}
        if($utype==9){$text1 = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        
        if($code==1){
            $text2="plan='1' and appointmentdatetime<initiateddt and cast(initiateddt as DATE) between '$sd' and '$ed'";
        }
        if($code==2){
            $text2="plan='1' and appointmentdatetime>initiateddt and cast(initiateddt as DATE) between '$sd' and '$ed'";
        }
        
        $query=$this->db->query("SELECT *,company_master.id cid, action.clr aclr,s1.clr bsclr,s2.clr asclr,s3.clr csclr,partner_master.clr pclr,s1.name bstatus, s1.name astatus,s1.name cstatus, action.name acname,user_details.name uname,partner_master.name pname FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN status s3 ON s3.id=init_call.cstatus LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id left JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id LEFT JOIN action on action.id=tblcallevents.actiontype_id left join partner_master on partner_master.id=company_master.partnerType_id WHERE $text1 and $text2 ORDER BY tblcallevents.initiateddt DESC");
        return $query->result();
    }
    
    
    
    public function get_updatedtask($uid,$sd,$ed,$code){
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text1 = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text1 = "user_details.user_id='$uid'";}
        if($utype==9){$text1 = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        
        if($code==1){
            $text2="plan='1' and initiateddt<updateddate and cast(updateddate as DATE) between '$sd' and '$ed'";
        }
        if($code==2){
            $text2="plan='1' and initiateddt>updateddate and cast(updateddate as DATE) between '$sd' and '$ed'";
        }
        
        $query=$this->db->query("SELECT *,company_master.id cid, action.clr aclr,s1.clr bsclr,s2.clr asclr,partner_master.clr pclr,s1.name bstatus, s1.name astatus, action.name acname,user_details.name uname,partner_master.name pname FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN status s3 ON s3.id=init_call.cstatus LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id left JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id LEFT JOIN action on action.id=tblcallevents.actiontype_id left join partner_master on partner_master.id=company_master.partnerType_id WHERE $text1 and $text2 ORDER BY tblcallevents.updateddate DESC");
        return $query->result();
    }
    
    
    
    public function get_todayupdatedtask($uid,$tdate){
        if($uid=='100103' || $uid=='100149'){$uid=$uid;}
        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;
        if($utype==2){$text1 = "user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active'";}
        if($utype==3){$text1 = "user_details.user_id='$uid'";}
        if($utype==9){$text1 = "user_details.aadmin='$uid' and user_details.type_id='3' and user_details.status='active'";}
        
        $query=$this->db->query("SELECT *,company_master.id cid, action.clr aclr,s1.clr bsclr,s2.clr asclr,partner_master.clr pclr,s1.name bstatus, s1.name astatus, action.name acname,user_details.name uname,partner_master.name pname FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN status s3 ON s3.id=init_call.cstatus LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id left JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id LEFT JOIN action on action.id=tblcallevents.actiontype_id left join partner_master on partner_master.id=company_master.partnerType_id WHERE $text1 and cast(updateddate as DATE)='$tdate' ORDER BY tblcallevents.updateddate DESC");
        return $query->result();
    }
    
    
    
    public function get_sconbydate($cid){
        $query=$this->db->query("SELECT 
    s1.name bstatus,
    s2.name astatus,
    s2.clr sclr,
    tblcallevents.updateddate,
    CONCAT(
        FLOOR(TIMESTAMPDIFF(MONTH, prev.updateddate, tblcallevents.updateddate)), ' months ',
        FLOOR(TIMESTAMPDIFF(DAY, prev.updateddate, tblcallevents.updateddate) % 30), ' days ',
        LPAD(HOUR(TIMEDIFF(tblcallevents.updateddate, prev.updateddate)), 2, '0'), ' hours ',
        LPAD(MINUTE(TIMEDIFF(tblcallevents.updateddate, prev.updateddate)), 2, '0'), ' minutes ',
        LPAD(SECOND(TIMEDIFF(tblcallevents.updateddate, prev.updateddate)), 2, '0'), ' seconds'
    ) AS time_difference
FROM tblcallevents LEFT JOIN status s1 ON s1.id=tblcallevents.status_id  LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id
LEFT JOIN init_call ON init_call.id = tblcallevents.cid_id
LEFT JOIN company_master ON company_master.id = init_call.cmpid_id
LEFT JOIN tblcallevents AS prev ON tblcallevents.id = prev.id + 1
WHERE init_call.id = '$cid'
    AND tblcallevents.updateddate > '2023-03-31'
    AND tblcallevents.nextCFID != '0'
    AND tblcallevents.status_id != tblcallevents.nstatus_id
ORDER BY tblcallevents.updateddate");
        return $query->result();
    }
    
    
    
    
    
    
    public function get_utaskbycmp($cid){
        $query=$this->db->query("SELECT *,company_master.id cid, action.clr aclr,s1.clr bsclr,s2.clr asclr,partner_master.clr pclr,s1.name bstatus, s2.name astatus, action.name acname,user_details.name uname,partner_master.name pname FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN status s3 ON s3.id=init_call.cstatus LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id left JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id LEFT JOIN action on action.id=tblcallevents.actiontype_id left join partner_master on partner_master.id=company_master.partnerType_id WHERE cid_id='$cid' and updateddate>'2023-03-31' and nextCFID!='0' ORDER BY tblcallevents.updateddate DESC");
        return $query->result();
    }
    
    
    public function get_usertask($uid){
        $query=$this->db->query("SELECT *,company_master.id cid, action.clr aclr,s1.clr bsclr,s2.clr asclr,partner_master.clr pclr,s1.name bstatus, s1.name astatus, action.name acname,user_details.name uname,partner_master.name pname FROM tblcallevents LEFT JOIN init_call ON init_call.id=tblcallevents.cid_id LEFT JOIN status s3 ON s3.id=init_call.cstatus LEFT JOIN user_details ON user_details.user_id=tblcallevents.user_id left JOIN company_master ON company_master.id=init_call.cmpid_id LEFT JOIN status s1 ON s1.id=tblcallevents.status_id LEFT JOIN status s2 ON s2.id=tblcallevents.nstatus_id LEFT JOIN action on action.id=tblcallevents.actiontype_id left join partner_master on partner_master.id=company_master.partnerType_id WHERE tblcallevents.user_id='$uid' and updateddate>'2023-03-31' and nextCFID!='0' ORDER BY tblcallevents.updateddate DESC");
        return $query->result();
    }
    
    
    
    
    
    public function get_daymanagment($uid,$tdate){
        $query=$this->db->query("SELECT user_details.name bdname, cast(ustart as TIME) as start,cast(uclose as TIME) as close, user_day.* FROM user_day LEFT JOIN user_details ON user_details.user_id=user_day.user_id WHERE cast(ustart as DATE)='$tdate' and user_details.user_id='$uid'");
        return $query->result();
    }
    








    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    







    
    
}
    