<?php
/**
 * Created by IntelliJ IDEA.
 * User: dee
 * Date: 12/5/19
 * Time: 3:12 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class SMS extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('sms/Smsmodel_model', 'smsModel');
	}

	public function getAllSmsInfo()
	{
		$this->sendJSON($this->smsModel->getAllSMS());
	}

	public function getSMSDetailedView()
	{
		$CampID = $_GET['camp'];
		$this->sendJSON($this->smsModel->getCampaignInfoById($CampID));
	}

	public function runScheduledSmsSender()
	{
		$qq = $this->smsModel->getScheduledSms();
		foreach($qq as $smsId)
		{
			$this->smsModel->ScheduledSmsSender($smsId['id']);
		}
	}
}
