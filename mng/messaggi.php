<! Autore: Matteo Ciaroni>
<html>
<head>
	<meta charset="UTF-8">
	<title> Videolezioni - Messaggi</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../style2.css?1.6">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<style>
		.msg
		{
			font-size: 15px;
		}
	</style>
</head>

<body>
<?php
include_once "logged.php";
if(msg()!=1)
{
	err();
}
echo file_get_contents('MNGnavbar.html');
?>
<h2> Messaggi:
	<?php
	include "numero-messaggi.php";
	?>
</h2>
<br>
<table id="table" align="center" style="font-size: 100%; ">
	<tr class="intestazione">
		<td width="150px"> Data e ora</td>
		<td width="200px"> Nome</td>
		<td width="300px"> Email</td>
		<td width="150px"> Dettagli</td>

		<?

		include_once "../util.php";

		$query="SELECT
		DATE_FORMAT(Data_inserimento, '%d/%m %H:%i') AS d,
    	Nome,
        Email,
        id
    	FROM Contatti 
        ORDER BY Data_inserimento ASC";

		$risultato=database2()->query($query);

		while($row=$risultato->fetch_assoc())
		{
			echo '<tr><td>'.$row["d"].'</td>';
			echo '<td>'.$row["Nome"].'</td>';
			echo '<td><a href=mailto:'.$row["Email"].'>'.$row["Email"].'</td>';
			echo '<td><a class="link" href=dettagli-messaggio.php?id='.$row["id"].'>Dettagli</td>';
		}
		?>
</table>
<br>
</body>

</html>
