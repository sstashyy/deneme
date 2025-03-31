<?php 

namespace sstashy;

use PDO;
use PDOException;

class System{
    protected static $connection;
    protected static $table;
    protected static $select = "*";
    protected static $whereRawKey;
    protected static $whereRawVal;
    protected static $whereKey;
    protected static $whereVal = array();
    protected static $orderby = NULL;
    protected static $limit = NULL;
    protected static $join = "";
    protected static $leftJoin = ""; 
    protected static $option = true;
    
    public function __construct()
    {
        self::__connect();
    }

    public static function __connect(){
        try{
            $dsn = "mysql:host=localhost;dbname=u384784769_sstashypriv1;charset=utf8";
            $username = 'u384784769_sstashypriv1';
            $password = 'Ae175424';
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                PDO::ATTR_EMULATE_PREPARES => false, 
            );
            self::$connection = new PDO($dsn, $username, $password, $options);
        }catch(PDOException $e){
            error_log("Bağlantı hatası: " . $e->getMessage());
            exit();
        }
    }

    public static function table($tableName){ 
        self::$table = $tableName;
        self::$select="*";
        self::$whereRawKey = NULL;
        self::$whereRawVal = NULL;
        self::$whereKey = NULL;
        self::$whereVal = NULL;
        self::$orderby = NULL;
        self::$limit = NULL;
        self::$join = "";
        self::$leftJoin = "";
        self::$option = "";
        return new self;
    }

    public static function select($columns){
        self::$select = (is_array($columns)) ? implode(",",$columns) : $columns;
        return new self;
    }

    public static function whereRaw($whereRaw,$whereRawVal){
        self::$whereRawKey = "(".$whereRaw.")";
        self::$whereRawVal = $whereRawVal;
        return new self;
    }

    public static function where($columns1,$columns2 = NULL,$columns3 = NULL,$opt = true){
        if(is_array($columns1) != false){ 
            $keyList = array();
            foreach($columns1 as $key => $item){
                self::$whereVal[] = $item;
                $keyList[] = $key;
            }
            self::$whereKey = ($opt == true) ? self::$whereKey = implode(" = ? and ",$keyList)." = ?" : self::$whereKey = implode(" = ? or ",$keyList)." = ?";
        }elseif($columns2 != NULL && $columns3 == NULL){
            self::$whereVal[] = $columns2; 
            self::$whereKey=$columns1." = ?";
        }elseif ($columns3 != NULL) { 
            self::$whereVal[] = $columns3;
            self::$whereKey = $columns1." ".$columns2." ?"; 
        }
        self::$option = $opt; 
        return new self;
    }

    public static function orderby($parameter = array()){ 
        self::$orderby=$parameter[0]." ".((!empty($parameter[1])) ? $parameter[1] : "ASC"); 
        return new self;
    }

    public static function limit($start,$end = NULL){ 
        self::$limit = $start.(($end != NULL) ? ",".$end : "");
        return new self;
    }

    public static function join($tableName, $thisColumns, $joinColumns){ /** İNNER JOİN FUNCTİONU */
        self::$join.="INNER JOIN ".$tableName." ON ".self::$table.".".$thisColumns."=".$tableName.".".$joinColumns." ";
        return new self;
    }

    public static function leftjoin($tableName, $thisColumns, $joinColumns){ /** LEFT JOİN FUNCTİONU */
        self::$leftJoin.="LEFT JOIN ".$tableName." ON ".self::$table.".".$thisColumns."=".$tableName.".".$joinColumns." ";
        return new self;
    }

