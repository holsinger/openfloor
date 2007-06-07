<?

/**************************************************************************
  This class was adapted by Daniel Watrous for Maintain Fit.  Any
  applicable rights reserved.  This code may be used and shared.
 **************************************************************************/

require_once(APPS_ROOT."/exceptions.php");

/****** class properties are found below ******/

class db_mysql extends exceptions {

  var $query_id = 0;  // Result of most recent mysql_query().
  var $debug_level = 0;  // debug level
  
  var $record   = array();  // current mysql_fetch_array()-result.
  var $row;           // current row number.

  var $errno    = 0;  // error state of query...
  var $error    = "";

/****** class methods are found below ******/

  function __construct ($debug_level=0) {
  	$this->debug_level = $debug_level;
  }

  function __destruct () {
  	$this->free_result();
  }
  
  //pretty date function
  function pretty_date ($date) {
  	if ($date==null) return "Unknown";
    //get only the first part, leave out the time of day
    $mydate=substr($date,0,10);

    $arr=explode('-',$mydate);
    $mydate=mktime(0,0,0,$arr[1],$arr[2],$arr[0]);

    return date("M, d, Y",$mydate);
  }


/***********************************************************************
  The 'last_id' method is used to ...
 ***********************************************************************/
  function last_id() {
    if ($GLOBALS['connection']) {
      
      $last_id = mysql_insert_id ($GLOBALS['connection']);
      if ($this->debug_level>0) printf("\n<b style='color:#FF0000'>LAST ID:</b> %s <br>\n",(string)$last_id);
      return $last_id;
      
    } else {
      $this->set_error (mysql_error());
      $this->set_errno (mysql_errno());
      $this->set_info_array (array("error"=>mysql_error(),"errno"=>mysql_errno()));
      $this->set_message ("Could not find connection");
      $this->log_halt ("Could not find connection");
    }
  }


/***********************************************************************
  The 'num_records' method is used to ...
 ***********************************************************************/
  function num_records() {
    if (!$this->query_id) {
      $this->set_error (mysql_error());
      $this->set_errno (mysql_errno());
      $this->set_info_array (array("error"=>mysql_error(),"errno"=>mysql_errno()));
      $this->set_message ("Invalid Result Set");
      $this->log_halt ("Invalid Result Set");
    }
    $num_records = mysql_num_rows ($this->query_id);
    if ($this->debug_level>0) printf("\n<b style='color:#FF0000'>NUM RECORDS:</b> %s <br>\n",(string)$num_records);
    return $num_records;
  }


/***********************************************************************
  The 'begin' method is used to begin a transaction.  nothing done will
  be permanent until the commit function has been called.  rollback
  will undo
 ***********************************************************************/
  function begin() {
  	if ($this->debug_level>0) echo "<font size=6>BEGIN WORK</font>";
    return $this->query("BEGIN WORK");
  }


/***********************************************************************
  The 'commit' method is used to commit a transaction.  this must
  be preceded by a call to the begin function.
 ***********************************************************************/
  function commit() {
  	if ($this->debug_level>0) echo "<font size=6>COMMIT</font>";
    return $this->query("COMMIT");
  }


/***********************************************************************
  The 'rollback' method is used to rollback a transaction.  this will
  undo and SQL queried from the time the begin function is called.
 ***********************************************************************/
  function rollback() {
  	if ($this->debug_level>0) echo "<font size=6>ROLLBACK</font>";
    return $this->query("ROLLBACK");
  }


/***********************************************************************
  The 'query' method is used to execute a query againts the database
  using the connection established in the 'connect' method.
 ***********************************************************************/
  function query($query_string) {
  	//added by james
  	if ($this->debug_level>0) printf("\n<b style='color:#FF0000'>SQL QUERY:</b> %s <br>\n",(string)$query_string);
  	
    $this->query_id = mysql_query($query_string,$GLOBALS['connection']);
    //echo "<br>\n".$this->query_id."<br>\n";
    $this->row   = 0;
    $this->errno = mysql_errno();
    $this->error = mysql_error();
    if (!$this->query_id) {
      $this->set_error (mysql_error());
      $this->set_errno (mysql_errno());
      $this->set_info_array (array("error"=>mysql_error(),"errno"=>mysql_errno(),"SQL_query"=>$query_string));
      $this->set_message ("Invalid SQL or Database Error");
      $this->log_halt ("Invalid SQL or Database Error");
    }

    return $this->query_id;
  }


/***********************************************************************
  The 'next_record' method cycles through a result set and returns a
  false when it runs out of records.
 ***********************************************************************/
  function next() {
    $this->record = mysql_fetch_array($this->query_id);
    $this->row   += 1;
    $this->errno = mysql_errno();
    $this->error = mysql_error();

    $stat = is_array($this->record);
    if (!$stat) {
      mysql_free_result($this->query_id);
      $this->query_id = 0;
    }
    if ($stat) return $this->record;
    else return false;
  }

  function free_result() {
    //var_dump($this->query_id);
    if ( is_resource($this->query_id) ) mysql_free_result($this->query_id);
  }
  
	/**
	 * This fuction prevents SQL injection attacks
	 * by escaping problematic SQL characters.
	 */
	function escape_data($data)
	{
		if (ini_get('magic_quotes_gpc'))
			$data = stripslashes($data);
			
		return mysql_escape_string($data);
	}
}




?>