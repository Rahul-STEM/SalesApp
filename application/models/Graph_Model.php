<?php
date_default_timezone_set("Asia/Calcutta");
defined('BASEPATH') or exit('No direct script access allowed');
// require_once('Menu_model.php');
class Graph_Model extends CI_Model
{

    public function get_utype($uyid)
    {
        $query = $this->db->query("SELECT id,name FROM user_type WHERE id='$uyid'");
        return $query->result();
    }

    public function get_fannalstwise($uid, $userTypeid, $sdate, $edate)
    {

        // need to add status id in this

        $this->db->select('status.id stid');
        $this->db->select('status.name stname');
        $this->db->select('COUNT(*) cont');
        $this->db->from('init_call ic');
        $this->db->join('status', 'status.id = ic.cstatus', 'left');
        $this->db->join('user_details', 'user_details.user_id = ic.mainbd', 'left');

        if ($userTypeid == 2) {
            //if admin is loggedin
            $this->db->where('admin_id', $uid);

        } elseif ($userTypeid == 4) {
            //if PST is loggedin
            $this->db->where('pst_co', $uid);

            # code...
        } elseif ($userTypeid == 9) {
            //if BDPST is loggedin
            $this->db->where('aadmin', $uid);

            # code...
        } elseif ($userTypeid == 13) {
            //if CLM is loggedin
            // $this->db->where('admin_id', $uid);

            # code...
        } else {
            //if BD is loggedin
            $this->db->where('mainbd', $uid);
        }

        $this->db->where('user_details.status', 'active');

        $this->db->where('CAST(ic.createDate AS DATE) >=', "'$sdate'", FALSE);
        $this->db->where('CAST(ic.createDate AS DATE) <=', "'$edate'", FALSE);
        $this->db->group_by('status.name');
        $this->db->group_by('status.id');
        // $this->db->order_by('nom_dept', 'asc');
        $query = $this->db->get();
        //    echo $this->db->last_query();die;

        return $query->result();
    }

    public function get_fannalbycode_OG($uid, $userTypeid, $sdate, $edate,$userType=null,$cluster=null,$partnerType=null,$category=null,$users=null)
    {

        $this->db->select('status.id stid');
        $this->db->select('status.name stname');
        $this->db->select('company_master.compname company_name');
        $this->db->select('company_master.address company_address');
        $this->db->select('city.city city');
        $this->db->select('states.state state');
        $this->db->select('partner_master.name partner_type');
        $this->db->select("CASE WHEN ic.focus_funnel = 'yes' THEN 'Focus Funnel' END as focus_funnel");
        $this->db->select("CASE WHEN ic.keycompany = 'yes' THEN 'Key Company' END as keycompany");
        $this->db->select("CASE WHEN ic.upsell_client = 'yes' THEN 'Upsell Client' END as upsell_client");
        $this->db->select('latest_remarks.remarks remark');
        $this->db->select('tblcallevents_counts.updatedt as latest_updated_date');
        $this->db->select('tblcallevents_counts.cont as total_count');

        // Calculate and format the difference
        $this->db->select(
            "CONCAT(
                TIMESTAMPDIFF(DAY, tblcallevents_counts.updatedt, CURDATE()), ' day ',
                MOD(TIMESTAMPDIFF(HOUR, tblcallevents_counts.updatedt, NOW()), 24), ' hour ',
                MOD(TIMESTAMPDIFF(MINUTE, tblcallevents_counts.updatedt, NOW()), 60), ' min ',
                MOD(TIMESTAMPDIFF(SECOND, tblcallevents_counts.updatedt, NOW()), 60), ' sec'
            ) AS time_since_last_update"
        );


        $this->db->from('init_call ic');

        $this->db->join('company_master', 'company_master.id = ic.cmpid_id', 'left');
        $this->db->join('city', 'city.id = company_master.city', 'left');
        $this->db->join('states', 'states.id = company_master.state', 'left');
        $this->db->join('tblcallevents', 'tblcallevents.cid_id = company_master.id', 'left');
        $this->db->join('partner_master', 'partner_master.id = company_master.partnerType_id', 'left');
        $this->db->join('status', 'status.id = ic.cstatus', 'left');

