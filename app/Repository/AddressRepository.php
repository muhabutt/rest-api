<?php


namespace App\Repository;


use App\Core\Database;

class AddressRepository extends Database
{
    private $conn ;
    private $table = 'addresses';

    public function __construct()
    {
        parent::__construct();
        $this->conn = $this->connectDB();
    }

    /**
     * @param string $streetName
     * @return array
     */
    public function getAddressByName($streetName = '')
    {
        //query
        try{
            $query = 'SELECT * FROM ' . $this->table . ' where street_name = :streetName OR street_name_alt = :streetName limit 50';

            //prepare statement
            $statement = $this->conn->prepare($query);

            $statement->bindParam(':streetName', $streetName);

            $statement->execute();
            return [
                'rowCount' => $statement->rowCount(),
                'rows' => $statement->fetchAll(\PDO::FETCH_ASSOC)
            ];
        }catch(\PDOException $e){
            return ['errorCode' => 500];
        }
    }

    /**
     * @param $data
     * Bulk insert
     */
    public function insertAddress($data)
    {
        $query = "INSERT INTO ". $this->table ." (
                       street_name,
                       street_name_alt,
                       postal_code,
                       city,
                       city_alt,
                       min_apartment_no,
                       max_apartment_no
                       ) VALUES "; //Prequery
        $valuesArrayAccordingToDataLenth = array_fill(0, count($data), "(?,?,?,?,?,?,?)");
        $query .=  implode(",",$valuesArrayAccordingToDataLenth);

        try{
            $statement = $this->conn->prepare($query);
            $i = 1;
            foreach($data as $item) { //bind the values one by one
                $statement->bindParam($i++, $item['streetName']);
                $statement->bindParam($i++, $item['streetNameAlt']);
                $statement->bindParam($i++, $item['postalCode']);
                $statement->bindParam($i++, $item['city']);
                $statement->bindParam($i++, $item['cityAlt']);
                $statement->bindParam($i++, $item['minApartmentNo']);
                $statement->bindParam($i++, $item['maxApartmentNo']);
            }
            if($statement->execute()){
                return ['status' => true, 'message' => '.dat file is imported successfully'];
            }else{
                throw new \PDOException();
            }
        }catch(\PDOException $e){
            return ['status' => false, 'message' => 'MYSQL Error ' . $statement->errorCode()];
        }

    }
}
