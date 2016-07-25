<?php
    require '../resources/php/connToServer.php';
    require '../resources/php/getSession.php';    
    require '../resources/php/browse.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, maximum-scale=1.0">
        <meta property="og:url" content="http://telenu.tv"/>
        <meta property="og:title" content="Telenu.TV"/>
        <meta property="og:description" content="¡Disfruta lo mejor del entretenimiento digital independiente por TELENU!"/>
        <meta property="og:image" content="http://telenu.tv/resources/images/fblogo.jpg"/>
        <title>Telenu - Series</title>
        <link rel="icon" type="image/x-icon" href="http://telenu.tv/resources/images/favicon.ico">
        <link href='https://fonts.googleapis.com/css?family=Roboto:500,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../vendor/tooltip/tooltip.css">        
        <?php if (!$_SESSION["detect"]->isMobile()) { echo '<link rel="stylesheet" type="text/css" href="../resources/css/style.css" />'; } else { echo '<link rel="stylesheet" type="text/css" href="../resources/css/style-movil.css" />'; } ?>
        <script type="text/javascript" src="../vendor/jquery.min.js"></script>
        <script>
            $(window).load(function() {
                $(".se-pre-con").fadeOut("slow");
            });
        </script>
    </head>
    <body>
        <?php include_once("../resources/php/analyticstracking.php") ?>
        <div class="se-pre-con"></div>
        <?php 
            if ($_SESSION["detect"]->isMobile()) { echo '<div id="o-wrapper" class="o-wrapper">'; }
            loadUserMenu(); 
        ?>
        <section id="banner">
            <div id="featured" class="carousel slide carousel-fade" interval="3000" data-ride="carousel">
                    <?php fetchFeatured($genre); ?>
                </div>
            </div>
        </section>

        <section id="content">
            <div class="container">
                <div class="row">
                    <div id="marker" style="position:absolute;top:-85px;"></div>
                    <div class="button-group sort-by-button-group">
                        <div class="button navigator" style="cursor:inherit">Ordenar por:</div>
                        <a class="button navigator is-checked" href="#marker" data-sort-value="name"><span class="underAnim">Alfabético</span></a>
                        <a class="button navigator" href="#marker" data-sort-value="rating"><span class="underAnim">Mejores Series <i class="fa fa-star" aria-hidden="true"></i></span></a>
                    </div>
                    <div class="grid series-grid">
                        <div class="grid-sizer"></div>
                        <?php fetchAllChannels($genre); ?>
                    </div>
                </div>
            </div>
        </section>

        <section id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <img src="../resources/images/logo.png" alt="">
                        <p>&copy;2016. El Vigilante Studios. Todos los derechos reservados.</p>
                        <!-- <ul>
                            <li><a href="">Términos y Condiciones</a></li>
                            <li><a href="">Preguntas Frecuentes</a></li>
                            <li><a href="">Forma de Contacto</a></li>
                        </ul>
                        <ul>
                            <li><a href="">Legal Notice</a></li>
                            <li><a href="">Copyright</a></li>
                        </ul> -->
                    </div>
                </div>
            </div>
        </section>

        <div id="searchNav" class="overlay">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <div class="overlay-content">
                <form>
                    <input type="search" name="search" id="search" placeholder="Buscar...">
                </form>
                <div id="livesearch"></div>
            </div>
        </div>

        <?php 
            if ($_SESSION["detect"]->isMobile()) { 
                echo '</div>'; 
                loadMobileMenu();
            }
        ?>

        <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../vendor/isotope.pkgd.min.js"></script>
        <?php if ($_SESSION["detect"]->isMobile()) { ?>
            <script type="text/javascript" src="../vendor/tooltip/tooltip-mobile.js"></script>
            <script type="text/javascript" src="../resources/js/menu.min.js"></script>
            <script>
                var pushRight = new Menu({
                    wrapper: '#o-wrapper',
                    type: 'push-right',
                    menuOpenerClass: '.c-button',
                    maskId: '#c-mask'
                });

                var pushRightBtn = document.querySelector('#c-button--push-right');

                pushRightBtn.addEventListener('click', function(e) {
                    e.preventDefault;
                    pushRight.open();
                });

                $(".dd-tg").click(function() {
                    $(this).parent().toggleClass("open");
                });
            </script>
        <?php } else { ?>
            <script type="text/javascript" src="../vendor/tooltip/tooltip.js"></script>
        <?php } ?>
        <script type="text/javascript" src="../resources/js/browse.js"></script>
        <script type="text/javascript" src="../resources/js/script.js"></script>
        <?php loadRegister(); ?>
        <?php loadRecents(); ?>
    </body>
</html>













