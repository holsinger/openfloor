<? $this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
            <h3>About Us</h3>
			<div id="top_about_us">
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr><td align="center"><a href="javascript: var none = MoveBackwards();">Back</a> | <a href="javascript: var none = MoveForward();">Forward</a></td></tr>
				</table>
			</div>
			<div  id="outer_about_div" style="overflow: hidden; border: 0px solid #000000;">
	            <div id="inner_about_div" style="margin-left:10px; margin-right:30px; height: 344px; width: 4000px">
					<? foreach($info as $name => $value): ?>
						<div id="<?=$name?>_div" style="float:left; width: <?=$info[$name]['img_size']?>px; overflow: visible; ">
							<img id="<?=$name?>" src="./images/about/<?=$name?>_off.jpg" border="0" onmouseover="ChangeAboutImage(this, 'on');" onmouseout="ChangeAboutImage(this, 'off');">
							<div id="<?=$name?>_bio" style="background-color: #FFFFFF; positioning: relative; width: 250px;">
								<div id="bio_<?=$name?>_name"></div>
								<div id="bio_<?=$name?>_desc" style="background-color: #FFFFFF; positioning: relative; width: 250px;"></div>								
							</div>
				
						</div>
					<? endforeach; ?>
	            </div>
			</div>

			<div style="visibility: hidden; width: 250px; top: 600px; position: relative;" id="about_bio">
				<div id="bio_name"></div>
				<div id="bio_desc"></div>
				<? if ($this->userauth->isSuperAdmin()) echo "<div>".anchor('admin/cms/', 'edit')."</div>"; ?>
			</div>
</div>
<script type="text/javascript" charset="utf-8">
	var info = <?=json_encode($info);?>
	// ===================================================================================
	// = ChangeAboutImage - used for changing the profile images and displaying bio info =
	// ===================================================================================
	ChangeAboutImage.last_elem_id;
	function ChangeAboutImage(elem, state){
		elem.src = "./images/about/"+elem.id+"_"+state+".jpg";
		if(state == 'on'){
			$('about_bio').style.visibility = 'visible'
			if (ChangeAboutImage.last_elem_id) {
				$('bio_'+ChangeAboutImage.last_elem_id+'_name').innerHTML = '';
				$('bio_'+ChangeAboutImage.last_elem_id+'_desc').innerHTML = '';				
			};
			$('bio_'+elem.id+'_name').innerHTML = '<h1>'+eval('info.'+elem.id+".name")+'</h1>';
			$('bio_'+elem.id+'_desc').innerHTML = eval('info.'+elem.id+".bio")+'<? if ($this->userauth->isSuperAdmin()) echo "<br>".anchor("admin/cms/about_us_'+elem.id+'", 'edit'); ?>';
			$('about_bio').style.left = $(elem.id).offsetLeft+'px';
		}
		ChangeAboutImage.last_elem_id = elem.id;
		return true;
	}
	// =========================================
	// = Caches the onmouseover profile images =
	// =========================================
	
	
	function MoveBackwards()
	{
	  new Effect.Move('inner_about_div', { x: 600, y: 0, transition: Effect.Transitions.sinoidal });
	}

	function MoveForward()
	{
	  new Effect.Move('inner_about_div', { x: -600, y: 0, transition: Effect.Transitions.sinoidal });
	}	
</script>
<? $this->load->view('view_includes/footer.php'); ?>