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

/*
<br />
Live feed of <?=$event_name;?> will be available: 
<br />
<script language="JavaScript" src="javascript/countdown.js"></script>
</div>
*/?>
<br />
The Event is Over.<br /> Look for a copy of the feed on our Blog.
<?/*if (!$blocked) { ?>
<!-- Begin Flash Video for VitalStream FVSS -->
<!-- Note: Extra space was added to "width=" & "height=" for the size of the skin -->
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="320" height="240" id="FLVPlayer">
<param name="movie" value="http://http.vitalstreamcdn.com/flashskins/FLVPlayer.swf" />
<param name="align" value="" />
<param name="salign" value="LT" />
<param name="quality" value="high" />
<param name="scale" value="showall" />
<param name="FlashVars" value="&bgColor=0xFFFFFF&serverName=wmssdemo3.flashsvc.vitalstreamcdn.com&appName=wmssdemo3_vitalstream_com/_definst_&streamName=live_P20_SLC_High&autoPlay=true&skinName=http://http.vitalstreamcdn.com/flashskins/clearSkin_1&bufferTime=3&autoRewind=true" />
<embed src="http://http.vitalstreamcdn.com/flashskins/FLVPlayer.swf" flashvars="&bgColor=0xFFFFFF&configFile=&serverName=wmssdemo3.flashsvc.vitalstreamcdn.com&appName=wmssdemo3_vitalstream_com/_definst_&streamName=live_P20_SLC_High&autoPlay=true&skinName=http://http.vitalstreamcdn.com/flashskins/clearSkin_1&bufferTime=3&autoRewind=true" quality="high" scale="showall" width="320" height="240" name="FLVPlayer" align="" salign="LT" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
 </object>
<!-- saved from url=(0013)about:internet -->
<!-- End Flash Video for VitalStream FVSS -->
<? } else { ?>
<p>Users at the live event will <br />be blocked from the live feed.</p>
<? } */?>
<?//=anchor('information/videoFeedLow/' . url_title($event_name), 'Low bandwidth feed')?>
</div>
</body>
</html>