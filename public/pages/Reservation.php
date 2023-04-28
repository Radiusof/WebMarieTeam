<?php
include('../../src/pages/functions/getLiaisons.php');
?>

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
    <?php include('../../src/inc/common/meteoAPI.php') ?>


    <section class="position-relative py-4 py-xl-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2>Réservation</h2>
                    <p class="w-lg-50">Que sera votre prochaine destination ?</p>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2>Météo en direct de <?php echo $data->name; ?> </h2>
                    <div class="w-lg-50">
                        <img src="http://openweathermap.org/img/w/<?php echo $data->weather[0]->icon; ?>.png" class="weather-icon" />
                        <?php echo $data->main->temp_max; ?>°C --- <span class="min-temperature"><?php echo $data->main->temp_min; ?>°C</span>
                    </div>
                    <div class="w-lg-50">
                        <div>Humidité: <?php echo $data->main->humidity; ?> %</div>
                        <div>Vitesse du vent: <?php echo $data->wind->speed; ?> km/h</div>
                    </div>
                </div>
                <?php
                $date = $_SESSION["date"];
                $secteur = $_SESSION["secteur"];
                $error_message_dispo =   $_SESSION["erreurMessageDispo"];
                $error_type_dispo = $_SESSION["erreurTypeDispo"];

                echo "Date selectionnée: " . $_SESSION["date"] . "<br>";
                getLiaisonsByDateAndSecteur($secteur, $date);
                ?>


            </div>
        </div>
    </section>

    <?php include('../../src/inc/common/footer.php') ?>
</body>


</html>