<?php

namespace App\Commands;

use App\Repository\AddressRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class ImportAddressCommand extends Command
{
    protected function configure()
    {
        $this->setName('ImportAddress')
            ->setDescription('Import data from .dat file and save into address database table!')
            ->setHelp('Custom symphony command');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $addresses = file("./data/BAF_20191116.dat");
        $data = array();
        $index = 0;
        foreach($addresses as $address){
            $data[$index]['streetName'] = utf8_encode(strstr(substr($address,102,134),' ',true));
            $data[$index]['streetNameAlt'] = utf8_encode(strstr(substr($address,132,163),' ',true));
            $data[$index]['postalCode'] = preg_replace('/[^0-9]/','',strstr(substr($address,13,18),' ',true));
            $data[$index]['city'] = utf8_encode(strstr(substr($address,216,237),' ',true));
            $data[$index]['cityAlt'] = utf8_encode(strstr(substr($address,236,256),' ',true));
            $data[$index]['minApartmentNo'] = trim(substr($address,188,12));
            $data[$index]['maxApartmentNo'] = trim(substr($address,201,12));
            $index++;
        }
        $repo = new AddressRepository();
        $repo->insertAddress($data);

    }

}
