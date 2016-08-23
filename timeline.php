<?php
    session_start();
    $id_page=4;
    if(!isset($_SESSION['mail'])) header('location:index.php');
    require_once('autoload.php');
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
	    <h1>Fil d'actualité</h1>
	    <div id="friend">
		<?php
		    Timeline::remise_zero_notif();
		    if(Friend::countFriends() == 0)
			echo '<br><p>Vous n\'avez pas encore d\'amis, ajoutez-en pour suivre les dernières vidéos qu\'ils publient.</p>';
		    else
			echo Friend::all_friends_videos();
		?>
	    </div>
	</div>
    </body>
</html>