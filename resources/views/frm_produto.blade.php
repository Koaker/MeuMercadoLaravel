@extends('layouts.app')


@section('content')
<head>
  <title> Cadastro de produto </title>
   <meta name="csrf-token" content="{{ csrf_token()}}">
</head>

<body>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 offset-md-4 mt-5">
                    <div class="card border">
                        <div class="card-header">
                           <div class="card-title">
                           Cadastrar produto
                            </div>
                        </div>

                        <div class="card-body">
                            
                            <form action="/salvarProduto" method="POST">
                            @csrf
                            @include('forms/produto')
                            
                                <button type="submit" class="btn btn-success btn-sm"> Cadastrar </button>
                               
                                 
                           
                            </form>
                            <hr>
                             <a href="{{ route('home') }}"><button type="cancel" class="btn btn-danger btn-sm"> Cancelar </button> </a>
                        </div>
                          
                    </div>                    
                </div>
            </div>
        </div>
    </main>


</body>

<script> 

$('#produto_valor').mask('000.000.000.000.000,00', {reverse: true});
$('#produto_estoque').mask('0000000000000' , {reverse: true});
$('#produto_estoque_minimo').mask('0000000000000' , {reverse: true});

</script>
@endsection
