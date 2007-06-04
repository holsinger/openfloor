<?

/**************************************************
  This class functions as an SQL generation
  utility and is inherited by a TABLE object.
  This file was generated automatically.
  Copyright (C) Daniel Watrous
  Maintain Fit Development Group
  Jun 2003
  **************************************************/

require_once(APPS_ROOT."/db/db_mysql.php");

class db_sql_utility extends db_mysql {


  // ***** VARIABLES *****

  // ***** class variables
  var $table_name = "";	//table name for queries (inherited)
  var $error = "";	//error messages

  //***** FUNCTIONS *****

  // ***** set field sub-routine function
  function setField ($field_name,$value,$options,$modifiers=null) {
    if ($this->debug_level > 0 && $this->error) printf ("<font color=\"red\">ERROR:</font> <font color=\"blue\">%s</font>\n<br>",$this->error);
    if ($this->debug_level > 0) printf ("%s=<font color=\"blue\">%s</font>\n<br>",$field_name,$value);
    $quotes = isset($this->fields[$field_name]["quotes"]) ? $this->fields[$field_name]["quotes"]:null;
    $this->fields[$field_name]["value"] = $this->valid_input ($value,$quotes,$modifiers);
    if ($this->fields[$field_name]["value"]!==false && $this->fields[$field_name]["value"]!==null) {
      if ($modifiers) $this->fields[$field_name]["modifiers"] = $modifiers;
      if (is_int(strpos($options,'S'))) $this->fields[$field_name]["set"] = ($this->fields[$field_name]["value"]!==null && $this->fields[$field_name]["value"]!==false) ? $this->fields[$field_name]["value"]:true;
      if (is_int(strpos($options,'L'))) $this->fields[$field_name]["select"] = ($this->fields[$field_name]["value"]!==null && $this->fields[$field_name]["value"]!==false) ? $this->fields[$field_name]["value"]:true;	//DEPRECATED
      if (is_int(strpos($options,'W'))) $this->fields[$field_name]["where"] = ($this->fields[$field_name]["value"]!==null && $this->fields[$field_name]["value"]!==false) ? $this->fields[$field_name]["value"]:true;
      if (is_int(strpos($options,'O'))) $this->fields[$field_name]["orderby"] = true;
      if (is_int(strpos($options,'G'))) $this->fields[$field_name]["groupby"] = true;
    } else $this->error = "Could not validate data type or content.";
  }

  // ***** set field sub-routine function
  function getField ($field_name) {
    return $this->record[strtoupper($field_name)];
  }

  // ***** reset function
  function resetFields () {
    reset($this->fields);
    do {
      $this->fields[key($this->fields)]["modifiers"] = "";
      $this->fields[key($this->fields)]["set"] = false;
      $this->fields[key($this->fields)]["select"] = false;
      $this->fields[key($this->fields)]["where"] = false;
      $this->fields[key($this->fields)]["orderby"] = false;
      $this->fields[key($this->fields)]["groupby"] = false;
    } while (next($this->fields));
  }

  // ***** valid_input function to ensure that provided value is what is expected for this field
  //valid_input (mixed value, string type, string modifiers)
  function valid_input ($value, $type, $modifiers="") {
    $success = true;
    //$type here refers to the 'quotes' element in the fields array and means
    //either a string value, or a numeric value in the case of if being false
    if ($type==true) {	//$type here refers to the 'quotes' element in the fields array and means either a string value, or a numeric value in the case of if being false
      if (!get_magic_quotes_gpc ()) {
        $value = addslashes($value);
      }
      if (!is_int(strpos($modifiers,'between'))) {
				$value = str_replace("\\'","'",$value);
				$value = str_replace("'","''",$value);
			}
      return $value;
    } else {
      if (is_int(strpos($value,","))) {
        $arguments = split(",",$value);
        for ($i=0;$i<count($arguments);$i++) {
          if ($success) $success = ((is_numeric(trim($arguments[$i])) || $arguments[$i]=="null") && $success) ? true:false;
        }
        if ($success) return $value;
      } else if ((is_numeric(trim($value)) || $value=="null") && $success) {
        settype($value, "string");
        return $value;
      } else $success = false;
      if (!$success) {
        $this->set_error ("Data validation failed!  Please check your datatypes...");
				$this->set_info_array (array("value"=>$value,"table_name"=>$this->table_name,"field"=>key($this->fields)));
				$this->set_message ("Data validation failed");
				$this->log_halt ("Data validation failed");
      }
    }
    return false;
  }

