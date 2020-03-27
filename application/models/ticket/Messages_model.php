<?php

class Messages_model extends BaseMySQL_model
{
    function __construct()
    {
        parent::__construct(TABLE_MESSAGES);
    }


    public function get_messages_by($where)
    {
        $this->db->select(
            TABLE_MESSAGES . '.id as id, '
            . TABLE_MESSAGES . '.ticket as ticket, '
            . TABLE_MESSAGES . '.message as message, '
            . TABLE_MESSAGES . '.created as created, '
            . 'user.name as user_name, '
        );

        foreach ($where as $col => $val)
            $this->db->where(TABLE_MESSAGES . '.' . $col, $val);

        return $this->db->join(TABLE_USERS . ' as user', 'user.id = ' . TABLE_MESSAGES . '.user', 'left')
            ->order_by(TABLE_MESSAGES . '.id', 'desc')
            ->get(TABLE_MESSAGES)->result_array();
    }


    public function makeDatatableQuery($table, $context, $db, $arguments = null)
    {
//        $db->join(TABLE_USERS . ' as user1', 'user1.id = ' . TABLE_TICKETS . '.assign_to', 'left');
//        $db->join(TABLE_USERS . ' as user2', 'user2.id = ' . TABLE_TICKETS . '.owner', 'left');
//        return array(
//            'columns' => array(
//                'id' => TABLE_TICKETS . ".id",
//                'ticket_no' => TABLE_TICKETS . ".ticket_no",
//                'owner' => TABLE_TICKETS . '.owner',
//                'severity' => TABLE_TICKETS . '.severity',
//                'created' => TABLE_TICKETS . '.created',
//                'purpose' => TABLE_TICKETS . '.purpose',
//                'subject' => TABLE_TICKETS . '.subject',
//                'message' => TABLE_TICKETS . '.message',
//                'file' => TABLE_TICKETS . '.file',
//                'status' => TABLE_TICKETS . '.status',
//                'assign_to' => TABLE_TICKETS . '.assign_to',
//                'assign_to_name' => 'user1.name',
//                'owner_name' => 'user2.name',
//                'assign_on' => TABLE_TICKETS . '.assign_on',
//                'progress' => TABLE_TICKETS . '.progress',
//                'updated' => TABLE_TICKETS . '.updated',
//                'closed' => TABLE_TICKETS . '.closed',
//            ),
//        );
    }

}