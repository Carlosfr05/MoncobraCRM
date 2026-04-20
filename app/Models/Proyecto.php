<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proyecto extends Model
{
    use HasFactory;

    /**
     * Keep project membership in sync for superadmins.
     */
    protected static function booted(): void
    {
        static::created(function (Proyecto $proyecto) {
            $superadminIds = User::query()
                ->where('role', 'superadmin')
                ->pluck('id')
                ->all();

            if (!empty($superadminIds)) {
                $proyecto->usuarios()->syncWithoutDetaching($superadminIds);
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'localizacion',
        'imagen',
    ];

    /**
     * Get the users that belong to the proyecto.
     */
    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'proyecto_user')->withTimestamps();
    }

    /**
     * Get clientes linked to this proyecto.
     */
    public function clientes(): HasMany
    {
        return $this->hasMany(Cliente::class, 'proyecto_id');
    }

    /**
     * Get albaranes linked to this proyecto.
     */
    public function albaranes(): HasMany
    {
        return $this->hasMany(AlbaranCliente::class, 'proyecto_id');
    }

    /**
     * Get presupuestos linked to this proyecto.
     */
    public function presupuestos(): HasMany
    {
        return $this->hasMany(Presupuesto::class, 'proyecto_id');
    }

    /**
     * Get inventario items linked to this proyecto.
     */
    public function inventarioItems(): HasMany
    {
        return $this->hasMany(Inventario::class, 'proyecto_id');
    }

    /**
     * Get pedidos clientes linked to this proyecto.
     */
    public function pedidosClientes(): HasMany
    {
        return $this->hasMany(PedidoCliente::class, 'proyecto_id');
    }

    /**
     * Get articulos linked to this proyecto.
     */
    public function articulos(): HasMany
    {
        return $this->hasMany(Articulo::class, 'proyecto_id');
    }
}
