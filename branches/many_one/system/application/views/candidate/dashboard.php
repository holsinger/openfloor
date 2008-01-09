<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>Candidate Dashboard</title>
	<base href="<?= $this->config->site_url();?>" />
	<style media="all" type="text/css">@import "css/candidate_dashboard.css";</style>
	<script type="text/javascript" src="javascript/clock.js"></script>
</head>

<body>

<script language="JavaScript">
setTimeout("refresh_location()", 1000*5); // 5 seconds
function refresh_location () {
	location = "<?=$this->config->site_url()."forums/candidate_dashboard/$event_name"?>";
}
</script>

<div id="content">
  <? $this->load->view('candidate/dashboard_content.php') ?>
</div>


</body>
</html>