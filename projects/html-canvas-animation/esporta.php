<?php
	$filename="HCA_".time().rand(0000,9999);
	$cartella="esportati/";
	$cartella_filejs="sandbox_files/";
	$nuova_cartella="include/";

	while(file_exists($cartella.$filename))//univocità file zip
	{
		$filename="HCA_".time().rand(0000,9999);
	}

	$archivia = new ZipArchive();
	$nome_file_zip = $cartella.$filename.".zip";

	if ($archivia->open($nome_file_zip, ZIPARCHIVE::CREATE)!==TRUE) 
	{
	  @exit("Impossibile aprire <$nome_file_zip>\n");
	}

	if($_POST['tipo_exp']=="animazione"){$dati_salvataggio_exp=$_POST["dati_salvataggio_exp_anim"];}
	else{$dati_salvataggio_exp=$_POST["dati_salvataggio_exp_fis"];}

	$dati_salvataggio_exp=explode("immagini_up/",$dati_salvataggio_exp);
	$dati_salvataggio_prov=""; $elenco_img=Array();

	for($i=0;$i<count($dati_salvataggio_exp);$i++){
		$dati_salvataggio_prov.=$dati_salvataggio_exp[$i]."images/";
		$elenco_img[]=substr($dati_salvataggio_exp[$i+1],0,strpos($dati_salvataggio_exp[$i+1],'",'));
	}
	$dati_salvataggio_exp=$dati_salvataggio_prov;
//echo htmlentities($dati_salvataggio_exp);

	if(substr($dati_salvataggio_exp,strlen($dati_salvataggio_exp)-7,strlen($dati_salvataggio_exp))=="images/"){
		$dati_salvataggio_exp=substr($dati_salvataggio_exp,0,strlen($dati_salvataggio_exp)-7);
	}

	$archivia->addFromString("index.html", "<script src='".$nuova_cartella."jquery.js'></script>
<script src='".$nuova_cartella."jcanvas.js'></script>".stripslashes($dati_salvataggio_exp)."</script>");
	
	$archivia->addFile($cartella_filejs.'jquery.js', $nuova_cartella.'jquery.js');
	$archivia->addFile($cartella_filejs.'jcanvas.js', $nuova_cartella.'jcanvas.js');

	foreach($elenco_img as $eimg){
		$archivia->addFile('immagini_up/'.$eimg, 'images/'.$eimg);
	}

	//echo "Sono stati zippati: " . $archivia->numFiles . " file.\n";

	$archivia->close();

	// Imposto gli header della pagina per forzare il download del file
	header("Cache-Control: public");
  	header("Content-Description: File Transfer");
 	header("Content-Disposition: attachment; filename=".$cartella.$filename.".zip");
  	header("Content-Transfer-Encoding: binary");
  	// Leggo il contenuto del file
  	readfile($cartella.$filename.".zip");
?>
