<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ApiData {

    var $ajax = false;
    var $rows = 0;
    var $cols = 0;
    var $debugLevel = 0;
    var $mainpageArray = array();
    
    function __construct ($debug=0) {
    	$this->debugLevel = $debug;
			$this->CI=& get_instance();
			
			$this->CI->load->model('Mainpage_model','mainpage');
			
			$this->mainpageArray = $this->buildMainPageArray();
    }
    
    /**
     * this function will build an array from the main page tables
     * with all information needed to build the main page
     * 
     * @author James Kleinschnitz
     */
			private function _buildMainPageArray () {
				$array = array();
				$data = array();
				//get all data
				$array = $this->CI->mainpage->select();
				foreach ($array as $key => $val) {
					$index = $val['col'].$val['row'];
					#the aray index the the row col pair
					$data[$index] = $val['data'];
					#set num cols
					$this->cols = ($this->cols < $val['col']) ? $val['col']:$this->cols;					
				}
				//sort data
				sort($data);
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
					$data = unserialize($data);
					if ($data['custom']) {
						
					} else {
						//assume it is a feed parse it for data
						$this->CI->load->library('simplepie');
						$this->simplepie->set_feed_url($data['feed']); 
        		$this->simplepie->init();
        		$feed = $this->simplepie;
        		$html .= "<div class='mainpod'>\n";
        		$html .= '<h1>'.strtoupper($data['name']).'<h1>';
        		$html .= "<ul>";
						foreach($feed->get_items() as $item) {
							$html .= "<li class='feed-title'><a href='" .$item->get_link() . "'>" . $item->get_title() . "</a></li>";
							$html .= "<li>" . $item->get_description() . "</li>";
						}
						$html .= "</ul>";        		
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
        		$html .= form_open('mainpage/ad/' . $rc);
						$html .= form_format("Name: *",form_input('name',$data['name'],'class="txt"') );
						$html .= form_format("Feed: *",form_input('feed',$data['feed'],'class="txt"') );
						$html .= form_format("Title: *",form_checkbox('title', 'TRUE', $data['title']) );
						$html .= form_format("Description: *",form_checkbox('desc', 'TRUE', $data['desc']) );
						$html .= form_format("Description Limit: *",form_input('desc_limit',$data['desc_limit'],'class="txt"') );
						$html .= form_format("# Items: *",form_input('items',$data['items'],'class="txt"') );
						$html .= form_hidden('colrow',$rc);   
						//if ($data['custom'])
						$html .= form_format("Delete Pod: *",form_checkbox('delete', 'TRUE', FALSE));
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
					foreach ($this->mainpageArray as $rc => $data) {
						//if the first number of the columnrow index is equal to the desired col
						if (strpos($rc,$col)== 1) {
							if (strtolower($type) == 'html') $html .= $this->getHTML($data);
							else if (strtolower($type) == 'form') $html .= $this->getForm($data,$rc);							
						}//end if correct col
						$html .= "<div style='clear:both;'></div>";
					}//end foreach
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
				
}