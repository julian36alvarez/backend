<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientStoreRequest;
use App\Client;
use Validator;


class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $clients = Client::get();
        echo json_encode($clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'nombres' => 'required|regex:/^[\pL\s\-]+$/u',
            'apellidos' => 'required|regex:/^[\pL\s\-]+$/u',
            'telefono' => 'required|numeric',
            'correo' => 'required|email|unique:client,correo',
            'cedula' => 'required|numeric|unique:client,cedula',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }else{
            $client = new Client;
            $client->nombres = $request->input('nombres');
            $client->apellidos = $request->input('apellidos');
            $client->cedula = $request->input('cedula');
            $client->correo = $request->input('correo');
            $client->telefono = $request->input('telefono');
            $client->save();
            return response()->json($client);
        }

        //print_r($request->all());
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'nombres' => 'required|regex:/^[\pL\s\-]+$/u',
            'apellidos' => 'required|regex:/^[\pL\s\-]+$/u',
            'correo' => 'required|email|unique:client,correo,'.$client->id.',id',
            'cedula' => 'required|numeric|unique:client,cedula,'.$client->id.',id',
            'telefono' => 'required|numeric',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $client->nombres = $request->input('nombres');
        $client->apellidos = $request->input('apellidos');
        $client->cedula = $request->input('cedula');
        $client->correo = $request->input('correo');
        $client->telefono = $request->input('telefono');
        $client->save();

        return $this->sendResponse($client->toArray(), 'Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }


    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);

    }


  public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }
}
