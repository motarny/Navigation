<?php

// pre
include '__pre.php';


// action

$add2navigation = array (
        'gal_arch'                  => array( '204a2bc53ee4b53', 'Archiwum zdjęć', 'url'),
        'gal_arch2010'              => array( 'gal_arch', 'Archiwum 2010', 'url'),
        'gal_arch2013'              => array( 'gal_arch', 'Archiwum 2013', 'url'),
        'gal_arch2011'              => array( 'gal_arch', 'Archiwum 2011', 'url'),
        'gal_arch2012'              => array( 'gal_arch', 'Archiwum 2012', 'url'),

        
        'stuff_mkli'                => array( '74f0f060914724a', 'Klimczuk Marcin', 'url'),
        'stuff_amar'                => array( '74f0f060914724a', 'Marczak Aleksandra', 'url'),
        'stuff_szie'                => array( '74f0f060914724a', 'Ziemkiewicz Stefan', 'url'),
        'stuff_aada'                => array( '74f0f060914724a', 'Adamowicz Adrian', 'url'),
        
        'kontakt'                   => array( 'root', 'Kontakt', 'url'),
        'teleadresy'                => array( 'kontakt', 'Dane teleadresowe', 'url'),
        'mapa'                      => array( 'kontakt', 'Mapa dojazdu', 'url'),
        'formularz'                 => array( 'kontakt', 'Formularz kontaktowy', 'url'),
        'chat'                      => array( 'kontakt', 'Czat on-line', 'url'),
        
        'sklep'                     => array( 'root', 'Sklep internetowy', 'url'),
);

$navigation->importArray($add2navigation);


// post
include '__post.php';