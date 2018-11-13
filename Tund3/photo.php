<?php
 
  $firstName = "Jaanus";
  $lastName = "Lille";
  //loeme piltide kataloogi sisu
  $dirToRead = "../../pics/";
  $allFiles = scandir($dirToRead);
  $picFiles = array_slice($allFiles, 1);
  //var_dump($picFiles);
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
     õppetöö</title>
</head>
<body>
  <h1>
    <?php
	  echo $firstName ." " .$lastName;
	?>
	, IF18</h1>
  <p>See leht on loodud <a href="https://www.tlu.ee" target="_blank">TLÜ</a>õppetöö raames, ei pruugi parim välja näha ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>
  <p>See rida on loodud koduse töö raames, ei pruugi midagi tähendada või mingit eesmärki teenida ning kindlasti ei ole kõige kujutlusvõimerikkam!</p>
  <p>Tundides tehtu: <a href="photo.php">photo.php</a></p>
  <?php
	//<img src="../../pics/pilt2.jpg" alt="pilt">
	for ($i = 0;$i <count($picFiles); $i ++){
	echo '<img src="' .$dirToRead .$picFiles[2] .'" alt="pilt"><br>' ."\n";
	}
  ?>
</body>
</html>