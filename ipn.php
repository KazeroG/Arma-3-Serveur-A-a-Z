<?php

require_once('class/config.php');

if(empty($_POST)){ header("Location: donate.php"); }
// read the post from PayPal system and add 'cmd'

$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
    $value = urlencode(stripslashes($value));
    $req .= "&$key=$value";
}

// post back to PayPal system to validate

$header = "POST /cgi-bin/webscr HTTP/1.1\r\n";

// If testing on Sandbox use:
$header .= "Host: www.sandbox.paypal.com\r\n";
$header .= "Connection: close\r\n";
//$header .= "Host: www.paypal.com:443\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

// If testing on Sandbox use:
$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);


// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$mc_gross = $_POST['mc_gross'];
$mc_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];

if (!$fp) {
// HTTP ERROR
} else {
    fputs ($fp, $header . $req);
    while (!feof($fp)) {
        $res = fgets ($fp, 1024);
        if (strcmp (trim($res), "VERIFIED") == 0) {
            $obj = new Donation($_POST);
            $obj->add();
        }
        else if (strcmp (trim($res), "INVALID") == 0) {
            $obj = new Donation($_POST);
            $obj->add();
        }
    }
    fclose ($fp);
}
?>