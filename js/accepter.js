function accepter(id){
    $.ajax({
        type    : 'POST',
        url     : 'ajax/accepter.php',
        data    : 'id='+id,
        success : affichage
    });
}

function affichage(id){
    if(id=="reussi")
        alert('Ami bien ajouté !');
    else
        alert('Erreur lors de la confirmation d\'ajout de l\'ami.');
}