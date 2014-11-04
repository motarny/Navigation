<?php
define('BR', '<br>');

// resetujemy plik z tablicą nawigacji na startowy
$navBackupSource = file_get_contents('backup_navigationSource.php');
file_put_contents('navigationSource.php', $navBackupSource);

$unlimitedLevels = false;

function __autoload ($class_name)
{
    include_once 'lib' . DIRECTORY_SEPARATOR . 'Navigation' . DIRECTORY_SEPARATOR .
             $class_name . '.php';
}

$navigationSourceFile = "navigationSource.php";
$navigation = new Navigation(include $navigationSourceFile, false);

$renderOptions = array (
        'rootContainerCssClass' => 'root',
        'containerCssClass' => 'ulclass'
);

$navigationOutput = $navigation->render($renderOptions);

$path = '';
$actionIndex = 0;
include_once 'template.phtml';


