<?php

class Player
{

    public $uid;
    public $name;
    public $playerid;
    public $cash;
    public $bankacc;
    public $coplevel;
    public $cop_licenses;
    public $civ_licenses;
    public $med_licenses;
    public $cop_gear;
    public $med_gear;
    public $mediclevel;
    public $arrested;
    public $aliases;
    public $adminlevel;
    public $donatorlvl;
    public $civ_gear;
    public $blacklist;
    public $sponsor;
    public $credit;

    public function __construct($donnees = null)
    {

        if (is_array($donnees)) $this->constructArray($donnees);
    }

    /**
     * @param array $donnees
     */
    public function constructArray(array $donnees = [])
    {
        foreach ($donnees as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function checkPlayer(){
        if(!isset($this->playerid)) return false;
        if(!isset($this->name)) $this->name = 'newPromo';
        if(!isset($this->cash)) $this->cash = 0;
        if(!isset($this->bankacc)) $this->bankacc = 10000;
        if(!isset($this->cop_gear)) $this->cop_gear = '"[]"';
        if(!isset($this->civ_gear)) $this->civ_gear = '"[]"';
        if(!isset($this->med_gear)) $this->med_gear = '"[]"';
        return $this;
    }

    public function toArray(){
        $infosArray = array(
            'uid'=>$this->uid,
            'name'=>$this->name,
            'playerid'=>$this->playerid,
            'cash'=>$this->cash,
            'bankacc'=>$this->bankacc,
            'coplevel'=>$this->coplevel,
            'cop_licenses'=>$this->cop_licenses,
            'civ_licenses'=>$this->civ_licenses,
            'med_licenses'=>$this->med_licenses,
            'cop_gear'=>$this->cop_gear,
            'med_gear'=>$this->med_gear,
            'mediclevel'=>$this->mediclevel,
            'arrested'=>$this->arrested,
            'aliases'=>$this->aliases,
            'adminlevel'=>$this->adminlevel,
            'donatorlvl'=>$this->donatorlvl,
            'civ_gear'=>$this->civ_gear,
            'blacklist'=>$this->blacklist,
            'sponsor'=>$this->sponsor,
            'credit'=>$this->credit
        );
        return $infosArray;
    }

    public function add(){
        $this->checkPlayer();
        $infoArray = $this->toArray();
        return $player = DB::insert(PLAYERS_TABLE,$infoArray);
    }

    public function update(){
        $infosArray = $this->toArray();
        DB::update(PLAYERS_TABLE, $infosArray,array('uid'=>$this->uid));
        return true;
    }

    /*
     * FIND PLAYER
     */

    public static function byPlayerid($playerid){
        $fetch = DB::select(['*'], PLAYERS_TABLE, array('playerid'=>$playerid));
        if(!isset($fetch[0])) return null;
        return new Player($fetch[0]);
    }

    public static function byName($name){
        $fetch = DB::get()->query("SELECT * FROM ".PLAYERS_TABLE." WHERE name LIKE '%$name%' OR aliases LIKE '%".$name."%' ORDER BY name ASC");
        $fetch = $fetch->fetchAll();
        return $fetch;
    }

    public static function getCop(){
        $fetch = DB::get()->query("SELECT * FROM ".PLAYERS_TABLE." WHERE coplevel != '0' ORDER BY coplevel DESC");
        $fetch = $fetch->fetchAll();
        return $fetch;
    }

    public static function getMed(){
        $fetch = DB::get()->query("SELECT * FROM ".PLAYERS_TABLE." WHERE mediclevel != '0' ORDER BY mediclevel DESC");
        $fetch = $fetch->fetchAll();
        return $fetch;
    }

    public static function getCiv(){
        $fetch = DB::get()->query("SELECT * FROM ".PLAYERS_TABLE."
        WHERE civ_licenses LIKE '%`license_civ_G1`,1%'
            OR civ_licenses LIKE '%`license_civ_G2`,1%'
            OR civ_licenses LIKE '%`license_civ_G3`,1%'
            OR civ_licenses LIKE '%`license_civ_G4`,1%'");
        $fetch = $fetch->fetchAll();
        return $fetch;
    }

    public static function getAdmins(){
        $fetch = DB::get()->query("SELECT * FROM ".PLAYERS_TABLE." WHERE adminlevel != '0' ORDER BY adminlevel ASC");
        $fetch = $fetch->fetchAll();
        return $fetch;
    }

    public static function getDona(){
        $fetch = DB::get()->query("SELECT * FROM ".PLAYERS_TABLE." WHERE donatorlvl != '0' ORDER BY name ASC");
        $fetch = $fetch->fetchAll();
        return $fetch;
    }

    public static function getNew(){
        $fetch = DB::get()->query("SELECT * FROM ".PLAYERS_TABLE." ORDER BY uid DESC LIMIT 50");
        $fetch = $fetch->fetchAll();
        return $fetch;
    }

    public static function getRichest(){
        $fetch = DB::get()->query("SELECT * FROM ".PLAYERS_TABLE." ORDER BY cash+bankacc DESC LIMIT 50");
        $fetch = $fetch->fetchAll();
        return $fetch;
    }

    public static function getTopSponsors(){
        $fetch = DB::get()->query("SELECT DISTINCT(sponsor) FROM ".PLAYERS_TABLE." WHERE sponsor != '' LIMIT 50");
        $fetch = $fetch->fetchAll();
        $return = [];
        foreach($fetch as $p){
            $return[] = new Player($p);
        }
        return $return;
    }

    public static function countCivLevel($rank){
        if($rank==0){
            $fetch = DB::get()->query("SELECT COUNT(uid) as countCiv FROM ".PLAYERS_TABLE."
                WHERE civ_licenses NOT LIKE '%`license_civ_G1`,1%'
                AND civ_licenses NOT LIKE '%`license_civ_G2`,1%'
                AND civ_licenses NOT LIKE '%`license_civ_G3`,1%'
                AND civ_licenses NOT LIKE '%`license_civ_G4`,1%'");
        }else {
            $fetch = DB::get()->query("SELECT COUNT(uid) as countCiv FROM " . PLAYERS_TABLE . "
            WHERE civ_licenses LIKE '%`license_civ_G{$rank}`,1%'");
        }
        $fetch = $fetch->fetch();
        return $fetch;
    }

    public static function getPlayersByFilter($filter){

        switch ($filter) {
            case 'cop':
                $res = self::getCop();
                break;
            case 'med':
                $res = self::getMed();
                break;
            case 'admins':
                $res = self::getAdmins();
                break;
            case 'dona':
                $res = self::getDona();
                break;
            case 'new' :
                $res = self::getNew();
                break;
            case 'bank' :
                $res = self::getRichest();
                break;
            case 'sponsors' :
                $res = self::getTopSponsors();
                break;
            default :
                $res = $filter!='' ? self::byName($filter) : null;
        }
        return $res;
    }

    public static function countPlayers(){
        $sql = DB::get()->query('SELECT COUNT(uid) FROM players');
        $fetch = $sql->fetch();
        return $fetch['COUNT(uid)'];
    }

    /*
     * SPONSORSHIP
     */

    public function getSponsoredPlayer(){
        $return = [];
        $fetch = DB::select(['playerid'],PLAYERS_TABLE,array('sponsor'=>$this->playerid));
        foreach($fetch as $p){
            $return[] = self::byPlayerid($p['playerid']);
        }
        return $return;
    }

    public function countSponsored(){
        $sql = DB::get()->query('SELECT COUNT(sponsor) as count FROM players WHERE sponsor = '.$this->playerid);
        $fetch = $sql->fetch();
        return $fetch['count'];
    }

    public static function countSponsors(){
        $sql = DB::get()->query("SELECT DISTINCT sponsor FROM ".PLAYERS_TABLE." WHERE sponsor IS NOT NULL");
        $fetch = $sql->fetchAll();
        return count($fetch);
    }

    /*
     * BLUEFOR
     */

    public static function displayCopLevel($rank){
        $ranks = [null,'1ère Classe','Soldat','Caporal','Sergent','Adjudant','Major','Lieutenant','Capitaine','Commandant','Colonel','Général'];
        return $ranks[$rank];
    }

    public function displayCivLevel(){
        $rank = strpos($this->civ_licenses, '`license_civ_G1`,1') !== false ? 'Recensé' : null ;
        $rank = strpos($this->civ_licenses, '`license_civ_G2`,1') !== false ? 'Ouvrier' : $rank ;
        $rank = strpos($this->civ_licenses, '`license_civ_G3`,1') !== false ? 'Marchand' : $rank ;
        $rank = strpos($this->civ_licenses, '`license_civ_G4`,1') !== false ? 'Citoyen' : $rank ;
        $rank = $rank == null ? 'Vagabond' : $rank;
        return $rank;
    }

}