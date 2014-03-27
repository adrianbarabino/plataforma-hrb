<?php
require("./data/config.php");
require("./data/connection.php");
require("./classes/message.class.php");

$message = new Message;
$message2 = $message->newMessage(1, 1, "hola");
?>