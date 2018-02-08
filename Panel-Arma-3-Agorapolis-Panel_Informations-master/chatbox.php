<?php
require "config.php";
if ($_SESSION['grade'] == 'Inconnu'){ // ah non, pas eux !!!
  header('Location: exit.php'); // pas d'intrus sur cette photo
} elseif(!isset($_SESSION['id'])){
  header('Location: index.php');
}
if ($_SESSION['grade'] == 'Harsh'){
	header('Location: harsh.php');
}
 ?>
    <?php
    include 'load/head.php';
    ?>
	<main class="cd-main-content">
		<?php
    include 'load/navbar.php';
    ?>
    <div id="spider">
		<div class="content-wrapper">
			<h1>Shoutbox</h1>



<?php

require_once('config.php');

function Smiley($smiley){

    $search  = array(':dance:', ':D',':bave:',':$', ':bye:', ':coeur:', ':crazy:', ':devil:', ':DJ:', ':dodo:', ':nrv:', ':espion:', 'o_O', ':@', ':fight:', ':hug:', ':p', ':love:', ':mmh:', ':modo:', ':neo:', ':non:', ':oui:', ':mechant:', ':puke:', ':1punch:', ':rofl:', ':bad:', ':tchuss:', ':\'(', ':nice:', ':troll:');

    $replace = array('<img src="shoutbox/smileys/dance.gif" />', '<img src="shoutbox/smileys/awesone.png" />', '<img src="shoutbox/smileys/bave.gif" />', '<img src="shoutbox/smileys/blush.gif" />', '<img src="shoutbox/smileys/bye.gif" />', '<img src="shoutbox/smileys/coeur.gif" />', '<img src="shoutbox/smileys/crazy.gif" />', '<img src="shoutbox/smileys/devil.gif" />', '<img src="shoutbox/smileys/DJ.gif" />', '<img src="shoutbox/smileys/dodo.gif" />', '<img src="shoutbox/smileys/enerve.gif" />', '<img src="shoutbox/smileys/espion.gif" />', '<img src="shoutbox/smileys/etonne.gif" />', '<img src="shoutbox/smileys/facher.gif" />', '<img src="shoutbox/smileys/fight.gif" />', '<img src="shoutbox/smileys/hug.gif" />', '<img src="shoutbox/smileys/joueur.gif" />', '<img src="shoutbox/smileys/love.gif" />', '<img src="shoutbox/smileys/mmh.gif" />', '<img src="shoutbox/smileys/modo.gif" />', '<img src="shoutbox/smileys/neo.gif" />', '<img src="shoutbox/smileys/non.gif" />', '<img src="shoutbox/smileys/oui.gif" />', '<img src="shoutbox/smileys/pelo.gif" />', '<img src="shoutbox/smileys/puke.gif" />', '<img src="shoutbox/smileys/punch.gif" />', '<img src="shoutbox/smileys/rofl.gif" />', '<img src="shoutbox/smileys/bad.gif" />', '<img src="shoutbox/smileys/tchuss.gif" />', '<img src="shoutbox/smileys/triste.gif" />', '<img src="shoutbox/smileys/nice.gif" />', '<img src="shoutbox/smileys/troll.png" />');

    $smiley = str_replace($search, $replace, $smiley);
    return $smiley;

}

