<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title><?php echo $pageTitle; ?></title>
	<style>
	  <?php
        echo "body{background-color: " .$_SESSION["bgColor"] ."; \n";
		echo "color: " .$_SESSION["txtColor"] ."} \n";
	  ?>
	</style>
  </head>
  <body>
    
	<div>
	   <a href="main.php">
	     <img src="../vp_pics/vp_logo_w135_h90.png" alt="VP logo">
	   </a>
	   <img src="../vp_pics/vp_banner.png" alt="VP 2018 bänner">
	</div>
	
    <h1><?php echo $pageTitle; ?></h1>