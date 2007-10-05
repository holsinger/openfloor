<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<base href="<?= $this->config->site_url();?>" />
	<title>myControlPanel</title>
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
</head>
<body>
	<table>
		<tr><th>Candidate</th><th>Overall Reaction</th></tr>		
		<? $class = '' ?>
		<? foreach($candidates as $v): ?>
		<tr<?=$class?>>
			<td><?=$v['can_display_name']?></td>
			<td><div id="overall-reaction-<?=$v['can_id']?>"><?$this->load->view('user/_overallReaction', $v)?></div></td>
		</tr>
		<? $class = $class ? '' : ' class="alternate"' ?>
		<? endforeach; ?>
	</table>
</body>
</html>