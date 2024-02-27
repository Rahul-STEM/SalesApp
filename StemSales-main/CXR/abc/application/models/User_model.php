<?php 
	class User_model extends CI_Model{


		public function getUsers(){
			return $this->db->get('action')->result();;
		}

		public function importUsers($import_data){
			$this->db->insert_batch('action',$import_data);
		}
		
	}


?>
