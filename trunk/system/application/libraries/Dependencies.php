<?php

/**
* Dependencies class
*/
class Dependencies
{
	private $views_base_path = './system/application/views/';
	private $views;
	private $dependencies;
	
	function __construct()
	{
		// set the base path here (use system dir specified in global config)
		$dependencies = array();
	}
	
	public function func($view)
	{
		$view = $this->check_extension($view);
		$this->views = array($view);
		
		$this->populate_views($view);
		echo('<pre>' . print_r($this->views, true) . '</pre>');
		exit('<pre>' . print_r($this->dependencies, true) . '</pre>');
	}
	
	private function populate_views($view)
	{
		$view_handle = fopen($this->views_base_path . $view, 'r');
		$contents = fread($view_handle, filesize($this->views_base_path . $view));
		preg_match_all('/\$this-\>load-\>view\([\'"](.*)[\'"]\)/', $contents, $views);
		$this->views = array_merge($this->views, $views[1]);
		
		preg_match_all('/#dependency (.*)/', $contents, $dependencies);
		foreach($dependencies[1] as $dependency) $this->dependencies[] = $dependency;
		
		if(!empty($views[1]))			
			foreach($views[1] as $v)
				$this->populate_views($this->check_extension($v));
		else
			$this->views[] = $view;
		
		fclose($view_handle);
	}
	
	public function check_extension($view)
	{
		// make sure .php is appended to the string
		return substr($view, 0, -4) != '.php' ? $view . '.php' : $view;
	}
}


?>