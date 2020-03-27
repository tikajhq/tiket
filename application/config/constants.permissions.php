<?PHP
/**
 * Before each permission, please elaborate by one line hashed comment
 * not less not more, this will be used to generate documentation.
 * - Multiple of 1000 will always be considered as module.
 */
# Ranges defined
# 1k : Core
# 2k : Notification/Storage/Payment
# 3k : Users/Auth
# 4k : Tiket
# 5k : Reserved
# 6k : Reserved
# 7k : Reserved
# 8k : Reserved
# 9k : Reserved
# 10k : Reserved
# 11k : Loan
# 12k : MultiLevel

# START OF DYNAMIC CONFIG # DONOT REMOVE OR CHANGE THIS LINE

#
# Users
#

# MODULE: User module range.
define('PERMISSION_USER', 3000);
# Can add a user
define('PERMISSION_USER_REGISTER', 3001);
# Can list all users
define('PERMISSION_USER_LIST', 3002);
# Can delete a user
define('PERMISSION_USER_DELETE', 3003);
# Can update user profile
define('PERMISSION_USER_UPDATE', 3004);
# Can see user dashboard
define('PERMISSION_USER_DASHBOARD', 3005);
# Can register from public
define('PERMISSION_AUTH_REGISTER', 3006);
# Can login using login form
define('PERMISSION_AUTH_LOGIN', 3007);


# sms send permission
define('PERMISSION_SMS_SEND', 11001);
# send sms view list permission
define('PERMISSION_SMS_VIEW', 11002);
# View permission for pending KYC
define('PERMISSION_PENDING_KYC', 11003);
# View permission for approved KYC
define('PERMISSION_APPROVED_KYC', 11004);

# Add Loan permission
define('PERMISSION_LOAN_ADD', 11005);
# All Loan View
define('PERMISSION_LOAN_VIEW_ALL', 11006);
# View Transestoins
define('PERMISSION_LOAN_VIEW_TXN', 11007);
# view running loan accounts
define('PERMISSION_LOAN_VIEW_RUNNING', 11008);
# view outstanding loan
define('PERMISSION_LOAN_VIEW_OUTSTANDING', 11009);
# view overdue loan
define('PERMISSION_LOAN_VIEW_OVERDUE', 11010);
# view transestions by payment mode
define('PERMISSION_LOAN_MODE_TXN', 11011);

// Domation


# END OF DYNAMIC CONFIG # DONOT REMOVE OR CHANGE THIS LINE

/**
 * This can be moved to client.config
 */

// Define different users and their numeric identifiers.
# Public user, it should be present in all cases, this refers to
define("USER_PUBLIC", 0);
# Limited user for donation mudule to donate
define("USER_LIMITED", 5);
# Deactivated user for donation mudule when he completes his 7 activate members
define("USER_DEACTIVATED", 6);
# Any normal user
define("USER_MEMBER", 10);
# Members of Resolution Team/Developer/Agent
define("USER_AGENT", 60);
# Managerial person
define("USER_MANAGER", 80);
# User with elevated permissions.
define("USER_ADMIN", 100);

define('USER_TYPE_LIMITED',5);


/**
 * Array of all user permissions.
 */
define("DEFAULT_PERMISSIONS_USERS", array(
			USER_PUBLIC => array(
				PERMISSION_AUTH_REGISTER => true,
				PERMISSION_AUTH_LOGIN => true,
			),

			USER_TYPE_LIMITED => array(
				PERMISSION_AUTH_LOGIN => true,
				PERMISSION_AUTH_REGISTER=> false,
				PERMISSION_USER_UPDATE => false,
			),
	
			USER_MEMBER => array(
				PERMISSION_USER_UPDATE => true,
				PERMISSION_AUTH_REGISTER => true,
				PERMISSION_USER_DASHBOARD => true,
				PERMISSION_AUTH_LOGIN => true
			),
			USER_AGENT => array(
				PERMISSION_USER_UPDATE => true,
				PERMISSION_AUTH_REGISTER => true,
				PERMISSION_USER_DASHBOARD => true,
				PERMISSION_AUTH_LOGIN => true
			),
			USER_MANAGER => array(
				PERMISSION_USER_REGISTER => true,
				PERMISSION_USER_LIST => true,
				PERMISSION_USER_UPDATE => true,
				PERMISSION_AUTH_LOGIN => true,
				PERMISSION_AUTH_REGISTER => true,
			),
			USER_ADMIN => array(
				PERMISSION_USER_REGISTER => true,
				PERMISSION_USER_LIST => true,
				PERMISSION_USER_UPDATE => true,
				PERMISSION_AUTH_LOGIN => true,
				PERMISSION_AUTH_REGISTER => true,
				PERMISSION_SMS_SEND => true,
				PERMISSION_SMS_VIEW => true,
				PERMISSION_PENDING_KYC => true,
				PERMISSION_APPROVED_KYC => false,
			),
			USER_DEACTIVATED => array(
				PERMISSION_AUTH_LOGIN => true,
				PERMISSION_AUTH_REGISTER=> false,
				PERMISSION_USER_DASHBOARD => false
			)
		)
	);
