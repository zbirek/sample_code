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
    public $controls = array();

    public function startup() {
        parent::startup();
    }

    public function renderDefault($slug) {
        if ($slug) {
            $node = $this->nodeModel->getNode($slug);
            $id_node = $node['id_node'];
            $id_module = $node['id_module'];

            $module = $this->modules->getModule($id_module);
            $this->createControl($module['control'], $id_node);

            
        }
		
		$this->template->modules = $this->controls;
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
