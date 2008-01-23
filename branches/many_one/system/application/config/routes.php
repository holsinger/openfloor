<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
| 	www.your-site.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://www.codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['scaffolding_trigger'] = 'scaffolding';
|
| This route lets you se t a "secret" word that will trigger the
| scaffolding feature for added security. Note: Scaffolding must be
| enabled in the controller in which you intend to use it.
|
*/

$route['default_controller'] = "event";
$route['scaffolding_trigger'] = "";
//more url clean up
$route['login'] = 'user/login';
$route['logout'] = 'user/logout';
$route['create_account'] = 'user/createAccount';
$route['signup'] = 'user/createAccount';

//we need these to keep controller paths working  (all controllers need to be here)
$route['admin/([a-zA-Z0-9_\-\/\.]+)'] = "admin/$1";
$route['admin'] = "admin";
$route['comment/([a-zA-Z0-9_\-\/\.]+)'] = "comment/$1";
$route['comment'] = "comment";
$route['contact/([a-zA-Z0-9_\-\/\.]+)'] = "contact/$1";
$route['contact'] = "contact";
$route['event/([a-zA-Z0-9_\-\/\.]+)'] = "event/$1";
$route['event'] = "event";
$route['feed/([a-zA-Z0-9_\-\/\.]+)'] = "feed/$1";
$route['feed'] = "feed";
$route['flag/([a-zA-Z0-9_\-\/\.]+)'] = "flag/$1";
$route['flag'] = "flag";
$route['forums/([a-zA-Z0-9_\-\/\.]+)'] = "forums/$1";
$route['forums'] = "forums";
$route['information/([a-zA-Z0-9_\-\/\.]+)'] = "information/$1";
$route['information'] = "information";
$route['karma/([a-zA-Z0-9_\-\/\.]+)'] = "karma/$1";
$route['karma'] = "karma";
$route['question/([a-zA-Z0-9_\-\/\.]+)'] = "question/$1";
$route['question'] = "question";
$route['user/([a-zA-Z0-9_\-\/\.]+)'] = "user/$1";
$route['user'] = "user";
//$route['url/([a-zA-Z0-9_\-\/\.]+)'] = "url/$1";
//$route['url'] = "url";
$route['votes/([a-zA-Z0-9_\-\/\.]+)'] = "votes/$1";
$route['votes'] = "votes";
$route['your_government/([a-zA-Z0-9_\-\/\.]+)'] = "your_government/$1";
$route['your_government'] = "your_government";

//this allows for wildcard short urls
$route['([a-zA-Z0-9_\-\/\.]+)'] = "url/tiny/$1";




?>