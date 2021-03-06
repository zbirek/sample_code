<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CompilerExtension
 *
 * @author Jiri
 */
class CompilerExtension extends Nette\DI\CompilerExtension {

	//put your code here

	public function loadConfiguration() {
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('modules'))
				->setClass('\Core\ModulesLoader', ['@nette.presenterFactory', '@dibi.connection', '@cacheStorage']);
	}

}
