<?php
	//laen andmebaasi info
	require("../../../config.php");
	//echo $GLOBALS["serverUsername"];
	$database = "if18_jaanus_li_1";
	
	//sisselogimine
	function signup($name, $surname, $email, $gender, $birthDate, $password){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS[
		"serverPassword"], $GLOBALS["database"]);
		//kt. ega kasutajat juba olemas pole
		$stmt = $mysqli->prepare("SELECT id, password FROM vpusers WHERE email=?");
		$mysqli->error;
		$stmt->bind_param("s", $email);
		$stmt->bind_result($idFromDb, $passwordFromDb);
		if($stmt->execute()){
		  //kui õnnestus andmebaasist lugemine
		  if($stmt->fetch()){
		    //leiti selline kasutaja
			if(password_verify($password, $passwordFromDb)){
				//parool õige
				$notice= "logisite õnnelikult sisse!";
				} else {
				$notice = "sisestasite vale salasõna!";
			}
			} else {
			$notice = "sellist kasutajat (" .$email .") ei leitud!";
			}
		} else {
			$notice = "sisselogimisel tekkis tehniline viga!" .$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		return $msgHTML;
	}
	
	
	//kasutaja salvestamine
	function signup($firstName, $lastName, $birthDate, $gender, $email, $password){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS[
		"serverPassword"], $GLOBALS["database"]);
		//kt
		$stmt = $mysqli->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, 
		email, password) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli->error; 
		//valmistame parooli ette salvestamiseks, - krüpteerime, teeme räsi (hash)
		$options = [
		  "cost" => 12, 
		"salt" => substr(sha1(rand()), 0, 22),];
	$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
	$stmt->bind_param("sssiss", $firstName, $lastName, $birthDate, $gender, $email, $pwdhash);
	if($stmt->execute()){
		$notice = "Uue kasutaja lisamine õnnestus!";
	} else {
		$notice = "Kasutaja lisamisel tekkis viga: " .$stmt->error; 
	}
	
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	//anonüümse sõnumi salvestamine
	function saveAMsg($msg){
		$notice = "";
		//serveri ühendus (server, kasutaja, parool, andmebaas
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS[
		"serverPassword"], $GLOBALS["database"]);
		//valmistan ette SQL käsu
		$stmt = $mysqli->prepare("INSERT INTO vpamsg (message) VALUES(?)");
		echo $mysqli->error;
		//asendame SQL käsus küsimärgi päris infoga (andmetüüp, andmed ise
		//s - string; i - integer; d - decimal(murdarv))
		$stmt->bind_param("s", $msg);
		if ($stmt->execute()){
			$notice = 'Sõnum: "' .$msg .'" on salvestatud.';
		}	else {
			$notice = "sõnumi salvestamisel tekkis tõrge: " .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	function listallmessages(){
		 $msgHTML = "";
		 $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS[
		"serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT message FROM vpamsg");
		echo $mysqli->error;
		$stmt->bind_result($msg);
		$stmt->execute();
		while($stmt->fetch()){
			$msgHTML  .= "<p>" .$msg ."</p> \n";
		}
		$stmt->close();
		$mysqli->close();
		return $msgHTML;
	}
	//tekstisisestuse kontroll
 function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
 }
?>