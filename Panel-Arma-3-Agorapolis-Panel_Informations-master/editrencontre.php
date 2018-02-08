<?php
require "config.php";
if ($_SESSION['grade'] == 'Inconnu'){ // ah non, pas eux !!!
  header('Location: exit.php'); // pas d'intrus sur cette photo
} elseif(!isset($_SESSION['id'])){
  header('Location: index.php');
}
if ($_SESSION['grade'] == 'Harsh'){
	header('Location: index.php');
}
if(isset($_POST['submit']))
{
  $id = htmlspecialchars(trim($_POST['id']));
  $statue = htmlspecialchars(trim($_POST['statue']));
  $dangerosite = htmlspecialchars(trim($_POST['dangerosite']));
  $identite = htmlspecialchars(trim($_POST['identite']));
  $telephone = htmlspecialchars(trim($_POST['telephone']));
  $date = htmlspecialchars(trim($_POST['date']));
  $pseudo = htmlspecialchars(trim($_POST['pseudo']));
  $informations = htmlspecialchars(trim($_POST['informations']));
  $pdv = htmlspecialchars(trim($_POST['pdv']));
  $carte = htmlspecialchars(trim($_POST['carte']));
  $UPDATEcommande = $bdd->prepare("UPDATE rencontre SET statue = ?, dangerosite = ?, identite = ?, telephone = ?, date = ?, pseudo = ?, informations = ?, pdv = ?, carte = ? WHERE id = ?");
  $UPDATEcommande->execute(array($statue, $dangerosite, $identite, $telephone, $date, $pseudo, $informations, $pdv, $carte, $id));
  header('Location:	rencontre.php');
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
			<h1>Editer les rencontres que j'ai saisies</h1>
      <table class="order-table table table-bordered table-hover">
        <thead>
           <tr>
              <th style="width: 10%">Carte d'identité</th>
              <th style="width: 10%">Date de rencontre</th>
              <th style="width: 11%">Statue</th>
              <th style="width: 10%">Identité</th>
              <th style="width: 8%">Téléphone</th>
              <th style="width: 5%">Dangerosité</th>
              <th style="width: 20%">Informations</th>
              <th style="width: 20%">Point de vue</th>
              <th style="width: 10%">Modification</th>
           </tr>
        </thead>
        <tbody>

      <?php
      if ($_SESSION['grade'] == 'Agent Divisionnaire') {

			$rencontre1 = $bdd->prepare("SELECT `id`, `statue`, `dangerosite`, `identite`, `telephone`, `date`, `pseudo`, `informations`, `pdv`, `carte` FROM `rencontre`");
			$rencontre1->bindParam(":pseudo", $_SESSION["pseudo"], PDO::PARAM_STR);
			$rencontre1->execute();
			while($Data = $rencontre1->fetch()):?>
               <tr>
                 <form action="editrencontre.php" method="post">
                  <input value="<?=$Data["id"] ?>" name="id" type="hidden" class="form-control">
                  <input value="<?=$Data["pseudo"] ?>" name="pseudo" type="hidden" class="form-control">
                  <td align='center'><input value="<?=$Data["carte"] ?>" name="carte" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["date"] ?>" name="date" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["statue"] ?>" name="statue" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["identite"] ?>" name="identite" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["telephone"] ?>" name="telephone" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["dangerosite"] ?>" name="dangerosite" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["informations"] ?>" name="informations" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["pdv"] ?>" name="pdv" type="text" class="form-control"></td>
                  <th style='width:15%;padding-left:20px'><button name='submit' class='btn btn-sm btn-primary link'>Appliquer</button></th>
                  </form>
               </tr>

			<?php endwhile;
			}
      ?>

      <?php
      if ($_SESSION['grade'] == 'Agent Representant') {

			$rencontre1 = $bdd->prepare("SELECT `id`, `statue`, `dangerosite`, `identite`, `telephone`, `date`, `pseudo`, `informations`, `pdv`, `carte` FROM `rencontre`");
			$rencontre1->bindParam(":pseudo", $_SESSION["pseudo"], PDO::PARAM_STR);
			$rencontre1->execute();
			while($Data = $rencontre1->fetch()):?>
               <tr>
                 <form action="editrencontre.php" method="post">
                  <input value="<?=$Data["id"] ?>" name="id" type="hidden" class="form-control">
                  <input value="<?=$Data["pseudo"] ?>" name="pseudo" type="hidden" class="form-control">
                  <td align='center'><input value="<?=$Data["carte"] ?>" name="carte" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["date"] ?>" name="date" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["statue"] ?>" name="statue" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["identite"] ?>" name="identite" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["telephone"] ?>" name="telephone" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["dangerosite"] ?>" name="dangerosite" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["informations"] ?>" name="informations" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["pdv"] ?>" name="pdv" type="text" class="form-control"></td>
                  <th style='width:15%;padding-left:20px'><button name='submit' class='btn btn-sm btn-primary link'>Appliquer</button></th>
                  </form>
               </tr>

			<?php endwhile;
			}
      ?>

      <?php
      if ($_SESSION['grade'] == 'Agent Renegat') {

			$rencontre1 = $bdd->prepare("SELECT `id`, `statue`, `dangerosite`, `identite`, `telephone`, `date`, `pseudo`, `informations`, `pdv`, `carte` FROM `rencontre` WHERE `pseudo` = :pseudo");
			$rencontre1->bindParam(":pseudo", $_SESSION["pseudo"], PDO::PARAM_STR);
			$rencontre1->execute();
			while($Data = $rencontre1->fetch()):?>
               <tr>
                 <form action="editrencontre.php" method="post">
                  <input value="<?=$Data["id"] ?>" name="id" type="hidden" class="form-control">
                  <input value="<?=$Data["pseudo"] ?>" name="pseudo" type="hidden" class="form-control">
                  <td align='center'><input value="<?=$Data["carte"] ?>" name="carte" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["date"] ?>" name="date" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["statue"] ?>" name="statue" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["identite"] ?>" name="identite" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["telephone"] ?>" name="telephone" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["dangerosite"] ?>" name="dangerosite" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["informations"] ?>" name="informations" type="text" class="form-control"></td>
                  <td align='center'><input value="<?=$Data["pdv"] ?>" name="pdv" type="text" class="form-control"></td>
                  <th style='width:15%;padding-left:20px'><button name='submit' class='btn btn-sm btn-primary link'>Appliquer</button></th>
                  </form>
               </tr>

			<?php endwhile;
			}
      ?>
        </tbody>
      </table>
		</div>
	 </div>
	</main>

<script src="js/app.js"></script>
<script src="js/jquery-2.1.4.js"></script>
<script src="js/jquery.menu-aim.js"></script>
<script src="js/main.js"></script>
<script src="js/bootstrap.min.js" ></script>
</body>
</html>
