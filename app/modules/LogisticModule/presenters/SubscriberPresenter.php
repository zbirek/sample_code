<?php
namespace App\FrontendModule\Presenters;

use Nette\Application\UI\Form;

/**
 * Description of SubscriberPresenter
 *
 * @author Jiri
 */
class SubscriberPresenter extends BaseFrontendPresenter {
    
    /** @var \App\SubscriberModel @inject */
    public $subsciberModel; 
    
    protected $userInfo;
    
    public function actionActive($email) {
        //ddump($this->findLayoutTemplateFile());        
        $email = base64_decode($email);
        
        $this->userInfo = $this->subsciberModel->getSubsciberFluent()->where('email = %s', $email)
                ->fetch();
        
        
        if(!$this->userInfo) {
            throw new \Nette\Application\BadRequestException('Uživatel nebyl nalezen');
        }
        
        if($this->userInfo['active']!=0) {
            throw new \Nette\Application\BadRequestException('Uživatel byl již aktivován');
        }
        
    }
    
    public function createComponentActiveForm() {
        $form = new Form();
        
        $form->setRenderer(new \Nextras\Forms\Rendering\Bs3FormRenderer());
        
        $form->addGroup('Přihlašovací údaje');
        $form->addPassword('password', 'Heslo');
        $form->addPassword('confirm_password', 'Ověření hesla')
                ->addCondition(Form::EQUAL, $form['password'], 'Zadaná hesla se neshodují');
        
        $form->addGroup('Údaje odběratele');
        
        //$form->addText('name', 'Jméno odběratele');
        $form->addText('street', 'Ulice');
        $form->addText('city', 'Obec');
        $form->addText('phone', 'Telefon');
        
        $form->addSubmit('send', 'Aktivovat účet');
        
        $form->onSuccess[] = $this->activeSubscriber;
        
        return $form;
    }
    
    public function activeSubscriber(Form $form) {
        $values = $form->getValues();
        
        $id_user = $this->userInfo['id_user'];
        $password = $values->password; 
        
        $user_values = [ 'id_user' => $id_user,
                //'name' => $values['name'],
                'street' => $values['street'],
                'city' => $values['city'],
                'phone' => $values['phone']
            ];
        
        $this->subsciberModel->activeUser($id_user, $password);
        $this->subsciberModel->addSubscriberInfo($user_values);
        
        $this->user->login($this->userInfo['login'], $password);
        
        $this->redirect('Odberatel:');
    }
    
    
}
