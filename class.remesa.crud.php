<?php

require "sepa/IBAN.php";
use CMPayments\IBAN;

class RemesaCrud
{
	private $db;
	
	
	
	function __construct($DB_con)
	{
		$this->db = $DB_con;
	}

	public function searchIkasleRemesa($sql)
	{
		$result_array = array();
		error_log($sql);
			
		$stmt = $this->db->prepare($sql); 
		 
		$stmt->execute();	
		if($stmt->rowCount() > 0)
		{
			$rows = array();
			while($r = $stmt->fetch()) {
				
				$validationData = $this->validateIkasleData($r['id']);
				$r['validationErrors'] = $validationData['validationErrors'];
				$r['validated'] = $validationData['validated'];
				
				$result_array[] = $r;
			}

			$json_array = json_encode($result_array);
			//error_log($json_array);
			return $json_array;
		}
		else
		{
			return "{}";
		}
	}	
	
	
	public function getBankDetails($codigo)
	{
		$stmt = $this->db->prepare("SELECT bic, denominacion, codigo FROM tbl_tipoBIC WHERE codigo=:codigo");
		$stmt->execute(array(":codigo"=>$codigo));
		$row = $stmt->fetch(PDO::FETCH_ASSOC); 
		return $row;
	}
	
	
	public function getNextFakturaZenbakia($faktura_mota, $faktura_urtea)
	{
		$stmt = $this->db->prepare("CALL dbpdo.getNextFakturaZenbakia(:faktura_mota,:faktura_urtea, @next_faktura_zenbakia);");
		$stmt->execute(array(":faktura_mota"=>$faktura_mota, ":faktura_urtea"=>$faktura_urtea));
		$outputArray = $this->db->query("SELECT @next_faktura_zenbakia")->fetch(PDO::FETCH_ASSOC);

		//error_log($outputArray['@next_faktura_zenbakia']);
		return $outputArray['@next_faktura_zenbakia'];
		
		//$returnedValue = $stmt->fetch(PDO::FETCH_ASSOC); 
		//return $returnedValue['next_faktura_zenbakia'];
	}
	
	
	public function validateIkasleData($idIkaslea)
	{
		$validationErrors = '';
		
		//Ikasle datuak:
		$stmt = $this->db->prepare("SELECT active, first_name, last_name, ncuenta, hours_per_week, ikasmaila_id, ikastetxea_id FROM tbl_ikasle WHERE id=:idIkaslea");
		$stmt->execute(array(":idIkaslea"=>$idIkaslea));
		$ikasleDatuak = $stmt->fetch(PDO::FETCH_ASSOC);
		
		
		$ncuenta = preg_replace('/\s+/', '', $ikasleDatuak['ncuenta']);
		$iban = new IBAN($ncuenta);
		
		// validate the IBAN
		if (!$iban->validate($error)) {
			$validationErrors  = $validationErrors + "IBAN " . $ncuenta . " is not valid, error: " . $error . "\n";
		}else{
			
			$codido = $iban->getInstituteIdentification();
		
		
			//Banku datuak:
			$bankuDatuak = $this->getBankDetails($codido);
			if($bankuDatuak){
				//error_log( "bankuDatuak['bic']: " . $bankuDatuak['bic']);
				//error_log( "bankuDatuak['denominacion']: " . $bankuDatuak['denominacion']);
			}else{
				$validationErrors  = $validationErrors + "No BIC found in  " . $ncuenta . "\n";	
			}
		}
		

		
		$validationData = array();
		$validationData['validationErrors'] = $validationErrors;
		$validationData['validated'] = 'false';
		if($validationErrors == ''){
			$validationData['validated'] = 'true';
		}

		
		return $validationData;
	}
}
?>