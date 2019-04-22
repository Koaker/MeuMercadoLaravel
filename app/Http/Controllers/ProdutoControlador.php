<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;
use Gate;
class ProdutoControlador extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * 
     * 
     */

    public function index()
    {
     
        $produto = Produto::all();
        return view('listar_produto', compact('produto'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Gate::allows('isAdmin')){
            abort(404,'Você não tem acesso a esta funcionalidade');
        }
        return view('frm_produto');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
         if(!Gate::allows('isAdmin')){
            abort(404,'Você não tem acesso a esta funcionalidade');
        }
        
        $request->validate([
            'produto_nome' => 'required|unique:produtos,nome',
            'produto_valor' => 'required',
            'produto_estoque_minimo' => 'required|numeric',

        ]);

        $produto = new Produto();
        $produto->nome = $request->input('produto_nome');
        $produto->tipo = $request->input('produto_tipo');
            $valor = str_replace(',','.',$request->input('produto_valor') );
        $produto->valor = $valor;     
        $produto->estoque_minimo = $request->input('produto_estoque_minimo');
        $produto->estoque = 0;
        $produto->ativo = 1;
        $produto->vendas = 0;
        $produto->save();

        return redirect(route('produto_listar'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
