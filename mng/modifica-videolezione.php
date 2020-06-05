<! Autore: Matteo Ciaroni>
<html>
<head>
	<meta charset="UTF-8">
	<title> Modifica videolezione </title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../style2.css?1.9">
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
<div class="container">
	<h2> Modifica </h2>
	<p> Per annullare, tornare indietro <br> Per eliminare, premere Elimina </p>
	<form method="post">
		<div class="container" style="max-width: 800px; text-align: left">
			<div class="row">
				<div class="col-lg">
					<div class="form-group">
						<label>ID</label>
						<input type="text" class="form-control" name="id" value="
				<?
						$id=$_GET['id'];
						if($id==null)
							echo "Nessun ID!";
						else
							echo $id;
						?>
				" disabled>
					</div>
					<div class="form-group">
						<label>Classe</label>
						<select name="classe" class="form-control">
							<? //select classi
							include "../util.php";

							$query="SELECT
    	Classe,
		Data,
    	TIME_FORMAT(Ora_inizio, '%H:%i') AS oi, 
    	TIME_FORMAT(Ora_fine, '%H:%i') AS of,
    	Materia,
        Prof, 
        Compiti,
        Link,
        Codice,
        Annotazioni
    	FROM Videolezioni
        WHERE id='$id'
        ORDER BY Data ASC, Ora_inizio ASC";

							$risultato=database2()->query($query);
							$row=$risultato->fetch_assoc();
							$classe=$row["Classe"];
							$data=$row["Data"];
							$orainizio=$row["oi"];
							$orafine=$row["of"];
							$materia=$row["Materia"];
							$prof=$row["Prof"];
							$compiti=$row["Compiti"];
							$link=$row["Link"];
							$codice=$row["Codice"];
							$annotazioni=$row["Annotazioni"];
							if(modif()!=1 && isMyLesson($id)==false)
								err();
							selectClasse($classe);
							echo ' </optgroup>';
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Data</label>
						<input type="date" class="form-control" value="<? echo $data; ?>" name="data">
					</div>
					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<label>Ora inizio</label>
								<input type="time" class="form-control" value="<? echo $orainizio; ?>" name="orainizio">
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label>Ora fine</label>
								<input type="time" class="form-control" value="<? echo $orafine; ?>" name="orafine">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Materia</label>
						<input type="text" class="form-control" value="<? echo $materia; ?>" name="materia">
					</div>
					<div class="form-group">
						<label>Prof</label>
						<input type="text" class="form-control" value="<? echo $prof; ?>" name="prof">
					</div>
				</div>
				<div class="col-lg">
					<div class="form-group">
						<label>Compiti</label>
						<input type="checkbox" class="form-control" name="compiti" value="1" <?
						if($compiti==1)
							echo 'checked';
						?>
					</div>
					<div class="form-group">
						<label>Link Meet</label>
						<input type="url" class="form-control" value="<? echo $link; ?>" name="link">
					</div>
					<div class="form-group">
						<label>Codice Meet</label>
						<input type="text" class="form-control" value="<? echo $codice; ?>" name="codice">
					</div>
					<div class="form-group">
						<label>Note</label>
						<textarea type="text" class="form-control" rows="5"
								  name="annotazioni"><? echo $annotazioni; ?></textarea>
					</div>
					<div class="row" style="text-align: center">
						<div class="col-6">
							<input class="btn" type="submit" name="formSubmit" value="Salva"/><br/>
						</div>
	</form>
	<div class="col-6">
		<form method="post">
			<input class="btn" type="submit" name="formSubmit" value="Elimina"/><br/>
		</form>
	</div>
</div>
</div>
</div>
</div>
<br>
</div>
</div>
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
		$sql="UPDATE Videolezioni SET Classe='$classe', Data='$data',  Ora_inizio='$orainizio', Ora_fine='$orafine', Materia='$materia', Prof='$prof', Compiti='$compiti', Link='$link', Codice='$codice', Annotazioni='$annotazioni' WHERE id=$id";
		database2()->query($sql);
		echo "<script type='text/javascript'> document.location = 'videolezioni-elenco.php'; </script>";
	}
}

if($_POST['formSubmit']=="Elimina")
{
	$sql="DELETE FROM Videolezioni WHERE id=$id";
	database2()->query($sql);
	header('Location: videolezioni-elenco.php');
}
?>
</body>
</html>