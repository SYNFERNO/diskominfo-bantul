<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class abilities extends Model
{
    use HasFactory;

    protected $table = 'abilities';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'pokemon_fk_id',
    ];

    public function pokemons()
    {
        return $this->belongsTo(pokemons::class, 'pokemon_id', 'pokemon_fk_id');
    }
}
