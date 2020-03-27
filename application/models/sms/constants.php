<?php
/**
 * Created by IntelliJ IDEA.
 * User: dee
 * Date: 10/5/19
 * Time: 3:32 PM
 */

define("TABLE_USERS", TABLE_PREFIX . "users");
define("TABLE_SMS", TABLE_PREFIX . "sms_track");
define("SMS_QUEUED", 0);
define("SMS_SENT", 1);
define("SMS_NOT_SCHEDULED", 0);
define("SMS_SCHEDULED_CANCELLED", 2);
define("SMS_CONFIG_FROM", 'JBINHI');
define("SMS_CONFIG_TOKEN", '');
define("SMS_TEMPLATE_USER_WELCOME", "Dear {{name}}, \r\nThank you for registering with ".CLIENT_FULL_NAME.".\r\n\r\nYour username is {{username}} and password is  {{password}}.\r\n\r\nLogin at:\r\n". BASE_URL);