<table>
	<th>Flag Type</th><th>What/Who</th><th>Flag</th><th>Reported By</th>
	<? foreach($last_10_flags as $flag): ?>
		<tr><td><?= $flag['type'] ?></td><td><?= $flag['object'] ?></td><td><?= $flag['flag'] ?></td><td><?= $flag['reporter'] ?></td></tr>
	<? endforeach; ?>
</table>