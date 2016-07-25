<?php
    require_once '../resources/php/connToServer.php';
    require_once '../resources/php/getSession.php';    
	if($_SESSION["Email"]!="telenu.tv@gmail.com"){
		header('Location:../index.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Telenu</title>
        <link href='https://fonts.googleapis.com/css?family=Russo+One' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../resources/css/style.css" />
    </head>
    <body>
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
                                <img class="profilePicture" src="../resources/images/Hon-Hon.png" alt="">
                                <?php echo $_SESSION["User_Name"] ?>
                                <i class="fa fa-ellipsis-v"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($_SESSION["Email"]=="elvigilantestudios@gmail.com") { ?>
                                <li><a class="btn btn-default" href="user/channelManager.php">Channel Manager</a></li>
                                <?php } ?>
                                <li><a class="btn btn-default" href="resources/php/logout.php">Salir</a></li>
                            </ul>
                            <?php } else { ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img class="usericon" src="../resources/images/usericon.png" alt=""> Ingreso / Registro <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php if(isset($_SESSION["LogInFail"])) { 
                                    echo '<li>',$_SESSION["LogInFail"],'</li>';
                                }
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

		<div class="container-fluid" id="newSeriesForm">
			<div class="row">
				<div class="col-xs-12">
					<h1 class="text-center">Registro de Series</h1>
				</div>
				<div class="col-sm-4">
			  		<h3 class="text-center">Nueva Serie:</h3>
			      	<form action="channelManagerFunctions.php" method="post" name="RegisterSeries" id="RegisterSeries" enctype="multipart/form-data">
			      		<div class="formElement">
      						<select name="Year" size="">
      							<option value="None">None</option>
                                <option value="Tele">Telenu</option>
								<option value="2014">2014</option>
								<option value="2015">2015</option>
								<option value="2016">2016</option>
							</select>
			 			</div>
			      		<div class="formElement">
      						<select name="Genre" size="">
								<option value="Acción/Aventura">Acción / Aventura</option>
								<option value="Animación">Animación</option>
								<option value="Comedia">Comedia</option>
								<option value="Documental">Documental</option>
								<option value="Drama">Drama</option>
								<option value="Fantasía/Scifi">Fantasia / Scifi</option>
								<option value="Terror">Terror</option>
							</select>
			 			</div>
			 			<table>
							<tr>
					 			<td>
					  				<label for="Winner">Ganadora &nbsp</label>
					 			</td>
					 			<td>
					 				<input type="checkbox" name="Winner" value="1">
					 			</td>
					 		</tr>
					 		<tr><td><p> </p></td></tr>
						</table>
			      		<div class="formElement">
			      			<input type="text" name="Country" Class="TField" placeholder="País">
			      		</div>
			      		<div class="formElement">
			      			<input type="text" name="Name" required="required" Class="TField" placeholder="Nombre *">
			      		</div>
			      		<div class="formElement">
			      			<input type="text" name="URLName" required="required" Class="TField" placeholder="Nombre de URL *">
			      		</div>
			      		<div class="formElement">
			      			<input type="text" name="Creator" required="required" Class="TField" placeholder="Creador *">
			      		</div>
			      		<div class="formElement">
			      			<input type="text" name="Director" Class="TField" placeholder="Director">
			      		</div>
						<div class="formElement">
			      			<input type="text" name="Writer" Class="TField" placeholder="Escritor">
			      		</div>
			      		<div class="formElement">
			      			<input type="text" name="Producer" Class="TField" placeholder="Productor">
			      		</div>
			      		<div class="formElement">
			      			<input type="text" name="Photography" Class="TField" placeholder="Cinefotógrafo">
			      		</div>
			      		<div class="formElement">
			      			<input type="text" name="Editor" Class="TField" placeholder="Editor">
			      		</div>
			      		<div class="formElement">
			      			<input type="text" name="Composer" Class="TField" placeholder="Compositor">
			      		</div>
			      		<textarea class="text_cmt" name="Cast" rows="5" placeholder="Reparto"></textarea>
			      		<textarea class="text_cmt" name="Synopsis" rows="5" required="required" placeholder="Sinopsis *"></textarea>
						<table>
							<tr>
					 			<td>
					  				<label for="Thumbnail">Thumbnail * &nbsp</label>
					 			</td>
					 			<td>
					 				<input type="file" name="Thumbnail" id="Thumbnail" required="required">
					 			</td>
					 		</tr>
					 		<tr><td><p> </p></td></tr>
					 		<tr>
					 			<td>
					  				<label for="Banner">Banner * &nbsp</label>
					 			</td>
					 			<td>
					 				<input type="file" name="Banner" id="Banner" required="required">
					 			</td>
					 		</tr>
					 		<tr><td><p> </p></td></tr>
						</table>
						<h4 class="text-center">Ubicación de la serie:</h4>
						<div class="text-center">
							<input type="radio" name="seriesSource" <?php if (isset($seriesSource) && $seriesSource=="youtube") echo "checked";?> value="youtube" onClick="Hide('VimeoSerie', this); Reveal('YoutubeSerie', this); Reveal('SendSerie', this)">Youtube &nbsp
							<input type="radio" name="seriesSource" <?php if (isset($seriesSource) && $seriesSource=="vimeo") echo "checked";?> value="vimeo" onClick="Hide('YoutubeSerie', this); Reveal('VimeoSerie', this); Reveal('SendSerie', this)">Vimeo
						</div>
						<div id="YoutubeSerie" style="display:none">
				      		<div id="toggleSeasonYT">
					      		<div class="text-center">
					      			<a id="addSeasonYT" style="cursor:pointer">Agregar Temporadas</a>
					      		</div>
					      		<div class="formElement">
					      			<input type="text" name="season1YT" Class="TField" placeholder="Playlist Temporada 1 *">
					      		</div>
				      		</div>
			      		</div>
			      		<div id="VimeoSerie" style="display:none">

				      		<div class="text-center">
				      			<a id="addSeasonVM" style="cursor:pointer">Agregar Episodios</a>
				      		</div>
				      		<table id="toggleSeasonVM">
								<tr>
						 			<td>
						  				<input type="text" name="episode1" Class="TField" placeholder="Episodio 1">
						 			</td>
						 			<td>
						 				<input type="text" name="episode1season" Class="TField" placeholder="Temporada">
						 			</td>
						 		</tr>
							</table>
			      		</div>
			      		<div id="SendSerie" class="formElement text-center" style="display:none">
			      			<input type="submit" name="RegisterSeries" class="" value="Agregar Serie">
			      		</div>
			      	</form>
				</div>
				<div class="col-sm-4">
			  		<h3 class="text-center">Nuevo Vlog:</h3>
			      	<form action="channelManagerFunctions.php" method="post" name="RegisterVlog" id="RegisterVlog" enctype="multipart/form-data">
			      		<div class="formElement">
      						<select name="Year" size="">
                                <option value="Vlog">Vlog</option>
							</select>
			 			</div>
			      		<div class="formElement">
      						<select name="Genre" size="">
								<option value="Belleza/Moda">Belleza y Moda</option>
								<option value="Ciencia/Educacion">Ciencia y Educación</option>
								<option value="Cine/Entretenimiento">Cine y Entretenimiento</option>
								<option value="Cocina">Cocina</option>
								<option value="Comedia">Comedia</option>
								<option value="Deportes">Deportes</option>
								<option value="Lyfestyle">Lyfestyle</option>
								<option value="Música">Música</option>
								<option value="Noticias/Política">Noticias y Política</option>
								<option value="Technología">Tecnología</option>
								<option value="Videojuegos">Videojuegos</option>
							</select>
			 			</div>
			      		<div class="formElement">
			      			<input type="text" name="Country" Class="TField" placeholder="País">
			      		</div>
			      		<div class="formElement">
			      			<input type="text" name="Name" required="required" Class="TField" placeholder="Nombre *">
			      		</div>
			      		<div class="formElement">
			      			<input type="text" name="URLName" required="required" Class="TField" placeholder="Nombre de URL *">
			      		</div>
			      		<div class="formElement">
			      			<input type="text" name="Creator" required="required" Class="TField" placeholder="Creador *">
			      		</div>
			      		<textarea class="text_cmt" name="Synopsis" rows="5" required="required" placeholder="Sinopsis *"></textarea>
						<table>
							<tr>
					 			<td>
					  				<label for="Thumbnail">Thumbnail * &nbsp</label>
					 			</td>
					 			<td>
					 				<input type="file" name="Thumbnail" id="Thumbnail" required="required">
					 			</td>
					 		</tr>
					 		<tr><td><p> </p></td></tr>
					 		<tr>
					 			<td>
					  				<label for="Banner">Banner * &nbsp</label>
					 			</td>
					 			<td>
					 				<input type="file" name="Banner" id="Banner" required="required">
					 			</td>
					 		</tr>
					 		<tr><td><p> </p></td></tr>
						</table>
						<div id="YoutubeSerie">
				      		<div class="formElement">
				      			<input type="text" name="YTUsername" Class="TField" placeholder="Youtube Username *">
				      		</div>
				      		<div class="formElement">
				      			<input type="text" name="YTPlaylist" Class="TField" placeholder="Youtube Playlist *">
				      		</div>
			      		</div>
			      		<div class="formElement text-center">
			      			<input type="submit" name="RegisterVlog" class="" value="Agregar Vlog">
			      		</div>
			      	</form>
				</div>
				<div class="col-sm-4">
			  		<h3 class="text-center">Nuevo Corto:</h3>
			      	<form action="channelManagerFunctions.php" method="post" name="RegisterShort" id="RegisterShort" enctype="multipart/form-data">
			      		<div class="formElement">
      						<select name="Year" size="">
                                <option value="Short">Short</option>
							</select>
			 			</div>
			      		<div class="formElement">
      						<select name="Genre" size="">
								<option value="Acción/Aventura">Acción / Aventura</option>
								<option value="Animación">Animación</option>
								<option value="Comedia">Comedia</option>
								<option value="Documental">Documental</option>
								<option value="Drama">Drama</option>
								<option value="Fantasía/Scifi">Fantasia / Scifi</option>
								<option value="Terror">Terror</option>
							</select>
			 			</div>
			      		<div class="formElement">
			      			<input type="text" name="Country" Class="TField" placeholder="País">
			      		</div>
			      		<div class="formElement">
			      			<input type="text" name="Name" required="required" Class="TField" placeholder="Nombre *">
			      		</div>
			      		<div class="formElement">
			      			<input type="text" name="URLName" required="required" Class="TField" placeholder="Nombre de URL *">
			      		</div>
			      		<div class="formElement">
			      			<input type="text" name="Creator" required="required" Class="TField" placeholder="Creador *">
			      		</div>
			      		<div class="formElement">
			      			<input type="text" name="Director" Class="TField" placeholder="Director">
			      		</div>
						<div class="formElement">
			      			<input type="text" name="Writer" Class="TField" placeholder="Escritor">
			      		</div>
			      		<div class="formElement">
			      			<input type="text" name="Producer" Class="TField" placeholder="Productor">
			      		</div>
			      		<div class="formElement">
			      			<input type="text" name="Photography" Class="TField" placeholder="Cinefotógrafo">
			      		</div>
			      		<div class="formElement">
			      			<input type="text" name="Editor" Class="TField" placeholder="Editor">
			      		</div>
			      		<div class="formElement">
			      			<input type="text" name="Composer" Class="TField" placeholder="Compositor">
			      		</div>
			      		<textarea class="text_cmt" name="Cast" rows="5" placeholder="Reparto"></textarea>
			      		<textarea class="text_cmt" name="Synopsis" rows="5" required="required" placeholder="Sinopsis *"></textarea>
						<table>
							<tr>
					 			<td>
					  				<label for="Thumbnail">Thumbnail * &nbsp</label>
					 			</td>
					 			<td>
					 				<input type="file" name="Thumbnail" id="Thumbnail" required="required">
					 			</td>
					 		</tr>
					 		<tr><td><p> </p></td></tr>
					 		<tr>
					 			<td>
					  				<label for="Banner">Banner * &nbsp</label>
					 			</td>
					 			<td>
					 				<input type="file" name="Banner" id="Banner" required="required">
					 			</td>
					 		</tr>
					 		<tr><td><p> </p></td></tr>
						</table>
						<h4 class="text-center">Ubicación del corto:</h4>
						<div class="text-center">
							<input type="radio" name="seriesSource" <?php if (isset($seriesSource) && $seriesSource=="youtube") echo "checked";?> value="youtube" onClick="Hide('VimeoShort', this); Reveal('YoutubeShort', this); Reveal('SendShort', this)">Youtube &nbsp
							<input type="radio" name="seriesSource" <?php if (isset($seriesSource) && $seriesSource=="vimeo") echo "checked";?> value="vimeo" onClick="Hide('YoutubeShort', this); Reveal('VimeoShort', this); Reveal('SendShort', this)">Vimeo
						</div>
						<div id="YoutubeShort" style="display:none">
				      		<div class="formElement">
				      			<input type="text" name="YTVideoID" Class="TField" placeholder="Youtube Video ID *">
				      		</div>
			      		</div>
			      		<div id="VimeoShort" style="display:none">
				      		<div class="formElement">
				      			<input type="text" name="VMVideoID" Class="TField" placeholder="Vimeo Video ID *">
				      		</div>
			      		</div>
			      		<div id="SendShort" class="formElement text-center" style="display:none">
			      			<input type="submit" name="RegisterShort" class="" value="Agregar Corto">
			      		</div>
			      	</form>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="../vendor/jquery.min.js"></script>
        <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../resources/js/script.js"></script>
        <script type="text/javascript" src="http://malsup.github.com/jquery.form.js"></script>
		<script>
			function Reveal (it, box) { 
				var vis = (box.checked) ? "block" : "none"; 
				document.getElementById(it).style.display = vis;
			} 

			function Hide (it, box) { 
				var vis = (box.checked) ? "none" : "none"; 
				document.getElementById(it).style.display = vis;
			}

			$seasonNumber = 1;
			$( "#addSeasonYT" ).click(function() {
				$seasonNumber++;
				$('#toggleSeasonYT').append('<div class="formElement"><input type="text" name="season' + $seasonNumber + 'YT" Class="TField" placeholder="Playlist Temporada ' + $seasonNumber + '"></div>');
			});
			$( "#addSeasonVM" ).click(function() {
				$seasonNumber++;
				$('#toggleSeasonVM').append('<tr><td><input type="text" name="episode' + $seasonNumber + '" Class="TField" placeholder="Episodio ' + $seasonNumber + '"></td><td><input type="text" name="episode' + $seasonNumber + 'season" Class="TField" placeholder="Temporada"></td></tr>');
			});
		</script>
    </body>
</html>













