<?php
function conversion($temps){
    $temps = strtotime($temps);
    $diff_temps = time() - $temps;
    
    if($diff_temps < 1){
        return 'à l\'instant';
    }
    
    $sec = array (
                12 * 30 * 24 * 60 * 60  =>  'an',
                30 * 24 * 60 * 60       =>  'mois',
                24 * 60 * 60            =>  'jour',
                60 * 60                 =>  'heure',
                60                      =>  'minute',
                1                       =>  'seconde'
    );
    
    foreach($sec as $sec => $value){
        $div = $diff_temps / $sec;
        if($div >= 1){
            $temps_conv = round($div);
            $temps_type = $value;
            if($temps_conv > 1 && $temps_type != "mois"){
                $temps_type .= "s" ;
            }
            return 'il y a ' . $temps_conv .' ' . $temps_type;
        }
    }

}
?>