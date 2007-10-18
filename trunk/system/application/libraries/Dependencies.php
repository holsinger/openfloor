<?php

class Dependencies
{
	public $javascript;
	public $css;
	
	private $views_base_path;
	private $dependencies;
		
	function __construct()
	{
		$this->CI =& get_instance();
		$this->views_base_path = './system/application/views/';
		$dependencies = $javascript = $css = array();
	}
	
	public function view($view)
	{
		$view = $this->check_extension($view);		
		$this->get_dependencies($view);
		$this->sort_dependencies();
	}
	
	private function get_dependencies($view)
	{
		// get contents of specified view
		if(!$view_handle = @fopen($this->views_base_path . $view, 'r'))
			show_error("Invalid view specified: $view");
		$contents = fread($view_handle, filesize($this->views_base_path . $view));
		
		// find out if this views calls any other views
		preg_match_all('/\$this-\>load-\>view\([\'"](.*)[\'"]\)/', $contents, $views);
		
		// populate dependencies array with any dependency tags found
		preg_match_all('/#dependency (.*)/', $contents, $dependencies);
		foreach($dependencies[1] as $dependency) $this->dependencies[] = $dependency;
		
		// recursion: get dependencies for children views, if any
		foreach($views[1] as $v) $this->get_dependencies($this->check_extension($v));
		
		fclose($view_handle);
	}
	
	private function sort_dependencies()
	{
		foreach($this->dependencies as $dependency)
			if(strpos(substr($dependency, -3), 'js') !== false) $this->javascript[] = $dependency;
			elseif(strpos(substr($dependency, -3), 'css') !== false) $this->css[] = $dependency;
			else show_error("Malformed dependency: $dependency");
		$this->javascript = array_unique($this->javascript);
		$this->css = array_unique($this->css);
	}
	
	private function check_extension($view)
	{
		// make sure .php is appended to the string
		return substr($view, -4) != '.php' ? $view . '.php' : $view;
	}
}

?>