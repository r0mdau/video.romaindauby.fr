<?php
    class Secu
    {
        private static $db;
        private static $hashi;
        
        //Sécurise toutes les valeurs d'un tableau meme si celui-ci contient des tableaux
        private static function parcourirTableauSecu($tableau, $fonction)
        {
            foreach($tableau as $val=>$key)
            {
                if(is_array($val))
                    self::parcourirTableauSecu($val, $fonction);
                else
                    $tableau[$val]=$fonction($key);
            }
            return $tableau;
        }
        
        private static function parcourirTableauHash($tableau, $fonction)
        {
            foreach($tableau as $val=>$key)
            {
                if(is_array($val))
                    self::parcourirTableauHash($val, $fonction);
                else
                    $tableau[$val]=hash($fonction, $key);
            }
            return $tableau;
        }
        
        private static function parcourirTableauParam($tableau, $fonction, $param)
        {
            foreach($tableau as $val=>$key)
            {
                if(is_array($val))
                    self::parcourirTableauParam($val, $fonction, $param);
                else
                    $tableau[$val]=$fonction($key, $param);
            }
            return $tableau;
        }
        
        ///////////////////////////////////////////////////////////////////////////////////////
        // Travaux sur les chaînes de caractères
        ///////////////////////////////////////////////////////////////////////////////////////
        public static function secuEntreeBDD($tab)
        {
            self::$db=Db::connect();
            $tab=self::secuMySql($tab);
            $tab=self::secuCslashes($tab);
            self::$db=Db::disconnect();
            return $tab;
        }
        
        public static function s($tab){
            return self::secuEntreeBDD($tab);
        }
        
        public static function secuCslashes($tableau)
        {
            if(is_array($tableau))
                $tableau=self::parcourirTableauParam($tableau, 'addcslashes', '%_');
            else
                $tableau=addcslashes($tableau, '%_');
            return $tableau;
        }
        
        public static function secuMySql($tableau)
        {
            if(is_array($tableau))
                $tableau=self::parcourirTableauSecu($tableau, 'mysql_real_escape_string');
            else
                $tableau=mysql_real_escape_string($tableau);
            return $tableau;
        }
        
        //htmlspecialchars() est pratique pour éviter que des données fournies par les utilisateurs contiennent des balises HTML
        public static function secuBalisesHtml($tab)
        {
            if(is_array($tab))
                $tab=self::parcourirTableauSecu($tab, 'htmlspecialchars');
            else
                $tab=htmlspecialchars($tab);
            return $tab;
        }
        ///////////////////////////////////////////////////////////////////////////////////////
        // Expressions régulières.
        ///////////////////////////////////////////////////////////////////////////////////////
        public static function regexMail($mail)
        {
            return preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $mail);
        }
        
        public static function regexTelephone($tel)
        {
            return preg_match("#^0[1-9]([-. ]?[0-9]{2}){4}$#", $mail);
        }
        
        ///////////////////////////////////////////////////////////////////////////////////////
        // Cryptage
        ///////////////////////////////////////////////////////////////////////////////////////
        public static function hashSingle($fct, $chaine)
        {
            if(in_array($fct, self::$hashi))
                return hash($fct, $chaine);
            else
                return "Ne peut pas être hashé !";
        }
        
        public static function hashVar($fct, $tab)
        {
            // $hashi contient le tableau des algorithmes existants pour la fonction hash sous forme de chaines
            if(in_array($fct, $hashi))
            {
                if(is_array($tab))
                {
                    $tab=self::parcourirTableauHash($tab, $fct);
                }
                else
                    $tab=hash($fct, $tab);
                return $tab;
            }
            else
                return "Fonction de hash non connue !";
        }
        
        ///////////////////////////////////////////////////////////////////////////////////////
        // Suppression d'accents/espaces pour les nom de fichiers
        ///////////////////////////////////////////////////////////////////////////////////////
	public static function suppr_accents($str){
            $avant = array('À','Á','Â','Ã','Ä','Å','Ā','Ă','Ą','Ǎ','Ǻ','Æ','Ǽ','Ç','Ć','Ĉ','Ċ','Č','Ð','Ď','Đ','É','È','Ê','Ë','Ē','Ĕ','Ė','Ę','Ě','Ĝ','Ğ','Ġ','Ģ','Ĥ','Ħ','Ì','Í','Î','Ï','Ĩ','Ī','Ĭ','Į','İ','ĺ','ļ','ľ','ŀ','ł','Ǐ','Ĳ','Ĵ','Ķ','Ĺ','Ļ','Ľ','Ŀ','Ł','Ń','Ņ','Ň','Ñ','Ò','Ó','Ô','Õ','Ö','Ō','Ŏ','Ő','Ơ','Ǒ','Ø','Ǿ','Œ','Ŕ','Ŗ','Ř','Ś','Ŝ','Ş','Š','Ţ','Ť','Ŧ','Ũ','Ù','Ú','Û','Ü','Ū','Ŭ','Ů','Ű','Ų','Ư','Ǔ','Ǖ','Ǘ','Ǚ','Ǜ','Ŵ','Ý','Ŷ','Ÿ','Ź','Ż','Ž','à','á','â','ã','ä','å','ā','ă','ą','ǎ','ǻ','æ','ǽ','ç','ć','ĉ','ċ','č','ď','đ',	'è','é','ê','ë','ē','ĕ','ė','ę','ě','ĝ','ğ','ġ','ģ','ĥ','ħ','ì','í','î','ï','ĩ','ī','ĭ','į','ı','ǐ','ĳ','ĵ','ķ',	'ñ','ń','ņ','ň','ŉ','ò','ó','ô','õ','ö','ō','ŏ','ő','ơ','ǒ','ø','ǿ','œ','ŕ','ŗ','ř','ś','ŝ','ş','š','ß','ţ','ť','ŧ','ù','ú','û','ü','ũ','ū','ŭ','ů','ű','ų','ǔ','ǖ','ǘ','ǚ','ǜ','ư','ŵ','ý','ÿ','ŷ','ź','ż','ž','ƒ','ſ');
            $apres = array('A','A','A','A','A','A','A','A','A','A','A','AE','AE','C','C','C','C','C','D','D','D','E','E','E','E','E','E','E','E','E','G','G','G','G','H','H','I','I','I','I','I','I','I','I','I','I','I','I','I','I','I','IJ','J','K','L','L','L','L','L','N','N','N','N','O','O','O','O','O','O','O','O','O','O','O','O','OE','R','R','R','S','S','S','S','T','T','T','U','U','U','U','U','U','U','U','U','U','U','U','U','U','U','U','W','Y','Y','Y','Z','Z','Z','a','a','a','a','a','a','a','a','a','a','a','ae','ae','c','c','c','c','c','d','d','e','e','e','e','e','e','e','e','e','g','g','g','g','h','h','i','i','i','i','i','i','i','i','i','i','ij','j','k','n','n','n','n','n','o','o','o','o','o','o','o','o','o','o','o','o','oe','r','r','r','s','s','s','s','s','t','t','t','u','u','u','u','u','u','u','u','u','u','u','u','u','u','u','u','w','y','y','y','z','z','z','f','s');
            return str_replace($avant, $apres, $str);
	}
        
	public static function siglereduit($texte){
            $val1 = self::suppr_accents(str_replace('-','-',$texte)); $val2 = str_replace(' ','-',$val1); $val3 = str_replace('\'','-',$val2);
            $val4 = str_replace('.','-',$val3); $val5 = str_replace(':','-',$val4); $val6 = str_replace('&','',$val5); $val7 = str_replace('---','-',$val6);
            $valeur = str_replace(',','',$val7);
            return strtolower($valeur);
	}
        public static function extension($str){
            if(strpos($str, '-jpg')) $str.='.jpg';
            if(strpos($str, '-jpeg')) $str.='.jpeg';
            if(strpos($str, '-png')) $str.='.png';
            if(strpos($str, '-gif')) $str.='.gif';
            return $str;
        }
	/*****************************************************************************************/
    }
?>