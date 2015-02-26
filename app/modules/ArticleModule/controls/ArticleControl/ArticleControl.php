<?php
//namespace App;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArticleControl
 *
 * @author Jiri
 */
class ArticleControl extends \Nette\Application\UI\Control {
    
    /** @var App\ArticleModule\ArticleModel */
	protected $articleModel;
	
	protected $article;
	
    
    public function __construct(\Nette\ComponentModel\IContainer $parent = NULL, $name = NULL) {
        parent::__construct($parent, $name);
        $this->articleModel = $this->presenter->getContext()->ArticleModel;
    }
    
    
	public function load($id = NULL) {		
		$this->article = $this->articleModel->getFluentArticle()->where('id_article = %i', $id)->fetch();
		
		
	}
	
    public function render() {
        $template = $this->getTemplate();
        $template->setFile(__DIR__. "/article.latte");
		$template->article = $this->article;
		        
        $template->render();
    }
}