        $this->db->join('user_details', 'user_details.user_id = ic.mainbd', 'left');

        // Subquery to get latest remarks for each init_call
        $this->db->join(
            '(SELECT tblcallevents.cid_id, tblcallevents.remarks, ROW_NUMBER() OVER (PARTITION BY tblcallevents.cid_id ORDER BY tblcallevents.updated_at DESC) as rn
              FROM tblcallevents) as latest_remarks',
            'latest_remarks.cid_id = ic.cmpid_id AND latest_remarks.rn = 1',
            'left'
        );


        // Subquery to get max updateddate and count for each cid_id
        $this->db->join(
            '(SELECT cid_id, MAX(updateddate) as updatedt, COUNT(*) as cont
            FROM tblcallevents
            WHERE nextCFID != "0"
            GROUP BY cid_id) as tblcallevents_counts',
            'tblcallevents_counts.cid_id = ic.cmpid_id',
            'left'
        );

        if ($userTypeid == 2) {
            //if admin is loggedin
            $this->db->where('admin_id', $uid);

        } elseif ($userTypeid == 4) {
            //if PST is loggedin
            $this->db->where('pst_co', $uid);

            # code...
        } elseif ($userTypeid == 9) {
            //if BDPST is loggedin
            $this->db->where('aadmin', $uid);

            # code...
        } elseif ($userTypeid == 13) {
            //if CLM is loggedin
            // $this->db->where('admin_id', $uid);

            # code...
        } else {
            //if BD is loggedin
            $this->db->where('mainbd', $uid);
        }

        

        $this->db->where('user_details.status', 'active');

        $this->db->where('CAST(ic.createDate AS DATE) >=', "'$sdate'", FALSE);
        $this->db->where('CAST(ic.createDate AS DATE) <=', "'$edate'", FALSE);
        $this->db->where('tblcallevents.remarks !=', '');
        $this->db->group_by('company_name');
        $query = $this->db->get();

        //    echo $this->db->last_query();die;
        return $query->result();
    }

    public function getRoles($type_id)
    {

        $this->db->select('*');
        $this->db->from('user_type');
        $this->db->where('Active_Flag', 0);
        if ($type_id != 2) {
            $this->db->where('id', $type_id);
        }
        $query = $this->db->get();
        // echo  $this->db->last_query(); die;
        return $query->result();

    }

    public function getPartnerType()
    {

        $this->db->select('*');
        $this->db->from('partner_master');

        $query = $this->db->get();
        // echo  $this->db->last_query(); die;
        return $query->result();

    }

    public function get_clusters()
    {

        $this->db->select('id');
        $this->db->select('cluster_name');
        $this->db->from('clustermaster');

        $query = $this->db->get();
        // echo  $this->db->last_query(); die;
        return $query->result();

    }

    public function getClusterManagerByCluster($clusterID)
    {

        $this->db->select('user_id');
        $this->db->select('name');
        $this->db->from('user_details');
        $this->db->join('clustermaster', 'user_details.user_id = clustermaster.clusterManager_id', 'left');
        $this->db->where_in('clustermaster.id',$clusterID);

        $query = $this->db->get();

        return $query->result();

    }

    public function getCategory()
    {

        $this->db->select('*');
        $this->db->from('categories');

        $query = $this->db->get();
        // echo  $this->db->last_query(); die;
        return $query->result();

    }

    public function get_tblbyidwithremark($ciid){
        // $query=$this->db->query("SELECT * FROM tblcallevents WHERE cid_id='$ciid' and remarks!='' ORDER BY tblcallevents.updateddate DESC");
        $this->db->select('cid_id');
        $this->db->select('remarks');
        $this->db->select('updateddate');
        $this->db->select('user_details.name last_updated_by');
        $this->db->from('tblcallevents');
        $this->db->join('user_details', 'user_details.user_id = tblcallevents.user_id', 'left');

        $this->db->where('cid_id', $ciid);

        $this->db->order_by('tblcallevents.updateddate DESC');
        $this->db->limit('1');

        $query = $this->db->get();
        // echo $this->db->last_query();die;
        return $query->result();
    }

    public function getGraphDetails($uid, $userTypeid, $sdate, $edate, $userType = null, $cluster = null, $partnerType = null, $category = null, $users = null)
    {

        // var_dump($category);die;
        $this->db->select('status.clr stclr');
        $this->db->select('status.id stid');
        $this->db->select('status.name stname');
        $this->db->select('COUNT(*) cont');
        $this->db->from('init_call ic');
        $this->db->join('status', 'status.id = ic.cstatus', 'left');
        $this->db->join('user_details', 'user_details.user_id = ic.mainbd', 'left');

        if ($partnerType != '') {

            $this->db->join('company_master', 'company_master.id = ic.cmpid_id', 'left');
            $this->db->where_in('company_master.partnerType_id', $partnerType);

        }

        if ($category != '') {
            // var_dump($category);die;
            foreach ($category as $singleCategory) {
                // var_dump($singleCategory);die;
                if ($singleCategory == 'upsell_client') {
                    $this->db->where('ic.upsell_client', 'yes');
                }
                if ($singleCategory == 'focus_funnel') {
                    $this->db->where('ic.focus_funnel', 'yes');
                }
                if ($singleCategory == 'keycompany') {
                    $this->db->where('ic.keycompany', 'yes');
                }
                if ($singleCategory == 'pkclient') {
                    $this->db->where('ic.pkclient', 'yes');
                }
                if ($singleCategory == 'priorityc') {
                    $this->db->where('ic.priorityc', 'yes');
                }
            }
        }

        // var_dump($cluster);die;
        // if cluster is selected
        if (!empty($cluster)) {

            $this->db->where_in('aadmin', $users);

        }


        // if userType is selected
        if (!empty($userType)) {

            // $users = implode(',', ($users));

            foreach ($userType as $singleuserType) {
                if ($singleuserType == 4) {
                    $this->db->where_in('pst_co', $users);
                } elseif($singleuserType == 9 || $singleuserType == 13) {
                    $this->db->where_in('aadmin', $users);
                }
                else{

                    $this->db->where_in('user_id', $users);
                }
            }  
        }

        if ($userTypeid == 2) {
            //if admin is loggedin
            $this->db->where('admin_id', $uid);

        } elseif ($userTypeid == 4) {
            //if PST is loggedin
            $this->db->where('pst_co', $uid);

        } elseif ($userTypeid == 9) {
            //if BDPST is loggedin
            $this->db->where('aadmin', $uid);

        } elseif ($userTypeid == 13) {
            //if CLM is loggedin
            $this->db->where('admin_id', $uid);

        } else {
            //if BD is loggedin
            $this->db->where('mainbd', $uid);
        }

        $this->db->where('user_details.status', 'active');

        $this->db->where('CAST(ic.createDate AS DATE) >=', "'$sdate'", FALSE);
        $this->db->where('CAST(ic.createDate AS DATE) <=', "'$edate'", FALSE);
        $this->db->group_by('status.name');
        $this->db->group_by('status.id');
        // $this->db->group_by('ic.cmpid_id ');
        $query = $this->db->get();
        // echo $this->db->last_query();die;

        return $query->result();
    }

    public function get_TableData($uid, $userTypeid, $sdate, $edate,$userType=null,$cluster=null,$partnerType=null,$category=null,$users=null)
    {   

        $this->db->select('ic.id ic_id');
        $this->db->select('status.clr stclr');
        $this->db->select('status.id stid');
        $this->db->select('status.name stname');
        $this->db->select('company_master.compname company_name');
        $this->db->select('company_master.address company_address');
        $this->db->select('city.city city');
        $this->db->select('states.state state');
        $this->db->select('partner_master.name partner_type');
        $this->db->from('init_call ic');
        $this->db->join('company_master', 'company_master.id = ic.cmpid_id', 'left');
        $this->db->join('city', 'city.id = company_master.city', 'left');
        $this->db->join('states', 'states.id = company_master.state', 'left');
        $this->db->join('partner_master', 'partner_master.id = company_master.partnerType_id', 'left');
        $this->db->join('status', 'status.id = ic.cstatus', 'left');
        $this->db->join('user_details', 'user_details.user_id = ic.mainbd', 'left');

        if ($partnerType != '') {

            $this->db->where_in('company_master.partnerType_id', $partnerType);
        }


        //if user type is selected
        if (!empty($userType)) {

            foreach ($userType as $singleuserType) {
                if ($singleuserType == 4) {
                    $this->db->where_in('pst_co', $users);
                } elseif($singleuserType == 9 || $singleuserType == 13) {
                    $this->db->where_in('aadmin', $users);
                }
                else{

                    $this->db->where_in('user_id', $users);
                }
            }  
        }else{
            $this->db->where_in('admin_id', $uid);
        }

        // if cluster is selected
        if (!empty($cluster)) {
            // var_dump($cluster);die;
            $this->db->where_in('aadmin', $users);
        }

        $this->db->where('CAST(ic.createDate AS DATE) >=', "'$sdate'", FALSE);
        $this->db->where('CAST(ic.createDate AS DATE) <=', "'$edate'", FALSE);
        // $this->db->where('tblcallevents.remarks !=', '');
        $this->db->group_by('ic.cmpid_id');
        // $this->db->group_by('stname');
        $query = $this->db->get();

        //    echo $this->db->last_query();die;
        return $query->result();
    }

    public function getStatusWiseFunnelData($uid,$sdate,$edate,$selected_partnerType,$arrayselected_cluster,$arrayselected_user,$status_id){

        // print_r($arrayselected_user);die;
        $this->db->select('status.id stid');
        $this->db->select('status.name stname');
        $this->db->select('company_master.compname company_name');
        $this->db->select('company_master.address company_address');
        $this->db->select('city.city city');
        $this->db->select('states.state state');
        $this->db->select('partner_master.name partner_type');
        $this->db->select('ic.cmpid_id cmpid_id');
        $this->db->select('user_details.name bd_name');
        $this->db->select('ud_bd.name pst_name');




        $this->db->from('init_call ic');
        $this->db->join('company_master', 'company_master.id = ic.cmpid_id', 'left');
        $this->db->join('city', 'city.id = company_master.city', 'left');
        $this->db->join('states', 'states.id = company_master.state', 'left');
        $this->db->join('tblcallevents', 'tblcallevents.cid_id = company_master.id', 'left');
        $this->db->join('partner_master', 'partner_master.id = company_master.partnerType_id', 'left');
        $this->db->join('status', 'status.id = ic.cstatus', 'left');
        $this->db->join('user_details', 'user_details.user_id = ic.mainbd', 'left');
        $this->db->join('user_details ud_bd', 'ud_bd.user_id = user_details.user_id', 'left');
        
        if ($selected_partnerType != '') {

            $this->db->where_in('company_master.partnerType_id', $selected_partnerType);
        }
        if ($arrayselected_user != '') {

            $this->db->where_in('user_details.aadmin', $arrayselected_user);
        }

        // $this->db->where_in('company_master.partnerType_id', $selected_partnerType);
        $this->db->where('CAST(ic.createDate AS DATE) >=', "'$sdate'", FALSE);
        $this->db->where('CAST(ic.createDate AS DATE) <=', "'$edate'", FALSE);
        // $this->db->where('tblcallevents.remarks !=', '');
        $this->db->where_in('user_details.admin_id', $uid);
        $this->db->where_in('status.id', $status_id);
        $this->db->group_by('ic.cmpid_id');
        $query = $this->db->get();

        //    echo $this->db->last_query();die;
        return $query->result();
    }
}