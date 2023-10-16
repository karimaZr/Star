<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'abriviation',
        'niveau'
    ];

    public function etudiants()
    {
        return $this->hasMany(User::class, 'filiere_id');
    }
    
    public function modules()
    {
        return $this->hasMany(Module::class, 'filiere_id');
    }

}
