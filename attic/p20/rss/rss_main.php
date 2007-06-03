<?php

	include('../config.php');
	require(mnminclude.'qeip_0_3.php'); 
	require_once('../3rdparty/magpierss/rss_fetch.inc');
	require('./libs/rssimport.php'); 
	include(mnminclude.'html1.php');

	force_authentication();

	$amIgod = 0;
	$amIgod = $amIgod + checklevel('god');
	
	if($amIgod == 1){

		$tableexists = checkfortable(table_prefix . 'feed_import');
		if (!$tableexists) {
			echo "Creating Tables<hr />";
			include_once( 'create_mysql_tables.php' );
			die("<hr />If there are no errors then refresh this page to continue");
		}
		
		$filename = 'create_mysql_tables.php';
		if (file_exists($filename)) {
		   die("Please delete or rename the file /rss/create_mysql_tables.php, then refresh this page");
		} 

		include_once('../Smarty.class.php');
		$smarty = new Smarty;	
		
		$smarty->compile_dir = "templates_c/";
		$smarty->template_dir = "templates/";
		$smarty->config_dir = "";
	
		$smarty->register_function('feedsListFeeds', 'smarty_function_feedsListFeeds');
		$smarty->register_function('feedsListFeedLinks', 'smarty_function_feedsListFeedLinks');
		$smarty->register_function('feedsListFeedFields', 'smarty_function_feedsListFeedFields');
		$smarty->register_function('feedsListPliggLinkFields', 'smarty_function_feedsListPliggLinkFields');
	
	
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
				          'field_name' => 'feed_name',  // the name of the field in the table
				          'key' => 'feed_id');  // a unique identifier for the row
		$smarty->assign('qeip_FeedName', $QEIPA);
	
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
				          'field_name' => 'feed_url',  // the name of the field in the table
				          'key' => 'feed_id');  // a unique identifier for the row
		$smarty->assign('qeip_FeedURL', $QEIPA);
	
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
				          'field_name' => 'feed_category',  // the name of the field in the table
				          'key' => 'feed_id');  // a unique identifier for the row
		$smarty->assign('qeip_FeedCategory', $QEIPA);
	
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
				          'field_name' => 'feed_freq_hours',  // the name of the field in the table
				          'key' => 'feed_id',  // a unique identifier for the row
				          'field_type' => 'number'); // the type of database field we are reading from / writing to
		$smarty->assign('qeip_FeedFreqHours', $QEIPA);
	
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
				          'field_name' => 'feed_votes',  // the name of the field in the table
				          'key' => 'feed_id',  // a unique identifier for the row
				          'field_type' => 'number'); // the type of database field we are reading from / writing to
		$smarty->assign('qeip_FeedVotes', $QEIPA);
	
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
				          'field_name' => 'feed_item_limit',  // the name of the field in the table
				          'key' => 'feed_id',  // a unique identifier for the row
				          'field_type' => 'number'); // the type of database field we are reading from / writing to
		$smarty->assign('qeip_FeedItemLimit', $QEIPA);
	
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
				          'field_name' => 'feed_url_dupe',  // the name of the field in the table
				          'key' => 'feed_id',  // a unique identifier for the row
				          'field_type' => 'number'); // the type of database field we are reading from / writing to
		$smarty->assign('qeip_FeedURLDupe', $QEIPA);
	
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
				          'field_name' => 'feed_title_dupe',  // the name of the field in the table
				          'key' => 'feed_id',  // a unique identifier for the row
				          'field_type' => 'number'); // the type of database field we are reading from / writing to
		$smarty->assign('qeip_FeedTitleDupe', $QEIPA);
	
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
				          'field_name' => 'feed_submitter',  // the name of the field in the table
				          'key' => 'feed_id',  // a unique identifier for the row
				          'field_type' => 'number'); // the type of database field we are reading from / writing to
		$smarty->assign('qeip_FeedSubmitter', $QEIPA);
	
		$QEIPA = array('table_name' => table_prefix . 'feed_link',  // the name of the table to use
				          'field_name' => 'feed_field',  // the name of the field in the table
				          'key' => 'feed_link_id',  // a unique identifier for the row
				          'eip_type' => 'select');  // the type of EIP field to show 
		$smarty->assign('qeip_FeedLink_FeedField', $QEIPA);
	
		$QEIPA = array('table_name' => table_prefix . 'feed_link',  // the name of the table to use
				          'field_name' => 'pligg_field',  // the name of the field in the table
				          'key' => 'feed_link_id',  // a unique identifier for the row
				          'eip_type' => 'select');  // the type of EIP field to show 
		$smarty->assign('qeip_FeedLink_PliggField', $QEIPA);
	
	
	
		
		$QEIP = new QuickEIP();	
		
		
		if(!isset($_REQUEST['action'])){
			$smarty->display('rss_main.tpl');
		}else{
	
			if($_REQUEST['action'] == "addnewfieldlink"){
				$RSSImport=new RSSImport;
				$RSSImport->FeedLinkId = $_REQUEST['FeedLinkId'];
				$RSSImport->new_field_link();
				header("Location: rss_main.php");
			}		
	
			if($_REQUEST['action'] == "dropfieldlink"){
				$RSSImport=new RSSImport;
				$RSSImport->FeedLinkId=$_REQUEST['FeedLinkId'];
				$RSSImport->drop_field_link();
				header("Location: rss_main.php");
			}		
	
			if($_REQUEST['action'] == "addnewfeed"){
				$RSSImport=new RSSImport;
				$RSSImport->FeedName="New Feed";
				$RSSImport->new_feed();
				header("Location: rss_main.php");
			}		
	
			if($_REQUEST['action'] == "dropfeed"){
				$RSSImport=new RSSImport;
				$RSSImport->FeedId=$_REQUEST['feed_id'];
				$RSSImport->drop_feed();
				header("Location: rss_main.php");
			}		
			if($_REQUEST['action'] == "save"){
				echo $QEIP->save_field();
			}
		}
	
	
		echo $QEIP->ShowOnloadJS();
	}	










