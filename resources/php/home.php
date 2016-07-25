<?php
    require "vendor/twitteroauth/autoloader.php";
    use Abraham\TwitterOAuth\TwitterOAuth;

    $consumer_key = "XQsFyYuHe1PwZJJTFwBBq2n5m";
    $consumer_secret = "WuSCZbrxPOuRgOwZPzZYDrTtllhxEdqcEMChaztMb45q7NfJL0";
    $access_token = "4827743185-V8V5Zh4n4Efmm3mSI3O5gRtxK6d5wCfPmspzcXI";
    $access_token_secret = "n9pK0w6BXvN7BbsTaTZvC78P4mJbGkEEbvyrlFUts8IZj";

    $connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);

    $statuses = $connection->get("statuses/user_timeline");

    function fetchFeed($statuses) {
        for ($i=0; $i < 3; $i++) { 
            echo '<li><a href="https://twitter.com/TelenuTv/status/',$statuses[$i]->id_str,'" target="_blank"><p>',$statuses[$i]->text,'</p></a></li>';
        }
    }

    function url_get_contents ($Url) {
        if (!function_exists('curl_init')){ 
            die('CURL is not installed!');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    $IAT = "3067589763.a9ae20a.a9b40b2e592e4b06b2c30e28251c2f35";

    $channelData = json_decode(url_get_contents("https://api.instagram.com/v1/users/self/media/recent/?access_token=$IAT"), true);

    function fetchInstagram($channelData) {
        echo '<a href="',$channelData['data']['0']['link'],'" target="_blank">';
        if ( $_SESSION["detect"]->isMobile() ) {
            echo '<div class="grid-item over-black instagramfeed" style="background-image: url(',$channelData['data']['0']['images']['standard_resolution']['url'],')">';
        } else {
            echo '<div class="grid-item grid-item--height2 over-black instagramfeed teaser lazyload" data-expand="-80" style="background-image: url(',$channelData['data']['0']['images']['standard_resolution']['url'],')">';
        }
        echo '<i class="fa fa-2x fa-instagram"></i></div></a>';
    }

    function fetchContent($statuses, $channelData) {
        if ( $_SESSION["detect"]->isMobile() ) { ?>
            <a href="series/drama">
                <div class="grid-item grid-item--height3 over-red" style="background-image: url(http://telenu.tv/resources/images/drama.jpg)">
                    <div>Drama</div>
                </div>
            </a>
            <a href="series/animacion">
                <div class="grid-item grid-item--height2 over-blue" style="background-image: url(http://telenu.tv/resources/images/animacion.jpg)">
                    <div>Animación</div>
                </div>
            </a>
            <a href="#">
                <div class="grid-item over-red" style="background-image: url(resources/images/foroabierto.jpg)">
                    <div><img src="http://telenu.tv/resources/images/logoabierto.png" alt="Foro"><br>Próximamente</div>
                </div>
            </a>
            <a href="series/comedia">
                <div class="grid-item over-blue" style="background-image: url(http://telenu.tv/resources/images/comedia.jpg)">
                    <div>Comedia</div>
                </div>
            </a>
            <a href="series/fantasia_scifi">
                <div class="grid-item grid-item--height2 over-red" style="background-image: url(http://telenu.tv/resources/images/scifi-m.jpg)">
                    <div>Fantasía / Scifi</div>
                </div>
            </a>
            <a href="series/accion_aventura">
                <div class="grid-item over-blue" style="background-image: url(http://telenu.tv/resources/images/aventura.jpg)">
                    <div>Acción / Aventura</div>
                </div>
            </a>
            <?php fetchInstagram($channelData); ?>
            <a href="channel/EsquinaDelCine">
                <div class="grid-item over-red" style="background-image: url(http://telenu.tv/resources/images/channel/delcine_logo.jpg)">
                    <div>Esquina del Cine</div>
                </div>
            </a>
            <a href="series/terror">
                <div class="grid-item over-blue" style="background-image: url(http://telenu.tv/resources/images/terror.jpg)">
                    <div>Terror</div>
                </div>
            </a>
            <div class="grid-item grid-item--height3 twitterfeed">
                <div style="top: 0; transform: none;">
                    <!-- <i class="fa fa-3x fa-twitter"></i> -->
                    <div class="flexslider">
                        <ul class="slides">
                            <?php fetchFeed($statuses); ?>
                        </ul>
                    </div>
                </div>
                <p>Síguenos en Twitter <a href="https://twitter.com/telenutv" target="_blank">@Telenu.TV</a>!</p>
            </div>
            <a href="http://www.bajawebfest.com/" target="_blank">
                <div class="grid-item advert" style="background-image: url(http://telenu.tv/resources/images/bwf2016.jpg)">
                </div>
            </a>
            <a href="series/documental">
                <div class="grid-item over-red" style="background-image: url(http://telenu.tv/resources/images/documental.jpg)">
                    <div>Documental</div>
                </div>
            </a>
        <?php } else { ?>
            <a href="series/drama">
                <div class="grid-item grid-item--height3 over-red" style="background-image: url(resources/images/drama.jpg)">
                    <div>Drama</div>
                </div>
            </a>
            <a href="series/animacion">
                <div class="grid-item grid-item--height2 over-blue" style="background-image: url(resources/images/animacion.jpg)">
                    <div>Animación</div>
                </div>
            </a>
            <a href="#">
                <div class="grid-item over-red" style="background-image: url(resources/images/foroabierto.jpg)">
                    <div><img src="http://telenu.tv/resources/images/vinilos3.png" alt="Foro"><br>Próximamente</div>
                </div>
            </a>
            <a href="series/comedia">
                <div class="grid-item over-blue teaser lazyload" data-expand="-80" style="background-image: url(resources/images/comedia.jpg)">
                    <div>Comedia</div>
                </div>
            </a>
            <?php fetchInstagram($channelData); ?>
            <a href="series/accion_aventura">
                <div class="grid-item over-blue teaser lazyload" data-expand="-80" style="background-image: url(resources/images/aventura.jpg)">
                    <div>Acción / Aventura</div>
                </div>
            </a>
            <a href="http://www.bajawebfest.com/" target="_blank">
                <div class="grid-item teaser lazyload advert" data-expand="-80" style="background-image: url(resources/images/bwf2016.jpg)">
                </div>
            </a>
            <a href="channel/EsquinaDelCine">
                <div class="grid-item over-red teaser lazyload" data-expand="-80" style="background-image: url(resources/images/channel/delcine_logo.jpg)">
                    <div>Esquina del Cine</div>
                </div>
            </a>
            <a href="series/terror">
                <div class="grid-item over-blue teaser lazyload" data-expand="-80" style="background-image: url(resources/images/terror.jpg)">
                    <div>Terror</div>
                </div>
            </a>
            <a href="series/fantasia_scifi">
                <div class="grid-item grid-item--height3 over-red teaser lazyload" data-expand="-80" style="background-image: url(resources/images/scifi.jpg)">
                    <div>Fantasía / Scifi</div>
                </div>
            </a>
            <a href="series/documental">
                <div class="grid-item over-blue teaser lazyload" data-expand="-80" style="background-image: url(resources/images/documental.jpg)">
                    <div>
                        <p style="font-style:italic">Documental</p>
                    </div>
                </div>
            </a>
            <div class="grid-item twitterfeed teaser lazyload" data-expand="-80">
                <div class="vertical-center">
                    <!-- <i class="fa fa-3x fa-twitter"></i> -->
                    <div class="flexslider">
                        <ul class="slides" style="margin-top:20px">
                            <?php fetchFeed($statuses); ?>
                        </ul>
                    </div>
                </div>
                <p>Síguenos en Twitter <a href="https://twitter.com/telenutv" target="_blank">@Telenu.TV</a>!</p>
            </div>
        <?php }
    }
?>