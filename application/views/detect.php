<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Development - Flavio Nunes
*/
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Plataform Detector</title>
</head>
<header>
	<style>
	p, h1, a  {
		color:  #6b6b47;
		font-family: Verdana;
	}
	#footer {
		margin-top: 30px;
		border-radius: 10px;
		border-style: dotted;
		border-color: #6b6b47;
		padding-left: 10px;
		max-width: 550px;
	}

	</style>
</header>
<body>
<center>
<div id="container">
	<h1>Hello!</h1>

	<div id="body">
		<p>You are using: <?= $agent ?></p>
		<p> Plataform Details: <?= $info ?></p>
		<p>Video:</p>
		<iframe width="420" height="315" src="https://www.youtube.com/embed/XGSy3_Czz8k"></iframe>

	</div>

	<div id='footer'>
		<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
	</div>

</div>
</center>
</body>
</html>