public static function get(){
    $sql = "SELECT ".self::$select." FROM ".self::$table." ";
    $sql.= (!empty(self::$join)) ? self::$join : "";
    $sql.= (!empty(self::$leftJoin)) ? self::$leftJoin : "";
    $where = NULL;
    if(!empty(self::$whereKey) && !empty(self::$whereRawKey)){
        $sql.="WHERE ".self::$whereKey." ".self::$option." ".self::$whereRawKey." ";
        $where = array_merge(self::$whereVal,self::$whereRawVal);
        
    }else{
        if(!empty(self::$whereKey)) {
            $sql.="WHERE ".self::$whereKey." ";
            $where = self::$whereVal;
        }elseif (!empty(self::$whereRawKey)) {
            $sql.="WHERE ".self::$whereRawKey." ";
            $where = self::$whereRawVal;
        }
    }

    $sql .= (!empty(self::$orderby)) ? "ORDER BY ".self::$orderby." " : "";
    $sql .= (!empty(self::$limit)) ? "LIMIT ".self::$limit : "";

    if($where != NULL){
        $entity = self::$connection -> prepare($sql);
        $sync = $entity -> execute($where);
    }else{
        $entity = self::$connection -> query($sql);
    }

    $result = $entity -> fetchAll(PDO::FETCH_ASSOC);
    if($result != false){
        $data = [];
        foreach($result as $item){
            $data[] =(object) $item;
            
        }

        if(count($data)>1){
            return $data;
        }else{
            return $data;
        }
        
    }else{
        return false;
    }   
}

    public static function first(){ 
        $entity = self::get();
        if($entity){
            return $entity[0];
        }else{
            return false;
        }
    }

    public static function create($arrayColumns){
        $columns = array_keys($arrayColumns); 
        $columnsVal = array_values($arrayColumns);

        $sql = "INSERT INTO ".self::$table." SET ".implode(" = ?, ",$columns)." = ? ";
        $entity = self::$connection -> prepare($sql);
        $sync = $entity -> execute($columnsVal);

        if($sync != false){
            return true;
        }else{
            return false;
        }

    }

    public static function update($arrayColumns){
        $columns = array_keys($arrayColumns); 
        $columnsVal = array_values($arrayColumns); 
    
        $sql = "UPDATE ".self::$table." SET ";
        $setColumns = array();
        foreach ($columns as $column) {
            $setColumns[] = "$column = ?";
        }
        $sql .= implode(", ", $setColumns);
    
        $where = NULL;
        if(!empty(self::$whereKey) && !empty(self::$whereRawKey)){
            $sql .= " WHERE ".self::$whereKey." ".self::$option." ".self::$whereRawKey." ";
            $where = array_merge(self::$whereVal, self::$whereRawVal);
        } else {
            if(!empty(self::$whereKey)) {
                $sql .= " WHERE ".self::$whereKey." ";
                $where = self::$whereVal;
            } elseif (!empty(self::$whereRawKey)) {
                $sql .= " WHERE ".self::$whereRawKey." ";
                $where = self::$whereRawVal;
            }
        }
    
        $entity = self::$connection -> prepare($sql);
        $sync = $entity -> execute(array_merge($columnsVal, $where));
    
        if($sync != false){
            return true;
        } else {
            return false;
        }
    }
    

    public static function delete(){
        $sql = "DELETE FROM ".self::$table." ";
        $where = NULL;
        if(!empty(self::$whereKey) && !empty(self::$whereRawKey)){
            $sql.="WHERE ".self::$whereKey." ".self::$option." ".self::$whereRawKey." ";
            $where = array_merge(self::$whereVal,self::$whereRawVal);
            
        }else{
            if(!empty(self::$whereKey)) {
                $sql.="WHERE ".self::$whereKey." ";
                $where = self::$whereVal;
            }elseif (!empty(self::$whereRawKey)) {
                $sql.="WHERE ".self::$whereRawKey." ";
                $where = self::$whereRawVal;
            }
        }

        $entity = self::$connection -> prepare($sql);
        $sync = $entity -> execute($where);

        if($sync != false){
            return true;
        }else{
            return false;
        }

    }

    public static function filter($val,$tf = false){
        if($tf == false){$val = strip_tags($val);}
        $val = addslashes(trim($val));
        return $val;
    }

    public static function view($page,$errorData){
        $file = "errors/".$page.".php";

        if(file_exists($file)){
            include_once($file);
        }elseif(file_exists("../".$file)){
            include_once("../".$file);
        }
        
    }
}

?>