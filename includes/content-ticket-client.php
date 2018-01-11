<?php

if (!isset($_GET['id']) and $_GET['id']!="") {
    echo "<script language=\"javascript\">";
    echo "window.location.replace('http://admin.altisfrance.Fr/support.php');";
    echo "</script>";
    exit();
}

require_once("class/config.php");

$ticket = Ticket::byId($_GET['id']);
if(!isset($ticket)){
    echo "<script language=\"javascript\">";
    echo "window.location.replace('http://admin.altisfrance.Fr/support.php');";
    echo "</script>";
    exit();
}

$hash = md5($ticket->id.sha1($ticket->playerid));
if($hash != $_GET['hash']){
    echo "<script language=\"javascript\">";
    echo "window.location.replace('http://admin.altisfrance.Fr/support.php');";
    echo "</script>";
    exit();
}

$admin = Admin::byId($ticket->staff_id);

?>

<div class="spacer-50"></div>
<div class="container">
    <div class="row">
        <a href="http://altisfrance.fr" title="retour au site"><img class="center-block" width="150" src="http://altisfrance.fr/img/logo_af.png"></a>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12 col-sm-offset-0 text-justify">
            <div class="corner-ribbon top-right sticky <?= $ticket->status==1 ? "blue \">Ouvert</div>":"red \">Fermé</div>"; ?>
            <h2 class="text-center uppercase">Ticket n°<?= $ticket->id." : ".$ticket->type." (".date("d/m/Y H\hi",strtotime($ticket->date)).")" ?></h2>
            <hr class="primary">
            <?php if(isset($error)){
                echo "<p class=\"error p-20\">$error</p>";
            }elseif(isset($success)){
                echo "<p class=\"success p-20\">$success</p>";
            } ?>
            <p class="warning p-20">ATTENTION : Ce ticket est personnel, vous pouvez accéder à celui ci uniquement grâce à son URL
                dans votre barre d'adresse, merci de ne pas la perdre si vous comptez revenir consulter la réponse du staff et les
                éventuelles sanctions.</p>
            <div class="minimalist p-30 mb-20">
                <div class="row mb-20">
                    <div class="col-lg-6">
                        <label class="p-0">Auteur</label>
                        <div class="content-brd width-full"><?= Player::byPlayerid($ticket->playerid)->name ?></div>
                    </div>
                    <div class="col-lg-6">
                        <label class="p-0">Staff assigné</label>
                        <div class="content-brd width-full"><?php echo isset($admin)?$admin->login." - ".$admin->displayRank():"Pas encore assigné" ?></div>
                    </div>
                </div>
                <div class="row mb-20">
                    <div class="col-lg-6">
                        <label class="p-0">Joueurs concernés</label>
                        <div class="content-brd width-full"><?= $ticket->target?$ticket->target:"Aucuns" ?></div>
                    </div>
                    <div class="col-lg-6">
                        <label class="p-0">Joueurs témoins</label>
                        <div class="content-brd width-full"><?= $ticket->witness?$ticket->witness:"Aucuns" ?></div>
                    </div>
                </div>
                <div class="row mb-20">
                    <div class="col-lg-12">
                        <label class="p-0">Description</label>
                        <div class="content-brd width-full"><?= $ticket->description ?></div>
                    </div>
                </div>
                <div class="row mb-50">
                    <div class="col-lg-12">
                        <label class="p-0">Preuve / fichier</label>
                        <div class="content-brd width-full"><?= $ticket->files?$ticket->files:"N/A" ?></div>
                    </div>
                </div>
                <div class="row mb-20">
                    <div class="col-lg-12">
                        <label class="p-0">Réponse du staff</label>
                        <div class="content-brd width-full"><?= $ticket->answer?$ticket->answer:"N/A" ?></div>
                    </div>
                </div>
                <?php
                $sanctions = Sanction::byTicket($ticket->id);
                if(!empty($sanctions)){
                    echo "<label class=\"p-0\">Délibérations du staff</label>";
                    foreach($sanctions as $s) {
                        if($s->type==2) $color = "red" ;
                        if($s->type==1) $color = "orange" ;
                        echo "<div class=\"content-brd mb-10 $color\">".date("d/m/Y H\hi",strtotime($s->date))." - ".Player::byPlayerid($s->playerid)->name." : $s->sanction</div>";
                    }
                } ?>
            </div>
        </div>
    </div>
</div>
<div class="spacer-100"></div>