/* ------------------------------------------------------------------------
    Auteur: Jonathan Boyer (http://www.grafikart.fr)
    Version: 1.0.0
    foncton: Permet une navigation Ajax entre les pages
------------------------------------------------------------------------- */

/*
Petit ajout par rappoirt au tutoriel :
Un loader qui s'affiche pour indiquer le chargement d'un contenu
*/
$(document).ready(function(){
    $("#menu ul li a").click(function(){
        $("#top").append('<div class="loader"></div>'); // On ajoute le loader en haut
        page=$(this).attr("href");
        $.ajax({
            url: "contenu/"+page,
            cache:false,
            success:function(html){
                afficher(html);
            },
            error:function(XMLHttpRequest,textStatus, errorThrown){
                afficher("erreur lors du chagement de la page");
            }
        })
        return false;
    });
});

function afficher(data){
$(".loader").remove(); // On supprime le loader
$("#contenu").fadeOut(500,function(){
    $("#contenu").empty();
    $("#contenu").append(data);
    $("#contenu").fadeIn(1000);
})
}
