<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".


function tags_normalize_string($string) {
	$string = preg_replace('/[\.\,] *$/', "", $string);
	return utf8_strtolower($string);
}

function tags_insert_string($link, $lang, $string, $date = 0) {
	global $db;

	$string = tags_normalize_string($string);
	if ($date == 0) $date=time();
	$words = preg_split('/[,;]+/', $string);
	if ($words) {
		$db->query("delete from " . table_tags . " where tag_link_id = $link");
		foreach ($words as $word) {
			$word=trim($word);
			if (!$inserted[$word] && !empty($word)) {
				$db->query("insert into " . table_tags . " (tag_link_id, tag_lang, tag_words, tag_date) values ($link, '$lang', '$word', from_unixtime($date))");
				$inserted[$word] = true;
			}
		}
		return true;
	}
	return false;

}

function tags_get_string($link, $lang) {
	global $db;

	$counter = 0;
	$res = $db->get_col("select tag_words from " . table_tags . " where tag_link_id=$link and tag_lang='$lang'");
	if (!$res) return false;

	foreach ($db->get_col("select tag_words from " . table_tags . " where tag_link_id=$link and tag_lang='$lang'") as $word) {
		if($counter>0)  $string .= ', ';
		$string .= $word;
		$counter++;
	}
	return $string;
}


class Tag {
	var $link=0;
	var $lang=0;
	var $words='';
	var $date;
	
	function Tag() {
		return;
	}
}





// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// The Pligg Team <pligger at pligg dot com>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".


class TagCloud {
	var $word_limit = NULL; // limit to cloud to this many words
	var $smarty_variable = '';
	var $filterTo = 'all'; // published, queued or ALL (does not include discarded)
	var $filterCategory = 0; // a specific category
	var $range_values = NULL; // only used on the tagcloud page where there is a list of time ranges to filter to.
	var $min_points = NULL; // the size of the smallest tag
	var $max_points = NULL; // the size of the largest tag
	
	function show(){
		global $db, $dblang, $URLMethod, $tags_words_limit, $tags_min_pts, $tags_max_pts;
		
		// if we didnt set a word limit, use the default set in the config.php
			if ($this->word_limit == NULL) {$this->word_limit = $tags_words_limit;}

		// if we didnt set the minimum font points, use the default set in the config.php
			if ($this->min_points == NULL) {$this->min_points = $tags_min_pts;}

		// if we didnt set the maximum font points, use the default set in the config.php
			if ($this->max_points == NULL) {$this->max_points = $tags_max_pts;}

		// see if we clicked on a link to filter to a specific time range
		if(($from = check_integer('range')) >= 0 && $from < count($this->range_values) && $this->range_values[$from] > 0 ) {
			$from_time = time() - $this->range_values[$from];
			$from_where = "FROM " . table_tags . ", " . table_links . " WHERE  tag_lang='$dblang' and tag_date > FROM_UNIXTIME($from_time) and link_id = tag_link_id and ";
			$time_query = "&amp;from=$from_time";
			$this->smarty_variable->assign('time_query', $time_query);
		} else {
			$from_where = "FROM " . table_tags . ", " . table_links . " WHERE tag_lang='$dblang' and link_id = tag_link_id and ";
		}

		if ($this->filterTo == 'all') {$from_where .= " link_status!='discard' ";}
		if ($this->filterTo == 'queued') {$from_where .= " link_status='queued' ";}
		if ($this->filterTo == 'published') {$from_where .= " link_status='published' ";}

		if($this->filterCategory>0){$from_where .= " and link_category='".$this->filterCategory."' ";}

		$from_where .= " GROUP BY tag_words";
		
		$max = max($db->get_var("select count(*) as words $from_where order by words desc limit 1"), 2);
		$coef = ($this->max_points - $this->min_points)/($max-1);

		$sql = "select tag_words, count(*) as count $from_where order by count desc limit $this->word_limit";
		//echo $sql;
		$res = $db->get_results($sql);
		
		if ($res) {
			foreach ($res as $item) {
				//echo $item->tag_words;
				$words[$item->tag_words] = $item->count;
			}
			ksort($words);


			$tag_number = array();
			$tag_name = array();
			$tag_count = array();
			$tag_size = array();
			$tag_url = array();
			
			$tagnumber = 0;
			foreach (array_keys($words) as $theword) {
				
				$tag_number[$tagnumber] = tagnumber;
				$tag_name[$tagnumber] = $theword;
				$tag_count[$tagnumber] = $words[$theword];
				$tag_size[$tagnumber] = $tags_min_pts + ($tag_count[$tagnumber] - 1) * $coef;
				
				if(isset($time_query)){
					$tag_url[$tagnumber] = getmyurl('tag2', $tag_name[$tagnumber], $from_time);
				} else {
					$tag_url[$tagnumber] = getmyurl('tag', urlencode($tag_name[$tagnumber]));
				}
				
				$tagnumber = $tagnumber + 1;
			}
		}

		// Set the smarty variables
			if(isset($words)){$this->smarty_variable->assign('words', $words);}
			if(isset($tag_number)){$this->smarty_variable->assign('tag_number', $tag_number);}else{$this->smarty_variable->assign('tag_number', 0);}
			if(isset($tag_name)){$this->smarty_variable->assign('tag_name', $tag_name);}
			if(isset($tag_count)){$this->smarty_variable->assign('tag_count', $tag_count);}
			if(isset($tag_size)){$this->smarty_variable->assign('tag_size', $tag_size);}
			if(isset($tag_url)){$this->smarty_variable->assign('tag_url', $tag_url);}

			$this->smarty_variable->assign('tags_words_limit', $this->word_limit);
			$this->smarty_variable->assign('tags_min_pts', $this->min_points);
			$this->smarty_variable->assign('tags_max_pts', $this->max_points);

			$this->smarty_variable->assign('tags_largest_tag', $max);
			$this->smarty_variable->assign('tags_coef', $coef);
	}
}


?>