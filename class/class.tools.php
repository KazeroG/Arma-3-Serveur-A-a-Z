<?php

class Tools
{

    // IS PLAYERID REAL
    public static function formatPlayerid($playerid){
        if(is_numeric($playerid) && strlen($playerid)==17 && $playerid[0]=="7"){
            return true;
        }else{
            return false;
        }
    }

    // LICENSES TO ARRAY
    public static function decodeLicenses($string){
        $suppr = array("\"", "`", "[", "]");
        $lineLicenses = str_replace($suppr, "", $string);
        $arrayLicenses = preg_split("/,/", $lineLicenses);
        return $arrayLicenses;
    }

    // UPDATE SINGLE LICENSE
    public static function updateLicense($id,$status,$playerid,$side=null){

        $player = Player::byPlayerid($playerid);
        if(!isset($player)) return false;

        switch($side){
            case 'cop':
                $arrayLicenses = $player->cop_licenses;
                break;
            case 'med':
                $arrayLicenses = $player->med_licenses;
                break;
            default :
                $arrayLicenses = $player->civ_licenses;
        }
        $arrayLicenses = Tools::decodeLicenses($arrayLicenses);

        // On inverse le choix à modifier
        if($status == 0){
            $status = $status + 1;
        }else{
            $status = $status - 1;
        }

        $totarrayLicenses = count($arrayLicenses);
        $y=0;
        $n=0;

        $fdp_arma = '';

        // test
        for($i=1; $y < $totarrayLicenses; $i++){
            // Reconstruction du contenu de civ_licenses pour Arma

            // Début
            if($n == $id && $y == 0){
                $fdp_arma .= "\"[[`".$arrayLicenses[$y]."`,".$status."],";
            }elseif($n == 0 && $id !== $n){
                $fdp_arma .= "\"[[`".$arrayLicenses[$y]."`,".$arrayLicenses[$i]."],";
            }

            // Millieux
            if($n == $id && $n !== 0 && $y !== ($totarrayLicenses-2)){
                $fdp_arma .= "[`".$arrayLicenses[$y]."`,".$status."],";
            }elseif($n !== $id && $y !== 0 && $y !== ($totarrayLicenses-2)){
                $fdp_arma .= "[`".$arrayLicenses[$y]."`,".$arrayLicenses[$i]."],";
            }

            // Fin
            if($n == $id && $y == ($totarrayLicenses-2)){
                $fdp_arma .= "[`".$arrayLicenses[$y]."`,".$status."]]\"";
            }elseif($n !== $id && $y == ($totarrayLicenses-2)){
                $fdp_arma .= "[`".$arrayLicenses[$y]."`,".$arrayLicenses[$i]."]]\"";
            }

            // Pair
            $y=$y+2;
            // Impair
            $i=$i+1;
            // Normal
            $n=$n+1;
        }

        // transformation de l'array en chaîne
        $civ_licenses = $fdp_arma;
        switch($side){
            case 'cop':
                $player->cop_licenses = $civ_licenses;
                break;
            case 'med':
                $player->med_licenses = $civ_licenses;
                break;
            default :
                $player->civ_licenses = $civ_licenses;
        }
        $player->update();
        return true;
    }

    // DISPLAY ERROR BAR

    public static function displayError($message){
        $error = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Error : '.$message.'</div>';
        return $error;
    }

    public static function displayWarning($message){
        $error = '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Warning : '.$message.'</div>';
        return $error;
    }

    public static function displaySuccess($message){
        $error = '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Success : '.$message.'</div>';
        return $error;
    }


    // SEND MAIL BY SMTP
    public static function sendMail($objet, $message, $to, $filePath=null, $fileName=null, $ics = null){
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->Host = SMTP_HOST;
        $mail->Port = SMTP_PORT; // Par défaut
        $mail->SMTPAuth   = false;
//        $mail->Username   = SMTP_USER; // SMTP account username
//        $mail->Password   = SMTP_PASSWORD;        // SMTP account password

        $mail->SetFrom('contact@altisfrance.fr', 'AltisFrance');
        $mail->AddAddress($to);
        $mail->Subject = $objet;
        $mail->MsgHTML($message);
        if ($fileName && $filePath) {
            $mail->AddAttachment($filePath, $fileName);
        }
        if($ics){
            $mail->Ical = $ics->render(false);
        }

        // Envoi du mail avec gestion des erreurs
        if(!@$mail->Send()) {
            return 'Erreur : ' . $mail->ErrorInfo;
        }else{
            return 1;
        }
    }

    // ALGORYTHM SPONSORING REWARDS
    public static function algoAddSponsor(Player $player,Player $sponsor){
        $player->sponsor = $sponsor->playerid;
        $count = $sponsor->countSponsored();
        $count += 1;
        $player->bankacc += GODSON_REWARD;
        $sponsor->bankacc += GODFATHER_REWARD;

        switch ($count) {
            case 3:
                $sponsor->bankacc += 100000;
                break;
            case 5:
                $sponsor->bankacc += 500000;
                break;
            case 10:
                Notification::newSponsorCeilingNotif(10,$sponsor->playerid)->sendAdmins();
                break;
            case 15:
                Notification::newSponsorCeilingNotif(15,$sponsor->playerid)->sendAdmins();
                break;
            case 20:
                Notification::newSponsorCeilingNotif(20,$sponsor->playerid)->sendAdmins();
                break;
            case 30:
                Notification::newSponsorCeilingNotif(30,$sponsor->playerid)->sendAdmins();
                break;
            default:
                //
        }

        $player->update();
        $sponsor->update();
    }

    // DISPLAY TIMELAPSE
    public static function timeLapse($datetime){
        $now = time();
        $then = strtotime($datetime);
        $diff = $now-$then;

        if($diff >= 24*3600) $return = "Il y a ".round($diff/(24*3600))." jours";
        if($diff >= 3600) $return = "Il y a ".round($diff/3600)." h";
        if($diff < 3600) $return = "Il y a ".round($diff/60)." min";
        return $return;
    }

}