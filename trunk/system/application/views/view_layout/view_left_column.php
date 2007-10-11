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

											<h1>EVENTS</h1>
											
	                    <a onclick="showBox('event_dashboard');window.open(site_url + 'conventionnext/cp/<?=str_replace('event/','',$event_url);?>', '_blank', 'width=1015,height=700,scrollbars=yes,status=no,resizable=yes,screenx=0,screeny=0');" href="javascript:void(0);"><h2>Dashboard</h2></a>
	                    <? /* <div id='event_pop' style="position:absolute;left:90px;top:188px;z-index:3000;"><img src="images/live_pop.gif" onLoad="new Effect.Shake($('event_pop')); window.setTimeout('Effect.Squish(\'event_pop\', {duration:.3})',4000);"></div> */?>

											<h1>EVENT</h1>
	                    <h2>Questions</h2>
	                    <?=anchor("question/add/{$event_url}","Ask a Question");?>
	                    <?= anchor("forums/queue/{$event_url}","View Upcoming");?>
	                    <?= anchor("forums/queue/{$event_url}/sort/newest","View Newest");?>
	                    <?= anchor("forums/queue/{$event_url}/sort/asked","View Asked");?>

											<br />
											<span onClick="showBox('event_instructions');" class="link">Help</span>
	                    <?
											break;
											case 'events':
											?>
											<h1>EVENTS</h1>
											<br/>
	                    Click on an <i>Event Name</i> to get started.
											<br />
											<br />
											<br />
											<span onClick="showBox('event_instructions');" class="link">Help</span>
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
											default:
											?>
											
											<?
											break;
											}
											?>
						
	                </div>