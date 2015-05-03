<?php

namespace App\AdminModule\Presenters;

use Nette\Application\UI\Form;

/**
 * Description of MenuPresenter
 *
 * @author Jiri
 */
class MenuPresenter extends BaseBackendPresenter {

    /** @var \App\MenuModel @inject */
    public $menuModel;

    /** @var \App\NodeModel @inject */
    public $nodeModel;
    protected $nodes;

    public function actionDefault() {
        if(!$this->nodes) $this->setNodes();
        
    }
    
    public function renderDefault() {
        //ddump($this->menuModel->getTreeMenu());
        $this->template->items = $this->menuModel->getMenu();
        $this->backlink = $this->storeRequest();
        $this->template->backlink = $this->backlink;
        //ddump($this->nodes);
    }

    public function handleDelete($id) {
        $this->menuModel->deleteMenuItem($id);

        $this->flashMessage('Položka menu byla smazána', 'success');

        if ($this->isAjax()) {
            $this->redrawControl('menu');
            $this->redrawControl('node');
            $this->redrawControl('scripts');
        } else {
            $this->redirect('this');
        }
    }

    public function createComponentMenuForm() {
        $form = new Form;
        $form->setRenderer(new \Nextras\Forms\Rendering\Bs3FormRenderer);
        $form->getElementPrototype()->class('ajax');
        //ddump($this->nodes);
        $form->addGroup('Přidání uzlů do menu');
        $form->addCheckboxList('items', 'Přidat do menu', $this->nodes);
        $form->addSubmit('send', 'Přidat');

        $form->onSuccess[] = $this->menuSubmitted;
        return $form;
    }

    public function menuSubmitted(Form $form) {
        $values = $form->getValues();

        $this->menuModel->addItems($values['items']);
        $this->setNodes();
        //ddump($this->nodes);
        if ($this->isAjax()) {
            $this['menuForm']->setValues(array(), TRUE);
            $this->redrawControl();
        } else {
            $this->redirect('this');
        }
    }

    protected function setNodes() {
        $items = $this->menuModel->getMenuFluent()->fetchPairs(NULL, 'id_node');
        $this->nodes = $this->nodeModel->getNodeFluent();
        if($items){
            $this->nodes->where('id_node NOT IN %in', $items);
        }
        $this->nodes = $this->nodes->fetchPairs('id_node', 'title');

        return $this->nodes;
    }
    
    public function handleSaveOrder() {
        //ddump($this->getParameter('order')[0]);
        $order = $this->getParameter('order');
        
        $this->menuModel->setOrder($order);
        
    }
    
    

}
