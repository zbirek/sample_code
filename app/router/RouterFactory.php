<?php

namespace App;

use Nette,
	Nette\Application\Routers\RouteList,
	Nette\Application\Routers\Route,
	Nette\Application\Routers\SimpleRouter;


/**
 * Router factory.
 */
class RouterFactory extends \Nette\Object
{
    /** @var NodeModel */
    public $nodeModel;

    public function __construct(NodeModel $nodeModel) {
        $this->nodeModel = $nodeModel;
    } 

	/**
	 * @return \Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList();
        
        //$router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
		//$router[] = new Route('[/<slug>]/[/<id>]', ':Front:Page:default');
        
         $router[] = new Route('admin/<presenter>/<action>[/<id>]', array(
            'module' => 'Admin',
            'presenter' => 'BaseBackend',
            'action' => 'default',
                )
        );
        
		$router[] = new Route('<slug>', 'Frontend:Page:default');
        
          
        $router[] = new Route('<presenter>/<action>[/<id>]', 'Frontend:Page:default');
        $router[] = new Route('index.php', 'Frontend:Page:default', Route::ONE_WAY);
        
        
        return $router;
	}

}
