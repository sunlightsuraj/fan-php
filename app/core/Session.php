<?php
/**
 * User: suraj
 * Date: 12/17/14
 * Time: 8:20 PM
 */

class Session {
	/**
	 * constructor
	 * session start
	 */

	public static function init() {
		ob_start();
		session_start();
		ob_end_clean();
	}

	/**
	 * function to create session, accepts two param
	 * @param $index_name -> array of session index
	 * @param $index_value -> array of session value
	 */
	public static function sessionCreate($session_data) {
		for($i = 0; $i < count($session_data); $i++){
			$name = $session_data[$i]['name'];
			$value = $session_data[$i]['value'];
			$_SESSION[$name] = $value;
		}
	}

	public static function sessionGet($sessionName) {
		if(isset($_SESSION[$sessionName])) {
			return $_SESSION[$sessionName];
		} else {
			return null;
		}
	}

	public static function sessionDestroy() {
		session_destroy();
	}

	public static function sessionUnset($sessionName) {
		unset($_SESSION[$sessionName]);
	}
}
