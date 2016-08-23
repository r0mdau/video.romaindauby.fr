<?php
    class Param{
        public static function get_infos_compte(){
            $res=Db::querySingle('SELECT * FROM utilisateur WHERE id='.$_SESSION['id']);
            return isset($res->nom) ? $res : false;
        }
        
        public static function supprimer_compte(){
            if(Player::nb_video()==0) return Db::query('DELETE FROM utilisateur WHERE id='.$_SESSION['id']);
            $res=Db::queryObject('SELECT id FROM video WHERE id_util='.$_SESSION['id']);
            if(isset($res[0])){
                foreach($res as $cle){
                    if(!Player::supprimer($cle->id) AND Player::nb_video()>0) return false;
                }
                return Db::query('DELETE FROM utilisateur WHERE id='.$_SESSION['id']);
            }else return false;            
        }
        
        public static function mailExist($m){
            return isset(Db::querySingle('SELECT id FROM utilisateur WHERE mail=\''.$m.'\'')->id);
        }
        
        public static function nbRetrive($m){
            $res=Db::querySingle('SELECT COUNT(1) total FROM password WHERE mail=\''.$m.'\'');
            return isset($res->total) ? $res->total : 0;
        }
        
        public static function sendMailRetrievePassword($m){
            retrievePasswd($m, Friend::getNameFromMail($m));
        }
    };
?>