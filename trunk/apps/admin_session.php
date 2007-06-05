<?

// define current working directory
define ("APPS_ROOT", dirname(__FILE__));
//define ("ENFORCE_SECURITY_LEVELS", false);

// set error reporting level globally
error_reporting(E_ALL);
//error_reporting(E_WARNING | E_ERROR);

// initialize sessions normally
session_start ();

// you may want to customize these includes
require_once(APPS_ROOT."/local_settings.php");
require_once(APPS_ROOT."/db/db_connection.php");
require_once(APPS_ROOT."/db/db_table.php");
require_once(APPS_ROOT."/db/db_mysql.php");
require_once(APPS_ROOT."/db/db_sql_utility.php");
require_once(APPS_ROOT."/db/db_vsql_utility.php");

$db =& new db_connection();

// consider including global authorization code here
require_once(APPS_ROOT.'/global/global.php');

?>