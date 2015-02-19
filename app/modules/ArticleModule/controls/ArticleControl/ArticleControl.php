<?php

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
    
    
    
    public function __construct(\Nette\ComponentModel\IContainer $parent = NULL, $name = NULL) {
        parent::__construct($parent, $name);
        
    }
    
    
    public function load($id = NULL) {
        
    }
    
    public function render() {
        //ddump($this);
        $template = $this->getTemplate();
        $template->setFile(__DIR__. "/article.latte");
        
        $template->render();
    }
}
