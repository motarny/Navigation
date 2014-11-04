<?php

// pre
include '__pre.php';


// action

$sorter = new NavigationSorter($navigation);

// posortujmy listę pracowników alfabetycznie A-Z (drugi parametr domyślnie = true)
$sorter->sortByLabel('74f0f060914724a');

// to samo zróbmy z archiwami zdjęć, ale malejąco (najświeższe u góry) (drugi parametr = false)
$sorter->sortByLabel('gal_arch', SORTER_ORDER_DESCENDING);

// strone główną przenieśmy na początek
$page = $navigation->getNavigationPage('glowna');
$sorter->makeFirst($page);

// kontakt damy na sam koniec
$page = $navigation->getNavigationPage('kontakt');
$sorter->makeLast($page);


// porządkujemy dział O Firmie

// historia firmy idzie na koniec
$page = $navigation->getNavigationPage('firma_historia');
$sorter->makeFirst($page);

// Nasi pracownicy przesuwamy za Zarząd firmy
$movingPage = $navigation->getNavigationPage('74f0f060914724a');
$refererPage = $navigation->getNavigationPage('firma_zarzad');
$sorter->insertAfter($movingPage, $refererPage); 

// przesuwamy dział Prezentacja siedziby przed Historia firmy (czyli powinno wskoczyć na początek)
$movingPage = $navigation->getNavigationPage('firma_siedziba');
$refererPage = $navigation->getNavigationPage('firma_historia');
$sorter->insertBefore($movingPage, $refererPage);

// post
include '__post.php';