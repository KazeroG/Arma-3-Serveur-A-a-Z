<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include_once('../class/config.php');

if(isset($_GET['hash']) and $_GET['hash'] == '267ef5d5f8d0a99889c284f7180dff4f21961b8f'){
    $req = DB::get()->query("UPDATE `players` SET `credit`=`credit`-1 WHERE `credit` > 0");
    $req->execute();

    $req = DB::get()->query("UPDATE `players` SET `donatorlvl`='0' WHERE `credit` = 0");
    $req->execute();
}