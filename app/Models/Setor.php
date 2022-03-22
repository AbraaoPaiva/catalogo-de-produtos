<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class Setor extends Model
{
    protected $table = 'tipo';
    protected $fillable = [
        'setor'
    ];

    protected function regras()
    { //regras de validação
        return [
            'setor'              => ['required', 'string', 'max:20', 'min:1'],
        ];
    }

    protected function mensagens() //mensagens para erros
    {
        return [
            'setor.required' => "O campo nome é obrigatório",
            'setor.max' => "O campo nome deve ter no máximo 20 caracteres",
            'setor.min' => "O campo tipo deve ter no mínimo 1 caracteres",
            'setor.string' => "O campo nome deve conter letras",
        ];
    }

    public function validacao(Request $request)
    {
        $validator = Validator::make($request->all(), $this->regras(), $this->mensagens());

        if ($validator->fails()) {
            return $validator->errors();
        } else {
            return [];
        }
    }
}
