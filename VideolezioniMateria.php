<! Autore: Matteo Ciaroni>
<html>
<head>
	<meta charset="UTF-8">
	<title> Videolezioni materia </title>
	<script src="Script.js?2.2"></script>
	<?php
	echo file_get_contents('navbar/head.html');
	?>
	<script>
		function setMateria()
		{
			if(typeof (Storage) !== "undefined")
			{
				document.getElementById('materia').value = sessionStorage.getItem("materia");
			}
		}

		function saveMateria()
		{
			if(typeof (Storage) !== "undefined")
			{
				sessionStorage.setItem("materia", document.getElementById("materia").value);
			}
		}
	</script>
</head>

<body onload="coloraProf(); select(); setMateria()">
<?php
echo file_get_contents('navbar/navbar-bootstrap.html');
?>
<div class="container">
<form method="post">
	<h2> Classe: &nbsp;
		<select class="select1" id="classe" name="classe" onchange="saveSelected();">
			<?php
			include_once "util.php";
			selectClasse(null);
			?>
		</select>
	</h2>

	<h2> Materia: &nbsp;
		<select class="selectData" onchange="saveMateria()" id="materia" type="text" name="materia">

			<?
			selectMateria();
			?>
		</select>
	</h2>

	<input class="btn" type="submit" name="test" id="test" value="Seleziona"/><br/>
</form>
<p> Sono visualizzate tutte le lezioni dal 01/04 <br> Clicca sul prof per vederne i dettagli </p>
<table id="table" align="center" style="font-size: 100%; ">
	<tr class="intestazione">
		<td width="100px"> Data</td>
		<td width="160px"> Ora</td>
		<td width="250px"> Prof</td>

		<?
		$Classe1=$_POST['classe'];
		$Materia1=$_POST['materia'];
		if(isset($Classe1) && isset($Materia1))
			header('Location: VideolezioniMateria.php?classe='.$Classe1.'&materia='.$Materia1);
		else
		{
			$Classe2=$_GET['classe'];
			$Materia2=$_GET['materia'];
			lezioni($Classe2, $Materia2);
		}

		function lezioni($Classe, $Materia)
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
        TIME_FORMAT(Ora_fine-Ora_inizio, '%H:%i') as Durata,
        Prof
    	FROM Videolezioni 
        WHERE Materia='$Materia'
        AND Classe='$Classe'
        AND Data <= CURRENT_DATE 
        ORDER BY Data DESC, Ora_inizio DESC";

			$risultato=database2()->query($query);
			$oreMateria=0;
			while($row=$risultato->fetch_assoc())
			{
				echo '<tr><td>';
				if($row["d"]==$oggi)
					if($row["oi"]<date("H:i") && $row["of"]>date("H:i"))
						echo "In corso";
					else
						echo "Oggi";
				else if($row["d"]==$domani)
					echo "Domani";
				else
					echo $row["d"];
				echo '</td><td class="ora">';
				echo $row["oi"];
				echo ' - ';
				echo $row["of"];
				echo '</td><td>';
				echo '<a href=dettagli-videolezione.php?id='.$row["id"].'>'.$row["Prof"].'</a>';
				echo '</td></tr>';
				$oreMateria+=$row["Durata"];
			}
			echo '<tr><td colspan="2"><p class="intestazione"> Ore totali: </p></td><td>'.$oreMateria.'</td></tr>';
		}

		?>
</table>
<br>
</div>
</body>

</html>
