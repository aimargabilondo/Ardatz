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

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);

//Add titles
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0, $rowNum, 'ID')
			->setCellValueByColumnAndRow(1, $rowNum, 'IZENA')
			->setCellValueByColumnAndRow(2, $rowNum, 'ABIZENA')
			->setCellValueByColumnAndRow(3, $rowNum, 'EMAIL')
			->setCellValueByColumnAndRow(4, $rowNum, 'TELEFONOA')
			->setCellValueByColumnAndRow(5, $rowNum, 'ORDUAK ASTERO')
			->setCellValueByColumnAndRow(6, $rowNum, 'IKASMAILA')
			->setCellValueByColumnAndRow(7, $rowNum, 'AKTIBO')
			->setCellValueByColumnAndRow(8, $rowNum, 'ALTA EGUNA');

// Set style for header row using alternative method
//echo date('H:i:s') , " Set style for header row using alternative method" , EOL;
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray(
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

// Add some data
$stmt = $DB_con->prepare('SELECT ikasle.*, tarifa.ikasmaila  FROM tbl_ikasle ikasle join tbl_tarifak tarifa on tarifa.id = ikasle.ikasmaila_id order by ikasle.id'); // préparation de la requete 
$stmt->execute(); 	
if($stmt->rowCount() > 0)  
{
	
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)) 
	{
		$rowNum++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $rowNum, $row['id'])
					->setCellValueByColumnAndRow(1, $rowNum, $row['first_name'])
					->setCellValueByColumnAndRow(2, $rowNum, $row['last_name'])
					->setCellValueByColumnAndRow(3, $rowNum, $row['email_id'])
					->setCellValueByColumnAndRow(4, $rowNum, $row['contact_no'])
					->setCellValueByColumnAndRow(5, $rowNum, $row['hours_per_week'])
					->setCellValueByColumnAndRow(6, $rowNum, $row['ikasmaila'])
					->setCellValueByColumnAndRow(7, $rowNum, $row['active'])
					->setCellValueByColumnAndRow(8, $rowNum, $row['creation_date']);
		
	}
	
}

?>