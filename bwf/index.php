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
        <meta property="og:description" content="Tu contenido aquí"/>
        <meta property="og:image" content="http://telenu.tv/resources/images/fblogo.jpg"/>
        <title>Telenu - Selección Baja Web Fest <?= $_GET['y'] ?></title>
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
            <div class="bwfOverlay" style="background-image:url(../resources/images/bwf<?= $_GET['y'] ?>.jpg); background-position: 0% -50px;">
                <div class="channelInfo">
                    <div class="channelTitle">
                        <?php
                            if (!$_SESSION["detect"]->isMobile()) { ?>
                                <div class="container-fluid channelTechnical">
                                <div class="row">
                                <div class="col-sm-8 col-sm-offset-2 text-center">
                                <?php

                                $stmt = $conn->prepare("SELECT ChN, Genre FROM channel JOIN chaninfoseries ON channel.ID = chaninfoseries.ChID WHERE channel.ChY = ? AND chaninfoseries.Win = 1 ORDER BY Genre");
                                $stmt->execute(array($_GET['y']));
                                $selection = $stmt->fetchAll();

                                foreach ($selection as $key => $serie) {
                                    echo '<p>Mejor ',$serie[1],': <span>',$serie[0],'</span></p>';        
                                }

                                echo '</div></div></div>';
                            }
                        ?>
                        <div class="vertical-center">
                            <h1>Baja Web Fest <?= $_GET['y'] ?></h1>
                            <h2>Selección Oficial</h2>
                            <?php if ($_GET['y']==2016) {
                                echo '<h1 style="font-style:italic;">Próximamente...</h1>';
                            } ?>
                        </div>
                    </div>
                    <?php 
                        if ($_SESSION["detect"]->isMobile()) {
                            echo '<div id="channelTrigger"><a class="btn btn-default" href="#" data-toggle="modal" data-target="#credits"><i class="fa fa-play"></i> Ganadores</a></div>';
                        } else {
                            echo '<div id="channelTrigger"><i class="fa fa-4x fa-caret-up"></i></div>';
                        }
                    ?>
                </div>
            </div>      
        </section>

        <section id="content">
            <div class="container">
                <div class="row">
                    <div id="marker" style="position:absolute;top:-85px;"></div>
                    <div class="button-group filters-button-group">
                        <a class="button navigator is-checked" href="#marker" data-filter="*"><span class="underAnim">Todos</span></a>
                        <?php if ($_GET['y']!=2014) {
                            echo '<a class="button navigator" href="#marker" data-filter=".Acción\/Aventura"><span class="underAnim">Acción / Aventura</span></a>';
                        } ?>          
                        <a class="button navigator" href="#marker" data-filter=".Animación"><span class="underAnim">Animación</span></a>
                        <a class="button navigator" href="#marker" data-filter=".Comedia"><span class="underAnim">Comedia</span></a>
                        <a class="button navigator" href="#marker" data-filter=".Documental"><span class="underAnim">Documental</span></a>
                        <a class="button navigator" href="#marker" data-filter=".Drama"><span class="underAnim">Drama</span></a>
                        <a class="button navigator" href="#marker" data-filter=".Fantasía\/Scifi"><span class="underAnim">Fantasía / Scifi</span></a>
                        <a class="button navigator" href="#marker" data-filter=".Terror"><span class="underAnim">Terror</span></a>
                    </div>
                    <div class="grid bwf-grid">
                        <div class="grid-sizer"></div>
                        <?php fetchAllChannels($_GET['y']); ?>
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
                       <!--  <ul>
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

        <?php
            if ($_SESSION["detect"]->isMobile()) { ?>
                <div id="credits" class="modal fade" role="dialog">
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-body channelTechnical">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="container-fluid channelTechnical">
                <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text-center">
                <?php 

                $stmt = $conn->prepare("SELECT ChN, Genre FROM channel JOIN chaninfoseries ON channel.ID = chaninfoseries.ChID WHERE channel.ChY = ? AND chaninfoseries.Win = 1 ORDER BY Genre");
                $stmt->execute(array($_GET['y']));
                $selection = $stmt->fetchAll();

                foreach ($selection as $key => $serie) {
                    echo '<p>Mejor ',$serie[1],': <span>',$serie[0],'</span></p>';        
                }

                echo '</div></div></div></div></div></div></div>'; 
            } 
        ?>

        <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../vendor/isotope.pkgd.min.js"></script>
        <script type="text/javascript" src="../vendor/tooltip/tooltip.js"></script>
        <?php if ($_SESSION["detect"]->isMobile()) { ?>
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
        <?php } ?>
        <script type="text/javascript" src="../resources/js/script.js"></script>
        <script type="text/javascript" src="../resources/js/browse.js"></script>
        <?php if (!$_SESSION["detect"]->isMobile()) { ?>
            <script>
                $(window).scroll(function() {
                    var scrolledY = $(window).scrollTop();
                    $('.bwfOverlay').css('background-position', 'center ' + ((scrolledY)) + 'px');
                });
            </script>
        <?php } ?>
        <?php loadRegister(); ?>
        <?php loadRecents(); ?>
    </body>
</html>













