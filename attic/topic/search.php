<?
error_reporting(E_ALL);
//ini_set('display_errors',true);
$postResult = '';
if ( isset($_GET['search']) ) {

$url='http://practice.wikireview.com/api.php?action=opensearch&search='.$_GET['search'];

//parse results
$resultsArray = json_decode(file_get_contents($url));

$searchTerm = array_shift($resultsArray);

$urlParams = implode("|",$resultsArray[0]);
$urlParams = str_replace(' ','_',$urlParams);

//get some desc
$url="http://practice.wikireview.com/api.php?action=query&format=php&prop=revisions&rvprop=content&titles=".$urlParams;

//$xml = new SimpleXMLElement(file_get_contents($url));
$data = unserialize(file_get_contents($url));
$displayArray = array_pop($data['query']);
//var_dump($displayArray);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>Politic 2.0</title>

</head>

<body>
<h3>Politic 2.0 Demo...</h3>
<form method='get'>
<p>Search: <input type="text" name="search" size="20">  </p>
<p><input type="submit" value="Search"></p>
</form>

<br />
<br />
<div id='area'>
<h2>Results For <?= $searchTerm;?></h2>
<?
foreach ($displayArray as $page) {
	//$page['title']
	//$page['pageid']
	//$page['ns']
	//$page['revisions']
	echo "<a href='topic.php?topic=".$page['title']."'><strong>".$page['title']."</strong></a><br/>";
	//get brief desc first revision record
	$desc = array_shift($page['revisions']);
	//break up parts of the array	
	$contentArray = explode('|',$desc['*']);
	echo substr($contentArray[1],0,250);
	echo '<br><br>';
	
}
?>
</div>

</body>

</html>
