@extends('layouts.app')
@include('global.notifications')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<head>
  <title> Cadastro de produto </title>
 
  <meta name="csrf-token" content="{{ csrf_token()}}">
</head>


if ($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all('<p>:message</p>') as $error)
            {{ $error }}
        @endforeach
    </div>
@endif

@if (Session::has('success'))
    <div class="alert alert-success">
        <p>{{ Session::get('success') }}</p>
    </div>
@endif

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
                                        <td><button class="btn btn-primary shadow-sm" data-valor ="{{$p->valor}}" data-tipo="{{$p->tipo}}" data-nome="{{$p->nome}}" data-toggle="modal" data-target="#editModal"> Editar </button></td>                                        
                                        <td><button class="btn btn-danger" > Inativar </button></td>
                                        <td><button class="btn btn-danger"> Excluir  </button></td>
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
      @include('forms/produto')
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
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
    
  var modal = $(this)  
  modal.find('.modal-title').text('Editando o produto: ' + nome)
  modal.find('.modal-body #produto_nome').val(nome)
  modal.find('.modal-body #produto_valor').val(valor)
  modal.find('.modal-body #produto_tipo').val(tipo)

})

</script>

@endsection