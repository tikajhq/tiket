<?PHP

require __DIR__ . '/constants.php';

class Notification_model
{

	static $notificationInstance = null;

	public function __construct()
	{
//        parent::__construct();
		self::$notificationInstance = $this;
		$this->collection = NOTIFICATION_TABLE;
	}

	/**
	 * Method which can be use to "emit" if certain event occurs in system.
	 * @param $event string Event name
	 * @param $params array Information about event
	 */
	static function notify($event, $params = [])
	{
		if (self::$notificationInstance == null)
			new Notification();

		self::$notificationInstance->emit($event, $params);
	}

	public function emit($event, $params = [])
	{
		// Log all messages to log file.
		log_message('error', '[' . $event . '] ' . json_encode($params));

		$this->db->insert($this->collection, array('username' => $this->session->userdata('username'), 'event' => $event, 'params' => $params, 'timestamp' => time()));
	}

	public function addCustomNotification($data)
	{
		// ['username' => $username, 'event' => 'custom_notification', 'message' => $message, 'timestamp' => time()];

		return $this->db->insertAll($this->collection, $data);
	}

	public function customNotificationHistory()
	{
		$results = $this->db->where(array('event' => 'custom_notification_log'))->get($this->collection);
		foreach ($results as &$result) {
			$result['timestamp'] = date('d-m-Y H:i:s', $result['timestamp']);
		}
		return $results;
	}


	public function userNotificationSeen($username)
	{
		$result = $this->db->set(array('params.seen' => true))->where(array('params.username' => $username))->updateAll($this->collection);
		return $result;
	}

	public function convertTimestamp($results)
	{
		foreach ($results as $key => &$value) {
			$value['timestamp'] = date("Y-m-d H:i", (int)($value['timestamp']));
		}
		return $results;
	}

}
