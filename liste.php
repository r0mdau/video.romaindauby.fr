<?php
    session_start();
    $id_page=6;
    if(!isset($_SESSION['mail'])) {header('location:index.php');exit;}
    require_once('autoload.php');
    $html='';
    $_POST=Secu::secuEntreeBDD($_POST);    
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
	    <?php require_once('includes/nav_barre.php'); ?>
	    <h1>Recherche d'amis</h1>
	    <div id="friend">
                <?php                    
                    echo Friend::liste($_GET['m']);
                ?>
            </div>
	</div>
        <?php
	    if(isset($_GET['m'])){
		?><script>
		    $(document).ready(function(){
			$('input[id="search"]').val('<?php echo $_GET['m']; ?>');
		    });
		</script><?php
	    }
        ?>
	<script src="js/ajouter.js"></script>
    </body>
</html>