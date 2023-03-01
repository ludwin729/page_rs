<?php

// Si la constante INIT_CONFIG esta definida, no se definen las demas CONSTANTES
if( !defined( "INIT_CONFIG" ) ){

	define('INIT_CONFIG', 1);

	define('DS', DIRECTORY_SEPARATOR);
	define('DOC_ROOT', __DIR__);


	//Admin JS - CSS
	define("ROOT_ADM_JS","assets/admin/js");
	define("ROOT_ADM_CSS","assets/admin/css");

	//Plugins
	define("ROOT_PLUG","assets/global/plugins/bower_components");

}