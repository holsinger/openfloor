<? $this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
            <h3>About Us</h3>
            <div style="margin-left:10px;margin-right:30px;">
					<? foreach($names as $name): ?>
						<div id="<?=$name?>_div" style="float:left; width: <?=$size[$name]?>px; overflow: visible; ">
							<img id="<?=$name?>" src="./images/about/<?=$name?>_off.jpg" border="0" onmouseover="ChangeAboutImage(this, 'on');" onmouseout="ChangeAboutImage(this, 'off');">
							<div id="<?=$name?>_bio" style="background-color: #FFFFFF; positioning: relative; <? //if($names[(count($names) - 1)] == $name){ echo "width: 150px;"; }else{ echo "width: 250px;"; }?>">
								<div id="bio_<?=$name?>_name"></div>
								<div id="bio_<?=$name?>_desc"></div>								
							</div>
							
						</div>
					<? endforeach; ?>
            </div>
			<div style="visibility: hidden; width: 250px; top: 600px; position: relative;" id="about_bio">
				<div id="bio_name"></div>
				<div id="bio_desc"></div>
				<? if ($this->userauth->isSuperAdmin()) echo "<div>".anchor('admin/cms/', 'edit')."</div>"; ?>
			</div>
</div>
<script type="text/javascript" charset="utf-8">

	var info = {
		daniel : {
			name: "Daniel Holsinger",
			bio: "Daniel is a great guy"
		},
		james : {
			name: "James Klienschnitz",
			bio: "James is a great guy"
		},
		kenshi : {
			name: "Kenshi Westover",
			bio: "Kenshi is a great guy" 
		},
		rob : {
			name: "Rob ",
			bio: "Rob is a great guy" 
		},
		matt : {
			name: "Matt Moon", 
			bio: "Matt Moon is currently the Chief Political Officer of RunPolitics.com . Matt Moon graduated from Harvard University (Cambridge, MA) in June 2005 with a Bachelor's degree in Environmental Science & Public Policy and a Master's degree in History of Science, where he focused on the politics of science and communication of science-based issues. During his years at Harvard, Matt worked on several statewide campaigns in Alaska and New England, and was a research associate at the Institute of the North, a public policy think tank in Alaska focusing on economic development policy and politics. From 2005 to 2006, Matt was a lead public outreach coordinator and environmental consultant within the regulatory and technical affairs department at Arctic Slope Regional Corporation. In 2006, Matt ran for a seat in the Alaska State Legislature and was the Republican nominee for House District 20; he lost in the general election by a little more than 500 votes. Matt was most recently a political communications consultant for several city council races in Anchorage." 
		},
		brady : {
			name: "Brady Uselman", 
			bio: "My name is Brady Uselman. A little about me, I grew up in New Mexico and I have lived here in Salt Lake City the last 6 years of my life. I have a wide range of interests and hobbies. I enjoy home construction projects, reading and lately, rock climbing. My fiancée and I love to travel, host dinner parties and enjoy all that Utah has to offer.  At the time I was hired by RunPolitics I had just completed my doctoral studies in Physical Chemistry at the University of Utah. Some may ask what interest does RunPolitics have in a Chemist and I in a Web 2.0 company? I have always had an interest in applied science and technology. While I have been interested in Chemistry for some time, I am more interested in the scientific method and the opportunity of applying my skill set to new and dynamic problems. It is my intention to assist in the design and implementation of several RunPolitics upcoming products, enabling the Web 2.0 community to interact in Politics in new and amazing ways."
		}	
	};
	// ===================================================================================
	// = ChangeAboutImage - used for changing the profile images and displaying bio info =
	// ===================================================================================
	ChangeAboutImage.last_elem_id;
	function ChangeAboutImage(elem, state){
		elem.src = "./images/about/"+elem.id+"_"+state+".jpg";
		if(state == 'on'){
			$('about_bio').style.visibility = 'visible'
			$('bio_'+elem.id+'_name').innerHTML = '<h1>'+eval('info.'+elem.id+".name")+'</h1>';
			//$('bio_'+elem.id+'_desc').innerHTML = eval('info.'+elem.id+".bio");
			$('bio_'+ChangeAboutImage.last_elem_id+'_name').innerHTML = '';
			//$('bio_'+ChangeAboutImage.last_elem_id+'_desc').innerHTML = '';
			$('about_bio').style.left = $(elem.id).offsetLeft+'px';
		}
		ChangeAboutImage.last_elem_id = elem.id;
		return true;
	}
	// =========================================
	// = Caches the onmouseover profile images =
	// =========================================
	
</script>
<? $this->load->view('view_includes/footer.php'); ?>