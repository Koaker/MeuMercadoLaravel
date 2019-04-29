<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fornecedores;
use Gate;
use Illuminate\Support\Facades\DB;
class FornecedorControlador extends Controller
{
   public function __construct()
    {
        $this->middleware('auth');
    }




     public function status(Request $request){

       $fornecedor = Fornecedores::find($request->id);
       
       if($fornecedor->ativo)
       $fornecedor->ativo= 0;
       else
        $fornecedor->ativo = 1;


        $fornecedor->save();
         return redirect(route('fornecedor_listar'));
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
            
           $mensagens = [            
            'fornecedor_nome.required' => 'O nome é obrigatório',
            'fornecedor_nome.string' => 'O nome deve ser um texto',            
            'fornecedor_cnpj.required' => 'O CNPJ é obrigatório',
            'fornecedor_cnpj.min' => 'O CNPJ digitado é inválido',
            'fornecedor_cnpj.max' => 'O CNPJ digitado é inválido',
            'fornecedor_cnpj.unique' => 'O CNPJ digitado já está cadastrado para outra empresa',
            'fornecedor_endereco.string' => 'O tipo não deve ser um valor númerico',            
            'fornecedor_endereco.required' => 'O endereço é obrigatório',
            'fornecedor_email.required' => 'O e-mail é obrigatório',
            'fornecedor_email.email' => 'Digite um endereço de e-mail válido',
            'fornecedor_estado.required' => 'O estado é obrigatório'           

        ];

         $request->validate([
            'fornecedor_nome' => 'required|string',
            'fornecedor_cnpj' => 'required|unique:fornecedores,cnpj|min:18|max:18',
            'fornecedor_email' => 'required|email|unique:fornecedores,email',
            'fornecedor_estado' => 'required|string',
            'fornecedor_endereco' =>'required|string'            

        ], $mensagens);

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
    public function update(Request $request)
    {
            
            $fornecedor = Fornecedores::find($request->input('id_fornecedor')); 
           

            $mensagens = [            
            'fornecedor_nome.required' => 'O nome é obrigatório',
            'fornecedor_nome.string' => 'O nome deve ser um texto',            
            'fornecedor_cnpj.required' => 'O CNPJ é obrigatório',
            'fornecedor_cnpj.min' => 'O CNPJ digitado é inválido',
            'fornecedor_cnpj.max' => 'O CNPJ digitado é inválido',
            'fornecedor_cnpj.unique' => 'O CNPJ digitado já está cadastrado para outra empresa',
            'fornecedor_endereco.string' => 'O tipo não deve ser um valor númerico',            
            'fornecedor_endereco.required' => 'O endereço é obrigatório',
            'fornecedor_email.required' => 'O e-mail é obrigatório',
            'fornecedor_email.email' => 'Digite um endereço de e-mail válido',
            'fornecedor_estado.required' => 'O estado é obrigatório'           

        ];

           $validate = [
            'fornecedor_nome' => 'required|string',           
            'fornecedor_estado' => 'required|string',
            'fornecedor_endereco' =>'required|string'

            ];



            if($request->input('fornecedor_cnpj') != $fornecedor->cnpj){        
            $validate['fornecedor_cnpj'] = 'required|unique:fornecedores,cnpj|min:18|max:18';                    
        
        }

         if($request->input('fornecedor_email') != $fornecedor->email){        
            $validate['fornecedor_email'] = 'required|email|unique:fornecedores,email';                    
        
        }

      

         $request->validate( $validate , $mensagens);

       

        $fornecedor->nome = $request->input('fornecedor_nome');
        $fornecedor->cnpj = $request->input('fornecedor_cnpj');
        $fornecedor->endereco = $request->input('fornecedor_endereco');
        $fornecedor->email = $request->input('fornecedor_email');  
        $fornecedor->estado = $request->input('fornecedor_estado');
        
     
        $fornecedor->save();
        return redirect(route('fornecedor_listar'));
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
