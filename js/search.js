var search = $('input[id="search"]');
$(document).ready(function(){
    search.keyup(function(event){
        if(event.keyCode == 13){
            window.location="liste.php?m="+search.val();
        }
    });
});

function sortie(res){
    $('#site').html(res);
}