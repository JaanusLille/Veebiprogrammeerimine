<?php
	class Photoupload
	{
		private $tempName;
		private $imageFileType;
		private $myTempImage;
		private $myImage;
		
		function __construct($name, $type){
			$this->tempName = $name;
			$this->imageFileType = $type;
			$this->createImageFromFile();
		}
		
		function __destruct(){
			imagedestroy($this->myTempImage);
			imagedestroy($this->myImage);
		}
		
		private function createImageFromFile(){
			//sõltuvalt failitüübist, loon sobiva pildiobjekti
			if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
				$this->myTempImage = imagecreatefromjpeg($this->tempName);
			}
			if($this->imageFileType == "png"){
				$this->myTempImage = imagecreatefrompng($this->tempName);
			}
			if($this->imageFileType == "gif"){
				$this->myTempImage = imagecreatefromgif($this->tempName);
			}
		}
		
		public function changePhotoSize($width, $height){
			//pildi originaalsuurus
			$imageWidth = imagesx($this->myTempImage);
			$imageHeight = imagesy($this->myTempImage);
			//Leian suuruse muutmise suhtarvu
			if($imageWidth > $imageHeight){
				$sizeRatio = $imageWidth / $width;
			} else {
				$sizeRatio = $imageHeight / $height;
			}
		
			$newWidth = round($imageWidth / $sizeRatio);
			$newHeight = round($imageHeight / $sizeRatio);
		
			$this->myImage = $this->resizeImage($this->myTempImage, $imageWidth, $imageHeight, $newWidth, $newHeight);
		}
		
		private function resizeImage($image, $ow, $oh, $w, $h){
			$newImage = imagecreatetruecolor($w, $h);
			imagecopyresampled($newImage, $image, 0, 0, 0, 0, $w, $h, $ow, $oh);
			return $newImage;
		}	
		
		public function addWaterMark(){
			$waterMark = imagecreatefrompng(
			"../vp_pics/vp_logo_w100_overlay.png");
			$waterMarkWidth = imagesx($waterMark);
			$waterMarkHeight = imagesy($waterMark);
			$waterMarkPosX = imagesx($this->myImage) - $waterMarkWidth - 10;
			$waterMarkPosY = imagesy($this->myImage) - $waterMarkHeight - 10;
			imagecopy($this->myImage, $waterMark, $waterMarkPosX, $waterMarkPosY, 0, 0, $waterMarkWidth, $waterMarkHeight);
		
		}
		
		public function addTextToImage(){
			$textToImage = "Veebiprogrammeerimine";
			$textColor = imagecolorallocatealpha($this->myImage, 255, 255, 255, 60);
			imagettftext($this->myImage, 20, -45, 10, 30, $textColor, "../vp_pics/ARIALBD.TTF", $textToImage);
		
		}
		
		public function savePhoto($target_file){
			$notice = null;
			//faili salvestamine, jälle sõltuvalt failitüübist
			if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
				if(imagejpeg($this->myImage, $this->target_file, 90)){
					$notice = 1;
					} else {
					$notice = 0;
			}
			}
			if($this->imageFileType == "png"){
			if(imagepng($this->myImage, $target_file, 6)){
			$notice = 1;
			} else {
			$notice = 0;
			
			}
			}
				
			if($imageFileType == "gif"){
			if(imagegif($myImage, $target_file)){
			echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " laeti edukalt üles!";
			addPhotoData($target_file_name, $_POST["altText"], $_POST["privacy"]);
			} else {
			echo "Vabandame, faili üleslaadimisel tekkis tehniline viga!";
			}
			}
		
			
		}
		
		
		
		
	}//class lõpeb
?>