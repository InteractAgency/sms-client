<?php
/**
 * Created by PhpStorm.
 * User: gkratz
 * Date: 18/09/2018
 * Time: 12:03
 */

namespace SMSClient\Client;

use SMSClient\Authentication\Auth;
use SMSClient\Service\Gateway;
use SMSClient\Service\Parser;
use SMSClient\Validator\Origine;
use SMSClient\Validator\Utf8;

/**
 * Class Client
 * @package SMSClient\Client
 */
class Client implements ClientInterface {
	/**
	 * @var Auth
	 */
	private $credentials;

	/**
	 * @var Gateway
	 */
	private $gateway;

	/**
	 * @var Utf8
	 */
	private $utf8Validator;

	/**
	 * @var Origine
	 */
	private $origineValidator;

	/**
	 * @var Parser
	 */
	private $parser;

	/**
	 * @var array
	 */
	private $current;

	/**
	 * Client constructor.
	 *
	 * @param string $login
	 * @param string $password
	 */
	public function __construct($login = '', $password = '')
	{
		$this->credentials = new Auth($login, $password);
		$this->gateway = new Gateway();
		$this->utf8Validator = new Utf8();
		$this->origineValidator = new Origine();
		$this->parser = new Parser();
	}

	/**
	 * @param $to
	 * @param $from
	 * @param $message
	 * @param null $subject
	 *
	 * The client function to send SMS via websms.lu API
	 *
	 * @return array|bool|mixed
	 */
	public function send($to, $from, $message, $subject = null)
	{
		// Validate UTF8
		if (!$this->utf8Validator->validateFrom($from) ||
		    !$this->utf8Validator->validateSubject($subject) ||
		    !$this->utf8Validator->validateMessage($message)) {
			return false;
		}

		// Validate Origine
		$from = $this->origineValidator->validate($from);

		$response = $this->gateway->call([
			'from' => urlencode($from),
			'to' => $to,
			'subject' => urlencode($subject),
			'text' => urlencode($message),
			'username' => $this->credentials->getLogin(),
			'password' => $this->credentials->getPassword(),
		]);

		$this->current = $this->parser->parse($response);

		return empty($this->current) ? false : $this->current;
	}

	/**
	 * @param null $current
	 *
	 * Display a brief overview of a sent message.
	 *
	 * Useful for debugging and quick-start purposes.
	 *
	 * @return string
	 */
	public function display($current = null)
	{
		$info = (!$current) ? $this->current : $current;

		if (!$info) {
			return 'Cannot display an overview of this response';
		}

		$status = ('0' !== $info->statusCode) ? 'There was an error sending your message' : 'Your message was saved for sending';

		$result = $status."\n";
		$result .= '  '.str_pad('Status', 8, ' ').'   ';

		if ('0' === $info->statusCode) {
			$result .= str_pad('Message ID', 10, ' ').'   ';
			$result .= str_pad('Parts', 10, ' ').'   ';
			$result .= str_pad('Price', 8, ' ').'   ';
			$result .= str_pad('Balance', 10, ' ').'   ';
		}

		$result .= str_pad('Response', 10, ' ')."\n";
		$result .= '  '.str_pad($info->statusCode, 8, ' ').'   ';

		if ('0' === $info->statusCode) {
			$result .= str_pad($info->message_id, 10, ' ').'   ';
			$result .= str_pad($info->smsParts, 10, ' ').'   ';
			$result .= str_pad($info->messagePrice, 8, ' ').'   ';
			$result .= str_pad($info->remainingBalance, 10, ' ').'   ';
		}

		$result .= str_pad($info->statusText, 10, ' ')."\n";

		return $result;
	}
}