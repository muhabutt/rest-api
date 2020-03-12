<?php
namespace App\Core;

use DI\Container;

/**
 * Class Routes
 * Description: This class will extract invoked url, and extract controller, function and parameters.
 * Attacks prevention: htmlspecialchars, validate routes check.
 * @package App\Core
 */
class Routes
{

    /**
     * @var string
     */
    protected $controller = '';

    /**
     * @var mixed|string
     */
    protected $method = '';

    /**
     * @var array
     */
    protected $params = [];

    /**
     * This constructor function it gets extracted url
     * index[0] => is the controller constructor will checks if controller exists than instantiate the class
     * index[1] => is the function in controller constructor checks if function exists
     * index[2] and [3] or 4 => are the parameters.
     * finally constructor call the function with its paramters
     * if there is any error constructor call response route error function
     * Routes constructor.
     *
     */
    public function __construct()
    {
        try {
            $url = $this->parseUrl();

            //since we dont have a default route so if controller is not defined in url than
            // we return route error response
            if(isset($url[0])){
                if (file_exists('../app/Controller/' . ucfirst($url[0]) . 'Controller.php')) {
                    $this->controller = ucfirst($url[0]) . 'Controller';
                    require_once('../app/Controller/' . $this->controller . '.php');
                    $class = ('App\\Controller\\' . $this->controller);
                    $this->controller = new $class(new Container);
                    unset($url[0]); // remove controller index
                }
                else {
                    Helpers::errorResponse500($url[0] . ' not found!');
                }
            }else{
                Helpers::errorResponse500('api not found!');
            }

            // Check if url contains method, which is index number 1 if not than error response
            if (isset($url[1])) {
                //Check if method exists in controller
                if (method_exists($this->controller, $url[1])) {
                    $this->method = $url[1];
                    unset($url[1]); // remove method part
                } else {
                    Helpers::errorResponse500($url[1] . ' not found!');
                }
            }
            else{
                Helpers::errorResponse500('api not found!');
            }

            //Now remaining index inside url array are parameters
            $this->params = $url ? array_values($url) : [];

            //if controller is found with method and parameters, now call function and if no success
            //than error response else call controller api
            if (!call_user_func_array([$this->controller, $this->method], $this->params)) {
                throw new \Exception();
            }

        } catch (\Throwable $e) {
            Helpers::errorResponse500('api not found!' . $e->getMessage());
        }

    }

    /**
     * Parse url this function will extract the url into array
     * index[0] => controller
     * index[1] => controller node
     * index[2] and so on will be  => parameters
     * @return array|null
     */
    protected function parseUrl()
    {
        $url = null;

        if (isset($_GET['url'])) {
            $url = explode('/', filter_var(rtrim(Helpers::noSpecialCharacters($_GET['url']), '/'), FILTER_SANITIZE_URL));
            if ($this->validateRoutes($url[0])) {
                $cleanUrl = [];
                foreach ($url as $u) {
                    $cleanUrl[] = Helpers::noHtmlXHTMLXML1Characters($u);
                }
                return $cleanUrl;
            } else {
                Helpers::errorResponse500('Route not found');
            }
        }
    }



    /**
     * This function checks for the routes
     * route parameter is the index[0] which is the controller
     * so if route match return true else false
     * @param $route
     * @return bool
     */
    public function validateRoutes($route)
    {
        switch ($route) {

            case 'address': /* address routes */
                return true;
                break;

            // don't accept any other values
            default:
                return false;
        }
    }
}
