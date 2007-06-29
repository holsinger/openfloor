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
																<li class="<?=$tab_view_question;?>"><a href="index.php/question/queue/<?=$event_url;?>" class="published-questions">View Questions</a></li>
																<li class="<?=$tab_submit_question;?>"><a href="index.php/question/add/<?=$event_url;?>" class="submit-questions">Submit a Question</a></li>
														</ul>
														<? } ?>
														<!-- sort questions list start here -->
														<ul class="sort-questions">
															<? /*
															<li><strong>Sort news by:</strong></li>
															<li>Recently Popular</li>
															<li><a href="/index.php?part=today">Top Today</a></li>
															<li><a href="/index.php?part=yesterday">Yesterday</a></li>
															<li><a href="/index.php?part=week">Week</a></li>
															<li><a href="/index.php?part=month">Month</a></li>
															<li class="rss"><a href="">rss</a></li>
															*/?>
														</ul>
														<h2><!--Published News --></h2>
													</div>
													<div id="twocolumn">
																			
																			
																			
																			
																			