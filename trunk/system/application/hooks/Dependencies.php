<?php

class Dependencies
{
	public $javascript;
	public $css;
	
	private $output;
	private $views_base_path;
	private $dependencies;
		
	function __construct()
	{
		global $OUT;
		$this->output =& $OUT->final_output;
		$this->views_base_path = './system/application/views/';
		$this->dependencies = $this->javascript = $this->css = array();
	}
	
	public function init()
	{		
		$this->get_dependencies();
		$this->sort_dependencies();
		$this->populate_dependencies();
	}
	
	private function get_dependencies()
	{
		preg_match_all('/#dependency (.*)/', $this->output, $dependencies);
		foreach($dependencies[1] as $dependency) $this->dependencies[] = trim($dependency);
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
	
	private function populate_dependencies()
	{
		$ret = '';
		if(!empty($this->css))	
			$ret .= '<link rel="stylesheet" type="text/css" href="css/' . implode(',', $this->css) . '" />' . "\n";			// $ret .= '<style type="text/css" media="screen">@import "css/' . implode(',', $this->css) . '";</style>';
		if(!empty($this->javascript))
			$ret .= '<script type="text/javascript" charset="utf-8" src="javascript' . implode(',', $this->javascript) . '"></script>';
		$this->output = str_replace('<!-- #dependencies -->', $ret, $this->output);
	}
	
	private function check_extension($view)
	{
		// make sure .php is appended to the string
		return substr($view, -4) != '.php' ? $view . '.php' : $view;
	}
}

?>