<?PHP
require_once(__DIR__ . "/constants.php");
require_once(APPPATH . 'libraries/mustache/src/Mustache/Autoloader.php');

Mustache_Autoloader::register();

/**
 * Class Template_model
 * Store, load templates etc.
 */

class Template_model extends BaseMySQL_model
{

	public function __construct()
	{
		parent::__construct(TABLE_TEMPLATES);
		$this->mustache = new Mustache_Engine();
	}

	public function test()
	{
		$templateData = "Hello {{name}} , Your username is {{username}}";

		$data = array(
			'template' => $templateData,
			'type' => 'signup'
		);

		$tId = $this->add($data);
		if ($tId) {
			echo "templateCreate() ---> Successfull!";
		} else {
			echo "templateCreate() ---> ERROR!";
		}

		$checkTemplateData = $this->getTemplatesBy(array('id' => $tId));
		if ($checkTemplateData[0]['template'] == $templateData) {
			echo "getTemplateById() ---> Successfull!";
		} else {
			echo "getTemplateById() ---> ERROR!";
		}

		$user = array(
			"username" => "james123",
			"name" => "James Bond"
		);

		$html = $this->parseById($tId, $user);
		echo $html;

		$deleteRes = $this->deleteById($tId);
		if ($deleteRes) {
			echo "deleteById() --> Successfull!";
		} else {
			echo "deleteById() ---> Error";
		}

		return;
	}

	public function getTemplatesBy($query)
	{
		return parent::getBy("*", $query);
	}


	/**
	 * Update body of a template.
	 * @param $templateID
	 * @param string $body
	 * @return mixed
	 */
	public function update($templateID, $body)
	{
		return parent::setByID($templateID, array('template' => $body));
	}


	/**
	 * Parse a given template using mustache template engine with data as array
	 * @param $template String template
	 * @param array $data Array of data items.
	 * @return string
	 */
	public function parse($template, $data)
	{
		return $this->mustache->render($template, $data);
	}


	/**
	 * Load and parse a template by id.
	 * @param string $id
	 * @param array $data
	 * @return bool|string
	 */
	public function parseById($id, $data = array())
	{
		$result = parent::getOneItem(parent::getBy("*", array("id" => $id)));
		if ($result !== null) {
			$template = $result['template'];
			return $this->parse($template, $data);
		}

		return FALSE;
	}


}
