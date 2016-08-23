<?php
    $id_page=1; $exist = true; $send = false; $param = false;
    require_once('autoload.php');
    if(isset($_POST['mail']) && !empty($_POST['mail'])){
	if(Param::mailExist($_POST['mail'])){
	    if(Param::nbRetrive($_POST['mail']) < 5){
		Param::sendMailRetrievePassword($_POST['mail']);
		$send = true;
	    }else $param = true;
	}else $exist=false;
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
		<h2>Récupérer son mot de passe :</h2>
		<form method="post">
		    <p class="pform"><label for="mail">E-mail :</label><input type="text" name="mail" value="<?php if(isset($_POST['mail'])) echo $_POST['mail']; ?>"></p>		    
		    <p class="pform"><label></label><input type="submit" value="Envoyer"></p>
		</form>
	    </div>
	    <div id="pas_inscrit">
		<?php
		    if(!$exist) echo '<br><br><h2><a style="color:blue;text-decoration:underline;" href="/enregistrement">Pas encore inscrit ?</a></h2>';
		    else if($send) echo '<br><br><h2>Mot de passe bien envoyé, allez voir vos mails</h2><p>Regardez eventuellement dans le spam.</p>';
		    else if ($param) echo '<br><br><h2>Vous avez fait trop de tentatives de demandes de changement de mot de passe<br>Veuillez contacter l\'administrateur du site.</h2>';
		?>		
	    </div>
	</div>
	<script src="/js/detect_browser.js"></script>
    </body>
</html>
