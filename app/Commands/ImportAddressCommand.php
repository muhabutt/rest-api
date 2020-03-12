<?php

namespace App\Commands;

use App\Repository\AddressRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class ImportAddressCommand
 * @package App\Commands
 */
class ImportAddressCommand extends Command
{
    /**
     *
     */
    protected function configure()
    {
        $this->setName('ImportAddress')
            ->setDescription('Import data from .dat file and save into address database table!')
            ->setHelp('Custom symphony command');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Importing ...................',
            'Please wait, it might take time because the .dat file is very big',
        ]);

        $data = array();
        $file = fopen("./data/BAF_20191116.dat", "r");
        $index = 0;
        while (!feof($file)) {
            $address = fgets($buffer = $file, 10000);
            $data[$index]['streetName'] = utf8_encode(strstr(substr($address, 102, 134), ' ', true));
            $data[$index]['streetNameAlt'] = utf8_encode(strstr(substr($address, 132, 163), ' ', true));
            $data[$index]['postalCode'] = preg_replace('/[^0-9]/', '', strstr(substr($address, 13, 18), ' ', true));
            $data[$index]['city'] = utf8_encode(strstr(substr($address, 216, 237), ' ', true));
            $data[$index]['cityAlt'] = utf8_encode(strstr(substr($address, 236, 256), ' ', true));
            $data[$index]['minApartmentNo'] = trim(substr($address, 188, 12));
            $data[$index]['maxApartmentNo'] = trim(substr($address, 201, 12));
            $index++;
        }
        $repo = new AddressRepository();
        $status = $repo::bulkInsertAddress($data);
        if($status['status'] === true){
            $output->writeln($status['message']);
        }else{
            $output->writeln($status['message']);
        }



    }

}
