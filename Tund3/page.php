<?php
  //kutsume välja funktsioonide faili
  require("functions.php");
  
  $firstName = "Kodanik";
  $lastName = "Tundmatu";
  $birthMonth = date("m");
  $monthNamesET = ["jaanuar"];
  //kontrollime kas kasutaja on midagi kirjutanud
  //var_dump($_POST);
  if (isset($_POST["firstName"])){
      //$firstName $_POST);
	  $firstName = test_input($_POST["firstName"]);
  }
  if (isset($_POST["lastName"])){
	  $lastName = test_input($_POST["lastName"]);
  }
  
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  
  //täiesti mõttetu, harjutamiseks mõeldud funktsioon
  function fullname(){
	$GLOBALS["fullName"] = $GLOBALS["firstName"] ." " .$GLOBALS["lastName"];
	  
  }
  $fullname = "";
  fullname();
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
  
  <hr>
  
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label>Eesnimi:</label>
	<input type="text" name="firstName">
	<label>Perekonnanimi:</label>
	<input type="text" name="lastName">
	<label>Sünniaasta:</label>
	<input type="number" min="1914" max="2000" value="1999" name="birthYear">
	<br>
	<input type="submit" name="submitUserData" value="Saada andmed">
  </form>
  <hr>
  <?php
	if (isset($_POST["firstName"])){
		echo "<p>" .$fullName .", olete elanud järgnevatel aastatel: </p> \n";
		echo "</ol> \n";
			for ($i = $_POST["birthYear"]; $i <= date("Y"); $i ++){
				echo "<li>" .$i ."</li> \n";
			}
		echo "</ol> \n";
	}
  ?>

</body>
</html>