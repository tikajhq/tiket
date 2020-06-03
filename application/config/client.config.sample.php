<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');
include_once __DIR__."/constants.permissions.php";

//Root Url of ur site
define('BASE_URL', 'http://localhost:8080/');

define('PAGE_LOADER', BASE_URL.'assets/img/loading.webp');

//Client Specific site wide information
define('CLIENT_FNAME','TIKAJ');
define('CLIENT_MNAME','Technologies Private Limited');
define('CLIENT_FULL_NAME', 'TIKAJ Technologies Private Limited');
define('CLIENT_ADDRESS','Gurgaon, Haryana');
define('CLIENT_CONATCT_NO','');
define('CLIENT_PINCODE','');

//Client Specific site wide information
define('CLIENT_USER_REGISTRATION_AMOUNT', 200);
define('CLIENT_REGISTRATION_FEE', CLIENT_USER_REGISTRATION_AMOUNT);
define('CLIENT_DIRECT_COMMISSION', 0.10);
define('CLIENT_ADMIN_FEE', 0.10);
define('CLIENT_TDS', 0.10);
define('CLIENT_ADF_PERCENT', 0.50);
define('CLIENT_LEVEL_REWARDS', array(0 => array('ADF' => 500, 'things' => '-')));
define('CLIENT_REGISTRATION_INTEREST', 0.4);;
define('CLIENT_MINIMUM_KYC_REQUIRED', 1);
define('WITHDRAWAL_DAY', 5);
define('CLIENT_WITHDRAWAL_NTH_DAY_WEEK',5);
define('CLIENT_WITHDRAWAL_7_DAY_OLD',4);
define('CURRENCY_SIGN', '₹');
define('MEMBER_ID_PREFIX', 'HHSW');
define('MEMBER_ID_LENGTH', 6);
define('CLIENT_TICKET_PREFIX', 'TIK-TIKAJ-');
define('CLIENT_TICKET_ID_LENGTH', 6);

//Client Mail Settings
define('CLIENT_FROM_EMAIL', 'all@xxx.xx.co');
define('CLIENT_HELPDESK_EMAIL', 'helpdesk@xxx.xx.co');
define('CLIENT_REPLYTO_EMAIL', 'all@xxx.xx.co');
define('CLIENT_SMTP_CONFIG', Array(
	'protocol' => 'smtp',
	'smtp_host' => 'xx.xxx.com',
	'smtp_port' => 587,
	'smtp_user' => 'all@xxx.xx.co',
	'smtp_pass' => 'xxxxx',
	'charset'   => 'iso-8859-1',
	'clrf' => '\r\n',
	'newline' => '\r\n'
));
define('CLIENT_DOMAIN', 'tikaj.com');
define('CLIENT_MAIL_FOOTER', '<div style="margin-top:10px"><p style="font-size:small;color:#777">—
<br>
Reply to this email directly or <a href="'.BASE_URL.'" target="_blank" >view it on the portal.</a>.
<br>
You\'re receiving this email because of your account on <a href="'.BASE_URL.'" target="_blank" >'.BASE_URL.'</a>.
</div></div>');

define('PAYMENT_ENV_MODE', "TEST");

define("CLIENT_KYC_DOCUMENTS", array("aadhar_front" => "Aadhar-Front","aadhar_back" => "Aadhar-Back", "pan_card" => "PAN Card", "bank_doc" => "Bank Documents", "voter_card" => "Voter Id Card", "others" => "Other Document"));

// Constants for enabling Modules
// MLM (Mutually exclusive)
define('BINARY_TREE',false);    
define('SINGLELEG_TREE',false);
// Micro Finance
define('LOAN_MODULE', false);
// Donation
define('DONATION_MODULE', true);

// define('DEFAULT_VIEW_FOLDER', 'loan');
define('DEFAULT_VIEW_FOLDER', 'donation');
//define('DEFAULT_VIEW_FOLDER', 'SingleLeg');
// define('DEFAULT_VIEW_FOLDER', 'Binary');
define('ADF_REPORT_PERMISSION',False);
define('INTERNAL_USER_REGISTER', True);
define('IS_DEV', true);

# Menues enable or disable
define('SMS_MENU_ENABLE', true);
define('KYC_MENU_ENABLE', true);
define('LOAN_NENU_ENABLE', true);


#donation amount
define('DONATION_AMOUNT',100);
define('TX_TYPE_DONATION',25);
define('TX_TYPE_PIN_PURCHASE', 26);

define('BANK',1);
define('UPI',2);
define('PAYTM',3);

define("SMS_CONFIG_FROM", 'XTIKET');
define("SMS_CONFIG_TOKEN", 'XXXXXXXXXXXXXXX');
define("SMS_TEMPLATE_USER_WELCOME", "Dear {{name}}, \r\nThank you for registering with ".CLIENT_FULL_NAME.".\r\n\r\nYour username is {{username}} and password is  {{password}}.\r\n\r\nLogin at:\r\n". BASE_URL);

# For Donation Module
define('CLIENT_USER_ACTIVATION_STATUS', 0);

// PIN Constants
define('PIN_AMOUNT', CLIENT_USER_REGISTRATION_AMOUNT);
define("PIN_BULK_PURCHASE_PLAN",
		 array(
				 "12" => array('free_pin' => "1"),
				 "33" => array('free_pin' => "3"),
				 "50" => array('free_pin' => "5"),
				 "100" => array('free_pin' =>"12"),
				 '12000' => array('free_pin' =>"0", 'plan' => "AIO")
			)
);

//Paytm Constants
define('PAYTM_ENVIRONMENT', PAYMENT_ENV_MODE); // PROD
$PAYTM_STATUS_QUERY_NEW_URL = $PAYTM_TXN_URL = null;
if (PAYTM_ENVIRONMENT === "TEST") {
	define('PAYTM_MERCHANT_MID', ''); //Change this constant's value with MID (Merchant ID) received from Paytm.
	define('PAYTM_MERCHANT_KEY', '');
	define('PAYTM_MERCHANT_WEBSITE', 'DEFAULT'); //Change this constant's value with Website name received from Paytm.

	$PAYTM_STATUS_QUERY_NEW_URL = 'https://securegw.paytm.in/merchant-status/getTxnStatus';
	$PAYTM_TXN_URL = 'https://securegw.paytm.in/theia/processTransaction';
} else {
	define('PAYTM_MERCHANT_MID', ''); //Change this constant's value with MID (Merchant ID) received from Paytm.
	define('PAYTM_MERCHANT_KEY', '');
	define('PAYTM_MERCHANT_WEBSITE', 'DEFAULT'); //Change this constant's value with Website name received from Paytm.

	$PAYTM_STATUS_QUERY_NEW_URL = 'https://securegw.paytm.in/merchant-status/getTxnStatus';
	$PAYTM_TXN_URL = 'https://securegw.paytm.in/theia/processTransaction';
}


define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_TXN_URL', $PAYTM_TXN_URL);

define('USER_SYSTEM_USERID', 1);
define('CLIENT_DOWNLINE_HALT', 6);
define('CLIENT_ACTIVATE_MEMBER_BY_DEFAULT', 7);
define('CLIENT_UPLINE_DONATION_AMT', 400);
define('CLIENT_UPPERLINE_DONATION_AMT', 600);
define('AIOPIN', CLIENT_UPLINE_DONATION_AMT + CLIENT_UPPERLINE_DONATION_AMT + CLIENT_REGISTRATION_FEE);

// Constants for selecting theme
define('CLIENT_SYSTEM_THEME', "custom.css");
//define('CLIENT_SYSTEM_THEME', "custom-flat.css");
