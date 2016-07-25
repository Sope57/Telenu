<?php
    require $_SERVER['DOCUMENT_ROOT'].'/resources/php/connToServer.php';
    require $_SERVER['DOCUMENT_ROOT'].'/resources/php/getSession.php';    
    require $_SERVER['DOCUMENT_ROOT'].'/resources/php/channel.php';
    $stmt = $conn->prepare("SELECT channel.ID, channel.ChN, channel.ChL, channel.ChY, channel.ChT, ChBnr, ChThmb, chaninfoseries.* FROM channel JOIN chanimg ON channel.ID = chanimg.ChID JOIN chaninfoseries ON channel.ID = chaninfoseries.ChID WHERE channel.ChL = ?");
    $stmt->execute(array($_GET['c']));
    $_SESSION['ChInfo'] = $stmt->fetch();
    if(isset($_COOKIE["id"])){
        updateRecents();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, maximum-scale=1.0">
        <meta property="og:title" content="<?= $_SESSION['ChInfo']['ChN'] ?>"/>
        <?php
            get_video_data();
            if (isset($_GET["v"])) {
                echo '<meta property="og:url" content="http://telenu.tv/channel/'.$_SESSION['ChInfo']['ChL'].'&v='.$_GET["v"].'"/>';
                echo '<meta property="og:description" content="'.$_SESSION['media'][$_SESSION['index']]['mediaTitle'].'"/>';
                echo '<meta property="og:image" content="'.$_SESSION['media'][$_SESSION['index']]['mediaThumbnail'].'"/>';
                echo '<meta property="og:image:width" content="320" />';
                echo '<meta property="og:image:height" content="180" />';
                echo '<link rel="canonical" href="http://telenu.tv/channel/'.$_SESSION['ChInfo']['ChL'].'&v='.$_GET["v"].'"/>';
            } else {
                echo '<meta property="og:url" content="http://telenu.tv/channel/'.$_SESSION['ChInfo']['ChL'].'"/>';
                echo '<meta property="og:description" content="¡Disfruta lo mejor del entretenimiento digital independiente por TELENU!"/>';
                echo '<meta property="og:image" content="http://telenu.tv/resources/images/channel/'.$_SESSION['ChInfo']['ChThmb'].'"/>';
                echo '<meta property="og:image:width" content="500" />';
                echo '<meta property="og:image:height" content="300" />';
                echo '<link rel="canonical" href="http://telenu.tv/channel/'.$_SESSION['ChInfo']['ChL'].'"/>';
            }
        ?>
        <title><?= $_SESSION['ChInfo']['ChN'] ?></title>
        <link rel="icon" type="image/x-icon" href="http://telenu.tv/resources/images/favicon.ico">
        <link href='https://fonts.googleapis.com/css?family=Roboto:500,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="http://telenu.tv/vendor/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="http://telenu.tv/vendor/owl/assets/owl.carousel.min.css">
        <?php if (!$_SESSION["detect"]->isMobile()) { echo '<link rel="stylesheet" type="text/css" href="../resources/css/style.css" />'; } else { echo '<link rel="stylesheet" type="text/css" href="../resources/css/style-movil.css" />'; } ?>
        <script type="text/javascript" src="http://telenu.tv/vendor/jquery.min.js"></script>
        <script type="text/javascript" src="https://f.vimeocdn.com/js/froogaloop2.min.js"></script>
        <script type="text/javascript" src="http://malsup.github.com/jquery.form.js"></script>
    </head>
    <body>
        <?php 
            include_once($_SERVER['DOCUMENT_ROOT']."/resources/php/analyticstracking.php");
            
            if ($_SESSION["detect"]->isMobile()) { echo '<div id="o-wrapper" class="o-wrapper">'; }
            loadUserMenu(); 
        ?>
        <section id="banner">
            <div class="bannerOverlay" style="background-image:url(http://telenu.tv/resources/images/channel/<?= $_SESSION['ChInfo']['ChBnr'] ?>)">
                <div class="channelInfo">
                    <div class="channelTitle">
                        <div id="linkAnchor" style="position:absolute;bottom:80px;"></div>
                        <?php
                            if (!$_SESSION["detect"]->isMobile()) {
                                if ($_SESSION['ChInfo']['ChT'] == "series" || $_SESSION['ChInfo']['ChT'] == "short") {
                                    echo '<div class="container-fluid channelTechnical">'
                                        ,'<div class="row">'
                                        ,'<div class="col-xs-6 col-xs-offset-0 col-sm-4 col-sm-offset-2">';
                                    if ($_SESSION['ChInfo']['ChT'] != "short") { echo '<p>Creador: <span>',$_SESSION['ChInfo']['Cre'],'</span></p>'; }
                                    if ($_SESSION['ChInfo']['Dir']) { echo '<p>Director: <span>',$_SESSION['ChInfo']['Dir'],'</span></p>'; }
                                    if ($_SESSION['ChInfo']['Wri']) { echo '<p>Escritor: <span>',$_SESSION['ChInfo']['Wri'],'</span></p>'; }
                                    if ($_SESSION['ChInfo']['Pro']) { echo '<p>Productor: <span>',$_SESSION['ChInfo']['Pro'],'</span></p>'; }
                                    if ($_SESSION['ChInfo']['Pho']) { echo '<p>Fotografía: <span>',$_SESSION['ChInfo']['Pho'],'</span></p>'; }
                                    if ($_SESSION['ChInfo']['Edi']) { echo '<p>Edición: <span>',$_SESSION['ChInfo']['Edi'],'</span></p>'; }
                                    if ($_SESSION['ChInfo']['Com']) { echo '<p>Música: <span>',$_SESSION['ChInfo']['Com'],'</span></p>'; }
                                    echo '</div><div class="col-xs-6 col-sm-4">';
                                    if ($_SESSION['ChInfo']['Coun']) { echo '<p>País: <span>',$_SESSION['ChInfo']['Coun'],'</span></p>'; }
                                    if ($_SESSION['ChInfo']['Cast']) { echo '<p>Reparto: <span>',$_SESSION['ChInfo']['Cast'],'</span></p>'; }
                                    echo '<p>Sinopsis: <span>',$_SESSION['ChInfo']['Syn'],'</span></p>'
                                        ,'</div></div></div>';
                                }
                            }
                        ?>
                        <div class="vertical-center">
                            <?php 
                                if ($_SESSION['ChInfo']['ChT'] == "series" && ($_SESSION['ChInfo']['ChY'] != "None" && $_SESSION['ChInfo']['ChY'] != "Tele")) {
                                    echo '<div class="selectionImage" style="background-image:url(\'http://telenu.tv/resources/images/seleccion',$_SESSION['ChInfo']['ChY'],'.png\');"></div>';
                                }
                                echo '<h1>',$_SESSION['ChInfo']['ChN'],'</h1>'
                                    ,'<h2>',$_SESSION['ChInfo']['Genre'],'</h2>';
                                if ($_SESSION['ChInfo']['ChT'] == "webshow" || $_SESSION['ChInfo']['ChT'] == "vlog") {
                                    echo '<p>',$_SESSION['ChInfo']['Syn'],'</p>';
                                }
                            ?>
                        </div>
                    </div>
                    <?php
                        if ($_SESSION['ChInfo']['ChT'] == "series" || $_SESSION['ChInfo']['ChT'] == "short") {
                            if ($_SESSION["detect"]->isMobile()) {
                                echo '<div id="channelTrigger"><a class="btn btn-default" href="#" data-toggle="modal" data-target="#credits">Créditos</a></div>';
                            } else {
                                echo '<div id="channelTrigger"><i class="fa fa-4x fa-caret-up"></i></div>';
                            }
                        }
                    ?>
                </div>
            </div>      
        </section>

        <?php 
            echo '<div class="container-fluid" id="pageTitle">'
                ,'<div></div>'
                ,'<p class="videoDataContainer" id="videoDataContainer">';
                print_player();
                echo '</p>'
            ,'</div>';
        ?>

        <section id="playerWide">
            <div class="container">
                <div class="row">
                    <?php if ($_SESSION["detect"]->isMobile()) { echo '<div class="col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0">'; } else { echo '<div class="col-xs-10 col-xs-offset-1">'; } ?>
                        <div class="video-container">
                            <?php
                                switch ($_SESSION['media'][$_SESSION['index']]['mediaSource']) {
                                    case 'youtube': ?>
                                        <iframe id="player" type="text/html" src="http://www.youtube.com/embed/<?= $_SESSION['vidkey'] ?>?enablejsapi=1&autoplay=0&rel=0&modestbranding=1&autohide=1" frameborder="0" allowfullscreen></iframe>
                                        <script>
                                            var tag = document.createElement('script');
                                            tag.src = "http://www.youtube.com/player_api";
                                            var firstScriptTag = document.getElementsByTagName('script')[0];
                                            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                                            var player;
                                            function onYouTubeIframeAPIReady() {
                                                player = new YT.Player('player', {
                                                    events: {
                                                        'onStateChange': onPlayerStateChange
                                                    }
                                                });
                                            }

                                            function onPlayerStateChange(event) {        
                                                if(event.data === 0) {
                                                    $.ajax({ url: 'http://telenu.tv/resources/php/channel.php',
                                                        data: {action: 'update_index'},
                                                        type: 'post',
                                                        success: function(response) {
                                                            if (response['vidkey'] != null) {
                                                                update_video_data(response['index']);
                                                                player.loadVideoById(response['vidkey']);
                                                                updateUrlLink(response['vidkey'], "<?= $_SESSION['ChInfo']['ChL'] ?>");
                                                            }
                                                        }
                                                    });
                                                }
                                            }
                                        </script>
                                        <?php
                                        break;
                                    case 'vimeo': ?>
                                        <iframe id="player1" src="https://player.vimeo.com/video/<?= $_SESSION['vidkey'] ?>?autoplay=0&api=1&player_id=player1" width="630" height="354" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                        <script>
                                            var iframe = $('#player1')[0];
                                            var player = $f(iframe);

                                            player.addEvent('ready', function() {
                                                player.addEvent('finish', onFinish);
                                            });

                                            function onFinish() {
                                                player.api("pause");
                                                $.ajax({ url: 'http://telenu.tv/resources/php/channel.php',
                                                    data: {action: 'update_index'},
                                                    type: 'post',
                                                    success: function(response) {
                                                        if (response['vidkey'] != null) {
                                                            update_video_data(response['index']);
                                                            player.api("loadVideo", response['vidkey']);
                                                            // setTimeout(function(){
                                                            //     player.api("play");
                                                            // }, 2000);
                                                        }
                                                    }
                                                });
                                            }
                                        </script>
                                        <?php
                                        break;
                                }
                            ?>
                        </div>
                    </div>

                    <div class="col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0">
                        <div id="telenumetro">
                            <?php
                                if (!empty($_COOKIE["id"])) {
                                    $stmt = $conn->prepare("SELECT rating FROM ratings WHERE ChID = ? AND ratedBy = ?");
                                    $stmt->execute(array($_SESSION['ChInfo']['ID'], $_COOKIE["id"]));
                                    $rating = $stmt->fetch();
                                    if (empty($rating)) {
                                        $rating['rating'] = 2;
                                    }
                                } else {
                                    $rating['rating'] = 2;
                                }
                             ?>
                            <form id="ratingForm" action="../resources/php/rate.php" method="post" name="ratingForm">
                                <input type="hidden" name="channelID" value="<?= $_SESSION['ChInfo']['ID'] ?>"/>
                                <div class="left">
                                    <input type="radio" class="rating-input" id="rating-input-1-1" name="rating-input-1" value="1" onClick="postRating();"/>
                                    <label id="1" for="rating-input-1-1" class="rating-star <?php if ($rating['rating']==1) { echo 'checked'; } ?>"><div></div></label>
                                </div>
                                <div id="center">
                                    <span id="meter">
                                        <?php 
                                            get_rating_data();
                                            if (!$_SESSION['ChInfo']['isRated']) {
                                                echo '<span id="isRated">¡Sé el primero en calificar ésta serie!</span>';
                                            }

                                            echo '<span id="telep" style="width:'.$_SESSION['ChInfo']['rating'].'%"></span>';
                                            echo '<span id="telen" style="width:'.$_SESSION['ChInfo']['ratingn'].'%"></span>';
                                         ?>
                                    </span>
                                </div>
                                <div class="right">
                                    <input type="radio" class="rating-input" id="rating-input-1-0" name="rating-input-1" value="0" onClick="postRating();"/>
                                    <label id="0" for="rating-input-1-0" class="rating-star <?php if ($rating['rating']==0) { echo 'checked'; } ?>"><div></div></label>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0"> 
                        <ul id="social-share" class="social-share">
                            <?php fetch_social_share(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>        

        <?php if ($_SESSION['ChInfo']['ChT'] != "short") { ?>
            <section id="channelVideos">
                <div class="container">
                    <div class="row">
                        <div id="viewControls">
                            <img id="carouselButton" src="http://telenu.tv/resources/images/carousel_view.png" class="activeView">
                            <img id="gridButton" src="http://telenu.tv/resources/images/grid_view.png">
                        </div>
                    </div>
                    <div id="carouselView">
                        <div class="owl-carousel" id="videoCarousel"> 
                            <?php
                                foreach ($_SESSION['media'] as $index => $video) {
                                    echo '<div class="item">';
                                        switch ($video['mediaSource']) {
                                            case 'youtube':
                                                echo '<a class="videothumb navigator text-center" id="',$index,'" href="#linkAnchor" data-vidkey="',$video['mediaId'],'" onClick="player.loadVideoById(\'',$video['mediaId'],'\'); updateVideoData(this.id); updateUrlLink(\'',$video['mediaId'],'\', \'',$_SESSION['ChInfo']['ChL'],'\');">';
                                                break;
                                            case 'vimeo':
                                                echo '<a class="videothumb navigator text-center" id="',$index,'" href="#linkAnchor" onClick="player.api(\'loadVideo\', \'',$video['mediaId'],'\'); updateVideoData(this.id);">';
                                                break;
                                        }
                                    echo '<img class="img-responsive" src="',$video['mediaThumbnail'],'" alt="',$video['mediaThumbnail'],'">'
                                        ,'<h3 class="title3">',$video['mediaTitle'],'</h3>';
                                        if ($_SESSION['ChInfo']['ChT'] == "series") {
                                            echo '<h4 class="title4">Temporada ',$video['mediaSeason'],'</h4>';
                                        }
                                    echo '</a></div>';
                                }
                             ?>
                        </div>
                    </div>
                    <div id="gridView" class="hidden">
                        <?php
                            foreach ($_SESSION['media'] as $index => $video) {
                                switch ($video['mediaSource']) {
                                    case 'youtube':
                                        echo '<a class="videothumb navigator text-center" id="',$index,'" href="#pageTitle" data-vidkey="',$video['mediaId'],'" onClick="player.loadVideoById(\'',$video['mediaId'],'\'); updateVideoData(this.id); updateUrlLink(\'',$video['mediaId'],'\', \'',$_SESSION['ChInfo']['ChL'],'\');">';
                                        break;
                                    case 'vimeo':
                                        echo '<a class="videothumb navigator text-center" id="',$index,'" href="#pageTitle" onClick="player.api(\'loadVideo\', \'',$video['mediaId'],'\'); updateVideoData(this.id);">';
                                        break;
                                }
                                echo '<img class="img-responsive" src="',$video['mediaThumbnail'],'" alt="',$video['mediaThumbnail'],'">'
                                    ,'<h3 class="title3">',$video['mediaTitle'],'</h3>';
                                    if ($_SESSION['ChInfo']['ChT'] == "series") {
                                            echo '<h4 class="title4">Temporada ',$video['mediaSeason'],'</h4>';
                                        }
                                    echo '</a>';
                            }
                            if (count($_SESSION['media']) % 3 == 2) { echo '<div style="width:300px"></div>';}
                         ?>
                    </div>
                </div>
            </section>
        <?php } ?>

        <section id="commentSection">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="comments" id="comments">
                            <?php get_comments(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <img src="http://telenu.tv/resources/images/logo.png" alt="">
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

                if ($_SESSION['ChInfo']['ChT'] != "short") { echo '<p>Creador: <span>',$_SESSION['ChInfo']['Cre'],'</span></p>'; }
                if ($_SESSION['ChInfo']['Dir']) { echo '<p>Director: <span>',$_SESSION['ChInfo']['Dir'],'</span></p>'; }
                if ($_SESSION['ChInfo']['Wri']) { echo '<p>Escritor: <span>',$_SESSION['ChInfo']['Wri'],'</span></p>'; }
                if ($_SESSION['ChInfo']['Pro']) { echo '<p>Productor: <span>',$_SESSION['ChInfo']['Pro'],'</span></p>'; }
                if ($_SESSION['ChInfo']['Pho']) { echo '<p>Fotografía: <span>',$_SESSION['ChInfo']['Pho'],'</span></p>'; }
                if ($_SESSION['ChInfo']['Edi']) { echo '<p>Edición: <span>',$_SESSION['ChInfo']['Edi'],'</span></p>'; }
                if ($_SESSION['ChInfo']['Com']) { echo '<p>Música: <span>',$_SESSION['ChInfo']['Com'],'</span></p>'; }
                if ($_SESSION['ChInfo']['Coun']) { echo '<p>País: <span>',$_SESSION['ChInfo']['Coun'],'</span></p>'; }
                if ($_SESSION['ChInfo']['Cast']) { echo '<p>Reparto: <span>',$_SESSION['ChInfo']['Cast'],'</span></p>'; }
                echo '<p>Sinopsis: <span>',$_SESSION['ChInfo']['Syn'],'</span></p>';
                echo '</div></div></div></div></div></div></div>'; 
            } 
        ?>

        <div id="emailshare" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <p class="text-center">¡Comparte con tus amigos tu series favoritas!</p>
                        <h4 class="modal-title"><?= $_SESSION['ChInfo']['ChN'] ?></h4>
                    </div>
                    <div class="modal-body">
                        <ul class="text-center">
                            <form action="http://telenu.tv/resources/php/sendseries.php" method="post" name="SendSeries">
                                <li>
                                    <input type="email" name="Receiver" class="form-control text-center" required="required" placeholder="Enviar a (correo):">
                                </li>
                                <li>
                                    <input type="email" name="Sender" class="form-control text-center" required="required" placeholder="Tu correo">
                                </li>
                                <li>
                                    <input type="text" name="SenderName" class="form-control text-center" required="required" placeholder="Tu nombre">
                                </li>
                                <li>
                                    <input type="text" name="Message" class="form-control text-center" placeholder="Mensaje (Opcional)">
                                </li>
                                <input type="submit" name="SendSeries" class="btn btn-default" value="Enviar">
                            </form>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="http://telenu.tv/vendor/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="http://telenu.tv/vendor/owl/owl.carousel.min.js"></script>
        <script type="text/javascript" src="http://telenu.tv/vendor/jquery.dotdotdot.min.js"></script>
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
        <script type="text/javascript" src="http://telenu.tv/resources/js/script.js"></script>
        <script type="text/javascript" src="http://telenu.tv/resources/js/channel.js"></script>

        <?php loadRegister(); ?>
        <?php loadRecents(); ?>
    </body>
</html>













