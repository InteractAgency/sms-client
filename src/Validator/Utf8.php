<?php
/**
 * Created by PhpStorm.
 * User: gkratz
 * Date: 18/09/2018
 * Time: 15:17
 */

namespace SMSClient\Validator;

/**
 * Class Utf8
 * @package SMSClient\Validator
 */
class Utf8 {
	/**
	 * @param string $from
	 *
	 * @return bool
	 */
	public function validateFrom($from = '') {
		if (!is_numeric($from) && !mb_check_encoding($from, 'UTF-8')) {
			trigger_error('$from needs to be a valid UTF-8 encoded string');
			return false;
		}

		return true;
	}

	/**
	 * @param string $subject
	 *
	 * @return bool
	 */
	public function validateSubject($subject = '') {
		if ($subject && !mb_check_encoding($subject, 'UTF-8')) {
			trigger_error('$subject needs to be a valid UTF-8 encoded string');
			return false;
		}

		return true;
	}

	/**
	 * @param string $message
	 *
	 * @return bool
	 */
	public function validateMessage($message = '') {
		if (!mb_check_encoding($message, 'UTF-8')) {
			trigger_error('$message needs to be a valid UTF-8 encoded string');
			return false;
		}

		return true;
	}
}