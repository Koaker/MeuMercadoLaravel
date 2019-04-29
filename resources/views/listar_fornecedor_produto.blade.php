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

                                  <label for="select_pesquisa2">Pesquisar por: </label>
                                 
                                  <select id="select_pesquisa2" class="form-control" style="width: 20%;">
                                    <option value='1' selected>Nome</option>   
                                    <option value='2' >Fornecedor</option>                                 
                                  </select>                                       
                                  
                                </div>

                                <div class="form-group" style="width: 40%;">      

                                  <input type="text" id="pesquisa_pf" class="form-control" placeholder="Pesquise aqui">

                                </div>
                                
                            
                              
                              </div>
                                  
                          </div>    
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered table-hover" id="tabela_pf">
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
                                        <td class="td_nome_produto">{{$p->p_nome}}</td>
                                        <td class="td_nome_fornecedor">{{$p->f_nome}}</td>
                                        <td>{{$p->estoque_minimo}}</td>
                                        <td>{{$p->estoque_entrada}}</td>
                                        <td>{{$p->estoque}}</td>
                                         <td>{{$p->p_minim}}</td>                                        
                                                                        
                                        <td><button class="btn btn-primary shadow-sm" data-id='{{$p->id}}' data-produto='{{ $p->produto_id }}' data-fornecedor='{{$p->fornecedor_id}}'  data-min='{{$p->estoque_minimo}}' data-target='#editPF' data-toggle="modal" data-keyboard="false">Editar</button></td>  
                                        @can('isAdmin')                                     
                                         <td>
                                          <button class="btn btn-success" data-target='#addEstoqueModal' data-id='{{$p->id}}'data-toggle="modal" data-keyboard="false" > 
                                          Adicionar estoque entrada 
                                          </button>
                                        </td>
                                        <td><button class="btn btn-danger dlt_produto" value="{{$p->id}}" > Excluir </button></td>
                                        @endcan

                                         @can('isVendedor')                                     
                                        <td>
                                          <button class="btn btn-success" data-target='#addEstoqueModal' data-id='{{$p->id}}' data-toggle="modal" data-keyboard="false" > 
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

<!-- Scripts -->


