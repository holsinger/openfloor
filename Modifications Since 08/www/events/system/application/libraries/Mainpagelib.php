<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mainpagelib {

    var $ajax = false;
    var $rows = 0;
    var $cols = 0;
    var $debugLevel = 0;
    var $mainpageArray = array();
    
    function __construct ($debug=0) {
    	$this->debugLevel = $debug;
		$this->CI=& get_instance();
		
		$this->CI->load->model('Mainpage_model','mainpage');
		
		$this->mainpageArray = $this->_buildMainPageArray();
		
		
    }
    
    /**
     * this function will build an array from the main page tables
     * with all information needed to build the main page
     * 
     * @author James Kleinschnitz
     **/
			private function _buildMainPageArray () {
				$array = array();
				$data = array();
				//get all data
				$array = $this->CI->mainpage->select();
				//exit(var_dump($array));
				foreach ($array as $key => $val) {
					$index = $val['col'].$val['row'];
					#the aray index the the row col pair
					$data[$index] = $val['data'];
					#set num cols
					$this->cols = ($this->cols < $val['col']) ? $val['col']:$this->cols;					
				}
				//sort data
				ksort($data);
				//exit(var_dump($data));
				return $data;
			}
    
    	/**
    	 * this function allow changes to ajax global boolean
    	 * 
    	 * @param booelan $val
    	 * @author James Kleinschnitz
    	 **/
			 function setAjax ($val) {
			 	$this->ajax = $val;
			 }
			 
			 /**
			  * this function will take serialized data
			  * and return html
			  * 
			  * @param serialized $data
			  * @return string $html
			  * @author James Kleinschnitz
			  **/
				function getHTML ($data) {
					$html = '';
					$desc = '';
					$data = unserialize($data);
					if (isset($data['custom'])) {
						
					} else {
						//assume it is a feed parse it for data
						$html .= "<div class='mainpod'>\n";
		        		if (isset($data['name'])) $html .= '<h1>'.strtoupper($data['name']).'<h1>';
						if (isset($data['feed'])) {
							$this->CI->load->library('Simplepie');
							$this->CI->simplepie->set_feed_url($data['feed']); 
			        		if (!@$this->CI->simplepie->error()) {
			        			$this->CI->simplepie->set_output_encoding ('UTF-8');
								//@$this->CI->simplepie->enable_cache(false);
			        			@$this->CI->simplepie->init();	
								@$this->CI->simplepie->handle_content_type();		        		
								$feed = $this->CI->simplepie;		        		
								$html .= "<ul>";
								foreach($feed->get_items(0,$data['items']) as $item) {
									if ($data['title']) $html .= "<li><a href='" .$item->get_link() . "' class='feed-title'>" . $item->get_title() . "</a></li>";
									if (isset($data['desc_limit']) && $data['desc_limit']>0) $desc = $this->_truncate($item->get_content(), $data['desc_limit'],false,true);
									else $desc = $item->get_content();	
									if (isset($data['desc'])) $html .= "<li>" . $desc . "</li>";
								}
								$html .= "</ul>";
							}//end if no errors        		
						}//end if feed is set
        				$html .= "</div>\n";								
					}
					
					return $html;
				}
			 
			 /**
			  * this function will take serialized data
			  * and return a form
			  * 
			  * @param serialized $data
			  * @param int $rc row colum grid id
			  * @return string $html
			  * @author James Kleinschnitz
			  **/
				function getForm ($data,$rc) {
					$html = '';
									
					$data = unserialize($data);
					//assume it is a feed parse it for data
	        		$html .= "<div class='mainform'>\n";
	        		$html .= '<h1>'.$rc.'(ColumnRow)<h1>';
	        		$html .= form_open('mainpage/edit/' . $rc);
					$html .= form_format("Name: *",form_input('name',(isset($data['name']))?$data['name']:'','class="txt"') );
					$html .= form_format("Feed: *",form_input('feed',(isset($data['feed']))?$data['feed']:'','class="txt"') );
					$html .= form_format("Title: *",form_checkbox('title', 'TRUE', (isset($data['title']))?TRUE:FALSE ));
					$html .= form_format("Description: *",form_checkbox('desc', 'TRUE', (isset($data['desc']))?TRUE:FALSE ));
					$html .= form_format("Description Limit: *",form_input('desc_limit',(isset($data['desc_limit']))?$data['desc_limit']:'','class="txt"') );
					$html .= form_format("# Items: *",form_input('items',(isset($data['items']))?$data['items']:'','class="txt"') );
					$html .= form_hidden('colrow',$rc);   
					//if ($data['custom'])
					//$html .= form_format("Delete Pod: *",form_checkbox('delete', 'TRUE', FALSE));
	        		$html .= "<br />\n";	
					$html .= form_submit('','Save','class="button"');
					$html .= form_close();     		
	        		$html .= "</div>\n";		
					
					return $html;
				}
				
				/**
				 * This function will return an entire col
				 * 
				 * @param int $col the column number
				 * @param string $type HTML|form
				 * @return html
				 * @author James Kleinschnitz
				 */
				function getCol ($col, $type) {
					$html = '';
					$rowCount = 0;
					//var_dump($this->mainpageArray);
					foreach ($this->mainpageArray as $rc => $data) {
						//if the first number of the columnrow index is equal to the desired col
						//if (strpos($rc,$col) === 1) {
						if ($rc >= (($col)*10) && $rc < (($col+1)*10)) {							
							$rowCount ++;
							$html .= '<div class="col-border"></div>';
							if (strtolower($type) == 'html') $html .= $this->getHTML($data);
							else if (strtolower($type) == 'form') $html .= $this->getForm($data,$rc);							
						}//end if correct col
						$html .= "<div style='clear:both;'></div>";
					}//end foreach			
					if (strtolower($type) == 'form') $html .= "<ul><li>".anchor('mainpage/add/'.$col.($rowCount+1),'add')."</li><li>".anchor('mainpage/delete/'.$col.$rowCount,'delete')."</li></ul>";
					return $html;
				}
				
				
				/**
				 * this fuction will return the entire main page
				 * 
				 * @return html
				 * @author James Kleinschnitz
				 **/
				function getMainpage () {
					$html = '';
					$html .= "<div id='mainpage'>";
					for ($i=0;$i<=$this->cols;$i++) $html .= "<div id='col{$i}'>".$this->getCol($i,'html')."</div>";
					$html .= "</div>";
					return $html;
				}
				
				/**
				 * this fuction will return an admin page
				 * 
				 * @return html
				 * @author James Kleinschnitz
				 **/
				function getMainpageAdmin () {
					$html = '';
					$html .= "<div id='mainpage'>";
					for ($i=0;$i<=$this->cols;$i++) $html .= "<div id='col{$i}'>".$this->getCol($i,'form')."</div>";
					$html .= "</div>";
					return $html;
				}
				
				/**
				 * Truncates text.
				 *
				 * Cuts a string to the length of $length and replaces the last characters
				 * with the ending if the text is longer than length.
				 *
				 * @param string  $text	String to truncate.
				 * @param integer $length Length of returned string, including ellipsis.
				 * @param string  $ending Ending to be appended to the trimmed string.
				 * @param boolean $exact If false, $text will not be cut mid-word
				 * @param boolean $considerHtml If true, HTML tags would be handled correctly
				 * @return string Trimmed string.
				 */
					function _truncate($text, $length = 100, $ending = '...', $exact = true, $considerHtml = true) {
				        if ($considerHtml) {
				            // if the plain text is shorter than the maximum length, return the whole text
				            if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
				                return $text;
				            }
				            
				            // splits all html-tags to scanable lines
				            preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
				    
				            $total_length = strlen($ending);
				            $open_tags = array();
				            $truncate = '';
				            
				            foreach ($lines as $line_matchings) {
				                // if there is any html-tag in this line, handle it and add it (uncounted) to the output
				                if (!empty($line_matchings[1])) {
				                    // if it's an "empty element" with or without xhtml-conform closing slash (f.e. <br/>)
				                    if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
				                        // do nothing
				                    // if tag is a closing tag (f.e. </b>)
				                    } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
				                        // delete tag from $open_tags list
				                        $pos = array_search($tag_matchings[1], $open_tags);
				                        if ($pos !== false) {
				                            unset($open_tags[$pos]);
				                        }
				                    // if tag is an opening tag (f.e. <b>)
				                    } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
				                        // add tag to the beginning of $open_tags list
				                        array_unshift($open_tags, strtolower($tag_matchings[1]));
				                    }
				                    // add html-tag to $truncate'd text
				                    $truncate .= $line_matchings[1];
				                }
				                
				                // calculate the length of the plain text part of the line; handle entities as one character
				                $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
				                if ($total_length+$content_length > $length) {
				                    // the number of characters which are left
				                    $left = $length - $total_length;
				                    $entities_length = 0;
				                    // search for html entities
				                    if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
				                        // calculate the real length of all entities in the legal range
				                        foreach ($entities[0] as $entity) {
				                            if ($entity[1]+1-$entities_length <= $left) {
				                                $left--;
				                                $entities_length += strlen($entity[0]);
				                            } else {
				                                // no more characters left
				                                break;
				                            }
				                        }
				                    }
				                    $truncate .= substr($line_matchings[2], 0, $left+$entities_length);
				                    // maximum lenght is reached, so get off the loop
				                    break;
				                } else {
				                    $truncate .= $line_matchings[2];
				                    $total_length += $content_length;
				                }
				                
				                // if the maximum length is reached, get off the loop
				                if($total_length >= $length) {
				                    break;
				                }
				            }
				        } else {
				            if (strlen($text) <= $length) {
				                return $text;
				            } else {
				                $truncate = substr($text, 0, $length - strlen($ending));
				            }
				        }
				        
				        // if the words shouldn't be cut in the middle...
						if (!$exact) {
				            // ...search the last occurance of a space...
							$spacepos = strrpos($truncate, ' ');
							if (isset($spacepos)) {
				                // ...and cut the text in this position
								$truncate = substr($truncate, 0, $spacepos);
							}
						}
						
				        // add the defined ending to the text
						$truncate .= $ending;
						
				        if($considerHtml) {
				            // close all unclosed html-tags
				            foreach ($open_tags as $tag) {
				                $truncate .= '</' . $tag . '>';
				            }
				        }
						
						return $truncate;
				        
					}
				

