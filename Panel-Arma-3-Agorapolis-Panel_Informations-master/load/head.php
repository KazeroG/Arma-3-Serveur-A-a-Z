<!doctype html>
<html lang="fr" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
	<script src="https://use.fontawesome.com/158774fdb7.js"></script>
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
	<script src="js/modernizr.js"></script>
	<script src="js/wow.js"></script>
	<script src="ckeditor/ckeditor.js"></script>
	<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120-precomposed.png" />
	<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152-precomposed.png" />
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<script src="../dist/APlayer.min.js"></script>
	<script src="//fast.eager.io/aMe7Oazo1G.js"></script>
	<script>
              new WOW().init();
	</script>

	<title>La Division | <?php $page= substr(
			 $_SERVER["PHP_SELF"],
			 strrpos($_SERVER["PHP_SELF"], '/')+1,
			 strrpos($_SERVER["PHP_SELF"],'.')-1

	); echo $page;?></title>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-87710084-1', 'auto');
  ga('send', 'pageview');

</script>
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
