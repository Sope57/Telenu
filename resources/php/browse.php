<?php
    
    if (isset($_GET['g'])) {
        $replace = array("accion_aventura", "animacion", "fantasia_scifi");
        $replacewith = array("acción/aventura", "animación", "fantasía/scifi");
        $genre = str_replace($replace, $replacewith, $_GET['g']);
    }

    function updateMyList($index) {
        include 'connToServer.php';
        $conn = db_connect();

        $stmt = $conn->prepare("SELECT ID, mlist FROM mylist WHERE mylist.UID = ?");
        $stmt->execute(array($_COOKIE["id"]));
        $myList = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($myList)) {
            $stmt = $conn->prepare("INSERT INTO mylist (mlist, UID) VALUES (?, ?)");
            $stmt->execute(array($index, $_COOKIE["id"]));

            $myListArray = array($index);
            addToListButton($myListArray, $index);
        } else {
            if (!empty($myList['mlist'])) {
                $myListArray = explode(',', $myList['mlist']);

                if (in_array($index, $myListArray)) {
                    $pushIndex = array_search($index, $myListArray);
                    unset($myListArray[$pushIndex]);
                    $myListArray = array_values($myListArray);
                } else {
                    $pushIndex = count($myListArray);
                    for ($i = $pushIndex; $i > 0; $i--) { 
                        $myListArray[$i] = $myListArray[$i-1];
                    }
                    $myListArray[0] = $index;
                }
                $myNewList = implode(',', $myListArray);
                addToListButton($myListArray, $index);
            } else {
                $myNewList = $index;
                $myListArray = array($index);
                addToListButton($myListArray, $index);
            }

            $stmt = $conn->prepare("UPDATE mylist SET mlist = ? WHERE UID = ?");
            $stmt->execute(array($myNewList, $_COOKIE["id"]));
        } 
    }

    function fetchAllChannels($filter){
        $conn = db_connect();

        if (isset($_GET['g'])) {
            $stmt = $conn->prepare("SELECT channel.ID, ChN, ChL, ChY, ChThmb, Genre, Syn, Coun, Lan FROM channel JOIN chanimg ON channel.ID = chanimg.ChID JOIN chaninfoseries ON channel.ID = chaninfoseries.ChID  WHERE chaninfoseries.Genre = ? AND channel.ChT = ? ORDER BY ChN");
            $stmt->execute(array($filter, "series"));
        } elseif (isset($_GET['y'])) {
            $stmt = $conn->prepare("SELECT channel.ID, ChN, ChL, ChThmb, Genre, Syn, Coun, Lan FROM channel JOIN chanimg ON channel.ID = chanimg.ChID JOIN chaninfoseries ON channel.ID = chaninfoseries.ChID  WHERE channel.ChY = ? ORDER BY ChN");
            $stmt->execute(array($filter));
        }
        $selection = $stmt->fetchAll();

        if (isset($_COOKIE["id"])) {
            $stmt = $conn->prepare("SELECT mlist FROM mylist WHERE mylist.UID = ?");
            $stmt->execute(array($_COOKIE["id"]));
            $myList = $stmt->fetchColumn();
            if (empty($myList)) {
                $myListArray = array();
            } else {
                $myListArray = explode(',', $myList);
            }
        }

        foreach ($selection as $key => $row) {

            $stmt = $conn->prepare("SELECT rating FROM ratings WHERE ChID = ?");
            $stmt->execute(array($row['ID']));
            $result = $stmt->fetchAll();

            if (!empty($result)) {
                $sum = 0;
                foreach ($result as $value) {
                    $sum = $sum + $value['rating'];
                }
                $rating = ($sum/count($result))*100;
            } else {
                $rating = 50;
            }
            $ratingn = 100 - $rating;

            if ( $_SESSION["detect"]->isMobile() ) {
                $maxWidth = ($_SESSION["detect"]->isTablet()) ? 400 : 250; ?>
                <div href="../channel/<?= $row['ChL'] ?>" onmouseover="tooltip.pop(this, '#<?= $row['ChL'] ?>', {duration:0, position:4, offsetY:0, maxWidth:<?= $maxWidth ?>, overlay:true})">
                    <div class="grid-item over-black <?= $row['Genre']?>" data-category="<?= $row['Genre']?>" style="background-image:url(http://telenu.tv/resources/images/channel/<?= $row['ChThmb'] ?>)">
                        <div class="name"><?= $row['ChN']?></div>
                        <div style="display:none" class="rating"><?= $ratingn ?></div>
                    </div>
                </div>
                <div style="display:none;">
                    <div id="<?= $row['ChL'] ?>">
                        <img class="img-responsive" src="http://telenu.tv/resources/images/channel/<?= $row['ChThmb'] ?>">
                        <div>
                            <p><?= $row['ChN']?></p>
                            <?php if ( $_SESSION["detect"]->isTablet() ) { echo '<p><span>',$row['Genre'],'</span> / <span>',$row['Lan'],'</span> / <span>',$row['Coun'],'</span></p>'; } ?>
                            <span class="ratingInfo">
                                <img src="../resources/images/score.png">
                                <span class="ratingbarp" style="width:<?= $rating ?>%"></span>
                                <span class="ratingbarn" style="width:<?= $ratingn ?>%"></span>
                            </span>
                        </div>
                        <?php if ( !$_SESSION["detect"]->isTablet() ) { echo '<p><span>',$row['Genre'],'</span> / <span>',$row['Lan'],'</span> / <span>',$row['Coun'],'</span></p>'; } ?>

                        <p><?= $row['Syn'] ?></p> 
                        <div>
                            <a class="btn btn-default" href="http://telenu.tv/channel/<?= $row['ChL'] ?>"><i class="fa fa-play"></i> Ver ahora</a>
                        </div>
                        <div id="add<?= $row['ID'] ?>toList" class="add<?= $row['ID'] ?>toList">
                            <?php addToListButton($myListArray, $row['ID']); ?>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <a href="../channel/<?= $row['ChL'] ?>" onmouseover="tooltip.pop(this, '#<?= $row['ChL'] ?>')">
                    <div class="grid-item over-black <?= $row['Genre']?>" data-category="<?= $row['Genre']?>" style="background-image:url(http://telenu.tv/resources/images/channel/<?= $row['ChThmb'] ?>)">
                        <div class="name"><?= $row['ChN']?></div>
                        <div style="display:none" class="rating"><?= $ratingn ?></div>
                    </div>
                </a>
                <div style="display:none;">
                    <div id="<?= $row['ChL'] ?>">
                        <p>
                            <span><?= $row['Genre'] ?></span> / <span><?= $row['Lan'] ?></span> / <span><?= $row['Coun'] ?></span>
                            <span class="ratingInfo">
                                <img src="../resources/images/score.png">
                                <span class="ratingbarp" style="width:<?= $rating ?>%"></span>
                                <span class="ratingbarn" style="width:<?= $ratingn ?>%"></span>
                            </span>
                        </p>
                        <p><?= $row['Syn'] ?></p>
                        <div id="add<?= $row['ID'] ?>toList" class="add<?= $row['ID'] ?>toList">
                            <?php addToListButton($myListArray, $row['ID']); ?>
                        </div>
                    </div>
                </div>
            <?php }
        }   
    }

    function addToListButton($myListArray, $index) {
        echo '<button id="' , $index , '" class="btn btn-secondary" onClick="addToList(this.id);">';
        if (in_array($index, $myListArray)) {
            echo '<i class="fa fa-minus-circle"></i> Remover de \'Mi Lista\'</button>';
        } else {
            echo '<i class="fa fa-plus-circle"></i> Agregar a \'Mi Lista\'</button>';
        }
    }

    function fetchFeatured($genre) {
        $conn = db_connect();

        $stmt = $conn->prepare("SELECT ChN, ChL, ChY, Genre, ChBnr FROM channel JOIN chanimg ON channel.ID = chanimg.ChID JOIN chaninfoseries ON channel.ID = chaninfoseries.ChID WHERE chaninfoseries.Genre = ? AND chaninfoseries.Win = 1 ORDER BY ChY DESC");
        $stmt->execute(array($genre));
        $featured = $stmt->fetchAll();

        echo '<ol class="carousel-indicators">';
        for ($i = 0; $i < count($featured); $i++) {
            if ($i == 0) { echo '<li data-target="#featured" data-slide-to="0" class="active"></li>'; }
            else { echo '<li data-target="#featured" data-slide-to="',$i,'"></li>'; }
        }
        echo '</ol><div class="carousel-inner" role="listbox">';

        foreach ($featured as $key => $row) {
            ?>
            <div class="<?php if($key == 0) { echo 'active'; } ?> item">
                <div class="featuredSeriesOverlay" style="background-image:url(http://telenu.tv/resources/images/channel/1<?= $row['ChBnr'] ?>)">
                    <div class="featuredInfo vertical-center">
                        <h1><?= $row['ChN'] ?></h1>
                        <h2>Mejor Serie Web<br><?= $row['Genre'],' ',$row['ChY'] ?></h2>
                        <a class="btn btn-default" href="../channel/<?= $row['ChL'] ?>"><i class="fa fa-play"></i> Ver ahora</a>
                    </div>
                </div>
            </div>
            <?php
        }   
    }

    if(isset($_POST['action']) && !empty($_POST['action'])) {
        $action = $_POST['action'];
        switch($action) {
            case 'updateMyList' :
                $index = $_POST['index'];
                updateMyList($index);
                break;
        }
    }
?>