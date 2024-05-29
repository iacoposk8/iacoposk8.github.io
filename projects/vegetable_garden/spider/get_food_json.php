<?php
	function get_before_h($str,$name){
		$str=str_replace("\r","",str_replace("\t","",str_replace("\n","",$str)));
		$ret=explode($name,$str);
		$ret=explode("<h2",$ret[1]);
		return $ret[0];
	}

	$urls=array(
		"http://www.dietabit.it/alimenti/legumi/",
		"http://www.dietabit.it/alimenti/cereali/",
		"http://www.dietabit.it/alimenti/farina/",
		"http://www.dietabit.it/alimenti/frutta/",
		"http://www.dietabit.it/alimenti/frutta-secca/",
		"http://www.dietabit.it/alimenti/funghi/",
		"http://www.dietabit.it/alimenti/pasta/",
		"http://www.dietabit.it/alimenti/verdure/"
	);

	$valori=array(
		"Calories"		=>"Calorie",
		"Carbohydrate"		=>"Carboidrati",
		"Protein"		=>"Proteine",
		"Fat"			=>"Grassi",
		"α-LinolenicAcid"	=>"C18:3 - Acido linolenico",
		"Linoleic Acid"		=>"C18:2 - Acido linoleico",
		"Water"			=>"Acqua",
		"CHO"			=>"***********************************************",
		"Calcium"		=>"Calcio",
		"Chloride"		=>"***********************************************",
		"Chromium"		=>"***********************************************",
		"Copper"		=>"Rame",
		"Iodine"		=>"***********************************************",
		"Iron"			=>"Ferro",
		"Magnesium"		=>"Magnesio",
		"Manganese"		=>"***********************************************",
		"Molybdenum"		=>"***********************************************",
		"Phosphorus"		=>"Fosforo",
		"Potassium"		=>"Potassio",
		"Selenium"		=>"Selenio",
		"Sodium"		=>"Sodio",
		"Zinc"			=>"Zinco",	
		"Vitamin A"		=>"Vitamina A (RAE)",
		"Vitamin C"		=>"Vitamina C (acido ascorbico)",
		"Vitamin D"		=>"Vitamina D (D2+D3)",
		"Vitamin E"		=>"Vitamina E",
		"Vitamin K"		=>"Vitamina K",
		"Thiamin"		=>"Tiamina (vitamina B1)",
		"Riboflavin"		=>"Riboflavina",
		"Niacin"		=>"Niacina",
		"Vitamin B 6"		=>"Piridossina (vitamina B6)",
		"Folate"		=>"***********************************************",
		"Vitamin B 12"		=>"Vitamina B12",
		"Pantothenic Acid"	=>"Acido Pantotenico (vitamina B5)",
		"Biotin"		=>"***********************************************",
		"Choline"		=>"Colina"
	);

	$json=array();
	$var=fopen("food.json","w+");
	foreach($urls as $url){
		echo "\n\n".$url."\n";
		$html=file_get_contents($url);
		$list=get_before_h($html,"calorie e valori nutrizionali");
		preg_match_all('/<a href="(.*?)">(.*?)<\/a>/',$list,$list);
		for($z=0;$z<count($list[1]);$z++){
			$v_name=$list[2][$z];
			echo $v_name.", ";
			$tab=file_get_contents("http://www.dietabit.it".$list[1][$z]);
			//$tab=file_get_contents("http://www.dietabit.it/alimenti/legumi/ceci/");
			$tab=str_replace("\r","",str_replace("\t","",str_replace("\n","",$tab)));
			preg_match_all('/<table(.*?)>(.*?)<\/table>/',$tab,$tab);
			$tab=$tab[2][count($tab[2])-1];
			preg_match_all('/<td(.*?)>(.*?)<\/td>/',$tab,$td);
			for($i=0;$i<count($td[2]);$i++){
				if(!strstr($td[1][$i],'colspan="4"') && !strstr($td[2][$i],'RDA')){
					foreach($valori as $key=>$val){
						if(strtolower(trim(strip_tags($td[2][$i])))==strtolower(trim($val))){
							$json[$v_name][$key]=$td[2][$i+1];
							break;
						}
					}
					$i+=2;
				}
			}
		}
	}

	$json=json_encode($json);
	$json=str_replace(":{",":{\n\t\t",$json);
	$json=str_replace("\",","\",\n\t\t",$json);
	$json=str_replace("},","\n\t},\n\t",$json);
	$json=substr($json,0,1)."\n\t".substr($json,1,-2)."\n\t}\n}";
	fwrite($var, $json);
	echo "\nFinish";
?>
