<?PHP
require_once(__DIR__. "/constants.php");

class Session_model extends BaseMySQL_model
{

	public function __construct()
	{
		parent::__construct("Session");
	}

	public function test()
	{
		$data = array(
			"id" => '1',
			"username" => "james",
			"name" => "James Bond",
			"email" => "james@gmail"
		);

		$ses = $this->set($data);
		if ($_SESSION[SESSION_KEY_PREFIX . '_user_data']['username'] == $data['username']) {
			echo "session->set() --> Successful!";
		} else {
			echo "session-set() --> Error!";
		}

		$getSession = $this->get($data['id']);
		if (!$getSession) {
			echo "get session() --> ERROR!";
		} else {
			echo "get session() --> Successfull!";
		}

		$this->destroy('user_data');
		if (!isset($_SESSION['user_data']['username'])) {
			echo "destroy_session() --> Successfull!";
		} else {
			echo "Destroy_session() --> Error!";
		}

		return;
	}


	/**
	 * Set complete session data
	 * @param $data
	 * @param string $key
	 * @return mixed
	 */
	public function setSession($data, $key = "xsession")
	{
		$_SESSION[SESSION_KEY_PREFIX . '_' . $key] = $data;
		return $data;
	}


	/**
	 * Return complete session data.
	 * @param $key
	 * @return mixed|null
	 */
	public function getSession($key = "xsession")
	{
		if (!isset($_SESSION[SESSION_KEY_PREFIX . '_' . $key])) return null;
		return $_SESSION[SESSION_KEY_PREFIX . '_' . $key];
	}


	/**
	 * Unset all given session keys else destroy the session completely.
	 * @param $sessionKeys array|string
	 * @return bool
	 */
	public function destroy($sessionKeys = null)
	{
		if ($sessionKeys !== null) {
			if (!is_array($sessionKeys))
				$sessionKeys = array($sessionKeys);
			foreach ($sessionKeys as $key)
				unset($_SESSION[$key]);

			return true;
		}
		session_destroy();
		return true;
	}


	/**
	 * Set session for login
	 * @param $username string
	 * @param $permissions array an  associative array of permission numbers eg: array(PERMISSION_ADMIN=>true)
	 * @param $details array
	 */
	public function login($username, $permissions, $details)
	{
		$this->setSession($username, "username");
		$this->setSession($details, "details");

		if (isset($permissions[0])) //it's a bad hack, any fast solution.
			throw new Error("Permissions should be an associative array.");
		$this->setSession($permissions, "permissions");
	}


	/**
	 * If a user is logged in or not.
	 * @return bool
	 */
	public function isLoggedin()
	{
		return $this->getSession('username') !== null;
	}

	/**
	 * Logged username.
	 * @return mixed|null
	 */
	public function getLoggedUsername()
	{
		return $this->getSession('username');
	}

	public function isAdmin()
	{
		$details = $this->getSession('details');
		if($details['type'] == 100)
			return true;
		return false;
	}

	public function isUser()
	{
		$details = $this->getSession('details');
		if($details['type'] == 10)
			return true;
		return false;
	}


	/**
	 * Return user's default permissions, it checks user type presence in DEFAULT_PERMISSIONS_USERS
	 * if found returns user's permissions.
	 * @param $userType
	 * @return mixed
	 */

	public static function getDefaultPermissions($userType){
		if(!isset(DEFAULT_PERMISSIONS_USERS[$userType]))
			throw new Error("Default permissions of usertype '".$userType."' is not defined in DEFAULT_PERMISSIONS_USERS.");
		return DEFAULT_PERMISSIONS_USERS[$userType];
	}


	/**
	 * Array of what permissions current session has.
	 * @return mixed|null
	 */
	public function getLoggedPermissions()
	{
//		$permissions = $this->getSession('permissions');
//		if($permissions===null)
		return $this->getDefaultPermissions($this->getUserType());

//		return $permissions;
	}


	/**
	 * Associative array of details of currently logged user.
	 * @return mixed|null
	 */
	public function getLoggedDetails()
	{
		return $this->getSession('details');
	}


	/**
	 * Returns currently logged user type, if user isn't logged in USER_PUBLIC is returned.
	 * @return mixed
	 */
	public function getUserType(){
		$details = $this->getSession('details');
		return isset($details['type'])?$details['type']:USER_PUBLIC;
	}


	/**
	 * Validate for $currentPermissions and $requiredPermissions.
	 * @param $currentPermissions array Current permissions
	 * @param $requiredPermissions array Array of int's representing permission, it should be sorted.
	 * @return bool
	 */
	public static function checkPermission($currentPermissions, $requiredPermissions)
	{
		if (!$currentPermissions) return false;

		//Redundancy is present due to fact that this method will be used everywhere. it needs to be fast.
		if (!is_array($requiredPermissions))
			return (isset($currentPermissions[$requiredPermissions]) && $currentPermissions[$requiredPermissions]);

		//Sort required permission
		//sort($requiredPermissions);

		foreach ($requiredPermissions as $value)
			//if key is not set or value is false return false.
			if (!isset($currentPermissions[$value]) || !$currentPermissions[$value])
				return false;

		return true;
	}


	/**
	 * Destroy current session.
	 * @return bool
	 */
	public function logout()
	{
		foreach (array('username', 'permissions', 'details') as $key)
			unset($_SESSION[SESSION_KEY_PREFIX . $key]);
		return $this->destroy();
	}

}
