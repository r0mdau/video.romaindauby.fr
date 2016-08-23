<div id="nav_barre">
    <?php
        echo Nav::Button('profil.php', 'Profil', $id_page);
        echo Nav::Button('timeline.php', 'Timeline', $id_page);
        echo Nav::Button('ajouter.php', 'Ajouter', $id_page);
        echo Nav::Button('friend.php', 'Friend List', $id_page);
        
        echo Nav::Search();
            
        if(isset($_SESSION['mail'])){
            if(Friend::new_friend())
                echo Nav::notif(Friend::nb_new_friend());
            if(Timeline::new_video())
                echo Nav::notif_timeline(Timeline::nb_new_video());
            echo Nav::settings($id_page==8 ? true : false);
            echo Nav::deco();
        }
        
    ?>
</div>
<script src="js/search.js"></script>