<?php
include('config.php');
include(mnminclude.'trackback.php');
include(mnminclude.'link.php');

function trackback_response($error = 0, $error_message = '') {
	header('Content-Type: text/xml; charset=UTF-8');
	if ($error) {
		echo '<?phpxml version="1.0" encoding="utf-8"?'.">\n";
		echo "<response>\n";
		echo "<error>1</error>\n";
		echo "<message>$error_message</message>\n";
		echo "</response>";
		die();
	} else {
		echo '<?phpxml version="1.0" encoding="utf-8"?'.">\n";
		echo "<response>\n";
		echo "<error>0</error>\n";
		echo "</response>";
	}
	die;
}

$tb_url    = strip_tags($_POST['url']);
$title     = strip_tags($_POST['title']);
$excerpt   = strip_tags($_POST['excerpt']);
$blog_name = strip_tags($_POST['blog_name']);
$charset   = strip_tags($_POST['charset']);


if(!empty($charset)) {
	$charset=preg_replace('/charset=([a-Z0-9\-])/', "$1", $GLOBALS['HTTP_RAW_POST_DATA']);
}


	print $charset . "\n";
	print $title . "\n\n\n";
if(!empty($charset)) {
	$title = @iconv($charset, 'UTF-8//IGNORE', $title);
	$excerpt = @iconv($charset, 'UTF-8//IGNORE', $excerpt);
	$blog_name = @iconv($charset, 'UTF-8//IGNORE', $blog_name);
}

$tb_id = strip_tags($_GET['id']);

if ( !intval( $tb_id ) )
	trackback_response(1, 'I need an ID for this to work.');

if (empty($title) && empty($tb_url) && empty($blog_name)) {
	// If it doesn't look like a trackback at all...
	header('Location: ' . get_permalink($tb_id));
	exit;
}

if ( !empty($tb_url) && !empty($title) && !empty($tb_url) ) {
	header('Content-Type: text/xml; charset=UTF-8');

	$title =  htmlspecialchars( strip_tags( $title ) );
	$title = (strlen($title) > 150) ? substr($title, 0, 150) . '...' : $title;
	$excerpt = strip_tags($excerpt);
	$excerpt = (strlen($excerpt) > 200) ? substr($excerpt, 0, 200) . '...' : $excerpt;

	$trackres = new Trackback;
	$trackres->link=$tb_id;
	$trackres->type='in';
	$trackres->url = $tb_url;
	$dupe = $trackres->read();
  
	$contents=@file_get_contents($tb_url);
	if(!$contents) 
		trackback_response(1, 'The provided URL does not seem to work.');
	

	$permalink=get_permalink($tb_id);
    $permalink_q=preg_quote($permalink,'/');
	$pattern="/<\s*a.*href\s*=[\"'\s]*".$permalink_q."[\"'\s]*.*>.*<\s*\/\s*a\s*>/i";
	if(!preg_match($pattern,$contents))
		trackback_response(1, 'The provided URL does not have a link back to us.');
	
	$trackres->title=$title;
	$trackres->content=$excerpt;
	$trackres->status='ok';
	$trackres->store();

	print $trackres->title . "\n\n\n";
	$trackres->read();
	print $trackres->title . "\n\n\n";
	trackback_response(0);
}

?>