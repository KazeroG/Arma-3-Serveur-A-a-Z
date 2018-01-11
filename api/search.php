<?php
include_once('../class/config.php');
date_default_timezone_set('Europe/Paris');

if (isset($_GET['name']) and $_GET['name'] != '') {

    $name = $_GET['name'];
    $data = Player::byName($name);
    $return = [];
    foreach($data as $player){
        $return[] = array('name'=>$player['name']);
    }
    echo json_encode($return);

}