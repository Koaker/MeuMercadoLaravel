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
                            <table class="table table-bordered table-hover table-striped" id="tabela_produtos">
                                <thead>
                                    <th> Código  </th>
                                    <th> Nome    </th>
                                    <th> Tipo    </th>
                                    <th> Valor R$  </th>                                    
                                    <th> Vendas  </th>
                                    <th> Estoque Loja </th>
                                    <th> Estoque Mínimo </th>
                                    <th> Editar </th>                                   
                                    <th> Inativar </th>
                                    <th> Excluir </th>
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
                                        <td><button class="btn btn-primary shadow-sm" data-id='{{$p->id}}' data-estoque='{{$p->estoque}}' data-stoker='{{$p->estoque_minimo}}' data-valor="{{$p->valor}}" data-tipo="{{$p->tipo}}" data-nome="{{$p->nome}}" data-toggle="modal" data-target="#editModal"> Editar </button></td> 
                                         @can('isAdmin')                                        
                                        <td><button class="btn btn-danger" > Inativar </button></td>
                                        <td><button class="btn btn-danger"> Excluir  </button></td>
                                        @endcan
                                         @can('isVendedor') 
                                         <td><button class="btn btn-danger" disabled > Inativar </button></td>
                                        <td><button class="btn btn-danger" disabled> Excluir  </button></td>
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

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar produto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('produto_editar')}}" method="post">
          @csrf
          @include('forms/produto')

          <div class="form-group">
    <label for="produto_estoque"> Estoque da Loja: </label>
    <input type="text" id="produto_estoque" class="form-control {{$errors->has('produto_estoque') ? 'is-invalid' : ''}}" name="produto_estoque" placeholder="Valor do produto" value="{{ old('produto_estoque') }}">
    <input type="hidden" name="id_produto" id='id_produto' value="">
       @if($errors->has('produto_estoque'))
      <div class='invalid-feedback'>
        {{$errors->first('produto_estoque')}}
      </div>
    @endif
  </div>

        <button type="submit" class="btn btn-primary">Salvar alterações</button>
          
        </form>
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
      <div class="modal-footer">
        
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
   

$('#editModal').on('show.bs.modal', function (event) {
    
  var button = $(event.relatedTarget) // Button that triggered the modal
  var nome = button.data('nome') 
  var valor = button.data('valor') 
  var tipo = button.data('tipo') 
  var stoker = button.data('stoker') 
  var estoque = button.data('estoque')
  var id = button.data('id')
    
  var modal = $(this)  
  modal.find('.modal-title').text('Editando o produto: ' + nome)
  modal.find('.modal-body #produto_nome').val(nome)
  modal.find('.modal-body #produto_valor').val(valor)
  modal.find('.modal-body #produto_tipo').val(tipo)
  modal.find('.modal-body #produto_estoque_minimo').val(stoker)
  modal.find('.modal-body #produto_estoque').val(estoque)
  modal.find('.modal-body #id_produto').val(id)

})

</script>

@endsection