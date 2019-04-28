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

    public function status(Request $request){

          if(!Gate::allows('isAdmin')){
            abort(404,'Você não tem acesso a esta funcionalidade');
        }


       $produto = Produto::find($request->id);
       
       if($produto->ativo)
       $produto->ativo= 0;
       else
        $produto->ativo = 1;


        $produto->save();
         return redirect(route('produto_listar'));
    }

     public function cancelar_venda(Request $request){
        
         if(!Gate::allows('isAdmin')){
            abort(404,'Você não tem acesso a esta funcionalidade');
        }

        $produto = Produto::find($request->input('id_produto'));
        $produto_cancelado = $request->input('venda_quantidade_cancelada');
        
        if($produto->vendas != 0) {
            $produto->vendas -= $produto_cancelado;
        } else if ($produto->vendas <= 0) {
            $produto->vendas = 0;
            
            return redirect()->back()->with('venda_zerada','O produto já está com a venda zerada');
        }


        if($produto->vendas < 0) {
            $produto->vendas = 0;
        }

        $produto->estoque += $produto_cancelado;

        $produto->save();

        return redirect(route('venda_listar'));
    }

     public function efetuar_venda(Request $request){

        $produto = Produto::find($request->input('id_produto'));
        $produto_venda = $request->input('venda_quantidade');

        $produto->vendas +=  $produto_venda;
        $produto->estoque -= $produto_venda;
        $produto->save();

        return redirect(route('venda_listar'));
    }

    /**
     * View da Venda
     *
     * @return \Illuminate\Http\Response
     */

    public function venda(){
        $produto = Produto::all();
        return view('listar_vendas', compact('produto'));
    }

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

        $mensagens = [
            'produto_nome.required' => 'O Nome é obrigatório',
            'produto_nome.unique' => 'Este produto já está cadastrado',
            'produto_valor.required' => 'O valor é obrigatório',
            'produto_estoque_minimo.required' => 'O estoque mínimo é obrigatório',
            'produto_estoque_minimo.numeric' => 'O valor do estoque deve ser númerico',
            'produto_tipo.string' => 'O tipo não deve ser um valor númerico',
            'produto_tipo.required' => 'O tipo do produto é obrigatório' 

        ];
        
        $request->validate([
            'produto_nome' => 'required|unique:produtos,nome',
            'produto_valor' => 'required',
            'produto_estoque_minimo' => 'required|numeric',
            'produto_tipo' => 'required|string'
        ], $mensagens);

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
    public function update(Request $request)
    {
        //
            if(!Gate::allows('isAdmin')){
            abort(404,'Você não tem acesso a esta funcionalidade');
        }

          $mensagens = [
            'produto_nome.required' => 'O Nome é obrigatório',
            'produto_nome.unique' => 'Este produto já está cadastrado',
            'produto_valor.required' => 'O valor é obrigatório',
            'produto_estoque_minimo.required' => 'O estoque mínimo é obrigatório',
            'produto_estoque_minimo.numeric' => 'O valor do estoque deve ser númerico',
            'produto_tipo.string' => 'O tipo não deve ser um valor númerico',
            'produto_tipo.required' => 'O tipo do produto é obrigatório' 

        ];
        
        $request->validate([
            'produto_nome' => 'required|unique:produtos,nome',
            'produto_valor' => 'required',
            'produto_estoque_minimo' => 'required|numeric',
            'produto_tipo' => 'required|string'
        ], $mensagens);


        $produto = Produto::find($request->input('id_produto'));          
         $produto->nome = $request->input('produto_nome');
        $produto->tipo = $request->input('produto_tipo');

            $valor = str_replace(',','.',$request->input('produto_valor') );
        $produto->valor = $valor;     

        $produto->estoque_minimo = $request->input('produto_estoque_minimo');
        $produto->estoque =  $request->input('produto_estoque');

        $produto->save();

        return redirect(route('produto_listar'));
    
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
