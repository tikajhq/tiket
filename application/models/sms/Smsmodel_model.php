<?PHP
require_once __DIR__ . "/constants.php";

class Smsmodel_model extends BaseMySQL_model
{
	public function __construct()
	{
		parent::__construct(TABLE_SMS);
		$this->load->model('notification/Sms_model', 'SMS');
	}

	public function sendSMS($info)
	{
		$camp_id = md5(date('dmYHis'));
		if(count($info))
		{
			$members = explode(";", trim($info['members_to_send']));
			foreach($members as $member)
			{
				$date = new DateTime();
				$timestamp = $date->getTimestamp();
				$smsData['campaign_name']	= empty(trim($info['sms_campaign'])) ? 'Not Defined' : trim($info['sms_campaign']);
				$smsData['sentto']			= trim($member);
				$smsData['created']			= $timestamp;
				$smsData['message']			= trim($info['ticketmessage']);
				$smsData['schedule']		= SMS_NOT_SCHEDULED;
				if(trim($info['schedule']) != '')
				{
					$smsData['schedule'] 	= strtotime(date_format(date_create(str_replace("T", " ", $info['schedule']).":00"),"Y/m/d H:i:s"));
				}
				
				if($smsData['schedule'] == '')
				{
					$sms_send = $this->SMS->sendTemplated($smsData['sentto'], $smsData['message'], $smsData);
					if($sms_send) {
						$smsData['status']	= SMS_SENT;
						$smsData['sendon']	= $timestamp;
					}
					else {
						$smsData['status']	= SMS_QUEUED;
						$smsData['sendon']	= 0;
					}
				}
				else
				{
					$smsData['status']		= SMS_QUEUED;
					$smsData['sendon']		= 0;
				}
				$smsData['owner']			= $this->session->userdata()['sessions_details']['id'];
				$smsData['camp_id']			= $camp_id;
				$this->db->insert(TABLE_SMS, $smsData);
			}
		}
		
	}

	public function getAllSMS()
	{
		return $this->db->select('campaign_name, created, COUNT(sentto) AS mambers, CONCAT(SUM(STATUS), \' out of \', COUNT(sentto)) total_send, camp_id')
						->where('owner', $this->session->userdata()['sessions_details']['id'])
				 		->group_by('camp_id')
				 		->get(TABLE_SMS)->result_array();
	}

	public function getCampaignInfoById($smsid)
	{
		return $this->db->select('id, created, sentto, status, schedule')
						->where('camp_id', $smsid)
				 		->get(TABLE_SMS)->result_array();
	}

	public function smsInfoByPrimary($smsId)
	{
		return $this->db->select('COUNT(sentto) AS receivers, message, campaign_name')
						->where('camp_id', $smsId)
				 		->group_by('camp_id')
				 		->get(TABLE_SMS)->result_array();
	}



	// ***********************************************************
	// ***********************************************************
	// Part for scheduled SMS

	public function getScheduledSms()
	{
		return $this->db->select('id')
						->where('schedule !=', SMS_NOT_SCHEDULED)
						->where('status', SMS_QUEUED)
				 		->get(TABLE_SMS)->result_array();
	}

	public function getSmsById($smsId)
	{
		return $this->db->select('sentto, message, schedule')
						->where('id', $smsId)
						->get(TABLE_SMS)->result_array();
	}

	public function ScheduledSmsSender($smsId)
	{
		$timestampNow = time();
		$smsData = $this->getSmsById($smsId);
		if($smsData[0]['schedule'] < $timestampNow)
		{
			$timestamp = time();
			$this->SMS->sendTemplated($smsData[0]['sentto'], $smsData[0]['message'], $smsData);
			$smsNewData = array(
				'status' => SMS_SENT,
				'sendon' => $timestamp
			);
			$this->db->where('id', $smsId);
			$this->db->update(TABLE_SMS, $smsNewData); 
		}
	}

	public function cancelScheduledSms($smsId)
	{
		$cancelData = array(
			'status' => SMS_SCHEDULED_CANCELLED,
		);
		return $this->db->update(TABLE_SMS, $cancelData); 
	}

	public function makeDatatableQuery($table, $context, $db, $arguments = null)
	{
		$db->group_by('camp_id');
		return array(
			'columns' => array(
				'campaign_name'=>'campaign_name',
				'created'=>'created',
				'members'=>'COUNT(sentto)',
				'total_sent'=>'SUM(CASE WHEN STATUS = 1 THEN 1 ELSE 0 END)',
				'schedule_cancelled'=>'SUM(CASE WHEN STATUS = 2 THEN 1 ELSE 0 END)',
				'camp_id'=>'camp_id'
			),
		);
	}



}
