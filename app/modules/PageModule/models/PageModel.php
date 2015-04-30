<?php

namespace App;
use Nette\Caching\Cache;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PageModel
 *
 * @author Jiri Jelinek <jelinekvb@gmail.com>
 * @version 25.2.2015
 * 
 */
class PageModel extends BaseModel{

	protected $tPage;
	
	const Model = "Page";
    
    protected $pages;
    
    /** @var \Nette\Caching\Cache */
    protected $pageStorage;
	
	public function __construct(\DibiConnection $dibi, \Core\ModulesLoader $modules) {
		parent::__construct($dibi, $modules);
		$this->tPage = self::PREFIX . "page";
        $this->pageStorage = new Cache(new \Nette\Caching\Storages\FileStorage(TEMP_DIR)); 
	}
    
    public function setStorage() {
        $pages = $this->getPageFluent()->fetchAssoc('id_node');
        $this->pageStorage->save('pages', $pages);        
    }
	
	/**
     * 
     * @return \DibiFluent
     */
	public function getPageFluent() {
		return $this->database->select("*")
					->from($this->tPage);				
	}
	
	/**
	 * 
	 * @param int $id
	 * @return \Nette\Utils\ArrayHash
	 */
	public function getPage($id) {
        $this->pages = $this->pageStorage->load('pages');            
        
        if(!$this->pages){
            $this->pages = $this->getPageFluent()->fetchAssoc('id_node');
            $this->pageStorage->save('pages', $this->pages);    
        }
        //ddump($this->pages[$id]);
        return  $this->pages[$id];
	}
		
	/**
	 * pridani stranky
	 * @param array $values
	 */
	public function addPage($values) {
		
		$this->database->begin();
		
			$module = $this->modules->getModuleByUid(self::Model);		
			$id_node = $this->initNode($module['id_module']);
			$values['id_node'] = $id_node;
			// pridani clanku
			$this->database->insert($this->tPage, $values)
				->execute();
		
			$this->updateNodeSeoSettings($id_node, $values['title']);
		
		$this->database->commit();
	}
	
	/***
	 * editace stranky
	 */
	public function editPage($id_page, $values) {		
		$this->database->update($this->tPage, $values)
			->where("id_node = %i", $id_page)
			->execute();				
	}
	
	public function deletePage($id_page) {
		$this->database->begin();		
		
		$this->database->delete($this->tPage)
				->where("id_node = %i", $id_page)
				->execute();
		
		$this->deleteNode($id_page);
		$this->pageStorage->remove('pages');
		$this->database->commit();
	}
	
	
	
}
