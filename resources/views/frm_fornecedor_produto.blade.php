@extends('layouts.app')


@section('content')
<head>
  <title> Cadastro de fornecedor ao produto</title>
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
                           Cadastro de fornecedor ao produto
                            </div>
                        </div>

                        <div class="card-body">
                           
                            <form action="{{ route('produtofornecedor_salvar') }}" method="POST">
                            @csrf
                            @include('forms/produto_fornecedor')
                            
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


</script>
@endsection
