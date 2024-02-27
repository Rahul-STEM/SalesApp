<?php 

date_default_timezone_set("Asia/Calcutta");
defined('BASEPATH') OR exit('No direct script access allowed'); 


class Menu extends CI_Controller {
    
    
    public function main(){
        $msg = '';
        $this->load->model('Menu_model');
        $this->load->view('index');
    }
    
    public function AddLocation(){
        $this->load->model('Menu_model');
        $this->load->view('/addlocation');  
    }
    
    public function AddState(){
        $this->load->model('Menu_model');
        $this->load->view('/AddState');  
    }
    
    
    public function stateadd(){
        $state = $_POST['state'];
        $this->load->model('Menu_model'); 
        $id = $this->Menu_model->state_add($state);
        redirect('Menu/AddState'); 
        
    }
    
    
    public function AddDistrict(){
        $this->load->model('Menu_model');
        $state = $this->Menu_model->get_gstate();
        $this->load->view('/AddDistrict',['state'=>$state]);  
    }
    
    
    public function districtadd(){
        $stateid = $_POST['stateid'];
        $district = $_POST['district'];
        $this->load->model('Menu_model'); 
        $id = $this->Menu_model->district_add($stateid,$district);
        redirect('Menu/AddDistrict'); 
        
    }
    
    
    
    public function AddTehsil(){
        $this->load->model('Menu_model');
        $state = $this->Menu_model->get_gstate();
        $this->load->view('/AddTehsil',['state'=>$state]);  
    }
    
    public function tehsiladd(){
        $districtid = $_POST['districtid'];
        $tehsil = $_POST['tehsil'];
        $this->load->model('Menu_model'); 
        $id = $this->Menu_model->tehsil_add($districtid,$tehsil);
        redirect('Menu/AddTehsil'); 
        
    }
    
    public function AddBlock(){
        $this->load->model('Menu_model');
        $state = $this->Menu_model->get_gstate();
        $this->load->view('/AddBlock',['state'=>$state]);  
    }
    
    public function AddPHNO(){
        $this->load->model('Menu_model');
        $state = $this->Menu_model->get_gstate();
        $this->load->view('/AddPHNO',['state'=>$state]);  
    }
    
    
    public function AddRI(){
        $this->load->model('Menu_model');
        $state = $this->Menu_model->get_gstate();
        $this->load->view('/AddRI',['state'=>$state]);  
    }
    
    
    public function blockadd(){
        $tehsilid = $_POST['tehsilid'];
        $block = $_POST['block'];
        $this->load->model('Menu_model'); 
        $id = $this->Menu_model->block_add($tehsilid,$block);
        redirect('Menu/AddBlock');
    }
    
    public function riadd(){
        $blockid = $_POST['blockid'];
        $ri = $_POST['ri'];
        $this->load->model('Menu_model'); 
        $id = $this->Menu_model->ri_add($blockid,$ri);
        redirect('Menu/AddRI');  
    }
    
    public function phnoadd(){
        $riid = $_POST['riid'];
        $phno = $_POST['phno'];
        $this->load->model('Menu_model'); 
        $id = $this->Menu_model->phno_add($riid,$phno);
        redirect('Menu/AddRI');  
    }
    
    
    public function AddVillage(){
        $this->load->model('Menu_model');
        $state = $this->Menu_model->get_gstate();
        $this->load->view('/AddVillage',['state'=>$state]);  
    }
    
    
    public function villageadd(){
        $riid = $_POST['riid'];
        $village = $_POST['village'];
        $this->load->model('Menu_model'); 
        $id = $this->Menu_model->village_add($riid,$village);
        redirect('Menu/AddVillage'); 
        
    }
    
    
    public function AddKhasrano(){
        $this->load->model('Menu_model');
        $state = $this->Menu_model->get_gstate();
        $this->load->view('/AddKhasrano',['state'=>$state]);  
    }
    
    
    
    
    public function statetodistrict(){
        $stateid= $this->input->post('stateid');
        $this->load->model('Menu_model');
        $remark=$this->Menu_model->get_statetodistrict($stateid);
        echo  $data = '<option value="">Select District</option>';
        foreach($remark as $d){
             echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }
    }
    
    
    public function districttotehsil(){
        $districtid= $this->input->post('districtid');
        $this->load->model('Menu_model');
        $remark=$this->Menu_model->get_districttotehsil($districtid);
        echo  $data = '<option value="">Select Tehsil</option>';
        foreach($remark as $d){
             echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }
    }
    
    
    public function tehsiltori(){
        $tehsilid= $this->input->post('tehsilid');
        $this->load->model('Menu_model');
        $remark=$this->Menu_model->get_tehsiltori($tehsilid);
        echo  $data = '<option value="">Select RI</option>';
        foreach($remark as $d){
             echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }
    }
    
