<?php
session_start();

if(isset($_SESSION['admin_id'])) {

    include_once("includes/head.php");
    include_once("includes/nav.php");
    include_once("includes/content-ticket-admin.php");
    include_once("includes/footer.php");

}elseif(isset($_GET['hash']) and $_GET['hash']!=''){

    include_once("includes/head-sp.php");
    include_once("includes/content-ticket-client.php");
    include_once("includes/footer-sp.php");

}else{
    header('Location:http://admin.altisfrance.Fr/support.php');
}