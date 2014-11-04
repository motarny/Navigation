<?php

/**
 * Klasa sortująca elementy nawigacji.
 * Przyjmuje w konstruktorze obiekt nawigacji i operuje na jego elementach
 *
 * @author Marcin
 * @package Navigation   
 */

define('SORTER_ORDER_ASCENDING', true);
define('SORTER_ORDER_DESCENDING', false);

class NavigationSorter
{

    // TODO Sprawdzenia w metodach, czy wskazywane do przenoszenia podstrony w ogóle istnieją.
    
    protected $_navigation;

    /**
     * Konstruktor
     *
     * @param INavigation $navigation            
     */
    function __construct (INavigation $navigation)
    {
        $this->_navigation = $navigation;
    }

    /**
     * Ustawia wskazaną stronę na pierwszej pozycji (wśród rodzeństwa)
     *
     * @param INavigationPage $page            
     */
    public function makeFirst (INavigationPage $page)
    {
        $navigationPageSiblings = $this->_navigation->getChildren(
                $page->getParentId());
        $lowestSorter = min($this->getSiblingsSorters($navigationPageSiblings));
        $page->setSorter(-- $lowestSorter);
        
        $this->normalizeSorters($navigationPageSiblings);
    }

    /**
     * Ustawia wskazaną stronę na ostatniej pozycji (wśród rodzeństwa)
     *
     * @param INavigationPage $page            
     */
    public function makeLast (INavigationPage $page)
    {
        $navigationPageSiblings = $this->_navigation->getChildren(
                $page->getParentId());
        $lowestSorter = max($this->getSiblingsSorters($navigationPageSiblings));
        
        $page->setSorter(++ $lowestSorter);
        
        $this->normalizeSorters($navigationPageSiblings);
    }

    /**
     * Ustawia wskazaną stronę $movingPage PRZED stroną $refererPage.
     *
     * @param INavigationPage $movigPage
     *            Strona, którą przenosimy
     * @param INavigationPage $refererPage
     *            Strona, względem której przenosimy
     *            
     * @throws Exception Zgłasza wyjątek, jeśli wskazane strony nie mają
     *         wspólnego rodzica.
     */
    public function insertBefore (INavigationPage $movigPage, 
            INavigationPage $refererPage)
    {
        $result = $this->movingTool($movigPage, $refererPage, - 1);
        if (! $result) {
            throw new Exception(
                    'Wskazane NavigationPages muszą należeć do jednego rodzica!');
        }
    }

    /**
     * Ustawia wskazaną stronę $movingPage ZA stroną $refererPage.
     *
     * @param INavigationPage $movigPage
     *            Strona, którą przenosimy
     * @param INavigationPage $refererPage
     *            Strona, względem której przenosimy
     *            
     * @throws Exception Zgłasza wyjątek, jeśli wskazane strony nie mają
     *         wspólnego rodzica.
     */
    public function insertAfter (INavigationPage $movigPage, 
            INavigationPage $refererPage)
    {
        $result = $this->movingTool($movigPage, $refererPage, 1);
        if (! $result) {
            throw new Exception(
                    'Wskazane NavigationPages muszą należeć do jednego rodzica!');
        }
    }

    protected function movingTool (INavigationPage $movigPage, 
            INavigationPage $refererPage, $increment)
    {
        if ($movigPage->getParentId() != $refererPage->getParentId()) {
            return false;
        }
        $refererSorter = $refererPage->getSorter();
        $movigPage->setSorter($refererSorter + $increment);
        $navigationPageSiblings = $this->_navigation->getChildren(
                $movigPage->getParentId());
        $this->normalizeSorters($navigationPageSiblings);
        
        return true;
    }

    /**
     * Sortowanie rodzeństwa alfabetycznie według właściwości Label
     *
     * @param unknown $parentId
     *            Identyfikator elementu nadrzędnego
     * @param boolean $ascending
     *            Opcjonalny - True - rosnąco (default), false - malejąco
     */
    public function sortByLabel ($parentId, $ascending = SORTER_ORDER_ASCENDING)
    {
        $navigationPageSiblings = $this->_navigation->getChildren($parentId);
        
        usort($navigationPageSiblings, 
                function  ($a, $b) use( $ascending)
                {
                    return $ascending ? strnatcasecmp($a->getLabel(), 
                            $b->getLabel()) : strnatcasecmp($b->getLabel(), 
                            $a->getLabel());
                });
        
        $this->normalizeSorters($navigationPageSiblings, false);
    }

    /**
     * Metoda pomocnicza.
     *
     * Pobiera tablicę z wszystkimi sorterami w podanej tablicy stron.
     *
     * @param array $navigationPages            
     * @return array
     */
    protected function getSiblingsSorters ($navigationPages)
    {
        $sorters = array();
        foreach ($navigationPages as $page) {
            $sorters[] = $page->getSorter();
        }
        return $sorters;
    }

    /**
     * Metoda pomocnicza.
     * Normalizuje wartości sorter tak, aby były jako 100..200..300.. itd.
     *
     * @param array $navigationPages            
     * @param boolean $fullNormalization
     *            Opcjonalny, domyślnie true
     */
    protected function normalizeSorters ($navigationPages, 
            $fullNormalization = true)
    {
        if ($fullNormalization) {
            usort($navigationPages, 
                    function  ($a, $b)
                    {
                        return $a->getSorter() > $b->getSorter();
                    });
        }
        
        $sorter = 0;
        foreach ($navigationPages as $page) {
            $page->setSorter($sorter += 100);
        }
    }
}

