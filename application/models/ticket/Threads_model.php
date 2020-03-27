<?php
require_once __DIR__ . "/constants.php";

class Threads_model extends BaseMySQL_model
{
    function __construct()
    {
        parent::__construct(TABLE_TICKETS);
    }

    public function get_ticket_list($where)
    {
        $this->db->select(
            TABLE_TICKETS . '.id as id, '
            . TABLE_TICKETS . '.ticket_no as ticket_no, '
            . TABLE_TICKETS . '.owner as owner, '
            . TABLE_TICKETS . '.severity as severity, '
            . TABLE_TICKETS . '.created as created, '
            . TABLE_TICKETS . '.purpose as purpose, '
            . TABLE_TICKETS . '.subject as subject, '
            . TABLE_TICKETS . '.message as message, '
            . TABLE_TICKETS . '.file as file, '
            . TABLE_TICKETS . '.status as status, '
            . TABLE_TICKETS . '.assign_to as assign_to, '
            . 'user1.name as assign_to_name,'
            . 'user2.name as owner_name,'
            . TABLE_TICKETS . '.assign_on as assign_on, '
            . TABLE_TICKETS . '.progress as progress, '
            . TABLE_TICKETS . '.updated as updated, '
            . TABLE_TICKETS . '.closed as closed, '
        );

        foreach ($where as $key => $value)
            $this->db->where(TABLE_TICKETS . "." . $key, $value);

        return $this->db->join(TABLE_USERS . ' as user1', 'user1.id = ' . TABLE_TICKETS . '.assign_to', 'left')
            ->join(TABLE_USERS . ' as user2', 'user2.id = ' . TABLE_TICKETS . '.owner', 'left')
            ->get(TABLE_TICKETS)->result_array();
    }

    public function get_ticket_details($ticket_id)
    {
        return $this->get_ticket_list(array("ticket_no" => $ticket_id));
    }

    public function get_ticket_threads($ticket_id)
    {
        return $this->db->select(
            TABLE_MESSAGES . '.id as id, '
            . TABLE_MESSAGES . '.ticket as ticket, '
            . TABLE_MESSAGES . '.message as message, '
            . TABLE_MESSAGES . '.created as created, '
            . 'user.name as user_name, '
        )
            ->where(TABLE_MESSAGES . '.ticket', $ticket_id)
            ->join(TABLE_USERS . ' as user', 'user.id = ' . TABLE_MESSAGES . '.user', 'left')
            ->order_by(TABLE_MESSAGES . '.id', 'desc')
            ->get(TABLE_MESSAGES)->result_array();
    }

    // generic function to list ticket by where condition => $where is array;
    public function get_ticket_where($where)
    {
        return $this->db->where($where)
            ->get(TABLE_TICKETS)->result_array();
    }

    public function get_ticket_where_limit($where, $limit)
    {
        return $this->db->where($where)->limit($limit)->order_by('id', 'desc')->get(TABLE_TICKETS)->result_array();
    }

    public function close_ticket($ticket)
    {
        $update = [
            'status' => TICKET_STATUS_CLOSED,
            'closed' => time()
        ];
        return $this->db->where('ticket_no', $ticket)->update(TABLE_TICKETS, $update);
    }

    public function update_ticket($where, $update)
    {
        return $this->db->where($where)->update(TABLE_TICKETS, $update);
    }

    public function add_thread($array)
    {
        return $this->db->insert(TABLE_MESSAGES, $array);
    }


    public function makeDatatableQuery($table, $context, $db, $arguments = null)
    {
        $db->join(TABLE_USERS . ' as user1', 'user1.id = ' . TABLE_TICKETS . '.assign_to', 'left');
        $db->join(TABLE_USERS . ' as user2', 'user2.id = ' . TABLE_TICKETS . '.owner', 'left');
        return array(
            'columns' => array(
                'id' => TABLE_TICKETS . ".id",
                'ticket_no' => TABLE_TICKETS . ".ticket_no",
                'owner' => TABLE_TICKETS . '.owner',
                'severity' => TABLE_TICKETS . '.severity',
                'created' => TABLE_TICKETS . '.created',
                'purpose' => TABLE_TICKETS . '.purpose',
                'subject' => TABLE_TICKETS . '.subject',
                'message' => TABLE_TICKETS . '.message',
                'file' => TABLE_TICKETS . '.file',
                'status' => TABLE_TICKETS . '.status',
                'assign_to' => TABLE_TICKETS . '.assign_to',
                'assign_to_name' => 'user1.name',
                'owner_name' => 'user2.name',
                'assign_on' => TABLE_TICKETS . '.assign_on',
                'progress' => TABLE_TICKETS . '.progress',
                'updated' => TABLE_TICKETS . '.updated',
                'closed' => TABLE_TICKETS . '.closed',
            ),
        );
    }

// End of class
}