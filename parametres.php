<?php
    session_start();
    $id_page=8;
    require_once('autoload.php');
    $res=Param::get_infos_compte();
    $confirmationpass=false;
    if(isset($_POST['prenom']) AND isset($_POST['nom']) AND isset($_POST['mail']) AND isset($_POST['pass']) AND isset($_POST['pass2'])){
	if($_POST['pass']==$_POST['pass2']){
	    $confirmationpass='';
	    if(!empty($_POST['prenom']))
		if(!Db::query('UPDATE utilisateur SET prenom=\''.$_POST['prenom'].'\' WHERE id='.$_SESSION['id'])) $confirmationpass.='<p>Erreur, prénom vide</p>';
	    if(!empty($_POST['nom']))
		if(!Db::query('UPDATE utilisateur SET nom=\''.$_POST['nom'].'\' WHERE id='.$_SESSION['id'])) $confirmationpass.='<p>Erreur, nom vide</p>';
	    if(!empty($_POST['mail']))
		if(!Db::query('UPDATE utilisateur SET mail=\''.$_POST['mail'].'\' WHERE id='.$_SESSION['id'])) $confirmationpass.='<p>Erreur, mail vide</p>';
	    if(!empty($_POST['pass']))
		if(!Db::query('UPDATE utilisateur SET pass=\''.$_POST['pass'].'\' WHERE id='.$_SESSION['id'])) $confirmationpass.='<p>Erreur, mot de passe vide</p>';
	}else $confirmationpass='<p>Mauvaise confirmation de mot de passe</p>';
    }
    
    $erreur=false;
    if(isset($_POST['passy'])){
	if(isset($_POST['supprimer'])){
	    $_POST=Secu::s($_POST);
	    $rep=Db::querySingle('SELECT * FROM utilisateur WHERE id='.$_SESSION['id']);
	    if($_POST['passy'] == $rep->pass){
		if(Param::supprimer_compte()){
		    header('location:../index.php');
		    exit;
		}else $erreur='<p style="color:red;">Erreur lors de la suppression de votre compte. Veuillez contacter le webmaster à l\'adresse contact@romaindauby.fr</p>';
	    }else $erreur='<p style="color:red;">Mauvais mot de passe pour la suppression de votre compte.</p>';
	}else $erreur='<p style="color:red;">Vous n\'avez pas cosé la case de confirmation de suppression de votre compte.</p>';
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
	    <h1>Paramètres de <?php echo Friend::get_name($_SESSION['id']); ?></h1>
	    <div id="friend">
	    <div id="form" style="height: 450px;">
		<form name="d" method="post">
		    <p class="pform"><label for="prenom">Prénom :</label><input type="text" name="prenom" value="<?php if(isset($res->prenom)) echo $res->prenom; ?>"></p>
		    <p class="pform"><label for="nom">Nom :</label><input type="text" name="nom" value="<?php if(isset($res->nom)) echo $res->nom; ?>"></p>
		    <p class="pform"><label for="mail">E-mail :</label><input type="text" name="mail" value="<?php if(isset($res->mail)) echo $res->mail; ?>"></p>		
		    <p class="pform"><label for="pass">Password :</label><input type="password" name="pass"></p>
		    <p class="pform"><label for="pass2"> Confirm password :</label><input type="password" name="pass2"></p>
		    <?php if($confirmationpass!=false) echo $confirmationpass; ?>
		    <p class="pform"><label></label><input type="submit" value="Modifier"></p>
		</form>
	    </div><br><hr><br>
		<form name="e" method="post" onsubmit="confirm('Souhaitez vous réellement supprimer votre compte et les vidéos qui sont associées ?')">
		    <input type="checkbox" name="supprimer">Supprimer son compte :<br>
		    Mot de passe :<input type="password" name="passy">
		    <input type="submit" value="Supprimer">
		</form>
		<?php
		    if($erreur!=false) echo $erreur;
		?>
	    </div>
	</div>
    </body>
</html>