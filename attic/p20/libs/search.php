<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// The Pligg Team <pligger at pligg dot com>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

class Search {
	var $newerthan = NULL;
	var $searchTerm = '';
	var $filterToStatus = 'all';
	var $filterToTimeFrame = '';
	var $isTag = false;
	var $searchTable = '';
	var $orderBy = NULL;
	var $offset = 0;
	var $pagesize = '';
	var $sql = '';
	var $countsql = '';
	var $category = ''; // search a specific category?
	var $search_subcats = true; // search it's subcategories? 
	var $search_extra_fields = true; // search the extra_fields (if enabled)
  
	function doCountUpcoming() {
		global $db;
		$totlz = $db->get_var("SELECT count(*) FROM ". table_links ." WHERE link_status='queued'");
		return $totlz;
	}
	

	function doSearch() {
		global $db, $main_smarty;
		
		$search_clause = $this->get_search_clause();
	
		// set smarty variables
		if(isset($this->searchTerm)){
			$main_smarty->assign('search', $this->searchTerm);
			$main_smarty->assign('searchtext', htmlspecialchars($this->searchTerm));
		} else {
			$main_smarty->assign('searchtext', '');
		}
	
		$from_where = "FROM " . $this->searchTable . " WHERE ";

		if ($this->filterToStatus == 'all') {$from_where .= " link_status!='discard' ";}
		if ($this->filterToStatus == 'queued') {$from_where .= " link_status='queued' ";}
		if ($this->filterToStatus == 'discard') {$from_where .= " link_status='discard' ";}		
		if ($this->filterToStatus == 'published') {$from_where .= " link_status='published' ";}		
		if ($this->filterToStatus == 'popular') {$from_where .= " link_status='published' ";}

		if ($this->filterToTimeFrame == 'today') {
			$tsdt = date('Ymd000000', strtotime("now"));
			$fsdt = date('Ymd235959', strtotime("now"));
			$from_where .= " AND (link_published_date >= $tsdt AND link_published_date <= $fsdt) "; 
		}
		if ($this->filterToTimeFrame == 'yesterday') {
			$tsdt = date('Ymd000000', strtotime("-1 day"));
			$fsdt = date('Ymd235959', strtotime("-1 day"));
			$from_where .= " AND (link_published_date >= $tsdt AND link_published_date <= $fsdt) "; 
		}
		if ($this->filterToTimeFrame == 'week') {
			$wknum =  date('w', strtotime("now"));
			if ($wknum > 0) {
				$tsdt = date('Ymd000000', strtotime("-{$wknum} day"));
				$fsdt = date('Ymd235959', strtotime("now"));
			} else {
				$tsdt = date('Ymd000000', strtotime("now"));
				$fsdt = date('Ymd235959', strtotime("now"));
			}
			$from_where .= " AND (link_published_date >= $tsdt AND link_published_date <= $fsdt) "; 
		}
		if ($this->filterToTimeFrame == 'month') {
			$tsdt = date('Ym01000000', strtotime("now"));
			$fsdt = date('Ym31235959', strtotime("now"));
			$from_where .= " AND (link_published_date >= $tsdt AND link_published_date <= $fsdt) "; 
		}
		if ($this->filterToTimeFrame == 'year') {
			$tsdt = date('Y0101000000', strtotime("now"));
			$fsdt = date('Y1231235959', strtotime("now"));
			$from_where .= " AND (link_published_date >= $tsdt AND link_published_date <= $fsdt) "; 
		}
		
		// get links newer than $newerthan
		if (isset($this->newerthan)){
			$from_where = $from_where . "AND UNIX_TIMESTAMP(link_date) > " . $this->newerthan;
			$from_text = PLIGG_Visual_Search_WithinTheLast . intval((time() - $this->newerthan) / 86400). PLIGG_Visual_Search_Days;
		}else{
			$from_datetime = "";
			$from_text = "";
		}

		//should we filter to just this category?
		if(isset($this->category))
		{
			$catId = $db->get_var("SELECT category_id from " . table_categories . " where category_name = '" . $this->category . "';");
			if(isset($catId)){
				$child_cats = '';
				// do we also search the subcategories? 
				if($this->search_subcats == true){
					$child_array = '';
					// get a list of all children and put them in $child_array.
					children_id_to_array_2($child_array, table_categories, $catId);
					if ($child_array != '') {
						// build the sql
						foreach($child_array as $child_cat_id) {
							$child_cat_sql .= ' OR `link_category` = ' . $child_cat_id . ' ';
						}
					}
				}
				$from_where .= " AND (link_category=$catId " . $child_cat_sql . ")";
			}
		}
		
		if(isset($this->orderBy)){
			$this->orderBy = "ORDER BY " . $this->orderBy;
		}

		if($this->searchTerm == ""){
			// like when on the index or upcoming pages.
			$this->sql = "SELECT DISTINCT link_id $from_where $search_clause $this->orderBy LIMIT $this->offset,$this->pagesize";
		}else{
			$this->sql = "SELECT link_id, link_date, link_published_date $from_where $search_clause ";
		}
		$this->countsql = "SELECT count(*) $from_where $search_clause $this->orderBy";

		return;
	}

