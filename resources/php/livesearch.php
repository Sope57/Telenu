<?php
	if (isset($_GET['q']) && !empty($_GET['q']) && strlen($_GET['q']) > 1) {
		include 'connToServer.php';
		$conn = db_connect();
		$q = $_GET['q'];
		$stmt = $conn->prepare("SELECT channel.ChT, channel.ChN, channel.ChL, ChThmb, Genre FROM channel JOIN chanimg ON channel.ID = chanimg.ChID JOIN chaninfoseries ON channel.ID = chaninfoseries.ChID WHERE ChN LIKE ? ORDER BY ChN");
		$stmt->execute(array('%'.$q.'%'));
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if (!empty($result)) {
			$replace = array("series", "short", "vlog", "webshow");
			$replacewith = array("Serie", "Corto", "Vlog", "Show");
			echo '<table id="searchResults"><tr><th></th><th>Nombre</th><th>Contenido</th><th>Género</th></tr>';
			foreach ($result as $channel) {
				$type = str_replace($replace, $replacewith, $channel["ChT"]);
				echo '<tr>'
					,'<td><a href="http://telenu.tv/channel/',$channel["ChL"],'">'
						,'<img src="http://telenu.tv/resources/images/channel/',$channel["ChThmb"],'" alt="">'
					,'</a></td>'
					,'<td><a href="http://telenu.tv/channel/',$channel["ChL"],'"><span class="underAnim">',$channel["ChN"],'</span></a></td>'
					,'<td><p>',$type,'</p></td>'
					,'<td><p>',$channel["Genre"],'</p></td>'
				,'</tr>';
			}
			echo '</table>';
		} else {
			echo '<div id="results-none">No se encontraron resultados.</div>';
		}
	}
?>