<! Autore: Matteo Ciaroni>
<html>
<head>
	<title> Videolezioni - Contatti </title>
	<?php
	echo file_get_contents('navbar/head.html');
	?>
</head>
<body>
<?php
echo file_get_contents('navbar/navbar-bootstrap.html');
?>
<div class="container">
<h1> Contatti </h1>
<br>
<h3> Contattami per problemi o suggerimenti </h3>
<br>
<div class="container" style="text-align: left">
	<form method="post">
		<div class="row">
			<div class="col-sm">
				<div class="form-group">
					<label for="exampleFormControlInput1">Nome e Cognome</label>
					<input type="text" class="form-control" name="nome" placeholder="Nome Cognome">
				</div>
			</div>
			<div class="col-sm">
				<div class="form-group">
					<label for="exampleFormControlInput1">Email</label>
					<input type="email" class="form-control" name="email"
						   placeholder="email@example.com">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="exampleFormControlTextarea1">Messaggio</label>
			<textarea class="form-control" name="messaggio" rows="3" style="height: 200px"></textarea>
		</div>
		<br>
</div>
		<input class="btn" type="submit" name="formSubmit" value="Invia"/><br/>
	</form>
</div>
<?php
if($_POST['formSubmit']=="Invia")
{
	$nome=$_POST['nome'];
	$email=$_POST['email'];
	$messaggio=$_POST['messaggio'];
	if(!strlen(trim($messaggio)))
	{
		echo '<p style="color:red">Inserisci almeno il messaggio</p>';
	}
	else
	{
		include_once "util.php";
		$query="INSERT INTO Contatti (id, Nome, Email, Messaggio) VALUES (NULL, '$nome', '$email', '$messaggio')";
		database2()->query($query);
		$message="$nome <$email> ti ha scritto un nuovo messaggio: $messaggio. acquamarinapesaro.altervista.org/Vari/4C/mng/messaggi.php?";
		mail('***email admin***', 'Nuovo messaggio nelle videolezioni', $message);
		echo 'Grazie per il messaggio';
		header('Location: Videolezioni.php');
	}
}
?>
<br>
</body>
</html>