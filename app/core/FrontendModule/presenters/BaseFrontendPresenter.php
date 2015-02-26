<?php
namespace App\Presenters;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseFrontendPresenter
 *
 * @author Jiri Jelinek <jelinekvb@gmail.com>
 * @version 25.2.2015
 * 
 */
class BaseFrontendPresenter extends \App\Presenters\BasePresenter{
	
	public function createComponentMenu() {
		return new \MenuControl($this, 'menu');
	}
	
	
}
