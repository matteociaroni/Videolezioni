<! Autore: Matteo Ciaroni>
<?php
include "logged.php";
if(modif()==1)
{
	$query="SELECT
    	id,
        Classe,
		DATE_FORMAT(Data, '%d/%m/%Y') AS d,
    	Prof
    	FROM Videolezioni 
        ORDER BY Classe ASC, Data DESC, Ora_inizio DESC";
}
else
{
	$Prof=cognome();

	$query="SELECT
    	id,
        Classe,
		DATE_FORMAT(Data, '%d/%m/%Y') AS d,
    	Prof
    	FROM Videolezioni 
    	WHERE Prof LIKE '%{$Prof}%'
        ORDER BY Classe ASC, Data DESC, Ora_inizio DESC";
}
?>
<html>
<head>
	<meta charset="UTF-8">
	<title> Videolezioni elenco </title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../style2.css?1.6.1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<style>
		.btn
		{
			height: 40px;
			width: 100px;
			display: block;
			margin: auto;
		}
		.btn:hover
		{
			color: white !important;
		}
	</style>
</head>

<body>
<?php
echo file_get_contents('MNGnavbar.html');
?>

<p> Sono visualizzate tutte le videolezioni, di tutte le classi </p>

<table id="table" align="center" style="font-size: 100%; ">
	<tr class="intestazione">
		<td width="100px"> Classe</td>
		<td width="150px"> Data</td>
		<td width="300px"> Prof</td>
		<td width="200px"> Azioni</td>
	</tr>

	<?
	echo "Duplicati: ".duplicates()."<br><br>";
	include_once "../util.php";
	$risultato=database2()->query($query);
	$lastData=null;
	$oggi=date('d/m/Y');
	while($row=$risultato->fetch_assoc())
	{
		if($row["d"]!=$lastData)
		{
			$lastData=$row["d"];
			echo '<tr class="spessa"><td>';
		}
		else
			echo '<tr><td>';
		echo $row["Classe"];
		echo '</td><td>';
		echo $row["d"];
		echo '</td><td>';
		echo $row["Prof"];
		echo '</td><td>';
		echo '<div class="dropdown">
	<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown">
		Azioni
	</a>
	<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
		<a class="dropdown-item" href="../dettagli-videolezione.php?id='.$row["id"].'">Dettagli</a>
		<a class="dropdown-item" href="modifica-videolezione.php?id='.$row["id"].'">Modifica</a>
		<a class="dropdown-item" href="copia-videolezione.php?id='.$row["id"].'">Copia</a>
	</div>
</div>';
		echo '</td></tr>'."\r\n";
	}

	?>
</table>
<br>
</body>

</html>
