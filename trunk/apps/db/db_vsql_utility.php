<?

/**************************************************
  This class functions as an SQL generation
  utility and is inherited by a VIEW object.
  This file was generated automatically.
  Copyright (C) Daniel Watrous
  Maintain Fit Development Group
  Dec 2003
  **************************************************/

class db_vsql_utility extends db_sql_utility {

  //***** FUNCTIONS *****
  //***** NOTE: these functions replace existing functions in sql_utility *****

  // ***** set VIEW field sub-routine function
  function setFieldSub ($field_name,$value,$options,$modifiers) {
    $this->fields[$field_name]["value"] = $this->valid_input ($value,$this->fields[$field_name]["quotes"]);
    if ($this->fields[$field_name]["value"]!==false && $this->fields[$field_name]["value"]!==null) {
      if ($modifiers) $this->fields[$field_name]["modifiers"] = $modifiers;
      if (is_int(strpos($options,'W'))) $this->fields[$field_name]["where"] = ($value!==null && $value!==false) ? $value:true;
      if (is_int(strpos($options,'H'))) $this->fields[$field_name]["having"] = ($value!==null && $value!==false) ? $value:true;
      if (is_int(strpos($options,'O'))) $this->fields[$field_name]["orderby"] = true;
      if (is_int(strpos($options,'G'))) $this->fields[$field_name]["groupby"] = true;
    } else $this->error = "Could not validate data type or content.";
    if ($this->debug_level > 0 && $this->error) printf ("<font color=\"red\">ERROR:</font> <font color=\"blue\">%s</font>\n<br>",$this->error);
    if ($this->debug_level > 0) printf ("%s=<font color=\"blue\">%s</font>\n<br>",$field_name,$value);
  }

  // ***** select function
  // function use select ([int limit, int offset])
  //  limit:
  //    this will limit the number of records returned in the result set
  //    from MySQL manual: [LIMIT [offset,] rows | rows OFFSET offset]
  function select ($limit=null,$offset=0) {
    $query = "select ";
    reset($this->fields);
    $select = "";

    //prepare fields for select
    $first = false;
    do {
      $select.= ($first) ? ", ":"";
      $select.= $this->fields[key($this->fields)]["real_field"]." AS ".key($this->fields)." ";
      $first = true;
    } while (next($this->fields));
    $query.= ($select!="") ? $select:"*";
    $query.= " from ";

    //prepare for tables and joins
    //note: the tables array referred to below is provided by child object
    $first = false;
    for ($i=0;$i<count($this->tables);$i++) {
      $query.= ($first && $this->tables[$i]["join_type"]=="NONE") ? ", ":"";
      if ($this->tables[$i]["join_type"]!="NONE") $query.= " ".$this->tables[$i]["join_type"];
      $query.= " ".$this->tables[$i]["table_real_name"];
      $query.= " as ".$this->tables[$i]["table_name_as"];
      if ($this->tables[$i]["join_method"]!="NONE") $query.= " ".$this->tables[$i]["join_method"];
      if ($this->tables[$i]["join_definition"]!="") $query.= " (".$this->tables[$i]["join_definition"].")";
      $first = true;
    }
    $query.= $this->buildWhere();
    $query.= $this->groupBy();
    $query.= $this->buildHaving();
    $query.= $this->orderBy();
    if ($limit!==null && is_numeric(trim($limit))) $query.= " limit ";
    if ($offset!==0 && is_numeric(trim($offset))) $query.= $offset.", ";
    if ($limit!==null && is_numeric(trim($limit))) $query.= $limit;
    if ($this->debug_level > 0) printf ("SELECT SQL: <font color=\"blue\"><pre>%s</pre></font>\n<br>",str_replace("<","&#60;",$query));
    $this->resetFields();
    if ($_SESSION["session_security_level"]<=$this->sql_privileges[0]) {
      $this->query_id = $this->query($query);
      return $this->query_id;
    } else {
      $this->error = "Insufficient Security Access.  Operation Failed.";
      return false;
    }
  }

