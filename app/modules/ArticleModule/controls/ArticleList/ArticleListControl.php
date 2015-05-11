<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArticleListControl
 *
 * @author Jiri
 */
class ArticleListControl extends \Nette\Application\UI\Control{
    
    /** @var App\ArticleModule\ArticleModel */
    public $articleModel;
    
    /** @var Array */
    public $articles;
    
    public function __construct(\Nette\ComponentModel\IContainer $parent = NULL, $name = NULL) {
        parent::__construct($parent, $name);
        $this->articleModel = $this->presenter->context->getService('ArticleModel');        
        
    }
    
    public function load($id = NULL) {
        $this->articles = $this->articleModel->getFluentArticle()->orderBy('article.created_at DESC')
                ->limit(5)
                ->fetchAll();
    }
    
    
    public function render() {
        $template = $this->getTemplate();
        $template->articles = $this->articles;
        if(file_exists($file = __DIR__ . "/articleList_Custom.latte")) {
            $template->setFile($file);
        }else{
            $template->setFile(__DIR__ . "/articleList.latte");
        }
        
        $template->render();
    }
    
    
}
