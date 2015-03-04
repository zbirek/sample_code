<?php

namespace App\AdminModule\Presenters;

use Nette\Application\UI\Form;

/**
 * Description of LogisticPresenter
 *
 * @author Jiri
 */
class LogisticPresenter extends BaseBackendPresenter {
    
    /** @var \App\LogisticModel  @inject */
    public $model;

    
    
    public function createComponentSubscriberForm() {

        $form = new Form;

        $form->setRenderer(new \Nextras\Forms\Rendering\Bs3FormRenderer());

        $form->addText('login', 'Login')
                ->setRequired('Zadejte přihlašovací jméno');

        $form->addText('name', 'Jméno odběratele')
                ->setRequired('Zadejte jméno odběratele');

        $form->addText('email', 'E-mail')
                ->addRule(Form::FILLED, 'Zadejte e-mail')
                ->addRule(Form::EMAIL, 'Zadejte e-mail ve správném tvaru');

        //$form->addPassword('password', 'Heslo');

        $form->addSubmit('send', 'Přidej uživatele');

        $form->onSuccess[] = $this->subscriberSubmitted;

        return $form;
    }
    
    public function subscriberSubmitted(Form $form){
        try {
            $values = $form->getValues();

            $this->model->addSubscriber($values);

            $this->flashMessage('Odběratel byl přidán', 'success');
            $this->redirect('default');
        }catch(\DibiDriverException $e) {
            if($e->getCode() == 1062) {
                $this->flashMessage('Uživatel s tímto loginem/emailem již v databázi je', 'danger');
            }else{
                $this->flashMessage('DB error', 'danger');
            }
        }
    }
    
    public function createComponentSubscriberGrid() { 
        $grid = new \Nextras\Datagrid\Datagrid();
        
        $grid->addColumn('login', 'Uživatelské jméno')->enableSort();
        $grid->addColumn('name', 'Jméno odběratele')->enableSort();
        $grid->addColumn('email', 'E-mail')->enableSort();
        $grid->addColumn('active', 'Aktivní uživatel')->enableSort();
        
        $grid->setDataSourceCallback(function($filter, $order){
           $source =  $this->model->getSubsciberFluent(); 
           
           if($order){
               $source->orderBy($order[0]. " " . $order[1]);
           }else{
               $source->orderBy('id_user DESC');
           }
           
           return $source;
        });
        
        $grid->addCellsTemplate(LIBS_DIR . '/nextras/datagrid/bootstrap-style/@bootstrap3.datagrid.latte');
        $grid->addCellsTemplate(__DIR__ . '/../templates/Logistic/subscriberGrid.latte');
        
        return $grid;
    }

}