    public function landtypetosc(){
        $category= $this->input->post('category');
        $this->load->model('Menu_model');
        $remark=$this->Menu_model->get_landtypetosc($category);
        echo  $data = '<option value="">Select Sub Category</option>';
        foreach($remark as $d){
             echo  $data = '<option>'.$d->name.'</option>';
        }
    }
    
    
    
    public function tehsiltoblock(){
        $tehsilid= $this->input->post('tehsilid');
        $this->load->model('Menu_model');
        $remark=$this->Menu_model->get_tehsiltoblock($tehsilid);
        echo  $data = '<option value="">Select Block</option>';
        foreach($remark as $d){
             echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }
    }
    
    
    public function blocktori(){
        $blockid= $this->input->post('blockid');
        $this->load->model('Menu_model');
        $remark=$this->Menu_model->get_blocktori($blockid);
        echo  $data = '<option value="">Select RI</option>';
        foreach($remark as $d){
             echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }
    }
    
    public function ritophno(){
        $riid= $this->input->post('riid');
        $this->load->model('Menu_model');
        $remark=$this->Menu_model->get_ritophno($riid);
        echo  $data = '<option value="">Select Patwari Halka No</option>';
        foreach($remark as $d){
             echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }
    }
    
    
    public function phnotovillage(){
        $phnoid= $this->input->post('phnoid');
        $this->load->model('Menu_model');
        $remark=$this->Menu_model->get_phnotovillage($phnoid);
        echo  $data = '<option value="">Select village</option>';
        foreach($remark as $d){
             echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }
    }
    
    
    
    public function villagetocategory(){
        $villageid= $this->input->post('villageid');
        $this->load->model('Menu_model');
        $remark=$this->Menu_model->get_villagetocategory($villageid);
        echo  $data = '<option value="">Select Category</option>';
        foreach($remark as $d){
             echo  $data = '<option>'.$d->landtype.'</option>';
        }
    }
    
    
    public function categorytosc(){
        $villageid= $this->input->post('villageid');
        $category= $this->input->post('category');
        $this->load->model('Menu_model');
        $remark=$this->Menu_model->get_categorytosc($villageid,$category);
        echo  $data = '<option value="">Select Sub Category</option>';
        foreach($remark as $d){
             echo  $data = '<option>'.$d->sublandtype.'</option>';
        }
    }
    
    
    
    public function villagetokhasrano(){
        $villageid= $this->input->post('villageid');
        $sc= $this->input->post('sc');
        $this->load->model('Menu_model');
        $remark=$this->Menu_model->get_villagetokhasrano($villageid,$sc);
        echo  $data = '<option value="">Select Khasrano</option>';
        foreach($remark as $d){
             echo  $data = '<option>'.$d->name.'</option>';
        }
    }
    
    
    public function khasranotomapinfo(){
        $khasranoid= $this->input->post('khasranoid');
        $this->load->model('Menu_model');
        $remark=$this->Menu_model->get_khasranotomapinfo($khasranoid);
        echo  '<p>asasdasd<p>';
    }
    
    
    
    
    
    
    
    
    function fetch()
	{
		
		$output ='<p>skjdhgks</p>';
		echo $output;
	}
    
    
    public function login(){
        date_default_timezone_set("Asia/Calcutta");
        $tdate = date('Y-m-d');
        $user=$this->input->post('user');
        $password=$this->input->post('password');
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->user_login($user,$password);
        if(!empty($dt))
        {
            $sessArray["id"] = $dt[0]->id;
            $sessArray["fullname"] = $dt[0]->fullname;
            $sessArray["user_name"] = $dt[0]->user_name;
            $sessArray["email"] = $dt[0]->email;
            $sessArray["mobileno"] = $dt[0]->mobileno;
            $sessArray["wno"] = $dt[0]->wno;
            $sessArray["type"] = $dt[0]->type;
            $this->session->set_userdata('user',$sessArray);  
        }else{redirect('Menu/main');}
        if(!empty($dt))
        {
            $this->load->model('Menu_model');
            $user = $this->session->userdata('user');
            $data['user'] = $user;
            $uid = $user['id'];
            $this->Menu_model->update_tpbncdbyuid($uid,$tdate);
            redirect('Menu/Dashboard');}
        else{redirect('Menu/main');}
    }
    
    
    public function Dashboard(){
        date_default_timezone_set("Asia/Calcutta");
        if(isset($_POST['tdate'])){
        $tdate = $_POST['tdate'];
        }
        else{
            $tdate = date('Y-m-d');
        }
        $this->load->model('Menu_model');
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['id'];
        $utype = $user['type'];
        if(!empty($user)){
                $this->load->view($utype.'/index',['user'=>$user,'uid'=>$uid]);
            
        }else{
            redirect('Menu/main');
        }  
    }
    
    
    public function AddCandidate(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['id'];
        $utype = $user['type'];
        $this->load->model('Menu_model');
        $position = $this->Menu_model->get_position();
        if(!empty($user)){
            $this->load->view($utype.'/AddCandidate.php',['user'=>$user,'uid'=>$uid,'position'=>$position]);
        }else{
            redirect('Menu/main');
        }  
    }
    
    
    
