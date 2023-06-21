<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pokemons extends Model
{
    use HasFactory;

    protected $table = 'pokemons';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'pokemon_id',
        'name',
        'base_experience',
        'weight',
        'stat_count',
        'image_url',
    ];

    public function abilities()
    {
        return $this->hasMany(abilities::class, 'pokemon_fk_id', 'pokemon_id');
    }

}
