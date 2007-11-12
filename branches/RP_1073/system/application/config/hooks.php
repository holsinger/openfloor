<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://www.codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['post_controller'][] = array(
                                'class'    => 'Dependencies',
                                'function' => 'init',
                                'filename' => 'Dependencies.php',
                                'filepath' => 'hooks',
                                'params'   => array()
                                );
?>