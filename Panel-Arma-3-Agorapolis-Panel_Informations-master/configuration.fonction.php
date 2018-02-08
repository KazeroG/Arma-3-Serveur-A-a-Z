<?php

function Configuration($str)
{
    static $row;
    global $bdd;

    if (!$row)
    {
        $stm = $bdd->query("SELECT * FROM configuration");
        $row = $stm->fetch();
    }
    return $row[$str];
}

?>