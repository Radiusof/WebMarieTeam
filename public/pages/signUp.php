<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>MarieTeam</title>
    <?php include('../../src/inc/common/head_link.php') ?>
</head>

<body>
    <?php include('../../src/inc/common/header_alt.php') ?>
    <form class="border rounded-0" method="post" action="../../src/pages/checkSignUp.php">
        <div class="bg-light bg-gradient border rounded-circle border-2 border-info shadow gc004-container">
            <h1>Inscription</h1>
            <p>Veuillez remplir ce formulaire pour vous créer un compte.</p>
            <hr><label class="form-label fw-bold" for="email">Email</label>
            <?php if (isset($_SESSION["erreurTypeSignUp"]) && isset($_SESSION["erreurMessageSignUp"])) {
                if ($_SESSION["erreurTypeSignUp"] == 4) {
                    echo '<span style="color:red;text-align:center;"><strong>' . $_SESSION["erreurMessageSignUp"] . '</strong></span>';
                }
            }
            ?>
            <input type="text" placeholder="Enter Email" type="email" name="email"" required="">
            
            <label class=" form-label fw-bold" for="nom">Nom</label>
            <input type="text" placeholder="Enter Name" type="text" name="name"" required="">

            <label class=" form-label fw-bold" for="prenom">Prenom</label>
            <input type="text" placeholder="Enter Surname" type="text" name="surname"" required="">

            <label class=" form-label fw-bold" for="adresse">Adresse</label>
            <input type="text" placeholder="Enter adress" type="text" name="adresse"" required="">

            <label class=" form-label fw-bold" for="codePostal">Code Postal</label> <br>
            <?php if (isset($_SESSION["erreurTypeSignUp"]) && isset($_SESSION["erreurMessageSignUp"])) {
                if ($_SESSION["erreurTypeSignUp"] == 6) {
                    echo '<span style="color:red;text-align:center;"><strong>' . $_SESSION["erreurMessageSignUp"] . '</strong></span>';
                }
            }
            ?>
            <input type="number" placeholder="Enter Post Code" type="number" name="codePostal"" required="" ><br><br>

           <label class=" form-label fw-bold" for="ville">Ville</label>
            <input type="text" placeholder="Enter Town" type="text" name="ville"" required="">

            <label class=" form-label fw-bold" for="mdp">Mot de Passe</label>
            <?php if (isset($_SESSION["erreurTypeSignUp"]) && isset($_SESSION["erreurMessageSignUp"])) {
                if ($_SESSION["erreurTypeSignUp"] == 2) {
                    echo '<span style="color:red;text-align:center;"><strong>' . $_SESSION["erreurMessageSignUp"] . '</strong></span>';
                };
            } ?>
            <input type="password" placeholder="Enter Password" type="password" name="mdp" required="">

            <label class="form-label fw-bold" for="mdp">Confirmer le nouveau&nbsp;Mot de Passe</label>
            <input type="password" placeholder="Repeat Password" type="password" name="mdp-repeat" required="">

            <p>En créant un compte, vous acceptez les&nbsp;<a class="gc004-dodgerblue" href="#">termes &amp; conditions</a>&nbsp;du site internet.</p>
            <div class="gc-clearfix">
                <a class="btn btn-primary gc-cancelbtn" role="button" href="index.php" style="padding-left: 142px;padding-right: 153px;">Annuler</a>
                <input class="btn btn-primary gc-signupbtn" type="submit" name="submit" style="margin-top: 0;border-color:transparent;color:white; padding-left: 142px;padding-right: 153px;" value="S'enregistrer !" "></input>
            </div>

            <?php if (isset($_SESSION["erreurTypeSignUp"]) && isset($_SESSION["erreurMessageSignUp"])) {
                if ($_SESSION["erreurTypeSignUp"] == 1 || $_SESSION["erreurTypeSignUp"] == 3 || $_SESSION["erreurTypeSignUp"] == 5) {
                    echo '<span style="color:red;text-align:center;"><strong>' . $_SESSION["erreurMessageSignUp"] . '</strong></span>';
                };
            }
            ?>
        </div>
    </form>
</body>
<?php include('../../src/inc/common/footer.php') ?>
</html>