<?php
/**
 * User: suraj
 * Date: 1/14/15
 * Time: 7:21 PM
 */

class App
{
    protected $controller = 'home';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();
	    $i = 0;
	    if(isset($url[$i])) {
		    if(file_exists('app/controllers/'.$url[$i].'.php')) {
			    $this->controller = $url[$i];
			    unset($url[$i]);
			    $i++;
		    }
	    }

	    require_once('app/controllers/'.$this->controller.'.php');

	    $this->controller = new $this->controller;
	    if(isset($url[$i])){
		    if(method_exists($this->controller,$url[$i]) && is_callable([$this->controller, $url[$i]])){
			    $this->method = $url[$i];
			    unset($url[$i]);
		    }
	    }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);

    }

    public function parseUrl() {
        if(isset($_GET['url'])){
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        } else
        	return [];
    }
}
