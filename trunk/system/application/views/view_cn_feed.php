<?php

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<base href="<?= $this->config->site_url();?>" />
	<title>Live ConventionNEXT Feed</title>
	<link rel="stylesheet" type="text/css" href="css/all.css" />
	<style type="text/css">body{min-width:10px;}</style>
	<!-- Date: 2007-08-02 -->
</head>
<body>
<script language="JavaScript">
//TargetDate = "08/08/2007 7:45 PM";
TargetDate = "<?=$date?>";
BackColor = "white";
ForeColor = "navy";
CountActive = true;
CountStepper = -1;
LeadingZero = true;
DisplayFormat = "%%D%% Days, %%H%% Hours, %%M%% Minutes, %%S%% Seconds.";
FinishMessage = "It is finally here!";
</script>
<div style="background:#FFFFFF;height:100%;">
<?//=($blocked)?'blocked':'free';?>
<br />
Live feed of <?=$event_name;?> will be available: 
<br />
<script language="JavaScript" src="javascript/countdown.js"></script>
</div>
</body>
</html>