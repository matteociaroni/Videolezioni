<?php

function database2() //crea la connessione con il database
{
	$username="acquamarinapesaro";
	$password="";
	$host="localhost";
	$database="my_acquamarinapesaro";
	$conn=new mysqli($host, $username, $password, $database);
	if($conn->connect_error)
	{
		die("Connection failed: ".$conn->connect_error);
	}
	return $conn;
}

function selectClasse($selected) //"riempe" la casella combinata delle classi con l'elenco delle classi presenti nella tabella "Classi" del database
{
	$query="SELECT
		Classe
    	FROM Classi
        ORDER BY Classe ASC";
	$risultato=database2()->query($query);
	$i=0;
	while($row=$risultato->fetch_assoc())
	{
		$classi[$i]=$row["Classe"];
		$i++;
	}
	$c=substr($classi[0], 0, 1);
	echo '<optgroup label="Classi '.$c.'">';
	$i=0;
	while($classi[$i]!=null)
	{
		if(substr($classi[$i], 0, 1)!=$c)
		{
			$c=substr($classi[$i], 0, 1);
			echo ' </optgroup>';
			echo '<optgroup label="Classi '.$c.'">';
		}
		if($classi[$i]==$selected)
			echo '<option selected>'.$classi[$i].'</option>';
		else
			echo '<option>'.$classi[$i].'</option>';
		$i++;
	}
	echo '</optgroup>';
}

function selectProf($selectedProf) //"riempe" la casella combinata dei prof con l'elenco dei prof presenti nella tabella "Videolezioni" del database
{
	$query="SELECT DISTINCT
    	SUBSTRING_INDEX(Prof, ',', 1) AS p,
        SUBSTRING_INDEX(Prof, ',', -1) AS q
    	FROM Videolezioni
        ORDER BY Prof ASC";
	$risultato=database2()->query($query);
	$i=0;
	while($row=$risultato->fetch_assoc())
	{
		$prof[$i]=trim($row["p"]);
		$i++;
		$prof[$i]=trim($row["q"]);
		$i++;
	}
	$prof=array_values(array_unique($prof));
	sort($prof);
	$i=0;
	while($prof[$i]!=null)
	{
		if($prof[$i]==$selectedProf)
			echo '<option selected>'.$prof[$i].'</option>';
		else
			echo '<option>'.$prof[$i].'</option>';
		$i++;
	}
}

function selectMateria($classe) //"riempe" la casella combinata delle materie con l'elenco delle materia presenti nella tabella "Videolezioni" del database
{
	if(!isset($classe))
	{
		$query="SELECT DISTINCT
    	Materia
    	FROM Videolezioni
        ORDER BY Materia ASC";
	}
	else
	{
		$query="SELECT DISTINCT
    	Materia
    	FROM Videolezioni
    	WHERE Classe='$classe'
        ORDER BY Materia ASC";
	}
	$risultato=database2()->query($query);
	while($row=$risultato->fetch_assoc())
	{
		echo '<option>'.$row["Materia"].'</option>';
	}
}

function randomString($length=10) //genera una stringa casuale
{
	return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)))), 1, $length);
}

?>
