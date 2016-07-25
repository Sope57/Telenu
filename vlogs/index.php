<?php
    require '../resources/php/connToServer.php';
    require '../resources/php/getSession.php';    
    require '../resources/php/vlogs.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, maximum-scale=1.0">
        <title>Telenu</title>
        <link rel="icon" type="image/x-icon" href="http://telenu.tv/resources/images/favicon.ico">
        <link href='https://fonts.googleapis.com/css?family=Roboto:500,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../vendor/tooltip/tooltip.css">        
        <link rel="stylesheet" type="text/css" href="../resources/css/style.css" />
        <script type="text/javascript" src="../vendor/jquery.min.js"></script>
        <script>
            $(window).load(function() {
                $(".se-pre-con").fadeOut("slow");
            });
        </script>
    </head>
    <body>
        <div class="se-pre-con"></div>
        <nav class="navbar navbar-fixed-top" id="navstyle1">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="http://telenu.tv">
                        <img alt="Brand" class="img-responsive" src="../resources/images/logo.png">
                    </a>
                </div>

                <div id="navbar1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" class="social-button facebook fb" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://twitter.com/telenutv" class="social-button twitter tw" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="https://www.instagram.com/telenu.tv/" class="social-button instagram in" target="_blank"><i class="fa fa-instagram"></i></a></li>
                        <li class="dropdown">
                            <?php
                                $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; 
                                if(isset($_COOKIE["id"])){
                            ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <img class="profilePicture" src="<?= $_SESSION["Picture"] ?>" alt="">
                                <?= $_SESSION["User_Name"] ?>
                                <i class="fa fa-ellipsis-v"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($_SESSION["Email"]=="elvigilantestudios@gmail.com") { ?>
                                <li><a class="btn btn-default" href="../user/channelManager.php">Channel Manager</a></li>
                                <?php } ?>
                                <li><a class="btn btn-default" data-toggle="modal" href="#showlogin" >Mis Series</a></li>
                                <li><a class="btn btn-default" href="../resources/php/logout.php">Salir</a></li>
                            </ul>
                            <?php } else { ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img class="usericon" src="../resources/images/usericon.png" alt=""> Ingreso / Registro <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php 
                                    if(isset($_SESSION["LogInFail"])) { 
                                        echo '<li>',$_SESSION["LogInFail"],'</li>';
                                    }
                                    require '../vendor/facebook/fb.php';
                                ?>
                                <form action="../resources/php/login.php" method="post" name="login" >
                                    <li><input type="email" name="Email" class="form-control text-center" required="required" placeholder="E-mail"></li>
                                    <li><input type="password" name="Password" class="form-control text-center" required="required" placeholder="Contraseña"></li>
                                    <li><input type="submit" name="Login" class="btn btn-default" value="Ingresar"></li>
                                </form>
                                <li role="separator" class="divider"></li>
                                <li><a href="#" data-toggle="modal" data-target="#regis">Registro</a></li>
                            </ul>
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <nav class="navbar navbar-fixed-top mobile-hide" id="navstyle2">
            <div class="container-fluid">
                <div id="navbar2">
                    <ul class="nav navbar-nav">
                        <!-- <li><a href="#"><span class="underAnim">Contenido Telenu</span></a></li> -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Series <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="../series/accion_aventura">Acción / Aventura</a></li>
                                <li><a href="../series/animacion">Animación</a></li>
                                <li><a href="../series/comedia">Comedia</a></li>
                                <li><a href="../series/documental">Documental</a></li>
                                <li><a href="../series/drama">Drama</a></li>
                                <li><a href="../series/fantasia_scifi">Fantasía / Sci-Fi</a></li>
                                <li><a href="../series/terror">Terror</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Baja Web Fest <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="../bwf/2014">Selección 2014</a></li>
                                <li><a href="../bwf/2015">Selección 2015</a></li>
                                <li><a href="../bwf/2016">Selección 2016</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="../vlogs" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Vlogs <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php fetchVlogsNav(); ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <section id="banner">
            <div class="bwfOverlay" style="background-image:url(../resources/images/telenubanner1.jpg); background-position: 0% -50px;">
                <div class="channelInfo">
                    <div class="channelTitle">
                        <div class="vertical-center">
                            <h1>Vlogs</h1>
                        </div>
                    </div>
                </div>
            </div>      
        </section>

        <section id="content">
            <div class="container">
                <div class="row">
                    <div id="marker" style="position:absolute;top:-85px;"></div>
                    <div class="button-group filters-button-group">
                        <a class="button navigator is-checked" href="#marker" data-filter="*"><span class="underAnim">Todos</span></a>    
                        <a class="button navigator" href="#marker" data-filter=".Reviews"><span class="underAnim">Reviews</span></a>
                    </div>

                    <div class="grid">
                        <div class="grid-sizer"></div>
                        <?php fetchAllChannels(); ?>
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
                        <ul>
                            <li><a href="">Términos y Condiciones</a></li>
                            <li><a href="">Preguntas Frecuentes</a></li>
                            <li><a href="">Forma de Contacto</a></li>
                        </ul>
                        <ul>
                            <li><a href="">Legal Notice</a></li>
                            <li><a href="">Copyright</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <?php loadRegister(); ?>
        <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../vendor/isotope.pkgd.min.js"></script>
        <script type="text/javascript" src="../vendor/tooltip/tooltip.js"></script>
        <script type="text/javascript" src="../resources/js/script.js"></script>
        <script type="text/javascript" src="../resources/js/browse.js"></script>
        <script>
            $(window).scroll(function() {
                var scrolledY = $(window).scrollTop();
                $('.bwfOverlay').css('background-position', 'center ' + ((scrolledY)) + 'px');
            });
        </script>
        <?php loadRecents(); ?>
    </body>
</html>













