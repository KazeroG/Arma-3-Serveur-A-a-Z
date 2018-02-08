<?php
session_start();
include_once("panier/config.php");
include_once("config.php");
if ($_SESSION['grade'] == 'Inconnu'){ // ah non, pas eux !!!
  header('Location: exit.php'); // pas d'intrus sur cette photo
} elseif(!isset($_SESSION['id'])){
  header('Location: index.php');
}

if ($_SESSION['grade'] == 'Harsh'){
	header('Location: index.php');
}
if (isset($_POST['submit1']))
{
	$commande = $_POST['commande'];
	$date = htmlspecialchars(trim($_POST['date']));
	$pseudo = htmlspecialchars(trim($_POST['pseudo']));
	$etat = htmlspecialchars(trim($_POST['etat']));
  $commentaire = htmlspecialchars(trim($_POST['commentaire']));
	$addcommande = $bdd->prepare('INSERT INTO commande(commande, date, pseudo, etat, commentaire) VALUES(?, ?, ?, ?, ?)');
	$addcommande->execute(array($commande, $date, $pseudo, "En attente", $commentaire));
	header('Location: vcommande.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/bootstrap1.css">
	<link href="panier/style/style.css" rel="stylesheet" type="text/css">
	<script src="../js/modernizr.js"></script>
	<script src="../ckeditor/ckeditor.js"></script>
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
	<link rel="icon" href="../favicon.ico" type="image/x-icon">
	<title>Division</title>

</head>
<body>
	<header class="cd-main-header">
	<a class="cd-logo"><img src="articles/image/logo.png" style="border-radius:5%;width:40px;" alt="Logo"></a>


	<div class="cd-search is-hidden">
		<form>
			<input placeholder="Grade actuel : <?= $_SESSION['grade']; ?>" disabled>
		</form>
	</div>
		<nav class="cd-nav">
			<ul class="cd-top-nav">
				<li><a href="profil">Mon compte</a></li>
				<li><a href="logout">Déconnexion</a></li>
				<li class="has-children account">
					<a>
						<img src="membres/avatars/<?= $_SESSION['avatar']; ?>">
						<?= $_SESSION['pseudo']; ?>
					</a>
				</li>
			</ul>
		</nav>
	</header>
  <?php
  include 'load/navbar.php';
  ?>
  <div class="content-wrapper"></br></br></br></br></br>
<h1 align="center">Recapitulatif de la commande</h1>
<div class="cart-view-table-back">
<form method="post" action="cart_update.php">
<table width="100%"  cellpadding="6" cellspacing="0"><thead><tr><th>Quantité</th><th>Nom</th><th>Prix unitaire</th><th>Total</th><th>Supprimer</th></tr></p></thead>
  <tbody>
 	<?php
	if(isset($_SESSION["cart_products"]))
    {
		$total = 0;
		$b = 0;
		foreach ($_SESSION["cart_products"] as $cart_itm)
        {
			
			$product_name = $cart_itm["product_name"];
			$product_qty = $cart_itm["product_qty"];
			$product_price = $cart_itm["product_price"];
			$product_price1 = number_format($product_price, 0, ',', ' ');
			$product_code = $cart_itm["product_code"];
			$product_color = $cart_itm["product_color"];
			$subtotal = ($product_price * $product_qty);
			$subtotal1 = number_format($subtotal, 0, ',', ' ');
		   $bg_color = ($b++%2==1) ? 'odd' : 'even';
		  echo '<tr class="'.$bg_color.'">';
			echo '<td><input type="number" class="form-control" name="product_qty['.$product_code.']" value="'.$product_qty.'" /></td>';
			echo '<td>'.$product_name.'</td>';
			echo '<td>'.$product_price1.' €</td>';
			echo '<td>'.$subtotal1.' €</td>';
			echo '<td><input type="checkbox" name="remove_code[]" value="'.$product_code.'" /></td>';
      echo '</tr>';
			$total = ($total + $subtotal);
			$grand_total = $total + $shipping_cost;
			$prix = number_format($grand_total, 0, ',', ' ');
        }
		}
    ?>

    <tr><td colspan="5"><span style="float:right;text-align:right;">Total à payer : <?php echo $prix ;?> €</span></td></tr>
    <tr><td colspan="5"><a href="commande.php" class="button1">Editer la commande</a><button type="submit">Actualiser</button></td></tr>
  </tbody>
</table>
<input type="hidden" name="return_url" value="<?php
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
echo $current_url; ?>" /></br>
<b>Si vous avez commandé des chargeurs merci de spécifier dans la case prévue à cette effet les détails pour chaque armes.</b>


</form>

<form method="POST">
<input type="hidden" name="commande" value='

<table width="100%"  cellpadding="6" cellspacing="0"><thead><tr><th>Quantité</th><th>Nom</th><th>Prix unitaire</th><th>Total</th></tr></p></thead>
  <tbody>
 	<?php
	if(isset($_SESSION["cart_products"]))
    {
		$total = 0;
		$b = 0;
		foreach ($_SESSION["cart_products"] as $cart_itm)
        {
			$product_name = $cart_itm["product_name"];
			$product_qty = $cart_itm["product_qty"];
			$product_price = $cart_itm["product_price"];
			$product_price1 = number_format($product_price, 0, ',', ' ');
			$product_code = $cart_itm["product_code"];
			$product_color = $cart_itm["product_color"];
			$subtotal = ($product_price * $product_qty);
			$subtotal1 = number_format($subtotal, 0, ',', ' ');
			$bg_color = ($b++%2==1) ? 'odd' : 'even';

		  echo '<tr class="'.$bg_color.'">';
			echo '<td>'.$product_qty.'</td>';
			echo '<td>'.$product_name.'</td>';
			echo '<td>'.$product_price1.' €</td>';
			echo '<td>'.$subtotal1.' €</td>';
      echo '</tr>';
			$total = ($total + $subtotal);
			$grand_total = $total + $shipping_cost;
        }
		}
    ?>
    <tr><td colspan="5"><span style="float:right;text-align:right;color:orange;font-size:15px"></br>Total à payer : <?php echo $prix ;?> €</span></td></tr>
  </tbody>
</table>
'>
<input name="date" type="hidden" value="<?php
$date = date("d-m-Y");
echo"$date";
?> ">
<input style="width:80%" type="text" class="form-control" name="commentaire" placeholder="Commentaire ( Chargeurs, Autres etc...)" />
<input type="hidden" name="pseudo" value="<?= $_SESSION['pseudo']; ?>" />
<button name="submit1">Passer commande</button>
</form>

</div>
</div>
</body>
</html>
