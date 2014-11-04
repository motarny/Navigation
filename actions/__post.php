<?php

$navigationOutput = $navigation->render($renderOptions);

$path = '..' . DIRECTORY_SEPARATOR;

include_once $path . 'template.phtml';

$outputNavigation = $navigation->getNavigationArrayAsString();

file_put_contents($path . 'navigationSource.php', '<? return ' . $outputNavigation);