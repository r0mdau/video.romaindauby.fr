$(document).ready(function(){
    $('input[name="titre"]').keyup(function(){
        $('#lg_titre').html((150-$('input[name="titre"]').val().length)+' caractères restants');
    });
});