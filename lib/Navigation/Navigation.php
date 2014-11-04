<?php

/**
 * Klasa obsługująca drzewo nawigacji.
 * 
 * @author Marcin
 * @package Navigation
 *
 */
class Navigation implements INavigation
{

    const MAX_LEVEL = 4;

    const EXCEPTION_MAX_LEVEL = "Przekroczono najwyższy poziom zagnieżdżenia";

    const P_PARENT_ID = 0;

    const P_LABEL = 1;

    const P_URL = 2;

    const P_SORT = 3;

    const PARENT_ROOT_NAME = 'root';

    protected $_navigationPagesArray;

    protected $_unlimitedLevels = false;

    /**
     * Do konstruktora przekazywana jest tablica zawierająca elementy nawigacji.
     * Na podstawie przekazanej tablicy, generowana jest wewnętrzna tablica
     * zawierająca obiekty NavigationPage.
     *
     * @param array $navigationSourceArray
     *            Tablica z elementami nawigacji
     * @param boolean $unlimitedLevels
     *            Opcjonalny, domyślnie false. Jeśli true, ignoruje ograniczenie
     *            maksymalnego poziomu zagnieżdżenia.
     */
    function __construct ($navigationSourceArray, $unlimitedLevels = false)
    {
        $this->setUnlimitedLevels($unlimitedLevels);
        
        foreach ($navigationSourceArray as $pageId => $pageData) {
            $navigationPage = new NavigationPage(
                    array(
                            'id' => $pageId,
                            'parentId' => $pageData[self::P_PARENT_ID],
                            'label' => $pageData[self::P_LABEL],
                            'url' => $pageData[self::P_URL],
                            'sorter' => (int) @ $pageData[self::P_SORT]
                    ), $this);
            
            try {
                $this->addNavigationPage($navigationPage);
            } catch (Exception $e) {
                echo $e->getMessage() . BR;
            }
        }
    }

    /**
     * Dodaje do nawigacji nową stronę.
     *
     * @param INavigationPage $newPage            
     * @throws Exception Rzuca wyjątek, jeśli przy dodawaniu przekroczono
     *         maksymalny poziom zagnieżdżenia.
     * @return INavigationPage Zwraca dodaną stronę
     */
    public function addNavigationPage (INavigationPage $newPage)
    {
        $backupNavigation = $this->_navigationPagesArray;
        
        $addingPageId = $newPage->getId();
        if (! empty($addingPageId)) {
            $this->_navigationPagesArray[$newPage->getId()] = $newPage;
        } else {
            // stwórz z kreacją nowego Id
            $createUniqId = substr(md5(serialize($newPage)), 0, 15);
            $newPage->setId($createUniqId);
            $this->_navigationPagesArray[$createUniqId] = $newPage;
            $newPageObject = end($this->_navigationPagesArray);
        }
        
        if (! $this->_unlimitedLevels) {
            if (! $this->checkNavigationInMaxLevelRange()) {
                $this->_navigationPagesArray = $backupNavigation;
                throw new Exception(
                        self::EXCEPTION_MAX_LEVEL . ' ' . $newPage->getId());
            }
        }
        
        return end($this->_navigationPagesArray);
    }

    /**
     * Zwraca tablicę z obiektami INavigationPages
     *
     * @return array
     */
    public function getNavigationPagesArray ()
    {
        return $this->_navigationPagesArray;
    }

    /**
     * Generuje jako string tablicę z nawigacją w formacie akceptowanym przez
     * konstruktor.
     * Można użyć np. do zapisu do pliku.
     *
     * @return string
     */
    public function getNavigationArrayAsString ()
    {
        $output = '// pageId   => parentId, pageLabel, url' . PHP_EOL;
        $output .= 'array ( ' . PHP_EOL;
        
        // TODO zrobić jakieś sortowanie, żeby tablica wynikowa była bardziej
        // uporządkowana
        // propozycja: najpierw sort by root + sorter, potem sort by dalsze
        // parentid + sorter
        
        foreach ($this->_navigationPagesArray as $page) {
            // TODO do przetestowania czy klucze integer zapisuje bez ''
            if (gettype($page->getId()) == "integer") {
                $pageIdFormatted = $page->getId();
            } else {
                $pageIdFormatted = str_pad('\'' . $page->getId() . '\'', 25, 
                        ' ');
            }
            
            $pageIdFormatted = str_pad('\'' . $page->getId() . '\'', 25, ' ');
            $output .= '    ' . $pageIdFormatted . ' => array( \'' .
                     $page->getParentId() . '\', \'' . $page->getLabel() .
                     '\', \'' . $page->getUrl() . '\', ' . $page->getSorter() .
                     ' ), ' . PHP_EOL;
        }
        $output .= ');';
        
        return $output;
    }

    /**
     * Zwraca nawigację w formie tablicy akceptowanej przez konstruktor.
     *
     * @return array
     */
    public function getNavigation ()
    {
        $navigationArray = array();
        foreach ($this->_navigationPagesArray as $page) {
            $navigationArray[$page->getId()] = $page->toNavigationArrayFormat();
        }
        return $navigationArray;
    }

