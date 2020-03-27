<?PHP

require_once __DIR__ . "/User_model.php";
require_once __DIR__ . "/constants.php";
require_once __DIR__ . "/../core/Token_model.php";
require_once __DIR__ . "/../core/Template_model.php";
require_once __DIR__ . "/../core/Session_model.php";


class Auth_model extends BaseMySQL_model
{

	public function __construct()
	{
		parent::__construct(TABLE_USER);
		$this->User = new User_model();
		$this->Token = new Token_model();
		$this->Session = new Session_model();

		$this->type_forgot = "forgot_password";
	}

	public function login($data)
	{
		$username = trim($data['username']);
		$password = $data['password'];
		$user = $this->User->getOneItem($this->User->getByOR("*", array('username' => $username)));
		if ($user && $user['password'] === $this->User->hashPassword($password) && $user['status'] == STATUS_ACTIVE)
		{
			unset($user['password']);
			return $user;
		}
		return false;
	}

	// public function sendResetPasswordLink($userId=null)
	// {
	//     $user = $this->User->getUsersBy(array('id' => $userId));
	//     if(count($user) < 1)
	//         return false;
	//     $user = $user[0];
	//     $type = "forgot_password";
	//     $token = $this->Token->create($user['id'], $this->type_forgot);
	//     $userdata = $user;
	//     $userData['token'] = $token;

	//     $this->sendResetLink($userData);
	// }


	//todo
	public function sendResetLink($id)
	{
		//Create instance for template model here for just one method
		$this->template = new Template_model();

		$templateId = $this->template->getTemplatesBy(array('type' => 'forgot_password'));
		$templateId = $templateId[0];

		$user = $this->User->getUsersBy(null,$query = ['id' => $id]);
		$user = $user[0];

		$token = $this->Token->generate($id, $this->type_forgot);
		$url = $this->generatePasswordResetLink($user['username'], $token);

		$data = array(
			'username' => $user['username'],
			'token' => $user['token']
		);

		$htmlData = $this->Template->parseById($templateId['id'], $data);
		$res = $this->mailer->send(CLIENT_SUPPORT_EMAIL, $user['email'], 'Password Reset Link', $htmlData);
		return $res;
	}

	public function generatePasswordResetLink($username, $token)
	{
		$url = BASE_URL . "auth/reset_password?username=$username&token=$token";
		return $url;
	}

	public function verifyPasswordResetLink($username, $token)
	{
		$user = $this->User->getUsersBy(null,array('username' => $username));
		if (count($user) < 1)
			return false;

		$user = $user[0];
		$result = $this->Session->verifyToken($user['username'], $token);
		if (!$result)
			return false;
		$newPassword = $this->generateRandomPassword(6);
		return $newPassword;
	}

	public function generateRandomPassword($n)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@$^#';
		$randomString = '';

		for ($i = 0; $i < $n; $i++) {
			$index = rand(0, strlen($characters) - 1);
			$randomString .= $characters[$index];
		}
		return $randomString;
	}


	public function setRandomPassword($username)
	{
		$random_password = $this->generateRandomPassword(8);
		$res = $this->user->update_user($username, array('password' => md5($random_password)));
		$user = $this->User->get_user_details($username);
		if ($res) {
//            Send Mail or Sms
			$body = 'Hi ' . $username . ', You recently requested a password reset. Your new password is' . $random_password;
//            $this->mailer->send($user['email'], 'jbi@fixange.com', 'Password Reset Request', $body);
//            $this->SMS->sendSMS($user['mobile'], "Dear " . $user['name'] . " Your new password is " . $random_password);
		}
		return $res;

	}


	public function do_payment($userData)
	{
		$_SESSION['pending_registration'] = $userData;
		$this->load->model('payment/Paytm_model', 'Paytm');
		$desc = 'Member Registration for ' . $userData['name'].', Mobile number - ' . $userData['mobile'];
		$payment = $this->Paytm->generateTX(USER_SYSTEM_USERID, CLIENT_REGISTRATION_FEE, 0, TX_TYPE_DEPOSIT, $desc);
		$payment['redirect'] = BASE_URL . "/auth/registration_payment";
		$_SESSION[PAYMENT_SESSION_KEY] = $payment;
		return $payment['html'];
	}



}
