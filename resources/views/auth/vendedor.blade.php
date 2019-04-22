   <!-- PRODUTO -->
                        <div class='row'>                          
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
                               <a href="{{ route('venda_listar' )}}">  <button style="width: 100%;"style="width: 100%;" type="button" class="btn btn-raised btn-dark">Venda de produto</button> </a> 
                            </div>                    

                                          
                        </div> 

                        <!-- FINAL VENDAS-->