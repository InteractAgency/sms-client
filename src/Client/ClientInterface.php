<?php
/**
 * Created by PhpStorm.
 * User: gkratz
 * Date: 18/09/2018
 * Time: 12:03
 */

namespace SMSClient\Client;

/**
 * Interface ClientInterface
 * @package SMSClient\Client
 */
interface ClientInterface {
	/**
	 * @param $to
	 * @param $from
	 * @param $message
	 * @param null $subject
	 *
	 * The client function to send SMS via websms.lu API
	 *
	 * @return mixed
	 */
	public function send($to, $from, $message, $subject = null);

	/**
	 * @param null $current
	 *
	 * @return string
	 */
	public function display($current = null);
}