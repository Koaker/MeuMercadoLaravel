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
                                <div class='row'>
                                  @can('isAdmin') 
                                  <div class='col-md-5'>
                                       <a href="{{route('produto_cadastro')}}"><button class="btn btn-success">Adicionar Produto</button></a>
                                  </div>
                                 @endcan
                                </div>
                            
                            <div class="row"> 
                                <div class="col-md-12">

                                <div class="form-group">

                                  <label for="pesquisa_produto">Pesquisar por: </label>
                                 
                                  <select id="select_pesquisa" class="form-control" style="width: 20%;">
                                    <option value='1' selected>Nome</option>
                                    <option value='2'>Tipo</option>
                                  </select>                                       
                                  
                                </div>

                                <div class="form-group" style="width: 40%;">      

                                  <input type="text" id="pesquisa_produto" class="form-control" placeholder="Pesquise aqui">

                                </div>
                                
                            
                              
                              </div>
                                  
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
                                    <th> Estoque de Entrada total</th>
                                    <th> Estoque Loja </th>
                                    <th> Estoque Mínimo </th>
                                    <th> Editar </th>                                   
                                    <th> Inativar </th>
                                    <th> Excluir </th>
                                </thead>
                                
                                <tbody>
                                    @foreach($produto as $p)
                                   
                                    <tr>

                                        <td >{{$p->id}}</td>
                                        <td class='td_nome_produto'>{{$p->nome}}</td>
                                        <td class='td_tipo_produto'>{{$p->tipo}}</td>
                                        <td>{{$p->valor}}</td>       
                                        <td>{{$p->vendas}}</td>
                                        <td>{{$p->estoque_entrada}}</td>
                                        <td>{{$p->estoque}}</td>
                                        <td>{{$p->estoque_minimo}}</td>
                                       
                                      
                                         
                                         @can('isAdmin')  
                                           <td><button class="btn btn-primary shadow-sm" data-id='{{$p->id}}' data-estoque='{{$p->estoque}}' data-stoker='{{$p->estoque_minimo}}' data-valor="{{$p->valor}}" data-tipo="{{$p->tipo}}" data-nome="{{$p->nome}}" data-toggle="modal" data-target="#editModal"  data-keyboard="false"> Editar </button></td> 
                                             @if($p->ativo == 1)
                                             <td><a href="{{ route('produto_status', $p->id) }}"> <button class="btn btn-danger" value='{{$p->id}}'> Inativar </button> </a></td>                             
                                             @else
                                              <td><a href="{{ route('produto_status', $p->id)  }}"> <button class="btn btn-success" > Ativar </button> </a></td> 
                                                                                         
                                             @endif    
                                             <td><button class="btn btn-danger dlt_produto" value='{{$p->id}}'  > Excluir  </button></td>                                            
                                        @endcan


                                         @can('isVendedor') 
                                         <td><button class="btn btn-primary shadow-sm" disabled=""> Editar </button></td> 
                                            @if($p->ativo == 1)
                                               <td><button class="btn btn-danger" disabled > Inativar </button></td>
                                                     
                                             @else

                                               </tr> <td><button class="btn btn-success" disabled > Ativar </button></td>
                                              
                                             @endif  
                                        <td><button class="btn btn-danger" disabled > Excluir  </button></td
>                                         @endcan
                                   
                                      
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

<!-- Scripts -->


<script>

      /* ~ PESQUISA */

      $("#select_pesquisa").change(function(){
        
        var value = $('#pesquisa_produto').val().toLowerCase()
        if($('#select_pesquisa').val() == 1 ){         

          $("#tabela_produtos tbody").find('.td_nome_produto').filter(function() {
            $(this).parents('tr').toggle($(this).text().toLowerCase().indexOf(value) > -1)   
          });

        } else{
           $("#tabela_produtos tbody").find('.td_tipo_produto').filter(function() {
            $(this).parents('tr').toggle($(this).text().toLowerCase().indexOf(value) > -1)    

          });

        }

      });

     $("#pesquisa_produto").on("keyup", function() {    
      var value = $(this).val().toLowerCase()
      if($('#select_pesquisa').val() == 1){
          $("#tabela_produtos tbody").find('.td_nome_produto').filter(function() {
            $(this).parents('tr').toggle($(this).text().toLowerCase().indexOf(value) > -1)    

          });

      } else{

         $("#tabela_produtos tbody").find('.td_tipo_produto').filter(function() {

            $(this).parents('tr').toggle($(this).text().toLowerCase().indexOf(value) > -1)    

          });

      }       
  
  });

  /* ~ FINAL PESQUISA */

  /* AJAX */

  var _token = $('meta[name="_token"]').attr('content');

           $('#edt_submit').click(function(e){
               e.preventDefault();
               
               $.ajaxSetup({
                        headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                             }
                          });
            
               $.ajax({
                  url: "{{ route('produto_editar') }}",
                  method: 'POST',
                  data: {
                      id_produto: $("#id_produto").val(),
                      produto_nome:  $('#produto_nome').val(),
                      produto_tipo: $('#produto_tipo').val() ,
                      produto_valor: $('#produto_valor').val() ,
                      produto_estoque_minimo:  $('#produto_estoque_minimo').val(),
                      produto_estoque:  $('#produto_estoque').val()
                  }, 
                  success: function(result){
                     alert('Produto alterado com sucesso!')                    
                     $("#editModal").modal('toggle')
                      location.reload();

                     
                  },
                  error: function(result){
                    var erou = "";
                    $.each(result.responseJSON.errors, function(key,val){
                        erou = erou + '\n' + val
                    })     
                    alert(erou)
                    
                  }
                });
               });







 $('.dlt_produto').click(function(){

          var r = confirm("Esta ação irá deletar todo o histórico do produto. Você realmente deseja excluir este produto?");

          if (r == true) {
           

               $.ajaxSetup({
                        headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                             }
                          });
            
               $.ajax({
                  url: "{{ route('produto_deletar') }}",
                  method: 'POST',     
                  data: {
                    id: $(this).val()
                  },           
                  success: function(result){
                    alert('Produto excluído com sucesso!')     
                    location.reload();                 
                  }
                });

            }
               
               });
    


  /* FINAL AJAX */

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

// MASK
$('#produto_valor').mask('000.000.000.000.000,00', {reverse: true});
$('#produto_estoque').mask('0000000000000' , {reverse: true});
$('#produto_estoque_minimo').mask('0000000000000' , {reverse: true});
//  FINAL MASK

</script>

@endsection


<!-- MODALS -->


<!-- MODAL EDIT -->

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="titulo_produto" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo_produto">Editar produto</h5>

        <button type="button"  data-dismiss="modal" class="close"  aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  method="POST" id='frm_edt'>
          
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

       
          
        </form>
         <button id='edt_submit' class="btn btn-primary">Salvar alterações</button>
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>
<!-- END MODAL EDIT -->



<!-- END MODALS -->