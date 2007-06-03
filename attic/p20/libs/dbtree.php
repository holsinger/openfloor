<?php

// taken from http://www.sitepoint.com/article/hierarchical-data-database and modified
function rebuild_tree($parent, $left, $table, $key_name, $parent_name) {
	global $db;
   // the right value of this node is the left value + 1
   $right = $left+1;

   // get all children of this node
   $sql = 'SELECT * FROM `'.$table.'` WHERE `'.$parent_name.'`='.$parent.' and category_enabled = 1 ORDER BY category_order;';
    // ORDER BY category_order;';
   //echo $sql . "<BR>";
   $result = mysql_query($sql);
   //echo 'SELECT `id` FROM `'.$table.'` WHERE `'.$parent_name.'`='.$parent.';<br>';

   while ($row = mysql_fetch_array($result)) {
       // recursive execution of this function for each
       // child of this node
       // $right is the current right value, which is
       // incremented by the rebuild_tree function
       $right = rebuild_tree($row[$key_name], $right, $table, $key_name, $parent_name);
   }

   // we've got the left value, and now that we've processed
   // the children of this node we also know the right value
   mysql_query('UPDATE `'.$table.'` SET lft='.$left.', rgt='.$right.' WHERE `'.$key_name.'`='.$parent.';');
	//echo 'UPDATE `'.$table.'` SET lft='.$left.', rgt='.$right.' WHERE `'.$key_name.'`='.$parent.';<BR>';
   // return the right value of this node + 1
   return $right+1;
}

// taken from http://www.sitepoint.com/article/hierarchical-data-database and modified
function display_tree($root, $table) {
	global $db;
   // retrieve the left and right value of the $root node
   $sql = 'SELECT lft, rgt FROM `'.$table.'` WHERE category__auto_id='.$root.';';
   //echo $sql;
   $result = mysql_query($sql);
   $row = mysql_fetch_array($result);

   // start with an empty $right stack
   $right = array();

   // now, retrieve all descendants of the $root node
   $sql = 'SELECT category__auto_id, category_name, category_parent, lft, rgt FROM `'.$table.'` WHERE lft BETWEEN '.$row['lft'].' AND '.$row['rgt'].' and category_enabled <> 0 ORDER BY lft ASC;';
   //echo $sql . '<br>';
   $result = mysql_query($sql);
   // display each row
   while ($row = mysql_fetch_array($result)) {
       // only check stack if there is one
       if (count($right)>0) {
           // check if we should remove a node from the stack
           while ($right[count($right)-1]<$row['rgt']) {
               array_pop($right);
           }
       }
       // display indented node title
       // ORIGINAL echo str_repeat('&nbsp;&nbsp;',count($right)).$row['category_name'].'<br>';

        echo str_repeat('--',count($right));
        
        //if($row['rgt'] - $row['lft'] > 1){echo " + ";}else{echo "&nbsp;&nbsp;";}
        
        echo 'id: ' .$row['category__auto_id']. ' | name: ' . $row['category_name'].' | parent: ' .$row['category_parent']. '<br>';


	      // echo '<td>'.str_repeat('&nbsp;&nbsp;&nbsp;',count($right)).$row['name'].'</td><td><a href="?mode=edit&id='.$row['id'].'">edit</a></td><td>'.$thetext."</td>";
       // add this node to the stack
       $right[] = $row['rgt'];
   }
}


function children_id_to_array($array, $table, $parent, $level) {
	global $array;
   // retrieve all children of $parent
   $sql = 'SELECT category__auto_id FROM '.$table.' WHERE category_parent="'.$parent.'" and category__auto_id <> 0;';
   //echo $sql;
   $result = mysql_query($sql);

	//if(count($array) > 50){print_r($array);die();};

   // display each child
   while ($row = mysql_fetch_array($result)) {
       // indent and display the title of this child
       //echo str_repeat('  ',$level).$row['category__auto_id']."\n";
       $array[] = $row['category__auto_id'];

       // call this function again to display this
       // child's children
       children_id_to_array($array, $table, $row['category__auto_id'], $level+1);
   }

}

