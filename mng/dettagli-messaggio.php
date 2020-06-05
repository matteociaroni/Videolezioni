<! Autore: Matteo Ciaroni>
<html>
<head>
	<meta charset="UTF-8">
	<title> Videolezioni - Messaggio</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../style2.css?1.9.4">
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
include "logged.php";
session_start();
if(msg()!=1)
{
	echo '<script type="text/javascript">
			alert("Non puoi accedere qui")
			window.location.href = "index.php"
			</script>';
}
echo file_get_contents('MNGnavbar.html');
?>
<h2> Messaggio </h2>
<br>
<table id="table" align="center" style="font-size: 100%; ">

	<?
	$id=$_GET['id'];
	include_once "../util.php";

	$query="SELECT
    	id,
		DATE_FORMAT(Data_inserimento, '%d/%m %H:%i') AS d,
    	Nome,
        Email,
        Messaggio
    	FROM Contatti 
        WHERE id='$id'";

	$risultato=database2()->query($query);

	while($row=$risultato->fetch_assoc())
	{
		?>

		<div class="container" style="text-align: left;">
			<dl class="row">
				<dt class="col-sm-3"></dt>
				<dt class="col-sm-2">ID</dt>
				<dd class="col-sm-4"> <? echo $row["id"]; ?> </dd>
			</dl>
			<dl class="row">
				<dt class="col-sm-3"></dt>
				<dt class="col-sm-2">Nome</dt>
				<dd class="col-sm-4"> <? echo $row["Nome"]; ?> </dd>
			</dl>
			<dl class="row">
				<dt class="col-sm-3"></dt>
				<dt class="col-sm-2">Email</dt>
				<dd class="col-sm-4"> <? echo $row["Email"]; ?> </dd>
			</dl>
			<dl class="row">
				<dt class="col-sm-3"></dt>
				<dt class="col-sm-2">Messaggio</dt>
				<dd class="col-sm-4"> <? echo $row["Messaggio"]; ?> </dd>
			</dl>
		</div>
	<?
	}
	?>
<br>
</body>

</html>
