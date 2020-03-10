<?php


namespace Tests\Integration;


use App\Models\Address;
use App\Repository\AddressRepository;
use DI\Container;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

class AddressIntegrationTest extends TestCase
{
    private $address;
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
     * Test search street by street name swedish or finnish
     */
    public function test_get_street_by_street_name_finnish_or_swedish(){

        /**
         * Mocker Address repository class to return data which is needed
         * that is rowCount, and rows(Assoc), than insert dependency to the
         * address class which is calling getAddressByName
         */
        $dbMock = $this->getMockBuilder(AddressRepository::class)
            ->onlyMethods(['getAddressByName'])
            ->getMock();
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
        //Here adding return data to getAddressbyName method
        $dbMock->method('getAddressByName')->willReturn($mockAddress);

        //Passing mocked Address Repository to address
        $testAddresses = new Address($dbMock);

        $addresses = $testAddresses->getAddressByName('Peijaksentie');
        $this->assertEquals('Peijaksentie',$addresses[0]['attributes']['streetName']);
    }
}
