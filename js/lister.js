function lister(id){
    alert()
    $.ajax({
        type    : 'POST',
        url     : 'ajax/liste_commun.php',
        data    : 'id='+id,
        success : affichage
    });
}

function liste(res){
    $('#boite').html(res);
    $(document).bind('mousemove',function(e){ 
        $('#boite').css('margin', e.pageY+'px 0 0 '+e.pageX+'px');
        //("e.pageX: " + e.pageX + ", e.pageY: " + e.pageY); 
    }); 
}