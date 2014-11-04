<?php

/**
 * 
 * @author Marcin
 * @package Navigation
 *
 */
interface INavigation
{

    public function importArray($navigationSourceArray);
    
    public function render ($options);

    public function getNavigation ();
}

?>