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
	                </div>
                </div>
                    <?
                    //set vars for right column
										//$data['rightpods'] = (isset($rightpods)) ? $rightpods:array('gvideo'=>array(),'gblog'=>array());
										$data['rightpods'] = (isset($rightpods)) ? $rightpods:array('events'=>array(),'gvideo'=>array(),'gblog'=>array(),'dynamic'=>array());
										if (isset($cloud)) {
											$data['rightpods']['dynamic']['tag_cloud']= $cloud;
										} else $data['cloud'] = FALSE;
										
										if (!$admin) $this->load->view('view_layout/view_right_column.php',$data); 
										?>
                    
            </div>
            
            <div class="footer">Copyright &copy; 2007 RunPolitics.com. All Rights Reserved. Reproduction in whole<br />or part in any form or medium without express written permission is strictly prohibited.</div>
			<div class="contact_us"><a href="<?=$this->config->site_url()?>contact/showForm/contact_us">Contact Us</a></div>
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