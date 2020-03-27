<?PHP

class Tabler extends MY_Tabler
{


    public function __construct()
    {
        parent::__construct();
       parent::requireLogin();
       $this->load->model('code/Session_model', 'Session');
    }


    public function list_my_tickets()
    {
        $this->load->model('ticket/Ticket_model', 'Tickets');
        $filter = array();
        $username = $this->Session->getLoggedDetails()['username'];
        // if (isset($_GET['username']) && $_GET['username'])
		// 	$filter['owner'] = $_GET['username'];

        if(!in_array((int)$this->Session->getLoggedDetails()['type'], array(USER_MANAGER, USER_ADMIN, USER_AGENT)))
            $filter['owner'] = $username;
        
        if(isset($_GET['type'])&& $_GET['type']){
            $type = $_GET['type'];
            if($type=="my_tickets")
                $filter['owner'] = $username;
            else if($type=="assigned_to_me")
                $filter['assign_to'] =  $username;
            else if($type=="cc_to_me")
                $filter['cc LIKE'] = '%'.$username.'%';
            else if($type=="assigned")
                $filter['status'] = TICKET_STATUS_ASSIGNED;
            else if($type=="unassigned")
                $filter['status'] = TICKET_STATUS_OPEN;
            else if($type=="closed")
                $filter['status'] = TICKET_STATUS_CLOSED;
        }



        return $this->handler($this->Tickets, __FUNCTION__, array(), array(
            "assign_to" => [
				"title" => "Assigned To",
                "type" => "string"
            ],
            "status" => [
                "title" => "Status",
                "type" => "string",
                "enum" => array(
                    "Open"=>0,
                    "In-Progress"=>50,
                    "Closed" =>100
                )

                ],
            "priority" => [
				"title" => "Priority",
                "type" => "string",
                "enum" => array(
					"High"=>10,
                    "Medium"=>5,
                    "Low" =>0
				)

                ],
                "severity" => [
                    "title" => "Severity",
                    "type" => "string",
                    "enum" => array(
                        "High"=>10,
                        "Medium"=>5,
                        "Low" =>0
                    )
    
                    ],
                "category" => [
                    "title" => "Category",
                    "type" => "string",
                    "enum" => array_flip(TICKET_CATEGORIES)
                ]

        ),$filter, array(
        ));
    }

    public function list_users()
    {
        $this->load->model('user/User_model', 'Users');
        return $this->handler($this->Users, __FUNCTION__, array(), array(), array(), array(
        ));
    }

}