	function new_search(){
		// do various searches and put the results in the $foundlinks array
		global $db;

		if(!isset($this->searchTerm)){return false;}

		$foundlinks = array();
		
		// search tags
		$this->isTag = true;
		$this->doSearch();
		$links = $db->get_results($this->sql);
		if ($links) {
			foreach($links as $link_id) {
				if(array_search($link_id->link_id, $foundlinks) === false){
					// if it's not already in our list, add it
					$foundlinks[] = $link_id->link_id;

					$newfoundlinks[$link_id->link_id]['link_id'] = $link_id->link_id;
					$newfoundlinks[$link_id->link_id]['link_date'] = $link_id->link_date;
					$newfoundlinks[$link_id->link_id]['link_published_date'] = $link_id->link_published_date;
				}
			}
		}

		// search links
		$this->isTag = false;
		$this->doSearch();
		$links = $db->get_results($this->sql);
		if ($links) {
			foreach($links as $link_id) {
				if(array_search($link_id->link_id, $foundlinks) === false){
					// if it's not already in our list, add it
					$foundlinks[] = $link_id->link_id;

					$newfoundlinks[$link_id->link_id]['link_id'] = $link_id->link_id;
					$newfoundlinks[$link_id->link_id]['link_date'] = $link_id->link_date;
					$newfoundlinks[$link_id->link_id]['link_published_date'] = $link_id->link_published_date;
				}
			}
		}
		
		if($newfoundlinks){
			foreach($newfoundlinks as $thelink){
				$sortarray[$thelink['link_id']] = $thelink['link_date'];
			}
			asort($sortarray);

			$x = 0;
			$aa = $this->offset;
			$ab = $aa + $this->pagesize;
			
			foreach($sortarray as $theitemaa=>$theitemab) {
				if($x >= $aa && $x < $ab){
					$results[] = $theitemaa;
				}
				$x++;
			}			
		}
		
		$returnme['rows'] = $results;
		$returnme['count'] = count($sortarray);
		
		return $returnme;
	}

