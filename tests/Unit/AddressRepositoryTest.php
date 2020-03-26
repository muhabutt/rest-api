<?php
namespace Tests\Unit;

use App\Repository\AddressRepository;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;


/**
 * Class AddressRepositoryTest
 * In order to run test to AddressRepository data should available in the database
 * @package Tests\Unit
 */
class AddressRepositoryTest extends TestCase {

    private $repo;

    /**
     * Function run before tests
     */
    public function setUp(): void
    {
        parent::setUp();

        //Load environmental variables for testing
        $dotenv = Dotenv::createMutable(dirname(__DIR__));
        $dotenv->load();
        $this->repo = new AddressRepository();
    }

    /**
     * Assert to check can get address detail by street name
     * Assert to check detail data array keys
     *
     */
    public function test_can_get_address_detail_by_street_name(){
        $data = $this->repo::getAddressByName ('Peijaksentie');
        $this->assertIsArray ($data);

        foreach ($data['rows'] as $row){
            $this->assertArrayHasKey('street_name', $row);
            $this->assertArrayHasKey('street_name_alt', $row);
            $this->assertArrayHasKey('city', $row);
            $this->assertArrayHasKey('city_alt', $row);
            $this->assertArrayHasKey('min_apartment_no', $row);
            $this->assertArrayHasKey('max_apartment_no', $row);
        }
        $this->assertArrayHasKey ('rowCount', $data);
        $this->assertGreaterThan (0, $data['rowCount']);
        foreach ($data['rows'] as $row){
            $this->assertArrayHasKey('street_name', $row);
            $this->assertArrayHasKey('street_name_alt', $row);
            $this->assertArrayHasKey('city', $row);
            $this->assertArrayHasKey('city_alt', $row);
            $this->assertArrayHasKey('min_apartment_no', $row);
            $this->assertArrayHasKey('max_apartment_no', $row);
        }
    }

    /**
     * Assert to check if number of rows are greater than zero return
     * from getAddress By Name function
     */
    public function test_can_get_address_detail_by_street_name_number_of_rows_are_greater_than_zero(){
        $data = $this->repo::getAddressByName ('Peijaksentie');
        $this->assertIsArray ($data);
        $this->assertArrayHasKey ('rowCount', $data);
        $this->assertGreaterThan (0, $data['rowCount']);
    }

    /**
     * Assert to check if number of rows are not greater than zero return
     * from getAddress By Name function
     */
    public function test_can_get_address_detail_by_street_name_number_of_rows_are_not_greater_than_zero(){
        $data = $this->repo::getAddressByName ('XXXXXXXXXX');
        $this->assertIsArray ($data);
        $this->assertArrayHasKey ('rowCount', $data);
        $this->assertEquals(0, $data['rowCount']);
    }
}
