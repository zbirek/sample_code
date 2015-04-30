<?php
namespace App\AdminModule\Presenters;

use Nette\Application\UI\Form;
/**
 * Description of PagePresenter
 *
 * @author Jiri Jelinek <jelinekvb@gmail.com>
 * @version 25.2.2015
 * 
 */
class PagePresenter extends BaseBackendPresenter{
	
	/** @var \App\PageModel @inject */
	public $pageModel;
	
	public function renderDefault() {
		$this->template->pages = $this->pageModel->getPageFluent()->orderBy("id_node DESC")->fetchAll();
        $this->template->backlink = $this->storeRequest();
	}
	
	public function renderEditPage($id) {
		$page = $this->pageModel->getPage($id);
		$this['pageForm']->setDefaults($page);
	}
	
	public function createComponentPageForm() {
		$form = new Form;
		$form->setRenderer(new \Nextras\Forms\Rendering\Bs3FormRenderer());
		
		$form->addText('title', 'Nadpis');		
		$form->addTextArea('body', 'Obsah');		
		$form->addSubmit('send', 'Uložit');
		$form->addHidden('id_node');		
		
		$form->onSuccess[] = $this->pageFormSubmitted;		
		return $form;
	}
	
	public function pageFormSubmitted(Form $form) {
		$values = $form->getValues();
		
		if($values['id_node']) {
			// edit page
			$this->pageModel->editPage($values['id_node'], $values);			
			$this->flashMessage('Stránka byla upravena', 'success');
		}else{			
			// add page
			unset($values['id_node']);
			$this->pageModel->addPage($values);
			$this->flashMessage("Stránka byla přidána", 'success');
		}
		
		$this->redirect('default');
		
	}
	
	public function handleDeletePage($id) {
		$this->pageModel->deletePage($id);
		$this->flashMessage('Stránka byla smazána', 'success');
		$this->redirect('this');
	}
	
	
}
