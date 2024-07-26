<?php

class Excel_import_model extends CI_Model
{
	

	function insert($data,$phnoid,$village)
	{
	    date_default_timezone_set("Asia/Kolkata");
        $date=date('Y-m-d H:i:s');
        
        $query=$this->db->query("INSERT INTO village(phnoid, name) VALUES ('$phnoid','$village')");
        $vid = $this->db->insert_id();
        
	   
	   $l = sizeof($data);
		for($i=0;$i<$l;$i++){
            $clat = $data[$i]['clat'];
            $clong = $data[$i]['clong'];
            if($clat!=''){
            $query=$this->db->query("INSERT INTO villagegc(clat, clong,villageid) VALUES ('$clat','$clong','$vid')");
            }
       
		}
		
	}
	
	function insert_khasra($basra,$clatc,$clongc,$data,$villageid,$khasarano,$area,$landtype,$landuse,$owner,$remarks,$presentuser,$sublandtype,$presentownername,$ownerfathername,$owneraddress,$saledeednumber,$saledeeddate,$purchasevalue,$paymentmode,$paymentdate,$stampduty,$registrationfee,$rinpustikanumber,$mutationno,$mutationdate,$diversionorderno,$diversiondate,$diversionrentyearly,$previousowner,$mortgager,$mortgagee)
	{
	    
	    date_default_timezone_set("Asia/Kolkata");
        $date=date('Y-m-d H:i:s');
        
        $query=$this->db->query("INSERT INTO khasrano(vid, name, area, landtype, landuse, owner, remarks, presentuser, sublandtype, presentownername, ownerfathername, owneraddress, saledeednumber, saledeeddate, purchasevalue, paymentmode, paymentdate, stampduty, registrationfee, rinpustikanumber, mutationno, mutationdate, diversionorderno, diversiondate, diversionrentyearly, previousowner, mortgager, mortgagee,clat,clong,barsrano) VALUES ('$villageid','$khasarano','$area','$landtype','$landuse','$owner','$remarks','$presentuser','$sublandtype','$presentownername','$ownerfathername','$owneraddress','$saledeednumber','$saledeeddate','$purchasevalue','$paymentmode','$paymentdate','$stampduty','$registrationfee','$rinpustikanumber','$mutationno','$mutationdate','$diversionorderno','$diversiondate','$diversionrentyearly','$previousowner','$mortgager','$mortgagee','$clatc','$clongc','$basra')");
        
        $l = sizeof($data);
		for($i=0;$i<$l;$i++){
            $clat = $data[$i]['clat'];
            $clong = $data[$i]['clong'];
            if($clat!=''){
            $query=$this->db->query("INSERT INTO khasranogc(glat, glong,khasranoid,vid) VALUES ('$clat','$clong','$khasarano','$villageid')");
            }
		}
	    
	    
	}
	
	
	
	
}
