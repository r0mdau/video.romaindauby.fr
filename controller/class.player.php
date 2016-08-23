<?php
    class Player{
        public static function nb_video(){
            $res=Db::querySingle('SELECT COUNT(id) tot FROM video WHERE id_util='.$_SESSION['id']);
            return isset($res->tot) ? $res->tot : 0;
        }
        
        public static function get_last_video_id(){
            $res=Db::querySingle('SELECT id FROM video WHERE id_util='.$_SESSION['id'].' ORDER BY id DESC LIMIT 1');
            return isset($res->id) ? $res->id : 0;
        }
        
        public static function getTitre($id){
            $didi=Db::querySingle('SELECT titre, nom FROM video WHERE id='.$id.' AND id_util='.$_SESSION['id']);
            return isset($didi->titre) ? '<a href="lecteur.php?v='.$didi->nom.'" id="titre_video">'.$didi->titre.'</a>' : '';
        }
        
        public static function getTitreN($n){
            $didi=Db::querySingle('SELECT titre, nom FROM video WHERE nom=\''.$n.'\'');
            return isset($didi->titre) ? $didi->titre : 'Lecteur';
        }
        
        public static function getLastTitre(){
            $didi=Db::querySingle('SELECT titre, nom FROM video WHERE id_util='.$_SESSION['id'].' ORDER BY id DESC LIMIT 1');
            return isset($didi->titre) ? '<a href="lecteur.php?v='.$didi->nom.'" id="titre_video">'.$didi->titre.'</a>' : '';
        }
        
        public static function titre($id=false){
            $didi=Db::querySingle('SELECT titre, nom FROM video WHERE id_util='.$_SESSION['id'].' 
                                  '.($id!=false ? 'AND id='.$id.' ' : ' ').'
                                  ORDER BY id DESC LIMIT 1');
            return isset($didi->titre) ? $didi->titre : '';
        }
        
        public static function getLastVideo(){
            $didi=Db::querySingle('SELECT nom FROM video WHERE id_util='.$_SESSION['id'].' ORDER BY id DESC LIMIT 1');
            if(isset($didi->nom) AND !empty($didi->nom))
                return Player::getPlayer($didi->nom);
            else{
                $html= 'Vous n\'avez pas encore uploadé de vidéo, vous pouvez le faire sur le lien suivant :<br>';
                $html.= '<a href="ajouter.php" style="color:blue;text-decoration:underline;"><h2>Ajouter une video<h2></a>';
                return $html;
            }
        }
        
        public static function getAllVideos(){
            $html='';
            $didi=Db::queryObject('SELECT nom, id FROM video WHERE id_util='.$_SESSION['id'].' ORDER BY id DESC');
            $i=0;
            foreach($didi as $cle){
                if($i!=0)$html.=self::miniPlayer($cle->nom, $cle->id);
                ++$i;
            }
            return $html;
        }
        
        public static function getOtherVideos($id){
            $html='';
            $didi=Db::queryObject('SELECT nom, id FROM video WHERE id!='.$id.' AND id_util='.$_SESSION['id'].' ORDER BY id DESC');
            if(isset($didi[0]->nom)){
                foreach($didi as $cle){
                    $html.=self::miniPlayer($cle->nom, $cle->id);
                }
            }
            return $html;
        }
        
        public static function getVideo($id){
            $didi=Db::querySingle('SELECT nom FROM video WHERE id='.$id.' AND id_util='.$_SESSION['id']);
            if(isset($didi->nom) AND !empty($didi->nom))
                return Player::getPlayer($didi->nom);
            else if(self::nb_video() == 0){
                $html= 'Vous n\'avez pas encore uploadé de vidéo, vous pouvez le faire sur le lien suivant :<br>';
                $html.= '<a href="ajouter.php" style="color:blue;text-decoration:underline;"><h2>Ajouter une video<h2></a>';
                return $html;
            }else {
                $html='Vous n\'avez pas les droits nécessaires pour accéder à cette vidéo.';
                return $html;
            }
        }
        
        public static function getLargePlayer($name){//fonction uniquement pour la video projet BTS
            //$name ne contient que le nom de la photo a charger
            $html='<video id="central" width="840" controls>
                    <source src="stock/'.$name.'" />
			<source src="stock/'.self::getTheoraName($name).'" />';
                    //si le navigateur ne peut pas lire la video html5
            $html.='<div style="display:inline-block;">
                        <script type="text/javascript" src="http://www.supportduweb.com/page/js/flashobject.js"></script>
                            <div id="lecteur_85232" style="display:inline-block;">
                                <a href="http://www.macromedia.com/go/getflashplayer">Vous devez installer le Plugin FlashPlayer</a>
                            </div>
                            <script type="text/javascript">
                            //<!--
                                var flashvars_85232 = {};
                                var params_85232 = {
                                quality: "high",
                                bgcolor: "#000000",
                                allowScriptAccess: "always",
                                allowFullScreen: "true",
                                wmode: "transparent",
                                flashvars: "fichier=http://video.romaindauby.fr/stock/'.$name.'"
                                };
                                var attributes_85232 = {};
                                flashObject("http://flash.supportduweb.com/lecteur_flv/v1_2.swf", "lecteur_85232", "590", "300", "8", false, flashvars_85232, params_85232, attributes_85232);
                            //-->
                        </script>
                    </div>';
            //fin du lecteur flash alternatif
            $html.='</video>';
            return $html;
        }

	public static function getTheoraName($n){
	    //preg_match('([^\.])\.[a-z]{3,4}', $n, $out);
	    $e = array('.mov','.MP4','.mp4','.mpeg', '.mkv', '.ogv');
	    return str_replace($e, '.ogv', $n);
	}
        
        public static function getPlayer($name){
            //$name ne contient que le nom de la photo a charger
            $html='<video id="central" width="590" controls>
                    <source src="stock/'.$name.'" />
			<source src="stock/'.self::getTheoraName($name).'" />';
                    //si le navigateur ne peut pas lire la video html5
            $html.='<div style="display:inline-block;">
                        <script type="text/javascript" src="http://www.supportduweb.com/page/js/flashobject.js"></script>
                            <div id="lecteur_85232" style="display:inline-block;">
                                <a href="http://www.macromedia.com/go/getflashplayer">Vous devez installer le Plugin FlashPlayer</a>
                            </div>
                            <script type="text/javascript">
                            //<!--
                                var flashvars_85232 = {};
                                var params_85232 = {
                                quality: "high",
                                bgcolor: "#000000",
                                allowScriptAccess: "always",
                                allowFullScreen: "true",
                                wmode: "transparent",
                                flashvars: "fichier=http://video.romaindauby.fr/stock/'.$name.'"
                                };
                                var attributes_85232 = {};
                                flashObject("http://flash.supportduweb.com/lecteur_flv/v1_2.swf", "lecteur_85232", "590", "300", "8", false, flashvars_85232, params_85232, attributes_85232);
                            //-->
                        </script>
                    </div>';
            //fin du lecteur flash alternatif
            $html.='</video>';
            return $html;
        }
        
        public static function miniPlayer($name, $id){
            $html='<a href="?v='.$id.'"><video width="200">
                    <source src="stock/'.$name.'" />
			<source src="stock/'.self::getTheoraName($name).'" />';
                    //si le navigateur ne peut pas lire la video html5
            $html.='Votre navigateur ne permet pas de lire les vidéos avec le player HTML5, pour lire la vidéo, cliquez sur ce lien.';
            //fin du lecteur flash alternatif
            $html.='</video></a>';
            return $html;
        }
        
        public static function mini_friend_player($name, $id, $friend){
            $html='<a href="profil.php?v='.$id.'&f='.$friend.'"><video width="200">
                    <source src="stock/'.$name.'" />';
                    //si le navigateur ne peut pas lire la video html5
            $html.='Votre navigateur ne permet pas de lire les vidéos avec le player HTML5, pour lire la vidéo, cliquez sur ce lien.';
            $html.='</video></a>';
            return $html;
        }
        
        public static function btn_suppr_last_video(){
            $res=Db::querySingle('SELECT nom, id FROM video WHERE id_util='.$_SESSION['id'].' ORDER BY id DESC LIMIT 1');
            return isset($res->nom) ? '<p style="text-decoration:underline;cursor:pointer;" onclick="suppr_video('.$res->id.')">Supprimer cette vidéo</p>' : '';
        }
        
        public static function btn_suppr_video($id){
            return '<p style="text-decoration:underline;cursor:pointer;" onclick="suppr_video('.$id.')">Supprimer cette vidéo</p>';
        }
        
        public static function proprio_video($id){
            $res=Db::querySingle('SELECT id_util FROM video WHERE id='.$id);
            return isset($res->id_util) ? $_SESSION['id']==$res->id_util : false;
        }
        
        public static function supprimer($id){
            if(self::proprio_video($id)){
                $res=Db::querySingle('SELECT nom FROM video WHERE id='.$id);
                if(isset($res->nom)){
                    if(unlink(_DIR_.'stock/'.$res->nom))
                        return Db::query('DELETE FROM video WHERE id='.$id);
                    else return false;
                }else return false;
            }else return false;
        }
        
        public static function modif_titre($titre, $id=false){
            $html='<br><br><form method="post" action="ajax/modif_titre.php">';
            $html.='Modifier le titre : <input style="width:60%;" type="text" name="titre" value="'.$titre.'"><input type="hidden" name="id" value="';
            if($id!=false) $html.=$id; else $html.=self::get_last_video_id();
            $html.='"><input type="submit" value="modifier">';
            $html.='</form>';
            $html.='<div id="lg_titre"></div><br>';
            return $html;
        }
        
        public static function video_owner($id){
            $res=Db::querySingle('SELECT id_util FROM video WHERE id='.$id);
            return isset($res->id_util) ? $res->id_util==$_SESSION['id'] : false;
        }
        
        public static function modifier_titre($id, $titre){
            if(self::video_owner($id))
                return Db::query('UPDATE video SET titre=\''.$titre.'\' WHERE id='.$id);
            else return false;
        }
    };
?>
