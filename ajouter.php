<?php
    session_start();
    $id_page=5;
    if(!isset($_SESSION['mail'])) header('location:index.php');
    require_once('autoload.php');
?>
<!DOCTYPE html>
<html>
    <head>        
	<?php require_once('includes/header.php'); ?>
	<link href="./uploadify/uploadify.css" type="text/css" rel="stylesheet" />
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="./uploadify/swfobject.js"></script>
	<script type="text/javascript" src="./uploadify/jquery.uploadify.v2.1.4.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function() { 
	  $('#file_upload').uploadify({
	    'uploader'  : './uploadify/uploadify.swf',
	    'script'    : 'uploadify.php?id=<?php echo $_SESSION['shopy'] ?>',
	    'cancelImg' : './uploadify/cancel.png',
            'displayData': 'speed',
	    'fileExt'   : '*.ogv;*.m4v;*.mp4;*.avi;*.mov', 
	    'multi'     : true, 
	    'wmode'     : 'transparent', 
	    'sizeLimit' : 300000000, 
	    'auto'      : true
	  });
	});
	</script>
    </head>
    <body>
	<header>
	    
	</header>
	<div id="site">
	    <?php require_once('includes/nav_barre.php'); ?>
	    <h1>Ajouter une vidéo</h1>
	    <div id="friend">
		<?php echo Side::texte(); ?>	    
		<br>
		<?php
		    if(Side::compteur()<=0)
			echo 'Vous avez dépassé les 500 MB de stockage offerts. Si vous souhaitez en uploadé de nouvelles, vous devez supprimer des vidéos pour libérer de l\'espace.';
		    else
			echo '<input type="file" id="file_upload" name="file_upload">';
		?>	    
		<p>Nb : Taille max de 300 MB par upload.</p>
	    </div>
	</div>
    </body>
</html>