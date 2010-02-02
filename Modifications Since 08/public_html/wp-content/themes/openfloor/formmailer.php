<?php
/* Copyright (c) 2007 WordPress Remix <http://wpremix.com/> */

// make sure this script was called via POST method, not GET
if ('POST' != $_SERVER['REQUEST_METHOD']) {
    exit('Not a POST request.');
}

// make your changes here
$sender    = 'yourname@yoursite.com';
// enter email address, where you wish to receive the contact inquiry
$recipient = 'yourname@yoursite.com';
// edit the subject line here
$subject   = 'Submitted form contents from your website';
$body      = "Input from submitted form:\n\n";
// redirect the user, where you want them after they submit the form
$redirect  = 'http://wpremix.com/demo/home/';







// loop through form input
foreach ($_POST as $key => $value) {
    $body .= $key . ' : ' . $value . "\n\n";
}

// additional (client) information
$body .= "\n\nAdditional (client) information:\n\n"
    . 'Date = ' . date('Y-m-d H:i') . "\n"
    . 'Browser = ' . HTTP_USER_AGENT . "\n"
    . 'IP Address = ' . $_SERVER['REMOTE_ADDR'] . "\n"
    . 'Hostname = ' . gethostbyaddr($_SERVER['REMOTE_ADDR']) . "\n";

// send email
mail($recipient, $subject, $body, 'From: ' . $sender);

// redirect to confirmation page
header('Location: ' . $redirect);
?>