<?

/**************************************************
  This class functions as a database access tool
  with variables and functions built specifically
  to access one table in a relational database
  schema.  This file was generated automatically.
  TABLE NAME: BM_ACCOUNT
  Copyright (C) Daniel Watrous
  Maintain Fit Development Group
  Dec 2003
  **************************************************/

define ("DATABASE_XML_FILE", "/php5/htdocs/p20/trunk/conf/p20_table_conf.xml");
require_once(APPS_ROOT."/db/db_sql_utility.php");

class db_table extends db_sql_utility {

  // ***** constructor for common database connection
  // (&$db) in the code below must reference a db_local
  // object created prior to creating an instance of
  // this object and must be the same for all objects
  // requiring transactions with rollback capability
  function db_table ($table,$debug=null) {
    $this->debug_level = $debug;
    $this->table_name = strtolower($table);
    $this->sys_log ();

    //local function variables
	$congif_simple_xml = simplexml_load_file(DATABASE_XML_FILE);	//container for xml object tree

    if($congif_simple_xml === FALSE) {
      sys_log::create_log("Error while parsing XML configuration document for database connection",ADMIN_EMAIL);
      $status["location"] = "table app";
      $status["exception_type"] = "fail at constructor";
      $status["error"] = $php_errormsg;
      exceptions::halt($status);
    }

		foreach ($congif_simple_xml->table as $table) {
			if ($this->table_name==strtolower($table['tname'])) {
				if ($this->debug_level>1) printf("\nTABLE_NAME: %s <br>\n",$table['tname']);
				foreach ($table->field as $field) {
					if ($this->debug_level>1) printf("\nFIELD_NAME: %s <br>\n",(string)$field['fname']);

					$this->fields[(string)$field['fname']] = array ("value" => "", "set" => false, "where" => false, "orderby" => false, "groupby" => false, "modifiers" => false);
					switch ($field->field_datatype) {
						case "CHAR":
							$this->fields[(string)$field['fname']]["quotes"] = true;
							break;
						case "VARCHAR":
							$this->fields[(string)$field['fname']]["quotes"] = true;
							break;
						case "TEXT":
							$this->fields[(string)$field['fname']]["quotes"] = true;
							break;
						case "BLOB":
							$this->fields[(string)$field['fname']]["quotes"] = true;
							break;
						case "MEDIUMBLOB":
							$this->fields[(string)$field['fname']]["quotes"] = true;
							break;
						case "DATE":
							$this->fields[(string)$field['fname']]["quotes"] = true;
							break;
						case "DATETIME":
							$this->fields[(string)$field['fname']]["quotes"] = true;
							break;
						case "TIMESTAMP":
							$this->fields[(string)$field['fname']]["quotes"] = true;
							break;
						default:
							$this->element.= "";
							break;
					}

					if ($field->field_formtype == "PASSWORD") {
						$this->fields[(string)$field['fname']]["password"] = true;
					} else {
						$this->fields[(string)$field['fname']]["password"] = false;
					}

					if ($this->debug_level>1) printf("\nDATATYPE: %s <br>\n",$field->field_datatype);
					if ($this->debug_level>1) printf("\nFORMTYPE: %s <br><hr>\n",$field->field_formtype);

				} // end foreach field
			} // end if table names match
		} // end foreach table

    register_shutdown_function(array(&$this, 'free_result'));
  }

  //***** VARIABLES *****

  // ***** fields array
  // the values in this array should always be set using the set methods below.
  //in other words, this array is private.
  var $fields = array ();

  // ***** class variables
  var $debug_level = false;		//current debug status, set in constructor
  var $query_id = 0;	//result of the current query for this object
  var $row = 0;		//current row of record set
  var $record = 0;	//current result array for this object
  var $table_name = "";	//current table name
  var $sql_privileges = array(6,6,6,0);	//in order (SELECT,INSERT,UPDATE,DELETE).  these are checked against $_SESSION["session_security_level"]
  // When this is set to true the select statement will have appended to it " FOR UPDATE" sql.
  // This will ensure that the row selected has an exclusive lock through the end of the transaction.
  var $for_update = false;

  // ***** class functions
  function setFor_update () {
  	$this->for_update = true;
  }

}

?>
