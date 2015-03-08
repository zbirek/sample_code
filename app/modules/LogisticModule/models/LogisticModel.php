<?php
namespace App;


/**
 * Description of LogisticModel
 *
 * @author Jiri
 */
class LogisticModel extends BaseModel {
   
    protected $tUser;
    
    public function __construct(\DibiConnection $dibi, \Core\ModulesLoader $modules = NULL) {
        parent::__construct($dibi, $modules);
        $this->tUser = self::PREFIX . "user";
    }
    

        
    
    
    
    
    
    
}
