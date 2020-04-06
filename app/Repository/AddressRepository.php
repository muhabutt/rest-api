<?php

namespace App\Repository;


use App\Core\Database;

/**
 * Class AddressRepository
 * handles all database related functionality for address model
 * @package App\Repository
 */
class AddressRepository extends Database
{
    /**
     * @var \PDO
     */
    protected static $conn;
    /**
     * @var string
     */
    protected static $table = 'addresses';

    /**
     * AddressRepository constructor.
     */
    public function __construct()
    {
        parent::__construct();
        self::$conn = $this->connectDB();
    }

    /**
     * Get address details by streetName
     * @param $streetName
     * @return array
     */
    public static function getAddressByName($streetName)
    {
        $street_name = $streetName;
        $street_name_alt = $streetName;
        //query
        try {
            $query = /** @lang text */
                'SELECT * FROM ' . self::$table . ' where street_name = :streetName OR street_name_alt = :street_name_alt limit 50';

            //prepare statement
            $statement = self::$conn->prepare($query);

            $statement->bindParam(':streetName', $street_name);
            $statement->bindParam(':street_name_alt', $street_name_alt);

            $statement->execute();
            return [
                'rowCount' => $statement->rowCount(),
                'rows' => $statement->fetchAll(\PDO::FETCH_ASSOC)
            ];
        } catch (\PDOException $e) {
            return ['errorCode' => 500];
        }
    }

    /**
     * @param $data
     * @return array
     */
    public static function insertAddress($data)
    {
        $query = /** @lang text */
            "INSERT INTO " . self::$table . " 
        SET 
        street_name = :streetName ,
        street_name_alt = :streetNameAlt ,
        postal_code = :postalCode ,
        city = :city,
        city_alt = :cityAlt,
        min_apartment_no = :minApartmentNo,
        max_apartment_no = :maxApartmentNo
        "; //Prequery

        try {
            $statement = self::$conn->prepare($query);
            //bind the values one by one
            $statement->bindParam(':streetName', $data['streetName']);
            $statement->bindParam('streetNameAlt', $data['streetNameAlt']);
            $statement->bindParam(':postalCode', $data['postalCode']);
            $statement->bindParam(':city', $data['city']);
            $statement->bindParam(':cityAlt', $data['cityAlt']);
            $statement->bindParam(':minApartmentNo', $data['minApartmentNo']);
            $statement->bindParam(':maxApartmentNo', $data['maxApartmentNo']);

            if ($statement->execute()) {
                return ['status' => true, 'message' => '.dat file is imported successfully'];
            } else {
                throw new \PDOException();
            }
        } catch (\PDOException $e) {
            return ['status' => false, 'message' => 'MYSQL Error ' . $statement->errorCode()];
        }
    }

    /**
     * Insert bulk data in to address table
     * @param $data
     * @return array
     */
    public static function bulkInsertAddress($data)
    {
        $query = /** @lang text */
            "INSERT INTO " . self::$table . " (
                       street_name,
                       street_name_alt,
                       postal_code,
                       city,
                       city_alt,
                       min_apartment_no,
                       max_apartment_no
                       ) VALUES "; //Prequery

        $valuesArrayAccordingToDataLenth = array_fill(0, count($data), "(?,?,?,?,?,?,?)");
        $query .= implode(",", $valuesArrayAccordingToDataLenth);

        try {
            $statement = self::$conn->prepare($query);
            $i = 1;
            foreach ($data as $item) { //bind the values one by one
                $statement->bindParam($i++, $item['streetName']);
                $statement->bindParam($i++, $item['streetNameAlt']);
                $statement->bindParam($i++, $item['postalCode']);
                $statement->bindParam($i++, $item['city']);
                $statement->bindParam($i++, $item['cityAlt']);
                $statement->bindParam($i++, $item['minApartmentNo']);
                $statement->bindParam($i++, $item['maxApartmentNo']);
            }
            if ($statement->execute()) {
                return ['status' => true, 'message' => '.dat file is imported successfully'];
            } else {
                throw new \PDOException();
            }
        } catch (\PDOException $e) {
            return ['status' => false, 'message' => 'MYSQL Error ' . $statement->errorCode()];
        }
    }
}
