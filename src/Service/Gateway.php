<?php
/**
 * Created by PhpStorm.
 * User: gkratz
 * Date: 18/09/2018
 * Time: 14:15
 */

namespace SMSClient\Service;

/**
 * Class Gateway
 * @package SMSClient\Service
 */
class Gateway {
	/**
	 * string API URL
	 */
	const API_URL = 'https://www.websms.lu/api/send';

	/**
	 * boolean SSL VERIFY
	 */
	const SSL_VERIFY = false;

	/**
	 * @param array $data
	 *
	 * @return bool|mixed|string
	 */
	public function call(array $data)
	{
		$post = implode('', array_map(function ($value, $key) {
			return sprintf("&%s=%s", $key, $value);
	    	} , $data, array_keys($data)));

		// If available, use CURL
		if (function_exists('curl_version')) {
			$ch = curl_init(self::API_URL);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

			if (!self::SSL_VERIFY) {
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			}

			$result = curl_exec($ch);
			curl_close($ch);
		} else if (ini_get('allow_url_fopen')) {
			// No CURL available so try to file_get_contents
			$options = [
				'http' => [
					'method' => 'POST',
					'header' => 'Content-type: application/x-www-form-urlencoded',
					'content' => $options,
				],
			];

			$context = stream_context_create($opts);

			$result = file_get_contents(self::API_URL, false, $context);
		} else {
			// No way of sending a HTTP post :(
			return false;
		}

		return $result;
	}
}
