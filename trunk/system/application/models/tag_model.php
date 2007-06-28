<?php
class Tag_model extends Model 
{
 	function __construct()
    {
        // Call the Model constructor
        parent::Model();
    }
    
	public function insertTag($value)
	{
		$query = $this->db->query("INSERT INTO cn_tags (value) VALUES ('$value')");
		if($this->db->insert_id() > 0)
			return $this->db->insert_id();
		else
			return false;	
	}
	
	public function insertTagAssociation($questionID, $tagID, $userID)
	{
		$query = "INSERT INTO cn_idx_tags_questions (fk_question_id, fk_tag_id, fk_user_id) ";
		$query .="VALUES ($questionID, $tagID, $userID)";
		$this->db->query($query);
	}
	
	public function getTagsInSet($set)
	{
		foreach($set as $k=>$v) $set[$k] = '\'' . $v . '\'';		
		return $this->db->query('SELECT tag_id, value FROM cn_tags WHERE value IN (' . implode(',',$set) . ')');
	}
}
?>