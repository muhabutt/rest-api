<?php
namespace Tests\Unit;

use App\Models\Address;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

/**
 * Class AddressUnitTest
 * @package Tests\Unit
 */
class AddressUnitTest extends TestCase {

    /**
     * @var mixed|Address
     */
    private $address;

    /**
     * Function run before tests
     */
    public function setUp(): void
    {
        parent::setUp();
        //Load environmental variables for testing
        $dotenv = Dotenv::createMutable(dirname(__DIR__));
        $dotenv->load();
        //Dependency container , using PHP DI package
        $container = new Container();
        try {
            $this->address = $container->get ('App\Models\Address');
        } catch (DependencyException $e) {
            echo 'Class Not found ' . $e->getMessage ();
        } catch (NotFoundException $e) {
            echo 'Class Not found ' . $e->getMessage ();
        }
    }

    /**
     * Test set Id method
     */
    public function test_set_address_id(){
        $this->address->setId(1);
        $this->assertEquals($this->address->getId(), 1);
    }

    /**
     * Test set street name method
     */
    public function test_set_address_street_name(){
        $this->address->setStreetName('tikkurilantie');
        $this->assertEquals($this->address->getStreetName(), 'tikkurilantie');
    }

    /**
     * Test set street name alt method
     */
    public function test_set_address_street_name_alt(){
        $this->address->setStreetNameAlt('tikkurilantie_swedish');
        $this->assertEquals($this->address->getStreetNameAlt(), 'tikkurilantie_swedish');
    }

    /**
     * Test set postal code alt method
     */
    public function test_set_address_postal_code(){
        $this->address->setPostalCode('01360');
        $this->assertEquals($this->address->getPostalCode(), '01360');
    }

    /**
     * Test set city alt method
     */
    public function test_set_address_city(){
        $this->address->setCity('Vantaa');
        $this->assertEquals($this->address->getCity(), 'Vantaa');
    }

    /**
     * Test set city alt alt method
     */
    public function test_set_address_city_alt(){
        $this->address->setCityAlt('Vantaa_swedish');
        $this->assertEquals($this->address->getCityAlt(), 'Vantaa_swedish');
    }

    /**
     * Test set min apartment no alt method
     */
    public function test_set_min_apartment_no(){
        $this->address->setMinApartmentNo('1');
        $this->assertEquals($this->address->getMinApartmentNo(), '1');
    }

    /**
     * Test set max apartment no alt method
     */
    public function test_set_max_apartment_no(){
        $this->address->setMaxApartmentNo('1');
        $this->assertEquals($this->address->getMaxApartmentNo(), '1');
    }
}
