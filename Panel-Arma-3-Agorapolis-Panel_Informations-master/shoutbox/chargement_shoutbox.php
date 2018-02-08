	<?php
        include ('../config.php');
        include ('date.php');
		$message = $bdd->query('SELECT * FROM shoutbox ORDER BY id DESC LIMIT 30');
		foreach ($message as $message) {


			if($message['utilisateur'] == "BOT"){ ?>
				<a><img src="<?= $message['avatar']; ?>" style="border-radius:50%;width:20px;height:20px"></a>
			<?php } else {?>

				<a><img src="membres/avatars/<?= $message['avatar']; ?>" style="border-radius:50%;width:20px;height:20px"></a> <?php } ?>

	              <span style="font-size: 11px;">Posté <?= conversion($message['date_p']); ?></span> -

								<?php
								if($message['utilisateur'] == "BOT"){ ?>
								<a style="color:#cf91da"><?= $message['utilisateur']; ?></a> :
								<?php } else {?>

				  			<a><?= $message['utilisateur']; ?></a> :  <?php }
								if($message['message'] == "vient de vider la shoutbox.")
								{
									echo "<a>".$message['message']."</a>";
								}
								else {
									echo $message['message'];
								}
								?>

		          <br><br>
			<?php
		}


	?>
