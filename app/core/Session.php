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
    public static function sessionCreate($index_name,$index_value) {
        for($i = 0; $i < count($index_name); $i++){
            $name = $index_name[$i];
            $value = $index_value[$i];
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
}
