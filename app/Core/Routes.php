<?php
namespace App\Core;
use App\Core\Response\Response;
use DI\Container;

class Routes{

	protected $controller = '';

	protected $method = '';

	protected $params = [];

	public function __construct()
	{

	    try{
            $url = $this->parseUrl();
            if(!empty($url)){
                //print_r($url);
                if(file_exists('../app/Controller/'. ucfirst($url[1]) . 'Controller.php'))
                {
                    $this->controller = ucfirst($url[1]) . 'Controller';
                    unset($url[0]);
                    unset($url[1]);
                }

                require_once('../app/Controller/'. $this->controller . '.php');
                $class = ('App\\Controller\\'.$this->controller);

                $this->controller = new $class(new Container);

                if(isset($url[2]))
                {
                    if(method_exists($this->controller, $url[2]))
                    {
                        $this->method = $url[2];
                        unset($url[2]);
                    }
                }
                //print_r($url);

                $this->params = $url ? array_values($url) : [];

                //print_r($this->params);

                if(!call_user_func_array([$this->controller, $this->method], $this->params)){
                    throw new \Exception();
                }
            }else{
                throw new \Exception();
            }
        }catch(\Throwable $e){
	        Response::sendJsonRouteExceptionResponse();
        }

	}

	protected function parseUrl()
	{
        $url = null;

		if(isset($_GET['url']))
		{
		    return $url = explode('/',filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));

		}

	}
}
