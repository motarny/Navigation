<?php

/**
 * Klasa renderująca kod html z dostarczonej nawigacji.
 * 
 * @author Marcin
 * @package Navigation
 *
 */

class NavigationRenderer
{

    protected $_navigationObject;

    protected $_options = array(
            'rootContainerCssClass' => 'navigationRoot',
            'containerCssClass' => 'navigation',
            'htmlContainer' => 'ul',
            'htmlPage' => 'li',
            'htmlAttribIdPrefix' => 'navid_'
    );

    function __construct ($options = array())
    {
        $this->_options = $options + $this->_options;
    }

    public function render (INavigation $navigationObject)
    {
        $this->_navigationObject = $navigationObject;
        
        $startTag = '<' . $this->o('htmlContainer') . ' class="' .
                 $this->o('rootContainerCssClass') . '">';
        $endTag = '</' . $this->o('htmlContainer') . '>';
        
        $renderedNavigationPages = '';
        
        $rootPages = $navigationObject->getChildren('root'); // TODO zamienic
                                                             // root na cos
                                                             // definiowanego
        
        foreach ($rootPages as $navigationPage) {
            $renderedNavigationPages .= $this->renderElement($navigationPage, 0);
        }
        
        return $startTag . $renderedNavigationPages . $endTag;
    }

    private function renderContainerContent ($navigationPages, $level)
    {
        $levelClass = 'level_' . $level;
        
        $startTag = '<' . $this->o('htmlContainer') . ' class="' .
                 $this->_options['containerCssClass'] . ' ' . $levelClass . '">';
        $endTag = '</' . $this->o('htmlContainer') . '>';
        
        $renderedElements = '';
        
        foreach ($navigationPages as $navigationPage) {
            $renderedElements .= $this->renderElement($navigationPage, $level);
        }
        
        return $startTag . $renderedElements . $endTag;
    }

    private function renderElement (INavigationPage $page, $level)
    {
        $getHtmlElement = '';
        
        $link = $this->renderLink($page);
        
        $levelClass = 'level_' . $level;
        
        $subContainerContent = '';
        $childrenPages = $this->_navigationObject->getChildren($page->getId(0));
        if (! empty($childrenPages)) {
            $subContainerContent = $this->renderContainerContent($childrenPages, 
                    ++ $level);
        }
        
        $getHtmlElement = '<' . $this->o('htmlPage') . ' id="' .
                 $this->o('htmlAttribIdPrefix') . $page->getId() . '" ' .
                 ' navid="' . $page->getId() . '"' . ' class="' .
                 $this->o('containerCssClass') . ' ' . $levelClass . ' ' . '">' .
                 $link . $subContainerContent . '</' . $this->o('htmlPage') . '>';
        
        return $getHtmlElement;
    }

    private function renderLink (INavigationPage $page)
    {
        $label = $page->getLabel();
        $url = $page->getUrl();
        if (empty($label))
            return null;
        if (empty($url))
            return $label;
        return '<a href="' . $url . '">' . $label . '</a>';
    }

    protected function o ($name)
    {
        return @$this->_options[$name];
    }
}

?>