<?php

namespace App\Model;

use Nette,
	Nette\Utils\Strings,
	Nette\Security\Passwords;


/**
 * Users management.
 */
class UserManager extends \App\BaseModel implements Nette\Security\IAuthenticator
{
	const
		TABLE_NAME = 'cms_user',
		COLUMN_ID = 'id_user',
		COLUMN_NAME = 'login',
		COLUMN_PASSWORD_HASH = 'password',
		COLUMN_ROLE = 'role';


	/**
	 * Performs an authentication.
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;

		$row = $this->database->select("*")->from(self::TABLE_NAME)->where(self::COLUMN_NAME." = %s", $username)->fetch();

		if (!$row) {
			throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);

		} elseif (!Passwords::verify($password, $row[self::COLUMN_PASSWORD_HASH])) {
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);

		} elseif (Passwords::needsRehash($row[self::COLUMN_PASSWORD_HASH])) {
			$row->update(array(
				self::COLUMN_PASSWORD_HASH => Passwords::hash($password),
			));
		}

		$arr = $row->toArray();
		unset($arr[self::COLUMN_PASSWORD_HASH]);
		return new Nette\Security\Identity($row[self::COLUMN_ID], $row[self::COLUMN_ROLE], $arr);
	}


	/**
	 * Adds new user.
	 * @param  string
	 * @param  string
	 * @return void
	 */
	public function add($username, $password)
	{
		$this->database->table(self::TABLE_NAME)->insert(array(
			self::COLUMN_NAME => $username,
			self::COLUMN_PASSWORD_HASH => Passwords::hash($password),
		));
	}

}
