<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clientes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'empresa_nombre',
        'cif_nif',
        'direccion',
        'localidad',
        'codigo_postal',
        'telefono',
        'email',
        'persona_contacto',
    ];

    /**
     * Get all albaranes for this cliente.
     */
    public function albaranes(): HasMany
    {
        return $this->hasMany(AlbaranCliente::class, 'cliente_id');
    }

    /**
     * Get all presupuestos for this cliente.
     */
    public function presupuestos(): HasMany
    {
        return $this->hasMany(Presupuesto::class, 'cliente_id');
    }
}
