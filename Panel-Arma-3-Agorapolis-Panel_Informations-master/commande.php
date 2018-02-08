<?php
session_start();
include_once("panier/config.php");
include 'config.php';
if ($_SESSION['grade'] == 'Inconnu'){ // ah non, pas eux !!!
  header('Location: exit.php'); // pas d'intrus sur cette photo
} elseif(!isset($_SESSION['id'])){
  header('Location: index.php');
}
if ($_SESSION['grade'] == 'Harsh'){
	header('Location: index.php');
}
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
  <script src="https://use.fontawesome.com/158774fdb7.js"></script>
	<link rel="stylesheet" href="../css/reset.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link href="panier/style/style1.css" rel="stylesheet" type="text/css">
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
<div class="content-wrapper">
<h1 align="center">Products </h1>

<!-- View Cart Box Start -->
<?php
if(isset($_SESSION["cart_products"]) && count($_SESSION["cart_products"])>0)
{
	echo '<div class="cart-view-table-front" id="view-cart">';
	echo '<h3>Votre panier</h3>';
	echo '<form method="post" action="cart_update.php">';
	echo '<table width="100%"  cellpadding="6" cellspacing="0">';
	echo '<tbody>';

	$total =0;
	$b = 0;
	foreach ($_SESSION["cart_products"] as $cart_itm)
	{
		$product_name = $cart_itm["product_name"];
		$product_qty = $cart_itm["product_qty"];
		$product_price = $cart_itm["product_price"];
		$product_code = $cart_itm["product_code"];
		$product_color = $cart_itm["product_color"];
		$bg_color = ($b++%2==1) ? 'odd' : 'even'; //zebra stripe
		echo '<tr class="'.$bg_color.'">';
		echo '<td>Quantité&nbsp;&nbsp;<a style="color:darkorange">'.$product_qty.'</a></td>';
		echo '<td>'.$product_name.'</td>';
		echo '<td><input type="checkbox" name="remove_code[]" value="'.$product_code.'" /> Supprimer</td>';
		echo '</tr>';
		$subtotal = ($product_price * $product_qty);
		$total = ($total + $subtotal);
	}
	echo '<td colspan="4">';
	echo '<button class="btn btn-danger" type="submit">Mettre à jour</button><a href="resume_commande.php" class="btn btn-danger button">Caisse</a>';
	echo '</td>';
	echo '</tbody>';
	echo '</table>';

	$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	echo '<input type="hidden" name="return_url" value="'.$current_url.'" />';
	echo '</form>';
	echo '</div>';

}
?>
<!-- View Cart Box End -->


<!-- Products List Start -->
<?php
$results = $mysqli->query("SELECT product_code, product_name, product_desc, product_img_name, price FROM products ORDER BY id ASC");
if($results){
$products_item = '<ul class="products">';
//fetch results set as object and output HTML
while($obj = $results->fetch_object())
{
$prix = number_format($obj->price, 0, ',', ' ');
$products_item .= <<<EOT
	<li class="product">
	<form method="post" action="cart_update.php">
	<div class="product-content"><h3>{$obj->product_name}</h3>
	<div class="product-thumb"><img style="border-radius:5%;width:180px;"src="panier/images/{$obj->product_img_name}"></div>
	</br></br>
	<div class="product-info">
	Prix $prix {$currency}

	<fieldset>

	<label>
		<span>Quantité</span>
		<input type="number" size="2" maxlength="2" name="product_qty" class="form-control" value="1" />
	</label>

	</fieldset>
	<input type="hidden" name="product_code" value="{$obj->product_code}" />
	<input type="hidden" name="type" value="add" />
	<input type="hidden" name="return_url" value="{$current_url}" />
	<div align="center"><button type="submit" class="btn btn-danger add_to_cart">Commander</button></div>
	</div></div>
	</form>
	</li>
EOT;
}
$products_item .= '</ul>';
echo $products_item;
}
?>
</div>
<!-- Products List End -->
<script src="../js/jquery-2.1.4.js"></script>
<script src="../js/jquery.menu-aim.js"></script>
<script src="../js/main.js"></script> <!-- Resource jQuery -->
<script src="../js/bootstrap.min.js" ></script>
</body>
</html>
