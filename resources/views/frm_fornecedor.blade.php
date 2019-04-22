@extends('layouts.app')


@section('content')
<head>
  <title> Cadastro de fornecedor </title>
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
                           Cadastrar fornecedor
                            </div>
                        </div>

                        <div class="card-body">
                            
                            <form action="{{ route('fornecedor_salvar') }}" method="POST">
                             @csrf       
                            @include('forms/fornecedor')
                            
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

    @if(isset($errors))
        {{ var_dump($errors) }}
    @endif


</body>

<script> 
$('#fornecedor_cnpj').mask('00.000.000/0000-00', {reverse: true});

</script>
@endsection
