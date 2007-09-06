<?php

class Cms_model extends Model 
{
	//vars

	
 	function __construct()
    {
        // Call the Model constructor
        parent::Model();
    }
    
    
    public function insert_cms_form()
    {
    	if ( isset($_POST['cms_name']) ) {
    		$this->db->set('cms_name',$_POST['cms_name']);    		
				$this->db->set('cms_url',url_title($_POST['cms_name']));
    	}
			if ( isset($_POST['cms_text']) ) $this->db->set('cms_text',$_POST['cms_text']);
			$this->db->insert('cms');
			
			$cms_id = $this->db->insert_id();
			return $cms_id;
    }
    
 		public function update_cms($array)
    {
    	if ( isset($array['cms_name']) ) {
    		$this->db->set('cms_name',$array['cms_name']);    		
				$this->db->set('cms_url',url_title($array['cms_name']));
    	}
			if ( isset($array['cms_text']) ) $this->db->set('cms_text',$array['cms_text']);
			$this->db->where('cms_id',$array['cms_id']);
			$this->db->update('cms');
			
			log_message('debug', "updateCMS:".trim($this->db->last_query()));
			return $this->db->affected_rows();
    }
		
		public function get_cms ($id, $url='')
		{
			 $result_array = array(); 
			 if ($id) $this->db->where('cms_id',$id);
			 if ($url) $this->db->where('cms_url',$url);
			 $query = $this->db->get('cms');
			 log_message('debug', "getCMS:".trim($this->db->last_query()));
			 $result_array = $query->result_array();
			 if (count($result_array)>0) return $result_array[0];
			 else return false;
		}
		
		public function get_all_cms ()
		{
			 $result_array = array(); 
			 $query = $this->db->get('cms');
			 log_message('debug', "getCMS:".trim($this->db->last_query()));
			 $result_array = $query->result_array();
			 if (count($result_array)>0) return $result_array;
			 else return false;
		}
    
		/**
		 * return the id from the cms url name
		 * 
		 * @param string $url event url name
		 * @author James Kleinschnitz
		 */
		public function get_id_from_url ($url)
		{
			 $result_array = $this->get_cms(0,$url);
			 if (is_array($result_array))  return $result_array['cms_id'];
			 else return false;
		}

}
?>