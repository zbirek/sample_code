<?php

namespace App;

/**
 * Description of userModel
 *
 * @author Jiri Jelinek <jelinekvb@gmail.com>
 * @version 7.4.2014
 * 
 */
class UserModel extends \App\BaseModel {

    /** @var string */
    private $tUser;

    public function __construct(\DibiConnection $database) {
        parent::__construct($database);

        $this->tUser = "cms_user";
    }

    public function add($data) {
        $this->database
                ->insert($this->tUser, array(
                    'login' => $data->login,
                    'name' => $data->name,
                    'password' => \Nette\Security\Passwords::hash($data->password),
                    'email' => $data->email,
                    'role' => 'admin'
                ))->execute();
    }

    public function getAllUsers() {
        return $this->database
                        ->select("*")
                        ->from($this->tUser);
    }

    public function deleteUser($id) {
        $this->database
                ->delete($this->tUser)
                ->where('id_user = ?', $id)
                ->execute();
    }

    public function getUser($id) {
        return $this->database->select("*")
                ->from($this->tUser)
                ->where('id_user = ?', $id)
                ->fetch();
    }

    public function editUser($id, $values) {
        unset($values->edit);

        if (!$values->password) {
            unset($values->password);
        } else {
            $values->password = \Nette\Security\Passwords::hash($values->password);
        }

        $this->database->update($this->tUser, $values)
                ->where('id_user = ?', $id)
                ->execute();
    }

}
