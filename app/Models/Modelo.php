<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;
    protected $fillable =  ['marca_id', 'nome', 'imagem', 'numero_portas', 'lugares', 'airbag', 'abs'];

    public function rules () {
        return [
            'marca_id' => 'exists:marcas,id',
            'nome' => 'required|unique:modelos,nome|min:3',
            'imagem' => 'required|file|mimes:png,jpeg,jpg',
            'numero_portas' => 'required|integer|digits_betwen:1,5',
            'lugares' => 'required|integer|digits_betwen:1,5',
            'airbag' => 'required|boolean',
            'abs' => 'required|abs'
        ];
    }
}
