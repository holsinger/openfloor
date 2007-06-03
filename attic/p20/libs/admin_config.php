<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// The Pligg Team <pligger at pligg dot com>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

class pliggconfig {
	var $id = 0;
	var $var_page = 0;
	var $var_name = 0;
	var $var_value = 0;
	var $var_defaultvalue = 0;
	var $var_optiontext = false;
	var $var_title = 0;
	var $var_desc = '';
	var $EditInPlaceCode = '';

	function listpages(){
		global $db;
		$sql = "Select var_page from " . table_config . " group by var_page;";
		$configs = $db->get_col($sql);
		if ($configs) {
			echo "<fieldset style='padding:5px 5px 5px 5px;'><legend>Pligg Config v1.0</legend><table style=border:none>";
			foreach($configs as $config_id) {
				if($config_id != "Hidden"){
					echo '<tr><td><a href = "?page='.$config_id.'">'.$config_id.'</a></tr></td>';
				}	
			}
			echo '</table></fieldset>';
		} else {
			echo "nothing found";
		}
		
	}

	function showpage(){
		global $db, $my_pligg_base;
		
		?>
			
			
			<style type="text/css">
				.eip_editable { background-color: #ff9; padding: 3px; }
				.eip_savebutton { background-color: #36f; color: #fff; }
				.eip_cancelbutton { background-color: #000; color: #fff; }
				.eip_saving { background-color: #903; color: #fff; padding: 3px; }
				.eip_empty { color: #afafaf; }
			</style>
		<?php

		$sql = "Select var_id from " . table_config . " where var_page = '$this->var_page'";
		$configs = $db->get_col($sql);
		if ($configs) {
			foreach($configs as $config_id) {
				$this->var_id=$config_id;
				$this->read();
				$this->print_summary();
				$EditInPlaceCode .= $this->EditInPlaceCode;
			}

			echo '<script type="text/javascript">';
			echo "Event.observe(window, 'load', init, false);";
			echo "function init() {";

			echo $EditInPlaceCode;
			
			echo "}</script>";

		} else {
			echo "nothing found";
		}
	}

	function read(){
		global $db;
		$config = $db->get_row("SELECT * FROM " . table_config . " WHERE var_id = $this->var_id");

			$this->var_page=$config->var_page;
			$this->var_name=$config->var_name;
			$this->var_value=htmlentities($config->var_value);
			$this->var_defaultvalue=$config->var_defaultvalue;
			$this->var_optiontext=$config->var_optiontext;
			$this->var_title=$config->var_title;
			$this->var_desc=$config->var_desc;

		return true;
	}
		
	function store(){
		global $db;
		$sql = "UPDATE " . table_config . " set var_value = '".$this->var_value."' where var_id = ".$this->var_id;
		$db->query($sql);
		$this->create_file();

		$content = $_POST["var_value"];
		print(htmlspecialchars($content));

		return true;
	}
		
	function print_summary(){
		global $db;

		echo '<span id = var_'.$this->var_id.'_span><form>';
		echo "<fieldset><legend><b>$this->var_title</b></legend><br />";
		echo "description: $this->var_desc<br>";
		
		if($this->var_name == '$my_base_url'){echo "It looks like this should be set to <b>"."http://" . $_SERVER["HTTP_HOST"]."</b><br>";}
		
		if($this->var_name == '$my_pligg_base'){
			$pos = strrpos($_SERVER["SCRIPT_NAME"], "/");
			$path = substr($_SERVER["SCRIPT_NAME"], 0, $pos);
			if ($path == "/" || $path == ""){$path = "nothing - just leave it blank";}
			echo "It looks like this should be set to <b>".$path."</b><br>";
		}
		
		echo '<b>value:</b> <span id="editme' .$this->var_id. '">'.$this->var_value.'</span><br>';
		echo "default value: $this->var_defaultvalue<br>";
		echo "expected values: $this->var_optiontext";
		echo '<input type = "hidden" name = "var_id" value = "'.$this->var_id.'">';
		echo "</form></fieldset></span>";
		$this->EditInPlaceCode = "EditInPlace.makeEditable( {type: 'text', action: 'save', id: 'editme" .$this->var_id. "',	save_url: 'admin_config.php'} );";		
		
	}


	function create_file($filename = "./settings.php"){
		global $db;
		if($handle = fopen($filename, 'w')) {
		
			fwrite($handle, "<?php\n");
			$usersql = $db->get_results('SELECT * FROM ' . table_prefix . 'config');
			foreach($usersql as $row) {
				$value = $row->var_enclosein . $row->var_value. $row->var_enclosein;
				
				$write_vars = array('table_prefix', '$my_base_url', '$my_pligg_base', '$dblang');
				
				if(in_array($row->var_name, $write_vars)){
				
					if ($row->var_method == "normal"){
						$line =  $row->var_name . " = " . $value . ";";
					}
					if ($row->var_method == "define"){
						$line = "define('" . $row->var_name . "', ". $value . ");";
					}
				
					if(fwrite($handle, $line . "\n")) {
			
					} else {
						echo "<b>Could not write to '$filename' file</b>";
					}
				}				
			}
			fwrite($handle, "include_once mnminclude.'settings_from_db.php';\n");
			fwrite($handle, "?>");
			fclose($handle);
		} else {
			echo "<b>Could not open '$filename' file for writing</b>";
		}
	}
}

?>