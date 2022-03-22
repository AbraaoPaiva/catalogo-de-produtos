<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Produto extends Model
{
    protected $table = 'produtos';
    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'id_setor'
    ];

    protected function regras()
    { //regras de validação
        return [
            'nome'               => ['required', 'string', 'max:20', 'min:1'],
            'descricao'          => ['required', 'string', 'max:100', 'min: 1'],
            'preco'              => ['required', 'min:1', 'max:5'],
            'id_setor'           => ['required', 'numeric', 'min:1', 'max:3'],
        ];
    }

    protected function mensagens() //mensagens para erros
    {
        return [
            'nome.required' => "O campo nome é obrigatório",
            'nome.max' => "O campo nome deve ter no máximo 20 caracteres",
            'nome.min' => "O campo tipo deve ter no mínimo 1 caracteres",
            'nome.string' => "O campo nome deve conter letras",
            
            'descricao.required' => "O campo descricao é obrigatório",
            'descricao.max' => "O campo descricao deve ter no máximo 100 caracteres",
            'descricao.min' => "O campo descricao deve ter no mínimo 1 caracteres",
            'descricao.string' => "O campo descricao deve conter letras",

            'preco.required' => "O campo preco é obrigatório",
            'preco.max' => "O campo preco deve ter no máximo 5 caracteres",
            'preco.min' => "O campo preco deve ter no mínimo 1 caracteres",
            'preco.numeric' => "O campo preco deve conter números",

            'id_setor.required' => "O campo tipo do produto é obrigatório",
            'id_setor.max' => "O campo setor deve ter no máximo 3 caracteres",
            'id_setor.min' => "O campo setor deve ter no mínimo 1 caracteres",
            'id_setor.numeric' => "O campo setor deve conter números",
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
