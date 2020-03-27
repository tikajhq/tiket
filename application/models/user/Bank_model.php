<?PHP
include_once __DIR__ . "/constants.php";


class Bank_model extends BaseMySQL_model
{
	public function __construct()
	{
		parent::__construct(TABLE_BANKS);
	}

	/**
	 * Add item and return id.
	 * @param $name
	 * @param $parentID
	 * @param int $status
	 * @return mixed
	 */
	public function add($name, $status = 1)
	{
		return parent::add([
			"name" => $name,
			"status" => $status
		]);
	}

	public function getBanks()
	{
		return parent::getAll();
	}

}