<script>

 

  $(document).ready(function(){

        /* ~ PESQUISA */

        $("#select_pesquisa2").change(function(){
          console.log('entrou change')
          var value = $('#pesquisa_pf').val().toLowerCase()
          if($('#select_pesquisa2').val() == 1 ){         

            $("#tabela_pf tbody").find('.td_nome_produto').filter(function() {
              $(this).parents('tr').toggle($(this).text().toLowerCase().indexOf(value) > -1)   
            });

          } else{
             $("#tabela_pf tbody").find('.td_nome_fornecedor').filter(function() {
              $(this).parents('tr').toggle($(this).text().toLowerCase().indexOf(value) > -1)    

            });

          }

        });

       $("#pesquisa_pf").on("keyup", function() {  
       console.log('entrou keyup')  
        var value = $(this).val().toLowerCase()
        if($('#select_pesquisa2').val() == 1){
            $("#tabela_pf tbody").find('.td_nome_produto').filter(function() {
              $(this).parents('tr').toggle($(this).text().toLowerCase().indexOf(value) > -1)    

            });

        } else{

           $("#tabela_pf tbody").find('.td_nome_fornecedor').filter(function() {

              $(this).parents('tr').toggle($(this).text().toLowerCase().indexOf(value) > -1)    

            });

        }       
    
    });

     /* ~ FINAL PESQUISA */

    $('#pf_estoque_minimo').mask('0000000000000' , {reverse: true});
  $('#editPF').on('show.bs.modal', function (event) {  

  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') 
  var produto = button.data('produto') 
  var fornecedor = button.data('fornecedor') 
  var min = button.data('min') 
    
  var modal = $(this)  
  modal.find('.modal-title').text('Edição produto x fornecedor')
  modal.find('.modal-body #pf_fornecedor').val(fornecedor)
  modal.find('.modal-body #pf_produto').val(produto)
  modal.find('.modal-body #pf_estoque_minimo').val(min)
  modal.find('.modal-body #id_produto_edt').val(id)
})

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
              

            $('#send_edit').click(function(e){
               e.preventDefault();
               
               $.ajaxSetup({
                        headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                             }
                          });
            
               $.ajax({
                  url: "{{ route('produtofornecedor_editar') }}",
                  method: 'POST',
                  dataType: "json",
                  data: {
                      id: $("#id_produto_edt").val(),
                      fornecedor: $("#pf_fornecedor").val(),
                      produto: $("#pf_produto").val(),
                      min: $("#pf_estoque_minimo").val()
          
                  }, 
                  success: function(result){
                    console.log(result)

                    if(result.error == '0'){
                      alert('Já existe uma assosiação para este produto e este forencedor') 
                    } 
                    
                    if(result.sucesso == '1'){
                      alert('Dados alterados com sucesso!')
                       $("#editPF").modal('toggle')
                       location.reload();
                    }                            
                    

                     
                  },
                  error: function(result){      
                  console.log(result)             
                    alert(result)
                    
                  }
                })
               });





 $('.dlt_produto').click(function(){

          var r = confirm("Dados poderão ser perdidos com esta ação. Você realmente deseja excluir esta assosiação? ");

          if (r == true) {
           

               $.ajaxSetup({
                        headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                             }
                          });
            
               $.ajax({
                  url: "{{ route('produtofornecedor_dlt') }}",
                  method: 'GET',     
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

<div class="modal fade" id="editPF" tabindex="-1" role="dialog" aria-labelledby="editarproduto_fornecedor" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarproduto_fornecedor">Editar produto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           
        <div class="form-group">


    <label for="pf_fornecedor"> Fornecedor:  </label>

    <select class="form-control  {{$errors->has('pf_fornecedor') ? 'is-invalid' : '' }}" id='pf_fornecedor' name='pf_fornecedor' value="{{ old('pf_fornecedor') }}">
        <option hidden selected disabled>Selecine o fornecedor</option>
        @foreach ($fornecedores_select as $fornecedor)
        @if($fornecedor->ativo != 0)
          <option value='{{$fornecedor->id}}'>{{$fornecedor->nome.' CNPJ:'. $fornecedor->cnpj }}</option>
        @endif

        @endforeach
    </select>

       @if($errors->has('pf_fornecedor'))
        <div class='invalid-feedback'>
        
            {{$errors->first('pf_fornecedor')}}
        </div>
    @endif

</div>


<div class="form-group">
    <label for="pf_produto"> Produto:  </label>

    <select class="form-control {{$errors->has('pf_produto') ? 'is-invalid' : '' }}" id='pf_produto' name='pf_produto' value="{{ old('pf_produto') }}">
        <option hidden selected disabled>Selecine o produto</option>
        @foreach ($produtos_select as $produto)
          @if($produto->ativo != 0)
             <option value='{{$produto->id}}'>{{$produto->nome }}</option>
          @endif 
       
        @endforeach
    </select>


     @if($errors->has('pf_produto'))
        <div class='invalid-feedback'>
            {{$errors->first('pf_produto')}}
        </div>
    @endif

</div>

<div class="form-group">
    <label for="pf_estoque_minimo"> Estoque mínimo:  </label>
    <input type="text" id="pf_estoque_minimo" class="form-control {{$errors->has('pf_estoque_minimo') ? 'is-invalid' : ''}}" name="pf_estoque_minimo" placeholder="estoque mínimo a se adquirir" value="{{ old('pf_estoque_minimo') }}">

     @if($errors->has('pf_estoque_minimo'))
        <div class='invalid-feedback'>
            {{$errors->first('pf_estoque_minimo')}}
        </div>
    @endif
</div>

        <input type="hidden" name="id_produto_edt" id='id_produto_edt' value="">
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button id="send_edit" type="button" class="btn btn-primary">Salvar alterações</button>
      </div>
    </div>
  </div>
</div>
<!-- END MODAL EDIT -->




@endsection