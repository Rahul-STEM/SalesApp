<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excel_import extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('excel_import_model');
		$this->load->library('excel');
	}


function importkhasara()
	{
	    $villageid = $_POST['villageid'];
        $khasarano = $_POST['khasarano'];
        $area = $_POST['area'];
        $landtype = $_POST['landtype'];
        $landuse = $_POST['landuse'];
        $owner = $_POST['owner'];
        $remarks = $_POST['remarks'];
        $presentuser = $_POST['presentuser'];
        $sublandtype = $_POST['sublandtype'];
        $presentownername = $_POST['presentownername'];
        $ownerfathername = $_POST['ownerfathername'];
        $owneraddress = $_POST['owneraddress'];
        $saledeednumber = $_POST['saledeednumber'];
        $saledeeddate = $_POST['saledeeddate'];
        $purchasevalue = $_POST['purchasevalue'];
        $paymentmode = $_POST['paymentmode'];
        $paymentdate = $_POST['paymentdate'];
        $stampduty = $_POST['stampduty'];
        $registrationfee = $_POST['registrationfee'];
        $rinpustikanumber = $_POST['rinpustikanumber'];
        $mutationno = $_POST['mutationno'];
        $mutationdate = $_POST['mutationdate'];
        $diversionorderno = $_POST['diversionorderno'];
        $diversiondate = $_POST['diversiondate'];
        $diversionrentyearly = $_POST['diversionrentyearly'];
        $previousowner = $_POST['previousowner'];
        $mortgager = $_POST['mortgager'];
        $mortgagee = $_POST['mortgagee'];
        $clatc = $_POST['clatc'];
        $clongc = $_POST['clongc'];
        $basra = $_POST['basra'];
        
		if(isset($_FILES["excel"]["name"]))
		{
			$path = $_FILES["excel"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=1; $row<=$highestRow; $row++)
				{
					
					$clat = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $clong = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$data[] = array(
                        'clat' => $clat,
                        'clong' => $clong,
					);
				}
			}
			
			$this->excel_import_model->insert_khasra($basra,$clatc,$clongc,$data,$villageid,$khasarano,$area,$landtype,$landuse,$owner,$remarks,$presentuser,$sublandtype,$presentownername,$ownerfathername,$owneraddress,$saledeednumber,$saledeeddate,$purchasevalue,$paymentmode,$paymentdate,$stampduty,$registrationfee,$rinpustikanumber,$mutationno,$mutationdate,$diversionorderno,$diversiondate,$diversionrentyearly,$previousowner,$mortgager,$mortgagee);
			redirect('Menu/AddKhasrano/');
			
		}	
	}


	function import()
	{
	    $phnoid = $_POST['phnoid'];
        $village = $_POST['village'];
		if(isset($_FILES["excel"]["name"]))
		{
			$path = $_FILES["excel"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=1; $row<=$highestRow; $row++)
				{
					
					$clat = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $clong = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$data[] = array(
                        'clat' => $clat,
                        'clong' => $clong,
					);
				}
			}
			
			$this->excel_import_model->insert($data,$phnoid,$village);
			redirect('Menu/AddVillage/');
			
		}	
	}
}

?>

