<? return // pageId   => parentId, pageLabel, url
array ( 
    'glowna'                  => array( 'root', 'Strona główna', 'url', 100 ), 
    'firma'                   => array( 'root', 'O firmie', '#', 200 ), 
    'firma_historia'          => array( 'firma', 'Historia firmy', '#', 200 ), 
    'firma_zarzad'            => array( 'firma', 'Zarząd firmy', '#', 300 ), 
    'firma_zarzad_spr'        => array( 'firma_zarzad', 'Sprawozdania zarządu', '#', 0 ), 
    'firma_siedziba'          => array( 'firma', 'Prezentacja siedziby', '#', 100 ), 
    'firma_sie_360'           => array( 'firma_siedziba', 'Panoramy 360 stopni', '#', 0 ), 
    '204a2bc53ee4b53'         => array( 'root', 'Galeria foto', '#', 300 ), 
    '74f0f060914724a'         => array( 'firma', 'Nasi pracownicy', '#', 400 ), 
    'gal_arch'                => array( 'firma_historia', 'Archiwum zdjęć', 'url', 0 ), 
    'gal_arch2010'            => array( 'gal_arch', 'Archiwum 2010', 'url', 400 ), 
    'gal_arch2013'            => array( 'gal_arch', 'Archiwum 2013', 'url', 100 ), 
    'gal_arch2011'            => array( 'gal_arch', 'Archiwum 2011', 'url', 300 ), 
    'gal_arch2012'            => array( 'gal_arch', 'Archiwum 2012', 'url', 200 ), 
    'stuff_mkli'              => array( '74f0f060914724a', 'Klimczuk Marcin', 'url', 200 ), 
    'stuff_amar'              => array( '74f0f060914724a', 'Marczak Aleksandra', 'url', 300 ), 
    'stuff_szie'              => array( '74f0f060914724a', 'Ziemkiewicz Stefan', 'url', 400 ), 
    'stuff_aada'              => array( '74f0f060914724a', 'Adamowicz Adrian', 'url', 100 ), 
    'kontakt'                 => array( 'root', 'Kontakt', 'url', 500 ), 
    'teleadresy'              => array( 'kontakt', 'Dane teleadresowe', 'url', 0 ), 
    'mapa'                    => array( 'kontakt', 'Mapa dojazdu', 'url', 0 ), 
    'formularz'               => array( 'kontakt', 'Formularz kontaktowy', 'url', 0 ), 
    'chat'                    => array( 'kontakt', 'Czat on-line', 'url', 0 ), 
    'sklep'                   => array( 'root', 'Sklep internetowy', 'url', 400 ), 
);