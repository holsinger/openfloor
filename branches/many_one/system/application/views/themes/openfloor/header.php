<body onLoad='<?=$onload;?>'>
	<!--
		#dependency <?= $this->config->item('custom_theme');?>_globalReset.css
		#dependency <?= $this->config->item('custom_theme');?>_global.css
	-->
	<?$this->load->view("ajax/{$this->config->item('custom_theme')}_login",$data);?>
	<br/>
    <div id="wrapper">
		<div id="header">
			<div xmlns="" class="breadcrumbs">
			</div>
			<div id="dashboard" class="clearfix">
				<ul xmlns="" class="loginmenu">
					<? if (strlen($this->session->userdata['user_name'])>1) {?>
					<li style="color:#444D3E;">Welcome <?=$this->session->userdata['user_name'];?></li>
					<li><a href='logout/'>Logout</a></li>				
					<?} else {?>	
					<li><a href='#login' class='lightview' title=' :: :: autosize: true, topclose:true' >Login</a></li>					
					<?}?>
				</ul>
			</div>
			<div class="box main-banner-wrapper  portalImg" id="zmid_22">
  				<div id="banner" class="portal-scope user-banner"> <img src="<?=$this->config->item('custom_theme_dir');?><?=$this->config->item('custom_theme');?>/logo_head.png" height="118"></div>
			</div>
			<div class="box main-navigation" id="zmid_23">
  				<ul id="mainnav" class="portal-scope">
    				<li class="selected ">
      					<a class="selected " href="<?= $this->config->site_url();?>">Home</a>
    				</li>
					
  				</ul>
			</div> 
		</div>
      	<div id="container">
			<? /*
        	<div id="leftnav" class="sash">
				<div class="left_sash_nav_title box" id="topics">
					<h3><a href="/topics/">Navigation</a></h3>
					<form enctype="multipart/form-data" id="topics_search" name="topics_search" class="content-form" method="post" action="">
						<fieldset>
							<div>
								<div class="iefix nolabel">
									<input id="topics-search" name="topics_search" onFocus="return setTopicfocus(this.form.name)" value="Search Portals &amp; Topics" type="text" class="text" />
									<input id="search-button" value="GO" src="/themes/newbase/i/button_go.gif" type="image" class="image" name="search-button" />
									<input name="__module" value="FlashNavigation" type="hidden" class="hidden" />
								</div>
							</div>
						</fieldset>
					</form>
				</div>
				<div id="flashnav-wrapper-outer">
					<div id="flashnav-wrapper-inner">
					</div>
				</div>
				<div id="flashnav-curtain"></div>
				<div id="left_sash_nav_box_default"></div>
				<div id="flashxml" style="display: none;"></div> 
			</div> 
			*/ ?>
    		<div id="content" style="width:96%; margin: 0% 2% 2% 2%;">
			<div><h1><?=$sub_title?></h1></div>