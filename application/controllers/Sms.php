<?PHP

class Sms extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		parent::requireLogin();
		$this->setHeaderFooter('global/header.php', 'global/footer.php');
		$this->load->model('sms/BinaryUser_model', 'User');
		$this->load->model('sms/Smsmodel_model', 'smsModel');	
	}

	public function send_sms()
	{
		$this->requirePermissions(PERMISSION_SMS_SEND);
		$data['members'] = $this->User->getUserContacts();
		if($_POST) {
			$this->smsModel->sendSMS($_POST);
			set_msg('success', "SMS send Successfully to all members.");
		}
		$this->render('Send SMS', 'sms/send_sms', $data);
	}

	public function all_sms()
	{
		$this->requirePermissions(PERMISSION_SMS_VIEW);
		$data['campaign_status'] = $this->smsModel->getAllSMS();
		$this->render('All SMS', 'sms/all_sms', $data);
	}

	public function smsDetails()
	{
		$this->requirePermissions(PERMISSION_SMS_VIEW);
		$data['smsID'] = $this->uri->segment(3);
		$data['smsInfo'] = $this->smsModel->smsInfoByPrimary($data['smsID']);
		$this->render('SMS Detailed View', 'sms/sms_details', $data);
	}

	public function cancelSchedule()
	{
		$this->requirePermissions(PERMISSION_SMS_VIEW);
		$sms_id = $_GET['sms'];
		$camp_id = $_GET['camp'];
		$this->smsModel->cancelScheduledSms($sms_id);
		redirect(BASE_URL.'sms/smsDetails/' . $camp_id);
	}

}