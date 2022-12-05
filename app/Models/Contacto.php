<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Contacto extends Model
{
    use HasFactory;

    protected $table = "contactos";
    protected $key = "id";
    protected $fillable = [
        'id_user',
        'nombre',
        'telefono',
        'fecha_nacimiento',
        'direccion',
        'email'
    ];

    public function account()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}