<?PHP

require __DIR__ . "/Token_model.php";

class BaseApi_model
{

	public function __construct()
	{
		$this->Token = new Token_model();
	}

	function requireToken()
	{
		$token = null;
		if (isset($_GET['xtoken'])) $token = $_GET['xtoken'];
		else if (isset($_POST['xtoken'])) $token = $_POST['xtoken'];

		$sess = $this->Token->get($token);
		$response = array(
			'status' => false,
			'message' => "You need xtoken to access this API"
		);

		if (!$sess) {
			echo json_encode($response);
			//bad code, bad code, very bad code - but seems like good solution.
			die();
			return false;
		}

		$_SESSION['username'] = $sess['user'];
		$_SESSION['is_logged'] = true;

		return $sess;
	}

}
