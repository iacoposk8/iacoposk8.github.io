<?

// QUESTE RIGHE RENDONO LO SCRIPT COMPATIBILE CON LE VERSIONI
// DI PHP PRECEDENTI ALLA 4.1.0
if(!isset($_FILES)) $_FILES = $HTTP_POST_FILES;
if(!isset($_SERVER)) $_SERVER = $HTTP_SERVER_VARS;

/********************* VARIABILI DA SETTARE ********************/
// Directory dove salvare i files Uploadati ( chmod 777, percorso assoluto)
$upload_dir = realpath(".")."/".$_GET['tipo'];

$file_name = str_replace("'", "" ,$_FILES["upfile"]["name"]);
$file_name = str_replace('"', '' ,$file_name);
//$file_name = htmlentities($_FILES["upfile"]["name"]);

$path_info = pathinfo($upload_dir.$file_name);
$estensione=$path_info['extension'];

//per evitare l'omonimia
while(file_exists($upload_dir."/".$file_name))
{
	$file_name=substr($file_name, 0, strlen($file_name)-4).time().rand(0000,9999).".".$estensione;
}

if(trim($_FILES["upfile"]["name"]) == "")
{
	die("Non hai indicato il file da uploadare !");
}

//controllo del tipo
if($_GET['tipo']=="immagini_up")
{
	$allowed_ext = array("gif","jpg","jpeg","png","GIF","JPG","JPEG","PNG");
}
if($_GET['tipo']=="apri_xml")
{
	$allowed_ext = array("xml");
}
if(!in_array($estensione,$allowed_ext))
{
	die("Il file non è di un tipo consentito, sono ammessi solo i seguenti: " . implode(", ", $allowed_ext) . ".");
}

//fa l'upload
if(@is_uploaded_file($_FILES["upfile"]["tmp_name"]))
{
	@move_uploaded_file($_FILES["upfile"]["tmp_name"], "$upload_dir/$file_name")
	or die("Impossibile spostare il file, controlla l'esistenza o i permessi della directory dove fare l'upload.");
} 
else
{
	die("Problemi nell'upload del file " . $_FILES["upfile"]["name"] . ". Controlla che il file non superari i 2Mb di peso e che il nome del file non contenga caratteri speciali");
}
echo "corretto," . $file_name;
?> 
