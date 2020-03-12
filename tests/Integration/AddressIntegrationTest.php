<?php


namespace Tests\Integration;


use App\Models\Address;
use DI\Container;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use Mockery;

/**
 * Class AddressIntegrationTest
 * @package Tests\Integration
 */
class AddressIntegrationTest extends TestCase
{
    /**
     * @var mixed|App\Models\Address
     */
    private $address;

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function setUp(): void
    {
        parent::setUp();
        //Load environmental variables for testing
        $dotenv = Dotenv::createMutable(dirname(__DIR__));
        $dotenv->load();
        //Dependency container , using PHP DI package
        $container = new Container();
        $this->address = $container->get('App\Models\Address');;
    }

    /**
     * Test getAddAddressname which is calling AddressRepository Static method
     * Using Mockery to mock AddressRepository Class, and partialy mock the
     * AddressRepository class, in order to mock static getAddressByName function
     *
     */
    public function test_get_street_by_street_name_finnish_or_swedish(){

        //fake array returned from getAddressbyName Address repository
        $mockAddress = array();
        $mockAddress['rowCount'] = 1;
        $mockAddress['rows'][0] = [
            'id' => 1,
            'street_name' => 'Peijaksentie',
            'street_name_alt' => 'Peijaksentie_swedish',
            'postal_code' => '01360',
            'city' => 'Vantaa',
            'city_alt' => 'Vantaa_swedish',
            'min_apartment_no' => '1',
            'max_apartment_no' => '15'
        ];

        $addressRepoClass = Mockery::mock('App\Repository\AddressRepository')->makePartial();

        $addressRepoClass->shouldReceive('getAddressByName')
            ->andReturn($mockAddress);


        //Passing mocked Address Repository to address
        $testAddresses = new Address($addressRepoClass);

        $addresses = $testAddresses->getAddressByName('Peijaksentie');
        $this->assertEquals('Peijaksentie',$addresses[0]['attributes']['streetName']);
    }

    /**
     * Close Mocker when teardown
     */
    public function tearDown() : void
    {
        Mockery::close();
    }
}
