// Chargement du script une fois que le document est prêt
$(document).ready(function() {
    autocompleteCustom();
    sendForm();
});

function sendForm(){
    // Récupération de l'évenement submit du formulaire possédant l'id task_search
    $('#task_search').submit(function(event){

        // On arrête le comportement habituel du formulaire
        event.preventDefault();

        // Appel de ajax
        $.ajax({

            // Définition de l'url de destination de la requete, cette dernière correspond à l'action définit dans le formulaire
            url: $(this).attr('action'),

            // Définition de la méthode de la requete, cette dernière correspond à la méthode défini dans le form
            type: $(this).attr('method'),

            // Formattage du formulaire
            data: new FormData($(this)[0]),

            processData: false

            // Traitement du retour de la requête
        }).then(function(response){

            // Injection du template reçu dans le dom
            $('#search_result').html(response);

            // Cas d'erreur
        }).catch(function(error){
            console.log(error);
        })
    })
}

function autocompleteCustom(){
    // Récupération de l'évènement keyup (puch sur une touche du clavier)
    $('#form_search').keyup(function(event){

        // Si la touche pressé est un caractère alphanumeric
        if (event.which <= 90 && event.which >= 48)
        {
            // Récupération du pattern saisi dans le formulaire
            var pattern = $(this).val();

            // Récupération de l'url de destination de la requête
            var url = $(this).data('url');

            // Si plus de 2 caractères ont été saisi
            if (pattern.length >= 2){

                // Appel ajax
                $.ajax({

                    // Définition du type de la méthode
                    type: 'POST',

                    // Définition de l'url de destination de la méthode
                    url: url,

                    // Type de donnée que l'on va envoyer
                    dataType: 'json',

                    // Donnée à envoyer
                    data: {'term' : pattern},

                    // Empeche d'emmettre plus d'une requête par 2 secondes
                    timeout: 2000

                    // Un fois la requête effectué, récupération de la réponse
                }).then(function(response){

                    // Transformation de la réponse json(chaine de caractères) en objet json
                    var response = JSON.parse(response);

                    // Définition d'une variable qui contiendra la liste des propositions
                    var contentUl = '';

                    // Boucle sur notre tableau de réponse
                    for(i = 0; i < response.length; i++){

                        // Création des li pour chaque élément retourné + concatenation avec le contenu du ul
                        contentUl += "<li>" + response[i].title + "</li>";
                    }

                    // Injection du contenu précédemment créé dans le dom
                    $('#result_autocomplete').html(contentUl);

                    // Récupération de l'évènement click sur une li (proposition)
                    $('#result_autocomplete li').click(function(){

                        // Récupération du contenu de l'élément sur lequel on a cliqué
                        var selectValue = $(this).text();

                        // Injection dans l'input du formulaire de l'élément sur lequel on a cliqué
                        $('#form_search').val(selectValue);

                        // Remise à zéro de la liste
                        $('#result_autocomplete').html('');
                    })
                    // En cas d'erreur
                }).catch(function(error){
                    console.log(error);
                })
            }
        }
    })
}