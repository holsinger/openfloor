<? 
include("./fckeditor/fckeditor.php");
$data['sub_title'] = $page_title;
$this->load->view('view_includes/header.php', $data);
?>
<!--
	#dependency autocomplete.css
-->
<div id="content_div">
  	<div class='errorArea'><?=$this->validation->error_string;?></div>
	<div id="account_form">
		<?= form_open_multipart(($user_id)?"event/manage_candidate/$event_id/$user_id":"event/manage_candidate/$event_id", array('name'=>'my_form')); ?>	
			<label>Speaker Display Name: *</label>
			<small>Type in the speakers name.  To avoid duplication, if the name matches an existing<br /> user then you can select him/her from the drop down box.</small><br />
			<input name="display_name" id="display_name" value="<?=$display_name?>" class="txt" size="48" maxlength="100">
			<span id="indicator1" style="display: none">Loading...</span>
			<div id="autocomplete_choices" class="autocomplete"></div>
			<div id="selected_user"></div>
			<div id="selected_user_info"></div>
			<br /><br />
			<br /><br />
			<input type="button" onclick="window.location='event/create_event_two/<?=$event_id?>';" class="button" value="Cancel">
			<?= form_submit('',($can_id)?"Update Speaker":"Next Step",'class="button"'); ?>
			<br /><br />
			<small>* required fields</small>
		<?= form_close(); ?>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
	new Ajax.Autocompleter("display_name", "autocomplete_choices", site_url+"event/user_name_from_search_ajax", {minChars: 3, indicator: 'indicator1', afterUpdateElement: after_update});
	function after_update(text_box, li_elem) {
		$('selected_user').innerHTML = text_box.value+ ", "+ li_elem.id;
	}
</script>
<? $this->load->view('view_includes/footer.php'); ?>