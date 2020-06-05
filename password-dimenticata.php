<! Autore: Matteo Ciaroni>
<html>
<head>
	<title> Videolezioni - Recupero password</title>
	<?php
	echo file_get_contents('navbar/head.html');
	?>
	<style>
		table, tr, td
		{
			border: none;
			width: 380px;
		}

		input
		{
			font-size: 15px;
			height: 30px;
			width: 200px;
		}
	</style>
</head>

<body>
<?php
echo file_get_contents('navbar/navbar-bootstrap.html');
?>
<div class="container">
	<h2> Recupero Password </h2>
	<br>
	<p> Riceverai un'email con la tua nuova password
		<br> che potrai cambiare successivamente </p>
	<br>
	<form method="post">
		<div class="container" style="max-width: 500px; text-align: left">
			<div class="form-group">
				<input type="email" class="form-control" name="email" placeholder="Email">
			</div>
		</div>
		<br>
		<input class="btn" type="submit" name="formSubmit" value="Richiedi"/><br/>
	</form>
</div>
<?php
if($_POST['formSubmit']=="Richiedi")
{
	include_once "util.php";
	$email=$_POST['email'];
	if(empty($email))
	{
		echo '<p style="color:red">Inserisci indirizzo email.</p>';
	}
	else
	{
		$query="SELECT id
    	FROM Utenti
        WHERE Email='$email'
        ORDER BY id ASC";
		$risultato=database2()->query($query);
		$i=0;
		if($risultato->num_rows==1)
		{
			$nuovapassword=randomString(10);
			$nuovapassword_hashed=md5($nuovapassword);
			$sql="UPDATE Utenti SET Password='$nuovapassword_hashed' WHERE Email='$email'";
			database2()->query($sql);
			$headers='From: Videolezioni'."\r\n".
				'Reply-To: s_crnmtt02a22d488h@itisurbino.it'."\r\n".
				'X-Mailer: PHP/'.phpversion();
			mail($email, 'Videolezioni - Recupero passord', 'La nuova password è: '.$nuovapassword."\r\n".'Poi cambiarla nella pagina "Profilo".', $headers);
			echo "Fatto, controlla la posta (anche nella casella SPAM)";
			echo '<br><br> <a class="link" href="login.php">Login</a>';
		}
		else
			echo '<p style="color:red">Email inesistente.</p>';
	}
}
?>
<br>
</body>
</html>