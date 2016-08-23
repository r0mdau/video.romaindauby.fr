<?php
    session_start();
    $id_page=3;
    if(!isset($_SESSION['mail'])) header('location:index.php');
    require_once('autoload.php');
    if(isset($_GET['v'])) $_GET=Secu::s($_GET);
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('includes/header.php'); ?>
        <script src="http://code.jquery.com/jquery-latest.pack.js"></script>
    </head>
    <body>
	<header style="display: block;">
	    
	</header>
	<div id="site">
	    <?php
                require_once('includes/nav_barre.php');
                if(isset($_GET['f']) AND !empty($_GET['f']) AND isset($_GET['v']) AND !empty($_GET['v']))
                    echo '<h1>Player de '.Friend::get_name((int)$_GET['f']).'</h1>';
                else
                    echo '<h1>Mon player</h1>';
            ?>             
	    <div id="contenu">
                <?php
                    if(isset($_GET['f']) AND !empty($_GET['f']) AND isset($_GET['v']) AND !empty($_GET['v'])){
                        echo '<h3>'.Friend::get_friend_titre((int)$_GET['f'], (int)$_GET['v']).'</h3>';
                        echo Friend::get_friend_video((int)$_GET['f'], (int)$_GET['v']);
                    }else{
                        if(isset($_GET['v']) AND !empty($_GET['v'])){
                            echo '<h3>'.Player::getTitre((int)$_GET['v']).'</h3>';
                            echo Player::getVideo((int)$_GET['v']);
                            echo Player::modif_titre(Player::titre((int)$_GET['v']), (int)$_GET['v']);
                            echo Player::btn_suppr_video((int)$_GET['v']);
                        }else{
                            echo '<h3>'.Player::getLastTitre().'</h3>';
                            echo Player::getLastVideo();
                            if(Player::nb_video()>0)
                                echo Player::modif_titre(Player::titre());
                            echo Player::btn_suppr_last_video();
                        }                        
                    }
                ?>
            </div>
            <div id="nav">
                <?php                    
                    if(isset($_GET['f']) AND !empty($_GET['f']) AND isset($_GET['v']) AND !empty($_GET['v'])){
                        echo Friend::get_friend_other_video((int)$_GET['f'], (int)$_GET['v']);
                    }else{
                        echo Side::boiteCompteur();
                        if(isset($_GET['v']) AND !empty($_GET['v']))
                            echo Player::getOtherVideos((int)$_GET['v']);
                        else
                            echo Player::getAllVideos();
                    }
                ?>
            </div>
            <span style="clear: both;"></span>
	</div>
        <!--script type="text/javascript">
            $("#central").dblclick(function(){
                $("header").before($("#central"));
                $("#central").attr("width", $(window).width()).attr("height", $(window).height());
                $('#site').css('top', $(window).height()+'px');
                $('.nav_button').css('top', '40px');
                $(document).keyup(function(event){
                    if(event.keyCode == 27){
                        $("#contenu").after($("#central"));
                        $("#central").css("margin", "0px 0 0 0px").attr("width", "590");
                        $('#site').css('top', '40px')
                    }
                });
            });
        </script-->
        <script src="js/suppr_video.js"></script>
        <script src="js/lg_titre.js"></script>
    </body>
</html>