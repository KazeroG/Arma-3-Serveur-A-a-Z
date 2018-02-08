<?php
	require "config.php";
	if(!empty($_SESSION['pseudo']))
	{
			header("Location: accueil.php");
	}

  if(isset($_POST['submit']))
	{
		if(!empty($_POST['pseudo']) && !empty($_POST['password']))
		{
			$pseudo = htmlspecialchars(trim($_POST['pseudo']));
			$password = md5(sha1($_POST['password']));
			$vUsers = $bdd->prepare("SELECT * FROM users WHERE pseudo = ? AND password = ?");
      $vUsers->execute(array($pseudo, $password));
			session_set_cookie_params('1814400'); // 10 minutes.
			session_regenerate_id(true);
			ini_set('session.gc_maxlifetime', 3600*24*21);
      setcookie('pseudo',$pseudo,time() + 3600*24*21, null, null, true, true);
      setcookie('password',$password,time() + 3600*24*21, null, null, true, true);
			$rUsers = $vUsers->rowCount();
			if($rUsers == 1)
			{
				$info = $vUsers->fetch();
				$_SESSION['id'] = $info['id'];
				$_SESSION['email'] = $info['email'];
				$_SESSION['pseudo'] = $info['pseudo'];
				$_SESSION['avatar'] = $info['avatar'];
				$_SESSION['grade'] = $info['grade'];
				header('Location: accueil.php');
			}
			else
			{
				$erreur = "Mauvaise combinaison pseudo / mot de passe";
			}
		}

	}

	if(isset($_POST['submit1']))
	{
		if(!empty($_POST['mail']) && !empty($_POST['pseudo']) && !empty($_POST['password']))
		{
			$email = htmlspecialchars(trim($_POST['mail']));
			$pseudo = htmlspecialchars(trim($_POST['pseudo']));
			$password = md5(sha1($_POST['password']));

				if(filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					$tPseudo = strlen($pseudo);
					if($tPseudo <= 20)
					{
						$vEmail = $bdd->prepare('SELECT * FROM users WHERE email = ?');
						$vEmail->execute(array($email));
						$rEmail = $vEmail->rowCount();
						if($rEmail == 0)
						{
							$vPseudo = $bdd->prepare('SELECT * FROM users WHERE pseudo = ?');
							$vPseudo->execute(array($pseudo));
							$rPseudo = $vPseudo->rowCount();
							if($rPseudo == 0)
							{
								$iUsers = $bdd->prepare('INSERT INTO users(email, pseudo, password, grade, surnom, telephone, avatar, surnom2) VALUES(?, ?, ?, ?, ?, ?, ?, ?)');
								$iUsers->execute(array($email, $pseudo, $password, "Inconnu", "Non renseigné", "Non renseigné", "Agent.png", "Non renseigné"));
              	$_SESSION['inscrit'] = '</br></br></br><i class="fa fa-exclamation-triangle"></i> Vous pouvez dès maintenant vous connecter ! <i class="fa fa-exclamation-triangle"></i>';
								header('Location: index.php');
							}
							else
							{
								$erreur = "Le pseudo est déjà prit par un autre membre, c'est peut-être vous ?";
							}
						}
						else
						{
							$erreur = "L'email est déjà prit par un autre membre, c'est peut-être vous ?";
						}
					}
					else
					{
						$erreur = "Le pseudo ne doit pas dépasser les 20 caractères !";
					}
				}
				else
				{
					$erreur = "L'e-mail n'est pas valide !";
				}
			}
		else
		{
			$erreur = "Tout les champs doivent être complétés !";
		}
	}
?>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
		<meta name="name" content="content">
    <title>La Division | <?php $page= substr(
         $_SERVER["PHP_SELF"],
         strrpos($_SERVER["PHP_SELF"], '/')+1,
         strrpos($_SERVER["PHP_SELF"],'.')-1

    ); echo $page;?></title>
    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Montserrat:400,700'>
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="css/login.css">
		<meta name="description" content="Site officiel de la Division Agorapolis, groupement paramilitaire lutant contre les rebelles ainsi que le LPA, connexion requise seule les agents sont autorisés à s'y connecter.">
		<link rel="stylesheet" href="spinner/css/style.css">
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		<link rel="icon" href="/favicon.ico" type="image/x-icon">
		<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120-precomposed.png" />
		<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152-precomposed.png" />
		<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-87710084-1', 'auto');
  ga('send', 'pageview');

