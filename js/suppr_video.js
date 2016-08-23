function suppr_video(id){
    if (confirm("Confirmez-vous la suppression de la vidéo ?")){
        $.ajax({
            type    : 'POST',
            url     : 'ajax/suppr_video.php',
            data    : 'id='+id,
            success : suppre
        });
    }
}

function suppre(id){
    if(id=="reussi")
        alert('La vidéo a bien été supprimée.');
    else alert('Erreur lors de la suppression :\n - Soit la vidéo ne vous appartient pas.\n - Soit la vidéo n\'existe pas.');
}