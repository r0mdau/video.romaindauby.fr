<?php
    session_start();
    $id_page=6;
    if(!isset($_SESSION['mail'])) header('location:index.php');
    require_once('autoload.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('includes/header.php'); ?>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
    </head>
    <body>
	<header>
	    
	</header>
	<div id="site">
	    <?php
		require_once('includes/nav_barre.php');
		if(Friend::new_friend()){
		    echo '<h1>Mes demandes d\'amis</h1>';
		    echo '<div id="friend">';
		    echo Friend::liste_new_friends();
		    echo '</div>';
		}
		
		if(Friend::attente()){
		    echo '<h1>Demandes en attente</h1>';
		    echo '<div id="friend1">';
		    echo Friend::liste_attente();
		    echo '</div>';
		}
	    ?>
	    <h1>Mes amis</h1>
	    <div id="friend">
		<?php
		    if(Friend::nb_friends()>0)
			echo Friend::liste_friends();
		    else
			echo '<p>Vous n\'avez pas encore d\'amis, vous pouvez les rechercher avec la barre de recherche ci-dessus.</p>';
		?>
	    </div>
	</div>
	<div id="boite"></div>
	<script src="js/accepter.js"></script>
	<script src="js/supprimer.js"></script>
    </body>
</html>