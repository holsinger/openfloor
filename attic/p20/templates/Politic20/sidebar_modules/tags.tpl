{php}
	include_once(mnminclude.'tags.php');
	global $main_smarty;
	
	$cloud=new TagCloud();
	$cloud->smarty_variable = $main_smarty; // pass smarty to the function so we can set some variables
	$cloud->word_limit = 5;
	$cloud->min_points = 6; // the size of the smallest tag
	$cloud->max_points = 15; // the size of the largest tag
	
	$cloud->show();
	$main_smarty = $cloud->smarty_variable; // get the updated smarty back from the function
{/php}

														<h3>
														{php}
															echo "<a onclick=\"new effect.toggle('s2','blind', {queue: 'end'}); \" class=\"close\">close</a>";
														{/php}
															<span class="top-tags">{#PLIGG_Visual_Top_5_Tags#}</span></h3>
														<div class="box" id="s2">
														{section name=customer loop=$tag_number}
														
															{* --- to change the way the words are displayed, change this part --- *}
																<ul class="list-rss">
																	<li><a href="{$tag_url[customer]}">{$tag_name[customer]}</a></li>
																</ul>
															{* ---		--- *}
															
														{/section}
															<a href="{$URL_tagcloud}" class="more">{#PLIGG_Visual_What_Is_Pligg_Read_More#} &raquo;</a>
														</div>
														<div class="box-bottom"></div>