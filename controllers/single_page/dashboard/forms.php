<?php
namespace Concrete\Package\AttributeForms\Controller\SinglePage\Dashboard;

use Concrete\Core\Page\Controller\PageController,
    Page,
    URL;

class Forms extends PageController
{
    public function on_start()
    {
        $c = Page::getCurrentPage();
        $children = $c->getCollectionChildrenArray();
        if (!empty($children) && isset($children[0])) {
            $this->redirect(URL::to(Page::getByID($children[0])));
        } else {
            $this->redirect($this->action('types'));
        }
    }
}