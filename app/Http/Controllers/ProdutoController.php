<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use DB;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $produtos = Produto::paginate(5); //quantidade por página
            return $produtos->toJson();
        } catch (Exception $e) {
            return response()->json(['erro' => $e], 402);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $produtosDefault = new Produto();
            $errosProdutos = $produtosDefault->validacao($request);
            if (!$errosProdutos) {
                $produto = Produto::Create([
                    'nome' => request('nome'),
                    'descricao' => request('descricao'),
                    'preco' => request('preco'),
                    'id_setor' => request('id_setor')
                ]);
            $produto->save();
            return response()->json(['Produto cadastrado com sucesso!']);
            }else{
                return response()->json(['Erro: ' => $errosProdutos], 400);
            }
        } catch (Exception $e) {
            return response()->json(['erro' => $e], 501);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $produto = Produto::find($id);
            if(!isset($produto)){
            throw new \Exception("Produto não encontrado", 2);
            }
            $produto = DB::table('produtos')->where('produtos.id', $id)->join('tipo', 'produtos.id_setor', '=', 'tipo.id')->select(
                'produtos.nome',
                'produtos.descricao',
                'produtos.preco',
                'tipo.setor')->get();

            return response()->json(['Dados do produto:' => $produto]);
        } catch (Exception $e) {
            return response()->json(['erro' => $e], 501);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function edit(Produto $produto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produto = Produto::find($id);
        try{
            if (!isset($produto)) {
                throw new \Exception("O produto não existe", 2);
            }

            $produtosDefault = new Produto();
            $errosProdutos = $produtosDefault->validacao($request);

            if(!$errosProdutos){
                $produto->nome = request('nome');
                $produto->descricao = request('descricao');
                $produto->preco = request('preco');
                $produto->id_setor = request('id_setor');
                $produto->save();
                return response()->json(['Produto editado com sucesso']);
            }
            else{
                return response()->json(['error' => $errosProdutos], 400);
            }
        }catch (Exception $e) {
            return response()->json(['erro' => $e], 501);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $produto = Produto::find($id);
            if (!isset($produto)) {
                throw new \Exception("Produto não encontrado", 2);
            }
            $produto->delete();
            return response()->json(["Produto deletado com sucesso!"]);
        } catch (\Exception $e) {
            return ($e->getMessage());
        }
    }
}
