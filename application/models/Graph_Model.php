<?php
date_default_timezone_set("Asia/Calcutta");
class Graph_model extends CI_Model{


    public function get_taskstatuswisebwdall($uid,$sd,$ed){

        $utype = $this->Menu_model->get_userbyid($uid);
        $utype = $utype[0]->type_id;

        if($utype==2){

            $query=$this->db->query("SELECT status.name stname,count(*) cont FROM tblcallevents LEFT JOIN status ON status.id=tblcallevents.status_id WHERE tblcallevents.cid_id IN (Select init_call.id from init_call LEFT JOIN user_details on user_details.user_id=init_call.mainbd WHERE user_details.admin_id='$uid' and user_details.status='active') and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' Group By status.name");
            
        }else{

            $query=$this->db->query("SELECT status.name stname,count(*) cont FROM tblcallevents LEFT JOIN status ON status.id=tblcallevents.status_id WHERE tblcallevents.cid_id IN (Select id from init_call WHERE init_call.mainbd='$uid') and nextCFID!='0' and cast(updateddate as DATE) BETWEEN '$sd' and '$ed' Group By status.name");
        }

        return $query->result();
    }
}


?>