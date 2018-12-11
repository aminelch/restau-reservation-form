/*
 *      Copyright (c) 2018. Louhich Amine  <aminelch> sous GNU
 *     Ce code source est fourni explicitement  nous (Amine Louhichi )dans le cadre de mini projet jQuery.
 *      Il donne une idée claire sur le  niveau que j'ai  atteint durant cette phase d'apprentissage.
 *      Merci de passer sur mon code et surtout de prendre le temps pour inspecter la totalité de ce mini projet
 *      __ ((^__^)) __ because i can do
 *
 */

$(function () {
    var $total = 0;
    var prix_ruz = 12;
    var prix_couscous = 15;
    var prix_fruits = 7;
    var prix_salade = 5;
    var prix_soupe = 4.5;

    $('[title]').tooltip();

    function verifierPlats() {
        let qte_salade = parseInt($('#salade').val());
        let qte_soupe = parseInt($('#soupe').val());
        let qte_ruz = parseInt($('#ruz').val());
        let qte_fruits = parseInt($('#fruits').val());
        let qte_couscous = parseInt($('#couscous').val());

        if (qte_ruz == (0) && qte_fruits == (0) && qte_couscous == (0) && qte_salade == (0) && qte_soupe == (0)) {
            return false
        } else {
            $total = (qte_salade * prix_salade) + (qte_soupe * prix_soupe) + (qte_ruz * prix_ruz) + (qte_fruits * prix_fruits) + (qte_couscous * prix_couscous);
            return true;
        }
    }


    //afficher la page via ajax
    $('#listeclients').click(function () {
        $content = $('#formulaire').clone();
        // alert($content);
        $('#formulaire').empty().hide().delay(800).load("web/php/liste_commandes.php").fadeIn();
    });

    //textarea des accompagnateurs
    $('#accom').val("");
    $('#champaccompagne').hide();

    //ANIMATION CSS loader
    var cssAnimation = function () {
        setTimeout(function () {
            $('body').addClass('loaded');
        }, 1400);
    }

    clearTimeout(cssAnimation());

    // Initialisation de DATEPICKER
    // $('#ddate').datepicker({
    //     format: "dd/mm/yyyy",
    //     todayBtn: true,
    //     // clearBtn: true,
    //     // language: "fr",
    //     // calendarWeeks: true,
    //     autoclose: true,
    //     todayHighlight: true,
    //     // toggleActive: true
    // });

    /*
     *** remplir un element HTML de type SELECT avec des options
     */
    function remplirSelect($element) {
        $element.html('<option value="0' + '" selected>0</option>');
        for (var i = 1; i <= 6; i++) {
            $element.html($element.html() + "<option value='" + i + "'>" + i + "</option>");
        }
    }
    // remplir tout sauf le select qui à l'id personne
    remplirSelect($('select ').not('#personne'));


    $('#personne').change(function () {
        $('#erreur-personne').empty();
        //on cache le champ des accompagneurs si on ne choisi pas ou on choisi une personne
        if (parseInt($('#personne').val()) === (-1) || parseInt($('#personne').val()) === 1) {
            $('#champaccompagne').hide();
        } else {
            $('#champaccompagne').show();

        }

        var image = '<img src="web/img/chaise.jpg" >';
        $('#chaise').remove();
        $('#personne').after('<div id="chaise"></div>');
        for (var i = 0; i < parseInt($('#personne').val()); i++) {
            $('#chaise').append(image).fadeIn();
        }
    });

    // Quand on clique sur le button verifier ma commande
    $('#submit').click(function (e) {
        e.preventDefault();
        // on vide les champs
        $('.champ-requis').each(function () {
            $(this).text('');
        });

        if (isValide()) viewResult();



    });

    function isValide() {
        var d = $('#ddate');
        var isChecked = $("input:radio [name='civilite']").prop('checked');
        //si on choisi pas des personnes
        if (parseInt($('#personne').val()) == (-1)) {
            $('#erreur-personne').text('Le nombre des personnes est obligatoire !');
            return false;
        } else if (d.val() === '' || d.val().length < 10) {
            $('#erreur-date').text('La date est obligatoire !');
            return false;
        } else if (!verifierPlats()) {
            //alert('Vous devez choisir au moins un plat');
            $('#plat-warning').modal();

            return false;
        } else if ($('#nomprenom').val() === '' || $('#nomprenom').val().length < 10) {
            $('#erreur-nom').text('Le nom et prènom doivent avoir au minimaum 10 caractères');
            return false;
        } else if ($('#phone').val().length != 8 ){
            $('#erreur-phone').empty().html('Le numèro doit avoir exactement 8 caractères');
            return false;
        } else if (! $.isNumeric($('#phone').val()) ) {
            $('#erreur-phone').empty().html('Numèro invalide ');
            return false;
        } else if ($('input:radio[name=civilite]:checked').val() === undefined) {
            $('#erreur-civilites').html('Choisir votre sexe !!');
            return false;
        } else if ($("#accom").is(":visible")) {
            if ($("#accom").val() === '') {
                $('#erreur-accom').html('Entrer la liste de vos accompagnateurs (une personne par ligne)');
                return false;
            } else {
                $('#erreur-accom').html('');
            }
        }



        return true;
    }

    function ajoutCommande($data) {
        $.ajax({
            type: "POST",
            url: "web/php/ajoutCommande.php",
            data: $data
        })
            .success(function (msg) {
                alert("Data Saved: " + msg);
            });
    }


    function viewResult() {
        var qte_salade = parseInt($('#salade').val());
        var qte_soupe = parseInt($('#soupe').val());
        var qte_ruz = parseInt($('#ruz').val())
        var qte_fruits = parseInt($('#fruits').val());
        var qte_couscous = parseInt($('#couscous').val());
        $total = (qte_salade * prix_salade) + (qte_soupe * prix_soupe) + (qte_ruz * prix_ruz) + (qte_fruits * prix_fruits) + (qte_couscous * prix_couscous);
        // contenu tableau
        $contenu = "";

        if (qte_salade > 0) $contenu += "<tr> <td>Salade</td><td>" + prix_salade + "</td> <td>" + qte_salade + "</td></tr>";
        if (qte_soupe > 0) $contenu += "<tr> <td>Soupe</td><td>" + prix_soupe + "</td><td>" + qte_soupe + "</td></tr>";
        if (qte_ruz > 0) $contenu += "<tr> <td>Ruz</td><td>" + prix_ruz + "</td><td>" + qte_ruz + "</td></tr>";
        if (qte_fruits > 0) $contenu += "<tr> <td>Fruits</td><td>" + prix_fruits + "</td><td>" + qte_fruits + "</td></tr>";
        if (qte_couscous > 0) $contenu += "<tr> <td>Couscous</td><td>" + prix_couscous + "</td><td>" + qte_couscous + "</td></tr>";

        // $('body').removeClass('animated fadeIn delay-1s');
        //injection de html
        $('#resume-civilites').append($('input:radio[name=civilite]:checked').val());
        $('#resume-nom').append($('#nomprenom').val());
        $('#resume-date').append($('#ddate').val());
        $('#resume-total').empty().append($total+ ' DT');
        $('#table-data').empty().append($contenu);
        //affichage de boite modal
        $('#resultat').modal();

    }
});