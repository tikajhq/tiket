<?php

class MY_Controller extends CI_Controller
{

	//List of view to run pre and post
	var $PRE_RENDER = array();
	var $POST_RENDER = array();
//	Set the path of view.
//	var $VIEW_ROOT = null;

	//Store data about current SCOPE
	var $SCOPE_DATA = array();

	//Store data about current SCOPE
	var $LOOKUP_PATHS = array('/');

	function __construct()
	{
		parent::__construct();
		$this->SCOPE_DATA = array();
		$this->load->model('core/Session_model', 'Session');
	}


	/**
	 * Add path where to lookup for views.
	 * @param $paths
	 * @return array
	 */
	function addLookupPaths($paths)
	{
		if (!is_array($paths))
			$this->LOOKUP_PATHS[] = $paths;
		else {
			foreach ($paths as $path)
				$this->LOOKUP_PATHS[] = $path;
		}
		return $this->LOOKUP_PATHS;
	}


	/**
	 * Set a user's session.
	 * @param $username
	 * @return bool
	 */
	protected function setSession($username)
	{
		$this->load->model('user/User_model', 'User');

		$query = array('username' => $username);
		$user = $this->User->getUsersBy(null, $query);
		if (count($user) > 0) {
			$user = $user[0];
		} else {
			return FALSE;
		}

		$userSession = $this->Session->setUserSession($user['id']);
		return $userSession;
	}


	/**
	 * Force controller to need login otherwise redirect.
	 * @return bool
	 */
	protected function requireLogin()
	{
		if (!$this->Session->isLoggedin()) {
			redirect(URL_LOGIN);
			//Warning: Stop the execution, don't use this method in other places.
			die();
			return false;
		}

		$this->SCOPE_DATA['logged'] = array(
			'username' => $this->Session->getLoggedUsername(),
			'details' => $this->Session->getLoggedDetails(),
			'permission' => $this->Session->getLoggedPermissions()
		);
		return true;
	}


	/**
	 * To check the user's privilege for the particular action
	 * where $privilege = 'action'
	 * @param $permissions
	 * @return bool
	 */
	protected function requirePermissions($permissions)
	{
		$currentPermissions = ($this->Session->getLoggedPermissions());

		if (!$this->Session->checkPermission($currentPermissions, $permissions)) {
			unauthorized(null, $permissions);
			//Warning: Stop the execution, don't use this method in other places.
			die();
		}
		return true;
	}


	protected function isPOST()
	{
		return $_SERVER['REQUEST_METHOD'] === 'POST';
	}


	/**
	 * Return path of view which can be found in LOOKUP_PATH.
	 * @param $name string name of the view
	 * @return string|null
	 */
	protected function lookForView($name)
	{
		$root = APPPATH . '/views/';
		$lookupPaths = $this->LOOKUP_PATHS;
		$i = count($lookupPaths);
		while ($i) {
			$i--;//reduce i
			$currentPath = $lookupPaths[$i] . '/' . $name . '.php';
			if (file_exists($root . $currentPath))
				return $currentPath;
		}
		return null;
	}


	/**
	 * Render a given page with given pre_render and post_render pages along with scoped data.
	 *
	 * @param string $title Title of page
	 * @param string $page Path of page. if VIEW_ROOT is set it is prefixed.
	 * @param array $data
	 */
	protected function render($title, $page, $data = array())
	{
		$data['title'] = $title;
		$data = array_merge($this->SCOPE_DATA, $data);

		foreach ($this->PRE_RENDER as $pre)
			$this->load->view($pre, $data);

		// viewPath we can find.
		$viewPath = $this->lookForView($page);

		//if view root is set prefix it.
		$this->load->view(($viewPath == null ? $page : $viewPath), $data);

		foreach ($this->POST_RENDER as $post)
			$this->load->view($post, $data);
	}

	/**
	 * Set header and footer by using pre and post render, Just a fancy wrapper.
	 * @param $header
	 * @param $footer
	 */
	protected function setHeaderFooter($header, $footer)
	{
		$this->PRE_RENDER = array($header);
		$this->POST_RENDER = array($footer);
	}


	/**
	 * Send JSON response to user.
	 * @param $data
	 * @param bool $top
	 */
	public function sendJSON($data, $top = false)
	{
		if ($top == false)
			$data = ['data' => $data];

		header('Content-Type: application/json');
		echo json_encode($data);
	}


	protected function isSuperUser()
	{
		if (!$this->Session->isLoggedin())
			return false;

		return $this->Session->getLoggedDetails()['type'] == USER_ADMIN;
	}

	protected function getLoggedUsername()
	{
		return $this->Session->getLoggedUsername();
	}

	protected function requireSuperUser()
	{

		if (!$this->isSuperUser()) {
			unauthorized();
			//Warning: Stop the execution, don't use this method in other places.
			die();
		}
		return true;
	}


}


class MY_Tabler extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * Tabler Handler.
	 *
	 * DONOT Modify unless required.
	 *
	 * @param $model
	 * @param $name
	 * @param $context
	 * @param $ui_filter
	 * @param $filters
	 * @param $more_response
	 */
	protected function handler($model, $name, $context, $ui_filter, $filters, $more_response)
	{

		if(is_array($model))
			return $this->sendClientData($model,$ui_filter,null,null,$more_response);
		$options = $_REQUEST;
		$options['filters'] = $filters;
		$dt = $model->getDataTable($options);
		if (isset($_GET['draw']) || isset($_POST['draw'])) { //if datatable request.
			$context = array_merge(array('action' => $name,
				'type' => $this->Session->getUserType(),
				'uid' => $this->getLoggedUsername(),
				'username' => $this->getLoggedUsername(),
			), $context);

			return parent::sendJSON($dt->getDataTableData($context, $options), false);
		} else {

			return $this->returnFilterView($dt, $ui_filter,$context,$options, $more_response);
		}
	}


	private function returnFilterView($dt, $ui_filter, $context, $options, $more_response)
	{
		$processedUIFilters = $dt->getUIFilters($context, $options, $ui_filter);
		return parent::sendJSON(
			array_merge($more_response, array('filters' => $processedUIFilters))
		);
	}

	private function sendClientData($tableData, $ui_filter, $context, $options, $more_response)
	{
		return parent::sendJSON(
			array_merge($more_response, array(
				'filters' => $ui_filter,
				'tableData' => $tableData,
			))
		);
	}

	public function get_session($key){
        if(empty($key))
            return false;
        return $this->session->userdata($key);
    }


}
