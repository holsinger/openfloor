<html>
<head>
<title>Database Error</title>
<style type="text/css">

body {
background-color:	#fff;
margin:				40px;
font-family:		Lucida Grande, Verdana, Sans-serif;
font-size:			12px;
color:				#0055A4;
text-align: center;
}

#content  {
border:				#999 1px solid;
background-color:	#fff;
padding:			20px 20px 12px 20px;
}

h1 {
font-weight:		normal;
font-size:			14px;
color:				#0055A4;
margin: 			0 0 4px 0;
}
</style>
</head>
<body>
	<div id="content">
	<img src='http://www.openfloortech.com/logo.png'>
	<br /><br />
	<br /><br />
	<h1>Oops! A system error has occured. An error report has been dispatched to our technical team.</h1>
	<div id="content">
		<!--<h1><?php echo $heading; ?></h1>-->
		<?php 
		//echo $message; 
		 #Smail('webmaster@openfloortech.com',$heading,$message);
		?>
	</div>
	</div>
</body>
</html>