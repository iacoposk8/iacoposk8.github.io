<style>
	.maps{
		overflow: hidden;
		margin-bottom: 30px;
	}
	.map{
		width: 50%;
		float: left;
	}
</style>
<?php
	$pdo = new PDO('mysql:host=iacoposk8.ipagemysql.com;dbname=correlation_ourworldindata', "co_user", "Qo64@9pp#%Js");

	function format_name($n){
		return ucfirst(str_replace("-"," ",$n));
	}

	function get_iframe($n){
		return '<iframe src="https://ourworldindata.org/grapher/'.$n.'?tab=map" loading="lazy" style="width: 100%; height: 600px; border: 0px none;"></iframe>';
	}

	if(isset($_GET["tab_id"])){
		$tab2 = "";
		if(isset($_GET["tab2"]))
			$tab2 = get_iframe($_GET["tab2"]);
		echo('<div class="maps"><div class="map">'.get_iframe($_GET["tab_name"]).'</div><div class="map" id="view_map">'.$tab2.'</div></div>');

		$stmt = $pdo->prepare("SELECT s.score, c.name FROM score as s, csv as c WHERE s.tab1 = ? AND s.tab2 = c.id ORDER BY s.score ASC");
		$stmt->execute([$_GET["tab_id"]]); 
		$data = $stmt->fetchAll();
		
		foreach($data as $d){
			//echo('<tr><td>'.$d["score"].'</td><td><a href="https://ourworldindata.org/grapher/'.$d["name"].'?tab=map" target="_blank">' . format_name($d["name"]) . "</a></td></tr>");

			echo "<strong>" . format_name($d["name"]) . '</strong><br />';
			echo 'Score: '.$d["score"].'<br />';
			echo '<a href="#" class="view_map" attr-tab="'.$d["name"].'">View Map</a><br /><br />';
		}
		echo "</table>";
	} else {	
		$stmt = $pdo->prepare("SELECT * FROM csv ORDER BY name ASC");
		$stmt->execute(); 
		$data = $stmt->fetchAll();
		foreach($data as $d){
			echo('<a href="?tab_id='.$d["id"].'&tab_name='.$d["name"].'">'.format_name($d["name"])."</a><br />");
		}
	}
?>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script>
	$(document).ready(function(){
		const queryString = window.location.search;
		const urlParams = new URLSearchParams(queryString);
		const tab_id = urlParams.get('tab_id');
		const tab_name = urlParams.get('tab_name');

		$(".view_map").click(function(){
			history.pushState({}, null, "?tab_id=" + tab_id + "&tab_name=" + tab_name + "&tab2=" + $(this).attr("attr-tab"));
			$("#view_map").html('<iframe src="https://ourworldindata.org/grapher/' + $(this).attr("attr-tab") + '?tab=map" loading="lazy" style="width: 100%; height: 600px; border: 0px none;"></iframe>');
		});
	});
</script>