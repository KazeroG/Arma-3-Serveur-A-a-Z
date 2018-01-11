<?php
$url = "http://admin.altisfrance.fr";
if(isset($_GET['error']) and $_GET['error']!='') $error = $_GET['error'];
?>
<style>
    p {
        font-size: 14px !important;
    }
    .form-label{
        font-size: 1.1em;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 5px;
        font-weight: 700;
    }
    .cgv-label{
        float: left;
        line-height: 30px;
        font-size: 1.2em;
        margin-right: 10px;
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
            <h2 class="text-center uppercase">DONATION</h2>
            <hr class="primary">
            <p>Bienvenue sur la page de donations AltisFrance. Si vous êtes ici c'est que vous considérez aider l'expention du serveur, et pour
            ça nous vous sommes infiniement reconnaissants. Vous faites partis des personnes qui font vivre le serveur en nous aidant dans son
            financement et vous pouvez être fier d'être "actionnaires" d'AltisFrance. En échange de vos donations vous accèderez à des avantages
            en jeu ainsi qu'un status spécial dans la communauté. Les donations se font par Paypal, si vous voulez faire un donation autrement
            veuillez passer par un Admin, de même si vous désirez donner plus que le montant max du formulaire ci dessous<br>
            Toutes vos donations faites à AltisFrance sont déclarées et uniquement utilisée pour le développement du serveur.</p>

            <?php if(isset($error)){
                echo "<p class=\"error p-20\">Erreur : $error</p>";
            } ?>
            <p class="warning p-20">
                ATTENTION : une fois la donation effectué vous devez <b>impérativement cliquer sur le bouton 'Retour sur AltisFrance'</b>
                , qui vous mènera vers un formulaire où vous pourrez rentrer votre ID ARMA3 (suite de
                chiffres commençant par 7 qui se trouve dans votre Profil). Sans celà votre donation ne sera pas faite automatiquement et vous devre
                soliciter un admin.
            </p>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-12 col-sm-offset-0 text-justify">
            <div class="minimalist p-30 mb-20">
                <form id="form" action="https://www.paypal.com/cgi-bin/webscr" method="post" class="payPalForm">
                    <div>
                        <input type="hidden" name="cmd" value="_xclick" />
                        <input type="hidden" name="item_name" value="Donation AltisFrance" />

                        <!-- Your PayPal email: -->
                        <input type="hidden" name="business"
                               value="donations@altisfrance.Fr"/>

                        <!-- PayPal will send an IPN notification to this URL: -->
                        <input type="hidden" name="notify_url"
                               value="<?php echo $url.'/ipn.php'?>" />

                        <!-- The return page to which the user is
                        navigated after the donations is complete: -->

                        <input type="hidden" name="return"
                               value="<?php echo $url.'/thankyou.php'?>" />

                        <!-- Signifies that the transaction data will be
                        passed to the return page by POST: -->

                        <input type="hidden" name="rm" value="2" />

                        <!-- General configuration variables for the paypal landing page. -->

                        <input type="hidden" name="no_note" value="0" />
                        <input type="hidden" name="tax_rate" value="10" />
                        <input type="hidden" name="cbt" value="Retour sur AltisFrance" />
                        <input type="hidden" name="no_shipping" value="1" />
                        <input type="hidden" name="lc" value="FR" />
                        <input type="hidden" name="currency_code" value="EUR" />

                        <!-- The amount of the transaction: -->

                        <label class="p-0" for="files">Montant de votre donation</label>
                        <select name="amount">
                            <option value="5" selected>5€ HT : 30 jours</option>
                            <option value="10">10€ HT : 70 jours</option>
                            <option value="15">15€ HT : 110 jours</option>
                            <option value="20">20€ HT : 150 jours</option>
                            <option value="30">30€ HT : 230 jours</option>
                        </select>

                        <input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHostedGuest" />

                        <p class="mt-20"><span class="cgv-label">En validant votre donation vous acceptez nos
                                <a target="_blank" href="http://altisfrance.fr/CGV.pdf">CGV</a></span></p>

                        <!-- You can change the image of the button: -->
                        <input class="submit width-full mt-40" id="submit" type="submit" name="submit" value="ENVOYER DONATION" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="spacer-100"></div>