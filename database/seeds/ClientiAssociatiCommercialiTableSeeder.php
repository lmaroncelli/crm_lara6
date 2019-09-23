<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientiAssociatiCommercialiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$tblMembership  =  DB::connection('old')
    	                ->table('clienti')
    	                ->select('id', 'commerciale')
    	                ->where('commerciale','!=','')
    	                ->get();

    	
    	foreach ($tblMembership as $record) 
    		{
    		$comm_arr = explode(',', $record->commerciale);

    		foreach ($comm_arr as $commerciale) 
    			{
    			$user = User::where('name',$commerciale)->where('type_id','C')->first();
    			if (!is_null($user)) 
    				{
    				DB::connection('mysql')->table('tblClienteAssociatoCommerciale')->insert(['cliente_id' => $record->id ,'user_id' => $user->id]);
    				}
    			}
    		}

    }
}
