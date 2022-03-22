<?php

namespace App\Http\Controllers;

use App\Models\Setor;
use Illuminate\Http\Request;
use DB;

class SetorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $setor = Setor::paginate(5); //quantidade por página
            return $setor->toJson();
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
            $setoresDefault = new Setor();
            $errosSetores = $setoresDefault->validacao($request);
            if (!$errosSetores) {
                $setor = Setor::Create([
                    'setor' => request('setor'),
                ]);
            $setor->save();
            return response()->json(['Setor cadastrado com sucesso!']);
            }else{
                return response()->json(['Erro: ' => $errosSetores], 400);
            }
        } catch (Exception $e) {
            return response()->json(['erro' => $e], 501);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function show(Setor $setor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function edit(Setor $setor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $setor = Setor::find($id);
        try{

            if (!isset($setor)) {
                throw new \Exception("O setor não existe", 2);
            }

            $setorDefault = new Setor();
            $errosSetor = $setorDefault->validacao($request);

            if(!$errosSetor){
                $setor->setor = request('setor');
                $setor->save();
                return response()->json(['Setor editado com sucesso']);
            }
            else{
                return response()->json(['error' => $errosSetor], 400);
            }
        }catch (Exception $e) {
            return response()->json(['erro' => $e], 501);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $setor = Setor::find($id);
            if (!isset($setor)) {
                throw new \Exception("Setor não encontrado", 2);
            }
            $setor->delete();
            return response()->json(["Setor deletado com sucesso!"]);
        } catch (\Exception $e) {
            return ($e->getMessage());
        }
    }
}
