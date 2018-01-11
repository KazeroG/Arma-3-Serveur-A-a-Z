<?php

$player = '';
$sponsor = '';

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

if(isset($_POST['submit'])){
    if(!empty($_POST['playerId']) and !empty($_POST['codePromo'])) {

        $code = Code::byName($_POST['codePromo']);
        $player = Player::byPlayerid($_POST['playerId']);

        if(!Tools::formatPlayerid($_POST['playerId'])){
            $error = "Erreur : format de GUID érroné";
        }elseif(isset($player)) {
            $error = "Erreur : Vous êtes déjà enregistré sur le serveur, vous ne pouvez plus accéder à la prime de bienvenue";
        }elseif(!isset($code)) {
            $error = "Erreur : Le code promo est invalide";
            // send mail niaise
        }elseif($code->exp < date("Y-m-d H:i:s",time()) and $code->exp != '0000-00-00 00:00:00'){
            $error = "Erreur : Code Promo expiré";
        }elseif($code->use == 0){
            $error = "Erreur : Code promo déjà utilisé";
        }
        if (!isset($error)) {
            if($code->useCode()){
                $player = new Player();
                $player->playerid = $_POST['playerId'];
                $player->bankacc = 20000;
                $player->add();
                $success = "Votre inscription s'est bien passée, vous commencerez l'aventure avec l'argent de départ doublé ! Nous vous souhaitons un excellent
                séjour sur notre serveur et espérons qu'il vous plaira !";
            }
        }
    }elseif(!empty($_POST['playerId']) and empty($_POST['codePromo'])){

        $player = Player::byPlayerid($_POST['playerId']);
        if(!Tools::formatPlayerid($_POST['playerId'])){
            $error = "Erreur : format de GUID érroné";
        }elseif(isset($player)){
            $error = "Erreur : Vous êtes déjà enregistré sur le serveur, vous ne pouvez plus accéder à la prime de bienvenue";
        }else{
            $old = DB::select(['*'],"players_old",array('playerid'=>$_POST['playerId']));
            if(isset($old[0])){
                $player = new Player();
                $player->playerid = $_POST['playerId'];
                $player->name=$old[0]['name'];
                $player->bankacc = 20000;
                $player->add();
                $success = "Salut <b> {$old[0]['name']} </b> !<br> Content de te revoir ! Ton inscription s'est bien passée, et ton argent de départ doublé ! Nous te souhaitons un excellent
                séjour sur le serveur et espérons qu'il te plaira !";
            }else{
                $error = "Erreur : Tu n'es pas enregistré comme ancien membre d'AltisFrance";
            }
        }
    }
}

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
            <h2 class="text-center uppercase">Offre spéciale</h2>
            <hr class="primary">
            <p>Bienvenue sur la page des promotions AltisFrance,<br>Si vous êtes ici c'est que vous êtes un ancien joueurs d'AltisFrance. Vous avez la possibilité de pouvoir commencer l'aventure sur AltisFrance
            avec votre argent de départ doublé pour vous motiver dans votre nouvelle vie. Afin de souscrire à cette offre de promotion veuillez rentrer votre GUID dans le formulaire
            ci dessous.</p>

            <p class="warning p-20">ATTENTION : Si vous êtes un ancient il est impératif que vous remplissiez ce formulaire AVANT votre 1ère connexion au serveur
            sans quoi vous n'aurez pas la prime de départ (qui s'applique à votre première connexion).
                <br><br>Pour obtenir votre GUID, lancez Arma 3 et allez dans Configurer>Profil et prenez l'ID joueur.</p>

<!--            <p class="warning p-20">ATTENTION : Si vous êtes munit d'un code promo faites bien attention à bien écrire votre GUID, les codes ne-->
<!--            sont utilisables qu'une seule fois, si vous créditez un GUID qui n'est pas le votre alors c'est tant pis pour vous.</p>-->

            <?php if(isset($error)){
                echo "<p class=\"error p-20\">$error</p>";
            }elseif(isset($success)){
                echo "<p class=\"success p-20\">$success</p>";
            } ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12 col-sm-offset-0 text-justify">
            <form method="post" action="" class="p-30 minimalist">
                <label class="p-0" for="user">Votre GUID</label><input class="block width-full" id="user" type="number" name="playerId" placeholder="GUID" value="" required>
<!--                <label class="pt-40" for="sponsor">Code Promo</label><input class="block width-full" id="sponsor" type="text" name="codePromo" placeholder="Code promo" value="">-->
                <input class="submit width-full mt-40" name="submit" type="submit">
            </form>
            <div class="mtb-20 text-center"><a href="http://altisfrance.fr" class="btn btn-primary btn-xl">Retour au site</a></div>
        </div>
    </div>
</div>
<div class="spacer-100"></div>