  // ***** insert function
  function insert () {
    $first = false;
    $query = "insert into ".$this->table_name." (";
    reset($this->fields);
    do {
      if ($this->fields[key($this->fields)]["set"]!==false && $this->fields[key($this->fields)]["set"]!==null) {
        $query.= ($first) ? ",":"";
        $query.= key($this->fields);
        $first = true;
      }
    } while (next($this->fields));
    $query.= ") values (";
    $first = false;
    reset($this->fields);
    do {
      if ($this->fields[key($this->fields)]["set"]!==false && $this->fields[key($this->fields)]["set"]!==null) {
        $quotes = isset($this->fields[key($this->fields)]["quotes"]) ? "'":"";
        $query.= ($first) ? ",":"";
        //deprecated 4/29/04
        //reintro James ENGEB w/MD5
        if ($this->fields[key($this->fields)]["password"]) $query.= "MD5(".$quotes.$this->fields[key($this->fields)]["set"].$quotes.")";
        else $query.= $quotes.$this->fields[key($this->fields)]["set"].$quotes;
        $query.= $quotes.$this->fields[key($this->fields)]["set"].$quotes;
        $first = true;
      }
    } while (next($this->fields));
    $query.= ")";
    if ($this->debug_level > 0) printf ("INSERT SQL: <font color=\"blue\">%s</font>\n<br>",$query);
    $this->resetFields();
    if (ENFORCE_SECURITY_LEVELS == false || $_SESSION["session_security_level"]<=$this->sql_privileges[1]) {
      $this->query_id = $this->query($query);
      return $this->query_id;
    } else {
      $this->error = "Insufficient Security Access.  Operation Failed.";
      return false;
    }
  }

  // ***** select function
  // function use select ([mixed limit])
  //  limit:
  //    this will limit the number of records returned in the result set
  //    from MySQL manual: [LIMIT [offset,] rows | rows OFFSET offset]
  function select ($select_modifier="*",$limit=null,$offset=0) {
    $query = "select ";
    reset($this->fields);
    //DEPRECATED 6/23/03
    $select = "";
    do {
      if (isset($this->fields[key($this->fields)]["select"]) && $this->fields[key($this->fields)]["select"]!==false && $this->fields[key($this->fields)]["select"]!==null) {
        $select.= $this->fields[key($this->fields)]["select"];
      }
    } while (next($this->fields));
    $query.= ($select!="") ? $select:$select_modifier;
    $query.= " from ".$this->table_name." ";
    $query.= $this->buildWhere();
    $query.= $this->orderBy();
    $query.= $this->groupBy();
    if ($limit!==null && is_numeric(trim($limit))) $query.= " limit ";
    if ($offset!==0 && is_numeric(trim($offset))) $query.= $offset.", ";
    if ($limit!==null && is_numeric(trim($limit))) $query.= $limit;
    if ($this->for_update == true) $query.= " FOR UPDATE";
    if ($this->debug_level > 0) printf ("SELECT SQL: <font color=\"blue\"><pre>%s</pre></font>\n<br>",str_replace("<","&#60;",$query));
    $this->resetFields();
    if (ENFORCE_SECURITY_LEVELS == false || $_SESSION["session_security_level"]<=$this->sql_privileges[0]) {
      $this->query_id = $this->query($query);
      if ($this->debug_level > 0) printf ("QUERY_ID: <font color=\"blue\">%s</font>\n<br>",$this->query_id);
      return $this->query_id;
    } else {
      $this->error = "Insufficient Security Access.  Operation Failed.";
      return false;
    }
  }

  // ***** delete function
  function delete () {
    $query = "delete from ".$this->table_name." ";
    $query.= $this->buildWhere();
    if ($this->debug_level > 0) printf ("DELETE SQL: <font color=\"blue\">%s</font>\n<br>",$query);
    $this->resetFields();
    if (ENFORCE_SECURITY_LEVELS == false || $_SESSION["session_security_level"]<=$this->sql_privileges[3]) {
      $this->query_id = $this->query($query);
      return $this->query_id;
    } else {
      $this->error = "Insufficient Security Access.  Operation Failed.";
      return false;
    }
  }

  // ***** update function
  function update () {
    $first = false;
    $query = "update ".$this->table_name." ";
    reset($this->fields);
    do {
      if ($this->fields[key($this->fields)]["set"]!==false && $this->fields[key($this->fields)]["set"]!==null) {
        $quotes = isset($this->fields[key($this->fields)]["quotes"]) ? "'":"";
        $query.= ($first) ? ",":" set ";
        $query.= " ".key($this->fields)." = ";
        //deprecated 4/29/04
        //reintro James ENGEB w/MD5
        if ($this->fields[key($this->fields)]["password"]) $query.= "MD5(".$quotes.$this->fields[key($this->fields)]["set"].$quotes.")";
        else $query.= $quotes.$this->fields[key($this->fields)]["set"].$quotes;
        $query.= $quotes.$this->fields[key($this->fields)]["set"].$quotes;
        $first = true;
      }
    } while (next($this->fields));
    $query.= $this->buildWhere();
    if ($this->debug_level > 0) printf ("UPDATE SQL: <font color=\"blue\">%s</font>\n<br>",$query);
    $this->resetFields();
    if (ENFORCE_SECURITY_LEVELS == false || $_SESSION["session_security_level"]<=$this->sql_privileges[2]) {
      $this->query_id = $this->query($query);
      return $this->query_id;
    } else {
      $this->error = "Insufficient Security Access.  Operation Failed.";
      return false;
    }
  }

