<?PHP
define("TABLE_TOKENS", TABLE_PREFIX . "tokens");
define('TABLE_USERR', TABLE_PREFIX . 'users');
define("TABLE_TEMPLATES", TABLE_PREFIX . "templates");
define("TABLE_SESSIONS", TABLE_PREFIX . "sessions");


define("TOKEN_ACTIVE", 1);
define("TOKEN_INACTIVE", 0); // new for token status inactive
define("TEMPLATE_LANG", 'en');

//Prefix of keys when using session class
define("SESSION_KEY_PREFIX", TABLE_PREFIX . "sessions");
define('TOKEN_STATUS_ACTIVE' ,1);
define('TOKEN_STATUS_DEACTIVATE' ,0);
define('TOKEN_TYPE_PIN', 1);