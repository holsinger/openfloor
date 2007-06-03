<?php

	include('../config.php');
	require(mnminclude.'link.php'); 
	require(mnminclude.'tags.php'); 
	require('./libs/rssimport.php'); 

	require_once('../3rdparty/magpierss/rss_fetch.inc');
	define('MAGPIE_CACHE_DIR', '../templates_c');


	$RSSImport=new RSSImport;
	
	$feeds_list = $RSSImport->get_feeds_lists();
	
	if(!$feeds_list){
		die("You have not setup any feeds yet!");
	}

	foreach ($feeds_list as $feed) {
		$url = $feed->feed_url;

		$rss = fetch_rss($url);
		
		echo "<h1>Site: ", $rss->channel['title'], "</h1><hr>";
		if ((time() - ($feed->feed_freq_hours * 3600)) > strtotime($feed->feed_last_check) || $_GET['override'] == $feed->feed_id){
			$MyArray = array();
			$Feed_Links = $RSSImport->get_feed_field_links($feed->feed_id);
			if(count($Feed_Links) > 0){
				foreach ($Feed_Links as $link ) {
					if($link->pligg_field == 'link_title'){$MyArray['title'] = $link->feed_field;}
					if($link->pligg_field == 'link_content'){$MyArray['content'] = $link->feed_field;}
					if($link->pligg_field == 'link_url'){$MyArray['link_url'] = $link->feed_field;}
					if($link->pligg_field == 'link_tags'){$MyArray['link_tags'] = $link->feed_field;}
					if($link->pligg_field == 'link_field1'){$MyArray['link_field1'] = $link->feed_field;}
					if($link->pligg_field == 'link_field2'){$MyArray['link_field2'] = $link->feed_field;}
					if($link->pligg_field == 'link_field3'){$MyArray['link_field3'] = $link->feed_field;}
					if($link->pligg_field == 'link_field4'){$MyArray['link_field4'] = $link->feed_field;}
					if($link->pligg_field == 'link_field5'){$MyArray['link_field5'] = $link->feed_field;}
					if($link->pligg_field == 'link_field6'){$MyArray['link_field6'] = $link->feed_field;}
					if($link->pligg_field == 'link_field7'){$MyArray['link_field7'] = $link->feed_field;}
					if($link->pligg_field == 'link_field8'){$MyArray['link_field8'] = $link->feed_field;}
					if($link->pligg_field == 'link_field9'){$MyArray['link_field9'] = $link->feed_field;}
					if($link->pligg_field == 'link_field10'){$MyArray['link_field10'] = $link->feed_field;}
					if($link->pligg_field == 'link_field11'){$MyArray['link_field11'] = $link->feed_field;}
					if($link->pligg_field == 'link_field12'){$MyArray['link_field12'] = $link->feed_field;}
					if($link->pligg_field == 'link_field13'){$MyArray['link_field13'] = $link->feed_field;}
					if($link->pligg_field == 'link_field14'){$MyArray['link_field14'] = $link->feed_field;}
					if($link->pligg_field == 'link_field15'){$MyArray['link_field15'] = $link->feed_field;}
				}
			
			
				$thecount = 0;
				foreach (array_reverse($rss->items) as $item) {
					echo "Title: " . get_val($item, $MyArray['title']) . "<br>";
					echo "Content: " . get_val($item, $MyArray['content']) . "<br>";
					echo "URL: " . get_val($item, $MyArray['link_url']) . "<hr>";
					
					$skipthis = 0;
					$linkres=new Link;
					$linkres->randkey = rand(10000,10000000);
					$linkres->status=$feed->feed_status;
					$linkres->author=$feed->feed_submitter;
				  	$linkres->title=get_val($item, $MyArray['title']);
					$linkres->title = strip_tags($linkres->title);
					$linkres->tags = get_val($item, $MyArray['link_tags']);
					$linkres->title_url = makeUrlFriendly($linkres->title);
					$linkres->url=get_val($item, $MyArray['link_url']);
					$linkres->url_title=$linkres->title;
				  	$linkres->content=get_val($item, $MyArray['content']);
					$linkres->content = strip_tags($linkres->content, Story_Content_Tags_To_Allow);
					$linkres->content = str_replace("\n", "<br />", $linkres->content);
				  	$linkres->link_field1=get_val($item, $MyArray['link_field1']);
					$linkres->link_field2=get_val($item, $MyArray['link_field2']);
					$linkres->link_field3=get_val($item, $MyArray['link_field3']);
					$linkres->link_field4=get_val($item, $MyArray['link_field4']);
					$linkres->link_field5=get_val($item, $MyArray['link_field5']);
					$linkres->link_field6=get_val($item, $MyArray['link_field6']);
					$linkres->link_field7=get_val($item, $MyArray['link_field7']);
					$linkres->link_field8=get_val($item, $MyArray['link_field8']);
					$linkres->link_field9=get_val($item, $MyArray['link_field9']);
					$linkres->link_field10=get_val($item, $MyArray['link_field10']);
					$linkres->link_field11=get_val($item, $MyArray['link_field11']);
					$linkres->link_field12=get_val($item, $MyArray['link_field12']);
					$linkres->link_field13=get_val($item, $MyArray['link_field13']);
					$linkres->link_field14=get_val($item, $MyArray['link_field14']);
					$linkres->link_field15=get_val($item, $MyArray['link_field15']);
				  	$linkres->category=$feed->feed_category;
					$linkres->link_summary = utf8_substr($linkres->content, 0, StorySummary_ContentTruncate - 1);					
		
		
					if($thecount >= $feed->feed_item_limit && $skipthis == 0){
						echo "Reached import limit, skipping<HR>";
						$skipthis = 1;
					}
		
				  
				  if($feed->feed_title_dupe == 0 && $skipthis == 0){  // 0 means don't allow, 1 means allow
			      if($linkres->duplicates_title($linkres->title) > 0) {
			      	echo "Title Match, skipping: " . $linkres->title . "<HR>";
			      	$skipthis = 1;
			      }
					}	
					
				  if($feed->feed_url_dupe == 0 && $linkres->url != "" && $skipthis == 0){  // 0 means don't allow, 1 means allow
			      if($linkres->duplicates($linkres->url) > 0) {
			      	echo "URL Match, skipping: " . $linkres->title . "<HR>";
			      	$skipthis = 1;
			      }
					}	
						  
					if ($skipthis == 0) {
						echo "Importing <hr>";
						$linkres->store();
						tags_insert_string($linkres->id, $dblang, $linkres->tags);
						
						require_once(mnminclude.'votes.php');
						for($i=1; $i <= $feed->feed_votes ; $i++){
							$value=10;
							$vote = new Vote;
							$vote->type='links';
							$vote->user=0;
							$vote->link=$linkres->id;
							$vote->ip='0.0.0.' . $i;
							$vote->value=$value;						
							$vote->insert();
							$vote = "";
							
							$vote = new Vote;
							$vote->type='links';
							$vote->link=$linkres->id;
							$linkres->votes=$vote->count();
							$linkres->store_basic();
							$linkres->check_should_publish();					
						}
												
						$thecount = $thecount + 1;
					}
				}
	
				$sql = "Update `" . table_prefix . "feeds` set `feed_last_check` = FROM_UNIXTIME(" . (time()-300) . ") where `feed_id` = $feed->feed_id;";
				//echo $sql;
				$db->query($sql);
				
			} else {
				echo "Feed not fully setup, skipping <hr>";
			}
		} else {
			echo "Feed Frequency is " . $feed->feed_freq_hours . ".<br>";
			$x = strtotime($feed->feed_last_check);
			$y = (time() - ($feed->feed_freq_hours * 3600));
			echo "Next run in " . (intval(($x - $y) / 60 / 60* 100) / 100) . " hours.";
			echo '<br><a href = "?override='.$feed->feed_id.'">Run Anyway</a><hr>';
		}
	}


	function get_val($item, $theField){
		$nestPos = strpos($theField, "_ne_st_ed_");
		if ($nestPos > 0){
			$first = substr($theField, 0 , $nestPos);
			$second = trim(substr($theField, $nestPos + 10, 100));
			return trim($item[$first][$second]);
		} else {
			return trim($item[$theField]);
		}
	}
?>