  // ***** where clause function
  function buildWhere () {
    $first = false;
    $wild = false;
    $query = "";
    $no_modifiers = false;
    reset($this->fields);
    do {
      $no_modifiers = false;
      if (isset($this->fields[key($this->fields)]["where"]) && $this->fields[key($this->fields)]["where"]!==false && $this->fields[key($this->fields)]["where"]!==null) {
        $quotes = isset($this->fields[key($this->fields)]["quotes"]) ? "'":"";
        $wild = preg_match("/%/",$this->fields[key($this->fields)]["where"]);
        $query.= ($first) ? " and ":"";
        if ($this->fields[key($this->fields)]["modifiers"]) {
          if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"not null"))) $query.= " ".key($this->fields)." is not null";
          else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"null"))) $query.= " ".key($this->fields)." is null";
          else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"between"))) {
            $query.= " ".key($this->fields)." between ";
            $query.= $quotes.$this->fields[key($this->fields)]["where"].$quotes;
          } else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],'lesszero'))) {
            $query.= " ".key($this->fields)." < 0 ";
          } else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],'less'))) {
            $query.= " ".key($this->fields)." < ";
            $query.= $quotes.$this->fields[key($this->fields)]["where"].$quotes;
          } else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],'greaterzero'))) {
            $query.= " ".key($this->fields)." > 0 ";
          } else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],'greater'))) {
            $query.= " ".key($this->fields)." > ";
            $query.= $quotes.$this->fields[key($this->fields)]["where"].$quotes;
          } else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"not in"))) {
            $query.= " ".key($this->fields)." not in ";
            $arguments = split(",",$this->fields[key($this->fields)]["where"]);
            $query.= "(";
            for ($i=0;$i<count($arguments);$i++) {
              $query.= $quotes.$arguments[$i].$quotes;
              if ($i<(count($arguments)-1)) $query.= ",";
            }
            $query.= ")";
          } else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"in"))) {
            $query.= " ".key($this->fields)." in ";
            $arguments = split(",",$this->fields[key($this->fields)]["where"]);
            $query.= "(";
            for ($i=0;$i<count($arguments);$i++) {
              $query.= $quotes.$arguments[$i].$quotes;
              if ($i<(count($arguments)-1)) $query.= ",";
            }
            $query.= ")";
          } else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"not equal"))) {
            $query.= " ".key($this->fields)." != ";
            $query.= $quotes.$this->fields[key($this->fields)]["where"].$quotes;
          } else $no_modifiers = true;
        } else $no_modifiers = true;
        if ($no_modifiers) {
          if (!$wild) {
            $query.= " ".key($this->fields)." = ";
            //deprecated 4/29/04
            //reintro James ENGEB w/MD5
            if ($this->fields[key($this->fields)]["password"]) $query.= "MD5(".$quotes.$this->fields[key($this->fields)]["where"].$quotes.")";
            else $query.= $quotes.$this->fields[key($this->fields)]["where"].$quotes;
            $query.= $quotes.$this->fields[key($this->fields)]["where"].$quotes;
          } else {
            $query.= " ".key($this->fields)." like ";
            $query.= $quotes.$this->fields[key($this->fields)]["where"].$quotes;
          }
        }
        $first = true;
      }
    } while (next($this->fields));
    if (($query!="")) return (" where ".$query);
    else return("");
  }

  // ***** order by clause function
  function orderBy () {
    $first = false;
    $query = "";
    $count = 100;
    $orderby_array = array();
    reset($this->fields);
    do {
      $count++;
      if (isset($this->fields[key($this->fields)]["orderby"]) && $this->fields[key($this->fields)]["orderby"]===true) {
        if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],'ASC'))) {
          $orderby_array[substr($this->fields[key($this->fields)]["modifiers"],0,1)] = key($this->fields)." ASC";
        } else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],'DESC'))) {
          $orderby_array[substr($this->fields[key($this->fields)]["modifiers"],0,1)] = key($this->fields)." DESC";
        } else {
          $orderby_array[$count] = key($this->fields);
        }
      }
    } while (next($this->fields));
    if (count($orderby_array)>0) {;
      ksort($orderby_array);
      reset($orderby_array);
      do {
        $query.= ($first) ? ",":"";
        $query.= " ".$orderby_array[key($orderby_array)]." ";
        $first = true;
      } while (next($orderby_array));
    }
    if ($query!="") return (" order by ".$query);
    else return ("");
  }

  // ***** group by clause function
  function groupBy () {
    $first = false;
    $query = "";
    reset($this->fields);
    do {
      if (isset($this->fields[key($this->fields)]["groupby"]) && $this->fields[key($this->fields)]["groupby"]===true) {
        $query.= ($first) ? ",":"";
        $query.= " ".key($this->fields)." ";
        $first = true;
      }
    } while (next($this->fields));
    if ($query!="") return (" group by ".$query);
    else return ("");
  }
}

?>
