<?php

class Vehicles
{

    public $id;
    public $side;
    public $classname;
    public $type;
    public $pid;
    public $alive;
    public $active;
    public $plate;
    public $color;
    public $inventory;
    public $insure;

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

    public function update()
    {
        $infosArray = array(
            'id'=>$this->id,
            'side'=>$this->side,
            'classname'=>$this->classname,
            'type'=>$this->type,
            'pid'=>$this->pid,
            'alive'=>$this->alive,
            'active'=>$this->active,
            'plate'=>$this->plate,
            'color'=>$this->color,
            'inventory'=>$this->inventory,
            'insure'=>$this->insure,
        );
        DB::update(VEHICLES_TABLE, $infosArray, array('id' => $this->id));
        return true;
    }

    public static function toogleAlive($id){
        $veh = Vehicles::byId($id);
        if(!empty($veh)){
            $toggle = $veh->alive ? '0' : '1';
            $veh->alive = $toggle;
            $veh->update();
            return true;
        }
        return false;
    }

    public static function toogleInsure($id){
        $veh = Vehicles::byId($id);
        if(!empty($veh)){
            $toggle = $veh->insure ? '0' : '1';
            $veh->insure = $toggle;
            $veh->update();
            return true;
        }
        return false;
    }

    /*
     * GET VEHICLES
     */

    public static function byPlayerId($pid){
        $res = DB::select(['*'],VEHICLES_TABLE,array('pid'=>$pid),array('classname'=>'asc'));
        $return = [];
        foreach($res as $v){
            $return[] = new Vehicles($v);
        }
        return $return;
    }

    public static function byId($id){
        $res = DB::select(['*'],VEHICLES_TABLE,array('id'=>$id));
        $return = new Vehicles($res[0]);
        return $return;
    }

    public static function delete($id){
        $q = DB::get()->prepare("DELETE FROM ".VEHICLES_TABLE." WHERE id = :id LIMIT 1");
        $q->bindValue(':id',$id,PDO::PARAM_INT);
        $q->execute();
        return true;
    }

}