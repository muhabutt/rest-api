# PHP Simple and custom MVC framework, With PHPUnit Testing, Symphony console package, Symphony validator, Mockery

### PHPUnit Code covrage is used to check how much php testing is done and on which class and function.

- The folder for php reports is phpUnitReports

### Things to do before calling the api's

- Create .env file copy .exampleENV file and change variables according to your needs.
- PHP character set should be UTF-8.
- PHP memory_limit=default or more, when running command for importing .dat file into database.
- MYSql max_allowed_packet=default, when running command for importing .dat file into database.
- Composer install, or composer update, to install PHPUnit, symfony/console

### For running the test's
- Create tests/.env file copy .exampleENV file and change variables according to your needs. this is testing environments.
- You need to create the database and create the address table.
- Run php console\bin ImportAddress

### For phpunit coverage html
- vendor\bin\phpunit --coverage-html FolderName

### Folder structure and description
``` html
app
    Commands
        ImportAddressCommand.php => ImportAddressCommand in order to run e.g: php bin\console ImportAddress
    Config
        Config.php => Class through which one can get .env variales
    Controller
        AddressController => Controller which handles api nodes
    Core
        Request
            IRequest => Handles Request Body
            Request => Implements IRequest Body, and other Request Related functions
        Response
            Response => Handles responses currently only json responses
        Controller => Base Controller
        Database => handles database connection
        Helpers => Application Helper function such as generateUniqueID
        Routes => Handles routes, extract controller, method, parameters.
    Models
        Address => Address table model
    Repository
        AddressRepository => Handles database queries for addresses table
    Views => currently not view.
    start => application bootstrap file.            
bin
    console => Handle commands. in order to run command e.g:php bin\console CommandName
data
    contains .dat file
public 
      css => css files
      images => images files
      js => js files
      .htaccess
      index.php => includes start.php      
tests
    Integration
        PHPUnit Integration test
    Unit
        PHPUnit tests                                   
    .envExampleEnv => environment variables example for testing
.gitignore file
.envExampleEnv => environment variables example for application
composer.json
phpunit.xml => contains phpunit configration
Readme
``` 
      
```php

CREATE TABLE `addresses` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `street_name` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `street_name_alt` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `postal_code` varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `city_alt` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `min_apartment_no` varchar(10) CHARACTER SET utf8mb4 DEFAULT NULL,
  `max_apartment_no` varchar(10) CHARACTER SET utf8mb4 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

```
### api routes 
``` html
- https://your-url.com/address/streets/finnsih_street_name or swedish_street_name
for e.g https://your-url.com/address/streets/peijsksentie
```

### api output
```
// 20200309211042
// http://api-test-dev.com/address/streets/peijaksentie

{
  "data": [
    {
      "type": "street",
      "id": "1",
      "attributes": {
        "streetName": "peijaksentie",
        "streetNameAlt": "peijsksentie",
        "postalCode": "01360",
        "city": "vantaa",
        "cityAlt": "vanda",
        "minApartmentNo": "10",
        "maxApartmentNo": "10"
      }
    }
  ]
}

```
## How to create cron job on linux
```    
crontab -e (will create or edit cron jobs)

Cron Syntax => "* * * * * cd /path-to-project && php bin/console ImportAddress >> /dev/null 2>&1" 

One can define *(@hourly) *(@Once everyday) *(@daily) *(weekly) * (@monthly) *(@annualy) ...

for e.g:
mid night
0 0 * * *  root /usr/bin/php /var/www/rest-api/bin/console ImportAddress

```
