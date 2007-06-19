<?php
include_once 'apps/admin_session.php';
include_once 'includes/header.php'; 

/* begin logic */

$userID = 1; // temporary

$dbf = new dbfunctions();
$dbf->query('SELECT * FROM cn_events');

$events = array();
while($row = $dbf->next()) $events[] = $row;

function populateEventsSelect($events)
{
	$output;
	foreach($events as $v) $output .= "<option value=\"{$v[0]}\">{$v[1]}</option>";
	return $output;
}

function addQuestion($eventID, $userID, $questionName, $questionDesc, $tags)
{
	/* deal with tags first */
	$tags = str_replace(array(' ', "\t"), '', $tags);
	$a = explode(',',$tags);
	$tags = array();
	foreach($a as $v) if(!empty($v)) $tags[] = $v;
	
	global $dbf;
	$tempArray = $tags;
	foreach($tempArray as $k=>$v) $tempArray[$k] = '\'' . $v . '\'';
	
	$dbf->query('SELECT tag_id, value FROM cn_tags WHERE value IN (' . implode(',',$tempArray) . ')');
	
	$existingKs;
	$existingVs;
	while($row = $dbf->next())
	{
		$existingKs[] = $row[0];
		$existingVs[] = $row[1];
	}
	
	$diff = array_diff($tags, $existingVs);
	
	$newKs = array();
	if(!empty($diff)) foreach($diff as $v) if($k=insertTag($v)) $newKs[] = $k;
	
	$newKs = array_merge($newKs, $existingKs);
	
	/* insert the question*/
	$query = "INSERT INTO cn_questions (question_name, question_desc, fk_user_id, fk_event_id) ";
	$query .="VALUES ('$questionName', '$questionDesc', $userID, $eventID)";
	
	if($dbf->query($query))
		$questionID = $dbf->last_id();
		
	/* insert proper associations */
	if(isset($questionID)) foreach($newKs as $v) insertTagAssociation($questionID, $v, $userID);

	echo 'success!';
}

function insertTag($value)
{
	global $dbf;
	if ($dbf->query("INSERT INTO cn_tags (value) VALUES ('$value')"))
		return $dbf->last_id();
	else
		return false;	
}

function insertTagAssociation($questionID, $tagID, $userID)
{
	global $dbf;
	
	$query = "INSERT INTO cn_idx_tags_questions (fk_question_id, fk_tag_id, fk_user_id) ";
	$query .="VALUES ($questionID, $tagID, $userID)";
	$dbf->query($query);
}

if (isset($_POST['submitted'])) // on submit
{
	if (!empty($_POST['question']) && $_POST['event']!='0')
	{
		addQuestion($_POST['event'], $userID, $_POST['question'], $_POST['desc'], $_POST['tags']);
	}
}

/* end logic */

echo '
<div align="center">
	<form method="post" action="'.$_SERVER['PHP_SELF'].'">
		<h3>Event</h3>
		<select name="event">
			<option value="0"></option>'.
			populateEventsSelect($events)
		.'</select>
		<h3>Question</h3>
		Enter a question you would like asked.<br/>
		<input type="text" name="question" maxlength="100"/>
		<h3>Description</h3>
		Write a brief description explaining your quesiton (limit 250 chars).<br/>
		<textarea rows="2" cols="20" name="desc">y helo thar</textarea>
		<h3>Tags</h3>
		Short, generic words separated by \',\' (commas) ex...<br/>
		<input type="text" name="tags"/><br/><br/>
		<input type="submit" value="Submit Question"/>
		<input type="hidden" name="submitted" value="true"/>
	</form>
</div>
';

include_once 'includes/footer.php';