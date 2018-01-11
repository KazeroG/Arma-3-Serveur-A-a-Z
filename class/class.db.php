<?php
class DB{
    /**
     * @var
     */
    static $bdd;
    static $oldbdd;

    /**
     *
     */
    public function __construct(){}

    /**
     * @return PDO
     */
    public static function get(){
		if(!self::$bdd){
			try {
                self::$bdd = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
				self::$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
				return self::$bdd;
			}catch(PDOException $e){
				echo $e->getMessage();
			}
		}else{
			return self::$bdd;
		}
	}

    /**
     * @param $table : the table to insert in
     * @param $array : key-values pairs to insert
     * @return int inserted id
     */
    public static function insert($table, $array){
        $sql = "INSERT INTO ".$table." SET";
        foreach($array as $k => $v){
            if($v!==null){
                $sql .= ' '.$k.' = :'.$k.',';
            }
        }
        $sql = substr($sql, 0, strlen($sql)-1);
        $query = DB::get()->prepare($sql);

        foreach($array as $k => $v){
            if($v!==null) {
                $query->bindValue(':' . $k, $v);
            }
        }

        $query -> execute();

        return DB::get()->lastInsertId();
    }

    /**
     * @param $table : the table to update in
     * @param $array : key-values pairs to update
     * @param $condition :  key-values pairs linked with AND condition within the SQL query (REQUIRED)
     */
    public static function update($table, $array, $condition){
        $sql = "UPDATE ".$table." SET";
        foreach($array as $k => $v){
            if($v!==null) {
                $sql .= ' '.$k.' = :'.$k.',';
            }
        }
        $sql = substr($sql, 0, strlen($sql)-1);
        $sql.=" WHERE ";

        foreach($condition as $k => $v){
            $sql .= ' '.$k.' = :'.$k.' AND';
        }

        $sql = substr($sql, 0, strlen($sql)-3)." LIMIT 1";

        $query = DB::get()->prepare($sql);

        foreach($array as $k => $v){
            if($v!==null) {
                $query->bindValue(':' . $k, $v);
            }
        }

        foreach($condition as $k => $v){
            $query -> bindValue(':'.$k, $v);
        }

        $query -> execute();
    }

    /**
     * @param array $champs select
     * @param $table : the table to select in
     * @param array $condition :  key-values pairs linked with AND condition within the SQL query
     * @param array $orderCondition
     * @return array from the query
     */
    public static function select($champs, $table, array $condition=[], array $orderCondition=[]){
        $sql = "SELECT";
        foreach($champs as $v){
            $sql .= ' '.$v.',';
        }
        $sql = substr($sql, 0, strlen($sql)-1);
        $sql.=" FROM ".$table;

        $sql.=" WHERE 1=1 ";
        foreach($condition as $k => $v){
            $sql .= 'AND '.$k.'=:'.str_replace(['!', '>', '<'], '', $k).' ';
        }

        if (count($orderCondition) > 0) {
            $sql.=" ORDER BY 1=1 ";
            foreach ($orderCondition as $k => $v)
                $sql .= ', '.$k.' '.$v.' ';
        }
        $query = DB::get()->prepare($sql);

        foreach ($condition as $k => $v) {
            $query->bindValue(':' . str_replace(['!', '>', '<'], '', $k), $v);
        }

        $query -> execute();

        $rep = $query -> fetchAll();


        return $rep;
    }


}
?>
