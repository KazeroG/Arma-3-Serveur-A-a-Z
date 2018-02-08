<?php if ($_SESSION['grade'] == 'Harsh') { ?>


  <nav class="cd-side-nav" id="menu">
    <ul>
      <li class="cd-label">Principal</li>
      <li class="has-children comments">
        <a href="#0">Rencontres</a>

        <ul>
          <li><a href="rencontre.php">Listes des rencontres</a></li>
        </ul>
      </li>
      <li class="has-children comments">
        <a href="harsh.php">Harsh</a>
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



<nav class="cd-side-nav" id="menu">
  <ul>
    <li class="cd-label">Principal</li>
    <li class="has-children overview">
      <a href="accueil.php">Vue complète<i class="fa fa-globe" aria-hidden="true" style="padding-left:56px"></i></a>
    </li>
    <li class="has-children comments">
      <a href="#0">Rencontres<i class="fa fa-address-book-o" aria-hidden="true" style="padding-left:70px"></i></a>

      <ul>
        <li><a href="addrencontre.php">Ajouter une personne</a></li>
        <li><a href="rencontre.php">Listes des rencontres</a></li>
        <li><a href="editrencontre.php">Editer mes rencontres</a></li>
      </ul>
    </li>
    <li class="has-children comments">
      <a href="#0">Stockage<i class="fa fa-home" style="padding-left:83px"></i></a>
      <ul>
        <li><a href="addstockage.php">Ajouter un lieu de stockage</a></li>
        <li><a href="stockage.php">Listes des stockages</a></li>
        <li><a href="editstockage.php">Editer mes stockages</a></li>
      </ul>
    </li>
    <li class="has-children comments">
      <a href="chatbox.php">Shoutbox<i class="fa fa-comments-o" style="padding-left:80px"></i></a>
    </li>
    <li class="has-children comments">
      <a href="harsh.php">Harsh<i class="fa fa-handshake-o" aria-hidden="true" style="padding-left:97px"></i></a>
    </li>
    <li class="has-children comments">
      <a href="itineraire.php">Itinéraires<i class="fa fa-car" style="padding-left:75px"></i></a>
    </li>
    <li class="has-children comments">
      <a href="#0">Revendication<i class="fa fa-file-text" aria-hidden="true" style="padding-left:54px"></i></a>
      <ul>
        <li><a href="revendication.php">Toutes les revendications</a></li>
        <li><a href="addrevendication.php">Ajouter une revendication</a></li>
      </ul>
    </li>
    <li class="has-children comments">
      <a href="#0">News<i class="fa fa-file-text-o" aria-hidden="true" style="padding-left:102px"></i></a>

      <ul>
        <li><a href="list_news.php">Toutes les news</a></li>
        <li><a href="nouvelle_news.php">Ajouter une news</a></li>
        <li><a href="editnews.php">Edit mes news</a></li>
      </ul>
    </li>
    <li class="has-children comments">
      <a href="/division/articles/" data-no-instant>Journal<i class="fa fa-newspaper-o" aria-hidden="true" style="padding-left:91px"></i></a>
    </li>
    <li class="has-children comments">
      <a href="musique.php">Musique<i class="fa fa-music" aria-hidden="true" style="padding-left:83px"></i></a>
    </li>
    <li class="has-children users">
      <a href="#0">Besoin d'équipements<i class="fa fa-crosshairs" aria-hidden="true" style="padding-left:7px"></i></a>

      <ul>
        <li><a href="commande.php" data-no-instant>Passer commande</a></li>
        <li><a href="vcommande.php" data-no-instant>Voir ses commandes</a></li>
        <?php if(isset($_SESSION['id']) AND $_SESSION['grade'] == 'Agent Representant') { ?>
        <li><a href="gcommande.php" data-no-instant>Gerer les commandes</a></li>
        <?php }?>
        <?php if(isset($_SESSION['id']) AND $_SESSION['grade'] == 'Agent Divisionnaire') { ?>
        <li><a href="gcommande.php" data-no-instant>Gerer les commandes</a></li>
        <?php }?>
      </ul>
    </li>
  </ul>

  <ul>
    <li class="cd-label">Administration</li>

    <li class="has-children users">
      <a href="#0">Membres<i class="fa fa-users" aria-hidden="true" style="padding-left:77px"></i></a>

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
        <li><a href="addnews.php">Ajouter un article</a></li>
        <li><a href="editn.php">Editer les articles</a></li>


      </ul>
    </li>
    <?php }?>

  </ul></br></br></br>
</nav>


<script src="js/instantclick.min.js" data-no-instant></script>
<script data-no-instant>InstantClick.init();</script>
<?php } ?>
