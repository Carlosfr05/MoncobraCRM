<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'localizacion',
    ];

    /**
     * Get the users that belong to the proyecto.
     */
    public function usuarios()
    {
        return $this->hasMany(User::class, 'proyecto_id');
    }
}
