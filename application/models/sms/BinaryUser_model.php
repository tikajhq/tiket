<?PHP
require_once __DIR__ . "/constants.php";
require_once __DIR__ . "/../user/UserDetail_model.php";

class BinaryUser_model extends UserDetail_model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('core/Session_model', 'Session');
	}

	public function getUserContacts()
	{
		return $this->db->select('name, mobile')
				 ->get(TABLE_USERS)->result_array();
	}


}
