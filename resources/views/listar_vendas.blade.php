@extends('layouts.app')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<head>
  <title> Cadastro de produto </title>
 
  <meta name="csrf-token" content="{{ csrf_token()}}">
</head>

<body>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 offset-md-1 mt-5">
                    <div class="card border">
                        <div class="card-header">
                           <div class="card-title">
                           Lista de produtos
                            </div>
                        </div>

                        <div class="card-body">
                          @if (session()->has('venda_zerada'))
                                    <h1>{{session('venda_zerada') }}</h1>
                              @endif
                            <table class="table table-bordered table-hover table-striped" id="tabela_produtos">
                                <thead>
                                    <th> Código  </th>
                                    <th> Nome    </th>
                                    <th> Tipo    </th>
                                    <th> Valor R$  </th>                                    
                                    <th> Vendas  </th>
                                    <th> Estoque Loja </th>
                                    <th> Estoque Mínimo </th>
                                    <th> Vender </th>                                   
                                    <th> Cancelar venda </th>
                                   
                                </thead>
                                
                                <tbody>
                                    @foreach($produto as $p)
                                    
                                    <tr>

                                        <td>{{$p->id}}</td>
                                        <td>{{$p->nome}}</td>
                                        <td>{{$p->tipo}}</td>
                                        <td>{{$p->valor}}</td>       
                                        <td>{{$p->vendas}}</td>
                                        <td>{{$p->estoque}}</td>
                                        <td>{{$p->estoque_minimo}}</td>
                                        <td><button class="btn btn-primary shadow-sm" data-id='{{$p->id}}' data-toggle="modal" data-target="#vendaModal"> Vender </button></td> 
                                         @can('isAdmin')                                       
                                        <td><button class="btn btn-danger shadow-sm" data-id='{{$p->id}}' data-toggle="modal" data-target="#cancelarVenda" > Cancelar Venda </button></td>
                                        @endcan
                                         @can('isVendedor')
                                         <td><button class="btn btn-danger shadow-sm" disabled> Cancelar Venda </button></td>
                                         @endcan                                      
                                    </tr>
                                      
                                    @endforeach

                                </tbody>

                            </table>

                           
                        </div>
                          
                    </div>                    
                </div>
            </div>
        </div>
    </main>


<!-- MODAL EDIT -->

<div class="modal fade" id="vendaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Venda de produto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('venda_efetuar') }}" method="POST">
          @csrf      
          <div class="form-group">
             <label for="venda_quantidade"> Quantidade: </label>
             <input type="text" id="venda_quantidade" class="form-control" name="venda_quantidade" placeholder="Digite a quantidade que deseja vender do produto">
          </div>
          <input type="hidden" id='id_produto' name="id_produto" value=""> 
             <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Efetuar venda</button>
      </div>
          </form>          
      </div>
   
    </div>
  </div>
</div>
<!-- END MODAL EDIT -->




<!-- MODAL EDIT -->

<div class="modal fade" id="cancelarVenda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cancelamento de venda</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('venda_cancelar') }}" method="POST">
          @csrf      
          <div class="form-group">
             <label for="venda_quantidade_cancelada"> Quantidade: </label>
             <input type="text" id="venda_quantidade_cancelada" class="form-control" name="venda_quantidade_cancelada" placeholder="Digite a quantidade de vendas que serão canceladas">
          </div>
          <input type="hidden" id='id_produto' name="id_produto" value=""> 
             <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Efetuar venda</button>
      </div>
          </form>          
      </div>
   
    </div>
  </div>
</div>
<!-- END MODAL EDIT -->

</body>

<script>



</script>



<!-- Scripts -->


<script>
   

$('#vendaModal').on('show.bs.modal', function (event) {
    
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id')     
  var modal = $(this)  
  modal.find('.modal-body #id_produto').val(id)


})


$('#cancelarVenda').on('show.bs.modal', function (event) {
    
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id')     
  var modal = $(this)  
  modal.find('.modal-body #id_produto').val(id)


})


venda_quantidade_cancelada

</script>

@endsection