<?php

require_once("class/config.php");

if(isset($_POST['submit'])){
    $player = Player::byPlayerid($_POST['playerid']);
    if(!isset($player)){
        $error = "Le Player ID ne correspond à aucun joueur enregistré";
    }else{
        $ticket = new Ticket();
        $ticket->date = $_POST['date']." ".$_POST['time'];
        $ticket->playerid = $player->playerid;
        $ticket->type = $_POST['type'];
        $ticket->description = $_POST['description'];
        $ticket->status = 1;
        if(isset($_POST['target'])) $ticket->target = $_POST['target'];
        if(isset($_POST['witness'])) $ticket->witness = $_POST['witness'];
        if(isset($_POST['files'])) $ticket->files = $_POST['files'];
        if($id = $ticket->add()){
            Notification::newTicketNotif()->sendAll();
            $hash = md5($id.sha1($ticket->playerid));
            echo "<script language=\"javascript\">";
            echo "window.location.replace('ticket.php?id=$id&hash=$hash');";
            echo "</script>";
            exit();
        }else{
            $error = "Une erreur s'est produite.";
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
            <h2 class="text-center uppercase">Support</h2>
            <hr class="primary">
            <p>Bienvenue sur la page de support AltisFrance. Ici vous pouvez laisser un ticket aux membres du STAFF afin de réfler
            un soucis relié au serveur. Afin de régler les problèmes plus facilement et de vous servir au mieux nous vous demandons
                une trace écrite de toute demande de modération. Chaque demande sera traitée par un membre du Staff le plus rapidement possible.</p>

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
            <div class="minimalist p-30 mb-20">
                <form method="post">
                    <div class="row mb-20">
                        <div class="col-lg-6">
                            <label class="p-0" for="user">Player ID auteur*</label>
                            <input class="block width-full" id="user" type="number" name="playerid" placeholder="GUID" required>
                        </div>
                        <div class="col-lg-3">
                            <label class="p-0" for="date">Date*</label>
                            <input class="block width-full datepicker-here" data-language='en' data-date-format="yyyy-mm-dd" id="date" type="text" name="date" placeholder="Date" value="<?php if(isset($_POST['date'])) echo $_POST['date']; ?>" required>
                        </div>
                        <div class="col-lg-3">
                            <label class="p-0" for="time">Heure*</label>
                            <input class="block width-full" id="time" type="time" name="time" required value="<?php if(isset($_POST['time'])) echo $_POST['time']; ?>">
                        </div>
                    </div>
                    <div class="row mb-20">
                        <div class="col-lg-6">
                            <label class="p-0" for="target">Joueur(s) concernés</label>
                            <input class="block width-full" id="target" type="text" name="target" placeholder="Nom" value="<?php if(isset($_POST['target'])) echo $_POST['target']; ?>">
                        </div>
                        <div class="col-lg-6">
                            <label class="p-0" for="witness">Joueur(s) témoins</label>
                            <input class="block width-full" id="witness" type="text" name="witness" placeholder="Nom" value="<?php if(isset($_POST['witness'])) echo $_POST['witness']; ?>">
                        </div>
                    </div>
                    <div class="row mb-20">
                        <div class="col-lg-12">
                            <label class="p-0" for="type-select">Type de support</label>
                            <select id="type" name="type">
                                <option value="Problème avec un joueur">Problème avec un joueur</option>
                                <option value="Bug du Serveur / jeu">Bug du Serveur / jeu</option>
                                <option value="Déco en scène RP">Déco en scène RP</option>
                                <option value="Freekill / Carkill">Freekill / Carkill</option>
                                <option value="Refus de coopérer">Refus de coopérer</option>
                                <option value="Remboursement">Remboursement</option>
                                <option value="Insultes">Insultes</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-20">
                        <div class="col-lg-12">
                            <label class="p-0" for="description">Description*</label>
                            <textarea class="full-width" id="description" name="description" placeholder="Description" style="text-align: left" required>
                                <?php if(isset($_POST['description'])) echo $_POST['description']; ?>
                            </textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label class="p-0" for="files">Preuve / Fichier</label>
                            <input class="block width-full" id="files" type="text" name="files" placeholder="url vidéo / screenshot" value="<?php if(isset($_POST['files'])) echo $_POST['files']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <input class="submit width-full mt-40" name="submit" type="submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="spacer-100"></div>