@extends('layouts.app')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<head>
  <title> Lista de produtos com fornecedores </title>
 
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
                           Lista de produtos com fornecedores
                            </div>


                                 <div class='row'>
                                  @can('isAdmin') 
                                  <div class='col-md-5'>
                                       <a href="{{route('produtofornecedor_cadastro')}}"><button class="btn btn-success">Adicionar Fornecedor ao produto</button></a>
                                  </div>
                                 @endcan
                                </div>



                            <div class="row"> 
                                <div class="col-md-12">


                                <div class="form-group">

                                  <label for="pesquisa_fornecedor">Pesquisar por: </label>
                                 
                                  <select id="select_pesquisa" class="form-control" style="width: 7%;">
                                    <option value='1' selected>Nome</option>                                   
                                  </select>                                       
                                  
                                </div>

                                <div class="form-group" style="width: 40%;">      

                                  <input type="text" id="pesquisa_fornecedor" class="form-control" placeholder="Pesquise aqui">

                                </div>
                                
                            
                              
                              </div>
                                  
                          </div>    
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered table-hover" id="tabela_produtos">
                                <thead>
                                    <th> Código  </th>
                                    <th> Produto    </th>
                                    <th> Fornecedor    </th>
                                    <th> Estoque Mínimo fornecedor  </th>
                                    <th> Estoque entrada</th>  
                                    <th> Estoque Loja</th> 
                                    <th> Estoque mínimo produto</th>                                   
                                    <th> Editar </th>
                                    <th> Adicionar estoque entrada</th> 
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
                                        <td>{{$p->estoque}}</td>
                                         <td>{{$p->p_minim}}</td>                                        
                                                                        
                                        <td><button class="btn btn-primary shadow-sm" >Editar</button></td>  
                                        @can('isAdmin')                                     
                                         <td>
                                          <button class="btn btn-success" data-target='#addEstoqueModal' data-id='{{$p->id}}'data-toggle="modal" data-keyboard="false" > 
                                          Adicionar estoque entrada 
                                          </button>
                                        </td>
                                        <td><button class="btn btn-danger" > Excluir </button></td>
                                        @endcan

                                         @can('isVendedor')                                     
                                        <td>
                                          <button class="btn btn-success" data-target='#addEstoqueModal' data-id='{{$p->id}}'data-toggle="modal" data-keyboard="false" > 
                                          Adicionar estoque entrada 
                                          </button>
                                        </td>
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




</body>

<script>



</script>



<!-- Scripts -->


<script>

 

  $(document).ready(function(){

    /* MASKS */
     $('#adicionar_estoque').mask('00000000000000', {reverse: true});
     /* END MASKS */


     $('#addEstoqueModal').on('show.bs.modal', function (event) {
      
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') 
      
    var modal = $(this)  
   
    modal.find('.modal-body #id_produto').val(id)
   
  
  })


     /* AJAX */
       var _token = $('meta[name="_token"]').attr('content');

           $('#add_submit').click(function(e){
               e.preventDefault();
               
               $.ajaxSetup({
                        headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                             }
                          });
            
               $.ajax({
                  url: "{{ route('produtofornecedor_estoque') }}",
                  method: 'POST',
                  dataType: "json",
                  data: {
                      id_produto: $("#id_produto").val(),
                      adicionar_estoque: $("#adicionar_estoque").val()
          
                  }, 
                  success: function(result){
                    console.log(result)

                    if(result.error == '0'){
                      alert('Você tentou adicionar ao estoque um valor menor que o valor mínimo requirido.') 
                    } else if(result.error == '1'){
                        alert('O Estoque mínimo da loja para este produto não foi alcançado com o valor que você tentou adicionar.')  
                    } else{
                      alert('Estoque alterado com sucesso!')
                       $("#addEstoqueModal").modal('toggle')
                       location.reload();
                    }                            
                    

                     
                  },
                  error: function(result){      
                  console.log(result)             
                    alert(result)
                    
                  }
                })
               });

            /* END AJAX*/



  }); // final document ready


 

</script>


<!-- MODAL ADD ESTOQUE -->

<div class="modal fade" id="addEstoqueModal" tabindex="-1" role="dialog" aria-labelledby="titulo_fornecedor_produto" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo_fornecedor_produto">Adicionar estoque de entrada</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     <form  method="POST">
       <label>Digite o valor desejado: </label>
       <input type="text" name="adicionar_estoque" class='form-control' id='adicionar_estoque'>
       <input type="hidden" name="id_produto" id='id_produto' value="">
     </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button id='add_submit' type="button" class="btn btn-primary">Adicionar</button>
      </div>
    </div>
  </div>
</div>


<!-- END MODAL ADD ESTOQUE -->






<!-- MODAL EDIT -->

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editarproduto_fornecedor" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarproduto_fornecedor">Editar produto</h5>
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




@endsection