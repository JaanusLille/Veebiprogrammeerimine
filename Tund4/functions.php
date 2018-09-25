<?php
	//laen andmebaasi info
	require("../../../vp2018config.php");
	//echo $GLOBALS["serverUsername"];
	$database = "if18_jaanus_li_1";
	
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
		$stmt = $mysqli->prepare("SELECT message FROM vpamsgl");
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