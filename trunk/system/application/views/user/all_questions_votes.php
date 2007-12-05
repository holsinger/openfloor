<?php
$data['sub_title'] = $header; 
$table_template = ($type == 'vote') ?
array('Voted' => 'vote_value', 'Event' => 'event_name', 'Question' => 'question_name') :
array('Event' => 'event_name', 'Question' => 'question_name') ;
?>
	
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<? $this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
	<p>
	<table class="user-profile">
	<tr><? foreach($table_template as $k => $v) echo "<th>$k</th>" ?></tr>
	<? 
	$rowClass = 'normal'; 
	foreach($result as $k1 => $v1):
		if ($type == 'vote') $v1['vote_value'] = ($v1['vote_value'] > 0) ? '<img src="./images/thumbsUp.png">' : '<img src="./images/thumbsDown.png">'; ?>
		<tr class="<?=$rowClass?>"><? foreach($table_template as $v) echo "<td>{$v1[$v]}</td>" ?></tr>
		<? $rowClass = $rowClass == 'normal' ? 'alternate' : 'normal' ; 
	endforeach; ?>
	</table>
	</p>
</div>	

<?$this->load->view('view_includes/footer.php');?>