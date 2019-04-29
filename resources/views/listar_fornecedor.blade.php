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


                               <div class='row'>
                                  @can('isAdmin') 
                                  <div class='col-md-5'>
                                       <a href="{{route('fornecedor_cadastro')}}"><button class="btn btn-success">Adicionar Fornecedor</button></a>
                                  </div>
                                 @endcan
                                </div>



                            <div class="row"> 
                                <div class="col-md-12">


                                <div class="form-group">

                                  <label for="pesquisa_fornecedor">Pesquisar por: </label>
                                 
                                  <select id="select_pesquisa" class="form-control" style="width: 20%;">
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
                            <table class="table table-bordered table-hover" id="tabela_fornecedor">
                                <thead>
                                    <th> Código  </th>
                                    <th> Nome    </th>
                                    <th> CNPJ    </th>
                                    <th> Endereço  </th>
                                    <th> Email</th>
                                    <th> Estado </th> 
                                    <th> Editar </th>                                   
                                    <th> Inativar </th>                                  

                                </thead>
                                
                                <tbody>
                                    @foreach($fornecedores as $p)
                                    <tr>
                                        <td>{{$p->id}}</td>
                                        <td class="td_nome_fornecedor">{{$p->nome}}</td>
                                        <td>{{$p->cnpj}}</td>
                                        <td>{{$p->endereco}}</td>
                                        <td>{{$p->email}}</td>
                                        <td>{{$p->estado}}</td>
                                                                        
                                        <td><button class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#editModalFornecedor" data-id='{{$p->id}}' data-cnpj='{{$p->cnpj}}' data-endereco='{{$p->endereco}}' data-email="{{$p->email}}" data-estado="{{$p->estado}}" data-nome="{{$p->nome}}" data-keyboard="false"> Editar </button></td> @can('isAdmin')                                     
                                        @if($p->ativo == 1)
                                             <td><a href="{{ route('fornecedor_status', $p->id) }}"> <button class="btn btn-danger" value='{{$p->id}}'> Inativar </button> </a></td>                
                                             @else
                                              <td><a href="{{ route('fornecedor_status', $p->id)  }}"> <button class="btn btn-success" > Ativar </button> </a></td>
                                        @endif
                                        @endcan

                                        @can('isVendedor')
                                         @if($p->ativo == 1)
                                             <td> <button class="btn btn-danger" value='{{$p->id}}' disabled=""> Inativar </button> </td>                
                                             @else
                                              <td> <button class="btn btn-success" disabled > Ativar </button> </td>
                                        @endif
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

      /* MASK */

$('#fornecedor_cnpj').mask('00.000.000/0000-00', {reverse: true});
      /* MASKS */

      /* ~ PESQUISA */

      $("#select_pesquisa").change(function(){
        
        var value = $('#pesquisa_fornecedor').val().toLowerCase()
        if($('#select_pesquisa').val() == 1 ){         

          $("#tabela_fornecedor tbody").find('.td_nome_fornecedor').filter(function() {
            $(this).parents('tr').toggle($(this).text().toLowerCase().indexOf(value) > -1)   
          });

        } else{
           $("#tabela_fornecedor tbody").find('.td_tipo_produto').filter(function() {
            $(this).parents('tr').toggle($(this).text().toLowerCase().indexOf(value) > -1)    

          });

        }

      });

     $("#pesquisa_fornecedor").on("keyup", function() {    
      var value = $(this).val().toLowerCase()
      if($('#select_pesquisa').val() == 1){
          $("#tabela_fornecedor tbody").find('.td_nome_fornecedor').filter(function() {
            $(this).parents('tr').toggle($(this).text().toLowerCase().indexOf(value) > -1)    

          });

      } else{

         $("#tabela_fornecedor tbody").find('.td_tipo_produto').filter(function() {

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
                  url: "{{ route('fornecedor_editar') }}",
                  method: 'POST',
                  data: {
                      id_fornecedor: $("#id_fornecedor").val(),
                      fornecedor_nome:  $('#fornecedor_nome').val(),
                      fornecedor_cnpj: $('#fornecedor_cnpj').val() ,
                      fornecedor_endereco: $('#fornecedor_endereco').val() ,
                      fornecedor_estado:  $('#fornecedor_estado').val(),
                      fornecedor_email:  $('#fornecedor_email').val()
                  }, 
                  success: function(result){
                     alert('Fornecedor alterado com sucesso!')                    
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


$('#editModalFornecedor').on('show.bs.modal', function (event) {

  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') 
  var nome = button.data('nome') 
  var cnpj = button.data('cnpj') 
  var endereco = button.data('endereco') 
  var email = button.data('email')
  var estado = button.data('estado')


  $.getJSON( "https://api.myjson.com/bins/786c4", function( data ) {
     console.log(data)
      
      var estados = [];
      
      estados.push("<option selected disabled hidden> Selecione um estado </option>") 

          $.each( data.UF, function( key, val ) {        
            
            estados.push( "<option value='" + data.UF[key].sigla + "'>" +  data.UF[key].sigla  + "</option>" );
          });        

           $('#fornecedor_estado').append(estados)
         
          $('#fornecedor_estado').val(estado);
           
          
         
  });      id_fornecedor
    

    
  var modal = $(this)  

  modal.find('.modal-title').text('Editando o fornecedor: ' + nome)
  modal.find('.modal-body #fornecedor_nome').val(nome)
  modal.find('.modal-body #fornecedor_cnpj').val(cnpj)
  modal.find('.modal-body #fornecedor_endereco').val(endereco)
  modal.find('.modal-body #fornecedor_email').val(email)
  modal.find('.modal-body #fornecedor_estado').val(estado)
  modal.find('.modal-body #id_fornecedor').val(id)

})
 }) // final document ready

</script>







<!-- MODAL EDIT -->

<<div class="modal fade" id="editModalFornecedor" tabindex="-1" role="dialog" aria-labelledby="titulo_fornecedor" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo_fornecedor">Editar fornecedor</h5>

        <button type="button"  data-dismiss="modal" class="close"  aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  method="POST" id='frm_edt'>
          
          @include('forms/fornecedor')     
           <input type="hidden" name="id_fornecedor" id='id_fornecedor' value="">
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

@endsection