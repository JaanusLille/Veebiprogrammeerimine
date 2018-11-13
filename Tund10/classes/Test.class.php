<?php
	class Test
	{
			
		// omadused ehk muutujad
		private $secretNumber;
		public $publicNumber;
		
		//eriline funktsioon eht constructor on see, mis käivitatakse kohe, klassi kasutuselevõtmisel ehk objekti loomisel
		function __construct($sentNumber){
			$this->secretNumber = 5;
			$this->publicNumber = $this->secretNumber * $sentNumber;
			$this->tellSecret();
		}
		//eriline funktsioon, mida kasut, kui klass suletakse/objekt eemaldatakse
		
		function __destruct(){
			echo "Lõpetame!"
		}
		
		private function tellSecret(){
			echo "Salajane number on: " $this->secretNumber ."! ";
		}
		
		public function tellInfo(){
			echo "\nSaladust ei paljasta!";
		}
	}//class lõpeb




?>