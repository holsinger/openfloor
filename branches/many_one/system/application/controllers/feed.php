<?php

class Feed extends Controller
{
	var $title;
	var $description;
	var $link;	
	var $data;
	
	function __construct()
	{
		parent::Controller();
		
		// models
		$this->load->model('event_model', 'event');
		$this->load->model('question_model', 'question');
		
		// libraries
		$this->load->library('RssGenerator_rss');
		$this->load->library('RssGenerator_channel');
		$this->load->library('RssGenerator_image');
		$this->load->library('RssGenerator_textInput');
		$this->load->library('RssGenerator_item');		
	}
	
	public function index()
	{
		redirect();
		exit();
	}
	
	public function events()
	{
		// set class vars
		$this->title 			= 'Events';
		$this->description		= 'RunPolitics Events Feed';
		$this->link 			= 'http://www.runpolitics.com';
		$this->data				= $this->event->rss_events();
		
		$this->feed_events();
	}

	public function event($event = 'salt_lake_city_mayoral_forum')
	{
		$event_id				= $this->event->get_id_from_url($event);
		if(!$event_id) 			exit();
		
		// set class vars
		$this->title 			= ucwords(str_replace('_',' ', $event));
		$this->description		= 'RunPolitics Event Feed';
		$this->link 			= 'http://www.runpolitics.com/';
		$this->data				= $this->event->rss_upcoming_questions($event_id);
		
		$this->feed_questions();				
	}

	public function tag($tag = 'politics')
	{
		// set class vars
		$this->title 			= 'Questions tagged with \'' . ucfirst($tag) . '\'';
		$this->description		= 'RunPolitics Tag Feed';
		$this->link 			= 'http://www.runpolitics.com/';
		$this->data				= $this->question->rss_questions_by_tag($tag);
		
		$this->feed_questions();
	}
	
	private function feed_questions()
	{
		$rss_channel 					= new RssGenerator_channel();
		$rss_channel->title 			= $this->title;
		$rss_channel->link 				= $this->link;
		$rss_channel->description 		= $this->description;
		$rss_channel->language 			= 'en-us';
		$rss_channel->managingEditor 	= 'contact@politic20.com';
		$rss_channel->webMaster 		= 'contact@politic20.com';

		foreach($this->data as $question) {
			$item 						= new RssGenerator_item();
			$item->title 				= $question->question_name;
			$item->description 			= $question->question_desc;
			$item->link 				= site_url('question/view/' . url_title($question->event_name) . '/' . url_title($question->question_name));
			$item->pubDate 				= 'Tue, 07 Mar 2006 00:00:01 GMT';
			$rss_channel->items[] 		= $item;
		}

		$rss_feed 						= new RssGenerator_rss();
		$rss_feed->encoding 			= 'UTF-8';
		$rss_feed->version 				= '2.0';
		header('Content-Type: text/xml');
		echo $rss_feed->createFeed($rss_channel);
	}
	
	private function feed_events()
	{
		$rss_channel 					= new RssGenerator_channel();
		$rss_channel->title 			= $this->title;
		$rss_channel->link 				= $this->link;
		$rss_channel->description 		= $this->description;
		$rss_channel->language 			= 'en-us';
		$rss_channel->managingEditor 	= 'contact@politic20.com';
		$rss_channel->webMaster 		= 'contact@politic20.com';

		foreach($this->data as $event) {
			$item 						= new RssGenerator_item();
			$item->title 				= $event->event_name;
			$item->description 			= htmlspecialchars($event->event_desc);
			$item->link 				= site_url('forums/queue/event/' . url_title($event->event_name));
			$item->pubDate 				= 'Tue, 07 Mar 2006 00:00:01 GMT';
			$rss_channel->items[] 		= $item;
		}

		$rss_feed 						= new RssGenerator_rss();
		$rss_feed->encoding 			= 'UTF-8';
		$rss_feed->version 				= '2.0';
		header('Content-Type: text/xml');
		echo $rss_feed->createFeed($rss_channel);
	}
}