    public function NewCandidate(){
        $storeby= $this->input->post('storeby');
        $cname= $this->input->post('cname');
        $cemail= $this->input->post('cemail');
        $cmo= $this->input->post('cmo');
        $cwno= $this->input->post('cwno');
        $cresume= $this->input->post('cresume');
        $cqual= $this->input->post('cqual');
        $cifield= $this->input->post('cifield');
        $address= $this->input->post('address');
        $city= $this->input->post('city');
        $state= $this->input->post('state');
        $position_id= $this->input->post('position_id');
        $this->load->model('Menu_model');
        $id=$this->Menu_model->New_Candidate($storeby,$cname,$cemail,$cmo,$cwno,$cresume,$cqual,$cifield,$address,$city,$state,$position_id);
        redirect('Menu/Dashboard');
        
    }
    
     
    public function CandidateList($s){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['id'];
        $utype = $user['type'];
        $this->load->model('Menu_model');
        $mdata = $this->Menu_model->get_Candidate($s,$uid);
        if(!empty($user)){
            $this->load->view($utype.'/CandidateList.php',['user'=>$user,'uid'=>$uid,'mdata'=>$mdata]);
        }else{
            redirect('Menu/main');
        }  
    }
    
    
    public function CreateTask(){
      $uid = $user['id'];
          $user = $this->session->userdata('user');
        $data['user'] = $user;
        $utype = $user['type'];
        $this->load->model('Menu_model');
        $mdata = $this->Menu_model->get_Candidate(0,$uid);
        $action = $this->Menu_model->get_action();
        $position = $this->Menu_model->get_position();
        if(!empty($user)){
            $this->load->view($utype.'/CreateTask.php',['user'=>$user,'uid'=>$uid,'mdata'=>$mdata,'action'=>$action,'position'=>$position]);
        }else{
            redirect('Menu/main');
        }  
    }
    
    public function cpdbypid(){
        $pid= $this->input->post('pid');
        $uid= $this->input->post('uid');
        $data='<option>Select Candidate Name<option>';
        $this->load->model('Menu_model');
        $cpdbypid=$this->Menu_model->get_Candidatebypid($pid,$uid);
        foreach($cpdbypid as $cpdp){
            $data = $data.'<option value='.$cpdp->id.'>'.$cpdp->cname.'('.$cpdp->city.')'.'<option>';
        }
        echo $data;
    }
    
    
    
    public function taskcreate(){
        $uid= $this->input->post('uid');
        $cpdid= $this->input->post('cpdid');
        $action_id= $this->input->post('action_id');
        $this->load->model('Menu_model');
        $this->Menu_model->task_create($uid,$cpdid,$action_id);
        redirect('Menu/CreateTask'); 
    }
    
    
    
