<? /*
	PAGE DESCRIPTION:
	This page displays the about us information, including bios for each person

	NOTES:
	TODO: Switch completely to using prototype events to load the ChangeAboutImage events on page load
*/ ?>
<!--
	#dependency /about_us.css
--> 
<?$data['left_nav'] = 'about_us';	?>
<?php $this->load->view('view_includes/header.php',$data); ?>
<div id="content_div">
        <h3>About Us</h3>
		<div id="loading_div">LOADING...</div>
		<div id="overall_outer_div">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="43" valign="top">
						<div style="margin-top: 130px">
							<img class="link" onclick="MoveBackwards();"  src="<?=base_url()?>images/about/RP_AboutUs_BackArrow.png" border="0" title="Move Backward">
						</div>
					</td>
					<td width="100%" id="main_content_td">
						<div  id="outer_about_div">
		            		<div id="inner_about_div">
								<? foreach($info as $name => $value): ?>
									<div id="<?=$name?>_div" style="float:left; width: <?=$info[$name]['img_size']?>px; overflow: visible;">
										<img id="<?=$name?>" src="<?=base_url()?>images/about/<?=$name?>_off.jpg" border="0" onmouseover="ChangeAboutImage(this, 'on');" onmouseout="ChangeAboutImage(this, 'off');">
									</div>
								<? endforeach; ?>
		            		</div>

						</div>
					</td>
					<td width="43" valign="top">
						<div style="margin-top: 130px">
							<img class="link" onclick="MoveForward();" src="./images/about/RP_AboutUs_ForwardArrow.png" border="0" title="Move Forward">
						</div>
					</td>
				</tr>
			</table>
			<!-- Moving Bio Div -->
			<div id="about_bio"> 
				<div style="font-weight: bold;" id="bio_name"></div>
				<div id="bio_content"></div>
			</div>
		</div>
		
</div>
<script type="text/javascript" charset="utf-8">
	var info = <?=json_encode($info);?>
	
	var about_bio_offset = 0;
	// ===================================================================================
	// = ChangeAboutImage - used for changing the profile images and displaying bio info =
	// ===================================================================================
	function ChangeAboutImage(elem, state){
		var div_pos = Position.positionedOffset($(elem));
		elem.src = "./images/about/"+elem.id+"_"+state+".jpg";
		
		if(state == 'on'){
			$('about_bio').style.visibility = 'visible';
			$('bio_name').innerHTML = eval('info.'+elem.id+'.name');	
			$('bio_content').innerHTML = eval('info.'+elem.id+'.bio;')+'<? if ($this->userauth->isSuperAdmin()) echo "<br>".anchor("admin/cms/about_us_'+elem.id+'", 'edit'); ?>';

			$('about_bio').setStyle({
				left: (div_pos[0] + about_bio_offset)+43+"px" // 43 is the size of the arrow image
			});
			
		}
		return true;
	}
	// =========================================
	// = Caches the onmouseover profile images =
	// =========================================
	<? foreach($info as $name => $value): ?>
		var img_<?=$name?> = new Image();
		img_<?=$name?>.src = "./images/about/<?=$name?>_on.jpg";
	<? endforeach; ?>
	// ======================
	// = Initialize Effects =
	// ======================
	var effects_active = true;
	function MoveBackwards()
	{
		if(effects_active){
		  	new Effect.Move('inner_about_div', { 
				x: 300, 
				y: 0, 
				transition: Effect.Transitions.sinoidal, 
				beforeStart	: function(){ effects_active = false; }, 
				afterFinish : function(){ effects_active = true; }
			});
		  	new Effect.Move('about_bio', { x: 300, y: 0, transition: Effect.Transitions.sinoidal });
			about_bio_offset += 300;
		}
	}

	function MoveForward()
	{
		if(effects_active){
		  	new Effect.Move('inner_about_div', { 
				x: -300, 
				y: 0, 
				transition: Effect.Transitions.sinoidal, 
				beforeStart	: function(){ effects_active = false; }, 
				afterFinish : function(){ effects_active = true; } 
			});
		  	new Effect.Move('about_bio', { x: -300, y: 0, transition: Effect.Transitions.sinoidal });
			about_bio_offset -= 300;			
		}

	}	
	// Ugly IE 6 Junk that keeps growing
	Event.observe(window, "load", onLoad);
	Event.observe(window, "resize", onResize);
	function onLoad(){
		$('outer_about_div').setStyle({
			width: $('main_content_td').offsetWidth+"px"
		});
		$('loading_div').innerHTML = '';
	}
	function onResize(){
		$('outer_about_div').setStyle({
			width: "0px"
		});
		onLoad();
	}
	

</script>
<? $this->load->view('view_includes/footer.php'); ?>