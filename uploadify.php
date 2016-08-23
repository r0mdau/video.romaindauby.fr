<?php
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	
	$targetPath = '/var/www/video/stock/';
	
	$db=mysql_connect('localhost', 'root', 'rom0991');
	mysql_select_db('video', $db);
	mysql_query("SET NAMES UTF8");
	
	/****************************************************************************************/
	/*fonction pour supprimer les accents des noms des photos********************************/
	function suppr_accents($str){
        $avant = array('À','Á','Â','Ã','Ä','Å','Ā','Ă','Ą','Ǎ','Ǻ','Æ','Ǽ','Ç','Ć','Ĉ','Ċ','Č','Ð','Ď','Đ','É','È','Ê','Ë','Ē','Ĕ','Ė','Ę','Ě','Ĝ','Ğ','Ġ','Ģ','Ĥ','Ħ','Ì','Í','Î','Ï','Ĩ','Ī','Ĭ','Į','İ','ĺ','ļ','ľ','ŀ','ł','Ǐ','Ĳ','Ĵ','Ķ','Ĺ','Ļ','Ľ','Ŀ','Ł','Ń','Ņ','Ň','Ñ','Ò','Ó','Ô','Õ','Ö','Ō','Ŏ','Ő','Ơ','Ǒ','Ø','Ǿ','Œ','Ŕ','Ŗ','Ř','Ś','Ŝ','Ş','Š','Ţ','Ť','Ŧ','Ũ','Ù','Ú','Û','Ü','Ū','Ŭ','Ů','Ű','Ų','Ư','Ǔ','Ǖ','Ǘ','Ǚ','Ǜ','Ŵ','Ý','Ŷ','Ÿ','Ź','Ż','Ž','à','á','â','ã','ä','å','ā','ă','ą','ǎ','ǻ','æ','ǽ','ç','ć','ĉ','ċ','č','ď','đ',	'è','é','ê','ë','ē','ĕ','ė','ę','ě','ĝ','ğ','ġ','ģ','ĥ','ħ','ì','í','î','ï','ĩ','ī','ĭ','į','ı','ǐ','ĳ','ĵ','ķ',	'ñ','ń','ņ','ň','ŉ','ò','ó','ô','õ','ö','ō','ŏ','ő','ơ','ǒ','ø','ǿ','œ','ŕ','ŗ','ř','ś','ŝ','ş','š','ß','ţ','ť','ŧ','ù','ú','û','ü','ũ','ū','ŭ','ů','ű','ų','ǔ','ǖ','ǘ','ǚ','ǜ','ư','ŵ','ý','ÿ','ŷ','ź','ż','ž','ƒ','ſ');
        $apres = array('A','A','A','A','A','A','A','A','A','A','A','AE','AE','C','C','C','C','C','D','D','D','E','E','E','E','E','E','E','E','E','G','G','G','G','H','H','I','I','I','I','I','I','I','I','I','I','I','I','I','I','I','IJ','J','K','L','L','L','L','L','N','N','N','N','O','O','O','O','O','O','O','O','O','O','O','O','OE','R','R','R','S','S','S','S','T','T','T','U','U','U','U','U','U','U','U','U','U','U','U','U','U','U','U','W','Y','Y','Y','Z','Z','Z','a','a','a','a','a','a','a','a','a','a','a','ae','ae','c','c','c','c','c','d','d','e','e','e','e','e','e','e','e','e','g','g','g','g','h','h','i','i','i','i','i','i','i','i','i','i','ij','j','k','n','n','n','n','n','o','o','o','o','o','o','o','o','o','o','o','o','oe','r','r','r','s','s','s','s','s','t','t','t','u','u','u','u','u','u','u','u','u','u','u','u','u','u','u','u','w','y','y','y','z','z','z','f','s');
        return str_replace($avant, $apres, $str);
	}
	function siglereduit($texte){
		$val1 = suppr_accents(str_replace('-','-',$texte)); $val2 = str_replace(' ','-',$val1); $val3 = str_replace('\'','-',$val2);
		$val4 = str_replace('.','-',$val3); $val5 = str_replace(':','-',$val4); $val6 = str_replace('&','',$val5); $val7 = str_replace('---','-',$val6);
		$valeur = str_replace(',','',$val7);
		return strtolower($valeur);
	}
	function randy()
	{
	    return sprintf( '%04x%04x%04x%04x%04x%04x%04x%04x',
		mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
		mt_rand( 0, 0x0fff ) | 0x4000,
		mt_rand( 0, 0x3fff ) | 0x8000,
		mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ) );
	}
	function espace($id){
		$taille=0;
		$rep=mysql_query('SELECT taille FROM video WHERE id_util='.$id);
		while($don=mysql_fetch_assoc($rep)){
			$taille+=$don['taille'];
		}
		$fin=500000000-$taille-$_FILES['Filedata']['size'];
		return $fin > 0;
	}
	function get_id($id){
		$req=mysql_query('SELECT id FROM utilisateur WHERE shopy=\''.$id.'\'');
		$don=mysql_fetch_assoc($req);
		return $don['id'];
	}
	/*****************************************************************************************/

	$_FILES['Filedata']['name'] = strtolower($_FILES['Filedata']['name']);
	$nom_picture=$_FILES['Filedata']['name'];
	
	$extension=strrchr($nom_picture, ".");
	if($extension == ".mov")
	{$nom_photos = str_replace('-mov', '.mov', siglereduit($nom_picture));}
	elseif($extension == ".m4v")
	{$nom_photos = str_replace('-m4v', '.m4v', siglereduit($nom_picture));}
	elseif($extension == ".mp4")
	{$nom_photos = str_replace('-mp4', '.mp4', siglereduit($nom_picture));}
	elseif($extension == ".avi")
	{$nom_photos = str_replace('-avi', '.avi', siglereduit($nom_picture));}
	elseif($extension == ".ogv")
	{$nom_photos = str_replace('-ogv', '.ogv', siglereduit($nom_picture));}
	
	$nom_photos=randy().$nom_photos;
	
	$targetFile =  str_replace('//','/',$targetPath) . $nom_photos;
	
	// $fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
	// $fileTypes  = str_replace(';','|',$fileTypes);
	// $typesArray = split('\|',$fileTypes);
	// $fileParts  = pathinfo($_FILES['Filedata']['name']);
	
	// if (in_array($fileParts['extension'],$typesArray)) {
		// Uncomment the following line if you want to make the directory if it doesn't exist
		//mkdir(str_replace('//','/',$targetPath), 0755, true);
		

		if(espace(get_id($_GET['id']))){
			if(move_uploaded_file($tempFile,$targetFile))
				mysql_query('INSERT INTO video (id_util, taille, nom, date) VALUES('.(int)get_id($_GET['id']).', \''.$_FILES['Filedata']['size'].'\', \''.$nom_photos.'\', '.time().')');
		}
		
		echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
		
		
	
		
		
	// } else {
	// 	echo 'Invalid file type.';
	// }
}
?>