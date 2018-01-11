<?php

class Donation
{
    public $txn_id;
    public $payment_status;
    public $payer_email;
    public $mc_gross;
    public $mc_currency;
    public $dt;

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

    public function toArray(){
        $infosArray = array(
            'txn_id'=>$this->txn_id,
            'payment_status'=>$this->payment_status,
            'payer_email'=>$this->payer_email,
            'mc_gross'=>$this->mc_gross,
            'mc_currency'=>$this->mc_currency,
        );
        return $infosArray;
    }

    public function add(){
        $infoArray = $this->toArray();
        $infoArray['dt'] = date("Y-m-d H:i:s",time());
        return $player = DB::insert(DC_DONATIONS_TABLE,$infoArray);
    }

    public function update(){
        $infosArray = $this->toArray();
        DB::update(DC_DONATIONS_TABLE, $infosArray,array('txn_id'=>$this->txn_id));
        return true;
    }

    public static function byTxn($txn_id){
        $res = DB::select(['*'],DC_DONATIONS_TABLE,array('txn_id'=>$txn_id));
        if(!isset($res[0])){
            return false;
        }else{
            return new Donation($res[0]);
        }
    }

    public static function getAll(){
        $res = DB::select(['*'],DC_DONATIONS_TABLE,[],array('mc_gross'=>'desc'));
        foreach($res as $t){
            $return[] = new Donation($t);
        }
        return $return;
    }
}