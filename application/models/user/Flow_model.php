<?PHP

require_once __DIR__ . "/User_model.php";
require_once __DIR__ . "/constants.php";
require_once __DIR__ . "/../core/Session_model.php";


class Flow_model  extends BaseMySQL_model
{

	public function __construct()
	{
		parent::__construct(TABLE_USER);
		$this->User = new User_model();
		$this->Token = new Token_model();
		$this->Session = new Session_model();

	}

	public function register_flow()
	{
		
	}
	public function next_flow(){

	}
	public function set_currentIndex(){


	}


}
