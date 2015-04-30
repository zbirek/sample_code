<?php
namespace App\AdminModule\Presenters;
use Nette\Application\UI\Form;

/**
 * Description of NodePresenter
 *
 * @author Jiri
 */
class NodePresenter extends BaseBackendPresenter{
    
    /** @var \App\NodeModel @inject */
    public $nodeModel;
    
    protected $node;
    
    public function renderEdit($id) {
        $this->node = $this->nodeModel->getNodeId($id);
        
        $this->template->node = $this->node;
        $this['editForm']->setDefaults($this->node);
        $this['editForm']['backlink']->setDefaultValue($this->getParameter('backlink'));
    }
    
    public function createComponentEditForm() {
        $form = new Form;
        
        $form->setRenderer(new \Nextras\Forms\Rendering\Bs3FormRenderer);
        
        $form->addText('slug', 'Slug')
                ->setRequired('Zadejte slug uzlu');
        
        $form->addText('title', 'Titulek stránky');
        
        $form->addTextArea('seo_description', 'Popisek stránky');
        
        $form->addHidden('id_node');
        
        $form->addSubmit('save', 'Uložit');
        $form->addHidden('backlink');
        
        $form->onSuccess[] = $this->editFormSubmitted;
        
        return $form;
    }
    
    public function editFormSubmitted(Form $form) {
        $values = $form->getValues();
        if($values['backlink']) {
            $backlink = $values['backlink'];
            unset($values['backlink']);
        }
        $this->nodeModel->editNode($values);
        
        $this->flashMessage('Uzel byl upraven', 'success');
        
        if(isset($backlink)){
            $this->redirect($this->restoreRequest($backlink));
        }
        $this->redirect('this');
    }
    
    
}
