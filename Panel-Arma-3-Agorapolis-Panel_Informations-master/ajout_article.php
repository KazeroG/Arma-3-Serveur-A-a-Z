<?php
// Création du panier si n'existe pas dans la session de l'utilisateur
session_start();
if (! isset($_SESSION['panier']))  $_SESSION['panier'] = array();

// Voici les données externes utilisées par le panier
$id_article   = isset($_GET['id_article'])   ? $_GET['id_article']   : null;
$nom_article  = isset($_GET['nom_article'])  ? $_GET['nom_article']  : null;
$prix_article = isset($_GET['prix_article']) ? $_GET['prix_article'] : '?';
$qte_article  = isset($_GET['qte_article'])  ? $_GET['qte_article']  : 1;

// Voici les traitements du panier
if ($id_article == null) echo 'Veuillez sélectionner un article pour le mettre dans le panier!'; // Message si pas d'acticle sélectionné
else
if (isset($_GET['ajouter'])){ // Ajouter un nouvel article
  $_SESSION['panier'][$id_article]['nom']  = $nom_article;
  $_SESSION['panier'][$id_article]['prix'] = $prix_article;
  $_SESSION['panier'][$id_article]['qte']  = $qte_article;
}
else if (isset($_GET['modifier']))  $_SESSION['panier'][$id_article]['qte'] = $qte_article; // Modifier la quantité achetée
else if (isset($_GET['supprimer']))  unset($_SESSION['panier'][$id_article]); // Supprimer un article du panier

// Voici l'affichage du panier
echo '<h2>Contenu de votre panier</h2><ul>';
if (isset($_SESSION['panier']) && count($_SESSION['panier'])>0){
  $total_panier = 0;
  foreach($_SESSION['panier'] as $id_article=>$article_acheté){
    // On affiche chaque ligne du panier : nom, prix et quantité modifiable + 2 boutons : modifier la qté et supprimer l'article
    if (isset($article_acheté['nom']) && isset($article_acheté['prix']) && isset($article_acheté['qte'])){
      echo '<li><form>', $article_acheté['nom'], ' (', number_format($article_acheté['prix'], 2, ',', ' '), ' €) ',
       '<input type="hidden" name="id_article" value="', $id_article , '" />
        <br />Qté: <input type="text" name="qte_article" value="', $article_acheté['qte'] , '" />
        <input type="submit" name="modifier" value="Nouvelle Qté" />
        <input type="submit" name="supprimer" value="Supprimer" />
      </form>
      </li>';

      // Calcule le prix total du panier
      $total_panier += $article_acheté['prix'] * $article_acheté['qte'];
    }
  }
  echo '<hr><h3>Total: ', number_format($total_panier, 2, ',', ' '), ' €'; // Affiche le total du panier
}
else { echo 'Votre panier est vide'; } // Message si le panier est vide
echo "</ul>";
?>
