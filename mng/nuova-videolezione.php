<! Autore: Matteo Ciaroni>
<html>
<head>
	<meta charset="UTF-8">
	<title> Nuova videolezione </title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../style2.css?1.8.1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<style>
		.col-lg
		{
			margin-left: 20px;
			margin-right: 20px;
		}
	</style>
</head>

<body>
<?php
include "logged.php";
echo file_get_contents('MNGnavbar.html');
?>
<h2> Aggiunta </h2>
<p> Per annullare, tornare indietro </p>
<br>
<form method="post">
	<div class="container" style="max-width: 800px; text-align: left">
		<div class="row">
			<div class="col-lg">
				<div class="form-group">
					<label>Classe</label>
					<select name="classe" class="form-control">
						<?php
						include "../util.php";
						selectClasse();
						?>
					</select>
				</div>
				<div class="form-group">
					<label>Data</label>
					<input type="date" class="form-control" name="data">
				</div>
				<div class="row">
					<div class="col-6">
						<div class="form-group">
							<label>Ora inizio</label>
							<input type="time" class="form-control" name="orainizio">
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label>Ora fine</label>
							<input type="time" class="form-control" name="orafine">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label>Materia</label>
					<input type="text" class="form-control" name="materia">
				</div>
				<div class="form-group">
					<label>Prof</label>
					<input type="text" class="form-control" name="prof"
						<?php
						if(modif()!=1)
							echo 'value="'.cognome().'"';
						?>>
				</div>
			</div>
			<div class="col-lg">
				<div class="form-group">
					<label>Compiti</label>
					<input type="checkbox" class="form-control" name="compiti" value="1">
				</div>
				<div class="form-group">
					<label>Link Meet</label>
					<input type="url" class="form-control" name="link">
				</div>
				<div class="form-group">
					<label>Codice Meet</label>
					<input type="text" class="form-control" name="codice">
				</div>
				<div class="form-group">
					<label>Note</label>
					<textarea type="text" class="form-control" rows="5" name="annotazioni"></textarea>
				</div>
			</div>
		</div>
	</div>
	</div>
	<br>
	<input class="btn" type="submit" name="formSubmit" value="Salva"/><br/>
</form>
<?php
if($_POST['formSubmit']=="Salva")
{
	$classe=$_POST['classe'];
	$data=$_POST['data'];
	$orainizio=$_POST['orainizio'];
	$orafine=$_POST['orafine'];
	$materia=$_POST['materia'];
	$prof=$_POST['prof'];
	$compiti=$_POST['compiti'];
	$link=$_POST['link'];
	$codice=$_POST['codice'];
	$annotazioni=$_POST['annotazioni'];
	if($compiti!=1)
		$compiti=0;
	if(empty($data) || empty($orainizio) || empty($orafine) || empty($materia) || empty($prof))
	{
		echo '<p style="color:red">Devi inserire almeno i primi 5 campi.</p>';
	}
	else if($orafine<=$orainizio)
	{
		echo '<p style="color:red">La lezione non può finire prima di essere iniziata.</p>';
	}
	else if(modif()!=1 && strpos($prof, cognome())===false)
	{
		echo '<p style="color:red">Il nome del prof non contiene il tuo.</p>';
	}
	else
	{
		include_once "../util.php";

		$sql="INSERT INTO Videolezioni (id, Classe, Data, Ora_inizio, Ora_fine, Materia, Prof, Compiti, Link, Codice, Annotazioni) VALUES (NULL, '$classe', '$data', '$orainizio', '$orafine', '$materia', '$prof', '$compiti', '$link', '$codice', '$annotazioni')";
		database2()->query($sql);
		header('Location: videolezioni-elenco.php');
	}
}
?>
<br>
</body>

</html>