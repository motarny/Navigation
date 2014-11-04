<?php

/**
 * 
 * @author Marcin
 * @package Navigation
 */
interface INavigationPage
{

    public function __construct (array $pageData, 
            INavigation $navigationObject = null);

    public function addToNavigation (INavigation $navigation);

    public function getId ();

    public function getParentId ();

    public function getLabel ();

    public function getUrl ();

    public function getSorter ();

    public function setId ($val);

    public function setParentId ($val);

    public function setLabel ($val);

    public function setUrl ($val);

    public function setSorter ($val);
}
