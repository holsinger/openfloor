<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<base href="<?= $this->config->site_url();?>" />
	<title>Admin Dashboard</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<link rel="stylesheet" type="text/css" href="css/admin_dashboard.css" />
</head>
<body>

<h2>Admin Dashboard</h2>

<h3>Last 10 Users Created</h3>
<div id="last_10_users"><? $this->load->view('admin/last_10_users'); ?></div>

<h3>Last 10 Flags Set</h3>
<div id="last_10_flags"><? $this->load->view('admin/last_10_flags'); ?></div>

<h3>Last 10 Questions Asked</h3>
<div id="last_10_questions"><? $this->load->view('admin/last_10_questions'); ?></div>

</body>
</html>