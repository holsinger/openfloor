<?php header("HTTP/1.1 404 Not Found"); ?>
<html>
<head>
<title>404 Page Not Found</title>
<style type="text/css">

body {
background-color:	#fff;
margin:				40px;
font-family:		Lucida Grande, Verdana, Sans-serif;
font-size:			12px;
color:				#000;
text-align: center;
}

#content  {
background-color:	#fff;
padding:			20px 20px 12px 20px;
}

h1 {
font-weight:		normal;
font-size:			14px;
color:				#990000;
margin: 			0 0 4px 0;
}
</style>
</head>
<body>
	<img src='http://www.politic20.com/images/logo.png'>
	<br /><br />
	<br /><br />
	<h1>Opps! We should fix this!</h1>
	<div id="content">
		<!--<h1><?php echo $heading; ?></h1>-->
		<?php 
		echo $message; 
		mail('kleinschnitz@politic20.com',$heading,$message);
		?>
	</div>
</body>
</html>