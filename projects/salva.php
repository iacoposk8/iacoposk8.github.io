<?php
	// verificare se il file esiste
	$filename="HCA_project(".$_POST['numero_salvataggio'].")_".time().rand(0000,9999).".xml";
	$cartella="salvataggi/";

	while(file_exists($cartella.$filename))
	{
		$filename="HCA_project(".$_POST['numero_salvataggio'].")_".time().rand(0000,9999).".xml";
	}
	
	//creare file
	$testo="<?xml version='1.0' encoding='UTF-8'?>
<hca>
  <var>
    <val>".stripslashes($_POST['dati_salvataggio'])."</val>
  </var>
</hca>";
	$f = fopen($cartella.$filename,"w");
	fwrite($f,$testo);
	fclose($f);

	//download file
	if(!file_exists($cartella.$filename))
	{
		// se non esiste chiudo e stampo un errore
	  	die("Errore durante la creazione del file");
	}
	else
	{
	  	// Se il file esiste...
	  	// Imposto gli header della pagina per forzare il download del file
	 	header("Cache-Control: public");
	  	header("Content-Description: File Transfer");
	 	header("Content-Disposition: attachment; filename= ".$filename);
	  	header("Content-Transfer-Encoding: binary");
	  	// Leggo il contenuto del file
	  	readfile($cartella.$filename);
	}
?>
