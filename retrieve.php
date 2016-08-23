<?php
    session_start();
    require_once('autoload.php');
    $pass = true; $ma = true;
    if(isset($_GET['randy']) AND !empty($_GET['randy'])){
        $res=Db::querySingle('SELECT mail FROM password WHERE alea=\''.$_GET['randy'].'\'');
	if(!isset($res->mail)) die;
        $_SESSION['mail'] = $res->mail;
    }else die;
    if(isset($_POST['mail']) && isset($_POST['pass']) && isset($_POST['pass2']) && !empty($_POST['mail']) && !empty($_POST['pass'])){
        if($_POST['pass'] == $_POST['pass2']){
            if($_POST['mail'] == $_SESSION['mail']){
                Db::query('UPDATE utilisateur SET pass=\''.$_POST['pass'].'\' WHERE mail = \''.$_SESSION['mail'].'\'');
                Db::query('DELETE FROM password WHERE mail=\''.$_SESSION['mail'].'\'');
		confirmRetrievePasswd($_SESSION['mail']);
                $_SESSION = array();
                header('location:/');
            }else $ma = false;
        }else $pass = false;
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
	    <h1>Bienvenue sur Dauby Tube !</h1>
	    <div id="form">
		<h2>Changer mot de passe :</h2>
		<form method="post">
		    <p class="pform"><label for="mail">E-mail :</label><input type="text" name="mail" value="<?php if(isset($res->mail)) echo $res->mail; ?>"></p>
		    <p class="pform"><label for="pass">Password :</label><input type="password" name="pass" value="<?php if(isset($_POST['pass'])) echo $_POST['pass']; ?>"></p>
                    <p class="pform"><label for="pass">Confirm :</label><input type="password" name="pass2" value="<?php if(isset($_POST['pass2'])) echo $_POST['pass2']; ?>"></p>
		    <p class="pform"><label>
		    </label><input type="submit" value="Envoyer"></p>
		</form>
		<?php
                    if(!$pass) echo '<br>Les deux mots de passe ne correspondent pas, veuillez recommencer.';
                    else if(!$ma) echo '<br>La demande de modification de mot de passe ne concerne pas l\'adresse mail que vous venez d\'entrer !!!';
                ?>
	    </div>
	</div>
	<script src="js/detect_browser.js"></script>
    </body>
</html>