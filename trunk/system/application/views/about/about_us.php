<!--
	TODO Switch completely to using prototype events so that there is no chance of getting an error of ChangeAboutImage not being set before it's loaded.  (add events on load)
-->
	
	
<?php $this->load->view('view_includes/header.php',$data); ?>
<div id="content_div">
        <h3>About Us</h3>
		<div id="loading_div" style="position: relative; font-size: 2em; text-align: center;">LOADING...</div>
		<div style="position: relative; overflow: hidden; width: 100%">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="43" valign="top">
						<div style="margin-top: 130px">
							<img class="link" onclick="MoveBackwards();"  src="<?=base_url()?>images/about/RP_AboutUs_BackArrow.png" border="0" title="Move Backward">
						</div>
					</td>
					<td width="100%" id="main_content_td">
						<div  id="outer_about_div" style="position: relative; overflow: hidden; width: 0px; height: 700px; border: 0px solid #000000; z-index: 3;">
		            		<div id="inner_about_div" style="position: relative; height: 344px; width: 4000px; z-index: 2;">
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
			<div style="visibility: hidden; width: 250px; top: 350px; position: absolute; margin-top: 10px" id="about_bio"> 
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
	// Ugly IE 6 Junk
	Event.observe(window, "load", onLoad);
	function onLoad(){
		$('outer_about_div').setStyle({
			width: $('main_content_td').offsetWidth+"px"
		});
		$('loading_div').innerHTML = '';
	}
</script>
<? $this->load->view('view_includes/footer.php'); ?>