    public function cctd(){
        $tid= $this->input->post('tid');
        $this->load->model('Menu_model'); 
        $result=$this->Menu_model->get_cctd($tid);
        echo json_encode($result);
    }
    
    
    public function CandidateDetails($cid){
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
            $this->load->view($dep_name.'/CandidateDetails.php',['pccd'=>$pccd,'ciid'=>$ciid,'tid'=>$tid,'uid'=>$uid,'user'=>$user,'cd'=>$cd,'ccd'=>$ccd,'init'=>$init,'tblc'=>$tblc,'status'=>$status,'tbllast'=>$tbllast,'status'=>$status,'action'=>$action,'tbllast'=>$tbllast,'cstatus'=>$cstatus,'sid'=>$sid,'mainbd'=>$mainbd,'apst'=>$apst]);
        }else{
            redirect('Menu/main');
        }  
    }
    
    
    
    public function submittask(){
        $tid = $_POST['tid'];
        $uid = $_POST['uid'];
        $actontaken = $_POST['actontaken'];
        $purpose = $_POST['purpose'];
        $noremark = $_POST['noremark'];
        $pyremark_msg = $_POST['pyremark_msg'];
        $pnoremark_msg = $_POST['pnoremark_msg'];
        $ystatus = $_POST['ystatus'];
        $this->load->model('Menu_model'); 
        $id = $this->Menu_model->submit_task($tid,$uid,$actontaken,$purpose,$noremark,$pyremark_msg,$pnoremark_msg,$ystatus);
        redirect('Menu/Dashboard'); 
        
    }
    
    
    
    public function AddPosition(){
        $uid = $user['id'];
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $utype = $user['type'];
        $this->load->model('Menu_model');
        $mdata = $this->Menu_model->get_Candidate(0,$uid);
        $action = $this->Menu_model->get_action();
        $position = $this->Menu_model->get_position();
        if(!empty($user)){
            $this->load->view($utype.'/AddPosition',['user'=>$user,'uid'=>$uid,'mdata'=>$mdata,'action'=>$action,'position'=>$position]);
        }else{
            redirect('Menu/main');
        }  
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
        $sname= $this->input->post('sname');
        $saddress= $this->input->post('saddress');
        $scity= $this->input->post('scity');
        $sstate= $this->input->post('sstate');
        $slanguage = $this->input->post('slanguage');
        $contact_name= $this->input->post('contact_name');
        $contact_no= $this->input->post('contact_no');
        $remark= $this->input->post('remark');
        $fttptype= $this->input->post('fttptype');
        
        $this->load->model('Menu_model');
        if(isset($_FILES['filname']['name'])) {
           $filname = $_FILES['filname']['name'];
           $count = sizeof($filname);
        }else{$count=0;$filname=0;}
        
        $id=$this->Menu_model->add_bdHandover($bdid, $client_name, $mediator, $noofschool, $location, $city, $state, $spd_identify_by, $infrastructure, $filname,$count, $contact_person, $cp_mno, $acontact_person, $acp_mno, $language, $expected_installation_date, $project_tenure,$project_type, $comments,$sname, $saddress, $scity, $sstate, $contact_name, $contact_no,$slanguage,$remark,$fttptype);
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
    
    public function getctot(){
        $ctype= $this->input->post('ctype');
        $this->load->model('Menu_model');
        if($ctype=='On Board Client'){
           echo  $data = '<option>Select Request Type</option>
           <option value='.Report.'>Client Report</option>
            <option value='.OnBoardVisit.'>On Board Client School Visit</option>
            <option value='.Inauguration.'>Inauguration</option>
            <option value='.SchoolMaintenance.'>School Maintenance</option>';
        }else{
            echo  $data = '<option>Select Request Type</option>
            <option value='.SchoolIdentification.'>School Identification</option>
            <option value='.NVisit.'>New Client School Visit</option>
            <option value='.Demo.'>Online/Offline Demo</option>';
        }
        return $data;
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
        echo  $data = '<option>Select Status</option>';
        if($cstatus==6){
        foreach($result as $d){if($d->id==6 || $d->id==9){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        elseif($cstatus==9){
        foreach($result as $d){if($d->id==9){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        else{
         foreach($result as $d){if($d->id!=1 && $d->id!=2 && $d->id!=3 && $d->id!=8 && $d->id!=7){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        return $data;
    }
    
    
    public function getstatusbd(){
        $cstatus= $this->input->post('cstatus');
        $this->load->model('Menu_model'); 
        $result=$this->Menu_model->get_status();
        echo  $data = '<option>Select Status</option>';
        if($cstatus==6){
        foreach($result as $d){if($d->id==6){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        elseif($cstatus==9){
        foreach($result as $d){if($d->id==9){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        elseif($cstatus==12){
        foreach($result as $d){if($d->id==12){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        elseif($cstatus==13){
        foreach($result as $d){if($d->id==13){
           echo  $data = '<option value='.$d->id.'>'.$d->name.'</option>';
        }}}
        else{
         foreach($result as $d){if($d->id==1 || $d->id==8 || $d->id==2 || $d->id==3){
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
        $filname = $_FILES['filname']['name'];
        $uploadPath = 'uploads/day/';
        $this->load->model('Menu_model');
        $flink = $this->Menu_model->uploadfile($filname, $uploadPath);
        
        $this->Menu_model->submit_day($wffo,$flink,$user_id,$lat,$lng,$do);
        redirect('Menu/Dashboard');
    }
    
    
    public function dateplan(){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $taskid = $_POST['taskid'];
        $date = $_POST['date'];
        $this->load->model('Menu_model');
        $this->Menu_model->plantask($taskid,$date,$uid);
        redirect('Menu/Dashboard');
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
    
    
    public function DailyReport(){
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
    
    public function BDDetail($aid){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_userbyaid($aid);
        $this->load->view($dep_name.'/BDDetail',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
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
        $mdata = $this->Menu_model->delete_r();
        $this->load->view($dep_name.'/DeleteCMP',['user'=>$user,'mdata'=>$mdata,'uid'=>$uid]);
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
        $this->load->model('Menu_model');
        $mdata = $this->Menu_model->hand_Apr($aprid);
    }
    
    public function handDelete($aprid){
        $this->load->model('Menu_model');
        $mdata = $this->Menu_model->hand_Delete($aprid);
    }
    
    
    public function REQAPR(){
        $id = $_POST['id'];
        $this->load->model('Menu_model');
        $mdata = $this->Menu_model->REQ_APR($id);
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
    
    
    public function BDTeamWork($date){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDTeamWork',['uid'=>$uid,'user'=>$user,'date'=>$date]);
        }else{
            redirect('Menu/main');
        }  
    }
    
    
    public function PSTTeamWork($date){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/PSTTeamWork',['uid'=>$uid,'user'=>$user,'date'=>$date]);
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
    
    
    
    public function BDStatusTask($date){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDStatusTask',['uid'=>$uid,'user'=>$user,'date'=>$date]);
        }else{
            redirect('Menu/main');
        }  
    }
    
    
    public function BDSConversion($date){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/BDSConversion',['uid'=>$uid,'user'=>$user,'date'=>$date]);
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
        
        $filname = $_FILES['cphoto']['name'];
        $uploadPath = 'uploads/day/';
        $this->load->model('Menu_model');
        $flink = $this->Menu_model->cphotofile($filname, $uploadPath);
        
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
    
    
    public function TBMD($code,$uid){
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
        $mdata = $this->Menu_model->get_tbmd($code,$uid,$sd,$ed);
        if(!empty($user)){
            $this->load->view($dep_name.'/TBMD',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
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
        $sd=$sdate;
        $ed=$edate;
        $sdate = new DateTime($sdate);
        $edate = new DateTime($edate);
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        $mdata = $this->Menu_model->get_tbmd(5,$bdname,$sd,$ed);
        if(!empty($user)){
            $this->load->view($dep_name.'/TBMDF',['uid'=>$uid,'user'=>$user,'mdata'=>$mdata,'sdate'=>$sdate,'edate'=>$edate,'sd'=>$sd,'ed'=>$ed]);
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
    
    
    
    public function ATaskDetail($code,$bdid,$atid,$tdate,$ab){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/ATaskDetail',['uid'=>$uid,'user'=>$user,'atid'=>$atid,'tdate'=>$tdate,'code'=>$code,'ab'=>$ab,'bdid'=>$bdid]);
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
        $mdata=$this->Menu_model->get_userbyaid($uid);
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
              $this->zip->read_file($fpath);
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
    
    
    public function pstcompanies($code){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if($uid=='100103'){$uid=45;}
        if($code==0){
            $mdata=$this->Menu_model->get_bdtcom($uid);
        }else{
            $mdata=$this->Menu_model->get_bdcombystatus($uid,$code);
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
        $cid=$_POST['cmpidaa'];
        $kcdate=$_POST['kcdate'];
        $kcremark=$_POST['kcremark'];
        $this->load->model('Menu_model');
        $this->Menu_model->set_kcomp($cid,$kcdate,$kcremark);
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
    
    
    public function rremark(){
        $pstuid=$_POST['pstuid'];
        $ntaction=$_POST['ntaction'];
        $ntppose=$_POST['ntppose'];
        $ntdate=$_POST['ntdate'];
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
    
    
    public function editcmp(){
        $cid=$_POST['cid'];
        $state=$_POST['state'];
        $city=$_POST['city'];
        $address=$_POST['address'];
        $website=$_POST['website'];
        
        $codeid=$_POST['ecodeid'];
        $bdid=$_POST['ebdid'];
        
        
        
        
        $this->load->model('Menu_model');
        $this->Menu_model->edit_cmp($cid,$state,$city,$address,$website);
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
    
    
    public function pstassignc($code){
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
            $this->load->view($dep_name.'/pstassignc',['user'=>$user,'mdata'=>$mdata,'code'=>$code,'uid'=>$uid]);
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
        $this->load->model('Menu_model');
        $id=$this->Menu_model->submit_company($uid,$compname, $website, $country, $city, $state, $draft, $address, $ctype, $budget, $compconname, $emailid, $phoneno, $draftop, $designation, $top_spender,$upsell_client,$focus_funnel);
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
        $user_id= $this->input->post('user_id');
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
    
    
    
    
    public function adminpopup(){
        $ur_id= $this->input->post('ur_id');
        $this->load->model('Menu_model'); 
        echo $result=$this->Menu_model->get_adminpopup($ur_id);
    }
    
    public function bdpopup(){
        $ur_id= $this->input->post('ur_id');
        $this->load->model('Menu_model'); 
        echo $result=$this->Menu_model->get_bdpopup($ur_id);
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
        $mdata = $this->Menu_model->get_userbyaid($uid);
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
    
    public function Conversion($bdid,$tdate,$code,$ab){
        $user = $this->session->userdata('user');
        $data['user'] = $user;
        $uid = $user['user_id'];
        $uyid =  $user['type_id'];
        $this->load->model('Menu_model');
        $dt=$this->Menu_model->get_utype($uyid);
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/Conversion',['uid'=>$uid,'user'=>$user,'code'=>$code,'tdate'=>$tdate,'ab'=>$ab,'bdid'=>$bdid]);
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
        $md = $mdata[0];
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/handover',['cid'=>$cid,'uid'=>$uid,'user'=>$user,'md'=>$md]);
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
        $md = $mdata[0];
        $mdc = $mdc[0];
        $dep_name = $dt[0]->name;
        if(!empty($user)){
            $this->load->view($dep_name.'/handEdit',['cid'=>$cid,'uid'=>$uid,'user'=>$user,'md'=>$md,'mdc'=>$mdc]);
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
           echo  $data = '<p> Company ID : '.$cid.'</p>
                          <p> Priority : '.$priority.'</p>
                         <p> BD Name : '.$bdname.'</p>
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
        $this->load->view($dep_name.'/createrequest', ['uid'=>$uid,'dep'=>$dt, 'data'=>$data,  'user'=>$user,'client'=>$client,'uid'=>$uid,'fannal'=>$fannal]);
    }
    
    
    
    public function bdrequest(){
        $cname=0;$pcode=0;
        $uid = $_POST['uid'];
        $ctype = $_POST['ctype'];
        $targetd = $_POST['targetd'];
        $request_type = $_POST['request_type'];
        $remark = $_POST['remark'];
        $tyschool = $_POST['tyschool'];
        $noschool = $_POST['noschool'];
        $location = $_POST['location'];
        if(isset($_POST['compname'])){$compname = $_POST['compname'];}else{$compname=0;}
        if(isset($_POST['cnamen'])){$compname = $_POST['cnamen'];}else{$compname=0;}
        if(isset($_POST['cnamena'])){$compname = $_POST['cnamena'];}else{$compname=0;}
        
        if(isset($_POST['pcode'])){
            $pcode = $_POST['pcode'];
        }
        $cid = $_POST['cid'];
            
            
        $this->load->model('Menu_model');
        $id = $this->Menu_model->submit_bdrequest($uid,$targetd,$request_type,$remark,$cid,$tyschool,$noschool,$location,$compname);
        redirect('Menu/Dashboard');
    }

}