<! Autore: Matteo Ciaroni>
<html>
<head>
	<title> Videolezioni </title>
	<script src="Script.js?2.5.1"></script>
	<?php
	echo file_get_contents('navbar/head.html');
	?>
</head>

<body onload="coloraGiorni(); coloraProf(); select(); dateUguali();">
<?php
echo file_get_contents('navbar/navbar-bootstrap.html');
?>
<div class="container">
	<form method="post">
		<h2> Classe: &nbsp;
			<select class="select1" id="classe" name="classe" onchange="saveSelected()">
				<?php
				include "util.php";
				selectClasse($_GET['classe']);
				?>
			</select>
		</h2>
		<input class="btn" type="submit" name="test" id="test" value="Seleziona"/><br/>
	</form>
	<p> Clicca sulla materia per vederne i dettagli </p>
	<table id="table" align="center" style="font-size: 100%; ">
		<tr class="intestazione">
			<td width="100px"> Data</td>
			<td width="180px"> Ora</td>
			<td width="250px"> Materia</td>
		</tr>

		<?
		$Classe1=$_POST['classe'];
		if(isset($Classe1))
			header('Location: Videolezioni.php?classe='.$Classe1);
		else
		{
			$Classe2=$_GET['classe'];
			lezioni($Classe2);
		}

		function lezioni($Classe) //stampa la tabella con l'elenco delle videolezioni della classe passata come parametro
		{
			$oggi=date('d/m');
			$domani=new DateTime('tomorrow');
			$domani=$domani->format('d/m');
			$query="SELECT
		DATE_FORMAT(Data, '%d/%m') AS d,
    	TIME_FORMAT(Ora_inizio, '%H:%i') AS oi, 
    	TIME_FORMAT(Ora_fine, '%H:%i') AS of, 
    	Materia,
        id,
        Link
    	FROM Videolezioni
        WHERE (Data > CURDATE() OR (Data = CURDATE() AND Ora_fine>CURTIME())) AND Data < CURDATE()+INTERVAL 7 DAY
        
        AND Classe='$Classe'
        ORDER BY Data ASC, Ora_inizio ASC";

			$risultato=database2()->query($query);
			$lastDate=null;
			while($row=$risultato->fetch_assoc())
			{
				if($row["d"]!=$lastDate)
				{
					echo '<tr class="spessa"><td>';
				}
				else
				{
					echo '<tr><td>';
				}
				$lastDate=$row["d"];
				if($row["d"]==$oggi)
					if($row["oi"]<date("H:i") && $row["of"]>date("H:i"))
					{
						echo "In corso";
						$materia=$row["Materia"];
						$link=$row["Link"];
					}
					else
					{
						echo "Oggi";
					}
				else if($row["d"]==$domani)
					echo "Domani";
				else
					echo $row["d"];

				echo '</td><td class="ora">';
				echo $row["oi"];
				echo ' - ';
				echo $row["of"];
				echo '</td><td>';
				echo '<a class="wh" href=dettagli-videolezione.php?id='.$row["id"].'>'.$row["Materia"].'</a>';
				echo '</td></tr>'."\r\n";
			}
			if(isset($materia) && filter_var($link, FILTER_VALIDATE_URL)) //se una materia ha una videolezione in corso, viene visualizzato un "alert" custom
			{
				echo '<script>messaggio("'.$materia.'","'.$link.'");</script>';
			}
		}
		?>
	</table>
	<br>
</div>
</body>
</html>
