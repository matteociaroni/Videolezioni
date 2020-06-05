<! Autore: Matteo Ciaroni>
<html>
<head>
	<title> Videolezioni data </title>
	<script src="Script.js?2.4"></script>
	<?php
	echo file_get_contents('navbar/head.html');
	?>
	<script>
		function setDate() //imposta la data dal localstorage
		{
			if(typeof (Storage) !== "undefined")
			{
				if(sessionStorage.getItem("data") != null)
					document.getElementById('data').value = sessionStorage.getItem("data");
				else
					setTodayDate();
			}
		}

		function saveDate() //salva la data selezionata nel localstorage
		{
			if(typeof (Storage) !== "undefined")
			{
				sessionStorage.setItem("data", document.getElementById("data").value);
			}
		}

		function setTodayDate() //imposta la data di oggi
		{
			var d = new Date()
			var y = d.getFullYear();
			var m = d.getMonth() + 1;
			var day = d.getDate();
			if(m < 10)
				m = "0" + m;
			if(day < 10)
				day = "0" + day;
			console.log(y + m + day);
			document.getElementById('data').value = y + "-" + m + "-" + day;
		}

	</script>
</head>

<body onload="coloraGiorni(); coloraProf(); select(); <?php echo (!isset($_GET['data'])) ? "setDate();" : "saveDate()"; ?>">
<?php
echo file_get_contents('navbar/navbar-bootstrap.html');
?>
<div class="container">
<form method="post">
	<h2> Classe: &nbsp;
		<select class="select1" id="classe" name="classe" onchange="saveSelected()">
			<?php
			include_once "util.php";
			selectClasse(null);
			?>
		</select>
	</h2>

	<h2> Giorno: &nbsp;
		<input class="selectData" onchange="saveDate()"
			   value="<?php echo (isset($_GET['data'])) ? $_GET['data'] : ''; ?>" id="data" type="date" name="data">
	</h2>

	<input class="btn" type="submit" name="test" id="test" value="Seleziona"/><br/>
</form>
<p> Clicca sulla materia per vederne i dettagli </p>
<table id="table" align="center" style="font-size: 100%; ">
	<tr class="intestazione">
		<td width="160px"> Ora</td>
		<td width="250px"> Materia</td>

		<?
		$Classe1=$_POST['classe'];
		$Data1=$_POST['data'];
		if(isset($Classe1) && isset($Data1))
			header('Location: VideolezioniData.php?classe='.$Classe1.'&data='.$Data1);
		else
		{
			$Classe2=$_GET['classe'];
			$Data2=$_GET['data'];
			lezioni($Classe2, $Data2);
		}

		function lezioni($Classe, $Data)
		{
			$oggi=new DateTime('today');
			$oggi->modify("+ 7 days");
			if($Data>$oggi->format("Y-m-d"))
			{
				echo "<tr> <td colspan='2'> Data troppo lontana </td></tr>";
				return;
			}
			include_once "util.php";
			$query="SELECT
		DATE_FORMAT(Data, '%d/%m') AS d,
    	TIME_FORMAT(Ora_inizio, '%H:%i') AS oi, 
    	TIME_FORMAT(Ora_fine, '%H:%i') AS of, 
    	Materia,
        id,
        TIME_FORMAT(Ora_fine-Ora_inizio, '%H:%i') as Durata
    	FROM Videolezioni 
        WHERE Data ='$Data'
        AND Classe='$Classe'
        ORDER BY Data ASC, Ora_inizio ASC";

			$risultato=database2()->query($query);
			$oreGiorno=0;
			while($row=$risultato->fetch_assoc())
			{
				echo '<tr><td>';
				echo $row["oi"];
				echo ' - ';
				echo $row["of"];
				echo '</td><td>';
				echo '<a class="wh" href=dettagli-videolezione.php?id='.$row["id"].'>'.$row["Materia"].'</a>';
				echo '</td></tr>';
				$oreGiorno+=$row["Durata"];
			}
			echo '<tr><td><p class="intestazione"> Ore totali: </p></td><td>'.$oreGiorno.'</td></tr>';
		}

		?>
</table>
<br>
</div>
</body>

</html>
