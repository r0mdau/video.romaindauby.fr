<?php
    function confirmMail($mail, $prenom, $nom){
        $get=randy();
        Db::query('INSERT INTO password (alea, mail) VALUES (\''.$get.'\', \''.$mail.'\')');
        
        $from  = "From:contact@daubytube.com\n";
        $from .= "MIME-version: 1.0\n";
        $from .= "Content-type: text/html; charset= iso-8859-1\n";
        
        $nomCompose='<h3>Bonjour '.$prenom.' '.$nom.'</h3><br><br> Cliquez sur le lien ci-dessous pour activer votre compte Dauby Tube :<br><br>';
        $nomCompose.='<a href="http://video.romaindauby.fr/confirm.php?randy='.$get.'">Confirmation inscription Dauby Tube</a><br><br> Cordialement,<br>';
        $nomCompose.='<u><a href="http://www.romaindauby.fr">Romain Dauby</a></u>.';
        
        mail($mail, 'Confirmation d\'inscription Dauby Tube', $nomCompose, $from);
    }
    
    function randy()
    {
        return sprintf('%04x%04x%04x%04x%04x%04x%04x%04x',
                        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
                        mt_rand( 0, 0x0fff ) | 0x4000,
                        mt_rand( 0, 0x3fff ) | 0x8000,
                        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ) );
    }
    
    function retrievePasswd($mail, $nom){
        $get=randy();
        Db::query('INSERT INTO password (alea, mail) VALUES (\''.$get.'\', \''.$mail.'\')');
        
        $from  = "From:contact@daubytube.com\n";
        $from .= "MIME-version: 1.0\n";
        $from .= "Content-type: text/html; charset= iso-8859-1\n";
        
        $nomCompose='<h3>Bonjour '.$nom.'</h3><br><br> Cliquez sur le lien ci-dessous pour changer le mot de passe de votre compte Dauby Tube :<br><br>';
        $nomCompose.='<a href="http://video.romaindauby.fr/retrieve.php?randy='.$get.'">Changement mot de passe Dauby Tube</a><br><br> Cordialement,<br>';
        $nomCompose.='<u><a href="http://www.romaindauby.fr">Romain Dauby</a></u>.';
        
        mail($mail, 'Changement mot de passe Dauby Tube', $nomCompose, $from);
    }
    
    function confirmRetrievePasswd($mail){
        $from  = "From:contact@daubytube.com\n";
        $from .= "MIME-version: 1.0\n";
        $from .= "Content-type: text/html; charset= iso-8859-1\n";
        
        $nomCompose='<h3>Bonjour,<br><br>Nous vous confirmons que votre mot de passe sur Dauby Tube a bien été modifié<br><br>';
        $nomCompose.='Cordialement,<br>';
        $nomCompose.='<u><a href="http://www.romaindauby.fr">Romain Dauby</a></u>.';
        
        mail($mail, 'Changement mot de passe Dauby Tube', $nomCompose, $from);
    }  
?>