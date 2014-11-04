<?php

// pre
include '__pre.php';

// action

$newPage = new NavigationPage(
        array(
                'id' => 'firma_sie_360',
                'parentId' => 'firma_siedziba',
                'label' => 'Panoramy 360 stopni',
                'url' => '#'
        ));

$newPage->addToNavigation($navigation);

// post
include '__post.php';