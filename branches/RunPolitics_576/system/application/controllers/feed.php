<?php

class Feed extends Controller
{
	function __constructor()
	{
		parent::Controller();
	}

	public function event($event = null)
	{
		$this->load->library('RssGenerator_rss');
		$this->load->library('RssGenerator_channel');
		$this->load->library('RssGenerator_image');
		$this->load->library('RssGenerator_textInput');
		$this->load->library('RssGenerator_item');		
		
		$rss_channel = new RssGenerator_channel();
		$rss_channel->title = 'My News';
		$rss_channel->link = 'http://mysite.com/news.php';
		$rss_channel->description = 'The latest news about web-development.';
		$rss_channel->language = 'en-us';
		$rss_channel->generator = 'PHP RSS Feed Generator';
		$rss_channel->managingEditor = 'editor@mysite.com';
		$rss_channel->webMaster = 'webmaster@mysite.com';

		$item = new RssGenerator_item();
		$item->title = 'New website launched';
		$item->description = 'Today I finaly launch a new website.';
		$item->link = 'http://newsite.com';
		$item->pubDate = 'Tue, 07 Mar 2006 00:00:01 GMT';
		$rss_channel->items[] = $item;

		$item = new RssGenerator_item();
		$item->title = 'Another website launched';
		$item->description = 'Just another website launched.';
		$item->link = 'http://anothersite.com';
		$item->pubDate = 'Wen, 08 Mar 2006 00:00:01 GMT';
		$rss_channel->items[] = $item;

		$rss_feed = new RssGenerator_rss();
		$rss_feed->encoding = 'UTF-8';
		$rss_feed->version = '2.0';
		header('Content-Type: text/xml');
		echo $rss_feed->createFeed($rss_channel);
	}

	public function tag($tag)
	{
		return true;
	}
}