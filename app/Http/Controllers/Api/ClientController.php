<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
    
        $status = $clients->isEmpty() ? 404 : 200;
        $message = $clients->isEmpty() ? 'No clients found' : 'Clients found';
    
        $data = [
            'message' => $message,
            'status' => $status,
            'clients' => $clients
        ];
    
        return response()->json($data, $status);
    }

    public function show($id)
    {
        $client = Client::find($id);

        if ($client) {
            $status = 200;
            $message = 'Client found';
            $data = [
                'message' => $message,
                'status' => $status,
                'client' => $client
            ];
        } else {
            $status = 404;
            $message = 'Client not found';
            $data = [
                'message' => $message,
                'status' => $status
            ];
        }

        return response()->json($data, $status);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'username' => 'required|max:20|unique:client',
            'email' => 'required|email|unique:client',
            'website' => 'required',
            'salary' => 'required',
            'phone' => 'required|digits:10'
        ]);
    
        if ($validator->fails()) {
            $status = 400;
            $message = 'Validation error';
            $data = [
                'message' => $message,
                'status' => $status,
                'errors' => $validator->errors()
            ];
    
            return response()->json($data, $status);
        }
    
        $client = Client::create($request->all());
    
        if ($client) {
            $status = 201;
            $message = 'Client created';
            $data = [
                'message' => $message,
                'status' => $status,
                'client' => $client
            ];
        } else {
            $status = 400;
            $message = 'Client not created';
            $data = [
                'message' => $message,
                'status' => $status
            ];
        }
    
        return response()->json($data, $status);
    }

    public function update(Request $request, $id)
    {
        $client = Client::find($id);

        if ($client) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'username' => 'required|max:20|unique:client,username,' . $id,
                'email' => 'required|email|unique:client,email,' . $id,
                'website' => 'required',
                'salary' => 'required',
                'phone' => 'required|digits:10'
            ]);
        
            if ($validator->fails()) {
                $status = 400;
                $message = 'Validation error';
                $data = [
                    'message' => $message,
                    'status' => $status,
                    'errors' => $validator->errors()
                ];
        
                return response()->json($data, $status);
            }
        
            $client->update($request->all());
        
            $status = 200;
            $message = 'Client updated';
            $data = [
                'message' => $message,
                'status' => $status,
                'client' => $client
            ];
        } else {
            $status = 404;
            $message = 'Client not found';
            $data = [
                'message' => $message,
                'status' => $status
            ];
        }

        return response()->json($data, $status);
    }

    public function destroy($id)
    {
        $client = Client::find($id);

        if ($client) {
            $client->delete();
            $status = 200;
            $message = 'Client deleted';
            $data = [
                'message' => $message,
                'status' => $status
            ];
        } else {
            $status = 404;
            $message = 'Client not found';
            $data = [
                'message' => $message,
                'status' => $status
            ];
        }

        return response()->json($data, $status);

    }
}
