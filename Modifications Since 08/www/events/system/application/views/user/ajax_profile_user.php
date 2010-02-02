<h3>Freeze Account User</h3>
<?= anchor("user/all/comments/$user_name", 'See all') ?>
<table class="user-profile">
	<tr>
		<th>Account</th>
		<th>Email</th>
	</tr>
	
	<? $rowClass = 'normal'; 
	foreach($account as $k => $v): ?>
	<tr class="<?=$rowClass?>">
		<td><?=$v['user_name']?></td>
		<td><?=$v['user_email']?></td>
	</tr>
	<? $rowClass = $rowClass == 'normal' ? 'alternate' : 'normal' ;?>
	<? endforeach; ?>
</table>