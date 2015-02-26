<?php
namespace App;
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
	
	
	public function __construct(\DibiConnection $dibi, \Core\ModulesLoader $modules = NULL) {
		parent::__construct($dibi, $modules);
		$this->tMenu = self::PREFIX . "menu";
	}
	
	/***
	 * @TODO cache!
	 */
	public function getMenuFluent() {
		return $this->database->select("*")
					->from("$this->tMenu menu")
					->leftJoin("$this->tNode node ON menu.id_node = node.id_node");
	}
	
}
