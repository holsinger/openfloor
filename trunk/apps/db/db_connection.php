<?

/************************************************************
  This class serves to establish and manage a static
  database connection for use by all table app files.
  Copyright (C)
  Daniel Watrous
  Maintain Fit Development Group
  Dec 2003
  ************************************************************/

define ("CONFIG_XML_FILE", "C:/wamp/www/temp/conf/p20_conf.xml");
require_once(APPS_ROOT."/exceptions.php");

class db_connection extends exceptions {

  //*****  private member variables
  // all private variables are initialized from an XML file
  // located behind the document root.
  var $username = "";
  var $password = "";
  var $host = ""; 	// hostname or IP of MySQL server.
  var $port = 3306;	// initialized to default MySQL port
  var $database = "";
  var $client_flags = "";
  var $new_connection = false;	// use same connection by default
  var $tty = "";
  var $security_level = 0;	// start as superuser and lower access requirements on initialization
  var $debug_level = 0;

  //*****  protected member variables
  // these include only error and errno as inherited by sys_log through exceptions
  var $error    = "";
  var $errno    = 0;

  //*****  static member variables
  //var $GLOBALS['connection'] = null;	//MySQL Resource

	//*****  class constructor
	function db_connection ($debug_level=0) {
		if ($debug_level) $this->debug_level = $debug_level;
		if ($this->debug_level>0) printf("\nDEBUG_LEVEL: %s <br>\n",$this->debug_level);
		$this->exceptions();
		$this->sys_log();

		//local function variables
		$congif_simple_xml = simplexml_load_file(CONFIG_XML_FILE);	//container for xml object tree

		if ($congif_simple_xml === FALSE) {
			sys_log::create_log("Error while parsing XML configuration document for database connection",ADMIN_EMAIL);
			$status["location"] = "db_connection";
			$status["exception_type"] = "fail at constructor";
			$status["error"] = $php_errormsg;
			exceptions::halt($status);
		}

		// extract information for DB connection
		$this->username = $congif_simple_xml->DatabaseAccount->username;
		$this->password = $congif_simple_xml->DatabaseAccount->password;
		$this->host = $congif_simple_xml->DatabaseAccount->host;
		$this->port = $congif_simple_xml->DatabaseAccount->port;
		$this->database = $congif_simple_xml->DatabaseAccount->database;
		$this->client_flags = $congif_simple_xml->DatabaseAccount->client_flags;
		$this->new_connection = $congif_simple_xml->DatabaseAccount->new_connection;
		$this->tty = $congif_simple_xml->DatabaseAccount->tty;
		$this->security_level = $congif_simple_xml->DatabaseAccount->security_level;

		// establish connection
		$this->connect ();

		register_shutdown_function(array(&$this, 'close'));
	}

  //*****  int connect() method
  // This connect method is used to establish a  connection
  // with a specific MySQL database as defined in the config.xml
  // file located in <prefix>_config behind the document root
  function connect() {
    if (!isset($GLOBALS['connection']) || 0 == $GLOBALS['connection']) {
      $GLOBALS['connection']  = mysql_connect($this->host, $this->username, $this->password, $this->new_connection);
      if (!$GLOBALS['connection']) {
        $this->set_error (mysql_error());
        $this->set_errno (mysql_errno());
        $this->set_info_array (array("error"=>mysql_error(),"errno"=>mysql_errno()));
        $this->set_message ("Connect to database failed");
        $this->log_halt ("connect to database failed",ADMIN_EMAIL);
      }
      if ($this->database) {
        if (!mysql_query(sprintf("use %s",$this->database),$GLOBALS['connection'] )) {
          $this->set_error (mysql_error());
					$this->set_errno (mysql_errno());
					$this->set_info_array (array("error"=>mysql_error(),"errno"=>mysql_errno()));
          $this->set_message ("Connect use database: ".$this->database."!");
          $this->log_halt ("Connect use database ".$this->database."!",ADMIN_EMAIL);
        }
      }
    }
    if ($this->debug_level>0) printf("\nMySQL_LINK: %s <br>\n",$GLOBALS['connection'] );
  }

  //*****  pconnect method
  // This pconnect method is used to establish a persistent connection
  // with a specific MySQL database as defined in the config.xml
  // file located in <prefix>_config behind the document root
  function pconnect() {
    if (0 == $GLOBALS['pconnection']) {
      $GLOBALS['pconnection']  = mysql_pconnect($this->host, $this->username, $this->password);
      if (!$GLOBALS['pconnection'] ) {
        $this->set_error (mysql_error());
        $this->set_errno (mysql_errno());
        $this->set_info_array (array("error"=>mysql_error(),"errno"=>mysql_errno()));
        $this->set_message ("Persistent Connect to database failed! pconnection == false");
        $this->log_halt ("pconnect to database failed",ADMIN_EMAIL);
      }
      if ($this->database) {
        if (!mysql_query(sprintf("use %s",$this->database),$GLOBALS['pconnection'])) {
          $this->set_error (mysql_error());
					$this->set_errno (mysql_errno());
					$this->set_info_array (array("error"=>mysql_error(),"errno"=>mysql_errno()));
          $this->set_message ("Connect use database <font color=blue>".$this->database."</font>!");
          $this->log_halt ("Connect use database ".$this->database."!",ADMIN_EMAIL);
        }
      }
    }
    if ($this->debug_level>0) printf("\nMySQL_LINK: %s <br>\n",$GLOBALS['pconnection']);
  }

  //*****  close method
  // The close method is used to close an open connection
  // with a specific MySQL database contained in the
  // $db_connection::connection static member variable
  function close() {
    if ($GLOBALS['connection']) {
      if (!mysql_close($GLOBALS['connection'])) {
        $this->set_error (mysql_error());
				$this->set_errno (mysql_errno());
				$this->set_info_array (array("error"=>mysql_error(),"errno"=>mysql_errno()));
        $this->set_message ("Database connection close failed");
        $this->log_halt ("Database connection close failed");
      }
    }
  }
}

?>
