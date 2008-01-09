<table>
	<th>Name</th><th>Email</th><th>Date Created</th>
	<? foreach($last_10_users as $user): ?>
	<tr><td><?= $user->user_name ?></td><td><?= $user->user_email ?></td><td><?= $user->timestamp ?></td></tr>
	<? endforeach; ?>
</table>	
