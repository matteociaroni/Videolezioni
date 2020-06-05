<?
include_once "logged.php";
include_once "../util.php";
$query="SELECT COUNT(*) As c
    	FROM Contatti";
$risultato=database2()->query($query);
$row=$risultato->fetch_assoc();
echo $row["c"];
?>