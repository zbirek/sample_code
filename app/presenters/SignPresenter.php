<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * Sign in/out presenters.
 */
class SignPresenter extends BasePresenter
{


	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = new Nette\Application\UI\Form;
		$form->addText('username', 'Username:')
			->setAttribute('class', 'form-control')
			->setAttribute('placeholder', 'Uživatelské jméno')		
			->setRequired('Please enter your username.');

		$form->addPassword('password', 'Password:')
			->setAttribute('class', 'form-control')
			->setAttribute('placeholder', 'Heslo')
			->setRequired('Please enter your password.');

		$form->addCheckbox('remember');

		$form->addSubmit('send', 'Přihlásit se');

		// call method signInFormSucceeded() on success
		$form->onSuccess[] = array($this, 'signInFormSucceeded');
		return $form;
	}


	public function signInFormSucceeded($form, $values)
	{
		if ($values->remember) {
			$this->getUser()->setExpiration('14 days', FALSE);
		} else {
			$this->getUser()->setExpiration('20 minutes', TRUE);
		}

		try {
			$this->getUser()->login($values->username, $values->password);
			$this->redirect(':Admin:BaseBackend:default');

		} catch (Nette\Security\AuthenticationException $e) {
			$form->addError($e->getMessage());
		}
	}


	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('You have been signed out.');
		$this->redirect('in');
	}

}
