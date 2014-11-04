<?php

// pre
include '__pre.php';


// action

// przenosimy cały dział Nasi pracownicy z Galerii foto do działu wyżej - O Firmie
$navigation->moveNavigationPage('74f0f060914724a', 'firma');

//  przenosimy cały dział Archiwum zdjęć do działu Historia firmy
$page = $navigation->getNavigationPage('gal_arch');
$page->setParentId('firma_historia');

// dział Galeria foto przenosimy do roota
$navigation->moveNavigationPage('204a2bc53ee4b53', 'root');


// post
include '__post.php';