
						<? if (isset($pagination)) { ?>
		                <div class="pagers">
		                	<div class="list"	>
										<?= (isset($foot)) ? $foot:'';?>
										<!-- pagers list start here -->
										<ul>
											<?=(isset($pagination)) ? $pagination:'';?>
										</ul>
							</div>
						</div>
						<div style="clear:both;"></div>
						<? } ?>
                    <?
                    //set vars for right column
					//$data['rightpods'] = (isset($rightpods)) ? $rightpods:array('gvideo'=>array(),'gblog'=>array());
					if($rightpods != 'suppress'){
						$data['rightpods'] = (isset($rightpods)) ? $rightpods:array('events'=>array(),'dynamic'=>array());
						if (isset($cloud)) {
							$data['rightpods']['dynamic']['top_tags']= $cloud;
						} else {
							// $data['cloud'] = FALSE;
							$cloud = $this->tag_lib->createTagCloud(null);
							$data['rightpods']['dynamic']['top_tags']= $cloud;
						
						}
					
						if (!$admin) $this->load->view('view_layout/view_right_column.php',$data); 
					}
					?>
            	</tr>
            </table>
			</div>
            <div class="footer">Copyright &copy; 2007 RunPolitics.com. All Rights Reserved. Reproduction in whole<br />or part in any form or medium without express written permission is strictly prohibited.</div>
			<div class="contact_us">
	                <?=anchor("event/","EVENTS");?>
	                <span class="separator">|</span>
					<a href="<?=$this->config->site_url()?>contact/showForm/contact_us">CONTACT US</a>
					<span class="separator">|</span>
					<?=anchor("information/aboutUs","ABOUT US");?>
	                <span class="separator">|</span>
	                <?=anchor("information/view/faq","FAQ");?>
	                <span class="separator">|</span>
					<a href="http://blog.runpolitics.com">BLOG</a>
			</div>
        </div></div></div></div></div>
    </div>
	
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
    
    </script>
    
    <script type="text/javascript">
    
    _uacct = "UA-1010094-3";
    urchinTracker();
    </script>
</body>
</html>