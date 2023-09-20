<?php
	if(!empty($_SERVER['HTTPS'])) {
	    define('HTTP', 'https://');
	}
	else {
	    define('HTTP', 'http://');
	}
	if($_SERVER['SERVER_NAME'] == 'localhost') {
		define('PATH', '/buluza/');
		define('HOST', 'localhost');
		$dominio_website = 'http://localhost'.PATH;
	}
	else {
		define('PATH', '/');
		define('HOST', 'localhost');
		$dominio_website = HTTP.$_SERVER['HTTP_HOST'].''.PATH;
	}
	define('ROOT', $_SERVER['DOCUMENT_ROOT'].PATH);
?>