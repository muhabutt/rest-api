<?php

namespace App\Controller;

use App\Core\Controller;
use App\Core\Helpers;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;

class AddressController extends Controller
{
    private $response;
    private $address;

    /**
     * AddressController constructor.
     * @param Container $container
     * Dependency injection is handled using PHPDI container
     * container is instantiated in the routes class.
     */
    public function __construct(Container $container)
    {
        try {
            $this->response = $container->get('App\Core\Response\Response');
            $this->address = $container->get('App\Models\Address');
        } catch (DependencyException $e) {
        } catch (NotFoundException $e) {
            echo 'Class Not found ' . $e->getMessage();
        }
    }

    /**
     * Index node is mandatory, because the way i have implemented my MVC framwork
     */


    /**
     *Get street by streetName finnish or swedish
     * @param null $streetName
     */
    public function streets($streetName = null)
    {
        $addresses = $this->address->getAddressByName($streetName);

        if (count($addresses) <= 0) {
            //if no data found not paramter is empty: status 400
            $errors = [
                [
                    'id' => Helpers::generateUniqueID(),
                    'status' => '400',
                    'title' => 'Parameter not given',
                    'detail' => 'Parameter, search not given or empty'
                ]
            ];
            $this->response::sendJson400Response(400, $errors);
        }

        //if data found
        $this->response::sendJson200Response(200, $addresses);
    }
}
