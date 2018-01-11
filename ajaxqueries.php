<?php
include_once('class/config.php');
session_start();

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

date_default_timezone_set('Europe/Paris');

if(isset($_SESSION['admin_id']) and Admin::byId($_SESSION['admin_id'])->status>0) {

    if (isset($_GET['query']) and $_GET['query'] == 'updateLic') {

        $status = $_GET['status'];
        $playerid = $_GET['playerid'];
        $id = $_GET['id'];
        $side = $_GET['side'];

        if (Tools::updateLicense($id, $status, $playerid, $side)) {
            $return['ok'] = 1;
        } else {
            $return['ok'] = 0;
        }
        echo json_encode($return);

    }

    if (isset($_GET['query']) and $_GET['query'] == 'toggleAliveVehicle') {

        $id = $_GET['id'];

        if (Vehicles::toogleAlive($id)) {
            $return['ok'] = 1;
        } else {
            $return['ok'] = 0;
        }
        echo json_encode($return);
    }

    if (isset($_GET['query']) and $_GET['query'] == 'toggleInsureVehicle') {

        $id = $_GET['id'];

        if (Vehicles::toogleInsure($id)) {
            $return['ok'] = 1;
        } else {
            $return['ok'] = 0;
        }
        echo json_encode($return);
    }

    if (isset($_GET['query']) and $_GET['query'] == 'delVehicle') {

        $id = $_GET['id'];

        if (Vehicles::delete($id)) {
            $return['ok'] = 1;
        } else {
            $return['ok'] = 0;
        }
        echo json_encode($return);
    }

    if (isset($_GET['query']) and $_GET['query'] == 'addSanction') {

        if(isset($_GET['playerid'])){
            $playerid = $_GET['playerid'];
        }elseif($_GET['name']){
            $players = Player::byName($_GET['name']);
            $playerid = $players[0]['playerid'];
        }else{
            $playerid = null;
        }

        if(isset($playerid)) {
            $sanction = new Sanction();
            $sanction->sanction = $_GET['sanction'];
            $sanction->playerid = $playerid;
            $sanction->type = $_GET['type'];
            $sanction->description = $_GET['desc'];
            $sanction->author = $_GET['author'];
            $sanction->date = date("Y-m-d H:i:s", time());
            if(isset($_GET['ticket'])) $sanction->ticket = $_GET['ticket'];

            $sanction->add();
            $return['ok']=1;
        }else{
            $return['ok']=0;
        }

        echo json_encode($return);
    }

    if (isset($_GET['query']) and $_GET['query'] == 'assignTicket') {
        $ticket = Ticket::byId($_GET['id']);
        $ticket->staff_id = $_GET['to'];
        $ticket->update();

        echo json_encode(array("ok"=>1));
    }

    if (isset($_GET['query']) and $_GET['query'] == 'setStatus') {
        $notif = Notification::byId($_GET['id']);
        $notif->setStatus(0);

        echo json_encode(array("ok"=>1));
    }

}else{
    if (isset($_GET['query']) and $_GET['query'] == "addDonation") {
        $txn_id = $_SESSION['txn_id'];
        $pId = $_GET['pId'];

        $transaction = Donation::byTxn($txn_id);

        $player = Player::byPlayerid($pId);

        if (!isset($player)) {
            $return = array("ok" => 0, "error" => "Id joueur inconnu");
        } elseif (!isset($transaction)) {
            $return = array("ok" => 0, "error" => "Transaction inconnue, contactez un Admin");
        }elseif($transaction->payment_status=="Processed"){
            $return = array("ok" => 2);
        }elseif($transaction->payment_status!="Completed"){
            $return = array("ok" => 0,"error" => "Cette transaction n'est pas validée, contactez un Admin");
        }else{
            switch($transaction->mc_gross){
                case 5 : $creditAdd = 30; break;
                case 10 : $creditAdd = 70; break;
                case 15 : $creditAdd = 110; break;
                case 20 : $creditAdd = 150; break;
                case 30 : $creditAdd = 250; break;
                default : $creditAdd = 0;
            }
            $player->credit += $creditAdd;

            $transaction->payment_status = "Processed";
            $transaction->update();

            $player->donatorlvl = 1;
            $player->update();

            $return = array("ok"=>1,"success"=>"Ta donation est bien prise en compte ! Tu es donateur jusqu'au ".date("d/m/Y",strtotime("+".$player->credit." days")));
        }

        echo json_encode($return);
    }
}