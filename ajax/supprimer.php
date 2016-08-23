<?php
    session_start();
    if(!isset($_SESSION['mail'])) die;
    require_once('../autoload.php');
    $_POST=Secu::s($_POST);
    if(Friend::supprimer($_POST['id']))
        echo 'reussi';
    else
        echo $_POST['id'];
    exit;
?>