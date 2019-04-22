<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use App\produtoFornecedor;
use Illuminate\Support\Facades\DB;

class produtoFornecedorControlador extends Controller
{

     public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtoFornecedor = DB::table('produto_fornecedor')
            ->join('produtos', 'produtos.id', '=', 'produto_fornecedor.produto')
            ->join('fornecedores', 'fornecedores.id', '=', 'produto_fornecedor.fornecedor')
            ->select('produtos.nome as p_nome', 'fornecedores.nome as f_nome', 'produto_fornecedor.estoque_minimo' , 'produto_fornecedor.estoque_entrada' , 'produto_fornecedor.id')
            ->get();
        return view('listar_fornecedor_produto', compact('produtoFornecedor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('frm_fornecedor_produto');
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

        $produtoFornecedor = new produtoFornecedor();
        $produtoFornecedor->produto = $request->input('pf_produto');
        $produtoFornecedor->fornecedor = $request->input('pf_fornecedor');
        $produtoFornecedor->estoque_minimo = $request->input('pf_estoque_minimo');
        $produtoFornecedor->estoque_entrada = $request->input('pf_estoque_entrada');
        $produtoFornecedor->ativo = 1;
        
        $produtoFornecedor->save();
        return redirect(route('produtofornecedor_listar'));

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
