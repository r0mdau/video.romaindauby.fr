<?php
    class Db
    {
        private static $db;
        
        public static function connect(){
            self::$db=mysql_connect(_DB_SERVER_, _DB_USER_, _DB_PASSWD_);
            mysql_select_db(_DB_NAME_, self::$db);
            mysql_query(_DB_FIRST_QUERY_);
        }
        
        public static function disconnect(){
            mysql_close(self::$db);
        }
        
        public static function queryObject($sql){
            self::connect();
            if ($res=mysql_query($sql)){
                $row=array();
                while($ligne=mysql_fetch_object($res)){
                    $row[]=$ligne;					
                }
                mysql_free_result($res); // permet de libérer les ressources rattachées à la requête
                return $row;
            }
            self::disconnect();
        }
        
        public static function queryArray($sql){
            self::connect();
            if ($res=mysql_query($sql)){
                $row=array();
                while($ligne=mysql_fetch_assoc($res)){
                    $row[]=$ligne;					
                }
                mysql_free_result($res); // permet de libérer les ressources rattachées à la requête
                return $row;
            }
            self::disconnect();
        }
        
        public static function querySingle($sql){
            self::connect();
            if ($res=mysql_query($sql)){
                $row=mysql_fetch_object($res);
                mysql_free_result($res); 
                return $row;
            }
            self::disconnect();
        }
        
        public static function query($sql){
            self::connect();
            return $res=mysql_query($sql);
        }
    }
?>
