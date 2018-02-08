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


if( isset($_POST['upload']) ) // si formulaire soumis
{
    $content_dir = 'music/'; // dossier où sera déplacé le fichier

    $tmp_file = $_FILES['fichier']['tmp_name'];

    if( !is_uploaded_file($tmp_file) )
    {
        exit("Le fichier est introuvable");
    }

    // on vérifie maintenant l'extension
    $type_file = $_FILES['fichier']['type'];

    if( !strstr($type_file, 'mp3') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') )
    {
        exit("Le fichier n'est pas une image");
    }

    // on copie le fichier dans le dossier de destination
    $name_file = $_FILES['fichier']['name'];

    if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
    {
        exit("Impossible de copier le fichier dans $content_dir");
    }

    //

    $content_dir1 = 'music/img/'; // dossier où sera déplacé le fichier

    $tmp_file1 = $_FILES['fichier1']['tmp_name'];

    if( !is_uploaded_file($tmp_file1) )
    {
        exit("Le fichier est introuvable");
    }

    // on vérifie maintenant l'extension
    $type_file1 = $_FILES['fichier1']['type'];

    if( !strstr($type_file1, 'jpg') && !strstr($type_file1, 'jpeg') && !strstr($type_file1, 'png') && !strstr($type_file1, 'gif') )
    {
        exit("Le fichier n'est pas une image");
    }

    // on copie le fichier dans le dossier de destination
    $name_file1 = $_FILES['fichier1']['name'];

    if( !move_uploaded_file($tmp_file1, $content_dir1 . $name_file1) )
    {
        exit("Impossible de copier le fichier dans $content_dir1");
    }

    $titre = htmlspecialchars(trim($_POST['titre']));
    $auteur = htmlspecialchars(trim($_POST['auteur']));
    $url = $name_file;
    $photo = $name_file1;
    $pseudo = htmlspecialchars(trim($_POST['pseudo']));
    $date_p = htmlspecialchars(trim($_POST['date_p']));
    $addarticle = $bdd->prepare('INSERT INTO musique(titre, auteur, url, photo, pseudo, date_p) VALUES(?, ?, ?, ?, ?, ?)');
    $addarticle->execute(array($titre, $auteur, $url, $photo, $pseudo, $date_p));
    header('Location: musique.php');
}


 ?>
    <?php
    include 'load/head.php';
    ?>
	<main class="cd-main-content">


    <?php if ($_SESSION['grade'] == 'Harsh') { ?>


      <nav class="cd-side-nav">
        <ul>
          <li class="cd-label">Principal</li>
          <li class="has-children comments">
            <a href="#0">Rencontres</a>

            <ul>
              <li><a href="rencontre">Listes des rencontres</a></li>
            </ul>
          </li>
          <li class="has-children comments">
            <a href="harsh">Harsh</a>
          </li>
          <li class="has-children comments">
            <a href="/articles/" data-no-instant>Journal</a>

          </li>

        </ul>

      </nav>

      <script src="js/instantclick.min.js" data-no-instant></script>
      <script data-no-instant>InstantClick.init();</script>

    <?php }
    else { ?>



    <nav class="cd-side-nav">
      <ul>
        <li class="cd-label">Principal</li>
        <li class="has-children overview">
          <a href="accueil">Vue complète</a>
        </li>
        <li class="has-children comments">
          <a href="#0">Rencontres</a>

          <ul>
            <li><a href="addrencontre">Ajouter une personne</a></li>
            <li><a href="rencontre">Listes des rencontres</a></li>
            <li><a href="editrencontre">Editer mes rencontres</a></li>
          </ul>
        </li>
        <li class="has-children comments">
          <a href="#0">Stockage</a>
          <ul>
            <li><a href="addstockage">Ajouter un lieu de stockage</a></li>
            <li><a href="stockage">Listes des stockages</a></li>
            <li><a href="editstockage">Editer mes stockages</a></li>
          </ul>
        </li>
        <li class="has-children comments">
          <a href="harsh">Harsh</a>
        </li>
        <li class="has-children comments">
          <a href="itineraire">Itinéraires</a>
        </li>
        <li class="has-children comments">
          <a href="#0">Revendication</a>
          <ul>
            <li><a href="revendication">Toutes les revendications</a></li>
            <li><a href="addrevendication">Ajouter une revendication</a></li>
          </ul>
        </li>
        <li class="has-children comments">
          <a href="#0">News</a>

          <ul>
            <li><a href="list_news">Toutes les news</a></li>
            <li><a href="nouvelle_news">Ajouter une news</a></li>
            <li><a href="editnews">Edit mes news</a></li>
          </ul>
        </li>
        <li class="has-children comments">
          <a href="/articles/" data-no-instant>Journal</a>
        </li>
        <li class="has-children comments">
          <a href="musique.php">Musique</a>
        </li>
        <li class="has-children users">
          <a href="#0">Besoin d'équipements</a>

          <ul>
            <li><a href="commande" data-no-instant>Passer commande</a></li>
            <li><a href="vcommande" data-no-instant>Voir ses commandes</a></li>
            <?php if(isset($_SESSION['id']) AND $_SESSION['grade'] == 'Agent Representant') { ?>
            <li><a href="gcommande" data-no-instant>Gerer les commandes</a></li>
            <?php }?>
            <?php if(isset($_SESSION['id']) AND $_SESSION['grade'] == 'Agent Divisionnaire') { ?>
            <li><a href="gcommande" data-no-instant>Gerer les commandes</a></li>
            <?php }?>
          </ul>
        </li>
      </ul>

      <ul>
        <li class="cd-label">Administration</li>

        <li class="has-children users">
          <a href="#0">Membres</a>

          <ul>
            <li><a href="membres.php">Tout les membres</a></li>
            <?php if(isset($_SESSION['id']) AND $_SESSION['grade'] == 'Agent Representant') { ?>
            <li><a href="editmembres.php">Editer les membres</a></li>
            <?php }?>

          </ul>
        </li>
        <?php if(isset($_SESSION['id']) AND $_SESSION['grade'] == 'Agent Representant') { ?>
        <li class="has-children users">
          <a href="#0">Journal</a>

          <ul>
            <li><a href="addnews">Ajouter un article</a></li>
            <li><a href="editn">Editer les articles</a></li>


          </ul>
        </li>
        <?php }?>
    </nav>


    <script src="js/instantclick.min.js" data-no-instant></script>
    <script data-no-instant>InstantClick.init();</script>
    <?php } ?>

		<div class="content-wrapper">
      <h1>Musique</h1>

      <div class="container">
        <div id="accordion" class="panel-group">
           <div class="panel panel-default">
              <div class="panel-heading">
                 <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Ajouter une musique</a>
                 </h4>
              </div>
              <div id="collapse2" class="panel-collapse collapse">
                 <div class="panel-body">
                   <div class="col-md-12">
                       <div class="panel panel-default">
                          <div class="panel-body">
                                     <form method="post" enctype="multipart/form-data" >
                                       <div class="form-group">
                                          <label class="col-lg-3 control-label">Titre</label>
                                          <div class="col-lg-4">
                                             <input name="titre" type="text" class="form-control">
                                          </div>
                                       </div></br></br></br>

                                       <div class="form-group">
                                          <label class="col-lg-3 control-label">Auteur</label>
                                          <div class="col-lg-4">
                                             <input name="auteur" type="text" class="form-control">
                                          </div>
                                       </div></br></br></br>
                                       <input name="date_p" type="hidden" value="<?php
                                      $date = date("d-m-Y");
                                      echo"$date";
                                      ?> ">
                                      <div class="form-group">
                                      <label class="col-lg-3 control-label">Musique</label>
                                       <input type="hidden" name="pseudo" value="<?= $_SESSION['surnom']; ?>" />

                                      <div class="col-lg-4">
                                        <input type="file" name="fichier" size="300">
                                      </div>
                                    </div></br></br>
                                      <div class="form-group">
                                      <label class="col-lg-3 control-label">Couverture musique</label>

                                      <div class="col-lg-4">
                                        <input type="file" name="fichier1" size="300">
                                      </div>
                                    </div></br></br>

                                        <input type="submit" name="upload" value="Uploader">


                                     </form>
                         </div>
                       </div>
                     </div>
                 </div>
              </div>
           </div>
        </div>

              <div id="player4" class="aplayer"></div>
      </div>
  </div>
	</main>
  <script>
  var ap4 = new APlayer({
      element: document.getElementById('player4'),
      narrow: false,
      autoplay: false,
      showlrc: false,
      mutex: true,
      theme: '#e66717',
      mode: 'order',
      music: [
        <?php
        $rmusique = $bdd->query('SELECT * FROM musique');
        foreach($rmusique as $rmusique)
        {
        echo "{

              title: '".$rmusique['titre']."',
              author: '".$rmusique['auteur']."',
              url: 'https://la-division-france.eu/music/".$rmusique['url']."',
              pic: 'https://la-division-france.eu/music/img/".$rmusique['photo']."'
          },";
        }
        ?>
      ]
  });
  </script>
<script src="js/jquery-2.1.4.js"></script>
<script src="js/jquery.menu-aim.js"></script>
<script src="js/main.js"></script>
<script src="js/bootstrap.min.js" ></script>
</body>
</html>
