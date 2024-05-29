<!-- Styles -->
<style>
*{
	font-family: arial;
}
#chartdiv {
  width: 100%;
  height: 500px;
}
form{
	width: 100%;
	max-width: 500px;
}
form{
	clear: left;
	margin: 50px auto 20px auto;
	padding-top: 50px;
}
form p{
	font-weight: bold;
	font-size: 16px;
}
#header_row, .header_col{
	background: #fff;
}
button, input[type="submit"]{
	background: #3498db;
	color: #fff;
	border: 1px solid #004c80;
	font-size: 20px;
	border-radius: 3px;
	padding: 5px 20px;
	text-align: center;
	cursor: pointer;
}
<?php
if(isset($_GET["map"])){
	echo '#hidemap{display: none;}';
}
?>
</style>

<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>

<!-- HTML -->
<div id="chartdiv"></div>

<?php
	function normalize($tab, $type, $val, $min, $max){
		if($_POST[$tab] == 0){
			return 0;
		} else {
			$val *=  $_POST[$tab] / 100;
			$min *=  $_POST[$tab] / 100;
			$max *=  $_POST[$tab] / 100;
		}
		if($type == "negative_index")
			$ret = 1 - (($val - $min) / ($max - $min));
		else if(strstr($type, "around_value_")){
			$around = str_replace("around_value_", "", $type);
			$min = abs($around - $min);
			$max = abs($around - $max);
			if($min < $max){
				$max = $min;
			}
			$res = abs((float) $val - $around) / abs(-17.18 - $around);
			$ret = 1 - $res;
		} else
			$ret = (($val - $min) / ($max - $min));

		if(is_nan($ret)){
			//echo($tab." ".$val." ".$min." ".$max."<br />");
			$ret = 0;
		}

		return $ret;
	}

	function translate_state($key){
		$states = [
			["Russia"],
			["United Kingdom"],
			["United States"],
			["Iran"],
			["Gambia"],
			["Tanzania"],
			["Moldova"],
			["Venezuela"],
			["Bolivia"],
			["China"],
			["Brunei"],
			["Bosnia-Herzegovina", "Bosnia and Herzegovina"],
			["Micronesia", "Federated States of Micronesia"],
			["Cabo Verde", "Cape Verde"],
			["Timor","Timor-Leste"],
			["Ivoire", "Côte d'Ivoire"],
			["Ivory ", "Côte d'Ivoire"],
			["Syrian", "Syria"],
			["Swaziland", "Eswatini"],
			["Laos", "Lao People's Democratic Republic"],
			["Democratic Republic of the Congo", "Democratic Republic of Congo"],
			["Congo", "Republic of Congo"],
			["Democratic People's Republic of Korea", "North Korea"],
			["Republic of Korea", "South Korea"],
			["Czech Republic", "Czechia"],
			["Palestine", "Palestinian Territories"],
			["Kyrgyz Republic", "Kyrgyzstan"],
			["Macedonia", "North Macedonia"]
		];

		if($key == "Viet Nam")
				return "Vietnam";

		foreach($states as $state){
			if(count($state) == 1){
				if(strstr($key, $state[0]))
					return $state[0];
			} else {
				if(strstr($key, $state[0]))
					return $state[1];
			}
		}

		return $key;
	}

	$pdo = new PDO("mysql:host=iacoposk8.ipagemysql.com;dbname=iacopoguarneri_projects_world", "world_user1", "Xa3ab*CA19pl");

	$names_allowed = ["Tuvalu","Bouvet Island","Gibraltar","Glorioso Islands","Juan De Nova Island","Jarvis Island","Baker Island","Howland Island","Johnston Atoll","Midway Islands","Wake Island","Bonair, Saint Eustachius and Saba","Netherlands","Zimbabwe","Zambia","South Africa","Yemen","Samoa","Wallis and Futuna","Palestinian Territories","Vanuatu","Vietnam","US Virgin Islands","British Virgin Islands","Venezuela","Saint Vincent and the Grenadines","Vatican City","Uzbekistan","United States","Uruguay","Ukraine","Uganda","Tanzania","Taiwan","Turkey","Tunisia","Trinidad and Tobago","Tonga","Timor-Leste","Turkmenistan","Tokelau","Tajikistan","Thailand","Togo","Chad","Turks and Caicos Islands","Syria","Seychelles","Sint Maarten","Eswatini","Sweden","Slovenia","Slovakia","Suriname","Sao Tome and Principe","Serbia","Saint Pierre and Miquelon","Somalia","San Marino","El Salvador","Sierra Leone","Solomon Islands","Saint Helena","South Georgia and South Sandwich Islands","Singapore","Senegal","South Sudan","Sudan","Saudi Arabia","Western Sahara","Rwanda","Russia","Romania","Reunion","Qatar","French Polynesia","Paraguay","Portugal","North Korea","Puerto Rico","Poland","Papua New Guinea","Palau","Philippines","Peru","Pitcairn Islands","Panama","Pakistan","Oman","New Zealand","Svalbard and Jan Mayen","Nauru","Nepal","Norway","Niue","Nicaragua","Nigeria","Norfolk Island","Niger","New Caledonia","Namibia","Mayotte","Malaysia","Malawi","Mauritius","Martinique","Montserrat","Mauritania","Mozambique","Northern Mariana Islands","Mongolia","Montenegro","Myanmar","Malta","Mali","North Macedonia","Marshall Islands","Mexico","Maldives","Madagascar","Moldova","Monaco","Morocco","Saint Martin","Macau","Latvia","Luxembourg","Lithuania","Lesotho","Sri Lanka","Liechtenstein","Saint Lucia","Libya","Liberia","Lebanon","Lao People's Democratic Republic","Kuwait","Kosovo","South Korea","Saint Kitts and Nevis","Kiribati","Cambodia","Kyrgyzstan","Kenya","Kazakhstan","Japan","Jordan","Jersey","Jamaica","Italy","Israel","Iceland","Iraq","Iran","Ireland","British Indian Ocean Territory","India","Isle of Man","Indonesia","Hungary","Haiti","Croatia","Honduras","Heard Island and McDonald Islands","Hong Kong","Guyana","Guam","French Guiana","Guatemala","Greenland","Grenada","Greece","Equatorial Guinea","Guinea-Bissau","Gambia","Guadeloupe","Guinea","Ghana","Guernsey","Georgia","Gabon","France","Federated States of Micronesia","Faroe Islands","Falkland Islands","Fiji","Finland","Ethiopia","Estonia","Spain","Eritrea","United Kingdom","Egypt","Ecuador","Algeria","Dominican Republic","Denmark","Dominica","Djibouti","Germany","Czechia","Cyprus","Cayman Islands","Christmas Island","Curaçao","Cuba","Costa Rica","Cape Verde","Comoros","Colombia","Cook Islands","Republic of Congo","Democratic Republic of Congo","Cameroon","Côte d'Ivoire","China","Chile","Switzerland","Cocos (Keeling) Islands","Canada","Central African Republic","Belgium","Botswana","Bhutan","Brunei","Barbados","Brazil","Bolivia","Bermuda","Belize","Belarus","Saint Barthelemy","Bahamas","Bahrain","Bosnia and Herzegovina","Bulgaria","Bangladesh","Burkina Faso","Benin","Burundi","Azerbaijan","Austria","Australia","French Southern and Antarctic Lands","Antarctica","American Samoa","Armenia","Argentina","United Arab Emirates","Andorra","Aland Islands","Albania","Anguilla","Angola","Afghanistan","Antigua and Barbuda","Aruba"];

	$nameid = json_decode('{"Tuvalu":"TV","Bouvet Island":"BV","Gibraltar":"GI","Glorioso Islands":"GO","Juan De Nova Island":"JU","Jarvis Island":"UM-DQ","Baker Island":"UM-FQ","Howland Island":"UM-HQ","Johnston Atoll":"UM-JQ","Midway Islands":"UM-MQ","Wake Island":"UM-WQ","Bonair, Saint Eustachius and Saba":"BQ","Netherlands":"NL","Zimbabwe":"ZW","Zambia":"ZM","South Africa":"ZA","Yemen":"YE","Samoa":"WS","Wallis and Futuna":"WF","Palestinian Territories":"PS","Vanuatu":"VU","Vietnam":"VN","US Virgin Islands":"VI","British Virgin Islands":"VG","Venezuela":"VE","Saint Vincent and the Grenadines":"VC","Vatican City":"VA","Uzbekistan":"UZ","United States":"US","Uruguay":"UY","Ukraine":"UA","Uganda":"UG","Tanzania":"TZ","Taiwan":"TW","Turkey":"TR","Tunisia":"TN","Trinidad and Tobago":"TT","Tonga":"TO","Timor-Leste":"TL","Turkmenistan":"TM","Tokelau":"TK","Tajikistan":"TJ","Thailand":"TH","Togo":"TG","Chad":"TD","Turks and Caicos Islands":"TC","Syria":"SY","Seychelles":"SC","Sint Maarten":"SX","Eswatini":"SZ","Sweden":"SE","Slovenia":"SI","Slovakia":"SK","Suriname":"SR","Sao Tome and Principe":"ST","Serbia":"RS","Saint Pierre and Miquelon":"PM","Somalia":"SO","San Marino":"SM","El Salvador":"SV","Sierra Leone":"SL","Solomon Islands":"SB","Saint Helena":"SH","South Georgia and South Sandwich Islands":"GS","Singapore":"SG","Senegal":"SN","South Sudan":"SS","Sudan":"SD","Saudi Arabia":"SA","Western Sahara":"EH","Rwanda":"RW","Russia":"RU","Romania":"RO","Reunion":"RE","Qatar":"QA","French Polynesia":"PF","Paraguay":"PY","Portugal":"PT","North Korea":"KP","Puerto Rico":"PR","Poland":"PL","Papua New Guinea":"PG","Palau":"PW","Philippines":"PH","Peru":"PE","Pitcairn Islands":"PN","Panama":"PA","Pakistan":"PK","Oman":"OM","New Zealand":"NZ","Svalbard and Jan Mayen":"SJ","Nauru":"NR","Nepal":"NP","Norway":"NO","Niue":"NU","Nicaragua":"NI","Nigeria":"NG","Norfolk Island":"NF","Niger":"NE","New Caledonia":"NC","Namibia":"NA","Mayotte":"YT","Malaysia":"MY","Malawi":"MW","Mauritius":"MU","Martinique":"MQ","Montserrat":"MS","Mauritania":"MR","Mozambique":"MZ","Northern Mariana Islands":"MP","Mongolia":"MN","Montenegro":"ME","Myanmar":"MM","Malta":"MT","Mali":"ML","North Macedonia":"MK","Marshall Islands":"MH","Mexico":"MX","Maldives":"MV","Madagascar":"MG","Moldova":"MD","Monaco":"MC","Morocco":"MA","Saint Martin":"MF","Macau":"MO","Latvia":"LV","Luxembourg":"LU","Lithuania":"LT","Lesotho":"LS","Sri Lanka":"LK","Liechtenstein":"LI","Saint Lucia":"LC","Libya":"LY","Liberia":"LR","Lebanon":"LB","Lao People\'s Democratic Republic":"LA","Kuwait":"KW","Kosovo":"XK","South Korea":"KR","Saint Kitts and Nevis":"KN","Kiribati":"KI","Cambodia":"KH","Kyrgyzstan":"KG","Kenya":"KE","Kazakhstan":"KZ","Japan":"JP","Jordan":"JO","Jersey":"JE","Jamaica":"JM","Italy":"IT","Israel":"IL","Iceland":"IS","Iraq":"IQ","Iran":"IR","Ireland":"IE","British Indian Ocean Territory":"IO","India":"IN","Isle of Man":"IM","Indonesia":"ID","Hungary":"HU","Haiti":"HT","Croatia":"HR","Honduras":"HN","Heard Island and McDonald Islands":"HM","Hong Kong":"HK","Guyana":"GY","Guam":"GU","French Guiana":"GF","Guatemala":"GT","Greenland":"GL","Grenada":"GD","Greece":"GR","Equatorial Guinea":"GQ","Guinea-Bissau":"GW","Gambia":"GM","Guadeloupe":"GP","Guinea":"GN","Ghana":"GH","Guernsey":"GG","Georgia":"GE","Gabon":"GA","France":"FR","Federated States of Micronesia":"FM","Faroe Islands":"FO","Falkland Islands":"FK","Fiji":"FJ","Finland":"FI","Ethiopia":"ET","Estonia":"EE","Spain":"ES","Eritrea":"ER","United Kingdom":"GB","Egypt":"EG","Ecuador":"EC","Algeria":"DZ","Dominican Republic":"DO","Denmark":"DK","Dominica":"DM","Djibouti":"DJ","Germany":"DE","Czechia":"CZ","Cyprus":"CY","Cayman Islands":"KY","Christmas Island":"CX","Curaçao":"CW","Cuba":"CU","Costa Rica":"CR","Cape Verde":"CV","Comoros":"KM","Colombia":"CO","Cook Islands":"CK","Republic of Congo":"CG","Democratic Republic of Congo":"CD","Cameroon":"CM","Côte d\'Ivoire":"CI","China":"CN","Chile":"CL","Switzerland":"CH","Cocos (Keeling) Islands":"CC","Canada":"CA","Central African Republic":"CF","Belgium":"BE","Botswana":"BW","Bhutan":"BT","Brunei":"BN","Barbados":"BB","Brazil":"BR","Bolivia":"BO","Bermuda":"BM","Belize":"BZ","Belarus":"BY","Saint Barthelemy":"BL","Bahamas":"BS","Bahrain":"BH","Bosnia and Herzegovina":"BA","Bulgaria":"BG","Bangladesh":"BD","Burkina Faso":"BF","Benin":"BJ","Burundi":"BI","Azerbaijan":"AZ","Austria":"AT","Australia":"AU","French Southern and Antarctic Lands":"TF","Antarctica":"AQ","American Samoa":"AS","Armenia":"AM","Argentina":"AR","United Arab Emirates":"AE","Andorra":"AD","Aland Islands":"AX","Albania":"AL","Anguilla":"AI","Angola":"AO","Afghanistan":"AF","Antigua and Barbuda":"AG","Aruba":"AW","Aruba":"AW"}');

	$js = Array();
	$table = Array();
	$tabs = [
		["GlobalPeaceIndex", "score", "negative_index", "https://en.wikipedia.org/wiki/Global_Peace_Index"],
		["Temperatures", "average", "around_value_13", "https://listfist.com/list-of-countries-by-average-temperature"],
		["PPP", "value", "positive_index", "https://en.wikipedia.org/wiki/List_of_countries_by_GDP_(PPP)_per_capita"],
		["WelfareSpending", "value", "positive_index", "https://en.wikipedia.org/wiki/List_of_countries_by_social_welfare_spending"],
		["HealthSystems", "score", "negative_index", "https://en.wikipedia.org/wiki/World_Health_Organization_ranking_of_health_systems_in_2000"],
		["Learning", "score", "positive_index", "https://ourworldindata.org/grapher/average-harmonized-learning-outcome-scores?tab=map"],
		["MentalHealt", "value", "negative_index", "https://ourworldindata.org/grapher/death-rates-from-mental-health-and-substance-use-disorders"],
		["Suicide", "score", "negative_index", "https://ourworldindata.org/grapher/suicide-death-rates"]
	];

	/*
	["Anxiety", "score", "negative_index", "https://ourworldindata.org/grapher/share-with-anxiety-disorders"],
	["Depression", "score", "negative_index", "https://ourworldindata.org/grapher/share-with-depression"],
	*/

	if(!isset($_POST["partial"]))
		$_POST["partial"] = 1;

	if($_POST["partial"] == 1)
		$partial1 = "checked";
	else
		$partial0 = "checked";

	echo '<div id="hidemap">';
	echo '<form method="post"><p class="translate" attr-translate="search_description"></p>';
	echo '<input type="radio" name="partial" value="0" '.$partial0.' /> <span class="translate" attr-translate="all_data"></span><br />';
	echo '<input type="radio" name="partial" value="1" '.$partial1.' /> <span class="translate" attr-translate="partial_data"></span><br />';
	echo'<table>';
	foreach($tabs as $tab){
		if(!isset($_POST[$tab[0]]))
			$_POST[$tab[0]] = 100;
		echo '<tr><td width="170"><a href="' . $tab[3] . '" target="_blank" class="translate" attr-translate="'.$tab[0].'"></a></td><td><input type="range" name="'.$tab[0].'" value="'.$_POST[$tab[0]].'" min="0" max="100" oninput="this.nextElementSibling.value = this.value"><output>100</output></td></tr>';
	}
	echo '</table><input type="submit"></form>';
	foreach($tabs as $tab){
		$sth = $pdo->prepare("SELECT * FROM ".$tab[0]." ORDER BY ".$tab[1]." DESC");
		$sth->execute();
		$rows = $sth->fetchAll(PDO::FETCH_CLASS);
		foreach($rows as $row){
			if(in_array($row->{"state"}, ["Southeast Asia", "Eastern Sub-Saharan Africa", "Western Sub-Saharan Africa", "Central Sub-Saharan Africa", "Sub-Saharan Africa", "South Asia", "Low SDI", "Low-middle SDI", "Southern Latin America", "Middle SDI", "Southeast Asia, East Asia, and Oceania", "North Africa and Middle East", "Oceania", "Central Latin America", "Andean Latin America", "Southern Sub-Saharan Africa", "East Asia", "High-middle SDI", "Latin America and Caribbean", "Central Asia", "Tropical Latin America", "World", "Eastern Europe", "Central Europe, Eastern Europe, and Central Asia", "Central Europe", "High SDI", "North America", "Yugoslavia", "FR Yugoslavia", "High-income Asia Pacific", "Western Europe", "Scotland", "England", "Northern Ireland", "Wales", "High-income", "Australasia", "Caribbean", "North America (WB)", "Region of the Americas (WHO)", "Latin America & Caribbean (WB)", "Middle East & North Africa (WB)", "World Bank High Income", "OECD Countries", "Eastern Mediterranean Region (WHO)", "Europe & Central Asia (WB)", "European Region (WHO)", "World Bank Upper Middle Income", "G20", "World Bank Low Income", "African Region (WHO)", "Sub-Saharan Africa (WB)", "East Asia & Pacific (WB)", "World Bank Lower Middle Income", "Western Pacific Region (WHO)", "South-East Asia Region (WHO)", "South Asia (WB)", "World Bank Low Income", "North America (WB)", "Sub-Saharan Africa (WB)", "Middle East & North Africa (WB)", "African Region (WHO)", "Eastern Mediterranean Region (WHO)", "World Bank High Income", "OECD Countries", "South Asia (WB)", "Region of the Americas (WHO)", "European Region (WHO)", "Europe & Central Asia (WB)", "World Bank Lower Middle Income", "South-East Asia Region (WHO)", "Latin America & Caribbean (WB)", "World Bank Upper Middle Income", "Western Pacific Region (WHO)", "East Asia & Pacific (WB)", "South Asia (WB)", "Europe & Central Asia (WB)", "European Region (WHO)", "North America (WB)", "South-East Asia Region (WHO)", "World Bank Low Income", "World Bank High Income", "Sub-Saharan Africa (WB)", "African Region (WHO)", "OECD Countries", "World Bank Lower Middle Income", "Region of the Americas (WHO)", "World Bank Upper Middle Income", "Western Pacific Region (WHO)", "East Asia & Pacific (WB)", "Latin America & Caribbean (WB)", "Eastern Mediterranean Region (WHO)", "Middle East & North Africa (WB)", "Macao", "Belgium Flemish", "Canada (Quebec)", "Canada (Ontario)", "United Arab Emirates (Dubai)", "Spain (regions)", "Mexico (Nuevo Leo)", "United Arab Emirates (Abu Dhabi)", "Argentina (Buenos Aires)"]))
				continue;

			$state = translate_state($row->{"state"});

			if(!in_array($state, $names_allowed))
				echo $state." - ";

			if(!isset($js[$state])){
				$js[$state] = [];
				$table[$state] = [];
			}
			if(!isset($js[$state][$tab[0]])){
				$table[$state][$tab[0]] = [];
			}
			$js[$state][$tab[0]] = normalize($tab[0], $tab[2], $row->{$tab[1]}, $rows[count($rows) - 1]->{$tab[1]}, $rows[0]->{$tab[1]});

			$table[$state][$tab[0]][] = normalize($tab[0], $tab[2], $row->{$tab[1]}, $rows[count($rows) - 1]->{$tab[1]}, $rows[0]->{$tab[1]});
			$table[$state][$tab[0]][] = $row->{$tab[1]};
		}
	}

	$js_avg = Array();
	foreach($js as $key => $j){
		if(count($j) != count($tabs) && $_POST["partial"] == 0)
			continue;
		$sum = 0;
		$tot = 0;
		foreach($j as $keyi => $i){
			$sum += $i;
			$tot += 1 * ($_POST[$keyi] / 100);
		}

		if($tot == 0)
			$js_avg[] = Array("id" => $nameid->{$key}, "value" => 0);
		else
			$js_avg[] = Array("id" => $nameid->{$key}, "value" => $sum/$tot);
	}

	echo '<table id="example" class="display" style="width:100%">';
	echo "<thead><tr id='header_row'><th>State</th><th>Score</th>";
	foreach($tabs as $tab){
		echo "<th><span class='translate' attr-translate='".$tab[0]."'></span> (<span class='translate' attr-translate='score'></span>)</th>";
		echo "<th><span class='translate' attr-translate='".$tab[0]."'></span></th>";
	}
	echo "</tr></thead><tbody>";
	foreach($table as $key => $row){
		echo "<tr><td class='header_col'>".$key."</td><td>".$js_avg[$key]."</td>";
		foreach($tabs as $tab){
			if(isset($row[$tab[0]])){
				echo "<td>".$row[$tab[0]][0]."</td>";
				echo "<td>".$row[$tab[0]][1]."</td>";
			} else {
				echo "<td>No data</td><td>No data</td>";
			}
		}
		echo "</tr>";
	}
	echo "</tbody><tfoot><tr><th>State</th><th>Score</th>";
	foreach($tabs as $tab){
		echo "<th>".$tab[0]." ".$tab[1]."</th>";
		echo "<th>".$tab[0]." ".$tab[1]."</th>";
	}
	echo "</tr></tfoot>";
	echo "</table><br />* <span class='translate' attr-translate='score_info'></span></div>";
