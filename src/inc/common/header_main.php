<nav class="navbar navbar-light navbar-expand navigation-clean">
    <div class="container"><a class="navbar-brand text-start link-secondary" href="index.php">Compagnie Marie Team</a>
        <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"></button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <?php session_start();

            $_SESSION["date"] = "";
            $_SESSION["secteur"] = "";

            date_default_timezone_set("Europe/Paris");
            if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
                echo "<a class=\"btn ms-auto\" role=\"button\" href=\"login.php\" style=\"margin-left: 51px;color: transparent; background_color: transparent\"></a>";
                echo "<p style=\"margin-bottom: -2px;\"><strong>Bienvenue " . $_SESSION["nomUser"] . "</strong></p>";
                echo "<a class=\"btn btn-primary text-end d-xl-flex mb-auto\" role=\"button\" style=\"margin-left: 48px;display: flex;position: relative;margin-top: -1px;padding-left: 9px;\" data-bs-target=\"#login\" href=\"../../src/pages/logout.php\">Se déconnecter</a>";
            } else {
                echo "<a class=\"btn btn-primary ms-auto\" role=\"button\" href=\"login.php\" style=\"margin-left: 51px;\">Identification</a>";
                echo "<a class=\"btn btn-primary text-end d-xl-flex mb-auto\" role=\"button\" style=\"margin-left: 48px;display: flex;position: relative;margin-top: -1px;padding-left: 9px;\" data-bs-target=\"#login\" href=\"signUp.php\">Inscription</a>";
            } ?>
        </div>
    </div>
</nav>
<header class="text-center text-white masthead" style="background: url('./img/bg-masthead.jpg?h=3d56ee9570bd6ab1d22f0827b18a0a99')no-repeat center center;background-size: cover;">
    <div class="overlay">
        <div></div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xl-9 mx-auto position-relative">
                <h1 class="mb-5" style="padding-bottom: 0px;margin-bottom: 576px;">Marie Team</h1>
                <p><br><strong>Une autre façon de traverser la mer</strong><br><br></p>
                <!-- <a class="btn btn-primary text-center" role="button" style="margin-top: 18px;margin-right: 0px;padding-left: 34px;padding-right: 35px;" href="Tarif.php">Tarifs</a> -->
            </div>
            <div class="col-xl-9 mx-auto position-relative"><a class="btn btn-primary" role="button" style="margin-top: 18px;" href="Reservation.php">Reservation</a></div>
        </div>
    </div>
</header>