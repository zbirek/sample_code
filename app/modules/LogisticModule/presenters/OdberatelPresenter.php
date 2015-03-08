<?php
namespace App\FrontendModule\Presenters;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OdberatelPresenter
 *
 * @author Jiri
 */
class OdberatelPresenter extends \App\FrontendModule\Presenters\BaseFrontendPresenter{
    
    public function startup() {
        parent::startup();
        
        if(!$this->user->isLoggedIn()){
            throw new \Nette\Security\AuthenticationException('Pro vstup do této sekce musíte být přihlášen');
        }
    }
    
    public function renderDefault() {
        
    }
    
}