/*

				function custom ($name) {
					switch ($name) {
						case "gVideo":
						return <<<EOT
<!-- ++Begin Video Search Control Wizard Generated Code++ -->
<!--
// Created with a Google AJAX Search Wizard
// http://code.google.com/apis/ajaxsearch/wizards.html
-->

<!--
// The Following div element will end up holding the Video Search Control.
// You can place this anywhere on your page.
-->
<div id="videoControl">
<span style="color:#676767;font-size:11px;margin:10px;padding:4px;">Loading...</span>
</div>

<!-- Ajax Search Api and Stylesheet
// Note: If you are already using the AJAX Search API, then do not include it
//       or its stylesheet again
//
// The Key Embedded in the following script tag is designed to work with
// the following site:
// http://politic20.com
-->
<script src="http://www.google.com/uds/api?file=uds.js&v=1.0&source=uds-vsw&key=ABQIAAAAkKcqFPODFw9EgKwKbb0vmxQMMgp4bRk8oDwCMuUVC3eAkH6yhxRey5JriXQU4hISBErCZHOSAAHL4w"
type="text/javascript"></script>
<style type="text/css">
@import url("http://www.google.com/uds/css/gsearch.css");
</style>

<!-- Video Search Control and Stylesheet -->
<script type="text/javascript">
window._uds_vsw_donotrepair = true;
</script>
<script src="http://www.google.com/uds/solutions/videosearch/gsvideosearch.js?mode=new"
type="text/javascript"></script>
<style media="all" type="text/css">@import "css/googleVideo.css";</style>

<script type="text/javascript">
function LoadVideoSearchControl() {
var options = { twoRowMode : true };
//var options = { largeResultSet : true };
var videoSearch = new GSvideoSearchControl(
                      document.getElementById("videoControl"),
                      [{ query : "Republican"}, { query : "Democrat"}, { query : "Conservative"}, { query : "Liberal"}, { query : "Presidential Campaign"}, { query : "Breaking Political News"}, { query : "U.S. Senate"}, { query : "U.S. House"}, { query : "Bush Administration"}, { query : "Supreme Court"}, { query : "Local & State Government"}], null, null, options);
}
// arrange for this function to be called during body.onload
// event processing
GSearch.setOnLoadCallback(LoadVideoSearchControl);
</script>

<!-- --End Video Search Control Wizard Generated Code-- -->					
EOT;						
						break;
						case "gNews":
						return <<<EOT
<!-- ++Begin News Bar Wizard Generated Code++ -->
<!--
// Created with a Google AJAX Search Wizard
// http://code.google.com/apis/ajaxsearch/wizards.html
-->

<!--
// The Following div element will end up holding the actual newsbar.
// You can place this anywhere on your page.
-->
<div id="newsBar-bar">
<span style="color:#676767;font-size:11px;margin:10px;padding:4px;">Loading...</span>
</div>

<!-- Ajax Search Api and Stylesheet
// Note: If you are already using the AJAX Search API, then do not include it
//       or its stylesheet again
//
// The Key Embedded in the following script tag is designed to work with
// the following site:
// http://politic20.com
-->
<script src="http://www.google.com/uds/api?file=uds.js&v=1.0&source=uds-nbw&key=ABQIAAAAkKcqFPODFw9EgKwKbb0vmxQMMgp4bRk8oDwCMuUVC3eAkH6yhxRey5JriXQU4hISBErCZHOSAAHL4w"
type="text/javascript"></script>
<style type="text/css">
@import url("http://www.google.com/uds/css/gsearch.css");
</style>

<!-- News Bar Code and Stylesheet -->
<script type="text/javascript">
window._uds_nbw_donotrepair = true;
</script>
<script src="http://www.google.com/uds/solutions/newsbar/gsnewsbar.js?mode=new"
type="text/javascript"></script>
<style type="text/css">
@import url("http://www.google.com/uds/solutions/newsbar/gsnewsbar.css");
</style>

<script type="text/javascript">
function LoadNewsBar() {
var newsBar;
var options = {
largeResultSet : false,
title : " ",
horizontal : false,
autoExecuteList : {
  executeList : ["politics", "us senate", "congress", "democrat", "republican", "campaign 2008", "liberal"]
}
}

newsBar = new GSnewsBar(document.getElementById("newsBar-bar"), options);
}
// arrange for this function to be called during body.onload
// event processing
GSearch.setOnLoadCallback(LoadNewsBar);
</script>
<!-- ++End News Bar Wizard Generated Code++ -->						
EOT;						
						break;
						case "gBlog":
						return <<<EOT
<!-- ++Begin Blog Bar Wizard Generated Code++ -->
<!--
// Created with a Google AJAX Search Wizard
// http://code.google.com/apis/ajaxsearch/wizards.html
-->

<!--
// The Following div element will end up holding the actual blogbar.
// You can place this anywhere on your page.
-->
<div id="blogBar-bar">
<span style="color:#676767;font-size:11px;margin:10px;padding:4px;">Loading...</span>
</div>

<!-- Ajax Search Api and Stylesheet
// Note: If you are already using the AJAX Search API, then do not include it
//       or its stylesheet again
//
// The Key Embedded in the following script tag is designed to work with
// the following site:
// http://politic20.com
-->
<script src="http://www.google.com/uds/api?file=uds.js&v=1.0&source=uds-blbw&key=ABQIAAAAkKcqFPODFw9EgKwKbb0vmxQMMgp4bRk8oDwCMuUVC3eAkH6yhxRey5JriXQU4hISBErCZHOSAAHL4w"
type="text/javascript"></script>
<style type="text/css">
@import url("http://www.google.com/uds/css/gsearch.css");
</style>

<!-- Blog Bar Code and Stylesheet -->
<script src="http://www.google.com/uds/solutions/blogbar/gsblogbar.js?mode=new"
type="text/javascript"></script>
<style type="text/css">
@import "css/googleBar.css";
</style>

<script type="text/javascript">
function LoadBlogBar() {
var blogBar;
var options = {
largeResultSet : false,
title : " ",
horizontal : false,
orderBy : GSearch.ORDER_BY_DATE,
autoExecuteList : {
executeList : [ "Republican", "Democrat", "Conservative", "Liberal", "Presidential Campaign", "Breaking Political News", "U.S. Senate", "U.S. House", "Bush Administration", "Supreme Court", "Local & State Government"]
}
}

blogBar = new GSblogBar(document.getElementById("blogBar-bar"), options);
}
// arrange for this function to be called during body.onload
// event processing
GSearch.setOnLoadCallback(LoadBlogBar);
</script>
<!-- ++End Blog Bar Wizard Generated Code++ -->						
EOT;						
						break;
					}
					
				}
				
	*/			
}