	function get_search_clause($option='') {
		if(!empty($this->searchTerm)) {
			// make sure there is a search term
			$words = $this->searchTerm;
			$SearchMethod = SearchMethod; // create a temp variable so we can change the value without possibly affecting anything else

			if($this->isTag == true){
				// search the tags table
				$this->searchTable = table_tags . " INNER JOIN " . table_links . " ON " . table_tags . ".tag_link_id = " . table_links . ".link_id";
				
				// thanks to jalso for this code
					$x = explode(",",$words);
					$sq .= "(";
					foreach($x as $k=>$v){
					 $sq .= "tag_words = '".trim($x[$k])."'";
					 if($k != (count($x) - 1))$sq .= " OR ";
					}
					$sq .= ")";
					$where .= " AND ".$sq." GROUP BY " . table_links . ".link_id, `link_votes` ORDER BY `link_votes` DESC"; 
				// ---
				
			} else {
				// search the links table
				$this->searchTable = table_links;

				if($SearchMethod == 3){
					$SearchMethod = $this->determine_search_method($words);
				}
				if($SearchMethod == 1){
					// use SQL "against" for searching
					// doesn't work with "stopwords" or less than 4 characters

					if($this->search_extra_fields == true){
						if(Enable_Extra_Fields){
							$matchfields = '';
							if(Enable_Extra_Field_1 == true && Field_1_Searchable == true){$matchfields .= ', `link_field1`';}
							if(Enable_Extra_Field_2 == true && Field_2_Searchable == true){$matchfields .= ', `link_field2`';}
							if(Enable_Extra_Field_3 == true && Field_3_Searchable == true){$matchfields .= ', `link_field3`';}
							if(Enable_Extra_Field_4 == true && Field_4_Searchable == true){$matchfields .= ', `link_field4`';}
							if(Enable_Extra_Field_5 == true && Field_5_Searchable == true){$matchfields .= ', `link_field5`';}
							if(Enable_Extra_Field_6 == true && Field_6_Searchable == true){$matchfields .= ', `link_field6`';}
							if(Enable_Extra_Field_7 == true && Field_7_Searchable == true){$matchfields .= ', `link_field7`';}
							if(Enable_Extra_Field_8 == true && Field_8_Searchable == true){$matchfields .= ', `link_field8`';}
							if(Enable_Extra_Field_9 == true && Field_9_Searchable == true){$matchfields .= ', `link_field9`';}
							if(Enable_Extra_Field_10 == true && Field_10_Searchable == true){$matchfields .= ', `link_field10`';}
							if(Enable_Extra_Field_11 == true && Field_11_Searchable == true){$matchfields .= ', `link_field11`';}
							if(Enable_Extra_Field_12 == true && Field_12_Searchable == true){$matchfields .= ', `link_field12`';}
							if(Enable_Extra_Field_13 == true && Field_13_Searchable == true){$matchfields .= ', `link_field13`';}
							if(Enable_Extra_Field_14 == true && Field_14_Searchable == true){$matchfields .= ', `link_field14`';}
							if(Enable_Extra_Field_15 == true && Field_15_Searchable == true){$matchfields .= ', `link_field15`';}
						}
					}

					$where = " AND MATCH (link_url, link_url_title, link_title, link_content, link_tags $matchfields) AGAINST ('$words' $mode) ";
				}
				if($SearchMethod == 2){
					// use % for searching

					if($this->search_extra_fields == true){
						if(Enable_Extra_Fields){
							$matchfields = '';
							if(Enable_Extra_Field_1 == true && Field_1_Searchable == true){$matchfields .= " or `link_field1` like '%$words%' ";}
							if(Enable_Extra_Field_2 == true && Field_2_Searchable == true){$matchfields .= " or `link_field2` like '%$words%' ";}
							if(Enable_Extra_Field_3 == true && Field_3_Searchable == true){$matchfields .= " or `link_field3` like '%$words%' ";}
							if(Enable_Extra_Field_4 == true && Field_4_Searchable == true){$matchfields .= " or `link_field4` like '%$words%' ";}
							if(Enable_Extra_Field_5 == true && Field_5_Searchable == true){$matchfields .= " or `link_field5` like '%$words%' ";}
							if(Enable_Extra_Field_6 == true && Field_6_Searchable == true){$matchfields .= " or `link_field6` like '%$words%' ";}
							if(Enable_Extra_Field_7 == true && Field_7_Searchable == true){$matchfields .= " or `link_field7` like '%$words%' ";}
							if(Enable_Extra_Field_8 == true && Field_8_Searchable == true){$matchfields .= " or `link_field8` like '%$words%' ";}
							if(Enable_Extra_Field_9 == true && Field_9_Searchable == true){$matchfields .= " or `link_field9` like '%$words%' ";}
							if(Enable_Extra_Field_10 == true && Field_10_Searchable == true){$matchfields .= " or `link_field10` like '%$words%' ";}
							if(Enable_Extra_Field_11 == true && Field_11_Searchable == true){$matchfields .= " or `link_field11` like '%$words%' ";}
							if(Enable_Extra_Field_12 == true && Field_12_Searchable == true){$matchfields .= " or `link_field12` like '%$words%' ";}
							if(Enable_Extra_Field_13 == true && Field_13_Searchable == true){$matchfields .= " or `link_field13` like '%$words%' ";}
							if(Enable_Extra_Field_14 == true && Field_14_Searchable == true){$matchfields .= " or `link_field14` like '%$words%' ";}
							if(Enable_Extra_Field_15 == true && Field_15_Searchable == true){$matchfields .= " or `link_field15` like '%$words%' ";}
						}
					}
					
					$where = " AND (";
					$where .= $this->explode_search('link_url', $words) . " OR ";
					$where .= $this->explode_search('link_url_title', $words) . " OR ";
					$where .= $this->explode_search('link_title', $words) . " OR ";
					$where .= $this->explode_search('link_content', $words) . " OR ";
					$where .= $this->explode_search('link_tags', $words);
					$where .= " $matchfields) ";
					
				}
			}
			return $where;
		} else {
			$this->searchTable = table_links;
			return false;
		}
	}

	function explode_search($search_field, $words){
		$sq = '';
		$x = explode(" ", $words);
		foreach($x as $k=>$v){
			if($k > 0){$sq .= " OR ";}
			$sq .= $search_field . " LIKE '%".trim($x[$k])."%' ";
		}

		return $sq;
	}

	function determine_search_method(&$words){
		// find out which of the methods is best and then use it.

		$pieces = explode(" ", $words);
		$SearchMethod = 1; // assume that it'll be ok to use method 1

		foreach($pieces as $piece){
			if (strlen($piece) < 4) {$SearchMethod = 2;} // if the length of the searchterm is less that 4 characters.
			if ($this->is_it_stopword($piece)) {$SearchMethod = 2;} // if its a stopword
			if (strpos($piece, "*") > 0){
				$SearchMethod = 2; 
				$words = str_replace("*", "", $words); // strip the * out so we can do a like on the actual search term
			}
		}


		return $SearchMethod;
	}

