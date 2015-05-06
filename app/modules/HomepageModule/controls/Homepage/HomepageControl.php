<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HomepageControl
 *
 * @author Jiri Jelinek <jelinekvb@gmail.com>
 */
class HomepageControl extends \Nette\Application\UI\Control{
    
    public function load($id) {
        
    }
    
    public function render() {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ . "/Homepage.latte");
        
        $template->render();
    }
    
}
