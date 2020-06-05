<! Autore: Matteo Ciaroni>
<?php
include "logged.php";
$idPrimo=$_GET['id'];
if(modif()!=1 && isMyLesson($idPrimo)==false)
	err();
else
{
	$idPrimo=$_GET['id'];
	if(isset($idPrimo))
	{
		include_once "../util.php";
		$sql="INSERT INTO Videolezioni SELECT null, Classe, Data, Ora_inizio, Ora_fine, Materia, Prof, Compiti, Link, Codice, Annotazioni, null FROM Videolezioni WHERE id=$idPrimo";
		database2()->query($sql);
		$sql="SELECT  MAX(id) AS id FROM Videolezioni";
		$risultato=database2()->query($sql);
		$idSecondo=$risultato->fetch_assoc();
		header("Location: modifica-videolezione.php?id=".$idSecondo["id"]);
	}
	else
	{
		echo "Inserisci ID";
	}
}
?>
