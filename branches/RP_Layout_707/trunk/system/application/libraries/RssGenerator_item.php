<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class RssGenerator_item
{

  var $title = '';
  var $description = '';
  var $link = '';
  var $author = '';
  var $pubDate = '';
  var $comments = '';
  var $guid = '';
  var $guid_isPermaLink = true;
  var $source = '';
  var $source_url = '';
  var $enclosure_url = '';
  var $enclosure_length = '0';
  var $enclosure_type = '';
  var $categories = array();

}

?>