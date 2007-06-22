<?

/************************************************************
  This class functions as an exception handling tool with
  member variables and member functions built specifically
  to manage exceptions and errors for the following objects:
    -db_utility.app	(where utility references an RDBMS)
    -sql_utility.app
    -table.app	(where table is a specific table)
    -db_connection.app
  Copyright (C)
  Daniel Watrous
  Maintain Fit Development Group
  Dec 2003
  ************************************************************/

require_once(APPS_ROOT."/sys_log.php");

class exceptions extends sys_log {

  //*****  member variables
  var $location = "";	//private
  //var $message = "";	//private
  //var $error = "";	//protected
  //var $errno = "";	//protected

  //*****  class constructor
  //private
  //needs to be explicitly called from extending function
  function exceptions () {
  	
  	if(isset($_SERVER['SERVER_NAME']))
  		$ServerName = $_SERVER['SERVER_NAME'];
  	else
  		$ServerName = "";	
  	
    $this->sys_log ();	//call constructor for parent object
    $this->location = $_SERVER["REQUEST_METHOD"].": ".$ServerName.$_SERVER["PHP_SELF"];
  }

  /*
  //*****  set methods
  //public function void set_message (string $msg)
  function set_message ($msg) {
    $this->message = $msg;
  }
  */

  //*****  function void halt (array $status)
  // static
  // this method can be called from any page and will effectively
  // halt the application and make a log of the error in the database.
  // this function expects the $status array to contain values indexed
  // by associative keys:
  //  "location"->...,
  //  "exception_type"->...,
  //  "error"->...,
  //  "errno"->...,
  //  "info"->array()
  // where the array contained in info is associative and contains additional
  // name=value pairs for display to the user.
  // NOTE: since this function is static it cannot contain $this-> references
  function halt ($status) {

    //actual halt message is stored here
    $halt_message_html = "";

    //variables used to cycle prepare array information for $halt_message_html
    $info_html_prepared = "";

    //prepare values in info_array for $halt_message_html
    if (count($status["info"])>0) {
      reset($status["info"]);
      do {
        $info_html_prepared .= "<br>".key($status["info"])."=".$status["info"][key($status["info"])];
      } while (next($status["info"]));
    }

    $halt_message_html = "</td></tr></table><img src=\"http://politic20.com/images/logo.gif\"><br><br>\n<font size=\"1\" face=\"Arial\">\n";
    $halt_message_html.= "<table cellspacing=\"0\" cellpadding=\"3\" border=\"1\">\n";
    //show location information
    $halt_message_html.= "  <tr>\n";
    $halt_message_html.= "    <td width =\"200\" valign=\"top\">Location:</td>\n";
    $halt_message_html.= "    <td width =\"500\" valign=\"top\">".$status["location"]."</td>\n";
    $halt_message_html.= "  </tr>\n";
    //show exception_type information
    $halt_message_html.= "  <tr>\n";
    $halt_message_html.= "    <td width =\"200\" valign=\"top\">Exception Type:</td>\n";
    $halt_message_html.= "    <td width =\"500\" valign=\"top\">".$status["exception_type"]."</td>\n";
    $halt_message_html.= "  </tr>\n";
    //show error information
    $halt_message_html.= "  <tr>\n";
    $halt_message_html.= "    <td width =\"200\" valign=\"top\">Error:</td>\n";
    $halt_message_html.= "    <td width =\"500\" valign=\"top\">".$status["error"]."</td>\n";
    $halt_message_html.= "  </tr>\n";
    //show errno information
    $halt_message_html.= "  <tr>\n";
    $halt_message_html.= "    <td width =\"200\" valign=\"top\">Errno:</td>\n";
    $halt_message_html.= "    <td width =\"500\" valign=\"top\">".$status["errno"]."</td>\n";
    $halt_message_html.= "  </tr>\n";
    //show info information
    $halt_message_html.= "  <tr>\n";
    $halt_message_html.= "    <td width =\"200\" valign=\"top\">Additional Information:</td>\n";
    $halt_message_html.= "    <td width =\"500\" valign=\"top\">".$info_html_prepared."</td>\n";
    $halt_message_html.= "  </tr>\n";
    $halt_message_html.= "</table>\n";
    $halt_message_html.= "</font><br><br>\n";

    print($halt_message_html);
    die("<font size=\"4\" face=\"Arial\">Session halted!<font>");
  }

  //*****  function void log_halt (string $exception="")
  // public
  // this script attempts to gather information and create a log
  // entry before calling halt to end the script
  function log_halt ($exception="",$email=null) {

    //declare array for status
    $status = array ();

    //prepare available values
    $status["location"] = $this->location;
    $status["exception_type"] = $exception;
    $status["error"] = $this->error;
    $status["errno"] = $this->errno;
    $status["info"] = $this->info_array;

    //log and then halt
    $this->log ($email);
    exceptions::halt($status);
  }

}

?>
