<?php
class Mainpage_model extends Model {

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
    }
    
    
    function insert($col, $row, $data) {
    	$this->db->set('col',$col);
    	$this->db->set('row',$row);
    	$this->db->set('data',$data);
			$this->db->insert('p20_mainpage');
    }
    
		function select() {
			$query = $this->db->get('p20_mainpage');
			if ($query->num_rows() > 0) {
			   return $query->result_array();			   
			} else {
				return array();
			}
    }
    
		function delete($col, $row) {
    	$this->db->where('col', $col);
    	$this->db->where('row', $row);
    	$this->db->delete('p20_mainpage');
    }
}
?>