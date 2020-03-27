<?PHP
define("TABLE_USER", TABLE_PREFIX . "users");
define("TABLE_GRAPHS", TABLE_PREFIX . "graph");
define("LOGIN_TABLE", TABLE_PREFIX . "login");
define("LOGIN_FIELD", "username");
define("TABLE_USER_DETAILS", TABLE_PREFIX . "users_details");
define("TABLE_KYC", TABLE_PREFIX . "kyc");
define("TABLE_LOCATIONS", TABLE_PREFIX . "locations");
define("TABLE_RANKS", TABLE_PREFIX . "ranks");
define("TABLE_BANKS", TABLE_PREFIX . "banks");
define("TABLE_BANK_DETAILS", TABLE_PREFIX. "bank_details");




if(DONATION_MODULE)
{
	define("KYC_DOCUMENTS", array("aadhar_front" => array("title"=>"Aadhar-Front", "fields"=>array("aadhar_front_primary_account_no", "aadhar_front_name"), "primary"=> "aadhar_front_primary_aadhar_no"),
	"aadhar_back" => array("title"=>"Aadhar-Back", "fields"=>array(), "primary"=> "aadhar_back_no"),
	"pan_card" => array("title"=>"PAN Card", "fields"=>array("pan_card_primary_card_no", "pan_card_name", "pan_card_dob"), "primary"=> "pan_card_primary_card_no"),
	"bank_doc" => array("title"=>"Bank Documents", "fields"=>array("bank_doc_primary_acc_no", "bank_doc_name", "bank_doc_ifsc"), "primary" => "bank_doc_primary_acc_no")
	));
}
else
{
	define("KYC_DOCUMENTS", array("aadhar_front" => array("title"=>"Aadhar-Front", "fields"=>array("aadhar_front_primary_account_no", "aadhar_front_name"), "primary"=> "aadhar_front_primary_aadhar_no"),
	"aadhar_back" => array("title"=>"Aadhar-Back", "fields"=>array(), "primary"=> "aadhar_back_no"),
	"pan_card" => array("title"=>"PAN Card", "fields"=>array("pan_card_primary_card_no", "pan_card_name", "pan_card_dob"), "primary"=> "pan_card_primary_card_no"),
	"bank_doc" => array("title"=>"Bank Documents", "fields"=>array("bank_doc_primary_acc_no", "bank_doc_name", "bank_doc_ifsc"), "primary" => "bank_doc_primary_acc_no"),
	"voter_card" => array("title"=>"Voter Id Card", "fields"=>array("voter_card_primary_card_no", "voter_card_name", "voter_card_dob"), "primary"=> "voter_card_primary_card_no"),
	"others" => array("title"=>"Other Document", "fields"=>array("other_document_no", "other_document_name", "other_document_dob"), "primary"=> "other_document_no")
	)
);
}


# Gender Types
const GENDER_TYPE = array(
	0 => 'Male',
	1 => 'Female',
	2 => 'Other'
);

define('USER_STATUS_ACTIVE', 1);
define('USER_STATUS_INACTIVE', 0);

define("TIKTABLE_LIST_USERS_ALL", 0);
define("TIKTABLE_LIST_MEMBERS_ACTIVE", 0);
