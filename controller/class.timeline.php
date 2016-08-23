<?php
    class Timeline{
        public static function nb_new_video(){
            $score=0;
            $last_id=Db::querySingle('SELECT id_video FROM timeline WHERE id_util='.$_SESSION['id']);
            if(isset($last_id->id_video)){
                if(Friend::get_all_id_friends()!=false){
                    if($res=Friend::get_all_id_friends()){
                        foreach($res as $cle){
                            $to=Db::querySingle('SELECT COUNT(id) tot FROM video WHERE id_util='.$cle->f2.' AND id > '.$last_id->id_video);
                            if(isset($to->tot)) $score+=$to->tot;
                        }return $score;
                    }else return 0;
                }else return 0;
            }else return 0;
        }
        
        public static function new_video(){
            return self::nb_new_video()>0;
        }
        
        public static function get_last_id_video_friend(){
            $score=0;
            if(Friend::get_all_id_friends()!=false){
                $res=Friend::get_all_id_friends();
                foreach($res as $cle){
                    $to=Db::querySingle('SELECT id FROM video WHERE id_util='.$cle->f2.' ORDER BY id DESC LIMIT 1');
                    if(isset($to->id) AND $to->id > $score) $score=$to->id;
                }return $score;
            }else return 0;
        }
        
        public static function remise_zero_notif(){
            return Db::query('UPDATE timeline SET id_video='.self::get_last_id_video_friend().' WHERE id_util='.$_SESSION['id']);
        }
    };
?>