// FEED FUNCTIONS



	function smarty_function_feedsListFeeds($params, &$smarty)
	{
		// get a list of feeds in the database and put them into smarty varliable $params['varname']
		global $db;
		$smarty->assign($params['varname'], $db->get_col("select feed_id from " . table_prefix . "feeds"));
	}	
	
	function smarty_function_feedsListFeedLinks($params, &$smarty)
	{
		// get a list of all field_links where `feed_id` = $feed_id and put them into the smarty variable $params['varname']
		global $db;
		$smarty->assign($params['varname'], $db->get_col("select feed_link_id from " . table_prefix . "feed_link where feed_id = " . $params['feedid']));
	}
	
		
	
	
	
	function smarty_function_feedsListFeedFields($params, &$smarty)
	{
		// get a list of fields in the RSS feed and put them into the smarty variable "eip_select" for the EIP selectbox to use
		global $db;
		$smarty->assign('eip_select', "");
		//$url = "http://localhost/nik.xml";
		$feed_url = $db->get_var("select feed_url from " . table_prefix . "feeds where feed_id = " . $params['feed_id']);
		$rss = fetch_rss($feed_url);

		$x = sizeof($rss->items[1]);
		$z = $rss->items[0];

		$TheTextToReturn = "	options: {";
		
		$count = 0;
		foreach ($z as $item => $key) {
			if ($count < $x){
				//echo $item . "<BR>";
				
				if (is_array($z[$item])) {
					foreach ($z[$item] as $item2 => $key) {
						if($count > 0){$TheTextToReturn .= ", ";}
						$TheTextToReturn .= $item . "_ne_st_ed_" . $item2 . ": '" . $item . " : " . $item2 . "'";				
						$count = $count + 1;
					}				
				} else {				
					if($count > 0){$TheTextToReturn .= ", ";}
					$TheTextToReturn .= $item . ": '" . $item . "'";				
					$count = $count + 1;
				}
			}
		}
		$TheTextToReturn .= "}";

		$smarty->assign('eip_select', $TheTextToReturn);
		
	}
	

	function get_pligg_fields(){
		global $db;
		$sql = "select * from " . table_prefix . "feed_import_fields;";
		$pligg_fields = $db->get_results($sql);
		return $pligg_fields;
	}
		
	function smarty_function_feedsListPliggLinkFields($params, &$smarty){
		// get a list of pligg fields and put them into the smarty variable "eip_select" for the EIP selectbox to use
		$Pligg_Fields = get_pligg_fields();
		$TheTextToReturn = "	options: {";
		$Count = 0;
		if($Pligg_Fields){
			foreach ($Pligg_Fields as $Field) {

				if($count > 0){$TheTextToReturn .= ", ";}
				$TheTextToReturn .= $Field->field_name . ": '" . $Field->field_name . "'";				
				$count = $count + 1;
				
			}
		}
		
		$TheTextToReturn .= "}";
		
		$smarty->assign('eip_select', $TheTextToReturn);
		
	}	

	function checkfortable($table)
	{
		$result = mysql_query('select * from ' . $table);
		if (!$result) {
			return false;
		}
		return true;
	}
	
?>