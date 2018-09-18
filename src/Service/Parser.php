<?php
/**
 * Created by PhpStorm.
 * User: gkratz
 * Date: 18/09/2018
 * Time: 15:39
 */

namespace SMSClient\Service;

/**
 * Class Parser
 * @package SMSClient\Service
 */
class Parser {
	/**
	 * @param $data
	 *
	 * @return array|mixed
	 */
	public function parse($data)
	{
		$data = json_decode($data);

		return $data ? $data : [];
	}
}