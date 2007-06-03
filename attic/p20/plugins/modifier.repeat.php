<?php
/**
 * template_lite repeat modifier plugin
 *
 * Type:     modifier
 * Name:     repeat
 * Purpose:  Wrapper for the PHP 'str_repeat' function
 * Credit:   Created for the Pligg CMS by the Pligg Dev Team
 */
function tpl_modifier_repeat($string, $count)
{
	return str_repeat($string, $count);
}
?>