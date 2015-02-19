<?php

namespace App\FrontendModule\Presenters;

/**
 * Description of BasePresenter
 *
 * @author Jiri
 */
class PagePresenter extends \App\Presenters\BasePresenter {

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

            
            $this->template->modules = $this->controls;
            //ddump($this);
            //ddump($this->controls);
        }
    }

    public function createControl($className, $key) {
       
        $control = new $className($this, $key);
        $this->controls[] = $control;
    }

}
