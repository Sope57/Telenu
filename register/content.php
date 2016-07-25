<html>
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, maximum-scale=1.0">
        <meta property="og:url" content="http://telenu.tv"/>
        <meta property="og:title" content="Telenu.TV"/>
        <meta property="og:description" content="Tu contenido aquí"/>
        <meta property="og:image" content="http://telenu.tv/resources/images/logo.png"/>
        <link rel="canonical" href="http://telenu.tv"/>
        <title>Telenu - Registra tu contenido</title>
		<!-- LOADERS -->
		<link rel="icon" type="image/x-icon" href="http://telenu.tv/resources/images/favicon.ico">
		<link href='https://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Exo+2:700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	    <link rel="stylesheet" type="text/css" href="../resources/css/style.css">
	    <script type="text/javascript" src="../vendor/jquery.min.js"></script>
		<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
		function showAlert(){
		  var w = window.open("", "Title", "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=780, height=80, top="+(screen.height-400)+", left="+(screen.width-840));
		  w.document.body.innerHTML = "<span style=\"color:white; font-family: Arial, Helvetica, sans-serif\">" + "Uploading... please wait." + "</span>";
		  w.document.body.style.backgroundColor = "#000";
		  w.document.close();
		  w.focus();
		}
		</script>
	</head>
	<body id="page-top" class="r-body">
			<div class="container r-logo-margin" style="width:1170px!important">
				<div class="row">
					<div class="col-xs-12 col-sm-4 col-sm-offset-4">
						<img src="../resources/images/logoHD.png" alt="" class="img-responsive" align="middle">
					</div> 
				</div>
			</div>
			<section class="height-half" id="r-content"> 
				<div class="container" style="width:1170px!important">
					<div class="row">
						<div class="col-xs-12">
							<?php 
								if (isset($_GET["l"]) && isset($_GET["t"])) {
									echo '<form id="r-registro" name="registro" method="post" action="content_send.php" enctype="multipart/form-data" onsubmit="showAlert();">';
									switch ($_GET["l"]) {
										case 'espanol': ?>
											<div class="col-xs-12 col-sm-6">
												<table>
													<tbody>
														<tr>
															<td colspan="2">INFORMACIÓN DEL PARTICIPANTE</td>
														</tr>
														<tr>
															<td>
																<label for="nombre_participante">Nombre completo*</label>
															</td>
															<td>
																<input type="text" name="nombre_participante" size="30" required>
															</td>
														</tr>
														<tr>
															<td>
																<label for="edad_participante">Edad*</label>
															</td>
															<td>
																<input type="text" name="edad_participante" size="30" required>
															</td>
														</tr>
														<tr>
															<td>
																<label for="correo_participante">Correo*</label>
															</td>
															<td>
																<input type="text" name="correo_participante" size="30" required>
															</td>
														</tr>
														<tr>
															<td>
																<label for="telefono_participante">Teléfono*</label>
															</td>
															<td>
																<input type="text" name="telefono_participante" size="30" required>
															</td>
														</tr>
														<tr>
															<td>
																<label for="direccion_participante">Dirección*</label>
															</td>
															<td>
																<input type="text" name="direccion_participante" size="30" required>
															</td>
														</tr>
														<tr>
															<td>
																<label for="postal_participante">Código postal*</label>
															</td>
															<td>
																<input type="text" name="postal_participante" size="30" required>
															</td>
														</tr>
														<tr>
															<td>
																<label for="ciudad_participante">Ciudad*</label>
															</td>
															<td>
																<input type="text" name="ciudad_participante" size="30" required>
															</td>
														</tr>
														<tr>
															<td>
																<label for="estado_participante">Estado*</label>
															</td>
															<td>
																<input type="text" name="estado_participante" size="30" required>
															</td>
														</tr>
														<tr>
															<td>
																<label for="pais_participante">País*</label>
															</td>
															<td>
																<input type="text" name="pais_participante" size="30" required>
															</td>
														</tr>

														<tr>
															<td colspan="2">REDES SOCIALES</td>
														</tr>
														<tr>
															<td>
																<label for="facebook_serie">Facebook</label>
															</td>
															<td>
																<input type="text" name="facebook_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="twitter_serie">Twitter</label>
															</td>
															<td>
																<input type="text" name="twitter_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="youtube_serie">Youtube</label>
															</td>
															<td>
																<input type="text" name="youtube_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="vimeo_serie">Vimeo</label>
															</td>
															<td>
																<input type="text" name="vimeo_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="instagram_serie">Instagram</label>
															</td>
															<td>
																<input type="text" name="instagram_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="otra_serie">Otra(s)</label>
															</td>
															<td>
																<input type="text" name="otra_serie" size="30">
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											<div class="col-xs-12 col-sm-6">
												<table>
													<tbody>
														<tr>
															<td colspan="2">INFORMACIÓN DE LA SERIE/CORTOMETRAJE/VLOG</td>
														</tr>
														<tr>
															<td>
																<label for="nombre_serie">Nombre*</label>
															</td>
															<td>
																<input type="text" name="nombre_serie" size="30" required>
															</td>
														</tr>
														<tr>
															<td>
																<label for="pagina_serie">Página oficial</label>
															</td>
															<td>
																<input type="text" name="pagina_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="idioma_serie">Idioma original*</label>
															</td>
															<td>
																<input type="text" name="idioma_serie" size="30" required>
															</td>
														</tr>
													<?php if ($_GET["t"] == "series" || $_GET["t"] == "short") { ?>
														<tr>
															<td>
																<label for="genero_serie">Género*</label>
															</td>
															<td>
																<select name="genero_serie" size="">
																	<option value="Drama">Drama</option>
																	<option value="Comedia">Comedia</option>
																	<option value="Scifi">Ciencia ficción</option>
																	<option value="Terror">Terror</option>
																	<option value="Aventura">Aventura</option>
																	<option value="Fantasia">Fantasía</option>
																	<option value="Musical">Musical</option>
																	<option value="Reality">Reality show</option>
																	<option value="Documental">Documental</option>
																	<option value="Animacion">Animación</option>
																</select>
															</td>
														</tr>
													<?php } elseif ($_GET["t"] == "webshow" || $_GET["t"] == "vlog") { ?>
														<tr>
															<td>
																<label for="genero_serie">Categoria*</label>
															</td>
															<td>
																<select name="genero_serie" size="">
																	<option value="Noticias">Noticias y Politica</option>
																	<option value="Deportes">Deportes</option>
																	<option value="Videojuegos">Videojuegos</option>
																	<option value="Musica">Música</option>
																	<option value="Comedia">Comedia</option>
																	<option value="Cine">Cine y Entretenimiento</option>
																	<option value="Moda">Belleza y Moda</option>
																	<option value="Tecnologia">Tecnología</option>
																	<option value="Cocina">Cocina</option>
																	<option value="Ciencia">Ciencia y Educación</option>
																	<option value="Lyfestyle">Lyfestyle</option>
																</select>
															</td>
														</tr>
													<?php } ?>
														<tr>
															<td>
																<label for="creador_serie">Creador*</label>
															</td>
															<td>
																<input type="text" name="creador_serie" size="30" required>
															</td>
														</tr>
													<?php if ($_GET["t"] == "series" || $_GET["t"] == "short") { ?>
														<tr>
															<td>
																<label for="director_serie">Director</label>
															</td>
															<td>
																<input type="text" name="director_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="escritor_serie">Escritor</label>
															</td>
															<td>
																<input type="text" name="escritor_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="productor_serie">Productor</label>
															</td>
															<td>
																<input type="text" name="productor_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="cinefotografo_serie">Cinefotógrafo</label>
															</td>
															<td>
																<input type="text" name="cinefotografo_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="editor_serie">Editor</label>
															</td>
															<td>
																<input type="text" name="editor_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="compositor_serie">Compositor</label>
															</td>
															<td>
																<input type="text" name="compositor_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="reparto_serie">Reparto</label>
															</td>
															<td>
																<input type="text" name="reparto_serie" size="30">
															</td>
														</tr>
													<?php } else { ?>
														<input type="hidden" name="director_serie" size="30">
														<input type="hidden" name="escritor_serie" size="30">
														<input type="hidden" name="productor_serie" size="30">
														<input type="hidden" name="cinefotografo_serie" size="30">
														<input type="hidden" name="editor_serie" size="30">
														<input type="hidden" name="compositor_serie" size="30">
														<input type="hidden" name="reparto_serie" size="30">
													<?php } ?>
														<tr>
															<td>
																<label for="sinopsis_serie">Sinopsis/Descripción*</label>
															</td>
															<td>
																<textarea name="sinopsis_serie" cols="30" rows="3" required></textarea>
															</td>
														</tr>
														<tr>
															<td>
																 <label for='img_1'>Imagen #1:</label>
															</td>
															<td>
																<input type="file" name="img_1" id="img_1">
																<input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
															</td>
														</tr>
														<tr>
															<td>
																 <label for='img_2'>Imagen #2:</label>
															</td>
															<td>
																<input type="file" name="img_2" id="img_2">
															</td>
														</tr>
														<tr>
															<td colspan="2">ENLACES (YOUTUBE, VIMEO, ETC.)</td>
														</tr>
														<tr>
															<td>
																<label for="enlace_1">Enlace 1</label>
															</td>
															<td>
																<input type="text" name="enlace_1" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="enlace_2">Enlace 2</label>
															</td>
															<td>
																<input type="text" name="enlace_2" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="enlace_3">Enlace 3</label>
															</td>
															<td>
																<input type="text" name="enlace_3" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="pw">Contraseña</label>
															</td>
															<td>
																<input type="text" name="pw" size="30">
															</td>
														</tr>
														<tr>
															<td>
																
															</td>
															<td>
																<input type="submit" name="button" id="r-button" value="Enviar" />
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											<input type="hidden" name="language" value="spanish"/>
											<input type="hidden" name="type" value="<?= $_GET["t"] ?>"/>

											<?php break;
										
										case 'english': ?>
											<div class="col-xs-12 col-sm-6">
												<table>
													<tbody>
														<tr>
															<td colspan="2">SUBMITTER'S INFO</td>
														</tr>
														<tr>
															<td>
																<label for="nombre_participante">Full name*</label>
															</td>
															<td>
																<input type="text" name="nombre_participante" size="30" required>
															</td>
														</tr>
														<tr>
															<td>
																<label for="edad_participante">Age*</label>
															</td>
															<td>
																<input type="text" name="edad_participante" size="30" required>
															</td>
														</tr>
														<tr>
															<td>
																<label for="correo_participante">E-mail*</label>
															</td>
															<td>
																<input type="text" name="correo_participante" size="30" required>
															</td>
														</tr>
														<tr>
															<td>
																<label for="telefono_participante">Phone*</label>
															</td>
															<td>
																<input type="text" name="telefono_participante" size="30" required>
															</td>
														</tr>
														<tr>
															<td>
																<label for="direccion_participante">Address*</label>
															</td>
															<td>
																<input type="text" name="direccion_participante" size="30" required>
															</td>
														</tr>
														<tr>
															<td>
																<label for="postal_participante">Zip code*</label>
															</td>
															<td>
																<input type="text" name="postal_participante" size="30" required>
															</td>
														</tr>
														<tr>
															<td>
																<label for="ciudad_participante">City*</label>
															</td>
															<td>
																<input type="text" name="ciudad_participante" size="30" required>
															</td>
														</tr>
														<tr>
															<td>
																<label for="estado_participante">State/Region*</label>
															</td>
															<td>
																<input type="text" name="estado_participante" size="30" required>
															</td>
														</tr>
														<tr>
															<td>
																<label for="pais_participante">Country*</label>
															</td>
															<td>
																<input type="text" name="pais_participante" size="30" required>
															</td>
														</tr>

														<tr>
															<td colspan="2">ONLINE PROFILES</td>
														</tr>
														<tr>
															<td>
																<label for="facebook_serie">Facebook</label>
															</td>
															<td>
																<input type="text" name="facebook_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="twitter_serie">Twitter</label>
															</td>
															<td>
																<input type="text" name="twitter_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="youtube_serie">Youtube</label>
															</td>
															<td>
																<input type="text" name="youtube_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="vimeo_serie">Vimeo</label>
															</td>
															<td>
																<input type="text" name="vimeo_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="instagram_serie">Instagram</label>
															</td>
															<td>
																<input type="text" name="instagram_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="otra_serie">Other(s)</label>
															</td>
															<td>
																<input type="text" name="otra_serie" size="30">
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											<div class="col-xs-12 col-sm-6">
												<table >
													<tbody>
														<tr>
															<td colspan="2">SERIES/SHORTFILM/VLOG INFO</td>
														</tr>
														<tr>
															<td>
																<label for="nombre_serie">Title*</label>
															</td>
															<td>
																<input type="text" name="nombre_serie" size="30" required>
															</td>
														</tr>
														<tr>
															<td>
																<label for="pagina_serie">Webpage</label>
															</td>
															<td>
																<input type="text" name="pagina_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="idioma_serie">Original Language*</label>
															</td>
															<td>
																<input type="text" name="idioma_serie" size="30" required>
															</td>
														</tr>
													<?php if ($_GET["t"] == "series" || $_GET["t"] == "short") { ?>
														<tr>
															<td>
																<label for="genero_serie">Genre*</label>
															</td>
															<td>
																<select name="genero_serie" size="">
																	<option value="Drama">Drama</option>
																	<option value="Comedia">Comedy</option>
																	<option value="Scifi">Science fiction</option>
																	<option value="Terror">Horror</option>
																	<option value="Aventura">Adventure</option>
																	<option value="Fantasia">Fantasy</option>
																	<option value="Musical">Musical</option>
																	<option value="Reality">Reality show</option>
																	<option value="Documental">Documentary</option>
																	<option value="Animacion">Animation</option>
																</select>
															</td>
														</tr>
													<?php } elseif ($_GET["t"] == "webshow" || $_GET["t"] == "vlog") { ?>
														<tr>
															<td>
																<label for="genero_serie">Categoria*</label>
															</td>
															<td>
																<select name="genero_serie" size="">
																	<option value="Noticias">News & Politics</option>
																	<option value="Deportes">Sports</option>
																	<option value="Videojuegos">Gaming</option>
																	<option value="Musica">Music</option>
																	<option value="Comedia">Comedy</option>
																	<option value="Cine">Movies & Entertainment</option>
																	<option value="Moda">Beauty & Fashion</option>
																	<option value="Tecnologia">Technology</option>
																	<option value="Cocina">Cooking</option>
																	<option value="Ciencia">Science & Education</option>
																	<option value="Lyfestyle">Lyfestyle</option>
																</select>
															</td>
														</tr>
													<?php } ?>
														<tr>
															<td>
																<label for="creador_serie">Creator*</label>
															</td>
															<td>
																<input type="text" name="creador_serie" size="30" required>
															</td>
														</tr>
													<?php if ($_GET["t"] == "series" || $_GET["t"] == "short") { ?>
														<tr>
															<td>
																<label for="director_serie">Director</label>
															</td>
															<td>
																<input type="text" name="director_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="escritor_serie">Writer</label>
															</td>
															<td>
																<input type="text" name="escritor_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="productor_serie">Producer</label>
															</td>
															<td>
																<input type="text" name="productor_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="cinefotografo_serie">Photography</label>
															</td>
															<td>
																<input type="text" name="cinefotografo_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="editor_serie">Editor</label>
															</td>
															<td>
																<input type="text" name="editor_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="compositor_serie">Composer</label>
															</td>
															<td>
																<input type="text" name="compositor_serie" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="reparto_serie">Cast</label>
															</td>
															<td>
																<input type="text" name="reparto_serie" size="30">
															</td>
														</tr>
													<?php } else { ?>
														<input type="hidden" name="director_serie" size="30">
														<input type="hidden" name="escritor_serie" size="30">
														<input type="hidden" name="productor_serie" size="30">
														<input type="hidden" name="cinefotografo_serie" size="30">
														<input type="hidden" name="editor_serie" size="30">
														<input type="hidden" name="compositor_serie" size="30">
														<input type="hidden" name="reparto_serie" size="30">
													<?php } ?>
														<tr>
															<td>
																<label for="sinopsis_serie">Synopsis/Description*</label>
															</td>
															<td>
																<textarea name="sinopsis_serie" cols="30" rows="3" required></textarea>
															</td>
														</tr>
														<tr>
															<td>
																 <label for='img_1'>Image #1:</label>
															</td>
															<td>
																<input type="file" name="img_1" id="img_1">
																<input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
															</td>
														</tr>
														<tr>
															<td>
																 <label for='img_2'>Image #2:</label>
															</td>
															<td>
																<input type="file" name="img_2" id="img_2">
															</td>
														</tr>
														<tr>
															<td colspan="2">LINKS (YOUTUBE, VIMEO, ETC.)</td>
														</tr>
														<tr>
															<td>
																<label for="enlace_1">Link 1</label>
															</td>
															<td>
																<input type="text" name="enlace_1" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="enlace_2">Link 2</label>
															</td>
															<td>
																<input type="text" name="enlace_2" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="enlace_3">Link 3</label>
															</td>
															<td>
																<input type="text" name="enlace_3" size="30">
															</td>
														</tr>
														<tr>
															<td>
																<label for="pw">Password</label>
															</td>
															<td>
																<input type="text" name="pw" size="30">
															</td>
														</tr>
														<tr>
															<td>
																 
															</td>
															<td>
																<input type="submit" name="button" id="r-button" value="Submit" />
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										<input type="hidden" name="language" value="english"/>
										<input type="hidden" name="type" value="<?= $_GET["t"] ?>"/>
											

											<?php break;
									}
									echo '</form>';
								} else {
									if (isset($_GET["l"])) { 
										switch ($_GET["l"]) {
											case 'espanol': ?>
												<br><br>
												<a href="?l=<?= $_GET["l"] ?>&t=series"><h2>Serie</h2></a>
												<br><br>
												<a href="?l=<?= $_GET["l"] ?>&t=short"><h2>Corto</h2></a>
												<br><br>
												<a href="?l=<?= $_GET["l"] ?>&t=webshow"><h2>Show</h2></a>
												<br><br>
												<a href="?l=<?= $_GET["l"] ?>&t=vlog"><h2>Vlog</h2></a>
												<br><br>
												<a href=""><h2>Regresar</h2></a>
												<?php break;
											case 'english': ?>
												<br><br>
												<a href="?l=<?= $_GET["l"] ?>&t=series"><h2>Series</h2></a>
												<br><br>
												<a href="?l=<?= $_GET["l"] ?>&t=short"><h2>Short</h2></a>
												<br><br>
												<a href="?l=<?= $_GET["l"] ?>&t=webshow"><h2>Show</h2></a>
												<br><br>
												<a href="?l=<?= $_GET["l"] ?>&t=vlog"><h2>Vlog</h2></a>
												<br><br>
												<a href=""><h2>Back</h2></a>
												<?php break;
										}
									 } else { ?>
										<br><br>
										<a href="?l=espanol"><h2>Español</h2></a>
										<br><br>
										<a href="?l=english"><h2>English</h2></a>
									<?php }
								}


							?>
						</div>
					</div>
				</div>
				<br>
				<br>
				<br>
				<p>©Telenu 2016. All Rights Reserved</p>
				<br>
			</section>

	</body>
</html>