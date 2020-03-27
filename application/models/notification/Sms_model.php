<?PHP
require_once(__DIR__ . '/constants.php');
require_once(__DIR__ . '/../core/QuickTemplate.php');
require_once(__DIR__ . '/../core/DataHandler.php');

class Sms_model
{
	private $config = array();

	public function __construct()
	{

		$this->config = array(
			'url' => 'http://api.msg91.com/api/sendhttp.php?country=91&route=4&message=$message&campaign=calcun&unicode=1',
			'method' => 'get',
			'fields' => array(
				'message' => 'message',
				'to' => 'mobiles',
				'from' => 'sender',
				'token' => 'authkey'
			),
			'params' => null
		);
	}

	public function send($to, $message)
	{

		$config = $this->config;
		$url = $config['url'];
		$fields = $config['fields'];

		//TODO: Implement method and params.
		$method = $config['method'];
		$params = $config['params'];

		$url = $url . '&' . http_build_query(array(
				$fields['message'] => urlencode($message),
				$fields['to'] => $to,
				$fields['from'] => SMS_CONFIG_FROM,
				$fields['token'] => SMS_CONFIG_TOKEN,
			));
		return DataHandler::get($url);
	}

	public function sendTemplated($to, $template, $data = '')
	{
		$temp = new QuickTemplate();
		return $this->send($to, $temp->parse($template, $data));
	}

}

