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
		if(!empty($_POST['identite']))
		{
			$statue = htmlspecialchars(trim($_POST['statue']));
			$dangerosite = htmlspecialchars(trim($_POST['dangerosite']));
			$identite = htmlspecialchars(trim($_POST['identite']));
			$telephone = htmlspecialchars(trim($_POST['telephone']));
			$date = htmlspecialchars(trim($_POST['date']));
			$pseudo = htmlspecialchars(trim($_POST['pseudo']));
			$informations = htmlspecialchars(trim($_POST['informations']));
			$pdv = htmlspecialchars(trim($_POST['pdv']));
			$carte = htmlspecialchars(trim($_POST['carte']));
			$addrencontre = $bdd->prepare('INSERT INTO rencontre(statue, dangerosite, identite, telephone, date, pseudo, informations, pdv, carte) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)');
			$addrencontre->execute(array($statue, $dangerosite, $identite, $telephone, $date, $pseudo, $informations, $pdv, $carte));
			header('Location: rencontre.php');
		}

		else
			{
				$erreur = "L'identité doit être completées";
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
			<h1>Ajouter une personne : </h1>
			<div class="col-md-12">
					<div class="panel panel-default">
                     <div class="panel-heading">Ajouter une personne</div>
                     <div class="panel-body">
											<form method="POST" class="form-horizontal">
                           <div class="form-group">
                              <label class="col-lg-2 control-label">Statue*</label>
                              <div style="padding-left:15px;"class="input-group pull-left">
					                         <div class="input-group pull-right">
					                            <select name="statue" class="input-sm form-control">
																				 <option value="Civil">Civil</option>
																				 <option value="Rebelle">Rebelle</option>
																				 <option value="Gendarme">Gendarme</option>
																				 <option value="Gouvernement">Gouvernement</option>
																				 <option value="Pompier">Pompier</option>
																 			</select>
 														 			 </div>
                           		</div></br></br>
													</div>
													<div class="form-group">
														 <label class="col-lg-2 control-label">Dangerosité*</label>
														 <div style="padding-left:15px;"class="input-group pull-left">
																	<div class="input-group pull-right">
																		 <select name="dangerosite" class="input-sm form-control">
																				<option value="Neutre">Neutre</option>
																				<option value="Amical">Amical</option>
																				<option value="Dangereux">Dangereux</option>
																		 </select>
																	</div>
														 </div></br></br>
												 </div>
													 <div class="form-group">
                              <label class="col-lg-2 control-label">Identité*</label>
                              <div class="col-lg-10">
                                 <input name="identite" type="text" class="form-control">
                              </div>
                           </div>
													 <div class="form-group">
                              <label class="col-lg-2 control-label">Téléphone</label>
                              <div class="col-lg-10">
                                 <input name="telephone" type="text" value="/" class="form-control">
                              </div>
                           </div>

                                 <input name="date" type="hidden" value="<?php
										 						$date = date("d-m-Y");
										 						echo"$date";
										 						?> ">
																 <input type="hidden" name="pseudo" value="<?= $_SESSION['pseudo']; ?>" />

													 <div class="form-group">
                              <label class="col-lg-2 control-label">Informations</label>
                              <div class="col-lg-10">
                                 <input name="informations" value="/" type="text" class="form-control">
                              </div>
                           </div>
													 <div class="form-group">
                              <label class="col-lg-2 control-label">Point de vue</label>
                              <div class="col-lg-10">
                                 <input name="pdv" type="text" value="/" class="form-control">
                              </div>
                           </div>
													 <div class="form-group">
                              <label class="col-lg-2 control-label">Carte d'identité</label>
                              <div class="col-lg-10">
                                 <input name="carte" type="text" placeholder="Laisser vide si vous ne l'avez pas" value="http://image.noelshack.com/fichiers/2016/47/1480012595-carte-identite.png" class="form-control">
                              </div>
                           </div>
                           <p style="padding-left:220px;font-style: italic;">Laisser le lien de la carte d'identité si vous n'avez pas celle de la personne</p>
													 <p style="padding-left:220px;font-style: italic;">Veiller à mettre le lien de l'image et non celle de l'hebergeur !</p>
													 <i style="padding-left:220px;font-style: italic;">Laisser tel quel si informations non connues</i>
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
	</div>
	</main>
<script src="js/jquery-2.1.4.js"></script>
<script src="js/jquery.menu-aim.js"></script>
<script src="js/main.js"></script>
</body>
</html>
