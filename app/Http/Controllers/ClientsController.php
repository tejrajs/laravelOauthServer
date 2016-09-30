<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use Dingo\Api\Routing\Helpers;
use App\Clients;

class ClientsController extends Controller
{
	
// 	use Helpers;
	
// 	public function __construct()
// 	{
// 		// Only apply to the index method.
// 		$this->scopes('read_client_data', ['only' => ['index']]);
	
// 		// Apply to every method except the store method.
// 		$this->scopes('read_client_data', ['except' => 'store']);
	
// 		// Apply only to the store method.
// 		$this->scopes('write_client_data', ['only' => ['store']]);
// 	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    	$client =  Clients::paginate();
    	return response(array(
    			'error' => false,
    			'clients' => $client,
    	),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    	$validator = Validator::make($request->all(), [
    			'name' => 'required|max:255',
    			'email' => 'required|email',
    	]);
    	if ($validator->fails()) {
    		return response(array(
    				'error' => true,
    				'message' => $validator->errors()->all(),
    		),400);
    	}else{
    		$client = Clients::create($request->all());
	    	return response(array(
	    			'error' => false,
	    			'message' => ['Product created successfully'],
	    			'data' => $client
	    	),200);
    	}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    	$client =  Clients::findOrFail($id);
    	return response(array(
    			'error' => false,
    			'client' => $client,
    	),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {    	
    	$validator = Validator::make($request->all(), [
    			'name' => 'required|max:255',
    			'email' => 'required|email',
    	]);
    	if ($validator->fails()) {
    		return response(array(
    				'error' => true,
    				'message' => $validator->errors()->all(),
    		),400);
    	}else{
    		$client = Clients::find($id);
    		if(empty($client)){
    			return response(array(
    					'error' => true,
    					'message' => ['Client Not Found'],
    			),400);
    		}else{
		    	$client->update($request->all());
		    	return response(array(
		    			'error' => false,
		    			'message' => ['Client updated successfully'],
		    	),200);
    		}
    	}
        //Save Updated Client Data to Database
       // return $clients->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Clients::find($id);
        if(empty($client)){
        	return response(array(
        			'error' => true,
        			'message' => ['Client Not Found'],
        	),400);
        }else{
	    	$client->delete();
	        return response(array(
	                'error' => false,
	                'message' => ['Client deleted successfully'],
	        ),200);
        }
    }
}
