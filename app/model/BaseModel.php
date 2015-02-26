<?php
namespace App;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseModel
 *
 * @author Jiri
 */
class BaseModel{
    
    /** @var \DibiConnection */
    protected $database;
	
	protected $modules;
	
	protected $tNode;
    
    const PREFIX = "cms_";

    public function __construct(\DibiConnection $dibi, \Core\ModulesLoader $modules = NULL) {
        $this->database = $dibi;
		$this->modules = $modules;
		
		$this->tNode = self::PREFIX . "node";		
    }
	
	/***
	 * inicializuje uzel 
	 * @return int
	 */	
	public function initNode($id_module) {
		$this->database->insert($this->tNode, ['id_module' => $id_module])
				->execute();
		
		return $this->database->insertId;
	}
	
	
	/**
	 * upraveni nastaveni slugu|popisku stranky
	 * @param int $id_node
	 * @param varchar $slug
	 * @param text $description
	 */
	public function updateNodeSeoSettings($id_node, $slug = NULL, $description = NULL) {
		try{
		$slug = \Nette\Utils\Strings::webalize($slug);
		
		$this->database->update($this->tNode, ['slug' => $slug, 'seo_description' => $description])
				->where('id_node = %i', $id_node)
				->execute();
		
		}catch (\DibiDriverException $e){
			
			if($e->getCode() == 1062){
				$slug = $id_node."-".$slug;
				$this->database->update($this->tNode, ['slug' => $slug, 'seo_description' => $description])
					->where('id_node = %i', $id_node)				
					->execute();
			}
		}
	}
	
	public function deleteNode($id_node) {
		$this->database->delete($this->tNode)
				->where("id_node = %i", $id_node)
				->execute();
	}
        
}
