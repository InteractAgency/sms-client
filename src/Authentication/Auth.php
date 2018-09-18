<?php
/**
 * Created by PhpStorm.
 * User: gkratz
 * Date: 18/09/2018
 * Time: 12:02
 */

namespace SMSClient\Authentication;

/**
 * Class Auth
 * @package SMSClient\Authentication
 */
class Auth {
	/**
	 * @var string
	 */
	private $login;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * Auth constructor.
	 *
	 * @param string $login
	 * @param string $password
	 */
	public function __construct($login = '', $password = '')
	{
		$this->login = $login;
		$this->password = $password;
	}

	/**
	 * @return string
	 */
	public function getLogin()
	{
		return $this->login;
	}

	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}
}