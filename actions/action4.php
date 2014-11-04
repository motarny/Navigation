<?php

// pre
include '__pre.php';

// action

$newPage = new NavigationPage(
        array(
                'parentId' => 'firma_siedziba',
                'label' => 'Galeria foto',
                'url' => '#'
        ));

$newPage = $newPage->addToNavigation($navigation);

$newPage2 = new NavigationPage(
        array(
                'parentId' => $newPage->getId(),
                'label' => 'Nasi pracownicy',
                'url' => '#'
        ), $navigation);

$navigation->addNavigationPage($newPage2);

// post
include '__post.php';