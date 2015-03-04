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
    
    public function getSubsciberFluent() {
        return $this->database->select("*")->from($this->tUser)
                ->where('role = %s', 'user');
    }
    
    /**
     * Pridani odberatele
     * @param array $values
     */
    public function addSubscriber($values) {
        $this->database->insert($this->tUser, ['login' => $values['login'],
                                                'name' => $values['name'],
                                                'email' => $values['email'],
                                                'role' => 'user',
                                                'active' => 0])
                                            ->execute();
        
        // @TODO send email
        
    }
    
    
    
    
    
}
