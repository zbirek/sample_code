<?php

namespace App\AdminModule\Presenters;

/**
 * Description of BasePresenter
 *
 * @author Jiri Jelinek <jelinekvb@gmail.com>
 * @version 27.3.2014
 * 
 */


class BaseBackendPresenter extends \App\Presenters\BasePresenter{
     
    public function startup() {
        parent::startup();
        
        if(!$this->getUser()->isLoggedIn())
        {
            $this->redirect(':Sign:in');
        }
		
        $this->setLayout($this->context->parameters['appDir'] . '/core/BackendModule/templates/@layout.latte');        
    }
    
    public function createTemplate($class = NULL)
    {
            $template = parent::createTemplate($class);
            
            $module = explode(':', $this->getName());
            $template->modulePath = $template->basePath . '/admin_theme/' . $module[0] . 'Module';
            return $template;
    }
    
    public function beforeRender() {
        parent::beforeRender();
        
        $this->template->modules = $this->modules->getAdminModules();
    }
    
    
    public function handleLogout()
    {
        $this->getUser()->logout();
        $this->flashMessage('Uživatel byl úspěšně odhlášen', 'success');
        $this->redirect(':Sign:In');
    }
    
    
     
}
