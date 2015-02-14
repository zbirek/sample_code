<?php
namespace App\ArticleModule;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModulesExtensions
 *
 * @author Jiri Jelinek <jelinekvb@gmail.com>
 * @version 11.2.2015
 * 
 */
class ModulesExtension extends \Nette\DI\CompilerExtension implements \Flame\Modules\Providers\IRouterProvider{
	//put your code here
	public function getRoutesDefinition()
    {
		$routeList = new \Nette\Application\Routers\RouteList();
		$routeList[] = new \Flame\Modules\Application\Routers\NetteRouteMock('index.php', 'App:Homepage:default', \Nette\Application\Routers\Route::ONE_WAY);
        $routeList[] = new \Nette\Application\Routers\Route('/pokus','Article:Frontend:default');
		$routeList[] = new \Nette\Application\Routers\Route('<module>/<presenter>/<action>[/<id>]', array(
                'module' => 'App',
                'Presenter' => 'Homepage',
                'action' => 'default',
                'id' => null
		));
        
		
        return $routeList;
    }
	//put your code here
}
