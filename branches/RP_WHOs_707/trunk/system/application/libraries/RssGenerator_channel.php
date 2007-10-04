<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class RssGenerator_channel
{

  var $title = '';
  var $link = '';
  var $description = '';
  var $language = '';
  var $copyright = '';
  var $managingEditor = '';
  var $webMaster = '';
  var $pubDate = '';
  var $lastBuildDate = '';
  var $categories = array();
  var $generator = '';
  var $docs = '';
  var $ttl = '';
  var $image = '';
  var $textInput = '';
  var $skipHours = array();
  var $skipDays = array();
  var $cloud_domain = '';
  var $cloud_port = '80';
  var $cloud_path = '';
  var $cloud_registerProcedure = '';
  var $cloud_protocol = '';
  var $items = array();
  var $extraXML = '';

}

?>