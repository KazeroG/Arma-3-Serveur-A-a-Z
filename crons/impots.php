<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include_once('../class/config.php');

if(isset($_GET['hash']) and $_GET['hash'] == '267ef5d5f8d0a99889c284f7180dff4f21961b8f'){

    $time = date("Y-m-d",time());

    // GET MONEY INCOME //

    $sql = "SELECT SUM(cash*0.05+bankacc*0.05) as income FROM players
            WHERE coplevel = '0' AND (civ_licenses LIKE '%`license_civ_G1`,1%'
            OR civ_licenses LIKE '%`license_civ_G2`,1%'
            OR civ_licenses LIKE '%`license_civ_G3`,1%'
            OR civ_licenses LIKE '%`license_civ_G4`,1%')";
    $q = DB::get()->query($sql);
    $f = $q->fetch();
    $income = (int) $f['income'];

    // GET MONEY GANGS //

    $sql = "SELECT SUM(bank*0.05) as income FROM gangs WHERE legal = 1 and id > 0";
    $q = DB::get()->query($sql);
    $f = $q->fetch();
    $income += (int) $f['income'];

    // UPDATE CIV //

    $civ = Player::getCiv();
    foreach($civ as $p){
        $player = Player::byPlayerid($p['playerid']);
        $player->cash *= 0.95;
        $player->bankacc *= 0.95;
        $player->update();
    }

    // UPDATE GANG //

    $sql = "SELECT id,bank FROM gangs WHERE legal = 1 AND id > 0";
    $gangs = DB::get()->query($sql);
    $gangs = $gangs->fetchAll();
    foreach($gangs as $g){
        $bank = $g['bank']*0.9;
        DB::update(GANGS_TABLE,array("bank"=>$bank),array("id"=>$g['id']));
    }

    // ADD MONEY TO STATE BANK

    $total = DB::select(['bank'],GANGS_TABLE,array('id'=>0));
    $total = (int) $total[0]['bank']+$income;
    DB::update(GANGS_TABLE,array('bank'=>$total),array('id'=>0));
    $query = DB::insert(IMPOTS_TABLE,array('date'=>$time,'income'=>$income,'total'=>$total));

}else{
    echo 'nope';
}