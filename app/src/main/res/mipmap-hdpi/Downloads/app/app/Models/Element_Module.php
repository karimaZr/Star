<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Element_Module extends Model
{
    use HasFactory;
    public function module()
    {
        return $this->belongsTo(Module::class,'module_id');
    }
    
    
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    

    protected $fillable = [
        'Code',
        'Nom',
        'coifficent',
        'module_id',
        'user_id',
        
    ];
}
