<?
error_reporting(E_ALL);
ini_set('display_errors',true);
if (!isset($_GET['topic'])) {
	header('location:search.php');
	exit();
}
//get some desc
$url="http://practice.wikireview.com/api.php?action=query&format=php&prop=revisions&rvprop=content&titles=".str_replace(" ",'_',$_GET['topic']);

$data = unserialize(file_get_contents($url));
$displayArray = array_pop($data['query']);
//var_dump($displayArray);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>Politic 2.0</title>
<link rel="stylesheet" type="text/css" href="ajaxtabs/ajaxtabs.css" />
<script type="text/javascript" src="ajaxtabs/ajaxtabs.js">

/***********************************************
* Ajax Tabs Content script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>
</head>
<h3>Topic Page</h3>
<form method='get' action='search.php'>
<p>Search: <input type="text" name="search" size="20">  </p>
<p><input type="submit" value="Search"></p>
</form>
<br />
<div id='area'>
<ul id="maintab" class="shadetabs">
<li class="selected"><a href="#default" rel="ajaxcontentarea">Overview</a></li>
<li class="nonSelected"><a href="wr.php?topic=<?= str_replace(" ",'_',$_GET['topic']); ?>" rel="ajaxcontentarea">WikiReview</a></li>
<li class="nonSelected"><a href="" rel="ajaxcontentarea">TagJungle</a></li>
</ul>
<div id="ajaxcontentarea" class="contentstyle">
<?
$page = array_shift($displayArray);
//$page['title']
//$page['pageid']
//$page['ns']
//$page['revisions']
echo "<a href='topic.php?topic=".$page['title']."'><strong>".$page['title']."</strong></a><br/>";
//get brief desc first revision record
$desc = array_shift($page['revisions']);
//break up parts of the array	
$contentArray = explode('|',$desc['*']);
?>

<div id='pro'>
<?=  $contentArray[2]; ?>
</div>

<div id='con'>
<?=  $contentArray[3]; ?>
</div>

</div>
</div>

<script type="text/javascript">
//Start Ajax tabs script for UL with id="maintab" Separate multiple ids each with a comma.
startajaxtabs("maintab")
</script>


</body>

</html>
