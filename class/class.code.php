<?php

class Code
{

    public $id;
    public $name;
    public $use;
    public $exp;

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

    public static function byName($name){
        $res = DB::select(['*'],CODE_TABLE,array('name'=>$name));
        $return = new Code($res[0]);
        return $return;
    }

    public function useCode(){
        if($this->use==0) return false;
        $q = DB::get()->query("UPDATE ".CODE_TABLE." SET `use` = {$this->use}-1 WHERE id = ".$this->id);
        $q->execute();
        return true;
    }

}