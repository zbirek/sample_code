<?php

namespace App;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SubscriberModel
 *
 * @author Jiri
 */
class SubscriberModel extends BaseModel {

    protected $tUser;
    protected $tSubscriber;

    public function __construct(\DibiConnection $dibi, \Core\ModulesLoader $modules = NULL) {
        parent::__construct($dibi, $modules);
        $this->tUser = self::PREFIX . "user";
        $this->tSubscriber = self::PREFIX . "subscriber";
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

    public function activeUser($id_user, $password) {
        $this->database->update($this->tUser, ['password' => \Nette\Security\Passwords::hash($password),
            'active' => 1])
                ->where('id_user = %i', $id_user)
                ->execute();
    }
    
    public function addSubscriberInfo($values) {
        $this->database->insert($this->tSubscriber, $values)
                ->execute();
        
    }

}
