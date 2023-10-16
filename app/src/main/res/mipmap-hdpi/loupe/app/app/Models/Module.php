<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['Code', 'Nom', 'filiere_id', 'semestre'];   
    use HasFactory;
    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }
    public function element_modules()
{
    return $this->hasMany(Element_Module::class);
}

    

}
