<! Autore: Matteo Ciaroni>
<html>
<head>
	<title> Videolezioni </title>
	<script src="Script.js"></script>
	<?php
	echo file_get_contents('navbar/head.html');
	?>
	<style>
		h2
		{
			margin-bottom: 30px;
		}

		.col-sm-2, .col-sm-3, .col-sm-4
		{
			margin-left: 25px;
		}
	</style>
</head>

<body>
<?php
echo file_get_contents('navbar/navbar-bootstrap.html');
?>

<div class="container">
	<h1> Dettaglio </h1>
	<br><br>
	<?php
	session_start();
	if($_SESSION['loggedin']==true)
	{
		include_once "mng/logged.php";
		$id=$_GET['id'];
		echo '<a class="link" href="mng/modifica-videolezione.php?id='.$id.'"> Modifica </a><br><br>';
	}

	$id=$_GET['id'];
	include_once "util.php";
	$oggi=date('d/m/Y');
	$domani=new DateTime('tomorrow');
	$domani=$domani->format('d/m/Y');
	$query="SELECT
    	Classe,
		DATE_FORMAT(Data, '%d/%m/%Y') AS d,
    	TIME_FORMAT(Ora_inizio, '%H:%i') AS oi, 
    	TIME_FORMAT(Ora_fine, '%H:%i') AS of,
        TIME_FORMAT(Ora_fine-Ora_inizio, '%H:%i') as Durata,
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
	?>
	<div class="container" style="text-align: left;">
		<dl class="row">
			<dt class="col-sm-3"></dt>
			<dt class="col-sm-2">Classe</dt>
			<dd class="col-sm-4"> <? echo $row["Classe"]; ?> </dd>
		</dl>
		<dl class="row">
			<dt class="col-sm-3"></dt>
			<dt class="col-sm-2">Data</dt>
			<dd class="col-sm-4">
				<?
				if($row["d"]==$oggi)
					echo $row["d"]."  (Oggi)";
				else if($row["d"]==$domani)
					echo $row["d"]."  (Domani)";
				else
					echo $row["d"];
				?>
			</dd>
		</dl>
		<dl class="row">
			<dt class="col-sm-3"></dt>
			<dt class="col-sm-2">Ora</dt>
			<dd class="col-sm-4"><? echo $row["oi"].' - '.$row["of"]; ?> </dd>
		</dl>
		<dl class="row">
			<dt class="col-sm-3"></dt>
			<dt class="col-sm-2">Durata</dt>
			<dd class="col-sm-4"> <? echo $row["Durata"]; ?></dd>
		</dl>
		<dl class="row">
			<dt class="col-sm-3"></dt>
			<dt class="col-sm-2">Materia</dt>
			<dd class="col-sm-4"> <? echo $row["Materia"]; ?> </dd>
		</dl>
		<dl class="row">
			<dt class="col-sm-3"></dt>
			<dt class="col-sm-2">Prof</dt>
			<dd class="col-sm-4"> <? echo $row["Prof"]; ?> </dd>
		</dl>
		<dl class="row">
			<dt class="col-sm-3"></dt>
			<dt class="col-sm-2">Compiti</dt>
			<dd class="col-sm-4">
				<?
				if($row["Compiti"]==0)
					echo 'No';
				else
					echo 'Sì';

				?>
			</dd>
		</dl>
		<dl class="row">
			<dt class="col-sm-3"></dt>
			<dt class="col-sm-2">Meet</dt>
			<dd class="col-sm-4">
				<?
				if(filter_var($row["Link"], FILTER_VALIDATE_URL) && $row["Codice"]==null)
					echo '<a class="link" target="_blank" href='.$row["Link"].'>Link</a>';
				else if(filter_var($row["Link"], FILTER_VALIDATE_URL) && $row["Codice"]!=null)
					echo '<a class="link" target="_blank" href='.$row["Link"].'>'.$row["Codice"].'</a>';
				else
					echo $row["Codice"];
				?>
			</dd>

		</dl>
		<? if(strlen(trim($row["Annotazioni"]))>0)
			echo '<dl class="row">
			<dt class="col-sm-3"></dt>
			<dt class="col-sm-2">Note</dt>
			<dd class="col-sm-4">'.$row["Annotazioni"].'</dd></dl>';
		?>
	</div>
	<br>
</div>
</body>

</html>
