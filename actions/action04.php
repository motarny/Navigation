<?php

// pre
include '__pre.php';


// action

	$newPage = new NavigationPage( array (
		'parentId'  => 'firma_siedziba',
		'label'     => 'Galeria foto',
		'url'       => '#'
		) );
		
	$newNavigationPage = $newPage->addToNavigation($navigation);

	
	$newPage2 = new NavigationPage( array (
		'parentId'  => $newNavigationPage->getId(),
		'label'     => 'Nasi pracownicy',
		'url'       => '#'
		) );
		
	$newNavigationPage2 = $navigation->addNavigationPage($newPage2); 



// post
include '__post.php';