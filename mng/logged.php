<?php
function msg() //verifica che l'utente abbia l'autorizzazione a leggere i messaggi (quelli scritti tramite la pagina "Contatti")
{
	session_start();
	include_once "../util.php";
	$utente=$_SESSION['username'];
	$query="SELECT auth_messaggi
    	FROM Utenti
        WHERE Email='$utente'";
	$risultato=database2()->query($query);
	$row=$risultato->fetch_assoc();
	return $row["auth_messaggi"];
}

function modif() //verifica che l'utente abbia l'autorizzazione a modificare tutte le videolezioni. Un prof "base", senza questa autorizzazione, potrà modificare solo le proprie videolezioni
{
	session_start();
	include_once "../util.php";
	$utente=$_SESSION['username'];
	$query="SELECT auth_modifica
    	FROM Utenti
        WHERE Email='$utente'";
	$risultato=database2()->query($query);
	$row=$risultato->fetch_assoc();
	return $row["auth_modifica"];
}

function mieLezioni()
{
	session_start();
	include_once "../util.php";
	$utente=$_SESSION['username'];
	$query="SELECT auth_mielezioni
    	FROM Utenti
        WHERE Email='$utente'";
	$risultato=database2()->query($query);
	$row=$risultato->fetch_assoc();
	return $row["auth_mielezioni"];
}

function cognome() //restituisce il cognome dell'utente
{
	include_once "../util.php";
	$utente=$_SESSION['username'];
	$query="SELECT Cognome
    	FROM Utenti
        WHERE Email='$utente'";
	$risultato=database2()->query($query);
	$row=$risultato->fetch_assoc();
	return $row["Cognome"];
}

function nome() //restituisce il nome dell'utente
{
	include_once "../util.php";
	$utente=$_SESSION['username'];
	$query="SELECT Nome
    	FROM Utenti
        WHERE Email='$utente'";
	$risultato=database2()->query($query);
	$row=$risultato->fetch_assoc();
	return $row["Nome"];
}

function email() //restituisce l'email dell'utente
{
	include_once "../util.php";
	$utente=$_SESSION['username'];
	$query="SELECT Email
    	FROM Utenti
        WHERE Email='$utente'";
	$risultato=database2()->query($query);
	$row=$risultato->fetch_assoc();
	return $row["Email"];
}

function err() //restituisce un alert che non permette di proseguire nella pagina e reindirizza alla home
{
	echo '<script type="text/javascript">
              alert("Non puoi accedere qui")
              window.location.href = "index.php"
              </script>';
}

function isMyLesson($id) //verifica se l'id passato corrisponde a una lezione dell'utente, controllando se è presente il suo cognome tra i prof della lezione
{
	include_once "../util.php";
	$Prof=cognome();
	$query="SELECT id, Prof
    	FROM Videolezioni
        WHERE Prof LIKE '%{$Prof}%' AND id=$id";
	$risultato=database2()->query($query);
	echo "Fatto";
	if($risultato->num_rows==1)
	{
		return true;
	}
	return false;
}

function duplicates() //controlla la presenza di duplicati
{
	include_once "../util.php";
	if(modif()==1)
	{
		$query="SELECT Count(cont) AS c FROM (SELECT Count(id) AS cont, Data, Materia FROM `Videolezioni` GROUP BY Classe, Data, Materia, Prof, Ora_inizio, Ora_fine HAVING cont>1) AS duplicati";
	}
	else
	{
		$Prof=cognome();
		$query="SELECT Count(cont) AS c FROM (SELECT Count(id) AS cont, Data, Materia FROM `Videolezioni` WHERE Prof LIKE '%{$Prof}%' GROUP BY Classe, Data, Materia, Prof, Ora_inizio, Ora_fine HAVING cont>1) AS duplicati";
	}
		$risultato=database2()->query($query);
		$row=$risultato->fetch_assoc();
		return $row["c"];
}

function classOverlaps()
{
	$query="SELECT v1.id AS id_1, v2.id AS id_2 FROM `Videolezioni` v1, Videolezioni v2 WHERE v1.Classe=v2.Classe AND v1.Data=v2.Data AND v1.id!=v2.id AND ((v1.Ora_inizio<v2.Ora_inizio and v1.Ora_fine>v2.Ora_inizio) OR (v1.Ora_inizio<=v2.Ora_inizio AND v1.Ora_fine>=v2.Ora_fine))";
}

//controlla se l'utente è loggato
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true)
	header('Location: ../login.php');

?>