<? 
//set vars the will detemine the head tag 
$data['browser'] = $this->agent->browser();
$data['browserVer'] = $this->agent->version();

//setup onLoad array
if (isset($data['js_onload']) && is_array($data['js_onload'])) {
	$onload = implode('();',$data['js_onload']).'();';
}else{
	$onload = 'init();';
} 
$this->load->view('view_layout/view_head_setup.php',$data);
?>
<body onLoad='<?=$onload;?>'>
	<div id="advertisement">
		<div class="box ad" id="adzone_1">
			<iframe src="<?=$this->config->item('m1_url')?>/AdFrame.php?adzoneid=1" frameborder="0" scrolling="no" width="728" height="90" marginwidth="0" marginheight="0"></iframe>
		</div>
		<div class="adv">Advertisement</div> 
	</div>
    <div id="wrapper">
		<div id="header">
			<div xmlns="" class="breadcrumbs">
				<a class="selected" href="/" title="">ManyOne Home</a>
				<span>&gt;</span>
				<a href="#" title="Portal Home &gt; Topic Home">...</a>
				<span>&gt;</span>
				<a href="/communities/groups/profile/1102/" title="">Global Politics</a>
				<span>&gt;</span>
				<a href="/communities/groups/profile/1078/" title="">US Politics </a>
				<span>&gt;</span>
				<a href="/communities/groups/topics/view/1078/8773/" title="">2008 Campaigns</a>
				<span class="last">&gt;</span>
				Northwest
			</div>
			<div id="dashboard" class="clearfix"><ul xmlns="" class="loginmenu"><li><a href="<?=$this->config->item('m1_url')?>/register/">Join Now</a> |</li><li><a href="<?=$this->config->item('m1_url')?>/login/">Login</a></li></ul></div>
			<div class="box main-logo-wrapper" id="zmid_21">
  				<div id="logo" class="portal-scope user-logo-image">
				    <a href="/communities/groups/profile/1078/">
				      <img src="images/many_one/USpolitcis.gif" alt="US Politics"/>
				    </a>
				 </div>
			</div>
			<div class="box main-banner-wrapper  portalImg" id="zmid_22">
  				<div id="banner" class="portal-scope user-banner" style="height:118px;background-image:url('images/many_one/oldflag.jpg');"> </div>
			</div>
			<div class="box main-navigation" id="zmid_23">
  				<ul id="mainnav" class="portal-scope">
    				<li id="nav_170" class="selected ">
      					<a class="selected " href="<?=$this->config->item('m1_url')?>/communities/groups/profile/1078/?topic=8774">Portal Home</a>
    				</li>
    				<li id="nav_174">
      					<a href="<?=$this->config->item('m1_url')?>/communities/groups/members/1078/?topic=8774">Members</a>

    				</li>
    				<li id="nav_1064" class="last ">
      					<a class="last " href="<?=$this->config->item('m1_url')?>/communities/groups/all/1078/?topic=8774">View All</a>
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