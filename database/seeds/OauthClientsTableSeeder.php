<?php

use Illuminate\Database\Seeder;

class OauthClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    	DB::table('oauth_clients')->insert([
	    	'id' => 'clients_id.sddd3ed8fdsfdfgsdfge',
	    	'secret' => 'secret.sdRxg#@&!Dgdfffg@#%$fsdf',
	    	'name' => 'Test Client',
    	]);
    }
}
