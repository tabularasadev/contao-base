<?php

namespace trdev\ContaoBaseBundle\Element;

class ceBase extends \ContentElement
{
    //Javascript et CSS additionnels a l'élément
    private $javascripts = [];
    private $styles = [];
    
    protected $strTemplate = "ce_base";

    public function generate()
    {
        if (TL_MODE == 'BE') {
            /** @var \BackendTemplate|object $objTemplate */
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### BASE ###';
            $objTemplate->title    = $this->headline;
            $objTemplate->id       = $this->id;
            $objTemplate->link     = $this->name;
            $objTemplate->href     = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        } else {
            if (Count($this->javascripts) > 0) {
                foreach ($this->javascripts as $js) {
                    $GLOBALS['TL_JAVASCRIPT'][] = $js;
                }
            }

            if (Count($this->styles) > 0) {
                foreach ($this->styles as $css) {
                    $GLOBALS['TL_CSS'][] = $css;
                }
            }
        }

        if (!isset($_GET['items']) && \Config::get('useAutoItem') && isset($_GET['auto_item'])) {
            \Input::setGet('items', \Input::get('auto_item'));
        }

        return parent::generate();
    }

    protected function compile()
    {

    }
}
