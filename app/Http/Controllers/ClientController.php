<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::with('user','address')->paginate(10);
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = $request->user()->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('password'),
            ]);

            $user->client()->create([
                'address_id' => $request->address_id,
            ]);

            return redirect()->route('clients.index')->with('success', 'Client created successfully.');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return 'test clients get';
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $client->load('user', 'address');
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        DB::transaction(function () use ($request, $client) {
            $client->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $client->update([
                'address_id' => $request->address_id,
            ]);
        });

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
