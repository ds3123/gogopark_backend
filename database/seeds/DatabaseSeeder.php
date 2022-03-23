<?php

use Illuminate\Database\Seeder;



class DatabaseSeeder extends Seeder {

    public function run(){

        $this->call('CustomersSeeder') ;
        $this->call('CustomerRelationSeeder') ;

        $this->call('PetsSeeder') ;

        $this->call('BathesSeeder') ;
        $this->call('BasicsSeeder') ;
        $this->call('BeautiesSeeder') ;

    }

}








