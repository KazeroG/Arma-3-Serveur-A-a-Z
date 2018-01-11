<?php

if(isset($_POST['txn_id']))
{
    include_once("includes/head-sp.php");
    include_once("includes/content-thankyou.php");
    include_once("includes/footer-sp.php");
}else{
    header("Location: donate.php?error=Vous n'avez pas fait de donation");
}