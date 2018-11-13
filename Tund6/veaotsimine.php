<?php
  //laen andmebaasi info
  require("../../../config.php");
  //echo $GLOBALS["serverUsername"];
  $database = "if18_jaanus_li_1";
  
  //võtan kasut. sessiooni
  
  session_start();
  
 //kõigi valideeritud sõnumite valideerimine kasutajate kaupa
 
 function readallvalidatedmessagesbyuser(){
	 $msgthml = "";
	 $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS[
	"database"]);
	$stmt = $mysqli->prepare("SELECT id, firstname, lastname FROM vpusers");
	echo $mysqli->error;
	$stmt->bind_result($idRfomDb, $firstnameFromDb, $LastnameFromDb);
	 
	$stmt2 = $mysqli->prepare("SELECT message, accepted FROM vpamsg WHERE acceptedby=?");
	echo $mysqli->error;
	$stmt2->bind_param("i", $idFromDb);
	$stmt2->bind_result($msgFromDb, $acceptedFromDb);
	
	$stmt->execute();
	//et hoida andmebaasis hoitud andmeid pisut kauem mälus, et saada edasi kasutada
	$stmt->store_result();
	while($stmt->fetch()){
		$msghtml .= "<h3>" .$firstnameFromDb ." " .$lastnameFromDb ."</h3> \n";
		$stmt2->execute();
		while($stmt2->fetch()){
			$msghtml .= "<p><b>";
			if($acceptedFromDb == 1) {
				$msghtml .= "Lubatud: ";
			} else {
			    $msghtml .= "Keelatud: ";
			}	
			$msghtml .= "</b>" .$msgFromDb ."</p> \n";
		}
	} 
	$stmt2->close();
	$stmt->close();
	$mysqli->close();
	return $msghtml;
 }
  
  //sisselogimine
  function signin($email, $password){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS[
	"database"]);
  $stmt = $mysqli->prepare("SELECT id, firstname, lastname, password FROM vpusers WHERE email=?");
  
	echo $mysqli->error;
	$stmt->bind_param("s", $email);
	$stmt->bind_result($idFromDb, $firstNameFromDb, $lastNameFromDb, $passwordFromDb);
	if($stmt->execute()){
	  //kui õnnestus andmebaasist lugenine
	  if($stmt->fetch()){
		//leiti selline kasutaja
	    if(password_verify($password, $passwordFromDb)){
		  //parool õige
		  $notice = "Logisite õnnelikult sisse!";
		  $_SESSION["userId"] = $idFromDb;
		  $_SESSION["firstName"] = $firstNameFromDb;
		  $_SESSION["lastName"] = $lastNameFromDb;
		  $stmt->close();
		  $mysqli->close();
		  header("Location: main.php");
		  exit();
			
		} else {
		  $notice = "Sisestasite vale salasõna!";
        }
	  } else {
		$notice = "Sellist kasutajat (" .$email .") ei leitud!";  
	  }		  
	} else {
	  $notice = "Sisselogimisel tekkis tehniline viga!" .$stmt->error;
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
  
  //kasutaja salvestamine
  function signup($name, $surname, $email, $gender, $birthDate, $password){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	//kontrollime, ega kasutajat juba olemas pole
	$stmt = $mysqli->prepare("SELECT id FROM vpusers1 WHERE email=?");
	echo $mysqli->error;
	$stmt->bind_param("s",$email);
	$stmt->execute();
	if($stmt->fetch()){
		//leiti selline, seega ei saa uut salvestada
		$notice = "Sellise kasutajatunnusega (" .$email .") kasutaja on juba olemas! Uut kasutajat ei salvestatud!";
	} else {
		$stmt->close();
		$stmt = $mysqli->prepare("INSERT INTO vpusers1 (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
    	echo $mysqli->error;
	    $options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
	    $pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
	    $stmt->bind_param("sssiss", $name, $surname, $birthDate, $gender, $email, $pwdhash);
	    if($stmt->execute()){
		  $notice = "ok";
	    } else {
	      $notice = "error" .$stmt->error;	
	    }
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
  //anonüümse sõnumi salvestamine
  function saveamsg($msg){
	$notice = "";
	//serveri ühendus (server, kasutaja, parool, andmebaas
	$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	//valmistan ette SQL käsu
	$stmt = $mysqli->prepare("INSERT INTO vpamsg (message) VALUES(?)");
	echo $mysqli->error;
	//asendame SQL käsus küsimargi päris infoga (andmetüüp, andmed ise)
	//s - string; i - integer; d - decimal
	$stmt->bind_param("s", $msg);
	if ($stmt->execute()){
	  $notice = 'Sõnum: "' .$msg .'" on salvestatud.';
	} else {
	  $notice = "Sõnumi salvestamisel tekkis tõrge: " .$stmt->error;
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
  
  function listallmessages(){
	$msgHTML = "";
    $mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("SELECT message FROM vpamsg");
	echo $mysqli->error;
	$stmt->bind_result($msg);
	$stmt->execute();
	while($stmt->fetch()){
		$msgHTML .= "<p>" .$msg ."</p> \n";
	}
	$stmt->close();
	$mysqli->close();
	return $msgHTML;
  }
  
  //tekstsisestuse kontroll
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>