<?php

/*
*|======================================================================|
*|	PayTM Payment Gateway Integration Kit (Stack Version : 1.0.0.0)		|
*|	@Author : Chandan Sharma 											|
*|	@Email: <devchandansh@gmail.com>									|
*|	@Website: <www.chandansharma.co.in>									|
*|======================================================================|
*/


/*
- Use PAYTM_ENVIRONMENT as 'PROD' if you wanted to do transaction in production environment else 'TEST' for doing transaction in testing environment.
- Change the value of PAYTM_MERCHANT_KEY constant with details received from Paytm.
- Change the value of PAYTM_MERCHANT_MID constant with details received from Paytm.
- Change the value of PAYTM_MERCHANT_WEBSITE constant with details received from Paytm.
- Above details will be different for testing and production environment.
*/

$PAYTM_MERCHANT_KEY = "ANxmST25543172102472";
$PAYTM_MERCHANT_MID = "A8EImu#N1CDVL&Z5";
$PAYTM_CHANNEL_ID = "WEB";
$PAYTM_MERCHANT_WEBSITE = "DEFAULT";
$PAYTM_INDUSTRY_TYPE_ID = "Retail";
$PAYTM_CALLBACK_URL 	= "http://localhost/hotal-booking-system/pay_response.php";
define('PAYTM_MERCHANT_KEY', $PAYTM_MERCHANT_KEY); 
define('PAYTM_MERCHANT_MID', $PAYTM_MERCHANT_MID);

define("PAYTM_MERCHANT_WEBSITE", $PAYTM_MERCHANT_WEBSITE);
define("PAYTM_CHANNEL_ID", $PAYTM_CHANNEL_ID);
define("PAYTM_INDUSTRY_TYPE_ID", $PAYTM_INDUSTRY_TYPE_ID);
define('PAYTM_ENVIRONMENT', 'TEST'); // PROD
define("PAYTM_CALLBACK_URL", $PAYTM_CALLBACK_URL);



// new \\


$PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
$PAYTM_TXN_URL='https://securegw-stage.paytm.in/theia/processTransaction';
if (PAYTM_ENVIRONMENT == 'TEST') {
	$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
	$PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';
}

define('PAYTM_REFUND_URL', '');
define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_TXN_URL', $PAYTM_TXN_URL);

// define('PAYTM_ENVIRONMENT', 'TEST'); // PROD
// define('PAYTM_MERCHANT_KEY', 'UfnfTQdcfwHZiSma'); //Change this constant's value with Merchant key received from Paytm.
// define('PAYTM_MERCHANT_MID', 'UvaLxt93516792108659'); //Change this constant's value with MID (Merchant ID) received from Paytm.
// define('PAYTM_MERCHANT_WEBSITE', 'DEFAULT'); //Change this constant's value with Website name received from Paytm.

// $PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
// $PAYTM_TXN_URL='https://securegw-stage.paytm.in/theia/processTransaction';
// if (PAYTM_ENVIRONMENT == 'TEST') {
// 	$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
// 	$PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';
// }

// define('PAYTM_REFUND_URL', '');
// define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
// define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
// define('PAYTM_TXN_URL', $PAYTM_TXN_URL);
?>


