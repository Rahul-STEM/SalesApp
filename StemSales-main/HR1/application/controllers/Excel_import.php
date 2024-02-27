<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excel_import extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('excel_import_model');
		$this->load->library('excel');
	}

	

	function import()
	{
	    $storeby= $this->input->post('storeby');
		if(isset($_FILES["excel"]["name"]))
		{
			$path = $_FILES["excel"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++)
				{
					
					$cname = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $cemail = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$cmo = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$cwno = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$cqual = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$city = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$state = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
					$position = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
					$p_location = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
					$department = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
					$source = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
					$cstatus = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
					$remark = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
					$data[] = array(
                        'cname' => $cname,
                        'cemail' => $cemail,
                        'cmo' => $cmo,
                        'cwno' => $cwno,
                        'cqual' => $cqual,
                        'city' => $city,
                        'state' => $state,
                        'position' => $position,
                        'p_location' => $p_location,
                        'department' => $department,
                        'source' => $source,
                        'cstatus' => $cstatus,
                        'remark' => $remark,
					);
				}
			}
			
			$this->excel_import_model->insert($data,$storeby);
			redirect('Menu/AddCandidate/');
			
		}	
	}
}

?>

