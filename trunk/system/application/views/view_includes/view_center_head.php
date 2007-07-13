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
																<li class="<?=$tab_view_question;?>"><a href="index.php/question/queue/<?=$event_url;?>" class="published-questions">View <?=$tabs;?>s</a></li>
																<li class="<?=$tab_submit_question;?>"><a href="index.php/question/add/<?=$event_url;?>" class="submit-questions">Submit a <?=$tabs;?></a></li>
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
																			
																			
																			
																			
																			