<?php
	require_once('autoload.php');
	$res = Db::queryArray('SELECT nom FROM video');
	$tab = array();
	if($dh = opendir(_DIR_.'stock/')) {
	        while (($file = readdir($dh)) !== false) {
	            if(strpos($file, '.ogv') !== false){
			$tab[] = $file;	                
	            }
	        }
	        closedir($dh);
	}
	foreach($res as $n){
		if(!in_array(Player::getTheoraName($n['nom']), $tab)){
			//echo 'Pas dans larray ' .$n['nom']."\n";
			exec('nohup ffmpeg2theora '._DIR_.'stock/'.$n['nom'].' &');
		}
	}
?>
