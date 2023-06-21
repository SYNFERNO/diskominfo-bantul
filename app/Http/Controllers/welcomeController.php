<?php

namespace App\Http\Controllers;

use App\Models\pokemons;
use App\Http\Controllers\apiController;
use App\Models\abilities;

class welcomeController extends Controller
{

    function view()
    {
        $client = new \GuzzleHttp\Client();
        $apiController = new apiController($client);


        $pokemons = pokemons::with('abilities')->get()->sortByDesc('weight');

        if (!$pokemons) {
            for ($i = 1; $i <= 200; $i++) {
                $data = $apiController->getDetailPokemon($i);
                $this->saveData($data);
            }
        }

        return view('welcome', compact('pokemons'));
    }

    function saveData($data)
    {
        if ($data['weight'] >= 100) {
            $checkIsExist = pokemons::where('name', $data['name'])->first();
            if (!$checkIsExist) {
                $poke = pokemons::create([
                    'pokemon_id' => $data['id'],
                    'name' => $data['name'],
                    'base_experience' => $data['base_experience'],
                    'weight' => $data['weight'],
                    'stat_count' => $this->filterStatCount($data),
                    'image_url' => $data['sprites']['front_default'],
                ]);
                $poke->save();
                $this->saveAbilities($data);
            }
        }
    }

    function saveAbilities($data)
    {
        $abilities = [];

        foreach ($data['abilities'] as $abilityData) {
            if (!$abilityData['is_hidden']) {
                $ability = [
                    'name' => $abilityData['ability']['name'],
                    'pokemon_fk_id' => $data['id']
                ];
                $abilities[] = $ability;
            }
        }

        $checkIsExist = abilities::where('pokemon_fk_id', $data['id'])->first();
        if (!$checkIsExist) {
            foreach ($abilities as $abilitie) {
                $data = abilities::create($abilitie);
                $data->save();
            }
        }
    }

    function filterStatCount($data)
    {
        $statCount = 0;
        foreach ($data['stats'] as $abilityData) {
            if ($abilityData['effort'] > 0) {
                $statCount += $abilityData['base_stat'];
            }
        }
        return $statCount;
    }
}
