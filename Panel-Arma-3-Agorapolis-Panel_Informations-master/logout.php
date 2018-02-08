<?php
session_start();
$_SESSION = array();
session_destroy();
sleep(2);
header('Location: index.php')

?>
