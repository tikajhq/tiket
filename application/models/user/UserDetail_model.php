<?PHP
require_once __DIR__."/User_model.php";

/**
 * Class UserDetail_model
 * Details of user.
 */
class UserDetail_model extends User_model {

	public function __construct()
    {
        parent::__construct();
    }


	public function makeDatatableQuery($table, $db, $context, $arguments = null)
	{

		return true;
	}

}
