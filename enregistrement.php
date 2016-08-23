<?php
    session_start();
    $_SESSION=array();
    $id_page=2;    
    require_once('autoload.php');
    $confirmationpass=true; $complet=true;
    $inscrit=false;
    if(isset($_POST['nom']) AND isset($_POST['prenom']) AND isset($_POST['pass']) AND isset($_POST['pass2']) AND isset($_POST['mail'])){
        if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['pass']) AND !empty($_POST['pass2']) AND !empty($_POST['mail'])){
            require_once('autoload.php');
            $_POST=Secu::secuEntreeBDD($_POST);
            if($_POST['pass'] == $_POST['pass2']){
                Db::query('INSERT INTO utilisateur (pass, ip, date, nom, prenom, mail, shopy) 
                           VALUES(\''.$_POST['pass'].'\', \''.$_SERVER['REMOTE_ADDR'].'\', 
                           \''.(date('d/m/Y')).'\', \''.$_POST['nom'].'\', \''.$_POST['prenom'].'\', 
                           \''.$_POST['mail'].'\', \''.time().randy().'\')');
		$last=mysql_insert_id();
		Db::query('INSERT INTO timeline (id_util) VALUES ('.$last.')');
		confirmMail($_POST['mail'], $_POST['prenom'], $_POST['nom']);
                $inscrit=true;
            }else{
                $confirmationpass=false;
            }
        }else $complet=false;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('includes/header.php'); ?>
    </head>
    <body>
    <header>
	
    </header>
	<div id="site">
	    <?php require_once('includes/nav_barre.php'); ?>
	    <h1>Formulaire d'inscription</h1>
	    <div id="form" style="height: 500px;">
		<form method="post" action="enregistrement.php">
		    <p class="pform"><label for="prenom">Prénom :</label><input type="text" name="prenom" value="<?php if(isset($_POST['prenom'])) echo $_POST['prenom']; ?>"></p>
		    <p class="pform"><label for="nom">Nom :</label><input type="text" name="nom" value="<?php if(isset($_POST['nom'])) echo $_POST['nom']; ?>"></p>
		    <p class="pform"><label for="mail">E-mail :</label><input type="text" name="mail" value="<?php if(isset($_POST['mail'])) echo $_POST['mail']; ?>"></p>		
		    <p class="pform"><label for="pass">Password :</label><input type="password" name="pass"></p>
		    <p class="pform"><label for="pass"> Confirm password :</label><input type="password" name="pass2"></p>
		    <?php if(!$confirmationpass) echo '<p><label></label>Mauvaise confirmation de mot de passe</p>'; ?>
		    <p class="pform"><label></label><input type="submit" value="Enregistrement"></p>
		</form>
            <?php if($inscrit) echo '<p>Vous devez désormais confirmer votre inscription en allant voir vos mails.</p>';
                if(!$complet) echo '<p>Formulaire incomplet.</p>'; ?>
		<p>
		    <h3>Conditions d'utilisation :</h3>
		    Vous disposez légalement de 500Mo de stockage disponible sur Dauby Tube à votre inscription.<br>
		    Toute vidéo à caractère pornographique sera directement supprimée et le compte de l'utilisateur<br>
		    banni à vie.
		</p>
	    </div>
	</div>
    </body>
</html>