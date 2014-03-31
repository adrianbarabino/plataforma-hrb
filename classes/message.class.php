<?php

require_once("./classes/misc.class.php");
require_once("./classes/user.class.php");


class Message extends Misc {
	public $_users = null;

	public function setUsers(User $users) {
		return $this->_users = $users;
	}
 
	public function getUsers() {
		if(null == $this->_users) {
			$this->setUsers(new User());

		}
		return $this->_users;
	}
	
    public function __construct() {
    	parent::__construct();
        $this->getUsers();
    }

    public function getAll($lastId = NULL){
    	if(!$this->_users->isAdmin())
   		{
   			$id_user = $this->_users->getCurrentUser();
   			// if user is not admin, only can see your privates and global messages
   			// and if is admin, can see all 
   			$where_array = array(array("M.receiver", "=", $id_user));
   		}else{
   			$where_array = NULL;
   		}
		$fields_array = array("id", "sender", "receiver", "message", "date");
        $result = $this->_db->advancedSelect("messages M",$fields_array,$where_array);

	   		$messages_array = array();
	   	while ($row = $result->fetch_assoc()) {

	   		if($row){

				$msg = array(
					"id" => $row['id'],
					"sender"  => $row['sender'],
					"receiver"  => $row['receiver'],
					"message"  => $row['message'],
					"date"  => $row['date']
					);
				array_push($messages_array, $msg);

			}
		}
				return $messages_array;


    }
    public function newMessage($sender, $receiver = NULL, $message, $date = NULL)
	{

		$users = $this->_users;
		// receiver null? so this message is global!
		if($receiver == NULL)
			$receiver = 0;


		// date null? so this message is sented right now!
		if($date == NULL)
			$date = date("Y-m-d H:i:s");

		$sender = intval($sender);
		$receiver = intval($receiver);
		if($users->isExist($receiver) && $users->isExist($sender))
		{

			$array_values = array(
				"sender" => $sender,
				"receiver" => $receiver,
				"message" => $message,
				"date" => $date
				);


			$id_vote = $this->_db->insertToDB("messages", $array_values);
		}else{
			die("User doesn't exist!");
			return false;
		}



	}

}