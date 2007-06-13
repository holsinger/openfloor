<?

/************************************************************
  This class functions as logger.  Its intended uses are
  error tracking and event tracking.  The log is stored
  in a flat file with delimited values and a new line
  at the end of each record.  While this class uses the PHP
  error_log function it is not limited to logging errors.
  This object is extended by the following objects:
    -db_utility.app	(where utility references an RDBMS)
      -sql_utility.app
      -table.app	(where table is a specific table)
    -db_connection.app
    -exceptions.app
  Copyright (C)
  Daniel Watrous
  Maintain Fit Development Group
  Dec 2003
  ************************************************************/

// this constant is used to send an e-mail to the address
// given as its value for critical errors
//define ("ADMIN_EMAIL", "james@engeb.com");
//define ("LOG_FILE", "/var/www/logs/php_app_log");

// this is to set $php_errormsg on errors
$error_tracking = ini_set("track_errors","1");
if ($error_tracking===false || $error_tracking===null) {
  //prepare available values
  $status["location"] = "sys_log.app";
  $status["exception_type"] = "track errors";
  $status["error"] = "failed to set php.ini flag to track_errors=1";

  //log and then halt
  exceptions::halt($status);
}

class sys_log {

  //*****  member variables
  var $date = "";	//private
  var $location = "";	//private
  var $info_array = array ();	//protected
  var $message = "";	//protected
  var $error = "";	//protected
  var $errno = "";	//protected

  //*****  class constructor
  //private
  //needs to be explicitly called from extending function
  function sys_log () {
    $this->location = $_SERVER["REQUEST_METHOD"].": ".$_SERVER["SCRIPT_FILENAME"];
    date_default_timezone_set('America/Denver');
    $this->date = date("r");
    if ($this->error) $info_array["error"] = $this->error;
    if ($this->errno) $info_array["errno"] = $this->errno;
  }

  //*****  set methods
  //public function void set_message (string $msg)
  function set_message ($msg) {
    $this->message = $msg;
  }

  //public function void set_info_array (array $info)
  //$info array is associative e.g. $info = array("name"=>"value",...)
  function set_info_array ($info) {
    if (is_array($info)) {
      $this->info_array = array_merge($this->info_array, $info);
    } else {
      $this->set_message ("Value passed to set_info_array () is not an array");
      $this->create_log ();
    }
  }

  //protected function void set_error (string $error)
  function set_error ($error) {
    $this->error = $error;
  }

  //protected function void set_errno (string $errno)
  function set_errno ($errno) {
    $this->errno = $errno;
  }

  //*****  int log (string $email=null)
  // protected
  // log will write a new log entry to the file specified in LOG_FILE
  // optionally if an e-mail address is provided a log message will also be sent to
  // address given by $email
  function log ($email=null) {
    return sys_log::create_log($this->create_log_entry(),$email);
  }

  //*****  string create_log_entry ()
  // protected
  // create_log_entry will return a new log entry
  function create_log_entry ($email=null) {

    //actual log entry is stored here
    $log_entry = "";

    //variables used to cycle prepare array information for $log_entry
    $info_log_prepared = "";
    $count = 0;

    //determine if log was successful
    $log_result = false;

    //prepare values in info_array for $log_entry
    if (count($this->info_array)>0) {
      reset($this->info_array);
      do {
        if ($count>0) $info_log_prepared .= "&";
        $info_log_prepared .= key($this->info_array)."=".$this->info_array[key($this->info_array)];
        $count++;
      } while (next($this->info_array));
    }

    $log_entry = "[".$this->date."] \"".$this->message."\" [".$this->location."] [".$info_log_prepared."]\n";
    if ($this->debug_level>0) printf("\nLOG_ENTRY: %s <br>\n",$log_entry);
    return $log_entry;
  }

  //*****  int create_log (string $log_entry, string $email=null)
  // static
  // create_log will write a new log entry to the file specified in LOG_FILE
  // optionally if an e-mail address is provided a log message will also be sent to
  // address given by $email
  function create_log ($log_entry,$email=null) {

    $log_result = error_log ($log_entry, 3, LOG_FILE);
    if (!$log_result || $email!=null) {
      if (!$log_result) $log_entry.="Log failed!\nPlease check the application hosted on ".$_SERVER["SERVER_NAME"].".\n";
      $log_result = error_log ($log_entry, 1, $email);
    }
    if ($this->debug_level>0) printf("\nLOG_RESULT: %s <br>\n",$log_result);
    return $log_result;
  }
}

?>
