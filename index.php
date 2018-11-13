<?php
  //echo "See on minu esimene PHP!";
  $firstName = "Jaanus";
  $lastName = "Lille";
  $dateToday = date("d.m.Y");
  $hourNow = date("G");
  $partOfDay = "";
  if ($hourNow < 8){
	$partOfDay = "varajane hommik";
  }
  if ($hourNow >= 8 and  $hourNow < 16){
	$partOfDay = "koolipäev";
  }
  if ($hourNow >= 16){
	  $partOfDay = "Ilmselt vaba aeg";
  }
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>
     <?php
	   echo $firstName;
	   echo  " ";
	   echo $lastName;
	 ?>
     </title>
</head>
<body>
  <h1>
    <?php
	  echo $firstName ." " .$lastName;
	?>
	, IF18</h1>
  <p>See leht on loodud <a href="https://www.tlu.ee" target="_blank">TLÜ</a>õppetöö raames, ei pruugi parim välja näha ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>
  <p>See rida on loodud koduse töö raames, ei pruugi midagi tähendada või mingit eesmärki teenida ning kindlasti ei ole kõige kujutlusvõimerikkam!</p>
  <?php
    echo "<p>Tänane kuupäev on: " .$dateToday .".</p>\n";
	echo "<p>Lehe avamise hetkel oli kell " .date("H:i:s") .". Käes oli " 
	.$partOfDay .".</p> \n";
  ?>
  <!--<img src="http://greeny.cs.tlu.ee/~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_1.jpg" alt="TLÜ Terra õppehoone">-->
  
  <img src="../../~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_1.jpg" alt="TLÜ Terra õppehoone">
  <p>Mul on ka sõber, kes teeb oma <a href="../../~marvhel">veebi</a>.</p>
  
</body>
</html>