    /**
     * Wykonuje przeniesienie danej strony do innego rodzica.
     *
     * @param unknown $pageId
     *            Identyfikator przenoszonej strony.
     * @param unknown $newParentPageId
     *            Identyfikator nowego rodzica.
     * @throws Exception Rzuca wyjątek, jeśli przy przenoszeniu przekroczono
     *         maksymalny poziom zagnieżdżenia.
     */
    public function moveNavigationPage ($pageId, $newParentPageId)
    {
        $backupNavigation = $this->_navigationPagesArray;
        
        $navigationPage = $this->getNavigationPage($pageId);
        
        // zabezpiecza przed zapętleniem delegacji z NavigationPage::setParent()
        if ($navigationPage->getParentId() != $newParentPageId) {
            $navigationPage->setParentId($newParentPageId);
        }
        
        if (! $this->_unlimitedLevels) {
            if (! $this->checkNavigationInMaxLevelRange()) {
                $this->_navigationPagesArray = $backupNavigation;
                throw new Exception(self::EXCEPTION_MAX_LEVEL);
            }
        }
    }

    /**
     * Zwraca obiekt INavigationPage strony o podanym id.
     *
     * @param unknown $pageId            
     */
    public function getNavigationPage ($pageId)
    {
        return $this->_navigationPagesArray[$pageId];
    }

    /**
     * Sprawdza czy istnieje rodzic o wskazanym id.
     *
     * @param unknown $parentId            
     * @return boolean
     */
    public function isParentIdValid ($parentId)
    {
        if ($parentId == self::PARENT_ROOT_NAME)
            return true;
        return array_key_exists($parentId, $this->_navigationPagesArray);
    }

    /**
     * Usuwa wskazaną stronę z nawigacji wraz z wszystkimi potomkami.
     *
     * @param unknown $pageId
     *            identyfikator strony nawigacji do usunięcia
     */
    public function deleteNavigationPage ($pageId)
    {
        $children = $this->getChildren($pageId);
        foreach ($children as $navigationPage) {
            $this->deleteNavigationPage($navigationPage->getId());
        }
        
        unset($this->_navigationPagesArray[$pageId]);
    }

    /**
     * Zwraca wyrenderowaną nawigację.
     * Korzysta z zewnętrznego renderera (defaultowo "NavigationRenderer").
     *
     * @param array $options            
     * @return string
     */
    public function render ($options = array())
    {
        if (empty($options['rendererClass']))
            $rendererClass = "NavigationRenderer";
        
        if (! class_exists($rendererClass)) {
            throw new Exception('Nie znaleziono renderera ' . $rendererClass);
        }
        
        $renderer = new $rendererClass($options);
        return $renderer->render($this);
    }

    /**
     * Zwraca tablicę elementów INavigationPage, które są dziećmi wskazanego
     * przez id rodzica.
     * Wyniki są na wyjściu sortowane według parametru sorter.
     *
     * @param unknown $parentId            
     * @return array
     */
    public function getChildren ($parentId)
    {
        $childrenArray = array();
        foreach ($this->_navigationPagesArray as $navigationPage) {
            if ($navigationPage->getParentId() === $parentId) {
                $childrenArray[$navigationPage->getId()] = $navigationPage;
            }
        }
        
        usort($childrenArray, 
                function  ($a, $b)
                {
                    return $a->getSorter() > $b->getSorter();
                });
        
        return $childrenArray;
    }

    /**
     * Włącza lub wyłącza sprawdzanie limitu maksymalnego zagnieżdżenia.
     *
     * @param unknown $onoff
     *            true - włącza, false - wyłącza
     */
    public function setUnlimitedLevels ($onoff)
    {
        $this->_unlimitedLevels = (bool) $onoff;
    }

    /**
     * Sprawdza, czy poziom zagnieżdżenia nawigacji mieści się w limicie.
     *
     * @return boolean
     */
    public function checkNavigationInMaxLevelRange ()
    {
        return $this->getNavigationMaxLevel() <= self::MAX_LEVEL ? true : false;
    }

    /**
     * Zwraca maksymalny poziom zagnieżdżenia nawigacji.
     *
     * @return int
     */
    public function getNavigationMaxLevel ()
    {
        $levels = array();
        foreach ($this->_navigationPagesArray as $page) {
            $pageLevel = $this->getNavigationPageLevel($page);
            $levels[] = $pageLevel;
        }
        
        return max($levels);
    }

    /**
     * Zwraca poziom zagnieżdżenia wskazanej strony względem poziomu
     * podstawowego (root).
     *
     * @param INavigationPage $page            
     * @return number
     */
    public function getNavigationPageLevel (INavigationPage $page)
    {
        $level = 0;
        while ($page->getParentId() != self::PARENT_ROOT_NAME) {
            $level ++;
            $page = $this->getNavigationPage($page->getParentId());
        }
        
        return $level;
    }
}

?>