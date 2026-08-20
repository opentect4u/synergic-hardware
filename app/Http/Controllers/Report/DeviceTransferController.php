<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class DeviceTransferController extends Controller
{
    public function Show(Request $request){
		//return DB::connection('mysql_test')->select('show tables;');
		

		return $request;
	}
	
	public function test(Request $request){
		
		// return "hii";
		// mysql_test
		//return DB::connection('mysql_test')->select('show tables;');
		

		
		
	}
}
