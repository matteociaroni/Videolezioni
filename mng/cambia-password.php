<! Autore: Matteo Ciaroni>
<html>
<head>
	<meta charset="UTF-8">
	<title> Nuova videolezione </title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../style2.css?1.6">
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
<h2> Profilo </h2>
<br>
<form method="post">
	<div class="container" style="max-width: 500px; text-align: left">
		<div class="col">
		<div class="form-group">
			<label>Vecchia password</label>
			<input type="text" class="form-control" name="vecchia" placeholder="Vecchia Password">
		</div>
		<div class="form-group">
			<label>Nuova Password</label>
			<input type="text" class="form-control" name="nuova1" placeholder="Nuova Password">
			<br>
			<input type="text" class="form-control" name="nuova2" placeholder="Conferma nuova Password">
		</div>
		</div>
	</div>
	<input class="btn" type="submit" name="formSubmit" value="Salva"/><br/>
</form>
<?php
if($_POST['formSubmit']=="Salva")
{
	$vecchia=$_POST['vecchia'];
	$nuova1=$_POST['nuova1'];
	$nuova2=$_POST['nuova2'];
	if(empty($vecchia) || empty($nuova1) || empty($nuova2))
	{
		echo '<p style="color:red">Compila tutti i campi.</p>';
	}
	else if($nuova1!=$nuova2)
	{
		echo '<p style="color:red">Le due nuove password non coincidono.</p>';
	}
	else
	{
		$email=email();
		include_once "../util.php";
		$vecchia=md5($vecchia);
		$query="SELECT id
    	FROM Utenti
        WHERE Email='$email' AND Password='$vecchia'
        ORDER BY id ASC";
		$risultato=database2()->query($query);
		if($risultato->num_rows==1)
		{
			$nuova1=md5($nuova1);
			$sql="UPDATE Utenti SET Password='$nuova1' WHERE Email='$email'";
			database2()->query($sql);
			header('Location: logout.php');
		}
		else
			echo '<p style="color:red">La password vecchia è errata.</p>';
	}
}
?>
<br>
</body>

</html>