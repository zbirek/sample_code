<?php

namespace App\AdminModule\Presenters;

use Nette\Application\UI\Form;
/**
 * Description of UserPresenter
 *
 * @author Jiri
 */
class UserPresenter extends BaseBackendPresenter {

    /**
     * @inject
     * @var \App\UserModel
     */
    public $model;

    public function renderDefault() {
        $this->template->users = $this->model->getAllUsers();
    }

    public function createComponentEdit() {

        $form = new Form;

        $form->setRenderer(new \Nextras\Forms\Rendering\Bs3FormRenderer());

        $form->addText('login', 'Login');
        $form->addText('name', 'Jméno');
        $form->addText('email', 'E-mail');
        $form->addPassword('password', 'Heslo');

        $form->addSubmit('send', 'Přidej uživatele');

        $form->onSuccess[] = $this->editSubmitted;

        return $form;
    }

    public function editSubmitted(Form $form) {
        try {
            $values = $form->getValues();


            if (isset($values->edit)) {
                $this->model->editUser($values->edit, $values);
                $this->redirect('default');
            } else {
                $this->model->add($values);

                $this->flashMessage('Uživatel byl přidán', 'success');
                $this->redirect('this');
            }
        } catch (\PDOException $e) {
            $this->flashMessage('DB Error', 'danger');
        }
    }

    public function handleDeleteUser($id) {
        $this->model->deleteUser($id);
        $this->flashMessage('Uživatel byl smazán', 'success');

        $this->redirect('this');
    }

    public function createComponentGrid() {
        $grid = new \Nextras\Datagrid\Datagrid();

        $grid->addColumn('id_user', 'ID');
        $grid->addColumn('login', 'Login');
        $grid->addColumn('name', 'Jméno');
        $grid->addColumn('email', 'E-mail');

        $_this = $this;
        $grid->setDataSourceCallback(function($filter, $order)use($_this) {

            return $_this->model->getAllUsers();
        });

        $grid->addCellsTemplate(__DIR__ . '/../templates/Backend/@grid.latte');

        return $grid;
    }

    public function actionEditUser($id) {
        $user = $this->model->getUser($id);
        $this->template->user = $user;
        $this['edit']->setDefaults($user);
        $this['edit']->addHidden('edit', $id);
        $this['edit']['send']->caption = "Uložit";
    }

}
