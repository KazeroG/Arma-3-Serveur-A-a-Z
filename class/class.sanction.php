<?php

class Sanction
{

    public $id;
    public $playerid;
    public $author;
    public $date;
    public $type;
    public $sanction;
    public $description;
    public $ticket;

    public function __construct($donnees = null)
    {
        if (is_array($donnees)) $this->constructArray($donnees);
    }

    /**
     * @param array $donnees
     */
    public function constructArray(array $donnees = []){
        foreach ($donnees as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function toArray(){
        if(!Tools::formatPlayerid($this->playerid)) return false;
        $infosArray = array(
            'playerid'=>$this->playerid,
            'author'=>$this->author,
            'date'=>$this->date,
            'type'=>$this->type,
            'sanction'=>$this->sanction,
            'description'=>$this->description,
            'ticket'=>$this->ticket
        );
        return $infosArray;
    }

    public function add(){
        if($infoArray = $this->toArray()) {
            return $player = DB::insert(SANCTION_TABLE, $infoArray);
        }else{
            return false;
        }
    }

    public function update(){
        $infosArray = $this->toArray();
        DB::update(SANCTION_TABLE, $infosArray, array('id' => $this->id));
        return true;
    }

    public static function byPlayerId($pid){
        $res = DB::select(['*'],SANCTION_TABLE,array('playerid'=>$pid),array('type'=>'desc'));
        $return = [];
        foreach($res as $s){
            $return[] = new Sanction($s);
        }
        return $return;
    }

    public static function byTicket($ticket){
        $res = DB::select(['*'],SANCTION_TABLE,array('ticket'=>$ticket),array('type'=>'desc'));
        $return = [];
        foreach($res as $s){
            $return[] = new Sanction($s);
        }
        return $return;
    }

    public static function byId($id){
        $res = DB::select(['*'],SANCTION_TABLE,array('id'=>$id));
        $return = new Sanction($res[0]);
        return $return;
    }

    public function displayType(){
        $type = ['RAS','Averto','Ban'];
        return $type[$this->type];
    }

}