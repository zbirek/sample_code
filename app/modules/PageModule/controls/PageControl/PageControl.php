<?php

/**
 * Description of PageControl
 *
 * @author Jiri Jelinek <jelinekvb@gmail.com>
 * @version 25.2.2015
 * 
 */
class PageControl extends \Nette\Application\UI\Control{
	
	/** @var \App\PageModel */
	protected $pageModel;
	
	protected $page;
	
	public function __construct(\Nette\ComponentModel\IContainer $parent = NULL, $name = NULL) {
		parent::__construct($parent, $name);
		$this->pageModel = $this->presenter->context->PageModel;		
	}
	
	public function load($id) {
		$this->page = $this->pageModel->getPage($id);
	}
	
	public function render() {
		$template = $this->template;
		$template->setFile(__DIR__ . "/page.latte");
		
		$template->page = $this->page;
		
		$template->render();
	}
	
}
