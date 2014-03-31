<?php
require("./data/config.php");
require("./data/connection.php");
require("./classes/message.class.php");

// Testing create New Message

$message = new Message;
$message2 = $message->newMessage(1, 1, "hola");


require("./classes/user.class.php");

// Testing create new user

$User = new User;
$User2 = $User->newUser(1, 1, "hola");

// Testing get all messages
$message2 = $message->getAll();

print_r(json_encode($message2));
?>