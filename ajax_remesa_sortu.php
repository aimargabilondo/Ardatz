<?php session_start(); ?>
<?php

include_once "dbconfig.php";
require_once('customlog.php');
require_once(dirname(__FILE__) . "/sepa/vendor/autoload.php"); 
		/** PHPExcel_IOFactory */
require_once(dirname(__FILE__) . '/Classes/PHPExcel/IOFactory.php');
require_once(dirname(__FILE__) . "/sepa/IBAN.php");


use CMPayments\IBAN;


use Digitick\Sepa\TransferFile\Factory\TransferFileFacadeFactory;
use Digitick\Sepa\PaymentInformation;
use Digitick\Sepa\GroupHeader;

if(isset($_GET['ikasle-fakturak'])){
	
	//try {
		
		//	Change these values to select the Rendering library that you wish to use
		//		and its directory location on your server
		//$rendererName = PHPExcel_Settings::PDF_RENDERER_TCPDF; 
		//$rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
		//$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
		//$rendererLibrary = 'tcPDF5.9';
		//$rendererLibrary = 'mpdf-5.4.0';
		//$rendererLibraryPath = dirname(__FILE__).'/' . $rendererLibrary;
		
		/*if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
			die(
				'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
				'<br />' .
				'at the top of this script as appropriate for your directory structure'
			);
		}*/
		

		
	
		$oldValue = ini_get('max_execution_time');
		
		set_time_limit(0);
		
		
		$now = date("Y-m-d H-i-s");
		$log_name = 'Fakturak ' . $now . '.log';

		custom_log($log_name, 'Init fakturak');

		/** Error reporting */
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);

		define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

		date_default_timezone_set('Europe/Madrid');



		// encode $_POST data to json
		$json = json_decode($_POST['json'], true);
		//print_r($json);
		
		$base_row = 20;
		$year = date("Y");
		$month = date('m');
		$day = date('d');
		
		$invoice_date = $year . '-' . $month . '-' . $day;
		
		$months = array('01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');
		$month_str = $months[$month];
		
		foreach ($json as $row)
		{
			custom_log($log_name, 'Load from Excel5 template');
			$objReader = PHPExcel_IOFactory::createReader('Excel5');
			$objPHPExcel = $objReader->load("./Classes/faktura_template.xls");
			
			// Set document properties
			$objPHPExcel->getProperties()->setCreator("Ardatz Akademia")
							 ->setLastModifiedBy("Ardatz Akademia")
							 ->setTitle("Faktura")
							 ->setSubject("Faktura")
							 ->setDescription("Faktura")
							 ->setKeywords("faktura")
							 ->setCategory("faktura");
			
			$ikaslea = $row['izena'];
			$ikasmaila = $row['ikasmaila'];
			$ncuenta = $row['ncuenta'];
			$prezioa = $row['prezioa_hilero_zuzenduta'];
			$guraso1 = $row['guraso1'];
			$guraso2 = $row['guraso2'];
			$helbidea = $row['helbidea'];
			custom_log($log_name, 'Processing ' . $ikaslea);
			
			$objPHPExcel->getActiveSheet()->setCellValue('F4', $invoice_date);
			//$objPHPExcel->getActiveSheet()->mergeCells("B2:D2"); 
			$objPHPExcel->getActiveSheet()->setCellValue('C8', $guraso1);
			$objPHPExcel->getActiveSheet()->setCellValue('C9', $helbidea);
			
			if($row['matrikula'] == 'true' || $row['matrikula'] == '1'){
				
				$objPHPExcel->getActiveSheet()->setCellValue('B'.($base_row+1), '2')
											  ->setCellValue('C'.($base_row+1), "Matrikula")
											  ->setCellValue('F'.($base_row+1), '40');
											  
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$base_row, $ikasmaila . " - Klase partikularrak")
											->setCellValue('F'.$base_row, $prezioa)
											->setCellValue('F'.($base_row+2), '=SUM(F'.$base_row.':F'.($base_row+1).')');
			}else{
				
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$base_row, $ikasmaila . " - Klase partikularrak")
											->setCellValue('F'.$base_row, $prezioa)
											->setCellValue('F'.($base_row+2), '=SUM(F'.$base_row.':F'.$base_row.')');
			}
				
			$fakturaZenbakia = $remesaCrud->getNextFakturaZenbakia('A', $year);	
			$objPHPExcel->getActiveSheet()->setCellValue('F5', $fakturaZenbakia);
										  
								  
										
			//echo date('H:i:s') , " Write to Excel5 format" , EOL;
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			if (!file_exists('/mnt/data/fakturak/' . $year . '/A/' . $month_str . '/')) {
				mkdir('/mnt/data/fakturak/' . $year . '/A/' . $month_str . '/', 0777, true);
			}
			$objWriter->save('/mnt/data/fakturak/' . $year . '/A/' . $month_str . '/' . $ikaslea . '-' . $now . '.xls');
			//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
			//$objWriter->save('/mnt/data/fakturak/' . $year . '/A/' . $month_str . '/' . $ikaslea . '-' . $now . '.pdf');
			custom_log($log_name, 'File written to /mnt/data/fakturak/' . $year . '/A/' . $month_str . '/' . $ikaslea . '-' . $now . '.xls');
			
		}
		
		// Echo memory peak usage
		//echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;
		error_log(date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB");

		// Echo done
		//echo date('H:i:s') , " Done writing file" , EOL;
		//echo 'File has been created in ' , getcwd() , EOL;
		set_time_limit($oldValue);
		
	/*}catch (exception $e) {	
		header('HTTP/1.0 400 Bad error');
		error_log($e->getMessage());
	}*/
			
	

}else if(isset($_GET['ikasle-sepa'])){
	
		$oldValue = ini_get('max_execution_time');
		
		set_time_limit(0);
		
		
		//$now = date("Y-m-d H-i-s");
		$log_name = 'SEPA ' . $now . '.log';

		custom_log($log_name, 'Init SEPA');

		/** Error reporting */
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);

		define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

		date_default_timezone_set('Europe/Madrid');



		// encode $_POST data to json
		$json = json_decode($_POST['json'], true);
		//print_r($json);
		
		
		
		
		$year = date("Y");
		$month = date('m');
		$day = date('d');
		
		$months = array('01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');
		$months_large = array('01' => 'Urtarrila', '02' => 'Otsaila', '03' => 'Martxoa', '04' => 'Apirila', '05' => 'Maiatza', '06' => 'Ekaina', '07' => 'Uztaila', '08' => 'Abuztua', '09' => 'Iraila', '10' => 'Urria', '11' => 'Azaroa', '12' => 'Abendua');
		$month_str = $months[$month];
		$months_large_str = $months_large[$month];
		
		$now = new DateTime();
		$tomorrow = new DateTime('now + 1 days');
		
		//Set the custom header (Spanish banks example) information
		$header = new GroupHeader(date('Y-m-d-H-i-s'), 'Mikel Makazaga Eraña y Otros C.B.');
		$header->setInitiatingPartyId('ES18000E75059782');
		$directDebit = TransferFileFacadeFactory::createDirectDebitWithGroupHeader($header, 'pain.008.001.02');
		
		// create a payment, it's possible to create multiple payments,
		// "firstPayment" is the identifier for the transactions
		$directDebit->addPaymentInfo('RemesaPayment', array(
			'id'                    => $now->getTimestamp(),
			'dueDate'               => new DateTime('now + 7 days'), // optional. Otherwise default period is used
			'creditorName'          => 'Mikel Makazaga Eraña y Otros C.B.',
			'creditorAccountIBAN'   => 'ES18000E75059782',
			'creditorAgentBIC'      => 'CLPEES2MXXX',
			'seqType'               => PaymentInformation::S_ONEOFF,
			'creditorId'            => 'ES18000E75059782',
			'localInstrumentCode'   => 'CORE' // default. optional.
		));

		
		
		foreach ($json as $row)
		{
			//custom_log($log_name, 'Load from Excel5 template');
			$totala = 0;
			$ikaslea = $row['izena'];
			$ikasmaila = $row['ikasmaila'];
			$ncuenta = $row['ncuenta'];
			$prezioa = $row['prezioa_hilero_zuzenduta'];
			$guraso1 = $row['guraso1'];
			$guraso2 = $row['guraso2'];
			$helbidea = $row['helbidea'];
			custom_log($log_name, 'Processing ' . $ikaslea);
			
			if($row['matrikula'] == 'true' || $row['matrikula'] == '1'){
				$totala = 40 + ((float)$prezioa);
			}else{
				$totala = ((float)$prezioa);
			}	

			$ncuenta = preg_replace('/\s+/', '', $ncuenta);
			$iban = new IBAN($ncuenta);
			$bankuDatuak = null;
			// validate the IBAN
			if ($iban->validate($error)) {
				
				$codido = $iban->getInstituteIdentification();
				//Banku datuak:
				$bankuDatuak = $remesaCrud->getBankDetails($codido);
				
				//$bankuDatuak['denominacion']
			}

			// Add a Transaction to the named payment
			$directDebit->addTransfer('RemesaPayment', array(
				'amount'                => number_format($totala,2,'.',''),
				'debtorIban'            => $ncuenta,
				'debtorBic'             => $bankuDatuak['bic'],
				'debtorName'            => $guraso1,
				'debtorMandate'         =>  'AB12345',
				'debtorMandateSignDate' => $tomorrow->format('d-m-Y'),
				'remittanceInformation' => 'Ardatz akademiako hilerokoa',
				'endToEndId'            => $months_large_str // optional, if you want to provide additional structured info
			));		

		
								  
			/*if (!file_exists('/mnt/data/fakturak/' . $year . '/A/' . $month . '/')) {
				mkdir('/mnt/data/fakturak/' . $year . '/A/' . $month . '/', 0777, true);
			}*/

			//custom_log($log_name, 'File written to /mnt/data/fakturak/' . $year . '/A/' . $month . '/' . $ikaslea . '-' . $now . '.xls');
			
		}
		
		
		// Echo memory peak usage
		//echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;
		error_log(date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB");

		// Echo done
		//echo date('H:i:s') , " Done writing file" , EOL;
		//echo 'File has been created in ' , getcwd() , EOL;
		set_time_limit($oldValue);
		
	/*}catch (exception $e) {	
		header('HTTP/1.0 400 Bad error');
		error_log($e->getMessage());
	}*/
						// Retrieve the resulting XML
			

		//ob_start();
		//echo $directDebit->asXML();
		//$data = ob_get_contents();
		//ob_end_clean();

		$opResult = array(
				'status' => 1,
				'data'=>"data:application/xml;base64,".base64_encode($directDebit->asXML())
			 );

		die(json_encode($opResult));	
	

}