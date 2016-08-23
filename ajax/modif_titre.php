<?php
    session_start();
    if(!isset($_SESSION['mail'])) die;
    require_once('../autoload.php');
    $_POST=Secu::s($_POST);
    if(isset($_POST['titre']) AND isset($_POST['id'])){
        if(!empty($_POST['titre'])){
            Player::modifier_titre($_POST['id'], $_POST['titre']);
        }else{
            Player::modifier_titre($_POST['id'], 'Ajouter un titre.');
        }
    }
    header('location:../profil.php?v='.$_POST['id']);
    exit;
?>