?>

<!-- Chart code -->
<script>
function translate(key){
	var lang = navigator.language || navigator.userLanguage; 
	if(lang == "it-IT"){
		if(key == "GlobalPeaceIndex")
			return "Pace";
		if(key == "PPP")
			return "Potere d&apos;acquisto";
		if(key == "Learning")
			return "Istruzione";
		if(key == "Temperatures")
			return "Temperature";
		if(key == "WelfareSpending")
			return "Welfare";
		if(key == "HealthSystems")
			return "Sistema sanitario";
		if(key == "MentalHealt")
			return "Morti per abuso di sostanze e salute mentale";
		if(key == "Suicide")
			return "Suicidi";
		if(key == "score")
			return "punteggio*";
		if(key == "score_info")
			return "Punteggio calcolato secondo la tua priorità d&apos;importanza";
		if(key == "search_description")
			return "Indica l'importanza che hanno per te i seguenti parametri per creare la tua mappa personale e premi sul bottone vai!";
		if(key == "all_data") 
			return "Mostra solo gli stati con tutti i dati";
		if(key == "partial_data") 
			return "Mostra anche gli stati con dati parziali";
	} else {
		if(key == "GlobalPeaceIndex")
			return "Pace";
		if(key == "PPP")
			return "Purchasing power";
		if(key == "Learning")
			return "Learning";
		if(key == "Temperatures")
			return "Temperature";
		if(key == "WelfareSpending")
			return "Welfare";
		if(key == "HealthSystems")
			return "Sanitary system";
		if(key == "MentalHealt")
			return "Mental healt";
		if(key == "Suicide")
			return "Suicide";
		if(key == "score")
			return "score*";
		if(key == "score_info")
			return "Score calculated according to your priority of importance";
		if(key == "search_description")
			return "Indicate the importance that the following parameters have for you to create your personal map and press the go button!";
		if(key == "all_data") 
			return "Show only states with all data";
		if(key == "partial_data") 
			return "It also shows states with partial data";
	}
	return key;
}
$(document).ready(function () {
    var table = $('#example').DataTable({
    	order: [[1, 'desc']],
        paging: false,
        fixedColumns: { left: 1 }
    });
    new $.fn.dataTable.FixedHeader( table );

    $(".translate").each(function(){
    	$(this).html(translate($(this).attr("attr-translate")));
    });
    $("span[attr-translate='score']").attr("title",translate("score_info"));
});
am5.ready(function() {
	<?php echo 'var score = ' . json_encode($js_avg) . ';'; ?>
	// Create root element
	// https://www.amcharts.com/docs/v5/getting-started/#Root_element
	var root = am5.Root.new("chartdiv");

	// Set themes
	// https://www.amcharts.com/docs/v5/concepts/themes/
	root.setThemes([
	  am5themes_Animated.new(root)
	]);

	// Create the map chart
	// https://www.amcharts.com/docs/v5/charts/map-chart/
	// setting rotationX to -154.8 makes the map Pacific-centered
	var chart = root.container.children.push(am5map.MapChart.new(root, {
	  panX: "translateX",
	  panY: "translateY",
	  projection: am5map.geoMercator()
	}));

	// Create main polygon series for countries
	// https://www.amcharts.com/docs/v5/charts/map-chart/map-polygon-series/
	var polygonSeries = chart.series.push(am5map.MapPolygonSeries.new(root, {
	  geoJSON: am5geodata_worldLow,
	  exclude: ["AQ"],
	  valueField: "value",
  	  calculateAggregates: true
	}));

	polygonSeries.mapPolygons.template.setAll({
	  tooltipText: "{name}: {value}"
	});

	var col_range = [am5.color(0x750000), am5.color(0x03ff00)]

	polygonSeries.set("heatRules", [{
	  target: polygonSeries.mapPolygons.template,
	  dataField: "value",
	  min: col_range[0],
	  max: col_range[1],
	  key: "fill"
	}]);

	polygonSeries.mapPolygons.template.events.on("pointerover", function(ev) {
	  heatLegend.showValue(ev.target.dataItem.get("value"));
	});

	polygonSeries.data.setAll(score);

	var heatLegend = chart.children.push(am5.HeatLegend.new(root, {
	  orientation: "vertical",
	  startColor: col_range[0],
	  endColor: col_range[1],
	  startText: "Worse",
	  endText: "Best",
	  stepCount: 5
	}));

	// change this to template when possible
	polygonSeries.events.on("datavalidated", function () {
	  heatLegend.set("startValue", polygonSeries.getPrivate("valueLow"));
	  heatLegend.set("endValue", polygonSeries.getPrivate("valueHigh"));
	});


	var colorSet = am5.ColorSet.new(root, {});

	var i = 0;
	polygonSeries.mapPolygons.template.adapters.add("fill", function (fill, target) {
		//console.log(JSON.stringify(target));
	  if (i < 10) {
		i++;
	  }
	  else {
		i = 0;
	  }
	  var dataContext = target.dataItem.dataContext;
	  //console.log(dataContext["id"]+" "+dataContext["name"]);
	  if (!dataContext.colorWasSet) {
		dataContext.colorWasSet = true;
		if(typeof score[dataContext["name"]] === "undefined"){
			//console.log(dataContext["name"]);
			score[dataContext["name"]] = 0;
		}

		if(score[dataContext["name"]] == 0)
			color = am5.color("#b9b9b9");
		/*if(score[dataContext["name"]] > 0  && score[dataContext["name"]] < 0.2)
			color = am5.color("#c25d33");
		if(score[dataContext["name"]] >= 0.2  && score[dataContext["name"]] < 0.4)
			color = am5.color("#e7a877"); 
		if(score[dataContext["name"]] >= 0.4  && score[dataContext["name"]] < 0.6)
			color = am5.color("#f1ecd7");
		if(score[dataContext["name"]] >= 0.6  && score[dataContext["name"]] < 0.8)
			color = am5.color("#a7c2a4");
		if(score[dataContext["name"]] >= 0.8  && score[dataContext["name"]] <= 1)
			color = am5.color("#448c82");*/
		

		//color = am5.color("rgb(0, 0, "+parseInt(score[dataContext["name"]]* 255)+")");
		target.setRaw("fill", color);
		return color;
	  }
	  else {
		return fill;
	  }
	})

	/*polygonSeries.mapPolygons.template.states.create("hover", { fillOpacity: 1 });

	// Add zoom control
	// https://www.amcharts.com/docs/v5/charts/map-chart/map-pan-zoom/#Zoom_control
	chart.set("zoomControl", am5map.ZoomControl.new(root, {}));

	// Set clicking on "water" to zoom out
	chart.chartContainer.get("background").events.on("click", function() {
	  chart.goHome();
	})

	// Make stuff animate on load
	chart.appear(1000, 100);*/

}); // end am5.ready()
</script>