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
	<script type="text/javascript">
	ajaxOn = true;
	site_url = '<?= $this->config->site_url();?>';
	var event_name = '<?=$event?>';
	var cans = [<? $cans = ''; foreach($candidates as $v) $cans .= "'{$v['can_id']}', "; echo substr($cans, 0, -2); ?>];	
	</script>

	<script type="text/javascript" src="javascript/cpUpdater.js"></script>
	<script type="text/javascript">cpUpdater.cpUpdate();</script>
	<style type="text/css" media="screen" >
		/* put the left rounded edge on the track */
		.track-left {
			position: absolute;
			width: 5px;
			height: 9px;
			background: transparent url(./images/slider-images-track-left.png) no-repeat top left;
		}

		/* put the track and the right rounded edge on the track */
		.track {
			background: transparent url(./images/slider-images-track-right.png) no-repeat top right;
		}
	</style>
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
					<td><div id="your-reaction-<?=$v['can_id']?>"><?$this->load->view('user/_userReactSlider', $v)?></div></td>
					<td><div id="overall-reaction-<?=$v['can_id']?>"><?$this->load->view('user/_overallReaction', $v)?></div></td>
				</tr>
				<? $class = $class ? '' : ' class="alternate"' ?>
				<? endforeach; ?>
			</table>	
		</div>
		
		<h3> &nbsp;&nbsp;Upcoming Questions:</h3>
		<div style="text-align:right"><a onClick="javascript:new Effect.toggle('cp-ask-question','blind', {queue: 'end'});">Ask a Question</a></div>
		<div id="cp-ask-question" style="display:none"><? $this->load->view('question/_submit_question_form') ?></div>
		<div id="upcoming_questions" class="upcoming_questions">		
			<?$this->load->view('user/cp_upcoming_questions.php')?>
		</div>
</body>
</html>