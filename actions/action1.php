<?php

// pre
include '__pre.php';

// action

$newPage = new NavigationPage(
        array(
                'id' => 'firma',
                'parentId' => 'root',
                'label' => 'O firmie',
                'url' => '#'
        ));
$navigation->addNavigationPage($newPage);

$newPage2 = new NavigationPage(
        array(
                'id' => 'firma_historia',
                'parentId' => 'firma',
                'label' => 'Historia firmy',
                'url' => '#'
        ));
$navigation->addNavigationPage($newPage2);

$newPage3 = new NavigationPage(
        array(
                'id' => 'firma_zarzad',
                'parentId' => 'firma',
                'label' => 'Zarząd firmy',
                'url' => '#'
        ));
$navigation->addNavigationPage($newPage3);

$newPage4 = new NavigationPage(
        array(
                'id' => 'firma_zarzad_spr',
                'parentId' => 'firma_zarzad',
                'label' => 'Sprawozdania zarządu',
                'url' => '#'
        ));
$navigation->addNavigationPage($newPage4);

// post
include '__post.php';