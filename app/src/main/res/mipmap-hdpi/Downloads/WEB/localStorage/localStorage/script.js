var tab = Array();
var id = 0;
function load() {
    if (typeof localStorage != 'undefined') {
        if ('e' in localStorage) {
            var contenu = $('#contenu');
            var ligne = '';
            var indice = 0;
            tab = JSON.parse(localStorage.getItem('e'));
            tab.forEach(element => {
                ligne += '<tr><td>' + element.nom + '</td><td>' + element.prenom + '</td><td>' + element.email + '</td><td><a class="delete" href="" indice="' + indice + '">Supprimer</a></td><td><a indice="' + indice + '" class="update" href="">Modifier</a></td></tr>';
                indice++;
            });
            contenu.html(ligne);
        }
    } else {
        alert("localStorage n'est pas supporté");
    }
}

$(document).ready(function () {
    load();
    $('#valider').click(function () {
        var nom = $('#nom').val();
        var prenom = $('#prenom').val();
        var email = $('#email').val();
        var e = {
            'nom': nom,
            'prenom': prenom,
            'email': email
        };
        if ($('#valider').html() == 'Modifier') {
            tab[id] = e;
            $('#valider').html("Valider");
        } else {
            tab.push(e);
        }
        localStorage.setItem('e', JSON.stringify(tab));
        load();
    });

    $('#contenu').on('click', '.delete', function () {
        //var id = parseInt( $(this).parent().index() )+1; //colonne index
        id = parseInt($(this).attr('indice'));
        alert(id);
        tab.splice(id, 1);
        localStorage.clear;
        localStorage.setItem('e', JSON.stringify(tab));
        load();
    });

    $('#contenu').on('click', '.update', function () {
        //var id = parseInt( $(this).parent().index() )+1; //colonne index
        id = parseInt($(this).attr('indice'));
        $('#nom').val(tab[id].nom);
        $('#prenom').val(tab[id].prenom);
        $('#email').val(tab[id].email);
        $('#valider').html('Modifier');
        return false;
    });
});

