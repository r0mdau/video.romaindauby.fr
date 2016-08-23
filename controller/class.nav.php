<?php
    class Nav{
        
        public static function Button($lien, $titre, $id_page){
            $html='<a href="'.$lien.'">';
            $html.= '<div class="nav_button ';
            if($titre=='Profil' AND $id_page==3) $html.= 'active';
            else if($titre=='Timeline' AND $id_page==4) $html.= 'active';
            else if($titre=='Ajouter' AND $id_page==5) $html.= 'active';
            else if($titre=='Friend List' AND $id_page==6) $html.= 'active';
            $html.='" >';
            $html.= $titre;
            $html.='</div>';
            $html.='</a>';
            return $html;
        }
        
        public static function deco(){
            return '<div id="deco" title="Déconnexion"><a href="index.php"><img src="images/site/fermer.png" alt="deconnexion"></a></div>';
        }
        
        public static function Search(){
            return '<input type="text" id="search" placeholder="Rechercher des amis">';
        }
        
        public static function notif($nb){
            return '<div id="notif">'.$nb.'</div>';
        }
        
        public static function notif_timeline($nb){
            return '<div id="notif_timeline">'.$nb.'</div>';
        }
        
        public static function settings($id=false){
            $html='<div id="param" ';
            if($id) $html.= 'style="opacity:1;"';
            $html.='><a href="parametres.php" title="Modifier les paramètres de votre compte"><img src="images/site/param.png" alt="paramètres"></a></div>';
            return $html;
        }
    };
?>