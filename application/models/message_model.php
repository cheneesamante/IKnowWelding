<?php

class Message_model extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * Get a Single Message
     *
     * @param  none
     * @return array
     */
    public function get_all_message() {
        // TO DO: get this in session
        $user_id = 1;
        $msg_id = 2;
        $sql = 'SELECT m.*, s.status, t.subject, ' . USER_TABLE_USERNAME .
        ' FROM ' . $this->db->dbprefix . 'msg_messages m ' .
        ' JOIN ' . $this->db->dbprefix . 'msg_threads t ON (m.thread_id = t.id) ' .
        ' JOIN ' . $this->db->dbprefix . USER_TABLE_TABLENAME . ' ON (' . USER_TABLE_ID . ' = m.sender_id) '.
        ' JOIN ' . $this->db->dbprefix . 'msg_status s ON (s.message_id = m.id AND s.user_id = ? ) ' .
        ' WHERE m.id = ? ' ;

        $query = $this->db->query($sql, array($user_id, $msg_id));

        return $query->result_array();
    }

    
}

?>
