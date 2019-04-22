@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Painel de controle</div>

                <div class="card-body">
                    @if (!Auth::check())
                    <p> Você não está logado </p>
                    @endif
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @can('isAdmin')
                    Você esta logado como admnistrador!
                    <div>
                        <!-- PRODUTO -->
                        <div class='row'>
                            <div class='col-md-6 mt-5'>
                                <a href="{{ route('produto_cadastro') }}"> <button style="width: 100%;" type="button" class="btn btn-raised btn-dark">Cadastro de produtos</button> </a>                                                    
                            </div>  

                             <div class="col-md-6 mt-5">
                                <a href="{{ route('produto_listar') }} "><button style="width: 100%;" type="button" class="btn btn-raised btn-dark">Lista de produtos</button> </a>
                            </div> 

                                                            
                        </div> 

                        <!-- FINAL PRODUTO -->

                        <!-- FORNECEDOR -->
                        <div class='row'> 
                            <div class='col-md-6 mt-5'>                              
                                    <a href="{{ route('fornecedor_cadastro') }}"> <button style="width: 100%;" type="button" class="btn btn-raised btn-dark">Cadastro de fornecedor</button> </a>
                            </div>

                             <div class="col-md-6 mt-5">
                                <a href="{{ route('fornecedor_listar') }} "><button style="width: 100%;" type="button" class="btn btn-raised btn-dark">Lista de fornecedores</button> </a>
                            </div> 

                        </div>
                        <!-- FINAL FORNECEDOR -->



                        <!-- PRODUTO E FORNECEDOR -->
                        <div class='row'>
                            <div class='col-md-6 mt-5'>
                                <a href="{{ route('produtofornecedor_cadastro') }} "><button style="width: 100%;"style="width: 100%;" type="button" class="btn btn-raised btn-dark">Cadastro Produto/Fornecedor</button></a>
                            </div>     

                             <div class="col-md-6 mt-5">
                                <a href="{{ route('produtofornecedor_listar') }} "><button style="width: 100%;" type="button" class="btn btn-raised btn-dark">Lista de Produto/Fornecedor</button> </a>
                            </div>                       

                                          
                        </div> 

                        <!-- FINAL PRODUTO E FORNECEDOR -->




                        <!-- VENDAS -->
                        <div class='row'>
                            <div class='col-md-6 mt-5'>
                                <button style="width: 100%;"style="width: 100%;" type="button" class="btn btn-raised btn-dark">Venda de produto</button>
                            </div>                    

                                          
                        </div> 

                        <!-- FINAL VENDAS-->

                        <!-- USUÁRIOS -->
                        <div class='row'>
                            <div class='col-md-6 mt-5'>
                                <button style="width: 100%;"style="width: 100%;" type="button" class="btn btn-raised btn-dark">Cadastro de usuários</button>
                            </div>     

                             <div class="col-md-6 mt-5">
                                <a href="{{ route('produto_listar') }} "><button style="width: 100%;" type="button" class="btn btn-raised btn-dark">Lista de usuários</button> </a>
                            </div>                       

                                          
                        </div> 

                        <!-- FINAL USUÁRIO -->
                    </div>
                    @endcan

                    @can('isVendedor')
                    You are logged in as vendedor!
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
  