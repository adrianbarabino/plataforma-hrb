<?php
require("./data/config.php");
require("./data/connection.php");
require("./classes/message.class.php");
$User = new User;
$message = new Message;

// Testing create new user

if(isset($_GET['action']) && $_GET['action']  == "register"){
$User->register("testing", "pumpkin", "user@mail.td", "a", 2);
}

if(isset($_GET['action']) && $_GET['action']  == "login"){
$User->login("testing", "pumpkin");
header('Location: test.php?action=newmsg');
}

if(isset($_GET['action']) && $_GET['action']  == "newmsg"){
	$userid = $User->getCurrentUser();

// Testing create New Message
$message2 = $message->newMessage($userid, $userid, "holasss");
header('Location: test.php?action=getall');

}

if(isset($_GET['action']) && $_GET['action']  == "logout2"){
$user_login = $User->logout();
}else{
	if($User->isLogged()){
	echo "Bienvenido !! ";
	$data_user = $User->getUserData($User->getCurrentUser());
	echo "Tus datos son: Usuario ".$data_user['username']." ID: ".$data_user['id'];
}
}
if(isset($_GET['action']) && $_GET['action']  == "logout"){
	$userid = $User->getCurrentUser();

$user_login = $User->logout();
$user_delete = $User->remove($userid);

if(isset($_GET['message'])){

		print_r(unserialize($_GET['message']));
}

}




if(isset($_GET['action']) && $_GET['action']  == "getall"){


// Testing get all messages
$message2 = $message->getAll(50);

print_r(json_encode($message2));

}

?>