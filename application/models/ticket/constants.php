<?PHP

define("TABLE_TICKETS", TABLE_PREFIX."tickets");
define("TABLE_MESSAGES", TABLE_PREFIX."messages");
define("TABLE_USERS", TABLE_PREFIX."users");
define("TICKET_PREFIX", "TIK");
define('TICKET_STATUS_OPEN', 0);
define('TICKET_STATUS_ASSIGNED', 50);
define('TICKET_STATUS_CLOSED', 100);
define('TICKET_PRIORITY_HIGH', 10);
define('TICKET_PRIORITY_MEDIUM', 5);
define('TICKET_PRIORITY_LOW', 0);
define('TICKET_SEVERITY_HIGH', 10);
define('TICKET_SEVERITY_MEDIUM', 5);
define('TICKET_SEVERITY_LOW', 0);

define('STATUS_MAP', array(
    TICKET_STATUS_OPEN          => '<div class="badge badge-corner bg-green">Open</div>',
    TICKET_STATUS_ASSIGNED      => '<div class="badge badge-corner bg-info">Assigned</div>',
    TICKET_STATUS_CLOSED        => '<div class="badge badge-corner bg-red">Closed</div>'
));

define('TICKET_STATUS', array(
    array('value'=>0, 'label'=> 'Open'),
    array('value'=>100, 'label' => 'Close')
));

define('TICKET_CATEGORIES', array(
    'Bug', 'Feature requests', 'Software Troubleshooting', 'How to', 'Password Reset', 'Network', 'Hardware', 'Access and Authorization'
));

define('TICKET_PRIORITIES', array(
    array('value' => 0, 'label'=> 'Low'),
    array('value' => 5, 'label'=> 'Medium'),
    array('value' => 10, 'label'=> 'High')
));

define('TICKET_SEVERITIES', array(
    array('value' => 0, 'label'=> 'Low'),
    array('value' => 5, 'label'=> 'Medium'),
    array('value' => 10, 'label'=> 'High')
));