  // ***** where clause function
  function buildWhere () {
    //initialize variables
    $first = false;
    $wild = false;
    if ($this->conditional!="") {
      $query = $this->conditional." ";
      $first = true;
    } else $query = "";
    $no_modifiers = false;
    reset($this->fields);
    do {
      $no_modifiers = false;
      if ($this->fields[key($this->fields)]["where"]!==false && $this->fields[key($this->fields)]["where"]!==null) {
        $quotes = ($this->fields[key($this->fields)]["quotes"]) ? "'":"";
        $wild = preg_match("/%/",$this->fields[key($this->fields)]["where"]);
        $query.= ($first) ? " and ":"";
        if ($this->fields[key($this->fields)]["modifiers"]) {
          if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"not null"))) $query.= " ".$this->fields[key($this->fields)]["real_field"]." is not null";
          else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"null"))) $query.= " ".$this->fields[key($this->fields)]["real_field"]." is null";
          else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"between"))) {
            $query.= " ".$this->fields[key($this->fields)]["real_field"]." between ";
            $query.= $quotes.$this->fields[key($this->fields)]["where"].$quotes;
          } else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"less"))) {
            $query.= " ".$this->fields[key($this->fields)]["real_field"]." < ";
            $query.= $quotes.$this->fields[key($this->fields)]["where"].$quotes;
          } else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"greater"))) {
            $query.= " ".$this->fields[key($this->fields)]["real_field"]." > ";
            $query.= $quotes.$this->fields[key($this->fields)]["where"].$quotes;
          } else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"not in"))) {
            $query.= " ".$this->fields[key($this->fields)]["real_field"]." not in ";
            $arguments = split(",",$this->fields[key($this->fields)]["where"]);
            $query.= "(";
            for ($i=0;$i<count($arguments);$i++) {
              $query.= $quotes.$arguments[$i].$quotes;
              if ($i<(count($arguments)-1)) $query.= ",";
            }
            $query.= ")";
          } else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"in"))) {
            $query.= " ".$this->fields[key($this->fields)]["real_field"]." in ";
            $arguments = split(",",$this->fields[key($this->fields)]["where"]);
            $query.= "(";
            for ($i=0;$i<count($arguments);$i++) {
              $query.= $quotes.$arguments[$i].$quotes;
              if ($i<(count($arguments)-1)) $query.= ",";
            }
            $query.= ")";
          } else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"not equal"))) {
            $query.= " ".$this->fields[key($this->fields)]["real_field"]." != ";
            $query.= $quotes.$this->fields[key($this->fields)]["where"].$quotes;
          } else $no_modifiers = true;
        } else $no_modifiers = true;
        if ($no_modifiers) {
          if (!$wild) {
            $query.= " ".$this->fields[key($this->fields)]["real_field"]." = ";
            if ($this->fields[key($this->fields)]["password"]) $query.= "password(".$quotes.$this->fields[key($this->fields)]["where"].$quotes.")";
            else $query.= $quotes.$this->fields[key($this->fields)]["where"].$quotes;
          } else {
            $query.= " ".$this->fields[key($this->fields)]["real_field"]." like ";
            $query.= $quotes.$this->fields[key($this->fields)]["where"].$quotes;
          }
        }
        $first = true;
      }
    } while (next($this->fields));
    if (($query!="")) return (" where ".$query);
    else return("");
  }

  // ***** having clause function
  function buildHaving () {
    //initialize variables
    $first = false;
    $wild = false;
    $query = "";
    $no_modifiers = false;
    reset($this->fields);
    do {
      $no_modifiers = false;
      if ($this->fields[key($this->fields)]["having"]!==false && $this->fields[key($this->fields)]["having"]!==null) {
        $quotes = ($this->fields[key($this->fields)]["quotes"]) ? "'":"";
        $wild = preg_match("/%/",$this->fields[key($this->fields)]["having"]);
        $query.= ($first) ? " and ":"";
        if ($this->fields[key($this->fields)]["modifiers"]) {
          if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"not null"))) $query.= " ".key($this->fields)." is not null";
          else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"null"))) $query.= " ".key($this->fields)." is null";
          else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"between"))) {
            $query.= " ".key($this->fields)." between ";
            $query.= $quotes.$this->fields[key($this->fields)]["having"].$quotes;
          } else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"less"))) {
            $query.= " ".key($this->fields)." < ";
            $query.= $quotes.$this->fields[key($this->fields)]["having"].$quotes;
          } else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"greater"))) {
            $query.= " ".key($this->fields)." > ";
            $query.= $quotes.$this->fields[key($this->fields)]["having"].$quotes;
          } else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"not in"))) {
            $query.= " ".key($this->fields)." not in ";
            $arguments = split(",",$this->fields[key($this->fields)]["having"]);
            $query.= "(";
            for ($i=0;$i<count($arguments);$i++) {
              $query.= $quotes.$arguments[$i].$quotes;
              if ($i<(count($arguments)-1)) $query.= ",";
            }
            $query.= ")";
          } else if (is_int(strpos($this->fields[key($this->fields)]["modifiers"],"not equal"))) {
            $query.= " ".key($this->fields)." != ";
            $query.= $quotes.$this->fields[key($this->fields)]["having"].$quotes;
          } else $no_modifiers = true;
        } else $no_modifiers = true;
        if ($no_modifiers) {
          if (!$wild) {
            $query.= " ".key($this->fields)." = ";
            if ($this->fields[key($this->fields)]["password"]) $query.= "password(".$quotes.$this->fields[key($this->fields)]["having"].$quotes.")";
            else $query.= $quotes.$this->fields[key($this->fields)]["having"].$quotes;
          } else {
            $query.= " ".key($this->fields)." like ";
            $query.= $quotes.$this->fields[key($this->fields)]["having"].$quotes;
          }
        }
        $first = true;
      }
    } while (next($this->fields));
    if (($query!="")) return (" having ".$query);
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
      if ($this->fields[key($this->fields)]["orderby"]===true) {
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
      if ($this->fields[key($this->fields)]["groupby"]===true) {
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
