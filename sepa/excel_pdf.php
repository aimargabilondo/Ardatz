<?php 
$newname = "../../excel/".$_POST['par1']."/".$_POST['par2'].".xlsx"; 
if((move_uploaded_file($_FILES['uploadfile']['tmp_name'], $newname))) {
	$pdf_path = "../../pdf/{$_POST['par1']}/{$_POST['par2']}.pdf"; 
	require_once 'Classes/PHPExcel.php'; 
	$rendererName = PHPExcel_Settings::PDF_RENDERER_TCPDF; 
	$rendererLibrary = 'tcPDF.php'; 
	$rendererLibraryPath = 'Classes/PHPExcel/Writer/PDF/'. $rendererLibrary; 
	$inputFileType = PHPExcel_IOFactory::identify($newname); 
	$objReader = PHPExcel_IOFactory::createReader($inputFileType); 
	$objPHPExcel = $objReader->load($newname); 
	$objPHPExcel->setActiveSheetIndex(0); 
	if(!PHPExcel_Settings::setPdfRenderer($rendererName,$rendererLibraryPath)) {
		die('NOTICE: Please set the $rendererName and $rendererLibraryPath values'.'<br>'.'at the top of this script as appropriate for your directory structure'); 
	}
	header('Content-Type: application/pdf'); 
	header('Content-Disposition: attachment;filename="converted.pdf"'); 
	header('Cache-Control: max-age=0'); 
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF'); 
	$objWriter->save('php://output'); 
	exit; 
} else { 
	echo "Error!"; 
} 

?>