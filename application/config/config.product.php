<?PHP
//Developer Information
//All product and developer related information.
define('DEV_COMPANY_NAME', 'TIKAJ');
define('DEV_COMPANY_EMAIL', 'hello@tikaj.com');
define('DEV_COMPANY_PHONE', '8881686666');
define('DEV_COMPANY_SUPPORT_EMAIL', 'support@tikaj.com');
define('DEV_COMPANY_URL', 'http://www.tikaj.com');
define('DEV_COMPANY_LOGO', 'assets/img/logo.png');

/**
 * Product related information
 */
define('PRODUCT_NAME', 'TIKAJ HELPDESK');
define('PRODUCT_LOGO', 'assets/img/product-logo.png');



/**
 * Global Settings
 */
# Products global settings
define('SETTING_UPLOAD_DIR', '/uploads/');
define('SETTING_UPLOAD_PATH', FCPATH."/uploads/");
define('SETTING_PROFILE_DIR', '/uploads/profiles/');
define('SETTING_PROFILE_PATH', FCPATH.SETTING_PROFILE_DIR);



/**
 * Dynamic Constants
 */
define('BRAND_NAME', '<span style="color: #FFF;">' . CLIENT_FNAME . '  </span><span class="text-danger">' . CLIENT_MNAME . ' </span>');
define('CLIENT_NAME', CLIENT_FNAME . ' ' . CLIENT_MNAME);
define('CLIENT_LOGO', SETTING_UPLOAD_DIR . '/logo.png');
define('CLIENT_LOGO_INVERSE', SETTING_UPLOAD_DIR . '/logo-inverse.png');


/**
 * URL's
 */
define('URL_PREFIX', BASE_URL . "index.php");
define('URL_LANDING', URL_PREFIX . '/auth/login');
define('URL_UNAUTHORIZED', URL_PREFIX . '/auth/login');
define('URL_NO_PERMISSION', URL_PREFIX . '/auth/unauthorized');
define('URL_ERROR', URL_PREFIX . '/auth/error');
define('URL_LOGIN', URL_PREFIX . '/auth/login');
define('URL_POST_LOGIN_USER', URL_PREFIX . '/user/dashboard');
define('URL_POST_LOGIN_AGENT', URL_PREFIX . '/user/dashboard');
define('URL_POST_LOGIN_MANAGER', URL_PREFIX . '/user/dashboard');
define('URL_POST_LOGIN_ADMIN', URL_PREFIX. '/user/dashboard');
define('URL_POST_LOGIN_LIMITED', URL_PREFIX . '/user/dashboard');
define('URL_POST_LOGIN_DEACTIVATED', URL_PREFIX . '/deactivated/dashboard');

define('URL_REGISTER', URL_PREFIX . '/auth/register');
define('URL_PAYMENT_DONE', URL_PREFIX . '/payment/done');


define("STATUS_ACTIVE", 1);
define("STATUS_INACTIVE", 0);
define('STATUS_DEACTIVATED', -1);


define('CLIENT_ADMIN_PAYTM_NUMBER', 9999999999);
define('CLIENT_ADMIN_UPI', 'username@upi');

define('DISABLE_POWERED_BY', true);
