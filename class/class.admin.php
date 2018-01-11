<?php


class Admin{

    public $id;
    public $login;
    public $playerid;
    public $email;
    private $password;
    public $status;
    public $active;


    public function __construct($donnees=null){

        if(is_array($donnees)) $this->constructArray($donnees);
    }

    public function constructArray(array $donnees=[]){
        foreach ($donnees as $key => $value) {
            if (property_exists($this,$key)) {
                $this->$key = $value;
            }
        }
    }

    public function password(){
        return $this->password;
    }

    /**
     * check if infos' format is valid before adding to DB
     * @param array $arrayAdmin
     * @return array errors
     */
    public static function formatInfos($arrayAdmin){
        $index = array('login', 'email', 'password', 'status');
        $errors = array('error'=>'');
        foreach ($index as $value) {
            if (isset($arrayAdmin[$value])&&$arrayAdmin[$value]!=="") {
                $errors[$value] = 'OK';
            }
            else {
                $errors[$value] = 'error';
            }
        }

        if(Tools::formatPlayerid($arrayAdmin['playerid'])){
            $errors['playerid'] = 'OK';
        }else{
            $errors['error'] .= 'not guid';
        }

        if(isset($arrayAdmin['email'])){
            $check = self::byEmail($arrayAdmin['email']);
            if(isset($check)){
                $errors['email'] = 'existe';
                $errors['error'] .= 'This email is already used. <br>';
            }
        }


        if(isset($arrayAdmin['login'])){
            $check = self::byId($arrayAdmin['login']);
            if(isset($check)){
                $errors['login'] = 'existe';
                $errors['error'] .= 'This login is already used. <br>';
            }
        }

        return $errors;
    }

    /**
     * @param string $p password
     * @return array hashkey valide
     */
    public function passwordValide($p){
        return $this->password === md5($p);
    }

    /**
     * @param string $p password
     * @return bool hashkey valide
     */
    public function signin($p){
        if($this->password === md5($p)){
            return array(
                'signin'=>1,
                'admin_id'=>$this->id,
                'status'=>$this->status
            );
        }else{
            return array('signin'=>0);
        }
    }

    /**
     * @param int $password
     * @return array errors
     */
    public function add($password){
        $infosArray = array(
            'login'=>$this->login,
            'playerid'=>$this->playerid,
            'email'=>$this->email,
            'active'=>$this->active,
            'password'=>$password,
            'status'=>$this->status
        );

        $formatInfosErrors = Admin::formatInfos($infosArray);

        //check que le mot de passe fait au moins 6 caractères
        if (isset($infosArray['password'])&&!(strlen($infosArray['password']) > 5)) {
            $formatInfosErrors['password'] = 'error';
            $formatInfosErrors['error'] .= 'Le mot de passe est trop faible. <br>';
        }

        $errs = false;
        foreach($formatInfosErrors as $k=>$v){
            if($k!=="error"&&$v!=="OK"&&$v!=="") $errs=true;
        }

        $signup=0;
        if(!$errs){
            $infosArray['password']=md5($password);
            $infosArray['inscription']=date("Y-m-d H:i:s");
            $this->id = DB::insert(ADMIN_TABLE, $infosArray);
            $signup=1;
        }
        else if($formatInfosErrors['error']===''){
            $infosArray['password']=md5($password);
            $infosArray['inscription']=date("Y-m-d H:i:s");
            $this->id = DB::insert(ADMIN_TABLE, $infosArray);
            $signup=1;
        }

        return array('signup' =>$signup, 'errors'=> $formatInfosErrors, 'admin_id'=>$this->id, 'status'=>$this->status);
    }

    /**
     * get admin by id
     * @param $admin_id
     * @return Admin
     */
    public static function byId($admin_id){
        $res = DB::select(['*'], ADMIN_TABLE, array('id'=>$admin_id));
        if(!isset($res[0])) return null;
        return new Admin( $res[0]  );
    }

    /**
     * get admin by email
     * @param $admin_email
     * @return Admin
     */
    public static function byEmail($admin_email){
        $res = DB::select(['*'], ADMIN_TABLE, array('email'=>$admin_email));
        if(!isset($res[0])) return null;
        return new Admin( $res[0] );
    }

    /**
     * get admin by login
     * @param $admin_login
     * @return Admin
     */
    public static function byLogin($admin_login){
        $res = DB::select(['*'], ADMIN_TABLE, array('login'=>$admin_login));
        if(!isset($res[0])) return null;
        return new Admin( $res[0] );
    }

    public static function byPlayerid($admin_playerid){
        $res = DB::select(['*'], ADMIN_TABLE, array('playerid'=>$admin_playerid));
        if(!isset($res[0])) return null;
        return new Admin( $res[0] );
    }

    public static function getAll(){
        $res = DB::select(['*'], ADMIN_TABLE,[],array('status'=>'desc'));
        if(!isset($res[0])){ return null; }
        else {
            foreach($res as $k => $a){
                $return[] = new Admin($res[$k]);
            }
            return $return;
        }
    }

    public static function getAdmins(){
        $res = DB::select(['*'], ADMIN_TABLE,array('status'=>2));
        if(!isset($res[0])){ return null; }
        else {
            foreach($res as $k => $a){
                $return[] = new Admin($res[$k]);
            }
            return $return;
        }
    }

    /**
     * get admins list
     * @param array $conditions
     * @return array
     */
    public static function parListe($conditions=[]) {
        $res = DB::select(['*'], ADMIN_TABLE, $conditions);
        $users = [];
        foreach($res as $user) $users[] = new Admin( $user );
        return $users;
    }

    public function displayRank(){
        $ranks = ['Helper','Modérateur','Admin'];
        return $ranks[$this->status];
    }

    public function update($password=null){
        $infosArray = array(
            'login'=>$this->login,
            'status'=>$this->status,
            'active'=>$this->active
        );
        if(isset($password)) $infosArray['password'] = md5($password);
        DB::update(ADMIN_TABLE,$infosArray,array('id'=>$this->id));
        return true;
    }

    public static function countAdmin(){
        $res = DB::get()->query("SELECT COUNT(id) as countAdmin FROM ".ADMIN_TABLE);
        $res = $res->fetch();
        return $res['countAdmin'];
    }

}