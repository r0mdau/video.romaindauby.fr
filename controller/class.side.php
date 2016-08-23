<?php
    class Side{
        public static function compteur(){
            $tot=0;
            $res=Db::queryObject('SELECT taille FROM video WHERE id_util='.$_SESSION['id']);
            foreach($res as $cle)
                $tot+=$cle->taille;
            return (int)(_STOCK_/1000000-$tot/1000000);
        }
        
        public static function boiteCompteur(){
            $html='<div class="box_side">';
            $html.='<p>Il vous reste '.self::compteur().' MB d\'espace libre</p>';
            $html.='</div>';
            return $html;
        }
        
        public static function texte(){
            $html='<p>Il vous reste actuellement '.self::compteur().' MB de stockage</p>';
            return $html;
        }
        
        public static function boiteVideo(){
            $res=Db::queryObject('SELECT * FROM video WHERE id_util='.$_SESSION['id']);
            foreach($res as $cle){
                $html='<div class="box_side" id="video'.$cle->id.'">';
                $html.=Player::getAllVideos();
                $html.='</div>';
            }
            return $html;
        }
    };
?>