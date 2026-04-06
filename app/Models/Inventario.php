<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'codigo',
        'descripcion',
        'referencia_proveedor',
        'clase',
        'ubicacion',
        'almacen',
        'stock_actual',
        'stock_minimo',
        'nivel_critico',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'stock_actual' => 'integer',
        'stock_minimo' => 'integer',
        'nivel_critico' => 'integer',
    ];
}
