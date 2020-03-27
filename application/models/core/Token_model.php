<?PHP

require_once(__DIR__ . "/constants.php");

class Token_model  extends BaseMySQL_model
{

	public function __construct()
	{
		parent::__construct(TABLE_TOKENS);
		$this->tokenId = '';
	}

	public function test()
	{
		$uId = '1';
		$tokenType = "test_token";
		$token = $this->generate($uId, $tokenType);
		if ($token) {
			echo "createToken() --> Successfull!";
		} else {
			echo "CreateToken() ---> ERROR";
		}

		$recentToken = $this->getRecentToken($uId, $tokenType);
		if (!$recentToken) {
			echo "getRecentToken() --> ERROR!! ";
		} else {
			echo "getRecentToken() --> SUCCESS!";
		}

		$verify = $this->verifyToken($uId, $tokenType, $token);
		if ($verify) {
			echo "verifyToken() --> Successfull!";
		} else {
			echo "VerifyToken() --> ERROR!";
		}

		$this->deleteById($this->tokenId);
		return;
	}

	public function generate($uid, $type, $token = null, $valid_till, $meta )
	{
		if ($token == null)
			$token = strtoupper(substr(sha1(rand()), 0, 8));

		$data = array(
			"uid" => $uid,
			"type" => $type,
			"token" => $token,
			"status" => TOKEN_ACTIVE,
			'meta' => json_encode($meta),
			'valid_till' => $valid_till
		);

		$this->tokenId = parent::add($data);
		return $token;
	}

	/**
	 * Verify a given token for a user.
	 * @param $uid
	 * @param $type
	 * @param $token
	 * @return bool
	 */
	public function verifyToken($uid, $type, $token)
	{
		$token = (string)$token;

		$query = array('uid' => $uid, "type" => $type, "token" => $token, "status" => TOKEN_ACTIVE);
		$result = parent::getBy("*", $query);

		if (empty($result)) return false;

		if ($result[0]['token'] == $token) {
			$this->setTokenStatus($result[0]['id']);
			return true;
		} else {
			return false;
		}
	}


	/**
	 * Expire a given tokenid.
	 * @param $tid
	 * @param int $status
	 * @return mixed
	 */
	public function setTokenStatus($tid, $status = 0)
	{
		return parent::setStatus($tid, $status);
	}


	/**
	 * Get last created token of certain type.
	 * @param $uid
	 * @param $type
	 * @return bool
	 */
	public function getRecentToken($uid, $type)
	{
		//$gte OTPEXPIRYTIME(in secs) conts
		$query = array('uid' => $uid, 'type' => $type, 'status' => 1);
		$result = $this->db->where($query)->order_by("updated", "DESC")->limit(1)->get(TABLE_TOKENS)->row_array();

		if (empty($result))
			return false;
		return $result['token'];
	}


	/**
	 * Get information about token, can be used to verify token.
	 * @param $token
	 * @return bool
	 */
	public function getToken($uid, $token)
	{
		$query = array('uid' => $uid, 'token' => $token, 'status' => TOKEN_ACTIVE);
		return parent::getOneItem(parent::getBy("*, uid as user_id", $query));
	}

	public function AtokenReport()
	{
		$aid = $this->session->sessions_details['id'];
		return $this->db->select('uid as user_id, type, token, status, created, meta')
						->like('meta', ':"'.$aid.'"}', 'before')
						->get(TABLE_TOKENS)->result_array();
	}

	public function UtokenReport()
	{
		$uid = $this->session->sessions_details['id'];
		return $this->db->select('uid as user_id, type, token, status, created, meta')
						->where('uid', $uid)
						->get(TABLE_TOKENS)->result_array();
	}

	public function pin_alloc_report()
	{
		return $this->db->query("SELECT count(t1.id) as total, t1.uid as userid, (select count(id) from tokens where uid=t1.uid and status=1) as active, (select count(id) from tokens where uid=t1.uid and status=0) as inactive, u.name as username, u.mobile as mobilenum, u.email as mailid FROM ".TABLE_TOKENS." t1 RIGHT JOIN ".TABLE_USERR." as u ON t1.uid = u.id GROUP BY t1.uid")->result_array();
	}

	public function getPINdetails($pin)
	{
		return $this->db->select('uid as user_id, type, token, status, created, meta')
						->where('token', $pin)
						->get(TABLE_TOKENS)->result_array()[0] ?? '';
	}

	public function deactivatePIN($pin)
	{
		$this->db->where('token', $pin)
				 ->update(TABLE_TOKENS, array('status'  => TOKEN_STATUS_DEACTIVATE));
	}
}
