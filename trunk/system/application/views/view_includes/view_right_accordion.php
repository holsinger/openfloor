<?
/*
	INSERT INTO `politic20`.`cms` VALUES  
	(37,'accordion',0x5768617420576520446F3A6163636F7264696F6E5F776861745F77655F646F2C486F7720497420576F726B733A6163636F7264696F6E5F686F775F69745F776F726B732C47657420537461727465643A6163636F7264696F6E5F6765745F737461727465642C57686F205765204172653A6163636F7264696F6E5F77686F5F77655F617265,'accordion','','',''),
	(38,'accordion_what_we_do',0x74686973206973207768617420776520646F21,'accordion_what_we_do','','',''),
	(39,'accordion_how_it_works',0x7468697320697320686F7720697420776F726B7321,'accordion_how_it_works','','',''),
	(40,'accordion_get_started',0x7468697320697320686F7720796F752063616E2067657420737461727465642E2E2E,'accordion_get_started','','',''),
	(41,'accordion_who_we_are',0x746869732069732077686F207765206172652E2E2E2E,'accordion_who_we_are','','','');
*/

$this->load->model('cms_model', 'cms');
$cms = $this->cms->get_cms($this->cms->get_id_from_url('accordion'));
$sections = explode(',', $cms['cms_text']);
?>

<!-- DEPENDENCIES
	#dependency /src/accordion.js
	#dependency accordion.css
-->

<script type="text/javascript" charset="utf-8">
	Event.observe(window, 'load', loadAccordions, false);
	
	function loadAccordions() {
		var bottomAccordion = new accordion('main_accordion', { onEvent : 'click', onChangeAccordion : ChangeAccordianStyle });
		bottomAccordion.activate($$('#main_accordion .accordion_toggle')[0]);
	}
	ChangeAccordianStyle.last_id = false;
	function ChangeAccordianStyle(content_id){
		pic_num = content_id.substring(3);
		if(ChangeAccordianStyle.last_id){
			$('left_img_'+ChangeAccordianStyle.last_id).src = "./images/accordion/left_off.png";
			$('right_img_'+ChangeAccordianStyle.last_id).src = "./images/accordion/right_off.png";
		}
		$('left_img_'+pic_num).src = "./images/accordion/left_on.png";
		$('right_img_'+pic_num).src = "./images/accordion/right_on.png";
		ChangeAccordianStyle.last_id = pic_num;
	}
</script>

<div id="main_accordion">
	<? $count= 0; ?>
	<? 	foreach($sections as $section):
			$section = explode(':', $section) ?>
			<table class="accordion_toggle" cellspacing="0" cellpadding="0">
				<tr>
					<td width="24" align="left"><img id="left_img_<?=$count?>" src="./images/accordion/left_off.png" border="0" /></td>
					<td width="100%" align="center" valign="middle" class="accordian_toggle_text"><?= $section[0] ?></td>
					<td width="24" align="right"><img id="right_img_<?=$count?>" src="./images/accordion/right_off.png" border="0" /></td>
				</tr>
			</table>
			<div class="accordion_content" id="ac_<?=$count?>">
				
				<? 	$content = $this->cms->get_cms($this->cms->get_id_from_url($section[1])); 
				echo $content['cms_text']; ?>
			</div>
			<? $count++; ?>
	<? endforeach; ?>
</div>