if(isset($_POST['shoutbox']))
	{
		$message = htmlspecialchars(trim($_POST['message']));
        $messagesmiley = Smiley($message);

		if(!empty($message))
		{
			$MessageLimite = strlen($messagesmiley);
			if($MessageLimite <= 500)
			{
				if(!isset($_COOKIE['messagesmiley']))

				{

                    $bonjour = explode('@BOT', $messagesmiley);

                    if($_SESSION['grade'] == "Agent Divisionnaire" || $_SESSION['grade'] == "Agent Representant"){
                    $bot = explode('/bot', $messagesmiley);
                    $vide = explode('/vide', $messagesmiley);

                }

                if(isset($bot['1']))
                {
                    $robot = $bot['1'];
                    $MessageBot = $bdd->prepare('INSERT INTO shoutbox(utilisateur, message, rank, date_p, avatar) VALUES(?, ?, ?, NOW(), ?)');
                    $MessageBot->execute(array('BOT', $robot, '2', 'https://website.smooch.io/static_assets/images/features/bot-avatar.png'));
                }
                    elseif(isset($vide['1']))
                {
                    $CommandeVide = $bdd->prepare('TRUNCATE shoutbox');
                    $CommandeVide->execute(array());
                    $CommandeVide = $bdd->prepare('INSERT INTO shoutbox(utilisateur, message, rank, date_p, avatar) VALUES(?, ?, ?, NOW(), ?)');
                    $CommandeVide->execute(array($_SESSION['pseudo'], 'vient de vider la shoutbox.', $_SESSION['grade'], $_SESSION['avatar']));
                }

                    elseif(isset($bonjour['1']))
                {
                    $CommandeBonjour = $bdd->prepare('INSERT INTO shoutbox(utilisateur, message, rank, date_p, avatar) VALUES(?, ?, ?, NOW(), ?)');
                    $CommandeBonjour->execute(array($_SESSION['pseudo'], $messagesmiley, $_SESSION['grade'], $_SESSION['avatar']));
                    $CommandeBonjour = $bdd->prepare('INSERT INTO shoutbox(utilisateur, message, rank, date_p, avatar) VALUES(?, ?, ?, NOW(), ?)');
                    $CommandeBonjour->execute(array('BOT', 'Salut '.$_SESSION['pseudo'].' <img src="shoutbox/smileys/awesone.png" />', '2', 'https://website.smooch.io/static_assets/images/features/bot-avatar.png'));
                }
                    else
                {

					$MessageGo = $bdd->prepare('INSERT INTO shoutbox(utilisateur, message, rank, date_p, avatar) VALUES(?, ?, ?, NOW(), ?)');
					$MessageGo->execute(array($_SESSION['pseudo'], $messagesmiley, $_SESSION['grade'], $_SESSION['avatar']));
					setcookie('message', $message, time()+0, null, null, false, true);
					unset($_POST);
				}
        }
				else
				{
					$erreur = "Un message toute les 5 secondes !";
				}
			}
			else
			{
				$erreur = "Le message ne doit pas dépasser les 100 caractères !";
			}
		}
		else
		{
			$erreur = "Veuillez mettre un message !";
		}
	}

?>

    <div class="be-wrapper">

      <div class="be-content">
        <div class="main-content container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-border-color panel-border-color-primary" style="border:1px solid grey">
                <div class="panel-body">
                    <form method="post" action="">
                    <div class="input-group">
									<input type="text" class="form-control" id="message" name="message" placeholder="Entrer votre message..." autocomplete="off">
									<span class="input-group-btn">
										<button type="submit" name="shoutbox" class="btn btn-primary">Envoyer</button>
									</span>
								</div>
                    </form>
                  </div>
                <div class="panel-body" style="height: 350px; margin: 0 auto 5px auto; font-size:12px; overflow: auto;">

                  <div id="chargemsg"><?php include "shoutbox/chargement_shoutbox.php"; ?></div>

                  </div>
                </div>
              </div>
            </div>
            </div>
            </div>
        </div>
      </div>
    </div>
    <script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <script src="assets/js/main.js" type="text/javascript"></script>
    <script src="assets/lib/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script>
		  	    setInterval('chargement_msg()', 2000);
                function chargement_msg() {
                $('#chargemsg').load('shoutbox/chargement_shoutbox.php');
                }
    </script>
    <script type="text/javascript">
      $(document).ready(function(){
      	App.init();
      });

    </script>
    <script type="text/javascript">
		function Tag(Utilisateur) {
			var tbx = document.getElementById("message");
			tbx.value += "@" + Utilisateur + " ";
			tbx.focus();
		}
	</script>



  </div>
</div>
	</main> <!-- .cd-main-content -->
<script src="js/jquery-2.1.4.js"></script>
<script src="js/jquery.menu-aim.js"></script>
<script src="js/main.js"></script> <!-- Resource jQuery -->
<script src="js/bootstrap.min.js" ></script>
</body>
</html>
