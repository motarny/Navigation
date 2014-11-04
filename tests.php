<?php


define('BR', '<br>');

// resetujemy plik z tablicą nawigacji na startowy
$navBackupSource = file_get_contents('backup_navigationSource.php');
file_put_contents('navigationSource.php', $navBackupSource);

$unlimitedLevels = false;

function __autoload($class_name)
{
    include_once 'lib' . DIRECTORY_SEPARATOR . 'Navigation' . DIRECTORY_SEPARATOR . $class_name . '.php';
}

$navigationItems = array(
        '1' => array('root', 'Strona ident jeden', 'url', 100),
        '2' => array('root', 'Strona ident dwa', 'url', 200),
        '3' => array('root', 'Strona ident trzy', 'url', 300),
        '4' => array('root', 'Strona ident cztery', 'url', 400),
        '5' => array('root', 'Strona ident pięć', 'url', 500),
        '6' => array('root', 'Strona ident sześć', 'url', 600),
);

$navigation = new Navigation($navigationItems, false);

$sorter = new NavigationSorter($navigation);
echo $navigation->render();

$sorter->makeFirst($navigation->getNavigationPage('6'));
echo $navigation->render();

$sorter->makeLast($navigation->getNavigationPage('3'));
echo $navigation->render();

$sorter->makeLast($navigation->getNavigationPage('4'));
echo $navigation->render();

$sorter->makeFirst($navigation->getNavigationPage('4'));
echo $navigation->render();

$sorter->sortByLabel('root');
echo $navigation->render();



echo '<pre>' . $navigation->getNavigationArrayAsString() . '<pre>';



$naviArray = $navigation->getNavigation();

//print_r($naviArray);

$nav2 = new Navigation($naviArray);

$sorter2 = new NavigationSorter($nav2);
$sorter2->sortByLabel('root', SORTER_ORDER_DESCENDING);

echo $nav2->render();



