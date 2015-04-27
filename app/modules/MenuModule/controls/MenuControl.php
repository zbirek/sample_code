<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MenuControl
 *
 * @author Jiri Jelinek <jelinekvb@gmail.com>
 * @version 25.2.2015
 * 
 */
class MenuControl extends \Nette\Application\UI\Control{
	
	/** @var \App\MenuModel */
	protected $menuModel;
	
	protected $menu;
	
	public function __construct(\Nette\ComponentModel\IContainer $parent = NULL, $name = NULL) {
		parent::__construct($parent, $name);
		$this->menuModel = $this->presenter->context->getService('MenuModel');
	}
	
	public function prepairMenu() {
		$this->menu = $this->menuModel->getMenu();
	}
	
	
	public function render() {
		$this->prepairMenu();
		$template = $this->template;
		$template->setFile(__DIR__. "/Menu.latte");
		$template->menu = $this->menu;
		$template->render();		
	}
	
}
