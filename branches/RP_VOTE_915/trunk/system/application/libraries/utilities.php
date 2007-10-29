<?php

class Utilities
{
	// function __construct()
	// {
	// 	$this->CI=& get_instance();
	// }
	
	public static function multi_select($name, $data, $selected = array())
	{
		$html = "<select name=\"{$name}[]\" multiple=\"multiple\">";
		foreach ($data as $k => $v)
			if(in_array($k, $selected)) $html .= "<option value=\"$k\" selected=\"selected\">$v</option>";
			else $html .= "<option value=\"$k\">$v</option>";
		$html .= "</select>";

		return $html;		
	}
}


?>