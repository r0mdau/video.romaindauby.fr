<?php
    class Friend{
        public static function get_all_id_friends(){
            $res=Db::queryObject('SELECT f2 FROM friend WHERE f1='.$_SESSION['id'].' AND actif=1');
            return isset($res[0]->f2) ? $res : false;
        }
        
        public static function get_name($id){
            $res=Db::querySingle('SELECT nom, prenom FROM utilisateur WHERE id='.$id);
            return isset($res->nom) ? $res->prenom.' '.$res->nom : '';
        }
        
        public static function getNameFromMail($m){
            $res=Db::querySingle('SELECT nom, prenom FROM utilisateur WHERE mail=\''.$m.'\'');
            return isset($res->nom) ? $res->prenom.' '.$res->nom : '';
        }
        
        public static function new_friend(){
            return self::nb_new_friend()>0;
        }
        
        public static function nb_new_friend(){
            $res=Db::querySingle('SELECT COUNT(id) tot FROM friend WHERE f1='.$_SESSION['id'].' AND demande!='.$_SESSION['id'].' AND actif=0');
            return !empty($res->tot) ? $res->tot : 0;
        }
        
        public static function isFriend($id){
            $res=Db::queryObject('SELECT f2 FROM friend WHERE f1='.$_SESSION['id'].' AND actif=1');
            if(isset($res[0]))
                foreach($res as $cle)
                    if($cle->f2 == $id) return true;
            return false;
        }
        
        public static function countFriends(){
            $res=Db::querySingle('SELECT COUNT(id) tot FROM friend WHERE f1='.$_SESSION['id'].' AND actif=1');
            return $res->tot;
        }
        
        public static function nb_friends(){
            return self::countFriends();
        }
        
        public static function get_friend($id){
            if(!self::isFriend($id) AND !self::himself($id)){
                $res=Db::querySingle('SELECT * FROM utilisateur WHERE id='.$id);
                return isset($res->tot) ? $res : '';
            }else return 'Erreur de récupération des infos de l\'ami.';
        }
        
        public static function nbCommun($id){
            if(!self::himself($id)){
                //$res=Db::querySingle('SELECT COUNT(*) tot FROM liste l, liste t WHERE l.f2 = t.f2 AND l.f1='.$_SESSION['id'].' AND t.f1='.$id);
                $res=Db::queryObject('SELECT f2 FROM friend WHERE f1='.$id.' AND actif=1');
                if(isset($res[0])){
                    $tot=0;
                    foreach($res as $cle){
                        if(self::isFriend($cle->f2))
                            ++$tot;
                    }
                    return $tot;
                }
            }
            return 0;
        }
        
        //fonction pas encore utilisées
        public static function listeCommun($id){
            $html='';
            if(!self::isFriend($id) AND !self::himself($id)){                
                $res=Db::queryObject('SELECT * FROM liste l, liste t WHERE l.f2 = t.f2 AND l.f1='.$_SESSION['id'].' AND t.f1='.$id);
                foreach($res as $cle){
                    $html.='<div class="friend">';
                    $html.='<p>'.$cle->prenom.' '.$cle->nom.'</p>';
                    $html.='</div>';
                }
            }
            return $html;
        }
        
        public static function ajouter($id){
            if(!self::isFriend($id) AND !self::himself($id)){
                if(Db::query('INSERT INTO friend (f1, f2, demande) VALUES('.$_SESSION['id'].', '.$id.', '.$_SESSION['id'].')'))
                    return Db::query('INSERT INTO friend (f2, f1, demande) VALUES('.$_SESSION['id'].', '.$id.', '.$_SESSION['id'].')');
            }
        }
        
        public static function confirmer($id){
            if(!self::isFriend($id) AND !self::himself($id) AND self::deja_demande($id)){
                if(Db::query('UPDATE friend SET actif=1 WHERE f1='.$_SESSION['id'].' AND f2='.$id.' AND demande='.$id))
                    return Db::query('UPDATE friend SET actif=1 WHERE f2='.$_SESSION['id'].' AND f1='.$id.' AND demande='.$id);
                else return false;
            }else return false;
        }
        
        public static function supprimer($id){
            if((self::isFriend($id) OR self::deja_demande($id)) AND !self::himself($id)){
                if(Db::query('DELETE FROM friend WHERE f1='.$_SESSION['id'].' AND f2='.$id))
                    return Db::query('DELETE FROM friend WHERE f2='.$_SESSION['id'].' AND f1='.$id);
                else return false;
            }else return false;
        }
        
        public static function deja_demande($id){
            $res=Db::querySingle('SELECT * FROM friend WHERE f1='.$_SESSION['id'].' AND f2='.$id.' AND actif=0');
            return isset($res->f1) ? true : false;
        }
        
        public static function attente(){
            $res=Db::querySingle('SELECT id FROM friend WHERE f1='.$_SESSION['id'].' AND actif=0 AND demande='.$_SESSION['id']);
            return isset($res->id) ? true : false;
        }
        
        public static function liste_attente(){
            $html='';
            $res=Db::queryObject('SELECT u.id id, u.prenom prenom, u.nom nom FROM utilisateur u, friend f WHERE f.f2='.$_SESSION['id'].' AND f.f1=u.id AND f.actif=0 AND demande='.$_SESSION['id']);
            if(isset($res[0])){
                foreach($res as $cle){
                    if(!self::isFriend($cle->id) AND !self::himself($cle->id)){
                        $html.='<div class="friend f'.$cle->id.'">';
                        $html.='<p>'.$cle->prenom.' '.$cle->nom.' - ('.self::nbCommun($cle->id).' '.(self::nbCommun($cle->id)>1 ? 'amis' : 'ami').' en commun) ';
                        $html.='<span title="Supprimer l\'ami" style="cursor:pointer;" onclick="supprimer('.$cle->id.')">';
                        $html.='<img style="width:10px;height:10px;" src="images/site/fermer.png" alt="supprimer"></span></p>';
                        $html.='</div>';
                    }
                }
            }
            return $html;
        }
        
        public static function himself($id){
            return $id == $_SESSION['id'];
        }
        
        public static function liste($mot){
            $html='';
            if(strpos($mot, ' ')) $mo=explode(' ', $mot);
            $res=Db::queryObject('SELECT * FROM utilisateur WHERE CONCAT(nom, prenom)
                                '.(strpos($mot, ' ') ? 'LIKE \'%'.$mo[0].'%'.$mo[1].'%\'
                                OR CONCAT(nom, prenom) LIKE \'%'.$mo[1].'%'.$mo[0].'%\'' : 'LIKE \'%'.$mot.'%\'' ));
            foreach($res as $cle){
                if(!self::isFriend($cle->id) AND !self::himself($cle->id) AND !self::deja_demande($cle->id)){
                    $html.='<div class="friend f'.$cle->id.'">';
                    $html.='<p>'.$cle->prenom.' '.$cle->nom.' - ('.self::nbCommun($cle->id).' '.(self::nbCommun($cle->id)>1 ? 'amis' : 'ami').' en commun) ';
                    $html.='<span style="font-size:1.2em;text-decoration:underline;cursor:pointer;color:blue;" onclick="ajouter('.$cle->id.')">Ajouter</span></p>';
                    $html.='</div>';
                }
            }
            return $html;
        }
        
        public static function liste_new_friends(){
            $html='';
            $res=Db::queryObject('SELECT u.id id, u.prenom prenom, u.nom nom, u.mail mail FROM utilisateur u, friend f WHERE f.f2='.$_SESSION['id'].' AND f.f1=u.id AND f.actif=0');
            foreach($res as $cle){
                if(!self::isFriend($cle->id) AND !self::himself($cle->id)){
                    $html.='<div class="friend f'.$cle->id.'">';
                    $html.='<p>'.$cle->prenom.' '.$cle->nom.' - ('.self::nbCommun($cle->id).' '.(self::nbCommun($cle->id)>1 ? 'amis' : 'ami').' en commun) ';
                    $html.='<span style="font-size:1.2em;text-decoration:underline;cursor:pointer;color:blue;" onclick="accepter('.$cle->id.')">Accepter</span> - ';
                    $html.='<span style="font-size:1.2em;text-decoration:underline;cursor:pointer;color:red;" onclick="supprimer('.$cle->id.')">Refuser</span></p>';
                    $html.='</div>';
                }
            }
            return $html;
        }
        
        public static function liste_friends(){
            $html='';
            $res=Db::queryObject('SELECT u.id id, u.prenom prenom, u.nom nom, u.mail mail FROM utilisateur u, friend f WHERE f.f2='.$_SESSION['id'].' AND f.f1=u.id AND f.actif=1 ORDER BY prenom, nom');
            foreach($res as $cle){
                if(self::isFriend($cle->id) AND !self::himself($cle->id)){
                    $html.='<div class="friend">';
                    $html.='<p><a href="profil.php?f='.$cle->id.'&v='.self::get_last_friend_video_id($cle->id).'" title="Aller sur le profil">'.$cle->prenom.' '.$cle->nom.'</a> - ';
                    $html.='<span onmouseover="lister('.$cle->id.')">('.self::nbCommun($cle->id).' '.(self::nbCommun($cle->id)>1 ? 'amis' : 'ami').' en commun)</span>';
                    $html.='<span title="Supprimer l\'ami" style="cursor:pointer;" onclick="supprimer('.$cle->id.')">';
                    $html.='<img style="width:10px;height:10px;" src="images/site/fermer.png" alt="supprimer"></span></p>';
                    $html.='</div>';
                }
            }
            return $html;
        }
        
        public static function all_friends_videos(){
            $html='';
            $res=Db::queryObject('SELECT u.id id, u.prenom prenom, u.nom nom, v.nom vid, v.date date, v.titre titre, v.id vide  
                                 FROM utilisateur u, friend f, video v 
                                 WHERE f.f2='.$_SESSION['id'].' 
                                 AND f.f1=u.id 
                                 AND f.actif=1
                                 AND v.id_util=u.id 
                                 ORDER BY v.id DESC');
            foreach($res as $cle){
                if(self::isFriend($cle->id) AND !self::himself($cle->id)){
                    $html.='<div class="friend">';
                    $html.='<div class="timi"><u>Auteur</u> :<a href="profil.php?f='.$cle->id.'&v='.$cle->vide.'" title="Aller sur le profil">'.$cle->prenom.' '.$cle->nom.'</a>';
                    $html.='<br><u>Titre</u> : '.$cle->titre. '<br>';
                    $html.='<span style="font-size:0.8em;"><i>Publiée le '.date('d/m/Y', $cle->date).'</i></span></div><div class="timi2">';
                    $html.= Player::mini_friend_player($cle->vid, $cle->vide, $cle->id);
                    $html.='</div><br style="clear:both;"></div><br>';
                }
            }
            return $html;
        }
        
        //////////////////////////////////////////////////////////////////
        //      Fonctions pour générer les vidéos du profil d'un ami    //
        //////////////////////////////////////////////////////////////////
        public static function get_last_friend_video_id($friend){
            $res=Db::querySingle('SELECT id FROM video WHERE id_util='.$friend.' ORDER BY id DESC LIMIT 1');
            return isset($res->id) ? $res->id : 0;
        }
        
        public static function get_friend_titre($friend, $video){
            if(self::isFriend($friend)){
                $res=Db::querySingle('SELECT titre FROM video WHERE id='.$video);
                return isset($res->titre) ? $res->titre : '';
            }else return 'Vous n\'êtes pas amis !';            
        }
        
        public static function get_friend_video($friend, $video){
            if(self::isFriend($friend)){
                $res=Db::querySingle('SELECT nom FROM video WHERE id='.$video);
                return isset($res->nom) ? Player::getPlayer($res->nom) : '';
            }else return 'Vous n\'êtes pas amis !';
        }
        
        public static function get_friend_other_video($friend, $video){
            if(self::isFriend($friend)){
                $html='';
                $didi=Db::queryObject('SELECT nom, id FROM video WHERE id!='.$video.' AND id_util='.$friend.' ORDER BY id DESC');
                if(isset($didi[0]->nom)){
                    foreach($didi as $cle){
                        $html.=Player::mini_friend_player($cle->nom, $cle->id, $friend);
                    }
                }
                return $html;
            }else return 'Vous n\'êtes pas amis !';
        }
    };
?>