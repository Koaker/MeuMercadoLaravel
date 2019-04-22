<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fornecedores;
use Gate;
class FornecedorControlador extends Controller
{
   public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     * 
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fornecedores = Fornecedores::all();
        return view('listar_fornecedor', compact('fornecedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(!Gate::allows('isAdmin')){
            abort(404,'Você não tem acesso a esta funcionalidade');
        }
        return view('frm_fornecedor');
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
            'fornecedor_nome' => 'required|string',
            'fornecedor_cnpj' => 'required|unique:fornecedores,cnpj',
            'fornecedor_email' => 'required|email',
            'fornecedor_estado' => 'required|string',

        ]);

        $fornecedor = new fornecedores();

        $fornecedor->nome = $request->input('fornecedor_nome');
        $fornecedor->cnpj = $request->input('fornecedor_cnpj');
        $fornecedor->endereco = $request->input('fornecedor_endereco');;
        $fornecedor->email = $request->input('fornecedor_email');       
        $fornecedor->estado = $request->input('fornecedor_estado');
        $fornecedor->ativo = 1;
     
        $fornecedor->save();
        return redirect(route('fornecedor_listar'));
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
