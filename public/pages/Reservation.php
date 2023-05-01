<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>MarieTeam</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <?php include('../../src/inc/common/head_link.php') ?>
</head>

<body>
    <?php include('../../src/inc/common/header_alt.php') ?>
    <?php include_once('../../src/inc/common/meteoAPI.php') ?>


    <section class="position-relative py-4 py-xl-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2>Réservation</h2>
                    <p class="w-lg-50">Quelle sera votre prochaine destination ?</p>
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

                <form class="border rounded-0" method="post" action="../../src/pages/functions/getBateau.php">

                    <div>
                        <div>
                            <label class="d-block"> Secteurs: </label>
                            <?php
                            include_once('../../src/pages/functions/getSecteurs.php');
                            getSecteurs();
                            ?>
                        </div>
                    </div>

                    <div id="resultLiaison"></div>

                    <div id="resultDate"></div>

                    <div id="resultHoraire"></div>

                    <br>
                    <br>
                    <?php if (isset($_SESSION["erreurTypeDispo"]) && isset($_SESSION["erreurMessageDispo"])) {
                        echo '<span style="color:red;text-align:center;"><strong>' . $_SESSION["erreurMessageDispo"] . '</strong></span>';
                    }
                    ?>
            </div>
            </form>


        </div>

        </div>
    </section>
    <script type=" text/javascript" src="../../public/pages/js/resaForm.js"></script>
    <?php include('../../src/inc/common/footer.php') ?>
</body>


</html>