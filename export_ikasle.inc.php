<?php
if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Ardatz Akademia")
							 ->setLastModifiedBy("Ardatz Akademia")
							 ->setTitle("")
							 ->setSubject("")
							 ->setDescription("")
							 ->setKeywords("")
							 ->setCategory("");

							 

$rowNum = 1;

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Ikasleen zerrenda');

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(18);

//Add titles
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0, $rowNum, 'ID')
			->setCellValueByColumnAndRow(1, $rowNum, 'IZENA')
			->setCellValueByColumnAndRow(2, $rowNum, 'ABIZENA')
			->setCellValueByColumnAndRow(3, $rowNum, 'GURASO1')
			->setCellValueByColumnAndRow(4, $rowNum, 'TELEFONOA1')
			->setCellValueByColumnAndRow(5, $rowNum, 'GURASO2')
			->setCellValueByColumnAndRow(6, $rowNum, 'TELEFONOA2')
			->setCellValueByColumnAndRow(7, $rowNum, 'ORDUAK ASTERO')
			->setCellValueByColumnAndRow(8, $rowNum, 'IKASTETXEA')
			->setCellValueByColumnAndRow(9, $rowNum, 'IKASMAILA')
			->setCellValueByColumnAndRow(10, $rowNum, 'TUTOREA')
			->setCellValueByColumnAndRow(11, $rowNum, 'AKTIBO');
			

// Set style for header row using alternative method
//echo date('H:i:s') , " Set style for header row using alternative method" , EOL;
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray(
		array(
			'font'    => array(
				'bold'      => true
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			),
			'borders' => array(
				'top'     => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			),
			'fill' => array(
				'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
				'rotation'   => 90,
				'startcolor' => array(
					'argb' => 'FFA0A0A0'
				),
				'endcolor'   => array(
					'argb' => 'FFFFFFFF'
				)
			)
		)
);


/*$ikasle_id = $_GET['ikasle_id'];
$ikastetxe_id = $_GET['ikastetxe_id'];
$maila_id = $_GET['maila_id'];
$egoera = $_GET['egoera'];*/

// Add some data
$sql = "SELECT ikasle.*, tarifa.ikasmaila, etxea.izena ikastetxea, date_format(ikasle.creation_date, '%Y-%m-%d') creation_date_formated 
								FROM tbl_ikasle ikasle 
								join tbl_tarifak tarifa on tarifa.id = ikasle.ikasmaila_id  
								join tbl_ikastetxea etxea on etxea.id = ikasle.ikastetxea_id 
								WHERE 1=1 ";
							
if($ikasle_id != ''){
	$sql = $sql." and ikasle.id = ".$ikasle_id." ";
}
if($ikastetxe_id != ''){
	$sql = $sql." and etxea.id = ".$ikastetxe_id." ";
}
if($maila_id != ''){
	$sql = $sql." and tarifa.id = ".$maila_id." ";
}		
if($egoera != '2'){
	$sql = $sql." and ikasle.active = ".$egoera." ";
}

$sql = $sql." order by ikasle.id ";
$stmt = $DB_con->prepare($sql); // préparation de la requete 
$stmt->execute(); 	
if($stmt->rowCount() > 0)  
{
/*	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0, $rowNum, 'ID')
			->setCellValueByColumnAndRow(1, $rowNum, 'IZENA')
			->setCellValueByColumnAndRow(2, $rowNum, 'ABIZENA')
			->setCellValueByColumnAndRow(3, $rowNum, 'GURASO1')
			->setCellValueByColumnAndRow(4, $rowNum, 'TELEFONOA1')
			->setCellValueByColumnAndRow(5, $rowNum, 'GURASO2')
			->setCellValueByColumnAndRow(6, $rowNum, 'TELEFONOA2')
			->setCellValueByColumnAndRow(7, $rowNum, 'ORDUAK ASTERO')
			->setCellValueByColumnAndRow(8, $rowNum, 'IKASTETXEA')
			->setCellValueByColumnAndRow(9, $rowNum, 'IKASMAILA')
			->setCellValueByColumnAndRow(10, $rowNum, 'TUTOREA')
			->setCellValueByColumnAndRow(11, $rowNum, 'AKTIBO');*/
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)) 
	{
		$rowNum++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $rowNum, $row['id'])
					->setCellValueByColumnAndRow(1, $rowNum, $row['first_name'])
					->setCellValueByColumnAndRow(2, $rowNum, $row['last_name'])
					->setCellValueByColumnAndRow(3, $rowNum, $row['guraso1'])
					->setCellValueByColumnAndRow(4, $rowNum, $row['contact_no1'])
					->setCellValueByColumnAndRow(5, $rowNum, $row['guraso2'])
					->setCellValueByColumnAndRow(6, $rowNum, $row['contact_no2'])
					->setCellValueByColumnAndRow(7, $rowNum, $row['hours_per_week'])
					->setCellValueByColumnAndRow(8, $rowNum, $row['ikastetxea'])
					->setCellValueByColumnAndRow(9, $rowNum, $row['ikasmaila'])
					->setCellValueByColumnAndRow(10, $rowNum, $row['tutorea'])
					->setCellValueByColumnAndRow(11, $rowNum, $row['active']);
		
	}
	
}

?>