function children_id_to_array_2(&$child_array, $table, $parent) {
	// a cleaner version of children_id_to_array

	// retrieve all children of $parent
	$sql = 'SELECT category__auto_id FROM '.$table.' WHERE category_parent="'.$parent.'" and category__auto_id <> 0;';
	$result = mysql_query($sql);

	// for each child...
	while ($row = mysql_fetch_array($result)) {
		$child_array[] = $row['category__auto_id'];

		// call this function again to display this child's children
		children_id_to_array_2($child_array, $table, $row['category__auto_id']);
	}
}


function display_tree_table($root, $table) {
	global $db;
   $sql = 'SELECT lft, rgt FROM `'.$table.'` WHERE category__auto_id='.$root.';';
   $result = mysql_query($sql);
   $row = mysql_fetch_array($result);
   $right = array();
   $sql = 'SELECT category__auto_id, category_name, category_parent, lft, rgt FROM `'.$table.'` WHERE lft BETWEEN '.$row['lft'].' AND '.$row['rgt'].' and category_enabled <> 0 ORDER BY lft ASC;';
   $result = mysql_query($sql);
   while ($row = mysql_fetch_array($result)) {
       if (count($right)>0) {
           while ($right[count($right)-1]<$row['rgt']) {
               array_pop($right);
           }
       }

				echo "<tr>";

	        echo str_repeat('<td></td>',count($right));
	        echo '<td><a href = "#" onclick="var replydisplay=document.getElementById(\''.$row['category__auto_id'].'\').style.display ? \'\' : \'none\';document.getElementById(\''.$row['category__auto_id'].'\').style.display = replydisplay;">name</a>: ' . $row['category_name'];
	        echo '<div id="'.$row['category__auto_id'].'" style="display:none">';
	        if($row['category__auto_id'] != 0){echo "<br>parent: " . GetCatName($row['category_parent']);}
	        //echo "<br>color: #ffffff";
					//echo "<br>add a subcategory";
					
				echo "</div></td></tr>";

       $right[] = $row['rgt'];
   }
}

function GetCatName($catid){
	global $db;
	$sql = "SELECT category_name FROM `".table_categories."` where category__auto_id = " . $catid;
	//echo $sql;
	$lastid = $db->get_var($sql);
	//echo "-".$lastid."-";
	return $lastid;
}


function tree_to_array2($root, $table){

	global $db;
	$tree_array = "";
	
   $sql = 'SELECT lft, rgt FROM `'.$table.'` WHERE category__auto_id='.$root.';';
   echo $sql . "<br>";
   $result = mysql_query($sql);
   $row = mysql_fetch_array($result);

   $right = array();

   $sql = 'SELECT category__auto_id, category_color, category_name, category_order, category_parent, lft, rgt FROM `'.$table.'` WHERE lft BETWEEN '.$row['lft'].' AND '.$row['rgt'].' and category_enabled = 1 ORDER BY lft ASC;';
   echo $sql . "<br>";
   $result = mysql_query($sql);
   $i = 1;
   while ($row = mysql_fetch_array($result)) {
       if (count($right)>0) {
           while ($right[count($right)-1]<$row['rgt']) {
               array_pop($right);
           }
       }

       	// we do the if > 0 to ignore the very first item which is "main"
				//if($i > 0){
					$tree_array[$i]->indents = count($right);
					$tree_array[$i]->catname = $row['category_name'];
					$tree_array[$i]->catid = $row['category__auto_id'];
					$tree_array[$i]->catcolor = $row['category_color'];
					$tree_array[$i]->catorder = $row['category_order'];
					$tree_array[$i]->catlft = $row['lft'];
					$tree_array[$i]->catrgt = $row['rgt'];
					$tree_array[$i]->catparent = $row['category_parent'];
				//}				

			 $i = $i + 1;

       $right[] = $row['rgt'];
   }
	
	$tree_array[0]->count = $i - 1;
	return $tree_array;
}


function get_item_path($itemid){
	$sql = "SELECT category__auto_id FROM ".table_categories." WHERE lft <10003 AND rgt >10004 ORDER BY lft ASC;";
}



