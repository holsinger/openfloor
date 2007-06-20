<?php

class CN_Model extends Model 
{
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
	
	public function insertQuestion($questionName, $questionDesc, $userID, $eventID)
	{
		$query = "INSERT INTO cn_questions (question_name, question_desc, fk_user_id, fk_event_id) ";
		$query .="VALUES ('$questionName', '$questionDesc', $userID, $eventID)";		
		$this->db->query($query);
		
		return $this->db->insert_id();
	}
	
	public function getEvents()
	{
		$query = $this->db->query('SELECT * FROM cn_events');
		return $query->result_array();
	}
}

?>