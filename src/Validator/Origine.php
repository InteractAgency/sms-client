<?php
/**
 * Created by PhpStorm.
 * User: gkratz
 * Date: 18/09/2018
 * Time: 15:53
 */

namespace SMSClient\Validator;

/**
 * Class Origine
 * @package SMSClient\Validator
 */
class Origine {
	/**
	 * @param $origine
	 *
	 * Validate an origine string.
	 *
	 * If the originator ('from' field) is invalid, some networks may reject the network
	 * whilst stinging you with the financial cost! While this cannot correct them, it
	 * will try its best to correctly format them.
	 *
	 * @return string
	 */
	public function validate($origine)
	{
		$result = preg_replace('/[^a-zA-Z0-9]/', '', (string) $origine);

		if (preg_match('/[a-zA-Z]/', $origine)) {
			// Max length is 11 chars
			$result = substr($result, 0, 11);
		} else {
			// Remove potential '00' at the beginning
			if ('00' == substr($result, 0, 2)) {
				$result = substr($result, 2);
				$result = substr($result, 0, 15);
			}
		}

		return (string) $result;
	}
}