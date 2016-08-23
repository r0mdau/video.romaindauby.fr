<?php
    if(isset($_GET['randy']) AND !empty($_GET['randy'])){
        require_once('autoload.php');
        $mail=Db::querySingle('SELECT mail FROM password WHERE alea=\''.$_GET['randy'].'\'');
        Db::query('UPDATE utilisateur SET actif=1 WHERE mail=\''.$mail->mail.'\'');
        Db::query('DELETE FROM password WHERE mail=\''.$mail->mail.'\'');
        header('location:index.php?get=bon');
    }else die;