<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $array = [[
	    	'name' => 'client1',
	    	'email' => 'client1@server.com',
	    	'gender' => 'M',
	    	'phone' => '9999999999',
	    	'address' => 'Address',
	    	'nationality' => 'nationality',
	    	'date_of_birth' => '1969-12-31',
	    	'education' => 'education',
	    	'preferred_contact' => 'email'		
    	],
    	[
	    	'name' => 'client2',
	    	'email' => 'client2@server.com',
	    	'gender' => 'F',
	    	'phone' => '9999999999',
	    	'address' => 'Address',
	    	'nationality' => 'nationality',
	    	'date_of_birth' => '1969-12-31',
	    	'education' => 'education',
	    	'preferred_contact' => 'email'
    	],
    	[
	    	'name' => 'client3',
	    	'email' => 'client3@server.com',
	    	'gender' => 'M',
	    	'phone' => '9999999999',
	    	'address' => 'Address',
	    	'nationality' => 'nationality',
	    	'date_of_birth' => '1969-12-31',
	    	'education' => 'education',
	    	'preferred_contact' => 'email'
    	]];
    	DB::table('clients')->insert($array);
    }
}
