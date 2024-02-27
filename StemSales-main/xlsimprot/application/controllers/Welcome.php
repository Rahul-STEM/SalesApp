<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$upload_status =  $this->uploadDoc();
			if($upload_status!=false)
			{
				$inputFileName = 'assets/uploads/imports/'.$upload_status;
				$inputTileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputTileType);
				$spreadsheet = $reader->load($inputFileName);
				$sheet = $spreadsheet->getSheet(0);
				$count_Rows = 0;
				foreach($sheet->getRowIterator() as $row)
				{
					$name = $spreadsheet->getActiveSheet()->getCell('A'.$row->getRowIndex());
					$mobile = $spreadsheet->getActiveSheet()->getCell('B'.$row->getRowIndex());
					$email = $spreadsheet->getActiveSheet()->getCell('C'.$row->getRowIndex());
					$address = $spreadsheet->getActiveSheet()->getCell('D'.$row->getRowIndex());
					$data = array(
						'name'=> $name,
						'email'=> $email,
						'mobile'=> $mobile,
						'address'=> $address,
					);

					$this->db->insert('users',$data);
					$count_Rows++;
				}
				$this->session->set_flashdata('success','Successfulyy Data Imported');
				redirect(base_url());
			}
			else
			{
				$this->session->set_flashdata('error','File is not uploaded');
				redirect(base_url());
			}
		}
		else
		{
			$this->load->view('welcome_message');
		}
		
	}


	function uploadDoc()
	{
		$uploadPath = 'assets/uploads/imports/';
		if(!is_dir($uploadPath))
		{
			mkdir($uploadPath,0777,TRUE); // FOR CREATING DIRECTORY IF ITS NOT EXIST
		}

		$config['upload_path']=$uploadPath;
		$config['allowed_types'] = 'csv|xlsx|xls';
		$config['max_size'] = 1000000;
		$this->load->library('upload',$config);
		$this->upload->initialize($config);
		if($this->upload->do_upload('upload_excel'))
		{
			$fileData = $this->upload->data();
			return $fileData['file_name'];
		}
		else
		{
			return false;
		}
	}

}
