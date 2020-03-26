<?php
namespace Tests\Unit;

use App\Config\Config;
use App\Core\Database;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;


/**
 * Class DatabaseUnitTest
 * @package Tests\Unit
 */
class DatabaseUnitTest extends TestCase {

    /**
     * Function run before tests
     */
    public function setUp(): void
    {
        parent::setUp();
        //Load environmental variables for testing
        $dotenv = Dotenv::createMutable(dirname(__DIR__));
        $dotenv->load();
    }

    /**
     * Test if user can connect to database
     * the database credential are hidden in env file
     */
    public function test_can_connect_to_database(){
        $db = new Database();
        $conn = $db->connectDB ();
        $this->assertInstanceOf ('PDO', $conn);
    }
}
