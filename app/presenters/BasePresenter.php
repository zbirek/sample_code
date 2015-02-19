<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    
    /**
     * @var \Core\ModulesLoader @inject
     */
    public $modules;
    
    
    /**
    * Overrides Nette\Application\UI\Presenter method for cases where layout is hard set
    */    
    public function formatLayoutTemplateFiles()
    {
        if (!empty($this->layout) && strpos($this->layout, $this->context->parameters['appDir']) !== false){
                return array($this->layout);
        }else{
                return parent::formatLayoutTemplateFiles();
        }
    }

}