	function is_it_stopword($word) {
	 	// list came from here
	 	// http://meta.wikimedia.org/wiki/MySQL_4.0.20_stop_word_list
		$stopwordlist = "a's able about above according accordingly across actually after afterwards again against ain't all allow allows almost alone along already also although always am among amongst an and another any anybody anyhow anyone anything anyway anyways anywhere apart appear appreciate appropriate are aren't around as aside ask asking associated at available away awfully be became because become becomes becoming been before beforehand behind being believe below beside besides best better between beyond both brief but by c'mon c's came can can't cannot cant cause causes certain certainly changes clearly co com come comes concerning consequently consider considering contain containing contains corresponding could couldn't course currently definitely described despite did didn't different do does doesn't doing don't done down downwards during each edu eg eight either else elsewhere enough entirely especially et etc even ever every everybody everyone everything everywhere ex exactly example except far few fifth first five followed following follows for former formerly forth four from further furthermore get gets getting given gives go goes going gone got gotten greetings had hadn't happens hardly has hasn't have haven't having he he's hello help hence her here here's hereafter hereby herein hereupon hers herself hi him himself his hither hopefully how howbeit however i'd i'll i'm i've ie if ignored immediate in inasmuch inc indeed indicate indicated indicates inner insofar instead into inward is isn't it it'd it'll it's its itself just keep keeps kept know knows known last lately later latter latterly least less lest let let's like liked likely little look looking looks ltd mainly many may maybe me mean meanwhile merely might more moreover most mostly much must my myself name namely nd near nearly necessary need needs neither never nevertheless new next nine no nobody non none noone nor normally not nothing novel now nowhere obviously of off often oh ok okay old on once one ones only onto or other others otherwise ought our ours ourselves out outside over overall own particular particularly per perhaps placed please plus possible presumably probably provides que quite qv rather rd re really reasonably regarding regardless regards relatively respectively right said same saw say saying says second secondly see seeing seem seemed seeming seems seen self selves sensible sent serious seriously seven several shall she should shouldn't since six so some somebody somehow someone something sometime sometimes somewhat somewhere soon sorry specified specify specifying still sub such sup sure t's take taken tell tends th than thank thanks thanx that that's thats the their theirs them themselves then thence there there's thereafter thereby therefore therein theres thereupon these they they'd they'll they're they've think third this thorough thoroughly those though three through throughout thru thus to together too took toward towards tried tries truly try trying twice two un under unfortunately unless unlikely until unto up upon us use used useful uses using usually value various very via viz vs want wants was wasn't way we we'd we'll we're we've welcome well went were weren't what what's whatever when whence whenever where where's whereafter whereas whereby wherein whereupon wherever whether which while whither who who's whoever whole whom whose why will willing wish with within without won't wonder would would wouldn't yes yet you you'd you'll you're you've your yours yourself yourselves zero";

		$word_array = explode(" ", $stopwordlist);

	 	if(array_search($word, $word_array) == true){
	 		return true;
	 	} else {
	 		return false;
	 	}
	}

	function do_setmek(){
		if(isset($this->setmek)){$setmek = $this->setmek;}else{$setmek = '';}
		if ($setmek=='upcoming') {
			$this->filterToStatus = "queued";
			$this->orderBy = "link_date DESC";
			$ords = $this->ords;
			if ($ords==newest) {
				$this->orderBy = "link_date DESC";
			} elseif ($ords==oldest) {
				$this->orderBy = "link_date ASC";
			} elseif ($ords==mostpopular) {
				$this->orderBy = "link_votes DESC";
			} elseif ($ords==leastpopular) {
				$this->orderBy = "link_votes ASC";
			} else {
				$this->orderBy = "link_date DESC";
			}
		} elseif ($setmek=='today') {
			$this->filterToTimeFrame = "today";
			$this->orderBy = "link_votes DESC";
		} elseif ($setmek=='yesterday') {
			$this->filterToTimeFrame = "yesterday";
			$this->orderBy = "link_votes DESC";
		} elseif ($setmek=='week') {
			$this->filterToTimeFrame = "week";
			$this->orderBy = "link_votes DESC";
		} elseif ($setmek=='month') {
			$this->filterToTimeFrame = "month";
			$this->orderBy = "link_votes DESC";
		} elseif ($setmek=='year') {
			$this->filterToTimeFrame = "year";
			$this->orderBy = "link_votes DESC";
		} else {
			//$this->filterToStatus = "popular";
			//$this->orderBy = "link_published_date DESC";
		}
	}
}

?>
