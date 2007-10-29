<?php

?>
				<div class="col-left">
	                    
						          <?
											switch ($left_nav) {
											case 'main':
							                    ?>
							                    <h1>FIND MORE</h1>
							                    <h2>Political</h2>
							                    <a href="http://media.runpolitics.com/category/policy/">Policy</a>
							                    <a href="http://media.runpolitics.com/category/elections/">Elections</a>
							                    <a href="http://media.runpolitics.com/category/beltway/">Beltway</a>
							                    <a href="http://media.runpolitics.com/category/commentary/">Commentary</a>
							                    <a href="http://media.runpolitics.com/category/hot-topics/">Hot Topics</a>															
												<a href="http://media.runpolitics.com/">All</a>
											
												<br /><br />
												<form id="searchform" action="http://media.runpolitics.com/" method="get">
												<input id="s" type="text" name="s" size="15" value=""/>
												<input id="searchsubmit" type="submit" value="Search"/>
												</form>	
												<?
											break;
											case 'event':
											?>
												<!-- <h1>EVENTS</h1> -->
											
							                    <? /* <div id='event_pop' style="position:absolute;left:90px;top:188px;z-index:3000;"><img src="images/live_pop.gif" onLoad="new Effect.Shake($('event_pop')); window.setTimeout('Effect.Squish(\'event_pop\', {duration:.3})',4000);"></div> */?>

												<h1>EVENT</h1>
												<div class="col_left_item_container">
								                    <h2>Questions</h2>
								                    
								                    <?=anchor("question/add/{$event_url}","Ask a Question");?>
								                    <?= anchor("forums/queue/{$event_url}","View Upcoming");?>
								                    <?= anchor("forums/queue/{$event_url}/sort/newest","View Newest");?>
								                    <?= anchor("forums/queue/{$event_url}/sort/asked","View Asked");?>
													<h2>RSS Feeds</h2>
													<?= anchor('feed/events', 'Events Feed') ?>
													<?= anchor("feed/$event_url", 'This Event\'s Question Feed') ?>
													<br />
													<span onClick="showBox('event_instructions');" class="help">HELP</span>
												</div>
	                    					<?
											break;
											case 'events':
											?>
												<h1>EVENTS</h1>
												<div class="col_left_item_container">
			                    					Click on an <i>Event Name</i> to get started.
													<br />
													<br />
													<a href="javascript: var none = new Effect.ScrollTo($('upcoming_events_title'));">Upcoming Events</a>
													<a href="javascript: var none = new Effect.ScrollTo($('past_events_title'));">Past Events</a>
													<br />
													<h2>RSS Feeds</h2>
													<?= anchor('feed/events','All Events');?>
	 												<br />

													<span onClick="showBox('event_instructions');" class="help">HELP</span>
												</div>
	                    					<?
											break;
											case 'admin':
											?>
												<h1>Admin</h1>
							                    <h2>Candidate</h2>
							                    <?echo anchor('forums/create/candidate','Add Candidate');?><br/>
						    									<h2>CMS</h2>
							                    <?echo anchor('admin/view','View All');?>
							                    <?echo anchor('admin/','Add New');?>
						                    <?
											break;
											case 'about_us':
											?>
												<h1>About Us</h1>
												<div class="col_left_item_container">
			                    					Hover over an individual to view their bio.
												</div>
						                    <?
											break;
											default:
											?>
											
											<?
											break;
											}
											?>
						
	                </div>