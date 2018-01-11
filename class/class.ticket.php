<?php

class Ticket
{

    public $id;
    public $playerid;
    public $date;
    public $type;
    public $description;
    public $target;
    public $witness;
    public $files;
    public $answer;
    public $staff_id;
    public $status;

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
            'date'=>$this->date,
            'type'=>$this->type,
            'description'=>$this->description,
            'target'=>$this->target,
            'witness'=>$this->witness,
            'files'=>$this->files,
            'answer'=>$this->answer,
            'staff_id'=>$this->staff_id,
            'status'=>$this->status
        );
        return $infosArray;
    }

    public function add(){
        if($infoArray = $this->toArray()) {
            $id = DB::insert(TICKET_TABLE, $infoArray);
            return $id;
        }else{
            return false;
        }
    }

    public function update(){
        $infosArray = $this->toArray();
        DB::update(TICKET_TABLE, $infosArray, array('id' => $this->id));
        return true;
    }

    public static function byPlayerId($pid){
        $res = DB::select(['*'],TICKET_TABLE,array('playerid'=>$pid),array('date'=>'desc'));
        $return = [];
        foreach($res as $t){
            $return[] = new Ticket($t);
        }
        return $return;
    }

    public static function byId($id){
        $res = DB::select(['*'],TICKET_TABLE,array('id'=>$id));
        $return = new Ticket($res[0]);
        return $return;
    }

    public static function getOpen(){
        $res = DB::get()->query("SELECT * FROM ".TICKET_TABLE." WHERE status = 1 ORDER BY date DESC");
        $res = $res->fetchAll();
        $return = [];
        foreach($res as $t){
            $return[] = new Ticket(($t));
        }
        return $return;
    }

    public static function getNew(){
        $res = DB::get()->query("SELECT * FROM ".TICKET_TABLE." WHERE status = 1 and staff_id = 0 ORDER BY date DESC");
        $res = $res->fetchAll();
        $return = [];
        foreach($res as $t){
            $return[] = new Ticket(($t));
        }
        return $return;
    }

    public static function getByStaff($staff_id){
        $res = DB::select(["*"],TICKET_TABLE,array('status'=>1,'staff_id'=>$staff_id),array('date'=>'desc'));
        $return = [];
        foreach($res as $t){
            $return[] = new Ticket($t);
        }
        return $return;
    }

    public static function getClosed(){
        $res = DB::get()->query("SELECT * FROM ".TICKET_TABLE." WHERE status = 0 ORDER BY date DESC LIMIT 20");
        $res = $res->fetchAll();
        $return = [];
        foreach($res as $t){
            $return[] = new Ticket(($t));
        }
        return $return;
    }

}