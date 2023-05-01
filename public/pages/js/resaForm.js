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
    xmlhttp.open("GET", "../../src/pages/functions/getLiaisons.php?secteur=" + secteurInt, true);
    // Envoie de la requête
    xmlhttp.send();
}

function getDateDispo(liaison) {
    // AJAX
    let liaisonInt = parseInt(liaison);
    var http = new XMLHttpRequest();
    // Dès que la fonction est appelée
    http.onreadystatechange = function() {
        // Si l'état de la requête est correct
        if (this.readyState == 4 && this.status == 200) {
            // Retourne l'élément de réponse sur l'id resultLiaison
            document.getElementById("resultDate").innerHTML = this.responseText;
        }
    };
    // Requête
    http.open("GET", "../../src/pages/functions/getDateDispo.php?liaison=" + liaisonInt, true);
    // Envoie de la requête
    http.send();
}

function getHoraire(traversee) {
    //AJAX
    let traverseeInt = parseInt(traversee);
    var horairehttp = new XMLHttpRequest();
    //Dés lors que la fonction est appellé
    horairehttp.onreadystatechange = function() {
        //Si l'état de la requête est correct
        if (this.readyState == 4 && this.status == 200) {
            //Retourne l'élement de réponse sur l'id resultHoraire
            document.getElementById("resultHoraire").innerHTML = this.responseText;
        }
    };
    //Requête
    horairehttp.open("GET", "../../src/pages/functions/getHoraire.php?traversee=" + traverseeInt, true);
    //Réponse
    horairehttp.send();
}

function getBateau(idBateau) {
    //AJAX
    let idBateauInt = parseInt(idBateau);
    var bateauhttp = new XMLHttpRequest();
    //Dés lors que la fonction est appellé
    bateauhttp.onreadystatechange = function() {
        //Si l'état de la requête est correct
        if (this.readyState == 4 && this.status == 200) {

            document.getElementById("resultBateau").innerHTML = this.responseText;
        }
    };
    //Requête
    bateauhttp.open("GET", "../../src/pages/functions/getBateau.php?idbateau=" + idBateauInt, true);
    //Réponse
    bateauhttp.send();
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