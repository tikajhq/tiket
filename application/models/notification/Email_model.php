<?PHP

require __DIR__ . "/constants.php";
// require __DIR__ . "/../core/Template_model.php";
include_once './vendor/autoload.php';
use EmailReplyParser\Parser\EmailParser;


class Email_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->loadCI();
		$config = array();
		// if(!empty(CLIENT_SMTP_CONFIG))
		// 	$config = CLIENT_SMTP_CONFIG;
		$this->load->library('email', $config);
		// $this->CI->load->model('Template_model');
	}

	public function send($to, $from, $subject, $body, $replyto=NULL)
	{
		$body = $this->_wrapTemplate($body);

		$result = $this->email->set_mailtype("html")->set_newline("\r\n")
			->from($from)
			->to($to)
			->reply_to($replyto)
			->subject($subject)
			->message($body)
			->send();

		return $result;
	}

	public function _wrapTemplate($body)
	{
		return $body;
	}

	public function sendByTemplate($to, $templateID, $data)
	{
		$templateBody = $this->CI->Template_model->parseById($templateID, $data);

	}

	// returns only the current content string eliminating threads
	public function getCurrentEmailContent($content){
		$res = current(((new EmailParser())->parse($content))->getFragments());
        return $res->getContent();
	}
}
