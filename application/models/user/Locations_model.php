<?PHP
include_once __DIR__ . "/constants.php";
/*
 * CREATE TABLE `location` (
`id` int(11) NOT NULL,
`name` varchar(30) NOT NULL,
`parent_id` int(11) NOT NULL DEFAULT '1',
`status` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

 */

class Locations_model extends BaseMySQL_model
{
	public function __construct()
	{
		parent::__construct(TABLE_LOCATIONS);
	}

	/**
	 * Add item and return id.
	 * @param $name
	 * @param $parentID
	 * @param int $status
	 * @return mixed
	 */
	public function add($name, $parentID = null, $status = 1)
	{
		return parent::add([
			"name" => $name,
			"parent_id" => $parentID,
			"status" => $status
		]);
	}

	public function getCountries()
	{
		return $this->getLocationByParentID(0);
	}

	public function getLocationByParentID($parent)
	{
		return parent::getBy(['id', 'name'], [
			'parent_id' => $parent,
			'status' => STATUS_ACTIVE
		]);
	}

	public function getStates($country = 0)
	{
		return $this->getLocationByParentID($country);
	}


	public function getCities($stateID)
	{
		return $this->getLocationByParentID($stateID);
	}
}
