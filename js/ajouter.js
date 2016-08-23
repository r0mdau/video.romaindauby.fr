function ajouter(id){
    $.ajax({
        type    : 'POST',
        url     : 'ajax/addfriend.php',
        data    : 'id='+id,
        success : affichage
    });
}

function affichage(id){
    if(id=="reussi")
        alert('Demande d\'ajout à la liste d\'amis bien envoyée !');
    else
        alert('Erreur lors de la demande d\'ajout de l\'ami.');
}