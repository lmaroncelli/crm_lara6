<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	


    	$tblMembership  =  DB::connection('old')
    	                ->table('membership')
    	                ->select(DB::raw('membership.id, concat(membership.first_name," ",membership.last_name) as name, membership.username, membership.email, membership.id_tipo as type_id'))
    	                ->get();

    	$tblMembership = collect($tblMembership)->map(function($x){ return (array) $x; })->toArray(); 

    	DB::connection('mysql')->table('users')->truncate();
    	
    	foreach ($tblMembership as $member) 
    		{
    		$member['password'] = bcrypt(strtolower($member['username']));
    	  DB::connection('mysql')->table('users')->insert($member);
    		}




    }
}
