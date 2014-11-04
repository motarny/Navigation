<?php

/**
 * Klasa generująca elementy nawigacji
 * 
 * @author Marcin
 * @package Navigation
 *
 */

class NavigationPage implements INavigationPage
{

    protected $_id;

    protected $_parentId;

    protected $_label;

    protected $_url;

    protected $_navigation;

    /**
     * Konstruktor tworzy obiekt NavigationPage.
     *
     * @param array $pageData
     *            Tablica zawierająca właściwości tworzonego obiektu
     * @param INavigation $navigationObject
     *            Opcjonalnie można wskazać obiekt INavigation, do którego dana
     *            strona zostanie przypisana.
     */
    function __construct (array $pageData, INavigation $navigationObject = null)
    {
        $this->setId(@$pageData['id'])
            ->setParentId($pageData['parentId'])
            ->setLabel($pageData['label'])
            ->setUrl($pageData['url'])
            ->setSorter(@$pageData['sorter']);
        
        if (! empty($navigationObject)) {
            $this->_navigation = $navigationObject;
            $this->addToNavigation($this->_navigation);
        }
    }

    /**
     * Utworzony obiekt NavigationPage możemy dodać do jakiejś nawigacji.
     *
     * @param INavigation $navigation
     *            Obiekt nawigacji, do której chcemy przypisać stronę.
     * @see INavigation::addNavigationPage()
     */
    public function addToNavigation (INavigation $navigation)
    {
        return $navigation->addNavigationPage($this);
    }

    public function getId ()
    {
        return $this->_id;
    }

    public function getParentId ()
    {
        return $this->_parentId;
    }

    public function getLabel ()
    {
        return $this->_label;
    }

    public function getUrl ()
    {
        return $this->_url;
    }

    public function getSorter ()
    {
        return $this->_sorter;
    }

    public function setId ($val)
    {
        $this->_id = $val;
        return $this;
    }

    /**
     * Przypisanie rodzica danej stronie.
     * Jeśli strona ma przypisaną nawigację, to wykonuje odpowiednią metodę
     * klasy Navigation
     *
     * @see INavigation::setParentId()
     */
    public function setParentId ($val)
    {
        if (isset($this->_navigation)) {
            if (! $this->_navigation->isParentIdValid($val)) {
                throw new Exception(
                        'Próba przypisania do nieistniejącego rodzica!');
            }
            
            $this->_parentId = $val;
            $this->_navigation->moveNavigationPage($this->getId(), $val);
        }
        
        $this->_parentId = $val;
        
        return $this;
    }

    public function setLabel ($val)
    {
        $this->_label = $val;
        return $this;
    }

    public function setUrl ($val)
    {
        $this->_url = $val;
        return $this;
    }

    public function setSorter ($val = 0)
    {
        $this->_sorter = $val;
        return $this;
    }

    public function toNavigationArrayFormat ()
    {
        return array(
                $this->getParentId(),
                $this->getLabel(),
                $this->getUrl(),
                $this->getSorter()
        );
    }
}
