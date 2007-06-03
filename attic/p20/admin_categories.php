<?php

include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');

include(mnminclude.'html1.php');
include(mnminclude.'ts.php');
include(mnminclude.'link.php');
include(mnminclude.'smartyvariables.php');
$smarty = $main_smarty;

include_once(mnminclude.'dbtree.php');
include(mnminclude.'qeip_0_3.php');

force_authentication();

 // breadcrumbs
		$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
		$navwhere['link1'] = getmyurl('admin', '');
		$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_2');
		$navwhere['link2'] = my_pligg_base . "/admin_categories.php";
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
	// breadcrumbs

$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('god');



if($canIhaveAccess == 1)
{

	// clear the category sidebar module from the cache so it can regenerate in case we make changes
		$main_smarty->cache = 2; 
		$main_smarty->cache_dir = "cache";
		$main_smarty->clear_cache();
		$main_smarty->cache = false; 

	$smarty = do_sidebar($smarty);

	$QEIPA = array('table_name' => table_categories,  // the name of the table to use
			          'field_name' => 'category_name',  // the name of the field in the table
			          'key' => 'category__auto_id');  // a unique identifier for the row
	$smarty->assign('qeip_CatName', $QEIPA);

	$QEIPA = array('table_name' => table_categories,  // the name of the table to use
			          'field_name' => 'category_parent',  // the name of the field in the table
			          'key' => 'category__auto_id');  // a unique identifier for the row
	$smarty->assign('qeip_CatParent', $QEIPA);

	$QEIPA = array('table_name' => table_categories,  // the name of the table to use
			          'field_name' => 'category_order',  // the name of the field in the table
			          'key' => 'category__auto_id');  // a unique identifier for the row
	$smarty->assign('qeip_CatOrder', $QEIPA);
	
	$QEIP = new QuickEIP();	


rebuild_the_tree();
		ordernew();

//display_the_tree_table();
// put the category tree into an array for use in the qeip dropdown

	if(isset($_REQUEST['action'])){
		$action = $_REQUEST['action'];
	} else {
		$action = "view";
	}
	
	
	if($_REQUEST['action'] == "save"){
		echo $QEIP->save_field();
		Cat_Safe_Names();
	}

	if($_REQUEST['action'] == "add"){
		$sql = "insert into `" . table_categories . "` (`category_name`) VALUES ('new category');";
		//echo $sql;
		$db->query($sql);
		rebuild_the_tree();
		ordernew();
		Cat_Safe_Names();
		header("Location: admin_categories.php");
	}

	if($_REQUEST['action'] == "changecolor"){
		$id = $_REQUEST['id'];
		$color = $_REQUEST['color'];
		$color = utf8_str_replace('#', '', $color);
	
		$sql = "update ".table_categories." set category_color = '" . $color . "' where category__auto_id=" . $id . ";";
		echo $sql;
		$db->query($sql);

		Cat_Safe_Names();
		//header("Location: admin_categories.php");
	}

	if($_REQUEST['action'] == "remove"){
		$id = $_REQUEST['id'];
		$sql = "delete from ".table_categories." where category__auto_id=" . $id . ";";
		$db->query($sql);
		header("Location: admin_categories.php");
	}

	if($_REQUEST['action'] == "changeparent"){
		$id = utf8_substr($_REQUEST['id'], 9, 100);
		$parent = utf8_substr($_REQUEST['parent'], 9, 100);
		
		children_id_to_array($array, table_categories, $id, 0);
		//print_r($array);
		if(is_array($array)){
			if(in_array($parent, $array)){
				die('You cannot move a category into it\'s own subcategory. Click <a href = "admin_categories.php">here</a> to reload.');
			}
		}
		
		if($id == $parent) {header("Location: admin_categories.php");die();}

		$sql = "update ".table_categories." set category_parent = " . $parent . " where category__auto_id=" . $id . ";";
		//echo $sql;
		$db->query($sql);
		header("Location: admin_categories.php");
	}


	if($_REQUEST['action'] == "move_above"){
		$id = utf8_substr($_REQUEST['id_to_move'], 9, 100);
		$move_id = utf8_substr($_REQUEST['moveabove_id'], 6, 100);

		if($id == $move_id) {header("Location: admin_categories.php");}

		$array = "";
		children_id_to_array($array, table_categories, $id, 0);
		if(is_array($array)){
			if(!in_array($move_id, $array))
			{
				$sql = "Select * from ".table_categories." where category__auto_id=" . $move_id . ";";
				$results = $db->get_row($sql);
				$move_sort = $results->category_order;
				
				$sql = "update ".table_categories." set category_parent = ".$results->category_parent.", category_order = " . ($move_sort - 1) . " where category__auto_id=" . $id . ";";
				//echo $sql;
				$db->query($sql);
				rebuild_the_tree();
				header("Location: admin_categories.php");
			}else{
				die('You cannot move a category into it\'s own subcategory. Click <a href = "admin_categories.php">here</a> to reload.');
			}
		}else{
			$sql = "Select * from ".table_categories." where category__auto_id=" . $move_id . ";";
			$results = $db->get_row($sql);
			$move_sort = $results->category_order;
			
			$sql = "update ".table_categories." set category_parent = ".$results->category_parent.", category_order = " . ($move_sort - 1) . " where category__auto_id=" . $id . ";";
			//echo $sql;
			$db->query($sql);
			rebuild_the_tree();
			header("Location: admin_categories.php");
		}
	}

	if($_REQUEST['action'] == "move_below"){
		$id = utf8_substr($_REQUEST['id_to_move'], 9, 100);
		$move_id = utf8_substr($_REQUEST['movebelow_id'], 6, 100);
		
		if($id == $move_id) {header("Location: admin_categories.php");}

		$array = "";
		children_id_to_array($array, table_categories, $id, 0);
		if(is_array($array)){
			if(!in_array($move_id, $array))
			{
				$sql = "Select * from ".table_categories." where category__auto_id=" . $move_id . ";";
				$results = $db->get_row($sql);
				$move_sort = $results->category_order;
				
				$sql = "update ".table_categories." set category_parent = ".$results->category_parent.", category_order = " . ($move_sort + 1) . " where category__auto_id=" . $id . ";";
				//echo $sql;
				$db->query($sql);
				rebuild_the_tree();
				header("Location: admin_categories.php");
			}else{
				die('You cannot move a category into it\'s own subcategory. Click <a href = "admin_categories.php">here</a> to reload.');
			}
		}else{
			$sql = "Select * from ".table_categories." where category__auto_id=" . $move_id . ";";
			$results = $db->get_row($sql);
			$move_sort = $results->category_order;
			
			$sql = "update ".table_categories." set category_parent = ".$results->category_parent.", category_order = " . ($move_sort + 1) . " where category__auto_id=" . $id . ";";
			//echo $sql;
			$db->query($sql);
			rebuild_the_tree();
			header("Location: admin_categories.php");
		}
	}

					
	if($action == "view"){
	
		$array = tree_to_array(0, table_categories, true);
		$smarty->assign('cat_count', count($array));
		$smarty->assign('cat_array', $array);
		//$smarty->display($the_template . '/category_manager.tpl');
		$smarty->assign('tpl_center', The_Template . '/admin_templates/category_manager');
		$smarty->display(The_Template . '/pligg.tpl');
		echo $QEIP->ShowOnloadJS();
	}

}else	{
	echo 'not for you! go away!';
}

?>