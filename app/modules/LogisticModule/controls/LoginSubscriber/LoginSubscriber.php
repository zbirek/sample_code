<?php
namespace App\SubscriberModel;

use Nette\Application\UI\Form;
/**
 * Description of LoginSubscriber
 *
 * @author Jiri
 */
class LoginSubscriber extends \Nette\Application\UI\Control {
    
    public function render() {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ . '/loginSubscriber.latte');
        
        $template->render();
    }
    
    public function createComponentLoginForm() {
        $form = new Form();
        
        $form->addText('login', 'Login');
        $form->addPassword('password',  'Heslo');
        $form->addSubmit('send', 'Přihlásit se');
        
        $form->onSuccess[] = $this->loginSubmitted;
        return $form;
    }
    
    public function loginSubmitted(Form $form) {
        
        $values = $form->getValues();
        
        $this->presenter->user->login($values->login, $values->password);
        
        if($this->presenter->user->isLoggedIn()){
            $this->redirect('Odberatel:');
        }else{
            $this['loginForm']->addError('Uživatel nelze přihlásit');
        }
    }
}
