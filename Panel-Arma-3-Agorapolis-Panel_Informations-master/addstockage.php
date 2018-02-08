<?php
require "config.php";
if ($_SESSION['grade'] == 'Inconnu'){ // ah non, pas eux !!!
  header('Location: exit.php'); // pas d'intrus sur cette photo
} elseif(!isset($_SESSION['id'])){
  header('Location: login.php');
}
if ($_SESSION['grade'] == 'Harsh'){
	header('Location: index.php');
}
	if(isset($_POST['submit']))
	{
		if(!empty($_POST['type']))
		{
			$type = htmlspecialchars(trim($_POST['type']));
			$nbcoffres = htmlspecialchars(trim($_POST['nbcoffres']));
			$coordonnees = htmlspecialchars(trim($_POST['coordonnees']));
			$date = htmlspecialchars(trim($_POST['date']));
			$surnom = htmlspecialchars(trim($_POST['surnom']));
			$Cocaïne = htmlspecialchars(trim($_POST['Cocaïne']));
			$Héroïne = htmlspecialchars(trim($_POST['Héroïne']));
			$Marijuana = htmlspecialchars(trim($_POST['Marijuana']));
      $Speed = htmlspecialchars(trim($_POST['Speed']));
			$addrencontre = $bdd->prepare('INSERT INTO stockage(type, nbcoffres, coordonnees, date, surnom, Cocaïne, Héroïne, Marijuana, Speed) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)');
			$addrencontre->execute(array($type, $nbcoffres, $coordonnees, $date, $surnom, $Cocaïne, $Marijuana, $Héroïne, $Speed));
			header('Location: stockage.php');
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
			<h1>Ajouter un lieu de stockage</h1>
      <div class="col-md-12">
          <div class="panel panel-default">
                     <div class="panel-heading">Ajouter un lieu de stockage</div>
                     <div class="panel-body">
                      <form method="POST" class="form-horizontal">
                           <div class="form-group">
                              <label class="col-lg-2 control-label">Type</label>
                              <div style="padding-left:15px;"class="input-group pull-left">
                                   <div class="input-group pull-right">
                                      <select name="type" class="input-sm form-control">
                                         <option value="Maison">Maison</option>
                                         <option value="Hangar">Hangar</option>
                                      </select>
                                   </div>
                              </div></br></br>
                          </div>
                          <div class="form-group">
                             <label class="col-lg-2 control-label">Nombre de coffres</label>
                             <div style="padding-left:15px;"class="input-group pull-left">
                                  <div class="input-group pull-right">
                                     <select name="nbcoffres" class="input-sm form-control">
                                       <option value="1">1</option>
                                       <option value="2">2</option>
                                       <option value="3">3</option>
                                       <option value="4">4</option>
                                       <option value="5">5</option>
                                       <option value="6">6</option>
                                       <option value="7">7</option>
                                       <option value="8">8</option>
                                       <option value="9">9</option>
                                       <option value="10">10</option>
                                     </select>
                                  </div>
                             </div></br></br>
                           </div>
                           <div class="form-group">
                              <label class="col-lg-2 control-label">Coordonnés</label>
                              <div class="col-lg-10">
                                 <input name="coordonnees" type="text" placeholder="Coordonnées ( optionnel )" class="form-control">
                              </div>
                           </div>
                                 <input name="date" type="hidden" value="<?php
                                $date = date("d-m-Y");
                                echo"$date";
                                ?> ">
                                 <input type="hidden" name="surnom" value="<?= $_SESSION['surnom']; ?>" />

                           <div class="form-group">
                              <label class="col-lg-2 control-label">Contenance actuelle</label>
                              <div class="col-lg-2">
                                 <input name="Cocaïne" type="text" placeholder="Cocaïne" class="form-control">
                              </div>
                              <div class="col-lg-2">
                                 <input name="Héroïne" type="text" placeholder="Héroïne" class="form-control">
                              </div>
                              <div class="col-lg-2">
                                 <input name="Marijuana" type="text" placeholder="Marijuana" class="form-control">
                              </div>
                              <div class="col-lg-2">
                                 <input name="Speed" type="text" placeholder="Speed" class="form-control">
                              </div>
                           </div>

                           <?php if(isset($erreur)) { ?><p><font color="orange"><i class="fa fa-exclamation-circle"></i> <?= $erreur; ?></p></font><?php } ?>
                           </br></br>
                           <div class="form-group">
                              <div class="col-lg-offset-2 col-lg-10">
                                 <button name="submit" class="btn btn-sm btn-default">Ajouter</button>
                              </div>
                           </div>
                        </form>
            </div>
          </div>
        </div>

    </div>
  </main>
<script src="js/jquery-2.1.4.js"></script>
<script src="js/jquery.menu-aim.js"></script>
<script src="js/main.js"></script>
<script src="js/bootstrap.min.js" ></script>
</body>
</html>
