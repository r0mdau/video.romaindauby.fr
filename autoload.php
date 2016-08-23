<?php
require_once('settings.php');
/*    if ($dh = opendir(_DIR_.'db/') AND $dhh = opendir(_DIR_.'controller/')) {
        while (($file = readdir($dh)) !== false) {
            if(strpos(strtolower($file), '.php')){
                if(!require_once(_DIR_.'db/'.$file)){
                    echo 'Erreur, un fichier n\'a pas été inclu : '.$file;
                    exit;
                }
            }
        }
        closedir($dh);
        while (($file = readdir($dhh)) !== false) {
            if(strpos(strtolower($file), '.php')){
                if(!require_once(_DIR_.'controller/'.$file)){
                    echo 'Erreur, un fichier n\'a pas été inclu : '.$file;
                    exit;
                }
            }
        }
        closedir($dhh);
    }
*/
function autoload(){
	loadDir('db/');
	loadDir('controller/');
}

function loadDir($dir){
	if ($dh = opendir(__DIR__.'/'.$dir)) {
        while (($file = readdir($dh)) !== false) {
            if(strpos($file, '.php') !== false){
                require_once(__DIR__.'/'.$dir.$file);
            }
        }
        closedir($dh);
    }
}

spl_autoload_register('autoload');
