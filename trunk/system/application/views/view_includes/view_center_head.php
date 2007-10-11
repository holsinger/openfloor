<?php

?>
				<div id="content">
					<div class="c-frame">
						<div class="c-bl">
							<div class="c-br">

								<div class="ct-l">
									<div class="c-tr">
										<div class="bg2">
											<div class="bg3">
												<div class="bg">
													<div class="top-box">
														<strong class="read_head"><?=$red_head;?></strong>
														<!-- local (sub) navigation start here -->

														<? if ($tabs) { ?>
														<ul class="local-nav">
																<li class=""><a onclick="showBox('event_dashboard');window.open(site_url + 'forums/cp/<?=str_replace('event/','',$event_url);?>', '_blank', 'width=850,height=700,scrollbars=yes,status=no,resizable=yes,screenx=0,screeny=0');" href="javascript:void(0);" class='published-questions'>Event Dashboard</a></li>
																<li class="<?=$tab_view_question;?>"><?=anchor("forums/queue/{$event_url}","View {$tabs}s","class='published-questions'");?></li>
																<?if (strtolower($tabs) == 'question') { ?>
																	<li class="<?=$tab_submit_question;?>"><?=anchor("question/add/{$event_url}","Submit a {$tabs}","class='submit-questions'");?></li>
																<?} else if (strtolower($tabs) == 'video') { ?>
																	<li class="<?=$tab_submit_question;?>"><?=anchor("video/add/{$event_url}","Submit a {$tabs}","class='submit-questions'");?></li>
																<?}?>	
														</ul>
														<? } ?>
														<!-- sort questions list start here -->
														<?
														$attributes = array(
											                    'class' => 'sort-questions',
											                    'id'    => 'sort-questions'
											                    );
														if (is_array($sort_array)) echo ul($sort_array,$attributes);
											      ?>
														<h2><!--Published News --></h2>
														
														<?
														echo nbs(6);
														foreach ($breadcrumb as $key => $link) echo anchor($link,$key)."&nbsp;>&nbsp;";
														?>
													</div>
													<div id="twocolumn">
																			
																			
																			
																			
																			