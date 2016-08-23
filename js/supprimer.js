function supprimer(id){
    if (confirm("Confirmez-vous la suppression de cet ami ?")){
        $.ajax({
            type    : 'POST',
            url     : 'ajax/supprimer.php',
            data    : 'id='+id,
            success : affi
        });
    }
}

function affi(id){
    if(id=='reussi')
        alert('La personne a bien été supprimée de votre liste d\'amis.');
    else
        alert('Erreur lors de la suppression de la personne :\n - Vous n\'étiez pas amis');
}