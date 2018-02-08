<?php
require "config.php";
if ($_SESSION['grade'] == 'Inconnu'){ // ah non, pas eux !!!
  header('Location: exit.php'); // pas d'intrus sur cette photo
} elseif(!isset($_SESSION['id'])){
  header('Location: login.php');
}
if(isset($_SESSION['id']))
{
    $rUsers = $bdd->prepare("SELECT * FROM users WHERE id = ?");
    $rUsers->execute(array($_SESSION['id']));
    $user = $rUsers->fetch();


    if(isset($_POST['surnom']) AND !empty($_POST['surnom']) AND $_POST['surnom'] != $user['surnom'])
    {
            $surnom = htmlspecialchars($_POST['surnom']);
            $isurnom = $bdd->prepare("UPDATE users SET surnom = ? WHERE id = ?");
            $isurnom->execute(array($surnom, $_SESSION['id']));
            header('Location: profil.php');
    }

    if(isset($_POST['surnom2']) AND !empty($_POST['surnom2']) AND $_POST['surnom2'] != $user['surnom2'])
    {
            $surnom2 = htmlspecialchars($_POST['surnom2']);
            $isurnom2 = $bdd->prepare("UPDATE users SET surnom2 = ? WHERE id = ?");
            $isurnom2->execute(array($surnom2, $_SESSION['id']));
            header('Location: profil.php');
    }

    if(isset($_POST['telephone']) AND !empty($_POST['telephone']) AND $_POST['telephone'] != $user['telephone'])
    {
            $telephone = htmlspecialchars($_POST['telephone']);
            $itelephone = $bdd->prepare("UPDATE users SET telephone = ? WHERE id = ?");
            $itelephone->execute(array($telephone, $_SESSION['id']));
            header('Location: profil.php');
    }

    if(isset($_POST['email']) AND !empty($_POST['email']) AND $_POST['email'] != $user['email'])
    {
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            {
                $email = htmlspecialchars($_POST['email']);
                $iEmail = $bdd->prepare("UPDATE users SET email = ? WHERE id = ?");
                $iEmail->execute(array($email, $_SESSION['id']));
                header('Location: profil.php');
            }
    }

    if(isset($_POST['password']) AND !empty($_POST['password']) AND isset($_POST['password2']) AND !empty($_POST['password2']))
    {
            $password = md5(sha1($_POST['password']));
            $password2 = md5(sha1($_POST['password2']));

            if($password == $password2)
            {
                $insertmdp = $bdd->prepare("UPDATE users SET password = ? WHERE id = ?");
                $insertmdp->execute(array($password, $_SESSION['id']));
                header('Location: profil.php');
            }
            else
            {
                $msg = "Vos deux mot de passe ne correspondent pas !";
            }
    }

    if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name']))
    {
            $tailleMax = 2097152;
            $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
            if($_FILES['avatar']['size'] <= $tailleMax)
            {
                $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
                if(in_array($extensionUpload, $extensionsValides))
                {
                    $chemin = "membres/avatars/".$_SESSION['id'].".".$extensionUpload;
                    $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
                    if($resultat)
                    {
                        $updateavatar = $bdd->prepare('UPDATE users SET avatar = :avatar WHERE id = :id');
                        $updateavatar->execute(array(
                            'avatar' => $_SESSION['id'].".".$extensionUpload,
                            'id' => $_SESSION['id']
                            ));
                        header('Location: profil.php');
                    }
                    else
                    {
                        $erreur = "Erreur durant l'importation de votre photo de profil";
                    }
                }
                else
                {
                    $erreur = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
                }
            }
            else
            {
                $erreur = "Votre photo de profil ne doit pas dépasser 2Mo";
            }
    }

}
?>
<?php
include 'load/head.php';
?>
<main class="cd-main-content">
<?php
include 'load/navbar.php';
?>

		<div class="content-wrapper">
			<h1>Profil</h1>
      <div class="container">
        <header>
          <h2>Panel utilisateur</h2>
          <p>Éditez vos informations par le biais de ce formulaire :
          </p>
          <?php if(isset($erreur)) { ?><p><font color="red"><i class="fa fa-exclamation-circle"></i> <?= $erreur; ?></font></p><?php } ?>
        </header>
        <div class="row">
          <div class="col-md-8">
            <form method="POST" class="row" enctype="multipart/form-data">
              <div class="form-group col-md-6">
                <input name="surnom" type="text" placeholder="Votre nouveau surnom" class="form-control" />
              </div>
              <div class="form-group col-md-6">
                <input name="surnom2" type="text" placeholder="Identité à donnée" class="form-control" />
              </div>
              <div class="form-group col-md-12">
                <input name="telephone" type="text" placeholder="Votre numéro de téléphone" class="form-control" />
              </div>
              <div class="form-group col-md-12">
                <input name="email" type="email" placeholder="Votre nouvelle email" class="form-control" />
              </div>
              <div class="form-group col-md-12">
                <input name="password" type="password" placeholder="Nouveau mot de passe" class="form-control" />
              </div>
              <div class="form-group col-md-12">
                <input name="password2" type="password" placeholder="Confirmation du nouveau mot de passe" class="form-control" />
              </div>
              <div class="form-group col-md-12">
              <label for="avatar">Un avatar ?</label><input id="avatar" type="file" name="avatar"><br />
            </div>
              <div class="form-group col-md-12">
                <button class="btn btn-lg btn-primary">Changer</button>
              </div>
            </form>
            <?php if(isset($msg)) { ?><p><font color="red"><i class="fa fa-exclamation-circle"></i> <?= $msg; ?></p></font><?php } ?>
          </div>
          <div class="col-md-3 col-md-offset-1">
            <address>
              <span><u>Vos informations</u></span></br></br>
                <img src="membres/avatars/<?= $_SESSION['avatar']; ?>" style="border-radius:5%;width:300px;"><br /><br />
              <p>Identité : <b><?= $_SESSION['pseudo']; ?></b></p>
              <p>Connu sous le nom : <b><?= $_SESSION['surnom2']; ?></b></p>
              <p>Pseudo : <b><?= $_SESSION['surnom']; ?></b></p>
              <p>Email : <b><?= $_SESSION['email']; ?></b></p>
              <p>Grade : <b style="color:<?php
                               if($_SESSION['grade'] == 'Agent Representant') { echo "#E06666"; }
                               if($_SESSION['grade'] == 'Agent') { echo "#999999"; }
                               if($_SESSION['grade'] == 'Agent Renegat') { echo "#6AA84F"; }
                            ?>;"><?= $_SESSION['grade']; ?></b></p>
          </div>
          </div>
        </div>
	</main> <!-- .cd-main-content -->
<script src="js/jquery-2.1.4.js"></script>
<script src="js/jquery.menu-aim.js"></script>
<script src="js/main.js"></script> <!-- Resource jQuery -->
<script src="js/bootstrap.min.js" ></script>
</body>
</html>
