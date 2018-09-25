<?php
     //kutsume välja funktsioonide faili
     require("functions.php");
	 
	 $notice = listallmessages();

?>
  
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Anonüümsete sõnumite lugemine</title>
</head>
<body>
  <h1>Sõnumid</h1>
  <p>See leht on loodud <a href="https://www.tlu.ee" target="_blank">TLÜ</a>õppetöö raames, ei pruugi parim välja näha ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>
  <p>See rida on loodud koduse töö raames, ei pruugi midagi tähendada või mingit eesmärki teenida ning kindlasti ei ole kõige kujutlusvõimerikkam!</p> 
  <hr>
	<?php
	   echo $notice;
	?>
 
 
</body>
</html>