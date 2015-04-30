<?php
namespace App;

use Nette\Caching\Cache;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MenuModel
 *
 * @author Jiri Jelinek <jelinekvb@gmail.com>
 * @version 25.2.2015
 * 
 */
class MenuModel extends BaseModel{
	
	protected $tMenu;
    protected $tNode;
	
    protected $menuStorage;
	
	public function __construct(\DibiConnection $dibi, \Core\ModulesLoader $modules = NULL) {
		parent::__construct($dibi, $modules);
		$this->tMenu = self::PREFIX . "menu";
        $this->tNode = self::PREFIX . "node";
        
        $this->menuStorage = new Cache(new \Nette\Caching\Storages\FileStorage(TEMP_DIR)); 
	}
	
	/***
	 * @TODO cache!
	 */
	public function getMenuFluent() {
		return $this->database->select("*")
					->from("$this->tMenu menu")
					->leftJoin("$this->tNode node ON menu.id_node = node.id_node");
	}
    
    /**
     * Vraci a cachuje aktualni menu
     * @return Array
     */
    public function getMenu() {
        $this->menu = $this->menuStorage->load('menu');
        
        if(!$this->menu) {        
            $this->menu = $this->database->select("*")
                            ->from("$this->tMenu menu")
                            ->leftJoin("$this->tNode node ON menu.id_node = node.id_node")
                            ->orderBy('position ASC')
                            ->fetchAll();
             $this->menuStorage->save('menu', $this->menu);
        }
        
        return $this->menu;
	}
    
    public function getPrimaryMenuItem() {
        $this->menu = $this->getMenu();        
        return reset($this->menu);
    }
    
    public function deleteMenuItem($id) {
        $this->database->delete($this->tMenu)
                ->where('id = %i', $id)
                ->execute();
        $this->menuStorage->remove('menu');
    }
    
    public function addMenuItem($id_node, $title, $position = 0) {
        $this->database->insert($this->tMenu, array(
                                    'id_node' => $id_node,
                                    'title' => $title,
                                    'position' => $position))
                        ->execute();
    }
    
    public function addItems($nodes) {
        $max_position = $this->database->select('MAX(position)')
                                ->from($this->tMenu)
                                ->fetchSingle();
        
        //ddump($nodes, $max_position);
        $tmp = $this->database->select('*')
                ->from($this->tNode)
                ->where('id_node IN %in', $nodes)
                ->fetchPairs('id_node', 'title');
        
        foreach($nodes as $node) {
            $max_position++;
            $this->addMenuItem($node, $tmp[$node],$max_position);
        }
        
        $this->menuStorage->remove('menu');
        
        
    }
	
}
