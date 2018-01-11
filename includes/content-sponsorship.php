<?php

$player = '';
$sponsor = '';

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

if(isset($_POST['submit'])){
    if(isset($_POST['playerId'],$_POST['sponsorId'])){
        if((Tools::formatPlayerid($_POST['playerId'])==false) or (Tools::formatPlayerid($_POST['sponsorId']))==false){
            $error = "Erreur : Le format des GUID fournit n'est pas corrects";
        }else{
            $player = Player::byPlayerid($_POST['playerId']);
            $sponsor = Player::byPlayerid($_POST['sponsorId']);
            if($_POST['playerId'] == $_POST['sponsorId']){
                $error = '<video id="gif-mp4" poster="https://media.giphy.com/media/h6FObJ8zJjBte/200_s.gif" style="margin:0;padding:0" width="229" height="264" autoplay="" loop="">
            <source src="https://media.giphy.com/media/h6FObJ8zJjBte/giphy.mp4" type="video/mp4">
            Your browser does not support the mp4 video codec.
        </video>';
            }elseif(!isset($player)) {
                $error = "Erreur : Vous n'êtes pas enregistré sur le serveur, vous devez vous connecter au moins une fois avant de vous faire parrainer";
            }elseif(!isset($sponsor)) {
                $error = "Erreur : Le GUID que vous avez entré comme parrain n'est pas enregistré sur le serveur, veuillez vérifier l'id de votre parrain";
            }elseif(isset($player->sponsor)) {
                $error = "Erreur : Vous avez déjà un parrain, mais bien tenté quand même :)";
                // send mail niaise
            }elseif($sponsor->sponsor == $player->playerid){
                $error = "Erreur : Bruh pk t'essaye de niaiser ? Tu peux pas parrainner ton parrain ... Come on man ! ";
                // send mail niaise
            }
            if (!isset($error)) {
                Tools::algoAddSponsor($player,$sponsor);
                $success = "Votre parrain à bien été enregistré, vous et lui allez être récompensé automatiquement. Par mesure de sécurité il est
            préférable d'attendre quelques minutes avant de vous reconnecter tous les deux";
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
            <h2 class="text-center uppercase">parrainages</h2>
            <hr class="primary">
            <p>Bienvenue sur la page de parrainage pour AltisFrance. Vous pouvez ici entrer directement les informations de votre
            parrain afin d'être immédiatement récompensé sans avoir recours à un membre du staff.</p>

            <div class="awards p-20 mb-20 row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="text-center">
                        <h3 class="text-color-blue mtb-10">Pour Chaque Filleuls</h3>
                        <p>20.000€ pour le filleul et son parrain</p>
                        <h3 class="text-color-blue mb-10">Total des filleuls</h3>
                    </div>
                    <ul class="p-0">
                        <li><span class="head bg-primary">3</span><span class="content">100.000€</span></li>
                        <li><span class="head bg-primary">5</span><span class="content">500.000€</span></li>
                        <li><span class="head bg-primary">10</span><span class="content">Véhicule terrestre de votre choix.</span></li>
                        <li><span class="head bg-primary">15</span><span class="content">Véhicule de votre choix.</span></li>
                        <li><span class="head bg-primary">20</span><span class="content">Maison offerte.</span></li>
                        <li><span class="head bg-primary">30</span><span class="content">Donateur à vie et grade "Le parrain" sur ts.</span></li>
                    </ul>
                </div>
            </div>

            <p class="warning p-20">ATTENTION : Pour que les récompenses vous soient envoyées directement suite à l'envoi de ce
            formulaire il est <b>IMPÉRATIF</b> que vous et votre parrain soient déconnectés, ou dans le lobby du serveur, sans quoi
            les modifications ne seront pas correctement enregistrée et <b>le staff ne sera ni responsable, ni en mesure de corriger celà.</b>
                    <br><br>Pour obtenir votre GUID, lancez Arma 3 et allez dans Configurer>Profil et prenez l'ID joueur.</p>
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
                <label class="p-0" for="user">GUID du filleuil</label><input class="block width-full" id="user" type="number" name="playerId" placeholder="GUID" value="<?= $player->playerid ?>" required>
                <label class="pt-40" for="sponsor">GUID du parrain</label><input class="block width-full" id="sponsor" type="number" name="sponsorId" placeholder="GUID" value="<?= $sponsor->playerid ?>" required>
                <input class="submit width-full mt-40" name="submit" type="submit">
            </form>
            <div class="mtb-20 text-center"><a href="http://altisfrance.fr" class="btn btn-primary btn-xl">Retour au site</a></div>
        </div>
    </div>
</div>
<div class="spacer-100"></div>