</script>

  </head>
  <body class="bg-home">
		<div class="container">
      <div class="info">
      </div>
    </div>
        <div class="form">
          <div class="thumbnail">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="200" height="200" viewbox="0 0 250 250" class="dv-loader">
						  <defs>
						    <mask id="trinityMask">
						      <rect width="100%" height="100%" fill="white"></rect>
						      <polygon points="125, 125, 133,250, 117,250"></polygon>
						      <polygon points="125, 125, 133,250, 117,250" class="rotate120"></polygon>
						      <polygon points="125, 125, 133,250, 117,250" class="rotate-120"></polygon>
						    </mask>
						    <mask id="linesMask">
						      <rect width="100%" height="100%" fill="white"></rect>
						      <line x1="125" y1="0" x2="125" y2="250" stroke="black" stroke-width=".5"></line>
						      <line x1="125" y1="0" x2="125" y2="250" stroke="black" stroke-width=".5" class="rotate120 center-origin"></line>
						      <line x1="125" y1="0" x2="125" y2="250" stroke="black" stroke-width=".5" class="rotate-120 center-origin">     </line>
						    </mask>
						  </defs>
						  <circle cx="50%" cy="50%" r="100" stroke-width=".5" class="ring-outer"></circle>
						  <g class="triangles">
						    <polygon points="125,123 123,126 127,126" class="triangle"></polygon>
						    <polygon points="125,123 123,126 127,126" class="triangle rotate90"></polygon>
						    <polygon points="125,123 123,126 127,126" class="triangle rotate-90"></polygon>
						    <polygon points="125,123 123,126 127,126" class="triangle rotate180"></polygon>
						  </g>
						  <g class="group-teeth">
						    <circle cx="50%" cy="50%" r="87" stroke-width=".5" class="ring-teeth"></circle>
						    <path d="M 125,38 a 1,1 0 0 0 0,174" class="ring-teeth-edge"></path>
						    <g class="group-line">
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(0deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(2.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(7.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(10deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(12.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(15deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(17.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(20deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(22.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(25deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(27.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(30deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(32.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(35deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(37.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(40deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(42.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(45deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(47.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(50deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(52.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(55deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(57.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(60deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(62.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(65deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(67.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(70deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(72.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(75deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(77.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(80deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(82.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(85deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(87.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(90deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(92.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(95deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(97.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(100deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(102.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(105deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(107.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(110deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(112.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(115deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(117.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(120deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(122.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(125deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(127.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(130deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(132.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(135deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(137.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(140deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(142.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(145deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(147.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(150deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(152.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(155deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(157.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(160deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(162.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(165deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(167.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(170deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(172.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(175deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(177.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(180deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(182.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(185deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(187.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(190deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(192.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(195deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(197.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(200deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(202.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(205deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(207.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(210deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(212.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(215deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(217.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(220deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(222.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(225deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(227.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(230deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(232.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(235deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(237.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(240deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(242.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(245deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(247.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(250deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(252.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(255deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(257.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(260deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(262.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(265deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(267.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(270deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(272.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(275deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(277.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(280deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(282.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(285deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(287.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(290deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(292.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(295deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(297.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(300deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(302.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(305deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(307.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(310deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(312.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(315deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(317.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(320deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(322.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(325deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(327.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(330deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(332.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(335deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(337.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(340deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(342.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(345deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(347.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(350deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(352.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(355deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(357.5deg) translate(0, -88px)" class="tooth"></line>
						      <line x1="125" y1="125" x2="125" y2="122" style="transform: rotate(0deg) translate(0, -88px)" class="tooth tooth-ticker"></line>
						    </g>
						  </g>
						  <g class="white-lines">
						    <path d="M122 126.5 L122 123.5 L128 123.5" class="white-line"></path>
						    <path d="M122 126.5 L122 123.5 L128 123.5" class="white-line alt"></path>
						    <path d="M122 126.5 L122 123.5 L128 123.5" class="white-line"></path>
						    <path d="M122 126.5 L122 123.5 L128 123.5" class="white-line alt"></path>
						  </g>
						  <g mask="url(#trinityMask)" class="group-middle-ring">
						    <circle cx="50%" cy="50%" r="66" stroke-width="10" class="ring-middle"></circle>
						  </g>
						  <g class="groupTravelingLine">
						    <rect width="100%" height="100%" fill="none"></rect>
						    <path id="travelingLine" class="travelingLine"></path>
						  </g>
						  <g mask="url(#trinityMask)" class="group-inner-ring">
						    <circle cx="50%" cy="50%" r="43" stroke-width="10" class="ring-inner"></circle>
						    <circle cx="50%" cy="50%" r="49" stroke-width="1" class="ring-inner-frame"></circle>
						    <circle cx="50%" cy="50%" r="37" stroke-width="1" class="ring-inner-frame"></circle>
						  </g>
						  <g class="group-inner-animation">
						    <path id="fatAnimatedPie" fill="none" stroke-width="10" class="ring-inner-animation"></path>
						    <path id="thinAnimatedPie" fill="none" stroke-width="2" mask="url(#linesMask)" class="ring-inner-animation-thin"></path>
						  </g>
						  <g class="group-innermost-ring">
						    <circle cx="50%" cy="50%" r="31" stroke-width=".5" class="ring-inner-frame"></circle>
						    <path id="ringInner1" class="ring-inner-part"></path>
						    <path id="ringInner2" class="ring-inner-part"></path>
						    <path id="ringInner3" class="ring-inner-part"></path>
						    <path id="ringInner4" class="ring-inner-part"></path>
						  </g>
						  <g mask="url(#linesMask)" width="100%" height="100%" class="group-eye">
						    <rect width="100%" height="100%" fill="none"></rect>
						    <circle cx="50%" cy="50%" class="ring-eye-thick"></circle>
						    <circle cx="50%" cy="50%" class="ring-eye-thin"></circle>
						  </g>
						  <g id="groupPixels" class="group-pixels">
						    <path id="pixel1" class="pixel"></path>
						    <path id="pixel2" class="pixel active"></path>
						    <path id="pixel3" class="pixel"></path>
						    <path id="pixel4" class="pixel"></path>
						    <path id="pixel5" class="pixel"></path>
						    <path id="pixel6" class="pixel"></path>
						  </g>
						</svg>

          </div>
          <form class="register-form row" method="POST">
            <input type="text" name="pseudo" placeholder="Nom d'utilisateur"/>
            <input type="password" name="password" placeholder="Mot de passe"/>
            <input type="text" name="mail" placeholder="Adresse e-mail"/>
            <button name="submit1">INSCRIPTION</button>
						<?php if(isset($erreur)) { ?><p><font color="orange"><i class="fa fa-exclamation-circle"></i> <?= $erreur; ?></p></font><?php } ?><p class="message">Déjà inscrit ? <a href="#">Connecter vous</a></p>
          </form>
          <form class="login-form row" method="POST">
            <input type="text" name="pseudo" placeholder="Nom d'utilisateur"/>
            <input type="password" name="password" placeholder="Mot de passe"/>
            <button name="submit">CONNEXION</button><h1></h1>
            <p class="message">S'inscrire ? <a href="#">Créer un compte</a></p>
						<?php if(isset($erreur)) { ?><p><font color="orange"><i class="fa fa-exclamation-circle"></i> <?= $erreur; ?></p></font><?php } ?>
						<?php
						if(isset($_SESSION['not_logged_message'])){
							echo $_SESSION['not_logged_message'];
						unset($_SESSION['not_logged_message']);
						}
						?>
          </form>
        </div>
        <script src='js/jquery-3.1.1.min.js'></script>
        <script src="js/login.js"></script>
				<script src="spinner/js/index.js"></script>
				<script src="//fast.eager.io/aMe7Oazo1G.js"></script>
  </body>
</html>
