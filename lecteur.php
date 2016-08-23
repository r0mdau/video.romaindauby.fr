<?php
    session_start();
    $id_page=7;
    require_once('autoload.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('includes/header.php'); ?>
        <script src="http://code.jquery.com/jquery-latest.pack.js"></script>
    </head>
    <body>
	<header>
	    
	</header>
	<div id="site">
            <?php require_once('includes/nav_barre.php'); ?>
            <h1>
                <?php
                    if(isset($_SESSION['mail'])) echo 'Lecteur';
                    else echo Player::getTitreN($_GET['v']);
                ?>
            </h1>
	    <?php
                if(isset($_GET['v']) AND !empty($_GET['v'])){
                    echo Player::getLargePlayer($_GET['v']);
                    if(isset($_SESSION['mail'])) echo '<p>Vous pouvez partager le lien de cette page pour partager cette vidéo avec tout le monde, même les non-inscrits</p>';
                }
            ?>
	</div>
        <script type="text/javascript">
            $("#central").dblclick(function(){
                $("header").before($("#central"));
                $("#central").attr("width", $(window).width()).attr("height", $(window).height());
                $('#site').css('top', $(window).height()+'px')
                $('.nav_button').css('top', '40px');
                $(document).keyup(function(event){
                    if(event.keyCode == 27){
                        $("#contenu").after($("#central"));
                        $("#central").css("margin", "0px 0 0 0px").attr("width", "590");
                        $('#site').css('top', '40px')
                    }
                });
            });
        </script>
    </body>
</html>