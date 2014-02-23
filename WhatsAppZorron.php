<?php
/**
 * WhatsAppZorron
 *
 * LICENSE: This source file is subject to Creative Commons Attribution
 * 3.0 License that is available through the world-wide-web at the following URI:
 * http://creativecommons.org/licenses/by/3.0/.  Basically you are free to adapt
 * and use this script commercially/non-commercially. My only requirement is that
 * you keep this header as an attribution to my work. Enjoy!
 *
 * @license http://creativecommons.org/licenses/by/3.0/
 *
 * @package WhatsAppZorron
 * @author flolas <flolas@alumnos.uai.cl>
 * @author Felipe Lolas<flolas@alumnos.uai.cl>
 */
	//Root Directory
	define('ROOT_DIR', __DIR__);
	require 'Classes/Autoloader.php';
	//Configuration file
	$config = include_once(ROOT_DIR . '/config.php');
	define('MPASS',$config['managepassword']);
	define('TIMEZONE',$config['timezone']);
	//Autoloader for classes
	spl_autoload_register( 'Autoloader::load' );
	//Instance Zorron
	$zorron = new Library\WhatsApp\bot();
	// Configure zorron
	$zorron->setPhone( $config['phone'] );
	$zorron->setIdentity( $config['identity'] );
	$zorron->setNickname( $config['nickname'] );
	$zorron->setPassword( $config['password'] );
	$zorron->setDebug( $config['debug']);
	$zorron->setProfilePicture( $config['profilepicture']);
	$zorron->setLogFile( $config['log_file'] );
	
	// Add Modules to zorron
	foreach ($config['modules'] as $moduleName => $args) {
		$reflector = new ReflectionClass($moduleName);
	
		$module = $reflector->newInstanceArgs($args);
	
		$zorron->addModule($module);
	}	
	if (function_exists('setproctitle')) {
		$title = basename(__FILE__, '.php') . ' - ' . $config['nickname'];
		setproctitle($title);
	}
	// Connect to WhatsApp
	$zorron->connectToWhatsApp();
?>