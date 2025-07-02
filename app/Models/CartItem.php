<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory; // Usamos la fábrica de modelos para crear instancias de este modelo

    // Definimos los atributos que son "masivos" (mass assignable), es decir, los que se pueden asignar en bloque
    protected $fillable = ['user_id', 'product_id', 'quantity'];

    // Relación de "pertenece a" con el modelo Product (un CartItem pertenece a un Product)
    public function product()
    {
        return $this->belongsTo(Product::class); // Relacionamos este modelo con el modelo Product
    }

    // Relación de "pertenece a" con el modelo User (un CartItem pertenece a un User)
    public function user()
    {
        return $this->belongsTo(User::class); // Relacionamos este modelo con el modelo User
    }
}
