<! Autore: Matteo Ciaroni>
<html>
<head>
	<meta charset="UTF-8">
	<title> Videolezioni </title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../style2.css?1.6">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<style>
		.col-sm-2, .col-sm-3, .col-sm-4
		{
			margin-left: 25px;
		}
	</style>
</head>

<body>
<?php
include "logged.php";
echo file_get_contents('MNGnavbar.html');
?>
<div class="container">
<h2> Utente </h2>
	<br>
	<div class="container" style="text-align: left;">
		<dl class="row">
			<dt class="col-sm-3"></dt>
			<dt class="col-sm-2">Nome</dt>
			<dd class="col-sm-4"> <? echo nome(); ?> </dd>
		</dl>
		<dl class="row">
			<dt class="col-sm-3"></dt>
			<dt class="col-sm-2">Cognome</dt>
			<dd class="col-sm-4"> <? echo cognome(); ?> </dd>
		</dl>
		<dl class="row">
			<dt class="col-sm-3"></dt>
			<dt class="col-sm-2">Email</dt>
			<dd class="col-sm-4"> <? echo email(); ?> </dd>
		</dl>
	</div>
<br>
	<div class="container" style="max-width: 250px">
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">Opzioni</h5>
			<a class="link" href="cambia-password.php">Cambia Password </a>
			<br>
			<a class="link" href="../contatti.php">Hai un problema?</a>
			<br>
			<a class="link" href="mailto:***email admin***">Mandami un'email</a>
		</div>
	</div>
	</div>

<br>
<br>

<br>

</div>
</body>

</html>
