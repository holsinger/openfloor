<h3>Last 10 answered questions</h3>
<?= anchor("user/all/answered/$user_name", 'See all') ?>
<table class="user-profile">
	<tr>
		<th>Event</th>
		<th>Request User</th>
		<?php if ($this->userauth->isAdmin()):?>
		<th>Option</th>
		<?php endif;?>
	</tr>
	<? $rowClass = 'normal'; foreach($request_events as $k => $v): ?>
	<tr class="<?=$rowClass?>">
		<td><?=$v['event_name']?></td>
		<td><?=$v['user_name']?></td>
		<?php if ($this->userauth->isAdmin()):?>
		<td><?= anchor("event/agree_student_request/" . $v['event_id'] . "/agree",'Agree')?>&nbsp;&nbsp;
			<?= anchor("event/agree_student_request/" . $v['event_id'] . "/delete",'Delete')?></td>
		<?php endif;?>
	</tr>
	<? $rowClass = $rowClass == 'normal' ? 'alternate' : 'normal' ; ?>
	<? endforeach; ?>
</table>