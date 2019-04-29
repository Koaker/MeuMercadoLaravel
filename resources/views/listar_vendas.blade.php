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
                           Lista de produtos para venda
                            </div>


                            <div class="row"> 
                                <div class="col-md-12">


                                <div class="form-group">

                                  <label for="select_pesquisa2">ordenar por: </label>
                                 
                                  <select id="select_pesquisa2" class="form-control" style="width: 20%;">
                                    <option value='1' selected>Mais vendidos</option>   
                                    <option value='2' >Menos vendidos</option>  
                                    <option value='3' >Estoque positivo</option>   
                                    <option value='4' >Estoque negativo</option>   
                                    <option value='5' >Estoque zerado</option>
                                    <option value='6'> Todos </option>                                 
                                  </select>                                       
                                  
                                </div>

                                <div class="form-group" style="width: 40%;">      

                                  <input type="text" id="pesquisa_vendas" class="form-control" placeholder="Pesquise aqui">

                                </div>
                                
                            
                              
                              </div>
                                  
                          </div>  
                        </div>

                        <div class="card-body">
                         
                            <table class="table table-bordered table-hover table-striped" id="tabela_venda">
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
                                        <td class="td_nome">{{$p->nome}}</td>
                                        <td>{{$p->tipo}}</td>
                                        <td>{{$p->valor}}</td>       
                                        <td class="td_vendas">{{$p->vendas}}</td>
                                        <td class="td_estoque">{{$p->estoque}}</td>
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
          <div class="form-group">
             <label for="venda_quantidade_cancelada"> Quantidade: </label>
             <input type="text" id="venda_quantidade_cancelada" class="form-control" name="venda_quantidade_cancelada" placeholder="Digite a quantidade de vendas que serão canceladas">
          </div>
          <input type="hidden" id='id_produto_venda' name="id_produto_venda" value=""> 
             <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button id="submit_cancelar" type="submit" class="btn btn-primary">Cancelar venda</button>
      </div>
                   
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
   
$(document).ready(function(){

function sortTable(table, order) {
  console.log('oi')
    var asc   = order === 'asc',
        tbody = table.find('tbody');
        $("#tabela_venda tbody tr").show()
    tbody.find('tr').sort(function(a, b) {
        if (asc) {
            return $('.td_vendas', a).text().localeCompare($('.td_vendas', b).text());
        } else {
            return $('.td_vendas', b).text().localeCompare($('.td_vendas', a).text());
        }
    }).appendTo(tbody);
}


             



        /* ~ PESQUISA */

        $("#select_pesquisa2").change(function(){
          $("#tabela_venda").children().removeClass('ativo')
          
          var valor_select = $('#select_pesquisa2').val()

          if( valor_select == 1 ){             
          sortTable($('#tabela_venda'),'desc') 


           } else if(valor_select == 2){
            sortTable($('#tabela_venda'),'asc');
             ;

          } else if(valor_select == 3){
               $("#tabela_venda tbody").find('.td_estoque').filter(function() {
              $(this).parents('tr').toggle($(this).text().toLowerCase() > 0 )    

            });

            } else if(valor_select == 4){
                 $("#tabela_venda tbody").find('.td_estoque').filter(function() {
              $(this).parents('tr').toggle($(this).text().toLowerCase() < 0 )    

            });

            } else if(valor_select == 5){
                 $("#tabela_venda tbody").find('.td_estoque').filter(function() {
                 $(this).parents('tr').addClass('ativo');
                $(this).parents('tr').toggle($(this).text().toLowerCase() == 0 )    

            });

            } else if(valor_select == 6){
              location.reload();
            }

        });

       $("#pesquisa_vendas").on("keyup", function() {  
      
        var value = $(this).val().toLowerCase()
       
            $("#tabela_venda tbody").find('.td_nome').filter(function() {
              $(this).parents('tr').toggle($(this).text().toLowerCase().indexOf(value) > -1)    

            });
     
    
    });

     /* ~ FINAL PESQUISA */

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
  modal.find('.modal-body #id_produto_venda').val(id)


})

 $('#submit_cancelar').click(function(e){
               e.preventDefault();
               
               $.ajaxSetup({
                        headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                             }
                          });
            
               $.ajax({
                  url: "{{ route('venda_cancelar') }}",
                  method: 'POST',
                  dataType: "json",
                  data: {
                      id: $("#id_produto_venda").val(),
                      quantidade: $("#venda_quantidade_cancelada").val()
                      },
                  success: function(result){
                    console.log(result)

                    if(result.error == '0'){
                      alert('A Quantidade de venda que você esta tentando cancelar, é maior que o total de vendas registradas'); 
                    } 

                    if(result.error == '1'){
                      alert('A quantidade é obrigatória'); 
                    } 
                    
                    if(result.sucesso == '1'){
                      alert('Venda cancelada com sucesso!')
                       $("#cancelarVenda").modal('toggle')
                       location.reload();
                    } 
                     
                  },
                  error: function(result){      
                  console.log(result)             
                    alert(result)
                    
                  }
                })
             })     

   })



$('#venda_quantidade_cancelada').mask('0000000000000' , {reverse: true});
$('#venda_quantidade').mask('0000000000000' , {reverse: true});




</script>

@endsection
