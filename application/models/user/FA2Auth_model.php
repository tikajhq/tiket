<?PHP

require_once __DIR__ . "/User_model.php";
require_once __DIR__ . "/constants.php";
require_once __DIR__ . "/../core/Token_model.php";
require_once __DIR__ . "/../core/Template_model.php";

class FA2Auth_model extends Token_model
{

	public function test()
	{
		$type = "register";
		$otp = $this->generateOTP($type);

		if ($_SESSION['otp_' . $type] == $otp) {
			echo "Generate_otp() --> Successful!";
		}

		$verify = $this->checkOTP($otp, 'otp_' . $type);
		if (!$verify) {
			echo "CheckOTP() --> ERROR!";
		} else {
			echo "checkOTP() --> Successful!";
		}
	}


	public function generateOTP($type)
	{
		$type = 'otp_' . $type;
		// $otp = 123456;
		$otp = rand(100000, 999999);
		$_SESSION[$type] = $otp;
		return;
	}

	public function checkOTP($otp, $type)
	{
		$type = 'otp_' . $type;
		if (isset($_SESSION[$type])) {
			if ($_SESSION[$type] == $otp) {
				unset($_SESSION[$type]);
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function resendOTP($to, $name, $type)
	{
		$type = 'otp_' . $type;
		if (isset($_SESSION[$type])) {
			$otp = $_SESSION[$type];
			$data = array(
				'name' => $name,
				'mobile' => $to,
				'otp' => $otp,
			);
			// Notification_model::notify("opt.resend", [$type, $data]);
			return $this->sendOTP($to, $name, $type, $otp, $gatewayPriority = 50);
		} else {
			return false;
		}
	}

	public function sendOTP($to, $name, $type, $otp = null, $gatewayPriority = 100)
	{
		if ($otp == null)
			$otp = $this->generateOTP($type);
		$message = 'Hi ' . $name . ' Welcome ! Your login OTP Is ' . $otp . ' Time validation 10 min.';
		$this->sendSMS($to, $message, $gatewayPriority);
		$data = array(
			'name' => $name,
			'mobile' => $to,
			'otp' => $otp,
		);
		//Notification_model::notify("opt.send", [$type, $data]);
		return $otp;
	}


}
