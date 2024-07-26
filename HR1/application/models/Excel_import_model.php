<?php

class Excel_import_model extends CI_Model
{
	

	function insert($data,$storeby)
	{
	    date_default_timezone_set("Asia/Kolkata");
        $date=date('Y-m-d H:i:s');
	   
	   $l = sizeof($data);
		for($i=0;$i<$l;$i++){
            $cname = $data[$i]['cname'];
            $cemail = $data[$i]['cemail'];
            $cmo = $data[$i]['cmo'];
            $cwno = $data[$i]['cwno'];
            $cqual = $data[$i]['cqual'];
            $city = $data[$i]['city'];
            $state = $data[$i]['state'];
            $position = $data[$i]['position'];
            $p_location = $data[$i]['p_location'];
            $department = $data[$i]['department'];
            $source = $data[$i]['source'];
            $cstatus = $data[$i]['cstatus'];
            $remark = $data[$i]['remark'];
            
            
            
            
		    $this->db->query("INSERT INTO cpd(cname, cemail, cmo, cwno, cqual, cstatus, lstatus, lupdate, storeby, city, state, position, p_location, source, department,last_remark) VALUES ('$cname','$cemail','$cmo','$cwno','$cqual','$cstatus','1','$date','$storeby','$city','$state','$position','$p_location','$source','$department','$remark')");
		    
		    
       
		}
		
	}
}
