<?php
session_start();
if(isset($_GET['error']) and $_GET['error']!='') $error = $_GET['error'];

// DEV
//$_SESSION['txn_id'] = "1R749759SN9967927";
//$_SESSION['mc_gross'] = "10";

// PROD
$_SESSION['txn_id'] = $_POST['txn_id'];
$_SESSION['mc_gross'] = $_POST['mc_gross'];
$payment_amount = $_SESSION['mc_gross'];

?>
<style>
    p {
        font-size: 14px !important;
    }
</style>
<div class="spacer-50"></div>
<div class="container">
    <div class="row">
        <a href="http://altisfrance.fr" title="retour au site"><img class="center-block" width="150" src="http://altisfrance.fr/img/logo_af_gold.png"></a>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-12 col-sm-offset-0 text-justify">
            <h2 class="text-center uppercase">MERCI !</h2>
            <hr class="primary">
            <p class="success p-20">
                SUCCÈS : MERCI ! Votre donation de <b><?= $payment_amount ?>€</b> est bien enregistrée ! C'est génial, merci encore d'avoir
                considéré nous aider pour continuer d'administrer le serveur ! Il ne nous manque plus que votre ID ARMA3 pour vous donner accès
                aux avantages donateurs. Renseignez le dans le formulaire ci-dessous pour terminer votre donation.
            </p>
            <p class="warning p-20">
                ATTENTION : <b>Il est impératif que vous soyez déconecté du serveur et que vous rentriez votre ID ARMA3 sans aucune faute</b>. Sans quoi la donation ne sera pas traitée automatiquement et vous devrez passer par un Admin. <br>
                Pour trouver votre ID ARMA3 rendez vous dans votre profil sur le jeu et copier la suite de chiffres commençant par 7.
            </p>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-12 col-sm-offset-0 text-justify">
            <form method="post" action="" class="p-30 minimalist">
                <label class="p-0" for="user">Votre ID Joueur</label>
                <input class="block width-full" type="number" id="playerId" placeholder="ID Joueur" value="" required>
                <input class="submit width-full mt-40" type="submit" id="submit" value="VALIDER">
            </form>
        </div>
    </div>
</div>
<div class="spacer-100"></div>
<script>
    $(document).ready(function(){
        $("#submit").click(function(e){
            e.preventDefault();
            var pId = $("#playerId").val();
            if(pId=="" || isNaN(pId)) {
                swal("Erreur", "Veuillez bien remplir votre ID Joueur !", "error");
            }else{
                $.getJSON("/ajaxqueries.php",{
                    query: "addDonation",
                    pId: pId
                }).done(function(data){
                    console.log(data);
                    if(data['ok']==2) {
                        window.location.replace("http://rickrolled.fr");
                    }else if(data['ok']==1){
                        swal("Nice :)", data['success'], "success");
                        setTimeout(function(){
                            window.location.replace("http://altisfrance.fr");
                        }, 10000);
                    }else{
                        swal("Erreur :(", data['error'], "error");
                    }
                });
            }
        });
    });
</script>