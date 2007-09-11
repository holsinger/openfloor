<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<base href="<?= $this->config->site_url();?>" />
	<title>myControlPanel</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="Rob Stefanussen">
	<link rel="stylesheet" type="text/css" href="css/all.css" />
	<link rel="stylesheet" type="text/css" href="css/view_live_queue.css" />
	<script type="text/javascript" src="javascript/lib/prototype.js"></script>
	<script src="javascript/src/scriptaculous.js" type="text/javascript"></script>
	<script type="text/javascript">site_url = '<?= $this->config->site_url();?>';var event_name = '<?=$event?>';</script>

	<script type="text/javascript" src="javascript/cpUpdater.js"></script>
	<script type="text/javascript">cpUpdater.cpUpdate();</script>
</head>
<body>
		<br />
		<span class='queue-logo'>
			<img src="./images/bg-convention-next.gif" alt="convention-next"/>
		</span>
		<br />
		<ul class="top-nav"></ul>
		
		<h3> &nbsp;&nbsp;Current Question</h3>	
		<div id="current_question" class="current_question">		
			<?$this->load->view('user/cp_current_question.php')?>		
		</div>
		
		<h3> &nbsp;&nbsp;Participant Reaction</h3>
		<div id="user-reaction">
			<table>
				<tr><th>Candidate</th><th>Your Reaction</th><th>Overall Reaction</th></tr>
				<? $class = '' ?>
				<? foreach($candidates as $v): ?>
				<tr<?=$class?>>
					<td><?=$v['can_display_name']?></td>
					<td><?$this->load->view('user/_userReactSlider', $v)?></td>
					<td><?$this->load->view('user/_overallReaction', $v)?></td>
				</tr>
				<? $class = $class ? '' : ' class="alternate"' ?>
				<? endforeach; ?>
			</table>	
		</div>
		
		<h3> &nbsp;&nbsp;Upcoming Questions:</h3>
		<div id="upcoming_questions" class="upcoming_questions">		
			<?$this->load->view('user/cp_upcoming_questions.php')?>
		</div>
</body>
</html>