<?php

namespace App\Http\Controllers;

use App\Models\pokemons;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class apiController extends Controller
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = new $client([
            'verify' => storage_path('cacert.pem'),
        ]);
    }

    public function getPokemons()
    {
        try {
            $response = $this->client->get('https://pokeapi.co/api/v2/pokemon');
            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function getDetailPokemon($id)
    {
        try {
            $response = $this->client->get('https://pokeapi.co/api/v2/pokemon/' . $id);
            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
