<?php
// FORM GENERATOR
/**
 * this function builds html form open and close tags
 * 
 * @param String $type tag type (open, close)
 * @param String $action the action where the form will be posted
 * @param String $method the form submit method (psot,get)
 * @param $name String form field name * 
 * @param $css String: form field style (optional)
 * @param $id String form field id
 * @param String $script1 form field javascript 1 (optional)
 * @param String $script2 form field javascript 2 (optional)
 * @param String $script3 form field javascript 3 (optional)
 * @author James Kleinschnitz
 */
 function form_tag ($type, $action='', $method='', $name='', $id='', $css='', $script1='', $script2='', $script3='') {
	switch($type) {
		case 'open':
			# id used in most of the tags (id="$id")
			$ID = !empty($id) ? ' id="'.$id.'"' : '';
			$NAME = !empty($name) ? ' name="'.$name.'"' : '';
			$METHOD = !empty($method) ? ' method="'.$method.'"' : '';
			$ACTION = !empty($action) ? ' action="'.$action.'"' : '';
			
			# class & script is optional for most of the tags (class="$css")
			$style = !empty($css) ? ' class="'.$css.'"' : '';
			$js1 = !empty($script1) ? ' '.$script1 : '';
			$js2 = !empty($script2) ? ' '.$script2 : '';
			$js3 = !empty($script3) ? ' '.$script3 : '';
			# $attribs is a set of usual/ optional input attri
			$attribs = $ACTION.$METHOD.$ID.$NAME.$style.$js1.$js2.$js3;
			return "<form $attribs>";
		break;
		case 'close':
			return "</form>";
		break;
	}//end switch
 }
/**
 * this function builds html form fields
 * 
 * TODO:fix param call order (type then param) -jk
 * 
 * @param $type String form field type (text,password,checkbox,radio,hidden,submit,reset,button,textarea)
 * @param $name String form field name
 * @param $id String form field id
 * @param $value String: form field value
 * @param $label String: form field label (optional)
 * @param $css String: form field style (optional)
 * @param $script1 String: form field javascript 1 (optional)
 * @param $script2 String: form field javascript 2 (optional)
 * @param $script3 String: form field javascript 3 (optional)
 * @param $checked Boolean: if type checkbox/radio true = option checked
 * @param $rows Integer: num of rows for a type textarea
 * @param $cols Integer: num of cols for a type textarea
 * @author James Kleinschnitz
 */
function form_field($type, $name, $id, $value, $label='', $css='', $script1='', $script2='', $script3='', $checked='', $rows=10, $cols=50) {
	# label for input tags (required: $id, $label; optional: $css, $js1-3)
	$lbl = !empty($label) ? '<label for="'.$id.'">'.$label.'</label>' : '';
	# id used in most of the tags (id="$id")
	$ID = !empty($id) ? ' id="'.$id.'"' : '';
	# class is optional for most of the tags (class="$css")
	$style = !empty($css) ? ' class="'.$css.'"' : '';
	$js1 = !empty($script1) ? ' '.$script1 : '';
	$js2 = !empty($script2) ? ' '.$script2 : '';
	$js3 = !empty($script3) ? ' '.$script3 : '';
	# $attribs is a set of usual/ optional input attributes (id, style, JavaScript) merged into one variable for easier maintenance
	$attribs = $ID.$style.$js1.$js2.$js3;
	# value is required in some of the tags (value="$value")
	$val = ' value="'.$value.'"';
	# input is starting attribute of some form tags (required: $type, $name; optional: $attribs)
	$input = '<input type="'.$type.'" name="'.$name.'"'.$attribs;
	switch($type) {
		case 'text':
		case 'file':
		case 'password': $output = ''.$lbl.'<br />'.$input.$val.' />'; break;
		case 'checkbox':
		case 'radio': $check = $checked == 'ok' ? ' checked="checked"' : ''; $output = '<p>'.$input.$val.$check.' />'.$lbl.'</p>'; break;
		case 'hidden':
		case 'submit':
		case 'reset':
		case 'button': $output = $input.$val.' />'; break;
		//case 'textarea': $output = '<p>'.$lbl.':<br /><textarea name="'.$name.'" rows="'.$rows.'" cols="'.$cols.'"'.$attribs.'>'.$value.'</textarea></p>'; break;
		case 'textarea': $output = $lbl.'<br /><textarea name="'.$name.'" rows="'.$rows.'" cols="'.$cols.'"'.$attribs.'>'.$value.'</textarea>'; break;
	}
	# display form tag
	return $output;
}
?>