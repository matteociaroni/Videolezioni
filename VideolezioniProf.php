<! Autore: Matteo Ciaroni>
<html>
<head>
	<title> Videolezioni docente </title>
	<script src="Script.js?2.2"></script>
	<?php
	echo file_get_contents('navbar/head.html');
	?>
	<style>
		h2
		{
			margin-bottom: 40px;
		}
	</style>
	<script>
		function setProf()
		{
			if(typeof (Storage) !== "undefined")
			{
				document.getElementById('prof').value = localStorage.getItem("prof");
				if(window.location.search == "")
					window.location = "VideolezioniProf.php?prof=" + document.getElementById('prof').value;
			}
		}

		function saveProf(noReload)
		{
			if(typeof (Storage) !== "undefined")
			{
				localStorage.setItem("prof", document.getElementById("prof").value);
				if(noReload!=true)
					window.location = "VideolezioniProf.php?prof=" + document.getElementById('prof').value;
			}
		}

	</script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-162833204-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag()
		{
			dataLayer.push(arguments);
		}

		gtag('js', new Date());

		gtag('config', 'UA-162833204-1');
	</script>
</head>

<body onload="coloraGiorni(); <?php echo (!isset($_GET['prof'])) ? 'setProf();' : 'saveProf(true)'; ?>">
<?php
echo file_get_contents('navbar/navbar-bootstrap.html');
?>
<h2> Prof: &nbsp;
	<select type="text" class="selectData" id="prof" onchange="saveProf()">
		<?php
		include "util.php";
		selectProf($_GET['prof']);
		?>
	</select>
</h2>

<p> Sono visualizzati i prossimi 7 giorni <br> Clicca sulla classe per vederne i dettagli </p>
<table id="table" align="center" style="font-size: 100%; ">
	<tr class="intestazione">
		<td width="100px"> Data</td>
		<td width="160px"> Ora</td>
		<td width="120px"> Classe</td>

		<?
		$Prof2=$_GET['prof'];
		lezioni($Prof2);

		function lezioni($Prof)
		{
			if($Prof==null)
				return;

			$oggi=date('d/m');
			$domani=new DateTime('tomorrow');
			$domani=$domani->format('d/m');
			$query="SELECT
		DATE_FORMAT(Data, '%d/%m') AS d,
    	TIME_FORMAT(Ora_inizio, '%H:%i') AS oi, 
    	TIME_FORMAT(Ora_fine, '%H:%i') AS of, 
    	Classe,
        id
    	FROM Videolezioni 
        WHERE (Data > CURDATE() OR (Data = CURDATE() AND Ora_fine>CURTIME())) AND Data <= CURDATE()+INTERVAL 7 DAY
        AND Prof LIKE '%{$Prof}%'
        ORDER BY Data ASC, Ora_inizio ASC";

			$risultato=database2()->query($query);

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
				echo '</td><td>';
				echo $row["oi"];
				echo ' - ';
				echo $row["of"];
				echo '</td><td>';
				echo '<a href=dettagli-videolezione.php?id='.$row["id"].'>'.$row["Classe"].'</a>';
				echo '</td></tr>'."\r\n";
			}
		}

		?>
</table>
<br>
</body>

</html>
