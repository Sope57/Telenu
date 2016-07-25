<?php
    session_start();
    $conn =  db_connect();

    require_once 'Mobile_Detect.php';
    $_SESSION["detect"] = new Mobile_Detect;

    if(!isset($_SESSION["firstVisit"]) && isset($_COOKIE["id"])) {
        $_SESSION["showLogin"] = "yes";
        $_SESSION["firstVisit"] = "yes";
    }

    if(isset($_COOKIE["id"])){
        $user = $_COOKIE["id"];
        $stmt = $conn->prepare("SELECT Name, UN, EM , Picture FROM user WHERE ID = ?");
        $stmt->execute(array($user));
        $row = $stmt->fetch();
        $_SESSION["First_Name"] = $row['Name'];
        if (empty($row['UN'])) {
            $firstName = explode(' ',trim($row['Name']));
            $_SESSION["User_Name"] = $firstName['0'];   
        } else {
            $_SESSION["User_Name"] = $row['UN'];
        }
        $_SESSION["Email"] = $row['EM'];
        if (empty($row['Picture'])) {
            $_SESSION["Picture"] = "http://telenu.tv/resources/images/user/usericon.png";   
        } else {
            $_SESSION["Picture"] = $row['Picture'];
        }
        $userLoggedIn = true;
    } else {
        $userLoggedIn = false;
        // header('Location: http://telenu.tv/login.php');            
    }

    function loadUserMenu() {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        require_once($_SERVER['DOCUMENT_ROOT'].'/vendor/facebook/fb.php');
        if (!$_SESSION["detect"]->isMobile()) { ?>
            <nav class="navbar navbar-fixed-top" id="navstyle1">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="http://telenu.tv">
                            <img alt="Brand" class="img-responsive" src="http://telenu.tv/resources/images/logo.png">
                        </a>
                        <p class="beta">.Beta</p>
                    </div>
                    <div id="navbar1">
                        <ul class="nav navbar-nav navbar-right">
                            <li style="border-right:1px solid white;height:55px;margin-right:8px;"><span class="social-button" onclick="openNav()""><i class="fa fa-search" aria-hidden="true"></i></span></li>
                            <li><a href="https://www.facebook.com/Telenu.tv" class="social-button facebook fb" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="https://twitter.com/telenutv" class="social-button twitter tw" target="_blank"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="https://www.instagram.com/telenu.tv/" class="social-button instagram in" target="_blank"><i class="fa fa-instagram"></i></a></li>
                            <li class="dropdown">
                                <?php if(isset($_COOKIE["id"])) { ?>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <img class="profilePicture" src="<?= $_SESSION["Picture"] ?>" alt="<?= $_SESSION["User_Name"] ?>">
                                        <?= $_SESSION["User_Name"] ?>
                                        <i class="fa fa-ellipsis-v"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php if ($_SESSION["Email"]=="telenu.tv@gmail.com") { ?>
                                        <li><a class="btn btn-default" href="http://telenu.tv/user/channelManager.php">Channel Manager</a></li>
                                        <?php } ?>
                                        <li><a class="btn btn-default" data-toggle="modal" href="#showlogin" >Mi Perfil</a></li>
                                        <li><a class="btn btn-default" href="http://telenu.tv/resources/php/logout.php">Salir</a></li>
                                    </ul>
                                <?php } else { ?>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img class="usericon" src="http://telenu.tv/resources/images/user/usericon.png" alt=""> Ingreso / Registro <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <?php 
                                            if(isset($_SESSION["LogInFail"])) { 
                                                echo '<li>',$_SESSION["LogInFail"],'</li>';
                                            }
                                            printFBlogin($_SESSION['loginUrl'], "desktop");
                                        ?>
                                        <form action="http://telenu.tv/resources/php/login.php" method="post" name="login">
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
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Series <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="http://telenu.tv/series/accion_aventura">Acción / Aventura</a></li>
                                    <li><a href="http://telenu.tv/series/animacion">Animación</a></li>
                                    <li><a href="http://telenu.tv/series/comedia">Comedia</a></li>
                                    <li><a href="http://telenu.tv/series/documental">Documental</a></li>
                                    <li><a href="http://telenu.tv/series/drama">Drama</a></li>
                                    <li><a href="http://telenu.tv/series/fantasia_scifi">Fantasía / Sci-Fi</a></li>
                                    <li><a href="http://telenu.tv/series/terror">Terror</a></li>
                                </ul>
                            </li>
                            <!--<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cortos <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    fetchLinksNav("Short");
                                </ul>
                            </li>-->
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Shows <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php fetchLinksNav("Webshow"); ?>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Vlogspot <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php fetchLinksNav("Vlog"); ?>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Baja Web Fest <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="http://telenu.tv/bwf/2014">Selección 2014</a></li>
                                    <li><a href="http://telenu.tv/bwf/2015">Selección 2015</a></li>
                                    <li><a href="http://telenu.tv/bwf/2016">Selección 2016</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        <?php } else { ?>
            <nav class="navbar navbar-fixed-top" id="navstyle1">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="http://telenu.tv">
                            <img alt="Brand" class="img-responsive" src="http://telenu.tv/resources/images/logo.png">
                        </a>
                        <p class="beta">.Beta</p>
                    </div>
                    <div id="navbar1">
                        <ul class="nav navbar-nav navbar-right">
                            <li><button class="social-button" onclick="openNav()"><i class="fa fa-search" aria-hidden="true"></i></button></li>
                            <li><button id="c-button--push-right" class="social-button c-button"><i class="fa fa-bars" aria-hidden="true"></i></button></li>
                        </ul>
                    </div>
                </div>
            </nav>
        <?php }
    }

    function loadMobileMenu() { ?>
        <nav id="c-menu--push-right" class="c-menu c-menu--push-right">
            <button class="c-menu__close"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cerrar Menu</button>
            <ul id="userMenu">
                <?php if(isset($_COOKIE["id"])) { ?>
                    <div class="mobile-pic-container">
                        <img class="profilePicture" src="<?= $_SESSION["Picture"] ?>" alt="<?= $_SESSION["User_Name"] ?>">
                        <p><?= $_SESSION["User_Name"] ?></p>
                    </div>
                    <ul>    
                        <?php if ($_SESSION["Email"]=="telenu.tv@gmail.com") { ?>
                        <li><a class="btn btn-default" href="http://telenu.tv/user/channelManager.php">Channel Manager</a></li>
                        <?php } ?>
                        <li><a class="btn btn-default" data-toggle="modal" href="#showlogin" >Mi Perfil</a></li>
                        <li><a class="btn btn-default" href="http://telenu.tv/resources/php/logout.php">Salir</a></li>
                    </ul>
                <?php } else { 
                    printFBlogin($_SESSION['loginUrl'], "mobile");
                    ?>
                    <form action="http://telenu.tv/resources/php/login.php" method="post" name="login" >
                        <li><input type="email" name="Email" class="form-control text-center" required="required" placeholder="E-mail"></li>
                        <li><input type="password" name="Password" class="form-control text-center" required="required" placeholder="Contraseña"></li>
                        <li><input type="submit" name="Login" class="btn btn-default" value="Ingresar"></li>
                    </form>
                    <li><a href="#" data-toggle="modal" data-target="#regis">Registro</a></li>
                <?php } ?>
            </ul>
            <ul>
                <li class="dd">
                    <a href="#" class="dd-tg">Series <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                    <ul class="dd-menu">
                        <li><a href="http://telenu.tv/series/accion_aventura">Acción / Aventura</a></li>
                        <li><a href="http://telenu.tv/series/animacion">Animación</a></li>
                        <li><a href="http://telenu.tv/series/comedia">Comedia</a></li>
                        <li><a href="http://telenu.tv/series/documental">Documental</a></li>
                        <li><a href="http://telenu.tv/series/drama">Drama</a></li>
                        <li><a href="http://telenu.tv/series/fantasia_scifi">Fantasía / Sci-Fi</a></li>
                        <li><a href="http://telenu.tv/series/terror">Terror</a></li>
                    </ul>
                </li>
                <!--<li class="dd">
                    <a href="#" class="dd-tg">Cortos <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                    <ul class="dd-menu">
                    </ul>
                </li>-->
                <li class="dd">
                    <a href="#" class="dd-tg">Shows <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                    <ul class="dd-menu">
                        <?php fetchLinksNav("Webshow"); ?>
                    </ul>
                </li>
                <li class="dd">
                    <a href="#" class="dd-tg">Vlogspot <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                    <ul class="dd-menu">
                        <?php fetchLinksNav("Vlog"); ?>
                    </ul>
                </li>
                <li class="dd">
                    <a href="#" class="dd-tg">Baja Web Fest <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                    <ul class="dd-menu">
                        <li><a href="http://telenu.tv/bwf/2014">Selección 2014</a></li>
                        <li><a href="http://telenu.tv/bwf/2015">Selección 2015</a></li>
                        <li><a href="http://telenu.tv/bwf/2016">Selección 2016</a></li>
                    </ul>
                </li>
            </ul>
            <ul>
                <li><a href="https://www.facebook.com/Telenu.tv" class="social-button facebook fb" target="_blank"><i class="fa fa-facebook"></i></a></li>
                <li><a href="https://twitter.com/telenutv" class="social-button twitter tw" target="_blank"><i class="fa fa-twitter"></i></a></li>
                <li><a href="https://www.instagram.com/telenu.tv/" class="social-button instagram in" target="_blank"><i class="fa fa-instagram"></i></a></li>
            </ul>
        </nav>

        <div id="c-mask" class="c-mask"></div>
    <?php }

    function loadRegister() {
        if(!isset($_COOKIE["id"])) { ?>
            <div id="regis" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Únete a la comunidad Telenu!</h4>
                        </div>
                        <div class="modal-body">
                            <ul class="text-center">
                                <form action="http://telenu.tv/resources/php/register.php" method="post" name="register" enctype="multipart/form-data">
                                    <li>
                                        <input type="text" name="First_Name" class="form-control text-center" required="required" placeholder="Nombre">
                                    </li>
                                    <li>
                                        <input type="text" name="Last_Name" class="form-control text-center" required="required" placeholder="Apellido(s)">
                                    </li>
                                    <li>
                                        <input type="text" name="User_Name" class="form-control text-center" required="required" placeholder="Usuario">
                                    </li>
                                    <li>
                                        <input type="email" name="Email" class="form-control text-center" required="required" placeholder="E-mail">
                                    </li>
                                    <li>
                                        <input type="password" name="Password" class="form-control text-center" required="required" placeholder="Contraseña">
                                    </li>
                                    <li>
                                        <input type="password" name="Password2" class="form-control text-center" required="required" placeholder="Confirmar contraseña">
                                    </li>
                                    <li class="image-select">
                                        <input type="radio" class="image-input" id="UserImage1" name="UserImage" value="boy" <?php if (isset($UserImage) && $UserImage=="boy") echo "checked";?> checked>
                                        <label for="UserImage1" class="input-image" style="background-image:url('http://telenu.tv/resources/images/user/boy.png')"></label>
                                        <input type="radio" class="image-input" id="UserImage2" name="UserImage" value="girl" <?php if (isset($UserImage) && $UserImage=="girl") echo "checked";?>>
                                        <label for="UserImage2" class="input-image" style="background-image:url('http://telenu.tv/resources/images/user/girl.png')"></label>
                                        <input type="radio" class="image-input" id="UserImage3" name="UserImage" value="surfer" <?php if (isset($UserImage) && $UserImage=="surfer") echo "checked";?>>
                                        <label for="UserImage3" class="input-image" style="background-image:url('http://telenu.tv/resources/images/user/surfer.png')"></label>
                                        <input type="radio" class="image-input" id="UserImage4" name="UserImage" value="vampire" <?php if (isset($UserImage) && $UserImage=="vampire") echo "checked";?>>
                                        <label for="UserImage4" class="input-image" style="background-image:url('http://telenu.tv/resources/images/user/vampire.png')"></label>
                                        <input type="radio" class="image-input" id="UserImage5" name="UserImage" value="alien" <?php if (isset($UserImage) && $UserImage=="alien") echo "checked";?>>
                                        <label for="UserImage5" class="input-image" style="background-image:url('http://telenu.tv/resources/images/user/alien.png')"></label>
                                        <input type="file" class="image-input-file" id="UserImageUpload" name="UserImageUpload" accept="image/*">
                                        <label for="UserImageUpload" class="input-image-file" id="displayUpload" style="background-image:url('http://telenu.tv/resources/images/user/chooseicon.png')"></label>
                                    </li>
                                    <li>
                                        <input type="submit" name="Register" class="btn btn-default" value="Registrar">
                                    </li>
                                </form>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        
                        reader.onload = function (e) {
                            $('.image-input').attr("checked", false);
                            $('#displayUpload').css({
                                'background-image': 'url(' + e.target.result + ')', 
                                'border-color'    : '#8d2533',
                                'border-width'    : '4px'
                            });
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
                
                $("#UserImageUpload").change(function(){
                    readURL(this);
                });
            </script>

            <div id="showregister" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Bienvenido a  <img src="http://telenu.tv/resources/images/logo.png" alt="Telenu"></h4>
                        <h4><span>Lo mejor del Entretenimiento Digital</span></h4>
                        <h3>Series - Vlogs - Shows - Cortos</h4>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12 col-xs-offset-0">
                                <p>Regístrate Gratis:</p>
                                    <?php
                                        printFBlogin($_SESSION['loginUrl']);
                                    ?>
                                    <a href="#" id="modalSwitcher">
                                        <p class="regisbtn">Registro</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12 col-xs-offset-0">
                                <p>¿Ya estás registrado? Inicia sesión:</p>
                                    <form action="http://telenu.tv/resources/php/login.php" method="post" name="login" >
                                        <ul style="list-style:none">
                                            <li><input type="email" name="Email" class="form-control text-center" required="required" placeholder="E-mail"></li>
                                            <li><input type="password" name="Password" class="form-control text-center" required="required" placeholder="Contraseña"></li>
                                            <li><input type="submit" name="Login" class="btn btn-default" value="Ingresar"></li>
                                        </ul>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(window).load(function(){
                $('#modalSwitcher').click(function(event) {
                    event.preventDefault();
                    $('#showregister').modal('hide');
                    setTimeout(function() {
                        $('#regis').modal('show');
                    }, 500);
                });
                $("#showregister").modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
            });
        </script>

        <?php } else {
            $conn = db_connect();

            $stmt = $conn->prepare("SELECT rlist FROM recents WHERE recents.UID = ?");
            $stmt->execute(array($_COOKIE["id"]));
            $recentsList = $stmt->fetchColumn();
            $recentsArray = explode(',', $recentsList);

            while (count($recentsArray) > 4) {
                array_pop($recentsArray);
            }

            $recents = array();
            $stmt = $conn->prepare("SELECT channel.ID, channel.ChN, channel.ChL, ChThmb FROM channel JOIN chanimg ON channel.ID = chanimg.ChID WHERE channel.ID = ?");
            foreach ($recentsArray as $value) {
                $stmt->execute(array($value));
                $recents[] = $stmt->fetch();
            }

            $stmt = $conn->prepare("SELECT mlist FROM mylist WHERE mylist.UID = ?");
            $stmt->execute(array($_COOKIE["id"]));
            $myList = $stmt->fetchColumn();
            $myListArray = explode(',', $myList);

            $list = array();
            $stmt = $conn->prepare("SELECT channel.ID, channel.ChN, channel.ChL, ChThmb FROM channel JOIN chanimg ON channel.ID = chanimg.ChID WHERE channel.ID = ?");
            foreach ($myListArray as $value) {
                $stmt->execute(array($value));
                $list[] = $stmt->fetch();
            }
            ?>
            <div id="showlogin" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <?php 
                                if (isset($_SESSION["showLogin"])) {
                                    if (isset($_SESSION["firstLogin"]) && $_SESSION["firstLogin"] == "yes") {
                                        echo '<h4 class="modal-title">Bienvenido a Telenú, <span>'.$_SESSION["User_Name"].'</span></h4>';
                                    } else {
                                        echo '<h4 class="modal-title">Bienvenido, <span>'.$_SESSION["User_Name"].'</span></h4>';
                                    }
                                } else {
                                    echo '<h4 class="modal-title"><span>'.$_SESSION["User_Name"].'</span></h4>';
                                }
                            ?>
                            <div style="background-image: url(<?= $_SESSION["Picture"] ?>);"></div>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <?php
                                    if (isset($_SESSION["firstLogin"]) && $_SESSION["firstLogin"] == "yes") {
                                        $_SESSION["firstLogin"] = "no";
                                        echo '<div class="col-xs-10 col-xs-offset-1">'
                                            ,'<h4 style="text-transform:inherit;margin:30px 0;">Disfruta del mejor entretenimiento digitial independiente, realizado por creadores de todo el mundo.</h4>'
                                            ,'</div>';
                                    } else {
                                        if ($recents[0] != false || $list[0] != false) {
                                            echo '<div class="col-md-6 col-xs-12">'
                                                ,'<h4>Seguir viendo</h4>';
                                            if ($recents[0] != false) {
                                                foreach ($recents as $channel) {
                                                    echo '<a class="videothumb" href="http://telenu.tv/channel/',$channel['ChL'],'">'
                                                        ,'<img class="img-responsive" src="http://telenu.tv/resources/images/channel/',$channel['ChThmb'],'" alt="',$channel['ChN'],'">'
                                                        ,'</a>';
                                                }
                                            } else {
                                                echo '<p>Visita canales y automáticamente quedarán registrados aquí para que puedas seguir disfrutando de su contenido.</p>';
                                            }
                                            if (count($recents) % 2 == 1) { echo '<div style="display:inline-block;width:45%;margin:2%;"></div>';}
                                            echo '</div>'
                                                ,'<div id="mylist" class="col-md-6 col-xs-12">';
                                            echo '<h4>Mi Lista</h4>';
                                            if ($list[0] != false) {
                                                foreach ($list as $channel) {
                                                    echo '<a class="videothumb" href="http://telenu.tv/channel/',$channel['ChL'],'">'
                                                        ,'<img class="img-responsive" src="http://telenu.tv/resources/images/channel/',$channel['ChThmb'],'" alt="',$channel['ChN'],'">'
                                                        ,'</a>';
                                                }
                                            } else {
                                                echo '<p>Agrega canales a tu lista para verlos enlistados aquí.</p>';
                                            }
                                            if (count($list) % 2 == 1) { echo '<div style="display:inline-block;width:45%;margin:2%;"></div>';}
                                            echo '</div>';
                                        } else {
                                            echo '<div class="col-xs-12">'
                                                ,'<h4>Recomendaciones</h4>';
                                            $stmt = $conn->prepare("SELECT channel.ID, channel.ChN, channel.ChL, ChThmb FROM channel JOIN chanimg ON channel.ID = chanimg.ChID ORDER BY RAND() LIMIT 8");
                                            $stmt->execute();
                                            $recomended = $stmt->fetchAll();
                                            foreach ($recomended as $channel) {
                                                echo '<a class="videothumb" href="http://telenu.tv/channel/',$channel['ChL'],'">'
                                                    ,'<img class="img-responsive" src="http://telenu.tv/resources/images/channel/',$channel['ChThmb'],'" alt="',$channel['ChN'],'" style="width:20%">'
                                                    ,'</a>';
                                            }
                                            echo '</div>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
    }

    function loadRecents() {
        if (isset($_SESSION["showLogin"])) { ?>
            <script type="text/javascript">
                $(window).load(function(){
                    $('#showlogin').modal('show');
                });
            </script> 
            <?php unset($_SESSION["showLogin"]);
        }
    }

    function fetchLinksNav($type) {
        $conn =  db_connect();

        $stmt = $conn->prepare("SELECT ChN, ChL FROM channel WHERE channel.ChT = ? ORDER BY ChN");
        $stmt->execute(array($type));
        $selection = $stmt->fetchAll();

        foreach ($selection as $row) {
            echo '<li><a href="http://telenu.tv/channel/',$row['ChL'],'">',$row['ChN'],'</a></li>';
        }
    }
?>