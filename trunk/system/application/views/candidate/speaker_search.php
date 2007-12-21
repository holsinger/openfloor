<? 
include("./fckeditor/fckeditor.php");
$data['sub_title'] = $page_title;
$this->load->view('view_includes/header.php', $data);
?>
<!--
	#dependency autocomplete.css
	#dependency events.css
-->
<div id="content_div">
  	<div class='errorArea'><?=$this->validation->error_string;?></div>
	<div id="account_form">
			<label>Speaker Display Name: *</label>
			<small>Type in the speakers name.  To avoid duplication, if the name matches an existing<br /> user then you can select him/her from the drop down box.</small><br />
			<input name="display_name" id="display_name" value="<?=$display_name?>" class="txt" size="48" maxlength="100">
			<span id="indicator1" style="display: none">Loading...</span>
			<div id="autocomplete_choices" class="autocomplete"></div>
			<div id="selected_area" style="background-color: #bedafc; border: 1px; padding: 10px; margin-top: 10px; display: none;">
				<strong><i>User Selected</i></strong>
				<div id="selected_user"></div>
				<div id="selected_user_info"></div>
			</div>
			<br /><br />
			<div id="explanation"></div>
			<br /><br />
			<input type="button" onclick="window.location='event/create_event_two/<?=$event_id?>';" class="button" value="Cancel">
			<input id="button_2" type="button" class="button" value="Next Step">
			<span id="optional_button"></span>
			<br /><br />
			<small>* required fields</small>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
	// Initial Setup
	new Ajax.Autocompleter("display_name", "autocomplete_choices", site_url+"event/user_name_from_search_ajax", {minChars: 3, indicator: 'indicator1', afterUpdateElement: after_update, callback: on_any_update});
	Event.observe($("button_2"), 'click', regular_submit);
	var current_selection = false;
	// Callbacks
	function after_update(text_box, li_elem) {
		$('selected_user').innerHTML = '<br /><strong>Selected User:</strong><br /><span>'+text_box.value+'</span><br /><br />';
		$('optional_button').innerHTML = '<input id="button_3" type="button" value="Create New Speaker" class="button" />';
		$('explanation').innerHTML = '<small>You have a user selected from our user database.  If you want to use this person then click the "Add" button below, otherwise click on the "Create New Speaker" button.</small>';
		$('button_2').value = 'Add "'+text_box.value+'"';
		// Set events
		Event.stopObserving($("button_2"), 'click', regular_submit);
		Event.observe($("button_2"), 'click', add_submit);
		Event.observe($("button_3"), 'click', regular_submit);
		// Ajax and assign
		current_selection = li_elem.id;
		new Ajax.Updater('selected_user_info', site_url+'event/show_user_info_ajax/'+li_elem.id);
		// show
		$('selected_area').setStyle({ display : 'block' });
	}
	function on_any_update(input_field, query_string) {
		if($('selected_user').innerHTML != ''){
			// Reset everything back to default
			$('selected_area').setStyle({ display : 'none' });
			Event.stopObserving($("button_3"), 'click', regular_submit);
			Event.stopObserving($("button_2"), 'click', add_submit);
			$('selected_user').innerHTML = '';
			$('selected_user_info').innerHTML = '';
			$('explanation').innerHTML = '';
			$('optional_button').innerHTML = '';
			$('button_2').value = 'Next Step';
			Event.observe($("button_2"), 'click', regular_submit);
			current_selection = false;
		}
		return query_string;
	}
	// Events
	function regular_submit(){
		window.location = site_url+'event/manage_candidate/<?=$event_id?>/none/'+$('display_name').value;
	}
	function add_submit(){
		window.location = site_url+'event/search_candidate/<?=$event_id?>/'+current_selection;
	}
</script>
<? $this->load->view('view_includes/footer.php'); ?>