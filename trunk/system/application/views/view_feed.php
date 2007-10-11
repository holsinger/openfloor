<?
$stream_link = $stream == 'high' ? 'low' : 'high';
$blocked_message = "<p>Thank you for saving us bandwidth by not watching the internet feed from the event.</p>";

$this->load->view('stream/stream_header.php');
if (!$blocked) echo "<p>{$stream_html[$stream]}</p>";
else echo "<p>$blocked_message</p>";
echo '<p>'.anchor("forums/stream_$stream_link/" . url_title($event_name), ucfirst($stream_link) . ' bandwidth feed').'</p>';
$this->load->view('stream/stream_footer.php');
?>