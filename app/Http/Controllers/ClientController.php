<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use App\Traits\UploadImgTrait;
use Image;


class ClientController extends Controller
{

    use UploadImgTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $input = $request->all();
        if ($request->hasFile('img')){
            $file_name = $this->saveImage($request->file('img'),'clients');
            $input['img'] = $file_name;
        }
        $client = Client::create($input);

        if($client){
            return response()->json([
                'status'=> true,
                'msg' => 'Added successfully',
                'client' => $client
            ]);
        }
        
        return response()->json([
            'status'=> false,
            'msg' => "There is an error"
        ]);
        
        // return redirect()->route('home')->with('success','stored successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
    	if($request->ajax()){
	       	Client::find($request->input('pk'))->update([$request->input('name') => $request->input('value')]);
	        return response()->json(['success' => true]);
    	}
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
