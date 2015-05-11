<?php
namespace App\AdminModule\Presenters;
use Nette\Application\UI\Form;
/**
 * Description of AdminPresenter
 *
 * @author Jiri
 */
class ArticlePresenter extends BaseBackendPresenter{
    
    /** @var \App\ArticleModule\ArticleModel @inject */
    public $articleModel;
    
    public function createComponentArticleGrid() {
        $grid = new \Nextras\Datagrid\Datagrid();
        
        $grid->addColumn('id_node', 'ID článku');
        $grid->addColumn('title', 'Titulek');
        $grid->addColumn('created_at', 'Přidáno');
        $grid->addColumn('name', 'Autor');
        
        $grid->setDataSourceCallback(function($filter, $order){
            return $this->articleModel->getFluentArticle()->fetchAll();
        });
        
        $grid->addCellsTemplate(LIBS_DIR . '/nextras/datagrid/bootstrap-style/@bootstrap3.datagrid.latte');
        $grid->addCellsTemplate(__DIR__ . '/../templates/Article/grid.latte');
                
        return $grid;
    }
    
    public function createComponentArticleForm() {
        $form = new Form();
        
        $form->setRenderer(new \Nextras\Forms\Rendering\Bs3FormRenderer);
        
        $form->addText('title', 'Titulek')
                ->setRequired('Zadejte titulek článku');
        $form->addTextArea('prefix', 'Prefix');
        $form->addTextArea('text', 'Text');
        $form->addSubmit('send','Uložit');
        $form->addHidden('id_node');
        
        $form->onSuccess[] = $this->articleSubmitted;
        return $form;
    }
    
    public function articleSubmitted(Form $form) {
        $values = $form->getValues();
        
        if($values->id_node) {
            // edit article
            $id_node = $values->id_node;
            unset($values->id_node);
            $this->articleModel->editArticle($id_node, $values);
            $this->flashMessage('Článek byl upraven', 'success');
            
        }else{
            //add article
            unset($values->id_node);
            $values->id_author = $this->getUser()->id;
            $this->articleModel->addArticle($values);
            $this->flashMessage('Článek byl přidán', 'success');
        }
        
        $this->redirect('default');
    }
    
    public function actionDefault() {
        $this->template->backlink = $this->storeRequest();
    }
    
    public function actionArticle($id = NULL) {
        if($id) {
            $this['articleForm']->setDefaults($this->articleModel->getArticle($id));
        }
    }
    
    public function handleDeleteArticle($id) {
        $this->articleModel->deleteArticle($id);
        $this->flashMessage('Článek byl smazán', 'success');
        $this->redirect('this');
    }
    
}
