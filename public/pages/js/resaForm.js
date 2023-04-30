function getDate(date) {
    //AJAX
    var xmlhttp = new XMLHttpRequest();
    //Dés lors que la fonction est appellé
    xmlhttp.onreadystatechange = function() {
        //Si l'état de la requête est correct
        if (this.readyState == 4 && this.status == 200) {
            //Retourne l'élement de réponse sur l'id resulDate
            document.getElementById("resultDate").innerHTML = this.responseText;
        }
    };
    //Requête
    xmlhttp.open("GET", "../../src/pages/functions/getDate.php?q=" + date, true);
    //Réponse
    xmlhttp.send();
}

function getLiaisons(secteur) {
    // AJAX
    let secteurInt = parseInt(secteur);
    var xmlhttp = new XMLHttpRequest();
    // Dès que la fonction est appelée
    xmlhttp.onreadystatechange = function() {
        // Si l'état de la requête est correct
        if (this.readyState == 4 && this.status == 200) {
            // Retourne l'élément de réponse sur l'id resultLiaison
            document.getElementById("resultLiaison").innerHTML = this.responseText;
        }
    };
    // Requête
    xmlhttp.open("GET", "../../src/pages/functions/getLiaisonsByDateAndSecteur.php?secteur=" + secteurInt, true);
    // Envoie de la requête
    xmlhttp.send();
}

function getHoraires(idLiaison) {
    // AJAX
    let idLiaisonInt = parseInt(idLiaison);
    var xmlhttp = new XMLHttpRequest();
    // Dès que la fonction est appelée
    xmlhttp.onreadystatechange = function() {
        // Si l'état de la requête est correct
        if (this.readyState == 4 && this.status == 200) {
            // Retourne l'élément de réponse sur l'id resultLiaison
            document.getElementById("resultHoraires").innerHTML = this.responseText;
        }
    };
    // Requête
    xmlhttp.open("GET", "../../src/pages/functions/getHorairesByIdLiaisonsAndDate.php?id=" + idLiaisonInt, true);
    // Envoie de la requête
    xmlhttp.send();
}


//Fonction Test
function showHint(str) {
    if (str.length == 0) {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "../../src/pages/functions/getHint.php?q=" + str, true);
        xmlhttp.send();
    }
}