function get_path($node) {
   // look up the parent of this node
   $sql = 'SELECT category_parent, category_name FROM '.table_categories.' WHERE category__auto_id="'.$node.'" and category__auto_id<>"9999";';
   echo $sql;
   $result = mysql_query($sql);
   $row = mysql_fetch_array($result);

   // save the path in this array [5]
   $path = array();

   // only continue if this $node isn't the root node
   // (that's the node with no parent)
   if ($row['category_parent']!='') {
       // the last part of the path to $node, is the name
       // of the parent of $node
       $path[] = $row['category_name'];

       // we should add the path to the parent of this node
       // to the path
       $path = array_merge(get_path($row['category_parent']), $path);
   }

   // return the path
   return $path;
} 

	function display_the_tree_table(){
		echo "<table>";
		display_tree_table(0, table_categories);
		echo "</table>";
	}

	function display_the_tree(){
		display_tree(0, table_categories);
	}

	function rebuild_the_tree(){
		rebuild_tree(0, 0, table_categories, "category__auto_id", "category_parent");
	}
	
	
	function parse_tree_array($tree_array){
		
		$indents = -1;
		for ($i = 1; $i <= $tree_array[0]->count; $i++) {
			if ($tree_array[$i]->indents > $indents){
				$tree_array[$i]->startUL = 1;
			}
			if ($tree_array[$i]->indents < $indents){
				$tree_array[$i]->endUL = 1;
				$tree_array[$i]->endULcount = $indents - $tree_array[$i]->indents;
				$tree_array[$i]->endULs = str_repeat('</ul>', $indents - $tree_array[$i]->indents);
			}

			$tree_array[$i]->addsubcatLink = '?action=addsubcat&parentid='.$tree_array[$i]->catid;
			$tree_array[$i]->disablecatLink = '?action=disablecat&catid='.$tree_array[$i]->catid;
			$tree_array[$i]->movedownLink = '?action=movedown&catid='.$tree_array[$i]->catid;
			$tree_array[$i]->moveupLink = '?action=moveup&catid='.$tree_array[$i]->catid;
					
			if($tree_array[$i]->catrgt - $tree_array[$i]->catlft = 1){$tree_array[$i]->hasSubs = 1;}else{$tree_array[$i]->hasSubs = 0;}			
			
			// show the disable link
				// we want to make sure the item after this is the same indents or less (meaning it doesnt have any sub-cats
				if($i < $tree_array[0]->count){
					if($tree_array[$i]->indents >= $tree_array[$i+1]->indents){
						if($i > 1){
							$tree_array[$i]->allowDisable = 1;
						}
					}
				}
				// if this is the very last item, it won't have any subcats and is safe to disable.
				if($i == $tree_array[0]->count){
					$tree_array[$i]->allowDisable = 1;
				}
			//				
				
			$indents = $tree_array[$i]->indents;
		}
		
		return $tree_array;
	}

function Rebuild_Safe_Category_Names(){
	global $db;
	$cateogories = $db->get_results("SELECT * FROM ".table_categories." where category__auto_id<>'9999';");
	if ($cateogories) {
		foreach($cateogories as $category) {
			
			
			$cat_path = "";
			$path = get_path($category->category__auto_id);	
			$count = 0;
			foreach ($path as $name) {
				if($count > 0){$cat_path .= "/";}
			  $cat_path .= makeCategoryFriendly($name);
			  $count = $count + 1;
			}
			$cat_path .= "/";
			
			$db->query("UPDATE ".table_categories." SET `category_full_path` = '".$cat_path."', `category_safe_name` = '".makeCategoryFriendly($category->category_name)."' WHERE `category__auto_id` ='".$category->category__auto_id."';");
			
			//echo $cat_path . "<br>";			
		}
	}
}

function GetLastCategoryOrder($catParentId){
	global $db;
	
	$sql = "SELECT category_order FROM ".table_categories." where category_parent = ".$catParentId." order by category_order DESC;";
	//echo $sql;
	$MaxOrder = $db->get_var($sql);
	//echo $MaxOrder;
	return $MaxOrder;
}


