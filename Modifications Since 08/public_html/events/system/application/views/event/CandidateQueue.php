<?
$this->load->view('view_layout/header.php', $data);
?>
<!-- 
#dependency event.css

-->
<div id="ucp">
	<div class="section">
		<h3>Speaker Queue</h3>
	</div>
	
	<br />
	<div class="section">
		<h3>Your Current Question</h3>
	</div>
	<div style="margin: 10px;">
		<input type="button" value="Answer Finished" onclick="new Ajax.Request(site_url+'forums/next_question/<?=$event_id?>',  { onSuccess: function(transport){    }, onFailure: function(){ alert('Could not change question.') } });">
	</div>
	<div id="current_question" class="current_question"></div>	
	<div class="section">
		<h3>Upcoming Questions</h3>
	</div>
	<div id="upcoming_questions" class="upcoming_questions">
	</div>
</div>
<script type="text/javascript" charset="utf-8">
	new Ajax.PeriodicalUpdater('current_question', site_url + 'forums/candidateQueue/<?=$event_name?>/current_question', {
	  frequency: 10
	});
	//new Effect.Opacity ('upcoming_questions',{duration:.5, from:1.0, to:0.7});
	new Ajax.PeriodicalUpdater('upcoming_questions', site_url + 'forums/candidateQueue/<?=$event_name?>/upcoming_questions', {
	  frequency: 10
	});	
</script>
<?
$this->load->view('view_layout/footer.php', $data);
?>