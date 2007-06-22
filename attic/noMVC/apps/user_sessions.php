<?

// define current working directory
define ("APPS_ROOT", dirname(__FILE__));
//define ("ENFORCE_SECURITY_LEVELS", false);

// set error reporting level globally
error_reporting(E_WARNING | E_ERROR);

// initialize sessions normally
$first_visit = false;
if (!isset($_COOKIE['PHPSESSID']))
	$first_visit = true;

session_start ();

// you may want to customize these includes
require_once(APPS_ROOT."/local_settings.php");
require_once(APPS_ROOT."/db/db_connection.php");
require_once(APPS_ROOT."/db/db_mysql.php");
require_once(APPS_ROOT.'/dbfunctions.php');
require_once(APPS_ROOT.'/htmlfunctions.php');
require_once(APPS_ROOT.'/Guid.php');
require_once(APPS_ROOT.'/Visit.php');
require_once(APPS_ROOT.'/Zip.php');

$db = new db_connection();
//special apps
require_once(APPS_ROOT."/api_data.php");
require_once(APPS_ROOT.'/global/global.php');


// consider including global authorization code here