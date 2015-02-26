<?php
namespace Core;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModulesLoader
 *
 * @author Jiri
 */
class ModulesLoader extends \Nette\Object{
    //put your code here
    
    /** @var \Nette\Application\PresenterFactory */
    private $presenterFactory;
    
    /** @var DibiConnection */
    private $database;
    
    /** @var Nette\Caching\Storages\FileStorage */
    private $cache;
    
    protected $modules;
    
    protected $tModules;
    
    public function __construct(\Nette\Application\PresenterFactory $presenterFactory, \DibiConnection $dibi, \Nette\Caching\Storages\FileStorage $cache) {
        $this->presenterFactory = $presenterFactory;
        $this->database = $dibi;
        $this->cache = $cache;
        
        $this->tModules = \App\BaseModel::PREFIX . "modules";
        $this->findModules();
    }
    
    public function getModules() {
        if(!$this->modules) $this->setModules();
		
        return $this->modules;
    }
    
	public function getAdminModules() {
		$modules = $this->getModules();
		
		$tmp = [];
		foreach($modules as $module) {
			if($module['have_admin']) $tmp[] = $module;
		}
		
		return $tmp;
	}
	
	
    public function setModules(){
		$cache = new \Nette\Caching\Cache($this->cache);		
		
		$this->modules = $cache->load("module");
		
		if($this->modules == NULL){		
			$this->modules = $this->database->select("*")
								->from($this->tModules)
								->where('active = 1')
								->fetchAssoc('id_module');

			$cache->save("module", $this->modules, array(\Nette\Caching\Cache::TAGS => "module"));
		}	
    }
    
    public function getModule($id) {
        if(!$this->modules) $this->setModules();
        
        return $this->modules[$id];        
    }
    
	public function getModuleByUid($uid) {
		if(!$this->modules) $this->setModules();
        
		foreach($this->modules as $module) {
			if($module->uid == $uid) return $module;
		}
		
		return NULL;
	}
	
    
    public function findModules() {
        
        
        //foreach(\Nette\Utils\Finder::findFiles("*.module.config")->in();
        
        
       //ddump($files);
    }
    
    
    
    
    
    
    /**
	 * Calls get<$view>ViewPossibleParams from given module
	 * @param string $module
	 * @param string $view
	 * @return mixed
	 */
	public function getViewParameters($module, $view)
	{
		$presenter = $this->presenterFactory->createPresenter($module . ':Frontend');
        ddump($presenter);
		$method_name = 'get' . ucfirst($view) . 'ViewPossibleParams';
		return $presenter->$method_name();
	}
}
