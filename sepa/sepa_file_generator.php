<?php 
require_once("vendor/autoload.php"); 


use Digitick\Sepa\TransferFile\Factory\TransferFileFacadeFactory;
use Digitick\Sepa\PaymentInformation;
use Digitick\Sepa\GroupHeader;

//Set the custom header (Spanish banks example) information
$header = new GroupHeader(date('Y-m-d-H-i-s'), 'Mikel Makazaga Eraña y Otros C.B.');
$header->setInitiatingPartyId('DE21WVM1234567890');

$now = new DateTime();
$tomorrow = new DateTime('now + 1 days');

$directDebit = TransferFileFacadeFactory::createDirectDebitWithGroupHeader($header, 'pain.008.001.02');

// create a payment, it's possible to create multiple payments,
// "firstPayment" is the identifier for the transactions
$directDebit->addPaymentInfo('RemesaPayment', array(
    'id'                    => $now->getTimestamp(),
    'dueDate'               => new DateTime('now + 7 days'), // optional. Otherwise default period is used
    'creditorName'          => 'Mikel Makazaga Eraña y Otros C.B.',
    'creditorAccountIBAN'   => 'FI1350001540000056',
//    'creditorAgentBIC'      => 'PSSTFRPPMON',
    'seqType'               => PaymentInformation::S_ONEOFF,
    'creditorId'            => 'DE21WVM1234567890',
    'localInstrumentCode'   => 'CORE' // default. optional.
));
// Add a Single Transaction to the named payment
$directDebit->addTransfer('RemesaPayment', array(
    'amount'                => '130.00',
    'debtorIban'            => 'FI1350001540000056',
//    'debtorBic'             => 'OKOYFIHH',
    'debtorName'            => 'IkasleA',
    'debtorMandate'         =>  'AB12345',
    'debtorMandateSignDate' => $tomorrow->format('d-m-Y'),
    'remittanceInformation' => 'Ardatz akademiako hilerokoa',
    'endToEndId'            => 'Invoice-No 2020-187' // optional, if you want to provide additional structured info
));
// Add a Single Transaction to the named payment
$directDebit->addTransfer('RemesaPayment', array(
    'amount'                => '170.00',
    'debtorIban'            => 'FI1303501540000057',
//    'debtorBic'             => 'OKOYFIHH',
    'debtorName'            => 'IkasleB',
    'debtorMandate'         =>  'AB12345',
    'debtorMandateSignDate' => $tomorrow->format('d-m-Y'),
    'remittanceInformation' => 'Ardatz akademiako hilerokoa',
    'endToEndId'            => 'Invoice-No 2020-188' // optional, if you want to provide additional structured info
));
// Retrieve the resulting XML
print($directDebit->asXML());
?>