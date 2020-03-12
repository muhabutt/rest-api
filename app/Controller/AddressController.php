<?php

namespace App\Controller;

use App\Core\Controller;
use App\Core\Helpers;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;

/**
 * Class AddressController
 * @package App\Controller
 */
class AddressController extends Controller
{
    /**
     * @var mixed|App\Core\Response\Response
     */
    private $response;
    /**
     * @var mixed|App\Models\Address
     */
    private $address;

    /**
     * AddressController constructor.
     * @param Container $container
     * Dependency injection is handled using PHP DI container
     * container is instantiated in the routes class.
     */
    public function __construct(Container $container)
    {
        try {
            $this->response = $container->get('App\Core\Response\Response');
            $this->address = $container->get('App\Models\Address');
        } catch (DependencyException $e) {
            echo 'Class Not found ' . $e->getMessage();
        } catch (NotFoundException $e) {
            echo 'Class Not found ' . $e->getMessage();
        }
    }

    /**
     *Get street by streetName finnish or swedish
     * @param $streetName
     */
    public function streets($streetName)
    {
        //Symphony validator
        $validator = Validation::createValidator();
        $violations = $validator->validate($streetName, [
            new NotBlank()
        ]);

        if (0 !== count($violations)) {
            // validation error
            foreach ($violations as $violation) {
                Helpers::errorResponse404($violation->getMessage());
            }
        }

        $addresses = $this->address->getAddressByName($streetName);

        if (count($addresses) <= 0) {
            //if no data found not paramter is empty: status 400
            Helpers::errorResponse404('Sorry no data found!');
        }

        //if data found
        $this->response::jsonResponse(200, $addresses);
    }
}
