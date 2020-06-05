<! Autore: Matteo Ciaroni>
<html>
<head>
	<meta charset="UTF-8">
	<title> Videolezioni - MNG </title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../style2.css?1.7">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body>
<?php
include "logged.php";
echo file_get_contents('MNGnavbar.html');
?>
<h2> Management tools </h2>
<h5> Benvenuto, <? echo nome().' '.cognome(); ?></h5>
<br>
<?php
if(mieLezioni()==1)
{
	echo '
	<form action="../VideolezioniProf.php">
	<input type="hidden" name="prof" value="'.cognome().'">
	<input class="btn" type="submit" value="Mie Lezioni"/>
	</form>';
}

?>
<form action="videolezioni-elenco.php">
	<input class="btn" type="submit" value="Elenco"/>
</form>
<form action="nuova-videolezione.php">
	<input class="btn" type="submit" value="Aggiungi"/>
</form>
<br>
<?php
session_start();
if(msg()==1)
{
	echo '<p> Messaggi: ';
	include "numero-messaggi.php";
	echo '</p>
		<form action="messaggi.php">
    	<input class="btn" type="submit" value="Messaggi" />
		</form>';
}
?>
</body>

</html>
