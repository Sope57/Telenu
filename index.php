<?php
    require 'resources/php/connToServer.php';
    require 'resources/php/getSession.php';
    require 'resources/php/home.php';
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
        <link rel="canonical" href="http://telenu.tv"/>
        <title>Telenu</title>
        <link rel="icon" type="image/x-icon" href="http://telenu.tv/resources/images/favicon.ico">
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="vendor/flexslider/flexslider.css">
        <?php if (!$_SESSION["detect"]->isMobile()) { echo '<link rel="stylesheet" type="text/css" href="resources/css/style.css" />'; } else { echo '<link rel="stylesheet" type="text/css" href="resources/css/style-movil.css" />'; } ?>
    </head>
    <body>
        <?php 
            include_once("resources/php/analyticstracking.php");
            if ($_SESSION["detect"]->isMobile()) { echo '<div id="o-wrapper" class="o-wrapper">'; }
            loadUserMenu();
        ?>
        <section id="banner">
            <div id="featured" class="carousel slide" interval="3000" data-ride="carousel">
                <?php if (!$_SESSION["detect"]->isMobile()) { ?>
                    <ol class="carousel-indicators">
                        <li data-target="#featured" data-slide-to="0" class="active"></li>
                        <li data-target="#featured" data-slide-to="1"></li>
                        <li data-target="#featured" data-slide-to="2"></li>
                        <li data-target="#featured" data-slide-to="3"></li>
                        <li data-target="#featured" data-slide-to="4"></li>
                    </ol>
                <?php } ?>
                <div class="carousel-inner" role="listbox">
                    <div class="active item">
                        <div class="featuredOverlay" style="background-image:url(http://telenu.tv/resources/images/telenubanner2.jpg)">
                            <div id="featured1" class="featuredInfo">
                                <img src="http://telenu.tv/resources/images/logoslogan.png" alt="Slogan">
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="featuredOverlay" style="background-image:url(http://telenu.tv/resources/images/BannerEsquina.jpg)">
                            <div class="featuredInfo vertical-center">
                                <h1 class="text-uppercase">LAS MEJORES RESEÑAS</h1>
                                <h2>Aquí en <img src="http://telenu.tv/resources/images/logo.png" alt="Telenu"></h2>
                                <a class="btn btn-default" href="channel/EsquinaDelCine"><i class="fa fa-play"></i> Esquina del Cine</a>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="featuredOverlay" style="background-image:url(http://telenu.tv/resources/images/BannerArak.jpg)">
                            <div class="featuredInfo vertical-center">
                                <h1 class="text-uppercase">¡Ya llegó Arak!</h1>
                                <h2>Ahora por <img src="http://telenu.tv/resources/images/logo.png" alt="Telenu"></h2>
                                <a class="btn btn-default" href="channel/TonyScrots"><i class="fa fa-play"></i> Ver ahora</a>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="featuredOverlay" style="background-image:url(http://telenu.tv/resources/images/BannerContenido.jpg);">
                            <div class="featuredInfo vertical-center">
                                <h1>¿Quieres que tu contenido</h1>
                                <h1>esté en <img src="http://telenu.tv/resources/images/logo.png" alt="Telenu">?</h1>
                                <a class="btn btn-default" href="register/content.php" target="_blank"><i class="fa fa-play"></i> Inscríbete aquí</a>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="featuredOverlay" style="background-image:url(http://telenu.tv/resources/images/BannerWebFest.jpg)">
                            <div class="featuredInfo vertical-center">
                                <h1 class="text-uppercase">¡Próximamente!</h1>
                                <h2>Solo por <img src="http://telenu.tv/resources/images/logo.png" alt="Telenu"></h2>
                                <h1 class="text-uppercase">Selección Oficial <span style="color:#6ce4d6">2016</span></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="left carousel-control" href="#featured" role="button" data-slide="prev">
                  <img src="resources/images/arrow-left.png" class="arrow-left" />
                  <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#featured" role="button" data-slide="next">
                  <img src="resources/images/arrow-right.png" class="arrow-right" />
                  <span class="sr-only">Next</span>
                </a>
            </div>
        </section>

        <section id="content">
            <div class="container">
                <div class="row">
                    <div class="grid js-isotope" data-isotope-options='{ "itemSelector": ".grid-item", "columnWidth": ".grid-sizer", "percentPosition": true }'>
                        <div class="grid-sizer"></div>
                        <?php fetchContent($statuses, $channelData) ?>
                    </div>
                </div>
            </div>
        </section>

        <section id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <img src="resources/images/logo.png" alt="">
                        <p>telenu.tv@gmail.com - +52 1 (664) 567 0038</p>
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
                    <input type="text" name="search" id="search" placeholder="Buscar...">
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

        <script type="text/javascript" src="vendor/jquery.min.js"></script>
        <script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="vendor/isotope.pkgd.min.js"></script>
        <script type="text/javascript" src="vendor/lazysizes/lazysizes.min.js"></script>
        <script type="text/javascript" src="vendor/flexslider/flexslider.min.js"></script>
        <?php if ($_SESSION["detect"]->isMobile()) { ?>
            <script type="text/javascript" src="resources/js/menu.min.js"></script>
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
        <?php } ?>
        <script type="text/javascript" src="resources/js/script.js"></script>
        <script type="text/javascript" src="resources/js/home.js"></script>
        <?php loadRegister(); ?>
        <?php loadRecents(); ?>
    </body>
</html>













