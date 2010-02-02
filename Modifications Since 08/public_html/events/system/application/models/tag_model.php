<?php
class Tag_model extends Model 
{
	public $type = 'question';
	private $global_count = 50;
	
 	function __construct()
    {
        // Call the Model constructor
        parent::Model();
    }
    
	public function insertTag($value)
	{
		$query = $this->db->query("INSERT INTO cn_tags (value) VALUES (\"$value\")");
		if($this->db->insert_id() > 0)
			return $this->db->insert_id();
		else
			return false;	
	}
	
	public function insertTagAssociation($questionID, $videoID, $tagID, $userID)
	{
		if ($questionID) {
			$query = "INSERT INTO cn_idx_tags_questions (fk_question_id, fk_tag_id, fk_user_id) ";
			$query .="VALUES ($questionID, $tagID, $userID)";
		} else if ($videoID) {
			$query = "INSERT INTO cn_idx_tags_questions (fk_video_id, fk_tag_id, fk_user_id) ";
			$query .="VALUES ($videoID, $tagID, $userID)";
		}
		$this->db->query($query);
	}
	
	public function getTagsInSet($set)
	{
		foreach($set as $k=>$v) $set[$k] = '"' . $v . '"';		
		return $this->db->query('SELECT tag_id, value FROM cn_tags WHERE value IN (' . implode(',',$set) . ')');
	}
		
	public function getAllReferencedTags($event_id = null)
	{
		$fk = ($this->type == 'question') ? 'fk_question_id' : 'fk_video_id' ;
		$id = ($this->type == 'question') ? 'question_id' : 'video_id' ;
		$table = ($this->type == 'question') ? 'cn_questions' : 'cn_videos' ;
		
		$query = ($event_id === null) ? 
		$this->db->query('SELECT value FROM cn_idx_tags_questions, cn_tags WHERE fk_tag_id = tag_id')->result_array() : 
		$this->db->query("SELECT value FROM cn_idx_tags_questions, cn_tags WHERE fk_tag_id = tag_id AND $fk IN (SELECT $id FROM $table WHERE fk_event_id=$event_id)")->result_array() ;
				
		$result = $words = array();
		foreach($query as $v) $result[] = $v['value'];		
		$count_values = array_count_values($result);		
		arsort($count_values);
		array_splice($count_values, $this->global_count);
		foreach($count_values as $k => $v) for($j = 0; $j < $v; $j++) $words[] = $k;
		return $words;
	}
		
	public function getTagsByQuestion($question_id)
	{
		return $this->db->query("SELECT value FROM cn_tags, cn_idx_tags_questions WHERE tag_id = fk_tag_id AND fk_question_id=$question_id")->result_array();
	}
	
	public function getTagsByVideo($video_id)
	{
		return $this->db->query("SELECT value FROM cn_tags, cn_idx_tags_questions WHERE tag_id = fk_tag_id AND fk_video_id=$video_id")->result_array();
	}
	
	public function get_id_from_tag($value)
	{
		$result = $this->db->getwhere('cn_tags', array('value' => $value))->result_array();
		return $result[0]['tag_id'];
	}
	
	public function updateTagsForMerge ($question_id, $result_question_id) 
	{
		$this->db->where ('fk_question_id',$question_id);
		$this->db->set ('fk_question_id',$result_question_id);
		$this->db->update('cn_idx_tags_questions');
		error_log(trim($this->db->last_query()));
		log_message('debug', "updateTagsQuestions:".trim($this->db->last_query()));
		return $this->db->affected_rows();
	}
}
?>