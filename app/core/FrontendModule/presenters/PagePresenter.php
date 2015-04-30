<?php

namespace App\FrontendModule\Presenters;

/**
 * Description of BasePresenter
 *
 * @author Jiri
 */
class PagePresenter extends BaseFrontendPresenter {

    /** @var \App\NodeModel @inject */
    public $nodeModel;
    
    /** @var \App\MenuModel @inject */
    public $menuModel;
    

    
    public $controls = array();

    public function startup() {
        parent::startup();
    }

    public function renderDefault($slug) {
        if ($slug) {
            $node = $this->nodeModel->getNode($slug);
        }else{
            //find main page
            $node = $this->menuModel->getPrimaryMenuItem();
        }
        
            $id_node = $node['id_node'];
            $id_module = $node['id_module'];
            $module = $this->modules->getModule($id_module);
            $this->createControl($module['control'], $id_node);
		
		$this->template->modules = $this->controls;
        $this->template->title = $node['title'];
        $this->template->seo_description = $node['seo_description'];
        //ddump($node);
		//ddump($this->template->modules);
    }

	public function createComponentContent($name, $od) {
		//ddump($name, $od);
	}
	
	
    public function createControl($className, $key) {		
		$component = new $className($this, $key);	
		$component->load($key);		
		
		$this->controls[] = $component;
		
    }

}
