<? 
include("./fckeditor/fckeditor.php");
$setup['sub_title'] = $page_title;
$setup['head_include'] = array("plaxo");
$this->load->view('view_layout/header.php', $setup);
?>
<!--
	#dependency events.css
	#dependency event_widget.css
	#dependency colorpicker.js
-->

<div id="content_div">
  	<div class='errorArea'><?=$this->validation->error_string;?></div>
	<div id="account_form">
		<?= form_open("event/create_event_four/$event_id/$option", array('name'=>'my_form')); ?>
			<h3>Event Theme</h3>
			example:
			<div id="ucp" style="border:2px dotted #CCCCCC;padding:3px;">
				<div class="section">
					<h3 id="question_title">Question Heading</h3>
				</div>
				<div>
				  <b class="qpod">
				  <b class="qpod1"><b></b></b>
				  <b class="qpod2"><b></b></b>
				  <b class="qpod3"></b>
				  <b class="qpod4"></b>
				  <b class="qpod5"></b></b>
					<div class="qpodfg question-pod-container" id="question_container_176">
						  <div class="question-podfg">
							<table style="margin-top: 5px; margin-bottom: 5px;" cellpadding="0" cellspacing="0">
								<tbody><tr>
									<td style="padding-left: 5px;"><div class="score" title="Question Score">0</div></td>
									<td><div class="vote">	<img src="./images/<?= $this->config->item('custom_theme');?>/thumbsUp.png" alt="Vote Up" title="Vote Up">
										<img src="./images/<?= $this->config->item('custom_theme');?>/thumbsDown.png" alt="Vote Down" title="Vote Down">
									</div></td>
									<td width="100%">
										<div class="question">
											<a href="http://localhost/m1//user/profile/jimmy"><img class="sc_image" src="./avatars/shrink.php?img=cf266383ff813b587fbc9e479780fa9f.jpg&amp;w=16&amp;h=16"></a>&nbsp;
											This is the question text?
										</div>
									</td>
									<td><div class="flag"><!-- <img src="./images/flag.png"> --></div></td>
								</tr>
							</tbody></table>
							<div id="cp_tab_body_176" class="cp-comments" style="overflow: auto; display: none;"></div>	
						</div>
					</div>
				  <b class="qpod">
				  <b class="qpod5"></b>
				  <b class="qpod4"></b>
				  <b class="qpod3"></b>
				  <b class="qpod2"><b></b></b>
				  <b class="qpod1"><b></b></b></b>
				</div>	
				
				<!-- TABS -->
				<div id="cp_votes_tab_176" class="votes" title="Vote History" >3 votes</div>
				<div id="cp_comments_tab_176" class="comments" title="Comments">3 comments</div>
				<div id="cp_info_tab_176" class="info" title="More Info">more info</div>
				<div id="cp_admin_tab_176" class="admin" title="Admin">Admin</div>
				<div style="clear: both;"></div>
			</div>
			
			<br/>
			<div id="theme_options">
				<div class="theme_section">
					<span>Theme Header Color:</span><input type="text" name="theme_header" value="<?=$theme_header?>" id="theme_header" class="txt" style="width:60px;">
				</div>
				<div class="theme_section">
					<span>Theme Link/Clickable Color:</span><input type="text" name="theme_header" value="<?=$theme_header?>" id="theme_header" class="txt" style="width:60px;">
				</div>
				<div class="theme_section">
					<span>Theme Element Background Color:</span><input type="text" name="theme_header" value="<?=$theme_header?>" id="theme_header" class="txt" style="width:60px;">
				</div>
				<div class="theme_section">
					<span>Theme Text Color:</span><input type="text" name="theme_header" value="<?=$theme_header?>" id="theme_header" class="txt" style="width:60px;"></div>
				</div>
				<div style="clear: both;"></div>
			</div>
	</div>
</div>

<? $this->load->view('view_layout/footer.php'); ?>