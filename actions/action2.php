<?php

// pre
include '__pre.php';

// action

$newPage = new NavigationPage(
        array(
                'id' => 'firma_siedziba',
                'parentId' => 'firma',
                'label' => 'Prezentacja siedziby',
                'url' => '#'
        ), $navigation);

// post
include '__post.php';