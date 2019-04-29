<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use App\produtoFornecedor;
use App\Produto;
use Illuminate\Support\Facades\DB;

class produtoFornecedorControlador extends Controller
{

     public function __construct()
    {
        $this->middleware('auth');
    }



       public function addEntrada(Request $request)
    {
        $produtoFornecedor = produtoFornecedor::find($request->id_produto);

        $produto = Produto::find($produtoFornecedor->produto);

        if($produtoFornecedor->estoque_minimo > $request->adicionar_estoque ){
             return response()->json(['error' => '0', 'valor_minimo' => $produtoFornecedor->estoque_minimo]);
        } 
           
        
        if($produto->estoque < $produto->estoque_minimo){
            $calculo_estoque =  $request->adicionar_estoque + $produto->estoque;
            if($produto->estoque_minimo > $calculo_estoque)
                return response()->json(['error' => '1', 'valor_minimo' => $produto->estoque_minimo]);
        }

        $produtoFornecedor->estoque_entrada = $request->adicionar_estoque;
        $produto->estoque_entrada +=  $produtoFornecedor->estoque_entrada;
        $produto->estoque +=  $produtoFornecedor->estoque_entrada;  
        
        $produtoFornecedor->save();
        $produto->save();
        return response()->json(['sucesso' => '1']);
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
            ->select('produtos.nome as p_nome', 'fornecedores.nome as f_nome', 'produto_fornecedor.estoque_minimo' , 'produto_fornecedor.estoque_entrada' , 'produto_fornecedor.id', 'produtos.estoque','produtos.estoque_minimo as p_minim')
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




          $mensagens = [
            'pf_estoque_minimo.required' => 'O estoque mínimo é obrigatório',
            'pf_estoque_entrada.required' => 'O estoque de entrada é obrigatório',
            'pf_estoque_minimo.numeric' => 'O valor do estoque deve ser númerico',        
            'pf_estoque_entrada.numeric' => 'O valor do estoque deve ser númerico', 
            'pf_estoque_entrada.min' => 'O valor não pode ser negativo',
            'pf_estoque_minimo.min' => 'O valor não pode ser negativo',
            'pf_fornecedor.required' => 'É obrigatório selecionar um fornecedor',
            'pf_produto.required' => 'É obrigatório selecionar um produto',

        ];      

            $validate =[  
                'pf_estoque_minimo' => 'required|numeric|min:0',
                'pf_estoque_entrada' => 'required|numeric|min:0',
                'pf_produto' => 'required',
                'pf_fornecedor' => 'required'
                
            ];
       

         $request->validate($validate, $mensagens);  

        $produtoFornecedor = new produtoFornecedor();

        $produtoFornecedor->produto = $request->input('pf_produto');
        $produtoFornecedor->fornecedor = $request->input('pf_fornecedor');
        $produtoFornecedor->estoque_minimo = $request->input('pf_estoque_minimo');
        $produtoFornecedor->estoque_entrada = $request->input('pf_estoque_entrada');
        $produtoFornecedor->ativo = 1;

        $matchThese = ['produto_fornecedor.produto' => $produtoFornecedor->produto, 'produto_fornecedor.fornecedor' => $produtoFornecedor->fornecedor];

        $validacao = DB::table('produto_fornecedor')->select('produto_fornecedor.produto,produto_fornecedor.fornecedor')
        ->where($matchThese)       
        ->count();
        
        if($validacao <= 0) { 

            if($produtoFornecedor->estoque_minimo > $produtoFornecedor->estoque_entrada){

                $error = \Illuminate\Validation\ValidationException::withMessages([
            'pf_estoque_entrada' => 'O Estoque de entrada é menor que o Estoque mínimo'
            ]);
                throw $error;

            }

            $produto = Produto::find($produtoFornecedor->produto);
            $calculo_estoque = $produtoFornecedor->estoque_entrada + $produto->estoque; 

            if($produto->estoque_minimo > $calculo_estoque ){
                   $error = \Illuminate\Validation\ValidationException::withMessages([
            'pf_estoque_entrada' => 'O valor de estoque de entrada somado com o estoque atual é menor que o estoque mínimo atual da loja ('.$produto->estoque_minimo.')'
            ]);
                throw $error;
            }


            
            $produtoFornecedor->save();                        
            $produto->estoque_entrada += $request->input('pf_estoque_entrada');
            $produto->estoque = $produto->estoque + $produtoFornecedor->estoque_entrada;
            $produto->save();

            return redirect(route('produtofornecedor_listar'));
        }
        


        $error = \Illuminate\Validation\ValidationException::withMessages([
            'pf_fornecedor' => 'Esta associação de fornecedor e produto já foi realizada'
            ]);
                throw $error;
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
