<?php

	define ( 'BR', '<br>' );

	$maxAction = 7;
	
	$unlimitedLevels = false;
	function __autoload($class_name) {
		include_once '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Navigation' . DIRECTORY_SEPARATOR . $class_name . '.php';
	}
	
	$navigationSourceFile = '..' . DIRECTORY_SEPARATOR . 'navigationSource.php';
	
	$navigation = new Navigation ( include $navigationSourceFile, $unlimitedLevels );
	
	$renderOptions = array (
			'rootContainerCssClass' => 'root',
			'containerCssClass' => 'ulclass' 
	);
	
	
	$actionIndex = (int) substr(basename($_SERVER['PHP_SELF']), 6, 2); 
