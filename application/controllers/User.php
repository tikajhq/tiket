<?php

class User extends MY_Controller
{
    function __construct()
	{
		parent::__construct();
		parent::requireLogin();
		$this->setHeaderFooter('global/header.php', 'global/footer.php');
		$this->load->model('core/Session_model', 'Session');
		$this->load->model('ticket/Threads_model', 'Tickets');
		$this->load->model('user/User_model', 'Users');
	}

	public function dashboard()
	{
		$data['title'] = 'Dashboard';
		$role = (int)($this->Session->getUserType());
		
		if($role == USER_MEMBER)
			$this->dashboard_member();
		else if($role == USER_AGENT)
			$this->dashboard_agent();
		else if($role == USER_MANAGER)
			$this->dashboard_manager();
		else if($role == USER_ADMIN)
			$this->dashboard_manager();
	}

	public function dashboard_member()
	{
		$agent_id = $this->Session->getLoggedDetails()['username'];
		$data['stats']['total_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id)));
		$data['stats']['open_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id, 'status' => TICKET_STATUS_OPEN)));
		$data['stats']['assigned_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id, 'status' => TICKET_STATUS_ASSIGNED)));
		$data['stats']['closed_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id, 'status' => TICKET_STATUS_CLOSED)));
		$data['recent']['created'] = $this->Tickets->get_ticket_where_limit(array('owner' => $agent_id), 5);
		$data['recent']['assigned'] = $this->Tickets->get_ticket_where_limit(array('assign_to' => $agent_id, 'status' => TICKET_STATUS_ASSIGNED), 5);
		$data['recent']['closed'] = $this->Tickets->get_ticket_where_limit(array('owner' => $agent_id, 'status' => TICKET_STATUS_CLOSED), 5);
		$this->render('Dashboard', 'user/dashboard_user', $data);
	}

	public function dashboard_agent()
	{
		$agent_id = $this->Session->getLoggedDetails()['username'];
		$data['stats']['total_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id)));
		$data['stats']['open_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id, 'status' => TICKET_STATUS_OPEN)));
		$data['stats']['assigned_tickets'] = count($this->Tickets->get_ticket_where(array('status' => TICKET_STATUS_ASSIGNED)));
		$data['stats']['closed_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id, 'status' => TICKET_STATUS_CLOSED)));
		$data['recent']['created'] = $this->Tickets->get_ticket_where_limit(array('owner' => $agent_id), 5);
		$data['recent']['assigned'] = $this->Tickets->get_ticket_where_limit(array('assign_to' => $agent_id, 'status' => TICKET_STATUS_ASSIGNED), 5);
		$data['recent']['closed'] = $this->Tickets->get_ticket_where_limit(array('owner' => $agent_id, 'status' => TICKET_STATUS_CLOSED), 5);
		$this->render('Dashboard', 'user/dashboard', $data);
	}

	public function dashboard_manager()
	{
		$data['stats']['total_tickets'] = count($this->Tickets->getBy(null,array()));
		$data['stats']['open_tickets'] = count($this->Tickets->getBy(null,array('status' => TICKET_STATUS_OPEN)));
		$data['stats']['assigned_tickets'] = count($this->Tickets->getBy(null,array('status' => TICKET_STATUS_ASSIGNED)));
		$data['stats']['closed_tickets'] = count($this->Tickets->getBy(null,array('status' => TICKET_STATUS_CLOSED)));

		$data['stats']['total_users'] = count($this->Users->getBy(null,array('type' => USER_MEMBER)));
		$data['stats']['total_agents'] = count($this->Users->getBy(null, array('type' => USER_AGENT)));
		$data['stats']['total_manager'] = count($this->Users->getBy(null, array('type' => USER_MANAGER)));

		$data['stats']['count_by_priority']['high'] = array(count($this->Tickets->getBy(null,array('priority'=>TICKET_PRIORITY_HIGH, 'status' => TICKET_STATUS_OPEN))),
		count($this->Tickets->getBy(null,array('priority'=>TICKET_PRIORITY_HIGH, 'status' => TICKET_STATUS_ASSIGNED))),
		count($this->Tickets->getBy(null,array('priority'=>TICKET_PRIORITY_HIGH, 'status' => TICKET_STATUS_CLOSED))));

		$data['stats']['count_by_priority']['medium'] = array(count($this->Tickets->getBy(null,array('priority'=>TICKET_PRIORITY_MEDIUM, 'status' => TICKET_STATUS_OPEN))),
		count($this->Tickets->getBy(null,array('priority'=>TICKET_PRIORITY_MEDIUM, 'status' => TICKET_STATUS_ASSIGNED))),
		count($this->Tickets->getBy(null,array('priority'=>TICKET_PRIORITY_MEDIUM, 'status' => TICKET_STATUS_CLOSED))));

		$data['stats']['count_by_priority']['low'] = array(count($this->Tickets->getBy(null,array('priority'=>TICKET_PRIORITY_LOW, 'status' => TICKET_STATUS_OPEN))),
		count($this->Tickets->getBy(null,array('priority'=>TICKET_PRIORITY_LOW, 'status' => TICKET_STATUS_ASSIGNED))),
		count($this->Tickets->getBy(null,array('priority'=>TICKET_PRIORITY_LOW, 'status' => TICKET_STATUS_CLOSED))));

		$data['stats']['count_by_severity']['high'] = array(count($this->Tickets->getBy(null,array('severity'=>TICKET_SEVERITY_HIGH, 'status' => TICKET_STATUS_OPEN))),
		count($this->Tickets->getBy(null,array('severity'=>TICKET_SEVERITY_HIGH, 'status' => TICKET_STATUS_ASSIGNED))),
		count($this->Tickets->getBy(null,array('severity'=>TICKET_SEVERITY_HIGH, 'status' => TICKET_STATUS_CLOSED))));

		$data['stats']['count_by_severity']['medium'] = array(count($this->Tickets->getBy(null,array('severity'=>TICKET_SEVERITY_MEDIUM, 'status' => TICKET_STATUS_OPEN))),
		count($this->Tickets->getBy(null,array('severity'=>TICKET_SEVERITY_MEDIUM, 'status' => TICKET_STATUS_ASSIGNED))),
		count($this->Tickets->getBy(null,array('severity'=>TICKET_SEVERITY_MEDIUM, 'status' => TICKET_STATUS_CLOSED))));

		$data['stats']['count_by_severity']['low'] = array(count($this->Tickets->getBy(null,array('severity'=>TICKET_SEVERITY_LOW, 'status' => TICKET_STATUS_OPEN))),
		count($this->Tickets->getBy(null,array('severity'=>TICKET_SEVERITY_LOW, 'status' => TICKET_STATUS_ASSIGNED))),
		count($this->Tickets->getBy(null,array('severity'=>TICKET_SEVERITY_LOW, 'status' => TICKET_STATUS_CLOSED))));


		$data['recent']['created'] = $this->Tickets->getBy(null,array(), 5);
		$data['recent']['open'] = $this->Tickets->getBy(null,array('status' => TICKET_STATUS_OPEN), 5);
		$data['recent']['assigned'] = $this->Tickets->getBy(null,array('status' => TICKET_STATUS_ASSIGNED), 5);
		$data['recent']['closed'] = $this->Tickets->getBy(null,array('status' => TICKET_STATUS_CLOSED), 5);
		$this->render('Dashboard', 'user/dashboard_manager', $data);
	}

	// public function dashboard_admin()
	// {
	// 	$agent_id = $this->Session->getLoggedDetails()['username'];
	// 	$data['stats']['total_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id)));
	// 	$data['stats']['open_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id, 'status' => TICKET_STATUS_OPEN)));
	// 	$data['stats']['assigned_tickets'] = count($this->Tickets->get_ticket_where(array('status' => TICKET_STATUS_ASSIGNED)));
	// 	$data['stats']['closed_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id, 'status' => TICKET_STATUS_CLOSED)));
	// 	$data['recent']['created'] = $this->Tickets->get_ticket_where_limit(array('owner' => $agent_id), 5);
	// 	$data['recent']['assigned'] = $this->Tickets->get_ticket_where_limit(array('assign_to' => $agent_id, 'status' => TICKET_STATUS_ASSIGNED), 5);
	// 	$data['recent']['closed'] = $this->Tickets->get_ticket_where_limit(array('owner' => $agent_id, 'status' => TICKET_STATUS_CLOSED), 5);
	// 	$this->render('Dashboard', 'user/dashboard', $data);
	// }

	public function profile()
	{
		$username = $this->Session->getLoggedDetails()['username'];
		$data['user_details'] = $this->Users->getUserBy(array('username' => $username));
		$this->render('Profile', 'user/profile', $data);
	}

	
	public function change_password()
	{
		$data[] = '';
		$this->render('Change password', 'user/change_password', $data);
	}

	public function profile_update()
	{
		$username = $this->Session->getLoggedDetails()['username'];
		$data['user_details'] = $this->Users->getUserBy(array('username' => $username));
		$this->render('Profile', 'user/profile_update', $data);
	}

	public function list()
	{
		$role = $this->Session->getLoggedDetails()['type'];
		$filter = ['type <=' => $role];
		$data['user_list'] = $this->Users->getBy(null, $filter);
		$this->render('All Users', 'user/list', $data);
	}

	public function add_user()
	{
		$this->render('Add Users', 'user/add_user');
	}

// End of Class
}