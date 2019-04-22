@extends('layouts.app')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<head>
  <title> Lista de fornecedores </title>
 
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
                           Lista de fornecedores
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered table-hover" id="tabela_produtos">
                                <thead>
                                    <th> Código  </th>
                                    <th> Produto    </th>
                                    <th> Fornecedor    </th>
                                    <th> Estoque Mínimo  </th>
                                    <th> Estoque entrada</th>                                    
                                    <th> Editar </th>                                   
                                    <th> Inativar </th>
                                    <th> Excluir </th>

                                </thead>
                                
                                <tbody>
                                    @foreach($produtoFornecedor as $p)
                                    <tr>
                                        <td>{{$p->id}}</td>
                                        <td>{{$p->p_nome}}</td>
                                        <td>{{$p->f_nome}}</td>
                                        <td>{{$p->estoque_minimo}}</td>
                                        <td>{{$p->estoque_entrada}}</td>                                      
                                                                        
                                        <td><button class="btn btn-primary shadow-sm" >Editar</button></td>  
                                        @can('isAdmin')                                     
                                        <td><button class="btn btn-danger" > Inativar </button></td>
                                        <td><button class="btn btn-danger" > Excluir </button></td>
                                        @endcan

                                         @can('isVendedor')                                     
                                        <td><button class="btn btn-danger" disabled > Inativar </button></td>
                                        <td><button class="btn btn-danger" disabled > Excluir </button></td>
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
   

// $('#editModal').on('show.bs.modal', function (event) {
    
//   var button = $(event.relatedTarget) // Button that triggered the modal
//   var nome = button.data('nome') 
//   var valor = button.data('valor') 
//   var tipo = button.data('tipo') 
    
//   var modal = $(this)  
//   modal.find('.modal-title').text('Editando o produto: ' + nome)
//   modal.find('.modal-body #produto_nome').val(nome)
//   modal.find('.modal-body #produto_valor').val(valor)
//   modal.find('.modal-body #produto_tipo').val(tipo)

// })

</script>

@endsection