<?
class participant_model extends Model {

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
    }
	/**
	 * Add a new record to the participant table.  Pass the data which is an associative array with field_name => field_value pairs
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function InsertParticipant($data){
		$this->db->insert('event_participants', $data); 
		return $this->db->insert_id();
	}

	/**
	 * Update a participant record.  Pass the id to be updated and the data which is an associative array with field_name => field_value pairs
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function UpdateParticipantByUserId($user_id, $data){
		$this->db->where('user_id', (int) $user_id);
		$this->db->update('event_participants', $data);
	
		return $this->db->affected_rows();
	}

	/**
	 * Deletes a participant that is specified by an id in the argument list
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function DeleteParticipant($id){
		$this->db->delete('event_participants', array('id' => $id));
	}
	
	
	/**
	 * Returns the number of current active users, this means any user that has pinged withing the last two minutes.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function GetActiveUsersForEvent($event_id)
	{
		# code...
	}
	
	public function GetParticipantByUserId($user_id='')
	{
		return $this->db->select('*')->from('event_participants')->where('fk_user_id', $user_id)->get()->result_array();
	}
}
?>