function tree_to_array($root, $table, $showRoot = TRUE) {
	// showRoot -- Do we want to include the "root" category named "all" in our results -- all subcats WILL appear regardless
	
	
	global $db;
   $sql = 'SELECT lft, rgt FROM `'.$table.'` WHERE category__auto_id='.$root.';';
   $result = mysql_query($sql);
   $row = mysql_fetch_array($result);
   $right = array();
   $sql = 'SELECT * FROM `'.$table.'` WHERE lft BETWEEN '.$row['lft'].' AND '.$row['rgt'].' and category_enabled <> 0 ORDER BY lft ASC;';
   $result = mysql_query($sql);
   $i = 0;
   $lastspacer = 0;
   while ($row = mysql_fetch_array($result)) {
       if (count($right)>0) {
           // check if we should remove a node from the stack
           while ($right[count($right)-1]<$row['rgt']) {
               array_pop($right);
           }
       }

				$array[$i]['spacercount'] = count($right);
				$array[$i]['lastspacercount'] = $lastspacer;
				$array[$i]['spacerdiff'] = abs($lastspacer - count($right));
				$array[$i]['auto_id'] = $row['category__auto_id'];
				$array[$i]['name'] = $row['category_name'];
				$array[$i]['safename'] = $row['category_safe_name'];
				$array[$i]['color'] = $row['category_color'];
				$array[$i]['parent'] = $row['category_parent'];
				$array[$i]['parent_name'] = GetCatName($row['category_parent']);
				$array[$i]['subcat_count'] = GetSubCatCount($row['category__auto_id']);
				$array[$i]['parent_subcat_count'] = GetSubCatCount($row['category_parent']);


				$lastspacer = count($right);
				$i = $i + 1;
       $right[] = $row['rgt'];
   }

	if($showRoot == FALSE){$array = my_array_unset($array,0);}
	return $array;
}

function my_array_unset($array,$index) {
  // unset $array[$index], shifting others values
  $res=array();
  $i=0;
  foreach ($array as $item) {
   if ($i!=$index)
     $res[]=$item;
   $i++;
  }
  return $res;
}

function GetSubCatCount($catid){
	global $db;
	$sql = "SELECT count(*) FROM `".table_categories."` where category__auto_id <> 0 AND category_parent = " . $catid;
	//echo $sql;
	$lastid = $db->get_var($sql);
	//echo "-".$lastid."-";
	return $lastid;
}

function OrderNew(){
	global $db;
	$cateogories = $db->get_results("SELECT * FROM ".table_categories.";");
	if ($cateogories) {
		foreach($cateogories as $category) {
			$sub_cateogories = $db->get_results("SELECT * FROM ".table_categories." where category_parent = ".$category->category__auto_id." and category_order = 0 AND category__auto_id<>0;");
			if ($sub_cateogories) {
				if(count($sub_cateogories) > 1){
					$OrderNum = GetLastCategoryOrder($category->category__auto_id);
					foreach($sub_cateogories as $sub_category) {
						$OrderNum = $OrderNum + 1;
						//echo $sub_category->category_name.'-'.$sub_category->category_order."<BR>";
						$sql = "Update ".table_categories." set category_order = " . $OrderNum . " where category__auto_id = ".$sub_category->category__auto_id.";";
						//echo $sql . "<BR>";
						$db->query($sql);
					}
					//echo "<hr>";
				}
			}
		}
	}
}

function Cat_Safe_Names(){
	global $db;
	$cats = $db->get_col("Select category_name from " . table_categories . ";");
	if ($cats) {
		foreach($cats as $catname) {
			$db->query("UPDATE `" . table_categories . '` SET `category_name` = "'.safeAddSlashes($catname).'"' . ", `category_safe_name` = '".makeCategoryFriendly($catname)."' WHERE `category_name` =".'"'.safeAddSlashes($catname).'";');
		}
	}
	$cats = $db->get_col("Select category__auto_id from " . table_categories . ";");
	if ($cats) {
		foreach($cats as $catid) {
			$db->query("UPDATE `" . table_categories . "` SET `category_id` = ".$catid." WHERE `category__auto_id` ='".$catid."';");
		}
	}
}

?>