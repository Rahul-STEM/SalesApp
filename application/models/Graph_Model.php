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
        // echo $this->db->last_query();die;
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

    public function getStatus()
    {

        $this->db->select('*');
        $this->db->from('status');

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

        if (!empty($partnerType)) {

            $this->db->join('company_master', 'company_master.id = ic.cmpid_id', 'left');
            $this->db->where_in('company_master.partnerType_id', $partnerType);

        }

        if (!empty($category)) {
            // var_dump($category);die;
            $this->db->group_start();

            foreach ($category as $singleCategory) {

                if ($singleCategory == 'topspender') {

                    $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'focus_funnel') {

                    $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'upsell_client') {
                    
                    $this->db->or_where('upsell_client', 'yes');

                }
                if($singleCategory == 'keycompany') {
                    
                    $this->db->or_where('keycompany', 'yes');

                }
                if($singleCategory == 'pkclient ') {
                    
                    $this->db->or_where('pkclient', 'yes'); 
                }
                if($singleCategory == 'priorityc ') {
                    
                    $this->db->or_where('priorityc', 'yes');
                }
            }  

            $this->db->group_end(); 
        }

        // var_dump($cluster);die;
        // if cluster is selected
        if (!empty($cluster)) {
            // echo 'hii';die;
            $this->db->where_in('aadmin', $users);

        }


        // if userType is selected
        if (!empty($userType)) {
            $this->db->group_start();
            foreach ($userType as $singleuserType) {
                if ($singleuserType == 4) {
                    $this->db->or_where_in('pst_co', $users);
                } 
                if($singleuserType == 9 || $singleuserType == 13) {
                    $this->db->or_where_in('aadmin', $users);
                }
                // else{

                //     $this->db->where_in('user_id', $users);
                // }
            } 
            $this->db->group_end();  
        }

        // echo $userTypeid;die;
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

        if ($category != '') {
            // var_dump($category);die;
            $this->db->group_start();

            foreach ($category as $singleCategory) {

                if ($singleCategory == 'topspender') {

                    $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'focus_funnel') {

                    $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'upsell_client') {
                    
                    $this->db->or_where('upsell_client', 'yes');

                }
                if($singleCategory == 'keycompany') {
                    
                    $this->db->or_where('keycompany', 'yes');

                }
                if($singleCategory == 'pkclient ') {
                    
                    $this->db->or_where('pkclient', 'yes'); 
                }
                if($singleCategory == 'priorityc ') {
                    
                    $this->db->or_where('priorityc', 'yes');
                }
            }  

            $this->db->group_end(); 
        }

        //if user type is selected
        if (!empty($userType)) {
            $this->db->group_start();
            foreach ($userType as $singleuserType) {
                if ($singleuserType == 4) {
                    $this->db->or_where_in('pst_co', $users);
                } 
                if($singleuserType == 9 || $singleuserType == 13) {
                    $this->db->or_where_in('aadmin', $users);
                }
                // else{

                //     $this->db->where_in('user_id', $users);
                // }
            } 
            $this->db->group_end();  
        }else{
            $this->db->where_in('admin_id', $uid);
        }

        // if cluster is selected
        if (!empty($cluster)) {
            // var_dump($cluster);die;
            $this->db->where_in('aadmin', $users);
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
        // $this->db->where('tblcallevents.remarks !=', '');
        $this->db->group_by('ic.cmpid_id');
        // $this->db->group_by('stname');
        $query = $this->db->get();

        //    echo $this->db->last_query();die;
        return $query->result();
    }

    public function getTableDataByStatus($uid,$userTypeid,$stid,$sdate,$edate,$selected_partnerType,$selected_category,$selected_userType,$selected_users,$selected_cluster)
    {   
        // print_r($selected_partnerType[0]);die;
        $this->db->select('ic.id ic_id');
        $this->db->select('ic.focus_funnel focus_funnel');
        $this->db->select('ic.upsell_client upsell_client');
        $this->db->select('ic.keycompany keycompany');
        $this->db->select('ic.pkclient pkclient');
        $this->db->select('ic.priorityc priorityc');
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

        if (!empty($selected_partnerType)) {
            
            $this->db->where_in('company_master.partnerType_id', $selected_partnerType);
        }

        if (!empty($selected_category)) {
            // var_dump($category);die;
            $this->db->group_start();

            foreach ($selected_category as $singleCategory) {

                if ($singleCategory == 'topspender') {

                    $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'focus_funnel') {

                    $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'upsell_client') {
                    
                    $this->db->or_where('upsell_client', 'yes');

                }
                if($singleCategory == 'keycompany') {
                    
                    $this->db->or_where('keycompany', 'yes');

                }
                if($singleCategory == 'pkclient ') {
                    
                    $this->db->or_where('pkclient', 'yes'); 
                }
                if($singleCategory == 'priorityc ') {
                    
                    $this->db->or_where('priorityc', 'yes');
                }
            }  

            $this->db->group_end(); 
        }

        //if user type is selected
        if (!empty($selected_userType)) {
            $this->db->group_start();
            foreach ($selected_userType as $singleuserType) {
                if ($singleuserType == 4) {
                    $this->db->or_where_in('pst_co', $selected_users);
                } 
                if($singleuserType == 9 || $singleuserType == 13) {
                    $this->db->or_where_in('aadmin', $selected_users);
                }
            } 
            $this->db->group_end();  
        }else{
            $this->db->where_in('admin_id', $uid);
        }

        // if cluster is selected
        if (!empty($selected_cluster)) {
            // var_dump($cluster);die;
            $this->db->where_in('aadmin', $selected_users);
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
        $this->db->where('status.id', $stid );

        $this->db->where('CAST(ic.createDate AS DATE) >=', "'$sdate'", FALSE);
        $this->db->where('CAST(ic.createDate AS DATE) <=', "'$edate'", FALSE);
        // $this->db->where('tblcallevents.remarks !=', '');
        $this->db->group_by('ic.cmpid_id');
        // $this->db->group_by('stname');
        $query = $this->db->get();

        //    echo $this->db->last_query();die;
        return $query->result();
    }

    public function getStatusWiseFunnelData($uid,$sdate,$edate,$selected_partnerType,$arrayselected_cluster,$arrayselected_user,$status_id,$selected_userType,$selected_category){

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
        
        if (!empty($selected_partnerType) ) {

            $this->db->where_in('company_master.partnerType_id', $selected_partnerType);
        }

        // if (!empty($arrayselected_user)) {

        //     $this->db->where_in('user_details.aadmin', $arrayselected_user);
        // }

        if (!empty($selected_category)) {
            // var_dump($category);die;
            $this->db->group_start();

            foreach ($selected_category as $singleCategory) {

                if ($singleCategory == 'topspender') {

                    $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'focus_funnel') {

                    $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'upsell_client') {
                    
                    $this->db->or_where('upsell_client', 'yes');

                }
                if($singleCategory == 'keycompany') {
                    
                    $this->db->or_where('keycompany', 'yes');

                }
                if($singleCategory == 'pkclient ') {
                    
                    $this->db->or_where('pkclient', 'yes'); 
                }
                if($singleCategory == 'priorityc ') {
                    
                    $this->db->or_where('priorityc', 'yes');
                }
            }  

            $this->db->group_end(); 
        }

        // var_dump($selected_userType);die;
        if (!empty($selected_userType)) {
            $this->db->group_start();
            foreach ($selected_userType as $singleuserType) {
                if ($singleuserType == 4) {
                    $this->db->or_where_in('user_details.pst_co', $arrayselected_user);
                } 
                if($singleuserType == 9 || $singleuserType == 13) {
                    $this->db->or_where_in('user_details.aadmin', $arrayselected_user);
                }
                // else{

                //     $this->db->where_in('user_id', $users);
                // }
            } 
            $this->db->group_end();  
        }

        $this->db->where('user_details.status', 'active');
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

    public function getCityWiseGraphDetails($uid, $userTypeid, $sdate, $edate){

            // $query=$this->db->query("Select city.id cityid, company_master.city,COUNT(*) cont from init_call LEFT JOIN user_details ON user_details.user_id=init_call.mainbd LEFT JOIN company_master ON company_master.id=init_call.cmpid_id left join city on city.city=company_master.city WHERE user_details.admin_id='$uid' and user_details.type_id='3' and user_details.status='active' GROUP BY company_master.city,city.id");
            // echo "hii";die;
            $this->db->select('city.id cityid');
            $this->db->select('city.city city');
            $this->db->select('COUNT(*) cont');
            $this->db->from('init_call ic');
            $this->db->join('company_master', 'company_master.id = ic.cmpid_id', 'left');
            $this->db->join('city', 'city.id = company_master.city', 'inner');
            $this->db->join('user_details', 'user_details.user_id = ic.mainbd');

            if ($userTypeid == 2) {

                $this->db->where('user_details.admin_id',$uid);
                
            }elseif ($userTypeid == 4) {
                
                $this->db->where_in('pst_co', $uid);

            }elseif ($userTypeid == 9 || $userTypeid == 13) {
                
                $this->db->where_in('aadmin', $uid);
            }else{
                $this->db->where('user_id', $uid);
            }

            $this->db->where('CAST(ic.createDate AS DATE) >=', "'$sdate'", FALSE);
            $this->db->where('CAST(ic.createDate AS DATE) <=', "'$edate'", FALSE);

            $this->db->group_by('city.city');
            $this->db->group_by('city.id');
            $query = $this->db->get();
            // echo $this->db->last_query();die;

            return $query->result();
    }

    public function getCityWiseTableDetails($uid,$userTypeid,$sdate,$edate){

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
        $this->db->join('city', 'city.id = company_master.city', 'INNER');
        $this->db->join('states', 'states.id = company_master.state', 'left');
        $this->db->join('partner_master', 'partner_master.id = company_master.partnerType_id', 'left');
        $this->db->join('status', 'status.id = ic.cstatus', 'left');
        $this->db->join('user_details', 'user_details.user_id = ic.mainbd', 'left');

        if ($userTypeid == 2) {

            $this->db->where('user_details.admin_id',$uid);
            
        }elseif ($userTypeid == 4) {
            
            $this->db->where_in('pst_co', $uid);

        }elseif ($userTypeid == 9 || $userTypeid == 13) {
            
            $this->db->where_in('aadmin', $uid);
        }else{
            $this->db->where('user_id', $uid);
        }

        $this->db->where('CAST(ic.createDate AS DATE) >=', "'$sdate'", FALSE);
        $this->db->where('CAST(ic.createDate AS DATE) <=', "'$edate'", FALSE);


        $this->db->group_by('company_master.id');

        $query = $this->db->get();
        // echo $this->db->last_query();die;

        return $query->result();
    }
    
    public function getTableDataByCity($uid,$userTypeid,$cityId,$sdate,$edate)
    {   
        // print_r($selected_partnerType[0]);die;
        $this->db->select('ic.id ic_id');
        $this->db->select('ic.focus_funnel focus_funnel');
        $this->db->select('ic.upsell_client upsell_client');
        $this->db->select('ic.keycompany keycompany');
        $this->db->select('ic.pkclient pkclient');
        $this->db->select('ic.priorityc priorityc');
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

        // if (!empty($selected_partnerType)) {
            
        //     $this->db->where_in('company_master.partnerType_id', $selected_partnerType);
        // }

        // if (!empty($selected_category)) {
        //     // var_dump($category);die;
        //     $this->db->group_start();

        //     foreach ($selected_category as $singleCategory) {

        //         if ($singleCategory == 'topspender') {

        //             $this->db->or_where('focus_funnel', 'yes');

        //         }
        //         if($singleCategory == 'focus_funnel') {

        //             $this->db->or_where('focus_funnel', 'yes');

        //         }
        //         if($singleCategory == 'upsell_client') {
                    
        //             $this->db->or_where('upsell_client', 'yes');

        //         }
        //         if($singleCategory == 'keycompany') {
                    
        //             $this->db->or_where('keycompany', 'yes');

        //         }
        //         if($singleCategory == 'pkclient ') {
                    
        //             $this->db->or_where('pkclient', 'yes'); 
        //         }
        //         if($singleCategory == 'priorityc ') {
                    
        //             $this->db->or_where('priorityc', 'yes');
        //         }
        //     }  

        //     $this->db->group_end(); 
        // }

        //if user type is selected
        // if (!empty($selected_userType)) {
        //     $this->db->group_start();
        //     foreach ($selected_userType as $singleuserType) {
        //         if ($singleuserType == 4) {
        //             $this->db->or_where_in('pst_co', $selected_users);
        //         } 
        //         if($singleuserType == 9 || $singleuserType == 13) {
        //             $this->db->or_where_in('aadmin', $selected_users);
        //         }
        //     } 
        //     $this->db->group_end();  
        // }else{
        //     $this->db->where_in('admin_id', $uid);
        // }

        // if cluster is selected
        
        
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
        $this->db->where('company_master.city', $cityId );

        $this->db->where('CAST(ic.createDate AS DATE) >=', "'$sdate'", FALSE);
        $this->db->where('CAST(ic.createDate AS DATE) <=', "'$edate'", FALSE);
        // $this->db->where('tblcallevents.remarks !=', '');
        $this->db->group_by('ic.cmpid_id');
        // $this->db->group_by('stname');
        $query = $this->db->get();

        return $query->result();
    }

    public function getPartnerWiseGraphDetails($uid,$userTypeid,$sdate,$edate,$partnerType){

        $this->db->select('partner_master.id PartnerMasterID');
        $this->db->select('partner_master.name PartnerMasterName');
        $this->db->select('partner_master.clr PartnerMasterclr');
        $this->db->select('COUNT(*) cont');
        $this->db->from('init_call ic');
        $this->db->join('company_master', 'company_master.id = ic.cmpid_id', 'left');
        $this->db->join('partner_master', 'partner_master.id = company_master.partnerType_id', 'left');
        $this->db->join('user_details', 'user_details.user_id = ic.mainbd');

        if ($userTypeid == 2) {

            $this->db->where('user_details.admin_id',$uid);
            
        }elseif ($userTypeid == 4) {
            
            $this->db->where_in('pst_co', $uid);

        }elseif ($userTypeid == 9 || $userTypeid == 13) {
            
            $this->db->where_in('aadmin', $uid);
        }else{
            $this->db->where('user_id', $uid);
        }

        if (!empty($partnerType)) {

            $this->db->where_in('company_master.partnerType_id', $partnerType);
        }


        $this->db->where('CAST(ic.createDate AS DATE) >=', "'$sdate'", FALSE);
        $this->db->where('CAST(ic.createDate AS DATE) <=', "'$edate'", FALSE);

        // $this->db->group_by('PartnerMasterName');
        $this->db->group_by('PartnerMasterID');
        $query = $this->db->get();
        // echo $this->db->last_query();die;

        return $query->result();
    }

    public function getPartnerWiseTableDetails($uid,$userTypeid,$sdate,$edate,$partnerType){

        // echo $partnerType;die;
        $this->db->select('ic.id ic_id');
        $this->db->select('status.clr stclr');
        $this->db->select('status.id stid');
        $this->db->select('status.name stname');
        $this->db->select('company_master.compname company_name');
        $this->db->select('company_master.address company_address');
        $this->db->select('city.city city');
        $this->db->select('states.state state');
        $this->db->select('partner_master.name partner_typeName');
        $this->db->select('partner_master.id partner_typeID');
        $this->db->select('partner_master.clr PartnerMasterclr');
        $this->db->from('init_call ic');
        $this->db->join('company_master', 'company_master.id = ic.cmpid_id', 'left');
        $this->db->join('city', 'city.id = company_master.city', 'left');
        $this->db->join('states', 'states.id = company_master.state', 'left');
        $this->db->join('partner_master', 'partner_master.id = company_master.partnerType_id', 'left');
        $this->db->join('status', 'status.id = ic.cstatus', 'left');
        $this->db->join('user_details', 'user_details.user_id = ic.mainbd', 'left');
        
        
        if ($userTypeid == 2) {

            $this->db->where('user_details.admin_id',$uid);
            
        }elseif ($userTypeid == 4) {
            
            $this->db->where_in('pst_co', $uid);

        }elseif ($userTypeid == 9 || $userTypeid == 13) {
            
            $this->db->where_in('aadmin', $uid);
        }else{
            $this->db->where('user_id', $uid);
        }


        if (!empty($partnerType)) {

            $this->db->where_in('company_master.partnerType_id', $partnerType);
        }
    
        $this->db->where('CAST(ic.createDate AS DATE) >=', "'$sdate'", FALSE);
        $this->db->where('CAST(ic.createDate AS DATE) <=', "'$edate'", FALSE);

        $query = $this->db->get();
        // echo $this->db->last_query();die;

        return $query->result();
    
    }

    public function getTableDataByPartnerType($uid,$userTypeid,$PartnerMasterID,$sdate,$edate)
    {   
        // print_r($selected_partnerType[0]);die;
        $this->db->select('ic.id ic_id');
        $this->db->select('ic.focus_funnel focus_funnel');
        $this->db->select('ic.upsell_client upsell_client');
        $this->db->select('ic.keycompany keycompany');
        $this->db->select('ic.pkclient pkclient');
        $this->db->select('ic.priorityc priorityc');
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

        if (!empty($PartnerMasterID)) {
            
            $this->db->where_in('company_master.partnerType_id', $PartnerMasterID);
        }

        // if (!empty($selected_category)) {
        //     // var_dump($category);die;
        //     $this->db->group_start();

        //     foreach ($selected_category as $singleCategory) {

        //         if ($singleCategory == 'topspender') {

        //             $this->db->or_where('focus_funnel', 'yes');

        //         }
        //         if($singleCategory == 'focus_funnel') {

        //             $this->db->or_where('focus_funnel', 'yes');

        //         }
        //         if($singleCategory == 'upsell_client') {
                    
        //             $this->db->or_where('upsell_client', 'yes');

        //         }
        //         if($singleCategory == 'keycompany') {
                    
        //             $this->db->or_where('keycompany', 'yes');

        //         }
        //         if($singleCategory == 'pkclient ') {
                    
        //             $this->db->or_where('pkclient', 'yes'); 
        //         }
        //         if($singleCategory == 'priorityc ') {
                    
        //             $this->db->or_where('priorityc', 'yes');
        //         }
        //     }  

        //     $this->db->group_end(); 
        // }

        //if user type is selected
        // if (!empty($selected_userType)) {
        //     $this->db->group_start();
        //     foreach ($selected_userType as $singleuserType) {
        //         if ($singleuserType == 4) {
        //             $this->db->or_where_in('pst_co', $selected_users);
        //         } 
        //         if($singleuserType == 9 || $singleuserType == 13) {
        //             $this->db->or_where_in('aadmin', $selected_users);
        //         }
        //     } 
        //     $this->db->group_end();  
        // }else{
        //     $this->db->where_in('admin_id', $uid);
        // }

        // if cluster is selected
        
        
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
        $this->db->where('company_master.partnerType_id', $PartnerMasterID );

        $this->db->where('CAST(ic.createDate AS DATE) >=', "'$sdate'", FALSE);
        $this->db->where('CAST(ic.createDate AS DATE) <=', "'$edate'", FALSE);
        // $this->db->where('tblcallevents.remarks !=', '');
        $this->db->group_by('ic.cmpid_id');
        // $this->db->group_by('stname');
        $query = $this->db->get();

        // echo $this->db->last_query();die;
        return $query->result();
    }
    public function getCategoryWiseGraphDetails($uid,$userTypeid,$sdate,$edate,$category){

        // print_r($category);die;
        $this->db->select("
                COUNT(CASE WHEN topspender != 'yes' AND focus_funnel != 'yes' AND upsell_client != 'yes' AND keycompany != 'yes' AND pkclient != 'yes' AND priorityc != 'yes' THEN 1 END) AS nocat,
                COUNT(CASE WHEN topspender = 'yes' THEN 1 END) AS topspender,
                COUNT(CASE WHEN focus_funnel = 'yes' THEN 1 END) AS focus_funnel,
                COUNT(CASE WHEN upsell_client = 'yes' THEN 1 END) AS upsell_client,
                COUNT(CASE WHEN keycompany = 'yes' THEN 1 END) AS keycompany,
                COUNT(CASE WHEN pkclient = 'yes' THEN 1 END) AS pkclient,
                COUNT(CASE WHEN priorityc = 'yes' THEN 1 END) AS priorityc
            ");

        
        $this->db->from('init_call ic');
        $this->db->join('user_details', 'user_details.user_id = ic.mainbd','left');
        $this->db->join('company_master', 'company_master.id = ic.cmpid_id', 'left');
        $this->db->join('partner_master', 'partner_master.id = company_master.partnerType_id', 'left');
        if ($userTypeid == 2) {

            $this->db->where('user_details.admin_id',$uid);
            
        }elseif ($userTypeid == 4) {
            
            $this->db->where_in('pst_co', $uid);

        }elseif ($userTypeid == 9 || $userTypeid == 13) {
            
            $this->db->where_in('aadmin', $uid);
        }else{
            $this->db->where('user_id', $uid);
        }

        if ($category != '') {

            $this->db->group_start();

            foreach ($category as $singleCategory) {

                if ($singleCategory == 'topspender') {

                     $this->db->or_where('topspender', 'yes');

                }
                if($singleCategory == 'focus_funnel') {

                    $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'upsell_client') {
                    
                    $this->db->or_where('upsell_client', 'yes');

                }
                if($singleCategory == 'keycompany') {
                    
                    $this->db->or_where('keycompany', 'yes');

                }
                if($singleCategory == 'pkclient ') {
                    
                    $this->db->or_where('pkclient', 'yes'); 
                }
                if($singleCategory == 'priorityc ') {
                    
                    $this->db->or_where('priorityc', 'yes');
                }
            }  

            $this->db->group_end(); 

        }


        $this->db->where('CAST(ic.createDate AS DATE) >=', "'$sdate'", FALSE);
        $this->db->where('CAST(ic.createDate AS DATE) <=', "'$edate'", FALSE);

        $query = $this->db->get();
// echo $this->db->last_query();die;
        return $query->result();    
    }

    public function getCategoryWiseTableDetails($uid,$userTypeid,$sdate,$edate,$category){

        $this->db->select('ic.id ic_id');
        $this->db->select('ic.topspender topspender');
        $this->db->select('ic.focus_funnel focus_funnel');
        $this->db->select('ic.upsell_client upsell_client');
        $this->db->select('ic.keycompany keycompany');
        $this->db->select('ic.pkclient pkclient');
        $this->db->select('ic.priorityc priorityc');
        $this->db->select('status.clr stclr');
        $this->db->select('status.id stid');
        $this->db->select('status.name stname');
        $this->db->select('company_master.compname company_name');
        $this->db->select('company_master.address company_address');
        $this->db->select('city.city city');
        $this->db->select('states.state state');
        $this->db->select('partner_master.name partner_typeName');
        $this->db->select('partner_master.id partner_typeID');
        $this->db->select('partner_master.clr PartnerMasterclr');
        $this->db->from('init_call ic');
        $this->db->join('company_master', 'company_master.id = ic.cmpid_id', 'left');
        $this->db->join('city', 'city.id = company_master.city', 'left');
        $this->db->join('states', 'states.id = company_master.state', 'left');
        $this->db->join('partner_master', 'partner_master.id = company_master.partnerType_id', 'left');
        $this->db->join('status', 'status.id = ic.cstatus', 'left');
        $this->db->join('user_details', 'user_details.user_id = ic.mainbd', 'left');
        
        
        if ($userTypeid == 2) {

            $this->db->where('user_details.admin_id',$uid);
            
        }elseif ($userTypeid == 4) {
            
            $this->db->where_in('pst_co', $uid);

        }elseif ($userTypeid == 9 || $userTypeid == 13) {
            
            $this->db->where_in('aadmin', $uid);
        }else{
            $this->db->where('user_id', $uid);
        }

        if ($category != '') {

            foreach ($category as $singleCategory) {

                if ($singleCategory == 'topspender') {

                     $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'focus_funnel') {

                    $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'upsell_client') {
                    
                    $this->db->or_where('upsell_client', 'yes');

                }
                if($singleCategory == 'keycompany') {
                    
                    $this->db->or_where('keycompany', 'yes');

                }
                if($singleCategory == 'pkclient ') {
                    
                    $this->db->or_where('pkclient', 'yes'); 
                }
                if($singleCategory == 'priorityc ') {
                    
                    $this->db->or_where('priorityc', 'yes');
                }
            }  

        }

        $this->db->where('CAST(ic.createDate AS DATE) >=', "'$sdate'", FALSE);
        $this->db->where('CAST(ic.createDate AS DATE) <=', "'$edate'", FALSE);

        $query = $this->db->get();
        // echo $this->db->last_query();die;

        return $query->result();
    }

    public function getTableDataByCategory($uid,$userTypeid,$Category,$sdate,$edate)
    {   
        // print_r($selected_partnerType[0]);die;
        $this->db->select('ic.id ic_id');
        $this->db->select('ic.focus_funnel focus_funnel');
        $this->db->select('ic.upsell_client upsell_client');
        $this->db->select('ic.keycompany keycompany');
        $this->db->select('ic.pkclient pkclient');
        $this->db->select('ic.priorityc priorityc');
        $this->db->select('ic.topspender topspender');
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

        // if (!empty($selected_partnerType)) {
            
        //     $this->db->where_in('company_master.partnerType_id', $selected_partnerType);
        // }

        // if (!empty($selected_category)) {
        //     // var_dump($category);die;
        //     $this->db->group_start();

        //     foreach ($selected_category as $singleCategory) {

        //         if ($singleCategory == 'topspender') {

        //             $this->db->or_where('focus_funnel', 'yes');

        //         }
        //         if($singleCategory == 'focus_funnel') {

        //             $this->db->or_where('focus_funnel', 'yes');

        //         }
        //         if($singleCategory == 'upsell_client') {
                    
        //             $this->db->or_where('upsell_client', 'yes');

        //         }
        //         if($singleCategory == 'keycompany') {
                    
        //             $this->db->or_where('keycompany', 'yes');

        //         }
        //         if($singleCategory == 'pkclient ') {
                    
        //             $this->db->or_where('pkclient', 'yes'); 
        //         }
        //         if($singleCategory == 'priorityc ') {
                    
        //             $this->db->or_where('priorityc', 'yes');
        //         }
        //     }  

        //     $this->db->group_end(); 
        // }

        //if user type is selected
        // if (!empty($selected_userType)) {
        //     $this->db->group_start();
        //     foreach ($selected_userType as $singleuserType) {
        //         if ($singleuserType == 4) {
        //             $this->db->or_where_in('pst_co', $selected_users);
        //         } 
        //         if($singleuserType == 9 || $singleuserType == 13) {
        //             $this->db->or_where_in('aadmin', $selected_users);
        //         }
        //     } 
        //     $this->db->group_end();  
        // }else{
        //     $this->db->where_in('admin_id', $uid);
        // }

        // if cluster is selected
        
        if ($Category == 'focus_funnel') {
            
            $this->db->where('ic.focus_funnel', 'yes');

        }
        elseif ($Category == 'upsell_client') {
            
            $this->db->where('ic.upsell_client', 'yes');

        }
        elseif ($Category == 'keycompany') {
            
            $this->db->where('ic.keycompany', 'yes');

        }
        elseif ($Category == 'pkclient') {
            
            $this->db->where('ic.pkclient', 'yes');

        }
        elseif ($Category == 'topspender') {
            
            $this->db->where('ic.topspender', 'yes');

        }
        elseif ($Category == 'priorityc') {
            
            $this->db->where('ic.priorityc', 'yes');

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
        // $this->db->where('company_master.partnerType_id', $PartnerMasterID );

        $this->db->where('CAST(ic.createDate AS DATE) >=', "'$sdate'", FALSE);
        $this->db->where('CAST(ic.createDate AS DATE) <=', "'$edate'", FALSE);
        // $this->db->where('tblcallevents.remarks !=', '');
        $this->db->group_by('ic.cmpid_id');
        // $this->db->group_by('stname');
        $query = $this->db->get();

        return $query->result();
    }

    public function getCompanyWithSameStatusTableDetails($uid,$userTypeid,$sdate,$edate,$SelectedStatus,$SelectedCluster,$SelectedCategory,$SelectedUsers){

        $subquery = $this->db->select('ic.id')
        ->from('init_call ic')
        ->join('user_details', 'user_details.user_id = ic.mainbd', 'left')
        ->where('CAST(ic.createDate AS DATE) >=', "'$sdate'", FALSE)
        ->where('CAST(ic.createDate AS DATE) <=', "'$edate'", FALSE);

        if ($userTypeid == 2) {

            $this->db->where('user_details.admin_id',$uid);

        }elseif ($userTypeid == 4) {

            $this->db->where_in('pst_co', $uid);

        }elseif ($userTypeid == 9 || $userTypeid == 13) {

            $this->db->where_in('aadmin', $uid);

        }else{

            $this->db->where('user_id', $uid);
        }
        
        $subquery = $subquery->get_compiled_select();

        $this->db->select('ic1.id ic_id');
        $this->db->select('ic1.topspender topspender');
        $this->db->select('ic1.focus_funnel focus_funnel');
        $this->db->select('ic1.upsell_client upsell_client');
        $this->db->select('ic1.keycompany keycompany');
        $this->db->select('ic1.pkclient pkclient');
        $this->db->select('ic1.priorityc priorityc');
        $this->db->select('status.clr stclr');
        $this->db->select('status.id stid');
        $this->db->select('status.name stname');
        $this->db->select('company_master.compname company_name');
        $this->db->select('company_master.address company_address');
        $this->db->select('city.city city');
        $this->db->select('states.state state');
        $this->db->select('partner_master.name partner_typeName');
        $this->db->select('partner_master.id partner_typeID');
        $this->db->select('partner_master.clr PartnerMasterclr');
        $this->db->from('init_call ic1');
        $this->db->join('company_master', 'company_master.id = ic1.cmpid_id', 'left');
        $this->db->join('city', 'city.id = company_master.city', 'left');
        $this->db->join('states', 'states.id = company_master.state', 'left');
        $this->db->join('partner_master', 'partner_master.id = company_master.partnerType_id', 'left');
        // $this->db->join('status', 'status.id = ic.cstatus', 'left');
        $this->db->join('user_details', 'user_details.user_id = ic1.mainbd', 'left');

        $this->db->join('tblcallevents', 'ic1.id = tblcallevents.cid_id', 'LEFT');
        $this->db->join('status', 'ic1.cstatus = status.id', 'LEFT');

        $this->db->where("tblcallevents.cid_id IN ($subquery)", NULL, FALSE);
        $this->db->where('tblcallevents.nextCFID !=', '0');

        if (!empty($SelectedStatus)) {

            $this->db->where_in('ic1.cstatus', $SelectedStatus);
        }

        if (!empty($SelectedpartnerType)) {
            
            $this->db->where_in('company_master.partnerType_id', $SelectedpartnerType);
        }

        if (!empty($SelectedUsers)) {
            
            $this->db->where_in('user_details.aadmin', $SelectedUsers);
        }

        if (!empty($SelectedCategory)) {

            $this->db->group_start();

            foreach ($SelectedCategory as $singleCategory) {

                if ($singleCategory == 'topspender') {

                     $this->db->or_where('ic1.topspender', 'yes');

                }
                if($singleCategory == 'focus_funnel') {

                    $this->db->or_where('ic1.focus_funnel', 'yes');

                }
                if($singleCategory == 'upsell_client') {
                    
                    $this->db->or_where('ic1.upsell_client', 'yes');

                }
                if($singleCategory == 'keycompany') {
                    
                    $this->db->or_where('ic1.keycompany', 'yes');

                }
                if($singleCategory == 'pkclient ') {
                    
                    $this->db->or_where('ic1.pkclient', 'yes'); 
                }
                if($singleCategory == 'priorityc ') {
                    
                    $this->db->or_where('ic1.priorityc', 'yes');
                }
            }  

            $this->db->group_end(); 
        }
        
        $this->db->group_by('ic1.id');

        $query = $this->db->get();

        return $query->result();

    }

    public function SameStatusTillDateByStatus($uid,$userTypeid,$sdate,$edate,$status,$SelectedCluster,$SelectedCategory,$SelectedUsers,$SelectedpartnerType){

        $subquery = $this->db->select('ic.id')
        ->from('init_call ic')
        ->join('user_details', 'user_details.user_id = ic.mainbd', 'left')
        ->where('CAST(init_call.createDate AS DATE) >=', "'$sdate'", FALSE)
        ->where('CAST(init_call.createDate AS DATE) <=', "'$edate'", FALSE);

        if ($userTypeid == 2) {

            $this->db->where('user_details.admin_id',$uid);

        }elseif ($userTypeid == 4) {

            $this->db->where_in('pst_co', $uid);

        }elseif ($userTypeid == 9 || $userTypeid == 13) {

            $this->db->where_in('aadmin', $uid);

        }else{

            $this->db->where('user_id', $uid);
        }
        
        $subquery = $subquery->get_compiled_select();

        $this->db->select("TIMESTAMPDIFF(DAY, MAX(tblcallevents.updateddate), NOW()) AS opensday");
        $this->db->select("status.name");
        $this->db->from('tblcallevents');
        $this->db->join('init_call', 'init_call.id = tblcallevents.cid_id', 'LEFT');
        $this->db->join('status', 'init_call.cstatus = status.id', 'LEFT');
        $this->db->join('company_master', 'init_call.cmpid_id = company_master.id', 'LEFT');
        $this->db->join('user_details ud', 'ud.user_id = init_call.mainbd', 'left');
        $this->db->where("tblcallevents.cid_id IN ($subquery)", NULL, FALSE);
        $this->db->where('tblcallevents.nextCFID !=', '0');
        $this->db->where('init_call.cstatus', $status);
        
        if (!empty($SelectedpartnerType)) {
            
            $this->db->where_in('company_master.partnerType_id', $SelectedpartnerType);
        }

        if (!empty($SelectedUsers)) {
            
            $this->db->where_in('ud.aadmin', $SelectedUsers);
        }

        if (!empty($SelectedCategory)) {

            $this->db->group_start();

            foreach ($SelectedCategory as $singleCategory) {

                if ($singleCategory == 'topspender') {

                     $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'focus_funnel') {

                    $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'upsell_client') {
                    
                    $this->db->or_where('upsell_client', 'yes');

                }
                if($singleCategory == 'keycompany') {
                    
                    $this->db->or_where('keycompany', 'yes');

                }
                if($singleCategory == 'pkclient ') {
                    
                    $this->db->or_where('pkclient', 'yes'); 
                }
                if($singleCategory == 'priorityc ') {
                    
                    $this->db->or_where('priorityc', 'yes');
                }
            }  

            $this->db->group_end(); 
        }

        $this->db->group_by('init_call.id');

// Execute the query
        $query = $this->db->get();
        // echo $this->db->last_query();die;
        return $query->result();

    }

    public function getTableDataOfCompanyWithSameStatus($uid,$userTypeid,$selectedStatus,$sdate,$edate,$selected_partnerType,$selected_category,$selected_userType,$selected_users,$selected_cluster){

        $subquery = $this->db->select('ic.id')
        ->from('init_call ic')
        ->join('user_details', 'user_details.user_id = ic.mainbd', 'left')
        ->where('CAST(ic.createDate AS DATE) >=', "'$sdate'", FALSE)
        ->where('CAST(ic.createDate AS DATE) <=', "'$edate'", FALSE);

        if ($userTypeid == 2) {

            $this->db->where('user_details.admin_id',$uid);

        }elseif ($userTypeid == 4) {

            $this->db->where_in('pst_co', $uid);

        }elseif ($userTypeid == 9 || $userTypeid == 13) {

            $this->db->where_in('aadmin', $uid);

        }else{

            $this->db->where('user_id', $uid);
        }
        
        $subquery = $subquery->get_compiled_select();

        $this->db->select('ic1.id ic_id');
        $this->db->select('ic1.topspender topspender');
        $this->db->select('ic1.focus_funnel focus_funnel');
        $this->db->select('ic1.upsell_client upsell_client');
        $this->db->select('ic1.keycompany keycompany');
        $this->db->select('ic1.pkclient pkclient');
        $this->db->select('ic1.priorityc priorityc');
        $this->db->select('status.clr stclr');
        $this->db->select('status.id stid');
        $this->db->select('status.name stname');
        $this->db->select('company_master.compname company_name');
        $this->db->select('company_master.address company_address');
        $this->db->select('city.city city');
        $this->db->select('states.state state');
        $this->db->select('partner_master.name partner_typeName');
        $this->db->select('partner_master.id partner_typeID');
        $this->db->select('partner_master.clr PartnerMasterclr');
        $this->db->from('init_call ic1');
        $this->db->join('company_master', 'company_master.id = ic1.cmpid_id', 'left');
        $this->db->join('city', 'city.id = company_master.city', 'left');
        $this->db->join('states', 'states.id = company_master.state', 'left');
        $this->db->join('partner_master', 'partner_master.id = company_master.partnerType_id', 'left');
        // $this->db->join('status', 'status.id = ic.cstatus', 'left');
        $this->db->join('user_details', 'user_details.user_id = ic1.mainbd', 'left');

        $this->db->join('tblcallevents', 'ic1.id = tblcallevents.cid_id', 'LEFT');
        $this->db->join('status', 'ic1.cstatus = status.id', 'LEFT');

        $this->db->where("tblcallevents.cid_id IN ($subquery)", NULL, FALSE);
        $this->db->where('tblcallevents.nextCFID !=', '0');
        // $this->db->where('ic1.cstatus', $selectedStatus);

        if (!empty($selectedStatus)) {

            $this->db->where('ic1.cstatus', $selectedStatus);
        }

        if (!empty($selected_partnerType)) {
            
            $this->db->where_in('company_master.partnerType_id', $selected_partnerType);
        }

        if (!empty($selected_users)) {
            
            $this->db->where_in('user_details.aadmin', $selected_users);
        }

        if (!empty($selected_category)) {

            $this->db->group_start();

            foreach ($selected_category as $singleCategory) {

                if ($singleCategory == 'topspender') {

                     $this->db->or_where('ic1.focus_funnel', 'yes');

                }
                if($singleCategory == 'focus_funnel') {

                    $this->db->or_where('ic1.focus_funnel', 'yes');

                }
                if($singleCategory == 'upsell_client') {
                    
                    $this->db->or_where('ic1.upsell_client', 'yes');

                }
                if($singleCategory == 'keycompany') {
                    
                    $this->db->or_where('ic1.keycompany', 'yes');

                }
                if($singleCategory == 'pkclient ') {
                    
                    $this->db->or_where('ic1.pkclient', 'yes'); 
                }
                if($singleCategory == 'priorityc ') {
                    
                    $this->db->or_where('ic1.priorityc', 'yes');
                }
            }  

            $this->db->group_end(); 
        }
        
        $this->db->group_by('ic1.id');

        $query = $this->db->get();

        // echo $this->db->last_query();die;
        return $query->result();
    }

    public function getStageWiseFunnelGraphDetails($uid,$userTypeid,$sdate,$edate,$status,$SelectedCluster,$SelectedCategory,$SelectedUsers,$SelectedpartnerType){

        // var_dump($SelectedCluster);die;

        $this->db->select("
            SUM(CASE WHEN init_call.cstatus = '1' THEN 1 ELSE 0 END) +
            SUM(CASE WHEN init_call.cstatus = '8' THEN 1 ELSE 0 END) +
            SUM(CASE WHEN init_call.cstatus = '2' THEN 1 ELSE 0 END) +
            SUM(CASE WHEN init_call.cstatus = '10' THEN 1 ELSE 0 END) +
            SUM(CASE WHEN init_call.cstatus = '11' THEN 1 ELSE 0 END) AS stage1, 
            SUM(CASE WHEN init_call.cstatus = '3' THEN 1 ELSE 0 END) AS stage2,
            SUM(CASE WHEN init_call.cstatus = '6' THEN 1 ELSE 0 END) +
            SUM(CASE WHEN init_call.cstatus = '9' THEN 1 ELSE 0 END) +
            SUM(CASE WHEN init_call.cstatus = '12' THEN 1 ELSE 0 END) +
            SUM(CASE WHEN init_call.cstatus = '13' THEN 1 ELSE 0 END) AS stage3,
            SUM(CASE WHEN init_call.cstatus = '7' THEN 1 ELSE 0 END) AS stage4
        ");

        //stage 1 -> Open,Reachout,OPEN RPEM,TTD-Reachout,WNO-Reachout
        //stage 2 -> tentative
        //stage 3 -> positive
        //stage 4 -> Closuer

        $this->db->from('init_call');
        $this->db->join('user_details', 'user_details.user_id = init_call.mainbd', 'LEFT');
        $this->db->join('status', 'status.id = init_call.cstatus','LEFT');
        $this->db->join('company_master', 'init_call.cmpid_id = company_master.id', 'LEFT');

        if (!empty($SelectedCategory)) {

            $this->db->group_start();

            foreach ($SelectedCategory as $singleCategory) {

                if ($singleCategory == 'topspender') {

                     $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'focus_funnel') {

                    $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'upsell_client') {
                    
                    $this->db->or_where('upsell_client', 'yes');

                }
                if($singleCategory == 'keycompany') {
                    
                    $this->db->or_where('keycompany', 'yes');

                }
                if($singleCategory == 'pkclient ') {
                    
                    $this->db->or_where('pkclient', 'yes'); 
                }
                if($singleCategory == 'priorityc ') {
                    
                    $this->db->or_where('priorityc', 'yes');
                }
            }  

            $this->db->group_end(); 
        }

        if (!empty($SelectedpartnerType)) {
            
            $this->db->where_in('company_master.partnerType_id', $SelectedpartnerType);
        }

        if ($userTypeid == 2) {

            $this->db->where('user_details.admin_id',$uid);

        }elseif ($userTypeid == 4) {

            $this->db->where_in('pst_co', $uid);

        }elseif ($userTypeid == 9 || $userTypeid == 13) {

            $this->db->where_in('aadmin', $uid);

        }else{

            $this->db->where('user_id', $uid);
        }

        if (!empty($SelectedUsers)) {
            
            $this->db->where_in('user_details.aadmin', $SelectedUsers);
        }

        $this->db->where('CAST(init_call.createDate AS DATE) >=', "'$sdate'", FALSE);
        $this->db->where('CAST(init_call.createDate AS DATE) <=', "'$edate'", FALSE);
        $query = $this->db->get();

        // echo $this->db->last_query();die;
        return $query->result();

    }

    public function getFunnelDetails($uid,$userTypeid,$sdate,$edate,$status,$SelectedCluster,$SelectedCategory,$SelectedUsers,$SelectedpartnerType,$statusArray){

        $this->db->select('status.name statusName');
        $this->db->select('status.id statusId');
        $this->db->select('COUNT(*) cont');

        $this->db->from('init_call');
        $this->db->join('user_details', 'user_details.user_id = init_call.mainbd', 'left');
        $this->db->join('status', 'status.id = init_call.cstatus', 'left');
        $this->db->join('company_master', 'init_call.cmpid_id = company_master.id', 'LEFT');


        if (!empty($SelectedCategory)) {

            $this->db->group_start();

            foreach ($SelectedCategory as $singleCategory) {

                if ($singleCategory == 'topspender') {

                     $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'focus_funnel') {

                    $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'upsell_client') {
                    
                    $this->db->or_where('upsell_client', 'yes');

                }
                if($singleCategory == 'keycompany') {
                    
                    $this->db->or_where('keycompany', 'yes');

                }
                if($singleCategory == 'pkclient ') {
                    
                    $this->db->or_where('pkclient', 'yes'); 
                }
                if($singleCategory == 'priorityc ') {
                    
                    $this->db->or_where('priorityc', 'yes');
                }
            }  

            $this->db->group_end(); 
        }

        if (!empty($SelectedpartnerType)) {
            
            $this->db->where_in('company_master.partnerType_id', $SelectedpartnerType);
        }

        if ($userTypeid == 2) {

            $this->db->where('user_details.admin_id',$uid);

        }elseif ($userTypeid == 4) {

            $this->db->where_in('pst_co', $uid);

        }elseif ($userTypeid == 9 || $userTypeid == 13) {

            $this->db->where_in('aadmin', $uid);

        }else{

            $this->db->where('user_id', $uid);
        }

        if (!empty($SelectedUsers)) {
            
            $this->db->where_in('user_details.aadmin', $SelectedUsers);
        }

        
        $this->db->where_in('init_call.cstatus', $statusArray);
        $this->db->where('CAST(init_call.createDate AS DATE) >=', "'$sdate'", FALSE);
         $this->db->where('CAST(init_call.createDate AS DATE) <=', "'$edate'", FALSE);
        $this->db->group_by('statusName');
        $query = $this->db->get();
        // echo $this->db->last_query();die;
        return $query->result();
    }

    public function getStageWiseFunnelTableDetails($uid,$userTypeid,$sdate,$edate,$SelectedStatus,$SelectedCluster,$SelectedCategory,$SelectedUsers,$SelectedpartnerType){

        $this->db->select('ic.id ic_id');
        $this->db->select('ic.topspender topspender');
        $this->db->select('ic.focus_funnel focus_funnel');
        $this->db->select('ic.upsell_client upsell_client');
        $this->db->select('ic.keycompany keycompany');
        $this->db->select('ic.pkclient pkclient');
        $this->db->select('ic.priorityc priorityc');
        $this->db->select('status.clr stclr');
        $this->db->select('status.id stid');
        $this->db->select('status.name stname');
        $this->db->select('company_master.compname company_name');
        $this->db->select('company_master.address company_address');
        $this->db->select('city.city city');
        $this->db->select('states.state state');
        $this->db->select('partner_master.name partner_typeName');
        $this->db->select('partner_master.id partner_typeID');
        $this->db->select('partner_master.clr PartnerMasterclr');
        $this->db->from('init_call ic');
        $this->db->join('company_master', 'company_master.id = ic.cmpid_id', 'left');
        $this->db->join('city', 'city.id = company_master.city', 'left');
        $this->db->join('states', 'states.id = company_master.state', 'left');
        $this->db->join('partner_master', 'partner_master.id = company_master.partnerType_id', 'left');
        $this->db->join('status', 'status.id = ic.cstatus', 'left');
        $this->db->join('user_details', 'user_details.user_id = ic.mainbd', 'left');
        
        if (!empty($SelectedCategory)) {

            $this->db->group_start();

            foreach ($SelectedCategory as $singleCategory) {

                if ($singleCategory == 'topspender') {

                     $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'focus_funnel') {

                    $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'upsell_client') {
                    
                    $this->db->or_where('upsell_client', 'yes');

                }
                if($singleCategory == 'keycompany') {
                    
                    $this->db->or_where('keycompany', 'yes');

                }
                if($singleCategory == 'pkclient ') {
                    
                    $this->db->or_where('pkclient', 'yes'); 
                }
                if($singleCategory == 'priorityc ') {
                    
                    $this->db->or_where('priorityc', 'yes');
                }
            }  

            $this->db->group_end(); 
        }

        if (!empty($SelectedpartnerType)) {
            
            $this->db->where_in('company_master.partnerType_id', $SelectedpartnerType);
        }
        

        if ($userTypeid == 2) {

            $this->db->where('user_details.admin_id',$uid);
            
        }elseif ($userTypeid == 4) {
            
            $this->db->where_in('pst_co', $uid);

        }elseif ($userTypeid == 9 || $userTypeid == 13) {
            
            $this->db->where_in('aadmin', $uid);
        }else{
            $this->db->where('user_id', $uid);
        }

        if (!empty($SelectedUsers)) {
            
            $this->db->where_in('user_details.aadmin', $SelectedUsers);
        }
       

        $this->db->where('CAST(ic.createDate AS DATE) >=', "'$sdate'", FALSE);
        $this->db->where('CAST(ic.createDate AS DATE) <=', "'$edate'", FALSE);

        $query = $this->db->get();
        // echo $this->db->last_query();die;
        return $query->result();
    }

    public function getTableDataStageWiseFunnel($uid,$userTypeid,$selectedStatus,$sdate,$edate,$selected_partnerType,$selected_category,$selected_users,$selected_cluster){

        $this->db->select('ic.id ic_id');
        $this->db->select('ic.topspender topspender');
        $this->db->select('ic.focus_funnel focus_funnel');
        $this->db->select('ic.upsell_client upsell_client');
        $this->db->select('ic.keycompany keycompany');
        $this->db->select('ic.pkclient pkclient');
        $this->db->select('ic.priorityc priorityc');
        $this->db->select('status.clr stclr');
        $this->db->select('status.id stid');
        $this->db->select('status.name stname');
        $this->db->select('company_master.compname company_name');
        $this->db->select('company_master.address company_address');
        $this->db->select('city.city city');
        $this->db->select('states.state state');
        $this->db->select('partner_master.name partner_typeName');
        $this->db->select('partner_master.id partner_typeID');
        $this->db->select('partner_master.clr PartnerMasterclr');
        $this->db->from('init_call ic');
        $this->db->join('company_master', 'company_master.id = ic.cmpid_id', 'left');
        $this->db->join('city', 'city.id = company_master.city', 'left');
        $this->db->join('states', 'states.id = company_master.state', 'left');
        $this->db->join('partner_master', 'partner_master.id = company_master.partnerType_id', 'left');
        $this->db->join('status', 'status.id = ic.cstatus', 'left');
        $this->db->join('user_details', 'user_details.user_id = ic.mainbd', 'left');
        
        if (!empty($selected_category)) {

            $this->db->group_start();

            foreach ($selected_category as $singleCategory) {

                if ($singleCategory == 'topspender') {

                     $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'focus_funnel') {

                    $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'upsell_client') {
                    
                    $this->db->or_where('upsell_client', 'yes');

                }
                if($singleCategory == 'keycompany') {
                    
                    $this->db->or_where('keycompany', 'yes');

                }
                if($singleCategory == 'pkclient ') {
                    
                    $this->db->or_where('pkclient', 'yes'); 
                }
                if($singleCategory == 'priorityc ') {
                    
                    $this->db->or_where('priorityc', 'yes');
                }
            }  

            $this->db->group_end(); 
        }

        if (!empty($selected_partnerType)) {
            
            $this->db->where_in('company_master.partnerType_id', $selected_partnerType);
        }
        
        $this->db->where_in('ic.cstatus', $selectedStatus);

        if ($userTypeid == 2) {

            $this->db->where('user_details.admin_id',$uid);
            
        }elseif ($userTypeid == 4) {
            
            $this->db->where_in('pst_co', $uid);

        }elseif ($userTypeid == 9 || $userTypeid == 13) {
            
            $this->db->where_in('aadmin', $uid);
        }else{
            $this->db->where('user_id', $uid);
        }

        if (!empty($selected_users)) {
            
            $this->db->where_in('user_details.aadmin', $selected_users);
        }
       

        $this->db->where('CAST(ic.createDate AS DATE) >=', "'$sdate'", FALSE);
        $this->db->where('CAST(ic.createDate AS DATE) <=', "'$edate'", FALSE);

        $query = $this->db->get();
        // echo $this->db->last_query();die;
        return $query->result();
    }


    public function StatusWiseTaskTableDetails($uid, $userTypeid, $sdate, $edate, $Selected_userType, $Selected_cluster, $Selected_partnerType, $Selected_category, $Selected_users){

        $this->db->select('ic.id ic_id');
        $this->db->select('ic.topspender topspender');
        $this->db->select('ic.focus_funnel focus_funnel');
        $this->db->select('ic.upsell_client upsell_client');
        $this->db->select('ic.keycompany keycompany');
        $this->db->select('ic.pkclient pkclient');
        $this->db->select('ic.priorityc priorityc');
        $this->db->select('status.clr stclr');
        $this->db->select('status.id stid');
        $this->db->select('status.name stname');
        $this->db->select('company_master.compname company_name');
        $this->db->select('company_master.address company_address');
        $this->db->select('city.city city');
        $this->db->select('states.state state');
        $this->db->select('partner_master.name partner_typeName');
        $this->db->select('partner_master.id partner_typeID');
        $this->db->select('partner_master.clr PartnerMasterclr');
        $this->db->from('init_call ic');
        $this->db->join('company_master', 'company_master.id = ic.cmpid_id', 'left');
        $this->db->join('city', 'city.id = company_master.city', 'left');
        $this->db->join('states', 'states.id = company_master.state', 'left');
        $this->db->join('partner_master', 'partner_master.id = company_master.partnerType_id', 'left');
        $this->db->join('status', 'status.id = ic.cstatus', 'left');
        $this->db->join('user_details', 'user_details.user_id = ic.mainbd', 'left');
        
        if (!empty($Selected_category)) {

            $this->db->group_start();

            foreach ($Selected_category as $singleCategory) {

                if ($singleCategory == 'topspender') {

                     $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'focus_funnel') {

                    $this->db->or_where('focus_funnel', 'yes');

                }
                if($singleCategory == 'upsell_client') {
                    
                    $this->db->or_where('upsell_client', 'yes');

                }
                if($singleCategory == 'keycompany') {
                    
                    $this->db->or_where('keycompany', 'yes');

                }
                if($singleCategory == 'pkclient ') {
                    
                    $this->db->or_where('pkclient', 'yes'); 
                }
                if($singleCategory == 'priorityc ') {
                    
                    $this->db->or_where('priorityc', 'yes');
                }
            }  

            $this->db->group_end(); 
        }

        if (!empty($Selected_partnerType)) {
            
            $this->db->where_in('company_master.partnerType_id', $Selected_partnerType);
        }
        
        // $this->db->where_in('ic.cstatus', $selectedStatus);

        if ($userTypeid == 2) {

            $this->db->where('user_details.admin_id',$uid);
            
        }elseif ($userTypeid == 4) {
            
            $this->db->where_in('pst_co', $uid);

        }elseif ($userTypeid == 9 || $userTypeid == 13) {
            
            $this->db->where_in('aadmin', $uid);
        }else{
            $this->db->where('user_id', $uid);
        }

        if (!empty($Selected_users)) {
            
            $this->db->where_in('user_details.aadmin', $Selected_users);
        }
       

        $this->db->where('CAST(ic.createDate AS DATE) >=', "'$sdate'", FALSE);
        $this->db->where('CAST(ic.createDate AS DATE) <=', "'$edate'", FALSE);

        $query = $this->db->get();
        // echo $this->db->last_query();die;
        return $query->result();

    }

    public function getStatusWiseTask($uid,$sdate,$edate,$selected_category,$selected_partnerType,$selected_userType,$selected_cluster,$selected_users,$status,$userTypeid){

            $this->db->select('init_call.id');
            $this->db->from('init_call');

            if ($userTypeid == 2) {

                $this->db->where('user_details.admin_id',$uid);
                
            }elseif ($userTypeid == 4) {
                
                $this->db->where_in('pst_co', $uid);
    
            }elseif ($userTypeid == 9 || $userTypeid == 13) {
                
                $this->db->where_in('aadmin', $uid);
            }else{
                $this->db->where('user_id', $uid);
            }

            // $this->db->where('user_details admin_id', $uid);
            $this->db->join('user_details', 'user_details.user_id = init_call.mainbd', 'left');
            $this->db->where('cstatus', $status);
            // if (condition) {
            //     # code...
            // }
            // $this->db->get_compiled_select();

            $subquery = $this->db->get_compiled_select();

            $this->db->select('COUNT(*) as cont,
                COUNT(CASE WHEN actiontype_id=1 THEN 1 END) as a,
                COUNT(CASE WHEN actiontype_id=2 THEN 1 END) as b,
                COUNT(CASE WHEN actiontype_id=3 THEN 1 END) as c,
                COUNT(CASE WHEN actiontype_id=4 THEN 1 END) as d,
                COUNT(CASE WHEN actiontype_id=5 THEN 1 END) as e,
                COUNT(CASE WHEN actiontype_id=6 THEN 1 END) as f,
                COUNT(CASE WHEN actiontype_id=7 THEN 1 END) as g,
                COUNT(CASE WHEN actiontype_id=8 THEN 1 END) as h,
                COUNT(CASE WHEN actiontype_id=9 THEN 1 END) as i,
                COUNT(CASE WHEN actiontype_id=10 THEN 1 END) as j,
                COUNT(CASE WHEN actiontype_id=11 THEN 1 END) as k'
            );

            $this->db->from('tblcallevents');

            // $this->db->where('tblcallevents.cid_id',$status);
            $this->db->where_in('cid_id', $subquery, FALSE);
            $this->db->where('nextCFID !=', '0');
            $this->db->where('CAST(updateddate AS DATE) >=', $sdate);
            $this->db->where('CAST(updateddate AS DATE) <=', $edate);
    
            $query = $this->db->get();

            // echo $this->db->last_query();die;
            return $query->result();
    }
}