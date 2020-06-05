<! Autore: Matteo Ciaroni>
<html>
<head>
	<title> Login Videolezioni </title>
	<?php
	echo file_get_contents('navbar/head.html');
	?>
	<style>
		table, tr, td
		{
			border: none;
			width: 350px;
		}
	</style>
</head>

<body>
<?php
echo file_get_contents('navbar/navbar-bootstrap.html');
?>
<div class="container">
	<h1> Login </h1>
	<br>
	<h3> Inserisci le tue credenziali </h3>
	<br>
	<form method="post">
		<div class="container" style="max-width: 500px; text-align: left">
			<div class="form-group">
				<label>Email</label>
				<input type="email" class="form-control" name="email" placeholder="Email">
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="password" class="form-control" name="password" placeholder="Password">
			</div>
		</div>
		<br>
		<input class="btn" type="submit" name="formSubmit" value="Login"/><br/>
	</form>
	<br>
	<a class="link" href="password-dimenticata.php">Password dimenticata?</a>
	<?php
	if($_POST['formSubmit']=="Login")
	{
		include_once "util.php";
		$email=$_POST['email'];
		$password=$_POST['password'];
		if(empty($email) || empty($password))
		{
			echo '<p style="color:red">Devi inserire le tue credenziali.</p>';
		}
		else
		{
			$password=md5($password);
			$query="SELECT id
    	FROM Utenti
        WHERE Email='$email' AND Password='$password'
        ORDER BY id ASC";
			$risultato=database2()->query($query);
			$i=0;
			if($risultato->num_rows==1)
			{
				session_start();
				$_SESSION['loggedin']=true;
				$_SESSION['username']=$email;
				header('Location: mng/index.php');
			}
			else
				echo '<p style="color:red">Email o password errate.</p>';
		}
	}
	?>
	<br>
	<br>
</div>
</body>
</html>