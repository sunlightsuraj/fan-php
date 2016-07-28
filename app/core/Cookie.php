<?php

/**
 * User: suraj
 * Date: 6/26/16
 * Time: 2:57 AM
 */
class Cookie
{
	public static function setCookie($data) {
		for($i = 0; $i < count($data); $i++){
			$name = $data[$i]['name'];
			$value = $data[$i]['value'];
			$time = $data[$i]['time'];
			setcookie($name, $value, $time);
		}
	}

	public static function getCookie($name) {
		if(isset($_COOKIE[$name])) {
			return $_COOKIE[$name];
		} else {
			return null;
		}
	}

	public static function cookieUnset($name) {
		//unset($_COOKIE[$name]);
		setcookie($name,'',0);
	}
}