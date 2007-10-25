<!--
	#dependency clock.js
-->

<h3>Candidate Dashboard</h3>
<p><table class="can-dashboard-current-question">
<tr><td>Current Question: </td>		<td><strong><?=$questions[0]['question_name']?></strong></td></tr>
<tr><td>Total Votes: </td>			<td><span class="total-votes"><?=$totalVotes?></span></td></tr>
<tr><td>Total Positive Votes:</td>	<td><span class="total-positive-votes"><?=$totalPositiveVotes?></span></td></tr>
<tr><td>Total Negative Votes: </td>	<td><span class="total-negative-votes"><?=$totalNegativeVotes?></span></td></tr>
</table></p>
<!-- <div>Current Question: <?=$questions[0]['question_name']?></div> -->
<div>Question Timer: <?=$timerHTML?></div>
<div>Local Time: <span id="clock">&nbsp;</span></div>
<script language="JavaScript">updateClock(); setInterval('updateClock()', 1000 );</script>
<? if($this->userauth->isAdmin()): ?>
<div>
	<p><?= form_open("forums/restart_question_timer/$event_name") ?>
	<?= form_submit('', 'Reset Timer') ?>
	<?= form_close() ?>
	</p>
</div>
<? endif; ?>