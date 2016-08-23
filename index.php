<?php
    session_start();
    $id_page=1;
    $_SESSION=array();
    $log=true; $activation=true;
    require_once('autoload.php');
    if(isset($_POST['mail']) AND isset($_POST['pass'])){
	$_POST=Secu::secuEntreeBDD($_POST);
	$rep=Db::querySingle('SELECT * FROM utilisateur WHERE mail=\''.$_POST['mail'].'\'');
	if(isset($rep->pass) AND $_POST['pass'] == $rep->pass AND $rep->actif==1){
	    $_SESSION['id']=$rep->id;$_SESSION['mail']=$rep->mail;
	    $_SESSION['pass']=$rep->pass;$_SESSION['id']=$rep->id;
	    $_SESSION['nom']=$rep->nom;$_SESSION['prenom']=$rep->prenom;
	    $_SESSION['shopy']=$rep->shopy;
	    header('location:profil.php');
	    exit;
	}else if(isset($rep->actif) AND $rep->actif==0){
	    $activation=false;
	    confirmMail($rep->mail, $rep->prenom, $rep->nom);
	}else{
	    $log=false;
	}
    }
    
    $confirme=false;
    if(isset($_GET['get']) AND !empty($_GET['get'])) $confirme = true;
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
	    <h1>Bienvenue sur Dauby Tube !</h1>
	    <div id="form">
		<h2>Connexion :</h2>
		<form method="post">
		    <p class="pform"><label for="mail">E-mail :</label><input type="text" name="mail" value="<?php if(isset($_POST['mail'])) echo $_POST['mail']; ?>"></p>
		    <p class="pform"><label for="pass">Password :</label><input type="password" name="pass" value="<?php if(isset($_POST['pass'])) echo $_POST['pass']; ?>"></p>
		    <p class="pform"><label>
			<?php if(!$log) echo 'Mauvais mail/password.'; ?>
		    </label><input type="submit" value="Connexion"></p>
		</form>
		<?php if(!$log) echo '<br><a style="color:blue;text-decoration:underline;" href="passwd-retrieve.php">Mot de passe perdu ?</a>'; ?>
	    </div>
	    <div id="pas_inscrit">
		<?php if($confirme) echo '<p>Votre confirmation a bien été prise en compte, vous pouvez désormais vous connecter</p>';
		elseif(!$activation) echo '<p>Votre compte et enregistré mais pas encore confirmé, allez voir vos mails.</p>';
		else echo '<br><br><h2><a style="color:blue;text-decoration:underline;" href="enregistrement.php">Pas encore inscrit ?</a></h2>';
		?>		
	    </div>
	</div>
	<!--script src="js/detect_browser.js"></script-->
    </body>
</html>
